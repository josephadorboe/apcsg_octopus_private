<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 28 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_promotion
	$patientpromotiontable->checkpromotionservice($servicescode,$patientcode,$day,$instcode)
*/

class OctopusPatientPromotionSql Extends Engine{

	// 31 DEC 2024, JOSEPH ADORBOE
	public function editpatientpromotionsubscription($promotioncode,$promotionstatus,$day,$reason,$currentusercode,$currentuser,$instcode)
	{
		$sql = "UPDATE octopus_patients_promotion SET PPR_STATUS = ? , PPR_REASON = ? , PPR_REASONACTOR = ? , PPR_REASONACTORCODE = ? , PPR_REASONDATE = ?  WHERE PPR_CODE = ? AND PPR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $promotionstatus);
		$st->BindParam(2, $reason);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $day);
		$st->BindParam(6, $promotioncode);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	//30 DEC 2024,  JOSEPH ADORBOE
    public function getpromotionstatus($patientcode,$instcode){	
		$two = '2';
		$sqlstmt = ("SELECT PPR_ID FROM octopus_patients_promotion WHERE PPR_PATIENTCODE = ? AND PPR_INSTCODE = ? AND PPR_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $two);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
			}
		}else{
			return '0';
		}
	}

	// 30 DEC 2024, JOSEPH ADORBOE 
	public function checkpromotionservice($servicescode, $patientcode,$day, $instcode){	
			$two = '2';	
			$zero  ='0';
			$sqlstmt = "SELECT * FROM octopus_patients_promotion WHERE PPR_PATIENTCODE = ? AND PPR_INSTCODE = ?  AND  PPR_STATUS = ?  AND PPR_ENDDATE > ? AND PPR_SERVICECODE = ? AND PPR_QTYLEFT > ?";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $two);
			$st->BindParam(4, $day);
			$st->BindParam(5, $servicescode);
			$st->BindParam(6, $zero);
			$ert = $st->execute();
			if($ert){
				if($st->rowcount()>0){					
					return '2';
				}else{
					return '0';
				}				
			}else{
				return '0';
			}	

		// }else{
		// 	return '2';
		// }		
	}

	//27 MAY 2024 JOSEPH ADORBOE 
	public function getpatientpromotionlov($patientcode,$day,$instcode)
	{
		$two = '2';
		$sql = " SELECT * FROM octopus_patients_promotion WHERE PPR_STATUS = '$two' AND PPR_INSTCODE = '$instcode' AND PPR_PATIENTCODE = '$patientcode' AND PPR_ENDDATE > '$day' ORDER BY PPR_DATE ASC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();			
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PPR_SERVICECODE'].'@@@'.$obj['PPR_SERVICE'].'">'.$obj['PPR_SERVICE'].' </option>';				
		}echo '<option value="" >No Subscription Found</option>';			
	}
	// 28 DEC 2024,  JOSEPH ADORBOE 
	public function getquerypromotionsubscriptionpendingpayment($instcode){		
		$list = ("SELECT * from octopus_patients_promotion WHERE PPR_INSTCODE = '$instcode' AND PPR_PAID = '0' order by PPR_ID DESC");
		return $list;
	}
	// 28 DEC 2024,  JOSEPH ADORBOE getquerypromotionsubscriptionpendingpayment
	public function getquerypromotionsubscription($instcode){		
		$list = ("SELECT * from octopus_patients_promotion WHERE PPR_INSTCODE = '$instcode' order by PPR_ID DESC");
		return $list;
	}

	// 28 DEC 2024,  JOSEPH ADORBOE
	public function getquerypromotionsubscriptionlist($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_promotion WHERE PPR_INSTCODE = '$instcode' AND PPR_PATIENTCODE = '$patientcode' order by PPR_ID DESC");
		return $list;
	}
	// 28 DEC 2024, JOSEPH ADORBOE
	public function activatepromotion($promotioncode,$enddate,$day,$two,$currentusercode,$currentuser,$instcode){
		$one = '1';
		$sql = "UPDATE octopus_patients_promotion SET PPR_STATUS = ? , PPR_STARTDATE = ? , PPR_ENDDATE = ? , PPR_PAYDATE = ? , PPR_PAYACTOR = ? , PPR_PAYACTORCODE = ? , PPR_PAID = ?  WHERE PPR_CODE = ? AND PPR_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $day);
		$st->BindParam(3, $enddate);
		$st->BindParam(4, $day);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $one);
		$st->BindParam(8, $promotioncode);
		$st->BindParam(9, $instcode);		
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}
	//28 DEC 2024,  JOSEPH ADORBOE
    public function addnewpatientpromotion($patientpromotioncode,$day,$patientcode,$patientnumber,$patient,$promotioncode,$promotiontitle,$promotionstartdate,$promotionenddate,$promotionvalidityday,$promotionservicecode,$promotionservice,$promotionunitprice,$promotiontotal,$promotionqty,$currentusercode,$currentuser,$instcode){	
		$one = '1';
		$sqlstmt = ("SELECT PPR_ID FROM octopus_patients_promotion WHERE PPR_PATIENTCODE = ? AND  PPR_PROMOTIONCODE = ?  AND PPR_INSTCODE = ? AND PPR_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $promotioncode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_promotion(PPR_CODE,PPR_DATE,PPR_PATIENTCODE,PPR_PATIENTNUMBER,PPR_PATIENT,PPR_PROMOTIONCODE,PPR_PROMOTION,PPR_STARTDATE,PPR_ENDDATE,PPR_VALIDITY,PPR_SERVICECODE,PPR_SERVICE,PPR_UNITPRICE,PPR_QTY,PPR_TOTAL,PPR_ACTOR,PPR_ACTORCODE,PPR_INSTCODE,PPR_QTYLEFT,PPR_LASTVISIT) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientpromotioncode);
				$st->BindParam(2, $day);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $promotioncode);
				$st->BindParam(7, $promotiontitle);
				$st->BindParam(8, $promotionstartdate);
				$st->BindParam(9, $promotionenddate);
				$st->BindParam(10, $promotionvalidityday);
				$st->BindParam(11, $promotionservicecode);
				$st->BindParam(12, $promotionservice);
				$st->BindParam(13, $promotionunitprice);
				$st->BindParam(14, $promotionqty);
				$st->BindParam(15, $promotiontotal);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $promotionqty);
				$st->BindParam(20, $day);
				$exe = $st->execute();									
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}			
			}
		}else{
			return '0';
		}	
	}
	
	
} 
	$patientpromotiontable = new OctopusPatientPromotionSql();
?>