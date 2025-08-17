<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$refundsmodel = htmlspecialchars(isset($_POST['refundsmodel']) ? $_POST['refundsmodel'] : '');
	
	// 9 SEPT  2022 JOSEPH ADORBOE  
switch ($refundsmodel)
{
	
	// 9 JAN 2024, 10 SEPT 2023, 08 SEPT 2022 
	case 'refundsearchfilter': 
		$patientrecords = htmlspecialchars(isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '');			
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
					$url = "cashier__refundssearch?$form_key";
					$engine->redirect($url);
				}
			}
		}

	break;

	// 10 JAN 2024, 09 SEPT 2022 JOSEPH ADORBOE 
	case 'saverefunds':
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$receiptnum = htmlspecialchars(isset($_POST['receiptnum']) ? $_POST['receiptnum'] : '');
		$walletbalance = htmlspecialchars(isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '');		
		$refundamount = htmlspecialchars(isset($_POST['refundamount']) ? $_POST['refundamount'] : '');	
		$refunddescription = htmlspecialchars(isset($_POST['refunddescription']) ? $_POST['refunddescription'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
						
				if(empty($refunddescription) || empty($refundamount) || empty($patientcode)){
					$status = "error";
					$msg = "Required Field cannot be null";
				}else{				
					if(!is_numeric($refundamount)){					
						$status = "error";
						$msg = "Amount Paid Should be Numbers Only.";
					}else{
						if($refundamount<'1'){
							$status = "error";
							$msg = "Amount Paid is not a valid number";
						}else{
						
						if("$refundamount">"$walletbalance"){
							$status = "error";
							$msg = "Amount Paid cannot be greater than wallet balance.";
						}else{
							
							$refundnumber = rand(100,10000);						
       						$sqlresults =  $patientrefundtable->newrefunds($form_key,$ekey,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$refundamount,$refunddescription,$currentusercode,$currentuser,$instcode,$receiptnum,$refundnumber,$currentday,$currentmonth,$currentyear);
	  
							// $a = $patientschemetable->updatepatientscheme($patientcode,$refundamount,$instcode,$prepaidchemecode);
							// $b = $cashiertillstable->updatetillrefund($currentshiftcode,$refundamount,$instcode,$cashschemecode);
							// $c = $cashiersummarytable->updaterefundsummary($currentshiftcode,$refundamount,$instcode);
			
							$action = "Refunds";							
							$result = $engine->getresults($sqlresults,$item=$patient,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=9865;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  	
					
						}

						}
					}
				}
			}
		}

	break;

	// 10 JAN 2024, 10 SEPT 2022 JOSEPH ADORBOE  
	case 'editrefunds':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');	
		$refunddescription = htmlspecialchars(isset($_POST['refunddescription']) ? $_POST['refunddescription'] : '');	
		$refundamount = htmlspecialchars(isset($_POST['refundamount']) ? $_POST['refundamount'] : '');	
		$walletbalance = htmlspecialchars(isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '');	
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				if(!is_numeric($refundamount)){					
					$status = "error";
					$msg = "Refund Amount  Should be Numbers Only.";
				}else{
					if($refundamount<'1'){
						$status = "error";
						$msg = "Refund Amount  is not a valid number";
					}else{
					
					if("$refundamount">"$walletbalance"){
						$status = "error";
						$msg = "Refund Amount  cannot be greater than wallet balance.";
					}else{	

				$sqlresults = $patientrefundtable->editrefundsrequest($ekey,$refunddescription,$refundamount,$instcode);		
				$action = "Refunds Edits";							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9863;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
					}
				}
			}
			}
		}

	break;

	// 10 JAN 2024, 10 SEPT 2022 JOSEPH ADORBOE  
	case 'approverefund':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');	
		$refunddescription = htmlspecialchars(isset($_POST['refunddescription']) ? $_POST['refunddescription'] : '');	
		$refundamount = htmlspecialchars(isset($_POST['refundamount']) ? $_POST['refundamount'] : '');	
		$walletbalance = htmlspecialchars(isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '');	
		$walletcode = htmlspecialchars(isset($_POST['walletcode']) ? $_POST['walletcode'] : '');	
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				if("$refundamount">"$walletbalance"){
					$status = "error";
					$msg = "Refund Amount  cannot be greater than wallet balance.";
				}else{	
							
				$sqlresults = $patientrefundtable->approverefund($ekey,$refunddescription,$days,$currentuser,$currentusercode,$instcode);
				if($sqlresults == '2'){
					$sqlresults = $patientschemetable->updatepatientschemewallet($refundamount,$instcode,$walletcode);
				}
				$action = "Refunds Approval";							
				$result = $engine->getresults($sqlresults,$item=$patient,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9864;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 
			}

			}
		}

	break;



	


































	// 27 MAR 2023 JOSEPH ADORBOE  
	case 'rejectinvestigationsreturns':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason)  || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->rejectinvestigationsreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Reject Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "200";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 27 MAR 2023 JOSEPH ADORBOE  
	case 'approveinvestigationsreturn':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paystatus = htmlspecialchars(isset($_POST['paystatus']) ? $_POST['paystatus'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->approveinvestigationsreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$visitcode,$amount,$paystatus=2,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode);
				$title = 'Approve Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "198";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 20 NOV 2022 JOSEPH ADORBOE  
	case 'rejectservicereturns':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason)  || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->rejectservicereturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Reject Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "200";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 02 OCT 2022 JOSEPH ADORBOE  
	case 'approveservicereturn':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paystatus = htmlspecialchars(isset($_POST['paystatus']) ? $_POST['paystatus'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->approveservicereturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$visitcode,$amount,$paystatus,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode);
				$title = 'Approve Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "198";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 02 OCT 2022 JOSEPH ADORBOE  
	case 'approveprocedurereturn':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$medicationcode = htmlspecialchars(isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->approveprocedurereturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode);
				$title = 'Approve Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "198";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 02 OCT  2022 JOSEPH ADORBOE  
	case 'rejectprocedurereturns':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->rejectproceduresreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Reject Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "200";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 28 SEPT 2022 JOSEPH ADORBOE  
	case 'approvedevicesreturn':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$medicationcode = htmlspecialchars(isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				$getqty = $pdevicesql->getdevicescurrentqty($medicationcode,$instcode);					
				$newqty = $getqty - $qty;					
				$edit = $cashierrefunds->approvedevicesreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$newqty,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode);
				$title = 'Approve Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "198";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	
	// 28 SEPT 2022 JOSEPH ADORBOE  
	case 'rejectdevicereturns':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->rejectdevicesreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Reject Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "200";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;
	
	// 25 SEPT 2022 JOSEPH ADORBOE  
	case 'approvemedicationreturn':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$medicationcode = htmlspecialchars(isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				$getqty = $pharmacysql->getmedicationdurrentqty($medicationcode,$instcode);
				$newqty = $getqty - $qty;					
									
				$edit = $cashierrefunds->approvemedicationreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$newqty,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode);
				$title = 'Approved Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "198";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

	// 25 SEPT 2022 JOSEPH ADORBOE  
	case 'rejectmedicationreturns':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$dispense = htmlspecialchars(isset($_POST['dispense']) ? $_POST['dispense'] : '');
		$qty = htmlspecialchars(isset($_POST['qty']) ? $_POST['qty'] : '');
		$amount = htmlspecialchars(isset($_POST['amount']) ? $_POST['amount'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($returnreason) || empty($dispense) || empty($qty) || empty($amount) || empty($paymentmethodcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->rejectmedicationreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Reject Returns';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "199";
					$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title  Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;
	
	
	
	// 09 SEPT 2022  JOSPH ADORBOE
	case 'refundssearch': 		
			$general = htmlspecialchars(isset($_POST['general']) ? $_POST['general'] : '');
			$patientrecords = htmlspecialchars(isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '');
			$fromdate = htmlspecialchars(isset($_POST['fromdate']) ? $_POST['fromdate'] : '');
			$todate = htmlspecialchars(isset($_POST['todate']) ? $_POST['todate'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
							$url = "cashier__refundreportpdflist?$form_key";
							$engine->redirect($url);

						}else if($general =='1'){
							if(!empty($patientrecords)){
								$value = $general.'@@@'.$patientrecords.'@@@'.$general;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "cashier__refundreportpdflist?$form_key";
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
	

		
	

	
	// 15 JUNE 2022 JOSEPH ADORBOE 
	case 'walletsearch':		
		$patientrecords = htmlspecialchars(isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
