    //////////////////////////////////////////////////////////////////
    // INIT
    //////////////////////////////////////////////////////////////////
    $(function(){
    	$('input[name="user_login"]').focusout(function(){
	    	checkUniqueLogin($('input[name="form_user"]').val(), $('input[name="user_login"]').val());
	    	
	    });
	});
    
    $(function(){
    	$('input[name="user_login"]').focus(function(){
	    	$('#msg').html('');
	    	$('#msg').removeClass('alert alert-danger');
	    });
	});
    
        
    //////////////////////////////////////////////////////////////////
    // CHECK PASSWORD STRENGTH
    //////////////////////////////////////////////////////////////////
    function validateUserEntry()
    {
    	//alert("IN JS!");
    	
    	var id  = $('input[name="form_user"]').val();
    	var ul  = $('input[name="user_login"]').val();
        var ut  = $('select[name="type_selection"]').val();
        var up  = $('input[name="user_password"]').val();
        var up2 = $('input[name="user_password2"]').val();
        
        alert(id + '\n' + ul + '\n' + ut + '\n' + up + '\n' + up2);
        
        
        if(up != up2)
        {        	
        	
        	/*$.get('/system/helpers/js_lang.php?t='+escape('Passwords Do Not Match'),function(data){ 
        		errormsg.show(data);
        	});*/
        	
            return false;
        }
        else if(!checkPassStrength())
        {
        	/*$.get('/system/helpers/js_lang.php?t='+escape('Password Minimum Of 8 Characters'),function(data){            		
    			errormsg.show(data);
        	});*/
        	
            return false;
        }
        else if(ul == "")
        {
        	/*$.get('/system/helpers/js_lang.php?t='+escape('Username is Required'),function(data){            		
    			errormsg.show(data);
        	});*/
        	        	
            return false;
        }
        else if(ut <= 0)
        {
        	/*$.get('/system/helpers/js_lang.php?t='+escape('User Type is required'),function(data){            		
    			errormsg.show(data);
        	});*/
        	
            return false;
        }
        
        return true;
    
    }
    
    //////////////////////////////////////////////////////////////////
    // CHECK PASSWORD STRENGTH
    //////////////////////////////////////////////////////////////////
    function checkPassStrength()
    {
        var p1 = $('input[name="user_password"]').val();

        if(p1.length < 8)
        { 
            return false;
        }
        else
        { 
            return true;
        }
    }
    
    //////////////////////////////////////////////////////////////////
    // CHECK UNIQUE USER LOGIN
    //////////////////////////////////////////////////////////////////
    function checkUniqueLogin(id,ul)
    {
        var params = { 
			            i : id,
			            l : ul
			         }

        $.post('../../admin/controllers/users.php?checklogin=t',params,function(data)
        {
        	if(data==1)
            {        		
        		$('#msg').addClass('alert alert-danger');
        		$.get('/system/helpers/js_lang.php?t='+escape('Username Already In Use'),function(data){
        			errormsg.show(data);
                });            	
            	
                $('#btn_save, #btn_update').attr('disabled', 'disabled').addClass('disabled');
                
	    	
                return false;
            }
            else
            {
                $('#msg').removeClass('alert alert-danger');
                errormsg.hide();
                $('#btn_save, #btn_update').removeAttr('disabled').removeClass('disabled');
                
				
                return true;
            }
        });
    }
    
    