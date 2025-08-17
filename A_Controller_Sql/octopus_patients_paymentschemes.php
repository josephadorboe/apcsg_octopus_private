<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023
	PURPOSE: TO OPERATE MYSQL QUERY	
	Based on octopus_patients_paymentschemes
	$patientschemetable->updatepatientschemewallet($patientcode,$refundamount,$instcode,$walletcode);
*/

class OctopusPatientsPaymentSchemeClass Extends Engine{
	

	
	// 1 SEPT 2023 
	public function listpatientpaymentscheme($instcode,$patientcodecode) : String {
		$list = ("SELECT * from octopus_patients_paymentschemes where PAY_INSTCODE = '$instcode' and PAY_PATIENTCODE = '$patientcodecode' and PAY_STATUS = '1' ");																	
		return $list;
	}
	// 12 SEPT 2023 JOSEPH ADORBOE
	public function walletpatientlist($prepaidchemecode,$instcode) : String {		
		$list = ("SELECT * from octopus_patients_paymentschemes where PAY_SCHEMECODE = '$prepaidchemecode' and PAY_INSTCODE = '$instcode' and PAY_STATUS = '1' ");
		return $list;
	}

	// 9 JAN 2024, JOSEPH ADORBOE  
	//   and PAY_STATUS = '1' AND AND (PAY_PATIENTNUMBER LIKE '.%$searchitem%.' OR PAY_PATIENT LIKE '.%$searchitem%.' ) 
	public function searchrefundswallet($searchitem,$prepaidcode,$instcode) : String {
		$list = ("SELECT * from octopus_patients_paymentschemes where  PAY_PAYMENTMETHODCODE = '$prepaidcode' AND PAY_INSTCODE = '$instcode' AND ( PAY_PATIENTNUMBER LIKE '%$searchitem%' OR PAY_PATIENT LIKE '%$searchitem%' ) ");
		return $list;
	}
	// 10 JAN 2024 JOSEPH ADORBOE
	public function updatepatientschemewallet($refundamount,$instcode,$walletcode) : Int
	{   
		$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE - ? WHERE PAY_CODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $refundamount);
		$st->BindParam(2, $walletcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$ext = $st->execute();
		if($ext){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}       
    }

