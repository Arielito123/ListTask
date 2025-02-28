<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerController
{
    static public function sendNewUser($email, $name, $last_name)
    {
        

        $credential = UserModel::getFirstValidCredential();
        if ($credential === false) {
            error_log("Error: No se pudo obtener la credencial.");
            return false;
        }
        
        if ($credential === null) {
            error_log("Error: No se encontró ninguna credencial.");
            return false;
        }
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host =$credential['host'];;
        $mail->SMTPAuth = true;
        $mail->Username = $credential['email'];
        $mail->Password = $credential['token'];
        $mail->SMTPSecure =$credential['certificatedSSL'];;
        $mail->Port =$credential['port_email'];

        $mail->setFrom($credential['email'], 'Listify');
        $mail->addAddress($email, 'Usuario');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "¡ya te has registrado correctamente gracias por confiar en nosotros!";

        $htmlFile = 'views/html/welcome.html';


        $htmlContent = file_get_contents($htmlFile);
        $htmlContent = str_replace('{{name}}', $name, $htmlContent);
        $htmlContent = str_replace('{{last_name}}', $last_name, $htmlContent);
        $htmlContent = str_replace('{{email}}', $email, $htmlContent);
        $mail->Body = $htmlContent;
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    static public function notificationEmail($email, $name, $last_name, $name_task, $reminder_date, $bcc_emails = [])
{
    $credential = UserModel::getFirstValidCredential();
    if ($credential === false || $credential === null) {
        error_log("Error: No se pudo obtener la credencial.");
        return false;
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

    // 📌 Agregar BCC sin foreach aquí (si hay correos en el array)
    foreach ($bcc_emails as $bcc) {
        $mail->addBCC($bcc);
    }

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "¡Recordatorio de tarea!";

    $htmlFile = 'views/html/notification.html';
    $htmlContent = file_get_contents($htmlFile);
    $htmlContent = str_replace(['{{name}}', '{{last_name}}', '{{email}}', '{{task_name}}', '{{reminder_date}}'], 
                               [$name, $last_name, $email, $name_task, $reminder_date], 
                               $htmlContent);

    $mail->Body = $htmlContent;

    return $mail->send();
}

}


