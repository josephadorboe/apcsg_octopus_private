 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$pharmacymodel = isset($_POST['pharmacymodel']) ? $_POST['pharmacymodel'] : '';

	// $speciementlist = ("SELECT * from octopus_st_labspecimen where SP_STATUS = '1' ");
	// $getspeciementlist = $dbconn->query($speciementlist);

	// $discplinelist = ("SELECT * from octopus_st_labdiscipline where LD_STATUS = '1' ");
	// $getdiscplinelist = $dbconn->query($discplinelist);

	// $labstestslist = ("SELECT * from octopus_st_labtest where LTT_STATUS = '1' ");
	// $getlabstestslist = $dbconn->query($labstestslist);
	
	// 23 APR 2021 
switch ($pharmacymodel)
{
	
	// 20 APR 2023 JOSPH ADORBOE
	case 'extendexpiry':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		// $medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$expirydate = isset($_POST['expirydate']) ? $_POST['expirydate'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
                    $add = $pharmacysql->extendexpiry($ekey,$expirydate,$days,$currentuser,$currentusercode,$instcode);
                    $title = 'Expiry Extended';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $medication Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $medication  Exist";
                    } elseif ($add == '2') {
                        $event= " $title $medication  successfully ";
                        $eventcode= "159";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " $title $medication Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            
		}

	break;
	
	// 23 AUG 2021 JOSEPH ADORBOE 
	case 'pharmacyreports': 

		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';
		$fromdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
		$todate = isset($_POST['todate']) ? $_POST['todate'] : '';
		$reportshift = isset($_POST['reportshift']) ? $_POST['reportshift'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($reportshift) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$reportshift;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacyreportpage?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($reportshift) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$reportshift;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacyreportpage?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacyreportpage?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacyreportpage?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '5'){
					if(empty($todate) || empty($fromdate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{

						$fdate = explode('/', $fromdate);
						$mmdf = $fdate[0];
						$dddf = $fdate[1];
						$yyyf = $fdate[2];
						$fromdate = $yyyf.'-'.$mmdf.'-'.$dddf;

						$cdate = explode('/', $todate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$todate = $yyy.'-'.$mmd.'-'.$ddd;					

						$value = $searchfilter.'@@@'.$fromdate.'@@@'.$todate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "pharmacyreportpage?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;
	

	// 20 AUG 2021 JOSPH ADORBOE
	case 'editdevices':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		$devices = isset($_POST['devices']) ? $_POST['devices'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($devices)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{											
				$devices = strtoupper($devices);
				$edit = $pharmacysql->editnewdevices($ekey,$devices,$currentuser,$currentusercode,$instcode);
				$title = 'Edit Devices';
				if($edit == '0'){				
					$status = "error";					
					$msg = "".$title." ".$devices."  Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "".$title." ".$devices."  Exist"; 					
				}else if($edit == '2'){
					$event= " ".$title." ".$devices."  successfully ";
					$eventcode= "42";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$devices." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
				}	
			}
		}

	break;

	// 26 JULY 2021 JOSEPH ADORBOE
	case 'reversesendoutdevicepharmacysingle':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);

		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                $answer = $pharmacysql->reversesendoutdevicepharmacysingle($ekey, $currentusercode, $currentuser);
                        
                if ($answer == '1') {
                    $status = "error";
                    $msg = "Already Selected";
                } elseif ($answer == '2') {
                    $event= "Reverser send out Device ".$ekey." for  has been saved successfully ";
                    $eventcode= 161;
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = "Sent Out Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail Failed!";
                    }
                } elseif ($answer == '0') {
                    $status = "error";
                    $msg = "Unsuccessful";
                } else {
                    $status = "error";
                    $msg = "Unknown Source";
                }
            }
			
			}
	break;

	// 26 JULY  2021 JOSEPH ADORBOE 
	case 'deviceprescriptionsentoutsearch': 
		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "deviceprescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;	

	// 29 JUNE 2021 JOSEPH ADORBOE 
	case 'setitempricedevice':	
		$item = isset($_POST['item']) ? $_POST['item']: '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode']: '';
		$schemcode = isset($_POST['schemcode']) ? $_POST['schemcode']: '';
		$schemename = isset($_POST['schemename']) ? $_POST['schemename']: '';
		$method = isset($_POST['method']) ? $_POST['method']: '';
		$methodcode = isset($_POST['methodcode']) ? $_POST['methodcode']: '';
		$itemprice = isset($_POST['itemprice']) ? $_POST['itemprice']: '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode']: '';
		$type = isset($_POST['type']) ? $_POST['type']: '';
		$qty = isset($_POST['qty']) ? $_POST['qty']: '';
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
					$totalprice = $itemprice*$qty;	
					$setprice = $pharmacysql->setpricedeviceprescription($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$totalprice,$currentuser,$currentusercode,$instcode);
					$title = 'Set Price';
					if($setprice == '0'){							
						$status = "error";					
						$msg = "".$title." for ".$itemprice." Unsuccessful"; 
					}else if($setprice == '1'){						
						$status = "error";					
						$msg = "".$title." for  ".$itemprice." Exist Already"; 							
					}else if($setprice == '2'){	
						$event= "".$title." for : ".$item." for has been saved successfully ";
						$eventcode= 171;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." for ".$item." Successfully";	
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
	
	// 28 JUN 2021 JOSEPH ADORBOE
	case 'manageeditpharamcyprescriptions':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$paymentscheme = isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '';
		$payment = isset($_POST['payment']) ? $_POST['payment'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($visitcode) || empty($patientcode) || empty($paymentscheme) || empty($payment)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{
                    $ps = explode('@@@', $paymentscheme);
                    $paymentschemecode = $ps[0];
                    $paymentscheme = $ps[1];
                    $paymentmethodcode = $ps[2];
                    $paymethname = $ps[3];
    
                    $answer = $pharmacysql->editprescriptionmanage($visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                        
                    if ($answer == '1') {
                        $status = "error";
                        $msg = "Already Selected";
                    } elseif ($answer == '2') {
                        $event= "Changed has been saved successfully ";
                        $eventcode= 165;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Change Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } elseif ($answer == '0') {
                        $status = "error";
                        $msg = "Unsuccessful";
                    } else {
                        $status = "error";
                        $msg = "Unknown Source";
                    }
                }
            }
			
			}
	break;

	// 16 JUNE 2021 JOSEPH ADORBOE 
	case 'prescriptionsentoutsearch': 
		$searchfilter = isset($_POST['searchfilter']) ? $_POST['searchfilter'] : '';
		$searchitem = isset($_POST['searchitem']) ? $_POST['searchitem'] : '';
		$prescriptiondate = isset($_POST['prescriptiondate']) ? $_POST['prescriptiondate'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){			
			if(empty($searchfilter) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{					
				if($searchfilter == '1'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '2'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '3'){
					if(empty($searchitem) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$value = $searchfilter.'@@@'.$searchitem;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}else if($searchfilter == '4'){
					if(empty($prescriptiondate) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
						$cdate = explode('/', $prescriptiondate);
						$mmd = $cdate[0];
						$ddd = $cdate[1];
						$yyy = $cdate[2];
						$prescriptiondate = $yyy.'-'.$mmd.'-'.$ddd;

						$value = $searchfilter.'@@@'.$prescriptiondate;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "prescriptionsendout?$form_key";
						$engine->redirect($url);
                    }
				}					
			}			
		}

	break;
	

	// 15 JUN 2021 JOSEPH ADORBOE
	case 'reversesendoutpharmacy':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';			
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
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$pharmacystate = $kt['6'];
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];
							$paymenttype = $kt['10'];
							$billingcode = md5(microtime());
							$depts = 'PHARMACY';

							if($pharmacystate !== '8'){
								$status = "error";
								$msg = "Only Sentout Pescription can be reversed "; 
							}else{								
							//	$serviceamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
								$answer = $pharmacysql->reversepharmacysentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser);
						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item SENT OUT REVERSED ".$bcode." for  has been saved successfully ";
									$eventcode= 161;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Sent Out Successfully";	
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
						//	}
							}							
						}			
					}			
				}
		
			}
	break;

	// 20 APR 2023 JOSPH ADORBOE
	case 'closeexpiry':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		// $medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		// $qtyleft = isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
                    $add = $pharmacysql->closeexpiry($ekey,$days,$currentuser,$currentusercode,$instcode);
                    $title = 'Sold Out';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $medication Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $medication  Exist";
                    } elseif ($add == '2') {
                        $event= " $title $medication  successfully ";
                        $eventcode= "159";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " $title $medication Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            
		}

	break;

	// 13 JUNE 2021 JOSPH ADORBOE
	case 'removemedication':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		$medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$qtyleft = isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($medicationcode) || empty($qtyleft) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
                $currentqty = $pharmacysql->getmedicationdurrentqty($medicationcode, $instcode);
                if ($qtyleft > $currentqty) {
                    $status = 'error';
                    $msg = 'Current qty is less than qty to be removed from shelf';
                } else {
					$cost = $requestionsql->getcashprice($medicationcode, $itemtype =1, $cashschemecode ,$instcode);
					$totalqty = $pharmacysql->getmedicationdurrenttotalqty($medicationcode, $instcode);
					$stockvalue = $cost*$totalqty;
					if($totalqty == '-1'){
						$stockvalue = 0;
					}
					
                    $add = $pharmacysql->removemedications($ekey, $medicationcode, $qtyleft, $days, $stockvalue,$currentuser, $currentusercode,$instcode);
                    $title = 'Sold Out Medication';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $medication Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $medication Exist";
                    } elseif ($add == '2') {
                        $event= "$title $medication successfully ";
                        $eventcode= "159";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "$title $medication Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            }
            
		}

	break;
	

	// 13 JUNE 2021 JOSPH ADORBOE
	case 'medicationsoldout':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		$medicationcode = isset($_POST['medicationcode']) ? $_POST['medicationcode'] : '';
		$qtyleft = isset($_POST['qtyleft']) ? $_POST['qtyleft'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($medicationcode) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
                    $add = $pharmacysql->soldoutmedications($ekey,$days,$currentuser, $currentusercode);
                    $title = 'Sold Out';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "$title $medication Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "$title $medication  Exist";
                    } elseif ($add == '2') {
                        $event= " $title $medication  successfully ";
                        $eventcode= "159";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " $title $medication Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            
		}

	break;
	
	// 04 JUNE 2021 JOSPH ADORBOE 
	case 'stockadjustment':
		$medications = isset($_POST['medications']) ? $_POST['medications'] : '';
		$devices = isset($_POST['devices']) ? $_POST['devices'] : '';	
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$expirydate = isset($_POST['expirydate']) ? $_POST['expirydate'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($qty) || empty($expirydate) || empty($type) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{

				if($type == '1'){
					$med = explode('@@@', $medications);
					$medcode = $med[0];
					$mednum = $med[4];
					$medname = $med[1];
					$medqty = $med[5];
				}
                if($type == '2'){
				//	die($devices);
					$med = explode('@@@', $devices);
					$medcode = $med[0];
					$mednum = $med[1];
					$medname = $med[2];
					$medqty = $med[3];
				}

				
                $adjustmentnumber = $coder->getstockadjustmentnumber($instcode);
                $newqty = $medqty + $qty;

                $exp = explode('/', $expirydate);
                $dd = $exp['1'];
                $mm = $exp['0'];
                $yy = $exp['2'];
                $expire = $yy.'-'.$mm.'-'.$dd;
                $expirycode = md5(microtime());

                if ($expire < $day) {
                    $status = "error";
                    $msg = " Stock expiry date cannot be before ".$day."  Unsuccessful";
                } else {
                    $add = $pharmacysql->addstockadjustment($form_key, $adjustmentnumber, $medcode, $mednum, $medname, $newqty, $medqty, $qty, $days, $day, $expire, $expirycode, $type,$currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode);
                    $title = 'New Stock Adjustment added';
                    if ($add == '0') {
                        $status = "error";
                        $msg = "".$title." ".$medname."  Unsuccessful";
                    } elseif ($add == '1') {
                        $status = "error";
                        $msg = "".$title." ".$medname."  Exist";
                    } elseif ($add == '2') {
                        $event= " ".$title." ".$medname."  successfully ";
                        $eventcode= "158";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " ".$title." ".$medname." Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unknown source ";
                    }
                }
            }
		}

	break;


	// 03 JUNE 2021 JOSPH ADORBOE
	case 'addnewsupply':
		$supplydate = isset($_POST['supplydate']) ? $_POST['supplydate'] : '';	
		$supplier = isset($_POST['supplier']) ? $_POST['supplier'] : '';
		$receiptnumber = isset($_POST['receiptnumber']) ? $_POST['receiptnumber'] : '';
		$totalamount = isset($_POST['totalamount']) ? $_POST['totalamount'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($receiptnumber) || empty($supplydate) || empty($supplier) || empty($totalamount)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					

				$supp = explode('@@@', $supplier);
				$suppcode = $supp[0];
				$suppnum = $supp[1];	
				$suppname = $supp[2];				
				$suppliesnumber = $setupsql->getlastsuppliescodenumber($instcode);	
				if($currentuserlevel == '7'){
                    $source = 'PHARMACY';
                } 			
				
				$ext = '.pdf';
				$finame = $form_key.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $invoices.$finame;
				move_uploaded_file($file_temp_loc, $file_store);

				$add = $pharmacysql->addnewsupply($form_key,$suppcode,$suppnum,$suppname,$receiptnumber,$totalamount,$supplydate,$day,$suppliesnumber,$finame,$source,$currentuser,$currentusercode,$instcode);
				$title = 'New supplies added';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." ".$suppliesnumber."  Unsuccessful"; 
				}else if($add == '1'){				
					$status = "error";					
					$msg = "".$title." ".$suppliesnumber."  Exist"; 					
				}else if($add == '2'){
					$event= " ".$title." ".$suppliesnumber."  successfully ";
					$eventcode= "42";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$suppliesnumber." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
				}	
			}
		}

	break; 

	// 13 MAY 2021 JOSPH ADORBOE
	case 'editmedication':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';	
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';	
		$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
		$unit = isset($_POST['unit']) ? $_POST['unit'] : '';
		$restock = isset($_POST['restock']) ? $_POST['restock'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$medicationnumber = isset($_POST['medicationnumber']) ? $_POST['medicationnumber'] : '';
		$mnum = isset($_POST['mnum']) ? $_POST['mnum'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($medication) || empty($dosageform) || empty($unit) || empty($restock)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$dose = explode('@@@', $dosageform);
				$dosageformcode = $dose[0];
				$dosageformname = $dose[1];	
				
				$unt = explode('@@@', $unit);
				$untcode = $unt[0];
				$untname = $unt[1];
				if(empty($medicationnumber)){
					$medicationnumber = $setupsql->getlastmedicationcodenumber($instcode);
				}					
				$medication = strtoupper($medication);

				$edit = $pharmacysql->editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$currentuser,$currentusercode,$instcode);
				$title = 'Edit Medication';
				if($edit == '0'){				
					$status = "error";					
					$msg = "".$title." ".$medication."  Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "".$title." ".$medication."  Exist"; 					
				}else if($edit == '2'){
					$event= " ".$title." ".$medication."  successfully ";
					$eventcode= "42";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$medication." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
				}	
			}
		}

	break;
	
	// 26 APR 2021
	case 'dispense':		
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
				
					foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$pharamcystate = $kt['6'];
							$qty = $kt['10'];							
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];

                            if ($pharamcystate == '4') {
                                $dispense = 1;
                            }else if($pharamcystate == '9'){
								$dispense = 1;
							}else{
								$dispense = '0';
							}

							if($dispense == '0'){
								$status = "error";
								$msg = "Only Paid Prescription can be Dispensed"; 
							}else{					
								$getqty = $pharmacysql->getmedicationdurrentqty($servicescode,$instcode);
								$newqty = $getqty - $qty;
								$answer = $pharmacysql->prescriptiondispense($bcode,$days,$servicescode,$qty,$cost,$newqty,$patientcode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
								$title = 'Prescription dispensed';
								if($answer == '1'){
									$status = "error";
									$msg = "".$title." Already Selected";
								}else if($answer == '2'){
									$event= "".$title."  ".$bcode." for  has been saved successfully ";
									$eventcode= 103;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									$claimsnumber = $coder->getclaimsnumber($instcode);
									$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);
									if($audittrail == '2'){
										$status = "success";
										$msg = "".$title."  Successfully";		
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
		
			}
	break;

	// 26 APR 2021
	case 'sendforpayment':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';
		$patientpaymenttype = isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '';
		$patienttype = isset($_POST['patienttype']) ? $_POST['patienttype'] : '';			
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if (empty($_POST["scheckbox"])) {
                    $status = "error";
                    $msg = "Required Fields cannot be empty";
                } else {
                    $bbcode = md5(microtime());
                    $billcode = $cashiersql->getpatientbillingcode($bbcode, $patientcode, $patientnumber, $patient, $days, $visitcode, $currentuser, $currentusercode, $instcode);

                    foreach ($_POST["scheckbox"] as $key) {
                        $kt = explode('@@@', $key);
                        $bcode = $kt['0'];
                        $servicescode = $kt['1'];
                        $depts = $kt['2'];
                        $cost = $kt['3'];
                        $paymentmethodcode = $kt['4'];
                        $paymentschemecode = $kt['5'];
                        $pharmacystate = $kt['6'];
                        $serviceitem = $kt['7'];
                        $paymentmethod = $kt['8'];
                        $paymentscheme = $kt['9'];
						$billercode = $kt['13'];
						$biller = $kt['14'];
                        //	$paymenttype = $kt['10'];
                        $billingcode = md5(microtime());
                        $depts = 'PHARMACY';
                        if ($pharmacystate !== '2') {
                            $status = "error";
                            $msg = "Only Selected Prescription can be Process Payment";
                        } else {
                            if ($cost == '-1') {
                                $status = "error";
                                $msg = "Price has not been set";
                            } else {
                                if ($cost == '0') {
                                    $status = "error";
                                    $msg = "Total Amount cannot be zero";
                                } else {
									$schemepricepercentage = $paymentschemetable->getschemepercentage($paymentschemecode,$instcode);                                          

                                // for cash
                                    if ($paymentmethodcode == $cashpaymentmethodcode) {
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }
                                
                                        // for momo
                                    } elseif ($paymentmethodcode == $mobilemoneypaymentmethodcode) {
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }

                                        // for private insurance
                                    } elseif ($paymentmethodcode == $privateinsurancecode) {
                                        $patientpaymenttype = 1;
										if($schemepricepercentage < 100){
											$patientpaymenttype = 1;
										}
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }

                                        // for partner companies
                                    } elseif ($paymentmethodcode == $partnercompaniescode) {
                                        $patientpaymenttype = 1;
										if($schemepricepercentage < 100){
											$patientpaymenttype = 1;
										}
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }
                                
                                        // for NHIS
                                    } elseif ($paymentmethodcode == $nationalinsurancecode) {
										$patientpaymenttype = 1;
										if($schemepricepercentage < 100){
											$patientpaymenttype = 1;
										}
                                        
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }


                                        // for others
                                    } else {

                                //	$patientpaymenttype = 7;
                                        $answer = $pharmacysql->prescriptionssendtopayment($form_key, $billingcode, $visitcode, $bcode, $billcode, $day, $days, $patientcode, $patientnumber, $patient, $servicescode, $serviceitem, $paymentmethodcode, $paymentmethod, $paymentschemecode, $paymentscheme, $cost, $depts, $patientpaymenttype, $patienttype, $currentuser, $currentusercode, $currentshift, $currentshiftcode, $instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
                        
                                        if ($answer == '1') {
                                            $status = "error";
                                            $msg = "Already Selected";
                                        } elseif ($answer == '2') {
                                            $event= "Item ".$serviceitem." Process payment successfully ";
                                            $eventcode= 113;
										//	$msql->performinsurancebilling($patientcode,$visitcode,$paymentmethodcode,$paymentschemecode,$servicescode,$currentusercode,$currentuser,$instcode);
                                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                $status = "success";
                                                $msg = "Process payment Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } elseif ($answer == '0') {
                                            $status = "error";
                                            $msg = "Unsuccessful";
                                        } else {
                                            $status = "error";
                                            $msg = "Unknown Source";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
		
			}
	break;


	// 24 APR  2021
	case 'unselecttransaction':
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
						
						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$labstate = $kt['6'];
							if($labstate !== '2'){
								$status = "error";
								$msg = "Only Selected  Prescription can be Unselected"; 
							}else{
								$answer = $pharmacysql->unselectprescription($bcode,$days,$currentusercode,$currentuser);						
								if($answer == '1'){
									$status = "error";
									$msg = "Already Selected";
								}else if($answer == '2'){
									$event= "Item Unselected ".$bcode." for  has been saved successfully ";
									$eventcode= 114;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Unselected Successfully";		
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
		}

	break;
	
		// 23 APR 2021
	case 'setitemprice':
		
		$item = isset($_POST['item']) ? $_POST['item']: '';
		$itemcode = isset($_POST['itemcode']) ? $_POST['itemcode']: '';
		$schemcode = isset($_POST['schemcode']) ? $_POST['schemcode']: '';
		$schemename = isset($_POST['schemename']) ? $_POST['schemename']: '';
		$method = isset($_POST['method']) ? $_POST['method']: '';
		$methodcode = isset($_POST['methodcode']) ? $_POST['methodcode']: '';
		$itemprice = isset($_POST['itemprice']) ? $_POST['itemprice']: '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode']: '';
		$type = isset($_POST['type']) ? $_POST['type']: '';
		$qty = isset($_POST['qty']) ? $_POST['qty']: '';
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
					$totalprice = $itemprice*$qty;	
					$setprice = $pharmacysql->setpriceprescription($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$totalprice,$currentuser,$currentusercode,$instcode);
					$title = 'Set Price';
					if($setprice == '0'){							
						$status = "error";					
						$msg = "".$title." for ".$itemprice." Unsuccessful"; 
					}else if($setprice == '1'){						
						$status = "error";					
						$msg = "".$title." for  ".$itemprice." Exist Already"; 							
					}else if($setprice == '2'){	
						$event= "".$title." for : ".$item." for has been saved successfully ";
						$eventcode= 55;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." for ".$item." Successfully";	
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
	
	// 23 APR 2021
	case 'selecttransaction':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$billcode = isset($_POST['billcode']) ? $_POST['billcode'] : '';	
		$validinsurance = isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '';							
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
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$labstate = $kt['6'];
							$med = $kt['7'];
							$scheme = $kt['9'];
							$qty = $kt['10'];
							if($labstate !== '1'){
								$status = "error";
								$msg = "Only Unselected Prescription can be selected"; 
							}else{
								$getqty = $pharmacysql->getmedicationdurrentqty($servicescode,$instcode);
								if($getqty<'1'){
									$status = "error";
									$msg = "Current $med quanatity of $getqty is too low. Adjust stock to continue "; 
								}else{
									if ($getqty < $qty) {
										$status = "error";
										$msg = "Insufficent Quantity";
									} else {
										$ptype = $msql->patientnumbertype($patientnumber, $instcode, $instcodenuc);
										$schemepricepercentage = $paymentschemetable->getschemepercentage($paymentschemecode,$instcode);
										// cash
										if ($paymentmethodcode == $cashpaymentmethodcode) {
											$serviceamount = $pricing->getprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode, $ptype, $instcodenuc);
											if ($serviceamount == '-1') {
												$totalamount = '-1';
											} else {
												$totalamount = $serviceamount*$qty;
											}

											if ($totalamount == '0') {
												$status = "error";
												$msg = "Total Amount cannot be zero";
											} else {
												$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
												$title = 'Prescription Selected';
												if ($answer == '1') {
													$status = "error";
													$msg = "".$title." Already Selected";
												} elseif ($answer == '2') {
													$event= "".$title."  ".$bcode." for  has been saved successfully ";
													$eventcode= 103;
													$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
													if ($audittrail == '2') {
														$status = "success";
														$msg = "".$title."  Successfully";
													} else {
														$status = "error";
														$msg = "Audit Trail Failed!";
													}
												} elseif ($answer == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$status = "error";
													$msg = "Unknown Source";
												}
											}
											// momo
										} elseif ($paymentmethodcode == $mobilemoneypaymentmethodcode) {
											$serviceamount = $pricing->getprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode, $ptype, $instcodenuc);
											if ($serviceamount == '-1') {
												$totalamount = '-1';
											} else {
												$totalamount = $serviceamount*$qty;
											}
											if ($totalamount == '0') {
												$status = "error";
												$msg = "Total Amount cannot be zero";
											} else {
												$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
												$title = 'Prescription Selected';
												if ($answer == '1') {
													$status = "error";
													$msg = "".$title." Already Selected";
												} elseif ($answer == '2') {
													$event= "".$title."  ".$bcode." for  has been saved successfully ";
													$eventcode= 103;
													$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
													if ($audittrail == '2') {
														$status = "success";
														$msg = "".$title."  Successfully";
													} else {
														$status = "error";
														$msg = "Audit Trail Failed!";
													}
												} elseif ($answer == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$status = "error";
													$msg = "Unknown Source";
												}
											}
											// private insurnace
										} elseif ($paymentmethodcode == $privateinsurancecode) {
											if ($validinsurance == 'NO') {
												$status = "error";
												$msg = "The patient $patient does not have a valid insurance ";
											} else {
												$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
												if ($insurancechecks == '-1') {
													$status = "error";
													$msg = "The patient $patient does not have a current insurance Policy ";
												} elseif ($insurancechecks == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$expt = explode('@@@', $insurancechecks);
													$cardnumber = $expt[0];
													$cardexpirydate = $expt[1];

													if($schemepricepercentage < 100){
														$payment = 1;
													}

													$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
													if ($serviceamount == '-1') {
														$status = "error";
														$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
													} else {
														$totalamount = $serviceamount*$qty;
									
														if ($totalamount == '0') {
															$status = "error";
															$msg = "Total Amount cannot be zero";
														} else {
															$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
															$title = 'Prescription Selected';
															if ($answer == '1') {
																$status = "error";
																$msg = "$title Already Selected";
															} elseif ($answer == '2') {
																$event= "$title  $bcode for  has been saved successfully ";
																$eventcode= 103;
																$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
																if ($audittrail == '2') {
																	$status = "success";
																	$msg = "$title  Successfully";
																} else {
																	$status = "error";
																	$msg = "Audit Trail Failed!";
																}
															} elseif ($answer == '0') {
																$status = "error";
																$msg = "Unsuccessful";
															} else {
																$status = "error";
																$msg = "Unknown Source";
															}
														}
													}
												}
											}
																							// partner companies
										} elseif ($paymentmethodcode == $partnercompaniescode) {
											if ($validinsurance == 'NO') {
												$status = "error";
												$msg = "The patient $patient does not have a valid insurance ";
											} else {
												$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
												if ($insurancechecks == '-1') {
													$status = "error";
													$msg = "The patient $patient does not have a current insurance Policy ";
												} elseif ($insurancechecks == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$expt = explode('@@@', $insurancechecks);
													$cardnumber = $expt[0];
													$cardexpirydate = $expt[1];
													if($schemepricepercentage < 100){
														$payment = 1;
													}

													$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
													if ($serviceamount == '-1') {
														$status = "error";
														$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
													} else {
														$totalamount = $serviceamount*$qty;

														if ($totalamount == '0') {
															$status = "error";
															$msg = "Total Amount cannot be zero";
														} else {
															$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
															$title = 'Prescription Selected';
															if ($answer == '1') {
																$status = "error";
																$msg = "$title Already Selected";
															} elseif ($answer == '2') {
																$event= "$title $bcode for  has been saved successfully ";
																$eventcode= 103;
																$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
																if ($audittrail == '2') {
																	$status = "success";
																	$msg = "$title  Successfully";
																} else {
																	$status = "error";
																	$msg = "Audit Trail Failed!";
																}
															} elseif ($answer == '0') {
																$status = "error";
																$msg = "Unsuccessful";
															} else {
																$status = "error";
																$msg = "Unknown Source";
															}
														}
													}
												}
											}
											// nhis
										} elseif ($paymentmethodcode == $nationalinsurancecode) {
											if ($validinsurance == 'NO') {
												$status = "error";
												$msg = "The patient $patient does not have a valid insurance ";
											} else {
												$insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
												if ($insurancechecks == '-1') {
													$status = "error";
													$msg = "The patient $patient does not have a current insurance Policy ";
												} elseif ($insurancechecks == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$expt = explode('@@@', $insurancechecks);
													$cardnumber = $expt[0];
													$cardexpirydate = $expt[1];
													if($schemepricepercentage < 100){
														$payment = 1;
													}

													$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
													if ($serviceamount == '-1') {
														$status = "error";
														$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
													} else {
														$totalamount = $serviceamount*$qty;

														if ($totalamount == '0') {
															$status = "error";
															$msg = "Total Amount cannot be zero";
														} else {
															$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
															$title = 'Prescription Selected';
															if ($answer == '1') {
																$status = "error";
																$msg = "$title Already Selected";
															} elseif ($answer == '2') {
																$event= "$title  $bcode for  has been saved successfully ";
																$eventcode= 103;
																$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
																if ($audittrail == '2') {
																	$status = "success";
																	$msg = "$title  Successfully";
																} else {
																	$status = "error";
																	$msg = "Audit Trail Failed!";
																}
															} elseif ($answer == '0') {
																$status = "error";
																$msg = "Unsuccessful";
															} else {
																$status = "error";
																$msg = "Unknown Source";
															}
														}
													}
												}
											}
											// others
										} else {
											$serviceamount = $pricing->getprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode, $ptype, $instcodenuc);
											if ($serviceamount == '-1') {
												$totalamount = '-1';
											} else {
												$totalamount = $serviceamount*$qty;
											}

											if ($totalamount == '0') {
												$status = "error";
												$msg = "Total Amount cannot be zero";
											} else {
												$answer = $pharmacysql->prescriptionselection($bcode, $days, $servicescode, $cost, $paymentmethodcode, $depts, $paymentschemecode, $serviceamount, $totalamount, $currentusercode, $currentuser, $instcode);
												$title = 'Prescription Selected';
												if ($answer == '1') {
													$status = "error";
													$msg = "$title Already Selected";
												} elseif ($answer == '2') {
													$event= "$title  $bcode for  has been saved successfully ";
													$eventcode= 103;
													$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
													if ($audittrail == '2') {
														$status = "success";
														$msg = "$title  Successfully";
													} else {
														$status = "error";
														$msg = "Audit Trail Failed!";
													}
												} elseif ($answer == '0') {
													$status = "error";
													$msg = "Unsuccessful";
												} else {
													$status = "error";
													$msg = "Unknown Source";
												}
											}
										}
									}
								}
						
							}							
						}			
					}			
				}
		
			}
	break;

	
}	

	
	

	function prescriptionmenu(){
		echo'
		<div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
									Prescription Menu <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li class="dropdown-plus-title">
									Prescription
										<b class="fa fa-angle-up" aria-hidden="true"></b>
									</li>
									
									<li><a href="prescriptionsendoutfilter">Sent Out </a></li>
									
									<li><a href="lowstocks">Low Stocks</a></li>
									<li><a href="newmedications">New Medication</a></li>
									<li><a href="pharmacystocklist">Stock List</a></li>
									<li><a href="pharmacypricing">Pricing</a></li>
									<li class="divider"></li>
									<li><a href="manageprescriptions">Prescription </a></li>
								</ul>
							</div>';
	}
	
?>

