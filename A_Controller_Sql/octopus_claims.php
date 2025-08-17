<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_claims
	$claimstable->peformclaims($clamskeycode,$claimnumber,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$claimmonth,$claimsamount,$days,$claimyear,$currentuser,$currentusercode,$instcode)
*/

class OctopusClaimsSql Extends Engine{

	// 5 JAN 2024 , JOSEPH ADORBOE 
	public function peformclaims($clamskeycode,$claimnumber,$claimmethodcode,$claimmethod,$claimschemecode,$claimscheme,$claimmonth,$claimsamount,$days,$claimyear,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$zero = '0';
		$sqlstmt = ("SELECT * FROM octopus_claims where CLAM_SCHEMECODE = ? AND CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_STATUS = ? ");
    $st = $this->db->prepare($sqlstmt);
    $st->BindParam(1, $claimschemecode);
    $st->BindParam(2, $claimmonth);
    $st->BindParam(3, $instcode);
    $st->BindParam(4, $one);
    $checkselect = $st->execute();
    if ($checkselect) {
        if ($st->rowcount() > 0) {

			$sql = "UPDATE octopus_claims SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_SCHEMECODE = ? AND CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND  CLAM_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $claimsamount);
			$st->BindParam(2, $claimsamount);
			$st->BindParam(3, $claimschemecode);
			$st->BindParam(4, $claimmonth);
			$st->BindParam(5, $instcode);
			$st->BindParam(6, $one);
			$selectitem = $st->Execute();
			if ($selectitem) {
                return '2' ;
            } else {
                return '0' ;
            }
            
        } else {
            $insertinurancetill =  "INSERT INTO octopus_claims (CLAM_CODE,CLAM_NUMBER,CLAM_METHODCODE,CLAM_METHOD,CLAM_SCHEME,CLAM_SCHEMECODE,CLAM_DATE,CLAM_AMOUNT,CLAM_AMOUNTPAID,CLAM_TAX,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
    }
	}
	
} 
$claimstable = new OctopusClaimsSql();
?>