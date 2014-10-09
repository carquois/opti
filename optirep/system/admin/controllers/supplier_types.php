<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE SUPPLIER TYPE
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['fr']) || !empty($_POST['en'])))
	{
		$supplier_type = new SupplierTypes();
		
		$supplier_type->supplier_type_name_fr = !empty($_POST['fr']) ? $_POST['fr'] : $_POST['en'];
		$supplier_type->supplier_type_name_en = !empty($_POST['en']) ? $_POST['en'] : $_POST['fr'];
		
		$supplier_type->created_by_id = 2;
		$supplier_type->modified_by_id = 2;
		
		$supplier_type->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE SUPPLIER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$supplier_type = new SupplierTypes();
	
		$supplier_type->supplier_type_id = $_POST['id'];
		$supplier_type->supplier_type_name_fr = $_POST['fr'];
		$supplier_type->supplier_type_name_en = $_POST['en'];
		
		$supplier_type->modified_by_id = 2;
		
		$supplier_type->Update();
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE SUPPLIER TYPE
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$supplier_type = new SupplierTypes();
		
		$supplier_type->supplier_type_id = $_GET['delete'];
		
		$supplier_type->Delete();	
	}
 ?>