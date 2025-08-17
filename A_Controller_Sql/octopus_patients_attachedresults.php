<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 2 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_attachedresults
	$patientsattachedresultstable->getqueryattachedlist($patientcode,$instcode)
	getviewfile($code,$instcode) = new OctopusPatientsAttachedResultsSql();
*/

class OctopusPatientsAttachedResultsSql Extends Engine{

	// 23 JUNE 2024,  JOSEPH ADORBOE
	public function getviewfiledocument($code,$instcode){
		$one = '1';
		$sqlstmt = ("SELECT RES_FILE FROM octopus_patients_attachedresults where RES_INSTCODE = ? AND  RES_CODE = ? LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $code);		
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['RES_FILE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}		
	}

	// 12 JUNE 2025, JOSEPH ADORBOE
	public function getqueryattachedlist($patientcode,$instcode){		
		$list = ("SELECT RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE,RES_CATGORY FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = '$patientcode' AND  RES_INSTCODE = '$instcode' and RES_STATUS != '0' ORDER BY RES_ID DESC");
		return $list;
	}

	// 26 JUNE 2024,  JOSEPH ADORBOE
	public function removeattachmented($ekey,$currentusercode,$currentuser,$instcode){			
		$zero = '0';
		$one = 1;
		$requestcode = $ekey.'_'.rand(100,999);
		$sqlstmt = "UPDATE octopus_patients_attachedresults SET RES_STATUS = ?, RES_ACTOR = ? , RES_ACTORCODE = ?, RES_REQUESTCODE = ?  WHERE RES_REQUESTCODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $requestcode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $one);
		$exe = $st->execute();		
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 23 JUNE 2024,  JOSEPH ADORBOE
	public function getviewfile($code,$instcode){
		$one = '1';
		$sqlstmt = ("SELECT RES_FILE FROM octopus_patients_attachedresults where RES_INSTCODE = ? AND  RES_REQUESTCODE = ? LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $code);		
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['RES_FILE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}		
	}
	// 2 SEPT  2023, JOSEPH ADORBOE
	public function selectattachedlist($patientcode,$instcode){
		$list = ("SELECT * FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = '$patientcode' AND RES_INSTCODE = '$instcode' AND RES_STATUS = '1'");										
		return $list;
	}	
	// 7 oct 2023 JOSEPH ADORBOE
	public function getquerysattacheddocument($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_attachedresults where RES_PATIENTCODE = '$patientcode' and  RES_INSTCODE = '$instcode' and RES_STATUS != '0' order by RES_ID DESC");
		return $list;
	}
	// 3 oct 2023 JOSEPH ADORBOE
	public function getquerylegacyattacheddocument($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_attachedresults where RES_PATIENTCODE = '$patientcode' and  RES_INSTCODE = '$instcode' and RES_STATUS != '0' order by RES_ID DESC");
		return $list;
	}
	// 2 oct 2023 JOSEPH ADORBOE
	public function getqueryattacheddocument($patientcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = '$patientcode' AND RES_INSTCODE = '$instcode' AND RES_STATUS = '1'");
		return $list;
	}
	// 2 oct 2023 JOSEPH ADORBOE
	public function getquerypatientsattachedresults($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_attachedresults  where RES_STATUS = '1' AND RES_INSTCODE = '$instcode' and RES_PATIENTCODE = '$patientcode' order by RES_DATETIME DESC");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getqueryattachedresults($day,$instcode){		
		$list = ("SELECT * from octopus_patients_attachedresults  where RES_STATUS = '1' AND RES_INSTCODE = '$instcode' and date(RES_DATETIME) = '$day'  order by RES_DATETIME DESC");
		return $list;
	}
	// 11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientattachedresults($patientcode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ? ");
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

	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberattachedresults($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_attachedresults SET RES_PATIENTNUMBER = ?,RES_ACTOR = ?, RES_ACTORCODE =?  where RES_PATIENTCODE = ? and RES_INSTCODE = ? ";
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
	// 15 AUG 2022 JOSEPH ADORBOE
	public function removeattachments($ekey,$currentusercode,$currentuser,$instcode){			
		$zero = '0';
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_attachedresults SET RES_STATUS = ?, RES_ACTOR = ? , RES_ACTORCODE = ? WHERE RES_CODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $one);
		$exe = $st->execute();		
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 2 SEPT 2023,  23 MAY 2021   JOSEPH ADORBOE
	public function attachepatientresults($form_key,$patientnumbers,$patient,$patientcode,$requestcode,$testscode,$tests,$finame,$currentusercode,$currentuser,$instcode){
		$day = Date('Y-m-d');
	$days = Date('Y-m-d H:i:s');		
			
		$sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $requestcode);
		$st->BindParam(8, $testscode);
		$st->BindParam(9, $tests);
		$st->BindParam(10, $finame);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$exe = $st->execute();		
			if($exe){
			//$investigationcontroller->updateinvestigationsattached($requestcode,$currentuser,$currentusercode,$instcode);					
				return '2';
			}else{
				return '0';
			}
	}
	// 2 SEPT 2023,  12 OCT 2021   JOSEPH ADORBOE
	public function attachenonrequestedpatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$itmcode,$itmname,$remarks,$finame,$currentusercode,$currentuser,$instcode){		
		
		$sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE,RES_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $requestcode);
		$st->BindParam(8, $itmcode);
		$st->BindParam(9, $itmname);
		$st->BindParam(10, $finame);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $remarks);
		$exe = $st->execute();		
		if($exe){
				return '2';
			}else{
				return '0';
			}
	}
	
} 
$patientsattachedresultstable = new OctopusPatientsAttachedResultsSql();
?>