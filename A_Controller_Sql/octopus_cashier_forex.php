<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 8 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 
	Base : 	octopus_cashier_forex	
	$cashierforextable->selectforex($instcode);
*/

class OctopusCashierForexSql Extends Engine{

	// 5 JAN 2023, ADORBOE JOSEPH 
	public function selectforex($instcode){
		$list = ("SELECT * from octopus_cashier_forex where FOX_STATUS != '0' and FOX_INSTCODE = '$instcode' ORDER BY FOX_ID DESC ");
		return $list;
	}
	
	// 8 AUG 2023 ,06 NOV 2022 JOSEPH ADORBOE 
	public function getexchangerate(String $currency, String $day, String $instcode) : float {
		$one = 1; 		
		$sql = 'SELECT FOX_RATE FROM octopus_cashier_forex where FOX_CURRENCY = ? and date(FOX_DATE) = ? and FOX_INSTCODE = ? and FOX_STATUS = ? order by FOX_ID DESC';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $currency);
		$st->BindParam(2, $day);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
		if ($exrt) {
			if ($st->rowcount() > 0) {
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['FOX_RATE'];
				return $price ;
			} else {
				return '-1';
			}
		} else {
			return '-1';
		}	
	}
	// 8 AUG 2023 , 05 NOV 2022 JOSEPH ADORBOE 
	public function addforex($form_key,$currency,$rates,$days,$currentusercode,$currentuser,$instcode) {		
		$zero = '0';
		$one = 1;
		$two = 2;
		
			$sqlstmt = "INSERT INTO octopus_cashier_forex(FOX_CODE,FOX_DATE,FOX_CURRENCY,FOX_RATE,FOX_ACTOR,FOX_ACTORCODE,FOX_INSTCODE) VALUES (?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $days);
			$st->BindParam(3, $currency);
			$st->BindParam(4, $rates);
			$st->BindParam(5, $currentuser);
			$st->BindParam(6, $currentusercode);
			$st->BindParam(7, $instcode);
			$exev = $st->execute();	
			if($exev){
				$sql = "UPDATE octopus_cashier_forex SET FOX_STATUS = ? WHERE FOX_CODE != ? AND FOX_CURRENCY = ?  AND FOX_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $two);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $currency);
				$st->BindParam(4, $instcode);
				$exet = $st->execute();		

				return '2';			
			}else{			
				return '0';			
			}
	}	
} 
$cashierforextable = new OctopusCashierForexSql();
?>