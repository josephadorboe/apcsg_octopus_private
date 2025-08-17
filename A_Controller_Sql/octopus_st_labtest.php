<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_labtest
	$labtesttable->getlabslist($instcode)
	updatelabsprices($ekey,$cashprice,$alternateprice,$insuranceprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode);
*/

class OctopusLabtestsSql Extends Engine{
	// 1 AUG 2024,JOSEPH ADORBOE
	public function getlabslist($instcode){		
		$list = ("SELECT * from octopus_st_labtest where  LTT_INSTCODE = '$instcode' and LTT_STATUS ='1' order by LTT_NAME DESC limit 100 ");
		return $list;
	}
	// 31 July 2024, Joseph adorboe 
	public function getlabslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT LTT_CODE,LTT_NAME,LTT_PARTNERCODE FROM octopus_st_labtest where LTT_STATUS = '$mnm' and LTT_INSTCODE = '$instcode' order by LTT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
	//	echo '<option value= 0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LTT_CODE'].'@@@'.$obj['LTT_NAME'].'@@@'.$obj['LTT_PARTNERCODE'].'">'.$obj['LTT_NAME'].' </option>';
		}
	}

	// 26 SEPT 2023 JOSEPH ADORBOE
	public function getquerylabtestforplan($instcode){		
		$list = ("SELECT * from octopus_st_labtest WHERE LTT_INSTCODE = '$instcode' and LTT_STATUS ='1' order by LTT_NAME Limit 150");
		return $list;
	}
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerylabtest($instcode){		
		$list = ("SELECT * from octopus_st_labtest WHERE LTT_INSTCODE = '$instcode' order by LTT_NAME ");
		return $list;
	}

	// 28 NOV 2023, 28 Dec 2022 JOSEPH ADORBOE 
	public function labsdetails($idvalue,$instcode){	
		$one = 1;
		$sql = "SELECT * FROM octopus_st_labtest WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$exe = $st->Execute();
		if($st->rowcount() > 0){			
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$ordernum = $obj['LTT_CODE'].'@@'.$obj['LTT_CODENUM'].'@@'.$obj['LTT_NAME'].'@@'.$obj['LTT_DESC'].'@@'.$obj['LTT_CASHPRICE'].'@@'.$obj['LTT_ALTERNATEPRICE'].'@@'.$obj['LTT_INSURANCEPRICE'].'@@'.$obj['LTT_DOLLARPRICE'].'@@'.$obj['LTT_PARTNERPRICE'] ;				
		}else{			
			$ordernum = '0';			
		}
		return 	$ordernum; 	
		
	}
	// 29 NOV 2023, 
	public function updatelabsprices($ekey,$cashprice,$alternateprice,$insuranceprice,$partnerprice,$dollarprice,$currentuser,$currentusercode,$instcode){
		
		$sql = "UPDATE octopus_st_labtest SET LTT_CASHPRICE = ?, LTT_ALTERNATEPRICE =?, LTT_INSURANCEPRICE = ?, LTT_DOLLARPRICE =?, LTT_PARTNERPRICE = ?, LTT_ACTORCODE = ?, LTT_ACTOR = ?   WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $cashprice);
		$st->BindParam(2, $alternateprice);
		$st->BindParam(3, $insuranceprice);
		$st->BindParam(4, $dollarprice);
		$st->BindParam(5, $partnerprice);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}


	// 29 NOV 2023, 
	public function updatelabs($ekey,$labs,$labsnum,$description,$partnercode,$currentuser,$currentusercode,$instcode){
		
		$sql = "UPDATE octopus_st_labtest SET LTT_NAME = ?, LTT_PARTNERCODE =?, LTT_DESC = ?, LTT_ACTORCODE =?, LTT_ACTOR = ?, LTT_CODENUM = ?  WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labs);
		$st->BindParam(2, $partnercode);
		$st->BindParam(3, $description);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $labsnum);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);
		$exe = $st->execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 NOV 2023  JOSEPH ADORBOE
    public function addnewlabs($form_key,$labs,$labsnumber,$description,$partnercode,$cashprice,$alternateprice,$dollarprice,$partnerprice,$insuranceprice,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest WHERE LTT_NAME = ? AND  LTT_INSTCODE = ?  AND LTT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labs);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_labtest(LTT_CODE,LTT_CODENUM,LTT_NAME,LTT_CASHPRICE,LTT_ALTERNATEPRICE,LTT_DESC,LTT_ACTOR,LTT_ACTORCODE,LTT_INSTCODE,LTT_PARTNERCODE,LTT_INSURANCEPRICE,LTT_DOLLARPRICE,LTT_PARTNERPRICE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $labsnumber);
				$st->BindParam(3, $labs);
				$st->BindParam(4, $cashprice);
				$st->BindParam(5, $alternateprice);
				$st->BindParam(6, $description);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $partnercode);	
				$st->BindParam(11, $insuranceprice);	
				$st->BindParam(12, $dollarprice);	
				$st->BindParam(13, $partnerprice);				
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
	// 23 Sept 2023, 
	public function enablelabstest($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$one = 1;
		$reason = '';
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_REASONACTOR =?, LTT_REASONACTORCODE = ?, LTT_REASON =?, LTT_REASONDATE =? WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $reason);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 23 Sept 2023, 
	public function disablelabstest($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$sql = "UPDATE octopus_st_labtest SET LTT_STATUS = ?, LTT_REASONACTOR =?, LTT_REASONACTORCODE = ?, LTT_REASON =?, LTT_REASONDATE =?  WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $disablereason);
		$st->BindParam(5, $days);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();	
		if($exe){	
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 23 sept 2023, 14 MAY 2021 JOSEPH ADORBOE
	public function editlabs($ekey,$labs,$labnumber,$discplinecode,$discplinename,$description,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_st_labtest SET LTT_CODENUM = ?, LTT_NAME = ?,  LTT_DISCIPLINECODE = ?, LTT_DISCIPLINE =? , LTT_DESC = ? , LTT_ACTOR =?, LTT_ACTORCODE =? WHERE LTT_CODE = ? AND LTT_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $labnumber);
		$st->BindParam(2, $labs);
		$st->BindParam(3, $discplinecode);
		$st->BindParam(4, $discplinename);
		$st->BindParam(5, $description);
		$st->BindParam(6, $currentuser);
		$st->BindParam(7, $currentusercode);
		$st->BindParam(8, $ekey);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';							
		}else{								
			return '0';								
		}	
	}

	// 24 Sept 2023,  14 MAY 2021,  JOSEPH ADORBOE
    public function addnew($form_key,$labs,$labsnumber,$discplinecode,$discplinename,$description,$partnercode,$currentuser,$currentusercode,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT LTT_ID FROM octopus_st_labtest WHERE LTT_NAME = ? AND  LTT_INSTCODE = ?  AND LTT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $labs);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
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
						return '2';								
					}else{								
						return '0';								
					}	
				
			}
		}else{
			return '0';
		}	
	}
	// 24 sept 2023, 10 MAR 2022,  JOSEPH ADORBOE
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

	
} 
$labtesttable = new OctopusLabtestsSql();
?>