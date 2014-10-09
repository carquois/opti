

// Input Fields
var address1InputField = $('input[name="address1"]');
var address2InputField = $('input[name="address2"]');
var cityInputField = $('input[name="city"]');
var provinceInputField = $('input[name="province_state"]');
var postalInputField = $('input[name="postal_zip_code"]');
var countryInputField = $('input[name="country_region"]');

// Hidden Fields
var provinceShortHiddenField = $('input[name="province_state_short"]');
var countryShortHiddenField = $('input[name="country_region_short"]');
var LatHiddenField = $('input[name="latitude"]');
var LngHiddenField = $('input[name="longitude"]');



// Disable all address input filds except for the autocomplete.
address1InputField.prop( "disabled", false );
address2InputField.prop( "disabled", true );
cityInputField.prop( "disabled", true );
provinceInputField.prop( "disabled", true );
postalInputField.prop( "disabled", true );
countryInputField.prop( "disabled", true );


 // This example displays an address form, using the autocomplete feature
 // of the Google Places API to help users fill in the information.
 function initializeAutocompletePlaces(elementId)
 {	 	 
   	// Create the autocomplete object, restricting the search
   	// to geographical location types.
   	autocomplete = new google.maps.places.Autocomplete(document.getElementById(elementId), { types: ['geocode'] });       	
   
   	// When the user selects an address from the dropdown,
   	// populate the address fields in the form.
  	google.maps.event.addListener(autocomplete, 'place_changed', function()
   	{
    	fillInAddress();
   	});
 }

 // START region_fillform
 function fillInAddress()
 {
	// Get the place details from the autocomplete object.
   	var place = autocomplete.getPlace();
	    
    if (!place.geometry)
    {
        return;
    }
	
	var streetNumber = "";
	var streetRoute = "";
	var streetString = "";
	
	// Reinitialiize fields
	address1InputField.val("");
	address2InputField.val("");
	cityInputField.val("");
	provinceInputField.val("");
	postalInputField.val("");
	countryInputField.val("");
	
	// Reinitialiize hidden fields
	//provinceShortHiddenField.val("");
	//countryShortHiddenField.val("");
	//LatHiddenField.val("");
	//LngHiddenField.val("");
        
    /* Loop through the address components for the selected place and fill */
    for (i = 0; i < place.address_components.length; i++)
    {
    	//var test = place.postcode_localities;
    	var type = place.address_components[i].types[0];
        
        if (type == 'street_number')
        {
            streetNumber = place.address_components[i].long_name;
        }
        
        if (type == 'route')
        {
            streetRoute = place.address_components[i].long_name;
        }
        
        if (type == 'locality')
        {
            cityInputField.val(place.address_components[i].long_name);
            cityInputField.prop( "disabled", true );
        }
        
        if (type == 'administrative_area_level_1')
        {
        	provinceInputField.val(place.address_components[i].long_name);
        	provinceShortHiddenField.val(place.address_components[i].short_name);
        	provinceInputField.prop( "disabled", true );
        }
        
        if (type == 'postal_code')
        {
            postalInputField.val(place.address_components[i].long_name);
            postalInputField.prop( "disabled", true );
        }
        
        if (type == 'country')
        {
        	countryInputField.val(place.address_components[i].long_name);
        	countryShortHiddenField.val(place.address_components[i].short_name);
        	countryInputField.prop( "disabled", true );
        }
    }
    
    if(!streetNumber)
    {
    	streetString = $('#ret_geocode_autocomplete').val().split(',')[0];    	
    }
    else
    {    	
    	streetString = streetNumber + " " + streetRoute;
    }
    
    // Set complete address field with concatenate string
    address1InputField.val(streetString);
    
    // Once all address fields have been filled, set Latitude and Longitude hidden fields
    LatHiddenField.val(place.geometry.location.lat());
    LngHiddenField.val(place.geometry.location.lng());
    
    if(!cityInputField.val()){cityInputField.prop( "disabled", false );}
    if(!provinceInputField.val()){provinceInputField.prop( "disabled", false );}
    if(!postalInputField.val()){postalInputField.prop( "disabled", false );}
    if(!countryInputField.val()){countryInputField.prop( "disabled", false );}
   	
   	// This field is not part of the places object from google.
   	// User has completed his address. Now need to enable to give access
   	// to input field for additional address information
    // This field is used for Office/Local/Suite ...
    address2InputField.prop( "disabled", false );

   
 }
 // END region_fillform
 
 //////////////////////////////////////////////////////////////////////////////////

 // START region_geolocation
 // Bias the autocomplete object to the user's geographical location,
 // as supplied by the browser's 'navigator.geolocation' object.
 function geolocate()
 {
 	if (navigator.geolocation)
 	{
    	navigator.geolocation.getCurrentPosition(function(position)
    	{
       		var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

       		autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
     });
   }
 }
 // END region_geolocation
 
 
		