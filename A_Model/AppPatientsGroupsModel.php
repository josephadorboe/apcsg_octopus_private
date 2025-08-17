<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$patientsgroupsmodel = isset($_POST['patientsgroupsmodel']) ? $_POST['patientsgroupsmodel'] : '';	
	
	// 10 AUG 2023
switch ($patientsgroupsmodel)
{

	// 10 AUG 2023 JOSEPH ADORBOE 
	case 'records_addpatientgroups':
		$patientgroup = htmlspecialchars(isset($_POST['patientgroup']) ? $_POST['patientgroup'] : '');
		$groupdesc = htmlspecialchars(isset($_POST['groupdesc']) ? $_POST['groupdesc'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($patientgroup) || empty($patientnumber)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					$sqlresults = $patientsgroupssql->addnewpatientgroup($form_key,$patientgroup,$groupdesc,$patientnumber,$day,$currentusercode,$currentuser,$instcode);
					$action = "Add Patient Groups";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=76;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
					}		
				}			
		}
	break;	
}
?>
