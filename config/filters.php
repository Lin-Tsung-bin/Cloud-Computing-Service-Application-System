<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Filters configuration
| -------------------------------------------------------------------
|
| Note: The filters will be applied in the order that they are defined
|
| Example configuration:
|
| $filter['auth'] = array('exclude', array('login/*', 'about/*'));
| $filter['cache'] = array('include', array('login/index', 'about/*', 'register/form,rules,privacy'));
|
*/
/*
$filter['perfmon'] = array(
	'include', array('*'), array('warning_time' => 0.001)
);
*/
$filter = array();
//22-25行 2018/01/18 開啟 登入畫面，再登入時會出現其他選項
$filter['auth'] = array(
    'exclude', array('auth/*',  'verifycode/*'), array('login_url'=>'./index.php?auth')
);

/*ip過濾*/
$filter['ip'] = array(
    'exclude', array(), array('allow_ip'=>array('0.0.0.0', '127.','140.116.'))
);
/*管理者權限限制*/
$filter['mana'] = array(
    'include', array('admin/*'),array()
);