	// 12 SEPT 2023 
	public function gettotaldeposit(String $instcode,String $prepaidchemecode): Float 
		{
		
		$sql = " SELECT SUM(PAY_BALANCE) AS BALANCE FROM octopus_patients_paymentschemes WHERE PAY_INSTCODE = ? AND PAY_STATUS = ? AND PAY_SCHEMECODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $this->theone);
		$st->BindParam(3, $prepaidchemecode);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = floatval($obj['BALANCE']);				
				return $value;
			}else{
				return floatval(0);
			}
		}else{
			return floatval(0);
		}			
	}

	// 12 SEPT 2023,  15 JUNE 2022  JOSEPH ADORBOE
	public function walletdepositpatientscheme($form_key,$day,$patientcode,$patientnumber,$patient,$amountpaid,$currentusercode,$currentuser,$instcode,$prepaidchemecode,$prepaidscheme,$prepaidcode,$prepaid) 
	{
        $na = 'NA';
		$bal = $this->thefailed;
		$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prepaidchemecode);
		$st->BindParam(4, $this->theone);
		$dt =	$st->execute();
		if ($dt) {
			if ($st->rowcount() >$this->thefailed) {
				// update account
				$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $prepaidchemecode);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $this->theone);
				$ext = $st->execute();
				if($ext){
					return $this->thepassed;
				}else{
					return $this->thefailed;
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
					return $this->thepassed;
				}else{
					return $this->thefailed;
				}
			}

			}
    }
	// 15 JUNE 2022 JOSEPH ADORBOE 
	public function getpatientwalletbalancee($patientcode,$prepaidcode,$prepaidchemecode,$instcode) : int {
		$one = 1;
		$typ = 7;
		$sql = "SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_PAYMENTMETHODCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prepaidcode);
		$st->BindParam(4, $prepaidchemecode);
		$st->BindParam(5, $one);
		$ext = $st->execute();
		if($ext){
			if($st->rowcount() > 0 ){
				$obj = $st->Fetch(PDO::FETCH_ASSOC);	
				$value = floatval($obj['PAY_BALANCE']);				
					return $value;			
			}else{				
					return $this->thefailed;				
			}
		}else{
			return $this->thefailed;
		}		
	}
	
	// 10 SEPT 2023, 08 SEPT 2022  JOSEPH ADORBOE
	public function updatepatientscheme($patientcode,$refundamount,$instcode,$prepaidchemecode) : int
	{   
		$one = 1;            
		$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE - ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $refundamount);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $prepaidchemecode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$ext = $st->execute();
		if($ext){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}       
    }
	// 11 AUG 2023 , 23 JUNE 2021 JOSEPH ADORBOE 
	public function disablepaymentscheme($ekey,$currentusercode,$currentuser,$instcode) : int{
		
		$sqlstmt = "UPDATE octopus_patients_paymentschemes SET PAY_STATUS = ? , PAY_ACTOR = ?, PAY_ACTORCODE = ? where PAY_CODE = ? and PAY_STATUS = ? and PAY_INSTCODE = ?";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $this->thezero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $this->theone);
		$st->BindParam(6, $instcode);
		$rt = $st->execute();
		if($rt){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}
	// 9 AUG 2023, 23 JUNE 2021 JOSEPH ADORBOE 
	public function insert_patientscheme($form_key,$patientcode,$patientnumber,$patient,$day,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$cardnumber,$expirydate,$plan,$currentusercode,$currentuser,$instcode) : int {
		$nuy = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes where PAY_PATIENTCODE = ? and PAY_SCHEMECODE = ? and PAY_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $paymentschemecode);
		$st->BindParam(3, $this->theone);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return $this->theexisted;
			}else{
				$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_CARDNUM,PAY_ENDDT,PAY_ACTORCODE,PAY_ACTOR,PAY_INSTCODE,PAY_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $day);
				$st->BindParam(6, $paymentmethodcode);
				$st->BindParam(7, $paymethname);
				$st->BindParam(8, $paymentschemecode);
				$st->BindParam(9, $paymentscheme);
				$st->BindParam(10, $cardnumber);
				$st->BindParam(11, $expirydate);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $plan);				
				$scheme = $st->execute();				
				if($scheme){					
					return $this->thepassed;					
				}else{					
					return $this->thefailed;					
				}
			}
		}else{
			return $this->thefailed;
		}			
	}
	// 9 AUG 2023, 22 JUNE 2021 JOSEPH ADORBOE 
	public function checkpatientinsurancestatus($patientcode,$paymentschemecode,$day,$instcode) : mixed{
		$sate = 1;
		$sqlstmt = "SELECT * FROM octopus_patients_paymentschemes where PAY_PATIENTCODE = ? and PAY_INSTCODE = ? and PAY_SCHEMECODE = ? and PAY_ENDDT > ? and PAY_STATUS = ?";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $paymentschemecode);
		$st->BindParam(4, $day);
		$st->BindParam(5, $this->theone);
		$ert = $st->execute();
		if($ert){
			if($st->rowcount()>0){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$data = $obj['PAY_CARDNUM'].'@@@'.$obj['PAY_ENDDT'];
				return $data;
			}else{
				return '-1';
			}				
		}else{
			return $this->thefailed;
		}	
	}
	// 29 AUG 2023, 19 JUNE 2022  JOSEPH ADORBOE
	public function getpatientwalletstate($patientcode,$prepaidcode,$prepaidchemecode,$instcode) : mixed
	{
		$one = 1;
		$sql = 'SELECT PAY_BALANCE FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? and PAY_INSTCODE = ? AND PAY_PAYMENTMETHODCODE  = ?  AND PAY_SCHEMECODE = ? AND PAY_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prepaidcode);
		$st->BindParam(4, $prepaidchemecode);
		$st->BindParam(5, $this->theone);
		$state = $st->execute();
		if($state){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$results = floatval($obj['PAY_BALANCE']);			
				return $results;					
			}else{
				return '-1';
			}
		}else{
			return '-1';
		}	
	}
		
} 

$patientschemetable = new OctopusPatientsPaymentSchemeClass();
?>