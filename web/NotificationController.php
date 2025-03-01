<?php
require 'vendor/autoload.php';
require 'config/MysqlDb.php';
require 'models/TaskModel.php';
require 'models/UserModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Argentina/Buenos_Aires');
$today = new DateTime();
$verifyState = TaskModel::selectTask();

foreach ($verifyState as $value) {
    $email = $value['mail_user'];
    $name = $value['name'];
    $last_name = $value['last_name'];
    $name_task = $value['name_task'];
    $reminder_date = $value['reminder_date'];
    
    
    $reminder_datetime = new DateTime($reminder_date);

    
    $today_no_seconds = $today->format('d-m-Y H:i'); 
    $reminder_no_seconds = $reminder_datetime->format('d-m-Y H:i'); 

    if ($reminder_no_seconds == $today_no_seconds) {

        if (!empty($email)) {
            $bcc_emails = [];

            
            $credential = UserModel::getFirstValidCredential();
            if ($credential === false || $credential === null) {
                error_log("Error: No se pudo obtener la credencial.");
                continue;
            }

          
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = $credential['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $credential['email'];
            $mail->Password = $credential['token'];
            $mail->SMTPSecure = $credential['certificatedSSL'];
            $mail->Port = $credential['port_email'];

            $mail->setFrom($credential['email'], 'Listify');
            $mail->addAddress($email, "$name $last_name");

           
            foreach ($bcc_emails as $bcc) {
                $mail->addBCC($bcc);
            }

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "¡Recordatorio de tarea!";

           
            $htmlFile = 'views/html/notification.html';
            $htmlContent = file_get_contents($htmlFile);
            $htmlContent = str_replace(['{{name}}', '{{last_name}}', '{{email}}', '{{task_name}}', '{{reminder_date}}'], 
                                       [$name, $last_name, $email, $name_task, $reminder_no_seconds], 
                                       $htmlContent);

            $mail->Body = $htmlContent;

           
            if ($mail->send()) {
              
                TaskModel::updateNotificationState($value['id_task']);
            } else {
               
                error_log("Error al enviar email a: $email");
            }
        }
    }
}

?>
