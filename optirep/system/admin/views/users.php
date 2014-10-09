<?php 

	$usr_id 		= 0;
	$usr_type_id 	= 0;
	$usr_login 		= "";
	$usr_pwd 		= "";
	
	// Get Users.
	$users = new User();
	$users->LoadRecords();
	
	// Get User.
	if(isset($_GET['usrid']) && !empty($_GET['usrid']))
	{
		$users->user_id = $_GET['usrid'];
		$usr = $users->GetUserRecord()[0];
	
		$usr_id = $usr['user_id'];
		$usr_type_id = $usr['user_type_id'];
		$usr_login = $usr['user_login'];
		$usr_pwd = $usr['user_password'];	
		
	}
	
?>


<input id="cur_user" type="hidden" value="<?php echo('2'); ?>" /> <!-- echo($_SESSION['admin']); -->
<input id="form_user" name="form_user" type="hidden" value="<?php echo($usr_id); ?>" />

<input type="button" class="btn btn-warning" value="<?php lang('Add new user'); ?>" onclick="show_user_edit();">
<br/>
<br/>

<div id="users_section">

<form action="" class="form">	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">		
			<label for="user_login"><?php lang('Username'); ?></label>
			<input class="form-control" type="text" name="user_login" value="<?php if(!empty($usr_login)){echo($usr_login);}else{echo("");}; ?>"/>
		</div>
		
		<div class="form-group">	
			<label for="type_selection"><?php lang('User Type'); ?></label>		
			<select name="type_selection" class="form-control">
				<?php if($usr_type_id == 0){?>
					<option value="" selected="selected"><?php lang('Please select type'); ?></option>
				<?php } ?>
				<?php foreach(cmnGetUserTypesList()->user_types_list as $user_type){ ?>
					<?php if($user_type['user_type_id'] != '1'){ ?> <!-- 1 = SUPERADMIN -->
						<option <?php if( $user_type['user_type_id'] == $usr_type_id ){ echo("selected='selected'"); } ?> value="<?php echo $user_type['user_type_id'] ?>"><?php echo $user_type['user_type_name'] ?></option>
					<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">	
			<label for="user_password"><?php lang('Password'); ?></label>		
			<input class="form-control" type="password" name="user_password" value="<?php if(!empty($usr_pwd)){echo($usr_pwd);}else{echo("");}; ?>"/>
		</div>
		
		<div class="form-group">	
			<label for="user_password2"><?php lang('Verify Password'); ?></label>		
			<input class="form-control" type="password" name="user_password2" value="<?php if(!empty($usr_pwd)){echo($usr_pwd);}else{echo("");}; ?>"/>
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div id="msg" class=""></div>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12">
	<?php if(empty($usr_id)) { ?>
		<button id="btn_save" class="btn btn-default" onclick="add_user_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button id="btn_update" class="btn btn-default" onclick="update_user_record(<?php echo($usr_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
	</div>
	</div>
</form>

	
</div>

<hr/>

<?php if($users->admin_users_records) {?>
	<table class="table table-striped" id="users_datatable">
	    <thead>
	        <tr>
	            <th><?php lang('Actions'); ?></th>
	            
	            <th><?php lang('Username'); ?></th>
	            <th><?php lang('User Type'); ?></th>
	            <th><?php lang('Created by'); ?></th>
	            <th><?php lang('Creation date'); ?></th>
	            <th><?php lang('Modified by'); ?></th>
	            <th><?php lang('Modification date'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	        
	        <?php foreach($users->admin_users_records as $user){ ?>
		        <?php if($user['user_id'] != '1'){ ?> <!-- 1 = SUPERADMIN -->
			        <tr id="user_<?php echo($user['user_id']); ?>">			        
			        	<td>
			        		<a onclick="edit_user_record(<?php echo($user['user_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
							<a onclick="delete_user_record(<?php echo($user['user_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
			            </td>
			            
			            <td><?php echo($user['user_login']); ?></td>
			            <td><?php echo(cmnGetUserTypeNameByID($user['user_type_id'])); ?></td>
			            <td><?php echo(cmnGetUserNameByID($user['created_by_id'])); ?></td>
			            <td><?php echo($user['created_date']); ?></td>
			            <td><?php echo(cmnGetUserNameByID($user['modified_by_id'])); ?></td>
			            <td><?php echo($user['modified_date']); ?></td>
			        </tr>
			    <?php } ?>
	        <?php } ?>		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>

	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['usrid'] == null)
	{
		hide_user_edit();
	}
	else
	{
		show_user_edit();
	}	

	function add_user_record()	
    {
		var result = validateUserEntry();

		if(result == true)
        {
			var params = { 
						   ut : $('select[name="type_selection"]').val(),
					   	   ul : $('input[name="user_login"]').val(),
						   up : $('input[name="user_password"]').val()
						 }
		 
			$.post('../controllers/users.php',params,function(){
			});

			location.reload();
        }
    }

	function update_user_record(id)
    {
		//alert(id + '\n' + $('select[name="type_selection"]').val() + '\n' + $('input[name="user_login"]').val() + '\n' + $('input[name="user_password"]').val());

		var params = { 
					   id : id,
					   ut : $('select[name="type_selection"]').val(),
					   ul : $('input[name="user_login"]').val(),					   
					   up : $('input[name="user_password"]').val()
					 }
	 
		$.post('../controllers/users.php',params,function(){
		});

		location.reload();
    }
	
    function edit_user_record(id)
    {		
    	show_user_edit();
		
		window.location = "site_configuration.php?usrid="+id;
    }

       
        
    function delete_user_record(id)
    {         
    	var count = $('.users_datatable tr').length;
    	        
    	if(count==1)
     	{
    		BootstrapDialog.alert("<?php lang('You must have at least one user in the system'); ?>");
    	}
    	else
      	{
    		if($('#cur_user').val()==id)
        	{
    			BootstrapDialog.alert("<?php lang('You are currently logged in as this user. It cannot be deleted.'); ?>");
    	    }
    	    else
        	{
    	    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	    	{       
	    	        if(result)
	    	        {
	    	        	$.get('../controllers/users.php?delete='+id);
	    	        	hide_user_edit();
	    	            $('tr#user_'+id).remove();

	    	            location.reload();    	            
	    	        }
    	    	});
    	    }
    	}
    }

    function show_user_edit()
    {
    	document.getElementById("users_section").style.display = "block";
    }

    function hide_user_edit()
    {
    	document.getElementById("users_section").style.display = "none";
    }
    
</script>
