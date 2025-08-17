<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_cashier_endofday
	$endofdaytable = new OctopusCashierEndofdaySql();
*/

class OctopusCashierEndofdaySql Extends Engine{
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function queryendofday($instcode){
		
		$list = ("SELECT * from octopus_cashier_endofday where END_STATUS IN('1','2') and END_INSTCODE = '$instcode' ");
		return $list;
	}
	// 10 SEPT 2023 12 APR 2023  JOSEPH ADORBOE 
	public function approveendofday($ekey,$approveremarks,$day,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$two =2;
		$zero =0;

		$sqlstmts = "UPDATE octopus_cashier_endofday set END_APPROVEREMARKS = ? ,END_APPROVEACTOR = ? ,END_APPROVEACTOTCODE = ? ,END_APPROVEDATE = ?, END_STATUS = ? where END_CODE = ? and END_INSTCODE = ? AND END_STATUS = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $approveremarks);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $day);
		$st->BindParam(5, $two);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $one);
		$tills = $st->execute();			
		if ($tills) {
			return '2';
		} else {
			return '0';
		}
						
	}
	// 10 SEPT 2023, 12 APR 2023  JOSEPH ADORBOE 
	public function updateendofday($ekey,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$zero =0;

		$sqlstmts = "UPDATE octopus_cashier_endofday set END_DATE = ? ,END_SHIFTCODE = ? ,END_SHIFT = ? ,END_ACCOUNT = ? ,END_SLIPNUM = ? ,END_BANKAMOUNT = ? ,END_MOMOBALANCEOPEN = ? ,END_MOMOAMOUNT = ? ,END_MOMOBALANCECLOSE = ? ,END_TOTALAMOUNT = ? ,END_CASH = ? ,END_CASHIERREMARKS = ? ,END_ACTOR = ? ,END_ACTORCODE = ?  where END_CODE = ? and END_INSTCODE = ? AND END_STATUS = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $shiftdate);
		$st->BindParam(2, $shiftcode);
		$st->BindParam(3, $shiftname);
		$st->BindParam(4, $bankaccountdetails);
		$st->BindParam(5, $bankdepositslip);
		$st->BindParam(6, $bankcashtotalamount);
		$st->BindParam(7, $ecashopeningbalance);
		$st->BindParam(8, $ecashtotalamount);
		$st->BindParam(9, $ecashclosebal);
		$st->BindParam(10, $totalamount);
		$st->BindParam(11, $cashathand);
		$st->BindParam(12, $remarks);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $one);
		$exe = $st->execute();				
		if ($exe) {
			return '2';
		} else {
			return '0';
		}
						
	}	

	// 10 SEPT 2023 JOSEPH ADORBOE 
	public function newendofday($form_key,$eodnumber,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$currentusercode,$currentuser,$instcode){	
			$one = 1;		
			$sqlstmt = "SELECT * from octopus_cashier_endofday where END_SHIFTCODE = ? and END_INSTCODE = ? and END_STATUS = ? ";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $shiftcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $one);
			$till = $st->execute();
			if ($till) {				
				$sql = ("INSERT INTO octopus_cashier_endofday (END_CODE,END_NUMBER,END_DATE,END_SHIFTCODE,END_SHIFT,END_ACCOUNT,END_SLIPNUM,END_BANKAMOUNT,END_MOMOBALANCEOPEN,END_MOMOAMOUNT,END_MOMOBALANCECLOSE,END_TOTALAMOUNT,END_CASH,END_CASHIERREMARKS,END_ACTOR,END_ACTORCODE,END_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $eodnumber);
				$st->BindParam(3, $shiftdate);
				$st->BindParam(4, $shiftcode);
				$st->BindParam(5, $shiftname);
				$st->BindParam(6, $bankaccountdetails);
				$st->BindParam(7, $bankdepositslip);
				$st->BindParam(8, $bankcashtotalamount);
				$st->BindParam(9, $ecashopeningbalance);
				$st->BindParam(10, $ecashtotalamount);
				$st->BindParam(11, $ecashclosebal);
				$st->BindParam(12, $totalamount);
				$st->BindParam(13, $cashathand);
				$st->BindParam(14, $remarks);
				$st->BindParam(15, $currentuser);
				$st->BindParam(16, $currentusercode);
				$st->BindParam(17, $instcode);
				$open = $st->execute();					
					if ($open) {
						return '2';
					} else {
						return '0';
					}
			}else{					
				return '0';					
			}			
	}	

	
} 
$endofdaytable = new OctopusCashierEndofdaySql();
?>