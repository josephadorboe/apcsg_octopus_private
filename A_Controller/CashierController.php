<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 10 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/


class cashierController Extends Engine
{

	// // 30 OCT 2021 JOSEPH ADORBOE 
	// public function makecopayment($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$currentday,$currentmonth,$currentyear,$amountdeducted,$foreigncurrency){
		
	// 	$one = 1;
	// 	$sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
	// 	$st = $this->db->prepare($sql);   
	// 	$st->BindParam(1, $form_key);
	// 	$st->BindParam(2, $visitcode);
	// 	$st->BindParam(3, $billingcode);
	// 	$st->BindParam(4, $day);
	// 	$st->BindParam(5, $days);
	// 	$st->BindParam(6, $patientcode);
	// 	$st->BindParam(7, $patientnumber);
	// 	$st->BindParam(8, $patient);
	// 	$st->BindParam(9, $paycode);
	// 	$st->BindParam(10, $payname);
	// 	$st->BindParam(11, $paymeth);
	// 	$st->BindParam(12, $paymethcode);
	// 	$st->BindParam(13, $amountpaid);
	// 	$st->BindParam(14, $totalgeneratedamountbal);
	// 	$st->BindParam(15, $bal);
	// 	$st->BindParam(16, $instcode);
	// 	$st->BindParam(17, $currentusercode);
	// 	$st->BindParam(18, $currentuser);
	// 	$st->BindParam(19, $currentshiftcode);
	// 	$st->BindParam(20, $currentshift);
	// 	$st->BindParam(21, $currentday);
	// 	$st->BindParam(22, $currentmonth);
	// 	$st->BindParam(23, $currentyear);
	// 	$st->BindParam(24, $phonenumber);
	// 	$st->BindParam(25, $chequenumber);
	// 	$st->BindParam(26, $bankcode);
	// 	$st->BindParam(27, $bankname);
	// 	$st->BindParam(28, $cashiertillcode);
	// 	$open = $st->execute();				
	// 	if($open){					
	// 		$sql = "UPDATE octopus_patients_billing SET BG_AMOUNTPAID = BG_AMOUNTPAID + ? , BG_AMOUNTBAL = BG_AMOUNTBAL - ?  WHERE BG_CODE = ? and BG_VISITCODE = ? and BG_INSTCODE = ? AND BG_TYPE = ? ";
	// 		$st = $this->db->prepare($sql);
	// 		$st->BindParam(1, $amountdeducted);
	// 		$st->BindParam(2, $amountdeducted);
	// 		$st->BindParam(3, $billingcode);
	// 		$st->BindParam(4, $visitcode);
	// 		$st->BindParam(5, $instcode);
	// 		$st->BindParam(6, $one);
	// 		$selectitem = $st->Execute();	
	// 		if($selectitem){
	// 			$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
	// 			$st = $this->db->prepare($sqlstmt);
	// 			$st->BindParam(1, $currentshiftcode);
	// 			$st->BindParam(2, $currentusercode);
	// 			$st->BindParam(3, $paycode);
	// 			$st->BindParam(4, $instcode);
	// 			$st->BindParam(5, $one);
	// 			$till = $st->execute();
	// 			if ($till) {
	// 			    if ($st->rowcount() >'0') {
	// 			        $sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? ,TILL_ALTAMOUNT = TILL_ALTAMOUNT + ?  where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
	// 			        $st = $this->db->prepare($sqlstmts);
	// 			        $st->BindParam(1, $amountdeducted);
	// 					$st->BindParam(2, $foreigncurrency);
	// 			        $st->BindParam(3, $currentshiftcode);
	// 			        $st->BindParam(4, $currentusercode);
	// 			        $st->BindParam(5, $paycode);
	// 			        $st->BindParam(6, $instcode);
	// 					$st->BindParam(7, $one);
	// 			        $tills = $st->execute(); 
	// 			        if ($tills) {
	// 			            $bbt = 1;
	// 			            $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? AND CS_TYPE = ?";
	// 			            $st = $this->db->prepare($sqlstmtsum);
	// 			            $st->BindParam(1, $currentshiftcode);
	// 			            $st->BindParam(2, $currentusercode);
	// 			            $st->BindParam(3, $instcode);
	// 			            $st->BindParam(4, $bbt);
	// 						$st->BindParam(5, $one);
	// 			            $cs = $st->execute();
	// 			            if ($st->rowcount() >'0') {
	// 			                $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_TYPE = ? ";
	// 			                $st = $this->db->prepare($sqlstmtst);
	// 			                $st->BindParam(1, $amountdeducted);
	// 			                $st->BindParam(2, $currentshiftcode);
	// 			                $st->BindParam(3, $currentusercode);
	// 			                $st->BindParam(4, $bbt);
	// 			                $st->BindParam(5, $instcode);
	// 							$st->BindParam(6, $one);
	// 			                $dt = $st->execute();
	// 			                if ($dt) {
	// 			                    return '2';
	// 			                } else {
	// 			                    return '0';
	// 			                }
	// 			            } else {
	// 			                $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
	// 			                $st = $this->db->prepare($sql);
	// 			                $st->BindParam(1, $form_key);
	// 			                $st->BindParam(2, $day);
	// 			                $st->BindParam(3, $currentshift);
	// 			                $st->BindParam(4, $currentshiftcode);
	// 			                $st->BindParam(5, $amountdeducted);
	// 			                $st->BindParam(6, $currentuser);
	// 			                $st->BindParam(7, $currentusercode);
	// 			                $st->BindParam(8, $instcode);
	// 							$st->BindParam(9, $one);
	// 			                $opensummary = $st->execute();
	// 			                if ($opensummary) {
	// 			                    return '2';
	// 			                } else {
	// 			                    return '0';
	// 			                }
	// 			            }
	// 			        } else {
	// 			            return '0';
	// 			        }
	// 			    } else {
	// 			        $sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE,TILL_ALTAMOUNT,TILL_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
	// 			        $st = $this->db->prepare($sql);
	// 			        $st->BindParam(1, $form_key);
	// 			        $st->BindParam(2, $day);
	// 			        $st->BindParam(3, $currentshift);
	// 			        $st->BindParam(4, $currentshiftcode);
	// 			        $st->BindParam(5, $payname);
	// 			        $st->BindParam(6, $paycode);
	// 			        $st->BindParam(7, $paymeth);
	// 			        $st->BindParam(8, $paymethcode);
	// 			        $st->BindParam(9, $amountdeducted);
	// 			        $st->BindParam(10, $currentuser);
	// 			        $st->BindParam(11, $currentusercode);
	// 			        $st->BindParam(12, $instcode);	
	// 					$st->BindParam(13, $foreigncurrency);
	// 					$st->BindParam(14, $one);	
												
	// 			        $opentill = $st->execute();
	// 			        if ($opentill) {
	// 			            $bbt = 1;
	// 			            $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
	// 			            $st = $this->db->prepare($sqlstmtsum);
	// 			            $st->BindParam(1, $currentshiftcode);
	// 			            $st->BindParam(2, $currentusercode);
	// 			            $st->BindParam(3, $instcode);
	// 			            $st->BindParam(4, $bbt);
	// 			            $cs = $st->execute();
	// 			            if ($st->rowcount() >'0') {
	// 			                $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? AND CS_TYPE = ?";
	// 			                $st = $this->db->prepare($sqlstmtst);
	// 			                $st->BindParam(1, $amountdeducted);
	// 			                $st->BindParam(2, $currentshiftcode);
	// 			                $st->BindParam(3, $currentusercode);
	// 			                $st->BindParam(4, $bbt);
	// 			                $st->BindParam(5, $instcode);
	// 							$st->BindParam(6, $one);
	// 			                $dt = $st->execute();
	// 			                if ($dt) {
	// 			                    return '2';
	// 			                } else {
	// 			                    return '0';
	// 			                }
	// 			            } else {
	// 			                $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE,CS_TYPE) VALUES (?,?,?,?,?,?,?,?,?) ");
	// 			                $st = $this->db->prepare($sql);
	// 			                $st->BindParam(1, $form_key);
	// 			                $st->BindParam(2, $day);
	// 			                $st->BindParam(3, $currentshift);
	// 			                $st->BindParam(4, $currentshiftcode);
	// 			                $st->BindParam(5, $amountdeducted);
	// 			                $st->BindParam(6, $currentuser);
	// 			                $st->BindParam(7, $currentusercode);
	// 			                $st->BindParam(8, $instcode);
	// 							$st->BindParam(9, $one);
	// 			                $opensummary = $st->execute();
	// 			                if ($opensummary) {
	// 			                    return '2';
	// 			                } else {
	// 			                    return '0';
	// 			                }
	// 			            }
	// 			        } else {
	// 			            return '0';
	// 			        }
	// 			    }
	// 			} else {
	// 			    return '0';
	// 			}
	// 		//	return '2';
	// 		}else{
	// 			return '0';
	// 		}						
	// 	}else{					
	// 		return '0';					
	// 	}			
	// }
	

	// 12 APR 2023  JOSEPH ADORBOE 
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

	// 12 APR 2023  JOSEPH ADORBOE 
	public function editendofday($form_key,$ekey,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$day,$currentusercode,$currentuser,$instcode){
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
		$tills = $st->execute();


		$sqlstmts = "UPDATE octopus_shifts set SHIFT_ENDOFDAY = ? where SHIFT_CODE = ? and SHIFT_INSTCODE = ? AND SHIFT_ENDOFDAY = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $one);
		$st->BindParam(2, $shiftcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $zero);
		$tills = $st->execute();			
				
		if ($tills) {
			return '2';
		} else {
			return '0';
		}
						
	}	
	

