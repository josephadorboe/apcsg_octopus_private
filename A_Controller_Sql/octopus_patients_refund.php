<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 10 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_refund
	$patientrefundtable->approverefund($ekey,$refunddescription,$days,$currentuser,$currentusercode,$instcode);
*/

class OctopusPatientRefundSql Extends Engine{
	// // 1 JAN 2024 JOSEPH ADORBOE
	// public function querydashboardrefundlist($instcode){		
	// 	$list = ("SELECT * FROM octopus_patients_refund  WHERE REF_STATUS IN('1') AND REF_INSTCODE = '$instcode' order by REF_ID DESC LIMIT 10 ");
	// 	return $list;
	// }

	// 9 SEPT 2023 JOSEPH ADORBOE
	public function queryrefundsearchlist($general,$first,$second,$day,$instcode){	
		if($general == '1'){											
			$querysearchrefundslist = ("SELECT * FROM octopus_patients_refund  WHERE REF_STATUS !='0' AND REF_INSTCODE = '$instcode' AND ( REF_PATIENTNUMBER LIKE '%$first%' OR (REF_PATIENT LIKE '%$first%' ) OR (REF_NUMBER LIKE '%$first%') ) ORDER BY REF_ID DESC LIMIT 10");			
						// AND ( REF_PATIENTNUMBER LIKE '%$first%' ) OR (REF_PATIENT LIKE '%$first%' ) OR (REF_NUMBER LIKE '%$first%') 	 		
		}else if($general == '2'){											
			$querysearchrefundslist = ("SELECT * FROM octopus_patients_refund  WHERE REF_STATUS !='0' AND REF_INSTCODE = '$instcode' AND REF_DAY >= '$first' AND REF_DAY <= '$second' order by REF_ID DESC ");						
		}else{											
			$querysearchrefundslist = ("SELECT * FROM octopus_patients_refund  WHERE REF_STATUS !='0' AND REF_INSTCODE = '$instcode' AND REF_DAY  = '$day' order by REF_ID DESC ");										 
		}
		return $querysearchrefundslist;
	}
	// 9 SEPT 2023 JOSEPH ADORBOE
	public function queryrefundlist($instcode){		
		$list = ("SELECT * FROM octopus_patients_refund  WHERE REF_STATUS IN('1') AND REF_INSTCODE = '$instcode' order by REF_ID DESC LIMIT 10 ");
		return $list;
	}

	// 10 JAN 2024,   JOSEPH ADORBOE 
	public function editrefundsrequest($ekey,$refunddescription,$refundamount,$instcode){
		$one = 1;	
		$two = 2;		
		$sqlstmts = "UPDATE octopus_patients_refund set REF_AMOUNT = ?, REF_PURPOSE = ? WHERE REF_CODE = ? and REF_INSTCODE = ? AND REF_STATUS = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $refundamount);
		$st->BindParam(2, $refunddescription);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$tills = $st->execute();
		if ($tills) {
			return '2';
		} else {
			return '0';
		}	
	}	

	// 10 JAN 2024,   JOSEPH ADORBOE 
	public function approverefund($ekey,$refunddescription,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;		
		$sqlstmts = "UPDATE octopus_patients_refund set REF_APPROVEDATE = ?, REF_APPROVEACTOR = ? , REF_APPROVEACTORCODE = ? , REF_STATUS = ?, REF_APPROVENOTES = ?  where REF_CODE = ? and REF_INSTCODE = ? AND REF_STATUS = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $two);
		$st->BindParam(5, $refunddescription);
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

	// 10 SEPT 2023, 08 SEPT 2022  JOSEPH ADORBOE
	public function newrefunds($form_key,$ekey,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$refundamount,$refunddescription,$currentusercode,$currentuser,$instcode,$receiptnum,$refundnumber,$currentday,$currentmonth,$currentyear)
	{
        $one = 1;
		$na = 'NA';
		$bal = '0';
        $sql = ("INSERT INTO octopus_patients_refund (REF_CODE,REF_NUMBER,REF_DATE,REF_SHIFTCODE,REF_SHIFT,REF_PATIENTCODE,REF_PATIENTNUMBER,REF_PATIENT,REF_AMOUNT,REF_PURPOSE,REF_AFFECTRECEIPTNUM,REF_ACTOR,REF_ACTORCODE,REF_CURRENTDAY,REF_CURRENTMONTH,REF_CURRENTYEAR,REF_INSTCODE,REF_DAY,REF_WALLETCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $refundnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentshiftcode);
		$st->BindParam(5, $currentshift);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumber);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $refundamount);
		$st->BindParam(10, $refunddescription);
		$st->BindParam(11, $receiptnum);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $currentusercode);
		$st->BindParam(14, $currentday);
		$st->BindParam(15, $currentmonth);
		$st->BindParam(16, $currentyear);
		$st->BindParam(17, $instcode);
		$st->BindParam(18, $day);
		$st->BindParam(19, $ekey);		
		$ext = $st->execute();
		if($ext){
			return '2';
		}else{
			return '0';
		}      
    }
} 

$patientrefundtable = new OctopusPatientRefundSql();
?>