<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$setupmodel = htmlspecialchars(isset($_POST['setupmodel']) ? $_POST['setupmodel'] : '');
	
	// 13 MAY 2021 JOSEPH ADORBOE 
	switch ($setupmodel)
	{
		
	
		// 23 JAN 2022  JOSEPH ADORBOE 
		case 'removemedicationfromprescriptionplan':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$medicate = htmlspecialchars(isset($_POST['medicate']) ? $_POST['medicate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{							
						
					$sqlresults = $planmedicationtable->update_removemedicationfromplans($ekey,$currentusercode,$currentuser,$instcode);		
					$action = "Remove Prescription Plan Medication ";
					$result = $engine->getresults($sqlresults,$item=$medicate,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=453;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					

				}
			}

		break;
		
		// 29 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
		case 'editprescriptioplanmedication':
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
			$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
			$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($medication) || empty($frequency) || empty($qty) || empty($pdays) || empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else {
					$med = explode('@@@', $medication);
					$medcode = $med[0];
					$medname = $med[1];
					$dosecode = $med[2];
					$dose = $med[3];
					
					$type = 'OPD';

					$freq = explode('@@@', $frequency);
					$freqcode = $freq[0];
					$freqname = $freq[1];
				//    $freqqty = $freq[2];

					$da = explode('@@@', $pdays);
					$dayscode = $da[0];
					$daysname = $da[1];
				//    $daysvalue = $da[2];

					if (!empty($route)) {
						$rou = explode('@@@', $route);
						$routecode = $rou[0];
						$routename = $rou[1];
					} else {
						$routecode = '';
						$routename = '';
					}
									
					$sqlresults = $planmedicationtable->editprescriptionplanmedication($ekey, $medcode, $medname, $dosecode, $dose, $freqcode, $freqname, $dayscode, $daysname, $routecode, $routename, $qty, $strenght, $currentusercode, $currentuser, $instcode);
					$action = "Add Prescription Plan Medication ";
								$result = $engine->getresults($sqlresults,$item=$medname,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=453;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					
				}

			
			}

		break;
		// 29 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
		case 'addmedicationtoprescriptionplan': 
			$plancode = htmlspecialchars(isset($_POST['plancode']) ? $_POST['plancode'] : '');
			$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($plancode) || empty($plan)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{							
							foreach ($_POST["scheckbox"] as $plandetails) {
								$lpdet = explode('@@@', $plandetails);
								$medicationcode = $lpdet['0'];
								$medicationnum = $lpdet['1'];
								$medicationname = $lpdet['2'];
								$dosagecode = $lpdet['3'];
								$dosage = $lpdet['4'];
								$form_key = md5(microtime());
								
								$sqlresults = $planmedicationtable->insert_prescriptionplanlist($form_key,$plancode,$plan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode);
								$action = "Add Prescription Plan Medication ";
								$result = $engine->getresults($sqlresults,$item=$plan,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=454;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}						
				}
			}
		break;
		// 29 Sept 2023, 22 NOV 2021 JOSEPH ADORBOE 
		case 'addprescriptionplan':			
			$prescriptionplan = htmlspecialchars(isset($_POST['prescriptionplan']) ? $_POST['prescriptionplan'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($prescriptionplan) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$prescriptionplancode = md5(microtime());
						$prescriptionplannumber = rand(1,100000);	
						$lp = $prescriptionplansetuptable->newprescriptionplans($prescriptionplancode,$prescriptionplan,$prescriptionplannumber,$description,$days,$currentusercode,$currentuser,$instcode,$prescriptionplansetuptable);
						if($lp == 2){
							foreach ($_POST["scheckbox"] as $plandetails) {
								$lpdet = explode('@@@', $plandetails);
								$medicationcode = $lpdet['0'];
								$medicationnum = $lpdet['1'];
								$medicationname = $lpdet['2'];
								$dosagecode = $lpdet['3'];
								$dosage = $lpdet['4'];
								$form_key = md5(microtime());
								$sqlresults = $planmedicationtable->insert_prescriptionplanlist($form_key,$prescriptionplancode,$prescriptionplan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode);

								$action = "Add Prescription Plan ";
								$result = $engine->getresults($sqlresults,$item=$prescriptionplan,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=455;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
							}
						}else {
							$status = "error";
							$msg = "Unknown Source";
						}
				}
			}
		break;
		
		// 29 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'enableprocedure':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($procedure)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$sqlresults = $setupcontroller->enableprocedures($ekey,$days,$currentuser,$currentusercode,$instcode,$proceduresetuptable,$pricingtable);
					$action = "Enable procedure";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=456;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;
		// 29 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'disableprocedure':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($procedure) || empty($disablereason) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					
					$sqlresults = $setupcontroller->disableprocedure($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode,$proceduresetuptable,$pricingtable);
					$action = "Disable procedure";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=457;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;
		// 15 MAY 2021 JOSPH ADORBOE
		case 'editprocedureonly':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$procedurenumber = htmlspecialchars(isset($_POST['procedurenumber']) ? $_POST['procedurenumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($procedure) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($procedurenumber)){
						$procedurenumber = rand(1,100000);
					}					
					$procedure = strtoupper($procedure);
					$sqlresults = $setupcontroller->editprocedure($ekey,$procedure,$procedurenumber,$description,$mnum,$currentuser,$currentusercode,$instcode,$proceduresetuptable,$pricingtable);
					$action = "Edit procedure ";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=458;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}	
		break;
		// 29 Sept 2023,  13 MAY 2021 JOSPH ADORBOE
		case 'addprocedureonly':			
			$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($procedure) || empty($description) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$procedurenumber = rand(1,100000);
					$procedure = strtoupper($procedure);
					$sqlresults = $proceduresetuptable->addnewprocedure($form_key,$procedure,$procedurenumber,$description,$currentuser,$currentusercode,$instcode);					
					$action = "Add procedure ";
					$result = $engine->getresults($sqlresults,$item=$procedure,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=459;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}
	
		break;
		// 29 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'enableimaging':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$sqlresults = $setupcontroller->enableimaging($ekey,$days,$currentuser,$currentusercode,$instcode,$imagingsetuptable,$pricingtable);
					$action = "Enable Imaging";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=460;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;
		// 29 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'disableimaging':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging) || empty($disablereason) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					
					$sqlresults = $setupcontroller->disableimaging($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode,$imagingsetuptable,$pricingtable);
					$action = "Disable Imaging";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=461;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;
		// 29 Sept 20-23, 29 MAY 2022 JOSPH ADORBOE
		case 'editimaging':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$imagingnumber = htmlspecialchars(isset($_POST['imagingnumber']) ? $_POST['imagingnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($imaging) || empty($partnercode) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					if(empty($imagingnumber)){
						$imagingnumber = rand(1,100000);						
					}					
					$imaging = strtoupper($imaging);

					$sqlresults = $setupcontroller->editnewimaging($ekey,$imaging,$imagingnumber,$description,$partnercode,$mnum,$currentuser,$currentusercode,$instcode,$imagingsetuptable,$pricingtable);
					$action = "Edit  Imaging ";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=462;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;
		// 29 Sept 2023 29 MAY 2022 JOSPH ADORBOE
		case 'addimagingonly':			
			$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($imaging) || empty($partnercode) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					
					$imagingnumber = rand(1,100000);
					$imaging = strtoupper($imaging);

					$sqlresults = $setupradiologytable->addnewimaging($form_key,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode);
					$action = "Add Imaging ";
					$result = $engine->getresults($sqlresults,$item=$imaging,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=463;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
				 }
			}	
		break;
		// 28 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'enabledevice':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($devices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					
					$sqlresults = $setupcontroller->enabledevices($ekey,$days,$currentuser,$currentusercode,$instcode,$devicesetuptable,$pricingtable);
					$action = "Enable Devices";
					$result = $engine->getresults($sqlresults,$item=$devices,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=464;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;

		// 28 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'disabledevice':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($devices) || empty($disablereason) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
					
					$sqlresults = $setupcontroller->disabledevices($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode,$devicesetuptable,$pricingtable);
					$action = "Disable Devices";
					$result = $engine->getresults($sqlresults,$item=$devices,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=465;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;

		// 28 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'editdevices':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$devicenumber = htmlspecialchars(isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($devices) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
									
					$devices = strtoupper($devices);
					$sqlresults = $setupcontroller->editnewdevice($ekey,$devices,$description,$currentuser,$currentusercode,$instcode,$devicesetuptable,$pricingtable);
					$action = "Edit Devices";
					$result = $engine->getresults($sqlresults,$item=$devices,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=466;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				
				}
			}
	
		break;

		
		// 28 Sept 2023, 25 DEC 2022  JOSPH ADORBOE
		case 'enablesetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $setupcontroller->enablemedications($ekey,$days,$currentuser,$currentusercode,$instcode,$medicationtable,$pricingtable,$planmedicationtable);
					$action = "Enable Medications";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=468;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					
				}
			}	
		break;

		// 28 Sept 2023, 25 DEC 2022  JOSPH ADORBOE
		case 'disablemedicationsetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  || empty($disablereason)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{						
					$sqlresults = $setupcontroller->disablemedications($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode,$medicationtable,$pricingtable,$planmedicationtable);
					$action = "Disable Medications";
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=469;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				
				}
			}	
		break;

		// 28 Sept 2023, 24 Sept 2023, 14 MAY 2021 JOSPH ADORBOE $medicationnumber
		case 'editmedicationonly':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$dosageform = htmlspecialchars(isset($_POST['dosageform']) ? $_POST['dosageform'] : '');
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$brandname = htmlspecialchars(isset($_POST['brandname']) ? $_POST['brandname'] : '');
			$medicationdose = htmlspecialchars(isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($medication) || empty($unit)  || empty($dosageform) ||  empty($brandname) || empty($medicationdose) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$dose = explode('@@@', $dosageform);
					$dosageformcode = $dose[0];
					$dosageformname = $dose[1];	
					
					$unt = explode('@@@', $unit);
					$untcode = $unt[0];
					$untname = $unt[1];

					$sqlresults = $setupcontroller->editmedications($ekey,$medication,$dosageformcode,$dosageformname,$untcode,$untname,$brandname,$medicationdose,$restock,$currentuser,$currentusercode,$instcode,$medicationtable);
					$action = "Edit Medications";
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=470;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
	
		break;
		// 28 Sept 2023, 13 MAY 2021 JOSPH ADORBOE
		case 'addmedicationsonly':			
			$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
			$dosageform = htmlspecialchars(isset($_POST['dosageform']) ? $_POST['dosageform'] : '');
			$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$brandname = htmlspecialchars(isset($_POST['brandname']) ? $_POST['brandname'] : '');
			$medicationdose = htmlspecialchars(isset($_POST['medicationdose']) ? $_POST['medicationdose'] : '');
			$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($medication) || empty($dosageform) || empty($restock) || empty($brandname) || empty($medicationdose) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$dose = explode('@@@', $dosageform);
					$dosageformcode = $dose[0];
					$dosageformname = $dose[1];	
					
					$unt = explode('@@@', $unit);
					$untcode = $unt[0];
					$untname = $unt[1];
					$medicationnumber = $currenttable->getlastmedicationcodenumber($instcode);
					$medication = strtoupper($medication);
					$brandname = strtoupper($brandname);
					$medication = $medication.' - '.$dosageformname.' - '.$medicationdose.' - '.$brandname ;

					$sqlresults = $setupcontroller->addnewmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$currentuser,$currentusercode,$instcode,$medicationtable,$currenttable);
					$action = "Add medication";
					
					$result = $engine->getresults($sqlresults,$item=$medication,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=471;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;	
		// 26 Sept 2023,  22 NOV 2021 JOSEPH ADORBOE 
		case 'removelabsfromplan':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$labstest = htmlspecialchars(isset($_POST['labstest']) ? $_POST['labstest'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$action = "Remove Labs test plans";				
					$sqlresults = $labplantesttable->update_removelabsfromplans($ekey,$currentusercode,$currentuser,$instcode);					
					$result = $engine->getresults($sqlresults,$item=$labstest,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=472;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
			
				}
			}

		break;
		// 26 Sept 2023, 23 JAN 2022 JOSEPH ADORBOE 
		case 'addnewlabstoplans': 
			$plancode = htmlspecialchars(isset($_POST['plancode']) ? $_POST['plancode'] : '');
			$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($plancode) || empty($plan)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
							foreach ($_POST["scheckbox"] as $plandetails) {
								$lpdet = explode('@@@', $plandetails);
								$lapcode = $lpdet['0'];
								$lapnum = $lpdet['1'];
								$lapname = $lpdet['2'];
								$lapcodenum = $lpdet['3'];
								$form_key = md5(microtime());
								$action = "Add Labs test plans";
								$sqlresults = $labplantesttable->insert_labstoplan($form_key,$plancode,$plan,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode);
								$result = $engine->getresults($sqlresults,$item=$plan,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=473;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);										
							
							}					
				}
			}
		break;
		// 26 Sept 2023, 23 JAN 2022  JOSEPH ADORBOE labsplans
		case 'addnewlabsplans': 
			$labsplans = htmlspecialchars(isset($_POST['labsplans']) ? $_POST['labsplans'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($labsplans) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$lapplancode = md5(microtime());
						$labplannumber = $lov->getlabplannumber($instcode);	
						$lp = $setupcontroller->addnewlabplans($lapplancode,$labsplans,$labplannumber,$description,$days,$category,$currentusercode,$currentuser,$instcode,$labplantable,$currenttable);
						if($lp == '2'){
							foreach ($_POST["scheckbox"] as $plandetails) {
								$lpdet = explode('@@@', $plandetails);
								$lapcode = $lpdet['0'];
								$lapnum = $lpdet['1'];
								$lapname = $lpdet['2'];
								$lapcodenum = $lpdet['3'];
								$form_key = md5(microtime());
								$sqlresults = $labplantesttable->insert_labsplanlist($form_key,$lapplancode,$labsplans,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode);
								
								$action = "Add Labs plans";
								$result = $engine->getresults($sqlresults,$item=$labsplans,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=474;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
							}
						}else {
							$status = "error";
							$msg = "Unknown Source";
						}
				}
			}
		break;
		// 24 Sept 203, 13 MAY 2021 JOSPH ADORBOE
		case 'addmedicallabs':			
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$discpline = htmlspecialchars(isset($_POST['discpline']) ? $_POST['discpline'] : '');
			$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($labs) || empty($discpline) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$dose = explode('@@@', $discpline);
					$discplinecode = $dose[0];
					$discplinename = $dose[1];	
					
					$labsnumber = $currenttable->getlastlabcodenumber($instcode);
					$labs = strtoupper($labs);
					$partnecodecheck = $labtesttable->checkpartnercode($partnercode,$instcode);
					if($partnecodecheck !== '2'){
						$status = 'error';
						$msg = "Partner code $partnercode already exist";	
					}else{
                        $sqlresults = $setupcontroller->addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode,$labtesttable,$currenttable);
                        $action = "Add Labs";
						$result = $engine->getresults($sqlresults,$item=$labs,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=479;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	                      
                    }	
				}
			}
	
		break;
		// 24 Sept 2023, 14 MAY 2021 JOSPH ADORBOE
		case 'editlabs':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$displine = htmlspecialchars(isset($_POST['displine']) ? $_POST['displine'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$labnumber = htmlspecialchars(isset($_POST['labnumber']) ? $_POST['labnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($labs) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$discplinecode=$discplinename='1';
					if(empty($labnumber)){
						$labnumber = $currenttable->getlastlabcodenumber($instcode);
					}					
					$labs = strtoupper($labs);
					$sqlresults = $setupcontroller->editnewlabs($ekey,$labs,$labnumber,$discplinecode,$discplinename,$description,$mnum,$currentuser,$currentusercode,$instcode,$labtesttable,$currenttable,$pricingtable,$labplantesttable);
					$action = "Edit Labs";
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=478;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}
	
		break;
		// 24 Sept 2023, 12 MAR 2023 JOSPH ADORBOE enablelabs
		case 'disablelabs':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$displine = htmlspecialchars(isset($_POST['displine']) ? $_POST['displine'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$labnumber = htmlspecialchars(isset($_POST['labnumber']) ? $_POST['labnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$disablereason = htmlspecialchars(isset($_POST['disablereason']) ? $_POST['disablereason'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($disablereason)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$sqlresults = $setupcontroller->disablelabs($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode,$labtesttable,$pricingtable,$labplantesttable);
					$action = "Disable Labs";
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=477;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
	
		break;

		// 12 MAR 2023 JOSPH ADORBOE 
		case 'enablelabs':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
			$displine = htmlspecialchars(isset($_POST['displine']) ? $_POST['displine'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$labnumber = htmlspecialchars(isset($_POST['labnumber']) ? $_POST['labnumber'] : '');
			$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$sqlresults = $setupcontroller->enablelabs($ekey,$days,$currentuser,$currentusercode,$instcode,$labtesttable,$pricingtable,$labplantesttable);
					$action = "Enable Labs";
					$result = $engine->getresults($sqlresults,$item=$labs,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=476;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}
	
		break;
		// // 23 Sept 2023,  14 APR 2022 JOSPH ADORBOE 
		// case 'deletelabs':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
		// 	$displine = htmlspecialchars(isset($_POST['displine']) ? $_POST['displine'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$labnumber = htmlspecialchars(isset($_POST['labnumber']) ? $_POST['labnumber'] : '');
		// 	$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
		// 	$deletereason = htmlspecialchars(isset($_POST['deletereason']) ? $_POST['deletereason'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey) || empty($deletereason)){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty Reason for delete';				
		// 		}else{
		// 			$edit = $setupcontroller->deletelabs($ekey,$currentuser,$currentusercode,$instcode);
		// 			$action = "Delete Labs";
		// 			$result = $engine->getresults($sqlresults,$item=$labs,$action);
		// 			$re = explode(',', $result);
		// 			$status = $re[0];					
		// 			$msg = $re[1];
		// 			$event= "$action: $form_key $msg";
		// 			$eventcode=477;
		// 			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					
		// 		}
		// 	}
	
		// break;






			

		// // 11 JAN 2023 JOSPH ADORBOE
		// case 'removedevice':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');	
		// 	$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)  ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$edit = $setupcontroller->removedevices($ekey,$category,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Remove Device ';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = " $title $devices Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = " $title $devices Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $devices  successfully ";
		// 				$eventcode= "206";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $devices Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}	
		// break;

		

		// // 27 DEC 2022  JOSPH ADORBOE
		// case 'addimagingprice':			
		// 	$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');			
		// 	$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');			
		// 	$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
		// 	$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
		// 	$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
		// 	$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
		// 	$totalqty = htmlspecialchars(isset($_POST['totalqty']) ? $_POST['totalqty'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($imaging) || empty($description) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
					
		// 			$labnumber = $setupcontroller->getlastlabcodenumber($instcode);
		// 			$imaging = strtoupper($imaging);
		// 			$cashpricecode = md5(microtime());	
		// 			$category = 7;
		// 			$cash = 'CASH';
		// 			if(empty($insuranceprice))
		// 			{
		// 				$insuranceprice = 0;
		// 			}
		// 			if(empty($dollarprice))
		// 			{
		// 				$dollarprice = 0;
		// 			}
		// 			// if(empty($alternateprice))
		// 			// {
		// 			// 	$alternateprice = 0;
		// 			// }

		// 			$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
		// 			if ($validatecashprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Cash Price value is invalid";
		// 				return '0';
		// 			}

		// 			// $validatealtenate = $engine->getnumbervalidation($alternateprice);
		// 			// if ($validatealtenate == '1') {
		// 			// 	$status = 'error';
		// 			// 	$msg = "Alternate Price Value is invalid";
		// 			// 	return '0';
		// 			// }

		// 			$validatedollarprice = $engine->getnumbervalidation($dollarprice);
		// 			if ($validatedollarprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Doallar Prices value is invalid";
		// 				return '0';
		// 			}

		// 			$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
		// 			if ($validateinsuranceprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Insurance Prices value is invalid";
		// 				return '0';
		// 			}

		// 			$validatepartnerprice = $engine->getnumbervalidation($partnerprice);
		// 			if ($validatepartnerprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Partner Prices value is invalid";
		// 				return '0';
		// 			}

		// 			$alternateprice = $cashprice;					

		// 			$add = $setupcontroller->addnewimagingsed($form_key,$imaging,$labnumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Add Imaging';
		// 			if($add == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $imaging Unsuccessful"; 
		// 			}else if($add == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $imaging  Exist"; 					
		// 			}else if($add == '2'){
		// 				if($insuranceprice > '0'){
		// 					if (!empty($_POST["scheckbox"])) {
		// 						foreach ($_POST["scheckbox"] as $schemes) {
		// 							$pricecode = md5(microtime());	
		// 							$req = explode('@@@', $schemes);
		// 							$schemecode = $req['0'];
		// 							$schemename = $req['1'];
		// 							$insurancecode = $req['2'];
		// 							$insurancename = $req['3'];                       
		// 							$ins = $setupcontroller->setinsuranceprices($pricecode,$category,$form_key,$imaging,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
		// 						}  
		// 					}

		// 				}
		// 				$event= "$title $imaging successfully ";
		// 				$eventcode= "217";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
							
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "$title $imaging  Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		

		// // 25 DEC 2022  JOSPH ADORBOE
		// case 'enablesetup':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
		// 	$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)  ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$edit = $setupcontroller->enablesetup($ekey,$category,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Enable Setup';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $item  successfully ";
		// 				$eventcode= "223";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $item Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}	
		// break;

		

		// // 24 DEC 2022  JOSPH ADORBOE
		// case 'enableprice':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)  ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$edit = $setupcontroller->enableprice($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Enable Price';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $item  successfully ";
		// 				$eventcode= "221";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $item Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}	
		// break;

		// // 24 DEC 2022  JOSPH ADORBOE
		// case 'disableprice':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)  ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$edit = $setupcontroller->disableprice($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Disable Price';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = " $title $item Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $item  successfully ";
		// 				$eventcode= "220";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $item Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}	
		// break;



		// // 24 DEC 2022  JOSPH ADORBOE
		// case 'addprocedureed':
			
		// 	$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');			
		// 	$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');			
		// 	$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
		// 	$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
		// 	$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
		// 	$totalqty = htmlspecialchars(isset($_POST['totalqty']) ? $_POST['totalqty'] : '');
		// 	$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($procedure) || empty($description) || empty($cashprice) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
					
		// 			$procedurenumber = $setupcontroller->getlastprocedurecodenumber($instcode);
		// 			$procedure = strtoupper($procedure);
		// 			$cashpricecode = md5(microtime());	
		// 			$category = 6;
		// 			$cash = 'CASH';
		// 			if(empty($insuranceprice))
		// 			{
		// 				$insuranceprice = 0;
		// 			}
		// 			if(empty($dollarprice))
		// 			{
		// 				$dollarprice = 0;
		// 			}
		// 			if(empty($alternateprice))
		// 			{
		// 				$alternateprice = 0;
		// 			}

		// 			if(empty($partnerprice))
		// 			{
		// 				$partnerprice = 0;
		// 			}

		// 			$validatecashprice = $engine->getnumbernonzerovalidation($cashprice);
		// 			if ($validatecashprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Cash Price value is invalid";
		// 				return '0';
		// 			}

		// 			// $validatealtenate = $engine->getnumbervalidation($alternateprice);
		// 			// if ($validatealtenate == '1') {
		// 			// 	$status = 'error';
		// 			// 	$msg = "Alternate Price Value is invalid";
		// 			// 	return '0';
		// 			// }

		// 			$validatedollarprice = $engine->getnumbervalidation($dollarprice);
		// 			if ($validatedollarprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Doallar Prices value is invalid";
		// 				return '0';
		// 			}

		// 			$validateinsuranceprice = $engine->getnumbervalidation($insuranceprice);
		// 			if ($validateinsuranceprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Insurance Prices value is invalid";
		// 				return '0';
		// 			}

		// 			$validatepartnerprice = $engine->getnumbervalidation($partnerprice);
		// 			if ($validatepartnerprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Partner Prices value is invalid";
		// 				return '0';
		// 			}


		// 			$add = $setupcontroller->addnewprocedureed($form_key,$procedure,$procedurenumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Add Procedure';
		// 			if($add == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $procedure Unsuccessful"; 
		// 			}else if($add == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $procedure  Exist"; 					
		// 			}else if($add == '2'){
		// 				if($insuranceprice > '0'){
		// 					if (!empty($_POST["scheckbox"])) {
		// 						foreach ($_POST["scheckbox"] as $schemes) {
		// 							$pricecode = md5(microtime());	
		// 							$req = explode('@@@', $schemes);
		// 							$schemecode = $req['0'];
		// 							$schemename = $req['1'];
		// 							$insurancecode = $req['2'];
		// 							$insurancename = $req['3'];                       
		// 							$ins = $setupcontroller->setinsuranceprices($pricecode,$category,$form_key,$procedure,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser);
		// 						}  
		// 					}

		// 				}
		// 				$event= "$title $procedure successfully ";
		// 				$eventcode= "211";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "$title $procedure  Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}	
		// break;		

		// // 14 APR 2022  JOSPH ADORBOE
		// case 'deleteimaging':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
		// 	$imaging = htmlspecialchars(isset($_POST['imaging']) ? $_POST['imaging'] : '');
		// 	$partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$imagingnumber = htmlspecialchars(isset($_POST['imagingnumber']) ? $_POST['imagingnumber'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{				

		// 			$edit = $setupcontroller->deleteimaging($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Delete Imaging';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $imaging Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $imaging  Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $imaging successfully ";
		// 				$eventcode= "219";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $imaging deleted Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		

		

		// // 03 JUNE  2021 JOSPH ADORBOE
		// case 'editsupplier':

		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$suppliernumber = htmlspecialchars(isset($_POST['suppliernumber']) ? $_POST['suppliernumber'] : '');
		// 	$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey) || empty($supplier) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{					
		// 			if(empty($suppliernumber)){
		// 				$suppliernumber = $setupcontroller->getlastsuppliercodenumber($instcode);
		// 			}					
		// 			$supplier = strtoupper($supplier);

		// 			$edit = $setupcontroller->editnewsupplier($ekey,$supplier,$suppliernumber,$description,$mnum,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Edit Suppliers';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $supplier Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $supplier Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $supplier Successfully ";
		// 				$eventcode= "46";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $supplier edited Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		// // 03 JUNE 2021 JOSPH ADORBOE
		// case 'addsupplier':
			
		// 	$supplier = htmlspecialchars(isset($_POST['supplier']) ? $_POST['supplier'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($supplier) || empty($description) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
					
		// 			$suppliernumber = $setupcontroller->getlastsuppliercodenumber($instcode);
		// 			$supplier = strtoupper($supplier);

		// 			$add = $setupcontroller->addnewsupplier($form_key,$supplier,$suppliernumber,$description,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Add supplier';
		// 			if($add == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$supplier."  Unsuccessful"; 
		// 			}else if($add == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$supplier."  Exist"; 					
		// 			}else if($add == '2'){
		// 				$event= "".$title."  ".$supplier."  successfully ";
		// 				$eventcode= "157";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "".$title." ".$supplier."  Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		

		// // 15 MAY 2021 JOSPH ADORBOE
		// case 'editprices':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$price = htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : '');
		// 	$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
		// 	$schemename = htmlspecialchars(isset($_POST['schemename']) ? $_POST['schemename'] : '');
		// 	$paycode = htmlspecialchars(isset($_POST['paycode']) ? $_POST['paycode'] : '');
		// 	$payname = htmlspecialchars(isset($_POST['payname']) ? $_POST['payname'] : '');
		// 	$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
		// 	$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
		// 	$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
		// 	$otherprice = htmlspecialchars(isset($_POST['otherprice']) ? $_POST['otherprice'] : '');
		// 	$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey) || empty($price) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$otherprice = '0';
		// 			$validatecostprice = $engine->getnumbernonzerovalidation($price);
		// 			if ($validatecostprice == '1') {
		// 				$status = 'error';
		// 				$msg = "New price value is invalid";
		// 				return '0';
		// 			}

		// 			$validatecashprice = $engine->getnumbernonzerovalidation($price);
		// 			if ($validatecashprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Cash Price value is invalid";
		// 				return '0';
		// 			}

		// 			// $validatealtenate = $engine->getnumbervalidation($alternateprice);
		// 			// if ($validatealtenate == '1') {
		// 			// 	$status = 'error';
		// 			// 	$msg = "Alternate Price Value is invalid";
		// 			// 	return '0';
		// 			// }

		// 			$validatedollarprice = $engine->getnumbervalidation($dollarprice);
		// 			if ($validatedollarprice == '1') {
		// 				$status = 'error';
		// 				$msg = "Doallar Prices value is invalid";
		// 				return '0';
		// 			}

		// 			// $validatepartnerprice = $engine->getnumbervalidation($partnerprice);
		// 			// if ($validatepartnerprice == '1') {
		// 			// 	$status = 'error';
		// 			// 	$msg = "Partner Prices value is invalid";
		// 			// 	return '0';
		// 			// }

				
		// 			$edit = $setupcontroller->editnewprices($ekey,$price,$alternateprice,$otherprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Edit Prices';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $item Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $item  Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " $title $item successfully ";
		// 				$eventcode= "216";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " $title $item Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		// // 14 APR 2022 JOSPH ADORBOE
		// case 'deletepaymentprice':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$price = htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : '');
		// 	$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
		// 	$schemename = htmlspecialchars(isset($_POST['schemename']) ? $_POST['schemename'] : '');
		// 	$paycode = htmlspecialchars(isset($_POST['paycode']) ? $_POST['paycode'] : '');
		// 	$payname = htmlspecialchars(isset($_POST['payname']) ? $_POST['payname'] : '');
		// 	$itemname = htmlspecialchars(isset($_POST['itemname']) ? $_POST['itemname'] : '');
		// 	$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
		// 	$otherprice = htmlspecialchars(isset($_POST['otherprice']) ? $_POST['otherprice'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey) || empty($price) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{				
		// 			$edit = $setupcontroller->deleteprices($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Delete Prices';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$itemname."  Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$itemname."  Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " ".$title." ".$itemname."  successfully ";
		// 				$eventcode= "215";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " ".$title." ".$itemname." edited Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;


		
		// // 16 MAY 2021 JOSEPH ADORBOE
		// case 'setprices': 

		// 	$billableservices = htmlspecialchars(isset($_POST['billableservices']) ? $_POST['billableservices'] : '');
		// 	$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		// 	$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
		// 	$schemename = htmlspecialchars(isset($_POST['schemename']) ? $_POST['schemename'] : '');
		// 	$paycode = htmlspecialchars(isset($_POST['paycode']) ? $_POST['paycode'] : '');
		// 	$payname = htmlspecialchars(isset($_POST['payname']) ? $_POST['payname'] : '');
		// 	$price = htmlspecialchars(isset($_POST['price']) ? $_POST['price'] : '');
		// 	$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
		// 	$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
		// 	$device = htmlspecialchars(isset($_POST['device']) ? $_POST['device'] : '');
		// 	$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		// 	$scan = htmlspecialchars(isset($_POST['scan']) ? $_POST['scan'] : '');
		// 	$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
		// 	$otherprice = htmlspecialchars(isset($_POST['otherprice']) ? $_POST['otherprice'] : '');
		// 	$dollarsprice = htmlspecialchars(isset($_POST['dollarsprice']) ? $_POST['dollarsprice'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');			
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($category) || empty($price) ){	
		// 			$status = "error";
		// 			$msg = "Required Fields cannot be empty ";	
		// 		}else{
					
		// 			if($category == 1){
		// 				$item = $billableservices;
		// 			}else if($category == 3){
		// 				$item = $labs;
		// 			}else if($category == 2){
		// 				$item = $medication;
		// 			}else if($category == 5){
		// 				$item = $device;
		// 			}else if($category == 4){
		// 				$item = $scan;
		// 			}else if($category == 6){
		// 				$item = $procedure;
		// 			}
					

        //             if (empty($item)) {
        //                 $status = "error";
		// 				$msg = "Required Fields cannot be empty ";
        //             }else{
		// 				$itm = explode('@@@', $item);
        //                 $sercode = $itm[0];
        //                 $sername = $itm[1];
        //                 /*
        //                 $fac = explode('@@@', $paymentmethod);
        //                 $paycode = $fac[0];
        //                 $payname = $fac[1];

        //                 if(!empty($scheme)){
        //                     $fac = explode('@@@', $scheme);
        //                     $schcode = $fac[0];
        //                     $schname = $fac[1];
        //                 }else{
        //                     $schcode = $schname = '';
        //                 }
        //                 */

        //                 // if (empty($otherprice) || empty($alternateprice)) {
        //                 //     $alternateprice = $price;
        //                 //     $otherprice = $price;
        //                 // }
                    
                    
        //                 $addsinglepriceing = $setupcontroller->admin_singlepricing($form_key, $sercode, $sername, $paycode, $payname, $schemecode, $schemename, $price, $day, $category, $alternateprice, $otherprice, $dollarsprice,$currentusercode, $currentuser, $instcode);
        //                 $title = 'Add Price ';
        //                 if ($addsinglepriceing == '0') {
        //                     $status = "error";
        //                     $msg = "Add Price  ".$sername." to ".$payname." Unsuccessful";
        //                 } elseif ($addsinglepriceing == '1') {
        //                     $status = "error";
        //                     $msg = "Price ".$sername." to ".$payname." Exist";
        //                 } elseif ($addsinglepriceing == '2') {
        //                     $event= " ".$title." ".$sername."  successfully ";
        //                     $eventcode= "214";
        //                     $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
        //                     if ($audittrail == '2') {
        //                         $status = "success";
        //                         $msg = " ".$title." ".$sername." edited Successfully";
        //                     } else {
        //                         $status = "error";
        //                         $msg = "Audit Trail unsuccessful";
        //                     }
        //                 } else {
        //                     $status = "error";
        //                     $msg = "Add Price Unsuccessful ";
        //                 }
        //             }		
	
		// 		}
	
		// 	}
	
		// break;
		
		// // 15 MAY 2021 JOSPH ADORBOE
		// case 'searchaddprice':			
		// 	$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');
		// 	$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($item) || empty($scheme) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$sche = explode('@@@', $scheme);
		// 			$schecode = $sche[0];
		// 			$schename = $sche[1];
		// 			$paycode = $sche[2];
		// 			$payname = $sche[3];			
		// 			$value = $item.'@@@'.$schecode.'@@@'.$schename.'@@@'.$paycode.'@@@'.$payname;
		// 			$msql->passingvalues($pkey=$form_key,$value);					
		// 			$url = "addprice?$form_key";
		// 			$engine->redirect($url);
		// 		}				
		// 	}	
		// break;


		// // 14 APR 2022  JOSPH ADORBOE
		// case 'deleteprocedure':

		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$procedure = htmlspecialchars(isset($_POST['procedure']) ? $_POST['procedure'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$procedurenumber = htmlspecialchars(isset($_POST['procedurenumber']) ? $_POST['procedurenumber'] : '');
		// 	$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{				

		// 			$edit = $setupcontroller->deleteprocedure($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Delete Procedure';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$procedure."  Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$procedure."  Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " ".$title." ".$procedure."  successfully ";
		// 				$eventcode= "213";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " ".$title." ".$procedure." edited Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;

		


		// // 14 APR 2022 JOSPH ADORBOE
		// case 'deletedevice':

		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		// 	$devicenumber = htmlspecialchars(isset($_POST['devicenumber']) ? $_POST['devicenumber'] : '');
		// 	$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{		
					
		// 			$edit = $setupcontroller->deletedevice($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Delete Devices';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "$title $devices Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "$title $devices Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= "$title $devices successfully ";
		// 				$eventcode= "206";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "$title $devices edited Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;
		

		// // 14 MAY 2021 JOSPH ADORBOE
		// case 'adddevices':
			
		// 	$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
		// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
		// 	$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($devices) || empty($description) ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
					
		// 			$devicenumber = $setupcontroller->getlastdevicecodenumber($instcode);
		// 			$devices = strtoupper($devices);

		// 			$add = $setupcontroller->addnewdevice($form_key,$devices,$devicenumber,$description,$qty,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Add Device';
		// 			if($add == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$devices."  Unsuccessful"; 
		// 			}else if($add == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$devices."  Exist"; 					
		// 			}else if($add == '2'){
		// 				$event= "".$title."  ".$devices."  successfully ";
		// 				$eventcode= "205";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = "".$title." ".$devices."  Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;


			

		// // 14 APR 2022  JOSPH ADORBOE
		// case 'deletemedication':
		// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
		// 	$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');	
		// 	$dosageform = htmlspecialchars(isset($_POST['dosageform']) ? $_POST['dosageform'] : '');
		// 	$unit = htmlspecialchars(isset($_POST['unit']) ? $_POST['unit'] : '');
		// 	$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
		// 	$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		// 	$medicationnumber = htmlspecialchars(isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '');
		// 	$mnum = htmlspecialchars(isset($_POST['mnum']) ? $_POST['mnum'] : '');
		// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		// 	if($preventduplicate == '1'){
		// 		if(empty($ekey)  ){
		// 			$status = 'error';
		// 			$msg = 'Required Field Cannot be empty';				
		// 		}else{	
		// 			$edit = $setupcontroller->deletemedication($ekey,$currentuser,$currentusercode,$instcode);
		// 			$title = 'Delete Medication';
		// 			if($edit == '0'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$medication."  Unsuccessful"; 
		// 			}else if($edit == '1'){				
		// 				$status = "error";					
		// 				$msg = "".$title." ".$medication."  Exist"; 					
		// 			}else if($edit == '2'){
		// 				$event= " ".$title." ".$medication."  successfully ";
		// 				$eventcode= "203";
		// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		// 				if($audittrail == '2'){				
		// 					$status = "success";
		// 					$msg = " ".$title." ".$medication." edited Successfully";
		// 				}else{
		// 					$status = "error";
		// 					$msg = "Audit Trail unsuccessful";	
		// 				}			
		// 		}else{				
		// 				$status = "error";					
		// 				$msg = "Unknown source "; 					
		// 			}	
		// 		}
		// 	}
	
		// break;		
			
	}
	

?>
