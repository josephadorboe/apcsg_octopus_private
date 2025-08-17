<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_consultations
	$patientconsultationstable->deleteconsultationrequestcode($ekey,$instcode);
	 = new OctopusPatientsConsultationsSql();
*/

class OctopusPatientsConsultationsSql Extends Engine{

	// 1 JUNE 2024, JOSEPH ADORBOE 
	public function editpatientsbio($patientcode,$visitcode,$name,$age,$gender,$instcode){		
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_PATIENT = ? , CON_AGE = ? , CON_GENDER = ?  WHERE CON_VISITCODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $name);
		$st->BindParam(2, $age);
		$st->BindParam(3, $gender);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
				
		$sql = "UPDATE octopus_patients_consultations SET  CON_PATIENT = ? , CON_AGE = ? , CON_GENDER = ?  WHERE CON_VISITCODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $name);
		$st->BindParam(2, $age);
		$st->BindParam(3, $gender);
		$st->BindParam(4, $visitcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}							
	}
	// 15 AUG 2023, JOSEPH ADORBOE
	public function selectconsultationlist($currentusercode,$instcode){
		$list = ("SELECT * from octopus_patients_consultations  where CON_STATUS IN('1','2') and CON_DOCTORCODE = '$currentusercode' and CON_INSTCODE = '$instcode' order by CON_ID ASC LIMIT 50 ");										
		return $list;
	}	
	
	// 1 Oct 2023, 17 MAR 2021 JOSEPH ADORBOE 
	public function getpatientconsultationdetails($idvalue){
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations where CON_CODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['CON_CODE'].'@'.$object['CON_REQUESTCODE'].'@'.$object['CON_VISITCODE'].'@'.$object['CON_DATE'].'@'.$object['CON_PATIENTCODE'].'@'.$object['CON_PATIENTNUMBER'].'@'.$object['CON_PATIENT'].'@'.$object['CON_AGE'].'@'.$object['CON_GENDER'].'@'.$object['CON_SERIAL'].'@'.$object['CON_PAYMENTMETHOD'].'@'.$object['CON_PAYMENTMETHODCODE'].'@'.$object['CON_PAYSCHEMECODE'].'@'.$object['CON_PAYSCHEME'].' : '.$object['CON_PLAN'].'@'.$object['CON_SERVICECODE'].'@'.$object['CON_SERVICE'].'@'.$object['CON_STATUS'].'@'.$object['CON_STAGE'].'@'.$object['CON_PAYMENTTYPE'].'@'.$object['CON_CONSULTATIONNUMBER'].'@'.$object['CON_PLAN'];
				return $results;
			}else{
				return'1';
			}

		}else{
			return '0';
		}
			
	}	

	// 23 oct 2023, 19 NOV 2022 JOSEPH ADORBOE 
	public function reassignpatients($days,$physicancode,$physicaname,$consultationcode,$patientcode,$instcode){		
		$sql = "UPDATE octopus_patients_consultations_archive SET  CON_DOCTOR = ? , CON_DOCTORCODE = ? , CON_DATE = ?  WHERE CON_CODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $physicaname);
		$st->BindParam(2, $physicancode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
				
		$sql = "UPDATE octopus_patients_consultations SET  CON_DOCTOR = ? , CON_DOCTORCODE = ? , CON_DATE = ?  WHERE CON_CODE = ? AND  CON_PATIENTCODE = ? AND CON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);		
		$st->BindParam(1, $physicaname);
		$st->BindParam(2, $physicancode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $consultationcode);
		$st->BindParam(5, $patientcode);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}							
	}

	// 5 oct 2023,  JOSEPH ADORBOE
    public function updateconsultationstage($column,$consultationcode){		
		$ut = '0';
		$nut = 1;
		$sql = "UPDATE octopus_patients_consultations SET $column = ?  WHERE CON_CODE = ? and $column = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $consultationcode);
		$st->BindParam(3, $ut);						
		$exe = $st->execute();
		$sql = "UPDATE octopus_patients_consultations_archive SET $column = ?  WHERE CON_CODE = ? and $column = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $consultationcode);
		$st->BindParam(3, $ut);						
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}			
	}
	// 3 oct 2023,  JOSEPH ADORBOE
    public function updatepatientcomplains($consultationcode){		
		$ut = '0';
		$nut = 1;
		$sql = "UPDATE octopus_patients_consultations SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $consultationcode);
		$st->BindParam(3, $ut);						
		$exe = $st->execute();
		$sql = "UPDATE octopus_patients_consultations_archive SET CON_COMPLAINT = ?  WHERE CON_CODE = ? and CON_COMPLAINT = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $consultationcode);
		$st->BindParam(3, $ut);						
		$exe = $st->execute();							
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}			
	}

	// 1 Oct 2023, 14 JUNE 2022  JOSEPH ADORBOE 
	public function getdoctorpastedconsulationstatus($currentusercode,$day,$instcode){
		$one  = 1 ; 
		$sqlstmt = ("SELECT * FROM octopus_patients_consultations WHERE DATE(CON_DATE) != ? AND CON_COMPLETE = ? AND CON_DOCTORCODE = ? AND CON_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $day);
		$st->BindParam(2, $one);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){			
				return '2';
			}else{
				return'1';
			}
		}else{
			return '1';
		}			
	}	

	// 18 SEPT 2023,  JOSEPH ADORBOE
    public function updateconsulationsdoctor($ekey,$specsname,$specscode,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_consultations SET CON_DOCTOR = ?, CON_DOCTORCODE = ?, CON_ACTORCODE = ? , CON_ACTOR = ?  where CON_REQUESTCODE = ? AND CON_INSTCODE = ?";
			$st = $this->db->Prepare($sqlstmt);
			$st->BindParam(1, $specsname);
			$st->BindParam(2, $specscode);
			$st->BindParam(3, $currentusercode);
			$st->Bindparam(4, $currentuser);
			$st->BindParam(5, $ekey);
			$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 18 SEPT 2023
	public function insertconsultations($ekey,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$specscode,$specsname,$days,$serialnumber,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$paymentmethod,$paymentmethodcode,$patientschemecode,$patientscheme,$patientservicecode,$patientservice,$paymenttype,$consultationnumber,$currentday,$currentmonth,$currentyear,$plan){
		$one = 1;
		$consultationcode = md5(microtime());	
			$sqlstmt = "INSERT INTO octopus_patients_consultations(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $consultationcode);
					$st->BindParam(2, $visitcode);
					$st->BindParam(3, $days);
					$st->BindParam(4, $patientcode);
					$st->BindParam(5, $patientnumber);
					$st->BindParam(6, $patient);
					$st->BindParam(7, $age);
					$st->BindParam(8, $gender);
					$st->BindParam(9, $serialnumber);
					$st->BindParam(10, $specsname);
					$st->BindParam(11, $specscode);
					$st->BindParam(12, $paymentmethod);
					$st->BindParam(13, $paymentmethodcode);
					$st->BindParam(14, $patientschemecode);
					$st->BindParam(15, $patientscheme);
					$st->BindParam(16, $patientservicecode);
					$st->BindParam(17, $patientservice);
					$st->BindParam(18, $currentuser);
					$st->BindParam(19, $currentusercode);
					$st->BindParam(20, $instcode);
					$st->BindParam(21, $currentshiftcode);
					$st->BindParam(22, $currentshift);
					$st->BindParam(23, $ekey);
					$st->BindParam(24, $paymenttype);
					$st->BindParam(25, $consultationnumber);
					$st->BindParam(26, $currentday);
					$st->BindParam(27, $currentmonth);
					$st->BindParam(28, $currentyear);
					$st->BindParam(29, $plan);
					$exe = $st->execute();
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}					
	}

	// 4 SEPT 2023
	public function newconsultations($newconsultationcode,$servicerequestcode,$patientcode,$patientnumber,$patient,$gender,$age,$visitcode,$days,$servicecode,$servicesed,$schemecode,$scheme,$paymentmethodcode,$paymentmethod,$consultationnumber,$consultationpaymenttype,$remarks,$physicians,$physiciancode,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$currentday,$currentmonth,$currentyear) : Int{
		$one = 1;
			$sqlstmt = "INSERT INTO octopus_patients_consultations(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $newconsultationcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $days);
			$st->BindParam(4, $patientcode);
			$st->BindParam(5, $patientnumber);
			$st->BindParam(6, $patient);
			$st->BindParam(7, $age);
			$st->BindParam(8, $gender);
			$st->BindParam(9, $one);
			$st->BindParam(10, $physicians);
			$st->BindParam(11, $physiciancode);
			$st->BindParam(12, $paymentmethod);
			$st->BindParam(13, $paymentmethodcode);
			$st->BindParam(14, $schemecode);
			$st->BindParam(15, $scheme);
			$st->BindParam(16, $servicecode);
			$st->BindParam(17, $servicesed);
			$st->BindParam(18, $currentuser);
			$st->BindParam(19, $currentusercode);
			$st->BindParam(20, $instcode);
			$st->BindParam(21, $currentshiftcode);
			$st->BindParam(22, $currentshift);
			$st->BindParam(23, $servicerequestcode);
			$st->BindParam(24, $consultationpaymenttype);
			$st->BindParam(25, $consultationnumber);
			$st->BindParam(26, $currentday);
			$st->BindParam(27, $currentmonth);
			$st->BindParam(28, $currentyear);
			$st->BindParam(29, $remarks);
			$exe = $st->execute();

			$sqlstmt = "INSERT INTO octopus_patients_consultations_archive(CON_CODE,CON_VISITCODE,CON_DATE,CON_PATIENTCODE,CON_PATIENTNUMBER,CON_PATIENT,CON_AGE,CON_GENDER,CON_SERIAL,CON_DOCTOR,CON_DOCTORCODE,CON_PAYMENTMETHOD,CON_PAYMENTMETHODCODE,CON_PAYSCHEMECODE,CON_PAYSCHEME,CON_SERVICECODE,CON_SERVICE,CON_ACTOR,CON_ACTORCODE,CON_INSTCODE,CON_SHIFTCODE,CON_SHIFT,CON_REQUESTCODE,CON_PAYMENTTYPE,CON_CONSULTATIONNUMBER,CON_DAY,CON_MONTH,CON_YEAR,CON_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $newconsultationcode);
			$st->BindParam(2, $visitcode);
			$st->BindParam(3, $days);
			$st->BindParam(4, $patientcode);
			$st->BindParam(5, $patientnumber);
			$st->BindParam(6, $patient);
			$st->BindParam(7, $age);
			$st->BindParam(8, $gender);
			$st->BindParam(9, $one);
			$st->BindParam(10, $physicians);
			$st->BindParam(11, $physiciancode);
			$st->BindParam(12, $paymentmethod);
			$st->BindParam(13, $paymentmethodcode);
			$st->BindParam(14, $schemecode);
			$st->BindParam(15, $scheme);
			$st->BindParam(16, $servicecode);
			$st->BindParam(17, $servicesed);
			$st->BindParam(18, $currentuser);
			$st->BindParam(19, $currentusercode);
			$st->BindParam(20, $instcode);
			$st->BindParam(21, $currentshiftcode);
			$st->BindParam(22, $currentshift);
			$st->BindParam(23, $servicerequestcode);
			$st->BindParam(24, $consultationpaymenttype);
			$st->BindParam(25, $consultationnumber);
			$st->BindParam(26, $currentday);
			$st->BindParam(27, $currentmonth);
			$st->BindParam(28, $currentyear);
			$st->BindParam(29, $remarks);
			$exe = $st->execute();
			if($exe){								
				return 2;								
			}else{								
				return $this->thefailed;								
			}
	}

	// 27 JULY 2024,  JOSEPH ADORBOE
    public function deleteconsultationrequestcode($ekey,$instcode){
		$sqlstmt = "DELETE FROM octopus_patients_consultations WHERE CON_REQUESTCODE = ? AND CON_INSTCODE = ?"	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $ekey);	
		$st->BindParam(2, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}
	}	

	// 3 SEPT 2023,  JOSEPH ADORBOE
	public function deleteconsultation($consultationcode,$instcode){
		$sqlstmt = "DELETE FROM octopus_patients_consultations WHERE CON_CODE = ? AND CON_INSTCODE = ?"	;
		$st = $this->db->prepare($sqlstmt);	
		$st->BindParam(1, $consultationcode);	
		$st->BindParam(2, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	
	// 3 SEPT 2023,  JOSEPH ADORBOE
    public function updatepatientnumberconsulations($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_consultations SET CON_PATIENTNUMBER = ?, CON_ACTOR = ?, CON_ACTORCODE =?  where CON_PATIENTCODE = ? and CON_INSTCODE = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $replacepatientnumber);
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

	// 2 AUG 2024 JOSEPH ADORBOE 
	public function pendingtodayconsultation($currentusercode,$instcode){
		$day = date("Y-m-d");
		$list = ("SELECT * from octopus_patients_consultations  WHERE CON_STATUS IN('1') AND CON_DOCTORCODE = '$currentusercode' AND CON_INSTCODE = '$instcode' AND DATE(CON_DATE) = '$day' LIMIT 10  ");
		return $list;
	}
	
} 

$patientconsultationstable = new OctopusPatientsConsultationsSql();
 
	// 2 AUG 2024 JOSEPH ADORBOE 
	function widgetpendingconsultationqueuetoday($pendingcount,$currentusercode,$instcode,$dbconn,$patientconsultationstable){ ?>
	<div class="card">
			<div class="card-header ">
				<h3 class="card-title ">Pending Consultation Queue Today</h3>
				<div class="card-options">
					<a href="patientconsultationgp" class="btn btn-secondary btn-sm">More </a>							
				</div>
			</div>
			<div class="card-body" style="min-height: 350px; max-height: 350px; font-size: 14px; overflow: scroll;">
			<div class="table-responsive">
				<?php // if($pendingcount<'1'){ ?>
				<table class="table card-table table-striped table-vcenter table-outline table-bordered text-nowrap ">
					<thead>
						<tr>
							<th scope="col" class="border-top-0">No.</th>							
							<th>Patient Details</th>
							<!-- <th>Patient No.</th>
							<th>Service</th>	 -->
						</tr>
					</thead>
					<tbody>
						<?php 								
							$nu = 0;
							$mypatientgpconsultationlist = $patientconsultationstable->pendingtodayconsultation($currentusercode,$instcode);
							$getmypatientgpconsultationlist = $dbconn->query($mypatientgpconsultationlist);
							while ($row = $getmypatientgpconsultationlist->fetch(PDO::FETCH_ASSOC)){						                   
						?>		
							<tr > 
								<td><?php echo ++$nu; ?></td>											
								<td><a href="consultationdetails?<?php echo $row['CON_CODE'] ?>"><?php echo $row['CON_CONSULTATIONNUMBER'] ; ?> - <?php echo $row['CON_PATIENTNUMBER'] ; ?> - <?php echo $row['CON_PATIENT']?><br /> 
								<?php echo $row['CON_PAYSCHEME'] ; ?> - <?php echo $row['CON_SERVICE'] ; ?> <br />
								By : <?php echo $row['CON_ACTOR'] ; ?> 
								</td>
							</tr>
					<?php  }  ?>
				</tbody>
				</table>
				<?php //} ?>
				</div>
			</div>
		</div>

	<?php  }

?>