<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_procedure_consumables
	$procedureconsumabletable->getissueprocedureconsumable($itemcode,$instcode);
*/

class OctopusProcedureConsumableSql Extends Engine{
	// 22 NOV 2023 JOSEPH ADORBOE
	public function getqueryprocedureconsumabletoused($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_st_procedure_consumables WHERE PCO_INSTCODE = '$instcode' AND PCO_STATUS = '1' AND PCO_PROCEDURECODE = '$idvalue' order by PCO_DATE DESC ");
		return $list;
	}

	// 9 NOV 2023 JOSEPH ADORBOE
	public function getqueryprocedureconsumableused($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_st_procedure_consumables WHERE PCO_INSTCODE = '$instcode' AND PCO_STATUS != '0' AND PCO_CONSUMABLECODE = '$idvalue' order by PCO_DATE DESC ");
		return $list;
	}

	// 27 SEPT 2024 , JOSEPH ADORBOE 
	public function getissueprocedureconsumable($itemcode,$instcode){
		$list = ("SELECT * from octopus_st_procedure_consumables where PCO_PROCEDURECODE = '$itemcode' and  PCO_INSTCODE = '$instcode' and PCO_STATUS = '1' order by PCO_CONSUMABLE DESC  ");
		return $list;
	}                                                  	

	// 22 NOV 2023 JOSEPH ADORBOE
	public function removeprocedureconsumable($ekey,$days,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_st_procedure_consumables SET PCO_STATUS = ?,  PCO_DATE = ?, PCO_ACTORCODE = ?, PCO_ACTOR = ? WHERE PCO_CODE = ? and PCO_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}


	// 22 NOV 2023, 31 OCT 2022 , JOSEPH ADORBOE
	public function editprocedureconsumable($ekey,$qty,$days,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_st_procedure_consumables SET PCO_QTY = ?,  PCO_DATE = ?, PCO_ACTORCODE = ?, PCO_ACTOR = ? WHERE PCO_CODE = ? and PCO_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}

	// 31 OCT 2023, 23 JAN 2022  JOSEPH ADORBOE
    public function newprocedureconsumabletouse($formkey,$procedurecode,$procedurename,$consumablecode,$consumablename,$qty,$days,$currentusercode,$currentuser,$instcode){	
		$one = 1;		
		$sqlstmt = "INSERT INTO octopus_st_procedure_consumables(PCO_CODE,PCO_PROCEDURECODE,PCO_PROCEDURE,PCO_CONSUMABLECODE,PCO_CONSUMABLE,PCO_QTY,PCO_DATE,PCO_ACTOR,PCO_ACTORCODE,PCO_INSTCODE) 
		VALUES (?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $formkey);
		$st->BindParam(2, $procedurecode);
		$st->BindParam(3, $procedurename);
		$st->BindParam(4, $consumablecode);
		$st->BindParam(5, $consumablename);				
		$st->BindParam(6, $qty);
		$st->BindParam(7, $days);
		$st->BindParam(8, $currentuser);
		$st->BindParam(9, $currentusercode);
		$st->BindParam(10, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{
			return '0';
		}		
	}	
} 

$procedureconsumabletable =  new OctopusProcedureConsumableSql();
?>