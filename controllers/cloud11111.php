<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // 避免直接連結
/**
* Ex12 GRID維護
* @author 吳珮菁
*
*/
class Cloud11111 extends NF_Controller {
	// 1.基礎設定
	private $code_name = 'cloud11111'; // 程式編號
	private $dir_name = ''; // 子目錄 (ex: exam/)
	
	// 2.Model相關設定
	private $model_setting = array (
			'model' => 'Cloud_manager_model',           // Model名稱		
			'add_one' => 'add_cloud_manager',           // 新增單筆資料	
			'get_page'  => 'get_cloud_managerpage',         // 取分頁資料
			'add_one'   => 'add_cloud_manager',             // 新增資料
			'upd_one'   => 'upd_cloud_manager',             // 更新資料
			'del_one'   => 'del_cloud_manager',             // 刪除資料    
			'get_one'   => 'get_cloud_manager',             // 取資料  
			'get_all'   => 'get_cloud_manager_all',         // 取資料多筆   		 		
			
			'key_field'=>array ("account"),         // 主鍵
			'edit_info' => array (              
					//'update_date' => 'upddate',  // 更改日期20130917
					//'update_time' => 'updtime',  // 更改時間15:10:15
					//'update_id'   => 'upduser',  // 更改使用者
					//'update_ip'   => 'updip'     // 更改IP  
			)

	);
    private $sort_item='account';
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
			'name' => array (
					'chi_name' => '姓名',
					'grid'     => array('width'=>100),
					'form'     => array('editable'=>'11'),              
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()			
								 ),
					'validate'=>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40)
			),
			'dept_name' => array (
					'chi_name' => '單位',	
					'grid'     => array('width'=>100),						
					'form'     => array('editable'=>'11'), 
					'query'    => array('textcase'=> 'toUpperCase',
									    'defaultval'=>array()
								 ),
					'validate'=>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40)
					
			),
			'account' => array (
					'chi_name' => '帳號',
					'grid'     => array('width'=>100),			
					'form'     => array('editable'=>'11'), 
					'query'    => true, 		 
					'validate'=>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40)
			),			
			'password' => array (
					'chi_name' => '密碼',	
					'grid'     => array('width'=>100),							
					'form'     => array('editable'=>'11'), 
					'query'    => false,
					'validate' =>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40)
			),
			'email' => array (
					'chi_name' => '信箱',	
					'grid'     => array('width'=>100),							
					'form'     => array('editable'=>'11'), 
					'validate' =>'required', 
					//'export'   => array('excel'=>20,'pdf'=>40)					
			),
			'mana_ty' => array (
					'chi_name' => '身份',
					'grid'     => array('width'=>100),			
					'form'     => array('editable'=>'11','initial'=> ''), 
					'query'    => array('queryType'=> 'dropdownlist',
					                    'querySource' =>array(
					                                 array('name'=>"VM承辦人",'value'=>"1"),					                                      
					                                 array('name'=>"收款承辦人",'value'=>"2"),
													 array('name'=>"全部權限",'value'=>"3")
												  ),
						                 'defaultval'=>false,  
                                         'allowtype'=>array('equal','not_equal','greater_equal','less_equal')                 
                                   ),
					'validate'=>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40)
			),
			'notice' => array (
					'chi_name' => '是否VM到期通知',	
					'grid'     => array('width'=>100),							
					'form'     => array('editable'=>'11','initial'=> ''), 
					'query'    => array('queryType'=> 'dropdownlist',
					                    'querySource' =>array(
					                                 array('name'=>"是",'value'=>"Y"),					                                      
					                                 array('name'=>"否",'value'=>"N"),
												  ),
						                 'defaultval'=>false, 
						                 		  /*  array(
                                                          array('type'=>'equal','value'=>'Y'),
                                                         // array('type'=>'less_equal','value'=>'M')
                                                       ),  */
                                         'allowtype'=>array('equal'),                 
                                   ),
					'validate'=>'required',
					//'export'   =>array('excel'=>20,'pdf'=>40) 
			)

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
			/*
			$data['item'][]='nvl(a.pass_no,'')';
			$data['equal'][]='greater';
			$data['value'][]='0';
			*/
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
			
			$rule=array('mana_ty'=>array('1'=>'VM承辦人','2'=>'收款承辦人','3'=>'全部權限'),
						'notice'=>array('Y'=>'是','N'=>'否')  );
			
			$result['data']=$this->grid_service->code_replace($result['data'],$rule);
			
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
	    	
	    foreach($this->show_field as $index=>$row){
	    	$value=""; 
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
				case 'del':
					if(isset($row['form']['editable'])){
						$editable=false;
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
    		$out=array('success'=>'F','msg'=>'');  //F
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
					
				
	    		//資料處理
				//增加編輯資訊(人員,日期,時間,ip)
				$this->load->service('data_service');					
				$data=$this->data_service->add_editinfo($data,$model_setting['edit_info']);
				
				//針對checkbox欄位處理，將勾選的項目值合成字串
				foreach($data as $index=>$row){
					if(is_array($row)){
						$data[$index]= implode("",$row) ;
					}
				}
				
	    		//新增前條件:
	    		 
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
	    				$out['msg']='新增失敗!';
						
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
				 	
	    	
	    	
	    		//資料處理
				//增加編輯資訊(人員,日期,時間,ip)
				$this->load->service('data_service');					
				$data=$this->data_service->add_editinfo($data,$model_setting['edit_info']);				
				
				//針對checkbox欄位處理，將勾選的項目值合成字串
				foreach($data as $index=>$row){
					if(is_array($row)){
						$data[$index]= implode("",$row) ;
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
		    		$out['msg']='修改成功!';	
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
		$excel_fname         ='report';     //下載檔名
		
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
						if($col_index=='account'){  //idno
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
    public function export_pdf() {
    	ob_start();
    	error_reporting(0);
    	//1.參數設定
    	$pdf_fname='report';                           // pdf下載檔名			
		$pdf_orientation='L';                       // PDF方向  P:直向 L:橫向
		$pdf_download='D';                          // F:存在server端   D:由瀏覽器下載	 I:由瀏覽器開檔		
		$pdf_download_path="/tmp/";                 // S:存在server端  目錄路徑
		$pdf_fontsize='10';                         // 字型大小
		$pdf_page_cnt='43';                         // 每頁顯示資料數
		$pdf_cell_height='8';                       // cell高度
		$pdf_font='M';                              // PDF 字體　　M:新細明體　　K:標楷體

		
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
		//(2)程式自行設定欄位中文與寬度

		
		//4.PDF製作
    	//(1)載入pdf函式庫
    	$this->load->library("pdf_lib/tcpdf/tcpdf.php");        
    	
		//(2)建立PDF物件
    	$pdf = new TCPDF($pdf_orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
    	// set document information
    	$pdf->SetCreator(PDF_CREATOR);
    	$pdf->setPrintHeader(false);
    	$pdf->setPrintFooter(false);
    	
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
    						$value='序號';
    						$pdf->MultiCell(10, $pdf_cell_height,$value, 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');

    					}
    					$value=trim($head_row["chi_name"]);
    					$pdf->MultiCell($col_width, $pdf_cell_height,$value, 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');
    					$col_cnt++;
    				}
    				 
    			}
    			
    		}			
    		$pdf->Ln();
			//加上資料序號
    		$pdf->MultiCell(10, $pdf_cell_height,($index+1), 1, 'C', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');
			
			//逐一寫入資料的每一個欄位
    		foreach($show_field as $col => $field_row){
    			//取得欄位寬度 
    			$col_width=$field_row['export']['pdf'];				
    			if($col_width>0){
    				$value=$row->$col;   
	    			$pdf->MultiCell($col_width, $pdf_cell_height,trim($value), 1, '', 0, 0, '', '', true, '', false, true,$pdf_cell_height, 'M');
    			}
    		}
			//超過每頁限制筆數，新增一頁
    		if( ($index+1) % $pdf_page_cnt==0){
    			$pdf->AddPage();
    			 
    		}
    		
    	}
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

} 
