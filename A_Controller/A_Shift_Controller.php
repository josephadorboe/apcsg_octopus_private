<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 15 AUG 2025
	PURPOSE: shift controller  	
*/

class ShiftControllerClass Extends Engine{
	
	// 05 MAY 2021 JOSEPH ADORBOE
    public function automaticshiftday($day,$days,$currentdate,$currenttime,$currentshiftcode,$currentusercode,$currentuser,$instcode)
	{		
		// when shift is open 
		if ($currentshiftcode !== '0') {
			$currentdate = date('Y-m-d',strtotime($currentdate));			
			if ($currentdate == $day) {				
				return '0';
			} elseif ($currentdate !== $day) {	
				$nut = '0';
				$sql = "UPDATE octopus_shifts SET SHIFT_STATUS = ? WHERE SHIFT_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nut);
				$st->BindParam(2, $currentshiftcode);
				$ups = $st->Execute();
				if ($ups) {
					$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $nut);
					$st->BindParam(3, $currenttime);
					$st->BindParam(4, $instcode);
					$upsd = $st->Execute();
					if ($upsd) {
					
							$shifttype = 'MORNING';
					 		$shiftstart = '01';
							$shiftend = '24';
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());
							$shiftday = date('d M Y', strtotime($day));
							$shiftmonth = date('M Y', strtotime($day));
							$shiftyear = date('Y', strtotime($day));
							$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $day);
                            $st->BindParam(3, $shiftname);
                            $st->BindParam(4, $shifttype);
                            $st->BindParam(5, $currentusercode);
                            $st->BindParam(6, $currentuser);
                            $st->BindParam(7, $days);
                            $st->BindParam(8, $instcode);
                            $st->BindParam(9, $shiftstart);
                            $st->BindParam(10, $shiftend);
                            $exe = $st->execute();
							$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ? , CU_DAY = ? , CU_MONTH = ? , CU_YEAR = ?  WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $form_key);
							$st->BindParam(2, $shiftname);
							$st->BindParam(3, $shifttype);
							$st->BindParam(4, $days);
							$st->BindParam(5, $shiftstart);
							$st->BindParam(6, $shiftend);
							$st->BindParam(7, $currenttime);
							$st->BindParam(8, $shiftday);
							$st->BindParam(9, $shiftmonth);
							$st->BindParam(10, $shiftyear);
							$st->BindParam(11, $instcode);
							$ups = $st->Execute();

							$sql = "INSERT INTO octopus_st_archive(AR_DATE,AR_ITEMCODE,AR_ITEM,AR_TYPE,AR_SHELFQTY,AR_STOREQTY,AR_TRANSFER,AR_TOTALQTY,AR_CASHPRICE,AR_PARTNERPRICE,AR_INSURANCEPRICE,AR_ALTERPRICE,AR_DOLLARPRICE,AR_COSTPRICE,AR_STOCKVALUE,AR_LASTDATE,AR_ACTOR,AR_ACTORCODE,AR_INSTCODE)
							SELECT '$day',MED_CODE,MED_MEDICATION,'1',MED_QTY,MED_STOREQTY,MED_TRANSFER,MED_TOTALQTY,MED_CASHPRICE,MED_PARTNERPRICE,MED_INSURANCEPRICE,MED_ALTERPRICE,MED_DOLLARPRICE,MED_COSTPRICE,MED_STOCKVALUE,MED_LASTDATE,'$currentuser','$currentusercode','$instcode'
							FROM octopus_st_medications";
							$st = $this->db->prepare($sql);                            
							$exe = $st->execute();

							$sql = "INSERT INTO octopus_st_archive(AR_DATE,AR_ITEMCODE,AR_ITEM,AR_TYPE,AR_SHELFQTY,AR_STOREQTY,AR_TRANSFER,AR_TOTALQTY,AR_CASHPRICE,AR_PARTNERPRICE,AR_INSURANCEPRICE,AR_ALTERPRICE,AR_DOLLARPRICE,AR_COSTPRICE,AR_STOCKVALUE,AR_LASTDATE,AR_ACTOR,AR_ACTORCODE,AR_INSTCODE)
							SELECT '$day',DEV_CODE,DEV_DEVICE,'2',DEV_QTY,DEV_STOREQTY,DEV_TRANSFER,DEV_TOTALQTY,DEV_CASHPRICE,DEV_PARTNERPRICE,DEV_INSURANCEPRICE,DEV_OTHERPRICE,DEV_DOLLARPRICE,DEV_COSTPRICE,DEV_STOCKVALUE,DEV_LASTDATE,'$currentuser','$currentusercode','$instcode'
							FROM octopus_st_devices";
							$st = $this->db->prepare($sql);                            
							$exe = $st->execute();													
							
							if ($ups && $exe) {
								$sqlstmt = "DELETE FROM octopus_passvalues ";
							$st = $this->db->prepare($sqlstmt);                            
							$exed = $st->execute();

							$sqlstmtf = "DELETE FROM octopus_userformlogs ";
							$st = $this->db->prepare($sqlstmtf);                            
							$exef = $st->execute();	
								return '2';
							} else {
								return '0';
							}
						}else{
							return '0';
						}
					
				} else {
					return '0';
				}
					
			}

		// when shift is closed 	
		}else if($currentshiftcode == '0'){
			$currentdate = date('Y-m-d',strtotime($currentdate));
			
			if ($currentdate == $day) {				
				return '0';
			} elseif ($currentdate !== $day) {	
			
							$shifttype = 'MORNING';
					 		$shiftstart = '01';
							$shiftend = '24';
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());
							$shiftday = date('d M Y', strtotime($day));
							$shiftmonth = date('M Y', strtotime($day));
							$shiftyear = date('Y', strtotime($day));
							$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $day);
                            $st->BindParam(3, $shiftname);
                            $st->BindParam(4, $shifttype);
                            $st->BindParam(5, $currentusercode);
                            $st->BindParam(6, $currentuser);
                            $st->BindParam(7, $days);
                            $st->BindParam(8, $instcode);
                            $st->BindParam(9, $shiftstart);
                            $st->BindParam(10, $shiftend);
                            $exe = $st->execute();
							$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ? , CU_DAY = ? , CU_MONTH = ? , CU_YEAR = ?  WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $form_key);
							$st->BindParam(2, $shiftname);
							$st->BindParam(3, $shifttype);
							$st->BindParam(4, $days);
							$st->BindParam(5, $shiftstart);
							$st->BindParam(6, $shiftend);
							$st->BindParam(7, $currenttime);
							$st->BindParam(8, $shiftday);
							$st->BindParam(9, $shiftmonth);
							$st->BindParam(10, $shiftyear);
							$st->BindParam(11, $instcode);
							$ups = $st->Execute();

							$sql = "INSERT INTO octopus_st_archive(AR_DATE,AR_ITEMCODE,AR_ITEM,AR_TYPE,AR_SHELFQTY,AR_STOREQTY,AR_TRANSFER,AR_TOTALQTY,AR_CASHPRICE,AR_PARTNERPRICE,AR_INSURANCEPRICE,AR_ALTERPRICE,AR_DOLLARPRICE,AR_COSTPRICE,AR_STOCKVALUE,AR_LASTDATE,AR_ACTOR,AR_ACTORCODE,AR_INSTCODE)
							SELECT '$day',MED_CODE,MED_MEDICATION,'1',MED_QTY,MED_STOREQTY,MED_TRANSFER,MED_TOTALQTY,MED_CASHPRICE,MED_PARTNERPRICE,MED_INSURANCEPRICE,MED_ALTERPRICE,MED_DOLLARPRICE,MED_COSTPRICE,MED_STOCKVALUE,MED_LASTDATE,'$currentuser','$currentusercode','$instcode'
							FROM octopus_st_medications";
							$st = $this->db->prepare($sql);                            
							$exe = $st->execute();

							$sql = "INSERT INTO octopus_st_archive(AR_DATE,AR_ITEMCODE,AR_ITEM,AR_TYPE,AR_SHELFQTY,AR_STOREQTY,AR_TRANSFER,AR_TOTALQTY,AR_CASHPRICE,AR_PARTNERPRICE,AR_INSURANCEPRICE,AR_ALTERPRICE,AR_DOLLARPRICE,AR_COSTPRICE,AR_STOCKVALUE,AR_LASTDATE,AR_ACTOR,AR_ACTORCODE,AR_INSTCODE)
							SELECT '$day',DEV_CODE,DEV_DEVICE,'2',DEV_QTY,DEV_STOREQTY,DEV_TRANSFER,DEV_TOTALQTY,DEV_CASHPRICE,DEV_PARTNERPRICE,DEV_INSURANCEPRICE,DEV_OTHERPRICE,DEV_DOLLARPRICE,DEV_COSTPRICE,DEV_STOCKVALUE,DEV_LASTDATE,'$currentuser','$currentusercode','$instcode'
							FROM octopus_st_devices";
							$st = $this->db->prepare($sql);                            
							$exe = $st->execute();

							if ($ups && $exe) {
								$sqlstmt = "DELETE FROM octopus_passvalues ";
							$st = $this->db->prepare($sqlstmt);                            
							$exed = $st->execute();

							$sqlstmtf = "DELETE FROM octopus_userformlogs ";
							$st = $this->db->prepare($sqlstmtf);                            
							$exef = $st->execute();	
								return '2';
							} else {
								return '0';
							}
						}else{
							die;
							return '0';
						}
	
		}else{
			return '0';
		}
		
		
    }	
       

} 

	$shiftcontroller =  new ShiftControllerClass();
?>