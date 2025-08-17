<?php
/*

	AUTHOR: JOSEPH ADORBOE
	DATE: 16 APR 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class StoresController Extends Engine{

	// 19 APR 2022 JOSEPH ADORBOE 
	public function restock($requestcode, $itemcode, $itemqty, $itemtype, $instcode, $days, $currentusercode, $currentuser){	
		$three = 3;
        if ($itemtype == 1) {
            $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_stores_supply SET SSU_STATUS = ? ,SSU_PROCESSACTORCODE = ?,  SSU_PROCESSACTOR = ?,  SSU_PROCESSDATE = ?  WHERE  SSU_CODE = ? AND SSU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }else 

		if ($itemtype == 2) {
            $sql = "UPDATE octopus_st_items SET ITM_STOREQTY = ITM_STOREQTY + ? WHERE ITM_CODE = ? AND ITM_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_stores_supply SET SSU_STATUS = ? ,SSU_PROCESSACTORCODE = ?,  SSU_PROCESSACTOR = ?,  SSU_PROCESSDATE = ?  WHERE  SSU_CODE = ? AND SSU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }else 

		if ($itemtype == 3) {
            $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_stores_supply SET SSU_STATUS = ? ,SSU_PROCESSACTORCODE = ?,  SSU_PROCESSACTOR = ?,  SSU_PROCESSDATE = ?  WHERE  SSU_CODE = ? AND SSU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }
		
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function removerequestitems($ekey,$currentusercode,$currentuser,$instcode){	
		$zero = '0';
		$sql = "UPDATE octopus_stores_supply SET SSU_STATUS = ? , SSU_ACTORCODE = ?, SSU_ACTOR = ? WHERE SSU_CODE = ? AND SSU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function editrequestitems($ekey,$requestedqty,$currentusercode,$currentuser,$instcode){	
		
		$sql = "UPDATE octopus_stores_supply SET SSU_REQUESTEDQTY = ? , SSU_ACTORCODE = ?, SSU_ACTOR = ? WHERE  SSU_CODE = ? AND SSU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $requestedqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 17 APR 2022 ,  JOSEPH ADORBOE
    public function saverequestions($requestitemcode, $requestionnumber, $itemcode, $itemname, $itemnumber, $itemqty, $requiredqty, $type,$instcode, $desc,$day, $currentusercode, $currentuser){
	
		$one = 1;
		$sqlstmt = ("SELECT SSU_ID FROM octopus_stores_supply where SSU_ITEMCODE = ? AND SSU_INSTCODE = ? AND SSU_STATUS = ? AND SSU_REQUESTIONNUM = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $requestionnumber);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{
				
			$sqlstmt = "INSERT INTO octopus_stores_supply(SSU_CODE,SSU_REQUESTIONNUM,SSU_DATE,SSU_CODENUM,SSU_ITEMCODE,SSU_ITEM,SSU_QTY,SSU_ACTORCODE,SSU_ACTOR,SSU_INSTCODE,SSU_REQUESTEDQTY,SSU_TYPE,SSU_DESC) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $requestitemcode);
			$st->BindParam(2, $requestionnumber);
			$st->BindParam(3, $day);
			$st->BindParam(4, $itemnumber);
			$st->BindParam(5, $itemcode);
			$st->BindParam(6, $itemname);
			$st->BindParam(7, $itemqty);
			$st->BindParam(8, $currentusercode);
			$st->BindParam(9, $currentuser);
			$st->BindParam(10, $instcode);
			$st->BindParam(11, $requiredqty);
			$st->BindParam(12, $type);	
			$st->BindParam(13, $desc);		
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
} 
?>