<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 19 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_management
	$patientmanagementtable->getpatientmanagementdetails($requestcode,$instcode)
*/

class OctopusPatientsManagementSql Extends Engine{
	// 15 AUG 2024, JOSEPH ADORBOE 
	public function getpatientmanagementdetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_management WHERE NOTES_CODE = ? AND NOTES_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['NOTES_CODE'].'@@'.$obj['NOTES_NUMBER'].'@@'.$obj['NOTES_PATIENTCODE'].'@@'.$obj['NOTES_PATIENTNUMBER'].'@@'.$obj['NOTES_PATIENT'].'@@'.$obj['NOTES_VISITCODE']
			.'@@'.$obj['NOTES_AGE'].'@@'.$obj['NOTES_GENDER'].'@@'.$obj['NOTES_NOTES'].'@@'.$obj['NOTES_CONSULTATIONCODE'].'@@'.$obj['NOTES_DATE'];
		}else{
			$res = '0';
		}
		return $res;
	}
	// 17 AUG  2024 JOSEPH ADORBOE 
	public function edit_patientmanagement($ekey,$editpatienotes,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_management SET NOTES_NOTES = ? ,  NOTES_ACTOR = ? , NOTES_ACTORCODE = ?  WHERE NOTES_CODE = ? AND NOTES_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $editpatienotes);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getquerymanagementhistory($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_management where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE != '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC  ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketmanagement($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_management where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE = '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC  ");
		return $list;
	}
	// 13 OCT 2023 JOSEPH ADORBOE
	public function getquerymanagementlist($patientcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_management WHERE NOTES_PATIENTCODE = '$patientcode' AND NOTES_INSTCODE = '$instcode' AND NOTES_STATUS = '1' ORDER BY NOTES_ID DESC LIMIT 10");
		return $list;
	}
	// 24 OCT 2023, 25 AUG 2023
	public function cancelconsultationmanagement($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_management SET NOTES_STATUS = ? WHERE NOTES_VISITCODE = ? AND NOTES_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// 13 OCT 2023, 
	public function insert_patientmanagementnotes($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$managementnumber,$managementnotes,$currentusercode,$currentuser,$instcode){		
		$mt = 1;
		$sqlstmt = ("SELECT NOTES_ID FROM octopus_patients_management where NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_NOTES = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $managementnotes);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_management(NOTES_CODE,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_VISITCODE,NOTES_NOTES,NOTES_ACTOR,NOTES_ACTORCODE,NOTES_INSTCODE,NOTES_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $managementnotes);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $managementnumber);
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

	// 13 oct 2023,  26 MAR 2021
	public function update_patientmanagement($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_management SET NOTES_DATE = ?, NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
		$st->BindParam(3, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
} 
$patientmanagementtable = new OctopusPatientsManagementSql();
?>