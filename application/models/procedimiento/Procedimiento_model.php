<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Procedimiento_model extends CI_Model {

    var $pagos_auth;

    function __construct()
    {
        parent::__construct();
        $this->pagos_auth = $this->load->database('pagos_auth', TRUE);
    }

    function getProcedimientos( ) {
        $q = "exec USP_GET_PROCEDIMIENTOS ";
        $result = (array) $this->pagos_auth->query($q)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

    function getIProcedimientoxId( $parametros) {
        $q = "exec USP_GET_PROCEDIMIENTO_X_ID ? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

}