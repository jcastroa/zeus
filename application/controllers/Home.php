<?php
 

 
require_once APPPATH . 'libraries/API_Controller.php';
class Home extends API_Controller {



	 
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
       
            $this->template->load('default_layout', 'contents' , 'home_view', $data);
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
}
