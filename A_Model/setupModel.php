<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setupmodel = isset($_POST['setupmodel']) ? $_POST['setupmodel'] : '';
	
	// 13 MAY 2021 JOSEPH ADORBOE 
	switch ($setupmodel)
	{

		// 12 JAN 2021  JOSPH ADORBOE 
		case 'modifyquantites':			
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';
			$pharmacyqty = isset($_POST['pharmacyqty']) ? $_POST['pharmacyqty'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		//	$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					if(empty($storeqty))
					{
						$storeqty = 0;
					}
					if(empty($pharmacyqty))
					{
						$pharmacyqty = 0;
					}
					if(empty($transferqty))
					{
						$transferqty = 0;
					}

					$validatestoreqty = $engine->getnumbervalidation($storeqty);
					if ($validatestoreqty == '1') {
						$status = 'error';
						$msg = "Store quantity value is invalid";
						return '0';
					}

					$validatepharmacyqty = $engine->getnumbervalidation($pharmacyqty);
					if ($validatepharmacyqty  == '1') {
						$status = 'error';
						$msg = "Pharmacy quantity value is invalid";
						return '0';
					}

					$validatetransferqty = $engine->getnumbervalidation($transferqty);
					if ($validatetransferqty == '1') {
						$status = 'error';
						$msg = "Transfer quantity value is invalid";
						return '0';
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}
	
						$totalqty = $storeqty + $transferqty + $pharmacyqty;
						if($totalqty < '0'){
							$status = 'error';
							$msg = "Total store qty cannot be less than zero ";
							return '0';
						}
						$stockvalue = $totalqty*$cashprice;
						if($stockvalue < '0'){
							$status = 'error';
							$msg = "Stock value cannot be zero or less";
							return '0';
						}
						$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					//	$ajustcode = md5(microtime());
					//	$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
					//	$expirycode = md5(microtime());
					//	$cashpricecode = md5(microtime());

						$add = $setupsql->setupstockqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue, $category,$currentuser, $currentusercode, $instcode);
						$title = 'Edit  Qty';
						if ($add == '0') {
							$status = "error";
							$msg = "$title $medication Unsuccessful";
						} elseif ($add == '1') {
							$status = "error";
							$msg = "$title $medication Exist";
						} elseif ($add == '2') {
							
							$event= "$title $medication successfully ";
							$eventcode= "232";
							$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
							if ($audittrail == '2') {
								$status = "success";
								$msg = "$title $medication Successfully";
							} else {
								$status = "error";
								$msg = "Audit Trail unsuccessful";
							}
						} else {
							$status = "error";
							$msg = "Unknown source ";
						}
					}
			//	}
			}
	
		break;	

		// 11 JAN 2023 JOSPH ADORBOE
		case 'removedevice':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->removedevices($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Remove Device ';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $devices Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $devices Exist"; 					
					}else if($edit == '2'){
						$event= " $title $devices  successfully ";
						$eventcode= "206";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $devices Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 28 DEC 2022  JOSPH ADORBOE
		case 'editimagingsetup':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$imaging = isset($_POST['imaging']) ? $_POST['imaging'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$devicenumber = isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
									
					$imaging = strtoupper($imaging);

					$edit = $setupsql->editnewimagingg($ekey,$imaging,$description,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Imaging';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $imaging Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $imaging Exist"; 					
					}else if($edit == '2'){
						$event= "$title $imaging   successfully ";
						$eventcode= "218";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $imaging  edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 27 DEC 2022  JOSPH ADORBOE
		case 'addimagingprice':			
			$imaging = isset($_POST['imaging']) ? $_POST['imaging'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';			
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';			
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$totalqty = isset($_POST['totalqty']) ? $_POST['totalqty'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($imaging) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$labnumber = $setupsql->getlastlabcodenumber($instcode);
					$imaging = strtoupper($imaging);
					$cashpricecode = md5(microtime());	
					$category = 7;
					$cash = 'CASH';
					if(empty($insuranceprice))
					{
						$insuranceprice = 0;
					}
					if(empty($dollarprice))
					{
						$dollarprice = 0;
					}
					// if(empty($alternateprice))
					// {
					// 	$alternateprice = 0;
					// }

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}

					$validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					if ($validatepartnerprice == '1') {
						$status = 'error';
						$msg = "Partner Prices value is invalid";
						return '0';
					}

					$alternateprice = $cashprice;					

					$add = $setupsql->addnewimagingsed($form_key,$imaging,$labnumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode);
					$title = 'Add Imaging';
					if($add == '0'){				
						$status = "error";					
						$msg = "$title $imaging Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "$title $imaging  Exist"; 					
					}else if($add == '2'){
						if($insuranceprice > '0'){
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $setupsql->setinsuranceprices($pricecode,$category,$form_key,$imaging,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
								}  
							}

						}
						$event= "$title $imaging successfully ";
						$eventcode= "217";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $imaging  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 27 DEC 2022  JOSPH ADORBOE 
		case 'addlabsprice':			
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';			
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';			
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$totalqty = isset($_POST['totalqty']) ? $_POST['totalqty'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($labs) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$labnumber = $setupsql->getlastlabcodenumber($instcode);
					$labs = strtoupper($labs);
					$cashpricecode = md5(microtime());	
					$category = 3;
					$cash = 'CASH';
					if(empty($insuranceprice))
					{
						$insuranceprice = 0;
					}
					if(empty($dollarprice))
					{
						$dollarprice = 0;
					}
					if(empty($partnercode))
					{
						$partnercode = 0;
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}

					$validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					if ($validatepartnerprice == '1') {
						$status = 'error';
						$msg = "Partner Prices value is invalid";
						return '0';
					}					
					$alternateprice = $cashprice;
					$add = $setupsql->addnewlabsed($form_key,$labs,$labnumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$partnercode,$currentuser,$currentusercode,$instcode);
					$title = 'Add Labs';
					if($add == '0'){				
						$status = "error";					
						$msg = "$title $labs Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "$title $labs  Exist"; 					
					}else if($add == '2'){
						if($insuranceprice > '0'){
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $setupsql->setinsuranceprices($pricecode,$category,$form_key,$labs,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
								}  
							}

						}
						$event= "$title $labs successfully ";
						$eventcode= "210";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $labs  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 25 DEC 2022  JOSPH ADORBOE
		case 'enablesetup':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->enablesetup($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Enable Setup';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "223";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 25 DEC 2022  JOSPH ADORBOE
		case 'disablesetup':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->disablesetup($ekey,$category,$currentuser,$currentusercode,$instcode);
					$title = 'Disable Setup';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "222";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 24 DEC 2022  JOSPH ADORBOE
		case 'enableprice':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->enableprice($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Enable Price';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "221";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 24 DEC 2022  JOSPH ADORBOE
		case 'disableprice':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$item = isset($_POST['item']) ? $_POST['item'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->disableprice($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Disable Price';
					if($edit == '0'){				
						$status = "error";					
						$msg = " $title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = " $title $item Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item  successfully ";
						$eventcode= "220";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;



		// 24 DEC 2022  JOSPH ADORBOE
		case 'addprocedureed':
			
			$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';			
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';			
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$totalqty = isset($_POST['totalqty']) ? $_POST['totalqty'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($procedure) || empty($description) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$procedurenumber = $setupsql->getlastprocedurecodenumber($instcode);
					$procedure = strtoupper($procedure);
					$cashpricecode = md5(microtime());	
					$category = 6;
					$cash = 'CASH';
					if(empty($insuranceprice))
					{
						$insuranceprice = 0;
					}
					if(empty($dollarprice))
					{
						$dollarprice = 0;
					}
					if(empty($alternateprice))
					{
						$alternateprice = 0;
					}

					if(empty($partnerprice))
					{
						$partnerprice = 0;
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}

					$validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					if ($validatepartnerprice == '1') {
						$status = 'error';
						$msg = "Partner Prices value is invalid";
						return '0';
					}


					$add = $setupsql->addnewprocedureed($form_key,$procedure,$procedurenumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode);
					$title = 'Add Procedure';
					if($add == '0'){				
						$status = "error";					
						$msg = "$title $procedure Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "$title $procedure  Exist"; 					
					}else if($add == '2'){
						if($insuranceprice > '0'){
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $setupsql->setinsuranceprices($pricecode,$category,$form_key,$procedure,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
								}  
							}

						}
						$event= "$title $procedure successfully ";
						$eventcode= "211";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $procedure  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;


		// 20 DEC 2022  JOSEPH ADORBOE 
		case 'addnewdevices':			
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';
			$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
			$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';
			$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';
			$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$expire = isset($_POST['expire']) ? $_POST['expire'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices) || empty($storeqty) || empty($costprice) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$devicenumber = $setupsql->getlastdevicecodenumber($instcode);
					$devices = strtoupper($devices);					
					
					// if (empty($transferqty)) {
					// 	$transferqty = 0;
					// }
					if (empty($insuranceprice)) {
						$insuranceprice = 0;
					}
					if (empty($dollarprice)) {
						$dollarprice = 0;
					}
					// if (empty($alternateprice)) {
					// 	$alternateprice = 0;
					// }

					$validatestoreqty = $engine->getnumbernonzerovalidation($storeqty);
					if ($validatestoreqty == '1') {
						$status = 'error';
						$msg = "Store quantity value is invalid";
						return '0';
					}

					$validaterestock = $engine->getnumbernonzerovalidation($restock);
					if ($validaterestock == '1') {
						$status = 'error';
						$msg = "Restock quantity value is invalid";
						return '0';
					}

					// $validatetransferqty = $engine->getnumbernonzerovalidation($transferqty);
					// if ($validatetransferqty == '1') {
					// 	$status = 'error';
					// 	$msg = "Restock quantity value is invalid";
					// 	return '0';
					// }

					$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
					if ($validatecostprice == '1') {
						$status = 'error';
						$msg = "Cost price value is invalid";
						return '0';
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Dollar Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}
					$transferqty = 0;
					$totalqty = $storeqty + $transferqty;
					if($totalqty < '0' || $totalqty == '0'){
						$status = 'error';
						$msg = "Total store qty cannot be less than zero ";
						return '0';
					}
					$stockvalue = $totalqty*$cashprice;
					if($stockvalue < '0' || $stockvalue == '0'){
						$status = 'error';
						$msg = "Stock value cannot be zero or less";
						return '0';
					}
					
					// $storeqty = $storeqty - $transferqty;	
					// $totalqty = $storeqty + $transferqty;
					// $stockvalue = $totalqty* $cashprice;
					$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
					$ajustcode = md5(microtime());
				//	$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
                	$expirycode = md5(microtime());	
					$cashpricecode = md5(microtime());	
					$alternateprice =$dollarprice =$partnerprice = '0.00';
								

					$add = $setupsql->setupnewdevices($form_key,$adjustmentnumber,$ajustcode,$devices,$devicenumber,$restock,$storeqty,$transferqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$days,$totalqty,$stockvalue,$expirycode,$expire,$category,$cashpricecode,$alternateprice,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$description,$partnerprice,$currentuser,$currentusercode,$instcode,$currentshift,$currentshiftcode);
					$title = 'Add Device';
					if($add == '0'){				
						$status = "error";					
						$msg = "$title $devices Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "$title $devices Exist"; 					
					}else if($add == '2'){
						if($insuranceprice > '0'){
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $setupsql->setinsuranceprices($pricecode,$category,$form_key,$devices,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
								}  
							}
	
						}
						$event= "$title $devices successfully ";
						$eventcode= "205";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $devices Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;


		

		// 14 APR 2022  JOSPH ADORBOE
		case 'deleteimaging':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$imaging = isset($_POST['imaging']) ? $_POST['imaging'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$imagingnumber = isset($_POST['imagingnumber']) ? $_POST['imagingnumber'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				

					$edit = $setupsql->deleteimaging($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Imaging';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $imaging Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $imaging  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $imaging successfully ";
						$eventcode= "219";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $imaging deleted Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 29 MAY 2022 JOSPH ADORBOE
		case 'editimaging':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$imaging = isset($_POST['imaging']) ? $_POST['imaging'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$imagingnumber = isset($_POST['imagingnumber']) ? $_POST['imagingnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging) || empty($partnercode) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($imagingnumber)){
						$imagingnumber = $coder->getimagingnumber($instcode);
						
					}					
					$imaging = strtoupper($imaging);

					$edit = $setupsql->editnewimaging($ekey,$imaging,$imagingnumber,$description,$partnercode,$mnum,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Imaging';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $imaging  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $imaging  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $imaging  successfully ";
						$eventcode= "218";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $imaging edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 29 MAY 2022 JOSPH ADORBOE
		case 'addimaging':			
			$imaging = isset($_POST['imaging']) ? $_POST['imaging'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($imaging) || empty($partnercode) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$imagingnumber = $coder->getimagingnumber($instcode);
					$imaging = strtoupper($imaging);

					$add = $setupsql->addnewimaging($form_key,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode);
					$title = 'Add Imaging';
					if($add == '0'){				
						$status = "error";					
						$msg = " $title $imaging Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "$title $imaging or $partnercode Exist"; 					
					}else if($add == '2'){
						$event= "$title $imaging successfully ";
						$eventcode= "217";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $imaging Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}	
		break;

		// 03 JUNE  2021 JOSPH ADORBOE
		case 'editsupplier':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$supplier = isset($_POST['supplier']) ? $_POST['supplier'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$suppliernumber = isset($_POST['suppliernumber']) ? $_POST['suppliernumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($supplier) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($suppliernumber)){
						$suppliernumber = $setupsql->getlastsuppliercodenumber($instcode);
					}					
					$supplier = strtoupper($supplier);

					$edit = $setupsql->editnewsupplier($ekey,$supplier,$suppliernumber,$description,$mnum,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Suppliers';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $supplier Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $supplier Exist"; 					
					}else if($edit == '2'){
						$event= " $title $supplier Successfully ";
						$eventcode= "46";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $supplier edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 03 JUNE 2021 JOSPH ADORBOE
		case 'addsupplier':
			
			$supplier = isset($_POST['supplier']) ? $_POST['supplier'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($supplier) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$suppliernumber = $setupsql->getlastsuppliercodenumber($instcode);
					$supplier = strtoupper($supplier);

					$add = $setupsql->addnewsupplier($form_key,$supplier,$suppliernumber,$description,$currentuser,$currentusercode,$instcode);
					$title = 'Add supplier';
					if($add == '0'){				
						$status = "error";					
						$msg = "".$title." ".$supplier."  Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "".$title." ".$supplier."  Exist"; 					
					}else if($add == '2'){
						$event= "".$title."  ".$supplier."  successfully ";
						$eventcode= "157";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$supplier."  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		

		// 15 MAY 2021 JOSPH ADORBOE
		case 'editprices':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$schemename = isset($_POST['schemename']) ? $_POST['schemename'] : '';
			$paycode = isset($_POST['paycode']) ? $_POST['paycode'] : '';
			$payname = isset($_POST['payname']) ? $_POST['payname'] : '';
			$item = isset($_POST['item']) ? $_POST['item'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
			$otherprice = isset($_POST['otherprice']) ? $_POST['otherprice'] : '';
			$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($price) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$otherprice = '0';
					$validatecostprice = $engine->getnumbernonzerovalidation($price);
					if ($validatecostprice == '1') {
						$status = 'error';
						$msg = "New price value is invalid";
						return '0';
					}

					$validatecashprice = $engine->getnumbernonzerovalidation($price);
					if ($validatecashprice == '1') {
						$status = 'error';
						$msg = "Cash Price value is invalid";
						return '0';
					}

					// $validatealtenate = $engine->getnumbervalidation($alternateprice);
					// if ($validatealtenate == '1') {
					// 	$status = 'error';
					// 	$msg = "Alternate Price Value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

				
					$edit = $setupsql->editnewprices($ekey,$price,$alternateprice,$otherprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Prices';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $item Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $item  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $item successfully ";
						$eventcode= "216";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $item Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 14 APR 2022 JOSPH ADORBOE
		case 'deletepaymentprice':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$schemename = isset($_POST['schemename']) ? $_POST['schemename'] : '';
			$paycode = isset($_POST['paycode']) ? $_POST['paycode'] : '';
			$payname = isset($_POST['payname']) ? $_POST['payname'] : '';
			$itemname = isset($_POST['itemname']) ? $_POST['itemname'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$otherprice = isset($_POST['otherprice']) ? $_POST['otherprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($price) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				
					$edit = $setupsql->deleteprices($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Prices';
					if($edit == '0'){				
						$status = "error";					
						$msg = "".$title." ".$itemname."  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "".$title." ".$itemname."  Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." ".$itemname."  successfully ";
						$eventcode= "215";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." ".$itemname." edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;


		
		// 16 MAY 2021 JOSEPH ADORBOE
		case 'setprices': 

			$billableservices = isset($_POST['billableservices']) ? $_POST['billableservices'] : '';
			$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
			$category = isset($_POST['category']) ? $_POST['category'] : '';
			$schemename = isset($_POST['schemename']) ? $_POST['schemename'] : '';
			$paycode = isset($_POST['paycode']) ? $_POST['paycode'] : '';
			$payname = isset($_POST['payname']) ? $_POST['payname'] : '';
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$device = isset($_POST['device']) ? $_POST['device'] : '';
			$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
			$scan = isset($_POST['scan']) ? $_POST['scan'] : '';
			$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
			$otherprice = isset($_POST['otherprice']) ? $_POST['otherprice'] : '';
			$dollarsprice = isset($_POST['dollarsprice']) ? $_POST['dollarsprice'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($category) || empty($price) ){	
					$status = "error";
					$msg = "Required Fields cannot be empty ";	
				}else{
					
					if($category == 1){
						$item = $billableservices;
					}else if($category == 3){
						$item = $labs;
					}else if($category == 2){
						$item = $medication;
					}else if($category == 5){
						$item = $device;
					}else if($category == 4){
						$item = $scan;
					}else if($category == 6){
						$item = $procedure;
					}
					

                    if (empty($item)) {
                        $status = "error";
						$msg = "Required Fields cannot be empty ";
                    }else{
						$itm = explode('@@@', $item);
                        $sercode = $itm[0];
                        $sername = $itm[1];
                        /*
                        $fac = explode('@@@', $paymentmethod);
                        $paycode = $fac[0];
                        $payname = $fac[1];

                        if(!empty($scheme)){
                            $fac = explode('@@@', $scheme);
                            $schcode = $fac[0];
                            $schname = $fac[1];
                        }else{
                            $schcode = $schname = '';
                        }
                        */

                        // if (empty($otherprice) || empty($alternateprice)) {
                        //     $alternateprice = $price;
                        //     $otherprice = $price;
                        // }
                    
                    
                        $addsinglepriceing = $setupsql->admin_singlepricing($form_key, $sercode, $sername, $paycode, $payname, $schemecode, $schemename, $price, $day, $category, $alternateprice, $otherprice, $dollarsprice,$currentusercode, $currentuser, $instcode);
                        $title = 'Add Price ';
                        if ($addsinglepriceing == '0') {
                            $status = "error";
                            $msg = "Add Price  ".$sername." to ".$payname." Unsuccessful";
                        } elseif ($addsinglepriceing == '1') {
                            $status = "error";
                            $msg = "Price ".$sername." to ".$payname." Exist";
                        } elseif ($addsinglepriceing == '2') {
                            $event= " ".$title." ".$sername."  successfully ";
                            $eventcode= "214";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = " ".$title." ".$sername." edited Successfully";
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Add Price Unsuccessful ";
                        }
                    }		
	
				}
	
			}
	
		break;
		
		// 15 MAY 2021 JOSPH ADORBOE
		case 'searchaddprice':			
			$item = isset($_POST['item']) ? $_POST['item'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($item) || empty($scheme) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sche = explode('@@@', $scheme);
					$schecode = $sche[0];
					$schename = $sche[1];
					$paycode = $sche[2];
					$payname = $sche[3];			
					$value = $item.'@@@'.$schecode.'@@@'.$schename.'@@@'.$paycode.'@@@'.$payname;
					$msql->passingvalues($pkey=$form_key,$value);					
					$url = "admin__addprice?$form_key";
					$engine->redirect($url);
				}				
			}	
		break;


		// 14 APR 2022  JOSPH ADORBOE
		case 'deleteprocedure':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$procedurenumber = isset($_POST['procedurenumber']) ? $_POST['procedurenumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				

					$edit = $setupsql->deleteprocedure($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Procedure';
					if($edit == '0'){				
						$status = "error";					
						$msg = "".$title." ".$procedure."  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "".$title." ".$procedure."  Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." ".$procedure."  successfully ";
						$eventcode= "213";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." ".$procedure." edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 15 MAY 2021 JOSPH ADORBOE
		case 'editprocedure':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$procedurenumber = isset($_POST['procedurenumber']) ? $_POST['procedurenumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($procedure) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($procedurenumber)){
						$procedurenumber = $setupsql->getlastprocedurecodenumber($instcode);
					}					
					$procedure = strtoupper($procedure);

					$edit = $setupsql->editnewprocedure($ekey,$procedure,$procedurenumber,$description,$mnum,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Procedure';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $procedure  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $procedure  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $procedure  successfully ";
						$eventcode= "212";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $procedure edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		
		// 13 MAY 2021 JOSPH ADORBOE
		case 'addprocedure':
			
			$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($procedure) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$procedurenumber = $setupsql->getlastprocedurecodenumber($instcode);
					$procedure = strtoupper($procedure);

					$add = $setupsql->addnewprocedure($form_key,$procedure,$procedurenumber,$description,$currentuser,$currentusercode,$instcode);
					$title = 'Add Procedure';
					if($add == '0'){				
						$status = "error";					
						$msg = "".$title." ".$procedure."  Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "".$title." ".$procedure."  Exist"; 					
					}else if($add == '2'){
						$event= "".$title."  ".$procedure."  successfully ";
						$eventcode= "211";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$procedure."  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 13 MAY 2021 JOSPH ADORBOE
		case 'addmedicallabs':
			
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$discpline = isset($_POST['discpline']) ? $_POST['discpline'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($labs) || empty($discpline) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$dose = explode('@@@', $discpline);
					$discplinecode = $dose[0];
					$discplinename = $dose[1];	
					
					$labsnumber = $setupsql->getlastlabcodenumber($instcode);
					$labs = strtoupper($labs);
					$partnecodecheck = $setupsql->checkpartnercode($partnercode,$instcode);
					if($partnecodecheck !== '2'){
						$status = 'error';
						$msg = "Partner code $partnercode already exist";	
					}else{
                        $add = $setupsql->addnewlabs($form_key, $labs, $labsnumber, $discplinecode, $discplinename, $description, $partnercode, $currentuser, $currentusercode, $instcode);
                        $title = 'Add Labs';
                        if ($add == '0') {
                            $status = "error";
                            $msg = "".$title." ".$labs."  Unsuccessful";
                        } elseif ($add == '1') {
                            $status = "error";
                            $msg = "".$title." ".$labs."  Exist";
                        } elseif ($add == '2') {
                            $event= "".$title."  ".$labs."  successfully ";
                            $eventcode= "210";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = "".$title." ".$labs."  Successfully";
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown source ";
                        }
                    }	
				}
			}
	
		break;

		// 14 APR 2022 JOSPH ADORBOE
		case 'deletelabs':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$displine = isset($_POST['displine']) ? $_POST['displine'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$labnumber = isset($_POST['labnumber']) ? $_POST['labnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$edit = $setupsql->deletelabs($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Labs';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title  $labs  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title  $labs  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $labs  successfully ";
						$eventcode= "209";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $labs edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 12 MAR 2023 JOSPH ADORBOE enablelabs
		case 'disablelabs':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$displine = isset($_POST['displine']) ? $_POST['displine'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$labnumber = isset($_POST['labnumber']) ? $_POST['labnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$edit = $setupsql->disable($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Disable Labs';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title  $labs  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title  $labs  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $labs  successfully ";
						$eventcode= "209";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $labs edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 12 MAR 2023 JOSPH ADORBOE 
		case 'enablelabs':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$displine = isset($_POST['displine']) ? $_POST['displine'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$labnumber = isset($_POST['labnumber']) ? $_POST['labnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$edit = $setupsql->enablelabs($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Enable Labs';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title  $labs  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title  $labs  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $labs  successfully ";
						$eventcode= "209";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $labs edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;


		// 14 MAY 2021 JOSPH ADORBOE
		case 'editlabs':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
			$displine = isset($_POST['displine']) ? $_POST['displine'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$labnumber = isset($_POST['labnumber']) ? $_POST['labnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($labs) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					// $dose = explode('@@@', $displine);
					// $discplinecode = $dose[0];
					// $discplinename = $dose[1];	
					$discplinecode=$discplinename='1';
					if(empty($labnumber)){
						$labnumber = $setupsql->getlastlabcodenumber($instcode);
					}					
					$labs = strtoupper($labs);
					$edit = $setupsql->editnewlabs($ekey,$labs,$labnumber,$discplinecode,$discplinename,$description,$mnum,$currentuser,$currentusercode,$instcode);
					$title = "Edit Labs";
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $labs  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $labs  Exist"; 					
					}else if($edit == '2'){
						$event= " $title $labs  successfully ";
						$eventcode= "208";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $labs  edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;




		// 14 MAY 2021 JOSPH ADORBOE
		case 'editdevices':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$devicenumber = isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($devices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($devicenumber)){
						$devicenumber = $setupsql->getlastdevicecodenumber($instcode);
					}					
					$devices = strtoupper($devices);
					$edit = $setupsql->editnewdevice($ekey,$devices,$devicenumber,$description,$qty,$mnum,$currentuser,$currentusercode,$instcode);
					$title = 'Edit Devices';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $devices Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $devices Exist"; 					
					}else if($edit == '2'){
						$event= "$title $devices   successfully ";
						$eventcode= "207";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title $devices  edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;

		// 14 APR 2022 JOSPH ADORBOE
		case 'deletedevice':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$devicenumber = isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{		
					
					$edit = $setupsql->deletedevice($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Devices';
					if($edit == '0'){				
						$status = "error";					
						$msg = "$title $devices Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "$title $devices Exist"; 					
					}else if($edit == '2'){
						$event= "$title $devices successfully ";
						$eventcode= "206";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title $devices edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;
		

		// 14 MAY 2021 JOSPH ADORBOE
		case 'adddevices':
			
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$devicenumber = $setupsql->getlastdevicecodenumber($instcode);
					$devices = strtoupper($devices);

					$add = $setupsql->addnewdevice($form_key,$devices,$devicenumber,$description,$qty,$currentuser,$currentusercode,$instcode);
					$title = 'Add Device';
					if($add == '0'){				
						$status = "error";					
						$msg = "".$title." ".$devices."  Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "".$title." ".$devices."  Exist"; 					
					}else if($add == '2'){
						$event= "".$title."  ".$devices."  successfully ";
						$eventcode= "205";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$devices."  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;


		// 13 MAY 2021 JOSPH ADORBOE
		case 'addmedications':
			
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
			$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$brandname = isset($_POST['brandname']) ? $_POST['brandname'] : '';
			$medicationdose = isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($medication) || empty($dosageform) || empty($restock) || empty($brandname) || empty($medicationdose) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$dose = explode('@@@', $dosageform);
					$dosageformcode = $dose[0];
					$dosageformname = $dose[1];	
					
					$unt = explode('@@@', $unit);
					$untcode = $unt[0];
					$untname = $unt[1];
					$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);
					$medication = strtoupper($medication);
					$brandname = strtoupper($brandname);
					$medication = $medication.' - '.$dosageformname.' - '.$medicationdose.' - '.$brandname ;

					$add = $setupsql->addnewmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$currentuser,$currentusercode,$instcode);
					$title = 'Add Medication';
					if($add == '0'){				
						$status = "error";					
						$msg = "".$title." ".$medication."  Unsuccessful"; 
					}else if($add == '1'){				
						$status = "error";					
						$msg = "".$title." ".$medication."  Exist"; 					
					}else if($add == '2'){
						$event= "".$title."  ".$medication."  successfully ";
						$eventcode= "202";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$medication."  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;		

		// 14 APR 2022  JOSPH ADORBOE
		case 'deletemedication':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
			$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
			$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
			$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
			$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
			$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
			$medicationnumber = isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '';
			$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $setupsql->deletemedication($ekey,$currentuser,$currentusercode,$instcode);
					$title = 'Delete Medication';
					if($edit == '0'){				
						$status = "error";					
						$msg = "".$title." ".$medication."  Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "".$title." ".$medication."  Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." ".$medication."  successfully ";
						$eventcode= "203";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." ".$medication." edited Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}			
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
					}	
				}
			}
	
		break;		
			
	}
	

?>
