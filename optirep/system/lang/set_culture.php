<?php
	@session_start();

	if(!isset($_SESSION["LANGUAGE"]))
	{
		setCulture();	
	}
	elseif (isset($_POST['culture']))
	{
		$_SESSION['LANGUAGE'] = $_POST['culture'];		
	}
	
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once(strtolower($_SESSION['LANGUAGE']) . '.php');
	
	
	//////////////////////////////////////////////////////////////////
	// FUNCTIONS
	//////////////////////////////////////////////////////////////////
	function setCulture()
	{
		// Define sites language depending on browser
		// language return value.
		if(getDefaultLanguage() != NULL)
		{
			if((getDefaultLanguage() == "fr-ca") ||
			(getDefaultLanguage() == "fr-fr"))
			{
				$_SESSION["LANGUAGE"] = "fr";
			}
			else
			{
				$_SESSION["LANGUAGE"] = "en";
			}
		}
		else
		{
			$_SESSION["LANGUAGE"] = "fr";
		}
	}
	
	
	function getDefaultLanguage()
	{
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
		{
			return parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		}
		else
		{
			return parseDefaultLanguage(NULL);
		}
	}
	
	function parseDefaultLanguage($http_accept, $deflang = "fr")
	{
		if(isset($http_accept) && strlen($http_accept) > 1)
		{
			# Split possible languages into array
			$x = explode(",",$http_accept);
	
			foreach ($x as $val)
			{
				#check for q-value and create associative array. No q-value means 1 by rule
				if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches))
				{
					$lang[$matches[1]] = (float)$matches[2];
				}
				else
				{
					$lang[$val] = 1.0;
				}
			}
	
				#return default language (highest q-value)
				$qval = 0.0;
	
				foreach ($lang as $key => $value)
				{
					if ($value > $qval)
					{
						$qval = (float)$value;
						$deflang = $key;
					}
				}
			}
	
			return strtolower($deflang);
		}
?>