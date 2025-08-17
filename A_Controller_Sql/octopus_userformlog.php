<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_userformlogs
	$userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
*/

class OctopusUserFormLogSql Extends Engine{
	// 24 DEC 2024, JOSEPH ADORBOE
	public function checkformactionkey($form_number,$form_key,$currentusercode){	
		$statu = '1';
		$sql = 'SELECT FORM_ID FROM octopus_userformlogs WHERE FORM_KEY = ? AND FORM_NUMBER = ? AND FORM_ACTORCODE = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $form_number);
		$st->BindParam(3, $currentusercode);
		$action = $st->execute();
		if($action){
			if($st->rowcount() > 0){		
				return '0';					
			}else{
				return '1';
			}
		}else{
			return '-1';
		}		
	
    }
	
	
} 
	$userformlogtable = new OctopusUserFormLogSql();
?>