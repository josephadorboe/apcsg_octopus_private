<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$consulationmodel = isset($_POST['consulationmodel']) ? $_POST['consulationmodel'] : '';
	$dept = 'OPD';

	Global $instcode;
	
	// 20 FEB 2021  
	switch ($consulationmodel)
	{
		// 12 JUNE 2023 JOSEPH ADORBOE 
		case 'editdietvitals':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$bodyfat = isset($_POST['bodyfat']) ? $_POST['bodyfat'] : '';
			$musclefat = isset($_POST['musclefat']) ? $_POST['musclefat'] : '';
			$visceralfat = isset($_POST['visceralfat']) ? $_POST['visceralfat'] : '';
			$bmi = isset($_POST['bmi']) ? $_POST['bmi'] : '';
			$metabolicrate = isset($_POST['metabolicrate']) ? $_POST['metabolicrate'] : '';
			$hipcircumfernce = isset($_POST['hipcircumfernce']) ? $_POST['hipcircumfernce'] : '';
			$waistcircumfernce = isset($_POST['waistcircumfernce']) ? $_POST['waistcircumfernce'] : '';
			$waisthips = isset($_POST['waisthips']) ? $_POST['waisthips'] : '';
			$height = isset($_POST['height']) ? $_POST['height'] : '';
			$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){			
				if(empty($ekey) ||empty($bodyfat) || empty($musclefat) || empty($visceralfat) || empty($bmi) || empty($metabolicrate) || empty($hipcircumfernce)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$editmedicalreport = $consultationsql->update_patientdietvitals($ekey,$days,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$currentusercode,$currentuser,$instcode);
					$title = 'Edit Patient Diet Vitals';
					if($editmedicalreport == '0'){				
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editmedicalreport == '1'){				
						$status = "error";					
						$msg = "$title Exist"; 					
					}else if($editmedicalreport == '2'){
						$event= "$title successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title edited Successfully";
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
	// 12 JUNE 2023
	case 'addpatientdietvitals':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$bodyfat = isset($_POST['bodyfat']) ? $_POST['bodyfat'] : '';
		$musclefat = isset($_POST['musclefat']) ? $_POST['musclefat'] : '';
		$visceralfat = isset($_POST['visceralfat']) ? $_POST['visceralfat'] : '';
		$bmi = isset($_POST['bmi']) ? $_POST['bmi'] : '';
		$metabolicrate = isset($_POST['metabolicrate']) ? $_POST['metabolicrate'] : '';
		$hipcircumfernce = isset($_POST['hipcircumfernce']) ? $_POST['hipcircumfernce'] : '';
		$waistcircumfernce = isset($_POST['waistcircumfernce']) ? $_POST['waistcircumfernce'] : '';
		$waisthips = isset($_POST['waisthips']) ? $_POST['waisthips'] : '';
		$height = isset($_POST['height']) ? $_POST['height'] : '';
		$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
		$idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($bodyfat) || empty($musclefat) || empty($visceralfat) || empty($bmi) || empty($metabolicrate) || empty($hipcircumfernce)){				
				$status = 'error';
				$msg = 'Diet Vitals Not saved successfully';				
			}else{					
				$vitalsnumber = date("his");		
				$add = $consultationsql->insert_patientdietvitals($form_key,$days,$visitcode,$age,$gender,$patientcode, $patientnumber,$patient,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$vitalsnumber,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
			if ($add == '0') {
				$status = "error";
				$msg = "Add Patient diet Vitals Unsuccessful";
			} elseif ($add == '1') {
				$status = "error";
				$msg = "Patient diet Vitals Exist";
			} elseif ($add == '2') {
				$event= "Patient diet Vitals added successfully ";
				$eventcode= "150";
				$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
				if ($audittrail == '2') {
					$status = "success";
					$msg = "Patient diet Vitals added Successfully";
				} else {
					$status = "error";
					$msg = "Audit Trail unsuccessful";
				}
			} else {
				$status = "error";
				$msg = "Unknown source ";
			}
			}			
		}
	break;
		// 19 MAR 2023 JOSEPH ADORBOE 
		case 'editpatientreferal':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$history = isset($_POST['history']) ? $_POST['history'] : '';
			$finding = isset($_POST['finding']) ? $_POST['finding'] : '';
			$provisionaldiagnosis = isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '';
			$treatementgiven = isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '';
			$reasonreferal = isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($history) || empty($provisionaldiagnosis)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{							
					$editmedicalreport = $consultationsql->update_patientreferal($ekey,$days,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$currentusercode,$currentuser,$instcode);
					$title = 'Edit Patient Referal';
					if($editmedicalreport == '0'){				
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($editmedicalreport == '1'){				
						$status = "error";					
						$msg = "$title Exist"; 					
					}else if($editmedicalreport == '2'){
						$event= "$title successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "$title edited Successfully";
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
	// 19 MAR 2023
	case 'addpatientreferal':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$history = isset($_POST['history']) ? $_POST['history'] : '';
		$finding = isset($_POST['finding']) ? $_POST['finding'] : '';
		$provisionaldiagnosis = isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '';
		$treatementgiven = isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '';
		$reasonreferal = isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '';
		$vitalscode = isset($_POST['vitalscode']) ? $_POST['vitalscode'] : '';
		$idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) || empty($vitalscode)){				
				$status = 'error';
				$msg = 'Referal Not saved successfully';				
			}else{	
				$intro = "I will be most grateful if you would see this patient for further evaluation and management.";
				$referalnumber = date("his");		
				$addcomplains = $consultationsql->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
				$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);

			if ($addcomplains == '0') {
				$status = "error";
				$msg = "Add Patient Referal Unsuccessful";
			} elseif ($addcomplains == '1') {
				$status = "error";
				$msg = "Patient Referal Exist";
			} elseif ($addcomplains == '2') {
				$event= "Patient Referal added successfully ";
				$eventcode= "150";
				$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
				if ($audittrail == '2') {
					$status = "success";
					$msg = "Patient Referal added Successfully";
				
				} else {
					$status = "error";
					$msg = "Audit Trail unsuccessful";
				}
			} else {
				$status = "error";
				$msg = "Unknown source ";
			}
			}			
		}
		break;
		// 15 SEPT 2022  JOSEPH ADORBOE 
		case 'addpatientmedicalreportsingle':
			$patientdet = isset($_POST['patientdet']) ? $_POST['patientdet'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$servicereq = isset($_POST['servicereq']) ? $_POST['servicereq'] : '';
			$addressedto = isset($_POST['addressedto']) ? $_POST['addressedto'] : '';
			$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
			$diagnosisname = isset($_POST['diagnosisname']) ? $_POST['diagnosisname'] : '';
			$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
			$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($servicereq) || empty($diagnosistype) || empty($storyline) || empty($patientdet)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$compl = explode('@@@', $servicereq);
					$servicereqcode = $compl[0];
					$servicereqname = $compl[1];
					$pd = explode('@@@', $patientdet);
					$patientcode = $pd[0];
					$patientnumber = $pd[1];
					$patient = $pd[2];
					$dob = $pd[3];
					$gender = $pd[4];
					$age = $pat->getpatientbirthage($dob);
					$diagnosiscode = 11;
					$addressedto = "To Whom It May Concern";
					$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
					$serviceamount = $pricing->getprice($cashpaymentmethodcode,$paymentschemecode= $cashschemecode, $servicereqcode, $instcode, $cashschemecode,$ptype,$instcodenuc);
					$servicerequestcode = md5(microtime());
					$servicebillcode = md5(microtime());
					$requestnumber = $lov->getmedicalreportnumber($instcode);
					$consultationcode=$visitcode=md5(microtime());
					$addmedicalreport = $consultationsql->insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$serviceamount,
					$servicerequestcode,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode,$currentuserspec);

					if($addmedicalreport == '0'){				
						$status = "error";					
						$msg = "Add medical report ".$servicereqname."  Unsuccessful"; 
					}else if($addmedicalreport == '1'){						
						$status = "error";					
						$msg = "medical report ".$servicereqname."  Exist";					
					}else if($addmedicalreport == '2'){
						$event= "medical report added successfully ";
						$eventcode= "182";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "medical report ".$servicereqname." added Successfully";
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
		// 22 JAN 2022  JOSEPH ADORBOE 
		case 'editmedicalreportssingle':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$addressedto = isset($_POST['addressedto']) ? $_POST['addressedto'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if( empty($addressedto) || empty($storyline)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{									
					$editmedicalreport = $consultationsql->update_patientmedicalreportssingle($ekey,$days,$storyline,$addressedto,$currentusercode,$currentuser,$instcode);
					$title = 'Edit Patient Medical Report';
					if($editmedicalreport == '0'){				
						$status = "error";					
						$msg = "".$title." ".$addressedto." Unsuccessful"; 
					}else if($editmedicalreport == '1'){				
						$status = "error";					
						$msg = "".$title." ".$addressedto." Exist"; 					
					}else if($editmedicalreport == '2'){
						$event= "".$title." successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$addressedto." edited Successfully";
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
		// 14 OCT 2021 JOSEPH ADORBOE 
		case 'editmedicalreports':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$servicetype = isset($_POST['servicetype']) ? $_POST['servicetype'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$addressedto = isset($_POST['addressedto']) ? $_POST['addressedto'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($servicetype) || empty($addressedto) || empty($storyline)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{									
						$com = explode('@@@', $servicetype);
						$servicetypecode = $com[0];
						$servicetypename = $com[1];						
					$editmedicalreport = $consultationsql->update_patientmedicalreports($ekey,$days,$servicetypecode,$servicetypename,$storyline,$addressedto,$currentusercode,$currentuser,$instcode);
					$title = 'Edit Patient Medical Report';
					if($editmedicalreport == '0'){				
						$status = "error";					
						$msg = "".$title." ".$servicetypename." Unsuccessful"; 
					}else if($editmedicalreport == '1'){				
						$status = "error";					
						$msg = "".$title." ".$servicetypename." Exist"; 					
					}else if($editmedicalreport == '2'){
						$event= "".$title." successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$servicetypename." edited Successfully";
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
		// 13 OCT 2021 JOSEPH ADORBOE 
		case 'addpatientmedicalreport':
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$servicereq = isset($_POST['servicereq']) ? $_POST['servicereq'] : '';
			$addressedto = isset($_POST['addressedto']) ? $_POST['addressedto'] : '';
			$diagnosisname = isset($_POST['diagnosisname']) ? $_POST['diagnosisname'] : '';
			$diagnosis = isset($_POST['diagnosis']) ? $_POST['diagnosis'] : '';
			$diagnosistype = isset($_POST['diagnosistype']) ? $_POST['diagnosistype'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
			$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($servicereq) || empty($diagnosistype) || empty($storyline)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$compl = explode('@@@', $servicereq);
					$servicereqcode = $compl[0];
					$servicereqname = $compl[1];					
					$diagnosiscode = 11;
					$addressedto = "To Whom It May Concern";
					$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
					$serviceamount = $pricing->getprice($cashpaymentmethodcode,$paymentschemecode= $cashschemecode, $servicereqcode, $instcode, $cashschemecode,$ptype,$instcodenuc);
					$servicerequestcode = md5(microtime());
					$servicebillcode = md5(microtime());
					$requestnumber = $lov->getmedicalreportnumber($instcode);
					$addmedicalreport = $consultationsql->insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$serviceamount,
					$servicerequestcode,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode,$currentuserspec);
					if($addmedicalreport == '0'){				
						$status = "error";					
						$msg = "Add medical report ".$servicereqname."  Unsuccessful"; 
					}else if($addmedicalreport == '1'){						
						$status = "error";					
						$msg = "medical report ".$servicereqname."  Exist";					
					}else if($addmedicalreport == '2'){
						$event= "medical report added successfully ";
						$eventcode= "182";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "medical report ".$servicereqname." added Successfully";
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
		// 13 AUG 2021 JOSEPH ADORBOE 
		case 'addpatientchronic':
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$newchronic = isset($_POST['newchronic']) ? $_POST['newchronic'] : '';
			$chronic = isset($_POST['chronic']) ? $_POST['chronic'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($chronic) && empty($newchronic) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else if(!empty($chronic) && empty($newchronic)){
					$compl = explode('@@@', $chronic);
					$chroniccode = $compl[0];
					$chronicc = $compl[1];
					$storyline = strtoupper($storyline);
					$addchronic = $consultationsql->insert_patientchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$chronicc,$storyline,$currentusercode,$currentuser,$instcode);
					if($addchronic == '0'){				
						$status = "error";					
						$msg = "Add Patient Chronic ".$chronicc."  Unsuccessful"; 
					}else if($addchronic == '1'){						
						$status = "error";					
						$msg = "Patient Chronic ".$chronicc."  Exist";					
					}else if($addchronic == '2'){
						$event= "Patient Chronic added successfully ";
						$eventcode= "182";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "Patient Chronic ".$chronicc." added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}
				}else if(empty($chronic) && !empty($newchronic)){					
					$storyline = strtoupper($storyline);
					$newchronic = strtoupper($newchronic);
					$chroniccode = md5(microtime());
					$addchronic = $consultationsql->insert_patientaddchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$newchronic,$storyline,$currentusercode,$currentuser,$instcode);
					if($addchronic == '0'){				
						$status = "error";					
						$msg = "Add Patient Chronic ".$newchronic."  Unsuccessful"; 
					}else if($addchronic == '1'){						
						$status = "error";					
						$msg = "Patient Chronic ".$newchronic."  Exist";					
					}else if($addchronic == '2'){
						$event= "Patient Chronic added successfully ";
						$eventcode= "182";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "Patient Chronic ".$newchronic." added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}
			}else if(!empty($chronic) && !empty($newchronic)){
				$status = 'error';
				$msg = 'Chronic Condition  and new Chronic Condition Cannot be filled at the same time ';
				}
			}
		break;
		// 13 AUG  2021
		case 'addnewchronic':
			$newchronic = isset($_POST['newchronic']) ? $_POST['newchronic'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($newchronic)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$newchronic = strtoupper($newchronic);
					$addnewchronic = $consultationsql->insert_newchronic($form_key,$newchronic,$description,$currentusercode,$currentuser,$instcode);
					if($addnewchronic == '0'){				
						$status = "error";					
						$msg = "Add New Chronic ".$newchronic." Unsuccessful"; 
					}else if($addnewchronic == '1'){					
						$status = "error";					
						$msg = "New Chronic ".$newchronic." Exist"; 						
					}else if($addnewchronic == '2'){
						$event= "Add New Chronic Added successfully ";
						$eventcode= "181";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){			
							$status = "success";
							$msg = "New Chronic ".$newchronic." Added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Add new Chronic ".$newchronic."  Unknown source ";					
				}
				}
			}
		break;		
		// 13 AUG 2021 JOSEPH ADORBOE 
		case 'addpatientallergy':
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$allergy = isset($_POST['allergy']) ? $_POST['allergy'] : '';
			$newallergy = isset($_POST['newallergy']) ? $_POST['newallergy'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($allergy) && empty($newallergy)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';
				}else if(empty($allergy) && !empty($newallergy)){
					$newallergy = strtoupper($newallergy);
					$storyline = strtoupper($storyline);
					$allergycode = md5(microtime());
					$addallergy = $consultationsql->insert_patientaddallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$newallergy,$storyline,$currentusercode,$currentuser,$instcode);
					if($addallergy == '0'){				
						$status = "error";					
						$msg = "Add Patient Allergy ".$allergyy."  Unsuccessful"; 
					}else if($addallergy == '1'){						
						$status = "error";					
						$msg = "Patient Allergy ".$allergyy."  Exist";					
					}else if($addallergy == '2'){
						$event= "Patient Allergy added successfully ";
						$eventcode= "180";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "Patient Allergy ".$newallergy." added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}
				}else if(!empty($allergy) && empty($newallergy)){					
					$compl = explode('@@@', $allergy);
					$allergycode = $compl[0];
					$allergyy = $compl[1];
					$storyline = strtoupper($storyline);
					$addallergy = $consultationsql->insert_patientallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy,$storyline,$currentusercode,$currentuser,$instcode);
					if($addallergy == '0'){				
						$status = "error";					
						$msg = "Add Patient Allergy ".$allergyy."  Unsuccessful"; 
					}else if($addallergy == '1'){						
						$status = "error";					
						$msg = "Patient Allergy ".$allergyy."  Exist";					
					}else if($addallergy == '2'){
						$event= "Patient Allergy added successfully ";
						$eventcode= "180";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "Patient Allergy ".$allergyy." added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}				
			}else if(!empty($allergy) && !empty($newallergy)){
					$status = 'error';
					$msg = 'Allergy and new allergy Cannot be filled at the same time ';
				}
			}
		break;		
		// 13 AUG  2021
		case 'addnewallergy':
			$newallergy = isset($_POST['newallergy']) ? $_POST['newallergy'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){
				if(empty($newallergy)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$newallergy = strtoupper($newallergy);
					$addnewallergy = $consultationsql->insert_newallergy($form_key,$newallergy,$description,$currentusercode,$currentuser,$instcode);
					if($addnewallergy == '0'){				
						$status = "error";					
						$msg = "Add New Allergy ".$newallergy." Unsuccessful"; 
					}else if($addnewallergy == '1'){					
						$status = "error";					
						$msg = "New Allergy ".$newallergy." Exist"; 						
					}else if($addnewallergy == '2'){
						$event= "Add New Allergy Added successfully ";
						$eventcode= "179";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){			
							$status = "success";
							$msg = "New Allergy ".$newallergy." Added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Add new Allergy ".$newallergy."  Unknown source ";					
				}
				}
			}
		break;
		// 29 MAY 2021 JOSEPH ADORBOE 
		case 'addpatientdevices':
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
			$newdevices = isset($_POST['newdevices']) ? $_POST['newdevices'] : '';
			$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
			$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';	
			$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($devices)  && empty($newdevices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else if(!empty($devices)  && empty($newdevices)){
					$compl = explode('@@@', $devices);
					$devicescode = $compl[0];
					$devicesname = $compl[1];
					if(!empty($notes)){
						$notes = strtoupper($notes);
					}
					$patientdevicecode = $lov->getpatientdevicerequestcode($instcode);
					$type = 'OPD';
					$adddevices = $consultationsql->insert_patientdevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$devicesname,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode);
					$title = 'Add Patient Devices';
					if($adddevices == '0'){				
						$status = "error";					
						$msg = "".$title." ".$devicesname."  Unsuccessful"; 
					}else if($adddevices == '1'){						
						$status = "error";					
						$msg = "".$title." ".$devicesname."  Exist";					
					}else if($adddevices == '2'){
						$event= "".$title."  successfully ";
						$eventcode= "152";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." ".$devicesname."  Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}				
				}else{				
						$status = "error";					
						$msg = "Unknown source "; 					
				}
			}else if(empty($devices)  && !empty($newdevices)){		
				if(!empty($notes)){
					$notes = strtoupper($notes);
				}
				$newdevices = strtoupper($newdevices);				
				$patientdevicecode = $lov->getpatientdevicerequestcode($instcode);
				$type = 'OPD';
				$devicescode = md5(microtime());
				$adddevices = $consultationsql->insert_patientadddevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$newdevices,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode);
				$title = 'Add Patient Devices';
				if($adddevices == '0'){				
					$status = "error";					
					$msg = "".$title." ".$newdevices."  Unsuccessful"; 
				}else if($adddevices == '1'){						
					$status = "error";					
					$msg = "".$title." ".$newdevices."  Exist";					
				}else if($adddevices == '2'){
					$event= "".$title."  successfully ";
					$eventcode= "152";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$newdevices."  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}
		}else if(!empty($devices)  && !empty($newdevices)){
			$status = "error";					
			$msg = "Device and new Device cannot be used togther "; 
		}
		}
		break;
	// 29 MAY 2021
	case 'editdevices':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($devices)  || empty($quantity)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $devices);
					$comcode = $com[0];
					$comname = $com[1];
					if(!empty($notes)){
						$notes = strtoupper($notes);
					}					
				$editpatientdevices = $consultationsql->update_patientdevices($ekey,$days,$comcode,$comname,$storyline,$quantity,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Patient Devices';
				if($editpatientdevices == '0'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Unsuccessful"; 
				}else if($editpatientdevices == '1'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Exist"; 					
				}else if($editpatientdevices == '2'){
					$event= "".$title." successfully ";
					$eventcode= "149";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$comname." edited Successfully";
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
	// 29 MAY 2021
	case 'removedevices':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$cancelreason = isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($devices) || empty($cancelreason)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					$com = explode('@@@', $devices);
					$comcode = $com[0];
					$comname = $com[1];
					if(!empty($notes)){
						$notes = strtoupper($notes);
					}
				$editpatientdevices = $consultationsql->update_removepatientdevices($ekey,$days,$comcode,$comname,$storyline,$cancelreason,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Patient Devices';
				if($editpatientdevices == '0'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Unsuccessful"; 
				}else if($editpatientdevices == '1'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Exist"; 					
				}else if($editpatientdevices == '2'){
					$event= "".$title."  successfully ";
					$eventcode= "154";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$comname."  Successfully";
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
	// 29 MAY 2021
	case 'addnewdevices':
		$newdevices = isset($_POST['newdevices']) ? $_POST['newdevices'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($newdevices)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$newdevices = strtoupper($newdevices);
				$devicecode = $lov->getdevicecode($instcode);
				$addnewdevice = $consultationsql->insert_newdevice($form_key,$newdevices,$description,$devicecode,$currentusercode,$currentuser,$instcode);
				$title = 'New Devices Added';
				if($addnewdevice == '0'){				
					$status = "error";					
					$msg = "".$title." ".$newdevices." Unsuccessful"; 
				}else if($addnewdevice == '1'){					
					$status = "error";					
					$msg = "".$title." ".$newdevices." Exist"; 						
				}else if($addnewdevice == '2'){
					$event= "".$title." Added successfully ";
					$eventcode= "153";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New Complains ".$newdevices." Added Successfully";
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
	function physiomenuarchive($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$allegryalert,$chronicalert,$pendivestalert,$attachedalert,$vitals,$consultationpaymenttype){

		//$vitals = $consultationsql->getpatientvitals($patientcode,$visitcode,$instcode);
		?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> 
			 </div>
			
			</div>
			<div class="card-body">
				<div class="btn-list">
					<a href="physioservicebasketarchivesdetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
					<a href="physiopatienttreatmentarchive?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Treatment</a>
					<a href="managephysioservicebasketarchives" class="btn btn-outline-dark <?php if($consult == 3){ ?>active <?php } ?>">Back</a>
					<!--
						<a href="physiopatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 3){ ?>active <?php } ?>">Action</a>	
						<a href="consultationpatientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">History</a>
					<a href="#" class="btn btn-outline-secondary">Vitals</a>
					<a href="#" class="btn btn-outline-secondary">History</a>											
					
					--
					<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Previous Visit</a>
					
					<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>">Physical Exam</a>
					<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
					<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
					<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<!--
					<a href="#" class="btn btn-outline-success">Management</a>
					--
					<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<!--
						<a href="#" class="btn btn-outline-warning">Doctors Notes</a>
						<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>
						-->																						
				</div>								
			</div>							
		</div>
		<div class="row">
		<?php if($allegryalert !== '1'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has allergy
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if($chronicalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if($pendivestalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Referal" data-content="Referal ">
			New Walkin Physio Patient
			</button>
			</a>
		</div>
		<?php } 
		 else if($pendivestalert == '3'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Referal" data-content="Referal">
			Internal Referal Patient
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
	<?php } 
	function physiomenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$allegryalert,$chronicalert,$pendivestalert,$attachedalert,$vitals,$consultationpaymenttype){
		//$vitals = $consultationsql->getpatientvitals($patientcode,$visitcode,$instcode);
		?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> 
			 </div>			
			</div>
			<div class="card-body">
				<div class="btn-list">
					<a href="physioservicebasketdetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
					<a href="physiopatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Treatment</a>
					<a href="physiopatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 3){ ?>active <?php } ?>">Action</a>	
					<!--
						<a href="consultationpatientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">History</a>
					<a href="#" class="btn btn-outline-secondary">Vitals</a>
					<a href="#" class="btn btn-outline-secondary">History</a>											
					
					--
					<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Previous Visit</a>
					
					<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>">Physical Exam</a>
					<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
					<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
					<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<!--
					<a href="#" class="btn btn-outline-success">Management</a>
					--
					<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<!--
						<a href="#" class="btn btn-outline-warning">Doctors Notes</a>
						<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>
						-->																
				</div>	
				<br />
				<?php 
					// if($vitals !== '1'){
					// 	$vt = explode('@', $vitals);
					// 	$bp = $vt[0];
					// 	$temp = $vt[1];
					// 	$height = $vt[2];
					// 	$weight = $vt[3];
					// 	$fbs = $vt[4];
					// 	$pulse = $vt[7];
					// 	$spo2 = $vt[8];

					// }else{
					// 	$bp = $temp = $height = $weight = $fbs = $pulse = 'NA';
					// }
				?>
				<!--
				<div class="card-title"> Vitals : BP - <?php //echo $bp??''; ?> , Temperature - <?php //echo $temp??''; ?> , Pulse - <?php //echo $pulse??''; ?> , Height - <?php //echo $height??''; ?> , Weight - <?php //echo $weight??''; ?> , SPO2 - <?php //echo $spo2??''; ?> , FBS - <?php //echo $fbs??''; ?>  </div>	
					-->						
			</div>								
		</div>
		<div class="row">
		<?php if($allegryalert !== '1'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has allergy
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if($chronicalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if($pendivestalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Referal" data-content="Referal ">
			New Walkin Physio Patient
			</button>
			</a>
		</div>
		<?php } 
		 else if($pendivestalert == '3'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Referal" data-content="Referal">
			Internal Referal Patient
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
	<?php } 	
	function consultationmenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$allegryalert,$chronicalert,$pendivestalert,$attachedalert,$vitals,$consultationpaymenttype){
		//$vitals = $consultationsql->getpatientvitals($patientcode,$visitcode,$instcode);
		?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> 
			 </div>
			
			</div>
			<div class="card-body">
				<div class="btn-list">
					<a href="consultationdetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient </a>
					<a href="consultationpatientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">History</a>
					<!--
					<a href="#" class="btn btn-outline-secondary">Vitals</a>
					<a href="#" class="btn btn-outline-secondary">History</a>											
					
					-->
					<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Last Visit</a>
					<a href="consultationpatientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Complaints</a>
					<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>"> Exam</a>
					<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
					<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
					<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<!--
					<a href="#" class="btn btn-outline-success">Management</a>
					-->
					<a href="consultationpatientdoctornotes?<?php echo $idvalue ?>?1" class="btn btn-outline-success <?php if($consult == 14){ ?>active <?php } ?>">Doctor Notes</a>
					<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<a href="consultationpatientphysiotheraphy?<?php echo $idvalue ?>?1" class="btn btn-outline-info <?php if($consult == 12){ ?>active <?php } ?>">Physiotherapy</a>
					<a href="consultationpatientdietetics?<?php echo $idvalue ?>?1" class="btn btn-outline-info <?php if($consult == 13){ ?>active <?php } ?>">Dietetics</a>
					<!-- <a href="#" class="btn btn-outline-warning">Doctors Notes</a>	-->
					<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>
					<a href="consultationpatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 7){ ?>active <?php } ?>">Action</a>													
				</div>	
				<br />
				<?php 
					if($vitals !== '1'){
						$vt = explode('@', $vitals);
						$bp = $vt[0];
						$temp = $vt[1];
						$height = $vt[2];
						$weight = $vt[3];
						$fbs = $vt[4];
						$pulse = $vt[7];
						$spo2 = $vt[8];

					}else{
						$bp = $temp = $height = $weight = $fbs = $pulse = 'NA';
					}
				?>
				<div class="card-title"> Vitals : BP - <?php echo $bp??''; ?> , Temperature - <?php echo $temp??''; ?> , Pulse - <?php echo $pulse??''; ?> , Height - <?php echo $height??''; ?> , Weight - <?php echo $weight??''; ?> , SPO2 - <?php echo $spo2??''; ?> , FBS - <?php echo $fbs??''; ?>  </div>	
			</div>							
		</div>
		<div class="row">
		<?php if($allegryalert !== '1'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has allergy
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if($chronicalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if($pendivestalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Investigations" data-content="Patient has Pending Investigations ">
			Patient has Pending Investigations
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if($attachedalert == '2'){ ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="consultationdetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content="Patient has Attached Results ">
			Patient has Attached Results 
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
	<?php } 
	function patientfolderconsultationmenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult){
		?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Patient Folder Details: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years </div>
			</div>
			<div class="card-body">
				<div class="btn-list">
					<a href="patientfolderlistdetailsvisit?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
					<a href="consultationpatientlegacypatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>"> History</a>
					<!--
					<a href="#" class="btn btn-outline-secondary">Vitals</a>
					<a href="#" class="btn btn-outline-secondary">History</a>					
					<a href="consultationpatientlastvisitpatientfolder?<?php // echo $idvalue ?>" class="btn btn-outline-success <?php // if($consult == 8){ ?>active <?php // } ?>">Last Visit</a>
					-->
					<a href="consultationpatientcomplainspatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Complaints</a>
					<a href="consultationpatientphysicalexamspatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>"> Exam</a>
					<a href="consultationpatientinvestigationpatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
					<a href="consultationpatientdiagnosispatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
					<a href="consultationpatientprescriptionpatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<a href="consultationpatientattachedresultspatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 12){ ?>active <?php } ?>">Results Attached</a>
					<a href="patientfolderlistmedicalreport?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 13){ ?>active <?php } ?>">Medical Report</a>
					<a href="consultationpatienttreatmentpatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<a href="patientfolderlistnotes?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 14){ ?>active <?php } ?>">Notes</a>
					<a href="consultationpatientvisitoutcomepatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 7){ ?>active <?php } ?>">Visit Outcome</a>
					<!--
						<a href="#" class="btn btn-outline-warning">Doctors Notes</a>
						<a href="consultationpatientsummary?<?php // echo $idvalue ?>" class="btn btn-outline-danger <?php   //if($consult == 6){ ?>active <?php //} ?>">Summary</a>
						
					<a href="consultationpatientactionpatientfolder?<?php // echo $idvalue ?>" class="btn btn-outline-danger <?php //if($consult == 7){ ?>active <?php //} ?>">Summary</a>	
					-->												
				</div>												
			</div>	
			<div class="col-md-3 mt-2 mb-2">		
					<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="" data-content="">
					<?php echo $patient; ?> Folder 
					</button>					
				</div>						
		</div>
	<?php } 
function consultationdetailsmenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult){
	?>
	<div class="card">
		<div class="card-header">
		<div class="card-title">Details: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years </div>
		</div>
		<div class="card-body">
			<div class="btn-list">
					<!--
					<a href="consultationdetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
					<a href="consultationpatientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">Past History</a>
					<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Last Visit</a>
					<a href="consultationpatientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Complaints</a>
					<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>">Physical Exams</a>
					<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
					<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
					<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>					
					<a href="consultationpatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 7){ ?>active <?php } ?>">Action</a>	
					-->												
			</div>									
		</div>						
	</div>
<?php } 
function consultationobgymenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult){
	?>
	<div class="card">
		<div class="card-header">
		<div class="card-title">Details: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years </div>
		</div>
		<div class="card-body">
			<div class="btn-list">
				<a href="consultationobgydetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
				<a href="consultationpatientobgyhistory?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">OB/GYN History</a>
				<a href="consultationpatientobgyopd?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Consultation</a>
				<!--
				<a href="consultationpatientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Complaints</a>
				<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>">Physical Exams</a>
				-->
				<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
				<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
				<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>
				<!--											
				<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
				-->
				<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>
				<a href="consultationpatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 7){ ?>active <?php } ?>">Action</a>													
			</div>									
		</div>						
	</div>
<?php } 	
function consultationarchivemenu($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$allegryalert,$chronicalert,$pendivestalert,$attachedalert,$vitals,$consultationpaymenttype){

	//$vitals = $consultationsql->getpatientvitals($patientcode,$visitcode,$instcode);
	?>
	<div class="card">
		<div class="card-header">
		<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($consultationpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?> 
		 </div>
		
		</div>
		<div class="card-body">
			<div class="btn-list">
				<!--
				<a href="consultationdetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 1){ ?>active <?php } ?>">Patient Details</a>
				<a href="consultationpatientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 11){ ?>active <?php } ?>">Medical History</a>
				<!--
				<a href="#" class="btn btn-outline-secondary">Vitals</a>
				<a href="#" class="btn btn-outline-secondary">History</a>											
				
				--
				<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 8){ ?>active <?php } ?>">Previous Visit</a>
				<a href="consultationpatientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 2){ ?>active <?php } ?>">Complaints</a>
				<a href="consultationpatientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if($consult == 3){ ?>active <?php } ?>">Physical Exam</a>
				<a href="consultationpatientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 10){ ?>active <?php } ?>">Investigations</a>
				<a href="consultationpatientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 4){ ?>active <?php } ?>">Diagnosis</a>
				<a href="consultationpatientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
				<!--
				<a href="#" class="btn btn-outline-success">Management</a>
				--
				<a href="consultationpatienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
				<!--
					<a href="#" class="btn btn-outline-warning">Doctors Notes</a>
					
					--
					<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 6){ ?>active <?php } ?>">Summary</a>
				<a href="consultationpatientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 7){ ?>active <?php } ?>">Action</a>
				-->													
			</div>	
			<br />
			<?php 
				if(!empty($vitals)){
					$vt = explode('@', $vitals);
					$bp = $vt[0];
					$temp = $vt[1];
					$height = $vt[2];
					$weight = $vt[3];
					$fbs = $vt[4];
					$pulse = $vt[7];
				}else{
					$bp = $temp = $height = $weight = $fbs = $pulse = '';
				}	
			?>
			<div class="card-title">Vitals : BP - <?php echo $bp; ?> , Temperature - <?php echo $temp; ?> , Pulse - <?php echo $pulse; ?> , Height - <?php echo $height; ?> , Weight - <?php echo $weight; ?> , FBS - <?php echo $fbs; ?>  </div>									
		</div>	
						
	</div>
	<div class="row">
	<?php if($allegryalert == '2'){ ?>			
	<div class="col-md-3 mt-2 mb-2">
		<a href="consultationdetails?<?php echo $idvalue ?>">
		<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
		Patient has ALLERGY
		</button>
		</a>
	</div>
	<?php } ?>

	<?php if($chronicalert == '2'){ ?>			
	<div class="col-md-3 mt-2 mb-2">
		<a href="consultationdetails?<?php echo $idvalue ?>">
		<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
		Patient has CHRONIC Condition
		</button>
		</a>
	</div>
	<?php } ?>
	<?php if($pendivestalert == '2'){ ?>			
	<div class="col-md-3 mt-2 mb-2">
		<a href="consultationdetails?<?php echo $idvalue ?>">
		<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Investigations" data-content="Patient has Pending Investigations ">
		Patient has Pending Investigations
		</button>
		</a>
	</div>
	<?php } ?>
	<?php if($attachedalert == '2'){ ?>			
	<div class="col-md-3 mt-2 mb-2">
		<a href="consultationdetails?<?php echo $idvalue ?>">
		<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content="Patient has Attached Results ">
		Patient has Attached Results 
		</button>
		</a>
	</div>
	<?php } ?>
	</div>
<?php } ?>
