<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Fpdf_lib
{
    public function __construct(){
        log_message('Debug', 'FPDF class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/fpdf/fpdf.php';
       
        
        $fdpd = new FPDF('P','mm',array(80,150));
        return $fdpd;
    }
}