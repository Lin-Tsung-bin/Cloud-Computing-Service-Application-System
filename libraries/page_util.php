<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Page_util {
    var $CI;
    var $page_size=FALSE;
    
    function __construct() {
        $this->CI =& get_instance();
        $this->page_size = $this->CI->config->item('page_size');
    }
    /**
     * 設定每頁資料筆數。
     * @param $size
     */
    function set_page_size($size) {
        $this->page_size = $size;
    }
    
    function get_page_size() {
        if ($this->page_size == FALSE) {
            $this->page_size = $this->CI->config->item('page_size');
        }
        return $this->page_size;
    }
    /**
     * 限制查詢筆數
     *
     * @param $db $CI->db
     * @param $currentPage 目前的頁碼 
     */
    function limit_query($db, $currentPage=1) {
        if (isset($db)) {
            $page_size = $this->page_size;
            if ($currentPage == 1) {
                $db->limit( $this->page_size);    
            } else {
                $db->limit( $this->page_size, ($currentPage-1) *  $this->page_size);
            }
        }
    }
    /**
     * 計算頁數
     *
     * @param $list array
     * @return 頁教
     */
    function count_page($list) {
        if (!isset($list) || !is_array($list)) {
            return 0;
        }
        return $this->total_page(count($list));
    }
    /**
     * 計算頁數
     * @param $totalNum 總筆數
     * @return 頁數
     */
    function total_page($totalNum) {
        $page_size = $this->page_size;
        $totalPage = floor($totalNum/$page_size);
        if ($totalNum % $page_size != 0) {
            $totalPage ++;
        }
        return $totalPage;
    }
    /**
     * 顯示頁數選單
     * @param $totalPage 總頁數
     * @param $currentPage 目前頁數
     */
    function show_page_option($totalPage=1, $currentPage=1) {
        for ($i=1; $i<=$totalPage; $i++) {
            if ($i == $currentPage) {
                echo '<option value="'.$i.'" selected="selected">第'.$i.'頁</option>';
            } else {
                echo '<option value="'.$i.'">第'.$i.'頁</option>';
            }
        }
    }
    /**
     * 顯示分頁的頁碼連結。
     * @param $totalPage 總頁數
     * @param $currentPage 目前頁數
     * @param $linkUrl 分頁的URL，在URL字串中，以${page}表示頁碼，show_pagebar()會將${page}取代為要顯示的頁碼
     * @param $pageName 頁碼變數名稱，即${page}中的'page'，預設值為'page'。
     */
    function show_pagebar($totalPage=1, $currentPage=1, $linkUrl, $pageName='page') {

        // 顯示「第一頁」與「上一頁」的連結
        if ($currentPage > 1) {
            echo '<a href="' . str_replace('${' . $pageName . '}', '1', $linkUrl) .  '" class="first">第一頁</a>';
            echo '<a href="' . str_replace('${' . $pageName . '}', ($currentPage-1), $linkUrl) . '" class="previous">上一頁</a>';
        } else {
            echo '<span class="first">第一頁</span>'; 
            echo '<span class="previous">上一頁</span>';
        }
        
        $max_show_page = $this->CI->config->item('max_show_page');
        $p = floor($max_show_page/2); 
        
        $startPage = $currentPage - $p;             // 計算第一個顯示的頁碼
        if ($startPage < 1) {
            $startPage = 1;
        }
        
        $endPage = $startPage + $max_show_page - 1; // 最後一個顯示的頁碼
        
        // 若最後的頁碼超過總頁數，則設定為最後的頁碼為最後一頁
        if ($endPage > $totalPage){
            $endPage = $totalPage;
            // 重新計算第一個顯示的頁碼
            if ($endPage - $max_show_page  + 1 >=1) {  
                $startPage = $endPage - $max_show_page + 1 ;
            } else {
                $startPage = 1;
            }
        }
        
        // 顯示頁碼的連結
        for ($i=$startPage; $i<=$endPage; $i++) {
            if ($currentPage != $i) {
                echo ' <a href="'. str_replace('${' . $pageName . '}', $i , $linkUrl) . '" class="page">' . $i . '</a> ';
            } else {
                echo '<span class="current"> ' . $i . ' </span>';
            }
        }
        
        // 顯示「最後一頁」與「下一頁」的連結
        if ($currentPage < $totalPage) {
            echo '<a href="' . str_replace('${' . $pageName . '}', ($currentPage+1) , $linkUrl) .'" class="next">下一頁</a>';
            echo '<a href="' . str_replace('${' . $pageName . '}', $totalPage , $linkUrl) . '" class="last">最後一頁</a>';
        } else {
            echo '<span class="next">下一頁</span>';
            echo '<span class="last">最後一頁</span>';
        }

        echo ' <span class="total">共 <span class="total_num">' . $totalPage . '</span> 頁</span>';
    }   
    /**
     * 搭配MIS_GRID-顯示分頁的頁碼連結-新增下拉式選單切換頁數。
     * @param $totalPage 總頁數
     * @param $currentPage 目前頁數
     * @param $linkUrl 分頁的URL，在URL字串中，以${page}表示頁碼，show_pagebar()會將${page}取代為要顯示的頁碼
     * @param $pageName 頁碼變數名稱，即${page}中的'page'，預設值為'page'。
     */
    function show_pagebar_mis($totalPage=1, $currentPage=1, $linkUrl, $pageName='page') {

        // 顯示「第一頁」與「上一頁」的連結
        if ($currentPage > 1) {
            echo '<a page="' . str_replace('${' . $pageName . '}', '1', $linkUrl) .  '" class="first">第一頁</a>';
            echo '<a page="' . str_replace('${' . $pageName . '}', ($currentPage-1), $linkUrl) . '" class="previous">上一頁</a>';
        } else {
            echo '<span class="first">第一頁</span>'; 
            echo '<span class="previous">上一頁</span>';
        }
        
        $max_show_page = $this->CI->config->item('max_show_page');
        $p = floor($max_show_page/2); 
        
        $startPage = $currentPage - $p;             // 計算第一個顯示的頁碼
        if ($startPage < 1) {
            $startPage = 1;
        }
        
        $endPage = $startPage + $max_show_page - 1; // 最後一個顯示的頁碼
        
        // 若最後的頁碼超過總頁數，則設定為最後的頁碼為最後一頁
        if ($endPage > $totalPage){
            $endPage = $totalPage;
            // 重新計算第一個顯示的頁碼
            if ($endPage - $max_show_page  + 1 >=1) {  
                $startPage = $endPage - $max_show_page + 1 ;
            } else {
                $startPage = 1;
            }
        }
        
        // 顯示頁碼的連結
        for ($i=$startPage; $i<=$endPage; $i++) {
            if ($currentPage != $i) {
                echo ' <a page="'. str_replace('${' . $pageName . '}', $i , $linkUrl) . '" class="page">' . $i . '</a> ';
            } else {
                echo '<span class="current"> ' . $i . ' </span>';
            }
        }
        
        // 顯示「最後一頁」與「下一頁」的連結
        if ($currentPage < $totalPage) {
            echo '<a page="' . str_replace('${' . $pageName . '}', ($currentPage+1) , $linkUrl) .'" class="next">下一頁</a>';
            echo '<a page="' . str_replace('${' . $pageName . '}', $totalPage , $linkUrl) . '" class="last">最後一頁</a>';
        } else {
            echo '<span class="next">下一頁</span>';
            echo '<span class="last">最後一頁</span>';
        }
		echo "<span class='total'>目前第</span><select class='gotopage'>";
		for($i=1;$i<=$totalPage;$i++){
			if($i==$currentPage){
				echo "<option value='".$i."' selected>".$i."</option>";				
			}else{
				echo "<option value='".$i."'>".$i."</option>";		
			}

		}	
		echo "</select><span class='total'>頁</span>";		
				
        echo ' <span class="total">共 <span class="total_num">' . $totalPage . '</span> 頁</span>';
    }   
}
?>