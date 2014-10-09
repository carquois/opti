<?php
	
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	
	
	$retailer = new Retailers();
	$address = new Addresses();
	$phonenumber = new PhoneNumbers();
	
	$ret_subs = array();
	$ret_servs = array();
	
	if(isset($_GET['id']))
	{	
		$retailer->retailer_id = $_GET['id'];
		$retailer->GetRetailer();		
		
		$address = new RetailerAddresses();
		$address->GetRetailerAddress($retailer->retailer_id);
		
		$phonenumber = new RetailerPhoneNumbers();
		$phonenumber->GetRetailerPhoneNumber($retailer->retailer_id);
		
		$services = new RetailerServices();
		$ret_servs = $services->GetRetailerServices($retailer->retailer_id);
		
		$subscriptions = new RetailerSubscriptions();
		$ret_subs = $subscriptions->GetRetailerSubcriptions($retailer->retailer_id);
	}

?>

	<div class="row">
		<div class="col-md-4">
	  		<h6><?php lang('General Information'); ?></h6>
  			<img src="<?php echo($retailer->retailer_logo); ?>" width="100" height="100" />
  	  	</div>
	  	<div class="col-md-4">
	  		 <h5><?php lang('Description'); ?></h5>
	  		<small>
		  		jkhBFvhjbSvjbLvbLDVBlBVb:Vjb:FJbvFbv:Bvf;KJBXv;kjBNFB:vn:FKBNJ:KJBNFK:JSNFb;kjnFB
		  		gFbv:SFJbn';NFBjknF"bn"Fbn"Fnb'NFB'KFNb"KFNb'KNF
		  		gkjF:Bjn"Fbn"SKFNb'KNFb'knF'bnF'blknFbnFbnFbn"Fnb
		  		gkjNFb;kn"FBn"FKBN':NKXFB'knFBnF"BknF"BKnFBKnFbn
	  		</small>
		  	
	  	</div>
	  
	</div>
	<div class="row">
	  <div class="col-md-8">
		  <p>
		 	<label><?php lang('Retailer name'); echo(": ") ?></label>
	  		<?php echo($retailer->retailer_name); if($retailer->retailer_is_head_office){echo(' ('); lang('Head office'); echo(') ');} ?>
		  <p>
	  	  <p>
		  	<label><?php lang('Grouping'); echo(": ") ?></label>
		  	<?php echo(cmnGetGroupingNameByID($retailer->grouping_id)); ?>
		  </p>
	  </div>
	</div>
	<div class="row">
	  <div class="col-md-4">.col-md-2</div>
	  <div class="col-md-4">.col-md-2</div>
	  <div class="col-md-4">.col-md-2</div>
	</div>
	<div class="row">
	  <div class="col-md-6">.col-md-2</div>
	  <div class="col-md-6">.col-md-2</div>
	</div>



<div class="container-fluid">

<div class="row">
  <div class="col-sm-9">
    <div class="row">
      <div class="col-xs-8 col-sm-6">
        <h6><?php lang('General Information'); ?></h6>
  		<img src="<?php echo($retailer->retailer_logo); ?>" width="100" height="100" />
      </div>
      
      <div class="col-xs-4 col-sm-6">
        <h5><?php lang('Description'); ?>
	  		<small>
		  		jkhBFvhjbSvjbLvbLDVBlBVb:Vjb:FJbvFbv:Bvf;KJBXv;kjBNFB:vn:FKBNJ:KJBNFK:JSNFb;kjnFB
		  		:Fbv:SFJbn';NFBjknF"bn"Fbn"Fnb'NFB'KFNb"KFNb'KNF
		  		;kjF:Bjn"Fbn"SKFNb'KNFb'knF'bnF'blknFbnFbnFbn"Fnb
		  		;kjNFb;kn"FBn"FKBN':NKXFB'knFBnF"BknF"BKnFBKnFbn
	  		</small></h5>
  		
      </div>
      
      <div class="col-xs-4 col-sm-6">
        <h6><?php lang('Retailer name'); echo(": ") ?></h6>
  		<?php echo($retailer->retailer_name); if($retailer->retailer_is_head_office){echo(' ('); lang('Head office'); echo(') ');} ?>
      </div>
      
      <div class="col-xs-4 col-sm-6">
        <h5><?php lang('Grouping'); echo(": ") ?></h6>
	  	<?php echo(cmnGetGroupingNameByID($retailer->grouping_id)); ?>
  		
      </div>
    </div>
  </div>
