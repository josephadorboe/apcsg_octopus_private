<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setupproceduremodel = htmlspecialchars(isset($_POST['setupproceduremodel']) ? $_POST['setupproceduremodel'] : '');
	
	// 28 NOV 2023 JOSEPH ADORBOE 
	switch ($setupproceduremodel)
	{

		// 28 NOV 2023  JOSPH ADORBOE
		case 'addprocedure':			
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');			
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
				if(empty($procedure) || empty($description) || empty($cashprice) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$procedurenumber = rand(1,100000);
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
					$sqlresults = $proceduresetuptable->newprocedure($form_key,$procedure,$procedurenumber,$description,$cashprice,$alternateprice,$insuranceprice,$dollarprice,$partnerprice,$currentuser,$currentusercode,$instcode);
					if($sqlresults =='2'){							
						$pricingtable->setcashprices($itemcode=$form_key,$procedure,$cashprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
						if($insuranceprice > '0'){						
							if (!empty($_POST["scheckbox"])) {
								foreach ($_POST["scheckbox"] as $schemes) {
									$pricecode = md5(microtime());	
									$req = explode('@@@', $schemes);
									$schemecode = $req['0'];
									$schemename = $req['1'];
									$insurancecode = $req['2'];
									$insurancename = $req['3'];                       
									$ins = $pricingtable->setinsuranceprices($pricecode,$category,$itemcode=$form_key,$procedure,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);;
								}  
							}
						}
					}
					$action = "Add procedure";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9964;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
	
		break;

		// 28 NOV 2023, JOSPH ADORBOE
		case 'editprocedure':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$procedurenumber = htmlspecialchars(isset($_POST['procedurenumber']) ? $_POST['procedurenumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($procedure) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($procedurenumber)){
						$procedurenumber = rand(1,100000);
					}					
					$procedure = strtoupper($procedure);
					$sqlresults = $proceduresetuptable->editprocedure($ekey,$procedure,$procedurenumber,$description,$currentuser,$currentusercode,$instcode);
					if($sqlresults =='2'){	
						$pricingtable->updatepricesitems($ekey,$procedure,$instcode);												
					}	
					$action = "Edit procedure";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9963;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}	
		break;

		// 28 NOV 2023 JOSPH ADORBOE
		case 'enableproceduresetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $proceduresetuptable->enableprocedures($ekey,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable Procedure";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9962;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;
		// 28 NOV 2023 JOSPH ADORBOE
		case 'disableproceduresetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
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
					$sqlresults = $proceduresetuptable->disableprocedure($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable Procedures";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9961;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

				}
			}	
		break;
			
	}
	

?>
