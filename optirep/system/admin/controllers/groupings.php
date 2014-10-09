<?php
	//////////////////////////////////////////////////////////////////
	// LOAD RESOURCES
	//////////////////////////////////////////////////////////////////
	require_once('../../../config.php');
	

	//////////////////////////////////////////////////////////////////
	// CREATE GROUPING
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['create']))
	{
		$grouping = new Groupings();
		
		$grouping->grouping_id 				= $_POST['id'];		
		$grouping->language_id        		= $_POST['lid'];
		$grouping->grouping_logo         	= $_POST['logo']; // OPTI-REP-TODO: Logo needs to be taken care of
		$grouping->grouping_name_fr 		= !empty($_POST['name_fr']) ? $_POST['name_fr'] : $_POST['name_en'];
		$grouping->grouping_name_en			= !empty($_POST['name_en']) ? $_POST['name_en'] : $_POST['name_fr'];
		$grouping->grouping_email_general  	= $_POST['eg'];
		$grouping->grouping_email_sales    	= $_POST['es'];
		$grouping->grouping_description_fr 	= !empty($_POST['desc_fr']) ? $_POST['desc_fr'] : $_POST['desc_en'];
		$grouping->grouping_description_en 	= !empty($_POST['desc_en']) ? $_POST['desc_en'] : $_POST['desc_fr'];

		// OPTI-REP-TODO: Complete the IsAlreadyGrouping Check
		
		// OPTI-REP-TODO: created_by_id and modified_by_id need to be set to logged in user.
		$grouping->created_by_id = 2;
		$grouping->modified_by_id = 2;
		
		echo $grouping->Create();
		
	}
	
	//////////////////////////////////////////////////////////////////
	// UPDATE GROUPING
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['update']))
	{
		$grouping = new Groupings();
		
		$grouping->grouping_id 				= $_POST['id'];		
		$grouping->language_id        		= $_POST['l_id'];
		$grouping->grouping_logo         	= $_POST['logo'];
		$grouping->grouping_name_fr 		= $_POST['fr'];
		$grouping->grouping_name_en			= $_POST['en'];
		$grouping->grouping_email_general  	= $_POST['eg'];
		$grouping->grouping_email_sales    	= $_POST['es'];
		$grouping->grouping_description_fr 	= $_POST['desc_fr'];
		$grouping->grouping_description_en 	= $_POST['desc_en'];
		
		$grouping->modified_by_id = 2;
		
		$grouping->Update();	
	}	
	
	//////////////////////////////////////////////////////////////////
	// DELETE GROUPING
	//////////////////////////////////////////////////////////////////
	if(isset($_GET['delete']))
	{
		if(!empty($_POST['gid']) || !empty($_POST['gids']))
		{
			$record_count_to_delete = 0;
			$addr_result 			= 0;
			$phn_result 			= 0;
			$ret_result 			= 0;
			$grp_comp_result		= 0;
			$grp_num_rows_del 		= 0;
	
			// CHECK HOW MANY RECORDS NEED TO BE DELETED AND ACT ACCORDINGLY.
			if(!empty($_POST['gid'])){ $record_count_to_delete = sizeof($_POST['gid']); }
			if(!empty($_POST['gids'])){ $record_count_to_delete = sizeof($_POST['gids']); }
	
			// TAKE CARE OF FOREIGN grouping_addresses TABLE BEFORE GROUPING DELETE
			// FOREIGN KEY CONSTRAINT. grouping_addresses TABLE WILL TRIGGER THE ADDRESS
			// DELETION IN THE addresses TABLE
			$grp_addr = new GroupingAddresses();
	
			if($record_count_to_delete == 1)
			{
				$addr_result = $grp_addr->DeleteGroupingAddress($_POST['gid']);
			}
			else if ($record_count_to_delete > 1)
			{
				$addr_result = $grp_addr->DeleteGroupingAddresses($_POST['gids']);
			}
	
			if($addr_result > 0)
			{
				// TAKE CARE OF FOREIGN grouping_phone_numbers TABLE BEFORE GROUPING DELETE
				// FOREIGN KEY CONSTRAINT. grouping_phone_numbers TABLE WILL TRIGGER THE
				// PHONE NUMBER DELETION IN THE phone_numbers TABLE
				$grp_phn = new GroupingPhoneNumbers();
	
				if($record_count_to_delete == 1)
				{
					$phn_result = $grp_phn->DeleteGroupingPhoneNumber($_POST['gid']);
				}
				else if ($record_count_to_delete > 1)
				{
					$phn_result = $grp_phn->DeleteGroupingPhoneNumbers($_POST['gids']);
				}
			}
				
			if($phn_result > 0)
			{
				// TAKE CARE OF FOREIGN companies TABLE BEFORE GROUPING DELETE
				// UPDATE grouping_id FIELD TO null and keep company.
				$grp_comp = new GroupingCompanies();
	
				if($record_count_to_delete == 1)
				{
					$grp_comp_result = $grp_comp->UpdateGroupingCompanyOnGroupingDelete($_POST['gid']);
				}
				else if ($record_count_to_delete > 1)
				{
					$grp_comp_result = $grp_comp->UpdateGroupingCompaniesOnGroupingDeletes($_POST['gids']);
				}
			}
	
			// FINALY DELETE GROUPING.
			if(($addr_result > 0) && ($phn_result > 0) && ($grp_comp_result > 0))
			{
				$grouping = new Groupings();
	
				if($record_count_to_delete == 1)
				{
					$grouping->grouping_id = $_POST['gid'];
					$grp_num_rows_del = $grouping->Delete();
				}
				else if ($record_count_to_delete > 1)
				{
					$grp_num_rows_del = $grouping->DeleteGroupingsByID($_POST['gids']);
				}
			}
	
			echo $grp_num_rows_del;
		}
	}
 ?>