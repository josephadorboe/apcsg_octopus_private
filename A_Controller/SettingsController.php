<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 APR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/


class SettingsController Extends Engine{  

	// 05 MAY 2021
	public function update_receiptdetails($finame,$companyname,$captions,$phonenumber,$email,$taxpin,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_admin_receiptdetails SET RP_INSTNAME = ? , RP_CAPTION = ?, RP_PHONENUM = ?, RP_EMAIL = ? , RP_LOGO = ?, RP_PIN = ? , RP_ACTOR = ? , RP_ACTORCODE = ?  WHERE RP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $companyname);
		$st->BindParam(2, $captions);
		$st->BindParam(3, $phonenumber);
		$st->BindParam(4, $email);
		$st->BindParam(5, $finame);
		$st->BindParam(6, $taxpin);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 05 MAY 2021
	public function update_shiftsettings($starttime,$endtime,$ekeyshift,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_admin_shifttypes SET SHT_STARTTIME = ? , SHT_ENDTIME = ?, SHT_ACTOR = ?, SHT_ACTORCODE = ?  WHERE SHT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $starttime);
		$st->BindParam(2, $endtime);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekeyshift);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 19 APR 2021
	public function update_settings($staffpershift,$consultationduration,$startconsultation,$endconsultation,$appointmentdays,$ekey,$instcode){

		$sql = "UPDATE octopus_current SET CU_STAFFPERSHIFT = ? , CU_CONSULTATIONDURATION = ?, CU_STARTCONSULTATION = ?, CU_ENDCONSULTATION = ? , CU_DAYSAHEAD = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $staffpershift);
		$st->BindParam(2, $consultationduration);
		$st->BindParam(3, $startconsultation);
		$st->BindParam(4, $endconsultation);
		$st->BindParam(5, $appointmentdays);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}


	

	// 18 APR 2021
	public function update_consultationend($consultationend,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_current SET CU_ENDCONSULTATION = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consultationend);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 18 APR 2021
	public function update_consultationstart($consultationstart,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_current SET CU_STARTCONSULTATION = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consultationstart);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 19 APR 2021
	public function update_consultationduration($consultationduration,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_current SET CU_CONSULTATIONDURATION = ?  WHERE CU_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $consultationduration);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 18 APR 2021
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



	
	
	
} 
?>