<?php

class Retailers
{   
	
	// This is currently used for the retailers batch import process.
	// If these avlues are changed, we need to make sure that the
	// retailers csv import file is reajusted. ELSE import process will fail.
	public $ret_import_col_names = array('retailer_is_active',
										 'retailer_is_head_office',
									 	 'retailer_type_id',
									 	 'grouping_id',
									 	 'company_id',
									 	 'language_id',
										 'retailer_logo',
										 'retailer_name_fr',
										 'retailer_name_en',
										 'retailer_ressource_person',
										 'retailer_founded_year',
										 'retailer_number_employes',
										 'retailer_revenue',
										 'retailer_email_general',
										 'retailer_website_url',
										 'retailer_facebook',
										 'retailer_twitter',
										 'retailer_linkedin',
										 'retailer_description_fr',
										 'retailer_description_en');
	
	
	
	public $retailer_id              	= 0;
	public $retailer_is_active         	= 0;
	public $retailer_is_head_office		= 0;
    public $retailer_type_id       		= 0;
    public $grouping_id					= 0;
    public $company_id         			= 0;
    public $language_id       			= 0;
    public $retailer_logo 				= "";    
    public $retailer_name_fr        	= "";
    public $retailer_name_en        	= "";
    public $retailer_ressource_person	= "";
    public $retailer_email_general      = "";
    public $retailer_founded_year       = "";
    public $retailer_number_employes    = "";
    public $retailer_revenue        	= "";
    public $retailer_website_url        = "";
    public $retailer_twitter        	= "";
    public $retailer_facebook        	= "";
    public $retailer_linkedin        	= "";
    public $retailer_description_fr     = "";
    public $retailer_description_en     = "";
    public $created_by_id 				= 0;
    public $created_date 				= "";    
    public $modified_by_id 				= 0;
    public $modified_date 				= "";
    
    public $retailers_records	= "";
    public $retailers_list		= "";
    
