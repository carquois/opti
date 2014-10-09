<?php

	$type_id = 0;
	$type_fr = "";
	$type_en = "";
	
	// Get Professional types.
	$professional_types = new ProfessionalTypes();
	$professional_types->LoadRecords();
	
	// Get Professional type.
	if(isset($_GET['protid']) && !empty($_GET['protid']))
	{
		$professional_types->professional_type_id = $_GET['protid'];
		$type = $professional_types->GetProfessionalTypeRecord()[0];
	
		$type_id = $type['professional_type_id'];
		$type_fr = $type['professional_type_name_fr'];
		$type_en = $type['professional_type_name_en'];
	}
?>

<input type="button" class="btn btn-warning" value="<?php lang('Add professional type'); ?>" onclick="show_prot_edit();">

<br/>
<br/>
<div id="professional_types_section">
<form action="" class="form-inline">
	<div class="form-group">
		<label class="sr-only" for="professional_type_name_fr"><?php lang('French'); ?></label>
		<input class="form-control" type="text" name="professional_type_name_fr" value="<?php if(!empty($type_fr)){echo($type_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>"/>
	</div>
	<div class="form-group">
		<label class="sr-only" for="professional_type_name_en"><?php lang('English'); ?></label>
		<input class="form-control" type="text" name="professional_type_name_en" value="<?php if(!empty($type_en)){echo($type_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>"/>
	</div>
	<?php if(empty($type_id)) { ?>
			<button class="btn btn-default" onclick="add_prot_record();"><?php lang('Add'); ?></button>
		<?php } else { ?>
			<button class="btn btn-default" onclick="update_prot_record(<?php echo($type_id); ?>)"><?php lang('Update'); ?></button>
		<?php } ?>
</form>
	
	
	
</div>

<hr/>

<?php if($professional_types->professional_types_records) {?>
	<table class="table table-striped" id="professional_types_datatable">
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
	        
	        <?php foreach($professional_types->professional_types_records as $professional_type){ ?>
		        <tr id="type_<?php echo($professional_type['professional_type_id']); ?>">
		        
		        	<td>
			        	<a onclick="edit_prot_record(<?php echo($professional_type['professional_type_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
			            <a onclick="delete_prot_record(<?php echo($professional_type['professional_type_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		            </td>
		            
		            <td><?php echo($professional_type['professional_type_name_fr']); ?></td>
		            <td><?php echo($professional_type['professional_type_name_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($professional_type['created_by_id'])); ?></td>
		            <td><?php echo($professional_type['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($professional_type['modified_by_id'])); ?></td>
		            <td><?php echo($professional_type['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>


	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['protid'] == null)
	{
		hide_prot_edit();
	}
	else
	{
		show_prot_edit();
	}
		

	function add_prot_record()
    {
		var params = { fr : $('input[name="professional_type_name_fr"]').val(),
				       en : $('input[name="professional_type_name_en"]').val()
					 }
	 
		$.post('../controllers/professional_types.php',params,function(){
		});

		location.reload();
    }
    
	function update_prot_record(id)
    {
		var params = { 
					   id : id,
				   	   fr : $('input[name="professional_type_name_fr"]').val(),
				       en : $('input[name="professional_type_name_en"]').val()
					 }
	 
		$.post('../controllers/professional_types.php',params,function(){
		});

		location.reload();
    }
    
	
	function edit_prot_record(id)
    {		
		show_prot_edit();
		
		window.location = "site_predefined_lists.php?protid="+id;
    }       
        
    function delete_prot_record(id)
    { 
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{            
	        if(result)
	        {
	            $.get('../controllers/professional_types.php?delete='+id);
	            hide_prot_edit();
	            $('tr#type_'+id).remove();

	            location.reload();
	        }
    	}); 
    }

    function show_prot_edit()
    {
    	document.getElementById("professional_types_section").style.display = "block";
    }

    function hide_prot_edit()
    {
    	document.getElementById("professional_types_section").style.display = "none";
    }
</script>


