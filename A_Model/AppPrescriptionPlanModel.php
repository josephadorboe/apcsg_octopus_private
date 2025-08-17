<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	
	$prescriptionplanmodel = htmlspecialchars(isset($_POST['prescriptionplanmodel']) ? $_POST['prescriptionplanmodel'] : '');
	global $treatmentplancode, $treatmentplanname;
	
	// 9 oct 2023, 27 MAR 2021 
	switch ($prescriptionplanmodel)
	{
			// 9 oct 2023,  27 MAY 2021 JOSEPH ADORBOE
	case 'newtreatmentplan':
		$treatmentplanname = htmlspecialchars(isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '');
		$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
		$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
	//	$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
		$newdays = htmlspecialchars(isset($_POST['newdays']) ? $_POST['newdays'] : '');
		$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($treatmentplanname) || empty($qty)|| empty($route)|| empty($newdays) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$med = explode('@@@', $medication);
				$medicationcode = $med[0];
				$medicationname = $med[1];
				$doseagecode = $med[2];
				$doseagename = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				if(!empty($frequency)){
					$freq = explode('@@@', $frequency);
					$frequencycode = $freq[0];
					$frequencyname = $freq[1];
				//	$frequencyqty = $freq[2];
				}else{
					$frequencycode = '';
					$frequencyname = '';
				//	$frequencyqty = '';
				}
				$dayscode = $daysname = $newdays;
				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}	
				$treatmentplanname = strtoupper($treatmentplanname);
				$treatmentplancode = md5(microtime());
				$prescriptionplannumber = rand(1,10000);	
				$sqlresults = $prescriptionplancontroller->newtreatmentplaninsertion($form_key,$prescriptionplannumber,$treatmentplancode,$treatmentplanname,$days,$day,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode,$prescriptionplansetuptable,$planmedicationtable);
				$action = "New prescription Plan";
				$result = $engine->getresults($sqlresults,$item=$treatmentplanname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=417;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
		
			
			}
		}
	break;		
	// 9 oct 2023, 27 MAY 2021 JOSEPH ADORBOE
	case 'addmedicationtotreatmentplan':
		$treatmentplanname = htmlspecialchars(isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '');
		$treatmentplancode = htmlspecialchars(isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '');
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
		$newdays = htmlspecialchars(isset($_POST['newdays']) ? $_POST['newdays'] : '');
		$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($treatmentplanname) || empty($qty)|| empty($route)|| empty($newdays) || empty($treatmentplancode)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				foreach ($medication as $key) {
				$med = explode('@@@', $key);
				$medicationcode = $med[0];
				$medicationname = $med[1];
				$doseagecode = $med[2];
				$doseagename = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				if(!empty($frequency)){
					$freq = explode('@@@', $frequency);
					$frequencycode = $freq[0];
					$frequencyname = $freq[1];
				//	$frequencyqty = $freq[2];
				}else{
					$frequencycode = '';
					$frequencyname = '';
				//	$frequencyqty = '';
				}
				$dayscode = $daysname = $newdays;
				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}	
				$form_key = md5(microtime());
				$sqlresults = $planmedicationtable->newprescriptionplanmedication($form_key,$treatmentplancode,$treatmentplanname,$medicationcode,$medicationname,$day,$doseagecode,$doseagename,$notes,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				$action = "$medicationname added to";
				$result = $engine->getresults($sqlresults,$item=$treatmentplanname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=418;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			
			}
		}
		}
	break;
	// 9 oct 2023, 27 MAY 2021
	case 'edittreatmenpalnmedication':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$treatmentplanname = htmlspecialchars(isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '');
		$treatmentplancode = htmlspecialchars(isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '');
		$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
		$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
		$newdays = htmlspecialchars(isset($_POST['newdays']) ? $_POST['newdays'] : '');
		$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$med = explode('@@@', $medication);
				$medicationcode = $med[0];
				$medicationname = $med[1];
				$doseagecode = $med[2];
				$doseagename = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				if(!empty($frequency)){
					$freq = explode('@@@', $frequency);
					$frequencycode = $freq[0];
					$frequencyname = $freq[1];
				//	$frequencyqty = $freq[2];
				}else{
					$frequencycode = '';
					$frequencyname = '';
				//	$frequencyqty = '';
				}
				$dayscode = $daysname = $newdays;
				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}	

				$sqlresults = $planmedicationtable->update_planmedication($ekey,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				$action = "Edit Treatment plan Medication";
				$result = $engine->getresults($sqlresults,$item=$medicationname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=420;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;	
	// 9 oct 2023, 27 MAY 2021
	case 'removemedicationfromtretmentplan':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$treatmentplanname = htmlspecialchars(isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '');
		$treatmentplancode = htmlspecialchars(isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '');
		$removereason = htmlspecialchars(isset($_POST['removereason']) ? $_POST['removereason'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($removereason)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
				$sqlresults = $planmedicationtable->update_removemedicationfromtreatmentplan($ekey,$removereason,$days,$currentusercode,$currentuser,$instcode);
				$action = "Remove Medication from Treatment Plan";
				$result = $engine->getresults($sqlresults,$item=$treatmentplanname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=419;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;	
			
	} 

?>
