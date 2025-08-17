<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 16 APR 2022 
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class RequestionController Extends Engine{

	// 07 JAN 2022 JOSEPH ADORBOE 
	public function singlemedicationtransferstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3; 
		$one = 1;  	
            $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ?, MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $suppliedqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newtransferqty);
				$st->BindParam(9, $newstoreqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $one);	
				$exep = $st->execute();
				if($exep){
					return '2';	
				}else{
					return '0';	
				}
							
				}else{			
					return '0';			
				}
		}

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function approvebulkdevicerestock($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode){	
			
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? , DEV_TOTALQTY = DEV_TOTALQTY + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $medciationcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_st_devices SET  DEV_STOCKVALUE = DEV_TOTALQTY * DEV_CASHPRICE WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medciationcode);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATE = ? , SA_DATETIME = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? AND SA_STATE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $ajustcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $zero);
		$exes = $st->Execute();
				
		if($exe && $exes){	
			return '2';			
		}else{			
			return '0';			
		}				
	}
	// 23 JULY 2023 JOSEPH ADORBOE 
	public function deletetransfermedication($ekey,$days,$currentusercode,$currentuser,$instcode){	
		$zero = '0';       
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATUS = ? , SA_STATE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $instcode);
		$exes = $st->Execute();			
		if($exes){	
			return '2';			
		}else{			
			return '0';			
		}
					
	}	

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function deleterestockmedication($ekey,$days,$currentusercode,$currentuser,$instcode){	
		$zero = '0';       
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATUS = ? , SA_STATE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $instcode);
		$exes = $st->Execute();			
		if($exes){	
			return '2';			
		}else{			
			return '0';			
		}
					
	}	

	// 22 JULY 2023 JOSEPH ADORBOE 
	public function edittransfermovement($ekey,$itemcode,$type,$suppliedqty,$oldqty,$days,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3;
		$cash = 'CASH';
		$one = 1;		
       
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ? , SA_NEWQTY = ? , SA_OLDQTY = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $suppliedqty);
		$st->BindParam(3, $oldqty);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exes = $st->Execute();			
		if($exes){	
			return '2';			
		}else{			
			return '0';			
		}
							
	}	

	// 22 JULY 2023 JOSEPH ADORBOE 
	public function approvebulkmedicationrestock($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode){	
			
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = MED_TOTALQTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $medciationcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_st_medications SET  MED_STOCKVALUE = MED_TOTALQTY * MED_CASHPRICE WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medciationcode);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATE = ? , SA_DATETIME = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? AND SA_STATE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $ajustcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $zero);
		$exes = $st->Execute();
				
		if($exe && $exes){	
			return '2';			
		}else{			
			return '0';			
		}				
	}	

	// 22 JULY 2023 JOSEPH ADORBOE 
	public function editrestockstockmovement($ekey,$itemcode,$type,$suppliedqty,$newqty,$oldqty,$expiry,$days,$costprice,$cashprice,$dollarprice,$insuranceprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod){	
		$three = 3;
		$cash = 'CASH';
		$one = 1;
		
        if ($type == 1) {           

			$sql = "UPDATE octopus_st_medications SET MED_COSTPRICE = ?  , MED_CASHPRICE = ?  ,  MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $costprice);
            $st->BindParam(2, $cashprice);
            $st->BindParam(3, $cashprice);
			$st->BindParam(4, $cashprice);
			$st->BindParam(5, $dollarprice);
			$st->BindParam(6, $insuranceprice);
			$st->BindParam(7, $itemcode);
			$st->BindParam(8, $instcode);
			$exe = $st->Execute();
			
			$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ? , SA_NEWQTY = ? , SA_OLDQTY = ?, SA_EXPIRY = ?, SA_COSTPRICE = ?, SA_NEWPRICE = ?, SA_INSURANCEPRICE = ? , SA_DOLLARPRICE = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $newqty);
            $st->BindParam(3, $oldqty);
			$st->BindParam(4, $expiry);
			$st->BindParam(5, $costprice);
			$st->BindParam(6, $cashprice);
			$st->BindParam(7, $insuranceprice);
			$st->BindParam(8, $dollarprice);
			$st->BindParam(9, $ekey);
			$st->BindParam(10, $instcode);
			$exes = $st->Execute();
			
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $insuranceprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $insuranceprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $itemcode);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $one);
			$exepr = $st->execute();
			
			$two = 2;
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $cashprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $partnerprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $itemcode);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $two);
			$exep = $st->execute();

			if($exe && $exepr && $exes && $exep){	
				return '2';			
			}else{			
				return '0';			
			}

		}

		if ($type == 4) {

		    $sql = "UPDATE octopus_st_devices SET  DEV_COSTPRICE = ? , DEV_CASHPRICE = ?, DEV_PARTNERPRICE = ?, DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $costprice);
            $st->BindParam(2, $newprice);
            $st->BindParam(3, $partnerprice);
			$st->BindParam(4, $alternateprice);
			$st->BindParam(5, $dollarprice);
			$st->BindParam(6, $itemcode);
			$st->BindParam(7, $instcode);
			// $st->BindParam(8, $dollarprice);
			// $st->BindParam(9, $itemcode);
			// $st->BindParam(10, $instcode);
            $exe = $st->Execute();
		//	if($exe){	
			$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ADDQTY = ? , SA_NEWQTY = ? , SA_OLDQTY = ?, SA_EXPIRY = ?, SA_COSTPRICE = ?, SA_NEWPRICE = ?, SA_INSURANCEPRICE = ? , SA_DOLLARPRICE = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $newqty);
            $st->BindParam(3, $oldqty);
			$st->BindParam(4, $expiry);
			$st->BindParam(5, $costprice);
			$st->BindParam(6, $cashprice);
			$st->BindParam(7, $insuranceprice);
			$st->BindParam(8, $dollarprice);
			$st->BindParam(9, $ekey);
			$st->BindParam(10, $instcode);
			$exes = $st->Execute();				
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $insuranceprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $insuranceprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $itemcode);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $one);
			$exepr = $st->execute();		
			$two = 2;
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $newprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $partnerprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $itemcode);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $two);
			$exep = $st->execute();					
					
			if($exe && $exepr && $exes && $exep){	
				return '2';			
			}else{			
				return '0';			
			}
			}
						
	}	


	// 16 JULY 2023 JOSEPH ADORBOE 
	public function restockstockmovementbulk($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice){	
		$three = 3;
		$cash = 'CASH';
		$one = 1;
		
        if ($type == 1) {

            // $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = ? , MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            // $st = $this->db->prepare($sql);
            // $st->BindParam(1, $suppliedqty);
            // $st->BindParam(2, $totalqty);
            // $st->BindParam(3, $costprice);
			// $st->BindParam(4, $newprice);
			// $st->BindParam(5, $stockvalue);
			// $st->BindParam(6, $partnerprice);
			// $st->BindParam(7, $alternateprice);
			// $st->BindParam(8, $dollarprice);
			// $st->BindParam(9, $insuranceprice);
			// $st->BindParam(10, $itemcode);
			// $st->BindParam(11, $instcode);
            // $exe = $st->Execute();
			// if($exe){	

			$sql = "UPDATE octopus_st_medications SET MED_COSTPRICE = ?  , MED_CASHPRICE = ?  ,  MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $costprice);
            $st->BindParam(2, $newprice);
            $st->BindParam(3, $partnerprice);
			$st->BindParam(4, $alternateprice);
			$st->BindParam(5, $dollarprice);
			$st->BindParam(6, $insuranceprice);
			$st->BindParam(7, $itemcode);
			$st->BindParam(8, $instcode);
			// $st->BindParam(9, $insuranceprice);
			// $st->BindParam(10, $itemcode);
			// $st->BindParam(11, $instcode);
            $exe = $st->Execute();
			// if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_INSURANCEPRICE,SA_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $costprice);
				$st->BindParam(19, $newprice);	
				$st->BindParam(20, $insuranceprice);
				$st->BindParam(21, $dollarprice);
				$exe = $st->execute();

				$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $expirycode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $expire);
				$exep = $st->execute();

				$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $insuranceprice);
				$st->BindParam(2, $insuranceprice);
				$st->BindParam(3, $dollarprice);
				$st->BindParam(4, $insuranceprice);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $cashpaymentmethodcode);
				$st->BindParam(8, $itemcode);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $one);
				$exe = $st->execute();		

				$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $itemcode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cashschemecode);
			//	$st->BindParam(4, $one);
				$exe = $st->Execute();
				if($st->rowcount() > 0){
					$two = 2;
					$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $newprice);
					$st->BindParam(2, $alternateprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $partnerprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $two);
					$exe = $st->execute();					
				}else{			
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $itemcode);
					$st->BindParam(4, $item);
					$st->BindParam(5, $newprice);
					$st->BindParam(6, $cashpaymentmethod);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $cashschemecode);
					$st->BindParam(9, $cash);
					$st->BindParam(10, $currentusercode);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $alternateprice);
					$st->BindParam(14, $alternateprice);
					$st->BindParam(15, $dollarprice);
					$exe = $st->execute();				
				}
				if($exe && $exep){	
					return '2';			
				}else{			
					return '0';			
				}

		}

		if ($type == 4) {

		    // $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ?, DEV_TOTALQTY = ? ,  DEV_COSTPRICE = ? , DEV_CASHPRICE = ?, DEV_STOCKVALUE = ?, DEV_PARTNERPRICE = ?, DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            // $st = $this->db->prepare($sql);
            // $st->BindParam(1, $suppliedqty);
            // $st->BindParam(2, $totalqty);
            // $st->BindParam(3, $costprice);
			// $st->BindParam(4, $newprice);
			// $st->BindParam(5, $stockvalue);
			// $st->BindParam(6, $partnerprice);
			// $st->BindParam(7, $alternateprice);
			// $st->BindParam(8, $dollarprice);
			// $st->BindParam(9, $itemcode);
			// $st->BindParam(10, $instcode);
            // $exe = $st->Execute();

			$sql = "UPDATE octopus_st_devices SET  DEV_COSTPRICE = ? , DEV_CASHPRICE = ?, DEV_PARTNERPRICE = ?, DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $costprice);
            $st->BindParam(2, $newprice);
            $st->BindParam(3, $partnerprice);
			$st->BindParam(4, $alternateprice);
			$st->BindParam(5, $dollarprice);
			$st->BindParam(6, $itemcode);
			$st->BindParam(7, $instcode);
			$exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_INSURANCEPRICE,SA_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $costprice);
				$st->BindParam(19, $newprice);
				$st->BindParam(20, $insuranceprice);
				$st->BindParam(21, $dollarprice);	
				$exe = $st->execute();

				$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $expirycode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $expire);
				$exep = $st->execute();

				
				$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $insuranceprice);
					$st->BindParam(2, $insuranceprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $insuranceprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $one);
					$exe = $st->execute();	

				$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $itemcode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cashschemecode);
			//	$st->BindParam(4, $one);
				$exe = $st->Execute();
				if($st->rowcount() > 0){
					$two = 2;
					$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $newprice);
					$st->BindParam(2, $alternateprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $partnerprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $two);
					$exe = $st->execute();					
				}else{			
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $itemcode);
					$st->BindParam(4, $item);
					$st->BindParam(5, $newprice);
					$st->BindParam(6, $cashpaymentmethod);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $cashschemecode);
					$st->BindParam(9, $cash);
					$st->BindParam(10, $currentusercode);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $alternateprice);
					$st->BindParam(14, $alternateprice);
					$st->BindParam(15, $dollarprice);
					$exe = $st->execute();				
				}	

					return '2';			
				}else{			
					return '0';			
				}
		}				
	}	

	// 17 OCT 2022 JOSEPH ADORBOE 
	public function returnstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newqty,$expire,$ajustcode,$adjustmentnumber,$days,$unit,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3;       

		if ($type == 3) {

            $sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY - ?, MED_STOREQTY = MED_STOREQTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $suppliedqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);	
				$exe = $st->execute();
					return '2';			
				}else{			
					return '0';			
				}
		}		

		if ($type == 6) {

            $sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY - ?, DEV_STOREQTY = DEV_STOREQTY + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $suppliedqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);	
				$exe = $st->execute();
					return '2';			
				}else{			
					return '0';			
				}
		}
		
	}

	// 07 JAN 2022 JOSEPH ADORBOE 
	public function transferstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3; 
		$one = 1;      

		if ($type == 2) {
            $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ?, MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $suppliedqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newtransferqty);
				$st->BindParam(9, $newstoreqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $one);	
				$exe = $st->execute();
					return '2';			
				}else{			
					return '0';			
				}
		}

		if ($type == 5) {
			//die($itemcode);
            $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ?, DEV_TRANSFER = DEV_TRANSFER + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $suppliedqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newtransferqty);
				$st->BindParam(9, $newstoreqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $one);	
				$exe = $st->execute();
					return '2';			
				}else{			
					return '0';			
				}
		}
		
	}

	// 07 JAN 2023 JOSEPH ADORBOE 
	public function restockstockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice){	
		$three = 3;
		$cash = 'CASH';
		$one = 1;
		
        if ($type == 1) {

            $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = ? , MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ?, MED_INSURANCEPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $totalqty);
            $st->BindParam(3, $costprice);
			$st->BindParam(4, $newprice);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $partnerprice);
			$st->BindParam(7, $alternateprice);
			$st->BindParam(8, $dollarprice);
			$st->BindParam(9, $insuranceprice);
			$st->BindParam(10, $itemcode);
			$st->BindParam(11, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $costprice);
				$st->BindParam(19, $newprice);
				$st->BindParam(20, $one);	
				$exe = $st->execute();

				$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $expirycode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $expire);
				$exep = $st->execute();

				$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $insuranceprice);
					$st->BindParam(2, $insuranceprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $insuranceprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $one);
					$exe = $st->execute();		

				$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $itemcode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cashschemecode);
			//	$st->BindParam(4, $one);
				$exe = $st->Execute();
				if($st->rowcount() > 0){
					$two = 2;
					$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $newprice);
					$st->BindParam(2, $alternateprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $partnerprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $two);
					$exe = $st->execute();					
				}else{			
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $itemcode);
					$st->BindParam(4, $item);
					$st->BindParam(5, $newprice);
					$st->BindParam(6, $cashpaymentmethod);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $cashschemecode);
					$st->BindParam(9, $cash);
					$st->BindParam(10, $currentusercode);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $alternateprice);
					$st->BindParam(14, $alternateprice);
					$st->BindParam(15, $dollarprice);
					$exe = $st->execute();				
				}	

					return '2';			
				}else{			
					return '0';			
				}

		}

		if ($type == 4) {
			$one = 1;
			$partnerprice = $alternateprice = $dollarprice = '0.00';
		   $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ?, DEV_TOTALQTY = ? , DEV_COSTPRICE = ? , DEV_CASHPRICE = ?, DEV_STOCKVALUE = ?, 
 DEV_PARTNERPRICE = ?, 
 DEV_OTHERPRICE = ?, DEV_DOLLARPRICE = ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $totalqty);
            $st->BindParam(3, $costprice);
			$st->BindParam(4, $newprice);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $partnerprice);
			$st->BindParam(7, $alternateprice);
			$st->BindParam(8, $dollarprice);
			$st->BindParam(9, $itemcode);
			$st->BindParam(10, $instcode);
            $exe = $st->Execute();			
			if($exe){	
				$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE,SA_STATE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $newqty);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $type);
				$st->BindParam(11, $currentshift);
				$st->BindParam(12, $currentshiftcode);	
				$st->BindParam(13, $expire);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $instcode);	
				$st->BindParam(17, $unit);
				$st->BindParam(18, $costprice);
				$st->BindParam(19, $newprice);	
				$st->BindParam(20, $one);	
				$exe = $st->execute();

				$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $expirycode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemnumber);
				$st->BindParam(6, $item);
				$st->BindParam(7, $suppliedqty);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $expire);
				$exep = $st->execute();

				
				$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE != ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $insuranceprice);
					$st->BindParam(2, $insuranceprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $insuranceprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $one);
					$exe = $st->execute();	

				$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $itemcode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cashschemecode);
			//	$st->BindParam(4, $one);
				$exe = $st->Execute();
				if($st->rowcount() > 0){
					$two = 2;
					$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $newprice);
					$st->BindParam(2, $alternateprice);
					$st->BindParam(3, $dollarprice);
					$st->BindParam(4, $partnerprice);
					$st->BindParam(5, $currentusercode);
					$st->BindParam(6, $currentuser);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $itemcode);
					$st->BindParam(9, $instcode);
					$st->BindParam(10, $two);
					$exe = $st->execute();					
				}else{			
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $itemcode);
					$st->BindParam(4, $item);
					$st->BindParam(5, $newprice);
					$st->BindParam(6, $cashpaymentmethod);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $cashschemecode);
					$st->BindParam(9, $cash);
					$st->BindParam(10, $currentusercode);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $alternateprice);
					$st->BindParam(14, $alternateprice);
					$st->BindParam(15, $dollarprice);
					$exe = $st->execute();				
				}	

					return '2';			
				}else{			
					return '0';			
				}
		}				
	}	

	// 19 DEC 2022  JOSEPH ADORBOE
	public function editnewprices($ekey,$itemcode,$itemname,$cashpricecode,$cashschemecode,$stockvalue,$costprice,$cashprice,$alternateprice,$insuranceprice,$dollarprice,$category,$cashpaymentmethodcode,$cashpaymentmethod,$privateinsurancecode,$currentuser,$currentusercode,$instcode,$partnerprice){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		$cash = 'CASH';
		if($category == 1){
			$sql = "UPDATE octopus_admin_services SET SEV_INSURANCE = ? , SEV_ALTPRICE = ? , SEV_CASHPRICE = ?  , SEV_DOLLAR = ?  WHERE SEV_SERVICECODE = ? AND SEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $cashprice);
			$st->BindParam(4, $dollarprice);
			$st->BindParam(5, $ekey);
			$st->BindParam(6, $instcode);
			$exe = $st->Execute();
		}

		if($category == 2){
			$sql = "UPDATE octopus_st_medications SET MED_INSURANCEPRICE = ? , MED_ALTERPRICE = ? , MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_DOLLARPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $costprice);
			$st->BindParam(4, $cashprice);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $partnerprice);
			$st->BindParam(7, $dollarprice);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $instcode);
			$exe = $st->Execute();
		}

		if($category == 3){
			$sql = "UPDATE octopus_st_labtest SET LTT_INSURANCEPRICE = ? , LTT_ALTERNATEPRICE = ? ,  LTT_CASHPRICE = ?  , LTT_DOLLARPRICE = ?, LTT_PARTNERPRICE = ? WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $cashprice);
			$st->BindParam(4, $dollarprice);
			$st->BindParam(5, $partnerprice);
			$st->BindParam(6, $ekey);
			$st->BindParam(7, $instcode);
		//	$st->BindParam(8, $newqty);
			$exe = $st->Execute();
		}

		if($category == 5){
			$sql = "UPDATE octopus_st_devices SET DEV_INSURANCEPRICE = ? , DEV_OTHERPRICE = ? , DEV_COSTPRICE = ?  , DEV_CASHPRICE = ?  , DEV_STOCKVALUE = ?, DEV_DOLLARPRICE = ? , DEV_PARTNERPRICE = ?  WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $costprice);
			$st->BindParam(4, $cashprice);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $dollarprice);
			$st->BindParam(7, $partnerprice);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $instcode);
		//	$st->BindParam(8, $newqty);
			$exe = $st->Execute();
		}

		if($category == 6){
			$sql = "UPDATE octopus_st_procedures SET MP_INSURANCEPRICE = ? , MP_ALTERNATEPRICE = ? , MP_CASHPRICE = ?  , MP_DOLLARPRICE = ? , MP_PARTNERPRICE = ?  WHERE MP_CODE = ? AND MP_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $cashprice);
			$st->BindParam(4, $dollarprice);
			$st->BindParam(5, $partnerprice);
			$st->BindParam(6, $ekey);
			$st->BindParam(7, $instcode);
		//	$st->BindParam(8, $newqty);
			$exe = $st->Execute();
		}

		if($category == 7){
			$sql = "UPDATE octopus_st_radiology SET SC_INSURANCEPRICE = ? , SC_ALTERNATEPRICE = ? , SC_CASHPRICE = ?  , SC_DOLLARPRICE = ? , SC_PARTNERPRICE = ? WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $cashprice);
			$st->BindParam(4, $dollarprice);
			$st->BindParam(5, $partnerprice);
			$st->BindParam(6, $ekey);
			$st->BindParam(7, $instcode);
		//	$st->BindParam(8, $newqty);
			$exe = $st->Execute();
		}

		$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $cashschemecode);
	//	$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){
			$two = 2;
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS != ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $cashprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $partnerprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $two);
			$exe = $st->execute();					
		}else{			
			$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $cashpricecode);
			$st->BindParam(2, $category);
			$st->BindParam(3, $itemcode);
			$st->BindParam(4, $itemname);
			$st->BindParam(5, $cashprice);
			$st->BindParam(6, $cashpaymentmethod);
			$st->BindParam(7, $cashpaymentmethodcode);
			$st->BindParam(8, $cashschemecode);
			$st->BindParam(9, $cash);
			$st->BindParam(10, $currentusercode);
			$st->BindParam(11, $currentuser);
			$st->BindParam(12, $instcode);
			$st->BindParam(13, $alternateprice);
			$st->BindParam(14, $partnerprice);
			$st->BindParam(15, $dollarprice);
			$exe = $st->execute();				
		}	

		if($insuranceprice > '0'){
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_OTHERPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYMENTMETHODCODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $alternateprice);
			$st->BindParam(5, $currentusercode);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $privateinsurancecode);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $one);
			$exe = $st->execute();	
		}			

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 25 OCT 2022 JOSEPH ADORBOE 
	public function devicesdetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_devices WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['DEV_DEVICE'].'@@'.$obj['DEV_RESTOCK'].'@@'.$obj['DEV_QTY'].'@@'.$obj['DEV_STOREQTY'].'@@'.$obj['DEV_TRANSFER'].'@@'.$obj['DEV_LASTDATE'].'@@'.$obj['DEV_TOTALQTY'].'@@'.$obj['DEV_INSURANCEPRICE'].'@@'.$obj['DEV_CASHPRICE'].'@@'.$obj['DEV_COSTPRICE'].'@@'.$obj['DEV_STOCKVALUE'].'@@'.$obj['DEV_OTHERPRICE'].'@@'.$obj['DEV_CODENUM'].'@@'.$obj['DEV_PARTNERPRICE'].'@@'.$obj['DEV_DOLLARPRICE'];				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}


	// 22 OCT 2022 JOSEPH ADORBOE 
	public function medicationdetails($idvalue,$instcode){	
			$one = 1;
            $sql = "SELECT * FROM octopus_st_medications WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $idvalue);
            $st->BindParam(2, $instcode);
        //    $st->BindParam(3, $one);
            $exe = $st->Execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$ordernum = $obj['MED_MEDICATION'].'@@'.$obj['MED_DOSAGE'].'@@'.$obj['MED_RESTOCK'].'@@'.$obj['MED_UNIT'].'@@'.$obj['MED_QTY'].'@@'.$obj['MED_STOREQTY'].'@@'.$obj['MED_TRANSFER'].'@@'.$obj['MED_LASTDATE'].'@@'.$obj['MED_INSURANCEPRICE'].'@@'.$obj['MED_ALTERPRICE'].'@@'.$obj['MED_CASHPRICE'].'@@'.$obj['MED_STOCKVALUE'].'@@'.$obj['MED_TOTALQTY'].'@@'.$obj['MED_CODENUM'].'@@'.$obj['MED_COSTPRICE'].'@@'.$obj['MED_PARTNERPRICE'].'@@'.$obj['MED_DOLLARPRICE'];				
			}else{			
				$ordernum = '0';			
			}
			return 	$ordernum; 	
			
        }


	// 19 OCT 2022 JOSEPH ADORBOE 
	public function getmedicationunit($itemcode,$instcode){	
		$one = 1;
		$sql = "SELECT MED_UNIT FROM octopus_st_medications WHERE MED_CODE = ? AND MED_INSTCODE = ? AND MED_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);		
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['MED_UNIT'];				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}

	// 18 APR 2022 JOSEPH ADORBOE 
	public function getcashprice($itemcode, $itemtype, $cashschemecode ,$instcode){	
		$three = 3;
		$one = 1;
        if ($itemtype == 1) {
            $sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ?  AND PS_STATUS = ?";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemcode);
            $st->BindParam(2, $instcode);
            $st->BindParam(3, $cashschemecode);
			$st->BindParam(4, $one);
            $exe = $st->Execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$ordernum = $obj['PS_PRICE'];				
			}else{			
				$ordernum = '0';			
			}
			return 	$ordernum; 	
		}
			
      
		
	}

	// 17 OCT 2022 JOSEPH ADORBOE 
	public function rejecttransfer($ekey,$rejectreason,$days,$itemqty,$itemcode,$type,$currentusercode,$currentuser,$instcode){	
		$two = 2;
		$one = 1;
		$zero = 0;
		if ($type == 5) {
			$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ? , DEV_TRANSFER = DEV_TRANSFER - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $itemqty);
			$st->BindParam(2, $itemqty);
			$st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
			$exe = $st->Execute();
			if($exe){

				$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?, SA_REASON = ?   WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $days);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $zero);
				$st->BindParam(5, $rejectreason);
				$st->BindParam(6, $ekey);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $one);				
				$exe = $st->Execute();
				if($exe){
					return '2';			
				}else{			
					return '0';			
				}
			}
		}

		if ($type == 2) {
			$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TRANSFER = MED_TRANSFER - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $itemqty);
			$st->BindParam(2, $itemqty);
			$st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
			$exe = $st->Execute();
			if($exe){

				$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?, SA_REASON = ?   WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $days);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $zero);
				$st->BindParam(5, $rejectreason);
				$st->BindParam(6, $ekey);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $one);				
				$exe = $st->Execute();
				if($exe){
					return '2';			
				}else{			
					return '0';			
				}
			}
		}
			
	}

	// 17 OCT 2022 JOSEPH ADORBOE 
	public function accepttransfer($ekey,$itemcode,$itemqty,$type,$days,$currentusercode,$currentuser,$instcode){	
		$two = 2;
		$one = 1;
		
        if ($type == 2) {

            $sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY + ? , MED_TRANSFER = MED_TRANSFER - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $days);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $two);
				$st->BindParam(5, $ekey);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $one);				
				$exe = $st->Execute();
				if($exe){
					return '2';			
				}else{			
					return '0';			
				}
		}
		}	
		
		if ($type == 5) {

            $sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY + ? , DEV_TRANSFER = DEV_TRANSFER - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemqty);
            $st->BindParam(3, $itemcode);
			$st->BindParam(4, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_ACTIONDATE = ?, SA_ACTIONACTOR = ?, SA_ACTIONACTORCODE = ? ,SA_STATUS = ?  WHERE SA_CODE = ? AND SA_INSTCODE = ?  AND SA_STATUS = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $days);
				$st->BindParam(2, $currentuser);
				$st->BindParam(3, $currentusercode);
				$st->BindParam(4, $two);
				$st->BindParam(5, $ekey);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $one);				
				$exe = $st->Execute();
				if($exe){
					return '2';			
				}else{			
					return '0';			
				}
		}
		}	
	}


	// // 17 OCT 2022 JOSEPH ADORBOE 
	// public function stockmovement($ekey,$type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$category){	
	// 	$three = 3;
		
    //     if ($type == 1) {

    //         $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY + ? , MED_TOTALQTY = ? , MED_COSTPRICE = ?  , MED_CASHPRICE = ?  , MED_STOCKVALUE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
    //         $st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $totalqty);
    //         $st->BindParam(3, $costprice);
	// 		$st->BindParam(4, $newprice);
	// 		$st->BindParam(5, $stockvalue);
	// 		$st->BindParam(6, $ekey);
	// 		$st->BindParam(7, $instcode);
	// 	//	$st->BindParam(8, $newqty);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);
	// 			$st->BindParam(18, $costprice);
	// 			$st->BindParam(19, $newprice);	
	// 			$exe = $st->execute();

	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $currentuser);
	// 			$st->BindParam(9, $currentusercode);
	// 			$st->BindParam(10, $instcode);
	// 			$st->BindParam(11, $expire);
	// 			$exep = $st->execute();

	// 			// $pricedifference = $newprice - $cashprice;
	// 			// if($pricedifference <'0'){
	// 			// 	$pricedifference = $newprice ;
	// 			// }
	// 			$one = 1;
	// 			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = PS_PRICE + ? , PS_ALTPRICE = PS_ALTPRICE + ? WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ?";
	// 			$st = $this->db->prepare($sql);
	// 			$st->BindParam(1, $newprice);
	// 			$st->BindParam(2, $pricedifference);
	// 			$st->BindParam(3, $itemcode);
	// 			$st->BindParam(4, $instcode);
	// 			$st->BindParam(5, $one);
	// 			$exe = $st->Execute();

	// 			// $sql = "UPDATE octopus_st_medications SET MED_TOTALQTY = MED_QTY + MED_STOREQTY + MED_TRANSFER WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
	// 			// $st = $this->db->prepare($sql);
	// 			// // $st->BindParam(1, $suppliedqty);
	// 			// // $st->BindParam(2, $ekey);
	// 			// // $st->BindParam(3, $instcode);
	// 			// $exe = $st->Execute();

	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}

	// 	}

	// 	if ($type == 2) {

    //         $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ?, MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
    //         $st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $suppliedqty);
    //         $st->BindParam(3, $ekey);
	// 		$st->BindParam(4, $instcode);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);	
	// 			$exe = $st->execute();
	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}
	// 	}

	// 	if ($type == 3) {

    //         $sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY - ?, MED_STOREQTY = MED_STOREQTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
    //         $st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $suppliedqty);
    //         $st->BindParam(3, $ekey);
	// 		$st->BindParam(4, $instcode);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);	
	// 			$exe = $st->execute();
	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}
	// 	}

	// 	if ($type == 4) {

    //         $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY + ?, DEV_TOTALQTY = ? ,  DEV_COSTPRICE = ? , DEV_CASHPRICE = ?, DEV_STOCKVALUE = ?  WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
	// 		$st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $totalqty);
    //         $st->BindParam(3, $costprice);
	// 		$st->BindParam(4, $newprice);
	// 		$st->BindParam(5, $stockvalue);
	// 		$st->BindParam(6, $ekey);
	// 		$st->BindParam(7, $instcode);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT,SA_COSTPRICE,SA_NEWPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);
	// 			$st->BindParam(18, $costprice);
	// 			$st->BindParam(19, $newprice);	
	// 			$exe = $st->execute();

	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $currentuser);
	// 			$st->BindParam(9, $currentusercode);
	// 			$st->BindParam(10, $instcode);
	// 			$st->BindParam(11, $expire);
	// 			$exep = $st->execute();

	// 			$pricedifference = $newprice - $cashprice;
	// 			if($pricedifference <'0'){
	// 				$pricedifference = $newprice ;
	// 			}
	// 			$one = 1;
	// 			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = PS_PRICE + ? , PS_ALTPRICE = PS_ALTPRICE + ?, PS_OTHERPRICE =  PS_OTHERPRICE + ? WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ?";
	// 			$st = $this->db->prepare($sql);
	// 			$st->BindParam(1, $pricedifference);
	// 			$st->BindParam(2, $pricedifference);
	// 			$st->BindParam(3, $pricedifference);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $instcode);
	// 			$st->BindParam(6, $one);
	// 			$exe = $st->Execute();

	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}

	// 	}

		
	// 	if ($type == 5) {

    //         $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ?, DEV_TRANSFER = DEV_TRANSFER + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
    //         $st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $suppliedqty);
    //         $st->BindParam(3, $ekey);
	// 		$st->BindParam(4, $instcode);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);	
	// 			$exe = $st->execute();
	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}
	// 	}

	// 	if ($type == 6) {

    //         $sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY - ?, DEV_STOREQTY = DEV_STOREQTY + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
    //         $st = $this->db->prepare($sql);
    //         $st->BindParam(1, $suppliedqty);
    //         $st->BindParam(2, $suppliedqty);
    //         $st->BindParam(3, $ekey);
	// 		$st->BindParam(4, $instcode);
    //         $exe = $st->Execute();
	// 		if($exe){	
	// 			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	// 			$st = $this->db->prepare($sqlstmt);   
	// 			$st->BindParam(1, $ajustcode);
	// 			$st->BindParam(2, $adjustmentnumber);
	// 			$st->BindParam(3, $days);
	// 			$st->BindParam(4, $itemcode);
	// 			$st->BindParam(5, $itemnumber);
	// 			$st->BindParam(6, $item);
	// 			$st->BindParam(7, $suppliedqty);
	// 			$st->BindParam(8, $newqty);
	// 			$st->BindParam(9, $storeqty);
	// 			$st->BindParam(10, $type);
	// 			$st->BindParam(11, $currentshift);
	// 			$st->BindParam(12, $currentshiftcode);	
	// 			$st->BindParam(13, $expire);
	// 			$st->BindParam(14, $currentuser);
	// 			$st->BindParam(15, $currentusercode);
	// 			$st->BindParam(16, $instcode);	
	// 			$st->BindParam(17, $unit);	
	// 			$exe = $st->execute();
	// 				return '2';			
	// 			}else{			
	// 				return '0';			
	// 			}
	// 	}		
	// }

	// 18 APR 2022 JOSEPH ADORBOE 
	public function restockgetstorebalance($itemcode, $itemtype, $instcode){	
		$three = 3;
		$one = 1;
        if ($itemtype == 1) {
            $sql = "SELECT MED_STOREQTY FROM octopus_st_medications WHERE MED_CODE = ? AND MED_INSTCODE = ? AND MED_STATUS = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemcode);
            $st->BindParam(2, $instcode);
            $st->BindParam(3, $one);
            $exe = $st->Execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$ordernum = $obj['MED_STOREQTY'];				
			}else{			
				$ordernum = '0';			
			}
			return 	$ordernum; 	
			
        }else 

		if ($itemtype == 2) {
            $sql = "SELECT ITM_STOREQTY FROM octopus_st_items WHERE ITM_CODE = ? AND ITM_INSTCODE = ? AND ITM_STATUS = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemcode);
            $st->BindParam(2, $instcode);
            $st->BindParam(3, $one);
            $exe = $st->Execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$ordernum = $obj['ITM_STOREQTY'];				
			}else{			
				$ordernum = '0';			
			}
			return 	$ordernum; 	
			
        }else 

		if ($itemtype == 3) {
            $sql = "SELECT DEV_STOREQTY FROM octopus_st_devices WHERE DEV_CODE = ? AND DEV_INSTCODE = ? AND DEV_STATUS = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemcode);
            $st->BindParam(2, $instcode);
            $st->BindParam(3, $one);
            $exe = $st->Execute();
			if($st->rowcount() > 0){			
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$ordernum = $obj['DEV_STOREQTY'];				
			}else{			
				$ordernum = '0';			
			}
			return 	$ordernum;
        }
		
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function restock($requestcode, $itemcode, $itemqty, $itemtype, $instcode, $days, $currentusercode, $currentuser){	
		$three = 3;
        if ($itemtype == 1) {
            $sql = "UPDATE octopus_st_medications SET MED_QTY = MED_QTY + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_requistions SET REQ_STATUS = ? ,REQ_PROCESSACTORCODE = ?,  REQ_PROCESSACTOR = ?,  REQ_PROCESSDATE = ?  WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }else 

		if ($itemtype == 2) {
            $sql = "UPDATE octopus_st_items SET ITM_QTY = ITM_QTY + ? WHERE ITM_CODE = ? AND ITM_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_requistions SET REQ_STATUS = ? ,REQ_PROCESSACTORCODE = ?,  REQ_PROCESSACTOR = ?,  REQ_PROCESSDATE = ?  WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }else 

		if ($itemtype == 3) {
            $sql = "UPDATE octopus_st_devices SET DEV_QTY = DEV_QTY + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $itemqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				$sql = "UPDATE octopus_requistions SET REQ_STATUS = ? ,REQ_PROCESSACTORCODE = ?,  REQ_PROCESSACTOR = ?,  REQ_PROCESSDATE = ?  WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $three);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $requestcode);
				$st->BindParam(6, $instcode);
				$exe = $st->Execute();		
				return '2';			
			}else{			
				return '0';			
			}
        }
		
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function removerequestitems($ekey,$currentusercode,$currentuser,$instcode){	
		$zero = '0';
		$sql = "UPDATE octopus_requistions SET REQ_STATUS = ? , REQ_ACTORCODE = ?, REQ_ACTOR = ? WHERE REQ_CODE = ? AND REQ_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function supplyrequestitems($ekey,$itemcode,$suppliedqty,$type,$days,$currentusercode,$currentuser,$instcode){
		$two =2;	
		if ($type == 1) {
            $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			
			if($exe){
				$sql = "UPDATE octopus_requistions SET REQ_SUPPLIEDQTY = ? , REQ_SUPPLYACTORCODE = ?, REQ_SUPPLYACTOR = ?, REQ_SUPPLYDATE = ?, REQ_STATUS = ?   WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $suppliedqty);
				$st->BindParam(2, $currentusercode);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $days);
				$st->BindParam(5, $two);
				$st->BindParam(6, $ekey);
				$st->BindParam(7, $instcode);
				$exe = $st->Execute();		
				if($exe){			
					return '2';			
				}else{			
					return '0';			
				}
			}else{			
				return '0';			
			}
			
        }else 

		if ($type == 2) {
            $sql = "UPDATE octopus_st_items SET ITM_STOREQTY = ITM_STOREQTY - ? WHERE ITM_CODE = ? AND ITM_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				
		$sql = "UPDATE octopus_requistions SET REQ_SUPPLIEDQTY = ? , REQ_SUPPLYACTORCODE = ?, REQ_SUPPLYACTOR = ?, REQ_SUPPLYDATE = ?, REQ_STATUS = ?   WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $days);
		$st->BindParam(5, $two);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}else{			
		return '0';			
	}
        }else 

		if ($type == 3) {
            $sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
            $st = $this->db->prepare($sql);
            $st->BindParam(1, $suppliedqty);
            $st->BindParam(2, $itemcode);
            $st->BindParam(3, $instcode);
            $exe = $st->Execute();
			if($exe){	
				
		$sql = "UPDATE octopus_requistions SET REQ_SUPPLIEDQTY = ? , REQ_SUPPLYACTORCODE = ?, REQ_SUPPLYACTOR = ?, REQ_SUPPLYDATE = ?, REQ_STATUS = ?   WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliedqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $days);
		$st->BindParam(5, $two);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}else{			
		return '0';			
	}
        }

		
	}

	// 16 APR 2022 JOSEPH ADORBOE 
	public function editrequestitems($ekey,$requestedqty,$currentusercode,$currentuser,$instcode){	
		
		$sql = "UPDATE octopus_requistions SET REQ_REQUESTEDQTY = ? , REQ_ACTORCODE = ?, REQ_ACTOR = ? WHERE  REQ_CODE = ? AND REQ_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $requestedqty);
		$st->BindParam(2, $currentusercode);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 16 APR 2022 ,  JOSEPH ADORBOE
    public function saverequestions($requestitemcode, $requestionnumber, $itemcode, $itemname, $itemnumber, $itemqty, $requiredqty, $type,$instcode, $day, $currentusercode, $currentuser){
	
		$one = 1;
		$sqlstmt = ("SELECT REQ_ID FROM octopus_requistions where REQ_ITEMCODE = ? AND REQ_INSTCODE = ? AND REQ_STATUS = ? AND REQ_REQUESTIONNUM = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $requestionnumber);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{
				
			$sqlstmt = "INSERT INTO octopus_requistions(REQ_CODE,REQ_REQUESTIONNUM,REQ_DATE,REQ_CODENUM,REQ_ITEMCODE,REQ_ITEM,REQ_QTY,REQ_ACTORCODE,REQ_ACTOR,REQ_INSTCODE,REQ_REQUESTEDQTY,REQ_TYPE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $requestitemcode);
			$st->BindParam(2, $requestionnumber);
			$st->BindParam(3, $day);
			$st->BindParam(4, $itemnumber);
			$st->BindParam(5, $itemcode);
			$st->BindParam(6, $itemname);
			$st->BindParam(7, $itemqty);
			$st->BindParam(8, $currentusercode);
			$st->BindParam(9, $currentuser);
			$st->BindParam(10, $instcode);
			$st->BindParam(11, $requiredqty);
			$st->BindParam(12, $type);		
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