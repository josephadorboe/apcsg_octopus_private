<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_claims_scheme
	$claimsschemetable->processclaimsschemes($days,$claimsamount,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode)
*/

class OctopusClaimsSchemeSql Extends Engine{
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getmonthlyclaimsscheme($instcode){
		$list = ("SELECT * from octopus_claims_scheme where CLAM_STATUS IN('1') AND CLAM_INSTCODE = '$instcode' AND CLAM_AMOUNTPAID < CLAM_AMOUNT Group by CLAM_SCHEMECODE   order by CLAM_SCHEME DESC ");
		return $list;
	}

	// 5 JAN 2024, 01 MAR 2023 JOSEPH ADORBOE 
	public function processclaimsschemes($days,$claimsamount,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode){

		$two = 2;
		$one = 1;
		$zero = 0;
		$sqlstmt = ("SELECT * FROM octopus_claims_scheme  where CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND CLAM_SCHEMECODE = ? AND CLAM_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimmonth);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $claimyear);
		$st->BindParam(4, $claimschemecode);
		$st->BindParam(5, $one);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){	
				$sql = "UPDATE octopus_claims_scheme SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND  CLAM_STATUS = ? AND CLAM_METHODCODE = ?  AND CLAM_SCHEMECODE = ?";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $claimsamount);
				$st->BindParam(2, $claimsamount);
				$st->BindParam(3, $claimmonth);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $claimyear);
				$st->BindParam(6, $one);
				$st->BindParam(7, $claimmethodcode);
				$st->BindParam(8, $claimschemecode);
				$selectitem = $st->Execute();   
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}						
					
			}else{   
				$insertinurancetill =  "INSERT INTO octopus_claims_scheme (CLAM_CODE,CLAM_NUMBER,CLAM_METHODCODE,CLAM_METHOD,CLAM_SCHEME,CLAM_SCHEMECODE,CLAM_DATE,CLAM_AMOUNT,CLAM_AMOUNTPAID,CLAM_TAX,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $clamskeycode);
				$st->BindParam(2, $claimnumber);
				$st->BindParam(3, $claimmethodcode);
				$st->BindParam(4, $claimmethod);
				$st->BindParam(5, $claimscheme);
				$st->BindParam(6, $claimschemecode);
				$st->BindParam(7, $days);
				$st->BindParam(8, $claimsamount);
				$st->BindParam(9, $zero);
				$st->BindParam(10, $zero);
				$st->BindParam(11, $claimsamount);
				$st->BindParam(12, $claimmonth);
				$st->BindParam(13, $claimyear);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);
				$selectitem = $st->Execute();
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}        
    	}
		
	}else{
		return '0' ;
	}	
		
	}
		
} 
$claimsschemetable = new OctopusClaimsSchemeSql();
?>