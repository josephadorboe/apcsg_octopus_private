<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 28 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_devices
	$devicesetuptable->calculatedevicestockvalue($itemcode,$instcode)
*/

class OctopusDevicesSql Extends Engine{

	// 25 DEC 2023, ,  25 DEC 2022  JOSEPH ADORBOE
	public function returntosupplierdevicesbulk($returnqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $returnqty);
		$st->BindParam(2, $itemcode);
		$st->BindParam(3, $instcode);

		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	//27 MAR 2021
	public function getdeviceslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm' and DEV_INSTCODE = '$instcode' order by DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= 0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'@@@'.$obj['DEV_DEVICE'].'">'.$obj['DEV_DEVICE'].' - '.$obj['DEV_QTY'].' </option>';
		}
	}


	// 24 DEC 2023, JOSEPH ADORBOE
	public function calculatedevicestockvalue($itemcode,$instcode){
		$sql = "UPDATE octopus_st_devices SET DEV_STOCKVALUE = DEV_TOTALQTY*DEV_CASHPRICE WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
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

	//24 DEC 2023, JOSEPH ADORBOE
	public function updatedevicesapprove($itemcode,$addqty,$costprice,$cashprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY =DEV_STOREQTY  + ?,  DEV_TOTALQTY = DEV_TOTALQTY  + ?, DEV_CASHPRICE =? , DEV_COSTPRICE =?, DEV_INSURANCEPRICE =?,  DEV_PARTNERPRICE =?, DEV_DOLLARPRICE = ?
		WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $cashprice);
		$st->BindParam(4, $costprice);
		$st->BindParam(5, $insuranceprice);
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

	// 22 DEC 2023  JOSEPH ADORBOE
	public function modifymedicationqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue,$currentuser, $currentusercode, $instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_QTY = ?, DEV_STOREQTY =?, DEV_TRANSFER = ?, DEV_TOTALQTY = ?, DEV_STOCKVALUE = ? , DEV_ACTOR = ?, DEV_ACTORCODE = ? WHERE DEV_CODE = ? AND DEV_STATUS = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $pharmacyqty);
		$st->BindParam(2, $storeqty);
		$st->BindParam(3, $transferqty);
		$st->BindParam(4, $totalqty);
		$st->BindParam(5, $stockvalue);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $currentusercode);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 22 DEC 2023 JOSEPH ADORBOE
	public function updatedevicesprices($itemcode,$costprice,$cashprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,$insuranceprice,$instcode){
		$sql = "UPDATE octopus_st_devices SET DEV_COSTPRICE = ?  , DEV_CASHPRICE = ?  , DEV_STOCKVALUE = ?, DEV_PARTNERPRICE = ?, DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ?, DEV_INSURANCEPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $costprice);
		$st->BindParam(2, $cashprice);
		$st->BindParam(3, $stockvalue);
		$st->BindParam(4, $partnerprice);
		$st->BindParam(5, $alternateprice);
		$st->BindParam(6, $dollarprice);
		$st->BindParam(7, $insuranceprice);
		$st->BindParam(8, $itemcode);
		$st->BindParam(9, $instcode);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 22 DEC 2023, JOSEPH ADORBOE
	public function returntosupplierdevices($returnqty,$newtotalqty,$itemcode,$stockvalue,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ? , DEV_TOTALQTY =  ?,  DEV_STOCKVALUE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $returnqty);
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

	// 22 DEC 2023, JOSEPH ADORBOE
	public function returntostoresdevices($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? , DEV_QTY = DEV_QTY - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
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

	// 22 DEC  2023, JOSEPH ADORBOE
	public function transferdevices($transferqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ? , DEV_TRANSFER = DEV_TRANSFER + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $transferqty);
		$st->BindParam(2, $transferqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 20 DEC 2023 , JOSEPH ADORBOE
	public function restockdevices($itemcode,$suppliedqty,$totalqty,$costprice,$newprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,
	$insuranceprice,$instcode){
			$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? , DEV_TOTALQTY = ? , DEV_COSTPRICE = ?  , DEV_CASHPRICE = ?  , DEV_STOCKVALUE = ?, DEV_PARTNERPRICE = ?, DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ?, DEV_INSURANCEPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $suppliedqty);
			$st->BindParam(2, $totalqty);
			$st->BindParam(3, $costprice);
			$st->BindParam(4, $newprice);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $partnerprice);
			$st->BindParam(7, $alternateprice);
			$st->BindParam(8, $dollarprice);
			$st->BindParam(9, $insuranceprice);
			$st->BindParam(10, $itemcode);
			$st->BindParam(11, $instcode);
      		$exe = $st->Execute();
				if($exe){
					return '2';
				}else{
					return '0';
				}
	}

	// 20 DEC 2023, 25 OCT 2022 JOSEPH ADORBOE 
	public function devicesdetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_devices WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['DEV_DEVICE'].'@@'.$obj['DEV_RESTOCK'].'@@'.$obj['DEV_QTY'].'@@'.$obj['DEV_STOREQTY'].'@@'.$obj['DEV_TRANSFER'].'@@'.$obj['DEV_LASTDATE'].'@@'.$obj['DEV_TOTALQTY'].'@@'.$obj['DEV_INSURANCEPRICE'].'@@'.$obj['DEV_CASHPRICE'].'@@'.$obj['DEV_COSTPRICE'].'@@'.$obj['DEV_STOCKVALUE'].'@@'.$obj['DEV_OTHERPRICE'].'@@'.$obj['DEV_CODENUM'].'@@'.$obj['DEV_PARTNERPRICE'].'@@'.$obj['DEV_DOLLARPRICE'].'@@'.$obj['DEV_STATUS'];				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}


	// 20 DEC 2023, JOSEPH ADORBOE
    public function adddevices($form_key,$devices,$devicenumber,$restock,$days,$description,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){
		$zero = '0';			
		$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices where DEV_DEVICE = ? and  DEV_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $devices);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_INSTCODE,DEV_LASTDATE,DEV_ACTOR,DEV_ACTORCODE,DEV_RESTOCK,DEV_QTY,DEV_STOREQTY,DEV_TRANSFER,DEV_TOTALQTY,DEV_INSURANCEPRICE,DEV_OTHERPRICE,DEV_PARTNERPRICE,DEV_DOLLARPRICE,DEV_CASHPRICE,DEV_COSTPRICE,DEV_STOCKVALUE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $devicenumber);
				$st->BindParam(3, $devices);
				$st->BindParam(4, $description);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $restock);
				$st->BindParam(10, $zero);
				$st->BindParam(11, $storeqty);
				$st->BindParam(12, $zero);
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

	// 28 SEPT 2023 JOSEPH ADORBOE
	public function getquerysetupdevicesdisabled($instcode){
		$zero = '0';		
		$list = ("SELECT * from octopus_st_devices where DEV_INSTCODE = '$instcode' AND DEV_STATUS = '$zero' order by DEV_DEVICE ");
		return $list;
	}


	// 28 SEPT 2023 JOSEPH ADORBOE
	public function getquerysetupdevices($instcode){	
		$one = '1';	
		$list = ("SELECT * from octopus_st_devices where DEV_INSTCODE = '$instcode' AND DEV_STATUS = '$one' order by DEV_DEVICE ");
		return $list;
	}

	// 21 NOV 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function rejecttransferdevices($itemqty,$itemcode,$instcode){
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? , DEV_TRANSFER = DEV_TRANSFER - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
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
	public function accepttransferdevices($itemqty,$itemcode,$instcode){
		$sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY + ? , DEV_TRANSFER = DEV_TRANSFER - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";	$st = $this->db->prepare($sql);
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
	// 10 oct  2023,  25 DEC 2022  JOSEPH ADORBOE
	public function updatedeviceslastsold($devicescode,$days,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_devices SET DEV_LASTDATE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? AND  DEV_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $devicescode);
		$st->BindParam(3, $instcode);	
		$st->BindParam(4, $one);						
		$exe = $st->execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	public function enabledevices($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one = 1;
		$reason = 'ENABLE';
		$sql = "UPDATE octopus_st_devices SET DEV_REASON = ?,  DEV_REASONDATE = ?, DEV_REASONACTOR =?, DEV_REASONACTORCODE =? , DEV_STATUS =? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $reason);
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
	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	public function disabledevices($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		// 9999
		$zero = '0';
		$sql = "UPDATE octopus_st_devices SET DEV_REASON = ?,  DEV_REASONDATE = ?, DEV_REASONACTOR =?, DEV_REASONACTORCODE =? , DEV_STATUS =? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
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

	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	public function editdevice($ekey,$devices,$description,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_st_devices SET DEV_DEVICE = ?,  DEV_DESC = ?, DEV_ACTOR =?, DEV_ACTORCODE =? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $devices);
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

	// 28 sept 2023,  20 DEC 2022 ,  JOSEPH ADORBOE
    public function newdevices($form_key,$devices,$devicenumber,$restock,$days,$description,$currentuser,$currentusercode,$instcode){			
		$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices where DEV_DEVICE = ? and  DEV_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $devices);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_INSTCODE,DEV_LASTDATE,DEV_ACTOR,DEV_ACTORCODE,DEV_RESTOCK) 
				VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $devicenumber);
				$st->BindParam(3, $devices);
				$st->BindParam(4, $description);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $restock);
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

$devicesetuptable = new OctopusDevicesSql();
?>