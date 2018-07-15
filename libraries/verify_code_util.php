<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Verify_code_util {
    const DEFAULT_SESSION_NAME = "_verifyCode";
    
    var $CI;
    var $width = 62;
    var $height = 20;
    var $length = 4;
    var $distribute = 64;
    var $foreground = array(0, 0, 0); // R, G, B
    var $background = array(210, 210, 210); // R, G, B
    
    function __construct() {
        $this->CI =& get_instance();
        srand((double)microtime()*1000000);
    }
    /**
     * 產生數字驗證碼，並將驗證碼存放至session。
     * @param $sessionName
     * @return 驗證碼字串。
     */
    function generateNumCode($sessionName=self::DEFAULT_SESSION_NAME) {
        $verifyCode = '';
        for ($i=0; $i<$this->length; $i++) {
            $verifyCode .= chr(rand(48, 57));    
        }
        $this->CI->session->set_userdata($sessionName, $verifyCode);
        return $verifyCode;
    }
    /**
     * 以MD5產生字串後，再依長度取出驗證碼，並將驗證碼存放至session。
     * @param $sessionName
     * @return 驗證碼字串。
     */
    function generateMd5Code($sessionName=self::DEFAULT_SESSION_NAME) {
        $verifyCode = strtoupper(substr(md5(rand()),0, $this->length));
        $this->CI->session->set_userdata($sessionName, $verifyCode);
        return $verifyCode;
    }
    /**
     * 取得驗證碼
     * @param  $sessionName
     */
    function getVerifyCode($sessionName=self::DEFAULT_SESSION_NAME) {
         return $this->CI->session->userdata($sessionName);
    }
    /**
     * 將驗證碼產生圖片。
     * @return Image
     */
    function createImage($verifyCode) {
        $im = imagecreate($this->width, $this->height);
        $fg = $this->foreground;
        $bg = $this->background;
        $fgColor = ImageColorAllocate($im, $fg[0], $fg[1], $fg[2]);
        $bgColor = ImageColorAllocate($im, $bg[0], $bg[1], $bg[2]);
        
        imagefill($im, 0, 0, $bgColor);          // 背景顏色
        imagestring($im, 5, 10, 3, $verifyCode, $fgColor);  // 將驗證碼繪入圖片
        
       for($i=0;$i<$this->distribute;$i++) { // 加入雜點
            $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);
        }
        return $im;
    }
    /**
     * 輸出驗證碼圖片。
     */
    function outputVerifyCode() {
        Header("Content-type: image/PNG");
        $verifyCode = $this->generateNumCode();
        $im = $this->createImage($verifyCode);
        ImagePNG($im); 
        ImageDestroy($im); 
    }
    /**
     * 驗證輸入的驗證碼是否正確。
     *
     * @param $code
     * @param $sessionName
     * @return true | false
     */
    function verify($code, $sessionName=self::DEFAULT_SESSION_NAME) {
        $check = $code == $this->CI->session->userdata($sessionName);
        $this->CI->session->unset_userdata($sessionName);
        return $check;
    }
}
