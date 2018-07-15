<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // 避免直接連結
/**
* Ex12 GRID維護
* @author 吳珮菁
*
*/
class Sign_in extends NF_Controller {
	// 1.基礎設定
	private $code_name = 'sign_in'; // 程式編號
	private $dir_name = ''; // 子目錄 (ex: exam/)
	
	// 2.Model相關設定
	private $model_setting = array (
			'model' => 'Mis_member_model',           // Model名稱		
			'add_one' => 'add_member',           // 新增單筆資料	
			'get_page'  => 'get_memberpage',         // 取分頁資料
			'add_one'   => 'add_member',             // 新增資料
			'upd_one'   => 'upd_member',             // 更新資料
			'del_one'   => 'del_member',             // 刪除資料    
			'get_one'   => 'get_member',             // 取資料  
			'get_all'   => 'get_member_all',         // 取資料多筆   		 		
			
			'key_field'=>array ("idno"),         // 主鍵
			'edit_info' => array (              
					'update_date' => 'upddate',  // 更改日期20130917
					'update_time' => 'updtime',  // 更改時間15:10:15			
					'update_ip'   => 'updip'     // 更改IP
			)

	);
    private $sort_item='idno';
	private $sort_method='asc';
	// 3.資料表相關設定
	/*
	  'chi_name'=>'欄位中文名稱'
	  'grid'    => array('width'=>100)                      //欄位寛度
	            => false                                    //於grid不使用
	 
	  'form'    => array('editable' => ('00'|'10'|'11')     //新增/修改時的顯示方式(input(1)|div(0))
	                                     00                 //新增不可編輯  &  修改不可編輯    (如更新日期、時間)  
	                                     10                 //新增可編輯      &  修改不可編輯   (如身份別)          
	                                     11                 //新增可編輯      &  修改可編輯       (一般維護欄位)
	                     'initial'   =>'初始值'
	                     )      
	            =>false                                     //於FROM不使用
	                                                                             
      'query'   => array('textcase'   => ('toUpperCase'|'toLowerCase')                  //大小寫轉換
		                 'defaultval' => array(                                         //預設查詢項
	                                        array('type'=>'關係','value'=>'查詢值')
	                                     )
	            =>false                                    //於query不使用
	 
	  'validate' =>  //以「|」連結，如required|interger|min_length[3]
					required         必填
	                integer          整數數字
	                numeric          數字
	                valid_email      信箱
	                min_length[3]    最小長度
	                max_length[5]    最大長度
	
	*/
	private $show_field = array (
			'psn_code' => array (
					'chi_name' => '帳號',
					'grid'     => array('width'=>200),
					'form'     => array('editable'=>'10'),              
					'query'    => array('textcase'=> 'toUpperCase',									
										'allowtype'=>array('equal','not_equal')
													
								 ),
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),


	);
	function __construct() {
		parent::__construct ();
		$this->load->service('grid_service');
		$this->load->service ('data_service' );
		$this->load->helper('encode');		
	}
	//維護主頁-預設空白grid
  	public function index()
    {

		
    	//準備要送至view參數
    	$param_field=array('code_name','dir_name','show_field');
    	foreach($param_field as $row){
    		$param[$row]=$this->$row;
    	}
		$msg='';
  		if($_POST){
  			$psn_code=strtoupper($this->input->post('psn_code'));
  			$passwd=$this->input->post('passwd');
			
			if($psn_code && $passwd){
				$p = '/^[A-Za-z0-9]{6,12}$/';
				$isPSNCODE = preg_match($p,$psn_code);
				if(!$isPSNCODE){
					$msg="帳號格示錯誤";				
				}else{
					$this->load->model('Allncku_model');
					$this->load->model('Signin_model');
					$data=$this->Allncku_model->get_member(array('psn_code'=>$psn_code));
					if($data){
						if(trim($passwd)===trim($data->passwd)){						
							$add_data['psn_code']=$psn_code;
							$add_data['psn_name']=$data->psn_name;
							$add_data=$this->data_service->add_editinfo($add_data,$this->model_setting['edit_info']);				
							$rtn=$this->Signin_model->add_signin($add_data);
							if($rtn['success']){
								$msg='登錄成功';
							}else{
								$msg='登錄失敗';
							}
						}else{
							$msg="密碼錯誤";	
						}
					}else{
						$msg="查無資料";
					}
				}
			}else{
				$msg="帳號或密碼未填";
			}
			
  		}
		$param['msg']=$msg;
    	$this->load->view($this->dir_name.$this->code_name.'/index',$param);    	
    }

} 
