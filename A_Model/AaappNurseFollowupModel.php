<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$followupmodel = isset($_POST['followupmodel']) ? $_POST['followupmodel'] : '';
	
	// 16 MAy 2024 JOSEPH ADORBOE
	switch ($followupmodel)
	{	
	
		// 17 MAY 2024, JOSEPH ADORBOE 
		case 'responsefollowup':			
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$followupresponse = htmlspecialchars(isset($_POST['followupresponse']) ? $_POST['followupresponse']: '');	
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$closefollowup = htmlspecialchars(isset($_POST['closefollowup']) ? $_POST['closefollowup'] : '');
			$followupnumber = htmlspecialchars(isset($_POST['followupnumber']) ? $_POST['followupnumber']: '');
			$followup = htmlspecialchars(isset($_POST['followup']) ? $_POST['followup']: '');
			$followupdate = htmlspecialchars(isset($_POST['followupdate']) ? $_POST['followupdate']: '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode']: '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber']: '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient']: '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($ekey) || empty($followupresponse)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$state = 2;
						$sqlresults = $patientnursefollowuptable->update_nursefollowupresponse($ekey,$day,$followupresponse,$state,$currentusercode,$currentuser,$instcode);	
						if($sqlresults == '2'){							
							if($closefollowup == 'on'){
								$patientnursefollowuptable->insert_addnewfollowup($form_key,$followupnumber,$days,$followup,$followupdate,$patientcode,$patientnumber,$patient,$currentusercode,$currentuser,$instcode);
							}
						}			
						$action = "Edit Patient followup";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9820;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 16 MAY 2024,  JOSEPH ADORBOE 
		case 'editnursefollowup':			
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$followupdate = htmlspecialchars(isset($_POST['followupdate']) ? $_POST['followupdate']: '');
			$followup = htmlspecialchars(isset($_POST['followup']) ? $_POST['followup']: '');			
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($ekey) || empty($followupdate) || empty($followup)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$fbs = 1;
						$sqlresults = $patientnursefollowuptable->update_nursefollowup($ekey,$followupdate,$followup,$currentusercode,$currentuser,$instcode);				
						$action = "Edit Patient followup";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9820;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 17 MAY 2024, JOSEPH ADORBOE 
		case 'addfollowup':
			$patientdet = htmlspecialchars(isset($_POST['patientdet']) ? $_POST['patientdet'] : '');
			$patientnumber = htmlspecialchars( isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$followupdate = htmlspecialchars(isset($_POST['followupdate']) ? $_POST['followupdate']: '');
			$followup = htmlspecialchars(isset($_POST['followup']) ? $_POST['followup']: '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				
				if(empty($patientdet) || empty($followupdate) || empty($followup) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$pd = explode('@@@', $patientdet);
					$patientcode = $pd[0];
					$patientnumber = $pd[1];
					$patient = $pd[2];
					$dob = $pd[3];
					$gender = $pd[4];
					$age = $pat->getpatientbirthage($dob);

					// $patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
					// if($patientnumbercheck == '-1'){
					// 	$status = 'error';
					// 	$msg = 'Invalid Patient number';
					// }else{
					// 	$pt = explode('@@@', $patientnumbercheck);
					// 	$patientcode = $pt[0];
					// 	$patient = $pt[1];	
						$followupnumber = rand(1,99).date("is");				
						$sqlresults = $patientnursefollowuptable->insert_addnewfollowup($form_key,$followupnumber,$days,$followup,$followupdate,$patientcode,$patientnumber,$patient,$currentusercode,$currentuser,$instcode);
						$action = 'New Notes Added';							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9823;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                         
					}
				// }
			//		}
			//	}
			}
		break;
		
		// 16 MAY 2024,  JOSEPH ADORBOE 
		case 'requestfollowupservice':			
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$followupdate = htmlspecialchars(isset($_POST['followupdate']) ? $_POST['followupdate']: '');
			$followup = htmlspecialchars(isset($_POST['followup']) ? $_POST['followup']: '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey) || empty($followupdate) || empty($followup)){				
						$status = "error";
						$msg = "Required Fields cannot be empty";				
					}else{				
						$followupnumber = rand(1,10000);			
						$sqlresults = $patientnursefollowuptable->insert_addnewfollowup($form_key,$followupnumber,$days,$followup,$followupdate,$patientcode,$patientnumber,$patient,$currentusercode,$currentuser,$instcode);
						$action = "Followup added";
						$result = $engine->getresults($sqlresults,$item=$followupnumber,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9821;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
					}			
				}
			}			
		break;	
				
	}
?>
