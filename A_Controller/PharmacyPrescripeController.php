<?php
/*  AUTHOR: JOSEPH ADORBOE
	DATE: 23 APR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PharmacyPrescripeController Extends Engine{

	// 20 APR 2023 JOSEPH ADORBOE
	public function prescriptionpaymentscheme($ekey,$visitcode, $patientcode, $paymentschemecode, $paymentscheme, $paymentmethodcode, $paymethname, $payment, $currentusercode, $currentuser, $instcode){
		$not = 1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_PAYMENTMETHOD = ?, PRESC_PAYMENTMETHODCODE = ? , PRESC_PAYSCHEMECODE = ?, PRESC_PAYSCHEME = ? ,PRESC_PAYMENTTYPE = ? WHERE PRESC_CODE = ? and PRESC_VISITCODE = ? and PRESC_STATE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymethname);
		$st->BindParam(2, $paymentmethodcode);
		$st->BindParam(3, $paymentschemecode);
		$st->BindParam(4, $paymentscheme);
		$st->BindParam(5, $payment);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $not);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 24 SEPT 2022 JOSEPH ADORBOE
	public function returnmedicationrequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_RETURN = ?, PRESC_RETURNTIME = ? , PRESC_RETURNACTOR = ?, PRESC_RETURNACTORCODE = ? , PRESC_RETURNREASON = ?  WHERE PRESC_CODE = ? and  PRESC_RETURN = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}


	// 13 MAR 2022 JOSEPH ADORBOE
	public function editpharamcyarchiveprescription($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_ARCHIVE = ?, PRESC_PROCESSTIME = ? , PRESC_PROCESSACTOR = ?, PRESC_PROCESSACTORCODE = ?  WHERE PRESC_CODE = ? and  PRESC_ARCHIVE = ? AND PRESC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 13 JUN 2021 JOSEPH ADORBOE
	public function editprescriptionqty($ekey,$newqty,$dayscode,$daysname,$currentuser,$currentusercode,$instcode){
		$nt = 1 ;
		$rt = 0 ;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_QUANTITY = ?, PRESC_ACTORCODE = ? , PRESC_ACTOR = ? , PRESC_DAYSCODE = ?, PRESC_DAYS = ? WHERE PRESC_CODE = ? and  PRESC_STATE = ? and  PRESC_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $newqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $dayscode);
		$st->BindParam(5, $daysname);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $nt);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}		
	}

	// 13 JUNE 2021,  JOSEPH ADORBOE
    public function insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$requestcode,$currentusercode,$currentuser,$instcode){
		//die($requestcode);
		$mt = 1;
		$sqlstmt = ("SELECT PRESC_ID FROM octopus_patients_prescriptions where PRESC_PATIENTCODE = ? AND PRESC_VISITCODE = ? AND PRESC_MEDICATIONCODE = ? and PRESC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $medcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{

				$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_DATE,PRESC_DATETIME,PRESC_PATIENTCODE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_CONSULTATIONCODE,PRESC_AGE,PRESC_GENDER,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_ROUTECODE,PRESC_ROUTE,PRESC_QUANTITY,PRESC_STRENGHT,PRESC_INSTRUCTION,PRESC_TYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_CODENUM,PRESC_PAYMENTTYPE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $medcode);
				$st->BindParam(12, $medname);
				$st->BindParam(13, $dosecode);
				$st->BindParam(14, $dose);
				$st->BindParam(15, $freqcode);
				$st->BindParam(16, $freqname);
				$st->BindParam(17, $dayscode);
				$st->BindParam(18, $daysname);
				$st->BindParam(19, $routecode);
				$st->BindParam(20, $routename);
				$st->BindParam(21, $qty);
				$st->BindParam(22, $strenght);
				$st->BindParam(23, $notes);
				$st->BindParam(24, $type);
				$st->BindParam(25, $currentusercode);
				$st->BindParam(26, $currentuser);
				$st->BindParam(27, $instcode);
				$st->BindParam(28, $paymentmethod);
				$st->BindParam(29, $paymentmethodcode);
				$st->BindParam(30, $schemecode);
				$st->BindParam(31, $scheme);
				$st->BindParam(32, $prescriptionrequestcode);
				$st->BindParam(33, $consultationpaymenttype);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_PRECRIPECODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $prescriptionrequestcode);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						$nut = 1;
						$ut = 0;
						$sql = "UPDATE octopus_patients_consultations SET CON_PRESCRIPTION = ? WHERE CON_CODE = ? and CON_PRESCRIPTION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_PRESCRIPTION = ? WHERE CON_CODE = ? and CON_PRESCRIPTION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();

						$sql = "UPDATE octopus_st_medications SET MED_LASTDATE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? AND  MED_STATUS = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $days);
						$st->BindParam(2, $medcode);
						$st->BindParam(3, $instcode);	
						$st->BindParam(4, $nut);						
						$exe = $st->execute();


						if($exe){	
							$swapped = '0';							
							$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATUS = ?, PRESC_SWAPP = ?, PRESC_ACTORCODE = ?, PRESC_ACTOR = ?, PRESC_COMPLETE = ? WHERE PRESC_CODENUM = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $swapped);
							$st->BindParam(2, $requestcode);
							$st->BindParam(3, $currentusercode);
							$st->BindParam(4, $currentuser);
							$st->BindParam(5, $swapped);
							$st->BindParam(6, $requestcode);
							$selectitem = $st->Execute();				
								if($selectitem){
									return '2' ;	
								}else{
									return '0' ;	
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
		}else{
			return '0';
		}	
	}

	

} 
?>