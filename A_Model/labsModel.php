<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$labsmodel = isset($_POST['labsmodel']) ? $_POST['labsmodel'] : '';
	
	// 29 MAR 2021
switch ($labsmodel)
{

	// 21 APR 2023 JOSEPH ADORBOE 
	case 'imagingpricesearch': 
		$selectedone = isset($_POST['selectedone']) ? $_POST['selectedone'] : '';
		$selectedtwo = isset($_POST['selectedtwo']) ? $_POST['selectedtwo'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){			
			if(empty($selectedone) || empty($selectedtwo)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{							
					echo 'Welcome';
				}
		}
	break;

	// 24 SEPT 2022 JOSEPH ADORBOE 
	case 'returninvestigation':		
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
							$type = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$state = $kt['5'];
							$return = $kt['6'];
							$category = $kt['7'];
							// $paymentmethod = $kt['8'];
							// $paymentscheme = $kt['9'];
							// $paymenttype = $kt['10'];
							// $dispense = $kt['11'];

							// $billingcode = md5(microtime());
							// $depts = 'PHARMACY';
							//  echo $row['MIV_CODE'].'@@@'.$row['MIV_TESTCODE'].'@@@'.$row['MIV_TYPE'].'@@@'.$row['MIV_COST'].'@@@'.$row['MIV_PAYMENTMETHODCODE'].'@@@'.$row['MIV_STATE'] 

							if($return !== '0'){
								$status = "error";
								$msg = "Investigation cannot be return because it has been returned  "; 
							}else{								
							//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
								$reportfeesamout = '0';
								
								if($category == 'IMAGING'){
									$reportfeesamout = $labssql->getreportfees($reportfees,$cashschemecode,$instcode);
								}
																
								$answer = $labssql->returninvetigationrequest($bcode,$returnreason,$reportfeesamout,$days,$currentusercode,$currentuser,$instcode);
						
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
	

	// 15 May 2022 
	case 'selectbulkspecimen':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$vccode = isset($_POST['vccode']) ? $_POST['vccode'] : '';
		$vcname = isset($_POST['vcname']) ? $_POST['vcname'] : '';
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
							$mivcode = $kt['0'];
							$requestcode = $kt['1'];
							$partnercost = $kt['2'];
							$labstate = $kt['3'];
							if($labstate !== '0'){
								$status = "error";
								$msg = "Already processed"; 
							}else{
															
								$samplecode = 'NA';
								$samplename = 'NA';	
								$batchnumber = $coder->getbatchnumber($instcode);
								$answer = $labssql->bulkselectspecimen($form_key,$batchnumber,$mivcode,$requestcode,$samplecode,$samplename,$days,$partnercost,$vccode,$vcname,$day,$currentusercode,$currentuser,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Selected $mivcode for  has been saved successfully ";
									$eventcode= 114;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Processed Successfully";		
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



	// 25 SEPT 2021 JOSEPH ADORBOE
	case 'manageeditlabsrequest':		
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
    
                    $answer = $labssql->editlabsmanage($visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                        
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

	// 20 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutlabssingle':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                $answer = $labssql->reverselabssentoutsingle($ekey,$currentusercode,$currentuser);
                        
                if ($answer == '1') {
                    $status = "error";
                    $msg = "Already Selected";
                }elseif($answer == '2') {
                    $event= "Reverser send out presccription ".$ekey." for  has been saved successfully ";
                    $eventcode= 161;
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if($audittrail == '2') {
                        $status = "success";
                        $msg = "Sent Out Successfully";
                    }else{
                        $status = "error";
                        $msg = "Audit Trail Failed!";
                    }
                }elseif ($answer == '0') {
                    $status = "error";
                    $msg = "Unsuccessful";
                }else{
                    $status = "error";
                    $msg = "Unknown Source";
                }
            }
			
			}
	break;


	// 20 JUNE 2021 JOSEPH ADORBOE 
	case 'labssentoutsearch': 

		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "labssendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "labssendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "labssendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "labssendout?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;

	// 18 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutlabs':		
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
							$labstate = $kt['5'];
							// $paymentmethodcode = $kt['4'];
							// $paymentschemecode = $kt['5'];
							// $pharmacystate = $kt['6'];
							// $serviceitem = $kt['7'];
							// $paymentmethod = $kt['8'];
							// $paymentscheme = $kt['9'];
							// $paymenttype = $kt['10'];
							// $billingcode = md5(microtime());
							// $depts = 'PHARMACY';

							if($labstate !== '8'){
								$status = "error";
								$msg = "Only Sentout Labs can be reversed "; 
							}else{								
							//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
								$answer = $labssql->reverselabssentout($bcode,$servicescode,$labstate,$currentusercode,$currentuser);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item SENT OUT REVERSED ".$bcode." for  has been saved successfully ";
									$eventcode= 162;
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

	
	// 08 JUNE 2021 JOSEPH ADORBOE 
	case 'labpricesearch': 

		$selectedone = isset($_POST['selectedone']) ? $_POST['selectedone'] : '';
		$selectedtwo = isset($_POST['selectedtwo']) ? $_POST['selectedtwo'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){			
			if(empty($selectedone) || empty($selectedtwo)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{							
					echo 'Welcome';
				}
		}

	break;

		// 01 JUN 2021 JOSEPH ADORBOE
		case 'sendout':		
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
								$labstate = $kt['6'];																	
								if($labstate !=='1'){
									$status = "error";
									$msg = "Only Unselected lab test can be Sent Out"; 
								}else{
																
								//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
									$answer = $labssql->labssentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser);
							
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

		
		// 08 APR 2021
		case 'archievesearch': 

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
							$url = "archieve?$form_key";
							$engine->redirect($url);

						}

					}

			}

		break;


		// 08 APR 2021
		case 'samplesearch': 

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
							$url = "sampleregistry?$form_key";
							$engine->redirect($url);

						}

					}

			}

		break;


	// 05 APR 2021
	case 'saveresults':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$testcode = isset($_POST['testcode']) ? $_POST['testcode'] : '';
		$test = isset($_POST['test']) ? $_POST['test'] : '';
		$resultval = isset($_POST['resultval']) ? $_POST['resultval'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$mivcode = isset($_POST['mivcode']) ? $_POST['mivcode'] : '';
		$completeresults = isset($_POST['completeresults']) ? $_POST['completeresults'] : '';			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{

				if(empty($mivcode) || empty($visitcode) || empty($testcode) || empty($requestcode) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{

					if($completeresults == 'NO'){
						$status = 'error';
						$msg = 'Select Result Complete';
					}else{			
								
						if(empty($_POST["scheckbox"])){   
							$status = "error";
							$msg = "Required Fields cannot be empty";	 
						}else{
								
							
						foreach($_POST["scheckbox"] as $key => $value){
							
							$resultval = $_POST['resultval'][$key];
						//	$resultvalue = $_POST['resultval'][$key];
							$kt = explode('@@@',$value);
							$attributecode = $kt['0'];
							$attribute = $kt['1'];
							$range = $kt['2'];
							$resultcode = md5(microtime());		
						//	die($resultval);					
							$answer = $labssql->labsresults($resultcode,$testcode,$test,$requestcode,$mivcode,$patientcode,$patientnumber,$patient,$visitcode,$days,$attributecode,$attribute,$range,$resultval,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode);
						
							
						//		var_dump($resultval);
						//		die($attribute);
						//		$answer = $labssql->labsresults($resultcode,$testcode,$test,$requestcode,$mivcode,$patientcode,$patientnumber,$patient,$visitcode,$days,$attributecode,$attribute,$range,$resultvalue,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode);
								$title = 'Test results';
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "".$title." for ".$test." successfully ";
									$eventcode= 112;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "".$title." saved Successfully";		
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

	
	// 05 APR 2021 JOSEPH ADORBOE 
	case 'addpatientsample':

		$mivcode = isset($_POST['mivcode']) ? $_POST['mivcode'] : '';
		$sample = isset($_POST['sample']) ? $_POST['sample'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$partnercost = isset($_POST['partnercost']) ? $_POST['partnercost'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($mivcode) ||  empty($sample) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				
				$samples = explode('@@@', $sample);
				$samplecode = $samples[0];
				$samplename = $samples[1];	
				$mcode = md5(microtime());
				$batchnumber = $coder->getbatchnumber($instcode);
				$addnew = $labssql->update_newsample($form_key,$batchnumber,$mivcode,$requestcode,$samplecode,$samplename,$days,$partnercost,$mcode,$day,$currentusercode,$currentuser,$instcode);
				$title = 'Patient Sample';
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add ".$title." for ".$samplename." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "".$title." ".$samplename." Exist"; 						
				}else if($addnew == '2'){
					$event= "".$title." Added successfully ";
					$eventcode= "118";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New ".$title." ".$samplename." Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
				
			}else{				
					$status = "error";					
					$msg = " Unknown source ";					
			}
			}
		}

	break;	


	// 04 APR 2021
	case 'sendforpayment':		
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
							$labstate = $kt['6'];
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];
							$billercode = $kt['10'];
							$biller = $kt['11'];
							$billingcode = md5(microtime());
							if($labstate !== '2'){
								$status = "error";
								$msg = "Only Selected lab test can be Sent for Payment"; 
							}else{								
								if($cost == '-1'){
									$status = "error";
									$msg = "Price has not been set"; 
								}else{								

							//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);
								
							$schemepricepercentage = $paymentschemetable->getschemepercentage($paymentschemecode,$instcode);
								$answer = $labssql->labssendtopayment($form_key,$billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item  ".$serviceitem." Sent for payment successfully ";
									$eventcode= 113;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										if($depts == 'IMAGING'){
											$billingcode = md5(microtime());
											$serviceamount = $pricing->getprice($cashpaymentmethodcode,$cashschemecode,$reportfees,$instcode,$cashschemecode,$ptype='OG',$instcodenuc);	
											$labssql->chargereportfees($form_key,$billingcode,$days,$day,$visitcode,$patientcode,$patientnumber,$patient,$reportfees,$serviceamount,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller);
										}
										$claimsnumber = $coder->getclaimsnumber($instcode);
									$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);	
											
										$status = "success";
										$msg = "Sent for payment Successfully";		
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


	// 31 JAN 2021
	case 'unselecttransaction':

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
								$msg = "Only Selected lab test can be selected"; 
							}else{
/*
							if($cost == '-1'){
								$status = "error";
								$msg = "Price has not been set"; 
							}else{
*/
						//		$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
					//	if($paymentmethodcode == "$cashpaymentmethodcode" || $paymentmethodcode == "$mobilemoneypaymentmethodcode" || $paymentmethodcode == "$prepaidcode" ){
								$answer = $labssql->labsunselectedlabs($bcode,$currentusercode,$currentuser);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Unselected $bcode for  has been saved successfully ";
									$eventcode= 114;
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
						
						// }else{
						// 	$status = "error";
						// 	$msg = "The Payment policy does not support patient payment method "; 
						// }
					//		}							
						}			
					}	
				}
			}
		}

	break;

	
	// 3 MAR 2021
	case 'setitemprice':
		
		$item = isset($_POST['item']) ? $_POST['item']: '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode']: '';
		$schemcode = isset($_POST['schemcode']) ? $_POST['schemcode']: '';
		$schemename = isset($_POST['schemename']) ? $_POST['schemename']: '';
		$method = isset($_POST['method']) ? $_POST['method']: '';
		$methodcode = isset($_POST['methodcode']) ? $_POST['methodcode']: '';
		$itemprice = isset($_POST['itemprice']) ? $_POST['itemprice']: '';
		$mdsitemprice = isset($_POST['mdsitemprice']) ? $_POST['mdsitemprice']: '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode']: '';
		$type = isset($_POST['type']) ? $_POST['type']: '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){			
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($itemprice) ){				
					$status = "error";
					$msg = "Required Fields cannot be empty";				
				}else{			
					$setprice = $labssql->setpricelabs($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$mdsitemprice,$currentuser,$currentusercode,$instcode);
					
					if($setprice == '0'){							
						$status = "error";					
						$msg = "New Price".$itemprice." Unsuccessful"; 
					}else if($setprice == '1'){						
						$status = "error";					
						$msg = "New Price ".$itemprice." Exist Already"; 							
					}else if($setprice == '2'){	
						$event= "New price set for: ".$item." for has been saved successfully ";
						$eventcode= 55;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "New price set for ".$item." Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}												
					}else{						
						$status = "error";					
						$msg = "Price query Unsuccessful "; 						
					}						
				}		
			}
		}
		
	break;

	
	// 31 JAN 2021
	case 'selecttransaction':		
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
				
				/*
					if($billcode == '0'){				
						$billcode = $coder->createbillcode($patientcode,$visitcode);
						$patientsbillstable->insertnewbills($billcode,$days,$patientcode,$patientnumber,$visitcode,$patient,$currentuser,$currentusercode,$instcode);
					}
				*/
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$labstate = $kt['6'];
							if($labstate !== '1'){
								$status = "error";
								$msg = "Only Unselected lab test can be selected"; 
							}else{
								/*
							if($cost == '-1'){
								$status = "error";
								$msg = "Price has not been set"; 
							}else{
								*/								
							
								//if($paymentmethodcode == "$cashpaymentmethodcode" || $paymentmethodcode == "$mobilemoneypaymentmethodcode" || $paymentmethodcode == "$prepaidcode" ){									
								
									$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
									$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
									$partneramount = $pricing->getpartnerrice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);
									$answer = $labssql->labsselectedlabs($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$serviceamount,$partneramount,$currentusercode,$currentuser);
							
									if($answer == '1'){
										$status = "error";
										$msg = "Already Selected";
									}else if($answer == '2'){
										$event= "Item Selected $bcode for  has been saved successfully ";
										$eventcode= 114;
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										if($audittrail == '2'){
											$status = "success";
											$msg = "Selected Successfully";		
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
								// }else{
								// 	$status = "error";
								// 	$msg = "The Payment policy does not support patient payment method "; 
								// }
						//	}
							}							
						}			
					}			
				}
		
			}
	break;

	
	
	// 29 MAR 2021
	case 'editattribute':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$attribute = isset($_POST['attribute']) ? $_POST['attribute'] : '';
		$range = isset($_POST['range']) ? $_POST['range'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($attribute) || empty($range) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					
					$attribute = strtoupper($attribute);
	
				$edit = $labssql->update_attribute($ekey,$attribute,$range,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Attribute ".$attribute." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Attribute ".$attribute." Exist"; 					
				}else if($edit == '2'){
					$event= "Attribute Edited successfully ";
					$eventcode= "115";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Attribute ".$attribute." edited Successfully";
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
	
	
	
	// 29 MAR 2021
	case 'addnewlabresultattribute':

		$attribute = isset($_POST['attribute']) ? $_POST['attribute'] : '';
		$range = isset($_POST['range']) ? $_POST['range'] : '';
		$testcode = isset($_POST['testcode']) ? $_POST['testcode'] : '';
		$testname = isset($_POST['testname']) ? $_POST['testname'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){
	
			if(empty($attribute) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$attribute = strtoupper($attribute);
				$addnew = $labssql->insert_newattribute($form_key,$attribute,$range,$testcode,$testname,$description,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Attribute ".$attribute." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Attribute ".$attribute." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Attribute Added successfully ";
					$eventcode= "116";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Attribute ".$attribute." Added Successfully";
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

		// 29 MAR 2021
	case 'addnewdiscpline':

	$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
	$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
	if($preventduplicate == '1'){

		if(empty($discipline) || empty($description) ){
			$status = 'error';
			$msg = 'Required Field Cannot be empty';				
		}else{
			$discipline = strtoupper($discipline);
			$addnew = $labssql->insert_newdiscipline($form_key,$discipline,$description,$currentusercode,$currentuser,$instcode);
			if($addnew == '0'){				
				$status = "error";					
				$msg = "Add New discipline ".$discipline." Unsuccessful"; 
			}else if($addnew == '1'){					
				$status = "error";					
				$msg = "New discipline ".$discipline." Exist"; 						
			}else if($addnew == '2'){
				$event= "Add New discipline Added successfully ";
				$eventcode= "120";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){				
					$status = "success";
					$msg = "New discipline ".$discipline." Added Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}	
			
		}else{				
				$status = "error";					
				$msg = " Unknown source ";					
		}
		}
	}

	break;
	
	// 29 MAR 2021
	case 'editdispline':

	$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
	$discpline = isset($_POST['discpline']) ? $_POST['discpline'] : '';
	$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
	$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
	$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
	
	if($preventduplicate == '1'){
		if(empty($discpline) || empty($storyline) ){
			$status = 'error';
			$msg = 'Required Field Cannot be empty';				
		}else{									
				
				$discpline = strtoupper($discpline);

			$edit = $labssql->update_discpline($ekey,$discpline,$storyline,$currentusercode,$currentuser,$instcode);
			
			if($edit == '0'){				
				$status = "error";					
				$msg = "Edit discpline ".$discpline." Unsuccessful"; 
			}else if($edit == '1'){				
				$status = "error";					
				$msg = "Edit discpline ".$discpline." Exist"; 					
			}else if($edit == '2'){
				$event= "discpline Edited successfully ";
				$eventcode= "191";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){			
					$status = "success";
					$msg = "discpline ".$discpline." edited Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}			
		}else{				
				$status = "error";					
				$msg = "Add Payment Method Unknown source "; 					
		}

		}
	}

	break;



	// 29 MAR 2021
	case 'editspecimen':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$specimen = isset($_POST['specimen']) ? $_POST['specimen'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($specimen) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					
					$specimen = strtoupper($specimen);

				$edit = $labssql->update_specimen($ekey,$specimen,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Specimen ".$specimen." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Specimen ".$specimen." Exist"; 					
				}else if($edit == '2'){
					$event= "Specimen Edited successfully ";
					$eventcode= "121";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Specimen ".$specimen." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Add Payment Method Unknown source "; 					
			}

			}
		}

	break;
	

	
	// 29 MAR 2021
	case 'editlabtest':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$labtest = isset($_POST['labtest']) ? $_POST['labtest'] : '';
		$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
		$storyline = isset($_POST['storyline']) ? $_POST['storyline'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if(empty($labtest) || empty($storyline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{									
					
				$labtest = strtoupper($labtest);
					$disc = explode('@@@', $discipline);
					$disccode = $disc[0];
					$discname = $disc[1];	
				$edit = $labssql->update_labtests($ekey,$labtest,$disccode,$discname,$storyline,$currentusercode,$currentuser,$instcode);
				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Lab Test ".$labtest." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Lab Test ".$labtest." Exist"; 					
				}else if($edit == '2'){
					$event= "Lab Test Edited successfully ";
					$eventcode= "117";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Lab Test ".$labtest." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Add Payment Method Unknown source "; 					
			}

			}
		}

	break;

	
	// 29 MAR 2021 addnewlabtest
	case 'addnewspecimen':

		$specimen = isset($_POST['specimen']) ? $_POST['specimen'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($specimen) || empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$specimen = strtoupper($specimen);
				$addnew = $labssql->insert_newspecimen($form_key,$specimen,$description,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Specimen ".$specimen." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Specimen ".$specimen." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Specimen Added successfully ";
					$eventcode= "122";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New Specimen ".$specimen." Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
				
			}else{				
					$status = "error";					
					$msg = " Unknown source ";					
			}
			}
		}

	break;

	// 30 MAR 2021 
	case 'addnewlabtest':

		$labtest = isset($_POST['labtest']) ? $_POST['labtest'] : '';
		$discipline = isset($_POST['discipline']) ? $_POST['discipline'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
		if($preventduplicate == '1'){

			if(empty($labtest) ||  empty($discipline) ||  empty($description) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$labtest = strtoupper($labtest);
				$disc = explode('@@@', $discipline);
				$disccode = $disc[0];
				$discname = $disc[1];	
				$addnew = $labssql->insert_newlabstest($form_key,$labtest,$disccode,$discname,$description,$currentusercode,$currentuser,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Lab Test ".$labtest." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Lab Test ".$labtest." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Lab Test Added successfully ";
					$eventcode= "118";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Lab Test ".$labtest." Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
				
			}else{				
					$status = "error";					
					$msg = " Unknown source ";					
			}
			}
		}

	break;	
		
}

	function labmenu(){
		?>
		<div class="col-md-8">
			<a href='labsrequests' class="btn btn-info">Lab Request</a>
			<a href='processpartnerlabs' class="btn btn-secondary">Partner Labs</a>	
			<a href='pendingresults' class="btn btn-warning">Pending Results</a>
			<a href='labreports' class="btn btn-primary">Report</a>																	
		</div>	
		<?php
	}

	function labreportmenu($idvalue){
		?>
		<div class="col-md-8">
			<a href="labreports" class="btn btn-dark">Back</a>
			<a href='labsrequestreportdetails?<?php echo $idvalue; ?>' class="btn btn-info">Nornial List</a>
			<a href='labsrequestreportpatientdetails?<?php echo $idvalue; ?>' class="btn btn-secondary">Patient Labs</a>	
			<a href='labsrequestreportlabsdetails?<?php echo $idvalue; ?>' class="btn btn-warning">Lab List</a>
			<a href='labsrequestreportdoctordetails?<?php echo $idvalue; ?>' class="btn btn-primary">Doctor List</a>																	
		</div>	
		<?php
	}

 	// $speciementlist = ("SELECT * from octopus_st_labspecimen where SP_STATUS = '1' ");
	// $getspeciementlist = $dbconn->query($speciementlist);
	// $discplinelist = ("SELECT * from octopus_st_labdiscipline where LD_STATUS = '1' ");
	// $getdiscplinelist = $dbconn->query($discplinelist);
	
?>
