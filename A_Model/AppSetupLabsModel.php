<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setuplabsmodel = htmlspecialchars(isset($_POST['setuplabsmodel']) ? $_POST['setuplabsmodel'] : '');
	
	// 28 NOV 2023 JOSEPH ADORBOE 
	switch ($setuplabsmodel)
	{


		
		// 29 NOV 2023  JOSPH ADORBOE
		case 'addlabsprice':			
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');	
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');		
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');			
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$totalqty = htmlspecialchars(isset($_POST['totalqty']) ? $_POST['totalqty'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($labs) || empty($description) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$labsnumber = rand(1,100000);
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
					$sqlresults = $labtesttable->addnewlabs($form_key,$labs,$labsnumber,$description,$partnercode,$cashprice,$alternateprice,$dollarprice,$partnerprice,$insuranceprice,$currentuser,$currentusercode,$instcode);
					
					if($sqlresults =='2'){	
						$itemcode=$form_key;
						$itemname = $labs;					
						$pricingtable->setcashprices($itemcode,$labs,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						if($insuranceprice > '0'){						
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $pricingtable->setinsurancepartnerprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$partnerprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
								}  
							}
						}
					}
					$action = "Add Labs";
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9941;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
	
		break;

		// 29 NOV 2023, JOSPH ADORBOE
		case 'editlabs':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$labsnum = htmlspecialchars(isset($_POST['labsnum']) ? $_POST['labsnum'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');	
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($labs) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($labsnum)){
						$labsnum = rand(1,100000);
					}					
					$labs = strtoupper($labs);
					$sqlresults = $labtesttable->updatelabs($ekey,$labs,$labsnum,$description,$partnercode,$currentuser,$currentusercode,$instcode);
					//$proceduresetuptable->editprocedure($ekey,$labs,$labsnum,$description,$partnercode,$currentuser,$currentusercode,$instcode);
					if($sqlresults =='2'){	
						$pricingtable->updatepricesitems($ekey,$labs,$instcode);												
					}	
					$action = "Edit Labs";
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9942;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}	
		break;

		// 28 NOV 2023 JOSPH ADORBOE
		case 'enablelabssetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $labtesttable->enablelabstest($ekey,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable Labs";									
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9943;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;
		

		// 29 NOV 2023 JOSPH ADORBOE
		case 'disablelabssetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($disablereason) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $labtesttable->disablelabstest($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable Labs";									
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9944;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

				}
			}	
		break;
			
	}
	

?>
