<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$patientnotesmodel = isset($_POST['patientnotesmodel']) ? $_POST['patientnotesmodel'] : '';
	
	// 27 JUNE 2023 
	switch ($patientnotesmodel)
	{
		// 27 JUNE 2023 JOSEPH ADORBOE 
		case 'editnotes':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$editpatienotes = isset($_POST['editpatienotes']) ? $_POST['editpatienotes'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$notestype = isset($_POST['notestype']) ? $_POST['notestype'] : '';
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
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
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
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$admissioncode = isset($_POST['admissioncode']) ? $_POST['admissioncode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$patientnotes = isset($_POST['patientnotes']) ? $_POST['patientnotes'] : '';
			$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
			$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$notestype = isset($_POST['notestype']) ? $_POST['notestype'] : '';
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
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
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
