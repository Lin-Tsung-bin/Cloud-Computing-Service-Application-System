<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // 避免直接連結
/**
* Ex12 GRID維護
* @author 吳珮菁
*
*/

class Cloud12111 extends NF_Controller {
	// 1.基礎設定
	private $code_name = 'cloud12111'; // 程式編號
	private $dir_name = ''; // 子目錄 (ex: exam/)
	
	// 2.Model相關設定
	private $model_setting = array (
			'model'     => 'Cloud_apply_model',     // Model名稱		
			'add_one'   => 'add_cloud',             // 新增單筆資料	
			'get_page'  => 'get_cloudpage',         // 取分頁資料
			'add_one'   => 'add_cloud',             // 新增資料
			'upd_one'   => 'upd_cloud',             // 更新資料
			'del_one'   => 'del_cloud',             // 刪除資料    
			'get_one'   => 'get_cloud',             // 取資料  
			'get_all'   => 'get_cloud_all',         // 取資料多筆   		 		
			
			'key_field'=>array ("apply_id"),        // 主鍵
			'edit_info' => array (         
			/*	  
			        'update_date'     => 'update_datetime',  // 更改日期20130917
				  //'update_time'     => 'updtime',          // 更改時間15:10:15
				    'update_datetime' => 'update_ip'         // 更改IP
				  //'update_member'   => 'update_psncode'    //更新人員證號
				    'update_id'       => 'update_psnname',   // 更改使用者   
			*/	
			        'update_datetime' => 'update_datetime',  // 更改日期20130917
				    'update_id'       => 'update_psncode',   // 更改使用者
				    'update_ip'       => 'update_ip'   		 // 更改IP
			
			)

	);
    private $sort_item='apply_id';  //idno
	private $sort_method='desc';
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

			'apply_id' => array (
					'chi_name' => '表單編號',
					'grid'     => array('width'=>100),
					'form'     => array('editable'=>'00'), 
            		'query'    => false,
					/* 'query'    => array('textcase'=> 'toUpperCase',									
										'allowtype'=>array('equal','not_equal')
									   ),*/
				  //'validate'=>'',   //要註解，會錯誤
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
			
			'register_psncode' => array (
					'chi_name' => '登錄者證號',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
					/* 'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ), */
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
			
			'register_psnname' => array (
					'chi_name' => '登錄者姓名',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),	
		
			'register_deptcode' => array (
					'chi_name' => '登錄者單位編號',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),	
			
			'register_deptname' => array (
					'chi_name' => '登錄者單位名稱',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),				
			
			'register_datetime' => array (
					'chi_name' => '登錄日期時間',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
			
			'register_ip' => array (
					'chi_name' => '登錄日期IP',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),				
			
		   'apply_psncode' => array (
					'chi_name' => '申請人證號',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),
						
		   'apply_psnname' => array (
					'chi_name' => '申請人姓名',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'00','initial'=>'aaa'), 
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ),
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),

		   'apply_deptcode' => array (
					'chi_name' => '申請人單位編號',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00'),
					'query'    => false,
				  //'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),						
				
		   'apply_deptname' => array (
					'chi_name' => '申請人單位名稱',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'00'),   //20180212
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ),
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),
		
		   'apply_phone' => array (
					'chi_name' => '申請人電話',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),					
							
		   'apply_email' => array (
					'chi_name' => '申請人信箱',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => array('textcase'=> 'toUpperCase'),
					'validate'=>'required|valid_email',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),

		   'host_psncode' => array (
					'chi_name' => '單位/計畫主持人編號',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'host_psnname' => array (
					'chi_name' => '單位/計畫主持人姓名',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'11'), 
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ),
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	

