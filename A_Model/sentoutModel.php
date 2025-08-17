<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$sentoutmodel = isset($_POST['sentoutmodel']) ? $_POST['sentoutmodel'] : '';
	
	// 19 JULY 2021 JOSEPH ADORBOE  
switch ($sentoutmodel)
{
	// 15 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutpharmacysingle':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                $answer = $sentoutsql->reversepharmacysentoutsingle($ekey, $day,$currentusercode, $currentuser);
                        
                if ($answer == '1') {
                    $status = "error";
                    $msg = "Already Selected";
                } elseif ($answer == '2') {
                    $event= "Reverser send out presccription ".$ekey." for  has been saved successfully ";
                    $eventcode= 161;
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = "Sent Out Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail Failed!";
                    }
                } elseif ($answer == '0') {
                    $status = "error";
                    $msg = "Unsuccessful";
                } else {
                    $status = "error";
                    $msg = "Unknown Source";
                }
            }
			
			}
	break;


	// 04 JUN 2021 JOSEPH ADORBOE
	case 'sendoutpharmacy':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';				
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
							$billingcode = md5(microtime());
							$depts = 'PHARMACY';
							if($pharmacystate !== '1'){
								$status = "error";
								$msg = "Only Unselected Pescription can be Sent Out"; 
							}else{								
							
								$answer = $sentoutsql->pharmacysentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item SENT OUT ".$bcode." for  has been saved successfully ";
									$eventcode= 156;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Sent Out Successfully";	
										
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


}

?>
