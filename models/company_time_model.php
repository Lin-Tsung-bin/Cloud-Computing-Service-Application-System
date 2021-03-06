<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Company_time_model extends NF_Model {
    const TABLE = 'company_time';
    
    function __construct() {
        parent::__construct(self::TABLE);
    }     
    //查詢資料(分頁)
    public function get_company_timepage($query_info,$page) {
        $param = new ModelParameter();
        $param->select('*');  	
        $param->where($query_info['where']);
		$param->order_by($query_info['order']);
	    $result= $this->page_query($param, $page);
		
		//新增刪除時的換頁操作
		if(empty($result['data'])){
			$result= $this->page_query($param, $page-1);
			$result['current_page']=$page-1;			
		}else if($page==''){
			$result['current_page']=1;
		}else{
			$result['current_page']=$page;
		}
		$result['count']= $this->count($query_info['where']);
	
		return $result;
		
    }
    //新增資料(單筆)
    public function  add_company_time($data,$key_field=False){
        return $this->add($data ,$key_field);
    }
	//查詢資料
    public function get_company_time($key_field) {
        $param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_one($param);    
	
    }
    /*
	 * 更新資料:可以更新key
    */
    public function  upd_company_time_ci($data,$where){
    	$result = array("success" => FALSE, "msg" => '', 'num'=>FALSE);
				
		if(count($where)==0){
			$result['msg'] = "where is empty.";
		}else{
			$this->db->where($where);
	        if ($this->db->update(self::TABLE, $data)) {
	        	$result['num'] = $this->db->affected_rows();
	        	if ($result['num'] > 0) {
	        		$result['success'] = TRUE;
	        	} else {
	        		$result['msg'] = "No data updated.";
	        	}
	        } else {
	        	$result['msg'] = '['.$this->get_error_number().'] '. $this->get_error_message();
	        }
		}
		return $result;
    }	
    //更新資料
    public function  upd_company_time($data,$key_field){
        return $this->save($data,$key_field);
    }
    //刪除資料
    public function  del_company_time($key_field){    	
        return $this->del($key_field);
    }
	//查詢資料
    public function get_company_time_all($key_field) {
    	$param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_all($param);    	
    }
    //查詢單一欄位資料，回傳array
    public function  get_company_time_col($col){
        $param = new ModelParameter();
        $param->select($col);
        $param->order_by($col." desc");  //asc
        $param->group_by($col);
        return $this->get_all($param);   
    } 

    public function uniq($where){
        //$where = array("idno" => $idno);
        $param = new ModelParameter();
        $param->select("count(*) as cnt")->where($where);
        $data = $this->get_one($param);
        return $data->cnt < 1;
    }
    /**
     * 依信箱取得個人資料。
     * @param unknown_type $no
     */
    public function get_by_id($no) {
        if ($no == '') {
            return FALSE;
        }
        $sql = "SELECT * FROM ". self::TABLE ." where email = ".$this->db->escape($no) ;
        return $this->select_one($sql);
    }
 
}