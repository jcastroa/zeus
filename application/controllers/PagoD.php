<?php
 

 
require_once APPPATH . 'libraries/API_Controller.php';
class PagoD extends API_Controller {



	 
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
			$this->template->load('default_layout', 'contents' , 'pago_der_view', $data);
        
		 }else{
	
			redirect($this->config->base_url().'Login');
 exit();
		 }
		// print_r($token);die();
		// $this->load->view('registro_view');
	}


   public function getRespuestaPago(){
	$this->_apiConfig([
		'methods' => ['GET'],
	]);

   
	
	 // Load Authorization Library or Load in autoload config file
	 $this->load->library('authorization_token');

	 // generate a token
	 $token = $this->authorization_token->validateTokenCookie();
	// print_r($token);die();
	 if($token["status"] === true){
	
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

		if(empty($_GET['merchantId'])){
			$this->template->load('default_layout_resp', 'contents' , 'error_404', $data);
			
		} else{
			$this->template->load('default_layout_resp', 'contents' , 'pago_der_resp_view', $data);
		}


		


		
	 }else{
		setcookie ('PHPSESSID', "", time() - 3600,"/");
		setcookie ('jwt', "", time() - 3600,"/");
		session_destroy();
		session_write_close();
		redirect($this->config->base_url().'Login');
        exit();
	 }
	   
   }


   public function mispagos()
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
       
            $this->template->load('default_layout', 'contents' , 'lista_pagos_view', $data);
		 }else{
			setcookie ('PHPSESSID', "", time() - 3600,"/");
			setcookie ('jwt', "", time() - 3600,"/");
			session_destroy();
			session_write_close();
			redirect($this->config->base_url().'Login');
 exit();
		 }
   }


   public function misderechostramites()
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
       
            $this->template->load('default_layout', 'contents' , 'lista_tramites_view', $data);
		 }else{
			setcookie ('PHPSESSID', "", time() - 3600,"/");
			setcookie ('jwt', "", time() - 3600,"/");
			session_destroy();
			session_write_close();
			redirect($this->config->base_url().'Login');
 exit();
		 }
   }




   public function getPagosUsuario(){
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
							$this->load->model('pagos/Pagos_model', 'pagos');
							$cod_usuario =  $token["data"]->id;                             
							$r_derechos_tramite = $this->pagos->getPagosUsuario(array($cod_usuario));
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



public function getPagosUsuarioFiltro(){
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
							$this->load->model('pagos/Pagos_model', 'pagos');
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


							$r_pagos = $this->pagos->getPagosUsuarioFiltro(array($cod_usuario,$fini,$ffin));




							$this->api_return(
								[
									'status' => true ,
									'data' => $r_pagos
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
