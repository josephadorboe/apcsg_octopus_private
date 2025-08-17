<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_medicalreports
	$patientsMedicalreportstable = new OctopusPatientsMedicalreportsSql();
*/

class OctopusPatientsMedicalreportsSql Extends Engine{
	// 08 AUG 2023 
	public function selectpendingmedicalreport($instcode){
		$list = ("SELECT * FROM octopus_patients_medicalreports WHERE MDR_INSTCODE = '$instcode' and MDR_ISSUED IN('0','1') order by MDR_ID DESC ");
		return 	$list;		
	}
	// 2 Oct 2023 
	public function patientmedicalreport($patientcode,$instcode){
		$list = ("SELECT * FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = '$patientcode'  AND MDR_INSTCODE = '$instcode' and MDR_ISSUED = '0' order by MDR_ID DESC ");
		return 	$list;		
	}
	// 3 NOV  2023 
	public function getpatientmedicalreport($patientcode,$instcode){
		$list = ("SELECT * FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = '$patientcode' AND MDR_INSTCODE = '$instcode' and MDR_STATUS != '0' order by MDR_ID DESC ");
		return 	$list;		
	}
	  
	
	// 14 OCT 2021 JOSEPH ADORBOE 
	public function getpatientpendingmedicalreport($patientcode,$instcode){
		$nut = '0';
		$sqlstmt = ("SELECT * FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = ? AND MDR_INSTCODE = ? AND MDR_ISSUED = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	
	//  1 oct 2023 , 22 JAN 2022  JOSEPH ADORBOE 
	public function update_patientmedicalreportssingle($ekey,$days,$storyline,$addressedto,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_DATE = ?, MDR_REPORT = ? , MDR_ADDRESS = ? ,MDR_ACTOR = ? , MDR_ACTORCODE = ? WHERE MDR_CODE = ? AND MDR_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
		$st->BindParam(3, $addressedto);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 1 OCT 2023,  13 OCT 2021,  JOSEPH ADORBOE
	public function insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$currentusercode,$currentuser,$instcode,$currentuserspec){
		$cash = 'CASH';
		$mt = 1;
		$zero = '0';
		$sqlstmt = ("SELECT MDR_ID FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = ? AND  MDR_INSTCODE = ? AND MDR_SERVICECODE = ? AND MDR_SELECTED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $servicereqcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{				
				$sqlstmt = "INSERT INTO octopus_patients_medicalreports(MDR_CODE,MDR_DATE,MDR_PATIENTCODE,MDR_PATIENTNUMBER,MDR_PATIENT,MDR_CONSULTATIONCODE,MDR_AGE,MDR_GENDER,MDR_VISITCODE,MDR_SERVICECODE,MDR_SERVICE,MDR_REPORT,MDR_ACTOR,MDR_ACTORCODE,MDR_INSTCODE,MDR_ADDRESS,MDR_REQUESTNUMBER,MDR_DIAGNOSISCODE,MDR_DIAGNOSIS,MDR_DIAGNOSISTYPE,MDR_ACTORTITLE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $servicereqcode);
				$st->BindParam(11, $servicereqname);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $addressedto);
				$st->BindParam(17, $requestnumber);
				$st->BindParam(18, $diagnosiscode);
				$st->BindParam(19, $diagnosisname);
				$st->BindParam(20, $diagnosistype);
				$st->BindParam(21, $currentuserspec);
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
	
	// 2 SEPT 2023, 28 JULY 2022 , JOSEPH ADORBOE 
	public function medicalreportdetails($idvalue){		
		$st = $this->db->prepare("SELECT * FROM octopus_patients_medicalreports WHERE MDR_CODE = ?");   
		$st->BindParam(1, $idvalue);
		$st->execute();
		if($st->rowcount()>0){
		$obj = $st->fetch(PDO::FETCH_ASSOC);
	
		$value = $obj['MDR_CODE'].'@@@'.$obj['MDR_REQUESTNUMBER'].'@@@'.$obj['MDR_PATIENTCODE'].'@@@'.$obj['MDR_PATIENTNUMBER'].'@@@'.$obj['MDR_PATIENT'].'@@@'.$obj['MDR_GENDER'].'@@@'.$obj['MDR_AGE'].'@@@'.$obj['MDR_DATE'].'@@@'.$obj['MDR_SERVICE'].'@@@'.$obj['MDR_ADDRESS'].'@@@'.$obj['MDR_REPORT'].'@@@'.$obj['MDR_ACTOR'].'@@@'.$obj['MDR_DIAGNOSIS'].'@@@'.$obj['MDR_ACTORTITLE'];
		
			return $value ;			
		}else{				
			return '-1';				
		}			
			
	}
	// 29 AUG 2023
	public function selectedpaidmedicalreport($selected,$patientcode,$unselected,$instcode){
		$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sqlmed);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}		
	}	
	// 26 AUG 2023
	public function reversecancelmedicalreport($selected,$servicecode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATE = ?, MDR_STATUS = ?, MDR_COMPLETE = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $unselected);
		$st->BindParam(6, $instcode);
		$selectitem = $st->Execute();			
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function cancelmedicalreport($selected,$servicecode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATE = ?, MDR_STATUS = ?, MDR_COMPLETE = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $unselected);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $unselected);
		$st->BindParam(6, $instcode);
		$selectitem = $st->Execute();			
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function sendbackmedicalreport($selected,$servicecode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATE = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $instcode);
		$selectitem = $st->Execute();			
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function unselectmedicalreport($selected,$servicecode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_SELECTED = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $instcode);
		$selectitem = $st->Execute();			
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function selectmedicalreport($selected,$servicecode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_SELECTED = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
} 
$patientsMedicalreportstable = new OctopusPatientsMedicalreportsSql();
?>