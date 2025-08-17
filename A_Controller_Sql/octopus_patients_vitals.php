<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 18 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_vitals
	$patientvitalstable->querygetphysiovitals($patientcode,$instcode)
*/

class OctopusPatientsVitalsSql Extends Engine{

	// 6 APR 2025, JOSPEH ADORBOE 
	public function querygetphysiovitals($patientcode,$instcode){
		$list = ("SELECT VID_DATE,VID_BP,VID_TEMPERATURE,VID_HEIGHT,VID_WEIGHT,VID_PULSE,VID_SPO2 from octopus_patients_vitals  where VIS_STATUS = '1' AND VID_INSTCODE = '$instcode' and VID_PATIENTCODE = '$patientcode' order by VID_ID DESC LIMIT 10 ");
		return $list;		
	}
	

	// 15 AUG 2024, JOSEPH ADORBOE 
	public function getvitalsrequesteddetails($requestcode,$instcode){
		$one  = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_vitals WHERE VID_CODE = ? AND VID_INSTCODE = ? AND VIS_STATUS = ? ORDER BY VID_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['VID_BP'].'@'.$object['VID_TEMPERATURE'].'@'.$object['VID_HEIGHT'].'@'.$object['VID_WEIGHT'].'@'.$object['VID_FBS'].'@'.$object['VID_RBS'].'@'.$object['VID_GLUCOSE'].'@'.$object['VID_PULSE'].'@'.$object['VID_SPO2'].'@'.$object['VID_REMARKS'].'@'.$object['VID_CODE'].'@'.$object['VID_ACTOR'];				
			}else{
				$results = '1';
			}

		}else{
			$results = '1';
		}
			
		return $results;
	}
	// 6 JUKY 2024,  JOSEPH ADORBOE
	public function getquerypatientvitalshistory($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_vitals where VID_PATIENTCODE = '$patientcode' and VID_VISITCODE != '$visitcode' and VID_INSTCODE = '$instcode' and VIS_STATUS = '1' order by VID_ID DESC ");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientvitalstoday($instcode){	
		$day = date("Y-m-d");	
		$list = ("SELECT * FROM octopus_patients_vitals WHERE VID_INSTCODE = '$instcode' AND DATE(VID_DATE) = '$day' ORDER BY VID_ID DESC");
		return $list;
	}
	// 15 AUG 2023, JOSEPH ADORBOE
	public function selectvitals($patientcode,$instcode){
		$list = ("SELECT * from octopus_patients_vitals  where VIS_STATUS = '1' AND VID_INSTCODE = '$instcode' and VID_PATIENTCODE = '$patientcode' order by VID_ID DESC ");										
		return $list;
	}	
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientvitalsservicebasket($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_vitals where VID_PATIENTCODE = '$patientcode' and VID_VISITCODE = '$visitcode' and VID_INSTCODE = '$instcode' and VIS_STATUS = '1' order by VID_ID DESC ");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getquerypatientvitals($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_vitals WHERE VID_INSTCODE = '$instcode' AND VID_PATIENTCODE = '$idvalue' ORDER BY VID_ID DESC");
		return $list;
	}
	// 24 APR 2024, 18 FEB 2021 JOSEPH ADORBOE 
	public function getpatientvitalsstatus($patientcode,$visitcode,$dept,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_vitals where VID_PATIENTCODE = ? and VID_VISITCODE = ? and VID_DEPT = ? and VID_INSTCODE = ? ");
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $dept);
		$st->BindParam(4, $instcode);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > 0){
				return '1';
			}else{
				return '2';
			}
		}else{
			return '0';
		}
	}
	// 24 oct 2023, 
	public function cancelconsultationvitals($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_vitals SET VIS_STATUS = ?  WHERE VID_VISITCODE = ? and VID_INSTCODE = ? ";
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
	// 24 APR 2024, 20 FEB 2021
	public function update_vitals($ekey,$bp,$temperature,$height,$weight,$remarks,$fbs,$rbs,$glucosetest,$pulse,$currentusercode,$currentuser,$spo){	

		$sqlstmt = "UPDATE octopus_patients_vitals SET VID_BP = ?, VID_TEMPERATURE = ?, VID_HEIGHT = ?, VID_WEIGHT = ? , VID_FBS = ?, VID_RBS = ?, VID_GLUCOSE = ? , VID_REMARKS = ? , VID_ACTOR = ? , VID_ACTORCODE = ?, VID_PULSE = ? , VID_SPO2 = ?  where VID_CODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $bp);
		$st->BindParam(2, $temperature);
		$st->BindParam(3, $height);
		$st->Bindparam(4, $weight);
		$st->BindParam(5, $fbs);
		$st->BindParam(6, $rbs);
		$st->BindParam(7, $glucosetest);
		$st->BindParam(8, $remarks);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $pulse);
		$st->BindParam(12, $spo);
		$st->BindParam(13, $ekey);				
		$ext = $st->execute();
		if($ext){
			return '2';
		}else{
			return '1';
		}
			
	}
	// 22 APR 2022 18 MAR 2021 JOSEPH ADORBOE 
	public function getpatientvitals($patientcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_vitals WHERE VID_PATIENTCODE = ? AND VID_VISITCODE = ? AND VID_INSTCODE = ? AND VIS_STATUS = ? ORDER BY VID_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['VID_BP'].'@'.$object['VID_TEMPERATURE'].'@'.$object['VID_HEIGHT'].'@'.$object['VID_WEIGHT'].'@'.$object['VID_FBS'].'@'.$object['VID_RBS'].'@'.$object['VID_GLUCOSE'].'@'.$object['VID_PULSE'].'@'.$object['VID_SPO2'].'@'.$object['VID_REMARKS'].'@'.$object['VID_CODE'].'@'.$object['VID_ACTOR'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '1';
		}
			
	}	
	// 1 oct 2023, 25 JULY 2021   JOSEPH ADORBOE
	public function updatepatientrbsvitals($ekey,$rbs){		
		$sqlstmt = "UPDATE octopus_patients_vitals SET VID_RBS = ?  where VID_CODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $rbs);
		$st->BindParam(2, $ekey);
		$ext = $st->execute();
		if ($ext) {
			return '2';
		} else {
			return '0';
		}
	}

	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientvitals($bp,$temperature,$height,$weight,$fbs,$rbs,$glucosetest,$remarks,$currentuser,$currentusercode,$pulse,$spo,$vitalscode,$instcode){
		$one  = 1;
		$two = 2;
		$sqlstmt = "UPDATE octopus_patients_vitals SET VID_BP = ?, VID_TEMPERATURE = ?, VID_HEIGHT = ?, VID_WEIGHT = ? , VID_FBS = ?, VID_RBS = ?, VID_GLUCOSE = ? , VID_REMARKS = ? , VID_ACTOR = ? , VID_ACTORCODE = ?, VID_PULSE = ? , VID_SPO2 = ?  where VID_CODE = ? AND VID_INSTCODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $bp);
		$st->BindParam(2, $temperature);
		$st->BindParam(3, $height);
		$st->Bindparam(4, $weight);
		$st->BindParam(5, $fbs);
		$st->BindParam(6, $rbs);
		$st->BindParam(7, $glucosetest);
		$st->BindParam(8, $remarks);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $pulse);
		$st->BindParam(12, $spo);
		$st->BindParam(13, $vitalscode);
		$st->BindParam(14, $instcode);	
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 18 SEPT 2023, 18 FEB 2021   JOSEPH ADORBOE
	public function insert_newpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear){
				
		$sqlstmt = "INSERT INTO octopus_patients_vitals(VID_CODE,VID_PATIENTCODE,VID_PATIENTNUMBER,VID_PATIENT,VID_VISITCODE,VID_AGE,VID_GENDER,VID_BP,VID_TEMPERATURE,VID_HEIGHT,VID_WEIGHT,VID_REMARKS,VID_DEPT,VID_ACTOR,VID_ACTORCODE,VID_INSTCODE,VID_SHIFT,VID_SHIFTCODE,VID_DATE,VID_FBS,VID_RBS,VID_GLUCOSE,VID_PULSE,VID_SPO2,VID_DAY,VID_MONTH,VID_YEAR) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumber);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $age);
		$st->BindParam(7, $gender);
		$st->BindParam(8, $bp);
		$st->BindParam(9, $temperature);
		$st->BindParam(10, $height);
		$st->BindParam(11, $weight);
		$st->BindParam(12, $remarks);
		$st->BindParam(13, $dept);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $currentshift);
		$st->BindParam(18, $currentshiftcode);
		$st->BindParam(19, $days);
		$st->BindParam(20, $fbs);
		$st->BindParam(21, $rbs);
		$st->BindParam(22, $glucosetest);
		$st->BindParam(23, $pulse);
		$st->BindParam(24, $spo);
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
	$patientvitalstable = new OctopusPatientsVitalsSql();
?>