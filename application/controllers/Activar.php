<?php
 header('Access-Control-Allow-Origin: *');

 

class Activar extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	 
    public function __construct() {
        parent::__construct();
    }

    public function activarUsuario()
    {

       $token= $_GET['token'];
       $this->load->model('login/Login_model', 'login');
       $token_valido = $this->login->verificar_token_activacion(array($token));
       if(!empty($token_valido)){
        $r_usuario = $this->login->activar_usuario(array($token));
          if($r_usuario){               
                $this->enviar_correo($token_valido[0]->vEmail);
                redirect($this->config->base_url().'Login?user=success');
                exit();
            }else{
                redirect($this->config->base_url().'Login?token=invalid');
                exit();
            }
       }else{
        redirect($this->config->base_url().'Login?token=invalid');
        exit();
       }
    }



    
   public function enviar_correo( $email)
   {

   //  $ip =  gethostbyname("smtp.gmail.com");

   $envio = FALSE;
   // Load PHPMailer library
   $this->load->library('phpmailer_lib');

   // PHPMailer object
   $mail = $this->phpmailer_lib->load();

   // SMTP configuration
   $mail->isSMTP();
   //$mail->Host     = 'smtp.gmail.com';
   $mail->Host     = "smtp.gmail.com";
  // $mail->SMTPKeepAlive = true;
   //$mail->SMTPAuth = false;
  // $mail->SMTPSecure = false;
  // $mail->SMTPAutoTLS = false;

  // $mail->SMTPDebug = 2;
   $mail->SMTPAuth = true;
   $mail->Username = 'mesadepartesvirtual@munitrujillo.gob.pe';
   $mail->Password = 'MuniTrujillo@2020';
   $mail->SMTPSecure = 'tls';
   $mail->Port     = 587;
   $mail->CharSet = 'UTF-8';
   //$mail->setFrom('mesadepartesvirtual@gmail.com', 'GS-MPT');
   $mail->From = 'mesadepartesvirtual@munitrujillo.com';
   $mail->FromName ='mesadepartesvirtual@munitrujillo.com';
   $mail->addReplyTo('mesadepartesvirtual@munitrujillo.com', 'GS-MPT');

   // Add a recipient
   $mail->addAddress($email);
  

   $mail->DKIM_domain = 'munitrujillo.gob.pe';
  // $mail->DKIM_private = 'E:/private.key';
   $mail->DKIM_selector = 'google';
   $mail->DKIM_passphrase = '';
   $mail->DKIM_identity = $mail->From;
   $mail->Encoding = "base64";

   // Add cc or bcc 
   //$mail->addCC('cc@example.com');
   //$mail->addBCC('bcc@example.com');

   // Email subject
   $mail->Subject = 'Activar usuario - Pagos MPT';

   // Set email format to HTML
   $mail->isHTML(true);




   // Email body content
   $mailContent = "<b>Pagos - MPT</b><br>
       <p>Su cuenta ha sido activada con éxito.</p>
       <p>Gracias,<br><i>Gerencia de Sistemas<br>Municipalidad Provincial de Trujillo<br>(044) 484-240</i></p>";
   $mail->Body = $mailContent;
  // $mail->AddAttachment("C:/SUBIDAS/17_05-13-2020_0136am.pdf","ssss");

   // Send email
   if (!$mail->send()) {
       /* echo 'Message could not be sent.';
       echo 'Mailer Error: ' . $mail->ErrorInfo;*/
   } else {
       /*echo 'Message has been sent';*/
       $envio = TRUE;
   }

   return $envio;
   }


}