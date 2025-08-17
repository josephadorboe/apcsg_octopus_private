<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$wardbedmodel = htmlspecialchars(isset($_POST['wardbedmodel']) ? $_POST['wardbedmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 6 AUG 2023 JOSEPH ADORBOE 
	switch ($wardbedmodel)
	{
		// 06 AUG 2023, 13 JAN 2022  JOSEPH ADORBOE  
		case 'editwardsbed':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$bedname = htmlspecialchars(isset($_POST['bedname']) ? $_POST['bedname'] : '');
			$wards = htmlspecialchars(isset($_POST['wards']) ? $_POST['wards'] : '');
			$bedrate = htmlspecialchars(isset($_POST['bedrate']) ? $_POST['bedrate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($bedname) || empty($bedrate) || empty($wards) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		
					$pers = explode('@@@', $wards);
					$wardcode = $pers[0];
					$wardname = $pers[1];								
					$sqlresults = $wardbedsql->editwardsbed($ekey,$bedname,$wardcode,$wardname,$bedrate,$currentuser,$currentusercode,$instcode);
					$action = 'Ward Bed Edit';							
					$result = $engine->getresults($sqlresults,$item=$bedname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=101;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}
		break;		
		// 06 AUG 2023 , 12 JAN 2022 JOSPH ADORBOE 
		case 'addwardsbeds':			
			$bedname = htmlspecialchars(isset($_POST['bedname']) ? $_POST['bedname'] : '');
			$wards = htmlspecialchars(isset($_POST['wards']) ? $_POST['wards'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($bedname) || empty($wards)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$bedname = strtoupper($bedname);
					$pers = explode('@@@', $wards);
					$wardcode = $pers[0];
					$wardname = $pers[1];
					$wardrate = $pers[2];
					$wardgender = $pers[3];			
					$sqlresults = $wardbedsql->addwardsbeds($form_key,$bedname,$wardcode,$wardname,$wardrate,$wardgender,$currentuser,$currentusercode,$instcode,$wardsql);
					$action = 'Ward Bed Added';							
					$result = $engine->getresults($sqlresults,$item=$bedname,$action);
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
