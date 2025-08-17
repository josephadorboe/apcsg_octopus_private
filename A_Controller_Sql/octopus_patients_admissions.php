<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_admissions
	$patientsadmissiontable->updateadmissionnotes($admissioncode,$admssionnotes,$actordetails,$instcode);
	 = new OctopusPatientsAdmissionsSql();
*/

class OctopusPatientsAdmissionsSql Extends Engine{

	// 5 JULY 2025 , JOSEPH ADORBOE
	public function updateadmissionnotes($admissioncode,$admssionnotes,$actordetails,$instcode){		
		$rt = 1;	
		$day = date("Y-m-d H:i:s");	
		$sql = "UPDATE octopus_patients_admissions SET ADM_ADMISSIONNOTES = ? , ADM_ADMISSIONNOTESACTOR = ? WHERE ADM_CODE = ? AND ADM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $admssionnotes);
		$st->BindParam(2, $actordetails);
		$st->BindParam(3, $admissioncode);
		$st->BindParam(4, $instcode);	
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_patients_admissions_archive SET ADM_ADMISSIONNOTES = ? , ADM_ADMISSIONNOTESACTOR = ? WHERE ADM_CODE = ? AND ADM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $admssionnotes);
		$st->BindParam(2, $actordetails);
		$st->BindParam(3, $admissioncode);
		$st->BindParam(4, $instcode);
		$exe = $st->execute();
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}	
	// 29 JUNE 2024, 22 APR  2022 JOSEPH ADORBOE
	public function assignbed($admissioncode,$bedcode,$bedname,$wardcode,$wardname,$bedgender,$bedrate,$currentuser,$currentusercode,$instcode){		
		$rt = 1;	
		$day = date("Y-m-d H:i:s");	
		$sql = "UPDATE octopus_patients_admissions SET ADM_WARDCODE = ? , ADM_WARD = ? , ADM_BEDCODE = ? , ADM_BED = ?, ADM_BEDGENDER = ?, ADM_BEDRATE = ? , ADM_ASSIGNBEDACTOR =?  , ADM_ASSIGNBEDACTORCODE = ? , ADM_ASSIGNBEDDATE =? WHERE ADM_CODE = ? AND ADM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $wardcode);
		$st->BindParam(2, $wardname);
		$st->BindParam(3, $bedcode);
		$st->BindParam(4, $bedname);	
		$st->BindParam(5, $bedgender);
		$st->BindParam(6, $bedrate);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $day);
		$st->BindParam(10, $admissioncode);
		$st->BindParam(11, $instcode);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_patients_admissions_archive SET ADM_WARDCODE = ? , ADM_WARD = ? , ADM_BEDCODE = ? , ADM_BED = ? , ADM_BEDGENDER = ?, ADM_BEDRATE = ? , ADM_ASSIGNBEDACTOR =?  , ADM_ASSIGNBEDACTORCODE = ? , ADM_ASSIGNBEDDATE =? WHERE ADM_CODE = ? AND ADM_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $wardcode);
		$st->BindParam(2, $wardname);
		$st->BindParam(3, $bedcode);
		$st->BindParam(4, $bedname);	
		$st->BindParam(5, $bedgender);
		$st->BindParam(6, $bedrate);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $day);
		$st->BindParam(10, $admissioncode);
		$st->BindParam(11, $instcode);
		$exe = $st->execute();
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}	
	// 29 JUNE 2024, 11 JAN 2021 JOSEPH ADORBOE 
	public function getpatientadmissiondetails($idvalue,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_admissions where ADM_CODE = ? AND ADM_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['ADM_CODE'].'@'.$object['ADM_NUMBER'].'@'.$object['ADM_VISITCODE'].'@'.$object['ADM_DATETIME'].'@'.$object['ADM_PATIENTCODE'].'@'.$object['ADM_PATIENTNUMBER'].'@'.$object['ADM_PATIENT'].'@'.$object['ADM_AGE'].'@'.$object['ADM_GENDER'].'@'.$object['ADM_STATUS'].'@'.$object['ADM_PAYMETHOD'].'@'.$object['ADM_PAYMETHODCODE'].'@'.$object['ADM_PAYMENTSCHEMECODE'].'@'.$object['ADM_PAYMENTSCHEME'].'@'.$object['ADM_TYPE'].'@'.$object['ADM_DOCTOR'].'@'.$object['ADM_ADMISSIONNOTES'].'@'.$object['ADM_TRIAGE'].'@'.$object['ADM_SHOW'].'@'.$object['ADM_WARD'].'@'.$object['ADM_BED'].'@'.$object['ADM_DAYS_SPENT'].'@'.$object['ADM_SERVICECODE'].'@'.$object['ADM_SERVICE'].'@'.$object['ADM_ADMISSIONNOTESACTOR'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	
	// 29 JUNE 2024
	public function getpatientsonadmissions($instcode){
		$list  = ("SELECT * FROM octopus_patients_admissions  WHERE ADM_STATUS = '1' AND  ADM_INSTCODE = '$instcode'  order by ADM_ID DESC ");
		return $list;
	}
	// 3 SEPT 2023
	public function newadmission($admissioncode,$admissionrequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$day,$admission,$admissionservice,$paymentmethod,$paymentmethodcode,$scheme,$schemecode,$currentusercode,$currentuser,$consultationcode,$requestcode,$instcode,$currentday,$currentmonth,$currentyear,$admissionnotes,$type,$triage,$consultationpaymenttype){
		$one = 1;
		
		$sqlstmt = "INSERT INTO octopus_patients_admissions(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
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
$patientsadmissiontable = new OctopusPatientsAdmissionsSql(); 
?>