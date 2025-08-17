<?php
/*

	AUTHOR: JOSEPH ADORBOE
	DATE: 24 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class PatientComplainsController Extends Engine{

	// 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$newcomplain,$storyline,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT COMPL_ID FROM octopus_st_complains where COMPL_COMPLAINS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newcomplain);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	

			$sqlstmt = "INSERT INTO octopus_patients_complains(PPC_CODE,PPC_DATE,PPC_PATIENTCODE,PPC_PATIENTNUMBER,PPC_PATIENT,PPC_CONSULTATIONCODE,PPC_AGE,PPC_GENDER,PPC_VISITCODE,PPC_COMPLAINCODE,PPC_COMPLAIN,PPC_HISTORY,PPC_ACTOR,PPC_ACTORCODE,PPC_INSTCODE) 
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
			$st->BindParam(10, $complainscode);
			$st->BindParam(11, $newcomplain);
			$st->BindParam(12, $storyline);
			$st->BindParam(13, $currentuser);
			$st->BindParam(14, $currentusercode);
			$st->BindParam(15, $instcode);
			$exe = $st->execute();
			if($exe){
				$ut = '0';
				$nut = 1;
				$sql = "UPDATE octopus_patients_consultations SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nut);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $ut);						
				$exe = $st->execute();	
				$sql = "UPDATE octopus_patients_consultations_archive SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
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
				$sqlstmt = "INSERT INTO octopus_st_complains(COMPL_CODE,COMPL_COMPLAINS,COMPL_DESC,COMPL_USERCODE,COMPL_USER,COMPL_INSTCODE) 
				VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newcomplain);
				$st->BindParam(3, $newcomplain);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $instcode);				
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_complains(PPC_CODE,PPC_DATE,PPC_PATIENTCODE,PPC_PATIENTNUMBER,PPC_PATIENT,PPC_CONSULTATIONCODE,PPC_AGE,PPC_GENDER,PPC_VISITCODE,PPC_COMPLAINCODE,PPC_COMPLAIN,PPC_HISTORY,PPC_ACTOR,PPC_ACTORCODE,PPC_INSTCODE) 
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
				$st->BindParam(10, $complainscode);
				$st->BindParam(11, $newcomplain);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					$ut = '0';
					$nut = 1;
					$sql = "UPDATE octopus_patients_consultations SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $consultationcode);
					$st->BindParam(3, $ut);						
					$exe = $st->execute();
					$sql = "UPDATE octopus_patients_consultations_archive SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
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
	
	// 24 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode){
	
		$one = 1;
		$sqlstmt = ("SELECT PPC_ID FROM octopus_patients_complains where PPC_PATIENTCODE = ? AND PPC_VISITCODE = ? AND PPC_CODE = ? and PPC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $form_key);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				$sqlstmt = "UPDATE octopus_patients_complains SET PPC_HISTORY = ? ,PPC_COMPLAINCODE = ?, PPC_COMPLAIN = ? WHERE PPC_CODE = ? AND PPC_STATUS =  ? ";    
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $storyline);
				$st->BindParam(2, $complainscode);
				$st->BindParam(3, $complain);  
				$st->BindParam(4, $form_key);
				$st->BindParam(5, $one);                 
				$exe = $st->execute();	
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}		

			}else{
				$sqlstmt = "INSERT INTO octopus_patients_complains(PPC_CODE,PPC_DATE,PPC_PATIENTCODE,PPC_PATIENTNUMBER,PPC_PATIENT,PPC_CONSULTATIONCODE,PPC_AGE,PPC_GENDER,PPC_VISITCODE,PPC_COMPLAINCODE,PPC_COMPLAIN,PPC_HISTORY,PPC_ACTOR,PPC_ACTORCODE,PPC_INSTCODE) 
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
				$st->BindParam(10, $complainscode);
				$st->BindParam(11, $complain);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					$ut = '0';
					$nut = 1;
					$sql = "UPDATE octopus_patients_consultations SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $consultationcode);
					$st->BindParam(3, $ut);						
					$exe = $st->execute();
					$sql = "UPDATE octopus_patients_consultations_archive SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
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
	
	// 24 MAR 2021,  JOSEPH ADORBOE
    public function insert_newcomplains($form_key,$newcomplain,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT COMPL_ID FROM octopus_st_complains where COMPL_COMPLAINS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newcomplain);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_complains(COMPL_CODE,COMPL_COMPLAINS,COMPL_DESC,COMPL_USERCODE,COMPL_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newcomplain);
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
	
	public function update_patientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_complains SET PPC_DATE = ?, PPC_COMPLAINCODE = ?,  PPC_COMPLAIN = ?, PPC_HISTORY =?  WHERE PPC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $comcode);
		$st->BindParam(3, $comname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_removepatientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_complains SET PPC_STATUS = ?  WHERE PPC_CODE = ?  ";
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