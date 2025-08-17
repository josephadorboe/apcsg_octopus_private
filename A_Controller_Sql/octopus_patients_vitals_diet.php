<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 13 Oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_vitals_diet
	$patientsvitalsdiettable = new OctopusVitalsDietSql();
*/

class OctopusVitalsDietSql Extends Engine{
	// 13 oct 2023 JOSEPH ADORBOE
	public function getquerydietvitals($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_vitals_diet WHERE VID_PATIENTCODE = '$patientcode' AND  VID_INSTCODE = '$instcode' AND VID_VISITCODE = '$visitcode' AND VID_STATUS = '1' ORDER BY VID_ID DESC ");
		return $list;
	}
	// 13 oct 2023,  12 JUNE 2023 JOSEPH ADORBOE 
	public function update_patientdietvitals($ekey,$days,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_vitals_diet SET VID_BOBYFAT = ? ,VID_MUSCLEMASS = ? ,VID_HEIGHT = ? ,VID_WEIGHT = ? ,VID_VISCERALFAT = ? ,VID_BMI = ? ,VID_METABOLICRATE = ? ,VID_HIP = ? ,VID_WAIST = ? ,VID_HIPTOWAIST = ? WHERE VID_CODE = ? AND VID_STATUS =  ? AND VID_INSTCODE = ?";    
		$st = $this->db->prepare($sqlstmt); 
		$st->BindParam(1, $bodyfat);
		$st->BindParam(2, $musclefat);
		$st->BindParam(3, $height);
		$st->BindParam(4, $weight);
		$st->BindParam(5, $visceralfat);
		$st->BindParam(6, $bmi);
		$st->BindParam(7, $metabolicrate);
		$st->BindParam(8, $hipcircumfernce);
		$st->BindParam(9, $waistcircumfernce);
		$st->BindParam(10, $waisthips);  
		$st->BindParam(11, $ekey);
		$st->BindParam(12, $one);
		$st->BindParam(13, $instcode);                                  
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}


	// 12 JUNE 2023  JOSEPH ADORBOE
	public function insert_patientdietvitals($form_key,$days,$visitcode,$age,$gender,$patientcode, $patientnumber,$patient,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$vitalsnumber,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
		$one = 1;
		$sqlstmt = "INSERT INTO octopus_patients_vitals_diet(VID_CODE,VID_NUMBER,VID_DATE,VID_PATIENTCODE,VID_PATIENTNUMBER,VID_PATIENT,VID_VISITCODE,VID_AGE,VID_GENDER,VID_ACTOR,VID_ACTORCODE,VID_INSTCODE,VID_BOBYFAT,VID_MUSCLEMASS,VID_HEIGHT,VID_WEIGHT,VID_VISCERALFAT,VID_BMI,VID_METABOLICRATE,VID_HIP,VID_WAIST,VID_HIPTOWAIST,VID_SHIFT,VID_SHIFTCODE,VID_DAY,VID_MONTH,VID_YEAR) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $vitalsnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $age);
		$st->BindParam(9, $gender);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$st->BindParam(12, $instcode);
		$st->BindParam(13, $bodyfat);
		$st->BindParam(14, $musclefat);
		$st->BindParam(15, $height);
		$st->BindParam(16, $weight);
		$st->BindParam(17, $visceralfat);
		$st->BindParam(18, $bmi);
		$st->BindParam(19, $metabolicrate);
		$st->BindParam(20, $hipcircumfernce);
		$st->BindParam(21, $waistcircumfernce);
		$st->BindParam(22, $waisthips);
		$st->BindParam(23, $currentshift);  
		$st->BindParam(24, $currentshiftcode);  
		$st->BindParam(25, $currentday);  
		$st->BindParam(26, $currentmonth);  
		$st->BindParam(27, $currentyear);                 
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}					
			
	}

	
} 
$patientsvitalsdiettable = new OctopusVitalsDietSql();
?>