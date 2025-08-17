<?php
/*  AUTHOR: JOSEPH ADORBOE
	DATE: 2 OCT 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class ProcedureController Extends Engine{

	// 31 OCT 2022 JOSEPH ADORBOE
	public function deductconsumables($consumablecode,$consumableqty,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY - ? WHERE MED_CODE = ? and MED_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consumableqty);
		$st->BindParam(2, $consumablecode);
		$st->BindParam(3, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 31 OCT 2022 JOSEPH ADORBOE
	public function dispenseprocedure($transactioncode,$currentusercode,$currentuser,$instcode){
		$two =2;
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_DISPENSE = ? WHERE PPD_CODE = ? and PPD_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $transactioncode);
		$st->BindParam(3, $instcode);
		// $st->BindParam(4, $currentuser);
		// $st->BindParam(5, $ekey);
		// $st->BindParam(6, $instcode);
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

	// 31 OCT 2022 JOSEPH ADORBOE
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

	// 31 OCT 2022 JOSEPH ADORBOE
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
    public function newprocedureconsumable($formkey,$procedurecode,$procedurename,$consumablecode,$consumablename,$qty,$days,$currentusercode,$currentuser,$instcode){	
		$one = 1;
		// $sqlstmt = ("SELECT PCO_ID FROM octopus_st_procedure_consumables where PCO_PROCEDURECODE = ? and  PCO_INSTCODE = ?  AND PCO_STATUS = ?");
		// $st = $this->db->prepare($sqlstmt);   
		// $st->BindParam(1, $procedurecode);
		// $st->BindParam(2, $instcode);
		// $st->BindParam(3, $one);
		// $check = $st->execute();
		// if($check){
		// 	if($st->rowcount() > 0){			
		// 		$sqlstmt = "INSERT INTO octopus_st_procedure_consumables(PCO_CODE,PCO_PROCEDURECODE,PCO_PROCEDURE,PCO_CONSUMABLECODE,PCO_CONSUMABLE,PCO_QTY,PCO_DATE,PCO_ACTOR,PCO_ACTORCODE,PCO_INSTCODE) 
		// 		VALUES (?,?,?,?,?,?,?,?,?,?) ";
		// 		$st = $this->db->prepare($sqlstmt);   
		// 		$st->BindParam(1, $formkey);
		// 		$st->BindParam(2, $procedurecode);
		// 		$st->BindParam(3, $procedurename);
		// 		$st->BindParam(4, $consumablecode);
		// 		$st->BindParam(5, $consumablename);				
		// 		$st->BindParam(6, $qty);
		// 		$st->BindParam(7, $days);
		// 		$st->BindParam(8, $currentuser);
		// 		$st->BindParam(9, $currentusercode);
		// 		$st->BindParam(10, $instcode);
		// 		$exe = $st->execute();
		// 		if($exe){				
		// 			return '2';
		// 		}else{
		// 			return '0';
		// 		}					
		// 	}else{
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
		// 	}
		// }else{
		// 	return '0';
		// }	
	}

	
	// 2 OCT 2022 JOSEPH ADORBOE
	public function returnprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_RETURN = ?, PPD_RETURNTIME = ? , PPD_RETURNACTOR = ?, PPD_RETURNACTORCODE = ? , PPD_RETURNREASON = ?  WHERE PPD_CODE = ? and  PPD_RETURN = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 2 OCT 2022 JOSEPH ADORBOE
	public function archivepastedprocedures($thereviewday,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_ARCHIVE = ?,  PPD_PACTOR = ?, PPD_PACTORCODE = ? WHERE PPD_DATE < ? and  PPD_ARCHIVE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $thereviewday);
		$st->BindParam(5, $zero);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 2 OCT 2022 JOSEPH ADORBOE
	public function editpharamcyarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_ARCHIVE = ?, PPD_PROCESSTIME = ? , PPD_PACTOR = ?, PPD_PACTORCODE = ?  WHERE PPD_CODE = ? and  PPD_ARCHIVE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}



	

} 
?>