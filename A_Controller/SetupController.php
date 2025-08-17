<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 25 MAR 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class SetupController Extends Engine{

	// 12 JAN 2023  JOSEPH ADORBOE
	public function setupstockqty($ekey, $totalqty, $storeqty, $pharmacyqty, $transferqty, $stockvalue, $category,$currentuser, $currentusercode, $instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;

		if($category == 2){
			$sql = "UPDATE octopus_st_medications SET MED_QTY = ?, MED_STOREQTY =?, MED_TRANSFER = ?, MED_TOTALQTY = ?, MED_STOCKVALUE = ? , MED_ACTOR = ?, MED_ACTORCODE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $pharmacyqty);
			$st->BindParam(2, $storeqty);
			$st->BindParam(3, $transferqty);
			$st->BindParam(4, $totalqty);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $currentusercode);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $one);
			$st->BindParam(10, $instcode);
			$exe = $st->execute();	
			if($exe){	
				return '2';								
			}else{								
				return '0';								
			}			
		}

	

		if($category == 5){
			
			$sql = "UPDATE octopus_st_devices SET DEV_QTY = ?, DEV_STOREQTY =?, DEV_TRANSFER = ?, DEV_TOTALQTY = ?, DEV_STOCKVALUE = ? , DEV_ACTOR = ?, DEV_ACTORCODE = ? WHERE DEV_CODE = ? AND DEV_STATUS = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $pharmacyqty);
			$st->BindParam(2, $storeqty);
			$st->BindParam(3, $transferqty);
			$st->BindParam(4, $totalqty);
			$st->BindParam(5, $stockvalue);
			$st->BindParam(6, $currentuser);
			$st->BindParam(7, $currentusercode);
			$st->BindParam(8, $ekey);
			$st->BindParam(9, $one);
			$st->BindParam(10, $instcode);
			$exe = $st->execute();	
			if($exe){	
				return '2';								
			}else{								
				return '0';								
			}			
		
		}

		
	}

	// 11 JAN 2023  JOSEPH ADORBOE
	public function removedevices($ekey,$category,$currentuser,$currentusercode,$instcode){
				
		$sql = " DELETE FROM octopus_st_devices WHERE DEV_CODE = ? AND DEV_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();	
		
		$sql = " DELETE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ?  ";
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


	// 28 Dec 2022 JOSEPH ADORBOE 
	public function imagingedetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_radiology WHERE SC_CODE = ? AND SC_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['SC_CODE'].'@@'.$obj['SC_CODENUM'].'@@'.$obj['SC_NAME'].'@@'.$obj['SC_DESC'].'@@'.$obj['SC_CASHPRICE'].'@@'.$obj['SC_ALTERNATEPRICE'].'@@'.$obj['SC_INSURANCEPRICE'].'@@'.$obj['SC_DOLLARPRICE'].'@@'.$obj['SC_PARTNERPRICE'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}


	// 28 DEC 2022 JOSEPH ADORBOE
	public function editnewimagingg($ekey,$imaging,$description,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sql = "UPDATE octopus_st_radiology SET SC_NAME = ?,  SC_DESC = ?, SC_ACTOR =? , SC_ACTORCODE = ?  WHERE SC_CODE = ? AND SC_INSTCODE = ?  AND SC_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $imaging);
		$st->BindParam(2, $description);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$st->BindParam(7, $one);
	//	$st->BindParam(8, $one);
	//	$st->BindParam(9, $one);
		$exe = $st->execute();
						
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}			
	}	

	// 28 DEC 2022,  JOSEPH ADORBOE
    public function addnewimagingsed($form_key,$imaging,$labnumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT SC_ID FROM octopus_st_radiology where SC_NAME = ? and  SC_INSTCODE = ?  and SC_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $imaging);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_radiology(SC_CODE,SC_CODENUM,SC_NAME,SC_DESC,SC_ACTOR,SC_ACTORCODE,SC_INSTCODE,SC_CASHPRICE,SC_ALTERNATEPRICE,SC_INSURANCEPRICE,SC_DOLLARPRICE,SC_PARTNERPRICE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $labnumber);
				$st->BindParam(3, $imaging);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $cashprice);
				$st->BindParam(9, $alternateprice);
				$st->BindParam(10, $insuranceprice);
				$st->BindParam(11, $dollarprice);
				$st->BindParam(12, $partnerprice);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();	
					
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $form_key);
					$st->BindParam(4, $imaging);
					$st->BindParam(5, $cashprice);
					$st->BindParam(6, $cashpaymentmethod);
					$st->BindParam(7, $cashpaymentmethodcode);
					$st->BindParam(8, $cashschemecode);
					$st->BindParam(9, $cash);
					$st->BindParam(10, $currentusercode);
					$st->BindParam(11, $currentuser);
					$st->BindParam(12, $instcode);
					$st->BindParam(13, $partnerprice);
					$st->BindParam(14, $insuranceprice);
					$st->BindParam(15, $dollarprice);
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
			return '0';
		}	
	}

	// 28 Dec 2022 JOSEPH ADORBOE 
	public function labsdetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_labtest WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['LTT_CODE'].'@@'.$obj['LTT_CODENUM'].'@@'.$obj['LTT_NAME'].'@@'.$obj['LTT_DESC'].'@@'.$obj['LTT_CASHPRICE'].'@@'.$obj['LTT_ALTERNATEPRICE'].'@@'.$obj['LTT_INSURANCEPRICE'].'@@'.$obj['LTT_DOLLARPRICE'].'@@'.$obj['LTT_PARTNERPRICE'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}

	// 25 DEC 2022  JOSEPH ADORBOE
	public function enablesetup($ekey,$category,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;

		if($category == 1){
			$sql = "UPDATE octopus_admin_services SET SEV_STATUS = ?, SEV_ACTOR =?, SEV_ACTORCODE = ? WHERE SEV_SERVICECODE = ? AND SEV_STATUS = ? AND SEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();				
		}

		if($category == 2){
			$sql = "UPDATE octopus_st_medications SET MED_STATUS = ?, MED_ACTOR =?, MED_ACTORCODE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
			
			$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ?, TRM_ACTOR =?, TRM_ACTORCODE = ? WHERE TRM_MEDICATIONCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
			
		}

		if($category == 3){
			
			$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_ACTOR =?, LTT_ACTORCODE = ? WHERE LTT_CODE = ? AND LTT_STATUS = ? AND LTT_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();

			$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR =?, TRM_ACTORCODE = ? WHERE TRM_TESTCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}

		if($category == 5){
			
			$sql = "UPDATE octopus_st_devices SET DEV_STATUS = ?, DEV_ACTOR =?, DEV_ACTORCODE = ? WHERE DEV_CODE = ? AND DEV_STATUS = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();	
		
		}

		if($category == 6){
			$sql = "UPDATE octopus_st_procedures SET MP_STATUS = ?, MP_ACTOR =?, MP_ACTORCODE = ? WHERE MP_CODE = ? AND MP_STATUS = ? AND MP_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}

		if($category == 7){
			$sql = "UPDATE octopus_st_radiology SET SC_STATUS = ?, SC_ACTOR =?, SC_ACTORCODE = ? WHERE SC_CODE = ? AND SC_STATUS = ? AND SC_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $zero);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ?  AND PS_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 25 DEC 2022  JOSEPH ADORBOE
	public function disablesetup($ekey,$category,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		if ($category == 1) {
			$sql = "UPDATE octopus_admin_services SET SEV_STATUS = ?, SEV_ACTOR =?, SEV_ACTORCODE = ? WHERE SEV_SERVICECODE = ?  AND SEV_STATUS = ? AND SEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}
		if($category == 2){
			$sql = "UPDATE octopus_st_medications SET MED_STATUS = ?, MED_ACTOR =?, MED_ACTORCODE = ? WHERE MED_CODE = ? AND MED_STATUS = ? AND MED_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
			
			$sql = "UPDATE octopus_prescriptionplan_medication SET TRM_STATUS = ?, TRM_ACTOR =?, TRM_ACTORCODE = ? WHERE TRM_MEDICATIONCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
			
			
		}

		if ($category == 3) {
			$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_ACTOR =?, LTT_ACTORCODE = ? WHERE LTT_CODE = ? AND LTT_STATUS = ? AND LTT_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();

			$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR =?, TRM_ACTORCODE = ? WHERE TRM_TESTCODE = ? AND TRM_STATUS = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();

			
		}
		if($category == 5){
			
			$sql = "UPDATE octopus_st_devices SET DEV_STATUS = ?, DEV_ACTOR =?, DEV_ACTORCODE = ? WHERE DEV_CODE = ? AND DEV_STATUS = ? AND DEV_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();		
		}

		if($category == 6){
			$sql = "UPDATE octopus_st_procedures SET MP_STATUS = ?, MP_ACTOR =?, MP_ACTORCODE = ? WHERE MP_CODE = ? AND MP_STATUS = ? AND MP_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}
		if($category == 7){
			$sql = "UPDATE octopus_st_radiology SET SC_STATUS = ?, SC_ACTOR =?, SC_ACTORCODE = ? WHERE SC_CODE = ? AND SC_STATUS = ? AND SC_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $zero);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $ekey);
			$st->BindParam(5, $one);
			$st->BindParam(6, $instcode);
			$exe = $st->execute();
		}
		
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ? AND PS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 27 DEC 2022,  JOSEPH ADORBOE
    public function addnewlabsed($form_key,$labs,$labnumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$partnercode,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest where LTT_NAME = ? and  LTT_INSTCODE = ?  and LTT_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labs);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_CODENUM,LTT_NAME,LTT_DESC,LTT_ACTOR,LTT_ACTORCODE,LTT_INSTCODE,LTT_CASHPRICE,LTT_ALTERNATEPRICE,LTT_INSURANCEPRICE,LTT_DOLLARPRICE,LTT_PARTNERPRICE,LTT_PARTNERCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $labnumber);
				$st->BindParam(3, $labs);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $cashprice);
				$st->BindParam(9, $alternateprice);
				$st->BindParam(10, $insuranceprice);
				$st->BindParam(11, $dollarprice);
				$st->BindParam(12, $partnerprice);
				$st->BindParam(13, $partnercode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();	
					
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $form_key);
					$st->BindParam(4, $labs);
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
			return '0';
		}	
	}

	// 25 Dec 2022 JOSEPH ADORBOE 
	public function servicedetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_admin_services WHERE SEV_SERVICECODE = ? AND SEV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['SEV_CODE'].'@@'.$obj['SEV_SERVICECODE'].'@@'.$obj['SEV_SERVICES'].'@@'.$obj['SEV_CASHPRICE'].'@@'.$obj['SEV_ALTPRICE'].'@@'.$obj['SEV_INSURANCE'].'@@'.$obj['SEV_DOLLAR'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}

		// 24 DEC 2022  JOSEPH ADORBOE
	public function enableprice($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_CODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 24 DEC 2022  JOSEPH ADORBOE
	public function disableprice($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_CODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 24 Dec 2022 JOSEPH ADORBOE 
	public function proceduredetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_procedures WHERE MP_CODE = ? AND MP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
	//	$st->BindParam(3, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['MP_CODE'].'@@'.$obj['MP_CODENUM'].'@@'.$obj['MP_NAME'].'@@'.$obj['MP_DESC'].'@@'.$obj['MP_CASHPRICE'].'@@'.$obj['MP_ALTERNATEPRICE'].'@@'.$obj['MP_INSURANCEPRICE'].'@@'.$obj['MP_DOLLARPRICE'].'@@'.$obj['MP_PARTNERPRICE'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}

	// 24 DEC 2022,  JOSEPH ADORBOE
    public function setinsuranceprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser){
		$one = 1;	

		$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ?  AND PS_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $schemecode);
		$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($st->rowcount() > 0){
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ? WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $currentusercode);
			$st->BindParam(5, $currentuser);
			$st->BindParam(6, $schemecode);
			$st->BindParam(7, $itemcode);
			$st->BindParam(8, $instcode);
			$st->BindParam(9, $one);
			$exe = $st->execute();			
		}else{
			$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $pricecode);
			$st->BindParam(2, $category);
			$st->BindParam(3, $itemcode);
			$st->BindParam(4, $itemname);
			$st->BindParam(5, $insuranceprice);
			$st->BindParam(6, $insurancename);
			$st->BindParam(7, $insurancecode);
			$st->BindParam(8, $schemecode);
			$st->BindParam(9, $schemename);
			$st->BindParam(10, $currentusercode);
			$st->BindParam(11, $currentuser);
			$st->BindParam(12, $instcode);
			$st->BindParam(13, $alternateprice);
			$st->BindParam(14, $insuranceprice);
			$st->BindParam(15, $dollarprice);
			$exe = $st->execute();	

		}
						
		
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
				
		
	}

	// 24 DEC 2022,  JOSEPH ADORBOE
    public function addnewprocedureed($form_key,$procedure,$procedurenumber,$description,$cashprice,$alternateprice,$dollarprice,$insuranceprice,$cashpaymentmethod,$cashpaymentmethodcode,$cashschemecode,$cash,$cashpricecode,$category,$partnerprice,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT MP_ID FROM octopus_st_procedures where MP_NAME = ? and  MP_INSTCODE = ?  and MP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $procedure);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_procedures(MP_CODE,MP_CODENUM,MP_NAME,MP_DESC,MP_ACTOR,MP_ACTORCODE,MP_INSTCODE,MP_CASHPRICE,MP_ALTERNATEPRICE,MP_INSURANCEPRICE,MP_DOLLARPRICE,MP_PARTNERPRICE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $procedurenumber);
				$st->BindParam(3, $procedure);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $cashprice);
				$st->BindParam(9, $alternateprice);
				$st->BindParam(10, $insuranceprice);
				$st->BindParam(11, $dollarprice);
				$st->BindParam(12, $partnerprice);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_PROCEDURE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $procedurenumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();	
					
					$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $cashpricecode);
					$st->BindParam(2, $category);
					$st->BindParam(3, $form_key);
					$st->BindParam(4, $procedure);
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
			return '0';
		}	
	}

	// 20 DEC 2022 ,  JOSEPH ADORBOE
    public function setupnewdevices($form_key,$adjustmentnumber,$ajustcode,$devices,$devicenumber,$restock,$storeqty,$transferqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$days,$totalqty,$stockvalue,$expirycode,$expire,$category,$cashpricecode,$alternateprice,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$description,$partnerprice,$currentuser,$currentusercode,$instcode,$currentshift,$currentshiftcode){	
		$mt = 1;
		$type = 5;
		$cash = 'CASH';
		$untname = 'pack';
		$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices where DEV_DEVICE = ? and  DEV_INSTCODE = ?  and DEV_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $devices);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_STOREQTY,DEV_RESTOCK,DEV_TRANSFER,DEV_STOCKVALUE,DEV_COSTPRICE,DEV_CASHPRICE,DEV_TOTALQTY,DEV_INSTCODE,DEV_LASTDATE,DEV_ACTOR,DEV_ACTORCODE,DEV_INSURANCEPRICE,DEV_PARTNERPRICE,DEV_DOLLARPRICE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $devicenumber);
				$st->BindParam(3, $devices);
				$st->BindParam(4, $description);
				$st->BindParam(5, $storeqty);
				$st->BindParam(6, $restock);
				$st->BindParam(7, $transferqty);
				$st->BindParam(8, $stockvalue);
				$st->BindParam(9, $costprice);
				$st->BindParam(10, $cashprice);
				$st->BindParam(11, $totalqty);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $days);
				$st->BindParam(14, $currentuser);
				$st->BindParam(15, $currentusercode);
				$st->BindParam(16, $insuranceprice);
				$st->BindParam(17, $partnerprice);
				$st->BindParam(18, $dollarprice);
				// $st->BindParam(19, $days);
				// $st->BindParam(20, $totalqty);
				// $st->BindParam(21, $dollarprice);
				// $st->BindParam(22, $transferqty);
				$exe = $st->execute();
				if($exe){

				if($transferqty > '0'){

					$sqlstmt = "INSERT INTO octopus_pharmacy_stockadjustment(SA_CODE,SA_ADJUSTMENTCODE,SA_DATETIME,SA_MEDICATIONCODE,SA_MEDICATIONNUMBER,SA_MEDICATION,SA_ADDQTY,SA_NEWQTY,SA_OLDQTY,SA_TYPE,SA_SHIFT,SA_SHIFTCODE,SA_EXPIRY,SA_ACTOR,SA_ACTORCODE,SA_INSTCODE,SA_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $ajustcode);
					$st->BindParam(2, $adjustmentnumber);
					$st->BindParam(3, $days);
					$st->BindParam(4, $form_key);
					$st->BindParam(5, $devicenumber);
					$st->BindParam(6, $devices);
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
				$st->BindParam(5, $devicenumber);
				$st->BindParam(6, $devices);
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
				$st->BindParam(4, $devices);
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

				$sql = "UPDATE octopus_current SET CU_DEVICECODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $devicenumber);
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

	

	


	// 29 JULY 2022  JOSEPH ADORBOE
	public function disableimaging($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		$sql = "UPDATE octopus_st_radiology SET SC_STATUS = ?, SC_ACTOR =?, SC_ACTORCODE = ? WHERE SC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$exe = $st->execute();	
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$exe = $st->execute();	

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 JULY 2022  JOSEPH ADORBOE
	public function enableimaging($ekey,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$vt = '-1';
		$sql = "UPDATE octopus_st_radiology SET SC_STATUS = ?, SC_ACTOR =?, SC_ACTORCODE = ? WHERE SC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$exe = $st->execute();
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 JULY 2022  JOSEPH ADORBOE
	public function enablelabs($ekey,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$vt = '-1';
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_ACTOR =?, LTT_ACTORCODE = ? WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$exe = $st->execute();

		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?  WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $ekey);	
		$st->BindParam(3, $instcode);					
		$exe = $st->execute();
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 JULY 2022  JOSEPH ADORBOE
	public function disablelabs($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_ACTOR =?, LTT_ACTORCODE = ? WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$exe = $st->execute();	
		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $one);
		$exe = $st->execute();	

		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?  WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $ekey);	
		$st->BindParam(3, $instcode);					
		$exe = $st->execute();

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	

	// 29 MAY 2022  JOSEPH ADORBOE
	public function deleteimaging($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_radiology SET SC_STATUS = ? , SC_ACTOR = ? , SC_ACTORCODE = ? WHERE SC_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
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
		
	// 29 MAY 2022 JOSEPH ADORBOE
	public function editnewimaging($ekey,$imaging,$imagingnumber,$description,$partnercode,$mnum,$currentuser,$currentusercode,$instcode){	
		$one = 1;
		$sql = "UPDATE octopus_st_radiology SET SC_CODENUM = ?, SC_NAME = ?,  SC_DESC = ?, SC_ACTOR =? , SC_ACTORCODE = ? , SC_PARTNERCODE = ? WHERE SC_CODE = ? AND SC_INSTCODE = ?  AND SC_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $imagingnumber);
		$st->BindParam(2, $imaging);
		$st->BindParam(3, $description);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $partnercode);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $one);
		$exe = $st->execute();
		$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $imaging);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();							
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}			
	}	

	// 20 MAY 2022   JOSEPH ADORBOE
    public function addnewimaging($form_key,$imaging,$imagingnumber,$description,$partnercode,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT SC_ID FROM octopus_st_radiology Where (SC_NAME = ? OR SC_PARTNERCODE = ?) and  SC_INSTCODE = ?  and SC_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $imaging);
		$st->BindParam(2, $partnercode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_radiology(SC_CODE,SC_CODENUM,SC_NAME,SC_DESC,SC_ACTOR,SC_ACTORCODE,SC_INSTCODE,SC_PARTNERCODE) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $imagingnumber);
				$st->BindParam(3, $imaging);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$st->BindParam(8, $partnercode);
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

	// 14 APR 2022  JOSEPH ADORBOE
	public function deleteprices($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR = ?,  PS_ACTORCODE = ? WHERE PS_CODE = ? and PS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();							
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}


	// 10 MAR 2022,  JOSEPH ADORBOE
    public function checkpartnercode($partnercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest WHERE LTT_INSTCODE = ? AND LTT_PARTNERCODE = ? AND LTT_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $partnercode);
		$st->BindParam(3, $mt);
	//	$st->BindParam(4, $partnercode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				return '2';				
			}
		}else{
			return '0';
		}	
	}

	// 03 JUNE 2021 JOSEPH ADORBOE
	public function editnewsupplier($ekey,$supplier,$suppliernumber,$description,$mnum,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_suppliers SET SUPPLIER_CODENUM = ?, SUPPLIER_NAME = ?,  SUPPLIER_DESC = ?, SUPPLIER_ACTOR =? , SUPPLIER_ACTORCODE = ? WHERE SUPPLIER_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $suppliernumber);
		$st->BindParam(2, $supplier);
		$st->BindParam(3, $description);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_SUPPLIERCODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $suppliernumber);
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


	// 03 june 2021,  JOSEPH ADORBOE
    public function addnewsupplier($form_key,$supplier,$suppliernumber,$description,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT SUPPLIER_ID FROM octopus_st_suppliers where SUPPLIER_NAME = ? and  SUPPLIER_INSTCODE = ?  and SUPPLIER_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $supplier);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_suppliers(SUPPLIER_CODE,SUPPLIER_CODENUM,SUPPLIER_NAME,SUPPLIER_DESC,SUPPLIER_ACTOR,SUPPLIER_ACTORCODE,SUPPLIER_INSTCODE) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $suppliernumber);
				$st->BindParam(3, $supplier);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_SUPPLIERCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $suppliernumber);
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
			return '0';
		}	
	}

	
	// 15 MAY 2021 JOSEPH ADORBOE
	public function editnewprices($ekey,$price,$alternateprice,$otherprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode){

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
		
		
		if($exe){		
			return '2';							
		}else{								
			return '0';								
		}	
	}
	
	// 15 MAY 2021   JOSEPH ADORBOE
	// admin_singlepricing($form_key, $sercode, $sername, $paycode, $payname, $schemecode, $schemename, $price, $day, $category, $alternateprice, $otherprice, $dollarsprice,$currentusercode, $currentuser, $instcode)
    public function admin_singlepricing($form_key, $sercode, $sername, $paycode, $payname, $schemecode, $schemename, $price, $day, $category, $alternateprice, $otherprice, $dollarsprice,$currentusercode, $currentuser, $instcode){	
		$rt = 1;
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and  PS_PAYMENTMETHODCODE = ? and PS_PAYSCHEMECODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $sercode);
		$st->BindParam(2, $paycode);
		$st->BindParam(3, $schemecode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $rt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{		
		$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE,PS_ALTPRICE,PS_OTHERPRICE,PS_DOLLARPRICE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $category);
		$st->BindParam(3, $sercode);
		$st->BindParam(4, $sername);
		$st->BindParam(5, $price);
		$st->BindParam(6, $payname);
		$st->BindParam(7, $paycode);
		$st->BindParam(8, $schemecode);
		$st->BindParam(9, $schemename);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $instcode);
		$st->BindParam(13, $alternateprice);
		$st->BindParam(14, $otherprice);
		$st->BindParam(15, $dollarsprice);
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	
	}
	}

	// 14 APR 2022  JOSEPH ADORBOE
	public function deleteprocedure($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_procedures SET MP_STATUS = ? , MP_ACTOR = ? , MP_ACTORCODE = ? WHERE MP_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
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


	// 15 MAY 2021 JOSEPH ADORBOE
	public function editnewprocedure($ekey,$procedure,$procedurenumber,$description,$mnum,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_procedures SET MP_CODENUM = ?, MP_NAME = ?,  MP_DESC = ?, MP_ACTOR =? , MP_ACTORCODE = ? WHERE MP_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $procedurenumber);
		$st->BindParam(2, $procedure);
		$st->BindParam(3, $description);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_PROCEDURE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $procedurenumber);
				$st->BindParam(2, $instcode);						
				$exe = $st->execute();							
				if($exe){								
					return '2';								
				}else{								
					return '0';								
				}
			}
			$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $procedure);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();
			return '2';								
							
		}else{								
			return '0';								
		}	
	}

	// 14 MAY 2021,  JOSEPH ADORBOE
    public function addnewprocedure($form_key,$procedure,$procedurenumber,$description,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT MP_ID FROM octopus_st_procedures where MP_NAME = ? and  MP_INSTCODE = ?  and MP_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $procedure);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_procedures(MP_CODE,MP_CODENUM,MP_NAME,MP_DESC,MP_ACTOR,MP_ACTORCODE,MP_INSTCODE) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $procedurenumber);
				$st->BindParam(3, $procedure);
				$st->BindParam(4, $description);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $instcode);
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_PROCEDURE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $procedurenumber);
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
			return '0';
		}	
	}

	// 14 MAY 2021 JOSEPH ADORBOE
	public function editnewlabs($ekey,$labs,$labnumber,$discplinecode,$discplinename,$description,$mnum,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_labtest SET LTT_CODENUM = ?, LTT_NAME = ?,  LTT_DISCIPLINECODE = ?, LTT_DISCIPLINE =? , LTT_DESC = ? , LTT_ACTOR =?, LTT_ACTORCODE =? WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labnumber);
		$st->BindParam(2, $labs);
		$st->BindParam(3, $discplinecode);
		$st->BindParam(4, $discplinename);
		$st->BindParam(5, $description);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $currentusercode);
		$st->BindParam(8, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $labnumber);
				$st->BindParam(2, $instcode);						
				$exe = $st->execute();							
				// if($exe){								
				// 	return '2';								
				// }else{								
				// 	return '0';								
				// }
			}
			$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $labs);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();

			$sql = "UPDATE octopus_labplans_tests SET TRM_TEST = ?  WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $labs);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();

			return '2';								
							
		}else{								
			return '0';								
		}	
	}

	// // 12 MAR 2023 JOSEPH ADORBOE
	// public function enablelabs($ekey,$currentuser,$currentusercode,$instcode){
	// 	$zero = '0';
	// 	$one = 1;
	// 	$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?,  LTT_ACTOR =?, LTT_ACTORCODE =? WHERE LTT_CODE = ?  ";
	// 	$st = $this->db->prepare($sql);
	// 	$st->BindParam(1, $one);
	// 	$st->BindParam(2, $currentuser);
	// 	$st->BindParam(3, $currentusercode);
	// 	$st->BindParam(4, $ekey);		
	// 	$exe = $st->execute();
		
		

	// 	if($exe){	
	// 		return '2';								
	// 	}else{								
	// 		return '0';								
	// 	}	
			
	// }


	// 12 MAR 2023 JOSEPH ADORBOE
	public function disable($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?,  LTT_ACTOR =?, LTT_ACTORCODE =? WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);		
		$exe = $st->execute();
		
		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?  WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $ekey);	
		$st->BindParam(3, $instcode);					
		$exe = $st->execute();

		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
			
	}

	// 14 APR 2022 JOSEPH ADORBOE
	public function deletelabs($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?,  LTT_ACTOR =?, LTT_ACTORCODE =? WHERE LTT_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
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

	// 14 MAY 2021,  JOSEPH ADORBOE
    public function addnewlabs($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest WHERE LTT_NAME = ? AND  LTT_INSTCODE = ?  AND LTT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labs);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
	//	$st->BindParam(4, $partnercode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_CODENUM,LTT_NAME,LTT_DISCIPLINECODE,LTT_DISCIPLINE,LTT_DESC,LTT_ACTOR,LTT_ACTORCODE,LTT_INSTCODE,LTT_PARTNERCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $labsnumber);
				$st->BindParam(3, $labs);
				$st->BindParam(4, $discplinecode);
				$st->BindParam(5, $discplinename);
				$st->BindParam(6, $description);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $partnercode);
				
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_LABCODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $labsnumber);
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
			return '0';
		}	
	}

	// 13 MAY 2021 JOSEPH ADORBOE
	public function editnewdevice($ekey,$devices,$devicenumber,$description,$qty,$mnum,$currentuser,$currentusercode,$instcode){

		$sql = "UPDATE octopus_st_devices SET DEV_CODENUM = ?, DEV_DEVICE = ?,  DEV_DESC = ?, DEV_QTY =? , DEV_ACTOR =?, DEV_ACTORCODE =? WHERE DEV_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $devicenumber);
		$st->BindParam(2, $devices);
		$st->BindParam(3, $description);
		$st->BindParam(4, $qty);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $ekey);
		$exe = $st->execute();							
		if($exe){	
			if(empty($mnum)){
				$sql = "UPDATE octopus_current SET CU_DEVICECODE = ?  WHERE CU_INSTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $devicenumber);
				$st->BindParam(2, $instcode);						
				$exe = $st->execute();							
				// if($exe){								
				// 	return '2';								
				// }else{								
				// 	return '0';								
				// }
			}
			$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $devices);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();

			return '2';								
							
		}else{								
			return '0';								
		}	
	}


	// 14 APR 2021 JOSEPH ADORBOE
	public function deletedevice($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_devices SET DEV_STATUS = ?, DEV_ACTOR =?, DEV_ACTORCODE = ? WHERE DEV_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
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


	// 14 MAY 2021,  JOSEPH ADORBOE
    public function addnewdevice($form_key,$devices,$devicenumber,$description,$qty,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT DEV_ID FROM octopus_st_devices where DEV_DEVICE = ? and  DEV_INSTCODE = ?  and DEV_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $devices);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_devices(DEV_CODE,DEV_CODENUM,DEV_DEVICE,DEV_DESC,DEV_QTY,DEV_INSTCODE,DEV_ACTOR,DEV_ACTORCODE) 
				VALUES (?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $devicenumber);
				$st->BindParam(3, $devices);
				$st->BindParam(4, $description);
				$st->BindParam(5, $qty);
				$st->BindParam(6, $instcode);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);				
				$exe = $st->execute();
				if($exe){
					$sql = "UPDATE octopus_current SET CU_DEVICECODE = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $devicenumber);
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
			return '0';
		}	
	}

	// 14 APR 2022  JOSEPH ADORBOE
	public function deletemedication($ekey,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_medications SET MED_STATUS = ?, MED_ACTOR =?, MED_ACTORCODE = ? WHERE MED_CODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
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

	// 13 MAY 2021,  JOSEPH ADORBOE
    public function addnewmedication($form_key,$medication,$medicationnumber,$dosageformcode,$dosageformname,$untcode,$untname,$restock,$qty,$brandname,$medicationdose,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
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
				$sqlstmt = "INSERT INTO octopus_st_medications(MED_CODE,MED_CODENUM,MED_MEDICATION,MED_DOSAGECODE,MED_DOSAGE,MED_RESTOCK,MED_UNITCODE,MED_UNIT,MED_QTY,MED_ACTOR,MED_ACTORCODE,MED_INSTCODE,MED_BRANDNAME,MED_DOSE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $medicationnumber);
				$st->BindParam(3, $medication);
				$st->BindParam(4, $dosageformcode);
				$st->BindParam(5, $dosageformname);
				$st->BindParam(6, $restock);
				$st->BindParam(7, $untcode);
				$st->BindParam(8, $untname);
				$st->BindParam(9, $qty);
				$st->BindParam(10, $currentuser);
				$st->BindParam(11, $currentusercode);
				$st->BindParam(12, $instcode);
				$st->BindParam(13, $brandname);
				$st->BindParam(14, $medicationdose);
				$exe = $st->execute();
				if($exe){
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

	// 13 MAY 2021 JOSEPH ADORBOE 
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

	// 14 MAY 2021 JOSEPH ADORBOE 
	public function getlastdevicecodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_DEVICECODE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}
	
	// 14 MAY 2021 JOSEPH ADORBOE 
	public function getlastlabcodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_LABCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}

	// 14 MAY 2021 JOSEPH ADORBOE 
	public function getlastprocedurecodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_PROCEDURE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}

	// 03 JUNE 2021 JOSEPH ADORBOE 
	public function getlastsuppliercodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_SUPPLIERCODE'];
				$results = $value + 1;
				return $results;
			}else{
				return'-1';
			}

		}else{
			return '-1';
		}
			
	}

	// 03 JUNE 2021 JOSEPH ADORBOE 
	public function getlastsuppliescodenumber($instcode){
		$sqlstmt = ("SELECT * FROM octopus_current where CU_INSTCODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$value = $object['CU_SUPPLIESCODE'];
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