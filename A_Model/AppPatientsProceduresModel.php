<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$proceduresmodel = htmlspecialchars(isset($_POST['proceduresmodel']) ? $_POST['proceduresmodel'] : '');
	
	// 12 oct 2023, 
switch ($proceduresmodel)
{
	// 14 OCT 2023, 26 MAR 2021
	case 'addnewprocdure':
		$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($procedure) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$procedure = strtoupper($procedure);
				$sqlresults = $proceduresetuptable->insert_newprocedure($form_key,$procedure,$description,$currentusercode,$currentuser,$instcode);
				$action = 'New Procedure';							
				$result = $engine->getresults($sqlresults,$item=$procedure,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=404;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			
			}
		}

	break;
	// 25 MAR 2021 
	case 'removeprocedure':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($cancelreason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$proc = explode('@@@', $procedure);
				$procedurecode = $proc[0];
				$procedurename = $proc[1];
				$sqlresults = $patientproceduretable->update_removepatientprocedure($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
				$action = 'Cancel procedure request';							
				$result = $engine->getresults($sqlresults,$item=$procedurename,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=408;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;

	// 12 oct 2023, 25 MAR 2021
	case 'editprocedure':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($procedure) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
				$proc = explode('@@@', $procedure);
				$procedurecode = $proc[0];
				$procedurename = $proc[1];
				$sqlresults = $patientproceduretable->update_editpatientprocedure($ekey,$procedurecode,$procedurename,$storyline,$currentusercode,$currentuser,$instcode);
				$action = 'Edit procedure request';							
				$result = $engine->getresults($sqlresults,$item=$procedurename,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=409;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;

	// 12 oct 2023,  26 MAR 2021
	case 'addpatientprocedure':
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
		$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$newprocedure = htmlspecialchars(isset($_POST['newprocedure']) ? $_POST['newprocedure'] : '');
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
			if( empty($procedure) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				foreach($procedure as $key){
				$proc = explode('@@@', $key);
				$procedurecode = $proc[0];
				$procedurename = $proc[1];
			//	$storyline = strtoupper($storyline);
				$procedurerequestcode = rand(1,10000);
				$form_key = md5(microtime());
				$sqlresults = $patientsprocedurecontroller->insertpatientprocedurerequest($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$storyline,$procedurerequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$patientproceduretable,$patientconsultationstable);
				$action = 'Add procedure request';							
				$result = $engine->getresults($sqlresults,$item=$procedurename,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=410;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}		
		}
	break;
		
}
 

?>
