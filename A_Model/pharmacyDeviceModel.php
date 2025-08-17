 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$pharmacydevicemodel = isset($_POST['pharmacydevicemodel']) ? $_POST['pharmacydevicemodel'] : '';
	
	// 23 APR 2021 
switch ($pharmacydevicemodel)
{


	// 28 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutdevice':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';			
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

							if($pharmacystate !== '8'){
								$status = "error";
								$msg = "Only Sentout device Pescription can be reversed "; 
							}else{				
							
								$answer = $pdevicesql->reversedevicesentout($bcode,$currentusercode,$currentuser);						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item SENT OUT REVERSED ".$bcode." for  has been saved successfully ";
									$eventcode= 166;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Reverse Sent Out Successfully";	
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


	// 27 SEPT 2022 JOSEPH ADORBOE 
	case 'returndevices':		
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
							$depts = 'DEVICES';

							if($dispense == '0'){
								$status = "error";
								$msg = "Device cannot be returned becasue it has not been dispensed"; 
							}else{								
								$answer = $pdevicesql->returndevicesrequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
						
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

	// 28 JUN 2021 JOSEPH ADORBOE
	case 'manageeditdeviceprescriptions':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
                if(empty($visitcode) || empty($patientcode) || empty($paymentscheme) || empty($payment)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{
                    $ps = explode('@@@', $paymentscheme);
                    $paymentschemecode = $ps[0];
                    $paymentscheme = $ps[1];
                    $paymentmethodcode = $ps[2];
                    $paymethname = $ps[3];

					// if($pharmacystate !== '8'){
					// 	$status = "error";
					// 	$msg = "Only Sentout device Pescription can be reversed "; 
					// }else{	
    
                    $answer = $pdevicesql->editdevicemanage($visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                        
                    if ($answer == '1') {
                        $status = "error";
                        $msg = "Already Selected";
                    } elseif ($answer == '2') {
                        $event= "Changed has been saved successfully ";
                        $eventcode= 167;
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


	// 28 SEPT 2022 JOSEPH ADORBOE
	case 'bulkdevicearchive':		
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
								$results = $pdevicesql->editpharamcyarchivedevices($ekey,$days,$currentuser,$currentusercode,$instcode);
						
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

	// 29 JUN 2021 JOSEPH ADORBOE
	case 'sendoutpharmacydevice':		
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
								$msg = "Only Unselected Device Pescription can be Sent Out"; 
							}else{								
							
								$answer = $pdevicesql->devicesentout($bcode,$currentusercode,$currentuser);
						
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

	// 03 JULY 2021 JOSPH ADORBOE
	case 'editpharamcydeviceprescriptionqty':
		$prescriptionnumber = isset($_POST['prescriptionnumber']) ? $_POST['prescriptionnumber'] : '';
		$newqty = isset($_POST['newqty']) ? $_POST['newqty'] : '';
		$device = isset($_POST['device']) ? $_POST['device'] : '';
		$devices = isset($_POST['devices']) ? $_POST['devices'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($newqty) || empty($devices)){ 
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
					$dev = explode('@@@',$devices);
					$devicecode = $dev['0'];
					$devicename = $dev['1'];

                    $add = $pdevicesql->editdeviceprescriptionqty($ekey,$newqty,$devicecode,$devicename,$currentuser,$currentusercode,$instcode);
                    $title = 'Edit Device Prescription';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $device  Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $device  Exist";
                    } elseif ($add == '2') {
                        $event= " $title $device  successfully ";
                        $eventcode= "172";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " $title $device Successfully";
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

	// 29 JUNE 2021 JOSEPH ADORBOE 
	case 'devicedispense':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';			
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
							$pharamcystate = $kt['6'];
							$qty = $kt['10'];
							
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];

                            if ($pharamcystate == '4') {
                                $dispense = 1;
                            }else if($pharamcystate == '9'){
								$dispense = 1;
							}else{
								$dispense = '0';
							}

							if($dispense == '0'){
								$status = "error";
								$msg = "Only Paid Device Prescription can be Dispensed"; 
							}else{	
								$getqty = $pdevicesql->getdevicescurrentqty($servicescode,$instcode);
							//	$getqty = $pharmacysql->getmedicationdurrentqty($servicescode,$instcode);
								$newqty = $getqty - $qty;			
							
								$answer = $pdevicesql->deviceprescriptiondispense($bcode,$days,$servicescode,$qty,$cost,$newqty,$patientcode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
								$title = 'Device Prescription dispensed';
								if($answer == '1'){
									$status = "error";
									$msg = "".$title." Already Selected";
								}else if($answer == '2'){
									$event= "".$title."  ".$bcode." for  has been saved successfully ";
									$eventcode= 103;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "".$title."  Successfully";	
										$claimsnumber = $coder->getclaimsnumber($instcode);
									$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);	
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

	// 29 JUNE 2021 JOSEPH ADORBOE
	case 'sendforpaymentdevices':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$patienttype = isset($_POST['patienttype']) ? $_POST['patienttype'] : '';			
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
							$bbcode = md5(microtime());
							$billcode = $cashiersql->getpatientbillingcode($bbcode,$patientcode,$patientnumber,$patient,$days,$visitcode,$currentuser,$currentusercode,$instcode);

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
							$billercode = $kt['12'];
							$biller = $kt['13'];
						//	$paymenttype = $kt['10'];
							$billingcode = md5(microtime());
							$depts = 'DEVICES';
							if($pharmacystate !== '2'){
								$status = "error";
								$msg = "Only Selected Prescription can be Process Payment"; 
							}else{
                                if ($cost == '-1') {
                                    $status = "error";
                                    $msg = "Price has not been set";
                                } else {
                                    if ($cost == '0') {
                                        $status = "error";
                                        $msg = "Total Amount cannot be zero";
                                    } else {
										$schemepricepercentage = $paymentschemetable->getschemepercentage($paymentschemecode,$instcode);
                                        // for cash
                                        if ($paymentmethodcode == $cashpaymentmethodcode) {
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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
                                
                                            // for momo
                                        } elseif ($paymentmethodcode == $mobilemoneypaymentmethodcode) {
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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

                                            // for private insurance
                                        } elseif ($paymentmethodcode == $privateinsurancecode) {
                                            $patientpaymenttype = 1;
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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

                                            // for partner companies
                                        } elseif ($paymentmethodcode == $partnercompaniescode) {
                                            $patientpaymenttype = 1;
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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
                                
                                            // for NHIS
                                        } elseif ($paymentmethodcode == $nationalinsurancecode) {
                                            $patientpaymenttype = 1;
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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


                                            // for others
                                        } else {

                                //	$patientpaymenttype = 7;
                                            $answer = $pdevicesql->deviceprescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                            if ($answer == '1') {
                                                $status = "error";
                                                $msg = "Already Selected";
                                            } elseif ($answer == '2') {
                                                $event= "Item ".$serviceitem." Process payment successfully ";
                                                $eventcode= 170;
                                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    $status = "success";
                                                    $msg = "Process payment Successfully";
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
                            }						
						}			
					}			
				}
		
			}else{
				$status = "error";
				$msg = "Double Clicks"; 
			}
	break;


	// 29 JUNE 2021
	case 'unselecttransactiondevice':

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
			
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
							$labstate = $kt['6'];
							if($labstate !== '2'){
								$status = "error";
								$msg = "Only Selected device Prescription can be Unselected"; 
							}else{
								$answer = $pdevicesql->unselectprescriptiondevice($bcode,$days,$currentusercode,$currentuser);						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Unselected ".$bcode." for  has been saved successfully ";
									$eventcode= 169;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Unselected Successfully";		
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
		}else{
			$status = "error";
			$msg = "Double Clicks";	
		}

	break;

	
	// 29 JUNE 2021 JOSEPH ADORBOE 
	case 'selecttransactiondevice':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';	
		$validinsurance = isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '';	
					
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
							$labstate = $kt['6'];
							$med = $kt['7'];
							$scheme = $kt['9'];
							$qty = $kt['10'];

							if($labstate !== '1'){
								$status = "error";
								$msg = "Only Unselected Device Prescription can be selected"; 
							}else{
								$getqty = $pdevicesql->getdevicescurrentqty($servicescode,$instcode);
							//	die($getqty);
								if($getqty < $qty){
									$status = "error";
									$msg = "Insufficent Quantity"; 
								}else{	
									$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
								// cash	
								if($paymentmethodcode == $cashpaymentmethodcode){
									
									$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
									if($serviceamount == '-1'){
										$totalamount = '-1';	
									}else{
										$totalamount = $serviceamount*$qty;
									}

									if($totalamount == '0'){
										$status = "error";
										$msg = "Total Amount cannot be zero"; 
									}else{                                  

                                //	die($totalamount);
                                
                                        $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                        $title = 'Device Prescription Selected';
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "".$title." Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                            $eventcode= 168;
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "".$title."  Successfully";
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


								// momo
								}else if($paymentmethodcode == $mobilemoneypaymentmethodcode){

									$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
									if($serviceamount == '-1'){
										$totalamount = '-1';	
									}else{
										$totalamount = $serviceamount*$qty;
									}
									if($totalamount == '0'){
										$status = "error";
										$msg = "Total Amount cannot be zero"; 
									}else{
                                        $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                        $title = 'Device Prescription Selected';
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "".$title." Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                            $eventcode= 168;
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "".$title."  Successfully";
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

								// private insurnace
								}else if($paymentmethodcode == $privateinsurancecode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient ".$patient." does not have a valid insurance ";
									} else {
                                        $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
                                        if ($insurancechecks == '-1') {
                                            $status = "error";
                                            $msg = "The patient ".$patient." does not have a current insurance Policy ";
                                        } elseif ($insurancechecks == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $expt = explode('@@@', $insurancechecks);
                                            $cardnumber = $expt[0];
                                            $cardexpirydate = $expt[1];

                                            $serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
                                            if ($serviceamount == '-1') {
                                                $status = "error";
                                                $msg = "The patient ".$patient." insurance scheme ".$scheme." does not pay for ".$med.". please use cash  ";
                                            } else {
                                                $totalamount = $serviceamount*$qty;
                                                if ($totalamount == '0') {
                                                    $status = "error";
                                                    $msg = "Total Amount cannot be zero";
                                                } else {
                                                    $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                                    $title = 'Prescription Selected';
                                                    if ($answer == '1') {
                                                        $status = "error";
                                                        $msg = "".$title." Already Selected";
                                                    } elseif ($answer == '2') {
                                                        $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                                        $eventcode= 168;
                                                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                        if ($audittrail == '2') {
                                                            $status = "success";
                                                            $msg = "".$title."  Successfully";
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
                                    }


								// partner companies 
								}else if($paymentmethodcode == $partnercompaniescode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient ".$patient." does not have a valid insurance ";
									} else {
                                        $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
                                        if ($insurancechecks == '-1') {
                                            $status = "error";
                                            $msg = "The patient ".$patient." does not have a current insurance Policy ";
                                        } elseif ($insurancechecks == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $expt = explode('@@@', $insurancechecks);
                                            $cardnumber = $expt[0];
                                            $cardexpirydate = $expt[1];

                                            $serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
                                            if ($serviceamount == '-1') {
                                                $status = "error";
                                                $msg = "The patient ".$patient." insurance scheme ".$scheme." does not pay for ".$med.". please use cash  ";
                                            } else {
                                                $totalamount = $serviceamount*$qty;
                                                if ($totalamount == '0') {
                                                    $status = "error";
                                                    $msg = "Total Amount cannot be zero";
                                                } else {
                                                    $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                                    $title = 'Prescription Selected';
                                                    if ($answer == '1') {
                                                        $status = "error";
                                                        $msg = "".$title." Already Selected";
                                                    } elseif ($answer == '2') {
                                                        $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                                        $eventcode= 168;
                                                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                        if ($audittrail == '2') {
                                                            $status = "success";
                                                            $msg = "".$title."  Successfully";
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
                                    }


								// nhis
								}else if($paymentmethodcode == $nationalinsurancecode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient ".$patient." does not have a valid insurance ";
									} else {
                                        $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
                                        if ($insurancechecks == '-1') {
                                            $status = "error";
                                            $msg = "The patient ".$patient." does not have a current insurance Policy ";
                                        } elseif ($insurancechecks == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $expt = explode('@@@', $insurancechecks);
                                            $cardnumber = $expt[0];
                                            $cardexpirydate = $expt[1];

                                            $serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
                                            if ($serviceamount == '-1') {
                                                $status = "error";
                                                $msg = "The patient ".$patient." insurance scheme ".$scheme." does not pay for ".$med.". please use cash  ";
                                            } else {
                                                $totalamount = $serviceamount*$qty;

                                                if ($totalamount == '0') {
                                                    $status = "error";
                                                    $msg = "Total Amount cannot be zero";
                                                } else {
                                                    $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                                    $title = 'Prescription Selected';
                                                    if ($answer == '1') {
                                                        $status = "error";
                                                        $msg = "".$title." Already Selected";
                                                    } elseif ($answer == '2') {
                                                        $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                                        $eventcode= 168;
                                                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                        if ($audittrail == '2') {
                                                            $status = "success";
                                                            $msg = "".$title."  Successfully";
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
                                    }


								// others
								}else {
                                    $serviceamount = $pricing->getprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode, $ptype, $instcodenuc);
                                    if ($serviceamount == '-1') {
                                        $totalamount = '-1';
                                    } else {
                                        $totalamount = $serviceamount*$qty;
                                    }
                                    if ($totalamount == '0') {
                                        $status = "error";
                                        $msg = "Total Amount cannot be zero";
                                    } else {
                                        $answer = $pdevicesql->deviceprescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
                                        $title = 'Prescription Selected';
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "".$title." Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "".$title."  ".$bcode." for  has been saved successfully ";
                                            $eventcode= 168;
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "".$title."  Successfully";
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
						
							}							
						}			
					}			
				}
		
			}else{
				$status = "error";
				$msg = "Double Clicks";	
			}
	break;

 }	

	function devicemenu(){
		echo'
		<div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
									Device Menu <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-plus-title">
										Medical Devices
										<b class="fa fa-angle-up" aria-hidden="true"></b>
									</li>									
									<li><a href="medicaldevicesendoutfilter">Sent Out Devices</a></li>									
									<li><a href="devicelowstocks">Low Stocks</a></li>
									<li><a href="newdevices">New Devices</a></li>
									<li><a href="devicespharmacystocklist">Stock List</a></li>
									<li><a href="devicepharmacypricing">Pricing</a></li>
									<li class="divider"></li>
									<li><a href="manageprescribedevices">Medical Devices</a></li>
								</ul>
							</div>';
	}
	

// 	function prescriptionmenu(){
// 		echo'
// 		<div class="btn-group mt-2 mb-2">
// 								<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
// 									Prescription Menu <span class="caret"></span>
// 								</button>
// 								<ul class="dropdown-menu" role="menu">
// 									<li class="dropdown-plus-title">
// 									Prescription
// 										<b class="fa fa-angle-up" aria-hidden="true"></b>
// 									</li>
									
// 									<li><a href="prescriptionsendoutfilter">Sent Out </a></li>
// 									<li><a href="stockadjustments">Stock Adjustments</a></li>
// 									<li><a href="lowstocks">Low Stocks</a></li>
// 									<li><a href="newmedications">New Medication</a></li>
// 									<li><a href="pharmacystocklist">Stock List</a></li>
// 									<li><a href="pharmacypricing">Pricing</a></li>
// 									<li class="divider"></li>
// 									<li><a href="manageprescriptions">Prescription </a></li>
// 								</ul>
// 							</div>';
// 	}
//}
	
?>

