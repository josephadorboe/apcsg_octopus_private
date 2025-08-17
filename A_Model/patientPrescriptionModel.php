<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$prescriptionmodel = isset($_POST['prescriptionmodel']) ? $_POST['prescriptionmodel'] : '';
	global $treatmentplancode, $treatmentplanname;
	
	// 27 MAR 2021 
switch ($prescriptionmodel)
{

	// 03 JUNE 2022  JOSEPH ADORBOE 
	case 'repeatprescriptions':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
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
						$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);		  
                            $tplanprescription = $prescriptionsql->insert_treatmentplanprescrption($form_key,$patientcode,$patientnumber,$patient,$visitcode,$medicationcode,$medication,$dosageformcode,$dosageformname,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$desc,$age,$gender,$type,$consultationcode,$paymentmethodcode,$paymentmethod,$schemecode,$scheme,$day,$days,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
							$title = "Prescription";
                            if ($tplanprescription == '1') {
                                $status = "error";
                                $msg = "$title Already Selected";
                            } elseif ($tplanprescription == '2') {
                                $event= "$title $patient for  has been saved successfully ";
                                $eventcode= 151;
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "$title Successfully";
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail Failed!";
                                }
                            } elseif ($tplanprescription == '0') {
                                $status = "error";
                                $msg = "Unsuccessful";
                            } else {
                                $status = "error";
                                $msg = "Unknown Source";
                            }
                        }
                    }
                }
            }		
			
	break;


	// 10 APR 2022 
	case 'addpatientallergy':
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(!empty($_POST["newallergy"])){						
				foreach ($_POST["newallergy"] as $key) {
					$kt = explode('@@@', $key);
					$allergycode = $kt['0'];
					$allergyname = $kt['1'];
					$form_key = md5(microtime());
					$insertcheck = $patientsqueue->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);
					
					if($insertcheck == '0'){				
						$status = "error";					
						$msg = "Add New allergy $allergyname Unsuccessful"; 
					}else if($insertcheck == '1'){					
						$status = "error";					
						$msg = "New Allergy $allergyname Exist"; 						
					}else if($insertcheck == '2'){
						$event= "Add New Allergy Added successfully ";
						$eventcode= "126";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = "New Allergy $allergyname Added Successfully";
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
		}

	break;


	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'editprescriptionplan':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$prescriptionplan = isset($_POST['prescriptionplan']) ? $_POST['prescriptionplan'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$prescriptionplan = strtoupper($prescriptionplan)	;
				$edit = $prescriptionsql->update_prescriptionplan($ekey,$prescriptionplan,$description,$currentusercode,$currentuser,$instcode);
				$title = "Edit Prescription Plan ";
				if($edit == '0'){				
					$status = "error";					
					$msg = "$title $prescriptionplan Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title $prescriptionplan Exist"; 					
				}else if($edit == '2'){
					$event= "$title successfully ";
					$eventcode= "185";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $prescriptionplan Edit Successfully";
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
	// 12 SEPT 2021
	case 'addpatientprescription':		
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$newmedication = isset($_POST['newmedication']) ? $_POST['newmedication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$unitqty = isset($_POST['unitqty']) ? $_POST['unitqty'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';	
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';	
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
		$predays = isset($_POST['predays']) ? $_POST['predays'] : '';	
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
		//	if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($pdays) || empty($consultationpaymenttype) ){
			if(empty($medication) && empty($newmedication) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if((!empty($medication) && empty($newmedication)) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($predays) || empty($consultationpaymenttype)){
				
				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
				$dunit = $med[6];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];
				$freqqty = $freq[2];

				// $da = explode('@@@', $pdays);
				// $dayscode = $da[0];
				// $daysname = $da[1];
				// $daysvalue = $da[2];
				$dayscode = $daysname = $predays;
				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}
				
				if($dunit == 'Per Pack' || $dunit == 'Per Bottle'){
					$qty = 1;
				}else{
					$qty = $predays*$unitqty*$freqqty;
				}
				
				if(!empty($_POST["newallergy"])){						
					foreach ($_POST["newallergy"] as $key) {
						$kt = explode('@@@', $key);
						$allergycode = $kt['0'];
						$allergyname = $kt['1'];
						$form_key = md5(microtime());
						$insertcheck = $patientsqueue->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
					}
				}
				
				$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
				
				$addmedication = $prescriptionsql->insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
				$title = "Add Patient Prescription ";
				if($addmedication == '0'){				
					$status = "error";					
					$msg = "$title $medname  Unsuccessful"; 
				}else if($addmedication == '1'){						
					$status = "error";					
					$msg = "$title $medname  Exist";					
				}else if($addmedication == '2'){
					$event= "$title successfully ";
					$eventcode= "129";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $medname added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

		}else if((empty($medication) && !empty($newmedication)) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($predays) || empty($consultationpaymenttype)){

			// $med = explode('@@@', $medication);
			// $medcode = $med[0];
			// $medname = $med[1];
			// $dosecode = $med[2];
			// $dose = $med[3];
		//	$notes = strtoupper($notes);
			$type = 'OPD';

			$freq = explode('@@@', $frequency);
			$freqcode = $freq[0];
			$freqname = $freq[1];
			$freqqty = $freq[2];

			// $da = explode('@@@', $pdays);
			// $dayscode = $da[0];
			// $daysname = $da[1];
			// $daysvalue = $da[2];
			$dayscode = $daysname = $predays;

			if(!empty($route)){
				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];
			}else{
				$routecode = '';
				$routename = '';
			}
			if(!empty($_POST["newallergy"])){						
				foreach ($_POST["newallergy"] as $key) {
					$kt = explode('@@@', $key);
					$allergycode = $kt['0'];
					$allergyname = $kt['1'];
					$form_key = md5(microtime());
					$insertcheck = $patientsqueue->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
				}
			}
			
			$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
			$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);
			$medcode = md5(microtime());
			$qty = $predays*$unitqty*$freqqty;


			$addmedication = $prescriptionsql->insert_patientaddprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medicationnumber,$newmedication,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
			$title = 'Add Patient Prescription ';
			if($addmedication == '0'){				
				$status = "error";					
				$msg = "$title $newmedication  Unsuccessful"; 
			}else if($addmedication == '1'){						
				$status = "error";					
				$msg = "$title $newmedication  Exist";					
			}else if($addmedication == '2'){
				$event= "$title successfully ";
				$eventcode= "129";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){			
					$status = "success";
					$msg = "$title $newmedication added Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}				
		}else{				
				$status = "error";					
				$msg = "Unknown source "; 					
		}


		}else if(!empty($medication) && !empty($newmedication)){
			$status = "error";					
			$msg = "Medications and New Medication cannot be used together  "; 
			
		}
		}

	break;


	// 28 MAY 2021 JOSEPH ADORBOE 
	case 'treatmentplanprescription':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
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
						$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);		  
                            $tplanprescription = $prescriptionsql->insert_treatmentplanprescrption($form_key,$patientcode,$patientnumber,$patient,$visitcode,$medicationcode,$medication,$dosageformcode,$dosageformname,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$desc,$age,$gender,$type,$consultationcode,$paymentmethodcode,$paymentmethod,$schemecode,$scheme,$day,$days,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
							$title = 'Prescription';
                            if ($tplanprescription == '1') {
                                $status = "error";
                                $msg = "$title Already Selected";
                            } elseif ($tplanprescription == '2') {
                                $event= "$title $patient for  has been saved successfully ";
                                $eventcode= 151;
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "$title Successfully";
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail Failed!";
                                }
                            } elseif ($tplanprescription == '0') {
                                $status = "error";
                                $msg = "Unsuccessful";
                            } else {
                                $status = "error";
                                $msg = "Unknown Source";
                            }
                        }
                    }
                }
            }		
			
	break;
	// 27 MAY 2021
	case 'removemedicationfromtretmentplan':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$treatmentplanname = isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '';
		$treatmentplancode = isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
				$remove = $prescriptionsql->update_removemedicationfromtreatmentplan($ekey,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Medication from Treatment Plan ';
				if($remove == '0'){				
					$status = "error";					
					$msg = "$title $treatmentplanname Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "$title $treatmentplanname Exist"; 					
				}else if($remove == '2'){
					$event= "$title successfully ";
					$eventcode= "127";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $treatmentplanname Removed Successfully";
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
	// 27 MAY 2021
	case 'edittreatmenpalnmedication':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$treatmentplanname = isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '';
		$treatmentplancode = isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				$da = explode('@@@', $pdays);
				$dayscode = $da[0];
				$daysname = $da[1];

				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];	

				$edit = $prescriptionsql->update_treatmentplanmedication($ekey,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Treatment plan Medication ';
				if($edit == '0'){				
					$status = "error";					
					$msg = "$title $medname Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title $medname Exist"; 					
				}else if($edit == '2'){
					$event= "$title successfully ";
					$eventcode= "49";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $medname edited Successfully";
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
	// 27 MAY 2021 JOSEPH ADORBOE
	case 'addmedicationtotreatmentplan':
		$treatmentplanname = isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '';
		$treatmentplancode = isset($_POST['treatmentplancode']) ? $_POST['treatmentplancode'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($treatmentplanname) || empty($qty)|| empty($route)|| empty($pdays) || empty($treatmentplancode)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{

				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				$da = explode('@@@', $pdays);
				$dayscode = $da[0];
				$daysname = $da[1];

				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];	
				
				$newtreatmentplan = $prescriptionsql->insert_addmedicationtotreatmentplans($form_key,$treatmentplanname,$treatmentplancode,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				$title = 'Add to Treatment Plan';
				if($newtreatmentplan == '0'){				
					$status = "error";					
					$msg = "$title Added $treatmentplanname  Unsuccessful"; 
				}else if($newtreatmentplan == '1'){						
					$status = "error";					
					$msg = "$title $treatmentplanname  Exist";					
				}else if($newtreatmentplan == '2'){
					$event= "$title added successfully ";
					$eventcode= "48";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $treatmentplanname added Successfully";
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
	// 27 MAY 2021
	case 'searchtreatmentplan':
		$treatmentplan = isset($_POST['treatmentplan']) ? $_POST['treatmentplan'] : '';
	//	$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
	// 27 MAY 2021 JOSEPH ADORBOE
	case 'newtreatmentplan':

		$treatmentplanname = isset($_POST['treatmentplanname']) ? $_POST['treatmentplanname'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($treatmentplanname) || empty($qty)|| empty($route)|| empty($pdays) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				$da = explode('@@@', $pdays);
				$dayscode = $da[0];
				$daysname = $da[1];

				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];	
				$treatmentplanname = strtoupper($treatmentplanname);
				$treatmentplancode = md5(microtime());
				$prescriptionplannumber = $lov->getprescriptionplannumber($instcode);	
				$newtreatmentplan = $prescriptionsql->insert_treatmentplans($form_key,$prescriptionplannumber,$treatmentplancode,$treatmentplanname,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				$title = 'New Treatment Plan';
				if($newtreatmentplan == '0'){				
					$status = "error";					
					$msg = "$title Added $treatmentplanname  Unsuccessful"; 
				}else if($newtreatmentplan == '1'){						
					$status = "error";					
					$msg = "$title $treatmentplanname  Exist";					
				}else if($newtreatmentplan == '2'){
					$event= "$title added successfully ";
					$eventcode= "47";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $treatmentplanname added Successfully";
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
	// 27 MAR 2021
	case 'addpatientprescription':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';	
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';	
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)||   empty($pdays) || empty($consultationpaymenttype) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{

				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
				$dosename = $med[4];
				$brand = $med[5];
			//	$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				$da = explode('@@@', $pdays);
				$dayscode = $da[0];
				$daysname = $da[1];

				if(!empty($route)){
					$rou = explode('@@@', $route);
					$routecode = $rou[0];
					$routename = $rou[1];
				}else{
					$routecode = '';
					$routename = '';
				}

				if(!empty($_POST["newallergy"])){						
					foreach ($_POST["newallergy"] as $key) {
						$kt = explode('@@@', $key);
						$allergycode = $kt['0'];
						$allergyname = $kt['1'];
						$form_key = md5(microtime());
						$insertcheck = $patientsqueue->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
					}
				}
				
				$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);	
				$addmedication = $prescriptionsql->insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode);
				$title = 'Add Patient Prescription ';
				if($addmedication == '0'){				
					$status = "error";					
					$msg = "$title $medname  Unsuccessful"; 
				}else if($addmedication == '1'){						
					$status = "error";					
					$msg = "$title $medname  Exist";					
				}else if($addmedication == '2'){
					$event= "$title successfully ";
					$eventcode= "129";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = " $title $medname added Successfully";
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
	// 27 MAR 2021
	case 'editprescription':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$predays = isset($_POST['predays']) ? $_POST['predays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
			//	$notes = strtoupper($notes); 
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				// $da = explode('@@@', $pdays);
				// $dayscode = $da[0];
				// $daysname = $da[1];

				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];	
				$dayscode = $daysname = $predays;

				$edit = $prescriptionsql->update_patientprescription($ekey,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Patient Prescription $medname Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Patient Prescription $medname Exist"; 					
				}else if($edit == '2'){
					$event= "Patient Prescription Edited successfully ";
					$eventcode= "128";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Patient Prescription $medname edited Successfully";
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
	// 27 MAR 2021
	case 'removeprescription':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$cancelreason = isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($cancelreason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{								
					
				$remove = $prescriptionsql->update_removepatientprescription($ekey,$cancelreason,$currentusercode,$currentuser,$instcode);
				
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Patient Prescription $patient Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove patient Prescription $patient Exist"; 					
				}else if($remove == '2'){
					$event= "Patient Prescription Remove successfully ";
					$eventcode= "127";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Patient Prescription  $patient Removed Successfully";
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
	// 27 MAR 2021
	case 'addnewmedication':
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$doseform = isset($_POST['doseform']) ? $_POST['doseform'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($medication) || empty($doseform) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$medication = strtoupper($medication);
				$dos = explode('@@@', $doseform);
				$doscode = $dos[0];
				$dosname = $dos[1];	
				$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);

				$addnew = $prescriptionsql->insert_newmedication($form_key,$medication,$medicationnumber,$doscode,$dosname,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New medication $medication Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Medication $medication Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Medication Added successfully ";
					$eventcode= "126";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Medication $medication Added Successfully";
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
		
}
 

?>
