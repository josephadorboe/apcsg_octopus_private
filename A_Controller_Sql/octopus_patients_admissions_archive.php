<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_admissions_archive
	$admissionsarchivetable = new OctopusPatientsAdmissionsArchiveSql();
*/

class OctopusPatientsAdmissionsArchiveSql Extends Engine{
	// 3 SEPT 2023
	public function newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission,$admissionservice,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype){
		$one = 1;
		
		$sqlstmt = "INSERT INTO octopus_patients_admissions_archive(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $admissioncode);
					$st->BindParam(2, $admissionrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $day);
					$st->BindParam(9, $days);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $admission);
					$st->BindParam(12, $admissionservice);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $scheme);
					$st->BindParam(16, $schemecode);
					$st->BindParam(17, $consultationcode);
					$st->BindParam(18, $requestcode);
					$st->BindParam(19, $admissionnotes);
					$st->BindParam(20, $type);
					$st->BindParam(21, $currentusercode);
					$st->BindParam(22, $currentuser);
					$st->BindParam(23, $currentusercode);
					$st->BindParam(24, $currentuser);
					$st->BindParam(25, $instcode);
					$st->BindParam(26, $triage);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);	
					$st->BindParam(30, $consultationpaymenttype);				
					$exeadmission = $st->execute();
					if($exeadmission){								
						return '2';								
					}else{								
						return '0';								
					}	
	}
	
} 
$admissionsarchivetable = new OctopusPatientsAdmissionsArchiveSql();
?>