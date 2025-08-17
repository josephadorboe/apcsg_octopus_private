<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$patientnotesmodel = htmlspecialchars(isset($_POST['patientnotesmodel']) ? $_POST['patientnotesmodel'] : '');
	
	// 27 JUNE 2023 
	switch ($patientnotesmodel)
	{

		// 12 Oct 2023, 18 JAN 2023
		case 'patientfoldereditnotes':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$doctorsnotes = htmlspecialchars(isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '');
			$doctorsnotesone = htmlspecialchars(isset($_POST['doctorsnotesone']) ? $_POST['doctorsnotesone'] : '');
			$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
			$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');			
			$notesnumber = htmlspecialchars(isset($_POST['notesnumber']) ? $_POST['notesnumber'] :'');
			$ekeyone = htmlspecialchars(isset($_POST['ekeyone']) ? $_POST['ekeyone'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$notekey = htmlspecialchars(isset($_POST['notekey']) ? $_POST['notekey'] : '');
			$notekeyone = htmlspecialchars(isset($_POST['notekeyone']) ? $_POST['notekeyone'] : '');
		//	$notenumber = htmlspecialchars(isset($_POST['notenumber']) ? $_POST['notenumber'] : '');
			$notestype = htmlspecialchars(isset($_POST['notestype']) ? $_POST['notestype'] : '');
			$oldnotes = htmlspecialchars(isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '');
			$oldnotesone = htmlspecialchars(isset($_POST['oldnotesone']) ? $_POST['oldnotesone'] : '');
			$typecode = htmlspecialchars(isset($_POST['typecode']) ? $_POST['typecode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if($typecode == '1'){				
					if(empty($ekeyone) || empty($doctorsnotesone) ){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';				
					}else{	
						$updatenumber = rand(100,10000);	
									
						$sqlresults = $patientsnotestable->update_doctornotes($ekeyone,$days,$doctorsnotesone,$currentusercode,$currentuser,$instcode);
						$patientsnotesupdatestable->insert_patientdoctorsnotesupdates($notekeyone,$days,$notesnumber,$notestype,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldnotesone,$currentusercode,$currentuser,$instcode,$updatenumber,$form_key);
						$action = "Notes Updated";							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=411;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}		
		break;
		// 12 Oct 2023, 18 JAN 2023
		case 'editdoctornotes':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$doctorsnotes = htmlspecialchars(isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '');
			$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
			$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');			
			$notesnumber = htmlspecialchars(isset($_POST['notesnumber']) ? $_POST['notesnumber'] :'');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$notekey = htmlspecialchars(isset($_POST['notekey']) ? $_POST['notekey'] : '');
			$notenumber = htmlspecialchars(isset($_POST['notenumber']) ? $_POST['notenumber'] : '');
			$notestype = htmlspecialchars(isset($_POST['notestype']) ? $_POST['notestype'] : '');
			$oldnotes = htmlspecialchars(isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				
				if(empty($ekey) || empty($doctorsnotes) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$updatenumber = rand(100,10000);					
					$sqlresults = $patientsnotestable->update_doctornotes($ekey,$days,$doctorsnotes,$currentusercode,$currentuser,$instcode);
					$patientsnotesupdatestable->insert_patientdoctorsnotesupdates($notekey,$days,$notenumber,$notestype,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldnotes,$currentusercode,$currentuser,$instcode,$updatenumber,$form_key);
					$action = "Notes Updated";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=411;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
		
		break;

		// 11 oct 2023,  25 MAR 2021
		case 'adddoctorsnotes':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$doctorsnotes = htmlspecialchars(isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '');
			$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
			$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$notekey = htmlspecialchars(isset($_POST['notekey']) ? $_POST['notekey'] : '');	
			$notestype = htmlspecialchars(isset($_POST['notestype']) ? $_POST['notestype'] : '');					
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if( empty($doctorsnotes) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{									
					$notesrequestcode = rand(100,10000);
					$sqlresults = $patientsnotescontroller->insertpatientdoctorsnotes($notekey,$days,$notesrequestcode,$notestype,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode,$patientconsultationstable,$patientsnotestable);
					$action = "New notes Added";							
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=412;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				}
			}
		break;

		// 23 Sept 2023, 13 FEB 2022 JOSEPH ADORBOE 
	case 'addnewhandover':
		$handovertitle = htmlspecialchars(isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '');
		$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');

		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($handovertitle) || empty($notes) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$handovertitle = strtoupper($handovertitle);
				$handovercode = rand(1,1000);
			//	$handovernotes = date('d M Y h:i:s a', strtotime($days))."\r\n".$notes;
				$sqlresults = $handovertable->insert_newhandovernotes($form_key,$handovercode,$day,$handovertitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
				$action = "New Handover notes Added";							
				$result = $engine->getresults($sqlresults,$item=$handovertitle,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=481;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  		 
			}
		}
	break;

	// 23 sept 2023, 1 JUL 2023 JOSEPH ADORBOE  
	case 'edithandover':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$handovertitle = htmlspecialchars(isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$oldnotes = htmlspecialchars(isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '');
		$oldshiftcode = htmlspecialchars(isset($_POST['oldshiftcode']) ? $_POST['oldshiftcode'] : '');
		$addnotes = htmlspecialchars(isset($_POST['addnotes']) ? $_POST['addnotes'] : '');
		$shiftnotes = htmlspecialchars(isset($_POST['shiftnotes']) ? $_POST['shiftnotes'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($oldnotes) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
			//	$handovernotes = date('d M Y h:i:s a', strtotime($days))."\r\n".$notes;
				
				$handovernotes = $shiftnotes;	
				if($currentshiftcode !== $oldshiftcode){
					$handovernotes = $addnotes."\r\n\r\n".$oldnotes;	
				}
				$sqlresults = $handovertable->edithandover($ekey,$handovertitle,$handovernotes,$currentusercode,$currentuser,$instcode);
				$action = "Edit Handover notes";							
				$result = $engine->getresults($sqlresults,$item=$handovertitle,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=480;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  
				
			}
		}

	break;
	
	// 27 JUNE 2023 JOSEPH ADORBOE 
		case 'editnotes':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$editpatienotes = htmlspecialchars(isset($_POST['editpatienotes']) ? $_POST['editpatienotes'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$notestype = htmlspecialchars(isset($_POST['notestype']) ? $_POST['notestype'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if( empty($editpatienotes) || empty($notestype) || empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				
				
					$add = $notessql->edit_patientnotes($ekey,$editpatienotes,$notestype,$currentusercode,$currentuser,$instcode);
					$title = "Patient Notes";
					if($add == '0'){				
						$status = "error";					
						$msg = "$title added Unsuccessful"; 
					}else if($add == '1'){						
						$status = "error";					
						$msg = "$title  Exist";					
					}else if($add == '2'){
						$event= "$title added successfully ";
						$eventcode= "502";
						$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
						if($audittrail == '2'){
							$status = "success";
							$msg = "$title  Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}					
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}

				}
			}

		break;

		// 27 JUNE 2023 JOSEPH ADORBOE 
		case 'savepatientadmissionnotes':
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$admissioncode = htmlspecialchars(isset($_POST['admissioncode']) ? $_POST['admissioncode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$patientnotes = htmlspecialchars(isset($_POST['patientnotes']) ? $_POST['patientnotes'] : '');
			$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
			$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$notestype = htmlspecialchars(isset($_POST['notestype']) ? $_POST['notestype'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if( empty($patientnotes) || empty($patientcode) || empty($patientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{				
				//	$doctorsnotes = strtoupper($doctorsnotes);
					
					$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				//	$types = 'ADMISSION';
				//	$service = "Amission";
					$add = $notessql->insert_patientnotes($form_key,$days,$notesrequestcode,$notestype,$servicerequestedcode,$servicerequested,$admissioncode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$patientnotes,$currentusercode,$currentuser,$instcode);
					$title = "Patient Notes";
					if($add == '0'){				
						$status = "error";					
						$msg = "$title added Unsuccessful"; 
					}else if($add == '1'){						
						$status = "error";					
						$msg = "$title  Exist";					
					}else if($add == '2'){
						$event= "$title added successfully ";
						$eventcode= "501";
						$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
						if($audittrail == '2'){
							$status = "success";
							$msg = "$title for $patient  Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}					
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}

				}
			}

		break;
			
	}
 
?>
