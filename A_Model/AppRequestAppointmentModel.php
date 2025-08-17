<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$requestappointmodel = htmlspecialchars(isset($_POST['requestappointmodel']) ? $_POST['requestappointmodel'] : '');	
	// 27 FEB 2021
switch ($requestappointmodel)
{    
	// 11 JAN 2020 
	case 'requestserviceappointment': 

		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patientnumbers = htmlspecialchars(isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$visittype = htmlspecialchars(isset($_POST['visittype']) ? $_POST['visittype'] : '');
		$appointmentstart = htmlspecialchars(isset($_POST['appointmentstart']) ? $_POST['appointmentstart'] : '');
		$appointmentend = htmlspecialchars(isset($_POST['appointmentend']) ? $_POST['appointmentend'] : '');
		$payment = htmlspecialchars(isset($_POST['payment']) ? $_POST['payment'] : '');
        $validinsurance = htmlspecialchars(isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
        if ($preventduplicate == '1') {
            if ($currentshiftcode == '0') {
                $status = "error";
                $msg = "Shift is closed";
            } else {
                if (empty($ekey) || empty($services) || empty($paymentscheme)) {
                    $status = "error";
                    $msg = "Required Fields cannot be empty ";
                } else {
                    $ps = explode('@@@', $paymentscheme);
                    $paymentschemecode = $ps[0];
                    $paymentscheme = $ps[1];
                    $paymentmethodcode = $ps[2];
                    $paymethname = $ps[3];
                    $sev = explode('@@@', $services);
                    $servicescode = $sev[0];
                    $servicesname = $sev[1];

                    if ($visittype == '2') {
                    //    $servicescode = 'SER0028';
                        $serviceappointmentcode = 'SER0028';
                        $serviceappointment = 'APPOINTMENT SERVICE';
                        $appointmentserviceamount = $pricing->gettheprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode,$cashpaymentmethodcode);
                    } else {
                        $serviceappointmentcode =$serviceappointment =$appointmentserviceamount = '';
                    }
                    $cashschemecode = $paymentschemetable->getcashschemecode($cashpaymentmethodcode,$instcode);

                //    die($cashschemecode);

                    // private insurance
                    if ($paymentmethodcode == $privateinsurancecode) {
                        if ($validinsurance == 'NO') {
                            $status = "error";
                            $msg = "The patient ".$patient." does not have a valid insurance ";
                        } else {
                            $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode,$day,$instcode);
                            if ($insurancechecks == '-1') {
                                $status = "error";
                                $msg = "The patient ".$patient." does not have a current insurance Policy ";
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
                                    $msg = "The patient ".$patient." insurance scheme ".$paymentscheme." does not pay for ".$servicesname.". please use cash  ";
                                } else {
                                    $visitcode = md5($form_key);
                                    $rt = 'requestservice';
                                    $ght = $form_key.''.$rt;
                                    $servicerequestcode = md5($ght);

                                    $bills = 'bills';
                                    $bil = $form_key.''.$bills;
                                    $billingcode = md5($bil);

                                    $billsitem = 'billsitems';
                                    $billc = $form_key.''.$billsitem;
                                    $billingitemcode = md5($billc);
                                    $payment = 7;
                                    $appointmentstart = date('d M Y h:i:s a', strtotime($appointmentstart));
                                    $appointmentend = date('d M Y h:i:s a', strtotime($appointmentend));
                                    $appointmenttime = $appointmentstart.' - '.$appointmentend;
                
                                    $requestservice = $requestappointsql->insert_requestserviceappointment($form_key, $patientcode, $patientnumbers, $patient, $gender, $age, $visitcode, $days, $servicescode, $servicesname, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $servicerequestcode, $billingcode, $serviceamount, $billingitemcode, $visittype, $serviceappointmentcode, $serviceappointment, $appointmentserviceamount, $payment, $cardnumber, $cardexpirydate, $cashpaymentmethodcode, $cashpaymentmethod, $cashschemecode, $ekey, $appointmenttime, $currentusercode, $currentuser, $currentshiftcode, $currentshift, $instcode);
                

                                    //    $requestservice = $requestservicecontroller->insert_requestservice($form_key, $patientcode, $patientnumbers, $patient, $gender, $age, $visitcode, $days, $servicescode, $servicesname, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $servicerequestcode, $billingcode, $serviceamount, $billingitemcode, $visittype, $serviceappointmentcode, $serviceappointment, $appointmentserviceamount, $payment, $cardnumber, $cardexpirydate, $ekey, $currentusercode, $currentuser, $currentshiftcode, $currentshift, $instcode);

                                    if ($requestservice == '0') {
                                        $status = "error";
                                        $msg = "Request Service  $servicesname for $patient Unsuccessful";
                                    } elseif ($requestservice == '1') {
                                        $status = "error";
                                        $msg = "Service Request $servicesname for $patient Exist";
                                    } elseif ($requestservice == '2') {
                                        $event= "Service Request CODE:$form_key $servicesname for $patient has been saved successfully ";
                                        $eventcode= 75;
                                        $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                        if ($audittrail == '2') {
                                            $status = "success";
                                            $msg = "Service Request $servicesname for $patient added Successfully";
                                        } else {
                                            $status = "error";
                                            $msg = "Audit Trail Failed!";
                                        }
                                    } else {
                                        $status = "error";
                                        $msg = "Unsuccessful ";
                                    }
                                }
                            }
                            // } else {
                        //     $status = "error";
                        //     $msg = "Unsuccessful ";
                        // }
                        }

                        // partner companies
                    } elseif ($paymentmethodcode == $partnercompaniescode) {
                        if ($validinsurance == 'NO') {
                            $status = "error";
                            $msg = "The patient ".$patient." does not have a valid insurance ";
                        } else {
                            $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
                            if ($insurancechecks == '-1') {
                                $status = "error";
                                $msg = "The patient ".$patient." does not have a current Partner Policy ";
                            } elseif ($insurancechecks == '0') {
                                $status = "error";
                                $msg = "Unsuccessful";
                            } else {
                                $expt = explode('@@@', $insurancechecks);
                                $cardnumber = $expt[0];
                                $cardexpirydate = $expt[1];
                                $serviceamount = $pricingtable->partnercompaniesprices($servicescode, $paymentmethodcode, $paymentschemecode, $partnercompaniescode, $cashpaymentmethodcode, $instcode);
                                if ($serviceamount == '-1') {
                                    $status = "error";
                                    $msg = "The patient ".$patient." Partner scheme ".$paymentscheme." does not pay for ".$servicesname.". please use cash  ";
                                } else {
                                    $visitcode = md5($form_key);
                                    $rt = 'requestservice';
                                    $ght = $form_key.''.$rt;
                                    $servicerequestcode = md5($ght);

                                    $bills = 'bills';
                                    $bil = $form_key.''.$bills;
                                    $billingcode = md5($bil);

                                    $billsitem = 'billsitems';
                                    $billc = $form_key.''.$billsitem;
                                    $billingitemcode = md5($billc);
                                    $payment = 7;
                                    $appointmentstart = date('d M Y h:i:s a', strtotime($appointmentstart));
                                    $appointmentend = date('d M Y h:i:s a', strtotime($appointmentend));
                                    $appointmenttime = $appointmentstart.' - '.$appointmentend;

                                    $requestservice = $requestappointsql->insert_requestserviceappointment($form_key, $patientcode, $patientnumbers, $patient, $gender, $age, $visitcode, $days, $servicescode, $servicesname, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $servicerequestcode, $billingcode, $serviceamount, $billingitemcode, $visittype, $serviceappointmentcode, $serviceappointment, $appointmentserviceamount, $payment, $cardnumber, $cardexpirydate, $cashpaymentmethodcode, $cashpaymentmethod, $cashschemecode, $ekey, $appointmenttime, $currentusercode, $currentuser, $currentshiftcode, $currentshift, $instcode);

                                    if ($requestservice == '0') {
                                        $status = "error";
                                        $msg = "Request Service  ".$servicesname." for ".$patient." Unsuccessful";
                                    } elseif ($requestservice == '1') {
                                        $status = "error";
                                        $msg = "Service Request ".$servicesname." for ".$patient." Exist";
                                    } elseif ($requestservice == '2') {
                                        $event= "Service Request CODE:".$form_key." ".$servicesname." for ".$patient." has been saved successfully ";
                                        $eventcode= 75;
                                        $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                        if ($audittrail == '2') {
                                            $status = "success";
                                            $msg = "Service Request ".$servicesname." for ".$patient." added Successfully";
                                        } else {
                                            $status = "error";
                                            $msg = "Audit Trail Failed!";
                                        }
                                    } else {
                                        $status = "error";
                                        $msg = "Unsuccessful ";
                                    }
                                }
                                // } else {
                        //     $status = "error";
                        //     $msg = "Unsuccessful ";
                        // }
                            }
                        }
                    } elseif ($paymentmethodcode == $cashpaymentmethodcode || $paymentmethodcode == $mobilemoneypaymentmethodcode) {
                   
                    // if ($payment == '7' && ( $paymentmethodcode !== $cashpaymentmethodcode )) {
                        //     $status = "error";
                        //     $msg = "Pay after service is only for cash patients";
                        // } else {

                            $ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                            $serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode,$ptype,$instcodenuc, $instcode, $cashschemecode,$cashpaymentmethodcode);

                            //  die($serviceamount);
                            // give 10% discount to patients above 64 years on services 
                            if($age > '64' && $serviceamount > '0'){
                                $discountamount = (10*$serviceamount)/100;
                                $serviceamount = $serviceamount - $discountamount;
                            }
                       
                    //    $serviceamount = $pricing->gettheprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode,$cashpaymentmethodcode);
                
                        $visitcode = md5($form_key);
                        $rt = 'requestservice';
                        $ght = $form_key.''.$rt;
                        $servicerequestcode = md5($ght);

                        $bills = 'bills';
                        $bil = $form_key.''.$bills;
                        $billingcode = md5($bil);

                        $billsitem = 'billsitems';
                        $billc = $form_key.''.$billsitem;
                        $billingitemcode = md5($billc);
                        $cardnumber =$cardexpirydate ='';
                        $appointmentstart = date('d M Y h:i:s a', strtotime($appointmentstart));
                        $appointmentend = date('d M Y h:i:s a', strtotime($appointmentend));
                        $appointmenttime = $appointmentstart.' - '.$appointmentend;
                        $requestservice = $requestappointsql->insert_requestserviceappointment($form_key, $patientcode, $patientnumbers, $patient, $gender, $age, $visitcode, $days, $servicescode, $servicesname, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $servicerequestcode, $billingcode, $serviceamount, $billingitemcode, $visittype, $serviceappointmentcode, $serviceappointment, $appointmentserviceamount, $payment, $cardnumber, $cardexpirydate, $cashpaymentmethodcode, $cashpaymentmethod, $cashschemecode, $ekey, $appointmenttime, $currentusercode, $currentuser, $currentshiftcode, $currentshift, $instcode);

                        if ($requestservice == '0') {
                            $status = "error";
                            $msg = "Request Service  ".$servicesname." for ".$patient." Unsuccessful";
                        } elseif ($requestservice == '1') {
                            $status = "error";
                            $msg = "Service Request ".$servicesname." for ".$patient." Exist";
                        } elseif ($requestservice == '2') {
                            $event= "Service Request CODE:".$form_key." ".$servicesname." for ".$patient." has been saved successfully ";
                            $eventcode= 75;
                            $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                            if ($audittrail == '2') {
                                $status = "success";
                                $msg = "Service Request ".$servicesname." for ".$patient." added Successfully";
                            } else {
                                $status = "error";
                                $msg = "Audit Trail Failed!";
                            }
                        } else {
                            $status = "error";
                            $msg = "Unsuccessful ";
                        }
                    } else {
                        if ($payment == '7' && $paymentmethodcode !== $cashpaymentmethodcode) {
                            $status = "error";
                            $msg = "Pay after service is only for cash patients";
                        } else {
                            $ptype = $msql->patientnumbertype($patientnumber,$instcode,$instcodenuc);
                            $serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode,$ptype,$instcodenuc, $instcode, $cashschemecode,$cashpaymentmethodcode);

                            //  die($serviceamount);
                            // give 10% discount to patients above 64 years on services 
                            if($age > '64' && $serviceamount > '0'){
                                $discountamount = (10*$serviceamount)/100;
                                $serviceamount = $serviceamount - $discountamount;
                            }
                        //    $serviceamount = $pricing->gettheprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode,$cashpaymentmethodcode);
                
                            $visitcode = md5($form_key);
                            $rt = 'requestservice';
                            $ght = $form_key.''.$rt;
                            $servicerequestcode = md5($ght);

                            $bills = 'bills';
                            $bil = $form_key.''.$bills;
                            $billingcode = md5($bil);

                            $billsitem = 'billsitems';
                            $billc = $form_key.''.$billsitem;
                            $billingitemcode = md5($billc);
                            $cardnumber =$cardexpirydate ='';
                            $appointmentstart = date('d M Y h:i:s a', strtotime($appointmentstart));
                            $appointmentend = date('d M Y h:i:s a', strtotime($appointmentend));
                            $appointmenttime = $appointmentstart.' - '.$appointmentend;

                            $requestservice = $requestappointsql->insert_requestserviceappointment($form_key, $patientcode, $patientnumbers, $patient, $gender, $age, $visitcode, $days, $servicescode, $servicesname, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $servicerequestcode, $billingcode, $serviceamount, $billingitemcode, $visittype, $serviceappointmentcode, $serviceappointment, $appointmentserviceamount, $payment, $cardnumber, $cardexpirydate, $cashpaymentmethodcode, $cashpaymentmethod, $cashschemecode, $ekey, $appointmenttime, $currentusercode, $currentuser, $currentshiftcode, $currentshift, $instcode);

                            if ($requestservice == '0') {
                                $status = "error";
                                $msg = "Request Service  ".$servicesname." for ".$patient." Unsuccessful";
                            } elseif ($requestservice == '1') {
                                $status = "error";
                                $msg = "Service Request ".$servicesname." for ".$patient." Exist";
                            } elseif ($requestservice == '2') {
                                $event= "Service Request CODE:".$form_key." ".$servicesname." for ".$patient." has been saved successfully ";
                                $eventcode= 75;
                                $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                if ($audittrail == '2') {
                                    $status = "success";
                                    $msg = "Service Request ".$servicesname." for ".$patient." added Successfully";
                                } else {
                                    $status = "error";
                                    $msg = "Audit Trail Failed!";
                                }
                            } else {
                                $status = "error";
                                $msg = "Unsuccessful ";
                            }
                        }
                    }
                }
            }
        }        
    break;
	// 7 AUG 2023, 26 JAN 2021
	case 'records_requestservicesearch':		
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
                    $url = "requestservices?$form_key";
                    $engine->redirect($url);
                    }
			}
		}
	break;
	// 11 JAN 2020 
	case 'requestservice': 
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$patientnumbers = htmlspecialchars(isset($_POST['patientnumbers']) ? $_POST['patientnumbers'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$gender = htmlspecialchars(isset($_POST['gender']) ? $_POST['gender'] : '');
		$age = htmlspecialchars(isset($_POST['age']) ? $_POST['age'] : '');
		$services = htmlspecialchars(isset($_POST['services']) ? $_POST['services'] : '');
		$paymentscheme = htmlspecialchars(isset($_POST['paymentscheme']) ? $_POST['paymentscheme'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$visittype = htmlspecialchars(isset($_POST['visittype']) ? $_POST['visittype'] : '');
		$payment = htmlspecialchars(isset($_POST['payment']) ? $_POST['payment'] : '');
		$validinsurance = htmlspecialchars(isset($_POST['validinsurance']) ? $_POST['validinsurance'] : '');
        $patientbirthdate = htmlspecialchars(isset($_POST['patientbirthdate']) ? $_POST['patientbirthdate'] : '');
        $physio = htmlspecialchars(isset($_POST['physio']) ? $_POST['physio'] : '');
        $bcurrency = htmlspecialchars(isset($_POST['bcurrency']) ? $_POST['bcurrency'] : '');
        $billingcurrency = htmlspecialchars(isset($_POST['billingcurrency']) ? $_POST['billingcurrency'] : '');
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if (empty($ekey) || empty($services) || empty($paymentscheme)) {
                    $status = "error";
                    $msg = "Required Fields cannot be empty ";
                } else {
                    $sev = explode('@@@', $services);
                    $servicescode = $sev[0];
                    $servicesname = $sev[1];
                    $exchangerate = 1;

                    if($physio !== '1' && ($servicescode == $physiofirstvisit || $servicescode == $physioultrasoundfirstvisit) ){
                        $status = "error";
                        $msg = "This is not the first visit of $patient to the Physiotherapist ";
                    }else{
                        $ps = explode('@@@', $paymentscheme);
                        $paymentschemecode = $ps[0];
                        $paymentscheme = $ps[1];
                        $paymentmethodcode = $ps[2];
                        $paymethname = $ps[3];
                        $paymentplan = $ps[4];

                        if (!empty($patientbirthdate)) {
                            $bdate = explode('/', $patientbirthdate);
                            $mmd = $bdate[0];
                            $ddd = $bdate[1];
                            $yyy = $bdate[2];
                            $patientbirthdate = $yyy.'-'.$mmd.'-'.$ddd;
                            $day = date('Y-m-d');
                            if ($patientbirthdate < $day) {
                                $patienttable->updatepatientbirtdate($patientcode, $patientbirthdate, $instcode);
                                $age = $pat->getpatientbirthage($patientbirthdate);
                            }
                        }

                        if($bcurrency !== $billingcurrency){
                            $patienttable->updatepatientbillingcurrency($patientcode, $billingcurrency, $instcode);
                        }       

                        if ($visittype == '2') {
                            $servicescode = 'SER0028';
                            $serviceappointmentcode = 'SER0028';
                            $serviceappointment = 'APPOINTMENT SERVICE';
                            $appointmentserviceamount = $pricing->gettheprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode, $cashpaymentmethodcode);
                        } else {
                            $serviceappointmentcode =$serviceappointment =$appointmentserviceamount = '';
                        }

                        $checkreviewservice = $patientreviewtable->checkreviewservice($servicescode, $patientcode, $day, $consultationreview, $xraylabreview, $consultationothopedicreview, $consultationrheumatologytopup, $consultationrheumatologyfollowuptopup, $consultationinternalmedicinetopup, $consultationinternalmedicinefollowuptopup, $consultationorthopedicspecilisttopup, $consultationorthopedicspecilistfollouptopup, $physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,
                        $physiofullbodymassage,$physioreflexology,$physioultrasoundfollowup,$physioultrasoundonly,$dieticanconsultationsreview,$thereviewday, $instcode);
                        if ($checkreviewservice == '0') {
                            $status = "error";
                            $msg = "This patient $patient does NOT have a vaild pending REVIEW / FOLLOW UP";
                        } else {
                            $schemepricepercentage = $paymentschemetable->getschemepercentage($paymentschemecode,$instcode);
                            

                       // $physico = $patienttable->chechphysiostate($servicescode,$patientcode,$physiofirstvisit,$physiofollowup,$instcode);
                            // private insurance
                            if ($paymentmethodcode == $privateinsurancecode) {
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

                                        if($billingcurrency == 2){
                                            $exchangerate = $cashierforextable->getexchangerate('USDOLLARS',$day,$instcode);                                            
                                            if($exchangerate == '-1'){
                                                $status = "error";
                                                $msg = "Forex rate for $day has not been set";
                                            }else{
                                             $serviceamount = $pricing->privateinsuranceforeignprices($servicescode, $paymentmethodcode, $paymentschemecode,$exchangerate, $instcode);   
                                                                                        
                                            }                                           
                                            
                                        }else{
                                            $serviceamount = $pricingtable->privateinsuranceprices($servicescode,$paymentschemecode,$instcode);
                                        }
                                       
                                       
                                        if ($serviceamount == '-1') {
                                            $status = "error";
                                            $msg = "The patient $patient insurance scheme $paymentscheme does not pay for $servicesname. please use cash  ";
                                        } else {
                                            $visitcode = md5($form_key);
                                            $rt = 'requestservice';
                                            $ght = $form_key.''.$rt;
                                            $servicerequestcode = md5($ght);

                                            $bills = 'bills';
                                            $bil = $form_key.''.$bills;
                                            $billingcode = md5($bil);

                                            $billsitem = 'billsitems';
                                            $billc = $form_key.''.$billsitem;
                                            $billingitemcode = md5($billc);
                                            $payment = 1;
                                            $discount = $servicecharge = $discountamount = 0;
                                            if($schemepricepercentage < 100){
                                                $payment = 1;
                                            }
                                            if ($exchangerate == '-1') {
                                                $status = "error";
                                                $msg = "Forex rate for $day has not been set";
                                            }else{
                                            $requestservice = $requestservicecontroller->insert_requestservice($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan,$servicerequestcode,$visittype,$billingcode,$serviceamount,$schemepricepercentage,$cardnumber,$cardexpirydate,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cash,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$discount,$servicecharge,$discountamount,$serviceappointmentcode,$serviceappointment,$appointmentserviceamount,$ekey,$patientappointmenttable,$patientvisittable,$patientsServiceRequesttable,$patientsbillstable,$patientbillitemtable,$patientreviewtable,$patienttable,$patientdiscounttable);

                                            if ($requestservice == '0') {
                                                $status = "error";
                                                $msg = "Request Service  $servicesname for $patient Unsuccessful";
                                            } elseif ($requestservice == '1') {
                                                $status = "error";
                                                $msg = "Service Request $servicesname for $patient Exist";
                                            } elseif ($requestservice == '2') {
                                                $event= "Service Request CODE: $form_key $servicesname for $patient has been saved successfully ";
                                                $eventcode= 75;
                                                $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                                if ($audittrail == '2') {
                                                    if($servicescode == $physiofirstvisit){
														$patienttable->updatepatientsetphysio($patientcode,$state =3,$instcode);
														$patientsServiceRequesttable->setpatientphysioservice($state=3,$servicerequestcode,$instcode);
												
                                                        // $patienttable->updatepatientsetphysio($patientcode,$servicerequestcode,$state =3,$instcode,$servicerequestsql); 
                                                           
														   }
                                                    $status = "success";
                                                    $msg = "Service Request $servicesname for $patient  costing $serviceamount  added Successfully";
                                                } else {
                                                    $status = "error";
                                                    $msg = "Audit Trail Failed!";
                                                }
                                            } else {
                                                $status = "error";
                                                $msg = "Unsuccessful ";
                                            }
                                        }
                                        }
                                    }
                                
                                }

                                // partner companies
                            } elseif ($paymentmethodcode == $partnercompaniescode) {
                                if ($validinsurance == 'NO') {
                                    $status = "error";
                                    $msg = "The patient ".$patient." does not have a valid insurance ";
                                } else {
                                    $insurancechecks = $patientschemetable->checkpatientinsurancestatus($patientcode, $paymentschemecode, $day, $instcode);
                                    if ($insurancechecks == '-1') {
                                        $status = "error";
                                        $msg = "The patient ".$patient." does not have a current Partner Policy ";
                                    } elseif ($insurancechecks == '0') {
                                        $status = "error";
                                        $msg = "Unsuccessful";
                                    } else {
                                        $expt = explode('@@@', $insurancechecks);
                                        $cardnumber = $expt[0];
                                        $cardexpirydate = $expt[1];
                                        if($billingcurrency == 2){
                                            $exchangerate = $cashierforextable->getexchangerate('USDOLLARS',$day,$instcode);                                            
                                            if($exchangerate == '-1'){
                                                $status = "error";
                                                $msg = "Forex rate for $day has not been set";
                                            }else{
                                             $serviceamount = $pricing->privateinsuranceforeignprices($servicescode, $paymentmethodcode, $paymentschemecode,$exchangerate, $instcode);   
                                                                                        
                                            }                                           
                                            
                                        }else{
                                            $serviceamount = $pricingtable->partnercompaniesprices($servicescode, $paymentmethodcode, $paymentschemecode, $partnercompaniescode, $cashpaymentmethodcode, $instcode);
                                        }
                                       

                                       
                                        if ($serviceamount == '-1') {
                                            $status = "error";
                                            $msg = "The patient ".$patient." Partner scheme ".$paymentscheme." does not pay for ".$servicesname.". please use cash  ";
                                        } else {
                                    $visitcode = md5($form_key);
                                    $rt = 'requestservice';
                                    $ght = $form_key.''.$rt;
                                    $servicerequestcode = md5($ght);

                                    $bills = 'bills';
                                    $bil = $form_key.''.$bills;
                                    $billingcode = md5($bil);

                                    $billsitem = 'billsitems';
                                    $billc = $form_key.''.$billsitem;
                                    $billingitemcode = md5($billc);
                                    $payment = 1;
                                    $discount = $servicecharge = $discountamount = 0;
                                    if ($schemepricepercentage < 100) {
                                        $payment = 1;
                                    }
                                    if ($exchangerate == '-1') {
                                        $status = "error";
                                        $msg = "Forex rate for $day has not been set";
                                    } else {
                                        $requestservice = $requestservicecontroller->insert_requestservice($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan,$servicerequestcode,$visittype,$billingcode,$serviceamount,$schemepricepercentage,$cardnumber,$cardexpirydate,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cash,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$discount,$servicecharge,$discountamount,$serviceappointmentcode,$serviceappointment,$appointmentserviceamount,$ekey,$patientappointmenttable,$patientvisittable,$patientsServiceRequesttable,$patientsbillstable,$patientbillitemtable,$patientreviewtable,$patienttable,$patientdiscounttable);

                                        if ($requestservice == '0') {
                                            $status = "error";
                                            $msg = "Request Service  ".$servicesname." for ".$patient." Unsuccessful";
                                        } elseif ($requestservice == '1') {
                                            $status = "error";
                                            $msg = "Service Request ".$servicesname." for ".$patient." Exist";
                                        } elseif ($requestservice == '2') {
                                            $event= "Service Request CODE:".$form_key." ".$servicesname." for ".$patient." has been saved successfully ";
                                            $eventcode= 75;
                                            $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                if ($servicescode == $physiofirstvisit) {
                                                    // $patienttable->updatepatientsetphysio($patientcode,$servicerequestcode,$state =3,$instcode,$servicerequestsql);
													$patienttable->updatepatientsetphysio($patientcode,$state =3,$instcode);
                                                $patientsServiceRequesttable->setpatientphysioservice($state=3,$servicerequestcode,$instcode);
                                                }
                                                $status = "success";
                                                $msg = "Service Request ".$servicesname." for ".$patient." costing $serviceamount  added Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } else {
                                            $status = "error";
                                            $msg = "Unsuccessful ";
                                        }
                                    }
                                }
                                                                        // } else {
                        //     $status = "error";
                        //     $msg = "Unsuccessful ";
                        // }
                                    }
                                }
                            } elseif ($paymentmethodcode == $cashpaymentmethodcode || $paymentmethodcode == $mobilemoneypaymentmethodcode) {
                   
                            // if ($payment == '7' && ( $paymentmethodcode !== $cashpaymentmethodcode ||$paymentmethodcode !== $mobilemoneypaymentmethodcode )) {
                                //     $status = "error";
                                //     $msg = "Pay after service is only for cash and mobile money patients";
                                // } else {
                                
                                $ptype = $msql->patientnumbertype($patientnumbers, $instcode, $instcodenuc);
                               
                                if($billingcurrency == 2){
                                    $exchangerate = $cashierforextable->getexchangerate('USDOLLARS',$day,$instcode);                                            
                                    if($exchangerate == '-1'){
                                        $status = "error";
                                        $msg = "Forex rate for $day has not been set";
                                    }else{
                                     $serviceamount = $pricing->getcashdollarprice($servicescode,$instcode,$cashschemecode,$exchangerate);                                                                                 
                                    }  
                                   
                                }else{
                                    $serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode, $ptype, $instcodenuc, $instcode, $cashschemecode, $cashpaymentmethodcode);                               
                                }

                                $discount = $servicecharge = $discountamount = 0;

                                //  die($serviceamount);
                                // give 10% discount to patients above 64 years on services
                                if ($age > '64' && $serviceamount > '0') {
                                    $discount = 10;
                                    $discountamount = (10*$serviceamount)/100;
                                    $serviceamount = $serviceamount - $discountamount;
                                    $servicecharge = $serviceamount + $discountamount;
                                }

                                $visitcode = md5($form_key);
                                $rt = 'requestservice';
                                $ght = $form_key.''.$rt;
                                $servicerequestcode = md5($ght);

                                $bills = 'bills';
                                $bil = $form_key.''.$bills;
                                $billingcode = md5($bil);

                                $billsitem = 'billsitems';
                                $billc = $form_key.''.$billsitem;
                                $billingitemcode = md5($billc);
                                $cardnumber= 'NA';
                                $cardexpirydate = date('Y-m-d');                                

                                if ($exchangerate == '-1') {
                                    $status = "error";
                                    $msg = "Forex rate for $day has not been set";
                                }else{                                  
                                    $requestservice = $requestservicecontroller->insert_requestservice($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan,$servicerequestcode,$visittype,$billingcode,$serviceamount,$schemepricepercentage,$cardnumber,$cardexpirydate,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cash,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$discount,$servicecharge,$discountamount,$serviceappointmentcode,$serviceappointment,$appointmentserviceamount,$ekey,$patientappointmenttable,$patientvisittable,$patientsServiceRequesttable,$patientsbillstable,$patientbillitemtable,$patientreviewtable,$patienttable,$patientdiscounttable);

                                    if ($requestservice == '0') {
                                        $status = "error";
                                        $msg = "Request Service  $servicesname for $patient Unsuccessful";
                                    } elseif ($requestservice == '1') {
                                        $status = "error";
                                        $msg = "Service Request $servicesname for $patient Exist";
                                    } elseif ($requestservice == '2') {
                                        $event= "Service Request CODE: $form_key $servicesname for $patient has been saved successfully ";
                                        $eventcode= 75;
                                        $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                        if ($audittrail == '2') {
                                            if ($servicescode == $physiofirstvisit) {
                                                // $patienttable->updatepatientsetphysio($patientcode,$servicerequestcode,$state =3,$instcode,$servicerequestsql);
												$patienttable->updatepatientsetphysio($patientcode,$state =3,$instcode);
                                                $patientsServiceRequesttable->setpatientphysioservice($state=3,$servicerequestcode,$instcode);
                                            }
                                            $status = "success";
                                            $msg = "Service Request $servicesname for $patient costing $serviceamount added Successfully";
                                        } else {
                                            $status = "error";
                                            $msg = "Audit Trail Failed!";
                                        }
                                    } else {
                                        $status = "error";
                                        $msg = "Unsuccessful ";
                                    }
                               
                                   
                                }
                                //    }
                            } else {
                                if ($payment == '7' && ($paymentmethodcode !== $cashpaymentmethodcode ||$paymentmethodcode !== $mobilemoneypaymentmethodcode)) {
                                    $status = "error";
                                    $msg = "Pay after service is only for cash patients";
                                } else {
                                    $ptype = $msql->patientnumbertype($patientnumbers, $instcode, $instcodenuc);
                                    if($billingcurrency == 2){
                                        $exchangerate = $cashierforextable->getexchangerate('USDOLLARS',$day,$instcode);                                            
                                        if($exchangerate == '-1'){
                                            $status = "error";
                                            $msg = "Forex rate for $day has not been set";
                                        }else{
                                         $serviceamount = $pricing->getcashdollarprice($servicescode,$instcode,$cashschemecode,$exchangerate);   
                                                                                    
                                        }                                           
                                        
                                    }else{
                                        $serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode, $ptype, $instcodenuc, $instcode, $cashschemecode, $cashpaymentmethodcode);
                                   
                                    }
                                   // $serviceamount = $pricing->getcashprice($paymentmethodcode, $paymentschemecode, $servicescode, $ptype, $instcodenuc, $instcode, $cashschemecode, $cashpaymentmethodcode);
                                    $discount = $servicecharge = $discountamount = 0;
                                    if ($age > '64' && $serviceamount > '0') {
                                        $discount = 10;
                                        $discountamount = (10*$serviceamount)/100;
                                        $serviceamount = $serviceamount - $discountamount;
                                        $servicecharge = $serviceamount + $discountamount;
                                    }
                
                                    $visitcode = md5($form_key);
                                    $rt = 'requestservice';
                                    $ght = $form_key.''.$rt;
                                    $servicerequestcode = md5($ght);

                                    $bills = 'bills';
                                    $bil = $form_key.''.$bills;
                                    $billingcode = md5($bil);

                                    $billsitem = 'billsitems';
                                    $billc = $form_key.''.$billsitem;
                                    $billingitemcode = md5($billc);
                                    $cardnumber =$cardexpirydate ='';
                                    if ($exchangerate == '-1') {
                                        $status = "error";
                                        $msg = "Forex rate for $day has not been set";
                                    }else{
                                        $requestservice = $requestservicecontroller->insert_requestservice($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan,$servicerequestcode,$visittype,$billingcode,$serviceamount,$schemepricepercentage,$cardnumber,$cardexpirydate,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cash,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$discount,$servicecharge,$discountamount,$serviceappointmentcode,$serviceappointment,$appointmentserviceamount,$ekey,$patientappointmenttable,$patientvisittable,$patientsServiceRequesttable,$patientsbillstable,$patientbillitemtable,$patientreviewtable,$patienttable,$patientdiscounttable);

                                        if ($requestservice == '0') {
                                            $status = "error";
                                            $msg = "Request Service  $servicesname for $patient Unsuccessful";
                                        } elseif ($requestservice == '1') {
                                            $status = "error";
                                            $msg = "Service Request $servicesname for $patient Exist";
                                        } elseif ($requestservice == '2') {
                                            $event= "Service Request CODE: $form_key $servicesname for $patient costing $serviceamount has been saved successfully ";
                                            $eventcode= 75;
                                            $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                                            if ($audittrail == '2') {
                                                if ($servicescode == $physiofirstvisit) {
                                                 //   $patienttable->updatepatientsetphysio($patientcode,$servicerequestcode,$state =3,$instcode,$servicerequestsql);
													$patienttable->updatepatientsetphysio($patientcode,$state =3,$instcode);
                                                $patientsServiceRequesttable->setpatientphysioservice($state=3,$servicerequestcode,$instcode);
                                                }
                                                $status = "success";
                                                $msg = "Service Request $servicesname  for $patient costing $serviceamount  added Successfully";
                                            } else {
                                                $status = "error";
                                                $msg = "Audit Trail Failed!";
                                            }
                                        } else {
                                            $status = "error";
                                            $msg = "Unsuccessful ";
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
 

?>
