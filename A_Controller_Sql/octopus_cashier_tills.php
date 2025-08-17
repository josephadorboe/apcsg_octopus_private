<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_cashier_tills
	$cashiertillstable->dashboardedtypetillquery($currentshiftcode,$instcode,$type)
*/

class OctopusCashierTillsSql Extends Engine{
	// 1 JAN 2024 JOSEPH ADORBOE
	public function dashboardedtillquery($currentshiftcode,$instcode){		
		$list = ("SELECT * FROM octopus_cashier_tills WHERE TILL_INSTCODE = '$instcode' AND TILL_STATUS = '1' AND TILL_SHIFTCODE = '$currentshiftcode' ORDER BY TILL_ID  DESC");
		return $list;
	}
	// 1 JAN 2024 JOSEPH ADORBOE
	public function dashboardedtypetillquery($currentshiftcode,$instcode,$type){		
		$list = ("SELECT * FROM octopus_cashier_tills WHERE  TILL_INSTCODE = '$instcode' and TILL_SHIFTCODE = '$currentshiftcode' AND TILL_TYPE = '$type' ORDER BY TILL_SCHEME DESC LIMIT 10 ");
	return $list;
	}
	// 12 SEPT 2023 JOSEPH ADORBOE
	public function dashboardtillquery($currentusercode,$currentshiftcode,$instcode,$type){		
		$list = ("SELECT * from octopus_cashier_tills where TILL_ACTORCODE = '$currentusercode' and TILL_INSTCODE = '$instcode' and TILL_SHIFTCODE = '$currentshiftcode' AND TILL_TYPE = '$type' ");
		return $list;
	}
						

	// 12 SEPT 2023,  15 JUNE 2022 JOSEPH ADORBOE 
	public function deposittillsoperations($form_key,$day, $currentshift,$currentusercode,$paymethcode,$paymeth,$amountpaid,$depositcode,$depositscheme,$currentuser,$currentshiftcode,$instcode){
		$three = 3;
		$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ?";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $depositcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $three);
		$till = $st->execute();
		if ($till) {
			if ($st->rowcount() >'0') {
				$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ?,TILL_ALTAMOUNT = TILL_ALTAMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ?";
				$st = $this->db->prepare($sqlstmts);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $amountpaid);
				$st->BindParam(3, $currentshiftcode);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $depositcode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $three);
				$tills = $st->execute();
				if($tills){
					return '2';
				}else{
					return '0';
				}
				
			} else {
				$sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE,TILL_TYPE,TILL_ALTAMOUNT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $currentshift);
				$st->BindParam(4, $currentshiftcode);
				$st->BindParam(5, $depositscheme);
				$st->BindParam(6, $depositcode);
				$st->BindParam(7, $paymeth);
				$st->BindParam(8, $paymethcode);
				$st->BindParam(9, $amountpaid);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $three);
				$st->BindParam(14, $amountpaid);
				$opentill = $st->execute();
				if($opentill){
					return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		} 	
	}
	// 10 SEPT 2023, 08 SEPT 2022  JOSEPH ADORBOE
	public function updatetillrefund($currentshiftcode,$refundamount,$instcode,$cashschemecode)
	{
		$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT - ? where TILL_SHIFTCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $refundamount);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $cashschemecode);
		$st->BindParam(4, $instcode);				
		$ext = $st->execute();
		if($ext){
			return '2';
		}else{
			return '0';
		}                  
    }
	// 20 SEPT 2022 JOSEPH ADORBOE 
	public function checkcashiertillbalance($currentshiftcode,$cashschemecode,$day,$instcode){
		$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_DATE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $day);
		$st->BindParam(3, $cashschemecode);
		$st->BindParam(4, $instcode);
		$till = $st->execute();
		if ($till) {
			if ($st->rowcount() >'0') {
				$obj =  $st->fetch(PDO::FETCH_ASSOC);
				return $obj['TILL_AMOUNT'];				
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}		
	
	// 29 AUG 2023 
	public function updatecashierinsurancetill($insurancetillcode,$amountpaid,$currentusercode,$transactionshiftcode,$paycode,$instcode){
		$two = 2;
		$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? ,TILL_ALTAMOUNT = TILL_ALTAMOUNT + ?  where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_CODE = ? AND TILL_TYPE = ?  ";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $amountpaid);
		$st->BindParam(2, $amountpaid);
		$st->BindParam(3, $transactionshiftcode);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $paycode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $insurancetillcode);
		$st->BindParam(8, $two);
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}
	// 29 AUG 2023, 01 FEB 2023 JOSEPH ADORBOE 
	public function getinsurancetillcode($paycode,$payname,$paymethcode,$paymeth,$tillcode,$currentusercode,$currentuser,$instcode,$transactiondate,$transactionshiftcode,$transactionshift){
		$but = 1;
		$amt = 0;
		$two =2;
		$sqlstmt = ("SELECT * FROM octopus_cashier_tills where TILL_DATE = ? AND TILL_INSTCODE = ? AND TILL_ACTORCODE = ? AND TILL_PAYMENTMETHODCODE = ? AND TILL_SCHEMECODE = ? AND TILL_STATUS = ? AND  TILL_SHIFTCODE = ? AND TILL_TYPE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $transactiondate);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $paymethcode);
		$st->BindParam(5, $paycode);
		$st->BindParam(6, $but);
		$st->BindParam(7, $transactionshiftcode);
		$st->BindParam(8, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				return $object['TILL_CODE'];				 				
			}else{
				$insertinurancetill =  "INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_AMOUNT,TILL_ALTAMOUNT,TILL_TYPE,TILL_INSTCODE,TILL_ACTOR,TILL_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $tillcode);
				$st->BindParam(2, $transactiondate);
				$st->BindParam(3, $transactionshift);
				$st->BindParam(4, $transactionshiftcode);
				$st->BindParam(5, $paymeth);
				$st->BindParam(6, $paymethcode);
				$st->BindParam(7, $payname);
				$st->BindParam(8, $paycode);
				$st->BindParam(9, $amt);
				$st->BindParam(10, $amt);
				$st->BindParam(11, $two);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
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
	public function selectinsertupdatetills($form_key,$day,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$amountdeducted,$foreigncurrency){
		$one = 1;
		$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $paycode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$till = $st->execute();
		if ($till) {
			if ($st->rowcount() >'0') {
				$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? ,TILL_ALTAMOUNT = TILL_ALTAMOUNT + ?  where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
				$st = $this->db->prepare($sqlstmts);
				$st->BindParam(1, $amountdeducted);
				$st->BindParam(2, $foreigncurrency);
				$st->BindParam(3, $currentshiftcode);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $paycode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $one);
				$tills = $st->execute(); 
				if($tills){
					return '2';
				}else{
					return '0';
				}
			}else{
				$sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE,TILL_ALTAMOUNT,TILL_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $currentshift);
				$st->BindParam(4, $currentshiftcode);
				$st->BindParam(5, $payname);
				$st->BindParam(6, $paycode);
				$st->BindParam(7, $paymeth);
				$st->BindParam(8, $paymethcode);
				$st->BindParam(9, $amountdeducted);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);	
				$st->BindParam(13, $foreigncurrency);
				$st->BindParam(14, $one);
				$tills = $st->execute(); 
				if($tills){
					return '2';
				}else{
					return '0';
				}	
			}	

		}else{
			return '0';
		}
				    
	}
}
$cashiertillstable = new OctopusCashierTillsSql(); 
?>