<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 8 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_complains_updates
	$patientcomplainsupdatestable = new OctopuspatientcomplainsupdateSql();
*/

class OctopuspatientcomplainsupdateSql Extends Engine{
	// 8 oct 2023 JOSEPH ADORBOE
	public function getquerycomplainsupdates($patientcode,$primarykey,$instcode){		
		$list = ("SELECT * from octopus_patients_complains_updates where PPC_PATIENTCODE = '$patientcode' and PPC_PRIMARYKEY = '$primarykey' and PPC_INSTCODE = '$instcode' and PPC_STATUS = '1' order by PPC_ID DESC");
		return $list;
	}
	// 6 OCT 2023 
	public function getcomplainsupdatecount($instcode,$ekey)
	{
		$sql = "SELECT PPC_ID FROM octopus_patients_complains_updates WHERE PPC_INSTCODE = '$instcode' AND PPC_PRIMARYKEY = '$ekey' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$count  = $st->rowCount();		
		return $count;      
	}

	// 8 Oct 2023,  24 MAR 2021,  JOSEPH ADORBOE
    public function insert_newpatientcomplainsupdates($form_key,$updatenumber,$ekey,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$oldcomplaincode,$oldcomplain,$oldstoryline,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "INSERT INTO octopus_patients_complains_updates(PPC_CODE,PPC_DATE,PPC_PATIENTCODE,PPC_PATIENTNUMBER,PPC_PATIENT,PPC_CONSULTATIONCODE,PPC_AGE,PPC_GENDER,PPC_VISITCODE,PPC_COMPLAINCODE,PPC_COMPLAIN,PPC_HISTORY,PPC_ACTOR,PPC_ACTORCODE,PPC_INSTCODE,PPC_UPDATENUMBER,PPC_PRIMARYKEY) 
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
		$st->BindParam(10, $oldcomplaincode);
		$st->BindParam(11, $oldcomplain);
		$st->BindParam(12, $oldstoryline);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $updatenumber);
		$st->BindParam(17, $ekey);
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}		
	}

	
} 
$patientcomplainsupdatestable = new OctopuspatientcomplainsupdateSql();
?>