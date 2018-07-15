<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verifycode extends CI_Controller {
    
    function __construct()   {
        parent::__construct();
    }
    
    function index()  {    
        $this->load->library('verify_code_util');
        $this->verify_code_util->outputVerifyCode();
        exit();
    }
}
