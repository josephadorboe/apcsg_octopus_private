<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023
	PURPOSE: TO OPERATE MYSQL QUERY	
	Based on octopus_patients_billingpayments
	$patientbillingpaymenttable->querygetprintreceiptbillpayment($billingcode,$instcode)
	= new OctopusPatientsBillingPaymentSql();
*/

class OctopusPatientsBillingPaymentSql Extends Engine{
	
	//  20 JUNE 2025, JOSEPH ADORBOE 
	public function querygetprintreceiptbillpayment($billingcode,$instcode){
		$list =  ("SELECT BPT_PAYSCHEME,BPT_AMOUNTPAID from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' and BPT_STATUS = '1' AND BPT_INSTCODE = '$instcode' order by BPT_ID DESC  ");
		return $list;
	}

	//  20 JUNE 2025, JOSEPH ADORBOE 
	public function querygetcashbillpayment($billingcode,$visitcode,$instcode){
		$list =  ("SELECT BPT_CODE,BPT_DATETIME,BPT_METHOD,BPT_PAYSCHEME,BPT_TOTALAMOUNT,BPT_AMOUNTPAID,BPT_TOTALBAL,BPT_SHIFTCODE,BPT_VISITCODE,BPT_PAYSCHEMECODE,BPT_BILLINGCODE,BPT_METHODCODE,BPT_PATIENTCODE  from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' AND BPT_VISITCODE = '$visitcode' AND BPT_STATUS = '1' AND BPT_INSTCODE = '$instcode' order by BPT_ID DESC ");
		return $list;
	}
	// 21 APR 2025, JOSEPH ADORBOE 
	public function queryreceiptpayment($billingcode,$instcode){
		$list =  ("SELECT BPT_PAYSCHEME,BPT_AMOUNTPAID from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' and BPT_STATUS = '1' AND BPT_INSTCODE = '$instcode' order by BPT_ID DESC  ");
		return $list;
	}
	// 7 SEPT 2023 JOSEPH ADORBOE
	public function querypaymenttransactions($billingcode,$instcode){
		$list = ("SELECT * from octopus_patients_billingpayments where BPT_BILLINGCODE = '$billingcode' and BPT_STATUS = '1' AND BPT_INSTCODE = '$instcode' order by BPT_ID DESC");
		return $list;
	}
	// 12 SEPT 2023,  15 JUNE 2022  JOSEPH ADORBOE
	public function walletdepositbillspayments($form_key,$day,$visitcode,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$cashiertillcode,$days,$billingpaymentcode,$currentday,$currentmonth,$currentyear) : Int
	{
        $one = 1;
		$na = 'NA';
		$bal = '0';
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
		if($recipt){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}        
    }
	// 29 AUG 2023 
	public function updatebillingpaymentreceipt($receiptnumber,$billingcode,$instcode)
	{	
		$sql = "UPDATE octopus_patients_billingpayments SET BPT_RECEIPTNUMBER = ? WHERE BPT_BILLINGCODE = ? AND  BPT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $receiptnumber);
		$st->BindParam(2, $billingcode);
		$st->BindParam(3, $instcode);						
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}	
	}
	// 29 AUG 2023 
	public function setbillingpayments($form_key,$billingcode,$day,$patientcode,$patientnumber,$patient,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamountbal,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$bankname,$bankcode,$cashiertillcode,$receiptnumber,$days,$currentday,$currentmonth,$currentyear){
		$one = 1;
		$sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE,BPT_RECEIPTNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $billingcode);
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
		$st->BindParam(14, $totalgeneratedamountbal);
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
		$st->BindParam(25, $chequenumber);
		$st->BindParam(26, $bankcode);
		$st->BindParam(27, $bankname);
		$st->BindParam(28, $cashiertillcode);
		$st->BindParam(29, $receiptnumber);
		$selectitem = $st->Execute();
		if($selectitem){
			return '2';
		}else{
			return '0';
		}	
	}

	// 29 AUG 2023 
	public function setbillingpaymentsinsurance($form_key,$billingcode,$transactiondate,$patientcode,$patientnumber,$patient,$visitcode,$transactionshift,$transactionshiftcode,$amountpaid,$totalamount,$bal,$currentusercode,$currentuser,$instcode,$paycode,$payname,$paymethcode,$paymeth,$phonenumber,$chequenumber,$insurancetillcode,$receiptnumber,$days,$transactionday,$transactionmonth,$transactionyear){
	$na = 'NA';
	$sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE,BPT_RECEIPTNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $form_key);
            $st->BindParam(2, $visitcode);
            $st->BindParam(3, $billingcode);
            $st->BindParam(4, $transactiondate);
            $st->BindParam(5, $days);
            $st->BindParam(6, $patientcode);
            $st->BindParam(7, $patientnumber);
            $st->BindParam(8, $patient);
            $st->BindParam(9, $paycode);
            $st->BindParam(10, $payname);
            $st->BindParam(11, $paymeth);
            $st->BindParam(12, $paymethcode);
            $st->BindParam(13, $amountpaid);
            $st->BindParam(14, $totalamount);
            $st->BindParam(15, $bal);
            $st->BindParam(16, $instcode);
            $st->BindParam(17, $currentusercode);
            $st->BindParam(18, $currentuser);
            $st->BindParam(19, $transactionshiftcode);
            $st->BindParam(20, $transactionshift);
            $st->BindParam(21, $transactionday);
            $st->BindParam(22, $transactionmonth);
            $st->BindParam(23, $transactionyear);
            $st->BindParam(24, $phonenumber);
            $st->BindParam(25, $chequenumber);
            $st->BindParam(26, $na);
            $st->BindParam(27, $na);
            $st->BindParam(28, $insurancetillcode);
			$st->BindParam(29, $receiptnumber);			
			$selectitem = $st->Execute();
			if($selectitem){
				return '2';
			}else{
				return '0';
			}	
}
	
		
} 
$patientbillingpaymenttable = new OctopusPatientsBillingPaymentSql();
?>