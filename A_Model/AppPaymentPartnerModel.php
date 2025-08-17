<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$providersmodel = htmlspecialchars(isset($_POST['providersmodel']) ? $_POST['providersmodel'] : '');
	
	// 11 AUG 2023 JOSEPH ADORBOE 
	switch ($providersmodel)
	{
		// 11 AUG 2023, 11 OCT 2020
		case 'editpaymentpartner':
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
							$sqlresults = $paymentpartnersql->update_paymentpartner($ekey,$partnername,$paymentmethodcode,$paymentmethodname,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);
							$action = 'Edit Payment Partner';							
							$result = $engine->getresults($sqlresults,$item=$partnername,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=238;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}
				}
		break;		
		// 11 AUG 2023 11 OCT 2020
		case 'addpaymentpartner':
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
						$sqlresults = $paymentpartnersql->insert_paymentpartner($form_key,$paymentmethodcode,$paymentmethodname,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);
					
						$action = 'Add Payment Partner';							
						$result = $engine->getresults($sqlresults,$item=$partnername,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=94;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
				}
		break;
		
	}	

?>
