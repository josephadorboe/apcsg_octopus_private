<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$cashierrecieptmodel = isset($_POST['cashierrecieptmodel']) ? $_POST['cashierrecieptmodel'] : '';
	
	// 9 SEPT  2022 JOSEPH ADORBOE  
switch ($cashierrecieptmodel)
{
	
	// 30 MAR 2023 JOSEPH ADORBOE  
	case 'changepaytype':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$methodcode = isset($_POST['methodcode']) ? $_POST['methodcode'] : '';
		$method = isset($_POST['method']) ? $_POST['method'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$shiftcode = isset($_POST['shiftcode']) ? $_POST['shiftcode'] : '';
		$shiftname = isset($_POST['shiftname']) ? $_POST['shiftname'] : '';
		$changereason = isset($_POST['changereason']) ? $_POST['changereason'] : '';
		$ownercode = isset($_POST['ownercode']) ? $_POST['ownercode'] : '';
		$owner = isset($_POST['owner']) ? $_POST['owner'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ||empty($patientpaymenttype) || empty($changereason)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{	
				// $newschemecode
				$kt = explode('@@@',$patientpaymenttype);
				$newschemecode = $kt['0'];
				$newscheme = $kt['1'];
				$newmethodcode = $kt['2'];
				$newmethod = $kt['3'];	
									
				$edit = $cashierreceiptssql->changepaymenttype($form_key,$day,$ekey,$totalamount,$newschemecode,$newscheme,$newmethodcode,$newmethod,$currentshiftcode,$currentshift,$methodcode,$method,$schemecode,$scheme,$shiftcode,$shiftname,$changereason,$days,$ownercode,$owner,$currentuser,$currentusercode,$instcode);
				$title = 'Payment Type Change';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for  Exist"; 					
				}else if($edit == '2'){
					$event= " $title  $schemecode to $newschemecode  successfully ";
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


	// 17 SEPT 2022  JOSPH ADORBOE
	case 'receiptsearch': 		
	//	$general = isset($_POST['general']) ? $_POST['general'] : '';
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';
	//	$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
	//	$todate = isset($_POST['todate']) ? $_POST['todate'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				// if(empty($general)){
				// 	$status = "error";
				// 	$msg = "Required Fields cannot be empty ";
				// }else{
											
				// 	if($general =='2'){
				// 		if(!empty($fromdate)){
				// 			$dt = explode('/', $fromdate);
				// 			$frommonth = $dt[0];
				// 			$fromday = $dt[1];
				// 			$fromyear = $dt[2];
				// 			$ffromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
				// 		}	
						
				// 		if(!empty($todate)){
				// 			$dt = explode('/', $todate);
				// 			$tomonth = $dt[0];
				// 			$today = $dt[1];
				// 			$toyear = $dt[2];
				// 			$ttodate = $toyear.'-'.$tomonth.'-'.$today;
				// 		}

				// 		$value = $general.'@@@'.$ffromdate.'@@@'.$ttodate;
				// 		$msql->passingvalues($pkey=$form_key,$value);					
				// 		$url = "cashier__refundreportpdflist?$form_key";
				// 		$engine->redirect($url);

				// 	}else if($general =='1'){
				if(!empty($patientrecords)){
				//	$value = $general.'@@@'$patientrecords.'@@@'.$general;
					$msql->passingvalues($pkey=$form_key,$patientrecords);					
					$url = "cashier__cashier__managereceiptsadd?$form_key";
					$engine->redirect($url);
				}else{
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}
						
					// }	
						
					// }
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
	
	
		
	// 17 SEPT 2022 JOSEPH ADORBOE 
	case 'reversereceipts':
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$receiptnumber = isset($_POST['receiptnumber']) ? $_POST['receiptnumber'] : '';
		$reversereason = isset($_POST['reversereason']) ? $_POST['reversereason'] : '';		
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';	
		// $refunddescription = isset($_POST['refunddescription']) ? $_POST['refunddescription'] : '';
		$ekeys = isset($_POST['ekeys']) ? $_POST['ekeys'] : '';			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";				
				}else{						
						
					if(empty($ekeys) || empty($reversereason) || empty($patientnumber)){
						$status = 'error';
						$msg = 'Required Field cannot be null';
					}else{	

						if(empty($_POST["scheckbox"])){   
							$status = "error";
							$msg = "Required Fields cannot be empty!!";	 
						}else{
						
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$billitemcode = $kt['0'];
							$billcode = $kt['1'];
							$billdpt = $kt['2'];
							$amt = $kt['3'];
							$billservicecode = $kt['4'];
						//	$dpts = $kt['5'];
						
							
						$reversereceipts = $cashierreceiptssql->reversereceipts($ekeys,$billitemcode,$billdpt,$amt,$billservicecode,$visitcode,$form_key,$prepaidcode,$prepaid,$prepaidchemecode,$prepaidscheme,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$reversereason,$receiptnumber,$currentusercode,$currentuser,$instcode);
						$title = 'Reverse Receipt';
						if($reversereceipts == '0'){						
							$status = 'error';
							$msg = "$title Unsuccessful";						
						}else if($reversereceipts == '1'){						
							$status = 'error';
							$msg = "$title Already done";						
						}else if($reversereceipts == '2'){
							$cashierreceiptssql->cancelreceipt($ekeys,$days,$currentusercode,$currentuser,$reversereason,$instcode);
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
