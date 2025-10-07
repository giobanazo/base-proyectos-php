<?php 
    namespace Classes;

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    
    class Email {
        public $email;
        public $nombre;
        public $token;

        public function __construct($nombre, $email, $token){
            $this->email = $email;
            $this->nombre = $nombre;
            $this->token = $token;
        }

        public function enviarConfirmacion() {
            // Crear el objeto de email
            $mail = new PHPMailer();
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $_ENV['EMAIL_HOST'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $_ENV['EMAIL_USER'];                 //SMTP username
            $mail->Password   = $_ENV['EMAIL_PASS'];                                 //SMTP password
            $mail->SMTPSecure = 'tls'; // tls significa transport layer security 
            $mail->Port       = $_ENV['EMAIL_PORT'];                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            // Set HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has creado tu cuenta en App Salón, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aqui: <a href='{$_ENV['APP_URL']}/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a> </p>";
            $contenido .= "<p>Si tu no solicitastes este cambio, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;

            // Enviar el mail
            $mail->send();
        }   

        public function enviarInstrucciones() {
            // Crear el objeto de email
            $mail = new PHPMailer();
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $_ENV['EMAIL_HOST'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $_ENV['EMAIL_USER'];                 //SMTP username
            $mail->Password   = $_ENV['EMAIL_PASS'];                                 //SMTP password
            $mail->SMTPSecure = 'tls'; // tls significa transport layer security 
            $mail->Port       = $_ENV['EMAIL_PORT'];                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom('cuentas@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            // Set HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola ". $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para Hacerlo.</p>";
            $contenido .= "<p>Presiona aqui: <a href='{$_ENV['APP_URL']}/recuperar?token=" . $this->token . "'>Reestablecer Password</a> </p>";
            $contenido .= "<p>Si tu no solicitastes este cambio, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";
            $mail->Body = $contenido;

            // Enviar el mail
            $mail->send(); //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        }
    }

?>