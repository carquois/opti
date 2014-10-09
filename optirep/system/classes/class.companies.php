<?php

class Companies
{
    
	
	public $company_id              	= 0;
    public $grouping_id					= 0;
    public $language_id       			= 0;
    public $company_logo 				= "";
    public $company_name_fr        		= "";
    public $company_name_en        		= "";
    public $company_ressource_person	= "";
    public $company_email_general      	= "";
    public $company_email_sales      	= "";
    public $company_description_fr     	= "";
    public $company_description_en     	= "";
    public $created_by_id 				= 0;
    public $created_date 				= "";    
    public $modified_by_id 				= 0;
    public $modified_date 				= "";
    
    public $companies_records	= "";
    public $companies_list	= "";

    public $company_name = "";
    
    
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
    		$this->lang_name_field = "company_name_fr";
    		$this->lang_desc_field = "company_description_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "company_name_en";
    		$this->lang_desc_field = "company_description_en";
    	}
    }
    
     
    //////////////////////////////////////////////////////////////////
    // LOAD COMPANIES. USED FOR LISTING
    //////////////////////////////////////////////////////////////////
    public function LoadList()
    {
    	$this->SetCulture();
    	$this->companies_list = $this->GetCompaniesList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD COMPANIES COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->companies_records = $this->GetCompaniesRecords();
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN COMPANIES LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetCompaniesList()
    {        
        $output = array();
        $rs = mysql_query("SELECT company_id, " . $this->lang_name_field . " FROM companies ORDER BY " . $this->lang_name_field . "  ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "company_id"            	=> $row['company_id'],                			
		                    "company_name"  			=> $row[$this->lang_name_field]
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
    // RETURN COMPANIES RECORDS
    //////////////////////////////////////////////////////////////////
    public function GetCompaniesRecords()
    {
    	$output = array();
    	$rs = mysql_query("SELECT * FROM companies ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    						"company_id"            	=> $row['company_id'],
                			"grouping_id"				=> $row['grouping_id'],
		                    "language_id"     			=> $row['language_id'],
		                    "company_logo"      		=> $row['company_logo'],
		                    "company_name_fr"  			=> $row['company_name_fr'],
    						"company_name_en"  			=> $row['company_name_en'],
		                    "company_ressource_person"	=> $row['company_ressource_person'],
		                    "company_email_general"    	=> $row['company_email_general'],
		                    "company_email_sales"     	=> $row['company_email_sales'],
    						"company_description_fr"   	=> $row['company_description_fr'],
		                    "company_description_en"   	=> $row['company_description_en'],
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
    // RETURN COMPANY
    //////////////////////////////////////////////////////////////////
    public function GetCompany()
    {
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT * FROM companies WHERE company_id=" . $this->company_id);
    	
    	$row = mysql_fetch_array($rs);
    
    	$this->company_id        		= $row['company_id'];
    	$this->grouping_id				= $row['grouping_id'];
    	$this->language_id        		= $row['language_id'];
    	$this->company_logo         	= $row['company_logo'];
    	$this->company_name     		= $row[$this->lang_name_field];
    	$this->company_ressource_person = $row['company_ressource_person'];
    	$this->company_email_general    = $row['company_email_general'];
    	$this->company_email_sales      = $row['company_email_sales'];
    	$this->company_description  	= $row[$this->lang_desc_field];
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
    // RETURN COMPANY NAME BY ID
    //////////////////////////////////////////////////////////////////
    public function GetCompanyNameByID($id)
    {
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT " . $this->lang_name_field . " FROM companies WHERE company_id = " . $id);
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	 
    	$row = mysql_fetch_array($rs);
    	 
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN COMPANY ID FROM COMPANY NAME
    //////////////////////////////////////////////////////////////////
    public function GetCompanyIDFromName($company_name)
    { 	
    	$company_name = mysql_real_escape_string($company_name);
    	
    	$rs = mysql_query("SELECT company_id FROM companies WHERE company_name_fr = '" . $company_name . "' OR company_name_en = '" . $company_name . "'");
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row['company_id'];
    }
    
    /////////////////////////////////////////////////////////////////
    // RETURN COMPANY NAME BY GROUPING ID
    //////////////////////////////////////////////////////////////////
    public function GetCompanyNameByGroupingID($id)
    {
    	$this->SetCulture();
    	
    	$output = array();
    	$rs = mysql_query("SELECT company_id, " . $this->lang_name_field . " FROM companies WHERE grouping_id = " . $id . " ORDER BY " . $this->lang_name_field . "  ASC");
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"company_id"            	=> $row['company_id'],
    					"company_name"  			=> $row[$this->lang_name_field]
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
    // RETURN COMPANIES LISTING BY ID's
    //////////////////////////////////////////////////////////////////    
    public function GetCompaniesListByIDs($ids)
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
                    $where_statement .= "company_id='" . $value . "'";
            
                }
                else
                {
                    $where_statement .= "company_id='" . $value . "' OR ";
                }
                $i++;
            }
        }

        
        $rs = mysql_query("SELECT * FROM companies WHERE " . $where_statement . " ORDER BY " . $this->lang_name_field . " ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "company_id"            	=> $row['company_id'],
                			"grouping_id"				=> $row['grouping_id'],
		                    "language_id"     			=> $row['language_id'],
		                    "company_logo"      		=> $row['company_logo'],
		                    "company_name"  			=> $row[$this->lang_name_field],
		                    "company_ressource_person"	=> $row['company_ressource_person'],
		                    "company_email_general"    	=> $row['company_email_general'],
		                    "company_email_sales"     	=> $row['company_email_sales'],
		                    "company_description"   	=> $row[$this->lang_desc_field],
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
    // CREATE COMPANY
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
       
        $rs = mysql_query("INSERT INTO companies (company_id,
            									  grouping_id,
                                                  language_id, 
                                                  company_logo,
                                                  company_name_fr,
                                                  company_name_en,
                                                  company_ressource_person,
                                                  company_email_general,
                                                  company_email_sales,
                                                  company_description_fr,
            									  company_description_en,
                                                  created_by_id,
                                                  created_date,
            									  modified_by_id,
                                                  modified_date,
                								  rowguid) VALUES
                                                           ('" . $this->company_id .
            											   "','" . $this->grouping_id .
                                                           "','" . $this->language_id . 
                                                           "','" . $this->company_logo .
                                                           "','" . scrub($this->company_name_fr) .
                                                           "','" . scrub($this->company_name_en) .
                                                           "','" . scrub($this->company_ressource_person) .
                                                           "','" . $this->company_email_general .
                                                           "','" . $this->company_email_sales .
                                                           "','" . scrub($this->company_description_fr) .
            											   "','" . scrub($this->company_description_en) .
            											   "','" . $this->created_by_id .
                                                           "','" . date("Y-m-d H:i:s") .
            											   "','" . $this->modified_by_id .
                                                           "','" . date("Y-m-d H:i:s") .
            											   "','" . create_guid() ."')");
           
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
            
            
        $this->company_id = mysql_insert_id();
            
        return mysql_insert_id();
            
        
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE COMPANY
    //////////////////////////////////////////////////////////////////
	public function Update()
	{
    	$rs = mysql_query("UPDATE companies SET company_id='" . $this->company_id .
    											"', grouping_id='" . $this->grouping_id .
            									"', language_id='" . $this->language_id .
            									"', company_logo='" . $this->company_logo .
                                                "', company_name_fr='" . scrub($this->company_name_fr) .
                                                "', company_name_en='" . scrub($this->company_name_en) .
                                                "', company_ressource_person='" . scrub($this->company_ressource_person) .
                                                "', company_email_general='" . $this->company_email_general .
                                                "', company_email_sales='" . $this->company_email_sales .
                                                "', company_description_fr='" . scrub($this->company_description_fr) .
            									"', company_description_en='" . scrub($this->company_description_en) .
            									"', modified_by_id='" . $this->modified_by_id .
                                                "', modified_date='" . date("Y-m-d H:i:s") .
            									"' WHERE company_id=" . $this->company_id);
    	
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
        $rs = mysql_query("DELETE FROM companies WHERE company_id=" . $this->company_id);
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE COMPANIES BY ID
    //////////////////////////////////////////////////////////////////
    public function DeleteCompaniesByIDs($ids)
    {
    	$num_deletes = 0;
    	 
    	foreach($ids as $id)
    	{
    		$rs = mysql_query("DELETE FROM companies WHERE company_id=" . $id);
    		$num_deletes += mysql_affected_rows();
    	}
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	 
    	return $num_deletes;
    	 
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE COMPANY'S LOGO
    //////////////////////////////////////////////////////////////////
    public function UpdateCompanyLogo()
    {
    	$rs = mysql_query("UPDATE companies SET company_logo='' WHERE company_id=" . $this->company_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    ////////     TO DO     /////////////////////
    //////////////////////////////////////////////////////////////////
    // RETURN TRUE OR FALSE. DEPENDS IF COMPANY EXISTS OR NOT!
    //////////////////////////////////////////////////////////////////    
    public function IsAlreadyCompany($company_id, $company_name)
    {        
        $rs = mysql_query("SELECT company_id, company_name_fr FROM companies WHERE company_id='" . $company_id . "' AND company_name_fr='" . $company_name . "'");
        
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
    // RETURN COMPANIES LISTING BY FILTER
    //////////////////////////////////////////////////////////////////
    /* public function GetCompaniesListByUserFilters($filters)
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
	    					"company_id"            	=> $row['company_id'],
	    					"grouping_id"				=> $row['grouping_id'],
	    					"language_id"     			=> $row['language_id'],
	    					"company_logo"      		=> $row['company_logo'],
	    					"company_name_fr"  			=> $row['company_name_fr'],
	    					"company_name_en"  			=> $row['company_name_en'],
	    					"company_ressource_person"	=> $row['company_ressource_person'],
	    					"company_email_general"    	=> $row['company_email_general'],
	    					"company_email_sales"     	=> $row['company_email_sales'],
	    					"company_description_fr"   	=> $row['company_description_fr'],
	    					"company_description_en"   	=> $row['company_description_en'],
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