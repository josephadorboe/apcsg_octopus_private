<?php
	REQUIRE_ONCE (INTFILE);
	
	$requestionmodel = isset($_POST['requestionmodel']) ? $_POST['requestionmodel'] : '';

switch ($requestionmodel)
{


	// 20 MAY 2023  JOSEPH ADORBOE  
	case 'bulktransferdevicesstores':										
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
													
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];							
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$itemqty = $kt['4'];
					$transferqty = $kt['5'];
				//	$cashprice = $kt['6'];
					
					if(!empty($suppliedqty) && !empty($itemcode)){

						if(!is_numeric($suppliedqty)){
							$status = "error";
							$msg = "Quantity MUST be a Number Only ";
						}else if($suppliedqty < 0 || $suppliedqty == 0){
							$status = "error";
							$msg = "Quantity cannot be zero or less ";
						}else{	
							$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
							if ($validateqty == '1') {
								$status = 'error';
								$msg = "Qty value is invalid";
								return '0';
							}
							

							$type = 5;	
							$transferqty = 0;
							$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
							$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
							$expirycode = md5(microtime());
							$ajustcode = md5(microtime());
							$cashpricecode = md5(microtime());
						//	$alternateprice = $partnerprice = $newprice;
							$category = 2;
							$newstoreqty = $storeqty - $suppliedqty;
							$newtransferqty = $transferqty + $suppliedqty;
							$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
							$unit = 1;							
								// $editpricing = $requestionsql->transferstockmovement($form_key,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$day,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);

								$editpricing = $medsql->transferbulkmedication($type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);

								$title = "$item Transfer Stores ";
								if($editpricing == '0'){					
									$status = "error";					
									$msg = "$title Unsuccessful"; 
								}else if($editpricing == '1'){				
									$status = "error";					
									$msg = "$title  Exist"; 					
								}else if($editpricing == '2'){
									$event= " $title   successfully ";
									$eventcode= "231";
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
									if($audittrail == '2'){				
										$status = "success";
										$msg = " $title  Successfully";
									}else{
										$status = "error";
										$msg = "Audit Trail unsuccessful";	
									}						
								}else{					
									$status = "error";					
									$msg = "Unsuccessful source "; 					
								}
						//	}						
							
						}
					}
				}
			}
	break;


	// 16 MAY 2023  JOSEPH ADORBOE  
	case 'bulkrestockdevicesstores':
										
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
													
				foreach($_POST["scheckbox"] as $key => $value){
					$suppliedqty = $_POST["suppliedqty"][$key];
					$costprice = $_POST["costprice"][$key];
					$newprice = $_POST["newprice"][$key];
					$dollarprice = $_POST["dollarprice"][$key];
					$insuranceprice = $_POST["insuranceprice"][$key];
					$expire = $_POST["expire"][$key];						
					$kt = explode('@@@',$value);
					$itemcode = $kt['0'];
					$itemnumber = $kt['1'];
					$item = $kt['2'];
					$storeqty = $kt['3'];
					$itemqty = $kt['4'];
					$unit = $kt['5'];
					$cashprice = $kt['6'];
					
					if(!empty($suppliedqty) && !empty($itemcode)){

						if(!is_numeric($suppliedqty) || !is_numeric($costprice) || !is_numeric($newprice)){
							$status = "error";
							$msg = "Quantity MUST be a Number Only ";
						}else if($suppliedqty < 0 || $suppliedqty == 0){
							$status = "error";
							$msg = "Quantity cannot be zero or less ";
						}else{	
							$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
							if ($validateqty == '1') {
								$status = 'error';
								$msg = "Qty value is invalid";
								return '0';
							}
											
							$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
							if ($validatecostprice == '1') {
								$status = 'error';
								$msg = "Cost Price value is invalid";
								return '0';
							}

							$validatenewprice = $engine->getnumbernonzerovalidation($newprice);
							if ($validatenewprice == '1') {
								$status = 'error';
								$msg = "New Price value is invalid";
								return '0';
							}
							
							$validatedollarprice = $engine->getnumbervalidation($dollarprice);
							if ($validatedollarprice == '1') {
								$status = 'error';
								$msg = "Dollar Price value is invalid";
								return '0';
							}

							$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
							if ($validateinsuranceprice == '1') {
								$status = 'error';
								$msg = "Insurance Price value is invalid";
								return '0';
							}

							//

							$type = 4;	
							$transferqty = 0;
							$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
							$newqty = $storeqty + $suppliedqty;
							$totalqty = $newqty + $transferqty + $itemqty; 
							$stockvalue = $totalqty * $newprice;
							$expirycode = md5(microtime());
							$ajustcode = md5(microtime());
							$cashpricecode = md5(microtime());
							$alternateprice = $partnerprice = $newprice;
							$category = 5;
							
							if ($expire < $day) {
								$status = "error";
								$msg = " Stock expiry date cannot be before $day  Unsuccessful";
							} else {
								//$editpricing = $requestionsql->restockstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode);
						
								$editpricing = $requestionsql->restockstockmovementbulk($form_key,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);
								$title = "$item Restock Stores ";
								if($editpricing == '0'){					
									$status = "error";					
									$msg = "$title Unsuccessful"; 
								}else if($editpricing == '1'){				
									$status = "error";					
									$msg = "$title  Exist"; 					
								}else if($editpricing == '2'){
									$event= " $title   successfully ";
									$eventcode= "231";
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
									if($audittrail == '2'){				
										$status = "success";
										$msg = " $title  Successfully";
									}else{
										$status = "error";
										$msg = "Audit Trail unsuccessful";	
									}						
								}else{					
									$status = "error";					
									$msg = "Unsuccessful source "; 					
								}
							}						
							
						}
					}
				}
			}
	break;



	// 19 DEC 2022 JOSPH ADORBOE editprices
	case 'editprices':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$item = isset($_POST['item']) ? $_POST['item'] : '';
		$paycode = isset($_POST['paycode']) ? $_POST['paycode'] : '';
		$payname = isset($_POST['payname']) ? $_POST['payname'] : '';
		$itemname = isset($_POST['itemname']) ? $_POST['itemname'] : '';
		$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
		$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';
		$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';
		$totalqty = isset($_POST['totalqty']) ? $_POST['totalqty'] : '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
		$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($cashprice) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{	
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
					// if(empty($partnerprice))
					// {
					// 	$partnerprice = 0;
					// }
					if($category == 3 || $category == 1 || $category == 6 || $category == 7){
						$costprice = $cashprice;
					}

				
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
						$msg = "Doallar Prices value is invalid";
						return '0';
					}

					$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
					if ($validateinsuranceprice == '1') {
						$status = 'error';
						$msg = "Insurance Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }

					
				$totalqty = $storeqty + $itemqty + $transferqty;
				$stockvalue = $totalqty	*$cashprice;
				if($category !== '3' && $category !== '6' && $category !== '7'){
					$partnerprice = $alternateprice = 0;
				}
				$alternateprice = $cashprice;
				$cashpricecode = md5(microtime());	
				$edit = $requestionsql->editnewprices($ekey,$itemcode,$itemname,$cashpricecode,$cashschemecode,$stockvalue,$costprice,$cashprice,$alternateprice,$insuranceprice,$dollarprice,$category,$cashpaymentmethodcode,$cashpaymentmethod,$privateinsurancecode,$currentuser,$currentusercode,$instcode,$partnerprice);
				$title = 'Edit Prices';
				if($edit == '0'){				
					$status = "error";					
					$msg = " $title $item  Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = " $title $item  Exist"; 					
				}else if($edit == '2'){
					//if($insuranceprice > '0'){
						if (!empty($_POST["scheckbox"])) {
							foreach ($_POST["scheckbox"] as $schemes) {
								$pricecode = md5(microtime());	
								$req = explode('@@@', $schemes);
								$schemecode = $req['0'];
								$schemename = $req['1'];
								$insurancecode = $req['2'];
								$insurancename = $req['3'];                       
								$ins = $setupsql->setinsuranceprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
							}  
						}

				//	}
					$event= " $title $item  successfully ";
					$eventcode= "216";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title $item edited Successfully";
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

	// 25 OCT 2022  JOSEPH ADORBOE  
	case 'returndevicesfromstores':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';	
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
		$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';	
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
		$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';	
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
		$type = isset($_POST['type']) ? $_POST['type'] : '';	
		$category = isset($_POST['category']) ? $_POST['category'] : '';				
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if(!is_numeric($suppliedqty)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else if($suppliedqty>$itemqty){
					$status = "error";
					$msg = "Quantity in Pharmacy NOT sufficent for this return ";
				}else{	
				$type = 6;	
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $itemqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $cashprice;
                
				$expire = date('Y-m-d', strtotime($day. '+ 6 months'));
                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
			//	$arrayparameters = array($ekey,$type,$suppliedqty,$currentusercode,$currentuser,$instcode);				
				$editpricing = $requestionsql->returnstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newqty,$expire,$ajustcode,$adjustmentnumber,$days,$unit,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
				$title = "$item Restock Stores ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "224";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
		}

	break;


	// 25 OCT 2022  JOSEPH ADORBOE  
	case 'transferdevicestocks':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';	
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
		$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';	
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
		$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';	
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
		$type = isset($_POST['type']) ? $_POST['type'] : '';	
		$category = isset($_POST['category']) ? $_POST['category'] : '';	
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if(!is_numeric($suppliedqty)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else if($suppliedqty>$storeqty){
					$status = "error";
					$msg = "Quantity in store NOT sufficent for this transfer ";
				}else{	
			//	$type = 5;	
			$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
			$newstoreqty = $storeqty - $suppliedqty;
			$newtransferqty = $transferqty + $suppliedqty;
			$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
			$stockvalue = $totalqty * $cashprice;               
			$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
		//    $expirycode = md5(microtime());
			$ajustcode = md5(microtime());

			$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
			if ($validatesuppliedqty == '1') {
				$status = 'error';
				$msg = "Qty value is invalid";
				return '0';
			}

			if ($expire < $day) {
				$status = "error";
				$msg = " Stock expiry date cannot be before $day  Unsuccessful";
			} else {		
				
			$editpricing = $requestionsql->transferstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
				$title = "$item Device Transfer ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "225";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
		}

	break;

	// 25 OCT 2022  JOSEPH ADORBOE  
	case 'restockdevicestores':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';	
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
		$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';			
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
		$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';		
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
		$type = isset($_POST['type']) ? $_POST['type'] : '';	
		$category = isset($_POST['category']) ? $_POST['category'] : '';	
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
		$expire = isset($_POST['expire']) ? $_POST['expire'] : '';
		$alternateprice = isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '';
		$partnerprice = isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '';
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';
		$dollarprice = isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '';	
		$insuranceprice = isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '';	
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) || empty($costprice) || empty($newprice) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if(!is_numeric($suppliedqty) || !is_numeric($costprice) || !is_numeric($newprice)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else{	
					$validateqty = $engine->getnumbernonzerovalidation($suppliedqty);
					if ($validateqty == '1') {
						$status = 'error';
						$msg = "Qty value is invalid";
						return '0';
					}

					$validatecostprice = $engine->getnumbernonzerovalidation($costprice);
					if ($validatecostprice == '1') {
						$status = 'error';
						$msg = "Cost Price value is invalid";
						return '0';
					}

					$validatenewprice = $engine->getnumbernonzerovalidation($newprice);
					if ($validatenewprice == '1') {
						$status = 'error';
						$msg = "New Price value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Price value is invalid";
					// 	return '0';
					// }

					$validatedollarprice = $engine->getnumbervalidation($dollarprice);
					if ($validatedollarprice == '1') {
						$status = 'error';
						$msg = "Dollar Price value is invalid";
						return '0';
					}
			//	$type = 4;	
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $storeqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $newprice;

                // $exp = explode('/', $expirydate);
                // $dd = $exp['1'];
                // $mm = $exp['0'];
                // $yy = $exp['2'];
                // $expire = $yy.'-'.$mm.'-'.$dd;

				//$expire  = date('Y-m-d', strtotime($day. '+ 6 months'));
                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());
				$cashpricecode = md5(microtime());

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day Unsuccessful";
                } else {
			//	$arrayparameters = array($ekey,$type,$suppliedqty,$currentusercode,$currentuser,$instcode);				
				$editpricing = $requestionsql->restockstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice);

				// restockstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode);
				$title = "$item Restock Stores ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "226";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
		}

	break;


	// 18 OCT 2022   JOSEPH ADORBOE  
	case 'rejecttransfers':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';
		$item = isset($_POST['item']) ? $_POST['item'] : '';
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$rejectreason = isset($_POST['rejectreason']) ? $_POST['rejectreason'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($rejectreason) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
						
				$editpricing = $requestionsql->rejecttransfer($ekey,$rejectreason,$days,$itemqty,$itemcode,$type,$currentusercode,$currentuser,$instcode);
			//	$title = "$item ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$item Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$item Exist"; 					
				}else if($editpricing == '2'){
					$event= " $item Rejected successfully ";
					$eventcode= "227";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $item rejected Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			
			}
		}

	break;

	// 18 OCT 2022   JOSEPH ADORBOE  
	case 'accepttransfers':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';
		$item = isset($_POST['item']) ? $_POST['item'] : '';
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				if(!is_numeric($suppliedqty)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else if($suppliedqty != $itemqty){
					$status = "error";
					$msg = "Quantity in Pharmacy NOT same ";
				}else{		
									
				$editpricing = $requestionsql->accepttransfer($ekey,$itemcode,$itemqty,$type,$days,$currentusercode,$currentuser,$instcode);
				$title = "$item Qty $suppliedqty ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title added successfully ";
					$eventcode= "228";
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
					$msg = "Unsuccessful source "; 					
				}
			}
			}
		}

	break;
	
	// 17 OCT 2022  JOSEPH ADORBOE  
	case 'returnfromstores':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';	
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
		$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';	
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
		$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';	
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
		$type = isset($_POST['type']) ? $_POST['type'] : '';	
		$category = isset($_POST['category']) ? $_POST['category'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if(!is_numeric($suppliedqty)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else if($suppliedqty>$itemqty){
					$status = "error";
					$msg = "Quantity in Pharmacy NOT sufficent for this return ";
				}else{	
			//	$type = 3;	
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $itemqty + $suppliedqty;
				$totalqty = $newqty + $transferqty + $itemqty; 
				$stockvalue = $totalqty * $cashprice;

                
				$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
                $expirycode = md5(microtime());
				$ajustcode = md5(microtime());

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
			//	$arrayparameters = array($ekey,$type,$suppliedqty,$currentusercode,$currentuser,$instcode);				
				$editpricing = $requestionsql->returnstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newqty,$expire,$ajustcode,$adjustmentnumber,$days,$unit,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
				$title = "$item Return to Stores ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "229";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
		}

	break;
	
	// 17 OCT 2022  JOSEPH ADORBOE  
	case 'transfermedicationstocks':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';	
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';	
		$itemnumber = isset($_POST['itemnumber']) ? $_POST['itemnumber'] : '';	
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';	
		$itemqty = isset($_POST['itemqty']) ? $_POST['itemqty'] : '';	
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';	
		$costprice = isset($_POST['costprice']) ? $_POST['costprice'] : '';			
		$newprice = isset($_POST['newprice']) ? $_POST['newprice'] : '';	
		$cashprice = isset($_POST['cashprice']) ? $_POST['cashprice'] : '';	
		$transferqty = isset($_POST['transferqty']) ? $_POST['transferqty'] : '';	
		$type = isset($_POST['type']) ? $_POST['type'] : '';	
		$category = isset($_POST['category']) ? $_POST['category'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if(!is_numeric($suppliedqty)){
					$status = "error";
					$msg = "Quantity MUST be a Number Only ";
				}else if($suppliedqty < 0 || $suppliedqty == 0){
					$status = "error";
					$msg = "Quantity cannot be zero or less ";
				}else if($suppliedqty>$storeqty){
					$status = "error";
					$msg = "Quantity in store NOT sufficent for this transfer ";
				}else{	
			//	$type = 2;	
				$adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
				$newstoreqty = $storeqty - $suppliedqty;
				$newtransferqty = $transferqty + $suppliedqty;
               	$totalqty = $newstoreqty + $newtransferqty + $itemqty; 
				$stockvalue = $totalqty * $cashprice;               
				$expire = date('Y-m-d', strtotime($day. '+ 3 months'));
            //    $expirycode = md5(microtime());
				$ajustcode = md5(microtime());

				$validatesuppliedqty = $engine->getnumbernonzerovalidation($suppliedqty);
				if ($validatesuppliedqty == '1') {
					$status = 'error';
					$msg = "Qty value is invalid";
					return '0';
				}

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before $day  Unsuccessful";
                } else {
			//	$arrayparameters = array($ekey,$type,$suppliedqty,$currentusercode,$currentuser,$instcode);				
				$editpricing = $requestionsql->transferstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$itemqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$totalqty,$stockvalue,$category,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode);
				$title = "$item Restock Stores ";
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title  Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title   successfully ";
					$eventcode= "230";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
			}
			}
		}

	break;
	
	


    // 16 APR 2022 JOSEPH ADORBOE 
	case 'restockrequestitems': 

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($form_number)  ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		

				// assign services
                if (!empty($_POST["scheckboxserv"])) {
                    foreach ($_POST["scheckboxserv"] as $restockitem) {
                        $req = explode('@@@', $restockitem);
                        $requestcode = $req['0'];
                        $itemcode = $req['1'];
                        $itemqty = $req['2'];
                        $itemtype = $req['3'];                       
                        $items = $requestionsql->restock($requestcode, $itemcode, $itemqty, $itemtype, $instcode, $days, $currentusercode, $currentuser);
                    }                

                    if ($items == '0') {
                        $status = "error";
                        $msg = "Restock Unsuccessful";
                    } elseif ($items == '1') {
                        $status = "error";
                        $msg = "Restock Exist";
                    } elseif ($items == '2') {
                        $event= " Restocks : $form_key $currentusercode has been saved successfully ";
                        $eventcode= 70;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Restock  Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } else {
                        $status = "error";
                        $msg = "Add Facility Unsuccessful ";
                    }
                }else{
					$status = "error";
					$msg = "Add restock Unsuccessful. No item selected  ";
				}
			}
		}
	break;

	 // 18 APR 2022  JOSEPH ADORBOE  
	 case 'supplyequestionitems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$suppliedqty = isset($_POST['suppliedqty']) ? $_POST['suppliedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$storeqty = isset($_POST['storeqty']) ? $_POST['storeqty'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($suppliedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
                if (is_numeric($suppliedqty)) {
                    if ($storeqty<$suppliedqty) {
                        $status = "error";
                        $msg = "In Store qty $storeqty is less than supply qty $suppliedqty ";
                    } else {
                        $editpricing = $requestionsql->supplyrequestitems($ekey, $itemcode,$suppliedqty, $type,$days, $currentusercode, $currentuser, $instcode);
                        $title = 'Edit Requisition';
                        if ($editpricing == '0') {
                            $status = "error";
                            $msg = "$title for $item Unsuccessful";
                        } elseif ($editpricing == '1') {
                            $status = "error";
                            $msg = "$title for $item Exist";
                        } elseif ($editpricing == '2') {
                            $event= " $title $item  successfully ";
                            $eventcode= "74";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = " $title $item Successfully";
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unsuccessful source ";
                        }
                    }
                } else {
                    $status = "error";
                    $msg = "Supply Qty $suppliedqty is not A number ";
                }
            }
		}

	break;
    
	// 16 APR 2022  JOSEPH ADORBOE  
	case 'removerequestionitems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($requestedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$editpricing = $requestionsql->removerequestitems($ekey,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Requisition';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title for $item Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title for $item Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title $item  successfully ";
					$eventcode= "74";
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
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

    // 16 APR 2022  JOSEPH ADORBOE  
	case 'editrequestionitems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$requestedqty = isset($_POST['requestedqty']) ? $_POST['requestedqty'] : '';
        $item = isset($_POST['item']) ? $_POST['item'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($requestedqty) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$editpricing = $requestionsql->editrequestitems($ekey,$requestedqty,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Requisition';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "$title for $item Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "$title for $item Exist"; 					
				}else if($editpricing == '2'){
					$event= " $title $item  successfully ";
					$eventcode= "74";
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
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 16 APR  2022 JOSEPH ADORBOE 
	case 'addrequestitems': 		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($form_number)  ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		

				// assign services
                if (!empty($_POST["scheckboxserv"])) {
					$requestionnumber = $coder->getrequestionnumber($instcode);
                    foreach ($_POST["scheckboxserv"] as $key => $value) {
						$requiredqty =$_POST['requriedqty'][$key];
						
                        $items = explode('@@@', $value);
                        $itemcode = $items['0'];
                        $itemname = $items['1'];
                        $itemqty = $items['2'];
                    	$itemnumber = $items['3'];  
                        $type = $items['4']; 
                        $requestitemcode = md5(microtime());
                        $itemrequested = $requestionsql->saverequestions($requestitemcode,$requestionnumber, $itemcode, $itemname, $itemnumber, $itemqty, $requiredqty,$type, $instcode,  $day, $currentusercode, $currentuser);
                    }
                    if ($itemrequested == '0') {
                        $status = "error";
                        $msg = "Request $itemname Unsuccessful";
                    } elseif ($itemrequested == '1') {
                        $status = "error";
                        $msg = "Request $itemname";
                    } elseif ($itemrequested == '2') {
                        $event= " Request $itemname  $requestitemcode has been saved successfully ";
                        $eventcode= 70;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Request $itemname Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } else {
                        $status = "error";
                        $msg = "Add item Unsuccessful ";
                    }
                }else{
					$status = "error";
					$msg = "Add item  Unsuccessful. No item selected  ";
				}
			}
		}
	break;    
}
 

?>
