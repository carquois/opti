<?php
	
	$service_id = 0;
	$service_fr = "";
	$service_en = "";
	
	// Get services.
	$services = new Services();
	$services->LoadRecords();
	
	// Get service.
	if(isset($_GET['serv']) && !empty($_GET['serv']))
	{
		$services->service_id = $_GET['serv'];
		$service = $services->GetServiceRecord()[0];
	
		$service_id = $service['service_id'];
		$service_fr = $service['service_name_fr'];
		$service_en = $service['service_name_en'];
	}

?>

<input type="button" class="btn btn-warning" value="<?php lang('Add service'); ?>" onclick="show_srv_edit();">

<br/>
<br/>
<div id="services_section">

<form action="" class="form-inline">
	<div class="form-group">
		<label class="sr-only" for="service_name_fr"><?php lang('French'); ?></label>
		<input class="form-control" type="text" name="service_name_fr" value="<?php if(!empty($service_fr)){echo($service_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>"/>
	</div>
	<div class="form-group">
		<label class="sr-only" for="service_name_en"><?php lang('English'); ?></label>
		<input class="form-control" type="text" name="service_name_en" value="<?php if(!empty($service_en)){echo($service_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>"/>
	</div>
	
	<?php if(empty($service_id)) { ?>
		<button class="btn btn-default" onclick="add_srv_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button class="btn btn-default" onclick="update_srv_record(<?php echo($service_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
</form>

	
</div>

<hr/>

<?php if($services->services_records) {?>
	<table class="table table-striped" id="services_datatable">
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
	        
	        <?php foreach($services->services_records as $service){ ?>
		        <tr id="service_<?php echo($service['service_id']); ?>">
		        
		        	<td>
		        		<a onclick="edit_srv_record(<?php echo($service['service_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
						<a onclick="delete_srv_record(<?php echo($service['service_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		            </td>
		            
		            <td><?php echo($service['service_name_fr']); ?></td>
		            <td><?php echo($service['service_name_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($service['created_by_id'])); ?></td>
		            <td><?php echo($service['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($service['modified_by_id'])); ?></td>
		            <td><?php echo($service['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>
	
	var $_GET = <?php echo(json_encode($_GET)); ?>;

	if($_GET['serv'] == null)
	{
		hide_srv_edit();
	}
	else
	{
		show_srv_edit();
	}	
	

	function add_srv_record()
    {
		var params = { name_fr : $('input[name="service_name_fr"]').val(),
				   	   name_en : $('input[name="service_name_en"]').val()
					 }
	
		$.post('../controllers/services.php',params,function(){
		});

		location.reload();
    }

	function update_srv_record(id)
    {
		var params = { 
					   id : id,
					   name_fr : $('input[name="service_name_fr"]').val(),
					   name_en : $('input[name="service_name_en"]').val()
					 }
	 
		$.post('../controllers/services.php',params,function(){
		});

		location.reload();
    }
	
	function edit_srv_record(id)
    {		
		show_srv_edit();
		
		window.location = "site_predefined_lists.php?serv="+id;
    }
    
        
    function delete_srv_record(id)
    {  
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{                
	        if(result)
	        {
	            $.get('../controllers/services.php?delete='+id);
	            hide_srv_edit();
	            $('tr#service_'+id).remove();

	            location.reload();
	        }
    	}); 
    }

    function show_srv_edit()
    {
    	document.getElementById("services_section").style.display = "block";
    }

    function hide_srv_edit()
    {
    	document.getElementById("services_section").style.display = "none";
    }
</script>



