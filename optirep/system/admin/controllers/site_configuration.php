<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// UPDATE CONFIGURATION
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['u']))
	{
		$config = new SiteConfiguration();
		
		$config_array = $_POST['u'];
		
		foreach($config_array as $key=>$val)
		{
			$config->config_key = $key;
			$config->config_value = $val;
			
			$config->Update();
		}
	}
	
	if(!empty($_POST['ut']))
	{
		$config = new SiteConfiguration();
	
		$config_array = $_POST['ut'];
	
		foreach($config_array as $key=>$val)
		{
			$config->config_key = $key;
			
			if(preg_match('/_fr$/', $_POST["lang"]))
			{
				$config->config_value_fr = $val;
				$config->UpdateTranslatables("site_config_value_fr");
			}
			
			if(preg_match('/_en$/', $_POST["lang"]))
			{
				$config->config_value_en = $val;
				$config->UpdateTranslatables("site_config_value_en");
			}			
		}
	}
 ?>