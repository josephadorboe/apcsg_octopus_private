<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$complainsmodel = htmlspecialchars(isset($_POST['complainsmodel']) ? $_POST['complainsmodel'] : '');
	
	// 3 Oct 2023, 24 MAR 2021
switch ($complainsmodel)
{
	// 3 oct 2023, 24 MAR 2021
	case 'addpatientcomplainsbulk':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$complains = htmlspecialchars(isset($_POST['complains']) ? $_POST['complains'] : '');
		$newcomplain = htmlspecialchars(isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($complains) && empty($newcomplain) ){
				$complainscode = $complain = 'NA';
				$sqlresults = $patientscomplainscontroller->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode,$patientcomplainstable,$patientconsultationstable);
				$action = "Add Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=442;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);      
			
			}else if(!empty($complains) && empty($newcomplain)){

				$compl = explode('@@@', $complains);
				$complainscode = $compl[0];
				$complain = $compl[1];
				$sqlresults = $patientscomplainscontroller->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode,$patientcomplainstable,$patientconsultationstable);
				$action = "Add Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=442;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			}else if(empty($complains) && !empty($newcomplain)){

				$newcomplain = strtoupper($newcomplain);
			//	$storyline = strtoupper($storyline);
				$complainscode = md5(microtime());
				$sqlresults = $patientscomplainscontroller->insert_patientaddcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$newcomplain,$storyline,$currentusercode,$currentuser,$instcode,$patientcomplainstable,$patientconsultationstable,$complainstable);
				$action = "Add Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=442;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 

			}else if(!empty($complains) && !empty($newcomplain)){

				$complainscode = $complain = 'NA';
				$sqlresults = $patientscomplainscontroller->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode,$patientcomplainstable,$patientconsultationstable);
				$action = "Add Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=442;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			}			
		}
	break;
	// 3 Oct 2023, 24 MAR 2021
	case 'editcomplains':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$complains = htmlspecialchars(isset($_POST['complains']) ? $_POST['complains'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$oldstoryline = htmlspecialchars(isset($_POST['oldstoryline']) ? $_POST['oldstoryline'] : '');
		$oldcomplaincode = htmlspecialchars(isset($_POST['oldcomplaincode']) ? $_POST['oldcomplaincode'] : '');
		$oldcomplain = htmlspecialchars(isset($_POST['oldcomplain']) ? $_POST['oldcomplain'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if(empty($complains) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$com = explode('@@@', $complains);
				$comcode = $com[0];
				$comname = $com[1];
				$updatenumber = rand(1,10000);
				$sqlresults = $patientcomplainstable->update_patientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				$patientcomplainsupdatestable->insert_newpatientcomplainsupdates($form_key,$updatenumber,$ekey,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldcomplaincode,$oldcomplain,$oldstoryline,$currentusercode,$currentuser,$instcode);
				$action = "Edit Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$comname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=441;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			}
	break;

	// 24 MAR 2021
	case 'addpatientcomplainsrepeat':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$hcomplaincode = htmlspecialchars(isset($_POST['hcomplaincode']) ? $_POST['hcomplaincode'] : '');
		$hcomplain = htmlspecialchars(isset($_POST['hcomplain']) ? $_POST['hcomplain'] : '');
		$hcomplainhistory = htmlspecialchars(isset($_POST['hcomplainhistory']) ? $_POST['hcomplainhistory'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($hcomplaincode) || empty($hcomplain) ){
				$status = 'error';
				$msg = 'Complaints selected but saved successfully';				
			}else {

			//	$hcomplainhistory = strtoupper($hcomplainhistory);
				$sqlresults = $patientscomplainscontroller->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$hcomplaincode,$hcomplain,$hcomplainhistory,$currentusercode,$currentuser,$instcode,$patientcomplainstable,$patientconsultationstable);
				$action = "Edit Patient Complains";
				$result = $engine->getresults($sqlresults,$item=$hcomplain,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=441;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			
			}			
		}
	break;

	


	

	
	// // 24 MAR 2021
	// case 'addpatientcomplains':

	// 	$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
	// 	$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
	// 	$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
	// 	$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
	// 	$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
	// 	$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
	// 	$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
	// 	$complains = htmlspecialchars(isset($_POST['complains']) ? $_POST['complains'] : '');
	// 	$newcomplain = htmlspecialchars(isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '');
	// 	$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 		if(empty($complains) && empty($newcomplain) ){
	// 			// $compl = explode('@@@', $complains);
	// 			// $complainscode = $compl[0];
	// 			// $complain = $compl[1];
	// 			$complainscode = $complain = 'NA';
	// 		//	$storyline = strtoupper($storyline);
	// 			$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

	// 			$status = 'error';
	// 			$msg = 'Complaints Not selected but saved successfully';				
	// 		}else if(!empty($complains) && empty($newcomplain)){

	// 			$compl = explode('@@@', $complains);
	// 			$complainscode = $compl[0];
	// 			$complain = $compl[1];
	// 		//	$storyline = strtoupper($storyline);

	// 			$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

	// 			if($addcomplains == '0'){				
	// 				$status = "error";					
	// 				$msg = "Add Patient Complains $complain  Unsuccessful"; 
	// 			}else if($addcomplains == '1'){						
	// 				$status = "error";					
	// 				$msg = "Patient Complains $complain  Exist";					
	// 			}else if($addcomplains == '2'){
	// 				$event= "Patient Complains added successfully ";
	// 				$eventcode= "150";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "Patient Complains $complain added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}				
	// 			}else{				
	// 					$status = "error";					
	// 					$msg = "Unknown source "; 					
	// 			}

	// 		}else if(empty($complains) && !empty($newcomplain)){

	// 			$newcomplain = strtoupper($newcomplain);
	// 		//	$storyline = strtoupper($storyline);
	// 			$complainscode = md5(microtime());
	// 			$addcomplains = $complainssql->insert_patientaddcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$newcomplain,$storyline,$currentusercode,$currentuser,$instcode);

	// 			if($addcomplains == '0'){				
	// 				$status = "error";					
	// 				$msg = "Add Patient Complains ".$newcomplain."  Unsuccessful"; 
	// 			}else if($addcomplains == '1'){						
	// 				$status = "error";					
	// 				$msg = "Patient Complains ".$newcomplain."  Exist";					
	// 			}else if($addcomplains == '2'){
	// 				$event= "Patient Complains added successfully ";
	// 				$eventcode= "150";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "Patient Complains ".$newcomplain." added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}				
	// 			}else{				
	// 					$status = "error";					
	// 					$msg = "Unknown source "; 					
	// 			}


	// 		}else if(!empty($complains) && !empty($newcomplain)){

	// 			$complainscode = $complain = 'NA';
	// 		//	$storyline = strtoupper($storyline);
	// 			$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

	// 			$status = 'error';
	// 			$msg = 'Complaint and New Complaint Cannot be filled at the same time ';
	// 		}

			
	// 	}

	// break;	
	
	// // 24 MAR 2021
	// case 'removecomplains':

	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$complains = htmlspecialchars(isset($_POST['complains']) ? $_POST['complains'] : '');
	// 	$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
	// 	if($preventduplicate == '1'){
	// 		if(empty($complains) || empty($storyline) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{									
	// 				$com = explode('@@@', $complains);
	// 				$comcode = $com[0];
	// 				$comname = $com[1];
	// 		//		$storyline = strtoupper($storyline);

	// 			$editpatientcomplains = $complainssql->update_removepatientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				
	// 			if($editpatientcomplains == '0'){				
	// 				$status = "error";					
	// 				$msg = "Remove Patient Complains ".$comname." Unsuccessful"; 
	// 			}else if($editpatientcomplains == '1'){				
	// 				$status = "error";					
	// 				$msg = "Remove patient Complains ".$comname." Exist"; 					
	// 			}else if($editpatientcomplains == '2'){
	// 				$event= "Patient Complains Remove successfully ";
	// 				$eventcode= "148";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "Patient Complains ".$comname." Removed Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}			
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Add Payment Method Unknown source "; 					
	// 		}

	// 		}
	// 	}

	// break;
	
	// // 24 MAR 2021
	// case 'addnewcomplains':

	// 	$newcomplain = htmlspecialchars(isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '');
	// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
	// 	if($preventduplicate == '1'){

	// 		if(empty($newcomplain)  ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{
	// 			$newcomplain = strtoupper($newcomplain);
	// 			$addnewcomplains = $complainssql->insert_newcomplains($form_key,$newcomplain,$description,$currentusercode,$currentuser,$instcode);
	// 			if($addnewcomplains == '0'){				
	// 				$status = "error";					
	// 				$msg = "Add New Complains ".$newcomplain." Unsuccessful"; 
	// 			}else if($addnewcomplains == '1'){					
	// 				$status = "error";					
	// 				$msg = "New Complains ".$newcomplain." Exist"; 						
	// 			}else if($addnewcomplains == '2'){
	// 				$event= "Add New Complains Added successfully ";
	// 				$eventcode= "147";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){			
	// 					$status = "success";
	// 					$msg = "New Complains ".$newcomplain." Added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}	
				
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Add new complains ".$newcomplain."  Unknown source ";					
	// 		}
	// 		}
	// 	}

	// break;
	
}
 

?>
