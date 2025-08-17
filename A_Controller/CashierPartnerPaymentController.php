<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 06 MAR 2022
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/
class cashierPartnerPaymentController Extends Engine
{


	// 06 MAR 2022 JOSEPH ADORBOE
	public function cashierpartnerpaymentadd($ekey,$amountrequested,$receiptnum,$desc,$days,$currentusercode,$currentuser,$instcode){
		$two = 2 ;
		$one = 1 ;
		$sql = "UPDATE octopus_cashier_partnerbills SET PC_PROCESSRECEIPT = ?, PC_PROCESSDESC = ?, PC_PROCESSAMOUNT = ?,  PC_PROCESSACTOR = ? , PC_PROCESSACTORCODE = ? , PC_PROCESSTIME = ? , PC_STATUS = ? WHERE PC_CODE = ? and PC_INSTCODE = ? AND PC_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $receiptnum);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $amountrequested);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $days);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $one);
		$exe = $st->execute();	
		
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_PARTNERSET = ? WHERE MIV_BATCHCODE = ? and MIV_PARTNERSET = ? and  MIV_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $ekey);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);
		$exe = $st->execute();							
		
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}
			
	// 06 MAR 2022  JOSEPH ADORBOE
	public function getpartnerreceiptnum($receiptnum,$instcode){
		$sql = ("SELECT *  FROM octopus_cashier_partnerbills where PC_PROCESSRECEIPT = ? and PC_INSTCODE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $$receiptnum);
		$st->BindParam(2, $instcode);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				return '1';
			}else{
				return '2';
			}
		}else{
			return '0';
		}
		
	}
	
	
} 
?>