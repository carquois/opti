<?php

		
	//////////////////////////////////////////////////////////////////
	// SITE CONFIGURATION - class.site_configuration.php
	//////////////////////////////////////////////////////////////////
	$cmn_configs = new SiteConfiguration();
	$cmn_configs->Load();
	
	//////////////////////////////////////////////////////////////////
	// SITE CONFIGURATION OPTI-GUIDE
	//////////////////////////////////////////////////////////////////
	$cmn_cfg_optiguide_site_title	= $cmn_configs->opti_guide_title;
	$cmn_cfg_optiguide_web_address	= $cmn_configs->opti_guide_domain_name;
	
	//////////////////////////////////////////////////////////////////
	// SITE CONFIGURATION OPTI-REP
	//////////////////////////////////////////////////////////////////
	$cmn_cfg_optirep_site_title		= $cmn_configs->opti_rep_title;
	$cmn_cfg_optirep_web_address	= $cmn_configs->opti_rep_domain_name;
	
	//////////////////////////////////////////////////////////////////
	// SITE CONFIGURATION GLOBAL
	//////////////////////////////////////////////////////////////////
	$cmn_cfg_email_general				 = $cmn_configs->email_general;
	$cmn_cfg_email_support				 = $cmn_configs->email_support;
	$cmn_cfg_email_alerts				 = $cmn_configs->email_alerts;
	$cmn_cfg_email_smtp					 = $cmn_configs->email_smtp;
	$cmn_cfg_email_smtp_is_auth			 = $cmn_configs->email_smtp_is_auth;
	$cmn_cfg_email_smtp_is_auth_username = $cmn_configs->email_smtp_is_auth_username; 
	$cmn_cfg_email_smtp_is_auth_password = $cmn_configs->email_smtp_is_auth_password;
	
	//////////////////////////////////////////////////////////////////
	// SITE IMPORTS
	//////////////////////////////////////////////////////////////////
	$cmn_cfg_accepted_import_files_array = array();	
	$cmn_cfg_accepted_import_files_array[$cmn_configs->import_groupings_filename_key_name] = $cmn_configs->import_groupings_filename;
	$cmn_cfg_accepted_import_files_array[$cmn_configs->import_companies_filename_key_name] = $cmn_configs->import_companies_filename;
	$cmn_cfg_accepted_import_files_array[$cmn_configs->import_retailers_filename_key_name] = $cmn_configs->import_retailers_filename;
