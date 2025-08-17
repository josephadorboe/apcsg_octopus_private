<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$nurseingservicesmodel = isset($_POST['nurseingservicesmodel']) ? $_POST['nurseingservicesmodel'] : '';
	
	// 16 MAy 2024 JOSEPH ADORBOE
	switch ($nurseingservicesmodel)
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
		// 27 MAY 2024,  JOSEPH ADORBOE 
		case 'patientnursingservicesave':			
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$servicereport = htmlspecialchars(isset($_POST['servicereport']) ? $_POST['servicereport']: '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";	 				
				}else{			
					if(empty($ekey) || empty($servicereport) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$fbs = 1;
						$servicereport = $servicereport.' - '.$currentuser .' - '.$days;
						$sqlresults = $patientsServiceRequesttable->update_nurseingservicereports($ekey,$servicereport,$instcode);				
						$action = "Save Service Report";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9818;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}				
			}			
		break;
		// 27 MAY 2024, JOSEPH ADORBOE  
		case 'patientnursingserviceadd':
			$patientdet = htmlspecialchars(isset($_POST['patientdet']) ? $_POST['patientdet'] : '');
			$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services']: '');
			$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme']: '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description']: '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				
				if(empty($patientdet) || empty($services) || empty($paymentscheme) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					// $patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
					// if($patientnumbercheck == '-1'){
					// 	$status = 'error';
					// 	$msg = 'Invalid Patient number';
					// }else{
					// 	$pt = explode('@@@', $patientnumbercheck);
					// 	$patientcode = $pt[0];
					// 	$patient = $pt[1];
					$pd = explode('@@@', $patientdet);
					$patientcode = $pd[0];
					$patientnumber = $pd[1];
					$patient = $pd[2];
					$dob = $pd[3];
					$gender = $pd[4];
					$age = $pat->getpatientbirthage($dob);
						$sch = explode('@@@', $paymentscheme);
						$patientschemecode = $sch[0];
						$patientscheme = $sch[1];
						$paymentmethodcode = $sch[2];
						$paymentmethod = $sch[3];

						$ser = explode('@@@', $services);
						$servicecode = $ser[0];
						$servicename = $ser[1];

						$servicerequestcode = md5(microtime());
						$billingcode = md5(microtime());
						$visitcode = md5(microtime());

						$theprice = $pricingtable->gettheprice($itemcode=$servicecode,$instcode,$paymentschemecode=$patientschemecode ,$cashschemecode);
						if($theprice == '-1'){
							$status = 'error';
							$msg = "Price of service $servicename not set";
						}else{
							$age='';	
							$gender='NA';	
							$payment = 1;
							$dpt = 'SERVICES';	
							$paymentplan = '';
							$cash = 'CASH';
						$sqlresults = 
						$patientsServiceRequesttable->vitalsforrbsservicerequest($patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype=1,$servicecode,$servicename,$servicerequestcode,$billingcode,$visittype=1,$currentday,$currentmonth,$currentyear,$plan='NA');

						if($sqlresults == '2'){
						$exe = $patientvisittable->newpatientvisit($visitcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicename,$patientschemecode,$patientscheme,$paymentmethodcode,$paymentmethod,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan);

						$exbill = $patientbillitemtable->newbilling($form_key,$patientcode,$patientnumber,$patient,$visitcode,$days,$servicecode,$servicename,$cashschemecode,$cash,$cashpaymentmethodcode,$cashpaymentmethod,$servicerequestcode,$billingcode,$patientamount=$theprice,$payment,$dpt,$paymentplan,$cardnumber='NA',$cardexpirydate=$day,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear); 
						}						
						$action = 'New Service Added';							
						$result = $engine->getresults($sqlresults,$item=$patient,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9819;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
					//	}                        
					}
				}
			
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
