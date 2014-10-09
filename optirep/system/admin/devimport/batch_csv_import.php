<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	
	//$time_start = microtime(true);
	//set_time_limit(0);
	
	$csv_columns_valid = true;
	
	if(isset($_GET['batch']))
	{		
		// CHECK WHICH TYPE OF ENTITY IS BEING IMPORTED
		$entity_import = array_search($_POST['csv'], $cmn_cfg_accepted_import_files_array);
		
		if($cmn_cfg_accepted_import_files_array[$entity_import] == $cmn_cfg_accepted_import_files_array['import_groupings_filename'])
		{
			$entity_import = preg_replace('/\\.[^.\\s]{3}$/', '', $cmn_cfg_accepted_import_files_array['import_groupings_filename']);
		}
		elseif($cmn_cfg_accepted_import_files_array[$entity_import] == $cmn_cfg_accepted_import_files_array['import_companies_filename'])
		{
			$entity_import = preg_replace('/\\.[^.\\s]{3}$/', '', $cmn_cfg_accepted_import_files_array['import_companies_filename']);
		}
		elseif($cmn_cfg_accepted_import_files_array[$entity_import] == $cmn_cfg_accepted_import_files_array['import_retailers_filename'])
		{
			$entity_import = preg_replace('/\\.[^.\\s]{3}$/', '', $cmn_cfg_accepted_import_files_array['import_retailers_filename']);
		}
		
		
		// IMPORT INPUT CSV FILE
		$csv_file = IMPORT_FOLDER . "/" . $_POST['csv'];

		
		
		// LOG Files
		$csv_error_file = IMPORT_FOLDER . "/" . $entity_import . "_ERRORS.csv";	
		if(file_exists($csv_error_file)) { unlink($csv_error_file); }
		
		$csv_missing_lat_lng_file = IMPORT_FOLDER . "/" . $entity_import . "_LATLNG_MISSING.csv";
		if(file_exists($csv_missing_lat_lng_file)) { unlink($csv_missing_lat_lng_file); }
		
		
		
		if(file_exists($csv_file))
		{
		
			$filecontents = file($csv_file);
			
			// MAKE SURE WE HAVE UTF-8 ENCODING
			$filecontents = array_map('utf8_encode', $filecontents);			
						
			
			if($filecontents[0] != "")
			{
				
				if($entity_import == "groupings")
				{
					$grouping = new Groupings();
					$grouping_addr = new GroupingAddresses();
					$grouping_phn = new GroupingPhoneNumbers();
				}
				else if($entity_import == "companies")
				{
					$company = new Companies();
					$company_addr = new CompanyAddresses();
					$company_phn = new CompanyPhoneNumbers();
					$grouping_company = new GroupingCompanies();
				}
				else if($entity_import == "retailers")
				{
					$retailer = new Retailers();
					$retailer_addr = new RetailerAddresses();
					$retailer_phn = new RetailerPhoneNumbers();
					$retailer_svr = new RetailerServices();
					$retailer_subs = new RetailerSubscriptions();
					$company_retailer = new CompanyRetailers();
				}
				
				// COMMON
				$address = new Addresses();
				$phone_number = new PhoneNumbers();
				
				// GET SERVICES COLUMN LIST FOR IMPORT
				$services = new Services();
				$svrs = $services->GetServicesNamesForImport();
				
				// GET SUBSCRIPTIONS COLUMN LIST FOR IMPORT
				$subscriptions = new Subscriptions();
				$subs = $subscriptions->GetSubscriptionsNamesForImport();
				
				// INITIALIZE. PRESUME ALL COLUMNS ARE PRESENT
				// IF COLUMNS ARE NOT FOUND, THIS VARIABLE WILL BE SET TO FALSE
				$csv_columns_valid = true;
				
				// FIRST VERIFY IF ALL NEEDED COLUMNS ARE PRESENT IN
				// THE FILES FIRST ROW.
				$column_headers  = str_getcsv($filecontents[0], ",", '"');
				$column_values   = array();
				$rows	 		 = array();
				$entity_record	 = array();
				$records 		 = array();
				$error_records	 = array();
				$missing_lat_lng = array();
				$addr_record 	 = array();
				$phn_record		 = array();
				$svr_record		 = array();
				$svr_ids		 = array();
				$subs_record	 = array();
				$subs_ids		 = array();
				
				
				if($entity_import == "groupings")
				{
					
				}
				elseif($entity_import == "companies")
				{
					
				}				
				elseif($entity_import == "retailers")
				{
					foreach ($column_headers as $header)
					{	
						if((!in_array($header, $retailer->ret_import_col_names)) &&
						   (!in_array($header, $retailer_addr->ret_addr_import_col_names)) &&
						   (!in_array($header, $retailer_phn->ret_phn_import_col_names)) &&
						   (!in_array($header, $svrs)) &&
						   (!in_array($header, $subs)))
						{
							$csv_columns_valid = false;
						}
						else
						{
							$rows[$header] = '';
						}
					}
				}
				
				
				if($csv_columns_valid)
				{
					$x = 0;
					
					// THIS LOOP STARTS AT 1 SINCE THE 0 ELEMENT ARE THE COLUMN NAMES
 					for ($i = 1; $i < count($filecontents); $i++)
					{
						$x = 0;
						
						$column_values = str_getcsv($filecontents[$i], ",", '"');
						
 						foreach($rows as $key=>$value)
 						{								
 							
 							// PREPARING OBJECT ARRAYS FOR ENTITIES
 							if($entity_import == "groupings")
 							{
 								
 							}
 							elseif($entity_import == "companies")
 							{
 								
 							}
 							elseif($entity_import == "retailers")
 							{
 								if(in_array($key, $retailer->ret_import_col_names))
 								{
 									$entity_record[$key] = $column_values[$x];
 								}
 								elseif(in_array($key, $retailer_addr->ret_addr_import_col_names))
	 							{
	 								$addr_record[$key] = $column_values[$x];
	 							}
	 							elseif(in_array($key, $retailer_phn->ret_phn_import_col_names))
	 							{
	 								$phn_record[$key] = $column_values[$x];
	 							}	 							
	 							elseif(in_array($key, $svrs))
	 							{
	 								$svr_record[$key] = $column_values[$x];
	 							}
	 							elseif(in_array($key, $subs))
	 							{
	 								$subs_record[$key] = $column_values[$x];
	 							}
 							}							
 							$x++;
 						}
 						
 						$complete_record[$entity_import] = $entity_record;
 						$complete_record['address'] = $addr_record;
 						$complete_record['phone_number'] = $phn_record;
 						
 						if($entity_import == "retailers")
 						{
	 						$complete_record['services'] = $svr_record;
	 						$complete_record['subscriptions'] = $subs_record;
 						}
 						
 						$records[] = $complete_record;
 					}
				}
			}
		}		
		
		foreach($records as $rec_index=>$recs)
		{
			$row_has_bad_value = false;
			
			foreach($recs as $rec_type=>$record)
			{	
				if($row_has_bad_value)
				{
					break;
				}
				
				if($rec_type == $entity_import)
				{	
					foreach($record as $key=>$value)
					{
						// THE FOLLOWING ARE ID COLUMNS IN THE CSV IMPORT FILE
						// THAT CONTAIN STRING VALUES REPRESENTING ONE OF THE ENTITIES.
						// HERE WE GET THE CORRESPONDING ID.
						if($key == 'grouping_id')
						{
							if(!empty($value))
							{
								if(cmnGetGroupingIDFromName($value) != false)
								{
									$record[$key] = cmnGetGroupingIDFromName($value);
								}
								else
								{
									$row_has_bad_value = true;
								}
							}
							else
							{
								$record[$key] = 0;
							}
						}
						elseif($key == 'company_id')
						{	
							if(!empty($value))
							{
								if(cmnGetCompanyIDFromName($value) != false)
								{
									$record[$key] = cmnGetCompanyIDFromName($value);
								}
								else
								{
									$row_has_bad_value = true;
								}
							}
							else
							{
								$record[$key] = 0;
							}
						}
						elseif($key == 'retailer_type_id')
						{							
							if(cmnGetretailerTyeIDFromName($value) != false)
							{
								$record[$key] = cmnGetretailerTyeIDFromName($value);
							}
							else
							{
								$row_has_bad_value = true;
							}							
						}
						
						
						// NOW WE CHECK IF WE WERE ABLE TO ASSOCIATE THE IMPORT
						// FILE STRING VALUE WITH A CORRESPONDING ID. IF NOT BUILD
						// AN RECORD ERROR ARRAY.
						if($row_has_bad_value)
						{
							array_push($error_records, $records[$rec_index]);
							unset($records[$rec_index]);
							break;
						}
						
						
						// FILL UP ENTITY PROPERTIES BEFORE ENTITY RECORD CREATION
						if($entity_import == "groupings")
						{
							$grouping->$key = $record[$key];
						}
						elseif($entity_import == "companies")
						{
							$company->$key = $record[$key];
						}
						elseif($entity_import == "retailers")
						{	
							$retailer->$key = $record[$key];
						}
					}					
				}
				elseif($rec_type == 'address')
				{
					foreach($record as $key=>$value)
					{
						$address->$key = $record[$key];
					}
					
					// GOOGLE BUSINESS API LIMITS: 10 per second / 2500 24/hrs
					if(($rec_index + 1) % 10 == 0)
					{						
						sleep(1);
					}
					
					// Call the geocodeAddress function passing Raw Address
					// and get the latitude and longitude values from Google API
					$address_parts = geocodeAddress($address->address1 .', '.
											  		$address->city . ', ' .
											  		$address->province_state . ', ' .
											  		$address->country_region . ', ' .
											  		$address->postal_zip_code);
						
					if(count($address_parts) > 0)
					{
						$address->address1 				= ((!empty($address_parts['street_number'])) && (!empty($address_parts['street_route']))) ? $address_parts['street_number'] . " " . $address_parts['street_route'] : $address->address1;
						
						$address->city 					= (!empty($address_parts['city'])) ? $address_parts['city'] : $address->city;
						$address->province_state		= (!empty($address_parts['province_state'])) ? $address_parts['province_state'] : $address->province_state;
						$address->province_state_short 	= (!empty($address_parts['province_state_short'])) ? $address_parts['province_state_short'] : $address->province_state_short;
						$address->country_region 		= (!empty($address_parts['country_region'])) ? $address_parts['country_region'] : $address->country_region;
						$address->country_region_short 	= (!empty($address_parts['country_region_short'])) ? $address_parts['country_region_short'] : $address->country_region_short;
						$address->postal_zip_code 		= (!empty($address_parts['postal_zip_code'])) ? $address_parts['postal_zip_code'] : $address->postal_zip_code;
						
						if(!empty($address_parts['lat']) && !empty($address_parts['lng']))
						{
							$address->latitude = $address_parts['lat'];
							$address->longitude = $address_parts['lng'];
						}
						else
						{
							$address->latitude = 0.00;
							$address->longitude = 0.00;
								
							array_push($missing_lat_lng,$records[$rec_index]);
						}
						
						if($address->latitude == 0 || $address->longitude == 0)
						{
							array_push($missing_lat_lng,$records[$rec_index]);
						}						
					}
					else
					{
						$address->latitude = 0.00;
						$address->longitude = 0.00;
					
						array_push($missing_lat_lng,$records[$rec_index]);
					}
				}				
				elseif($rec_type == 'phone_number')
				{
					foreach($record as $key=>$value)
					{
						$phone_number->$key = format_phone_number($record[$key]);
					}
				}
				elseif($rec_type == 'services')
				{
					foreach($record as $key=>$value)
					{
						if($value)
						{
							array_push($svr_ids, cmnGetServiceIDFromName($key));							
						}
					}
				}
				elseif($rec_type == 'subscriptions')
				{
					foreach($record as $key=>$value)
					{
						if($value)
						{
							array_push($subs_ids, cmnGetSubcsriptionIDFromName($key));							
						}
					}
				}				
			}
			
			
			if(!$row_has_bad_value)
			{			
				// INSERT RECORD
				$record_id	= 0;
				$add_id 	= 0;
				$pn_id 		= 0;
				
				if($entity_import == "groupings")
				{
					// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
					$grouping->created_by_id = 2;
					$grouping->modified_by_id = 2;
					
					$record_id = $grouping->Create();
				}
				elseif($entity_import == "companies")
				{
					// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
					$company->created_by_id = 2;
					$company->modified_by_id = 2;
					
					$record_id = $company->Create();
				}
				elseif($entity_import == "retailers")
				{
					// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
					$retailer->created_by_id = 2;
					$retailer->modified_by_id = 2;
					
					$record_id = $retailer->Create();
				}
	
				if($record_id > 0)
				{					
					// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
					$address->created_by_id = 2;
					$address->modified_by_id = 2;
					
					$add_id = $address->Create();					
					
					// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
					$phone_number->created_by_id = 2;
					$phone_number->modified_by_id = 2;
					
					$pn_id = $phone_number->Create();
					
					if($entity_import == "groupings")
					{					
						$grouping_addr->InsertGroupingAddress($record_id, $add_id);
						$grouping_phn->InsertGroupingPhoneNumber($record_id, $pn_id);					
					}
					elseif($entity_import == "companies")
					{
						$company_addr->InsertCompanyAddress($record_id, $add_id);
						$company_phn->InsertCompanyPhoneNumber($record_id, $pn_id);					
					}
					elseif($entity_import == "retailers")
					{					
						$retailer_addr->InsertRetailerAddress($record_id, $add_id);
						$retailer_phn->InsertRetailerPhoneNumber($record_id, $pn_id);
					}
					
					
					// IF SERVICES
					if(count($svr_ids) > 0)
					{
						foreach($svr_ids as $svr_id)
						{
							$retailer_svr->InsertRetailerService($record_id, $svr_id);
						}
					}
						
					// IF SUBSCRIPTIONS
					if(count($subs_ids) > 0)
					{
						foreach($subs_ids as $sub_id)
						{
							$retailer_subs->InsertRetailerSubscription($record_id, $sub_id);
						}
					}
					
					
					if($entity_import == "companies")
					{
						if($grouping_company->InsertGroupingCompany($grouping->grouping_id, $record_id));					
					}
					elseif($entity_import == "retailers")
					{
						if($retailer->company_id > 0)
						{
							$company_retailer->InsertCompanyRetailer($retailer->company_id, $record_id);
						}
					}
				}
				else 
				{
					array_push($error_records,$record_id);
				}
			}
		}
		
		if($csv_columns_valid)
		{
			if(count($error_records) > 0)
			{
				CreateCSVImportInfoFile($csv_error_file, $error_records, $column_headers);
			}
			
			if(count($missing_lat_lng) > 0)
			{
				CreateCSVImportInfoFile($csv_missing_lat_lng_file, $missing_lat_lng, $column_headers);
			}			
		}
		
		//$time_end = microtime(true);
		//$time = $time_end - $time_start;
		
		echo json_encode($csv_columns_valid);
	}
	
	
	function CreateCSVImportInfoFile($filepath, $error_records, $column_headers)
	{		
		$records = array();
		
		$file = fopen($filepath, 'a');
		fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
		
		// WRITE COLUMN NAMES TO CSV FILE
		fputcsv($file, $column_headers);
		
		foreach($error_records as $rec_index=>$recs)
		{
			if(!is_array($recs))
			{
				// WRITE ERROR MESSAGE IN CSV
				$recs = preg_replace("/[\n\r[^\s]]/", "",$recs);
				//$recs = strip_tags($recs);
				
				array_push($records, '"' . $recs . '"');
			}
			else
			{
				foreach($recs as $rec_type=>$error_record)
				{
					foreach($error_record as $key=>$value)
					{
						array_push($records, $value);
					}
				}
			}		
			
			fputcsv($file, $records, ',', '"');
			$records = array();
		}
		
		fclose($file);
	}
	
?>
