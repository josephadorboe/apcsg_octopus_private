<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 4 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_consultations_outcome
	$outcometable = new OctopusPatientsConsultationsOutcomeSql();
*/

class OctopusPatientsConsultationsOutcomeSql Extends Engine{
	// 9 AUG 2024 JOSEPH ADORBOE
	public function getqueryoutcomeshistory($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_consultations_outcome WHERE OUT_INSTCODE = '$instcode' and OUT_STATUS = '1' AND OUT_VISITCODE != '$visitcode' AND OUT_PATIENTCODE ='$patientcode' order by OUT_ID DESC ");
		return $list;
	}
	// 24 OCT 2023 JOSEPH ADORBOE
	public function getqueryoutcomes($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_consultations_outcome WHERE OUT_INSTCODE = '$instcode' and OUT_STATUS = '1' AND OUT_VISITCODE = '$visitcode' AND OUT_PATIENTCODE ='$patientcode' order by OUT_ID DESC ");
		return $list;
	}

	// 25 Oct 2023, 4 SEPT 2023,  JOSEPH ADORBOE
	public function checkoutcomesonly($patientcode,$visitcode,$consultationcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$check = $st->execute();
		if($check){								
			return $st->rowcount();
		}else{				
			return '0';				
		}	
	}

	// 24 Oct 2023, 4 SEPT 2023,  JOSEPH ADORBOE
	public function newoutcomesonly($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode){
		$one = 1;
		$outcomecode = md5(microtime());
		$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $outcomecode);
		$st->BindParam(2, $consultationcode);
		$st->BindParam(3, $consultationnumber);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $days);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumber);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $servicerequestedcode);
		$st->BindParam(12, $servicerequested);
		$st->BindParam(13, $days);
		$st->BindParam(14, $patientaction);
		$st->BindParam(15, $action);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $currentshiftcode);
		$st->BindParam(18, $currentshift);
		$st->BindParam(19, $currentday);
		$st->BindParam(20, $currentmonth);
		$st->BindParam(21, $currentyear);
		$st->BindParam(22, $currentuser);
		$st->BindParam(23, $currentusercode);
		$st->BindParam(24, $outcomenumber);				
		$exeoutcome = $st->execute();				
		if($exeoutcome){				
			return '2';
		}else{				
			return '0';				
		}	
	}

		// 4 SEPT 2023,  JOSEPH ADORBOE
		public function newoutcome($patientcode,$patientnumber,$patient,$consultationnumber,$days,$patientaction,$visitcode,$action,$outcomenumber,$servicerequestedcode,$servicerequested,$consultationcode,$currentuser,$currentusercode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$instcode){
			$one = 1;
			$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();				
				if($exeoutcome){				
					return '2';
				}else{				
					return '0';				
				}
		}	
		}
	}
	
} 
$outcometable = new OctopusPatientsConsultationsOutcomeSql();
?>