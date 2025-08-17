<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 8 AUG 2023, 29 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	Based : 	
*/

class MedicalReportController Extends Engine{	
	// 1 oct 2023, 13 OCT 2021,  JOSEPH ADORBOE
    public function insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$serviceamount,$servicerequestcode,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode,$currentuserspec,$patientsMedicalreportstable,$patientsServiceRequesttable,$patientbillitemtable){

		$new = $patientsMedicalreportstable->insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$currentuserspec);
		if($new == '2'){
			$cash = 'CASH';
			$serv = $patientsServiceRequesttable->newservicerequest($form_key,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicereqcode,$servicereqname,$cashschemecode,$cash,$cashpaymentmethodcode,$cash,$servicerequestcode,$servicebillcode,$visittype='1',$payment='1',$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan='cash');

			$bill = $patientbillitemtable->newbillingmedicalreport($form_key,$days,$visitcode,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$serviceamount,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode);

			if($serv == '2' && $bill  == '2'){
				return '2';
			}else{
				return '0';
			}	

		}else{
			return '0';
		}	
	}


} 

	$medicalreportcontroller = new MedicalReportController();
?>