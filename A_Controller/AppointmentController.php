<?php
/*

	AUTHOR: JOSEPH ADORBOE
	DATE: 29 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class AppointmentController Extends Engine{	


	// 20 APR 2021 JOSEPH ADORBOE 
	public function cancelledappointment($ekey,$days,$timecode,$currentuser,$currentusercode,$instcode){
		$but = 0;
		$sql = "UPDATE octopus_patients_appointments SET APP_STATUS = ?,  APP_ACTOR = ?, APP_ACTORCODE =?  WHERE APP_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $but);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
	//	$st->BindParam(5, $ekey);			
		$exe = $st->execute();							
		if($exe){	
			$nut = 1;							
			$sql = "UPDATE octopus_appointmentslots SET AP_STATUS = ?,  AP_ACTOR = ?, AP_ACTORCODE =?  WHERE AP_CODE = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $nut);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $timecode);
		//	$st->BindParam(5, $ekey);			
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


	
	// 20 APR 2021,  JOSEPH ADORBOE
    public function insert_bookappointment($form_key,$patientcode,$patientnumbers,$patient,$phone,$appcode,$appstart,$append,$appdoccode,$appdocname,$days,$age,$gender,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		
		$sqlstmt = ("SELECT APP_ID FROM octopus_patients_appointments where APP_PATIENTCODE = ? and APP_TIMECODE = ?  and APP_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $appcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				
				$sqlstmt = "INSERT INTO octopus_patients_appointments(APP_CODE,APP_DATE,APP_PATIENTCODE,APP_PATIENTNUMBER,APP_PATIENT,APP_PHONE,APP_TIMECODE,APP_STARTTIME,APP_ENDTIME,APP_DOCTOR,APP_DOCTORCODE,APP_ACTOR,APP_ACTORCODE,APP_INSTCODE,APP_GENDER,APP_AGE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $appstart);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumbers);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $phone);
				$st->BindParam(7, $appcode);
				$st->BindParam(8, $appstart);
				$st->BindParam(9, $append);
				$st->BindParam(10, $appdocname);
				$st->BindParam(11, $appdoccode);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $gender);
				$st->BindParam(16, $age);				
				$exe = $st->execute();
				
				if($exe){
					
					$nty = '2';
					$sqlstmt = "UPDATE octopus_appointmentslots SET AP_STATUS = ?  WHERE AP_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $nty);
						$st->BindParam(2, $appcode);						
						$setbills = $st->execute();
						if($setbills){
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


	// 20 APR 2021 JOSEPH ADORBOE	  
	public function generateappointmentslots($form_key,$start,$endtime,$appointmentda,$appdoctorcode,$appdoctorname,$currentuser,$currentusercode,$instcode)
	{
		
		$but = 1;
		$cate = '*';
		$sqlstmt = ("SELECT AP_ID FROM octopus_appointmentslots where AP_TIMESTART = ? and AP_TIMEEND = ? and AP_DOCTORCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $start);
		$st->BindParam(2, $endtime);
		$st->BindParam(3, $appdoctorcode);
		$checkprice = $st->execute();
		if($checkprice){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
			
				$sql = ("INSERT INTO octopus_appointmentslots (AP_CODE,AP_TIMESTART,AP_TIMEEND,AP_DOCTORCODE,AP_DOCTOR,AP_ACTORCODE,AP_ACTOR,AP_INSTCODE,AP_DATE) VALUES (?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $start);
				$st->BindParam(3, $endtime);
				$st->BindParam(4, $appdoctorcode);
				$st->BindParam(5, $appdoctorname);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $appointmentda);
				$setprice = $st->execute();				
				if($setprice){	
					return '2';

						/*		
						$sqlstmt = "UPDATE octopus_appointmentloop SET T_TIMESLOT = ?  WHERE T_DOCTORCODE = ? and  T_INSTCODE = ?  and T_TIMESLOT = ?  ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $endtime);
						$st->BindParam(2, $appdoctorcode);
						$st->BindParam(3, $instcode);
						$st->BindParam(4, $starttimeslot);
						$setbills = $st->execute();
						if($setbills){
							return '2';
						}else{
							return '0';
						}
				*/

				}else{					
					return '0';					
				}		
			}
		}else{			
			return '0';			
		}	
	}



	

	

	public function update_discpline($ekey,$discpline,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_st_labdiscipline SET LD_NAME = ?, LD_DESC = ?,  LD_ACTOR = ?, LD_ACTORCODE =?  WHERE LD_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $discpline);
		$st->BindParam(2, $storyline);
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

	public function update_labtests($ekey,$labtest,$disccode,$discname,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_st_labtest SET LTT_NAME = ?, LTT_DESC = ?,  LTT_ACTOR = ?, LTT_ACTORCODE =? ,LTT_DISCIPLINECODE = ?  , LTT_DISCIPLINE =?  WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labtest);
		$st->BindParam(2, $storyline);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $disccode);
		$st->BindParam(6, $discname);
		$st->BindParam(7, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	public function update_attribute($ekey,$attribute,$range,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_st_labresulttemplate SET LR_ATTRIBUTE = ?, LR_REFRANGE = ?,  LR_ACTOR = ?, LR_ACTORCODE =? ,LR_DESC = ?  WHERE LR_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $attribute);
		$st->BindParam(2, $range);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $storyline);	
		$st->BindParam(6, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
} 
?>