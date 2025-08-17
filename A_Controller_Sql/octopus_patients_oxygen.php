<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 19 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_oxygen
	$patientsoxygentable->insert_patientoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode)
*/

class OctopusPatientsOxygenSql Extends Engine{
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketoxygen($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_oxygen where POX_PATIENTCODE = '$patientcode' and POX_VISITCODE = '$visitcode' and POX_INSTCODE = '$instcode' and POX_STATUS != '0' order by POX_ID DESC   ");
		return $list;
	}

	// 7 NOV 2023, JOSEPH ADORBOE
	public function update_patientoxygen($ekey,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqldevices = "UPDATE octopus_patients_oxygen SET POX_OXYGENCODE = ? ,POX_OXYGEN = ? ,  POX_REMARK =? , POX_ACTOR = ? , POX_ACTORCODE = ? WHERE POX_CODE = ? and POX_STATUS = ? and POX_INSTCODE = ? ";
		$st = $this->db->prepare($sqldevices);
		$st->BindParam(1, $comcode);
		$st->BindParam(2, $comname);
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
	// 24 OCT 2023, 25 AUG 2023
	public function cancelconsultationoxygen($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_oxygen SET POX_STATUS = ? WHERE POX_VISITCODE = ? AND POX_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// 12 SEPT  2021,  JOSEPH ADORBOE
    public function insert_patientaddoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$storyline,$newoxygen,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$randonnumber = rand(1,10000);
		$sqlstmt = ("SELECT OX_ID FROM octopus_st_oxygen where OX_NAME = ? AND OX_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newoxygen);
		$st->BindParam(2, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_oxygen(OX_CODE,OX_NAME,OX_DESC,OX_ACTORCODE,OX_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newoxygen);
				$st->BindParam(3, $newoxygen);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);				
				$exe = $st->execute();
				if($exe){
						$sqlstmt = "INSERT INTO octopus_patients_oxygen(POX_CODE,POX_DATE,POX_PATIENTCODE,POX_PATIENTNUMBER,POX_PATIENT,POX_CONSUTLATIONCODE,POX_AGE,POX_GENDER,POX_VISITCODE,POX_REMARK,POX_ACTOR,POX_ACTORCODE,POX_INSTCODE,POX_OXYGENCODE,POX_OXYGEN,POX_NUMBER) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
					$st->BindParam(10, $storyline);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $currentusercode);
					$st->BindParam(13, $instcode);
					$st->BindParam(14, $comcode);
					$st->BindParam(15, $newoxygen);
					$st->BindParam(16, $randonnumber);
					$exe = $st->execute();
					if($exe){
						$nut = 1;
							$ut = '0';
							$sql = "UPDATE octopus_patients_consultations SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
							$exe = $st->execute();
							$sql = "UPDATE octopus_patients_consultations_archive SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
							$exe = $st->execute();							
							if($exe){								
								return '2';								
							}else{								
								return '0';								
							}	
					}else{
						return '0';
					}
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
		
	}

	//17 OCT 2023,  26 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientoxygenonly($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$randonnumber = rand(1,100000);		
		$sqlstmt = "INSERT INTO octopus_patients_oxygen(POX_CODE,POX_DATE,POX_PATIENTCODE,POX_PATIENTNUMBER,POX_PATIENT,POX_CONSUTLATIONCODE,POX_AGE,POX_GENDER,POX_VISITCODE,POX_REMARK,POX_ACTOR,POX_ACTORCODE,POX_INSTCODE,POX_OXYGENCODE,POX_OXYGEN,POX_NUMBER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
		$st->BindParam(10, $storyline);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $comcode);
		$st->BindParam(15, $comname);
		$st->BindParam(16, $randonnumber);
		$exe = $st->execute();													
		if($exe){
										
			return '2';								
		}else{								
			return '0';								
		}		
	}
	

	//17 OCT 2023,  26 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$randonnumber = rand(1,10000);
		$sqlstmt = ("SELECT POX_ID FROM octopus_patients_oxygen where POX_PATIENTCODE = ? AND POX_VISITCODE = ? AND POX_OXYGENCODE = ? AND POX_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $comcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_oxygen(POX_CODE,POX_DATE,POX_PATIENTCODE,POX_PATIENTNUMBER,POX_PATIENT,POX_CONSUTLATIONCODE,POX_AGE,POX_GENDER,POX_VISITCODE,POX_REMARK,POX_ACTOR,POX_ACTORCODE,POX_INSTCODE,POX_OXYGENCODE,POX_OXYGEN,POX_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $storyline);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $comcode);
				$st->BindParam(15, $comname);
				$st->BindParam(16, $randonnumber);
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

$patientsoxygentable = new OctopusPatientsOxygenSql();
?>