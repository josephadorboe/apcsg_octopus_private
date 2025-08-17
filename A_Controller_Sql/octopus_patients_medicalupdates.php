<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 JULY 2024, 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_medicalupdates
	$octopuspatientsmedicalupdatestable->getupdatelist($admissioncode,$instcode);
	$_COOKIE = new OctopusPatientsCreditsSql();
*/

class OctopusPatientsMedicalupdatesSql Extends Engine{
	// 05 JULY 2024, JULY 2024,
	public function getupdatelist($admissioncode,$instcode){		
		$list = ("SELECT * from octopus_patients_medicalupdates where PU_UPDATECODE = '$admissioncode' AND PU_INSTCODE = '$instcode' Order By PU_UPDATESERIAL DESC ");
		return $list;
	}
	// 05 JULY 2024, JULY 2024, 
	public function getupdateserial($admissioncode,$instcode){
		$sqlstmt = ("SELECT PU_ID FROM octopus_patients_medicalupdates WHERE PU_UPDATECODE = ? AND PU_INSTCODE = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $admissioncode);
        $st->BindParam(2, $instcode);
        $details =	$st->execute();
        if ($details) {
			return $st->rowcount() + 1;            
        } else {
            return '0';
        }
	}
	// 05 JULY 2024 JOSEPH ADORBOE 
	public function insertnewmedicalupdate($keyupdatecode,$updatenumber,$patientcode,$patientnumber,$patient,$patientgender,$patientage,$days,
	$updatetype,$updateserial,$updatecode,$updatevisitcode,$updatenotes,$updatenotesactor,$updatedate,$currentusercode,$currentuser,$instcode){
		$sql = "INSERT INTO octopus_patients_medicalupdates (PU_CODE,PU_NUMBER,PU_PATIENTCODE,PU_PATIENT,PU_PATIENTNUMBER,PU_GENDER
		,PU_AGE,PU_DATETIME,PU_TYPE,PU_UPDATESERIAL,PU_UPDATECODE,PU_UPDATEVISITCODE,PU_UPDATENOTES,PU_UPDATEACTOR,PU_UPDATEDATE,PU_ACTORCODE,
		PU_ACTOR,PU_INSTCODE) VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $keyupdatecode);
		$st->BindParam(2, $updatenumber);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patientgender);
		$st->BindParam(7, $patientage);
		$st->BindParam(8, $days);
		$st->BindParam(9, $updatetype);
		$st->BindParam(10, $updateserial);				
		$st->BindParam(11, $updatecode);
		$st->BindParam(12, $updatevisitcode);
		$st->BindParam(13, $updatenotes);
		$st->BindParam(14, $updatenotesactor);
		$st->BindParam(15, $updatedate);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $currentuser);
		$st->BindParam(18, $instcode);		
		$exe = $st->execute();	
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}				
	}
	
}
$octopuspatientsmedicalupdatestable = new OctopusPatientsMedicalupdatesSql(); 
?>