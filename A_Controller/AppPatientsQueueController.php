<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 Sept 2023, 18 FEB 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientQueueController Extends Engine{
	// 1 oct 2023, 25 JULY 2021   JOSEPH ADORBOE
	public function insert_patientrbstest($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$rbs,$paymenttype,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$patientsServiceRequesttable,$patientbillitemtable,$patientvitalstable){		
		$visittype = 1;
		if ($chargerbs == 'YES') {
			$serv  = $patientsServiceRequesttable->vitalsforrbsservicerequest($patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$servicerequestcode,$servicebillcode,$visittype,$currentday,$currentmonth,$currentyear,$plan='Others');
			if($serv =='2'){
				$bills = $patientbillitemtable->servicebilling($patientcode,$patientnumber,$patient,$visitcode,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$form_key,$currentday,$currentmonth,$currentyear,$plan);
				$vitals = $patientvitalstable->updatepatientrbsvitals($ekey,$rbs);
				if ($bills == '2' && $vitals == '2') {
					return '2';
				} else {
					return '0';
				}
			}else{
				return '0';
			}				
		}else{
			$vitals = $patientvitalstable->updatepatientrbsvitals($ekey,$rbs);
			if ($vitals == '2') {
				return '2';
			} else {
				return '0';
			}
		}			
	}

	// 18 SEPT 2023, 18 FEB 2021   JOSEPH ADORBOE
	public function insert_patientvitals($form_key,$ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$fbs,$rbs,$glucosetest,$paymenttype,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$consultationnumber,$spo,$currentday,$currentmonth,$currentyear,$plan,$patientvitalstable,$patientsServiceRequesttable,$patientconsultationstable,
	$patientconsultationsarchivetable,$patientbillitemtable,$currenttable,$serialtable){
		$new = $patientvitalstable->insert_newpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear);
		if($new == '2'){
			$doct = $patientsServiceRequesttable->updatepatientservicerequestdoctors($ekey,$specscode,$specsname,$serialnumber,$currentusercode,$currentuser,$instcode);
			$cons = $patientconsultationstable->insertconsultations($ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$paymenttype,$consultationnumber,$currentday,$currentmonth,$currentyear,$plan);
			$consarchive = $patientconsultationsarchivetable->insertconsultationsarchive($ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$paymenttype,$consultationnumber,$currentday,$currentmonth,$currentyear,$plan);
			if ($chargerbs =='YES') {
				$visittype = 1;
				$paymenttype = 7;
				$rbsservice = $patientsServiceRequesttable->vitalsforrbsservicerequest($patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$servicerequestcode,$billingcode,$visittype,$currentday,$currentmonth,$currentyear,$plan);
				$ser = $patientbillitemtable->servicebilling($patientcode,$patientnumber,$patient,$visitcode,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$paymenttype,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$currentday,$currentmonth,$currentyear,$plan);
			}
			$currenttable->updatecurrenttable($columnname = 'CU_CONSULTATIONCODE',$coulmnvalue=$consultationnumber,$instcode);
			$ser =$serialtable->updateserials($serialnumber,$specscode,$instcode);
			if($doct && $cons ){
				return '2';
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}
	// 18 Sept 2023, 20 FEB 2021
	public function update_reassignpatient($form_key,$ekey,$vitalscode,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$specscode,$specsname,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$chargerbs,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$spo,$plan,$currentday,$currentmonth,$currentyear,$patientsServiceRequesttable,$patientconsultationstable,$patientconsultationsarchivetable,$patientbillitemtable,$patientvitalstable){
		$doct = $patientsServiceRequesttable->updatepatientservicerequestdoctors($ekey,$specscode,$specsname,$serialnumber,$currentusercode,$currentuser,$instcode);
		if($doct == '2'){
			$cons = $patientconsultationstable->updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode);
			$cons = $patientconsultationsarchivetable->updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode);
			if ($chargerbs =='YES') {
				$visittype = 1;
				$payment = 7;
				$rbsservice = $patientsServiceRequesttable->vitalsforrbsservicerequest($patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$payment,$servicerbscode,$servicerbs,$servicerequestcode,$billingcode,$visittype,$currentday,$currentmonth,$currentyear,$plan);
				$ser = $patientbillitemtable->servicebilling($patientcode,$patientnumber,$patient,$visitcode,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$payment,$servicerbscode,$servicerbs,$rbsserviceamount,$servicerequestcode,$servicebillcode,$billingcode,$currentday,$currentmonth,$currentyear,$plan);
			}
			$vitals = $patientvitalstable->updatepatientvitals($bp,$temperature,$height,$weight,$fbs,$rbs,$glucosetest,$remarks,$currentuser,$currentusercode,$pulse,$spo,$vitalscode,$instcode);
			if($vitals == '2'){
				return '2';
			}else{
				return '0';
			}

		}else{
			return '0';
		}
	}	
} 
?>