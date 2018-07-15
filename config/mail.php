<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* Location: ./application/config/ */
$ncku_mail = array();

/*code : 編號*/   
/*$from,$to,$subject, $file,$replace*/
/*測試用*/
$ncku_mail['test'] = array("from" => "pers@mail.ncku.edu.tw", "subject"=>"測試信件","filename"=>"email/test", "bcc"=>array("z10109102@email.ncku.edu.tw"));
$ncku_mail['forgot'] = array("from" => "no-reply@mail.ncku.edu.tw", "subject"=>"忘記密碼","filename"=>"email/forgot", "bcc"=>array("z10109102@email.ncku.edu.tw"));




$config['ncku_mail'] = $ncku_mail;
/* End of file config.php */