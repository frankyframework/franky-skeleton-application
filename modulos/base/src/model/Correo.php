<?php
namespace Base\model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Correo extends \Franky\Core\configure
{
        public function Enviar($Asunto, $Direccion, $Texto, $from, $reply,$bcc,$cc)
      	{

              if(!file_exists($this->getServerUploadDir()."/core_config/core_config.php"))
                {
                  return false;
                }
              $config = include($this->getServerUploadDir()."/core_config/core_config.php");

              $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
              try {
                  //Server settings
                  $mail->SMTPDebug = $config['base/smtp/debug'];                                 // Enable verbose debug output
                  $mail->isSMTP();                                      // Set mailer to use SMTP
                  $mail->Host = $config['base/smtp/host'];  // Specify main and backup SMTP servers
                  $mail->SMTPAuth = $config['base/smtp/auth'];                               // Enable SMTP authentication
                  $mail->Username = $config['base/smtp/user'];                 // SMTP username
                  $mail->Password =  $config['base/smtp/password'];                           // SMTP password
                  $mail->SMTPSecure =  $config['base/smtp/secure'];                            // Enable TLS encryption, `ssl` also accepted
                  $mail->Port = $config['base/smtp/port'];                                    // TCP port to connect to

                  //Recipients

                  $mail->setFrom($from["email_from"], $from["name_from"]);
                  $mail->addAddress($Direccion);               // Name is optional
                  $mail->addReplyTo($reply, 'Information');


                  if(!empty($cc)){
                      foreach($cc as $_cc)
                      {
                        if(!empty($_cc))
                        {
                          $mail->addCC($_cc);
                        }

                      }

                  }
                  if(!empty($bcc)){
                      foreach($bcc as $_bcc)
                      {
                        if(!empty($_bcc))
                        {
                          $mail->addBCC($_bcc);
                        }

                      }

                  }

                  //Content
                  $mail->isHTML(true); // Set email format to HTML
                  $mail->Subject = $Asunto;
                  $mail->Body    = $Texto;
                  //$mail->AltBody = '';

                  $mail->send();
                  //echo 'Message has been sent';
              } catch (Exception $e) {
                //  echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
              }

      	}
}
?>
