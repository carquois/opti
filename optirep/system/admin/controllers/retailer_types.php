<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER TYPE
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['fr']) || !empty($_POST['en'])))
	{
		$retailer_type = new RetailerTypes();
		
		$retailer_type->retailer_type_name_fr = !empty($_POST['fr']) ? $_POST['fr'] : $_POST['en'];
		$retailer_type->retailer_type_name_en = !empty($_POST['en']) ? $_POST['en'] : $_POST['fr'];
		
		$retailer_type->created_by_id = 2;
		$retailer_type->modified_by_id = 2;
		
		$retailer_type->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE RETAILER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$retailer_type = new RetailerTypes();
	
		$retailer_type->retailer_type_id = $_POST['id'];
		$retailer_type->retailer_type_name_fr = $_POST['fr'];
		$retailer_type->retailer_type_name_en = $_POST['en'];
		
		$retailer_type->modified_by_id = 2;
		
		$retailer_type->Update();
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE RETAILER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$retailer_type = new RetailerTypes();
		
		$retailer_type->retailer_type_id = $_GET['delete'];
		
		$retailer_type->Delete();	
	}
 ?>