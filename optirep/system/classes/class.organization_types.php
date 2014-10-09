<?php

class OrganizationTypes
{
    public $organization_type_id		= "";    
    public $organization_type_name_fr	= "";
    public $organization_type_name_en	= "";
    public $created_by_id 				= "";
    public $created_date				= "";
    public $modified_by_id				= "";
    public $modified_date				= "";
    
    public $organization_types_records 	= "";
    public $organization_types_list		= "";   
    
    
    public $organization_type_name  = "";
    
    
    private $lang_name_field		= "";
    
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "organization_type_name_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "organization_type_name_en";
    	}    
    }    
        
    //////////////////////////////////////////////////////////////////
    // LOAD ORGANIZATION TYPES. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    public function LoadList()
    {
    	$this->SetCulture();    
    	$this->organization_types_list = $this->GetOrganizationTypesList();
    }
    
    
    //////////////////////////////////////////////////////////////////
    // LOAD ORGANIZATION TYPES COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////    
    public function LoadRecords()
    {       
        $this->SetCulture();
    	$this->organization_types_records = $this->GetOrganizationTypesRecords();
    }   
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN ORGANIZATION TYPES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    public function GetOrganizationTypesList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT organization_type_id, " . $this->lang_name_field . " FROM organization_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"organization_type_id"    	=> $row['organization_type_id'],
	    					"organization_type_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN ORGANIZATION TYPES COMPLETE RECORD
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetOrganizationTypesRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM organization_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"organization_type_id"    	=> $row['organization_type_id'],
	    					"organization_type_name_fr"	=> $row['organization_type_name_fr'],
	    					"organization_type_name_en"	=> $row['organization_type_name_en'],
	    					"created_by_id"  			=> $row['created_by_id'],
	    					"created_date"  			=> $row['created_date'],
	    					"modified_by_id"  			=> $row['modified_by_id'],
	    					"modified_date"  			=> $row['modified_date']
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN ORGANIZATION TYPE COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetOrganizationTypeRecord()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM organization_types WHERE organization_type_id = " . $this->organization_type_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"organization_type_id"    	=> $row['organization_type_id'],
	    					"organization_type_name_fr"	=> $row['organization_type_name_fr'],
	    					"organization_type_name_en"	=> $row['organization_type_name_en'],
	    					"created_by_id"  			=> $row['created_by_id'],
	    					"created_date"  			=> $row['created_date'],
	    					"modified_by_id"  			=> $row['modified_by_id'],
	    					"modified_date"  			=> $row['modified_date']
    			);
    		}
    	}
    	 
    	 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$output\n<br>";
    	}
    	 
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN ORGANIZATION TYPE NAME BY ID
    //////////////////////////////////////////////////////////////////    
    public function GetOrganizationTypeNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM organization_types WHERE organization_type_id = " . $id);
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	 
    	$row = mysql_fetch_array($rs);
    	 
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE ORGANIZATION TYPE
    //////////////////////////////////////////////////////////////////
	public function Create()
    {
    	// CREATE ORGANIZATION TYPE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO organization_types (organization_type_name_fr,
	                                                   organization_type_name_en,
	                                                   created_by_id,
	                                                   created_date,
	                                                   modified_by_id,
	                                                   modified_date,
	                								   rowguid) VALUES
                                                           ('" . scrub($this->organization_type_name_fr) .
										    				"','" . scrub($this->organization_type_name_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->organization_type_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE ORGANIZATION TYPE
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE organization_types SET organization_type_name_fr='" . scrub($this->organization_type_name_fr) .
								    				 "', organization_type_name_en='" . scrub($this->organization_type_name_en) .
								    				 "', modified_by_id='" . $this->modified_by_id .
								    				 "', modified_date='" . date("Y-m-d H:i:s") .
								    				 "' WHERE organization_type_id=" . $this->organization_type_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE ORGANIZATION TYPE
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM organization_types WHERE organization_type_id=" . $this->organization_type_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>