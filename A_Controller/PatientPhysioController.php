<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 1 MAY 2022
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/


class PatientPhysioController Extends Engine{

	// 04 JUNE 2022   JOSEPH ADORBOE 
	public function checkpatientphysiotreatreatment($visitcode,$patientcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT NOTES_ID  FROM octopus_patients_notes WHERE NOTES_PATIENTCODE = ? AND NOTES_INSTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return '1';
			}
		}else{
			return '1';
		}		
	}	

	// 04 MAY 2022 edittreatmentnotes
	public function update_editpatienttreatment($ekey,$days,$storyline,$currentusercode,$currentuser,$instcode){
		$two = 2;
		$one = 1;
		$sql = "UPDATE octopus_patients_notes SET NOTES_NOTES = ? , NOTES_DATE  = ?,  NOTES_ACTOR = ? , NOTES_ACTORCODE = ?  WHERE NOTES_CODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $storyline);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 6 MAY 2022   JOSEPH ADORBOE
	public function insert_patienttreatmentnotes($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient, $servicerequestedcode, $servicerequested, $storyline, $notesrequestcode, $types, $currentusercode, $currentuser, $instcode){
				
		$sqlstmt = "INSERT INTO octopus_patients_notes(NOTES_CODE,NOTES_NUMBER,NOTES_DATE,NOTES_PATIENTCODE,NOTES_PATIENTNUMBER,NOTES_PATIENT,NOTES_VISITCODE,NOTES_CONSULTATIONCODE,NOTES_AGE,NOTES_GENDER,NOTES_NOTES,NOTES_SERVICECODE,NOTES_SERVICE,NOTES_TYPE,NOTES_INSTCODE,NOTES_ACTOR,NOTES_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $notesrequestcode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $consultationcode);
		$st->BindParam(9, $age);
		$st->BindParam(10, $gender);
		$st->BindParam(11, $storyline);
		$st->BindParam(12, $servicerequestedcode);
		$st->BindParam(13, $servicerequested);
		$st->BindParam(14, $types);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $currentuser);
		$st->BindParam(17, $currentusercode);
		
		$exe = $st->execute();	
		if($exe){					
			return '2';
		}else{
			return '0';
		}
	}

	// 04 MAY 2022 edittreatmentnotes
	public function updatepatientphysio($requestcode,$currentuser,$currentusercode,$instcode){
		$two = 2;
		$one = 1;
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_DOCTOR = ? , REQU_DOCTORCODE = ?  WHERE REQU_CODE = ? and REQU_INSTCODE = ? AND REQU_DOCTORCODE != ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $currentuser);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $requestcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $currentusercode);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 02 MAY 2022 JOSEPH ADORBOE 
	public function update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks){		
		$one = 1;
		$two = 2;
		$three = 3;
		$sql = "UPDATE octopus_patients_servicesrequest SET  REQU_REMARKS = ?, REQU_STATE = ?, REQU_COMPLETE = ? WHERE REQU_CODE = ?  AND REQU_COMPLETE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $remarks);
		$st->BindParam(2, $three);
		$st->BindParam(3, $two);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $one);
		// $st->BindParam(6, $not);
		// $st->BindParam(7, $nnt);
		// $st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	
		if($exe){

			    $but = 2;
                $sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $but);
                $st->BindParam(2, $but);
                $st->BindParam(3, $but);
                $st->BindParam(4, $visitcode);
                $exevisit = $st->execute();

                $sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $one);
                $st->BindParam(2, $visitcode);
                $exeprocedure = $st->execute();

                if ($exevisit  && $exeprocedure) {
                    return '2';
                } else {
                    return '0';
                }				
		}else{								
			return '0';								
		}	
	}

	
	// 02 MAY 2022 JOSEPH ADORBOE 
	public function update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
				
		$one = 1;
		$two = 2;
		$three = 3;
		$sql = "UPDATE octopus_patients_servicesrequest SET  REQU_REMARKS = ?, REQU_STATE = ?, REQU_COMPLETE = ? WHERE REQU_CODE = ?  AND REQU_COMPLETE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $remarks);
		$st->BindParam(2, $three);
		$st->BindParam(3, $two);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();		

		if($exe){

				$but = 2;
				$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $but);
				$st->BindParam(2, $but);
				$st->BindParam(3, $but);
				$st->BindParam(4, $visitcode);
				$exevisit = $st->execute();				

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $one);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();

				if(!empty($patientdate)){

					$sqlstmt = "INSERT INTO octopus_patients_review(REV_CODE,REV_DATE,REV_PATIENTCODE,REV_PATIENTNUM,REV_PATIENT,REV_VISITCODE,REV_NOTES,REV_ACTOR,REV_ACTORCODE,REV_INSTCODE,REV_REQUESTCODE,REV_SERVICE,REV_SERVICECODE,REV_DAY,REV_MONTH,REV_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $patientdate);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patientnumber);
					$st->BindParam(5, $patient);
					$st->BindParam(6, $visitcode);
					$st->BindParam(7, $remarks);
					$st->BindParam(8, $currentuser);
					$st->BindParam(9, $currentusercode);
					$st->BindParam(10, $instcode);
					$st->BindParam(11, $requestcodecode);
					$st->BindParam(12, $servicesed);
					$st->BindParam(13, $servicecode);	
					$st->BindParam(14, $currentday);
					$st->BindParam(15, $currentmonth);
					$st->BindParam(16, $currentyear);			
					$exe = $st->execute();
					$sql = "UPDATE octopus_current SET CU_REVIEWCODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $requestcodecode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$sql = "UPDATE octopus_patients SET PATIENT_REVIEWDATE = ? , PATIENT_SERVICES = ? WHERE PATIENT_CODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $patientdate);
					$st->BindParam(2, $servicesed);
					$st->BindParam(3, $patientcode);
					$exed = $st->execute();	
				}

				if($exevisit && $exeprocedure){
					return '2';
				}else{
					return '0';
				}

		}else{								
			return '0';								
		}	
	}

	
	

	 // 02 MAY 2022 JOSEPH ADORBOE
	 public function enterprocedurereports($ekey, $procedurereport,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
		$not = 2;
		$sql = "UPDATE octopus_patients_procedures SET PPD_REPORTTIME = ?, PPD_REPORTACTOR = ? , PPD_REPORTACTORCODE = ?, PPD_REPORT = ?, PPD_COMPLETE = ?, PPD_DAY = ? , PPD_MONTH = ? , PPD_YEAR = ?  WHERE PPD_CODE = ? and PPD_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $procedurereport);
		$st->BindParam(5, $not);
		$st->BindParam(6, $currentday);
        $st->BindParam(7, $currentmonth);
		$st->BindParam(8, $currentyear);
		$st->BindParam(9, $ekey);
		$st->BindParam(10, $instcode);	
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 02 MAY 2022
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

	// 02 MAY 2022 
	public function update_removepatientprocedure($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?  WHERE PPD_CODE = ?  ";
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

	// 01 MAY 2022  JOSEPH ADORBOE 
	public function getpatientphysioservicedetails($idvalue,$instcode){
		$sqlstmt = ("SELECT REQU_CODE,REQU_VISITCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_PAYMENTTYPE,REQU_DATE FROM octopus_patients_servicesrequest WHERE REQU_CODE = ? AND REQU_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['REQU_CODE'].'@'.$object['REQU_VISITCODE'].'@'.$object['REQU_DATE'].'@'.$object['REQU_PATIENTCODE'].'@'.$object['REQU_PATIENTNUMBER'].'@'.$object['REQU_PATIENT'].'@'.$object['REQU_AGE'].'@'.$object['REQU_GENDER'].'@'.$object['REQU_PAYMENTMETHOD'].'@'.$object['REQU_PAYMENTMETHODCODE'].'@'.$object['REQU_PAYSCHEMECODE'].'@'.$object['REQU_PAYSCHEME'].'@'.$object['REQU_SERVICECODE'].'@'.$object['REQU_SERVICE'].'@'.$object['REQU_PAYMENTTYPE'].'@'.$object['REQU_DATE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
	
	// 1 MAY 2022   JOSEPH ADORBOE
	public function insert_patientphysiovitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$dept,$currentday,$currentmonth,$currentyear){
				
		$sqlstmt = "INSERT INTO octopus_patients_vitals(VID_CODE,VID_PATIENTCODE,VID_PATIENTNUMBER,VID_PATIENT,VID_VISITCODE,VID_AGE,VID_GENDER,VID_BP,VID_TEMPERATURE,VID_HEIGHT,VID_WEIGHT,VID_REMARKS,VID_DEPT,VID_ACTOR,VID_ACTORCODE,VID_INSTCODE,VID_SHIFT,VID_SHIFTCODE,VID_DATE,VID_FBS,VID_RBS,VID_GLUCOSE,VID_PULSE,VID_SPO2,VID_DAY,VID_MONTH,VID_YEAR) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumber);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $age);
		$st->BindParam(7, $gender);
		$st->BindParam(8, $bp);
		$st->BindParam(9, $temperature);
		$st->BindParam(10, $height);
		$st->BindParam(11, $weight);
		$st->BindParam(12, $remarks);
		$st->BindParam(13, $dept);
		$st->BindParam(14, $currentuser);
		$st->BindParam(15, $currentusercode);
		$st->BindParam(16, $instcode);
		$st->BindParam(17, $currentshift);
		$st->BindParam(18, $currentshiftcode);
		$st->BindParam(19, $days);
		$st->BindParam(20, $fbs);
		$st->BindParam(21, $rbs);
		$st->BindParam(22, $glucosetest);
		$st->BindParam(23, $pulse);
		$st->BindParam(24, $spo);
		$st->BindParam(25, $currentday);
		$st->BindParam(26, $currentmonth);
		$st->BindParam(27, $currentyear);
		$exe = $st->execute();	
		if($exe){					
			return '2';
		}else{
			return '0';
		}
	}

	
	// 2 MAY 2022  JOSEPH ADORBOE 
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
				$sqlstmt = "INSERT INTO octopus_patients_procedures(PPD_CODE,PPD_DATE,PPD_PATIENTCODE,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_CONSUTLATIONCODE,PPD_AGE,PPD_GENDER,PPD_VISITCODE,PPD_REMARK,PPD_ACTOR,PPD_ACTORCODE,PPD_INSTCODE,PPD_PROCEDURECODE,PPD_PROCEDURE,PPD_PROCEDURENUMBER,PPD_TYPE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYMENTTYPE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_DAY,PPD_MONTH,PPD_YEAR) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$exe = $st->execute();
				if($exe){
						// $nut = 1;
						// $ut = '0';
						// $sql = "UPDATE octopus_patients_consultations SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
						// $st = $this->db->prepare($sql);
						// $st->BindParam(1, $nut);
						// $st->BindParam(2, $consultationcode);
						// $st->BindParam(3, $ut);						
						// $exe = $st->execute();
						// $sql = "UPDATE octopus_patients_consultations_archive SET CON_PROCEDURE = ?  WHERE CON_CODE = ? and CON_PROCEDURE = ?  ";
						// $st = $this->db->prepare($sql);
						// $st->BindParam(1, $nut);
						// $st->BindParam(2, $consultationcode);
						// $st->BindParam(3, $ut);						
						// $exe = $st->execute();							
						// if($exe){								
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
				// }else{
				// 	return '0';
				// }
			}
		}else{
			return '0';
		}	
	}	
	
	public function updatepatientphysiostate($patientcode,$instcode){
		$two = 2;
		$one = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_PHYSIO = ?  WHERE PATIENT_CODE = ? and PATIENT_INSTCODE = ? AND PATIENT_PHYSIO = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
	//	$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_removepatientcomplains($ekey,$days,$comcode,$comname,$storyline,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_complains SET PPC_STATUS = ?  WHERE PPC_CODE = ?  ";
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
} 
?>