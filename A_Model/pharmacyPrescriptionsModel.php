 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$pharmacyprescripemodel = isset($_POST['pharmacyprescripemodel']) ? $_POST['pharmacyprescripemodel'] : '';
	
	// 24 SEPT 2022  
switch ($pharmacyprescripemodel)
{
	// 20 APR 2023 JOSEPH ADORBOE
	case 'paymentscheme':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$paymentscheme = isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '';
		$payment = isset($_POST['payment']) ? $_POST['payment'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($patientcode) || empty($paymentscheme) || empty($payment)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{
                    $ps = explode('@@@', $paymentscheme);
                    $paymentschemecode = $ps[0];
                    $paymentscheme = $ps[1];
                    $paymentmethodcode = $ps[2];
                    $paymethname = $ps[3];
				//	$add = $pprescripesql->editpharamcyarchiveprescription($ekey,$days,$currentuser,$currentusercode,$instcode);
                   
                    $answer = $pprescripesql->prescriptionpaymentscheme($ekey,$visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                        
                    if ($answer == '1') {
                        $status = "error";
                        $msg = "Already Selected";
                    } elseif ($answer == '2') {
                        $event= "Changed has been saved successfully ";
                        $eventcode= 165;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Change Successfully";
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
			
			}
	break;
	
	// 02 OCT 2022  JOSPH ADORBOE
	case 'foldersearchprocedure': 		
		$general = isset($_POST['general']) ? $_POST['general'] : '';
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
		$todate = isset($_POST['todate']) ? $_POST['todate'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($general)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
											
					if($general =='2'){
						if(!empty($fromdate)){
							$dt = explode('/', $fromdate);
							$frommonth = $dt[0];
							$fromday = $dt[1];
							$fromyear = $dt[2];
							$ffromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
						}	
						
						if(!empty($todate)){
							$dt = explode('/', $todate);
							$tomonth = $dt[0];
							$today = $dt[1];
							$toyear = $dt[2];
							$ttodate = $toyear.'-'.$tomonth.'-'.$today;
						}

						$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacypatientfolderprocedure?$form_key";
						$engine->redirect($url);

					}else if($general =='1'){
						if(!empty($patientrecords)){
							$value = $general.'@@@'.$patientrecords.'@@@'.$general;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "pharmacypatientfolderprocedure?$form_key";
							$engine->redirect($url);
						}else{
							$status = "error";
							$msg = "Required Fields cannot be empty ";
						}
						
					}	
						
					}
				}
		}

	break;

	// 02 OCT 2022  JOSPH ADORBOE
	case 'foldersearchdevice': 		
		$general = isset($_POST['general']) ? $_POST['general'] : '';
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
		$todate = isset($_POST['todate']) ? $_POST['todate'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($general)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
											
					if($general =='2'){
						if(!empty($fromdate)){
							$dt = explode('/', $fromdate);
							$frommonth = $dt[0];
							$fromday = $dt[1];
							$fromyear = $dt[2];
							$ffromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
						}	
						
						if(!empty($todate)){
							$dt = explode('/', $todate);
							$tomonth = $dt[0];
							$today = $dt[1];
							$toyear = $dt[2];
							$ttodate = $toyear.'-'.$tomonth.'-'.$today;
						}

						$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacypatientfolderdevice?$form_key";
						$engine->redirect($url);

					}else if($general =='1'){
						if(!empty($patientrecords)){
							$value = $general.'@@@'.$patientrecords.'@@@'.$general;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "pharmacypatientfolderdevice?$form_key";
							$engine->redirect($url);
						}else{
							$status = "error";
							$msg = "Required Fields cannot be empty ";
						}
						
					}	
						
					}
				}
		}

	break;

	// 24 SEPT 2022  JOSPH ADORBOE
	case 'foldersearch': 		
		$general = isset($_POST['general']) ? $_POST['general'] : '';
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
		$todate = isset($_POST['todate']) ? $_POST['todate'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($general)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
											
					if($general =='2'){
						if(!empty($fromdate)){
							$dt = explode('/', $fromdate);
							$frommonth = $dt[0];
							$fromday = $dt[1];
							$fromyear = $dt[2];
							$ffromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
						}	
						
						if(!empty($todate)){
							$dt = explode('/', $todate);
							$tomonth = $dt[0];
							$today = $dt[1];
							$toyear = $dt[2];
							$ttodate = $toyear.'-'.$tomonth.'-'.$today;
						}

						$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacypatientfolder?$form_key";
						$engine->redirect($url);

					}else if($general =='1'){
						if(!empty($patientrecords)){
							$value = $general.'@@@'.$patientrecords.'@@@'.$general;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "pharmacypatientfolder?$form_key";
							$engine->redirect($url);
						}else{
							$status = "error";
							$msg = "Required Fields cannot be empty ";
						}
						
					}	
						
					}
				}
		}

	break;

	
	// 24 SEPT 2022 JOSEPH ADORBOE 
	case 'returnmedication':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($returnreason)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
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
							$dispense = $kt['11'];

							$billingcode = md5(microtime());
							$depts = 'PHARMACY';

							if($dispense == '0'){
								$status = "error";
								$msg = "Medication cannot be returned becasue it has not been dispensed"; 
							}else{								
							//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
								$answer = $pprescripesql->returnmedicationrequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
						
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
							}
							}							
						}			
					}			
				}
		
			}
	break;
	
	// 13 JUNE 2021 JOSPH ADORBOE
	case 'editpharamcyprescriptionqty':
		$prescriptionnumber = isset($_POST['prescriptionnumber']) ? $_POST['prescriptionnumber'] : '';
		$newqty = isset($_POST['newqty']) ? $_POST['newqty'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($prescriptionnumber) || empty($newqty)  || empty($pdays)){ 
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
					$da = explode('@@@', $pdays);
					$dayscode = $da[0];
					$daysname = $da[1];
                    $add = $pprescripesql->editprescriptionqty($ekey,$newqty,$dayscode,$daysname,$currentuser,$currentusercode,$instcode);
                    $title = 'Edit Prescription Qty';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $medication Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $medication Exist";
                    } elseif ($add == '2') {
                        $event= " $title $medication successfully ";
                        $eventcode= "160";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "$title $medication Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }  
            
		}
	break;


	// 24 SEPT 2022 JOSEPH ADORBOE
	case 'bulkarchive':		
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
								$results = $pprescripesql->editpharamcyarchiveprescription($ekey,$days,$currentuser,$currentusercode,$instcode);
						
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

	
	// 24 SEPT 2022 JOSPH ADORBOE
	case 'editpharamcyarchiveprescription':		
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey)){ 
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				
                    $add = $pprescripesql->editpharamcyarchiveprescription($ekey,$days,$currentuser,$currentusercode,$instcode);
                    $title = 'Archive Prescription';
					if ($add == '0') {
                        $status = "error";
                        $msg = "$title Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title   Exist";
                    } elseif ($add == '2') {
                        $event= " $title  successfully ";
                        $eventcode= "172";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " $title Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            
		}

	break;

	
	// 13 JUNE 2021 JOSEPH ADORBOE
	case 'addpatientprescription':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';	
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($patientcode) || empty($patientnumber) || empty($patient)|| empty($qty)|| empty($route) || empty($pdays) || empty($consultationpaymenttype) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{

				$med = explode('@@@', $medication);
				$medcode = $med[0];
				$medname = $med[1];
				$dosecode = $med[2];
				$dose = $med[3];
				$notes = strtoupper($notes);
				$type = 'OPD';

				$freq = explode('@@@', $frequency);
				$freqcode = $freq[0];
				$freqname = $freq[1];

				$da = explode('@@@', $pdays);
				$dayscode = $da[0];
				$daysname = $da[1];

				$rou = explode('@@@', $route);
				$routecode = $rou[0];
				$routename = $rou[1];	
				$prescriptionrequestcode = $lov->getprescriptionrequestcode($instcode);			

				$addmedication = $pprescripesql->insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$requestcode,$currentusercode,$currentuser,$instcode);
				$title = 'Add Patient Prescription ';
				if($addmedication == '0'){				
					$status = "error";					
					$msg = "$title $medname  Unsuccessful"; 
				}else if($addmedication == '1'){						
					$status = "error";					
					$msg = "$title $medname  Exist";					
				}else if($addmedication == '2'){
					$event= "$title  successfully ";
					$eventcode= "129";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "$title $medname added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

			}
		}

	break;


	
}	

?>

