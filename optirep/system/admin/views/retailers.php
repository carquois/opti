<?php

	include_once("../header.php");
	
	$retailers = new Retailers();
	$retailers->LoadRecords();	
	
	$address = new RetailerAddresses();	
	$phone_number = new RetailerPhoneNumbers();
	
?>

<style>

	body { font-size: 140%; }
    div.DTTT { margin-bottom: 0.5em; float: right; }
    div.dataTables_wrapper { clear: both; }

</style>

<div>
	<input type="button" class="btn btn-warning" value="<?php lang('Add retailer'); ?>" onclick="add_retailer_record();">

	<?php if($retailers->retailers_records > 0 ){?>
		<input type="button" id="delete_selected" class="btn btn-warning" value="<?php lang('Delete selected'); ?>" onclick="delete_retailer_records();">
	<?php }?>
</div>


<br/>

<div id="dataTables_wrapper">

	<table id="PagerTable" class="table table-striped">
	
	<thead>
	        <tr>
	        	<td>
		        	<label class="checkbox">
						<input type="checkbox" id="select_all_chk" value=""/><?php lang('Select all'); ?>
					</label>
	        	</td>
	        	<td>
		        	<label class="checkbox">
						<?php echo( $count = ($retailers->retailers_records == 0) ? $retailers->retailers_records : count($retailers->retailers_records)); ?>
						<?php echo(" "); ?>
						<?php lang('Retailers'); ?> 
					</label>
	        	</td>
	        </tr>
	        <tr>
	        	<th><?php lang('Actions'); ?></th>
	        	<th><?php lang('Active'); ?></th>
		        
		        <!-- RETAILER ENTITY -->
		        <th><?php lang('Retailer type'); ?></th>
		        <!-- <th><?php lang('Logo'); ?></th> --> 
		        <th><?php lang('Retailer'); ?></th>
		        <th><?php lang('Grouping'); ?></th>
		        <th><?php lang('Head office'); ?></th>
	            <th><?php lang('Contact'); ?></th>
	            <!-- <th><?php lang('Prefered language'); ?></th> -->
	            <!-- <th><?php lang('Year of foundation'); ?></th> -->
	            <!-- <th><?php lang('Number of employees'); ?></th> -->
	            <!-- <th><?php lang('Revenue'); ?></th> -->
	            
	            <!-- ADDRESSES ENTITY -->
	            <!-- <th><?php lang('Address 1'); ?></th> -->
	            <!-- <th><?php lang('Address 2'); ?></th> -->
	            <th><?php lang('City'); ?></th>
	            <th><?php lang('Prov/St.'); ?></th>            
	            <th><?php lang('Country'); ?></th>
	            <!-- <th><?php lang('Postal Code'); ?></th> -->
	            
	            <!-- PHONE_NUMBERS ENTITY -->
	            <th><?php lang('Telephone'); ?></th>
	            <!-- <th><?php lang('Telephone Other'); ?></th> -->
	            <!-- <th><?php lang('Telephone Toll Free'); ?></th> -->
	            <!-- <th><?php lang('Fax'); ?></th> -->
	            <!-- <th><?php lang('Fax Toll Free'); ?></th> -->
	            
	            <!-- RETAILER ENTITY -->
	            <th><?php lang('General Email'); ?></th>
	            <!-- <th><?php lang('Web Site'); ?></th> -->
	            <!-- <th><?php lang('Facebook'); ?></th> -->
	            <!-- <th><?php lang('Twitter'); ?></th> -->
	            <!-- <th><?php lang('Linkedin'); ?></th> -->            
	            <!-- <th><?php lang('Retailer description'); ?></th>
	            <!-- <th><?php lang('Created by'); ?></th> -->
	            <!-- <th><?php lang('Creation date'); ?></th> -->
	            <th><?php lang('Modified by'); ?></th>
	            <th><?php lang('Modification date'); ?></th>
	            
	            
	        </tr>
	    </thead>
	    <tbody>
	    
	        <?php if(!empty($retailers->retailers_records)){
	        	
	                  foreach($retailers->retailers_records as $retailer){ ?>
	                
				        <tr valign="top" id="retailer_<?php echo($retailer['retailer_id']); ?>">
				        
				        	<td>			        		
					            <a onclick="edit_retailer_record(<?php echo($retailer['retailer_id']); ?>);"><span title="<?php lang('Edit'); ?>" class="glyphicon glyphicon-pencil"></span></a>
					            <a onclick="delete_retailer_record(<?php echo($retailer['retailer_id']); ?>);"><span title="<?php lang('Delete'); ?>" class="glyphicon glyphicon-trash"></span></a>
					            <input type='checkbox' id="delete_chk_group" name='delete_chk_group[]' value="<?php echo($retailer['retailer_id']); ?>" />
				            </td>
				        	
				        	<!-- RETAILER ENTITY -->
				        	<td><?php if($retailer['retailer_is_active']){echo("<span class='glyphicon glyphicon-ok'></span>");} ?></td>
				            <td><?php echo(cmnGetRetailerTypeNameByID($retailer['retailer_type_id'])); ?></td>
				            <!-- <td><img id="retailer_logo" src="<?php echo($retailer['retailer_logo']); ?>" alt="Logo"></td> -->      
				            <td><?php echo($retailer['retailer_name']); ?></td>
				            <td><?php echo((cmnGetGroupingNameByID($retailer['grouping_id']) != false) ? cmnGetGroupingNameByID($retailer['grouping_id']) : ""); ?></td>
				            <td><?php echo((cmnGetCompanyNameByID($retailer['company_id']) != false) ? cmnGetCompanyNameByID($retailer['company_id']) : ""); ?></td>
				            <td><?php echo($retailer['retailer_ressource_person']); ?></td>
				            <!-- <td><?php echo(cmnGetLanguageNameByID($retailer['language_id'])); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_founded_year']); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_number_employes']); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_revenue']); ?></td> -->			            
				            
				            
				            <!-- ADDRESSES ENTITY -->
				            <?php $address->GetRetailerAddress($retailer['retailer_id'])?>
				            <input type='hidden' name='delete_addr_group[]' value="<?php echo($address->address_id); ?>" />
				            <!-- <td><?php echo($address->address1); ?></td> -->
				            <!-- <td><?php echo($address->address2); ?></td> -->
				            <td><?php echo($address->city); ?></td>
				            <td><?php echo($address->province_state); ?></td>
				            <td><?php echo($address->country_region); ?></td>
				            <!-- <td><?php echo($address->postal_zip_code); ?></td> -->
				            
				            
				            <!-- PHONE_NUMBERS ENTITY -->
				            <?php $phone_number->GetRetailerPhoneNumber($retailer['retailer_id']) ?>
				            <input type='hidden' name='delete_phn_group[]' value="<?php echo($phone_number->phone_number_id); ?>" />
				            <td><?php echo($phone_number->phone_number1); ?></td>
				            <!-- <td><?php echo($phone_number->phone_number2); ?></td> -->
				            <!-- <td><?php echo($phone_number->phone_number_toll_free); ?></td> -->
				            <!-- <td><?php echo($phone_number->phone_number_fax); ?></td> -->
				            <!-- <td><?php echo($phone_number->phone_number_fax_toll_free); ?></td> -->
				            
				            
				            <!-- RETAILER ENTITY -->
				            <td><?php echo($retailer['retailer_email_general']); ?></td>            
				            <!-- <td><?php echo($retailer['retailer_website_url']); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_facebook']); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_twitter']); ?></td> -->
				            <!-- <td><?php echo($retailer['retailer_linkedin']); ?></td> -->            
				            <!-- <td><?php echo($retailer['retailer_description']); ?></td> -->
				            <!-- <td><?php echo(cmnGetUserNameByID($retailer['created_by_id'])); ?></td> -->
				            <!-- <td><?php echo($retailer['created_date']); ?></td> -->
				            <td><?php echo(cmnGetUserNameByID($retailer['modified_by_id'])); ?></td>
				            <td><?php echo($retailer['modified_date']); ?></td>
				            
				        </tr>
	        
				<?php } ?>
	        <?php } ?>
	        
	    </tbody>
	       
	</table>
