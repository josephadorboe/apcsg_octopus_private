<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 7 oct 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_diagnosis
	$diagnosissetuptable->
*/

class OctopussetupdiagnosisSql Extends Engine{
	// 7 oct 2023 JOSEPH ADORBOE
	public function getquerylabplan($instcode){		
		$list = ("SELECT * FROM octopus_labplans WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
		return $list;
	}
	// 7 oct 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_newdiagnosis($diagnosiscode,$newdiagnosis,$description,$currentusercode,$currentuser,$instcode){	
		$sqlstmt = "INSERT INTO octopus_st_diagnosis(DN_CODE,DN_NAME,DN_DESC,DN_ACTORCODE,DN_ACTOR, DN_INSTCODE) 
		VALUES (?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $diagnosiscode);
		$st->BindParam(2, $newdiagnosis);
		$st->BindParam(3, $description);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}	
} 

$diagnosissetuptable =  new OctopussetupdiagnosisSql();
?>