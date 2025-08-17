<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 30 NOV 2024, JOSEPH ADORBOE 
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopuspatients_users
	$octopuspatientsuserstable->newoctopususer($patientcode,$patientnumber,$patient,$patientphonenumber,$altpatientphonenumber,$patientemail,$currentusercode,$currentuser,$facility,$instcode);
*/

class OctopusPatientsUsersSql Extends Engine{

	// 30 NOV 2024, JOSEPH ADORBOE 
	public function newoctopususer($patientcode,$patientnumber,$patient,$patientphonenumber,$altpatientphonenumber,$patientemail,$currentusercode,$currentuser,$facility,$instcode){
		$one = 1;
		$pwd = md5($patientphonenumber.$patientphonenumber);
		$sqlstmt = ("SELECT * FROM octopuspatients_users where USER_PATIENTCODE = ? AND USER_INSTCODE = ?  AND USER_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
					return '1';						
			}else{
				$usercode = md5(microtime());
				$sqlstmt = "INSERT INTO octopuspatients_users(USER_CODE,USER_USERNAME,USER_PWD,USER_FULLNAME,USER_PHONENUMBER,USER_ALTPHONENUMBER,
				USER_PATIENTNUMBER,USER_EMAIL,USER_PATIENTCODE,USER_FACILITY,USER_FACILITYCODE,USER_ACTORCODE,USER_ACTOR,USER_INSTCODE) 
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $usercode);
				$st->BindParam(2, $patientphonenumber);
				$st->BindParam(3, $pwd);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $patientphonenumber);
				$st->BindParam(6, $altpatientphonenumber);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patientemail);
				$st->BindParam(9, $patientcode);
				$st->BindParam(10, $facility);
				$st->BindParam(11, $instcode);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $instcode);
				$exedd = $st->execute();
				if($exedd){						
					return '2' ;						
				}else{						
					return '0' ;						
				}
				
			}
		}
	}

	
}

$octopuspatientsuserstable = new OctopusPatientsUsersSql();
?>
