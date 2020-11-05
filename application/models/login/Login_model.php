<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of User
 *
 * @author roytuts.com
 */
class Login_model extends CI_Model {

    var $pagos;

    function __construct()
    {
        parent::__construct();
        $this->pagos = $this->load->database('pagos', TRUE);
    }

    function verifica_usuario_login( $params) {
        $q = "exec USP_GET_USUARIO ? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }

    function eliminar_pwd_recovery_email( $params) {
        $q = "exec USP_DEL_PASSWORD_RESET ? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }

    function insertar_pwd_recovery_email( $params) {
        $q = "exec USP_INS_PASSWORD_RESET ?,?,?,? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }


    function get_pwd_recovery( $params) {
        $q = "exec USP_GET_USUARIO_PASSWORD_RESET ?,? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return $result;
        }
        return null;
    }


    function actualizar_pwd_recovery_email( $params) {
        $q = "exec USP_UPD_PASSWORD_USUARIO_RESET ?,? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }


    function verificar_usuario_existe( $params) {
        $q = "exec USP_VERIFICA_USUARIO_EXISTE ? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }

    function registra_nuevo_usuario( $params) {
        $q = "exec USP_INS_USUARIO ?,?,?,?,? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }


    function verificar_token_activacion( $params) {
        $q = "exec USP_GET_USUARIO_X_TOKEN ? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return $result;
        }
        return false;
    }

    function activar_usuario( $params) {
        $q = "exec USP_ACTIVAR_USUARIO ? ";
        $result = (array) $this->pagos->query($q, $params)->result();
        if (count($result)>0) {
            return true;
        }
        return false;
    }

}