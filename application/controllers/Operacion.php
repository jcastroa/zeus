<?php

require_once APPPATH . 'libraries/API_Controller.php';
class Operacion extends API_Controller {

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
	public function requestPay()
	{

		  // API Configuration
         $this->_apiConfig([
            'methods' => ['POST'],
        ]);


			$this->load->model('operacion/Operacion_model', 'op');

			if(isset($_POST["purchaseVerification"])){
				$purchaseVerification = $_POST["purchaseVerification"];
			}else{$purchaseVerification = "";}
			if(isset($_POST["IDTransaction"])){
				$IDTransaction = $_POST["IDTransaction"];
			}else{$IDTransaction = "";}

			$parametros = array(
								  $_POST["authorizationResult"]	,
								  $_POST["purchaseOperationNumber"],
								  $_POST["shippingEmail"],
								  $_POST["purchaseAmount"],
								  $_POST["txDateTime"],
								  $_POST["descriptionProducts"],
								  $purchaseVerification,
								  $_POST["acquirerId"],
								  $_POST["idCommerce"],
								  $_POST["purchaseCurrencyCode"],
								  $_POST["reserved1"],
								  $_POST["reserved2"],
								  $IDTransaction
								  	
			);

			$idadquiriente = $parametros[7];
			$idcomercio = $parametros[8];
			  $op = $parametros[1];
			  $monto =$parametros[3];
			  $moneda = $parametros[9];
			  $authorizationResult = $parametros[0];
			  $key='VrWsTZMmPAgUhQFm*897388977';
			 $fimra_cadena = $idadquiriente.$idcomercio.$op.$monto.$moneda. $authorizationResult.$key;
			 $signature = openssl_digest($fimra_cadena,'sha512');

			 if ($parametros[6] == $signature ||  $parametros[6] == "") {  
			if($parametros[0] == '00'){
				$operacion = $this->op->saveOperacionPagoDerecho(array(
					$parametros[0],$parametros[12],$parametros[1],$parametros[9],$parametros[3],
					$parametros[4],$parametros[2],$parametros[5],$parametros[10],$parametros[11]
				));

				if(!empty($operacion)){
					define('SOL','S/.');
					$this->load->library('fpdf_lib');
					$pdf = $this->fpdf_lib->load();
					$pdf->AddPage();
			 
					// CABECERA
					$pdf->SetFont('Helvetica','',12);
					$pdf->Cell(60,4,'Pagos - MPT',0,1,'C');
					$pdf->SetFont('Helvetica','',8);
					$pdf->Cell(60,4,'RUC: 20175639391',0,1,'C');
					//$pdf->Cell(60,4,'C/ Arturo Soria, 1',0,1,'C');
					$pdf->Cell(60,4,'JR. ALMAGRO NRO. 525',0,1,'C');
					$pdf->Cell(60,4,'(044) 484-240',0,1,'C');
				//	$pdf->Cell(60,4,'alfredo@lacodigoteca.com',0,1,'C');
					
					// DATOS FACTURA        
					$pdf->Ln(5);
					$pdf->Cell(60,4,'Fecha: '.$parametros[4],0,1,'');
					$pdf->Cell(60,4,'Id Usuario: '.$parametros[2],0,1,'');
					$pdf->Cell(60,4,'Medio de pago: '.'Tarjeta de Crédito',0,1,'');
					
					// COLUMNAS
					$pdf->SetFont('Helvetica', 'B', 7);
					$pdf->Cell(35, 10, 'Procedimiento', 0);
				   // $pdf->Cell(5, 10, 'Ud',0,0,'R');
					$pdf->Cell(10, 10, 'Costo(S/.)',0,0,'R');
					$pdf->Cell(15, 10, 'Total(S/.)',0,0,'R');
					$pdf->Ln(8);
					$pdf->Cell(60,0,'','T');
					$pdf->Ln(0);
					
					// PRODUCTOS
					$pdf->SetFont('Helvetica', '', 7);
					$pdf->MultiCell(35,4,$parametros[5],0,'L'); 
				   // $pdf->Cell(35, -5, '2',0,0,'R');
					$pdf->Cell(45, -5, number_format(round(($parametros[3]/100),2), 2, ',', ' '),0,0,'R');
					$pdf->Cell(15, -5, number_format(round(($parametros[3]/100),2), 2, ',', ' '),0,0,'R');
					$pdf->Ln(3);
				   
					
					// SUMATORIO DE LOS PRODUCTOS Y EL IVA
					$pdf->Ln(6);
					$pdf->Cell(60,0,'','T');
					$pdf->Ln(2);    
				   /* $pdf->Cell(25, 10, 'TOTAL SIN I.V.A.', 0);    
					$pdf->Cell(20, 10, '', 0);
					$pdf->Cell(15, 10, number_format(round((round(12.25,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
					$pdf->Ln(3);    
					$pdf->Cell(25, 10, 'I.V.A. 21%', 0);    
					$pdf->Cell(20, 10, '', 0);
					$pdf->Cell(15, 10, number_format(round((round(12.25,2)),2)-round((round(2*3,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
					$pdf->Ln(3); */   
					$pdf->Cell(25, 10, 'TOTAL', 0);    
					$pdf->Cell(20, 10, '', 0);
					$pdf->Cell(15, 10,SOL.number_format(round(($parametros[3]/100),2), 2, ',', ' '),0,0,'R');
					
					// PIE DE PAGINA
					$pdf->SetFont('Helvetica', 'B', 7);
					$pdf->Ln(12);
					$pdf->Cell(60,0,utf8_decode('MI NÚMERO DE DERECHO DE TRÁMITE:'),0,1,'C');
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica', 'B', 12);
					$pdf->Cell(60,0,$operacion[0]->derecho_tramite,0,1,'C');
					
					$nombre_pdf = $operacion[0]->derecho_tramite.'.pdf';
					$pdf->Output('C:/SUBIDAS/'.$nombre_pdf,'f');
		
					$this->enviar_correo($parametros[2],array($operacion[0]->derecho_tramite,$parametros[5],$parametros[4],number_format(round(($parametros[3]/100),2), 2, ',', ' '),$nombre_pdf));
			
				 }
			}
		}
	
	session_start();
		$_SESSION["dataArr"]=$parametros;
		redirect($this->config->base_url().'Respuesta');
			


        

        
       




	


		
	}


	
	public function enviar_correo($email,$datos)
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
    $mail->Subject = 'Derecho Trámite - Pagos MPT';

    // Set email format to HTML
    $mail->isHTML(true);




    // Email body content
    $mailContent = "Estimado Usuario,
         <p>En este correo, encontrarás adjunto tu ticket referente al pago que realizaste en la plataforma de Pagos - MPT.</p>   
		 <hr>
		 <p><b>Información de tu Derecho Trámite: ".$datos[0] ."</b></p>
		 <p>
		  <b>Procedimiento : </b>".$datos[1] ."<br>
		  <b>Fecha Emisión : </b>".$datos[2] ."<br>
		  <b>Monto Total : </b>S/.".$datos[3] ."<br>
		 </p>
		 <p>Te pedimos guardar este mensaje para futuras consultas.</p>
        <p>Gracias,<br><i>Gerencia de Sistemas<br>Municipalidad Provincial de Trujillo<br>(044) 484-240</i></p>";
    $mail->Body = $mailContent;
    $mail->AddAttachment('C:/SUBIDAS/'.$datos[4],"ticket");

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
