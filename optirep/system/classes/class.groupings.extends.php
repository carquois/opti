<?php

// COMPANY RETAILERS
class GroupingCompanies extends Companies
{

	// GROUPING COMPANIES
	public function GetGroupingCompany($grouping_id)
	{	$rs = mysql_query("SELECT company_id FROM grouping_companies WHERE grouping_id=" . $grouping_id);

		if(mysql_num_rows($rs)==0)
		{
			return false;
		}
		else
		{
			$row = mysql_fetch_array($rs);
			$this->company_id = $row['company_id'];

			$this->GetCompany();
		}


		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	}
	
	public function GetGroupingCompanies($grouping_id)
	{
		$output = array();
	
		$rs = mysql_query("SELECT company_id FROM grouping_companies WHERE grouping_id=" . $grouping_id);
	
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
		}
		else
		{
			while($row=mysql_fetch_array($rs))
			{
				$this->company_id = $row['company_id'];
			
				$this->GetCompany();			
				
				$output[] = array(
						"company_id"   => $this->company_id,
						"company_name" => $this->company_name
				);
			}
		}
	
	
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		return $output;
	}
	

	// INSERT GROUPING COMPANY ////////////////////////////////////////////
	public function InsertGroupingCompany($grouping_id, $company_id)
	{
		$rs = mysql_query("INSERT INTO grouping_companies (grouping_id,
		                                                   company_id,
		                								   rowguid) VALUES
		                                                            ('" . $grouping_id .
																	 "','" . $company_id .
																	 "','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

	}

	// UPDATE COMPANY RETAILER ////////////////////////////////////////////
	public function UpdateGroupingCompanyOnGroupingDelete($company_id)
	{
		$rs = mysql_query("UPDATE companies SET grouping_id='" . null . "' WHERE company_id=" . $company_id);

		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}

		return mysql_affected_rows();
	}

	// UPDATE COMPANY RETAILERS ////////////////////////////////////////////
	public function UpdateGroupingCompaniesOnGroupingDeletes($company_ids)
	{
		$num_updates = 0;
			
		foreach($company_ids as $id)
		{
			$rs = mysql_query("UPDATE companies SET grouping_id='" . null . "' WHERE company_id=" . $id);
			$num_updates += mysql_affected_rows();
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
			
		return $num_updates;
	}

}


// GROUPING ADDRESSES
class GroupingAddresses extends Addresses
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
	
	
	public $grouping_city_list = "";
	public $grouping_province_state_list = "";
	public $grouping_country_region_list = "";
	
	
	// GROUPING ADDRESS
	public function GetGroupingAddress($grouping_id)
	{
		$output = array();

		$rs = mysql_query("SELECT address_id FROM grouping_addresses WHERE grouping_id=" . $grouping_id);

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
	
	// GET GROUPING LATITUDE AND LONGITUDE
	public function GetGroupingLatitudeLongitude($grouping_id)
	{
		$output = array();
	
		$rs = mysql_query("SELECT address_id FROM grouping_addresses WHERE grouping_id=" . $grouping_id);
	
		if(mysql_num_rows($rs)==0)
		{
			$output = 0;
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
	
	// GROUPING CITIES
	public function GetGroupingCitiesList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.city FROM grouping_addresses rs " .
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
			
		$this->grouping_city_list = $output;
	}
	
	// GROUPING PROVINCE/STATE
	public function GetGroupingProvinceStateList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.province_state, rs2.province_state_short FROM grouping_addresses rs " .
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
	
		$this->grouping_province_state_list = $output;
	}
	
	// GROUPING COUNTRY/REGION
	public function GetGroupingCountryRegionList()
	{
		$output = array();
			
		$rs = mysql_query("SELECT rs.address_id, rs2.country_region, rs2.country_region_short FROM grouping_addresses rs " .
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
	
		$this->grouping_country_region_list = $output;
	}
	
	

	
	
	// INSERT GROUPING ADDRESS ////////////////////////////////////////////
	public function InsertGroupingAddress($grouping_id, $add_id)
	{		
		$rs = mysql_query("INSERT INTO grouping_addresses (grouping_id,
		                                                   address_id,
		                								   rowguid) VALUES
		                                                            ('" . $grouping_id .
																	  "','" . $add_id .
																	  "','" . create_guid() ."')");
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
	}
	
	// DELETE GROUPING ADDRESS ////////////////////////////////////////////
	public function DeleteGroupingAddress($grouping_id)
	{
		$rs = mysql_query("DELETE FROM grouping_addresses WHERE grouping_id=" . $grouping_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		
		return mysql_affected_rows();	
	}
	
	// DELETE GROUPING ADDRESS ////////////////////////////////////////////
	public function DeleteGroupingAddresses($grouping_ids)
	{
		$num_deletes = 0;
		 
		foreach($grouping_ids as $id)
		{
			$rs = mysql_query("DELETE FROM grouping_addresses WHERE grouping_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
		 
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
		 
		return $num_deletes;
	}
}



// GROUPING PHONE NUMBERS
class GroupingPhoneNumbers extends PhoneNumbers
{
	// This is currently used for the batch import process.
	// If these values are changed, we need to make sure that
	// the csv import file is reajusted. ELSE import process will fail.
	public $phn_import_col_names = array('phone_number1',
										 'phone_number2',
										 'phone_number_toll_free',
										 'phone_number_fax',
										 'phone_number_fax_toll_free');
	
	
	// GROUPING PHONE NUMBERS
	public function GetGroupingPhoneNumber($grouping_id)
	{
		$output = array();

		$rs = mysql_query("SELECT phone_number_id FROM grouping_phone_numbers WHERE grouping_id=" . $grouping_id);

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
	
	// INSERT GROUPING PHONE NUMBERS ////////////////////////////////////////////
	public function InsertGroupingPhoneNumber($grouping_id, $pn_id)
	{		
		$rs = mysql_query("INSERT INTO grouping_phone_numbers (grouping_id,
			                                                   phone_number_id,
			                								   rowguid) VALUES
			                                                            ('" . $grouping_id .
																		  "','" . $pn_id .
																		  "','" . create_guid() ."')");
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
	}
	
	// DELETE GROUPING PHONE NUMBER ////////////////////////////////////////////
	public function DeleteGroupingPhoneNumber($grouping_id)
	{
		$rs = mysql_query("DELETE FROM grouping_phone_numbers WHERE grouping_id=" . $grouping_id);
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
	
		return mysql_affected_rows();
	}
	
	// DELETE GROUPING PHONE NUMBERS ////////////////////////////////////////////
	public function DeleteGroupingPhoneNumbers($grouping_ids)
	{
		$num_deletes = 0;
			
		foreach($grouping_ids as $id)
		{
			$rs = mysql_query("DELETE FROM grouping_phone_numbers WHERE grouping_id=" . $id);
			$num_deletes += mysql_affected_rows();
		}
			
		if (mysql_errno())
		{
			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
		}
			
		return $num_deletes;
	}
}





?>