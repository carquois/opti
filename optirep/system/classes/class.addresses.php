<?php




class Addresses
{	
    // ADDRESSES
    public $address_id    		 = 0;
    public $address1    		 = "";
    public $address2			 = "";    
    public $province_state  	 = "";
    public $province_state_short = "";
    public $country_region  	 = "";
    public $country_region_short = "";
    public $city            	 = "";
    public $postal_zip_code 	 = "";    
    public $latitude        	 = "";
    public $longitude       	 = "";
    public $created_by_id 		 = 0;
    public $created_date    	 = "";
    public $modified_by_id 		 = 0;
    public $date_modified   	 = ""; 
    
	
    //////////////////////////////////////////////////////////////////
    // RETURN ADDRESS
    //////////////////////////////////////////////////////////////////
    public function GetAddress()
    {
    	$rs = mysql_query("SELECT * FROM addresses WHERE address_id=" . $this->address_id);
    	
    	$row = mysql_fetch_array($rs);
    
    	$this->address_id    		= $row['address_id'];
    	$this->address1    			= $row['address1'];
    	$this->address2				= $row['address2'];
    	$this->province_state  		= $row['province_state'];
    	$this->province_state_short = $row['province_state_short'];
    	$this->country_region  		= $row['country_region'];
    	$this->country_region_short	= $row['country_region_short'];    	
    	$this->city            		= $row['city'];
    	$this->postal_zip_code  	= $row['postal_zip_code'];
    	$this->latitude        		= $row['latitude'];
    	$this->longitude       		= $row['longitude'];    	
    	$this->created_by_id 		= $row['created_by_id'];
    	$this->created_date    		= $row['created_date'];
    	$this->modified_by_id 		= $row['modified_by_id'];
    	$this->date_modified   		= $row['modified_date'];
    
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN LATITUDE AND LONGITUDE FROM ADDRESS BY ADDRESS ID
    //////////////////////////////////////////////////////////////////
    public function GetLatitudeLongitudeFromAddress()
    {
    	$rs = mysql_query("SELECT latitude, longitude FROM addresses WHERE address_id=" . $this->address_id);
    	 
    	$row = mysql_fetch_array($rs);    
    	
    	$this->latitude		= $row['latitude'];
    	$this->longitude	= $row['longitude'];    
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN ADDRESSES LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetAddressesList()
    {        
        $output = array();
        $rs = mysql_query("SELECT * FROM addresses");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "address_id"        	=> $row['address_id'],
		                    "address1"     			=> $row['address1'],
		                    "address2"       		=> $row['address2'],
                			"province_state"    	=> $row['province_state'],
                			"province_state_short"  => $row['province_state_short'],
                			"country_region"		=> $row['country_region'],		                    
                			"country_region_short"	=> $row['country_region_short'],
                			"city"     				=> $row['city'],
		                    "postal_zip_code"  		=> $row['postal_zip_code'],
                			"latitude"    			=> $row['latitude'],
		                    "longitude"				=> $row['longitude'],		                    		                    
		                	"created_by_id"  		=> $row['created_by_id'],
		                    "created_date"   		=> $row['created_date'],
		                    "modified_by_id" 		=> $row['modified_by_id'],
		                	"modified_date"  		=> $row['modified_date']
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
    // CREATE ADDRESS
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	
    	$rs = mysql_query("INSERT INTO addresses (address1,
                                                  address2,
    											  province_state,
                                                  province_state_short,
    											  country_region,
                                                  country_region_short,
                                                  city,
                                                  postal_zip_code,
                                                  latitude,
                                                  longitude,
                                                  created_by_id,
                                                  created_date,
            									  modified_by_id,
                                                  modified_date,
                								  rowguid) VALUES
                                                           ('" . scrub($this->address1) .
											    			"','" . scrub($this->address2) .
    														"','" . scrub($this->province_state) .
											    			"','" . scrub($this->province_state_short) .
    														"','" . scrub($this->country_region) .
    														"','" . scrub($this->country_region_short) .
    														"','" . scrub($this->city) .
											    			"','" . $this->postal_zip_code .											    			
											    			"','" . $this->latitude .
    														"','" . $this->longitude .
											    			"','" . $this->created_by_id .
											    			"','" . date("Y-m-d H:i:s") .
											    			"','" . $this->modified_by_id .
											    			"','" . date("Y-m-d H:i:s") .
											    			"','" . create_guid() ."')");
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    
    
    	$this->address_id = mysql_insert_id();
    
    	return mysql_insert_id();
    
    	 
    
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE ADDRESS
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE addresses SET address1='" . scrub($this->address1) .
							    			"', address2='" . scrub($this->address2) .    										
							    			"', province_state='" . scrub($this->province_state) .
    										"', province_state_short='" . scrub($this->province_state_short) .
    										"', country_region='" . scrub($this->country_region) .
    										"', country_region_short='" . scrub($this->country_region_short) .
    										"', city='" . scrub($this->city) .
							    			"', postal_zip_code='" . $this->postal_zip_code .							    			
							    			"', latitude='" . $this->latitude .
    										"', longitude='" . $this->longitude .
							    			"', modified_by_id='" . $this->modified_by_id .
							    			"', modified_date='" . date("Y-m-d H:i:s") .
							    			"' WHERE address_id=" . $this->address_id);
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    
    }
    
    
    //////////////////////////////////////////////////////////////////
    // DELETE
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM addresses WHERE address_id=" . $this->address_id);
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN TRUE OR FALSE. DEPENDS IF ADDRESS EXISTS OR NOT!
    //////////////////////////////////////////////////////////////////
    public function IsAddressPresent()
    {
    	$rs = mysql_query("SELECT address1, address2, province_state, country_region, city, postal_zip_code" .
    					  " FROM addresses WHERE address1='" . $this->address1 . "'" .
    			          " AND address2='" . $this->address2 . "'" .
    					  " AND province_state='" . $this->province_state . "'" .
    			          " AND country_region='" . $this->country_region . "'" .
    					  " AND city='" . $this->city . "'" .
    					  " AND postal_zip_code='" . $this->postal_zip_code . "'");
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    
    	$row = mysql_fetch_array($rs);
    
    	if(!empty($row))
    	{
    		return true;
    	}
    
    	return false;
    
    }
    
   
    
    //////////////////////////////////////////////////////////////////
    // RETURN ADDRESSES LISTING BY ID's
    //////////////////////////////////////////////////////////////////    
    /* public function GetAddressesListByIDs($ids)
    {        
        $output = array();
        
        $where_statement = "";
        $numItems = count($ids);
        $i = 0;       
        foreach($ids as $value)
        {
            if(!empty($value))
            {
                if($i == ($numItems-1))
                {
                    $where_statement .= "address_id='" . $value . "'";
            
                }
                else
                {
                    $where_statement .= "address_id='" . $value . "' OR ";
                }
                $i++;
            }
        }
        
        $rs = mysql_query("SELECT * FROM addresses WHERE " .  $where_statement . " ORDER BY address_id ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "address_id"        	=> $row['address_id'],
		                    "address1"     			=> $row['address1'],
		                    "address2"       		=> $row['address2'],
		                    "city"     				=> $row['city'],
		                    "province_state"    	=> $row['province_state'],
                			"province_state_short"  => $row['province_state_short'],
                			"country_region"		=> $row['country_region'],		                    
                			"country_region_short"	=> $row['country_region_short'],
		                    "postal_zip_code"  		=> $row['postal_zip_code'],		                    
		                    "latitude"    			=> $row['latitude'],
		                    "longitude"				=> $row['longitude'],		                    
		                	"created_by_id"  		=> $row['created_by_id'],
		                    "created_date"   		=> $row['created_date'],
		                    "modified_by_id" 		=> $row['modified_by_id'],
		                	"modified_date"  		=> $row['modified_date']
                ); 
            }
        }
        
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
        
        return $output;        
    } */
    
    //////////////////////////////////////////////////////////////////
    // RETURN ADDRESSES LISTING BY FILTER
    //////////////////////////////////////////////////////////////////    
    /* public function GetAddressesListByUserFilters($filters)
    {        
        
        // Set filtered fields.
        $services_field = "mbs_services_ids";
        $country_field = "mbs_country";
        $province_state_field = "mbs_province";
        $city_fields = "mbs_city";        
        
        $filtered_fields = "";
        $where_statement = "";
        $key_counter = 0;
        
        foreach ($filters as $key => $value)
        {
            if($key == strtolower('service1'))
            {                
                $filtered_fields = $services_field . ",";
                
                $where_statement = "WHERE $filtered_fields LIKE '%$filters[service1]%'";
            }
            
            if($key == strtolower('service2'))
            {                
                $filtered_fields = $services_field . ",";
                $where_statement = "WHERE ($filtered_fields LIKE '%$filters[service1]%' OR $filtered_fields LIKE '%$filters[service2]%')";
            }
            
            if($key == strtolower('country'))
            {
                $filtered_fields = $country_field . ",";
                
                if(array_key_exists('service1', $filters))
                {
                    $where_statement .= " AND $filtered_fields = $value";
                }
                else
                {
                    $where_statement = "WHERE $filtered_fields = $value";
                }
            }
            
            if($key == strtolower('province_state'))
            {
                $filtered_fields = $province_state_field . ",";
                $where_statement .= " AND $filtered_fields = $value";
            }
            
            if($key == strtolower('city'))
            {
                $filtered_fields = $city_fields . ",";
                $where_statement .= " AND $filtered_fields = $value";
            }
            $key_counter++;
        }

        // Remove trailing comma at the end of the fields being filtered.
        $where_statement = str_replace(', ', ' ', $where_statement);
        $sql_statement = "SELECT * FROM addresses " . $where_statement . " ORDER BY address_id ASC";
      
        $output = array();
                
        $rs = mysql_query($sql_statement);
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "address_id"        	=> $row['address_id'],
		                    "address1"     			=> $row['address1'],
		                    "address2"       		=> $row['address2'],
		                    "city"     				=> $row['city'],
		                    "province_state"    	=> $row['province_state'],
                			"province_state_short"  => $row['province_state_short'],
                			"country_region"		=> $row['country_region'],		                    
                			"country_region_short"	=> $row['country_region_short'],
		                    "postal_zip_code"  		=> $row['postal_zip_code'],
		                    "latitude"    			=> $row['latitude'],
		                    "longitude"				=> $row['longitude'],		                    		                    
		                	"created_by_id"  		=> $row['created_by_id'],
		                    "created_date"   		=> $row['created_date'],
		                    "modified_by_id" 		=> $row['modified_by_id'],
		                	"modified_date"  		=> $row['modified_date']
                ); 
            }
        }
        
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
        
        return $output;        
    } */
    
    
}



?>