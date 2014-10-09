<?php

	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');



	//checkToken(); // Check Authentication Token

	//////////////////////////////////////////////////////////////////
	// CREATE USER
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['ul']) && $_POST['id'] == 0)
	{
		$user = new User();
		
		$user->user_login = $_POST['ul'];
		$user->user_type_id = $_POST['ut'];
		$user->user_password = $_POST['up'];
		
		$user->created_by_id = 2;
		$user->modified_by_id = 2;
		
		$user->Create();
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE USER
	//////////////////////////////////////////////////////////////////
	if(!empty($_POST['id']))
	{
		$user = new User();
		
		$user->user_id = $_POST['id'];
		$user->user_type_id = $_POST['ut'];
		$user->user_login = $_POST['ul'];
		$user->user_password = $_POST['up'];
		
		$user->modified_by_id = 2;
		
		$user->Update();
	}
	
	//////////////////////////////////////////////////////////////////
	// CHECK DUPLICATE LOGIN
	//////////////////////////////////////////////////////////////////
	if(!empty($_GET['checklogin']))
	{
		$user = new User();
		$user->user_id = $_POST['i'];
		$user->user_login = scrub($_POST['l']);
	
		// Return
		$result = $user->CheckIfUserExists();
		echo($result);
	}
	
    //////////////////////////////////////////////////////////////////
    // DELETE USER
    //////////////////////////////////////////////////////////////////
    if(!empty($_GET['delete']))
    {
        $user = new User();
        
        $user->user_id = $_GET['delete'];
        $user->Delete();
    }
    
    

?>