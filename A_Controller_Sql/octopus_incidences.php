<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 1 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_incidences
	$incidencetable = new OctopusIncidencesSql();
*/

class OctopusIncidencesSql Extends Engine{	

	// 1 SEPT 2023 
	public function selectincidence($instcode,$currentusercode){
		$list = ("SELECT * FROM octopus_incidences WHERE IND_STATUS = '1' AND IND_INSTCODE = '$instcode' AND IND_ACTORCODE = '$currentusercode'  order by IND_ID DESC ");
		return $list;
	}
	// 1 SEPT 2023 
	public function selectallincidence($instcode){
		$list = ("SELECT * FROM octopus_incidences WHERE IND_STATUS = '1' AND IND_INSTCODE = '$instcode' order by IND_ID DESC ");
		return $list;
	}	

	// 1 SEPT 2023, 20 OCT 2021    JOSEPH ADORBOE
	public function insert_newincidence($form_key,$incidencecode,$days,$incidencetitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){	
		
		$sqlstmt = "INSERT INTO octopus_incidences(IND_CODE,IND_NUMBER,IND_DATE,IND_TYPE,IND_TITLE,IND_DESCRIPTION,IND_SHIFT,IND_SHIFTCODE,IND_INSTCODE,IND_ACTOR,IND_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $incidencecode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $type);
		$st->BindParam(5, $incidencetitle);
		$st->BindParam(6, $notes);
		$st->BindParam(7, $currentshift);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$exe = $st->execute();	
		if($exe){					
			return '2';										
		}else{								
			return '0';								
		}				
		
	}
	
}
$incidencetable = new OctopusIncidencesSql(); 
?>