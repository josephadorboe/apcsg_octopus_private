<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 17 JUNE 2024 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_glucosemonitor
	$patientsglucosemonitortable->update_patientglucosemonitor($ekey,$type,$gludate,$gvalue,$remark,$currentusercode,$currentuser,$instcode);
*/

	class OctopusPatientsGlucosemonitorSql Extends Engine{

		// 17 JUNE 2024, JOSEPH ADORBOE
		public function getglucosemonitorlist($instcode){
			$list = ("SELECT * FROM octopus_patients_glucosemonitor WHERE GM_INSTCODE = '$instcode' AND GM_STATUS = '1' ORDER BY GM_ID DESC ");										
			return $list;
		}
		// 17 JUNE 2024 , 06 MAR 2022 JOSEPH ADORBOE
		public function update_patientglucosemonitor($ekey,$type,$gludate,$gvalue,$remark,$currentusercode,$currentuser,$instcode){
			$two = 2 ;
			$one = 1 ;
			$sql = "UPDATE octopus_patients_glucosemonitor SET GM_TYPE = ? ,GM_VALUE = ? ,GM_REMARK = ? ,GM_ACTOR = ? ,GM_ACTORCODE = ? , GM_DATE =?  WHERE GM_CODE = ? AND GM_INSTCODE = ?";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $type);
			$st->BindParam(2, $gvalue);
			$st->BindParam(3, $remark);
			$st->BindParam(4, $currentuser);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $gludate);
			$st->BindParam(7, $ekey);
			$st->BindParam(8, $instcode);
			$exe = $st->execute();		
			if($exe){		
				return '2';							
			}else{								
				return '0';								
			}	
		}
		// 17 JUNE 2024, JOSEPH ADORBOE
		public function insert_patientglucosemonitor($form_key,$patientcode,$patientnumber,$patient,$gnumber,$type,$gludate,$age,$gender,$gvalue,$remark,$currentusercode,$currentuser,$instcode){			
			$sqlstmt = "INSERT INTO octopus_patients_glucosemonitor(GM_CODE,GM_NUMBER,GM_DATE,GM_PATIENTCODE,GM_PATIENTNUMBER,GM_PATIENT,GM_AGE,GM_GENDER,GM_TYPE,GM_VALUE,GM_REMARK,GM_ACTOR,GM_ACTORCODE,GM_INSTCODE) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $gnumber);
			$st->BindParam(3, $gludate);
			$st->BindParam(4, $patientcode);
			$st->BindParam(5, $patientnumber);
			$st->BindParam(6, $patient);
			$st->BindParam(7, $age);
			$st->BindParam(8, $gender);
			$st->BindParam(9, $type);
			$st->BindParam(10, $gvalue);
			$st->BindParam(11, $remark);
			$st->BindParam(12, $currentuser);
			$st->BindParam(13, $currentusercode);
			$st->BindParam(14, $instcode);
			$exe = $st->execute();										
			if($exe){								
				return '2';								
			}else{								
				return '0';								
			}
					
		}
		
		
	} 

	$patientsglucosemonitortable = new OctopusPatientsGlucosemonitorSql();
?>