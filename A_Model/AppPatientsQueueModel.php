<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$queuemodel = htmlspecialchars(isset($_POST['queuemodel']) ? $_POST['queuemodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 18 FEB 2021  
	switch ($queuemodel)
	{

		// 1 JUNE 2024, JOSEPH ADORBOE 
		case 'saveaddpatientvitals':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$patientvitalstatus = htmlspecialchars(isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '');
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
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{									
					$sqlresults = $patientvitalstable->insert_newpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear);											
					$action = "Vitals Added";
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9828;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}			
		break;	

		// 1 JUNE 2024, JOSEPH ADORBOE 
		case 'saveeditpatientvitalsonly':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$patientvitalstatus = htmlspecialchars(isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '');
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
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{										
					$sqlresults = $patientvitalstable->updatepatientvitals($bp,$temperature,$height,$weight,$fbs,$rbs,$glucosetest,$remarks,$currentuser,$currentusercode,$pulse,$spo,$vitalscode,$instcode);											
					$action = "Vitals editted";
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9828;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
				}
			}			
		break;	

		// 1 JUNE 2024, JOSEPH ADORBOE 
		case 'saveeditpatientvitals':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$patientvitalstatus = htmlspecialchars(isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '');
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
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
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
                        $rbsserviceamount = $pricingtable->getprice($paymentmethodcode, $patientschemecode, $servicerbscode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$servicerequestcode = md5(microtime());
						$servicebillcode = md5(microtime());
                    } else {
                        $servicerbscode =$servicerbs =$rbsserviceamount = $servicerequestcode = $servicebillcode = '';
					}
						if(empty($paymenttype) || $paymenttype ==''){
							$paymenttype = 1;
						}
			
						if(empty($physician) ){
							$status = "error";
							$msg = "Required Fields cannot be empty ";
						}else{
						$sp = explode('@@@', $physician);
						$specscode = $sp['0'];
						$specsname = $sp['1'];		
						$sqlresults = $patientvitalstable->updatepatientvitals($bp,$temperature,$height,$weight,$fbs,$rbs,$glucosetest,$remarks,$currentuser,$currentusercode,$pulse,$spo,$vitalscode,$instcode);
						if($sqlresults == '2'){							
							$doct = $patientsServiceRequesttable->updatepatientservicerequestdoctors($ekey,$specscode,$specsname,$serialnumber,$currentusercode,$currentuser,$instcode);
							$cons = $patientconsultationstable->updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode);
							$cons = $patientconsultationsarchivetable->updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode);							
						}
						
						$action = "Vitals editted";
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

		// 25 MAY 2024, JOSEPH ADORBOE 
		case 'reversecannelledservices':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$reversalreason = htmlspecialchars(isset($_POST['reversalreason']) ? $_POST['reversalreason'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($reversalreason)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{				
						$sqlresults = $patientsServiceRequesttable->returnservicerequestreversal($ekey,$reversalreason,$currentusercode,$currentuser,$instcode);
						if($sqlresults == '2'){
							$patientvisittable->reversecancelvisit($visitcode,$instcode);
						}
						$action = "Patient Service Cancelled Reversed";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9824;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
						}
					}							
			}			
		break;
		
		
		// 20 sept 2023, 20 NOV 2022 JOSEPH ADORBOE 
		case 'addtoqueueservice':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$addreason = htmlspecialchars(isset($_POST['addreason']) ? $_POST['addreason'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($addreason)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{				
						$sqlresults = $patientsServiceRequesttable->addtoqueuetodayservicerequest($ekey,$addreason,$currentusercode,$currentuser,$instcode);
						$action = "Patient Service added";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9829;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
					}
				}							
			}				
		break;
		// 20 sept 2023, 20 NOV 2022 JOSEPH ADORBOE 
		case 'returnservice':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($returnreason)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{				
					$sqlresults = $patientsServiceRequesttable->returnservicerequest($ekey,$returnreason,$currentusercode,$currentuser,$instcode);
					if($sqlresults == '2'){
						$patientconsultationstable->deleteconsultationrequestcode($ekey,$instcode);
						$patientconsultationsarchivetable->cancelarchiveconsultationrequestcode($ekey,$cancelreason=$returnreason,$instcode);						
					}
					$action = "Patient Service Cancelled";
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9824;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}							
			}			
		break;
		// 24 APR 2024,  02 JUNE 2022  JOSEPH ADORBOE 
		case 'editvitals':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$bp = htmlspecialchars(isset($_POST['bp']) ? $_POST['bp'] : '');
			$pulse = htmlspecialchars(isset($_POST['pulse']) ? $_POST['pulse'] : '');
			$temperature = htmlspecialchars(isset($_POST['temperature']) ? $_POST['temperature'] : '');
			$height = htmlspecialchars(isset($_POST['height']) ? $_POST['height'] : '');
			$weight = htmlspecialchars(isset($_POST['weight']) ? $_POST['weight'] : '');
			$spo = htmlspecialchars(isset($_POST['spo']) ? $_POST['spo'] : '');
			$rbs = htmlspecialchars(isset($_POST['rbs']) ? $_POST['rbs'] : '');
			$glucosetest = htmlspecialchars(isset($_POST['glucosetest']) ? $_POST['glucosetest'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');			
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($bp) || empty($temperature) || empty($ekey) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$fbs = 1;
						$sqlresults = $patientvitalstable->update_vitals($ekey,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$currentusercode,$currentuser,$spo);				
						$action = "Edit Patient vitals";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9827;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 30 MAR 2022  JOSEPH ADORBOE 
		case 'savepatientwounddressing':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '') ;
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '') ;
			$patientschemecode = htmlspecialchars(isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '') ;
			$patientscheme = htmlspecialchars(isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' );
			$patientservicecode = htmlspecialchars(isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '' );
			$patientservice = htmlspecialchars(isset($_POST['patientservice']) ? $_POST['patientservice']: '') ;
			$paymenttype = htmlspecialchars(isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' );
			$servicerequestcode = htmlspecialchars(isset($_POST['servicerequestcode']) ? $_POST['servicerequestcode']: '' );
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
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
									$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
								}
							}
					
							$wounddressingnumber = $coder->getwounddressingnumber($instcode);						
							$sqlresults  = $patientswounddressingtable->insert_patientwounddressingservice($form_key,$ekey,$wounddressingnumber,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$patientservicecode,$patientservice,$servicerequestcode,$remarks,$currentday,$currentmonth,$currentyear);
							//$patientswounddressingtable->insert_patientwounddressing($form_key,$days,$requestcode,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$woundservicecode,$woundservicename,$storyline,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
							//$patientsqueuecontroller->insert_patientwounddressing($form_key,$ekey,$wounddressingnumber,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$patientservicecode,$patientservice,$servicerequestcode,$remarks,$currentday,$currentmonth,$currentyear);	
							$action = "Save patient wound dressing ";
							$result = $engine->getresults($sqlresults,$item='',$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=9825;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
						
						}					
				}
			}			
		break;

		// 1 oct 2023, 25 JULY 2021 JOSEPH ADORBOE 
		case 'saverbs':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod']: '' );
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode']: '') ;
			$patientschemecode = htmlspecialchars(isset($_POST['patientschemecode']) ? $_POST['patientschemecode']: '' );
			$patientscheme = htmlspecialchars(isset($_POST['patientscheme']) ? $_POST['patientscheme']: '' );
			$patientservicecode = htmlspecialchars(isset($_POST['patientservicecode']) ? $_POST['patientservicecode']: '') ;
			$patientservice = htmlspecialchars(isset($_POST['patientservice']) ? $_POST['patientservice']: '' );
			$paymenttype = htmlspecialchars(isset($_POST['paymenttype']) ? $_POST['paymenttype']: '' );
			$chargerbs = htmlspecialchars(isset($_POST['chargerbs']) ? $_POST['chargerbs']: '') ;
			$rbs = htmlspecialchars(isset($_POST['rbs']) ? $_POST['rbs']: '' );
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age']: '' );
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender']: '' );
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
						
                        $rbsserviceamount = $pricingtable->getprice($paymentmethodcode, $patientschemecode, $servicerbscode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$servicerequestcode = md5(microtime());
						$servicebillcode = md5(microtime());
                    } else {
                        $servicerbscode =$servicerbs =$rbsserviceamount = $servicerequestcode = $servicebillcode = '';
					}  

					$sqlresults = $patientsqueuecontroller->insert_patientrbstest($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$rbs,$paymenttype,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$patientsServiceRequesttable,$patientbillitemtable,$patientvitalstable);
					$action = "Patient Vitals RBS";
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9826;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);           					
				}
			}			
		break;

		// 24 APR 2024, 18 FEB 2021 JOSEPH ADORBOE 
		case 'savepatientqueue':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$patientvitalstatus = htmlspecialchars(isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '');
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
					if(empty($physician)   ){
						$status = "error";
						$msg = "Required Field cannot be empty";	
					}else{
					if($chargerbs == 'YES'){
						$servicerbscode = 'SER0030';
                        $servicerbs = 'RANDOM BLOOD SUGAR';
						$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                        $rbsserviceamount = $pricingtable->getprice($paymentmethodcode, $patientschemecode, $servicerbscode, $instcode, $cashschemecode,$ptype,$instcodenuc);
						$servicerequestcode = md5(microtime());
						$servicebillcode = md5(microtime());
                    } else {
                        $servicerbscode =$servicerbs =$rbsserviceamount = $servicerequestcode = $servicebillcode = '';
					}
					// if(!empty($_POST["newallergy"])){						
                    //     foreach ($_POST["newallergy"] as $key) {
					// 		$kt = explode('@@@', $key);
                    //         $allergycode = $kt['0'];
                    //         $allergyname = $kt['1'];
					// 		$form_key = md5(microtime());
					// 		$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode);			
                    //     }
					// }

					if(!(empty($allergyone))){                       
						$allergycode = rand(100,1000);
						$form_key = md5(microtime());
						$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyone,$days,$currentusercode,$currentuser,$instcode);	                      
					}

					if(!(empty($allergytwo))){                       
						$allergycode = rand(100,1000);
						$form_key = md5(microtime());
						$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergytwo,$days,$currentusercode,$currentuser,$instcode);	                      
					}

					if(!(empty($allergythree))){                       
						$allergycode = rand(100,1000);
						$form_key = md5(microtime());
						$insertcheck = $patientsallergytable->insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergythree,$days,$currentusercode,$currentuser,$instcode);	                      
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
						//		$serialnumber = $patientsqueuecontroller->getconsultationserialnumber($form_key,$specscode,$specsname,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode); 
						//		$serialnumber = $serialnumber + 1;
						//	}
							$sqlresults = $patientsqueuecontroller->insert_patientvitals($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$fbs,$rbs,$glucosetest,$paymenttype,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$consultationnumber,$spo,$currentday,$currentmonth,$currentyear,$plan,$patientvitalstable,$patientsServiceRequesttable,$patientconsultationstable,$patientconsultationsarchivetable,$patientbillitemtable,$currenttable,$serialtable);	
							$action = "Patient Vitals added";
							$result = $engine->getresults($sqlresults,$item=$patient,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=9828;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							if($sqlresults == '2'){
								$claimsnumber = $coder->getclaimsnumber($instcode);
								$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);
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
							$sqlresults = $patientsqueuecontroller->update_reassignpatient($form_key,$ekey,$vitalscode,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$specscode,$specsname,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$spo,$plan,$currentday,$currentmonth,$currentyear,$patientsServiceRequesttable,$patientconsultationstable,$patientconsultationsarchivetable,$patientbillitemtable,$patientvitalstable);	
							$action = "Patient Assigned";
							$result = $engine->getresults($sqlresults,$item=$patient,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=9828;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							if($sqlresults == '2'){
								$claimsnumber = $coder->getclaimsnumber($instcode);
								$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);
							}							
						}
					}
				}
			}
			}			
		break;		
	}

			function patientcancelledmenu(){ ?>			
				<div class="btn-group mt-2 mb-2">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						Sub Menu <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="managecancelledconsultation">Cancelled Consultation </a></li>
						<li><a href="managecancelledservices">Cancelled Services </a></li>									
					</ul>
				</div>
			
		<?php 
		}
	
		function patientqueuemenu(){ ?>			
				<div class="btn-group mt-2 mb-2">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						Sub Menu <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="nursepatientqueueconsultation">Consultation Queue</a></li>
						<li><a href="nursepatientqueuepasted">Past Queue</a></li>
						<li><a href="nursepatientvitals">Patient Vitals</a></li>
						<li><a href="nursepatientqueue">Patient Queue</a></li>					
					</ul>
				</div>
			
		<?php 
		}

		function patientqueuedetailsmenu($patientcode,$requestcode){ ?>		
				<div class="btn-group mt-2 mb-2">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						Sub Menu <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#" data-toggle="modal" data-target="#largeModaltakevitals">Take Vitals</a></li>
						<li><a href="#" data-toggle="modal" data-target="#largeModalcancel">Cancel Service </a></li>
						<li><a href="#" data-toggle="modal" data-target="#largeModalfollowup">Request Followup </a></li>
						<li><a href="#" data-toggle="modal" data-target="#largeModaladdnotes">Add Nurse Notes </a></li>
						<li><a href="#" data-toggle="modal" data-target="#largeModaleditpatientbio">Edit Patient Bio</a></li>
						<li><a href="patientqueuenursesnotes?<?php echo $patientcode ?>?<?php echo $requestcode ; ?>">Nurses Notes</a></li>	
						<li><a href="patientfollowupsdetails?<?php echo $patientcode ?>?<?php echo $requestcode ; ?>">Follow Ups</a></li>
						<li><a href="vitalhistorydetails?<?php echo $patientcode ?>?<?php echo $requestcode ; ?>">Vitals</a></li>					
					</ul>
				</div>
			
		<?php 
		}
?>
