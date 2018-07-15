<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * include default mime types
 */
include(FRAMEWORK_PATH.'config/mimes.php');
$mimes['xls']=array('application/excel', 'application/vnd.ms-excel', 'application/msexcel','composite document file v2 document, no summary info');
$mimes['xlsm']=array('application/vnd.ms-excel');

/*
| -------------------------------------------------------------------
| set customized MIME TYPES
| -------------------------------------------------------------------
| $mimes['ext'] = 'mime-type';
| such as
| $mimes['pdf'] = array('application/pdf', 'application/x-download');
| $mimes['my'] = 'application/octet-stream';
*/



/* End of file mimes.php */
/* Location: ./application/config/mimes.php */
