<?php

class RetailerTypes
{
    public $retailer_type_id		= "";    
    public $retailer_type_name_fr	= "";
    public $retailer_type_name_en	= "";
    public $created_by_id 			= "";
    public $created_date			= "";
    public $modified_by_id			= "";
    public $modified_date			= "";
    
    public $retailer_types_records	= "";
    public $retailer_types_list		= "";
    
    
    
    public $retailer_type_name  = "";
    
    
    private $lang_name_field		= "";
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "retailer_type_name_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "retailer_type_name_en";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD RETAILER TYPES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////    
    public function LoadList()
    {
        $this->SetCulture();
        $this->retailer_types_list = $this->GetRetailerTypesList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD RETAILER TYPES LIST COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->retailer_types_records = $this->GetRetailerTypesRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILER TYPES. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    public function GetRetailerTypesList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT retailer_type_id, " . $this->lang_name_field . " FROM retailer_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"retailer_type_id"    	=> $row['retailer_type_id'],
	    					"retailer_type_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILER TYPES COMPLETE RECORD
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetRetailerTypesRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM retailer_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"retailer_type_id"    	=> $row['retailer_type_id'],
    					"retailer_type_name_fr"	=> $row['retailer_type_name_fr'],
    					"retailer_type_name_en"	=> $row['retailer_type_name_en'],
    					"created_by_id"  		=> $row['created_by_id'],
    					"created_date"  		=> $row['created_date'],
    					"modified_by_id"  		=> $row['modified_by_id'],
    					"modified_date"  		=> $row['modified_date']
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILER TYPE
    //////////////////////////////////////////////////////////////////
    public function GetRetailerTypeRecord()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM retailer_types WHERE retailer_type_id = " . $this->retailer_type_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"retailer_type_id"    	=> $row['retailer_type_id'],
	    					"retailer_type_name_fr"	=> $row['retailer_type_name_fr'],
	    					"retailer_type_name_en"	=> $row['retailer_type_name_en'],
	    					"created_by_id"  		=> $row['created_by_id'],
	    					"created_date"  		=> $row['created_date'],
	    					"modified_by_id"  		=> $row['modified_by_id'],
	    					"modified_date"  		=> $row['modified_date']
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
    // RETURN RETAILER TYPE NAME BY RETAILER TYPE ID
    //////////////////////////////////////////////////////////////////    
    public function GetRetailerTypeNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM retailer_types WHERE retailer_type_id = " . $id);
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	 
    	$row = mysql_fetch_array($rs);
    	 
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILER TYPE ID BY RETAILER TYPE NAME
    //////////////////////////////////////////////////////////////////
    public function GetretailerTyeIDFromName($retailer_type_name)
    {
    	$retailer_type_name = mysql_real_escape_string($retailer_type_name);
    	
    	$rs = mysql_query("SELECT retailer_type_id FROM retailer_types WHERE retailer_type_name_fr = '" . $retailer_type_name . "' OR retailer_type_name_en = '" . $retailer_type_name . "'");
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row['retailer_type_id'];
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE RETAILER TYPE
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	// CREATE RETAILER TYPE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO retailer_types (retailer_type_name_fr,
	                                                   retailer_type_name_en,
	                                                   created_by_id,
	                                                   created_date,
	                                                   modified_by_id,
	                                                   modified_date,
	                								   rowguid) VALUES
                                                           ('" . scrub($this->retailer_type_name_fr) .
										    				"','" . scrub($this->retailer_type_name_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->retailer_type_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE RETAILER TYPE
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE retailer_types SET retailer_type_name_fr='" . scrub($this->retailer_type_name_fr) .
								    				 "', retailer_type_name_en='" . scrub($this->retailer_type_name_en) .
								    				 "', modified_by_id='" . $this->modified_by_id .
								    				 "', modified_date='" . date("Y-m-d H:i:s") .
								    				 "' WHERE retailer_type_id=" . $this->retailer_type_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE RETAILER TYPES
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM retailer_types WHERE retailer_type_id=" . $this->retailer_type_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>