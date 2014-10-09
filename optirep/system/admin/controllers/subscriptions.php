<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE SUBSCRIPTION
	//////////////////////////////////////////////////////////////////
	if(empty($_POST['id']) && (!empty($_POST['name_fr']) || !empty($_POST['name_en'])))
	{
		$subscription = new Subscriptions();
		
		$subscription->subscription_name_fr = $_POST['name_fr'];
		$subscription->subscription_name_en = $_POST['name_en'];
		
		$subscription->subscription_desc_fr = $_POST['desc_fr'];
		$subscription->subscription_desc_en = $_POST['desc_en'];
		
		$subscription->created_by_id = 2;
		$subscription->modified_by_id = 2;
		
		$subscription->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE SUBSCRIPTION
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$subscription = new Subscriptions();
	
		$subscription->subscription_id = $_POST['id'];
		
		$subscription->subscription_name_fr = $_POST['name_fr'];
		$subscription->subscription_name_en = $_POST['name_en'];
		
		$subscription->subscription_desc_fr = $_POST['desc_fr'];
		$subscription->subscription_desc_en = $_POST['desc_en'];		
		
		$subscription->modified_by_id = 2;
		
		$subscription->Update();
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE SUBSCRIPTION
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['delete']))
	{
		$subscription = new Subscriptions();
		
		$subscription->subscription_id = $_GET['delete'];
		
		$subscription->Delete();	
	}
 ?>