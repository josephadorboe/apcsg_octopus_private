<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$admissionmodel = htmlspecialchars(isset($_POST['admissionmodel']) ? $_POST['admissionmodel'] : '');
	$dept = 'IPD';

	Global $instcode; 
	
	// 11 JAN 2022 JOSEPH ADORBOE assignbeds
	switch ($admissionmodel)
	{

	// 13 JUNE 2023 JOSEPH ADORBOE
	case 'savepatienthandovernotes':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$handovernotes = htmlspecialchars(isset($_POST['handovernotes']) ? $_POST['handovernotes'] : '');
		$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
		$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($handovernotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$doctorsnotes = strtoupper($doctorsnotes);
				
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'HANDOVER';
				$service = "Amission";
				$add = $treatmentsql->insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$service,$service,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$handovernotes,$currentusercode,$currentuser,$instcode);
				$title = "Handover Notes";
				if($add == '0'){				
					$status = "error";					
					$msg = "$title added Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "$title  Exist";					
				}else if($add == '2'){
					$event= "$title added successfully ";
					$eventcode= "139";
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


	// // 23 APR 2022  JOSEPH ADORBOE 
	// case 'savepatientvitals':			
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
	// 	$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
	// 	$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$patientvitalstatus = htmlspecialchars(isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '');
	// 	$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
	// 	$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
	// 	$bp = htmlspecialchars(isset($_POST['bp']) ? $_POST['bp'] : '');
	// 	$temperature = htmlspecialchars(isset($_POST['temperature']) ? $_POST['temperature'] : '');
	// 	$height = htmlspecialchars(isset($_POST['height']) ? $_POST['height'] : '');
	// 	$spo = htmlspecialchars(isset($_POST['spo']) ? $_POST['spo'] : '');
	// 	$weight = htmlspecialchars(isset($_POST['weight']) ? $_POST['weight'] : '');
	// 	$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
	// 	$pulse = htmlspecialchars(isset($_POST['pulse']) ? $_POST['pulse']: '') ;
	// 	$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
	// 	if($preventduplicate == '1'){
	// 		if($currentshiftcode == '0'){				
	// 			$status = "error";
	// 			$msg = "Shift is closed";	 				
	// 		}else{
				
	// 			$fbs=$rbs=$glucosetest='NA';
	// 			$insertcheck = $admissionsql->insert_admissionpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear);	

	// 			if($insertcheck == '0'){				
	// 				$status = "error";					
	// 				$msg = "Adding Patient $patient Vitals Unsuccessful"; 
	// 			}else if($insertcheck == '1'){			
	// 				$status = "error";					
	// 				$msg = "Patient Vitals for $patient already Exist"; 			
	// 			}else if($insertcheck == '2'){				
	// 				$status = "success";
	// 				$msg = "Patient $patient Vitals added Successfully";
	// 				$event= "ADD PATIENT VITALS CODE: $form_key $patientcode $patient has been saved successfully ";
	// 				$eventcode= 52;
	// 				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);												
	// 			}else{				
	// 				$status = "error";					
	// 				$msg = "Add New Users Unsuccessful "; 				
	// 			}
	// 		}
				
	// 	}			
	// break;


	// 29 JUNE 2024 JOSEPH ADORBOE 
	case 'editpatientchronic':			
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$chronic = htmlspecialchars(isset($_POST['chronic']) ? $_POST['chronic'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
				if(empty($chronic)  || empty($ekey)  ){
					$status = "error";
					$msg = "Required Field cannot be empty";	
				}else{
					$pers = explode('@@@', $chronic);
					$chroniccode = $pers[0];
					$chronicname = $pers[1];

					$sqlresults = $patientchronictable->editpatientchronic($ekey,$chroniccode,$chronicname,$currentusercode,$currentuser,$instcode);
					$action = "Edit Patient Allergy";
					$result = $engine->getresults($sqlresults,$item=$chronicname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9808;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
			}
		}
					
	break;	

	// 29 JUNE 2024, 22 APR 2022  JOSEPH ADORBOE  
	case 'assignbeds':
		$admissioncode = htmlspecialchars(isset($_POST['admissioncode']) ? $_POST['admissioncode'] : '');
		$wardbeds = htmlspecialchars(isset($_POST['wardbeds']) ? $_POST['wardbeds'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($admissioncode) || empty($wardbeds) || empty($patientcode) || empty($patientnumber) || empty($patient) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
				$pers = explode('@@@', $wardbeds);
				$bedcode = $pers[0];
				$bedname = $pers[1];
				$wardcode = $pers[2];
				$wardname = $pers[3];
				$bedgender = $pers[4];
				$bedrate = $pers[5]; 								
				$sqlresults = $patientsadmissiontable->assignbed($admissioncode,$bedcode,$bedname,$wardcode,$wardname,$bedgender,$bedrate,$currentuser,$currentusercode,$instcode);
				$action = "Assign Bed <b> $bedname </b> to ";
				$result = $engine->getresults($sqlresults,$item=$patientnumber.' - '.$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9812;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			}
		}
	break;	

	// 29 JUNE 2024 JOSEPH ADORBOE 
	case 'editpatientallergy':			
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$allergy = htmlspecialchars(isset($_POST['allergy']) ? $_POST['allergy'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
				if(empty($allergy)  || empty($ekey)  ){
					$status = "error";
					$msg = "Required Field cannot be empty";	
				}else{				
					$sqlresults = $patientsallergytable->editpatientallergy($ekey,$allergy,$currentusercode,$currentuser,$instcode);
					$action = "Edit Patient Allergy";
					$result = $engine->getresults($sqlresults,$item=$allergy,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9809;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
			}
		}
					
	break;	

	// 29 JUNE 2024 JOSEPH ADORBOE 
	case 'savepatientallergy':			
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$allergyone = htmlspecialchars(isset($_POST['allergyone']) ? $_POST['allergyone']: '') ; 
		$allergytwo = htmlspecialchars(isset($_POST['allergytwo']) ? $_POST['allergytwo']: '') ; 
		$allergythree = htmlspecialchars(isset($_POST['allergythree']) ? $_POST['allergythree']: '') ; 
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
				if(empty($allergyone)  || empty($patientcode)  ){
					$status = "error";
					$msg = "Required Field cannot be empty";	
				}else{				

				if(!(empty($allergyone))){                       
					$allergycode = rand(100,1000);
					$form_key = md5(microtime());
					$sqlresults = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyone,$days,$currentusercode,$currentuser,$instcode);	                      
				}

				if(!(empty($allergytwo))){                       
					$allergycode = rand(100,1000);
					$form_key = md5(microtime());
					$sqlresults = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergytwo,$days,$currentusercode,$currentuser,$instcode);	                      
				}

				if(!(empty($allergythree))){                       
					$allergycode = rand(100,1000);
					$form_key = md5(microtime());
					$sqlresults = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergythree,$days,$currentusercode,$currentuser,$instcode);	                      
				}				
					$action = "Patient Allergy";
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9811;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
				}
			}
		}
					
	break;	

	// 13 AUG 2021 JOSEPH ADORBOE 
	case 'addpatientchronic':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$newchronic = htmlspecialchars(isset($_POST['newchronic']) ? $_POST['newchronic'] : '');
		$chronic = htmlspecialchars(isset($_POST['chronic']) ? $_POST['chronic'] : '');
		$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
				$consultationcode=md5(microtime());
				$sqlresults = $patientchronictable->insert_patientchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$chronicc,$storyline,$currentusercode,$currentuser,$instcode);
				$action = "Chronic added successfully";
				$result = $engine->getresults($sqlresults,$item=$chronicc,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9810;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 	
			}else if(empty($chronic) && !empty($newchronic)){					
				$storyline = strtoupper($storyline);
				$newchronic = strtoupper($newchronic);
				$chroniccode = md5(microtime());
				$consultationcode=md5(microtime());
				$sqlresults = $patientchronictable->insert_patientaddchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$newchronic,$storyline,$currentusercode,$currentuser,$instcode);
				$action = "Chronic added successfully";
				$result = $engine->getresults($sqlresults,$item=$newchronic,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9810;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 	
		}else if(!empty($chronic) && !empty($newchronic)){
			$status = 'error';
			$msg = 'Chronic Condition  and new Chronic Condition Cannot be filled at the same time ';
			}
		}
	break;

	// 29 JUNE 2024,  JOSEPH ADORBOE 
	case 'savepatientvitals':			
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$bp = htmlspecialchars(isset($_POST['bp']) ? $_POST['bp'] : '');
		$temperature = htmlspecialchars(isset($_POST['temperature']) ? $_POST['temperature'] : '');
		$height = htmlspecialchars(isset($_POST['height']) ? $_POST['height'] : '');
		$spo = htmlspecialchars(isset($_POST['spo']) ? $_POST['spo'] : '');
		$weight = htmlspecialchars(isset($_POST['weight']) ? $_POST['weight'] : '');
		$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
		$physician = htmlspecialchars(isset($_POST['physician']) ? $_POST['physician'] : '');
		$serial = htmlspecialchars(isset($_POST['serial']) ? $_POST['serial'] : '');
		$serialnumber = htmlspecialchars(isset($_POST['serialnumber']) ? $_POST['serialnumber']: '' );
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '' );
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '' );
		$patientschemecode = htmlspecialchars(isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '' );
		$patientscheme = htmlspecialchars(isset($_POST['patientscheme']) ? $_POST['patientscheme']: '') ;
		$patientservicecode = htmlspecialchars(isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '') ;
		$patientservice = htmlspecialchars(isset($_POST['patientservice']) ? $_POST['patientservice']: '');
		$fbs = htmlspecialchars(isset($_POST['fbs']) ? $_POST['fbs']: '' );
		$rbs = htmlspecialchars(isset($_POST['rbs']) ? $_POST['rbs']: '') ;
		$glucosetest = htmlspecialchars(isset($_POST['glucosetest']) ? $_POST['glucosetest']: '') ;
		$vitalscode = htmlspecialchars(isset($_POST['vitalscode']) ? $_POST['vitalscode']: '') ;
		$pulse = htmlspecialchars(isset($_POST['pulse']) ? $_POST['pulse']: '') ;
		$paymenttype = htmlspecialchars(isset($_POST['paymenttype']) ? $_POST['paymenttype']: '') ;
		$chargerbs = htmlspecialchars(isset($_POST['chargerbs']) ? $_POST['chargerbs']: '') ;
		$billingcode = htmlspecialchars(isset($_POST['billingcode']) ? $_POST['billingcode']: '') ;
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan']: '') ; 
		$allergyone = htmlspecialchars(isset($_POST['allergyone']) ? $_POST['allergyone']: '') ; 
		$allergytwo = htmlspecialchars(isset($_POST['allergytwo']) ? $_POST['allergytwo']: '') ; 
		$allergythree = htmlspecialchars(isset($_POST['allergythree']) ? $_POST['allergythree']: '') ; 
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
				if(empty($bp) || empty($patientcode) || empty($temperature)){
					$status = "error";
					$msg = "Required Field cannot be empty";	
				}else{
					$dept = "IPD";			
					$sqlresults = $patientvitalstable->insert_newpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear);
					$action = "Patient Vitals added";
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9828;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
										
				}
				
			}
		}
			
	break;	

	}

    function admissionmenu($patient, $patientnumber, $paymentmethod, $scheme, $gender, $age, $idvalue, $consult, $allegryalert, $chronicalert, $pendivestalert, $attachedalert, $vitals,$admissiontype,$admissiondoctor,$admissionnotes,$admissiontriage ,$admissionpaymenttype,$admissionward,	$admissionbed,$admissionsduration,$admissiondate,$admissionnumber,$admissionsservice,$admissionsservicecode)
    {
        ?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($admissionpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?>  - <?php echo(($admissiontype == '1')?'DETAIN':(($admissiontype == '2')?'ADMISSION':'EMERGENCY')); ?> 
			 </div>		
			</div>
			
			<div class="card-body">
			<div class="btn-list">
			<!-- <a href="manageadmission" class="btn btn-dark <?php if ($consult == 11) { ?>active <?php } ?>">Back</a>
			<br /> -->
			<a href="admission__admissiondetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 1) { ?>active <?php } ?>">Patient Details</a>
			<a href="admission__patientvitals?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 2) { ?>active <?php } ?>">Vitals</a>
			<a href="admissionpatientnotes?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 12) { ?>active <?php } ?>">Notes</a>
			<a href="admission__patientvisit?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 3) { ?>active <?php } ?>">Visit Summary</a>
			<a href="admission__patientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 4) { ?>active <?php } ?>">History</a>
			<a href="admission__patientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if ($consult == 5) { ?>active <?php } ?>">Complaints</a>
			<a href="admission__patientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 6) { ?>active <?php } ?>">Physical Exam</a>
			<a href="admission__patientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 7) { ?>active <?php } ?>">Investigations</a>
			<a href="admission__patientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 8) { ?>active <?php } ?>">Diagnosis</a>
			<a href="admission__patientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 9) { ?>active <?php } ?>">Prescription</a>
			<a href="admission__patienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 10) { ?>active <?php } ?>">Treatment</a>
			
			<a href="admission__patientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 11) { ?>active <?php } ?>">Action</a>	
									
				</div>	
				<br />
				<div class="row">										
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission No*</label>
								<?php echo $admissionnumber; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission Date*</label>
								<?php echo date('D d M Y H:i:s a',strtotime($admissiondate)); ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Ward*</label>
								<?php echo $admissionward; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Bed*</label>
							<?php echo $admissionbed; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Triage*</label>
							<?php echo $admissiontriage; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Doctor*</label>
							<?php echo $admissiondoctor; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Duration*</label>
							<?php echo $admissionsduration; ?> Days
							</div>											
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Service*</label>
							<?php echo $admissionsservice; ?>
							</div>											
						</div>
	
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admiting Notes*</label>
							<?php echo $admissionnotes; ?>
							</div>											
						</div>
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
				<div class="card-title">Vitals : BP - <?php echo $bp; ?> , Temperature - <?php echo $temp; ?> , Pulse - <?php echo $pulse; ?> , Height - <?php echo $height; ?> , Weight - <?php echo $weight; ?> , FBS - <?php echo $fbs; ?>  </div>	
										
			</div>	
							
		</div>
			
		<div class="row">
		<?php if (empty($admissionbed)) { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient NOT Assigned to a Bed">
			Patient NOT Assigned to a Bed 
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if ($allegryalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has ALLERGY
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if ($chronicalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($pendivestalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Investigations" data-content="Patient has Pending Investigations ">
			Patient has Pending Investigations
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($attachedalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content="Patient has Attached Results ">
			Patient has Attached Results 
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
		
<?php
    }

	function nurseadmissionmenu($patient, $patientnumber, $paymentmethod, $scheme, $gender, $age, $idvalue, $consult, $allegryalert, $chronicalert, $pendivestalert, $attachedalert, $vitals,$admissiontype,$admissiondoctor,$admissionnotes,$admissiontriage ,$admissionpaymenttype,$admissionward,	$admissionbed,$admissionsduration,$admissiondate,$admissionnumber,$admissionsservice,$admissionsservicecode)
    {
        ?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($admissionpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?>  - <?php echo(($admissiontype == '1')?'DETAIN':(($admissiontype == '2')?'ADMISSION':'EMERGENCY')); ?> 
			 </div>		
			</div>
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
						$medicalcondition = $vt[9];

					}else{
						$bp = $temp = $height = $weight = $fbs = $pulse = $medicalcondition = 'NA';
					}
				?>
			
			<div class="card-body">
			
				<br />
				<div class="row">										
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission No*</label>
								<?php echo $admissionnumber; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission Date*</label>
								<?php echo date('D d M Y H:i:s a',strtotime($admissiondate)); ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Ward*</label>
								<?php echo $admissionward; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Bed*</label>
							<?php echo $admissionbed; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Triage*</label>
							<?php echo $admissiontriage; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Doctor*</label>
							<?php echo $admissiondoctor; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Duration*</label>
							<?php echo $admissionsduration; ?> Days
							</div>											
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Service*</label>
							<?php echo $admissionsservice; ?>
							</div>											
						</div>
	
						<div class="col-md-6">
							<div class="form-group">
							<label class="form-label">Admiting Notes*</label>
							<?php echo $admissionnotes; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Any Medical Condition *</label>
							<?php echo $medicalcondition; ?>
							</div>											
						</div>
				</div>					
				<br />
				
				<div class="card-title">Vitals : BP - <?php echo $bp; ?> , Temperature - <?php echo $temp; ?> , Pulse - <?php echo $pulse; ?> , Height - <?php echo $height; ?> , Weight - <?php echo $weight; ?> , FBS - <?php echo $fbs; ?> <br /><br />
			</div>
			<br />
			<div class="btn-list">			
			<a href="admission__nurseadmissiondetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 1) { ?>active <?php } ?>">Patient Details</a>
			<!-- <a href="admission__patientvitals?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 2) { ?>active <?php } ?>">Vitals</a>
			<a href="admissionpatientnotes?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 12) { ?>active <?php } ?>">Notes</a>
			<a href="admission__patientvisit?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 3) { ?>active <?php } ?>">Visit Summary</a>
			<a href="admission__patientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 4) { ?>active <?php } ?>">History</a>
			<a href="admission__patientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if ($consult == 5) { ?>active <?php } ?>">Complaints</a>
			<a href="admission__patientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 6) { ?>active <?php } ?>">Physical Exam</a>
			<a href="admission__patientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 7) { ?>active <?php } ?>">Investigations</a>
			<a href="admission__patientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 8) { ?>active <?php } ?>">Diagnosis</a>
			<a href="admission__patientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 9) { ?>active <?php } ?>">Prescription</a>
			<a href="admission__patienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 10) { ?>active <?php } ?>">Treatment</a>			
			<a href="admission__patientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 11) { ?>active <?php } ?>">Action</a>	-->
			</div>		
										
			</div>	
							
		</div>
			
		<div class="row">
		<?php if (empty($admissionbed)) { ?>			
		<div class="col-md-3 mt-2 mb-2">			
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="modal" data-target="#largeModalbed" data-content="Patient NOT Assigned to a Bed">
			Patient NOT Assigned to a Bed 
			</button>		
		</div>
		<?php } ?>

		<?php if ($allegryalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has ALLERGY
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if ($chronicalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($pendivestalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Investigations" data-content="Patient has Pending Investigations ">
			Patient has Pending Investigations
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($attachedalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content="Patient has Attached Results ">
			Patient has Attached Results 
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
		
<?php
    }

	function nursemenu($patientcode){ ?>		
		<div class="btn-group mt-2 mb-2">
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
				Sub Menu <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-toggle="modal" data-target="#largeModalbed">Assign Bed</a></li>
				<li><a href="#" data-toggle="modal" data-target="#largeModalallergy">Allergy</a></li>
				<li><a href="#" data-toggle="modal" data-target="#largeModalchronic">Chronic Conditions</a></li>
				<li><a href="#" data-toggle="modal" data-target="#largeModaltakevitals">Take Vitals</a></li>
				<!-- <li><a href="#" data-toggle="modal" data-target="#largeModalcancel">Cancel Service </a></li> -->
				<li><a href="#" data-toggle="modal" data-target="#largeModalfollowup">Request Followup </a></li>
				<li><a href="#" data-toggle="modal" data-target="#largeModaladdnotes">Add Nurse Notes </a></li>
				<li><a href="#" data-toggle="modal" data-target="#largeModaleditpatientbio">Edit Patient Bio</a></li>
				<!-- <li><a href="patientqueuenursesnotes?<?php //echo $patientcode ?>?<?php //echo $requestcode ; ?>">Nurses Notes</a></li>	
				<li><a href="patientfollowupsdetails?<?php //echo $patientcode ?>?<?php //echo $requestcode ; ?>">Follow Ups</a></li>
				<li><a href="vitalhistorydetails?<?php //echo $patientcode ?>?<?php //echo $requestcode ; ?>">Vitals</a></li>	 -->
				
			</ul>
		</div>
	
<?php 
}
	
?>
