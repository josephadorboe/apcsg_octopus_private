<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 26 FEB 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	insert_newdevice($form_key,$newdevices,$description,$currentusercode,$currentuser,$instcode)
*/

class ConsultationActionController Extends Engine{

	// 27 JULY 2023 JOSEPH ADORBOE 
	public function cancelconsultationfees($form_key,$consultationcode,$requestcode,$visitcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$patientcode,$patientnumber,$patient,$days,$day,$prepaidcode, $prepaid,$prepaidchemecode,$prepaidscheme,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$action = 'Cancelled';
		$na = 'NA';
		$one = '1';
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems WHERE B_SERVCODE = ? AND B_VISITCODE = ? AND B_PATIENTCODE = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $requestcode);
        $st->BindParam(2, $visitcode);
        $st->BindParam(3, $patientcode);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$schemecode = $obj['B_PAYSCHEMECODE'];
					$scheme = $obj['B_PAYSCHEME'];					
					$methodcode = $obj['B_METHODCODE'];					
					$paymethod = $obj['B_PAYMETHOD'];
					$paymethodcode = $obj['B_PAYMETHODCODE'];
					$costamount = $obj['B_TOTAMT'];
					$patstatus = $obj['B_STATUS'];
					if($methodcode == $cashpaymentmethodcode ||$methodcode == $mobilemoneypaymentmethodcode ){
						$sql = "UPDATE octopus_patients_billitems SET B_STATUS = ? , B_COMPLETE = ? WHERE B_SERVCODE = ? AND B_VISITCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $zero);
						$st->BindParam(2, $zero);
						$st->BindParam(3, $requestcode);
						$st->BindParam(4, $visitcode);
						$exevisit = $st->execute();

						$sql = ("INSERT INTO octopus_patients_billingpayments (BPT_CODE,BPT_VISITCODE,BPT_BILLINGCODE,BPT_DATE,BPT_DATETIME,BPT_PATIENTCODE,BPT_PATIENTNUMBER,BPT_PATIENT,BPT_PAYSCHEMECODE,BPT_PAYSCHEME,BPT_METHOD,BPT_METHODCODE,BPT_AMOUNTPAID,BPT_TOTALAMOUNT,BPT_TOTALBAL,BPT_INSTCODE,BPT_ACTORCODE,BPT_ACTOR,BPT_SHIFTCODE,BPT_SHIFT,BPT_DAY,BPT_MONTH,BPT_YEAR,BPT_PHONENUMBER,BPT_CHEQUENUMBER,BPT_BANKCODE,BPT_BANK,BPT_CASHIERTILLCODE,BPT_RECEIPTNUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
						$st = $this->db->prepare($sql);   
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $visitcode);
						$st->BindParam(3, $form_key);
						$st->BindParam(4, $day);
						$st->BindParam(5, $days);
						$st->BindParam(6, $patientcode);
						$st->BindParam(7, $patientnumber);
						$st->BindParam(8, $patient);
						$st->BindParam(9, $schemecode);
						$st->BindParam(10, $scheme);
						$st->BindParam(11, $paymethod);
						$st->BindParam(12, $paymethodcode);
						$st->BindParam(13, $costamount);
						$st->BindParam(14, $costamount);
						$st->BindParam(15, $costamount);
						$st->BindParam(16, $instcode);
						$st->BindParam(17, $currentusercode);
						$st->BindParam(18, $currentuser);
						$st->BindParam(19, $currentshiftcode);
						$st->BindParam(20, $currentshift);
						$st->BindParam(21, $currentday);
						$st->BindParam(22, $currentmonth);
						$st->BindParam(23, $currentyear); 
						$st->BindParam(24, $na);
						$st->BindParam(25, $na);
						$st->BindParam(26, $na);
						$st->BindParam(27, $na);
						$st->BindParam(28, $na);
						$st->BindParam(29, $na);
						$recipt = $st->Execute();
	
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
								$st->BindParam(1, $costamount);
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
								$st->BindParam(10, $costamount);
								$st->BindParam(11, $na);
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
						} else {
							return '0';
						}
					} else {
						$sql = "UPDATE octopus_patients_billitems SET B_STATUS = ? , B_COMPLETE = ? WHERE B_SERVCODE = ? AND B_VISITCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $zero);
						$st->BindParam(2, $zero);
						$st->BindParam(3, $requestcode);
						$st->BindParam(4, $visitcode);
						$exevisit = $st->execute();

					}
				}
			}
		}		
	// 27 JULY 2023 JOSEPH ADORBOE 
	public function cancelconsultation($consultationcode,$requestcode,$visitcode,$cancelreason,$patientcode,$patientnumber,$patient,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$action = 'Cancelled';
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTIONDATE = ? , CON_ACTIONCODE = ? , CON_ACTION = ?, CON_REMARKS = ?   WHERE CON_CODE = ?  ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $days);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $action);
		$st->BindParam(7, $cancelreason);
		$st->BindParam(8, $consultationcode);			
		$exe = $st->execute();	

		$sqlstmt = 'DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? '	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
		$exe = $st->execute();
			if($exe){
				$sql = "UPDATE octopus_patients_visit SET VISIT_STATUS = ? , VISIT_COMPLETE = ? , VISIT_STATE = ? WHERE VISIT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $zero);
				$st->BindParam(4, $visitcode);
				$exevisit = $st->execute();
				
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATUS = ? WHERE PRESC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exeprescription = $st->execute();
				
				$sql = "UPDATE octopus_patients_devices SET PD_STATUS = ? WHERE PD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exeedevice = $st->execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ? WHERE MIV_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exeinvestigation = $st->execute();

				$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exeprocedure = $st->execute();

				$sql = "UPDATE octopus_patients_complains SET PPC_STATUS = ? WHERE PPC_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$excomplains = $st->execute();

				$sql = "UPDATE octopus_patients_diagnosis SET DIA_STATUS = ? WHERE DIA_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exdiagnosis = $st->execute();

				$sql = "UPDATE octopus_patients_management SET NOTES_STATUS = ? WHERE NOTES_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exmanagements = $st->execute();

				$sql = "UPDATE octopus_patients_notes SET NOTES_STATUS = ? WHERE NOTES_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exnotes = $st->execute();

				$sql = "UPDATE octopus_patients_oxygen SET POX_STATUS = ? WHERE POX_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exoxygen = $st->execute();

				$sql = "UPDATE octopus_patients_physicalexam SET PHE_STATUS = ? WHERE PHE_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exphysical = $st->execute();

				/*$sql = "UPDATE octopus_patients_physio_treatment SET PPD_STATUS = ? WHERE PPD_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exphysio = $st->execute(); */

				/*$sql = "UPDATE octopus_patients_servicesrequest SET REQU_STATUS = ? WHERE REQU_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exservice = $st->execute();*/
				
				$one = 1;
				$zero = '0';
				$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, 
				REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ?  WHERE REQU_VISITCODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $one);
				$st->BindParam(2, $days);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $cancelreason);
				$st->BindParam(6, $visitcode);
				$st->BindParam(7, $zero);
				$st->BindParam(8, $instcode);
				$exservice = $st->Execute();		

				$sql = "UPDATE octopus_patients_vitals SET VIS_STATUS = ? WHERE VID_VISITCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $zero);
				$st->BindParam(2, $visitcode);
				$exvitals = $st->execute();
				
				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exvitals && $exservice ){
					return '2';
				}else{
					return '0';
				}						
		}else{								
			return '0';								
		}	
	}	
	// 19 NOV 2022 JOSEPH ADORBOE 
	public function reassignpatients($days,$physicancode,$physicaname,$consultationcode,$patientcode,$instcode){		
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_DOCTOR = ? , CON_DOCTORCODE = ? , CON_DATE = ?  WHERE CON_CODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $physicaname);
		$st->BindParam(2, $physicancode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();			
		$sql = "UPDATE octopus_patients_consultations SET  CON_DOCTOR = ? , CON_DOCTORCODE = ? , CON_DATE = ?  WHERE CON_CODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $physicaname);
		$st->BindParam(2, $physicancode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}							
	}
	// 28 AUG 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function endconsultation($patientcode,$days,$visitcode,$consultationcode,$patientaction,$servicerequestedcode,$action,$currentusercode,$currentuser,$instcode){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one = 1; 
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){
				$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTIONDATE = ? , CON_ACTIONCODE = ? , CON_ACTION = ?  WHERE CON_CODE = ?  ";
				$st = $this->db->prepare($sql);		
				$st->BindParam(1, $nut);
				$st->BindParam(2, $not);
				$st->BindParam(3, $nnt);
				$st->BindParam(4, $days);
				$st->BindParam(5, $patientaction);
				$st->BindParam(6, $action);
				$st->BindParam(7, $consultationcode);			
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
				
				$sql = "UPDATE octopus_patients_billitems SET B_BILLER = ? , B_BILLERCODE = ?  WHERE B_VISITCODE = ? AND B_ITEMCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $currentuser);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $visitcode);
				$st->BindParam(4, $servicerequestedcode);
				$exebillier = $st->execute();
					
				if($patientaction == '20'){
					$type = 2;
				}else{
					$type = 1;
				}								

				if($exevisit && $exeprescription && $exeedevice && $exeinvestigation && $exeprocedure && $exebillier  ){
					return '2';
				}else{
					return '0';
				}				

				}			
				
			}else{
				return '1';	
			}
						
		}else{								
			return '0';								
		}
	}
	


	// 30 apr 2022  JOSEPH ADORBOE 
	public function checkpatientphysico($patientcode,$instcode){
        $one = 1;
        $sqlstmt = ("SELECT PATIENT_PHYSIO FROM octopus_patients WHERE PATIENT_CODE = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $one);
    //    $st->BindParam(4, $one);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$data = $obj['PATIENT_PHYSIO'];
					return $data;
                return '2';
            } else {
                return '0';
            }
        } else {
            return '0';
        }
    }
		

	// 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorproceurestats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode){		
		$one = 1;	
		$three = 3;	
		$four = 4;
		$sql = "UPDATE octopus_stats_doctors SET DS_PROCEDURES = DS_PROCEDURES + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_MONTH = ? AND DS_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentmonth);	
		$st->BindParam(5, $three);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_stats_doctors SET DS_PROCEDURES = DS_PROCEDURES + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$exe = $st->execute();

		$sql = "UPDATE octopus_stats_doctors SET DS_PROCEDURES = DS_PROCEDURES + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ? AND DS_YEAR = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$st->BindParam(7, $currentyear);	
		$exe = $st->execute();
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 28 APR 2022 JOSEPH ADORBOE 
	public function countdoctorstats($currentmonth,$currentday,$currentyear,$currentusercode,$currentuser,$instcode){		
		$one = 1;	
		$three = 3;	
		$four = 4;
		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_MONTH = ? AND DS_TYPE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentmonth);	
		$st->BindParam(5, $three);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$exe = $st->execute();

		$sql = "UPDATE octopus_stats_doctors SET DS_CONSULTATION = DS_CONSULTATION + ? WHERE DS_DOCTORCODE = ? AND DS_INSTCODE = ? AND DS_DAY = ? AND DS_TYPE = ? AND DS_MONTH = ? AND DS_YEAR = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $currentday);	
		$st->BindParam(5, $four);
		$st->BindParam(6, $currentmonth);	
		$st->BindParam(7, $currentyear);	
		$exe = $st->execute();
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}


	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_dischargeonly($visitcode, $consultationcode, $days, $patientaction, $action, $remarks,$patientcode, $patientnumber, $patient,$day,$consultationnumber, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber,$currentuser,$currentusercode,$servicerequestedcode,$servicerequested){
		
		$one = 1; 
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){
					
					return '2';
		} else {
			return '0';
		}
	}	
	}			
		
	}

	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_admission($patientcode, $patientnumber, $patient, $visitcode,$day,$consultationcode,$consultationnumber,$days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$servicerequestedcode,$servicerequested,$consultationpaymenttype,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$currentshiftcode,$currentshift,$outcomenumber){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$type = 2;
		$one = 1; 
		$admissionservice = 'SER0012';
		$admission = 'ADMISSION';
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){				
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

				if($exeadmission ){
					return '2';
				}else{
					return '0';
				}									
		}else{								
			return '0';								
		}	
	}
	}
	}

	
	// 21 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_detain($form_key, $patientcode, $patientnumber, $patient, $visitcode, $day, $consultationcode, $days, $patientaction, $action, $remarks, $admissionrequestcode,$admissionnotes,$triage,$requestcode, $age,$gender, $paymentmethod,$paymentmethodcode,$schemecode,$scheme,$consultationpaymenttype,$dententioncode,$dententionname,$detainserviceamount,$currentshiftcode,$currentshift,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$outcomenumber){
			
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one = 1;
		$dpt = 'SERVICES';
		$type = 1;
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){	
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
                $st->BindParam(18, $consultationnumber);
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
                $st->BindParam(18, $consultationnumber);
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

                if ($exeadmission && $exebills) {
                    return '2';
                } else {
                    return '0';
                }
               
            } else {
                return '0';
            }
		}
	}	
	}

	// 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_death($patientcode, $patientnumber, $patient, $visitcode, $consultationcode, $days, $patientaction, $action, $remarks, $patientdeathdate,$patientdeathtime,$deathremarks,$deathrequestcode, $age,$gender,$currentusercode, $currentuser, $instcode,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$currentday,$currentmonth,$currentyear,$outcomenumber){				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one =1;
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_ACTIONCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $patientaction);		
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{
				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);
				$exeoutcome = $st->execute();
				if($exeoutcome){
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
				if($exedeath){
					return '2';
				}else{
					return '0';
				}
			}
		}
	}									
	
	}

	// 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_followup($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber){
				
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one =1;
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){	

				// 	$sql = "UPDATE octopus_patients_consultations_archive SET  CON_STATE = ? , CON_STATUS = ? , CON_COMPLETE = ?, CON_ACTIONDATE = ? , CON_ACTIONCODE = ? , CON_ACTION = ?  WHERE CON_CODE = ?  ";
				// $st = $this->db->prepare($sql);		
				// $st->BindParam(1, $nut);
				// $st->BindParam(2, $not);
				// $st->BindParam(3, $nnt);
				// $st->BindParam(4, $days);
				// $st->BindParam(5, $patientaction);
				// $st->BindParam(6, $action);
				// $st->BindParam(7, $consultationcode);			
				// $exe = $st->execute();

				
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

		if($exe){
			return '2';
		}else{
			return '0';
		}	
		}	
	}
	}
	}
	

	// 22 APR 2022 28 MAR 2021 JOSEPH ADORBOE 
	public function update_patientaction_review($form_key, $patientcode, $patientnumber, $patient, $visitcode, $patientdate, $consultationcode, $days, $patientaction, $action, $remarks, $servicecode, $servicesed, $requestcodecode,$currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear,$consultationnumber,$servicerequestedcode,$servicerequested,$currentshiftcode,$currentshift,$outcomenumber){
		
		$nut = 10;
		$not = 5;
		$nnt = 2;
		$one =1;
		$sqlstmt = ("SELECT OUT_ID FROM octopus_patients_consultations_outcome WHERE OUT_VISITCODE = ? AND  OUT_PATIENTCODE = ? AND  OUT_INSTCODE = ? AND OUT_STATUS = ? AND OUT_CONSULTATIONCODE  = ? AND OUT_ACTIONCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $consultationcode);
		$st->BindParam(6, $patientaction);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';	
			}else{

				$outcomecode = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_patients_consultations_outcome(OUT_CODE,OUT_CONSULTATIONCODE,OUT_CONSULTATIONNUMBER,OUT_VISITCODE,OUT_DATE,OUT_PATIENTCODE,OUT_PATIENTNUMBER,OUT_PATIENT,OUT_DOCTOR,OUT_DOCTORCODE,OUT_SERVICECODE,OUT_SERVICE,OUT_ACTIONDATE,OUT_ACTIONCODE,OUT_ACTION,OUT_INSTCODE,OUT_SHIFTCODE,OUT_SHIFT,OUT_DAY,OUT_MONTH,OUT_YEAR,OUT_ACTOR,OUT_ACTORCODE,OUT_NUMBER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $outcomecode);
				$st->BindParam(2, $consultationcode);
				$st->BindParam(3, $consultationnumber);
				$st->BindParam(4, $visitcode);
				$st->BindParam(5, $days);
				$st->BindParam(6, $patientcode);
				$st->BindParam(7, $patientnumber);
				$st->BindParam(8, $patient);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $servicerequestedcode);
				$st->BindParam(12, $servicerequested);
				$st->BindParam(13, $days);
				$st->BindParam(14, $patientaction);
				$st->BindParam(15, $action);
				$st->BindParam(16, $instcode);
				$st->BindParam(17, $currentshiftcode);
				$st->BindParam(18, $currentshift);
				$st->BindParam(19, $currentday);
				$st->BindParam(20, $currentmonth);
				$st->BindParam(21, $currentyear);
				$st->BindParam(22, $currentuser);
				$st->BindParam(23, $currentusercode);
				$st->BindParam(24, $outcomenumber);				
				$exeoutcome = $st->execute();			
				if($exeoutcome){	
				
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

				if($exe){
					return '2';
				}else{
					return '0';
				}
			}
		}
	}
	
	
	// 29 MAY 2022  JOSEPH ADORBOE 
	public function checkpatientcomplains($visitcode,$patientcode,$instcode){
		$one = 1;
		$sqlstmt = ("SELECT PPC_ID  FROM octopus_patients_complains WHERE PPC_PATIENTCODE = ? AND PPC_INSTCODE = ? AND PPC_VISITCODE = ? AND PPC_STATUS = ? ");
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