<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
//	$physiosql = new PatientPhysioController();
	$physiomodel = isset($_POST['physiomodel']) ? $_POST['physiomodel'] : '';
	
	// 1 MAY 2022 
switch ($physiomodel)
{

	// 13 JAN 2023
	case 'addpatienttreatmentnotesdiet':

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
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
        if ($preventduplicate == '1') {
            if (empty($storyline)  || empty($patientcode) || empty($patientnumber)) {
                $status = 'error';
                $msg = 'Required Field Cannot be empty';
            } else {
                // $com = explode('@@@', $procedure);
                // $comcode = $com[0];
                // $comname = $com[1];
                $storyline = strtoupper($storyline);
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'DIETITICAN';
                $add = $physiosql->insert_patienttreatmentnotes($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient, $servicerequestedcode, $servicerequested, $storyline, $notesrequestcode, $types, $currentusercode, $currentuser, $instcode);
                $title = 'Patient Treatment Notes';
                if ($add == '0') {
                    $status = "error";
                    $msg = " $title add Unsuccessful";
                } elseif ($add == '1') {
                    $status = "error";
                    $msg = "".$title." Exist";
                } elseif ($add == '2') {
                    $event= " $title added successfully ";
                    $eventcode= "137";
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = " $title for $patient Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail Failed!";
                    }
                } else {
                    $status = "error";
                    $msg = "Unknown source ";
                }

             
            }
        }

	break;
	
	// 06 MAY 2022 JOSEPH ADORBOE 
	case 'edittreatmentnotes':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
	//	$procedure = isset($_POST['procedure']) ? $_POST['procedure'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					// $com = explode('@@@', $procedure);
					// $comcode = $com[0];
					// $comname = $com[1];
					$storyline = strtoupper($storyline);

				$remove = $physiosql->update_editpatienttreatment($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Patient Treatment Notes';
				if($remove == '0'){				
					$status = "error";					
					$msg = " $title  Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "$title Exist"; 					
				}else if($remove == '2'){
					$event= " $title  successfully ";
					$eventcode= "136";
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
	
	// 21 APR 2022 , 28 MAY 2021
	case 'patientsaction':

		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$patientaction = isset($_POST['patientaction']) ? $_POST['patientaction'] : '';
		$patientdate = isset($_POST['patientdate']) ? $_POST['patientdate'] : '';
		$services = isset($_POST['services']) ? $_POST['services'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientdeathdate = isset($_POST['patientdeathdate']) ? $_POST['patientdeathdate'] : '';
		$patientdeathtime = isset($_POST['patientdeathtime']) ? $_POST['patientdeathtime'] : '';
		$deathremarks = isset($_POST['deathremarks']) ? $_POST['deathremarks'] : '';
		$admissionnotes = isset($_POST['admissionnotes']) ? $_POST['admissionnotes'] : '';
		$triage = isset($_POST['triage']) ? $_POST['triage'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
		$referalservices = isset($_POST['referalservices']) ? $_POST['referalservices'] : '';
		$physician = isset($_POST['physician']) ? $_POST['physician'] : '';
		$referaltype = isset($_POST['referaltype']) ? $_POST['referaltype'] : '';
		$detentiontypes = isset($_POST['detentiontypes']) ? $_POST['detentiontypes'] : '';
		$action = isset($_POST['action']) ? $_POST['action'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if ($preventduplicate == '1') {
			if (empty($patientaction)) {
				$status = 'error';
				$msg = 'Required Field Cannot be empty';
			} else {
			  
				// Discharge the patients only 
				if ($patientaction == '10') {
					$action = 'DISCHARGED'; 
					$acts = $physiosql->update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks);               

					if ($acts == '0') {
						$status = "error";
						$msg = "Patient Action $action Unsuccessful";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '1') {
						$status = "error";
						$msg = "Patient Action $action Exist";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '2') {
						$event= "Patient Action successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
						if ($audittrail == '2') {
							$consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
							$status = "success";
							$msg = "Patient $patient $action Successfully";
							$actions = 'managephysioservicebasket';
						} else {
							$status = "error";
							$msg = "Audit Trail unsuccessful";
						}
					} else {
						$status = "error";
						$msg = "Unknown Source ";
					}

				
				}else if($patientaction == '70'){
				
				if (empty($patientdate) || empty($services) || empty($remarks)) {
					$status = 'error';
					$msg = 'Required Field Cannot be empty';
					$actions = "physiopatientaction?'.$idvalue";
				} else {
					$action = 'FOLLOWUP';

					$remarks = strtoupper($remarks);
					if (!empty($patientdate)) {
						$cdate = explode('/', $patientdate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$patientdate = $yyy.'-'.$mmd.'-'.$ddd;
						$requestcodecode = $currenttable->getreviewrequestcode($instcode);
						$sert = explode('@@@', $services);
						$servicecode = $sert[0];
						$servicesed = $sert[1];
				   
					} else {
						$servicecode = $servicesed = '';
					}

					$acts = $physiosql->update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
					
					if ($acts == '0') {
						$status = "error";
						$msg = "Patient Action ".$action." Unsuccessful";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '1') {
						$status = "error";
						$msg = "Patient Action ".$action." Exist";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '2') {
						$event= "Patient Action successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
						if ($audittrail == '2') {
							$consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
							$status = "success";
							$msg = "Patient $patient ".$action." Successfully";
							$actions = 'managephysioservicebasket';
						} else {
							$status = "error";
							$msg = "Audit Trail unsuccessful";
						}
					} else {
						$status = "error";
						$msg = "Unknown Source ";
					}
				}
			}else if($patientaction == '40'){

				if (empty($referalservices) || empty($physician) || empty($referaltype) || empty($remarks) ) {
					$status = 'error';
					$msg = 'Required Field Cannot be empty';
					$actions = "physiopatientaction?'.$idvalue";
				} else {
					$action = 'REFERAL';
						$sert = explode('@@@', $referalservices);
						$servicecode = $sert[0];
						$servicesed = $sert[1];
						$phy = explode('@@@', $physician);
						$physiciancode = $phy[0];
						$physicians = $phy[1];
						$consultationnumber = $lov->getconsultationrequestcode($instcode);
						$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
						$referalserviceamount = $pricing->getprice($paymentmethodcode, $schemecode, $servicecode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$reviewnumber = $currenttable->getreviewrequestcode($instcode);

					$acts = $referalsql->update_patientaction_referal($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $reviewnumber,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
			
					if ($acts == '0') {
						$status = "error";
						$msg = "Patient Action $action  Unsuccessful";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '1') {
						$status = "error";
						$msg = "Patient Action $action Exist";
						$actions = "physiopatientaction?'.$idvalue";
					} elseif ($acts == '2') {
						$event= "Patient Action successfully ";
						$eventcode= "149";
						$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
						if ($audittrail == '2') {
							$consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
							$status = "success";
							$msg = "Patient $patient $action Successfully";
							$actions = 'managephysioservicebasket';
						} else {
							$status = "error";
							$msg = "Audit Trail unsuccessful";
						}
					} else {
						$status = "error";
						$msg = "Unknown Source ";
					}
				}
			   
			// }else if($patientaction == '80'){
				
			// 	if (empty($patientdate) || empty($services) || empty($remarks)) {
			// 		$status = 'error';
			// 		$msg = 'Required Field Cannot be empty';
			// 		$actions = "consultationpatientaction?'.$idvalue";
			// 	} else {
			// 		$action = 'REVIEW';

			// 		$remarks = strtoupper($remarks);
			// 		if (!empty($patientdate)) {
			// 			$cdate = explode('/', $patientdate);
			// 			$mmd = $cdate[0];
			// 			$ddd = $cdate[1];
			// 			$yyy = $cdate[2];
			// 			$patientdate = $yyy.'-'.$mmd.'-'.$ddd;
			// 			$requestcodecode = $currenttable->getreviewrequestcode($instcode);
			// 			$sert = explode('@@@', $services);
			// 			$servicecode = $sert[0];
			// 			$servicesed = $sert[1];
				   
			// 		} else {
			// 			$servicecode = $servicesed = '';
			// 		}

			// 		$acts = $consultactionsql->update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
					
			// 		if ($acts == '0') {
			// 			$status = "error";
			// 			$msg = "Patient Action ".$action." Unsuccessful";
			// 			$actions = "consultationpatientaction?'.$idvalue";
			// 		} elseif ($acts == '1') {
			// 			$status = "error";
			// 			$msg = "Patient Action ".$action." Exist";
			// 			$actions = "consultationpatientaction?'.$idvalue";
			// 		} elseif ($acts == '2') {
			// 			$event= "Patient Action successfully ";
			// 			$eventcode= "149";
			// 			$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
			// 			if ($audittrail == '2') {
			// 				$consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
			// 				$status = "success";
			// 				$msg = "Patient $patient ".$action." Successfully";
			// 				$actions = 'patientconsultationgp';
			// 			} else {
			// 				$status = "error";
			// 				$msg = "Audit Trail unsuccessful";
			// 			}
			// 		} else {
			// 			$status = "error";
			// 			$msg = "Unknown Source ";
			// 		}
			// 	}

			// 	} 
				
			}
			}
		}

	break;
			   
	
	// 02 MAY 2022  JOSEPH ADORBOE
	case 'saveprocedurereports':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
		$reportstate = isset($_POST['reportstate']) ? $_POST['reportstate'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($procedurereport) ) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{					                      
                    $answer = $physiosql->enterprocedurereports($ekey, $procedurereport,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
                        
					// $locum = $msql->getlocumdetails($currentusercode,$instcode);
					// if($locum !== '0'){
					// 	$ps = explode('@', $locum);
					// 	$locumamount = $ps[0];
					// 	$locumntax = $ps[1];
					// 	$locumshare = $ps[2];
					// 	$facilityshare = $ps[3];
					// 	$paysource = 'PROCEDURE';
					// 	$procedurecost = $msql->getbillingitemdetails($ekey,$procedurecode,$instcode);
					// 	if($procedurecost !== '0'){
					// 		$consumablepercentage  = 3;
					// 		$consumableamount = ($procedurecost*$consumablepercentage)/100; 
					// 		$procedurefee = $procedurecost-$consumableamount;
					// 		$usershareamount  = ($procedurefee*$locumshare)/100; 
					// 		$usersharetaxamount = ($usershareamount*$locumntax)/100; 
					// 		$useramountdue = $usershareamount - $usersharetaxamount ;
					// 		$facilityshareamount = $procedurefee - $useramountdue;
					// 		$salarydetailsnum = $lov->getsalarydetailsnumber($instcode);
					// 		$salarynum = $lov->getsalarynumber($instcode);

					// 	//	$facilityshareamount  = ($procedurecost*$facilityshare)/100; 
					// 	//	$facilitysharetaxamount = ($facilityshareamount*$locumntax)/100; 
					// 	}

					// }else{
					// 	$locumamount = $locumntax = $locumshare = $facilityshare = $consumablepercentage = $paysource = $consumableamount = $procedurefee = $usershareamount = $usersharetaxamount = $useramountdue = $facilityshareamount = $salarydetailsnum = $salarynum = '0';
					// }


                    if ($answer == '1') {
                        $status = "error";
                        $msg = "Already Selected";
                    } elseif ($answer == '2') {
                        $event= "Procedure Report has been saved successfully ";
                        $eventcode= 165;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
							// if($locum !== '0'){
							// 	$msql->processprocedurefees($locumshare,$paysource,$facilityshare,$consumablepercentage,$consumableamount,$procedurefee,$usershareamount,$usersharetaxamount,$useramountdue,$facilityshareamount,$salarydetailsnum,$salarynum,$currentdate,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode);
							// }
							if($reportstate == '1'){
								$consultactionsql->countdoctorproceurestats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
							}
							
                            $status = "success";
                            $msg = "Report Entered Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } elseif ($answer == '0') {
                        $status = "error";
                        $msg = "Unsuccessful";
                    } else {
                        $status = "error";
                        $msg = "Unknown Source";
                    }
                }
            }
			
			}
	break;
	
	// 01 MAY 2022  JOSEPH ADORBOE 
	case 'savephysiovitals':			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';		
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$bp = isset($_POST['bp']) ? $_POST['bp'] : '';
		$temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';
		$height = isset($_POST['height']) ? $_POST['height'] : '';
		$spo = isset($_POST['spo']) ? $_POST['spo'] : '';
		$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';		
		$pulse = isset($_POST['pulse']) ? $_POST['pulse']: '' ;	
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
                if (empty($bp) || empty($temperature)) {
                    $status = 'error';
                    $msg = 'Blood pressure and temperature is mandatory';
                } else {
                    $dept = 'PHYSIOTHERAPY';
                    $fbs=$rbs=$glucosetest='NA';
                    $insertcheck = $physiosql->insert_patientphysiovitals($form_key, $patientcode, $patientnumber, $patient, $visitcode, $age, $gender, $bp, $temperature, $height, $weight, $remarks, $days, $currentshiftcode, $currentshift, $currentusercode, $currentuser, $instcode, $fbs, $rbs, $glucosetest, $pulse, $spo, $dept, $currentday, $currentmonth, $currentyear);
        
                    if ($insertcheck == '0') {
                        $status = "error";
                        $msg = "Adding Patient ".$patient. " Vitals Unsuccessful";
                    } elseif ($insertcheck == '1') {
                        $status = "error";
                        $msg = "Patient Vitals for ".$patient. " already Exist";
                    } elseif ($insertcheck == '2') {
                        $status = "success";
                        $msg = "Patient ".$patient. " Vitals added Successfully";
                        $event= "ADD PATIENT VITALS CODE:".$form_key." ".$patientcode.", ".$patient. " has been saved successfully ";
                        $eventcode= 52;
                        $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    } else {
                        $status = "error";
                        $msg = "Add New Users Unsuccessful ";
                    }
                }
            }
				
		}			
	break;

	// 26 MAR 2021
	case 'addpatienttreatmentnotes':

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
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
        if ($preventduplicate == '1') {
            if (empty($storyline)  || empty($patientcode) || empty($patientnumber)) {
                $status = 'error';
                $msg = 'Required Field Cannot be empty';
            } else {
                // $com = explode('@@@', $procedure);
                // $comcode = $com[0];
                // $comname = $com[1];
                $storyline = strtoupper($storyline);
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'PHYSIOTHERAPY';
                $add = $physiosql->insert_patienttreatmentnotes($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient, $servicerequestedcode, $servicerequested, $storyline, $notesrequestcode, $types, $currentusercode, $currentuser, $instcode);
                $title = 'Patient Treatment Notes';
                if ($add == '0') {
                    $status = "error";
                    $msg = " $title add Unsuccessful";
                } elseif ($add == '1') {
                    $status = "error";
                    $msg = "".$title." Exist";
                } elseif ($add == '2') {
                    $event= " $title added successfully ";
                    $eventcode= "137";
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = " $title for $patient Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail Failed!";
                    }
                } else {
                    $status = "error";
                    $msg = "Unknown source ";
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
					$storyline = strtoupper($storyline);

				$remove = $physiosql->update_editpatientprocedure($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Patient Treatment';
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
					$storyline = strtoupper($storyline);

				$remove = $physiosql->update_removepatientprocedure($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode);
				$title = 'Remove Patient Treatment';
				if($remove == '0'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "".$title." ".$comname." Exist"; 					
				}else if($remove == '2'){
					$event= "".$title." successfully ";
					$eventcode= "135";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "".$title." for  Successfully";	
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
	
}
 

?>
