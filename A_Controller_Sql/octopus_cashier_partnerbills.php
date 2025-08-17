<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 11 SEPT 2023  
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_cashier_partnerbills
	$partnerbilltable->querypartnerbilllist($instcode)
	$partnerbilltable = new OctopusCashierPartnerbillsSql();

	
*/

class OctopusCashierPartnerbillsSql Extends Engine{
	// 11 SEPT 2023 JOSEPH ADORBOE
	public function querypartnerbilllist($instcode){		
		$list = ("SELECT PC_CODE,PC_DATE,PC_COMPANY,PC_BATCHNUMBER,PC_AMOUNT,PC_NUMBEROFLABS,PC_BATCHNUMBER FROM octopus_cashier_partnerbills WHERE PC_INSTCODE = '$instcode' ORDER BY PC_ID DESC ");		
		return $list;
	}

	// 5 JAN 2023, 06 MAR 2022 JOSEPH ADORBOE
	public function getpartneratientlabstotal($instcode){
		$one = 1;
		$sql = ("SELECT SUM(PC_AMOUNT) FROM octopus_cashier_partnerbills WHERE PC_INSTCODE = ? AND PC_STATUS = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $one);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(PC_AMOUNT)'];
				return intval($results);
			}else{
				return '0';
			}
		}else{
			return '0';
		}
		
	}
	// 06 MAR 2022 JOSEPH ADORBOE
	public function updatepartnerpayments($ekey,$amountrequested,$receiptnum,$desc,$days,$currentusercode,$currentuser,$instcode){
		$two = 2 ;
		$one = 1 ;
		$sql = "UPDATE octopus_cashier_partnerbills SET PC_PROCESSRECEIPT = ?, PC_PROCESSDESC = ?, PC_PROCESSAMOUNT = ?,  PC_PROCESSACTOR = ? , PC_PROCESSACTORCODE = ? , PC_PROCESSTIME = ? , PC_STATUS = ? WHERE PC_CODE = ? and PC_INSTCODE = ? AND PC_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $receiptnum);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $amountrequested);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $days);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $one);
		$exe = $st->execute();		
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}
		
	// 06 MAR 2022  JOSEPH ADORBOE
	public function getpartnerreceiptnum($receiptnum,$instcode){
		$sql = ("SELECT PC_ID FROM octopus_cashier_partnerbills where PC_PROCESSRECEIPT = ? and PC_INSTCODE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $$receiptnum);
		$st->BindParam(2, $instcode);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				return '1';
			}else{
				return '2';
			}
		}else{
			return '0';
		}
		
	}
	
} 
$partnerbilltable = new OctopusCashierPartnerbillsSql();
?>