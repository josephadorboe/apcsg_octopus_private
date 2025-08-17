<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$consulationmodel = htmlspecialchars(isset($_POST['consulationmodel']) ? $_POST['consulationmodel'] : '');
	$dept = 'OPD';

	Global $instcode;
	
	// 20 FEB 2021  
	switch ($consulationmodel)
	{
		
		// 2 Oct 2023, 13 AUG 2021 JOSEPH ADORBOE 
		case 'addpatientallergy':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$allergy = htmlspecialchars(isset($_POST['allergy']) ? $_POST['allergy'] : '');
			$newallergy = htmlspecialchars(isset($_POST['newallergy']) ? $_POST['newallergy'] : '');
			$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($allergy) && empty($newallergy)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';
				}else if(empty($allergy) && !empty($newallergy)){
					$newallergy = strtoupper($newallergy);
					$storyline = strtoupper($storyline);
					$allergycode = md5(microtime());
					$sqlresults = $patientsallergytable->insert_patientaddallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$newallergy,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Patient Allergy added successfully";
					$result = $engine->getresults($sqlresults,$item=$newallergy,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=448;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);      
					
				}else if(!empty($allergy) && empty($newallergy)){					
					$compl = explode('@@@', $allergy);
					$allergycode = $compl[0];
					$allergyy = $compl[1];
					$storyline = strtoupper($storyline);
					$sqlresults = $patientsallergytable->insert_newpatientallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Patient Allergy added successfully";
					$result = $engine->getresults($sqlresults,$item=$allergyy,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=448;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
				
			}else if(!empty($allergy) && !empty($newallergy)){
					$status = 'error';
					$msg = 'Allergy and new allergy Cannot be filled at the same time ';
				}
			}
		break;
		// 2 oct 2023, 13 AUG  2021
		case 'addnewallergy':
			$newallergy = htmlspecialchars(isset($_POST['newallergy']) ? $_POST['newallergy'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){
				if(empty($newallergy)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$newallergy = strtoupper($newallergy);
					$sqlresults = $allergytable->insert_newallergy($form_key,$newallergy,$description,$currentusercode,$currentuser,$instcode);
					$action = "Allergy added successfully";
					$result = $engine->getresults($sqlresults,$item=$allergyy,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=447;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 		
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
					$sqlresults = $patientchronictable->insert_patientchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$chronicc,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Chronic added successfully";
					$result = $engine->getresults($sqlresults,$item=$chronicc,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=446;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 	
				}else if(empty($chronic) && !empty($newchronic)){					
					$storyline = strtoupper($storyline);
					$newchronic = strtoupper($newchronic);
					$chroniccode = md5(microtime());
					$sqlresults = $patientchronictable->insert_patientaddchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$newchronic,$storyline,$currentusercode,$currentuser,$instcode);
					$action = "Chronic added successfully";
					$result = $engine->getresults($sqlresults,$item=$newchronic,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=446;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 	
			}else if(!empty($chronic) && !empty($newchronic)){
				$status = 'error';
				$msg = 'Chronic Condition  and new Chronic Condition Cannot be filled at the same time ';
				}
			}
		break;
		// 2 oct 2023, 13 AUG  2021
		case 'addnewchronic':
			$newchronic = htmlspecialchars(isset($_POST['newchronic']) ? $_POST['newchronic'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($newchronic)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$newchronic = strtoupper($newchronic);
					$sqlresults = $chronictable->insert_newchronic($form_key,$newchronic,$description,$currentusercode,$currentuser,$instcode);
					$action = "Chronic added successfully";
					$result = $engine->getresults($sqlresults,$item=$newchronic,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=445;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 	
				}
			}
		break;

		// 13 oct 2023,  12 JUNE 2023
	case 'addpatientdietvitals':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$bodyfat = htmlspecialchars(isset($_POST['bodyfat']) ? $_POST['bodyfat'] : '');
		$musclefat = htmlspecialchars(isset($_POST['musclefat']) ? $_POST['musclefat'] : '');
		$visceralfat = htmlspecialchars(isset($_POST['visceralfat']) ? $_POST['visceralfat'] : '');
		$bmi = htmlspecialchars(isset($_POST['bmi']) ? $_POST['bmi'] : '');
		$metabolicrate = htmlspecialchars(isset($_POST['metabolicrate']) ? $_POST['metabolicrate'] : '');
		$hipcircumfernce = htmlspecialchars(isset($_POST['hipcircumfernce']) ? $_POST['hipcircumfernce'] : '');
		$waistcircumfernce = htmlspecialchars(isset($_POST['waistcircumfernce']) ? $_POST['waistcircumfernce'] : '');
		$waisthips = htmlspecialchars(isset($_POST['waisthips']) ? $_POST['waisthips'] : '');
		$height = htmlspecialchars(isset($_POST['height']) ? $_POST['height'] : '');
		$weight = htmlspecialchars(isset($_POST['weight']) ? $_POST['weight'] : '');
		$idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($bodyfat) || empty($musclefat) || empty($visceralfat) || empty($bmi) || empty($metabolicrate) || empty($hipcircumfernce)){				
				$status = 'error';
				$msg = 'Diet Vitals Not saved successfully';				
			}else{					
				$vitalsnumber = date("his");		
				$sqlresults = $patientsvitalsdiettable->insert_patientdietvitals($form_key,$days,$visitcode,$age,$gender,$patientcode, $patientnumber,$patient,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$vitalsnumber,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
				$action = "Patient diet vitals added ";
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=406;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			
			}			
		}
	break;
	// 13 oct 2023, 12 JUNE 2023 JOSEPH ADORBOE 
	case 'editdietvitals':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$bodyfat = htmlspecialchars(isset($_POST['bodyfat']) ? $_POST['bodyfat'] : '');
		$musclefat = htmlspecialchars(isset($_POST['musclefat']) ? $_POST['musclefat'] : '');
		$visceralfat = htmlspecialchars(isset($_POST['visceralfat']) ? $_POST['visceralfat'] : '');
		$bmi = htmlspecialchars(isset($_POST['bmi']) ? $_POST['bmi'] : '');
		$metabolicrate = htmlspecialchars(isset($_POST['metabolicrate']) ? $_POST['metabolicrate'] : '');
		$hipcircumfernce = htmlspecialchars(isset($_POST['hipcircumfernce']) ? $_POST['hipcircumfernce'] : '');
		$waistcircumfernce = htmlspecialchars(isset($_POST['waistcircumfernce']) ? $_POST['waistcircumfernce'] : '');
		$waisthips = htmlspecialchars(isset($_POST['waisthips']) ? $_POST['waisthips'] : '');
		$height = htmlspecialchars(isset($_POST['height']) ? $_POST['height'] : '');
		$weight = htmlspecialchars(isset($_POST['weight']) ? $_POST['weight'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){			
			if(empty($ekey) ||empty($bodyfat) || empty($musclefat) || empty($visceralfat) || empty($bmi) || empty($metabolicrate) || empty($hipcircumfernce)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{						
				$sqlresults = $patientsvitalsdiettable->update_patientdietvitals($ekey,$days,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$currentusercode,$currentuser,$instcode);
				$action = "Patient diet vitals edit ";
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=405;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			}
		}
	break;

		




















































		
	
			
		
	
	// 29 MAY 2021
	case 'addnewdevices':
		$newdevices = htmlspecialchars(isset($_POST['newdevices']) ? $_POST['newdevices'] : '');
		$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
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
	// // 14 OCT 2021 JOSEPH ADORBOE 
		// case 'editmedicalreports':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		// 	$servicetype = htmlspecialchars(isset($_POST['servicetype']) ? $_POST['servicetype'] : '');
		// 	$storyline = htmlspecialchars(isset($_POST['storyline']) ? $_POST['storyline'] : '');
		// 	$addressedto = htmlspecialchars(isset($_POST['addressedto']) ? $_POST['addressedto'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($servicetype) || empty($addressedto) || empty($storyline)){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{									
		// 				$com = explode('@@@', $servicetype);
		// 				$servicetypecode = $com[0];
		// 				$servicetypename = $com[1];						
		// 			$editmedicalreport = $consultationsql->update_patientmedicalreports($ekey,$days,$servicetypecode,$servicetypename,$storyline,$addressedto,$currentusercode,$currentuser,$instcode);
		// 			$title = 'Edit Patient Medical Report';
		// 			if($editmedicalreport == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$servicetypename." Unsuccessful"; 
		// 			}else if($editmedicalreport == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$servicetypename." Exist"; 					
		// 			}else if($editmedicalreport == '2'){
		// 				$event= "".$title." successfully ";
		// 				$eventcode= "149";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "".$title." ".$servicetypename." edited Successfully";
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
	
	}
	function physiomenuarchive($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$allegryalert,$chronicalert,$pendivestalert,$attachedalert,$vitals,$consultationpaymenttype){

		//$vitals = $patientvitalstable->getpatientvitals($patientcode,$visitcode,$instcode);
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
		//$vitals = $patientvitalstable->getpatientvitals($patientcode,$visitcode,$instcode);
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
		//$vitals = $patientvitalstable->getpatientvitals($patientcode,$visitcode,$instcode);
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
					<a href="consultationpatientprocedures?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 15){ ?>active <?php } ?>">Procedures</a>
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
	function patientfolderconsultationmenu($patientcode,$patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult,$patienttable,$instcode){
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
					<a href="patientfolderprescriptions?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if($consult == 9){ ?>active <?php } ?>">Prescription</a>											
					<a href="patientfolderdevices?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 17){ ?>active <?php } ?>">Devices</a>
						
					<a href="consultationpatientattachedresultspatientfolder?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if($consult == 12){ ?>active <?php } ?>">Results Attached</a>
					<a href="patientfolderlistmedicalreport?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if($consult == 13){ ?>active <?php } ?>">Medical Report</a>
					<a href="patientfoldertreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 5){ ?>active <?php } ?>">Treatment</a>
					<a href="patientfolderprocedures?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 15){ ?>active <?php } ?>">Procedures</a>
					<a href="patientfoldernotesopd?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if($consult == 14){ ?>active <?php } ?>">Notes</a>
					<a href="patientfoldervisitoutcome?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 7){ ?>active <?php } ?>">Visit Outcome</a>
					<a href="patientfolderreview?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 16){ ?>active <?php } ?>">Review / Referal</a>
					
					<!--<a href="patientfolderreferal?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if($consult == 16){ ?>active <?php } ?>">Review / Referal</a>
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
				<?php $alive = $patienttable->checkpatientalive($patientcode,$instcode);
				 ?>	
				 <br /> 
				<?php if($alive !== '0'){ ?>
						<button type="button" class="btn btn-sm btn-danger" data-container="body" data-toggle="popover" data-popover-color="popsecondary" data-placement="top" >Deceased On <?php echo $alive; ?>	</button> 
				<?php } ?>				
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

	//$vitals = $patientvitalstable->getpatientvitals($patientcode,$visitcode,$instcode);
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
