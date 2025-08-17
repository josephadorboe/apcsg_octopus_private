<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_procedures_consumables
	$patientprocedureconsumabletable->removeprocedureconsumableused($ekey,$days,$currentusercode,$currentuser,$instcode);
*/

class OctopusPatientsProcedureConsumableusedSql Extends Engine{
	// 9 NOV 2023 JOSEPH ADORBOE
	public function getqueryprocedureconsumableused($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_procedures_consumables WHERE PPDC_INSTCODE = '$instcode' AND PPDC_STATUS != '0' AND PPDC_CONSUMABLECODE = '$idvalue' order by PPDC_DATE DESC ");
		return $list;
	}

	// 9 NOV 2023 JOSEPH ADORBOE
	public function getqueryconsumableused($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_procedures_consumables WHERE PPDC_INSTCODE = '$instcode' AND PPDC_STATUS != '0' AND PPDC_REQUESTCODE = '$idvalue' order by PPDC_DATE DESC ");
		return $list;
	}
	// 27 SEPT 2024,  JOSEPH ADORBOE
	public function removeprocedureconsumableused($ekey,$days,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures_consumables SET PPDC_STATUS = ?,  PPDC_RETURNTIME = ?, PPDC_RETURNACTORCODE = ?, PPDC_RETURNACTOR = ? WHERE PPDC_CODE = ? and PPDC_INSTCODE = ?";
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

	// 31 OCT 2023, 23 JAN 2022  JOSEPH ADORBOE
    public function newprocedureconsumableissued($formkey,$randomnumber,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$consumablecode,$consumablename,$consumableqty,$visitcode,$days,$transactioncode,$currentusercode,$currentuser,$instcode){	
		$one = 1;		
		$sqlstmt = "INSERT INTO octopus_patients_procedures_consumables(PPDC_CODE,PPDC_PROCEDURENUMBER,PPDC_PATIENTCODE,PPDC_PATIENT,PPDC_PATIENTNUMBER,PPDC_VISITCODE,PPDC_REQUESTCODE,PPDC_DATE,PPDC_PROCEDURECODE,PPDC_PROCEDURE,PPDC_CONSUMABLECODE,PPDC_CONSUMABLE,PPDC_QTY,PPDC_ACTOR,PPDC_ACTORCODE,PPDC_INSTCODE) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $formkey);
		$st->BindParam(2, $randomnumber);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $patientnumber);				
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $transactioncode);
		$st->BindParam(8, $days);
		$st->BindParam(9, $procedurecode);
		$st->BindParam(10, $procedurename);
		$st->BindParam(11, $consumablecode);
		$st->BindParam(12, $consumablename);
		$st->BindParam(13, $consumableqty);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{
			return '0';
		}			
		
	}

	
} 

$patientprocedureconsumabletable =  new OctopusPatientsProcedureConsumableusedSql();
?>