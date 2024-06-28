<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class correoElectronico {

    public function enviarEmail($email, $asunto, $cuerpo) {
        require '../mailer/src/PHPMailer.php';
        require '../mailer/src/SMTP.php';
        require '../mailer/src/Exception.php';
        require_once './config.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                
            $mail->isSMTP();                          
            $mail->Host       = 'smtp.office365.com';                     
            $mail->SMTPAuth   = true;                            
            $mail->Username   = EMAIL; 
            $mail->Password   = PASSWORD;           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     
            $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(EMAIL, 'Tienda Itos');
            $mail->addAddress($email, 'Joe User');   

            //Content
            $mail->isHTML(true);                      
            $mail->Subject = $asunto;

            $mail->Body = utf8_decode($cuerpo);
            $mail->AltBody = 'Le enviamos los detalles de la compra';

            $mail->setLanguage('es', '../mailer/language/phpmailer.lang-es.php');

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo "Error al enviar el correo electronico: {$mail->ErrorInfo}";
        }
    }
}