<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['language'] = 'chinese_utf8'; //utf8_general_ci

$config['subclass_prefix'] = 'MY_';


//於正式主主機
//$config['commons_url'] = '/nf/commons/v1.1.2/';

//於 204 測試主機開發
$config['commons_url'] = 'http://localhost/ncku_framework/commons/';   /// '/nf/commons/';  <- 務必改為此路徑，網頁才能顯示 20180118  


//寬度1000
$config['layout'] = 'bootstrap_layout';
//$config['layout'] = 'mis_layout';
//滿版
//$config['layout'] = 'full_mis_layout';


//設定程式名稱
$config['breadcrumb'] = array(
						/*	'ex1'=>'ex1-select_service(下拉式)選單',
							'ex2'=>'ex2-data_service_(編輯資訊)',
							'ex3'=>'ex3-encode_helper(編碼轉換)',
							'ex4'=>'ex4-codetab(選單維護)',
							'ex5'=>'ex5-PDF製作',
							'ex6'=>'ex6-EXCEL匯入匯出',
							'ex7'=>'ex7-CKEDITOR文字編輯器',
							'ex13'=>'ex13-信件發送與附檔上傳',
							'ex14'=>'ex14-操作說明',
							'ex17'=>'ex17-操作說明-程式建檔',
							'ex15'=>'ex15-操作說明-圖文製作',
							
							'ex12'=>'ex12-grid(維護按鈕上方)',
							'ex16'=>'ex16-grid(維護按鈕左側)',
							'ex18'=>'ex18-master_detail grid',
							'ex19'=>'ex19-share grid(上方grid,下方form)',
							'ex20'=>'ex20-share grid(左方grid,右方form)',
							'ex21'=>'ex21-grid(查詢對話框顯示)',	
							
							'ex22'=>'ex22-Form新增(註冊)',
							'ex23'=>'ex23-Form修改(資料維護)',
							'ex24'=>'ex24-Show_field參數設定說明',	
							
							
							'ex8'=>'ex8-Form新增(註冊)',
							'ex9'=>'ex9-Form修改(資料維護)',
							'ex10'=>'ex10-grid(管理平台)',	
							'ex11_md'=>'ex11-master-detailgrid(管理平台)',						
							'proglist'=>'樣版圖示說明'	,
							'ex36'=>'ex36-報表(WEB,EXCEl,PDF)',
							'ex40'=>'Ex40-表單',		
							'ex42'=>'Ex42-資料維護',
							'notice'=>array('manual1'=>'開發環境介紹與版本控制設定'),  */
							'cloud11111'=>'管理者總覽',
							'cloud11121'=>'申請單總覽',
							'cloud11131'=>'系統租用計算',
							'cloud12111'=>'雲端計算服務申請'	
																				
						); 							  

$config['mail_setting'] = array('protocol' =>'smtp',		
								'charset'  =>'utf8',	//20180226 'big5'						
			  					'smtp_host'=>'email.ncku.edu.tw',
								'mailtype' =>'html',
								'newline'=>"\r\n",
								'wordwrap'=>true
								);
$config['upload_setting'] = array('upload_path'=>'./uploads/','allowed_types'=>'gif|jpg|png|doc|docx|pdf|tif|tiff|rar|zip|xls|xlsx|xlsm', 'max_size'=>'500', 'max_width'=>'1024', 'max_height'=>'800');
//$config['upload_setting'] = array('upload_path'=>'./uploads/','allowed_types'=>'gif|jpg|png|doc|docx|pdf|tif|tiff|rar|zip|xls|xlsx|xlsm', 'max_size'=>'500', 'max_width'=>'1024', 'max_height'=>'800');
$config['photo_setting'] = array('image_library'=>'gd2', 'create_thumb'=>TRUE, 'maintain_ratio'=>TRUE, 'width'=>185, 'height'=>185);


/**/

//設定系統資訊
$config['web_name']="雲端計算服務申請系統";    //資訊組模組範例程式


//設定footer 資訊
$config['footer']=array(
		'phone'=>'(06)2757575 ext 61013',
		'service_time' => '週一~ 週五 08:00~17:00',
		'service_unit' => 'XXOO中心',
		'mailto' =>'z9509039@email.ncku.edu.tw'
		//'phone'=>'(06)2757575 ext 61010',
		//'service_time' => '週一~ 週五 08:00~17:00',
		//'service_unit' => '計算機與網路中心',
		
);
//分頁
$config['page_size'] =10;
$config['max_show_page'] = 10;
$config['charset'] = "UTF-8";

//20180316主機寄信和繳費寄信 你先在config加上$machine_sender='xxxx@xx'
//$config['machine_sender']= 'z9509039@email.ncku.edu.tw';
//$config['money_sender']= 'z8903012@email.ncku.edu.tw';
$config['machine_sender']= 'bin39313141@hotmail.com';
$config['money_sender']= 'bin39313141@hotmail.com';


