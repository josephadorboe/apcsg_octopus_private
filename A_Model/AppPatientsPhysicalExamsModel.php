<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$physicalexammodel = htmlspecialchars(isset($_POST['physicalexammodel']) ? $_POST['physicalexammodel'] : '');
	
	// 25 MAR 2021 
switch ($physicalexammodel)
{

	// 5 Oct 2023, 24 MAR 2021
	case 'addpastpatientphysicalexammodel':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$physicalexams = htmlspecialchars(isset($_POST['physicalexams']) ? $_POST['physicalexams'] : '');
		$newphysicalexams = htmlspecialchars(isset($_POST['newphysicalexams']) ? $_POST['newphysicalexams'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($physicalexams) && empty($newphysicalexams)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($physicalexams) && empty($newphysicalexams) ){
				$phye = explode('@@@', $physicalexams);
				$physicalexamcode = $phye[0];
				$physicalexam = $phye[1];
				$sqlresults =  $physicalexamstable->insert_addpatientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode);
		
		$action = 'Add Patient Physical Exams';							
				$result = $engine->getresults($sqlresults,$item=$physicalexam,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9785;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			
		}else if(empty($physicalexams) && !empty($newphysicalexams) ){			
		//	$storyline = strtoupper($storyline);
			$newphysicalexams = strtoupper($newphysicalexams);
			$physicalexamcode = md5(microtime());
			$sqlresults =  $physicalexamstable->insert_addpatientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$newphysicalexams,$storyline,$currentusercode,$currentuser,$instcode);
			if($sqlresults  == '2'){
				$physicalexamssetuptable->insert_physicalexams($physicalexamcode,$newphysicalexams,$currentusercode,$currentuser);						
			}	
			$action = 'Add Patient Physical Exams';							
			$result = $engine->getresults($sqlresults,$item=$newphysicalexams,$action);
			$re = explode(',', $result);
			$status = $re[0];					
			$msg = $re[1];
			$event= "$action: $form_key $msg";
			$eventcode=9785;
			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
	
			}else if(!empty($physicalexams) && !empty($newphysicalexams) ){
				$status = 'error';
				$msg = 'Physical exams and new physical exams cannot be selected at the same time';
			}
		}

	break;
	// 5 Oct 2023, 24 MAR 2021
	case 'addpatientphysicalexammodel':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$physicalexams = htmlspecialchars(isset($_POST['physicalexams']) ? $_POST['physicalexams'] : '');
		$newphysicalexams = htmlspecialchars(isset($_POST['newphysicalexams']) ? $_POST['newphysicalexams'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($physicalexams) && empty($newphysicalexams)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($physicalexams) && empty($newphysicalexams) ){
				$phye = explode('@@@', $physicalexams);
				$physicalexamcode = $phye[0];
				$physicalexam = $phye[1];
			//	$storyline = strtoupper($storyline);

				// $sqlresults = $patientsphysicalexamscontroller->insert_patientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode,$physicalexamstable,$patientconsultationstable);
				$sqlresults =  $physicalexamstable->insert_addpatientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode);
		if($sqlresults  == '2'){
			$patientconsultationstable->updateconsultationstage($column ='CON_PHYSIALEXAMS',$consultationcode);			
		}	
		$action = 'Add Patient Physical Exams';							
				$result = $engine->getresults($sqlresults,$item=$physicalexam,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9785;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			
		}else if(empty($physicalexams) && !empty($newphysicalexams) ){			
		//	$storyline = strtoupper($storyline);
			$newphysicalexams = strtoupper($newphysicalexams);
			$physicalexamcode = md5(microtime());

			// $sqlresults = $patientsphysicalexamscontroller->insert_patientaddphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$newphysicalexams,$storyline,$currentusercode,$currentuser,$instcode,$physicalexamstable,$patientconsultationstable,$physicalexamssetuptable);
			$sqlresults =  $physicalexamstable->insert_addpatientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$newphysicalexams,$storyline,$currentusercode,$currentuser,$instcode);
		if($sqlresults  == '2'){
			$physicalexamssetuptable->insert_physicalexams($physicalexamcode,$newphysicalexams,$currentusercode,$currentuser);
			$patientconsultationstable->updateconsultationstage($column ='CON_PHYSIALEXAMS',$consultationcode);			
		}	
		$action = 'Add Patient Physical Exams';							
			$result = $engine->getresults($sqlresults,$item=$newphysicalexams,$action);
			$re = explode(',', $result);
			$status = $re[0];					
			$msg = $re[1];
			$event= "$action: $form_key $msg";
			$eventcode=9785;
			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
	
			}else if(!empty($physicalexams) && !empty($newphysicalexams) ){
				$status = 'error';
				$msg = 'Physical exams and new physical exams cannot be selected at the same time';
			}
		}

	break;
	// 5 oct 2023, 25 MAR 2021
	case 'addnewphysicalexams':
		$physicalexams = htmlspecialchars(isset($_POST['physicalexams']) ? $_POST['physicalexams'] : '');
		$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($physicalexams) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$physicalexams = strtoupper($physicalexams);
				$physicalexamcode = md5(microtime());
				$sqlresults = $physicalexamssetuptable->insert_physicalexams($physicalexamcode,$newphysicalexams,$currentusercode,$currentuser);
				$action = 'Add Physical Exams';							
			$result = $engine->getresults($sqlresults,$item=$physicalexams,$action);
			$re = explode(',', $result);
			$status = $re[0];					
			$msg = $re[1];
			$event= "$action: $form_key $msg";
			$eventcode=9786;
			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
	
			}
		}

	break;

	// 5 oct 2023, 25 MAR 2021
	case 'editphysicalexams':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$physicalexam = htmlspecialchars(isset($_POST['physicalexam']) ? $_POST['physicalexam'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$oldnotes = htmlspecialchars(isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '');
		$oldexamcode = htmlspecialchars(isset($_POST['oldexamcode']) ? $_POST['oldexamcode'] : '');
		$oldexam = htmlspecialchars(isset($_POST['oldexam']) ? $_POST['oldexam'] : '');
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
			if(empty($physicalexam) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $physicalexam);
					$physicalexamcode = $com[0];
					$physicalexamname = $com[1];
				//	$storyline = strtoupper($storyline);
				$updatenumber = rand(1,10000);

				$sqlresults = $physicalexamstable->update_patientphysicalexams($ekey,$days,$physicalexamcode,$physicalexamname,$storyline,$currentusercode,$currentuser,$instcode);
				$sqlresults = $physicalexamsupdatestable->insert_addpatientphysicalexamsupdates($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldexamcode,$oldexam,$oldnotes,$updatenumber,$ekey,$currentusercode,$currentuser,$instcode);				
				
				$action = 'Edit Patient Physical Exams';							
				$result = $engine->getresults($sqlresults,$item=$physicalexamname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9787;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		
			}
		}

	break;
	
	// 5 oct 2023, 25 MAR 2021
	case 'removephysicalexams':

		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$physicalexam = htmlspecialchars(isset($_POST['physicalexam']) ? $_POST['physicalexam'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($physicalexam) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $physicalexam);
					$comcode = $com[0];
					$comname = $com[1];
					$sqlresults = $physicalexamstable->update_removepatientphysicalexams($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);			
				
				$action = 'Remove Patient Physical Exams';							
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9788;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		

			}
		}

	break;	
			
}
 

?>
