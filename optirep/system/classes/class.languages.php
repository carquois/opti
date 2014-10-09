<?php

	class Languages
	{
		//////////////////////////////////////////////////////////////////
		// PROPERTIES
		//////////////////////////////////////////////////////////////////
		public $language_id			= "";
		public $language_name_fr 	= "";
		public $language_name_en 	= "";
		public $created_by_id 		= 0;
    	public $created_date		= "";    
    	public $modified_by_id		= 0;
    	public $modified_date		= "";
    	
    	public $language_records	= "";
    	public $languages_list      = "";
    	
    	private $lang_name_field	= "";
    	
    	
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
    			$this->lang_name_field = "language_name_fr";
    		}
    		else
    		{
    			$this->lang_name_field = "language_name_en";
    		}
    	}
    	
    	 
    	//////////////////////////////////////////////////////////////////
    	// LOAD LANGUAGESS LIST. USED FOR DROPDOWN LIST
    	//////////////////////////////////////////////////////////////////
    	public function LoadList()
    	{
    		$this->SetCulture();
    		$this->languages_list = $this->GetLanguagesList();
    	}
    	
    	//////////////////////////////////////////////////////////////////
    	// LOAD LANGUAGES LIST COMPLETE RECORDS
    	//////////////////////////////////////////////////////////////////
    	public function LoadRecords()
    	{
    		$this->SetCulture();
    		$this->language_records = $this->GetLanguagesRecords();
    	}
    	
    	
    	//////////////////////////////////////////////////////////////////
	    // RETURN LANGUAGES. USED FOR DROPDOWN LIST
	    //////////////////////////////////////////////////////////////////
    	public function GetLanguagesList()
    	{
    		$output = array();
    	
    		$rs = mysql_query("SELECT language_id, " . $this->lang_name_field . ", language_abbreviation FROM languages WHERE is_active = 1");
    	
    		if(mysql_num_rows($rs)==0)
    		{
    			$output = 0;
    		}
    		else
    		{
    			while($row=mysql_fetch_array($rs))
    			{
    				$output[] = array(
	    						"language_id"    		=> $row['language_id'],
    							"language_name"  		=> $row[$this->lang_name_field],
    							"language_abbreviation" => $row['language_abbreviation']
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
	    // RETURN RETAILER TYPES COMPLETE RECORD
	    // THESE RECORDS ARE FOR ADMIN PURPOSES.
	    //////////////////////////////////////////////////////////////////
    	public function GetLanguagesRecords()
    	{
    		$output = array();
    		 
    		$rs = mysql_query("SELECT * FROM languages");
    		 
    		if(mysql_num_rows($rs)==0)
    		{
    			$output = 0;
    		}
    		else
    		{
    			while($row=mysql_fetch_array($rs))
    			{
    				$output[] = array(
    						"language_id"    		=> $row['language_id'],
    						"language_name"  		=> $row[$this->lang_name_field],
    						"language_abbreviation" => $row['language_abbreviation'],
    						"is_active"  			=> $row['language_name_en'],
    						"created_by_id"  		=> $row['created_by_id'],
    						"created_date"   		=> $row['created_date'],
    						"modified_by_id" 		=> $row['modified_by_id'],
    						"modified_date"  		=> $row['modified_date']
    				);
    			}
    		}
    	
    		if (mysql_errno())
    		{
    			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    		}
    	
    		return $output;
    	}
    	
    	/////////////////////////////////////////////////////////////////
    	// RETURN LANGUAGE NAME BY ID
    	//////////////////////////////////////////////////////////////////
    	public function GetLanguageNameByID($id)
    	{
    		$this->SetCulture();
    		$output = mysql_result(mysql_query("SELECT " . $this->lang_name_field . " FROM languages WHERE language_id = " . $id), 0, 0);
    	
    		return $output;
    	}
    	

    	//////////////////////////////////////////////////////////////////
    	// CREATE LANGUAGE
    	//////////////////////////////////////////////////////////////////
    	public function Create()
    	{
    		
    		$rs = mysql_query("INSERT INTO languages (language_name_fr,
	                                                  language_name_en,
	                                                  language_abbreviation,
	                                                  is_active,
	                                                  created_by_id,
	                                                  created_date,
	                                                  modified_by_id,
	                                                  modified_date,
	                								  rowguid) VALUES
                                                           ('" . scrub($this->language_name_fr) .
									    					"','" . scrub($this->language_name_en) .
									    					"','" . scrub($this->language_abbreviation) .
									    					"','" . scrub($this->is_active) .
									    					"','" . $this->created_by_id .
									    					"','" . date("Y-m-d H:i:s") .
									    					"','" . $this->modified_by_id .
									    					"','" . date("Y-m-d H:i:s") .
									    					"','" . create_guid() ."')");
    	
    		if (mysql_errno())
    		{
    			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    		}
    	
    	
    		$this->language_id = mysql_insert_id();
    	
    		return mysql_insert_id();
    	
    		
    	}
    	
    	//////////////////////////////////////////////////////////////////
    	// UPDATE LANGUAGE
    	//////////////////////////////////////////////////////////////////
    	public function Update()
    	{
    		$rs = mysql_query("UPDATE languages SET language_name_fr='" . scrub($this->language_name_fr) .
								    				"', language_name_en='" . scrub($this->language_name_en) .
								    				"', language_abbreviation='" . $this->language_abbreviation .
								    				"', is_active='" . $this->is_active .
								    				"', modified_by_id='" . $this->modified_by_id .
								    				"', modified_date='" . date("Y-m-d H:i:s") .
								    				"' WHERE language_id=" . $this->language_id);
    		
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
    		$rs = mysql_query("DELETE FROM languages WHERE language_id=" . $this->language_id);
    		
    		if (mysql_errno())
    		{
    			return "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$rs\n<br>";
    		}
    	}
    	 
	}

?>