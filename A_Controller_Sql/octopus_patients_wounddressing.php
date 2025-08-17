<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 7 NOV 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_wounddressing
	$patientswounddressingtable->cancelwounddressing($woundcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode)
	insert_patientwounddressingservice($form_key,$ekey,$wounddressingnumber,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$patientservicecode,$patientservice,$servicerequestcode,$remarks,$currentday,$currentmonth,$currentyear)
*/

class OctopusPatientsWounddressingSql Extends Engine{
	// 22 AUG 2024, JOSEPH ADORBOE 
	public function getpatientwounddressingdetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_wounddressing WHERE WD_CODE = ? AND WD_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['WD_CODE'].'@@'.$obj['WD_SERVICECODE'].'@@'.$obj['WD_SERVICE'].'@@'.$obj['WD_NOTES'].'@@'.$obj['WD_STATUS'];
			// .'@@'.$obj['WD_PATIENT'].'@@'.$obj['WD_VISITCODE'].'@@'.$obj['WD_AGE'].'@@'.$obj['WD_GENDER'].'@@'.$obj['WD_SERVICEREQUESTCODE'].'@@'.$obj['WD_SERVICECODE'].'@@'.$obj['WD_SERVICE'].'@@'.$obj['WD_DATE'];
		}else{
			$res = '0';
		}
		return $res;
	}
	// 26 AUG 2024, JOSEPH ADORBOE 
	public function cancelwounddressing($woundcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_wounddressing SET WD_STATUS = ?, WD_RETURNREASON = ?, WD_RETURNACTORCODE = ?, WD_RETURNACTOR = ?, WD_RETURNTIME = ?  WHERE WD_CODE = ? AND WD_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $days);
		$st->BindParam(6, $woundcode);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();				
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 22 AUG 2024 JOSEPH ADORBOE
	public function getwounddressinghistorylist($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_wounddressing WHERE WD_INSTCODE = '$instcode' AND WD_PATIENTCODE = '$patientcode'  AND WD_VISITCODE != '$visitcode'  order by WD_STATUS DESC , WD_ID DESC ");
		return $list;
	}

	// 22 AUG 2024 JOSEPH ADORBOE
	public function getwounddressinglist($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_wounddressing WHERE WD_INSTCODE = '$instcode' AND WD_PATIENTCODE = '$patientcode'  AND WD_VISITCODE = '$visitcode'  order by WD_STATUS DESC , WD_ID DESC ");
		return $list;
	}

	// 7 NOV  2023 JOSEPH ADORBOE
	public function getquerywounddressinglist($patientcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_wounddressing WHERE WD_INSTCODE = '$instcode' AND WD_PATIENTCODE = '$patientcode'  order by WD_STATUS DESC , WD_ID DESC ");
		return $list;
	}

	// 7 NOV 2023, JOSEPH ADORBOE
	public function update_patientwounddressing($ekey,$woundservicecode,$woundservicename,$storyline,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqldevices = "UPDATE octopus_patients_wounddressing SET WD_SERVICECODE = ? , WD_SERVICE = ?, WD_NOTES =? , WD_ACTOR = ? , WD_ACTORCODE = ? WHERE WD_CODE = ? and WD_STATUS = ? and WD_INSTCODE = ? ";
		$st = $this->db->prepare($sqldevices);
		$st->BindParam(1, $woundservicecode);
		$st->BindParam(2, $woundservicename);
		$st->BindParam(3, $storyline);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// 7 NOV 2023 JOSEPH ADORBOE
    public function insert_patientwounddressing($form_key,$days,$requestcode,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$woundservicecode,$woundservicename,$storyline,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
	
		$sqlstmt = "INSERT INTO octopus_patients_wounddressing(WD_CODE,WD_NUMBER,WD_DATE,WD_PATIENTNUMBER,WD_PATIENT,WD_PATIENTCODE,WD_AGE,WD_GENDER,WD_VISITCODE,WD_SERVICECODE,WD_SERVICE,WD_NOTES,WD_ACTOR,WD_ACTORCODE,WD_INSTCODE,WD_PAYMENTMETHOD,WD_PAYMENTMETHODCODE,WD_SCHEMECODE,WD_SCHEME,WD_DAY,WD_MONTH,WD_YEAR) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $requestcode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $age);
		$st->BindParam(8, $gender);
		$st->BindParam(9, $visitcode);
		$st->BindParam(10, $woundservicecode);
		$st->BindParam(11, $woundservicename);
		$st->BindParam(12, $storyline);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $paymentmethod);
		$st->BindParam(17, $paymentmethodcode);
		$st->BindParam(18, $schemecode);
		$st->BindParam(19, $scheme);
		$st->BindParam(20, $currentday);
		$st->BindParam(21, $currentmonth);
		$st->BindParam(22, $currentyear);
		$exe = $st->execute();								
			if($exe){								
				return '2';								
			}else{								
				return '0';								
			}
		}
		
		// 30 MAR 2022    JOSEPH ADORBOE
	public function insert_patientwounddressingservice($form_key,$ekey,$wounddressingnumber,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$days,$currentusercode,$currentuser,$instcode,$patientservicecode,$patientservice,$servicerequestcode,$remarks,$currentday,$currentmonth,$currentyear){
				
		$sqlstmt = "INSERT INTO octopus_patients_wounddressing(WD_CODE,WD_NUMBER,WD_PATIENTNUMBER,WD_PATIENTCODE,WD_PATIENT,WD_DATE,WD_AGE,WD_GENDER,WD_SERVICE,WD_SERVICECODE,WD_NOTES,WD_VISITCODE,WD_ACTOR,WD_ACTORCODE,WD_INSTCODE,WD_DAY,WD_MONTH,WD_YEAR,WD_SERVICEREQUESTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $wounddressingnumber);
		$st->BindParam(3, $patientnumber);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $days);
		$st->BindParam(7, $age);
		$st->BindParam(8, $gender);
		$st->BindParam(9, $patientservice);
		$st->BindParam(10, $patientservicecode);
		$st->BindParam(11, $remarks);
		$st->BindParam(12, $visitcode);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $currentday);
		$st->BindParam(17, $currentmonth);
		$st->BindParam(18, $currentyear);
		$st->BindParam(19, $ekey);		
		$exe = $st->execute();
		// $one = 1;
		// $two = 2;
		// $sqlstmt = "UPDATE octopus_patients_servicesrequest SET REQU_COMPLETE = ?, REQU_VITALSTATUS = ?  WHERE REQU_CODE = ? ";
		// $st = $this->db->Prepare($sqlstmt);
		// $st->BindParam(1, $two);
		// $st->BindParam(2, $one);
		// $st->BindParam(3, $ekey);
		// $ext = $st->execute();				
		if($exe){				
			return '2';
		}else{
			return '0';
		}				
	}
		
	
} 

$patientswounddressingtable =  new OctopusPatientsWounddressingSql();
?>