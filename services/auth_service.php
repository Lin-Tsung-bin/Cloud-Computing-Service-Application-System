<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_service extends NF_Service {
    
    const USER_ID = '__user_id_cloud';
    const USER_NAME = '__user_name_cloud';
    const LOGIN_TIME = '__login_time_cloud';
    const USER_ROLE = '__user_role_cloud';
    const DEPT_CODE = '__dept_code_cloud';
    const DEPT_NAME = '__dept_name_cloud';  
    public function __construct() {
        log_message('debug', "Auth_service Class Initialized");
    }

    /**
     * 取得登入的使用者ID。
     */
    function get_user_id() {
        return $this->session->userdata(self::USER_ID);
    }

    /**
     * 取得使用者名稱。
     */
    function get_user_name() {
        return $this->session->userdata(self::USER_NAME);
    }
    /**
     * 取得角色
     */
    function get_user_role() {
        return ($this->session->userdata(self::USER_ROLE))? $this->session->userdata(self::USER_ROLE) : $this->config->item('default_role');  
    //2018018討論管理者權限不同，登入情況不同
	}  
	
    /**
     * 是否登入
     */
    function is_login() {
        if($this->session->userdata(self::USER_ID)) {
        	
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * 取得登入者的資料。
     */
    function get_user_data($fields='*') {
        $name_id = $this->get_user_id();  //account更動name_id
        if ($account) {   //account更動name_id
            $this->load->model('User_model'); 
            return $this->User_model->get_by_no($account, $fields);   //account更動name_id
        } else {
            return FALSE;
        }
    }
    
    /**
     * Logout user
     */
    function logout() {
        //Destroy session
        $this->session->sess_destroy();
    } 
	/*
     * 取得SSO登入的帳號
     */
    function get_sso_psn_code(){
        return $_SESSION['__sso_psn_code_cloud'];
    }
	/*
     * 取得SSO登入的姓名
     */
    function get_sso_psn_name(){
        return $_SESSION['__sso_psn_name_cloud'];
    }
	/*
     * 取得SSO登入的單位名稱
     */
    function get_sso_dept_name(){
        return $_SESSION['__sso_dept_name_cloud'];
    }
	/*
     * 取得SSO登入的單位編號
     */
    function get_sso_dept_code(){
        return $_SESSION['__sso_dept_code_cloud'];
    }	
	/*
     * 取得登入的單位名稱
     */
    function get_dept_name(){
        return $this->session->userdata(self::DEPT_CODE);
    }
	/*
     * 取得登入的單位編號
     */
    function get_dept_code(){
        return $this->session->userdata(self::DEPT_NAME);
    }				
    /*
     * 取得SSO登入的錯誤訊息
     */
    function get_sso_errormsg(){
        return $_SESSION['__sso_errormsg_cloud'];
    }	
    /*
     * 確認SSO登入是否成功
     */
    function sso_islogin(){
        if(isset($_SESSION['__sso_check_cloud']) && $_SESSION['__sso_check_cloud'] == true){
            return true;
            
        }else{
            return false;
        }
    } 
    /**
     * 登入
     * @param $user_id - 登入帳號   //accunt
     * @param $password - 密碼
     * @return 登入成功回傳TRUE，失敗回傳FALSE
     */
    function login($account='', $password='') {   //account更動name_id
 
        if($account == '' || $password == '') {   //account更動name_id
            return FALSE;
        }
        

        //若無需其他資料，以下三行可省略，直接判斷sso_islogin就好
        if($this->sso_islogin()){
                $user_info = array(
                                    self::USER_ID => $account,          	    // 身分證字號  //user_id 更動  account 
                                    self::USER_NAME => $this->get_sso_psn_name(), 	// 名稱       
                                    self::DEPT_CODE => $this->get_sso_dept_code(), 	// 單位編號    
                                    self::DEPT_NAME => $this->get_sso_dept_name(), 	// 單位名稱                                                                                           
                                    self::LOGIN_TIME => date('Y-m-d H:i:s'),    // 登入時間
                                    self::USER_ROLE => "U"	        // 角色  user_role 更動  mana_ty
                                    											// mana_ty 20180118討論管理者權限不同，登入情況不同
                             );                
                $this->session->set_userdata($user_info);
                return TRUE;        	
        }else{       	
        
	        //1.資料表查詢
	        $this->load->model('User_model');
	        $user = $this->User_model->get_by_id($account);  //user_id 更動  account
	        if($user) {
	
	        	//SSO
	        	//if($this->sso_islogin()){
	        	//非SSO   
	        	//2.密碼比對     	
				if (
					trim($user->password) === $password) {  //$user->passwd更動為password
	            	//3.驗証成功，session記錄              
	                $user_info = array(
	                                    self::USER_ID => $account,          	    // 身分證字號  //user_id 更動  account 
	                                    self::USER_NAME => $user->name,       		// 名稱          //user_name 更動  name
	                                    self::DEPT_CODE => '00000000', 	// 單位名稱
	                                    self::DEPT_NAME => $user->dept_name, 	// 單位名稱                                                                                                 
	                                    self::LOGIN_TIME => date('Y-m-d H:i:s'),    // 登入時間
	                                    self::USER_ROLE => $user->mana_ty	        // 角色  user_role 更動  mana_ty
	                                    											// mana_ty 20180118討論管理者權限不同，登入情況不同
	                             );                
	                $this->session->set_userdata($user_info);
	                return TRUE;
	            }
	        }
	       
	    }
 		return FALSE;
        
    }
    
}