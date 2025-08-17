<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$incidencemodel = isset($_POST['incidencemodel']) ? $_POST['incidencemodel'] : '';	
	// 1 SEPT 2023 JOSEPH ADORBOE  
	switch ($incidencemodel)
	{
		// 1 SEPT 2023, 20 OCT 2021 JOSEPH ADORBOE 
		case 'addnewincidence':
			$incidencetitle = htmlspecialchars(isset($_POST['incidencetitle']) ? $_POST['incidencetitle'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');
			$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($incidencetitle) || empty($type) || empty($notes) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$incidencetitle = strtoupper($incidencetitle);
					$incidencecode = rand(100,10000);
					$sqlresults = $incidencetable->insert_newincidence($form_key,$incidencecode,$days,$incidencetitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
					$action = 'New Incidence Added';
					$result = $engine->getresults($sqlresults,$item=$incidencetitle,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=153;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 					
				}
			}
		break;

		
	}

?>
