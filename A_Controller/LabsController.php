<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 29 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class LabsController Extends Engine{ 

	// 28 MAR 2022 JOSEPH ADORBOE
	public function getreportfees($reportfees,$cashschemecode,$instcode){
		$one = 1;
		$sql = ("SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_INSTCODE = ? AND PS_STATUS = ? AND PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $cashschemecode);
		$st->BindParam(4, $reportfees);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PS_PRICE'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '0';
		}
		
	}

	// 27 MAR 2023 JOSEPH ADORBOE
	public function returninvetigationrequest($bcode,$returnreason,$reportfeesamout,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_RETURN = ?, MIV_RETURNTIME = ? , MIV_RETURNACTOR = ?, MIV_RETURNACTORCODE = ? , MIV_RETURNREASON = ? , MIV_COST = MIV_COST + ? WHERE MIV_CODE = ? and  MIV_RETURN = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $reportfeesamout);
		$st->BindParam(7, $bcode);
		$st->BindParam(8, $zero);
		$st->BindParam(9, $instcode);
		$selectitem = $st->Execute();				
		if($selectitem){
			return '2' ;	
		}else{
			return '0' ;	
		}	
	}

	// 04 APR  2021 JOSEPH ADORBOE	  
	public function chargereportfees($form_key,$billingcode,$days,$day,$visitcode,$patientcode,$patientnumber,$patient,$reportfees,$serviceamount,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$billercode,$biller)
	{
		$nut = 2;
		$one =1;
		$zero = 0;
		$serviceitem = 'REPORT FEES';
		$cashscheme = 'CASH';
		$depts = 'IMAGING';
		// $sqlstmt = "SELECT * FROM octopus_patients_billitems WHERE B_VISITCODE = ? AND B_PATIENTCODE = ? AND B_INSTCODE = ? AND B_STATUS != ? AND B_ITEMCODE = ?";
		// $st = $this->db->prepare($sqlstmt);
		// $st->BindParam(1, $visitcode);
		// $st->BindParam(2, $patientcode);
		// $st->BindParam(3, $instcode);
		// $st->BindParam(4, $zero);
		// $st->BindParam(5, $reportfees);
		// $selectit = $st->execute();
		// if($selectit){
		// 	if($st->rowcount() >'0'){
		// 		return '1';
		// 	}else{
		
		$qty = 1 ;
		$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $billingcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $form_key);
		$st->BindParam(4, $form_key);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $patientcode);
		$st->BindParam(8, $patientnumber);
		$st->BindParam(9, $patient);
		$st->BindParam(10, $serviceitem);
		$st->BindParam(11, $reportfees);
		$st->BindParam(12, $cashpaymentmethodcode);
		$st->BindParam(13, $cashpaymentmethod);
		$st->BindParam(14, $cashschemecode);
		$st->BindParam(15, $cashscheme);
		$st->BindParam(16, $qty);
		$st->BindParam(17, $serviceamount);
		$st->BindParam(18, $serviceamount);
		$st->BindParam(19, $serviceamount);
		$st->BindParam(20, $instcode);
		$st->BindParam(21, $depts);
		$st->BindParam(22, $currentusercode);
		$st->BindParam(23, $currentuser);
		$st->BindParam(24, $currentshiftcode);
		$st->BindParam(25, $currentshift);	
		$st->BindParam(26, $one);
		$st->BindParam(27, $currentday);
		$st->BindParam(28, $currentmonth);
		$st->BindParam(29, $currentyear);
		$st->BindParam(30, $billercode);
		$st->BindParam(31, $biller);	
		$setbills = $st->execute();				
		if($setbills){				
			return '2';
		}else{
			return '0';
		}		
				
	//	}	
		// }else{					
		// 	return '0';					
		// }	
	}

	// 15 may 2022 
	public function bulkselectspecimen($form_key,$batchnumber,$mivcode,$requestcode,$samplecode,$samplename,$days,$partnercost,$vccode,$vcname,$day,$currentusercode,$currentuser,$instcode){
		$one = 1 ;
		$nt = 6 ;
		$sqlstmt = "SELECT * FROM octopus_cashier_partnerbills WHERE PC_STATUS = ? AND PC_INSTCODE = ?  AND PC_COMPANYCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $one);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $vccode);
		$selectit = $st->execute();
        if ($selectit) {
            if ($st->rowcount() >'0') {	
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$batchnumber = $obj['PC_BATCHNUMBER'];
				$batchcode = $obj['PC_CODE'];
				$sql = "UPDATE octopus_cashier_partnerbills SET PC_AMOUNT = PC_AMOUNT + ? , PC_NUMBEROFLABS = PC_NUMBEROFLABS + ? WHERE PC_CODE = ?   ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $partnercost);
				$st->BindParam(2, $one);
				$st->BindParam(3, $batchcode);
				$selectitem = $st->Execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SAMPLE = ?, MIV_SAMPLECODE = ?, MIV_SAMPLELABEL = ? , MIV_SAMPLEACTOR = ?, MIV_SAMPLEACTORCODE = ? , MIV_STATE = ? , MIV_SAMPLEDATE = ? , MIV_BATCHNUMBER = ? , MIV_BATCHCODE = ? , MIV_PARTNERSET = ? WHERE MIV_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $samplename);
				$st->BindParam(2, $samplecode);
				$st->BindParam(3, $requestcode);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $nt);
				$st->BindParam(7, $days);
				$st->BindParam(8, $batchnumber);
				$st->BindParam(9, $form_key);
				$st->BindParam(10, $one);
				$st->BindParam(11, $mivcode);
				$selectitem = $st->Execute();						
					if($selectitem){
						return '2' ;	
					}else{
						return '0' ;	
					}
							
            //    return '1';
            } else {
               
                $rt = 5 ;
				$sql = ("INSERT INTO octopus_cashier_partnerbills (PC_CODE,PC_BATCHNUMBER,PC_DATE,PC_AMOUNT,PC_NUMBEROFLABS,PC_ACTOR,PC_ACTORCODE,PC_INSTCODE,PC_COMPANYCODE,PC_COMPANY) VALUES (?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $batchnumber);
				$st->BindParam(3, $day);
				$st->BindParam(4, $partnercost);
				$st->BindParam(5, $one);
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $currentusercode);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $vccode);
				$st->BindParam(10, $vcname);
				$pbills = $st->execute();	

                $sql = "UPDATE octopus_patients_investigationrequest SET MIV_SAMPLE = ?, MIV_SAMPLECODE = ?, MIV_SAMPLELABEL = ? , MIV_SAMPLEACTOR = ?, MIV_SAMPLEACTORCODE = ? , MIV_STATE = ? , MIV_SAMPLEDATE = ? , MIV_BATCHNUMBER = ? , MIV_BATCHCODE = ? , MIV_PARTNERSET = ? WHERE MIV_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $samplename);
				$st->BindParam(2, $samplecode);
				$st->BindParam(3, $requestcode);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $nt);
				$st->BindParam(7, $days);
				$st->BindParam(8, $batchnumber);
				$st->BindParam(9, $form_key);
				$st->BindParam(10, $one);
				$st->BindParam(11, $mivcode);
				$selectitem = $st->Execute();				
				if($selectitem){
					return '2' ;	
				}else{
					return '0' ;	
				}

            }
        }else{
			return '0';
		}
	}


	// 12 MAR 2022 JOSEPH ADORBOE 
	public function archivepastedlabs($thearchivedate,$currentusercode,$currentuser,$instcode){
		$two = 2;
		$one = 1;
		$eight = 8 ;
        $five = 5 ;
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ? , MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ?, MIV_COMPLETE = ? WHERE MIV_DATE < ? AND MIV_STATE = ? AND MIV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $eight);
		$st->BindParam(2, $five);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $two);
		$st->BindParam(6, $thearchivedate);
		$st->BindParam(7, $one);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();
		
	}

	// 06 MAR 2022 JOSEPH ADORBOE
	public function getpartneratientlabstotal($instcode){
		$one = 1;
		$sql = ("SELECT SUM(PC_AMOUNT) FROM octopus_cashier_partnerbills WHERE PC_INSTCODE = ? AND PC_STATUS = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $one);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(PC_AMOUNT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}

	// 25 SEPT 2021 JOSEPH ADORBOE
	public function editlabsmanage($visitcode,$patientcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_PAYMENTMETHOD = ?, MIV_PAYMENTMETHODCODE = ? , MIV_SCHEMECODE = ?, MIV_SCHEME = ? ,MIV_PAYMENTTYPE = ? WHERE MIV_VISITCODE = ? and MIV_PATIENTCODE = ? and MIV_STATE = ?  ";
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
	
	// 18 JUN 2021 JOSEPH ADORBOE
	public function reverselabssentoutsingle($ekey, $currentusercode, $currentuser){
		$not = 1;
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ? , MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ? ,MIV_COMPLETE = ? WHERE MIV_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $not);
		$st->BindParam(6, $ekey);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 18 JUN 2021 JOSEPH ADORBOE
	public function reverselabssentout($bcode,$servicescode,$labstate,$currentusercode,$currentuser){
		$not = 1;
		$but = 8;
		$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ? , MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ? ,MIV_COMPLETE = ? WHERE MIV_CODE = ? and MIV_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $not);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $but);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 31 MAY 2021 JOSEPH ADORBOE
	public function getlabdashboard($currentusercode,$currentshiftcode,$instcode){
        $nut = 1;
		$stet = 6;
		$sentout = 8;
        $not = '0';
		$rt = 'LABS';
        $sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATUS = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $pendinglabs = $st->rowcount();
        } else {
            return '0';
        }
        $sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $stet);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $awaitingresults = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_patients_investigationrequest WHERE MIV_STATE = ? and MIV_INSTCODE = ? and MIV_CATEGORY = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $sentout);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $rt);
        $ext = $st->execute();
        if ($ext) {
            $labssentout = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_st_labtest WHERE LTT_STATUS = ? and LTT_INSTCODE = ? ';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
    //    $st->BindParam(3, $currentusercode);
        $ext = $st->execute();
        if ($ext) {
            $lablist = $st->rowcount();
        } else {
            return '0';
        }
                       
        //							0				1						2					3						4					5						6
        $labdashboarddetails = $pendinglabs.'@@@'.$awaitingresults.'@@@'.$labssentout.'@@@'.$lablist;
        
        return $labdashboarddetails;
    }
	
	// 01 JUN 2021 JOSEPH ADORBOE
	public function labssentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser){
		$one = 1;
		$two = 2;
		$rat = 0;
		// $sqlstmt = "SELECT * FROM octopus_patients_investigationrequest where  MIV_CODE = ? and MIV_STATE != ? ";
		// $st = $this->db->prepare($sqlstmt);
		// $st->BindParam(1, $bcode);
		// $st->BindParam(2, $one);
		// $selectit = $st->execute();
        // if ($selectit) {
        //     if ($st->rowcount() >'0') {
        //         return '1';
        //     } else {
                $eight = 8 ;
                $five = 5 ;
                $sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ? , MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ?, MIV_COMPLETE = ? WHERE MIV_CODE = ? and MIV_STATE = ?   ";
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $eight);
                $st->BindParam(2, $five);
                $st->BindParam(3, $currentuser);
                $st->BindParam(4, $currentusercode);
                $st->BindParam(5, $two);
				$st->BindParam(6, $bcode);
				$st->BindParam(7, $one);
                $selectitem = $st->Execute();
                if ($selectitem) {
                    return '2' ;
                } else {
                    return '0' ;
                }
        //    }
        // }else{
		// 	return '0';
		// }	
	}

	// 04 APR  2021 JOSEPH ADORBOE	  
	public function labsresults($resultcode,$testcode,$test,$requestcode,$mivcode,$patientcode,$patientnumber,$patient,$visitcode,$days,$attributecode,$attribute,$range,$resultval,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode)
	{
		$sev = 7 ;
		$det = 3;
		$sql = ("INSERT INTO octopus_patients_labresult (PLR_CODE,PLR_PATIENTCODE,PLR_PATIENTNUMBER,PLR_PATIENT,PLR_DATE,PLR_DATETIME,PLR_LABREQUESTCODE,PLR_REQUESTCODE,PLR_TESTCODE,PLR_TEST,PLR_VISITCODE,PLR_ATTRIBUTECODE,PLR_ATTRIBUTE,PLR_REFRANGE,PLR_VALUES,PLR_ACTOR,PLR_ACTORCODE,PLR_INSTCODE) 
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $resultcode);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumber);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $days);
		$st->BindParam(6, $days);
		$st->BindParam(7, $requestcode);
		$st->BindParam(8, $mivcode);
		$st->BindParam(9, $testcode);
		$st->BindParam(10, $test);
		$st->BindParam(11, $visitcode);
		$st->BindParam(12, $attributecode);
		$st->BindParam(13, $attribute);
		$st->BindParam(14, $range);
		$st->BindParam(15, $resultval);
		$st->BindParam(16, $currentuser);
		$st->BindParam(17, $currentusercode);
		$st->BindParam(18, $instcode);
		$setprice = $st->execute();				
		if($setprice){	
			$frt = 7;
			$nut = 3;
			$rt = 6;
			$tuo = 1;				
			$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_STATUS = ? , MIV_RESULTSTATE = ?  WHERE MIV_CODE = ? and MIV_STATE = ?  ";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $frt);
			$st->BindParam(2, $nut);
			$st->BindParam(3, $tuo);
			$st->BindParam(4, $mivcode);
			$st->BindParam(5, $rt);
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
	
	// 05 APR 2021 
	public function update_newsample($form_key,$batchnumber,$mivcode,$requestcode,$samplecode,$samplename,$days,$partnercost,$mcode,$day,$currentusercode,$currentuser,$instcode){
		$one = 1 ;
		$nt = 6 ;
		$sqlstmt = "SELECT * FROM octopus_cashier_partnerbills WHERE PC_STATUS = ? AND PC_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $one);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $instcode);
		$selectit = $st->execute();
        if ($selectit) {
            if ($st->rowcount() >'0') {	
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$batchnumber = $obj['PC_BATCHNUMBER'];
				$batchcode = $obj['PC_CODE'];
				$sql = "UPDATE octopus_cashier_partnerbills SET PC_AMOUNT = PC_AMOUNT + ? , PC_NUMBEROFLABS = PC_NUMBEROFLABS + ? WHERE PC_CODE = ?   ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $partnercost);
				$st->BindParam(2, $one);
				$st->BindParam(3, $batchcode);
				$selectitem = $st->Execute();

				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_SAMPLE = ?, MIV_SAMPLECODE = ?, MIV_SAMPLELABEL = ? , MIV_SAMPLEACTOR = ?, MIV_SAMPLEACTORCODE = ? , MIV_STATE = ? , MIV_SAMPLEDATE = ? , MIV_BATCHNUMBER = ? , MIV_BATCHCODE = ? , MIV_PARTNERSET = ? WHERE MIV_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $samplename);
				$st->BindParam(2, $samplecode);
				$st->BindParam(3, $requestcode);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $nt);
				$st->BindParam(7, $days);
				$st->BindParam(8, $batchnumber);
				$st->BindParam(9, $form_key);
				$st->BindParam(10, $one);
				$st->BindParam(11, $mivcode);
				$selectitem = $st->Execute();						
					if($selectitem){
						return '2' ;	
					}else{
						return '0' ;	
					}
							
            //    return '1';
            } else {
               
                $rt = 5 ;
				$sql = ("INSERT INTO octopus_cashier_partnerbills (PC_CODE,PC_BATCHNUMBER,PC_DATE,PC_AMOUNT,PC_NUMBEROFLABS,PC_ACTOR,PC_ACTORCODE,PC_INSTCODE) VALUES (?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $batchnumber);
				$st->BindParam(3, $day);
				$st->BindParam(4, $partnercost);
				$st->BindParam(5, $one);
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $currentusercode);
				$st->BindParam(8, $instcode);
				$pbills = $st->execute();	

                $sql = "UPDATE octopus_patients_investigationrequest SET MIV_SAMPLE = ?, MIV_SAMPLECODE = ?, MIV_SAMPLELABEL = ? , MIV_SAMPLEACTOR = ?, MIV_SAMPLEACTORCODE = ? , MIV_STATE = ? , MIV_SAMPLEDATE = ? , MIV_BATCHNUMBER = ? , MIV_BATCHCODE = ? , MIV_PARTNERSET = ? WHERE MIV_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $samplename);
				$st->BindParam(2, $samplecode);
				$st->BindParam(3, $requestcode);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $nt);
				$st->BindParam(7, $days);
				$st->BindParam(8, $batchnumber);
				$st->BindParam(9, $form_key);
				$st->BindParam(10, $one);
				$st->BindParam(11, $mivcode);
				$selectitem = $st->Execute();				
				if($selectitem){
					return '2' ;	
				}else{
					return '0' ;	
				}

            }
        }else{
			return '0';
		}
	}

	// 04 APR  2021 JOSEPH ADORBOE	  
	public function labssendtopayment($form_key,$billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller)
	{
		$nut = 2;
		$rat = 0;
		$sqlstmt = "SELECT * FROM octopus_patients_investigationrequest where  MIV_CODE = ? and MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $nut);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() >'0'){
				return '1';
			}else{
		
				$qty = 1 ;
		if ($schemepricepercentage < 100) {
			$schemeamount = ($cost*$schemepricepercentage)/100;
			$patientamount = $cost - $schemeamount ;
			$rtn = 1;
			$cash = 'CASH';

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
			$st->BindParam(17, $schemeamount);
			$st->BindParam(18, $schemeamount);
			$st->BindParam(19, $schemeamount);
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

			
			$formkey = md5(microtime());
			$sql = ("INSERT INTO octopus_patients_billitems (B_CODE,B_VISITCODE,B_SERVCODE,B_BILLCODE,B_DT,B_DTIME,B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_METHODCODE,B_METHOD,B_PAYSCHEMECODE,B_PAYSCHEME,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_INSTCODE,B_DPT,B_ACTORCODE,B_ACTOR,B_SHIFTCODE,B_SHIFT,B_PAYMENTTYPE,B_DAY,B_MONTH,B_YEAR,B_BILLERCODE,B_BILLER) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $formkey);
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
			$st->BindParam(12, $cashpaymentmethodcode);
			$st->BindParam(13, $cashpaymentmethod);
			$st->BindParam(14, $cashschemecode);
			$st->BindParam(15, $cash);
			$st->BindParam(16, $qty);
			$st->BindParam(17, $patientamount);
			$st->BindParam(18, $patientamount);
			$st->BindParam(19, $patientamount);
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


		}else{
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
		}			
		if($setprice){			
			$sqlstmt = "UPDATE octopus_patients_bills SET BILL_AMOUNT = BILL_AMOUNT + ?  WHERE BILL_CODE = ?";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $cost);
			$st->BindParam(2, $billcode);
			$setbills = $st->execute();
			if($setbills){
				if($patientpaymenttype == '7'){

					$frt = 9;
					$nut = 2;
					$not = 3;				
					$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_BILLINGCODE = ? , MIV_STATUS = ? WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $frt);
					$st->BindParam(2, $billcode);
					$st->BindParam(3, $not);
					$st->BindParam(4, $bcode);
					$st->BindParam(5, $nut);
					$setbills = $st->execute();
					if($setbills){				
						return '2';
					}else{
						return '0';
					}

				}else if($patientpaymenttype == '1'){
					$frt = 3;
					$nut = 2;				
					$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_BILLINGCODE = ? WHERE MIV_CODE = ? and MIV_STATE = ?  ";
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
				}else{
					return '2';
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

	

	
	// 04 APR 2021 JOSEPH ADORBOE 
	public function getpatienttransactiondetails($idvalue){
		$sqlstmt = ("SELECT DISTINCT MIV_VISITCODE,MIV_DATE,MIV_PATIENTCODE,MIV_PATIENTNUMBER,MIV_PATIENT,MIV_CATEGORY,MIV_BILLINGCODE,MIV_PAYMENTMETHOD,MIV_PAYMENTMETHOD,MIV_SCHEMECODE,MIV_SCHEME,MIV_TYPE,MIV_PAYMENTTYPE,MIV_CONSULTATIONSTATE,MIV_GENDER,MIV_AGE FROM octopus_patients_investigationrequest where MIV_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_VISITCODE'].'@'.$object['MIV_DATE'].'@'.$object['MIV_PATIENTCODE'].'@'.$object['MIV_PATIENTNUMBER'].'@'.$object['MIV_PATIENT'].'@'.$object['MIV_CATEGORY'].'@'.$object['MIV_BILLINGCODE'].'@'.$object['MIV_PAYMENTMETHOD'].'@'.$object['MIV_SCHEME'].'@'.$object['MIV_SCHEMECODE'].'@'.$object['MIV_TYPE'].'@'.$object['MIV_PAYMENTTYPE'].'@'.$object['MIV_CONSULTATIONSTATE'].'@'.$object['MIV_GENDER'].'@'.$object['MIV_AGE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}
	
	// 04 APR 2021 JOSEPH ADORBOE
	public function getpatientlabstotal($visitcode){
		$rty = 2;
		$sql = ("SELECT SUM(MIV_COST) FROM octopus_patients_investigationrequest where MIV_VISITCODE = ? and MIV_STATE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(MIV_COST)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}

	// 04 APR 2021 JOSEPH ADORBOE  transactioncode
	public function getlabrequestdetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_investigationrequest where MIV_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MIV_TEST'].'@'.$object['MIV_TESTCODE'].'@'.$object['MIV_SCHEMECODE'].'@'.$object['MIV_SCHEME'].'@'.$object['MIV_PAYMENTMETHOD'].'@'.$object['MIV_PAYMENTMETHODCODE'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 3MAR 2021 JOSEPH ADORBOE	  
	public function setpricelabs($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$mdsitemprice,$currentuser,$currentusercode,$instcode)
	{
		
		$but = 1;
		$cate = '*';
		$nut = 2;
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and PS_PAYMENTMETHODCODE = ? and PS_PAYSCHEMECODE = ? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $methodcode);
		$st->BindParam(3, $schemcode);
		$st->BindParam(4, $but);
		$checkprice = $st->execute();
		if($checkprice){
			if($st->rowcount() > 0){			
				$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_COST = ? , MIV_STATE = ?  WHERE MIV_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $itemprice);
					$st->BindParam(2, $nut);
					$st->BindParam(3, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						return '2';
					}else{
						return '0';
					}
				
			}else{	
		
				$sql = ("INSERT INTO octopus_st_pricing (PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHODCODE,PS_PAYMENTMETHOD,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_OTHERPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ");
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $type);
				$st->BindParam(3, $itemcode);
				$st->BindParam(4, $item);
				$st->BindParam(5, $itemprice);
				$st->BindParam(6, $methodcode);
				$st->BindParam(7, $method);
				$st->BindParam(8, $schemcode);
				$st->BindParam(9, $schemename);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $mdsitemprice);
				$setprice = $st->execute();				
				if($setprice){					
					$sqlstmt = "UPDATE octopus_patients_investigationrequest SET MIV_COST = ? , MIV_STATE = ? , MIV_PARTNERCOST = ?  WHERE MIV_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $itemprice);
					$st->BindParam(2, $nut);
					$st->BindParam(3, $mdsitemprice);
					$st->BindParam(4, $transactioncode);
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

	// 03 APR 2021 
	public function labsunselectedlabs($bcode,$currentusercode,$currentuser){

		$nut = 2;
		$rat = 0;
		$sqlstmt = "SELECT * FROM octopus_patients_investigationrequest where  MIV_CODE = ? and MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $nut);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() >'0'){
				return '1';
			}else{
				$nt = 1 ;
				$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_PROCESSACTOR = ?, MIV_PROCESSACTORCODE = ? , MIV_COST = ?,  MIV_PARTNERCOST = ?  WHERE MIV_CODE = ? and MIV_STATE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nt);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $rat);
				$st->BindParam(5, $rat);
				$st->BindParam(6, $bcode);
				$st->BindParam(7, $nut);
				$selectitem = $st->Execute();				
					if($selectitem){
						return '2' ;	
					}else{
						return '0' ;	
					}

            	}
			}else{
				return '0';
			}							
	}	

	// 03 APR 2021 
	public function labsselectedlabs($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$serviceamount,$partneramount,$currentusercode,$currentuser){

		$nut = 1;
		$rat = 2;
		$sqlstmt = "SELECT * FROM octopus_patients_investigationrequest where  MIV_CODE = ? and MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $nut);
		$selectit = $st->execute();
		if($selectit){
			if($st->rowcount() >'0'){
				return '1';
			}else{
				if($serviceamount == '-1'){
					$but = 1 ;
					$sql = "UPDATE octopus_patients_investigationrequest SET MIV_COST = ? , MIV_PROCESSACTOR = ? , MIV_PROCESSACTORCODE = ?, MIV_PARTNERCOST = ?   WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $serviceamount);
					$st->BindParam(2, $currentuser);
					$st->BindParam(3, $currentusercode);
					$st->BindParam(4, $partneramount);
					$st->BindParam(5, $bcode);
					$st->BindParam(6, $nut);
					$selectitem = $st->Execute();				
					if($selectitem){
						return '2' ;	
					}else{
						return '0' ;	
					}

				}else{
					$but = 2 ;
					$sql = "UPDATE octopus_patients_investigationrequest SET MIV_STATE = ?, MIV_COST = ? , MIV_PROCESSACTOR = ? , MIV_PROCESSACTORCODE = ? , MIV_PARTNERCOST = ?  WHERE MIV_CODE = ? and MIV_STATE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $rat);
					$st->BindParam(2, $serviceamount);
					$st->BindParam(3, $currentuser);
					$st->BindParam(4, $currentusercode);
					$st->BindParam(5, $partneramount);
					$st->BindParam(6, $bcode);
					$st->BindParam(7, $nut);
					$selectitem = $st->Execute();				
					if($selectitem){
						return '2' ;	
					}else{
						return '0' ;	
					}

				}
						
			}
		}else{
			return '0';
		}	
	}	

	// 29 MAR 2021,  JOSEPH ADORBOE
    public function insert_newattribute($form_key,$attribute,$range,$testcode,$testname,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT LR_ID FROM octopus_st_labresulttemplate where LR_ATTRIBUTE = ? and LR_TESTCODE = ?  and LR_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $attribute);
		$st->BindParam(2, $testcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labresulttemplate(LR_CODE,LR_ATTRIBUTE,LR_TESTCODE,LR_TEST,LR_REFRANGE,LR_DESC,LR_ACTOR,LR_ACTORCODE) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $attribute);
				$st->BindParam(3, $testcode);
				$st->BindParam(4, $testname);
				$st->BindParam(5, $range);
				$st->BindParam(6, $description);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				
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
	
	// 30 MAR 2021 JOSEPH ADORBOE 
	public function getlabtestdetails($idvalue){
		$nm = 2;		
		$sqlstmt = ("SELECT * FROM octopus_st_labtest where LTT_CODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['LTT_CODE'].'@'.$object['LTT_NAME'].'@'.$object['LTT_DISCIPLINECODE'].'@'.$object['LTT_DISCIPLINE'].'@'.$object['LTT_DESC'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '1';
		}			
	}	
	
	// 29 MAR 2021,  JOSEPH ADORBOE
    public function insert_newlabstest($form_key,$labtest,$disccode,$discname,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest where LTT_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labtest);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_NAME,LTT_DESC,LTT_DISCIPLINECODE,LTT_DISCIPLINE,LTT_ACTORCODE,LTT_ACTOR) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $labtest);
				$st->BindParam(3, $description);
				$st->BindParam(4, $disccode);
				$st->BindParam(5, $discname);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $currentuser);
				
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

	// 29 MAR 2021,  JOSEPH ADORBOE
    public function insert_newdiscipline($form_key,$discipline,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT LD_ID FROM octopus_st_labdiscipline where LD_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $discipline);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labdiscipline(LD_CODE,LD_NAME,LD_DESC,LD_ACTORCODE,LD_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $discipline);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
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

	// 29 MAR 2021,  JOSEPH ADORBOE
    public function insert_newspecimen($form_key,$specimen,$description,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT SP_ID FROM octopus_st_labspecimen where SP_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $specimen);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labspecimen(SP_CODE,SP_NAME,SP_DESC,SP_ACTORCODE,SP_ACTOR) 
				VALUES (?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $specimen);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				
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
	
	public function update_specimen($ekey,$specimen,$storyline,$currentusercode,$currentuser,$instcode){

		$sql = "UPDATE octopus_st_labspecimen SET SP_NAME = ?, SP_DESC = ?,  SP_ACTOR = ?, SP_ACTORCODE =?  WHERE SP_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $specimen);
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