//CKEDITOR
//upload_url請改成對應目錄，並給nobody該目錄寫入權限 
$config['ckeditor_upload_setting']=array( 
                                          'upload_path'=>APPPATH.'/ckeditor_uploads/',
                                          'upload_url'=>'/~10107006/learn/ckeditor_uploads/',
                                          'allowed_types'=>'gif|jpg|jepg|png',
                                          'max_size'=>'500',
                                          'max_width'=>'1024',
                                          'max_height'=>'800'
										 );
//$config['ckeditor_base']=array('basePath'=>"/~10107006/public_html/ncku_framework/commons/libraries/ckeditor/");
//$config['ckeditor_base']=array('basePath'=>"/~10107006/learn/libraries/ckeditor_v4.7.7/");

// 信件欄功能config1, config2  20180309
$config['ckeditor_base']=array('basePath'=>"/ncku_framework/commons/libraries/ckeditor/");  // /nf/commons/libraries/ckeditor/
$config['ckeditor_config']=
	array(
	    'config1'=>array('skin'=>'kama',	    	
				'toolbar'=> array(
					/*	array( 'Source','-',
								'NewPage','Templates','-',
								'Cut','Copy','Paste','PasteText','PasteFromWord','-',
								'Undo','Redo','-',
								'Find','Replace','-',
								'SelectAll','RemoveFormat','-',
								'Maximize', 'ShowBlocks'),  */
					/*	'/',  */
						array('Bold','Italic','Underline','Strike','-',
								'Subscript','Superscript','-',
								'NumberedList','BulletedList','-',
								'Outdent','Indent','Blockquote','-',
								'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-',
								'Link','Unlink','-',
								'Table','HorizontalRule',
							/*	'SpecialChar','Image'  */
						),
					/*	'/',   */
						array('Format','Font','FontSize','-',
								'TextColor','BGColor')
				)
				
		),
		'config2'=>array('skin'=>'kama',
				'toolbar'=> array(
						array( 'Source','-',
								'NewPage','Templates','-',
								'Cut','Copy','Paste','PasteText','PasteFromWord','-',
								'Undo','Redo','-',
								'Find','Replace','-',
								'SelectAll','RemoveFormat','-',
								'Maximize', 'ShowBlocks'),
						'/',
						array('Bold','Italic','Underline','Strike','-',
								'Subscript','Superscript','-',
								'NumberedList','BulletedList','-',
								'Outdent','Indent','Blockquote','-',
								'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-',
								'Link','Unlink','-',
								'Table','HorizontalRule','SpecialChar','Image'
						),
						'/',
						array('Format','Font','FontSize','-',
								'TextColor','BGColor')
				),
				
				'height'=>600
		)
);
$config['codetab']=array(
		'table'=>'codetab',
		'charset'=>'utf8',
		'default'=>'Y',
		'code_kind'=>'類別',
		'code_field'=>'代碼',
		'chin_item'=>'名稱',
		'chin_abbr'=>'簡稱',
		'super_kind'=>'上層類別',
		'super_field'=>'上層類號',
		'super_name'=>'上層名稱');
		
//簡訊寄送設定
$config['sms']=array(
		
		//SQL設定  "select First $search_cnt(筆數) sql_field(欄位名稱) $sql_suffix(後段SQL)"
		'search_cnt'=>5,           //查詢筆數
		'sql_field'=>'psn_code',   //預設的欄位(key)ex stu_no,psn_code 
		                           //後段SQL(from...where)
				
		'data_m_Name'=>'Smsdata_model',  //簡訊項目sql查詢的model
		
		'data_f_Name'=>'get_query',  //回傳SQL查詢結果     return $this->select_all($sql);
		
		'user_m_Name'=>'Smsuser_model', //藉由$sql_field 去User_model 取使用者姓名和手機的model
		
		'user_f_Name'=>'get_by_no',  //return row(); 回傳psn_name,mobil欄位
		
		'test_sample'=>'[姓名]您好，於[時間]舉辦的[活動名稱]活動你已報名成功!',  //測試版預設的範本內容
		
		'sys_name'    =>'acti',       					 //系統名稱
		'admin_code'=>'10107006',     					 //管理者帳號
		'admin_mobile'=>'0937925209',  					 //承辦人手機
		'admin_email' =>'peiching@mail.ncku.edu.tw',	 //承辦人信箱
        'allow_field'=>array(                            //正式版:使用者資料設定要顯示的資料欄位
        
			'psn_name'     =>'使用者姓名',
			'psn_code'     =>'使用者代號',
			'mobil'        =>'使用者手機',
			'info'        =>'介紹',
		
		),
		
       'sql_item' =>array(                              //正式版:使用者資料設定 使用者群組的SQL
			'sql1'=>array(
					'info'=>"發送名單 ",
					"sql_suffix" =>"from sms_data "
			),
		
		),
        'alias_field'=>array(                           //若allow_field資料欄位於的SQL中多出現在多個table，請表示為哪一個table的欄位
	         'acti_activities.active_start' =>'active_start'
        )
);		
/* End of file config.php */
/* Location: ./application/config/config.php */
