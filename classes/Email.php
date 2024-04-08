<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    
    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre,$email,$token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Configurando SMTP
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        
        //Configurar Estructura del Email
        $mail->setFrom('admin@appsalon.com');
        $mail->addAddress('dev@maya.com','Maya Importaciones MEX');
        $mail->Subject = 'CONFIRMAR CUENTA';

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //Contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has creado tu cuenta en AppSalon, Solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<a href='".$_ENV['APP_URL']."/confirmar-cuenta?token=" . $this->token ."'>Confirma Aqui</a>";
        $contenido .= "</html>";

        //Agregar el Contenido al Body
        $mail->Body = $contenido;
        $mail->AltBody = 'Correo de Confirmacion de Cuenta';

        //Enviar
        $mail->send();
        header('Location: /mensaje');
    }

    public function enviarInstrucciones(){
        //Configurando SMTP
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        
        //Configurar Estructura del Email
        $mail->setFrom('admin@appsalon.com');
        $mail->addAddress('dev@maya.com','Maya Importaciones MEX');
        $mail->Subject = 'REESTABLECER PASSWORD';

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //Contenido
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has solicitado reestablecer la contraseña tu cuenta en AppSalon, Solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<a href='" .$_ENV['APP_URL']."/recuperar?token=" . $this->token ."'>Reestablece Aqui</a>";
        $contenido .= "</html>";
        
        //Agregar el Contenido al Body
        $mail->Body = $contenido;
        $mail->AltBody = 'Correo para Reestablecer Password';

        //Enviar
        $mail->send();
        header('Location: /mensaje');
    }


    
}