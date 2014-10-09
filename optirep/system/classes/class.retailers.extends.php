<?php

// RETAILER ADDRESSES
class RetailerAddresses extends Addresses
{
	// This is currently used for the batch import process.
	// If these values are changed, we need to make sure that
	// the csv import file is reajusted. ELSE import process will fail.
	public $ret_addr_import_col_names = array('address1',
										  	  'address2',
										      'city',
										      'province_state',
										      'country_region',
										  	  'postal_zip_code');
	
	
	public $retailer_city_list 			 = "";
	public $retailer_province_state_list = "";
	public $retailer_country_region_list = "";
		
	// RETAILER ADDRESS
	public function GetRetailerAddress($ret_id)
	{
		$rs = mysql_query("SELECT address_id FROM retailer_addresses WHERE retailer_id=" . $ret_id);

		if(mysql_num_rows($rs)==0)
		{
			return false;
		}
		else
		{
			$row = mysql_fetch_array($rs);
			$this->address_id = $row['address_id'];

			$this->GetAddress();
		}


		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	}

	// RETAILER LATITUDE AND LONGITUDE 
	public function GetRetailerLatitudeLongitude($ret_id)
	{
		$rs = mysql_query("SELECT address_id FROM retailer_addresses WHERE retailer_id=" . $ret_id);
	
		if(mysql_num_rows($rs)==0)
		{
			return false;
		}
		else
		{
			$row = mysql_fetch_array($rs);			
			$this->address_id = $row['address_id'];
	
			$this->GetLatitudeLongitudeFromAddress();
		}
	
	
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	}
	
	// RETAILER LATITUDE AND LONGITUDE BY USER FILTER
	public function GetRetailerLatitudeLongitudeByUserFilters($ret_id, $filters)
	{
		//$output = array();
		 
		if(count($filters) > 0)
		{
			// Set filtered fields.
			$country_region_short_field = "country_region_short";
			$province_state_short_field = "province_state_short";
			$city_field 		  		= "city";
			 
			$filtered_fields = "";
			$where_statement = "";
			 
			foreach ($filters as $key => $value)
			{
				if(strtolower($key) == strtolower($country_region_short_field))
				{
					$filtered_fields = $country_region_short_field;					 
					$where_statement .= " AND $filtered_fields = '$value'";
				}
			  
				if(strtolower($key) == strtolower($province_state_short_field))
				{
					$filtered_fields = $province_state_short_field;
					$where_statement .= " AND $filtered_fields = '$value'";
				}
				
				if(strtolower($key) == strtolower($city_field))
				{
					$filtered_fields = $city_field;
					$where_statement .= " AND $filtered_fields = '$value'";
				}
			}
			
			// return if where statement variable is empty. No need to continue.
			if(empty($where_statement)) { return; }
			 
			
			$sql_statement = "SELECT address_id FROM retailer_addresses WHERE retailer_id=" . $ret_id;
			 
			$rs = mysql_query($sql_statement);
			 
			if(mysql_num_rows($rs)==0)
			{
				$output = false;
			}
			else
			{
				$row = mysql_fetch_array($rs);
				$this->address_id = $row['address_id'];
				
				
				// Remove trailing comma at the end of the fields being filtered.
				//$where_statement = str_replace(', ', ' ', $where_statement);
				
				$sql_statement = "SELECT latitude, longitude FROM addresses WHERE address_id=" . "'" . $this->address_id . "'". $where_statement;
				$rs2 = mysql_query($sql_statement);
				

				if(mysql_num_rows($rs2)==0)
				{
					$output = false;
				}
				else
				{		
					while($row=mysql_fetch_array($rs2))
					{
						$this->latitude = $row['latitude'];
						$this->longitude = $row['longitude'];
					}
				}
			}
			 
			if (mysql_errno())
			{
				return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
			}
		}
		 
		//return $output;		
	}
	
