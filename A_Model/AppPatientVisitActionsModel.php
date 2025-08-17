<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$visitactionmodel = htmlspecialchars(isset($_POST['visitactionmodel']) ? $_POST['visitactionmodel'] : '');
	$dept = 'OPD';

	Global $instcode;
	
	// 26 FEB 2022  
	switch ($visitactionmodel)
	{

        // 9 AUG 2024, 24 oct 2023, 21 APR 2022 , 28 MAY 2021
		case 'pastpatientsaction':
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$patientaction = htmlspecialchars(isset($_POST['patientaction']) ? $_POST['patientaction'] : '');
			$patientdate = htmlspecialchars(isset($_POST['patientdate']) ? $_POST['patientdate'] : '');
			$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
			$patientdeathdate = htmlspecialchars(isset($_POST['patientdeathdate']) ? $_POST['patientdeathdate'] : '');
			$patientdeathtime = htmlspecialchars(isset($_POST['patientdeathtime']) ? $_POST['patientdeathtime'] : '');
			$deathremarks = htmlspecialchars(isset($_POST['deathremarks']) ? $_POST['deathremarks'] : '');
			$admissionnotes = htmlspecialchars(isset($_POST['admissionnotes']) ? $_POST['admissionnotes'] : '');
			$triage = htmlspecialchars(isset($_POST['triage']) ? $_POST['triage'] : '');
			$requestcode = htmlspecialchars(isset($_POST['requestcode']) ? $_POST['requestcode'] : '');
			$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
			$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
			$paymentmethod = htmlspecialchars(isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '');
			$paymentmethodcode = htmlspecialchars(isset($_POST['paymentmethodcode']) ? $_POST['paymentmethodcode'] : '');
			$schemecode = htmlspecialchars(isset($_POST['schemecode']) ? $_POST['schemecode'] : '');
			$scheme = htmlspecialchars(isset($_POST['scheme']) ? $_POST['scheme'] : '');
			$servicerequestedcode = htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '');
			$servicerequested = htmlspecialchars(isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '');
			$idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');
			$consultationpaymenttype = htmlspecialchars(isset($_POST['consultationpaymenttype']) ? $_POST['consultationpaymenttype'] : '');
			$referalservices = htmlspecialchars(isset($_POST['referalservices']) ? $_POST['referalservices'] : '');
			$physician = htmlspecialchars(isset($_POST['physician']) ? $_POST['physician'] : '');
			$referaltype = htmlspecialchars(isset($_POST['referaltype']) ? $_POST['referaltype'] : '');
			$detentiontypes = htmlspecialchars(isset($_POST['detentiontypes']) ? $_POST['detentiontypes'] : '');
            $action = htmlspecialchars(isset($_POST['action']) ? $_POST['action'] : '');
            $consultationnumber = htmlspecialchars(isset($_POST['consultationnumber']) ? $_POST['consultationnumber'] : ''); 
            $currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : ''); 
            $currentshift = htmlspecialchars(isset($_POST['currentshift']) ? $_POST['currentshift'] : '');            
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
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
                        $sqlresults = $visitactioncontroller->update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks,$patientcode, $patientnumber, $patient,$day,$consultationnumber, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currentuser,$currentusercode,$servicerequestedcode,$servicerequested,$outcometable);  
                        $action = "Patient Discharged";
                        $actions = "consultationpatientaction?'.$idvalue";
                            if($sqlresults == '2'){
                            //    $actions = 'patientconsultationgp';
                                $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            }else{
                            //    $actions = "consultationpatientaction?'.$idvalue";
                            }                       
                            $result = $engine->getresults($sqlresults,$item=$patient,$action);
                            $re = explode(',', $result);
                            $status = $re[0];					
                            $msg = $re[1];
                            $event= "$action: $form_key $msg";
                            $eventcode=9795;
                            $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                      
                        
                    }else if($patientaction == '20'){
                        if (empty($admissionnotes) ) {
                            $status = 'error';
                            $msg = 'Required Field Cannot be empty';
                            $actions = "consultationpatientaction?'.$idvalue";
                        } else {
                            $action = 'ADMISSION';
                            $admissionnotes = strtoupper($admissionnotes);                           
                        //    $admissionrequestcode = $lov->admissionrequestcode($instcode); 
                            $admissionrequestcode = rand(100,100000);     
                            $sqlresults = $visitactioncontroller->update_patientaction_admission($patientcode, $patientnumber, $patient, $visitcode,$day,$consultationcode,$consultationnumber,$days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currenttable,$outcometable,$patientsadmissiontable,$admissionsarchivetable);
                            $action = "Patient Admited";
                            $actions = "consultationpatientaction?'.$idvalue";
                            if($sqlresults == '2'){
                            //    $actions = 'patientconsultationgp';
                                $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            }else{
                            //    $actions = "consultationpatientaction?'.$idvalue";
                            }                       
                            $result = $engine->getresults($sqlresults,$item=$patient,$action);
                            $re = explode(',', $result);
                            $status = $re[0];					
                            $msg = $re[1];
                            $event= "$action: $form_key $msg";
                            $eventcode=9794;
                            $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                            
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
                            $detainserviceamount = $pricingtable->getprice($paymentmethodcode, $schemecode, $dententioncode, $instcode, $cashschemecode,$ptype,$instcodenuc);
                            $admissionnotes = strtoupper($admissionnotes);                           
                            $admissionrequestcode = rand(100,100000);                 
                            $sqlresults = $visitactioncontroller->update_patientaction_detain($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$dententioncode,$dententionname,$detainserviceamount,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$outcomenumber,$outcometable,$patientsadmissiontable,$admissionsarchivetable);
                            $action = "Patient Detain";
                            if($sqlresults == '2'){
                             //   $actions = 'patientconsultationgp';
                                $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            }else{
                                $actions = "consultationpatientaction?'.$idvalue";
                            }                       
                            $result = $engine->getresults($sqlresults,$item=$patient,$action);
                            $re = explode(',', $result);
                            $status = $re[0];					
                            $msg = $re[1];
                            $event= "$action: $form_key $msg";
                            $eventcode=9793;
                            $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  
                          
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
                            $referalserviceamount = $pricingtable->getprice($paymentmethodcode, $schemecode, $servicecode, $instcode, $cashschemecode,$ptype,$instcodenuc);
                            $reviewnumber = rand(100,10000);
                            $sqlresults =  $visitactioncontroller->update_patientaction_internalreferals($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$servicerequestedcode,$servicerequested,$outcomenumber,$currenttable,$patientconsultationstable,$patientconsultationsarchivetable,$outcometable,$patientsServiceRequesttable,$serialtable,$patientbillingtable,$patientreferaltable);

                            // $sqlresults = $actionreferalcontroller->update_patientaction_referal($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $reviewnumber,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$servicerequestedcode,$servicerequested,$outcomenumber,$reviewcontroller,$currenttable,$patientsql);
                            $action = "Patient Referal";
                            $actions = "consultationpatientaction?'.$idvalue";
                            if($sqlresults == '2'){
                            //    $actions = 'patientconsultationgp';
                                $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            }else{
                                $actions = "consultationpatientaction?'.$idvalue";
                            }                       
                            $result = $engine->getresults($sqlresults,$item=$patient,$action);
                            $re = explode(',', $result);
                            $status = $re[0];					
                            $msg = $re[1];
                            $event= "$action: $form_key $msg";
                            $eventcode=9792;
                            $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                            
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
                            $sqlresults = $visitactioncontroller->update_patientaction_death($patientcode, $patientnumber, $patient, $visitcode, $consultationcode, $days, $patientaction, $action, $remarks, $patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode, $age,$gender,$currentusercode, $currentuser, $instcode,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$outcomenumber,$outcometable,$patientdeathtable,$patienttable);
                            $action = "Patient Death";
                            if($sqlresults == '2'){
                                $actions = 'patientconsultationgp';
                                $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            }else{
                                $actions = "consultationpatientaction?'.$idvalue";
                            }                       
                            $result = $engine->getresults($sqlresults,$item=$patient,$action);
                            $re = explode(',', $result);
                            $status = $re[0];					
                            $msg = $re[1];
                            $event= "$action: $form_key $msg";
                            $eventcode=9791;
                            $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);  
                          
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
                        $sqlresults = $visitactioncontroller->update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber,$outcometable,$reviewcontroller,$patientreviewtable,$currenttable,$patienttable);
                        $action = "Follow Up";
                        if($sqlresults == '2'){
                            $actions = 'patientconsultationgp';
                            $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                        }else{
                            $actions = "consultationpatientaction?'.$idvalue";
                        }                       
                        $result = $engine->getresults($sqlresults,$item=$patient,$action);
                        $re = explode(',', $result);
                        $status = $re[0];					
                        $msg = $re[1];
                        $event= "$action: $form_key $msg";
                        $eventcode=9790;
                        $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                    
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
                        //    $requestcodecode = $currenttable->getreviewrequestcode($instcode);
                            $requestcodecode = rand(1,10000);
                            $sert = explode('@@@', $services);
                            $servicecode = $sert[0];
                            $servicesed = $sert[1];                       
                        } else {
                            $servicecode = $servicesed = '';
                        }

                        $sqlresults = $visitactioncontroller->update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber,$outcometable,$patientreviewtable,$patienttable);
                    //    $sqlresults = $reviewcontroller->editreviewbooking($ekey, $reviewremark, $reviewdate, $patientcode,$secode,$sename,$currentusercode, $currentuser, $instcode,$patientsql); 
                        $action = "Review";
                        $actions = "consultationpatientaction?'.$idvalue";
                        if($sqlresults == '2'){
                        //    $actions = 'patientconsultationgp';
                            $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                        }else{
                            $actions = "consultationpatientaction?'.$idvalue";
                        }                       
                        $result = $engine->getresults($sqlresults,$item=$patient,$action);
                        $re = explode(',', $result);
                        $status = $re[0];					
                        $msg = $re[1];
                        $event= "$action: $form_key $msg";
                        $eventcode=9789;
                        $usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);                      
                    }
                    }                    
                }
            }
        break; 

        // 4 aug 2024, 28 AUG 2022 
		case 'endconsultation':            
			$consultationcode = htmlspecialchars(isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '');
			$patientaction = htmlspecialchars(isset($_POST['patientaction']) ? $_POST['patientaction'] : '');
			$patientdate = htmlspecialchars(isset($_POST['patientdate']) ? $_POST['patientdate'] : '');
			$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services'] : '');
			$remarks = htmlspecialchars(isset($_POST['remarks']) ? $_POST['remarks'] : '');
			$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
			$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
			$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
			$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');	
            $idvalue = htmlspecialchars(isset($_POST['idvalue']) ? $_POST['idvalue'] : '');	
            $servicerequestedcode =  htmlspecialchars(isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] :'');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
            if ($preventduplicate == '1') {
                if (empty($patientcode)) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                    $actions = "consultationpatientaction?'.$idvalue";
                } else {                  
                    $action = 'END CONSULTATION'; 
                    $patientaction = 1;
                    $actions = "consultationpatientaction?'.$idvalue";
                    $out = $outcometable->checkoutcomesonly($patientcode,$visitcode,$consultationcode,$instcode);                        
                    if($out >'0'){
                        $sqlresults = $patientconsultationsarchivetable->endconsultationarchive($days,$patientaction,$action,$visitcode,$instcode);
                        if($sqlresults == '2'){
                            $patientconsultationstable ->deleteconsultation($consultationcode,$instcode);
                            $patientvisittable->dischargevisit($visitcode,$instcode);
                            $Prescriptionstable->dischargeprescription($patientcode,$visitcode,$instcode);
                            $patientsDevicestable->dischagerdevices($patientcode,$visitcode,$instcode);
                            $patientsInvestigationRequesttable->dischagerinvestigations($patientcode,$visitcode,$instcode);
                            $patientproceduretable->dischargeprocedure($patientcode,$visitcode,$instcode);
                            $patientbillitemtable->updatebilleritems($servicerequestedcode,$currentuser,$currentusercode,$visitcode,$instcode);
                            $visitactioncontroller->countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable);
                            $actions = 'patientconsultationgp';   
                            return '2';
                        }else{
                            return '0';
                        }
                    }else{
                        return '0';
                    }
                                                    
                }
            }
        break;                   

       
                  
	}	
?>