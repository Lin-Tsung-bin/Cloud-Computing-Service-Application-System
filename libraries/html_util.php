<?php
class Html_util {
    
    public function show_options_by_kv($options, $default=FALSE) {
        foreach($options as $k=>$v) {
            echo '<option value="'.$k.'"';
            if ($k === $default) {
                echo ' selected="selected"';
            }
            echo '>'.$v.'</option>';
        }
    }
    public function show_options_by_array($options, $default=FALSE) {
        foreach($options as $v) {
            echo '<option value="'.$v.'"';
            if ($v === $default) {
                echo ' selected="selected"';
            }
            echo '>'.$v.'</option>';
        }
    }
}