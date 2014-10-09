<?php


class Reps
{  

    public $rep_id			= 0;
    public $language_id		= 0;
    public $company_id		= 0;
    public $rep_type_id		= 0;
    
    public $rep_first_name		= "";
    public $rep_last_name		= "";	
    
    public $is_active			= false;
    
    public $created_by_id		= 0;
    public $created_date		= "";
    public $modified_by_id		= 0;
    public $modified_date		= ""; 
    
    public $addressline1		= "";
    public $addressline2		= "";
    public $city				= "";
    public $province			= "";
    public $country			= "";
    public $postalcode			= "";
    public $telephone			= "";
    public $mobile			= "";
    public $email				= "";
    public $website			= "";
    
    public $reps_list			= "";
   
     //////////////////////////////////////////////////////////////////
    // RETURN REP LIST
    //////////////////////////////////////////////////////////////////    
     public function load()
    {
        $this->reps_list = $this->GetRepsList();
    }
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN REP
    //////////////////////////////////////////////////////////////////    
    public function GetRep()
    {        
        $rs = mysql_query("SELECT * FROM reps WHERE rep_id=" . $this->rep_id);
        $row = mysql_fetch_array($rs);        
        
        $this->logo_path        = $row['mbs_logo_path'];
        $this->company          = $row['mbs_company'];
        $this->firstname        = $row['mbs_firstname']; 
        $this->lastname         = $row['mbs_lastname'];
        $this->addressline1     = $row['mbs_addressline1'];
        $this->addressline2     = $row['mbs_addressline2'];
        $this->city             = $row['mbs_city'];
        $this->province         = $row['mbs_province'];
        $this->country          = $row['mbs_country'];
        $this->postalcode       = $row['mbs_postalcode'];
        $this->telephone        = $row['mbs_telephone'];
        $this->mobile           = $row['mbs_mobile'];
        $this->email            = $row['mbs_email'];
        $this->website          = $row['mbs_website'];
        $this->services_ids     = $row['mbs_services_ids'];
        $this->serviced_cities  = $row['mbs_serviced_cities'];
        $this->active           = $row['mbs_active'];
        $this->date_created     = $row['mbs_date_created'];
        $this->date_modified    = $row['mbs_date_modified'];
    }

