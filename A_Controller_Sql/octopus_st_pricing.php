<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 27 AUG 20
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_st_pricing
	$pricingtable->getcashprice($servicescode,$instcode,$cashschemecode);
*/

class OctopusStPricingSql Extends Engine{

	// 15 JULY 2021 JOSEPH ADORBOE 
	public function getcashprice($servicescode,$instcode,$cashschemecode) : mixed{
		//	die($instcodenuc);
			// $rat =  1;
			// if($instcode == $instcodenuc){
			// 	if($ptype == 'XP'){
			// 		$sql = 'SELECT PS_ALTPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
			// 		$st = $this->db->Prepare($sql);
			// 		$st->BindParam(1, $cashschemecode);
			// 		$st->BindParam(2, $servicescode);
			// 		$st->BindParam(3, $instcode);
			// 		$st->BindParam(4, $rat);
			// 		$exrt = $st->execute();
			// 		if ($exrt) {
			// 			if ($st->rowcount() > $this->thefailed) {
			// 				$obj = $st->Fetch(PDO::FETCH_ASSOC);
			// 				$price = $obj['PS_ALTPRICE'];
			// 				return $price ;
			// 			} else {
			// 				return '-1';
			// 			}
			// 		} else {
			// 			return $this->thefailed;
			// 		}
	
			// 	}else{
			// 		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
			// 		$st = $this->db->Prepare($sql);
			// 		$st->BindParam(1, $cashschemecode);
			// 		$st->BindParam(2, $servicescode);
			// 		$st->BindParam(3, $instcode);
			// 		$st->BindParam(4, $rat);
			// 		$exrt = $st->execute();
			// 		if ($exrt) {
			// 			if ($st->rowcount() > $this->thefailed) {
			// 				$obj = $st->Fetch(PDO::FETCH_ASSOC);
			// 				$price = $obj['PS_PRICE'];
			// 				return $price ;
			// 			} else {
			// 				return '-1';
			// 			}
			// 		} else {
			// 			return $this->thefailed;
			// 		}
			// 	}
	
			// }else{
				
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrt = $st->execute();
				if ($exrt) {
					if ($st->rowcount() > $this->thefailed) {
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];
						return $price ;
					} else {
						return '-1';
					}
				} else {
					return $this->thefailed;
				}
			//}
		}
	// 30 MAY 2025, JOSEPH ADORBOE 
	public function querygetradiologypricesearch($instcode,$selectedone,$selectedtwo){
		if($selectedone == 'ALL'){
			$list = ("SELECT PS_CODE,PS_ITEMNAME,PS_PAYMENTMETHOD,PS_PAYSCHEME,PS_PRICE,PS_ALTPRICE,PS_OTHERPRICE,PS_STATUS,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_DOLLARPRICE FROM octopus_st_pricing WHERE PS_STATUS = '1' AND PS_INSTCODE = '$instcode' AND PS_CATEGORY = '7' AND PS_PAYMENTMETHODCODE = '$selectedtwo' ");
		}else{
			$list = ("SELECT PS_CODE,PS_ITEMNAME,PS_PAYMENTMETHOD,PS_PAYSCHEME,PS_PRICE,PS_ALTPRICE,PS_OTHERPRICE,PS_STATUS,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_DOLLARPRICE FROM octopus_st_pricing WHERE PS_STATUS = '1' AND PS_INSTCODE = '$instcode' AND PS_CATEGORY = '7' AND PS_ITEMCODE = '$selectedone' AND PS_PAYMENTMETHODCODE = '$selectedtwo' ");
		}
		return $list;
	}

	// 23 JUNE 2$this->thefailed21 JOSEPH ADORBOE 
	public function partnercompaniesprices($servicescode, $paymentmethodcode, $paymentschemecode, $partnercompaniescode,$cashpaymentmethodcode,$instcode)  {
		
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > $this->thefailed){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYMENTMETHODCODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $paymentmethodcode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrted = $st->execute();
                if ($exrted) {
					if($st->rowcount() > $this->thefailed){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];			
						return $price ; 			
					}else{
                        $sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYMENTMETHODCODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
                        $st = $this->db->Prepare($sql);
                        $st->BindParam(1, $cashpaymentmethodcode);
                        $st->BindParam(2, $servicescode);
                        $st->BindParam(3, $instcode);
						$st->BindParam(4, $this->theone);
                        $exrted = $st->execute();
                        if ($exrted) {
                            if ($st->rowcount() > $this->thefailed) {
                                $obj = $st->Fetch(PDO::FETCH_ASSOC);
                                $price = $obj['PS_PRICE'];
                                return $price ;
                            } else {
                                return '-1';
                            }
                        }
                    }

                }else{
					return $this->thefailed;
				}
            }

        }else{
			return $this->thefailed;
		}

	}
	// 22 JUNE 2$this->thefailed21 JOSEPH ADORBOE 
	public function privateinsuranceprices($servicescode,$paymentschemecode,$instcode) : mixed{		
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > $this->thefailed){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				return '-1';
            }
        }else{
			return $this->thefailed;
		}
	}


	// 26 NOV 2$this->thefailed24,  JOSEPH ADORBOE
	public function revrse_setprice($itemcode,$instcode) : int {		
		$sqlstmt = "DELETE * FROM octopus_st_pricing  where PS_ITEMCODE = ? and  PS_INSTCODE = ?  and PSSTATUS = ? ";		
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $this->theone);		
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}
	// $this->thefailed6 NOV 2$this->thefailed22 JOSEPH ADORBOE 
	public function privateinsuranceforeignprices($servicescode,$paymentschemecode,$exchangerate,$instcode) : mixed {
		
		$sql = 'SELECT PS_DOLLARPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > $this->thefailed){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_DOLLARPRICE']*$exchangerate;			
				return $price ; 			
			}else{
				return '-1';
            }

        }else{
			return $this->thefailed;
		}

	}

	// 9 NOV 2$this->thefailed23 JOSEPH ADORBOE
	public function getquerysingleitempricelist($category,$idvalue,$instcode) : String {
		$list = ("SELECT * FROM octopus_st_pricing WHERE PS_INSTCODE = '$instcode' AND PS_CATEGORY = '$category' AND PS_ITEMCODE = '$idvalue' ");
		return $list;
	}

	// // 9 NOV 2$this->thefailed23 JOSEPH ADORBOE
	// public function getquerycategorypricelist($category,$instcode){
	// 	$list = ("SELECT * FROM octopus_st_pricing WHERE PS_INSTCODE = '$instcode' AND PS_CATEGORY = '$category' AND PS_ITEMCODE = '$idvalue' ");
	// 	return $list;
	// }

	// 1$this->thefailed NOV 2$this->thefailed23 JOSEPH ADORBOE
	public function editnewprices($ekey,$price,$alternateprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode) : int {
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
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}

	// 9 NOV 2$this->thefailed23, 24 DEC 2$this->thefailed22,  JOSEPH ADORBOE
    public function setinsurancepartnerprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$partnerprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser) : int {
		
		$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ?  AND PS_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $schemecode);
		$st->BindParam(4, $this->theone);
		$exe = $st->Execute();
		if($st->rowcount() > $this->thefailed){
			$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_ALTPRICE =?, PS_DOLLARPRICE = ?, PS_ACTORCODE =? ,PS_ACTOR = ?,PS_OTHERPRICE = ? WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ?  AND PS_STATUS = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $insuranceprice);
			$st->BindParam(2, $alternateprice);
			$st->BindParam(3, $dollarprice);
			$st->BindParam(4, $currentusercode);
			$st->BindParam(5, $currentuser);
			$st->BindParam(6, $partnerprice);
			$st->BindParam(7, $schemecode);
			$st->BindParam(8, $itemcode);
			$st->BindParam(9, $instcode);
			$st->BindParam(10, $this->theone);
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
			$st->BindParam(14, $partnerprice);
			$st->BindParam(15, $dollarprice);
			$exe = $st->execute();
		}
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}

	}

	// 9 NOV 2$this->thefailed23, 24 DEC 2$this->thefailed22,  JOSEPH ADORBOE
    public function setcashprices($itemcode,$item,$newprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode) : int {
		$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $cashschemecode);
		$exe = $st->Execute();
		if($st->rowcount() > $this->thefailed){
		//	return $this->theexisted;
			
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
			$st->BindParam(10, $this->thetwo);
			$exe = $st->execute();
			if($exe){
				return $this->thepassed;
			}else{
				return $this->thefailed;
			}

		}else{
		//	return '3';
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
			$st->BindParam(14, $partnerprice);
			$st->BindParam(15, $dollarprice);
			$exe = $st->execute();
			if($exe){
				return $this->thepassed;
			}else{
				return $this->thefailed;
			}
		}
	}
	// 9 NOV 2$this->thefailed23, 24 DEC 2$this->thefailed22,  JOSEPH ADORBOE
    public function updateinsuranceprices($cashpaymentmethodcode,$itemcode,$insuranceprice,$dollarprice,$instcode, $currentusercode, $currentuser) : int {
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
		$st->BindParam(10, $this->theone);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}

	}
	// 9 NOV 2023, 24 DEC 2022,  JOSEPH ADORBOE
    public function setinsuranceprices($pricecode,$category,$itemcode,$itemname,$schemecode, $schemename, $insurancecode, $insurancename,$insuranceprice,$alternateprice,$dollarprice,$instcode, $days, $currentusercode, $currentuser) : int{
		$sql = "SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_PAYSCHEMECODE = ?  AND PS_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $schemecode);
		$st->BindParam(4, $this->theone);
		$exe = $st->Execute();
		if($st->rowcount() > $this->thefailed){
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
			$st->BindParam(9, $this->theone);
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
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}

	}
	// 29 JULY 2$this->thefailed23 ,  JOSEPH ADORBOE
    public function getservicecover( String $itemcode, String $schemecode, String $cashschemecode, String $instcode) : Int {
		
		if($schemecode == $cashschemecode){
			return $this->theexisted;
		}else{
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and  PS_PAYSCHEMECODE = ? and  PS_STATUS = ? AND PS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $schemecode);
		$st->BindParam(3, $this->theone);
		$st->BindParam(4, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > $this->thefailed){
				return $this->theexisted;
			}else{
				return $this->thefailed;
			}
		}else{
			return $this->thefailed;
		}
	}
	}
	// 23 Sept 2023, 29 JULY 2022  JOSEPH ADORBOE
	public function enablepriceing( String $ekey, String $currentuser, String $currentusercode, String $instcode) : Int {
		$vt = '-1';
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_CODE = ? AND PS_STATUS = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $vt);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}

	// 28 NOV 2$this->thefailed23  JOSEPH ADORBOE
	public function enableitempriceing( String $itemcode, String $currentuser, String $currentusercode, String $instcode) : int{
		$vt = '-1';
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $this->theone);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $vt);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}

	// 28 NOV 2$this->thefailed23  JOSEPH ADORBOE
	public function disableitempriceing( String $itemcode, String $currentuser, String $currentusercode, String $instcode) : int{	
		$vt = '-1';		
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_ITEMCODE = ? AND PS_STATUS = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $this->theone);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}

	// 23 Sept 2$this->thefailed23, 29 JULY 2$this->thefailed22  JOSEPH ADORBOE
	public function disablepriceing( String $ekey, String $currentuser, String $currentusercode, String $instcode) : int{
		$vt = '-1';
		$sql = "UPDATE octopus_st_pricing SET PS_STATUS = ?, PS_ACTOR =?, PS_ACTORCODE = ? WHERE PS_CODE = ? AND PS_STATUS = ? AND PS_INSTCODE = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $vt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $this->theone);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){
			return $this->thepassed;
		}else{
			return $this->thefailed;
		}
	}
	// 23 sept 2$this->thefailed23, 14 MAY 2$this->thefailed21 JOSEPH ADORBOE
	public function updatepricesitems( String $ekey, String $itemname, String $instcode) : mixed{
			$sql = "UPDATE octopus_st_pricing SET PS_ITEMNAME = ?  WHERE PS_ITEMCODE = ? AND PS_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $itemname);
			$st->BindParam(2, $ekey);
			$st->BindParam(3, $instcode);
			$exe = $st->execute();
			if($exe){
				return $this->thepassed;
			}else{
				return $this->thefailed;
			}
	}
	public function getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc) : mixed {
		if($instcode == $instcodenuc){
			if($ptype == 'XP'){
			//	if($ptype == 'XP' && $paymentschemecode == $cashschemecode){
				$sql = 'SELECT PS_ALTPRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > $this->thefailed){
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_ALTPRICE'];
						return $price ;
					}else{
						return '-1';
					}
				}else{
					return '-2';
				}
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $paymentschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrt = $st->execute();
				if($exrt){
					if($st->rowcount() > $this->thefailed){
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];
						return $price ;
					}else{
						$sql = 'SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
						$st = $this->db->Prepare($sql);
						$st->BindParam(1, $cashschemecode);
						$st->BindParam(2, $servicescode);
						$st->BindParam(3, $instcode);
						$st->BindParam(4, $this->theone);
						$exrted = $st->execute();
						if($exrted){
							if($st->rowcount() > $this->thefailed){
								$obj = $st->Fetch(PDO::FETCH_ASSOC);
								$price = $obj['PS_PRICE'];
								return $price ;
							}else{
								return '-1';
							}
						}else{
							return '-2';
						}
					}
				}else{
					return '-1';
				}
			}

		}else{

		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ? ';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$exrt = $st->execute();
		if($exrt){
			if($st->rowcount() > $this->thefailed){
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];
				return $price ;
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > $this->thefailed){
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];
						return $price ;
					}else{
						return '-1';

					}
				}else{
					return '-2';
				}
			}
		}else{
			return '-1';
		}
	}
	}
	// 27 AUG 2$this->thefailed23, 12 JULY 2$this->thefailed21 JOSEPH ADORBOE
	public function gettheprice($itemcode,$instcode,$paymentschemecode,$cashschemecode) : mixed {
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $itemcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $this->theone);
		$exrt = $st->execute();
		if($exrt){
			if($st->rowcount() > $this->thefailed){
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];
				return $price ;
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $itemcode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $this->theone);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > $this->thefailed){
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];
						return $price ;
					}else{
						return '-1';
					}
				}else{
					return '-1';
				}
			}
		}else{
			return '-1';
		}
	}


}
$pricingtable = new OctopusStPricingSql();
?>
