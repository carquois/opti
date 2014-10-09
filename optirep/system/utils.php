<?php

	//////////////////////////////////////////////////////////////////
	// CHECK TOKEN
	//////////////////////////////////////////////////////////////////
	/*function checkToken(){
	 if(!isset($_SESSION['admin']))
	 {
	echo("<script>$(function(){ window.location = '/admin';  });</script>");
	exit();
	}
	}*/

	//////////////////////////////////////////////////////////////////
	// Define site's URL
	//////////////////////////////////////////////////////////////////
	function defineURL()
	{
		$URL = 'http';
	
		if( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off'){ $URL .= "s"; }
	
		$URL .= "://";
		if($_SERVER["SERVER_PORT"]!="80" && $_SERVER["SERVER_PORT"]!="443")
		{
			$URL .= $_SERVER['HTTP_HOST'].":".$_SERVER["SERVER_PORT"];
		}
		else
		{
			$URL .= $_SERVER['HTTP_HOST'];
		}
	
		return $URL;
	}


	//////////////////////////////////////////////////////////////////
	// Set language translation string
	//////////////////////////////////////////////////////////////////
	function lang($text)
	{
		global $lang;
		if(isset($lang[$text]))
		{
			echo($lang[$text]);
		}
		else
		{
			echo("????????");
		}
	}
	
	
	//////////////////////////////////////////////////////////////////
	// Scrub for Database Entry
	//////////////////////////////////////////////////////////////////
	function scrub($val)
	{
		return mysql_real_escape_string($val);
	}
	
	//////////////////////////////////////////////////////////////////
	// Shorten string
	//////////////////////////////////////////////////////////////////
	function shortenString($val,$len)
	{
		if(strlen($val) > $len)
		{ 
			return(rtrim(substr($val, 0, $len)) . "&hellip;");
		}
		else
		{
			return($val);
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// Hellip string
	//////////////////////////////////////////////////////////////////
	function hellipString($val)
	{	
		return($val . " " . "&hellip;");
	}
	
	//////////////////////////////////////////////////////////////////
	// Timestamp formatting
	//////////////////////////////////////////////////////////////////
	function formatTimestamp($val)
	{
		return str_replace(" ", "&nbsp;", date('n/j/y', strtotime($val)));
	}

	//////////////////////////////////////////////////////////////////
	// GUID GENERATOR
	//////////////////////////////////////////////////////////////////
	function create_guid()
	{
		if (function_exists('com_create_guid'))
		{
			return com_create_guid();
		}
		else
		{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtolower(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			
			return $uuid;
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// Include and Get params
	//////////////////////////////////////////////////////////////////
	//include_get_params('organization_types.php?orgt='. $titi);	
	function include_get_params($file)
	{
		$parts = explode('?', $file);
	
		if (isset($parts[1]))
		{
			parse_str($parts[1], $output);
				
			foreach ($output as $key => $value)
			{
				$_GET[$key] = $value;
			}
		}
	
		include($parts[0]);
	}
	
	//////////////////////////////////////////////////////////////////
	// Include once and Get params
	//////////////////////////////////////////////////////////////////
	//include_once_get_params('organization_types.php?orgt='. $titi);
	function include_once_get_params($file)
	{
		$parts = explode('?', $file);
	
		if (isset($parts[1]))
		{
			parse_str($parts[1], $output);
	
			foreach ($output as $key => $value)
			{
				$_GET[$key] = $value;
			}
		}
	
		include_once($parts[0]);
	}
	
	//////////////////////////////////////////////////////////////////
	// Geocoding - returns the lat lng of a raw address
	//////////////////////////////////////////////////////////////////
	function geocodeAddress($rawAdd)
	{
		// OPTI-REP-TODO: Google API try to set Culture depending on entity prefrences.
		//add the user entered location to the Google Maps API url query string
		$gmapsApiAdd = "http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ","+", urlencode($rawAdd))."&sensor=false";
	
		//Open the Google Maps API and send it the above url containing user entered address
		//Google Maps will return a JSON file (Javascript multidimensional array)
		if($results = @file_get_contents($gmapsApiAdd))
		{
			//convert the json file to PHP array
			$response = json_decode($results, true);
				
			//If the user entered address matched a Google Maps API address, it will return 'OK' in the status field.
			if($response["status"] == "OK")
			{				
				$address_parts = array();
				
				for ($i = 0; $i < count($response["results"][0]["address_components"]) ; $i++)
				{
					$type = $response["results"][0]["address_components"][$i]['types'][0];
				
					if ($type == 'street_number')
					{						
						$address_parts["street_number"] = $response["results"][0]["address_components"][$i]['long_name'];
					}
					
					if ($type == 'route')
					{
						$address_parts["street_route"] = $response["results"][0]["address_components"][$i]['long_name'];
					}
					
					if ($type == 'locality')
					{
						$address_parts["city"] = $response["results"][0]["address_components"][$i]['long_name'];
					}
				
        			if ($type == 'administrative_area_level_1')
			        {
			        	$address_parts["province_state"] = $response["results"][0]["address_components"][$i]['long_name'];
			        	$address_parts["province_state_short"] = $response["results"][0]["address_components"][$i]['short_name'];
        			}
				
        			if ($type == 'postal_code')
        			{
				        $address_parts["postal_zip_code"] = $response["results"][0]["address_components"][$i]['long_name'];
					}
				
	        		if ($type == 'country')
	        		{
	        			$address_parts["country_region"] = $response["results"][0]["address_components"][$i]['long_name'];
	        			$address_parts["country_region_short"] = $response["results"][0]["address_components"][$i]['short_name'];
	        		}
				}
				
				//If okay, find the lat and lng values and assign them to local array
				$address_parts["lat"] = $response["results"][0]["geometry"]["location"]["lat"];
				$address_parts["lng"] = $response["results"][0]["geometry"]["location"]["lng"];
	
				return $address_parts;
			}
			elseif ($response["status"] == "OVER_QUERY_LIMIT")
			{
				// OPTI-REP-TODO: return message concerning $response["status"] == "OVER_QUERY_LIMIT".
			}
		}
		else
		{
			// OPTI-REP-TODO: return message concerning 'Error: Address not found';
		}
	}
	
	
	
	// Sign a URL with a given crypto key
	// Note that this URL must be properly URL-encoded
	function signUrl($myUrlToSign, $privateKey)
	{
		// parse the url
		$url = parse_url($myUrlToSign);
	
		$urlPartToSign = $url['path'] . "?" . $url['query'];
	
		// Decode the private key into its binary format
		$decodedKey = decodeBase64UrlSafe($privateKey);
	
		// Create a signature using the private key and the URL-encoded
		// string using HMAC SHA1. This signature will be binary.
		$signature = hash_hmac("sha1",$urlPartToSign, $decodedKey,  true);
	
		$encodedSignature = encodeBase64UrlSafe($signature);
	
		return $myUrlToSign."&signature=".$encodedSignature;
	}	
	//echo signUrl("http://maps.google.com/maps/api/geocode/json?address=New+York&sensor=false&client=clientID", 'vNIXE0xscrmjlyV-12Nj_BvUPaw=');
	
	// Encode a string to URL-safe base64
	function encodeBase64UrlSafe($value)
	{
		return str_replace(array('+', '/'), array('-', '_'), base64_encode($value));
	}
	
	// Decode a string from URL-safe base64
	function decodeBase64UrlSafe($value)
	{
		return base64_decode(str_replace(array('-', '_'), array('+', '/'), $value));
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	// FORMAT PHONE NUMBER
	// Even including formats with extensions.
	/////////////////////////////////////////////////////////////////////////////////
	function format_phone_number($phone_number = '', $convert = true, $trim = true)
	{
		
		// If we have not entered a phone number just return empty
		if (empty($phone_number))
		{
			return;
		}
		
		// Keep original phone in case of problems later on but without special characters
		$OriginalPhone = $phone_number;
		
		// Verify if phone number contains an extension
		if (preg_match("/[\s]?[x|#|\s]+(\d{1,5})$/", $phone_number, $matches))
		{
			// extension
			$extension = $matches[1];
			
			// Remove extension from phone number
			$phone_number = str_replace($matches[0], "", $phone_number);
		}
		
	
		// Strip out any extra characters that we do not need only keep letters and numbers
		$phone_number = preg_replace("/[^0-9A-Za-z]/", "", $phone_number);
		
	
		// If we have a number longer than 11 digits cut the string down to only 11
		// This is also only ran if we want to limit only to 11 characters
		if ($trim == true && strlen($phone_number)>11)
		{
			$phone_number = substr($phone_number, 0, 11);
		}
	
		// Do we want to convert phone numbers with letters to their number equivalent?
		// Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
		if ($convert == true && !is_numeric($phone_number))
		{
			$replace = array('2'=>array('a','b','c'),
							 '3'=>array('d','e','f'),
							 '4'=>array('g','h','i'),
							 '5'=>array('j','k','l'),
							 '6'=>array('m','n','o'),
							 '7'=>array('p','q','r','s'),
							 '8'=>array('t','u','v'),
							 '9'=>array('w','x','y','z'));
			
			// Replace each letter with a number
			// Notice this is case insensitive with the str_ireplace instead of str_replace
			foreach($replace as $digit=>$letters)
			{
				$phone_number = str_ireplace($letters, $digit, $phone_number);
			}
		}
	
		$length = strlen($phone_number);
		
		// Perform phone number formatting here
		switch ($length)
		{
			case 7:
				// Format: xxx-xxxx
				return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone_number);
			case 10:
				// Format: (xxx) xxx-xxxx
				return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone_number);
			case 11:
				// Format: x(xxx) xxx-xxxx
				return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone_number);
			default:
				// Return original phone if not 7, 10 or 11 digits long
				return $OriginalPhone;
		}	
	
		
		return $phone_number; 
	}
	
	
?>