<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$diagnosismodel = isset($_POST['diagnosismodel']) ? $_POST['diagnosismodel'] : '';
	
	// 25 MAR 2021
switch ($diagnosismodel)
{


	// 2 JUNE 2022 JOSEPH ADORBOE 
	case 'repeatsinglediagnosis': 
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$diagnosiscode = isset($_POST['diagnosiscode']) ? $_POST['diagnosiscode'] : '';
		$diagnosisname = isset($_POST['diagnosisname']) ? $_POST['diagnosisname'] : '';
		$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';	
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($visitcode) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
		
					$repeatdiagnosis = $diagnosissql->insert_patientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode);
								
				if($repeatdiagnosis == '0'){					
					$status = "error";					
					$msg = "Add  Unsuccessful"; 
				}else if($repeatdiagnosis == '1'){						
					$status = "error";					
					$msg = "Diagnosis Exist Already"; 					
				}else if($repeatdiagnosis == '2'){	
					$event= " Add schedule $diagnosisname has been saved successfully ";
					$eventcode= 110;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Repeate diagnosis for $diagnosisname Added Successfully";
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}									
				}else{					
					$status = "error";					
					$msg = "Unknown Source";					
				}
		
			}
		}
	break;


	// 21 NOV 2021
	case 'saverepeatdiagnosis': 
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$newdiagnosis = isset($_POST['newdiagnosis']) ? $_POST['newdiagnosis'] : '';
		$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';	
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($visitcode) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
		//		$schedulecode = md5(microtime());
		//		$mainschedule = $schedulesql->insert_schedule($schedulecode,$scheduledate,$shifttype,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);

				foreach($_POST["scheckboxchronic"] as $chronicdetails){
				//	$schedulenumber = $lov->getschedulenumber($instcode);	
					$chrondet = explode('@@@',$chronicdetails);
					$diagnosiscode = $chrondet['0'];
					$diagnosisname = $chrondet['1'];
					$form_key = md5(microtime());
					$diagnosistype = 'CONFIRMED';
					$storyline = 'REPEAT DIAGNOSIS';
					$repeatdiagnosis = $diagnosissql->insert_patientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode);
				//	$staffschedule = $schedulesql->insert_staffschedule($staffschedulecode,$scheduledate,$shifttype,$staffdetcode,$staffdetname,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
								
				if($repeatdiagnosis == '0'){					
					$status = "error";					
					$msg = "Add  Unsuccessful"; 
				}else if($repeatdiagnosis == '1'){						
					$status = "error";					
					$msg = "Diagnosis Exist Already"; 					
				}else if($repeatdiagnosis == '2'){	
					$event= " Add schedule ".$diagnosisname." has been saved successfully ";
					$eventcode= 110;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Repeate diagnosis for $diagnosisname Added Successfully";
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}									
				}else{					
					$status = "error";					
					$msg = "Unknown Source";					
				}
			}
			}
		}
	break;



	// 25 MAR 2021
	case 'addpatientdiagnosis':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$newdiagnosis = isset($_POST['newdiagnosis']) ? $_POST['newdiagnosis'] : '';
		$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
		//	if (empty($diagnosis) && empty($newdiagnosis)) {
            if (empty($diagnosis)) {
                $status = 'error';
                $msg = 'Required Field Cannot be empty';
                //}else if(!empty($diagnosis) && empty($newdiagnosis)){
            }else{
                $diag = explode('@@@', $diagnosis);
                $diagnosiscode = $diag[0];
                $diagnosisname = $diag[1];
                // if (!empty($storyline)) {
                //     $storyline = strtoupper($storyline);
                // }

                $add = $diagnosissql->insert_patientdiagnosis($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient, $diagnosiscode, $diagnosisname, $diagnosistype, $storyline, $currentusercode, $currentuser, $instcode);
                if ($add == '0') {
                    $status = "error";
                    $msg = "Add Patient Diagnosis".$diagnosisname."  Unsuccessful";
                } elseif ($add == '1') {
                    $status = "error";
                    $msg = "Patient Diagnosis ".$diagnosisname."  Exist";
                } elseif ($add == '2') {
                    $event= "Patient Diagnosis added successfully ";
                    $eventcode= "142";
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = "Patient Diagnosis ".$diagnosisname." added Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail unsuccessful";
                    }
                } else {
                    $status = "error";
                    $msg = "Unknown source ";
                }
            }

		// }else if(empty($diagnosis) && !empty($newdiagnosis)){

		// 	$newdiagnosis = strtoupper($newdiagnosis);
		// 	$diagnosiscode = md5(microtime());
		// 	if(!empty($storyline)){
		// 		$storyline = strtoupper($storyline);
		// 	}				

		// 	$add = $diagnosissql->insert_patientadddiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$newdiagnosis,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode);
		// 	if($add == '0'){				
		// 		$status = "error";					
		// 		$msg = "Add Patient Diagnosis".$diagnosisname."  Unsuccessful"; 
		// 	}else if($add == '1'){						
		// 		$status = "error";					
		// 		$msg = "Patient Diagnosis ".$diagnosisname."  Exist";					
		// 	}else if($add == '2'){
		// 		$event= "Patient Diagnosis added successfully ";
		// 		$eventcode= "142";
		// 		$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
		// 		if($audittrail == '2'){				
		// 			$status = "success";
		// 			$msg = "Patient Diagnosis ".$diagnosisname." added Successfully";
		// 		}else{
		// 			$status = "error";
		// 			$msg = "Audit Trail unsuccessful";	
		// 		}				
		// 	}else{				
		// 			$status = "error";					
		// 			$msg = "Unknown source "; 					
		// 	}

		// }else if(!empty($diagnosis) && !empty($newdiagnosis)){
		// 	$status = "error";					
		// 	$msg = "diagnosis and new diagnosis cannot be used togther"; 
		// }

		}

	break;



	// 25 MAR 2021
	case 'editdiagnosis':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($diagnosis) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $diagnosis);
					$diagnosiscode = $com[0];
					$diagnosisname = $com[1];
					// if(!empty($storyline)){
					// 	$storyline = strtoupper($storyline);
					// }
					// $diagnosis = strtoupper($diagnosis);

				$edit = $diagnosissql->update_patientdiagnosis($ekey,$days,$diagnosiscode,$diagnosisname,$storyline,$diagnosistype,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Patient Diagnosis".$diagnosisname." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Patient Diagnosis".$diagnosisname." Exist"; 					
				}else if($edit == '2'){
					$event= "Patient Diagnosis Edited successfully ";
					$eventcode= "141";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Patient Diagnosis ".$diagnosisname." edited Successfully";
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
	case 'removediagnosis':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($diagnosis) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $diagnosis);
					$comcode = $com[0];
					$comname = $com[1];
					// if(!empty($storyline)){
					// 	$storyline = strtoupper($storyline);
					// }
				$remove = $diagnosissql->update_removepatientdiagnosis($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Patient Diagnosis ".$comname." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove patient Diagnosis ".$comname." Exist"; 					
				}else if($remove == '2'){
					$event= "Patient Diagnosis Remove successfully ";
					$eventcode= "140";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Diagnosis ".$comname." Removed Successfully";
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
	case 'addnewdiagnosis':

		$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($diagnosis) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				// if(!empty($storyline)){
				// 	$storyline = strtoupper($storyline);
				// }
				$diagnosis = strtoupper($diagnosis);
				$addnew = $diagnosissql->insert_newdiagnosis($form_key,$diagnosis,$description,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Diagnosis ".$diagnosis." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Diagnosis ".$diagnosis." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Diagnosis Added successfully ";
					$eventcode= "143";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Diagnosis ".$diagnosis." Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
				
			}else{				
					$status = "error";					
					$msg = " Unknown source ";					
			}
			}
		}

	break;
	
		
}
 

?>
