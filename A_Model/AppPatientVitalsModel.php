<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$patientvitalsmodel = htmlspecialchars(isset($_POST['patientvitalsmodel']) ? $_POST['patientvitalsmodel'] : '');
	$dept = 'IPD';

	Global $instcode; 
	
	// 11 JAN 2022 JOSEPH ADORBOE assignbeds 
	switch ($patientvitalsmodel)
	{


		// 9 AUG 2024, JOSEPH ADORBOE 
		case 'savevitalsonly':			
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
					$dept = 'OPD';								
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
		case 'saveeditadmissionpatientvitals':			
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
		case 'saveretakepatientvitals':			
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

		// 24 APR 2024,  02 JUNE 2022  JOSEPH ADORBOE 
		case 'editadmissionvitals':			
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

		// 29 JUNE 2024,  JOSEPH ADORBOE 
		case 'savepatientadmissionvitals':			
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

?>
