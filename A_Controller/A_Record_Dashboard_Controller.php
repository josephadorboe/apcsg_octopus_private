<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 15 AUG 2025
	PURPOSE: shift controller  	
*/

class RecordDashboardControllerClass Extends Engine{
	
	// 13 JAN 2021 
	public function getdashboarddetails($instcode,$day)
	{
		if(empty($_SESSION['recorddashboard'])){
		$ntt = 1;	
		$sql = "SELECT PATIENT_ID FROM octopus_patients where PATIENT_INSTCODE = ? and PATIENT_DATE = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day); 
		$st->execute();
		$patientaddedtoday = $st->rowcount();
			//	$ntt = 2;	
		$sql = "SELECT PATIENT_ID FROM octopus_patients where PATIENT_INSTCODE = ? and PATIENT_STATUS = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $ntt); 
		$st->execute();
		$patienttotalnumber = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest where REQU_INSTCODE = ? and REQU_DATE = ? and REQU_STATUS != ? "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
		$st->BindParam(3, $ntt); 
		$st->execute();
		$activeservices = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest where REQU_INSTCODE = ? and REQU_DATE = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
	//	$st->BindParam(3, $ntt); 
		$st->execute();
		$todayactiveservices = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT VISIT_ID FROM octopus_patients_visit where VISIT_INSTCODE = ? and VISIT_DATE = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
	//	$st->BindParam(3, $ntt); 
		$st->execute();
		$todayvisits = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT APP_ID FROM octopus_patients_appointments where APP_INSTCODE = ? and APP_DATE = ? and APP_STATUS = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
		$st->BindParam(3, $ntt); 
		$st->execute();
		$todayappointmentpending = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT APP_ID FROM octopus_patients_appointments where APP_INSTCODE = ? and APP_DATE = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
	//	$st->BindParam(3, $ntt); 
		$st->execute();
		$todayappointment = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT AP_ID FROM octopus_appointmentslots where AP_INSTCODE = ? and AP_DATE = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
	//	$st->BindParam(3, $ntt); 
		$st->execute();
		$todaytotalslots = $st->rowcount();

		$ntt = 1;	
		$sql = "SELECT AP_ID FROM octopus_appointmentslots where AP_INSTCODE = ? and AP_DATE = ? and  AP_STATUS = ?  "; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $day);
		$st->BindParam(3, $ntt); 
		$st->execute();
		$todayavaliableslots = $st->rowcount();
		$_SESSION['recorddashboard'] =  $patientaddedtoday.'@@@'.$patienttotalnumber.'@@@'.$activeservices.'@@@'.$todayactiveservices.'@@@'.$todayvisits.'@@@'.$todayappointmentpending.'@@@'.$todayappointment.'@@@'.$todaytotalslots.'@@@'.$todayavaliableslots ;

			return $_SESSION['recorddashboard']; 
		} else{
		return $_SESSION['recorddashboard']; 
	}
	}

} 

	$recorddashboardcontroller =  new RecordDashboardControllerClass();
?>