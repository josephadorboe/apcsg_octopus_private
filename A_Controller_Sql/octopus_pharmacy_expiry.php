<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023,
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_pharmacy_expiry
	$expirytable->reverse_newexpiry($expirycode,$instcode);
*/

class OctopusPharmacyExpirySql Extends Engine{

	// 26 NOV 2024 , JOSEPH ADORBOE 
	public function reverse_newexpiry($expirycode,$instcode){
		$one = '1';
		$sqlstmt = ("DELETE * FROM octopus_pharmacy_expiry WHERE EXP_CODE = ? AND  EXP_INSTCODE = ?  AND EXP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $expirycode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// // 9 NOV 2023, JOSEPH ADORBOE
	// public function getquerylabplan($instcode){
	// 	$list = ("SELECT * FROM octopus_pharmacy_expiry WHERE LP_INSTCODE = '$instcode' and LP_STATUS = '1' AND LP_CATEGORY = 'LABS'  order by LP_NAME DESC ");
	// 	return $list;
	// }

	

	// 14 NOV 2024, JOSEPH ADORBOE
	public function editexpiry($batchcode,$qty,$expire,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_QTY = ? , EXP_EXPIRYDATE = ? , EXP_ACTOR = ? , EXP_ACTORCODE = ? WHERE EXP_BATCHCODE = ? AND EXP_INSTCODE = ? AND EXP_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $expire);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $batchcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 9 DEC 2023, JOSEPH ADORBOE
	public function disableexpiry($batchcode,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ? WHERE EXP_BATCHCODE = ? AND EXP_INSTCODE = ? AND EXP_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 9 NOV 2023 JOSEPH ADORBOE
	public function newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$batchcode,$batchnumber,$currentuser,$currentusercode,$instcode){
		$one =1;
		$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE,EXP_BATCHNUMBER,EXP_BATCHCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $expirycode);
		$st->BindParam(2, $adjustmentnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemnumber);
		$st->BindParam(6, $item);
		$st->BindParam(7, $suppliedqty);
		$st->BindParam(8, $currentuser);
		$st->BindParam(9, $currentusercode);
		$st->BindParam(10, $instcode);
		$st->BindParam(11, $expire);
		$st->BindParam(12, $batchnumber);
		$st->BindParam(13, $batchcode);
		$exep = $st->execute();
		if($exep){
			return '2';
		}else{
			return '0';
		}
	}
}

$expirytable =  new OctopusPharmacyExpirySql();	
?>
