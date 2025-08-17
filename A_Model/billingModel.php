<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$billingmodel = isset($_POST['billingmodel']) ? $_POST['billingmodel'] : '';
	
	// 19 JULY 2021 JOSEPH ADORBOE  
switch ($billingmodel)
{


	// 10 MAR 2023 
	case 'rejecttransaction':
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
							$billingdate = $kt['7'];
							$answer = $billingsql->billingrejectransactions($bcode,$servicecode,$dpts,$visitcode,$instcode,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode);
				
							if($answer == '1'){
								$status = "error";
								$msg = "Already Unselected ";	
							}else if($answer == '2'){
								$event= "Cashier Item Selected $bcode has been saved successfully ";
								$eventcode= 69;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "Item Rejection Successfully";	
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


	// 01 MAR 2023
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
							$billingdate = $kt['7'];
							$lastdate = '2023-02-28';
							if($billingdate>$lastdate){
								$answer = $cashiersql->cashierunselectedtransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode,2);
							}else{
								$answer = $billingsql->billingunselectiontransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode);
							}						
				
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


	// 01 MAR 2023
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
							$billingdate = $kt['7'];

							if($amt == '-1'){
								$status = "error";
								$msg = "Price has not been set"; 
							}else{
								$lastdate = '2023-02-28';
								$billgeneratedcode = $patientbillingtable->getgeneratedbillcode($patientcode,$patientnumber,$patient,$visitcode,$days,$day,$currentuser,$currentusercode,$instcode,2);
								if($billingdate>$lastdate){									
									$answer = $cashiersql->cashierselectedtransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,2);
								}else{									
									$answer = $billingsql->billingselectiontransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,2);
								}						
						
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


	// 09 SEPT 2022  JOSPH ADORBOE
	case 'claimssearch': 		
		$general = isset($_POST['general']) ? $_POST['general'] : '';
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
		$todate = isset($_POST['todate']) ? $_POST['todate'] : '';	
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';			
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
						$url = "claimbilling__manageclaimsreports?$form_key";
						$engine->redirect($url);

					}else if($general =='4'){

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

						$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate.'@@@'.$scheme;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "claimbilling__manageclaimsreports?$form_key";
						$engine->redirect($url);

					}else if($general =='3'){

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
						$url = "claimbilling__manageclaimsreports?$form_key";
						$engine->redirect($url);

					}else if($general =='5'){

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

						$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate.'@@@'.$patientrecords;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "claimbilling__manageclaimsreports?$form_key";
						$engine->redirect($url);

					}else if($general =='1'){

						if(!empty($patientrecords)){
							$value = $general.'@@@'.$patientrecords.'@@@'.$general;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "claimbilling__manageclaimsreports?$form_key";
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
	
	// 06 FEB 2023 JOSEPH ADORBOE
	case 'closeclaims':
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$claimscodes = isset($_POST['claimscodes']) ? $_POST['claimscodes'] : '';			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{					
						$answer = $billingsql->processclaimsperformedtransactionsclose($claimscodes,$visitcode,$instcode);
			
						if($answer == '1'){
							$status = "error";
							$msg = "Already Unselected ";	
						}else if($answer == '2'){
							$event= "Claims $claimscodes has been saved successfully ";
							$eventcode= 234;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "Claims Closed Successfully";	
								$view = "manageclaims";
								// $url = "receiptdetails?$form_key";
								// $engine->redirect($url);
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

	break;


	// 05 FEB 2023 
	case 'processclaims':		
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
						$clamskeycode = md5(microtime());
					//	$claimnumber = date('YmdHis');
						$claimnumber = date('dhis');
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$claimscode = $kt['1'];
							$claimsnumber = $kt['2'];
							$claimsamount = $kt['3'];
							$claimmethodcode = $kt['4'];
							$claimmethod = $kt['5'];
							$claimschemecode = $kt['6'];
							$claimscheme = $kt['7'];
							$claimmonth = $kt['8'];
							$claimyear = $kt['9'];
														
								$answer = $billingsql->processclaimsperformedtransactions($bcode,$days,$claimscode,$claimsnumber,$claimsamount,$visitcode,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Processed Transaction";
								}else if($answer == '2'){
									$billingsql->processclaimsmonthly($days,$claimsamount,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode);
									$billingsql->processclaimsschemes($days,$claimsamount,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode);
									$event= "Item PROCESSED CLAIMS $bcode been saved successfully ";
									$eventcode= 233;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Claims Processed Successfully";
										$view = "manageclaims";	
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

	//  22 JAN 2023 
	case 'bookpayments':

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
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$paymentschemestate = isset($_POST['paymentschemestate']) ? $_POST['paymentschemestate'] : '';
		$chequenumber = isset($_POST['chequenumber']) ? $_POST['chequenumber'] : '';
		$banks = isset($_POST['banks']) ? $_POST['banks'] : '';
		$insurancebal = isset($_POST['insurancebal']) ? $_POST['insurancebal'] : '';
		$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
		$payingtype = isset($_POST['payingtype']) ? $_POST['payingtype'] : '';
		$transactionday = isset($_POST['transactionday']) ? $_POST['transactionday'] : '';
		$transactionmonth = isset($_POST['transactionmonth']) ? $_POST['transactionmonth'] : '';
		$transactionyear = isset($_POST['transactionyear']) ? $_POST['transactionyear'] : '';
		$transactionshiftcode = isset($_POST['transactionshiftcode']) ? $_POST['transactionshiftcode'] : '';
		$transactionshift = isset($_POST['transactionshift']) ? $_POST['transactionshift'] : '';
		$transactiondate = isset($_POST['transactiondate']) ? $_POST['transactiondate'] : '';								
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
							//	$amountpaid = number_format($amountpaid, 2);
							// $totalamount = number_format($totalamount, 2);			
							if($amountpaid !== $totalamount){					
								$status = 'error';
								$msg = "Amount to be Paid $amountpaid is NOT equal to total Amount $totalamount";
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
									$msg = "Payment Scheme $payname Has been suspended";
								}else if($paymentschemestate == '1'){
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);	
									$fkey = md5(microtime());
									$days = date('Y-m-d h:i:s')	;
								//	die($days)	;												
									
								
								// private insurance
								if($paymethcode == $privateinsurancecode){
									
											$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);
											$tillcode = md5(microtime());
											$insurancetillcode = $billingsql->getinsurancetillcode($day,$paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$tillcode = md5(microtime());
											$insurancesummarycode = $billingsql->getinsurancesummarycode($day,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$billingcode = md5(microtime());
											
											if($patientcredits == '1'){

												if(empty($amountpaid) || $amountpaid !== $totalamount) {
													$status = "error";					
													$msg = "Insurance Balance is mandatory or insurance balance is insufficent!";
											   }else{
												$state = 'PRIVATE INSURANCE TO PAY';
												$chang = $amountpaid - $totalamount;
												$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
												$generatereciept = $billingsql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$fkey,$currentday,$currentmonth,$currentyear,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
												$title = 'Payment';
												if($generatereciept == '0'){						
													$status = 'error';
													$msg = "$title Unsuccessful";						
												}else if($generatereciept == '1'){						
													$status = 'error';
													$msg = "$title Already done";						
												}else if($generatereciept == '2'){
													$event= "$title done $form_key successfully ";
													$eventcode= 51;
													$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
													if($audittrail == '2'){
														$status = "success";
														$msg = "$title for $patient Successfully";	
														$url = "receiptdetails?$fkey";
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
											$tillcode = md5(microtime());
											$insurancetillcode = $billingsql->getinsurancetillcode($day,$paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$tillcode = md5(microtime());
											$insurancesummarycode = $billingsql->getinsurancesummarycode($day,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$billingcode = md5(microtime());
											
									
								$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = 'NHIS PAID';
									$chang = $amountpaid - $totalamount;
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$generatereciept = $billingsql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$fkey,$currentday,$currentmonth,$currentyear,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
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
											$url = "receiptdetails?$fkey";
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
											$tillcode = md5(microtime());
											$insurancetillcode = $billingsql->getinsurancetillcode($day,$paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$tillcode = md5(microtime());
											$insurancesummarycode = $billingsql->getinsurancesummarycode($day,$tillcode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
											$billingcode = md5(microtime());
											
									
								$patientcredits = $cashiersql->getpatientactivecreditdetails($patientcode,$instcode);

								if($patientcredits == '1'){
									$state = 'PARTNER COMPANY PAID';
									$chang = $amountpaid - $totalamount;
									$receiptnumber = $cashiersql->getlastestreceiptnumber($instcode);
									$generatereciept = $billingsql->generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$insurancetillcode,$insurancesummarycode, $billingcode,$fkey,$currentday,$currentmonth,$currentyear,$transactiondate,$transactionday,$transactionmonth,$transactionyear,$transactionshiftcode,$transactionshift);
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
											$url = "receiptdetails?$fkey";
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
				}
		}
	}

	break;
	
	// 24 JULY 2022 
	case 'addtoclaims':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$cashiertill = isset($_POST['cashiertill']) ? $_POST['cashiertill'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientscheme = isset($_POST['patientscheme']) ? $_POST['patientscheme'] : '';	
		$patientschemecode = isset($_POST['patientschemecode']) ? $_POST['patientschemecode'] : '';	
		$date = isset($_POST['date']) ? $_POST['date'] : '';	
		$paymethod = isset($_POST['paymethod']) ? $_POST['paymethod'] : '';	
		$paymethodcode = isset($_POST['paymethodcode']) ? $_POST['paymethodcode'] : '';
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
		
					$claimsnumber = $coder->getclaimsnumber($instcode);
					$answer = $msql->processbillinglegacy($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$date,$visitcode,$paymethodcode,$paymethod,$patientschemecode,$patientscheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode);							
						
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
		
			}
	break;

	
	// 15 APR 2022 
	case 'billingunselecttransaction':

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
							// $bills = $kt['1'];
							// $bdpt = $kt['2'];
							// $amt = $kt['3'];
							// $servicecode = $kt['4'];
							// $dpts = $kt['5'];
							// $billingcode = $kt['6'];
							$answer = $billingsql->billingunselectedtransactions($bcode,$visitcode,$instcode);
				
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

	
	
	// 15 APR 2022 
	case 'billingselecttransaction':		
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
							// $bills = $kt['1'];
							// $bdpt = $kt['2'];
							// $amt = $kt['3'];
							// $servicecode = $kt['4'];
							// $dpts = $kt['5'];				
								
								$answer = $billingsql->billingselectedtransactions($bcode,$visitcode,$instcode);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Selected ".$billcode." for  has been saved successfully ";
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
			}
		
			}
	break;


	
}

?>
