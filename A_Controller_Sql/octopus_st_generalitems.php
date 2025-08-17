<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 17 FEB 2024
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_st_generalitems
	$generalitemstable->returntostoresgeneralitems($itemqty,$itemcode,$instcode);
*/

class OctopusGeneralItemsSql Extends Engine{
	// // 29 Sept 2023, 24 SEPT 2023 JOSEPH ADORBOE
	// public function getqueryactivemedicationlist($instcode){
	// 	$list = ("SELECT * from octopus_st_medications WHERE MED_INSTCODE = '$instcode' AND MED_STATUS = '1' order by MED_MEDICATION limit 150 ");
	// 	return $list;
	// }

	// 22 MAR 2024,   JOSEPH ADORBOE 
	public function getgeneralitemslov($instcode)
	{
		$mnm = 1;
		$sql = " SELECT * FROM octopus_st_generalitems WHERE GEN_STATUS = '1' AND GEN_INSTCODE = '$instcode' ORDER BY GEN_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= 0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['GEN_CODE'].'@@@'.$obj['GEN_NAME'].'@@@'.$obj['GEN_SHELFQTY'].'">'.$obj['GEN_NAME'].' </option>';
		}
	}

	// 31 JAN 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function aftersale($productcode,$saleqty,$instcode){	
		$one = 1;	
		$sql = "UPDATE octopus_st_generalitems SET GEN_SHELFQTY = GEN_SHELFQTY - ?  WHERE GEN_CODE = ? AND GEN_INSTCODE = ?  AND GEN_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $saleqty);
		$st->BindParam(2, $productcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}

	// 26 MAR 2023  JOSEPH ADORBOE 
	public function removesaleproducts($productcode,$productqty,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_st_generalitems SET GEN_SHELFQTY = GEN_SHELFQTY + ?  WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $productqty);
		$st->BindParam(2, $productcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}

	// 17 FEB 2024, JOSEPH ADORBOE 
	public function getstockvalue(String $instcode): Int 
		{
		$one = 1;
		$sql = " SELECT SUM(GEN_STOCKVALUE) AS STOCKVALUE FROM octopus_st_generalitems WHERE GEN_INSTCODE = ? AND GEN_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['STOCKVALUE'];				
				return intval($value);
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}
	// 17 FEB 2024, JOSEPH ADORBOE
	public function getquerygenralitemslistdisabled($instcode){
		$zero  = '0';
		$list = ("SELECT * from octopus_st_generalitems WHERE GEN_INSTCODE = '$instcode' AND GEN_STATUS = '$zero' order by GEN_NAME ");
		return $list;
	}

	// 17 FEB 2024, JOSEPH ADORBOE
	public function getquerygenralitemslist($instcode){
		$one = '1';
		$list = ("SELECT * from octopus_st_generalitems WHERE GEN_INSTCODE = '$instcode' AND GEN_STATUS = '$one' order by GEN_NAME ");
		return $list;
	}

	// 17 FEB 2024, JOSEPH ADORBOE
	public function getquerygenralitemssearchlist($searchitem,$instcode){
		if(empty($searchitem)){
			$list = ("SELECT * FROM octopus_st_generalitems WHERE GEN_STATUS = '1' AND GEN_INSTCODE = '$instcode' AND GEN_STATUS = '1' order by GEN_ID desc limit 10");                                                                            
		} else{
			$list = ("SELECT * FROM octopus_st_generalitems WHERE GEN_STATUS = '1' AND GEN_INSTCODE = '$instcode' AND GEN_STATUS = '1' and GEN_NAME LIKE '%$searchitem%'  order by GEN_ID desc limit 50");                                                                            
		}  
		return $list;   		
	}

	// 20 FEB 2024, JOSEPH ADORBOE
	public function calculategeneralitemstockvalue($itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOCKVALUE = GEN_TOTALQTY*GEN_CASHPRICE WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 20 FEB 2024, JOSEPH ADORBOE
	public function updatemedicationapprove($itemcode,$addqty,$costprice,$cashprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY =GEN_STOREQTY  + ?,  GEN_TOTALQTY = GEN_TOTALQTY  + ?, GEN_CASHPRICE =? , GEN_COSTPRICE =?, GEN_INSURANCEPRICE =?,  GEN_PARTNERPRICE =?, GEN_DOLLARPRICE = ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ?";
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
		$st->BindParam(10, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 19 FEB 2024  JOSEPH ADORBOE
	public function returntosuppliergeneralitemsbulk($returnqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY = GEN_STOREQTY - ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $returnqty);
		$st->BindParam(2, $itemcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 19 FEB 2024  JOSEPH ADORBOE
	public function returntosuppliergeneralitems($returnqty,$newtotalqty,$itemcode,$stockvalue,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY = GEN_STOREQTY - ? , GEN_TOTALQTY =  ?,  GEN_STOCKVALUE = ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $returnqty);
		$st->BindParam(2, $newtotalqty);
		$st->BindParam(3, $stockvalue);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 19 FEB 2024, JOSEPH ADORBOE
	public function updategeneralitemprices($itemcode,$costprice,$cashprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,$insuranceprice,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_COSTPRICE = ?  , GEN_CASHPRICE = ?  , GEN_STOCKVALUE = ?, GEN_PARTNERPRICE = ?, GEN_ALTERPRICE = ?, GEN_DOLLARPRICE = ?, GEN_INSURANCEPRICE = ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ?  AND GEN_STATUS = ?";
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
		$st->BindParam(10, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 18 feb 2024, JOSEPH ADORBOE
	public function modifymedicationqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue,$currentuser, $currentusercode, $instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_SHELFQTY = ?, GEN_STOREQTY =?, GEN_TRANSFER = ?, GEN_TOTALQTY = ?, GEN_STOCKVALUE = ? , GEN_ACTOR = ?, GEN_ACTORCODE = ? WHERE GEN_CODE = ? AND GEN_STATUS = ? AND GEN_INSTCODE = ?  ";
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
	//	$st->BindParam(11, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 18 FEB 2024, JOSEPH ADORBOE
	public function restockgeneralitems($itemcode,$suppliedqty,$totalqty,$costprice,$newprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,
	$insuranceprice,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY =GEN_STOREQTY + ? ,GEN_TOTALQTY = ? ,GEN_COSTPRICE = ?  ,GEN_CASHPRICE = ?  ,GEN_STOCKVALUE = ?,GEN_PARTNERPRICE = ?,GEN_ALTERPRICE = ?,GEN_DOLLARPRICE = ?,GEN_INSURANCEPRICE = ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ?";
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
		$st->BindParam(12, $one);
		$exe = $st->Execute();
			if($exe){
				return '2';
			}else{
				return '0';
			}
	}

	

	// // 2 DEC 2023, 13 MAY 2023 JOSEPH ADORBOE
	// public function editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$medicationbrand,$medicationdose,$currentuser,$currentusercode,$instcode){

	// 	$sql = "UPDATE octopus_st_medications SET MED_CODENUM = ?, MED_MEDICATION = ?,  MED_DOSAGECODE = ?, MED_DOSAGE =? , MED_RESTOCK =?, MED_UNITCODE =?, MED_UNIT =?, MED_QTY =?, MED_ACTOR =?, MED_ACTORCODE = ? , MED_BRANDNAME = ? , MED_DOSE = ? WHERE MED_CODE = ?  ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $medicationnumber);
	// 	$st->BindParam(2, $medication);
	// 	$st->BindParam(3, $dosageformcode);
	// 	$st->BindParam(4, $dosageformname);
	// 	$st->BindParam(5, $restock);
	// 	$st->BindParam(6, $untcode);
	// 	$st->BindParam(7, $untname);
	// 	$st->BindParam(8, $qty);
	// 	$st->BindParam(9, $currentuser);
	// 	$st->BindParam(10, $currentusercode);
	// 	$st->BindParam(11, $medicationbrand);
	// 	$st->BindParam(12, $medicationdose);
	// 	$st->BindParam(13, $ekey);
	// 	$exe = $st->execute();
	// 	if($exe){


	// 		return '2';
	// 	}else{
	// 		return '0';
	// 	}
	// }

	// // 2 DEC 2023,  JOSEPH ADORBOE
    // public function addmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){
	// 	$mt = 1;
	// 	$days = date('Y-m-d H:i:s');
	// 	$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications where MED_MEDICATION = ? and  MED_INSTCODE = ?  and MED_STATUS = ? ");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $medication);
	// 	$st->BindParam(2, $instcode);
	// 	$st->BindParam(3, $mt);
	// 	$check = $st->execute();
	// 	if($check){
	// 		if($st->rowcount() > 0){
	// 			return '1';
	// 		}else{
	// 			$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_CODENUM,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_RESTOCK,MED_UNITCODE,MED_UNIT,MED_QTY,MED_ACTOR,MED_ACTORCODE,MED_INSTCODE,MED_BRANDNAME,MED_DOSE,MED_LASTDATE,MED_CASHPRICE,MED_PARTNERPRICE,MED_INSURANCEPRICE,MED_ALTERPRICE,MED_DOLLARPRICE,MED_TOTALQTY,MED_COSTPRICE,MED_STOCKVALUE,MED_STOREQTY)
	// 			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);
	// 			$st->BindParam(1, $form_key);
	// 			$st->BindParam(2, $medicationnumber);
	// 			$st->BindParam(3, $medication);
	// 			$st->BindParam(4, $dosageformcode);
	// 			$st->BindParam(5, $dosageformname);
	// 			$st->BindParam(6, $restock);
	// 			$st->BindParam(7, $untcode);
	// 			$st->BindParam(8, $untname);
	// 			$st->BindParam(9, $qty);
	// 			$st->BindParam(10, $currentuser);
	// 			$st->BindParam(11, $currentusercode);
	// 			$st->BindParam(12, $instcode);
	// 			$st->BindParam(13, $brandname);
	// 			$st->BindParam(14, $medicationdose);
	// 			$st->BindParam(15, $days);
	// 			$st->BindParam(16, $cashprice);
	// 			$st->BindParam(17, $partnerprice);
	// 			$st->BindParam(18, $insuranceprice);
	// 			$st->BindParam(19, $alternateprice);
	// 			$st->BindParam(20, $dollarprice);
	// 			$st->BindParam(21, $totalqty);
	// 			$st->BindParam(22, $costprice);
	// 			$st->BindParam(23, $stockvalue);
	// 			$st->BindParam(24, $storeqty);
	// 			$exe = $st->execute();
	// 			if($exe){
	// 				return '2';
	// 			}else{
	// 				return '0';
	// 			}
	// 		}
	// 	}else{
	// 		return '1';
	// 	}
	// }
	// 19 FEB 2024, JOSEPH ADORBOE
	public function returntostoresgeneralitems($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY = GEN_STOREQTY + ? , GEN_SHELFQTY = GEN_SHELFQTY - ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemqty);
		$st->BindParam(2, $itemqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 18 FEB 2024,  JOSEPH ADORBOE
	public function transfergeneralitems($transferqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY = GEN_STOREQTY - ? , GEN_TRANSFER = GEN_TRANSFER + ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $transferqty);
		$st->BindParam(2, $transferqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	

	// 21 FEB 2024, JOSEPH ADORBOE
	public function rejecttransfergeneralitems($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STOREQTY = GEN_STOREQTY + ? , GEN_TRANSFER = GEN_TRANSFER - ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemqty);
		$st->BindParam(2, $itemqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 21 FEB 2024, JOSEPH ADORBOE
	public function accepttransfergeneralitems($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_SHELFQTY = GEN_SHELFQTY + ? , GEN_TRANSFER = GEN_TRANSFER - ? WHERE GEN_CODE = ? AND GEN_INSTCODE = ? AND GEN_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemqty);
		$st->BindParam(2, $itemqty);
		$st->BindParam(3, $itemcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// // 8 oct  2023,  25 DEC 2022  JOSEPH ADORBOE
	// public function updatemedicationlastsold($medcode,$days,$instcode){
	// 	$one = 1;
	// 	$sql = "UPDATE octopus_st_medications SET MED_LASTDATE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? AND  MED_STATUS = ? ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $days);
	// 	$st->BindParam(2, $medcode);
	// 	$st->BindParam(3, $instcode);
	// 	$st->BindParam(4, $one);
	// 	$exe = $st->execute();
	// 	if($exe){
	// 		return '2';
	// 	}else{
	// 		return '0';
	// 	}
	// }

	// 18 FEB 2024, JOSEPH ADORBOE 
	public function gettotalgeneralitemqty(String $medcode): Int 
		{
		$one = 1;
		$sql = " SELECT GEN_TOTALQTY AS TOTALQTY FROM octopus_st_generalitems WHERE GEN_CODE = ? AND GEN_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $medcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['TOTALQTY'];				
				return $value;
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}
	// 18 FEB 2024 , JOSEPH ADORBOE
	public function generalitemdetails($idvalue,$instcode){
		$one = 1;
		$sql = "SELECT * FROM octopus_st_generalitems WHERE GEN_CODE = ? AND GEN_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['GEN_NAME'].'@@'.$obj['GEN_RESTOCK'].'@@'.$obj['GEN_CATEGORY'].'@@'.$obj['GEN_UNIT'].'@@'.$obj['GEN_SHELFQTY'].'@@'.$obj['GEN_STOREQTY'].'@@'.$obj['GEN_TRANSFER'].'@@'.$obj['GEN_LASTDATE'].'@@'.$obj['GEN_INSURANCEPRICE'].'@@'.$obj['GEN_ALTERPRICE'].'@@'.$obj['GEN_CASHPRICE'].'@@'.$obj['GEN_STOCKVALUE'].'@@'.$obj['GEN_TOTALQTY'].'@@'.$obj['GEN_COSTPRICE'].'@@'.$obj['GEN_PARTNERPRICE'].'@@'.$obj['GEN_DOLLARPRICE'].'@@'.$obj['GEN_STATUS'];
		}else{
			$ordernum = '0';
		}
		return 	$ordernum;
	}
	// 18 FEB 2024,  JOSEPH ADORBOE
	public function enablegeneralitem($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;
		$reason = 'Enable';
		$sql = "UPDATE octopus_st_generalitems SET GEN_STATUS = ?, GEN_RESONACTOR =?, GEN_REASONACTORCODE = ?, GEN_REASON =?, GEN_REASONDATE = ? WHERE GEN_CODE = ? AND GEN_STATUS = ? AND GEN_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $reason);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 18 FEB 2024,  JOSEPH ADORBOE
	public function disablegeneralitem($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;
		$sql = "UPDATE octopus_st_generalitems SET GEN_STATUS = ?, GEN_RESONACTOR =?, GEN_REASONACTORCODE = ?, GEN_REASON =?, GEN_REASONDATE = ? WHERE GEN_CODE = ? AND GEN_STATUS = ? AND GEN_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $disablereason);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 17 FEB 2024 , JOSEPH ADORBOE
	public function editgeneralitem($ekey,$generalitems,$itemcategory,$unit,$restock,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;

		$sql = "UPDATE octopus_st_generalitems SET GEN_NAME = ?, GEN_RESTOCK =?, GEN_UNIT = ?, GEN_CATEGORY = ?, GEN_ACTOR =?, GEN_ACTORCODE =? WHERE GEN_CODE = ?  AND GEN_INSTCODE = ? AND GEN_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $generalitems);
		$st->BindParam(2, $restock);
		$st->BindParam(3, $unit);
		$st->BindParam(4, $itemcategory);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 17 FEB 2024, JOSEPH ADORBOE
    public function addnewitems($form_key,$generalitems,$itemcategory,$unit,$restock,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){
		$mt = 1;
		$zero = '0';
		$days = date('Y-m-d H:i:s');
		$sqlstmt = ("SELECT GEN_ID FROM octopus_st_generalitems where GEN_NAME = ? and  GEN_INSTCODE = ?  and GEN_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $generalitems);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){
				return '1';
			}else{
				$sqlstmt = "INSERT INTO octopus_st_generalitems(GEN_CODE,GEN_NAME,GEN_RESTOCK,GEN_UNIT,GEN_CATEGORY,GEN_SHELFQTY,GEN_STOREQTY,GEN_TRANSFER,GEN_CASHPRICE,GEN_PARTNERPRICE,GEN_INSURANCEPRICE,GEN_ALTERPRICE,GEN_DOLLARPRICE,GEN_TOTALQTY,GEN_COSTPRICE,GEN_STOCKVALUE,GEN_ACTOR,GEN_ACTORCODE,GEN_INSTCODE,GEN_LASTDATE)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $generalitems);
				$st->BindParam(3, $restock);
				$st->BindParam(4, $unit);
				$st->BindParam(5, $itemcategory);
				$st->BindParam(6, $zero);
				$st->BindParam(7, $storeqty);
				$st->BindParam(8, $zero);
				$st->BindParam(9, $cashprice);
				$st->BindParam(10, $partnerprice);
				$st->BindParam(11, $insuranceprice);
				$st->BindParam(12, $alternateprice);
				$st->BindParam(13, $dollarprice);
				$st->BindParam(14, $totalqty);
				$st->BindParam(15, $costprice);
				$st->BindParam(16, $stockvalue);
				$st->BindParam(17, $currentuser);
				$st->BindParam(18, $currentusercode);
				$st->BindParam(19, $instcode);
				$st->BindParam(20, $days);
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

$generalitemstable =  new OctopusGeneralItemsSql;
?>
