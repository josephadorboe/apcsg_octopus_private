<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 2 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_appointmentslots
	$appointmentslottable->querygetappoitmenttimeslot($instcode)
	= new OctopusAppointmentslotSql();
*/

class OctopusAppointmentslotSql Extends Engine{

	// 9 JUNE 2025, JOSEPH ADORBOE 
	public function querygetappoitmenttimeslot($instcode){
		$list = "SELECT AP_CODE,AP_TIMESTART,AP_TIMEEND,AP_DOCTORCODE,AP_DOCTOR,AP_ACTORCODE,AP_ACTOR,AP_INSTCODE,AP_DATE from octopus_appointmentslots where AP_STATUS = '1' and AP_INSTCODE = '$instcode' and  AP_TIMESTART >= '$this->thedays' order by AP_DATE , AP_TIMESTART ";
		return $list;
	}

	// 2 SEPT 2023, 20 APR 2021 JOSEPH ADORBOE 
	public function cancelledappointmentslot($timecode,$currentuser,$currentusercode,$instcode){
		$one = 1;							
		$sql = "UPDATE octopus_appointmentslots SET AP_STATUS = ?,  AP_ACTOR = ?, AP_ACTORCODE =?  WHERE AP_CODE = ?  AND AP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $timecode);
		$st->BindParam(5, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 08 AUG 2023, 20 APR 2021,  JOSEPH ADORBOE
    public function updateappointmentslot($appcode,$currentusercode,$currentuser,$instcode){
		$two = 2;	
		$one = 1;	
		$sqlstmt = "UPDATE octopus_appointmentslots SET AP_STATUS = ?, AP_ACTORCODE = ? , AP_ACTOR = ?  WHERE AP_CODE = ? AND AP_STATUS = ? AND AP_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $two);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $appcode);
		$st->BindParam(5, $one);
		$st->BindParam(6, $instcode);						
		$setbills = $st->execute();
		if($setbills){
			return '2';
		}else{
			return '0';
		}				
	}
	// 2 SEPT 2023, 20 APR 2021 JOSEPH ADORBOE	  
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
				}else{					
					return '0';					
				}		
			}
		}else{			
			return '0';			
		}	
	}
	
}
$appointmentslottable = new OctopusAppointmentslotSql(); 
?>