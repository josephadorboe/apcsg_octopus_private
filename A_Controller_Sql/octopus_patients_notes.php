<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 19 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_notes 
	$patientsnotestable->querygetphysionotes($patientcode,$type,$instcode)
	insert_patientdoctorsnotes($notekey,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode);
	 = new OctopusPatientsNotesSql();
*/

class OctopusPatientsNotesSql Extends Engine{
	
											
	// 13 OCT 2023 JOSEPH ADORBOE
	public function querygetphysionotes($patientcode,$type,$instcode){		
		$list = ("SELECT NOTES_CODE,NOTES_DATE,NOTES_NUMBER,NOTES_SERVICE,NOTES_NOTES FROM octopus_patients_notes WHERE NOTES_PATIENTCODE = '$patientcode' AND NOTES_TYPE = '$type' AND  NOTES_INSTCODE = '$instcode' AND NOTES_STATUS = '1' ORDER BY NOTES_ID DESC ");
		return $list;
	}

	// 15 AUG 2024, JOSEPH ADORBOE 
	public function getpatientnotesdetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_notes WHERE NOTES_CODE = ? AND NOTES_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['NOTES_CODE'].'@@'.$obj['NOTES_NUMBER'].'@@'.$obj['NOTES_PATIENTCODE'].'@@'.$obj['NOTES_PATIENTNUMBER'].'@@'.$obj['NOTES_PATIENT'].'@@'.$obj['NOTES_VISITCODE']
			.'@@'.$obj['NOTES_AGE'].'@@'.$obj['NOTES_GENDER'].'@@'.$obj['NOTES_TYPE'].'@@'.$obj['NOTES_NOTES'].'@@'.$obj['NOTES_CONSULTATIONCODE'].'@@'.$obj['NOTES_SERVICECODE'].'@@'.$obj['NOTES_SERVICE'].'@@'.$obj['NOTES_DATE'];
		}else{
			$res = '0';
		}
		return $res;
	}

	// 06 MAY 2022
	public function getnotesnumber($instcode){
		$sql = "SELECT NOTES_NUMBER FROM octopus_patients_notes WHERE  NOTES_INSTCODE = '$instcode'  ORDER BY NOTES_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['NOTES_NUMBER'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 13 OCT 2023 JOSEPH ADORBOE
	public function getquerynotes($patientcode,$type,$instcode){		
		$list = ("SELECT * FROM octopus_patients_notes WHERE NOTES_PATIENTCODE = '$patientcode' AND NOTES_TYPE = '$type' AND  NOTES_INSTCODE = '$instcode' AND NOTES_STATUS = '1' ORDER BY NOTES_ID DESC ");
		return $list;
	}
	// 4 NOV 2023 JOSEPH ADORBOE
	public function getquerytypenotes($patientcode,$visitcode,$type,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' AND NOTES_VISITCODE = '$visitcode' AND NOTES_TYPE = '$type' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC ");
		return $list;
	}
	// 4 NOV 2023 JOSEPH ADORBOE
	public function getqueryhistorytypenotes($patientcode,$visitcode,$type,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' AND NOTES_VISITCODE != '$visitcode' AND NOTES_TYPE = '$type' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryhistorynotes($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' AND NOTES_VISITCODE != '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC ");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getquerylegacynotes($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode'  and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketnotes($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE = '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC");
		return $list;
	}
	public function getquerydoctornotesopd($patientcode,$instcode){		
		$list =  ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' and  NOTES_INSTCODE = '$instcode' AND NOTES_TYPE = 'OPD' and NOTES_STATUS = '1' order by NOTES_ID DESC  ");
		return $list;
	}
	// 6 JULY 2024, JOSEPH ADORBOE
	public function getqueryadmissionnoteshistory($patientcode,$visitcode,$instcode){		
		$list =  ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE != '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' AND NOTES_TYPE IN('ADMISSION','HANDOVER') order by NOTES_ID DESC limit 10 ");
		return $list;
	}
	// 6 JULY 2024, JOSEPH ADORBOE
	public function getqueryadmissionnotes($patientcode,$visitcode,$instcode){		
		$list =  ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE = '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' AND NOTES_TYPE IN('ADMISSION','HANDOVER') order by NOTES_ID DESC limit 10 ");
		return $list;
	}
	// 11 oct 2023,  2023 JOSEPH ADORBOE
	public function getquerydoctornotes($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_notes where NOTES_PATIENTCODE = '$patientcode' and NOTES_VISITCODE = '$visitcode' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' AND NOTES_TYPE = 'OPD' order by NOTES_ID DESC limit 10 ");
		return $list;
	}
	// 24 OCT 2023, 25 AUG 2023
	public function cancelconsultationnotes($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_notes SET NOTES_STATUS = ? WHERE NOTES_VISITCODE = ? AND NOTES_INSTCODE = ? ";
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
	// 18 Jan 2023 JOSEPH ADORBOE 
	public function getpatientdoctorsnotesdet($complainid,$patientcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_notes WHERE NOTES_CODE = ? AND NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_INSTCODE = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $complainid);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
	//	$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['NOTES_CODE'].'@'.$object['NOTES_NOTES'].'@'.$object['NOTES_TYPE'].'@'.$object['NOTES_NUMBER'].'@'.$object['NOTES_ACTOR'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	
	// 6 JULY 2024 JOSEPH ADORBOE 
	public function edit_patientnotes($ekey,$editpatienotes,$notestype,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_notes SET NOTES_NOTES = ? , NOTES_TYPE = ? , NOTES_ACTOR = ? , NOTES_ACTORCODE = ?  WHERE NOTES_CODE = ? AND NOTES_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $editpatienotes);
		$st->BindParam(2, $notestype);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 18 JAN 2023 JOSEPH ADORBOE 
	public function update_doctornotes($form_key,$days,$doctorsnotes,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $doctorsnotes);
		$st->BindParam(2, $form_key);
	//	$st->BindParam(3, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 6 JULY 2024 JOSEPH ADORBOE 
	public function update_notes($form_key,$patientnotes){
		$sql = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientnotes);
		$st->BindParam(2, $form_key);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 11 OCT 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientdoctorsnotes($notekey,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode){
	
		$one = 1;
		$sqlstmt = ("SELECT NOTES_ID FROM octopus_patients_notes where NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_CODE = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $notekey);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){	
				$sqlstmt = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ? AND NOTES_STATUS =  ? ";    
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $doctorsnotes);
                    $st->BindParam(2, $notekey);
                    $st->BindParam(3, $one);                   
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
				$st->BindParam(1, $notekey);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $doctorsnotes);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $notesrequestcode);
				$st->BindParam(15, $servicerequestedcode);
				$st->BindParam(16, $servicerequested);
				$st->BindParam(17, $types);
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

$patientsnotestable = new OctopusPatientsNotesSql();
?>