</div>


<?php include_once('../footer.php'); ?>

<script>

$(document).ready(function() {
    var table = $('#PagerTable').DataTable();
    var tt = new $.fn.dataTable.TableTools( table );
 
    $( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');
} );		

	$(function(){
		
		// SELECT ALL RETAILERS	
		$('#select_all_chk').on('click', function() {			
	
			if($(this).is(':checked'))
			{
				$('input[name="delete_chk_group[]"]').each(function(){				 
					 $(this).prop('checked', true);
				});
			}
			else
			{
				$('input[name="delete_chk_group[]"]').each(function(){				 
					 $(this).prop('checked', false);
				});
			}
		});
	});
	

	function add_retailer_record()	
	{		
		location.replace('retailer_editor.php');
	}

	function edit_retailer_record(id)
    {
		location.replace('retailer_editor.php?ret_id='+id);
    }  

	function delete_retailer_record(id)
    {  
        BootstrapDialog.confirm("<?php lang('Delete permanently') ?>", function(result)
        {            
			if(result)
	        {
	            $.post('../controllers/retailers.php?delete=',{rid : id}, function(data){

					var num_deleted = data.trim();

					if(num_deleted > 0)
					{
						$('tr#retailer_'+id).remove();
					}            	
	            });
	            
	            location.reload();
	        }            
        });    
        
    }
	
	function delete_retailer_records()
	{
		var retailer_ids = [];
		var add_ids = [];
		var phn_ids = [];
	    
	    if ($('input:checkbox[name="delete_chk_group[]"]:checked').length > 0)
	    {
	    	var num_records = $('input:checkbox[name="delete_chk_group[]"]:checked').length;

	    	BootstrapDialog.confirm("<?php lang('Delete all permanently'); ?>" +
	    	    					"<BR/><BR/>" +
	    	    					"<label>" + num_records + " " +
	    	    					"<?php lang('Retailers'); ?>" + " " +
	    	    					"<?php lang('will be deleted permanently'); ?>." +
	    	    					"</label>", function(result)
		    {
	    		if(result)
    		    {
    				$('input[name=delete_chk_group[]]:checked').each(function(){
    		    		retailer_ids.push($(this).val());	
    		        });

    		    	$.post('../controllers/retailers.php?delete=',{rids : retailer_ids}, function(data){

    					var num_deleted = data.trim();

    					if(num_deleted > 0)
    					{
							// Remove rows in table. 
    						$('input[name=delete_chk_group[]]:checked').each(function(){
    							$('tr#retailer_'+$(this).val()).remove();
    						});
    					}            	
    	            });

    		    	location.reload();
    		    }		    	      
    	    });
	    }
	    else
	    {
	    	BootstrapDialog.alert("<?php lang('Please check one or more entries to be deleted'); ?>");
	    }    
	    
	 }
	 
   	 
</script>