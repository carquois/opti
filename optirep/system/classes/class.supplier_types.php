<?php

class SupplierTypes
{
    public $supplier_type_id		= "";    
    public $supplier_type_name_fr	= "";
    public $supplier_type_name_en	= "";
    public $created_by_id 			= "";
    public $created_date			= "";
    public $modified_by_id			= "";
    public $modified_date			= "";
    
    public $supplier_types_records	= "";
    public $supplier_types_list		= "";    
    
    
    public $supplier_type_name  = "";
    
    
    private $lang_name_field		= "";
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "supplier_type_name_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "supplier_type_name_en";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD SUPPLIER TYPES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////    
    public function LoadList()
    {
        $this->SetCulture();
        $this->supplier_types_list = $this->GetSupplierTypesList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD SUPPLIER TYPES LIST COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->supplier_types_records = $this->GetSupplierTypesRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUPPLIER TYPES. USED FOR DROPDOWN LIST
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetSupplierTypesList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT supplier_type_id, " . $this->lang_name_field . " FROM supplier_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"supplier_type_id"		=> $row['supplier_type_id'],
	    					"supplier_type_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUPPLIER TYPES COMPLETE RECORD
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetSupplierTypesRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM supplier_types ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"supplier_type_id"    	=> $row['supplier_type_id'],
	    					"supplier_type_name_fr"	=> $row['supplier_type_name_fr'],
	    					"supplier_type_name_en"	=> $row['supplier_type_name_en'],
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
    // RETURN SUPPLIER TYPE
    //////////////////////////////////////////////////////////////////
    public function GetSupplierTypeRecord()
    {    
    	$output = array();
    	
    	$rs = mysql_query("SELECT * FROM supplier_types WHERE supplier_type_id = " . $this->supplier_type_id);
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
	    		$output[] = array(
	    					"supplier_type_id"    	=> $row['supplier_type_id'],
	    					"supplier_type_name_fr"	=> $row['supplier_type_name_fr'],
	    					"supplier_type_name_en"	=> $row['supplier_type_name_en'],
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
    // RETURN SUPPLIER TYPE NAME BY ID
    //////////////////////////////////////////////////////////////////    
    public function GetSupplierTypeNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM supplier_types WHERE supplier_type_id = " . $id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE SUPPLIER TYPE
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	// CREATE SUPPLIER TYPE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO supplier_types (supplier_type_name_fr,
	                                                   supplier_type_name_en,
	                                                   created_by_id,
	                                                   created_date,
	                                                   modified_by_id,
	                                                   modified_date,
	                								   rowguid) VALUES
                                                           ('" . scrub($this->supplier_type_name_fr) .
										    				"','" . scrub($this->supplier_type_name_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->supplier_type_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE SUPPLIER TYPE
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE supplier_types SET supplier_type_name_fr='" . scrub($this->supplier_type_name_fr) .
								    				 "', supplier_type_name_en='" . scrub($this->supplier_type_name_en) .
								    				 "', modified_by_id='" . $this->modified_by_id .
								    				 "', modified_date='" . date("Y-m-d H:i:s") .
								    				 "' WHERE supplier_type_id=" . $this->supplier_type_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE SUPPLIER TYPE
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM supplier_types WHERE supplier_type_id=" . $this->supplier_type_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>