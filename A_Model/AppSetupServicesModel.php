<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$setupservicemodel = htmlspecialchars(isset($_POST['setupservicemodel']) ? $_POST['setupservicemodel'] : '');
	$dept = 'OPD';
	Global $instcode;

	
	// 28 NOV 2023 JOSEPH ADORBOE  returnconsumablestosupplier deleteconsumabletransfer
	switch ($setupservicemodel)
	{
		// 28 NOV 2023 JOSPH ADORBOE
		case 'enableservicesetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $adminservicetable->enableservicesetup($ekey,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->enableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Enable Service";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9965;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}	
		break;

		// 28 NOV 2023 JOSPH ADORBOE
		case 'disableservicesetup':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');	
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item'] : '');	
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)  ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$sqlresults = $adminservicetable->disableservicesetup($ekey,$currentuser,$currentusercode,$instcode);					
					if($sqlresults =='2'){	
						$pricingtable->disableitempriceing($ekey,$currentuser,$currentusercode,$instcode);												
					}	
					$action = "Disable Service";									
					$result = $engine->getresults($sqlresults,$item,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9966;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	

				}
			}	
		break;
		
	}
	

?>