<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 23 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_handover
	$handovertable = new OctopusHandoverSql();
*/

class OctopusHandoverSql Extends Engine{
	// 23 SEPT 2023 JOSEPH ADORBOE
	public function getqueryhandover($instcode){		
		$list = ("SELECT * FROM octopus_handover WHERE HO_STATUS = '1' AND HO_INSTCODE = '$instcode'  order by HO_ID DESC");
		return $list;
	}

	// 23 Sept 2023, 1 JUL 2023 JOSEPH ADORBOE 
	public function edithandover($ekey,$handovertitle,$handovernotes,$currentusercode,$currentuser,$instcode){	
		$sql = "UPDATE octopus_handover SET HO_TITLE = ? , HO_NOTES = ?, HO_ACTOR = ?, HO_ACTORCODE = ? WHERE HO_CODE = ? AND HO_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $handovertitle);
		$st->BindParam(2, $handovernotes);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 23 SEPT 2023, 13 FEB 2022   JOSEPH ADORBOE
	public function insert_newhandovernotes($form_key,$handovercode,$day,$handovertitle,$handovernotes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){	
		$type = 'NA';
		$sqlstmt = "INSERT INTO octopus_handover(HO_CODE,HO_NUMBER,HO_DATE,HO_TYPE,HO_TITLE,HO_NOTES,HO_SHIFT,HO_SHIFTCODE,HO_INSTCODE,HO_ACTOR,HO_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $handovercode);
		$st->BindParam(3, $day);
		$st->BindParam(4, $type);
		$st->BindParam(5, $handovertitle);
		$st->BindParam(6, $handovernotes);
		$st->BindParam(7, $currentshift);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$exe = $st->execute();	
		if ($exe) {
			return '2';
		}else{
			return '0';
		}	
	}
	
} 
$handovertable = new OctopusHandoverSql();
?>