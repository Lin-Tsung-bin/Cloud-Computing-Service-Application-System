<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * EX13-Select Service 通知信寄送
 * @author 吳珮菁
 */
class sendmail extends CI_Controller {    //ex13 to sendmail

	public function index($msg = '') {
		$this -> load -> layout('sendmail/index', '');   //ex13 to sendmail
	}
	/**
	 * 發信
	 */
	public function mail() {

		$where = array();
		$where_str = '';
		$auth_where = '';
		$out = array('success' => 'F', 'msg' => '');
		$field=array('receiver','sender','title','content');
		$data=$this->input->post_parameters($field);
		$data['content']=trim($data['content']);
		$data['content'] = preg_replace('/\s(?=\s)/', '',$data['content']);
		$data['content'] = preg_replace('/[\n\r\t]/', ' ',$data['content']);	 	
		$data['content'] =str_replace("@@@@@","&", $data['content'] );
		//檔案路徑
		$file_path='/home/10107006/public_html/learn/uploads/';   //file_path   
		        
		//檢查檔案大小，總大小不可超過 500kb
		$upload_file = $this -> session -> userdata('upload');
		$has_file = false;
		if (isset($upload_file['file_size'])) {
			$has_file = true;
			$total_size = 0;
			foreach ($upload_file['file_size'] as $row) {
				$total_size += $row;
			}
		}
		

		if ($has_file && $total_size > 500) {
			$out['msg'] = "夾帶檔案總和請勿超過500KB，目前總計" . $total_size . "KB";
			//2. 檢查主旨
		} else if (!$data['title']) {
			$out['msg'] = "未填寫主旨";
			//3. 檢查內文
		} else if (!$data['content']) {
			$out['msg'] = "未填寫內文";
			//4. 檢查單位
		} else if (!$data['receiver']) {
			$out['msg'] = "未填寫收件者";
			//4. 檢查單位
		}else if (!$data['sender']) {
			$out['msg'] = "未填寫寄件者";
			//4. 檢查單位
		} else {
		
			$this->load->helper('encode');	
	    	$this->load->library('email');	    	
	    	$this->email->initialize($this->config->item('mail_setting'));		
	    	$this->email->set_mailtype("html");		
			$this->email->clear(TRUE);	
			$this->email->from($data['sender']);
			$this->email->to($data['receiver']);
			$this->email->subject(utf8_to_big5($data['title']));			
			$this->email->message(utf8_to_big5($data['content']));
			
			if(!empty($upload_file)){
				foreach($upload_file['file_name'] as $row){
					$this->email->attach($file_path.$row);
				}	
			}
			$send_rtn=$this->email->send();

			if($send_rtn){
				$out['success'] = 'T';	
				$out['msg'] = '發送成功!';	
			}else{
				$out['msg'] = "發送失敗!";	
			}
		}
		die(json_encode($out));
	}
	
	/*
	 * 檔案上傳
	 */
	public function do_upload() {

		$upload = array('status' => 0, 'msg' => '');
		$config = $this -> config -> item('upload_setting');
		$this -> load -> library('upload', $config);
		$out['upload'] = $this -> session -> userdata('upload');

		if (!$this -> upload -> do_upload('userfile')) {

			$out['upload']['status'] = '-1';
			$out['upload']['msg'] = $this -> upload -> display_errors();

		} else {

			$out['upload']['status'] = '1';
			$out['upload']['msg'] = '';
			$file_info = $this -> upload -> data();
			//檔名
			// $out['upload']['file_name'][]=$file_info['file_name']."(".$file_info['file_size']."KB)";
			$out['upload']['file_name'][$file_info['file_name']] = $file_info['file_name'];
			//尺吋大小
			$out['upload']['file_size'][$file_info['file_name']] = $file_info['file_size'];

		}
		$this -> session -> set_userdata($out);
	}
	/*
	 * 檢查檔案上傳狀態
	 */
	public function check_upload_status() {
		$upload = array('status' => 0, 'msg' => '');
		if ($this -> session -> userdata('upload')) {
			die(json_encode($this -> session -> userdata('upload')));
		} else {
			die(json_encode($upload));
		}
	}

	/*
	 * 檔案刪除
	 */
	public function delete_file() {
		$upload = $this -> session -> userdata('upload');
		$file_name = $this -> input -> post('file', true);
		if (isset($upload)) {
			unset($upload['file_name'][$file_name]);
			unset($upload['file_size'][$file_name]);
			$data['upload']['file_name'] = ($upload['file_name']);
			$data['upload']['file_size'] = ($upload['file_size']);
			$this -> session -> set_userdata($data);
		}
		die(json_encode($this -> session -> userdata('upload')));
	}
	public function send(){
		$this->load->helper('encode');	
		$this->load->library('email');	    	
    	$this->email->initialize($this->config->item('mail_setting'));		
    	$this->email->set_mailtype("html");		
		$this->email->clear();	
		$this->email->from('z10107006@email.ncku.edu.tw');
		$this->email->to('peiching@mail.ncku.edu.tw');
		$this->email->subject(utf8_to_big5("測試"));			
		$this->email->message(utf8_to_big5("測試內文"));
		
		$attach_filename = big5_to_utf8("/home/10107006/public_html/learn/uploads/測試.jpg");
		//echo base64_encode($attach_filename);
		//$attach_filename = sprintf('=?big5?b?%s?=', base64_encode($attach_filename));  //無檔
		//$attach_filename = sprintf('=?big5?b?%s?=', $attach_filename);                   //無檔
		//$attach_filename = sprintf('=?big5?b?%s?=', big5_to_utf8($attach_filename));     //無檔
		//$attach_filename = sprintf('=?big5?b?%s?=', utf8_to_big5($attach_filename));       //無檔3
		//$attach_filename = sprintf('=?utf8?b?%s?=', ($attach_filename));       //無檔
		//$attach_filename = $attach_filename;       //無檔
		$this->email->attach($attach_filename);
	
		$send_rtn=$this->email->send();

		if($send_rtn){
			
			echo 'success!';	
		}else{
			echo "error!";	
		}
	}




}
