<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mana_filter extends Filter {
    var $CI;
    public function __construct($config = array()) {
        log_message('debug', 'Auth_filter Class Initialized');
        parent::Filter($config);
    }
    
    function before() {
        $this->CI = &get_instance();
        $this->CI->load->service('Auth_service');

        // 判斷是否
        if ( ! $this->CI->Auth_service->get_user_role()!='A') {
			header('Content-Type: text/html; charset=utf-8');
            die('您無權使用本程式');           
        }
    }
}

?>