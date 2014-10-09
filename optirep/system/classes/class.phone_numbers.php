<?php


class PhoneNumbers
{	
    // PHONE NUMBERS
    public $phone_number_id				= "";
    public $phone_number1    			= "";
    public $phone_number2				= "";
    public $phone_number_mobile         = "";
    public $phone_number_toll_free  	= "";
    public $phone_number_fax			= "";
    public $phone_number_fax_toll_free	= "";
    public $created_by_id				= 0;
    public $created_date    			= "";
    public $modified_by_id 				= 0;
    public $date_modified   			= ""; 
    
	
    //////////////////////////////////////////////////////////////////
    // RETURN PHONE NUMBER
    //////////////////////////////////////////////////////////////////
    public function GetPhoneNumbers()
    {
    	$rs = mysql_query("SELECT * FROM phone_numbers WHERE phone_number_id=" . $this->phone_number_id);
    	$row = mysql_fetch_array($rs);
    
    	$this->phone_number_id    			= $row['phone_number_id'];
    	$this->phone_number1    			= $row['phone_number1'];
    	$this->phone_number2				= $row['phone_number2'];
    	$this->phone_number_mobile          = $row['phone_number_mobile'];
    	$this->phone_number_toll_free  		= $row['phone_number_toll_free'];
    	$this->phone_number_fax  			= $row['phone_number_fax'];
    	$this->phone_number_fax_toll_free	= $row['phone_number_fax_toll_free'];
    	$this->created_by_id 				= $row['created_by_id'];
    	$this->created_date    				= $row['created_date'];
    	$this->modified_by_id 				= $row['modified_by_id'];
    	$this->date_modified   				= $row['modified_date'];
    
    	
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN RETAILERS LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetPhoneNumbersList()
    {        
        $output = array();
        $rs = mysql_query("SELECT * FROM phone_numbers");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
		                    "phone_number_id"        		=> $row['phone_number_id'],
		                    "phone_number1"     			=> $row['phone_number1'],
		                    "phone_number2"       			=> $row['phone_number2'],
		                    "phone_number_mobile"     		=> $row['phone_number_mobile'],
		                    "phone_number_toll_free"    	=> $row['phone_number_toll_free'],
		                    "phone_number_fax"				=> $row['phone_number_fax'],
		                    "phone_number_fax_toll_free"	=> $row['phone_number_fax_toll_free'],
		                	"created_by_id"  				=> $row['created_by_id'],
		                    "created_date"   				=> $row['created_date'],
		                    "modified_by_id" 				=> $row['modified_by_id'],
		                	"modified_date"  				=> $row['modified_date']
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
    // CREATE PHONE NUMBER
    //////////////////////////////////////////////////////////////////
    public function Create()
    {
        // CREATE PHONE_NUMBER ////////////////////////////////////////////                  
        $rs = mysql_query("INSERT INTO phone_numbers (phone_number1,
                                                      phone_number2,
            										  phone_number_mobile, 
                                                      phone_number_toll_free,
                                                      phone_number_fax,
                                                      phone_number_fax_toll_free,
                                                      created_by_id,
                                                      created_date,
            										  modified_by_id,
                                                      modified_date,
                									  rowguid) VALUES
	                                                           	('" . scrub($this->phone_number1) .
	                                                           "','" . scrub($this->phone_number2) .
	                                                           "','" . scrub($this->phone_number_mobile) . 
	                                                           "','" . scrub($this->phone_number_toll_free) .
	                                                           "','" . scrub($this->phone_number_fax) .
	                                                           "','" . scrub($this->phone_number_fax_toll_free) .
	            											   "','" . $this->created_by_id .
	                                                           "','" . date("Y-m-d H:i:s") .
	            											   "','" . $this->modified_by_id .
	                                                           "','" . date("Y-m-d H:i:s") .
	            											   "','" . create_guid() ."')");
           
        if (mysql_errno())
        {
            return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
            
            
        $this->phone_number_id = mysql_insert_id();
            
        return mysql_insert_id();
    }   
    
    //////////////////////////////////////////////////////////////////
    // UPDATE PHONE NUMBER
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
        $rs = mysql_query("UPDATE phone_numbers SET phone_number1='" . scrub($this->phone_number1) .
	            									"', phone_number2='" . scrub($this->phone_number2) .
	            									"', phone_number_mobile='" . scrub($this->phone_number_mobile) .
	            									"', phone_number_toll_free='" . scrub($this->phone_number_toll_free) .
	                                                "', phone_number_fax='" . scrub($this->phone_number_fax) .
	                                                "', phone_number_fax_toll_free='" . $this->phone_number_fax_toll_free .
	            									"', modified_by_id='" . $this->modified_by_id .
	                                                "', modified_date='" . date("Y-m-d H:i:s") .
	            									"' WHERE phone_number_id=" . $this->phone_number_id);
            
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
        
    }
    
    
    //////////////////////////////////////////////////////////////////
    // DELETE PHONE NUMBER
    //////////////////////////////////////////////////////////////////
    public function Delete($phone_number_id)
    {
        $rs = mysql_query("DELETE FROM phone_numbers WHERE phone_number_id=" . $phone_number_id);
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
    }
}





?>