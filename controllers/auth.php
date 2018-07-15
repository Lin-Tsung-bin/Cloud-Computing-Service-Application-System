<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $referer = $this->input->server('HTTP_REFERER');
        $this->load->layout('bootstrap_login');
    }
    
    public function login() {
        $this->load->service('Auth_service');
        $this->load->library('verify_code_util');

		//--SSO--		
        if($this->Auth_service->sso_islogin()){
            $user_id=$this->Auth_service->get_sso_psn_code();
            $passwd="sso";           
        }
		//--非SSO--
        else{
        	//1.取得POST資料
			$user_id = trim($this->input->post('account',true));
	        $passwd = $this->input->post('password',true);
	        $code = $this->input->post('code',true);        	
        }

        $param = array();
         
		//2.資料驗証
		
        if ($user_id == '' || $passwd == '') {
            $param['msg'] = '請輸入使用者代號與密碼！';
        } else if (!$this->Auth_service->sso_islogin()  && ! $this->verify_code_util->verify($code)){
            $param['msg'] = '驗證碼不正確！';
        } else
		
		if ( ! $this->Auth_service->login($user_id, $passwd)) {
            $param['msg'] = '使用者代號或密碼有誤！';
        }
        
		//3.驗証失敗->導回首頁並傳送錯誤訊息
        if (isset($param['msg'])) {
            if ($user_id) {
                $param['account'] = $user_id;  //used_id改為account
            }
            $this->load->layout('bootstrap_login', $param);
            return;
        }
		
		//4.驗証成功->因身份決定要導向的程式
    	if ($this->Auth_service->get_user_role()!='U') {
            $this->output->redirect($this->control_util->action_url('cloud11121'));  //action_url('ex12')
        } else {
            $this->output->redirect($this->control_util->action_url('cloud12111')); //action_url('notice','manual1')
        }   
        
    }
    public function logout() {
        $this->load->service('Auth_service');
        $this->Auth_service->logout();        
        $app_url="http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?c=auth";       
        $sso_url="https://fs.ncku.edu.tw/adfs/ls/?wa=wsignout1.0&wreply=";     
        header("Location: ".$sso_url.$app_url);
    }

    public function ssologin_error(){
        $param['msg']=$this->Auth_service->get_sso_errormsg();
        $param['msg'].="<a href='index.php'>回首頁</a>";
        $this->load->layout('ssologin_error',$param);
	}  
}