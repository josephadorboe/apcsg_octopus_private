<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$cashierwalletmodel = isset($_POST['cashierwalletmodel']) ? $_POST['cashierwalletmodel'] : '';
	
	// 15 JUNE 2022 JOSEPH ADORBOE  
switch ($cashierwalletmodel)
{
	// 15 JUNE 2022 JOSEPH ADORBOE 
	case 'receivepayments':

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertilcode = isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$amountpaid = isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '';
		$descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : '';		
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';	
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';		
		$bkey = isset($_POST['bkey']) ? $_POST['bkey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';		
		$walletbalance = isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '';
		$paymentscheme = isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '';
		// $paymentschemestate = isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '';
		// $chequenumber = isset($_POST['chequenumber']) ? $_POST['chequenumber'] : '';
		// $banks = isset($_POST['banks']) ? $_POST['banks'] : '';
		// $insurancebal = isset($_POST['insurancebal']) ? $_POST['insurancebal'] : '';
		$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
		// $payingtype = isset($_POST['payingtype']) ? $_POST['payingtype'] : '';
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
					// if($cashiertill == '0'){					
					// 	$status = "error";
					// 	$msg = "Cashier Tills is not open. Please open one now.";				
					// }else{ 	
						if(empty($paymentscheme) || empty($descriptions) || empty($amountpaid)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{				
							if(!is_numeric($amountpaid)){					
								$status = 'error';
								$msg = 'Amount Paid Should be Numbers Only.';
							}else{
								if($amountpaid<'1'){
									$status = 'error';
									$msg = 'Amount Paid is not a valid number';
								}else{								

								$paytype = explode('@@@',$paymentscheme);
								$paycode = $paytype['0'];
								$payname = $paytype['1'];
								$paymethcode = $paytype['2'];
								$paymeth = $paytype['3'];	
								
								$paymentschemestate = $paymentschemetable->getpaymentschemestate($paycode,$instcode);
								
								if($paymentschemestate == '0'){
									$status = 'error';
									$msg = "Payment Scheme $payname Has been suspended";
								}else if($paymentschemestate == '1'){
								//	$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);	
									$days = date('Y-m-d h:i:s')	;
															
									if($paymethcode == $cashpaymentmethodcode){
												$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
												if($patientcredits == '1'){
													// Patient has not active credit
													$state = 'PAID';
												//	$chang = $amountpaid - $totalamount;
													$chang = '0';
													$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
													$cashiertillcode = md5(microtime());
													$billingpaymentcode = md5(microtime());
														
													$generatereciept = $cashierwalletsql->generatewalletreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear);
													$title = 'Payment';
													if($generatereciept == '0'){						
														$status = 'error';
														$msg = ''.$title.' Unsuccessful';						
													}else if($generatereciept == '1'){						
														$status = 'error';
														$msg = ''.$title.' Already done';						
													}else if($generatereciept == '2'){
														$cashierwalletsql->cashierwallettillsoperations($form_key,$day, $currentshift,$currentusercode,$paycode,$payname,$paymethcode,$paymeth,$amountpaid,$currentuser,$currentshiftcode,$instcode);
														$event= " $title done $form_key successfully";
														$eventcode= 51;
														$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
														if($audittrail == '2'){
															$status = "success";
															$msg = "$title for $patient Successfully";	
															$url = "cashier__receiptwalletdetails?$form_key";
															$engine->redirect($url);	
														}else{
															$status = "error";					
															$msg = "Audit Trail Failed!"; 
														}																
													}else{						
														$status = 'error';
														$msg = 'Unknown Source';						
													}
												}else{
													$status = "error";					
													$msg = "Patient has an active credit to pay. Please clear at manage credit!"; 
												}											
									// momo
									}else if($paymethcode == $mobilemoneypaymentmethodcode){									
											$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
											if($patientcredits == '1'){ 
												   if(empty($phonenumber) ){
														$status = "error";					
														$msg = "Phone Number is mandatory!";
												   }else{												
												$state = 'MOMO PAID';
												$chang = '0';
												$cashiertillcode = md5(microtime());
												$billingpaymentcode = md5(microtime());
													
												$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
												$generatereciept = $cashierwalletsql->generatewalletreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear);
												$title = 'Payment';
												if($generatereciept == '0'){						
													$status = 'error';
													$msg = ''.$title.' Unsuccessful';						
												}else if($generatereciept == '1'){						
													$status = 'error';
													$msg = ''.$title.' Already done';						
												}else if($generatereciept == '2'){
													$cashierwalletsql->cashierwallettillsoperations($form_key,$day, $currentshift,$currentusercode,$paycode,$payname,$paymethcode,$paymeth,$amountpaid,$currentuser,$currentshiftcode,$instcode);
														
													$event= "$title done $form_key successfully ";
													$eventcode= 51;
													$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
													if($audittrail == '2'){
														$status = "success";
														$msg = "$title for $patient Successfully";	
														$url = "cashier__receiptwalletdetails?$form_key";
														$engine->redirect($url);	
													}else{
														$status = "error";					
														$msg = "Audit Trail Failed!"; 
													}																
												}else{						
													$status = 'error';
													$msg = 'Unknown Source';						
												}
											}

											}else{
												$status = "error";					
												$msg = "Ptient has an active credit to pay. Please clear at manage credit!"; 
											}

								}else{
									$status = "error";					
									$msg = "Invalid Payment Method"; 
								}								
						}					
					}
				}
		
			
			}
		}
	}

	break;
	
	
	// 15 JUNE 2022 JOSEPH ADORBOE 
	case 'walletsearch':		
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
				$url = "cashier__managepatientwallet?$form_key";
				$engine->redirect($url);
				}
			}
		}
	break;



}
	

?>
