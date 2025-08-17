<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 OCT 2023,
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientsVisitActionController Extends Engine{

	// 24 OCT 2023, 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber,$outcometable,$reviewcontroller,$patientreviewtable,$currenttable,$patienttable){
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			if(!empty($patientdate)){
				$exe = $reviewcontroller->insert_reviewbookings($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate=$patientdate,$reviewremark=$remarks,$secode=$servicecode,$sename=$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patientreviewtable,$patienttable);		
			}
			return '2';		
		}else{
			return '0';
		}		
	}
	// 24 Oct 2023, 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber,$outcometable,$patientreviewtable,$patienttable){		
		
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			$exe =$patientreviewtable->newreviewbookingonly($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$patientdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode);
			$patienttable->updatepatientreviewservices($patientdate,$servicesed,$patientcode,$instcode);
			// $columnname = 'CU_REVIEWCODE';
			// $currenttable->updatecurrenttable($columnname,$requestcodecode,$instcode);
			// $exe = $reviewcontroller->insert_reviewbookings($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate=$patientdate,$reviewremark=$remarks,$secode=$servicecode,$sename=$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patientreviewtable,$patienttable);
			if($exe){
				return '2';
			}else{
				return '0';
			}
		}else{
			return '0';
		}					
	}

	// 24 OCT 2023, 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_death($patientcode, $patientnumber, $patient, $visitcode, $consultationcode, $days, $patientaction, $action, $remarks, $patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode, $age,$gender,$currentusercode, $currentuser, $instcode,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$outcomenumber,$outcometable,$patientdeathtable,$patienttable){	
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			$randonnumber = Rand(1,100)	; 
			$infacility = 'Inside Facility';
			$death = $patientdeathtable->addpatientdeaths($deathrequestcode,$patientcode,$randonnumber,$patient,$patientnumber,$gender,$age,$infacility,$patientdeathdate,$deathremarks,$days,$currentuser,$currentusercode,$instcode,$currentday,$currentmonth,$currentyear,$patienttable);	
			if($death){
				return '2';
			}else{
				return '0';
			}	
		}else{
			return '0';
		}		
	}	

	// 25 oct 2023, 4 SEPT 2023, 26 FEB 2022  JOSEPH ADORBOE 
	public function update_patientaction_internalreferals($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$consultationnumber,$referalserviceamount,$physiofirstvisit,$physiofollowup,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$servicerequestedcode,$servicerequested,$outcomenumber,$currenttable,$patientconsultationstable,$patientconsultationsarchivetable,$outcometable,$patientsServiceRequesttable,$serialtable,$patientbillingtable,$patientreferaltable){	
		
		$servicerequestcode = md5(microtime());
		$billingcode = md5(microtime());		
		$newconsultationcode = md5(microtime());
		$visitdate =  date( "Y-m-d", strtotime( "$day +7 day" ) );
		$dpt = 'SERVICES';
		$paymentplan = 'NA';

		$outcome = $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);	
		if($outcome == '2'){
			if($referaltype == 'TODAY'){
				// create a new consultation
				if($servicecode !== $physiofirstvisit && $servicecode !== $physiofollowup){
					$servicerequest = $patientsServiceRequesttable->newoutcomeservicerequest($servicerequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$billingcode,$consultationpaymenttype,$physicians,$physiciancode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear);

					$patientconsultationstable->newconsultations($newconsultationcode,$servicerequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$consultationnumber,$consultationpaymenttype,$remarks,$physicians,$physiciancode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear);

					$patientconsultationsarchivetable->newconsultationsarchive($newconsultationcode,$servicerequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$consultationnumber,$consultationpaymenttype,$remarks,$physicians,$physiciancode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear);

					$patientsServiceRequesttable->updatepatientservicerequestoutcome($requestcode,$currentusercode,$currentuser,$instcode);
					
					$columnname = "CU_CONSULTATIONCODE";
					$currenttable->updatecurrenttable($columnname,$consultationnumber,$instcode);
					$serialtable->updateserials($count = 1,$physiciancode,$instcode);
					$exebills = $patientbillingtable->newbilling($form_key,$patientcode,$patientnumber,$patient,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$servicerequestcode,$billingcode,$referalserviceamount,$consultationpaymenttype,$dpt,$paymentplan,'NA',$day,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear);
					$exe = $patientreferaltable->insert_patientreferalinternal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$physiciancode,$physicians,$servicecode, $servicesed,$referaltype,$remarks,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);

					if($servicerequest && $exebills  ){
						return '2';
					}else{
						return '0';
					}
				}else{
					$exe = $patientreferaltable->insert_patientreferalinternal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$physiciancode,$physicians,$servicecode, $servicesed,$referaltype,$remarks,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);
					if($exe){
						return '2';
					}else{
						return '0';
					}
					}
				}else if($referaltype == 'NEXTVISIT'){
					$exe = $patientreferaltable->insert_patientreferalinternal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$physiciancode,$physicians,$servicecode, $servicesed,$referaltype,$remarks,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear);

					// $exe = $reviewcontroller->insert_reviewbookings($form_key,$reviewnumber,$patientcode,$patient,$patientnumber,$visitcode,$visitdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patientreviewtable,$patienttable);

					if($exe){
						return '2';
					}else{
						return '0';
					}
				}
			}else{
				return '0';
			}
		}

	// 25 OCT 2023,  21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_detain($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$dententioncode,$dententionname,$detainserviceamount,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$outcomenumber,$outcometable,$patientsadmissiontable,$admissionsarchivetable){
		$admissioncode = md5(microtime());
		$admissionservice = 'SER0013';
		$admission = 'DETAIN';
		$type = 1;
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			$exeadmission = $patientsadmissiontable->newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission=$dententionname,$admissionservice=$dententioncode,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype);

			$admissionsarchivetable->newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission=$dententionname,$admissionservice=$dententioncode,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype);

			if($exeadmission ){
				return '2';
			}else{
				return '0';
			}	
		}else{
			return '0';
		}				
	}	

	// 25 OCT 2023 JOSEPH ADORBOE 
	public function update_patientaction_admission($patientcode, $patientnumber, $patient, $visitcode,$day,$consultationcode,$consultationnumber,$days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currenttable,$outcometable,$patientsadmissiontable,$admissionsarchivetable){	
		$admissioncode = md5(microtime());
		$admissionservice = 'SER0012';
		$admission = 'ADMISSION';
		$type = 2;
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			$exeadmission  = $patientsadmissiontable->newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission,$admissionservice,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype);
			$admissionsarchivetable->newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission,$admissionservice,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype);
			if($exeadmission ){
				return '2';
			}else{
				return '0';
			}	
		}else{
			return '0';
		}		
	}

	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks,$patientcode, $patientnumber, $patient,$day,$consultationnumber, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currentuser,$currentusercode,$servicerequestedcode,$servicerequested,$outcometable){		
		$out =  $outcometable->newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode);
		if($out == '2'){
			return '2';
		}else{
			return '0';
		}		
	}
	// 24 oct 2023, 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode,$doctorstatsmonthlytable){	
		$cot = $doctorstatsmonthlytable->countdoctorstatsmonthly($currentmonth,$currentusercode,$instcode);	
		if($cot == '2'){
			$doctorstatsmonthlytable->countdoctorstatsday($currentday,$currentmonth,$currentusercode,$instcode);
			$doctorstatsmonthlytable->countdoctorstatsyear($currentyear,$currentday,$currentmonth,$currentusercode,$instcode);
			return '2';
		}else{
			return '0';
		}		
	}

	// 23 OCT 2023, 27 JULY 2023 JOSEPH ADORBOE 
	public function cancelconsultation($consultationcode,$visitcode,$cancelreason,$days,$currentusercode,$currentuser,$instcode,$patientconsultationsarchivetable,$patientconsultationstable,$patientvisittable,$Prescriptionstable,$patientsDevicestable,$patientsInvestigationRequesttable,$patientproceduretable,$patientcomplainstable,$patientsdiagnosistable,$patientmanagementtable,$patientsnotestable,$patientsoxygentable,$physicalexamstable,$patientsServiceRequesttable,$patientvitalstable){
		
		$con =  $patientconsultationsarchivetable->cancelarchiveconsultation($consultationcode,$cancelreason,$instcode);
		if($con == '2'){
			$patientconsultationstable->deleteconsultation($consultationcode,$instcode);
			$patientvisittable->cancelvisit($visitcode,$instcode);
			$Prescriptionstable->cancellprescription($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
			$patientsDevicestable->cancelconsultationdevices($cancelreason,$days,$visitcode,$currentusercode,$currentuser,$instcode);
			$patientsInvestigationRequesttable->cancellconsutlationinvestigations($visitcode,$cancelreason,$currentusercode,$currentuser,$instcode);
			$patientproceduretable->cancelconsultationprocedure($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
			$patientcomplainstable->cancelconsultationcomplains($visitcode,$instcode);
			$patientsdiagnosistable->cancelconsultationdiagnosis($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode);
			$patientmanagementtable->cancelconsultationmanagement($visitcode,$instcode);
			$patientsnotestable->cancelconsultationnotes($visitcode,$instcode);		
			$patientsoxygentable->cancelconsultationoxygen($visitcode,$instcode);
			$physicalexamstable->cancelconsultationphysicalexam($visitcode,$instcode);
			$patientsServiceRequesttable->cancelconsultationservicerequest($cancelreason,$days,$visitcode,$currentuser,$currentusercode,$instcode);
		//	$patientsServiceRequesttable->returnservicerequest($ekey,$returnreason,$currentusercode,$currentuser,$instcode);
		//	$patientsServiceRequesttable->cancelconsultationservicerequest($visitcode,$instcode);	
			$patientvitalstable->cancelconsultationvitals($visitcode,$instcode);
			return '2';			
		}else{
			return '0';
		}		
	}

	
} 

$visitactioncontroller = new PatientsVisitActionController();
?>