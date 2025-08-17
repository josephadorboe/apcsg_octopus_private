<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$physicalexammodel = isset($_POST['physicalexammodel']) ? $_POST['physicalexammodel'] : '';
	
	// 25 MAR 2021 
switch ($physicalexammodel)
{
	// 24 MAR 2021
	case 'addpatientphysicalexammodel':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$physicalexams = isset($_POST['physicalexams']) ? $_POST['physicalexams'] : '';
		$newphysicalexams = isset($_POST['newphysicalexams']) ? $_POST['newphysicalexams'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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

				$addphysicalexam = $physicalexamssql->insert_patientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode);

				if($addphysicalexam == '0'){				
					$status = "error";					
					$msg = "Add Patient Physical Exams $physicalexam  Unsuccessful"; 
				}else if($addphysicalexam == '1'){						
					$status = "error";					
					$msg = "Patient Physical Exams $physicalexam Exist";					
				}else if($addphysicalexam == '2'){
					$event= "Patient Physical Exams added successfully ";
					$eventcode= "150";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Patient Physical Exam $physicalexam added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}
		}else if(empty($physicalexams) && !empty($newphysicalexams) ){

			
		//	$storyline = strtoupper($storyline);
			$newphysicalexams = strtoupper($newphysicalexams);
			$physicalexamcode = md5(microtime());

			$addphysicalexam = $physicalexamssql->insert_patientaddphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$newphysicalexams,$storyline,$currentusercode,$currentuser,$instcode);

			if($addphysicalexam == '0'){				
				$status = "error";					
				$msg = "Add Patient Physical Exams ".$newphysicalexams."  Unsuccessful"; 
			}else if($addphysicalexam == '1'){						
				$status = "error";					
				$msg = "Patient Physical Exams ".$newphysicalexams."  Exist";					
			}else if($addphysicalexam == '2'){
				$event= "Patient Physical Exams added successfully ";
				$eventcode= "150";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){			
					$status = "success";
					$msg = "Patient Physical Exams ".$newphysicalexams." added Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}				
		}else{				
				$status = "error";					
				$msg = "Unknown source "; 					
		}
			}else if(!empty($physicalexams) && !empty($newphysicalexams) ){
				$status = 'error';
				$msg = 'Physical exams and new physical exams cannot be selected at the same time';
			}

		}

	break;



	// 25 MAR 2021
	case 'editphysicalexams':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$physicalexam = isset($_POST['physicalexam']) ? $_POST['physicalexam'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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

				$edit = $physicalexamssql->update_patientphysicalexams($ekey,$days,$physicalexamcode,$physicalexamname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Patient Physical Exams ".$physicalexamname." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Patient Physical Exams ".$physicalexamname." Exist"; 					
				}else if($edit == '2'){
					$event= "Patient Physical Exams Edited successfully ";
					$eventcode= "145";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Physical Exams ".$physicalexamname." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source"; 					
			}

			}
		}

	break;
	
	// 25 MAR 2021
	case 'removephysicalexams':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$physicalexam = isset($_POST['physicalexam']) ? $_POST['physicalexam'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($physicalexam) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $physicalexam);
					$comcode = $com[0];
					$comname = $com[1];
				//	$storyline = strtoupper($storyline);

				$remove = $physicalexamssql->update_removepatientphysicalexams($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Patient Physical Exams ".$comname." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove patient Physical Exams ".$comname." Exist"; 					
				}else if($remove == '2'){
					$event= "Patient Physical Exams Remove successfully ";
					$eventcode= "144";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Physical Exams ".$comname." Removed Successfully";
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
	
	// 25 MAR 2021
	case 'addnewphysicalexams':

		$physicalexams = isset($_POST['physicalexams']) ? $_POST['physicalexams'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($physicalexams) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$physicalexams = strtoupper($physicalexams);
				$addnew = $physicalexamssql->insert_newphysicalexams($form_key,$physicalexams,$description,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Physical Exams ".$physicalexams." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Physical Exams ".$physicalexams." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Physical Exams Added successfully ";
					$eventcode= "143";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Physical Exams ".$physicalexams." Added Successfully";
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
