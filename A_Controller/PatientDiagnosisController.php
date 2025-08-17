<?php
/*

	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class PatientDiagnosisController Extends Engine{

	// 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientadddiagnosis($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$diagnosiscode,$newdiagnosis,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT DN_ID FROM octopus_st_diagnosis WHERE DN_NAME = ? AND DN_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newdiagnosis);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_diagnosis(DN_CODE,DN_NAME,DN_DESC,DN_ACTORCODE,DN_ACTOR,DN_INSTCODE) 
				VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newdiagnosis);
				$st->BindParam(3, $newdiagnosis);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $instcode);
				$exe = $st->execute();
				if($exe){
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
				$st->BindParam(11, $newdiagnosis);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $diagnosistype);
				$exe = $st->execute();
				if($exe){
					$ut = '0';
						$nut = 1;
						$sql = "UPDATE octopus_patients_consultations SET CON_DIAGNSIS = ?  WHERE CON_CODE = ? and CON_DIAGNSIS = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_DIAGNSIS = ?  WHERE CON_CODE = ? and CON_DIAGNSIS = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();							
						if($exe){								
							return '2';								
						}else{								
							return '0';								
						}		
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
	
	
	

	// 25 MAR 2021,  JOSEPH ADORBOE
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
					$ut = '0';
						$nut = 1;
						$sql = "UPDATE octopus_patients_consultations SET CON_DIAGNSIS = ?  WHERE CON_CODE = ? and CON_DIAGNSIS = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();	
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_DIAGNSIS = ?  WHERE CON_CODE = ? and CON_DIAGNSIS = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
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
	
	// 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_newdiagnosis($form_key,$diagnosis,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT DN_ID FROM octopus_st_diagnosis where DN_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $diagnosis);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_diagnosis(DN_CODE,DN_NAME,DN_DESC,DN_ACTORCODE,DN_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $diagnosis);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
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
	
	public function update_patientdiagnosis($ekey,$days,$diagnosiscode,$diagnosisname,$storyline,$diagnosistype,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_diagnosis SET DIA_DATE = ?, DIA_DIAGNOSISCODE = ?,  DIA_DIAGNOSIS = ?, DIA_REMARK =?  , DIA_DIAGNOSISTYPE = ? , DIA_ACTORCODE = ? , DIA_ACTOR = ?  WHERE DIA_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $diagnosiscode);
		$st->BindParam(3, $diagnosisname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $diagnosistype);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_removepatientdiagnosis($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_diagnosis SET DIA_STATUS = ?  WHERE DIA_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $ekey);
			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
					


	
} 
?>