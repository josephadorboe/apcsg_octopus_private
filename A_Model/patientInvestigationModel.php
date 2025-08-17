<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
		
	$investigationmodel = isset($_POST['investigationmodel']) ? $_POST['investigationmodel'] : '';
	
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
	// 07 APR 2022 JOSEPH ADORBOE 
	case 'editlabplanname':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$labplanname = isset($_POST['labplanname']) ? $_POST['labplanname'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{	

				$up = $investigationsql->update_editlabplanname($ekey,$labplanname,$notes,$currentusercode,$currentuser,$instcode);
				if($up == '0'){				
					$status = "error";					
					$msg = "Edit Lab Plan $labplanname  Unsuccessful"; 
				}else if($up == '1'){				
					$status = "error";					
					$msg = "Edit Lab Plan $labplanname Exist"; 					
				}else if($up == '2'){
					$event= "Edit Lab Plan $labplanname successfully ";
					$eventcode= "123";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Edit Lab Plan $labplanname Successfully";
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


	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'labstreatmentplanrequest':		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
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
						$addlabs = $investigationsql->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);			
							$title = 'Lab Request';
                            if ($addlabs == '1') {
                                $status = "error";
                                $msg = "$title Already Selected";
                            } elseif ($addlabs == '2') {
                                $event= "$title $patient for  has been saved successfully ";
                                $eventcode= 151;
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "$title Successfully";
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail Failed!";
                                }
                            } elseif ($addlabs == '0') {
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
			
	break;

	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'searchtreatmentplan':
		$treatmentplan = isset($_POST['treatmentplan']) ? $_POST['treatmentplan'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
	case 'removelabsfromplan':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$labstest = isset($_POST['labstest']) ? $_POST['labstest'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
				$remove = $investigationsql->update_removelabsfromplans($ekey,$currentusercode,$currentuser,$instcode);				
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Patient Labs".$labstest." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove patient Labs".$labstest." Exist"; 					
				}else if($remove == '2'){
					$event= "Patient Labs Remove successfully ";
					$eventcode= "123";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Labs ".$labstest." Removed Successfully";
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

	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'addnewlabstoplans': 
		$plancode = isset($_POST['plancode']) ? $_POST['plancode'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($plancode) || empty($plan)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
						foreach ($_POST["scheckbox"] as $plandetails) {
							$lpdet = explode('@@@', $plandetails);
							$lapcode = $lpdet['0'];
							$lapnum = $lpdet['1'];
							$lapname = $lpdet['2'];
							$lapcodenum = $lpdet['3'];
							$form_key = md5(microtime());
							$labplans = $investigationsql->insert_labstoplan($form_key,$plancode,$plan,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode);
									
							if ($labplans == '0') {
								$status = "error";
								$msg = "Add  Unsuccessful";
							} elseif ($labplans == '1') {
								$status = "error";
								$msg = "Lab Plan Exist Already";
							} elseif ($labplans == '2') {
								$event= " Add Lab Plans ".$lapname." has been saved successfully ";
								$eventcode= 189;
								$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
								if ($audittrail == '2') {
									$status = "success";
									$msg = "Lab Plan for $lapname Added Successfully";
								} else {
									$status = "error";
									$msg = "Audit Trail Failed!";
								}
							} else {
								$status = "error";
								$msg = "Unknown Source";
							}
						}					
			}
		}
	break;

	// 23 JAN 2022  JOSEPH ADORBOE labsplans
	case 'addnewlabsplans': 
		$labsplans = isset($_POST['labsplans']) ? $_POST['labsplans'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($labsplans) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					$lapplancode = md5(microtime());
					$labplannumber = $lov->getlabplannumber($instcode);	
					$lp = $investigationsql->newlabplans($lapplancode,$labsplans,$labplannumber,$description,$days,$category,$currentusercode,$currentuser,$instcode);
					if($lp == 2){
						foreach ($_POST["scheckbox"] as $plandetails) {
							$lpdet = explode('@@@', $plandetails);
							$lapcode = $lpdet['0'];
							$lapnum = $lpdet['1'];
							$lapname = $lpdet['2'];
							$lapcodenum = $lpdet['3'];
							$form_key = md5(microtime());
							$labplans = $investigationsql->insert_labsplanlist($form_key,$lapplancode,$labsplans,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode);
									
							if ($labplans == '0') {
								$status = "error";
								$msg = "Add  Unsuccessful";
							} elseif ($labplans == '1') {
								$status = "error";
								$msg = "Lab Plan Exist Already";
							} elseif ($labplans == '2') {
								$event= " Add Lab Plans $labsplans has been saved successfully ";
								$eventcode= 180;
								$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
								if ($audittrail == '2') {
									$status = "success";
									$msg = "Lab Plan for $labsplans Added Successfully";
								} else {
									$status = "error";
									$msg = "Audit Trail Failed!";
								}
							} else {
								$status = "error";
								$msg = "Unknown Source";
							}
						}
					}else {
						$status = "error";
						$msg = "Unknown Source";
					}
			}
		}
	break;
	
	// 15 SEPT 2021
	case 'addpatientscans':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$scans = isset($_POST['scans']) ? $_POST['scans'] : '';
		$newscans = isset($_POST['newscans']) ? $_POST['newscans'] : '';
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
				$lab = explode('@@@', $scans);
				$labscode = $lab[0];
				$labsname = $lab[1];
			//	$labpartnercode = $lab[2];
				$labpartnercode = 1;
				$labrequestcode = $lov->getlabrequestcode($instcode);

				$addlabs = $investigationsql->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);
				$title = 'Add Patient Imaging';
				if($addlabs == '0'){				
					$status = "error";					
					$msg = "$title $labsname Unsuccessful"; 
				}else if($addlabs == '1'){						
					$status = "error";					
					$msg = "$title $labsname Exist";					
				}else if($addlabs == '2'){
					$event= "$title successfully ";
					$eventcode= "125";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){	
					//	$investigationsql->chargereportfees($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$reportfees,$cate,$notes,$type,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode);			
						$status = "success";
						$msg = "$title $labsname added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

		}else if(empty($scans) && !empty($newscans)){

			// if(!empty($notes)){
			// 	$notes = strtoupper($notes);
			// }			
			$type = 'OPD';
			$cate = 'SCANS';			
			$labrequestcode = $lov->getlabrequestcode($instcode);
			$labcodenum = $lov->getlabcode($instcode);
			$newscans = strtoupper($newscans);
			$labscode = md5(microtime());
			$newlabs = $newscans;
			$addlabs = $investigationsql->insert_patientaddscans($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labcodenum,$labscode,$newlabs,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$plan);
			$title = 'Add Patient Imaging';
			if($addlabs == '0'){				
				$status = "error";					
				$msg = " $title $newlabs  Unsuccessful"; 
			}else if($addlabs == '1'){						
				$status = "error";					
				$msg = " $title $newlabs  Exist";					
			}else if($addlabs == '2'){
				$event= "$title successfully ";
				$eventcode= "125";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){				
					$status = "success";
					$msg = "$title $newlabs added Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}
		}else if(!empty($scans) && !empty($newscans)){
			$status = "error";					
			$msg = "Labs and New labs cannot be both used at the same time "; 
			}
		}
	break;
	// 27 MAR 2021
	case 'addpatientlabs':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
		$newlabs = isset($_POST['newlabs']) ? $_POST['newlabs'] : '';		
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
		$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
		$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
		$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($labs) && empty($newlabs) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else if(!empty($labs) && empty($newlabs)){

				// if(!empty($notes)){
				// 	$notes = strtoupper($notes);
				// }				
				$type = 'OPD';
				$cate = 'LABS';
				$lab = explode('@@@', $labs);
				$labscode = $lab[0];
				$labsname = $lab[1];
				$labpartnercode = $lab[2];
				$labrequestcode = $lov->getlabrequestcode($instcode);
				$addlabs = $investigationsql->insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan);
				$title = 'Add Patient Labs';
				if($addlabs == '0'){				
					$status = "error";					
					$msg = "$title $labsname  Unsuccessful"; 
				}else if($addlabs == '1'){						
					$status = "error";					
					$msg = "$title $labsname  Exist";					
				}else if($addlabs == '2'){
					$event= "".$title." successfully ";
					$eventcode= "125";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "$title $labsname added Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}				
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

		}else if(empty($labs) && !empty($newlabs)){

			// if(!empty($notes)){
			// 	$notes = strtoupper($notes);
			// }			
			$type = 'OPD';
			$cate = 'LABS';			
			$labrequestcode = $lov->getlabrequestcode($instcode);
			$labcodenum = $lov->getlabcode($instcode);
			$newlabs = strtoupper($newlabs);
			$labscode = md5(microtime());
			$addlabs = $investigationsql->insert_patientaddlabs($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labcodenum,$labscode,$newlabs,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$plan);
			$title = 'Add Patient Labs';
			if($addlabs == '0'){				
				$status = "error";					
				$msg = "$title $newlabs  Unsuccessful"; 
			}else if($addlabs == '1'){						
				$status = "error";					
				$msg = "$title $newlabs  Exist";					
			}else if($addlabs == '2'){
				$event= "$title successfully ";
				$eventcode= "125";
				$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
				if($audittrail == '2'){				
					$status = "success";
					$msg = "$title $newlabs added Successfully";
				}else{
					$status = "error";
					$msg = "Audit Trail unsuccessful";	
				}				
		}else{				
				$status = "error";					
				$msg = "Unknown source "; 					
		}

		}else if(!empty($labs) && !empty($newlabs)){
			$status = "error";					
			$msg = "Labs and New labs cannot be both used at the same time "; 

			}
		}

	break;

	// 27 MAR 2021
	case 'editlabs':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$labtest = isset($_POST['labtest']) ? $_POST['labtest'] : '';		
		$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
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
				$edit = $investigationsql->update_patientlabs($ekey,$labscode,$labsname,$notes,$currentusercode,$currentuser,$instcode);				
				if($edit == '0'){				
					$status = "error";					
					$msg = "Edit Patient Labs ".$labsname." Unsuccessful"; 
				}else if($edit == '1'){				
					$status = "error";					
					$msg = "Edit Patient Labs ".$labsname." Exist"; 					
				}else if($edit == '2'){
					$event= "Patient Labs Edited successfully ";
					$eventcode= "124";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){			
						$status = "success";
						$msg = "Patient Labs ".$labsname." edited Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source"; 					
			}

			}
		}

	break;

	// 27 MAR 2021
	case 'removelabs':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$cancelreason = isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{					
				$remove = $investigationsql->update_removepatientlabs($ekey,$cancelreason,$currentusercode,$currentuser,$instcode);
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Patient Labs $patient Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove patient Labs $patient Exist"; 					
				}else if($remove == '2'){
					$event= "Patient Labs Remove successfully ";
					$eventcode= "123";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Patient Labs $patient Removed Successfully";
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
	case 'addmedicallabs':			
		$labs = isset($_POST['labs']) ? $_POST['labs'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($labs) || empty($discpline) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{	
				$dose = explode('@@@', $discpline);
				$discplinecode = $dose[0];
				$discplinename = $dose[1];				
				$labsnumber = $setupsql->getlastlabcodenumber($instcode);
				$labs = strtoupper($labs);
				$partnercode = 'NA';
				$add = $setupsql->addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode);
				$title = 'Add Labs';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." ".$labs."  Unsuccessful"; 
				}else if($add == '1'){				
					$status = "error";					
					$msg = "".$title." ".$labs."  Exist"; 					
				}else if($add == '2'){
					$event= "".$title."  ".$labs."  successfully ";
					$eventcode= "45";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$labs."  Successfully";
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
	
	// 27 MAR 2021
	case 'addnewlabs':
		$labs = isset($_POST['labs']) ? $_POST['labs'] : '';
		$discpline = isset($_POST['discpline']) ? $_POST['discpline'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($labs) || empty($discpline)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				// if(!empty($description)){
				// 	$description = strtoupper($description);
				// }
				$dose = explode('@@@', $discpline);
				$discplinecode = $dose[0];
				$discplinename = $dose[1];				
				$labsnumber = $setupsql->getlastlabcodenumber($instcode);
				$labs = strtoupper($labs);
				$partnercode = 'NA';
				$addnew = $setupsql->addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode);
				if($addnew == '0'){				
					$status = "error";					
					$msg = "Add New Labs ".$labs." Unsuccessful"; 
				}else if($addnew == '1'){					
					$status = "error";					
					$msg = "New Labs ".$labs." Exist"; 						
				}else if($addnew == '2'){
					$event= "Add New Labs Added successfully ";
					$eventcode= "126";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "New Labs ".$labs." Added Successfully";
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
		
}
 

?>
