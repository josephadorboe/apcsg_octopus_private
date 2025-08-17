<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 10 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 
	
*/


class FacilityController Extends Engine{

	
	// 22 MAY 2020,  JOSEPH ADORBOE
    public function setupreceiptdetails($facilitycode,$facilityname,$currentusercode,$currentuser){
	
		$sqlstmt = ("SELECT USER_ID FROM octopus_admin_receiptdetails where RP_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $facilitycode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_admin_receiptdetails(RP_INSTCODE,RP_INSTNAME,RP_ACTOR,RP_ACTORCODE) VALUES (?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $facilitycode);
			$st->BindParam(2, $facilityname);
			$st->BindParam(3, $currentuser);
			$st->BindParam(4, $currentusercode);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	

	// 02 JAN 2020,  JOSEPH ADORBOE
    public function setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser){
	
		$sqlstmt = ("SELECT USER_ID FROM octopus_users where USER_USERNAME = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $inputusername);
		$st->execute();
		
		if($st->rowcount() > 0){
			
			return '1';
			
		}else{
				
			$sqlstmt = "INSERT INTO octopus_users(USER_CODE,USER_USERNAME,USER_PWD,USER_FULLNAME,USER_INSTCODE,USER_SHORTCODE,USER_USERKEY,USER_ACTOR,USER_ACTORCODE,USER_LEVEL,USER_LEVELNAME,USER_INSTNAME) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $inputusername);
			$st->BindParam(3, $pwd);
			$st->BindParam(4, $fullname);
			$st->BindParam(5, $facilitycode);
			$st->BindParam(6, $facilityshortcode);
			$st->BindParam(7, $newuserkey);
			$st->BindParam(8, $currentuser);
			$st->BindParam(9, $currentusercode);
			$st->BindParam(10, $ulevcode);
			$st->BindParam(11, $ulevname);	
			$st->BindParam(12, $facilityname);	
			$exe = $st->execute();

			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
	// 1 JAN 2021 JOSEPH ADORBOE
	public function setup_facilities($form_key,$facilityname,$facilityaddress,$phonenumber,$facilityshortcode,$facilitystart,$facilityend,$expirydate,$day,$facilityrate,$facilitycode,$adminusername,$adminfullname,$pwdd,$newuserkeyd,$ulevcode,$ulevname,$currentusercode,$currentuser){
			
		$nt = 1; 
		$sqlstmt = ("SELECT FAC_ID FROM octopus_setup_facilities where FAC_SHORTCODE = ? and FAC_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $facilityshortcode);
		$st->BindParam(2, $nt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{					
		$sqlstmt = "INSERT INTO octopus_setup_facilities(FAC_CODE,FAC_NAME,FAC_ADDRESS,FAC_PHONENUMBER,FAC_DATE,FAC_SHORTCODE,FAC_START,FAC_END,FAC_EXPIRY,FAC_RATE,FAC_ACTOR,FAC_ACTORCODE,FAC_CODENUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $facilityname);
		$st->BindParam(3, $facilityaddress);
		$st->BindParam(4, $phonenumber);
		$st->BindParam(5, $day);
		$st->BindParam(6, $facilityshortcode);
		$st->BindParam(7, $facilitystart);
		$st->BindParam(8, $facilityend);
		$st->BindParam(9, $expirydate);
		$st->BindParam(10, $facilityrate);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $facilitycode);
		$exe = $st->execute();			
		if($exe){			
			$nut = 0 ;
			$sqlstmt = "INSERT INTO octopus_current(CU_SHIFTCODE,CU_SHIFT,CU_SHFTTYPE,CU_INSTCODE,CU_DATE) VALUES (?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $nut);
			$st->BindParam(2, $nut);
			$st->BindParam(3, $nut);
			$st->BindParam(4, $facilitycode);
			$st->BindParam(5, $day);
			$exe = $st->execute();			
			if($exe){				
				$sqlstmt = "INSERT INTO octopus_users(USER_CODE,USER_USERNAME,USER_PWD,USER_FULLNAME,USER_INSTCODE,USER_SHORTCODE,USER_USERKEY,USER_ACTOR,USER_ACTORCODE,USER_LEVEL,USER_LEVELNAME,USER_INSTNAME) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $adminusername);
				$st->BindParam(3, $pwdd);
				$st->BindParam(4, $adminfullname);
				$st->BindParam(5, $facilitycode);
				$st->BindParam(6, $facilityshortcode);
				$st->BindParam(7, $newuserkeyd);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $ulevcode);
				$st->BindParam(11, $ulevname);	
				$st->BindParam(12, $facilityname);	
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
		}
	}

	// 1 JAN 2021 JOSEPH ADORBOE
	public function setup_assignfacilities($assigncode,$shifttypecode,$shifttypes,$facilitycode,$facilityname,$day,$currentusercode,$currentuser){			
		$nt = 1; 
		$sqlstmt = ("SELECT SHT_ID FROM octopus_admin_shifttypes where SHT_SHIFTTYPECODE =? AND SHT_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $shifttypecode);
		$st->BindParam(2, $facilitycode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{						
		$sqlstmt = "INSERT INTO octopus_admin_shifttypes(SHT_CODE,SHT_SHIFTTYPE,SHT_SHIFTTYPECODE,SHT_INSTCODE,SHT_FACILITY,SHT_DATE,SHT_ACTOR,SHT_ACTORCODE) VALUES (?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $assigncode);
		$st->BindParam(2, $shifttypes);
		$st->BindParam(3, $shifttypecode);
		$st->BindParam(4, $facilitycode);
		$st->BindParam(5, $facilityname);
		$st->BindParam(6, $day);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);		
		$exe = $st->execute();			
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	
	}

	}

	// 14 APR 2021 JOSEPH ADORBOE
	public function setup_assignfaclilitypaymentmethod($assigncode,$facilitypaymethodcode,$facilitypaymethodname,$facilitycode,$facilityname,$day,$currentusercode,$currentuser){
			
		$nt = 1; 
		$sqlstmt = ("SELECT PAY_ID FROM octopus_admin_paymentmethod where PAY_METHODCODE =? AND PAY_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $facilitypaymethodcode);
		$st->BindParam(2, $facilitycode);
		$st->execute();
		
		if($st->rowcount() > 0){			
			return '1';			
		}else{							
			$sqlstmt = "INSERT INTO octopus_admin_paymentmethod(PAY_CODE,PAY_METHODCODE,PAY_METHOD,PAY_INSTCODE,PAY_FACILITY,PAY_DATE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $assigncode);
			$st->BindParam(2, $facilitypaymethodcode);
			$st->BindParam(3, $facilitypaymethodname);
			$st->BindParam(4, $facilitycode);
			$st->BindParam(5, $facilityname);
			$st->BindParam(6, $day);
			$st->BindParam(7, $currentuser);
			$st->BindParam(8, $currentusercode);		
			$exe = $st->execute();			
			if($exe){		
				return '2';			
			}else{			
				return '0';			
			}
	
		}

	}


	// 14 APR 2021,  JOSEPH ADORBOE
    public function setup_assignfacilityservices($assigncode,$facilityservicecode,$facilityservicename,$facilitybillable,$facilityservicelevel,$facilitycode,$facilityname,$day,$currentusercode,$currentuser){
	
		$mt = 1;
		$sqlstmt = ("SELECT SEV_ID FROM octopus_admin_services where SEV_SERVICECODE = ? AND SEV_INSTCODE = ? AND SEV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $facilityservicecode);
		$st->BindParam(2, $facilitycode);
		$st->BindParam(3, $mt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{
				
			$sqlstmt = "INSERT INTO octopus_admin_services(SEV_CODE,SEV_SERVICECODE,SEV_SERVICES,SEV_INSTCODE,SEV_FACILITY,SEV_BILLABLE,SEV_STATE,SEV_DATE,SEV_ACTOR,SEV_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $assigncode);
			$st->BindParam(2, $facilityservicecode);
			$st->BindParam(3, $facilityservicename);
			$st->BindParam(4, $facilitycode);
			$st->BindParam(5, $facilityname);
			$st->BindParam(6, $facilitybillable);
			$st->BindParam(7, $facilityservicelevel);
			$st->BindParam(8, $day);
			$st->BindParam(9, $currentuser);
			$st->BindParam(10, $currentusercode);		
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	






} 
?>