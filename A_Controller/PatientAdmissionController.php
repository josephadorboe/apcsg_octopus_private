<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 11 JAN 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientAdmissionController Extends Engine{

	// 24 APR 2022   JOSEPH ADORBOE
	public function insert_admissionpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear){
				
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


	// 22 APR  2022 JOSEPH ADORBOE
	public function assignbed($admissioncode,$bedcode,$bedname,$wardcode,$wardname,$bedgender,$bedrate,$currentuser,$currentusercode,$instcode){		
		$rt = 1;		
		$sql = "UPDATE octopus_patients_admissions SET ADM_WARDCODE = ? , ADM_WARD = ? , ADM_BEDCODE = ? , ADM_BED = ? WHERE ADM_CODE = ? AND ADM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $wardcode);
		$st->BindParam(2, $wardname);
		$st->BindParam(3, $bedcode);
		$st->BindParam(4, $bedname);	
		$st->BindParam(5, $admissioncode);
		$st->BindParam(6, $instcode);
	//	$st->BindParam(7, $ekey);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_patients_admissions_archive SET ADM_WARDCODE = ? , ADM_WARD = ? , ADM_BEDCODE = ? , ADM_BED = ? WHERE ADM_CODE = ? AND ADM_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $wardcode);
		$st->BindParam(2, $wardname);
		$st->BindParam(3, $bedcode);
		$st->BindParam(4, $bedname);	
		$st->BindParam(5, $admissioncode);
		$st->BindParam(6, $instcode);
	//	$st->BindParam(7, $ekey);
		$exe = $st->execute();
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	//13 JAN 2022 JOSEPH ADORBOE
	public function editwardsbed($ekey,$bedname,$wardcode,$wardname,$bedrate,$currentuser,$currentusercode,$instcode){		
		$rt = 1;		
		$sql = "UPDATE octopus_st_ward_bed SET BED_NAME = ? , BED_WARDCODE = ? , BED_WARD = ? , BED_RATE = ? , BED_ACTOR = ? , BED_ACTORCODE = ? WHERE BED_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bedname);
		$st->BindParam(2, $wardcode);
		$st->BindParam(3, $wardname);
		$st->BindParam(4, $bedrate);	
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $ekey);
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	//12 JAN 2022 JOSEPH ADORBOE
	public function addwardsbeds($form_key,$bedname,$wardcode,$wardname,$wardrate,$wardgender,$currentuser,$currentusercode,$instcode){	
		$bt = 1;
		$sqlstmt = ("SELECT BED_ID FROM octopus_st_ward_bed WHERE BED_NAME = ? AND BED_INSTCODE =? AND BED_STATUS = ? AND BED_WARDCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $wardname);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$st->BindParam(4, $wardcode);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$not = '0';
				$sqlstmt = "INSERT INTO octopus_st_ward_bed(BED_CODE,BED_NAME,BED_WARDCODE,BED_WARD,BED_GENDER,BED_RATE,BED_ACTOR,BED_ACTORCODE,BED_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $bedname);
				$st->BindParam(3, $wardcode);
				$st->BindParam(4, $wardname);
				$st->BindParam(5, $wardgender);
				$st->BindParam(6, $wardrate);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$exe = $st->execute();	

				$not = 1;
				$sql = "UPDATE octopus_st_ward SET WARD_CAPACITY = WARD_CAPACITY + ?  WHERE WARD_CODE = ? AND WARD_INSTCODE = ?";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $not);
				$st->BindParam(2, $wardcode);
				$st->BindParam(3, $instcode);
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
	
	//12 JAN 2022 JOSEPH ADORBOE
	public function editwards($ekey,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode){		
		$rt = 1;		
		$sql = "UPDATE octopus_st_ward SET WARD_NAME = ? , WARD_RATE = ? , WARD_GENDER = ? , WARD_ACTOR = ? , WARD_ACTORCODE = ? WHERE WARD_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $wardname);
		$st->BindParam(2, $warerate);
		$st->BindParam(3, $wardgender);
		$st->BindParam(4, $currentuser);	
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	//12 JAN 2022 JOSEPH ADORBOE
	public function addwards($form_key,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode){	
		$bt = 1;
		$sqlstmt = ("SELECT WARD_ID FROM octopus_st_ward WHERE WARD_NAME = ? AND WARD_INSTCODE =? AND WARD_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $wardname);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$not = '0';
				$sqlstmt = "INSERT INTO octopus_st_ward(WARD_CODE,WARD_NAME,WARD_RATE,WARD_CAPACITY,WARD_GENDER,WARD_ACTORCODE,WARD_ACTOR,WARD_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $wardname);
				$st->BindParam(3, $warerate);
				$st->BindParam(4, $not);
				$st->BindParam(5, $wardgender);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $instcode);
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


	// 11 JAN 2021 JOSEPH ADORBOE 
	public function getpatientadmissiondetails($idvalue,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_admissions where ADM_CODE = ? AND ADM_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['ADM_CODE'].'@'.$object['ADM_NUMBER'].'@'.$object['ADM_VISITCODE'].'@'.$object['ADM_DATETIME'].'@'.$object['ADM_PATIENTCODE'].'@'.$object['ADM_PATIENTNUMBER'].'@'.$object['ADM_PATIENT'].'@'.$object['ADM_AGE'].'@'.$object['ADM_GENDER'].'@'.$object['ADM_STATUS'].'@'.$object['ADM_PAYMETHOD'].'@'.$object['ADM_PAYMETHODCODE'].'@'.$object['ADM_PAYMENTSCHEMECODE'].'@'.$object['ADM_PAYMENTSCHEME'].'@'.$object['ADM_TYPE'].'@'.$object['ADM_DOCTOR'].'@'.$object['ADM_ADMISSIONNOTES'].'@'.$object['ADM_TRIAGE'].'@'.$object['ADM_SHOW'].'@'.$object['ADM_WARD'].'@'.$object['ADM_BED'].'@'.$object['ADM_DAYS_SPENT'].'@'.$object['ADM_SERVICECODE'].'@'.$object['ADM_SERVICE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	


	
} 
?>