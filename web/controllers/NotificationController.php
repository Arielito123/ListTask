<?php
class NotificationController {
    public function notification() {
        $verifyState = TaskModel::selectTask();

        foreach ($verifyState as $value) {
            $email = $value['mail_user'];
            $name = $value['name'];
            $last_name = $value['last_name'];
            $name_task = $value['name_task'];
            $reminder_date = $value['reminder_date'];
          
            // Solo si el email es válido, intentamos enviar
            if (!empty($email)) {
                $bcc_emails = [];
                $sent = MailerController::notificationEmail($email, $name, $last_name, $name_task, $reminder_date, $bcc_emails);

                if ($sent) {
                    TaskModel::updateNotificationState($value['id_task']); // 🔹 Marcamos la tarea como enviada
                } else {
                    error_log("Error al enviar email a: $email");
                }
            }
        }

        // 🔹 Redirección al final del proceso, no dentro del bucle
        header("Location: index.php?pages=manageTasks&subfolder=unassignedTask&notification=correcto");
        exit();
    }
}