</div>

</div>









<table>
	<tr>		
		<td>
			<h6><?php lang('General Information'); ?></h6>
		</td>
	</tr>		
	<tr>
		<td> 
			 <img src="<?php echo($retailer->retailer_logo); ?>" width="100" height="100" />
		</td>
		<td>
			<h6><?php lang('Description'); ?></h6>
			<?php echo($retailer->retailer_description); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Retailer name'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_name); if($retailer->retailer_is_head_office){echo(' ('); lang('Head office'); echo(') ');} ?>
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Grouping'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo(cmnGetGroupingNameByID($retailer->grouping_id)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Head office'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo(cmnGetCompanyNameByID($retailer->company_id)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Retailer type'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo(cmnGetRetailerTypeNameByID($retailer->retailer_type_id)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Contact'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_ressource_person); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Prefered language'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo(cmnGetLanguageNameByID($retailer->language_id)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('General Email'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_email_general); ?>
		</td>
	</tr>
</table>
<table>
	<tr>		
		<td>
			<h4><?php lang('Web addresses and Social Network'); ?></h4>
		</td>
	</tr>		
	<tr>
		<td>
			<label ><?php lang('Web Site'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_website_url); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Facebook'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_facebook); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Twitter'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_twitter); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Linkedin'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_linkedin); ?>
		</td>
	</tr>
	
</table>
<table>
	<tr>		
		<td>
			<h4><?php lang('Contact Information'); ?></h4>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Address'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($address->address1); ?>				
		</td>
	</tr>
	<tr>
		<td>					
		</td>
		<td>
			<?php echo($address->address2); ?>				
		</td>
	</tr>
	<tr>
		<td>					
		</td>
		<td>
			<?php echo($address->city); ?>				
		</td>
	</tr>
	<tr>
		<td>					
		</td>
		<td>
			<?php echo($address->province_state); ?>				
		</td>
	</tr>
	<tr>
		<td>					
		</td>
		<td>
			<?php echo($address->country_region); ?>				
		</td>
	</tr>
	<tr>
		<td>					
		</td>
		<td>
			<?php echo($address->postal_zip_code); ?>				
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Telephone'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($phonenumber->phone_number1); ?>				
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<?php echo($phonenumber->phone_number2); ?>				
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Telephone Toll Free'); ?></label>
		</td>
		<td>
			<?php echo($phonenumber->phone_number_toll_free); ?>				
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Fax'); ?></label>
		</td>
		<td>
			<?php echo($phonenumber->phone_number_fax); ?>				
		</td>
	</tr>
	<tr>
		<td>
			<label><?php lang('Fax Toll Free'); ?></label>
		</td>
		<td>
			<?php echo($phonenumber->phone_number_fax_toll_free); ?>				
		</td>
	</tr>
</table>
<table>
	<tr>		
		<td>
			<h4><?php lang('Additional Information'); ?></h4>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Year of foundation'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_founded_year); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Number of employees'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_number_employes); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label ><?php lang('Revenue'); echo(": ") ?></label>	
		</td>
		<td>
			<?php echo($retailer->retailer_revenue); ?>
		</td>
	</tr>	
</table>
<table>
	<tr>		
		<td>
			<h4><?php lang('Offered Services'); ?></h4>
		</td>
	</tr>
	<?php foreach ($ret_servs as $srv) { ?>
        	<tr>
            	<td>
            		<?php echo($srv); ?>
            	</td>
            </tr>                       
	    <?php } ?>

</table>
<table>
	<tr>		
		<td>
			<h4><?php lang('Subscriptions'); ?></h4>
		</td>
	</tr>
	<?php foreach ($ret_subs as $sub) { ?>
        	<tr>
            	<td>
            		<?php echo($sub); ?>
            	</td>
            </tr>                       
	    <?php } ?>	
</table>

<table>
	<tr>		
		<td>
			<h4><?php lang('Description'); ?></h4>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo($retailer->retailer_description); ?>
		</td>
	</tr>


</table>
	
	
		
		
			
			
			
	
	
