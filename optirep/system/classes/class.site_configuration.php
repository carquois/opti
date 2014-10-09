<?php


	class SiteConfiguration
	{
	
	    //////////////////////////////////////////////////////////////////
	    // PROPERTIES
	    //////////////////////////////////////////////////////////////////
		// KEY NAMES
		public $opti_guide_domain_name_key_name			= "opti_guide_domain_name";
		public $opti_guide_title_key_name				= "opti_guide_title";
		public $opti_rep_domain_name_key_name			= "opti_rep_domain_name";
		public $opti_rep_title_key_name					= "opti_rep_title";
		public $email_general_key_name					= "email_general";
		public $email_support_key_name					= "email_support";
		public $email_alerts_key_name					= "email_alerts";
		public $email_smtp_key_name						= "email_smtp";
		public $email_smtp_is_auth_key_name				= "email_smtp_is_auth";
		public $email_smtp_is_auth_username_key_name	= "email_smtp_is_auth_username";
		public $email_smtp_is_auth_password_key_name	= "email_smtp_is_auth_password";
		public $import_groupings_filename_key_name		= "import_groupings_filename";
		public $import_companies_filename_key_name		= "import_companies_filename";
		public $import_retailers_filename_key_name		= "import_retailers_filename";
		
		// KEY VALUES
		public $opti_guide_domain_name		= "";
		public $opti_guide_title			= "";
		public $opti_rep_domain_name		= "";
		public $opti_rep_title				= "";
		public $email_general				= "";
		public $email_support				= "";
		public $email_alerts				= "";
		public $email_smtp					= "";
		public $email_smtp_is_auth			= "";
		public $email_smtp_is_auth_username	= "";
		public $email_smtp_is_auth_password	= "";
		public $import_groupings_filename	= "";
		public $import_companies_filename	= "";
		public $import_retailers_filename	= "";
		
		
		public $config_key			= "";
		public $config_value		= "";
		
		// Translatables
		public $config_value_fr     = "";
		public $config_value_en     = "";
		
		
	    public $site_configuration_list = "";
	    
	    private $lang_name_field			= "";
	    private $site_config_friendly_name	= "";
	    private $site_config_desc			= "";
	    
	    //////////////////////////////////////////////////////////////////
	    // METHODS
	    //////////////////////////////////////////////////////////////////
	    
	    // ------------------------------------------------------------ //
	    
	    //////////////////////////////////////////////////////////////////
	    // LOAD CONFIGURATIONS
	    //////////////////////////////////////////////////////////////////
	    public function Load()
	    {
	    	if($_SESSION['LANGUAGE'] == "fr" )
	    	{
	    		$this->lang_name_field 			 = "site_config_value_fr";
	    		$this->site_config_friendly_name = "site_config_friendly_name_fr";
	    		$this->site_config_desc			 = "site_config_desc_fr";
	    	}
	    	else
	    	{
	    		$this->lang_name_field 			 = "site_config_value_en";
	    		$this->site_config_friendly_name = "site_config_friendly_name_en";
	    		$this->site_config_desc			 = "site_config_desc_en";
	    	} 
	    	
	    	
	    	$this->site_configuration_list = $this->GetConfigurationsList();
	         
	    	// OPTI-GUIDE
	    	$this->opti_guide_domain_name = $this->site_configuration_list[$this->opti_guide_domain_name_key_name]['site_config_value'];	         
	        
	    	// OPTI-GUIDE TRANSLATABLES
	    	$this->opti_guide_title	= $this->site_configuration_list[$this->opti_guide_title_key_name]['site_config_value_current_lang'];
	         
	         
	         
	        // OPTI-REP
	        $this->opti_rep_domain_name	= $this->site_configuration_list[$this->opti_rep_domain_name_key_name]['site_config_value'];
	         
	        // OPTI-REP TRANSLATABLES
	        $this->opti_rep_title = $this->site_configuration_list[$this->opti_rep_title_key_name]['site_config_value_current_lang'];
	         
	         
	        // COMMON GLOBALS
	        $this->email_general				= $this->site_configuration_list[$this->email_general_key_name]['site_config_value'];
	        $this->email_support				= $this->site_configuration_list[$this->email_support_key_name]['site_config_value'];
	        $this->email_alerts					= $this->site_configuration_list[$this->email_alerts_key_name]['site_config_value'];
	        $this->email_smtp					= $this->site_configuration_list[$this->email_smtp_key_name]['site_config_value'];
	        $this->email_smtp_is_auth			= $this->site_configuration_list[$this->email_smtp_is_auth_key_name]['site_config_value'];
	        $this->email_smtp_is_auth_username	= $this->site_configuration_list[$this->email_smtp_is_auth_username_key_name]['site_config_value'];
	        $this->email_smtp_is_auth_password	= $this->site_configuration_list[$this->email_smtp_is_auth_password_key_name]['site_config_value'];
	        
	        
	        // IMPORTS
	        $this->import_groupings_filename	= $this->site_configuration_list[$this->import_groupings_filename_key_name]['site_config_value'];
	        $this->import_companies_filename	= $this->site_configuration_list[$this->import_companies_filename_key_name]['site_config_value'];
	        $this->import_retailers_filename	= $this->site_configuration_list[$this->import_retailers_filename_key_name]['site_config_value'];
	    }    
	    
	    //////////////////////////////////////////////////////////////////
	    // RETURN CONFIGURATIONS
	    //////////////////////////////////////////////////////////////////    
	    public function GetConfigurationsList()
	    {    
	        $output = array();
	        $rs = mysql_query("SELECT * FROM site_configuration");
	        if(mysql_num_rows($rs)==0)
			{
	            $output = 0;
	        }
			else
			{
	            while($row=mysql_fetch_array($rs))
		    	{
	                $output[$row['site_config_key']] = array(
			                    "site_config_key"					=> $row['site_config_key'],
			                    "site_config_value"					=> $row['site_config_value'],
	                			"site_config_value_current_lang"	=> $row[$this->lang_name_field],
	                			"site_config_value_fr"				=> $row['site_config_value_fr'],
	                			"site_config_value_en"				=> $row['site_config_value_en'],
			                	"site_config_friendly_name"			=> $row[$this->site_config_friendly_name],			                	
			                	"site_config_desc"					=> $row[$this->site_config_desc],
	                			"is_translatable"					=> $row['is_translatable'],
	                			"is_configurable"					=> $row['is_configurable']
	                ); 
	            }
	        }
	        
	        
	        if (mysql_errno())
	        {
	        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
	        }
	        
	        return $output;     
	    }
	    
	    //////////////////////////////////////////////////////////////////
	    // RETURN CONFIGURATION
	    //////////////////////////////////////////////////////////////////    
	    public function GetConfigurationValue()
	    {    
	        $this->config_value = mysql_query("SELECT site_config_value FROM site_configuration WHERE site_config_key=" . $this->config_key);
	        
	        if (mysql_errno())
	        {
	        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
	        }
	          
	    }
	    
	    public function GetTranslatablesConfigurationValue()
	    {
	    	$this->config_value = mysql_query("SELECT ". $this->lang_name_field . " FROM site_configuration WHERE site_config_key=" . $this->config_key);
	    	 
	    	if (mysql_errno())
	    	{
	    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
	    	}
	    	 
	    }
	
	    //////////////////////////////////////////////////////////////////
	    // UPDATE CONFIGURATION
	    //////////////////////////////////////////////////////////////////    
	    public function Update()
	    {
	    	$rs = mysql_query("UPDATE site_configuration SET site_config_value='" . $this->config_value .
	    														"' WHERE site_config_key=" . $this->config_key);
	    	
	    	if (mysql_errno())
	    	{
	    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
	    	}
	    }
	    
	    public function UpdateTranslatables($field)
	    {
	    	if(preg_match('/_fr$/', $field))
	    	{	    	
		    	$rs = mysql_query("UPDATE site_configuration SET " . $field . "='" . $this->config_value_fr .
		    													"' WHERE site_config_key=" . $this->config_key);
	    	}
	    	
	    	if(preg_match('/_en$/', $field))
	    	{
	    		$rs = mysql_query("UPDATE site_configuration SET " . $field . "='" . $this->config_value_en .
	    														"' WHERE site_config_key=" . $this->config_key);
	    	}
	    	
	    	if (mysql_errno())
	    	{
	    		return "MySQL error ".mysql_errno().": ".mysql_error()."TOTO\n<br>When executing:<br>\n$rs\n<br>";
	    	}
	    }
	}

?>
