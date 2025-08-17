<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 16 MAY 2024
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_patients_nurse_followup
	$patientnursefollowuptable->getfollowuprequestdetails($requestcode,$instcode)
*/

class OctopusPatientNurseFollowupSql Extends Engine{

	// 18 AUG 2024, JOSEPH ADORBOE 
	public function getfollowuprequestdetails($requestcode,$instcode){
		$stmt = "SELECT *  FROM octopus_patients_nurse_followup WHERE FU_CODE = ? AND FU_INSTCODE = ? ";
		$st = $this->db->prepare($stmt);
		$st->BindParam(1, $requestcode);
        // $st->BindParam(2, $patientcode);
        $st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$res = $obj['FU_REASON'].'@@'.$obj['FU_REQUESTDATE'].'@@'.$obj['FU_CODE'].'@@'.$obj['FU_NUMBER'].'@@'.$obj['FU_RESPONSE'].'@@'.$obj['FU_ACTORCODE'];
		}else{
			$res = '0';
		}
		return $res;
	}

	// 22 MAY 2024 JOSEPH ADORBOE
	public function getqueryfollowupfuture($instcode){
		$day = date('Y-m-d');
		$noteday = date('Y-m-d', strtotime($day. ' - 5 days'));		
		$list = ("SELECT * FROM octopus_patients_nurse_followup WHERE FU_INSTCODE = '$instcode' AND (FU_REQUESTDATE > '$day') AND FU_STATUS = '1' ORDER BY FU_ID DESC");
		return $list;
	}
	// 27 MAY 2024 JOSEPH ADORBOE 
	public function getnursefollowupscount($day,$instcode){
		$state = 4;
		$one = 1;
		$sqlstmt = ("SELECT FU_ID FROM octopus_patients_nurse_followup WHERE FU_REQUESTDATE = ? and  FU_INSTCODE = ? AND FU_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $day);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$details =	$st->execute();
		if($details){
			return $st->rowcount();		
		}else{
			return '0';
		}	
	}
	// 25 MAY 2024 , JOSEPH ADORBOE 
	public function getlistoffollowups($followupnumber,$instcode)
	{
		$sql = " SELECT * FROM octopus_patients_nurse_followup WHERE FU_NUMBER = '$followupnumber' and FU_INSTCODE = '$instcode' AND FU_STATUS = '2' ORDER BY FU_ID DESC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();	
		?>
				<div class="tab-pane" id="tab1">
					<div class="chat">
						<div class="contacts_card">																						
		<?php	while($obj = $st->fetch(PDO::FETCH_ASSOC)){ ?>
					<ul class="contacts mb-0">
						<li class="active">
							<div class="d-flex bd-highlight">								
								<div class="user_info">
									<h6 class="mt-1 mb-0 "><?php echo $obj['FU_REASON']; ?></h6><br />
									<h6 class="mt-1 mb-0 "><?php echo $obj['FU_RESPONSE']; ?></h6><br />
									<small class="text-muted"><?php echo date('d M Y', strtotime($obj['FU_RESPONSEDATE'])) ; ?> <br /> <?php echo $obj['FU_RESPONSEACTOR']; ?></small>									
								</div>								
							</div>
						</li>
						<br />
					</ul>
			<?php } ?>											
										</div>
									</div>
								</div>
		<?php // echo '<option value="'.$obj['SEV_SERVICECODE'].'@@@'.$obj['SEV_SERVICES'].'">'.$obj['SEV_SERVICES'].' </option>';			
	}
	// 27 AUG 2024 JOSEPH ADORBOE
	public function getquerypatientfollowup($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_nurse_followup WHERE FU_INSTCODE = '$instcode' AND FU_PATIENTCODE = '$idvalue' ORDER BY FU_ID DESC");
		return $list;
	}
	// 17 MAY 2024 JOSEPH ADORBOE
	public function getqueryfollowup($instcode){
		$day = date('Y-m-d');
		$noteday = date('Y-m-d', strtotime($day. ' - 5 days'));		
		$list = ("SELECT * FROM octopus_patients_nurse_followup WHERE FU_INSTCODE = '$instcode' AND !(FU_REQUESTDATE > '$day') AND FU_STATUS = '1' ORDER BY FU_ID DESC");
		return $list;
	}
	// 16 MAY 2024 JOSEPH ADORBOE
	public function getquerypatientnursefollowup($idvalue,$instcode){		
		$list = ("SELECT * FROM octopus_patients_nurse_followup WHERE FU_INSTCODE = '$instcode' AND FU_PATIENTCODE = '$idvalue' ORDER BY FU_ID DESC");
		return $list;
	}
	// 17 MAY 2024,  JOSEPH ADORBOE
    public function update_nursefollowupresponse($ekey,$day,$followupresponse,$state,$currentusercode,$currentuser,$instcode){
		$two = 2;
		$sqlstmt = "UPDATE octopus_patients_nurse_followup SET FU_RESPONSE = ?, FU_RESPONSEDATE = ? , FU_RESPONSEACTOR = ?, FU_RESPONSEACTORCODE = ?, FU_STATUS = ? WHERE FU_CODE = ? AND FU_INSTCODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $followupresponse);
		$st->BindParam(2, $day);
		$st->BindParam(3, $currentuser);
		$st->Bindparam(4, $currentusercode);
		$st->BindParam(5, $state);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 16 MAY 2024,  JOSEPH ADORBOE
    public function update_nursefollowup($ekey,$followupdate,$followup,$currentusercode,$currentuser,$instcode){
		$sqlstmt = "UPDATE octopus_patients_nurse_followup SET FU_REASON = ?, FU_REQUESTDATE = ? , FU_ACTOR = ?, FU_ACTORCODE = ? WHERE FU_CODE = ? AND FU_INSTCODE = ? ";
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $followup);
		$st->BindParam(2, $followupdate);
		$st->BindParam(3, $currentuser);
		$st->Bindparam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);
		$exe = $st->execute();
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}
	// 16 MAY 2024  JOSEPH ADORBOE
	public function insert_addnewfollowup($form_key,$followupnumber,$days,$followup,$followupdate,$patientcode,$patientnumber,$patient,$currentusercode,$currentuser,$instcode){				
		$sqlstmt = "INSERT INTO octopus_patients_nurse_followup(FU_CODE,FU_NUMBER,FU_DATE,FU_PATIENTCODE,FU_PATIENTNUMBER,FU_PATIENT,FU_REQUESTDATE,FU_REASON,FU_ACTOR,FU_ACTORCODE,FU_INSTCODE
		) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $followupnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $patientnumber);
		$st->BindParam(6, $patient);
		$st->BindParam(7, $followupdate);
		$st->BindParam(8, $followup);
		$st->BindParam(9, $currentuser);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $instcode);
		$exe = $st->execute();			
		if($exe){				
			return '2';
		}else{				
			return '0';				
		}	
	}	
}
	$patientnursefollowuptable =  new OctopusPatientNurseFollowupSql();
?>
