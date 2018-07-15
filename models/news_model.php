<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends NF_Model {
    const TABLE = 'news';
    
    function __construct() {
        parent::__construct(self::TABLE);
    }     
    //查詢資料(分頁)
    public function get_newspage($query_info,$page) {
        $param = new ModelParameter();
        $param->select('*');  	
        $param->where($query_info['where']);
		$param->join('category','category.category_type=news.category');  // 跨資料表查詢
		
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
    public function  add_news($data,$key_field=False){
        return $this->add($data ,$key_field);
    }
	//查詢資料
    public function get_news($key_field) {
        $param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_one($param);    	
    }
    //更新資料
    public function  upd_news($data,$key_field){
        return $this->save($data,$key_field);
    }
    //刪除資料
    public function  del_news($key_field){    	
        return $this->del($key_field);
    }
	//查詢資料
    public function get_news_all($key_field) {
    	$param = new ModelParameter();
        $param->select('*');
        $param->where($key_field);
        return $this->get_all($param);    	
    }
    //查詢單一欄位資料，回傳array
    public function  get_news_col($col){
        $param = new ModelParameter();
        $param->select($col);
        $param->order_by($col." asc");
        $param->group_by($col);
        return $this->get_all($param);   
    } 
}

// news_id     title     create_date     create_time     create_id     content        category    
// ----------  --------  --------------  --------------  ------------  -------------  ----------- 
// 7783        系統分派      20171113        15:52:08        0             分派給aaaaaa請處理   A           
// 7778        aaaa1     20171123        14:23:16        0             aaaaaaaa       B          