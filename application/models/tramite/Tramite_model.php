<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Tramite_model extends CI_Model {

    var $pagos_auth;

    function __construct()
    {
        parent::__construct();
        $this->pagos_auth = $this->load->database('pagos_auth', TRUE);
    }

  

    function getDerechosTramitesUsuario( $parametros) {
        $q = "exec USP_GET_TRAMITES_X_USUARIO ? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

    function getDerechosTramitesUsuarioFiltro( $parametros) {
        $q = "exec USP_GET_TRAMITES_X_USUARIO_FILTRO ?,?,? ";
        $result = (array) $this->pagos_auth->query($q,$parametros)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

}