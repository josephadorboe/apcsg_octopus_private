<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 24 SEPT 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_labplans_tests
	$labplantesttable = new OctopusLabPlanstestSql();
	
*/

class OctopusLabPlanstestSql Extends Engine{
	// 7 oct 2023 JOSEPH ADORBOE
	public function getquerylabs($treatmentplancode,$instcode){		
		$list = ("SELECT * from octopus_labplans_tests where TRM_PLANCODE = '$treatmentplancode' and TRM_INSTCODE = '$instcode' and TRM_STATUS = '1' order by TRM_TEST ASC");
		return $list;
	}
	// 24 SEPT 2023 JOSEPH ADORBOE
	public function getquerylabplantest($plancode,$instcode){		
		$list = ("SELECT * FROM octopus_labplans_tests WHERE TRM_INSTCODE = '$instcode' and TRM_STATUS = '1' AND TRM_PLANCODE = '$plancode'  order by TRM_TEST DESC ");
		return $list;
	}
	// 26 Sept 2023, 22 NOV 2021 JOSEPH ADORBOE 
	public function update_removelabsfromplans($ekey,$currentusercode,$currentuser,$instcode){
		$tty = '0';
		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR = ? , TRM_ACTORCODE = ? WHERE TRM_CODE = ? AND TRM_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $tty);
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
	// 26 Sept 2023, 22 NOV 2021,  JOSEPH ADORBOE
    public function insert_labstoplan($form_key,$plancode,$plan,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_labplans_tests where TRM_TESTCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? AND TRM_STATUS = '1'");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $lapcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $plancode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans_tests(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_TESTCODE,TRM_TESTNUM,TRM_TEST,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_TESTCODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $plancode);
				$st->BindParam(3, $plan);
				$st->BindParam(4, $lapcode);
				$st->BindParam(5, $lapnum);
				$st->BindParam(6, $lapname);
				$st->BindParam(7, $days);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $lapcodenum);
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
    public function insert_labsplanlist($form_key,$lapplancode,$labsplans,$lapcode,$lapnum,$lapname,$days,$lapcodenum,$currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$sqlstmt = ("SELECT TRM_ID FROM octopus_labplans_tests where TRM_TESTCODE = ? and  TRM_INSTCODE = ? and  TRM_PLANCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $lapcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $lapplancode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				$sqlstmt = "INSERT INTO octopus_labplans_tests(TRM_CODE,TRM_PLANCODE,TRM_PLAN,TRM_TESTCODE,TRM_TESTNUM,TRM_TEST,TRM_DATE,TRM_ACTOR,TRM_ACTORCODE,TRM_INSTCODE,TRM_TESTCODENUM) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $lapplancode);
				$st->BindParam(3, $labsplans);
				$st->BindParam(4, $lapcode);
				$st->BindParam(5, $lapnum);
				$st->BindParam(6, $lapname);
				$st->BindParam(7, $days);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $lapcodenum);
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

	// 23 sept 2023, 14 MAY 2021 JOSEPH ADORBOE
	public function editlabsplanstest($ekey,$labs,$instcode){
			$sql = "UPDATE octopus_labplans_tests SET TRM_TEST = ?  WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $labs);
			$st->BindParam(2, $ekey);	
			$st->BindParam(3, $instcode);					
			$exe = $st->execute();
			if($exe){			
				return '2';							
			}else{								
				return '0';								
			}	
	}

	// 23 Sept 2023, 29 JULY 2022  JOSEPH ADORBOE
	public function disablelabplanstest($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR = ?, TRM_ACTORCODE = ?   WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
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

	// 23 Sept 2023, 29 JULY 2022  JOSEPH ADORBOE
	public function enablelabplanstest($ekey,$currentuser,$currentusercode,$instcode){
		$zero = 0;
		$vt = '-1';
		$one = 1;
		$sql = "UPDATE octopus_labplans_tests SET TRM_STATUS = ?, TRM_ACTOR = ?, TRM_ACTORCODE = ?   WHERE TRM_TESTCODE = ? AND TRM_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
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

	
} 
$labplantesttable = new OctopusLabPlanstestSql();
?>