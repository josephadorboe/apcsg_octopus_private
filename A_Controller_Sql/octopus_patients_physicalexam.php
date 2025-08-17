<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 19 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_physicalexam
	$physicalexamstable->getphysicalexamrequesteddetails($requestcode,$instcode);
	 = new OctopusPatientsPhysicalexamsSql();
*/

class OctopusPatientsPhysicalexamsSql Extends Engine{
	// 15 AUG 2024, JOSEPH ADORBOE 
	public function getphysicalexamrequesteddetails($requestcode,$instcode){
		$one  = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_physicalexam WHERE PHE_CODE = ? AND PHE_INSTCODE = ? ORDER BY PHE_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PHE_EXAMCODE'].'@'.$object['PHE_EXAMNAME'].'@'.$object['PHE_EXAMNOTES'].'@'.$object['PHE_CODE'].'@'.$object['PHE_CONSULTATIONCODE'].'@'.$object['PHE_GENDER'].'@'.$object['PHE_AGE'].'@'.$object['PHE_VISITCODE'].'@'.$object['PHE_PATIENTCODE'].'@'.$object['PHE_PATIENTNUMBER'].'@'.$object['PHE_PATIENT'].'@'.$object['PHE_DATE'];				
			}else{
				$results = '1';
			}
		}else{
			$results = '1';
		}			
		return $results;
	}

	// 5 Oct 2023 JOSEPH ADORBOE
	public function getqueryphysicalexamhistory($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_physicalexam where PHE_PATIENTCODE = '$patientcode' and PHE_VISITCODE != '$visitcode' and PHE_INSTCODE = '$instcode'  order by PHE_STATUS DESC , PHE_ID DESC ");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerylegacyphysicalexams($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_physicalexam where PHE_PATIENTCODE = '$patientcode' and PHE_INSTCODE = '$instcode'  order by PHE_STATUS DESC , PHE_ID DESC");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketphysicalexam($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_physicalexam where PHE_PATIENTCODE = '$patientcode' and PHE_VISITCODE = '$visitcode' and PHE_INSTCODE = '$instcode'  order by PHE_STATUS DESC , PHE_ID DESC ");
		return $list;
	}
	// 24 oct 2023, 
	public function cancelconsultationphysicalexam($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_physicalexam SET PHE_STATUS = ?  WHERE PHE_VISITCODE = ? and PHE_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 5 oct 2023, 
	public function update_removepatientphysicalexams($ekey,$days,$removereason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one = '1';
		$sql = "UPDATE octopus_patients_physicalexam SET PHE_STATUS = ?, PHE_CANCEL = ? , PHE_CANCELREASON = ? , PHE_CANCELACTORCODE = ?,  PHE_CANCELACTOR = ?, PHE_CANCELTIME = ? WHERE PHE_CODE = ? and PHE_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $one);
		$st->BindParam(3, $removereason);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $days);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 5 oct 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_addpatientphysicalexams($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$physicalexamcode,$physicalexam,$storyline,$currentusercode,$currentuser,$instcode){
	
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
					return '2';								
				}else{								
					return '0';								
				}				
			}
		}else{
			return '0';
		}	
	}
	// 5 oct 2023, 
	public function update_patientphysicalexams($ekey,$days,$physicalexamcode,$physicalexamname,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_physicalexam SET PHE_DATE = ?, PHE_EXAMCODE = ?,  PHE_EXAMNAME = ?, PHE_EXAMNOTES =? , PHE_ACTORCODE = ?, PHE_ACTOR = ? WHERE PHE_CODE = ? AND PHE_INSTCODE =?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $physicalexamcode);
		$st->BindParam(3, $physicalexamname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
} 
$physicalexamstable = new OctopusPatientsPhysicalexamsSql();
?>