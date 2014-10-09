<?php 

	$type_id = 0;
	$type_fr = "";
	$type_en = "";

	// Get Supplier types.
	$supplier_types = new SupplierTypes();
	$supplier_types->LoadRecords();
	
	// Get Supplier type.
	if(isset($_GET['suptid']) && !empty($_GET['suptid']))
	{
		$supplier_types->supplier_type_id = $_GET['suptid'];
		$type = $supplier_types->GetSupplierTypeRecord()[0];
	
		$type_id = $type['supplier_type_id'];
		$type_fr = $type['supplier_type_name_fr'];
		$type_en = $type['supplier_type_name_en'];
	}
		
?>

<input type="button" class="btn btn-warning" value="<?php lang('Add supplier type'); ?>" onclick="show_supt_edit();">

<br/>
<br/>
<div id="supplier_types_section">

<form action="" class="form-inline">
	<div class="form-group">
		<label class="sr-only" for="supplier_type_name_fr"><?php lang('French'); ?></label>
		<input class="form-control" type="text" name="supplier_type_name_fr" value="<?php if(!empty($type_fr)){echo($type_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>"/>
	</div>
	<div class="form-group">
		<label class="sr-only" for="supplier_type_name_en"><?php lang('English'); ?></label>
		<input class="form-control" type="text" name="supplier_type_name_en" value="<?php if(!empty($type_en)){echo($type_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>"/>
	</div>
	
	<?php if(empty($type_id)) { ?>
		<button class="btn btn-default" onclick="add_supt_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button class="btn btn-default" onclick="update_supt_record(<?php echo($type_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
</form>

</div>

<hr/>

<?php if($supplier_types->supplier_types_records) {?>
	<table class="table table-striped" id="supplier_types_datatable">
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
	        
	        <?php foreach($supplier_types->supplier_types_records as $supplier_type){ ?>
		        <tr id="type_<?php echo($supplier_type['supplier_type_id']); ?>">
		        
		        	<td>
		        		<a onclick="edit_supt_record(<?php echo($supplier_type['supplier_type_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
						<a onclick="delete_supt_record(<?php echo($supplier_type['supplier_type_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		            </td>
		            
		            <td><?php echo($supplier_type['supplier_type_name_fr']); ?></td>
		            <td><?php echo($supplier_type['supplier_type_name_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($supplier_type['created_by_id'])); ?></td>
		            <td><?php echo($supplier_type['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($supplier_type['modified_by_id'])); ?></td>
		            <td><?php echo($supplier_type['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>


	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['suptid'] == null)
	{
		hide_supt_edit();
	}
	else
	{
		show_supt_edit();
	}
		
	
	function add_supt_record()
    {
		var params = { 
					   fr : $('input[name="supplier_type_name_fr"]').val(),
				       en : $('input[name="supplier_type_name_en"]').val()
					 }	 
		
		$.post('../controllers/supplier_types.php',params,function(data){
			alert(data);			
		});
		
		location.reload();
    }
    
	function update_supt_record(id)
    {
		var params = { 
					   id : id,
				   	   fr : $('input[name="supplier_type_name_fr"]').val(),
				       en : $('input[name="supplier_type_name_en"]').val()
					 }
	 
		$.post('../controllers/supplier_types.php',params,function(){
		});

		location.reload();
    }
	
	function edit_supt_record(id)
    {
		show_supt_edit();
		
		window.location = "site_predefined_lists.php?suptid="+id;
    }

            
    function delete_supt_record(id)
    {  
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{       
	        if(result)
	        {
	            $.get('../controllers/supplier_types.php?delete='+id);
	            hide_supt_edit();
	            $('tr#type_'+id).remove();

	            location.reload();
	        }
    	});
    }

    function show_supt_edit()
    {
    	document.getElementById("supplier_types_section").style.display = "block";
    }

    function hide_supt_edit()
    {
    	document.getElementById("supplier_types_section").style.display = "none";
    }
</script>


