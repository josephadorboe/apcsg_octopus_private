<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$patientappointmentmodel = isset($_POST['patientappointmentmodel']) ? $_POST['patientappointmentmodel'] : '';
	
	// 8 AUG 2023, 18 APR 2021 JOSEPH ADORBOE
	switch ($patientappointmentmodel)
	{		
			
		// // 21 APR 2021 JOSEPH ADORBOE 
		// case 'cancellappointment':
			
		// 	$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode']: '';
		// 	$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift']: '';
		// 	$ekey = isset($_POST['ekey']) ? $_POST['ekey']: '';
		// 	$patient = isset($_POST['patient']) ? $_POST['patient']: '';
		// 	$timecode = isset($_POST['timecode']) ? $_POST['timecode']: '';
			
		// 	$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		// 	$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
		// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		// 	if($preventduplicate == '1'){			
		// 		if($currentshiftcode == '0'){				
		// 			$status = "error";
		// 			$msg = "Shift is closed";				
		// 		}else{
		// 			if(empty($ekey) ){				
		// 				$status = "error";
		// 				$msg = "Required Fields cannot be empty";				
		// 			}else{			
				
		// 				$update = $patientappointmentsql->cancelledappointment($ekey,$days,$timecode,$currentuser,$currentusercode,$instcode);
		// 				$title = 'Appointment Cancelled';
		// 				if($update == '0'){							
		// 					$status = "error";					
		// 					$msg = "".$title." for ".$patient." Unsuccessful"; 
		// 				}else if($update == '1'){						
		// 					$status = "error";					
		// 					$msg = "".$title." for ".$patient." Exist Already"; 							
		// 				}else if($update == '2'){	
		// 					$event= "".$title.": ".$form_key." for  has been saved successfully ";
		// 					$eventcode= 104;
		// 					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
		// 					if($audittrail == '2'){
		// 						$status = "success";
		// 						$msg = "".$title." for ".$patient."  Successfully";	
		// 					}else{
		// 						$status = "error";					
		// 						$msg = "Audit Trail Failed!"; 
		// 					}												
		// 				}else{						
		// 					$status = "error";					
		// 					$msg = "Query Unsuccessful "; 						
		// 				}
							
		// 			}			
		// 	}
		// }
			
		// break;		
				
	}
?>
