<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$walkinmodel =htmlspecialchars(isset($_POST['walkinmodel']) ? $_POST['walkinmodel'] : '');
	
	
	// 12 MAR 2022
switch ($walkinmodel)
{
	// 31 July 2024, JOSEPH ADORBOE 
	case 'patientwalkininvestigationsearch': 	
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
					$url = "patientwalkininvestigations?$form_key";
					$engine->redirect($url);
					}
				}
		}
	break;
	// 31 July 2024, 12 MARCH 2022  JOSEPH ADORBOE 
	case 'walkininvestigations':
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$currentvisitcode = htmlspecialchars(isset($_POST['currentvisitcode']) ? $_POST['currentvisitcode'] : '');
		$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
		$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($patientcode) || empty($currentvisitcode) || empty($labs) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
				$lb = explode('@@@', $labs);
				$labscode = $lb[0];
				$labsname = $lb[1];
				$labpartnercode = $lb[2];				   
				$notes = strtoupper($notes);
				$labrequestcode = rand(1,100).date('His');				
				$type = 'WALK IN';
				$sqlresults = $patientsInvestigationRequesttable->insert_labswalkin($form_key,$labrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$labscode,$labsname,$labpartnercode,$notes,$type,$category,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$currentusercode,$currentuser,$instcode);
				$action = "New Investigation Request";							
				$result = $engine->getresults($sqlresults,$item=$labsname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=9798;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
			}
		}
	break;

	// 15 AUG 2022   JOSEPH ADORBOE 
	case 'addbulklabs': 
		$patientcode =htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patient =htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patientnumber =htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$currentvisitcode =htmlspecialchars(isset($_POST['currentvisitcode']) ? $_POST['currentvisitcode'] : '');
		$labs = htmlspecialchars(isset($_POST['labs']) ? $_POST['labs'] : '');
		$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$notes = htmlspecialchars(isset($_POST['notes']) ? $_POST['notes'] : '');
		$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');	
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($patientcode) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					foreach ($_POST["scheckbox"] as $plandetails) {
						$lb = explode('@@@', $plandetails);
						$labscode = $lb[0];
						$labsnum = $lb[1];
						$labsname = $lb[2];
						$labpartnercode = $lb[3];				   
						$notes = 'WALK IN' ;
						$labrequestcode = rand(1,100).date('His');		
						$type = 'WALK IN';
						$form_key = md5(microtime());	
						$sqlresults = $patientsInvestigationRequesttable->insert_labswalkin($form_key,$labrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$labscode,$labsname,$labpartnercode,$notes,$type,$category,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$currentusercode,$currentuser,$instcode);
						$action = "New Lab Request";							
						$result = $engine->getresults($sqlresults,$item=$labsname,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9798;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
									
					}					
			}
		}
	break;

	
	// 30 JULY 2021 JOSEPH ADORBOE 
	case 'walkindevices':
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$currentvisitcode = htmlspecialchars(isset($_POST['currentvisitcode']) ? $_POST['currentvisitcode'] : '');
		$devices = htmlspecialchars(isset($_POST['devices']) ? $_POST['devices'] : '');
		$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$physician = htmlspecialchars(isset($_POST['physician']) ? $_POST['physician'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($patientcode) || empty($quantity) || empty($currentvisitcode) || empty($devices) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				
                    $med = explode('@@@', $devices);
                    $devicecode = $med[0];
                    $devicename = $med[1];	
					
					$sp = explode('@@@', $physician);
					$phycode = $sp['0'];
					$phyname = $sp['1'];
					
                        $walkinrequestcode = $lov->getpatientdevicerequestcode($instcode);
                        $add = $walkinsql->insert_deviceswalkin($form_key,$walkinrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$days,$day,$devicecode,$devicename,$quantity,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$phycode,$phyname,$currentusercode,$currentuser,$instcode);
                        $title = 'New walk in Added';
                        if ($add == '0') {
                            $status = "error";
                            $msg = " $title $walkinrequestcode  Unsuccessful";
                        } elseif ($add == '1') {
                            $status = "error";
                            $msg = " $title $walkinrequestcode  Exist";
                        } elseif ($add == '2') {
                            $event= " $title  Added successfully ";
                            $eventcode= "178";
                            $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = "New walk in Request $walkinrequestcode  for patient $patient  Added Successfully";
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

	// 31 JULY 2021 JOSEPH ADORBOE 
	case 'addnewwalkin':
		$patientname = htmlspecialchars(isset($_POST['patientname']) ? $_POST['patientname'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$phonenumber = htmlspecialchars(isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($patientname) || empty($gender) || empty($phonenumber) || empty($age) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				                  
					$walkinpatientnumber = $lov->getwalkinpatientnumber($instcode);
					$patientcode = md5(microtime());
					$patientname = strtoupper($patientname);
					$add = $walkinsql->insert_addnewwalkinpatient($form_key,$patientcode,$patientname,$walkinpatientnumber,$gender,$age,$days,$day,$phonenumber,$currentusercode,$currentuser,$instcode);
					$title = 'New walk in Patient Added';
					if ($add == '0') {
						$status = "error";
						$msg = "$title $walkinpatientnumber Unsuccessful";
					} elseif ($add == '1') {
						$status = "success";
						$msg = " $title $walkinpatientnumber  Exist";
						$value = $phonenumber;
						$msql->passingvalues($pkey=$form_key,$value);					
						$url = "walkinnonpatients?$form_key";
						$engine->redirect($url);
					} elseif ($add == '2') {
						$event= " $title  Added successfully ";
						$eventcode= "178";
						$audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
						if ($audittrail == '2') {
							$status = "success";
							$msg = "New walk in Patient  $walkinpatientnumber  for patient $patientname Added Successfully";
							$value = $phonenumber;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "walkinnonpatients?$form_key";
							$engine->redirect($url);
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

	// 31 JULY 2021
	case 'walkinnonpatient': 
		
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
					$url = "walkinnonpatients?$form_key";
					$engine->redirect($url);
				}
			}
		}

	break;

	// 26 JULY 2021
	case 'walkin': 
		
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
					$url = "walkinrecords?$form_key";
					$engine->redirect($url);
				}
			}
		}

	break;

	// 29 JULY 2021 JOSEPH ADORBOE 
	case 'walkinmedications':
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$currentvisitcode = htmlspecialchars(isset($_POST['currentvisitcode']) ? $_POST['currentvisitcode'] : '');
		$medication = htmlspecialchars(isset($_POST['medication']) ? $_POST['medication'] : '');
		$quantity = htmlspecialchars(isset($_POST['quantity']) ? $_POST['quantity'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$physician = htmlspecialchars(isset($_POST['physician']) ? $_POST['physician'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($patientcode) || empty($quantity) || empty($currentvisitcode) || empty($medication) || empty($physician) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				
                    $med = explode('@@@', $medication);
                    $medicationcode = $med[0];
                    $medicationname = $med[1];
					$dosagecode = $med[2];
					$dosage = $med[3];
					$medicationnumber = $med[4];   
					
					$sp = explode('@@@', $physician);
					$phycode = $sp['0'];
					$phyname = $sp['1'];
					
                        $walkinrequestcode = $lov->getprescriptionrequestcode($instcode);
                        $add = $walkinsql->insert_mediationwalkin($form_key, $walkinrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$days,$day,$medicationcode,$medicationname,$dosagecode,$dosage,$medicationnumber,$quantity,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$phycode,$phyname,$currentusercode,$currentuser,$instcode);
                        $title = 'New walk in Added';
                        if ($add == '0') {
                            $status = "error";
                            $msg = "$title $walkinrequestcode Unsuccessful";
                        } elseif ($add == '1') {
                            $status = "error";
                            $msg = "$title $walkinrequestcode Exist";
                        } elseif ($add == '2') {
                            $event= "$title Added successfully ";
                            $eventcode= "177";
                            $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = "New walk in Request $walkinrequestcode for patient  $patient Added Successfully";
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

}


?>
