 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$proceduremodel = isset($_POST['proceduremodel']) ? $_POST['proceduremodel'] : '';
	
	// 02 OCT 2022 
switch ($proceduremodel)
{
	// 31 OCT 2022 JOSEPH ADORBOE 
	case 'issueconsumables':		
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
								$answer = $proceduresql->newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Added";
								}else if($answer == '2'){
									$proceduresql->dispenseprocedure($transactioncode,$currentusercode,$currentuser,$instcode);
									$proceduresql->deductconsumables($consumablecode,$consumableqty,$currentusercode,$currentuser,$instcode);
									
									// $event= "Add procedure Consumable saved successfully ";
									// $eventcode= 197;
									// $audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									//if($audittrail == '2'){
										$status = "success";
										$msg = "Add $consumablename Successfully";	
									// }else{
									// 	$status = "error";					
									// 	$msg = "Audit Trail Failed!"; 
									// }									
								}else if($answer == '0'){
									$status = "error";
									$msg = "Unsuccessful"; 
								}else{
									$status = "error";
									$msg = "Unknown Source"; 
								}
											
						}			
					}			
				}
		
			}
	break;

	// 31 OCT 2022 JOSEPH ADORBOE 
	case 'removeprocedureconsumables':		
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
					$answer = $proceduresql->removeprocedureconsumable($ekey,$days,$currentusercode,$currentuser,$instcode);						
					if($answer == '1'){
						$status = "error";
						$msg = "Already Added";
					}else if($answer == '2'){						
						$event= "Remove procedure Consumable saved successfully ";
						$eventcode= 197;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Remove $consumablename Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}									
					}else if($answer == '0'){
						$status = "error";
						$msg = "Unsuccessful"; 
					}else{
						$status = "error";
						$msg = "Unknown Source"; 
					}
							
					}			
				}
		
			}
	break;

	// 31 OCT 2022 JOSEPH ADORBOE 
	case 'editprocedureconsumables':		
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
					
					$answer = $proceduresql->editprocedureconsumable($ekey,$qty,$days,$currentusercode,$currentuser,$instcode);
						
					if($answer == '1'){
						$status = "error";
						$msg = "Already Added";
					}else if($answer == '2'){
						
						$event= "Edit procedure Consumable saved successfully ";
						$eventcode= 197;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Edit $consumablename Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}									
					}else if($answer == '0'){
						$status = "error";
						$msg = "Unsuccessful"; 
					}else{
						$status = "error";
						$msg = "Unknown Source"; 
					}
							
					}			
				}
		
			}
	break;

	// 31 OCT 2022 JOSEPH ADORBOE 
	case 'addprocedureconsumables':		
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
					// 	var_dump($key);
					// die;
						$med = explode('@@@', $key);
						$consumablecode = $med[0];
						$consumablename = $med[1];
						$formkey = md5(microtime());														
								$answer = $proceduresql->newprocedureconsumable($formkey,$procedurecode,$procedurename,$consumablecode,$consumablename,$qty,$days,$currentusercode,$currentuser,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Added";
								}else if($answer == '2'){
									
									// $event= "Add procedure Consumable saved successfully ";
									// $eventcode= 197;
									// $audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									//if($audittrail == '2'){
										$status = "success";
										$msg = "Add $consumablename Successfully";	
									// }else{
									// 	$status = "error";					
									// 	$msg = "Audit Trail Failed!"; 
									// }									
								}else if($answer == '0'){
									$status = "error";
									$msg = "Unsuccessful"; 
								}else{
									$status = "error";
									$msg = "Unknown Source"; 
								}
											
						}			
					}			
				}
		
			}
	break;

	// 2 OCT 2022 JOSEPH ADORBOE 
	case 'returnprocedures':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($_POST["scheckbox"]) || empty($returnreason)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
					foreach($_POST["scheckbox"] as $key){						
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$pharmacystate = $kt['6'];
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];
							$paymenttype = $kt['10'];
							$dispense = $kt['11'];

							$billingcode = md5(microtime());
							$depts = 'PROCEDURE';

							if($dispense == '0'){
								$status = "error";
								$msg = "Procedure cannot be returned becasue it has not been dispensed"; 
							}else{								
								$answer = $proceduresql->returnprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Return Request saved successfully ";
									$eventcode= 197;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Return Request Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}									
								}else if($answer == '0'){
									$status = "error";
									$msg = "Unsuccessful"; 
								}else{
									$status = "error";
									$msg = "Unknown Source"; 
								}
						//	}
							}							
						}			
					}			
				}
		
			}
	break;
	
	// 02 OCT 2022 JOSEPH ADORBOE
	case 'bulkprocedurearchive':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';						
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
					foreach($_POST["scheckbox"] as $key){						
							$kt = explode('@@@',$key);
							$ekey = $kt['0'];
								$results = $proceduresql->editpharamcyarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode);
						
								if($results == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($results == '2'){
									$event= "Archived $ekey Prescriptions Successfully ";
									$eventcode= 156;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Archive  Successfully";	
								
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}									
								}else if($results == '0'){
									$status = "error";
									$msg = "Unsuccessful"; 
								}else{
									$status = "error";
									$msg = "Unknown Source"; 
								}
										
						}			
					}			
				}
		
			}
	break;

	
}	

	
?>

