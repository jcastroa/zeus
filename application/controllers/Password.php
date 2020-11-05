<?php
 

 
require_once APPPATH . 'libraries/API_Controller.php';
class Password extends API_Controller {



	 
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

       
		
		 // Load Authorization Library or Load in autoload config file
		 $this->load->library('authorization_token');

		 // generate a token
		 $token = $this->authorization_token->validateTokenCookie();
		// print_r($token);die();
         if($token["status"] === true){
			ini_set("session.cookie_httponly", 1);
			ini_set("session.cookie_secure", 0);
			ini_set("session.cookie_path","/;SameSite=Strict");
		   
			session_start();
   
			if(empty($_SESSION['key'])){
			   $_SESSION['key'] = bin2hex(random_bytes(32));
			}
   
			$data['csrf'] = hash_hmac("sha256","DV9BigBsYDpRIKtTYnhAdpUKe_ovdsI6cIGAT00QH17Jku02QKdA3ThH6pdBAAKR3ux66MKpH7cWTaAKBShPvRoqJPE9EYWHFWTVELBNfmicZ6aIkHtEB89o-qirdnPeoTaLaiB3rPdZ2G8SU4tKLswx2BKB6-qRIDT52yfe9-6_ttChgwkzOYMdL4RQBpzDB5-4j6t9GKWOnT5s_uxjPFvlObHcVoORMD7Obca437R3zxEiZZXcR_Nn-E_azRHdXn_cr3KhrEf0zupBZsrWe8hsso9uTOKqvYUo-lL7W07tgerkH2xjqerlfE24ZLzvzrKIremgMWvC_KFt8LIglQ",$_SESSION['key']);
			$first_name = explode(" ", $token["data"]->nombres)[0];
			$first_last_name = explode(" ", $token["data"]->apellidos)[0];
            $data['names_user'] = ucfirst(strtolower($first_name)).' '.ucfirst(strtolower($first_last_name));  
			if(empty($_SESSION['csrf'])){
			   $_SESSION['csrf'] = $data['csrf'];
			}
       
            $this->template->load('default_layout', 'contents' , 'change_password_view', $data);
		 }else{
			setcookie ('PHPSESSID', "", time() - 3600,"/");
			setcookie ('jwt', "", time() - 3600,"/");
			session_destroy();
			session_write_close();
			redirect($this->config->base_url().'Login');
 exit();
		 }
		// print_r($token);die();
		// $this->load->view('registro_view');
	}



    public function changePassword(){
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        $this->load->library('authorization_token');
        $this->load->library('form_validation');
        $this->load->helper('cookie');
       
        //VERIFICO EL TOKEN CSRF
        
		$token = $this->authorization_token->tokenCsrfIsExist();
         if($token["status"] === true){
            session_start();
               //LIMPIO SESION Y COOKIES
            if(empty($_SESSION['csrf'])){
                setcookie ('PHPSESSID', "", time() - 3600,"/");
                setcookie ('jwt', "", time() - 3600,"/");
                session_destroy();
                session_write_close();
                $this->api_return(['status' => false  ,'tipo' => 'error_token' ],200);
                exit();
             }

			if(hash_equals($token['token-csrf'] ,$_SESSION['csrf'])){
                 //VERIFICO JWT SI ESTA AUTENTICADO
            $this->load->library('authorization_token');
            $token = $this->authorization_token->validateTokenCookie();
                if($token["status"] === true){ 
				  				
					$this->form_validation->set_rules('txtPasswordActual', 'contraseña actual', 'required|trim');
					$this->form_validation->set_rules('txtPassword', 'nueva contraseña', 'required|trim');
					$this->form_validation->set_rules('txtConfirmPassword', 'confirmar nueva contraseña', 'required|trim|matches[txtPassword]');

                            if ($this->form_validation->run() == false){
                            $errors = array(

											'contraseña_actual_error'   => form_error('txtPasswordActual'),
											'contraseña_error'   => form_error('txtPassword'),
											'confirmacion_contraseña_error'   => form_error('txtConfirmPassword')
                            );
                            $this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
                            exit();
                            }else{
                                //OBTENGO DATA
                                $this->load->model('usuario/Usuario_model', 'usuario');                               
								$cod_usuario = $token["data"]->id;
                                $r_usuario = $this->usuario->getPasswordActualUsuario(array($cod_usuario));
                            //    print_r($r_procedimientos);die();
                                if(empty($r_usuario)){
                                    $this->api_return(['status' => false  ,'tipo' => 'error_listado' ],200);
                                    exit();
								}

						
                                $pwd_actual = $this->input->post('txtPasswordActual');
                                $pwd_nueva = $this->input->post('txtPassword');
								$pwd_confirmacion = $this->input->post('txtConfirmPassword');
                                if (password_verify($pwd_actual, $r_usuario[0]->vPassword)) {     

                                    if(password_verify($pwd_nueva, $r_usuario[0]->vPassword)){
                                        $msg_err = '<span id="spMsgError">La nueva contraseña no puede ser igual a la contraseña actual.</span>'; 
                                        $this->api_return(['status' => false  ,'tipo' => 'error_pwd_nueva' ,'data' => $msg_err],200);
                                        exit();
                                    }
									
									$opciones = ['cost' => 12];
									$pwd_nueva = password_hash($pwd_confirmacion, PASSWORD_BCRYPT, $opciones);


									if($this->usuario->setPasswordUsuario(array($cod_usuario,$pwd_nueva))){
                                        $this->enviar_correo($token["data"]->email);
										$this->api_return(
											[
												'status' => true ,
												'data' => '<span id="spMsgExito">Se ha actualizado correctamente su contraseña.</span>'
											],
										200);
									}else{
										$msg_err = '<span id="spMsgError">No fue posible cambiar su contraseña.Por favor intente nuevamente.</span>'; 
									$this->api_return(['status' => false  ,'tipo' => 'error_upd_pass' ,'data' => $msg_err],200);
									exit();
									}
									



									
								}else{
									$msg_err = '<span id="spMsgError">La contraseña actual es incorrecta.</span>'; 
									$this->api_return(['status' => false  ,'tipo' => 'error_pwd_actual' ,'data' => $msg_err],200);
									exit();
									
								}


                            }

   
                }
                else{
                    setcookie ('PHPSESSID', "", time() - 3600,"/");
                    setcookie ('jwt', "", time() - 3600,"/");
                    session_destroy();
                    session_write_close();
                    $this->api_return(['status' => false  ,'tipo' => 'error_auth' ],200);
                    exit();
                }
                                 
            }else{
                //echo 'no paso token csrf';die();
                setcookie ('PHPSESSID', "", time() - 3600,"/");
                setcookie ('jwt', "", time() - 3600,"/");
                session_destroy();
                session_write_close();
                $this->api_return(['status' => false  ,'tipo' => 'error_token' ],200);
                exit();
            } 
		 }else{
            //echo 'no hay  token  csrf';die();
            setcookie ('PHPSESSID', "", time() - 3600,"/");
            setcookie ('jwt', "", time() - 3600,"/");
            session_destroy();
            session_write_close();
            $this->api_return(['status' => false  ,'tipo' => 'error_token' ],200);
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
   $mail->SMTPSecure = false;
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
   $mail->Subject = 'INFOMAIL - Pagos MPT';

   // Set email format to HTML
   $mail->isHTML(true);




   // Email body content
   $mailContent = "<b>Pagos - MPT</b><br>
       <p>Se ha actualizado su contraseña con éxito.</p>
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
