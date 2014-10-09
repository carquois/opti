<?php

class Subscriptions
{
    public $subscription_id			= "";    
    public $subscription_name_fr	= "";
    public $subscription_name_en	= "";
    public $subscription_desc_fr	= "";
    public $subscription_desc_en	= "";
    public $created_by_id 			= "";
    public $created_date			= "";
    public $modified_by_id			= "";
    public $modified_date			= "";
    
    public $subscriptions_records 	= "";
    public $subscriptions_list		= "";
    
    public $subscription_name  = "";
    public $subscription_desc  = "";
    
    private $lang_name_field = "";
    private $lang_desc_field = "";
    
    //////////////////////////////////////////////////////////////////
    // SET CULTURE FOR LIST CREATIONS AND ORDERING BY
    //////////////////////////////////////////////////////////////////
    private function SetCulture()
    {
    	if($_SESSION['LANGUAGE'] == "fr" )
    	{
    		$this->lang_name_field = "subscription_name_fr";
			$this->lang_desc_field = "subscription_desc_fr";
    	}
    	else
    	{
    		$this->lang_name_field = "subscription_name_en";
			$this->lang_desc_field = "subscription_desc_en";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD SUBSCRIPTIONS LIST
    //////////////////////////////////////////////////////////////////    
    public function LoadList()
    {
        $this->SetCulture();
        $this->subscriptions_list = $this->GetSubscriptionsList();
    }
    
    //////////////////////////////////////////////////////////////////
    // LOAD SUBSCRIPTIONS LIST COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->SetCulture();
    	$this->subscriptions_records = $this->GetSubscriptionsRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUBSCRIPTIONS
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetSubscriptionsList()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT subscription_id, " . $this->lang_name_field . " FROM subscriptions ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"subscription_id"   => $row['subscription_id'],
	    					"subscription_name"	=> $row[$this->lang_name_field]
    			);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUBCRIPTION NAMES. USED FOR IMPORT
    //////////////////////////////////////////////////////////////////
    public function GetSubscriptionsNamesForImport()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT subscription_name_en FROM subscriptions ORDER BY subscription_name_en ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			array_push($output, $row['subscription_name_en']);
    		}
    	}
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUBSCRIPTIONS COMPLETE RECORD
    // THESE RECORDS ARE FOR ADMIN PURPOSES.
    //////////////////////////////////////////////////////////////////
    public function GetSubscriptionsRecords()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM subscriptions ORDER BY " . $this->lang_name_field . "  ASC");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"subscription_id"    	=> $row['subscription_id'],
	    					"subscription_name_fr"	=> $row['subscription_name_fr'],
	    					"subscription_name_en"	=> $row['subscription_name_en'],
	    					"subscription_desc_fr"	=> $row['subscription_desc_fr'],
	    					"subscription_desc_en"	=> $row['subscription_desc_en'],
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
    // RETURN SUBSCRIPTION COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetSubscriptionRecord()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM subscriptions WHERE subscription_id = " . $this->subscription_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"subscription_id"    	=> $row['subscription_id'],
	    					"subscription_name_fr"	=> $row['subscription_name_fr'],
	    					"subscription_name_en"	=> $row['subscription_name_en'],
	    					"subscription_desc_fr"	=> $row['subscription_desc_fr'],
	    					"subscription_desc_en"	=> $row['subscription_desc_en'],
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
    // RETURN SUBSCRIPTION
    //////////////////////////////////////////////////////////////////
    public function GetSubscription()
    {
    	$this->SetCulture();
    	 
    	$rs = mysql_query("SELECT subscription_id, " . $this->lang_name_field . " FROM subscriptions WHERE subscription_id=" . $this->subscription_id);
    	 
    	$row = mysql_fetch_array($rs);
    
    	$this->subscription_id		= $row['subscription_id'];
    	$this->subscription_name	= $row[$this->lang_name_field];
    	
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
       
    //////////////////////////////////////////////////////////////////
    // RETURN SUBSCRIPTION NAME BY ID
    //////////////////////////////////////////////////////////////////    
    public function GetSubscriptionNameByID($id)
    {     
    	$this->SetCulture();
    	
    	$rs = mysql_query("SELECT $this->lang_name_field FROM subscriptions WHERE subscription_id = " . $id);
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		return false;
    	}
    	 
    	$row = mysql_fetch_array($rs);
    	 
    	return $row[$this->lang_name_field];
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN SUBSCRIPTION ID FROM SUBSCRIPTION NAME
    //////////////////////////////////////////////////////////////////
    public function GetSubscriptionIDFromName($subscription_name)
    {
    	$output = mysql_result(mysql_query("SELECT subscription_id FROM subscriptions WHERE subscription_name_fr = '" . $subscription_name . "' OR subscription_name_en = '" . $subscription_name . "'" ), 0, 0);
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // CREATE SUBSCRIPTION
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
    	// CREATE RETAILER TYPE ////////////////////////////////////////////
    	$rs = mysql_query("INSERT INTO subscriptions (subscription_name_fr,
	                                                   subscription_name_en,
    												   subscription_desc_fr,
	                                                   subscription_desc_en,
	                                                   created_by_id,
	                                                   created_date,
	                                                   modified_by_id,
	                                                   modified_date,
	                								   rowguid) VALUES
                                                           ('" . scrub($this->subscription_name_fr) .
										    				"','" . scrub($this->subscription_name_en) .
											    			"','" . scrub($this->subscription_desc_fr) .
											    			"','" . scrub($this->subscription_desc_en) .
										    				"','" . $this->created_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . $this->modified_by_id .
										    				"','" . date("Y-m-d H:i:s") .
										    				"','" . create_guid() ."')");
    		 
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    		 
    		 
    	$this->subscription_id = mysql_insert_id();
    		 
    	return mysql_insert_id();
    		 
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // UPDATE SUBSCRIPTION
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$rs = mysql_query("UPDATE subscriptions SET subscription_name_fr='" . scrub($this->subscription_name_fr) .
								    				 "', subscription_name_en='" . scrub($this->subscription_name_en) .
									    			 "', subscription_desc_fr='" . scrub($this->subscription_desc_fr) .
									    			 "', subscription_desc_en='" . scrub($this->subscription_desc_en) .
								    				 "', modified_by_id='" . $this->modified_by_id .
								    				 "', modified_date='" . date("Y-m-d H:i:s") .
								    				 "' WHERE subscription_id=" . $this->subscription_id);
    		
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    	
    }
    
    //////////////////////////////////////////////////////////////////
    // DELETE SUBSCRIPTIONS
    //////////////////////////////////////////////////////////////////
    public function Delete()
    {
    	$rs = mysql_query("DELETE FROM subscriptions WHERE subscription_id=" . $this->subscription_id);
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
   
}

?>