<?php
	REQUIRE_ONCE (INTFILE);	
	$engine = new engine(); 
	$coder = new code();
	$msql = new mainsql();	
	$lov = new lov();
	$ulogs = new userlogs();
	$pat = new patients();
	$dash = new dashboard();
	$sett = new settings();
	$pricing = new pricing();
	// $cry = new crypt();	
	$days = Date('Y-m-d H:i:s');
	$day = Date('Y-m-d');
	$nowday = date('Y-m-d', strtotime(str_replace('-','/', $day)));
	$pathed = 'folders/'; 
	$resultspathed = 'results/'; 
	$invoices = 'invoices/'; 
	$userdetails = $usertable->getcurrentuserdetails();	
	
	if($userdetails !== '-1'){
		$usd = explode('@@@', $userdetails);
		$currentusercode = $usd[0];
		$currentuser = $usd[2];
		$currentusername = $usd[1];
		$currentuserlevel = $usd[3];
		$currentusershortcode = $usd[4];
		$currentuserinst = $usd[10];
		$instcode = $usd[8];
		$userkey = $usd[6];
		$loginkey= $usd[7];
		$currentuserlevelname = $usd[11];
		$cashpaymentmethodcode = '2ff5c97d7ccc5523a37c7559cdb9f717';
		$cashpaymentmethod = 'CASH';
		$mobilemoneypaymentmethodcode = 'd43cdab483a9c0f983fced3b5835a19a';
	//	$mobilemoneypaymentmethod = 'd43cdab483a9c0f983fced3b5835a19a';
		$mobilemoneypaymentmethod = 'MOBILE MONEY';
		$privateinsurancecode = '6c5314f8ca64d89e437e0f459b246495';
		$privateinsurance = 'PRIVATE INSURANCE';
		$nationalinsurancecode = '55bf44c672dfa8850064af4a6bb9fd5d';
		$nationalinsurance = 'NHIS';
		$partnercompaniescode = 'e0e2103fc5a47cd834e77317da85d200';
		$partnercompanies = 'PARTNER COMPANIES';
		$cashschemecode = $paymentschemetable->getcashschemecode($cashpaymentmethodcode,$instcode);
		$currentshiftdetails = $engine->getcurrentshiftdetails($instcode);


		$admissionservice = 'SER0012';
		$newfolder = 'SER0001';
		$consultationadult = 'SER0002';
		$consultationchildren = 'SER0003';
		$consultationreview = 'SER0004';
		$consultationnight = 'SER0005';
		$consultationfasttrack = 'SER0006';
		$consultationspecialist = 'SER0018';
		$consultationorthopediccomplaint = 'SER0020';
		$consultationothopedic = 'SER0023';
		$consultationothopedicreview = 'SER0024';
		$consultationothopedicexpats = 'SER0019';
		$appointmentservice = 'SER0028';
		$newfolderexpat = 'SER0029';
		$xraylabreview = 'SER0031';
		$consultationobsgyne = 'SER0032';
		$consultationrheumatology = 'SER0033';
		$consultationrheumatologyfollowup = 'SER0034';
		$consultationinternalmedicine = 'SER0035';
		$consultationinternalmedicinefollowup = 'SER0036';
		$medicalreport = 'SER0037';
		$employmentmedicallocalreport = 'SER0038';
		$schoolmedicallocalreport = 'SER0039';
		$consultationprocedures = 'SER0040';
		$consultationrheumatologytopup = 'SER0041';
		$consultationrheumatologyfollowuptopup = 'SER0042';
		$consultationinternalmedicinetopup = 'SER0043';
		$consultationinternalmedicinefollowuptopup = 'SER0044';
		$consultationorthopedicspecilisttopup = 'SER0045';
		$consultationorthopedicspecilistfollouptopup = 'SER0046';
		$largewounddressing = 'SER0047';
		$mediumwounddressing = 'SER0048';
		$smallwounddressing = 'SER0049';
		$walkinservice = 'SER0051';
		$familymedicine = 'SER0052';
		$familymedicinefollowup = 'SER0053';
		$detentionthreehours = 'SER0054';
		$detentionfivehours = 'SER0055';
		$schoolmedicalforeignreport = 'SER0056';
		$employmentmedicalforeignreport = 'SER0057';
		$insurancemedicalreportlocal = 'SER0058';
		$insurancemedicalreportforeign = 'SER0059';
		$airevacuationmedicalreport  = 'SER0060';
		$medicalopinionlocalreport  = 'SER0061';
		$medicalopinionforeignreport  = 'SER0062';
		$physiofirstvisit  = 'SER0063';
		$physiofollowup  = 'SER0064';
		$physioacupuncturesinglesite  = 'SER0065';
		$physioacupuncturemultisite  = 'SER0066';
		$physiofullbodymassage  = 'SER0067';
		$physioreflexology  = 'SER0068';
	//	$instcodenuc = 'HMIS100';
		$instcodenuc = 'HMS1000';	


		if($currentshiftdetails !== 0){			
			$usde = explode('@@@', $currentshiftdetails);
			$currentshiftcode = $usde[0];
			$currentshift = $usde[1];
			$currentshifttype = $usde[2];
			$currentdate = $usde[3];		
		}else{
			$currentshiftcode=$currentshift=$currentshifttype=$currentdate= -1;
		}
	}
	$mainmodel = isset($_POST['mainmodel']) ? $_POST['mainmodel'] : '';
	
	// 12 sept 2020  disableservicepartner
