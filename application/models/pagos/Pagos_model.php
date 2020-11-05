<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Pagos_model extends CI_Model {

    var $pagos_auth;

    function __construct()
    {
        parent::__construct();
        $this->pagos_auth = $this->load->database('pagos_auth', TRUE);
    }

  

    function getPagosUsuario( $parametros) {
        $q = "exec USP_GET_PAGOS_X_USUARIO_2 ? ";
      
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

    function getPagosUsuarioFiltro( $parametros) {
        $q = "exec USP_GET_PAGOS_X_USUARIO_FILTRO_2 ?,?,? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

}