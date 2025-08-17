<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	$transmodel = htmlspecialchars(isset($_POST['transmodel']) ? $_POST['transmodel'] : '');	
	// 23 AUG 2023 JOSEPH ADORBOE  
	switch ($transmodel)
	{

		// 14 SEPT 2023
		case 'sendback':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$sendbackreason = htmlspecialchars(isset($_POST['sendbackreason']) ? $_POST['sendbackreason'] : '');				
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){	
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
				if(empty($_POST["unscheckbox"]) || empty($sendbackreason)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{
					
						foreach($_POST["unscheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
							$state = $kt['7'];
							$tdate = $kt['8'];
							$itemqty = $kt['9'];
							$itemcode = $kt['10'];
							if($state !== '1'){
								$status = "error";
								$msg = "Only Unselected Transactions can be changed"; 							
							}else{
								$sqlresults = $billprocessingcontroller->cashiersendbacktransactions($bcode,$servicecode,$dpts,$sendbackreason,$visitcode,$days,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
									$action = 'Send Back Transaction';							
									$result = $engine->getresults($sqlresults,$item='Item',$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=13;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
							}							
						}							
					}
				}		
			}
		break;

		//  22 JAN 2023 
	case 'bookpayments':
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$cashiertilcode = htmlspecialchars(isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '');
		$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
		$patientpaymenttype = htmlspecialchars(isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '');
		$amountpaid = htmlspecialchars(isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '');
		$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');		
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');	
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');		
		$bkey = htmlspecialchars(isset($_POST['bkey']) ? $_POST['bkey'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');		
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
		$paymentschemestate = htmlspecialchars(isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '');
		$chequenumber = htmlspecialchars(isset($_POST['chequenumber']) ? $_POST['chequenumber'] : '');
		$banks = htmlspecialchars(isset($_POST['banks']) ? $_POST['banks'] : '');
		$insurancebal = htmlspecialchars(isset($_POST['insurancebal']) ? $_POST['insurancebal'] : '');
		$phonenumber = htmlspecialchars(isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '');
		$payingtype = htmlspecialchars(isset($_POST['payingtype']) ? $_POST['payingtype'] : '');
		$transactionday = htmlspecialchars(isset($_POST['transactionday']) ? $_POST['transactionday'] : '');
		$transactionmonth = htmlspecialchars(isset($_POST['transactionmonth']) ? $_POST['transactionmonth'] : '');
		$transactionyear = htmlspecialchars(isset($_POST['transactionyear']) ? $_POST['transactionyear'] : '');
		$transactionshiftcode = htmlspecialchars(isset($_POST['transactionshiftcode']) ? $_POST['transactionshiftcode'] : '');
		$transactionshift = htmlspecialchars(isset($_POST['transactionshift']) ? $_POST['transactionshift'] : '');
		$transactiondate = htmlspecialchars(isset($_POST['transactiondate']) ? $_POST['transactiondate'] : '');								
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{				
						if(empty($totalamount) || empty($patientpaymenttype) || empty($amountpaid)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{	
									
							if($amountpaid !== $totalamount){					
								$status = 'error';
								$msg = "Amount to be Paid $amountpaid is NOT equal to total Amount $totalamount";
							}else{

								$paytype = explode('@@@',$patientpaymenttype);
								$paycode = $paytype['0'];
								$payname = $paytype['1'];
								$paymethcode = $paytype['2'];
								$paymeth = $paytype['3'];
								$payplan = $paytype['4'];	
								
								if(!empty($banks)){
									$bk = explode('@@@', $banks);
									$bankname = $bk['1'];
									$bankcode = $bk['0'];
								}else{
									$bankname=$bankcode = '';
								}

								$paymentschemestate = $paymentschemetable->getpaymentschemestate($paycode,$instcode);
																
								if($paymentschemestate == '0'){
									$status = 'error';
									$msg = "Payment Scheme $payname Has been suspended";
								}else if($paymentschemestate == '1'){
									$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);	
									$fkey = md5(microtime());
									$days = date('Y-m-d h:i:s')	;
								
								if($paymethcode == $privateinsurancecode){
									$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
									$tillcode = md5(microtime());
									$insurancetillcode = $cashiertillstable->getinsurancetillcode($paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift);
									$tillcode = md5(microtime());
									$insurancesummarycode = $cashiersummarytable->getinsurancesummarycode($tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift);
									$billingcode = md5(microtime());
									if($patientcredits == '1'){
										if(empty($amountpaid) || $amountpaid !== $totalamount) {
											$status = "error";					
											$msg = "Insurance Balance is mandatory or insurance balance is insufficent!";
										}else{
											$state = 'PRIVATE INSURANCE TO PAY';
											$chang = $amountpaid - $totalamount;
											//	$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
											$sqlresults = $billprocessingcontroller->generatereceiptdefered($form_key,$day,$days,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift,$currenttable,$patientreceipttable,$patientbillitemtable,$patientsbillstable,$patientdiscounttable,$patientbillingtable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable,$patientsMedicalreportstable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable);																								
											if($sqlresults == '2'){
												$patcontact = $patientcontactstable->getpatientcontactdetails($patientcode,$instcode);
												$pdc = explode('@', $patcontact);
												$patientphonenumber = $pdc[0];
												$altpatientphonenumber = $pdc[1];
												$patientemail = $pdc[3];
												$octopuspatientsuserstable->newoctopususer($patientcode,$patientnumber,$patient,$patientphonenumber,$altpatientphonenumber,$patientemail,$currentusercode,$currentuser,$currentuserinst,$instcode);
											}
											$action = 'Transaction Processed';							
											$result = $engine->getresults($sqlresults,$item=$patient,$action);
											$re = explode(',', $result);
											$status = $re[0];					
											$msg = $re[1];
											$event= "$action: $form_key $msg";
											$eventcode=51;
											$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
											if($sqlresults == "2"){
												$url = "receiptdetails?$form_key";
												$engine->redirect($url);	
											}
												
											}
											}else{
												$status = "error";					
												$msg = "Patient has an active credit to pay. Please clear at manage credit!"; 
											}

								// National insurance 
							}else if($paymethcode == $nationalinsurancecode){
								$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
											$tillcode = md5(microtime());
											$insurancetillcode = $cashiertillstable->getinsurancetillcode($paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift);
											$tillcode = md5(microtime());
											$insurancesummarycode = $cashiersummarytable->getinsurancesummarycode($day,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$billingcode = md5(microtime());											
									
								$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = 'NHIS PAID';
									$chang = $amountpaid - $totalamount;
								//	$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
									$sqlresults = $billprocessingcontroller->generatereceiptdefered($form_key,$day,$days,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift,$currenttable,$patientreceipttable,$patientbillitemtable,$patientsbillstable,$patientdiscounttable,$patientbillingtable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable,$patientsMedicalreportstable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable);
									if($sqlresults == '2'){
										$patcontact = $patientcontactstable->getpatientcontactdetails($patientcode,$instcode);
										$pdc = explode('@', $patcontact);
										$patientphonenumber = $pdc[0];
										$altpatientphonenumber = $pdc[1];
										$patientemail = $pdc[3];
										$octopuspatientsuserstable->newoctopususer($patientcode,$patientnumber,$patient,$patientphonenumber,$altpatientphonenumber,$patientemail,$currentusercode,$currentuser,$currentuserinst,$instcode);
									}
									$action = 'Transaction Processed';							
									$result = $engine->getresults($sqlresults,$item=$patient,$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=51;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
									if($sqlresults == "2"){
										$url = "receiptdetails?$form_key";
										$engine->redirect($url);	
									}
									
								}else{
									$status = "error";					
									$msg = "Ptient has an active credit to pay. Please clear at manage credit!"; 
								}

							// partner insurance
							}else if($paymethcode == $partnercompaniescode){
								$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
								$tillcode = md5(microtime());
								$insurancetillcode = $cashiertillstable->getinsurancetillcode($paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift);
								$tillcode = md5(microtime());
								// cashiersummarytable
								$insurancesummarycode = $cashiersummarytable->getinsurancesummarycode($tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift);
								$billingcode = md5(microtime());	
						
								$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = "PARTNER COMPANY PAID";
									$chang = $amountpaid - $totalamount;
									$sqlresults = $billprocessingcontroller->generatereceiptdefered($form_key,$day,$days,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift,$currenttable,$patientreceipttable,$patientbillitemtable,$patientsbillstable,$patientdiscounttable,$patientbillingtable,$patientbillingpaymenttable,$cashiertillstable,$cashiersummarytable,$patientsMedicalreportstable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable);
									if($sqlresults == '2'){
										$patcontact = $patientcontactstable->getpatientcontactdetails($patientcode,$instcode);
										$pdc = explode('@', $patcontact);
										$patientphonenumber = $pdc[0];
										$altpatientphonenumber = $pdc[1];
										$patientemail = $pdc[3];
										$octopuspatientsuserstable->newoctopususer($patientcode,$patientnumber,$patient,$patientphonenumber,$altpatientphonenumber,$patientemail,$currentusercode,$currentuser,$currentuserinst,$instcode);
									}
									$action = 'Transaction Processed';							
									$result = $engine->getresults($sqlresults,$item=$patient,$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=51;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);											
									if($sqlresults == "2"){
										$url = "receiptdetails?$form_key";
										$engine->redirect($url);	
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
	break;

		// 30 OCT 2021 JOSEPH ADORBOE 
	case 'processcopayment':
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$cashiertilcode = htmlspecialchars(isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '');
		$totalamount = htmlspecialchars(isset($_POST['totalamount']) ? $_POST['totalamount'] : '');
		$patientpaymenttype = htmlspecialchars(isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '');
		$amountpaid = htmlspecialchars(isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '');
		$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');		
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');	
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');		
		$bkey = htmlspecialchars(isset($_POST['bkey']) ? $_POST['bkey'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');		
		$billingcode = htmlspecialchars(isset($_POST['billingcode']) ? $_POST['billingcode'] : '');
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
		$paymentschemestate = htmlspecialchars(isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '');
		$chequenumber = htmlspecialchars(isset($_POST['chequenumber']) ? $_POST['chequenumber'] : '');
		$banks = htmlspecialchars(isset($_POST['banks']) ? $_POST['banks'] : '');
		$insurancebal = htmlspecialchars(isset($_POST['insurancebal']) ? $_POST['insurancebal'] : '');
		$phonenumber = htmlspecialchars(isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '');
		$payingtype = htmlspecialchars(isset($_POST['payingtype']) ? $_POST['payingtype'] : '');
		$totalgeneratedamount = htmlspecialchars(isset($_POST['totalgeneratedamount']) ? $_POST['totalgeneratedamount'] : '');
		$totalgeneratedamountpaid = htmlspecialchars(isset($_POST['totalgeneratedamountpaid']) ? $_POST['totalgeneratedamountpaid'] : '');
		$totalgeneratedamountbal = htmlspecialchars(isset($_POST['totalgeneratedamountbal']) ? $_POST['totalgeneratedamountbal'] : '');		
		$patientwallet = htmlspecialchars(isset($_POST['patientwallet']) ? $_POST['patientwallet'] : '');	
		$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
					
						if(empty($totalgeneratedamount) || empty($patientpaymenttype) || empty($totalgeneratedamountbal)  || empty($amountpaid) || empty($billingcode)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{				
								$paytype = explode('@@@',$patientpaymenttype);
								$paycode = $paytype['0'];
								$payname = $paytype['1'];
								$paymethcode = $paytype['2'];
								$paymeth = $paytype['3'];	
								
								if(!empty($banks)){
									$bk = explode('@@@', $banks);
									$bankname = $bk['1'];
									$bankcode = $bk['0'];
								}else{
									$bankname=$bankcode = '';
								}
								$paymentschemestate = $paymentschemetable->getpaymentschemestate($paycode,$instcode);								
								if($paymentschemestate == '0'){
									$status = 'error';
									$msg = 'Payment Scheme '.$payname.' Has been suspended';
								}else if($paymentschemestate == '1'){
									$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);	
									$days = date('Y-m-d h:i:s')	;
									
									if($paymethcode == $creditcode){
										$status = 'error';
										$msg = 'Patient has no Active Credit';												
									}else if($paymethcode == $cashpaymentmethodcode){																	
												$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
												if($patientcredits == '1'){
		
													$state = 'PAID';													
													if($paycode == $cashdollar ){														
														$exchangerate = $cashierforextable->getexchangerate('USDOLLARS',$day,$instcode); 												                                        
														if($exchangerate == '-1'){
															$status = "error";
															$msg = "Forex rate for $day has not been set";
														}else{
															$foreigncurrency = $amountpaid;
															$amountpaid = $amountpaid*$exchangerate;
														if($amountpaid>$totalgeneratedamountbal){
															$chang = $amountpaid - $totalgeneratedamountbal;
														}else{
															$chang = $totalgeneratedamountbal-$amountpaid ;
														}
														$bal = $totalgeneratedamountbal - $amountpaid;
														if($bal<'0'){
															$bal = '0';
														}

														$payname = $payname.'@'.$exchangerate;

														if($amountpaid<$totalgeneratedamountbal){
															$amountdeducted = $amountpaid;
														}else if($amountpaid==$totalgeneratedamountbal){
															$amountdeducted = $amountpaid;
														}else if($amountpaid>$totalgeneratedamountbal){
															$amountdeducted = $totalgeneratedamountbal;
														}												

														}

													}else{
														$foreigncurrency = '0';
														if($amountpaid>$totalgeneratedamountbal){
															$chang = $amountpaid - $totalgeneratedamountbal;
														}else{
															$chang = $totalgeneratedamountbal-$amountpaid ;
														}
														$bal = $totalgeneratedamountbal - $amountpaid;
														if($bal<'0'){
															$bal = '0';
														}

														if($amountpaid<$totalgeneratedamountbal){
															$amountdeducted = $amountpaid;
														}else if($amountpaid==$totalgeneratedamountbal){
															$amountdeducted = $amountpaid;
														}else if($amountpaid>$totalgeneratedamountbal){
															$amountdeducted = $totalgeneratedamountbal;
														}
													}

													$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
													$cashiertillcode = md5(microtime());

													$sqlresults = $billprocessingcontroller->makecopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$foreigncurrency,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$cashiertillstable,$cashiersummarytable);
													
													$action = "Payment Received";
													$result = $engine->getresults($sqlresults,$item=$patient,$action);
													$re = explode(',', $result);
													$status = $re[0];					
													$msg = $re[1];
													$event= "$action: $form_key $msg";
													$eventcode=487;
													$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
													if($sqlresults == '2'){
														if($bal>'0'){
															$status = "success";
															$msg = "$action for $patient Successfully";
														}else if($bal == '0'){
															$amountpaid = intval($totalgeneratedamountpaid) + intval($amountpaid);
															$generatereciept = $billprocessingcontroller->generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode,$patientreceipttable,$patientbillitemtable,$patientbillingtable,$patientdiscounttable,$patientsbillstable,$patientbillingpaymenttable,$currenttable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);											
															$status = "success";
															$msg = "$action for $patient Successfully";																
															$url = "receiptdetails?$form_key";
															$engine->redirect($url);	
														}
													}													
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
												if($amountpaid>$totalgeneratedamountbal){
													$chang = $amountpaid - $totalgeneratedamountbal;
												}else{
													$chang = $totalgeneratedamountbal-$amountpaid ;
												}
												$bal = $totalgeneratedamountbal - $amountpaid;
												if($bal<'0'){
													$bal = '0';
												}
												if($amountpaid<$totalgeneratedamountbal){
													$amountdeducted = $amountpaid;
												}else if($amountpaid==$totalgeneratedamountbal){
													$amountdeducted = $amountpaid;
												}else if($amountpaid>$totalgeneratedamountbal){
													$amountdeducted = $totalgeneratedamountbal;
												}
												$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
												$foreigncurrency = '0';

												$cashiertillcode = md5(microtime());

												$sqlresults = $billprocessingcontroller->makecopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$foreigncurrency,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$cashiertillstable,$cashiersummarytable);
												$action = "Payment Received";
													$result = $engine->getresults($sqlresults,$item=$patient,$action);
													$re = explode(',', $result);
													$status = $re[0];					
													$msg = $re[1];
													$event= "$action: $form_key $msg";
													$eventcode=487;
													$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
													if($sqlresults == '2'){
														if($bal>'0'){
															$status = "success";
															$msg = "$action for $patient Successfully";
														}else if($bal == '0'){
															$amountpaid = intval($totalgeneratedamountpaid) + intval($amountpaid);
															$generatereciept = $billprocessingcontroller->generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode,$patientreceipttable,$patientbillitemtable,$patientbillingtable,$patientdiscounttable,$patientsbillstable,$patientbillingpaymenttable,$currenttable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);											
															$status = "success";
															$msg = "$action for $patient Successfully";																
															$url = "receiptdetails?$form_key";
															$engine->redirect($url);	
														}
													}											
											}

											}else{
												$status = "error";					
												$msg = "Ptient has an active credit to pay. Please clear at manage credit!"; 
											}
								// cheques
							}else if($paymethcode == $chequescode){
									
								$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
								if($patientcredits == '1'){ 
									   if(empty($chequenumber) || empty($banks) ){
											$status = "error";					
											$msg = "Cheque number or banks is mandatory!";
									   }else{
										 
										$bk = explode('@@@',$banks);
										$bankscode = $bk['0'];
										$banks = $bk['1']; 									   
									
									$state = 'CHEQUE PAID';
									$chang = $amountpaid - $totalgeneratedamount;
									$bal = $totalgeneratedamountbal - $amountpaid;
									$foreigncurrency = '0';
									$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
									$cashiertillcode = md5(microtime());
									if($amountpaid<$totalgeneratedamountbal){
										$amountdeducted = $amountpaid;
									}else if($amountpaid==$totalgeneratedamountbal){
										$amountdeducted = $amountpaid;
									}else if($amountpaid>$totalgeneratedamountbal){
										$amountdeducted = $totalgeneratedamountbal;
									}

									$sqlresults = $billprocessingcontroller->makecopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$foreigncurrency,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$cashiertillstable,$cashiersummarytable);
									$action = "Payment Received";
									$result = $engine->getresults($sqlresults,$item=$patient,$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=487;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
									if($sqlresults == '2'){
										if($bal>'0'){
											$status = "success";
											$msg = "$action for $patient Successfully";
										}else if($bal == '0'){
											$amountpaid = intval($totalgeneratedamountpaid) + intval($amountpaid);
											$generatereciept = $billprocessingcontroller->generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode,$patientreceipttable,$patientbillitemtable,$patientbillingtable,$patientdiscounttable,$patientsbillstable,$patientbillingpaymenttable,$currenttable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);											
											$status = "success";
											$msg = "$action for $patient Successfully";																
											$url = "receiptdetails?$form_key";
											$engine->redirect($url);	
										}
									}								
								}

								}else{
									$status = "error";					
									$msg = "Patient has an active credit to pay. Please clear at manage credit!"; 
								}

								// prepaid insurance
								}else if($paymethcode == $prepaidcode){	
												//	die($patientwallet)	;					
											$patientcredits = $patientcredittable->getpatientactivecreditdetails($patientcode,$instcode);
											if($patientcredits == '1'){ 
												   if($patientwallet == '-1'){
														$status = "error";					
														$msg = "$patient does not have a prepaid account!";
												   }else if($patientwallet <$amountpaid){	
														$status = "error";					
														$msg = "$patient wallet balance $patientwallet is less than $amountpaid !";
												   }else{
												
												$state = 'PREPAID';
												if($amountpaid>$totalgeneratedamountbal){
													$chang = $amountpaid - $totalgeneratedamountbal;
												}else{
													$chang = $totalgeneratedamountbal-$amountpaid ;
												}
												$bal = $totalgeneratedamountbal - $amountpaid;
												if($bal<'0'){
													$bal = '0';
												}
												if($chang>'0'){
													$status = "error";					
													$msg = "Amount Paid $amountpaid is greater than $totalgeneratedamountbal!";
												}else{
												if($amountpaid<$totalgeneratedamountbal){
													$amountdeducted = $amountpaid;
												}else if($amountpaid==$totalgeneratedamountbal){
													$amountdeducted = $amountpaid;
												}else if($amountpaid>$totalgeneratedamountbal){
													$amountdeducted = $totalgeneratedamountbal;
												}
												$receiptnumber = $currenttable->getlastestreceiptnumber($instcode);
												$cashiertillcode = md5(microtime());
												$sqlresults = $billprocessingcontroller->makeprepaidcopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$prepaidcode,$prepaidchemecode,$receiptnumber,$patientbillingpaymenttable,$patientbillingtable,$patientschemetable,$cashiersummarytable);
												$action = "Payment Received";
												$result = $engine->getresults($sqlresults,$item=$patient,$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=487;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
												if($sqlresults == '2'){
													if($bal>'0'){
														$status = "success";
														$msg = "$action for $patient Successfully";
													}else if($bal == '0'){
														$amountpaid = intval($totalgeneratedamountpaid) + intval($amountpaid);
														$generatereciept = $billprocessingcontroller->generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode,$patientreceipttable,$patientbillitemtable,$patientbillingtable,$patientdiscounttable,$patientsbillstable,$patientbillingpaymenttable,$currenttable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);											
														$status = "success";
														$msg = "$action for $patient Successfully";																
														$url = "receiptdetails?$form_key";
														$engine->redirect($url);	
													}
												}
											}									
												
											}
											}else{
												$status = "error";					
												$msg = "Ptient has an active credit to pay. Please clear at manage credit!"; 
											}

					}
				}
			
			}
		}
	}

	break;
	// 27 AUG 2023 , 31 JAN 2021
		case 'changescheme':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');	
			$changeschemereason = htmlspecialchars(isset($_POST['changeschemereason']) ? $_POST['changeschemereason'] : '');				
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){	
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{
				if(empty($_POST["unscheckbox"]) || empty($paymentscheme) ){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{
						$ps = explode('@@@', $paymentscheme);
                        $paymentschemecode = $ps[0];
                        $paymentscheme = $ps[1];
                        $paymentmethodcode = $ps[2];
                        $paymethname = $ps[3];
                        $paymentplan = $ps[4];
					
						foreach($_POST["unscheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
							$state = $kt['7'];
							$tdate = $kt['8'];
							$itemqty = $kt['9'];
							$itemcode = $kt['10'];
							if($state !== '1'){
								$status = "error";
								$msg = "Only Unselected Transactions can be changed"; 							
							}else{
								$getprice = $pricingtable->gettheprice($itemcode,$instcode,$paymentschemecode,$cashschemecode);		
								$total = $getprice*$itemqty;
								if($getprice == '-1'){
									$total = '-1';
								}								
								$sqlresults = $patientbillitemtable->updatepaymentschemetransactions($bcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$paymentplan,$getprice,$total,$days,$visitcode,$currentuser,$currentusercode,$instcode);
								$action = 'Change Scheme';							
								$result = $engine->getresults($sqlresults,$item='Item',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=11;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
							}							
						}							
					}
				}		
			}
		break;
		// 22 AUG 2023, JOSEPH ADORBOE 
		case 'reversecanceltransaction':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$servicecode = htmlspecialchars(isset($_POST['servicecode']) ? $_POST['servicecode'] : '');
			$department = htmlspecialchars(isset($_POST['department']) ? $_POST['department'] : '');
			$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){	
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{											
					$sqlresults = $billprocessingcontroller->reversecashiercanceltransactions($ekey,$servicecode,$department,$visitcode,$amount,$days,$patientcode,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
					$action = "Cancelled Transaction Reveresed";							
					$result = $engine->getresults($sqlresults,$item=$patient,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=498;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);									
					}			
				}
		break;
		// 19 AUG 2023,  29 JULY 2021 JOSEPH ADORBOE 
		case 'canceltransaction':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');			
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
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
							$state = $kt['7'];
							if($state !== '1'){
								$status = "error";
								$msg = "Only Unselected Transactions can be Cancelled"; 
							}else{	
									
							$sqlresults = $billprocessingcontroller->cashiercanceltransactions($bcode,$servicecode,$dpts,$visitcode,$days,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
							$action = "Cancel Transactions";							
							$result = $engine->getresults($sqlresults,$item=$patient,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=68;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
							}	
						}						
						}					
					}			
				}
		break;
		// 26 AUG 2023, 31 JAN 2021
		case 'sendbacktransaction':
				$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
				$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
				$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');
				$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
				$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
				$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
				$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
				$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');				
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
								$bills = $kt['1'];
								$bdpt = $kt['2'];
								$amt = $kt['3'];
								$servicecode = $kt['4'];
								$dpts = $kt['5'];
								$billingcode = $kt['6'];
								$type = 1;
								$state = $kt['7'];							
								if($state !== '1'){
									$status = "error";
									$msg = "Only Unselected Transactions can be Send Back"; 
								}else{	
								
									$sqlresults = $billprocessingcontroller->cashiersendbacktransactions($bcode,$servicecode,$dpts,$sendbackreason,$visitcode,$days,$currentuser,$currentusercode,$instcode,$patientbillitemtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
									$action = 'Send Back Transaction';							
									$result = $engine->getresults($sqlresults,$item='Item',$action);
									$re = explode(',', $result);
									$status = $re[0];					
									$msg = $re[1];
									$event= "$action: $form_key $msg";
									$eventcode=13;
									$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
								}					
						}
					}		
				}
			}
		break;
		// 25 AUG 2023, 31 JAN 2021
		case 'unselecttransaction':
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');				
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
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
							$billingcode = $kt['6'];
							$state = $kt['7'];
							$type = 1;
						if($state !== '2'){
							$status = "error";
							$msg = "Only selected Transactions can be Unselected"; 
						}else{	
							
							$sqlresults = $billprocessingcontroller->cashierunselectedtransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type,$patientbillitemtable,$patientbillingtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
							$action = 'Unselect Transaction';							
							$result = $engine->getresults($sqlresults,$item='Item',$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=12;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						}				
					}
				}		
			}
			}
		break;
		// 23 AUG 2023 , 31 JAN 2021
		case 'selecttransaction':		
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$cashiertill = htmlspecialchars(isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
			$type = htmlspecialchars(isset($_POST['type']) ? $_POST['type'] : '');				
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
					if($billcode == '0'){				
						$billcode = md5(microtime());						
						$patientsbillstable->insertnewbills($billcode,$days,$patientcode,$patientnumber,$visitcode,$patient,$serviceamount =0,$currentuser,$currentusercode,$instcode);
					}	
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
							$state = $kt['7'];
							if($amt == '-1'){
								$status = "error";
								$msg = "Price has not been set"; 
							}else if($state !== '1'){
								$status = "error";
								$msg = "Only Unselected Transactions can be selected"; 							
							}else{								
								$billgeneratedcode = $patientbillingtable->getgeneratedbillcode($patientcode,$patientnumber,$patient,$visitcode,$days,$day,$currentuser,$currentusercode,$instcode,$type);
								$sqlresults = $billprocessingcontroller->cashierselectedtransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type,$patientbillitemtable,$patientbillingtable,$patientsServiceRequesttable,$patientsInvestigationRequesttable,$Prescriptionstable,$patientsDevicestable,$patientproceduretable,$patientsMedicalreportstable);
								$action = 'Select Transaction';							
								$result = $engine->getresults($sqlresults,$item='Item',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=11;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
							}							
						}							
					}
				}		
			}
		break;
	}


?>
