<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_patients_reciept	
	$patientreceipttable->querygetprintreceiptdetails();
	 = new OctopusPatientsReceiptSql();
*/

class OctopusPatientsReceiptSql Extends Engine{

	// 22 JUNE 2025 , JOSEPH ADORBOE 
	public function getprintpatientreceiptdetails($idvalue){
		$sqlstmt = ("SELECT BP_CODE,BP_AMTPAID,BP_PATIENT,BP_CHANGE,BP_TOTAL,BP_DT,BP_ACTOR,BP_RECIEPTNUMBER,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_METHOD,BP_SCHEME,BP_BANKS,BP_METHODCODE,BP_BILLINGCODE FROM octopus_patients_reciept where BP_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['BP_CODE'].'@@'.$object['BP_AMTPAID'].'@@'.$object['BP_PATIENT'].'@@'.$object['BP_CHANGE'].'@@'.$object['BP_TOTAL'].'@@'.$object['BP_DT'].'@@'.$object['BP_ACTOR'].'@@'.$object['BP_RECIEPTNUMBER'].'@@'.$object['BP_PHONENUMBER'].'@@'.$object['BP_CHEQUENUMBER'].'@@'.$object['BP_INSURANCEBAL'].'@@'.$object['BP_METHOD'].'@@'.$object['BP_SCHEME'].'@@'.$object['BP_BANKS'].'@@'.$object['BP_METHODCODE'].'@@'.$object['BP_BILLINGCODE'];
				return $results;
			}else{
				return $this->theexisted;
			}

		}else{
			return $this->thefailed;
		}
	}

	// 22 JUNE 2025, JOSEPH ADORBOE 
	public function querygetprintreceiptdetails() : String {
		$list = "SELECT  BP_CODE,BP_AMTPAID,BP_PATIENT,BP_CHANGE,BP_TOTAL,BP_DT,BP_ACTOR,BP_RECIEPTNUMBER,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_METHOD,BP_SCHEME,BP_BANKS,BP_METHODCODE,BP_BILLINGCODE from octopus_patients_reciept where BP_CODE = ?";     
		return $list;
	}
	// 21 APR 2025, JOSEPH ADORBOE 
	public function querygetdashboardreceipt($instcode){
		$list = ("SELECT BP_RECIEPTNUMBER,BP_DT,BP_PATIENTNUMBER,BP_PATIENT,BP_SCHEME,BP_TOTAL from octopus_patients_reciept where BP_STATUS = '1' and BP_INSTCODE = '$instcode'  order by BP_ID DESC limit 10 ");
		return $list;
	}
	// 10 SEPT 2023 JOSEPH ADORBOE
	public function queryreceiptrefundlist($searchitem,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$instcode){		
		$list = ("SELECT * from octopus_patients_reciept where BP_INSTCODE = '$instcode' and BP_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode') and ( BP_PATIENTNUMBER like '%$searchitem%' or BP_PATIENT like '%$searchitem%' or BP_RECIEPTNUMBER like '%$searchitem%' ) ");
		return $list;
	}
	// 12 SEPT 2023,  15 JUNE 2022  JOSEPH ADORBOE
	public function walletdepositreceipt($form_key,$day,$patientcode,$patientnumber,$patient,$descriptions,$currentshift,$currentshiftcode,$amountpaid,$currentusercode,$currentuser,$instcode,$chang,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$phonenumber,$state,$cashiertillcode,$days,$billingpaymentcode)
	{
        $one = 1;
		$na = 'NA';
		$bal = $this->thefailed;
        $sqlstmt = ("SELECT * FROM octopus_patients_reciept WHERE BP_CODE = ? AND BP_INSTCODE = ?");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $form_key);
        $st->BindParam(2, $instcode);
        $details =	$st->execute();		
        if ($details) {
            if ($st->rowcount() ==$this->thefailed) {
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
				if($genreceipt){
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}                
        } else {
            return $this->thefailed;
        }
		} else {
			return $this->thefailed;
		}
    }
	// 7 SEPT 2023, 6 MAR 2021 JOSEPH ADORBOE 
	public function getpatientreceiptdetails($idvalue){
		$sqlstmt = ("SELECT BP_VISITCODE,BP_DT,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_TOTAL,BP_AMTPAID,BP_METHOD,BP_ACTOR,BP_BALANCE,BP_SHIFT,BP_SCHEME,BP_STATE,BP_RECIEPTNUMBER,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKS,BP_METHODCODE,BP_CHANGE,BP_BILLINGCODE,BP_DESC,BP_SHIFTCODE FROM octopus_patients_reciept where BP_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['BP_VISITCODE'].'@@'.$object['BP_DT'].'@@'.$object['BP_PATIENTCODE'].'@@'.$object['BP_PATIENTNUMBER'].'@@'.$object['BP_PATIENT'].'@@'.$object['BP_TOTAL'].'@@'.$object['BP_AMTPAID'].'@@'.$object['BP_METHOD'].'@@'.$object['BP_ACTOR'].'@@'.$object['BP_BALANCE'].'@@'.$object['BP_SHIFT'].'@@'.$object['BP_SCHEME'].'@@'.$object['BP_STATE'].'@@'.$object['BP_RECIEPTNUMBER'].'@@'.$object['BP_PHONENUMBER'].'@@'.$object['BP_CHEQUENUMBER'].'@@'.$object['BP_INSURANCEBAL'].'@@'.$object['BP_BANKS'].'@@'.$object['BP_METHODCODE'].'@@'.$object['BP_CHANGE'].'@@'.$object['BP_BILLINGCODE'].'@@'.$object['BP_DESC'].'@@'.$object['BP_SHIFTCODE'];
				return $results;
			}else{
				return $this->theexisted;
			}

		}else{
			return $this->thefailed;
		}
	}
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberreceipt($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_reciept SET BP_PATIENTNUMBER = ? , BP_ACTOR = ?, BP_ACTORCODE =? where BP_PATIENTCODE = ? and BP_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();
		if($exe){				
			return $this->thepassed;
		}else{				
			return $this->thefailed;				
		}	
	}


    // 29 AUG 2023 
	public function selectinsertreceiptsinsurance($form_key,$transactiondate,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$transactionshift,$transactionshiftcode,$amountpaid,$totalamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$insurancetillcode,$days,$billingcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() ==$this->thefailed) {                
			   $sql = ("INSERT INTO octopus_patients_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENTNUMBER,BP_PATIENT,BP_BILLCODE,BP_DESC,BP_SHIFTCODE,BP_SHIFT,BP_CASHIERTILLSCODE,BP_SCHEME,BP_SCHEMCODE,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_ACTORCODE,BP_ACTOR,BP_INSTCODE,BP_CHANGE,BP_RECIEPTNUMBER,BP_METHOD,BP_METHODCODE,BP_STATE,BP_PHONENUMBER,BP_CHEQUENUMBER,BP_INSURANCEBAL,BP_BANKSCODE,BP_BANKS,BP_DT,BP_BILLINGCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				   $st = $this->db->prepare($sql);
				   $st->BindParam(1, $form_key);
				   $st->BindParam(2, $transactiondate);
				   $st->BindParam(3, $patientcode);
				   $st->BindParam(4, $patientnumber);
				   $st->BindParam(5, $patient);
				   $st->BindParam(6, $billcode);
				   $st->BindParam(7, $remarks);
				   $st->BindParam(8, $transactionshiftcode);
				   $st->BindParam(9, $transactionshift);
				   $st->BindParam(10, $insurancetillcode);
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
				   $st->BindParam(30, $billingcode);
				   $selectitem = $st->execute();               
				if($selectitem){
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}				    
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}
	}
	
	// 29 AUG 2023 
	public function selectinsertreceipts($form_key,$day,$patientcode,$patientnumber,$patient,$remarks,$visitcode,$currentshift,$currentshiftcode,$amountpaid,$totalgeneratedamount,$currentusercode,$currentuser,$instcode,$chang,$billcode,$paycode,$payname,$paymethcode,$paymeth,$receiptnumber,$state,$phonenumber,$chequenumber,$insurancebal,$bankname,$bankcode,$cashiertillcode,$days,$billingcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_reciept where BP_CODE = ? AND BP_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
        if ($details) {
            if ($st->rowcount() ==$this->thefailed) {
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
                $selectitem = $st->Execute();
				if($selectitem){
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}	
				    
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}
	}
} 

$patientreceipttable = new OctopusPatientsReceiptSql();
?>
