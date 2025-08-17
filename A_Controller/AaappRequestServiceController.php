<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 9 AUG 2023, 27 FEB 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class RequestServiceController Extends Engine{			
	
	// 9 AUG 2023, 11 JAN 2021,  JOSEPH ADORBOE
    public function insert_requestservice($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan,$servicerequestcode,$visittype,$billingcode,$serviceamount,$schemepricepercentage,$cardnumber,$cardexpirydate,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cash,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$discount,$servicecharge,$discountamount,$serviceappointmentcode,$serviceappointment,$appointmentserviceamount,$ekey,$patientappointmenttable,$patientvisittable,$patientsServiceRequesttable,$patientsbillstable,$patientbillitemtable,$patientreviewtable,$patienttable,$patientdiscounttable){
	
		$dpt = 'SERVICES';
		$day = date('Y-m-d');
		$exe = $patientvisittable->newpatientvisit($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan);
		
		if($exe == 2){
			$exd = $patientsServiceRequesttable->newservicerequest($patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$visittype,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan);
				if($exd == 2){		
				$ep = $patientsbillstable->insertnewbills($billingcode,$days,$patientcode,$patientnumbers,$visitcode,$patient,$serviceamount,$currentuser,$currentusercode,$instcode);
					if($ep == 2){	
						if ($schemepricepercentage < '100') {
							$schemeamount = ($serviceamount*$schemepricepercentage)/100;
							$patientamount = $serviceamount - $schemeamount ;
							$rtn = 1;
							$cash = 'CASH';
							
							$exbill = $patientbillitemtable->newbilling($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$schemeamount,$payment,$dpt,$paymentplan,$cardnumber,$cardexpirydate,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear); 

							$exbill = $patientbillitemtable->newbilling($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$cashschemecode,$cash,$cashpaymentmethodcode,$cashpaymentmethod,$servicerequestcode,$billingcode,$patientamount,$payment,$dpt,$paymentplan,$cardnumber,$cardexpirydate,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear); 
						}else{
							$exbill = $patientbillitemtable->newbilling($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$serviceamount,$payment,$dpt,$paymentplan,$cardnumber,$cardexpirydate,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear); 
						}
						if($exbill == 2){
							if ($servicescode == $consultationreview || $servicescode == $xraylabreview || $servicescode == $consultationothopedicreview || $servicescode == $consultationrheumatologytopup || $servicescode == $consultationrheumatologyfollowuptopup || $servicescode == $consultationinternalmedicinetopup || $servicescode == $consultationinternalmedicinefollowuptopup || $servicescode == $consultationorthopedicspecilisttopup || $servicescode == $consultationorthopedicspecilistfollouptopup  ) {									
								$patientreviewtable->updatepatientsreview($patientcode,$day,$currentusercode,$currentuser,$instcode,$patienttable);
                            }
							
							if($serviceamount == floatval(0.00) || $payment == 7){
								$show = 7;
								$exd = $patientsServiceRequesttable->updateservicerequest($servicerequestcode);
							}
							if ($age > '64' && $serviceamount > '0') {
								$patientdiscounttable->newpatientdiscounts($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$discount,$servicecharge,$discountamount,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);								
							}	
							if($visittype =='2'){
								$exbill = $patientbillitemtable->newbilling($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$serviceappointmentcode,$serviceappointment,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$servicerequestcode,$billingcode,$appointmentserviceamount,$payment,$dpt,$paymentplan,$cardnumber,$cardexpirydate,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear); 
								$exp = $patienttable->updatepatientvisitservices($days,$patientcode,$instcode);
								$exp = $patientappointmenttable->updateappointment($ekey);
									if($exbill && $exp){								
										return 2;								
									}else{								
										return $this->thefailed;								
									}
							}else{							
									$exp = $patienttable->updatepatientvisitservices($days,$patientcode,$instcode);						
									if($exp){								
										return 2;								
									}else{								
										return $this->thefailed;								
									}	
							}		
						//	return 2;
						}else{
							return $this->thefailed;
						}
					}else{			
						return $this->thefailed;			
					}
				}else{				
					return $this->thefailed;				
				}				
		}else{			
			return $this->thefailed;			
		}
	}
	
	
} 

$requestservicecontoller = new RequestServiceController();
?>