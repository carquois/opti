<?php
	
	$type_id = 0;
	$type_fr = "";
	$type_en = "";	
	
	// Get Organization types.
	$organization_types = new OrganizationTypes();
	$organization_types->LoadRecords();
	
	// Get Organization type.
	if(isset($_GET['orgtid']) && !empty($_GET['orgtid']))
	{	
		$organization_types->organization_type_id = $_GET['orgtid'];
		$type = $organization_types->GetOrganizationTypeRecord()[0];
		
		$type_id = $type['organization_type_id'];
		$type_fr = $type['organization_type_name_fr'];
		$type_en = $type['organization_type_name_en'];
	}

?>

<input type="button" class="btn btn-warning" value="<?php lang('Add organization type'); ?>" onclick="show_orgt_edit();">	

<br/>
<br/>
<div id="organization_types_section">
	<form action="" class="form-inline">
	
		<div class="form-group">
			<label class="sr-only" for="organization_type_name_fr"><?php lang('French'); ?></label>
			<input class="form-control" type="text" name="organization_type_name_fr" value="<?php if(!empty($type_fr)){echo($type_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>"/>
		</div>
		<div class="form-group">
			<label class="sr-only" for="organization_type_name_en"><?php lang('English'); ?></label>
			<input class="form-control" type="text" name="organization_type_name_en" value="<?php if(!empty($type_en)){echo($type_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>"/>
		</div>
		
		<?php if(empty($type_id)) { ?>
			<button class="btn btn-default" onclick="add_orgt_record();"><?php lang('Add'); ?></button>
		<?php } else { ?>
			<button class="btn btn-default" onclick="update_orgt_record(<?php echo($type_id); ?>)"><?php lang('Update'); ?></button>
		<?php } ?>
	
	</form>	
</div>

<hr/>

<?php if($organization_types->organization_types_records) {?>
	<table class="table table-striped" id="organization_types_datatable">
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
	        
	        <?php foreach($organization_types->organization_types_records as $organization_type){ ?>
		        <tr id="type_<?php echo($organization_type['organization_type_id']); ?>">
		        
		        	<td>
			        	<a onclick="edit_orgt_record(<?php echo($organization_type['organization_type_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
			        	<a onclick="delete_orgt_record(<?php echo($organization_type['organization_type_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		        	</td>
		            
		            <td><?php echo($organization_type['organization_type_name_fr']); ?></td>
		            <td><?php echo($organization_type['organization_type_name_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($organization_type['created_by_id'])); ?></td>
		            <td><?php echo($organization_type['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($organization_type['modified_by_id'])); ?></td>
		            <td><?php echo($organization_type['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script type="text/javascript">

	var $_GET = <?php echo(json_encode($_GET)); ?>;

	if($_GET['orgtid'] == null)
	{
		hide_orgt_edit();
	}
	else
	{
		show_orgt_edit();
	}	
	
	function add_orgt_record()
    {
		var params = { 
					   fr : $('input[name="organization_type_name_fr"]').val(),
				       en : $('input[name="organization_type_name_en"]').val()
					 }
	 
		$.post('../controllers/organization_types.php',params,function(){
		});

		location.reload();
    }

	function update_orgt_record(id)
    {
		var params = { 
					   id : id,
				   	   fr : $('input[name="organization_type_name_fr"]').val(),
				       en : $('input[name="organization_type_name_en"]').val()
					 }
	 
		$.post('../controllers/organization_types.php',params,function(){
		});

		location.reload();
    }
	
	function edit_orgt_record(id)
    {
		show_orgt_edit();
		
		window.location = "site_predefined_lists.php?orgtid="+id;
    }

       
        
    function delete_orgt_record(id)
    {  
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{                
	        if(result)
	        {
	            $.get('../controllers/organization_types.php?delete='+id);
	            hide_orgt_edit();
	            $('tr#type_'+id).remove();

	            location.reload();
	        }
    	});
    }

    function show_orgt_edit()
    {
		document.getElementById("organization_types_section").style.display = "block";
    }

    function hide_orgt_edit()
    {
    	document.getElementById("organization_types_section").style.display = "none";
    }
</script>


