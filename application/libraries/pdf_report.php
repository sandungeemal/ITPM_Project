<?php
defined('BASEPATH') OR exit('no direct script access allowed');

require_once(dirname(__FILE__).'/tcpdf/tcpdf.php');

class pdf_report extends TCPDF {
    public function __construct(){
        parent::__construct();
    }
}