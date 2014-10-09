<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['create']))
	{
		$phone_number = new PhoneNumbers();
		
		$phone_number->phone_number1    			= format_phone_number($_POST['phone1']);
		$phone_number->phone_number2    			= format_phone_number($_POST['phone2']);
		
		if(isset($_POST['mob']))
		{
			$phone_number->phone_number_mobile  	= format_phone_number($_POST['mob']);
		}
		
		$phone_number->phone_number_toll_free   	= format_phone_number($_POST['free']);
		$phone_number->phone_number_fax 			= format_phone_number($_POST['fax']);
		$phone_number->phone_number_fax_toll_free	= format_phone_number($_POST['faxfree']);
		
		$phone_number->created_by_id = 2;
		$phone_number->modified_by_id = 2;
		
		echo $phone_number->Create(); // Returns newly created ID
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['update']))
	{
		$phone_number = new PhoneNumbers();
		
		$phone_number->phone_number_id    			= format_phone_number($_POST['id']);
		$phone_number->phone_number1    			= format_phone_number($_POST['phone1']);
		$phone_number->phone_number2    			= format_phone_number($_POST['phone2']);
		
		if(isset($_POST['mob']))
		{
			$phone_number->phone_number_mobile  	= format_phone_number($_POST['mob']);
		}		
		
		$phone_number->phone_number_toll_free   	= format_phone_number($_POST['free']);
		$phone_number->phone_number_fax 			= format_phone_number($_POST['fax']);
		$phone_number->phone_number_fax_toll_free	= format_phone_number($_POST['faxfree']);
		
		$phone_number->modified_by_id = 2;
		
		$phone_number->Update();	
	}
	
	//////////////////////////////////////////////////////////////////
	// DELETE PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$phone_number = new PhoneNumbers();
		
		$phone_number->phone_number_id = $_GET['delete'];
		
		$phone_number->Delete();

		
	}
 ?>
