<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$complainsmodel = isset($_POST['complainsmodel']) ? $_POST['complainsmodel'] : '';
	
	// 24 MAR 2021
switch ($complainsmodel)
{
	
	// 24 MAR 2021
	case 'addpatientcomplainsrepeat':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$hcomplaincode = isset($_POST['hcomplaincode']) ? $_POST['hcomplaincode'] : '';
		$hcomplain = isset($_POST['hcomplain']) ? $_POST['hcomplain'] : '';
		$hcomplainhistory = isset($_POST['hcomplainhistory']) ? $_POST['hcomplainhistory'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($hcomplaincode) || empty($hcomplain) ){
				$status = 'error';
				$msg = 'Complaints selected but saved successfully';				
			}else {

			//	$hcomplainhistory = strtoupper($hcomplainhistory);
				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$hcomplaincode,$hcomplain,$hcomplainhistory,$currentusercode,$currentuser,$instcode);

				if($addcomplains == '0'){				
					$status = "error";					
					$msg = "Add Patient Complains $hcomplain  Unsuccessful"; 
				}else if($addcomplains == '1'){						
					$status = "error";					
					$msg = "Patient Complains $hcomplain  Exist";					
				}else if($addcomplains == '2'){
					$status = "success";
						$msg = "Patient Complains $complain added Successfully";
					$event= "Patient Complains added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains $hcomplain added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}
			}
			
		}

	break;

	// 24 MAR 2021
	case 'editcomplains':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$complains = isset($_POST['complains']) ? $_POST['complains'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	//	if($preventduplicate == '1'){
			if(empty($complains) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $complains);
					$comcode = $com[0];
					$comname = $com[1];
			//		$storyline = strtoupper($storyline);

				$editpatientcomplains = $complainssql->update_patientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($editpatientcomplains == '0'){				
					$status = "error";					
					$msg = "Edit Patient Complains ".$comname." Unsuccessful"; 
				}else if($editpatientcomplains == '1'){				
					$status = "error";					
					$msg = "Edit patient Complains ".$comname." Exist"; 					
				}else if($editpatientcomplains == '2'){
					$status = "success";
						$msg = "Patient Complains $complains added Successfully";
					$event= "Patient Complains Edited successfully ";
					$eventcode= "149";
					$audittrail = 2;
				//	$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains ".$comname." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Add Payment Method Unknown source "; 					
			}

			}
	//	}

	break;


	// 24 MAR 2021
	case 'addpatientcomplainsbulk':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$complains = isset($_POST['complains']) ? $_POST['complains'] : '';
		$newcomplain = isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($complains) && empty($newcomplain) ){
				// $compl = explode('@@@', $complains);
				// $complainscode = $compl[0];
				// $complain = $compl[1];
				$complainscode = $complain = 'NA';
			//	$storyline = strtoupper($storyline);
				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				$status = 'error';
				$msg = 'Complaints Not selected but saved successfully';				
			}else if(!empty($complains) && empty($newcomplain)){

				$compl = explode('@@@', $complains);
				$complainscode = $compl[0];
				$complain = $compl[1];
			//	$storyline = strtoupper($storyline);

				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				if($addcomplains == '0'){				
					$status = "error";					
					$msg = "Add Patient Complains $complain  Unsuccessful"; 
				}else if($addcomplains == '1'){						
					$status = "error";					
					$msg = "Patient Complains $complain Exist";					
				}else if($addcomplains == '2'){
					$event= "Patient Complains added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains $complain added Successfully";
					// //	$url = "?$idvalue?1";
					// 	$url = "?$idvalue?$form_key";
					// //	$url = "?1";
					// 	$engine->redirect($url);						
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}

			}else if(empty($complains) && !empty($newcomplain)){

				$newcomplain = strtoupper($newcomplain);
			//	$storyline = strtoupper($storyline);
				$complainscode = md5(microtime());
				$addcomplains = $complainssql->insert_patientaddcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$newcomplain,$storyline,$currentusercode,$currentuser,$instcode);

				if($addcomplains == '0'){				
					$status = "error";					
					$msg = "Add Patient Complains $newcomplain  Unsuccessful"; 
				}else if($addcomplains == '1'){						
					$status = "error";					
					$msg = "Patient Complains $newcomplain Exist";					
				}else if($addcomplains == '2'){
					$event= "Patient Complains added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains $newcomplain added Successfully";
						// $url = "?$idvalue?$form_key";
						// $engine->redirect($url);	
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}


			}else if(!empty($complains) && !empty($newcomplain)){

				$complainscode = $complain = 'NA';
			//	$storyline = strtoupper($storyline);
				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				$status = 'error';
				$msg = 'Complaint and New Complaint Cannot be filled at the same time ';
			}

			
		}

	break;

	
	// 24 MAR 2021
	case 'addpatientcomplains':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$complains = isset($_POST['complains']) ? $_POST['complains'] : '';
		$newcomplain = isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($complains) && empty($newcomplain) ){
				// $compl = explode('@@@', $complains);
				// $complainscode = $compl[0];
				// $complain = $compl[1];
				$complainscode = $complain = 'NA';
			//	$storyline = strtoupper($storyline);
				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				$status = 'error';
				$msg = 'Complaints Not selected but saved successfully';				
			}else if(!empty($complains) && empty($newcomplain)){

				$compl = explode('@@@', $complains);
				$complainscode = $compl[0];
				$complain = $compl[1];
			//	$storyline = strtoupper($storyline);

				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				if($addcomplains == '0'){				
					$status = "error";					
					$msg = "Add Patient Complains $complain  Unsuccessful"; 
				}else if($addcomplains == '1'){						
					$status = "error";					
					$msg = "Patient Complains $complain  Exist";					
				}else if($addcomplains == '2'){
					$event= "Patient Complains added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains $complain added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}

			}else if(empty($complains) && !empty($newcomplain)){

				$newcomplain = strtoupper($newcomplain);
			//	$storyline = strtoupper($storyline);
				$complainscode = md5(microtime());
				$addcomplains = $complainssql->insert_patientaddcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$newcomplain,$storyline,$currentusercode,$currentuser,$instcode);

				if($addcomplains == '0'){				
					$status = "error";					
					$msg = "Add Patient Complains ".$newcomplain."  Unsuccessful"; 
				}else if($addcomplains == '1'){						
					$status = "error";					
					$msg = "Patient Complains ".$newcomplain."  Exist";					
				}else if($addcomplains == '2'){
					$event= "Patient Complains added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains ".$newcomplain." added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}


			}else if(!empty($complains) && !empty($newcomplain)){

				$complainscode = $complain = 'NA';
			//	$storyline = strtoupper($storyline);
				$addcomplains = $complainssql->insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode);

				$status = 'error';
				$msg = 'Complaint and New Complaint Cannot be filled at the same time ';
			}

			
		}

	break;



	
	
	// 24 MAR 2021
	case 'removecomplains':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$complains = isset($_POST['complains']) ? $_POST['complains'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($complains) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $complains);
					$comcode = $com[0];
					$comname = $com[1];
			//		$storyline = strtoupper($storyline);

				$editpatientcomplains = $complainssql->update_removepatientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($editpatientcomplains == '0'){				
					$status = "error";					
					$msg = "Remove Patient Complains ".$comname." Unsuccessful"; 
				}else if($editpatientcomplains == '1'){				
					$status = "error";					
					$msg = "Remove patient Complains ".$comname." Exist"; 					
				}else if($editpatientcomplains == '2'){
					$event= "Patient Complains Remove successfully ";
					$eventcode= "148";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Complains ".$comname." Removed Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Add Payment Method Unknown source "; 					
			}

			}
		}

	break;
	
	// 24 MAR 2021
	case 'addnewcomplains':

		$newcomplain = isset($_POST['newcomplain']) ? $_POST['newcomplain'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($newcomplain)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$newcomplain = strtoupper($newcomplain);
				$addnewcomplains = $complainssql->insert_newcomplains($form_key,$newcomplain,$description,$currentusercode,$currentuser,$instcode);
				if($addnewcomplains == '0'){				
					$status = "error";					
					$msg = "Add New Complains ".$newcomplain." Unsuccessful"; 
				}else if($addnewcomplains == '1'){					
					$status = "error";					
					$msg = "New Complains ".$newcomplain." Exist"; 						
				}else if($addnewcomplains == '2'){
					$event= "Add New Complains Added successfully ";
					$eventcode= "147";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New Complains ".$newcomplain." Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
				
			}else{				
					$status = "error";					
					$msg = "Add new complains ".$newcomplain."  Unknown source ";					
			}
			}
		}

	break;
	
}
 

?>
