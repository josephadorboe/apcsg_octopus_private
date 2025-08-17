<?php
/*
AUTHOR: JOSEPH ADORBOE
DATE: 4 NOV 2017
PURPOSE: TO GENERATE CODES  
*/

class code Extends Engine{

	// 09 SEPT  2022 
	public function getrefundnumber($instcode){
		$sql = "SELECT REF_NUMBER FROM octopus_patients_refund WHERE  REF_INSTCODE = '$instcode'  ORDER BY REF_ID "; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
		//	$obj = $st->fetch(PDO::FETCH_ASSOC);
		//	$valu = $obj['SA_ADJUSTMENTCODE'];
			$valu = $st->rowcount();
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 6 AUG 2022 
	public function getoutcomenumber($instcode){
		return rand(10,99).date('is') ;		
	}
	// 6 AUG 2022 
	public function getstockadjustmentnumber($instcode){
		$sql = "SELECT SA_ADJUSTMENTCODE FROM octopus_pharmacy_stockadjustment WHERE  SA_INSTCODE = '$instcode'  ORDER BY SA_ID "; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
		//	$obj = $st->fetch(PDO::FETCH_ASSOC);
		//	$valu = $obj['SA_ADJUSTMENTCODE'];
			$valu = $st->rowcount();
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 2 JUNE 2022
	public function getservicepartnerdetails($type,$instcode){
	
		$sql = "SELECT * FROM octopus_servicepartners WHERE  COMP_INSTCODE = '$instcode' AND COMP_SERVICECODE = '$type' AND COMP_STATUS = '1'  ORDER BY COMP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['COMP_CODE'].'@'.$obj['COMP_NAME'];			
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 28 MAY 2022
	public function getimagingnumber($instcode){
		$sql = "SELECT SC_CODENUM FROM octopus_st_radiology WHERE  SC_INSTCODE = '$instcode'  ORDER BY SC_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['SC_CODENUM'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 15 JULY 2022 2022
	public function getclaimsnumber($instcode){
		$sql = "SELECT CLAIM_NUMBER FROM octopus_patients_claims WHERE  CLAIM_INSTCODE = '$instcode'  ORDER BY CLAIM_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['CLAIM_NUMBER'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}


	// 28 MAY 2022
	public function getservicepartnername($type,$instcode){
	
		$sql = "SELECT COMP_NAME FROM octopus_servicepartners WHERE  COMP_INSTCODE = '$instcode' AND COMP_SERVICECODE = '$type' AND COMP_STATUS = '1'  ORDER BY COMP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['COMP_NAME'];			
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}
	

	// 06 MAY 2022
	public function getnotesnumber($instcode){
		$sql = "SELECT NOTES_NUMBER FROM octopus_patients_notes WHERE  NOTES_INSTCODE = '$instcode'  ORDER BY NOTES_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['NOTES_NUMBER'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 17 APR 2022
	public function getstoresrequestionnumber($instcode){
		$sql = "SELECT SSU_REQUESTIONNUM FROM octopus_stores_supply WHERE  SSU_INSTCODE = '$instcode'  ORDER BY SSU_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['SSU_REQUESTIONNUM'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}


	// 16 APR 2022
	public function getrequestionnumber($instcode){
		$sql = "SELECT REQ_REQUESTIONNUM FROM octopus_requistions WHERE  REQ_INSTCODE = '$instcode'  ORDER BY REQ_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['REQ_REQUESTIONNUM'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 30 MAR 2022
	public function getwounddressingnumber($instcode){
		$sql = "SELECT WD_NUMBER FROM octopus_patients_wounddressing WHERE  WD_INSTCODE = '$instcode'  ORDER BY WD_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['WD_NUMBER'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}

	// 6 MAR 2022
	public function getbatchnumber($instcode){
		$sql = "SELECT PC_BATCHNUMBER FROM octopus_cashier_partnerbills WHERE  PC_INSTCODE = '$instcode'  ORDER BY PC_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['PC_BATCHNUMBER'];
			$ordernum = $valu + 1;
		}else{			
			$ordernum = 1;			
		}		
		return $ordernum ;		
	}


	// 13 JAN 2022 JOSEPH ADORBOE  
	public function  getlastvisitarchivedetails($lastvisitcode,$patientcode){			
		$sp = 1 ;		
		$sql = "SELECT * FROM octopus_patients_consultations_archive where CON_PATIENTCODE = ? AND CON_VISITCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $lastvisitcode);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['CON_DOCTOR'].'@'.$obj['CON_DATE'].'@'.$obj['CON_COMPLAINT'].'@'.$obj['CON_PHYSIALEXAMS'].'@'.$obj['CON_INVESTIGATION'].'@'.$obj['CON_DIAGNSIS'].'@'.$obj['CON_PRESCRIPTION'].'@'.$obj['CON_DOCNOTES'].'@'.$obj['CON_PROCEDURE'].'@'.$obj['CON_OXYGEN'].'@'.$obj['CON_MANAGEMENT'].'@'.$obj['CON_DEVICES'];			
		}else{			
			$valu = 0;			
		}		
		return $valu ;		
	}

	// 18 JULY 2021 JOSEPH ADORBOE  
	public function  getlastvisitdetails($lastvisitcode,$patientcode){			
		$sp = 1 ;		
		$sql = "SELECT * FROM octopus_patients_consultations_archive where CON_PATIENTCODE = ? AND CON_VISITCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $lastvisitcode);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['CON_DOCTOR'].'@'.$obj['CON_DATE'].'@'.$obj['CON_COMPLAINT'].'@'.$obj['CON_PHYSIALEXAMS'].'@'.$obj['CON_INVESTIGATION'].'@'.$obj['CON_DIAGNSIS'].'@'.$obj['CON_PRESCRIPTION'].'@'.$obj['CON_DOCNOTES'].'@'.$obj['CON_PROCEDURE'].'@'.$obj['CON_OXYGEN'].'@'.$obj['CON_MANAGEMENT'].'@'.$obj['CON_DEVICES'];			
		}else{			
			$valu = 0;			
		}		
		return $valu ;		
	}
	

	// 6 JAN 2021
	public function getnewpatientnumber($instcode){		
		$theyear = date('Y');				
		$sql = "SELECT PYR_SERIAL FROM octopus_patients_year where PYR_YEAR = ? and PYR_INSTCODE = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $theyear);
		$st->BindParam(2, $instcode);
		$ext = $st->execute();
		if($ext){
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = $obj['PYR_SERIAL'];
				$value = $valu + 1;
				$patientnumber = $value.'/'.$theyear;	
				if($instcode == 'HMS1000'){
					$patientnumber = $value.'/OG/'.$theyear;
				}					
			}else{				
				$value = 1;
				$patientnumber = $value.'/'.$theyear;
				if($instcode == 'HMS1000'){
					$patientnumber = $value.'/OG/'.$theyear;
				}					
			}
			return $patientnumber ;
		}else{
			return '0';
		}		
	}

	// 26 MAR 2021
	public function  getlastvisitcode($visitcode,$patientcode){			
		$sp = 1 ;		
		$sql = "SELECT VISIT_CODE FROM octopus_patients_visit where VISIT_PATIENTCODE = ? AND VISIT_CODE != ? order by VISIT_ID DESC limit 1"; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->execute();				
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['VISIT_CODE'];			
		}else{			
			$valu = $visitcode;			
		}		
		return $valu ;		
	}
	

	
	// 6 JUNE 2020
	public function getbillcode($patientcode,$visitcode){			
		
		$sp = 1 ;		
		$sql = "SELECT BILL_CODE FROM octopus_patients_bills where BILL_PATIENTCODE = ? AND BILL_VISITCODE = ? AND BILL_STATUS = ? "; 
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $sp);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = $obj['BILL_CODE'];						
			
		}else{
			
			$valu = '0';
			
		}
		
		return $valu ;
		
	}
	
	
	


	// 7 AUG 2019
	public function getstockadjustmentcode(){
			
		$pre = 'SA';
		$prefix = $pre ;
		
		$sql = "SELECT SA_CODE FROM octopus_pharmacy_stockadjustment ORDER BY SA_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['SA_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 24 APR 2019
	public function billitemsecondcode(){
		$d = date('y');
		$pre = 'BI';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT B_CODE FROM octopus_patients_billitems  ORDER BY B_ID DESC LIMIT 1"; 
		
        $st = $this->db->prepare($sql);
		$st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['B_CODE'],5,20);
			$valu = $valu + 2;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-2';
			
		}
		
		return $ordernum ;
		
	}
	


	// 7 AUG 2019
	public function getroutecode(){
			
		$pre = 'RT';
		$prefix = $pre ;
		
		$sql = "SELECT RT_CODE FROM octopus_st_route ORDER BY RT_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['RT_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}

	// 6 AUG 2019
	public function getphysicalexamcode(){
			
		$pre = 'PE';
		$prefix = $pre ;
		
		$sql = "SELECT PE_CODE FROM octopus_st_physicalexam ORDER BY PE_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PE_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}



	// 27 JULY 2019
	public function getmedicationcode(){
			
		$pre = 'MD';
		$prefix = $pre ;
		
		$sql = "SELECT MED_CODE FROM octopus_st_medications ORDER BY MED_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['MED_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}



	// 27 JULY 2019
	public function getdosageformcode(){
			
		$pre = 'DF';
		$prefix = $pre ;
		
		$sql = "SELECT DF_CODE FROM octopus_st_dosageform ORDER BY DF_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['DF_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}



	// 7 JULY 2019
	public function getnoticescode(){
			
		$pre = 'NTS';
		$prefix = $pre ;
		
		$sql = "SELECT NC_CODE FROM octopus_notices ORDER BY NC_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['NC_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 6 JULY 2019
	public function getpatientreviewcode(){
			
		$pre = 'REV';
		$prefix = $pre ;
		
		$sql = "SELECT REV_CODE FROM octopus_patients_review ORDER BY REV_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['REV_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}

	// 1 JULY 2019
	public function getpatientreciptcode(){
			
		$pre = 'PRC';
		$prefix = $pre ;
		
		$sql = "SELECT BP_CODE FROM octopus_patients_reciept ORDER BY BP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['BP_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}




	// 30 JUNE 2019
	public function getcashierbootcode(){
		
		$pre = 'CSB';
		$prefix = $pre ;
		
		$sql = "SELECT CA_CODE FROM octopus_cashierboots ORDER BY CA_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['CA_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}

	

	// 29 JUNE 2019
	public function phc_shiftcode(){
		
		$pre = 'SFT';
		$prefix = $pre ;
		
		$sql = "SELECT SHIFT_CODE FROM octopus_shifts ORDER BY SHIFT_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['SHIFT_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
}

	
	// 29 JUNE 2019
	public function shifttypecodes(){
		
		$pre = 'SH';
		$prefix = $pre ;
		
		$sql = "SELECT SHT_CODE FROM octopus_admin_shifttypes ORDER BY SHT_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['SHT_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 5 JUNE 2019
	public function patientprocedurescode(){
		
		$pre = 'PD';
		$prefix = $pre ;
		
		$sql = "SELECT PPD_CODE FROM octopus_patients_procedures ORDER BY PPD_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PPD_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}



	// 8 JUNE 2019
	public function setprocedurescode(){
		
		$pre = 'MP';
		$prefix = $pre ;
		
		$sql = "SELECT MP_CODE FROM octopus_st_procedures ORDER BY MP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['MP_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 5 JUNE 2019
	public function patientmedicaldevicecode(){
		
		$pre = 'PD';
		$prefix = $pre ;
		
		$sql = "SELECT MED_CODE FROM octopus_patients_medicaldevices ORDER BY MED_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['MED_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 5 JUNE 2019
	public function setmedicaldevicescode(){
		
			$pre = 'MED';
			$prefix = $pre ;
			
			$sql = "SELECT MD_CODE FROM octopus_st_medicaldevices ORDER BY MD_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['MD_CODE'],4,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
	// 5 JUNE 2019
	public function patientmanagementcode(){
		//	$d = date('y');
			$pre = 'MG';
			$prefix = $pre ;
			
			$sql = "SELECT MAN_CODE FROM octopus_patients_managements ORDER BY MAN_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['MAN_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
	
	
	
	
	
	// 5 JUNE 2019
	public function setroutecode(){
		//	$d = date('y');
			$pre = 'RT';
			$prefix = $pre ;
			
			$sql = "SELECT RT_CODE FROM octopus_st_route ORDER BY RT_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['RT_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}

	// 5 JUNE 2019
	public function setdayscode(){
		//	$d = date('y');
			$pre = 'DY';
			$prefix = $pre ;
			
			$sql = "SELECT DA_CODE FROM octopus_st_days ORDER BY DA_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['DA_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}



	// 5 JUNE 2019
	public function setfrequencycode(){
		//	$d = date('y');
			$pre = 'FR';
			$prefix = $pre ;
			
			$sql = "SELECT FRE_CODE FROM octopus_st_frequency ORDER BY FRE_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['FRE_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}


	// 3 JUNE 2019
	public function setmedicationcode(){
		//	$d = date('y');
			$pre = 'MD';
			$prefix = $pre ;
			
			$sql = "SELECT MED_CODE FROM octopus_st_medications ORDER BY MED_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['MED_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
		



	// 3 JUNE 2019
	public function patientprescriptioncode(){
		//	$d = date('y');
			$pre = 'PRS';
			$prefix = $pre ;
			
			$sql = "SELECT PRESC_CODE FROM octopus_patients_prescriptions ORDER BY PRESC_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['PRESC_CODE'],4,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
		

	// 3 JUNE 2019
	public function setdiagnosiscode(){
		//	$d = date('y');
			$pre = 'DN';
			$prefix = $pre ;
			
			$sql = "SELECT DN_CODE FROM octopus_st_diagnosis ORDER BY DN_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['DN_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
		
	
	
	// 3 JUNE 2019
	public function setcomplaincode(){
		//	$d = date('y');
			$pre = 'CMP';
			$prefix = $pre ;
			
			$sql = "SELECT COMPL_CODE FROM octopus_st_complains ORDER BY COMPL_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['COMPL_CODE'],4,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
		
	// 31 JULY 2020
	/*
	public function #setmedicaldevicescode(){
		//	$d = date('y');
			$pre = 'MED';
			$prefix = $pre ;
			
			$sql = "SELECT MD_CODE FROM octopus_st_medicaldevices ORDER BY MD_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['MD_CODE'],4,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;		
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
		*/
	
	
	
	// 25 MAY 2019
	public function patientinvestigationcode(){
		$d = date('y');
		$pre = 'IN';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT MIV_CODE FROM octopus_patients_investigationrequest ORDER BY MIV_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['MIV_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
	
	
	
	// 25 MAY 2019
	public function investigationtypecode(){
	//	$d = date('y');
		$pre = 'MI';
		$prefix = $pre ;
		
		$sql = "SELECT MI_CODE FROM octopus_st_medivestigation ORDER BY MI_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['MI_CODE'],3,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	

	// 25 MAY 2019
	public function patientdiagnosiscode(){
		$d = date('y');
		$pre = 'DN';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT DIA_CODE FROM octopus_patients_diagnosis ORDER BY DIA_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['DIA_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	


	// 25 MAY 2019
	public function patientphysicalexamcode(){
		$d = date('y');
		$pre = 'PE';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT PHE_CODE FROM octopus_patients_physicalexam ORDER BY PHE_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PHE_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
	// 25 MAY 2019
	public function patientcomplainscode(){
		$d = date('y');
		$pre = 'PC';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT PPC_CODE FROM octopus_patients_presentingcomplains ORDER BY PPC_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PPC_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	

	// 30 april 2018 
	public function patientvitalscode(){
		$d = date('y');
		$pre = 'VT';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT VID_CODE FROM octopus_patients_vitals ORDER BY VID_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['VID_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
	
	// 24 APR 2019
	public function billitemcode(){
		$d = date('y');
		$pre = 'BI';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT B_CODE FROM octopus_patients_billitems  ORDER BY B_ID DESC LIMIT 1"; 
		
        $st = $this->db->prepare($sql);
		$st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['B_CODE'],5,20);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
/*
	// 24 APR 2019
	public function billitemsecondcode(){
		$d = date('y');
		$pre = 'BI';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT B_CODE FROM octopus_patients_billitems  ORDER BY B_ID DESC LIMIT 1"; 
		
        $st = $this->db->prepare($sql);
		$st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['B_CODE'],5,20);
			$valu = $valu + 2;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-2';
			
		}
		
		return $ordernum ;
		
	}
	
	*/


	// 24 APR 2019
	public function pricecode(){
		$d = date('y');
		$pre = 'PC';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT PS_CODE FROM octopus_st_pricing  ORDER BY PS_ID DESC LIMIT 1"; 
		
        $st = $this->db->prepare($sql);
		$st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PS_CODE'],5,20);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
	
	// 22 APR 2019
	public function patientvisitcode(){
		$d = date('y');
		$pre = 'V';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT VISIT_CODE FROM octopus_patients_visit  ORDER BY VISIT_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['VISIT_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	

	// 22 APR 2019
	public function patientservicerequestcode(){
		$d = date('y');
		$pre = 'SR';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT REQU_CODE FROM octopus_patients_servicesrequest  ORDER BY REQU_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['REQU_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
			

	// 22 APR 2019
	public function patientservicerequestsecondcode(){
		$d = date('y');
		$pre = 'SR';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT REQU_CODE FROM octopus_patients_servicesrequest  ORDER BY REQU_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();
                
        if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['REQU_CODE'],5,15);
			$valu = $valu + 2;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-2';
			
		}
		
		return $ordernum ;
		
	}
			
	
	
	
	// 18 APR 2019
	public function patientpaymentcode(){
		$d = date('y');
		$pre = 'PM';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT PAY_CODE FROM octopus_patients_paymentschemes ORDER BY PAY_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PAY_CODE'],5,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}


	// 18 APR 2019
	public function patientpaymentsecondcode(){
		$d = date('y');
		$pre = 'PM';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT PAY_CODE FROM octopus_patients_paymentschemes ORDER BY PAY_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['PAY_CODE'],5,15);
			$valu = $valu + 2;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
		

	// 18 APR 2019
	public function patientemergencycode(){
		$d = date('y');
		$pre = 'E';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT EP_CODE FROM octopus_patients_emergencycontacts ORDER BY EP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['EP_CODE'],4,15);
			$valu = $valu + 1;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	
	
	// 18 APR 2019
	public function patientemergencytwocode(){
		$d = date('y');
		$pre = 'E';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT EP_CODE FROM octopus_patients_emergencycontacts ORDER BY EP_ID DESC LIMIT 1"; 
		$st = $this->db->prepare($sql);
		$st->execute();
				
		if($st->rowcount() > 0){
			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['EP_CODE'],4,15);
			$valu = $valu + 2;
			
			$ordernum = $prefix.'-'.$valu;
		
			
		}else{
			
			$ordernum = $prefix.'-1';
			
		}
		
		return $ordernum ;
		
	}
	


	
	// 17 APR 2019
	public function patientcode(){
			$d = date('y');
			$pre = 'R';
			$prefix = $pre.''.$d ;
			
			$sql = "SELECT PATIENT_CODE FROM octopus_patients ORDER BY PATIENT_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['PATIENT_CODE'],4,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;
			
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
			

	// 14 APR 2019
	public function paymentschemecode(){
		//	$d = date('y');
			$pre = 'PS';
			$prefix = $pre ;
			
			$sql = "SELECT PSC_CODE FROM octopus_paymentscheme ORDER BY PSC_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['PSC_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;
			
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
			


	// 10 APR 2019
	public function loginkeycode(){
		$d = date('y');
		$pre = 'LK';
		$prefix = $pre.''.$d ;
		
		$sql = "SELECT LOGIN_CODE FROM octopus_userlogin ORDER BY LOGIN_ID DESC LIMIT 1"; 
	    $st = $this->db->prepare($sql);
	    $st->execute();                
        if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$valu = substr($obj['LOGIN_CODE'],5,15);
			$valu = $valu + 1;			
			$ordernum = $prefix.'-'.$valu;		
		}else{			
			$ordernum = $prefix.'-1';			
		}		
		return $ordernum ;		
	}
	
		

	// 10 APR 2019
	public function usercode(){
		//	$d = date('y');
			$pre = 'US';
			$prefix = $pre ;
			
			$sql = "SELECT USER_CODE FROM octopus_user ORDER BY USER_ID DESC LIMIT 1"; 
			$st = $this->db->prepare($sql);
			$st->execute();
					
			if($st->rowcount() > 0){
				
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$valu = substr($obj['USER_CODE'],3,15);
				$valu = $valu + 1;
				
				$ordernum = $prefix.'-'.$valu;
			
				
			}else{
				
				$ordernum = $prefix.'-1';
				
			}
			
			return $ordernum ;
			
		}
			

	// 9 APR 2019, JOSEPH ADORBOE , 
	public function institutioncode(){
		$prefix = 'INT';
		$sql = "SELECT CP_CODE FROM octopus_admin_institution ORDER BY CP_ID DESC LIMIT 1"; 
        $st = $this->db->prepare($sql);   
        $st->execute();
                
        if($st->rowcount() > 0){
			
        $obj = $st->fetch(PDO::FETCH_ASSOC);
        $valu = substr($obj['CP_CODE'],3,6);
		$valu = $valu + 1;
		if(strlen($valu) == 1){
			
			$ordernum = $prefix.'000'.$valu;
			
		}else if(strlen($valu) == 2){
			
			$ordernum = $prefix.'00'.$valu;
			
		}else if(strlen($valu) == 3){
			
			$ordernum = $prefix.'0'.$valu;
			
		}else if(strlen($valu) == 4){
			
			$ordernum = $prefix.''.$valu;
		}	
        	
        }else{
			
            $ordernum = $prefix.'0001';
        }
		
        return $ordernum;
    }
     
	
	
	
    
	
}
