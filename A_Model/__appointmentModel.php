<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$appointmentmodel = isset($_POST['appointmentmodel']) ? $_POST['appointmentmodel'] : '';
/*
	if($userdetails !== '-1'){

			
	}
	*/
	
	// 18 APR 2021 JOSEPH ADORBOE
	switch ($appointmentmodel)
	{
		
		
		
		// 21 APR 2021 JOSEPH ADORBOE 
		case 'cancellappointment':
			
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode']: '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift']: '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey']: '';
			$patient = isset($_POST['patient']) ? $_POST['patient']: '';
			$timecode = isset($_POST['timecode']) ? $_POST['timecode']: '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

			if($preventduplicate == '1'){			
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($ekey) ){				
						$status = "error";
						$msg = "Required Fields cannot be empty";				
					}else{			
				
						$update = $appointmentsql->cancelledappointment($ekey,$days,$timecode,$currentuser,$currentusercode,$instcode);
						$title = 'Appointment Cancelled';
						if($update == '0'){							
							$status = "error";					
							$msg = "".$title." for ".$patient." Unsuccessful"; 
						}else if($update == '1'){						
							$status = "error";					
							$msg = "".$title." for ".$patient." Exist Already"; 							
						}else if($update == '2'){	
							$event= "".$title.": ".$form_key." for  has been saved successfully ";
							$eventcode= 104;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "".$title." for ".$patient."  Successfully";	
							}else{
								$status = "error";					
								$msg = "Audit Trail Failed!"; 
							}												
						}else{						
							$status = "error";					
							$msg = "Query Unsuccessful "; 						
						}
							
					}			
			}
		}
			
		break;

		
		
		
		// 20 APR 2021 JOSEPH ADORBOE  
		case 'bookappointment': 

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$patientnumbers = isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$paymentscheme = isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
			$appointmenttime = isset($_POST['appointmenttime']) ? $_POST['appointmenttime'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
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

					$add = $appointmentsql->insert_bookappointment($form_key,$patientcode,$patientnumbers,$patient,$phone,$appcode,$appstart,$append,$appdoccode,$appdocname,$days,$age,$gender,$currentusercode,$currentuser,$instcode);
					$title = 'Book Appointment';
					if($add == '0'){					
						$status = "error";					
						$msg = "".$title." for ".$patient." Unsuccessful";
					}else if($add == '1'){					
						$status = "error";					
						$msg = "".$title." for ".$patient." Exist"; 					
					}else if($add == '2'){	
						$event= "".$title." CODE:".$form_key." for ".$patient." has been saved successfully ";
						$eventcode= 75;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "".$title." for ".$patient." added Successfully";	
							}else{
								$status = "error";					
								$msg = "Audit Trail Failed!"; 
							}							
					}else{					
						$status = "error";					
						$msg = "Unsuccessful "; 					
					}

				}				

				}

			}

		break;

		
		
		
		// 20 APR 2021 JOSEPH ADORBOE 
		case 'generateappointmentslots':		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$appointmentdate = isset($_POST['appointmentdate']) ? $_POST['appointmentdate'] : '';
			$appointmentshifttype = isset($_POST['appointmentshifttype']) ? $_POST['appointmentshifttype'] : '';
			$appointmentdoctor = isset($_POST['appointmentdoctor']) ? $_POST['appointmentdoctor'] : '';
							
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
							
						$thedate = explode('/', $appointmentdate);
						$themonth = $thedate[0];
						$theday = $thedate[1];
						$theyear = $thedate[2];
						$appointmentda = $theyear.'-'.$themonth.'-'.$theday;
						$appdoctor = explode('@@@', $appointmentdoctor);
						$appdoctorcode = $appdoctor[0];
						$appdoctorname = $appdoctor[1];				
						$starttime = date('Y-m-d '.$currentconsultationstart.':i:s' , strtotime($appointmentda));
						$endconsultation = date('Y-m-d '.$currentconsultationend.':i:s' , strtotime($appointmentda));
						
					//	die($endtime);
						if($appointmentda < $day){
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
									$answer = $appointmentsql->generateappointmentslots($form_key,$start,$endtime,$appointmentda,$appdoctorcode,$appdoctorname,$currentuser,$currentusercode,$instcode);
									$x++;

									$title = 'Appointment Slots';
									
									if($answer == '1'){
										$status = "error";
										$msg = "".$title." Already Exist";
									}else if($answer == '2'){
										$event= "".$title." ".$start." generated successfully ";
										$eventcode= 105;
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										if($audittrail == '2'){
											$status = "success";
											$msg = " ".$title."  saved Successfully";		
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
									
				}
		
			}
						
		break;


		// 18 APR 2021 JOSEPH ADORBOE 
		case 'appointmentpatientsearch': 
			
			$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
