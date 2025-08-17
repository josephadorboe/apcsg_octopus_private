<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	$cashmodel = htmlspecialchars(isset($_POST['cashmodel']) ? $_POST['cashmodel'] : '');
	
	// 19 AUG 2023 JOSEPH ADORBOE  
	switch ($cashmodel)
	{

	

		// 19 AUG 2023 , 08 SEPT 2022 
		case 'cancelledsearchfilter': 
			$patientrecords = htmlspecialchars(isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";					
				}else{
					if(empty($patientrecords) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{						
						$value = $patientrecords;
						$msql->passingvalues($pkey=$form_key,$value);						
						$url = "cancelledsearch?$form_key";
						$engine->redirect($url);
					}
				}
			}
		break;
		
		// 19 AUG 2023, 3 MAR 2021 JOSEPH ADORBOE 
		case 'setitemprice':		
			$item = htmlspecialchars(isset($_POST['item']) ? $_POST['item']: '');
			$itemcode = htmlspecialchars(isset($_POST['itemcode']) ? $_POST['itemcode']: '');
			$schemcode = htmlspecialchars(isset($_POST['schemcode']) ? $_POST['schemcode']: '');
			$schemename = htmlspecialchars(isset($_POST['schemename']) ? $_POST['schemename']: '');
			$method = htmlspecialchars(isset($_POST['method']) ? $_POST['method']: '');
			$methodcode = htmlspecialchars(isset($_POST['methodcode']) ? $_POST['methodcode']: '');
			$itemprice = htmlspecialchars(isset($_POST['itemprice']) ? $_POST['itemprice']: '');
			$transactioncode = htmlspecialchars(isset($_POST['transactioncode']) ? $_POST['transactioncode']: '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($itemprice) ){				
						$status = "error";
						$msg = "Required Fields cannot be empty";				
					}else{			
						$sqlresults = $pricesettingsql->setprice($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$currentuser,$currentusercode,$instcode,$billingitemssql);
						$action = 'Set Prices';							
						$result = $engine->getresults($sqlresults,$item,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=55;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
					}		
				}
			}		
		break;
		
	}	

?>
