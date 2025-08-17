<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 15 AUG 2025, 
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class CurrentControllerClass Extends Engine{
	
	// 10 SEPT 2021   JOSEPH ADORBOE
	public function currentday($currentday,$currentmonth,$currentyear,$currentuser,$currentusercode,$instcode){	
		$but = 1;		
		$sqlstmt = ("SELECT ST_ID FROM octopus_st_summary where ST_NAME = ? and ST_INSTCODE =? and ST_TYPE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentday);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $but);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$forkey = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_st_summary(ST_CODE,ST_NAME,ST_TYPE,ST_ACTOR,ST_ACTORCODE,ST_INSTCODE,ST_MONTH,ST_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkey);
				$st->BindParam(2, $currentday);
				$st->BindParam(3, $but);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
				$exe = $st->execute();	

				$forkeys = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_stats(STAT_CODE,STAT_TITLE,STAT_TYPE,STAT_ACTOR,STAT_ACTORCODE,STAT_INSTCODE,STAT_MONTH,STAT_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkeys);
				$st->BindParam(2, $currentday);
				$st->BindParam(3, $but);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
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


	// 10 SEPT 2021    JOSEPH ADORBOE
	public function currentmonth($currentmonth,$currentyear,$currentuser,$currentusercode,$instcode){	
		$bt = 2;
		$sqlstmt = ("SELECT ST_ID FROM octopus_st_summary where ST_NAME = ? and ST_INSTCODE =? and ST_TYPE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentmonth);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$forkeys = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_st_summary(ST_CODE,ST_NAME,ST_TYPE,ST_ACTOR,ST_ACTORCODE,ST_INSTCODE,ST_MONTH,ST_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkeys);
				$st->BindParam(2, $currentmonth);
				$st->BindParam(3, $bt);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
				$exe = $st->execute();
				$forkeys = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_stats(STAT_CODE,STAT_TITLE,STAT_TYPE,STAT_ACTOR,STAT_ACTORCODE,STAT_INSTCODE,STAT_MONTH,STAT_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkeys);
				$st->BindParam(2, $currentmonth);
				$st->BindParam(3, $bt);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
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


	// 10 SEPT 2021   JOSEPH ADORBOE
	public function currentyear($currentmonth,$currentyear,$currentuser,$currentusercode,$instcode){	
		
		$gt = 3;
		$sqlstmt = ("SELECT ST_ID FROM octopus_st_summary where ST_NAME = ? and ST_INSTCODE =? and ST_TYPE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentyear);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $gt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$forkeyd = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_st_summary(ST_CODE,ST_NAME,ST_TYPE,ST_ACTOR,ST_ACTORCODE,ST_INSTCODE,ST_MONTH,ST_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkeyd);
				$st->BindParam(2, $currentyear);
				$st->BindParam(3, $gt);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
				$exe = $st->execute();	

				$forkeys = md5(microtime());
				$sqlstmt = "INSERT INTO octopus_stats(STAT_CODE,STAT_TITLE,STAT_TYPE,STAT_ACTOR,STAT_ACTORCODE,STAT_INSTCODE,STAT_MONTH,STAT_YEAR) VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $forkeys);
				$st->BindParam(2, $currentyear);
				$st->BindParam(3, $gt);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentmonth);
				$st->BindParam(8, $currentyear);
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

} 
$currentcontroller =  new CurrentControllerClass();
?>