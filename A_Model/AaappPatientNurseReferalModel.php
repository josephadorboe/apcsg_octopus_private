<?php
	REQUIRE_ONCE (INTFILE);	
	$patientnursereferalmodel = isset($_POST['patientnursereferalmodel']) ? $_POST['patientnursereferalmodel'] : '';

	switch ($patientnursereferalmodel) 
	{
	
		// 2 OCT 2024 JOSEPH ADORBOE 
		case 'patientnursereferalcancel':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');			
			$cancelreasonreferal = htmlspecialchars(isset($_POST['cancelreasonreferal']) ? $_POST['cancelreasonreferal'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($cancelreasonreferal) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{							
					$canceldetails = $cancelreasonreferal .' @@ '. date('d M Y H:i:s a') .' @@ '. $currentuser;
					$sqlresults = $patientreferaltable->update_cancelpatientreferal($ekey,$canceldetails,$instcode);
					$action = 'Cancel Patient Referal';
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9753;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
				}
			}
		break;	
		// 2 OCT 2024 JOSEPH ADORBOE 
		case 'patientnursereferaledit':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$history = htmlspecialchars(isset($_POST['history']) ? $_POST['history'] : '');
			$finding = htmlspecialchars(isset($_POST['finding']) ? $_POST['finding'] : '');
			$provisionaldiagnosis = htmlspecialchars(isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '');
			$treatementgiven = htmlspecialchars(isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '');
			$reasonreferal = htmlspecialchars(isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($history) || empty($provisionaldiagnosis)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{							
					$sqlresults = $patientreferaltable->update_patientreferal($ekey,$days,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$currentusercode,$currentuser,$instcode);
					$action = 'Edit Patient Referal';
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9754;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
				}
			}
		break;	
		// 2 OCT 2024 , JOSEPH ADORBOE 
		case 'patientnursereferaladdexternal':
			$patientdet = htmlspecialchars(isset($_POST['patientdet']) ? $_POST['patientdet'] : '');
			$reviewdate = htmlspecialchars(isset($_POST['reviewdate']) ? $_POST['reviewdate'] : '');
			$history = htmlspecialchars(isset($_POST['history']) ? $_POST['history'] : '');
			$finding = htmlspecialchars(isset($_POST['finding']) ? $_POST['finding'] : '');
			$provisionaldiagnosis = htmlspecialchars(isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '');
			$treatementgiven = htmlspecialchars(isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '');
			$reasonreferal = htmlspecialchars(isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '');
			$vitalscode = htmlspecialchars(isset($_POST['vitalscode']) ? $_POST['vitalscode'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($patientdet) || empty($reviewdate) || empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) ){				
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$pd = explode('@@@', $patientdet);
					$patientcode = $pd[0];
					$patientnumber = $pd[1];
					$patient = $pd[2];
					$dob = $pd[3];
					$gender = $pd[4];
					$age = $pat->getpatientbirthage($dob);
						
						// $cdate = explode('-', $reviewdate);
						// $mmd = $cdate[1];
						// $ddd = $cdate[2];
						// $yyy = $cdate[0];
						// if (empty($mmd) || empty($ddd) || empty($yyy)) {
						// 	$status = 'error';
						// 	$msg = 'Invalid date format';
						// } else {
							// $reviewdate = $yyy.'-'.$mmd.'-'.$ddd;
							if($reviewdate<$day){
								$status = 'error';
								$msg = "$reviewdate is passed";
							}else{
								$intro = "I will be most grateful if you would see this patient for further evaluation and management.";
								$referalnumber = rand(10,99).date("is");	
								$consultationcode= $visitcode = 1;
								$sqlresults = $patientreferaltable->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);
								$action = 'New Referal Added';							
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=9755;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                            
						//	}
						//}
					}
				}
			}
		break;

	} 
?>
