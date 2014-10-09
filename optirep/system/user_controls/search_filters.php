<?php
	require_once("../../config.php");
?>


<form action="" class="form">
	<div>
		<button id="reset_filters_button" type="reset" class="btn btn-danger"><?php lang('Reset filters'); ?></button>
	</div>
	<fieldset>
		<div class="col-sm-6">
			<div class="form-group">			        
		        <label for="grouping_selector"><?php lang('Grouping'); ?></label>
				<select id="grouping_selector" name="grouping_selector" class="form-control">
			    	<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
			        <?php foreach (cmnGetGroupingsList()->groupings_list as $grouping) { ?>              
			              <option value="<?php echo($grouping['grouping_id']); ?>"><?php echo($grouping['grouping_name']); ?></option>                 
			        <?php } ?>
				</select>		
			</div>
							
		
			<div class="form-group">		
				<label for="retailer_type_selector"><?php lang('Retailer type'); ?></label>
				<select id="retailer_type_selector" name="retailer_type_selector"  class="form-control"  required>					
					<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
					<?php foreach(cmnGetRetailerTypesList()->retailer_types_list as $ret_type){ ?>							
						<option value="<?php echo $ret_type['retailer_type_id'] ?>"><?php echo $ret_type['retailer_type_name'] ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group">		
				<label for="country_region_selector"><?php lang('Country'); ?></label>
				<select id="country_region_selector" name="country_region_selector"  class="form-control">					
					<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
					<?php foreach(cmnGetRetailerDatabaseCountryRegionList()->retailer_country_region_list as $ret_country_region){ ?>							
						<option value="<?php echo($ret_country_region['country_region_short']); ?>"><?php echo($ret_country_region['country_region']); ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group">		
				<label for="province_state_selector"><?php lang('Province/State'); ?></label>
				<select id="province_state_selector" name="province_state_selector"  class="form-control">					
					<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
					<?php foreach(cmnGetRetailerDatabaseProvinceStateList()->retailer_province_state_list as $ret_province_state){ ?>							
						<option value="<?php echo($ret_province_state['province_state_short']); ?>"><?php echo($ret_province_state['province_state']); ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group">		
				<label for="city_selector"><?php lang('City'); ?></label>
				<select id="city_selector" name="city_selector"  class="form-control">					
					<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
					<?php foreach(cmnGetRetailerDatabaseCityList()->retailer_city_list as $ret_city){ ?>							
						<option value="<?php echo($ret_city['city']); ?>"><?php echo($ret_city['city']); ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group">		
				<label for="kilometer_range_selector"><?php lang('Distance range'); ?></label>
				<select id="kilometer_range_selector" name="kilometer_range_selector" class="form-control">					
					<option value="" selected="selected"><?php echo(hellipString(lang('Select'))); ?></option>
				</select>
			</div>
		</div>
		
	</fieldset>
	

</form>
