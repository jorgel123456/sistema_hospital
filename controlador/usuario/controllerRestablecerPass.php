<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


require "../../modelo/modelUsuario.php";

$MU=new modelUsuario();
$correo=htmlspecialchars($_POST["correo"],ENT_QUOTES,'UTF-8');
$correoactual=htmlspecialchars($_POST["pass"],ENT_QUOTES,'UTF-8');
$contrasena=password_hash($_POST["pass"],PASSWORD_DEFAULT,['cost'=>10]);

$consulta=$MU->restablecerPass($correo,$contrasena);

if($consulta =="1"){
  
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );
        //Server settings
        //$mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'malustore90@gmail.com';                     //SMTP username
        $mail->Password   = 'cmcqmiuxqwtadekv';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('malustore90@gmail.com', 'MaluStore');
        $mail->addAddress($correo);     //Add a recipient
 
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Restablecer Password';
        $mail->Body    = 'Su contraseña fue restablecida <br> Nueva Contraseña : <b>'.$correoactual.'</b>';

        $mail->send();
        echo '1';
    } catch (Exception $e) {
        echo "0";
    }

}else{
    echo '2';
}



?>