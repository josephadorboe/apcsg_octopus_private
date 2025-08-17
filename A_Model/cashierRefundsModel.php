<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$cashierrefundsmodel = isset($_POST['cashierrefundsmodel']) ? $_POST['cashierrefundsmodel'] : '';
	
	// 9 SEPT  2022 JOSEPH ADORBOE  
switch ($cashierrefundsmodel)
{

	// 27 MAR 2023 JOSEPH ADORBOE  
	case 'rejectinvestigationsreturns':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paystatus = isset($_POST['paystatus']) ? $_POST['paystatus'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paystatus = isset($_POST['paystatus']) ? $_POST['paystatus'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$dispense = isset($_POST['dispense']) ? $_POST['dispense'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
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
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
	
	// 10 SEPT 2022 JOSEPH ADORBOE  
	case 'approverefund':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
									
				$edit = $cashierrefunds->approverefund($ekey,$days,$currentuser,$currentusercode,$instcode);
				$title = 'Approve Refund';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title   successfully ";
					$eventcode= "101";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
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
	

		
	// 09 SEPT 2022 JOSEPH ADORBOE 
	case 'saverefunds':
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$receiptnum = isset($_POST['receiptnum']) ? $_POST['receiptnum'] : '';
		$walletbalance = isset($_POST['walletbalance']) ? $_POST['walletbalance'] : '';		
		$refundamount = isset($_POST['refundamount']) ? $_POST['refundamount'] : '';	
		$refunddescription = isset($_POST['refunddescription']) ? $_POST['refunddescription'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
						
				if(empty($refunddescription) || empty($refundamount) || empty($patientcode)){
					$status = 'error';
					$msg = 'Required Field cannot be null';
				}else{				
					if(!is_numeric($refundamount)){					
						$status = 'error';
						$msg = 'Amount Paid Should be Numbers Only.';
					}else{
						if($refundamount<'1'){
							$status = 'error';
							$msg = 'Amount Paid is not a valid number';
						}else{
						
						// if("$refundamount">"$walletbalance"){
						//	$status = 'error';
						//	$msg = 'Amount Paid cannot be greater than wallet balance.';
						// }else{
							$tillbalance = $cashierrefunds->checkcashiertillbalance($currentshiftcode,$cashschemecode,$day,$instcode);
							if($tillbalance < $refundamount){
								$status = 'error';
								$msg = 'Amount Paid cannot be greater than Cashier Till cash Balance.';
							}else{

							
							$refundnumber = $coder->getrefundnumber($instcode);
							$generatereciept = $cashierrefunds->saverefunds($form_key,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$refundamount,$refunddescription,$currentusercode,$currentuser,$instcode,$receiptnum,$refundnumber,$prepaidchemecode,$currentday,$currentmonth,$currentyear,$cashschemecode);
							$title = 'Refunds';
							if($generatereciept == '0'){						
								$status = 'error';
								$msg = "$title Unsuccessful";						
							}else if($generatereciept == '1'){						
								$status = 'error';
								$msg = "$title Already done";						
							}else if($generatereciept == '2'){
							//	$cashierwalletsql->cashierwallettillsoperations($form_key,$day, $currentshift,$currentusercode,$paycode,$payname,$paymethcode,$paymeth,$amountpaid,$currentuser,$currentshiftcode,$instcode);
								$event= " $title done $form_key successfully";
								$eventcode= 51;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "$title for $patient Successfully";	
									// $url = "cashier__receiptwalletdetails?$form_key";
									// $engine->redirect($url);	
								}else{
									$status = "error";					
									$msg = "Audit Trail Failed!"; 
								}																
							}else{						
								$status = 'error';
								$msg = 'Unknown Source';						
						//	}
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
