<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE PROFESSIONAL TYPE
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['fr']) || !empty($_POST['en'])))
	{
		$professional_type = new ProfessionalTypes();
		
		$professional_type->professional_type_name_fr = !empty($_POST['fr']) ? $_POST['fr'] : $_POST['en'];
		$professional_type->professional_type_name_en = !empty($_POST['en']) ? $_POST['en'] : $_POST['fr'];
		
		$professional_type->created_by_id = 2;
		$professional_type->modified_by_id = 2;
		
		$professional_type->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE PROFESSIONAL TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$professional_type = new ProfessionalTypes();
	
		$professional_type->professional_type_id = $_POST['id'];
		$professional_type->professional_type_name_fr = $_POST['fr'];
		$professional_type->professional_type_name_en = $_POST['en'];
		
		$professional_type->modified_by_id = 2;
		
		$professional_type->Update();
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE PROFESSIONAL TYPES
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$professional_type = new ProfessionalTypes();
		
		$professional_type->professional_type_id = $_GET['delete'];
		
		$professional_type->Delete();	
	}
 ?>