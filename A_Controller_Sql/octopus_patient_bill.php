<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_bills
	$patientsbillstable->updatebillsamount($cost,$billcode);
	$patientsbillstable = new OctopusPatientsBillsClass();
*/

class OctopusPatientsBillsClass Extends Engine{
	// 6 JUNE 2020
	public function createbillcode($patientcode,$visitcode){			
		$pre = 'SA';
		$yr = date("Y");
		$mt = date("m");
		$prefix = $yr.''.$mt ;		
		$sp = 1 ;		
		$sql = "SELECT BILL_CODE FROM octopus_patients_bills ORDER BY BILL_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);	
		$st->execute();		
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['BILL_CODE'],7,30);
			$valu = $valu + 1;			
			$ordernum = $prefix.'-'.$valu;		
		}else{			
			$ordernum = $prefix.'-1';			
		}		
		return $ordernum ;		
	}

	// 23 NOV 2023, JOSEPH ADORBOE  
	public function updatebillsamount($cost,$billcode){
		$sqlstmt = "UPDATE octopus_patients_bills SET BILL_AMOUNT = BILL_AMOUNT + ?  WHERE BILL_CODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $cost);
		$st->BindParam(2, $billcode);
		$setbills = $st->execute();
		if($setbills){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}	

	// 30 OCT 2021 JOSEPH ADORBOE 
	public function getpatientbillingcode($bbcode,$patientcode,$patientnumber,$patient,$days,$visitcode,$currentuser,$currentusercode,$instcode){
		$nuy = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_bills where BILL_PATIENTCODE = ? and BILL_VISITCODE = ? and BILL_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $nuy);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['BILL_CODE'];
				return $value;
			}else{
				$sql = ("INSERT INTO octopus_patients_bills (BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $bbcode);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);			
				$opentill = $st->execute();				
				if($opentill){					
					return $bbcode;					
				}else{					
					return $this->thefailed;					
				}
			}

		}else{
			return '-1';
		}
			
	}	
	// 29 AUG 2023 
	public function updatebillsreceipt($form_key,$currentuser,$currentusercode,$billcode){
		$two = 2;
		$sql = ("UPDATE octopus_patients_bills SET BILL_RECEIPTNUMBER = ?, BILL_ACTOR = ?, BILL_ACTORCODE = ?, BILL_STATUS = ? WHERE BILL_CODE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $two);
		$st->BindParam(5, $billcode);
		$selectitem = $st->Execute();
		if($selectitem){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}
	// 23 AUG 2023
	public function insertnewbills($billcode,$days,$patientcode,$patientnumber,$visitcode,$patient,$serviceamount,$currentuser,$currentusercode,$instcode)
	{		
		$sql = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_DATE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE,BILL_AMOUNT) VALUES (?,?,?,?,?,?,?,?,?,?)";
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $billcode);
		$st->BindParam(2, $days);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $patientnumber);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $serviceamount);
		$addbills = $st->Execute();
		if($addbills){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}	
} 
$patientsbillstable = new OctopusPatientsBillsClass();
?>