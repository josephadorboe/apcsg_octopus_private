<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	$promotionwalletmodel = htmlspecialchars(isset($_POST['promotionwalletmodel']) ? $_POST['promotionwalletmodel'] : '');
	
	// 29 DEC 2024, JOSEPH ADORBOE  
switch ($promotionwalletmodel)
{
	// 12 SEPT 2023, 15 JUNE 2022 JOSEPH ADORBOE 
	case 'receivewalletpayments':
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$cashiertilcode = htmlspecialchars(isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '');
		$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
		$patientpaymenttype = htmlspecialchars(isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '');
		$amountpaid = htmlspecialchars(isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '');
		$descriptions = htmlspecialchars(isset($_POST['descriptions']) ? $_POST['descriptions'] : '');		
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');	
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');		
		$bkey = htmlspecialchars(isset($_POST['bkey']) ? $_POST['bkey'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$promotiontotal = htmlspecialchars(isset($_POST['promotiontotal']) ? $_POST['promotiontotal'] : '');
		$promotioncode = htmlspecialchars(isset($_POST['promotioncode']) ? $_POST['promotioncode'] : '');
		$procode = htmlspecialchars(isset($_POST['procode']) ? $_POST['procode'] : '');
		$prounit = htmlspecialchars(isset($_POST['prounit']) ? $_POST['prounit'] : '');
		$promotionvaildity = htmlspecialchars(isset($_POST['promotionvaildity']) ? $_POST['promotionvaildity'] : '');
		$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');		
		$walletbalance = htmlspecialchars(isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$phonenumber = htmlspecialchars(isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
						if(empty($paymentscheme) || empty($descriptions) || empty($amountpaid)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{				
							if(!is_numeric($amountpaid)){					
								$status = 'error';
								$msg = 'Amount Paid Should be Numbers Only.';
							}else{
								if($amountpaid < '1'){
									$status = 'error';
									$msg = 'Amount Paid is not a valid number';
								}else if($amountpaid !== $promotiontotal){
									$status = 'error';
									$msg = "$amountpaid Amount Paid is NOT equal to total $promotiontotal ";
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
								//	$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);	
									$days = date('Y-m-d h:i:s')	;									
									$vday = ' + '.$promotionvaildity.' days';
									$enddate = date('Y-m-d', strtotime($day. $vday));
													
									if($paymethcode == $cashpaymentmethodcode){
												$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
												if($patientcredits == '1'){
													// Patient has not active credit
													$state = 'PAID';												
													$chang = '0';
													$receiptnumber = rand(10,99).date("His");
													// $currenttable->getlastestreceiptnumber($instcode);
													$cashiertillcode = md5(microtime());
													$billingpaymentcode = md5(microtime());
														
													$sqlresults = $walletoperationcontroller->generatewalletoperationreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear,$depositcode,$depositscheme,$patientreceipttable,$patientschemetable,$currenttable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable);
													if($sqlresults == '2'){
														$two = '2';														
														$sqlresults = $patientpromotiontable->activatepromotion($promotioncode,$enddate,$day,$two,$currentusercode,$currentuser,$instcode);
														$promotionsetuptable->updateaddpromotionsubscriber($procode,$prounit,$amountpaid,$instcode);
													}																		
													$action = "Payment Receipt";							
													$result = $engine->getresults($sqlresults,$item=$receiptnumber,$action);
													$re = explode(',', $result);
													$status = $re[0];					
													$msg = $re[1];
													$event= "$action: $form_key $msg";
													$eventcode=9740;
													$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
													
												}else{
													$status = "error";					
													$msg = "Patient has an active credit to pay. Please clear at manage credit!"; 
												}											
									// momo
									}else if($paymethcode == $mobilemoneypaymentmethodcode){									
											$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
											if($patientcredits == '1'){ 
												   if(empty($phonenumber) ){
														$status = "error";					
														$msg = "Phone Number is mandatory!";
													}else{												
														$state = 'MOMO PAID';
														$chang = '0';
														$cashiertillcode = md5(microtime());
														$billingpaymentcode = md5(microtime());
															
														$receiptnumber = date("His").rand(10,99);
														$sqlresults = $walletoperationcontroller->generatewalletoperationreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear,$depositcode,$depositscheme,$patientreceipttable,$patientschemetable,$currenttable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable);																		if($sqlresults == '2'){
															$two = '2';														
															$sqlresults = $patientpromotiontable->activatepromotion($promotioncode,$enddate,$day,$two,$currentusercode,$currentuser,$instcode);
														}	
															$action = "Payment Receipt ";							
															$result = $engine->getresults($sqlresults,$item=$receiptnumber,$action);
															$re = explode(',', $result);
															$status = $re[0];					
															$msg = $re[1];
															$event= "$action: $form_key $msg";
															$eventcode=9740;
															$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
													}

											}else{
												$status = "error";					
												$msg = "Patient has an active credit to pay. Please clear at manage credit!"; 
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
	
	
	// // 15 JUNE 2022 JOSEPH ADORBOE 
	// case 'walletsearch':		
	// 	$patientrecords = htmlspecialchars(isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '');		
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 		if($currentshiftcode == '0'){			
	// 			$status = "error";
	// 			$msg = "Shift is closed";				
	// 		}else{
	// 		if(empty($patientrecords) ){
	// 			$status = "error";
	// 			$msg = "Required Fields cannot be empty ";
	// 		}else{					
	// 			$value = $patientrecords;
	// 			$msql->passingvalues($pkey=$form_key,$value);					
	// 			$url = "cashier__managepatientwallet?$form_key";
	// 			$engine->redirect($url);
	// 			}
	// 		}
	// 	}
	// break;

}
	

?>
