<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_cashier_summary	
	$cashiersummarytable = new OctopusCashierSummarySql();
*/

class OctopusCashierSummarySql Extends Engine{
	// 16 SEPT 2023 
	public function selectinsertupdatecashiersummarytypes($form_key,$day,$currentshift,$currentshiftcode,$type,$currentusercode,$currentuser,$instcode,$amountdeducted){
		$one = 1;
		$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? AND CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtsum);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $type);
		$cs = $st->execute();
		if ($st->rowcount() >'0') {
			$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_TYPE = ? ";
			$st = $this->db->prepare($sqlstmtst);
			$st->BindParam(1, $amountdeducted);
			$st->BindParam(2, $currentshiftcode);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $one);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $type);
			$dt = $st->execute();
			if ($dt) {
				return '2';
			} else {
				return '0';
			}
		} else {
			$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $day);
			$st->BindParam(3, $currentshift);
			$st->BindParam(4, $currentshiftcode);
			$st->BindParam(5, $amountdeducted);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $currentusercode);
			$st->BindParam(8, $instcode);
			$st->BindParam(9, $type);
			$opensummary = $st->execute();
			if ($opensummary) {
				return '2';
			} else {
				return '0';
			}
		}
	}
	

	// 16 SEPT 2023, 08 SEPT 2022  JOSEPH ADORBOE
	public function deductfromsummary($currentshiftcode,$amount,$type,$instcode)
	{
		$one = 1;
		$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL - ? where CS_SHIFTCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtst);
		$st->BindParam(1, $amount);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $type);
		$ext = $st->execute();
		if($ext){
			return '2';
		}else{
			return '0';
		}                 
    }
	// 12 SEPT 2023, 15 JUNE 2022 JOSEPH ADORBOE 
	public function summaryoperations($day, $currentshift,$currentusercode,$amountpaid,$type,$currentuser,$currentshiftcode,$instcode){	
		$three = 3;
		$one = 1;
		$form_key = md5(microtime());
		$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? and CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtsum);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $type);
		$cs = $st->execute();
		if ($st->rowcount() >'0') {
			$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? and CS_TYPE = ?";
			$st = $this->db->prepare($sqlstmtst);
			$st->BindParam(1, $amountpaid);
			$st->BindParam(2, $currentshiftcode);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $one);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $type);
			$dt = $st->execute();
			if ($dt) {
				return '2';
			} else {
				return '0';
			}
		} else {
			$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $day);
			$st->BindParam(3, $currentshift);
			$st->BindParam(4, $currentshiftcode);
			$st->BindParam(5, $amountpaid);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $currentusercode);
			$st->BindParam(8, $instcode);
			$st->BindParam(9, $type);
			$opensummary = $st->execute();
			if ($opensummary) {
				return '2';
			} else {
				return '0';
			}
		}			
	}

	// 12 SEPT 2023, 15 JUNE 2022 JOSEPH ADORBOE 
	public function gettotalrunningdeposit($currentshiftcode,$type,$instcode){	
		$three = 3;
		$one = 1;
		$sqlstmtsum = "SELECT CS_TOTAL from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? and CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtsum);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $type);
		$cs = $st->execute();
		if($cs){
			if ($st->rowcount() >'0') {
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = floatval($obj['CS_TOTAL']);				
				return $value;
			}else{
				return '-1';
			}
		}else{
			return '-1';
		}		
	}
	// 12 sept 2023 , 27 NOV 2022
	public function gettotalsummary(String $currentusercode, String $currentshiftcode,  String $instcode, String $type) 
		{
		$one = 1;
		$value = '0';
		$sql = " SELECT SUM(CS_TOTAL) AS STOCKVALUE FROM octopus_cashier_summary WHERE CS_SHIFTCODE = ? and CS_ACTORCODE = ? and  CS_INSTCODE = ? AND CS_STATUS = ? and CS_TYPE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $currentshiftcode);	
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $type);
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = floatval($obj['STOCKVALUE']);
				return $value;					
			}else{
				return $value;	
			}
		}else{
			return $value;	
		}
				
	}

	// 12 SEPT 2023, 15 JUNE 2022 JOSEPH ADORBOE 
	public function depositsummaryoperations($form_key,$day, $currentshift,$currentusercode,$amountpaid,$currentuser,$currentshiftcode,$instcode){	
			$three = 3;
			$one = 1;
			$four = 4;
			$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? and CS_TYPE = ?";
			$st = $this->db->prepare($sqlstmtsum);
			$st->BindParam(1, $currentshiftcode);
			$st->BindParam(2, $currentusercode);
			$st->BindParam(3, $instcode);
			$st->BindParam(4, $one);
			$st->BindParam(5, $three);
			$cs = $st->execute();
			if ($st->rowcount() >'0') {
				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? and CS_TYPE = ?";
				$st = $this->db->prepare($sqlstmtst);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $currentshiftcode);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $one);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $three);
				$dt = $st->execute();

				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? and CS_TYPE = ?";
				$st = $this->db->prepare($sqlstmtst);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $currentshiftcode);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $one);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $four);
				$dt = $st->execute();
				if ($dt) {
					return '2';
				} else {
					return '0';
				}
			} else {
				$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $currentshift);
				$st->BindParam(4, $currentshiftcode);
				$st->BindParam(5, $amountpaid);
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $currentusercode);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $three);
				$opensummary = $st->execute();
				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? and CS_TYPE = ?";
				$st = $this->db->prepare($sqlstmtst);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $currentshiftcode);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $one);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $four);
				$dt = $st->execute();
				if ($opensummary) {
					return '2';
				} else {
					return '0';
				}
			}
				
	}
	// 10 SEPT 2023, 08 SEPT 2022  JOSEPH ADORBOE
	public function updaterefundsummary($currentshiftcode,$refundamount,$instcode)
	{$one = 1;
		$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL - ? where CS_SHIFTCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmtst);
		$st->BindParam(1, $refundamount);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);
		$ext = $st->execute();
		if($ext){
			return '2';
		}else{
			return '0';
		}                 
    }
	// 29 AUG 2023 
	public function updatecashierinsurancesummary($insurancesummarycode,$amountpaid,$transactionshiftcode,$instcode){
		$two = 2;
		$one = 1;
		$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_CODE = ? AND CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtst);
		$st->BindParam(1, $amountpaid);
		$st->BindParam(2, $transactionshiftcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $insurancesummarycode);
		$st->BindParam(6, $two);		
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}
	// 29 AUG 2023, 01 FEB 2023 JOSEPH ADORBOE 
	public function getinsurancesummarycode($tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift){		
		$one = 1;
		$amt = 0;
		$two =2;
		$sqlstmt = ("SELECT * FROM octopus_cashier_summary where CS_DATE = ? AND CS_INSTCODE = ? AND CS_TYPE = ?  AND CS_STATUS = ? AND  CS_SHIFTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $transactiondate);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $two);
		$st->BindParam(4, $one);
		$st->BindParam(5, $transactionshiftcode);		
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				return $object['CS_CODE'];				 				
			}else{
				$insertinurancetill =  "INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_TYPE,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $tillcode);
				$st->BindParam(2, $transactiondate);
				$st->BindParam(3, $transactionshift);
				$st->BindParam(4, $transactionshiftcode);
				$st->BindParam(5, $amt);
				$st->BindParam(6, $two);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);				
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return $tillcode ;
                } else {
                    return '0' ;
                }
            }		
		}
	}
	// 29 AUG 2023 
	public function selectinsertupdatecashiersummary($form_key,$day,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$amountdeducted){
		$one = 1;
		$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? AND CS_TYPE = ?";
		$st = $this->db->prepare($sqlstmtsum);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $one);
		$cs = $st->execute();
		if ($st->rowcount() >'0') {
			$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_TYPE = ? ";
			$st = $this->db->prepare($sqlstmtst);
			$st->BindParam(1, $amountdeducted);
			$st->BindParam(2, $currentshiftcode);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $one);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $one);
			$dt = $st->execute();
			if ($dt) {
				return '2';
			} else {
				return '0';
			}
		} else {
			$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $day);
			$st->BindParam(3, $currentshift);
			$st->BindParam(4, $currentshiftcode);
			$st->BindParam(5, $amountdeducted);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $currentusercode);
			$st->BindParam(8, $instcode);
			$st->BindParam(9, $one);
			$opensummary = $st->execute();
			if ($opensummary) {
				return '2';
			} else {
				return '0';
			}
		}
	}
	
} 
$cashiersummarytable = new OctopusCashierSummarySql();
?>