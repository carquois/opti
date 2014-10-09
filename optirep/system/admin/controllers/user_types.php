<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE USER TYPE
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['fr']) || !empty($_POST['en'])))
	{
		$user_type = new UserTypes();
		
		$user_type->user_type_name_fr = !empty($_POST['fr']) ? $_POST['fr'] : $_POST['en'];
		$user_type->user_type_name_en = !empty($_POST['en']) ? $_POST['en'] : $_POST['fr'];
		
		$user_type->created_by_id = 2;
		$user_type->modified_by_id = 2;
		
		$user_type->Create();		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE USER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$user_type = new UserTypes();
	
		$user_type->user_type_id = $_POST['id'];
		$user_type->user_type_name_fr = $_POST['fr'];
		$user_type->user_type_name_en = $_POST['en'];
		
		$user_type->modified_by_id = 2;
		
		$user_type->Update();
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE USER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$user_type = new UserTypes();
		
		$user_type->user_type_id = $_GET['delete'];
		
		$user_type->Delete();	
	}
 ?>