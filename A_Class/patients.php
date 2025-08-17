<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 05 APR 2018
 */
class patients Extends Engine{

	// 15 JUNE 2022 JOSEPH ADORBOE 
	public function getpatientwalletbalancee($patientcode,$prepaidcode,$prepaidchemecode,$instcode){
		$one = 1;
		$typ = 7;
		$sql = "SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_PAYMENTMETHODCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $prepaidcode);
		$st->BindParam(4, $prepaidchemecode);
		$st->BindParam(5, $one);
		$ext = $st->execute();
		if($ext){
			if($st->rowcount() > 0 ){
				$obj = $st->Fetch(PDO::FETCH_ASSOC);	
				$value = $obj['PAY_BALANCE'];				
					return $value;			
			}else{				
					return '0';				
			}

		}else{
			return '0';
		}

		// $num = $st->rowcount();
		// if($num > '0'){
		// 	return '0';
		// }else{
		// 	return '0';
		// }	
	}


	// 19 JUNE 2021
	public function getpatientpayafterservicebillstate($patientcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$instcode){
		$statu = 3;
		$typ = 7;
		$sql = "SELECT * FROM octopus_patients_billitems WHERE B_PATIENTCODE = ? AND B_INSTCODE = ? AND B_PAYMENTTYPE = ? and B_STATE != ? and ( B_PAYMETHODCODE != ? or B_PAYMETHODCODE != ? ) ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $typ);
		$st->BindParam(4, $statu);
		$st->BindParam(5, $cashpaymentmethodcode);
		$st->BindParam(6, $mobilemoneypaymentmethodcode);
		$st->execute();
		$num = $st->rowcount();
		if($num > '0'){
			return '0';
		}else{
			return '1';
		}	
	}


	// 3 MAR 2020
	public function getpatientattachedresults($patientcode,$instcode){
		$statu = '1';
		$typ = 'Labs';
		$sql = "SELECT * FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $typ);
		$st->BindParam(3, $statu);
		$st->execute();
		$num = $st->rowcount();
		if($num == '0'){
			return 'NONE';
		}else{
			return $num;
		}	
	}

	// 3 MAR 2020
	public function getpatientpendinginvestigations($patientcode,$instcode){
		$statu = '1';
		$typ = 'Labs';
		$sql = "SELECT * FROM octopus_patients_investigationrequest WHERE MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? AND MIV_ATTACHED = ?  order by MIV_ID DESC ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $typ);
		$st->BindParam(3, $statu);
		$st->execute();
		$num = $st->rowcount();
		if($num == '0'){
			return 'NONE';
		}else{
			return $num;
		}	
	}

	// 3 MAR 2020
	public function getpatientpendinglabs($patientcode,$instcode){
		$statu = '1';
		$typ = 'Labs';
		$sql = "SELECT * FROM octopus_patients_investigationrequest WHERE MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? AND MIV_TYPE = ? and MIV_STATE = ?  order by MIV_ID DESC ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $typ);
		$st->BindParam(4, $statu);
		$st->execute();
		$num = $st->rowcount();
		if($num == '0'){
			return 'NONE';
		}else{
						return $num;

		}		
		
	}
	
	


