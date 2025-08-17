<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 23 DEC 2024
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_promotion
	$promotionsetuptable->updateaddpromotionsubscriber($promotioncode,$serviceunit,$total,$instcode);
	
*/

class OctopusSetupPromotionSql Extends Engine{

	// 31 DEC 2024, JOSEPH ADORBOE
	public function updateaddpromotionsubscriber($procode,$prounit,$amountpaid,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_st_promotion SET PRM_COUNTSUSCRIBEPENDING = PRM_COUNTSUSCRIBEPENDING - ?, PRM_COUNTSUBSCRIBER = PRM_COUNTSUBSCRIBER + ? , PRM_COUNTSERVICE =  PRM_COUNTSERVICE + ? , PRM_WALLETBALANCE = PRM_WALLETBALANCE + ? WHERE PRM_CODE = ? AND PRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $one);
		$st->BindParam(3, $prounit);
		$st->BindParam(4, $amountpaid);
		$st->BindParam(5, $procode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 31 DEC 2024, JOSEPH ADORBOE
	public function updateaddpromotionpendingsubscriber($promotioncode,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_promotion SET PRM_COUNTSUSCRIBEPENDING = PRM_COUNTSUSCRIBEPENDING + ? WHERE PRM_CODE = ? AND PRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $promotioncode);
		$st->BindParam(3, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 28 DEC 2024, JOSEPH ADORBOE 
	public function getactivepromotionslov($instcode)
	{
		$one = '1';
		$day = date('Y-m-d');
		$sql = " SELECT * FROM octopus_st_promotion WHERE PRM_STATUS = '$one' AND PRM_INSTCODE = '$instcode' and PRM_ENDDATE > '$day' ORDER BY PRM_ID  ASC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['PRM_CODE'].'@@@'.$obj['PRM_TITLE'].'@@@'.$obj['PRM_STARTDATE'].'@@@'.$obj['PRM_ENDDATE'].'@@@'.$obj['PRM_VALIDDAYS'].'@@@'.$obj['PRM_SERVICECODE'].'@@@'.$obj['PRM_SERVICE'].'@@@'.$obj['PRM_UNITPRICE'].'@@@'.$obj['PRM_TOTAL'].'@@@'.$obj['PRM_QTY'].'">'.$obj['PRM_TITLE'].' - '.$obj['PRM_SERVICE'].'</option>';
		}
			
	}

	// 24 DEC 2024,  JOSEPH ADORBOE
    public function addnewpromotion($promotioncode,$promotiontitle,$startdate,$enddate,$day,$promotiontype,$servicecode,$servicename,$unitprice,$totalprice,$promotionqty,$promotionterms,$promotionvalidity,$currentusercode,$currentuser,$instcode){	
		$mt = 1;		
		$sqlstmt = "INSERT INTO octopus_st_promotion(PRM_CODE,PRM_TITLE,PRM_DATE,PRM_STARTDATE,PRM_ENDDATE,PRM_TYPE,PRM_SERVICECODE,PRM_SERVICE,PRM_UNITPRICE,PRM_TOTAL,PRM_QTY,PRM_TERMS,PRM_ACTORCODE,PRM_ACTOR,PRM_INSTCODE,PRM_VALIDDAYS,PRM_LASTDATE) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $promotioncode);
		$st->BindParam(2, $promotiontitle);
		$st->BindParam(3, $day);
		$st->BindParam(4, $startdate);
		$st->BindParam(5, $enddate);
		$st->BindParam(6, $promotiontype);
		$st->BindParam(7, $servicecode);
		$st->BindParam(8, $servicename);
		$st->BindParam(9, $unitprice);
		$st->BindParam(10, $totalprice);
		$st->BindParam(11, $promotionqty);
		$st->BindParam(12, $promotionterms);
		$st->BindParam(13, $currentusercode);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $promotionvalidity);	
		$st->BindParam(17, $enddate);				
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}			
	}

	// 24 DEC 2024, JOSEPH ADORBOE
	public function editpromotion($ekey,$promotiontitle,$startdate,$enddate,$promotiontype,$servicecode,$servicename,$unitprice,$totalprice,$promotionqty,$promotionterms,$promotionstatus,$promotionvalidity,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_promotion SET PRM_TITLE = ? , PRM_STARTDATE = ? , PRM_ENDDATE = ? , PRM_TYPE = ? , PRM_SERVICECODE = ? , PRM_SERVICE = ? , PRM_UNITPRICE = ? , PRM_TOTAL = ? , PRM_QTY = ? , PRM_TERMS = ?  , PRM_ACTORCODE = ? , PRM_ACTOR = ? , PRM_STATUS = ? ,PRM_VALIDDAYS = ? WHERE PRM_CODE = ? AND PRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $promotiontitle);
		$st->BindParam(2, $startdate);
		$st->BindParam(3, $enddate);
		$st->BindParam(4, $promotiontype);
		$st->BindParam(5, $servicecode);
		$st->BindParam(6, $servicename);
		$st->BindParam(7, $unitprice);
		$st->BindParam(8, $totalprice);
		$st->BindParam(9, $promotionqty);
		$st->BindParam(10, $promotionterms);
		$st->BindParam(11, $currentusercode);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $promotionstatus);
		$st->BindParam(14, $promotionvalidity);
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 23 DEC 2024, JOSEPH ADORBOE
	public function getquerypromotion($instcode){		
		$list = ("SELECT * from octopus_st_promotion WHERE PRM_INSTCODE = '$instcode'  ORDER BY PRM_ID DESC");
		return $list;
	}
	
} 
	$promotionsetuptable = new OctopusSetupPromotionSql();
?>