<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 12 MAY 2023
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class MedicationController Extends Engine{

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function approvebulkdevicetransfer($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode){	
		$three = 3;
		$one = 1;
		
		$sql = "UPDATE octopus_st_devices SET DEV_STOREQTY = DEV_STOREQTY - ?, DEV_TRANSFER = DEV_TRANSFER + ? WHERE DEV_CODE = ? AND DEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $medciationcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $ajustcode);
		$st->BindParam(3, $instcode);
		$exe = $st->Execute();

		if($exe){
			return '2';			
		}else{			
			return '0';			
		}		
	}

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function approvebulkmedicationtransfer($ajustcode,$medciationcode,$addqty,$days,$currentusercode,$currentuser,$instcode){	
		$three = 3;
		$one = 1;
		
		$sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ?, MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $addqty);
		$st->BindParam(2, $addqty);
		$st->BindParam(3, $medciationcode);
		$st->BindParam(4, $instcode);
		$exe = $st->Execute();
		
		$sql = "UPDATE octopus_pharmacy_stockadjustment SET SA_STATE = ? WHERE SA_CODE = ? AND SA_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $ajustcode);
		$st->BindParam(3, $instcode);
		$exe = $st->Execute();

		if($exe){
			return '2';			
		}else{			
			return '0';			
		}		
	}

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function transferbulkmedication($type,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3;
		$one = 1;
		
		// $sql = "UPDATE octopus_st_medications SET MED_STOREQTY = MED_STOREQTY - ?, MED_TRANSFER = MED_TRANSFER + ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
		// $st = $this->db->prepare($sql);
		// $st->BindParam(1, $suppliedqty);
		// $st->BindParam(2, $suppliedqty);
		// $st->BindParam(3, $itemcode);
		// $st->BindParam(4, $instcode);
		// $exe = $st->Execute();
		// if($exe){	
			$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $ajustcode);
			$st->BindParam(2, $adjustmentnumber);
			$st->BindParam(3, $days);
			$st->BindParam(4, $itemcode);
			$st->BindParam(5, $itemnumber);
			$st->BindParam(6, $item);
			$st->BindParam(7, $suppliedqty);
			$st->BindParam(8, $newtransferqty);
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
			if($exe){
				return '2';			
			}else{			
				return '0';			
			}		
	}


	// 18 MAY 2023 JOSEPH ADORBOE 
	public function transfermedication($type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode){	
		$three = 3;
		
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

	// 15 MAY 2021 JOSEPH ADORBOE
	public function editedprices($ekey,$price,$alternateprice,$otherprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode,$category,$paycode,$cashpaymentmethodcode,$stockvalue,$itemcode){

		$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE = ?, PS_ACTOR = ?,  PS_ACTORCODE = ? , PS_OTHERPRICE = ? , PS_DOLLARPRICE = ? WHERE PS_CODE = ? and PS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $price);
		$st->BindParam(2, $alternateprice);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $partnerprice);
		$st->BindParam(6, $dollarprice);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();	
		
		if ($category == 2) {
			if($paycode==$cashpaymentmethodcode){
				$sql = "UPDATE octopus_st_medications SET MED_CASHPRICE = ?  , MED_STOCKVALUE = ?, MED_PARTNERPRICE = ?, MED_ALTERPRICE = ?, MED_DOLLARPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $price);
				$st->BindParam(2, $stockvalue);
				$st->BindParam(3, $partnerprice);
				$st->BindParam(4, $alternateprice);
				$st->BindParam(5, $dollarprice);
				$st->BindParam(6, $itemcode);
				$st->BindParam(7, $instcode);
				$exe = $st->Execute();
			}

			if($paycode!==$cashpaymentmethodcode){
				$sql = "UPDATE octopus_st_medications SET MED_INSURANCEPRICE = ? , MED_PARTNERPRICE = ?, MED_ALTERPRICE = ? WHERE MED_CODE = ? AND MED_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $price);
				$st->BindParam(2, $partnerprice);
				$st->BindParam(3, $alternateprice);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $instcode);
				$exe = $st->Execute();
			}
           
		}
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}


	// 14 DEC 2022 ,  JOSEPH ADORBOE
    public function setupnewmedication($form_key,$adjustmentnumber,$ajustcode,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$storeqty,$brandname,$medicationdose,$transferqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$days,$totalqty,$stockvalue,$expirycode,$expire,$category,$cashpricecode,$alternateprice,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$partnerprice,$currentuser,$currentusercode,$instcode,$currentshift,$currentshiftcode){	
		$mt = 1;
		$type = 2;
		$cash = 'CASH';
		$sqlstmt = ("SELECT MED_ID FROM octopus_st_medications where MED_MEDICATION = ? and  MED_INSTCODE = ?  and MED_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $medication);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_CODENUM,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_RESTOCK,MED_UNITCODE,MED_UNIT,MED_STOREQTY,MED_ACTOR,MED_ACTORCODE,MED_INSTCODE,MED_BRANDNAME,MED_DOSE,MED_CASHPRICE,MED_INSURANCEPRICE,MED_COSTPRICE,MED_STOCKVALUE,MED_LASTDATE,MED_TOTALQTY,MED_ALTERPRICE,MED_TRANSFER,MED_PARTNERPRICE,MED_DOLLARPRICE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $medicationnumber);
				$st->BindParam(3, $medication);
				$st->BindParam(4, $dosageformcode);
				$st->BindParam(5, $dosageformname);
				$st->BindParam(6, $restock);
				$st->BindParam(7, $untcode);
				$st->BindParam(8, $untname);
				$st->BindParam(9, $storeqty);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $brandname);
				$st->BindParam(14, $medicationdose);
				$st->BindParam(15, $cashprice);
				$st->BindParam(16, $insuranceprice);
				$st->BindParam(17, $costprice);
				$st->BindParam(18, $stockvalue);
				$st->BindParam(19, $days);
				$st->BindParam(20, $totalqty);
				$st->BindParam(21, $dollarprice);
				$st->BindParam(22, $transferqty);
				$st->BindParam(23, $partnerprice);
				$st->BindParam(24, $dollarprice);
				$exe = $st->execute();
				if($exe){

				if($transferqty > '0'){
					$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $ajustcode);
					$st->BindParam(2, $adjustmentnumber);
					$st->BindParam(3, $days);
					$st->BindParam(4, $form_key);
					$st->BindParam(5, $medicationnumber);
					$st->BindParam(6, $medication);
					$st->BindParam(7, $transferqty);
					$st->BindParam(8, $totalqty);
					$st->BindParam(9, $storeqty);
					$st->BindParam(10, $type);
					$st->BindParam(11, $currentshift);
					$st->BindParam(12, $currentshiftcode);	
					$st->BindParam(13, $expire);
					$st->BindParam(14, $currentuser);
					$st->BindParam(15, $currentusercode);
					$st->BindParam(16, $instcode);	
					$st->BindParam(17, $untname);	
					$exe = $st->execute();

				}					

				$sqlstmt = "INSERT INTO octopus_pharmacy_expiry(EXP_CODE,EXP_SUPPLYCODE,EXP_DATE,EXP_MEDICATIONCODE,EXP_MEDICATIONNUM,EXP_MEDICATION,EXP_QTY,EXP_ACTOR,EXP_ACTORCODE,EXP_INSTCODE,EXP_EXPIRYDATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $ajustcode);
				$st->BindParam(2, $adjustmentnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $form_key);
				$st->BindParam(5, $medicationnumber);
				$st->BindParam(6, $medication);
				$st->BindParam(7, $storeqty);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $expire);
				$exep = $st->execute();
			//	$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,

				$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $cashpricecode);
				$st->BindParam(2, $category);
				$st->BindParam(3, $form_key);
				$st->BindParam(4, $medication);
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

				}else{
					return '0';
				}
			}
		}else{
			return '1';
		}	
	}

	// 29 DEC 2022 JOSEPH ADORBOE
	public function editadminmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$pharmacyqty,$storeqty,$transferqty,$mnum,$medicationbrand,$medicationdose,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_medications SET MED_CODENUM = ?, MED_MEDICATION = ?,  MED_DOSAGECODE = ?, MED_DOSAGE =? , MED_RESTOCK =?, MED_UNITCODE =?, MED_UNIT =?, MED_QTY =?, MED_ACTOR =?, MED_ACTORCODE = ? , MED_BRANDNAME = ? , MED_DOSE = ? ,MED_STOREQTY = ?, MED_TRANSFER = ? , MED_TOTALQTY = ? , MED_STOCKVALUE = ? WHERE MED_CODE = ?  AND MED_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $medicationnumber);
		$st->BindParam(2, $medication);
		$st->BindParam(3, $dosageformcode);
		$st->BindParam(4, $dosageformname);
		$st->BindParam(5, $restock);
		$st->BindParam(6, $untcode);
		$st->BindParam(7, $untname);
		$st->BindParam(8, $pharmacyqty);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $medicationbrand);
		$st->BindParam(12, $medicationdose);
		$st->BindParam(13, $storeqty);
		$st->BindParam(14, $transferqty);
		$st->BindParam(15, $totalqty);
		$st->BindParam(16, $stockvalue);
		$st->BindParam(17, $ekey);
		$st->BindParam(18, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';							
		}else{								
			return '0';								
		}	
	}


	// 11 JAN 2023  JOSEPH ADORBOE 
	public function removemedications($ekey,$category,$currentuser,$currentusercode,$instcode){
				
		$sql = " DELETE FROM octopus_st_medications WHERE MED_CODE = ? AND MED_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();	

		$sql = " DELETE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();	

		$sql = " DELETE FROM octopus_prescriptionplan_medication WHERE TRM_MEDICATIONCODE = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}


	// 13 MAY 2023 JOSEPH ADORBOE
	public function editnewmedication($ekey,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$mnum,$medicationbrand,$medicationdose,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_medications SET MED_CODENUM = ?, MED_MEDICATION = ?,  MED_DOSAGECODE = ?, MED_DOSAGE =? , MED_RESTOCK =?, MED_UNITCODE =?, MED_UNIT =?, MED_QTY =?, MED_ACTOR =?, MED_ACTORCODE = ? , MED_BRANDNAME = ? , MED_DOSE = ? WHERE MED_CODE = ?  ";
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
		$st->BindParam(11, $medicationbrand);
		$st->BindParam(12, $medicationdose);
		$st->BindParam(13, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_MEDICATIONCODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $medicationnumber);
				$st->BindParam(2, $instcode);						
				$exe = $st->execute();
			}
				$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $medication);
				$st->BindParam(2, $ekey);	
				$st->BindParam(3, $instcode);					
				$exe = $st->execute();

				$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_MEDICATION = ?  WHERE TRM_MEDICATIONCODE = ? AND TRM_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $medication);
				$st->BindParam(2, $ekey);	
				$st->BindParam(3, $instcode);					
				$exe = $st->execute();
			return '2';							
		}else{								
			return '0';								
		}	
	}

	// 12 MAY 2023 JOSEPH ADORBOE 
	public function getlastmedicationcodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_MEDICATIONCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}
		}else{
			return '-1';
		}			
	}

	
	
} 
?>