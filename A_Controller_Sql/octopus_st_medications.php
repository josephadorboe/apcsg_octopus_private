<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 28 SEPT 2023
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_st_medications
	$medicationtable->reverse_returntostoresmedications($itemqty,$itemcode,$instcode);
*/

class OctopusMedicationSql Extends Engine{

	// 26 NOV 2024, JOSEPH ADORBOE
	public function reverse_returntosuppliermedications($returnqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = MED_TOTALQTY + ?,  MED_STOCKVALUE = MED_STOCKVALUE - (MED_CASHPRICE * ? )  WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $returnqty);
		$st->BindParam(2, $returnqty);
		$st->BindParam(3, $returnqty);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	// 26 NOV 2024, JOSEPH ADORBOE
	public function reverse_returntostoresmedications($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? , MED_QTY = MED_QTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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

	// 26 NOV 2024, JOSEPH ADORBOE
	public function reverse_restockmedication($itemcode,$suppliedqty,$newprice,$instcode){
			$diff = $suppliedqty*$newprice;
			$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? , MED_TOTALQTY = MED_TOTALQTY - ?  , MED_STOCKVALUE = MED_STOCKVALUE - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $suppliedqty);
			$st->BindParam(2, $suppliedqty);
			$st->BindParam(3, $diff);
			$st->BindParam(4, $itemcode);
			$st->BindParam(5, $instcode);
			$exe = $st->Execute();
			if($exe){
				return '2';
			}else{
				return '0';
			}
	}

	// 26 NOV 2024,   JOSEPH ADORBOE
    public function reverse_addmedication($form_key,$instcode){
		$mt = '0';
		$sqlstmt = ("DELETE * FROM octopus_st_medications where MED_CODE = ? and  MED_INSTCODE = ?  and MED_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
			
	}

	// 29 Sept 2023, 24 SEPT 2023 JOSEPH ADORBOE
	public function getqueryactivemedicationlist($instcode){
		$list = ("SELECT * from octopus_st_medications WHERE MED_INSTCODE = '$instcode' AND MED_STATUS = '1' order by MED_MEDICATION limit 150 ");
		return $list;
	}
	// 28 Sept 2023, 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerymedicationlist($instcode){
		$one = '1';
		$list = ("SELECT * from octopus_st_medications WHERE MED_INSTCODE = '$instcode' AND MED_STATUS = '$one' order by MED_MEDICATION ");
		return $list;
	}

	// 15 OCT 2024,  JOSEPH ADORBOE
	public function getquerymedicationdisabledlist($instcode){
		$zero = '0';
		$list = ("SELECT * from octopus_st_medications WHERE MED_INSTCODE = '$instcode' AND MED_STATUS = '$zero' order by MED_MEDICATION ");
		return $list;
	}

