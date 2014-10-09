<?php

class User
{

    //////////////////////////////////////////////////////////////////
    // PROPERTIES
    //////////////////////////////////////////////////////////////////
    public $user_id         = 0;   
    public $user_type_id	= 0;
    public $user_login		= "";
    public $user_password   = "";
    public $created_by_id 	= "";
    public $created_date	= "";
    public $modified_by_id	= "";
    public $modified_date	= "";
    
        
    public $admin_users_records	= "";
    public $admin_users_list	= "";
    
    //////////////////////////////////////////////////////////////////
    // METHODS
    //////////////////////////////////////////////////////////////////
    
    // ------------------------------------------------------------ //
    
    //////////////////////////////////////////////////////////////////
    // RETURN USER'S LIST
    //////////////////////////////////////////////////////////////////
    public function LoadList()
    {
    	$this->admin_users_list = $this->GetUsersList();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USER'S LIST COMPLETE RECORDS
    //////////////////////////////////////////////////////////////////
    public function LoadRecords()
    {
    	$this->admin_users_records = $this->GetUsersRecords();
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USERS LIST.
    //////////////////////////////////////////////////////////////////
    public function GetUsersList()
    {
    	$output = array();
    	
    	$rs = mysql_query("SELECT * FROM users ORDER BY user_login");
    	
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"user_id"      	=> $row['user_id'],
	    					"user_login"   	=> stripslashes($row['user_login']),
	    					"user_type_id" 	=> $row['user_type_id']
    			);
    		}
    	}    	
    	
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USER
    //////////////////////////////////////////////////////////////////
    public function GetUser()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM users WHERE user_id = " . $this->user_id);
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"user_id"      	=> $row['user_id'],
    					"user_login"   	=> stripslashes($row['user_login']),
    					"user_type_id" 	=> $row['user_type_id']
    			);
    		}
    	}
    	 
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USER TYPE NAME BY ID
    //////////////////////////////////////////////////////////////////
    public function GetUserNameByID($id)
    {
    	$output = mysql_result(mysql_query("SELECT user_login FROM users WHERE user_id = " . $id), 0, 0);
    
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USERS LIST COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetUsersRecords()
    {
    	$output = array();
    	 
    	$rs = mysql_query("SELECT * FROM users ORDER BY user_login");
    	 
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"user_id"      		=> $row['user_id'],
	    					"user_login"   		=> stripslashes($row['user_login']),
	    					"user_type_id"  	=> $row['user_type_id'],
	    					"created_by_id"		=> $row['created_by_id'],
	    					"created_date"  	=> $row['created_date'],
	    					"modified_by_id"  	=> $row['modified_by_id'],
	    					"modified_date"  	=> $row['modified_date']
    			);
    		}
    	}
    	 
    	return $output;
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN USER COMPLETE RECORD
    //////////////////////////////////////////////////////////////////
    public function GetUserRecord()
    {
    	$output = array();
    
    	$rs = mysql_query("SELECT * FROM users WHERE user_id = " . $this->user_id);
    
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
	    					"user_id"      		=> $row['user_id'],
	    					"user_type_id"  	=> $row['user_type_id'],
	    					"user_login"   		=> stripslashes($row['user_login']),
	    					"user_password"   	=> $row['user_password'],
	    					"created_by_id"		=> $row['created_by_id'],
	    					"created_date"  	=> $row['created_date'],
	    					"modified_by_id"  	=> $row['modified_by_id'],
	    					"modified_date"  	=> $row['modified_date']
    			);
    		}
    	}
    
    	return $output;
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN USERS LIST BY USER TYPE
    //////////////////////////////////////////////////////////////////
    public function GetUsersListByUserType()
    {
    	$output = array();
    	$rs = mysql_query("SELECT * FROM users WHERE user_type_id=" . $this->user_type_id);
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"user_id"      		=> $row['user_id'],
    					"user_login"   		=> stripslashes($row['user_login']),
    					"user_type_id"   	=> $row['user_type_id']
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
    // RETURN USERS LIST COMPLETE RECORD BY USER TYPE
    //////////////////////////////////////////////////////////////////
    public function GetUsersRecordsByUserType()
    {
    	$output = array();
    	$rs = mysql_query("SELECT * FROM users WHERE user_type_id=" . $this->user_type_id);
    	if(mysql_num_rows($rs)==0)
    	{
    		$output = 0;
    	}
    	else
    	{
    		while($row=mysql_fetch_array($rs))
    		{
    			$output[] = array(
    					"user_id"      		=> $row['user_id'],
    					"user_login"   		=> stripslashes($row['user_login']),
    					"user_type_id"   	=> $row['user_type_id'],
    					"created_by_id"		=> $row['created_by_id'],
    					"created_date"  	=> $row['created_date'],
    					"modified_by_id"	=> $row['modified_by_id'],
    					"modified_date"  	=> $row['modified_date']
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
    // CREATE USER
    //////////////////////////////////////////////////////////////////    
    public function Create()
    { 
        $this->EncryptPassword();
        
        // CREATE USER ////////////////////////////////////////////
        $rs = mysql_query("INSERT INTO users (user_login,
	                                          user_type_id,
        									  user_password,
	                                          created_by_id,
	                                          created_date,
	                                          modified_by_id,
	                                          modified_date,
	                						  rowguid) VALUES
                                                       ('" . scrub($this->user_login) .
											        	"','" . scrub($this->user_type_id) .
        												"','" . scrub($this->user_password) .
											        	"','" . $this->created_by_id .
											        	"','" . date("Y-m-d H:i:s") .
											        	"','" . $this->modified_by_id .
											        	"','" . date("Y-m-d H:i:s") .
											        	"','" . create_guid() ."')");
         
					
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }         
         
        $this->user_id = mysql_insert_id();
         
        return mysql_insert_id();
    }   
   
    
    //////////////////////////////////////////////////////////////////
    // UPDATE USER
    //////////////////////////////////////////////////////////////////
    public function Update()
    {
    	$this->EncryptPassword();
    	
    	$rs = mysql_query("UPDATE users SET user_login='" . scrub($this->user_login) .
										"', user_type_id='" . $this->user_type_id .
    									"', user_password='" . $this->user_password .
										"', modified_by_id='" . $this->modified_by_id .
										"', modified_date='" . date("Y-m-d H:i:s") .
										"' WHERE user_id=" . $this->user_id);
    
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
    	$rs = mysql_query("DELETE FROM users WHERE user_id=" . $this->user_id);
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // CHECK DUPLICATE LOGIN
    //////////////////////////////////////////////////////////////////
    public function CheckIfUserExists()
    {
    	$exists = 0;    	
    	    
    	$rs = mysql_query("SELECT user_id FROM users WHERE user_login='" . $this->user_login . "'");
    
    	if(mysql_num_rows($rs)!=0)
    	{
    		$exists = 1;
    	}
    
    	if (mysql_errno())
    	{
    		return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    	}
    
    	return $exists;
    }
    
    //////////////////////////////////////////////////////////////////
    // AUTHENTICATE
    //////////////////////////////////////////////////////////////////
    public function Authenticate()
    {
    	$this->EncryptPassword();
    	$rs = mysql_query("SELECT user_id, user_type_id FROM users WHERE
							      user_login='" . scrub($this->user_login) . "'
							      AND user_password='" . $this->user_password . "'");
    
    	if(mysql_num_rows($rs)==0)
    	{
    		return 0;
    	}
    	else
    	{
    		$row = mysql_fetch_array($rs);
    		$_SESSION['admin'] = $row['user_id'];
    		$_SESSION['admin_type'] = $row['user_type_id'];
    		return 1;
    	}
    }
    
    //////////////////////////////////////////////////////////////////
    // CHANGE PASSWORD
    //////////////////////////////////////////////////////////////////    
    public function ChangePassword()
    {
        $this->EncryptPassword();
        
        $rs = mysql_query("UPDATE users SET user_password='" . $this->user_password
				    					. "' WHERE user_id=" . $this->user_id);
        
        if (mysql_errno())
        {
        	return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
        }
    }
    
    //////////////////////////////////////////////////////////////////
    // GENERATE PASSWORD
    //////////////////////////////////////////////////////////////////    
    public function GeneratePassword()
    {
        $len = 8;
        $hex = md5("1n3B82Gh6Ti52o905" . uniqid("", true));
        $pack = pack('H*', $hex);
        $uid = base64_encode($pack);        			// max 22 chars
        $uid = ereg_replace("[^A-Za-z0-9]", "", $uid);  // mixed case
        if ($len<4) $len=4;
        if ($len>128) $len=128;                       	// prevent silliness, can remove
        while (strlen($uid)<$len)
		{
            $uid = $uid . generatePassword(22);     	// append until length achieved
		}
        
		$key = substr($uid, 0, $len);
		
        return $key;  
    }   
    
        
    //////////////////////////////////////////////////////////////////
    // ENCRYPT PASSWORD
    //////////////////////////////////////////////////////////////////    
    private function EncryptPassword()
    {
        $this->user_password = sha1(md5($this->user_password));
    }    
}

?>