// 	$cmn_cfg_import_groupings_filename = $cmn_configs->import_groupings_filename;
// 	$cmn_cfg_import_companies_filename = $cmn_configs->import_companies_filename;
// 	$cmn_cfg_import_retailers_filename = $cmn_configs->import_retailers_filename;
	
	
	//////////////////////////////////////////////////////////////////
	//
	// COMMON DATABASE UTILITIES
	//
	//////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////
	//////////////////////     LISTS    //////////////////////////////
	//////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////////////////////////////////
	// GET GROUPINGS LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetGroupingsList()
	{
		$groupings = new Groupings();
		$groupings->LoadList();
	
		return $groupings;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET COMPANIES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetCompaniesList()
	{
		$companies = new Companies();
		$companies->LoadList();
	
		return $companies;
	}

	function cmnGetCompaniesListByGrouping($grouping_id)
	{
		// IF grouping_id == 0, Give complete companies listing
		if($grouping_id != 0)
		{
			$companies = new GroupingCompanies();
			$companies->companies_list = $companies->GetGroupingCompanies($grouping_id);
		}
		else
		{
			$companies = cmnGetCompaniesList();
		}
		
	
		return $companies;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET LANGUAGES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetLanguageList()
	{
		$languages = new Languages();
		$languages->LoadList();
		
		return $languages;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET ORGANIZATION TYPES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetOrganizationTypesList()
	{
		$org_types = new OrganizationTypes();
		$org_types->LoadList();
	
		return $org_types;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET PROFESSIONAL TYPES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetProfessionalTypesList()
	{
		$pro_types = new ProfessionalTypes();
		$pro_types->LoadList();
	
		return $pro_types;
	}
		
	
	//////////////////////////////////////////////////////////////////
	// GET RETAILER TYPES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetRetailerTypesList()
	{
		$ret_types = new RetailerTypes();
		$ret_types->LoadList();
	
		return $ret_types;
	}
	
	
	//////////////////////////////////////////////////////////////////
	// GET SERVICES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetServicesList()
	{
		$srv = new Services();
		$srv->LoadList();
	
		return $srv;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET SUBSCRIPTIONS LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetSubscriptionsList()
	{
		$subscription = new Subscriptions();
		$subscription->LoadList();
	
		return $subscription;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET SUPPLIER TYPES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetSupplierTypesList()
	{
		$sup_types = new SupplierTypes();
		$sup_types->LoadList();
	
		return $sup_types;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET USER TYPES LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetUserTypesList()
	{
		$usr_types = new UserTypes();
		$usr_types->LoadList();
	
		return $usr_types;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET GROUPING DATABASE CITY/PROVINCE_STATE/COUNTRY_REGION LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetGroupingDatabaseCityList()
	{
		$grouping_cities = new GroupingAddresses();
		$grouping_cities->GetGroupingCitiesList();
	
		return $grouping_cities;
	}
	
	function cmnGetGroupingDatabaseProvinceStateList()
	{
		$grouping_province_state = new GroupingAddresses();
		$grouping_province_state->GetGroupingProvinceStateList();
	
		return $grouping_province_state;
	}
	
	function cmnGetGroupingDatabaseCountryRegionList()
	{
		$grouping_country_region = new GroupingAddresses();
		$grouping_country_region->GetGroupingCountryRegionList();
	
		return $grouping_country_region;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET COMPANY DATABASE CITY/PROVINCE_STATE/COUNTRY_REGION LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetCompanyDatabaseCityList()
	{
		$company_cities = new CompanyAddresses();
		$company_cities->GetCompanyCitiesList();
	
		return $company_cities;
	}
	
	function cmnGetCompanyDatabaseProvinceStateList()
	{
		$company_province_state = new CompanyAddresses();
		$company_province_state->GetCompanyProvinceStateList();
	
		return $company_province_state;
	}
	
	function cmnGetCompanyDatabaseCountryRegionList()
	{
		$company_country_region = new CompanyAddresses();
		$company_country_region->GetCompanyCountryRegionList();
	
		return $company_country_region;
	}
	
	//////////////////////////////////////////////////////////////////
	// GET RETAILER DATABASE CITY/PROVINCE_STATE/COUNTRY_REGION LIST
	//////////////////////////////////////////////////////////////////
	function cmnGetRetailerDatabaseCityList()
	{
		$ret_cities = new RetailerAddresses();
		$ret_cities->GetRetailerCitiesList();
	
		return $ret_cities;
	}
	
	function cmnGetRetailerDatabaseProvinceStateList()
	{
		$ret_province_state = new RetailerAddresses();
		$ret_province_state->GetRetailerProvinceStateList();
	
		return $ret_province_state;
	}
	
	function cmnGetRetailerDatabaseCountryRegionList()
	{
		$ret_country_region = new RetailerAddresses();
		$ret_country_region->GetRetailerCountryRegionList();
	
		return $ret_country_region;
	}
	
	
	//////////////////////////////////////////////////////////////////
	//////   GET NAME FROM ID AND GET ID FROM NAMES   /////////////
	//////////////////////////////////////////////////////////////////	
	//////////////////////////////////////////////////////////////////
	// GET GROUPING NAME FROM GROUPING ID
	//////////////////////////////////////////////////////////////////
	function cmnGetGroupingNameByID($id)
	{
		$groupings = new Groupings();
		return $groupings->GetGroupingNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET GROUPING ID FROM GROUPING NAME
	//////////////////////////////////////////////////////////////////
	function cmnGetGroupingIDFromName($grouping_name)
	{
		$groupings = new Groupings();
		return $groupings->GetGroupingIDFromName($grouping_name);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET COMPANY NAME FROM COMPANY ID
	//////////////////////////////////////////////////////////////////
	function cmnGetCompanyNameByID($id)
	{
		$companies = new Companies();
		return $companies->GetCompanyNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET COMPANY ID FROM COMPANY NAME
	//////////////////////////////////////////////////////////////////
	function cmnGetCompanyIDFromName($company_name)
	{
		$companies = new Companies();
		return $companies->GetCompanyIDFromName($company_name);
	}
	
	
	//////////////////////////////////////////////////////////////////
	// GET LANGUAGE NAME FROM LANGUAGE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetLanguageNameByID($id)
	{
		$languages = new Languages();
		return $languages->GetLanguageNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET ORGANIZATION TYPE NAME FROM ORGANIZATION TYPE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetOrganizationTypeNameByID($id)
	{
		$org_type = new OrganizationTypes();
		return $org_type->GetOrganizationTypeNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET PROFESSIONAL TYPE NAME FROM PROFESSIONAL TYPE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetProfessionalTypeNameByID($id)
	{
		$pro_type = new ProfessionalTypes();
		return $pro_type->GetProfessionalTypeNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET RETAILER TYPE NAME FROM RETAILER TYPE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetRetailerTypeNameByID($id)
	{
		$ret_type = new RetailerTypes();
		return $ret_type->GetRetailerTypeNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET RETAILER TYPE ID FROM RETAILER TYPE NAME
	//////////////////////////////////////////////////////////////////
	function cmnGetretailerTyeIDFromName($retailer_type_name)
	{
		$ret_type = new RetailerTypes();		
		return $ret_type->GetretailerTyeIDFromName($retailer_type_name);
	}
	
	
	
	//////////////////////////////////////////////////////////////////
	// GET SERVICE NAME FROM SERVICE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetServiceNameByID($id)
	{
		$serv = new Services();
		return $serv->GetServiceNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET SERVICE ID FROM SERVICE NAME
	//////////////////////////////////////////////////////////////////
	function cmnGetServiceIDFromName($service_name)
	{
		$services = new Services();
		return $services->GetServiceIDFromName($service_name);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET SUBSCRIPTION NAME FROM SUBSCRIPTION ID
	//////////////////////////////////////////////////////////////////
	function cmnGetSubscriptionNameByID($id)
	{
		$subscription = new Subscriptions();
		return $subscription->GetSubscriptionNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET SUBSCRIPTION ID FROM SUBSCRIPTION NAME
	//////////////////////////////////////////////////////////////////
	function cmnGetSubcsriptionIDFromName($subscription_name)
	{
		$subscription = new Subscriptions();
		return $subscription->GetSubscriptionIDFromName($subscription_name);
	}
	
	
	//////////////////////////////////////////////////////////////////
	// GET SUPPLIER TYPE NAME FROM SUPPLIER TYPE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetSupplierTypeNameByID($id)
	{
		$supplier_type = new SupplierTypes();
		return $supplier_type->GetSupplierTypeNameByID($id);
	}
	
	//////////////////////////////////////////////////////////////////
	// GET USER NAME FROM USER ID
	//////////////////////////////////////////////////////////////////
	function cmnGetUserNameByID($id)
	{
		$user = new User();
		return $user->GetUserNameByID($id);		
	}
	
	//////////////////////////////////////////////////////////////////
	// GET USER TYPE NAME FROM USER TYPE ID
	//////////////////////////////////////////////////////////////////
	function cmnGetUserTypeNameByID($id)
	{
		$user_type = new UserTypes();		
		return $user_type->GetUserTypeNameByID($id);
	}
	
	
	
	
?>




