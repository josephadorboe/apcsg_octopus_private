<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_discounts
	$patientdiscounttable = new OctopusPatientsDiscountSql();
*/

class OctopusPatientsDiscountSql Extends Engine{
	// 30 SEPT 2021 JOSEPH ADORBOE 
	public function getdiscountdetails($idvalue){
		$nut = 2;
		$sqlstmt = ("SELECT PDS_SERVICE,PDS_SERVICEAMOUNT,PDS_DISCOUNTAMOUNT,PDS_DISCOUNT FROM octopus_patients_discounts WHERE PDS_RECEIPTCODE = ? AND PDS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PDS_SERVICE'].'@@'.$object['PDS_SERVICEAMOUNT'].'@@'.$object['PDS_DISCOUNTAMOUNT'].'@@'.$object['PDS_DISCOUNT'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}			
	}	
	// 9 AUG 2023
	Public function newpatientdiscounts($form_key,$patientcode,$patientnumbers,$patient,$visitcode,$days,$servicescode,$servicesname,$discount,$servicecharge,$discountamount,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
		$sqlstmtdiscount = "INSERT INTO octopus_patients_discounts(PDS_CODE,PDS_PATIENTCODE,PDS_PATIENTNUMBER,PDS_PATIENT,PDS_DATE,
		PDS_VISITCODE,PDS_SERVICECODE,PDS_SERVICE,PDS_SERVICEAMOUNT,PDS_DISCOUNTAMOUNT,PDS_DISCOUNT,PDS_ACTOR,PDS_ACTORCODE,PDS_INSTCODE,PDS_DAY,PDS_MONTH,PDS_YEAR) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmtdiscount);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $days);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $servicescode);
		$st->BindParam(8, $servicesname);
		$st->BindParam(9, $servicecharge);
		$st->BindParam(10, $discountamount);
		$st->BindParam(11, $discount);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $currentusercode);
		$st->BindParam(14, $instcode);	
		$st->BindParam(15, $currentday);
		$st->BindParam(16, $currentmonth);
		$st->BindParam(17, $currentyear);							
		$exedx = $st->execute();
		if($exedx){			
			return '2';
		}else{			
			return '0';			
		}
	}
	
	// 29 AUG 2023
	public function updatereceiptdiscount($reciptcode,$patientcode,$instcode)
	{	
		$one = 1;
		$two = 2;	
		$sql = "UPDATE octopus_patients_discounts SET PDS_RECEIPTCODE = ? , PDS_STATUS = ?  WHERE PDS_PATIENTCODE = ? AND  PDS_STATUS = ? AND PDS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $reciptcode);
		$st->BindParam(2, $two);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$recipt = $st->Execute();
		if($recipt){
			return '2';
		}else{
			return '0';
		}		
	}

	

}
$patientdiscounttable = new OctopusPatientsDiscountSql(); 
?>