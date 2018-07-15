<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends NF_Model {

    const TABLE = 'cloud_manager'; //user  -20180204
    
    function __construct() {
        parent::__construct(self::TABLE);
    }
    /**
     * 依識別證號或學號取得使用者資料。
     * @param  $no
	 * @param  $field要讀取的欄位
     */
    public function get_by_id($no, $fields='*') {
        $param = new ModelParameter();
        $param->select($fields);
        $param->where(array('account'=>$no));
        return $this->get_one($param);       	

    }
}