<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$forexmodel = isset($_POST['forexmodel']) ? $_POST['forexmodel'] : '';
	$dept = 'OPD';
	Global $instcode;
	
	// 9 AUG 2023 JOSEPH ADORBOE 
	switch ($forexmodel)
	{
		
		// 05 NOV 2022 
		case 'addforexrate':
			$currency = htmlspecialchars(isset($_POST['currency']) ? $_POST['currency'] : '');
			$rates = htmlspecialchars(isset($_POST['rates']) ? $_POST['rates'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($currency) || empty($rates)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					if(!is_numeric($rates)){					
						$status = 'error';
						$msg = 'Rate is Should be Numbers Only.';
					}else{
						if($rates<'1'){
							$status = 'error';
							$msg = 'Rate cannot be less than 1';
						}else{								
						$sqlresults = $cashierforextable->addforex($form_key,$currency,$rates,$days,$currentusercode,$currentuser,$instcode);
						$action = 'Rates added';							
						$result = $engine->getresults($sqlresults,$item=$currency,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9872;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
						}							
					}
				}
			}		
		break;
		
	}	

?>
