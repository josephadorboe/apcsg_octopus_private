<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 5 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_claims_monthly
	$claimsmonthlytable->processclaimsmonthly($days,$claimsamount,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode)
*/

class OctopusClaimsMonthlySql Extends Engine{
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function getmonthlyclaims($instcode){
		$list = ("SELECT * from octopus_claims_monthly where CLAM_STATUS IN('1') AND CLAM_INSTCODE = '$instcode' AND CLAM_AMOUNTPAID < CLAM_AMOUNT Group by CLAM_MONTH ,CLAM_YEAR  order by CLAM_YEAR DESC ");
		return $list;
	}

	// 5 JAN 2024, 01 MAR 2023 JOSEPH ADORBOE 
	public function processclaimsmonthly($days,$claimsamount,$clamskeycode,$claimnumber,$claimmonth,$claimyear,$currentusercode,$currentuser,$instcode){
		$two = 2;
		$one = 1;
		$zero = 0;
		$sqlstmt = ("SELECT * FROM octopus_claims_monthly where CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $claimmonth);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $claimyear);
	//	$st->BindParam(4, $two);
		$checkselect = $st->execute();
		if($checkselect){
			if($st->rowcount() > 0){			
				$sql = "UPDATE octopus_claims_monthly SET CLAM_AMOUNT = CLAM_AMOUNT + ? , CLAM_BAL =  CLAM_BAL + ? WHERE CLAM_MONTH = ? AND CLAM_INSTCODE = ? AND CLAM_YEAR = ? AND  CLAM_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $claimsamount);
				$st->BindParam(2, $claimsamount);
				$st->BindParam(3, $claimmonth);
				$st->BindParam(4, $instcode);
				$st->BindParam(5, $claimyear);
				$st->BindParam(6, $one);
				$selectitem = $st->Execute();   
				if ($selectitem) {
					return '2' ;
				} else {
					return '0' ;
				}				
			}else{           
       
				$insertinurancetill =  "INSERT INTO octopus_claims_monthly (CLAM_CODE,CLAM_NUMBER,CLAM_DATE,CLAM_AMOUNT,CLAM_BAL,CLAM_MONTH,CLAM_YEAR,CLAM_ACTOR,CLAM_ACTORCODE,CLAM_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($insertinurancetill);
				$st->BindParam(1, $clamskeycode);
				$st->BindParam(2, $claimnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $claimsamount);
				$st->BindParam(5, $claimsamount);
				$st->BindParam(6, $claimmonth);
				$st->BindParam(7, $claimyear);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
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
$claimsmonthlytable = new OctopusClaimsMonthlySql(); 
?>