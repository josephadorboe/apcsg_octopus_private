<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 7 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_diagnosis_updates
	$diagnosisupdatestable =  new OctopuspatientdiagnosisupdatesSql();
*/

class OctopuspatientdiagnosisupdatesSql Extends Engine{
	// 7 oct 2023 JOSEPH ADORBOE
	public function getquerydiagnosisupdates($patientcode,$primarykey,$instcode){
		$list = ("SELECT * from octopus_patients_diagnosis_updates where DIA_PATIENTCODE = '$patientcode' and DIA_PRIMARYKEY = '$primarykey' and DIA_INSTCODE = '$instcode' and DIA_STATUS = '1' order by DIA_ID DESC  ");
		return $list;
	}
	// 6 OCT 2023 
	public function getdiagnosisupdatecount($instcode,$ekey)
	{
		$sql = "SELECT DIA_ID FROM octopus_patients_diagnosis_updates WHERE DIA_INSTCODE = '$instcode' AND DIA_PRIMARYKEY = '$ekey' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$count  = $st->rowCount();		
		return $count;      
	}
	// 7 oct 2023, 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientdiagnosisupdates($form_key,$ekey,$updatenumber,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$olddiagnosiscode,$olddiagnosis,$diagnosistype,$oldstoryline,$currentusercode,$currentuser,$instcode){

		$sqlstmt = "INSERT INTO octopus_patients_diagnosis_updates(DIA_CODE,DIA_DATE,DIA_PATIENTCODE,DIA_PATIENTNUMBER,DIA_PATIENT,DIA_CONSULTATIONCODE,DIA_AGE,DIA_GENDER,DIA_VISITCODE,DIA_DIAGNOSISCODE,DIA_DIAGNOSIS,DIA_REMARK,DIA_ACTOR,DIA_ACTORCODE,DIA_INSTCODE,DIA_DIAGNOSISTYPE,DIA_PRIMARYKEY,DIA_UPDATENUMBER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
		$st->BindParam(10, $olddiagnosiscode);
		$st->BindParam(11, $olddiagnosis);
		$st->BindParam(12, $oldstoryline);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $diagnosistype);
		$st->BindParam(17, $ekey);
		$st->BindParam(18, $updatenumber);
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}		
	
	}
	
	
} 
$diagnosisupdatestable =  new OctopuspatientdiagnosisupdatesSql();
?>