<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$treatmentmodel = isset($_POST['treatmentmodel']) ? $_POST['treatmentmodel'] : '';
	
	// 25 MAR 2021
switch ($treatmentmodel)
{


	// 25 MAR 2021
	case 'adddietnotes':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$doctorsnotes = isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '';
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($doctorsnotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$doctorsnotes = strtoupper($doctorsnotes);
				
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'DIETITICAN';
				$add = $treatmentsql->insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Doctors Notes';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." added Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title."  Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "139";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
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

	// 25 MAR 2021
	case 'addphysionotes':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$doctorsnotes = isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '';
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($doctorsnotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$doctorsnotes = strtoupper($doctorsnotes);
				
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'PHYSIOTHERAPY';
				$add = $treatmentsql->insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Doctors Notes';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." added Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title."  Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "139";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
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

	// 18 JAN 2023
	case 'editdoctornotes':
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$doctorsnotes = isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] :'';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
	
		if($preventduplicate == '1'){
			if( empty($doctorsnotes) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					
			//	$storyline = strtoupper($storyline);
				$edit = $treatmentsql->update_doctornotes($form_key,$days,$doctorsnotes,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Doctor Notes';
				if($edit == '0'){				
					$status = "error";					
					$msg = " $title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title Exist"; 					
				}else if($edit == '2'){
					// $event= "$title successfully ";
					// $eventcode= "191";
					// $audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					// 	if($audittrail == '2'){
							$status = "success";
							$msg = "$title for $patient Successfully";	
						// }else{
						// 	$status = "error";					
						// 	$msg = "Audit Trail Failed!"; 
						// }			
			}else{				
					$status = "error";					
					$msg = "Unknown source"; 					
			}
	
			}
		}
	
	break;
	

	// 30 MAR 2022 
	case 'editwounddressing':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
	
		if($preventduplicate == '1'){
			if( empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					
			//	$storyline = strtoupper($storyline);
				$edit = $treatmentsql->update_patientwounddressing($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Patient Wound dressing Note';
				if($edit == '0'){				
					$status = "error";					
					$msg = " ".$title." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "".$title." Exist"; 					
				}else if($edit == '2'){
					$event= "".$title." successfully ";
					$eventcode= "191";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." for ".$patient."  Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}			
			}else{				
					$status = "error";					
					$msg = "Unknown source"; 					
			}
	
			}
		}
	
		break;
	
	
	// 29 MAR 2022 JOSEPH ADORBOE 
	case 'addpatientwounddressing':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$woundservices = isset($_POST['woundservices']) ? $_POST['woundservices'] : '';
	//	$newprocedure = isset($_POST['newprocedure']) ? $_POST['newprocedure'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
		$types = isset($_POST['types']) ? $_POST['types'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($woundservices) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else {
				$ser = explode('@@@', $woundservices);
				$woundservicecode = $ser[0];
				$woundservicename = $ser[1];
			//	$storyline = strtoupper($storyline);
				$wounddressingrequestcode = $coder->getwounddressingnumber($instcode);
				$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                $serviceamount = $pricing->getcashprice($paymentmethodcode, $schemecode, $woundservicecode,$ptype,$instcodenuc, $instcode, $cashschemecode,$cashpaymentmethodcode);
                               
				$add = $treatmentsql->insert_patientwounddressing($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$woundservicecode,$woundservicename,$storyline,$wounddressingrequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$serviceamount,$currentusercode,$currentuser,$instcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear);
				$title = 'Patient Wound Dressing ';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." add Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title." Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "137";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
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
	
	
	// 26 MAR 2021
	case 'addpatientoxygen':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$oxygen = isset($_POST['oxygen']) ? $_POST['oxygen'] : '';
		$newoxygen = isset($_POST['newoxygen']) ? $_POST['newoxygen'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if( (empty($oxygen) && empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if((!empty($oxygen) && empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber)){
				$com = explode('@@@', $oxygen);
				$comcode = $com[0];
				$comname = $com[1];
			//	$storyline = strtoupper($storyline);
				$add = $treatmentsql->insert_patientoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Oxygen';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." Add Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title." Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "133";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}	
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

			}else if((empty($oxygen) && !empty($newoxygen)) || empty($storyline) || empty($patientcode) || empty($patientnumber)){
				
			//	$storyline = strtoupper($storyline);
				$newoxygen = strtoupper($newoxygen);
				$comcode = md5(microtime());
				$add = $treatmentsql->insert_patientaddoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$storyline,$newoxygen,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Oxygen';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." Add Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title." Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "133";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}	
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}
			}else if(!empty($oxygen) && !empty($newoxygen)){
				$status = "error";					
				$msg = "Oxgyen and new oxygen cannot be used together  "; 	

			}
		}

	break;

	

	// 26 MAR 2021
	case 'addpatientprocedure':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$newprocedure = isset($_POST['newprocedure']) ? $_POST['newprocedure'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
		$types = isset($_POST['types']) ? $_POST['types'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( (!empty($procedure) && !empty($newprocedure) ) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if( (!empty($procedure) && empty($newprocedure) ) || empty($patientcode) || empty($patientnumber) ){
				$com = explode('@@@', $procedure);
				$comcode = $com[0];
				$comname = $com[1];
			//	$storyline = strtoupper($storyline);
				$procedurerequestcode = $lov->getprocedurerequestcode($instcode);
				$add = $treatmentsql->insert_patientprocedure($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$procedurerequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
				$title = 'Patient Procedure';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." add Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title." Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "137";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

		}else if( (empty($procedure) && !empty($newprocedure) ) || empty($patientcode) || empty($patientnumber) ){
			
			$newprocedure = strtoupper($newprocedure);
		//	$storyline = strtoupper($storyline);
			$procedurerequestcode = $lov->getprocedurerequestcode($instcode);
			$comcode = md5(microtime());
			$procedurecode = $lov->getprocedurecode($instcode);
			$add = $treatmentsql->insert_patientaddprocedure($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$newprocedure,$storyline,$procedurerequestcode,$procedurecode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
			$title = 'Patient Procedure';
			if($add == '0'){				
				$status = "error";					
				$msg = "".$title." add Unsuccessful"; 
			}else if($add == '1'){						
				$status = "error";					
				$msg = "".$title." Exist";					
			}else if($add == '2'){
				$event= "".$title." added successfully ";
				$eventcode= "137";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){
					$status = "success";
					$msg = "".$title." for ".$patient."  Successfully";	
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

	
	
	// 25 MAR 2021
	case 'adddoctorsnotes':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$doctorsnotes = isset($_POST['doctorsnotes']) ? $_POST['doctorsnotes'] : '';
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($doctorsnotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$doctorsnotes = strtoupper($doctorsnotes);
				
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'OPD';
				$add = $treatmentsql->insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Doctors Notes';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." added Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title."  Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "139";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
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


	// 26 MAR 2021
	case 'addmanagement':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$managementnotes = isset($_POST['managementnotes']) ? $_POST['managementnotes'] : '';

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($managementnotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				
			//	$managementnotes = strtoupper($managementnotes);
				$add = $treatmentsql->insert_patientmanagementnotes($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$managementnotes,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Management Notes';
				if($add == '0'){				
					$status = "error";					
					$msg = " ".$title." add Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "".$title." Exist";					
				}else if($add == '2'){
					$event= "".$title." added successfully ";
					$eventcode= "131";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
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


		
	// 26 MAR 2021
	case 'editmanagement':

	$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
	$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
	$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
	$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

	if($preventduplicate == '1'){
		if( empty($storyline) ){
			$status = 'error';
			$msg = 'Required Field Cannot be empty';				
		}else{									
				
		//	$storyline = strtoupper($storyline);
			$edit = $treatmentsql->update_patientmanagement($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode);
			$title = 'Edit Patient Management Note';
			if($edit == '0'){				
				$status = "error";					
				$msg = " ".$title." Unsuccessful"; 
			}else if($edit == '1'){				
				$status = "error";					
				$msg = "".$title." Exist"; 					
			}else if($edit == '2'){
				$event= "".$title." successfully ";
				$eventcode= "130";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}			
		}else{				
				$status = "error";					
				$msg = "Unknown source"; 					
		}

		}
	}

	break;


	// 25 MAR 2021
	case 'editnotes':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$storyline = strtoupper($storyline);
				$edit = $treatmentsql->update_patientnotes($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode);
				$title = "Edit Patient Notes";
				if($edit == '0'){				
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title Exist"; 					
				}else if($edit == '2'){
					$event= "$title successfully ";
					$eventcode= "138";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = " $title for   Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source"; 					
			}
			}
		}
	break;


	
	// 25 MAR 2021
	case 'editprocedure':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($procedure) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $procedure);
					$comcode = $com[0];
					$comname = $com[1];
				//	$storyline = strtoupper($storyline);

				$remove = $treatmentsql->update_editpatientprocedure($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Patient Procedure';
				if($remove == '0'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Exist"; 					
				}else if($remove == '2'){
					$event= "".$title." successfully ";
					$eventcode= "136";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title."  Successfully";	
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

	// 25 MAR 2021 
	case 'removeprocedure':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$cancelreason = isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($cancelreason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				// $com = explode('@@@', $procedure);
				// $comcode = $com[0];
				// $comname = $com[1];
				//	$storyline = strtoupper($storyline);

				$remove = $treatmentsql->update_removepatientprocedure($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Patient Procedure';
				if($remove == '0'){				
					$status = "error";					
					$msg = " $title $comname  Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = " $title $comname  Exist"; 					
				}else if($remove == '2'){
					$event= " $title  successfully ";
					$eventcode= "135";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = " $title  Successfully";	
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
	
	// 26 MAR 2021
	case 'addnewprocdure':

		$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($procedure) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$procedure = strtoupper($procedure);
				$addnew = $treatmentsql->insert_newprocedure($form_key,$procedure,$description,$currentusercode,$currentuser,$instcode);
				$title = 'Add New Procedure';
				if($addnew == '0'){				
					$status = "error";					
					$msg = "".$title." ".$procedure." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "".$title." ".$procedure." Exist"; 						
				}else if($addnew == '2'){
					$event= "".$title." Added successfully ";
					$eventcode= "134";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}					
			}else{				
					$status = "error";					
					$msg = " Unknown source ";					
			}
			}
		}

	break;


	// 26 MAR 2021
	case 'addnewoxygen':

		$oxygen = isset($_POST['oxygen']) ? $_POST['oxygen'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($oxygen) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$oxygen = strtoupper($oxygen);
				$addnew = $treatmentsql->insert_newoxygen($form_key,$oxygen,$description,$currentusercode,$currentuser,$instcode);
				$title = "Add New Oxygen";
				if($addnew == '0'){				
					$status = "error";					
					$msg = "".$title." ".$oxygen." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "".$title." ".$oxygen." Exist"; 						
				}else if($addnew == '2'){
					$event= "".$title." successfully ";
					$eventcode= "132";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for ".$patient."  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
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
