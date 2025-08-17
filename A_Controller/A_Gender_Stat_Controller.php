<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 15 AUG 2025
	PURPOSE: shift controller  	
*/

class GenderStatControllerClass Extends Engine{
	

	// 11 NOV 2021 JOSEPH ADORBOE 
	public function getpatientgenderstatsreport($instcode){
		if(empty($_SESSION['genderstat'])){
		$state = 1;
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$details =	$st->execute();
		if($details){
			$totalpatients = $st->rowcount();		
		}else{
			return '0';
		}	
		$malegender = 'Male';
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_GENDER = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $malegender);
		$details =	$st->execute();
		if($details){
			$totalmalepatients = $st->rowcount();		
		}else{
			return '0';
		}	
		$femalegender = 'Female';
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $femalegender);
		$details =	$st->execute();
		if($details){
			$totalfemalepatients = $st->rowcount();		
		}else{
			return '0';
		}

		$day = Date('Y-m-d');		
		// $yearOnly1 = date('Y', strtotime($patientbirthdate));
		// $yearOnly2 = 

		$thisyear = date('Y', strtotime($day));
		$endyearchildern = $thisyear - 16;
		$startyeardatechildern = $thisyear.'-12-31';
		$endyeardatechildren = $endyearchildern.'-01-01';
		
		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardatechildren);
		$st->BindParam(4, $startyeardatechildern);
		$detailss =	$st->execute();
		if($detailss){
			$totalchildrenpatients = $st->rowcount();
			
		}else{
			return '0';
		}	

		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardatechildren);
		$st->BindParam(4, $startyeardatechildern);
		$st->BindParam(5, $malegender);
		$detailss =	$st->execute();
		if($detailss){
			$totalmalechildrenpatients = $st->rowcount();
			
		}else{
			return '0';
		}	

		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardatechildren);
		$st->BindParam(4, $startyeardatechildern);
		$st->BindParam(5, $femalegender);
		$detailss =	$st->execute();
		if($detailss){
			$totalfemalechildrenpatients = $st->rowcount();
			
		}else{
			return '0';
		}	

	
		$startyear = $thisyear - 17;
		$startyeardate = $startyear.'-01-01';
		$endyear = $thisyear - 50;
		$endyeardate = $endyear.'-12-31';
		
		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$detailss =	$st->execute();
		if($detailss){
			$totaladultpatients = $st->rowcount();
			
		}else{
			return '0';
		}

		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$st->BindParam(5, $malegender);
		$detailss =	$st->execute();
		if($detailss){
			$totaladultmalepatients = $st->rowcount();
			
		}else{
			return '0';
		}

		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$st->BindParam(5, $femalegender);
		$detailss =	$st->execute();
		if($detailss){
			$totaladultfemalepatients = $st->rowcount();
			
		}else{
			return '0';
		}

		$startyear = $thisyear - 51;
		$startyeardate = $startyear.'-01-01';
		$endyear = $thisyear - 100;
		$endyeardate = $endyear.'-12-31';
		
		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$detailss =	$st->execute();
		if($detailss){
			$totalelderlypatients = $st->rowcount();
			
		}else{
			return '0';
		}

		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$st->BindParam(5, $malegender);
		$detailss =	$st->execute();
		if($detailss){
			$totaleldermalepatients = $st->rowcount();
			
		}else{
			return '0';
		}

		$aged = 30;
		$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);		
		$st->BindParam(3, $endyeardate);
		$st->BindParam(4, $startyeardate);
		$st->BindParam(5, $femalegender);
		$detailss =	$st->execute();
		if($detailss){
			$totalelderfemalepatients = $st->rowcount();
			
		}else{
			return '0';
		}
			
		$_SESSION['genderstat'] =  $totalpatients.'@'.$totalmalepatients.'@'.$totalfemalepatients.'@'.$totalchildrenpatients.'@'.$totaladultpatients.'@'.$totalelderlypatients.'@'.$totalmalechildrenpatients.'@'.$totalfemalechildrenpatients.'@'.$totaladultmalepatients.'@'.$totaladultfemalepatients.'@'.$totaleldermalepatients.'@'.$totalelderfemalepatients;
	
		return $_SESSION['genderstat']; 

		} else{

		return $_SESSION['genderstat']; 
	}

	}	

} 

	$genderstatcontroller =  new GenderStatControllerClass();
?>