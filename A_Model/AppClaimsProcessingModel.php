<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$claimsprocessingmodel = htmlspecialchars(isset($_POST['claimsprocessingmodel']) ? $_POST['claimsprocessingmodel'] : '');
	
		// 5 Jan 2024,  JOSEPH ADORBOE  
	switch ($claimsprocessingmodel)
	{

		// 5 JAN 2024, 06 FEB 2023, JOSEPH ADORBOE
		case 'closeclaims':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$claimscodes = htmlspecialchars(isset($_POST['claimscodes']) ? $_POST['claimscodes'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				if($preventduplicate == '1'){
					if($currentshiftcode == '0'){				
						$status = "error";
						$msg = "Shift is closed";				
					}else{							
						$sqlresults = $patientbillitemtable->getcloseclaims($claimscodes,$visitcode,$instcode);
						if($sqlresults == '2'){
							$sqlresults = $patientclaimstable->processclaimsperformedtransactionsclose($claimscodes,$visitcode,$instcode);
						}
						$action = 'Close Process Claims';							
						$result = $engine->getresults($sqlresults,$item=$claimsnumber,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9866;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
				}
		break;

		// 5 JAN 2024, 05 FEB 2023 , JOSEPH ADORBOE
		case 'processclaims':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){	
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($_POST["scheckbox"])){   
						$status = "error";
						$msg = "Required Fields cannot be empty";	 
					}else{
						$clamskeycode = md5(microtime());
						$claimnumber = date('dhis');
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$claimscode = $kt['1'];
							$claimsnumber = $kt['2'];
							$claimsamount = $kt['3'];
							$claimmethodcode = $kt['4'];
							$claimmethod = $kt['5'];
							$claimschemecode = $kt['6'];
							$claimscheme = $kt['7'];
							$claimmonth = $kt['8'];
							$claimyear = $kt['9'];

								$sqlresults = $patientclaimscontroller->processclaimsperformedtransactions($bcode,$days,$claimscode,$claimsnumber,$claimsamount,$visitcode,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode,$patientbillitemtable,$patientclaimstable,$claimstable);
								if($sqlresults == '2'){
									$cm = $claimsmonthlytable->processclaimsmonthly($days,$claimsamount,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode);
									$cs = $claimsschemetable->processclaimsschemes($days,$claimsamount,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode);
									if($cm == '2' && $cs =='2'){
										$sqlresults = '2';
									}else{
										$sqlresults = '0';
									}										
								}
								$action = 'Process Claims';							
								$result = $engine->getresults($sqlresults,$item=$claimsnumber,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=9867;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
								
							}		
						}
					}			
				}
		break;
			
	}

?>
