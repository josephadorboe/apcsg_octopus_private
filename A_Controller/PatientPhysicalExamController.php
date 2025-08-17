<?php
/*

	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class PatientPhysicalExamController Extends Engine{

	// 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$newphysicalexams,$storyline,$currentusercode,$currentuser,$instcode){	

		$mt = 1;
		$sqlstmt = ("SELECT PE_ID FROM octopus_st_physicalexam where PE_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newphysicalexams);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_physicalexam(PE_CODE,PE_NAME,PE_DESC,PE_ACTORCODE,PE_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newphysicalexams);
				$st->BindParam(3, $newphysicalexams);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_physicalexam(PHE_CODE,PHE_DATE,PHE_PATIENTCODE,PHE_PATIENTNUMBER,PHE_PATIENT,PHE_CONSULTATIONCODE,PHE_AGE,PHE_GENDER,PHE_VISITCODE,PHE_EXAMCODE,PHE_EXAMNAME,PHE_EXAMNOTES,PHE_ACTOR,PHE_ACTORCODE,PHE_INSTCODE) 
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
				$st->BindParam(10, $physicalexamcode);
				$st->BindParam(11, $newphysicalexams);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					$ut = '0';
					$nut = 1;
					$sql = "UPDATE octopus_patients_consultations SET CON_PHYSIALEXAMS = ?  WHERE CON_CODE = ? and CON_PHYSIALEXAMS = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $consultationcode);
					$st->BindParam(3, $ut);						
					$exe = $st->execute();	
					$sql = "UPDATE octopus_patients_consultations_archive SET CON_PHYSIALEXAMS = ?  WHERE CON_CODE = ? and CON_PHYSIALEXAMS = ?  ";
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
    public function insert_patientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT PHE_ID FROM octopus_patients_physicalexam where PHE_PATIENTCODE = ? AND PHE_VISITCODE = ? AND PHE_EXAMCODE = ? and PHE_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $physicalexamcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_physicalexam(PHE_CODE,PHE_DATE,PHE_PATIENTCODE,PHE_PATIENTNUMBER,PHE_PATIENT,PHE_CONSULTATIONCODE,PHE_AGE,PHE_GENDER,PHE_VISITCODE,PHE_EXAMCODE,PHE_EXAMNAME,PHE_EXAMNOTES,PHE_ACTOR,PHE_ACTORCODE,PHE_INSTCODE) 
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
				$st->BindParam(10, $physicalexamcode);
				$st->BindParam(11, $physicalexam);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					$ut = '0';
					$nut = 1;
					$sql = "UPDATE octopus_patients_consultations SET CON_PHYSIALEXAMS = ?  WHERE CON_CODE = ? and CON_PHYSIALEXAMS = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $consultationcode);
					$st->BindParam(3, $ut);						
					$exe = $st->execute();	
					$sql = "UPDATE octopus_patients_consultations_archive SET CON_PHYSIALEXAMS = ?  WHERE CON_CODE = ? and CON_PHYSIALEXAMS = ?  ";
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
    public function insert_newphysicalexams($form_key,$physicalexams,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT PE_ID FROM octopus_st_physicalexam where PE_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $physicalexams);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_physicalexam(PE_CODE,PE_NAME,PE_DESC,PE_ACTORCODE,PE_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $physicalexams);
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
	
	public function update_patientphysicalexams($ekey,$days,$physicalexamcode,$physicalexamname,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_physicalexam SET PHE_DATE = ?, PHE_EXAMCODE = ?,  PHE_EXAMNAME = ?, PHE_EXAMNOTES =?  WHERE PHE_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $physicalexamcode);
		$st->BindParam(3, $physicalexamname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_removepatientphysicalexams($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_physicalexam SET PHE_STATUS = ?  WHERE PHE_CODE = ?  ";
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