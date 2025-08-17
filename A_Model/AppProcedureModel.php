 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$proceduremodel = htmlspecialchars(isset($_POST['proceduremodel']) ? $_POST['proceduremodel'] : '');
	
	// 02 OCT 2022 
switch ($proceduremodel)
{

	// 30 oct 2023,  16 JULY 2021 JOSEPH ADORBOE
	case 'selecttransaction':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');	
		$validinsurance = htmlspecialchars(isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '');					
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
							$procedurestate = $kt['6'];
							$med = $kt['7'];
							$scheme = $kt['9'];
							$qty = $kt['10'];

							if($procedurestate !== '1'){
								$status = "error";
								$msg = "Only Unselected Procedure can be selected"; 
							}else{
								
								$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
								$title = 'Procedure Selected';
								if($paymentmethodcode == $cashpaymentmethodcode){
									$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
								if($serviceamount == '-1'){
									$totalamount = '-1';	
								}else{
									$totalamount = $serviceamount*$qty;
								}
								
								$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
								$action = "Procedure Selected";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=390;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
								// momo
								}else if($paymentmethodcode == $mobilemoneypaymentmethodcode){

								$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
								if($serviceamount == '-1'){
									$totalamount = '-1';	
								}else{
									$totalamount = $serviceamount*$qty;
								}
								$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
								$action = "Procedure Selected";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=390;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
								
							
								// private insurnace
								}else if($paymentmethodcode == $privateinsurancecode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient $patient does not have a valid insurance ";
									} else {
										$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
										if ($insurancechecks == '-1') {
											$status = "error";
											$msg = "The patient $patient does not have a current insurance Policy ";
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
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;	
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);												
											}
										}
									}


								// partner companies 
								}else if($paymentmethodcode == $partnercompaniescode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient $patient does not have a valid insurance ";
									} else {
										$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
										if ($insurancechecks == '-1') {
											$status = "error";
											$msg = "The patient $patient does not have a current insurance Policy ";
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
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;	
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
									
												
											}
										}
									}


								// nhis
								}else if($paymentmethodcode == $nationalinsurancecode){
									if ($validinsurance == 'NO') {
										$status = "error";
										$msg = "The patient $patient does not have a valid insurance ";
									} else {
										$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
										if ($insurancechecks == '-1') {
											$status = "error";
											$msg = "The patient $patient does not have a current insurance Policy ";
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
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
												
											}
										}
									}


								// others
								}else {
									$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
									if($serviceamount == '-1'){
										$totalamount = '-1';	
									}else{
										$totalamount = $serviceamount*$qty;
									}
									
									$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
								$action = "Procedure Selected";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=390;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}
						
							}							
						}			
					}			
				}
		
			}
	break;

	// 30 OCT 2023, 16 JULY 2021 JOSEPH ADORBOE
	case 'manageeditprocedurerequest':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$payment = htmlspecialchars(isset($_POST['payment']) ? $_POST['payment'] : '');		
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
                    $sqlresults = $patientproceduretable->editproceduremanage($visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                	$action = "Procedure Manage";
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=391;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
					
                }
            }
			
			}
	break;

	
	// 20 Sept 2023, 15 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutprocedure':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');			
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
							$depts = 'PROCEDURE';

							if($pharmacystate !== '8'){
								$status = "error";
								$msg = "Only Sentout Pescription can be reversed "; 
							}else{								
							//	$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
								
								$sqlresults = $patientproceduretable->sendoutprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
								$action = "Return Request saved";
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=483;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						
								
							}							
						}			
					}			
				}
		
			}
	break;

	// 20 SEPT 2023, 2 OCT 2022 JOSEPH ADORBOE 
	case 'returnprocedures':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
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
								$msg = "Procedure cannot be returned because it has not been dispensed"; 
							}else{								
								$sqlresults = $patientproceduretable->returnprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
								$action = "Return Request saved";
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=483;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						
							}							
						}			
					}			
				}
		
			}
	break;
	
	// 02 OCT 2022 JOSEPH ADORBOE
	case 'bulkprocedurearchive':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');						
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
								$results = $patientproceduretable->editpharamcyarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode);
						
								if($results == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($results == '2'){
									$event= "Archived $ekey Prescriptions Successfully ";
									$eventcode= 156;
									$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
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

