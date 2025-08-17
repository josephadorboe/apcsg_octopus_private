<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 4 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_diagnosis
	$patientsdiagnosistable = new OctopusPatientsDiagnosisSql();
	$patientsdiagnosistable->querygetdiagnosisreport($diagnosissearch,$diagnosisfrom,$diagnosisto,$instcode);
*/

class OctopusPatientsDiagnosisSql Extends Engine{

	// 21 FEB 2025, JOSEPH ADORBOE  = $diagnosisto = $diagnosissearch AND DIA_INSTCODE = '$instcode' ,$instcode
	// public function querygetdiagnosisreport($patientcode,$instcode){
	public function querygetdiagnosisreport($diagnosissearch,$diagnosisfrom,$diagnosisto,$instcode){
		$list = ("SELECT  DIA_PATIENTCODE,  DATE(DIA_DATE) AS DAT , DIA_PATIENTNUMBER AS PATIENTNO, DIA_PATIENT AS PATIENT,  DIA_AGE AS AGE, DIA_GENDER AS GENDER ,  DIA_DIAGNOSIS AS DIAGNOSIS , PC_PHONE AS PHONE , PC_PHONEALT AS PHONEALT , PC_EMAIL AS EMAIL  FROM octopus_patients_diagnosis JOIN octopus_patients_contacts ON DIA_PATIENTCODE = PC_PATIENTCODE where DIA_DIAGNOSIS LIKE '%$diagnosissearch%' AND  DATE(DIA_DATE) between '$diagnosisfrom' AND '$diagnosisto' AND DIA_INSTCODE = '$instcode' ORDER BY DIA_DATE ASC ");

		// $list = ("SELECT DIA_DATE AS DAT , DIA_PATIENTNUMBER AS PATIENTNO, DIA_PATIENT AS PATIENT, DIA_AGE AS AGE, DIA_GENDER AS GENDER, PC_PHONE AS PHONE, PC_PHONEALT AS PHONEALT , PC_EMAIL AS EMAIL ,  DIA_DIAGNOSIS AS DIAGNOSIS FROM octopus_patients_diagnosis JOIN octopus_patients_contacts ON DIA_PATIENTCODE = PC_PATIENTCODE WHERE DIA_DIAGNOSIS LIKE '%$diagnosissearch%' AND  DATE(DIA_DATE) between '$diagnosisfrom' AND '$diagnosisto'  GROUP BY DIA_PATIENTCODE ORDER BY DIA_DATE ASC "); GROUP BY DIA_PATIENTCODE ORDER BY DIA_DATE ASC

		return $list;
	}
	// 16 AUG 2024, JOSEPH ADORBOE 
	public function getdiagnosisrequesteddetails($requestcode,$instcode){
		$zero = '0';
		$one  = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_diagnosis WHERE DIA_CODE = ? AND DIA_INSTCODE = ? AND DIA_STATUS != ? ORDER BY DIA_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $zero);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['DIA_DIAGNOSISCODE'].'@'.$object['DIA_DIAGNOSIS'].'@'.$object['DIA_REMARK'].'@'.$object['DIA_DIAGNOSISTYPE'].'@'.$object['DIA_CODE'].'@'.$object['DIA_CONSULTATIONCODE'].'@'.$object['DIA_VISITCODE'].'@'.$object['DIA_DATE'].'@'.$object['DIA_GENDER'].'@'.$object['DIA_AGE'].'@'.$object['DIA_PATIENTCODE'].'@'.$object['DIA_PATIENTNUMBER'].'@'.$object['DIA_PATIENT'] ;				
			}else{
				$results = '1';
			}
		}else{
			$results = '1';
		}			
		return $results;
	}
	
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketdiagnosis($patientcode,$visitcode,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis where DIA_PATIENTCODE = '$patientcode' and DIA_VISITCODE = '$visitcode' and DIA_INSTCODE = '$instcode'  order by DIA_STATUS DESC, DIA_ID DESC  ");
		return $list;
	}
	// 03 Oct 2023 JOSEPH ADORBOE
	public function getquerylegacydiagnosis($patientcode,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis where DIA_PATIENTCODE = '$patientcode'  and DIA_INSTCODE = '$instcode'  order by  DIA_STATUS DESC,  DIA_ID DESC");
		return $list;
	}
	// 7 Oct 2023 JOSEPH ADORBOE
	public function getquerydiagnosismainhistory($patientcode,$visitcode,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis where DIA_PATIENTCODE = '$patientcode' and DIA_VISITCODE != '$visitcode' and DIA_INSTCODE = '$instcode'  order by  DIA_STATUS DESC,  DIA_ID DESC");
		return $list;
	}

	
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerydiagnosishistory($patientcode,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis where DIA_PATIENTCODE = '$patientcode' and DIA_INSTCODE = '$instcode'  order by  DIA_STATUS DESC,  DIA_ID DESC");
		return $list;
	}
	 

	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getpatientdiagnosisclaims($visitcode,$patientcode,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis where DIA_PATIENTCODE = '$patientcode' and DIA_VISITCODE = '$visitcode' and DIA_INSTCODE = '$instcode' and DIA_STATUS = '1' order by DIA_ID DESC ");
		return $list;
	}
	// 7 oct 2023, 
	public function cancelconsultationdiagnosis($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_diagnosis SET DIA_STATUS = ?, DIA_REASON =?, DIA_REASONACTOR = ?, DIA_REASONACTORCODE =?, DIA_REASONDATE = ?  WHERE DIA_VISITCODE = ?  AND DIA_INSTCODE =? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $days);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
	// 7 oct 2023, 
	public function update_removepatientdiagnosis($ekey,$days,$removereason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_diagnosis SET DIA_STATUS = ?, DIA_REASON =?, DIA_REASONACTOR = ?, DIA_REASONACTORCODE =?, DIA_REASONDATE = ?  WHERE DIA_CODE = ?  AND DIA_INSTCODE =? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $removereason);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 4 SEPT  2023, 7 MAR 2022  JOSEPH ADORBOE 
	public function checkpatientdiagnosis($visitcode,$patientcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT DIA_ID  FROM octopus_patients_diagnosis WHERE DIA_PATIENTCODE = ? AND DIA_INSTCODE = ? AND DIA_VISITCODE = ? AND DIA_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return '1';
			}
		}else{
			return '1';
		}		
	}

	// 7 oct 2023, 
	public function update_patientdiagnosis($ekey,$days,$diagnosiscode,$diagnosisname,$storyline,$diagnosistype,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_diagnosis SET DIA_DATE = ?, DIA_DIAGNOSISCODE = ?,  DIA_DIAGNOSIS = ?, DIA_REMARK = ?  , DIA_DIAGNOSISTYPE = ? , DIA_ACTORCODE = ? , DIA_ACTOR = ?  WHERE DIA_CODE = ? AND DIA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $diagnosiscode);
		$st->BindParam(3, $diagnosisname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $diagnosistype);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);	
		$st->BindParam(9, $instcode);		
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 7 oct 2023, 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientdiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT DIA_ID FROM octopus_patients_diagnosis where DIA_PATIENTCODE = ? AND DIA_VISITCODE = ? AND DIA_DIAGNOSISCODE = ? and DIA_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $diagnosiscode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_diagnosis(DIA_CODE,DIA_DATE,DIA_PATIENTCODE,DIA_PATIENTNUMBER,DIA_PATIENT,DIA_CONSULTATIONCODE,DIA_AGE,DIA_GENDER,DIA_VISITCODE,DIA_DIAGNOSISCODE,DIA_DIAGNOSIS,DIA_REMARK,DIA_ACTOR,DIA_ACTORCODE,DIA_INSTCODE,DIA_DIAGNOSISTYPE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $diagnosiscode);
				$st->BindParam(11, $diagnosisname);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $diagnosistype);
				$exe = $st->execute();
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
	
	
} 
$patientsdiagnosistable = new OctopusPatientsDiagnosisSql();
?>