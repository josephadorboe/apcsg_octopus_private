<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setupimagingmodel = htmlspecialchars(isset($_POST['setupimagingmodel']) ? $_POST['setupimagingmodel'] : '');
	
	// 28 NOV 2023 JOSEPH ADORBOE 
	switch ($setupimagingmodel)
	{		
		// 29 NOV 2023  JOSPH ADORBOE
		case 'addimagingprice':			
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
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
				if(empty($imaging) || empty($description) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$imagingnumber = rand(1,100000);
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
						$msg = "Dollar Prices value is invalid";
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
					$sqlresults = $setupradiologytable->addnew($form_key,$imaging,$imagingnumber,$description,$partnercode,$cashprice,$alternateprice,$dollarprice,$partnerprice,$insuranceprice, $currentuser,$currentusercode,$instcode);
					
					if($sqlresults =='2'){	
										
						$pricingtable->setcashprices($itemcode=$form_key,$imaging,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						if($insuranceprice > '0'){						
							if (!empty($_POST["scheckbox"])) {
								$itemcode=$form_key;		
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $pricingtable->setinsurancepartnerprices($pricecode,$category,$itemcode,$imaging,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$partnerprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);									
								}  
							}
						}
					}
					$action = "Add imaging";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9937;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
	
		break;

		//  29 NOV 2023, JOSPH ADORBOE
		case 'editimagingsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$imagingnumber = htmlspecialchars(isset($_POST['imagingnumber']) ? $_POST['imagingnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{										
					$imaging = strtoupper($imaging);
					$sqlresults = $setupradiologytable->editimagingonly($ekey,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->updatepricesitems($ekey,$imaging,$instcode);												
					}	
					$action = "Edit imaging";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9938;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}
	
		break;


		// 29 NOV 2023 JOSPH ADORBOE
		case 'enableimagingsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $setupradiologytable->enableimaging($ekey,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable imaging";									
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9939;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;
		

		// 29 NOV 2023 JOSPH ADORBOE
		case 'disableimagingsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
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
					$sqlresults = $setupradiologytable->disableimagaing($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable imaging";									
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9940;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

				}
			}	
		break;
			
	}
	

?>
