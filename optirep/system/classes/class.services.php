<?php

class Services
{
    public $service_id		= "";    
    public $service_name_fr	= "";
    public $service_name_en	= "";
    public $created_by_id 	= "";
    public $created_date	= "";
    public $modified_by_id	= "";
    public $modified_date	= "";
    
    public $services_records	= "";
    public $services_list		= "";    
    
    
    public $service_name = "";
    
    
    private $lang_name_field = "";
    
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "service_name_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "service_name_en";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD RETAILER SERVICES LIST. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////    
    public function LoadList()
    {
        $this->SetCulture();
        $this->services_list = $this->GetServicesList();
    }    
   
    //////////////////////////////////////////////////////////////////
    // LOAD SERVICES LIST COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->services_records = $this->GetServicesRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICES. USED FOR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    public function GetServicesList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT service_id, " . $this->lang_name_field . " FROM services ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"service_id"   	=> $row['service_id'],
	    					"service_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICE NAMES. USED FOR IMPORT 
    //////////////////////////////////////////////////////////////////
    public function GetServicesNamesForImport()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT service_name_en FROM services ORDER BY service_name_en ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			array_push($output, $row['service_name_en']);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICES COMPLETE RECORDS
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetServicesRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM services ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"service_id"    	=> $row['service_id'],
	    					"service_name_fr"	=> $row['service_name_fr'],
	    					"service_name_en"	=> $row['service_name_en'],
	    					"created_by_id"  	=> $row['created_by_id'],
	    					"created_date"  	=> $row['created_date'],
	    					"modified_by_id"  	=> $row['modified_by_id'],
	    					"modified_date"  	=> $row['modified_date']
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICES COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetServiceRecord()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM services WHERE service_id = " . $this->service_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"service_id"    	=> $row['service_id'],
	    					"service_name_fr"	=> $row['service_name_fr'],
	    					"service_name_en"	=> $row['service_name_en'],
	    					"created_by_id"  	=> $row['created_by_id'],
	    					"created_date"  	=> $row['created_date'],
	    					"modified_by_id"  	=> $row['modified_by_id'],
	    					"modified_date"  	=> $row['modified_date']
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
    // RETURN SERVICE
    //////////////////////////////////////////////////////////////////
    public function GetService()
    {
    	$this->SetCulture();
    
    	$rs = mysql_query("SELECT service_id, " . $this->lang_name_field . " FROM services WHERE service_id=" . $this->service_id);
    
    	$row = mysql_fetch_array($rs);
    
    	$this->service_id	= $row['service_id'];
    	$this->service_name	= $row[$this->lang_name_field];
    	 
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICE NAME BY ID
    //////////////////////////////////////////////////////////////////    
    public function GetServiceNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM services WHERE service_id = " . $id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	
    	$row = mysql_fetch_array($rs);
    	
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SERVICE ID FROM SERVICE NAME
    //////////////////////////////////////////////////////////////////
    public function GetServiceIDFromName($service_name)
    {
    	$output = mysql_result(mysql_query("SELECT service_id FROM services WHERE service_name_fr = '" . $service_name . "' OR service_name_en = '" . $service_name . "'" ), 0, 0);
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE SERVICES
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	// CREATE SERVICE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO services (service_name_fr,
	                                             service_name_en,
	                                             created_by_id,
	                                             created_date,
	                                             modified_by_id,
	                                             modified_date,
	                							 rowguid) VALUES
                                                           ('" . scrub($this->service_name_fr) .
										    				"','" . scrub($this->service_name_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->service_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE SERVICES
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE services SET service_name_fr='" . scrub($this->service_name_fr) .
								    	   "', service_name_en='" . scrub($this->service_name_en) .
								    	   "', modified_by_id='" . $this->modified_by_id .
								    	   "', modified_date='" . date("Y-m-d H:i:s") .
								    	   "' WHERE service_id=" . $this->service_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE SERVICES
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM services WHERE service_id=" . $this->service_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>
