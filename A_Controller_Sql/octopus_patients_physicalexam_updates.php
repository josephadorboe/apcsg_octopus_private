<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 19 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_physicalexam_updates
	$physicalexamsupdatestable =  new OctopusPatientsPhysicalexamsUpdatesSql();
*/

class OctopusPatientsPhysicalexamsUpdatesSql Extends Engine{
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getqueryphysicalexamsupdates($primarycode,$instcode){		
		$list = ("SELECT * from octopus_patients_physicalexam_updates where PHE_PRIMARYCODE = '$primarycode' and PHE_INSTCODE = '$instcode' and PHE_STATUS = '1' order by PHE_ID DESC");
		return $list;
	}
	// 5 OCT 2023 
	public function getphysicalexamsupdatecount($instcode,$ekey)
	{
		$sql = "SELECT PHE_ID FROM octopus_patients_physicalexam_updates WHERE PHE_INSTCODE = '$instcode' AND PHE_PRIMARYCODE = '$ekey' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$count  = $st->rowCount();		
		return $count;      
	}
	
	// 5 oct 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_addpatientphysicalexamsupdates($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldexamcode,$oldexam,$oldnotes,$updatenumber,$ekey,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "INSERT INTO octopus_patients_physicalexam_updates(PHE_CODE,PHE_DATE,PHE_PATIENTCODE,PHE_PATIENTNUMBER,PHE_PATIENT,PHE_CONSULTATIONCODE,PHE_AGE,PHE_GENDER,PHE_VISITCODE,PHE_EXAMCODE,PHE_EXAMNAME,PHE_EXAMNOTES,PHE_ACTOR,PHE_ACTORCODE,PHE_INSTCODE,PHE_PRIMARYCODE,PHE_UPDATENUMBER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
		$st->BindParam(10, $oldexamcode);
		$st->BindParam(11, $oldexam);
		$st->BindParam(12, $oldnotes);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $ekey);
		$st->BindParam(17, $updatenumber);
		$exe = $st->execute();								
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}			
	}
	
} 

$physicalexamsupdatestable =  new OctopusPatientsPhysicalexamsUpdatesSql();
?>