    //////////////////////////////////////////////////////////////////
    // RETURN REPS LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetRepsList()
    {        
        $output = array();
        $rs = mysql_query("SELECT * FROM reps");
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
                $output[] = array(
                    "rep_id"		=> $row['rep_id'],
		    		"language_id"	=> $row['language_id'],
		    		"rep_type_id"	=> $row['rep_type_id'],
                    "company_id"	=> $row['company_id'],
                    "rep_first_name"	=> $row['rep_first_name'],
                    "rep_last_name"	=> $row['rep_last_name'],
                    "is_active"		=> $row['is_active'],
                ); 
            }
        }
        
        return $output;        
    }
    
    //////////////////////////////////////////////////////////////////
    // RETURN REPS LISTING BY ID's
    //////////////////////////////////////////////////////////////////    
    public function GetRepsListByIDs($ids)
    {        
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
                    $where_statement .= "rep_id='" . $value . "'";
            
                }
                else
                {
                    $where_statement .= "rep_id='" . $value . "' OR ";
                }
                $i++;
            }
        }
        
        $rs = mysql_query("SELECT * FROM reps WHERE " .  $where_statement . " ORDER BY rep_last_name ASC");
        
        if(mysql_num_rows($rs)==0)
        {
            $output = 0;
        }
        else
        {
            while($row=mysql_fetch_array($rs))
            {
               $output[] = array(
                    "rep_id"			=> $row['rep_id'],
		    		"language_id"		=> $row['language_id'],
		    		"rep_type_id"		=> $row['rep_type_id'],
                    "company_id"		=> $row['company_id'],
                    "rep_first_name"	=> $row['rep_first_name'],
                    "rep_last_name"		=> $row['rep_last_name'],
                    "is_active"			=> $row['is_active'],
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
    // RETURN REPS LISTING
    //////////////////////////////////////////////////////////////////    
    public function GetRepsListByUserFilters($filters)
    {        
        // Set filtered fields.
        $rep_types_field = "mbs_services_ids";
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
        $sql_statement = "SELECT * FROM reps " . $where_statement . " ORDER BY rep_last_name ASC";
      
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
                    "rep_id"		=> $row['rep_id'],
		    "language_id"	=> $row['language_id'],
		    "rep_type_id"	=> $row['rep_type_id'],
                    "company_id"	=> $row['company_id'],
                    "rep_first_name"	=> $row['rep_first_name'],
                    "rep_last_name"	=> $row['rep_last_name'],
                    "is_active"		=> $row['is_active'],
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
    // SAVE OR UPDATE REP
    //////////////////////////////////////////////////////////////////
    public function SaveRep()
    {
        // CREATE REP ////////////////////////////////////////////
        if($this->id=="new")
        {            
            $rs = mysql_query("INSERT INTO reps (mbs_logo_path,
                                                           mbs_company, 
                                                           mbs_firstname, 
                                                           mbs_lastname,
                                                           mbs_addressline1,
                                                           mbs_addressline2,
                                                           mbs_city,
                                                           mbs_province,
                                                           mbs_country,
                                                           mbs_postalcode,
                                                           mbs_telephone,
                                                           mbs_mobile,
                                                           mbs_email,
                                                           mbs_website,
                                                           mbs_services_ids,
                                                           mbs_serviced_cities,
                                                           mbs_active,
                                                           mbs_date_created,
                                                           mbs_date_modified) VALUES
                                                           ('" . $this->logo_path . 
                                                           "','" . $this->company .
                                                           "','" . $this->firstname .
                                                           "','" . $this->lastname . 
                                                           "','" . $this->addressline1 .
                                                           "','" . $this->addressline2 .
                                                           "','" . $this->city .
                                                           "','" . $this->province .
                                                           "','" . $this->country .
                                                           "','" . $this->postalcode .
                                                           "','" . $this->telephone .
                                                           "','" . $this->mobile .
                                                           "','" . $this->email .
                                                           "','" . $this->website .
                                                           "','" . $this->services_ids .
                                                           "','" . $this->serviced_cities .
                                                           "','" . $this->active .
                                                           "','" . $this->date_created .
                                                           "','" . $this->date_modified . "')");
           
            if (mysql_errno())
            {
                return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
            }
            
            
            $this->rep_id = mysql_insert_id();
            
            return mysql_insert_id();
            
        }
        else // UPDATE REP ////////////////////////////////////////////
        {
            $rs = mysql_query("UPDATE reps SET mbs_logo_path='" . $this->logo_path . "',
                                                         mbs_company='" . scrub($this->company) . "',
                                                         mbs_firstname='" . $this->firstname . "',
                                                         mbs_lastname='" . $this->lastname . "',
                                                         mbs_addressline1='" . scrub($this->addressline1) . "',
                                                         mbs_addressline2='" . scrub($this->addressline2) . "',
                                                         mbs_city='" . scrub($this->city) . "',
                                                         mbs_province='" . $this->province . "',
                                                         mbs_country='" . $this->country . "',
                                                         mbs_postalcode='" . $this->postalcode . "',
                                                         mbs_telephone='" . scrub($this->telephone) . "',
                                                         mbs_mobile='" . scrub($this->mobile) . "',
                                                         mbs_email='" . $this->email . "',
                                                         mbs_website='" . $this->website . "',
                                                         mbs_services_ids='" . $this->services_ids . "',
                                                         mbs_serviced_cities='" . $this->serviced_cities . "',
                                                         mbs_active='" . $this->active . "',
                                                         mbs_date_modified='" . date("Y-m-d H:i:s") . "' WHERE mbs_id=" . $this->id);
        }
    }
    
   
    
    
    //////////////////////////////////////////////////////////////////
    // DELETE
    //////////////////////////////////////////////////////////////////
    public function DeleteRep($rep_id)
    {
        $rs = mysql_query("DELETE FROM reps WHERE rep_id=" . $rep_id);
    }
    
    
    
    //////////////////////////////////////////////////////////////////
    // RETURN TRUE OR FALSE. DEPENDS IF USER EXISTS OR NOT!
    //////////////////////////////////////////////////////////////////    
    public function IsAlreadyRep($company, $firstname, $lastname)
    {        
        $rs = mysql_query("SELECT mbs_company, mbs_firstname, mbs_lastname FROM cms_membership WHERE mbs_company='" . $company . "' AND mbs_firstname='" . $firstname . "' AND mbs_lastname='" . $lastname . "'");
        
        if (!$rs)
        {
            die('Could not query:' . mysql_error());
        }

        $row = mysql_fetch_array($rs);
        
        if(!empty($row))
        {
            return true;
        }
        
        return false;
        
        // DEBUG
        // echo $row['mbs_company'] . " " . $row['mbs_firstname']  . " " . $row['mbs_lastname'];
    }
    
    
   
}



?>