<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 10 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class cashierWalletController Extends Engine
{

	// 15 JUNE 2022  JOSEPH ADORBOE
	public function generatewalletreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid,$billingpaymentcode,$currentday,$currentmonth,$currentyear)
	{
        $one = 1;
		$na = 'NA';
		$bal = '0';
        $sqlstmt = ("SELECT * FROM octopus_patients_reciept WHERE BP_CODE = ? AND BP_INSTCODE = ?");
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
                $st->BindParam(6, $form_key);
                $st->BindParam(7, $descriptions);
                $st->BindParam(8, $currentshiftcode);
                $st->BindParam(9, $currentshift);
                $st->BindParam(10, $cashiertillcode);
                $st->BindParam(11, $payname);
                $st->BindParam(12, $paycode);
                $st->BindParam(13, $form_key);
                $st->BindParam(14, $amountpaid);
                $st->BindParam(15, $amountpaid);
                $st->BindParam(16, $currentusercode);
                $st->BindParam(17, $currentuser);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $chang);
                $st->BindParam(20, $receiptnumber);
                $st->BindParam(21, $paymeth);
                $st->BindParam(22, $paymethcode);
                $st->BindParam(23, $state);
                $st->BindParam(24, $$phonenumber);
                $st->BindParam(25, $na);
                $st->BindParam(26, $na);
                $st->BindParam(27, $na);
                $st->BindParam(28, $na);
                $st->BindParam(29, $days);
				$st->BindParam(30, $billingpaymentcode);
                $genreceipt = $st->execute();
                if ($genreceipt) {
					$sql = "UPDATE octopus_current SET CU_RECEIPTNUMBER = CU_RECEIPTNUMBER + ?  WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $one);
					$st->BindParam(2, $instcode);
					$recipt = $st->Execute();

					$sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE,BPT_RECEIPTNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $billingpaymentcode);
					$st->BindParam(4, $day);
					$st->BindParam(5, $days);
					$st->BindParam(6, $patientcode);
					$st->BindParam(7, $patientnumber);
					$st->BindParam(8, $patient);
					$st->BindParam(9, $paycode);
					$st->BindParam(10, $payname);
					$st->BindParam(11, $paymeth);
					$st->BindParam(12, $paymethcode);
					$st->BindParam(13, $amountpaid);
					$st->BindParam(14, $amountpaid);
					$st->BindParam(15, $bal);
					$st->BindParam(16, $instcode);
					$st->BindParam(17, $currentusercode);
					$st->BindParam(18, $currentuser);
					$st->BindParam(19, $currentshiftcode);
					$st->BindParam(20, $currentshift);
					$st->BindParam(21, $currentday);
					$st->BindParam(22, $currentmonth);
					$st->BindParam(23, $currentyear); 
					$st->BindParam(24, $phonenumber);
					$st->BindParam(25, $na);
					$st->BindParam(26, $na);
					$st->BindParam(27, $na);
					$st->BindParam(28, $cashiertillcode);
					$st->BindParam(29, $receiptnumber);
					$recipt = $st->Execute();

                    $sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
                    $st = $this->db->prepare($sqlstmt);
                    $st->BindParam(1, $patientcode);
                    $st->BindParam(2, $instcode);
                    $st->BindParam(3, $prepaidchemecode);
                    $st->BindParam(4, $one);
                    $dt =	$st->execute();
                    if ($dt) {
                        if ($st->rowcount() >'0') {
							// update account
							$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $amountpaid);
							$st->BindParam(2, $patientcode);
							$st->BindParam(3, $prepaidchemecode);
							$st->BindParam(4, $instcode);
							$st->BindParam(5, $one);
							$ext = $st->execute();
							if($ext){
								return '2';
							}else{
								return '0';
							}							

                        }else{
							// insert noe accountt
							$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $form_key);
							$st->BindParam(2, $patientcode);
							$st->BindParam(3, $patientnumber);
							$st->BindParam(4, $patient);
							$st->BindParam(5, $day);
							$st->BindParam(6, $prepaidcode);
							$st->BindParam(7, $prepaid);
							$st->BindParam(8, $prepaidchemecode);
							$st->BindParam(9, $prepaidscheme);
							$st->BindParam(10, $amountpaid);
							$st->BindParam(11, $na);
							$st->BindParam(12, $instcode);
							$st->BindParam(13, $currentuser);
							$st->BindParam(14, $currentusercode);
							$ext = $st->execute();
							if($ext){
								return '2';
							}else{
								return '0';
							}

						}

                    } else {
                        return '0';
                    }
                }
            }else{
				return '0';
			}
        } else {
            return '0';
        }
    }

	// 15 JUNE 2022 JOSEPH ADORBOE 
	public function cashierwallettillsoperations($form_key,$day, $currentshift,$currentusercode,$paycode,$payname,$paymethcode,$paymeth,$amountpaid,$currentuser,$currentshiftcode,$instcode){

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
				$st->BindParam(1, $amountpaid);
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
						$st->BindParam(1, $amountpaid);
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
						$st->BindParam(5, $amountpaid);
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
				$st->BindParam(9, $amountpaid);
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
						$st->BindParam(1, $amountpaid);
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
						$st->BindParam(5, $amountpaid);
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
	
	}


                                
} 
?>