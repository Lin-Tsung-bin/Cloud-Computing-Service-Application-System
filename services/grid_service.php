<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Grid_service extends NF_Service {
    
    public function __construct() {
        log_message('debug', "Auth_service Class Initialized");
    }
	
	/**產生kendo grid,form,query 要使用的column設定
	 * @show_field:欄位設定
	 */
	public function get_column($show_field){
		$data=array('grid_column'=>array(),'form_column'=>array());
		$column_index=0;
		foreach($show_field as $index =>$row){
			if(isset($row['grid']) && $row['grid']!=false){
				if(isset($row['grid']['width'])){
					$data['grid_column'][]=array(
						'field'=>$index,
						'title'=>$row['chi_name'],
						'width'=>$row['grid']['width']
					);
				}
			}
			if(isset($row['form']) && $row['form']!=false){
				
				$data['form_column'][$column_index]['name']=$index;	
				if(isset($row['form']['initial'])){				
					$data['form_column'][$column_index]['initial']=$row['form']['initial'];
				}		
				if(isset($row['form']['editable'])){				
   					$data['form_column'][$column_index]['editable']=$row['form']['editable'];
				}
				$column_index++;
			}
			
			
			if(isset($row['query']) && $row['query']!=false){
				$data['query_column'][$index]['title']=$row['chi_name'];
				if(isset($row['query']['textcase'])){							
					$data['query_column'][$index]['textcase']=$row['query']['textcase'];
				}
				if(isset($row['query']['queryType'])){			
					$data['query_column'][$index]['queryType']=$row['query']['queryType'];
				}
				if(isset($row['query']['querySource'])){			
					$data['query_column'][$index]['querySource']=$row['query']['querySource'];
				}
				if(isset($row['query']['defaultval'])){
								
					$data['query_column'][$index]['defaultval']=$row['query']['defaultval'];
				}
				if(isset($row['query']['allowtype'])){
					$data['query_column'][$index]['allowtype']=$row['query']['allowtype'];
				}				
			}
			
			

		}		
		
		return json_encode($data);
	}
	/**
	 * 格示驗証(根據show_field的validate設定進行POST的格示設定)
	 * @ post      :表單參數
	 * @ show_field:欄位設定
	 * @ return array('表單欄位'=>'格示驗証錯誤訊息')
	 */
	public function validate($post,$show_field){
		$this->load->library ( 'form_validation' );	
		$validate_result=array();	
		
		foreach($show_field as $index=>$row){
			if(isset($show_field[$index]['validate'])){
				$col_name = $index; // 欄位名稱
				$col_chiname = $show_field[$index]['chi_name']; // 欄位中文
				$col_rule    = $show_field[$index]['validate'];
				$this->form_validation->set_rules ( $col_name, $col_chiname, $col_rule );
				if(!isset($_POST[$index])){
					$_POST[$index]="";
				}
			}

		}
		if($this->form_validation->run () == FALSE){
			$validate_result=$this->form_validation->error_array();
		}

		return $validate_result;
	}
	/**
	 * grid 查詢$_POST參數處理(pageSize,skip,order,item[],type[],value[])
	 * @ return array('pageSize'=>讀取筆數
	 *                'skip'    =>略過幾筆
	 *                'order'   =>排序方式
	 *                'where'   =>過濾條件(string)
	 *               )
	 */
	function get_query_info($query_data){
		//分頁資訊
		$result['pageSize'] = isset($query_data['pageSize'])?$query_data['pageSize']:"10"; // 每數筆數
		$result['skip']     = isset($query_data['skip'])?$query_data['skip']:"0";      // skip筆數
		
		//排序資訊
		if (isset ( $query_data['sort'] [0] )) {
			$result['order'] = implode ( $query_data['sort'] [0], " " );
		
		}else{
			$result['order'] ='';
		}
		
		//過濾資訊
		
		$item=isset($query_data['item'])?$query_data['item']:false;		
		$type=isset($query_data['type'])?$query_data['type']:false;
		$value=isset($query_data['value'])?$query_data['value']:false;
		$where_str=array();	
		//皆存在
		if($item && $type && $value){
		
			foreach($item as $index=>$row){
				$has_item=(isset($item[$index]) && trim($item[$index])!='')?true:false;
				$has_type=(isset($type[$index]) && trim($type[$index])!='')?true:false;
				$has_value=(isset($value[$index]) && trim($value[$index])!='')?true:false;
				//該項查詢組合皆有值
				if($has_item && $has_type && $has_value){
					$item_str=$item[$index];
					$type_str=$type[$index];
					$value_str=$this->db->escape($value[$index]);
					switch($type_str){
						case 'equal':
							$where_str[]=$item_str." = ".$value_str;
							break;
						case 'not_equal':
							$where_str[]=$item_str." != ".$value_str;
							break;
						case 'like':
							$where_str[]=$item_str." like '%".substr($value_str,1,strlen($value_str)-2)."%'";
							break;
						case 'greater':
							$where_str[]=$item_str." > ".$value_str;
							break;
						case 'less':
							$where_str[]=$item_str." < ".$value_str;
							break;
						case 'greater_equal':
							$where_str[]=$item_str." >= ".$value_str;
							break;
						case 'less_equal':
							$where_str[]=$item_str." <= ".$value_str;						
					}

				}
				
			}
		}
		$result['where']=implode(" and ", $where_str);
		return $result;
	}
 	/**
	 *	編碼轉換
	 *  將查詢資料的內容，部分欄位做code與中文說明轉換
	 *  @param $data
	 *  @param $replace_rule
	 *  $replace_rule=array('team_state'=>array('0'=>'首次送件待審核',
	 *	                                        '1'=>'已審核待修正',
	 *	                                        '2'=>'完成審核',
	 *	                                        '3'=>'未審過取消送件',
	 *	                                        '4'=>'已修正重新送件待審核'
	 *	                                       )
	 *	                   );
	 */
	public function code_replace($data=array(),$replace_rule=array()){
		$key=array_keys($replace_rule);
		foreach($data as $index1=>$row1 ){
			//每一筆資料是陣列
			if(is_array($row1)){
				foreach($row1 as $index2=>$row2){
					//需要轉換的欄位
					if (in_array($index2, $key)){
						$data[$index1][$index2]=$replace_rule[$index2][$row2];					
					}
				}
				
			}else{
			//每一筆資料是object
				foreach($row1 as $index2=>$row2){
					//需要轉換的欄位
					if (in_array($index2, $key)){
						@$data[$index1]->$index2=$replace_rule[$index2][trim($row2)];	 //20180202 增加'@'					
					}
				}			
			}
		}
		return $data;
		
	}  
    
}