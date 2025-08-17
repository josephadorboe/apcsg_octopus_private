<?php
/*  AUTHOR: JOSEPH ADORBOE
	DATE: 23 APR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PharmacyController Extends Engine{

	// 13 JUN 2021 JOSEPH ADORBOE
	public function extendexpiry($ekey,$expirydate,$days,$currentuser,$currentusercode,$instcode){
		$nt = 2 ;
		$rt = 0 ;
		$one  = 1;
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ?, EXP_EXPIRYDATE = ? , EXP_QTYLEFT = ?, EXP_PROCESSACTOR = ? , EXP_PROCESSACTORCODE = ?  WHERE EXP_CODE = ? AND EXP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $expirydate);
		$st->BindParam(3, $rt);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}		
	}


	// // 20 APR 2023 JOSEPH ADORBOE
	// public function extendexpiry($ekey,$expirydate,$days,$currentuser,$currentusercode){
	// 	$nt = 2 ;
	// 	$zero = 0 ;
	// 	$one = 1;
	// 	// echo $ekey;
	// 	// die;
	// 	$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ?, EXP_EXPIRYDATE = ? , EXP_QTYLEFT = ?, EXP_PROCESSACTOR = ? , EXP_PROCESSACTORCODE = ?  WHERE EXP_CODE = ? AND EXP_INSTCODE = ?  ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $one);
	// 	$st->BindParam(2, $expirydate);
	// 	$st->BindParam(3, $zero);
	// 	$st->BindParam(4, $currentuser);
	// 	$st->BindParam(5, $currentusercode);
	// 	$st->BindParam(6, $ekey);
	// 	$st->BindParam(7, $instcode);
	// 	$selectitem = $st->Execute();			
	// 	if($selectitem){								
	// 		return '2';								
	// 	}else{								
	// 		return '0';								
	// 	}				
			
	// }

	// 20 APR 2023 JOSEPH ADORBOE
	public function closeexpiry($ekey,$days,$currentuser,$currentusercode,$instcode){
		$nt = 2 ;
		$zero = 0 ;
		// echo $ekey,$days,$currentuser,$currentusercode;
		// die;
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ?, EXP_DATEPROCESSED = ? , EXP_QTYLEFT = ?, EXP_PROCESSACTOR = ? , EXP_PROCESSACTORCODE = ?  WHERE EXP_CODE = ? AND EXP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $days);
		$st->BindParam(3, $zero);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();			
		if($selectitem){								
			return '2';								
		}else{								
			return '0';								
		}				
			
	}

	// 27 NOV 2022
	public function getmedicationtotals($cashpaymentmethodcode,$day,$instcode){
		$zero = '0';
		$two = 2;
		$sqlstmt = ("SELECT SUM(PRESC_TOT) AS TOTCASH from octopus_patients_prescriptions where PRESC_PAYMENTMETHODCODE = ? and PRESC_DISPENSE = ? AND PRESC_INSTCODE = ? AND  date(PRESC_DISPENSEDATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $cashpaymentmethodcode);
        $st->BindParam(2, $two);
        $st->BindParam(3, $instcode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['TOTCASH'];
		}else{
			$res = '0';
		}

		$sqlstmt = ("SELECT SUM(PRESC_TOT) AS TOTCASH from octopus_patients_prescriptions where PRESC_PAYMENTMETHODCODE != ? and PRESC_DISPENSE = ? AND PRESC_INSTCODE = ? AND  date(PRESC_DISPENSEDATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $cashpaymentmethodcode);
        $st->BindParam(2, $two);
        $st->BindParam(3, $instcode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ress = $obj['TOTCASH'];
		}else{
			$ress = '0';
		}
		$tot = $res +$ress;

		return $res.'@'.$ress.'@'.$tot;

	}

	// 13 MAR 2022 JOSEPH ADORBOE
	public function archivepastedprescriptions($thearchivedate,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_ARCHIVE = ?,  PRESC_PROCESSACTOR = ?, PRESC_PROCESSACTORCODE = ? WHERE PRESC_DATE < ? and  PRESC_ARCHIVE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $thearchivedate);
		$st->BindParam(5, $zero);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 19 SEPT 2021 JOSEPH ADORBOE  transactioncode
	public function getpatientconsultationstatus($patientcode,$visitcode,$types,$instcode){
        if ($types == 'WALK IN') {
            return '2';
        } else {        
        $rant = '0' ;
        $sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_PATIENTCODE = ? AND CON_INSTCODE = ? AND CON_VISITCODE = ? AND CON_COMPLETE != ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $patientcode);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $visitcode);
		$st->BindParam(4, $rant);
        $details =	$st->execute();
        if ($details) {
            if ($st->rowcount() > 0) {				
                return '2';
            } else {
                return '1';
            }
        } else {
            return '-1';
        }
    }
			
	}

	// 20 AUG 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingprocedure($patientcode,$instcode){
		$rant = 1 ; 
		$sqlstmt = ("SELECT * FROM octopus_patients_procedures where PPD_PATIENTCODE = ? AND PPD_INSTCODE = ? AND PPD_STATUS = ? ");
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

	// 20 AUG 2021 JOSEPH ADORBOE 
	public function editnewdevices($ekey,$devices,$currentuser,$currentusercode,$instcode){
		
		$sql = "UPDATE octopus_st_devices SET DEV_DEVICE = ?  WHERE DEV_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $devices);
		$st->BindParam(2, $ekey);						
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}				
	
	}
	


	// 26 JULY 2021 JOSEPH ADORBOE
	public function reversesendoutdevicepharmacysingle($ekey, $currentusercode, $currentuser){
		$not = 1;
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ? , PD_PROCESSACTOR = ?, PD_PROCESSACTORCODE = ? ,PD_COMPLETE = ? WHERE PD_CODE = ?   ";
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


	

	// 29 JUNE 2021 JOSEPH ADORBOE	  
	public function setpricedeviceprescription($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$totalprice,$currentuser,$currentusercode,$instcode)
	{
		//die;
		$but = 1;
		$cate = '*';
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and PS_PAYMENTMETHODCODE =? and PS_PAYSCHEMECODE =? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $methodcode);
		$st->BindParam(3, $schemcode);
		$st->BindParam(4, $but);
		$checkprice = $st->execute();
		if($checkprice){
			if($st->rowcount() > 0){
				$nt = 2 ;			
				$sqlstmt = "UPDATE octopus_patients_devices SET PD_TOT = ?, PD_STATE = ?, PD_UNITCOST = ?  WHERE PD_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $totalprice);
					$st->BindParam(2, $nt);
					$st->BindParam(3, $totalprice);
					$st->BindParam(4, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_devices SET DEV_STATE = ?  WHERE DEV_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $wet);
						$st->BindParam(2, $itemcode);
						$setmed = $st->execute();
						if($setbills){
							return '2';
						}else{
							return '0';
						}
					}else{
						return '0';
					}
				
			}else{	
		
				$sql = ("INSERT INTO octopus_st_pricing (PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHODCODE,PS_PAYMENTMETHOD,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
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
				$setprice = $st->execute();				
				if($setprice){	
					$nt = 2;				
					$sqlstmt = "UPDATE octopus_patients_devices SET PD_TOT = ?, PD_STATE = ?, PD_UNITCOST = ? WHERE PD_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $totalprice);
					$st->BindParam(2, $nt);
					$st->BindParam(3, $itemprice);
					$st->BindParam(4, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_devices SET DEV_STATE = ?  WHERE DEV_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $wet);
						$st->BindParam(2, $itemcode);
						$setmed = $st->execute();
						if($setbills){
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
	
	// 28 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getdeviceprescriptionrequestdetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_devices where PD_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PD_DEVICE'].'@'.$object['PD_DEVICECODE'].'@'.$object['PD_SCHEMECODE'].'@'.$object['PD_SCHEME'].'@'.$object['PD_PAYMENTMETHOD'].'@'.$object['PD_PAYMENTMETHODCODE'].'@'.$object['PD_QTY'].'@'.$object['PD_STATE'].'@'.$object['PD_STATUS'].'@'.$object['PD_REQUESTCODE'].'@'.$object['PD_DATE'].'@'.$object['PD_PROCESSTIME'].'@'.$object['PD_PROCESSACTOR']  ;
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 28 JUNE 2021 JOSEPH ADORBOE 
	public function getpatientdeviceprescriptiondetails($idvalue){
		$sqlstmt = ("SELECT DISTINCT  PD_PATIENTCODE,PD_DATE,PD_PATIENTNUMBER,PD_PATIENT,PD_VISITCODE,PD_PAYMENTMETHOD,PD_PAYMENTMETHODCODE,PD_SCHEMECODE,PD_SCHEME,PD_TYPE,PD_PAYMENTTYPE,PD_GENDER,PD_AGE,PD_BILLINGCODE,PD_CONSULTATIONSTATE from octopus_patients_devices where PD_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PD_VISITCODE'].'@'.$object['PD_DATE'].'@'.$object['PD_PATIENTCODE'].'@'.$object['PD_PATIENTNUMBER'].'@'.$object['PD_PATIENT'].'@'.$object['PD_TYPE'].'@'.$object['PD_BILLINGCODE'].'@'.$object['PD_PAYMENTMETHOD'].'@'.$object['PD_SCHEME'].'@'.$object['PD_SCHEMECODE'].'@'.$object['PD_PAYMENTTYPE'].'@'.$object['PD_TYPE'].'@'.$object['PD_GENDER'].'@'.$object['PD_AGE'].'@'.$object['PD_PAYMENTMETHODCODE'].'@'.$object['PD_CONSULTATIONSTATE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}

	// 28 JUNE 2021 JOSEPH ADORBOE
	public function getpatientdeviceprescriptiontotal($visitcode){
		$rty = 2;
		$sql = ("SELECT SUM(PD_TOT) FROM octopus_patients_devices where PD_VISITCODE = ? and PD_STATE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(PD_TOT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}


	// 28 JUN 2021 JOSEPH ADORBOE
	public function editprescriptionmanage($visitcode,$patientcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_PAYMENTMETHOD = ?, PRESC_PAYMENTMETHODCODE = ? , PRESC_PAYSCHEMECODE = ?, PRESC_PAYSCHEME = ? ,PRESC_PAYMENTTYPE = ? WHERE PRESC_VISITCODE = ? and PRESC_PATIENTCODE = ? and PRESC_STATE = ?  ";
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

	// 27 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getpendingmedicaldevices($patientcode,$instcode){
		$rant = 1 ; 
		$sqlstmt = ("SELECT * FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_INSTCODE = ? AND PD_STATUS = ? ");
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
	
	// 28 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getinsurancestatus($patientcode,$visitcode,$privateinsurancecode,$partnercompaniescode,$nationalinsurancecode,$instcode){
		$nut = 1 ;
		$sqlstmt = ("SELECT * FROM octopus_patients_prescriptions where PRESC_PATIENTCODE = ? AND PRESC_VISITCODE = ? and PRESC_INSTCODE = ? and PRESC_COMPLETE = ? and PRESC_PAYMENTMETHODCODE IN(?,?,?) ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $nut);
		$st->BindParam(5, $privateinsurancecode);
		$st->BindParam(6, $partnercompaniescode);
		$st->BindParam(7, $nationalinsurancecode);
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

	// 28 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getdeviceinsurancestatus($patientcode,$visitcode,$privateinsurancecode,$partnercompaniescode,$nationalinsurancecode,$instcode){
		$nut = 1 ;
		$sqlstmt = ("SELECT * FROM octopus_patients_devices where PD_PATIENTCODE = ? AND PD_VISITCODE = ? and PD_INSTCODE = ? and PD_COMPLETE = ? and PD_PAYMENTMETHODCODE IN(?,?,?) ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $nut);
		$st->BindParam(5, $privateinsurancecode);
		$st->BindParam(6, $partnercompaniescode);
		$st->BindParam(7, $nationalinsurancecode);
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

	// 15 JUN 2021 JOSEPH ADORBOE
	public function reversepharmacysentout($bcode,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$currentusercode,$currentuser){
		$not = 1;
		$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_STATUS = ? , PRESC_PROCESSACTOR = ?, PRESC_PROCESSACTORCODE = ? ,PRESC_COMPLETE = ? WHERE PRESC_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $not);
		$st->BindParam(2, $not);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $not);
		$st->BindParam(6, $bcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	
	
	// 13 JUN 2021 JOSEPH ADORBOE
	public function removemedications($ekey, $medicationcode, $qtyleft, $days, $stockvalue,$currentuser, $currentusercode,$instcode){
		$nt = 2 ;
		$rt = 0 ;
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ?, EXP_DATEPROCESSED = ? , EXP_QTYLEFT = ?, EXP_PROCESSACTOR = ? , EXP_PROCESSACTORCODE = ?  WHERE EXP_CODE = ? AND EXP_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $days);
		$st->BindParam(3, $qtyleft);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? , MED_TOTALQTY = MED_TOTALQTY - ?, MED_STOCKVALUE =  MED_STOCKVALUE - ?  WHERE MED_CODE = ? AND MED_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $qtyleft);
				$st->BindParam(2, $qtyleft);		
				$st->BindParam(3, $stockvalue);		
				$st->BindParam(4, $medicationcode);		
				$st->BindParam(5, $instcode);						
	
				$exe = $st->execute();							
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}				
			}else{
				return '0' ;	
			}				
		
	}

	// 13 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getmedicationdurrentqty($medicationcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_st_medications where MED_CODE = ? AND MED_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MED_QTY']  ;
				return $results;
			}else{
				return '-2';
			}

		}else{
			return '-1';
		}			
	}

	// 26 NOV 2022  JOSEPH ADORBOE  transactioncode
	public function getmedicationdurrenttotalqty($medicationcode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_st_medications where MED_CODE = ? AND MED_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $medicationcode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MED_TOTALQTY']  ;
				$storeqty = $object['MED_STOREQTY']  ;
				$pharamcyqty = $object['MED_QTY']  ;
				$transferqty = $object['MED_TRANSFER']  ;
				if($results == '0'){
					$results = $storeqty + $pharamcyqty + $transferqty ;
				}
				return $results;
			}else{
				return '-2';
			}

		}else{
			return '-1';
		}			
	}
	

	// 13 JUN 2021 JOSEPH ADORBOE
	public function soldoutmedications($ekey,$days,$currentuser, $currentusercode){
		$nt = 2 ;
		$rt = 0 ;
		$sql = "UPDATE octopus_pharmacy_expiry SET EXP_STATUS = ?, EXP_DATEPROCESSED = ? , EXP_QTYLEFT = ?, EXP_PROCESSACTOR = ? , EXP_PROCESSACTORCODE = ?  WHERE EXP_CODE = ?   ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $days);
		$st->BindParam(3, $rt);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}		
	}


	// 26 NOV 2022 , 04 JUNE 2021 JOSEPH ADORBOE 
	public function prescriptiondispense($bcode,$days,$servicescode,$qty,$cost,$newqty,$patientcode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "SELECT * FROM octopus_patients_prescriptions where PRESC_CODE = ? and PRESC_DISPENSE = ? AND PRESC_PATIENTCODE = ? and PRESC_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $not);
		$st->BindParam(3, $patientcode);
		$st->BindParam(4, $instcode);
		$ext = $st->execute();
		if($ext){
			if($st->rowcount()>0){
				
				$dispense = 10 ;
				$complete = 2;			
				$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_COMPLETE = ? , PRESC_DISPENSEDATE = ? , PRESC_DISPENSER = ? , PRESC_DISPENSERCODE = ?, PRESC_DISPENSESHIFTCODE = ?, PRESC_DISPENSESHIFT = ? ,PRESC_DISPENSE = ? ,PRESC_NEWQTY = ? WHERE PRESC_CODE = ? AND PRESC_PATIENTCODE = ? and PRESC_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $dispense);
				$st->BindParam(2, $complete);
				$st->BindParam(3, $days);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $currentshiftcode);
				$st->BindParam(7, $currentshift);
				$st->BindParam(8, $complete);
				$st->BindParam(9, $newqty);
				$st->BindParam(10, $bcode);
				$st->BindParam(11, $patientcode);
				$st->BindParam(12, $instcode);
				$selectitem = $st->Execute();				
					if($selectitem){
						$sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY - ?, MED_TOTALQTY = MED_TOTALQTY - ?, MED_STOCKVALUE =  MED_STOCKVALUE - ?  WHERE MED_CODE = ? AND MED_INSTCODE = ?";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $qty);
						$st->BindParam(2, $qty);
						$st->BindParam(3, $cost);
						$st->BindParam(4, $servicescode);	
						$st->BindParam(5, $instcode);					
						$exe = $st->execute();							
						if($exe){								
							return '2';								
						}else{								
							return '0';								
						}					
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
	
	
	// 04 JUNE 2021 JOSEPH ADORBOE
	public function getpatientprescriptiontotal($visitcode){
		$rty = 2;
		$sql = ("SELECT SUM(PRESC_TOT) FROM octopus_patients_prescriptions where PRESC_VISITCODE = ? and PRESC_STATE = ?");
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $visitcode);
		$st->BindParam(2, $rty);
		$total = $st->execute();
		if($total){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUM(PRESC_TOT)'];
				return $results;
			}else{
				return '0';
			}
		}else{
			return '-1';
		}
		
	}


	// 04 JUNE 2021 JOSEPH ADORBOE	  
	public function addstockadjustment($form_key,$adjustmentnumber,$medcode,$mednum,$medname,$newqty,$medqty,$qty,$days,$day,$expire,$expirycode,$type,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode)
	{
        $but = 1;
        $sqlstmt = ("SELECT SA_ID FROM octopus_pharmacy_stockadjustment where SA_MEDICATIONCODE = ? and SA_SHIFTCODE = ?");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $medcode);
        $st->BindParam(2, $currentshiftcode);
        $check = $st->execute();
        if ($check) {
            if ($st->rowcount() > 0) {
               return '1';
            } else {
				$sql = ("INSERT INTO octopus_pharmacy_stockadjustment (SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_SHIFT,SA_SHIFTCODE,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_EXPIRY,SA_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $adjustmentnumber);
                $st->BindParam(3, $days);
                $st->BindParam(4, $medcode);
                $st->BindParam(5, $mednum);
                $st->BindParam(6, $medname);
                $st->BindParam(7, $qty);
                $st->BindParam(8, $newqty);
                $st->BindParam(9, $medqty);
                $st->BindParam(10, $currentshift);
                $st->BindParam(11, $currentshiftcode);
                $st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $expire);
				$st->BindParam(16, $type);
                $setp = $st->execute();
                if ($setp) {
						$sql = ("INSERT INTO octopus_pharmacy_expiry (EXP_CODE,EXP_SUPPLYCODE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_EXPIRYDATE,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_DATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ");
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $expirycode);
						$st->BindParam(2, $adjustmentnumber);
						$st->BindParam(3, $medcode);
						$st->BindParam(4, $mednum);
						$st->BindParam(5, $medname);
						$st->BindParam(6, $qty);
						$st->BindParam(7, $expire);
						$st->BindParam(8, $currentuser);
						$st->BindParam(9, $currentusercode);
						$st->BindParam(10, $instcode);
						$st->BindParam(11, $day);
					//	$st->BindParam(12, $instcode);
						$setp = $st->execute();
						if($setp){
							$sql = "UPDATE octopus_current SET CU_ADJUSTMENTCODE = ?  WHERE CU_INSTCODE = ?  ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $adjustmentnumber);
							$st->BindParam(2, $instcode);						
							$exe = $st->execute();							
							if($exe){
                                if ($type == '1') {
                                    $sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY + ?  WHERE MED_CODE = ?  ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $qty);
                                    $st->BindParam(2, $medcode);
                                    $exe = $st->execute();
                                    if ($exe) {
                                        return '2';
                                    } else {
                                        return '0';
                                    }
                                }

								if ($type == '2') {
                                    $sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY + ?  WHERE DEV_CODE = ?  ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $qty);
                                    $st->BindParam(2, $medcode);
                                    $exe = $st->execute();
                                    if ($exe) {
                                        return '2';
                                    } else {
                                        return '0';
                                    }
                                }


							}else{								
								return '0';								
							}

						}else{
							return '0';
						}
					
                } else {
                    return '0';
                }
            }
        } else {
            return '0';
        }
    }


	// 04 JUNE 2021 JOSEPH ADORBOE 
	public function getlastadjustmentcodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_ADJUSTMENTCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}	

	// 04 JUNE 2021 JOSEPH ADORBOE 
	public function getrestockdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_supplies where SUP_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SUP_CODE'].'@'.$object['SUP_SUPPLYCODE'].'@'.$object['SUP_RECEIPTNUM'].'@'.$object['SUP_DATE'].'@'.$object['SUP_SUPPLIERCODE'].'@'.$object['SUP_SUPPLIERNUM'].'@'.$object['SUP_SUPPLIER'].'@'.$object['SUP_TOTALAMOUNT'].'@'.$object['SUP_FILE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}
			
	}	


	
	// 03 JUNE 2021 JOSEPH ADORBOE	  
	public function addnewsupply($form_key,$suppcode,$suppnum,$suppname,$receiptnumber,$totalamount,$supplydate,$day,$suppliesnumber,$finame,$currentuser,$currentusercode,$instcode)
	{
        $but = 1;
        $sqlstmt = ("SELECT SUP_ID FROM octopus_supplies where SUP_RECEIPTNUM = ? and SUP_SUPPLIERCODE = ?");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $receiptnumber);
        $st->BindParam(2, $suppcode);
        $check = $st->execute();
        if ($check) {
            if ($st->rowcount() > 0) {
               return '1';
            } else {
				$sql = ("INSERT INTO octopus_supplies (SUP_CODE,SUP_SUPPLYCODE,SUP_RECEIPTNUM,SUP_DATE,SUP_SUPPLIERCODE,SUP_SUPPLIERNUM,SUP_SUPPLIER,SUP_TOTALAMOUNT,SUP_FILE,SUP_ACTORCODE,SUP_ACTOR,SUP_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
                $st = $this->db->prepare($sql);
                $st->BindParam(1, $form_key);
                $st->BindParam(2, $suppliesnumber);
                $st->BindParam(3, $receiptnumber);
                $st->BindParam(4, $day);
                $st->BindParam(5, $suppcode);
                $st->BindParam(6, $suppnum);
                $st->BindParam(7, $suppname);
                $st->BindParam(8, $totalamount);
                $st->BindParam(9, $finame);
                $st->BindParam(10, $currentusercode);
                $st->BindParam(11, $currentuser);
                $st->BindParam(12, $instcode);
                $setp = $st->execute();
                if ($setp) {
                    $sql = "UPDATE octopus_current SET CU_SUPPLIESCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $suppliesnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();							
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}	
                } else {
                    return '0';
                }
            }
        } else {
            return '0';
        }
    }

		
	
	// 02 JUNE 2021 JOSEPH ADORBOE
	public function getpharmacydashboard($currentusercode,$currentshiftcode,$instcode){
        $nut = 1;
        $not = 2;
        $sql = 'SELECT * FROM octopus_patients_prescriptions WHERE PRESC_COMPLETE = ? and PRESC_INSTCODE = ? ';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $ext = $st->execute();
        if ($ext) {
            $pendingprescription = $st->rowcount();
        } else {
            return '0';
        }
        
        $sql = 'SELECT * FROM octopus_patients_prescriptions WHERE PRESC_COMPLETE = ? and PRESC_INSTCODE = ? and PRESC_DISPENSESHIFTCODE = ? ';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $not);
        $st->BindParam(2, $instcode);
        $st->BindParam(3, $currentshiftcode);
	    $ext = $st->execute();
        if ($ext) {
            $shiftdispensed = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_st_medications WHERE MED_STATE = ? and MED_INSTCODE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $nut);
        $st->BindParam(2, $instcode);
        $ext = $st->execute();
        if ($ext) {
            $pendingmedication = $st->rowcount();
        } else {
            return '0';
        }

		$sql = 'SELECT * FROM octopus_st_medications WHERE MED_STATE = ? and MED_INSTCODE = ?';
        $st = $this->db->prepare($sql);
        $st->BindParam(1, $not);
        $st->BindParam(2, $instcode);
        $ext = $st->execute();
        if ($ext) {
            $inpharmacystore = $st->rowcount();
        } else {
            return '0';
        }
                       
        //								0						1						2						3						4					5						6
        $labdashboarddetails = $pendingprescription.'@@@'.$shiftdispensed.'@@@'.$pendingmedication.'@@@'.$inpharmacystore;
        
        return $labdashboarddetails;
    }

	
	// 13 MAY 2021 JOSEPH ADORBOE
	public function editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$currentuser,$currentusercode,$instcode){

		$not =2;
		$sql = "UPDATE octopus_st_medications SET MED_CODENUM = ?, MED_MEDICATION = ?,  MED_DOSAGECODE = ?, MED_DOSAGE =? , MED_RESTOCK =?, MED_UNITCODE =?, MED_UNIT =?, MED_QTY =?, MED_ACTOR =?, MED_ACTORCODE = ? , MED_STATE = ? WHERE MED_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medicationnumber);
		$st->BindParam(2, $medication);
		$st->BindParam(3, $dosageformcode);
		$st->BindParam(4, $dosageformname);
		$st->BindParam(5, $restock);
		$st->BindParam(6, $untcode);
		$st->BindParam(7, $untname);
		$st->BindParam(8, $qty);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $not);
		$st->BindParam(12, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_MEDICATIONCODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $medicationnumber);
				$st->BindParam(2, $instcode);						
				$exe = $st->execute();							
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}
			}
			return '2';								
							
		}else{								
			return '0';								
		}	
	}
	

	// 26 APR  2021 JOSEPH ADORBOE	  
	public function prescriptionssendtopayment($form_key,$billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$patienttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller)
	{
		$not = 2;
		$sql = "SELECT * FROM octopus_patients_prescriptions where PRESC_CODE = ? and PRESC_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $not);
		$seth = $st->execute();
		if($seth){
			if($st->rowcount()>'0'){
				if ($schemepricepercentage < 100) {
					$schemeamount = ($cost*$schemepricepercentage)/100;
					$patientamount = $cost - $schemeamount ;
					$rtn = 1;
					$cash = 'CASH';
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


				}
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
								$sqlstmt = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_BILLINGCODE = ?, PRESC_STATUS = ? , PRESC_DISPENSE = ? WHERE PRESC_CODE = ? and PRESC_STATE = ?  ";
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
								$sqlstmt = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ?, PRESC_BILLINGCODE = ? WHERE PRESC_CODE = ? and PRESC_STATE = ?  ";
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



	// 26 APR 2021 JOSEPH ADORBOE  transactioncode
	public function getinstoreqty($servicescode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_st_medications_qty where MEDQ_MEDCODE = ? AND MEDQ_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $servicescode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MEDQ_QTY']  ;
				return $results;
			}else{
				return '-2';
			}

		}else{
			return '-1';
		}
			
	}	

	
	// 25 APR 2021 JOSEPH ADORBOE 
	public function unselectprescription($bcode,$days,$currentusercode,$currentuser){
			$not = 2 ;
			$sql = "SELECT * FROM octopus_patients_prescriptions WHERE PRESC_CODE = ? AND PRESC_STATE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $bcode);
			$st->BindParam(2, $not);
			$exe = $st->execute();
			if($exe){
				if($st->rowcount()>'0'){
					$vt = 0;
					$nt = 1;		
					$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_TOT = ? , PRESC_PROCESSTIME = ? , PRESC_PROCESSACTOR = ? , PRESC_PROCESSACTORCODE = ?,PRESC_UNITCOST = ?  WHERE PRESC_CODE = ?   ";
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
	


	// 24 APR 2021 JOSEPH ADORBOE	  
	public function setpriceprescription($form_key,$itemprice,$method,$methodcode,$schemename,$schemcode,$itemcode,$item,$transactioncode,$type,$totalprice,$currentuser,$currentusercode,$instcode)
	{
		//die;
		$but = 1;
		$cate = '*';
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and PS_PAYMENTMETHODCODE =? and PS_PAYSCHEMECODE =? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $methodcode);
		$st->BindParam(3, $schemcode);
		$st->BindParam(4, $but);
		$checkprice = $st->execute();
		if($checkprice){
			if($st->rowcount() > 0){
				$nt = 2 ;			
				$sqlstmt = "UPDATE octopus_patients_prescriptions SET PRESC_TOT = ?, PRESC_STATE = ?, PRESC_UNITCOST = ?  WHERE PRESC_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $totalprice);
					$st->BindParam(2, $nt);
					$st->BindParam(3, $totalprice);
					$st->BindParam(4, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_medications SET MED_STATE = ?  WHERE MED_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $wet);
						$st->BindParam(2, $itemcode);
						$setmed = $st->execute();
						if($setbills){
							return '2';
						}else{
							return '0';
						}
					}else{
						return '0';
					}
				
			}else{	
		
				$sql = ("INSERT INTO octopus_st_pricing (PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHODCODE,PS_PAYMENTMETHOD,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
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
				$setprice = $st->execute();				
				if($setprice){	
					$nt = 2;				
					$sqlstmt = "UPDATE octopus_patients_prescriptions SET PRESC_TOT = ?, PRESC_STATE = ?, PRESC_UNITCOST = ? WHERE PRESC_CODE = ?  ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $totalprice);
					$st->BindParam(2, $nt);
					$st->BindParam(3, $itemprice);
					$st->BindParam(4, $transactioncode);
					$setbills = $st->execute();
					if($setbills){
						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_medications SET MED_STATE = ?  WHERE MED_CODE = ? ";
						$st = $this->db->prepare($sqlstmt);
						$st->BindParam(1, $wet);
						$st->BindParam(2, $itemcode);
						$setmed = $st->execute();
						if($setbills){
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

	// 023 APR 2021 JOSEPH ADORBOE 
	public function getpatientprescriptiondetails($idvalue){
		$sqlstmt = ("SELECT DISTINCT  PRESC_PATIENTCODE,PRESC_DATE,PRESC_PATIENTNUMBER,PRESC_PATIENT,PRESC_VISITCODE,PRESC_PAYMENTMETHOD,PRESC_PAYMENTMETHODCODE,PRESC_PAYSCHEMECODE,PRESC_PAYSCHEME,PRESC_TYPE,PRESC_BILLINGCODE,PRESC_PAYMENTTYPE,PRESC_TYPE,PRESC_GENDER,PRESC_AGE,PRESC_CONSULTATIONSTATE from octopus_patients_prescriptions where PRESC_VISITCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PRESC_VISITCODE'].'@'.$object['PRESC_DATE'].'@'.$object['PRESC_PATIENTCODE'].'@'.$object['PRESC_PATIENTNUMBER'].'@'.$object['PRESC_PATIENT'].'@'.$object['PRESC_TYPE'].'@'.$object['PRESC_BILLINGCODE'].'@'.$object['PRESC_PAYMENTMETHOD'].'@'.$object['PRESC_PAYSCHEME'].'@'.$object['PRESC_PAYSCHEMECODE'].'@'.$object['PRESC_PAYMENTTYPE'].'@'.$object['PRESC_TYPE'].'@'.$object['PRESC_GENDER'].'@'.$object['PRESC_AGE'].'@'.$object['PRESC_PAYMENTMETHODCODE'].'@'.$object['PRESC_CONSULTATIONSTATE'] ;
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}

	// 23 APR 2021 JOSEPH ADORBOE 
	public function prescriptionselection($bcode,$days,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode){
		
		$not = 1;
		$sql = "SELECT * from octopus_patients_prescriptions where PRESC_CODE = ? and PRESC_INSTCODE = ? and PRESC_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $not);
		$acti = $st->execute();
	//	die;
		if($acti){
			
			if($st->rowcount()>0){
				if($totalamount == '-1'){
					$sql = "UPDATE octopus_patients_prescriptions SET PRESC_TOT = ? , PRESC_PROCESSTIME = ? , PRESC_PROCESSACTOR = ? , PRESC_PROCESSACTORCODE = ?,PRESC_UNITCOST = ?  WHERE PRESC_CODE = ?   ";
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
					$sql = "UPDATE octopus_patients_prescriptions SET PRESC_STATE = ? , PRESC_TOT = ? , PRESC_PROCESSTIME = ? , PRESC_PROCESSACTOR = ? , PRESC_PROCESSACTORCODE = ?,PRESC_UNITCOST = ?  WHERE PRESC_CODE = ?   ";
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

	// 04 APR 2021 JOSEPH ADORBOE  transactioncode
	public function getprescriptionrequestdetails($transactioncode){
		$sqlstmt = ("SELECT * FROM octopus_patients_prescriptions where PRESC_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $transactioncode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['PRESC_MEDICATION'].'@'.$object['PRESC_MEDICATIONCODE'].'@'.$object['PRESC_PAYSCHEMECODE'].'@'.$object['PRESC_PAYSCHEME'].'@'.$object['PRESC_PAYMENTMETHOD'].'@'.$object['PRESC_PAYMENTMETHODCODE'].'@'.$object['PRESC_QUANTITY'].'@'.$object['PRESC_STATE'].'@'.$object['PRESC_STATUS'].'@'.$object['PRESC_CODENUM'].'@'.$object['PRESC_DATETIME'].'@'.$object['PRESC_DOSAGEFORM'].'@'.$object['PRESC_FREQUENCY'].'@'.$object['PRESC_DAYS'].'@'.$object['PRESC_ROUTE'].'@'.$object['PRESC_STRENGHT'].'@'.$object['PRESC_INSTRUCTION'] .'@'.$object['PRESC_PROCESSTIME'].'@'.$object['PRESC_PROCESSACTOR'].'@'.$object['PRESC_DAYSCODE']  ;
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	


} 
?>