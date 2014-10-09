<?php 
	require_once('config.php');
	
	$filters = array();
	$retailers_filtered = array();
	$retailers_filtered_complete = array();

	
	if(isset($_GET['grouping'])) { $filters['grouping'] = $_GET['grouping']; }
	
	if(isset($_GET['retailer_type'])) { $filters['retailer_type'] = $_GET['retailer_type']; }
	
	if(isset($_GET['country_region_short'])) { $filters['country_region_short'] = $_GET['country_region_short']; }
	
	if(isset($_GET['province_state_short'])) { $filters['province_state_short'] = $_GET['province_state_short']; }
	
	if(isset($_GET['city'])) { $filters['city'] = $_GET['city']; }
	
	if(isset($_GET['kilometer'])) { $filters['kilometer'] = $_GET['kilometer']; }	
	
		
	$retailers = new Retailers();
	$retailers_filtered = $retailers->GetRetailersListByUserFilters($filters);
	
	if(($retailers_filtered) && (isset($_GET['country_region_short']) || isset($_GET['province_state_short']) || isset($_GET['city'])))
	{
		$element = 0;
		
		foreach($retailers_filtered as $ret)
		{
			$ret_address = new RetailerAddresses();
			$ret_address->GetRetailerLatitudeLongitudeByUserFilters($ret['retailer_id'], $filters);			
			
			if($ret_address->latitude && $ret_address->longitude)
			{
				$retailers_filtered_complete[$element]['retailer_id'] = $ret['retailer_id'];
				$retailers_filtered_complete[$element]['retailer_name'] = $ret['retailer_name'];
				$retailers_filtered_complete[$element]['latitude'] = $ret_address->latitude;
				$retailers_filtered_complete[$element]['longitude'] = $ret_address->longitude;
				
				$element++;
			}
		}
	}
	
	
	$grouping_lat_lng_array = array();
	$company_lat_lng_array = array();
	$retailer_lat_lng_array = array();
	
	if($retailers_filtered_complete)
	{		
		foreach($retailers_filtered_complete as $filtered_retailer)
		{
					
			$services = new RetailerServices();
			$services_array = $services->GetRetailerServices($filtered_retailer['retailer_id']);
			
			array_push($retailer_lat_lng_array, array("id"		  	=>$filtered_retailer['retailer_id'],
												 	  "name"	  	=>$filtered_retailer['retailer_name'],
												 	  "srvs_array"	=>$services_array,
												 	  "addr_lat"	=>$filtered_retailer['latitude'],
												 	  "addr_lng"	=>$filtered_retailer['longitude'])
			);
		}
	}	
	elseif($retailers_filtered)
	{
		if($retailers_filtered)
		{
			foreach($retailers_filtered as $ret)
			{
				$address = new RetailerAddresses();
				$address->GetRetailerLatitudeLongitude($ret['retailer_id']);
	
				$services = new RetailerServices();
				$services_array = $services->GetRetailerServices($ret['retailer_id']);
	
				array_push($retailer_lat_lng_array, array("id"		  	=>$ret['retailer_id'],
														  "name"	  	=>$ret['retailer_name'],
														  "srvs_array"	=>$services_array,
														  "addr_lat"	=>$address->latitude,
														  "addr_lng"	=>$address->longitude)
				);
			}
		}
	
	}

?>


