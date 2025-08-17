<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$cancelledservicesmodel = htmlspecialchars(isset($_POST['cancelledservicesmodel']) ? $_POST['cancelledservicesmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 18 FEB 2021  
	switch ($cancelledservicesmodel)
	{

		// 1 OCT 2024, 25 MAY 2024, JOSEPH ADORBOE 
		case 'reversecannelledservices':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$reversalreason = htmlspecialchars(isset($_POST['reversalreason']) ? $_POST['reversalreason'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($reversalreason)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{				
						$sqlresults = $patientsServiceRequesttable->returnservicerequestreversal($ekey,$reversalreason,$currentusercode,$currentuser,$instcode);
						if($sqlresults == '2'){
							$patientvisittable->reversecancelvisit($visitcode,$instcode);
						}
						$action = "Patient Service Cancelled Reversed";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9824;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
						}
					}							
			}			
		break;			
	}

			
?>
