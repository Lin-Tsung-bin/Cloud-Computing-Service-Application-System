<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Notice 注意事項
* @author 吳珮菁
*
*/
class Notice extends CI_Controller {
    
    /**
     *開發注意事項
     */
    public function index()
    {    
        $this->load->layout('notice/index');
    }
    /**
     *開發環境與版本控制介紹
     */
    public function manual1()
    {    
        $this->load->layout('notice/manual1');
    }	
    /**
     *成大PHP程式撰寫規範
     */
    public function manual2()
    {    
        $this->load->layout('notice/manual2');
    }	
	/**
     *成大PHP程式撰寫規範
     */
    public function teach()
    {    
        $this->load->layout('notice/teach');
    }
    /**
     *登入程式說明
     */
    public function login()
    {    
        $this->load->layout('notice/login');
    }
    /**
     *模組可用常數
     */
    public function constants()
    {    
        $this->load->layout('notice/constants');
    }
    /**
     * 樣版圖示說明
     */
    public function proglist()
    {    
        $this->load->layout('notice/proglist');
    }	
    /**
     * showfield參數說明
     */
    public function showfield()
    {    
        $this->load->layout('notice/showfield');
    }
	public function htmlencode(){
		echo "websys.secr.ncku.edu.tw/kpimag/Quest/index.php?c=question11131&urlid=7&submitdept=".urlencode("行政單位--計算機與網路中心--資訊系統發展組");
		
	}	
	public function decode(){
		echo $_GET['name']."<br/>";
		echo urldecode('吳珮菁');
		echo urldecode(urlencode("行政單位--計算機與網路中心--資訊系統發展組"));
		echo urldecode("行政單位--計算機與網路中心--資訊系統發展組");
	}
	public function curl(){

		//連線初始化
		$ch = curl_init();
		//定義網址
		curl_setopt($ch, CURLOPT_URL, "http://ap0512.most.gov.tw/WDL/PR_AUD/FA09/104/73/1040073722/1040073722-FA09-3.txt");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//curl總執行時間(CURLOPT_TIMEOUT 要比 CURLOPT_CONNECTTIMEOUT 大)
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		//curl等待連線的時間
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

		//執行連線
		$output = curl_exec($ch);
		
		//方法一:
		echo "<pre>";
		echo $output;
		
		//方法二：
		echo nl2br($output);
		
		//以斷行符號切割
		$output_array=explode("\n", $output);
		print_r($output_array);
		
		
		//連線結束
		curl_close($ch);
				
	}
	public function sms(){
		    /*
			foreach($user_rtn as $index=> $row){		
				$curl['memo1['.$index.']']=$row->psn_name;    	
	    		$curl['mobile['.$index.']']=$row->mobil;
				$curl['message['.$index.']']=$data['info_content'];
			}
			 */
			
			$this->load->helper('encode');
			//--系統測試--
			$curl['memo1[0]']="test";    	
			$curl['mobile[0]']="0937925209";
			$curl['message[0]']=utf8_to_big5("珮菁測試");
			
				
	    	$curl['uid']='10107006';   
	    	$curl['sys_name']='learn';
	    	//若自訂時間小於3分鐘，時間也設3分鐘後 
	    
	    	$curl['exec_date']=date("Ymd");
	    	$curl['exec_time']=date("H:i:s");
	    	    	
	    	$curl['admin_mobile']='0937925209'; 
	    	$curl['admin_email']='peiching@mail.ncku.edu.tw'; 
			//print_R($curl);
	    	$ch = curl_init();    	
	    	//specify target host
	    	//20150128 伯憲提出 由campus5.ncku.edu.tw 改為uac2.ncku.edu.tw
	    	curl_setopt($ch, CURLOPT_URL, "http://uac2.ncku.edu.tw/sms/sms_plan.php");
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     	//post data to target host
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl);
	    	$str = curl_exec($ch);
			$result=json_decode($str);
			echo "<pre>";
			print_r($result);
	
	}
	public function compute_date(){
		echo date('z',strtotime('2015/02/01'));
	}
	public function chi_year(){
		$start_yy='104';
		$start_mm='11';
		$end_yy='105';
		$end_mm='3';
		
		$cross=5;
		$i=0;
		$now_accross=0;
		while($now_accross<$cross){					
			$new_yy=($start_yy)+floor(($start_mm+$i)/13);
			$now_mm=floor(($start_mm+$i)%13);			
			if($now_mm!='0'){
				echo $new_yy.$now_mm."<br/>";
				$now_accross++;
			}	
			$i++;
		}
	}
	public function chi_year2(){
		$start_yy='104';
		$start_mm='11';
		$end_yy='105';
		$end_mm='3';
			
		$i=0;
		$now_yy=$start_yy;
		$now_mm=$start_mm;		
		while($now_yy!=$end_yy || $now_mm!=$end_mm){					
			$now_yy=($start_yy)+floor(($start_mm+$i)/13);
			$now_mm=floor(($start_mm+$i)%13);			
			if($now_mm!='0'){
				echo $now_yy.$now_mm."<br/>";
				
			}	
			$i++;
		}
	}
}    


