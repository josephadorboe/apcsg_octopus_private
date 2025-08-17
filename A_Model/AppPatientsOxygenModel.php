<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$oxygenmodel = htmlspecialchars(isset($_POST['oxygenmodel']) ? $_POST['oxygenmodel'] : '');
	
	// 27 JUNE 2023 
	switch ($oxygenmodel)
	{
		// 7 NOV 2023, JOSEPH ADORBOE 
		case 'editpatientoxygen':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$oxygen = htmlspecialchars(isset($_POST['oxygen']) ? $_POST['oxygen'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if( empty($oxygen) || empty($storyline) || empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$com = explode('@@@', $oxygen);
					$comcode = $com[0];
					$comname = $com[1];
					$requestcode = date("His");												
					$sqlresults = $patientsoxygentable->update_patientoxygen($ekey,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Wound dressing  Edit";							
					$result = $engine->getresults($sqlresults,$item=$comname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=386;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
		break;
		// 7 NOV 2023
		case 'addpatientoxygenonly':
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
			$oxygen = htmlspecialchars(isset($_POST['oxygen']) ? $_POST['oxygen'] : '');
			$newoxygen = htmlspecialchars(isset($_POST['newoxygen']) ? $_POST['newoxygen'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if( empty($oxygen) || empty($storyline) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else if(!empty($oxygen)  || empty($storyline) || empty($patientcode) || empty($patientnumber)){
					$com = explode('@@@', $oxygen);
					$comcode = $com[0];
					$comname = $com[1];
				
					$sqlresults = $patientsoxygentable->insert_patientoxygenonly($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Oxygen requested";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=385;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
				}
		break;

		// 17 OCT 2023, 26 MAR 2021
		case 'addpatientoxygen':
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
			$oxygen = htmlspecialchars(isset($_POST['oxygen']) ? $_POST['oxygen'] : '');
			$newoxygen = htmlspecialchars(isset($_POST['newoxygen']) ? $_POST['newoxygen'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if( (empty($oxygen) && empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else if((!empty($oxygen) && empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber)){
					$com = explode('@@@', $oxygen);
					$comcode = $com[0];
					$comname = $com[1];
				//	$storyline = strtoupper($storyline);
					$sqlresults = $patientsoxygencontroller->insertpatientoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode,$patientconsultationstable,$patientsoxygentable);
					$action = "Oxygen requested";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=403;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				

				}else if((empty($oxygen) && !empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber)){
					
				//	$storyline = strtoupper($storyline);
					$newoxygen = strtoupper($newoxygen);
					$comcode = md5(microtime());
					$sqlresults = $patientsoxygencontroller->insertpatientaddoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$storyline,$newoxygen,$currentusercode,$currentuser,$instcode,$patientconsultationstable,$patientsoxygentable,$oxygensetuptable );
					$action = "Oxygen requested";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=403;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				
				}else if(!empty($oxygen) && !empty($newoxygen)){
					$status = "error";					
					$msg = "Oxgyen and new oxygen cannot be used together  "; 	

				}
			}

		break;
		
			
	}
 
?>
