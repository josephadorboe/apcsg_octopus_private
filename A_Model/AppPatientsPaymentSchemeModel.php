<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$patientpaymentschememodel = isset($_POST['patientpaymentschememodel']) ? $_POST['patientpaymentschememodel'] : '';
	
	// 12 AUG 2023 JOSEPH ADORBOE 
switch ($patientpaymentschememodel)
{
	// 1 SEPT 2023, 23 JUN 2021 JOSEPH ADORBOE  
	case 'disablescheme': 
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$sqlresults = $patientschemetable->disablepaymentscheme($ekey,$currentusercode,$currentuser,$instcode);
				$action = 'Patient Payment Scheme Disable';							
				$result = $engine->getresults($sqlresults,$item=$scheme,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=163;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;
	// 1 SEPT 2023, 23 JUNE 2021 JOSEPH ADORBOE 
	case 'addpaymentscheme': 
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$cardnumber = htmlspecialchars(isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '');
		$expirydate = htmlspecialchars(isset($_POST['expirydate']) ? $_POST['expirydate'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{

			if(empty($patientcode) || empty($expirydate) || empty($cardnumber) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
                $ps = explode('@@@', $scheme);
                $paymentschemecode = $ps[0];
                $paymentscheme = $ps[1];
                $paymentmethodcode = $ps[2];
                $paymethname = $ps[3];
				$plan = $ps[4];
				$expirydate = date('Y-m-d', strtotime($expirydate));
                $sqlresults = $patientschemetable->insert_patientscheme($form_key, $patientcode,$patientnumber,$patient,$day,$paymentschemecode, $paymentscheme,$paymentmethodcode,$paymethname,$cardnumber,$expirydate,$plan,$currentusercode,$currentuser,$instcode);				
				$action = 'Patient Payment Scheme';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=164;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
                
            }
				}
		}
	break;
	// 12 AUG 2023, 17 JAN 2021
	case 'records_patientpaymentschemesearch': 
		$patientpaymentscheme = htmlspecialchars(isset($_POST['patientpaymentscheme']) ? $_POST['patientpaymentscheme'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
			if(empty($patientpaymentscheme) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{				
					$value = $patientpaymentscheme;
					$msql->passingvalues($pkey=$form_key,$value);
					$url = "patientpaymentscheme?$form_key";
					$engine->redirect($url);				
				}
			}
		}
	break;
	// 12 AUG 2023, 17 JAN 2020 
	case 'records_updatepatientpaymentscheme': 
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$patientcardno = htmlspecialchars(isset($_POST['patientcardno']) ? $_POST['patientcardno'] : '');
		$expirydate = htmlspecialchars(isset($_POST['expirydate']) ? $_POST['expirydate'] : '');		
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){
				$status = "error";
				$msg = "Shift is closed";				
			}else{
			if(empty($ekey) || empty($paymentscheme) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ps = explode('@@@', $paymentscheme);
				$paymentschemecode = $ps[0];
				$paymentscheme = $ps[1];
				$paymentmethodcode = $ps[2];
				$paymethname = $ps[3];
				$paymentplan = $ps[4];
				if($paymentscheme == $cashschemecode){
					$status = "error";
					$msg = "Cash scheme cannot be added to the patient scheme  ";
				}else{				
				if(empty($expirydate)){
					$expirydate = $day ;
				}
				$sqlresults = $patientspaymentschemecontroller->insertupdate_patientpaymentscheme($form_key,$ekey,$patientnumber,$patient,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$patientcardno,$expirydate,$currentusercode,$currentuser,$instcode,$day,$paymentplan);
				$action = 'Patient Payment Scheme';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=75;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}
			}				

			}
		}
	break;
	
}

?>
