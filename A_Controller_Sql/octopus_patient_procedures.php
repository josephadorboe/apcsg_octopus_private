<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_procedures
	$patientproceduretable->getpendingprocedure($patientcode,$visitcode,$instcode);
*/

class OctopusPatientsProceduresClass Extends Engine{
	// 13 NOV 2021 JOSEPH ADORBOE 
	public function getpendingprocedurereport($currentusercode,$instcode){
		$state = 4;
		$complete = 1;
		$sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures WHERE PPD_ACTORCODE = ? and  PPD_INSTCODE = ? AND PPD_STATE = ? AND PPD_COMPLETE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$st->BindParam(4, $complete);
		$details =	$st->execute();
		if($details){
			return $st->rowcount();		
		}else{
			return '0';
		}	
	}

	// 19 SEPT 2021 JOSEPH ADORBOE
	public function getpendingprocedure($patientcode,$visitcode,$instcode){        
        $sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures WHERE PPD_PATIENTCODE = ? AND PPD_INSTCODE = ? AND PPD_VISITCODE = ? AND PPD_STATE IN('1','2') ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
	    $details =	$st->execute();
         if ($details) {
            if ($st->rowcount() > 0) {				
                return $this->thepassed;
            } else {
                return $this->theexisted;
            }
        } else {
            return $this->thefailed;
        }    	
	}
	// // 20 SEPT 2023 JOSEPH ADORBOE
	// public function getqueryprocedurecompletednurseslist($instcode){		
	// 	$procedurerequest  = ("SELECT DISTINCT PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_CONSULTATIONSTATE,PPD_AGE,PPD_GENDER from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_NOTES IS NOT NULL  order by PPD_ID DESC ");
	// 	return $procedurerequest;
	// }

	// 1 OCT 2024,  JOSEPH ADORBOE
	public function getqueryarchiveprocedurelist($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_PATIENTCODE = '$patientcode' and PPD_ARCHIVE = '1'");
		return $list;
	}

	// 29 SEPT 2024 JOSEPH ADORBOE
	public function getqueryproceduredetailslistnurse($idvalue,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$idvalue'  and PPD_STATUS IN('1','2','5','6') and PPD_COMPLETE = '1' AND PPD_ARCHIVE = '0'");
		return $list;
	}

