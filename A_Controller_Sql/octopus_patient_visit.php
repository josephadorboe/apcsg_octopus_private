<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_visit
	$patientvisittable = new OctopusPatientsVisitSql();
	$patientvisittable->querygetactiveservice($instcode);
*/

class OctopusPatientVisitClass Extends Engine{
	// 07 APR 2022 JOSEPH ADORBOE 
	public function endpastvisits($day,$instcode){	
		$zero = '0';
		$one = 1;
		$two = 2;
		$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_STAGE = ?, VISIT_COMPLETE = ?, VISIT_STATE = ? WHERE DATE(VISIT_DATE) != ? AND VISIT_STATUS = ? AND VISIT_COMPLETE = ? AND VISIT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $two);
		$st->BindParam(5, $day);
		$st->BindParam(6, $one);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}
	// 14 JUNE 2025, JOSEPH ADORBOE 
	public function querygetactiveservice($instcode){
		$list = ("SELECT VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUMBER,VISIT_PATIENT,VISIT_DATE,VISIT_PAYMENTMETHOD,VISIT_PAYMENTSCHEME,VISIT_SERVICE,VISIT_PAYMENTTYPE,VISIT_SERVICECODE,VISIT_GENDER,VISIT_AGE from octopus_patients_visit where VISIT_INSTCODE = '$instcode' and VISIT_COMPLETE = '1' ");
		return $list;
	}
	// 23 oct 2023, 3 SEPT 2023,  JOSEPH ADORBOE
    public function reversecancelvisit($visitcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? AND VISIT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $one);
		$st->BindParam(3, $one);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $instcode);
		$exevisit = $st->execute();
		if($exevisit){				
			return '2';
		}else{				
			return '0';				
		}		
	}	
	// 23 oct 2023, 3 SEPT 2023,  JOSEPH ADORBOE
    public function cancelvisit($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? AND VISIT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $instcode);
		$exevisit = $st->execute();
		if($exevisit){				
			return '2';
		}else{				
			return '0';				
		}		
	}	
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function dischargevisit($visitcode,$instcode){
		$two = 2;
		$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? AND VISIT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $two);
		$st->BindParam(3, $two);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $instcode);
		$exevisit = $st->execute();
		if($exevisit){				
			return '2';
		}else{				
			return '0';				
		}		
	}	
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumbervisit($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_visit SET VISIT_PATIENTNUMBER = ? , VISIT_ACTOR = ?, VISIT_ACTORCODE =?  where VISIT_PATIENTCODE = ? and VISIT_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}		
	}
	// 9 AUG 2023
	public function newpatientvisit($form_key,$patientcode,$patientnumbers,$patient,$gender,$age,$visitcode,$days,$servicescode,$servicesname,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear,$paymentplan){
		$one = 1;
		$day = date('Y-m-d');
		$sqlstmt = ("SELECT VISIT_ID FROM octopus_patients_visit WHERE VISIT_PATIENTCODE = ? AND VISIT_INSTCODE = ? AND VISIT_STATUS = ? AND date(VISIT_DATE) = ? AND VISIT_SERVICECODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $day);
		$st->BindParam(5, $servicescode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{
		$sqlstmt = "INSERT INTO octopus_patients_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUMBER,VISIT_PATIENT,VISIT_DATE,VISIT_SERVICECODE,VISIT_SERVICE,VISIT_PAYMENTMETHOD,VISIT_PAYMENTMETHODCODE,VISIT_PAYMENTSCHEME,VISIT_PAYMENTSCHEMECODE,VISIT_ACTOR,VISIT_ACTORCODE,VISIT_INSTCODE,VISIT_SHIFTCODE,VISIT_SHIFT,VISIT_GENDER,VISIT_AGE,VISIT_PAYMENTTYPE,VISIT_DAY,VISIT_MONTH,VISIT_YEAR,VISIT_PLAN,VISIT_STATUS,VISIT_COMPLETE,VISIT_STATE) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $days);
		$st->BindParam(6, $servicescode);
		$st->BindParam(7, $servicesname);
		$st->BindParam(8, $paymethname);
		$st->BindParam(9, $paymentmethodcode);
		$st->BindParam(10, $paymentscheme);
		$st->BindParam(11, $paymentschemecode);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $currentusercode);
		$st->BindParam(14, $instcode);
		$st->BindParam(15, $currentshiftcode);
		$st->BindParam(16, $currentshift);
		$st->BindParam(17, $gender);
		$st->BindParam(18, $age);
		$st->BindParam(19, $payment);
		$st->BindParam(20, $currentday);
		$st->BindParam(21, $currentmonth);
		$st->BindParam(22, $currentyear);
		$st->BindParam(23, $paymentplan);
		$st->BindParam(24, $one);
		$st->BindParam(25, $one);
		$st->BindParam(26, $one);
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	}
	
} 
$patientvisittable = new OctopusPatientVisitClass();
?>