<?php

// COMPANY RETAILERS
class CompanyRetailers extends Retailers
{
	
	// COMPANY RETAILERS
	public function GetCompanyRetailer($company_id)
	{
		$rs = mysql_query("SELECT retailer_id FROM company_retailers WHERE company_id=" . $company_id);
	
		if(mysql_num_rows($rs)==0)
		{
			return false;
		}
		else
		{
			$row = mysql_fetch_array($rs);
			$this->retailer_id = $row['retailer_id'];
	
			$this->GetRetailer();
		}
	
	
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	}	
	
	// INSERT COMPANY RETAILER ////////////////////////////////////////////
	public function InsertCompanyRetailer($company_id, $ret_id)
	{
		$rs = mysql_query("INSERT INTO company_retailers (company_id,
		                                                  retailer_id,
		                								  rowguid) VALUES
		                                                           ('" . $company_id .
																	 "','" . $ret_id .
																	 "','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
	}
	
	// UPDATE COMPANY RETAILER ////////////////////////////////////////////
	public function UpdateCompanyRetailerOnCompanyDelete($retailer_id)
	{
		$rs = mysql_query("UPDATE retailers SET company_id='" . null . "' WHERE retailer_id=" . $retailer_id);		
		
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
		return mysql_affected_rows();
	}
	
	// UPDATE COMPANY RETAILERS ////////////////////////////////////////////
	public function UpdateCompanyRetailersOnCompanyDeletes($retailer_ids)
	{
		$num_updates = 0;
			
		foreach($retailer_ids as $id)
		{
			$rs = mysql_query("UPDATE retailers SET company_id='" . null . "' WHERE retailer_id=" . $id);
			$num_updates += mysql_affected_rows();
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
			
		return $num_updates;
	}	
	
}


// COMPANY ADDRESSES
class CompanyAddresses extends Addresses
{
	// This is currently used for the batch import process.
	// If these values are changed, we need to make sure that
	// the csv import file is reajusted. ELSE import process will fail.
	public $addr_import_col_names = array('address1',
										  'address2',
										  'province_state',
										  'province_state_short',
										  'country_region',
										  'country_region_short',
										  'city',
										  'postal_zip_code');
	
	
	public $company_city_list = "";
	public $company_province_state_list = "";
	public $company_country_region_list = "";
		
	// COMPANY ADDRESS
	public function GetCompanyAddress($company_id)
	{
		$output = array();

		$rs = mysql_query("SELECT address_id FROM company_addresses WHERE company_id=" . $company_id);

		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			$row = mysql_fetch_array($rs);
			$this->address_id = $row['address_id'];

			$output = $this->GetAddress();
		}


		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

		return $output;
	}
	
	// GET COMPANY LATITUDE AND LONGITUDE
	public function GetCompanyLatitudeLongitude($company_id)
	{
		$rs = mysql_query("SELECT address_id FROM company_addresses WHERE company_id=" . $company_id);
	
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

	// COMPANY CITIES
	public function GetCompanyCitiesList()
	{
		$output = array();
	
		$rs = mysql_query("SELECT rs.address_id, rs2.city FROM company_addresses rs " .
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
			
		$this->company_city_list = $output;
	}
	
	// COMPANY PROVINCE/STATE
	public function GetCompanyProvinceStateList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.province_state, rs2.province_state_short FROM company_addresses rs " .
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
	
		$this->company_province_state_list = $output;
	}
	
	// COMPANY COUNTRY/REGION
	public function GetCompanyCountryRegionList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.country_region, rs2.country_region_short FROM company_addresses rs " .
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
	
		$this->company_country_region_list = $output;
	}
	
	
	
	// INSERT COMPANY ADDRESS ////////////////////////////////////////////
	public function InsertCompanyAddress($company_id, $add_id)
	{		
		$rs = mysql_query("INSERT INTO company_addresses (company_id,
		                                                  address_id,
		                								  rowguid) VALUES
		                                                           ('" . $company_id .
																	 "','" . $add_id .
																	 "','" . create_guid() ."')");
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
	}
	
	// DELETE COMPANY ADDRESS ////////////////////////////////////////////
	public function DeleteCompanyAddress($company_id)
	{
		$rs = mysql_query("DELETE FROM company_addresses WHERE company_id=" . $company_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
		return mysql_affected_rows();	
	}
	
	// DELETE COMPANY ADDRESSES ////////////////////////////////////////////
	public function DeleteCompanyAddresses($company_ids)
	{
		$num_deletes = 0;
		 
		foreach($company_ids as $id)
		{
			$rs = mysql_query("DELETE FROM company_addresses WHERE company_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		 
		return $num_deletes;
	}
}



// COMPANY PHONE NUMBERS
class CompanyPhoneNumbers extends PhoneNumbers
{
	// This is currently used for the batch import process.
	// If these values are changed, we need to make sure that
	// the csv import file is reajusted. ELSE import process will fail.
	public $phn_import_col_names = array('phone_number1',
										 'phone_number2',
										 'phone_number_toll_free',
										 'phone_number_fax',
										 'phone_number_fax_toll_free');
	
	
	// COMPANY PHONE NUMBERS
	public function GetCompanyPhoneNumber($company_id)
	{
		$output = array();

		$rs = mysql_query("SELECT phone_number_id FROM company_phone_numbers WHERE company_id=" . $company_id);

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
	
	// INSERT COMPANY PHONE NUMBERS ////////////////////////////////////////////
	public function InsertCompanyPhoneNumber($company_id, $pn_id)
	{		
		$rs = mysql_query("INSERT INTO company_phone_numbers (company_id,
			                                                  phone_number_id,
			                								  rowguid) VALUES
			                                                           ('" . $company_id .
																		 "','" . $pn_id .
																		 "','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
	}
	
	// DELETE COMPANY PHONE NUMBER ////////////////////////////////////////////
	public function DeleteCompanyPhoneNumber($company_id)
	{
		$rs = mysql_query("DELETE FROM company_phone_numbers WHERE company_id=" . $company_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		return mysql_affected_rows();
	}
	
	// DELETE COMPANY PHONE NUMBERS ////////////////////////////////////////////
	public function DeleteCompanyPhoneNumbers($company_ids)
	{
		$num_deletes = 0;
			
		foreach($company_ids as $id)
		{
			$rs = mysql_query("DELETE FROM company_phone_numbers WHERE company_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
			
		return $num_deletes;
	}
}



	
	// DO NOT USE - UPDATE COMPANY SERVICES //////////////////////////////////////////// 
	/* public function UpdateCompanyService($company_id, $srv_id)
	{	
		
		$rs = mysql_query("UPDATE company_services SET company_id='" . $company_id .
							"', service_id='" . $srv_id .
							"' WHERE company_id=" . $company_id . "IF @@ROWCOUNT=0" .
							$this->InsertCompanyService($company_id,$srv_id));
		
						
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}		
	
	} */
	
	






?>