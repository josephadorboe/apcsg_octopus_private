<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 
	BASED: octopus_userlog	
	$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$day);
*/

class UsersEventLogSql Extends Engine{
	// 24 DEC 2024,  JOSEPH ADORBOE  
    public function auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$day){
		$sql = 'SELECT FORM_ID FROM octopus_userformlogs WHERE FORM_KEY = ? AND FORM_NUMBER = ? AND FORM_ACTORCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $form_number);
		$st->BindParam(3, $currentusercode);
		$vxt = $st->execute();
		if($vxt){
			if($st->rowcount() > 0){			
				return '1';
			}else{
				$sql = ("INSERT INTO octopus_userformlogs (FORM_NUMBER,FORM_KEY,FORM_ACTORCODE,FORM_ACTOR,FORM_INSTCODE) VALUES (?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_number);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $currentuser);		
				$st->BindParam(5, $instcode);
				$exeformlogs = $st->execute();

				$sqlstmt = ("INSERT INTO octopus_usereventlog (EV_CODE,EV_USERCODE,EV_USER,EV_LOGNUMBER,EV_LOG,EV_DATE,EV_INSTCODE) VALUES (?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $eventcode);
				$st->BindParam(5, $event);
				$st->BindParam(6, $day);
				$st->BindParam(7, $instcode);
			//	$st->BindParam(8, $form_key);
				$exeuserlogs = $st->execute();	
				return '2';																					
			}

		}else{
			return '0';
		}
	}


} 

$usereventlogtable = new UsersEventLogSql()
?>