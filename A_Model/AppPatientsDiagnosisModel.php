<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$diagnosismodel = htmlspecialchars(isset($_POST['diagnosismodel']) ? $_POST['diagnosismodel'] : '');
	
	// 25 MAR 2021
switch ($diagnosismodel)
{


	// 7 Oct 2023, 25 MAR 2021
	case 'addpatientdiagnosis':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$newdiagnosis = htmlspecialchars(isset($_POST['newdiagnosis']) ? $_POST['newdiagnosis'] : '');
		$diagnosistype = htmlspecialchars(isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if (empty($diagnosis) && empty($newdiagnosis)) {
         //   if (empty($diagnosis)) {
                $status = 'error';
                $msg = 'Required Field Cannot be empty';
		 	}else if(!empty($diagnosis) && empty($newdiagnosis)){
          //  }else{
					
			foreach($diagnosis as $key){
                $diag = explode('@@@', $key);
                $diagnosiscode = $diag[0];
                $diagnosisname = $diag[1];
                $form_key = md5(microtime());
                $sqlresults = $patientsdiagnosiscontroller->addpatientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$diagnosistable,$patientconsultationstable);
				$action = 'Patient Diagnosis Added';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=432;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
	
          
		}else if(empty($diagnosis) && !empty($newdiagnosis)){

			$newdiagnosis = strtoupper($newdiagnosis);
			$diagnosiscode = rand(100, 10000);
			$addnew = $diagnosissetuptable->insert_newdiagnosis($diagnosiscode,$newdiagnosis,$description=$newdiagnosis,$currentusercode,$currentuser,$instcode);
			
			$sqlresults = $patientsdiagnosiscontroller->addpatientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$newdiagnosis,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$diagnosistable,$patientconsultationstable);
				$action = 'Patient Diagnosis Added';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=431;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			

		}else if(!empty($diagnosis) && !empty($newdiagnosis)){
			$status = "error";					
			$msg = "diagnosis and new diagnosis cannot be used togther"; 
		}

		}

	break;

	// 7 oct 2023, 25 MAR 2021
	case 'addnewdiagnosis':
		$diagnosis = htmlspecialchars(isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '');
		$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($diagnosis) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
				$diagnosis = strtoupper($diagnosis);
				$diagnosiscode = rand(100, 10000);
				$sqlresults =  $diagnosissetuptable->insert_newdiagnosis($diagnosiscode,$diagnosis,$description,$currentusercode,$currentuser,$instcode);
				
				$action = 'Diagnosis Added';							
				$result = $engine->getresults($sqlresults,$item=$diagnosis,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=430;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
			}
		}
	break;

	// 7 oct 2023, 25 MAR 2021
	case 'editdiagnosis':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$diagnosis = htmlspecialchars(isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$oldstoryline = htmlspecialchars(isset($_POST['oldstoryline']) ? $_POST['oldstoryline'] : '');
		$olddiagnosiscode = htmlspecialchars(isset($_POST['olddiagnosiscode']) ? $_POST['olddiagnosiscode'] : '');
		$olddiagnosis = htmlspecialchars(isset($_POST['olddiagnosis']) ? $_POST['olddiagnosis'] : '');
		$diagnosistype = htmlspecialchars(isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '');
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($diagnosis) || empty($storyline) || empty($oldstoryline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$com = explode('@@@', $diagnosis);
				$diagnosiscode = $com[0];
				$diagnosisname = $com[1];
				$updatenumber = rand(1, 10000);
				$form_key = md5(microtime());
				$sqlresults = $diagnosistable->update_patientdiagnosis($ekey,$days,$diagnosiscode,$diagnosisname,$storyline,$diagnosistype,$currentusercode,$currentuser,$instcode);
							
				$diagnosisupdatestable->insert_patientdiagnosisupdates($form_key,$ekey,$updatenumber,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$olddiagnosiscode,$olddiagnosis,$diagnosistype,$oldstoryline,$currentusercode,$currentuser,$instcode);
				$action = 'Edit Patient diagnosis';							
				$result = $engine->getresults($sqlresults,$item=$diagnosisname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=429;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}
		}
	break;

	// 7 oct 2023, 25 MAR 2021
	case 'removediagnosis':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$diagnosis = htmlspecialchars(isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$removereason = htmlspecialchars(isset($_POST['removereason']) ? $_POST['removereason'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($diagnosis) || empty($removereason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $diagnosis);
					$comcode = $com[0];
					$comname = $com[1];
					// if(!empty($storyline)){
					// 	$storyline = strtoupper($storyline);
					// }
				$sqlresults = $diagnosistable->update_removepatientdiagnosis($ekey,$days,$removereason,$currentusercode,$currentuser,$instcode);
				
				$action = 'Remove diagnosis';							
				$result = $engine->getresults($sqlresults,$item=$comname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=428;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}

	break;

	// 7 OCT 2023, 2 JUNE 2022 JOSEPH ADORBOE 
	case 'repeatsinglediagnosis': 
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$diagnosiscode = htmlspecialchars(isset($_POST['diagnosiscode']) ? $_POST['diagnosiscode'] : '');
		$diagnosisname = htmlspecialchars(isset($_POST['diagnosisname']) ? $_POST['diagnosisname'] : '');
		$diagnosistype = htmlspecialchars(isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');	
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($visitcode) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
		
				$sqlresults = $patientsdiagnosiscontroller->addpatientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$diagnosistable,$patientconsultationstable);
					
				$action = 'Repeat diagnosis';							
				$result = $engine->getresults($sqlresults,$item=$diagnosisname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=427;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
			}
		}
	break;


	// 7 oct 2023, 21 NOV 2021
	case 'saverepeatdiagnosis': 
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$diagnosis = htmlspecialchars(isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '');
		$newdiagnosis = htmlspecialchars(isset($_POST['newdiagnosis']) ? $_POST['newdiagnosis'] : '');
		$diagnosistype = htmlspecialchars(isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');	
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($visitcode) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
		
				foreach($_POST["scheckboxchronic"] as $chronicdetails){
					$chrondet = explode('@@@',$chronicdetails);
					$diagnosiscode = $chrondet['0'];
					$diagnosisname = $chrondet['1'];
					$form_key = md5(microtime());
					$diagnosistype = 'CONFIRMED';
					$storyline = 'REPEAT DIAGNOSIS';
					$sqlresults = $patientsdiagnosiscontroller->addpatientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$diagnosistable,$patientconsultationstable);
				//	$repeatdiagnosis = $diagnosissql->insert_patientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode);
				//	$staffschedule = $schedulesql->insert_staffschedule($staffschedulecode,$scheduledate,$shifttype,$staffdetcode,$staffdetname,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
								
					
				$action = 'Repeat diagnosis';							
				$result = $engine->getresults($sqlresults,$item=$diagnosisname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=426;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			}
			}
		}
	break;



	


	
	
	
	
	
	
		
}
 

?>