	// 11 AUG 2024, JOSEPH ADORBOE 
	public function getprocedurerequesteddetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_procedures WHERE PPD_CODE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['PPD_PROCEDURECODE'].'@@'.$obj['PPD_PROCEDURE'].'@@'.$obj['PPD_REMARK'].'@@'.$obj['PPD_QUANTITY'].'@@'.$obj['PPD_STATE'].'@@'.$obj['PPD_RETURN'];
		}else{
			$res = '0';
		}
		return $res;
	}

	// 13 FEB 2022 JOSEPH ADORBOE
	public function enterprocedurenotesreports($ekey, $procedurereport,$instcode){
		$not = 2;
		$sql = "UPDATE octopus_patients_procedures SET PPD_NOTES = ? WHERE PPD_CODE = ? and PPD_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $procedurereport);
		$st->BindParam(2, $ekey);
		$st->BindParam(3, $instcode);		
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 12 oct 2023 JOSEPH ADORBOE
	public function getqueryprocedures($patientcode,$visitcode,$instcode){	
		$list = ("SELECT * from octopus_patients_procedures where PPD_PATIENTCODE = '$patientcode' and PPD_VISITCODE = '$visitcode' and PPD_INSTCODE = '$instcode' order by PPD_STATUS  DESC, PPD_ID DESC");
		return $list;
	}
	// 3 Oct 2023 JOSEPH ADORBOE
	public function getquerylegacyprocedure($patientcode,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_PATIENTCODE = '$patientcode'  and PPD_INSTCODE = '$instcode'  order by PPD_STATUS  DESC,  PPD_ID DESC");
		return $list;
	}
	
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryproceduremonitor($instcode){		
		$list = ("SELECT PPD_CODE,PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PROCEDURENUMBER,PPD_STATE,PPD_REPORT,PPD_ACTOR,PPD_REMARK,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_AGE,PPD_GENDER,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_CONSULTATIONSTATE,PPD_PROCEDURECODE,PPD_PROCEDURE FROM octopus_patients_procedures WHERE PPD_STATUS != '0' AND PPD_INSTCODE = '$instcode' ORDER BY PPD_ID DESC");
		return $list;
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryproceduredetailscompletelist($currentuserlevel,$idvalue,$instcode){	
		if($currentuserlevel == '4'){
			$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$idvalue'  and PPD_STATUS IN('1','2','5','6') AND PPD_NOTES IS NOT NUll ");
		}else{	
			$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$idvalue'  and PPD_STATUS IN('1','2','5','6') AND PPD_COMPLETE = '2'");
		}
		return $list;
	}
	// 11 AUG 2024, JOSEPH ADORBOE
	public function getqueryprocedureshistorylist($patientcode,$visitcode,$instcode){	
		$list = ("SELECT * from octopus_patients_procedures where PPD_PATIENTCODE = '$patientcode' and PPD_VISITCODE != '$visitcode' and PPD_INSTCODE = '$instcode' order by PPD_STATUS  DESC, PPD_ID DESC ");
		return $list;
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprocedureslist($patientcode,$visitcode,$instcode){	
		$list = ("SELECT * from octopus_patients_procedures where PPD_PATIENTCODE = '$patientcode' and PPD_VISITCODE = '$visitcode' and PPD_INSTCODE = '$instcode' and PPD_STATUS = '1' order by PPD_ID DESC ");
		return $list;
	}
	
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryproceduredetailslist($idvalue,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$idvalue'  and PPD_STATUS IN('1','2','5','6') and PPD_COMPLETE = '1' AND PPD_ARCHIVE = '0'");
		return $list;
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getquerysendoutprocedurelist($visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$visitcode' and PPD_STATUS = '5' and PPD_STATE = '8' and PPD_COMPLETE = '2'");
		return $list;
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryreturnprocedurelist($visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_VISITCODE = '$visitcode' and PPD_STATUS IN('2','3','6') AND PPD_DISPENSE IN('1') AND PPD_RETURN = '0'");
		return $list;
	}

	// 23 NOV 2023 JOSEPH ADORBOE
	public function dispenseprocedure($transactioncode,$instcode){
		$two =2;
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_DISPENSE = ? , PPD_CONSUMABLESTATE = ?  WHERE PPD_CODE = ? and PPD_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $two);
		$st->BindParam(3, $transactioncode);
		$st->BindParam(4, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 23 NOV 2023,  JOSEPH ADORBOE	  
	public function processprocedurepaymenttype($bcode,$billcode,$patientpaymenttype)
	{
		
		if ($patientpaymenttype == '7') {
			$nine = 9;
			$two = 2;
			$six = 6;	
			$one = 1;		
			$sqlstmt = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_BILLING = ?, PPD_STATUS = ? , PPD_DISPENSE = ? WHERE PPD_CODE = ? and PPD_STATE = ?  ";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $nine);
			$st->BindParam(2, $billcode);
			$st->BindParam(3, $six);
			$st->BindParam(4, $one);
			$st->BindParam(5, $bcode);
			$st->BindParam(6, $two);
			$setbills = $st->execute();
			if($setbills){
				return '2';
			}else{
				return '0';
			}
		}else if($patientpaymenttype == '1'){
			$three = 3;
			$two = 2;				
			$sqlstmt = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_BILLING = ? WHERE PPD_CODE = ? and PPD_STATE = ?  ";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $three);
			$st->BindParam(2, $billcode);
			$st->BindParam(3, $bcode);
			$st->BindParam(4, $two);
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


	// 16 JULY 2021 JOSEPH ADORBOE 
	public function unselectproceduretransaction($bcode,$days,$currentusercode,$currentuser){
       	$one  = 1;
		$two = 2;
		$zero = '0';
        $sql = "SELECT * FROM octopus_patients_procedures WHERE PPD_CODE = ? AND PPD_STATE = ? ";
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $bcode);
        $st->BindParam(2, $two);
        $exe = $st->execute();
        if($exe){
            if($st->rowcount()>'0'){
                $sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ? ,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $one);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $days);
                $st->BindParam(4, $currentuser);
                $st->BindParam(5, $currentusercode);
                $st->BindParam(6, $zero);
                $st->BindParam(7, $bcode);
                $selectitem = $st->Execute();				
                if($selectitem){
                    return '2' ;	
                }else{
                    return '0' ;	
                }

            }else{
                return '1';
            }
        }else{
            return '0';
        }					
    }

	 // 30 OCT 2023, 18 JULY  2021 JOSEPH ADORBOE 
	 public function precedureselection($bcode,$days,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode){		
		$one = 1;
		$two = 2;
		$sql = "SELECT * from octopus_patients_procedures where PPD_CODE = ? and PPD_INSTCODE = ? and PPD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$acti = $st->execute();
		if($acti){			
			if($st->rowcount()>0){
				if($totalamount == '-1'){
					$sql = "UPDATE octopus_patients_procedures SET PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ?,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $totalamount);
					$st->BindParam(2, $days);
					$st->BindParam(3, $currentuser);
					$st->BindParam(4, $currentusercode);
					$st->BindParam(5, $serviceamount);
					$st->BindParam(6, $bcode);
					$selectitem = $st->Execute();				
						if($selectitem){
							return '2' ;	
						}else{
							return '0' ;	
						}
				}else{
					
					$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ?,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $two);
					$st->BindParam(2, $totalamount);
					$st->BindParam(3, $days);
					$st->BindParam(4, $currentuser);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $serviceamount);
					$st->BindParam(7, $bcode);
					$selectitem = $st->Execute();				
						if($selectitem){
							return '2' ;	
						}else{
							return '0' ;	
						}						
				}
			}else{
				return '1';
			}
		}else{
			return '0';
		}	
			
	}
	// 16 JULY 2021 JOSEPH ADORBOE
	public function editproceduremanage($visitcode,$patientcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_PAYMENTMETHOD = ?, PPD_PAYMENTMETHODCODE = ? , PPD_PAYSCHEMECODE = ?, PPD_PAYSCHEME = ? ,PPD_PAYMENTTYPE = ? WHERE PPD_VISITCODE = ? and PPD_PATIENTCODE = ? and PPD_STATE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymethname);
		$st->BindParam(2, $paymentmethodcode);
		$st->BindParam(3, $paymentschemecode);
		$st->BindParam(4, $paymentscheme);
		$st->BindParam(5, $payment);
		$st->BindParam(6, $visitcode);
		$st->BindParam(7, $patientcode);
		$st->BindParam(8, $not);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 2 OCT 2022 JOSEPH ADORBOE
	public function unarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_ARCHIVE = ?, PPD_PROCESSTIME = ? , PPD_PACTOR = ?, PPD_PACTORCODE = ?  WHERE PPD_CODE = ? and  PPD_ARCHIVE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $one);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 2 OCT 2022 JOSEPH ADORBOE
	public function editpharamcyarchiveprocedure($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_ARCHIVE = ?, PPD_PROCESSTIME = ? , PPD_PACTOR = ?, PPD_PACTORCODE = ?  WHERE PPD_CODE = ? and  PPD_ARCHIVE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 30 OCT 2023, 2 OCT 2022,  JOSEPH ADORBOE
	public function archivepastedprocedures($thereviewday,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_ARCHIVE = ?,  PPD_PACTOR = ?, PPD_PACTORCODE = ? WHERE PPD_DATE < ? and  PPD_ARCHIVE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $thereviewday);
		$st->BindParam(5, $zero);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 01 NOV 2022 JOSEPH ADORBOE 
	public function cancelconsultationprocedure($visitcode,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_RETURNREASON = ?, PPD_RETURNTIME = ?, PPD_RETURNACTOR = ?, PPD_RETURNACTORCODE = ? , PPD_STATE = ?, PPD_COMPLETE = ? WHERE PPD_VISITCODE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $visitcode);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 01 NOV 2022 JOSEPH ADORBOE 
	public function update_removepatientprocedure($ekey,$days,$cancelreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_RETURNREASON = ?, PPD_RETURNTIME = ?, PPD_RETURNACTOR = ?, PPD_RETURNACTORCODE = ?  WHERE PPD_CODE = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $cancelreason);
		$st->BindParam(3, $days);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	//12 OCT 2023,  26 MAR 2021 WHERE ";
	public function update_editpatientprocedure($ekey,$procedurecode,$procedurename,$storyline,$currentusercode,$currentuser,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_PROCEDURECODE = ?, PPD_PROCEDURE = ?, PPD_REMARK = ?, PPD_ACTOR = ?, PPD_ACTORCODE = ? WHERE PPD_CODE = ? AND PPD_INSTCODE = ?  ";		
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $procedurecode);
		$st->BindParam(2, $procedurename);
		$st->BindParam(3, $storyline);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 12 oct 2023,  25 MAR 2021,  JOSEPH ADORBOE
    public function insert_patientprocedurerequest($form_key,$days,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$procedurecode,$procedurename,$storyline,$procedurerequestcode,$paymentmethod,$paymentmethodcode,$consultationpaymenttype,$types,$schemecode,$scheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear){
			$mt = 1;
		$sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures where PPD_PATIENTCODE = ? AND PPD_VISITCODE = ? AND PPD_PROCEDURECODE = ? AND PPD_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $procedurecode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_procedures(PPD_CODE,PPD_DATE,PPD_PATIENTCODE,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_CONSUTLATIONCODE,PPD_AGE,PPD_GENDER,PPD_VISITCODE,PPD_REMARK,PPD_ACTOR,PPD_ACTORCODE,PPD_INSTCODE,PPD_PROCEDURECODE,PPD_PROCEDURE,PPD_PROCEDURENUMBER,PPD_TYPE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYMENTTYPE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_DAY,PPD_MONTH,PPD_YEAR,PPD_BILLERCODE,PPD_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $days);
				$st->BindParam(3, $patientcode);
				$st->BindParam(4, $patientnumber);
				$st->BindParam(5, $patient);
				$st->BindParam(6, $consultationcode);
				$st->BindParam(7, $age);
				$st->BindParam(8, $gender);
				$st->BindParam(9, $visitcode);
				$st->BindParam(10, $storyline);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$st->BindParam(14, $procedurecode);
				$st->BindParam(15, $procedurename);
				$st->BindParam(16, $procedurerequestcode);
				$st->BindParam(17, $types);
				$st->BindParam(18, $paymentmethod);
				$st->BindParam(19, $paymentmethodcode);
				$st->BindParam(20, $consultationpaymenttype);
				$st->BindParam(21, $schemecode);
				$st->BindParam(22, $scheme);
				$st->BindParam(23, $currentday);
				$st->BindParam(24, $currentmonth);
				$st->BindParam(25, $currentyear);
				$st->BindParam(26, $currentusercode);
				$st->BindParam(27, $currentuser);
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
	// 20 sept 2023,  16 JULY 2021 JOSEPH ADORBOE
	public function enterprocedurereports($ekey, $procduredate,$proceduredoctors,$procedurenurse,$procedureassitants,$proceduresite,$procedurdiagnosis,$proceduremedications,$procedureoutcomes,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
		$not = 2;
		$sql = "UPDATE octopus_patients_procedures SET PPD_REPORTTIME = ?, PPD_REPORTACTOR = ? , PPD_REPORTACTORCODE = ?, PPD_REPORT = ?, PPD_COMPLETE = ?, PPD_DAY = ? , PPD_MONTH = ? , PPD_YEAR = ? , PPD_DOCTORS = ? , PPD_NURSE = ?, PPD_SITE = ?, PPD_DIAGNOSIS = ? , PPD_MEDICATIONS = ?, PPD_ASSIST =? WHERE PPD_CODE = ? and PPD_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $days);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $procedureoutcomes);
		$st->BindParam(5, $not);
		$st->BindParam(6, $currentday);
        $st->BindParam(7, $currentmonth);
		$st->BindParam(8, $currentyear);
		$st->BindParam(9, $proceduredoctors);
		$st->BindParam(10, $procedurenurse);	
		$st->BindParam(11, $proceduresite);	
		$st->BindParam(12, $procedurdiagnosis);	
		$st->BindParam(13, $proceduremedications);	
		$st->BindParam(14, $procedureassitants);	
		$st->BindParam(15, $ekey);
		$st->BindParam(16, $instcode);	
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	 // 20 Sept 2023, 16 JULY 2021 JOSEPH ADORBOE  transactioncode
	 public function getprocedurerequestdetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_procedures where PPD_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PPD_PROCEDURE'].'@'.$object['PPD_PROCEDURECODE'].'@'.$object['PPD_PAYSCHEMECODE'].'@'.$object['PPD_PAYSCHEME'].'@'.$object['PPD_PAYMENTMETHOD'].'@'.$object['PPD_PAYMENTMETHODCODE'].'@'.$object['PPD_QUANTITY'].'@'.$object['PPD_STATE'].'@'.$object['PPD_STATUS'].'@'.$object['PPD_PROCEDURENUMBER'].'@'.$object['PPD_DATE'].'@'.$object['PPD_PROCESSTIME'].'@'.$object['PPD_PACTOR'].'@'.$object['PPD_REMARK'].'@'.$object['PPD_NOTES'].'@'.$object['PPD_REPORT'].'@'.$object['PPD_CONSUMABLESTATE'] .'@'.$object['PPD_REPORTTIME'] .'@'.$object['PPD_REPORT'] .'@'.$object['PPD_REPORTACTOR'] .'@'.$object['PPD_REPORTACTORCODE'] .'@'.$object['PPD_DOCTORS'] .'@'.$object['PPD_NURSE'] .'@'.$object['PPD_SITE'] .'@'.$object['PPD_DIAGNOSIS'] .'@'.$object['PPD_MEDICATIONS'] .'@'.$object['PPD_ASSIST']  ;
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}			
	}	
	// 20 Sept 2023, 2 OCT 2022 JOSEPH ADORBOE
	public function sendoutprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$eight = 8;
		$five = 5;
		$three = 3;
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_RETURNTIME = ? , PPD_RETURNACTOR = ?, PPD_RETURNACTORCODE = ? , PPD_RETURNREASON = ?  WHERE PPD_CODE = ? and  PPD_STATUS = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $three);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 20 Sept 2023, 2 OCT 2022 JOSEPH ADORBOE
	public function returnprocedurerequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_procedures SET PPD_RETURN = ?, PPD_RETURNTIME = ? , PPD_RETURNACTOR = ?, PPD_RETURNACTORCODE = ? , PPD_RETURNREASON = ?  WHERE PPD_CODE = ? and  PPD_RETURN = ? AND PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}
	// 20 sept 2023, 16 JULY 2021 JOSEPH ADORBOE
	public function getpatientproceduretotal($visitcode){
		$two = 2;
		$sql = ("SELECT SUM(PPD_TOT) FROM octopus_patients_procedures where PPD_VISITCODE = ? and PPD_STATE IN('2','3','4')");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
	//	$st->BindParam(2, $two);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(PPD_TOT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}		
	}
	// 20 AUG 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingprocedures($patientcode,$instcode){
		$rant = 1 ; 
		$sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures where PPD_PATIENTCODE = ? AND PPD_INSTCODE = ? AND PPD_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $rant);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){					
				return '2';
			}else{
				return '1';
			}

		}else{
			return '-1';
		}
			
	}
	// 20 Sept 2023, 16 JULY  2021 JOSEPH ADORBOE 
	public function getpatientprodceuredetails($idvalue){
		$sqlstmt = ("SELECT   PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_BILLING,PPD_GENDER,PPD_AGE,PPD_CONSULTATIONSTATE,PPD_PROCEDURECODE from octopus_patients_procedures where PPD_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PPD_VISITCODE'].'@'.$object['DT'].'@'.$object['PPD_PATIENTCODE'].'@'.$object['PPD_PATIENTNUMBER'].'@'.$object['PPD_PATIENT'].'@'.$object['PPD_TYPE'].'@'.$object['PPD_BILLING'].'@'.$object['PPD_PAYMENTMETHOD'].'@'.$object['PPD_PAYSCHEME'].'@'.$object['PPD_PAYSCHEMECODE'].'@'.$object['PPD_PAYMENTTYPE'].'@'.$object['PPD_GENDER'].'@'.$object['PPD_AGE'].'@'.$object['PPD_PAYMENTMETHODCODE'].'@'.$object['PPD_CONSULTATIONSTATE'].'@'.$object['PPD_PROCEDURECODE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprocedurelist($currentuserlevel,$currentusercode,$instcode){	
		if($currentuserlevel == '5'){
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_AGE,PPD_GENDER,PPD_CONSULTATIONSTATE from octopus_patients_procedures where PPD_STATUS IN('1','2','4','6') and PPD_INSTCODE = '$instcode' and PPD_COMPLETE = '1' AND PPD_ACTORCODE = '$currentusercode' order by PPD_ID DESC ");
		}else if($currentuserlevel == '4'){
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_AGE,PPD_GENDER,PPD_CONSULTATIONSTATE from octopus_patients_procedures where PPD_STATUS IN('1','2','4','6') and PPD_INSTCODE = '$instcode' and PPD_NOTES IS NULL order by PPD_ID DESC ");		
		}else{
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_AGE,PPD_GENDER,PPD_CONSULTATIONSTATE from octopus_patients_procedures where PPD_STATUS IN('1','2','4','6') and PPD_INSTCODE = '$instcode' and PPD_COMPLETE = '1' order by PPD_ID DESC ");
		
		}	
		return $procedurerequest;
		
	}
	// 20 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprocedurepastedlist($currentuserlevel,$currentusercode,$instcode){
		if($currentuserlevel == '5'){
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_CONSULTATIONSTATE,PPD_AGE,PPD_GENDER from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_COMPLETE = '2' AND PPD_ACTORCODE = '$currentusercode' order by PPD_ID DESC LIMIT 500");
		}else if($currentuserlevel == '4'){
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_CONSULTATIONSTATE,PPD_AGE,PPD_GENDER from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_NOTES IS NOT NULL  order by PPD_ID DESC LIMIT 500 ");
		}else{
			$procedurerequest  = ("SELECT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_CONSULTATIONSTATE,PPD_AGE,PPD_GENDER from octopus_patients_procedures where PPD_INSTCODE = '$instcode' and PPD_COMPLETE = '2'  order by PPD_ID DESC LIMIT 500 ");		
		}
		return $procedurerequest;
	}
	// 19 SEPT 2023 JOSEPH ADORBOE
	public function getqueryservicebasketpatientprocedure($patientcode,$visitcode,$instcode){		
		$list = ("SELECT * from octopus_patients_procedures where PPD_PATIENTCODE = '$patientcode' and PPD_VISITCODE = '$visitcode' and PPD_INSTCODE = '$instcode'  order by PPD_STATUS DESC , PPD_ID DESC ");
		return $list;
	}
	// 3 SEPT 2023, 
	public function dischargeprocedure($patientcode,$visitcode,$instcode){
		$four = 4;
		$sql = "UPDATE octopus_patients_procedures SET PPD_CONSULTATIONSTATE = ? WHERE PPD_VISITCODE = ? and PPD_INSTCODE = ? AND PPD_PATIENTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $four);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $patientcode);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function selectedshowprocedures($selected,$patientcode,$visitcode,$unselected,$instcode){
		$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATUS = ? , PPD_SELECTED = ? WHERE PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_INSTCODE = ? AND PPD_PATIENTCODE = ?";
		$st = $this->db->prepare($sqlprocedure);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $patientcode);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function selectedpaidprocedures($selected,$paid,$patientcode,$visitcode,$unselected,$instcode){
		$sqlprocedure = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_STATUS = ? , PPD_SELECTED = ? , PPD_DISPENSE = ?  WHERE  PPD_VISITCODE = ? and  PPD_SELECTED = ? AND PPD_PATIENTCODE = ? ";
		$st = $this->db->prepare($sqlprocedure);
		$st->BindParam(1, $paid);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $unselected);
		$st->BindParam(7, $patientcode);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function reversecancelprocedures($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_STATUS = ?, PPD_COMPLETE = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $selected);
		$st->BindParam(3, $selected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $unselected);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 26 AUG 2023
	public function cancelprocedures($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_STATUS = ?, PPD_COMPLETE = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $unselected);
		$st->BindParam(3, $unselected);
		$st->BindParam(4, $servicecode);
		$st->BindParam(5, $visitcode);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $unselected);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function sendbackprocedures($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $unselected);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}

	// // 19 SEPT 2021 JOSEPH ADORBOE  transactioncode
	// public function getpendingprocedure($patientcode,$visitcode,$instcode){        
    //     $rant = '0' ;
    //     $sqlstmt = ("SELECT * FROM octopus_patients_procedures WHERE PPD_PATIENTCODE = ? AND PPD_INSTCODE = ? AND PPD_VISITCODE = ? AND PPD_STATE IN('1','2') ");
    //     $st = $this->db->prepare($sqlstmt);
    //     $st->BindParam(1, $patientcode);
    //     $st->BindParam(2, $instcode);
    //     $st->BindParam(3, $visitcode);
	//     $details =	$st->execute();
    //     if ($details) {
    //         if ($st->rowcount() > 0) {				
    //             return '2';
    //         } else {
    //             return '1';
    //         }
    //     } else {
    //         return '-1';
    //     }    			
	// }
	// 25 AUG 2023
	public function unselectprocedures($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_SELECTED = ? WHERE PPD_CODE = ? AND PPD_VISITCODE = ? AND PPD_INSTCODE = ? and PPD_SELECTED = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $unselected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $selected);
		$selectitem = $st->Execute();						
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	// 25 AUG 2023
	public function selectprocedures($selected,$servicecode,$visitcode,$unselected,$instcode){
		$sql = "UPDATE octopus_patients_procedures SET PPD_SELECTED = ? WHERE PPD_CODE = ? and PPD_VISITCODE = ? and PPD_SELECTED = ? and PPD_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $selected);
		$st->BindParam(2, $servicecode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $unselected);
		$st->BindParam(5, $instcode);
		$selectitem = $st->Execute();					
		if($selectitem){						
			return '2' ;						
		}else{						
			return '0' ;						
		}
	}
	
	
} 

$patientproceduretable = new OctopusPatientsProceduresClass();
?>