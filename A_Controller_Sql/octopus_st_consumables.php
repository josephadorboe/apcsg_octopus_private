<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 NOV 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_consumables
	$consumablesetuptable->calculatestockvalue($itemcode,$instcode); 
*/

class OctopusSetupConsumablesSql Extends Engine{	

	// 25 NOV 2023 JOSEPH ADORBOE 
	public function getconsumableqty($consumablecode,$instcode){	
		$one = 1;
		$sql = "SELECT COM_QTY FROM octopus_st_consumables WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consumablecode);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$qty = $obj['COM_QTY'];				
		}else{			
			$qty = '0';			
		}
		return 	$qty; 	
		
	}

	// 5 NOV JOSEPH ADORBOE
	public function getconsumableslistdisable($instcode){		
		$list = ("SELECT * FROM octopus_st_consumables WHERE COM_INSTCODE = '$instcode' AND COM_STATUS IN('0') ORDER BY COM_CONSUMABLE ASC ");
		return $list;
	}
	
	// 5 NOV JOSEPH ADORBOE
	public function getconsumableslist($instcode){		
		$list = ("SELECT * FROM octopus_st_consumables WHERE COM_INSTCODE = '$instcode' AND COM_STATUS IN('1') ORDER BY COM_CONSUMABLE ASC ");
		return $list;
	}

	// 27 SEPT 2024  JOSEPH ADORBOE
	public function addconsumables($consumablecode,$consumableqty,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_QTY = COM_QTY + ? WHERE COM_CODE = ? and COM_INSTCODE = ?";
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

	// 23 NOV 2023,  JOSEPH ADORBOE
	public function deductconsumables($consumablecode,$consumableqty,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_QTY = COM_QTY - ? WHERE COM_CODE = ? and COM_INSTCODE = ?";
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

	// 21 NOV 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function rejecttransferconsumable($itemqty,$itemcode,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = COM_STOREQTY + ? , COM_TRANSFER = COM_TRANSFER - ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";	
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemqty);
		$st->BindParam(2, $itemqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 20 NOV 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function accepttransferconsumable($itemqty,$itemcode,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_QTY = COM_QTY + ? , COM_TRANSFER = COM_TRANSFER - ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";	
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemqty);
		$st->BindParam(2, $itemqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 12 NOV 2023, JOSEPH ADORBOE
	public function calculatestockvalue($itemcode,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_STOCKVALUE = COM_TOTALQTY*COM_CASHPRICE WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 12 NOV 2023, JOSEPH ADORBOE
	public function updateconsumable($itemcode,$addqty,$costprice,$newprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY =COM_STOREQTY  + ?,  COM_TOTALQTY = COM_TOTALQTY  + ?, COM_CASHPRICE =? , COM_COSTPRICE =?, COM_INSURANCEPRICE =?, COM_OTHERPRICE =?, COM_PARTNERPRICE =?, COM_DOLLARPRICE = ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $newprice);
		$st->BindParam(4, $costprice);
		$st->BindParam(5, $insuranceprice);
		$st->BindParam(6, $alternateprice);
		$st->BindParam(7, $partnerprice);
		$st->BindParam(8, $dollarprice);
		$st->BindParam(9, $itemcode);
		$st->BindParam(10, $instcode);
	//	$st->BindParam(11, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 11 NOV 2023, JOSEPH ADORBOE
	public function changeqty($itemcode,$totalqty,$storeqty,$transferqty,$pharmacyqty,$stockvalue,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_QTY = ?, COM_STOREQTY = ? , COM_TRANSFER = ?, COM_TOTALQTY = ?, COM_STOCKVALUE = ? WHERE COM_CODE = ? AND COM_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $pharmacyqty);
		$st->BindParam(2, $storeqty);
		$st->BindParam(3, $transferqty);
		$st->BindParam(4, $totalqty);
		$st->BindParam(5, $stockvalue);
		$st->BindParam(6, $itemcode);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 11 NOV 2023, JOSEPH ADORBOE
	public function changeprice($itemcode,$costprice,$newprice,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_consumables SET COM_STOCKVALUE =?, COM_CASHPRICE =? , COM_COSTPRICE =?, COM_INSURANCEPRICE =?, COM_OTHERPRICE =?, COM_PARTNERPRICE =?, COM_DOLLARPRICE = ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $stockvalue);
		$st->BindParam(2, $newprice);
		$st->BindParam(3, $costprice);
		$st->BindParam(4, $insuranceprice);
		$st->BindParam(5, $alternateprice);
		$st->BindParam(6, $partnerprice);
		$st->BindParam(7, $dollarprice);
		$st->BindParam(8, $itemcode);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 19 NOV 2023 JOSEPH ADORBOE 
	public function returnconsumabletosup($suppliedqty,$itemcode,$instcode){		
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = COM_STOREQTY - ?, COM_TOTALQTY = COM_TOTALQTY - ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $suppliedqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}		
	}

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function returnconsumabletosupplier($newstoreqty,$newtotalqty,$stockvalue,$itemcode,$instcode){		
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = ?, COM_TOTALQTY = ?, COM_STOCKVALUE = ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $newstoreqty);
		$st->BindParam(2, $newtotalqty);
		$st->BindParam(3, $stockvalue);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}		
	}

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function returnconsumabletostore($suppliedqty,$itemcode,$instcode){		
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = COM_STOREQTY + ?, COM_QTY = COM_QTY - ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $suppliedqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}		
	}

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function transferconsumabletopharmacy($suppliedqty,$itemcode,$instcode){		
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = COM_STOREQTY - ?, COM_TRANSFER = COM_TRANSFER + ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $suppliedqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}		
	}

	// 9 NOV 2023, JOSEPH ADORBOE
	public function restockconsumable($itemcode,$newqty,$costprice,$newprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_consumables SET COM_STOREQTY = ?,  COM_TOTALQTY = ?, COM_STOCKVALUE =?, COM_CASHPRICE =? , COM_COSTPRICE =?, COM_INSURANCEPRICE =?, COM_OTHERPRICE =?, COM_PARTNERPRICE =?, COM_DOLLARPRICE = ? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $newqty);
		$st->BindParam(2, $totalqty);
		$st->BindParam(3, $stockvalue);
		$st->BindParam(4, $newprice);
		$st->BindParam(5, $costprice);
		$st->BindParam(6, $insuranceprice);
		$st->BindParam(7, $alternateprice);
		$st->BindParam(8, $partnerprice);
		$st->BindParam(9, $dollarprice);
		$st->BindParam(10, $itemcode);
		$st->BindParam(11, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 9 NOV 2023 JOSEPH ADORBOE 
	public function consumabledetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_consumables WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['COM_CONSUMABLE'].'@@'.$obj['COM_RESTOCK'].'@@'.$obj['COM_QTY'].'@@'.$obj['COM_STOREQTY'].'@@'.$obj['COM_TRANSFER'].'@@'.$obj['COM_LASTDATE'].'@@'.$obj['COM_TOTALQTY'].'@@'.$obj['COM_INSURANCEPRICE'].'@@'.$obj['COM_CASHPRICE'].'@@'.$obj['COM_COSTPRICE'].'@@'.$obj['COM_STOCKVALUE'].'@@'.$obj['COM_OTHERPRICE'].'@@'.$obj['COM_CODENUM'].'@@'.$obj['COM_PARTNERPRICE'].'@@'.$obj['COM_DOLLARPRICE'].'@@'.$obj['COM_STATUS'];				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}
	// 9 NOV 2023, JOSEPH ADORBOE
	public function enableconsumable($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one = 1;
		$enablereason = 'ENABLE';
		$sql = "UPDATE octopus_st_consumables SET COM_REASON = ?,  COM_REASONDATE = ?, COM_REASONACTOR =?, COM_REASONACTORCODE =? , COM_STATUS =? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $enablereason);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $one);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 9 NOV 2023, JOSEPH ADORBOE
	public function disableconsumable($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_consumables SET COM_REASON = ?,  COM_REASONDATE = ?, COM_REASONACTOR =?, COM_REASONACTORCODE =? , COM_STATUS =? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $disablereason);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 9 NOV 2023, JOSEPH ADORBOE
	public function editconsumable($ekey,$consumable,$description,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_st_consumables SET COM_CONSUMABLE = ?,  COM_DESC = ?, COM_ACTOR =?, COM_ACTORCODE =? WHERE COM_CODE = ? AND COM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consumable);
		$st->BindParam(2, $description);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
	//5 NOV 2023,  JOSEPH ADORBOE
    public function newconsumable($form_key,$consumable,$consumablenumber,$restock,$days,$description,$storeqty,$costprice,$cashprice,$dollarprice,$partnerprice,$alternateprice,$insuranceprice,$transferqty,$qty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){	
		$one  = 1;
		$sqlstmt = ("SELECT COM_ID FROM octopus_st_consumables where COM_CONSUMABLE = ? and  COM_INSTCODE = ? AND COM_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $consumable);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_consumables(COM_CODE,COM_CODENUM,COM_CONSUMABLE,COM_DESC,COM_INSTCODE,COM_LASTDATE,COM_ACTOR,COM_ACTORCODE,COM_RESTOCK,COM_STOREQTY,COM_QTY,COM_TRANSFER,COM_TOTALQTY,COM_INSURANCEPRICE,COM_OTHERPRICE,COM_PARTNERPRICE,COM_DOLLARPRICE,COM_CASHPRICE,COM_COSTPRICE,COM_STOCKVALUE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $consumablenumber);
				$st->BindParam(3, $consumable);
				$st->BindParam(4, $description);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $restock);
				$st->BindParam(10, $storeqty);
				$st->BindParam(11, $qty);
				$st->BindParam(12, $transferqty);
				$st->BindParam(13, $totalqty);
				$st->BindParam(14, $insuranceprice);
				$st->BindParam(15, $alternateprice);
				$st->BindParam(16, $partnerprice);
				$st->BindParam(17, $dollarprice);
				$st->BindParam(18, $cashprice);
				$st->BindParam(19, $costprice);
				$st->BindParam(20, $stockvalue);
				$exe = $st->execute();
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}			
			}
		}else{
			return '1';
		}	
	}
} 
$consumablesetuptable = new OctopusSetupConsumablesSql();
?>