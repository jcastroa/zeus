<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Login extends API_Controller {

	

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



		$this->load->view('login_view',$data);
    }
    

     public function Autenticar()
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
                $this->form_validation->set_rules('password', 'contraseña', 'required|trim');

                        if ($this->form_validation->run() == false){
                        $errors = array(
                                        'email_error'   => form_error('emailaddress'),
                                        'password_error'   => form_error('password')
                        );
                        $this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
                        exit();
                        }else{
                            //VERIFICO USUARIO Y CLAVE BD
                            $email = $this->input->post('emailaddress');
                            $password = $this->input->post('password');

                            $this->load->model('login/Login_model', 'login');
                            $r_usuario = $this->login->verifica_usuario_login(array($email));
                          //  print_r($r_usuario);die();
                            if(empty($r_usuario)){
                                $msg_err = '<span id="spMsgError">Email ó contraseña incorrectos</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                exit();
                            }
                            if(!$r_usuario[0]->bActivo){
                                $msg_err = '<span id="spMsgError">Tu cuenta no ha sido activada.</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                exit();
                            }

                           /* $opciones = [
                                'cost' => 12,
                            ];
                            echo password_hash("123456", PASSWORD_BCRYPT, $opciones)."\n";*/
                            if (password_verify($password, $r_usuario[0]->vPassword)) {       
                                        // CREO AUTH JWT 
                                        $payload = [
                                            'id' => $r_usuario[0]->iCodUsuario,
                                            'nombres' => $r_usuario[0]->vNombres,
                                            'apellidos' =>$r_usuario[0]->vApellidos,
                                            'email' =>  $r_usuario[0]->vEmail
                                        ];
                                
                                        // Load Authorization Library or Load in autoload config file
                                    // $this->load->library('authorization_token');
                                
                                        // generate a token
                                        $token = $this->authorization_token->generateToken($payload);
                                    
                                        set_cookie('jwt',$token,'3600','','/');
                                       
                                        // return data
                                        $this->api_return(
                                            [
                                                'status' => true  
                                            ],
                                        200);

                                         setcookie ('PHPSESSID', "", time() - 3600,"/");
                                        session_destroy();
                                        session_write_close();

                                       
                            } else {
                                $msg_err = '<span id="spMsgError">Email ó contraseña incorrectos</span>'; 
                                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                                exit();
                               
                            }




                        }
         
       
















                
            }else{
                //echo 'no paso token csrf';die();
                $msg_err = '<span id="spMsgError">Email ó contraseña incorrectos</span>'; 
                $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
                exit();
            } 
		 }else{
            //echo 'no hay  token  csrf';die();
            $msg_err = '<span id="spMsgError">Email ó contraseña incorrectos</span>'; 
            $this->api_return(['status' => false  ,'tipo' => 'error_user' ,'data' => $msg_err],200);
            exit();
		 }


       /*  $this->api_return(
            [
                'status' => false  
            ],
        401);*/

       
      
      





    }



public function logOut(){
   
    $this->_apiConfig([
        'methods' => ['GET'],
    ]);

   
    session_start();
      //VERIFICO EL TOKEN CSRF
      $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
 
      if(hash_equals($token ,$_SESSION['csrf'])){
              //VERIFICO JWT SI ESTA AUTENTICADO
         /*   $this->load->library('authorization_token');
            $token = $this->authorization_token->validateTokenCookie();
            if($token["status"] === true){*/
                //LIMPIO SESION Y COOKIES
                setcookie ('PHPSESSID', "", time() - 3600,"/");
                setcookie ('jwt', "", time() - 3600,"/");
                session_destroy();
                session_write_close();
                redirect($this->config->base_url().'Login');
                exit();
              
          //  }
         }
         
     }


    }
      
     
     

