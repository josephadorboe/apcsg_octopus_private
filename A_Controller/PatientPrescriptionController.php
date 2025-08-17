<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientPrescriptionController Extends Engine{

	// 23 JAN 2022 JOSEPH ADORBOE 
	public function update_prescriptionplan($ekey,$prescriptionplan,$description,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_prescriptionplan SET TRP_NAME = ?, TRP_DESC = ? , TRP_ACTOR = ? , TRP_ACTORCODE = ?    WHERE TRP_CODE = ? AND TRP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $prescriptionplan);
		$st->BindParam(2, $description);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medicationnumber,$newmedication,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode){
		//die($days);

		$mt = 1;
		$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications WHERE MED_MEDICATION = ? AND MED_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newmedication);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_MEDICATION,MED_ACTOR,MED_ACTORCODE,MED_CODENUM,MED_INSTCODE) 
				VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newmedication);
				// $st->BindParam(3, $doscode);
				// $st->BindParam(4, $dosname);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $medicationnumber);
				$st->BindParam(6, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_MEDICATIONCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $medicationnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){	
						$dosecode = $dose = '';							
						$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_DATE,PRESC_DATETIME,PRESC_PATIENTCODE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_CONSULTATIONCODE,PRESC_AGE,PRESC_GENDER,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_ROUTECODE,PRESC_ROUTE,PRESC_QUANTITY,PRESC_STRENGHT,PRESC_INSTRUCTION,PRESC_TYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_CODENUM,PRESC_PAYMENTTYPE,PRESC_BILLERCODE,PRESC_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(12, $newmedication);
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
				$st->BindParam(34, $currentusercode);
				$st->BindParam(35, $currentuser);
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
							return '2';								
						}else{								
							return '0';								
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
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	

	}
	
		

	// 28 MAY 2021,  JOSEPH ADORBOE
    public function insert_treatmentplanprescrption($form_key,$patientcode,$patientnumber,$patient,$visitcode,$medicationcode,$medication,$dosageformcode,$dosageformname,$frequencycode,$frequencyname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$desc,$age,$gender,$type,$consultationcode,$paymentmethodcode,$paymentmethod,$schemecode,$scheme,$day,$days,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){
		//die($days);
		$mt = 1;
		$sqlstmt = ("SELECT PRESC_ID FROM octopus_patients_prescriptions where PRESC_PATIENTCODE = ? AND PRESC_VISITCODE = ? AND PRESC_MEDICATIONCODE = ? and PRESC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $medicationcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{

				$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_DATE,PRESC_DATETIME,PRESC_PATIENTCODE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_CONSULTATIONCODE,PRESC_AGE,PRESC_GENDER,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_ROUTECODE,PRESC_ROUTE,PRESC_QUANTITY,PRESC_STRENGHT,PRESC_INSTRUCTION,PRESC_TYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_CODENUM,PRESC_PAYMENTTYPE,PRESC_BILLERCODE,PRESC_BILLER,PRESC_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(11, $medicationcode);
				$st->BindParam(12, $medication);
				$st->BindParam(13, $dosageformcode);
				$st->BindParam(14, $dosageformname);
				$st->BindParam(15, $frequencycode);
				$st->BindParam(16, $frequencyname);
				$st->BindParam(17, $dayscode);
				$st->BindParam(18, $daysname);
				$st->BindParam(19, $routecode);
				$st->BindParam(20, $routename);
				$st->BindParam(21, $qty);
				$st->BindParam(22, $strenght);
				$st->BindParam(23, $desc);
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
				$st->BindParam(34, $currentusercode);
				$st->BindParam(35, $currentuser);
				$st->BindParam(36, $plan);
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
						$sql = "UPDATE octopus_patients_consultations SET CON_PRESCRIPTION = ? WHERE CON_CODE = ?  and CON_PRESCRIPTION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exed = $st->execute();	
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_PRESCRIPTION = ? WHERE CON_CODE = ? and CON_PRESCRIPTION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();	
						$sql = "UPDATE octopus_st_medications SET MED_LASTDATE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? AND  MED_STATUS = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $days);
						$st->BindParam(2, $medicationcode);
						$st->BindParam(3, $instcode);	
						$st->BindParam(4, $nut);						
						$exe = $st->execute();						
						if($exed){								
							return '2';								
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
	


	// 27 MAY 2021 
	public function update_removemedicationfromtreatmentplan($ekey,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ?  WHERE TRM_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 27 MAY 2021 JOSEPH ADORBOE 
	public function update_treatmentplanmedication($ekey,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATIONCODE = ?, TRM_MEDICATION = ?,  TRM_DOSAGEFORMCODE = ?, TRM_DOSAGEFORM =? , TRM_FREQCODE =?, TRM_FREQ =?, TRM_DAYSCODE =?, TRM_DAYS =?, TRM_ROUTECODE =?, TRM_ROUTE =? , TRM_QTY =?, TRM_STRENGHT =?, TRM_DESC =?, TRM_ACTOR =?, TRM_ACTORCODE =? WHERE TRM_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medcode);
		$st->BindParam(2, $medname);
		$st->BindParam(3, $dosecode);
		$st->BindParam(4, $dose);
		$st->BindParam(5, $freqcode);
		$st->BindParam(6, $freqname);
		$st->BindParam(7, $dayscode);
		$st->BindParam(8, $daysname);
		$st->BindParam(9, $routecode);
		$st->BindParam(10, $routename);
		$st->BindParam(11, $qty);
		$st->BindParam(12, $strenght);
		$st->BindParam(13, $notes);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 27 MAY 2021,  JOSEPH ADORBOE
    public function insert_addmedicationtotreatmentplans($form_key,$treatmentplanname,$treatmentplancode,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){
		
		$mt = 1;
		$sqlstmt = ("SELECT TRP_ID FROM octopus_prescriptionplan where TRP_NAME = ? AND TRP_STATUS = ? AND TRP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $treatmentplanname);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $instcode);		
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				
					$ket = md5(microtime());
						$sqlstmt = "INSERT INTO octopus_prescriptionplan_medication(TRM_CODE,TRM_PLANCODE,TRM_MEDICATIONCODE,TRM_MEDICATION,TRM_DOSAGEFORMCODE,TRM_DOSAGEFORM,TRM_FREQCODE,TRM_FREQ,TRM_DAYSCODE,TRM_DAYS,TRM_ROUTECODE,TRM_ROUTE,TRM_QTY,TRM_STRENGHT,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_DESC,TRM_PLAN) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $ket);
					$st->BindParam(2, $treatmentplancode);
					$st->BindParam(3, $medcode);
					$st->BindParam(4, $medname);
					$st->BindParam(5, $dosecode);
					$st->BindParam(6, $dose);
					$st->BindParam(7, $freqcode);
					$st->BindParam(8, $freqname);
					$st->BindParam(9, $dayscode);
					$st->BindParam(10, $daysname);
					$st->BindParam(11, $routecode);
					$st->BindParam(12, $routename);
					$st->BindParam(13, $qty);
					$st->BindParam(14, $strenght);
					$st->BindParam(15, $days);
					$st->BindParam(16, $currentuser);
					$st->BindParam(17, $currentusercode);
					$st->BindParam(18, $instcode);
					$st->BindParam(19, $notes);	
					$st->BindParam(20, $treatmentplanname);						
					$exe = $st->execute();
					if($exe){
						return '2';
					}else{
						return '0';
					}
					
					
			}else{				
				return '1';
			}
		}else{
			return '0';
		}	
	}
	

	// 27 MAY 2021,  JOSEPH ADORBOE
    public function insert_treatmentplans($form_key,$prescriptionplannumber,$treatmentplancode,$treatmentplanname,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){
		
		$mt = 1;
		$sqlstmt = ("SELECT TRP_ID FROM octopus_prescriptionplan where TRP_NAME = ? AND TRP_STATUS = ? AND TRP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $treatmentplanname);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $instcode);		
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{				
				$sqlstmt = "INSERT INTO octopus_prescriptionplan(TRP_CODE,TRP_NAME,TRP_DATES,TRP_ACTOR,TRP_ACTORCODE,TRP_INSTCODE,TRP_NUMBER) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $treatmentplancode);
				$st->BindParam(2, $treatmentplanname);
				$st->BindParam(3, $days);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $prescriptionplannumber);
				$exe = $st->execute();
				$sql = "UPDATE octopus_current SET CU_PRESCRIPTIONPLAN = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $prescriptionplannumber);
					$st->BindParam(2, $instcode);						
					$exetg = $st->execute();
				if($exe){
					$ket = md5(microtime());
						$sqlstmt = "INSERT INTO octopus_prescriptionplan_medication(TRM_CODE,TRM_PLANCODE,TRM_MEDICATIONCODE,TRM_MEDICATION,TRM_DOSAGEFORMCODE,TRM_DOSAGEFORM,TRM_FREQCODE,TRM_FREQ,TRM_DAYSCODE,TRM_DAYS,TRM_ROUTECODE,TRM_ROUTE,TRM_QTY,TRM_STRENGHT,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_DESC,TRM_PLAN) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $ket);
					$st->BindParam(2, $treatmentplancode);
					$st->BindParam(3, $medcode);
					$st->BindParam(4, $medname);
					$st->BindParam(5, $dosecode);
					$st->BindParam(6, $dose);
					$st->BindParam(7, $freqcode);
					$st->BindParam(8, $freqname);
					$st->BindParam(9, $dayscode);
					$st->BindParam(10, $daysname);
					$st->BindParam(11, $routecode);
					$st->BindParam(12, $routename);
					$st->BindParam(13, $qty);
					$st->BindParam(14, $strenght);
					$st->BindParam(15, $days);
					$st->BindParam(16, $currentuser);
					$st->BindParam(17, $currentusercode);
					$st->BindParam(18, $instcode);
					$st->BindParam(19, $notes);	
					$st->BindParam(20, $treatmentplanname);					
					$exe = $st->execute();
					if($exe){
						return '2';
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
	// 27 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientprescription($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$prescriptionrequestcode,$consultationpaymenttype,$plan,$currentusercode,$currentuser,$instcode){
		//die('testio');
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

				$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_DATE,PRESC_DATETIME,PRESC_PATIENTCODE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_CONSULTATIONCODE,PRESC_AGE,PRESC_GENDER,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_ROUTECODE,PRESC_ROUTE,PRESC_QUANTITY,PRESC_STRENGHT,PRESC_INSTRUCTION,PRESC_TYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_CODENUM,PRESC_PAYMENTTYPE,PRESC_BILLERCODE,PRESC_BILLER,PRESC_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(34, $currentusercode);
				$st->BindParam(35, $currentuser);
				$st->BindParam(36, $plan);
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
							return '2';								
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
	
	// 27 MAR 2021,  JOSEPH ADORBOE
    public function insert_newmedication($form_key,$medication,$medicationnumber,$doscode,$dosname,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications where MED_MEDICATION = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $medication);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_ACTOR,MED_ACTORCODE,MED_CODENUM,MED_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $medication);
				$st->BindParam(3, $doscode);
				$st->BindParam(4, $dosname);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $medicationnumber);
				$st->BindParam(8, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_MEDICATIONCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $medicationnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						return '2';								
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
	
	public function update_patientprescription($ekey,$days,$day,$medcode,$medname,$dosecode,$dose,$notes,$type,$freqcode,$freqname,$dayscode,$daysname,$routecode,$routename,$qty,$strenght,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_DATE = ?, PRESC_DATETIME = ?,  PRESC_MEDICATIONCODE = ?, PRESC_MEDICATION =? , PRESC_DOSAGEFORMCODE =?, PRESC_DOSAGEFORM =?, PRESC_FREQUENCYCODE =?, PRESC_FREQUENCY =?, PRESC_DAYSCODE =?, PRESC_DAYS =? , PRESC_ROUTECODE =?, PRESC_ROUTE =?, PRESC_QUANTITY =?, PRESC_STRENGHT =?, PRESC_INSTRUCTION =?, PRESC_ACTORCODE =?, PRESC_ACTOR =?  WHERE PRESC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $day);
		$st->BindParam(2, $days);
		$st->BindParam(3, $medcode);
		$st->BindParam(4, $medname);
		$st->BindParam(5, $dosecode);
		$st->BindParam(6, $dose);
		$st->BindParam(7, $freqcode);
		$st->BindParam(8, $freqname);
		$st->BindParam(9, $dayscode);
		$st->BindParam(10, $daysname);
		$st->BindParam(11, $routecode);
		$st->BindParam(12, $routename);
		$st->BindParam(13, $qty);
		$st->BindParam(14, $strenght);
		$st->BindParam(15, $notes);
		$st->BindParam(16, $currentusercode);
		$st->BindParam(17, $currentuser);
		$st->BindParam(18, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_removepatientprescription($ekey,$cancelreason,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATUS = ?, PRESC_RETURNREASON = ?  WHERE PRESC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
		
} 
?>