	// RETAILER CITIES
	public function GetRetailerCitiesList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.city FROM retailer_addresses rs " .
							"JOIN addresses rs2 ON rs.address_id = rs2.address_id GROUP BY rs2.city ORDER BY rs2.city ASC");
		 
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			while($row=mysql_fetch_array($rs))
			{
				$output[] = array(
						"city" => $row['city']
				);
			}
		}
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
		$this->retailer_city_list = $output;
	}
	
	// RETAILER PROVINCE/STATE
	public function GetRetailerProvinceStateList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.province_state, rs2.province_state_short FROM retailer_addresses rs " .
							"JOIN addresses rs2 ON rs.address_id = rs2.address_id GROUP BY rs2.province_state ORDER BY rs2.province_state ASC");
			
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			while($row=mysql_fetch_array($rs))
			{
				$output[] = array(
						"province_state" => $row['province_state'],
						"province_state_short" => $row['province_state_short']
				);
			}
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		$this->retailer_province_state_list = $output;
	}
	
	// RETAILER COUNTRY/REGION
	public function GetRetailerCountryRegionList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.country_region, rs2.country_region_short FROM retailer_addresses rs " .
							"JOIN addresses rs2 ON rs.address_id = rs2.address_id GROUP BY rs2.country_region ORDER BY rs2.country_region ASC");
			
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			while($row=mysql_fetch_array($rs))
			{
				$output[] = array(
						"country_region" => $row['country_region'],
						"country_region_short" => $row['country_region_short']
				);
			}
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		$this->retailer_country_region_list = $output;
	}
	
	// INSERT RETAILER ADDRESS ////////////////////////////////////////////
	public function InsertRetailerAddress($ret_id, $add_id)
	{		
		$rs = mysql_query("INSERT INTO retailer_addresses (retailer_id,
		                                                   address_id,
		                								   rowguid) VALUES
		                                                           ('" . $ret_id .
																	"','" . $add_id .
																	"','" . create_guid() ."')");
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
	}
	
	// DELETE RETAILER ADDRESS ////////////////////////////////////////////
	public function DeleteRetailerAddress($ret_id)
	{
		$rs = mysql_query("DELETE FROM retailer_addresses WHERE retailer_id=" . $ret_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
		return mysql_affected_rows();	
	}
	
	// DELETE RETAILER ADDRESS ////////////////////////////////////////////
	public function DeleteRetailerAddresses($ret_ids)
	{
		$num_deletes = 0;
		 
		foreach($ret_ids as $id)
		{
			$rs = mysql_query("DELETE FROM retailer_addresses WHERE retailer_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		 
		return $num_deletes;
	}
}



// RETAILER PHONE NUMBERS
class RetailerPhoneNumbers extends PhoneNumbers
{
	// This is currently used for the batch import process.
	// If these values are changed, we need to make sure that
	// the csv import file is reajusted. ELSE import process will fail.
	public $ret_phn_import_col_names = array('phone_number1',
										 	 'phone_number2',
										 	 'phone_number_toll_free',
										 	 'phone_number_fax',
										 	 'phone_number_fax_toll_free');
	
	
	// RETAILER PHONE NUMBERS
	public function GetRetailerPhoneNumber($ret_id)
	{
		$output = array();

		$rs = mysql_query("SELECT phone_number_id FROM retailer_phone_numbers WHERE retailer_id=" . $ret_id);

		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			$row = mysql_fetch_array($rs);
			$this->phone_number_id = $row['phone_number_id'];

			$output = $this->GetPhoneNumbers();
		}


		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

		return $output;
	}
	
	// INSERT RETAILER PHONE NUMBERS ////////////////////////////////////////////
	public function InsertRetailerPhoneNumber($ret_id, $pn_id)
	{		
		$rs = mysql_query("INSERT INTO retailer_phone_numbers (retailer_id,
			                                                   phone_number_id,
			                								   rowguid) VALUES
			                                                           ('" . $ret_id .
																		"','" . $pn_id .
																		"','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
	}
	
	// DELETE RETAILER PHONE NUMBER ////////////////////////////////////////////
	public function DeleteRetailerPhoneNumber($ret_id)
	{
		$rs = mysql_query("DELETE FROM retailer_phone_numbers WHERE retailer_id=" . $ret_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		return mysql_affected_rows();
	}
	
	// DELETE RETAILER PHONE NUMBERS ////////////////////////////////////////////
	public function DeleteRetailerPhoneNumbers($ret_ids)
	{
		$num_deletes = 0;
			
		foreach($ret_ids as $id)
		{
			$rs = mysql_query("DELETE FROM retailer_phone_numbers WHERE retailer_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
			
		return $num_deletes;
	}
}


// RETAILER SERVICES
class RetailerServices extends Services
{	
	// RETAILER SERVICES
	public function GetRetailerServices($ret_id)
	{
		$output = array();

		$rs = mysql_query("SELECT rs.retailer_id, rs.service_id FROM retailer_services rs " . 
																"JOIN retailer_services rs2 " .
																"ON rs.retailer_id = rs2.retailer_id " .
																"WHERE rs2.retailer_id=" . $ret_id);

		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{				
			while($row=mysql_fetch_array($rs))
			{
				$this->service_id = $row['service_id'];
			
				$this->GetService();
				
				$output[$this->service_id] = $this->service_name;
			}
		}

		
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

		return $output;
	}
	

	// INSERT RETAILER SERVICES ////////////////////////////////////////////
	public function InsertRetailerService($ret_id, $srv_id)
	{
		$rs = mysql_query("INSERT INTO retailer_services (retailer_id,
		                                                  service_id,
		                								  rowguid) VALUES
		                                                           ('" . $ret_id .
																	"','" . $srv_id .
																	"','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

	}
	
	// DO NOT USE - UPDATE RETAILER SERVICES //////////////////////////////////////////// 
	/* public function UpdateRetailerService($ret_id, $srv_id)
	{	
		
		$rs = mysql_query("UPDATE retailer_services SET retailer_id='" . $ret_id .
							"', service_id='" . $srv_id .
							"' WHERE retailer_id=" . $ret_id . "IF @@ROWCOUNT=0" .
							$this->InsertRetailerService($ret_id,$srv_id));
		
						
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}		
	
	} */
	
	// DELETE RETAILER SERVICES ////////////////////////////////////////////
	public function DeleteRetailerServices($ret_id)
	{
		$rs = mysql_query("DELETE FROM retailer_services WHERE retailer_id=" . $ret_id);		
	
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}	
	}
}




// RETAILER SUBSCRIPTIONS
class RetailerSubscriptions extends Subscriptions
{
	// RETAILER SUBSCRIPTIONS
	public function GetRetailerSubcriptions($ret_id)
	{
		$output = array();

		$rs = mysql_query("SELECT rs.retailer_id, rs.subscription_id FROM retailer_subscriptions rs " .
																	 "JOIN retailer_subscriptions rs2 " .
																	 "ON rs.retailer_id = rs2.retailer_id " .
																	 "WHERE rs2.retailer_id=" . $ret_id);		
		
		
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{			
			while($row=mysql_fetch_array($rs))
			{
				$this->subscription_id = $row['subscription_id'];
								
				$this->GetSubscription();
			
				$output[$this->subscription_id] = $this->subscription_name;
			}
		}


		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

		return $output;
	}
	

	// INSERT RETAILER SUBSCRIPTIONS ////////////////////////////////////////////
	public function InsertRetailerSubscription($ret_id, $subs_id)
	{
		$rs = mysql_query("INSERT INTO retailer_subscriptions (retailer_id,
			                                                   subscription_id,
			                								   rowguid) VALUES
			                                                           ('" . $ret_id .
																		"','" . $subs_id .
																		"','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

	}
	
	
	// DELETE RETAILER SUBSCRIPTIONS ////////////////////////////////////////////
	public function DeleteRetailerSubscriptions($ret_id)
	{
		$rs = mysql_query("DELETE FROM retailer_subscriptions WHERE retailer_id=" . $ret_id);
	
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	}
}


?>