	// 12 APR 2023  JOSEPH ADORBOE 
	public function addendofday($form_key,$eodnumber,$shiftcode,$shiftname,$shiftdate,$bankcashtotalamount,$bankaccountdetails,$bankdepositslip,$ecashopeningbalance,$ecashtotalamount,$ecashclosebal,$cashathand,$totalamount,$remarks,$day,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$zero =0;
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
				
				$sqlstmts = "UPDATE octopus_shifts set SHIFT_ENDOFDAY = ? where SHIFT_CODE = ? and SHIFT_INSTCODE = ? AND SHIFT_ENDOFDAY = ?";
				$st = $this->db->prepare($sqlstmts);
				$st->BindParam(1, $one);
				$st->BindParam(2, $shiftcode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $zero);
				$tills = $st->execute();

					if ($open) {
						return '2';
					} else {
						return '0';
					}
			}else{					
				return '0';					
			}	
			
	}	
	

	
	
			// 	$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
			// 	$st = $this->db->prepare($sqlstmt);
			// 	$st->BindParam(1, $currentshiftcode);
			// 	$st->BindParam(2, $currentusercode);
			// 	$st->BindParam(3, $paycode);
			// 	$st->BindParam(4, $instcode);
			// 	$till = $st->execute();
			// 	if ($till) {
			// 	    if ($st->rowcount() >'0') {
			// 	        $sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
			// 	        $st = $this->db->prepare($sqlstmts);
			// 	        $st->BindParam(1, $amountdeducted);
			// 	        $st->BindParam(2, $currentshiftcode);
			// 	        $st->BindParam(3, $currentusercode);
			// 	        $st->BindParam(4, $paycode);
			// 	        $st->BindParam(5, $instcode);
			// 	        $tills = $st->execute();
			// 	        if ($tills) {
			// 	            $bbt = 1;
			// 	            $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
			// 	            $st = $this->db->prepare($sqlstmtsum);
			// 	            $st->BindParam(1, $currentshiftcode);
			// 	            $st->BindParam(2, $currentusercode);
			// 	            $st->BindParam(3, $instcode);
			// 	            $st->BindParam(4, $bbt);
			// 	            $cs = $st->execute();
			// 	            if ($st->rowcount() >'0') {
			// 	                $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
			// 	                $st = $this->db->prepare($sqlstmtst);
			// 	                $st->BindParam(1, $amountdeducted);
			// 	                $st->BindParam(2, $currentshiftcode);
			// 	                $st->BindParam(3, $currentusercode);
			// 	                $st->BindParam(4, $bbt);
			// 	                $st->BindParam(5, $instcode);
			// 	                $dt = $st->execute();
			// 	                if ($dt) {
			// 	                    return '2';
			// 	                } else {
			// 	                    return '0';
			// 	                }
			// 	            } else {
			// 	                $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
			// 	                $st = $this->db->prepare($sql);
			// 	                $st->BindParam(1, $form_key);
			// 	                $st->BindParam(2, $day);
			// 	                $st->BindParam(3, $currentshift);
			// 	                $st->BindParam(4, $currentshiftcode);
			// 	                $st->BindParam(5, $amountdeducted);
			// 	                $st->BindParam(6, $currentuser);
			// 	                $st->BindParam(7, $currentusercode);
			// 	                $st->BindParam(8, $instcode);
			// 	                $opensummary = $st->execute();
			// 	                if ($opensummary) {
			// 	                    return '2';
			// 	                } else {
			// 	                    return '0';
			// 	                }
			// 	            }
			// 	        } else {
			// 	            return '0';
			// 	        }
			// 	    } else {
			// 	        $sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
			// 	        $st = $this->db->prepare($sql);
			// 	        $st->BindParam(1, $form_key);
			// 	        $st->BindParam(2, $day);
			// 	        $st->BindParam(3, $currentshift);
			// 	        $st->BindParam(4, $currentshiftcode);
			// 	        $st->BindParam(5, $payname);
			// 	        $st->BindParam(6, $paycode);
			// 	        $st->BindParam(7, $paymeth);
			// 	        $st->BindParam(8, $paymethcode);
			// 	        $st->BindParam(9, $amountdeducted);
			// 	        $st->BindParam(10, $currentuser);
			// 	        $st->BindParam(11, $currentusercode);
			// 	        $st->BindParam(12, $instcode);							
			// 	        $opentill = $st->execute();
			// 	        if ($opentill) {
			// 	            $bbt = 1;
			// 	            $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
			// 	            $st = $this->db->prepare($sqlstmtsum);
			// 	            $st->BindParam(1, $currentshiftcode);
			// 	            $st->BindParam(2, $currentusercode);
			// 	            $st->BindParam(3, $instcode);
			// 	            $st->BindParam(4, $bbt);
			// 	            $cs = $st->execute();
			// 	            if ($st->rowcount() >'0') {
			// 	                $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
			// 	                $st = $this->db->prepare($sqlstmtst);
			// 	                $st->BindParam(1, $amountdeducted);
			// 	                $st->BindParam(2, $currentshiftcode);
			// 	                $st->BindParam(3, $currentusercode);
			// 	                $st->BindParam(4, $bbt);
			// 	                $st->BindParam(5, $instcode);
			// 	                $dt = $st->execute();
			// 	                if ($dt) {
			// 	                    return '2';
			// 	                } else {
			// 	                    return '0';
			// 	                }
			// 	            } else {
			// 	                $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
			// 	                $st = $this->db->prepare($sql);
			// 	                $st->BindParam(1, $form_key);
			// 	                $st->BindParam(2, $day);
			// 	                $st->BindParam(3, $currentshift);
			// 	                $st->BindParam(4, $currentshiftcode);
			// 	                $st->BindParam(5, $amountdeducted);
			// 	                $st->BindParam(6, $currentuser);
			// 	                $st->BindParam(7, $currentusercode);
			// 	                $st->BindParam(8, $instcode);
			// 	                $opensummary = $st->execute();
			// 	                if ($opensummary) {
			// 	                    return '2';
			// 	                } else {
			// 	                    return '0';
			// 	                }
			// 	            }
			// 	        } else {
			// 	            return '0';
			// 	        }
			// 	    }
			// 	} else {
			// 	    return '0';
			// 	}
			// //	return '2';
			



	// 27 MAY 2022  JOSEPH ADORBOE
	public function getinsuracnetotal($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$instcode){	
		$nut = 1;
		$zero = '0';
		$two = 2;	
		$sql = 'SELECT SUM(B_TOTAMT) AS TOT  FROM octopus_patients_billitems  WHERE B_INSTCODE = ?  AND B_STATUS != ? AND B_STATUS != ? AND B_METHODCODE IN(?,?,?)';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $two);
		$st->BindParam(4, $privateinsurancecode);
		$st->BindParam(5, $nationalinsurancecode);
		$st->BindParam(6, $partnercompaniescode);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 						0					
				$currentdetails = $obj['TOT'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 27 MAY 2022  JOSEPH ADORBOE
	public function getcurrentcashierinsuracnetotal($privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$currentshiftcode,$instcode){	
		$nut = 1;
		$zero = '0';
		$two = 2;	
		$sql = 'SELECT SUM(B_TOTAMT) AS TOT  FROM octopus_patients_billitems  WHERE B_SHIFTCODE = ? AND B_INSTCODE = ?  AND B_STATUS != ? AND B_STATUS != ? AND B_METHODCODE IN(?,?,?)';
		$st = $this->db->prepare($sql);
	//	$st->BindParam(1, $currentusercode);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $two);
		$st->BindParam(5, $privateinsurancecode);
		$st->BindParam(6, $nationalinsurancecode);
		$st->BindParam(7, $partnercompaniescode);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					
				$currentdetails = $obj['TOT'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 27 MAY 2022  JOSEPH ADORBOE
	public function getcurrentcashierstotal($currentshiftcode,$instcode){	
		$nut = 1;	
		$sql = 'SELECT * FROM octopus_cashier_summary WHERE CS_SHIFTCODE = ? AND CS_INSTCODE = ? AND CS_STATUS = ? AND CS_TYPE = ?';
		$st = $this->db->prepare($sql);
	//	$st->BindParam(1, $currentusercode);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$st->BindParam(4, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					
				$currentdetails = $obj['CS_TOTAL'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 27 MAY 2022 JOSEPH ADORBOE
	public function getcashiertilldetail($currentshiftcode,$instcode){	
		$nut = 1;	
		$sql = 'SELECT * FROM octopus_cashiertill WHERE CA_SHIFTCODE = ?  AND  CA_INSTCODE = ? AND CA_STATUS = ?';
		$st = $this->db->prepare($sql);
	//	$st->BindParam(1, $currentusercode);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					1						2							3						4					5						6				
				$currentdetails = $obj['CA_CASH'].'@@@'.$obj['CA_CHEQUES'].'@@@'.$obj['CA_MOMO'].'@@@'.$obj['CA_INSURANCE'].'@@@'.$obj['CA_CREDIT'].'@@@'.$obj['CA_POS'].'@@@'.$obj['CA_TOTALAMT'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}
	
	
		

	// 30 OCT 2021  2021  JOSEPH ADORBOE
	public function generatecopaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode)
	{		
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {
                $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS,BP_DT,BP_BILLINGCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $day);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patientnumber);
                $st->BindParam(5, $patient);
                $st->BindParam(6, $billcode);
                $st->BindParam(7, $remarks);
                $st->BindParam(8, $currentshiftcode);
                $st->BindParam(9, $currentshift);
                $st->BindParam(10, $cashiertillcode);
                $st->BindParam(11, $payname);
                $st->BindParam(12, $paycode);
                $st->BindParam(13, $visitcode);
                $st->BindParam(14, $totalgeneratedamount);
                $st->BindParam(15, $amountpaid);
                $st->BindParam(16, $currentusercode);
                $st->BindParam(17, $currentuser);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $chang);
                $st->BindParam(20, $receiptnumber);
                $st->BindParam(21, $paymeth);
                $st->BindParam(22, $paymethcode);
                $st->BindParam(23, $state);
                $st->BindParam(24, $phonenumber);
                $st->BindParam(25, $chequenumber);
                $st->BindParam(26, $insurancebal);
                $st->BindParam(27, $bankcode);
                $st->BindParam(28, $bankname);
				$st->BindParam(29, $days);
				$st->BindParam(30, $billingcode);
                $genreceipt = $st->execute();
                if ($genreceipt) {
                    $a = '2';
                    $b = '3';
                    $c = '1';
                
                    $sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? ");
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $a);
                    $st->BindParam(2, $b);
                    $st->BindParam(3, $day);
                    $st->BindParam(4, $form_key);
                    $st->BindParam(5, $currentuser);
                    $st->BindParam(6, $currentusercode);
                    $st->BindParam(7, $currentshiftcode);
                    $st->BindParam(8, $currentshift);
                    $st->BindParam(9, $a);
                    $st->BindParam(10, $paycode);
                    $st->BindParam(11, $payname);
                    $st->BindParam(12, $visitcode);
                    $st->BindParam(13, $a);
                    //	$st->BindParam(14, $billcode);
                    $updtebilitems = $st->execute();
                    if ($updtebilitems) {
                        $vt = 2 ;
                        $sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $form_key);
                        $st->BindParam(2, $currentuser);
                        $st->BindParam(3, $currentusercode);
                        $st->BindParam(4, $vt);
                        $st->BindParam(5, $billcode);
                        $updatebills = $st->execute();
                        if ($updatebills) {
                            $vt = 1;
							$nut = 2;
                            $sql = "UPDATE octopus_patients_discounts SET PDS_RECEIPTCODE = ? , PDS_STATUS = ?  WHERE PDS_PATIENTCODE = ? AND  PDS_STATUS = ? AND PDS_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $nut);
							$st->BindParam(3, $patientcode);
							$st->BindParam(4, $vt);
							$st->BindParam(5, $instcode);
							$recipt = $st->Execute();

							$nut = 2;
							$not = 1;
                            $sql = "UPDATE octopus_patients_billing SET BG_STATUS = ?, BG_RECEIPTNUMBER = ? WHERE BG_CODE = ? AND  BG_STATUS = ? AND BG_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $nut);
                            $st->BindParam(2, $receiptnumber);
							$st->BindParam(3, $billingcode);
							$st->BindParam(4, $not);
							$st->BindParam(5, $instcode);
							$recipt = $st->Execute();

							$not = 1;
                            $sql = "UPDATE octopus_patients_billingpayments SET BPT_RECEIPTNUMBER = ? WHERE BPT_BILLINGCODE = ? AND  BPT_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $receiptnumber);
                            $st->BindParam(2, $billingcode);
							$st->BindParam(3, $instcode);
						//	$st->BindParam(4, $not);
						//	$st->BindParam(5, $instcode);
							$recipt = $st->Execute();


							$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $vt);
                            $st->BindParam(2, $instcode);
                            $recipt = $st->Execute();
                            if ($recipt) {
                                $selected = 2;
                                $unselected = 1;
                                $paid = 4;
                                $show = 7;
                                
                                // pay before service
                                if ($payingtype == 1) {
                                    $selected = 2;
                                    $unselected = 1;
                                    $paid = 4;
                                    $show = 7;

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                    $med = $st->Execute();
                                
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $visitcode);
                                        $st->BindParam(5, $unselected);
                                        $st->BindParam(6, $instcode);
										$st->BindParam(7, $patientcode);
                                        $labs = $st->Execute();

										$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
										$st = $this->db->prepare($sqlprescriptions);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$prescriptions = $st->Execute();

										$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
										$st = $this->db->prepare($sqldevices);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$devices = $st->Execute();

										$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
										$st = $this->db->prepare($sqlprocedure);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$procedure = $st->Execute();

										return '2';

                                                                      

                                    // pay after service
                                } elseif ($payingtype == 7) {

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                //    $st->BindParam(6, $instcode);
                                    $med = $st->Execute();
									
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and  REQU_SELECTED = ? and REQU_INSTCODE = ?  AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =?";
									$st = $this->db->prepare($sqllabs);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$labs = $st->Execute();

									$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET  PRESC_STATUS = ? , PRESC_SELECTED = ? WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? and PRESC_INSTCODE = ? AND PRESC_PATIENTCODE = ?";
									$st = $this->db->prepare($sqlprescriptions);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$prescriptions = $st->Execute();

									$sqldevices = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_SELECTED = ? WHERE PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? AND PD_PATIENTCODE = ?";
									$st = $this->db->prepare($sqldevices);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$devices = $st->Execute();

									$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATUS = ? , PPD_SELECTED = ? WHERE PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_PATIENTCODE = ? AND PPD_PATIENTCODE = ?";
									$st = $this->db->prepare($sqlprocedure);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $selected);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$st->BindParam(6, $patientcode);
									$procedure = $st->Execute();
									return '2';
                                    
                                } else {   $selected = 2;
                                    $unselected = 1;
                                    $paid = 4;
                                    $show = 7;

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                    $med = $st->Execute();
                                
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? AND  REQU_PATIENTCODE = ?";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
									$st->BindParam(7, $patientcode);
                                    $servicerequest = $st->Execute();

									$sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? AND MIV_PATIENTCODE =? ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $visitcode);
                                        $st->BindParam(5, $unselected);
                                        $st->BindParam(6, $instcode);
										$st->BindParam(7, $patientcode);
                                        $labs = $st->Execute();

										$sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_PATIENTCODE = ?";
										$st = $this->db->prepare($sqlprescriptions);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$prescriptions = $st->Execute();

										$sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ? AND PD_PATIENTCODE = ?";
										$st = $this->db->prepare($sqldevices);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$devices = $st->Execute();

										$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
										$st = $this->db->prepare($sqlprocedure);
										$st->BindParam(1, $paid);
										$st->BindParam(2, $selected);
										$st->BindParam(3, $selected);
										$st->BindParam(4, $unselected);
										$st->BindParam(5, $visitcode);
										$st->BindParam(6, $unselected);
										$st->BindParam(7, $patientcode);
										$procedure = $st->Execute();

										return '2';                                   
                                }
                            } else {
                                return '0';
                            }
                        } else {
                            return '0';
                        }
                    } else {
                        return '0';
                    }
                } else {
                    return '0';
                }
            } else {
                return '0';
            }
        }else{
			return '0';
		}
	}




	// // 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	// public function getpatientbillinggeneratedcode($patientcode,$visitcode,$instcode,$type)
	// {		
	// 	$rant = 1;
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ");
    //     $st = $this->db->prepare($sqlstmt);
    //     $st->BindParam(1, $patientcode);
    //     $st->BindParam(2, $instcode);
    //     $st->BindParam(3, $visitcode);
	// 	$st->BindParam(4, $rant);
	// 	$st->BindParam(5, $type);
    //     $details =	$st->execute();
    //     if ($details) {
    //         if ($st->rowcount() > 0) {
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$billdetails = $object['BG_CODE']	;
    //             return $billdetails;
    //         } else {
	// 			return '0';
    //         }
    //     } else {
    //         return '0';
    //     }		
	// }

	// // 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	// public function getpatientbillingdetailscash($patientcode,$visitcode,$instcode)
	// {		
	// 	$one = 1;
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ");
    //     $st = $this->db->prepare($sqlstmt);
    //     $st->BindParam(1, $patientcode);
    //     $st->BindParam(2, $instcode);
    //     $st->BindParam(3, $visitcode);
	// 	$st->BindParam(4, $one);
	// 	$st->BindParam(5, $one);
    //     $details =	$st->execute();
    //     if ($details) {
    //         if ($st->rowcount() > 0) {
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$billdetails = $object['BG_CODE'].'@'.$object['BG_AMOUNT'].'@'.$object['BG_AMOUNTPAID'].'@'.$object['BG_AMOUNTBAL']	;
    //             return $billdetails;
    //         } else {
	// 			return '0';
    //         }
    //     } else {
    //         return '0';
    //     }		
	// }

	// // 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	// public function getpatientbillingdetails($patientcode,$visitcode,$instcode,$type)
	// {		
	// 	$rant = 1;
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ?");
    //     $st = $this->db->prepare($sqlstmt);
    //     $st->BindParam(1, $patientcode);
    //     $st->BindParam(2, $instcode);
    //     $st->BindParam(3, $visitcode);
	// 	$st->BindParam(4, $rant);
	// 	$st->BindParam(5, $type);
    //     $details =	$st->execute();
    //     if ($details) {
    //         if ($st->rowcount() > 0) {
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$billdetails = $object['BG_CODE'].'@'.$object['BG_AMOUNT'].'@'.$object['BG_AMOUNTPAID'].'@'.$object['BG_AMOUNTBAL']	;
    //             return $billdetails;
    //         } else {
	// 			return '0';
    //         }
    //     } else {
    //         return '0';
    //     }		
	// }


	
	// 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	public function getgeneratedbillcode($patientcode,$patientnumber,$patient,$visitcode,$days,$day,$currentuser,$currentusercode,$instcode,$type)
	{		
		$rant = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
		$st->BindParam(4, $rant);
		$st->BindParam(5, $type);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$billcode = $object['BG_CODE']	;
                return $billcode;
            } else {
				$billcode = md5(microtime());
				$sql = "INSERT INTO octopus_patients_billing(BG_CODE,BG_PATIENTCODE,BG_PATIENTNUMBER,BG_PATIENT,BG_VISITCODE,BG_DATE,BG_BILLDATE,BG_ACTOR,BG_ACTORCODE,BG_INSTCODE,BG_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $billcode);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $day);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $type);
				$addbills = $st->Execute();
				if($addbills){
					return $billcode;
				}else{
					return '0';
				}		
            }
        } else {
            return '0';
        }		
	}


	// // 30 SEPT 2021 JOSEPH ADORBOE 
	// public function getdiscountdetails($idvalue){
	// 	$nut = 2;
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_discounts WHERE PDS_RECEIPTCODE = ? AND PDS_STATUS = ? ");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $idvalue);
	// 	$st->BindParam(2, $nut);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		if($st->rowcount() > 0){
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$results = $object['PDS_SERVICE'].'@@'.$object['PDS_SERVICEAMOUNT'].'@@'.$object['PDS_DISCOUNTAMOUNT'].'@@'.$object['PDS_DISCOUNT'];
	// 			return $results;
	// 		}else{
	// 			return'1';
	// 		}

	// 	}else{
	// 		return '0';
	// 	}			
	// }	

	// 29 JULY 2021 JOSEPH ADORBOE 
	public function cashiercanceltransactions($bcode,$billcode,$amt,$servicecode,$dpts,$visitcode,$instcode){

		$but = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$nt = '0';
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_STATUS = ?, B_COMPLETE = ? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nt);
				$st->BindParam(2, $nt);
				$st->BindParam(3, $nt);
				$st->BindParam(4, $bcode);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $visitcode);
			//	$st->BindParam(7, $visitcode);
				$selectitem = $st->Execute();				
					if($selectitem){

							$selected = 1;
							$unselected = '0';
							$sted = 2;
							$utied = 3 ;
							if($dpts == 'SERVICES'){				
								
								$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? and REQU_SELECTED = ?  and REQU_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $unselected);
								$st->BindParam(5, $instcode);
							//	$st->BindParam(6, $vl);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'LABS'){
								
								$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_STATE = ? AND MIV_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $sted);
								$st->BindParam(2, $unselected);
								$st->BindParam(3, $servicecode);
								$st->BindParam(4, $visitcode);
								$st->BindParam(5, $utied);
								$st->BindParam(6, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

								}else if($dpts == 'SCANS'){
								
									$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_STATE = ? AND MIV_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $sted);
									$st->BindParam(2, $unselected);
									$st->BindParam(3, $servicecode);
									$st->BindParam(4, $visitcode);
									$st->BindParam(5, $utied);
									$st->BindParam(6, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
							
							}else if($dpts == 'PHARMACY'){

								$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_SELECTED = ? WHERE PRESC_CODE = ? AND PRESC_VISITCODE = ? and PRESC_STATE = ? AND PRESC_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $sted);
								$st->BindParam(2, $unselected);
								$st->BindParam(3, $servicecode);
								$st->BindParam(4, $visitcode);
								$st->BindParam(5, $utied);
								$st->BindParam(6, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'DEVICES'){

									$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_SELECTED = ? WHERE PD_CODE = ? and PD_VISITCODE = ? and PD_STATE = ? and PD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $sted);
									$st->BindParam(2, $unselected);
									$st->BindParam(3, $servicecode);
									$st->BindParam(4, $visitcode);
									$st->BindParam(5, $utied);
									$st->BindParam(6, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
										
								}else if($dpts == 'PROCEDURE'){

									$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_SELECTED = ? WHERE PPD_CODE = ? and PPD_VISITCODE = ? and PPD_STATE = ? and PPD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $sted);
									$st->BindParam(2, $unselected);
									$st->BindParam(3, $servicecode);
									$st->BindParam(4, $visitcode);
									$st->BindParam(5, $utied);
									$st->BindParam(6, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
										
								}else if($dpts == 'MEDREPORTS'){
									$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATE = ? , MDR_SELECTED = ? WHERE MDR_CODE = ? and MDR_VISITCODE = ? and MDR_STATE = ? and MDR_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $sted);
									$st->BindParam(2, $unselected);
									$st->BindParam(3, $servicecode);
									$st->BindParam(4, $visitcode);
									$st->BindParam(5, $utied);
									$st->BindParam(6, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
							}else{
								return '1';
							}					
												
					}else{						
						return '0' ;						
					}
				}			
		}else{			
			return '0' ;			
		}	
	}

	// 04 JULY 2021 JOSEPH ADORBOE
	public function getcurrentcashiertotal($currentusercode,$currentshiftcode,$instcode){	
		$nut = 1;	
		$sql = 'SELECT * FROM octopus_cashier_summary WHERE CS_ACTORCODE = ? and CS_SHIFTCODE = ?  and CS_INSTCODE = ? and CS_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					
				$currentdetails = $obj['CS_TOTAL'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 20 JUNE 2021 JOSEPH ADORBOE
	public function getcashierdashboard($currentusercode,$currentshiftcode,$instcode){
        $nut = 1;
		$stet = 6;
		$sentout = 8;
        $not = '0';
		$rt = 'LABS';
        $sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATUS = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $pendinglabs = $st->rowcount();
        } else {
            return '0';
        }
        $sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $stet);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $awaitingresults = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $sentout);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $labssentout = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_st_labtest WHERE LTT_STATUS = ? and LTT_INSTCODE = ? ';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
    //    $st->BindParam(3, $currentusercode);
        $ext = $st->execute();
        if ($ext) {
            $lablist = $st->rowcount();
        } else {
            return '0';
        }
                       
        //							0				1						2					3						4					5						6
        $labdashboarddetails = $pendinglabs.'@@@'.$awaitingresults.'@@@'.$labssentout.'@@@'.$lablist;
        
        return $labdashboarddetails;
    }
	
	// 08 MAY 2021 JOSEPH ADORBOE
	public function getcurrentcashiertilldetails($currentusercode,$currentshiftcode,$instcode){	
		$nut = 1;	
		$sql = 'SELECT * FROM octopus_cashiertill WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE = ?  and CA_INSTCODE = ? and CA_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentshiftcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $nut);
		$ext = $st->execute();
		if($ext){		
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				// 							0					1						2							3						4					5						6				
				$currentdetails = $obj['CA_CASH'].'@@@'.$obj['CA_CHEQUES'].'@@@'.$obj['CA_MOMO'].'@@@'.$obj['CA_INSURANCE'].'@@@'.$obj['CA_CREDIT'].'@@@'.$obj['CA_POS'].'@@@'.$obj['CA_TOTALAMT'];				
				return $currentdetails;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}
	
	
	// // 08 MAY 2021 JOSEPH ADORBOE
	// public function getcurrentcashiertilldetails($currentusercode,$currentshiftcode,$instcode){	
	// 	$nut = 1;	
	// 	$sql = 'SELECT * FROM octopus_cashiertill WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE = ?  and CA_INSTCODE = ? and CA_STATUS = ?';
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $currentusercode);
	// 	$st->BindParam(2, $currentshiftcode);
	// 	$st->BindParam(3, $instcode);
	// 	$st->BindParam(4, $nut);
	// 	$ext = $st->execute();
	// 	if($ext){		
	// 		if($st->rowcount() > 0){			
	// 			$obj = $st->fetch(PDO::FETCH_ASSOC);
	// 			// 							0					1						2							3						4					5						6				
	// 			$currentdetails = $obj['CA_CASH'].'@@@'.$obj['CA_CHEQUES'].'@@@'.$obj['CA_MOMO'].'@@@'.$obj['CA_INSURANCE'].'@@@'.$obj['CA_CREDIT'].'@@@'.$obj['CA_POS'].'@@@'.$obj['CA_TOTALAMT'];				
	// 			return $currentdetails;					
	// 		}else{
	// 			return '0';
	// 		}
	// 	}else{
	// 		return '0';
	// 	}	
	// }
	

	// 30 OCT 2021 JOSEPH ADORBOE 
	public function getpatientbillingcode($bbcode,$patientcode,$patientnumber,$patient,$days,$visitcode,$currentuser,$currentusercode,$instcode){
		$nuy = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_bills where BILL_PATIENTCODE = ? and BILL_VISITCODE = ? and BILL_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $nuy);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['BILL_CODE'];
				return $value;
			}else{
				$sql = ("INSERT INTO octopus_patients_bills (BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $bbcode);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);			
				$opentill = $st->execute();				
				if($opentill){					
					return $bbcode;					
				}else{					
					return '0';					
				}
			}

		}else{
			return '-1';
		}
			
	}	
	
	// 12 MAR 2021  JOSEPH ADORBOE
	public function generatereceiptdefered($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$banks,$bankscode,$cashiertill)
	{		
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {
            			
		$sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $day);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $billcode);
		$st->BindParam(7, $remarks);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $currentshift);
		$st->BindParam(10, $cashiertilcode);
		$st->BindParam(11, $payname);
		$st->BindParam(12, $paycode);
		$st->BindParam(13, $visitcode);
		$st->BindParam(14, $totalamount);
		$st->BindParam(15, $amountpaid);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $currentuser);
		$st->BindParam(18, $instcode);
		$st->BindParam(19, $chang);	
		$st->BindParam(20, $receiptnumber);	
		$st->BindParam(21, $paymeth);	
		$st->BindParam(22, $paymethcode);	
		$st->BindParam(23, $state);
		$st->BindParam(24, $phonenumber);
		$st->BindParam(25, $chequenumber);
		$st->BindParam(26, $insurancebal);
		$st->BindParam(27, $bankscode);
		$st->BindParam(28, $banks);	
		$genreceipt = $st->execute();	
			if($genreceipt){
				$a = 6;
				$b = 2;
				$c = 1;
				$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? and B_BILLCODE = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $a);
				$st->BindParam(2, $a);
				$st->BindParam(3, $day);
				$st->BindParam(4, $form_key);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentshiftcode);
				$st->BindParam(8, $currentshift);
				$st->BindParam(9, $c);
				$st->BindParam(10, $paymethcode);
				$st->BindParam(11, $paymeth);
				$st->BindParam(12, $visitcode);
				$st->BindParam(13, $b);
				$st->BindParam(14, $billcode);
				$updtebilitems = $st->execute();
					if($updtebilitems){
						$vt = 6 ;
						$sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $currentuser);
						$st->BindParam(3, $currentusercode);
						$st->BindParam(4, $vt);
						$st->BindParam(5, $billcode);
						$updatebills = $st->execute();						
							if($updatebills){
								$nt = 3;
								$ty = 5;
								$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ?  WHERE REQU_BILLCODE = ? and REQU_STATUS = ?  ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $nt);
								$st->BindParam(2, $billcode);
								$st->BindParam(3, $ty);
								$servicerequest = $st->Execute();	
								if($servicerequest){
									$vt = 1;
									$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $vt);
									$st->BindParam(2, $instcode);
									$recipt = $st->Execute();	
									if($recipt){
										$selected = 5;
											$paid = 6;
											$pay = 2;
											$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ?  WHERE MIV_STATE = ? and MIV_BILLINGCODE = ?";
											$st = $this->db->prepare($sql);
											$st->BindParam(1, $paid);
											$st->BindParam(2, $pay);
											$st->BindParam(3, $selected);
											$st->BindParam(4, $billcode);
											$labs = $st->Execute();	
											if($labs){
												$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ?  WHERE PRESC_STATE = ? and PRESC_BILLINGCODE = ?";
												$st = $this->db->prepare($sql);
												$st->BindParam(1, $paid);
												$st->BindParam(2, $pay);
												$st->BindParam(3, $selected);
												$st->BindParam(4, $billcode);
												$labs = $st->Execute();	
												if($labs){
														$sede = 1;
														$sql = "UPDATE octopus_cashiertill SET  CA_INSURANCE = CA_INSURANCE + ?  WHERE CA_CODE = ? and CA_STATUS = ? ";
														$st = $this->db->prepare($sql);
														$st->BindParam(1, $totalamount);
													//	$st->BindParam(2, $totalamount);
														$st->BindParam(2, $cashiertill);
														$st->BindParam(3, $sede);
														$tills = $st->Execute();	
														if($tills){
															return '2';
														}else{
															return '0';
														}	
												}else{
													return '0';
												}
											}else{
												return '0';
											}
									}else{
										return '0';
									}				
								}else{
									return '0';
								}				
							}					
					}else{				
						return '0';				
					}
				}else{
					return '0';
				}
			}else{
				return '0';
			}
        }else{
			return '0';
		}

	}


	// 11 MAR 2021  JOSEPH ADORBOE
	public function generatecreditrepaymentreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$cashiertill)
	{		
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {

		$sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $day);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $billcode);
		$st->BindParam(7, $remarks);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $currentshift);
		$st->BindParam(10, $cashiertilcode);
		$st->BindParam(11, $payname);
		$st->BindParam(12, $paycode);
		$st->BindParam(13, $visitcode);
		$st->BindParam(14, $totalamount);
		$st->BindParam(15, $amountpaid);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $currentuser);
		$st->BindParam(18, $instcode);
		$st->BindParam(19, $chang);	
		$st->BindParam(20, $receiptnumber);	
		$st->BindParam(21, $paymeth);	
		$st->BindParam(22, $paymethcode);	
		$st->BindParam(23, $state);	
		$genreceipt = $st->execute();	
	
			if($genreceipt){
				$a = 5;
				$b = 3;
				$c = 2;
				$d = 1;
				$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? and B_BILLCODE = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $c);
				$st->BindParam(2, $b);
				$st->BindParam(3, $day);
				$st->BindParam(4, $form_key);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentshiftcode);
				$st->BindParam(8, $currentshift);
				$st->BindParam(9, $c);
				$st->BindParam(10, $paycode);
				$st->BindParam(11, $payname);
				$st->BindParam(12, $visitcode);
				$st->BindParam(13, $a);
				$st->BindParam(14, $billcode);
				$updtebilitems = $st->execute();
					if($updtebilitems){
						$vt = 2 ;
						$sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $currentuser);
						$st->BindParam(3, $currentusercode);
						$st->BindParam(4, $vt);
						$st->BindParam(5, $billcode);
						$updatebills = $st->execute();						
							if($updatebills){
								
									$vt = 1;
									$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $vt);
									$st->BindParam(2, $instcode);
									$recipt = $st->Execute();	
									if($recipt){
										$vt = 2;
										$paid = 3;
										$sql = "UPDATE octopus_patients_credit SET  CREDIT_AMTPAID = CREDIT_AMTPAID + ? , CREDIT_AMOUNTBAL = CREDIT_AMOUNTBAL - ? ,CREDIT_STATUS = ?  WHERE CREDIT_PATIENTCODE = ? and CREDIT_STATUS = ? ";
										$st = $this->db->prepare($sql);
										$st->BindParam(1, $totalamount);
										$st->BindParam(2, $totalamount);
										$st->BindParam(3, $paid);
										$st->BindParam(4, $patientcode);
										$st->BindParam(5, $vt);
										$recipt = $st->Execute();	
										if($recipt){
											$sede = 1;
											$sql = "UPDATE octopus_cashiertill SET  CA_CASH = CA_CASH + ? , CA_TOTALAMT = CA_TOTALAMT + ? WHERE CA_CODE = ? and CA_STATUS = ? ";
											$st = $this->db->prepare($sql);
											$st->BindParam(1, $totalamount);
											$st->BindParam(2, $totalamount);
											$st->BindParam(3, $cashiertill);
											$st->BindParam(4, $sede);
											$tills = $st->Execute();	
											if($tills){
												return '2';
											}else{
												return '0';
											}	
										}else{
											return '0';
										}	
									}else{
										return '0';
									}				
											
							}					
					}else{				
						return '0';				
					}
				}else{
					return '0';
				}
			}else{
				return '0';
			}
        }else{
			return '0';
		}

	}



	// 9 MAR 2021  JOSEPH ADORBOE
	public function generatecreditreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$cashiertilcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$cashiertill)
	{	
		// $but = 1;
		// $sqlstmt = ("SELECT REV_ID FROM octopus_patients_review where REV_PATIENTCODE = ? and REV_DATE =? and REV_STATUS = ? ");
		// $st = $this->db->prepare($sqlstmt);   
		// $st->BindParam(1, $patientcode);
		// $st->BindParam(2, $reviewdate);
		// $st->BindParam(3, $but);
		// $extp = $st->execute();
		// if($extp){
		// 	if($st->rowcount() > 0){			
		// 		return '1';				
		// 	}else{	

			$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {
                $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $day);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patientnumber);
                $st->BindParam(5, $patient);
                $st->BindParam(6, $billcode);
                $st->BindParam(7, $remarks);
                $st->BindParam(8, $currentshiftcode);
                $st->BindParam(9, $currentshift);
                $st->BindParam(10, $cashiertilcode);
                $st->BindParam(11, $payname);
                $st->BindParam(12, $paycode);
                $st->BindParam(13, $visitcode);
                $st->BindParam(14, $totalamount);
                $st->BindParam(15, $amountpaid);
                $st->BindParam(16, $currentusercode);
                $st->BindParam(17, $currentuser);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $chang);
                $st->BindParam(20, $receiptnumber);
                $st->BindParam(21, $paymeth);
                $st->BindParam(22, $paymethcode);
                $st->BindParam(23, $state);
                $genreceipt = $st->execute();
    
                if ($genreceipt) {
                    $a = 4;
                    $b = 5;
                    $c = 2;
                    $d = 1;
                    $sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? and B_BILLCODE = ? ");
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $a);
                    $st->BindParam(2, $b);
                    $st->BindParam(3, $day);
                    $st->BindParam(4, $form_key);
                    $st->BindParam(5, $currentuser);
                    $st->BindParam(6, $currentusercode);
                    $st->BindParam(7, $currentshiftcode);
                    $st->BindParam(8, $currentshift);
                    $st->BindParam(9, $d);
                    $st->BindParam(10, $paycode);
                    $st->BindParam(11, $payname);
                    $st->BindParam(12, $visitcode);
                    $st->BindParam(13, $c);
                    $st->BindParam(14, $billcode);
                    $updtebilitems = $st->execute();
                    if ($updtebilitems) {
                        $vt = 3 ;
                        $sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $form_key);
                        $st->BindParam(2, $currentuser);
                        $st->BindParam(3, $currentusercode);
                        $st->BindParam(4, $vt);
                        $st->BindParam(5, $billcode);
                        $updatebills = $st->execute();
                        if ($updatebills) {
                            $nt = 6;
                            $ntt = 5;
                            $vtg = 7;
                            $sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ?  and REQU_SHOW = ? WHERE REQU_BILLCODE = ? and REQU_STATUS = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $nt);
                            $st->BindParam(2, $vtg);
                            $st->BindParam(3, $billcode);
                            $st->BindParam(4, $ntt);
                            $servicerequest = $st->Execute();
                            if ($servicerequest) {
                                $vt = 1;
                                $sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $vt);
                                $st->BindParam(2, $instcode);
                                $recipt = $st->Execute();
                                if ($recipt) {
                                    $vt = 2;
                                    $sql = "UPDATE octopus_patients_credit SET  CREDIT_AMOUNTUSED = CREDIT_AMOUNTUSED + ? , CREDIT_AMOUNTBAL = CREDIT_AMOUNTBAL - ?  WHERE CREDIT_PATIENTCODE = ? and CREDIT_STATUS = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $totalamount);
                                    $st->BindParam(2, $totalamount);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $vt);
                                    $recipt = $st->Execute();
                                    if ($recipt) {
                                        $selected = 5;
                                        $paid = 6;
                                        $pay = 2;
                                        $sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ?  WHERE MIV_STATE = ? and MIV_BILLINGCODE = ?";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $pay);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $billcode);
                                        $labs = $st->Execute();
                                        if ($labs) {
                                            $sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ?  WHERE PRESC_STATE = ? and PRESC_BILLINGCODE = ?";
                                            $st = $this->db->prepare($sql);
                                            $st->BindParam(1, $paid);
                                            $st->BindParam(2, $pay);
                                            $st->BindParam(3, $selected);
                                            $st->BindParam(4, $billcode);
                                            $labs = $st->Execute();
                                            if ($labs) {
                                                // $cashiertill
                                                $statuee = '1';
                                                $sql = "UPDATE octopus_cashiertill SET CA_CREDIT = CA_CREDIT + ? WHERE CA_CODE = ? and CA_STATUS = ?";
                                                $st = $this->db->prepare($sql);
                                                $st->BindParam(1, $totalamount);
                                                //	$st->BindParam(2, $totalamount);
                                                $st->BindParam(2, $cashiertill);
                                                $st->BindParam(3, $statuee);
                                                $tills = $st->Execute();
                                                if ($tills) {
                                                    return '2';
                                                } else {
                                                    return '0';
                                                }
                                            } else {
                                                return '0';
                                            }
                                        } else {
                                            return '0';
                                        }
                                    } else {
                                        return '0';
                                    }
                                } else {
                                    return '0';
                                }
                            } else {
                                return '0';
                            }
                        }
                    } else {
                        return '0';
                    }
                } else {
                    return '0';
                }
            } else {
                return '0';
            }
        }else{
			return '0';
		}
	}
	
	// // 9 MAR 2021 JOSEPH ADORBOE 
	// public function getpatientactivecreditdetails($patientcode,$instcode){
	// 	$nm = 2;		
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_credit where CREDIT_INSTCODE = ? and CREDIT_PATIENTCODE = ? and CREDIT_STATUS = ?  ");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $patientcode);
	// 	$st->BindParam(3, $nm);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		if($st->rowcount() > 0){
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$results = $object['CREDIT_DATE'].'@'.$object['CREDIT_CELLINGAMOUNT'].'@'.$object['CREDIT_AMOUNTUSED'].'@'.$object['CREDIT_AMTPAID'].'@'.$object['CREDIT_AMOUNTBAL'].'@'.$object['CREDIT_DUE'].'@'.$object['CREDIT_STATUS'].'@'.$object['CREDIT_AMOUNTUSEDBAL'];
	// 			return $results;
	// 		}else{
	// 			return '1';
	// 		}
	// 	}else{
	// 		return '1';
	// 	}			
	// }	
	

	// 8 MAR 2021 JOSEPH ADORBOE 
	public function getpatientcreditdetails($patientcode,$instcode){
		$nm = 1;
		$rt = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_credit where CREDIT_INSTCODE = ? and CREDIT_PATIENTCODE = ? and ( CREDIT_STATUS = ? or CREDIT_STATUS = ? ) ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $nm);
		$st->BindParam(4, $rt);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CREDIT_DATE'].'@'.$object['CREDIT_CELLINGAMOUNT'].'@'.$object['CREDIT_AMOUNTUSED'].'@'.$object['CREDIT_AMTPAID'].'@'.$object['CREDIT_AMOUNTBAL'].'@'.$object['CREDIT_DUE'].'@'.$object['CREDIT_STATUS'].'@'.$object['CREDIT_VISITCODE'].'@'.$object['CREDIT_CODE'].'@'.$object['CREDIT_PATIENTCODE'].'@'.$object['CREDIT_PATIENT'].'@'.$object['CREDIT_PATIENTNUMBER'].'@'.$object['CREDIT_BILLCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '1';
		}
			
	}	
	

	//8 MAR 2021 JOSEPH ADORBOE	  
	public function requestcredit($form_key,$days,$patientcode,$patientnumber,$patient,$amountrequested,$visitcode,$billcode,$currentusercode,$currentuser,$instcode)
	{
		
		$but = 1;
		$sqlstmt = ("SELECT CREDIT_ID FROM octopus_patients_credit where CREDIT_PATIENTCODE = ? and CREDIT_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $but);
		$checkopentill = $st->execute();
		if($checkopentill){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$vt = '0';
				$sql = ("INSERT INTO octopus_patients_credit (CREDIT_CODE,CREDIT_DATE,CREDIT_PATIENTCODE,CREDIT_PATIENT,CREDIT_PATIENTNUMBER,CREDIT_VISITCODE,CREDIT_BILLCODE,CREDIT_AMOUNTBAL,CREDIT_CELLINGAMOUNT,CREDIT_AMOUNTUSED,CREDIT_AMTPAID,CREDIT_ACTOR,CREDIT_ACTORCODE,CREDIT_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $visitcode);
				$st->BindParam(7, $billcode);
				$st->BindParam(8, $amountrequested);
				$st->BindParam(9, $amountrequested);
				$st->BindParam(10, $vt);
				$st->BindParam(11, $vt);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
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

	
		


	// 31 JAN 2021  JOSEPH ADORBOE
	public function generatereceipt($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$payingtype,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days)
	{		
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() =='0') {
                $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS,BP_DT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $day);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patientnumber);
                $st->BindParam(5, $patient);
                $st->BindParam(6, $billcode);
                $st->BindParam(7, $remarks);
                $st->BindParam(8, $currentshiftcode);
                $st->BindParam(9, $currentshift);
                $st->BindParam(10, $cashiertillcode);
                $st->BindParam(11, $payname);
                $st->BindParam(12, $paycode);
                $st->BindParam(13, $visitcode);
                $st->BindParam(14, $totalamount);
                $st->BindParam(15, $amountpaid);
                $st->BindParam(16, $currentusercode);
                $st->BindParam(17, $currentuser);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $chang);
                $st->BindParam(20, $receiptnumber);
                $st->BindParam(21, $paymeth);
                $st->BindParam(22, $paymethcode);
                $st->BindParam(23, $state);
                $st->BindParam(24, $phonenumber);
                $st->BindParam(25, $chequenumber);
                $st->BindParam(26, $insurancebal);
                $st->BindParam(27, $bankcode);
                $st->BindParam(28, $bankname);
				$st->BindParam(29, $days);
                $genreceipt = $st->execute();
                if ($genreceipt) {
                    $a = '2';
                    $b = '3';
                    $c = '1';
                
                    $sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PAYDATE = ?, B_RECIPTNUM = ?, B_PAYACTOR = ?, B_PAYACTORCODE = ? , B_PAYSHIFTCODE = ? , B_PAYSHIFT = ?, B_COMPLETE = ?, B_PAYMETHODCODE = ?, B_PAYMETHOD = ? WHERE B_VISITCODE = ? AND B_STATE = ? ");
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $a);
                    $st->BindParam(2, $b);
                    $st->BindParam(3, $day);
                    $st->BindParam(4, $form_key);
                    $st->BindParam(5, $currentuser);
                    $st->BindParam(6, $currentusercode);
                    $st->BindParam(7, $currentshiftcode);
                    $st->BindParam(8, $currentshift);
                    $st->BindParam(9, $a);
                    $st->BindParam(10, $paycode);
                    $st->BindParam(11, $payname);
                    $st->BindParam(12, $visitcode);
                    $st->BindParam(13, $a);
                    //	$st->BindParam(14, $billcode);
                    $updtebilitems = $st->execute();
                    if ($updtebilitems) {
                        $vt = 2 ;
                        $sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $form_key);
                        $st->BindParam(2, $currentuser);
                        $st->BindParam(3, $currentusercode);
                        $st->BindParam(4, $vt);
                        $st->BindParam(5, $billcode);
                        $updatebills = $st->execute();
                        if ($updatebills) {
                            $vt = 1;
							$nut = 2;
                            $sql = "UPDATE octopus_patients_discounts SET PDS_RECEIPTCODE = ? , PDS_STATUS = ?  WHERE PDS_PATIENTCODE = ? AND  PDS_STATUS = ? AND PDS_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $nut);
							$st->BindParam(3, $patientcode);
							$st->BindParam(4, $vt);
							$st->BindParam(5, $instcode);
							$recipt = $st->Execute();

							$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $vt);
                            $st->BindParam(2, $instcode);
                            $recipt = $st->Execute();
                            if ($recipt) {
                                $selected = 2;
                                $unselected = 1;
                                $paid = 4;
                                $show = 7;
                                
                                // pay before service
                                if ($payingtype == 1) {
                                    $selected = 2;
                                    $unselected = 1;
                                    $paid = 4;
                                    $show = 7;

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                //    $st->BindParam(6, $instcode);
                                    $med = $st->Execute();
                                
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and REQU_SELECTED = ? and REQU_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
                                    $servicerequest = $st->Execute();
                                    if ($servicerequest) {
                                        $selected = 2;
                                        $unselected = 1;
                                        $paid = 4;
                                        $show = 7;
                                
                                        
                                        $sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ?  WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ?  ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $paid);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $selected);
                                        $st->BindParam(4, $visitcode);
                                        $st->BindParam(5, $unselected);
                                        $st->BindParam(6, $instcode);
                                        $labs = $st->Execute();
                                        if ($labs) {
                                            // $selected = 2;
                                            // $unselected = 1;
                                            // $paid = 4;
                                            // $show = 7;
                                            // $tp = '4';
                                            // $sp = '1';

                                            
                                            $sqlprescriptions = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? ";
                                            $st = $this->db->prepare($sqlprescriptions);
                                            $st->BindParam(1, $paid);
                                            $st->BindParam(2, $selected);
                                            $st->BindParam(3, $selected);
                                            $st->BindParam(4, $unselected);
                                            $st->BindParam(5, $visitcode);
                                            $st->BindParam(6, $unselected);
                                            $prescriptions = $st->Execute();
                                            if ($prescriptions) {
                                                $sqldevices = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_VISITCODE = ? and PD_SELECTED = ?";
                                                $st = $this->db->prepare($sqldevices);
                                                $st->BindParam(1, $paid);
                                                $st->BindParam(2, $selected);
                                                $st->BindParam(3, $selected);
                                                $st->BindParam(4, $unselected);
                                                $st->BindParam(5, $visitcode);
                                                $st->BindParam(6, $unselected);
                                                $devices = $st->Execute();
                                                if ($devices) {
                                                    $sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? ";
                                                    $st = $this->db->prepare($sqlprocedure);
                                                    $st->BindParam(1, $paid);
                                                    $st->BindParam(2, $selected);
                                                    $st->BindParam(3, $selected);
                                                    $st->BindParam(4, $unselected);
                                                    $st->BindParam(5, $visitcode);
                                                    $st->BindParam(6, $unselected);
                                                    $procedure = $st->Execute();
                                                    if ($procedure) {
                                                        //die('test');

                                                        $sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
                                                        $st = $this->db->prepare($sqlstmt);
                                                        $st->BindParam(1, $currentshiftcode);
                                                        $st->BindParam(2, $currentusercode);
                                                        $st->BindParam(3, $paycode);
                                                        $st->BindParam(4, $instcode);
                                                        $till = $st->execute();
                                                        if ($till) {
                                                            if ($st->rowcount() >'0') {
                                                                $sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
                                                                $st = $this->db->prepare($sqlstmts);
                                                                $st->BindParam(1, $totalamount);
                                                                $st->BindParam(2, $currentshiftcode);
                                                                $st->BindParam(3, $currentusercode);
                                                                $st->BindParam(4, $paycode);
                                                                $st->BindParam(5, $instcode);
                                                                $tills = $st->execute();
                                                                if ($tills) {
                                                                    $bbt = 1;
                                                                    $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
                                                                    $st = $this->db->prepare($sqlstmtsum);
                                                                    $st->BindParam(1, $currentshiftcode);
                                                                    $st->BindParam(2, $currentusercode);
                                                                    $st->BindParam(3, $instcode);
                                                                    $st->BindParam(4, $bbt);
                                                                    $cs = $st->execute();
                                                                    if ($st->rowcount() >'0') {
                                                                        $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
                                                                        $st = $this->db->prepare($sqlstmtst);
                                                                        $st->BindParam(1, $totalamount);
                                                                        $st->BindParam(2, $currentshiftcode);
                                                                        $st->BindParam(3, $currentusercode);
                                                                        $st->BindParam(4, $bbt);
                                                                        $st->BindParam(5, $instcode);
                                                                        $dt = $st->execute();
                                                                        if ($dt) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    } else {
                                                                        $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
                                                                        $st = $this->db->prepare($sql);
                                                                        $st->BindParam(1, $form_key);
                                                                        $st->BindParam(2, $day);
                                                                        $st->BindParam(3, $currentshift);
                                                                        $st->BindParam(4, $currentshiftcode);
                                                                        $st->BindParam(5, $totalamount);
                                                                        $st->BindParam(6, $currentuser);
                                                                        $st->BindParam(7, $currentusercode);
                                                                        $st->BindParam(8, $instcode);
                                                                        $opensummary = $st->execute();
                                                                        if ($opensummary) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    }
                                                                } else {
                                                                    return '0';
                                                                }
                                                            } else {
                                                                $sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                                                                $st = $this->db->prepare($sql);
                                                                $st->BindParam(1, $form_key);
                                                                $st->BindParam(2, $day);
                                                                $st->BindParam(3, $currentshift);
                                                                $st->BindParam(4, $currentshiftcode);
                                                                $st->BindParam(5, $payname);
                                                                $st->BindParam(6, $paycode);
                                                                $st->BindParam(7, $paymeth);
                                                                $st->BindParam(8, $paymethcode);
                                                                $st->BindParam(9, $totalamount);
                                                                $st->BindParam(10, $currentuser);
                                                                $st->BindParam(11, $currentusercode);
                                                                $st->BindParam(12, $instcode);
                                                                // $st->BindParam(13, $currentusercode); $,$,$,$
                                                                // $st->BindParam(14, $instcode);
                                                                $opentill = $st->execute();
                                                                if ($opentill) {
                                                                    $bbt = 1;
                                                                    $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
                                                                    $st = $this->db->prepare($sqlstmtsum);
                                                                    $st->BindParam(1, $currentshiftcode);
                                                                    $st->BindParam(2, $currentusercode);
                                                                    $st->BindParam(3, $instcode);
                                                                    $st->BindParam(4, $bbt);
                                                                    $cs = $st->execute();
                                                                    if ($st->rowcount() >'0') {
                                                                        $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
                                                                        $st = $this->db->prepare($sqlstmtst);
                                                                        $st->BindParam(1, $totalamount);
                                                                        $st->BindParam(2, $currentshiftcode);
                                                                        $st->BindParam(3, $currentusercode);
                                                                        $st->BindParam(4, $bbt);
                                                                        $st->BindParam(5, $instcode);
                                                                        $dt = $st->execute();
                                                                        if ($dt) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    } else {
                                                                        $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
                                                                        $st = $this->db->prepare($sql);
                                                                        $st->BindParam(1, $form_key);
                                                                        $st->BindParam(2, $day);
                                                                        $st->BindParam(3, $currentshift);
                                                                        $st->BindParam(4, $currentshiftcode);
                                                                        $st->BindParam(5, $totalamount);
                                                                        $st->BindParam(6, $currentuser);
                                                                        $st->BindParam(7, $currentusercode);
                                                                        $st->BindParam(8, $instcode);
                                                                        $opensummary = $st->execute();
                                                                        if ($opensummary) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    }
                                                                } else {
                                                                    return '0';
                                                                }
                                                            }
                                                        } else {
                                                            return '0';
                                                        }
                                                    } else {
                                                        return '0';
                                                    }
                                                } else {
                                                    return '0';
                                                }
                                            } else {
                                                return '0';
                                            }
                                        } else {
                                            return '0';
                                        }
                                    } else {
                                        return '0';
                                    }
                                    
                                
                                    

                                    // pay after service
                                } elseif ($payingtype == 7) {

									$sqlmed = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ?  WHERE MDR_PATIENTCODE = ? and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
                                    $st = $this->db->prepare($sqlmed);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $selected);
                                    $st->BindParam(3, $patientcode);
                                    $st->BindParam(4, $unselected);
                                    $st->BindParam(5, $instcode);
                                //    $st->BindParam(6, $instcode);
                                    $med = $st->Execute();
									
                                    $sqlservice = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? , REQU_SHOW = ? , REQU_SELECTED = ?  WHERE REQU_VISITCODE = ? and  REQU_SELECTED = ? and REQU_INSTCODE = ?  ";
                                    $st = $this->db->prepare($sqlservice);
                                    $st->BindParam(1, $selected);
                                    $st->BindParam(2, $show);
                                    $st->BindParam(3, $selected);
                                    $st->BindParam(4, $visitcode);
                                    $st->BindParam(5, $unselected);
                                    $st->BindParam(6, $instcode);
                                    $servicerequest = $st->Execute();
                                    if ($servicerequest) {
                                        $sqllabs = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_VISITCODE = ? and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
                                        $st = $this->db->prepare($sqllabs);
                                        $st->BindParam(1, $selected);
                                        $st->BindParam(2, $selected);
                                        $st->BindParam(3, $visitcode);
                                        $st->BindParam(4, $unselected);
                                        $st->BindParam(5, $instcode);
                                        $labs = $st->Execute();
                                        if ($labs) {
                                            $sqlprescriptions = "UPDATE octopus_patients_prescriptions SET  PRESC_STATUS = ? , PRESC_SELECTED = ? WHERE PRESC_VISITCODE = ? and PRESC_SELECTED = ? and PRESC_INSTCODE = ? ";
                                            $st = $this->db->prepare($sqlprescriptions);
                                            $st->BindParam(1, $selected);
                                            $st->BindParam(2, $selected);
                                            $st->BindParam(3, $visitcode);
                                            $st->BindParam(4, $unselected);
                                            $st->BindParam(5, $instcode);
                                            $prescriptions = $st->Execute();
                                            if ($prescriptions) {
                                                $sqldevices = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_SELECTED = ? WHERE PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? ";
                                                $st = $this->db->prepare($sqldevices);
                                                $st->BindParam(1, $selected);
                                                $st->BindParam(2, $selected);
                                                $st->BindParam(3, $visitcode);
                                                $st->BindParam(4, $unselected);
                                                $st->BindParam(5, $instcode);
                                                //	$st->BindParam(4, $rat);
                                                $devices = $st->Execute();
                                                if ($devices) {
                                                    $sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATUS = ? , PPD_SELECTED = ? WHERE PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_PATIENTCODE = ?";
                                                    $st = $this->db->prepare($sqlprocedure);
                                                    $st->BindParam(1, $selected);
                                                    $st->BindParam(2, $selected);
                                                    $st->BindParam(3, $visitcode);
                                                    $st->BindParam(4, $unselected);
                                                    $st->BindParam(5, $instcode);
                                                    $procedure = $st->Execute();
                                                    if ($procedure) {
                                                        $sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
                                                        $st = $this->db->prepare($sqlstmt);
                                                        $st->BindParam(1, $currentshiftcode);
                                                        $st->BindParam(2, $currentusercode);
                                                        $st->BindParam(3, $paycode);
                                                        $st->BindParam(4, $instcode);
                                                        $till = $st->execute();
                                                        if ($till) {
                                                            if ($st->rowcount() >'0') {
                                                                $sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
                                                                $st = $this->db->prepare($sqlstmts);
                                                                $st->BindParam(1, $totalamount);
                                                                $st->BindParam(2, $currentshiftcode);
                                                                $st->BindParam(3, $currentusercode);
                                                                $st->BindParam(4, $paycode);
                                                                $st->BindParam(5, $instcode);
                                                                $tills = $st->execute();
                                                                if ($tills) {
                                                                    $bbt = 1;
                                                                    $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
                                                                    $st = $this->db->prepare($sqlstmtsum);
                                                                    $st->BindParam(1, $currentshiftcode);
                                                                    $st->BindParam(2, $currentusercode);
                                                                    $st->BindParam(3, $instcode);
                                                                    $st->BindParam(4, $bbt);
                                                                    $cs = $st->execute();
                                                                    if ($st->rowcount() >'0') {
                                                                        $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
                                                                        $st = $this->db->prepare($sqlstmtst);
                                                                        $st->BindParam(1, $totalamount);
                                                                        $st->BindParam(2, $currentshiftcode);
                                                                        $st->BindParam(3, $currentusercode);
                                                                        $st->BindParam(4, $bbt);
                                                                        $st->BindParam(5, $instcode);
                                                                        $dt = $st->execute();
                                                                        if ($dt) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    } else {
                                                                        $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
                                                                        $st = $this->db->prepare($sql);
                                                                        $st->BindParam(1, $form_key);
                                                                        $st->BindParam(2, $day);
                                                                        $st->BindParam(3, $currentshift);
                                                                        $st->BindParam(4, $currentshiftcode);
                                                                        $st->BindParam(5, $totalamount);
                                                                        $st->BindParam(6, $currentuser);
                                                                        $st->BindParam(7, $currentusercode);
                                                                        $st->BindParam(8, $instcode);
                                                                        $opensummary = $st->execute();
                                                                        if ($opensummary) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    }
                                                                } else {
                                                                    return '0';
                                                                }
                                                            } else {
                                                                $sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                                                                $st = $this->db->prepare($sql);
                                                                $st->BindParam(1, $form_key);
                                                                $st->BindParam(2, $day);
                                                                $st->BindParam(3, $currentshift);
                                                                $st->BindParam(4, $currentshiftcode);
                                                                $st->BindParam(5, $payname);
                                                                $st->BindParam(6, $paycode);
                                                                $st->BindParam(7, $paymeth);
                                                                $st->BindParam(8, $paymethcode);
                                                                $st->BindParam(9, $totalamount);
                                                                $st->BindParam(10, $currentuser);
                                                                $st->BindParam(11, $currentusercode);
                                                                $st->BindParam(12, $instcode);
                                                                    
                                                                $opentill = $st->execute();
                                                                if ($opentill) {
                                                                    $bbt = 1;
                                                                    $sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
                                                                    $st = $this->db->prepare($sqlstmtsum);
                                                                    $st->BindParam(1, $currentshiftcode);
                                                                    $st->BindParam(2, $currentusercode);
                                                                    $st->BindParam(3, $instcode);
                                                                    $st->BindParam(4, $bbt);
                                                                    $cs = $st->execute();
                                                                    if ($st->rowcount() >'0') {
                                                                        $sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
                                                                        $st = $this->db->prepare($sqlstmtst);
                                                                        $st->BindParam(1, $totalamount);
                                                                        $st->BindParam(2, $currentshiftcode);
                                                                        $st->BindParam(3, $currentusercode);
                                                                        $st->BindParam(4, $bbt);
                                                                        $st->BindParam(5, $instcode);
                                                                        $dt = $st->execute();
                                                                        if ($dt) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    } else {
                                                                        $sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
                                                                        $st = $this->db->prepare($sql);
                                                                        $st->BindParam(1, $form_key);
                                                                        $st->BindParam(2, $day);
                                                                        $st->BindParam(3, $currentshift);
                                                                        $st->BindParam(4, $currentshiftcode);
                                                                        $st->BindParam(5, $totalamount);
                                                                        $st->BindParam(6, $currentuser);
                                                                        $st->BindParam(7, $currentusercode);
                                                                        $st->BindParam(8, $instcode);
                                                                        $opensummary = $st->execute();
                                                                        if ($opensummary) {
                                                                            return '2';
                                                                        } else {
                                                                            return '0';
                                                                        }
                                                                    }
                                                                } else {
                                                                    return '0';
                                                                }
                                                            }
                                                        } else {
                                                            return '0';
                                                        }
                                                    } else {
                                                        return '0';
                                                    }
                                                } else {
                                                    return '0';
                                                }
                                            } else {
                                                return '0';
                                            }
                                        } else {
                                            return '0';
                                        }
                                    } else {
                                        return '0';
                                    }
                                } else {
                                    return '0';
                                }
                            } else {
                                return '0';
                            }
                        } else {
                            return '0';
                        }
                    } else {
                        return '0';
                    }
                } else {
                    return '0';
                }
            } else {
                return '0';
            }
        }else{
			return '0';
		}
	}



	


	// // 6 MAR 2021 JOSEPH ADORBOE 
	// public function getpatientreceiptdetails($idvalue){
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ?");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $idvalue);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		if($st->rowcount() > 0){
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$results = $object['BP_VISITCODE'].'@@'.$object['BP_DT'].'@@'.$object['BP_PATIENTCODE'].'@@'.$object['BP_PATIENTNUMBER'].'@@'.$object['BP_PATIENT'].'@@'.$object['BP_TOTAL'].'@@'.$object['BP_AMTPAID'].'@@'.$object['BP_METHOD'].'@@'.$object['BP_ACTOR'].'@@'.$object['BP_BALANCE'].'@@'.$object['BP_SHIFT'].'@@'.$object['BP_SCHEME'].'@@'.$object['BP_STATE'].'@@'.$object['BP_RECIEPTNUMBER'].'@@'.$object['BP_PHONENUMBER'].'@@'.$object['BP_CHEQUENUMBER'].'@@'.$object['BP_INSURANCEBAL'].'@@'.$object['BP_BANKS'].'@@'.$object['BP_METHODCODE'].'@@'.$object['BP_CHANGE'].'@@'.$object['BP_BILLINGCODE'].'@@'.$object['BP_DESC'].'@@'.$object['BP_SHIFTCODE'];
	// 			return $results;
	// 		}else{
	// 			return $this->theexisted;
	// 		}

	// 	}else{
	// 		return $this->thefailed;
	// 	}
			
	// }	
	
	// 6 JUNE 2020 INSERT PATIENT EMERGENCY CONTACT
	public function insertnewbills($billcode,$days,$patientcode,$patientnumber,$visitcode,$patient,$currentuser,$currentusercode,$instcode)
	{		
		$sql = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_DATE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?)";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $billcode);
		$st->BindParam(2, $days);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $instcode);
		$addbills = $st->Execute();
		if($addbills){
			return '2';
		}else{
			return '0';
		}		
	}

	
	// 31 JAN 2021 
	public function cashierunselectedtransactions($bcode,$billcode,$billingcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type){
		
		//die($billingcode);
		$but = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? and B_INSTCODE = ? and B_VISITCODE = ? AND  B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$unselect = $st->execute();
		if($unselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$selected = 2;
				$unselected = 1;
				$retvial = 0;
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? WHERE B_CODE = ? and B_VISITCODE = ? AND B_INSTCODE = ? AND  B_STATE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $unselected);
				$st->BindParam(2, $bcode);
				$st->BindParam(3, $visitcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $selected);
				$billitems = $st->Execute();	

				$ut = 1;
				$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT - ?, BG_AMOUNTBAL = BG_AMOUNTBAL - ?  WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $amt);
				$st->BindParam(2, $amt);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $ut);
				$st->BindParam(7, $type);
				$selectitem = $st->Execute();

					if($billitems){
						$selected = 1;
						$unselected = '0';					
						if($dpts == 'SERVICES'){
							
							$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SELECTED = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? AND REQU_INSTCODE = ? and REQU_SELECTED = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $unselected);
							$st->BindParam(2, $servicecode);
							$st->BindParam(3, $visitcode);
							$st->BindParam(4, $instcode);
							$st->BindParam(5, $selected);
							$selectitem = $st->Execute();				
								if($selectitem){						
									return '2' ;						
								}else{						
									return '0' ;						
								}
							}else if($dpts == 'LABS'){								
								$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $unselected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $instcode);
								$st->BindParam(5, $selected);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}
								}else if($dpts == 'IMAGING'){								
									$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $unselected);
									$st->BindParam(2, $servicecode);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $instcode);
									$st->BindParam(5, $selected);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
								
							}else if($dpts == 'PHARMACY'){									
									$sql = "UPDATE octopus_patients_prescriptions SET PRESC_SELECTED = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $unselected);
									$st->BindParam(2, $servicecode);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $instcode);
									$st->BindParam(5, $selected);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0';						
										}

							}else if($dpts == 'DEVICES'){

								$sql = "UPDATE octopus_patients_devices SET PD_SELECTED = ? WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $unselected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $instcode);
								$st->BindParam(5, $selected);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0';						
									}

							}else if($dpts == 'PROCEDURE'){

								$sql = "UPDATE octopus_patients_procedures SET PPD_SELECTED = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $unselected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $instcode);
								$st->BindParam(5, $selected);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'MEDREPORTS'){

									$sql = "UPDATE octopus_patients_medicalreports SET MDR_SELECTED = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $unselected);
									$st->BindParam(2, $servicecode);
								//	$st->BindParam(3, $visitcode);
									$st->BindParam(3, $selected);
									$st->BindParam(4, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
							}else{
								return '1';
							}	

											
					}else{						
						return '0' ;						
					}
				}			
			}else{			
				return '0' ;			
			}	
	}
	

	// 31 JAN 2021 JOSEPH ADORBOE 
	public function cashierselectedtransactions($bcode,$billgeneratedcode,$amt,$servicecode,$dpts,$visitcode,$instcode,$type){		
		$but = 2;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? AND B_STATE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $but);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				return '1';				
			}else{
				$nt = 2;
				
				$sql = "UPDATE octopus_patients_billitems SET B_STATE = ? , B_BILLGENERATEDCODE = ? WHERE B_CODE = ? AND B_INSTCODE = ? AND B_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nt);
				$st->BindParam(2, $billgeneratedcode);
				$st->BindParam(3, $bcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$selectitem = $st->Execute();
				
				
				$ut = 1;
				$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT + ?, BG_AMOUNTBAL = BG_AMOUNTBAL + ? WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $amt);
				$st->BindParam(2, $amt);
				$st->BindParam(3, $billgeneratedcode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $ut);
				$st->BindParam(7, $type);
				$selectitem = $st->Execute();
					if($selectitem){
							$selected = 1;
							$unselected = '0';
							if($dpts == 'SERVICES'){				
								
								$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SELECTED = ? WHERE REQU_CODE = ? and REQU_VISITCODE = ? and REQU_SELECTED = ?  and REQU_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $unselected);
								$st->BindParam(5, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'LABS'){
								
								$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $unselected);
								$st->BindParam(5, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}
							}else if($dpts == 'IMAGING'){
								
									$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ?  and MIV_SELECTED = ? AND MIV_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $servicecode);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}
								
							}else if($dpts == 'PHARMACY'){

								$sql = "UPDATE octopus_patients_prescriptions SET PRESC_SELECTED = ? WHERE PRESC_CODE = ? AND PRESC_VISITCODE = ? and PRESC_SELECTED = ? AND PRESC_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $selected);
								$st->BindParam(2, $servicecode);
								$st->BindParam(3, $visitcode);
								$st->BindParam(4, $unselected);
								$st->BindParam(5, $instcode);
								$selectitem = $st->Execute();				
									if($selectitem){						
										return '2' ;						
									}else{						
										return '0' ;						
									}

							}else if($dpts == 'DEVICES'){

									$sql = "UPDATE octopus_patients_devices SET PD_SELECTED = ? WHERE PD_CODE = ? and PD_VISITCODE = ? and PD_SELECTED = ? and PD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $servicecode);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}

								}else if($dpts == 'PROCEDURE'){

									$sql = "UPDATE octopus_patients_procedures SET PPD_SELECTED = ? WHERE PPD_CODE = ? and PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_INSTCODE = ? ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $selected);
									$st->BindParam(2, $servicecode);
									$st->BindParam(3, $visitcode);
									$st->BindParam(4, $unselected);
									$st->BindParam(5, $instcode);
									$selectitem = $st->Execute();				
										if($selectitem){						
											return '2' ;						
										}else{						
											return '0' ;						
										}

								}else if($dpts == 'MEDREPORTS'){

										$sql = "UPDATE octopus_patients_medicalreports SET MDR_SELECTED = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
										$st = $this->db->prepare($sql);
										$st->BindParam(1, $selected);
										$st->BindParam(2, $servicecode);
										$st->BindParam(3, $unselected);
										$st->BindParam(4, $instcode);
										$selectitem = $st->Execute();				
											if($selectitem){						
												return '2' ;						
											}else{						
												return '0' ;						
											}
							}else{
								return '1';
							}					
												
					}else{						
						return '0' ;						
					}
				}			
		}else{			
			return '0' ;			
		}	
	}


	
	// 3MAR 2021 JOSEPH ADORBOE	  
	public function setprice($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$currentuser,$currentusercode,$instcode)
	{		
		$but = 1;
		$cate = '*';
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and PS_PAYMENTMETHODCODE = ? and PS_PAYSCHEMECODE =? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $methodcode);
		$st->BindParam(3, $schemcode);
		$st->BindParam(4, $but);
		$checkprice = $st->execute();
		if($checkprice){
			if($st->rowcount() > 0){			
					$sqlstmt = "UPDATE octopus_patients_billitems SET B_COST = ?, B_TOTAMT = ?  WHERE B_CODE = ? ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $itemprice);
					$st->BindParam(2, $itemprice);
					$st->BindParam(3, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						return '2';
					}else{
						return '0';
					}
				
			}else{	
		
				$sql = ("INSERT INTO octopus_st_pricing (PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHODCODE,PS_PAYMENTMETHOD,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $cate);
				$st->BindParam(3, $itemcode);
				$st->BindParam(4, $item);
				$st->BindParam(5, $itemprice);
				$st->BindParam(6, $methodcode);
				$st->BindParam(7, $method);
				$st->BindParam(8, $schemcode);
				$st->BindParam(9, $schemename);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $instcode);
				$setprice = $st->execute();				
				if($setprice){					
					$sqlstmt = "UPDATE octopus_patients_billitems SET B_COST = ?, B_TOTAMT =? , B_CASHAMT = ?  WHERE B_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $itemprice);
					$st->BindParam(2, $itemprice);
					$st->BindParam(3, $itemprice);
					$st->BindParam(4, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						return '2';
					}else{
						return '0';
					}

				}else{					
					return '0';					
				}
			}
		}else{			
			return '0';			
		}	
	}

	// 3 MAR 2021 JOSEPH ADORBOE  transactioncode
	public function gettransactiondetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_ITEM'].'@'.$object['B_ITEMCODE'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_METHOD'].'@'.$object['B_METHODCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}

	// 27 FEB 2021 JOSEPH ADORBOE
	public function patientbillitems($visitcode,$instcode){
		$sql = ("SELECT * from octopus_patients_billitems where B_INSTCODE = ? and  B_VISITCODE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $visitcode);
		$total = $st->execute();
	}

	// 27 FEB 2021 JOSEPH ADORBOE
	public function getpatientinsurancetotal($visitcode,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){
		$rty = 2;
		$sql = ("SELECT SUM(B_TOTAMT) FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATE = ? AND B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode')");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(B_TOTAMT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}
	
	
	
	// 27 FEB 2021 JOSEPH ADORBOE
	public function getpatientcredittotal($visitcode){
		$rty = 5;
		$sql = ("SELECT SUM(B_TOTAMT) FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(B_TOTAMT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}
	
	// 


	//27 FEB 2021 JOSEPH ADORBOE	  
	public function opencashiertills($form_key,$day,$currentshiftcode,$currentshift,$days,$currentuser,$currentusercode,$instcode)
	{
		
		$but = 1;
		$sqlstmt = ("SELECT CA_ID FROM octopus_cashiertill where CA_CASHIERCODE = ? and CA_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $but);
		$checkopentill = $st->execute();
		if($checkopentill){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
		
				$sql = ("INSERT INTO octopus_cashiertill (CA_CODE,CA_DT,CA_SHIFT,CA_SHIFTCODE,CA_OPENTIME,CA_CASHIERCODE,CA_CASHIER,CA_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $currentshift);
				$st->BindParam(4, $currentshiftcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $instcode);
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


	// // 31 JAN 2021
	// public function getcashiertilldetails($currentusercode,$currentshiftcode,$instcode){
	// 	$closestatus = 2;
	// 	$openstatus = 1;
	// 	$sqlstmt = "UPDATE octopus_cashiertill SET CA_STATUS = ? WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE != ? and CA_STATUS = ? ";
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $closestatus);
	// 	$st->BindParam(2, $currentusercode);
	// 	$st->BindParam(3, $currentshiftcode);
	// 	$st->BindParam(4, $openstatus);
	// 	$closetill = $st->execute();
	// 	if($closetill){

	// 		$sql = 'SELECT * FROM octopus_cashiertill WHERE CA_CASHIERCODE = ? and CA_SHIFTCODE = ? and CA_STATUS = ? and CA_INSTCODE = ?';
	// 		$st = $this->db->prepare($sql);
	// 		$st->BindParam(1, $currentusercode);
	// 		$st->BindParam(2, $currentshiftcode);
	// 		$st->BindParam(3, $openstatus);
	// 		$st->BindParam(4, $instcode);
	// 		$tilldetails = $st->execute();
	// 		if($tilldetails){
	// 			if($st->rowcount() > 0){			
	// 				$object = $st->fetch(PDO::FETCH_ASSOC);
	// 				$results = $object['CA_CODE'];			
	// 				return $results;					
	// 			}else{
	// 					return '1';
	// 			}

	// 		}else{
	// 			return '0';
	// 		}
	// 	}else{
	// 		return '0';
	// 	}		
		
	// }
				

	// 27 FEB 2021 JOSEPH ADORBOE	  
	public function setcashiertill($form_key,$cascode,$casname,$momcode,$momname,$cqcode,$cqname,$day,$currentusercode,$currentuser,$instcode)
	{
		$but = 1;
		$sqlstmt = ("SELECT TILL_ID FROM octopus_admin_till where TILL_INSTCODE = ? and TILL_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $but);
		$selecttill = $st->execute();
		if($selecttill){
			if($st->rowcount() > 0){			
				return '1';				
			}else{			
				$sql = ("INSERT INTO octopus_admin_till (TILL_CODE,TILL_DATE,TILL_CASHCODE,TILL_CASH,TILL_MOMOCODE,TILL_MOMO,TILL_CHEQUECODE,TILL_CHEQUE,TILL_ACTORCODE,TILL_ACTOR,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $cascode);
				$st->BindParam(4, $casname);
				$st->BindParam(5, $momcode);
				$st->BindParam(6, $momname);
				$st->BindParam(7, $cqcode);
				$st->BindParam(8, $cqname);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $instcode);
				$exe = $st->execute();				
				if($exe){					
					return '2';					
				}else{					
					return '0';					
				}
			}
		}else{			
			return '0';			
		}		
	}


	// 27 FEB 2021 
	public function getinstitutionsettill($instcode)
	{
		$statu = 1;
		$sql = 'SELECT * FROM octopus_admin_till WHERE TILL_INSTCODE = ? and TILL_STATUS = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $statu);
		$till = $st->execute();
		if($till){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$results = $obj['TILL_CASHCODE'].'@'.$obj['TILL_CASH'].'@'.$obj['TILL_MOMOCODE'].'@'.$obj['TILL_MOMO'].'@'.$obj['TILL_CHEQUECODE'].'@'.$obj['TILL_CHEQUE'];			
				return $results;					
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	
	}	

	// 27 FEB 2021 JOSEPH ADORBOE 
	// public function getpatienttransactiondetails($idvalue,$mobilemoneypaymentmethodcode,$cashpaymentmethodcode,$prepaidcode){
	// 	$sqlstmt = ("SELECT DISTINCT B_VISITCODE,B_DT,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_DPT,B_BILLCODE,B_METHOD,B_METHODCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_SHIFTCODE,B_SHIFT FROM octopus_patients_billitems where B_VISITCODE = ? and B_STATUS IN('1','4') and B_METHODCODE IN('$mobilemoneypaymentmethodcode','$cashpaymentmethodcode','$prepaidcode') ");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $idvalue);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		if($st->rowcount() > 0){
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$results = $object['B_VISITCODE'].'@'.$object['B_DT'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DPT'].'@'.$object['B_BILLCODE'].'@'.$object['B_METHOD'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PAYSCHEMECODE'].'@'.$object['B_PAYMENTTYPE'].'@'.$object['B_DAY'].'@'.$object['B_MONTH'].'@'.$object['B_YEAR'].'@'.$object['B_SHIFTCODE'].'@'.$object['B_SHIFT'];
	// 			return $results;
	// 		}else{
	// 			return $this->theexisted;
	// 		}
	// 	}else{
	// 		return $this->thefailed;
	// 	}			
	// }	
	
} 
?>