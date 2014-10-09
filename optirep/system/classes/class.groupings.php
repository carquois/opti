<?php

class Groupings
{	
	public $grouping_id					= 0;
    public $language_id       			= 0;
    public $grouping_logo 				= "";
    public $grouping_name_fr        	= "";
    public $grouping_name_en        	= "";
    public $grouping_email_general      = "";
    public $grouping_email_sales      	= "";
    public $grouping_description_fr     = "";
    public $grouping_description_en    	= "";
    public $created_by_id 				= 0;
    public $created_date 				= "";    
    public $modified_by_id 				= 0;
    public $modified_date 				= "";
    
    public $groupings_records	= "";
    public $groupings_list		= "";    
    
    public $grouping_name = "";
    
    
    private $lang_name_field = "";
    private $lang_desc_field = "";
   
    
    
    //////////////////////////////////////////////////////////////////
    // METHODS
    //////////////////////////////////////////////////////////////////
     
    // ------------------------------------------------------------ //
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "grouping_name_fr";
    		$this->lang_desc_field = "grouping_description_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "grouping_name_en";
    		$this->lang_desc_field = "grouping_description_en";
    	}
    }
    
     
    //////////////////////////////////////////////////////////////////
    // LOAD GROUPINGS. USED FOR LISTING
    //////////////////////////////////////////////////////////////////
    public function LoadList()
    {
    	$this->SetCulture();
    	$this->groupings_list = $this->GetGroupingsList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD GROUPINGS COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->groupings_records = $this->GetGroupingsRecords();
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN GROUPINGS LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetGroupingsList()
    {        
        $output = array();
        $rs = mysql_query("SELECT grouping_id, " . $this->lang_name_field . " FROM groupings ORDER BY " . $this->lang_name_field . "  ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "grouping_id"	=> $row['grouping_id'],                			
		                    "grouping_name"	=> $row[$this->lang_name_field]
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
    // RETURN GROUPINGS RECORDS
    //////////////////////////////////////////////////////////////////
    public function GetGroupingsRecords()
    {
    	$output = array();
    	$rs = mysql_query("SELECT * FROM groupings ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    						"grouping_id"            	=> $row['grouping_id'],
		                    "language_id"     			=> $row['language_id'],
		                    "grouping_logo"      		=> $row['grouping_logo'],
		                    "grouping_name_fr"  		=> $row['grouping_name_fr'],
    						"grouping_name_en"  		=> $row['grouping_name_en'],
		                    "grouping_email_general"    => $row['grouping_email_general'],
		                    "grouping_email_sales"     	=> $row['grouping_email_sales'],
    						"grouping_description_fr"   => $row['grouping_description_fr'],
		                    "grouping_description_en"   => $row['grouping_description_en'],
		                	"created_by_id"  			=> $row['created_by_id'],
		                    "created_date"   			=> $row['created_date'],
		                    "modified_by_id" 			=> $row['modified_by_id'],
		                	"modified_date"  			=> $row['modified_date']
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
    // RETURN GROUPING
    //////////////////////////////////////////////////////////////////
    public function GetGrouping()
    {
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT * FROM groupings WHERE grouping_id=" . $this->grouping_id);
    	
    	$row = mysql_fetch_array($rs);
    
    	$this->grouping_id				= $row['grouping_id'];
    	$this->language_id        		= $row['language_id'];
    	$this->grouping_logo         	= $row['grouping_logo'];
    	$this->grouping_name     		= $row[$this->lang_name_field];
    	$this->grouping_email_general    = $row['grouping_email_general'];
    	$this->grouping_email_sales      = $row['grouping_email_sales'];
    	$this->grouping_description  	= $row[$this->lang_desc_field];
    	$this->created_by_id     		= $row['created_by_id'];
    	$this->created_date     		= $row['created_date'];
    	$this->modified_by_id    		= $row['modified_by_id'];
    	$this->modified_date    		= $row['modified_date'];
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    /////////////////////////////////////////////////////////////////
    // RETURN GROUPING NAME BY ID
    //////////////////////////////////////////////////////////////////
    public function GetGroupingNameByID($id)
    {
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT " . $this->lang_name_field . " FROM groupings WHERE grouping_id = " . $id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN GROUPING ID FROM GROUPING NAME
    //////////////////////////////////////////////////////////////////
    public function GetGroupingIDFromName($grouping_name)
    {
    	$grouping_name = mysql_real_escape_string($grouping_name);
    	
    	$rs = mysql_query("SELECT grouping_id FROM groupings WHERE grouping_name_fr = '" . $grouping_name . "' OR grouping_name_en = '" . $grouping_name . "'");
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	 
    	$row = mysql_fetch_array($rs);
    	
    	return $row['grouping_id'];
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN GROUPINGS LISTING BY ID's
    //////////////////////////////////////////////////////////////////    
    public function GetGroupingsListByIDs($ids)
    {        
    	$this->SetCulture();
    	
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
                    $where_statement .= "grouping_id='" . $value . "'";
            
                }
                else
                {
                    $where_statement .= "grouping_id='" . $value . "' OR ";
                }
                $i++;
            }
        }

        
        $rs = mysql_query("SELECT * FROM groupings WHERE " . $where_statement . " ORDER BY " . $this->lang_name_field . " ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "grouping_id"            	=> $row['grouping_id'],
		                    "language_id"     			=> $row['language_id'],
		                    "grouping_logo"      		=> $row['grouping_logo'],
		                    "grouping_name"  			=> $row[$this->lang_name_field],
		                    "grouping_email_general"    => $row['grouping_email_general'],
		                    "grouping_email_sales"     	=> $row['grouping_email_sales'],
		                    "grouping_description"   	=> $row[$this->lang_desc_field],
		                	"created_by_id"  			=> $row['created_by_id'],
		                    "created_date"   			=> $row['created_date'],
		                    "modified_by_id" 			=> $row['modified_by_id'],
		                	"modified_date"  			=> $row['modified_date']
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
    // CREATE GROUPING
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
       
        $rs = mysql_query("INSERT INTO companies (grouping_id,
                                                  language_id, 
                                                  grouping_logo,
                                                  grouping_name_fr,
                                                  grouping_name_en,
                                                  grouping_email_general,
                                                  grouping_email_sales,
                                                  grouping_description_fr,
            									  grouping_description_en,
                                                  created_by_id,
                                                  created_date,
            									  modified_by_id,
                                                  modified_date,
                								  rowguid) VALUES
                                                           ('" . $this->grouping_id .
                                                           "','" . $this->language_id . 
                                                           "','" . $this->grouping_logo .
                                                           "','" . scrub($this->grouping_name_fr) .
                                                           "','" . scrub($this->grouping_name_en) .
                                                           "','" . $this->grouping_email_general .
                                                           "','" . $this->grouping_email_sales .
                                                           "','" . scrub($this->grouping_description_fr) .
            											   "','" . scrub($this->grouping_description_en) .
            											   "','" . $this->created_by_id .
                                                           "','" . date("Y-m-d H:i:s") .
            											   "','" . $this->modified_by_id .
                                                           "','" . date("Y-m-d H:i:s") .
            											   "','" . create_guid() ."')");
           
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
            
            
        $this->grouping_id = mysql_insert_id();
            
        return mysql_insert_id();
            
        
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE GROUPING
    //////////////////////////////////////////////////////////////////
	public function Update()
	{
    	$rs = mysql_query("UPDATE groupings SET grouping_id='" . $this->grouping_id .
            									"', language_id='" . $this->language_id .
            									"', grouping_logo='" . $this->grouping_logo .
                                                "', grouping_name_fr='" . scrub($this->grouping_name_fr) .
                                                "', grouping_name_en='" . scrub($this->grouping_name_en) .
                                                "', grouping_email_general='" . $this->grouping_email_general .
                                                "', grouping_email_sales='" . $this->grouping_email_sales .
                                                "', grouping_description_fr='" . scrub($this->grouping_description_fr) .
            									"', grouping_description_en='" . scrub($this->grouping_description_en) .
            									"', modified_by_id='" . $this->modified_by_id .
                                                "', modified_date='" . date("Y-m-d H:i:s") .
            									"' WHERE grouping_id=" . $this->grouping_id);
    	
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
        $rs = mysql_query("DELETE FROM groupings WHERE grouping_id=" . $this->grouping_id);
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE COMPANIES BY ID
    //////////////////////////////////////////////////////////////////
    public function DeleteGroupingsByIDs($ids)
    {
    	$num_deletes = 0;
    
    	foreach($ids as $id)
    	{
    		$rs = mysql_query("DELETE FROM groupings WHERE grouping_id=" . $id);
    		$num_deletes += mysql_affected_rows();
    	}
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    
    	return $num_deletes;
    
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE GROUPING'S LOGO
    //////////////////////////////////////////////////////////////////
    public function UpdateGroupingLogo()
    {
    	$rs = mysql_query("UPDATE groupings SET grouping_logo='' WHERE grouping_id=" . $this->grouping_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    ////////     TO DO     /////////////////////
    //////////////////////////////////////////////////////////////////
    // RETURN TRUE OR FALSE. DEPENDS IF GROUPING EXISTS OR NOT!
    //////////////////////////////////////////////////////////////////    
    public function IsAlreadyCompany($grouping_id, $grouping_name)
    {        
        $rs = mysql_query("SELECT grouping_id, grouping_name_fr FROM groupings WHERE grouping_id='" . $grouping_id . "' AND grouping_name_fr='" . $grouping_name . "'");
        
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
    // RETURN GROUPINGS LISTING BY FILTER
    //////////////////////////////////////////////////////////////////
    /* public function GetGroupingsListByUserFilters($filters)
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
    	$sql_statement = "SELECT * FROM companies " . $where_statement . " ORDER BY company_id ASC";
    
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
	    					"grouping_id"            	=> $row['grouping_id'],
	    					"language_id"     			=> $row['language_id'],
	    					"grouping_logo"      		=> $row['grouping_logo'],
	    					"grouping_name_fr"  		=> $row['grouping_name_fr'],
	    					"grouping_name_en"  		=> $row['grouping_name_en'],
	    					"grouping_email_general"    => $row['grouping_email_general'],
	    					"grouping_email_sales"     	=> $row['grouping_email_sales'],
	    					"grouping_description_fr"   => $row['grouping_description_fr'],
	    					"grouping_description_en"   => $row['grouping_description_en'],
	    					"created_by_id"  			=> $row['created_by_id'],
	    					"created_date"   			=> $row['created_date'],
	    					"modified_by_id" 			=> $row['modified_by_id'],
	    					"modified_date"  			=> $row['modified_date']
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
