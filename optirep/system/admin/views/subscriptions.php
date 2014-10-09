<?php
	
	$subs_id 	  = 0;
	$subs_name_fr = "";
	$subs_name_en = "";
	$subs_desc_fr = "";
	$subs_desc_en = "";
	
	// Get Subscriptions.
	$subscriptions = new Subscriptions();
	$subscriptions->LoadRecords();
	
	// Get Subscription.
	if(isset($_GET['subsid']) && !empty($_GET['subsid']))
	{
		$subscriptions->subscription_id = $_GET['subsid'];
		$subs = $subscriptions->GetSubscriptionRecord()[0];
	
		$subs_id 		= $subs['subscription_id'];
		$subs_name_fr 	= $subs['subscription_name_fr'];
		$subs_name_en 	= $subs['subscription_name_en'];
		$subs_desc_fr 	= $subs['subscription_desc_fr'];
		$subs_desc_en 	= $subs['subscription_desc_en'];
	}

?>

<input type="button" class="btn btn-warning" value="<?php lang('Add subscription'); ?>" onclick="show_subs_edit();">

<br/>
<br/>
<div id="subscriptions_section">

<form action="">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="subscription_name_fr"><?php lang('French'); ?></label>
				<input class="form-control" type="text" name="subscription_name_fr" value="<?php if(!empty($subs_name_fr)){echo($subs_name_fr);}else{echo("");}; ?>" placeholder="<?php lang('French'); ?>" />
			</div>
			<div class="form-group">
				<label for="subscription_desc_fr"><?php lang('French Description'); ?></label>
				<textarea class="form-control" rows="4" cols="50" name="subscription_desc_fr"><?php if(!empty($subs_desc_fr)){echo($subs_desc_fr);}else{echo("");}; ?></textarea>
			</div>
			
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="subscription_name_en"><?php lang('English'); ?></label>
				<input class="form-control" type="text" name="subscription_name_en" value="<?php if(!empty($subs_name_en)){echo($subs_name_en);}else{echo("");}; ?>" placeholder="<?php lang('English'); ?>" />
			</div>
			<div class="form-group">
				<label for="subscription_desc_en"><?php lang('English Description'); ?></label>
				<textarea class="form-control" rows="4" cols="50" name="subscription_desc_en"><?php if(!empty($subs_desc_en)){echo($subs_desc_en);}else{echo("");}; ?></textarea>
			</div>
			
		</div>
	</div>
	
	<?php if(empty($subs_id)) { ?>
		<button class="btn btn-default" onclick="add_subs_record();"><?php lang('Add'); ?></button>
	<?php } else { ?>
		<button class="btn btn-default" onclick="update_subs_record(<?php echo($subs_id); ?>)"><?php lang('Update'); ?></button>
	<?php } ?>
</form>

	
</div>

<hr/>

<?php if($subscriptions->subscriptions_records) {?>
	<table class="table table-striped" id="subscriptions_datatable">
	    <thead>
	        <tr>
	            <th><?php lang('Actions'); ?></th>
	            
	            <th><?php lang('French'); ?></th>
	            <th><?php lang('English'); ?></th>
	            <th><?php lang('French Desc'); ?></th>
	            <th><?php lang('English Desc'); ?></th>
	            <th><?php lang('Created by'); ?></th>
	            <th><?php lang('Creation date'); ?></th>
	            <th><?php lang('Modified by'); ?></th>
	            <th><?php lang('Modification date'); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	        
	        <?php foreach($subscriptions->subscriptions_records as $subscription){ ?>
		        <tr id="subscription_<?php echo($subscription['subscription_id']); ?>">
		        
		        	<td>
		        		<a onclick="edit_subs_record(<?php echo($subscription['subscription_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
						<a onclick="delete_subs_record(<?php echo($subscription['subscription_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
		            </td>
		            
		            <td><?php echo($subscription['subscription_name_fr']); ?></td>
		            <td><?php echo($subscription['subscription_name_en']); ?></td>
		            <td><?php echo($subscription['subscription_desc_fr']); ?></td>
		            <td><?php echo($subscription['subscription_desc_en']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($subscription['created_by_id'])); ?></td>
		            <td><?php echo($subscription['created_date']); ?></td>
		            <td><?php echo(cmnGetUserNameByID($subscription['modified_by_id'])); ?></td>
		            <td><?php echo($subscription['modified_date']); ?></td>
		            
		            
		        </tr>
	        <?php } ?>
		    
	    </tbody>
	</table>
<?php } ?>

<hr/>

<script>


	var $_GET = <?php echo(json_encode($_GET)); ?>;
	
	if($_GET['subsid'] == null)
	{
		hide_subs_edit();
	}
	else
	{
		show_subs_edit();
	}
		
	
	function add_subs_record()
    {
		var params = { 
					   name_fr : $('input[name="subscription_name_fr"]').val(),
				   	   name_en : $('input[name="subscription_name_en"]').val(),
				       desc_fr : $('textarea[name="subscription_desc_fr"]').val(),
				       desc_en : $('textarea[name="subscription_desc_en"]').val()
					 }
	
		$.post('../controllers/subscriptions.php',params,function(){
		});

		location.reload();
    }

	function update_subs_record(id)
    {
		var params = { 
					   id : id,
					   name_fr : $('input[name="subscription_name_fr"]').val(),
				   	   name_en : $('input[name="subscription_name_en"]').val(),
				       desc_fr : $('textarea[name="subscription_desc_fr"]').val(),
				       desc_en : $('textarea[name="subscription_desc_en"]').val()
					 }
	 
		$.post('../controllers/subscriptions.php',params,function(){
		});

		location.reload();
    }

    
	function edit_subs_record(id)
    {		
		show_subs_edit();
		
		window.location = "site_predefined_lists.php?subsid="+id;
    }

       
        
    function delete_subs_record(id)
    {  
    	BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
    	{       
    		if(result)
	        {
	            $.get('../controllers/subscriptions.php?delete='+id);
	            hide_subs_edit();
	            $('tr#subscription_'+id).remove();

	            location.reload();
	        }
    	});
    }

    function show_subs_edit()
    {
    	document.getElementById("subscriptions_section").style.display = "block";
    }

    function hide_subs_edit()
    {
    	document.getElementById("subscriptions_section").style.display = "none";
    }
</script>



