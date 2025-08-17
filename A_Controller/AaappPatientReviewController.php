<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 7 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_patients_review	
*/

class PatientReviewController Extends Engine{
	
	// 25 OCT 2023,   JOSEPH ADORBOE
	public function insert_reviewbookingsnextvisit($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$visitcode,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patienttable,$patientreviewtable){	
		$one = 1;
		$new  = $patientreviewtable->newreviewbooking($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode);
		if($new == '2'){
			$columnname = 'CU_REVIEWCODE';
			$currenttable->updatecurrenttable($columnname,$requestcodecode,$instcode);
			$patienttable->updatepatientreviewservices($reviewdate,$servicesed,$patientcode,$instcode);
			return '2';	

		}else{
			return '0';
		}		
	}	

	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function insert_reviewbookingssamevisit($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$visitcode,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patienttable,$patientreviewtable){	
		$one = 1;
		$new  = $patientreviewtable->newreviewbooking($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode);
		if($new == '2'){
			$columnname = 'CU_REVIEWCODE';
			$currenttable->updatecurrenttable($columnname,$requestcodecode,$instcode);
			$patienttable->updatepatientreviewservices($reviewdate,$servicesed,$patientcode,$instcode);
			return '2';	

		}else{
			return '0';
		}		
	}	
	// // 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	// public function insert_reviewbookingsonly($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$visitcode,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patienttable,$patientreviewtable){	
	// 	$one = 1;
	// 	$new  = $patientreviewtable->newreviewbooking($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$remarks,$servicecode,$servicesed,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode);
	// 	if($new == '2'){
	// 		$columnname = 'CU_REVIEWCODE';
	// 		$currenttable->updatecurrenttable($columnname,$requestcodecode,$instcode);
	// 		$patienttable->updatepatientreviewservices($reviewdate,$servicesed,$patientcode,$instcode);
	// 		return '2';	

	// 	}else{
	// 		return '0';
	// 	}		
	// }	
	// 4 AUG 2023 09 JULY 2021 JOSEPH ADORBOE 
	public function cancelreviewbooking($ekey,$cancelreason,$patientcode,$day,$currentusercode,$currentuser,$instcode,$patientreviewtable,$patienttable){	
		$sname  = "Review Service Cancelled";
		$can = $patientreviewtable->cancelreviewbooked($ekey,$cancelreason,$currentusercode,$currentuser,$instcode);
		if($can == 2){
			$patienttable->updatepatientreviewservices($day,$sname,$patientcode,$instcode);	
			return '2';
		}else{			
			return '0';			
		}	
		
	}
	// 4 AUG 2023 09 JULY 2021 JOSEPH ADORBOE 
	public function editreviewbooked($ekey,$reviewremark,$reviewdate,$patientcode,$secode,$sename,$currentusercode,$currentuser,$instcode,$patientreviewtable,$patienttable){
		$edit = $patientreviewtable->editreviewbooking($ekey,$reviewremark,$reviewdate,$secode,$sename,$currentusercode,$currentuser,$instcode);
		if($edit){
			$patienttable->updatepatientreviewservices($reviewdate,$sename,$patientcode,$instcode);	
			return '2';
		}else{
			return '0';
		}			
	}
	
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function insert_reviewbookings($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$reviewremark,$secode,$sename,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode,$currenttable,$patientreviewtable,$patienttable){
		$new =  $patientreviewtable->newreviewbooking($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$reviewremark,$secode,$sename,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode);
		
		if($new == '2'){
			$columnname = 'CU_REVIEWCODE';
			$currenttable->updatecurrenttable($columnname,$requestcodecode,$instcode);
			$patienttable->updatepatientreviewservices($reviewdate,$sename,$patientcode,$instcode);
			return '2';		
		}else{
			return '0';
		}		
	}	
} 

$reviewcontroller = new PatientReviewController();
?>