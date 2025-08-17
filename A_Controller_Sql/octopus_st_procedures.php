<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 29 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_st_procedures
	$proceduresetuptable->getpatientsprocedurelov($instcode);
*/

class OctopusProceduresSql Extends Engine{

	//26 MAR 2021
	public function getpatientsprocedurelov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm' and MP_SPEC IS NULL and MP_INSTCODE = '$instcode' order by MP_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= 0>-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['MP_CODE'].'@@@'.$obj['MP_NAME'].'">'.$obj['MP_NAME'].' </option>';

            }
	}

	//28 NOV 2023 JOSEPH ADORBOE
    public function newprocedure($form_key,$procedure,$procedurenumber,$description,$cashprice,$alternateprice,$insuranceprice,$dollarprice,$partnerprice,$currentuser,$currentusercode,$instcode){	
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
					return '2';								
				}else{								
					return '0';								
				}			
			}
		}else{
			return '0';
		}	
	}


	// 28 NOV 2023, JOSEPH ADORBOE
	public function procedurechangeprice($ekey,$cashprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_procedures SET MP_CASHPRICE =?, MP_ALTERNATEPRICE =? , MP_INSURANCEPRICE =?, MP_DOLLARPRICE =?, MP_PARTNERPRICE =? WHERE MP_CODE = ? AND MP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $cashprice);
		$st->BindParam(2, $alternateprice);
		$st->BindParam(3, $insuranceprice);
		$st->BindParam(4, $dollarprice);
		$st->BindParam(5, $partnerprice);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getqueryprocedures($instcode){		
		$list = ("SELECT * from octopus_st_procedures WHERE MP_INSTCODE = '$instcode' order by MP_NAME ");
		return $list;
	}

	// 28 NOV 2023, JOSEPH ADORBOE 
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

	// 14 oct 2023,  JOSEPH ADORBOE
    public function insert_newprocedure($form_key,$procedure,$description,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$num = date('his');
		$sqlstmt = ("SELECT MP_ID FROM octopus_st_procedures where MP_NAME = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $procedure);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_st_procedures(MP_CODE,MP_NAME,MP_DESC,MP_ACTORCODE,MP_ACTOR,MP_CODENUM,MP_INSTCODE) 
				VALUES (?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $procedure);
				$st->BindParam(3, $description);
				$st->BindParam(4, $currentusercode);
				$st->BindParam(5, $currentuser);
				$st->BindParam(6, $num);
				$st->BindParam(7, $instcode);				
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
	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	public function enableprocedures($ekey,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$one = 1;
		$reason = 'ENABLE';
		$sql = "UPDATE octopus_st_procedures SET MP_REASON = ?,  MP_REASONDATE = ?, MP_REASONACTOR =?, MP_REASONACTORCODE =? , MP_STATUS =? WHERE MP_CODE = ? AND MP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $reason);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $one);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}
	// 28 Sept 2023, 13 MAY 2021 JOSEPH ADORBOE
	public function disableprocedure($ekey,$disablereason,$days,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$sql = "UPDATE octopus_st_procedures SET MP_REASON = ?,  MP_REASONDATE = ?, MP_REASONACTOR =?, MP_REASONACTORCODE =? , MP_STATUS =? WHERE MP_CODE = ? AND MP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $disablereason);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $zero);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();							
		if($exe){			
			return '2';								
		}else{								
			return '0';								
		}	
	}

	// 29 Sept 2023,  15 MAY 2021 JOSEPH ADORBOE
	public function editprocedure($ekey,$procedure,$procedurenumber,$description,$currentuser,$currentusercode,$instcode){
		$sql = "UPDATE octopus_st_procedures SET MP_CODENUM = ?, MP_NAME = ?,  MP_DESC = ?, MP_ACTOR =? , MP_ACTORCODE = ? WHERE MP_CODE = ? AND MP_INSTCODE  = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $procedurenumber);
		$st->BindParam(2, $procedure);
		$st->BindParam(3, $description);
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

	// 29 SEPT 2023, 14 MAY 2021,  JOSEPH ADORBOE
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
					return '2';								
				}else{								
					return '0';								
				}			
			}
		}else{
			return '0';
		}	
	}

	
} 
$proceduresetuptable = new OctopusProceduresSql();
?>