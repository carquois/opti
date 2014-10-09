<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE ADDRESS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['create']))
	{
		$address = new Addresses();
		
		$address->address1        		= $_POST['add1'];		
		$address->address2        		= $_POST['add2'];
		$address->city         			= $_POST['city'];
		$address->province_state 		= $_POST['ps'];
		$address->province_state_short 	= $_POST['pss'];
		$address->country_region		= $_POST['cr'];
		$address->country_region_short	= $_POST['crs'];
		$address->postal_zip_code		= $_POST['postal'];
		$address->latitude    			= $_POST['lati'];
		$address->longitude  			= $_POST['longi'];			
		
		$address->created_by_id = 2;
		$address->modified_by_id = 2;
		
		echo $address->Create(); // Returns newly created ID
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE ADDRESS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['update']))
	{
		$address = new Addresses();
		
		$address->address_id        	= $_POST['id'];
		$address->address1        		= $_POST['add1'];		
		$address->address2        		= $_POST['add2'];
		$address->city         			= $_POST['city'];
		$address->province_state 		= $_POST['ps'];
		$address->province_state_short 	= $_POST['pss'];
		$address->country_region		= $_POST['cr'];
		$address->country_region_short	= $_POST['crs'];
		$address->postal_zip_code		= $_POST['postal'];
		$address->latitude    			= $_POST['lati'];
		$address->longitude  			= $_POST['longi'];		
		
		$address->modified_by_id = 2;
		
		$address->Update();	
	}
	
	//////////////////////////////////////////////////////////////////
	// DELETE ADDRESS
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$address = new Addresses();
		
		$address->address_id = $_GET['delete'];
		
		$address->Delete();

		
	}
 ?>
