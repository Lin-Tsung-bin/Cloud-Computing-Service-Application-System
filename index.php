<?php
/*
*---------------------------------------------------------------
* APPLICATION ENVIRONMENT
*---------------------------------------------------------------
*
* You can load different configurations depending on your
* current environment. Setting the environment also influences
* things like logging and error reporting.
*
* This can be set to anything, but default usage is:
*
*     development
*     testing
*     production
*
* NOTE: If you change these, also change the error_reporting() code below
*
*/
define('ENVIRONMENT', 'development');

/*
*---------------------------------------------------------------
* APPLICATION FOLDER NAME
*---------------------------------------------------------------
*
* If you want this front controller to use a different "application"
* folder then the default one you can set its name here. The folder
* can also be renamed or relocated anywhere on your server.  If
* you do, use a full server path. For more info please see the user guide:
* http://codeigniter.com/user_guide/general/managing_apps.html
*
* NO TRAILING SLASH!
*
*/
//$application_folder = 'ap1';

/*
* --------------------------------------------------------------------
* DEFAULT CONTROLLER
* --------------------------------------------------------------------
*
* Normally you will set your default controller in the routes.php file.
* You can, however, force a custom routing by hard-coding a
* specific controller class/function here.  For most applications, you
* WILL NOT set your routing here, but it's an option for those
* special instances where you might want to override the standard
* routing in a specific front controller that shares a common CI installation.
*
* IMPORTANT:  If you set the routing here, NO OTHER controller will be
* callable. In essence, this preference limits your application to ONE
* specific controller.  Leave the function name blank if you need
* to call functions dynamically via the URI.
*
* Un-comment the $routing array below to use this feature
*
*/
// The directory name, relative to the "controllers" folder.  Leave blank
// if your controller is not in a sub-folder within the "controllers" folder
// $routing['directory'] = '';

// The controller class file name.  Example:  Mycontroller
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']	= '';


define('DEFAULT_LAYOUT', 'layout');

define('LAYOUT_BODY', '_layout_body');

/*
 * -------------------------------------------------------------------
*  CUSTOM CONFIG VALUES
* -------------------------------------------------------------------
*
* The $assign_to_config array below will be passed dynamically to the
* config class when initialized. This allows you to set custom config
* items or override any default config values found in the config.php file.
* This can be handy as it permits you to share one application between
* multiple front controller files, with each file containing different
* config values.
*
* Un-comment the $assign_to_config array below to use this feature
*
*/
// $assign_to_config['name_of_config_item'] = 'value of config item';

// include '../ncku_framework/framework/Bootstrap.php';
	
//於正式主機時，要加上版次，請改成以下兩行	   
//define('COMMONS_PATH', '/usr/local/apache2/htdocs/nf/commons/v1.1.2/');
//include '/usr/local/apache2/htdocs/nf/framework/v1.1.2/Bootstrap.php';

//於	204 測試主機開發
//include '/usr/local/apache2/htdocs/nf/framework/Bootstrap.php';

include 'C:\wamp64\www\ncku_framework\framework\Bootstrap.php';