	// 3 MAR 2020
	public function getpatientlastvisit($patientcode,$instcode){
		$statu = '1';
		$sql = "SELECT * FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			$obj = $st->Fetch(PDO::FETCH_ASSOC);

			$value = $obj['PATIENT_LASTVISIT'];
			
				return $value;			
			
		}else{
			
				return 'FIRST TIME';
			
		}
	}



	// 3 MAR 2020
	public function getpatientlastservice($patientcode,$instcode){
		$statu = '1';
		$sql = "SELECT * FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			$obj = $st->Fetch(PDO::FETCH_ASSOC);

			$value = $obj['PATIENT_NUMVISITS'];
			
			return $value;
			
		}else{
			
			return 'NONE';
			
		}
	}



	// 3 MAR 2020
	public function getpatientlastreview($patientcode,$instcode){
		$statu = '1';
		$sql = "SELECT * FROM octopus_patients_review WHERE REV_PATIENTCODE = ? AND REV_INSTCODE = ? order by REV_ID DESC LIMIT 1";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			$obj = $st->Fetch(PDO::FETCH_ASSOC);

			$value = $obj['REV_DATE'];
			
			return $value;
			
		}else{
			
			return 'NONE';
			
		}
	}
	
	
	
	// 18 APR 2019
	public function getcashpayment($instcode){
		$statu = 'PC0001';
		$sql = 'SELECT * FROM octopus_paymentscheme WHERE PSC_INSTCODE = ? and PSC_PAYMENTMETHODCODE = ? ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){

			$obj = $st->Fetch(PDO::FETCH_ASSOC);			
			$rt = $obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'];
			
			return $rt;
			
		}else{
			
			return '0';
			
		}
	}
	

	// 17 APR 2019
	public function getpatientyears($theyear,$instcode){
		$statu = '1';
		$sql = 'SELECT YEAR_NAME FROM octopus_patients_years WHERE YEAR_INSTCODE = ? and YEAR_NAME = ?  ';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $theyear);
		$st->execute();
		
		if($st->rowcount() > 0 ){

		//	$obj = $st->Fetch(PDO::FETCH_ASSOC);			
		//	$nextnumber = $obj['SET_PATIENTNUMBERLENGHT'];
			
			return '1';
			
		}else{
			
			return '0';
			
		}
	}
	

	// 17 APR 2019
	public function getpatientnumberlenght($instcode){
		$statu = '1';
		$sql = 'SELECT SET_PATIENTNUMBERLENGHT FROM octopus_settings WHERE SET_INSTCODE = ? AND  SET_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){

			$obj = $st->Fetch(PDO::FETCH_ASSOC);
			
			$nextnumber = $obj['SET_PATIENTNUMBERLENGHT'];
			
			return $nextnumber;
			
		}else{
			
			return '0';
			
		}
	}
	

	// 17 APR 2019
	public function getnextpatientnumber($instcode){
		$statu = '1';
		$sql = 'SELECT SET_NEXTPATIENTNUMBER FROM octopus_settings WHERE SET_INSTCODE = ? AND  SET_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){

			$obj = $st->Fetch(PDO::FETCH_ASSOC);
			
			$nextnumber = $obj['SET_NEXTPATIENTNUMBER'];
			
			return $nextnumber;
			
		}else{
			
			return '0';
			
		}
	}


	// 16 JUNE 2019, 27 JULY 2023
	public function getpatientbirthage($patientbirthdate)
	{	
		$day = date('Y-m-d');		
		$y = 0;
		$yearOnly1 = date('Y', strtotime($patientbirthdate));
		$yearOnly2 = date('Y', strtotime($day));		
		$monthOnly1 = date('m', strtotime($patientbirthdate));
		$monthOnly2 = date('m', strtotime($day));
		$dayOnly1 = date('d', strtotime($patientbirthdate));
		$dayOnly2 = date('d', strtotime($day));
		$yearOnly = $yearOnly2 - $yearOnly1;
		$monthOnly = $monthOnly2 - $monthOnly1;
		$dayOnly = $dayOnly2 - $dayOnly1;
		if($yearOnly>0){
			if($monthOnly<1){
				$m = 1;
				$yr = $yearOnly - 1;
				$y = $yr .' Years';
			}elseif($monthOnly>'0'){
				$y = $yearOnly .' Years';
			}else if($monthOnly=='0'){
				$y = $yearOnly .' Years';;
			}
		}else{
			$y = $monthOnly .'Months';
		}
		return $y;				
	}
		

	// 11 JULY 2018
	public function getpatientpendingbill($patientcode,$userinst){
		$statu = '1';
		$sql = 'SELECT B_ID FROM octopus_bill_items WHERE B_PATIENTCODE = ? AND B_INSTCODE =  ? AND B_STATUS = ?';
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $userinst);
		$st->BindParam(3, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			
			return 0;
			
		}else{
			
			return 1;
			
		}
	}
	
	
	// 11 JULY 2018
	public function getpatientfirstvisit($patientcode,$userinst){
		$sql = "SELECT VISIT_ID FROM octopus_patient_visit WHERE VISIT_PATIENTCODE = ? AND VISIT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $userinst);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			
			return 0;
			
		}else{
			
			return 1;
			
		}
	}
	
	
	// 11 JULY 2018
	public function getpatientactivevisit($patientcode,$userinst){
		$statu = '1';
		$sql = "SELECT VISIT_ID FROM octopus_patient_visit WHERE VISIT_PATIENTCODE = ? AND VISIT_INSTCODE = ?  AND VISIT_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $userinst);
		$st->BindParam(3, $statu);
		$st->execute();
		
		if($st->rowcount() > 0 ){
			
			return 0;
			
		}else{
			
			return 1;
			
		}
	}
	
	
	
	// 29 MAR 2018
	public function getpatientage($patientcode,$userinst)
	{
            
			$sql = " SELECT PATIENT_DOB FROM octopus_patients where PATIENT_CODE = ? and PATIENT_INSTCODE = ?  "; 
			$st = $this->db->prepare($sql);  
			$st->Bindparam(1, $patientcode);
			$st->Bindparam(2, $userinst);
			$st->execute();
			if($st->rowcount() > 0){
			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$dob = $obj['PATIENT_DOB'];
				$day = Date('Y-m-d');
				
				$yearOnly1 = date('Y', strtotime($dob));
				$yearOnly2 = date('Y', strtotime($day));
				$monthOnly1 = date('m', strtotime($dob));
				$monthOnly2 = date('m', strtotime($day));
				$dayOnly1 = date('d', strtotime($dob));
				$dayOnly2 = date('d', strtotime($day));
				$yearOnly = $yearOnly2 - $yearOnly1;
				$monthOnly = $monthOnly2 - $monthOnly1;
				
				return $yearOnly;
						
			}else{

				return '0';

			}
						
        }
		
	 
}
 $pats =  new patients;
