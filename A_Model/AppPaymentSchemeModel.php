<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$paymentschememodel = htmlspecialchars(isset($_POST['paymentschememodel']) ? $_POST['paymentschememodel'] : '');
	
	// 6 MAR 2021
switch ($paymentschememodel)
{
	// 11 AUG 2023, 15 NOV 2022, 12 OCT 2020
	case 'editpaymentscheme':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$newscheme = htmlspecialchars(isset($_POST['newscheme']) ? $_POST['newscheme'] : '');
		$pmethod = htmlspecialchars(isset($_POST['pmethod']) ? $_POST['pmethod'] : '');
		$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');
		$schemepercentage = htmlspecialchars(isset($_POST['schemepercentage']) ? $_POST['schemepercentage'] : '');
		$patientpercentage = htmlspecialchars(isset($_POST['patientpercentage']) ? $_POST['patientpercentage'] : '');
		// $vkey = htmlspecialchars(isset($_POST['vkey']) ? $_POST['vkey'] : '');
		// $paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		// $paymentmethodname = htmlspecialchars(isset($_POST['paymentmethodname']) ? $_POST['paymentmethodname'] : '');
		// $partnercode = htmlspecialchars(isset($_POST['partnercode']) ? $_POST['partnercode'] : '');
		// $partnername = htmlspecialchars(isset($_POST['partnername']) ? $_POST['partnername'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($newscheme) || empty($pmethod) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';					
				}else{										
						if($patientpercentage > 100 || $patientpercentage < 0){
							$status = 'error';
							$msg = 'Patient percentage cannot be greater than 100 or less than 0';						
						}else{
							if(empty($patientpercentage)){
								$patientpercentage = 0;
							}															
							$schemepercentage = 100 - $patientpercentage;	
							// echo $pmethod;
							// die;
							$pay = explode('@@@', $pmethod);						
						$partnercode = $pay[0];
						$partnername = $pay[1];	
						$paymentmethodcode = $pay[2];
						$paymentmethodname = $pay[3];					
						$sqlresults = $paymentschemesql->update_paymentscheme($ekey, $newscheme, $desc, $paymentmethodcode, $paymentmethodname, $partnercode, $partnername, $schemepercentage, $patientpercentage, $plan,$currentusercode, $currentuser, $instcode,$patientspaymentschemecontroller);
						$action = 'Edit Payment Scheme';							
						$result = $engine->getresults($sqlresults,$item=$newscheme,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=241;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					
					}

				}
			}
	break;
	// 11 AUG 2023, 6 MAR 2021 JOSEPH ADORBOE
	case 'suspendpaymentscheme':			
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$newscheme = htmlspecialchars(isset($_POST['newscheme']) ? $_POST['newscheme'] : '');
		$vkey = htmlspecialchars(isset($_POST['vkey']) ? $_POST['vkey'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{										
					$sqlresults = $paymentschemetable->suspendpaymentscheme($currentusercode,$currentuser,$ekey);
					$action = 'Suspend Payment Scheme';							
				$result = $engine->getresults($sqlresults,$item=$newscheme,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=239;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}			
		}
	break;
	// 11 AUG 2023 6 MAR 2021 JOSEPH ADORBOE
	case 'activatepaymentscheme':			
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$newscheme = htmlspecialchars(isset($_POST['newscheme']) ? $_POST['newscheme'] : '');
		$vkey = htmlspecialchars(isset($_POST['vkey']) ? $_POST['vkey'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($ekey)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{										
					$sqlresults = $paymentschemetable->activatepaymentscheme($currentusercode,$currentuser,$ekey);
					$action = 'Activate Payment Scheme';							
					$result = $engine->getresults($sqlresults,$item=$newscheme,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=240;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}				
		}
	break;
	// 11 AUG 2023, 3 JAN 2021
	case 'addpaymentscheme':
		$newscheme = htmlspecialchars(isset($_POST['newscheme']) ? $_POST['newscheme'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$schemepercentage = htmlspecialchars(isset($_POST['schemepercentage']) ? $_POST['schemepercentage'] : '');
		$patientpercentage = htmlspecialchars(isset($_POST['patientpercentage']) ? $_POST['patientpercentage'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($newscheme) || empty($paymentmethod) || empty($plan) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';						
				}else{
					if ($patientpercentage > 100 || $patientpercentage < 0) {
						$status = 'error';
						$msg = 'Patient percentage cannot be greater than 100 or less than 0';
					} else {
						if (empty($patientpercentage)) {
							$patientpercentage = 0;
						}
						$schemepercentage = 100 - $patientpercentage;
						$pay = explode('@@@', $paymentmethod);
						$paymentmethodcode = $pay[2];
						$paymentmethodname = $pay[3];
						$partnercode = $pay[0];
						$partnername = $pay[1];
						$sqlresults = $paymentschemesql->insert_paymentscheme($form_key, $newscheme, $desc, $paymentmethodcode, $paymentmethodname, $partnercode, $partnername, $schemepercentage, $patientpercentage,$plan, $currentusercode, $currentuser, $instcode);
						$action = 'Add Payment Scheme';							
						$result = $engine->getresults($sqlresults,$item=$newscheme,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=95;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
					}
				}
									
			}
	break;	
	
	
	// // // 12 OCT 2020
	// // case 'editpaymentscheme':
	// // 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// // 	$newscheme = htmlspecialchars(isset($_POST['newscheme']) ? $_POST['newscheme'] : '');
	// // 	$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
	// // 	$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');

	// // 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// // 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// // 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
	// // 		if($preventduplicate == '1'){

	// // 			if(empty($newscheme) || empty($paymentmethod) ){

	// // 				$status = 'error';
	// // 				$msg = 'Required Field Cannot be empty';
					
	// // 			}else{

	// // 				if($paymentmethod !== $vkey){
						
	// // 					$pay = explode('@@@', $paymentmethod);
	// // 					$paymentmethodcode = $pay[0];
	// // 					$paymentmethodname = $pay[1];
	// // 					$partnercode = $pay[2];
	// // 					$partnername = $pay[3];
	// // 					$msql->update_scheme($ekey,$paymentmethodcode,$paymentmethodname,$partnercode,$partnername);
	// // 				}

					

	// // 				$editpaymentscheme = $msql->update_paymentscheme($ekey,$newscheme,$desc,$currentusercode,$currentuser,$instcode);


	// // 				if($editpaymentscheme == '0'){
					
	// // 					$status = "error";					
	// // 					$msg = "Edit Payment Scheme Unsuccessful"; 
	
	// // 				}else if($editpaymentscheme == '1'){					
						
	// // 					$status = "error";					
	// // 					$msg = "Payment Scheme Exist"; 				
						
	// // 				}else if($editpaymentscheme == '2'){
						
	// // 					$status = "success";
	// // 					$msg = "Edit Payment Scheme Successfully";
						
	// // 					$event= "Edit Payment Scheme ".$form_key." has been saved successfully ";
	// // 					$eventcode= "020";
	// // 					$userlogsql->auditlog($currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
	// // 					$msql->insertformkey($form_number,$form_key,$currentusercode,$currentuser,$instcode);
					
					
	// // 			}else{					
	// // 				$status = "error";					
	// // 				$msg = "Add Payment Method Unknown source "; 						
	// // 			}

	// // 			}
	// // 		}
	// // break;

	// // 6 MAR 2021 JOSEPH ADORBOE
	// case 'approvecreditrequest':			
	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$amountrequested = htmlspecialchars(isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '');
	// 	$patientduedate = htmlspecialchars(isset($_POST['patientduedate']) ? $_POST['patientduedate'] : '');
	// 	$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 		if($preventduplicate == '1'){
	// 			if(empty($ekey)){
	// 				$status = "error";
	// 				$msg = "Required Fields cannot be empty ";
	// 			}else{										
	// 				$approverequest = $patientcredittable->approvecreditrequested($desc,$amountrequested,$days,$currentusercode,$currentuser,$ekey);
				
	// 					if($approverequest == '0'){							
	// 						$status = "error";					
	// 						$msg = "Approve credit request".$ekey." Unsuccessful"; 			
	// 					}else if($approverequest == '1'){							
	// 						$status = "error";					
	// 						$msg = "Approve credit request ".$ekey." Exist"; 							
	// 					}else if($approverequest == '2'){
	// 						$event= "Approve credit request :".$ekey." has been successfully ";
	// 						$eventcode= 59;
	// 						$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 							if($audittrail == '2'){
	// 								$status = "success";
	// 								$msg = "Approve credit request ".$patient." Successfully";	
	// 							}else{
	// 								$status = "error";					
	// 								$msg = "Audit Trail Failed!"; 
	// 							}						
	// 					}else{					
	// 						$status = "error";					
	// 						$msg = "User Changes Unsuccessful "; 						
	// 					}			
	// 			}				
	// 	}
	// break;

	// // 6 MAR 2021 JOSEPH ADORBOE
	// case 'rejectcreditrequest':			
	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$amountrequested = htmlspecialchars(isset($_POST['amountrequested']) ? $_POST['amountrequested'] : '');
	// 	$patientduedate = htmlspecialchars(isset($_POST['patientduedate']) ? $_POST['patientduedate'] : '');
	// 	$desc = htmlspecialchars(isset($_POST['desc']) ? $_POST['desc'] : '');
	// 	$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 		if($preventduplicate == '1'){
	// 			if(empty($ekey)){
	// 				$status = "error";
	// 				$msg = "Required Fields cannot be empty ";
	// 			}else{										
	// 				$creditrequest = $patientcredittable->rejectcreditrequest($days,$desc,$currentusercode,$currentuser,$ekey);
				
	// 					if($creditrequest == '0'){							
	// 						$status = "error";					
	// 						$msg = "Reject credit request".$ekey." Unsuccessful"; 			
	// 					}else if($creditrequest == '1'){							
	// 						$status = "error";					
	// 						$msg = "Reject credit request ".$ekey." Exist"; 							
	// 					}else if($creditrequest == '2'){
	// 						$event= "Reject credit request :".$ekey." has been successfully ";
	// 						$eventcode= 60;
	// 						$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 							if($audittrail == '2'){
	// 								$status = "success";
	// 								$msg = "Reject credit request ".$patient." Successfully";	
	// 							}else{
	// 								$status = "error";					
	// 								$msg = "Audit Trail Failed!"; 
	// 							}						
	// 					}else{					
	// 						$status = "error";					
	// 						$msg = "User Changes Unsuccessful "; 						
	// 					}			
	// 			}				
	// 	}
	// break;



	// // 8 MAR 2021 JOSEPH ADORBOE
	// case 'deactivatecredit':			
	// 		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 			if($preventduplicate == '1'){
	// 				if(empty($form_key)){
	// 					$status = "error";
	// 					$msg = "Required Fields cannot be empty ";
	// 				}else{										
	// 					$deactivatecredit = $currenttable->deactivatefacilitycreditstatus($currentusercode,$currentuser,$instcode);					
	// 						if($deactivatecredit == '0'){							
	// 							$status = "error";					
	// 							$msg = "Deactivate credit ".$form_key." Unsuccessful"; 			
	// 						}else if($deactivatecredit == '1'){							
	// 							$status = "error";					
	// 							$msg = "Credit ".$form_key." Exist"; 							
	// 						}else if($deactivatecredit == '2'){
	// 							$event= "Deactivate credit :".$form_key." has been successfully ";
	// 							$eventcode= 58;
	// 							$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 								if($audittrail == '2'){
	// 									$status = "success";
	// 									$msg = "Deactivate Credit Successfully";	
	// 								}else{
	// 									$status = "error";					
	// 									$msg = "Audit Trail Failed!"; 
	// 								}						
	// 						}else{					
	// 							$status = "error";					
	// 							$msg = "User Changes Unsuccessful "; 						
	// 						}			
	// 				}				
	// 		}
	// break;
		

	// // 8 MAR 2021 JOSEPH ADORBOE
	// case 'activatecredit':			
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 		if($preventduplicate == '1'){
	// 			if(empty($form_key)){
	// 				$status = "error";
	// 				$msg = "Required Fields cannot be empty ";
	// 			}else{										
	// 				$activatecredit = $currenttable->activatefacilitycreditstatus($currentusercode,$currentuser,$instcode);
				
	// 					if($activatecredit == '0'){							
	// 						$status = "error";					
	// 						$msg = "Activate credit ".$form_key." Unsuccessful"; 			
	// 					}else if($activatecredit == '1'){							
	// 						$status = "error";					
	// 						$msg = "Credit ".$form_key." Exist"; 							
	// 					}else if($activatecredit == '2'){
	// 						$event= "Activate credit :".$form_key." has been successfully ";
	// 						$eventcode= 57;
	// 						$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 							if($audittrail == '2'){
	// 								$status = "success";
	// 								$msg = "Activate Credit Successfully";	
	// 							}else{
	// 								$status = "error";					
	// 								$msg = "Audit Trail Failed!"; 
	// 							}						
	// 					}else{					
	// 						$status = "error";					
	// 						$msg = "User Changes Unsuccessful "; 						
	// 					}			
	// 			}				
	// 	}
	// break;

	

	
	
		
		
}

?>
