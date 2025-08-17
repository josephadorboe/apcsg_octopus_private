<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_pharmacy_stockadjustment
	$stockadjustmenttable->revrse_stockadjustments($ajustcode,$instcode);
*/
 	
class OctopusStockadjustmentSql Extends Engine{

	// 26 NOV 2024,  JOSEPH ADORBOE
	public function revrse_stockadjustments($ajustcode,$instcode){
		$one = '1';
		$sqlstmt = "DELETE * FROM octopus_pharmacy_stockadjustment  where SA_CODE = ? and  SA_INSTCODE = ?  and SA_STATUS = ? ";		
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);		
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 14 NOV 2024, JOSEPH ADORBOE
	public function editstockadjustment($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$expire,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ?, SA_COSTPRICE =  ?, SA_NEWPRICE = ? , SA_INSURANCEPRICE = ?, SA_DOLLARPRICE = ?, SA_EXPIRY = ? , SA_ACTOR = ?, SA_ACTORCODE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $costprice);
		$st->BindParam(3, $cashprice);
		$st->BindParam(4, $insuranceprice);
		$st->BindParam(5, $dollarprice);
		$st->BindParam(6, $expire);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $ekey);
		$st->BindParam(10, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 14 NOV 2024, JOSEPH ADORBOE
	public function editstockadjustmentbybatchcode($batchcode,$suppliedqty,$expire,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ?, SA_EXPIRY = ? , SA_ACTOR = ?, SA_ACTORCODE = ? WHERE SA_BATCHCODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $expire);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $batchcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 20 FEB 2024, JOSEPH ADORBOE
	public function gettransfersitemspending($instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment WHERE SA_INSTCODE = '$instcode' AND SA_STATUS ='1' AND SA_STATE = '1' AND SA_TYPE IN('8') ORDER BY SA_DATETIME ASC ");
		return $list;
	}
	// 16 NOV 2023 JOSEPH ADORBOE
	public function gettransferspending($instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment WHERE SA_INSTCODE = '$instcode' AND SA_STATUS ='1' AND SA_STATE = '1' AND SA_TYPE IN('2','5','11') ORDER BY SA_DATETIME ASC ");
		return $list;
	}

	// 16 NOV 2023 JOSEPH ADORBOE
	public function getreturntosupplier($type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  IN($type) AND SA_INSTCODE = '$instcode' AND SA_STATE = '1' AND SA_BATCHNUMBER != '0' order by SA_DATETIME desc");
		return $list;
	}
	// 13 NOV 2023 JOSEPH ADORBOE
	public function getpendingreturntostores($type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_STATE = '0' order by SA_DATETIME desc");
		return $list;
	}

	// 13 NOV 2023 JOSEPH ADORBOE
	public function getpendingtransfer($type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_STATE = '0' AND SA_BATCHNUMBER != '0' order by SA_DATETIME desc");
		return $list;
	}

	// 11 NOV 2023 JOSEPH ADORBOE getpendingtransfer
	public function getpendingrestock($type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_STATE = '0' order by SA_DATETIME desc");
		return $list;
	}
	// 12 NOV 2023 JOSEPH ADORBOE
	public function getrestockgeneralreport($type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_STATE = '1' order by SA_DATETIME desc");
		return $list;
	}
	// 11 NOV 2023 JOSEPH ADORBOE
	public function getrestockreport($idvalue,$type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_MEDICATIONCODE = '$idvalue' AND SA_STATE = '1' order by SA_DATETIME desc");
		return $list;
	}

	// 5 DEC 2023 JOSEPH ADORBOE
	public function getadjustmentreport($idvalue,$type,$instcode){
		$list = ("SELECT * FROM octopus_pharmacy_stockadjustment  WHERE SA_STATUS != '0' AND SA_TYPE  = '$type' AND SA_INSTCODE = '$instcode' AND SA_MEDICATIONCODE = '$idvalue' AND SA_STATE = '1' order by SA_DATETIME desc");
		return $list;
	}

	// 21 FEB 2024
	public function getgeneralitemtransfercounts(String $instcode): Int 
	{
		$sql = "SELECT SA_ID FROM octopus_pharmacy_stockadjustment WHERE SA_INSTCODE = '$instcode' AND SA_TYPE IN('8') and SA_STATUS = '1' AND SA_STATE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$transfercount  = $st->rowCount();
		return $transfercount;      
	}

	// 12 DEC 2023 JOSEPH ADORBOE
	public function editreturntosupplier($ekey,$supplier,$returnstockvalue,$description,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ?  , SA_ACTOR = ? , SA_ACTORCODE = ?,SA_BATCHNUMBER = ?,SA_BATCHCODE = ?,SA_DESCRIPTION = ?,
		SA_SUPPLIER = ?, SA_VALUE = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $batchnumber);
		$st->BindParam(5, $batchcode);
		$st->BindParam(6, $description);
		$st->BindParam(7, $supplier);
		$st->BindParam(8, $returnstockvalue);
		$st->BindParam(9, $ekey);
		$st->BindParam(10, $instcode);
		$exes = $st->Execute();
		if($exes){
			return '2';
		}else{
			return '0';
		}
	}
	// 11 DEC 2023 JOSEPH ADORBOE
	public function stockadjustmentsreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$batchcode,$batchnumber,$currentshift,$currentshiftcode,
	$expire,$type,$state,$supplier,$description,$value,$currentuser,$currentusercode,$instcode){
		$zero = '0.00';
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,
			SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE,SA_BATCHCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $zero);
		$st->BindParam(19, $zero);
		$st->BindParam(20, $state);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $zero);
		$st->BindParam(23, $zero);
		$st->BindParam(24, $description);
		$st->BindParam(25, $supplier);
		$st->BindParam(26, $value);
		$st->BindParam(27, $batchcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 9 DEC 2023 JOSEPH ADORBOE
	public function stockadjustmentstransfer($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$batchcode,$batchnumber,$currentshift,$currentshiftcode,
	$expire,$type,$state,$supplier,$description,$currentuser,$currentusercode,$instcode){
		$zero = '0.00';
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,
			SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE,SA_BATCHCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $zero);
		$st->BindParam(19, $zero);
		$st->BindParam(20, $state);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $zero);
		$st->BindParam(23, $zero);
		$st->BindParam(24, $description);
		$st->BindParam(25, $supplier);
		$st->BindParam(26, $zero);
		$st->BindParam(27, $batchcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 2 DEC 2023 JOSEPH ADORBOE
	public function stockadjustments($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,
	$newprice,$batchcode,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$state,$stockvalue,$supplier,$description,$currentuser,$currentusercode,$instcode){
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,
			SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE,SA_BATCHCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $newprice);
		$st->BindParam(20, $state);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $insuranceprice);
		$st->BindParam(23, $dollarprice);
		$st->BindParam(24, $description);
		$st->BindParam(25, $supplier);
		$st->BindParam(26, $stockvalue);
		$st->BindParam(27, $batchcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 5 DEC 2023 JOSEPH ADORBOE
	public function pricechangesstockadjustment($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$totalqty,$cashprice,$costprice,$insuranceprice,
	$dollarprice,$unit,$currentshift,$currentshiftcode,$type,$currentuser,$currentusercode,$instcode){
		$one =1;
		$zero = '0.00';
		$na = 'NA';
		$description ='Price change';
		$expire  = date('Y-m-d');
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY
			,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $totalqty);
		$st->BindParam(8, $totalqty);
		$st->BindParam(9, $totalqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $cashprice);
		$st->BindParam(20, $one);
		$st->BindParam(21, $one);
		$st->BindParam(22, $insuranceprice);
		$st->BindParam(23, $dollarprice);
		$st->BindParam(24, $description);
		$st->BindParam(25, $na);
		$st->BindParam(26, $zero);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 5 DEC 2023 JOSEPH ADORBOE
	public function returntosupplierstockadjustment($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$returnqty,$oldqty,$newqty,$unit,$costprice,
	$newprice,$batchnumber,$currentshift,$currentshiftcode,$expire,$type,$description,$supplier,$returnstockvalue,$currentuser,$currentusercode,$instcode){
		$one =1;
		$zero = '0.00';
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY
			,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $returnqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $oldqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $newprice);
		$st->BindParam(20, $one);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $zero);
		$st->BindParam(23, $zero);
		$st->BindParam(24, $description);
		$st->BindParam(25, $supplier);
		$st->BindParam(26, $returnstockvalue);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 2 DEC 2023 JOSEPH ADORBOE
	public function restockstockadjustment($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,
	$newprice,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$type,$description,$currentuser,$currentusercode,$instcode){
		$one =1;
		$na = 'NA';
		$zero = '0.00';
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,
			SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,
			SA_INSURANCEPRICE,SA_DOLLARPRICE,SA_DESCRIPTION,SA_SUPPLIER,SA_VALUE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $newprice);
		$st->BindParam(20, $one);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $insuranceprice);
		$st->BindParam(23, $dollarprice);
		$st->BindParam(24, $description);
		$st->BindParam(25, $na);
		$st->BindParam(26, $zero);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 20 NOV 2023 JOSEPH ADORBOE
	public function rejecttransfers($ekey,$days,$rejectreason,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$two = 2;
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?, SA_REASON = ?   WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $zero);
		$st->BindParam(5, $rejectreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $one);
		$exe = $st->Execute();

		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 20 NOV 2023 JOSEPH ADORBOE
	public function accepttransfers($ekey,$days,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$two = 2;
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $two);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 19 NOV 2023, JOSEPH ADORBOE
	public function returntosupplierbulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newitemqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){
		$one =1;
		$zero = '0';
		$type = 13;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE,SA_BATCHNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newstoreqty);
		$st->BindParam(9, $newitemqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $zero);
		$st->BindParam(19, $batchnumber);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 18 NOV 2023, JOSEPH ADORBOE
	public function returntostorebulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newitemqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){
		$one =1;
		$zero = '0';
		$type = 12;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE,SA_BATCHNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newstoreqty);
		$st->BindParam(9, $newitemqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $zero);
		$st->BindParam(19, $batchnumber);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 13 NOV 2023 JOSEPH ADORBOE
	public function edittransfer($ekey,$suppliedqty,$batchcode,$batchnumber,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ?  , SA_ACTOR = ? , SA_ACTORCODE = ?,SA_BATCHNUMBER = ?,SA_BATCHCODE = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $batchnumber);
		$st->BindParam(5, $batchcode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exes = $st->Execute();
		if($exes){
			return '2';
		}else{
			return '0';
		}

	}


	// 12 NOV 2023, JOSEPH ADORBOE
	public function transferbulkconsumable($type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$batchnumber,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){
		$one =1;
		$zero = '0';
		$type = 11;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE,SA_BATCHNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newtransferqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $zero);
		$st->BindParam(19, $batchnumber);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 12 NOV 2023
	public function approvebulkrestock($ajustcode,$instcode){
		$one = 1;
		$zero = '0';
		$days = date('Y-m-d H:i:s');
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATE = ? , SA_DATETIME = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? AND SA_STATE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $ajustcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $zero);
		$exes = $st->Execute();

		if($exes){
			return '2';
		}else{
			return '0';
		}
	}

	// 12 NOV 2023 JOSEPH ADORBOE
	public function deletependingstockajustment($ekey,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATUS = ? , SA_STATE = ? , SA_ACTOR = ? , SA_ACTORCODE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exes = $st->Execute();
		if($exes){
			return '2';
		}else{
			return '0';
		}

	}

	// 12 NOV 2023, JOSEPH ADORBOE
	public function editstockadjustmentpending($ekey,$suppliedqty,$costprice,$newprice,$insuranceprice,$dollarprice,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ?, SA_COSTPRICE =  ?, SA_NEWPRICE = ? , SA_INSURANCEPRICE = ?, SA_DOLLARPRICE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $costprice);
		$st->BindParam(3, $newprice);
		$st->BindParam(4, $insuranceprice);
		$st->BindParam(5, $dollarprice);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 9 NOV 2023 JOSEPH ADORBOE
	public function newstockadjustmenttosupplier($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtotalqty,$totalqty,$unit,$type,$batchnumber,$description,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode){
		$one =1;
		//	$type = 10;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_BATCHNUMBER,SA_DESCRIPTION,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newtotalqty);
		$st->BindParam(9, $totalqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $batchnumber);
		$st->BindParam(19, $description);
		$st->BindParam(20, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 9 NOV 2023 JOSEPH ADORBOE
	public function newstockadjustmentreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$type,$batchnumber,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode){
		$one =1;
		//	$type = 10;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_BATCHNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $batchnumber);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 9 NOV 2023 JOSEPH ADORBOE
	public function newstockadjustmenttransfer($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$newstoreqty,$unit,$type
	,$batchnumber,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode){
		$one =1;
	//	$type = 10;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE,SA_BATCHNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newtransferqty);
		$st->BindParam(9, $newstoreqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $one);
		$st->BindParam(19, $batchnumber);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 9 NOV 2023 JOSEPH ADORBOE
	public function newstockadjustmentpending($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,
	$newprice,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode){
		$one =1;
		$type = 10;
		$zero = '0';
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,SA_INSURANCEPRICE,SA_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $newprice);
		$st->BindParam(20, $zero);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $insuranceprice);
		$st->BindParam(23, $dollarprice);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 9 NOV 2023 JOSEPH ADORBOE
	public function newstockadjustment($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode){
		$one =1;
		$type = 10;
		$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE,SA_BATCHNUMBER,SA_INSURANCEPRICE,SA_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ajustcode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $storeqty);
		$st->BindParam(10, $type);
		$st->BindParam(11, $currentshift);
		$st->BindParam(12, $currentshiftcode);
		$st->BindParam(13, $expire);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $unit);
		$st->BindParam(18, $costprice);
		$st->BindParam(19, $newprice);
		$st->BindParam(20, $one);
		$st->BindParam(21, $batchnumber);
		$st->BindParam(22, $insuranceprice);
		$st->BindParam(23, $dollarprice);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

}

$stockadjustmenttable = new OctopusStockadjustmentSql;
?>
