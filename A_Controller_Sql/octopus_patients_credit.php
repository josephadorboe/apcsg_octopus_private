<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_credit
	$patientcredittable = new OctopusPatientsCreditsSql();
*/

class OctopusPatientCreditClass Extends Engine{

	// 18 JUNE 2025, 7 MAR 2021
	public function rejectcreditrequest($days,$desc,$currentusercode,$currentuser,$ekey){		
		$sql = "UPDATE octopus_patients_credit SET CREDIT_APPROVERDATE = ? , CREDIT_REMAKES = ? , CREDIT_APPROVERCODE = ? , CREDIT_APPROVER = ?, CREDIT_STATUS = ? WHERE CREDIT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $this->thezero);
		$st->BindParam(6, $ekey);
		$activatescheme = $st->execute();		
		if($activatescheme){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}


	// 18 JUNE 2025, 8 MAR 2021
	public function approvecreditrequested($desc,$amountrequested,$days,$currentusercode,$currentuser,$ekey){		
		$value = 2;
		$sql = "UPDATE octopus_patients_credit SET CREDIT_CELLINGAMOUNT = ?, CREDIT_APPROVERDATE = ? , CREDIT_REMAKES = ? , CREDIT_APPROVERCODE = ? , CREDIT_APPROVER = ?, CREDIT_STATUS = ?, CREDIT_AMOUNTBAL = ?  WHERE CREDIT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $amountrequested);
		$st->BindParam(2, $days);
		$st->BindParam(3, $desc);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $this->thetwo);
		$st->BindParam(7, $amountrequested);
		$st->BindParam(8, $ekey);
		$activatescheme = $st->execute();		
		if($activatescheme){			
			return $this->thepassed;			
		}else{			
			return $this->thefailed;			
		}
	}
	//8 MAR 2021 JOSEPH ADORBOE	  
	public function requestcredit($form_key,$days,$patientcode,$patientnumber,$patient,$amountrequested,$visitcode,$billcode,$currentusercode,$currentuser,$instcode) : Int
	{
		$sqlstmt = ("SELECT CREDIT_ID FROM octopus_patients_credit where CREDIT_PATIENTCODE = ? and CREDIT_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $this->theone);
		$checkopentill = $st->execute();
		if($checkopentill){
			if($st->rowcount() > 0){			
				return $this->theexisted;				
			}else{	
				$sql = ("INSERT INTO octopus_patients_credit (CREDIT_CODE,CREDIT_DATE,CREDIT_PATIENTCODE,CREDIT_PATIENT,CREDIT_PATIENTNUMBER,CREDIT_VISITCODE,CREDIT_BILLCODE,CREDIT_AMOUNTBAL,CREDIT_CELLINGAMOUNT,CREDIT_AMOUNTUSED,CREDIT_AMTPAID,CREDIT_ACTOR,CREDIT_ACTORCODE,CREDIT_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $visitcode);
				$st->BindParam(7, $billcode);
				$st->BindParam(8, $amountrequested);
				$st->BindParam(9, $amountrequested);
				$st->BindParam(10, $this->thezero);
				$st->BindParam(11, $this->thezero);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$opentill = $st->execute();				
				if($opentill){					
					return $this->thepassed;					
				}else{					
					return $this->thefailed;					
				}
			}
		}else{			
			return $this->thefailed;			
		}	
	}
	// 9 SEPt 2023 
	public function getpatientcreditquery($instcode) : String {
		$list = ("SELECT CREDIT_DATE,CREDIT_CELLINGAMOUNT,CREDIT_AMOUNTUSED,CREDIT_AMTPAID,CREDIT_AMOUNTBAL,CREDIT_DUE,CREDIT_STATUS,CREDIT_AMOUNTUSEDBAL from octopus_patients_credit where CREDIT_STATUS IN('1','2') and CREDIT_INSTCODE = '$instcode' ");
		return 	$list;		
	}
	// 29 AUG 2023,  9 MAR 2021 JOSEPH ADORBOE 
	public function getpatientactivecreditdetails($patientcode,$instcode) : mixed{
		$sqlstmt = ("SELECT CREDIT_DATE,CREDIT_CELLINGAMOUNT,CREDIT_AMOUNTUSED,CREDIT_AMTPAID,CREDIT_AMOUNTBAL,CREDIT_DUE,CREDIT_STATUS,CREDIT_AMOUNTUSEDBAL FROM octopus_patients_credit where CREDIT_INSTCODE = ? and CREDIT_PATIENTCODE = ? and CREDIT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $this->thetwo);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CREDIT_DATE'].'@'.$object['CREDIT_CELLINGAMOUNT'].'@'.$object['CREDIT_AMOUNTUSED'].'@'.$object['CREDIT_AMTPAID'].'@'.$object['CREDIT_AMOUNTBAL'].'@'.$object['CREDIT_DUE'].'@'.$object['CREDIT_STATUS'].'@'.$object['CREDIT_AMOUNTUSEDBAL'];
				return $results;
			}else{
				return $this->theexisted;
			}
		}else{
			return $this->theexisted;
		}			
	}	
	
	// 25 AUG 2023,  8 MAR 2021 JOSEPH ADORBOE 
	public function getpatientcreditdetails($patientcode,$instcode) : mixed{
		$sqlstmt = ("SELECT CREDIT_DATE,CREDIT_CELLINGAMOUNT,CREDIT_AMOUNTUSED,CREDIT_AMTPAID,CREDIT_AMOUNTBAL,CREDIT_DUE,CREDIT_STATUS,CREDIT_VISITCODE,CREDIT_CODE,CREDIT_PATIENTCODE,CREDIT_PATIENT,CREDIT_PATIENTNUMBER,CREDIT_BILLCODE FROM octopus_patients_credit where CREDIT_INSTCODE = ? and CREDIT_PATIENTCODE = ? and ( CREDIT_STATUS = ? or CREDIT_STATUS = ? ) ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $this->thetwo);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CREDIT_DATE'].'@'.$object['CREDIT_CELLINGAMOUNT'].'@'.$object['CREDIT_AMOUNTUSED'].'@'.$object['CREDIT_AMTPAID'].'@'.$object['CREDIT_AMOUNTBAL'].'@'.$object['CREDIT_DUE'].'@'.$object['CREDIT_STATUS'].'@'.$object['CREDIT_VISITCODE'].'@'.$object['CREDIT_CODE'].'@'.$object['CREDIT_PATIENTCODE'].'@'.$object['CREDIT_PATIENT'].'@'.$object['CREDIT_PATIENTNUMBER'].'@'.$object['CREDIT_BILLCODE'];
				return $results;
			}else{
				return $this->theexisted;
			}
		}else{
			return  $this->theexisted;
		}			
	}
	// 8 MAR 2021 JOSEPH ADORBOE 
	public function getpatientcreditstatus($patientcode,$instcode) : Int{
		$sqlstmt = ("SELECT CREDIT_ID FROM octopus_patients_credit where CREDIT_PATIENTCODE = ? and CREDIT_INSTCODE = ? and CREDIT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->thetwo);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return $this->theexisted;
			}else{
				return $this->thezero;
			}

		}else{
			return -1;
		}
			
	}
	
}
$patientcredittable = new OctopusPatientCreditClass(); 
?>