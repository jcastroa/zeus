<?php
 

 
require_once APPPATH . 'libraries/API_Controller.php';
class Tramite extends API_Controller {



	 
    public function __construct() {
        parent::__construct();
    }




    public function getDerechosTramitesUsuario(){
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

                                //OBTENGO DATA
                                $this->load->model('tramite/Tramite_model', 'tramite');
                                $cod_usuario =  $token["data"]->id;                             
                                $r_derechos_tramite = $this->tramite->getDerechosTramitesUsuario(array($cod_usuario));
                                $this->api_return(
                                    [
                                        'status' => true ,
                                        'data' => $r_derechos_tramite
                                    ],
                                200);
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
       

    public function getDerechosTramitesUsuarioFiltro(){
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

                                //OBTENGO DATA
                                $this->load->model('tramite/Tramite_model', 'tramite');
                                $cod_usuario =  $token["data"]->id;     
                                
                                $ai = $this->input->post('ai');
                                $mi = $this->input->post('mi')+1;
                                $di = $this->input->post('di');

                                $af = $this->input->post('af');
                                $mf = $this->input->post('mf')+1;
                                $df = $this->input->post('df');

                                if(checkdate($mi, $di, $ai)== false and checkdate($mf, $df, $af)==false){
                                    $this->api_return(['status' => false  ,'tipo' => 'error_filtro' ],200);
                                    exit();
                                }

                                $fini=$ai.'-'.$mi.'-'.$di;
                                $ffin=$af.'-'.$mf.'-'.$df;


                                $r_derechos_tramite = $this->tramite->getDerechosTramitesUsuarioFiltro(array($cod_usuario,$fini,$ffin));
                                $this->api_return(
                                    [
                                        'status' => true ,
                                        'data' => $r_derechos_tramite
                                    ],
                                200);
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
		
}
