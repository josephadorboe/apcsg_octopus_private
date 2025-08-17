<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_deaths
	$patientdeathtable = new OctopusPatientsDeathSql();
*/

class OctopusPatientsDeathSql Extends Engine{
	//08 AUG 2023, 12 JAN 2022 JOSEPH ADORBOE
	public function addpatientdeaths($form_key,$ekey,$randonnumber,$patient,$patientnumbers,$gender,$age,$infacility,$patientdeathdate,$deathreport,$day,$currentuser,$currentusercode,$instcode,$currentday,$currentmonth,$currentyear,$patienttable){	
		$zero = '0';
		$sqlstmt = ("SELECT PD_ID FROM octopus_patients_deaths WHERE PD_PATIENTCODE = ? AND PD_INSTCODE =? AND PD_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $zero);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{				
				$sqlstmt = "INSERT INTO octopus_patients_deaths(PD_CODE,PD_NUMBER,PD_PATIENTCODE,PD_PATIENTNUMBER,PD_PATIENT,PD_GENDER,PD_AGE,PD_TYPE,PD_DEATHDATE,PD_DATE,PD_REPORT,PD_REPORTACTOR,PD_REPORTACTORCODE,PD_INSTCODE,PD_DAY,PD_MONTH,PD_YEAR) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $randonnumber);
				$st->BindParam(3, $ekey);
				$st->BindParam(4, $patientnumbers);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $gender);
				$st->BindParam(7, $age);
				$st->BindParam(8, $infacility);
				$st->BindParam(9, $patientdeathdate);
				$st->BindParam(10, $day);
				$st->BindParam(11, $deathreport);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $currentday);
				$st->BindParam(16, $currentmonth);
				$st->BindParam(17, $currentyear);				
				$exe = $st->execute();	
				if($exe){
					$patienttable->updatepatientdeath($ekey,$patientdeathdate,$instcode);				
					return '2';														
				}else{								
					return '0';								
				}				
			}
		}else{
			return '0';
		}
	}
	
} 
$patientdeathtable = new OctopusPatientsDeathSql();
?>