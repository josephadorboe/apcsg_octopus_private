<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 17 SEPT 2022
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class cashierRecieptController Extends Engine
{

	// 30 MARCH 2023  JOSEPH ADORBOE 
	public function changepaymenttype($form_key,$day,$ekey,$totalamount,$newschemecode,$newscheme,$newmethodcode,$newmethod,$currentshiftcode,$currentshift,$methodcode,$method,$schemecode,$scheme,$shiftcode,$shiftname,$changereason,$days,$ownercode,$owner,$currentuser,$currentusercode,$instcode){
		$one =1;
		$zero = '0';
									// update account
				$sql = ("UPDATE octopus_patients_billingpayments SET BPT_METHODCODE = ?, BPT_METHOD = ? , BPT_PAYSCHEMECODE = ? , BPT_PAYSCHEME = ? , BPT_CHANGE = ? , BPT_CHANGEMETHODCODE = ? , BPT_CHANGEMETHOD = ? , BPT_CHANGESCHEMECODE = ? , BPT_CHANGESCHEME = ? , BPT_CHANGEACTORCODE = ? , BPT_CHANGEACTOR = ? , BPT_CHANGESHIFTCODE = ? , BPT_CHANGESHIFT = ? , BPT_CHANGEDATE = ? , BPT_CHANGEREASON = ?  WHERE BPT_CODE = ? AND BPT_INSTCODE = ?  AND BPT_STATUS = ?  ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $newmethodcode);
				$st->BindParam(2, $newmethod);
				$st->BindParam(3, $newschemecode);
				$st->BindParam(4, $newscheme);
				$st->BindParam(5, $one);
				$st->BindParam(6, $methodcode);
				$st->BindParam(7, $method);
				$st->BindParam(8, $schemecode);
				$st->BindParam(9, $scheme);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentshiftcode);
				$st->BindParam(13, $currentshift);
				$st->BindParam(14, $days);
				$st->BindParam(15, $changereason);
				$st->BindParam(16, $ekey);
				$st->BindParam(17, $instcode);
				$st->BindParam(18, $one);
				
				$ext = $st->execute();
				if($ext){

					$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT - ?  where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
					$st = $this->db->prepare($sqlstmts);
					$st->BindParam(1, $totalamount);
					$st->BindParam(2, $shiftcode);
					$st->BindParam(3, $ownercode);
					$st->BindParam(4, $schemecode);
					$st->BindParam(5, $instcode);
					$st->BindParam(6, $one);
					$tills = $st->execute();
					if($tills){
							$sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
							$st = $this->db->prepare($sqlstmt);
							$st->BindParam(1, $shiftcode);
							$st->BindParam(2, $ownercode);
							$st->BindParam(3, $newschemecode);
							$st->BindParam(4, $instcode);
							$st->BindParam(5, $one);
							$tillcheck = $st->execute();
									if ($tillcheck) {
										if ($st->rowcount() >'0') {
											$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ?   where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? AND TILL_TYPE = ? ";
											$st = $this->db->prepare($sqlstmts);
											$st->BindParam(1, $totalamount);
											$st->BindParam(2, $shiftcode);
											$st->BindParam(3, $ownercode);
											$st->BindParam(4, $newschemecode);
											$st->BindParam(5, $instcode);
											$st->BindParam(6, $one);
											$tillsd = $st->execute();
											if ($tillsd) {
												return '2';
											} else {
												return '0';
											}

										} else {

											$sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_SCHEME,TILL_SCHEMECODE,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE,TILL_ALTAMOUNT,TILL_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
												$st = $this->db->prepare($sql);
												$st->BindParam(1, $form_key);
												$st->BindParam(2, $day);
												$st->BindParam(3, $shiftname);
												$st->BindParam(4, $shiftcode);
												$st->BindParam(5, $newmethod);
												$st->BindParam(6, $newmethodcode);
												$st->BindParam(7, $totalamount);
												$st->BindParam(8, $newscheme);
												$st->BindParam(9, $newschemecode);
												$st->BindParam(10, $owner);
												$st->BindParam(11, $ownercode);
												$st->BindParam(12, $instcode);
												$st->BindParam(13, $zero);
												$st->BindParam(14, $one);	
												$opentill = $st->execute();
												if ($opentill) {
													return '2';
												} else {
													return '0';
												}

										}
									}else{
										return '0';
									}

					}else{
						return '0';
					}

					
				}else{
					return '0';
				}
		
	}

	// 19 SEPT 2022   JOSEPH ADORBOE 
	public function cancelreceipt($ekeys,$days,$currentusercode,$currentuser,$reversereason,$instcode){
		$one =1;
		$zero = '0';
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems WHERE B_RECIPTNUM = ? AND B_COMPLETE = ? AND B_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ekeys);
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $one);
		$dt =	$st->execute();
		if ($dt) {
			if ($st->rowcount() <'1') {
				// update account
				$sql = ("UPDATE octopus_patients_reciept SET BP_REVERSEREASON = ?, BP_REVERSEACTOR = ? , BP_REVERSEACTORCODE = ? , BP_REVERSEDATE = ? , BP_STATUS = ?  WHERE BP_CODE = ? AND BP_INSTCODE = ?  AND BP_STATUS = ?  ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $reversereason);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $zero);
				$st->BindParam(6, $ekeys);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $one);
				$ext = $st->execute();
				if($ext){
					return '2';
				}else{
					return '0';
				}
			}
		}		
	}
	
	
	// 17 SEPT 2022 JOSEPH ADORBOE 
	public function reversereceipts($ekeys,$billitemcode,$billdpt,$amt,$billservicecode,$visitcode,$form_key,$prepaidcode,$prepaid,$prepaidchemecode,$prepaidscheme,$days,$day,$patientcode,$patientnumber,$patient,$currentshift,$currentshiftcode,$reversereason,$receiptnumber,$currentusercode,$currentuser,$instcode){

		$one = 1;
		$zero = '0';
		$two = 2;
		$three = 3;	
		if($billdpt == 'LABS'){												
			$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $one);
			$st->BindParam(3, $zero);
			$st->BindParam(4, $billservicecode);
			$st->BindParam(5, $visitcode);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $two);
			$selectitem = $st->Execute();		
		}
		
		if($billdpt == 'SERVICES'){							
			$sql = "UPDATE octopus_patients_servicesrequest SET REQU_SELECTED = ?, REQU_STATUS = ? , REQU_SHOW = ?  WHERE REQU_CODE = ? and REQU_VISITCODE = ? AND REQU_INSTCODE = ? and REQU_SELECTED = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $one);
			$st->BindParam(3, $one);
			$st->BindParam(4, $billservicecode);
			$st->BindParam(5, $visitcode);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $two);
			$selectitem = $st->Execute();			
		}
		
		if($billdpt == 'IMAGING'){								
			$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ? , MIV_STATUS = ? , MIV_SELECTED = ? WHERE MIV_CODE = ? and MIV_VISITCODE = ? AND MIV_INSTCODE = ? and MIV_SELECTED = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $one);
			$st->BindParam(3, $zero);
			$st->BindParam(4, $billservicecode);
			$st->BindParam(5, $visitcode);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $two);
			$selectitem = $st->Execute();				
		}

		if($billdpt == 'PHARMACY'){									
			$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_STATUS = ? , PRESC_SELECTED = ? , PRESC_DISPENSE = ?  WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? AND PRESC_INSTCODE = ? and PRESC_SELECTED = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $one);
			$st->BindParam(3, $zero);
			$st->BindParam(4, $zero);
			$st->BindParam(5, $billservicecode);
			$st->BindParam(6, $visitcode);
			$st->BindParam(7, $instcode);
			$st->BindParam(8, $two);
			$selectitem = $st->Execute();				
		}


		if($billdpt == 'DEVICES'){
			$sql = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_STATUS = ? , PD_SELECTED = ?, PD_DISPENSE = ?  WHERE PD_CODE = ? AND PD_VISITCODE = ? AND PD_INSTCODE = ? and PD_SELECTED = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $one);
			$st->BindParam(3, $zero);
			$st->BindParam(4, $zero);
			$st->BindParam(5, $billservicecode);
			$st->BindParam(6, $visitcode);
			$st->BindParam(7, $instcode);
			$st->BindParam(8, $two);
			$selectitem = $st->Execute();				
		}

		if($billdpt == 'PROCEDURE'){
			$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $one);
			$st->BindParam(3, $zero);
			$st->BindParam(4, $zero);
			$st->BindParam(5, $billservicecode);
			$st->BindParam(6, $visitcode);
			$st->BindParam(7, $instcode);
			$st->BindParam(8, $two);
			$selectitem = $st->Execute();				
		}

		if($billdpt == 'MEDREPORTS'){
			$sql = "UPDATE octopus_patients_medicalreports SET MDR_STATUS = ? , MDR_SELECTED = ? WHERE MDR_CODE = ?  and MDR_SELECTED = ? and MDR_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $zero);
			$st->BindParam(3, $billservicecode);
			$st->BindParam(4, $two);
			$st->BindParam(5, $instcode);
			$selectitem = $st->Execute();				
		}

		if($selectitem){
			$none = '';
			$zero = 0;
			$sql = ("UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ?, B_REVERSEDATE = ?, B_COMPLETE = ?, B_REVERSEACTOR = ?, B_REVERSEACTORCODE = ? WHERE B_CODE = ? AND B_STATE = ? ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $zero);
			$st->BindParam(3, $day);
			$st->BindParam(4, $none);
			$st->BindParam(5, $currentuser);
			$st->BindParam(6, $currentusercode);
			$st->BindParam(7, $billitemcode);
			$st->BindParam(8, $three);
			// $st->BindParam(9, $one);
			// $st->BindParam(10, $none);
			// $st->BindParam(11, $none);
			// $st->BindParam(12, $billitemcode);
			// $st->BindParam(13, $three);
			$updtebilitems = $st->execute();

			if($updtebilitems){	
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
						$st->BindParam(1, $amt);
						$st->BindParam(2, $patientcode);
						$st->BindParam(3, $prepaidchemecode);
						$st->BindParam(4, $instcode);
						$st->BindParam(5, $one);
						$ext = $st->execute();
						if($ext){
							return '2';
						}else{
							return '0';
						}							
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
						$st->BindParam(10, $amt);
						$st->BindParam(11, $none);
						$st->BindParam(12, $instcode);
						$st->BindParam(13, $currentuser);
						$st->BindParam(14, $currentusercode);
						$ext = $st->execute();
						if($ext){
							return '2';
						}else{
							return '0';
						}
					}
				}
			}
		}

		}
		
		
		// $sqlstmt = "SELECT * from octopus_cashier_tills where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		// $st = $this->db->prepare($sqlstmt);
		// $st->BindParam(1, $currentshiftcode);
		// $st->BindParam(2, $currentusercode);
		// $st->BindParam(3, $paycode);
		// $st->BindParam(4, $instcode);
		// $till = $st->execute();
		// if ($till) {
		// 	if ($st->rowcount() >'0') {
		// 		$sqlstmts = "UPDATE octopus_cashier_tills set TILL_AMOUNT = TILL_AMOUNT + ? where TILL_SHIFTCODE = ? and TILL_ACTORCODE = ? and TILL_SCHEMECODE = ?  and TILL_INSTCODE = ? ";
		// 		$st = $this->db->prepare($sqlstmts);
		// 		$st->BindParam(1, $amountpaid);
		// 		$st->BindParam(2, $currentshiftcode);
		// 		$st->BindParam(3, $currentusercode);
		// 		$st->BindParam(4, $paycode);
		// 		$st->BindParam(5, $instcode);
		// 		$tills = $st->execute();
		// 		if ($tills) {
		// 			$bbt = 1;
		// 			$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
		// 			$st = $this->db->prepare($sqlstmtsum);
		// 			$st->BindParam(1, $currentshiftcode);
		// 			$st->BindParam(2, $currentusercode);
		// 			$st->BindParam(3, $instcode);
		// 			$st->BindParam(4, $bbt);
		// 			$cs = $st->execute();
		// 			if ($st->rowcount() >'0') {
		// 				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
		// 				$st = $this->db->prepare($sqlstmtst);
		// 				$st->BindParam(1, $amountpaid);
		// 				$st->BindParam(2, $currentshiftcode);
		// 				$st->BindParam(3, $currentusercode);
		// 				$st->BindParam(4, $bbt);
		// 				$st->BindParam(5, $instcode);
		// 				$dt = $st->execute();
		// 				if ($dt) {
		// 					return '2';
		// 				} else {
		// 					return '0';
		// 				}
		// 			} else {
		// 				$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
		// 				$st = $this->db->prepare($sql);
		// 				$st->BindParam(1, $form_key);
		// 				$st->BindParam(2, $day);
		// 				$st->BindParam(3, $currentshift);
		// 				$st->BindParam(4, $currentshiftcode);
		// 				$st->BindParam(5, $amountpaid);
		// 				$st->BindParam(6, $currentuser);
		// 				$st->BindParam(7, $currentusercode);
		// 				$st->BindParam(8, $instcode);
		// 				$opensummary = $st->execute();
		// 				if ($opensummary) {
		// 					return '2';
		// 				} else {
		// 					return '0';
		// 				}
		// 			}
		// 		} else {
		// 			return '0';
		// 		}
		// 	} else {
		// 		$sql = ("INSERT INTO octopus_cashier_tills (TILL_CODE,TILL_DATE,TILL_SHIFT,TILL_SHIFTCODE,TILL_SCHEME,TILL_SCHEMECODE,TILL_PAYMENTMETHOD,TILL_PAYMENTMETHODCODE,TILL_AMOUNT,TILL_ACTOR,TILL_ACTORCODE,TILL_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
		// 		$st = $this->db->prepare($sql);
		// 		$st->BindParam(1, $form_key);
		// 		$st->BindParam(2, $day);
		// 		$st->BindParam(3, $currentshift);
		// 		$st->BindParam(4, $currentshiftcode);
		// 		$st->BindParam(5, $payname);
		// 		$st->BindParam(6, $paycode);
		// 		$st->BindParam(7, $paymeth);
		// 		$st->BindParam(8, $paymethcode);
		// 		$st->BindParam(9, $amountpaid);
		// 		$st->BindParam(10, $currentuser);
		// 		$st->BindParam(11, $currentusercode);
		// 		$st->BindParam(12, $instcode);
		// 		// $st->BindParam(13, $currentusercode); $,$,$,$
		// 		// $st->BindParam(14, $instcode);
		// 		$opentill = $st->execute();
		// 		if ($opentill) {
		// 			$bbt = 1;
		// 			$sqlstmtsum = "SELECT * from octopus_cashier_summary where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_INSTCODE = ? and CS_STATUS = ? ";
		// 			$st = $this->db->prepare($sqlstmtsum);
		// 			$st->BindParam(1, $currentshiftcode);
		// 			$st->BindParam(2, $currentusercode);
		// 			$st->BindParam(3, $instcode);
		// 			$st->BindParam(4, $bbt);
		// 			$cs = $st->execute();
		// 			if ($st->rowcount() >'0') {
		// 				$sqlstmtst = "UPDATE octopus_cashier_summary set CS_TOTAL = CS_TOTAL + ? where CS_SHIFTCODE = ? and CS_ACTORCODE = ? and CS_STATUS = ?  and CS_INSTCODE = ? ";
		// 				$st = $this->db->prepare($sqlstmtst);
		// 				$st->BindParam(1, $amountpaid);
		// 				$st->BindParam(2, $currentshiftcode);
		// 				$st->BindParam(3, $currentusercode);
		// 				$st->BindParam(4, $bbt);
		// 				$st->BindParam(5, $instcode);
		// 				$dt = $st->execute();
		// 				if ($dt) {
		// 					return '2';
		// 				} else {
		// 					return '0';
		// 				}
		// 			} else {
		// 				$sql = ("INSERT INTO octopus_cashier_summary (CS_CODE,CS_DATE,CS_SHIFT,CS_SHIFTCODE,CS_TOTAL,CS_ACTOR,CS_ACTORCODE,CS_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
		// 				$st = $this->db->prepare($sql);
		// 				$st->BindParam(1, $form_key);
		// 				$st->BindParam(2, $day);
		// 				$st->BindParam(3, $currentshift);
		// 				$st->BindParam(4, $currentshiftcode);
		// 				$st->BindParam(5, $amountpaid);
		// 				$st->BindParam(6, $currentuser);
		// 				$st->BindParam(7, $currentusercode);
		// 				$st->BindParam(8, $instcode);
		// 				$opensummary = $st->execute();
		// 				if ($opensummary) {
		// 					return '2';
		// 				} else {
		// 					return '0';
		// 				}
		// 			}
		// 		} else {
		// 			return '0';
		// 		}
		// 	}
		// } else {
		// 	return '0';
		// }	
	


                                
} 
?>