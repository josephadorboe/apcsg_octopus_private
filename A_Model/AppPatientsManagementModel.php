<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$managementmodel = htmlspecialchars(isset($_POST['managementmodel']) ? $_POST['managementmodel'] : '');
	
	// 13 oct 2023, 
	switch ($managementmodel)
	{
		// 13 Oct 2023, 26 MAR 2021
		case 'addmanagement':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$managementnotes = htmlspecialchars(isset($_POST['managementnotes']) ? $_POST['managementnotes'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if( empty($managementnotes) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$managementnumber = rand(1,10000);				
					$sqlresults = $patientsmanagementcontroller->insertpatientmanagementnotes($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$managementnotes,$managementnumber,$currentusercode,$currentuser,$instcode,$patientmanagementtable,$patientconsultationstable);
					$action = "Management Notes added";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=407;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				
				}
			}
		break;

		// 13 oct 2023, 26 MAR 2021
	case 'editmanagement':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);	
		if($preventduplicate == '1'){
			if( empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
			//	$storyline = strtoupper($storyline);
				$sqlresults = $patientmanagementtable->update_patientmanagement($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode);
				$action = "Edit Management Notes added";							
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=407;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
	
			}
		}
	
		break;
			
	}
	

?>
