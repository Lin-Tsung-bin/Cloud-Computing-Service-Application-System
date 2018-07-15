<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Privacy_util {
    var $privacy_map = array('tele'=>array('a', 'A'), 'mobile'=>array('b', 'B'), 'addr'=>array('c', 'C'), 'email'=>array('d', 'D'), 'fax'=>array('e', 'E'));
    
    public function parse_privacy($private_set) {
        
        $privacy = array();
        foreach($this->privacy_map as $k=>$v) {
            $privacy['privacy_'.$k] = '';
            foreach($v as $p) {
                if (strpos($private_set, $p) !== FALSE) {
                    $privacy['privacy_'.$k] = $p;
                    break;
                }
            }
        }
        return $privacy;
    }
    
    public function check_classmate($privacy, $field) {
        if (isset($privacy['privacy_'.$field]) && isset($this->privacy_map[$field])) {
            $values = $this->privacy_map[$field];
            return $privacy['privacy_'.$field] == $values[0] || $privacy['privacy_'.$field] == $values[1];
        }
        return FALSE;
    }
    
    public function check_all($privacy, $field) {
        if (isset($privacy['privacy_'.$field]) && isset($this->privacy_map[$field])) {
            $values = $this->privacy_map[$field];
            return $privacy['privacy_'.$field] == $values[1];
        }
        return FALSE;
    }
}