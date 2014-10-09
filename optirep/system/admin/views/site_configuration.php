<?php
	
	include_once("../header.php");
	
	// Get Site Configurations.
	$configs = new SiteConfiguration();
	$configs->Load();
	
?>



<ul class="nav nav-tabs" id="site_configuration_tabs" data-tabs="tabs">
  <li class="active">
  		<a href="#configuration_pane" data-toggle="tab"><?php lang('Configuration'); ?></a>
  </li>
  <li>
  		<a href="#translatable_pane" data-toggle="tab"><?php lang('Translatable Configuration'); ?></a>
  </li>
  <li>
  		<!-- 1 = SUPERADMIN (Show only to SUPERADMIN) -->
  		<a href="#non_configurables_pane" data-toggle="tab"><?php lang('Static Configuration'); ?></a>
  </li>
  <li>
  		<a href="#users_pane" data-toggle="tab"><?php lang('Users'); ?></a>
  </li>
  <li>
  		<a href="#user_types_pane" data-toggle="tab"><?php lang('User Types'); ?></a>
  </li>
</ul>


<!-- Tab panes -->
<div id="site_configuration_content" class="tab-content">
  
  <div class="tab-pane active" id="configuration_pane">
  	<h2 title="<?php lang('Configuration'); ?>"><?php lang('Configuration'); ?></h2>
	<table class="table table-striped" id="site_configs">
		    <thead>
		        <tr>
		            <th><p class="lead"><?php lang('Config variables'); ?></p></th>
		            <th><p class="lead"><?php lang('Config values'); ?></p></th>
		            <th></th>
		        </tr>
		    </thead>
	    
		     <tbody>
				<?php foreach($configs->site_configuration_list as $config){ ?>
					<?php if(($config['is_configurable']) && (!$config['is_translatable'])) { ?>
					<tr>		  
					  <td>
					  	<p><?php echo($config['site_config_friendly_name']); ?></p>
					  </td>                 
					  <td>			  
					  	<input class="form-control" type="text"
					  		   id="<?php echo($config['site_config_key']); ?>"
					  		   name="site_config_value"
					  		   value="<?php if(!empty($config['site_config_value'])){echo($config['site_config_value']);}else{echo "";}; ?>"/>
					  </td>
					  <td>
					  	<p><?php echo($config['site_config_desc']); ?></p>
					  </td> 
					</tr>
					<?php } ?>
		        <?php } ?>
		    </tbody>
		</table>
	<button class="btn btn-warning" onclick="UpdateConfig();"><?php lang('Save'); ?></button>
  </div>
  
  <div class="tab-pane" id="translatable_pane">
  	<h2 title="<?php lang('Translatable Configuration'); ?>"><?php lang('Translatable Configuration'); ?></h2>	
	<table class="table table-striped" id="site_trans_configs">
	    <thead>
	        <tr>
	            <th><p class="lead"><?php lang('Config variables'); ?></p></th>
	            <th><p class="lead"><?php lang('French'); ?></p></th>
	            <th><p class="lead"><?php lang('English'); ?></p></th>
	            <th></th>
	        </tr>
	    </thead>
	    
	    <tbody>
			<?php foreach($configs->site_configuration_list as $config){ ?>
				<?php if($config['is_translatable']) { ?>	
				<tr>	  
				  <td>
				  	<p><?php echo($config['site_config_friendly_name']); ?></p>
				  </td>                 
				  <td>			  
				  	<input class="form-control" type="text"
				  		   id="<?php echo($config['site_config_key']); ?>"
				  		   name="site_config_value_fr"
				  		   value="<?php if(!empty($config['site_config_value_fr'])){echo($config['site_config_value_fr']);}else{echo "";}; ?>"/>
				  </td>
				  <td>
				  	<input class="form-control" type="text"
				  		   id="<?php echo($config['site_config_key']); ?>"
				  		   name="site_config_value_en"
				  		   value="<?php if(!empty($config['site_config_value_en'])){echo($config['site_config_value_en']);}else{echo "";}; ?>"/>
				  </td>
				  <td>
				  	<p><?php echo($config['site_config_desc']); ?></p>
				  </td> 
				</tr>
				<?php } ?>
	        <?php } ?>
	    </tbody>
	</table>
	<button class="btn btn-warning" onclick="UpdateTranslatablesConfig();"><?php lang('Save'); ?></button>
  	
  </div>
  
  <div class="tab-pane" id="non_configurables_pane">
  	<h2 title="<?php lang('Static Configuration'); ?>"><?php lang('Static Configuration'); ?></h2>
	<table class="table table-striped" id="site_configs">
		    <thead>
		        <tr>
		            <th><p class="lead"><?php lang('Config variables'); ?></p></th>
		            <th><p class="lead"><?php lang('Config values'); ?></p></th>
		            <th></th>
		        </tr>
		    </thead>
	    
		     <tbody>
				<?php foreach($configs->site_configuration_list as $config){ ?>
					<?php if(!$config['is_configurable']) { ?>
					<tr>		  
					  <td>
					  	<p><?php echo($config['site_config_friendly_name']); ?></p>
					  </td>                 
					  <td>			  
					  	<input class="form-control" type="text"
					  		   id="<?php echo($config['site_config_key']); ?>"
					  		   name="site_config_value"
					  		   value="<?php if(!empty($config['site_config_value'])){echo($config['site_config_value']);}else{echo "";}; ?>"/>
					  </td>
					  <td>
					  	<p><?php echo($config['site_config_desc']); ?></p>
					  </td> 
					</tr>
					<?php } ?>
		        <?php } ?>
		    </tbody>
		</table>
	<button class="btn btn-warning" onclick="UpdateConfig();"><?php lang('Save'); ?></button>
  </div>
  
 
  
  <div class="tab-pane" id="users_pane">
  	<h2 title="<?php lang('Users'); ?>"><?php lang('Users'); ?></h2>	
	<?php include_once('users.php'); ?>  	
  </div>
  
  <div class="tab-pane" id="user_types_pane">
  	<h2 title="<?php lang('User Types'); ?>"><?php lang('User Types'); ?></h2>	
	<?php include_once('user_types.php'); ?>  	
  </div>
  
</div>




<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#site_configuration_tabs').tab();        
    });    
    
</script>  


<script type="text/javascript">
	
	function UpdateConfig()
    {        
		var inputValuesToUpdate = {};
		
    	$('input[id!=""][name="site_config_value"][value!=""]').each(function(){ 
    		inputValuesToUpdate["'" + $(this).attr("id") + "'"] = $(this).attr("value");
        });

        var params = { u : inputValuesToUpdate }
    	 
        $.post('../controllers/site_configuration.php',params,function(){
        });

    	location.reload();
    }

	function UpdateTranslatablesConfig()
    {        
		var inputValuesToUpdate = {};
		
		$('input[id!=""][name="site_config_value_fr"][value!=""]').each(function(){ 
    		inputValuesToUpdate["'" + $(this).attr("id") + "'"] = $(this).attr("value");

    		var params = { ut : inputValuesToUpdate, lang: $(this).attr("name") }
       	 
            $.post('../controllers/site_configuration.php',params,function(){
            });
        });

    	
		$('input[id!=""][name="site_config_value_en"][value!=""]').each(function(){ 
    		inputValuesToUpdate["'" + $(this).attr("id") + "'"] = $(this).attr("value");

    		var params = { ut : inputValuesToUpdate, lang: $(this).attr("name") }
       	 
            $.post('../controllers/site_configuration.php',params,function(){
            });
        });

		location.reload();    	
    }
            
</script>

<?php include_once('../footer.php'); ?>
