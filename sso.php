<?php
session_start();
$_SESSION['__sso_check_cdr'] = false;
/* OAuth Start  */
//這行一定要加上去，目的取得REQUEST_TIME控制token取得
define('REQUEST_TIME', (int) $_SERVER['REQUEST_TIME']);

//設定哪裡取得oauth2_client class 
include("oauth2_client.inc");

/**
 * 下面設定與OAuth Server 溝通的參數， 
 *   $base_url 改成自己的Web Server Domain
 *   client_id 改成由OAuth管理員授權的client_id
 *   client_secret 改成申請的系統代碼
 *   redirect_uri 改成申請的redirect_uri
 */
$base_url = "http://dev.mis.ncku.edu.tw";
$server_url = "https://fs.ncku.edu.tw";
$oauth2_clients['CLOUD'] = array(
    'token_endpoint' => $server_url . '/adfs/oauth2/token',
    'auth_flow' => 'server-side',
    'client_id' => '06c49abd-7ea2-4d6a-b38f-3821ebfeb3db',
    'client_secret' => 'cloud',
    'authorization_endpoint' => $server_url . '/adfs/oauth2/authorize',
    'redirect_uri' => $base_url . '/~clouduser/CLOUD/sso.php',
    
);


// NEW一個 oauth2_client 物件
$oauth2_client = new OAuth2\Client($oauth2_clients['CLOUD'], 'CLOUD');
$oauth2_client->clearToken();
//在輸入帳號密碼完成授權後會回傳accessToken
$access_token = $oauth2_client->getAccessToken();

// echo $access_token;
// exit;

/**
 * 利用accessToken 轉換為可讀的資料，回傳 array , 回傳範例如下
 *   $result['commonname'] = "S26051017"
 *   $result['DN'] = "CN=S26051017,OU=Students,DC=ncku,DC=edu,DC=tw"
 *   $result['email'] = "s26051017@ncku.edu.tw"
 *   $result['identity'] =  "student" 或 "employee"
 */

$result = $oauth2_client->getUserIdentity($access_token);
//print_r($result);
 //[DisplayName] => 吳珮菁 [Department] => 計網中心資訊系統發展組 [employeedeptCode] => (1)50120000
//自行處理登入系統身份識別，可利用 $result['identity'] 先判別學生或職員
//其他識別是否有權限使用系統，可以將原先判別的程式寫在這裡
if (isset($result['commonname'])) {

    //成功後寫入$_SESSION[''] 與之前系統判別做銜接，正確銜接上後就可以不用修訂原系統程式。
    $_SESSION['__sso_check_cloud']=true;
    $_SESSION['__sso_psn_code_cloud']=$result['commonname'];
    $_SESSION['__sso_identity_cloud']=$result['identity'];
	$_SESSION['__sso_psn_name_cloud']=$result['DisplayName'];
	
    $_SESSION['__sso_check_cloud']=true;
    $_SESSION['__sso_psn_code_cloud']=$result['commonname'];
    $_SESSION['__sso_identity_cloud']=$result['identity'];
	$_SESSION['__sso_psn_name_cloud']=$result['DisplayName'];

	if ($result['identity']=="stff"){
		$_SESSION['__sso_dept_name_cloud']=$result['Department'];
		$dept_code = $result['employeedeptCode'];
		$dept_code = substr($dept_code, -8);
		$_SESSION['__sso_dept_code_cloud']=$dept_code;
	} else{
		$_SESSION['__sso_dept_name_cloud']=$result['studentdeptAllName'];   // 學生姓名欄位
		$_SESSION['__sso_dept_code_cloud']=$result['studentdeptNo'];	// 學生學號欄位
	}	
		
    unset($_SESSION['oauth2_client']);
    $oauth2_client->clearToken();
	//print_r($_SESSION);
    header('Location: http://dev.mis.ncku.edu.tw/~clouduser/CLOUD/index.php?c=auth&m=login');
    

    
} else { // 驗證不過就導到其他網頁處理
    $oauth2_client->clearToken();
    $_SESSION['__sso_errormsg_cdr']="成功入口帳號密碼認證失敗 ";
    header('Location: http://dev.mis.ncku.edu.tw/~clouduser/CLOUD/index.php?c=auth&m=ssologin_error');
}
/* OAuth2 End */

?>