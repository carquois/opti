<?php

class ProfessionalTypes
{
    public $professional_type_id		= "";    
    public $professional_type_name_fr	= "";
    public $professional_type_name_en	= "";
    public $created_by_id 				= "";
    public $created_date				= "";
    public $modified_by_id				= "";
    public $modified_date				= "";
    
    public $professional_types_records	= "";
    public $professional_types_list		= "";
    
    
    public $professional_type_name  = "";
    
    
    private $lang_name_field		= "";
    
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "professional_type_name_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "professional_type_name_en";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD PROFESSIONAL TYPES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////    
    public function LoadList()
    {
        $this->SetCulture();
        $this->professional_types_list = $this->GetProfessionalTypesList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD PROFESSIONAL TYPES LIST COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->professional_types_records = $this->GetProfessionalTypesRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN PROFESSIONAL TYPES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    public function GetProfessionalTypesList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT professional_type_id, " . $this->lang_name_field . " FROM professional_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"professional_type_id"    	=> $row['professional_type_id'],
    					"professional_type_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN PROFESSIONAL TYPES COMPLETE RECORD
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetProfessionalTypesRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM professional_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"professional_type_id"    	=> $row['professional_type_id'],
	    					"professional_type_name_fr"	=> $row['professional_type_name_fr'],
	    					"professional_type_name_en"	=> $row['professional_type_name_en'],
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
    // RETURN PROFESSIONAL TYPE COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetProfessionalTypeRecord()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM professional_types WHERE professional_type_id = " . $this->professional_type_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"professional_type_id"    	=> $row['professional_type_id'],
	    					"professional_type_name_fr"	=> $row['professional_type_name_fr'],
	    					"professional_type_name_en"	=> $row['professional_type_name_en'],
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
    // RETURN PROFESSIONAL TYPE NAME BY ID
    //////////////////////////////////////////////////////////////////    
    public function GetProfessionalTypeNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM professional_types WHERE professional_type_id = " . $id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE PROFESSIONAL TYPE
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	// CREATE PROFESSIONAL TYPE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO professional_types (professional_type_name_fr,
	                                                   professional_type_name_en,
	                                                   created_by_id,
	                                                   created_date,
	                                                   modified_by_id,
	                                                   modified_date,
	                								   rowguid) VALUES
                                                           ('" . scrub($this->professional_type_name_fr) .
										    				"','" . scrub($this->professional_type_name_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->professional_type_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE PROFESSIONAL TYPE
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE professional_types SET professional_type_name_fr='" . scrub($this->professional_type_name_fr) .
								    				 "', professional_type_name_en='" . scrub($this->professional_type_name_en) .
								    				 "', modified_by_id='" . $this->modified_by_id .
								    				 "', modified_date='" . date("Y-m-d H:i:s") .
								    				 "' WHERE professional_type_id=" . $this->professional_type_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE PROFESSIONAL TYPES
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM professional_types WHERE professional_type_id=" . $this->professional_type_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>