<?php
	
	include_once("../header.php");
		
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="predefined_lists_tabs" data-tabs="tabs">
  <li class="active">
	  <a href="#organization_types" data-toggle="tab">
	  	<?php lang('Organization types'); ?>
	  </a>
  </li>
  <li>
  	<a href="#professional_types" data-toggle="tab">
  		<?php lang('Professional types'); ?>
  	</a>
  </li>
  <li>
  	<a href="#retailer_types" data-toggle="tab">
  		<?php lang('Retailer types'); ?>
  	</a>
  </li> 
  <li>
  	<a href="#supplier_types" data-toggle="tab">
  		<?php lang('Supplier types'); ?>
  	</a>
  </li>
   <li>
  	<a href="#services" data-toggle="tab">
  		<?php lang('Services'); ?>
  	</a>
  </li>
  <li>
  	<a href="#subscriptions" data-toggle="tab">
  		<?php lang('Subscriptions'); ?>
  	</a>
  </li>
</ul>

<!-- Tab panes -->
<div id="predefined_lists_tabs_content" class="tab-content">
  
  <div class="tab-pane active" id="organization_types">
    <?php include_once("organization_types.php"); ?>
  </div>
  
  <div class="tab-pane" id="professional_types">
  	<?php include_once("professional_types.php"); ?>
  </div>
  
  <div class="tab-pane" id="retailer_types">
 	<?php include_once("retailer_types.php"); ?>
  </div>
  
  <div class="tab-pane" id="supplier_types">
  	<?php include_once("supplier_types.php"); ?>
  </div>
  
  <div class="tab-pane" id="services">
  	<?php include_once("services.php"); ?>
  </div>
  
  <div class="tab-pane" id="subscriptions">
  	<?php include_once("subscriptions.php"); ?>
  </div>
  
</div>


<?php include_once('../footer.php'); ?>

<script type="text/javascript">

	$(document).ready(function ($) {
        $('#predefined_lists_tabs').tab();
    });    
    
</script>  