<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE COMPANY
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['create']))
	{
		$company = new Companies();
		
		$company->grouping_id        		= $_POST['gid'];		
		$company->language_id        		= $_POST['lid'];
		$company->company_logo         		= $_POST['logo']; // OPTI-REP-TODO: Logo needs to be taken care of
		$company->company_name_fr 			= !empty($_POST['name_fr']) ? $_POST['name_fr'] : $_POST['name_en'];
		$company->company_name_en			= !empty($_POST['name_en']) ? $_POST['name_en'] : $_POST['name_fr'];
		$company->company_ressource_person	= $_POST['rp'];
		$company->company_email_general  	= $_POST['eg'];
		$company->company_email_sales    	= $_POST['es'];
		$company->company_description_fr 	= !empty($_POST['desc_fr']) ? $_POST['desc_fr'] : $_POST['desc_en'];
		$company->company_description_en 	= !empty($_POST['desc_en']) ? $_POST['desc_en'] : $_POST['desc_fr'];		
		
		// OPTI-REP-TODO: Complete the IsAlreadyCompany Check
		
		
		// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
		$company->created_by_id = 2;
		$company->modified_by_id = 2;
		
		echo $company->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE COMPANY
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['update']))
	{
		$company = new Companies();
		
		$company->company_id 				= $_POST['id'];
		$company->grouping_id        		= $_POST['gid'];
		$company->language_id        		= $_POST['lid'];
		$company->company_logo         		= $_POST['logo'];
		$company->company_name_fr 			= $_POST['name_fr'];
		$company->company_name_en			= $_POST['name_en'];
		$company->company_ressource_person	= $_POST['rp'];
		$company->company_email_general  	= $_POST['eg'];
		$company->company_email_sales    	= $_POST['es'];
		$company->company_description_fr 	= $_POST['desc_fr'];
		$company->company_description_en 	= $_POST['desc_en'];	
		
		$company->modified_by_id = 2;
		
		$company->Update();	
	}
	
		
	//////////////////////////////////////////////////////////////////
	// DELETE COMPANY
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['delete']))
	{
		if(!empty($_POST['cid']) || !empty($_POST['cids']))
		{
			$record_count_to_delete = 0;
			$addr_result 			= 0;
			$phn_result 			= 0;
			$ret_result 			= 0;
			$ret_comp_result		= 0;
			$comp_num_rows_del 		= 0;
				
			// CHECK HOW MANY RECORDS NEED TO BE DELETED AND ACT ACCORDINGLY.
			if(!empty($_POST['cid'])){ $record_count_to_delete = sizeof($_POST['cid']); }
			if(!empty($_POST['cids'])){ $record_count_to_delete = sizeof($_POST['cids']); }
				
			// TAKE CARE OF FOREIGN company_addresses TABLE BEFORE COMPANY DELETE
			// FOREIGN KEY CONSTRAINT. company_addresses TABLE WILL TRIGGER THE ADDRESS
			// DELETION IN THE addresses TABLE
			$comp_addr = new CompanyAddresses();
				
			if($record_count_to_delete == 1)
			{
				$addr_result = $comp_addr->DeleteCompanyAddress($_POST['cid']);
			}
			else if ($record_count_to_delete > 1)
			{
				$addr_result = $comp_addr->DeleteCompanyAddresses($_POST['cids']);
			}
				
			if($addr_result > 0)
			{
				// TAKE CARE OF FOREIGN company_phone_numbers TABLE BEFORE COMPANY DELETE
				// FOREIGN KEY CONSTRAINT. company_phone_numbers TABLE WILL TRIGGER THE
				// PHONE NUMBER DELETION IN THE phone_numbers TABLE
				$comp_phn = new CompanyPhoneNumbers();
	
				if($record_count_to_delete == 1)
				{
					$phn_result = $comp_phn->DeleteCompanyPhoneNumber($_POST['cid']);
				}
				else if ($record_count_to_delete > 1)
				{
					$phn_result = $comp_phn->DeleteCompanyPhoneNumbers($_POST['cids']);
				}
			}
			
			if($phn_result > 0)
			{
				// TAKE CARE OF FOREIGN retailers TABLE BEFORE COMPANY DELETE
				// UPDATE company_id FIELD TO null and keep retailer.
				$comp_ret = new CompanyRetailers();
				
				if($record_count_to_delete == 1)
				{
					$ret_comp_result = $comp_ret->UpdateCompanyRetailerOnCompanyDelete($_POST['cid']);
				}
				else if ($record_count_to_delete > 1)
				{
					$ret_comp_result = $comp_ret->UpdateCompanyRetailersOnCompanyDeletes($_POST['cids']);
				}
			}	
				
			// FINALY DELETE COMPANY.
			if(($addr_result > 0) && ($phn_result > 0) && ($ret_comp_result > 0))
			{
				$company = new Companies();
	
				if($record_count_to_delete == 1)
				{
					$company->company_id = $_POST['cid'];
					$comp_num_rows_del = $company->Delete();
				}
				else if ($record_count_to_delete > 1)
				{
					$comp_num_rows_del = $company->DeleteCompaniesByIDs($_POST['cids']);
				}
			}
				
			echo $comp_num_rows_del;
		}
	}
	
	
	
	
	//////////////////////////////////////////////////////////////////
	// COMPANY'S ADDRESS
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE COMPANY'S ADDRESS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['compaddr']))
	{
		if(!empty($_POST['cid']) && !empty($_POST['aid']))
		{
			$comp_addr = new CompanyAddresses();
			$comp_addr->InsertCompanyAddress($_POST['cid'], $_POST['aid']);
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// COMPANY'S PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE COMPANY'S PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['comppn']))
	{
		if(!empty($_POST['cid']) && !empty($_POST['pid']))
		{
			$ret_pn = new CompanyPhoneNumbers();
			$ret_pn->InsertCompanyPhoneNumber($_POST['cid'], $_POST['pid']);
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// GROUPING COMPANY
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE GROUPING COMPANY
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['groupcomp']))
	{
		if(!empty($_POST['gid']) && !empty($_POST['cid']))
		{
			$grouping_company = new GroupingCompanies();
			$grouping_company->InsertGroupingCompany($_POST['gid'], $_POST['cid']);
		}
	}
	
	
	
 ?>