<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$wounddressingmodel = htmlspecialchars(isset($_POST['wounddressingmodel']) ? $_POST['wounddressingmodel'] : '');
	
	// 18 OCT 2023, 2023 
	switch ($wounddressingmodel)
	{

		// 7 NOV 2023, 18 oct 2023,  29 MAR 2022 JOSEPH ADORBOE 
		case 'editpatientwounddressing':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$woundservices = htmlspecialchars(isset($_POST['woundservices']) ? $_POST['woundservices'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if( empty($woundservices) || empty($storyline) || empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$ser = explode('@@@', $woundservices);
					$woundservicecode = $ser[0];
					$woundservicename = $ser[1];
					$requestcode = date("His");												
					$sqlresults = $patientswounddressingtable->update_patientwounddressing($ekey,$woundservicecode,$woundservicename,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Wound dressing  Edit";							
					$result = $engine->getresults($sqlresults,$item=$woundservicename,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=386;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
		break;

		// 7 NOV 2023, 18 oct 2023,  29 MAR 2022 JOSEPH ADORBOE 
		case 'addpatientwounddressing':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$woundservices = htmlspecialchars(isset($_POST['woundservices']) ? $_POST['woundservices'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
			$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
			$types = htmlspecialchars(isset($_POST['types']) ? $_POST['types'] : '');
			$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
			$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if( empty($woundservices) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$ser = explode('@@@', $woundservices);
					$woundservicecode = $ser[0];
					$woundservicename = $ser[1];
					$requestcode = date("His");
					// $ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
					// $serviceamount = $pricing->getcashprice($paymentmethodcode, $schemecode, $woundservicecode,$ptype,$instcodenuc, $instcode, $cashschemecode,$cashpaymentmethodcode);
								
					$sqlresults = $patientswounddressingtable->insert_patientwounddressing($form_key,$days,$requestcode,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$woundservicecode,$woundservicename,$storyline,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
					$action = "Wound dressing  requested";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=387;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
			}

		break;
		
			
	}
 
?>
