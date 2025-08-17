<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_claims
	$patientclaimstable->processclaimsperformedtransactionsclose($claimscodes,$visitcode,$instcode)
	$patientclaimstable = new OctopusPatientsClaimsSql();
*/

class OctopusPatientsClaimsSql Extends Engine{

	// 5 JAN 2023, 9 SEPT 2023 JOSEPH ADORBOE
	public function getpatientclaims($instcode){
		$list = ("SELECT * FROM octopus_patients_claims WHERE CLAIM_STATUS IN('1','3') AND CLAIM_INSTCODE = '$instcode'  order by CLAIM_ID DESC LIMIT 400");
		return $list;
	}
	// 5 JAN 2024, JOSEPH ADORBOE 
	public function updateperformedbillingitemsclaims($claimsnumber,$claimsamount,$claimscode,$visitcode,$instcode){	
		$two = 2;		
		$one = 1;
		$sql = "UPDATE octopus_patients_claims SET CLAIMS_TRANSNUM = CLAIMS_TRANSNUM + ? , CLAIM_TOTAL =  CLAIM_TOTAL + ? WHERE CLAIM_CODE = ? AND CLAIM_INSTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_STATUS = ? AND CLAIM_NUMBER = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $claimsamount);
		$st->BindParam(3, $claimscode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $one);
		$st->BindParam(7, $claimsnumber);
		$selectitem = $st->Execute();	
		if($selectitem){
			return '2';
		}else{
			return '0';
		}		
	}	
	// 05 JAN 2024, 05 FEB 2023 JOSEPH ADORBOE 
	public function processclaimsperformedtransactionsclose($claimscodes,$visitcode,$instcode){
		$one = 1;
		$two = 2;
		        
		$sql = "UPDATE octopus_patients_claims SET CLAIM_STATUS = ?  WHERE CLAIM_CODE = ? AND CLAIM_INSTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $claimscodes);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $one);
		$selectitem = $st->Execute();
		if ($selectitem) {
			return '2' ;
		} else {
			return '0' ;
		}	
	}
	// 18 Sept 2023 JOSEPH ADORBOE
	public function insert_patientclaims($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$visitcode,$patientschemecode,$patientscheme,$paymentmethod,$paymentmethodcode,$days,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
				
		$sqlstmt = "INSERT INTO octopus_patients_claims(CLAIM_CODE,CLAIM_NUMBER,CLAIM_PATIENTCODE,CLAIM_PATIENTNUMBER,CLAIM_PATIENT,CLAIM_DATE,CLAIM_VISITCODE,CLAIM_PAYSCHEMECODE,CLAIM_PAYSCHEME,CLAIM_METHOD,CLAIM_METHODCODE,CLAIM_INSTCODE,CLAIM_DAY,CLAIM_MONTH,CLAIM_YEAR,CLAIMS_ACTOR,CLAIMS_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $claimsnumber);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $days);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $patientschemecode);
		$st->BindParam(9, $patientscheme);
		$st->BindParam(10, $paymentmethod);
		$st->BindParam(11, $paymentmethodcode);
		$st->BindParam(12, $instcode);
		$st->BindParam(13, $currentday);
		$st->BindParam(14, $currentmonth);
		$st->BindParam(15, $currentyear);
		$st->BindParam(16, $currentuser);
		$st->BindParam(17, $currentusercode);	
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{
			return '0';
		}				
	}
	// 18 Sept 2023, 05 FEB 2023 JOSEPH ADORBOE 
	public function getclaimsnumber($patientcode,$visitcode,$patientschemecode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT CLAIM_CODE,CLAIM_NUMBER FROM octopus_patients_claims WHERE CLAIM_PATIENTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_PAYSCHEMECODE = ? AND CLAIM_STATUS = ?  AND CLAIM_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $patientschemecode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CLAIM_CODE'].'@'.$object['CLAIM_NUMBER'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}
	// 05 FEB 20223 JOSEPH ADORBOE 
	public function getclaimsmain($patientcode,$visitcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_claims where CLAIM_VISITCODE = ? and CLAIM_PATIENTCODE = ? and CLAIM_INSTCODE = ? and CLAIM_STATUS IN('1','2','4')  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CLAIM_DATE'].'@'.$object['CLAIM_PAYSCHEME'].'@'.$object['CLAIM_METHOD'].'@'.$object['CLAIMS_TRANSNUM'].'@'.$object['CLAIM_TOTAL'].'@'.$object['CLAIM_CODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
		
} 
$patientclaimstable = new OctopusPatientsClaimsSql();
?>