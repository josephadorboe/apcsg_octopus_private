<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$patientdevicemodel = isset($_POST['patientdevicemodel']) ? $_POST['patientdevicemodel'] : '';
	
	Global $instcode;
	
	// 10 oct 2023 JOSEPH ADORBOE 
	switch ($patientdevicemodel)
	{
		// 10 0ct 2023, 29 MAY 2021 JOSEPH ADORBOE 
		case 'addpatientdevices':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$newdevices = htmlspecialchars(isset($_POST['newdevices']) ? $_POST['newdevices'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
			$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
			$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
			$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					foreach ($devices as $key) {
					$compl = explode('@@@', $key);
					$devicescode = $compl[0];
					$devicesname = $compl[1];					
					$patientdevicecode = rand(1,10000);
					$type = 'OPD';
					$form_key = md5(microtime());
					$sqlresults = $patientsdevicescontroller->insertpatientdevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$devicesname,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode,$patientsDevicestable,$patientconsultationstable,$devicesetuptable);
					$action = "$devicesname added to";
					$result = $engine->getresults($sqlresults,$item=$devicesname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=414;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			
					}
				}				
			}
		break;
		// 10 oct 2023, 29 MAY 2021
		case 'editdevices':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($devices)  || empty($quantity)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{									
						$com = explode('@@@', $devices);
						$devicescode = $com[0];
						$devicesname = $com[1];
									
					$sqlresults = $patientsDevicestable->update_patientdevices($ekey,$days,$devicescode,$devicesname,$storyline,$quantity,$currentusercode,$currentuser,$instcode);
					$action = "$devicesname edit to";
					$result = $engine->getresults($sqlresults,$item=$devicesname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=413;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
		break;	
		// 10 oct 2023, 29 MAY 2021
		case 'removedevices':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($devices) || empty($cancelreason)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{									
						$com = explode('@@@', $devices);
						$devicescode = $com[0];
						$devicesname = $com[1];

					$sqlresults = $patientsDevicestable->update_removepatientdevices($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
					$action = "Remove device";
					$result = $engine->getresults($sqlresults,$item=$devicesname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=413;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}
		break;
		
		
	}	

?>
