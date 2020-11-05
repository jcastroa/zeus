<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Usuario_model extends CI_Model {

    var $pagos_auth;

    function __construct()
    {
        parent::__construct();
        $this->pagos_auth = $this->load->database('pagos_auth', TRUE);
    }

  

    public function getPasswordActualUsuario($parametros) {
        $q = "exec USP_GET_PASSWORD_USUARIO ? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

    public function setPasswordUsuario($parametros) {
        $q = "exec USP_UPD_PASSWORD_USUARIO ?,? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }

}