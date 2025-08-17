<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_referal
	$patientreferaltable->getqueryreferallist($instcode); = new OctopusPatientsReferalSql();
*/

class OctopusPatientsReferalSql Extends Engine{

	// 2 OCT 2024, JOSEPH ADORBOE 
	public function update_cancelpatientreferal($ekey,$canceldetails,$instcode){
		$one = 1;
		$zero = '0';
		$sqlstmt = "UPDATE octopus_patients_referal SET RF_CANCELDETAILS = ?  ,RF_STATUS = ? WHERE RF_CODE = ? AND RF_STATUS =  ? AND RF_INSTCODE = ?";    
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $canceldetails);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);		                                 
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 15 JUNE  JOSEPH ADORBOE
	public function getqueryreferallist($instcode){
		$list = ("SELECT * FROM octopus_patients_referal WHERE RF_INSTCODE = '$instcode' and RF_STATUS = '1' order by RF_ID DESC ");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerypatientreferallist($patientcode,$instcode){
		$list = ("SELECT * FROM octopus_patients_referal WHERE RF_PATIENTCODE = '$patientcode'  AND RF_INSTCODE = '$instcode' and RF_STATUS = '1' order by RF_ID DESC ");
		return $list;
	}
	// // 7 NOV 2023 JOSEPH ADORBOE
	// public function getquerypatientreferallist($patientcode,$instcode){
	// 	$list = ("SELECT * FROM octopus_patients_referal WHERE RF_PATIENTCODE = '$patientcode'  AND RF_INSTCODE = '$instcode' and RF_STATUS = '1' order by RF_ID DESC ");
	// 	return $list;
	// }

	// 25 OCT 2023 JOSEPH ADORBOE
	public function insert_patientreferalinternal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$doctorcode,$doctorname,$servicecode,$servicename,$type,$remarks,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear){

		$days = Date('Y-m-d H:i:s');
		$referalnumber = date("his");
		$sqlstmt = "INSERT INTO octopus_patients_referal(RF_CODE,RF_NUMBER,RF_DATE,RF_PATIENTCODE,RF_PATIENTNUM,RF_PATIENT,RF_CONSULTATIONNUM,RF_AGE,RF_GENDER,RF_VISITCODE,RF_ACTOR,RF_ACTORCODE,RF_INSTCODE,RF_DAY,RF_MONTH,RF_YEAR,RF_DOCTOR,RF_DOCTORCODE,RF_SERVICECODE,RF_SERVICE,RF_TYPE,RF_REMARKS) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $referalnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $consultationcode);
		$st->BindParam(8, $age);
		$st->BindParam(9, $gender);
		$st->BindParam(10, $visitcode);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $currentday);
		$st->BindParam(15, $currentmonth);
		$st->BindParam(16, $currentyear);
		$st->BindParam(17, $doctorname);
		$st->BindParam(18, $doctorcode);
		$st->BindParam(19, $servicecode);
		$st->BindParam(20, $servicename);
		$st->BindParam(21, $type);
		$st->BindParam(22, $remarks);		
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}					
		
	}
	// 6 AUG 2023 JOSEPH ADORBOE 
	public function getcounttodayreferals($day,$instcode){
		$state = 4;
		$one = 1;
		$sqlstmt = ("SELECT RF_ID FROM octopus_patients_referal WHERE Date(RF_DATE) = ? and  RF_INSTCODE = ? AND RF_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $day);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			return $st->rowcount();		
		}else{
			return '0';
		}	
	}
	// 19 MAR 2023 , JOSEPH ADORBOE 
	public function getreferaldetails($idvalue){		
		$st = $this->db->prepare("SELECT * FROM octopus_patients_referal WHERE RF_CODE = ?");   
		$st->BindParam(1, $idvalue);
		$st->execute();
		if($st->rowcount()>0){
		$obj = $st->fetch(PDO::FETCH_ASSOC);	
		$value = $obj['RF_CODE'].'@@@'.$obj['RF_NUMBER'].'@@@'.$obj['RF_PATIENTCODE'].'@@@'.$obj['RF_PATIENTNUM'].'@@@'.$obj['RF_PATIENT'].'@@@'.$obj['RF_GENDER'].'@@@'.$obj['RF_AGE'].'@@@'.$obj['RF_DATE'].'@@@'.$obj['RF_HISTORY'].'@@@'.$obj['RF_FINDINGS'].'@@@'.$obj['RF_DIAGNOSIS'].'@@@'.$obj['RF_TREATMENT'].'@@@'.$obj['RF_REMARKS'].'@@@'.$obj['RF_VITALSNUM'].'@@@'.$obj['RF_INTRO'].'@@@'.$obj['RF_ACTOR'].'@@@'.$obj['RF_SPECIALITY'];
		
		return $value ;			
		}else{				
			return '-1';				
		}			
			
	}

	//  5 AUG 2023, 14 OCT 2021 JOSEPH ADORBOE 
	public function update_patientreferal($ekey,$days,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_referal SET RF_HISTORY = ? ,RF_FINDINGS = ? ,RF_DIAGNOSIS = ? ,RF_TREATMENT = ? ,RF_REMARKS = ? WHERE RF_CODE = ? AND RF_STATUS =  ? AND RF_INSTCODE = ?";    
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $history);
		$st->BindParam(2, $finding);
		$st->BindParam(3, $provisionaldiagnosis);
		$st->BindParam(4, $treatementgiven);
		$st->BindParam(5, $reasonreferal);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);                                  
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 5 AUG 2023 , 19 MAR 2023  JOSEPH ADORBOE
	public function insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
	$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear){

		$days = Date('Y-m-d H:i:s');
		$one = 1;
		$sqlstmt = " SELECT * FROM octopus_patients_referal WHERE RF_CODE = ? AND  RF_STATUS = ? AND RF_INSTCODE = ? "; 
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowCount()> '0'){
				$status = 1;
				$sqlstmt = "UPDATE octopus_patients_referal SET RF_HISTORY = ? ,RF_FINDINGS = ? ,RF_DIAGNOSIS = ? ,RF_TREATMENT = ? ,RF_REMARKS = ? WHERE RF_CODE = ? AND RF_STATUS =  ? AND RF_INSTCODE = ?";    
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $history);
				$st->BindParam(2, $finding);
				$st->BindParam(3, $provisionaldiagnosis);
				$st->BindParam(4, $treatementgiven);
				$st->BindParam(5, $reasonreferal);
				$st->BindParam(6, $form_key);
				$st->BindParam(7, $status);
				$st->BindParam(8, $instcode);                                  
				$exe = $st->execute();
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}
			}else{
				$referalnumber = date("his");
				$sqlstmt = "INSERT INTO octopus_patients_referal(RF_CODE,RF_NUMBER,RF_DATE,RF_PATIENTCODE,RF_PATIENTNUM,RF_PATIENT,RF_CONSULTATIONNUM,RF_AGE,RF_GENDER,RF_VISITCODE,RF_ACTOR,RF_ACTORCODE,RF_INSTCODE,RF_DAY,RF_MONTH,RF_YEAR,RF_VITALSNUM,RF_INTRO,RF_HISTORY,RF_FINDINGS,RF_DIAGNOSIS,RF_TREATMENT,RF_REMARKS) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $referalnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $currentday);
				$st->BindParam(15, $currentmonth);
				$st->BindParam(16, $currentyear);
				$st->BindParam(17, $vitalscode);
				$st->BindParam(18, $intro);
				$st->BindParam(19, $history);
				$st->BindParam(20, $finding);
				$st->BindParam(21, $provisionaldiagnosis);
				$st->BindParam(22, $treatementgiven);
				$st->BindParam(23, $reasonreferal);                 
				$exe = $st->execute();
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}					
			}
		}else{
			return '0';
		}	
	}
} 

$patientreferaltable = new OctopusPatientsReferalSql();
?>