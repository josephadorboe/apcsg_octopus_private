<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$patientprocedureconsumablesmodel = htmlspecialchars(isset($_POST['patientprocedureconsumablesmodel']) ? $_POST['patientprocedureconsumablesmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 27 SEPT 2024,  JOSEPH ADORBOE 
	switch ($patientprocedureconsumablesmodel) 
	{

	// 25 SEPT 2024, 23 NOV 2023 JOSEPH ADORBOE
	case 'patientprocedureconsumableremoveissued':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$consumablecode = isset($_POST['consumablecode']) ? $_POST['consumablecode'] : '';
		$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
		$consumableqty = isset($_POST['consumableqty']) ? $_POST['consumableqty'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($ekey)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
						$sqlresults = $patientprocedureconsumabletable->removeprocedureconsumableused($ekey,$days,$currentusercode,$currentuser,$instcode);
						// $patientprocedureconsumabletable->newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode);
						if($sqlresults  == '2'){
							// $patientproceduretable->dispenseprocedure($transactioncode,$instcode);
							$consumablesetuptable->addconsumables($consumablecode,$consumableqty,$instcode);
						}								
						$action = "Consumable Issued Removed";
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9762;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
							
					}			
				}
		
			}
	break;

			// 25 SEPT 2024, 23 NOV 2023 JOSEPH ADORBOE
	case 'patientprocedureconsumablesingleissue':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurename = isset($_POST['procedurename']) ? $_POST['procedurename'] : '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$consumablecode = isset($_POST['consumablecode']) ? $_POST['consumablecode'] : '';
		$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
		$consumableqty = isset($_POST['consumableqty']) ? $_POST['consumableqty'] : '';
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($transactioncode)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
						$formkey = md5(microtime());	
						$randomnumber = Rand(100,10000)	;												
						$sqlresults = $patientprocedureconsumabletable->newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode);
						if($sqlresults  == '2'){
							$patientproceduretable->dispenseprocedure($transactioncode,$instcode);
							$consumablesetuptable->deductconsumables($consumablecode,$consumableqty,$instcode);
						}
								
						$action = "Consumable Issued";
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9762;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
							
					}			
				}
		
			}
	break;


		// 25 SEPT 2024, 23 NOV 2023 JOSEPH ADORBOE
	case 'patientprocedureconsumableissueconsumables':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurename = isset($_POST['procedurename']) ? $_POST['procedurename'] : '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($_POST["conscheckbox"]) || empty($transactioncode)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
					foreach ($_POST["conscheckbox"] as $key) {
						$med = explode('@@@', $key);
						$consumablecode = $med[0];
						$consumablename = $med[1];
						$consumableqty = $med[2];
						$formkey = md5(microtime());	
						$randomnumber = Rand(100,10000)	;												
						$sqlresults = $patientprocedureconsumabletable->newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode);
						if($sqlresults  == '2'){
							$patientproceduretable->dispenseprocedure($transactioncode,$instcode);
							$consumablesetuptable->deductconsumables($consumablecode,$consumableqty,$instcode);
						}
								
						$action = "Consumable Issued";
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9762;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
																		
						}			
					}			
				}
		
			}
	break;

	//27 SEPT 2024,  JOSEPH ADORBOE 
	case 'patientprocedureconsumableremove':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($ekey)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
					$sqlresults = $procedureconsumabletable->removeprocedureconsumable($ekey,$days,$currentusercode,$currentuser,$instcode);							
					$action = "Remove Procedure consumable";									
					$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9880;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);															
											
					}			
				}
		
			}
	break;
	
	// 27 SEPT 2024, JOSEPH ADORBOE 
	case 'patientprocedureconsumableedit':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$consumablename = isset($_POST['consumablename']) ? $_POST['consumablename'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($ekey) || empty($qty)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{							
					$sqlresults = $procedureconsumabletable->editprocedureconsumable($ekey,$qty,$days,$currentusercode,$currentuser,$instcode);							
					$action = "Edit Procedure consumable";									
					$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9881;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
													
					}			
				}			
			}
	break;
		
	// 27 SEPT 2024,  JOSEPH ADORBOE 
	case 'patientprocedureconsumableadd':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurename = isset($_POST['procedurename']) ? $_POST['procedurename'] : '';
		$consumable = isset($_POST['consumable']) ? $_POST['consumable'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($consumable) || empty($qty)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{	
					
					foreach ($consumable as $key) {						
						$med = explode('@@@', $key);
						$consumablecode = $med[0];
						$consumablename = $med[1];
						$formkey = md5(microtime());														
						$sqlresults = $procedureconsumabletable->newprocedureconsumabletouse($formkey,$procedurecode,$procedurename,$consumablecode,$consumablename,$qty,$days,$currentusercode,$currentuser,$instcode);							
						$action = "Add Procedure consumable";									
						$result = $engine->getresults($sqlresults,$item=$procedurename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9764;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
																		
						}			
					}			
				}
		
			}
	break;
		
	}	

?>
