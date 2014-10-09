
<?php 
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	
?>

		
    <form class="form" method="post" action="" onsubmit="return false;">
	    <span id="adm_error"></span>
	    
	    <div class="form-group">
	    	<label for="login"><?php lang('Username'); ?></label>
	    	<input class="form-control" value="" name="login" type="text" />
	    </div>
	    
	    <div class="form-group">
	    	<label for="password"><?php lang('Password'); ?></label>
	    	<input class="form-control" value="" name="password" type="password" />
	    </div>
	    
	    <button class="btn btn-primary" onclick="processAuth();" id="adm_btn_login"><?php lang('Login'); ?></button>
    </form>
		

<script>
    $(function(){
        
        // Check for previous credentials in localStorage
        if(localStorage.getItem("username") !== null)
        {
            $('input[name="login"]').val(localStorage.getItem("username"));
            $('input[name="password"]').val('').focus();
        }
        
        // Clear LocalStorage
        localStorage.clear();
        
        $('input[name="login"], input[name="password"]').keypress(function(e)
        {
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13)
            {
               processAuth();
            }
        });
        
        $('input[name="login"], input[name="password"]').focus(function()
        {
            this.select();
        });
    });
    
    function processAuth()
    {
        // Get Values
        var login = $('input[name="login"]').val();
        var password = $('input[name="password"]').val();
        
        // Post
        $.post('system/admin/controllers/login.php',
               { l : login, p : password },
               function(data){
                   if(data==0)
                   {
                       errormsg.show('<?php lang('Failed Login Attempt'); ?>');
                       $('input[name="login"]').focus();
                   }
                   else
                   {
                       localStorage.username = login;
                       url.refresh();
                   }
               }
        );
    }
</script>

