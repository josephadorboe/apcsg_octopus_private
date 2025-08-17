<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 18 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_allergy
	$patientsallergytable->querygetphysiopatientallergy($patientcode,$instcode);
*/

class OctopusPatientsAllergySql Extends Engine{

										
	// 6 APR 2025, JOSEPH ADORBOE 
	public function querygetphysiopatientallergy($patientcode,$instcode){
		$list = ("SELECT ALG_CODE,ALG_ALLERGY,ALG_DATE,ALG_HISTORY from octopus_patients_allergy where ALG_PATIENTCODE = '$patientcode' and  ALG_INSTCODE = '$instcode' and ALG_STATUS = '1' order by ALG_ID DESC  ");
		return $list;
	}
	// 24 APR 2022  AND DN_INSTCODE = '$instcode'
	public function getpatientsallergylov($patientcode,$instcode)
	{
		$one = 1;
		$sql = ("SELECT ALG_ALLERGY from octopus_patients_allergy where ALG_PATIENTCODE = '$patientcode' and  ALG_INSTCODE = '$instcode' and ALG_STATUS = '1' order by ALG_ID DESC");
		$st = $this->db->prepare($sql); 
		$st->execute();
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo "<li>".$obj['ALG_ALLERGY']."</li>";			
		}
	}

	// 17 JUNE 2024 
	public function editpatientallergy($ekey,$allergy,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_allergy SET ALG_ALLERGY = ?, ALG_ACTORCODE = ?, ALG_ACTOR = ? WHERE ALG_CODE = ? AND ALG_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $allergy);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 2 Oct 2023 JOSEPH ADORBOE
	public function getquerypatientallergytoday($instcode){
		$day = Date('Y-m-d');		
		$list = ("SELECT * FROM octopus_patients_allergy WHERE  ALG_INSTCODE = '$instcode' AND ALG_STATUS = '1' AND DATE(ALG_DATE) = '$day' ORDER BY ALG_ID DESC");
		return $list;
	}
	// 2 Oct 2023 JOSEPH ADORBOE
	public function getquerypatientallergy($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_allergy where ALG_PATIENTCODE = '$patientcode' and  ALG_INSTCODE = '$instcode' and ALG_STATUS = '1' order by ALG_ID DESC");
		return $list;
	}
		//11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientallegystatus($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_allergy WHERE ALG_PATIENTCODE = ? AND ALG_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){			
				return '2';
			}else{
				return'1';
			}
		}else{
			return '1';
		}			
	}
	 
	
	// 2 OCXT 2023, 11 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$newallergy,$storyline,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_st_allergy where ALG_ALLEGY = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newallergy);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_allergy(ALG_CODE,ALG_ALLEGY,ALG_USERCODE,ALG_USER,ALG_DESC) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $allergycode);
				$st->BindParam(2, $newallergy);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $currentuser);	
				$st->BindParam(5, $newallergy);			
				$exe = $st->execute();
				if($exe){
						$sqlstmt = "INSERT INTO octopus_patients_allergy(ALG_CODE,ALG_DATE,ALG_PATIENTCODE,ALG_PATIENTNUMBER,ALG_PATIENT,ALG_CONSULTATIONCODE,ALG_AGE,ALG_GENDER,ALG_VISITCODE,ALG_ALLERGYCODE,ALG_ALLERGY,ALG_HISTORY,ALG_ACTOR,ALG_ACTORCODE,ALG_INSTCODE) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
					$st->BindParam(10, $allergycode);
					$st->BindParam(11, $newallergy);
					$st->BindParam(12, $storyline);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$st->BindParam(15, $instcode);
					$exe = $st->execute();
					if($exe){
						return '2';
					}else{
						return '0';
					}
					// return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	
	}	

	// 18 Sept 2023,  10 APR 2022  JOSEPH ADORBOE 
	public function insert_patientallergy($form_key,$patientcode,$patientnumber,$patient,$age,$gender,$allergycode,$allergyname,$days,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_allergy WHERE ALG_PATIENTCODE = ? AND ALG_ALLERGY = ? AND ALG_STATUS = ? AND ALG_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $allergyname);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);		
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > '0'){
			return 1;
			}else{			
				$serial = 0 ;
				$sqlstmt = "INSERT INTO octopus_patients_allergy(ALG_CODE,ALG_DATE,ALG_PATIENTCODE,ALG_PATIENTNUMBER,ALG_PATIENT,ALG_AGE,ALG_GENDER,ALG_ALLERGYCODE,ALG_ALLERGY,ALG_ACTORCODE,ALG_ACTOR,ALG_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $age);
				$st->BindParam(7, $gender);
				$st->BindParam(8, $allergycode);
				$st->BindParam(9, $allergyname);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $instcode);
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

	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_newpatientallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_patients_allergy where ALG_PATIENTCODE = ? AND ALG_VISITCODE = ? AND ALG_ALLERGY = ? and ALG_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $allergyy);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_allergy(ALG_CODE,ALG_DATE,ALG_PATIENTCODE,ALG_PATIENTNUMBER,ALG_PATIENT,ALG_CONSULTATIONCODE,ALG_AGE,ALG_GENDER,ALG_VISITCODE,ALG_ALLERGYCODE,ALG_ALLERGY,ALG_HISTORY,ALG_ACTOR,ALG_ACTORCODE,ALG_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $allergycode);
				$st->BindParam(11, $allergyy);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
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

	$patientsallergytable = new OctopusPatientsAllergySql();
?>