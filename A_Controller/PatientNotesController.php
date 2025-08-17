<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 27 JUNE 2023 
	PURPOSE: Handle the patient notes in the system	
*/

class PatientNotesController Extends Engine{

	// 27 JUNE 2023,  JOSEPH ADORBOE
    public function edit_patientnotes($ekey,$editpatienotes,$notestype,$currentusercode,$currentuser,$instcode){	
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_notes SET NOTES_NOTES = ? , NOTES_TYPE = ?, NOTES_ACTOR = ?, NOTES_ACTORCODE = ? WHERE NOTES_CODE = ? AND NOTES_STATUS =  ? ";    
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $editpatienotes);
		$st->BindParam(2, $notestype);
		$st->BindParam(3, $currentuser);  
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $one);                 
		$exe = $st->execute();		
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}
	}
	

	// 27 JUNE 2023,  JOSEPH ADORBOE
    public function insert_patientnotes($form_key,$days,$notesrequestcode,$notestype,$servicerequestedcode,$servicerequested,$admissioncode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$patientnotes,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT NOTES_ID FROM octopus_patients_notes where NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_CODE = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $form_key);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){	
				$sqlstmt = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ? AND NOTES_STATUS =  ? ";    
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $patientnotes);
                    $st->BindParam(2, $form_key);
                    $st->BindParam(3, $status);                   
                    $exe = $st->execute();		
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_notes(NOTES_CODE,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_VISITCODE,NOTES_NOTES,NOTES_ACTOR,NOTES_ACTORCODE,NOTES_INSTCODE,NOTES_NUMBER,NOTES_SERVICECODE,NOTES_SERVICE,NOTES_TYPE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $admissioncode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $patientnotes);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $notesrequestcode);
				$st->BindParam(15, $servicerequestedcode);
				$st->BindParam(16, $servicerequested);
				$st->BindParam(17, $notestype);
				$exe = $st->execute();
				if($exe){
					return '2';	
					// $nut = 1;
					// 	$ut = '0';
					// 	$sql = "UPDATE octopus_patients_consultations SET CON_DOCNOTES = ?  WHERE CON_CODE = ? and CON_DOCNOTES = ?  ";
					// 	$st = $this->db->prepare($sql);
					// 	$st->BindParam(1, $nut);
					// 	$st->BindParam(2, $consultationcode);
					// 	$st->BindParam(3, $ut);						
					// 	$exe = $st->execute();	
						
					// 	$sql = "UPDATE octopus_patients_consultations_archive SET CON_DOCNOTES = ?  WHERE CON_CODE = ? and CON_DOCNOTES = ?  ";
					// 	$st = $this->db->prepare($sql);
					// 	$st->BindParam(1, $nut);
					// 	$st->BindParam(2, $consultationcode);
					// 	$st->BindParam(3, $ut);						
					// 	$exe = $st->execute();	
					// 	if($exe){								
					// 		return '2';								
					// 	}else{								
					// 		return '0';								
					// 	}
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	}
	
	
} 
?>