    
    //////////////////////////////////////////////////////////////////
    // INIT
    //////////////////////////////////////////////////////////////////
	
    
    
    //////////////////////////////////////////////////////////////////
    // OBJECTS
    //////////////////////////////////////////////////////////////////

    // ------------------------------------------------------------ //
	
	//////////////////////////////////////////////////////////////////
    // SET AJAX ASYNCHRONOUS MODE
	// (Ajax calls are asynchronous (i.e.: $.post)
    //////////////////////////////////////////////////////////////////
	$.ajaxSetup({ async: false });


	//////////////////////////////////////////////////////////////////
    // AJAX AUTOCOMPLETE FIELD
    //////////////////////////////////////////////////////////////////
	$('*').ajaxComplete(function(){ message_obj = $('#msg'); });
	
    
	//////////////////////////////////////////////////////////////////
    // TABLE PAGING INITIALISATION 
	//////////////////////////////////////////////////////////////////
	/*$('#PagerTable').dataTable( {
		    "bSort": true,       // Enable sorting
			"iDisplayLength": 5,   //records per page
			"sDom": "t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType": "bootstrap",
			
			//cdn.datatables.net/plug-ins/be7019ee387/i18n/French.json
			
			 "language": {
				"url": "French.json"
	            }

	    });*/
	
	/*$(document).ready(function() {
		
		var table = $('#PagerTable').DataTable({
			 	dom: 'T<"clear">lfrtip',
		        tableTools: {
		            "aButtons": [
		                "copy",
		                "csv",
		                "xls",
		                {
		                    "sExtends": "pdf",
		                    "sPdfOrientation": "landscape",
		                    "sPdfMessage": "Your custom message would go here."
		                },
		                "print"
		            ]
		        }
			
		});
		
		var tt = new $.fn.dataTable.TableTools( table );	 
		$( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');
		
		
		
		
		
		   
    }); */
    
    //////////////////////////////////////////////////////////////////
    // FORMAT TO CURRENCY
    //////////////////////////////////////////////////////////////////
    Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator)
    {
        var n = this,
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSeparator = decSeparator == undefined ? "." : decSeparator,
        thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
        return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
    };
    
    
    
    //////////////////////////////////////////////////////////////////
    // GENERATE KILOMETER DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
    // GENERATE KILOMETER DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    function GenerateKilometerDropDownList(select_element_id, selected_option)
    {
    	var select_km = document.getElementById(select_element_id);
    	
    	var count = 10;
 	    var max_count = 500;
 	    
 	    for(var i = 0; i <= 12; i++)
 	    {
 	    	var option = document.createElement('option');
 	        
 	        option.text = count + " Km";
 	        option.value = count;
 	        
 	        select_km.add(option);
 	        
 	        if(count < 25) { count += 15; }
 	        else if(count < 50) { count += 25; }
 	        else if(count < 100) { count += 50; }
 	        else{ count += 100; }
 	        
 	        if(count > max_count)
	        {
	        	break;
	        } 	      
 	    }
	    
	    select_km.value = selected_option;
    }
    
    //////////////////////////////////////////////////////////////////
    // GENERATE YEAR DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    function GenerateYearDropDownList(select_element_id, selected_option)
    {
    	var select_founded = document.getElementById(select_element_id);
    	
    	var min_year = 1900;
    	
	    for(var i = min_year ;  i <= new Date().getFullYear() ; i++)
	    {
	        var option = document.createElement('option');
	        
	        option.text = option.value = i;
	        select_founded.add(option, 1);
	    }
	    
	    select_founded.value = selected_option;
    }
    
    //////////////////////////////////////////////////////////////////
    // GENERATE NUMBER RANGE DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    function GenerateNumberRangeDropDownList(select_element_id, selected_option)
    {
    	var select_employees = document.getElementById(select_element_id);
    	
	    var min = 1;
	    var max = 10;
	    var max_list = 1000;
	    
	    for(var i = 0; i <= 10; i++)
	    {
	        var option = document.createElement('option');
	        
	        option.text = option.value = min + " - " + max;
	        select_employees.add(option);        
	        
	        min = max;
	        
	        if(max < 25) { max += 15; }
	        else if(max < 50) { max += 25; }
	        else if(max < 100) { max += 50; }
	        else if(max > 500) { max += 200; }      
	        else{ max += 100; }		
	
			if(max > max_list)
			{
				option = document.createElement('option');
				
	        	option.text = max_list + "+";
	        	option.value = max_list;
	        	
	        	select_employees.add(option);
			}
	    }
	    
	    select_employees.value = selected_option;
    }
    
    //////////////////////////////////////////////////////////////////
    // GENERATE REVENUE RANGE DROPDOWN LIST
    //////////////////////////////////////////////////////////////////
    function GenerateRevenueRangeDropDownList(select_element_id, selected_option)
    {
    	var select_revenue = document.getElementById(select_element_id);
    	
	    var min = 50000;
	    var max = 100000;
	    var max_list = 5000000;
	    
	    for(var i = 0; i <=17; i++)
	    {
	        var option = document.createElement('option');
				
	        option.text = option.value = '$' + min.formatMoney(2,',','.') + " - " + '$' + max.formatMoney(2,',','.');
	        select_revenue.add(option);
	
			min = max;
	        
	        if(max < 500000) { max += 50000; }
	        else if(max < 1000000) { max += 100000; }
	        else { max += 1000000; }
	        
	        if(max > max_list)
			{    		
				option = document.createElement('option');
				
	        	option.text = '$' + max_list.formatMoney(2,',','.') + "+";
	        	option.value = max_list;
	        	        	
	        	select_revenue.add(option);
			}
	    }
	    
	    select_revenue.value = selected_option;
    }
    
    
    //////////////////////////////////////////////////////////////////
    // SET URL PARAMETERS
    // USAGE:
    // var url = 'http://www.url.com';
    // var params = { id:27, country_id:2 };
    //////////////////////////////////////////////////////////////////    
    function setParameters(url, params)
    {
    	url = url.replace(/[\?#].*|$/, "?" + $.param(params).replace(/&?[^&?]+=(?=(?:&|$))/g, ''));
	    
	    return url;
	}
    
    //////////////////////////////////////////////////////////////////
    // GET SPECIFIC URL PARAMETER
    //////////////////////////////////////////////////////////////////
    function getParamFromUrl(url, param)
    {
        var regex = new RegExp(".*[?&]" + param + "=([^&]+)(&|$)");
        var match = url.match(regex);
        
        return(match ? match[1] : "");
    }
    
    //////////////////////////////////////////////////////////////////
    // GET URL PARAMETERS
    //////////////////////////////////////////////////////////////////    
    function getParameters()
    {
        var searchString = window.location.search.substring(1);
        var params = searchString.split("&");
        var hash = {};

	    if (searchString == "")
    	{
	    	return {};
    	}
	    	
	    for (var i = 0; i < params.length; i++)
	    {
	      var val = params[i].split("=");
	      hash[unescape(val[0])] = unescape(val[1]);
	    }
	    
	    return hash;
	}
    
    
    
    
    
    