switch ($mainmodel)
{

	// 1 JUL 2023 JOSEPH ADORBOE  
	case 'edithandover':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$handovertitle = isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$oldnotes = isset($_POST['oldnotes']) ? $_POST['oldnotes'] : '';
		$oldshiftcode = isset($_POST['oldshiftcode']) ? $_POST['oldshiftcode'] : '';
		$addnotes = isset($_POST['addnotes']) ? $_POST['addnotes'] : '';
		$shiftnotes = isset($_POST['shiftnotes']) ? $_POST['shiftnotes'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($oldnotes) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
			//	$handovernotes = date('d M Y h:i:s a', strtotime($days))."\r\n".$notes;
				
				$handovernotes = $shiftnotes;	
				if($currentshiftcode !== $oldshiftcode){
					$handovernotes = $addnotes."\r\n\r\n".$oldnotes;	
				}
							
				$edit = $msql->edithandover($ekey,$handovertitle,$handovernotes,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Handover Notes';
				if($edit == '0'){					
					$status = "error";					
					$msg = "$title for $handovertitle Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "$title for $handovertitle Exist"; 					
				}else if($edit == '2'){
					$event= " $title $handovertitle  successfully ";
					$eventcode= "74";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "$title $handovertitle Successfully";
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


	// 03 DEC 2022 
	case 'processmonthlystatsfinance':
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		// $requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		// $tests = isset($_POST['tests']) ? $_POST['tests'] : '';
		// $testscode = isset($_POST['testscode']) ? $_POST['testscode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($currentshiftcode)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				
					foreach($_POST["scheckbox"] as $key){
						$kt = explode('@@@',$key);
						$mcode = $kt['0'];
						$mtitle = $kt['1'];
						$myear = $kt['2'];
						$mstart = $kt['3'];
						$estart = $kt['4'];	

								foreach($_POST["scheckboxuser"] as $userkey){
									$ut = explode('@@@',$userkey);
									$doctorcode = $ut['0'];
									$doctorname = $ut['1'];
									$formkey = md5(microtime());

									$attache = $msql->processdoctorstatsmonthlyfinance($formkey,$mcode,$mtitle,$myear,$mstart,$estart,$doctorcode,$doctorname,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$currentusercode,$currentuser,$instcode);
									$title = 'Stats Processed ';
									if($attache == '0'){					
										$status = "error";					
										$msg = "$title for  Unsuccessful"; 
									}else if($attache == '1'){	
									//	continue;				
										// $status = "error";					
										// $msg = "$title for Patient  Exist"; 				
									}else if($attache == '2'){
										$event= "$title   successfully ";
										$eventcode= "62";
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
										if($audittrail == '2'){				
											$status = "success";
											$msg = "$title for Patient  Successfully";
										}else{
											$status = "error";
											$msg = "Audit Trail unsuccessful";	
										}															
									}else{					
										$status = "error";					
										$msg = " Unkown Source "; 					
									}

								}
						//		$attache = $msql->processdoctorstatsmonthlyend($mcode,$currentusercode,$currentuser,$instcode);
					}							
				}
		}
		
	break;


	// 02 DEC 2022 
	case 'processmonthlystats':
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($currentshiftcode)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				
					foreach($_POST["scheckbox"] as $key){
						$kt = explode('@@@',$key);
						$mcode = $kt['0'];
						$mtitle = $kt['1'];
						$myear = $kt['2'];
						$mstart = $kt['3'];
						$estart = $kt['4'];	

								foreach($_POST["scheckboxuser"] as $userkey){
									$ut = explode('@@@',$userkey);
									$doctorcode = $ut['0'];
									$doctorname = $ut['1'];
									$formkey = md5(microtime());

									$attache = $msql->processdoctorstatsmonthly($formkey,$mcode,$mtitle,$myear,$mstart,$estart,$doctorcode,$doctorname,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$currentusercode,$currentuser,$instcode);
									$attache = $msql->processdoctorstatsmonthlyfinance($formkey,$mcode,$mtitle,$myear,$mstart,$estart,$doctorcode,$doctorname,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$currentusercode,$currentuser,$instcode);
									
									$title = 'Stats Processed ';
									if($attache == '0'){					
										$status = "error";					
										$msg = "$title for  Unsuccessful"; 
									}else if($attache == '1'){	
									//	continue;				
										// $status = "error";					
										// $msg = "$title for Patient  Exist"; 				
									}else if($attache == '2'){
										$event= "$title   successfully ";
										$eventcode= "62";
										$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
										if($audittrail == '2'){				
											$status = "success";
											$msg = "$title for Patient  Successfully";
										}else{
											$status = "error";
											$msg = "Audit Trail unsuccessful";	
										}															
									}else{					
										$status = "error";					
										$msg = " Unkown Source "; 					
									}

								}
						//		$attache = $msql->processdoctorstatsmonthlyend($mcode,$currentusercode,$currentuser,$instcode);
					}							
				}
		}
		
	break;


	// 20 NOV 2022 JOSEPH ADORBOE 
	case 'returnservice':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$returnreason = isset($_POST['returnreason']) ? $_POST['returnreason'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($returnreason)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
				
						$answer = $msql->returnservicerequest($ekey,$returnreason,$currentusercode,$currentuser,$instcode);
				
						if($answer == '1'){
							$status = "error";
							$msg = "Already Selected";
						}else if($answer == '2'){
							$event= "Return Request saved successfully ";
							$eventcode= 197;
							$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "Return Request Successfully";	
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


	// 05 NOV 2022 
	case 'addforexrate':

		$currency = isset($_POST['currency']) ? $_POST['currency'] : '';
		$rates = isset($_POST['rates']) ? $_POST['rates'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($currency) || empty($rates)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				if(!is_numeric($rates)){					
					$status = 'error';
					$msg = 'Rate is Should be Numbers Only.';
				}else{
					if($rates<'1'){
						$status = 'error';
						$msg = 'Rate cannot be less than 1';
					}else{
				
							
					$forex = $msql->addforex($form_key,$currency,$rates,$days,$currentusercode,$currentuser,$instcode);
					$title = 'Rates added ';
					if($forex == '0'){					
						$status = "error";					
						$msg = "$title Unsuccessful"; 
					}else if($forex == '1'){					
						$status = "error";					
						$msg = "$title Exist"; 				
					}else if($forex == '2'){
						$event= " $title   successfully ";
						$eventcode= "62";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " $title Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}	
														
					}else{					
						$status = "error";					
						$msg = " Unkown Source "; 					
					}
					}							
				}
			}
		}
		
		
	break;

	// 09 SEPT 2022  JOSPH ADORBOE
	case 'consultationsearch': 		
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
						$url = "recordconsultations?$form_key";
						$engine->redirect($url);

					}else if($general =='1'){
						if(!empty($patientrecords)){
							$value = $general.'@@@'.$patientrecords.'@@@'.$general;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "recordconsultations?$form_key";
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


	// 26 AUG 2022 
	case 'attachpatientresultsbulk':

		//$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patientnumbers = isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		// $requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		// $tests = isset($_POST['tests']) ? $_POST['tests'] : '';
		// $testscode = isset($_POST['testscode']) ? $_POST['testscode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($patientcode)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ext = '.pdf';
				$finame = $form_key.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $resultspathed.$finame;
				move_uploaded_file($file_temp_loc, $file_store);

				foreach($_POST["scheckbox"] as $key){
					$kt = explode('@@@',$key);
					$ekey = $kt['0'];
					$requestcode = $kt['1'];
					$testscode = $kt['2'];
					$tests = $kt['3'];					
							
					$attache = $msql->attachepatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$testscode,$tests,$finame,$currentusercode,$currentuser,$instcode);
					$title = 'Results attached';
					if($attache == '0'){					
						$status = "error";					
						$msg = "".$title." for ".$patient." Unsuccessful"; 
					}else if($attache == '1'){					
						$status = "error";					
						$msg = "".$title." for Patient ".$patient." Exist"; 				
					}else if($attache == '2'){
						$event= " ".$title." ".$patient."  successfully ";
						$eventcode= "62";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." for Patient ".$patient." Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}	
														
					}else{					
						$status = "error";					
						$msg = " Unkown Source "; 					
					}
					}							
				}
		}
		
	break;
	
	// 15 AUG 2022 JOSEPH ADORBOE
	case 'removeattachments':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$titled = isset($_POST['titled']) ? $_POST['titled'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				
				$attache = $msql->removeattachments($ekey,$form_key,$currentusercode,$currentuser,$instcode);
				$title = "Attachement $titled Removed";
				if($attache == '0'){					
					$status = "error";					
					$msg = " $title Unsuccessful"; 
				}else if($attache == '1'){					
					$status = "error";					
					$msg = "$title Exist"; 				
				}else if($attache == '2'){
					$event= " $title successfully ";
					$eventcode= "62";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "$title Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
													
				}else{					
					$status = "error";					
					$msg = " Unkown Source "; 					
				}
			}
		}		
	break;
	
	// 11 OCT 2020
	case 'disableservicepartner':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
		$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$partneraddress = isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
		$contactperson = isset($_POST['contactperson']) ? $_POST['contactperson'] : '';
		$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
		$partnerremarks = isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';						
				}else{											
						$pay = explode('@@@', $paymentmethod);
						$paymentmethodcode = $pay[0];
						$paymentmethodname = $pay[1];
						$partnername = strtoupper($partnername);
					$editpaymentpartner = $msql->update_disableservicepartner($ekey,$currentusercode,$currentuser,$instcode);						
					if($editpaymentpartner == '0'){						
						$status = "error";					
						$msg = "Add Service Partner $partnername Unsuccessful"; 		
					}else if($editpaymentpartner == '1'){							
						$status = "error";					
						$msg = "Service Partner $partnername Exist";							
					}else if($editpaymentpartner == '2'){
						$event= " Service Partner Disable successfully ";
						$eventcode= "193";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){			
							$status = "success";
							$msg = "service Partner $partnername Disabled Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}												
				}else{						
						$status = "error";					
						$msg = "Add Service Method Unknown source "; 							
				}
				}
			}
	break;	

	// 28 MAY 2022 
	case 'editservicepartner':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
		$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$partneraddress = isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
		$contactperson = isset($_POST['contactperson']) ? $_POST['contactperson'] : '';
		$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
		$partnerremarks = isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';						
				}else{											
						$pay = explode('@@@', $paymentmethod);
						$partnerservicecode = $pay[0];
						$partnerservicename = $pay[1];
						$partnername = strtoupper($partnername);
					$editpaymentpartner = $msql->update_servicepartner($ekey,$partnername,$partnerservicecode,$partnerservicename,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);						
					if($editpaymentpartner == '0'){						
						$status = "error";					
						$msg = "Add Service Partner $partnername Unsuccessful"; 		
					}else if($editpaymentpartner == '1'){							
						$status = "error";					
						$msg = "Service Partner $partnername Exist";							
					}else if($editpaymentpartner == '2'){
						$event= " Service Partner Edit successfully ";
						$eventcode= "193";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){			
							$status = "success";
							$msg = "Edit service Partner $partnername Added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}												
				}else{						
						$status = "error";					
						$msg = "Add Service Method Unknown source "; 							
				}
				}
			}
	break;	

	
	// 28 MAY 2022 JOSEPH ADORBOE 
	case 'addservicepartner':
		$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
		$partnerservice = isset($_POST['partnerservice']) ? $_POST['partnerservice'] : '';
		$partneraddress = isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '';
		$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
		$contactperson = isset($_POST['contactperson']) ? $_POST['contactperson'] : '';
		$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
		$partnerremarks = isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
			if($preventduplicate == '1'){
				if(empty($partnername) || empty($partnerservice) || empty($partneraddress) || empty($phone) || empty($contactperson)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';						
				}else{
					$pay = explode('@', $partnerservice);
					$partnerservicecode = $pay[0];
					$partnerservicename = $pay[1];
					$partnername = strtoupper($partnername);
					$addpartner = $msql->insert_servicepartner($form_key,$partnerservicecode,$partnerservicename,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);
					if($addpartner == '0'){						
						$status = "error";					
						$msg = "Add Service Partner $partnername Unsuccessful"; 		
					}else if($addpartner == '1'){							
						$status = "error";					
						$msg = "Service Partner $partnername Exist"; 							
					}else if($addpartner == '2'){	
						$event= " Service Partner Added successfully ";
						$eventcode= "192";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){			
							$status = "success";
							$msg = "New Service Partner $partnername Added Successfully";
						}else{
							$status = "error";
							$msg = "Audit Trail unsuccessful";	
						}								
							
				}else{						
						$status = "error";					
						$msg = "Add Payment Partner  $partnername   Unknown source "; 							
				}

				}
			}
	break;


	// 21 MAY 2022 JOSPH ADORBOE
	case 'revenuereportstats': 			
		
		$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';	
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
				if(empty($statstype)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
						if($statstype == 1){
							if(empty($fromdate) || empty($todate)){
								$status = "error";
								$msg = "Required Fields Month cannot be empty ";
							}else{
							
								$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;

								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);	
							}								
						}else if($statstype == 2){
							if(empty($fromdate) || empty($todate)){
								$status = "error";
								$msg = "Required Fields Month cannot be empty ";
							}else{
							
								$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;
								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);	
							}		
							
						}else if($statstype == 3){
							$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;
							
								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);

						}else if($statstype == 4){
								$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
								
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "report__allrevenuepdf?$form_key";
									$engine->redirect($url);	
									
								}else if($statstype == 5 || $statstype == 6 || $statstype == 7 || $statstype == 8 || $statstype == 9 || $statstype == 10 || $statstype == 11 ){
									$from = explode('/', $fromdate);
										$frommonth = $from[0];
										$fromday = $from[1];
										$fromyear = $from[2];
										$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
	
										$to = explode('/', $todate);
										$tomonth = $to[0];
										$today = $to[1];
										$toyear = $to[2];
										$todate = $toyear.'-'.$tomonth.'-'.$today;
									
										$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
										$msql->passingvalues($pkey=$form_key,$value);					
										$url = "report__allrevenuepdf?$form_key";
										$engine->redirect($url);	

							}
						
					}
				}
		}

