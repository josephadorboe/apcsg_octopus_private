<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$appointmentmodel = isset($_POST['appointmentmodel']) ? $_POST['appointmentmodel'] : '';
	
	// 8 AUG 2023, 18 APR 2021 JOSEPH ADORBOE
	switch ($appointmentmodel)
	{	
		// 2 SEPT 2023, 21 APR 2021 JOSEPH ADORBOE 
		case 'cancellappointment':			
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode']: '');
			$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift']: '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey']: '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient']: '');
			$timecode = htmlspecialchars(isset($_POST['timecode']) ? $_POST['timecode']: '');
			$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason']: '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey) || empty($cancelreason)){				
						$status = "error";
						$msg = "Required Fields cannot be empty";				
					}else{				
						$sqlresults = $appointmentcontroller->cancellappointment($ekey,$timecode,$cancelreason,$currentuser,$currentusercode,$instcode,$patientappointmenttable,$appointmentslottable);
						$action = "Appointment Cancelled for ";							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=104;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
					}			
				}
			}			
		break;	
		// 2 SEPT 2023 ,  8 AUG 2023, 20 APR 2021 JOSEPH ADORBOE  
		case 'bookappointment':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$patientnumbers = htmlspecialchars(isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services'] : '');
			$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$phone = htmlspecialchars(isset($_POST['phone']) ? $_POST['phone'] : '');
			$appointmenttime = htmlspecialchars(isset($_POST['appointmenttime']) ? $_POST['appointmenttime'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey) || empty($appointmenttime) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{										
						$ps = explode('@@@', $appointmenttime);
						$appcode = $ps[0];
						$appstart = $ps[1];
						$append = $ps[2];
						$appdoccode = $ps[3];
						$appdocname = $ps[4];
					$sqlresults = $appointmentcontroller->newappointment($form_key,$patientcode,$patientnumbers,$patient,$phone,$appcode,$appstart,$append,$appdoccode,$appdocname,$days,$age,$gender,$currentusercode,$currentuser,$instcode,$patientappointmenttable,$appointmentslottable);
					$action = "New Appointment Added for ";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=56;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);			
					}
				}
			}
		break;	
		// 8 AUG 2023, 20 APR 2021 JOSEPH ADORBOE 
		case 'generateappointmentslots':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$appointmentdate = htmlspecialchars(isset($_POST['appointmentdate']) ? $_POST['appointmentdate'] : '');
			$appointmentshifttype = htmlspecialchars(isset($_POST['appointmentshifttype']) ? $_POST['appointmentshifttype'] : '');
			$appointmentdoctor = htmlspecialchars(isset($_POST['appointmentdoctor']) ? $_POST['appointmentdoctor'] : '');							
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				if($preventduplicate == '1'){		
					if($currentshiftcode == '0'){				
						$status = "error";
						$msg = "Shift is closed";				
					}else{
						if(empty($appointmentdate) || empty($appointmentshifttype) || empty($appointmentdoctor) ){
							$status = 'error';
							$msg = 'Required Field Cannot be empty';				
						}else{	
													
						// $thedate = explode('/', $appointmentdate);
						// $themonth = $thedate[0];
						// $theday = $thedate[1];
						// $theyear = $thedate[2];
						// $appointmentda = $theyear.'-'.$themonth.'-'.$theday;
						$appdoctor = explode('@@@', $appointmentdoctor);
						$appdoctorcode = $appdoctor[0];
						$appdoctorname = $appdoctor[1];	
						$currentconsultationstart = '09';	
						$currentconsultationend = '18';	
						$currentconsultationduration = 30;	
						$currentappointmentnumber = 10;
						$starttime = date('Y-m-d '.$currentconsultationstart.':i:s' , strtotime($appointmentdate));
						$endconsultation = date('Y-m-d '.$currentconsultationend.':i:s' , strtotime($appointmentdate));
						if($appointmentdate < $day){
							$status = 'error';
							$msg = 'Cannot generate appointment slot for pasted dates ';	
						}else{							
								$x = 1;
								while ($x < $currentappointmentnumber ) {
									$tm = $currentconsultationduration*$x;
									$y = $x + 1;
									$ym = $currentconsultationduration*$y;
									$form_key = $form_key.''.$x;
									$start = date('Y-m-d H:i:s', strtotime('+ '.$tm.' minutes ', strtotime($starttime)));
									$endtime = date('Y-m-d H:i:s', strtotime('+ '.$ym.' minutes ', strtotime($starttime)));
									$sqlresults = $appointmentslottable->generateappointmentslots($form_key,$start,$endtime,$appointmentdate,$appdoctorcode,$appdoctorname,$currentuser,$currentusercode,$instcode);
									$x++;									
								}
								$action = 'New Appointment Slots Added';							
								$result = $engine->getresults($sqlresults,$item=$appdoctorname,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=105;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
						}
					}									
				}		
			}						
		break;
		// 18 APR 2021 JOSEPH ADORBOE 
		case 'appointmentpatientsearch':			
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
						$url = "bookappointment?$form_key";
						$engine->redirect($url);
					}
				}
			}
		break;			
	}
?>
