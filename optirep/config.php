
<?php

	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	// THE FOLLOWING NEEDS TO BE PLACED FIRST AND IN THIS ORDER
	// DO NOT CHANGE PLEASE. UTILS.php IS NEEDED FOR FUNCTION CALLS
	// IN THIS FILE(Config.php)
	require_once('system/utils.php');
	//////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////
	// ERROR REPORTING
	//////////////////////////////////////////////////////////////////
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('error_log','_error_log');
	
	//////////////////////////////////////////////////////////////////
	// SESSION INITIALIZATION
	//////////////////////////////////////////////////////////////////
	@session_start();
	
	ini_set("session.cache_expire",360000);
	ini_set("session.gc_maxlifetime", "3600000");

	//////////////////////////////////////////////////////////////////
	// DEFINE PATHS
	//////////////////////////////////////////////////////////////////	
	if(!defined('ROOT_PATH')){ define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']); };
	if(!defined('IMPORT_FOLDER')){ define("IMPORT_FOLDER", ROOT_PATH . "/system/admin/devimport/imported_files"); };
		
	
	//////////////////////////////////////////////////////////////////
	// TIMEZONE
	//////////////////////////////////////////////////////////////////	
	date_default_timezone_set('America/Montreal');
	
    
       
    //////////////////////////////////////////////////////////////////
    // LOAD RESOURCES
    //////////////////////////////////////////////////////////////////
    // THE FOLLOWING NEEDS TO BE PLACED FIRST AND IN THIS ORDER
    // DO NOT CHANGE PLEASE
    require_once('system/dbconn.php');    
    //////////////////////////////////////////////////////////////////
    
    
    require_once('system/lang/set_culture.php');
    
   
    require_once('system/classes/class.site_configuration.php');
    require_once('system/classes/class.languages.php');
    
    require_once('system/classes/class.groupings.php');
    require_once('system/classes/class.companies.php');
    
    
    
    require_once('system/classes/class.organization_types.php');
    require_once('system/classes/class.professional_types.php');    
   
    require_once('system/classes/class.retailers.php');
    require_once('system/classes/class.retailer_types.php');
    
    
    require_once('system/classes/class.supplier_types.php');
    
    
    require_once('system/classes/class.services.php');
    require_once('system/classes/class.subscriptions.php');
    
    require_once('system/classes/class.addresses.php');
    require_once('system/classes/class.phone_numbers.php');
    
    require_once('system/classes/class.users.php');
    require_once('system/classes/class.user_types.php');
    
    
   
    // THE FOLLOWING NEEDS TO BE PLACED LAST AND IN THIS ORDER
    // DO NOT CHANGE PLEASE
    require_once('system/classes/class.groupings.extends.php');
    require_once('system/classes/class.companies.extends.php');    
    require_once('system/classes/class.retailers.extends.php');
    require_once('system/common.php');
    //////////////////////////////////////////////////////////////////
   

?>


