<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 FEB 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class LocumControllerClass Extends Engine{
	
	// 07 NOV 2021 JOSEPH ADORBOE
	public function proceslocumschedule($currentshiftcode,$currentshift,$currentshifttype,$currentdate,$days,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode){		
		
		$nt = 1; 
		$cdate = date('Y-m-d' , strtotime($currentdate));
		$sqlstmt = ("SELECT LOCUM_AMOUNT,LOCUM_TAX FROM octopus_setup_locum where LOCUM_USERCODE = ? and LOCUM_STATUS = ? and LOCUM_INSTCODE =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
		$extp = $st->execute();
		
		if($extp){
			
			if($st->rowcount() > 0){				
				$row = $st->fetch(PDO::FETCH_ASSOC);
				$locumamount = $row['LOCUM_AMOUNT'];
				$locumtax = $row['LOCUM_TAX'];
				$taxamount = ($locumamount*$locumtax)/100;
				$amountdue = $locumamount-$taxamount;
				$zero = '0';
				$sqlstmt = ("SELECT SC_STATUS FROM octopus_schedule_staff WHERE SC_STAFFCODE = ? AND SC_INSTCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $currentusercode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cdate);
				$st->BindParam(4, $currentshifttype);
				$extp = $st->execute();
				
                if ($extp) {
					
                     if($st->rowcount() > 0){                   
                    $row = $st->fetch(PDO::FETCH_ASSOC);
                    $state = $row['SC_STATUS'];
                    // not paid for the shift
					
                    if ($state == '1') {						
                        // insert into thhe locum bill for the user
						//die($state);
                        $sqlstmt = ("SELECT SALS_CODE FROM octopus_salary WHERE SALS_USERCODE = ? AND SALS_INSTCODE = ? AND SALS_STATUS = ? AND SALS_MONTH = ? ");
                        $st = $this->db->prepare($sqlstmt);
                        $st->BindParam(1, $currentusercode);
                        $st->BindParam(2, $instcode);
                        $st->BindParam(3, $nt);
                        $st->BindParam(4, $currentmonth);
                        $extp = $st->execute();
                        if ($extp) {
                            if ($st->rowcount() > 0) {
							//	die;
                                $row = $st->fetch(PDO::FETCH_ASSOC);
                                $monthsalarycode = $row['SALS_CODE'];
                                $salarycode = md5(microtime());
                               
                                $sql = " SELECT CU_SALARYTRANSACTIONNUM FROM octopus_current where CU_INSTCODE = ?";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $instcode);
                                $st->execute();
                                $obj = $st->fetch(PDO::FETCH_ASSOC);
                                $data = $obj['CU_SALARYTRANSACTIONNUM'];
                                $salarytransactionnum = $data + 1;
								$paysource = 'SHIFT';

                                $sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $salarycode);
                                $st->BindParam(2, $monthsalarycode);
                                $st->BindParam(3, $salarytransactionnum);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $currentuser);
                                $st->BindParam(6, $cdate);
                                $st->BindParam(7, $locumamount);
                                $st->BindParam(8, $amountdue);
                                $st->BindParam(9, $taxamount);
                                $st->BindParam(10, $locumtax);
                                $st->BindParam(11, $currentday);
                                $st->BindParam(12, $currentmonth);
                                $st->BindParam(13, $currentyear);
                                $st->BindParam(14, $currentusercode);
                                $st->BindParam(15, $currentuser);
                                $st->BindParam(16, $instcode);
								$st->BindParam(17, $paysource);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ?  WHERE CU_INSTCODE = ?  ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $salarytransactionnum);
                                    $st->BindParam(2, $instcode);
                                    $exe = $st->execute();
									$nut = 1;

                                    $sql = "UPDATE octopus_salary SET SALS_AMOUNTDUE =  SALS_AMOUNTDUE + ?, SALS_TOTALTAX = SALS_TOTALTAX + ? , SALS_SHIFTNUMS = SALS_SHIFTNUMS + ?  WHERE SALS_CODE = ? AND SALS_USERCODE = ? AND SALS_INSTCODE = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $amountdue);
                                    $st->BindParam(2, $taxamount);
                                    $st->BindParam(3, $nut);
                                    $st->BindParam(4, $monthsalarycode);
                                    $st->BindParam(5, $currentusercode);
									$st->BindParam(6, $instcode);
                                    $exe = $st->execute();

                                    $two = 2;
                                    $sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $currentshiftcode);
                                    $st->BindParam(2, $currentshift);
                                    $st->BindParam(3, $days);
                                    $st->BindParam(4, $currentuser);
                                    $st->BindParam(5, $currentusercode);
                                    $st->BindParam(6, $two);
                                    $st->BindParam(7, $currentusercode);
                                    $st->BindParam(8, $cdate);
                                    $st->BindParam(9, $currentshifttype);
                                    $st->BindParam(10, $instcode);
                                    $exe = $st->execute();
                                } else {
                                    return '0';
                                }
                            } else {
                                $monthsalarycode = md5(microtime());
                                $salarycode = md5(microtime());
								$paysource = 'SHIFT';
                               
                                $sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $instcode);
                                $st->execute();
                                $obj = $st->fetch(PDO::FETCH_ASSOC);
                                $data = $obj['CU_SALARYNUM'].'@@'.$obj['CU_SALARYTRANSACTIONNUM'];
                                $et = explode('@@', $data);
                                $snum = $et[0];
                                $tnum = $et[1];
                                $salarynum = $snum + 1;
                                $salarytransactionnum = $tnum + 1;
								$nut = 1;
								$zero = '0';

                                $sqlstmt = "INSERT INTO octopus_salary(SALS_CODE,SALS_SALARYNUM,SALS_USER,SALS_USERCODE,SALS_DATE,SALS_AMOUNTDUE,SALS_TOTALTAX,SALS_ACTOR,SALS_ACTORCODE,SALS_DAY,SALS_MONTH,SALS_YEAR,SALS_INSTCODE,SALS_SHIFTNUMS,SALS_PROCEDURESNUMS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $monthsalarycode);
                                $st->BindParam(2, $salarynum);
                                $st->BindParam(3, $currentuser);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $cdate);
                                $st->BindParam(6, $amountdue);
                                $st->BindParam(7, $taxamount);
                                $st->BindParam(8, $currentuser);
                                $st->BindParam(9, $currentusercode);
                                $st->BindParam(10, $currentday);
                                $st->BindParam(11, $currentmonth);
                                $st->BindParam(12, $currentyear);
                                $st->BindParam(13, $instcode);
								$st->BindParam(14, $nut);
								$st->BindParam(15, $zero);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                    $st = $this->db->prepare($sqlstmt);
                                    $st->BindParam(1, $salarycode);
                                    $st->BindParam(2, $monthsalarycode);
                                    $st->BindParam(3, $salarytransactionnum);
                                    $st->BindParam(4, $currentusercode);
                                    $st->BindParam(5, $currentuser);
                                    $st->BindParam(6, $cdate);
                                    $st->BindParam(7, $locumamount);
                                    $st->BindParam(8, $amountdue);
                                    $st->BindParam(9, $taxamount);
                                    $st->BindParam(10, $locumtax);
                                    $st->BindParam(11, $currentday);
                                    $st->BindParam(12, $currentmonth);
                                    $st->BindParam(13, $currentyear);
                                    $st->BindParam(14, $currentusercode);
                                    $st->BindParam(15, $currentuser);
                                    $st->BindParam(16, $instcode);
									$st->BindParam(17, $paysource);
									
                                    $exet = $st->execute();
                                    if ($exet) {
                                        $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ? ,CU_SALARYNUM = ?  WHERE CU_INSTCODE = ?  ";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $salarytransactionnum);
                                        $st->BindParam(2, $salarynum);
                                        $st->BindParam(3, $instcode);
                                        $exe = $st->execute();

                                        // $sql = "UPDATE octopus_salary SET SALS_AMOUNTDUE =  SALS_AMOUNTDUE + ?, SALS_TOTALTAX = SALS_TOTALTAX + ?  WHERE SALS_CODE = ? AND SALS_USERCODE = ? AND SALS_INSTCODE = ? ";
                                        // $st = $this->db->prepare($sql);
                                        // $st->BindParam(1, $amountdue);
                                        // $st->BindParam(2, $taxamount);
                                        // $st->BindParam(3, $monthsalarycode);
                                        // $st->BindParam(4, $currentusercode);
                                        // $st->BindParam(5, $instcode);
                                        // $exe = $st->execute();

                                        $two = 2;
                                        $sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $currentshiftcode);
                                        $st->BindParam(2, $currentshift);
                                        $st->BindParam(3, $days);
                                        $st->BindParam(4, $currentuser);
                                        $st->BindParam(5, $currentusercode);
                                        $st->BindParam(6, $two);
                                        $st->BindParam(7, $currentusercode);
                                        $st->BindParam(8, $cdate);
                                        $st->BindParam(9, $currentshifttype);
                                        $st->BindParam(10, $instcode);
                                        $exe = $st->execute();
                                    } else {
                                        return '0';
                                    }
                                } else {
                                    return '0';
                                }
                            }
                        }
                    } elseif ($state == 2) {
                        return '20';
                    } else {
                        return '30';
                    }
                }else{
					return '40';
				}

				}else{
					return '0';
				}

				
			}else{

				$sqlstmt = ("SELECT SC_STATUS FROM octopus_schedule_staff WHERE SC_STAFFCODE = ? AND SC_INSTCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $currentusercode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cdate);
				$st->BindParam(4, $currentshifttype);
				$extp = $st->execute();
                if ($extp) {
					if ($st->rowcount() > 0) {
					$row = $st->fetch(PDO::FETCH_ASSOC);
					$state = $row['SC_STATUS'];
					// not paid for the shift
                    if ($state == 1) {

						$two = 2;
						$sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $currentshiftcode);
						$st->BindParam(2, $currentshift);
						$st->BindParam(3, $days);
						$st->BindParam(4, $currentuser);	
						$st->BindParam(5, $currentusercode);	
						$st->BindParam(6, $two);
						$st->BindParam(7, $currentusercode);
						$st->BindParam(8, $cdate);
						$st->BindParam(9, $currentshifttype);
						$st->BindParam(10, $instcode);
						$exe = $st->execute();

                    }else if($state == 2){
						return '20';
					}else{
						return '30';
					}

                }else{
					return '0';
				}

			}else{
				return '0';
			}
			//	return '10';				
			}
		}else{
			return '0';
		}

	}

	// 05 NOV 2021 JOSEPH ADORBOE 
	public function editlocum($ekey,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentusercode,$currentuser,$instcode){		
		$rt = 1;		
		$sql = "UPDATE octopus_setup_locum SET LOCUM_START = ? , LOCUM_END = ? , LOCUM_AMOUNT = ? , LOCUM_ACTOR = ? , LOCUM_ACTORCODE = ? , LOCUM_TAX = ? , LOCUM_SHARE = ? , LOCUM_FACILITYSHARE = ? WHERE LOCUM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $startdate);
		$st->BindParam(2, $enddate);
		$st->BindParam(3, $amount);
		$st->BindParam(4, $currentuser);	
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $taxprecentage);
		$st->BindParam(7, $procedureshareamount);
		$st->BindParam(8, $facilityshare);
		$st->BindParam(9, $ekey);	
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 05 NOV 2021 JOSEPH ADORBOE
	public function addnewlocum($form_key,$personelcode,$personelname,$locumnumber,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentuser,$currentusercode,$instcode){	
		$bt = 1;
		$sqlstmt = ("SELECT LOCUM_ID FROM octopus_setup_locum WHERE LOCUM_USERCODE = ? AND LOCUM_INSTCODE =? AND LOCUM_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $personelcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$sqlstmt = "INSERT INTO octopus_setup_locum(LOCUM_CODE,LOCUM_NUMBER,LOCUM_USER,LOCUM_USERCODE,LOCUM_START,LOCUM_END,LOCUM_AMOUNT,LOCUM_INSTCODE,LOCUM_ACTOR,LOCUM_ACTORCODE,LOCUM_TAX,LOCUM_SHARE,LOCUM_FACILITYSHARE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $locumnumber);
				$st->BindParam(3, $personelname);
				$st->BindParam(4, $personelcode);
				$st->BindParam(5, $startdate);
				$st->BindParam(6, $enddate);
				$st->BindParam(7, $amount);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $taxprecentage);
				$st->BindParam(12, $procedureshareamount);
				$st->BindParam(13, $facilityshare);
				$exe = $st->execute();	
				if($exe){									
					$sql = "UPDATE octopus_current SET CU_LOCUM = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $locumnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();
					if ($exe) {
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


	
} 

	$locumcontroller =  new LocumControllerClass()
?>