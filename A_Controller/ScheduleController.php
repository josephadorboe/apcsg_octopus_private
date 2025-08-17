<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 APR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/


class ScheduleController Extends Engine{  

	// 07 NOV 2021 JOSEPH ADORBOE 
	public function cancelschedule($ekey,$days,$currentusercode,$currentuser){
		$nt = 0 ;
		$sql = "UPDATE octopus_schedule_staff SET SC_STATUS = ? ,SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ?  WHERE SC_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}
	}

	// 07 NOV 2021,  JOSEPH ADORBOE
    public function insert_myschedule($staffschedulecode,$scheduledate,$shifttype,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
	
		$mt = 1;
		$sqlstmt = ("SELECT SD_ID FROM octopus_schedule_staff where SC_STAFFCODE = ? and SC_DATE = ? and SC_SHIFTTYPE = ? and SC_INSTCODE = ? and SC_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $scheduledate);
		$st->BindParam(3, $shifttype);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_schedule_staff(SC_CODE,SC_DATE,SC_SHIFTTYPE,SC_STAFFCODE,SC_STAFF,SC_INSTCODE,SC_ACTOR,SC_ACTORCODE,SC_DAY,SC_MONTH,SC_YEAR,SC_CODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $staffschedulecode);
				$st->BindParam(2, $scheduledate);
				$st->BindParam(3, $shifttype);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $currentday);
				$st->BindParam(10, $currentmonth);
				$st->BindParam(11, $currentyear);
				$st->BindParam(12, $schedulenumber);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_SCHEDULENUMBER = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $schedulenumber);
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

	// 18 APR 2021 JOSEPH ADORBOE 
	public function removestaffschedule($ekey,$currentusercode,$currentuser){
		$nt = 0 ;
		$sql = "UPDATE octopus_schedule_staff SET SC_STATUS = ? WHERE SC_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $ekey);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}
	}
	
	
	// 18 APR 2021 JOSEPH ADORBOE 
	public function update_staffpershift($staffpershift,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_current SET CU_STAFFPERSHIFT = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $staffpershift);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}


	// 18 APR 2021,  JOSEPH ADORBOE
    public function insert_schedule($schedulecode,$scheduledate,$shifttype,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
	
		$mt = 1;
		$sqlstmt = ("SELECT SCD_ID FROM octopus_schedule where SCD_SHIFTTYPE = ? and SCD_DATE = ? and SCD_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $shifttype);
		$st->BindParam(2, $scheduledate);
		$st->BindParam(3, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_schedule(SCD_CODE,SCD_DATE,SCD_SHIFTTYPE,SCD_ACTOR,SCD_ACTORCODE,SCD_INSTCODE,SCD_DAY,SCD_MONTH,SCD_YEAR) 
				VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $schedulecode);
				$st->BindParam(2, $scheduledate);
				$st->BindParam(3, $shifttype);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentday);
				$st->BindParam(8, $currentmonth);
				$st->BindParam(9, $currentyear);
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


	// 18 APR 2021,  JOSEPH ADORBOE
    public function insert_staffschedule($staffschedulecode,$scheduledate,$shifttype,$staffdetcode,$staffdetname,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
		
		$mt = 1;
		$sqlstmt = ("SELECT SD_ID FROM octopus_schedule_staff where SC_STAFFCODE = ? and SC_DATE = ? and SC_SHIFTTYPE = ? and SC_INSTCODE = ? and SC_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $staffdetcode);
		$st->BindParam(2, $scheduledate);
		$st->BindParam(3, $shifttype);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $mt);
		$check = $st->execute();				
		if($check){						
			if($st->rowcount() > 0){						
				return '1';			
			}else{
								// 
				$sqlstmted = "INSERT INTO octopus_schedule_staff (SC_CODE,SC_DATE,SC_SHIFTTYPE,SC_STAFFCODE,SC_STAFF,SC_INSTCODE,SC_ACTOR,SC_ACTORCODE,SC_DAY,SC_MONTH,SC_YEAR,SC_CODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmted);   
				$st->BindParam(1, $staffschedulecode);
				$st->BindParam(2, $scheduledate);
				$st->BindParam(3, $shifttype);
				$st->BindParam(4, $staffdetcode);
				$st->BindParam(5, $staffdetname);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $currentday);
				$st->BindParam(10, $currentmonth);
				$st->BindParam(11, $currentyear);
				$st->BindParam(12, $schedulenumber);
				$exe = $st->execute();				
				if($exe){				
					$sql = "UPDATE octopus_current SET CU_SCHEDULENUMBER = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $schedulenumber);
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



	
} 
?>