<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_complains
	$patientcomplainstable->querygetcomplainreport($complainsearch,$fromdate,$todate,$instcode)
	 = new OctopusPatientsComplainsSql();
	("SELECT * from octopus_patients_complains where PPC_PATIENTCODE = '$patientcode' and PPC_VISITCODE = '$visitcode' and PPC_INSTCODE = '$instcode' and PPC_STATUS = '1' order by PPC_ID DESC  ");
*/

class OctopusPatientsComplainsSql Extends Engine{

	// 21 FEB 2025, JOSEPH ADORBOE 
		public function querygetcomplainreport($complainsearch,$fromdate,$todate,$instcode){
			$list = ("SELECT  PPC_PATIENTCODE,  DATE(PPC_DATE) AS DAT , PPC_PATIENTNUMBER AS PATIENTNO, PPC_PATIENT AS PATIENT,  PPC_AGE AS AGE, PPC_GENDER AS GENDER ,  PPC_COMPLAIN AS COMPLAINT , PC_PHONE AS PHONE , PC_PHONEALT AS PHONEALT , PC_EMAIL AS EMAIL  FROM octopus_patients_complains JOIN octopus_patients_contacts ON PPC_PATIENTCODE = PC_PATIENTCODE where PPC_COMPLAIN LIKE '%$complainsearch%' AND  DATE(PPC_DATE) between '$fromdate' AND '$todate' AND PPC_INSTCODE = '$instcode' ORDER BY PPC_DATE ASC ");	
			return $list;
		}
	// 15 AUG 2024, JOSEPH ADORBOE 
	public function getcomplainrequesteddetails($requestcode,$instcode){
		$one  = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_complains WHERE PPC_CODE = ? AND PPC_INSTCODE = ? AND PPC_STATUS = ? ORDER BY PPC_ID  DESC LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PPC_COMPLAINCODE'].'@'.$object['PPC_COMPLAIN'].'@'.$object['PPC_HISTORY'].'@'.$object['PPC_CODE'];				
			}else{
				$results = '1';
			}
		}else{
			$results = '1';
		}
			
		return $results;
	}
	// 26 AUG 2024,  JOSEPH ADORBOE
	public function getquerypastconsultationcomplains($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_complains WHERE PPC_PATIENTCODE = '$patientcode' AND PPC_VISITCODE = '$visitcode' AND PPC_INSTCODE = '$instcode' order by PPC_STATUS desc , PPC_ID DESC");
		return $list;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketcomplains($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_complains where PPC_PATIENTCODE = '$patientcode' and PPC_VISITCODE = '$visitcode' and PPC_INSTCODE = '$instcode'  order by PPC_STATUS desc , PPC_ID DESC");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerycomplainshsitory($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_complains where PPC_PATIENTCODE = '$patientcode' and PPC_INSTCODE = '$instcode'  order by PPC_STATUS desc, PPC_ID DESC");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerycomplainshistorynotvisit($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_complains where PPC_PATIENTCODE = '$patientcode' and  PPC_INSTCODE = '$instcode' AND PPC_VISITCODE != '$visitcode' order by PPC_STATUS desc, PPC_ID DESC limit 10 ");
		return $list;
	}
	
	// 2 oct 2023 JOSEPH ADORBOE
	public function getquerycomplainhistorylist($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_complains where PPC_PATIENTCODE = '$patientcode' and  PPC_INSTCODE = '$instcode'  AND PPC_VISITCODE != '$visitcode' order by PPC_STATUS desc, PPC_ID DESC limit 10 ");
		return $list;
	}
	// 8 AUG 2024 , JOSEPH ADORBOE 
	public function removepatientcomplains($ekey,$removereason,$currentusercode,$currentuser,$instcode){
		$days =  date("Y-m-d H:i:s");
		$zero = '0';
		$one  =  '1';
		$sql = "UPDATE octopus_patients_complains SET PPC_STATUS = ?, PPC_CANCELREASON = ? , PPC_CANCELDATE = ?, PPC_CANCELACTOR = ?, PPC_CANCELACTORCODE = ?, PPC_CANCEL = ?  WHERE PPC_CODE = ? AND PPC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $removereason);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $one);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// 29 MAY 2022  JOSEPH ADORBOE 
	public function checkpatientcomplains($visitcode,$patientcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT PPC_ID  FROM octopus_patients_complains WHERE PPC_PATIENTCODE = ? AND PPC_INSTCODE = ? AND PPC_VISITCODE = ? AND PPC_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return '1';
			}
		}else{
			return '1';
		}		
	}
		

	// 23 OCT 2023, 25 AUG 2023
	public function cancelconsultationcomplains($visitcode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_complains SET PPC_STATUS = ? WHERE PPC_VISITCODE = ? AND PPC_INSTCODE = ? ";
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
	// 3 Oct 2023,  24 MAR 2021,  JOSEPH ADORBOE
    public function insert_newpatientcomplains($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$complainscode,$complain,$storyline,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT PPC_ID FROM octopus_patients_complains where PPC_PATIENTCODE = ? AND PPC_VISITCODE = ? AND PPC_CODE = ? and PPC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $form_key);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				$sqlstmt = "UPDATE octopus_patients_complains SET PPC_HISTORY = ? ,PPC_COMPLAINCODE = ?, PPC_COMPLAIN = ? WHERE PPC_CODE = ? AND PPC_STATUS =  ? ";    
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $storyline);
				$st->BindParam(2, $complainscode);
				$st->BindParam(3, $complain);  
				$st->BindParam(4, $form_key);
				$st->BindParam(5, $one);                 
				$exe = $st->execute();	
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}		

			}else{
				$sqlstmt = "INSERT INTO octopus_patients_complains(PPC_CODE,PPC_DATE,PPC_PATIENTCODE,PPC_PATIENTNUMBER,PPC_PATIENT,PPC_CONSULTATIONCODE,PPC_AGE,PPC_GENDER,PPC_VISITCODE,PPC_COMPLAINCODE,PPC_COMPLAIN,PPC_HISTORY,PPC_ACTOR,PPC_ACTORCODE,PPC_INSTCODE) 
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
				$st->BindParam(10, $complainscode);
				$st->BindParam(11, $complain);
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
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumbercomplains($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_complains SET PPC_PATIENTNUMBER = ?, PPC_ACTOR = ?, PPC_ACTORCODE =?  where PPC_PATIENTCODE = ? and PPC_INSTCODE = ? ";
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
	// 3 oct 2023, JOSEPH ADORBOE
	public function update_patientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_complains SET PPC_DATE = ?, PPC_COMPLAINCODE = ?,  PPC_COMPLAIN = ?, PPC_HISTORY =?  WHERE PPC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $comcode);
		$st->BindParam(3, $comname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
}
$patientcomplainstable = new OctopusPatientsComplainsSql(); 
?>
