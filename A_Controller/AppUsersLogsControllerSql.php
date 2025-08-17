<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 11 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	BASED: octopus_userlog	
*/

class UsersLogsControllerSql Extends Engine{
	// 11 AUG 2023, JOSEPH ADORBOE  
    public function auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day){				
		$sqlstmt = ("INSERT INTO octopus_userlog (USLOG_USERCODE,USLOG_USERNAME,USLOG_FULLNAME,USLOG_LOGTYPECODE,USLOG_DESC,USLOG_DATE,USLOG_INSTCODE,USLOG_CODE) VALUES (?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentusername);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $eventcode);
		$st->BindParam(5, $event);
		$st->BindParam(6, $day);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $form_key);
		$exeuserlogs = $st->execute();
		if($exeuserlogs ){
			$sql = ("INSERT INTO octopus_userformlogs (FORM_NUMBER,FORM_KEY,FORM_ACTORCODE,FORM_ACTOR,FORM_INSTCODE) VALUES (?,?,?,?,?) ");
			$st = $this->db->prepare($sql);   
			$st->BindParam(1, $form_number);
			$st->BindParam(2, $form_key);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $currentuser);		
			$st->BindParam(5, $instcode);
			$exeformlogs = $st->execute();
			if($exeformlogs){
				return '2';
			}else{
				return '0';
			}

		}else{
			return '0';
		}					
	}
} 
?>