<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$cashiermodel = isset($_POST['cashiermodel']) ? $_POST['cashiermodel'] : '';
	
	// 26 FEB 2021 JOSEPH ADORBOE  
switch ($cashiermodel)
{

	// 12 APR 2023 JOSEPH ADORBOE 
	case 'approveendofday':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$approveremarks = isset($_POST['approveremarks']) ? $_POST['approveremarks'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){			
			if(empty($approveremarks)){
				$status = 'error';
				$msg = 'Required Field cannot be null';
			}else{				
							
					$endofday = $cashiersql->approveendofday($ekey,$approveremarks,$day,$currentusercode,$currentuser,$instcode);
					$title = "End of Day";
					if($endofday == '0'){						
						$status = 'error';
						$msg = " $title Unsuccessful ";						
					}else if($endofday == '1'){						
						$status = 'error';
						$msg = " $title Already done";						
					}else if($endofday == '2'){
						$event= " $title done $form_key successfully ";
						$eventcode= 51;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "$title Successfully";	
							// $url = "receiptdetails?$form_key";
							// $engine->redirect($url);	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}																
					}else{						
						$status = 'error';
						$msg = 'Unknown Source';						
					}												
				}				
			}
	break;


	// 11 APR 2023 JOSEPH ADORBOE 
	case 'editendofday':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$bankcashtotalamount = isset($_POST['bankcashtotalamount']) ? $_POST['bankcashtotalamount'] : '';
		$bankaccountdetails = isset($_POST['bankaccountdetails']) ? $_POST['bankaccountdetails'] : '';
		$bankdepositslip = isset($_POST['bankdepositslip']) ? $_POST['bankdepositslip'] : '';
		$ecashopeningbalance = isset($_POST['ecashopeningbalance']) ? $_POST['ecashopeningbalance'] : '';
		$ecashtotalamount = isset($_POST['ecashtotalamount']) ? $_POST['ecashtotalamount'] : '';	
		$ecashclosebal = isset($_POST['ecashclosebal']) ? $_POST['ecashclosebal'] : '';
		$cashathand = isset($_POST['cashathand']) ? $_POST['cashathand'] : '';		
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$shift = isset($_POST['shift']) ? $_POST['shift'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){			
			if(empty($bankcashtotalamount) || empty($shift) || empty($totalamount)){
				$status = 'error';
				$msg = 'Required Field cannot be null';
			}else{				
				$sshift = explode('@@@',$shift);
				$shiftcode = $sshift['0'];
				$shiftname = $sshift['1'];
				$shiftdate = $sshift['2'];
				$eodnumber = date('His');
				
					$endofday = $cashiersql->editendofday($form_key,$ekey,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$day,$currentusercode,$currentuser,$instcode);
					$title = "End of Day";
					if($endofday == '0'){						
						$status = 'error';
						$msg = " $title Unsuccessful ";						
					}else if($endofday == '1'){						
						$status = 'error';
						$msg = " $title Already done";						
					}else if($endofday == '2'){
						$event= " $title done $form_key successfully ";
						$eventcode= 51;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "$title Successfully";	
							// $url = "receiptdetails?$form_key";
							// $engine->redirect($url);	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}																
					}else{						
						$status = 'error';
						$msg = 'Unknown Source';						
					}												
				}				
			}
	break;

	// 11 APR 2023 JOSEPH ADORBOE 
	case 'addendofday':
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$bankcashtotalamount = isset($_POST['bankcashtotalamount']) ? $_POST['bankcashtotalamount'] : '';
		$bankaccountdetails = isset($_POST['bankaccountdetails']) ? $_POST['bankaccountdetails'] : '';
		$bankdepositslip = isset($_POST['bankdepositslip']) ? $_POST['bankdepositslip'] : '';
		$ecashopeningbalance = isset($_POST['ecashopeningbalance']) ? $_POST['ecashopeningbalance'] : '';
		$ecashtotalamount = isset($_POST['ecashtotalamount']) ? $_POST['ecashtotalamount'] : '';	
		$ecashclosebal = isset($_POST['ecashclosebal']) ? $_POST['ecashclosebal'] : '';
		$cashathand = isset($_POST['cashathand']) ? $_POST['cashathand'] : '';		
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$shift = isset($_POST['shift']) ? $_POST['shift'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){			
			if(empty($bankcashtotalamount) || empty($shift) || empty($ecashopeningbalance) || empty($ecashclosebal)){
				$status = 'error';
				$msg = 'Required Field cannot be null';
			}else{				
				$sshift = explode('@@@',$shift);
				$shiftcode = $sshift['0'];
				$shiftname = $sshift['1'];
				$shiftdate = $sshift['2'];
				$eodnumber = date('His');

				$ecashtotalamount = $ecashclosebal-$ecashopeningbalance;
				$totalamount = $bankcashtotalamount+$ecashtotalamount+$cashathand;
				
					$endofday = $cashiersql->addendofday($form_key,$eodnumber,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$day,$currentusercode,$currentuser,$instcode);
					$title = "End of Day";
					if($endofday == '0'){						
						$status = 'error';
						$msg = " $title Unsuccessful ";						
					}else if($endofday == '1'){						
						$status = 'error';
						$msg = " $title Already done";						
					}else if($endofday == '2'){
						$event= " $title done $form_key successfully ";
						$eventcode= 51;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "$title Successfully";	
							// $url = "receiptdetails?$form_key";
							// $engine->redirect($url);	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}																
					}else{						
						$status = 'error';
						$msg = 'Unknown Source';						
					}												
				}				
			}
	break;
			
			

	// 08 SEPT 2022 
	case 'refundreceiptsearchfilter': 
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
					$url = "cashier__refundreceiptsearch?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;

	


	// 29 JULY 2021 JOSEPH ADORBOE 
	case 'canceltransaction':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';
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
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];
									
								$answer = $cashiersql->cashiercanceltransactions($bcode,$billcode,$amt,$servicecode,$dpts,$visitcode,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Selected ".$billcode." for  has been saved successfully ";
									$eventcode= 68;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Cancelled Successfully";	
										$view = 'cashiertransactions';	
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
	break;

	// 10 MAY 2021
	case 'receiptsearchfilter': 
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
					$url = "receiptsearch?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;

	// 11 MAR 2021 JOSEPH ADORBOE 
	case 'receivecreditpayments':

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertilcode = isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$amountpaid = isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';	
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';		
		$bkey = isset($_POST['bkey']) ? $_POST['bkey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';		
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$paymentschemestate = isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '';

		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
					if($cashiertill == '0'){					
						$status = "error";
						$msg = "Cashier Tills is not open. Please open one now.";				
					}else{ 	
						if(empty($totalamount) || empty($patientpaymenttype) || empty($amountpaid)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{				
							if($amountpaid<$totalamount){					
								$status = 'error';
								$msg = 'Amount Paid cannot Be less than total Amount.';
							}else{

								$paytype = explode('@@@',$patientpaymenttype);
								$paycode = $paytype['0'];
								$payname = $paytype['1'];
								$paymethcode = $paytype['2'];
								$paymeth = $paytype['3'];							

								$paymentschemestate = $paymentschemetable->getpaymentschemestate($paycode,$instcode);
								
								if($paymentschemestate == '0'){
									$status = 'error';
									$msg = 'Payment Scheme '.$payname.' Has been suspended';
								}else if($paymentschemestate == '1'){
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
									if($patientcredits !== '1'){
										$pcdetails = explode('@',$patientcredits);
										$creditdate = $pcdetails[0];
										$creditamount = $pcdetails[1];
										$creditamountused = $pcdetails[2];
										$creditamountpaid = $pcdetails[3];
										$creditamountbal = $pcdetails[4];
										$creditdue = $pcdetails[5];
										$creditstate = $pcdetails[6];
										$creditamountusedbal = $pcdetails[7];
										$creditdate = date("d M Y h:i:s a" , strtotime($creditdate));
										if($creditstate == '1'){
											$creditstatused = 'Pending';
										}else if($creditstate == '2'){
											$creditstatused = 'Approved';
										}												
									}else{
										$creditdate=$creditamount=$creditamountused=$creditamountpaid=$creditamountbal=$creditdue=$creditstate=$creditstatused='';
									}
									
									if($paymethcode == $cashpaymentmethodcode){

										$state = 'CREDIT PAID';
										$chang = $amountpaid - $totalamount;
										$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
										$generatereciept = $cashiersql->generatecreditrepaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$cashiertill);
										$title = 'Credit Payment';
										if($generatereciept == '0'){						
											$status = 'error';
											$msg = ''.$title.' Unsuccessful';						
										}else if($generatereciept == '1'){						
											$status = 'error';
											$msg = ''.$title.' Already done';						
										}else if($generatereciept == '2'){
											$event= "".$title." done '.$form_key.' successfully ";
											$eventcode= 51;
											$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
											if($audittrail == '2'){
												$status = "success";
												$msg = "'.$title.' ".$patient." Successfully";	
												$url = "receiptdetails?$form_key";
												$engine->redirect($url);	
											}else{
												$status = "error";					
												$msg = "Audit Trail Failed!"; 
											}																
										}else{						
											$status = 'error';
											$msg = 'Unknown Source';						
										}

									}else if($paymethcode == $mobilemoneypaymentmethodcode){

										$state = 'CREDIT PAID';
										$chang = $amountpaid - $totalamount;
										$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
										$generatereciept = $cashiersql->generatecreditrepaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$cashiertill);
										$title = 'Credit Payment';
										if($generatereciept == '0'){						
											$status = 'error';
											$msg = ''.$title.' Unsuccessful';						
										}else if($generatereciept == '1'){						
											$status = 'error';
											$msg = ''.$title.' Already done';						
										}else if($generatereciept == '2'){
											$event= "'.$title.' done '.$form_key.' successfully ";
											$eventcode= 51;
											$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
											if($audittrail == '2'){
												$status = "success";
												$msg = "'.$title.' ".$patient." Successfully";	
												$url = "receiptdetails?$form_key";
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
										$status = 'error';
										$msg = 'Invalid payment Method ';						
									}
								}
							}
						}
					}
				}
			}

	break;
										
								
	
	
	
	// 31 JAN 2021
	case 'receivepayments':

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertilcode = isset($_POST['cashiertilcode']) ? $_POST['cashiertilcode'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$amountpaid = isset($_POST['amountpaid']) ? $_POST['amountpaid'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';		
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';	
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';		
		$bkey = isset($_POST['bkey']) ? $_POST['bkey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';		
	//	$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$paymentschemestate = isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '';
		$chequenumber = isset($_POST['chequenumber']) ? $_POST['chequenumber'] : '';
		$banks = isset($_POST['banks']) ? $_POST['banks'] : '';
		$insurancebal = isset($_POST['insurancebal']) ? $_POST['insurancebal'] : '';
		$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
		$payingtype = isset($_POST['payingtype']) ? $_POST['payingtype'] : '';
		
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
						if(empty($totalamount) || empty($patientpaymenttype) || empty($amountpaid)){
							$status = 'error';
							$msg = 'Required Field cannot be null';
						}else{				
							if($amountpaid<$totalamount){					
								$status = 'error';
								$msg = 'Amount Paid cannot Be less than total Amount.';
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
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);	
									$days = date('Y-m-d h:i:s')	;
								//	die($days)	;												
									
									if($paymethcode == $creditcode){
												$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
												if($patientcredits == '1'){
													$status = 'error';
													$msg = 'Patient has no Active Credit';	
												}else{
													
													if($patientcredits !== '1'){
														$pcdetails = explode('@',$patientcredits);
														$creditdate = $pcdetails[0];
														$creditamount = $pcdetails[1];
														$creditamountused = $pcdetails[2];
														$creditamountpaid = $pcdetails[3];
														$creditamountbal = $pcdetails[4];
														$creditdue = $pcdetails[5];
														$creditstate = $pcdetails[6];
														$creditamountusedbal = $pcdetails[7];
														$creditdate = date("d M Y h:i:s a" , strtotime($creditdate));
														if($creditstate == '1'){
															$creditstatused = 'Pending';
														}else if($creditstate == '2'){
															$creditstatused = 'Approved';
														}												
													}else{
														$creditdate=$creditamount=$creditamountused=$creditamountpaid=$creditamountbal=$creditdue=$creditstate=$creditstatused='';
													}

													if($creditamountbal<$totalamount){
														$status = 'error';
														$msg = 'Patient Credit line Balance is insufficent';
													}else{

													$state = 'CREDIT';
													$chang = '0';
													$generatereciept = $cashiersql->generatecreditreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$cashiertill);
													$title = 'Payment';
													if($generatereciept == '0'){						
														$status = 'error';
														$msg = 'Payment Unsuccessful';						
													}else if($generatereciept == '1'){						
														$status = 'error';
														$msg = 'Payment Already done';						
													}else if($generatereciept == '2'){
														$event= "New cashier payment done '.$form_key.' successfully ";
														$eventcode= 51;
														$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
														if($audittrail == '2'){
															$status = "success";
															$msg = "Payment for ".$patient." Successfully";	
															$url = "receiptdetails?$form_key";
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
											}
									}else if($paymethcode == $cashpaymentmethodcode){	
																	
												$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
												if($patientcredits == '1'){
													// Patient has not active credit
													$state = 'PAID';
													$chang = $amountpaid - $totalamount;
													$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
													$cashiertillcode = md5(microtime());
														
													$generatereciept = $cashiersql->generatereceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days);
													$title = 'Payment';
													if($generatereciept == '0'){						
														$status = 'error';
														$msg = ''.$title.' Unsuccessful';						
													}else if($generatereciept == '1'){						
														$status = 'error';
														$msg = ''.$title.' Already done';						
													}else if($generatereciept == '2'){
														$event= " '.$title.' done '.$form_key.' successfully";
														$eventcode= 51;
														$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
														if($audittrail == '2'){
															$status = "success";
															$msg = "'.$title.' for ".$patient." Successfully";	
															$url = "receiptdetails?$form_key";
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
												$chang = $amountpaid - $totalamount;
												$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
												$generatereciept = $cashiersql->generatereceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days);
												$title = 'Payment';
												if($generatereciept == '0'){						
													$status = 'error';
													$msg = ''.$title.' Unsuccessful';						
												}else if($generatereciept == '1'){						
													$status = 'error';
													$msg = ''.$title.' Already done';						
												}else if($generatereciept == '2'){
													$event= "'.$title.' done '.$form_key.' successfully ";
													$eventcode= 51;
													$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
													if($audittrail == '2'){
														$status = "success";
														$msg = "'.$title.' for ".$patient." Successfully";	
														$url = "receiptdetails?$form_key";
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


								// cheques
							}else if($paymethcode == $chequescode){
									
								$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
								if($patientcredits == '1'){ 
									   if(empty($chequenumber) || empty($banks) ){
											$status = "error";					
											$msg = "Cheque number or banks is mandatory!";
									   }else{
										 
										$bk = explode('@@@',$banks);
										$bankscode = $bk['0'];
										$banks = $bk['1']; 									   
									
									$state = 'CHEQUE PAID';
									$chang = $amountpaid - $totalamount;
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$generatereciept = $cashiersql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$banks,$bankscode,$cashiertill);
									$title = 'Payment';
									if($generatereciept == '0'){						
										$status = 'error';
										$msg = ''.$title.' Unsuccessful';						
									}else if($generatereciept == '1'){						
										$status = 'error';
										$msg = ''.$title.' Already done';						
									}else if($generatereciept == '2'){
										$event= "'.$title.' done '.$form_key.' successfully ";
										$eventcode= 51;
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										if($audittrail == '2'){
											$status = "success";
											$msg = "'.$title.' for ".$patient." Successfully";	
											$url = "receiptdetails?$form_key";
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

								// private insurance
								}else if($paymethcode == $privateinsurancecode){
									
											$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);

											if($patientcredits == '1'){

												if(empty($insurancebal) || $insurancebal<$totalamount) {
													$status = "error";					
													$msg = "Insurnce Balance is mandatory or insurance balance is insufficent!";
											   }else{
												$state = 'PRIVATE INSURANCE PAID';
												$chang = $amountpaid - $totalamount;
												$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
												$generatereciept = $cashiersql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$banks,$bankscode,$cashiertill);
												$title = 'Payment';
												if($generatereciept == '0'){						
													$status = 'error';
													$msg = ''.$title.' Unsuccessful';						
												}else if($generatereciept == '1'){						
													$status = 'error';
													$msg = ''.$title.' Already done';						
												}else if($generatereciept == '2'){
													$event= "'.$title.' done '.$form_key.' successfully ";
													$eventcode= 51;
													$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
													if($audittrail == '2'){
														$status = "success";
														$msg = "'.$title.' for ".$patient." Successfully";	
														$url = "receiptdetails?$form_key";
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


								// National insurance 
							}else if($paymethcode == $nationalinsurancecode){
									
								$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = 'NHIS PAID';
									$chang = $amountpaid - $totalamount;
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$generatereciept = $cashiersql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$banks,$bankscode,$cashiertill);
								$title = 'Payment';
									if($generatereciept == '0'){						
										$status = 'error';
										$msg = ''.$title.' Unsuccessful';						
									}else if($generatereciept == '1'){						
										$status = 'error';
										$msg = ''.$title.' Already done';						
									}else if($generatereciept == '2'){
										$event= "'.$title.' done '.$form_key.' successfully ";
										$eventcode= 51;
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										if($audittrail == '2'){
											$status = "success";
											$msg = "'.$title.' for ".$patient." Successfully";	
											$url = "receiptdetails?$form_key";
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
									$msg = "Ptient has an active credit to pay. Please clear at manage credit!"; 
								}

							// partner insurance
							}else if($paymethcode == $partnercompaniescode){
									
								$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = 'PARTNER COMPANY PAID';
									$chang = $amountpaid - $totalamount;
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$generatereciept = $cashiersql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$banks,$bankscode,$cashiertill);
								$title = 'Payment';
									if($generatereciept == '0'){						
										$status = 'error';
										$msg = ''.$title.' Unsuccessful';						
									}else if($generatereciept == '1'){						
										$status = 'error';
										$msg = ''.$title.' Already done';						
									}else if($generatereciept == '2'){
										$event= "'.$title.' done '.$form_key.' successfully ";
										$eventcode= 51;
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										if($audittrail == '2'){
											$status = "success";
											$msg = "'.$title.' for ".$patient." Successfully";	
											$url = "receiptdetails?$form_key";
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
									
								}else{
									$status = "error";					
									$msg = "Invalid Payment Method"; 
								}								
						}					
					}
			//	}
			
			}
		}
	}

	break;
	
	// 31 JAN 2021
	case 'unselecttransaction':

		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';
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

				// if($cashiertill == '0'){				
				// 	$status = "error";
				// 	$msg = "Cashier Tills is not open. Please open one now.";			
				// }else{ 			
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
							$answer = $cashiersql->cashierunselectedtransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type);
				
							if($answer == '1'){
								$status = "error";
								$msg = "Already Unselected ";	
							}else if($answer == '2'){
								$event= "Cashier Item Selected ".$bcode."  has been saved successfully ";
								$eventcode= 69;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "Unselections Successfully";	
									$view = '#';
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
		//	}
		}
		}

	break;

	
	// 3 MAR 2021 JOSEPH ADORBOE 
	case 'setitemprice':
		
		$item = isset($_POST['item']) ? $_POST['item']: '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode']: '';
		$schemcode = isset($_POST['schemcode']) ? $_POST['schemcode']: '';
		$schemename = isset($_POST['schemename']) ? $_POST['schemename']: '';
		$method = isset($_POST['method']) ? $_POST['method']: '';
		$methodcode = isset($_POST['methodcode']) ? $_POST['methodcode']: '';
		$itemprice = isset($_POST['itemprice']) ? $_POST['itemprice']: '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode']: '';
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
					$setprice = $cashiersql->setprice($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$currentuser,$currentusercode,$instcode);
					
					if($setprice == '0'){							
						$status = "error";					
						$msg = "New Price $itemprice Unsuccessful"; 
					}else if($setprice == '1'){						
						$status = "error";					
						$msg = "New Price $itemprice Exist Already"; 							
					}else if($setprice == '2'){	
						$event= "New price set for: $item for has been saved successfully ";
						$eventcode= 55;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "New price set for $item Successfully";	
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
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';				
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

				if(empty($_POST["scheckbox"])){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{

				//	die($billcode);
			
					if($billcode == '0'){				
						$billcode = $coder->createbillcode($patientcode,$visitcode);
						$patientsbillstable->insertnewbills($billcode,$days,$patientcode,$patientnumber,$visitcode,$patient,$currentuser,$currentusercode,$instcode);
					}		
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$bills = $kt['1'];
							$bdpt = $kt['2'];
							$amt = $kt['3'];
							$servicecode = $kt['4'];
							$dpts = $kt['5'];

							if($amt == '-1'){
								$status = "error";
								$msg = "Price has not been set"; 
							}else{
								
								$billgeneratedcode = $patientbillingtable->getgeneratedbillcode($patientcode,$patientnumber,$patient,$visitcode,$days,$day,$currentuser,$currentusercode,$instcode,$type);
								$answer = $cashiersql->cashierselectedtransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Selected $billcode for  has been saved successfully ";
									$eventcode= 68;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Selected Successfully";
										$view = '#';		
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
				//	}			
				}
			}
		
			}
	break;


	
	// 31 JAN 2021
	case 'opencashiertills':		
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode']: '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift']: '';
		$currentusercode = isset($_POST['currentusercode']) ? $_POST['currentusercode']: '';
		$currentuser = isset($_POST['currentuser']) ? $_POST['currentuser']: '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){			
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($currentusercode) ){				
					$status = "error";
					$msg = "Required Fields cannot be empty";				
				}else{			
			
					$opentills = $cashiersql->opencashiertills($form_key,$day,$currentshiftcode,$currentshift,$days,$currentuser,$currentusercode,$instcode);
					
					if($opentills == '0'){							
						$status = "error";					
						$msg = "New Tills Opened $currentuser Unsuccessful"; 
					}else if($opentills == '1'){						
						$status = "error";					
						$msg = "New Tills Opened $currentuser Exist Already"; 							
					}else if($opentills == '2'){	
						$event= "New Tills Opened: $form_key for  has been saved successfully ";
						$eventcode= 67;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "New Tills Opened for $currentuser Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}												
					}else{						
						$status = "error";					
						$msg = "Open Till query Unsuccessful "; 						
					}
						
				}			
		}
	}
		
	break;

	
	// 27 FEB 2021 
	case 'setcashiertill': 
		$cashpaymentmethod = isset($_POST['cashpaymentmethod']) ? $_POST['cashpaymentmethod'] : '';
		$momopaymentmethod = isset($_POST['momopaymentmethod']) ? $_POST['momopaymentmethod'] : '';
		$chequespaymentmethod = isset($_POST['chequespaymentmethod']) ? $_POST['chequespaymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($cashpaymentmethod) || empty($momopaymentmethod) || empty($chequespaymentmethod) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$cas = explode('@@@', $cashpaymentmethod);
				$cascode = $cas[0];
				$casname = $cas[1];	
				
				$mom = explode('@@@', $momopaymentmethod);
				$momcode = $mom[0];
				$momname = $mom[1];
				
				$cq = explode('@@@', $chequespaymentmethod);
				$cqcode = $cq[0];
				$cqname = $cq[1];				
				$settile = $cashiersql->setcashiertill($form_key,$cascode,$casname,$momcode,$momname,$cqcode,$cqname,$day,$currentusercode,$currentuser,$instcode);

				if($settile == '0'){					
					$status = "error";					
					$msg = "Set Till Unsuccessful"; 
				}else if($settile == '1'){				
					$status = "error";					
					$msg = "Till Has been set already "; 					
				}else if($settile == '2'){
					$event= "Cashier Till Set :".$form_key." has been Set successfully ";
					$eventcode= 54;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Cashier Till Set Successfully";	
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}						
													
				}else{					
					$status = "error";					
					$msg = "Add Price Unsuccessful "; 					
				}
			}
		}

	break;

}
	
//	$cashiertilllist = ("SELECT * from octopus_cashiertill where CA_STATUS = '1' and CA_INSTCODE = '$instcode' and CA_CASHIERCODE = '$currentusercode'  ");
//	$getcashiertilllist = $dbconn->query($cashiertilllist);

?>
