<?php
	
	include_once("../header.php");
	
	
	$retailer = new Retailers();
	$address = new Addresses();
	$phonenumber = new PhoneNumbers();
	
	$ret_subs = array();
	$ret_servs = array();
	
	if(isset($_GET['ret_id']))
	{	
		$retailer->retailer_id = $_GET['ret_id'];
		$retailer->GetRetailersRecord();		
		
		$address = new RetailerAddresses();
		$address->GetRetailerAddress($retailer->retailer_id);
		
		$phonenumber = new RetailerPhoneNumbers();
		$phonenumber->GetRetailerPhoneNumber($retailer->retailer_id);
		
		$services = new RetailerServices();
		$ret_servs = $services->GetRetailerServices($retailer->retailer_id);
		
		$subscriptions = new RetailerSubscriptions();
		$ret_subs = $subscriptions->GetRetailerSubcriptions($retailer->retailer_id);
	}
	
	
	// OPTI-REP-TODO: add_ret_record() IsAlreadyRetailer

?>


<form action="" class="form">
	<div>	
		<div>
			<h3><?php lang('Retailer Info'); ?></h3>
		</div>
		<?php if($retailer->retailer_id != 0) { ?>
		<div>
			<table>
				<tr>
					<td>
						<?php echo(lang('Created by') . ":"); ?>
					</td>
					<td>
						<?php echo(cmnGetUserNameByID($retailer->created_by_id)); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo(lang('Creation date') . ":"); ?>
					</td>
					<td>
						<?php echo($retailer->created_date); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo(lang('Modified by') . ":"); ?>
					</td>
					<td>
						<?php echo(cmnGetUserNameByID($retailer->modified_by_id)); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo(lang('Modification date') . ":"); ?>
					</td>
					<td>
						<?php echo($retailer->modified_date); ?>
					</td>
				</tr>
			</table>		
		</div>
		<?php } ?>
	</div>
	<hr />
	<!-- Tab panes -->
	<ul class="nav nav-tabs" id="retailer_tabs" data-tabs="tabs">
		<li class="active">
			<a href="#ret_profile" data-toggle="tab">
		  		<?php lang('Retailer Profile'); ?>
		  	</a>
	  	</li>
	  	<li>
			<a href="#ret_user_account" data-toggle="tab">
		  		<?php lang('User account'); ?>
		  	</a>
	  	</li>
    </ul>
	<div id="retailer_lists_tabs_content" class="tab-content">
	  
		<div class="tab-pane active" id="ret_profile">
		
			<fieldset> <!-- Informations générales -->
			
				<div class="col-md-6">					
					<div class="form-group">			 
					    <label for="retailer_name"><?php lang('Retailer name'); echo(' ('); lang('French'); echo(') '); ?></label>					    
						<input type="checkbox" id="retailer_is_head_office" name='retailer_is_head_office' value="<?php echo($retailer->retailer_is_head_office); ?>"<?php if($retailer->retailer_is_head_office) : ?> checked<?php endif; ?>/><?php lang('Head office'); ?>
						<input class="form-control" type="text" name="retailer_name_fr" value="<?php echo($retailer->retailer_name_fr); ?>" required/>
					</div>
					<div class="form-group">			
					    <label for="retailer_name_en"><?php lang('Retailer name'); echo(' ('); lang('English'); echo(') '); ?></label>
						<input class="form-control" type="text" name="retailer_name_en" value="<?php echo($retailer->retailer_name_en); ?>"  required/>
						
					</div>					
					
					<div class="form-group">		
						<label for="retailer_type_selector"><?php lang('Retailer type'); ?></label>
						<select name="retailer_type_selector"  class="form-control"  required>					
							<option value="0" selected="selected"><?php lang('Please select type'); ?></option>
							<?php foreach(cmnGetRetailerTypesList()->retailer_types_list as $ret_type){ ?>							
								<option <?php if( $ret_type['retailer_type_id'] == $retailer->retailer_type_id ){ echo("selected='selected'"); } ?> value="<?php echo $ret_type['retailer_type_id'] ?>"><?php echo $ret_type['retailer_type_name'] ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="form-group">		
					    <label for="retailer_logo"><?php lang('Logo'); ?></label>
					   
					    <div class="input-group">
					        <span class="input-group-btn">
					            <span class="btn btn-primary btn-file">
					                <?php lang('Select'); ?>&hellip;
					                <input type="file" id="retailer_logo" name="retailer_logo">
					            </span>
					        </span>
					        <input type="text" class="form-control" readonly>
					    </div>
											
					</div>
					
					<div class="form-group">			
					    <label for="retailer_ressource_person"><?php lang('Contact'); ?></label>
						<input class="form-control" type="text" name="retailer_ressource_person" value="<?php echo($retailer->retailer_ressource_person); ?>"/>
					</div>
					<div class="form-group">		
					    <label for="language_selector"><?php lang('Prefered language'); ?></label>
					    <select name="language_selector" class="form-control"  required>			    	
							<option value="" selected="selected"><?php lang('Please select language'); ?></option>					
							<?php foreach (cmnGetLanguageList()->languages_list as $language) { ?>              
					              <option value="<?php echo $language['language_id'] ?>"<?php if( $language['language_id'] == $retailer->language_id ) : ?> selected="selected"<?php endif; ?>><?php echo $language['language_name'] ?></option>;                  
					        <?php } ?>
						</select>					
					</div>
				</div>
				
				
				<div class="col-md-6">
					<div class="form-group">		            
						<label for="retailer_description_fr"><?php lang('Retailer description'); echo(' ('); lang('French'); echo(') '); ?></label>
						<textarea class="form-control" name="retailer_description_fr" id="" rows="5"><?php echo($retailer->retailer_description_fr); ?></textarea>
						
					</div>
					<div class="form-group">		
						<label for="retailer_description_en"><?php lang('Retailer description'); echo(' ('); lang('English'); echo(') '); ?></label>
						<textarea class="form-control" name="retailer_description_en" id="" rows="5"><?php echo($retailer->retailer_description_en); ?></textarea>
					</div>
					
					<div class="form-group">			        
			            <label for="grouping_selector"><?php lang('Grouping'); ?></label>
						<select id="grouping_selector" name="grouping_selector" class="form-control">
					    	<option value="0" selected="selected"><?php lang('Please select grouping'); ?></option>
					        <?php foreach (cmnGetGroupingsList()->groupings_list as $grouping) { ?>              
					              <option value="<?php echo($grouping['grouping_id']); ?>"<?php if( $grouping['grouping_id'] == $retailer->grouping_id) : ?> selected="selected"<?php endif; ?>><?php echo($grouping['grouping_name']); ?></option>                 
					        <?php } ?>
						</select>		
					</div>
					<div class="form-group">			
			            <label for="company_selector"><?php lang('Head office'); ?></label>
						<select id="company_selector" name="company_selector" class="form-control">
					    	<option value="0" selected="selected"><?php lang('Please select head office'); ?></option>
					    	<?php foreach (cmnGetCompaniesListByGrouping($retailer->grouping_id)->companies_list as $company) { ?>              
					              <option value="<?php echo($company['company_id']); ?>"<?php if( $company['company_id'] == $retailer->company_id ) : ?> selected="selected"<?php endif; ?>><?php echo($company['company_name']); ?></option>                 
					        <?php } ?>
						</select>
					</div>
				</div>
								
			
			</fieldset>
			
			<h3><?php lang('Contact Information'); ?></h3>
			<hr />
			
			<fieldset> <!-- Informations de contact -->
				<div class="col-md-6">
					
					<div class="form-group">
						<label for="retailer_email_general"><?php lang('General Email'); ?></label>
						<input class="form-control" type="text" name="retailer_email_general" value="<?php echo($retailer->retailer_email_general); ?>"  required/>
					</div>
					<div class="form-group">		
						<label for="address1"><?php lang('Address'); ?></label>
						<input class="form-control" type="text" id="street_number" name="address1" value="<?php echo($address->address1); ?>" required/>
					</div>
					<div class="form-group">	
			            <label for="address2"><?php lang('Office / Suite / Local / App / Place'); ?></label>
						<input class="form-control" type="text" name="address2" value="<?php echo($address->address2); ?>" disabled/>
					</div>
					<div class="form-group">	            
						<label for="city"><?php lang('City'); ?></label>
						<input class="form-control" type="text" id="locality" name="city" value="<?php echo($address->city); ?>" disabled required/>
					</div>
					<div class="form-group">	
						<label for="province_state"><?php lang('Province/State'); ?></label>
						<input class="form-control" type="text" id="administrative_area_level_1" name="province_state" value="<?php echo($address->province_state); ?>" disabled required/>
					</div>
					<div class="form-group">
						<label for="country_region"><?php lang('Country'); ?></label>
						<input class="form-control" type="text" id="country" name="country_region" value="<?php echo($address->country_region); ?>" disabled required/>
					</div>
					<div class="form-group">
						<label for=""><?php lang('Postal/Zip Code'); ?></label>
						<input class="form-control" type="text" id="postal_code" name="postal_zip_code" value="<?php echo($address->postal_zip_code); ?>" disabled required/>
					</div>
					<input type="hidden" name="province_state_short" value="<?php echo($address->province_state_short); ?>" />
					<input type="hidden" name="country_region_short" value="<?php echo($address->country_region_short); ?>" />
					<input type="hidden" name="latitude" value="<?php echo($address->latitude); ?>" />
					<input type="hidden" name="longitude" value="<?php echo($address->longitude); ?>" />
				</div>
				<div class="col-md-6">
				
					<div class="form-group">		
						<label for="phone_number1"><?php lang('Telephone'); ?></label>
						<input class="form-control" type="text" name="phone_number1" value="<?php echo($phonenumber->phone_number1); ?>"/>
					</div>
					<div class="form-group">	
						<label for="phone_number2"><?php lang('Telephone Other'); ?></label>
						<input class="form-control" type="text" name="phone_number2" value="<?php echo($phonenumber->phone_number2); ?>"/>
					</div>
					<div class="form-group">	
						<label for="phone_number_toll_free"><?php lang('Telephone Toll Free'); ?></label>
						<input class="form-control" type="text" name="phone_number_toll_free" value="<?php echo($phonenumber->phone_number_toll_free); ?>"/>
					</div>				
					<div class="form-group">	
						<label for="phone_number_fax"><?php lang('Fax'); ?></label>
						<input class="form-control" type="text" name="phone_number_fax" value="<?php echo($phonenumber->phone_number_fax); ?>"/>
					</div>
					<div class="form-group">	
						<label for="phone_number_fax_toll_free"><?php lang('Fax Toll Free'); ?></label>
						<input class="form-control" type="text" name="phone_number_fax_toll_free" value="<?php echo($phonenumber->phone_number_fax_toll_free); ?>"/>				
					</div>
				</div>
			
			</fieldset>
			
			<fieldset> <!-- Informations additionnelles -->
			
			
			</fieldset>
			<h3><?php lang('Web addresses and Social Network'); ?></h3>
			<hr />
			<fieldset> <!-- Réseaux sociaux -->
				
				
				<div class="col-md-6">
					<div class="form-group">	
						<label for="retailer_website_url"><?php lang('Web Site'); ?></label>
						<input class="form-control" type="text" name="retailer_website_url" value="<?php echo($retailer->retailer_website_url); ?>"/>
					</div>
					<div class="form-group">		
						<label for="retailer_facebook"><?php lang('Facebook'); ?></label>
						<input class="form-control" type="text" name="retailer_facebook" value="<?php echo($retailer->retailer_facebook); ?>"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">		
						<label for="retailer_twitter"><?php lang('Twitter'); ?></label>
						<input class="form-control" type="text" name="retailer_twitter" value="<?php echo($retailer->retailer_twitter); ?>"/>
					</div>
					<div class="form-group">		
			            <label for="retailer_linkedin"><?php lang('Linkedin'); ?></label>
						<input class="form-control" type="text" name="retailer_linkedin" value="<?php echo($retailer->retailer_linkedin); ?>"/>
					</div>
				</div>
				
		
			</fieldset>
			<h3><?php lang('Additional Information'); ?></h3>
			<hr />
			<fieldset>
				<div class="col-md-6">
					<div class="form-group">			
			            <label for="founded_year_selector"><?php lang('Year of foundation'); ?></label>
						<select id="founded_year_selector" name="founded_year_selector" class="form-control">				
					    	<option value="" selected="selected"><?php lang('Please select year of foundation'); ?></option>			    	
						</select>
					</div>
					<!--
					<div class="input-group date">
						<span class="input-group-addon">de</span>
						<input id="datepicker" type="date" class="form-control" placeholder="" />
					</div>
					-->
					
					<div class="form-group">			
			            <label for="number_employes_selector"><?php lang('Number of employees'); ?></label>
						<select id="number_employes_selector" name="number_employes_selector" class="form-control">				
					    	<option value="" selected="selected"><?php lang('Please select number of employees'); ?></option>			    	
						</select>
					</div>
					<div class="form-group">			
			            <label for="revenue_selector"><?php lang('Revenue'); ?></label>
						<select id="revenue_selector" name="revenue_selector" class="form-control">				
					    	<option value="" selected="selected"><?php lang('Please select a revenue'); ?></option>			    	
						</select>
					</div>
				</div>
			</fieldset>
			
			<h3><?php lang('Offered Services'); ?></h3>
			<hr />
			<fieldset>
				<div class="col-md-6">
					<div class="form-group" required>			
			            <?php foreach (cmnGetServicesList()->services_list as $srv) { ?>
			            	<label class="checkbox">	            		 
			            		<input type="checkbox" id="services_chk_group" name='services_chk_group[]' value="<?php echo($srv['service_id']); ?>"<?php if( $srv['service_id'] == array_search($srv['service_name'],$ret_servs)) : ?> checked<?php endif; ?> /><?php echo($srv['service_name']); ?>              
				        	</label>                        
				        <?php } ?>
					</div>			
				</div>
			</fieldset>
			
			<h3><?php lang('Subscriptions'); ?></h3>
			<hr />
			<fieldset>
				<div class="col-md-6">
					<div class="form-group" required>						
			            <?php foreach (cmnGetSubscriptionsList()->subscriptions_list as $sub) {	?>
			            	
			            	<label class="checkbox">	              
				        		<input type="checkbox" id="retailer_subscriptions_chk_group" name='subscriptions_chk_group[]' value="<?php echo($sub['subscription_id']); ?>"<?php if( $sub['subscription_id'] == array_search($sub['subscription_name'],$ret_subs)) : ?> checked<?php endif; ?> /><?php echo($sub['subscription_name']); ?>
				        	</label>                 
				        <?php } ?>
					</div>			
				</div>
			</fieldset>
			
			<hr />
			
			<div class="col-md-12">
				<?php if(empty($retailer->retailer_id)) { ?>
					<button class="btn btn-warning" onclick="add_ret_record();"><?php lang('Add'); ?></button>
				<?php } else { ?>
					<button class="btn btn-warning" onclick="update_ret_record(<?php echo($retailer->retailer_id); ?>, <?php echo($address->address_id); ?>, <?php echo($phonenumber->phone_number_id); ?>)"><?php lang('Update'); ?></button>
				<?php } ?>		
			</div>
	
		</div>
		<div class="tab-pane" id="ret_user_account">
			À faire / To Do
		</div>
	</div>
	
	
	
	
</form>



<?php include_once('../footer.php'); ?> 




<script type="text/javascript">

	window.onload = function ()
	{		
		// YEAR OF FOUNDATION DROP DOWN LIST
		GenerateYearDropDownList("founded_year_selector", <?php echo(json_encode($retailer->retailer_founded_year)); ?>);
	    	    
		// NUMBER OF EMPLOYEES DROP DOWN LIST
		GenerateNumberRangeDropDownList("number_employes_selector", <?php echo(json_encode($retailer->retailer_number_employes)); ?>);	    
	
	 	// RETAILER REVENUE DROP DOWN LIST
	 	GenerateRevenueRangeDropDownList("revenue_selector", <?php echo(json_encode($retailer->retailer_revenue)); ?>);
	};

	$(document).ready(function ($) {
	    $('#retailer_tabs').tab();
	});

	



	$("#grouping_selector").change(function() {

		$("#company_selector").val('0');
	});

	
	$("#street_number").click(function() {	
		
		BootstrapDialog.show({
		    title: '<?php lang('Complete address'); ?>',
		    message: $('<input type="text" class="form-control" id="ret_geocode_autocomplete" onFocus="geolocate()" placeholder="<?php lang('Type your address'); ?>" />'),
		    onshown: function(dialogRef){
				    	initializeAutocompletePlaces('ret_geocode_autocomplete');
				    	$('#ret_geocode_autocomplete').focus();
			    	 },
			    	 
	    	buttons: [{
		        label: '<?php lang('Done'); ?>',
		        cssClass: 'btn-primary',
		        action: function(dialogRef) {		        	
		        	dialogRef.close();
		        }
		    }]
		});		
	});


	function add_ret_record()
    {
		
		var IsAlreadyRetailer = false;

		// INSERT RETAILER
		$.post('../controllers/retailers.php?ispresent=',ret_params,function(data){

		});


		// RETAILER PARAMS
	    var ret_params = { 
							ho		: $("#retailer_is_head_office").is(':checked') ? 1 : 0,
							gid 	: $('select[name="grouping_selector"]').val(),
		                    cid		: $('select[name="company_selector"]').val(),
		                    tid 	: $('select[name="retailer_type_selector"]').val(),
		                    lid 	: $('select[name="language_selector"]').val(),
		                    logo	: null,
		                    name_fr : $('input[name="retailer_name_fr"]').val().trim(),
		                    name_en : $('input[name="retailer_name_en"]').val().trim(),
		                    rp 		: $('input[name="retailer_ressource_person"]').val().trim(),
		                    eg 		: $('input[name="retailer_email_general"]').val().trim(),
		                    fy 		: $('select[name="founded_year_selector"]').val(),
		                    ne 		: $('select[name="number_employes_selector"]').val(),
		                    rev 	: $('select[name="revenue_selector"]').val(),
		                    wu 		: $('input[name="retailer_website_url"]').val(),
		                    twt 	: $('input[name="retailer_twitter"]').val().trim(),
		                    fb 		: $('input[name="retailer_facebook"]').val().trim(),
		                    li 		: $('input[name="retailer_linkedin"]').val().trim(),
		                    desc_fr : $('textarea[name="retailer_description_fr"]').val().trim(),
		                    desc_en : $('textarea[name="retailer_description_en"]').val().trim()
		                    
		                 }	    
		
		// INSERT RETAILER
		$.post('../controllers/retailers.php?create=',ret_params,function(data){
	    	
	    	var retailer_id = data.trim();
	    	var address_id = 0;
	    	var phone_number_id = 0;
	    	
			if(data > 0)
			{
				// ADDRESS PARAMS
		        var addr_param = {
									ret_id	: retailer_id,
									add1 	: $('input[name="address1"]').val().trim(),
						            add2 	: $('input[name="address2"]').val().trim(),
						            city 	: $('input[name="city"]').val().trim(),
						            ps 		: $('input[name="province_state"]').val().trim(),
						            pss		: $('input[name="province_state_short"]').val().trim(),						            
						            cr 		: $('input[name="country_region"]').val().trim(),
						            crs		: $('input[name="country_region_short"]').val().trim(),
						            postal 	: $('input[name="postal_zip_code"]').val().trim(),						            
						            lati 	: $('input[name="latitude"]').val().trim(),
						            longi 	: $('input[name="longitude"]').val().trim()
						    	 }

		     	// INSERT ADDRESS		     	
		        $.post('../controllers/addresses.php?create=',addr_param,function(data){
		        	address_id = data.trim();
		        });

		     	// INSERT RETAILER'S ADDRESS (many to many)
		     	var ret_addr_param = { aid : address_id, rid : retailer_id }  
	        	$.post('../controllers/retailers.php?retaddr=',ret_addr_param,function(){
			    });
		     	
			 

		        // PHONE NUMBERS PARAMS
	        	var phone_param = {
									ret_id	: retailer_id,
									phone1 	: $('input[name="phone_number1"]').val().trim(),
						    		phone2 	: $('input[name="phone_number2"]').val().trim(),
						    		free 	: $('input[name="phone_number_toll_free"]').val().trim(),
						    		fax 	: $('input[name="phone_number_fax"]').val().trim(),
						    		faxfree	: $('input[name="phone_number_fax_toll_free"]').val().trim()
						    	  }
				
		     	// INSERT PHONE NUMBERS            
		        $.post('../controllers/phone_numbers.php?create=',phone_param,function(data){
		        	phone_number_id = data.trim();
			    });

		     	// INSERT RETAILER'S PHONE NUMBERS (many to many)
		     	var ret_pn_param = { pid : phone_number_id, rid	: retailer_id }
	        	$.post('../controllers/retailers.php?retpn=',ret_pn_param,function(){
			    });


				// INSERT COMPANY RETAILER
				if($('select[name="company_selector"]').val() > 0)
				{
					var comp_ret_param = { cid : $('select[name="company_selector"]').val(), rid : retailer_id }
		        	$.post('../controllers/retailers.php?compret=',comp_ret_param,function(){
				    });
				}
			    

		     			     	 
		        // CHECK IF USER HAS SELECTED SERVICES 
		        if ($('input:checkbox[name="services_chk_group[]"]:checked').length > 0)
		        {
					var service_ids = {};
				   	$('input:checkbox[name="services_chk_group[]"]:checked').each(function() {
				   		service_ids[$(this).val()] = retailer_id;
				    });

				   	// INSERT RETAILER'S SERVICES (many to many)
				   	var ret_srv_param = { srvids : service_ids }
			       	$.post('../controllers/retailers.php?retsrv=',ret_srv_param,function(){
				    });
		        }

		     	// CHECK IF USER HAS SELECTED SUBSCRIPTIONS
		     	if ($('input:checkbox[name="subscriptions_chk_group[]"]:checked').length > 0)
		        {
					var subscription_ids = {};
				   	$('input:checkbox[name="subscriptions_chk_group[]"]:checked').each(function() {
				   		subscription_ids[$(this).val()] = retailer_id;
				    });

				   	// INSERT RETAILER'S SUBSCRIPTIONS (many to many)
				   	var ret_subs_param = { subsids : subscription_ids }
			      	$.post('../controllers/retailers.php?retsubs=',ret_subs_param,function(){
				    });
		         }
			}  			       
	 	});    	        
	  
	}
    
    

	function update_ret_record(retid, addid, pnid)
    {

		// UPDATE PARAMS
	    var ret_params = {
	    					id		: retid,
	    					ho		: $("#retailer_is_head_office").is(':checked') ? 1 : 0, 
	    					gid 	: $('select[name="grouping_selector"]').val(),
		                    cid		: $('select[name="company_selector"]').val(),
		                    tid 	: $('select[name="retailer_type_selector"]').val(),
		                    lid 	: $('select[name="language_selector"]').val(),
		                    logo	: null,
		                    name_fr : $('input[name="retailer_name_fr"]').val().trim(),
		                    name_en : $('input[name="retailer_name_en"]').val().trim(),
		                    rp 		: $('input[name="retailer_ressource_person"]').val().trim(),
		                    eg 		: $('input[name="retailer_email_general"]').val().trim(),
		                    fy 		: $('select[name="founded_year_selector"]').val().trim(),
		                    ne 		: $('select[name="number_employes_selector"]').val().trim(),
		                    rev 	: $('select[name="revenue_selector"]').val(),
		                    wu 		: $('input[name="retailer_website_url"]').val(),
		                    twt 	: $('input[name="retailer_twitter"]').val().trim(),
		                    fb 		: $('input[name="retailer_facebook"]').val().trim(),
		                    li 		: $('input[name="retailer_linkedin"]').val().trim(),
		                    desc_fr : $('textarea[name="retailer_description_fr"]').val().trim(),
		                    desc_en : $('textarea[name="retailer_description_en"]').val().trim()
		                    
		                 }	    
		
		// UPDATE RETAILER
		$.post('../controllers/retailers.php?update=',ret_params,function(){

			// ADDRESS PARAMS
	        var addr_param = {
	        					id		: addid,
								add1 	: $('input[name="address1"]').val().trim(),
					            add2 	: $('input[name="address2"]').val().trim(),
					            city 	: $('input[name="city"]').val().trim(),
					            ps 		: $('input[name="province_state"]').val().trim(),
					            pss		: $('input[name="province_state_short"]').val().trim(),
					            cr 		: $('input[name="country_region"]').val().trim(),
					            crs		: $('input[name="country_region_short"]').val().trim(),
					            postal 	: $('input[name="postal_zip_code"]').val().trim(),
					            lati 	: $('input[name="latitude"]').val().trim(),
					            longi 	: $('input[name="longitude"]').val().trim()
					    	 }

	     	// UPDATE ADDRESS		     	
	        $.post('../controllers/addresses.php?update=',addr_param,function(){
	        });


	     	// PHONE NUMBERS PARAMS
        	var phone_param = {
        						id		: pnid,
								phone1 	: $('input[name="phone_number1"]').val().trim(),
					    		phone2 	: $('input[name="phone_number2"]').val().trim(),
					    		free 	: $('input[name="phone_number_toll_free"]').val().trim(),
					    		fax 	: $('input[name="phone_number_fax"]').val().trim(),
					    		faxfree	: $('input[name="phone_number_fax_toll_free"]').val().trim()
					    	  }
			
	     	// UPDATE PHONE NUMBERS            
	        $.post('../controllers/phone_numbers.php?update=',phone_param,function(){
		    });


        	// CHECK IF USER HAS SELECTED NAD/OR CHANGED SERVICES 
	        if ($('input:checkbox[name="services_chk_group[]"]:checked').length > 0)
	        {
				var service_ids = [];
			   	$('input:checkbox[name="services_chk_group[]"]:checked').each(function() {
			   		service_ids.push($(this).val());
			    });

			   	// INSERT RETAILER'S SERVICES (many to many)
			   	var ret_srv_param = { srvids : service_ids, rid : retid }
		       	$.post('../controllers/retailers.php?uptretsrv=',ret_srv_param,function(){
			    });
	        }

	     	// CHECK IF USER HAS SELECTED SUBSCRIPTIONS
	     	if ($('input:checkbox[name="subscriptions_chk_group[]"]:checked').length > 0)
	        {
				var subscription_ids = [];
			   	$('input:checkbox[name="subscriptions_chk_group[]"]:checked').each(function() {
			   		subscription_ids.push($(this).val());
			    });

			   	// INSERT RETAILER'S SUBSCRIPTIONS (many to many)
			   	var ret_subs_param = { subsids : subscription_ids, rid : retid }
		      	$.post('../controllers/retailers.php?uptretsubs=',ret_subs_param,function(){
			    });
	         }
	        		    	 
	    });
	   
	}



	
</script>
	
	
	
