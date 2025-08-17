<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 26 FEB 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	insert_newdevice($form_key,$newdevices,$description,$currentusercode,$currentuser,$instcode)
*/

class AdmissionActionController Extends Engine{


	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks){
		
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
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

                $nuted = 1;
                $sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeprescription = $st->execute();
                
                $sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeedevice = $st->execute();

                $sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeinvestigation = $st->execute();

                $sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeprocedure = $st->execute();

                if ($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure) {
                    return '2';
                } else {
                    return '0';
                }				
		}else{								
			return '0';								
		}	
	}

	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_admission($patientcode, $patientnumber, $patient, $visitcode,$day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$admissionservice = 'SER0012';
		$admission = 'ADMISSION';
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
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

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();
				if($patientaction == '20'){
					$type = 2;
				}else{
					$type = 1;
				}
					$admissioncode = md5(microtime());
					$sqlstmt = "INSERT INTO octopus_patients_admissions(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $admissioncode);
					$st->BindParam(2, $admissionrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $day);
					$st->BindParam(9, $days);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $admission);
					$st->BindParam(12, $admissionservice);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $scheme);
					$st->BindParam(16, $schemecode);
					$st->BindParam(17, $consultationcode);
					$st->BindParam(18, $requestcode);
					$st->BindParam(19, $admissionnotes);
					$st->BindParam(20, $type);
					$st->BindParam(21, $currentusercode);
					$st->BindParam(22, $currentuser);
					$st->BindParam(23, $currentusercode);
					$st->BindParam(24, $currentuser);
					$st->BindParam(25, $instcode);
					$st->BindParam(26, $triage);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);	
					$st->BindParam(30, $consultationpaymenttype);				
					$exeadmission = $st->execute();

					$sqlstmt = "INSERT INTO octopus_patients_admissions_archive(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $admissioncode);
					$st->BindParam(2, $admissionrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $day);
					$st->BindParam(9, $days);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $admission);
					$st->BindParam(12, $admissionservice);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $scheme);
					$st->BindParam(16, $schemecode);
					$st->BindParam(17, $consultationcode);
					$st->BindParam(18, $requestcode);
					$st->BindParam(19, $admissionnotes);
					$st->BindParam(20, $type);
					$st->BindParam(21, $currentusercode);
					$st->BindParam(22, $currentuser);
					$st->BindParam(23, $currentusercode);
					$st->BindParam(24, $currentuser);
					$st->BindParam(25, $instcode);
					$st->BindParam(26, $triage);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$st->BindParam(30, $consultationpaymenttype);				
					$exeadmission = $st->execute();
					$sql = "UPDATE octopus_current SET CU_ADMSSIONNUMBER = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $admissionrequestcode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();				

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exeadmission ){
					return '2';
				}else{
					return '0';
				}									
		}else{								
			return '0';								
		}	
	}

	
	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_detain($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$dententioncode,$dententionname,$detainserviceamount,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
			
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one = 1;
		$dpt = 'SERVICES';
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
		$exe = $st->execute();

        if ($exe) {
           
                $but = 2;
                $sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $but);
                $st->BindParam(2, $but);
                $st->BindParam(3, $but);
                $st->BindParam(4, $visitcode);
                $exevisit = $st->execute();

                $nuted = 1;
                $sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeprescription = $st->execute();
                
                $sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeedevice = $st->execute();

                $sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeinvestigation = $st->execute();

                $sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nuted);
                $st->BindParam(2, $visitcode);
                $exeprocedure = $st->execute();
                if ($patientaction == '20') {
                    $type = 2;
                } else {
                    $type = 1;
                }
                $admissioncode = md5(microtime());
                $sqlstmt = "INSERT INTO octopus_patients_admissions(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $admissioncode);
                $st->BindParam(2, $admissionrequestcode);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patient);
                $st->BindParam(5, $patientnumber);
                $st->BindParam(6, $gender);
                $st->BindParam(7, $age);
                $st->BindParam(8, $day);
                $st->BindParam(9, $days);
                $st->BindParam(10, $visitcode);
                $st->BindParam(11, $dententionname);
                $st->BindParam(12, $dententioncode);
                $st->BindParam(13, $paymentmethod);
                $st->BindParam(14, $paymentmethodcode);
                $st->BindParam(15, $scheme);
                $st->BindParam(16, $schemecode);
                $st->BindParam(17, $consultationcode);
                $st->BindParam(18, $requestcode);
                $st->BindParam(19, $admissionnotes);
                $st->BindParam(20, $type);
                $st->BindParam(21, $currentusercode);
                $st->BindParam(22, $currentuser);
                $st->BindParam(23, $currentusercode);
                $st->BindParam(24, $currentuser);
                $st->BindParam(25, $instcode);
                $st->BindParam(26, $triage);
                $st->BindParam(27, $currentday);
                $st->BindParam(28, $currentmonth);
                $st->BindParam(29, $currentyear);
                $st->BindParam(30, $consultationpaymenttype);
                $exeadmission = $st->execute();

                $sqlstmt = "INSERT INTO octopus_patients_admissions_archive(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $admissioncode);
                $st->BindParam(2, $admissionrequestcode);
                $st->BindParam(3, $patientcode);
                $st->BindParam(4, $patient);
                $st->BindParam(5, $patientnumber);
                $st->BindParam(6, $gender);
                $st->BindParam(7, $age);
                $st->BindParam(8, $day);
                $st->BindParam(9, $days);
                $st->BindParam(10, $visitcode);
                $st->BindParam(11, $dententionname);
                $st->BindParam(12, $dententioncode);
                $st->BindParam(13, $paymentmethod);
                $st->BindParam(14, $paymentmethodcode);
                $st->BindParam(15, $scheme);
                $st->BindParam(16, $schemecode);
                $st->BindParam(17, $consultationcode);
                $st->BindParam(18, $requestcode);
                $st->BindParam(19, $admissionnotes);
                $st->BindParam(20, $type);
                $st->BindParam(21, $currentusercode);
                $st->BindParam(22, $currentuser);
                $st->BindParam(23, $currentusercode);
                $st->BindParam(24, $currentuser);
                $st->BindParam(25, $instcode);
                $st->BindParam(26, $triage);
                $st->BindParam(27, $currentday);
                $st->BindParam(28, $currentmonth);
                $st->BindParam(29, $currentyear);
                $st->BindParam(30, $consultationpaymenttype);
                $exeadmission = $st->execute();
				// send price to billing 
				$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
				B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
				,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT,B_SERVCODE,B_DPT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtbillsitems);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $form_key);
				$st->BindParam(4, $days);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $dententionname);
				$st->BindParam(10, $dententioncode);
				$st->BindParam(11, $schemecode);
				$st->BindParam(12, $scheme);
				$st->BindParam(13, $paymentmethod);
				$st->BindParam(14, $paymentmethodcode);
				$st->BindParam(15, $one);
				$st->BindParam(16, $detainserviceamount);
				$st->BindParam(17, $detainserviceamount);
				$st->BindParam(18, $detainserviceamount);
				$st->BindParam(19, $currentuser);
				$st->BindParam(20, $currentusercode);
				$st->BindParam(21, $instcode);
				$st->BindParam(22, $currentshiftcode);
				$st->BindParam(23, $currentshift);
				$st->BindParam(24, $form_key);
				$st->BindParam(25, $dpt);
				$st->BindParam(26, $consultationpaymenttype);
				$st->BindParam(27, $currentday);
				$st->BindParam(28, $currentmonth);
				$st->BindParam(29, $currentyear);
				$exebills= $st->execute();

                $sql = "UPDATE octopus_current SET CU_ADMSSIONNUMBER = ? WHERE CU_INSTCODE = ? ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $admissionrequestcode);
                $st->BindParam(2, $instcode);
                $exe = $st->execute();

                if ($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exeadmission && $exebills) {
                    return '2';
                } else {
                    return '0';
                }
               
            } else {
                return '0';
            }	
	}

	// 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_death($patientcode, $patientnumber, $patient, $visitcode, $consultationcode, $days, $patientaction, $action, $remarks, $patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode, $age,$gender,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
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

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();
				if($patientaction == '20'){
					$type = 2;
				}else{
					$type = 1;
				}
					$patientdeathcode = md5(microtime());	
				
					$sqlstmt = "INSERT INTO octopus_patients_deaths(PD_CODE,PD_NUMBER,PD_PATIENTCODE,PD_PATIENT,PD_PATIENTNUMBER,PD_GENDER,PD_AGE,PD_DATE,PD_TOD,PD_VISITCODE,PD_REPORT,PD_DOCCODE,PD_DOCNAME,PD_INSTCODE,PD_DAY,PD_MONTH,PD_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $patientdeathcode);
					$st->BindParam(2, $deathrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $patientdeathdate);
					$st->BindParam(9, $patientdeathtime);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $deathremarks);
					$st->BindParam(12, $currentusercode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $instcode);
					$st->BindParam(15, $currentday);
					$st->BindParam(16, $currentmonth);
					$st->BindParam(17, $currentyear);
							
					$exedeath = $st->execute();
					$sql = "UPDATE octopus_current SET CU_ADMSSIONNUMBER = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $deathrequestcode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$killed = '0';
					$sql = "UPDATE octopus_patients SET PATIENT_STATUS = ? WHERE PATIENT_CODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $killed);
					$st->BindParam(2, $patientcode);					
					$exed = $st->execute();

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exedeath){
					return '2';
				}else{
					return '0';
				}									
		}else{								
			return '0';								
		}	
	}

	// 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
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

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
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

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure){
					return '2';
				}else{
					return '0';
				}

		}else{								
			return '0';								
		}	
	}

	// 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
		
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
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

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
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

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure){
					return '2';
				}else{
					return '0';
				}
									
		}else{								
			return '0';								
		}	
	}
	
	
	
	
	
	
	// 7 MAR 2022  JOSEPH ADORBOE 
	public function checkpatientdiagnosis($visitcode,$patientcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT DIA_ID  FROM octopus_patients_diagnosis WHERE DIA_PATIENTCODE = ? AND DIA_INSTCODE = ? AND DIA_VISITCODE = ? AND DIA_STATUS = ? ");
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
		
		// $sqlstmt = ("SELECT CON_DIAGNSIS  FROM octopus_patients_consultations where CON_PATIENTCODE = ? and CON_INSTCODE = ? and CON_VISITCODE = ? ");
		// $st = $this->db->prepare($sqlstmt);
		// $st->BindParam(1, $patientcode);
		// $st->BindParam(2, $instcode);
		// $st->BindParam(3, $visitcode);
		// $details =	$st->execute();
		// if($details){
		// 	if($st->rowcount() > 0){
		// 		$object = $st->fetch(PDO::FETCH_ASSOC);
		// 		$results = $object['CON_DIAGNSIS'];
		// 		return $results;
		// 	}else{
		// 		return '-1';
		// 	}

		// }else{
		// 	return '-1';
		// }			
	}	
	

	// 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $day, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode,$admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$physiciancode,$physicians,$referaltype,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
		echo $action;
		die;
		
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_ACTIONDATE = ?, CON_ACTIONCODE = ?,  CON_ACTION = ?,  CON_REMARKS = ?, CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ? WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $patientaction);
		$st->BindParam(3, $action);
		$st->BindParam(4, $remarks);
		$st->BindParam(5, $nut);
		$st->BindParam(6, $not);
		$st->BindParam(7, $nnt);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
		$exe = $st->execute();

		if($exe){

			// patient dischage only 
			if($patientaction == '10' || $patientaction == '70' || $patientaction == '80'){

				$but = 2;
				$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $but);
				$st->BindParam(2, $but);
				$st->BindParam(3, $but);
				$st->BindParam(4, $visitcode);
				$exevisit = $st->execute();	

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
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


				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure){
					return '2';
				}else{
					return '0';
				}
			// PATIENT ADMISSIONS
			}else if($patientaction == '20' || $patientaction == '30'){

				$but = 2;
				$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $but);
				$st->BindParam(2, $but);
				$st->BindParam(3, $but);
				$st->BindParam(4, $visitcode);
				$exevisit = $st->execute();	

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();
				if($patientaction == '20'){
					$type = 2;
				}else{
					$type = 1;
				}
					$admissioncode = md5(microtime());
					$sqlstmt = "INSERT INTO octopus_patients_admissions(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $admissioncode);
					$st->BindParam(2, $admissionrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $day);
					$st->BindParam(9, $days);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $servicerequested);
					$st->BindParam(12, $servicerequestedcode);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $scheme);
					$st->BindParam(16, $schemecode);
					$st->BindParam(17, $consultationcode);
					$st->BindParam(18, $requestcode);
					$st->BindParam(19, $admissionnotes);
					$st->BindParam(20, $type);
					$st->BindParam(21, $currentusercode);
					$st->BindParam(22, $currentuser);
					$st->BindParam(23, $currentusercode);
					$st->BindParam(24, $currentuser);
					$st->BindParam(25, $instcode);
					$st->BindParam(26, $triage);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);	
					$st->BindParam(30, $consultationpaymenttype);				
					$exeadmission = $st->execute();

					$sqlstmt = "INSERT INTO octopus_patients_admissions_archive(ADM_CODE,ADM_NUMBER,ADM_PATIENTCODE,ADM_PATIENT,ADM_PATIENTNUMBER,ADM_GENDER,ADM_AGE,ADM_DATE,ADM_DATETIME,ADM_VISITCODE,ADM_SERVICE,ADM_SERVICECODE,ADM_PAYMETHOD,ADM_PAYMETHODCODE,ADM_PAYMENTSCHEME,ADM_PAYMENTSCHEMECODE,ADM_CONSULTATIONCODE,ADM_CONSULTATIONNUMBER,ADM_ADMISSIONNOTES,ADM_TYPE,ADM_DOCTORCODE,ADM_DOCTOR,ADM_ACTORCODE,ADM_ACTOR,ADM_INSTCODE,ADM_TRIAGE,ADM_DAY,ADM_MONTH,ADM_YEAR,ADM_SHOW) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $admissioncode);
					$st->BindParam(2, $admissionrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $day);
					$st->BindParam(9, $days);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $servicerequested);
					$st->BindParam(12, $servicerequestedcode);
					$st->BindParam(13, $paymentmethod);
					$st->BindParam(14, $paymentmethodcode);
					$st->BindParam(15, $scheme);
					$st->BindParam(16, $schemecode);
					$st->BindParam(17, $consultationcode);
					$st->BindParam(18, $requestcode);
					$st->BindParam(19, $admissionnotes);
					$st->BindParam(20, $type);
					$st->BindParam(21, $currentusercode);
					$st->BindParam(22, $currentuser);
					$st->BindParam(23, $currentusercode);
					$st->BindParam(24, $currentuser);
					$st->BindParam(25, $instcode);
					$st->BindParam(26, $triage);
					$st->BindParam(27, $currentday);
					$st->BindParam(28, $currentmonth);
					$st->BindParam(29, $currentyear);
					$st->BindParam(30, $consultationpaymenttype);				
					$exeadmission = $st->execute();
					$sql = "UPDATE octopus_current SET CU_ADMSSIONNUMBER = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $admissionrequestcode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exeadmission){
					return '2';
				}else{
					return '0';
				}
				// Patient death 
			}else if($patientaction == '60' ){

				$but = 2;
				$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $but);
				$st->BindParam(2, $but);
				$st->BindParam(3, $but);
				$st->BindParam(4, $visitcode);
				$exevisit = $st->execute();	

				$nuted = 1;
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_CONSULTATIONSTATE = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_CONSULTATIONSTATE = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_CONSULTATIONSTATE = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nuted);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();
				if($patientaction == '20'){
					$type = 2;
				}else{
					$type = 1;
				}
					$patientdeathcode = md5(microtime());	
				
					$sqlstmt = "INSERT INTO octopus_patients_deaths(PD_CODE,PD_NUMBER,PD_PATIENTCODE,PD_PATIENT,PD_PATIENTNUMBER,PD_GENDER,PD_AGE,PD_DATE,PD_TOD,PD_VISITCODE,PD_REPORT,PD_DOCCODE,PD_DOCNAME,PD_INSTCODE,PD_DAY,PD_MONTH,PD_YEAR) 
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $patientdeathcode);
					$st->BindParam(2, $deathrequestcode);
					$st->BindParam(3, $patientcode);
					$st->BindParam(4, $patient);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $gender);
					$st->BindParam(7, $age);
					$st->BindParam(8, $patientdeathdate);
					$st->BindParam(9, $patientdeathtime);
					$st->BindParam(10, $visitcode);
					$st->BindParam(11, $deathremarks);
					$st->BindParam(12, $currentusercode);
					$st->BindParam(13, $currentuser);
					$st->BindParam(14, $instcode);
					$st->BindParam(15, $currentday);
					$st->BindParam(16, $currentmonth);
					$st->BindParam(17, $currentyear);
							
					$exedeath = $st->execute();
					$sql = "UPDATE octopus_current SET CU_ADMSSIONNUMBER = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $deathrequestcode);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();

					$killed = '0';
					$sql = "UPDATE octopus_patients SET PATIENT_STATUS = ? WHERE PATIENT_CODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $killed);
					$st->BindParam(2, $patientcode);
					
					$exed = $st->execute();

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exedeath){
					return '2';
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