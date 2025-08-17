<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 15 MAY 2024, 
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_patients_nurse_notes
	$patientnuresnotestable->getqueryservicebasketnursenotesinsert_addnewnotes($form_key,$notenumber,$days,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$nursenotes,$currentusercode,$currentuser,$instcode)
	
	
*/

class OctopusPatientNurseNotesSql Extends Engine{
	// 17 MAY 2024 JOSEPH ADORBOE
	public function getquerytnursenotes($instcode){
		$day = date('Y-m-d');
	//	$noteday = date('Y-m-d', strtotime($day. ' - 1 days'));		
		$list = ("SELECT NN_NUMBER,NN_CODE,NN_PATIENTCODE,NN_PATIENTNUMBER,NN_PATIENT,NN_DATE,NN_ACTORCODE,NN_ACTOR,NN_NOTES FROM octopus_patients_nurse_notes WHERE NN_INSTCODE = '$instcode' AND DATE(NN_DATE) = '$day' ORDER BY NN_ID DESC");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketnursenotes($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_nurse_notes where NN_PATIENTCODE = '$patientcode' and NN_VISITCODE = '$visitcode' and NN_INSTCODE = '$instcode' and NN_STATUS = '1' order by NN_ID DESC");
		return $list;
	}
	// 15 MAY 2024 JOSEPH ADORBOE
	public function getquerypatientnursenotes($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_nurse_notes WHERE NN_INSTCODE = '$instcode' AND NN_PATIENTCODE = '$idvalue' ORDER BY NN_ID DESC");
		return $list;
	}
	// 15 MAY 2024,  JOSEPH ADORBOE
    public function update_nursenotes($ekey,$nursenotes,$currentusercode,$currentuser,$instcode){
		$day = date('Y-m-d H:i:s');
		$sqlstmt = "UPDATE octopus_patients_nurse_notes SET NN_NOTES = ?, NN_ACTOR = ?, NN_ACTORCODE = ?, NN_DATE = ? WHERE NN_CODE = ? AND NN_INSTCODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $nursenotes);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->Bindparam(4, $day);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 15 MAY 2024  JOSEPH ADORBOE
	public function insert_addnewnotes($form_key,$notenumber,$days,$visitcode,$patientcode,$patientnumber,$patient,$age,$gender,$nursenotes,$currentusercode,$currentuser,$instcode){
				
		$sqlstmt = "INSERT INTO octopus_patients_nurse_notes(NN_CODE,NN_NUMBER,NN_DATE,NN_PATIENTCODE,NN_PATIENTNUMBER,NN_PATIENT,NN_VISITCODE,NN_AGE,NN_GENDER,NN_NOTES,NN_INSTCODE,NN_ACTOR,NN_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $notenumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $age);
		$st->BindParam(9, $gender);
		$st->BindParam(10, $nursenotes);
		$st->BindParam(11, $instcode);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $currentusercode);		
		$exe = $st->execute();			
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	
}
$patientnuresnotestable =  new OctopusPatientNurseNotesSql();
?>
