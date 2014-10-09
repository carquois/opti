<?php
 
	require_once('../../../config.php');

    //////////////////////////////////////////////////////////////////
    // Authenticate User
    //////////////////////////////////////////////////////////////////
    
    if(!empty($_POST['ul']) && !empty($_POST['pwd']))
    {
        $user = new User();
        
        $user->user_login = $_POST['ul'];
        $user->user_password = $_POST['pwd'];
        
        echo($user->Authenticate()); // 0 = Fail, 1 = Pass
    }

?>