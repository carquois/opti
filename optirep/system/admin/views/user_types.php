<?php
	
	$type_id = 0;
	$type_fr = "";
	$type_en = "";
	
	// Get User types.
	$user_types = new UserTypes();
	$user_types->LoadRecords();
	
	// Get User type.
	if(isset($_GET['usrtid']) && !empty($_GET['usrtid']))
	{
		$user_types->user_type_id = $_GET['usrtid'];
		$type = $user_types->GetUserTypeRecord()[0];
	
		$type_id = $type['user_type_id'];
		$type_fr = $type['user_type_name_fr'];
		$type_en = $type['user_type_name_en'];
	}
	
?>

<input id="cur_user_type" type="hidden" value="<?php echo('2'); ?>" /> <!-- echo($_SESSION['admin']); -->

<input class="btn btn-warning" type="button" value="<?php lang('Add user type'); ?>" onclick="show_usrt_edit();">

<br/>
<br/>
<div id="user_types_section">

<form action="" class="form-inline">
	<div class="form-group">
		<label for="user_type_name_fr"><?php lang('French'); ?></label>
		<input class="form-control" type="text" name="user_type_name_fr" value="<?php if(!empty($type_fr)){echo($type_fr);}else{echo("");}; ?>"/>
	</div>
	<div class="form-group">
		<label for="user_type_name_en"><?php lang('English'); ?></label>
		<input class="form-control" type="text" name="user_type_name_en" value="<?php if(!empty($type_en)){echo($type_en);}else{echo("");}; ?>"/>
	</div>
	
	<?php if(empty($type_id)) { ?>
		<button class="btn btn-default" onclick="add_usrt_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button class="btn btn-default" onclick="update_usrt_record(<?php echo($type_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
</form>

	
</div>

<hr/>

<?php if($user_types->user_types_records) {?>
	<table class="table table-striped" id="user_types_datatable">
	    <thead>
	        <tr>
	            <th><?php lang('Actions'); ?></th>
	            
	            <th><?php lang('French'); ?></th>
	            <th><?php lang('English'); ?></th>
	            <th><?php lang('Created by'); ?></th>
	            <th><?php lang('Creation date'); ?></th>
	            <th><?php lang('Modified by'); ?></th>
	            <th><?php lang('Modification date'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	        
	        <?php foreach($user_types->user_types_records as $user_type){ ?>
	        	<?php if($user_type['user_type_id'] != '1'){ ?> <!-- 1 = SUPERADMIN -->
			        <tr id="type_<?php echo($user_type['user_type_id']); ?>">
			        
			        	<td>
			        		<a onclick="edit_usrt_record(<?php echo($user_type['user_type_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
			            	<a onclick="delete_usrt_record(<?php echo($user_type['user_type_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
			            </td>
			            
			            <td><?php echo($user_type['user_type_name_fr']); ?></td>
			            <td><?php echo($user_type['user_type_name_en']); ?></td>
			            <td><?php echo(cmnGetUserNameByID($user_type['created_by_id'])); ?></td>
			            <td><?php echo($user_type['created_date']); ?></td>
			            <td><?php echo(cmnGetUserNameByID($user_type['modified_by_id'])); ?></td>
			            <td><?php echo($user_type['modified_date']); ?></td>
			        </tr>
			    <?php } ?>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>


	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['usrtid'] == null)
	{
		hide_usrt_edit();
	}
	else
	{
		show_usrt_edit();
	}
		
	
	function add_usrt_record()
    {
		var params = { 
					   fr : $('input[name="user_type_name_fr"]').val(),
				       en : $('input[name="user_type_name_en"]').val()
					 }
	 
		$.post('../controllers/user_types.php',params,function(){
		});

		location.reload();
    }

	function update_usrt_record(id)
    {
		var params = { 
					   id : id,
				   	   fr : $('input[name="user_type_name_fr"]').val(),
				       en : $('input[name="user_type_name_en"]').val()
					 }
	 
		$.post('../controllers//user_types.php',params,function(){
		});

		location.reload();
    }
    
	
	function edit_usrt_record(id)
    {
		show_usrt_edit();
			
		window.location = "site_configuration.php?usrtid="+id;
    }

            
    function delete_usrt_record(id)
    {         
    	var count = $('.user_types_datatable tr').length;
    	        
    	if(count==1)
     	{
    		BootstrapDialog.alert("<?php lang('You must have at least one user type in the system'); ?>");
    	}
    	else
      	{
    		if($('#cur_user_type').val()==id)
        	{
    			BootstrapDialog.alert("<?php lang('You are currently logged in using this user type. It cannot be deleted.'); ?>");
    	    }
    	    else
        	{
    	    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	    	{      
	    	        if(result)
	    	        {
	    	        	$.get('../controllers/user_types.php?delete='+id);
	    	        	hide_usrt_edit();
	    	            $('tr#type_'+id).remove();

	    	            location.reload();
	    	        }
    	    	});
    	    }
    	}
    }
    

    function show_usrt_edit()
    {
    	document.getElementById("user_types_section").style.display = "block";
    }

    function hide_usrt_edit()
    {
    	document.getElementById("user_types_section").style.display = "none";
    }
</script>