break;

	
	// 14 MAY 2022 JOSPH ADORBOE
	case 'pharmacyreportstats': 			
		
			$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';	
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
					if(empty($statstype)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
							if($statstype == 1){
								if(empty($fromdate) || empty($todate)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
								
									$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;

									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "pharmacyreports?$form_key";
									$engine->redirect($url);	
								}								
							}else if($statstype == 2){
								if(empty($fromdate) || empty($todate)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
								
									$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "pharmacyreports?$form_key";
									$engine->redirect($url);	
								}		
								
							}else if($statstype == 3){
								$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
								
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "pharmacyreports?$form_key";
									$engine->redirect($url);

							}else if($statstype == 4){
									$from = explode('/', $fromdate);
										$frommonth = $from[0];
										$fromday = $from[1];
										$fromyear = $from[2];
										$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
	
										$to = explode('/', $todate);
										$tomonth = $to[0];
										$today = $to[1];
										$toyear = $to[2];
										$todate = $toyear.'-'.$tomonth.'-'.$today;
									
										$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
										$msql->passingvalues($pkey=$form_key,$value);					
										$url = "pharmacyreports?$form_key";
										$engine->redirect($url);					
	
								}
							
						}
					}
			}
	
	break;


	// 04 MAY 2022 JOSPH ADORBOE
	case 'physiopatientstats': 
			
		//	$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';	
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
					if(empty($statstype)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
							if($statstype == 1){
								if(empty($fromdate) || empty($todate)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
								
									$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;

									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "physioreports?$form_key";
									$engine->redirect($url);	
								}								
							}else if($statstype == 2){
								if(empty($fromdate) || empty($todate)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
									
								
									$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
									
									$totalservices =  number_format($lov->gettotalamount($fromdate,$todate,$physiofirstvisit,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,$physiofullbodymassage,$physioreflexology,$instcode)); 
									
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate.'@@@'.$totalservices;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "physioreports?$form_key";
									$engine->redirect($url);	
								}		
								
							}else if($statstype == 3){
								$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
								
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "physioreports?$form_key";
									$engine->redirect($url);	
								

							}
						}
					}
			}
	
	break;




	// 13 FEB 2022 JOSEPH ADORBOE 
	case 'addnewhandover':

		$handovertitle = isset($_POST['handovertitle']) ? $_POST['handovertitle'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($handovertitle) || empty($notes) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$handovertitle = strtoupper($handovertitle);
				$handovercode = rand(1,1000);
			//	$handovernotes = date('d M Y h:i:s a', strtotime($days))."\r\n".$notes;
				
				$addhandover = $msql->insert_newhandovernotes($form_key,$handovercode,$day,$handovertitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
				$title = 'New Handover Added';
				if($addhandover == '0'){				
					$status = "error";					
					$msg = "$title $handovertitle Unsuccessful"; 
				}else if($addhandover == '1'){					
					$status = "error";					
					$msg = "$title $handovertitle Exist"; 						
				}else if($addhandover == '2'){
					$event= "$title Added successfully ";
					$eventcode= "153";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New Handover $handovertitle Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
					$status = "error";					
					$msg = " Unknown source ";					
				}
			}
		}

	break;



	// 22 JAN 2022 JOSEPH ADORBOE 
	case 'searchmedicalreport': 
	
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
				$url = "medicalreportpatients?$form_key";
				$engine->redirect($url);
				}
			}
		}

	break;


	// 02 JAN 2022  JOSPH ADORBOE
	case 'generalstats': 
			
		//	$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){			
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($statstype)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
							// $dt = explode('/', $scheduledate);
							// $schedulemonth = $dt[0];
							// $scheduleday = $dt[1];
							// $scheduleyear = $dt[2];
							// $scheduledate = $scheduleyear.'-'.$schedulemonth.'-'.$scheduleday;
	
							// if($scheduledate < $day){
							// 	$status = "error";
							// 	$msg = "Schedule date can only be a future date";
							// }else{
							// 	$value = $scheduledate.'@@@'.$shifttype;
							// 	$msql->passingvalues($pkey=$form_key,$value);					
							// 	$url = "manualschedule?$form_key";
							// 	$engine->redirect($url);
							// }
							
							if($statstype == 1){
								$value = $statstype;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "patientstatsreport?$form_key";
								$engine->redirect($url);
							}else if($statstype == 2){
								$value = $statstype;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "patientstatsreport?$form_key";
								$engine->redirect($url);
	
							}
						}
					}
			}
	
		break;

	


	// 13 NOV 2021 JOSPH ADORBOE
	case 'myconsultation': 
			
		//	$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$statstype = isset($_POST['statstype']) ? $_POST['statstype'] : '';	
			$statsmonth = isset($_POST['statsmonth']) ? $_POST['statsmonth'] : '';	
			$statsday = isset($_POST['statsday']) ? $_POST['statsday'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){			
					$status = "error";
					$msg = "Shift is closed";				
				}else{
					if(empty($statstype)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
							// $dt = explode('/', $scheduledate);
							// $schedulemonth = $dt[0];
							// $scheduleday = $dt[1];
							// $scheduleyear = $dt[2];
							// $scheduledate = $scheduleyear.'-'.$schedulemonth.'-'.$scheduleday;
	
							// if($scheduledate < $day){
							// 	$status = "error";
							// 	$msg = "Schedule date can only be a future date";
							// }else{
							// 	$value = $scheduledate.'@@@'.$shifttype;
							// 	$msql->passingvalues($pkey=$form_key,$value);					
							// 	$url = "manualschedule?$form_key";
							// 	$engine->redirect($url);
							// }
							
							if($statstype == 2){
								if(empty($statsmonth)){
									$status = "error";
									$msg = "Required Fields Month cannot be empty ";
								}else{
									$value = $statstype.'@@@'.$statsmonth;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "myconsultationreport?$form_key";
									$engine->redirect($url);	
								}								
							}
						}
					}
			}
	
		break;

	// 11 NOV 2021 JOSPH ADORBOE
	case 'patientstats': 
			
	//	$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
		$patientstats = isset($_POST['patientstats']) ? $_POST['patientstats'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($patientstats)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
						// $dt = explode('/', $scheduledate);
						// $schedulemonth = $dt[0];
						// $scheduleday = $dt[1];
						// $scheduleyear = $dt[2];
						// $scheduledate = $scheduleyear.'-'.$schedulemonth.'-'.$scheduleday;

						// if($scheduledate < $day){
						// 	$status = "error";
						// 	$msg = "Schedule date can only be a future date";
						// }else{
						// 	$value = $scheduledate.'@@@'.$shifttype;
						// 	$msql->passingvalues($pkey=$form_key,$value);					
						// 	$url = "manualschedule?$form_key";
						// 	$engine->redirect($url);
						// }
						
						if($patientstats == 1){
							$value = $patientstats;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "patientstatsreport?$form_key";
							$engine->redirect($url);
						}else if($patientstats == 2){
							$value = $patientstats;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "patientstatsreport?$form_key";
							$engine->redirect($url);

						}
					}
				}
		}

	break;


	// 05 NOV 2021 JOSEPH ADORBOE  
	case 'editlocum':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '';
		$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$taxprecentage = isset($_POST['taxprecentage']) ? $_POST['taxprecentage'] : '';
		$procedureshareamount = isset($_POST['procedureshareamount']) ? $_POST['procedureshareamount'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($name) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
				$facilityshare = 100-$procedureshareamount; 							
				$editpricing = $msql->editlocum($ekey,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Locum';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$name." Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "".$title." for ".$name." Exist"; 					
				}else if($editpricing == '2'){
					$event= " ".$title." ".$name."  successfully ";
					$eventcode= "74";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$name." Successfully";
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

	// 05 NOV 2021 JOSPH ADORBOE 
	case 'addlocum':			
		$personelname = isset($_POST['personelname']) ? $_POST['personelname'] : '';
		$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : '';
		$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$taxprecentage = isset($_POST['taxprecentage']) ? $_POST['taxprecentage'] : '';
		$procedureshareamount = isset($_POST['procedureshareamount']) ? $_POST['procedureshareamount'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($personelname) || empty($amount) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
				$locumnumber = $lov->getlocumnumber($instcode);	
				$pers = explode('@@@', $personelname);
				$personelcode = $pers[0];
				$personelname = $pers[1];	
				$facilityshare = 100-$procedureshareamount; 	
				$add = $msql->addnewlocum($form_key,$personelcode,$personelname,$locumnumber,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentuser,$currentusercode,$instcode);
				$title = 'Add Locum';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." ".$personelname."  Unsuccessful"; 
				}else if($add == '1'){				
					$status = "error";					
					$msg = "".$title." ".$personelname."  Exist"; 					
				}else if($add == '2'){
					$event= "".$title."  ".$personelname."  successfully ";
					$eventcode= "157";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$personelname."  Successfully";
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

	// 20 OCT 2021 JOSEPH ADORBOE 
	case 'addnewincidence':

		$incidencetitle = isset($_POST['incidencetitle']) ? $_POST['incidencetitle'] : '';
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($incidencetitle) || empty($type) || empty($notes) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$incidencetitle = strtoupper($incidencetitle);
				$incidencecode = $lov->getincidencecode($instcode);

				$addnewincidence = $msql->insert_newincidence($form_key,$incidencecode,$days,$incidencetitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode);
				$title = 'New Incidence Added';
				if($addnewincidence == '0'){				
					$status = "error";					
					$msg = "$title $incidencetitle Unsuccessful"; 
				}else if($addnewincidence == '1'){					
					$status = "error";					
					$msg = "$title $incidencetitle Exist"; 						
				}else if($addnewincidence == '2'){
					$event= "$title Added successfully ";
					$eventcode= "153";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "New Incidence $incidencetitle Added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
				}else{				
					$status = "error";					
					$msg = " Unknown source ";					
				}
			}
		}

	break;


	// 12 OCT 2021 JOSEPH ADORBOE
	case 'attachnonrequestedpatientresults':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patientnumbers = isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$items = isset($_POST['items']) ? $_POST['items'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
		$itmname = isset($_POST['itmname']) ? $_POST['itmname'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($itmname)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				// $itm = explode('@@@', $items);
				// $itmcode = $itm[0];
				// $itmname = $itm[1];	
				$itmcode = 'NA';	
				$requestcode = 'NA';
				$ext = '.pdf';
				$mkey = md5(microtime());
				$finame = $mkey.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $resultspathed.$finame;
				move_uploaded_file($file_temp_loc, $file_store);

				$attache = $msql->attachenonrequestedpatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$itmcode,$itmname,$remarks,$finame,$currentusercode,$currentuser,$instcode);
				$title = 'Results attached';
				if($attache == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$patient." Unsuccessful"; 
				}else if($attache == '1'){					
					$status = "error";					
					$msg = "".$title." for Patient ".$patient." Exist"; 				
				}else if($attache == '2'){
					$event= " ".$title." ".$patient."  successfully ";
					$eventcode= "62";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." for Patient ".$patient." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
													
				}else{					
					$status = "error";					
					$msg = " Unkown Source "; 					
				}
			}
		}		
	break;

	// 20 SEPT 2021 JOSEPH ADORBOE  
	case 'edititems':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$itemnames = isset($_POST['itemnames']) ? $_POST['itemnames'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($itemnames) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{				
								
				$editpricing = $msql->edititems($ekey,$itemnames,$desc,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Items';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$itemnames." Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "".$title." for ".$itemnames." Exist"; 					
				}else if($editpricing == '2'){
					$event= " ".$title." ".$itemnames."  successfully ";
					$eventcode= "74";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$itemnames." Successfully";
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


	// 20 SEPT 2021 JOSEPH ADORBOE 
	case 'additems':
		$itemnames = isset($_POST['itemnames']) ? $_POST['itemnames'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($itemnames)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				                  
					
					$itemnames = strtoupper($itemnames);
					$add = $msql->insert_addnewitems($form_key,$itemnames,$desc,$currentusercode,$currentuser,$instcode);
					$title = 'New Items Added';
					if ($add == '0') {
						$status = "error";
						$msg = "".$title." ".$itemnames." Unsuccessful";
					} elseif ($add == '1') {
						$status = "success";
						$msg = "".$title." ".$itemnames." Exist";						
					} elseif ($add == '2') {
						$event= "".$title." Added successfully ";
						$eventcode= "178";
						$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
						if ($audittrail == '2') {
							$status = "success";
							$msg = "New item ".$itemnames." Added Successfully";							
						} else {
							$status = "error";
							$msg = "Audit Trail unsuccessful";
						}
					} else {
						$status = "error";
						$msg = " Unknown source ";
					}
				}
		}

	break;


	// 10 JULY 2021
	case 'attachpatientexternalresults':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patientnumbers = isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$attachtype = isset($_POST['attachtype']) ? $_POST['attachtype'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
	//	$testscode = isset($_POST['testscode']) ? $_POST['testscode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ext = '.pdf';
				$finame = $ekey.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $resultspathed.$finame;
				move_uploaded_file($file_temp_loc, $file_store);

				$attache = $msql->attachepatientexternalresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$attachtype,$remarks,$finame,$currentusercode,$currentuser,$instcode);
				$title = 'Results attached';
				if($attache == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$patient." Unsuccessful"; 
				}else if($attache == '1'){					
					$status = "error";					
					$msg = "".$title." for Patient ".$patient." Exist"; 				
				}else if($attache == '2'){
					$event= " ".$title." ".$patient."  successfully ";
					$eventcode= "62";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." for Patient ".$patient." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
													
				}else{					
					$status = "error";					
					$msg = " Unkown Source "; 					
				}
			}
		}

		
	break;
	
	// 10 JULY 2021 JOSEPH ADORBOE patient folder search 
	case 'nurse_patientfoldersearch': 
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
					$url = "nursepatientfolder?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;

	
	
	// 11 JUNE 2021 JOSEPH ADORBOE 
	case 'medicationpricesearch': 

		$selectedone = isset($_POST['selectedone']) ? $_POST['selectedone'] : '';
		$selectedtwo = isset($_POST['selectedtwo']) ? $_POST['selectedtwo'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){			
			if(empty($selectedone) || empty($selectedtwo)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{							
					echo 'Welcome';
				}
		}

	break;

	// 03 JUN 2021 JOSEPH ADORBOE  
	case 'editpricining': 

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($paymentmethod) || empty($price) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				// $sht = explode('@@@', $billableservices);
				// $sercode = $sht[0];
				// $sername = $sht[1];	
				
				$paymethod = explode('@@@', $paymentmethod);
				$paycode = $paymethod[0];
				$payname = $paymethod[1];

				if(!empty($scheme)){
					$fac = explode('@@@', $scheme);
					$schcode = $fac[0];
					$schname = $fac[1];
				}else{
					$schcode = $schname = '';
				}				
				
				$editpricing = $msql->editpricing($ekey,$paycode,$payname,$schcode,$schname,$price,$day,$category,$currentusercode,$currentuser,$instcode);
				$title = 'Edit Price';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$medication." Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "".$title." for ".$medication." Exist"; 					
				}else if($editpricing == '2'){
					$event= " ".$title." ".$medication."  successfully ";
					$eventcode= "74";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$medication." Successfully";
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
	
	// 23 MAY 2021
	case 'attachpatientresults':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patientnumbers = isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$tests = isset($_POST['tests']) ? $_POST['tests'] : '';
		$testscode = isset($_POST['testscode']) ? $_POST['testscode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ext = '.pdf';
				$finame = $ekey.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $resultspathed.$finame;
				move_uploaded_file($file_temp_loc, $file_store);

				$attache = $msql->attachepatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$testscode,$tests,$finame,$currentusercode,$currentuser,$instcode);
				$title = 'Results attached';
				if($attache == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$patient." Unsuccessful"; 
				}else if($attache == '1'){					
					$status = "error";					
					$msg = "".$title." for Patient ".$patient." Exist"; 				
				}else if($attache == '2'){
					$event= " ".$title." ".$patient."  successfully ";
					$eventcode= "62";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." for Patient ".$patient." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
													
				}else{					
					$status = "error";					
					$msg = " Unkown Source "; 					
				}
			}
		}

		
	break;
			
	// 27 JAN 2021
	case 'set_editunits':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$units = isset($_POST['units']) ? $_POST['units'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$units = strtoupper($units);
				$editunits = $msql->update_editunits($ekey,$units,$currentusercode,$currentuser);				
				if($editunits == '0'){					
					$status = "error";					
					$msg = "Edit Units $units Unsuccessful"; 
				}else if($editunits == '1'){					
					$status = "error";					
					$msg = "Edit Units $units Exist Already"; 					
				}else if($editunits == '2'){
					$event= "Edit units: $form_key for $units has been saved successfully ";
					$eventcode= 66;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Edit Units $units successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
													
				}else{					
					$status = "error";					
					$msg = "Edit Dosage form query Unsuccessful "; 					
				}
			}
		}		
	break;



	// 27 JAN 2021
	case 'set_units':

		$units = isset($_POST['units']) ? $_POST['units'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($units)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';			
			}else{
				$units = strtoupper($units);
				$addunits = $msql->insert_addunits($form_key,$units,$currentusercode,$currentuser,$instcode);
				if($addunits == '0'){				
					$status = "error";					
					$msg = "Add units  $units Unsuccessful"; 
				}else if($addunits == '1'){						
					$status = "error";					
					$msg = "Add Units $units already Exist"; 					
				}else if($addunits == '2'){						
					$event= "Add Units $form_key has been saved successfully ";
					$eventcode= 65;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Add Units $units Successfully";		
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
						
			}else{				
					$status = "error";					
					$msg = "Query unsuccessful"; 					
			}
			}
		}
	break;

	// 27 JAN 2021
	case 'set_editdosageform':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$dosageform = strtoupper($dosageform);
				$editdosageform = $msql->update_editdosageform($ekey,$dosageform,$currentusercode,$currentuser);				
				if($editdosageform == '0'){					
					$status = "error";					
					$msg = "Edit Dosage form $dosageform Unsuccessful"; 
				}else if($editdosageform == '1'){						
					$status = "error";					
					$msg = "Edit dosage form $dosageform Exist Already"; 					
				}else if($editdosageform == '2'){	
					$event= "Edit Dosage Form :$form_key for $dosageform has been saved successfully ";
					$eventcode= 64;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Edit Dosage Form  $dosageform  Successfully";		
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}											
				}else{					
					$status = "error";					
					$msg = "Edit Dosage form query Unsuccessful "; 					
				}
			}
		}		
	break;

	// 27 JAN 2021
	case 'set_dosageform':

		$dosageform = isset($_POST['dosageform']) ? $_POST['dosageform'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($dosageform)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$dosageform = strtoupper($dosageform);
				$adddosageform = $msql->insert_dosageform($form_key,$dosageform,$currentusercode,$currentuser,$instcode);
				if($adddosageform == '0'){				
					$status = "error";					
					$msg = "Add dosage form $dosageform Unsuccessful"; 
				}else if($adddosageform == '1'){					
					$status = "error";					
					$msg = "Dosage Form $dosageform  already Exist"; 					
				}else if($adddosageform == '2'){
					$event= "Add Dosage form $form_key  has been saved successfully ";
					$eventcode= 63;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Add Dosage Form $dosageform Successfully";	
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}	
			}else{				
					$status = "error";					
					$msg = "Query unsuccessful";					
			}

			}
		}
	break;

	// 27 JAN 2021
	case 'billing_schemepatientsearch': 
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
					$url = "schemepatients?$form_key";
					$engine->redirect($url);				
				}
			}
		}
	break;	
	
	// 26 JAN 2021
	case 'attachpatientlegacy':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ext = '.pdf';
				$finame = $ekey.''.$ext;
				$file = $_FILES['fileone'];
				$file_name = $_FILES['fileone']['name'];
				$file_type = $_FILES['fileone']['type'];
				$file_size = $_FILES['fileone']['size'];
				$file_temp_loc = $_FILES['fileone']['tmp_name'];	
				$file_store = $pathed.$finame;
				move_uploaded_file($file_temp_loc, $file_store);
				$attache = $msql->update_patientfileed($ekey,$finame);				
				if($attache == '0'){					
					$status = "error";					
					$msg = "Attach legacy for Patient $patient Unsuccessful"; 
				}else if($attache == '1'){					
					$status = "error";					
					$msg = "Attach legacy for Patient $patient Exist"; 					
				}else if($attache == '2'){
					$event= "Attach Legacy :$form_key for $patient has been saved successfully ";
					$eventcode= 62;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Attach legacy for Patient $patient added Successfully";	
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}		
							
				}else{
					$status = "error";					
					$msg = "Add Price Unsuccessful "; 					
				}
			}
		}		
	break;

	// 17 JAN 2020 
	case 'records_updatepatientpaymentscheme': 
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$paymentscheme = isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '';
		$patientcardno = isset($_POST['patientcardno']) ? $_POST['patientcardno'] : '';
		$expirydate = isset($_POST['expirydate']) ? $_POST['expirydate'] : '';		
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){
				$status = "error";
				$msg = "Shift is closed";				
			}else{
			if(empty($ekey) || empty($paymentscheme) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$ps = explode('@@@', $paymentscheme);
				$paymentschemecode = $ps[0];
				$paymentscheme = $ps[1];
				$paymentmethodcode = $ps[2];
				$paymethname = $ps[3];
				$paymentplan = $ps[4];
				if(empty($expirydate)){
					$expirydate = $day ;
				}
				$editpatientpaymentscheme = $msql->insert_patientpaymentscheme($form_key,$ekey,$patientnumber,$patient,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$patientcardno,$expirydate,$currentusercode,$currentuser,$instcode,$day,$paymentplan);
				if($editpatientpaymentscheme == '0'){
					$status = "error";					
					$msg = "Patient Scheme$paymentscheme for $patient Unsuccessful"; 
				}else if($editpatientpaymentscheme == '1'){				
					$status = "error";					
					$msg = "Patient Scheme$paymentscheme for $patient Exist"; 					
				}else if($editpatientpaymentscheme == '2'){
					$event= "Patient Scheme CODE: $form_key $paymentscheme for $patient has been saved successfully ";
					$eventcode= 75;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Scheme $paymentscheme for $patient added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
					
				}else{					
					$status = "error";					
					$msg = "Add Price Unsuccessful "; 					
				}
			}				

			}
		}
	break;
	
	// 17 JAN 2021
	case 'records_patientpaymentschemesearch': 
		$patientpaymentscheme = isset($_POST['patientpaymentscheme']) ? $_POST['patientpaymentscheme'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
			if(empty($patientpaymentscheme) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{				
					$value = $patientpaymentscheme;
					$msql->passingvalues($pkey=$form_key,$value);
					$url = "patientpaymentscheme?$form_key";
					$engine->redirect($url);				
				}
			}
		}
	break;
	
	// 14 JAN 2021
	case 'records_patientrecord': 
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
					$url = "patientrecords?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;	

	// 14 JAN 2021
	case 'records_editpatientgroups':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$groupname = isset($_POST['groupname']) ? $_POST['groupname'] : '';
		$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($groupname) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';					
				}else{
					$editpatientgroup = $msql->update_patientgroup($ekey,$groupname,$desc,$currentusercode,$currentuser,$instcode);
					if($editpatientgroup == '0'){					
						$status = "error";					
						$msg = "Edit Patient Group Unsuccessful"; 	
					}else if($editpatientgroup == '1'){							
						$status = "error";					
						$msg = "Patient Group Exist";						
					}else if($editpatientgroup == '2'){
						$event= "New Patient Group CODE:".$form_key."  has been saved successfully ";
						$eventcode= 79;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Edit Patient group Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}		
							
				}else{
					
						$status = "error";					
						$msg = "Add Payment Method Unknown source "; 
						
				}
				}
			}
	break;	
	
	// 14 JAN 2021
	case 'records_editpatientgroupsmember': 

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){

			if($currentshiftcode == '0'){
			
				$status = "error";
				$msg = "Shift is closed";
				
			}else{
		
				if(empty($ekey) || empty($vkey) ){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

					
					$editpatientgroupmembers = $msql->update_patientgroupsmembersremove($form_key,$ekey,$vkey,$currentusercode,$currentuser,$instcode);
			
				if($editpatientgroupmembers == '0'){
				
					$status = "error";					
					$msg = "Remove Memeber from Group  Unsuccessful"; 
					

				}else if($editpatientgroupmembers == '1'){					
					
					$status = "error";					
					$msg = "Memeber  Group MemberExist"; 
					
				}else if($editpatientgroupmembers == '2'){
					
					$status = "success";
					$msg = "Remove Member from group Successfully";				
					
					$event= "New Patient memeber removed Group CODE:".$form_key."  has been saved successfully ";
					$eventcode= 78;
					$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				
				
			}else{
				
					$status = "error";					
					$msg = "Remove memeber Unknown source "; 
					
			}
			}
		
			
			}
			
		}

	break;
	
	
	// 14 JAN 2021
	case 'records_addpatientgroupsmembers': 

		$groupcode = isset($_POST['groupcode']) ? $_POST['groupcode'] : '';
		$groupname = isset($_POST['groupname']) ? $_POST['groupname'] : '';
		$grouppatientnumber = isset($_POST['grouppatientnumber']) ? $_POST['grouppatientnumber'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){

			if($currentshiftcode == '0'){
			
				$status = "error";
				$msg = "Shift is closed";
				
			}else{
		
				if(empty($groupcode) || empty($grouppatientnumber)){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

				//	$groupname = $lov->getgroupname($groupcode,$instcode);

					$addpatientgroupmembers = $msql->update_patientgroupsmembers($form_key,$groupcode,$groupname,$grouppatientnumber,$currentusercode,$currentuser,$instcode);
			
				if($addpatientgroupmembers == '0'){
				
					$status = "error";					
					$msg = "Add Patient Group member ".$groupname." Unsuccessful"; 
					

				}else if($addpatientgroupmembers == '1'){					
					
					$status = "error";					
					$msg = "Patient Group Member ".$groupname." Exist"; 
					
				}else if($addpatientgroupmembers == '2'){
					
					$status = "success";
					$msg = "New Patient Group ".$groupname."  member added Successfully";				
					
					$event= "New Patient memeber Group CODE:".$form_key." ".$groupname."  has been saved successfully ";
					$eventcode= 77;
					$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				
				
			}else{
				
					$status = "error";					
					$msg = "Patient Registration Unknown source "; 
					
			}
			}
		
			
			}
			
		}

	break;
	
 	
	// 14 Jan 2021
	case 'records_addpatientgroups': 

		$patientgroup = isset($_POST['patientgroup']) ? $_POST['patientgroup'] : '';
		$groupdesc = isset($_POST['groupdesc']) ? $_POST['groupdesc'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){

			if($currentshiftcode == '0'){
			
				$status = "error";
				$msg = "Shift is closed";
				
			}else{

				if(empty($patientgroup) || empty($patientnumber)){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

					$addpatientgroup = $msql->insert_patientgroups($form_key,$patientgroup,$groupdesc,$patientnumber,$day,$currentusercode,$currentuser,$instcode);
			
				if($addpatientgroup == '0'){
				
					$status = "error";					
					$msg = "Add Patient Group ".$patientgroup." Unsuccessful"; 
					

				}else if($addpatientgroup == '1'){					
					
					$status = "error";					
					$msg = "Patient Group ".$patientgroup." Exist"; 
					
				}else if($addpatientgroup == '2'){
					
					$status = "success";
					$msg = "New Patient Group ".$patientgroup." added Successfully";				
					
					$event= "New Patient Group CODE:".$form_key." ".$patientgroup."  has been saved successfully ";
					$eventcode= 76;
					$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				
				}else if($addpatientgroup == '3'){					
					
					$status = "error";					
					$msg = "Patient Number ".$patientnumber." doest Not   Exist";		
				
			}else{
				
					$status = "error";					
					$msg = "Patient Registration Unknown source "; 
					
			}
			}
		
			
			}
			
		}

	break;
	
		
	// 14 JAN 2021
	case 'records_patientrecordsearch': 
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
					$url = "patientsearch?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;

		// 8 JAN 2020 
		case 'addsinglepricing': 

			$billableservices = isset($_POST['billableservices']) ? $_POST['billableservices'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$price = isset($_POST['price']) ? $_POST['price'] : '';
			$type = isset($_POST['type']) ? $_POST['type'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
	
				if(empty($billableservices) || empty($paymentmethod) || empty($price) ){
	
					$status = "error";
					$msg = "Required Fields cannot be empty ";
	
				}else{
	
					$sht = explode('@@@', $billableservices);
					$sercode = $sht[0];
					$sername = $sht[1];	
					
					$fac = explode('@@@', $paymentmethod);
					$paycode = $fac[0];
					$payname = $fac[1];
	
					if(!empty($scheme)){
						$fac = explode('@@@', $scheme);
					$schcode = $fac[0];
					$schname = $fac[1];
	
					}else{
	
						$schcode = $schname = '';
	
					}
	
					
					
					$addsinglepriceing = $msql->admin_singlepricing($form_key,$sercode,$sername,$paycode,$payname,$schcode,$schname,$price,$day,$type,$currentusercode,$currentuser,$instcode);
	
					if($addsinglepriceing == '0'){
						
						$status = "error";					
						$msg = "Add Price  ".$sername." to ".$payname." Unsuccessful"; 
	
					}else if($addsinglepriceing == '1'){				
						
						$status = "error";					
						$msg = "Price ".$sername." to ".$payname." Exist"; 				
						
					}else if($addsinglepriceing == '2'){
						
						$status = "success";
						$msg = "Price for ".$sername." to ".$payname." added Successfully";
						
												
						$event= "ADD PRICE CODE:".$form_key." ".$sername." to ".$payname." has been saved successfully ";
						$eventcode= 74;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
										
					}else{
						
						$status = "error";					
						$msg = "Add Price Unsuccessful "; 
						
					}
	
					
	
				}
	
			}
	
		break;
	

	// // 6 JAN 2021 JOSEPH ADORBOE
	// 	case 'records_patientregistrationsave':

	// 		$newpatientnumber = isset($_POST['newpatientnumber']) ? $_POST['newpatientnumber'] : '';
	// 		$patientmaritalstatus = isset($_POST['patientmaritalstatus']) ? $_POST['patientmaritalstatus'] : '';
	// 		$patientemail = isset($_POST['patientemail']) ? $_POST['patientemail'] : '';
			
	// 		$patientpostal = isset($_POST['patientpostal']) ? $_POST['patientpostal'] : '';
	// 		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
	// 		$requestservices = isset($_POST['requestservices']) ? $_POST['requestservices'] : '';
			
	// 		$services = isset($_POST['services']) ? $_POST['services'] : '';
	// 		$patientfirstname = isset($_POST['patientfirstname']) ? $_POST['patientfirstname'] : '';
	// 		$patientgender = isset($_POST['patientgender']) ? $_POST['patientgender'] : '';
			
	// 		$patientphone = isset($_POST['patientphone']) ? $_POST['patientphone'] : '';
	// 		$patientnationality = isset($_POST['patientnationality']) ? $_POST['patientnationality'] : '';
	// 		$patientlastname = isset($_POST['patientlastname']) ? $_POST['patientlastname'] : '';
			
	// 		$patientreligion = isset($_POST['patientreligion']) ? $_POST['patientreligion'] : '';
	// 		$patientaltphone = isset($_POST['patientaltphone']) ? $_POST['patientaltphone'] : '';
	// 		$patientemergencyone = isset($_POST['patientemergencyone']) ? $_POST['patientemergencyone'] : '';
			
	// 		$privateinsurancescheme = isset($_POST['privateinsurancescheme']) ? $_POST['privateinsurancescheme'] : '';
	// 		$natioanlinsurancescheme = isset($_POST['natioanlinsurancescheme']) ? $_POST['natioanlinsurancescheme'] : '';
	// 		$partnerscheme = isset($_POST['partnerscheme']) ? $_POST['partnerscheme'] : '';
			
	// 		$patientbirthdate = isset($_POST['patientbirthdate']) ? $_POST['patientbirthdate'] : '';
	// 		$patienthomeaddress = isset($_POST['patienthomeaddress']) ? $_POST['patienthomeaddress'] : '';
	// 		$patientoccupation = isset($_POST['patientoccupation']) ? $_POST['patientoccupation'] : '';
			
	// 		$patientemergencytwo = isset($_POST['patientemergencytwo']) ? $_POST['patientemergencytwo'] : '';
	// 		$patientcardnumber = isset($_POST['patientcardnumber']) ? $_POST['patientcardnumber'] : '';
	// 		$patientcardexpirydate = isset($_POST['patientcardexpirydate']) ? $_POST['patientcardexpirydate'] : '';
			
	// 		$patienttitle = isset($_POST['patienttitle']) ? $_POST['patienttitle'] : '';
	// 		$attachefolder = isset($_POST['attachefolder']) ? $_POST['attachefolder'] : '';
	// 		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
	// 		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
			
	// 		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
	// 		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		
			
			
	// 		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				
	// 			if($preventduplicate == '1'){
					
	// 				if($currentshiftcode == '0'){
					
	// 					$status = "error";
	// 					$msg = "Shift is closed";
						
	// 				}else{

	// 				if(empty($paymentmethod) || empty($patientfirstname) || empty($patientlastname) || empty($patientbirthdate) || empty($patientgender) || empty($patientphone) || empty($patientemergencyone) || empty($patientemergencytwo)){
					
				
	// 					$status = 'error';
	// 					$msg = 'Required Field Cannot be empty';
	// 					$view = 'patientregistration';
											
	// 				}else{

	// 					$pay = explode('@@@', $paymentmethod);
	// 					$paymentmethodcode = $pay[0];
	// 					$paymentmenthodname = $pay[1];


	// 					if($paymentmethodcode == $privateinsurancecode  || $paymentmethodcode == $nationalinsurancecode || $paymentmethodcode == $partnercompaniescode){
							

	// 						if(!empty($privateinsurancescheme)){

	// 							$pays = explode('@@@', $privateinsurancescheme);
	// 							$paymentschemecode = $pays[0];
	// 							$paymentschemename = $pays[1];						

	// 						}

	// 						if(!empty($natioanlinsurancescheme)){

	// 							$pays = explode('@@@', $natioanlinsurancescheme);
	// 							$paymentschemecode = $pays[0];
	// 							$paymentschemename = $pays[1];						

	// 						}

	// 						if(!empty($partnerscheme)){

	// 							$pays = explode('@@@', $partnerscheme);
	// 							$paymentschemecode = $pays[0];
	// 							$paymentschemename = $pays[1];						

	// 						}

							
						
	// 					}else{

	// 						$paymentschemecode = $paymentschemename = '';
	// 					}


	// 					if($requestservices == 'YES'){

	// 						$ser = explode('@@@', $services);
	// 						$servicescode = $ser[0];
	// 						$servicesname = $ser[1];
	// 						$amount = $pricing->getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode);	
	// 						$newfolderamount = $pricing->getprice($paymentmethodcode,$paymentschemecode,'SER0001',$instcode,$cashschemecode);
	// 					//	die($newfolderamount);
	// 						$billamount = $amount + $newfolderamount ;
	// 					}else{

	// 						$servicescode = $servicesname = $amount = $billamount = $newfolderamount = '';

	// 					}


	// 					$patientfirstname = strtoupper($patientfirstname);
	// 					$patientlastname = strtoupper($patientlastname);
	// 					$fullname = $patientfirstname.' '.$patientlastname;

	// 					$bdate = explode('/', $patientbirthdate);
	// 					$mmd = $bdate[0];
	// 					$ddd = $bdate[1];
	// 					$yyy = $bdate[2];
	// 					$patientbirthdate = $yyy.'-'.$mmd.'-'.$ddd;

	// 			//		$patientbirthdate = date('Y-m-d', strtotime(str_replace('/','-', $patientbirthdate)));

	// 					if(!empty($patientcardexpirydate)){
						
	// 						$cdate = explode('/', $patientcardexpirydate);
	// 						$mmd = $cdate[0];
	// 						$ddd = $cdate[1];
	// 						$yyy = $cdate[2];
	// 						$patientcardexpirydate = $yyy.'-'.$mmd.'-'.$ddd;

	// 					}

						


			
	// 			//		$patientcardexpirydate = date('Y-m-d', strtotime(str_replace('/','-', $patientcardexpirydate)));
						

	// 						$lenght = strlen($patientphone);
	// 						$firstnumber = substr($patientphone, 0, 1);
	// 						$lenghtt = strlen($patientaltphone);
	// 						$firstnumbert = substr($patientaltphone, 0, 1);
										
	// 						if($lenght != '10' || $firstnumber !='0' || $lenghtt != '10' || $firstnumbert !='0'){
	
	// 							$status = "error";
	// 							$msg = "Phone Number format is wrong. Please correct it";
									
	// 						}else{
										
	// 							$prefix = '+233';
	// 							$smsphone = $prefix.''.$patientphone ;
	// 							$smsphoned = $prefix.''.$patientaltphone ;
	// 							$one = 1;
	// 							$fk = $form_key.''.$one;
	// 							$visitcode = md5($form_key);
	// 							$rt = 'requestservice';
	// 							$ght = $form_key.''.$rt;
	// 							$servicerequestcode = md5($ght);

	// 							$bills = 'bills';
	// 							$bil = $form_key.''.$bills;
	// 							$billingcode = md5($bil);

	// 							$billsitem = 'billsitems';
	// 							$billc = $form_key.''.$billsitem;
	// 							$billingitemcode = md5($billc);

	// 							$billsitem = 'newfolder';
	// 							$billc = $form_key.''.$billsitem;
	// 							$billingnewfolderitemcode = md5($billc);

	// 							$ext = '.pdf';
	// 							$filenamed = $form_key.''.$ext;

	// 							$patientage = $lov->getpatientage($patientbirthdate);

	// 						//	die($servicerequestcode);
												
								
	// 							if(!empty($newpatientnumber)){

	// 								if($instcode == 'HMIS101'){
										
	// 									$pnd = explode('/', $newpatientnumber);
	// 									$theserial = $pnd[0];
	// 									$theyear = $pnd[2];

	// 								}else{
								

	// 									$pnd = explode('/', $newpatientnumber);
	// 									$theserial = $pnd[0];
	// 									$theyear = $pnd[1];

	// 								}

	// 								$addnewpatient = $msql->insert_patientregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode,$patientemergencyone,$patientemergencytwo,$smsphone,$smsphoned,$fk,$patientemail,$patientpostal,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$paymentschemecode,$paymentschemename,$patientcardnumber,$patientcardexpirydate,$requestservices,$servicescode,$servicesname,$visitcode,$currentshiftcode,$currentshift,$servicerequestcode,$billingcode,$billingitemcode,$patientage,$amount,$newfolderamount,$billamount,$billingnewfolderitemcode,$filenamed);
									
								

	// 								/*
	// 								$newpatientnumbered = $coder->getnewpatientnumber($instcode);
	// 								$pn = explode('/', $newpatientnumbered);
	// 								$theserialed = $pn[0];
	// 								$theyeared = $pn[1];

	// 								die($theserialed);


	// 								if($theserial !== $theserialed){

	// 									$status = 'error';
	// 									$msg = 'The Patient Number '.$newpatientnumber.' is not the next number to be assigned for year.';
										
	// 								}else{

	// 									$addnewpatient = $msql->insert_patientregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode);
								
	// 								}
	// 								*/


	// 							}else{

	// 								if($instcode == 'HMIS101'){
										
	// 									$pnd = explode('/', $newpatientnumber);
	// 									$theserial = $pnd[0];
	// 									$theyear = $pnd[2];

	// 								}else{

	// 									$newpatientnumber = $coder->getnewpatientnumber($instcode);
										
	// 									$pn = explode('/', $newpatientnumber);
	// 									$theserial = $pn[0];
	// 									$theyear = $pn[1];

	// 								}

	// 								$addnewpatient = $msql->insert_patientregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode,$patientemergencyone,$patientemergencytwo,$smsphone,$smsphoned,$fk,$patientemail,$patientpostal,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$paymentschemecode,$paymentschemename,$patientcardnumber,$patientcardexpirydate,$requestservices,$servicescode,$servicesname,$visitcode,$currentshiftcode,$currentshift,$servicerequestcode,$billingcode,$billingitemcode,$patientage,$amount,$newfolderamount,$billamount,$billingnewfolderitemcode,$filenamed);
								

	// 							}

	// 							if($attachefolder == 'YES'){

	// 								$ext = '.pdf';

	// 								$finame = $form_key.''.$ext;
	// 								$file = $_FILES['fileone'];
	// 								$file_name = $_FILES['fileone']['name'];
	// 								$file_type = $_FILES['fileone']['type'];
	// 								$file_size = $_FILES['fileone']['size'];
	// 								$file_temp_loc = $_FILES['fileone']['tmp_name'];	
	// 								$file_store = $pathed.$finame;

	// 								move_uploaded_file($file_temp_loc, $file_store);

	// 							//	$msql->update_patientfile($form_key,$finame);

	// 							}
	// 					if($addnewpatient == '0'){						
	// 						$status = "error";					
	// 						$msg = "Add Patient ".$fullname." ".$newpatientnumber." Unsuccessful"; 	
	// 					}else if($addnewpatient == '1'){						
	// 						$status = "error";					
	// 						$msg = "Patient ".$fullname." ".$newpatientnumber."  Exist"; 						
	// 					}else if($addnewpatient == '2'){
	// 						$event= "Patient Registration PATIENT CODE:".$form_key." PATIENT NUMBER:".$newpatientnumber." , PATIENT :".$fullname." has been saved successfully ";
	// 						$eventcode= 101;
	// 						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
	// 						if($audittrail == '2'){
	// 							$status = "success";
	// 							$msg = "New Patient ".$fullname." Registerd with ".$newpatientnumber." Successfully";
	// 							$msql->processpatientnumber($form_key,$newpatientnumber,$theserial,$theyear,$instcode,$currentuser,$currentusercode);
	// 						}else{
	// 							$status = "error";					
	// 							$msg = "Audit Trail Failed!"; 
	// 						}					
	// 					}else{							
	// 						$status = "error";					
	// 						$msg = "Patient Registration Unknown source "; 							
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}

	// 	break;



		
		// 3 JAN 2021
		case 'setup_editassignpaymentmethod':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($paymentmethod)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$sht = explode('@@@', $paymentmethod);
					$paycode = $sht[0];
					$payname = $sht[1];	
					
					
					$fac = explode('@@@', $facility);
					$faccode = $fac[0];
					$facname = $fac[1];

					$setup_editassignpaymentmethod = $msql->setup_editassignpaymentmethod($ekey,$paycode,$payname,$faccode,$facname,$day,$currentusercode,$currentuser);

					if($setup_editassignpaymentmethod == '0'){
						
						$status = "error";					
						$msg = "Edit ".$payname." to ".$facname." Unsuccessful"; 

					}else if($setup_editassignpaymentmethod == '1'){				
						
						$status = "error";					
						$msg = "Assign ".$payname." to ".$facname." Exist"; 				
						
					}else if($setup_editassignpaymentmethod == '2'){
						
						$status = "success";
						$msg = "Assign ".$payname." to ".$facname." Editted Successfully";
						
						
						$event= "Assign Payment method CODE:".$form_key." Method:".$payname." , Facility :".$facname." has been saved successfully ";
						$eventcode= 99;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							
				
						
					}else{
						
						$status = "error";					
						$msg = "Assign ".$payname." to ".$facname." unknown "; 
						
					}
			
				
				
			}
		}

	break;





	// 6 JAN 2020 
	case 'setup_assignsservices': 

			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
			$billable = isset($_POST['billable']) ? $_POST['billable'] : '';
			$servicestate = isset($_POST['servicestate']) ? $_POST['servicestate'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){

				if(empty($services) || empty($facility) ){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

					$sht = explode('@@@', $services);
					$sercode = $sht[0];
					$sername = $sht[1];	
					
					$fac = explode('@@@', $facility);
					$faccode = $fac[0];
					$facname = $fac[1];
					
					$setup_assignservices = $msql->setup_assignservices($form_key,$sercode,$sername,$faccode,$facname,$billable,$servicestate,$day,$currentusercode,$currentuser);

					if($setup_assignservices == '0'){
						
						$status = "error";					
						$msg = "Assign  ".$sername." to ".$facname." Unsuccessful"; 

					}else if($setup_assignservices == '1'){				
						
						$status = "error";					
						$msg = "Assign ".$sername." to ".$facname." Exist"; 				
						
					}else if($setup_assignservices == '2'){
						
						$status = "success";
						$msg = "Assigned ".$sername." to ".$facname." Successfully";
						
												
						$event= "ASSIGN SERVICES CODE:".$form_key." ".$sername." to ".$facname." has been saved successfully ";
						$eventcode= 98;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
										
					}else{
						
						$status = "error";					
						$msg = "Assign Services Unsuccessful "; 
						
					}

					

				}

			}

	break;


			
		
		// 1 JAN 2021
		case 'setup_editservices':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$servicename = isset($_POST['servicename']) ? $_POST['servicename'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($servicename)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$servicename = strtoupper($servicename);
					$setup_editservice = $msql->setup_editservice($ekey,$servicename,$desc,$currentusercode,$currentuser);

					if($setup_editservice == '0'){
						
						$status = "error";					
						$msg = "Edit ".$servicename." Unsuccessful"; 

					}else if($setup_editservice == '1'){				
						
						$status = "error";					
						$msg = "Service ".$servicename." Exist"; 				
						
					}else if($setup_editservice == '2'){
						
						$status = "success";
						$msg = "Service ".$servicename." Editted Successfully";
						
						
						$event= "EDIT SERVICES CODE:".$form_key." ".$servicename." has been saved successfully ";
						$eventcode= 98;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
						
					}else{
						
						$status = "error";					
						$msg = "Password Change Unsuccessful "; 
						
					}
			
				
				
			}
		}

	break;






	// 1 JAN 2020 
	case 'setup_addservices': 

			$servicecode = isset($_POST['servicecode']) ? $_POST['servicecode'] : '';
			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){

				if(empty($servicecode) || empty($services) ){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

					$services = strtoupper($services);
					
					$setup_services = $msql->setup_services($form_key,$servicecode,$services,$desc,$currentusercode,$currentuser);

					if($setup_services == '0'){
						
						$status = "error";					
						$msg = "Add Services ".$services." Unsuccessful"; 

					}else if($setup_services == '1'){				
						
						$status = "error";					
						$msg = "Services ".$services." Exist"; 				
						
					}else if($setup_services == '2'){
						
						$status = "success";
						$msg = "Services ".$services." Added Successfully";
						
						
						$event= "ADD SERVICES CODE:".$form_key." ".$services." has been saved successfully ";
						$eventcode= 97;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
				
						
					}else{
						
						$status = "error";					
						$msg = "Add Facility Unsuccessful "; 
						
					}

					

				}

			}

	break;


	
	
	
	
		// 11 OCT 2020
		case 'editpaymentpartner':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
			$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$partneraddress = isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '';
			$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
			$contactperson = isset($_POST['contactperson']) ? $_POST['contactperson'] : '';
			$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
			$partnerremarks = isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
				if($preventduplicate == '1'){
					if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';						
					}else{											
							$pay = explode('@@@', $paymentmethod);
							$paymentmethodcode = $pay[0];
							$paymentmethodname = $pay[1];
							$partnername = strtoupper($partnername);
						$editpaymentpartner = $msql->update_paymentpartner($ekey,$partnername,$paymentmethodcode,$paymentmethodname,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);						
						if($editpaymentpartner == '0'){						
							$status = "error";					
							$msg = "Add Payment Partner $partnername Unsuccessful"; 		
						}else if($editpaymentpartner == '1'){							
							$status = "error";					
							$msg = "Payment Partner $partnername Exist";							
						}else if($editpaymentpartner == '2'){							
							$status = "success";
							$msg = "Add Payment Partner $partnername Successfully";							
							$event= "Payment Partner $form_key has been saved successfully ";
							$eventcode= "018";
							$msql->auditlog($currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							$msql->insertformkey($form_number,$form_key,$currentusercode,$currentuser,$instcode);
							$event= "EDIT PAYMENT PARTNER CODE:$form_key $partnername has been saved successfully ";
							$eventcode= 96;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);						
					}else{						
							$status = "error";					
							$msg = "Add Payment Method Unknown source "; 							
					}
					}
				}
		break;	

		
		// 3 JAN 2021
		case 'addpaymentscheme':
			$newscheme = isset($_POST['newscheme']) ? $_POST['newscheme'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$schemepercentage = isset($_POST['schemepercentage']) ? $_POST['schemepercentage'] : '';
			$patientpercentage = isset($_POST['patientpercentage']) ? $_POST['patientpercentage'] : '';
			$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
							$addpaymentscheme = $msql->insert_paymentscheme($form_key, $newscheme, $desc, $paymentmethodcode, $paymentmethodname, $partnercode, $partnername, $schemepercentage, $patientpercentage,$plan, $currentusercode, $currentuser, $instcode);
							if ($addpaymentscheme == '0') {
								$status = "error";
								$msg = "Add Payment Scheme $newscheme  Unsuccessful";
							} elseif ($addpaymentscheme == '1') {
								$status = "error";
								$msg = "Payment Scheme $newscheme  Exist";
							} elseif ($addpaymentscheme == '2') {
								$status = "success";
								$msg = "Add Payment Scheme $newscheme Successfully";
								$event= "ADD PAYMENT SCHEME CODE:$form_key $newscheme has been saved successfully ";
								$eventcode= 95;
								$msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
							} else {
								$status = "error";
								$msg = "Add Payment Method Unknown source ";
							}
						}
					}
										
				}
		break;

		// 15 NOV 2022, 12 OCT 2020
		case 'editpaymentscheme':
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$newscheme = isset($_POST['newscheme']) ? $_POST['newscheme'] : '';
			$pmethod = isset($_POST['pmethod']) ? $_POST['pmethod'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			$schemepercentage = isset($_POST['schemepercentage']) ? $_POST['schemepercentage'] : '';
			$patientpercentage = isset($_POST['patientpercentage']) ? $_POST['patientpercentage'] : '';
			$vkey = isset($_POST['vkey']) ? $_POST['vkey'] : '';
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
			$paymentmethodname = isset($_POST['paymentmethodname']) ? $_POST['paymentmethodname'] : '';
			$partnercode = isset($_POST['partnercode']) ? $_POST['partnercode'] : '';
			$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
			$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
				if($preventduplicate == '1'){
					if(empty($newscheme) || empty($pmethod) ){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';					
					}else{
							//$totalpercentage = $schemepercentage + $patientpercentage ;
						
							if($patientpercentage > 100 || $patientpercentage < 0){
								$status = 'error';
								$msg = 'Patient percentage cannot be greater than 100 or less than 0';	
						
							}else{
								if(empty($patientpercentage)){
									$patientpercentage = 0;
								}
																
								$schemepercentage = 100 - $patientpercentage;
								// if($vkey !== $pmethod){
								// 	$pay = explode('@@@', $pmethod);
								// 	$paymentmethodcode = $pay[0];
								// 	$paymentmethodname = $pay[1];
								// 	$partnercode = $pay[2];
								// 	$partnername = $pay[3];
								// }								
							
							//	$msql->update_scheme($ekey,$paymentmethodcode,$paymentmethodname,$partnercode,$partnername);
							$editpaymentscheme = $msql->update_paymentscheme($ekey, $newscheme, $desc, $paymentmethodcode, $paymentmethodname, $partnercode, $partnername, $schemepercentage, $patientpercentage, $plan,$currentusercode, $currentuser, $instcode);
							if ($editpaymentscheme == '0') {
								$status = "error";
								$msg = "Edit Payment Scheme Unsuccessful";
							} elseif ($editpaymentscheme == '1') {
								$status = "error";
								$msg = "Payment Scheme Exist";
							} elseif ($editpaymentscheme == '2') {
								$status = "success";
								$msg = "Edit Payment Scheme Successfully";

								$event= "Edit payment scheme  $ekey successfully ";
							$eventcode= 94;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							} else {
								$status = "error";
								$msg = "Add Payment Method Unknown source ";
							}
						}

					}
				}
		break;


		// 11 OCT 2020
		case 'addpaymentpartner':
			$partnername = isset($_POST['partnername']) ? $_POST['partnername'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$partneraddress = isset($_POST['partneraddress']) ? $_POST['partneraddress'] : '';
			$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
			$contactperson = isset($_POST['contactperson']) ? $_POST['contactperson'] : '';
			$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';
			$partnerremarks = isset($_POST['partnerremarks']) ? $_POST['partnerremarks'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);				
				if($preventduplicate == '1'){
					if(empty($partnername) || empty($paymentmethod) || empty($partneraddress) || empty($phone) || empty($contactperson)){
						$status = 'error';
						$msg = 'Required Field Cannot be empty';						
					}else{
						$pay = explode('@@@', $paymentmethod);
						$paymentmethodcode = $pay[0];
						$paymentmethodname = $pay[1];
						$partnername = strtoupper($partnername);
						$addpaymentpartner = $msql->insert_paymentpartner($form_key,$paymentmethodcode,$paymentmethodname,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode);
						if($addpaymentpartner == '0'){						
							$status = "error";					
							$msg = "Add Payment Partner $partnername Unsuccessful"; 		
						}else if($addpaymentpartner == '1'){							
							$status = "error";					
							$msg = "Payment Partner $partnername Exist"; 							
						}else if($addpaymentpartner == '2'){							
							$status = "success";
							$msg = "Add Payment Partner $partnername Successfully";							
							$event= "ADD PAYMENT PARTNERS CODE: $form_key $partnername has been saved successfully ";
							$eventcode= 94;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);						
					}else{						
							$status = "error";					
							$msg = "Add Payment Partner  $partnername   Unknown source "; 							
					}

					}
				}
		break;
		
		
		
		// 3 JAN 2021
		case 'setup_editassignpaymentmethod':

				$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
				$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
				$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
				
				$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
				$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

				$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
				if($preventduplicate == '1'){


				if(empty($ekey) || empty($paymentmethod)){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{
						
						$sht = explode('@@@', $paymentmethod);
						$paycode = $sht[0];
						$payname = $sht[1];	
						
						
						$fac = explode('@@@', $facility);
						$faccode = $fac[0];
						$facname = $fac[1];

						$setup_editassignpaymentmethod = $msql->setup_editassignpaymentmethod($ekey,$paycode,$payname,$faccode,$facname,$day,$currentusercode,$currentuser);

						if($setup_editassignpaymentmethod == '0'){
							
							$status = "error";					
							$msg = "Edit ".$payname." to ".$facname." Unsuccessful"; 

						}else if($setup_editassignpaymentmethod == '1'){				
							
							$status = "error";					
							$msg = "Assign ".$payname." to ".$facname." Exist"; 				
							
						}else if($setup_editassignpaymentmethod == '2'){
							
							$status = "success";
							$msg = "Assign ".$payname." to ".$facname." Editted Successfully";
							
							$event= "EDIT ASSIGN PAYMENT METHOD CODE:".$form_key." ".$payname." to ".$facname." has been saved successfully ";
							$eventcode= 93;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
							
						}else{
							
							$status = "error";					
							$msg = "Assign ".$payname." to ".$facname." unknown "; 
							
						}
				
					
					
				}
			}

		break;





		// 3 JAN 2020 
		case 'setup_assignpaymentmethod': 

				$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
				$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
				
				$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
				$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
				
				$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				
				if($preventduplicate == '1'){

					if(empty($paymentmethod) || empty($facility) ){

						$status = "error";
						$msg = "Required Fields cannot be empty ";

					}else{

						$sht = explode('@@@', $paymentmethod);
						$paycode = $sht[0];
						$payname = $sht[1];	
						
						$fac = explode('@@@', $facility);
						$faccode = $fac[0];
						$facname = $fac[1];
						
						$setup_assignpaymentmethod = $msql->setup_assignpaymentmethod($form_key,$paycode,$payname,$faccode,$facname,$day,$currentusercode,$currentuser);

						if($setup_assignpaymentmethod == '0'){
							
							$status = "error";					
							$msg = "Assign  ".$payname." to ".$facname." Unsuccessful"; 

						}else if($setup_assignpaymentmethod == '1'){				
							
							$status = "error";					
							$msg = "Assign ".$payname." to ".$facname." Exist"; 				
							
						}else if($setup_assignpaymentmethod == '2'){
							
							$status = "success";
							$msg = "Assigned ".$payname." to ".$facname." Successfully";
							
							
							$event= "ADD ASSIGN PAYMENT METHOD CODE:".$form_key." ".$payname." to ".$facname." has been saved successfully ";
							$eventcode= 92;
							$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
										
						}else{
							
							$status = "error";					
							$msg = "Assign facility Unsuccessful "; 
							
						}

						

					}

				}

		break;



	
	
		// 03 JAN 2021
		case 'setup_editpaymentmethod':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';

			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($paymentmethod)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$paymentmethod = strtoupper($paymentmethod);
					$setup_editpaymentmethod = $msql->setup_editpaymentmethod($ekey,$paymentmethod,$desc,$currentusercode,$currentuser);

					if($setup_editpaymentmethod == '0'){
						
						$status = "error";					
						$msg = "Edit  ".$paymentmethod." Unsuccessful"; 

					}else if($setup_editpaymentmethod == '1'){				
						
						$status = "error";					
						$msg = "Edit ".$paymentmethod."  Exist"; 				
						
					}else if($setup_editpaymentmethod == '2'){
						
						$status = "success";
						$msg = "Edit ".$paymentmethod."  Successfully";
						
						
						$event= "EDIT PAYMENT METHOD CODE:".$form_key." ".$paymentmethod." has been saved successfully ";
						$eventcode= 91;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
						
					}else{
						
						$status = "error";					
						$msg = "Password Change Unsuccessful "; 
						
					}
			
				
				
			}
		}

	break;



	// 02 JAN 2021
	case 'setup_addpaymentmethod': 

			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){

				if(empty($paymentmethod) ){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{

					$paymentmethod = strtoupper($paymentmethod);
						
					$setup_paymentmethod = $msql->setup_paymentmethod($form_key,$paymentmethod,$desc,$currentusercode,$currentuser);

					if($setup_paymentmethod == '0'){
						
						$status = "error";					
						$msg = "Add Payment Method for ".$paymentmethod." Unsuccessful"; 

					}else if($setup_paymentmethod == '1'){				
						
						$status = "error";					
						$msg = "Payment Method ".$paymentmethod." Exist"; 				
						
					}else if($setup_paymentmethod == '2'){
						
						$status = "success";
						$msg = "Payment Method ".$paymentmethod." added Successfully";
						
						
						$event= "ADD PAYMENT METHOD CODE:".$form_key." ".$paymentmethod." has been saved successfully ";
						$eventcode= 90;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						
						
					}else{
						
						$status = "error";					
						$msg = "Add payment Method ".$paymentmethod." Unsuccessful "; 
						
					}
				}
			}
	break;
	
	// 02 JAN 2021
	case 'setup_addsetupusers':		

			$inputusername = isset($_POST['inputusername']) ? $_POST['inputusername'] : '';
			$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
			$theuserlevel = isset($_POST['theuserlevel']) ? $_POST['theuserlevel'] : '';
			$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';			
				
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';			
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
	
			if($preventduplicate == '1'){
			
				if(empty($inputusername)  || empty($fullname) || empty($theuserlevel) || empty($facility)){

					$status = "error";
					$msg = "Required Fields cannot be empty ";

				}else{	
					
					$fac = explode('@@@', $facility);
					$faccode = $fac['0'];
					$facname = $fac['1'];
					$facsname = $fac['2'];

					$ulev = explode('@@@', $theuserlevel);
					$ulevcode = $ulev['0'];
					$ulevname = $ulev['1'];
					

					$inputusername = $inputusername.'@'.$facsname ;            
				
					$pwd = $hash = md5($inputusername . $facsname);
					$newuserkey = md5($inputusername . $form_key);
				
								
				$setup_adduser = $msql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$nowday,$newuserkey,$faccode,$facname,$facsname,$ulevcode,$ulevname,$currentusercode,$currentuser);	
				
				if($setup_adduser == '0'){
					
					$status = "error";					
					$msg = "Adding New User ".$fullname." Unsuccessful"; 

				}else if($setup_adduser == '1'){
				
					
					$status = "error";					
					$msg = "User ".$fullname." already Exist"; 				
					
				}else if($setup_adduser == '2'){
					
					$status = "success";
					$msg = "New User ".$inputusername." added Successfully";				

					
					$event= "ADD SETUP USER  CODE:".$form_key."  ".$fullname. " has been saved successfully ";
						$eventcode= 85;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				
					
					
				}else{
					
					$status = "error";					
					$msg = "Add New Users Unsuccessful "; 
					
				}
							
			}
		}

	break;
		
		
		
	
	// 1 JAN 2021
	case 'closeshift':					
			$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode']: '';
			$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift']: '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){			
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is already closed";				
				}else{
				$closeshift = $msql->closingshift($currentshiftcode,$days,$currentuser,$currentusercode,$instcode);						
				
				if($closeshift == 0){
					$status = "error";
					$msg = "Failed.! Query Unsuccessful";
				}else if($closeshift == 1){
					$status = "error";
					$msg = "Failed.! Already Exist";
				}else if($closeshift == 2){
					$status = "success";
					$msg = "Shift ".$currentshift." Closed Successfully";					
					$currentshiftcode='';
					$event= "SHIFT CLOSED  CODE:".$form_key."  ".$currentshiftcode. " has been saved successfully ";
					$eventcode= 80;
					$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);				
				}else {
					$status = "error";
					$msg = "Failed.! Unknown Source";
				}				
			}
		}			
	break;
	
	
	// 01 JAN 2021
	case 'newshift':
		
			$shifttype = isset($_POST['shifttype']) ? $_POST['shifttype']: '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){
				if(empty($shifttype) ){				
					$status = "error";
					$msg = "Required Fields cannot be empty";				
				}else{	
					$shft = explode('@@@', $shifttype);
					$shftty = $shft[0];
					$shftstart =$shft[1];
					$shftend = $shft[2];
				$shiftname = date('d M Y', strtotime($day)) .'@'.$shftty;
				$newshift = $msql->opennewshift($form_key,$day,$shiftname,$shftty,$days,$shftstart,$shftend,$currentuser,$currentusercode,$instcode);
				$title = "New Shift";				
				if($newshift == 0){
					$status = "error";
					$msg = "Failed.! ".$title." Query Unsuccessful";	
				}else if($newshift == 1){
					$status = "error";
					$msg = "Failed.! ".$title." Already Exist";
				}else if($newshift == 2){
						$event= "".$title." for :".$form_key." has been saved successfully ";
						$eventcode= 81;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." ".$shiftname." Opened Successfully";	
						
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}					
				}else {
					$status = "error";
					$msg = "Failed.! Unknown Source";
				}				
			}								
			}
			
	break;

	// 1 JAN 2021
	case 'setup_editassignshifttypes':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$shifttypes = isset($_POST['shifttypes']) ? $_POST['shifttypes'] : '';
			$facility = isset($_POST['facility']) ? $_POST['facility'] : '';
			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($shifttypes)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$sht = explode('@@@', $shifttypes);
					$shtcode = $sht[0];
					$shtname = $sht[1];	
					
					$fac = explode('@@@', $facility);
					$faccode = $fac[0];
					$facname = $fac[1];

					$setup_editassignfacility = $msql->setup_editassignfacility($ekey,$shtcode,$shtname,$faccode,$facname,$day,$currentusercode,$currentuser);

					if($setup_editassignfacility == '0'){
						
						$status = "error";					
						$msg = "Edit Unsuccessful"; 

					}else if($setup_editassignfacility == '1'){				
						
						$status = "error";					
						$msg = "Facility Exist"; 				
						
					}else if($setup_editassignfacility == '2'){
						
						$status = "success";
						$msg = "Shift type ".$shtname. "  TO ".$facname. " Editted Successfully";
						
						
						$event= "EDIT ASSIGN  SHIFT TYPES CODE:".$form_key."  ".$shtname. "  TO ".$facname. " has been saved successfully ";
						$eventcode= 82;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				
				
						
					}else{
						
						$status = "error";					
						$msg = "Password Change Unsuccessful "; 
						
					}
			
				
				
			}
		}

	break;

	
	// 1 JAN 2021
	case 'setup_editfacility':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$facilityname = isset($_POST['facilityname']) ? $_POST['facilityname'] : '';
			$facilityaddress = isset($_POST['facilityaddress']) ? $_POST['facilityaddress'] : '';
			$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';

			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($facilityname)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$facilityname = strtoupper($facilityname);
					$setup_editfacility = $msql->setup_editfacility($ekey,$facilityname,$facilityaddress,$phonenumber,$currentusercode,$currentuser);

					if($setup_editfacility == '0'){
						
						$status = "error";					
						$msg = "Edit  ".$facilityname. " Unsuccessful"; 

					}else if($setup_editfacility == '1'){				
						
						$status = "error";					
						$msg = "Facility  ".$facilityname. " Exist"; 				
						
					}else if($setup_editfacility == '2'){
						
						$status = "success";
						$msg = "Facility  ".$facilityname. " Editted Successfully";
						
						$event= " EDIT FACILITY CODE:".$form_key."  ".$facilityname. "   has been saved successfully ";
						$eventcode= 84;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									
					}else{
						
						$status = "error";					
						$msg = "Password Change Unsuccessful "; 
						
					}
			
				
				
			}
		}

	break;

	

	// 31 DEC 2020
	case 'setup_editshifttypes':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$shifttypes = isset($_POST['shifttypes']) ? $_POST['shifttypes'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';

			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';

			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
			if($preventduplicate == '1'){


			if(empty($ekey) || empty($shifttypes)){

				$status = "error";
				$msg = "Required Fields cannot be empty ";

			}else{
					
					$shifttypes = strtoupper($shifttypes);
					$setup_editshift = $msql->setup_editshifttypes($ekey,$shifttypes,$desc,$currentusercode,$currentuser);

					if($setup_editshift == '0'){
						
						$status = "error";					
						$msg = "Edit ".$shifttypes." Unsuccessful"; 

					}else if($setup_editshift == '1'){				
						
						$status = "error";					
						$msg = "Shift type ".$shifttypes." Exist"; 				
						
					}else if($setup_editshift == '2'){						
						$status = "success";
						$msg = "Shift types  ".$shifttypes." added Successfully";						
						$event= " EDIT SHIFT TYPES SETUP  CODE:".$form_key."  ".$shifttypes. "   has been saved successfully ";
						$eventcode= 71;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);						
					}else{						
						$status = "error";					
						$msg = "Password Change Unsuccessful "; 						
					}				
			}
		}
	break;	
	
	// 31 DEC 2020
	case 'setup_addshifttypes':
			$shifttypes = isset($_POST['shifttypes']) ? $_POST['shifttypes'] : '';
			$desc = isset($_POST['desc']) ? $_POST['desc'] : '';			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($shifttypes) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					$shifttypes = strtoupper($shifttypes);						
					$setup_shifttypes = $msql->setup_shifttypes($form_key,$shifttypes,$desc,$currentusercode,$currentuser);
					if($setup_shifttypes == '0'){						
						$status = "error";					
						$msg = "Add Shift Types Unsuccessful"; 
					}else if($setup_shifttypes == '1'){							
						$status = "error";					
						$msg = "Shifts Types Exist"; 							
					}else if($setup_shifttypes == '2'){						
						$status = "success";
						$msg = "Shift types Successfully";					
						$event= " ADD SHIFT TYPES SETUP  CODE:".$form_key."  ".$shifttypes. "   has been saved successfully ";
						$eventcode= 72;
						$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);					
					}else{						
						$status = "error";					
						$msg = "Shift types Unsuccessful "; 						
					}
				}
			}
	break;
	
	// 30 DEC 2020
	case 'changepassword':
			$newpassword = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';
			$confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
			if(empty($newpassword) || empty($confirmpassword)){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				if($newpassword != $confirmpassword){
					$status = "error";
					$msg = "Passwords dont march  ";
				}else{
					if(strlen($newpassword) < 12){
						$status = "error";
						$msg = "Passwords MUST be more than 12 characters ";
					}else{
                        $updatepassword = $msql->updatepassword($newpassword, $userkey, $currentusername);
                        if ($updatepassword == '0') {
                            $status = "error";
                            $msg = "Password Change Unsuccessful";
                        } elseif ($updatepassword == '1') {
                            $status = "error";
                            $msg = "Password Changes Exist";
                        } elseif ($updatepassword == '2') {
							$event= "change password ";
							$eventcode= 3;
							$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
							if ($audittrail == '2') {
								$status = "success";
								$msg = "Password Changed Successfully";
							} else {
								$status = "error";
								$msg = "Audit Trail Failed!";
							}

                        } else {
                            $status = "error";
                            $msg = "Password Change Unsuccessful ";
                        }
                    }			
				}				
			}
		}
	break;	
		
}
?>
