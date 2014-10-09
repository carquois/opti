<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['create']))
	{
		$retailer = new Retailers();
		
		//$image = addslashes(file_get_contents($_FILE['image']['tmp_name']));		
		
		$retailer->retailer_is_active = 1; // SET 1 FOR ACTIVE(DEFAULT).
		$retailer->retailer_is_head_office = $_POST['ho'];
		$retailer->retailer_type_id = $_POST['tid'];
		$retailer->grouping_id = $_POST['gid'];
		$retailer->company_id = $_POST['cid'];
		$retailer->language_id = $_POST['lid'];
		$retailer->retailer_logo = $_POST['logo']; // OPTI-REP-TODO: Logo needs to be taken care of
		$retailer->retailer_name_fr = !empty($_POST['name_fr']) ? $_POST['name_fr'] : $_POST['name_en'];
		$retailer->retailer_name_en = !empty($_POST['name_en']) ? $_POST['name_en'] : $_POST['name_fr'];
		$retailer->retailer_ressource_person = $_POST['rp'];
		$retailer->retailer_founded_year = $_POST['fy'];
		$retailer->retailer_number_employes = $_POST['ne'];
		$retailer->retailer_revenue = $_POST['rev'];
		$retailer->retailer_email_general = $_POST['eg'];
		$retailer->retailer_website_url = $_POST['wu'];
		$retailer->retailer_facebook = $_POST['fb'];
		$retailer->retailer_twitter = $_POST['twt'];
		$retailer->retailer_linkedin = $_POST['li'];
		$retailer->retailer_description_fr = !empty($_POST['desc_fr']) ? $_POST['desc_fr'] : $_POST['desc_en'];
		$retailer->retailer_description_en = !empty($_POST['desc_en']) ? $_POST['desc_en'] : $_POST['desc_fr'];
		
// 		if($retailer->IsAlreadyRetailer()) // OPTI-REP-TODO: Complete the IsAlreadyRetailer Check
// 		{			
// 			echo true;
// 			return;
// 		}
		
		// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
		$retailer->created_by_id = 2;
		$retailer->modified_by_id = 2; 
		
		echo $retailer->Create();  // Returns newly created ID
	}
	
	
	//////////////////////////////////////////////////////////////////
	// UPDATE RETAILER
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['update']))
	{
		$retailer = new Retailers();
		
		$retailer->retailer_is_head_office = $_POST['ho'];
		$retailer->retailer_id = $_POST['id'];
		$retailer->retailer_type_id = $_POST['tid'];
		$retailer->grouping_id = $_POST['gid'];
		$retailer->company_id = $_POST['cid'];
		$retailer->language_id = $_POST['lid'];
		$retailer->retailer_logo = $_POST['logo'];
		$retailer->retailer_name_fr = $_POST['name_fr'];
		$retailer->retailer_name_en = $_POST['name_en'];
		$retailer->retailer_ressource_person = $_POST['rp'];
		$retailer->retailer_founded_year = $_POST['fy'];
		$retailer->retailer_number_employes = $_POST['ne'];
		$retailer->retailer_revenue = $_POST['rev'];
		$retailer->retailer_email_general = $_POST['eg'];
		$retailer->retailer_website_url = $_POST['wu'];
		$retailer->retailer_facebook = $_POST['fb'];
		$retailer->retailer_twitter = $_POST['twt'];
		$retailer->retailer_linkedin = $_POST['li'];
		$retailer->retailer_description_fr = $_POST['desc_fr'];
		$retailer->retailer_description_en = $_POST['desc_en'];
		
		$retailer->modified_by_id = 2;
		
		$retailer->Update();	
	}
	
	
	//////////////////////////////////////////////////////////////////
	// DELETE RETAILER
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['delete']))
	{	
		if(!empty($_POST['rid']) || !empty($_POST['rids']))
		{
			$record_count_to_delete = 0;
			$addr_result = 0;
			$phn_result = 0;
			$ret_num_rows_del = 0;
			
			// CHECK HOW MANY RECORDS NEED TO BE DELETED AND ACT ACCORDINGLY.
			if(!empty($_POST['rid'])){ $record_count_to_delete = sizeof($_POST['rid']); }
			if(!empty($_POST['rids'])){ $record_count_to_delete = sizeof($_POST['rids']); }
			
			// TAKE CARE OF FOREIGN retailer_addresses TABLE BEFORE RETAILER DELETE
			// FOREIGN KEY CONSTRAINT. retailer_addresses TABLE WILL TRIGGER THE ADDRESS
			// DELETION IN THE addresses TABLE
			$ret_addr = new RetailerAddresses();
			
			if($record_count_to_delete == 1)
			{			
				$addr_result = $ret_addr->DeleteRetailerAddress($_POST['rid']);
			}
			else if ($record_count_to_delete > 1)
			{
				$addr_result = $ret_addr->DeleteRetailerAddresses($_POST['rids']);				
			}
			
			if($addr_result > 0)
			{
				// TAKE CARE OF FOREIGN retailer_phone_numbers TABLE BEFORE RETAILER DELETE
				// FOREIGN KEY CONSTRAINT. retailer_phone_numbers TABLE WILL TRIGGER THE
				// PHONE NUMBER DELETION IN THE phone_numbers TABLE
				$ret_phn = new RetailerPhoneNumbers();
				
				if($record_count_to_delete == 1)
				{
					$phn_result = $ret_phn->DeleteRetailerPhoneNumber($_POST['rid']);
				}
				else if ($record_count_to_delete > 1)
				{
					$phn_result = $ret_phn->DeleteRetailerPhoneNumbers($_POST['rids']);
				}
			}			
			
			// PLEASE NOTE THAT ENTRIES IN retailer_services, retailer_subscriptions AND company_retailers
			// ARE DELETED THRU SQL FOREIGN KEY ACTIONS ON DELETE CASCADE.		
			
			
			// FINALY DELETE RETAILER.
			if(($addr_result > 0) && ($phn_result > 0))
			{			
				$retailer = new Retailers();
				
				if($record_count_to_delete == 1)
				{
					$retailer->retailer_id = $_POST['rid'];
					$ret_num_rows_del = $retailer->Delete();
				}
				else if ($record_count_to_delete > 1)
				{
					$ret_num_rows_del = $retailer->DeleteRetailersByIDs($_POST['rids']);
				}
			}
			
			echo $ret_num_rows_del;
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// RETAILER'S ADDRESS
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER'S ADDRESS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['retaddr']))
	{
		if(!empty($_POST['aid']) && !empty($_POST['rid']))
		{
			$ret_addr = new RetailerAddresses();
			$ret_addr->InsertRetailerAddress($_POST['rid'], $_POST['aid']);
		}
	}	
	
		
	//////////////////////////////////////////////////////////////////
	// RETAILER'S PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER'S PHONE NUMBERS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['retpn']))
	{
		if(!empty($_POST['pid']) && !empty($_POST['rid']))
		{
			$ret_pn = new RetailerPhoneNumbers();
			$ret_pn->InsertRetailerPhoneNumber($_POST['rid'], $_POST['pid']);
		}
	}

	//////////////////////////////////////////////////////////////////
	// COMPANY RETAILER
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE COMPANY RETAILER
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['compret']))
	{
		if(!empty($_POST['cid']) && !empty($_POST['rid']))
		{
			$comp_ret = new CompanyRetailers();
			$comp_ret->InsertCompanyRetailer($_POST['cid'], $_POST['rid']);
		}
	}

	//////////////////////////////////////////////////////////////////
	// RETAILER'S SERVICES
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER'S SERVICES
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['retsrv']))
	{
		if(!empty($_POST['srvids']))
		{			
			$ret_srv = new RetailerServices();
			
			foreach($_POST['srvids'] as $srvid=>$retid)
			{
				$ret_srv->InsertRetailerService($retid, $srvid);			
			}
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE RETAILER'S SERVICES
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['uptretsrv']))
	{
		if(!empty($_POST['srvids']) && !empty($_POST['rid']))
		{
			$ret_srv = new RetailerServices();
			
			$ret_srv->DeleteRetailerServices($_POST['rid']);
					
			foreach($_POST['srvids'] as $srvid)
			{
				$ret_srv->InsertRetailerService($_POST['rid'], $srvid);
			}
		}
	}	
	

	//////////////////////////////////////////////////////////////////
	// RETAILER'S SUBSCRIPTIONS
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	// CREATE RETAILER'S SUBSCRIPTIONS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['retsubs']))
	{
		if(!empty($_POST['subsids']))
		{
			$ret_subs = new RetailerSubscriptions();
			
			foreach($_POST['subsids'] as $subsid=>$retid)
			{
				$ret_subs->InsertRetailerSubscription($retid, $subsid);
			}
		}
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE RETAILER'S SUBSCRIPTIONS
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['uptretsubs']))
	{
		if(!empty($_POST['subsids']) && !empty($_POST['rid']))
		{
			$ret_subs = new RetailerSubscriptions();
				
			$ret_subs->DeleteRetailerSubscriptions($_POST['rid']);
			
			foreach($_POST['subsids'] as $subid)
			{
				$ret_subs->InsertRetailerSubscription($_POST['rid'], $subid);
			}
		}
	}
	
	
?>