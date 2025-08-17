<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 17 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	insert_newdevice($form_key,$newdevices,$description,$currentusercode,$currentuser,$instcode)
*/

class ConsultationController Extends Engine{

	//  12 JUNE 2023 JOSEPH ADORBOE 
	public function update_patientdietvitals($ekey,$days,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_vitals_diet SET VID_BOBYFAT = ? ,VID_MUSCLEMASS = ? ,VID_HEIGHT = ? ,VID_WEIGHT = ? ,VID_VISCERALFAT = ? ,VID_BMI = ? ,VID_METABOLICRATE = ? ,VID_HIP = ? ,VID_WAIST = ? ,VID_HIPTOWAIST = ? WHERE VID_CODE = ? AND VID_STATUS =  ? AND VID_INSTCODE = ?";    
		$st = $this->db->prepare($sqlstmt); 
		$st->BindParam(1, $bodyfat);
		$st->BindParam(2, $musclefat);
		$st->BindParam(3, $height);
		$st->BindParam(4, $weight);
		$st->BindParam(5, $visceralfat);
		$st->BindParam(6, $bmi);
		$st->BindParam(7, $metabolicrate);
		$st->BindParam(8, $hipcircumfernce);
		$st->BindParam(9, $waistcircumfernce);
		$st->BindParam(10, $waisthips);  
		$st->BindParam(11, $ekey);
		$st->BindParam(12, $one);
		$st->BindParam(13, $instcode);                                  
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 12 JUNE 2023  JOSEPH ADORBOE
	public function insert_patientdietvitals($form_key,$days,$visitcode,$age,$gender,$patientcode, $patientnumber,$patient,$bodyfat,$musclefat,$visceralfat,$bmi,$metabolicrate,$hipcircumfernce,$waistcircumfernce,$waisthips,$height,$weight,$vitalsnumber,$currentshift,$currentshiftcode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
		$one = 1;
		$sqlstmt = "INSERT INTO octopus_patients_vitals_diet(VID_CODE,VID_NUMBER,VID_DATE,VID_PATIENTCODE,VID_PATIENTNUMBER,VID_PATIENT,VID_VISITCODE,VID_AGE,VID_GENDER,VID_ACTOR,VID_ACTORCODE,VID_INSTCODE,VID_BOBYFAT,VID_MUSCLEMASS,VID_HEIGHT,VID_WEIGHT,VID_VISCERALFAT,VID_BMI,VID_METABOLICRATE,VID_HIP,VID_WAIST,VID_HIPTOWAIST,VID_SHIFT,VID_SHIFTCODE,VID_DAY,VID_MONTH,VID_YEAR) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $vitalsnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $visitcode);
		$st->BindParam(8, $age);
		$st->BindParam(9, $gender);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$st->BindParam(12, $instcode);
		$st->BindParam(13, $bodyfat);
		$st->BindParam(14, $musclefat);
		$st->BindParam(15, $height);
		$st->BindParam(16, $weight);
		$st->BindParam(17, $visceralfat);
		$st->BindParam(18, $bmi);
		$st->BindParam(19, $metabolicrate);
		$st->BindParam(20, $hipcircumfernce);
		$st->BindParam(21, $waistcircumfernce);
		$st->BindParam(22, $waisthips);
		$st->BindParam(23, $currentshift);  
		$st->BindParam(24, $currentshiftcode);  
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


	//  14 OCT 2021 JOSEPH ADORBOE 
	public function update_patientreferal($ekey,$days,$history,$finding,$provisionaldiagnosis,$treatementgiven,$reasonreferal,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_referal SET RF_HISTORY = ? ,RF_FINDINGS = ? ,RF_DIAGNOSIS = ? ,RF_TREATMENT = ? ,RF_REMARKS = ? WHERE RF_CODE = ? AND RF_STATUS =  ? AND RF_INSTCODE = ?";    
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $history);
		$st->BindParam(2, $finding);
		$st->BindParam(3, $provisionaldiagnosis);
		$st->BindParam(4, $treatementgiven);
		$st->BindParam(5, $reasonreferal);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);                                  
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

		// 19 MAR 2023  JOSEPH ADORBOE
		public function insert_patientreferal($form_key, $days, $consultationcode, $visitcode, $age, $gender, $patientcode, $patientnumber, $patient,$history,$finding,$provisionaldiagnosis,
		$treatementgiven,$reasonreferal,$vitalscode,$intro,$referalnumber,$currentusercode, $currentuser, $instcode, $currentday, $currentmonth, $currentyear){

			$days = Date('Y-m-d H:i:s');
			$one = 1;
            $sqlstmt = " SELECT * FROM octopus_patients_referal WHERE RF_CODE = ? AND  RF_STATUS = ? AND RF_INSTCODE = ? "; 
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $one);
			$st->BindParam(3, $instcode);
			$check = $st->execute();
            if($check){
                if($st->rowCount()> '0'){
                    $status = 1;
                    $sqlstmt = "UPDATE octopus_patients_referal SET RF_HISTORY = ? ,RF_FINDINGS = ? ,RF_DIAGNOSIS = ? ,RF_TREATMENT = ? ,RF_REMARKS = ? WHERE RF_CODE = ? AND RF_STATUS =  ? AND RF_INSTCODE = ?";    
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $history);
                    $st->BindParam(2, $finding);
                    $st->BindParam(3, $provisionaldiagnosis);
                    $st->BindParam(4, $treatementgiven);
                    $st->BindParam(5, $reasonreferal);
                    $st->BindParam(6, $form_key);
                    $st->BindParam(7, $status);
                    $st->BindParam(8, $instcode);                                  
                    $exe = $st->execute();
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}	

                }else{
                    $referalnumber = date("his");
                    $sqlstmt = "INSERT INTO octopus_patients_referal(RF_CODE,RF_NUMBER,RF_DATE,RF_PATIENTCODE,RF_PATIENTNUM,RF_PATIENT,RF_CONSULTATIONNUM,RF_AGE,RF_GENDER,RF_VISITCODE,RF_ACTOR,RF_ACTORCODE,RF_INSTCODE,RF_DAY,RF_MONTH,RF_YEAR,RF_VITALSNUM,RF_INTRO,RF_HISTORY,RF_FINDINGS,RF_DIAGNOSIS,RF_TREATMENT,RF_REMARKS) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                    $st = $this->db->prepare($sqlstmt);   
                    $st->BindParam(1, $form_key);
                    $st->BindParam(2, $referalnumber);
                    $st->BindParam(3, $days);
                    $st->BindParam(4, $patientcode);
                    $st->BindParam(5, $patientnumber);
                    $st->BindParam(6, $patient);
                    $st->BindParam(7, $consultationcode);
                    $st->BindParam(8, $age);
                    $st->BindParam(9, $gender);
                    $st->BindParam(10, $visitcode);
                    $st->BindParam(11, $currentuser);
                    $st->BindParam(12, $currentusercode);
                    $st->BindParam(13, $instcode);
                    $st->BindParam(14, $currentday);
                    $st->BindParam(15, $currentmonth);
                    $st->BindParam(16, $currentyear);
                    $st->BindParam(17, $vitalscode);
                    $st->BindParam(18, $intro);
                    $st->BindParam(19, $history);
                    $st->BindParam(20, $finding);
                    $st->BindParam(21, $provisionaldiagnosis);
                    $st->BindParam(22, $treatementgiven);
                    $st->BindParam(23, $reasonreferal);                 
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
		

	// 18 Jan 2023 JOSEPH ADORBOE 
	public function getpatientdoctorsnotesdet($complainid,$patientcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_notes WHERE NOTES_CODE = ? AND NOTES_PATIENTCODE = ? AND NOTES_VISITCODE = ? AND NOTES_INSTCODE = ? AND NOTES_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $complainid);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
	//	$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['NOTES_CODE'].'@'.$object['NOTES_NOTES'].'@'.$object['NOTES_TYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 09 AUG  2022 JOSEPH ADORBOE 
	public function getreviewdata($patientcode,$visitcode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_review WHERE REV_PATIENTCODE = ? AND REV_VISITCODE = ? AND REV_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['REV_DATE'].'@'.$object['REV_SERVICE'].'@'.$object['REV_ACTOR'];
				return $results;
			}else{
				return '1';
			}
		}else{
			return '1';
		}			
	}	

	// 14 JUNE 2022  JOSEPH ADORBOE 
	public function getdoctorpastedconsulationstatus($currentusercode,$day,$instcode){
		$one  = 1 ; 
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations WHERE DATE(CON_DATE) != ? AND CON_COMPLETE = ? AND CON_DOCTORCODE = ? AND CON_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $day);
		$st->BindParam(2, $one);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){			
				return '2';
			}else{
				return'1';
			}
		}else{
			return '1';
		}			
	}	

	// // 10 APR 2022 JOSEPH ADORBOE 
	// public function getpatientallegystatus($patientcode,$instcode){
	// 	$nu = 0;
	// 	$allergy = ("SELECT * FROM octopus_patients_allergy WHERE ALG_PATIENTCODE = '$patientcode' AND ALG_INSTCODE = '$instcode' AND ALG_STATUS = '1' ORDER BY ALG_ID DESC ");
	// 	$getallergy = $this->db->query($allergy);
	// 	while ($rowd = $getallergy->fetch(PDO::FETCH_ASSOC)) {
	// 		echo $rowd['ALG_ALLERGY'].' , ';
	// 	}
	// 	//return $ret;	
	// }

	//getpatientcomplainsdet($complainid,$patientcode,$visitcode,$instcode)

	// 29 MAY 2022 JOSEPH ADORBOE 
	public function getpatientcomplainsdet($complainid,$patientcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_complains WHERE PPC_CODE = ? AND PPC_PATIENTCODE = ? AND PPC_VISITCODE = ? AND PPC_INSTCODE = ? AND PPC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $complainid);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
	//	$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PPC_COMPLAINCODE'].'@'.$object['PPC_COMPLAIN'].'@'.$object['PPC_HISTORY'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	
	

	//11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientallegystatus($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_allergy WHERE ALG_PATIENTCODE = ? AND ALG_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){			
				return '2';
			}else{
				return'1';
			}
		}else{
			return '1';
		}			
	}	

	// 12 FEB 2022 JOSEPH ADORBOE 
	public function getpatientfolderconsultationdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'].'@'.$object['CON_ACTION'].'@'.$object['CON_ACTIONCODE'].'@'.$object['CON_ACTIONDATE'].'@'.$object['CON_DOCTOR'].'@'.$object['CON_DOCTORCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 23 JAN 2022 JOSEPH ADORBOE 
	public function getprescriptionplandetails($plancode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_prescriptionplan WHERE TRP_CODE = ? AND TRP_INSTCODE = ? AND TRP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $plancode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['TRP_CODE'].'@'.$object['TRP_NUMBER'].'@'.$object['TRP_NAME'];
				return $results;
			}else{
				return '1';
			}
		}else{
			return '0';
		}			
	}	

	// 23 JAN 2022 JOSEPH ADORBOE 
	public function getlabplandetails($plancode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_labplans WHERE LP_CODE = ? AND LP_INSTCODE = ? AND LP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $plancode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['LP_CODE'].'@'.$object['LP_CODENUM'].'@'.$object['LP_NAME'].'@'.$object['LP_CATEGORY'];
				return $results;
			}else{
				return '1';
			}
		}else{
			return '0';
		}			
	}	


	//  22 JAN 2022  JOSEPH ADORBOE 
	public function update_patientmedicalreportssingle($ekey,$days,$storyline,$addressedto,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_medicalreports SET MDR_DATE = ?, MDR_REPORT = ? , MDR_ADDRESS = ? ,MDR_ACTOR = ? , MDR_ACTORCODE = ? WHERE MDR_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $storyline);
		$st->BindParam(3, $addressedto);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationarchivedetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 14 OCT 2021 JOSEPH ADORBOE 
	public function getpatientpendingmedicalreport($patientcode,$instcode){
		$nut = '0';
		$sqlstmt = ("SELECT * FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = ? AND MDR_INSTCODE = ? AND MDR_ISSUED = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	


	//  14 OCT 2021 JOSEPH ADORBOE 
	public function update_patientmedicalreports($ekey,$days,$servicetypecode,$servicetypename,$storyline,$addressedto,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_medicalreports SET MDR_DATE = ?, MDR_SERVICECODE = ?,  MDR_SERVICE = ?, MDR_REPORT = ? , MDR_ADDRESS = ? ,MDR_ACTOR = ? , MDR_ACTORCODE = ? WHERE MDR_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $servicetypecode);
		$st->BindParam(3, $servicetypename);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $addressedto);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $currentusercode);
		$st->BindParam(8, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 13 OCT 2021,  JOSEPH ADORBOE
    public function insert_patientmedicalreport($form_key,$days,$requestnumber,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$servicereqcode,$servicereqname,$addressedto,$diagnosiscode,$diagnosisname,$diagnosistype,$storyline,$serviceamount,
	$servicerequestcode,$servicebillcode,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentday,$currentmonth,$currentyear,$currentuser,$instcode,$currentuserspec){
		$cash = 'CASH';
		$mt = 1;
		$zero = '0';
		$sqlstmt = ("SELECT MDR_ID FROM octopus_patients_medicalreports WHERE MDR_PATIENTCODE = ? AND  MDR_INSTCODE = ? AND MDR_SERVICECODE = ? AND MDR_SELECTED = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $servicereqcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{				
				$sqlstmt = "INSERT INTO octopus_patients_medicalreports(MDR_CODE,MDR_DATE,MDR_PATIENTCODE,MDR_PATIENTNUMBER,MDR_PATIENT,MDR_CONSULTATIONCODE,MDR_AGE,MDR_GENDER,MDR_VISITCODE,MDR_SERVICECODE,MDR_SERVICE,MDR_REPORT,MDR_ACTOR,MDR_ACTORCODE,MDR_INSTCODE,MDR_ADDRESS,MDR_REQUESTNUMBER,MDR_DIAGNOSISCODE,MDR_DIAGNOSIS,MDR_DIAGNOSISTYPE,MDR_ACTORTITLE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
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
				$st->BindParam(10, $servicereqcode);
				$st->BindParam(11, $servicereqname);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $addressedto);
				$st->BindParam(17, $requestnumber);
				$st->BindParam(18, $diagnosiscode);
				$st->BindParam(19, $diagnosisname);
				$st->BindParam(20, $diagnosistype);
				$st->BindParam(21, $currentuserspec);
				$exe = $st->execute();

				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT,REQU_VISITTYPE,REQU_PAYMENTTYPE,REQU_SHOW,REQU_DAY,REQU_MONTH,REQU_YEAR) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                $st = $this->db->prepare($sqlstmtserv);
                $st->BindParam(1, $servicerequestcode);
                $st->BindParam(2, $visitcode);
                $st->BindParam(3, $servicebillcode);
                $st->BindParam(4, $days);
                $st->BindParam(5, $patientcode);
                $st->BindParam(6, $patientnumber);
                $st->BindParam(7, $patient);
                $st->BindParam(8, $age);
                $st->BindParam(9, $gender);
                $st->BindParam(10, $cash);
                $st->BindParam(11, $cashpaymentmethodcode);
                $st->BindParam(12, $cashschemecode);
                $st->BindParam(13, $cash);
                $st->BindParam(14, $servicereqcode);
                $st->BindParam(15, $servicereqname);
                $st->BindParam(16, $currentuser);
                $st->BindParam(17, $currentusercode);
                $st->BindParam(18, $instcode);
                $st->BindParam(19, $currentshiftcode);
                $st->BindParam(20, $currentshift);
                $st->BindParam(21, $mt);
                $st->BindParam(22, $mt);
                $st->BindParam(23, $mt);
				$st->BindParam(24, $currentday);
				$st->BindParam(25, $currentmonth);
				$st->BindParam(26, $currentyear);
                $exed = $st->execute();
               
                    $rtn = 1;
                    $dpt = 'MEDREPORTS';
                    $sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
				B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
				,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_STATUS,B_BILLERCODE,B_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                    $st = $this->db->prepare($sqlstmtbillsitems);
                    $st->BindParam(1, $servicebillcode);
                    $st->BindParam(2, $visitcode);
                    $st->BindParam(3, $servicebillcode);
                    $st->BindParam(4, $days);
                    $st->BindParam(5, $days);
                    $st->BindParam(6, $patientcode);
                    $st->BindParam(7, $patientnumber);
                    $st->BindParam(8, $patient);
                    $st->BindParam(9, $servicereqname);
                    $st->BindParam(10, $servicereqcode);
                    $st->BindParam(11, $cashschemecode);
                    $st->BindParam(12, $cash);
                    $st->BindParam(13, $cash);
                    $st->BindParam(14, $cashpaymentmethodcode);
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
                    $st->BindParam(26, $rtn);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$st->BindParam(30, $rtn);
					$st->BindParam(31, $currentusercode);
					$st->BindParam(32, $currentuser);
                    $exedx = $st->execute();
					$sql = "UPDATE octopus_current SET CU_MEDICALREPORTNUMBER = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $requestnumber);
					$st->BindParam(2, $instcode);
				//	$st->BindParam(3, $but);
					$exe = $st->execute();

				if($exedx){
					return '2';
				}else{
					return '0';
				}			
			}
		}else{
			return '0';
		}
	
	}
	

	// 10 OCT 2021 JOSEPH ADORBOE 
	public function getpatientvitalsed($patientcode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_obgyn_history where PAH_PATIENTCODE = ? and PAH_INSTCODE = ? and PAH_STATUS = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PAH_CODE'].'@'.$object['PAH_PATIENTCODE'].'@'.$object['PAH_PATIENTNUMBER'].'@'.$object['PAH_PATIENT'].'@'.$object['PAH_DATE'].'@'.$object['PAH_PARITY'].'@'.$object['PAH_GRAVIDITY'].'@'.$object['PAH_AGEAT'].'@'.$object['PAH_LMP'].'@'.$object['PAH_TERMINIATIONS'].'@'.$object['PAH_MISCARRAGES'].'@'.$object['PAH_RAPTEST'].'@'.$object['PAH_MISCARRAGENOTES'].'@'.$object['PAH_YEAR'].'@'.$object['PAH_CYCLELENGHT'].'@'.$object['PAH_MENSTRALDURATION'].'@'.$object['PAH_BLEEDINGVOL'].'@'.$object['PAH_BLEEDINGNOTES'].'@'.$object['PAH_GALACTORRHEA'].'@'.$object['PAH_WEIGHTCHANGES'].'@'.$object['PAH_WEIGHTNOTES'].'@'.$object['PAH_DYMENORRHEA'].'@'.$object['PAH_DYMENORRHEANOTES'].'@'.$object['PAH_VAGINALDISCHARGE'].'@'.$object['PAH_VAGINALBLEED'].'@'.$object['PAH_FERTITLITYHISTORY'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '1';
		}
			
	}	

	

	// 12 SEPT 2021,  JOSEPH ADORBOE
	public function insert_patientadddevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$newdevices,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode){

		$mt = 1;
		$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices WHERE DEV_DEVICE = ? AND DEV_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newdevices);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$ty = 0;
				$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_ACTOR,DEV_ACTORCODE,DEV_INSTCODE,DEV_QTY) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $devicescode);
				$st->BindParam(3, $newdevices);
				$st->BindParam(4, $newdevices);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $ty);					
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_DEVICECODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $patientdevicecode);
					$st->BindParam(2, $instcode);
				//	$st->BindParam(3, $but);
					$exe = $st->execute();							
					if($exe){								
								$sqlstmt = "INSERT INTO octopus_patients_devices(PD_CODE,PD_DATE,PD_PATIENTCODE,PD_PATIENTNUMBER,PD_PATIENT,PD_CONSULTATIONCODE,PD_AGE,PD_GENDER,PD_VISITCODE,PD_DEVICECODE,PD_DEVICE,PD_HISTORY,PD_ACTOR,PD_ACTORCODE,PD_INSTCODE,PD_REQUESTCODE,PD_TYPE,PD_PAYMENTMETHODCODE,PD_PAYMENTMETHOD,PD_SCHEMECODE,PD_SCHEME,PD_PAYMENTTYPE,PD_QTY,PD_BILLERCODE,PD_BILLER) 
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
						$st->BindParam(10, $devicescode);
						$st->BindParam(11, $newdevices);
						$st->BindParam(12, $storyline);
						$st->BindParam(13, $currentuser);
						$st->BindParam(14, $currentusercode);
						$st->BindParam(15, $instcode);
						$st->BindParam(16, $patientdevicecode);
						$st->BindParam(17, $type);
						$st->BindParam(18, $paymentmethodcode);
						$st->BindParam(19, $paymentmethod);
						$st->BindParam(20, $schemecode);
						$st->BindParam(21, $scheme);
						$st->BindParam(22, $consultationpaymenttype);
						$st->BindParam(23, $quantity);
						$st->BindParam(24, $currentusercode);
						$st->BindParam(25, $currentuser);
						$exe = $st->execute();
						if($exe){	
							$rtn = 1;
							$sql = "UPDATE octopus_patients_consultations SET CON_DEVICES = ? WHERE CON_CODE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $rtn);
							$st->BindParam(2, $consultationcode);				
							$exe = $st->execute();											
							$sql = "UPDATE octopus_current SET CU_DEVICEREQUESTCODE = ? WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $patientdevicecode);
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
		$sqlstmt = ("SELECT PD_ID FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_VISITCODE = ? AND PD_DEVICECODE = ? and PD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $devicescode);
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

	// 11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientattachedresults($patientcode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_attachedresults WHERE RES_PATIENTCODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	


	// 11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientinvestigationrequest($patientcode,$instcode){
		$nut = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_investigationrequest WHERE MIV_PATIENTCODE = ? AND MIV_INSTCODE = ? AND MIV_COMPLETE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nut);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	


	// 11 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$newchronic,$storyline,$currentusercode,$currentuser,$instcode){

		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_st_chronic where CH_CHRONIC = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newchronic);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_chronic(CH_CODE,CH_CHRONIC,CH_DESC,CH_USERCODE,CH_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newchronic);
				$st->BindParam(3, $newchronic);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);				
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_chronic(CH_CODE,CH_DATE,CH_PATIENTCODE,CH_PATIENTNUMBER,CH_PATIENT,CH_CONSULTATIONCODE,CH_AGE,CH_GENDER,CH_VISITCODE,CH_CHRONICCODE,CH_CHRONIC,CH_HISTORY,CH_ACTOR,CH_ACTORCODE,CH_INSTCODE) 
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
				$st->BindParam(10, $chroniccode);
				$st->BindParam(11, $newchronic);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
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
	


	// 11 SEPT 2021 JOSEPH ADORBOE 
	public function getpatientchronicstatus($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_chronic WHERE CH_PATIENTCODE = ? AND CH_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	

	// 11 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$newallergy,$storyline,$currentusercode,$currentuser,$instcode){
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_st_allergy where ALG_ALLEGY = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newallergy);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_allergy(ALG_CODE,ALG_ALLEGY,ALG_USERCODE,ALG_USER,ALG_DESC) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $allergycode);
				$st->BindParam(2, $newallergy);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $currentuser);	
				$st->BindParam(5, $newallergy);			
				$exe = $st->execute();
				if($exe){
						$sqlstmt = "INSERT INTO octopus_patients_allergy(ALG_CODE,ALG_DATE,ALG_PATIENTCODE,ALG_PATIENTNUMBER,ALG_PATIENT,ALG_CONSULTATIONCODE,ALG_AGE,ALG_GENDER,ALG_VISITCODE,ALG_ALLERGYCODE,ALG_ALLERGY,ALG_HISTORY,ALG_ACTOR,ALG_ACTORCODE,ALG_INSTCODE) 
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
					$st->BindParam(10, $allergycode);
					$st->BindParam(11, $newallergy);
					$st->BindParam(12, $storyline);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $currentusercode);
					$st->BindParam(15, $instcode);
					$exe = $st->execute();
					if($exe){
						return '2';
					}else{
						return '0';
					}
					// return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}	
	
	}	

	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_patientchronic($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$chroniccode,$chronicc,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_patients_chronic where CH_PATIENTCODE = ? AND CH_VISITCODE = ? AND CH_CHRONICCODE = ? and CH_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $chroniccode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_chronic(CH_CODE,CH_DATE,CH_PATIENTCODE,CH_PATIENTNUMBER,CH_PATIENT,CH_CONSULTATIONCODE,CH_AGE,CH_GENDER,CH_VISITCODE,CH_CHRONICCODE,CH_CHRONIC,CH_HISTORY,CH_ACTOR,CH_ACTORCODE,CH_INSTCODE) 
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
				$st->BindParam(10, $chroniccode);
				$st->BindParam(11, $chronicc);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
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
	

	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_newchronic($form_key,$newchronic,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT CH_ID FROM octopus_st_chronic where CH_CHRONIC = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newchronic);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_chronic(CH_CODE,CH_CHRONIC,CH_DESC,CH_USERCODE,CH_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newchronic);
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


	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_patientallergy($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$allergycode,$allergyy,$storyline,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_patients_allergy where ALG_PATIENTCODE = ? AND ALG_VISITCODE = ? AND ALG_ALLERGYCODE = ? and ALG_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $allergycode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_allergy(ALG_CODE,ALG_DATE,ALG_PATIENTCODE,ALG_PATIENTNUMBER,ALG_PATIENT,ALG_CONSULTATIONCODE,ALG_AGE,ALG_GENDER,ALG_VISITCODE,ALG_ALLERGYCODE,ALG_ALLERGY,ALG_HISTORY,ALG_ACTOR,ALG_ACTORCODE,ALG_INSTCODE) 
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
				$st->BindParam(10, $allergycode);
				$st->BindParam(11, $allergyy);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
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
	

	// 13 AUG 2021,  JOSEPH ADORBOE
    public function insert_newallergy($form_key,$newallergy,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT ALG_ID FROM octopus_st_allergy where ALG_ALLEGY = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newallergy);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_allergy(ALG_CODE,ALG_ALLEGY,ALG_DESC,ALG_USERCODE,ALG_USER) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newallergy);
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

	// 04 Aug 2021 JOSEPH ADORBOE 
	public function getpatientobygnhistory($patientcode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_obgyn_history where PAH_PATIENTCODE = ? and PAH_INSTCODE = ? and PAH_STATUS = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PAH_CODE'].'@'.$object['PAH_PATIENTCODE'].'@'.$object['PAH_PATIENTNUMBER'].'@'.$object['PAH_PATIENT'].'@'.$object['PAH_DATE'].'@'.$object['PAH_PARITY'].'@'.$object['PAH_GRAVIDITY'].'@'.$object['PAH_AGEAT'].'@'.$object['PAH_LMP'].'@'.$object['PAH_TERMINIATIONS'].'@'.$object['PAH_MISCARRAGES'].'@'.$object['PAH_RAPTEST'].'@'.$object['PAH_MISCARRAGENOTES'].'@'.$object['PAH_YEAR'].'@'.$object['PAH_CYCLELENGHT'].'@'.$object['PAH_MENSTRALDURATION'].'@'.$object['PAH_BLEEDINGVOL'].'@'.$object['PAH_BLEEDINGNOTES'].'@'.$object['PAH_GALACTORRHEA'].'@'.$object['PAH_WEIGHTCHANGES'].'@'.$object['PAH_WEIGHTNOTES'].'@'.$object['PAH_DYMENORRHEA'].'@'.$object['PAH_DYMENORRHEANOTES'].'@'.$object['PAH_VAGINALDISCHARGE'].'@'.$object['PAH_VAGINALBLEED'].'@'.$object['PAH_FERTITLITYHISTORY'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 12 JULY 2021 JOSEPH ADORBOE 
	public function checkattachedpatientfolder($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients where PATIENT_CODE = ? and PATIENT_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PATIENT_FOLDERATTACHED'];
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}	
	

	// 09 JULY 2021 JOSEPH ADORBOE 
	public function getpatientconsultationallvisitdetails($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_PATIENTCODE = ? and CON_INSTCODE = ? limit 1 ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 09 JULY 2021 JOSEPH ADORBOE 
	public function getpatientconsultationarchivesallvisitdetails($patientcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_PATIENTCODE = ? and CON_INSTCODE = ? limit 1 ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 09 JULY 2021 JOSEPH ADORBOE 
	public function getpatientconsultationvisitdetails($visitcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_VISITCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $visitcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 12 OCT 2022 JOSEPH ADORBOE 
	public function getpatientconsultationarchivevisitdetails($visitcode){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_VISITCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $visitcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	


	public function update_patientdevices($ekey,$days,$comcode,$comname,$storyline,$quantity,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_patients_devices SET PD_DATE = ?, PD_DEVICECODE = ?,  PD_DEVICE = ?, PD_HISTORY = ? , PD_QTY = ?  WHERE PD_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $comcode);
		$st->BindParam(3, $comname);
		$st->BindParam(4, $storyline);
		$st->BindParam(5, $quantity);
		$st->BindParam(6, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 MAY 2021 JOSEPH  ADORBOE 
	public function update_removepatientdevices($ekey,$days,$comcode,$comname,$storyline,$cancelreason,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_devices SET PD_STATUS = ? , PD_RETURNREASON = ?  WHERE PD_CODE = ?  ";
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

		// 29 MAY 2021,  JOSEPH ADORBOE
		public function insert_newdevice($form_key,$newdevices,$description,$devicecode,$currentusercode,$currentuser,$instcode){
	
			$mt = 1;
			$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices where DEV_DEVICE = ?  ");
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $newdevices);
			$check = $st->execute();
			if($check){
				if($st->rowcount() > 0){			
					return '1';			
				}else{
					$ty = 0;
					$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_ACTOR,DEV_ACTORCODE,DEV_INSTCODE,DEV_QTY) 
					VALUES (?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $form_key);
					$st->BindParam(2, $devicecode);
					$st->BindParam(3, $newdevices);
					$st->BindParam(4, $description);
					$st->BindParam(5, $currentuser);
					$st->BindParam(6, $currentusercode);
					$st->BindParam(7, $instcode);
					$st->BindParam(8, $ty);					
					$exe = $st->execute();
					if($exe){
						$sql = "UPDATE octopus_current SET CU_DEVICECODE = ? WHERE CU_INSTCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $devicecode);
						$st->BindParam(2, $instcode);
					//	$st->BindParam(3, $but);
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

	// 29 MAY  2021,  JOSEPH ADORBOE
    public function insert_patientdevices($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$devicescode,$devicesname,$storyline,$patientdevicecode,$type,$paymentmethodcode,$paymentmethod,$quantity,$scheme,$schemecode,$consultationpaymenttype,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT PD_ID FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_VISITCODE = ? AND PD_DEVICECODE = ? and PD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $devicescode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_devices(PD_CODE,PD_DATE,PD_PATIENTCODE,PD_PATIENTNUMBER,PD_PATIENT,PD_CONSULTATIONCODE,PD_AGE,PD_GENDER,PD_VISITCODE,PD_DEVICECODE,PD_DEVICE,PD_HISTORY,PD_ACTOR,PD_ACTORCODE,PD_INSTCODE,PD_REQUESTCODE,PD_TYPE,PD_PAYMENTMETHODCODE,PD_PAYMENTMETHOD,PD_SCHEMECODE,PD_SCHEME,PD_PAYMENTTYPE,PD_QTY, PD_BILLERCODE, PD_BILLER) 
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
				$st->BindParam(10, $devicescode);
				$st->BindParam(11, $devicesname);
				$st->BindParam(12, $storyline);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $patientdevicecode);
				$st->BindParam(17, $type);
				$st->BindParam(18, $paymentmethodcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $schemecode);
				$st->BindParam(21, $scheme);
				$st->BindParam(22, $consultationpaymenttype);
				$st->BindParam(23, $quantity);
				$st->BindParam(24, $currentusercode);
				$st->BindParam(25, $currentuser);
				$exe = $st->execute();
				if($exe){	
					$rtn = 1;
					$sql = "UPDATE octopus_patients_consultations SET CON_DEVICES = ? WHERE CON_CODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $rtn);
					$st->BindParam(2, $consultationcode);				
					$exe = $st->execute();
					$sql = "UPDATE octopus_patients_consultations_archive SET CON_DEVICES = ? WHERE CON_CODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $rtn);
					$st->BindParam(2, $consultationcode);				
					$exe = $st->execute();											
					$sql = "UPDATE octopus_current SET CU_DEVICEREQUESTCODE = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $patientdevicecode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();
					$sql = "UPDATE octopus_st_devices SET DEV_LASTDATE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? AND DEV_STATUS = ?";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $days);
					$st->BindParam(2, $devicescode);
					$st->BindParam(3, $instcode);
					$st->BindParam(4, $rtn);
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

	// 25 MAY 2021 JOSEPH ADORBOE
	public function getdoctordashboard($currentusercode,$currentshiftcode,$instcode){
        $nut = 1;
        $not = '0';
        $sql = 'SELECT * FROM octopus_patients_appointments WHERE APP_STATUS = ? and APP_INSTCODE = ? and APP_DOCTORCODE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $not);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $currentusercode);
        $ext = $st->execute();
        if ($ext) {
            $appointments = $st->rowcount();
        } else {
            return '0';
        }
        
        $sql = 'SELECT * FROM octopus_patients_servicesrequest WHERE REQU_VITALSTATUS = ? and REQU_INSTCODE = ? and REQU_STATE = ? and REQU_DOCTORCODE = ? and REQU_SHIFTCODE = ? ';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $nut);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentshiftcode);
        $ext = $st->execute();
        if ($ext) {
            $patientqueue = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_patients_servicesrequest WHERE REQU_VITALSTATUS = ? and REQU_INSTCODE = ? and REQU_STATE != ? and REQU_DOCTORCODE = ? and REQU_SHIFTCODE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $nut);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentshiftcode);
        $ext = $st->execute();
        if ($ext) {
            $servicebasket = $st->rowcount();
        } else {
            return '0';
        }
                       
        //							0				1					2							3						4					5						6
        $doctordashboarddetails = $appointments.'@@@'.$patientqueue.'@@@'.$servicebasket;
        
        return $doctordashboarddetails;
    }			
		

	// // 17 MAR 2021 JOSEPH ADORBOE 
	// public function getpatientconsultationservicebasketdetails($idvalue){
	// 	$sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_VISITCODE = ?");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $idvalue);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		if($st->rowcount() > 0){
	// 			$object = $st->fetch(PDO::FETCH_ASSOC);
	// 			$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_COMPLAINT'].'@'.$object['CON_PHYSIALEXAMS'].'@'.$object['CON_INVESTIGATION'].'@'.$object['CON_DIAGNSIS'].'@'.$object['CON_PRESCRIPTION'].'@'.$object['CON_DOCNOTES'].'@'.$object['CON_PROCEDURE'].'@'.$object['CON_OXYGEN'].'@'.$object['CON_MANAGEMENT'].'@'.$object['CON_DEVICES'];
	// 			return $results;
	// 		}else{
	// 			return'1';
	// 		}

	// 	}else{
	// 		return '0';
	// 	}
			
	// }
	
	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationservicebasketdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations_archive where CON_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_COMPLAINT'].'@'.$object['CON_PHYSIALEXAMS'].'@'.$object['CON_INVESTIGATION'].'@'.$object['CON_DIAGNSIS'].'@'.$object['CON_PRESCRIPTION'].'@'.$object['CON_DOCNOTES'].'@'.$object['CON_PROCEDURE'].'@'.$object['CON_OXYGEN'].'@'.$object['CON_MANAGEMENT'].'@'.$object['CON_DEVICES'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	




	// 13 MAY 2021 JOSEPH ADORBOE 
	public function updateservicerequest($requestcode){

		$nut = 3;
		$but = 2;
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STAGE = ? WHERE REQU_CODE = ? and REQU_STAGE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $requestcode);
		$st->BindParam(3, $but);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	

	}
	
	// 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].' : '.$object['CON_PLAN'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'].'@'.$object['CON_CONSULTATIONNUMBER'].'@'.$object['CON_PLAN'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 22 APR 2022 18 MAR 2021 JOSEPH ADORBOE 
	public function getpatientvitals($patientcode,$visitcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_vitals WHERE VID_PATIENTCODE = ? AND VID_VISITCODE = ? AND VID_INSTCODE = ? AND VIS_STATUS = ? ORDER BY VID_ID LIMIT 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['VID_BP'].'@'.$object['VID_TEMPERATURE'].'@'.$object['VID_HEIGHT'].'@'.$object['VID_WEIGHT'].'@'.$object['VID_FBS'].'@'.$object['VID_RBS'].'@'.$object['VID_GLUCOSE'].'@'.$object['VID_PULSE'].'@'.$object['VID_SPO2'].'@'.$object['VID_REMARKS'].'@'.$object['VID_CODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '1';
		}
			
	}	



									
																					   
											
	
} 
?>