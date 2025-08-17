<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$servicepartnermodel = htmlspecialchars(isset($_POST['servicepartnermodel']) ? $_POST['servicepartnermodel'] : '');
	
	
	// 12 AUG 2023 JOSEPH ADORBOE 
	switch ($servicepartnermodel)
	{
		// 12 AUG 2023, 11 OCT 2020
		case 'disableservicepartner':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$vkey = htmlspecialchars(isset($_POST['vkey']) ? $_POST['vkey'] : '');
			$partnername = htmlspecialchars(isset($_POST['partnername']) ? $_POST['partnername'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
			$partneraddress = htmlspecialchars(isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '');
			$phone = htmlspecialchars(isset($_POST['phone']) ? $_POST['phone'] : '');
			$contactperson = htmlspecialchars(isset($_POST['contactperson']) ? $_POST['contactperson'] : '');
			$contacts = htmlspecialchars(isset($_POST['contacts']) ? $_POST['contacts'] : '');
			$partnerremarks = htmlspecialchars(isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
				if($preventduplicate == '1'){
					if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';						
					}else{											
							$pay = explode('@@@', $paymentmethod);
							$paymentmethodcode = $pay[0];
							$paymentmethodname = $pay[1];
							$partnername = strtoupper($partnername);
						$sqlresults = $servicepartnersql->update_disableservicepartner($ekey,$currentusercode,$currentuser,$instcode);
						$action = 'Disable Service partner';							
						$result = $engine->getresults($sqlresults,$item=$partnername,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=194;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
					
					}
				}
		break;	
		// 12 AUG 2023, 28 MAY 2022 
		case 'editservicepartner':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$vkey = htmlspecialchars(isset($_POST['vkey']) ? $_POST['vkey'] : '');
			$partnername = htmlspecialchars(isset($_POST['partnername']) ? $_POST['partnername'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
			$partneraddress = htmlspecialchars(isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '');
			$phone = htmlspecialchars(isset($_POST['phone']) ? $_POST['phone'] : '');
			$contactperson = htmlspecialchars(isset($_POST['contactperson']) ? $_POST['contactperson'] : '');
			$contacts = htmlspecialchars(isset($_POST['contacts']) ? $_POST['contacts'] : '');
			$partnerremarks = htmlspecialchars(isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
				if($preventduplicate == '1'){
					if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';						
					}else{											
							$pay = explode('@@@', $paymentmethod);
							$partnerservicecode = $pay[0];
							$partnerservicename = $pay[1];
							$partnername = strtoupper($partnername);
						$sqlresults = $servicepartnersql->update_servicepartner($ekey,$partnername,$partnerservicecode,$partnerservicename,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);						
						$action = 'Edit Service partner';							
						$result = $engine->getresults($sqlresults,$item=$partnername,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=193;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					}
				}
		break;
		// 12 AUG 2023, 28 MAY 2022 JOSEPH ADORBOE 
		case 'addservicepartner':
			$partnername = htmlspecialchars(isset($_POST['partnername']) ? $_POST['partnername'] : '');
			$partnerservice = htmlspecialchars(isset($_POST['partnerservice']) ? $_POST['partnerservice'] : '');
			$partneraddress = htmlspecialchars(isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '');
			$phone = htmlspecialchars(isset($_POST['phone']) ? $_POST['phone'] : '');
			$contactperson = htmlspecialchars(isset($_POST['contactperson']) ? $_POST['contactperson'] : '');
			$contacts = htmlspecialchars(isset($_POST['contacts']) ? $_POST['contacts'] : '');
			$partnerremarks = htmlspecialchars(isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
				if($preventduplicate == '1'){
					if(empty($partnername) || empty($partnerservice) || empty($partneraddress) || empty($phone) || empty($contactperson)){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';						
					}else{
						$pay = explode('@', $partnerservice);
						$partnerservicecode = $pay[0];
						$partnerservicename = $pay[1];
						$partnername = strtoupper($partnername);
						$sqlresults = $servicepartnersql->insert_servicepartner($form_key,$partnerservicecode,$partnerservicename,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);
						$action = 'Add Service partner';							
						$result = $engine->getresults($sqlresults,$item=$partnername,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=192;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					}
				}
		break;	
		
	}	

?>
