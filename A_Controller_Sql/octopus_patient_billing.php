<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_billing
	$patientbillingtable = new OctopusPatientsBillingSql();
*/

class OctopusPatientBillingClass Extends Engine{
	public function updatebillingreceipt($receiptnumber,$billingcode,$instcode)
	{	
		$two = 2;
		$one = 1;
		$sql = "UPDATE octopus_patients_billing SET BG_STATUS = ?, BG_RECEIPTNUMBER = ? WHERE BG_CODE = ? AND  BG_STATUS = ? AND BG_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $receiptnumber);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();
		if($selectitem){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}	
	// 29 AUG 2023, 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	public function getpatientbillingdetails($patientcode,$visitcode,$instcode,$type)
	{		
		$rant = 1;
		$sqlstmt = ("SELECT BG_CODE,BG_AMOUNT,BG_AMOUNTPAID,BG_AMOUNTBAL FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ?");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
		$st->BindParam(4, $rant);
		$st->BindParam(5, $type);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$billdetails = $object['BG_CODE'].'@'.$object['BG_AMOUNT'].'@'.$object['BG_AMOUNTPAID'].'@'.$object['BG_AMOUNTBAL']	;
                return $billdetails;
            } else {
				return $this->thefailed;
            }
        } else {
            return $this->thefailed;
        }		
	}
	// 25 AUG 2023
	public function unselectupdatebilling($amt,$billingcode,$type,$visitcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT - ?, BG_AMOUNTBAL = BG_AMOUNTBAL - ? WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $amt);
		$st->BindParam(2, $amt);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $one);
		$st->BindParam(7, $type);
		$selectitem = $st->Execute();
		if($selectitem){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}
	// 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	public function getpatientbillinggeneratedcode($patientcode,$visitcode,$instcode,$type) : mixed
	{		
		$sqlstmt = ("SELECT BG_CODE FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
		$st->BindParam(4, $this->theone);
		$st->BindParam(5, $type);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$billdetails = $object['BG_CODE']	;
                return $billdetails;
            } else {
				return $this->thezero;
            }
        } else {
            return $this->thezero;
        }		
	}

	
	// 24 AUG 2023
	public function updatebilling($amt,$billgeneratedcode,$type,$visitcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_patients_billing SET BG_AMOUNT = BG_AMOUNT + ?, BG_AMOUNTBAL = BG_AMOUNTBAL + ? WHERE BG_CODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $amt);
		$st->BindParam(2, $amt);
		$st->BindParam(3, $billgeneratedcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $one);
		$st->BindParam(7, $type);
		$selectitem = $st->Execute();
		if($selectitem){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}
	// 29 AUG 2023
	public function updatepaymentbilling($amountdeducted,$billingcode,$type,$visitcode,$instcode){
		$sql = "UPDATE octopus_patients_billing SET BG_AMOUNTPAID = BG_AMOUNTPAID + ? , BG_AMOUNTBAL = BG_AMOUNTBAL - ?  WHERE BG_CODE = ? and BG_VISITCODE = ? and BG_INSTCODE = ? AND BG_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $amountdeducted);
		$st->BindParam(2, $amountdeducted);
		$st->BindParam(3, $billingcode);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $type);
		$selectitem = $st->Execute();
		if($selectitem){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}		
	}
	// 25 AUG 2023, 23 AUG 2023, 30 OCT 2021  INSERT PATIENT EMERGENCY CONTACT
	public function getgeneratedbillcode($patientcode,$patientnumber,$patient,$visitcode,$days,$day,$currentuser,$currentusercode,$instcode,$type) : mixed
	{		
		$rant = 1;
		$sqlstmt = ("SELECT BG_CODE FROM octopus_patients_billing WHERE BG_PATIENTCODE = ? AND BG_INSTCODE = ? AND BG_VISITCODE = ? AND BG_STATUS = ? AND BG_TYPE = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
		$st->BindParam(4, $rant);
		$st->BindParam(5, $type);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$billcode = $object['BG_CODE']	;
                return $billcode;
            } else {
				$billcode = md5(microtime());
				$sql = "INSERT INTO octopus_patients_billing(BG_CODE,BG_PATIENTCODE,BG_PATIENTNUMBER,BG_PATIENT,BG_VISITCODE,BG_DATE,BG_BILLDATE,BG_ACTOR,BG_ACTORCODE,BG_INSTCODE,BG_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $billcode);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $day);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $type);
				$addbills = $st->Execute();
				if($addbills){
					return $billcode;
				}else{
					return $this->thefailed;
				}		
            }
        } else {
            return $this->thefailed;
        }		
	}
	
} 
$patientbillingtable = new OctopusPatientBillingClass();
?>