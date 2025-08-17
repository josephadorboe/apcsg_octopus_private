<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 08 MAY 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class RecordsController Extends Engine{	

	// 29 JULY 2021,  JOSEPH ADORBOE
    public function endvisit($ekey,$visitcode,$servicecode,$patientcode,$currentusercode,$currentuser,$instcode){

		$but = 1;
		$nut = '0';
		$sqlstmt = ("SELECT * FROM octopus_patients_servicesrequest where REQU_VISITCODE = ? and REQU_SERVICECODE = ? and REQU_STAGE = ? and REQU_INSTCODE = ? and REQU_COMPLETE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $but);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $but);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				$sqlstmt = "UPDATE octopus_patients_servicesrequest SET REQU_COMPLETE = ?, REQU_STATUS = ? ,REQU_STATE = ?, REQU_ACTOR = ? , REQU_ACTORCODE = ? where REQU_VISITCODE = ? and REQU_SERVICECODE = ? and REQU_STAGE = ? and REQU_INSTCODE = ? and REQU_COMPLETE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $nut);
				$st->BindParam(2, $nut);
				$st->BindParam(3, $nut);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $visitcode);
				$st->BindParam(7, $servicecode);
				$st->BindParam(8, $but);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $but);
			//	$st->BindParam(11, $patientaltphone);
				$exe = $st->execute();
				$sqlstmt = "UPDATE octopus_patients_billitems SET B_STATUS = ? ,B_ACTOR = ? , B_ACTORCODE = ? where B_VISITCODE = ? and B_ITEMCODE = ? and B_PATIENTCODE = ?  ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $nut);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $servicecode);
				$st->BindParam(6, $patientcode);
				$exe = $st->execute();	
				$sqlstmt = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? ,VISIT_ACTOR = ? , VISIT_ACTORCODE = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? where VISIT_CODE = ? and VISIT_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $nut);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $nut);
				$st->BindParam(5, $nut);
				$st->BindParam(6, $visitcode);
				$st->BindParam(7, $instcode);
				$exe = $st->execute();				
				if($exe){				
					return '2';
				}else{				
					return '0';				
				}					
			}else{	
				return '1';	
			}
		}else{
			return '0';
		}		
		
	}

	// 17 jan 2021,  JOSEPH ADORBOE
    public function update_patientnumberrecords($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode) {

		$but = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients where PATIENT_PATIENTNUMBER = ? and PATIENT_INSTCODE = ? and PATIENT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $but);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$sqlstmt = "UPDATE octopus_patients SET PATIENT_PATIENTNUMBER = ? ,PATIENT_ACTOR = ? , PATIENT_ACTORCODE = ? where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $ekey);
				$st->BindParam(5, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_contacts SET PC_PATIENTNUMBER = ?  where PC_PATIENTCODE = ? and PC_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_reciept SET BP_PATIENTNUMBER = ? where BP_PATIENTCODE = ? and BP_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_servicesrequest SET REQU_PATIENTNUMBER = ?  where REQU_PATIENTCODE = ? and REQU_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_visit SET VISIT_PATIENTNUMBER = ? where VISIT_PATIENTCODE = ? and VISIT_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();
				
				$sqlstmt = "UPDATE octopus_patients_appointments SET APP_PATIENTNUMBER = ?  where APP_PATIENTCODE = ? and PATIENT_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_attachedresults SET RES_PATIENTNUMBER = ?  where RES_PATIENTCODE = ? and RES_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_billitems SET B_PATIENTNUMBER = ? where B_PATIENTCODE = ? and B_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_complains SET PPC_PATIENTNUMBER = ? where PPC_PATIENTCODE = ? and PPC_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();

				$sqlstmt = "UPDATE octopus_patients_consultations SET CON_PATIENTNUMBER = ? where CON_PATIENTCODE = ? and CON_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $replacepatientnumber);
				$st->BindParam(2, $ekey);
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

	// 17 jan 2021,  JOSEPH ADORBOE
    public function update_patientrecords($ekey,$patientfirstname,$patientlastname,$fullname,$patientaltphone,$patientnationality,$patientreligion,$patientpostal,$patientmaritalstatus,$patienthomeaddress,$patientemail,$patientbirthdate,$patientoccupation,$patientgender,$patientphone,$patientemergencyone,$patientemergencytwo,$currentusercode,$currentuser,$instcode){
	
		$sqlstmt = "UPDATE octopus_patients SET PATIENT_FIRSTNAME = ? ,PATIENT_LASTNAME = ? , PATIENT_NAMES = ? , PATIENT_GENDER = ? , PATIENT_RELIGION = ?  , PATIENT_MARITAL =  ? , PATIENT_OCCUPATION = ? , PATIENT_NATIONALITY = ?, PATIENT_HOMEADDRESS = ?, PATIENT_PHONENUMBER = ? , PATIENT_ALTPHONENUMBER = ? , PATIENT_DOB= ?  , PATIENT_ACTOR = ? , PATIENT_ACTORCODE = ?   where PATIENT_CODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientfirstname);
		$st->BindParam(2, $patientlastname);
		$st->BindParam(3, $fullname);
		$st->BindParam(4, $patientgender);
		$st->BindParam(5, $patientreligion);
		$st->BindParam(6, $patientmaritalstatus);
		$st->BindParam(7, $patientoccupation);
		$st->BindParam(8, $patientnationality);
		$st->BindParam(9, $patienthomeaddress);
		$st->BindParam(10, $patientphone);
		$st->BindParam(11, $patientaltphone);
		$st->BindParam(12, $patientbirthdate);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $ekey);
		$exe = $st->execute();	
		if($exe){
			$sql = "UPDATE octopus_patients_contacts SET PC_PHONE = ?, PC_PHONEALT = ? , PC_HOMEADDRESS = ?, PC_EMAIL = ? ,PC_POSTAL = ?, PC_EMERGENCYONE =? , PC_EMERGENCYTWO =?, PC_ACTOR =?, PC_ACTORCODE =? WHERE PC_PATIENTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $patientphone);
			$st->BindParam(2, $patientaltphone);
			$st->BindParam(3, $patienthomeaddress);
			$st->BindParam(4, $patientemail);
			$st->BindParam(5, $patientpostal);
			$st->BindParam(6, $patientemergencyone);
			$st->BindParam(7, $patientemergencytwo);
			$st->BindParam(8, $currentuser);
			$st->BindParam(9, $currentusercode);
			$st->BindParam(10, $ekey);
			$exe = $st->execute();		
			if($exe){				
				return '2';
			}else{				
				return '0';				
			}			
		}else{			
			return '0';			
		}	
	}


	// 08 MAY 2021  JOSEPH ADORBOE
	public function checknewpatientnumber($replacepatientnumber,$instcode){		
		$but = 1;
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients where PATIENT_PATIENTNUMBER = ? and PATIENT_INSTCODE = ? and PATIENT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $but);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				return '2';			
			}
		}else{
			return '0';
		}
	}
	
} 

$recordscontroller = new RecordsController();
?>