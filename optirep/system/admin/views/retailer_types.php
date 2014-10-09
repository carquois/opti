<?php
	
	$type_id = 0;
	$type_fr = "";
	$type_en = "";	
	
	// Get Retailer types.
	$retailer_types = new RetailerTypes();
	$retailer_types->LoadRecords();
	
	// Get Retailer type.
	if(isset($_GET['rettid']) && !empty($_GET['rettid']))
	{	
		$retailer_types->retailer_type_id = $_GET['rettid'];
		$type = $retailer_types->GetRetailerTypeRecord()[0];
		
		$type_id = $type['retailer_type_id'];
		$type_fr = $type['retailer_type_name_fr'];
		$type_en = $type['retailer_type_name_en'];
	}
?>

<input type="button" class="btn btn-warning" value="<?php lang('Add retailer type'); ?>" onclick="show_rett_edit();">

<br/>
<br/>
<div id="retailer_types_section">

<form action="" class="form-inline">
	<div class="form-group">
		<label class="sr-only" for="retailer_type_name_fr"><?php lang('French'); ?></label>
		<input class="form-control" type="text" name="retailer_type_name_fr" value="<?php if(!empty($type_fr)){echo($type_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>"/>
	</div>
	<div class="form-group">
		<label class="sr-only" for="retailer_type_name_en"><?php lang('English'); ?></label>
		<input class="form-control" type="text" name="retailer_type_name_en" value="<?php if(!empty($type_en)){echo($type_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>"/>
	</div>
	
	<?php if(empty($type_id)) { ?>
		<button class="btn btn-default" onclick="add_rett_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button class="btn btn-default" onclick="update_rett_record(<?php echo($type_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
</form>

	
</div>

<hr/>

<?php if($retailer_types->retailer_types_records) {?>
	<table class="table table-striped" id="retailer_types_datatable">
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
	        
	        <?php foreach($retailer_types->retailer_types_records as $retailer_type){ ?>
		        <tr valign="top" id="type_<?php echo($retailer_type['retailer_type_id']); ?>">
		        
		        	<td>
		        		<a onclick="edit_rett_record(<?php echo($retailer_type['retailer_type_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
						<a onclick="delete_rett_record(<?php echo($retailer_type['retailer_type_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		            </td>
		            
		            <td><?php echo($retailer_type['retailer_type_name_fr']); ?></td>
		            <td><?php echo($retailer_type['retailer_type_name_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($retailer_type['created_by_id'])); ?></td>
		            <td><?php echo($retailer_type['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($retailer_type['modified_by_id'])); ?></td>
		            <td><?php echo($retailer_type['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>


	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['rettid'] == null)
	{
		hide_rett_edit();
	}
	else
	{
		show_rett_edit();
	}
		

	function add_rett_record()
    {
		var params = { fr : $('input[name="retailer_type_name_fr"]').val(),
					   en : $('input[name="retailer_type_name_en"]').val()
					 }
	 
		$.post('../controllers/retailer_types.php',params,function(){
		});

		location.reload();
    }

	function update_rett_record(id)
    {
		var params = { 
					   id : id,
				   	   fr : $('input[name="retailer_type_name_fr"]').val(),
				       en : $('input[name="retailer_type_name_en"]').val()
					 }
	 
		$.post('../controllers/retailer_types.php',params,function(){
		});

		location.reload();
    }
	
    function edit_rett_record(id)
    {		
		show_rett_edit();
		
		window.location = "site_predefined_lists.php?rettid="+id;
    }
       
        
    function delete_rett_record(id)
    {  
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{                
	        if(result)
	        {
	            $.get('../controllers/retailer_types.php?delete='+id);
	            hide_rett_edit();
	            $('tr#type_'+id).remove();

	            location.reload();
	        }
    	});
    }

    function show_rett_edit()
    {
    	document.getElementById("retailer_types_section").style.display = "block";
    }

    function hide_rett_edit()
    {
    	document.getElementById("retailer_types_section").style.display = "none";
    }
</script>


