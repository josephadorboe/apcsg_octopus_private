<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PatientInvestigationController Extends Engine{
	
	// 07 APR 2022 JOSEPH ADORBOE 
	public function update_editlabplanname($ekey,$labplanname,$notes,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_labplans SET LP_NAME = ?, LP_DESC = ?, LP_ACTOR = ? , LP_ACTORCODE = ?  WHERE LP_CODE = ? AND LP_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labplanname);
		$st->BindParam(2, $notes);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 22 NOV 2021 JOSEPH ADORBOE 
	public function update_removelabsfromplans($ekey,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR = ? , TRM_ACTORCODE = ? WHERE TRM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
				

	// 22 NOV 2021,  JOSEPH ADORBOE
    public function insert_labstoplan($form_key,$plancode,$plan,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_labplans_tests where TRM_TESTCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $lapcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $plancode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans_tests(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_TESTCODE,TRM_TESTNUM,TRM_TEST,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_TESTCODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $plancode);
				$st->BindParam(3, $plan);
				$st->BindParam(4, $lapcode);
				$st->BindParam(5, $lapnum);
				$st->BindParam(6, $lapname);
				$st->BindParam(7, $days);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $lapcodenum);
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


	// 22 NOV 2021,  JOSEPH ADORBOE
    public function insert_labsplanlist($form_key,$lapplancode,$labsplans,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_labplans_tests where TRM_TESTCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $lapcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $lapplancode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans_tests(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_TESTCODE,TRM_TESTNUM,TRM_TEST,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_TESTCODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $lapplancode);
				$st->BindParam(3, $labsplans);
				$st->BindParam(4, $lapcode);
				$st->BindParam(5, $lapnum);
				$st->BindParam(6, $lapname);
				$st->BindParam(7, $days);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $lapcodenum);
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

	// 22 NOV 2021,  JOSEPH ADORBOE
    public function newlabplans($lapplancode,$labsplans,$labplannumber,$description,$days,$category,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT LP_ID FROM octopus_labplans where LP_NAME = ? and  LP_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labsplans);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans(LP_CODE,LP_CODENUM,LP_NAME,LP_DESC,LP_DATES,LP_CATEGORY,LP_ACTOR,LP_ACTORCODE,LP_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $lapplancode);
				$st->BindParam(2, $labplannumber);
				$st->BindParam(3, $labsplans);
				$st->BindParam(4, $description);
				$st->BindParam(5, $days);
				$st->BindParam(6, $category);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABPLAN = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labplannumber);
					$st->BindParam(2, $instcode);						
					$exetg = $st->execute();
					if($exetg){
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

	// 15 SEPT 2021,  JOSEPH ADORBOE
    public function insert_patientaddscans($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labcodenum,$labscode,$newlabs,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype){
		
		$mt = 1;
		$sqlstmt = ("SELECT SC_ID FROM octopus_st_radiology WHERE SC_NAME = ? AND SC_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newlabs);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_radiology(SC_CODE,SC_NAME,SC_ACTOR,SC_ACTORCODE,SC_INSTCODE,SC_CODENUM,SC_DESC) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newlabs);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $labcodenum);
				$st->BindParam(7, $newlabs);
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_BILLERCODE,MIV_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $newlabs);
				$st->BindParam(13, $type);
				$st->BindParam(14, $cate);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $paymentmethodcode);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $consultationpaymenttype);
				$st->BindParam(25, $currentusercode);
				$st->BindParam(26, $currentuser);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABSCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labrequestcode);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						$ut = '0';
						$nut = 1;
						$sql = "UPDATE octopus_patients_consultations SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();							
						if($exe){
							$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $labcodenum);
							$st->BindParam(2, $instcode);						
							$exetg = $st->execute();
							if($exetg){
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
	

	// 27 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientaddlabs($form_key,$days,$day,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labcodenum,$labscode,$newlabs,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype){
		
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest WHERE LTT_NAME = ? AND LTT_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newlabs);
		$st->BindParam(2, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_NAME,LTT_ACTOR,LTT_ACTORCODE,LTT_INSTCODE,LTT_CODENUM) 
				VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newlabs);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $instcode);
				$st->BindParam(6, $labcodenum);
				$exe = $st->execute();
				if($exe){
					$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_BILLERCODE,MIV_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $newlabs);
				$st->BindParam(13, $type);
				$st->BindParam(14, $cate);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $paymentmethodcode);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $consultationpaymenttype);
				$st->BindParam(25, $currentusercode);
				$st->BindParam(26, $currentuser);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABSCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labrequestcode);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						$ut = '0';
						$nut = 1;
						$sql = "UPDATE octopus_patients_consultations SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();								
						if($exe){
							$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $labcodenum);
							$st->BindParam(2, $instcode);						
							$exetg = $st->execute();
							if($exetg){
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
	

	// 27 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientlabs($form_key,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$labscode,$labsname,$cate,$notes,$type,$paymentmethod,$paymentmethodcode,$schemecode,$scheme,$labrequestcode,$currentusercode,$currentuser,$instcode,$consultationpaymenttype,$labpartnercode,$plan){
		
		$mt = 1;
		$sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest where MIV_PATIENTCODE = ? AND MIV_VISITCODE = ? AND MIV_TESTCODE = ? and MIV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_investigationrequest(MIV_CODE,MIV_DATE,MIV_DATETIME,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CONSULTATIONCODE,MIV_AGE,MIV_GENDER,MIV_VISITCODE,MIV_TESTCODE,MIV_TEST,MIV_TYPE,MIV_CATEGORY,MIV_REMARK,MIV_ACTOR,MIV_ACTORCODE,MIV_INSTCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHODCODE,MIV_SCHEMECODE,MIV_SCHEME,MIV_REQUESTCODE,MIV_PAYMENTTYPE,MIV_TESTPARTNERCODE,MIV_BILLERCODE,MIV_BILLER,MIV_PLAN) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $days);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $patient);
				$st->BindParam(7, $consultationcode);
				$st->BindParam(8, $age);
				$st->BindParam(9, $gender);
				$st->BindParam(10, $visitcode);
				$st->BindParam(11, $labscode);
				$st->BindParam(12, $labsname);
				$st->BindParam(13, $type);
				$st->BindParam(14, $cate);
				$st->BindParam(15, $notes);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $paymentmethod);
				$st->BindParam(20, $paymentmethodcode);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $labrequestcode);
				$st->BindParam(24, $consultationpaymenttype);
				$st->BindParam(25, $labpartnercode);
				$st->BindParam(26, $currentusercode);
				$st->BindParam(27, $currentuser);
				$st->BindParam(28, $plan);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABSCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labrequestcode);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						$ut = '0';
						$nut = 1;
						$sql = "UPDATE octopus_patients_consultations SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
						$exe = $st->execute();
						$sql = "UPDATE octopus_patients_consultations_archive SET CON_INVESTIGATION = ?  WHERE CON_CODE = ? and CON_INVESTIGATION = ?  ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $nut);
						$st->BindParam(2, $consultationcode);
						$st->BindParam(3, $ut);						
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
		}else{
			return '0';
		}	
	}
	
	// 27 MAR 2021,  JOSEPH ADORBOE
    public function insert_newlabs($form_key,$newlabs,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest where LTT_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newlabs);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_NAME,LTT_ACTOR,LTT_ACTORCODE) 
				VALUES (?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $newlabs);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
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
	public function update_patientlabs($ekey,$labscode,$labsname,$notes,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_DATE = ?, MIV_DATETIME = ?,  MIV_TESTCODE = ?, MIV_TEST =? , MIV_REMARK =?, MIV_ACTORCODE =?, MIV_ACTOR =?  WHERE MIV_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $day);
		$st->BindParam(2, $days);
		$st->BindParam(3, $labscode);
		$st->BindParam(4, $labsname);
		$st->BindParam(5, $notes);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}	
	// 01 NOV 2022 JOSEPH ADORBOE
	public function update_removepatientlabs($ekey,$cancelreason,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATUS = ?  WHERE MIV_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
		$st->BindParam(2, $ekey);			
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	
} 
?>