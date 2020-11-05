<?php
 

 
require_once APPPATH . 'libraries/API_Controller.php';
class Procedimiento extends API_Controller {



	 
    public function __construct() {
        parent::__construct();
    }


	public function getProcedimientos()
	{
       

           $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        $this->load->library('authorization_token');
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
                            $this->load->model('procedimiento/Procedimiento_model', 'pro');
                            $r_procedimientos = $this->pro->getProcedimientos();
                            //print_r($r_usuario);die();
                        
                            if(empty($r_procedimientos)){
                                $this->api_return(['status' => false  ,'tipo' => 'error_listado' ],200);
                                exit();
                            }

                            $this->api_return(
                                [
                                    'status' => true ,
                                    'data' => $r_procedimientos
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


    public function getInfoProcedimiento(){
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
                    if(!is_numeric ( $_POST["cbo_procedimiento"] )){
                        unset ($_POST["cbo_procedimiento"]);
                    }
                    $this->form_validation->set_rules('cbo_procedimiento', 'procedimiento', 'required');
                            if ($this->form_validation->run() == false){
                            $errors = array(

                                            'procedimiento_error'   => form_error('cbo_procedimiento')
                            );
                            $this->api_return(['status' => false  ,'tipo' => 'error_form' ,'data' => $errors],200);
                            exit();
                            }else{
                                //OBTENGO DATA
                                $this->load->model('procedimiento/Procedimiento_model', 'pro');
                                $cod_procedimiento = $this->input->post('cbo_procedimiento');
                               
                                $r_procedimientos = $this->pro->getIProcedimientoxId(array($cod_procedimiento));
                            //    print_r($r_procedimientos);die();
                                if(empty($r_procedimientos)){
                                    $this->api_return(['status' => false  ,'tipo' => 'error_listado' ],200);
                                    exit();
                                }

                               // $fecha = date("dmy");
                                //$hora = date("hms");
                               // echo substr(microtime(true),5);die();
                                $time = explode('.',microtime(true));
                                $refTransaccion = substr($time[0],6) . $time[1];
                                //$new_date = date('dmY', $date);
                               // $refTransaccion =  'U'.$token["data"]->id .'P'.$cod_procedimiento.'F'.$fecha.'H'.$hora ;
                              // $refTransaccion = '1602080371';
                               $email =  $token["data"]->email ;
                               $codUsu =  $token["data"]->id ;
                               $nombres =  explode(" ",$token["data"]->nombres)[0] ;
                               $apellidos =  explode(" ",$token["data"]->apellidos)[0] ;
                              // $signature = md5("4Vj8eK4rloUd272L48hsrarnUA"."~"."508029"."~".$refTransaccion."~".$r_procedimientos[0]->vMonto."~PEN");
                               $idadquiriente = '144';
                               $idcomercio = '11977';
                                 $op = $refTransaccion;
                                 $monto =$r_procedimientos[0]->vMonto . $r_procedimientos[0]->vDecimales;
                                 $moneda = '604';
                                 $key='VrWsTZMmPAgUhQFm*897388977';
                                $fimra_cadena = $idadquiriente.$idcomercio.$op.$monto.$moneda.$key;
                                $signature = openssl_digest($fimra_cadena,'sha512');

                               $html = '<form name="f1" id="f1" action="#" method="post" class="alignet-form-vpos2">'
                                .'<input name="acquirerId"    type="hidden"  value="144"   >'
                               .'<input name="idCommerce"     type="hidden"  value="11977" >'
                                .'<input name="purchaseAmount"   type="hidden"  value="' .$monto .   '"  >'
                               .'<input name="purchaseCurrencyCode" type="hidden"  value="604" >'
                               . '<input name="purchaseOperationNumber"        type="hidden"   value="' . $op .   '"   >'
                               . '<input name="language"           type="hidden"  value="SP"  >'
                              . '<input name="shippingFirstName" type="hidden"  value="' . $nombres .   '" >'
                              . '<input name="shippingLastName"      type="hidden"  value="' . $apellidos .   '" >'
                              . '<input name="shippingEmail"     type="hidden"  value="' .  $email .   '"  >'
                               . '<input name="shippingAddress"          type="hidden"  value="NO ADDRESS" >'
                              .  '<input name="shippingZIP"    type="hidden"  value="No ZIP" >'
                              .  '<input name="shippingCity"    type="hidden"  value="No CITY" >'
                             . '<input name="shippingState"    type="hidden"  value="NO STATE" >'
                             . '<input name="shippingCountry"          type="hidden"  value="PE" >'
                             . '<input name="descriptionProducts"          type="hidden" value="' .$r_procedimientos[0]->vDescripcion .   '"   >'
                             . '<input name="programmingLanguage"          type="hidden"  value="PHP" >'
                             . '<input name="purchaseVerification"          type="hidden"  value="'.$signature.'" >'
                             . '<input name="reserved1"          type="hidden"  value="'.$codUsu.'" >'
                             . '<input name="reserved2"          type="hidden"  value="'.$cod_procedimiento.'" >'
                             .  '<input type="button" class="btn btn-lg btn-block btn-success" onclick="javascript:AlignetVPOS2.openModal(&#39;https://integracion.alignetsac.com/&#39;,&#39;2&#39;)" value="Pagar Trámite">'
                            . '</form>';


                                $this->api_return(
                                    [
                                        'status' => true ,
                                        'data' => $html,
                                        'procedimiento' => $r_procedimientos
                                    ],
                                200);

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
       
		
}