		   'host_phone' => array (
					'chi_name' => '單位/計畫主持人電話',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	

		   'host_email' => array (
					'chi_name' => '單位/計畫主持人信箱',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ),
					'validate'=>'required|valid_email',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'host' => array (
					'chi_name' => '主機名稱',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'os' => array (
					'chi_name' => '作業系統',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'11'), 
					'query'    => array('queryType'=> 'dropdownlist',					
					                    'querySource' =>array(
					                                 array('name'=>"Windows",'value'=>"W"),					                                      
					                                 array('name'=>"Linux",'value'=>"L"),
													 array('name'=>"Other",'value'=>"O"),
												  ),
						             /* 'defaultval'=>array(
                                                          array('type'=>'equal','value'=>'W'),
                                                         // array('type'=>'less_equal','value'=>'M')
                                                       ), */
                                          ),
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	

			'version' => array (
					'chi_name' => '作業系統版本',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11','initial'=> ''), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
						
			'cpu' => array (
					'chi_name' => 'CPU核心',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	

			'ram' => array (
					'chi_name' => 'RAM',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
			'hardDisk' => array (
					'chi_name' => '本機硬碟',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00','initial'=> '100'),
					'query'    => false,
					'validate' => false,//'required',
					'export'   => array('excel'=>20,'pdf'=>40)	
			),	
			
			'addHardDisk' => array (
					'chi_name' => '增購本機硬碟空間',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate' => false,//'required',
					'export'   => array('excel'=>20,'pdf'=>40)	
			),	
			
			'disk_use' => array (
					'chi_name' => '加購本機硬碟空間方式',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11','initial'=> '1'), 
					'query'    => false,
					'validate' => 'required',
					'export'   => array('excel'=>20,'pdf'=>40)	
			),				
				
			'addNFSDisk' => array (
					'chi_name' => '增購NFS網路硬碟空間',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate' => false,//'required',
					'export'   => array('excel'=>20,'pdf'=>40)	
			),		
		
		   'start_date' => array (
					'chi_name' => '開始使用期間',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'end_date' => array (
					'chi_name' => '結束使用期間',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'period' => array (
					'chi_name' => '使用天數',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00', 'initial'=>'0'), 
					'query'    => false,
					'validate' => false,//'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
		   'applyItem' => array (
					'chi_name' => '申請項目',	
					'grid'     => array('width'=>120),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,             
					'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),					
			
		   'receipt' => array (
					'chi_name' => '收據抬頭',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
			'price' => array (
					'chi_name' => '金額',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00','initial'=>'0'), 
					'query'    => false,
					'validate' => false,//'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
			'discount' => array (
					'chi_name' => '折扣',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00','initial'=>'0'), 
					'query'    => false,
					'validate' => false,
					'export'   => array('excel'=>20,'pdf'=>40)	
			),
							
		    'number' => array (
					'chi_name' => '臺數',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00',
										'initial'=>'1'  //初始值:1台
										), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),	
			
			 'totalPrice' => array (
					'chi_name' => '總計新台幣',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'00','initial'=>'0'), 
					'query'    => false,
					'validate' => false,//'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),		
			
			'uses' => array (
					'chi_name' => '用途',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				 // 'validate' =>'required', 
					'export'   => array('excel'=>20,'pdf'=>40)	
			),		

			'ps' => array (
					'chi_name' => '備註',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				 // 'validate' =>'required',
					'export'   => array('excel'=>20,'pdf'=>40)	
			),		
						
			'VM_Client' => array (
					'chi_name' => 'VM-Client管理帳號	',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),		

			'VM_Password' => array (
					'chi_name' => 'VM-Client管理密碼',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),
			
			'ip' => array (
					'chi_name' => 'IP',	
					'grid'     => array('width'=>0),						
					'form'     => array('editable'=>'00','initial'=> ''), 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)	
			),		
			
			'status' => array (
					'chi_name' => '虛擬機器狀態',	
					'grid'     => array('width'=>150),							
					'form'     => array('editable'=>'11'), 		 
					'query'    => false,
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)						
			),			
														
			'is_paid' => array (
					'chi_name' => '付款狀態',
					'grid'     => array('width'=>100),			
				
					'form'     => array('editable'=>'00'), 
					'query'    => array('queryType'=> 'dropdownlist','initial'=> '', 
					
					                    'querySource' =>array(
 					                                 array('name'=>"處理中",'value'=>"D"),					                                      
					                                 array('name'=>"已開收據",'value'=>"E"),
													 array('name'=>"已入帳",'value'=>"F"),
									 				 array('name'=>"免收費",'value'=>"G"),
												  ),
						             /* 'defaultval'=>array(
                                                          array('type'=>'equal','value'=>'D'),
                                                         // array('type'=>'less_equal','value'=>'M')
                                                       ), */
                                         'allowtype'=>array('equal','not_equal','greater_equal','less_equal')                 
                                   ),
								 
				  //'validate'=>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
			
				
			'update_datetime' => array (
					'chi_name' => '更新日期時間',	
					'grid'     => array('width'=>0),							
					'form'     => array('editable'=>'11'), 
					'query'    => false, 
				  //'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
			
			'update_ip' => array (
					'chi_name' => '更新ip',	
					'grid'     => array('width'=>0),							
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				  //'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
								
			'update_psncode' => array (
					'chi_name' => '更新人員證號',	
					'grid'     => array('width'=>0),							
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				  //'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)
			),
						
			'update_psnname' => array (
					'chi_name' => '更新人員姓名',	
					'grid'     => array('width'=>0),							
					'form'     => array('editable'=>'11'), 
					'query'    => false,
				  //'validate' =>'required',
					'export'   =>array('excel'=>20,'pdf'=>40)			
			),
		
	);
	
	function __construct() {
		parent::__construct ();
		$this->load->model ( $this->model_setting ['model'] );
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
  
    	$this->load->layout($this->dir_name.$this->code_name.'/index',$param);    	
    }
    //變更grid內容:查詢、換頁、排序、新增/修改/刪除 操作成功後
    public function read()
    {
		
    	if($this->input->post()){
	        //(1) 基礎設定
			$model_setting = $this->model_setting;	
	    	//(3) 欄位排序
	    	$param['now_sort']='';
	    	$param['sort_info']='';    	
	    	if($this->input->post('sort_item')){
	            $sort_item=$this->input->post('sort_item');
	    	    $sort_method=$this->input->post('sort_method');
	    	}else{
	    	    $sort_item=$this->sort_item;
	    	    $sort_method=$this->sort_method;
	    	}	
	    	$order=$sort_item." ".$sort_method;
	    	$param['sort_item']=$sort_item;
	    	$param['sort_method']=$sort_method;
			//只接受特定欄位
			$field=array('item','value','type');
			$data=$this->input->post_parameters($field);
			//限查登錄者本人
			$data['item'][]='apply_psncode';
			$data['type'][]='equal';
			$data['value'][]=$this->Auth_service->get_user_id();
			
			/*[big5_db]使用
			foreach($data['item'] as $index=>$row){
				if($row!=''){
					$data['value'][$index]=utf8_to_big5($data['value'][$index]);
				}
			}
			*/
			
			//取查詢條件
			$query_info=$this->grid_service->get_query_info($data);	 
			//print_r($query_info);   	

			$query_info['order']=$param['sort_item']." ".$param['sort_method'];
			
			
	    	//(4) 資料查詢-以分頁方式顯示
	    	
			$page=($this->input->param('page'));
			$result=$this->$model_setting ['model']->$model_setting ['get_page'] ($query_info,$page);
    		//echo "<pre>";
    		//print_r($result);
    		//取得總頁數
    		$param['total_page'] = $this->page_util->total_page($result['count']);
    		//取得總筆數
    		$param['total_count']=$result['count'];			
	    	//查詢資料結果
	    	$param['data'] = $result['data'];
			
			//$rule=array('sex'=>array('M'=>'男','F'=>'女')	);
	        
	        $rule=array('is_paid'=>array('D'=>'處理中','E'=>'已開收據','F'=>'已入帳','G'=>'免收費'),
	        			//'disk_use'=>array('1'=>'與作業系統空間同一硬碟','2'=>'設定為第二顆硬碟'),
						'applyItem'=>array('A'=>'第一次使用','B'=>'續租','C'=>'擴充'),
						'os'=>array('W'=>'Windows','L'=>'Linux','O'=>'Other'),
						'status'=>array('0'=>'暫存','1'=>'送審中','2'=>'完成') //資料送審
			);  //20180105		
		
			$result['data']=$this->grid_service->code_replace($result['data'],$rule); //20180105
		
	    	//目前頁碼
	    	$param['current_page'] = $result['current_page'];
			//主鍵資訊
			$param['key_field']=$this->model_setting['key_field'];
			//欄位資訊
			$param['show_field']=$this->show_field;
			
			//總寬度(20140508 新增)
			$param['tot_width']=45;
			foreach($this->show_field as $row){
				if(isset($row['grid']['width'])){
					$param['tot_width']+=$row['grid']['width'];
				}
			}
	    	
			//(7) 傳結果給view		
			$this->load->view($this->dir_name.$this->code_name.'/grid',$param);
		}

    }
   
    //編輯對話框
    public function get()
    {

     //(1) 基礎設定
		$model_setting = $this->model_setting;
			
		if($this->input->post('mode')!='add'){
			$post_data = $this->input->post_parameters($model_setting['key_field']);		
			$row_data=$this->$model_setting ['model']->$model_setting ['get_one'] ($post_data);			
		}
	    	
		///  $this->show_field['apply_deptname']['form']['initial']="aaaa";  //20180212
		$this->show_field['apply_psnname']['form']['initial']=$this->Auth_service->get_user_name();
 		$this->show_field['apply_psncode']['form']['initial']=$this->Auth_service->get_user_id();	
		$this->show_field['apply_deptname']['form']['initial']=$this->Auth_service->get_dept_name();
		$this->show_field['apply_deptcode']['form']['initial']=$this->Auth_service->get_dept_code();
		$this->show_field['apply_phone']['form']['initial']=$this->Auth_service->get_office_phone();
				
	    foreach($this->show_field as $index=>$row){
	    	$value=""; 
			$value2=""; //
			$editable=false;   		
			 	
 			
			switch($this->input->post('mode')){
				case 'add':
					//載入預設值
					if(substr($row['form']['editable'], 0,1)){
	    				$editable=true;
	    			}else{
	    				$editable=false;
	    			}
					$value=(isset($row['form']['initial']))?$row['form']['initial']:"";	 
					$value2=(isset($row['form']['initial']))?$row['form']['initial']:"";	 //		 				
					break;

				case 'upd':
					if(isset($row['form']['editable'])){
						if(substr($row['form']['editable'], 1,1)){
			    			$editable=true;
		    			}else{
		    				$editable=false;
		    			}
						$value=$row_data->$index;
					}
					break;
				case 'look':
				case 'del':
					if(isset($row['form']['editable'])){
						$editable=false;
						$value=$row_data->$index;
					}
					break;
					
				case 'save':  //暫存								
					if(substr($row['form']['editable'], 1,1)){
	    				$editable=true;
	    			}else{
	    				$editable=false;
	    			}
					$value=(isset($row['form']['initial']))?$row['form']['initial']:"";	 
					$value2=(isset($row['form']['initial']))?$row['form']['initial']:"";	 				
					break;	
				
				case 'recover':  //回收
					if(substr($row['form']['editable'], 0,0)){
	    				$editable=true;
						$value=$row_data->$index;
	    			}		 				
					break;	
							
			}
			$rtn[]=array('name'=>$index,'editable'=>$editable,'value'=>trim($value));
		}

		die(json_encode($rtn));

    }
 
    //新增對話框-送出
    public function add()
    {
    	if($_POST){
    		$out=array('success'=>'F','msg'=>'');
 			$model_setting = $this->model_setting;	   			    	
	    	$validate_rtn = $this->grid_service->validate($this->input->post(),$this->show_field);
			
			// 需要驗証，但有格示錯誤
			if (!empty($validate_rtn)) {
				$out ['msg'] = $validate_rtn;
				$out ['error_type'] = 'validate';
			} else {

				foreach ( $this->show_field as $index => $row ) {
					// 新增時要處理的的欄位
					if (isset($row ['form']['editable']) && substr($row ['form']['editable'],0,1)=='1') {
						$fields [] = $index;
					}
				}
	    		//接收POST
			    $data = $this->input->post_parameters($fields);
				if ($this->input->post('upd_type')== 'send'){
					$data['status']='1';
				
				}else{
					$data['status']='0';
				}            
			 /* $data['hardDisk']  = isset($_POST['hardDisk'])  ? trim($_POST['hardDisk']) : null;  //20180204
				$data['period']  = isset($_POST['period'])  ? intval(trim($_POST['period'])) : NULL;  //20180204
				$data['discount']  = isset($_POST['discount'])  ? trim($_POST['discount']) : NULL;		  //20180204		
				$data['price']  = isset($_POST['price'])  ? trim($_POST['price']) : NULL;		  //20180204		
				$data['totalPrice']  = isset($_POST['totalPrice'])  ? trim($_POST['totalPrice']) : NULL;	  //20180204 */
				//$data['ip']  = isset($_POST['ip']) ? $_POST['ip'] : NULL;
				//$data['is_paid']  = isset($_POST['is_paid']) ? $_POST['is_paid'] : NULL; 
				$data['version'] = $this->input->post('version'); 
				$data['cpu'] = $this->input->post('cpu'); 
				$data['ram'] = $this->input->post('ram'); 
				$data['hardDisk'] = $this->input->post('hardDisk');	    //20180202
				$data['period'] = $this->input->post('period');	        //20180202
				$data['discount'] = $this->input->post('discount');	    //20180202
				$data['price'] = $this->input->post('price');	            //20180202
				$data['totalPrice'] = $this->input->post('totalPrice');	//20180202   
				$data['ip']  = $this->input->post('ip');
				$data['is_paid']  = $this->input->post('is_paid'); 
				$data['number'] = $this->input->post('number'); 
				$data['apply_psnname'] = $this->Auth_service->get_user_name();
		 		$data['apply_psncode'] = $this->Auth_service->get_user_id();	
				$data['apply_deptname'] = $this->Auth_service->get_dept_name();
				$data['apply_deptcode'] = $this->Auth_service->get_dept_code();
				$data['apply_phone'] = $this->Auth_service->get_office_phone();
				
	    		//資料處理
				//增加編輯資訊(人員,日期,時間,ip)
				$this->load->service('data_service');					
				$data=$this->data_service->add_editinfo($data,$model_setting['edit_info']);     
				$data['register_psncode']=$data['update_psncode'];     //20180202 登錄者證號
				$data['register_datetime'] = $data['update_datetime'];   //20180202 登錄日期時間
				$data['register_ip'] = $data['update_ip'];				 //20180202 登錄日期IP
				//$data['register_psncode'] = isset($_POST['update_psncode']) ? $_POST['update_psncode'] : NULL;
				//$data['register_datetime'] = isset($_POST['update_datetime']) ? $_POST['update_datetime'] : NULL;
				//$data['register_ip'] = isset($_POST['update_ip']) ? $_POST['update_ip'] : NULL;


				//20180202 增加
				$this->load->model('User_model');  
				$data['update_psnname']=$this->Auth_service->get_user_name();
				$data['register_psnname']=$data['update_psnname'];  //登錄者姓名, 更新人員姓名 		 

		     	$data['register_deptcode']=$this->Auth_service->get_dept_code();
				$data['register_deptname']=$this->Auth_service->get_dept_name(); 		//登錄者單位名稱				
				 
			//針對checkbox欄位處理，將勾選的項目值合成字串
				foreach($data as $index=>$row){
					if(is_array($row)){
						$data[$index]= implode("|",$row) ;
					}
				}
				
	    		//新增前條件:
	    		 
	    		//20180201 表單編號建立724-734
	    		//$data['apply_id']='1060800005';
				$this_mon =(date("Y")-1911).date("m");  // 目前-1911=民國年 , 連結(.), 月
				$serial_data = $this->Cloud_apply_model->get_serial($this_mon); // 讀取Cloud_apply_model --> model
				if(!$serial_data){
					$data['apply_id'] = $this_mon."00001";   //$this_mon."00001"目前年月+00001 = 表單編號(1060500001) ; $data['apply_id']:讀取sql-apply_id
				    alert($serial_data);
				}else{
					$max_serial = (int)$serial_data->max_apply_id;   // $serial_data int取整數傳回到max_apply_id
					$new_serial = (string)($max_serial+1);        // $max_serial+1取成字串
					 
					$data['apply_id'] = $this_mon.str_pad($new_serial,5,"0",STR_PAD_LEFT);
				    // printf($data['apply_id']);  //列印
					   
					// $data['apply_id'] = $this_mon.str_pad($new_serial,5,"0",STR_PAD_LEFT);  --> 20180201檢查出錯誤:產生107021070200002錯誤，超過10個字串;正確1070200002，要刪除'$this_mon.'
												//str_pad() 函數把字串填充為新的長度。
												//str_pad( string , length , pad_string , pad_type )
												//string: 必需。規定要填充的字符串。
												//length: 必需。規定新的字符串長度。如果該值小於字符串的原始長度，則不進行任何操作。
												//pad_string:可選。規定供填充使用的字符串。默認是空白。
												//pad_type: 可選。規定填充字符串的哪邊。 STR_PAD_RIGHT - 填充字符串的右側。
					}
				
	    		//新增資料
	    		$rtn=$this->$model_setting ['model']->$model_setting ['add_one'] ($data,$model_setting ['key_field']);
	    		
	    		//回傳結果
	    		if($rtn['success']){
	    			$out['success']='T';
	    			$out['msg']='新增成功!';
	    		}else{
	    			if($rtn['existed']){
	    				$out['msg']='資料已存在!';
	    			}else{
						/*取得錯誤訊息				
							$error_number=$this->$model_setting ['model']->get_error_number();
							$error_message=$this->$model_setting ['model']->get_error_message();
							$out['msg']='新增失敗!-'.$error_number.$error_message;
						*/		    				
						
	    			}
	    		}
	    		 
	    		 
	    	}	 
	    	   	
	    	die(json_encode($out));
    	}
    }
    
    //更新對話框-送出
    public function upd()
    {
    	if($_POST){
    		$out=array('success'=>'F','msg'=>'');
			$model_setting = $this->model_setting;	

	    	 
			$validate_rtn = $this->grid_service->validate($this->input->post(),$this->show_field);
			
			// 需要驗証，但有格示錯誤
			if (!empty($validate_rtn)) {
				$out ['msg'] = $validate_rtn;
				$out ['error_type'] = 'validate';
			} else {
	
				foreach ( $this->show_field as $index => $row ) {
					// 修改時要處理的的欄位
					if (isset($row ['form']['editable']) && substr($row ['form']['editable'],1,1)=='1') {
						$fields [] = $index;
					}
				}
		    	$data = $this->input->post_parameters($fields);
				if ($this->input->post('upd_type')== 'send'){
					$data['status']='1';
				
				}else{
					$data['status']='0';
				}
				
				
				//20180222判斷送審狀態
				//$data = $this->input->post_parameters($fields);										 	
	    		    	
	    		//資料處理
				//增加編輯資訊(人員,日期,時間,ip)
				$this->load->service('data_service');					
				$data=$this->data_service->add_editinfo($data,$model_setting['edit_info']);     			
				
				//針對checkbox欄位處理，將勾選的項目值合成字串
				foreach($data as $index=>$row){
					if(is_array($row)){
						$data[$index]= implode("|",$row) ;
					}
				}
				
				//以original參數做為key值
				foreach($model_setting['key_field'] as $row){
					$data[$row] = $this->input->post($row.'_original');
					
					//會upd到key的欄位，改放到$where array
					//$where[$row] = $this->input->post($row.'_original');
					
					if($data[$row]===false){
						$out['msg']='修改失敗-格示有誤 !';	
						die(json_encode($out));
					}					
				}
				$data['version'] = $this->input->post('version'); 
				$data['cpu'] = $this->input->post('cpu'); 
				$data['ram'] = $this->input->post('ram'); 
				$data['hardDisk'] = $this->input->post('hardDisk');	    //20180202
				$data['period'] = $this->input->post('period');	        //20180202
				$data['discount'] = $this->input->post('discount');	    //20180202
				$data['price'] = $this->input->post('price');	            //20180202
				$data['totalPrice'] = $this->input->post('totalPrice');	//20180202   
				$data['ip']  = $this->input->post('ip');
				$data['is_paid']  = $this->input->post('is_paid');	
				$data['number'] = $this->input->post('number'); 
		    	//更新前條件:(請務必判斷該筆資料登入者是否可以修改，以下為判斷範例提供參考)
		        /*
		    	$get_rtn=$this->$model_setting ['model']->$model_setting ['get_one'] (array('no'=>$data['no']));
				if(!$get_rtn){
					$out['msg']='修改失敗-條件有誤 !';	
					die(json_encode($out));		    
				}else if($get_rtn->create_user != $this->Auth_service->get_user_id()){
					$out['msg']='修改失敗-您無權修改此資料 !';	
					die(json_encode($out));			 
				}
		    	*/
				
	    		//transaction，確認受影響筆數為1---------------------------
				$this->db->trans_begin();
				//更新資料
	    		$rtn=$this->$model_setting ['model']->$model_setting ['upd_one'] ($data,$model_setting['key_field']);
				
				//會upd到key的欄位，改用以下這段  upd_one改用ci upd_member_ci
				//$rtn=$this->$model_setting ['model']->upd_member_ci($data,$where);
				//echo $this->db->last_query();
				
				if ($this->db->trans_status()==true && $rtn['success'] && $rtn['num']==1)
				{
					$this->db->trans_commit();
					$out['success']='T';
					if ($this->input->post('upd_type')== 'send'){
						$out['msg']='送審完成!';	
					}else{
						$out['msg']='修改完成!';	
					}	
		    			
				}
				else
				{    		    		
				    $this->db->trans_rollback(); 					
					if($rtn['success'] && $rtn['num']!=1){
						$out['msg']='修改失敗-影響筆數不為1筆 !';	
					}else if($rtn['msg']=='No data updated'){
						$out['msg']='修改失敗-修改條件查無資料!';	
					}else{
						/*取得錯誤訊息				
						$error_number=$this->$model_setting ['model']->get_error_number();
						$error_message=$this->$model_setting ['model']->get_error_message();
						$out['msg']='修改失敗!-'.$error_number.$error_message;
						*/	
						$out['msg']='修改失敗!';		
					}				   
				}
				//-------------------------------------------------		
	    	}
	    	
	    	die(json_encode($out));
	    
    	}
    }
	public function recover(){
		$apply_id = $this->input->post('apply_id');
			
		if($apply_id){
    		$out=array('success'=>'F','msg'=>'');
			$model_setting = $this->model_setting;
			$data = array('apply_id'=>$apply_id,'status'=>'0');				
			$rtn=$this->$model_setting ['model']->$model_setting ['upd_one'] ($data,array('apply_id'));
			
			//會upd到key的欄位，改用以下這段  upd_one改用ci upd_member_ci
			//$rtn=$this->$model_setting ['model']->upd_member_ci($data,$where);
			//echo $this->db->last_query();
			
			if ($this->db->trans_status()==true && $rtn['success'] && $rtn['num']==1)
			{
				$this->db->trans_commit();
				$out['success']='T';
				$out['msg']='回收完成!';	
			
	    			
			}
			else
			{    		    		
			    $this->db->trans_rollback(); 					
				if($rtn['success'] && $rtn['num']!=1){
					$out['msg']='修改失敗-影響筆數不為1筆 !';	
				}else if($rtn['msg']=='No data updated'){
					$out['msg']='修改失敗-修改條件查無資料!';	
				}else{
					/*取得錯誤訊息				
					$error_number=$this->$model_setting ['model']->get_error_number();
					$error_message=$this->$model_setting ['model']->get_error_message();
					$out['msg']='修改失敗!-'.$error_number.$error_message;
					*/	
					$out['msg']='修改失敗!';		
				}				   
			}
			die(json_encode($out));			
		}
	}
	public function directsend(){
		$apply_id = $this->input->post('apply_id');
			
		if($apply_id){
    		$out=array('success'=>'F','msg'=>'');
			$model_setting = $this->model_setting;
			$data = array('apply_id'=>$apply_id,'status'=>'1');				
			$rtn=$this->$model_setting ['model']->$model_setting ['upd_one'] ($data,array('apply_id'));
			
			//會upd到key的欄位，改用以下這段  upd_one改用ci upd_member_ci
			//$rtn=$this->$model_setting ['model']->upd_member_ci($data,$where);
			//echo $this->db->last_query();
			
			if ($this->db->trans_status()==true && $rtn['success'] && $rtn['num']==1)
			{
				$this->db->trans_commit();
				$out['success']='T';
				$out['msg']='送審完成!';	
			
	    			
			}
			else
			{    		    		
			    $this->db->trans_rollback(); 					
				if($rtn['success'] && $rtn['num']!=1){
					$out['msg']='送審失敗-影響筆數不為1筆 !';	
				}else if($rtn['msg']=='No data updated'){
					$out['msg']='送審失敗-修改條件查無資料!';	
				}else{
					/*取得錯誤訊息				
					$error_number=$this->$model_setting ['model']->get_error_number();
					$error_message=$this->$model_setting ['model']->get_error_message();
					$out['msg']='修改失敗!-'.$error_number.$error_message;
					*/	
					$out['msg']='送審失敗!';		
				}				   
			}
			die(json_encode($out));			
		}
	}   
    //刪除-送出
    public function del(){
    	if($_POST){
	    	$out=array('success'=>'F','msg'=>'');
			$model_setting = $this->model_setting;	
	    	
			//以original參數做為key值
			foreach($model_setting['key_field'] as $row){
				$data[$row] = $this->input->post($row.'_original');
				if($data[$row]===false){
					$out['msg']='刪除失敗-格示有誤!';	
					die(json_encode($out));
				}
			}
	    	//刪除前條件:(請務必判斷該筆資料登入者是否可以刪除，以下為判斷範例提供參考)
	        /*
	    	$get_rtn=$this->$model_setting ['model']->$model_setting ['get_one'] ($data);
			if(!$get_rtn){
				$out['msg']='刪除失敗-條件有誤 !';	
				die(json_encode($out));		    
			}else if($get_rtn->create_user != $this->Auth_service->get_user_id()){
				$out['msg']='刪除失敗-您無權刪除此資料 !';	
				die(json_encode($out));			 
			}
	    	*/   	
			
			//transaction，確認受影響筆數為1---------------------------
			$this->db->trans_begin();
			//更新資料
			$rtn=$this->$model_setting ['model']->$model_setting ['del_one'] ($data);
	
			if ($this->db->trans_status()==true && $rtn['success'] && $rtn['num']==1)
			{
				$this->db->trans_commit();
				$out['success']='T';
	    		$out['msg']='刪除成功!';	
			}
			else
			{    		    		
			    $this->db->trans_rollback(); 					
				if($rtn['success'] && $rtn['num']!=1){
					$out['msg']='刪除失敗-影響筆數不為1筆 !';	
				}else{
					/*取得錯誤訊息				
					$error_number=$this->$model_setting ['model']->get_error_number();
					$error_message=$this->$model_setting ['model']->get_error_message();
					$out['msg']='刪除失敗!-'.$error_number.$error_message;
					*/	
					$out['msg']='刪除失敗!';		
				}				   
			}
			//-------------------------------------------------					  	
	    	die(json_encode($out));
	    } 
    }
	/*
	 * Excel下載
	 */
    public function export_excel() {
	//	error_reporting(0);
		//1.參數設定
		$excel_font          ='M';  	 //excel字體    
		$excel_fname         ='report';     //下載檔名 report
		
	    //(1) 基礎設定
		$model_setting = $this->model_setting;
		//(3) 欄位排序
    	$param['now_sort']='';
    	$param['sort_info']='';    	
    	if($this->input->get('sort_item')){
            $sort_item=$this->input->post('sort_item');
    	    $sort_method=$this->input->post('sort_method');
    	}else{
    	    $sort_item=$this->sort_item;
    	    $sort_method=$this->sort_method;
    	}	
    	$order=$sort_item." ".$sort_method;
    	$param['sort_item']=$sort_item;
    	$param['sort_method']=$sort_method;
		//只接受特定欄位
		$field=array('item','value','type');
		$data=$this->input->get_parameters($field);
		/*[big5_db]使用
		foreach($data['item'] as $index=>$row){
			if($row!=''){
				$data['value'][$index]=utf8_to_big5($data['value'][$index]);
			}
		}
		*/		
		//取查詢條件
		$query_info=$this->grid_service->get_query_info($data);	    	

		$query_info['order']=$param['sort_item']." ".$param['sort_method'];

		  	
		//2.資料查詢		
		$data=$this->$model_setting ['model']->$model_setting ['get_all'] ($query_info['where']); 


		//3.設定欄位名稱
		$show_field=$this->show_field;
		
		//4.Excel製作
		// (1)載入Excel函式庫
		$this->load->library("PHPExcel");
		 
		// (2)建立PHPExcel物件
		$objPHPExcel = new PHPExcel();
		 
		// (3)新增一個sheet
		$objPHPExcel->createSheet();
		// (4)設定目前要編輯的sheet index
		$objPHPExcel->setActiveSheetIndex(0);
		// (5)取得目前active sheet
		$new_sheet =  $objPHPExcel->getActiveSheet();
		
		
		// (6)字型設定
		if($excel_font=='M'){
			$objPHPExcel->getDefaultStyle()->getFont()->setName('新細明體');
		}else{
			$objPHPExcel->getDefaultStyle()->getFont()->setName('標楷體');
		}		 
		// (7)sheet名稱
		$new_sheet->setTitle("report");
		
		// 設定表頭
		// $new_sheet->SetCellValue('A1', '主標題');
		// 欄位合併
		// $new_sheet->mergeCells('A2:I2');
		 
		 
		//資料要開始的列
		$rowIndex=1; 
		
		//設寬度
		$new_sheet->getColumnDimension('A')->setWidth('7');
		$ch=1; 
		foreach($show_field as $index=>$row) {
			//取得欄位寬度
			$col_width=$row['export']['excel'];
			if($col_width>0){
				//設定欄位寬度
				$new_sheet->getColumnDimensionByColumn($ch)->setWidth($col_width);
			
				$ch++;
			}
		}
		
		
		
		//第一列:設定欄位標題
		$ch=1; //B
		foreach($show_field as $index=>$row) {
			//取欄位寬度			
			$col_width=$row['export']['excel'];
			//寬度>0，表示此欄位要顯示
			if($col_width>0){     
				$colNo=1;
				//取欄位中文名稱(chi_name)	    
				$chi_name = $row['chi_name'];         
				if($colNo==1){
					$new_sheet->SetCellValue('A'.$rowIndex, '序號');
				}
				$new_sheet->setCellValueByColumnAndRow($ch, $rowIndex,$chi_name);			
				$ch++;
			}
		}
		
		//第二列
		$rowIndex++;
		//資料序號
		$seqNo=1;
		//開始放DB查到的資料
		if($data){
			foreach($data as $index=>$row) {
				//欄位序號
				$colNo=1;
				
				$ch=1;  //B				
				// 依序將資料填入對應的位置
				foreach($show_field as $col_index=> $col) {
					$col_width=$col['export']['excel'];
					//寬度>0，表示此欄位要顯示
					if($col_width>0){     
						$value = $row->$col_index;						
						if($colNo==1){
							//(A2,A3,A4...)放上資料序號
							$new_sheet->SetCellValue('A'.$rowIndex, $seqNo);						
						}
						//特別字串處理
						if($col_index=='apply_id'){   //20180104 idno
							//字串格示					
							$new_sheet->setCellValueExplicitByColumnAndRow($ch, $rowIndex,$value, PHPExcel_Cell_DataType::TYPE_STRING);
						}else{
							$new_sheet->setCellValueByColumnAndRow($ch, $rowIndex,$value);	 
						}						   				
						$ch++;
						$colNo++;
					}    				 
				}
				$rowIndex++;
				$seqNo++;
			}
		}
		
		//畫框線
		for($i=0;$i<=count($show_field);$i++){
			for($j=1;$j<$rowIndex;$j++){
				$thiscell=$new_sheet->getStyleByColumnAndRow($i,$j);
				$thiscell->getAlignment()->setWrapText(true);
				//取得全部border，設定框線格示
				$thiscell->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );				
						
			}
		}
		
		// 由瀏覽器下載
		//2007格示
		// header('Content-Type: application/vnd.ms-excel');
		// header("Content-Disposition: attachment;filename=".$excel_fname.".xlsx");
		// header('Cache-Control: max-age=0');		
		// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		// $objWriter->save("php://output");		
	
		//2003格示
		header('Content-Type: application/vnd.ms-excel');			
		header('Cache-Control: max-age=0');
		header("Content-Disposition: attachment;filename=".$excel_fname.".xls");
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save("php://output");

	}	
    public function export_pdf() {   //20180119 - 1084至1134 另外弄成一個project
    	ob_start();
    	error_reporting(0);
    	//1.參數設定
    	$pdf_fname='CloudServices';                 // pdf下載檔名			
		$pdf_orientation='P';                       // PDF方向  P:直向 L:橫向
		$pdf_download='D';                          // F:存在server端   D:由瀏覽器下載	 I:由瀏覽器開檔		
		$pdf_download_path="/tmp/";                 // S:存在server端  目錄路徑
		$pdf_fontsize='12';                         // 字型大小
		$pdf_page_cnt='43';                         // 每頁顯示資料數
		$pdf_cell_height='7';                       // cell高度
		$pdf_font='K';                              // PDF 字體　　M:新細明體　　K:標楷體
		$col_width='180';

	    //(1) 基礎設定
		$model_setting = $this->model_setting;
		//(3) 欄位排序
    	$param['now_sort']='';
    	$param['sort_info']='';    	
    	if($this->input->get('sort_item')){
            $sort_item=$this->input->post('sort_item');
    	    $sort_method=$this->input->post('sort_method');
    	}else{
    	    $sort_item=$this->sort_item;
    	    $sort_method=$this->sort_method;
    	}	
    	$order=$sort_item." ".$sort_method;
    	$param['sort_item']=$sort_item;
    	$param['sort_method']=$sort_method;

		  	
		//2.資料查詢		
		//$data=$this->$model_setting ['model']->$model_setting ['get_all'] ($query_info['where']);  //原始
		//$data=$this->$model_setting ['model']->$model_setting ['get_one'] ($query_info['where']);  //原始 20180212  只能讀取第一筆
		
		//更動201802084
		$apply_id = $this->input->get('apply_id');
		$data = array('apply_id'=>$apply_id); 
		//$data=$this->$model_setting ['model']->$model_setting ['get_one'] (array('apply_id'=>'1070200018'));  //20180208可讀取單筆資料
		$data=$this->$model_setting ['model']->$model_setting ['get_one']($data);  //20180222 只能指定頭一筆


		//3.設定欄位名稱
		$show_field=$this->show_field;
		//(2)程式自行設定欄位中文與寬度

		
		//4.PDF製作
    	//(1)載入pdf函式庫
    	require_once(COMMONS_PATH.'/libraries/pdf_lib/tcpdf_v6.2.8/tcpdf.php');       
    	
		//(2)建立PDF物件
    	$pdf = new TCPDF($pdf_orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
    	// set document information
    	$pdf->SetCreator(PDF_CREATOR);
    	$pdf->setPrintHeader(false);
    	$pdf->setPrintFooter(false);
		//20180209  設置線條
		$pdf->SetLineStyle(array('width' => 0.3, 'cap' =>  'square', 'join' => 'bevel', 'dash' => '0', 'color' => array(0, 0, 0)));				
    	
    	//(3)字型設定
    	if($pdf_font=='M'){
    		$pdf->SetFont('msungstdlight', '', $pdf_fontsize, '', true);      //新細明體
    	}else{
    		$pdf->AddFont('kaiu','B','kaiu.php');
    		$pdf->SetFont('kaiu', '', $pdf_fontsize, '', true);                //標楷體
    	}
		$pdf->SetProtection(array('print','copy'));
		//(4)新增一頁
    	$pdf->AddPage();
    
	//20180202 撰寫PDF: 國立成功大學雲端計算服務申請表 
	$pdf->MultiCell($col_width, $pdf_cell_height,'國立成功大學雲端計算服務申請表', 0, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');  //20180119使用ex34，畫一個個表格
	$pdf->Ln(); 	
	$this_year =date("Y")-1911;  
	$this_mon=date("m");
	$this_date=date("d");
    $pdf->MultiCell($col_width, $pdf_cell_height,'申請日期：'. $this_year . '年'. $this_mon .'月'. $this_date.'日', 0, 'R', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');  //20180119使用ex34，畫一個個表格
    $pdf->Ln(8);


$pdf_width=47.5;
// first two cells, first couple of parameters are the width and the height
$pdf->MultiCell($pdf_width, $pdf_cell_height, '申請單位/系所', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width*3, $pdf_cell_height, $data->apply_deptname, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
//$pdf->MultiCell($pdf_width, $pdf_cell_height, '校內單位', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
//$pdf->MultiCell($pdf_width, $pdf_cell_height, '是', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
// a new row to go to the next line
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '姓名(單位/計畫主持人)', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->host_psnname, 'L,R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '電話', 1, 'C', 0, 0, '','', false, '',true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->host_phone, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();
/*
$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,B', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,B', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '傳真', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->host_fax, 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();
*/
$pdf->MultiCell($pdf_width, $pdf_cell_height, 'E_Mail', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->host_email, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '姓名(申請人)', 'L', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->apply_psnname, 'L', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '電話', 1, 'C', 0, 0, '','', false, '',true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->apply_phone, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();
/*
$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,B', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, '傳真', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->apply_fax, 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();
*/
$pdf->MultiCell($pdf_width, $pdf_cell_height, 'E_Mail', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->apply_email, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '虛擬機器規格', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'1. 主機名稱：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->host, 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'2. 作業系統：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->version, 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'3. CPU：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->cpu.'核心', 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'4. RAM：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->ram.'GB', 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'5. 本機硬碟：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->hardDisk.'GB (安裝作業系統的空間)', 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'6. 增購本機硬碟：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->addHardDisk.'GB', 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height,'7. 增購NFS硬碟：', 0, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, $data->addNFSDisk.'GB', 'R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '使用期間', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->start_date.' ~ '. $data->end_date.'(共 '.$data->period.' 天)', 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '申請項目', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
switch ($data->applyItem) {
	case 'A':
		$data->applyItem='第一次使用';
		break;
	case 'B':
		$data->applyItem='續租';
		break;
	case 'C':
		$data->applyItem='擴充';
		break;
	default:	
		break;
}
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->applyItem, 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');

$pdf->MultiCell($pdf_width, $pdf_cell_height, '收據抬頭', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell($pdf_width, $pdf_cell_height, $data->receipt, 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '金額', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, '單價：'.$data->price.'天/元', 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '用途', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->uses, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(2*$pdf_width, 1.5*$pdf_cell_height, '', 'L,T', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, 1.5*$pdf_cell_height,'', 'R,T', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(2*$pdf_width, $pdf_cell_height, '申請人：', 'L,B', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(2*$pdf_width, $pdf_cell_height,'申請單位蓋章：', 'R,B', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(4*$pdf_width, 0.5*$pdf_cell_height, '', 0, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(4*$pdf_width, $pdf_cell_height, '以下資料由計算機與網路中心填寫', 0, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '虛擬主機IP位址', 'L,R,T', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->ip, 'L,R,T', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, 'VM-Client管理帳號', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, $data->VM_Client, 1, 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '收費計算', 'L,R,T', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height, '總計新台幣 :　單價 * 天數 * 折扣 * 臺數 ','L,R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell($pdf_width, $pdf_cell_height, '', 'L,R', 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(3*$pdf_width, $pdf_cell_height,'總計新台幣：'.$data->price.' * '.$data->period.' * '.$data->discount.' * '.$data->number.' = '.$data->totalPrice.'元','L,R', 'L', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(63.3, $pdf_cell_height, '網路組承辦人', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(63.3, $pdf_cell_height, '組長簽章', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(63.3, $pdf_cell_height, '主任簽章', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();

$pdf->MultiCell(63.3, 2*$pdf_cell_height, '', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(63.3, 2*$pdf_cell_height, '', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->MultiCell(63.3, 2*$pdf_cell_height, '', 1, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');
$pdf->Ln();
		
$pdf->MultiCell(4*$pdf_width, $pdf_cell_height, '註:申請表單列印蓋章後，請送至計算機與網路中心4樓網路與資訊安全組。', 0, 'C', 0, 0, '', '', false, '', true, false, $pdf_cell_height, 'M');		
$pdf->Ln();

		/*		
		//(5)撰寫PDF內容
     	foreach($data as $index=>$row){
    		//取一筆資料
    		
    		//若為第1筆，先建立欄位標題      		
    		if( ($index) % $pdf_page_cnt==0){  
    			$col_cnt=1;
    			foreach($show_field as $col=> $head_row){    				
    				$col_width=$head_row['export']['pdf'];
    				if($col_width>0){
    					if($col_cnt=='1'){
    						//標頭增加序號欄位 1194-1195 20180202
    						$value='序號';  
    						$pdf->MultiCell(10, $pdf_cell_height,$value, 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');

    					}
						//chi_name SQL所有欄位1199-1201 20180202
    					$value=trim($head_row["chi_name"]);
    					$pdf->MultiCell($col_width, $pdf_cell_height,$value, 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');  //20180119使用ex34，畫一個個表格
    					$col_cnt++;
    				}
    				 
    			}
    			
    		}			
    		$pdf->Ln();   // 20180202建立pdf表單要跳行 格式: $pdf->MultiCell(); $pdf->Ln();  $pdf->MultiCell();  -->...-->
			//加上資料序號
            //20180202 SQL 表頭'1'數值  1210
    		$pdf->MultiCell(10, $pdf_cell_height,($index+1), 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');
   		
			//逐一寫入資料的每一個欄位
    		foreach($show_field as $col => $field_row){
    			//取得欄位寬度 
    			$col_width=$field_row['export']['pdf'];				
    			if($col_width>0){
    				$value=$row->$col;   
	    			//20180202 SQL 數值1219
	    			$pdf->MultiCell($col_width, $pdf_cell_height,trim($value), 1, '', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');
    			}
    		}
			//超過每頁限制筆數，新增一頁
    		if( ($index+1) % $pdf_page_cnt==0){
    			$pdf->AddPage();  			 
    		}		
    	} 
 		/*/
    	ob_end_clean();
		
    	//5.檔案輸出
    	if($pdf_download=='S'){
    		//存在server端 
    		$pdf->Output($this->pdf_download_path.$pdf_fname.'.pdf', 'F');    	
    	}else if($pdf_download=='D'){
    		// 由瀏覽器下載
			$pdf->Output($pdf_fname.'.pdf', 'D');
		}else{
			// 直接由瀏覽器開啟
			$pdf->Output($pdf_fname.'.pdf', 'I');
    	
    	}
    	
     
    
    }
 	public function column(){	
		die($this->grid_service->get_column($this->show_field));
	}	   

 	/*
	 * 格示驗証
	 * 當Form欄位值change時，觸發ajax做單一欄位驗証
	 * 範例如下:
	 * INPUT: $_POST['idno']=''
	 *        show_field
	 * OUTPUT:{"idno":"身份證字號 必須填寫"}
	 */
	public function validate_one(){
		$val_rtn=$this->grid_service->validate($this->input->post(),$this->show_field);
		$this->output->json( $val_rtn );				
	}	  

	/**
	 * 發信20180227
	 */	 

	public function mail() {
		//ob_start();
		
		//(1) 基礎設定
		$model_setting = $this->model_setting;
		//(3) 欄位排序
    	$param['now_sort']='';
    	$param['sort_info']='';    	
    	if($this->input->get('sort_item')){
            $sort_item=$this->input->post('sort_item');
    	    $sort_method=$this->input->post('sort_method');
    	}else{
    	    $sort_item=$this->sort_item;
    	    $sort_method=$this->sort_method;
    	}	
    	$order=$sort_item." ".$sort_method;
    	$param['sort_item']=$sort_item;
    	$param['sort_method']=$sort_method;
		//只接受特定欄位
		$field=array('item','value','type');
		$data=$this->input->get_parameters($field);
		
		//取查詢條件
		$query_info=$this->grid_service->get_query_info($data);	    	
		$query_info['order']=$param['sort_item']." ".$param['sort_method'];
	
		//2.資料查詢		
		$data=$this->$model_setting ['model']->$model_setting ['get_one']($data['apply_id'],$model_setting ['key_field']);  //20180222 只能指定頭一筆			

		//3.設定欄位名稱
		$show_field=$this->show_field;
	
	
		//(1)載入php_mail函式庫      
		$this->load->library('ckeditor/ckeditor.php');
		
		//(2)建立PHP_email物件
		$CKEditor = new CKEditor();
		$CKEditor->basePath = $this->config->item('basePath', 'ckeditor_base');
		
		//選擇樣版
		$config=$this->config->item('config1', 'ckeditor_config');	
	      
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
		$file_path='C:/';
		        
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
		

		if ($has_file && $total_size > 5000) {
			$out['msg'] = "夾帶檔案總和請勿超過5000KB，目前總計" . $total_size . "KB";
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
			$this->email->subject($data['title']);	
			$this->email->message($data['content']);
			
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
		
		//ob_end_clean();
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
			$out['upload']['file_name'][]=$file_info['file_name']."(".$file_info['file_size']."KB)";
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

	public function send(){
		$this->load->helper('encode');	
		$this->load->library('email');	    	
    	$this->email->initialize($this->config->item('mail_setting'));		
    	$this->email->set_mailtype("html");		
		$this->email->clear();	
		$this->email->from($data->user_mail); //管理者mail  $data['user_mail']
		$this->email->to($data->apply_email);  //使用者mail $data['apply_email']  =$this->Auth_service->get_user_id();	
		$this->email->subject("測試");			
		$this->email->message("測試內文");
		
		$attach_filename = big5_to_utf8("");
		$this->email->attach($attach_filename);
	
		$send_rtn=$this->email->send();

		if($send_rtn){
			
			echo 'success!';	
		}else{
			echo "error!";	
		}
	}

} 
