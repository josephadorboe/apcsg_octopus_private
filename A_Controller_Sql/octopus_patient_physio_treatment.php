<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 6 APR 2025 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patient_physio_treatment
	$patientvisittable = new OctopusPatientsVisitSql();
	$patientphysiotreatmenttable->getpatientphysiotreatmentdetails($patientcode,$instcode) ;
	$patientphysiotreatmenttable->newpatienttreatment($form_key,$treatmentnumber,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$servicescode,$servicesname,$pcomplain,$treatmentplan,$treatment,$currentusercode,$currentuser,$instcode)
*/

class OctopusPatientPhysioTreatmentSql Extends Engine{

	/// 8 MAY 2025, JOSEPH ADORBOE 
	public function getpatientphysiotreatmentdetail($editvalue,$instcode){
		$one = '1';
		$stmt = "SELECT PHT_CODE,PHT_NUMBER,PHT_PATIENTCODE,PHT_PATIENTNUMBER,PHT_PATIENT,PHT_GENDER,PHT_AGE,PHT_DATE,PHT_VISITCODE,PHT_SERVICECODE,PHT_SERVICE,PHT_PRESENTING,PHT_TREATMENTPLAN,PHT_TREATMENT,PHT_ACTOR,PHT_ACTORCODE FROM octopus_patient_physio_treatment WHERE PHT_CODE = ? AND PHT_INSTCODE = ? AND PHT_STATUS = ? order by PHT_ID DESC LIMIT 1";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $editvalue);
        $st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowCount() > intval(0)){
				$obj = $st->fetch(PDO::FETCH_ASSOC);			
				$res = $obj['PHT_PRESENTING'].'@@'.$obj['PHT_TREATMENTPLAN'].'@@'.$obj['PHT_TREATMENT'].'@@'.$obj['PHT_ACTOR'].'@@'.$obj['PHT_CODE'].'@@'.$obj['PHT_SERVICE']
				.'@@'.$obj['PHT_SERVICECODE'].'@@'.$obj['PHT_NUMBER'].'@@'.$obj['PHT_PATIENTCODE'].'@@'.$obj['PHT_PATIENTNUMBER'].'@@'.$obj['PHT_PATIENT'];
			}else{
				$res = Intval(0);
			}
			
		}else{
			$res = Intval(0);
		}
		return $res;
	}

	/// 8 MAY 2025, JOSEPH ADORBOE 
	public function getpatientphysiotreatmentdetails($patientcode,$instcode){
		$one = '1';
		$stmt = "SELECT PHT_CODE,PHT_NUMBER,PHT_PATIENTCODE,PHT_PATIENTNUMBER,PHT_PATIENT,PHT_GENDER,PHT_AGE,PHT_DATE,PHT_VISITCODE,PHT_SERVICECODE,PHT_SERVICE,PHT_PRESENTING,PHT_TREATMENTPLAN,PHT_TREATMENT,PHT_ACTOR,PHT_ACTORCODE FROM octopus_patient_physio_treatment WHERE PHT_PATIENTCODE = ? AND PHT_INSTCODE = ? AND PHT_STATUS = ? order by PHT_ID DESC LIMIT 1";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowCount() > intval(0)){
				$obj = $st->fetch(PDO::FETCH_ASSOC);			
				$res = $obj['PHT_PRESENTING'].'@@'.$obj['PHT_TREATMENTPLAN'].'@@'.$obj['PHT_TREATMENT'].'@@'.$obj['PHT_ACTOR'].'@@'.$obj['PHT_CODE'].'@@'.$obj['PHT_SERVICE']
				.'@@'.$obj['PHT_SERVICECODE'].'@@'.$obj['PHT_NUMBER'].'@@'.$obj['PHT_PATIENTCODE'].'@@'.$obj['PHT_PATIENTNUMBER'].'@@'.$obj['PHT_PATIENT'];
			}else{
				$res = Intval(0);
			}
		}else{
			$res = Intval(0);
		}
		return $res;
	}

	// 6 APR 2025 JOSEPH ADORBOE 
	public function updatepatienttreatment($ekey,$pcomplain,$treatmentplan,$treatment,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patient_physio_treatment SET PHT_PRESENTING = ?,  PHT_TREATMENTPLAN = ?, PHT_TREATMENT =?  WHERE PHT_CODE = ? AND PHT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $pcomplain);
		$st->BindParam(2, $treatmentplan);
		$st->BindParam(3, $treatment);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);		
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function querygetphysiotreatment( String $patientcode, String $instcode) : String {		
		$list = ("SELECT PHT_CODE,PHT_NUMBER,PHT_PATIENTCODE,PHT_PATIENTNUMBER,PHT_PATIENT,PHT_GENDER,PHT_AGE,PHT_DATE,PHT_VISITCODE,PHT_SERVICECODE,PHT_SERVICE,PHT_PRESENTING,PHT_TREATMENTPLAN,PHT_TREATMENT,PHT_ACTOR from octopus_patient_physio_treatment where PHT_PATIENTCODE = '$patientcode' and PHT_INSTCODE = '$instcode' order by PHT_DATE DESC ");
		return $list;
	}
	
	// 6 APR 2025 JOSEPH ADORBOE
	public function newpatienttreatment($form_key,$treatmentnumber,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$pcomplain,$treatmentplan,$treatment,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$day = date('Y-m-d');		
		$sqlstmt = "INSERT INTO octopus_patient_physio_treatment(PHT_CODE,PHT_NUMBER,PHT_PATIENTCODE,PHT_PATIENTNUMBER,PHT_PATIENT,PHT_GENDER,PHT_AGE,PHT_DATE,PHT_VISITCODE,PHT_SERVICECODE,PHT_SERVICE,PHT_PRESENTING,PHT_TREATMENTPLAN,PHT_TREATMENT,PHT_ACTOR,PHT_ACTORCODE,PHT_INSTCODE) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $treatmentnumber);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $gender);
		$st->BindParam(7, $age);
		$st->BindParam(8, $days);
		$st->BindParam(9, $visitcode);
		$st->BindParam(10, $servicescode);
		$st->BindParam(11, $servicesname);
		$st->BindParam(12, $pcomplain);
		$st->BindParam(13, $treatmentplan);
		$st->BindParam(14, $treatment);
		$st->BindParam(15, $currentuser);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $instcode);		
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	

	}
	
} 
$patientphysiotreatmenttable = new OctopusPatientPhysioTreatmentSql();
?>