<?php

	include_once("../header.php");
	
	
	$upload_result = 0;
	
	$success_message 	= "";
	$warning_message	= "";
	$error_message 		= "";
	$csv_filename 		= "";

	if(isset($_FILES["file"]))
	{		
		if(in_array($_FILES["file"]["name"], $cmn_cfg_accepted_import_files_array))
		{	
			if ($_FILES["file"]["error"] > 0)
			{
				$error_message = $_FILES["file"]["error"];
			}
			else
			{
				$upload_result = move_uploaded_file($_FILES["file"]["tmp_name"], IMPORT_FOLDER . "/" . $_FILES["file"]["name"]);
				
				if($upload_result)
				{
					$csv_filename    = $_FILES["file"]["name"];						
					$success_message = "<b>" . $csv_filename . "</b>" . " " . $lang['has been successfully uploaded and is now ready for import'];
				}
				else
				{
					$error_message = $lang['Unable to upload file'];
				}
			}
			
		}
		else
		{
			$error_message = "<b>" . $_FILES["file"]["name"] . "</b><BR/><BR/>" . $lang['Invalide file name'] . ":<BR/><BR/>";
			
			foreach($cmn_cfg_accepted_import_files_array as $cfg_key => $filename)
			{
				$error_message .= "<ul><li><b>" . $filename . "</b></li></ul>";
			}			
		}
	}

?>
<style>

.six-sec-ease-in-out {
    -webkit-transition: width 6s ease-in-out;
    -moz-transition: width 6s ease-in-out;
    -ms-transition: width 6s ease-in-out;
    -o-transition: width 6s ease-in-out;
    transition: width 6s ease-in-out;
}


</style>

<div>	
	<form method="post" enctype="multipart/form-data">
		<div class="form-group">	
	    	<label for="file"><?php lang('Select .csv file to import'); ?></label>		   
	    	<div class="input-group">
	        	<span class="input-group-btn">
	            	<span class="btn btn-primary btn-file">
	            	    <?php lang('Select'); ?>&hellip;
	           	     <input type="file" id="file" name="file">
	           		</span>
	       	 	</span>
	        	<input type="text" id="file_path" class="form-control" readonly>
	    	</div>
	    	<?php 
	    		$lastElement = end($cmn_cfg_accepted_import_files_array);
	    		echo("<i>");
	    		echo("<b>");
	    		echo(lang('Accepted files') . ": ");
	    		echo("</b>");
	    		foreach($cmn_cfg_accepted_import_files_array as $key=>$accepted_files)
			    {	
			    	echo($accepted_files . ($lastElement===$accepted_files ? '' : ', '));			        		
			    }
			    echo("</i>");
	        ?>		    
	    </div>
	    <div>
		    <input type="submit" class="btn btn-warning" value="<?php lang('Upload file'); ?>" />
		    <input type="button" id="import_button" class="btn btn-success" onclick="import_to_database()" value="<?php lang('Import to database'); ?>" disabled />

<!-- 		    <div class="progress"> -->
<!-- 			    <div class="progress-bar six-sec-ease-in-out" role="progressbar" data-transitiongoal="9000" aria-valuenow="" aria-valuemin="0" aria-valuemax="9000"></div> -->
<!-- 			</div> -->
		    
		</div>    
	</form>
	
</div>

<?php include_once("../footer.php"); ?>

<script>

	$(window).load(function() {
				
// 		$('.progress .progress-bar').progressbar({
// 													display_text: 'center',
// 													use_percentage: false,
// 													amount_format: function(p, t) {return p + ' of ' + t;}
// 		});
				
	});


	function updateProgress($current)
	{
		$('.progress .progress-bar').progressbar({
					display_text: 'center',
					use_percentage: false,
					amount_format: function(p, t) {return p + ' of ' + t;}
		});

		$(".progress-bar").attr("aria-valuenow", $current);
	}

	var upload_result 	= <?php echo($upload_result); ?>;
	var success_message = "<?php if(!empty($success_message)){echo($success_message);}else{echo("");} ?>";
	var warning_message = "<?php if(!empty($warning_message)){echo($warning_message);}else{echo("");} ?>";
	var error_message 	= "<?php if(!empty($error_message)){echo($error_message);}else{echo("");} ?>";
	var csv_filename 	= "<?php if(!empty($csv_filename)){echo($csv_filename);}else{echo("");} ?>";
	
	$('#file').change(function ()
	{
		for (var i = 0; i < this.files.length; i++)
		{
			$('#file_path').val(this.files.item(i).name);			
		}

		$('#progressbar').progressbar('stepIt');
	})	
	

	if((upload_result == 0) && (error_message != ""))
	{
		BootstrapDialog.alert({
	        title: "<?php lang('Error'); ?>",
	        message: error_message,
	        type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
	        closable: true,
	    });
	}
	else if(upload_result == 1)
	{
		BootstrapDialog.alert({
	        title: "<?php lang('File upload'); ?>",
	        message: success_message,
	        type: BootstrapDialog.TYPE_SUCCESS, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
	        closable: true,
	    });

	    $('#import_button').prop('disabled',false);
	    	    
	}

	function import_to_database()
	{	
		var params = { csv : csv_filename }

		$.post('batch_csv_import.php?batch=',params,function(data, status){

			var result = data.trim();

			if(result == 'true')
			{
				BootstrapDialog.alert({
			        title: "<?php lang('Import'); ?>",
			        message: "<b>" + csv_filename + "</b>" + " " + "<?php lang('has been successfully imported'); ?>",
			        type: BootstrapDialog.TYPE_SUCCESS, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
			        closable: true,
			    });
			}
			else if(result == 2)
			{
				BootstrapDialog.alert({
			        title: "<?php lang('Warning'); ?>",
			        message: "<?php lang('Warning'); ?>",
			        type: BootstrapDialog.TYPE_WARNING, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
			        closable: true,
			    });
			}
			else
			{
				BootstrapDialog.alert({
			        title: "<?php lang('Error'); ?>",
			        //message: error_message,
			        type: BootstrapDialog.TYPE_DANGER, // <-- Default value is BootstrapDialog.TYPE_PRIMARY
			        closable: true,
			    });
			}
		});
	}
	
	
	
</script>