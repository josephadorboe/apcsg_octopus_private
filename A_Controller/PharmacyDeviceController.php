<?php
/*  AUTHOR: JOSEPH ADORBOE
	DATE: 02 OCT 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class PharmacyDeviceController Extends Engine{

	// 27 NOV 2022
	public function getdevicetotals($cashpaymentmethodcode,$day,$instcode){
		$zero = '0';
		$two = 2;
		$sqlstmt = ("SELECT SUM(PD_TOT) AS TOTCASH from octopus_patients_devices where PD_PAYMENTMETHODCODE = ? and PD_DISPENSE = ? AND PD_INSTCODE = ? AND  date(PD_DISPENSEDATE) = ? ");
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

		$sqlstmt = ("SELECT SUM(PD_TOT) AS TOTCASH from octopus_patients_devices where PD_PAYMENTMETHODCODE != ? and PD_DISPENSE = ? AND PD_INSTCODE = ? AND  date(PD_DISPENSEDATE) = ? ");
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
	public function archivepasteddevice($thearchivedate,$currentusercode,$currentuser,$instcode){
		$one =1;
		$zero = '0';
		$sql = "UPDATE octopus_patients_devices SET PD_ARCHIVE = ?,  PD_PROCESSACTOR = ?, PD_PROCESSACTORCODE = ? WHERE PD_DATE < ? and  PD_ARCHIVE = ? ";
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

	// 28 JUN 2021 JOSEPH ADORBOE
	public function reversedevicesentout($bcode,$currentusercode,$currentuser){
		$not = 1;
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ? , PD_PROCESSACTOR = ?, PD_PROCESSACTORCODE = ? ,PD_COMPLETE = ? WHERE PD_CODE = ?   ";
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


	// 27 SEPT 2022 JOSEPH ADORBOE
	public function returndevicesrequest($bcode,$returnreason,$days,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_devices SET PD_RETURN = ?, PD_RETURNTIME = ? , PD_RETURNACTOR = ?, PD_RETURNACTORCODE = ? , PD_RETURNREASON = ?  WHERE PD_CODE = ? and  PD_RETURN = ? AND PD_INSTCODE = ? ";
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


	// 28 JUN 2021 JOSEPH ADORBOE
	public function editdevicemanage($visitcode,$patientcode,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$payment,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "UPDATE octopus_patients_devices SET PD_PAYMENTMETHOD = ?, PD_PAYMENTMETHODCODE = ? , PD_SCHEMECODE = ?, PD_SCHEME = ? ,PD_PAYMENTTYPE = ? WHERE PD_VISITCODE = ? and PD_PATIENTCODE = ? and PD_STATE = ?  ";
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

	// 28 SEPT 2022 JOSEPH ADORBOE
	public function editpharamcyarchivedevices($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_devices SET PD_ARCHIVE = ?, PD_PROCESSTIME = ? , PD_PROCESSACTOR = ?, PD_PROCESSACTORCODE = ?  WHERE PD_CODE = ? and  PD_ARCHIVE = ? AND PD_INSTCODE = ? ";
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


	// 29 JUN 2021 JOSEPH ADORBOE
	public function devicesentout($bcode,$currentusercode,$currentuser){
		$nt = 8 ;
		$rt = 5 ;
		$tut = 2;
		$nut =1;
		$sql = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_STATUS = ? , PD_PROCESSACTOR = ?, PD_PROCESSACTORCODE = ? ,PD_COMPLETE = ? WHERE PD_CODE = ? and  PD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nt);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $tut);
		$st->BindParam(6, $bcode);
		$st->BindParam(7, $nut);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 03 JULY 2021 JOSEPH ADORBOE	
	public function editdeviceprescriptionqty($ekey,$newqty,$devicecode,$devicename,$currentuser,$currentusercode,$instcode){
		$nt = 1 ;
		$rt = 0 ;
	
		$sql = "UPDATE octopus_patients_devices SET PD_QTY = ?, PD_ACTORCODE = ? , PD_ACTOR = ?, PD_DEVICECODE = ?, PD_DEVICE = ? WHERE PD_CODE = ? and PD_INSTCODE = ? and PD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $newqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $devicecode);
		$st->BindParam(5, $devicename);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $nt);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}		
	}

	// 29 JUNE 2021 JOSEPH ADORBOE 
	public function deviceprescriptiondispense($bcode,$days,$servicescode,$qty,$cost,$newqty,$patientcode,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){
		$not = 1;
		$sql = "SELECT * FROM octopus_patients_devices where PD_CODE = ? and PD_DISPENSE = ? AND PD_PATIENTCODE = ? and PD_INSTCODE = ?";
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
				$sql = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_COMPLETE = ? , PD_DISPENSEDATE = ? , PD_DISPENSER = ? , PD_DISPENSERCODE = ?,PD_DISPENSESHIFTCODE = ?, PD_DISPENSESHIFT = ? ,PD_DISPENSE = ? ,PD_NEWQTY = ? WHERE PD_CODE = ? AND PD_INSTCODE = ? ";
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
				$st->BindParam(11, $instcode);
				$selectitem = $st->Execute();				
					if($selectitem){
						$sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY - ?, DEV_TOTALQTY = DEV_TOTALQTY - ?, DEV_STOCKVALUE =  DEV_STOCKVALUE - ?  WHERE DEV_CODE = ?  AND DEV_INSTCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $qty);
						$st->BindParam(2, $qty);
						$st->BindParam(3, $cost);
						$st->BindParam(4, $servicescode);	
						$st->BindParam(5, $instcode);	
					//	$st->BindParam(2, $servicescode);						
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

	// 29 JUNE 2021 JOSEPH ADORBOE	  
	public function deviceprescriptionssendtopayment($form_key,$billingcode,$visitcode,$bcode,$billcode,$day,$days,$patientcode,$patientnumber,$patient,$servicescode,$serviceitem,$paymentmethodcode,$paymentmethod,$paymentschemecode,$paymentscheme,$cost,$depts,$patientpaymenttype,$patienttype,$currentuser,$currentusercode,$currentshift,$currentshiftcode,$instcode,$currentday,$currentmonth,$currentyear,$schemepricepercentage,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$billercode,$biller)
	{
		$not = 2;
		$sql = "SELECT * FROM octopus_patients_devices where PD_CODE = ? and PD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $not);
		$seth = $st->execute();
		if($seth){
			if($st->rowcount()>'0'){
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
					$sqlstmt = "UPDATE octopus_patients_bills SET BILL_AMOUNT = BILL_AMOUNT + ?  WHERE BILL_CODE = ? ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $cost);
					$st->BindParam(2, $billcode);
					$setbills = $st->execute();
					if($setbills){

						$wet = 2;
						$sqlstmt = "UPDATE octopus_st_devices SET DEV_STATE = ?  WHERE DEV_CODE = ? ";
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
								$sqlstmt = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_BILLINGCODE = ?, PD_STATUS = ? , PD_DISPENSE = ? WHERE PD_CODE = ? and PD_STATE = ?  ";
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
								$sqlstmt = "UPDATE octopus_patients_devices SET PD_STATE = ?, PD_BILLINGCODE = ? WHERE PD_CODE = ? and PD_STATE = ?  ";
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

	// 25 APR 2021 JOSEPH ADORBOE 
	public function unselectprescriptiondevice($bcode,$days,$currentusercode,$currentuser){
		$not = 2 ;
		$sql = "SELECT * FROM octopus_patients_devices WHERE PD_CODE = ? AND PD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $not);
		$exe = $st->execute();
		if($exe){
			if($st->rowcount()>'0'){
				$vt = 0;
				$nt = 1;		
				$sql = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_TOT = ? , PD_PROCESSTIME = ? , PD_PROCESSACTOR = ? , PD_PROCESSACTORCODE = ?,PD_UNITCOST = ?  WHERE PD_CODE = ?   ";
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

	// 29 JUNE 2021 JOSEPH ADORBOE 
	public function deviceprescriptionselection($bcode,$days,$servicescode,$cost,$paymentmethodcode,$depts,$paymentschemecode,$serviceamount,$totalamount,$currentusercode,$currentuser,$instcode){
		
		$not = 1;
		$sql = "SELECT * from octopus_patients_devices where PD_CODE = ? and PD_INSTCODE = ? and PD_STATE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $bcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $not);
		$acti = $st->execute();
	//	die;
		if($acti){
			
			if($st->rowcount()>0){
				if($totalamount == '-1'){
					$sql = "UPDATE octopus_patients_devices SET PD_TOT = ? , PD_PROCESSTIME = ? , PD_PROCESSACTOR = ? , PD_PROCESSACTORCODE = ?, PD_UNITCOST = ?   WHERE PD_CODE = ?   ";
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
					$nt = 2 ;
					$sql = "UPDATE octopus_patients_devices SET PD_STATE = ? , PD_TOT = ? , PD_PROCESSTIME = ? , PD_PROCESSACTOR = ? , PD_PROCESSACTORCODE = ?, PD_UNITCOST = ?  WHERE PD_CODE = ?   ";
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

	// 13 JUNE 2021 JOSEPH ADORBOE  transactioncode
	public function getdevicescurrentqty($servicescode,$instcode){
		$sqlstmt = ("SELECT * FROM octopus_st_devices where DEV_CODE = ? AND DEV_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $servicescode);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['DEV_QTY']  ;
				return $results;
			}else{
				return '-2';
			}

		}else{
			return '-1';
		}
			
	}	

} 
?>