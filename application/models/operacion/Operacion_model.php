<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Operacion_model extends CI_Model {

    var $pagos_auth;

    function __construct()
    {
        parent::__construct();
        $this->pagos_auth = $this->load->database('pagos_auth', TRUE);
    }

    function saveOperacionPagoDerecho($parametros) {
        $q = "exec USP_INS_OPERACION_PAGO_DERECHO_2 ?,?,?,?,?,?,?,?,?,?";
       // echo $q;die();
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

 

}