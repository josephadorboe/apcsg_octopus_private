<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 31 MAY 2025, JOSEPH ADORBOE 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	$investigationcontroller->investigationsendtopayment($billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller);
*/

class PatientInvestigationControllerClass Extends Engine{ 

	// 31 MAY 2025, 04 APR 2021 , JOSEPH ADORBOE	  
	public function investigationsendtopayment($billingcode,$visitcode,$bcode,$billcode,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller,$gender,$age)
	{
		$nut = 2;
		$rat = 0;
		
		$sqlstmt = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE  MIV_CODE = ? AND MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $this->thetwo);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() >$this->thefailed){
				return $this->theexisted;
			}else{
		
				$qty = 1 ;
		if ($schemepricepercentage < 100) {
			$schemeamount = ($cost*$schemepricepercentage)/100;
			$patientamount = $cost - $schemeamount ;
			$rtn = 1;
			$cash = 'CASH';

			$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER,B_AGE,B_GENDER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $billingcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $bcode);
			$st->BindParam(4, $billcode);
			$st->BindParam(5, $this->theday);
			$st->BindParam(6, $this->thedays);
			$st->BindParam(7, $patientcode);
			$st->BindParam(8, $patientnumber);
			$st->BindParam(9, $patient);
			$st->BindParam(10, $serviceitem);
			$st->BindParam(11, $servicescode);
			$st->BindParam(12, $paymentmethodcode);
			$st->BindParam(13, $paymentmethod);
			$st->BindParam(14, $paymentschemecode);
			$st->BindParam(15, $paymentscheme);
			$st->BindParam(16, $qty);
			$st->BindParam(17, $schemeamount);
			$st->BindParam(18, $schemeamount);
			$st->BindParam(19, $schemeamount);
			$st->BindParam(20, $instcode);
			$st->BindParam(21, $depts);
			$st->BindParam(22, $currentusercode);
			$st->BindParam(23, $currentuser);
			$st->BindParam(24, $currentshiftcode);
			$st->BindParam(25, $currentshift);
			$st->BindParam(26, $patientpaymenttype);
			$st->BindParam(27, $currentday);
			$st->BindParam(28, $currentmonth);
			$st->BindParam(29, $currentyear);
			$st->BindParam(30, $billercode);
			$st->BindParam(31, $biller);
			$st->BindParam(32, $age);
			$st->BindParam(33, $gender);
			$newbill = $st->execute();

			
			$formkey = md5(microtime());
			$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER,B_AGE,B_GENDER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $formkey);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $bcode);
			$st->BindParam(4, $billcode);
			$st->BindParam(5, $this->theday);
			$st->BindParam(6, $this->thedays);
			$st->BindParam(7, $patientcode);
			$st->BindParam(8, $patientnumber);
			$st->BindParam(9, $patient);
			$st->BindParam(10, $serviceitem);
			$st->BindParam(11, $servicescode);
			$st->BindParam(12, $cashpaymentmethodcode);
			$st->BindParam(13, $cashpaymentmethod);
			$st->BindParam(14, $cashschemecode);
			$st->BindParam(15, $cash);
			$st->BindParam(16, $qty);
			$st->BindParam(17, $patientamount);
			$st->BindParam(18, $patientamount);
			$st->BindParam(19, $patientamount);
			$st->BindParam(20, $instcode);
			$st->BindParam(21, $depts);
			$st->BindParam(22, $currentusercode);
			$st->BindParam(23, $currentuser);
			$st->BindParam(24, $currentshiftcode);
			$st->BindParam(25, $currentshift);
			$st->BindParam(26, $patientpaymenttype);
			$st->BindParam(27, $currentday);
			$st->BindParam(28, $currentmonth);
			$st->BindParam(29, $currentyear);
			$st->BindParam(30, $billercode);
			$st->BindParam(31, $biller);
			$st->BindParam(32, $age);
			$st->BindParam(33, $gender);
			$newbill = $st->execute();
			// if($sche && $sch){
			// 	return $this->thepassed ;	
			// }else{
			// 	return $this->thefailed ;	
			// }


		}else{
			$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER,B_AGE,B_GENDER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $billingcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $bcode);
			$st->BindParam(4, $billcode);
			$st->BindParam(5, $this->theday);
			$st->BindParam(6, $this->thedays);
			$st->BindParam(7, $patientcode);
			$st->BindParam(8, $patientnumber);
			$st->BindParam(9, $patient);
			$st->BindParam(10, $serviceitem);
			$st->BindParam(11, $servicescode);
			$st->BindParam(12, $paymentmethodcode);
			$st->BindParam(13, $paymentmethod);
			$st->BindParam(14, $paymentschemecode);
			$st->BindParam(15, $paymentscheme);
			$st->BindParam(16, $qty);
			$st->BindParam(17, $cost);
			$st->BindParam(18, $cost);
			$st->BindParam(19, $cost);
			$st->BindParam(20, $instcode);
			$st->BindParam(21, $depts);
			$st->BindParam(22, $currentusercode);
			$st->BindParam(23, $currentuser);
			$st->BindParam(24, $currentshiftcode);
			$st->BindParam(25, $currentshift);
			$st->BindParam(26, $patientpaymenttype);
			$st->BindParam(27, $currentday);
			$st->BindParam(28, $currentmonth);
			$st->BindParam(29, $currentyear);
			$st->BindParam(30, $billercode);
			$st->BindParam(31, $biller);
			$st->BindParam(32, $age);
			$st->BindParam(33, $gender);
			$newbill = $st->execute();
			// if($newbil){
			// 	return $this->thepassed ;	
			// }else{
			// 	return $this->thefailed ;	
			// }
		}			
		if($newbill){			
			$sqlstmt = "UPDATE octopus_patients_bills SET BILL_AMOUNT = BILL_AMOUNT + ?  WHERE BILL_CODE = ?";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $cost);
			$st->BindParam(2, $billcode);
			$setbills = $st->execute();
			if($setbills){
				if($patientpaymenttype == $this->theseven){		
					$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_BILLINGCODE = ? , MIV_STATUS = ? WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $this->thenine);
					$st->BindParam(2, $billcode);
					$st->BindParam(3, $this->thethree);
					$st->BindParam(4, $bcode);
					$st->BindParam(5, $this->thetwo);
					$setbills = $st->execute();
					if($setbills){				
						return $this->thepassed;
					}else{
						return $this->thefailed;
					}

				}else if($patientpaymenttype == $this->theone){
					$frt = 3;
					$nut = 2;				
					$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_BILLINGCODE = ? WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $this->thethree);
					$st->BindParam(2, $billcode);
					$st->BindParam(3, $bcode);
					$st->BindParam(4, $this->thetwo);
					$setbills = $st->execute();
					if($setbills){				
						return $this->thepassed;
					}else{
						return $this->thefailed;
					}
				}else{
					return $this->thepassed;
				}
		
			}else{
				return $this->thefailed;
			}

		}else{					
			return $this->thefailed;					
		}
				
		}	
		}else{					
			return $this->thefailed;					
		}	
	}

	
	
} 
$patientinvestigationcontroller =  new PatientInvestigationControllerClass() ;
?>