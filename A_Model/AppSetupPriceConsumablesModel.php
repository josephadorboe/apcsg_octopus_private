<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$setupconsumablepricemodel = htmlspecialchars(isset($_POST['setupconsumablepricemodel']) ? $_POST['setupconsumablepricemodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 26 DEC 2023 JOSEPH ADORBOE  
	switch ($setupconsumablepricemodel)
	{

		// 11 NOV 2023 JOSEPH ADORBOE
		case 'singleconsumablechangeprices':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
			$paycode = htmlspecialchars(isset($_POST['paycode']) ? $_POST['paycode'] : '');
			$payname = htmlspecialchars(isset($_POST['payname']) ? $_POST['payname'] : '');
			$itemname = htmlspecialchars(isset($_POST['itemname']) ? $_POST['itemname'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$totalqty = htmlspecialchars(isset($_POST['totalqty']) ? $_POST['totalqty'] : '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode'] : '');
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$itemqty = htmlspecialchars(isset($_POST['itemqty']) ? $_POST['itemqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
							$msg = "Insurance Prices value is invalid";
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
				//	$alternateprice = $cashprice;
					$cashpricecode = md5(microtime());	
					$cash= 'CASH';

					$sqlresults = $consumablesetuptable->changeprice($itemcode,$costprice,$cashprice,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);									
					$action = "Change consumable Price";
					if($sqlresults =='2'){		
						
						$pricingtable->setcashprices($itemcode,$itemname,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						if($insuranceprice > '0'){						
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $pricingtable->setinsuranceprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);;
								}  
							}
						}
					}
					$result = $engine->getresults($sqlresults,$item=$itemname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9900;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		

				}
			}

		break;	

		// 10 NOV 2023,  JOSPH ADORBOE
		case 'enableprice':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $pricingtable->enablepriceing($ekey,$currentuser,$currentusercode,$instcode);						
					$action = "Enable Price";					
					$result = $engine->getresults($sqlresults,$item=$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9905;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}	
		break;

		// 10 NOV 2023,  JOSPH ADORBOE
		case 'disableconsumableprice':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$sqlresults = $pricingtable->disablepriceing($ekey,$currentuser,$currentusercode,$instcode);						
					$action = "Disable Price";					
					$result = $engine->getresults($sqlresults,$item=$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9906;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				}
			}	
		break;

		// 10 NOV 2023 JOSPH ADORBOE
		case 'editconsumableprices':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$price = htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$schemename = htmlspecialchars(isset($_POST['schemename']) ? $_POST['schemename'] : '');
			$paycode = htmlspecialchars(isset($_POST['paycode']) ? $_POST['paycode'] : '');
			$payname = htmlspecialchars(isset($_POST['payname']) ? $_POST['payname'] : '');
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$otherprice = htmlspecialchars(isset($_POST['otherprice']) ? $_POST['otherprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
						$msg = "Dollar Prices value is invalid";
						return '0';
					}

					// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
					// if ($validatepartnerprice == '1') {
					// 	$status = 'error';
					// 	$msg = "Partner Prices value is invalid";
					// 	return '0';
					// }
					$alternateprice=$partnerprice='0';
					$sqlresults = $pricingtable->editnewprices($ekey,$price,$alternateprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode);						
					$action = "Edit Price";					
					$result = $engine->getresults($sqlresults,$item=$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9907;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;
		
	}
	

?>