<!doctype html>
<!--<div class="alert alert-danger"><?php require('config.php'); ?></div>-->
<html lang="en">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="UTF-8" />
	<title>Opti-Rep</title>
	
	
	<link rel="stylesheet" href="content/css/style-rep.css" />	
	
	<!--  WHERE TO PLACE ??? -->
	<style>	
		
		.large-dialog .modal-dialog
		{
		    width :900px;
		}

		
	</style>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="content/js/bootstrap.min.js" type="text/javascript">></script>
	<script src="content/js/bootstrap-dialog.min.js" type="text/javascript"></script>	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-44R_oUpOUEEX8eksEIawM6tTJ91U_3w&amp;sensor=false" type="text/javascript" ></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp" type="text/javascript"></script>
		
		
	<script src="/system/admin/content/js/common.js" type="text/javascript"></script>
		
	<script type="text/javascript">

		var $_SERVER = <?php echo(json_encode($_SERVER)); ?>;

		// GOOGLE MAP SETUP
		google.maps.event.addDomListener(window, 'load', initialize);
		
		var marker			 = "";
		var openedInfoWindow = null;

		function initialize()
		{
			var map = "";
						
		  	var mapOptions = {
				  	zoom: 4,
    				center: new google.maps.LatLng(44.141884, -97.541502)
  			}
		  
		  	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		  		
		  	setMapMarkers(map);
		}		

		function setMapMarkers(map)
		{
			var retailer_array = <?php echo(json_encode($retailer_lat_lng_array)); ?>;

			if(retailer_array.length > 0)
			{	
				var lat = retailer_array[0]['addr_lat'];
				var lng = retailer_array[0]['addr_lng']

				for(retailer in retailer_array)
				{
					var record_id = retailer_array[retailer]['id'];
					var title = retailer_array[retailer]['name'];
					var additional_info = ""; 
	
					if(retailer_array[retailer]['srvs_array'])
					{
						for(service in retailer_array[retailer]['srvs_array'])
						{
							additional_info += retailer_array[retailer]['srvs_array'][service] + "<br/>";
						}
					}
	
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(retailer_array[retailer]['addr_lat'],retailer_array[retailer]['addr_lng']),
						map: map,
						title: title
				   });
	
				   setMapInfoWindow(map, marker, title, additional_info, record_id)
				}

				map.setCenter(new google.maps.LatLng(lat, lng));

				if(retailer_array.length <= 1)
				{
					map.setZoom(10);
				}

				if(retailer_array.length > 1 && retailer_array.length < 25)
				{					
					map.setZoom(6);
				}
			}
		}
		

		function setMapInfoWindow(map, marker ,title, additional_info, record_id)
		{
			var contentString = '<div class="infowindow">' +
	                 	    	'<b>' + title + '</b>'+
			      				'<div>'+
			      				additional_info +
			      				'<br/>' +
			      				'<a onclick="showCompleteDetails(' + record_id + ');" style="text-decoration:none;">' + '<?php echo(lang('Complete Details')); ?>' + '</a>' + 
	     		      			'</div>' +
	                            '</div>';
	        

	        var infowindow = new google.maps.InfoWindow({
            	content: contentString
            });
            

	    	google.maps.event.addListener(marker, 'click', function() {
		    	
	    		if (openedInfoWindow != null)
		    	{
		    		openedInfoWindow.close();
		    	}
		    	
	    	    infowindow.open(map, marker); 

    	        openedInfoWindow = infowindow;

      	        google.maps.event.addListener(infowindow, 'closeclick', function() {
    	        	openedInfoWindow = null;
    	        });	    	
		    });
		}
	
		

		// RETAILER DETAILS AND SEARCH FILTERS
		function showCompleteDetails(record_id)
		{			
			BootstrapDialog.show({
				cssClass: 'large-dialog',
				title: '<h3>' + '<?php lang('Retailer Info'); ?>' + '</h3>',
	            message: $('<div></div>').load('system/admin/views/retailer_card.php?id=' + record_id),
	            draggable: true,
	            buttons: [{
			        label: '<?php lang('Close'); ?>',
			        cssClass: 'btn-primary',
			        action: function(dialogRef) {		        	
			        	dialogRef.close();
			        }
			    }]
	        });
		}

		function search_filter()
		{
			BootstrapDialog.show({
				title: '<h3>' + '<?php lang('Search'); ?>' + '</h3>',
	            message: $('<div></div>').load('system/user_controls/search_filters.php'),
	            draggable: true,
	            
	            onshown: function(dialogRef){					

	            	// Disable search button until at least one selection has been made
	            	dialogRef.getButton('search-button').disable();
	            			            
					// Generate kilometers list. (common.js)
	            	GenerateKilometerDropDownList("kilometer_range_selector","");


	            	// Disable province/state drop down list until a country/region is selected
	            	$("#province_state_selector").prop('disabled',true);

	            	// Disable city drop down list until a province/state is selected
	            	$("#city_selector").prop('disabled',true);

	            	// Disable kilometers drop down list until a city is selected
	            	$("#kilometer_range_selector").prop('disabled',true);

	            	

					// If one of the following element have been changed re-enable search button if a selection is made
	            	$("#grouping_selector, #retailer_type_selector, #country_region_selector, #kilometer_range_selector").change(function() {

						if($("#grouping_selector").val() != "" || $("#retailer_type_selector").val() != "" ||
						   $("#country_region_selector").val() != "" || $("#kilometer_range_selector").val() != "")
						{
		            		// Re-enable search button since at least one selection has been made
			            	dialogRef.getButton('search-button').enable();
						}
						else
						{
							// Re-enable search button since at least one selection has been made
			            	dialogRef.getButton('search-button').disable();
						}
	        		});

	            	// Offer the province/state drop down list only if a country/region
					// has been selected. otherwise disable
	            	$("#country_region_selector").change(function() {

						if($("#country_region_selector").val() != "")
						{
	            			$("#province_state_selector").prop('disabled',false);
						}
						else
						{
							$("#province_state_selector").prop('disabled',true);
							$("#province_state_selector").val("");
							
							$("#city_selector").prop('disabled',true);
							$("#city_selector").val("");

							$("#kilometer_range_selector").prop('disabled',true);
							$("#kilometer_range_selector").val("");
						}
	        		});

	            	// Offer the city drop down list only if a province/state
					// has been selected. otherwise disable
	            	$("#province_state_selector").change(function() {

						if($("#province_state_selector").val() != "")
						{
	            			$("#city_selector").prop('disabled',false);
						}
						else
						{
							$("#city_selector").prop('disabled',true);
							$("#city_selector").val("");

							$("#kilometer_range_selector").prop('disabled',true);
							$("#kilometer_range_selector").val("");
						}
	        		});

					// Offer the kilometer range drop down list only if a city
					// has been selected. otherwise disable
	            	$("#city_selector").change(function() {

						if($("#city_selector").val() != "")
						{
	            			$("#kilometer_range_selector").prop('disabled',false);
						}
						else
						{
							$("#kilometer_range_selector").prop('disabled',true);
							$("#kilometer_range_selector").val("");
						}
	        		});

	            	$("#reset_filters_button").click(function() {
		            	
	            		// Disable search button until at least one selection has been made
		            	dialogRef.getButton('search-button').disable();

		            	// Disable province/state drop down list until a country/region is selected
		            	$("#province_state_selector").prop('disabled',true);

		            	// Disable city drop down list until a province/state is selected
		            	$("#city_selector").prop('disabled',true);

		            	// Disable kilometers drop down list until a city is selected
		            	$("#kilometer_range_selector").prop('disabled',true);

		            	
		            			            	
	            	});
	            	
	            	
	            	// Verify if there are querystring values that were already present in current URL
					// and if present then assign value to controls. Otherwise empty.
	            	$("#grouping_selector").val(getParamFromUrl(window.location.href, 'grouping'));
	            	$("#retailer_type_selector").val(getParamFromUrl(window.location.href, 'retailer_type'));
	            	$("#country_region_selector").val(getParamFromUrl(window.location.href, 'country_region_short'));
	            	$("#province_state_selector").val(getParamFromUrl(window.location.href, 'province_state_short'));
	            	$("#city_selector").val(getParamFromUrl(window.location.href, 'city'));
	            	$("#kilometer_range_selector").val(getParamFromUrl(window.location.href, 'kilometer'));

					// Need to trigger change event since re-assigning
					// drop down list if url parameters are found previously
	            	triggerChangeEventOnSropDownList();
	            	
		    	},
		    	
	            buttons: [{
	            	id: 'search-button',
			        label: '<?php lang('Start search'); ?>',
			        cssClass: 'btn-success',
			        action: function (dialogRef) {
						
 						var params = { 
					        		 	grouping: $("#grouping_selector").val() != "" ? $("#grouping_selector").val() : "",
					        		 	retailer_type : $("#retailer_type_selector").val() != "" ? $("#retailer_type_selector").val() : "",
					        	      	country_region_short: $("#country_region_selector").val() != "" ? $("#country_region_selector").val() : "",
					        	      	province_state_short: $("#province_state_selector").val() != "" ? $("#province_state_selector").val() : "",
					        	      	city: $("#city_selector").val() != "" ? $("#city_selector").val() : "",
					        	      	kilometer: $("#kilometer_range_selector").val() != "" ? $("#kilometer_range_selector").val() : ""
						    		  };	
						 
			        	
		        	 	// Format url and parameters
				        window.location.href = setParameters(window.location.href, params);
			        }
			    },{
	            	label: '<?php lang('Close'); ?>',
	            	cssClass: 'btn-primary',
	            	action: function(dialogRef) {
	            		
	            		dialogRef.close();
	            		
	            		if($("#grouping_selector").val() == "" && $("#retailer_type_selector").val() == "" &&
 	 					   $("#country_region_selector").val() == "" && $("#province_state_selector").val() == "" &&
 	 					   $("#city_selector").val() == "" && $("#kilometer_range_selector").val() == "")
  						{
							if($_SERVER['HTTP_REFERER'])
							{
 	            				window.location.href = $_SERVER['HTTP_REFERER'];
							}
  						}	            		
 					}
			    			        
			    }]
	        });
		}

		function triggerChangeEventOnSropDownList()
		{
			// If there were querystring values that were set prior. Launch the change() event on the controls
			// that have associated values.
        	if($("#grouping_selector").val() != "") { $("#grouping_selector").change(); }
        	if($("#retailer_type_selector").val() != "") { $("#retailer_type_selector").change(); }
        	if($("#country_region_selector").val() != "") { $("#country_region_selector").change(); }
        	if($("#province_state_selector").val() != "") { $("#province_state_selector").change(); }
        	if($("#city_selector").val() != "") { $("#city_selector").change(); }
        	if($("#kilometer_range_selector").val() != "") { $("#kilometer_range_selector").change(); }
		}
	  
	</script>
	
</head>
<body>

<header>

	<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Opti-Rep</a>
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <!--
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#">Link</a></li>
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul>
	       -->     
	      <button type="submit" class="btn btn-inverse" style="position:absolute; z-index:200!important;" onclick="search_filter();"><?php lang('Search'); ?></button>
	      <button type="submit" class="btn btn-inverse" onclick="window.location.href=window.location.pathname"><?php lang('Reset filters'); ?></button>
	     <!--
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	        <li><?php include("system/user_controls/language_selector.php"); ?></li>
	      </ul>
	      -->
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

</header>
		
<div id="map-canvas"></div>

<footer></footer>




</body>
</html>

