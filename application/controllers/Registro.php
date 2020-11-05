<?php
 header('Access-Control-Allow-Origin: *');

 
require_once APPPATH . 'libraries/API_Controller.php';
class Registro extends API_Controller {

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


	public function index()
	{
		//$this->load->view('registro_view');
		  // API Configuration
          $this->_apiConfig([
            'methods' => ['GET'],
        ]);
		
	
			$this->load->view('registro_view');
		  }

   public function registrarUsuario(){
			// API Configuration
			$this->_apiConfig([
				'methods' => ['POST'],
			]);

			$claveCaptcha = '6LfNjMkZAAAAAAXnSntqT5QTJupQpYKUFsrmb72D';

			$this->load->library('form_validation');
			$this->form_validation->set_rules('emailaddress', 'correo electrónico', 'required|trim|valid_email');
			$this->form_validation->set_rules('nombres', 'nombres', 'required|trim');
			$this->form_validation->set_rules('apellidos', 'apellidos', 'required|trim');
			$this->form_validation->set_rules('pwd', 'contraseña', 'required|trim');
			$this->form_validation->set_rules('pwd_confirm', 'confirmación contraseña', 'required|trim|matches[pwd]');

					if ($this->form_validation->run() == false){
					$errors = array(
									'email_error'   => form_error('emailaddress'),
									'nombres_error'   => form_error('nombres'),
									'apellidos_error'   => form_error('apellidos'),
									'password_error'   => form_error('pwd'),
									'password_confirm_error'   => form_error('pwd_confirm')
					);
					$this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
					exit();
					}else{
						$r_captcha = $this->input->post('g-recaptcha-response');
						$captcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $claveCaptcha . '&response=' . $r_captcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']));
						if ($captcha->success != false) {
							$email = $this->input->post('emailaddress');
                            $this->load->model('login/Login_model', 'login');
							$r_usuario = $this->login->verificar_usuario_existe(array($email));
							if(!$r_usuario){
								$nombres = $this->input->post('nombres');
								$apellidos = $this->input->post('apellidos');
								$pwd = $this->input->post('pwd');
								$opciones = ['cost' => 12];
								$pwd_hash =password_hash($pwd, PASSWORD_BCRYPT, $opciones);
								$token = bin2hex(random_bytes(32));
								$r_usuario = $this->login->registra_nuevo_usuario(array($nombres,$apellidos,$email,$pwd_hash,$token));
								if($r_usuario){
								$url=  $url = $this->config->base_url().'activar?token=' .$token;	
									if($this->enviar_correo($url,$email,$nombres)){
										$this->api_return(
											[
												'status' => true ,
												'data'  => $this->config->base_url() .'Login?activate=email' 
											],
										200);
									}else{
										$msg = '<span id="spMsg">Error! Al parecer ha ocurrido un error, con el envio de correo.</span>'; 
										$this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg],200);
										exit();
									}
								}else{
									$msg = '<span id="spMsg">Error! Al parecer ha ocurrido un error, y no se ha registrado el usuario.</span>'; 
									$this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg],200);
									exit();
								}
							}else{
								$msg = '<span id="spMsg">Atención! el usuario <b>'.$email.'</b> ya se encuentra registrado.</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg],200);
                                exit();
							}
						} else{
							$msg = '<span id="spMsg">Error captcha! Por favor ingresa correctamente el captcha.</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_captcha' ,'data' => $msg],200);
                                exit();
						}           
					}

   }	
   
   

   public function enviar_correo($url, $email,$nombres)
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
    $mailContent = "Hola, ".$nombres."
        <b><p>Gracias por registrarse como usuario de inicio de sesión de Pagos - MPT.</p>
        <p>Para activar su cuenta y verificar su dirección de correo electrónico, haga clic en el botón de abajo:</p></b>
        <p> <a href='$url' target='_blank' style='background-color:#3f51b5;padding: 8px 12px; border: 1px solid #3f51b5;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;'>
        Activar Mi Cuenta             
		 </a></p>
		 <hr>
		 <p><b>Debe activar su cuenta dentro de los 7 días posteriores a la creación</b></p>
		 <p>Si ha recibido este correo electrónico por error, no necesita realizar ninguna acción para cancelar la cuenta. La cuenta no se activará y no recibirá ningún otro correo electrónico.</p>
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
