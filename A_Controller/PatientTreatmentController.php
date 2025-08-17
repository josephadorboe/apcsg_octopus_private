<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/
class PatientTreatmentController Extends Engine{

	// 18 JAN 2023 JOSEPH ADORBOE 
	public function update_doctornotes($form_key,$days,$doctorsnotes,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $doctorsnotes);
		$st->BindParam(2, $form_key);
	//	$st->BindParam(3, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 30 MAR 2022 JOSEPH ADORBOE 
	public function update_patientwounddressing($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_DATE = ?, REQU_REMARKS = ?  WHERE REQU_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
		$st->BindParam(3, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 MAR 2022 ,  JOSEPH ADORBOE
    public function insert_patientwounddressing($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$woundservicecode,$woundservicename,$storyline,$wounddressingrequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$serviceamount,$currentusercode,$currentuser,$instcode,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear){
	
		$mt = 1;
		$sqlstmt = ("SELECT REQU_ID FROM octopus_patients_servicesrequest where REQU_PATIENTCODE = ? AND REQU_VISITCODE = ? AND REQU_SERVICECODE = ? AND REQU_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $woundservicecode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR,REQU_REMARKS) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtserv);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $form_key);
			$st->BindParam(4, $days);
			$st->BindParam(5, $patientcode);
			$st->BindParam(6, $patientnumber);
			$st->BindParam(7, $patient);
			$st->BindParam(8, $age);
			$st->BindParam(9, $gender);
			$st->BindParam(10, $paymentmethod);
			$st->BindParam(11, $paymentmethodcode);
			$st->BindParam(12, $schemecode);
			$st->BindParam(13, $scheme);
			$st->BindParam(14, $woundservicecode);
			$st->BindParam(15, $woundservicename);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$st->BindParam(18, $instcode);
			$st->BindParam(19, $currentshiftcode);
			$st->BindParam(20, $currentshift);
			$st->BindParam(21, $mt);
			$st->BindParam(22, $consultationpaymenttype);
			$st->BindParam(23, $consultationpaymenttype);
			$st->BindParam(24, $currentday);
			$st->BindParam(25, $currentmonth);
			$st->BindParam(26, $currentyear);
			$st->BindParam(27, $storyline);
			$exed = $st->execute();	
			
			$rtn = 1;
			$billingitemcode = md5(microtime());
			$dpt = 'SERVICES';
			$seven = 7;
			$cardnumber = 'NA';
			$day = date('Y-m-d');
			$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
			B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
			,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_CARDNUMBER,B_EXPIRYDATE,B_DAY,B_MONTH,B_YEAR) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmtbillsitems);   
			$st->BindParam(1, $billingitemcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $form_key);
			$st->BindParam(4, $days);
			$st->BindParam(5, $days);
			$st->BindParam(6, $patientcode);
			$st->BindParam(7, $patientnumber);
			$st->BindParam(8, $patient);
			$st->BindParam(9, $woundservicename);
			$st->BindParam(10, $woundservicecode);
			$st->BindParam(11, $schemecode);
			$st->BindParam(12, $scheme);
			$st->BindParam(13, $paymentmethod);
			$st->BindParam(14, $paymentmethodcode);
			$st->BindParam(15, $rtn);
			$st->BindParam(16, $serviceamount);
			$st->BindParam(17, $serviceamount);
			$st->BindParam(18, $serviceamount);
			$st->BindParam(19, $currentuser);
			$st->BindParam(20, $currentusercode);
			$st->BindParam(21, $instcode);
			$st->BindParam(22, $currentshiftcode);
			$st->BindParam(23, $currentshift);
			$st->BindParam(24, $form_key);
			$st->BindParam(25, $dpt);
			$st->BindParam(26, $seven);
			$st->BindParam(27, $cardnumber);
			$st->BindParam(28, $day);
			$st->BindParam(29, $currentday);
			$st->BindParam(30, $currentmonth);
			$st->BindParam(31, $currentyear);
			$exedd = $st->execute();
			if($exed){								
				return '2';								
			}else{								
				return '0';								
			}	
				
			}
		}else{
			return '0';
		}	
	}
	

	// 12 SEPT  2021,  JOSEPH ADORBOE
    public function insert_patientaddoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$storyline,$newoxygen,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT OX_ID FROM octopus_st_oxygen where OX_NAME = ? AND OX_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newoxygen);
		$st->BindParam(2, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_oxygen(OX_CODE,OX_NAME,OX_DESC,OX_ACTORCODE,OX_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newoxygen);
				$st->BindParam(3, $newoxygen);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);				
				$exe = $st->execute();
				if($exe){
						$sqlstmt = "INSERT INTO octopus_patients_oxygen(POX_CODE,POX_DATE,POX_PATIENTCODE,POX_PATIENTNUMBER,POX_PATIENT,POX_CONSUTLATIONCODE,POX_AGE,POX_GENDER,POX_VISITCODE,POX_REMARK,POX_ACTOR,POX_ACTORCODE,POX_INSTCODE,POX_OXYGENCODE,POX_OXYGEN) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $days);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patientnumber);
					$st->BindParam(5, $patient);
					$st->BindParam(6, $consultationcode);
					$st->BindParam(7, $age);
					$st->BindParam(8, $gender);
					$st->BindParam(9, $visitcode);
					$st->BindParam(10, $storyline);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $currentusercode);
					$st->BindParam(13, $instcode);
					$st->BindParam(14, $comcode);
					$st->BindParam(15, $newoxygen);
					$exe = $st->execute();
					if($exe){
						$nut = 1;
							$ut = '0';
							$sql = "UPDATE octopus_patients_consultations SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
							$exe = $st->execute();
							$sql = "UPDATE octopus_patients_consultations_archive SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
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
	


	// 12 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddprocedure($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$newprocedure,$storyline,$procedurerequestcode,$procedurecode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
	
		$mt = 1;
		$sqlstmt = ("SELECT MP_ID FROM octopus_st_procedures WHERE MP_NAME = ? AND MP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newprocedure);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_procedures(MP_CODE,MP_NAME,MP_DESC,MP_ACTORCODE,MP_ACTOR,MP_INSTCODE,MP_CODENUM) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newprocedure);
				$st->BindParam(3, $newprocedure);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $procedurecode);
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_procedures(PPD_CODE,PPD_DATE,PPD_PATIENTCODE,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_CONSUTLATIONCODE,PPD_AGE,PPD_GENDER,PPD_VISITCODE,PPD_REMARK,PPD_ACTOR,PPD_ACTORCODE,PPD_INSTCODE,PPD_PROCEDURECODE,PPD_PROCEDURE,PPD_PROCEDURENUMBER,PPD_TYPE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYMENTTYPE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_MONTH,PPD_YEAR,PPD_BILLERCODE,PPD_BILLER) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $days);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patientnumber);
					$st->BindParam(5, $patient);
					$st->BindParam(6, $consultationcode);
					$st->BindParam(7, $age);
					$st->BindParam(8, $gender);
					$st->BindParam(9, $visitcode);
					$st->BindParam(10, $storyline);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $currentusercode);
					$st->BindParam(13, $instcode);
					$st->BindParam(14, $comcode);
					$st->BindParam(15, $newprocedure);
					$st->BindParam(16, $procedurerequestcode);
					$st->BindParam(17, $types);
					$st->BindParam(18, $paymentmethod);
					$st->BindParam(19, $paymentmethodcode);
					$st->BindParam(20, $consultationpaymenttype);
					$st->BindParam(21, $schemecode);
					$st->BindParam(22, $scheme);
					$st->BindParam(23, $currentday);
					$st->BindParam(24, $currentmonth);
					$st->BindParam(25, $currentyear);
					$st->BindParam(26, $currentusercode);
					$st->BindParam(27, $currentuser);
					$exe = $st->execute();
					if($exe){
							$nut = 1;
							$ut = '0';
							$sql = "UPDATE octopus_patients_consultations SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
							$exe = $st->execute();
							$sql = "UPDATE octopus_patients_consultations_archive SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $nut);
							$st->BindParam(2, $consultationcode);
							$st->BindParam(3, $ut);						
							$exe = $st->execute();							
							if($exe){								
								$sql = "UPDATE octopus_current SET CU_PROCEDURECODE = ? , CU_PROCEDURE = ? WHERE CU_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $procedurerequestcode);
								$st->BindParam(2, $procedurecode);
								$st->BindParam(3, $instcode);
								$recipt = $st->Execute();	
								if($recipt){								
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
			}
		}else{
			return '0';
		}	


		$mt = 1;
		$sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures where PPD_PATIENTCODE = ? AND PPD_VISITCODE = ? AND PPD_PROCEDURECODE = ? AND PPD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $comcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
			
			}
		}else{
			return '0';
		}	
	}
	

	// 26 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientoxygen($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT POX_ID FROM octopus_patients_oxygen where POX_PATIENTCODE = ? AND POX_VISITCODE = ? AND POX_OXYGENCODE = ? AND POX_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $comcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_oxygen(POX_CODE,POX_DATE,POX_PATIENTCODE,POX_PATIENTNUMBER,POX_PATIENT,POX_CONSUTLATIONCODE,POX_AGE,POX_GENDER,POX_VISITCODE,POX_REMARK,POX_ACTOR,POX_ACTORCODE,POX_INSTCODE,POX_OXYGENCODE,POX_OXYGEN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $storyline);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $comcode);
				$st->BindParam(15, $comname);
				$exe = $st->execute();
				if($exe){
					$nut = 1;
						$ut = '0';
						$sql = "UPDATE octopus_patients_consultations SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_OXYGEN = ?  WHERE CON_CODE = ? and CON_OXYGEN = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
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
	


	// 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientprocedure($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$comcode,$comname,$storyline,$procedurerequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
	
		$mt = 1;
		$sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures where PPD_PATIENTCODE = ? AND PPD_VISITCODE = ? AND PPD_PROCEDURECODE = ? AND PPD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $comcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_procedures(PPD_CODE,PPD_DATE,PPD_PATIENTCODE,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_CONSUTLATIONCODE,PPD_AGE,PPD_GENDER,PPD_VISITCODE,PPD_REMARK,PPD_ACTOR,PPD_ACTORCODE,PPD_INSTCODE,PPD_PROCEDURECODE,PPD_PROCEDURE,PPD_PROCEDURENUMBER,PPD_TYPE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYMENTTYPE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_DAY,PPD_MONTH,PPD_YEAR,PPD_BILLERCODE,PPD_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $storyline);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $comcode);
				$st->BindParam(15, $comname);
				$st->BindParam(16, $procedurerequestcode);
				$st->BindParam(17, $types);
				$st->BindParam(18, $paymentmethod);
				$st->BindParam(19, $paymentmethodcode);
				$st->BindParam(20, $consultationpaymenttype);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $currentday);
				$st->BindParam(24, $currentmonth);
				$st->BindParam(25, $currentyear);
				$st->BindParam(26, $currentusercode);
				$st->BindParam(27, $currentuser);
				$exe = $st->execute();
				if($exe){
						$nut = 1;
						$ut = '0';
						$sql = "UPDATE octopus_patients_consultations SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();							
						if($exe){								
							$sql = "UPDATE octopus_current SET CU_PROCEDURECODE = ?  WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $procedurerequestcode);
							$st->BindParam(2, $instcode);
							$recipt = $st->Execute();	
							if($recipt){								
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
	


	// 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$servicerequestedcode,$servicerequested,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$doctorsnotes,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT NOTES_ID FROM octopus_patients_notes where NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_NOTES = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $doctorsnotes);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){	
				$sqlstmt = "UPDATE octopus_patients_notes SET NOTES_NOTES = ?  WHERE NOTES_CODE = ? AND NOTES_STATUS =  ? ";    
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $doctorsnotes);
                    $st->BindParam(2, $form_key);
                    $st->BindParam(3, $status);                   
                    $exe = $st->execute();		
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_notes(NOTES_CODE,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_VISITCODE,NOTES_NOTES,NOTES_ACTOR,NOTES_ACTORCODE,NOTES_INSTCODE,NOTES_NUMBER,NOTES_SERVICECODE,NOTES_SERVICE,NOTES_TYPE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $doctorsnotes);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $notesrequestcode);
				$st->BindParam(15, $servicerequestedcode);
				$st->BindParam(16, $servicerequested);
				$st->BindParam(17, $types);
				$exe = $st->execute();
				if($exe){
					$nut = 1;
						$ut = '0';
						$sql = "UPDATE octopus_patients_consultations SET CON_DOCNOTES = ?  WHERE CON_CODE = ? and CON_DOCNOTES = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();	
						
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_DOCNOTES = ?  WHERE CON_CODE = ? and CON_DOCNOTES = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
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
	

	// 25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientmanagementnotes($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$managementnotes,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT NOTES_ID FROM octopus_patients_management where NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_NOTES = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $managementnotes);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_management(NOTES_CODE,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_VISITCODE,NOTES_NOTES,NOTES_ACTOR,NOTES_ACTORCODE,NOTES_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $managementnotes);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
			//	$st->BindParam(14, $currentusercode);
			//	$st->BindParam(15, $instcode);
				$exe = $st->execute();
				if($exe){
					$nut = 1;
						$ut = '0';
						$sql = "UPDATE octopus_patients_consultations SET CON_MANAGEMENT = ?  WHERE CON_CODE = ? and CON_MANAGEMENT = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_MANAGEMENT = ?  WHERE CON_CODE = ? and CON_MANAGEMENT = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
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
	

	// 26 MAR 2021,  JOSEPH ADORBOE
    public function insert_newprocedure($form_key,$procedure,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT MP_ID FROM octopus_st_procedures where MP_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $procedure);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_procedures(MP_CODE,MP_NAME,MP_DESC,MP_ACTORCODE,MP_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $procedure);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
				$exe = $st->execute();
				if($exe){
					return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	}
	
	public function update_patientnotes($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_notes SET NOTES_DATE = ?, NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
	//	$st->BindParam(3, $diagnosisname);
	//	$st->BindParam(4, $storyline);
		$st->BindParam(3, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 26 MAR 2021
	public function update_editpatientprocedure($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_PROCEDURECODE = ?, PPD_PROCEDURE = ?, PPD_REMARK = ?  WHERE PPD_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $comcode);
		$st->BindParam(2, $comname);
		$st->BindParam(3, $storyline);
		$st->BindParam(4, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 01 NOV 2022 JOSEPH ADORBOE 
	public function update_removepatientprocedure($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_RETURNREASON = ?  WHERE PPD_CODE = ?  ";
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

	// 26 MAR 2021,  JOSEPH ADORBOE
    public function insert_newoxygen($form_key,$oxygen,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT OX_ID FROM octopus_st_oxygen where OX_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $oxygen);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_oxygen(OX_CODE,OX_NAME,OX_DESC,OX_ACTORCODE,OX_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $oxygen);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
				$exe = $st->execute();
				if($exe){
					return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	}

	
	// 26 MAR 2021
	public function update_patientmanagement($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_management SET NOTES_DATE = ?, NOTES_NOTES = ?  WHERE NOTES_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
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