<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 13 MAR 2022
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/

class SentoutController Extends Engine
{
	// 04 JUN 2021 JOSEPH ADORBOE
	public function pharmacysentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser){
		$nt = 8 ;
		$rt = 5 ;
		$tut = 2;
		$nut =1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_STATUS = ? , PRESC_PROCESSACTOR = ?, PRESC_PROCESSACTORCODE = ? ,PRESC_COMPLETE = ? WHERE PRESC_CODE = ? and  PRESC_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $tut);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $nut);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 15 JUN 2021 JOSEPH ADORBOE
	public function reversepharmacysentoutsingle($ekey,$day, $currentusercode, $currentuser){
		$not = 1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_STATUS = ? , PRESC_PROCESSACTOR = ?, PRESC_PROCESSACTORCODE = ? ,PRESC_COMPLETE = ?, PRESC_DATE = ?  WHERE PRESC_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $not);
		$st->BindParam(6, $day);
		$st->BindParam(7, $ekey);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	
} 
?>