    public $retailer_name		= ""; 
        
    
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
    		$this->lang_name_field = "retailer_name_fr";
    		$this->lang_desc_field = "retailer_description_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "retailer_name_en";
    		$this->lang_desc_field = "retailer_description_en";
    	}
    }
    
     
    //////////////////////////////////////////////////////////////////
    // LOAD RETAILERS. USED FOR LISTING
    //////////////////////////////////////////////////////////////////
    public function LoadList()
    {
    	$this->SetCulture();
    	$this->retailers_list = $this->GetRetailersList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD RETAILERS COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->retailers_records = $this->GetRetailersRecords();
    }
    
        
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILERS LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetRetailersList()
    {        
        $output = array();
        $rs = mysql_query("SELECT * FROM retailers ORDER BY " . $this->lang_name_field . "  ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "retailer_id"            	=> $row['retailer_id'],
		                    "retailer_name"  			=> $row[$this->lang_name_field]
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
    // RETURN RETAILERS RECORDS
    //////////////////////////////////////////////////////////////////
    public function GetRetailersRecords()
    {
    	$output = array();
    	$rs = mysql_query("SELECT * FROM retailers ORDER BY retailer_id DESC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"retailer_id"            	=> $row['retailer_id'],
    						"retailer_is_active"		=> $row['retailer_is_active'],
    						"retailer_is_head_office"	=> $row['retailer_is_head_office'],
	    					"retailer_type_id"     		=> $row['retailer_type_id'],
	    					"grouping_id"				=> $row['grouping_id'],
	    					"company_id"       			=> $row['company_id'],
	    					"language_id"     			=> $row['language_id'],
	    					"retailer_logo"      		=> $row['retailer_logo'],
    						"retailer_name"  			=> $row[$this->lang_name_field],
	    					"retailer_name_fr"  		=> $row['retailer_name_fr'],
	    					"retailer_name_en"  		=> $row['retailer_name_en'],
	    					"retailer_ressource_person"	=> $row['retailer_ressource_person'],
	    					"retailer_email_general"    => $row['retailer_email_general'],
	    					"retailer_founded_year"     => $row['retailer_founded_year'],
	    					"retailer_number_employes"  => $row['retailer_number_employes'],
	    					"retailer_revenue"     		=> $row['retailer_revenue'],
	    					"retailer_website_url"      => $row['retailer_website_url'],
	    					"retailer_twitter"         	=> $row['retailer_twitter'],
	    					"retailer_facebook"       	=> $row['retailer_facebook'],
	    					"retailer_linkedin"  		=> $row['retailer_linkedin'],
    						"retailer_description"   	=> $row[$this->lang_desc_field],
	    					"retailer_description_fr"   => $row['retailer_description_fr'],
	    					"retailer_description_en"   => $row['retailer_description_en'],
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
    // RETURN RETAILERS RECORD
    //////////////////////////////////////////////////////////////////
    public function GetRetailersRecord()
    {
    	
    	$rs = mysql_query("SELECT * FROM retailers WHERE retailer_id=" . $this->retailer_id);
    	 
    	$row = mysql_fetch_array($rs);
    	
    	$this->retailer_id        		 	= $row['retailer_id'];
    	$this->retailer_is_active			= $row['retailer_is_active'];
    	$this->retailer_is_head_office		= $row['retailer_is_head_office'];
    	$this->retailer_type_id				= $row['retailer_type_id'];
    	$this->grouping_id					= $row['grouping_id'];
    	$this->company_id          			= $row['company_id'];
    	$this->language_id        			= $row['language_id'];
    	$this->retailer_logo         		= $row['retailer_logo'];
    	$this->retailer_name_fr     		= $row['retailer_name_fr'];
    	$this->retailer_name_en     		= $row['retailer_name_en'];
    	$this->retailer_ressource_person 	= $row['retailer_ressource_person'];
    	$this->retailer_email_general       = $row['retailer_email_general'];
    	$this->retailer_founded_year        = $row['retailer_founded_year'];
    	$this->retailer_number_employes     = $row['retailer_number_employes'];
    	$this->retailer_revenue        		= $row['retailer_revenue'];
    	$this->retailer_website_url         = $row['retailer_website_url'];
    	$this->retailer_twitter            	= $row['retailer_twitter'];
    	$this->retailer_facebook          	= $row['retailer_facebook'];
    	$this->retailer_linkedin     		= $row['retailer_linkedin'];
    	$this->retailer_description_fr  	= $row['retailer_description_fr'];
    	$this->retailer_description_en  	= $row['retailer_description_en'];
    	$this->created_by_id     			= $row['created_by_id'];
    	$this->created_date     			= $row['created_date'];
    	$this->modified_by_id    			= $row['modified_by_id'];
    	$this->modified_date    			= $row['modified_date'];
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILER
    //////////////////////////////////////////////////////////////////
    public function GetRetailer()
    {
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT * FROM retailers WHERE retailer_id=" . $this->retailer_id);
    	
    	$row = mysql_fetch_array($rs);
    
    	$this->retailer_id        		 	= $row['retailer_id'];
    	$this->retailer_is_active			= $row['retailer_is_active'];
    	$this->retailer_is_head_office		= $row['retailer_is_head_office'];
    	$this->retailer_type_id				= $row['retailer_type_id'];
    	$this->grouping_id					= $row['grouping_id'];
    	$this->company_id          			= $row['company_id'];
    	$this->language_id        			= $row['language_id'];
    	$this->retailer_logo         		= $row['retailer_logo'];
    	$this->retailer_name     			= $row[$this->lang_name_field];
    	$this->retailer_ressource_person 	= $row['retailer_ressource_person'];
    	$this->retailer_email_general       = $row['retailer_email_general'];
    	$this->retailer_founded_year        = $row['retailer_founded_year'];
    	$this->retailer_number_employes     = $row['retailer_number_employes'];
    	$this->retailer_revenue        		= $row['retailer_revenue'];
    	$this->retailer_website_url         = $row['retailer_website_url'];
    	$this->retailer_twitter            	= $row['retailer_twitter'];
    	$this->retailer_facebook          	= $row['retailer_facebook'];
    	$this->retailer_linkedin     		= $row['retailer_linkedin'];
    	$this->retailer_description  		= $row[$this->lang_desc_field];
    	$this->created_by_id     			= $row['created_by_id'];
    	$this->created_date     			= $row['created_date'];
    	$this->modified_by_id    			= $row['modified_by_id'];
    	$this->modified_date    			= $row['modified_date'];
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILERS LISTING BY ID's
    //////////////////////////////////////////////////////////////////    
    public function GetRetailersListByIDs($ids)
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
                    $where_statement .= "retailer_id='" . $value . "'";
            
                }
                else
                {
                    $where_statement .= "retailer_id='" . $value . "' OR ";
                }
                $i++;
            }
        }
        
        $rs = mysql_query("SELECT * FROM retailers WHERE " . $where_statement . " ORDER BY " . $this->lang_name_field . " ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "retailer_id"            	=> $row['retailer_id'],
                			"retailer_is_active"		=> $row['retailer_is_active'],
                			"retailer_is_head_office"	=> $row['retailer_is_head_office'],
		                    "retailer_type_id"     		=> $row['retailer_type_id'],
                			"grouping_id"				=> $row['grouping_id'],
		                    "company_id"       			=> $row['company_id'],
		                    "language_id"     			=> $row['language_id'],
		                    "retailer_logo"      		=> $row['retailer_logo'],
		                    "retailer_name"  			=> $row[$this->lang_name_field],
		                    "retailer_ressource_person"	=> $row['retailer_ressource_person'],
		                    "retailer_email_general"    => $row['retailer_email_general'],
		                    "retailer_founded_year"     => $row['retailer_founded_year'],
		                    "retailer_number_employes"  => $row['retailer_number_employes'],
		                    "retailer_revenue"     		=> $row['retailer_revenue'],
		                    "retailer_website_url"      => $row['retailer_website_url'],
		                    "retailer_twitter"         	=> $row['retailer_twitter'],
		                    "retailer_facebook"       	=> $row['retailer_facebook'],
		                    "retailer_linkedin"  		=> $row['retailer_linkedin'],
		                    "retailer_description"   	=> $row[$this->lang_desc_field],
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
    // CREATE RETAILER
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
       
        $rs = mysql_query("INSERT INTO retailers (retailer_is_active,
        										  retailer_is_head_office,
        										  retailer_type_id,        										  
            									  grouping_id,
                                                  company_id, 
                                                  language_id, 
                                                  retailer_logo,
                                                  retailer_name_fr,
                                                  retailer_name_en,
                                                  retailer_ressource_person,
                                                  retailer_email_general,
                                                  retailer_founded_year,
                                                  retailer_number_employes,
                                                  retailer_revenue,
                                                  retailer_website_url,
                                                  retailer_twitter,
                                                  retailer_facebook,
                                                  retailer_linkedin,
                                                  retailer_description_fr,
            									  retailer_description_en,
                                                  created_by_id,
                                                  created_date,
            									  modified_by_id,
                                                  modified_date,
                								  rowguid) VALUES
                                                           ('" . $this->retailer_is_active .
        												    "','" . $this->retailer_is_head_office .
        												    "','" . $this->retailer_type_id .        												   
            											    "','" . $this->grouping_id .
                                                            "','" . $this->company_id .
                                                            "','" . $this->language_id . 
                                                            "','" . $this->retailer_logo .
                                                            "','" . scrub($this->retailer_name_fr) .
                                                            "','" . scrub($this->retailer_name_en) .
                                                            "','" . scrub($this->retailer_ressource_person) .
                                                            "','" . $this->retailer_email_general .
                                                            "','" . $this->retailer_founded_year .
                                                            "','" . $this->retailer_number_employes .
                                                            "','" . $this->retailer_revenue .
                                                            "','" . $this->retailer_website_url .
                                                            "','" . $this->retailer_twitter .
                                                            "','" . $this->retailer_facebook .
                                                            "','" . $this->retailer_linkedin .
                                                            "','" . scrub($this->retailer_description_fr) .
            											    "','" . scrub($this->retailer_description_en) .
            											    "','" . $this->created_by_id .
                                                            "','" . date("Y-m-d H:i:s") .
            											    "','" . $this->modified_by_id .
                                                            "','" . date("Y-m-d H:i:s") .
            											    "','" . create_guid() ."')");        
        
        
           
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
            
            
        $this->retailer_id = mysql_insert_id();
            
        return mysql_insert_id();
            
        
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE RETAILER
    //////////////////////////////////////////////////////////////////
	public function Update()
	{
    	$rs = mysql_query("UPDATE retailers SET retailer_is_active='" . $this->retailer_is_active .
    											"', retailer_is_head_office='" . $this->retailer_is_head_office .
    											"', retailer_type_id='" . $this->retailer_type_id .
    											"', grouping_id='" . $this->grouping_id .
            									"', company_id='" . $this->company_id .
            									"', language_id='" . $this->language_id .
            									"', retailer_logo='" . $this->retailer_logo .
                                                "', retailer_name_fr='" . scrub($this->retailer_name_fr) .
                                                "', retailer_name_en='" . scrub($this->retailer_name_en) .
                                                "', retailer_ressource_person='" . scrub($this->retailer_ressource_person) .
                                                "', retailer_email_general='" . $this->retailer_email_general .
                                                "', retailer_founded_year='" . $this->retailer_founded_year .
                                                "', retailer_number_employes='" . $this->retailer_number_employes .
                                                "', retailer_revenue='" . $this->retailer_revenue .
                                                "', retailer_website_url='" . $this->retailer_website_url .
                                                "', retailer_twitter='" . $this->retailer_twitter .
                                                "', retailer_facebook='" . $this->retailer_facebook .
                                                "', retailer_linkedin='" . $this->retailer_linkedin .
                                                "', retailer_description_fr='" . scrub($this->retailer_description_fr) .
            									"', retailer_description_en='" . scrub($this->retailer_description_en) .
            									"', modified_by_id='" . $this->modified_by_id .
                                                "', modified_date='" . date("Y-m-d H:i:s") .
            									"' WHERE retailer_id=" . $this->retailer_id);
    	
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
        $rs = mysql_query("DELETE FROM retailers WHERE retailer_id=" . $this->retailer_id);    	
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
        
        return mysql_affected_rows();
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE RETAILERS BY ID
    //////////////////////////////////////////////////////////////////
    public function DeleteRetailersByIDs($ids)
    {
    	$num_deletes = 0;
    	
    	foreach($ids as $id)
    	{
    		$rs = mysql_query("DELETE FROM retailers WHERE retailer_id=" . $id);
    		$num_deletes += mysql_affected_rows();
    	}
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    	return $num_deletes;
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE RETAILER'S LOGO
    //////////////////////////////////////////////////////////////////
    public function UpdateRetailerLogo()
    {
    	$rs = mysql_query("UPDATE retailers SET retailer_logo='' WHERE retailer_id=" . $this->retailer_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    ////////     TO DO     /////////////////////
    //////////////////////////////////////////////////////////////////
    // RETURN TRUE OR FALSE. DEPENDS IF RETAILER EXISTS OR NOT!
    //////////////////////////////////////////////////////////////////    
    public function IsRetailerPresent()
    {        
    	$rs = mysql_query("SELECT retailer_name_fr, retailer_name_en, retailer_email_general" .
    					  " FROM retailers WHERE (retailer_name_fr='" . $this->retailer_name_fr . "'" .
    			          " OR retailer_name_en='" . $this->retailer_name_en . "')" .
    			          " AND retailer_email_general='" . $this->retailer_email_general . "'");
        
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
    // RETURN RETAILERS LISTING BY USER FILTER
    //////////////////////////////////////////////////////////////////
    public function GetRetailersListByUserFilters($filters)
    {    
    	$output = array();
    	
    	if(count($filters) > 0)
    	{    	
    		$this->SetCulture();
	    	
	    	// Set filtered fields.
	    	$grouping_field = "grouping_id";
	    	$retailer_type_field = "retailer_type_id";
	    
	    	$filtered_fields = "";
	    	$where_statement = "";
	    	$where_str		 = "";
	    
	    	foreach ($filters as $key => $value)
	    	{
	    		if(strtolower($key) == strtolower('grouping'))
	    		{
	    			$filtered_fields = $grouping_field;
	    			$where_statement .= !empty($where_statement) ? " AND " . "$filtered_fields = $value" : "$filtered_fields = $value";
	    		}
	    
	    		if(strtolower($key) == strtolower('retailer_type'))
	    		{
	    			$filtered_fields = $retailer_type_field;
	    			$where_statement .= !empty($where_statement) ? " AND " . "$filtered_fields = $value" : "$filtered_fields = $value";
	    		}
	    	}
	    	
	    	if(!empty($where_statement)) { $where_str = " WHERE "; }	    	
	    	
	    	$sql_statement = "SELECT * FROM retailers" . $where_str . $where_statement;
	    
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
			                    "retailer_id"	=> $row['retailer_id'],
			                    "retailer_name"	=> $row[$this->lang_name_field]
	                );
	    		}
	    	}
	    
	    	if (mysql_errno())
	    	{
	    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
	    	}
    	}
    	
    	return $output;
    }

    //////////////////////////////////////////////////////////////////
    // RETURN RETAILERS LISTING BY FILTER
    //////////////////////////////////////////////////////////////////
    public function GetRetailersRecordByUserFilters($filters)
    {
    	$output = array();
    	
    	if(count($filters) > 0)
    	{    		
    		$this->SetCulture();
    		
    		// Set filtered fields.
    		$grouping_field = "grouping_id";
    		$retailer_type_field = "retailer_type_id";
    	  
    		$filtered_fields = "";
    		$where_statement = "";
    		$key_counter = 0;
    	  
    		foreach ($filters as $key => $value)
    		{
    			if(strtolower($key) == strtolower('grouping'))
    			{
    				$filtered_fields = $grouping_field . ",";
    				 
    				$where_statement = "WHERE $filtered_fields = $value";
    			}
    			 
    			if(strtolower($key) == strtolower('retailer_type'))
    			{
    				$filtered_fields = $retailer_type_field . ",";
    				$where_statement .= " AND $filtered_fields = $value";
    			}
    			 
    	   
    			$key_counter++;
    		}
    	  
    		// Remove trailing comma at the end of the fields being filtered.
    		$where_statement = str_replace(', ', ' ', $where_statement);
    		$sql_statement = "SELECT * FROM retailers " . $where_statement;
    	  
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
    						"retailer_id"            	=> $row['retailer_id'],
    						"retailer_is_active"		=> $row['retailer_is_active'],
    						"retailer_is_head_office"	=> $row['retailer_is_head_office'],
    						"retailer_type_id"     		=> $row['retailer_type_id'],
    						"grouping_id"				=> $row['grouping_id'],
    						"company_id"       			=> $row['company_id'],
    						"language_id"     			=> $row['language_id'],
    						"retailer_logo"      		=> $row['retailer_logo'],
    						"retailer_name"  			=> $row[$this->lang_name_field],
    						"retailer_ressource_person"	=> $row['retailer_ressource_person'],
    						"retailer_email_general"    => $row['retailer_email_general'],
    						"retailer_founded_year"     => $row['retailer_founded_year'],
    						"retailer_number_employes"  => $row['retailer_number_employes'],
    						"retailer_revenue"     		=> $row['retailer_revenue'],
    						"retailer_website_url"      => $row['retailer_website_url'],
    						"retailer_twitter"         	=> $row['retailer_twitter'],
    						"retailer_facebook"       	=> $row['retailer_facebook'],
    						"retailer_linkedin"  		=> $row['retailer_linkedin'],
    						"retailer_description"   	=> $row[$this->lang_desc_field],
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
    	}
    	 
    	return $output;
    }

}



?>