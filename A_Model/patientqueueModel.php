<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$queuemodel = isset($_POST['queuemodel']) ? $_POST['queuemodel'] : '';
	$dept = 'OPD';

	Global $instcode;
	
	// 18 FEB 2021 
	switch ($queuemodel)
	{

		

		// 02 JUNE 2022  JOSEPH ADORBOE 
		case 'editvitals':			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$bp = isset($_POST['bp']) ? $_POST['bp'] : '';
			$pulse = isset($_POST['pulse']) ? $_POST['pulse'] : '';
			$temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';
			$height = isset($_POST['height']) ? $_POST['height'] : '';
			$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
			$spo = isset($_POST['spo']) ? $_POST['spo'] : '';
			$rbs = isset($_POST['rbs']) ? $_POST['rbs'] : '';
			$glucosetest = isset($_POST['glucosetest']) ? $_POST['glucosetest'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
						if(empty($bp) || empty($temperature) || empty($height) || empty($weight)){
							$status = "error";
							$msg = "Required Fields cannot be empty ";
						}else{
							$fbs = 1;
						$updateassign = $patientsqueue->update_vitals($ekey,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$currentusercode,$currentuser,$spo);				
						if($updateassign == '0'){				
							$status = "error";					
							$msg = "Edit Vitals Unsuccessful"; 
						}else if($updateassign == '1'){			
							$status = "error";					
							$msg = "Edit Vitals already Exist"; 			
						}else if($updateassign == '2'){				
							$status = "success";
							$msg = "Vital Edit Successfully  ";	
							$event= "ASSIGN PATIENT CODE: $ekey has been saved successfully ";
							$eventcode= 53;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);													
						}else{				
							$status = "error";					
							$msg = "Assign Patient Unsuccessful "; 				
						}
					}
				}
				
			}			
		break;


		// 30 MAR 2022  JOSEPH ADORBOE 
		case 'savepatientwounddressing':			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '' ;
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '' ;
			$patientschemecode = isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '' ;
			$patientscheme = isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' ;
			$patientservicecode = isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '' ;
			$patientservice = isset($_POST['patientservice']) ? $_POST['patientservice']: '' ;
			$paymenttype = isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' ;
			$servicerequestcode = isset($_POST['servicerequestcode']) ? $_POST['servicerequestcode']: '' ;
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{
						if(empty($remarks) ){
							$status = "error";
							$msg = "Required Fields cannot be empty ";			
						}else{	
							
							if(!empty($_POST["newallergy"])){						
								foreach ($_POST["newallergy"] as $key) {
									$kt = explode('@@@', $key);
									$allergycode = $kt['0'];
									$allergyname = $kt['1'];
									$form_key = md5(microtime());
									$insertcheck = $patientsqueue->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
								}
							}
					
							$wounddressingnumber = $coder->getwounddressingnumber($instcode);						
							$insertcheck = $patientsqueue->insert_patientwounddressing($form_key,$ekey,$wounddressingnumber,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$patientservicecode,$patientservice,$servicerequestcode,$remarks,$currentday,$currentmonth,$currentyear);	
			
							if($insertcheck == '0'){				
								$status = "error";					
								$msg = "Adding Patient $patient $patientservice Unsuccessful"; 
							}else if($insertcheck == '1'){			
								$status = "error";					
								$msg = "Patient $patient $patientservice already Exist"; 			
							}else if($insertcheck == '2'){				
								$status = "success";
								$msg = "Patient $patient $patientservice added Successfully";
								$event= "ADD PATIENT WOUND DRESSING CODE:".$form_key." ".$patientcode.", ".$patient. " has been saved successfully ";
								$eventcode= 190;
								$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);												
							}else{				
								$status = "error";					
								$msg = "Add New Users Unsuccessful "; 				
							}
						}
					
				}
			}			
		break;


		// 25 JULY 2021 JOSEPH ADORBOE 
		case 'saverbs':			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '' ;
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '' ;
			$patientschemecode = isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '' ;
			$patientscheme = isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' ;
			$patientservicecode = isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '' ;
			$patientservice = isset($_POST['patientservice']) ? $_POST['patientservice']: '' ;
			$paymenttype = isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' ;
			$chargerbs = isset($_POST['chargerbs']) ? $_POST['chargerbs']: '' ;
			$rbs = isset($_POST['rbs']) ? $_POST['rbs']: '' ;
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{
					if($chargerbs == 'YES'){
						$servicerbscode = 'SER0030';
                        $servicerbs = 'RANDOM BLOOD SUGAR';
						$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
					//	$serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode,$ptype,$instcodenuc, $instcode, $cashschemecode, $cashpaymentmethodcode);
						
                        $rbsserviceamount = $pricing->getprice($paymentmethodcode, $paymentschemecode, $servicerbscode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$servicerequestcode = md5(microtime());
						$servicebillcode = md5(microtime());
                    } else {
                        $servicerbscode =$servicerbs =$rbsserviceamount = $servicerequestcode = $servicebillcode = '';
					}  

					$insertcheck = $patientsqueue->insert_patientrbstest($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$rbs,$paymenttype,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear);
	
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
		break;



		// 18 FEB 2021 JOSEPH ADORBOE 
		case 'savepatientqueue':			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$patientvitalstatus = isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$bp = isset($_POST['bp']) ? $_POST['bp'] : '';
			$temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';
			$height = isset($_POST['height']) ? $_POST['height'] : '';
			$spo = isset($_POST['spo']) ? $_POST['spo'] : '';
			$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$physician = isset($_POST['physician']) ? $_POST['physician'] : '';
			$serial = isset($_POST['serial']) ? $_POST['serial'] : '';
			$serialnumber = isset($_POST['serialnumber']) ? $_POST['serialnumber']: '' ;
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '' ;
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '' ;
			$patientschemecode = isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '' ;
			$patientscheme = isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' ;
			$patientservicecode = isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '' ;
			$patientservice = isset($_POST['patientservice']) ? $_POST['patientservice']: '' ;
			$fbs = isset($_POST['fbs']) ? $_POST['fbs']: '' ;
			$rbs = isset($_POST['rbs']) ? $_POST['rbs']: '' ;
			$glucosetest = isset($_POST['glucosetest']) ? $_POST['glucosetest']: '' ;
			$vitalscode = isset($_POST['vitalscode']) ? $_POST['vitalscode']: '' ;
			$pulse = isset($_POST['pulse']) ? $_POST['pulse']: '' ;
			$paymenttype = isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' ;
			$chargerbs = isset($_POST['chargerbs']) ? $_POST['chargerbs']: '' ;
			$billingcode = isset($_POST['billingcode']) ? $_POST['billingcode']: '' ;
			$plan = isset($_POST['plan']) ? $_POST['plan']: '' ; 
		// 	
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{
					if($chargerbs == 'YES'){
						$servicerbscode = 'SER0030';
                        $servicerbs = 'RANDOM BLOOD SUGAR';
						$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                        $rbsserviceamount = $pricing->getprice($paymentmethodcode, $patientschemecode, $servicerbscode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$servicerequestcode = md5(microtime());
						$servicebillcode = md5(microtime());
                    } else {
                        $servicerbscode =$servicerbs =$rbsserviceamount = $servicerequestcode = $servicebillcode = '';
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

					if(empty($paymenttype) || $paymenttype ==''){
						$paymenttype = 1;
					}
			
					if($patientvitalstatus == '0'){
						if(empty($physician) ){
							$status = "error";
							$msg = "Required Fields cannot be empty ";			
						}else{

							$sp = explode('@@@', $physician);
							$specscode = $sp['0'];
							$specsname = $sp['1'];
							$serialnumber = 1;
							$consultationnumber = $lov->getconsultationrequestcode($instcode);
						//	if(empty($serialnumber)){
						//		$serialnumber = $patientsqueue->getconsultationserialnumber($form_key,$specscode,$specsname,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode); 
						//		$serialnumber = $serialnumber + 1;
						//	}
							$insertcheck = $patientsqueue->insert_patientvitals($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$fbs,$rbs,$glucosetest,$paymenttype,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$consultationnumber,$spo,$currentday,$currentmonth,$currentyear,$plan);	
			
							if($insertcheck == '0'){				
								$status = "error";					
								$msg = "Adding Patient ".$patient. " Vitals Unsuccessful"; 
							}else if($insertcheck == '1'){			
								$status = "error";					
								$msg = "Patient Vitals for ".$patient. " already Exist"; 			
							}else if($insertcheck == '2'){				
								$status = "success";
								$msg = "Patient $patient Vitals added Successfully";
								$claimsnumber = $coder->getclaimsnumber($instcode);
								$msql->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode);
								$event= "ADD PATIENT VITALS CODE:".$form_key." ".$patientcode.", ".$patient. " has been saved successfully ";
								$eventcode= 52;
								$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
																			
							}else{				
								$status = "error";					
								$msg = "Add New Users Unsuccessful "; 				
							}
						}
					}else if($patientvitalstatus == '1'){
							if(empty($physician) ){
								$status = "error";
								$msg = "Required Fields cannot be empty ";
							}else{

							$sp = explode('@@@', $physician);
							$specscode = $sp['0'];
							$specsname = $sp['1'];							
							$updateassign = $patientsqueue->update_reassignpatient($form_key,$ekey,$vitalscode,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$specscode,$specsname,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$spo,$currentday,$currentmonth,$currentyear);				
							if($updateassign == '0'){				
								$status = "error";					
								$msg = "Assign Patient ".$patient." Unsuccessful"; 
							}else if($updateassign == '1'){			
								$status = "error";					
								$msg = "Assign Patient for ".$patient." already Exist"; 			
							}else if($updateassign == '2'){				
								$status = "success";
								$msg = "Assign Patient ".$patient." Successfully to ".$specsname." ";	
								$claimsnumber = $coder->getclaimsnumber($instcode);
								$msql->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode);
								$event= "ASSIGN PATIENT CODE:".$ekey." ".$patientcode.", ".$patient. " has been saved successfully ";
								$eventcode= 53;
								$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);													
							}else{				
								$status = "error";					
								$msg = "Assign Patient Unsuccessful "; 				
							}
						}
					}
				}
			}			
		break;


		
	}

	
?>
