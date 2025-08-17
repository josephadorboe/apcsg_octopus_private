<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 8 AUG 2023, 29 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	Based ON : octopus_patients_appointments
	$patientappointmenttable->querygetappointmentbooked($instcode) = new OctopusPatientsAppointmentSql;
	
*/

class OctopusPatientsAppointmentSql Extends Engine{	

	// 9 JUNE 2025, JOSEPH ADORBOE 
	public function querygetappointmentbooked($instcode){
		$list = "SELECT APP_CODE,APP_DATE,APP_PATIENTCODE,APP_PATIENTNUMBER,APP_PATIENT,APP_PHONE,APP_TIMECODE,APP_STARTTIME,APP_ENDTIME,APP_DOCTOR,APP_DOCTORCODE,APP_ACTOR,APP_ACTORCODE,APP_INSTCODE,APP_GENDER,APP_AGE from octopus_patients_appointments where APP_STATUS = '1' and APP_INSTCODE = '$instcode' and  APP_ENDTIME >= '$this->thedays' order by APP_DATE ";
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getqueryappointment($instcode){		
		$list = ("SELECT APP_CODE,APP_DATE,APP_PATIENTCODE,APP_PATIENTNUMBER,APP_PATIENT,APP_PHONE,APP_TIMECODE,APP_STARTTIME,APP_ENDTIME,APP_DOCTOR,APP_DOCTORCODE,APP_ACTOR,APP_ACTORCODE,APP_INSTCODE,APP_GENDER,APP_AGE FROM octopus_patients_appointments WHERE APP_STATUS = '$this->theone' AND APP_INSTCODE = '$instcode' AND  APP_ENDTIME >= '$this->thedays' ORDER BY APP_DATE ");
		return $list;
	}
	// 2 SEPT 2023, 20 APR 2021 JOSEPH ADORBOE 
	public function updatepatientnumberappointments($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$zero = $this->thezero;
		$sql = "UPDATE octopus_patients_appointments SET APP_PATIENTNUMBER = ?,  APP_ACTOR = ?, APP_ACTORCODE =?  WHERE APP_PATIENTCODE = ? AND APP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);		
		$exe = $st->execute();							
		if($exe){								
			return $this->thetwo;								
		}else{								
			return $this->thezero;								
		}	
	}
	
	// 9 AUG 2023
	public function updateappointment($appcode){
		$sql = "UPDATE octopus_patients_appointments SET APP_STATUS = ? WHERE APP_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thetwo);
		$st->BindParam(2, $appcode);
		$exe = $st->execute();	
		if($exe){
			return $this->thetwo;
		}else{
			return $this->thezero;
		}
	}
	// 2 SEPT 2023, 20 APR 2021,  JOSEPH ADORBOE
    public function newpatientappointment($form_key,$patientcode,$patientnumbers,$patient,$phone,$appcode,$appstart,$append,$appdoccode,$appdocname,$age,$gender,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT APP_ID FROM octopus_patients_appointments where APP_PATIENTCODE = ? and APP_TIMECODE = ?  and APP_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $appcode);
		$st->BindParam(3, $this->theone);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return $this->theone;			
			}else{				
				$sqlstmt = "INSERT INTO octopus_patients_appointments(APP_CODE,APP_DATE,APP_PATIENTCODE,APP_PATIENTNUMBER,APP_PATIENT,APP_PHONE,APP_TIMECODE,APP_STARTTIME,APP_ENDTIME,APP_DOCTOR,APP_DOCTORCODE,APP_ACTOR,APP_ACTORCODE,APP_INSTCODE,APP_GENDER,APP_AGE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $appstart);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumbers);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $phone);
				$st->BindParam(7, $appcode);
				$st->BindParam(8, $appstart);
				$st->BindParam(9, $append);
				$st->BindParam(10, $appdocname);
				$st->BindParam(11, $appdoccode);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $gender);
				$st->BindParam(16, $age);				
				$exe = $st->execute();				
				if($exe){
					return $this->thetwo;					
				}else{					
					return $this->thezero;
				}
			}			
		}else{
			return $this->thezero;
		}	
	}
	// 2 SEPT 2023, 20 APR 2021 JOSEPH ADORBOE 
	public function cancelledappointment($ekey,$cancelreason,$currentuser,$currentusercode,$instcode){
		$zero = $this->thezero;
		$sql = "UPDATE octopus_patients_appointments SET APP_STATUS = ?,  APP_ACTOR = ?, APP_ACTORCODE =? ,APP_CANCELREASON = ? WHERE APP_CODE = ? AND APP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $cancelreason);	
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);		
		$exe = $st->execute();							
		if($exe){								
			return $this->thetwo;								
		}else{								
			return $this->thezero;								
		}	
	}
	
} 
$patientappointmenttable = new OctopusPatientsAppointmentSql;
?>