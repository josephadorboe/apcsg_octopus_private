<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 17 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientController Extends Engine{

	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientdetails($patientcode){
		$sqlstmt = ("SELECT PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_DOB,PATIENT_NAMES,PATIENT_GENDER,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_OCCUPATION,PATIENT_NATIONALITY,PATIENT_HOMEADDRESS,PATIENT_PHONENUMBER,PATIENT_BLOODGROUP,PATIENT_LASTVISIT,PATIENT_NUMVISITS,PATIENT_REVIEWDATE,PATIENT_PHYSIO FROM octopus_patients where PATIENT_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PATIENT_CODE'].'@'.$object['PATIENT_PATIENTNUMBER'].'@'.$object['PATIENT_DOB'].'@'.$object['PATIENT_NAMES'].'@'.$object['PATIENT_GENDER'].'@'.$object['PATIENT_RELIGION'].'@'.$object['PATIENT_MARITAL'].'@'.$object['PATIENT_OCCUPATION'].'@'.$object['PATIENT_NATIONALITY'].'@'.$object['PATIENT_HOMEADDRESS'].'@'.$object['PATIENT_PHONENUMBER'].'@'.$object['PATIENT_BLOODGROUP'].'@'.$object['PATIENT_LASTVISIT'].'@'.$object['PATIENT_NUMVISITS'].'@'.$object['PATIENT_REVIEWDATE'].'@'.$object['PATIENT_PHYSIO'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	
	
} 
?>