<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
		
	$investigationmodel = htmlspecialchars(isset($_POST['investigationmodel']) ? $_POST['investigationmodel'] : '');
	
	// 27 MAR 2021 
switch ($investigationmodel)
{
	// 9 AUG 2024, JOSEPH ADORBOE 
	case 'pastaddpatientlabs':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
		$newlabs = htmlspecialchars(isset($_POST['newlabs']) ? $_POST['newlabs'] : '');		
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($labs) && empty($newlabs) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($labs) && empty($newlabs)){			
				$type = 'OPD';
				$cate = 'LABS';
				foreach($labs as $key){
					$la = explode('@@@',$key);
					$labscode = $la['0'];
					$labsname = $la['1'];
					$labpartnercode = $la['2'];					
					$labrequestcode = rand(1,1000);
					$form_key = md5(microtime());
					$sqlresults = $patientsInvestigationRequesttable->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);
		
					$action = "lab Requested successfully";							
					$result = $engine->getresults($sqlresults,$item=$labsname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9785;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}

		}else if(empty($labs) && !empty($newlabs)){
			$type = 'OPD';
			$cate = 'LABS';			
			$labrequestcode = rand(1,1000);
			$labcodenum = $lov->getlabcode($instcode);
			$newlabs = strtoupper($newlabs);
			$labscode = md5(microtime());
			$sqlresults = $patientsInvestigationRequesttable->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);
		
			$action = "lab Requested successfully";							
			$result = $engine->getresults($sqlresults,$item=$labsname,$action);
			$re = explode(',', $result);
			$status = $re[0];					
			$msg = $re[1];
			$event= "$action: $form_key $msg";
			$eventcode=9785;
			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		}else if(!empty($labs) && !empty($newlabs)){
			$status = "error";					
			$msg = "Labs and New labs cannot be both used at the same time "; 

			}
		}

	break;
	// 5 oct 2023, 27 MAR 2021
	case 'addpatientlabs':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
		$newlabs = htmlspecialchars(isset($_POST['newlabs']) ? $_POST['newlabs'] : '');		
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($labs) && empty($newlabs) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($labs) && empty($newlabs)){			
				$type = 'OPD';
				$cate = 'LABS';
				foreach($labs as $key){
					$la = explode('@@@',$key);
					$labscode = $la['0'];
					$labsname = $la['1'];
					$labpartnercode = $la['2'];					
				//	$labrequestcode = $lov->getlabrequestcode($instcode);
					$labrequestcode = rand(1,1000);
					$form_key = md5(microtime());
				$sqlresults = $investigationcontroller->newlabrequest($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan,$patientsInvestigationRequesttable,$patientconsultationstable);
				
				$action = "lab Requested successfully";							
				$result = $engine->getresults($sqlresults,$item=$labsname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=437;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}

		}else if(empty($labs) && !empty($newlabs)){
			$type = 'OPD';
			$cate = 'LABS';			
			$labrequestcode = rand(1,1000);
			$labcodenum = $lov->getlabcode($instcode);
			$newlabs = strtoupper($newlabs);
			$labscode = md5(microtime());
			$addlabs = $investigationcontroller->newlabrequest($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labcodenum,$labscode,$newlabs,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$plan,$patientsInvestigationRequesttable,$patientconsultationstable);
			$action = "lab Requested successfully";							
				$result = $engine->getresults($sqlresults,$item=$labsname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=437;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
		}else if(!empty($labs) && !empty($newlabs)){
			$status = "error";					
			$msg = "Labs and New labs cannot be both used at the same time "; 

			}
		}

	break;

	// 27 MAR 2021
	case 'editlabs':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$labtest = htmlspecialchars(isset($_POST['labtest']) ? $_POST['labtest'] : '');		
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($labtest) || empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{						
				// if(!empty($notes)){
				// 	$notes = strtoupper($notes);
				// }
				$lab = explode('@@@', $labtest);
				$labscode = $lab[0];
				$labsname = $lab[1];
				$sqlresults = $patientsInvestigationRequesttable->update_patientlabs($ekey,$labscode,$labsname,$notes,$currentusercode,$currentuser,$instcode);				
				$action = "lab Request edit successfully";							
				$result = $engine->getresults($sqlresults,$item=$labsname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=436;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			}
		}
	break;

	// 5 oct 2023, 27 MAR 2021
	case 'removelabs':
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey)  || empty($cancelreason) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
				$sqlresults = $patientsInvestigationRequesttable->update_removepatientlabs($ekey,$cancelreason,$currentusercode,$currentuser,$instcode);
				$action = "lab Request removed successfully";							
				$result = $engine->getresults($sqlresults,$item='',$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=435;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
			}
		}
	break;
	// 7 oct 2023,  22 NOV 2021 JOSEPH ADORBOE 
	case 'searchtreatmentplan':
		$treatmentplan = htmlspecialchars(isset($_POST['treatmentplan']) ? $_POST['treatmentplan'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($treatmentplan) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{	
				$freq = explode('@@@', $treatmentplan);
				$treatmentplancode = $freq[0];
				$treatmentplanname = $freq[1];
			}
		}
	break;
	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'labstreatmentplanrequest':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
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
                    foreach ($_POST["scheckbox"] as $key) {
                        $kt = explode('@@@', $key);
                        $labscode = $kt['0'];
                        $labsname = $kt['2'];
						$labpartnercode = $kt['3'];
                       	$form_key = md5(microtime()) ;
						$labrequestcode = $lov->getlabrequestcode($instcode);
						$cate = 'LABS';
						$type = 'OPD';
						$notes = 'NA';
						$sqlresults = $patientsInvestigationRequesttable ->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);
									
						$action = "lab Request successfully";							
						$result = $engine->getresults($sqlresults,$item=$labsname,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=434;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
                        }
                    }
                }
            }		
			
	break;
	// 7 oct 2023, 15 SEPT 2021
	case 'addpatientscans':
		$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');
		$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');
		$scans = isset($_POST['scans']) ? $_POST['scans'] : '';
		$newscans = htmlspecialchars(isset($_POST['newscans']) ? $_POST['newscans'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
		$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
		$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
		$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
		$plan = htmlspecialchars(isset($_POST['plan']) ? $_POST['plan'] : '');
		$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($scans) && empty($newscans) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($scans) && empty($newscans)){
				if(!empty($notes)){
					$notes = strtoupper($notes);
				}
				
				$type = 'OPD';
				$cate = 'IMAGING';
				foreach($scans as $key){
					$la = explode('@@@',$key);
					$labscode = $la[0];
					$labsname = $la[1];			
					$labrequestcode = rand(1,1000);
					$form_key = md5(microtime());
					$labpartnercode = 'NA';
				$sqlresults = $investigationcontroller->newlabrequest($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan,$patientsInvestigationRequesttable,$patientconsultationstable);
				
				$action = "Imaging Requested successfully";							
				$result = $engine->getresults($sqlresults,$item=$labsname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=433;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
			}				
		}else if(empty($scans) && !empty($newscans)){
	
			$type = 'OPD';
			$cate = 'SCANS';			
			$labrequestcode = rand(1,1000);
			$labcodenum =  rand(1,1000);
			$newscans = strtoupper($newscans);
			$labscode = md5(microtime());
			$newlabs = $newscans;
			$labpartnercode = 'NA';
			$sqlresults = $investigationcontroller->newlabrequest($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan,$patientsInvestigationRequesttable,$patientconsultationstable);
			
			$action = "Imaging Requested successfully";							
			$result = $engine->getresults($sqlresults,$item=$labsname,$action);
			$re = explode(',', $result);
			$status = $re[0];					
			$msg = $re[1];
			$event= "$action: $form_key $msg";
			$eventcode=433;
			$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
		}else if(!empty($scans) && !empty($newscans)){
			$status = "error";					
			$msg = "Imaging and New Imaging cannot be both used at the same time "; 
			}
		}
	break;



	
	
	// // 07 APR 2022 JOSEPH ADORBOE 
	// case 'editlabplanname':
	// 	$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
	// 	$labplanname = htmlspecialchars(isset($_POST['labplanname']) ? $_POST['labplanname'] : '');
	// 	$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
	// 	if($preventduplicate == '1'){
	// 		if(empty($ekey) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{	

	// 			$up = $investigationcontroller->update_editlabplanname($ekey,$labplanname,$notes,$currentusercode,$currentuser,$instcode);
	// 			if($up == '0'){				
	// 				$status = "error";					
	// 				$msg = "Edit Lab Plan $labplanname  Unsuccessful"; 
	// 			}else if($up == '1'){				
	// 				$status = "error";					
	// 				$msg = "Edit Lab Plan $labplanname Exist"; 					
	// 			}else if($up == '2'){
	// 				$event= "Edit Lab Plan $labplanname successfully ";
	// 				$eventcode= "123";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "Edit Lab Plan $labplanname Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}			
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source "; 					
	// 		}

	// 		}
	// 	}
	// break;


	

	

	

	

	
	
	
	

	

	

	// // 13 MAY 2021 JOSPH ADORBOE
	// case 'addmedicallabs':			
	// 	$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');		
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 	if($preventduplicate == '1'){
	// 		if(empty($labs) || empty($discpline) ){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{	
	// 			$dose = explode('@@@', $discpline);
	// 			$discplinecode = $dose[0];
	// 			$discplinename = $dose[1];				
	// 			$labsnumber = $setupcontroller->getlastlabcodenumber($instcode);
	// 			$labs = strtoupper($labs);
	// 			$partnercode = 'NA';
	// 			$add = $setupcontroller->addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode);
	// 			$title = 'Add Labs';
	// 			if($add == '0'){				
	// 				$status = "error";					
	// 				$msg = "".$title." ".$labs."  Unsuccessful"; 
	// 			}else if($add == '1'){				
	// 				$status = "error";					
	// 				$msg = "".$title." ".$labs."  Exist"; 					
	// 			}else if($add == '2'){
	// 				$event= "".$title."  ".$labs."  successfully ";
	// 				$eventcode= "45";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);	
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "".$title." ".$labs."  Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}			
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source "; 					
	// 			}	
	// 		}
	// 	}
	// break;
	
	// // 27 MAR 2021
	// case 'addnewlabs':
	// 	$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
	// 	$discpline = htmlspecialchars(isset($_POST['discpline']) ? $_POST['discpline'] : '');
	// 	$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
	// 	$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
	// 	$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
	// 	$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
	// 	if($preventduplicate == '1'){
	// 		if(empty($labs) || empty($discpline)){
	// 			$status = 'error';
	// 			$msg = 'Required Field Cannot be empty';				
	// 		}else{
	// 			// if(!empty($description)){
	// 			// 	$description = strtoupper($description);
	// 			// }
	// 			$dose = explode('@@@', $discpline);
	// 			$discplinecode = $dose[0];
	// 			$discplinename = $dose[1];				
	// 			$labsnumber = $setupcontroller->getlastlabcodenumber($instcode);
	// 			$labs = strtoupper($labs);
	// 			$partnercode = 'NA';
	// 			$addnew = $setupcontroller->addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode);
	// 			if($addnew == '0'){				
	// 				$status = "error";					
	// 				$msg = "Add New Labs ".$labs." Unsuccessful"; 
	// 			}else if($addnew == '1'){					
	// 				$status = "error";					
	// 				$msg = "New Labs ".$labs." Exist"; 						
	// 			}else if($addnew == '2'){
	// 				$event= "Add New Labs Added successfully ";
	// 				$eventcode= "126";
	// 				$audittrail = $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
	// 				if($audittrail == '2'){				
	// 					$status = "success";
	// 					$msg = "New Labs ".$labs." Added Successfully";
	// 				}else{
	// 					$status = "error";
	// 					$msg = "Audit Trail unsuccessful";	
	// 				}				
	// 		}else{				
	// 				$status = "error";					
	// 				$msg = "Unknown source ";					
	// 		}
	// 		}
	// 	}

	// break;			
		
}
 

?>
