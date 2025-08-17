<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$paymentschememodel = isset($_POST['paymentschememodel']) ? $_POST['paymentschememodel'] : '';
	
	// 6 MAR 2021
switch ($paymentschememodel)
{
		
	
	
	// // 12 OCT 2020
	// case 'editpaymentscheme':
	// 	$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
	// 	$newscheme = isset($_POST['newscheme']) ? $_POST['newscheme'] : '';
	// 	$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
	// 	$desc = isset($_POST['desc']) ? $_POST['desc'] : '';

	// 	$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
	// 	$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
	// 		if($preventduplicate == '1'){

	// 			if(empty($newscheme) || empty($paymentmethod) ){

	// 				$status = 'error';
	// 				$msg = 'Required Field Cannot be empty';
					
	// 			}else{

	// 				if($paymentmethod !== $vkey){
						
	// 					$pay = explode('@@@', $paymentmethod);
	// 					$paymentmethodcode = $pay[0];
	// 					$paymentmethodname = $pay[1];
	// 					$partnercode = $pay[2];
	// 					$partnername = $pay[3];
	// 					$msql->update_scheme($ekey,$paymentmethodcode,$paymentmethodname,$partnercode,$partnername);
	// 				}

					

	// 				$editpaymentscheme = $msql->update_paymentscheme($ekey,$newscheme,$desc,$currentusercode,$currentuser,$instcode);


	// 				if($editpaymentscheme == '0'){
					
	// 					$status = "error";					
	// 					$msg = "Edit Payment Scheme Unsuccessful"; 
	
	// 				}else if($editpaymentscheme == '1'){					
						
	// 					$status = "error";					
	// 					$msg = "Payment Scheme Exist"; 				
						
	// 				}else if($editpaymentscheme == '2'){
						
	// 					$status = "success";
	// 					$msg = "Edit Payment Scheme Successfully";
						
	// 					$event= "Edit Payment Scheme ".$form_key." has been saved successfully ";
	// 					$eventcode= "020";
	// 					$msql->auditlog($currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
	// 					$msql->insertformkey($form_number,$form_key,$currentusercode,$currentuser,$instcode);
					
					
	// 			}else{					
	// 				$status = "error";					
	// 				$msg = "Add Payment Method Unknown source "; 						
	// 			}

	// 			}
	// 		}
	// break;

	// 6 MAR 2021 JOSEPH ADORBOE
	case 'approvecreditrequest':			
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$amountrequested = isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '';
		$patientduedate = isset($_POST['patientduedate']) ? $_POST['patientduedate'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{										
					$approverequest = $patientcredittable->approvecreditrequested($desc,$amountrequested,$days,$currentusercode,$currentuser,$ekey);
				
						if($approverequest == '0'){							
							$status = "error";					
							$msg = "Approve credit request".$ekey." Unsuccessful"; 			
						}else if($approverequest == '1'){							
							$status = "error";					
							$msg = "Approve credit request ".$ekey." Exist"; 							
						}else if($approverequest == '2'){
							$event= "Approve credit request :".$ekey." has been successfully ";
							$eventcode= 59;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "Approve credit request ".$patient." Successfully";	
								}else{
									$status = "error";					
									$msg = "Audit Trail Failed!"; 
								}						
						}else{					
							$status = "error";					
							$msg = "User Changes Unsuccessful "; 						
						}			
				}				
		}
	break;

	// 6 MAR 2021 JOSEPH ADORBOE
	case 'rejectcreditrequest':			
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$amountrequested = isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '';
		$patientduedate = isset($_POST['patientduedate']) ? $_POST['patientduedate'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{										
					$creditrequest = $patientcredittable->rejectcreditrequest($days,$desc,$currentusercode,$currentuser,$ekey);
				
						if($creditrequest == '0'){							
							$status = "error";					
							$msg = "Reject credit request".$ekey." Unsuccessful"; 			
						}else if($creditrequest == '1'){							
							$status = "error";					
							$msg = "Reject credit request ".$ekey." Exist"; 							
						}else if($creditrequest == '2'){
							$event= "Reject credit request :".$ekey." has been successfully ";
							$eventcode= 60;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "Reject credit request ".$patient." Successfully";	
								}else{
									$status = "error";					
									$msg = "Audit Trail Failed!"; 
								}						
						}else{					
							$status = "error";					
							$msg = "User Changes Unsuccessful "; 						
						}			
				}				
		}
	break;



	// 8 MAR 2021 JOSEPH ADORBOE
	case 'deactivatecredit':			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
				if($preventduplicate == '1'){
					if(empty($form_key)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{										
						$deactivatecredit = $paymentschemesql->deactivatefacilitycreditstatus($currentusercode,$currentuser,$instcode);
					
							if($deactivatecredit == '0'){							
								$status = "error";					
								$msg = "Deactivate credit ".$form_key." Unsuccessful"; 			
							}else if($deactivatecredit == '1'){							
								$status = "error";					
								$msg = "Credit ".$form_key." Exist"; 							
							}else if($deactivatecredit == '2'){
								$event= "Deactivate credit :".$form_key." has been successfully ";
								$eventcode= 58;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Deactivate Credit Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}						
							}else{					
								$status = "error";					
								$msg = "User Changes Unsuccessful "; 						
							}			
					}				
			}
	break;
		

	// 8 MAR 2021 JOSEPH ADORBOE
	case 'activatecredit':			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($form_key)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{										
					$activatecredit = $paymentschemesql->activatefacilitycreditstatus($currentusercode,$currentuser,$instcode);
				
						if($activatecredit == '0'){							
							$status = "error";					
							$msg = "Activate credit ".$form_key." Unsuccessful"; 			
						}else if($activatecredit == '1'){							
							$status = "error";					
							$msg = "Credit ".$form_key." Exist"; 							
						}else if($activatecredit == '2'){
							$event= "Activate credit :".$form_key." has been successfully ";
							$eventcode= 57;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
								if($audittrail == '2'){
									$status = "success";
									$msg = "Activate Credit Successfully";	
								}else{
									$status = "error";					
									$msg = "Audit Trail Failed!"; 
								}						
						}else{					
							$status = "error";					
							$msg = "User Changes Unsuccessful "; 						
						}			
				}				
		}
	break;

		// 6 MAR 2021 JOSEPH ADORBOE
		case 'activatepaymentscheme':			
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
				if($preventduplicate == '1'){
					if(empty($ekey)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{										
						$activatescheme = $paymentschemetable->activatepaymentscheme($currentusercode,$currentuser,$ekey);
					
							if($activatescheme == '0'){							
								$status = "error";					
								$msg = "Activate Scheme ".$vkey." Unsuccessful"; 			
							}else if($activatescheme == '1'){							
								$status = "error";					
								$msg = "Payment Scheme ".$vkey." Exist"; 							
							}else if($activatescheme == '2'){
								$event= "Activate Payament scheme :".$ekey." has been successfully ";
								$eventcode= 56;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Activate Scheme ".$vkey." Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}						
							}else{					
								$status = "error";					
								$msg = "User Changes Unsuccessful "; 						
							}			
					}				
			}
		break;

	
		// 6 MAR 2021 JOSEPH ADORBOE
		case 'suspendpaymentscheme':			
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
				if($preventduplicate == '1'){
					if(empty($ekey)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{										
						$suspendscheme = $paymentschemetable->suspendpaymentscheme($currentusercode,$currentuser,$ekey);
					
							if($suspendscheme == '0'){							
								$status = "error";					
								$msg = "Suspend Scheme ".$vkey." Unsuccessful"; 			
							}else if($suspendscheme == '1'){							
								$status = "error";					
								$msg = "Payment Scheme ".$vkey." Exist"; 							
							}else if($suspendscheme == '2'){
								$event= "Suspend Payament scheme :".$ekey." has been successfully ";
								$eventcode= 56;
								$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Suspend Scheme ".$vkey." Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}						
							}else{					
								$status = "error";					
								$msg = "User Changes Unsuccessful "; 						
							}			
					}
				
			}
		break;
		
		
}


// $creditlist = ("SELECT * from octopus_patients_credit where CREDIT_STATUS IN('1','2') and CREDIT_INSTCODE = '$instcode' ");
// $gecreditlist = $dbconn->query($creditlist);
?>
