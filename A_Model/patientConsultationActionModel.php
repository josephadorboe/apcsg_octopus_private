<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$consulationactionmodel = isset($_POST['consulationactionmodel']) ? $_POST['consulationactionmodel'] : '';
	$dept = 'OPD';

	Global $instcode;
	
	// 26 FEB 2022  
	switch ($consulationactionmodel)
	{

        // 27 JULY 2023
		case 'cancelconsulation':            
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$cancelreason = htmlspecialchars(isset($_POST['cancelreason']) ? $_POST['cancelreason'] : '');
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$physician = isset($_POST['physician']) ? $_POST['physician'] : '';	
            $idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';	
            $idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
            if ($preventduplicate == '1') {
                if (empty($consultationcode) || empty($cancelreason)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                    $actions = "consultationpatientaction?'.$idvalue";
                } else {                  
                         $action = 'Consultation Cancelled ';                         
                        $acts = $consultactionsql->cancelconsultation($consultationcode,$requestcode,$visitcode,$cancelreason,$patientcode,$patientnumber,$patient,$days,$currentusercode,$currentuser,$instcode);                        
                        if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action $action Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "No Patient action has been done ";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $consultactionsql->cancelconsultationfees($form_key,$consultationcode,$requestcode,$visitcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$patientcode,$patientnumber,$patient,$days,$day,$prepaidcode, $prepaid,$prepaidchemecode,$prepaidscheme,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient $action Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }                   
                }
            }
        break;
         // 19 NOV 2022 
		case 'reassignpatient':            
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$patientaction = isset($_POST['patientaction']) ? $_POST['patientaction'] : '';
			$patientdate = isset($_POST['patientdate']) ? $_POST['patientdate'] : '';
			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$physician = isset($_POST['physician']) ? $_POST['physician'] : '';	
            $idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';	
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
            if ($preventduplicate == '1') {
                if (empty($consultationcode) || empty($physician)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                    $actions = "consultationpatientaction?'.$idvalue";
                } else {                  
                         $action = 'Reassigned '; 
                        // $patientaction = 1;
                        $sp = explode('@@@', $physician);
							$physicancode = $sp['0'];
							$physicaname = $sp['1'];
                        $acts = $consultactionsql->reassignpatients($days,$physicancode,$physicaname,$consultationcode,$patientcode,$instcode);                        
                        if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action $action Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "No Patient action has been done ";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient $action Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }                   
                }
            }
        break;		
        // 28 AUG 2022 
		case 'endconsultation':            
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$patientaction = isset($_POST['patientaction']) ? $_POST['patientaction'] : '';
			$patientdate = isset($_POST['patientdate']) ? $_POST['patientdate'] : '';
			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';	
            $idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';	
            $servicerequestedcode =  isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] :'';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
            if ($preventduplicate == '1') {
                if (empty($patientcode)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                    $actions = "consultationpatientaction?'.$idvalue";
                } else {                  
                        $action = 'END CONSULTATION'; 
                        $patientaction = 1;
                        $acts = $consultactionsql->endconsultation($patientcode,$days,$visitcode,$consultationcode,$patientaction,$servicerequestedcode,$action,$currentusercode,$currentuser,$instcode);                        
                        if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action $action Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "No Patient action has been done ";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient $action Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }           
                }
            }
        break;        
        // 21 APR 2022 , 28 MAY 2021
		case 'patientsaction':
			$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
			$patientaction = isset($_POST['patientaction']) ? $_POST['patientaction'] : '';
			$patientdate = isset($_POST['patientdate']) ? $_POST['patientdate'] : '';
			$services = isset($_POST['services']) ? $_POST['services'] : '';
			$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
			$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
			$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
			$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
			$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
			$patientdeathdate = isset($_POST['patientdeathdate']) ? $_POST['patientdeathdate'] : '';
			$patientdeathtime = isset($_POST['patientdeathtime']) ? $_POST['patientdeathtime'] : '';
			$deathremarks = isset($_POST['deathremarks']) ? $_POST['deathremarks'] : '';
			$admissionnotes = isset($_POST['admissionnotes']) ? $_POST['admissionnotes'] : '';
			$triage = isset($_POST['triage']) ? $_POST['triage'] : '';
			$requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
			$age = isset($_POST['age']) ? $_POST['age'] : '';
			$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
			$paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';
			$paymentmethodcode = isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '';
			$schemecode = isset($_POST['schemecode']) ? $_POST['schemecode'] : '';
			$scheme = isset($_POST['scheme']) ? $_POST['scheme'] : '';
			$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
			$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
			$idvalue = isset($_POST['idvalue']) ? $_POST['idvalue'] : '';
			$consultationpaymenttype = isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '';
			$referalservices = isset($_POST['referalservices']) ? $_POST['referalservices'] : '';
			$physician = isset($_POST['physician']) ? $_POST['physician'] : '';
			$referaltype = isset($_POST['referaltype']) ? $_POST['referaltype'] : '';
			$detentiontypes = isset($_POST['detentiontypes']) ? $_POST['detentiontypes'] : '';
            $action = isset($_POST['action']) ? $_POST['action'] : '';
            $consultationnumber = isset($_POST['consultationnumber']) ? $_POST['consultationnumber'] : ''; 
            $currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : ''; 
            $currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';            
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
            if ($preventduplicate == '1') {
                if (empty($patientaction)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                } else {
                  $outcomenumber = $coder->getoutcomenumber($instcode);
                    // Discharge the patients only 
                    if ($patientaction == '10') {
                        $action = 'DISCHARGED'; 
                        $acts = $consultactionsql->update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks,$patientcode, $patientnumber, $patient,$day,$consultationnumber, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currentuser,$currentusercode,$servicerequestedcode,$servicerequested);  
                        
                        if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action $action Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "Patient Action $action Exist";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                            //    $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient $action Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }
                    }else if($patientaction == '20'){
                        if (empty($admissionnotes) ) {
                            $status = 'error';
                            $msg = 'Required Field Cannot be empty';
                            $actions = "consultationpatientaction?'.$idvalue";
                        } else {
                            $action = 'ADMISSION';
                            $admissionnotes = strtoupper($admissionnotes);                           
                            $admissionrequestcode = $lov->admissionrequestcode($instcode);    
                            $acts = $consultactionsql->update_patientaction_admission($patientcode, $patientnumber, $patient, $visitcode,$day,$consultationcode,$consultationnumber,$days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber);
                            
                            if ($acts == '0') {
                                $status = "error";
                                $msg = "Patient Action $action Unsuccessful";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '1') {
                                $status = "error";
                                $msg = "Patient Action $action Exist";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '2') {
                                $event= "Patient Action successfully ";
                                $eventcode= "149";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                               //     $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                    $status = "success";
                                    $msg = "Patient $patient $action Successfully";
                                    $actions = 'patientconsultationgp';
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail unsuccessful";
                                }
                            } else {
                                $status = "error";
                                $msg = "Unknown Source ";
                            }
                        }
                    } else if($patientaction == '30'){
                        if (empty($admissionnotes) || empty($detentiontypes) || empty($detentiontypes)) {
                            $status = 'error';
                            $msg = 'Required Field Cannot be empty';
                            $actions = "consultationpatientaction?'.$idvalue";
                        } else {
                            $action = 'DETAIN';
                            $dt = explode('@@@', $detentiontypes);
                            $dententioncode = $dt[0];
                            $dententionname = $dt[1];
                            $ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                            $detainserviceamount = $pricing->getprice($paymentmethodcode, $schemecode, $dententioncode, $instcode, $cashschemecode,$ptype,$instcodenuc);
                            $admissionnotes = strtoupper($admissionnotes);                           
                            $admissionrequestcode = $lov->admissionrequestcode($instcode);                   
                            $acts = $consultactionsql->update_patientaction_detain($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$dententioncode,$dententionname,$detainserviceamount,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$outcomenumber);
                            if ($acts == '0') {
                                $status = "error";
                                $msg = "Patient Action $action Unsuccessful";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '1') {
                                $status = "error";
                                $msg = "Patient Action $action Exist";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '2') {
                                $event= "Patient Action successfully ";
                                $eventcode= "149";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                //    $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                    $status = "success";
                                    $msg = "Patient $patient $action Successfully";
                                    $actions = 'patientconsultationgp';
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail unsuccessful";
                                }
                            } else {
                                $status = "error";
                                $msg = "Unknown Source ";
                            }
                        }
                    }else if($patientaction == '40'){
                        if (empty($referalservices) || empty($physician) || empty($referaltype) || empty($remarks) ) {
                            $status = 'error';
                            $msg = 'Required Field Cannot be empty';
							$actions = "consultationpatientaction?'.$idvalue";
                        } else {
                            $action = 'REFERAL';
								$sert = explode('@@@', $referalservices);
                                $servicecode = $sert[0];
                                $servicesed = $sert[1];
								$phy = explode('@@@', $physician);
                                $physiciancode = $phy[0];
                                $physicians = $phy[1];
								$consultationnumber = $lov->getconsultationrequestcode($instcode);
								$ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
								$referalserviceamount = $pricing->getprice($paymentmethodcode, $schemecode, $servicecode, $instcode, $cashschemecode,$ptype,$instcodenuc);
								$reviewnumber = $currenttable->getreviewrequestcode($instcode);
                            $acts = $referalsql->update_patientaction_referal($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $reviewnumber,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$servicerequestedcode,$servicerequested,$outcomenumber);
                            // update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber)
                            if ($acts == '0') {
                                $status = "error";
                                $msg = "Patient Action $action  Unsuccessful";
								$actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '1') {
                                $status = "error";
                                $msg = "Patient Action $action Exist";
								$actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '2') {
                                $event= "Patient Action successfully ";
                                $eventcode= "149";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                               //     $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                    $status = "success";
                                    $msg = "Patient $patient $action Successfully";
									$actions = 'patientconsultationgp';
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail unsuccessful";
                                }
                            } else {
                                $status = "error";
                                $msg = "Unknown Source ";
                            }
                        }                    
                    }else if($patientaction == '60'){
                        if (empty($patientdeathdate) || empty($patientdeathtime) || empty($deathremarks)) {
                            $status = 'error';
                            $msg = 'Required Field Cannot be empty';
                            $actions = "consultationpatientaction?'.$idvalue";
                        } else {
                            $action = 'DEATH';
                            $deathremarks = strtoupper($deathremarks);
                            if (!empty($patientdeathdate)) {
                                $cdate = explode('/', $patientdeathdate);
                                $mmd = $cdate[0];
                                $ddd = $cdate[1];
                                $yyy = $cdate[2];
                                $patientdeathdate = $yyy.'-'.$mmd.'-'.$ddd;
                                $servicecode = $servicesed = '';  
                                $deathrequestcode = $lov->getdeathrequestcode($instcode);                   
                            } else {
                                $servicecode = $servicesed = '';
                            }                           
                            $acts = $consultactionsql->update_patientaction_death($patientcode, $patientnumber, $patient, $visitcode, $consultationcode, $days, $patientaction, $action, $remarks, $patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode, $age,$gender,$currentusercode, $currentuser, $instcode,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$outcomenumber);
                            if ($acts == '0') {
                                $status = "error";
                                $msg = "Patient Action $action Unsuccessful";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '1') {
                                $status = "error";
                                $msg = "Patient Action $action Exist";
                                $actions = "consultationpatientaction?'.$idvalue";
                            } elseif ($acts == '2') {
                                $event= "Patient Action successfully ";
                                $eventcode= "149";
                                $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                //    $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                    $status = "success";
                                    $msg = "Patient $patient $action Successfully";
                                    $actions = 'patientconsultationgp';
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail unsuccessful";
                                }
                            } else {
                                $status = "error";
                                $msg = "Unknown Source ";
                            }
                        }
                    }else if($patientaction == '70'){                    
                    if (empty($patientdate) || empty($services) || empty($remarks)) {
                        $status = 'error';
                        $msg = 'Required Field Cannot be empty';
                        $actions = "consultationpatientaction?'.$idvalue";
                    } else {
                        $action = 'FOLLOWUP';
                        $remarks = strtoupper($remarks);
                        if (!empty($patientdate)) {
                            $cdate = explode('/', $patientdate);
                            $mmd = $cdate[0];
                            $ddd = $cdate[1];
                            $yyy = $cdate[2];
                            $patientdate = $yyy.'-'.$mmd.'-'.$ddd;
                            $requestcodecode = $currenttable->getreviewrequestcode($instcode);
                            $sert = explode('@@@', $services);
                            $servicecode = $sert[0];
                            $servicesed = $sert[1];
                       
                        } else {
                            $servicecode = $servicesed = '';
                        }
                        $acts = $consultactionsql->update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber);
                       if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action ".$action." Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "Patient Action ".$action." Exist";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                            //    $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient ".$action." Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }
                    }                   
                }else if($patientaction == '80'){                    
                    if (empty($patientdate) || empty($services) || empty($remarks)) {
                        $status = 'error';
                        $msg = 'Required Field Cannot be empty';
                        $actions = "consultationpatientaction?'.$idvalue";
                    } else {
                        $action = 'REVIEW';
                        $remarks = strtoupper($remarks);
                        if (!empty($patientdate)) {
                            $cdate = explode('/', $patientdate);
                            $mmd = $cdate[0];
                            $ddd = $cdate[1];
                            $yyy = $cdate[2];
                            $patientdate = $yyy.'-'.$mmd.'-'.$ddd;
                            $requestcodecode = $currenttable->getreviewrequestcode($instcode);
                            $sert = explode('@@@', $services);
                            $servicecode = $sert[0];
                            $servicesed = $sert[1];                       
                        } else {
                            $servicecode = $servicesed = '';
                        }
                        $acts = $consultactionsql->update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber);
                        if ($acts == '0') {
                            $status = "error";
                            $msg = "Patient Action ".$action." Unsuccessful";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '1') {
                            $status = "error";
                            $msg = "Patient Action ".$action." Exist";
                            $actions = "consultationpatientaction?'.$idvalue";
                        } elseif ($acts == '2') {
                            $event= "Patient Action successfully ";
                            $eventcode= "149";
                            $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                            //    $consultactionsql->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode);
                                $status = "success";
                                $msg = "Patient $patient ".$action." Successfully";
                                $actions = 'patientconsultationgp';
                            } else {
                                $status = "error";
                                $msg = "Audit Trail unsuccessful";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unknown Source ";
                        }
                    }
                    }                    
                }
            }
        break;           
	}	
?>