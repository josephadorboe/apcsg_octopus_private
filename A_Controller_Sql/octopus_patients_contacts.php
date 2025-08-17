<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 3 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_contacts
	$patientcontactstable->getpatientcontactdetails($patientcode,$instcode);
*/

class OctopusPatientsContactsSql Extends Engine{

	// 29 NOV 2024 , JOSEPH ADORBOE
	public function getpatientcontactdetails(String $patientcode,String $instcode) : mixed{	
		$one = '1';	
		$sql = 'SELECT PC_PHONE,PC_PHONEALT,PC_HOMEADDRESS,PC_EMAIL,PC_POSTAL,PC_EMERGENCYONE,PC_EMERGENCYTWO FROM octopus_patients_contacts WHERE PC_PATIENTCODE = ? AND PC_INSTCODE = ? AND PC_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->theone);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				//						0						1						2										
				$currentdetails = $obj['PC_PHONE'].'@'.$obj['PC_PHONEALT'].'@'.$obj['PC_HOMEADDRESS'].'@'.$obj['PC_EMAIL'].'@'.$obj['PC_POSTAL'].'@'.$obj['PC_EMERGENCYONE'].'@'.$obj['PC_EMERGENCYTWO'];				
				return $currentdetails;					
			}else{
				return $this->thezero;
			}
		}else{
			return $this->thezero;
		}	
	}
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumbercontacts($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode) : Int {
		$sqlstmt = "UPDATE octopus_patients_contacts SET PC_PATIENTNUMBER = ?, PC_ACTOR = ?, PC_ACTORCODE =?  where PC_PATIENTCODE = ? and PC_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();
		if($exe){				
			return $this->thetwo;
		}else{				
			return $this->thezero;				
		}	
	}

	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientcontacts($ekey,$patientaltphone,$patientpostal,$patienthomeaddress,$patientemail,$patientphone,$patientemergencyone,$patientemergencytwo,$currentusercode,$currentuser,$instcode) : Int {
		$sql = "UPDATE octopus_patients_contacts SET PC_PHONE = ?, PC_PHONEALT = ? , PC_HOMEADDRESS = ?, PC_EMAIL = ? ,PC_POSTAL = ?, PC_EMERGENCYONE =? , PC_EMERGENCYTWO =?, PC_ACTOR =?, PC_ACTORCODE =? WHERE PC_PATIENTCODE = ? AND PC_INSTCODE = ?";
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
		$st->BindParam(11, $instcode);
		$exe = $st->execute();		
		if($exe){				
			return $this->thetwo;
		}else{				
			return $this->thezero;				
		}	
	}
	
} 
$patientcontactstable = new OctopusPatientsContactsSql();

?>