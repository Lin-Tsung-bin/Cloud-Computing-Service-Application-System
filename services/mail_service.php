<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_service extends NF_Service {
    
       
      private $config = array(      'protocol' =>  'smtp',
                                    'smtp_host' =>  'email.ncku.edu.tw',
//                                  'smtp_user' =>  '',
//                                  'smtp_pass' =>  '',
                                    'smtp_port' =>  '25',
                                    'smtp_timeout' =>  '5',
                                    'charset' => 'utf-8',
                                    'newline' =>  "\r\n",
                                    'crlf' =>  "\r\n");
    public function __construct() {
    	
        log_message('debug', "Mail_service Class Initialized");
        
    }
    
    /**
     * 寄信
     * @param $code 使用程式
     * @param array() $to
     * @param 新增一個replace array or ?  讓某些變數可以取代
     */
    public function mail_info($code, $to, $replace){
	    $this->load->model('Cfg_mail_model');
		$mail = $this->Cfg_mail_model->get_by_code($code);
    	
    	$this->load->library('email');
    	
    	$this->email->initialize($this->config);
    	$this->email->set_mailtype("html");
		//mail_id, mail_code, mail_content, subject, mail_from, mail_bcc 
		$this->email->from($mail->mail_from);
		$this->email->to($to);
		//$this->email->bcc(explode(",", $mail->bcc));		
		$this->email->subject($mail->subject);
		
		$msg = $this->load->view('email/' . $code . ".php", $replace, true);
		$this->email->message($msg);
		
	
		$this->email->send();
    
    }
    
    public function replace_content($content, $replace){
    
	    foreach ($replace as $key => $value) {
	    	$content = str_replace("%".$key."%", $value, $content);
		}		
		return  $content;
    
    }
    
    public function ncku_mail($from,$to,$subject,$cotent,$bcc=array()){
    	   	 
    	$this->load->library('email');    	 
    	$this->email->initialize($this->config);
    	$this->email->set_mailtype("html");    	
    	$this->email->from($from);
    	$this->email->to($to);
    	$this->email->bcc($bcc);
    	$this->email->subject($subject);   	
    	$msg = $cotent;
    	$this->email->message($msg);	
    	$this->email->send();
    	log_message('debug', $this->email->print_debugger());
//     	echo $this->email->print_debugger();
    }
    
    
    
}