	// 9 DEC 2023, JOSEPH ADORBOE
	public function calculatemedicationstockvalue($itemcode,$instcode){
		$sql = "UPDATE octopus_st_medications SET MED_STOCKVALUE = MED_TOTALQTY*MED_CASHPRICE WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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

	//9 DEC 2023, JOSEPH ADORBOE
	public function updatemedicationapprove($itemcode,$addqty,$costprice,$cashprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY =MED_STOREQTY  + ?,  MED_TOTALQTY = MED_TOTALQTY  + ?, MED_CASHPRICE =? , MED_COSTPRICE =?, MED_INSURANCEPRICE =?,  MED_PARTNERPRICE =?, MED_DOLLARPRICE = ?
		WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	// 12 DEC 2023, ,  25 DEC 2022  JOSEPH ADORBOE
	public function returntosuppliermedicationsbulk($returnqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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

	// 5 DEC 2023, ,  25 DEC 2022  JOSEPH ADORBOE
	public function returntosuppliermedications($returnqty,$newtotalqty,$itemcode,$stockvalue,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? , MED_TOTALQTY =  ?,  MED_STOCKVALUE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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

	// 2 DEC 2023, 13 MAY 2023 JOSEPH ADORBOE
	public function updatemedicationprices($itemcode,$costprice,$cashprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,$insuranceprice,$instcode){
		$sql = "UPDATE octopus_st_medications SET MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	// 2 DEC 2023  JOSEPH ADORBOE
	public function modifymedicationqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue,$currentuser, $currentusercode, $instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_QTY = ?, MED_STOREQTY =?, MED_TRANSFER = ?, MED_TOTALQTY = ?, MED_STOCKVALUE = ? , MED_ACTOR = ?, MED_ACTORCODE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
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


	// 2 DEC 2023, 13 MAY 2023 JOSEPH ADORBOE
	public function restockmedication($itemcode,$suppliedqty,$totalqty,$costprice,$newprice,$stockvalue,$partnerprice,$alternateprice,$dollarprice,
	$insuranceprice,$instcode){
			$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = ? , MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	// 2 DEC 2023 , JOSEPH ADORBOE
	public function medicationdetails($idvalue,$instcode){
		$one = 1;
		$sql = "SELECT * FROM octopus_st_medications WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['MED_MEDICATION'].'@@'.$obj['MED_DOSAGE'].'@@'.$obj['MED_RESTOCK'].'@@'.$obj['MED_UNIT'].'@@'.$obj['MED_QTY'].'@@'.$obj['MED_STOREQTY'].'@@'.$obj['MED_TRANSFER'].'@@'.$obj['MED_LASTDATE'].'@@'.$obj['MED_INSURANCEPRICE'].'@@'.$obj['MED_ALTERPRICE'].'@@'.$obj['MED_CASHPRICE'].'@@'.$obj['MED_STOCKVALUE'].'@@'.$obj['MED_TOTALQTY'].'@@'.$obj['MED_CODENUM'].'@@'.$obj['MED_COSTPRICE'].'@@'.$obj['MED_PARTNERPRICE'].'@@'.$obj['MED_DOLLARPRICE'].'@@'.$obj['MED_STATUS'];
		}else{
			$ordernum = '0';
		}
		return 	$ordernum;

	}
	// 2 DEC 2023, 13 MAY 2023 JOSEPH ADORBOE
	public function editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$medicationbrand,$medicationdose,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_medications SET MED_CODENUM = ?, MED_MEDICATION = ?,  MED_DOSAGECODE = ?, MED_DOSAGE =? , MED_RESTOCK =?, MED_UNITCODE =?, MED_UNIT =?, MED_QTY =?, MED_ACTOR =?, MED_ACTORCODE = ? , MED_BRANDNAME = ? , MED_DOSE = ? WHERE MED_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medicationnumber);
		$st->BindParam(2, $medication);
		$st->BindParam(3, $dosageformcode);
		$st->BindParam(4, $dosageformname);
		$st->BindParam(5, $restock);
		$st->BindParam(6, $untcode);
		$st->BindParam(7, $untname);
		$st->BindParam(8, $qty);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $medicationbrand);
		$st->BindParam(12, $medicationdose);
		$st->BindParam(13, $ekey);
		$exe = $st->execute();
		if($exe){


			return '2';
		}else{
			return '0';
		}
	}

	// 2 DEC 2023,  JOSEPH ADORBOE
    public function addmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$cashprice,$costprice,$partnerprice,$insuranceprice,$alternateprice,$dollarprice,$storeqty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){
		$mt = 1;
		$days = date('Y-m-d H:i:s');
		$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications where MED_MEDICATION = ? and  MED_INSTCODE = ?  and MED_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $medication);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){
				return '1';
			}else{
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_CODENUM,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_RESTOCK,MED_UNITCODE,MED_UNIT,MED_QTY,MED_ACTOR,MED_ACTORCODE,MED_INSTCODE,MED_BRANDNAME,MED_DOSE,MED_LASTDATE,MED_CASHPRICE,MED_PARTNERPRICE,MED_INSURANCEPRICE,MED_ALTERPRICE,MED_DOLLARPRICE,MED_TOTALQTY,MED_COSTPRICE,MED_STOCKVALUE,MED_STOREQTY)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $medicationnumber);
				$st->BindParam(3, $medication);
				$st->BindParam(4, $dosageformcode);
				$st->BindParam(5, $dosageformname);
				$st->BindParam(6, $restock);
				$st->BindParam(7, $untcode);
				$st->BindParam(8, $untname);
				$st->BindParam(9, $qty);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $brandname);
				$st->BindParam(14, $medicationdose);
				$st->BindParam(15, $days);
				$st->BindParam(16, $cashprice);
				$st->BindParam(17, $partnerprice);
				$st->BindParam(18, $insuranceprice);
				$st->BindParam(19, $alternateprice);
				$st->BindParam(20, $dollarprice);
				$st->BindParam(21, $totalqty);
				$st->BindParam(22, $costprice);
				$st->BindParam(23, $stockvalue);
				$st->BindParam(24, $storeqty);
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
	// 3 DEC 2023, ,  25 DEC 2022  JOSEPH ADORBOE
	public function returntostoresmedications($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_QTY = MED_QTY - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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

	// 2 DEC  2023,  25 DEC 2022  JOSEPH ADORBOE
	public function transfermedications($transferqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? , MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	// 21 NOV 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function rejecttransfermedications($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TRANSFER = MED_TRANSFER - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	public function accepttransfermedications($itemqty,$itemcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY + ? , MED_TRANSFER = MED_TRANSFER - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
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
	// 8 oct  2023,  25 DEC 2022  JOSEPH ADORBOE
	public function updatemedicationlastsold($medcode,$days,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_LASTDATE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? AND  MED_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $medcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 28 Sept 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function enablemedication($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;
		$reason = 'Enable';
		$sql = "UPDATE octopus_st_medications SET MED_STATUS = ?, MED_RESONACTOR =?, MED_REASONACTORCODE = ?, MED_REASON =?, MED_REASONDATE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
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
	// 28 Sept 2023,  25 DEC 2022  JOSEPH ADORBOE
	public function disablemedication($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;
		$sql = "UPDATE octopus_st_medications SET MED_STATUS = ?, MED_RESONACTOR =?, MED_REASONACTORCODE = ?, MED_REASON =?, MED_REASONDATE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
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

	// 12 JAN 2023  JOSEPH ADORBOE
	public function editmedications($ekey,$medication,$dosageformcode,$dosageformname,$untcode,$untname,$brandname,$medicationdose,$restock,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;

		$sql = "UPDATE octopus_st_medications SET MED_MEDICATION = ?, MED_DOSAGECODE =?, MED_DOSAGE = ?, MED_RESTOCK = ?, MED_UNITCODE = ? , MED_UNIT = ?, MED_DOSE = ? , MED_BRANDNAME =?, MED_ACTOR =?, MED_ACTORCODE =? WHERE MED_CODE = ?  AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medication);
		$st->BindParam(2, $dosageformcode);
		$st->BindParam(3, $dosageformname);
		$st->BindParam(4, $restock);
		$st->BindParam(5, $untcode);
		$st->BindParam(6, $untname);
		$st->BindParam(7, $medicationdose);
		$st->BindParam(8, $brandname);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $ekey);
		$st->BindParam(12, $instcode);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}

	}

	// 28 Sept 2023, 13 MAY 2021,  JOSEPH ADORBOE
    public function addnewmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$currentuser,$currentusercode,$instcode){
		$mt = 1;
		$days = date('Y-m-d H:i:s');
		$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications where MED_MEDICATION = ? and  MED_INSTCODE = ?  and MED_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $medication);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){
				return '1';
			}else{
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_CODENUM,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_RESTOCK,MED_UNITCODE,MED_UNIT,MED_QTY,MED_ACTOR,MED_ACTORCODE,MED_INSTCODE,MED_BRANDNAME,MED_DOSE,MED_LASTDATE)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $medicationnumber);
				$st->BindParam(3, $medication);
				$st->BindParam(4, $dosageformcode);
				$st->BindParam(5, $dosageformname);
				$st->BindParam(6, $restock);
				$st->BindParam(7, $untcode);
				$st->BindParam(8, $untname);
				$st->BindParam(9, $qty);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $brandname);
				$st->BindParam(14, $medicationdose);
				$st->BindParam(15, $days);
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

$medicationtable = new OctopusMedicationSql();
?>
