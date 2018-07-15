<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Date_util {
    

    /**
    * 將字串日期格式化
    *
    * @param $strDate 字串日期
    * @param $targetFormat 日期格式
    * @param $sourceFormat 字串日期原本的格式，以陣列表示格式順序。
    * @return 格式化的日期
    */
    function format_date($strDate, $targetFormat='Y/m/d', $sourceFormat=array("Y","m","d","H","i","s")) {
        if ($strDate == '') {
            return '';
        }
        $date_array = $this->split_date($strDate, $sourceFormat);
        $strDate = '';
        foreach($sourceFormat as $f) {
            if (isset($date_array[$f]) && $date_array[$f] != '') {
                if ($f == 'm' || $f == 'd') {
                    $strDate .= '/';
                } else if ($f == 'i' || $f == 's') {
                    $strDate .= ':';
                }
                $strDate .= $date_array[$f];
            }
        }

        return date($targetFormat, strtotime($strDate));
    
    }
    
    function split_date($strDate, $format=array("Y", "m", "d")) {
        $d = preg_split("[-/]", $strDate);
        $date_array = array("m" => "", "d" => "", "Y" => "");
        if (count($d) == 1) {
            // 無日期分格符號
            $i = 0;
            foreach($format as $f) {
                if ($f == "m" || $f == "d" || $f == "H" || $f == "i" || $f == "s") {
                    if ($i + 2 > strlen($strDate)) {
                        break;
                    }
                    $date_array[$f] = substr($strDate, $i, 2);
                    $i += 2;
                } else if ($f == "Y") {
                    if ($i + 4 > strlen($strDate)) {
                        break;
                    }
                    $date_array[$f] = substr($strDate, $i, 4);
                    $i += 4;
                }
            }
        } else if (count($d) > 1) {
            $i = 0;
            for ($i=0; $i<count($d); $i++) {
                $date_array[$format[$i]] = $d[$i];
            }
        }
        return $date_array;
    }
}