<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 30 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_chronic
	$patientchronictable->querygetphysiopatientchronic($patientcode,$instcode);
	 = new OctopusPatientsChronicSql();
*/

class OctopusPatientsChronicSql Extends Engine{
	
	// 6 APR 2025, JOSEPH ADORBOE 
	public function querygetphysiopatientchronic($patientcode,$instcode){
		$list = "SELECT CH_CODE,CH_CHRONIC,CH_DATE,CH_HISTORY from octopus_patients_chronic where CH_PATIENTCODE = '$patientcode' and CH_INSTCODE = '$instcode' and CH_STATUS = '1' order by CH_ID DESC  ";
		return $list;
	}
	// 2 oct  2023 JOSEPH ADORBOE
	public function getquerypatientchronic($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_chronic where CH_PATIENTCODE = '$patientcode' and CH_INSTCODE = '$instcode' and CH_STATUS = '1' order by CH_ID DESC ");
		return $list;
	}
	// 29 JUNE 2024 
	public function editpatientchronic($ekey,$chroniccode,$chronicname,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_chronic SET CH_CHRONICCODE = ?, CH_CHRONIC = ?, CH_ACTORCODE = ?, CH_ACTOR = ? WHERE CH_CODE = ? AND CH_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $chroniccode);
		$st->BindParam(2, $chronicname);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 11 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$newchronic,$storyline,$currentusercode,$currentuser,$instcode){

		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_st_chronic where CH_CHRONIC = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newchronic);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_chronic(CH_CODE,CH_CHRONIC,CH_DESC,CH_USERCODE,CH_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newchronic);
				$st->BindParam(3, $newchronic);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);				
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_chronic(CH_CODE,CH_DATE,CH_PATIENTCODE,CH_PATIENTNUMBER,CH_PATIENT,CH_CONSULTATIONCODE,CH_AGE,CH_GENDER,CH_VISITCODE,CH_CHRONICCODE,CH_CHRONIC,CH_HISTORY,CH_ACTOR,CH_ACTORCODE,CH_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $chroniccode);
				$st->BindParam(11, $newchronic);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					return '2';
				}else{
					return '0';
				}

				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	}
	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_patientchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$chronicc,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_patients_chronic where CH_PATIENTCODE = ? AND CH_VISITCODE = ? AND CH_CHRONICCODE = ? and CH_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $chroniccode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_chronic(CH_CODE,CH_DATE,CH_PATIENTCODE,CH_PATIENTNUMBER,CH_PATIENT,CH_CONSULTATIONCODE,CH_AGE,CH_GENDER,CH_VISITCODE,CH_CHRONICCODE,CH_CHRONIC,CH_HISTORY,CH_ACTOR,CH_ACTORCODE,CH_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $chroniccode);
				$st->BindParam(11, $chronicc);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
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
	// 30 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientchronicstatus($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_chronic WHERE CH_PATIENTCODE = ? AND CH_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	

	
}
$patientchronictable = new OctopusPatientsChronicSql(); 
?>