<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 10 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class cashierRefundsController Extends Engine
{

	// 27 MAR 2023 JOSEPH ADORBOE
	public function rejectinvestigationsreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;	
		$zero = '0';	
	

		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_RETURN = ?, MIV_ACTRETURNTIME = ? , MIV_ACTRETURNACTOR = ?, MIV_ACTRETURNACTORCODE = ?  , MIV_ACTRETURNREASON = ?  WHERE MIV_CODE = ? and  MIV_RETURN = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	
	

	// 27 MAR 2023 JOSEPH ADORBOE
	public function approveinvestigationsreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$visitcode,$amount,$paystatus,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode){
		
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$seven = 7;
		$none = 'NA';

		

		if($paymentmethodcode !== $privateinsurancecode && $paymentmethodcode !== $nationalinsurancecode && $paystatus == '2'){

			$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $prepaidchemecode);
			$st->BindParam(4, $one);
			$dt =	$st->execute();
			if ($dt) {
				if ($st->rowcount() >'0') {
					// update account
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $amount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();
										
				}else{
					// insert noe accountt 
					$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $patientnumber);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $day);
					$st->BindParam(6, $prepaidcode);
					$st->BindParam(7, $prepaid);
					$st->BindParam(8, $prepaidchemecode);
					$st->BindParam(9, $prepaidscheme);
					$st->BindParam(10, $amount);
					$st->BindParam(11, $none);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$ext = $st->execute();
					
				}
			}

		}

		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PREFORMED = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $seven);
		$st->BindParam(2, $seven);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();

		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_RETURN = ?, MIV_ACTRETURNTIME = ? , MIV_ACTRETURNACTOR = ?, MIV_ACTRETURNACTORCODE = ?  , MIV_ACTRETURNREASON = ? , MIV_STATUS = ? , MIV_COMPLETE = ?  WHERE MIV_CODE = ? and  MIV_RETURN = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$selectitem = $st->Execute();	

		$sql = ("UPDATE octopus_patients_visit SET VISIT_STATUS = ?, VISIT_COMPLETE = ? WHERE VISIT_CODE = ? AND VISIT_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $two);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
	//	$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();
		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}	

	// 02 OCT 2022   JOSEPH ADORBOE 
	public function rejectservicereturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_ACCRETURNTIME = ? , REQU_ACCRETURNACTOR = ?, REQU_ACCRETURNACTORCODE = ?  , REQU_ACCRETURNREASON = ?  WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	
	


	// 20 NOV 2022   JOSEPH ADORBOE 
	public function approveservicereturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$visitcode,$amount,$paystatus,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode){
		
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$seven = 7;
		$none = 'NA';

		// if($dispense == 2){
		// 	$sqlstmtst = "UPDATE octopus_st_devices set DEV_QTY = DEV_QTY + ? WHERE DEV_CODE = ? AND DEV_STATUS = ?  AND DEV_INSTCODE = ? ";
		// 	$st = $this->db->prepare($sqlstmtst);
		// 	$st->BindParam(1, $qty);
		// 	$st->BindParam(2, $medicationcode);
		// 	$st->BindParam(3, $one);
		// 	$st->BindParam(4, $instcode);
		// 	$dt = $st->execute();
		// }

		if($paymentmethodcode !== $privateinsurancecode && $paymentmethodcode !== $nationalinsurancecode && $paystatus == '2'){

			$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $prepaidchemecode);
			$st->BindParam(4, $one);
			$dt =	$st->execute();
			if ($dt) {
				if ($st->rowcount() >'0') {
					// update account
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $amount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();
										
				}else{
					// insert noe accountt 
					$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $patientnumber);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $day);
					$st->BindParam(6, $prepaidcode);
					$st->BindParam(7, $prepaid);
					$st->BindParam(8, $prepaidchemecode);
					$st->BindParam(9, $prepaidscheme);
					$st->BindParam(10, $amount);
					$st->BindParam(11, $none);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$ext = $st->execute();
					
				}
			}

		}

		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PREFORMED = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $seven);
		$st->BindParam(2, $seven);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();

		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_ACCRETURNTIME = ? , REQU_ACCRETURNACTOR = ?, REQU_ACCRETURNACTORCODE = ?  , REQU_ACCRETURNREASON = ? , REQU_STATUS = ? , REQU_COMPLETE = ?  WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$selectitem = $st->Execute();	

		$sql = ("UPDATE octopus_patients_visit SET VISIT_STATUS = ?, VISIT_COMPLETE = ? WHERE VISIT_CODE = ? AND VISIT_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $two);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
	//	$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();
		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}	


	// 20 NOV 2022 JOSEPH ADORBOE 
	public function gettheserviceamount($requestcode,$patientcode,$instcode){
		$sqlstmt = "SELECT * FROM octopus_patients_billitems WHERE B_SERVCODE = ? AND B_PATIENTCODE = ? AND B_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $requestcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$amt = $st->execute();
		if ($amt) {
			if ($st->rowcount() >'0') {
				$obj =  $st->fetch(PDO::FETCH_ASSOC);
				return $obj['B_TOTAMT'].'@'.$obj['B_STATUS'];				
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}

	// 02 OCT 2022   JOSEPH ADORBOE 
	public function approveprocedurereturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode){
		
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$seven = 7;
		$none = 'NA';

		// if($dispense == 2){
		// 	$sqlstmtst = "UPDATE octopus_st_devices set DEV_QTY = DEV_QTY + ? WHERE DEV_CODE = ? AND DEV_STATUS = ?  AND DEV_INSTCODE = ? ";
		// 	$st = $this->db->prepare($sqlstmtst);
		// 	$st->BindParam(1, $qty);
		// 	$st->BindParam(2, $medicationcode);
		// 	$st->BindParam(3, $one);
		// 	$st->BindParam(4, $instcode);
		// 	$dt = $st->execute();
		// }

		if($paymentmethodcode !== $privateinsurancecode && $paymentmethodcode !== $nationalinsurancecode){

			$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $prepaidchemecode);
			$st->BindParam(4, $one);
			$dt =	$st->execute();
			if ($dt) {
				if ($st->rowcount() >'0') {
					// update account
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $amount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();
										
				}else{
					// insert noe accountt 
					$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $patientnumber);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $day);
					$st->BindParam(6, $prepaidcode);
					$st->BindParam(7, $prepaid);
					$st->BindParam(8, $prepaidchemecode);
					$st->BindParam(9, $prepaidscheme);
					$st->BindParam(10, $amount);
					$st->BindParam(11, $none);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$ext = $st->execute();
					
				}
			}

		}

		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PREFORMED = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $seven);
		$st->BindParam(2, $seven);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();

		$sql = "UPDATE octopus_patients_procedures SET PPD_RETURN = ?, PPD_ACCRETURNTIME = ? , PPD_ACCRETURNACTOR = ?, PPD_ACCRETURNACTORCODE = ?  , PPD_ACCRETURNREASON = ? , PPD_ARCHIVE = ? , PPD_COMPLETE = ?  WHERE PPD_CODE = ? and  PPD_RETURN = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $one);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$selectitem = $st->Execute();	

		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}	


	// 02 OCT 2022   JOSEPH ADORBOE 
	public function rejectproceduresreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$sql = "UPDATE octopus_patients_procedures SET PPD_RETURN = ?, PPD_ACCRETURNTIME = ? , PPD_ACCRETURNACTOR = ?, PPD_ACCRETURNACTORCODE = ? , PPD_ACCRETURNREASON = ?  WHERE PPD_CODE = ? and  PPD_RETURN = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}	

	// 28 SEPT 2022   JOSEPH ADORBOE 
	public function approvedevicesreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$newqty,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode){
		
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$seven = 7;
		$none = 'NA';

		if($dispense == 2){
			$sqlstmtst = "UPDATE octopus_st_devices set DEV_QTY = DEV_QTY + ?, DEV_TOTALQTY = DEV_TOTALQTY + ?, DEV_STOCKVALUE =  DEV_STOCKVALUE + ? WHERE DEV_CODE = ? AND DEV_STATUS = ?  AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sqlstmtst);
			$st->BindParam(1, $qty);
			$st->BindParam(2, $qty);
			$st->BindParam(3, $amount);
			$st->BindParam(4, $medicationcode);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$dt = $st->execute();

		}

		if($paymentmethodcode !== $privateinsurancecode && $paymentmethodcode !== $nationalinsurancecode){

			$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $prepaidchemecode);
			$st->BindParam(4, $one);
			$dt =	$st->execute();
			if ($dt) {
				if ($st->rowcount() >'0') {
					// update account
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $amount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();
										
				}else{
					// insert noe accountt 
					$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $patientnumber);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $day);
					$st->BindParam(6, $prepaidcode);
					$st->BindParam(7, $prepaid);
					$st->BindParam(8, $prepaidchemecode);
					$st->BindParam(9, $prepaidscheme);
					$st->BindParam(10, $amount);
					$st->BindParam(11, $none);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$ext = $st->execute();
					
				}
			}

		}

		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PREFORMED = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $seven);
		$st->BindParam(2, $seven);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();

		$sql = "UPDATE octopus_patients_devices SET PD_RETURN = ?, PD_ACCRETURNTIME = ? , PD_ACCRETURNACTOR = ?, PD_ACCRETURNACTORCODE = ?  , PD_ACCRETURNREASON = ? , PD_ARCHIVE = ? , PD_COMPLETE = ?  WHERE PD_CODE = ? and  PD_RETURN = ? AND PD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $one);
		$st->BindParam(7, $two);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $one);
		$st->BindParam(10, $instcode);
		$selectitem = $st->Execute();	

		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}	


	// 28 SEPT 2022   JOSEPH ADORBOE 
	public function rejectdevicesreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$sql = "UPDATE octopus_patients_devices SET PD_RETURN = ?, PD_ACCRETURNTIME = ? , PD_ACCRETURNACTOR = ?, PD_ACCRETURNACTORCODE = ? , PD_ACCRETURNREASON = ?  WHERE PD_CODE = ? and  PD_RETURN = ? AND PD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}	

	// 25 SEPT 2022   JOSEPH ADORBOE 
	public function approvemedicationreturn($form_key,$ekey,$patientcode,$patientnumber,$patient,$prepaidchemecode,$day,$prepaidcode,$prepaid,$prepaidscheme,$returnreason,$medicationcode,$dispense,$qty,$amount,$newqty,$paymentmethodcode,$days,$privateinsurancecode,$nationalinsurancecode,$currentuser,$currentusercode,$instcode){
		
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$seven = 7;
		$none = 'NA';

		if($dispense == 2){
			$sqlstmtst = "UPDATE octopus_st_medications set MED_QTY = MED_QTY + ? , MED_TOTALQTY = MED_TOTALQTY + ?, MED_STOCKVALUE =  MED_STOCKVALUE + ?  where MED_CODE = ? and MED_STATUS = ? and MED_INSTCODE = ? ";
			$st = $this->db->prepare($sqlstmtst);
			$st->BindParam(1, $qty);
			$st->BindParam(2, $qty);
			$st->BindParam(3, $amount);
			$st->BindParam(4, $medicationcode);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$dt = $st->execute();
		}
		// 
		if($paymentmethodcode !== $privateinsurancecode && $paymentmethodcode !== $nationalinsurancecode ){
			
			
			$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes WHERE PAY_PATIENTCODE = ? AND PAY_INSTCODE = ? AND PAY_SCHEMECODE = ? AND PAY_STATUS = ? ");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $prepaidchemecode);
			$st->BindParam(4, $one);
			$dt =	$st->execute();
			if ($dt) {
				if ($st->rowcount() >'0') {
					// update account
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE + ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $amount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();
										
				}else{
					// insert noe accountt 
					$sql = ("INSERT INTO octopus_patients_paymentschemes (PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_BALANCE,PAY_CARDNUM,PAY_INSTCODE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $patientnumber);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $day);
					$st->BindParam(6, $prepaidcode);
					$st->BindParam(7, $prepaid);
					$st->BindParam(8, $prepaidchemecode);
					$st->BindParam(9, $prepaidscheme);
					$st->BindParam(10, $amount);
					$st->BindParam(11, $none);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$ext = $st->execute();
					
				}
			}

		}
		

		$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_PREFORMED = ? WHERE B_SERVCODE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $seven);
		$st->BindParam(2, $seven);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$updtebilitems = $st->execute();

		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_RETURN = ?, PRESC_ACTRETURNTIME = ? , PRESC_ACTRETURNACTOR = ?, PRESC_ACTRETURNACTORCODE = ?  , PRESC_ACTRETURNREASON = ? , PRESC_ARCHIVE = ? , PRESC_COMPLETE = ?, PRESC_NEWQTY = ?  WHERE PRESC_CODE = ? and  PRESC_RETURN = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $one);
		$st->BindParam(7, $two);
		$st->BindParam(8, $newqty);
		$st->BindParam(9, $ekey);
		$st->BindParam(10, $one);
		$st->BindParam(11, $instcode);
		$selectitem = $st->Execute();	

		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}	

	// 25 SEPT 2022   JOSEPH ADORBOE 
	public function rejectmedicationreturns($ekey,$returnreason,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;	
		$zero = '0';	
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_RETURN = ?, PRESC_ACTRETURNTIME = ? , PRESC_ACTRETURNACTOR = ?, PRESC_ACTRETURNACTORCODE = ? , PRESC_ACTRETURNREASON = ?  WHERE PRESC_CODE = ? and  PRESC_RETURN = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}	


	// 20 SEPT 2022 JOSEPH ADORBOE 
	public function checkcashiertillbalance($currentshiftcode,$cashschemecode,$day,$instcode){

		$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_DATE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $day);
		$st->BindParam(3, $cashschemecode);
		$st->BindParam(4, $instcode);
		$till = $st->execute();
		if ($till) {
			if ($st->rowcount() >'0') {
				$obj =  $st->fetch(PDO::FETCH_ASSOC);
				return $obj['TILL_AMOUNT'];				
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}		

	// 10 SEPT 2022   JOSEPH ADORBOE 
	public function approverefund($ekey,$days,$currentuser,$currentusercode,$instcode){
		$one = 1;	
		$two = 2;		
		$sqlstmts = "UPDATE octopus_patients_refund set REF_APPROVEDATE = ?, REF_APPROVEACTOR = ? , REF_APPROVEACTORCODE = ? , REF_STATUS = ?  where REF_CODE = ? and REF_INSTCODE = ? AND REF_STATUS = ?";
		$st = $this->db->prepare($sqlstmts);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $two);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $one);
		$tills = $st->execute();
		if ($tills) {
			return '2';
		} else {
			return '0';
		}
						
	
	}	

	// 08 SEPT 2022  JOSEPH ADORBOE
	public function saverefunds($form_key,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$refundamount,$refunddescription,$currentusercode,$currentuser,$instcode,$receiptnum,$refundnumber,$prepaidchemecode,$currentday,$currentmonth,$currentyear,$cashschemecode)
	{
        $one = 1;
		$na = 'NA';
		$bal = '0';
        $sql = ("INSERT INTO octopus_patients_refund (REF_CODE,REF_NUMBER,REF_DATE,REF_SHIFTCODE,REF_SHIFT,REF_PATIENTCODE,REF_PATIENTNUMBER,REF_PATIENT,REF_AMOUNT,REF_PURPOSE,REF_AFFECTRECEIPTNUM,REF_ACTOR,REF_ACTORCODE,REF_CURRENTDAY,REF_CURRENTMONTH,REF_CURRENTYEAR,REF_INSTCODE,REF_DAY) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $refundnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentshiftcode);
		$st->BindParam(5, $currentshift);
		$st->BindParam(6, $patientcode);
		$st->BindParam(7, $patientnumber);
		$st->BindParam(8, $patient);
		$st->BindParam(9, $refundamount);
		$st->BindParam(10, $refunddescription);
		$st->BindParam(11, $receiptnum);
		$st->BindParam(12, $currentuser);
		$st->BindParam(13, $currentusercode);
		$st->BindParam(14, $currentday);
		$st->BindParam(15, $currentmonth);
		$st->BindParam(16, $currentyear);
		$st->BindParam(17, $instcode);
		$st->BindParam(18, $day);		
		$genreceipt = $st->execute();

                if ($genreceipt) {
					$sql = ("UPDATE octopus_patients_paymentschemes SET PAY_BALANCE = PAY_BALANCE - ? WHERE PAY_PATIENTCODE = ? AND PAY_SCHEMECODE = ?  AND PAY_INSTCODE = ? AND PAY_STATUS = ? ");
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $refundamount);
					$st->BindParam(2, $patientcode);
					$st->BindParam(3, $prepaidchemecode);
					$st->BindParam(4, $instcode);
					$st->BindParam(5, $one);
					$ext = $st->execute();

					$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT - ? where TILL_SHIFTCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
					$st = $this->db->prepare($sqlstmts);
					$st->BindParam(1, $refundamount);
					$st->BindParam(2, $currentshiftcode);
					$st->BindParam(3, $cashschemecode);
					$st->BindParam(4, $instcode);
				//	$st->BindParam(5, $instcode);
					$tills = $st->execute();

					$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL - ? where CS_SHIFTCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
					$st = $this->db->prepare($sqlstmtst);
					$st->BindParam(1, $refundamount);
					$st->BindParam(2, $currentshiftcode);
					$st->BindParam(3, $one);
					$st->BindParam(4, $instcode);
				//	$st->BindParam(5, $instcode);
					$dt = $st->execute();

					if($ext){
						return '2';
					}else{
						return '0';
					}			
           }else{
				return '0';
			}
       
    }

	// 15 JUNE 2022 JOSEPH ADORBOE 
	public function cashierwallettillsoperations($form_key,$day, $currentshift,$currentusercode,$paycode,$payname,$paymethcode,$paymeth,$amountpaid,$currentuser,$currentshiftcode,$instcode){

		$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentshiftcode);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $paycode);
		$st->BindParam(4, $instcode);
		$till = $st->execute();
		if ($till) {
			if ($st->rowcount() >'0') {
				$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
				$st = $this->db->prepare($sqlstmts);
				$st->BindParam(1, $amountpaid);
				$st->BindParam(2, $currentshiftcode);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $paycode);
				$st->BindParam(5, $instcode);
				$tills = $st->execute();
				if ($tills) {
					$bbt = 1;
					$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
					$st = $this->db->prepare($sqlstmtsum);
					$st->BindParam(1, $currentshiftcode);
					$st->BindParam(2, $currentusercode);
					$st->BindParam(3, $instcode);
					$st->BindParam(4, $bbt);
					$cs = $st->execute();
					if ($st->rowcount() >'0') {
						$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
						$st = $this->db->prepare($sqlstmtst);
						$st->BindParam(1, $amountpaid);
						$st->BindParam(2, $currentshiftcode);
						$st->BindParam(3, $currentusercode);
						$st->BindParam(4, $bbt);
						$st->BindParam(5, $instcode);
						$dt = $st->execute();
						if ($dt) {
							return '2';
						} else {
							return '0';
						}
					} else {
						$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $day);
						$st->BindParam(3, $currentshift);
						$st->BindParam(4, $currentshiftcode);
						$st->BindParam(5, $amountpaid);
						$st->BindParam(6, $currentuser);
						$st->BindParam(7, $currentusercode);
						$st->BindParam(8, $instcode);
						$opensummary = $st->execute();
						if ($opensummary) {
							return '2';
						} else {
							return '0';
						}
					}
				} else {
					return '0';
				}
			} else {
				$sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $currentshift);
				$st->BindParam(4, $currentshiftcode);
				$st->BindParam(5, $payname);
				$st->BindParam(6, $paycode);
				$st->BindParam(7, $paymeth);
				$st->BindParam(8, $paymethcode);
				$st->BindParam(9, $amountpaid);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				// $st->BindParam(13, $currentusercode); $,$,$,$
				// $st->BindParam(14, $instcode);
				$opentill = $st->execute();
				if ($opentill) {
					$bbt = 1;
					$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
					$st = $this->db->prepare($sqlstmtsum);
					$st->BindParam(1, $currentshiftcode);
					$st->BindParam(2, $currentusercode);
					$st->BindParam(3, $instcode);
					$st->BindParam(4, $bbt);
					$cs = $st->execute();
					if ($st->rowcount() >'0') {
						$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
						$st = $this->db->prepare($sqlstmtst);
						$st->BindParam(1, $amountpaid);
						$st->BindParam(2, $currentshiftcode);
						$st->BindParam(3, $currentusercode);
						$st->BindParam(4, $bbt);
						$st->BindParam(5, $instcode);
						$dt = $st->execute();
						if ($dt) {
							return '2';
						} else {
							return '0';
						}
					} else {
						$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $day);
						$st->BindParam(3, $currentshift);
						$st->BindParam(4, $currentshiftcode);
						$st->BindParam(5, $amountpaid);
						$st->BindParam(6, $currentuser);
						$st->BindParam(7, $currentusercode);
						$st->BindParam(8, $instcode);
						$opensummary = $st->execute();
						if ($opensummary) {
							return '2';
						} else {
							return '0';
						}
					}
				} else {
					return '0';
				}
			}
		} else {
			return '0';
		}
	
	}


                                
} 
?>