<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$glucosemonitormodel = isset($_POST['glucosemonitormodel']) ? $_POST['glucosemonitormodel'] : '';
	
	// 17 JUNE 2024 JOSEPH ADORBOE
	switch ($glucosemonitormodel)
	{	
		
		// 17 JUNE 2024, JOSEPH ADORBOE 
		case 'editpatientglucosemonitor':			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$gludate = htmlspecialchars(isset($_POST['gludate']) ? $_POST['gludate'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$gvalue = htmlspecialchars(isset($_POST['gvalue']) ? $_POST['gvalue'] : '');
			$remark = htmlspecialchars(isset($_POST['remark']) ? $_POST['remark'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($gvalue) || empty($ekey) || empty($type) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$sqlresults = $patientsglucosemonitortable->update_patientglucosemonitor($ekey,$type,$gludate,$gvalue,$remark,$currentusercode,$currentuser,$instcode);				
						$action = "Edit Patient Glucode Monitor";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9813;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 17 JUNE 2024, JOSEPH ADORBOE 
		case 'addpatientglucosemonitor':
			$patientnumber = htmlspecialchars( isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$gludate = htmlspecialchars(isset($_POST['gludate']) ? $_POST['gludate'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$gvalue = htmlspecialchars(isset($_POST['gvalue']) ? $_POST['gvalue'] : '');
			$remark = htmlspecialchars(isset($_POST['remark']) ? $_POST['remark'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($patientnumber) || empty($gludate) || empty($type)  || empty($gvalue)  ){
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
						$gnumber = rand(1,10000);	
						$age = $pat->getpatientbirthage($patientbirthdate);							
						$sqlresults = $patientsglucosemonitortable->insert_patientglucosemonitor($form_key,$patientcode,$patientnumber,$patient,$gnumber,$type,$gludate,$age,$gender,$gvalue,$remark,$currentusercode,$currentuser,$instcode);
											
						$action = 'Patient Glucode Monitor Added';							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9814;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                         
					}
				}			
			}
		break;
	}
?>
