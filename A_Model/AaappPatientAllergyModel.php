<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$allergymodel = isset($_POST['allergymodel']) ? $_POST['allergymodel'] : '';
	
	// 4 JUNE 2024 JOSEPH ADORBOE
	switch ($allergymodel)
	{	
		
		// 17 JUNE 2024, JOSEPH ADORBOE 
		case 'editpatientallergy':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$allergy = htmlspecialchars(isset($_POST['allergy']) ? $_POST['allergy'] : '');				
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($allergy) || empty($ekey) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$sqlresults = $patientsallergytable->editpatientallergy($ekey,$allergy,$currentusercode,$currentuser,$instcode);				
						$action = "Edit Patient Allergy";
						$result = $engine->getresults($sqlresults,$item=$allergy,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9815;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;

		// 17 JUNE 2024, JOSEPH ADORBOE 
		case 'addpatientallergy':
			$patientnumber = htmlspecialchars( isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$firstallergy = htmlspecialchars(isset($_POST['firstallergy']) ? $_POST['firstallergy'] : '');
			$secondallergy = htmlspecialchars(isset($_POST['secondallergy']) ? $_POST['secondallergy'] : '');
			$thirdallergy = htmlspecialchars(isset($_POST['thirdallergy']) ? $_POST['thirdallergy'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($patientnumber) || empty($firstallergy) ){
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
						$patientbirthdate = $pt[2];
						$gender = $pt[3];	
						$allergycode = rand(1,10000);	
						$age = $pat->getpatientbirthage($patientbirthdate);							
						$sqlresults = $patientsallergytable->insert_newpatientallergy($form_key,$days,$consultationcode='',$visitcode='',$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy=$firstallergy,$storyline=$firstallergy,$currentusercode,$currentuser,$instcode);
						if(!empty($secondallergy)){
							$allergycode = rand(1,10000);
							$formkey = md5(microtime());
							$sqlresults = $patientsallergytable->insert_newpatientallergy($formkey,$days,$consultationcode='',$visitcode='',$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy=$secondallergy,$storyline=$secondallergy,$currentusercode,$currentuser,$instcode);
						}
						if(!empty($thirdallergy)){
							$allergycode = rand(1,10000);
							$formkey = md5(microtime());
							$sqlresults = $patientsallergytable->insert_newpatientallergy($formkey,$days,$consultationcode='',$visitcode='',$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy=$thirdallergy,$storyline=$thirdallergy,$currentusercode,$currentuser,$instcode);
						}
						
						$action = 'Patient Allergy Added';							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9816;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                         
					}
				}
			
			}
		break;
	}
?>
