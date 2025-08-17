<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 12 OCT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_notes_updates
	$patientsnotesupdatestable = new OctopusPatientsNotesUpdatesSql();
*/

class OctopusPatientsNotesUpdatesSql Extends Engine{
	// 12 OCT 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_patients_notes_updates WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 12 OCT 2023 JOSEPH ADORBOE
	public function getquerynotesupdates($patientcode,$primarykey,$instcode){
		$list = ("SELECT * from octopus_patients_notes_updates where NOTES_PATIENTCODE = '$patientcode' and NOTES_PRIMARYKEY = '$primarykey' and NOTES_INSTCODE = '$instcode' and NOTES_STATUS = '1' order by NOTES_ID DESC  ");
		return $list;
	}
	// 12 OCT 2023 
	public function getnotesupdatecount($instcode,$ekey)
	{
		$sql = "SELECT NOTES_ID FROM octopus_patients_notes_updates WHERE NOTES_INSTCODE = '$instcode' AND NOTES_PRIMARYKEY = '$ekey' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$count  = $st->rowCount();		
		return $count;      
	}

	// 11 OCT 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientdoctorsnotesupdates($notekey,$days,$notenumber,$notestype,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldnotes,$currentusercode,$currentuser,$instcode,$updatenumber,$form_key){	
		$sqlstmt = "INSERT INTO octopus_patients_notes_updates(NOTES_CODE,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_VISITCODE,NOTES_NOTES,NOTES_ACTOR,NOTES_ACTORCODE,NOTES_INSTCODE,NOTES_NUMBER,NOTES_SERVICECODE,NOTES_SERVICE,NOTES_TYPE,NOTES_PRIMARYKEY,NOTES_UPDATESNUMBER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
		$st->BindParam(10, $oldnotes);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $notenumber);
		$st->BindParam(15, $servicerequestedcode);
		$st->BindParam(16, $servicerequested);
		$st->BindParam(17, $notestype);
		$st->BindParam(18, $notekey);
		$st->BindParam(19, $updatenumber);
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}		
	}

	
} 
$patientsnotesupdatestable = new OctopusPatientsNotesUpdatesSql();
?>