<?php
	REQUIRE_ONCE (INTFILE);	
	$patientreferalmodel = isset($_POST['patientreferalmodel']) ? $_POST['patientreferalmodel'] : '';

	switch ($patientreferalmodel)
	{
			// 7 NOV 2023
	case 'addpatientnewreferal':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$history = htmlspecialchars(isset($_POST['history']) ? $_POST['history'] : '');
		$finding = htmlspecialchars(isset($_POST['finding']) ? $_POST['finding'] : '');
		$provisionaldiagnosis = htmlspecialchars(isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '');
		$treatementgiven = htmlspecialchars(isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '');
		$reasonreferal = htmlspecialchars(isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '');
		$vitalscode = htmlspecialchars(isset($_POST['vitalscode']) ? $_POST['vitalscode'] : '');
		$idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) || empty($patientcode)){				
				$status = 'error';
				$msg = 'Referal Not saved successfully';				
			}else{	
				$intro = "I will be most grateful if you would see this patient for further evaluation and management.";
				$referalnumber = date("his");		
				$sqlresults = $referaltable->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
				$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);
				$action = 'New Referal Added';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=444;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
			}			
		}
		break;

		// 3 Oct 2023, 19 MAR 2023 JOSEPH ADORBOE 
		case 'editpatientreferal':
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
					$sqlresults = $referaltable->update_patientreferal($ekey,$days,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$currentusercode,$currentuser,$instcode);
					$action = 'Edit Patient Referal';
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=443;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
				}
			}
		break;	
		// 5 AUG 2023, 18 MAY 2023 
		case 'addexternalreferal':
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
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
				if(empty($patientnumber) || empty($reviewdate) || empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) ){				
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
					if($patientnumbercheck == '-1'){
						$status = 'error';
						$msg = 'Invalid Patient number';
					}else{
						$pt = explode('@@@', $patientnumbercheck);
						$patientcode = $pt[0];
						$patient = $pt[1];
						$ag = $pt[2];
						$gender = $pt[3];
						$age = $pat->getpatientbirthage($ag);
						
						$cdate = explode('-', $reviewdate);
						$mmd = $cdate[1];
						$ddd = $cdate[2];
						$yyy = $cdate[0];
						if (empty($mmd) || empty($ddd) || empty($yyy)) {
							$status = 'error';
							$msg = 'Invalid date format';
						} else {
							$reviewdate = $yyy.'-'.$mmd.'-'.$ddd;
							if($reviewdate<$day){
								$status = 'error';
								$msg = "$reviewdate is passed";
							}else{
								$intro = "I will be most grateful if you would see this patient for further evaluation and management.";
								$referalnumber = date("his");	
								$consultationcode= $visitcode = 1;
								$sqlresults = $referaltable->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);
								$action = 'New Referal Added';							
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=444;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                            
							}
						}
					}
				}
			}
		break;

		// 19 MAR 2023
	case 'addpatientreferal':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$history = htmlspecialchars(isset($_POST['history']) ? $_POST['history'] : '');
		$finding = htmlspecialchars(isset($_POST['finding']) ? $_POST['finding'] : '');
		$provisionaldiagnosis = htmlspecialchars(isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '');
		$treatementgiven = htmlspecialchars(isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '');
		$reasonreferal = htmlspecialchars(isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '');
		$vitalscode = htmlspecialchars(isset($_POST['vitalscode']) ? $_POST['vitalscode'] : '');
		$idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) || empty($vitalscode)){				
				$status = 'error';
				$msg = 'Referal Not saved successfully';				
			}else{	
				$intro = "I will be most grateful if you would see this patient for further evaluation and management.";
				$referalnumber = date("his");		
				$sqlresults = $referaltable->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
				$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);
				$action = 'New Referal Added';							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=444;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
			}			
		}
		break;

	} 
?>
