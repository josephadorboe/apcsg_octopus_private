<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$nurseingnotesmodel = isset($_POST['nurseingnotesmodel']) ? $_POST['nurseingnotesmodel'] : '';
	
	// 4 JUNE 2024 JOSEPH ADORBOE
	switch ($nurseingnotesmodel)
	{	
		

		// 15 MAY 2024, JOSEPH ADORBOE 
		case 'addnursenotes':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '') ;
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '') ;
			$patientschemecode = htmlspecialchars(isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '') ;
			$patientscheme = htmlspecialchars(isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' );
			$patientservicecode = htmlspecialchars(isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '' );
			$patientservice = htmlspecialchars(isset($_POST['patientservice']) ? $_POST['patientservice']: '') ;
			$paymenttype = htmlspecialchars(isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' );
			$servicerequestcode = htmlspecialchars(isset($_POST['servicerequestcode']) ? $_POST['servicerequestcode']: '' );
			$nursenotes = htmlspecialchars(isset($_POST['nursenotes']) ? $_POST['nursenotes'] : '');
			$patientdet = htmlspecialchars(isset($_POST['patientdet']) ? $_POST['patientdet'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($nursenotes)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{	
						$notenumber = rand(1,10000);			
						$sqlresults = $patientnuresnotestable->insert_addnewnotes($form_key,$notenumber,$days,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$nursenotes,$currentusercode,$currentuser,$instcode);
						$action = "Nurses Notes added";
						$result = $engine->getresults($sqlresults,$item=$notenumber,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9823;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}							
			}			
		break;
		// 15 MAY 2024,  JOSEPH ADORBOE 
		case 'editnursenotes':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$nursenotes = htmlspecialchars(isset($_POST['nursenotes']) ? $_POST['nursenotes'] : '');				
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($nursenotes) || empty($ekey) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$sqlresults = $patientnuresnotestable->update_nursenotes($ekey,$nursenotes,$currentusercode,$currentuser,$instcode);				
						$action = "Edit Patient Nurse Notes";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9822;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 17 MAY 2024, JOSEPH ADORBOE 
		case 'addnursenotessingle':
			$patientdet = htmlspecialchars(isset($_POST['patientdet']) ? $_POST['patientdet'] : '');
			$nursenotes = htmlspecialchars(isset($_POST['nursenotes']) ? $_POST['nursenotes'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($patientdet) || empty($nursenotes) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					// $patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
					// if($patientnumbercheck == '-1'){
					// 	$status = 'error';
					// 	$msg = 'Invalid Patient number';
					// }else{
					// 	$pt = explode('@@@', $patientnumbercheck);
					// 	$patientcode = $pt[0];
					// 	$patient = $pt[1];
					// 	$patientbirthdate = $pt[2];
					// 	$patientgender = $pt[3];	
					$pd = explode('@@@', $patientdet);
					$patientcode = $pd[0];
					$patientnumber = $pd[1];
					$patient = $pd[2];
					$dob = $pd[3];
					$patientgender = $pd[4];
					$age = $pat->getpatientbirthage($dob);
						$notenumber = rand(1,99).date("is");
						
								
						$sqlresults = $patientnuresnotestable->insert_addnewnotes($form_key,$notenumber,$days,$visitcode=1,$patientcode,$patientnumber,$patient,$age,$patientgender,$nursenotes,$currentusercode,$currentuser,$instcode);
						$action = 'New Notes Added';							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9823;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                         
				//	}
				}
			
			}
		break;
	}
?>
