<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$wardmodel = htmlspecialchars(isset($_POST['wardmodel']) ? $_POST['wardmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 6 AUG 2023 JOSEPH ADORBOE 
	switch ($wardmodel)
	{
		
		// 12 JAN 2022  JOSEPH ADORBOE  
		case 'editwards':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$wardname = htmlspecialchars(isset($_POST['wardname']) ? $_POST['wardname'] : '');
			$wardgender = htmlspecialchars(isset($_POST['wardgender']) ? $_POST['wardgender'] : '');
			$warerate = htmlspecialchars(isset($_POST['warerate']) ? $_POST['warerate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($wardname) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{											
					$sqlresults = $wardsql->editwards($ekey,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);					
					$action = 'Ward Edit';							
					$result = $engine->getresults($sqlresults,$item=$wardname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=100;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}

		break;	
		// 8 AUG 2023 , 12 JAN 2022 JOSPH ADORBOE 
		case 'addwards':			
			$wardname = htmlspecialchars(isset($_POST['wardname']) ? $_POST['wardname'] : '');
			$wardgender = htmlspecialchars(isset($_POST['wardgender']) ? $_POST['wardgender'] : '');
			$warerate = htmlspecialchars(isset($_POST['warerate']) ? $_POST['warerate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($wardname) || empty($wardgender) || empty($warerate)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$wardname = strtoupper($wardname);			
					$sqlresults = $wardsql->addwards($form_key,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);
					$title = 'Add Ward';
					$action = 'Ward Bed Added';							
					$result = $engine->getresults($sqlresults,$item=$wardname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=100;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}

		break;
		
	}	

?>
