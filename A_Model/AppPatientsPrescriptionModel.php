<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$prescriptionmodel = htmlspecialchars(isset($_POST['prescriptionmodel']) ? $_POST['prescriptionmodel'] : '');
	global $treatmentplancode, $treatmentplanname;
	
	// 27 MAR 2021 
switch ($prescriptionmodel)
{

	// 8 oct 2023, 12 SEPT 2021
	case 'addpatientprescriptionbulk':		
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$newmedication = htmlspecialchars(isset($_POST['newmedication']) ? $_POST['newmedication'] : '');
		$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
		$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
		$unitqty = htmlspecialchars(isset($_POST['unitqty']) ? $_POST['unitqty'] : '');
		$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
		$predays = htmlspecialchars(isset($_POST['predays']) ? $_POST['predays'] : '');	
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
		//	if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($pdays) || empty($consultationpaymenttype) ){
			if(empty($medication) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else {				
				
				if(!empty($_POST["newallergy"])){						
					foreach ($_POST["newallergy"] as $key) {
						$kt = explode('@@@', $key);
						$allergycode = $kt['0'];
						$allergyname = $kt['1'];
						$form_key = md5(microtime());
						$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
					}
				}
				foreach ($medication as $key) {
					$med = explode('@@@', $key);
					$medicationcode = $med[0];
					$medicationname = $med[1];
					$doseagecode = $med[2];
					$doseagename = $med[3];
					$dosageunit = $med[6];
					$type = 'OPD';

					if(!empty($frequency)){
						$freq = explode('@@@', $frequency);
						$frequencycode = $freq[0];
						$frequencyname = $freq[1];
						$frequencyqty = $freq[2];
					}else{
						$frequencycode = '';
						$frequencyname = '';
						$frequencyqty = '';
					}
					$dayscode = $daysname = $predays;
					if(!empty($route)){
						$rou = explode('@@@', $route);
						$routecode = $rou[0];
						$routename = $rou[1];
					}else{
						$routecode = '';
						$routename = '';
					}
					
					if($dosageunit == 'Per Pack' || $dosageunit == 'Per Bottle'){
						$qty = 1;
					}else{
						if(is_numeric($predays) && is_numeric($unitqty) && is_numeric($frequencyqty)){
							$qty = $predays*$unitqty*$frequencyqty;
						}else{
							$qty = 1;
						}
						
					}

			//	$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
				$prescriptionrequestcode = rand(1,10000);
				$form_key = md5(microtime());	
				
				$sqlresults = $prescriptioncontroller->addpatientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$type,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode,$Prescriptionstable,$patientconsultationstable,$medicationtable);
				
				$action = "Patient Prescription added";
				$result = $engine->getresults($sqlresults,$item=$medicationname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=425;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}	
				}	
		}
	break;
	// 8 oct 2023, 10 APR 2022 
	case 'addpatientallergy':
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(!empty($_POST["newallergy"])){						
				foreach ($_POST["newallergy"] as $key) {
					$kt = explode('@@@', $key);
					$allergycode = $kt['0'];
					$allergyname = $kt['1'];
					$form_key = md5(microtime());
					$sqlresults = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);
					$action = "Patient allergy added";
				$result = $engine->getresults($sqlresults,$item=$allergyname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=424;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}		
		}
	break;
	// 8 oct 2023,  27 MAR 2021
	case 'editprescription':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
		$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
		$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
		$predays = htmlspecialchars(isset($_POST['predays']) ? $_POST['predays'] : '');
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
			//	$dosageunit = $med[6];
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
				$dayscode = $daysname = $predays;
				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}
				$dayscode = $daysname = $predays;

				$sqlresults = $Prescriptionstable->update_patientprescription($ekey,$days,$day,$medicationcode,$medicationname,$doseagecode,$doseagename,$notes,$type,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);				
				$action = "Edit Patient prescription";
				$result = $engine->getresults($sqlresults,$item=$medicationname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=422;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}
		}
	break;
	// 8 oct 2023, 27 MAR 2021
	case 'removeprescription':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($cancelreason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{						
				$sqlresults = $Prescriptionstable->update_removepatientprescription($ekey,$cancelreason,$days,$currentusercode,$currentuser,$instcode);							
				$action = "Remove Patient prescription";
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=421;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;
	// 03 JUNE 2022  JOSEPH ADORBOE 
	case 'repeatprescriptions':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){	
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if (empty($_POST["scheckbox"])) {
                    $status = "error";
                    $msg = "Required Fields cannot be empty";
                } else {
                    foreach ($_POST["scheckbox"] as $key) {
                        $kt = explode('@@@', $key);
                        $medicationcode = $kt['0'];
                        $medication = $kt['1'];
                        $dosageformcode = $kt['2'];
                        $dosageformname = $kt['3'];
                        $frequencycode = $kt['4'];
                        $frequencyname = $kt['5'];
						$dayscode = $kt['6'];
                        $daysname = $kt['7'];
                        $routecode = $kt['8'];
                        $routename = $kt['9'];
                        $qty = $kt['10'];
                        $strenght = $kt['11'];
						$desc = $kt['12'];
						$type = 'OPD';   
						$form_key = md5(microtime()) ;
						$prescriptionrequestcode = rand(1,10000);		  
                            $sqlresults = $prescriptioncontroller->addpatientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medicationcode,$medication,$dosageformcode,$dosageformname,$notes='NA',$type,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode,$Prescriptionstable,$patientconsultationstable,$medicationtable);
							
							$action = "Repeat Patient prescription";
							$result = $engine->getresults($sqlresults,$item=$medication,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=423;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
												
                        }
                    }
                }
            }			
	break;	
	// 9 oct 2023, 27 MAY 2021
	case 'searchtreatmentplan':
		$treatmentplan = htmlspecialchars(isset($_POST['treatmentplan']) ? $_POST['treatmentplan'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($treatmentplan) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{	
				$freq = explode('@@@', $treatmentplan);
				$treatmentplancode = $freq[0];
				$treatmentplanname = $freq[1];
			}
		}
	break;	
	// 9 oct 2023, 28 MAY 2021 JOSEPH ADORBOE 
	case 'treatmentplanprescription':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){	
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if (empty($_POST["scheckbox"])) {
                    $status = "error";
                    $msg = "Required Fields cannot be empty";
                } else {
                    foreach ($_POST["scheckbox"] as $key) {
                        $kt = explode('@@@', $key);
                        $medicationcode = $kt['0'];
                        $medicationname = $kt['1'];
                        $dosageformcode = $kt['2'];
                        $dosageformname = $kt['3'];
                        $frequencycode = $kt['4'];
                        $frequencyname = $kt['5'];
						$dayscode = $kt['6'];
                        $daysname = $kt['7'];
                        $routecode = $kt['8'];
                        $routename = $kt['9'];
                        $qty = $kt['10'];
                        $strenght = $kt['11'];
						$desc = $kt['12'];
						$type = 'OPD';   
						$form_key = md5(microtime()) ;
						$prescriptionrequestcode = rand(1,10000);
						// $prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);		  
                            $sqlresults = $prescriptioncontroller->inserttreatmentplanprescrption($form_key,$patientcode,$patientnumber,$patient,$visitcode,$medicationcode,$medicationname,$dosageformcode,$dosageformname,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$desc,$age,$gender,$type,$consultationcode,$paymentmethodcode,$paymentmethod,$schemecode,$scheme,$day,$days,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$Prescriptionstable,$patientconsultationstable,$medicationtable);
							$action = "Patient prescription";
							$result = $engine->getresults($sqlresults,$item=$medicationname,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=425;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
                        }
                    }
                }
            }			
	break;
	
	
	

	// // 12 SEPT 2021
	// case 'addpatientprescription':		
	// 	$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
	// 	$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
	// 	$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
	// 	$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
	// 	$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
	// 	$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
	// 	$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
	// 	$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
	// 	$newmedication = htmlspecialchars(isset($_POST['newmedication']) ? $_POST['newmedication'] : '');
	// 	$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
	// 	$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
	// 	$unitqty = htmlspecialchars(isset($_POST['unitqty']) ? $_POST['unitqty'] : '');
	// 	$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
	// 	$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
	// 	$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
	// 	$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
	// 	$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
	// 	$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
	// 	$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
	// 	$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
	// 	$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
	// 	$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
	// 	$predays = htmlspecialchars(isset($_POST['predays']) ? $_POST['predays'] : '');	
	// 	$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');		
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 	//	if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($pdays) || empty($consultationpaymenttype) ){
	// 		if(empty($medication) && empty($newmedication) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else if((!empty($medication) && empty($newmedication)) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($predays) || empty($consultationpaymenttype)){
				
	// 			$med = explode('@@@', $medication);
	// 			$medcode = $med[0];
	// 			$medname = $med[1];
	// 			$dosecode = $med[2];
	// 			$dose = $med[3];
	// 			$dunit = $med[6];
	// 		//	$notes = strtoupper($notes);
	// 			$type = 'OPD';

	// 			$freq = explode('@@@', $frequency);
	// 			$freqcode = $freq[0];
	// 			$freqname = $freq[1];
	// 			$freqqty = $freq[2];

	// 			// $da = explode('@@@', $pdays);
	// 			// $dayscode = $da[0];
	// 			// $daysname = $da[1];
	// 			// $daysvalue = $da[2];
	// 			$dayscode = $daysname = $predays;
	// 			if(!empty($route)){
	// 				$rou = explode('@@@', $route);
	// 				$routecode = $rou[0];
	// 				$routename = $rou[1];
	// 			}else{
	// 				$routecode = '';
	// 				$routename = '';
	// 			}
				
	// 			if($dunit == 'Per Pack' || $dunit == 'Per Bottle'){
	// 				$qty = 1;
	// 			}else{
	// 				$qty = $predays*$unitqty*$freqqty;
	// 			}
				
	// 			if(!empty($_POST["newallergy"])){						
	// 				foreach ($_POST["newallergy"] as $key) {
	// 					$kt = explode('@@@', $key);
	// 					$allergycode = $kt['0'];
	// 					$allergyname = $kt['1'];
	// 					$form_key = md5(microtime());
	// 					$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
	// 				}
	// 			}
				
	// 			$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
				
	// 			$addmedication = $prescriptionsql->insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
	// 			$title = "Add Patient Prescription ";
	// 			if($addmedication == '0'){				
	// 				$status = "error";					
	// 				$msg = "$title $medname  Unsuccessful"; 
	// 			}else if($addmedication == '1'){						
	// 				$status = "error";					
	// 				$msg = "$title $medname  Exist";					
	// 			}else if($addmedication == '2'){
	// 				$event= "$title successfully ";
	// 				$eventcode= "129";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){			
	// 					$status = "success";
	// 					$msg = "$title $medname added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}				
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source "; 					
	// 		}

	// 	}else if((empty($medication) && !empty($newmedication)) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($predays) || empty($consultationpaymenttype)){

	// 		// $med = explode('@@@', $medication);
	// 		// $medcode = $med[0];
	// 		// $medname = $med[1];
	// 		// $dosecode = $med[2];
	// 		// $dose = $med[3];
	// 	//	$notes = strtoupper($notes);
	// 		$type = 'OPD';

	// 		$freq = explode('@@@', $frequency);
	// 		$freqcode = $freq[0];
	// 		$freqname = $freq[1];
	// 		$freqqty = $freq[2];

	// 		// $da = explode('@@@', $pdays);
	// 		// $dayscode = $da[0];
	// 		// $daysname = $da[1];
	// 		// $daysvalue = $da[2];
	// 		$dayscode = $daysname = $predays;

	// 		if(!empty($route)){
	// 			$rou = explode('@@@', $route);
	// 			$routecode = $rou[0];
	// 			$routename = $rou[1];
	// 		}else{
	// 			$routecode = '';
	// 			$routename = '';
	// 		}
	// 		if(!empty($_POST["newallergy"])){						
	// 			foreach ($_POST["newallergy"] as $key) {
	// 				$kt = explode('@@@', $key);
	// 				$allergycode = $kt['0'];
	// 				$allergyname = $kt['1'];
	// 				$form_key = md5(microtime());
	// 				$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
	// 			}
	// 		}
			
	// 		$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
	// 		$medicationnumber = $setupcontroller->getlastmedicationcodenumber($instcode);
	// 		$medcode = md5(microtime());
	// 		$qty = $predays*$unitqty*$freqqty;


	// 		$addmedication = $prescriptionsql->insert_patientaddprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medicationnumber,$newmedication,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
	// 		$title = 'Add Patient Prescription ';
	// 		if($addmedication == '0'){				
	// 			$status = "error";					
	// 			$msg = "$title $newmedication  Unsuccessful"; 
	// 		}else if($addmedication == '1'){						
	// 			$status = "error";					
	// 			$msg = "$title $newmedication  Exist";					
	// 		}else if($addmedication == '2'){
	// 			$event= "$title successfully ";
	// 			$eventcode= "129";
	// 			$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 			if($audittrail == '2'){			
	// 				$status = "success";
	// 				$msg = "$title $newmedication added Successfully";
	// 			}else{
	// 				$status = "error";
	// 				$msg = "Audit Trail unsuccessful";	
	// 			}				
	// 	}else{				
	// 			$status = "error";					
	// 			$msg = "Unknown source "; 					
	// 	}


	// 	}else if(!empty($medication) && !empty($newmedication)){
	// 		$status = "error";					
	// 		$msg = "Medications and New Medication cannot be used together  "; 
			
	// 	}
	// 	}

	// break;



	// // 23 JAN 2022 JOSEPH ADORBOE 
	// case 'editprescriptionplan':

	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$prescriptionplan = htmlspecialchars(isset($_POST['prescriptionplan']) ? $_POST['prescriptionplan'] : '');
	// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 		if(empty($ekey) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{									
	// 			$prescriptionplan = strtoupper($prescriptionplan)	;
	// 			$edit = $prescriptionsql->update_prescriptionplan($ekey,$prescriptionplan,$description,$currentusercode,$currentuser,$instcode);
	// 			$title = "Edit Prescription Plan ";
	// 			if($edit == '0'){				
	// 				$status = "error";					
	// 				$msg = "$title $prescriptionplan Unsuccessful"; 
	// 			}else if($edit == '1'){				
	// 				$status = "error";					
	// 				$msg = "$title $prescriptionplan Exist"; 					
	// 			}else if($edit == '2'){
	// 				$event= "$title successfully ";
	// 				$eventcode= "185";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){			
	// 					$status = "success";
	// 					$msg = "$title $prescriptionplan Edit Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}			
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source "; 					
	// 		}

	// 		}
	// 	}

	// break;
	


	
	
	
	
	
	
	// // 27 MAR 2021
	// case 'addpatientprescription':
	// 	$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
	// 	$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
	// 	$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
	// 	$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
	// 	$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
	// 	$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
	// 	$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
	// 	$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
	// 	$frequency = htmlspecialchars(isset($_POST['frequency']) ? $_POST['frequency'] : '');
	// 	$pdays = htmlspecialchars(isset($_POST['pdays']) ? $_POST['pdays'] : '');
	// 	$route = htmlspecialchars(isset($_POST['route']) ? $_POST['route'] : '');
	// 	$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
	// 	$strenght = htmlspecialchars(isset($_POST['strenght']) ? $_POST['strenght'] : '');
	// 	$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
	// 	$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
	// 	$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
	// 	$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
	// 	$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');	
	// 	$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');	
	// 	$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');		
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 		if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($pdays) || empty($consultationpaymenttype) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{

	// 			$med = explode('@@@', $medication);
	// 			$medcode = $med[0];
	// 			$medname = $med[1];
	// 			$dosecode = $med[2];
	// 			$dose = $med[3];
	// 			$dosename = $med[4];
	// 			$brand = $med[5];
	// 		//	$notes = strtoupper($notes);
	// 			$type = 'OPD';

	// 			$freq = explode('@@@', $frequency);
	// 			$freqcode = $freq[0];
	// 			$freqname = $freq[1];

	// 			$da = explode('@@@', $pdays);
	// 			$dayscode = $da[0];
	// 			$daysname = $da[1];

	// 			if(!empty($route)){
	// 				$rou = explode('@@@', $route);
	// 				$routecode = $rou[0];
	// 				$routename = $rou[1];
	// 			}else{
	// 				$routecode = '';
	// 				$routename = '';
	// 			}

	// 			if(!empty($_POST["newallergy"])){						
	// 				foreach ($_POST["newallergy"] as $key) {
	// 					$kt = explode('@@@', $key);
	// 					$allergycode = $kt['0'];
	// 					$allergyname = $kt['1'];
	// 					$form_key = md5(microtime());
	// 					$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
	// 				}
	// 			}
				
	// 			$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
	// 			$addmedication = $prescriptionsql->insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
	// 			$title = 'Add Patient Prescription ';
	// 			if($addmedication == '0'){				
	// 				$status = "error";					
	// 				$msg = "$title $medname  Unsuccessful"; 
	// 			}else if($addmedication == '1'){						
	// 				$status = "error";					
	// 				$msg = "$title $medname  Exist";					
	// 			}else if($addmedication == '2'){
	// 				$event= "$title successfully ";
	// 				$eventcode= "129";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){			
	// 					$status = "success";
	// 					$msg = " $title $medname added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}				
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source "; 					
	// 		}
	// 		}
	// 	}
	// break;
	
	
	// // 27 MAR 2021
	// case 'addnewmedication':
	// 	$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
	// 	$doseform = htmlspecialchars(isset($_POST['doseform']) ? $_POST['doseform'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
	// 	if($preventduplicate == '1'){

	// 		if(empty($medication) || empty($doseform) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{
	// 			$medication = strtoupper($medication);
	// 			$dos = explode('@@@', $doseform);
	// 			$doscode = $dos[0];
	// 			$dosname = $dos[1];	
	// 			$medicationnumber = $setupcontroller->getlastmedicationcodenumber($instcode);

	// 			$addnew = $prescriptionsql->insert_newmedication($form_key,$medication,$medicationnumber,$doscode,$dosname,$currentusercode,$currentuser,$instcode);
	// 			if($addnew == '0'){				
	// 				$status = "error";					
	// 				$msg = "Add New medication $medication Unsuccessful"; 
	// 			}else if($addnew == '1'){					
	// 				$status = "error";					
	// 				$msg = "New Medication $medication Exist"; 						
	// 			}else if($addnew == '2'){
	// 				$event= "Add New Medication Added successfully ";
	// 				$eventcode= "126";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "New Medication $medication Added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}	
				
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source ";					
	// 		}
	// 		}
	// 	}

	// break;			
		
}
 

?>
