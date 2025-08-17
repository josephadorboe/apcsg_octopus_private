<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$reviewmodel = isset($_POST['reviewmodel']) ? $_POST['reviewmodel'] : '';
	$dept = 'OPD';

	Global $instcode;
	
	// 10 MAR 2022 JOSEPH ADORBOE
	switch ($reviewmodel)
	{

        // 18 MAY 2023 
	case 'addexternalreferal':
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$reviewdate = isset($_POST['reviewdate']) ? $_POST['reviewdate'] : '';
		$history = isset($_POST['history']) ? $_POST['history'] : '';
		$finding = isset($_POST['finding']) ? $_POST['finding'] : '';
		$provisionaldiagnosis = isset($_POST['provisionaldiagnosis']) ? $_POST['provisionaldiagnosis'] : '';
		$treatementgiven = isset($_POST['treatementgiven']) ? $_POST['treatementgiven'] : '';
		$reasonreferal = isset($_POST['reasonreferal']) ? $_POST['reasonreferal'] : '';
		$vitalscode = isset($_POST['vitalscode']) ? $_POST['vitalscode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
            if(empty($patientnumber) || empty($reviewdate) || empty($history) || empty($finding) || empty($provisionaldiagnosis) || empty($treatementgiven) || empty($reasonreferal) ){				
			
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
				if($patientnumbercheck == '-1'){
					$status = 'error';
					$msg = 'Invalid Patient number';
				}else{
                    $pt = explode('@@@', $patientnumbercheck);
                    $patientcode = $pt[0];
                    $patient = $pt[1];
                    $ag = $pt[2];
                    $gender = $pt[3];
                    $age = $pat->getpatientbirthage($ag);
					
                    $cdate = explode('-', $reviewdate);
                    $mmd = $cdate[1];
                    $ddd = $cdate[2];
                    $yyy = $cdate[0];
                    if (empty($mmd) || empty($ddd) || empty($yyy)) {
                        $status = 'error';
                        $msg = 'Invalid date format';
                    } else {
                        $reviewdate = $yyy.'-'.$mmd.'-'.$ddd;
						if($reviewdate<$day){
							$status = 'error';
                        	$msg = "$reviewdate is passed";
						}else{
                            $intro = "I will be most grateful if you would see this patient for further evaluation and management.";
				            $referalnumber = date("his");	
                            // $requestcodecode = $currenttable->getreviewrequestcode($instcode);
							// $se = explode('@@@', $services);
							// $secode = $se[0];
							// $sename = $se[1];
                            $consultationcode= $visitcode = 1;

                            $add = $consultationsql->insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
				$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);


                            // $add = $reviewsql->insert_reviewbookings($form_key, $requestcodecode, $patientcode, $patient, $patientnumber, $reviewdate, $reviewremark, $secode,$sename,$currentusercode, $currentuser,$currentday,$currentmonth,$currentyear, $instcode);
                            $title = 'New Review Date Added';
                            if ($add == '0') {
                                $status = "error";
                                $msg = " $title $requestcodecode  Unsuccessful";
                            } elseif ($add == '1') {
                                $status = "error";
                                $msg = " $title $requestcodecode  Exist";
                            } elseif ($add == '2') {
                                $event= " $title  Added successfully ";
                                $eventcode= "173";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "New Referal  $referalnumber  for patient $patient Added Successfully";
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
                }
			}
		}

	break;


    

		// 09 JULY 2021 JOSEPH ADORBOE  
	case 'editreviewbooking': 
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$reviewdate = isset($_POST['reviewdate']) ? $_POST['reviewdate'] : '';
		$reviewremark = isset($_POST['reviewremark']) ? $_POST['reviewremark'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$services = isset($_POST['services']) ? $_POST['services'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($patient) || empty($reviewdate) || empty($services) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
				$cdate = explode('-', $reviewdate);
                    $mmd = $cdate[1];
                    $ddd = $cdate[2];
                    $yyy = $cdate[0];
                    if (empty($mmd) || empty($ddd) || empty($yyy)) {
                        $status = 'error';
                        $msg = 'Invalid date format';
                    } else {
                        $reviewdate = $yyy.'-'.$mmd.'-'.$ddd;
						$se = explode('@@@', $services);
						$secode = $se[0];
						$sename = $se[1];
                        $edit = $reviewsql->editreviewbooking($ekey, $reviewremark, $reviewdate, $patientcode,$secode,$sename,$currentusercode, $currentuser, $instcode);
                        $title = 'Edit Review Booking';
                        if ($edit == '0') {
                            $status = "error";
                            $msg = "".$title." for ".$patient." Unsuccessful";
                        } elseif ($edit == '1') {
                            $status = "error";
                            $msg = "".$title." for ".$patient." Exist";
                        } elseif ($edit == '2') {
                            $event= " ".$title." ".$patient."  successfully ";
                            $eventcode= "175";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = " ".$title." ".$patient." Successfully";
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unsuccessful source ";
                        }
                    }
			}
		}

	break;

	// 09 JULY 2021 JOSEPH ADORBOE  
	case 'cancelreviewbooking': 
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($patient) || empty($requestcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
                if (empty($mmd) || empty($ddd) || empty($yyy)) {
                    $status = 'error';
                    $msg = 'Invalid date format';
                } else {
					
                    $edit = $reviewsql->cancelreviewbooking($ekey, $patientcode,$currentusercode, $currentuser, $instcode);
                    $title = 'Cancel Review Booking';
                    if ($edit == '0') {
                        $status = "error";
                        $msg = "".$title." for ".$patient." Unsuccessful";
                    } elseif ($edit == '1') {
                        $status = "error";
                        $msg = "".$title." for ".$patient." Exist";
                    } elseif ($edit == '2') {
                        $event= " ".$title." ".$patient."  successfully ";
                        $eventcode= "174";
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = " ".$title." ".$patient." Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail unsuccessful";
                        }
                    } else {
                        $status = "error";
                        $msg = "Unsuccessful source ";
                    }
                }
            }
		}

	break;



	// 09 JULY  2021
	case 'addreviewbookings':
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$reviewdate = isset($_POST['reviewdate']) ? $_POST['reviewdate'] : '';
		$reviewremark = isset($_POST['reviewremark']) ? $_POST['reviewremark'] : '';
		$services = isset($_POST['services']) ? $_POST['services'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($patientnumber) || empty($reviewdate) || empty($services)  ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$patientnumbercheck = $msql->getpatientdetails($patientnumber,$instcode);
				if($patientnumbercheck == '-1'){
					$status = 'error';
					$msg = 'Invalid Patient number';
				}else{
                    $pt = explode('@@@', $patientnumbercheck);
                    $patientcode = $pt[0];
                    $patient = $pt[1];
					
                    $cdate = explode('-', $reviewdate);
                    $mmd = $cdate[1];
                    $ddd = $cdate[2];
                    $yyy = $cdate[0];
                    if (empty($mmd) || empty($ddd) || empty($yyy)) {
                        $status = 'error';
                        $msg = 'Invalid date format';
                    } else {
                        $reviewdate = $yyy.'-'.$mmd.'-'.$ddd;
						if($reviewdate<$day){
							$status = 'error';
                        	$msg = "$reviewdate is passed";
						}else{
                            $requestcodecode = $currenttable->getreviewrequestcode($instcode);
							$se = explode('@@@', $services);
							$secode = $se[0];
							$sename = $se[1];

                            $add = $reviewsql->insert_reviewbookings($form_key, $requestcodecode, $patientcode, $patient, $patientnumber, $reviewdate, $reviewremark, $secode,$sename,$currentusercode, $currentuser,$currentday,$currentmonth,$currentyear, $instcode);
                            $title = 'New Review Date Added';
                            if ($add == '0') {
                                $status = "error";
                                $msg = " $title $requestcodecode  Unsuccessful";
                            } elseif ($add == '1') {
                                $status = "error";
                                $msg = " $title $requestcodecode  Exist";
                            } elseif ($add == '2') {
                                $event= " $title  Added successfully ";
                                $eventcode= "173";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "New Review Request  $requestcodecode  for patient $patient Added Successfully";
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
                }
			}
		}

	break;


    }
	
?>
