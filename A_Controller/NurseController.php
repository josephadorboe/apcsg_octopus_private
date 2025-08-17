<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 11 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class NurseController Extends Engine{

	 // 13 FEB 2022 JOSEPH ADORBOE
	 public function enterprocedurenotesreports($ekey, $procedurereport,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear){
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

	// 16 JULY 2021 JOSEPH ADORBOE
	public function cancelprocedures($bcode, $days,$patientcode, $visitcode, $currentusercode, $currentuser, $instcode){
		$not = '0';
		$fut = '1';
		$sql = "UPDATE octopus_patients_procedures SET PPD_STATUS = ?, PPD_STATE = ? , PPD_COMPLETE = ? , PPD_PROCESSTIME = ?, PPD_PACTOR = ?, PPD_PACTORCODE = ? WHERE PPD_CODE = ? and PPD_INSTCODE = ? AND PPD_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $not);
		$st->BindParam(4, $days);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
        $st->BindParam(7, $bcode);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $fut);
	//	$st->BindParam(10, $fut);	
		$selectitem = $st->Execute();	
		
		$sql = "UPDATE octopus_patients_billitems SET B_STATUS = ?, B_STATE = ? , B_COMPLETE = ? , B_PAYACTOR = ?, B_PAYACTORCODE = ? WHERE B_CODE = ? and B_INSTCODE = ? AND B_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $not);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $bcode);
        $st->BindParam(7, $instcode);
		$st->BindParam(8, $fut);
	//	$st->BindParam(9, $fut);
	//	$st->BindParam(10, $fut);	
		$selectitem = $st->Execute();	
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}


	// 24 JULY 2021 JOSEPH ADORBOE
	public function getpatientconsultation($patientcode){
		$rty = '0';
		$sql = ("SELECT CON_ID FROM octopus_patients_consultations where CON_PATIENTCODE = ? and CON_STATUS != ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				return '2';
			}else{
				return '1';
			}
		}else{
			return '-1';
		}
		
	}


    // 16 JULY 2021 JOSEPH ADORBOE
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

    // 16 JULY 2021 JOSEPH ADORBOE  transactioncode
	public function getprocedurerequestdetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_procedures where PPD_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PPD_PROCEDURE'].'@'.$object['PPD_PROCEDURECODE'].'@'.$object['PPD_PAYSCHEMECODE'].'@'.$object['PPD_PAYSCHEME'].'@'.$object['PPD_PAYMENTMETHOD'].'@'.$object['PPD_PAYMENTMETHODCODE'].'@'.$object['PPD_QUANTITY'].'@'.$object['PPD_STATE'].'@'.$object['PPD_STATUS'].'@'.$object['PPD_PROCEDURENUMBER'].'@'.$object['PPD_DATE'].'@'.$object['PPD_PROCESSTIME'].'@'.$object['PPD_PACTOR'].'@'.$object['PPD_REMARK'].'@'.$object['PPD_NOTES'].'@'.$object['PPD_REPORT']  ;
				return $results;
			}else{
				return'1';
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

    // 16 JULY 2021 JOSEPH ADORBOE	  
	public function procesuresendtopayment($form_key,$billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$patienttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller)
	{
		$not = 2;
		$sql = "SELECT * FROM octopus_patients_procedures where PPD_CODE = ? and PPD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $not);
		$seth = $st->execute();
		if($seth){
			if($st->rowcount()>'0'){
				$qty = 1 ;
				$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $billingcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $bcode);
				$st->BindParam(4, $billcode);
				$st->BindParam(5, $day);
				$st->BindParam(6, $days);
				$st->BindParam(7, $patientcode);
				$st->BindParam(8, $patientnumber);
				$st->BindParam(9, $patient);
				$st->BindParam(10, $serviceitem);
				$st->BindParam(11, $servicescode);
				$st->BindParam(12, $paymentmethodcode);
				$st->BindParam(13, $paymentmethod);
				$st->BindParam(14, $paymentschemecode);
				$st->BindParam(15, $paymentscheme);
				$st->BindParam(16, $qty);
				$st->BindParam(17, $cost);
				$st->BindParam(18, $cost);
				$st->BindParam(19, $cost);
				$st->BindParam(20, $instcode);
				$st->BindParam(21, $depts);
				$st->BindParam(22, $currentusercode);
				$st->BindParam(23, $currentuser);
				$st->BindParam(24, $currentshiftcode);
				$st->BindParam(25, $currentshift);
				$st->BindParam(26, $patientpaymenttype);	
				$st->BindParam(27, $currentday);
				$st->BindParam(28, $currentmonth);
				$st->BindParam(29, $currentyear);
				$st->BindParam(30, $billercode);	
				$st->BindParam(31, $biller);	
				$setprice = $st->execute();				
				if($setprice){	
					$sqlstmt = "UPDATE octopus_patients_bills SET BILL_AMOUNT = BILL_AMOUNT + ?  WHERE BILL_CODE = ? ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $cost);
					$st->BindParam(2, $billcode);
					$setbills = $st->execute();
					if($setbills){

						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_medications SET MED_STATE = ?  WHERE MED_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $wet);
						$st->BindParam(2, $servicescode);
						$setmed = $st->execute();
						if($setmed) {
							if ($patientpaymenttype == '7') {

								$frt = 9;
								$nut = 2;
								$not = 6;	
								$twu = 1;		
								$sqlstmt = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_BILLING = ?, PPD_STATUS = ? , PPD_DISPENSE = ? WHERE PPD_CODE = ? and PPD_STATE = ?  ";
								$st = $this->db->prepare($sqlstmt);
								$st->BindParam(1, $frt);
								$st->BindParam(2, $billcode);
								$st->BindParam(3, $not);
								$st->BindParam(4, $twu);
								$st->BindParam(5, $bcode);
								$st->BindParam(6, $nut);
								$setbills = $st->execute();
								if($setbills){
									return '2';
								}else{
									return '0';
								}
			
							}else if($patientpaymenttype == '1'){
								$frt = 3;
								$nut = 2;				
								$sqlstmt = "UPDATE octopus_patients_procedures SET PPD_STATE = ?, PPD_BILLING = ? WHERE PPD_CODE = ? and PPD_STATE = ?  ";
								$st = $this->db->prepare($sqlstmt);
								$st->BindParam(1, $frt);
								$st->BindParam(2, $billcode);
								$st->BindParam(3, $bcode);
								$st->BindParam(4, $nut);
								$setbills = $st->execute();
								if($setbills){
									return '2';
								}else{
									return '0';
								}
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
				return '1';
			}

		}else{
			return '0';
		}	
	}


    // 16 JULY 2021 JOSEPH ADORBOE 
	public function unselectprocedure($bcode,$days,$currentusercode,$currentuser){
        $not = 2 ;
        $sql = "SELECT * FROM octopus_patients_procedures WHERE PPD_CODE = ? AND PPD_STATE = ? ";
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $bcode);
        $st->BindParam(2, $not);
        $exe = $st->execute();
        if($exe){
            if($st->rowcount()>'0'){
                $vt = 0;
                $nt = 1;		
                $sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ? ,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $nt);
                $st->BindParam(2, $vt);
                $st->BindParam(3, $days);
                $st->BindParam(4, $currentuser);
                $st->BindParam(5, $currentusercode);
                $st->BindParam(6, $vt);
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



    // 18 JULY  2021 JOSEPH ADORBOE 
	public function precedureselection($bcode,$days,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode){
		
		$not = 1;
		$sql = "SELECT * from octopus_patients_procedures where PPD_CODE = ? and PPD_INSTCODE = ? and PPD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $not);
		$acti = $st->execute();
	//	die;
		if($acti){
			
			if($st->rowcount()>0){
				if($totalamount == '-1'){
					$sql = "UPDATE octopus_patients_procedures SET PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ?,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
					$st = $this->db->prepare($sql);
				//	$st->BindParam(1, $nt);
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
					$nt = 2 ;
					$sql = "UPDATE octopus_patients_procedures SET PPD_STATE = ? , PPD_TOT = ? , PPD_PROCESSTIME = ? , PPD_PACTOR = ? , PPD_PACTORCODE = ?,PPD_UNITCOST = ?  WHERE PPD_CODE = ?   ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nt);
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
	public function getpatientproceduretotal($visitcode){
		$rty = 2;
		$sql = ("SELECT SUM(PPD_TOT) FROM octopus_patients_procedures where PPD_VISITCODE = ? and PPD_STATE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
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

    // 16 JULY  2021 JOSEPH ADORBOE 
	public function getpatientprodceuredetails($idvalue){
		$sqlstmt = ("SELECT DISTINCT  PPD_PATIENTCODE,DATE(PPD_DATE) AS DT ,PPD_PATIENTNUMBER,PPD_PATIENT,PPD_VISITCODE,PPD_PAYMENTMETHOD,PPD_PAYMENTMETHODCODE,PPD_PAYSCHEMECODE,PPD_PAYSCHEME,PPD_TYPE,PPD_PAYMENTTYPE,PPD_BILLING,PPD_GENDER,PPD_AGE,PPD_CONSULTATIONSTATE,PPD_PROCEDURECODE from octopus_patients_procedures where PPD_VISITCODE = ?");
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

	// 25 MAY 2021 JOSEPH ADORBOE  
	public function getnursedashboard($currentusercode,$currentshiftcode,$day,$instcode){
        $nut = 1;
        $not = '0';
        $rat = 2;
        $but = 3;
        $sql = 'SELECT * FROM octopus_patients_servicesrequest WHERE REQU_VITALSTATUS = ? and REQU_INSTCODE = ? and REQU_STATE = ? and date(REQU_DATE) = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $not);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $nut);
        $st->BindParam(4, $day);
        $ext = $st->execute();
        if ($ext) {
            $vitals = $st->rowcount();
        } else {
            return '0';
        }
        
        $sql = 'SELECT * FROM octopus_patients_servicesrequest WHERE REQU_VITALSTATUS = ? and REQU_INSTCODE = ? and REQU_STATE = ? and date(REQU_DATE) = ? and REQU_STAGE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $nut);
        $st->BindParam(4, $day);
        $st->BindParam(5, $rat);
        $ext = $st->execute();
        if ($ext) {
            $patientqueue = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_patients_servicesrequest WHERE REQU_VITALSTATUS = ? and REQU_INSTCODE = ? and date(REQU_DATE) = ? and REQU_STAGE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
   //     $st->BindParam(3, $nut);
        $st->BindParam(3, $day);
        $st->BindParam(4, $but);
        $ext = $st->execute();
        if ($ext) {
            $servicebasket = $st->rowcount();
        } else {
            return '0';
        }
            
            
        //							0				1					2							3						4					5						6
        $nursedashboarddetails = $vitals.'@@@'.$patientqueue.'@@@'.$servicebasket;
        
        return $nursedashboarddetails;
    }			
		
	

	
	
} 
?>