<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends NF_Model {
    const TABLE = 'category';
    
    function __construct() {
        parent::__construct(self::TABLE);
    }     
    //查詢資料(分頁)
    public function get_categorypage($query_info,$page) {
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
    public function  add_category($data,$key_field=False){
        return $this->add($data ,$key_field);
    }
	//查詢資料
    public function get_category($key_field) {
        $param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_one($param);    	
    }
    //更新資料
    public function  upd_category($data,$key_field){
        return $this->save($data,$key_field);
    }
    //刪除資料
    public function  del_category($key_field){    	
        return $this->del($key_field);
    }
	//查詢資料
    public function get_category_all($key_field) {
    	$param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_all($param);    	
    }
    //查詢單一欄位資料，回傳array
    public function  get_category_col($col){
        $param = new ModelParameter();
        $param->select($col);
        $param->order_by($col." asc");
        $param->group_by($col);
        return $this->get_all($param);   
    } 
}