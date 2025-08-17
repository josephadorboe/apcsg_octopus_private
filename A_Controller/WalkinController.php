<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 12 MAR 2022
	PURPOSE: TO OPERATE MYSQL QUERY 		
*/

class WalkinController Extends Engine{ 	

	// 29 JULY 2021   JOSEPH ADORBOE
	public function insert_deviceswalkin($form_key,$walkinrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$days,$day,$devicecode,$devicename,$quantity,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$phycode,$phyname,$currentusercode,$currentuser,$instcode){		
		$payment = 1;
		$cash  = 'CASH';
		$type = 'WALK IN';
		$nut = 'NA';
		$sqlstmt = "INSERT INTO octopus_patients_devices(PD_CODE,PD_REQUESTCODE,PD_DATE,PD_PATIENTCODE,PD_PATIENTNUMBER,PD_PATIENT,PD_GENDER,PD_AGE,PD_TYPE,PD_VISITCODE,PD_PAYMENTMETHODCODE,PD_PAYMENTMETHOD,PD_SCHEMECODE,PD_SCHEME,PD_PAYMENTTYPE,PD_DEVICECODE,PD_DEVICE,PD_QTY,PD_ACTORCODE,PD_ACTOR,PD_INSTCODE,PD_CONSULTATIONSTATE,PD_BILLERCODE,PD_BILLER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $walkinrequestcode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $gender);
		$st->BindParam(8, $age);
		$st->BindParam(9, $type);
		$st->BindParam(10, $currentvisitcode);
		$st->BindParam(11, $cashpaymentmethodcode);
		$st->BindParam(12, $cashpaymentmethod);
		$st->BindParam(13, $cashschemecode);
		$st->BindParam(14, $cash);
		$st->BindParam(15, $payment);
		$st->BindParam(16, $devicecode);
		$st->BindParam(17, $devicename);
		$st->BindParam(18, $quantity);
		$st->BindParam(19, $currentusercode);
		$st->BindParam(20, $currentuser);
		$st->BindParam(21, $instcode);
		$st->BindParam(22, $payment);
		$st->BindParam(23, $phycode);
		$st->BindParam(24, $phyname);
		
		$exe = $st->execute();		
		if($exe){
			$sql = "UPDATE octopus_current SET CU_DEVICEREQUESTCODE = ?  WHERE CU_INSTCODE = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $walkinrequestcode);
			$st->BindParam(2, $instcode);						
			$exe = $st->execute();
			$sql = "UPDATE octopus_st_devices SET DEV_LASTDATE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? AND DEV_STATUS = ?";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $days);
					$st->BindParam(2, $devicecode);
					$st->BindParam(3, $instcode);
					$st->BindParam(4, $payment);
					$exe = $st->execute();
            if ($exe) {
                return '2';
            }else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 29 JULY 2021   JOSEPH ADORBOE
	public function insert_mediationwalkin($form_key, $walkinrequestcode,$currentvisitcode,$patientcode,$patient,$patientnumber,$gender,$age,$days,$day,$medicationcode,$medicationname,$dosagecode,$dosage,$medicationnumber,$quantity,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$phycode,$phyname,$currentusercode,$currentuser,$instcode){		
		$payment = 1;
		$cash  = 'CASH';
		$type = 'WALK IN';
		$nut = 'NA';
		$one = 1;
		$sqlstmt = "INSERT INTO octopus_patients_prescriptions(PRESC_CODE,PRESC_CODENUM,PRESC_PATIENTNUMBER,PRESC_PATIENTCODE,PRESC_PATIENT,PRESC_TYPE,PRESC_GENDER,PRESC_AGE,PRESC_DATE,PRESC_DATETIME,PRESC_VISITCODE,PRESC_MEDICATIONCODE,PRESC_MEDICATION,PRESC_DOSAGEFORMCODE,PRESC_DOSAGEFORM,PRESC_FREQUENCYCODE,PRESC_FREQUENCY,PRESC_DAYSCODE,PRESC_DAYS,PRESC_QUANTITY,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_PAYMENTTYPE,PRESC_ACTORCODE,PRESC_ACTOR,PRESC_INSTCODE,PRESC_CONSULTATIONSTATE,PRESC_BILLERCODE,PRESC_BILLER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $walkinrequestcode);
		$st->BindParam(3, $patientnumber);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patient);
		$st->BindParam(6, $type);
		$st->BindParam(7, $gender);
		$st->BindParam(8, $age);
		$st->BindParam(9, $day);
		$st->BindParam(10, $days);
		$st->BindParam(11, $currentvisitcode);
		$st->BindParam(12, $medicationcode);
		$st->BindParam(13, $medicationname);
		$st->BindParam(14, $dosagecode);
		$st->BindParam(15, $dosage);
		$st->BindParam(16, $nut);
		$st->BindParam(17, $nut);
		$st->BindParam(18, $nut);
		$st->BindParam(19, $nut);
		$st->BindParam(20, $quantity);
		$st->BindParam(21, $cashpaymentmethod);
		$st->BindParam(22, $cashpaymentmethodcode);
		$st->BindParam(23, $cashschemecode);
		$st->BindParam(24, $cash);
		$st->BindParam(25, $payment);
		$st->BindParam(26, $currentusercode);
		$st->BindParam(27, $currentuser);
		$st->BindParam(28, $instcode);
		$st->BindParam(29, $payment);
		$st->BindParam(30, $phycode);
		$st->BindParam(31, $phyname);
		$exe = $st->execute();		
		if($exe){
			$sql = "UPDATE octopus_current SET CU_PRECRIPECODE = ?  WHERE CU_INSTCODE = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $walkinrequestcode);
			$st->BindParam(2, $instcode);						
			$exe = $st->execute();
			$sql = "UPDATE octopus_st_medications SET MED_LASTDATE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? AND  MED_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $days);
			$st->BindParam(2, $medicationcode);
			$st->BindParam(3, $instcode);	
			$st->BindParam(4, $one);						
			$exe = $st->execute();	
            if ($exe) {
                return '2';
            }else{
				return '0';
			}
		}else{
			return '0';
		}	
	}


	
} 
?>