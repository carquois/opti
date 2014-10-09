<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE ORGANIZATION TYPE
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['fr']) || !empty($_POST['en'])))
	{
		$organization_type = new OrganizationTypes();
		
		$organization_type->organization_type_name_fr = !empty($_POST['fr']) ? $_POST['fr'] : $_POST['en'];
		$organization_type->organization_type_name_en = !empty($_POST['en']) ? $_POST['en'] : $_POST['fr'];
		
		$organization_type->created_by_id = 2;
		$organization_type->modified_by_id = 2;
		
		$organization_type->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE ORGANIZATION TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$organization_type = new OrganizationTypes();
		
		$organization_type->organization_type_id = $_POST['id'];
		$organization_type->organization_type_name_fr = $_POST['fr'];
		$organization_type->organization_type_name_en = $_POST['en'];
		
		$organization_type->modified_by_id = 2;
		
		$organization_type->Update();	
	}
	
	//////////////////////////////////////////////////////////////////
	// DELETE ORGANIZATION TYPES
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$organization_type = new OrganizationTypes();
		
		$organization_type->organization_type_id = $_GET['delete'];
		
		$organization_type->Delete();	
	}
 ?>