<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cloud_apply_model extends NF_Model {
    const TABLE = 'cloud_apply';
    
    function __construct() {
        parent::__construct(self::TABLE);
    }     
    //查詢資料(分頁)
    public function get_cloudpage($query_info,$page) {
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
    public function  add_cloud($data,$key_field=False){
        return $this->add($data ,$key_field);
    }
	//查詢資料
    public function get_cloud($key_field) {
        $param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_one($param);    
	
    }
    /*
	 * 更新資料:可以更新key
    */
    public function  upd_cloud_ci($data,$where){
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
    public function  upd_cloud($data,$key_field){
        return $this->save($data,$key_field);
    }
    //刪除資料
    public function  del_cloud($key_field){    	
        return $this->del($key_field);
    }
	//查詢資料
    public function get_cloud_all($key_field) {
    	$param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_all($param);    	
    }
    //查詢單一欄位資料，回傳array
    public function  get_cloud_col($col){
        $param = new ModelParameter();
        $param->select($col);
        $param->order_by($col." asc");
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


// 2018/02/01 建立表單編號 與 回傳回sql 110-114
	public function get_serial($this_mon){
		$sql ="select max(substring(apply_id,6,5)) as max_apply_id from cloud_apply where substring(apply_id,1,5) = '".$this_mon."' "; //SUBSTRING(str:(指定文字), pos(文字內第幾個), len(從第幾個開始往後列出指定的個數))
		//echo $sql; 	// 2018/02/01 判斷 ,刪除此行
		return $this->select_one($sql);
	}
 
}