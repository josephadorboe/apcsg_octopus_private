 <?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$procedureprocessingmodel = htmlspecialchars(isset($_POST['procedureprocessingmodel']) ? $_POST['procedureprocessingmodel'] : '');
	
	// 23 NOV 2023
switch ($procedureprocessingmodel)
{

	// 25 NOV 2023, 09 NOV 2021 JOSEPH ADORBOE
	case 'savedoctorprocedurereports':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procduredate = isset($_POST['procduredate']) ? $_POST['procduredate'] : '';
		$proceduredoctors = isset($_POST['proceduredoctors']) ? $_POST['proceduredoctors'] : '';
		$procedurenurse = isset($_POST['procedurenurse']) ? $_POST['procedurenurse'] : '';
		$procedureassitants = isset($_POST['procedureassitants']) ? $_POST['procedureassitants'] : '';
		$proceduresite = isset($_POST['proceduresite']) ? $_POST['proceduresite'] : '';
		$procedurdiagnosis = isset($_POST['procedurdiagnosis']) ? $_POST['procedurdiagnosis'] : '';
		$proceduremedications = isset($_POST['proceduremedications']) ? $_POST['proceduremedications'] : '';
		$procedureoutcomes = isset($_POST['procedureoutcomes']) ? $_POST['procedureoutcomes'] : '';
		$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
	//	$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
				
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($procedureoutcomes)  || empty($procedurdiagnosis) ) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{					                      
                    $sqlresults = $patientproceduretable->enterprocedurereports($ekey, $procduredate,$proceduredoctors,$procedurenurse,$procedureassitants,$proceduresite,$procedurdiagnosis,$proceduremedications,$procedureoutcomes,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
                        
					// $locum = $msql->getlocumdetails($currentusercode,$instcode);
					// if($locum !== '0'){
					// 	$ps = explode('@', $locum);
					// 	$locumamount = $ps[0];
					// 	$locumntax = $ps[1];
					// 	$locumshare = $ps[2];
					// 	$facilityshare = $ps[3];
					// 	$paysource = 'PROCEDURE';
					// 	$procedurecost = $msql->getbillingitemdetails($ekey,$procedurecode,$instcode);
					// 	if($procedurecost !== '0'){
					// 		$consumablepercentage  = 3;
					// 		$consumableamount = ($procedurecost*$consumablepercentage)/100; 
					// 		$procedurefee = $procedurecost-$consumableamount;
					// 		$usershareamount  = ($procedurefee*$locumshare)/100; 
					// 		$usersharetaxamount = ($usershareamount*$locumntax)/100; 
					// 		$useramountdue = $usershareamount - $usersharetaxamount ;
					// 		$facilityshareamount = $procedurefee - $useramountdue;
					// 		$salarydetailsnum = $lov->getsalarydetailsnumber($instcode);
					// 		$salarynum = $lov->getsalarynumber($instcode);

					// 	//	$facilityshareamount  = ($procedurecost*$facilityshare)/100; 
					// 	//	$facilitysharetaxamount = ($facilityshareamount*$locumntax)/100; 
					// 	}

					// }else{
					// 	$locumamount = $locumntax = $locumshare = $facilityshare = $consumablepercentage = $paysource = $consumableamount = $procedurefee = $usershareamount = $usersharetaxamount = $useramountdue = $facilityshareamount = $salarydetailsnum = $salarynum = '0';
					// }

					// if($sqlresults  == '2'){
					// 	if($locum !== '0'){
					// 		$msql->processprocedurefees($locumshare,$paysource,$facilityshare,$consumablepercentage,$consumableamount,$procedurefee,$usershareamount,$usersharetaxamount,$useramountdue,$facilityshareamount,$salarydetailsnum,$salarynum,$currentdate,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode);
					// 	}
					// 	$consultactionsql->countdoctorproceurestats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
					// }
							
					$action = "Procedure Notes ";
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=354;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
                }
            }
			
			}
	break;

	// 25 NOV 2023, 09 NOV 2021 JOSEPH ADORBOE
	case 'savenurseprocedurereports':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procduredate = isset($_POST['procduredate']) ? $_POST['procduredate'] : '';
		$proceduredoctors = isset($_POST['proceduredoctors']) ? $_POST['proceduredoctors'] : '';
		$procedurenurse = isset($_POST['procedurenurse']) ? $_POST['procedurenurse'] : '';
		$procedureassitants = isset($_POST['procedureassitants']) ? $_POST['procedureassitants'] : '';
		$proceduresite = isset($_POST['proceduresite']) ? $_POST['proceduresite'] : '';
		$procedurdiagnosis = isset($_POST['procedurdiagnosis']) ? $_POST['procedurdiagnosis'] : '';
		$proceduremedications = isset($_POST['proceduremedications']) ? $_POST['proceduremedications'] : '';
		$procedureoutcomes = isset($_POST['procedureoutcomes']) ? $_POST['procedureoutcomes'] : '';
		$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
	//	$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
				
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($procedureoutcomes)  || empty($procedurdiagnosis) ) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{					                      
                    $sqlresults = $patientproceduretable->enterprocedurereports($ekey, $procduredate,$proceduredoctors,$procedurenurse,$procedureassitants,$proceduresite,$procedurdiagnosis,$proceduremedications,$procedureoutcomes,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);
                        
					// $locum = $msql->getlocumdetails($currentusercode,$instcode);
					// if($locum !== '0'){
					// 	$ps = explode('@', $locum);
					// 	$locumamount = $ps[0];
					// 	$locumntax = $ps[1];
					// 	$locumshare = $ps[2];
					// 	$facilityshare = $ps[3];
					// 	$paysource = 'PROCEDURE';
					// 	$procedurecost = $msql->getbillingitemdetails($ekey,$procedurecode,$instcode);
					// 	if($procedurecost !== '0'){
					// 		$consumablepercentage  = 3;
					// 		$consumableamount = ($procedurecost*$consumablepercentage)/100; 
					// 		$procedurefee = $procedurecost-$consumableamount;
					// 		$usershareamount  = ($procedurefee*$locumshare)/100; 
					// 		$usersharetaxamount = ($usershareamount*$locumntax)/100; 
					// 		$useramountdue = $usershareamount - $usersharetaxamount ;
					// 		$facilityshareamount = $procedurefee - $useramountdue;
					// 		$salarydetailsnum = $lov->getsalarydetailsnumber($instcode);
					// 		$salarynum = $lov->getsalarynumber($instcode);

					// 	//	$facilityshareamount  = ($procedurecost*$facilityshare)/100; 
					// 	//	$facilitysharetaxamount = ($facilityshareamount*$locumntax)/100; 
					// 	}

					// }else{
					// 	$locumamount = $locumntax = $locumshare = $facilityshare = $consumablepercentage = $paysource = $consumableamount = $procedurefee = $usershareamount = $usersharetaxamount = $useramountdue = $facilityshareamount = $salarydetailsnum = $salarynum = '0';
					// }

					// if($sqlresults  == '2'){
					// 	if($locum !== '0'){
					// 		$msql->processprocedurefees($locumshare,$paysource,$facilityshare,$consumablepercentage,$consumableamount,$procedurefee,$usershareamount,$usersharetaxamount,$useramountdue,$facilityshareamount,$salarydetailsnum,$salarynum,$currentdate,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode);
					// 	}
					// 	$consultactionsql->countdoctorproceurestats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
					// }
							
					$action = "Procedure Notes ";
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=354;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
                }
            }
			
			}
	break;

	// 25 NOV 2023,  13 FEB 2022  JOSEPH ADORBOE
	case 'saveprocedurenotes':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurereport = isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '';
				
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($procedurereport) ) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{			
					$procedurereport = strtoupper($procedurereport);		                      
                    $sqlresults = $patientproceduretable->enterprocedurenotesreports($ekey, $procedurereport,$instcode); 						
						$action = "Nurse Noted saved";
						$result = $engine->getresults($sqlresults,$item='',$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=353;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
					
                }
            }
			
			}
	break;

	// 23 NOV 2023,  JOSEPH ADORBOE 
	case 'issueconsumables':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$procedurecode = isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '';
		$procedurename = isset($_POST['procedurename']) ? $_POST['procedurename'] : '';
		$transactioncode = isset($_POST['transactioncode']) ? $_POST['transactioncode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($_POST["conscheckbox"]) || empty($transactioncode)){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{					
					foreach ($_POST["conscheckbox"] as $key) {
						$med = explode('@@@', $key);
						$consumablecode = $med[0];
						$consumablename = $med[1];
						$consumableqty = $med[2];
						$formkey = md5(microtime());	
						$randomnumber = Rand(100,10000)	;												
						$sqlresults = $patientprocedureconsumabletable->newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode);
						if($sqlresults  == '2'){
							$patientproceduretable->dispenseprocedure($transactioncode,$instcode);
							$consumablesetuptable->deductconsumables($consumablecode,$consumableqty,$instcode);
						}
								
						$action = "Consumable Issued";
						$result = $engine->getresults($sqlresults,$item=$consumablename,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=355;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
																		
						}			
					}			
				}
		
			}
	break;

	// 23 NOV 2023, 20 SEPT 2023, 2 OCT 2022 JOSEPH ADORBOE 
	case 'returnprocedures':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$returnreason = htmlspecialchars(isset($_POST['returnreason']) ? $_POST['returnreason'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($_POST["scheckbox"]) || empty($returnreason)){   
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
							$dispense = $kt['11'];

							$billingcode = md5(microtime());
							$depts = 'PROCEDURE';

							if($dispense == '0'){
								$status = "error";
								$msg = "Procedure cannot be returned because it has not been dispensed"; 
							}else{								
								$sqlresults = $patientproceduretable->returnprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
								$action = "Return Request saved";
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=483;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
						
							}							
						}			
					}			
				}
		
			}
	break;

	// 23 NOV 2023, 20 Sept 2023, 15 JUN 2021 JOSEPH ADORBOE
	case 'sendoutprocedure':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');			
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
							$depts = 'PROCEDURE';

							if($pharmacystate !== '8'){
								$status = "error";
								$msg = "Only Sentout Pescription can be reversed "; 
							}else{															
								$sqlresults = $patientproceduretable->sendoutprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode);
								$action = "Return Request saved";
								$result = $engine->getresults($sqlresults,$item=$patient,$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=483;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
							}							
						}			
					}			
			}
		
			}
	break;

	// 23 NOV 2023,  30 OCT 2023, 16 JULY 2021 JOSEPH ADORBOE
	case 'manageeditprocedurerequest':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$payment = htmlspecialchars(isset($_POST['payment']) ? $_POST['payment'] : '');		
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
                    $sqlresults = $patientproceduretable->editproceduremanage($visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode);
                	$action = "Procedure Manage";
					$result = $engine->getresults($sqlresults,$item='',$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=391;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
					
                }
            }
			
			}
	break;

	// 23 NOV 2023, 02 OCT 2022 JOSEPH ADORBOE
	case 'bulkprocedurearchive':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');						
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
							$ekey = $kt['0'];
								$sqlresults = $patientproceduretable->editpharamcyarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode);
								
								$action = "Archive procedure";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=356;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
																
						}			
					}			
				}
		
			}
	break;
	
	// 23 NOV 2023, 16 JULY 2021
	case 'sendforpaymentprocedure':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');
		$patientpaymenttype = htmlspecialchars(isset($_POST['patientpaymenttype']) ? $_POST['patientpaymenttype'] : '');
		$patienttype = htmlspecialchars(isset($_POST['patienttype']) ? $_POST['patienttype'] : '');			
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
							$bbcode = md5(microtime());
							$billcode = $patientsbillstable->getpatientbillingcode($bbcode,$patientcode,$patientnumber,$patient,$days,$visitcode,$currentuser,$currentusercode,$instcode);

						foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$procedurestate = $kt['6'];
							$serviceitem = $kt['7'];
							$paymentmethod = $kt['8'];
							$paymentscheme = $kt['9'];
							$billercode = $kt['13'];
							$biller = $kt['14'];
						//	$paymenttype = $kt['10'];
							$billingcode = md5(microtime());
							$depts = 'PROCEDURE';
							if($procedurestate !== '2'){
								$status = "error";
								$msg = "Only Selected Procedure can be Process Payment"; 
							}else{	
															
								if($cost == '-1'){
									$status = "error";
									$msg = "Price has not been set"; 
								}else{								
										$sqlresults = $patientbillitemtable->sendprocedureforpayment($billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller);

										if($sqlresults == '2'){
											$patientsbillstable->updatebillsamount($cost,$billcode);
											$patientproceduretable->processprocedurepaymenttype($bcode,$billcode,$patientpaymenttype);

											$claimsnumber = rand(1,10000);
											$patientclaimscontroller->performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$servicescode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$patientclaimstable,$patientbillitemtable);
										}										
										$action = "Process payment";
										$result = $engine->getresults($sqlresults,$item=$serviceitem,$action);
										$re = explode(',', $result);
										$status = $re[0];					
										$msg = $re[1];
										$event= "$action: $form_key $msg";
										$eventcode=358;
										$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);						
								}								

							}							
						}			
					}			
				}
		
			}
	break;		

	// 23 NOV 2023 , JOSEPH ADORBOE
	case 'unselectproceduretransaction':
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$procedurestate = $kt['6'];
							if($procedurestate !== '2'){
								$status = "error";
								$msg = "Only Selected  Prescription can be Unselected"; 
							}else{
								$sqlresults = $patientproceduretable->unselectproceduretransaction($bcode,$days,$currentusercode,$currentuser);
								$action = "Procedure Selected";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=359;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
								
							}
			
					}	
				}
			}
		}

	break;

	// 23 NOV 2023 JOSEPH ADORBOE
	case 'selectproceduretransaction':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');	
		$validinsurance = htmlspecialchars(isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '');					
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
							$procedurestate = $kt['6'];
							$med = $kt['7'];
							$scheme = $kt['9'];
							$qty = $kt['10'];

							if($procedurestate !== '1'){
								$status = "error";
								$msg = "Only Unselected Procedure can be selected"; 
							}else{
								
								$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
								$title = 'Procedure Selected';
								if($paymentmethodcode == $cashpaymentmethodcode){
											$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
										if($serviceamount == '-1'){
											$totalamount = '-1';	
										}else{
											$totalamount = $serviceamount*$qty;
										}
										
										$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
										$action = "Procedure Selected";
										$result = $engine->getresults($sqlresults,$item='',$action);
										$re = explode(',', $result);
										$status = $re[0];					
										$msg = $re[1];
										$event= "$action: $form_key $msg";
										$eventcode=390;
										$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
								// momo
								}else if($paymentmethodcode == $mobilemoneypaymentmethodcode){

										$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
										if($serviceamount == '-1'){
											$totalamount = '-1';	
										}else{
											$totalamount = $serviceamount*$qty;
										}
										$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
										$action = "Procedure Selected";
										$result = $engine->getresults($sqlresults,$item='',$action);
										$re = explode(',', $result);
										$status = $re[0];					
										$msg = $re[1];
										$event= "$action: $form_key $msg";
										$eventcode=390;
										$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
										
							
								// private insurnace
								}else if($paymentmethodcode == $privateinsurancecode){
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

											$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
											if ($serviceamount == '-1') {
												$status = "error";
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;	
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);												
											}
										}
									}


								// partner companies 
								}else if($paymentmethodcode == $partnercompaniescode){
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

											$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
											if ($serviceamount == '-1') {
												$status = "error";
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;	
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);								
									
												
											}
										}
									}


								// nhis
								}else if($paymentmethodcode == $nationalinsurancecode){
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

											$serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
											if ($serviceamount == '-1') {
												$status = "error";
												$msg = "The patient $patient insurance scheme $scheme does not pay for $med. please use cash  ";
											} else {
												$totalamount = $serviceamount*$qty;
												$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
												$action = "Procedure Selected";
												$result = $engine->getresults($sqlresults,$item='',$action);
												$re = explode(',', $result);
												$status = $re[0];					
												$msg = $re[1];
												$event= "$action: $form_key $msg";
												$eventcode=390;
												$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
												
											}
										}
									}


								// others
								}else {
									$serviceamount = $pricingtable->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc);	
									if($serviceamount == '-1'){
										$totalamount = '-1';	
									}else{
										$totalamount = $serviceamount*$qty;
									}
									
									$sqlresults = $patientproceduretable->precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode);												
								$action = "Procedure Selected";
								$result = $engine->getresults($sqlresults,$item='',$action);
								$re = explode(',', $result);
								$status = $re[0];					
								$msg = $re[1];
								$event= "$action: $form_key $msg";
								$eventcode=390;
								$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
							}
						
							}							
						}			
					}			
				}
		
			}
	break;

	

	// // 09 NOV 2021 JOSEPH ADORBOE
	// case 'saveprocedurereports':		
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$procedurecode = htmlspecialchars(isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '');
	// 	$procduredate = htmlspecialchars(isset($_POST['procduredate']) ? $_POST['procduredate'] : '');
	// 	$proceduredoctors = htmlspecialchars(isset($_POST['proceduredoctors']) ? $_POST['proceduredoctors'] : '');
	// 	$procedurenurse = htmlspecialchars(isset($_POST['procedurenurse']) ? $_POST['procedurenurse'] : '');
	// 	$procedureassitants = htmlspecialchars(isset($_POST['procedureassitants']) ? $_POST['procedureassitants'] : '');
	// 	$proceduresite = htmlspecialchars(isset($_POST['proceduresite']) ? $_POST['proceduresite'] : '');
	// 	$procedurdiagnosis = htmlspecialchars(isset($_POST['procedurdiagnosis']) ? $_POST['procedurdiagnosis'] : '');
	// 	$proceduremedications = htmlspecialchars(isset($_POST['proceduremedications']) ? $_POST['proceduremedications'] : '');
	// 	$procedureoutcomes = htmlspecialchars(isset($_POST['procedureoutcomes']) ? $_POST['procedureoutcomes'] : '');
	// 	$procedurereport = htmlspecialchars(isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '');
	// //	$procedurereport = htmlspecialchars(isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '');
				
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
	// 	if($preventduplicate == '1'){		
	// 		if($currentshiftcode == '0'){				
	// 			$status = "error";
	// 			$msg = "Shift is closed";				
	// 		}else{
    //             if(empty($ekey) || empty($procedureoutcomes)  || empty($procedurdiagnosis) ) {
    //                 $status = 'error';
    //                 $msg = 'Required Field Cannot be empty';
    //             }else{					                      
    //                 $sqlresults = $patientproceduretable->enterprocedurereports($ekey, $procduredate,$proceduredoctors,$procedurenurse,$procedureassitants,$proceduresite,$procedurdiagnosis,$proceduremedications,$procedureoutcomes,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);					
	// 				$action = "Procedure Report saved";
	// 				$result = $engine->getresults($sqlresults,$item=$patient,$action);
	// 				$re = explode(',', $result);
	// 				$status = $re[0];					
	// 				$msg = $re[1];
	// 				$event= "$action: $form_key $msg";
	// 				$eventcode=482;
	// 				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);		
					
    //             }
    //         }
			
	// 		}
	// break;
	

	
	
	

	
}	

	
?>

