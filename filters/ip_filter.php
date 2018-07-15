<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ip_filter extends Filter {
    var $CI;
    var $allow_ip;
    public function __construct($config = array()) {
        log_message('debug', 'Ip_filter Class Initialized');
        parent::Filter($config);
        $this->allow_ip = $config['allow_ip'];
    }

    function before() {
        $this->CI = &get_instance();
        //echo $this->CI->input->ip_address();;
        if (is_array($this->allow_ip)) {
            $client_ip = $this->CI->input->ip_address();
            foreach($this->allow_ip as $ip) {
                if (strpos($client_ip, $ip) !== FALSE) {
                    return;
                }
            }
        }
        exit($this->CI->input->ip_address(). ' Not allow access!');
    }
}

?>