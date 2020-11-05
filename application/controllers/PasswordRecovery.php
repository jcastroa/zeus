<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class PasswordRecovery extends API_Controller {

	

    public function __construct() {
        parent::__construct();
    }


	public function index()
	{
      /* $this->_APIConfig([
            'methods' => ['GET'],
            'requireAuthorization' => true,
        ]);*/

        $this->_apiConfig([
            'methods' => ['GET'],
        ]);
         // Load Authorization Library or Load in autoload config file
		 $this->load->library('authorization_token');

		 // generate a token
		 $token = $this->authorization_token->validateTokenCookie();
	//	 print_r($token);die();
         if($token["status"] === true){
            redirect($this->config->base_url().'inicio');
            exit();
		 }
      

         ini_set("session.cookie_httponly", 1);
         ini_set("session.cookie_secure", 0);
         ini_set("session.cookie_path","/;SameSite=Strict");
        
         session_start();

         if(empty($_SESSION['key'])){
            $_SESSION['key'] = bin2hex(random_bytes(32));
         }

         $data['csrf'] = hash_hmac("sha256","DV9BigBsYDpRIKtTYnhAdpUKe_ovdsI6cIGAT00QH17Jku02QKdA3ThH6pdBAAKR3ux66MKpH7cWTaAKBShPvRoqJPE9EYWHFWTVELBNfmicZ6aIkHtEB89o-qirdnPeoTaLaiB3rPdZ2G8SU4tKLswx2BKB6-qRIDT52yfe9-6_ttChgwkzOYMdL4RQBpzDB5-4j6t9GKWOnT5s_uxjPFvlObHcVoORMD7Obca437R3zxEiZZXcR_Nn-E_azRHdXn_cr3KhrEf0zupBZsrWe8hsso9uTOKqvYUo-lL7W07tgerkH2xjqerlfE24ZLzvzrKIremgMWvC_KFt8LIglQ",$_SESSION['key']);

         if(empty($_SESSION['csrf'])){
            $_SESSION['csrf'] = $data['csrf'];
         }


//$_SESSION['key'] = "www";

      //  echo $this->security->get_csrf_hash();die();

       //  set_cookie('jwt','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEyMzQ1NiIsIm90aGVyIjoiU29tZSBvdGhlciBkYXRhIiwiQVBJX1RJTUUiOjE1OTc2Mzg2OTR9.EGFWv7hrkFgu_8M0n_-_sz9dKQha_pWtUIETn2vPY94','3600','','/'); 
        
        // $this->input->set_cookie($cookie);
       // setcookie(    "prueba", "123456", 300, "/", "", false, false );



		$this->load->view('pwd_reset_view',$data);
    }
    

   
    public function recoveryPwd()
        {
               // API Configuration
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
			if(hash_equals($token['token-csrf'] ,$_SESSION['csrf'])){
                //CAMPOS VACIOS
               
                $this->form_validation->set_rules('emailaddress', 'correo electrónico', 'required|trim|valid_email');
                

                        if ($this->form_validation->run() == false){
                        $errors = array(
                                        'email_error'   => form_error('emailaddress')
                        );
                        $this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
                        exit();
                        }else{
                            //VERIFICO USUARIO Y CLAVE BD
                            $email = $this->input->post('emailaddress');

                            $this->load->model('login/Login_model', 'login');
                            $r_usuario = $this->login->verifica_usuario_login(array($email));

                            if(!empty($r_usuario)){
                          $datosGenerados =  $this->generarLinkPwdRecovery();
                          $hashedToken = password_hash($datosGenerados['token'],PASSWORD_DEFAULT);
                          $this->login->eliminar_pwd_recovery_email(array($email));
                          $this->login->insertar_pwd_recovery_email(array($email,
                                                                          $datosGenerados['selector'],
                                                                          $hashedToken,
                                                                          $datosGenerados['expires']));
                           
                                
                            


                            }

                          
                            $posArroba = strpos($email,'@');
                            $lenEmail = strlen($email);
                           
                            $emailMask = substr($email,0,1).  str_repeat('*',$posArroba-1) .'@'. substr($email,$posArroba+1,1).  str_repeat('*',(($lenEmail-1) - $posArroba)-1)   ;   
                         

                             //ENVIO EMAL CON LINK
                             if($this->enviar_correo( $datosGenerados['url'],$email)){
                                $this->api_return(
                                    [
                                        'status' => true ,
                                        'data' => '<span id="spMsg">Se envio un mensaje a tu correo electrónico <b>'.$emailMask.'</b>. &nbsp;Sigue las instrucciones del mensaje para restablecer la contraseña.</span>'
                                    ],
                                200);
                             }else{
                                $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                exit();
                             }

                        }
       
            }else{
                //echo 'no paso token csrf';die();
                $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                exit();
            } 
		 }else{
            //echo 'no hay  token  csrf';die();
            $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
            $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
            exit();
		 }

        }


        function generarLinkPwdRecovery(){

          $selector = bin2hex(random_bytes(8));
          $token = bin2hex(random_bytes(32));
          $url = $this->config->base_url().'nuevapwd?selector=' .$selector."&validator=".bin2hex($token);
          $expires = date('U')+1800;

           return array('url' => $url ,'expires' => $expires ,'selector' => $selector , 'token' => $token );

        }




        
    public function enviar_correo($url, $email)
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

    //$mail->SMTPDebug = 2;
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
    $mail->Subject = 'Restablecer contraseña - Pagos MPT';

    // Set email format to HTML
    $mail->isHTML(true);




    // Email body content
    $mailContent = "Hola,
        <p>Hemos recibido una solicitud para restablecer la contraseña.</p>
        <p>Si no has sido tú quien ha enviado la solicitud, ignora este mensaje.<br>En caso contrario, puedes restablecer a través de este enlace:</p>
        <p> <a href='$url' target='_blank' style='background-color:#ed2939;padding: 8px 12px; border: 1px solid #ED2939;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;'>
        Haz click aquí para restablecer tu contraseña             
         </a></p>
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


public function newPwd()
{
    $this->_apiConfig([
        'methods' => ['GET'],
    ]);
     // Load Authorization Library or Load in autoload config file
     $this->load->library('authorization_token');

     // generate a token
     $token = $this->authorization_token->validateTokenCookie();
//	 print_r($token);die();
     if($token["status"] === true){
        redirect($this->config->base_url().'inicio');
        exit();
     }
  

     ini_set("session.cookie_httponly", 1);
     ini_set("session.cookie_secure", 0);
     ini_set("session.cookie_path","/;SameSite=Strict");
    
     session_start();

     if(empty($_SESSION['key'])){
        $_SESSION['key'] = bin2hex(random_bytes(32));
     }

     $data['csrf'] = hash_hmac("sha256","DV9BigBsYDpRIKtTYnhAdpUKe_ovdsI6cIGAT00QH17Jku02QKdA3ThH6pdBAAKR3ux66MKpH7cWTaAKBShPvRoqJPE9EYWHFWTVELBNfmicZ6aIkHtEB89o-qirdnPeoTaLaiB3rPdZ2G8SU4tKLswx2BKB6-qRIDT52yfe9-6_ttChgwkzOYMdL4RQBpzDB5-4j6t9GKWOnT5s_uxjPFvlObHcVoORMD7Obca437R3zxEiZZXcR_Nn-E_azRHdXn_cr3KhrEf0zupBZsrWe8hsso9uTOKqvYUo-lL7W07tgerkH2xjqerlfE24ZLzvzrKIremgMWvC_KFt8LIglQ",$_SESSION['key']);

     if(empty($_SESSION['csrf'])){
        $_SESSION['csrf'] = $data['csrf'];
     }


//$_SESSION['key'] = "www";

  //  echo $this->security->get_csrf_hash();die();

   //  set_cookie('jwt','eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEyMzQ1NiIsIm90aGVyIjoiU29tZSBvdGhlciBkYXRhIiwiQVBJX1RJTUUiOjE1OTc2Mzg2OTR9.EGFWv7hrkFgu_8M0n_-_sz9dKQha_pWtUIETn2vPY94','3600','','/'); 
    
    // $this->input->set_cookie($cookie);
   // setcookie(    "prueba", "123456", 300, "/", "", false, false );

   $currentDate = date("U");
   $selector = $_GET['selector'];
   $this->load->model('login/Login_model', 'login');
   $r_pwd_reset = $this->login->get_pwd_recovery(array($selector,$currentDate));       
   if(empty($r_pwd_reset)){
     $this->template->load('default_error_404', 'contents' , 'error_404_front', array());
   }else{
    $this->load->view('pwd_nueva_view',$data);
   }

   




}


        public function savePwd()
            {
                     // API Configuration
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
                    if(hash_equals($token['token-csrf'] ,$_SESSION['csrf'])){
                        //CAMPOS VACIOS
                    
                        $this->form_validation->set_rules('txtPassword', 'nueva contraseña', 'required|trim');
                        $this->form_validation->set_rules('txtConfirmPassword', 'confirmar nueva contraseña', 'required|trim|matches[txtPassword]');
                        

                                if ($this->form_validation->run() == false){
                                $errors = array(
                                    'contraseña_error'   => form_error('txtPassword'),
                                    'confirmacion_contraseña_error'   => form_error('txtConfirmPassword')
                                );
                                $this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
                                exit();
                                }else{
                                    //VERIFICO TOKEN YA EXPIRO
                                    $currentDate = date("U");
                                    $selector = $this->input->post('selector');
                                    $validator = $this->input->post('validator');
                                    $pwd_confirmacion = $this->input->post('txtConfirmPassword');
                                    $this->load->model('login/Login_model', 'login');
                                    $r_pwd_reset = $this->login->get_pwd_recovery(array($selector,$currentDate));       
                                    if(empty($r_pwd_reset)){
                                      // MSJ VUELVA A ENVIAR MSJ
                                      $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Debe volver a enviar su solicitud de reinicio de contraseña.</span>'; 
                                      $this->api_return(['status' => false  ,'tipo' => 'error_pwd' ,'data' => $msg_err],200);
                                      exit();
                                    }else{
                                       $tokenBin = hex2bin($validator);
                                       $tokenCheck = password_verify($tokenBin,$r_pwd_reset[0]->tTokenReset);
                                       if($tokenCheck === false){
                                            // MSJ VUELVA A ENVIAR MSJ
                                            $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Debe volver a enviar su solicitud de reinicio de contraseña.</span>'; 
                                            $this->api_return(['status' => false  ,'tipo' => 'error_pwd' ,'data' => $msg_err],200);
                                            exit();
                                       }else if($tokenCheck === true){
                                            $r_usuario = $this->login->verifica_usuario_login(array($r_pwd_reset[0]->tEmailReset));
                                            if(empty($r_usuario)){
                                                 // MSJ ERROR
                                                 $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                                                 $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                                 exit();
                                            }else{
                                                $opciones = ['cost' => 12];
                                                $pwd_nueva = password_hash($pwd_confirmacion, PASSWORD_BCRYPT, $opciones);
                                                if($this->login->actualizar_pwd_recovery_email(array($r_pwd_reset[0]->tEmailReset,$pwd_nueva))){
                                                    if( $this->login->eliminar_pwd_recovery_email(array($r_pwd_reset[0]->tEmailReset))){
                                                       $this->enviar_correo_alerta($r_pwd_reset[0]->tEmailReset);
                                                        $this->api_return(
                                                            [
                                                                'status' => true ,
                                                                'data'  => $this->config->base_url() .'Login?newpwd=pwdupdate' 
                                                            ],
                                                        200);
                                                    }else{
                                                        $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                                                        $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                                        exit();
                                                    }
                                                   
                                                }else{
                                                    $msg_err = '<span id="spMsg">No fue posible cambiar su contraseña.Por favor intente nuevamente.</span>'; 
                                                    $this->api_return(['status' => false  ,'tipo' => 'error_upd_pass' ,'data' => $msg_err],200);
                                                    exit();
                                                }
                                            }
                                       }


                                    }

                                   

                                }
            
                    }else{
                        //echo 'no paso token csrf';die();
                        $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                        $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                        exit();
                    } 
                }else{
                    //echo 'no hay  token  csrf';die();
                    $msg_err = '<span id="spMsg"><b>Oh!</b>&nbsp;Al parecer ha ocurrido un error.</span>'; 
                    $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                    exit();
                }
            }




   public function enviar_correo_alerta( $email)
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
      
     
     

