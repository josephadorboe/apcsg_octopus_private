<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 25 AUG 2023 
	PURPOSE: TO OPERATE MYSQL QUERY 	
	Base : 	octopus_patients_review
	$patientreviewtable->querygetphysioreviewlist($patientcode,$physioservices,$instcode);
	 = new OctopusPatientsReviewSql();
*/

class OctopusPatientsReviewSql Extends Engine{
	// 6 APR 2025
	public function querygetphysioreviewlist($patientcode,$physioservices,$instcode){
		$list = "SELECT REV_REQUESTCODE,REV_DATE,REV_SERVICE,REV_NOTES,REV_ACTOR from octopus_patients_review where REV_INSTCODE = '$instcode' and REV_PATIENTCODE = '$patientcode' and REV_STATUS != '0' 
		AND REV_SERVICECODE IN('$physioservices') ";
		return $list;
	}
	// 8 JUNE 2024 JOSEPH ADORBOE
	public function getqueryreviewtodaycompleteddashboard($day,$instcode){		
		$list = ("SELECT * from octopus_patients_review where REV_STATUS = '2' and REV_INSTCODE = '$instcode' and REV_DATE = '$day' order by REV_REQUESTCODE ASC LIMIT 4 ");
		return $list;
	}
	// 8 JUNE 2024 JOSEPH ADORBOE
	public function getqueryreviewpastdashboard($day,$instcode){		
		$list = ("SELECT * from octopus_patients_review where REV_STATUS = '1' and REV_INSTCODE = '$instcode' and REV_DATE < '$day' order by REV_REQUESTCODE ASC LIMIT 4 ");
		return $list;
	}
	// 8 JUNE 2024 JOSEPH ADORBOE
	public function getqueryreviewtodaydashboard($day,$instcode){		
		$list = ("SELECT * from octopus_patients_review where REV_STATUS = '1' and REV_INSTCODE = '$instcode' and REV_DATE = '$day' order by REV_REQUESTCODE ASC LIMIT 4 ");
		return $list;
	}
	// 08 AUG 2023 
	public function selectpendingreviews($instcode,$thearchivedate){
		$appointmentslotlist = ("SELECT * FROM octopus_patients_review WHERE REV_STATUS = '1' AND REV_INSTCODE = '$instcode' AND REV_DATE > '$thearchivedate' ORDER BY REV_DATE ASC");
		return 	$appointmentslotlist;		
	}

	public function getquerypending($patientcode,$consultationvisitoutcomedate,$instcode){		
		$list = ("SELECT * FROM octopus_patients_review WHERE REV_PATIENTCODE = '$patientcode' and REV_INSTCODE = '$instcode' and REV_DATE > '$consultationvisitoutcomedate' order by REV_ID DESC  ");
		return $list;
	}
	public function getquerypatientreviewlist($patientcode,$instcode){		
		$list = ("SELECT * FROM octopus_patients_review WHERE REV_PATIENTCODE = '$patientcode' and REV_INSTCODE = '$instcode' order by REV_ID DESC  ");
		return $list;
	}
	// 18 SEPT 2023 JOSEPH ADORBOE
	public function getqueryreviewtoday($day,$instcode){		
		$list = ("SELECT * from octopus_patients_review where REV_STATUS = '1' and REV_INSTCODE = '$instcode' and REV_DATE = '$day' order by REV_REQUESTCODE DESC ");
		return $list;
	}
	// 4 AUG 2023 09 JULY 2021 JOSEPH ADORBOE 
	public function cancelreviewbooked($ekey,$cancelreason,$currentusercode,$currentuser,$instcode){		
		$rt = '0';
		$nul = '';
		$sname  = "Review Service Cancelled";
		$sql = "UPDATE octopus_patients_review SET REV_STATUS = ?, REV_ACTOR = ? ,  REV_ACTORCODE = ?, REV_CANCEL = ?  WHERE REV_CODE = ? AND REV_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $rt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $cancelreason);
		$st->BindParam(5, $ekey);
		$st->BindParam(6, $instcode);		
		$exe = $st->execute();	
				
		if($exe){			
			return '2';
		}else{			
			return '0';			
		}
	}
	// 4 AUG 2023 09 JULY 2021 JOSEPH ADORBOE 
	public function editreviewbooking($ekey,$reviewremark,$reviewdate,$secode,$sename,$currentusercode,$currentuser,$instcode){		
		$rt = '0';		
		$sql = "UPDATE octopus_patients_review SET REV_DATE = ?, REV_ACTOR = ? ,  REV_ACTORCODE = ? , REV_NOTES = ?, REV_SERVICE = ?, REV_SERVICECODE = ?  WHERE REV_CODE = ? AND REV_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $reviewdate);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $reviewremark);	
		$st->BindParam(5, $sename);
		$st->BindParam(6, $secode);
		$st->BindParam(7, $ekey);
		$st->BindParam(8, $instcode);	
		$exe = $st->execute();					
		if($exe){			
			return '2';
		}else{			
			return '0';			
		}		
	}

	// 25 oct 2023  JOSEPH ADORBOE
	public function newreviewbookingonly($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$reviewremark,$secode,$sename,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode){	
		$one = 1;
	
				$sqlstmt = "INSERT INTO octopus_patients_review(REV_CODE,REV_REQUESTCODE,REV_DATE,REV_PATIENTCODE,REV_PATIENTNUM,REV_NOTES,REV_ACTOR,REV_ACTORCODE,REV_INSTCODE,REV_PATIENT,REV_SERVICE,REV_SERVICECODE,REV_DAY,REV_MONTH,REV_YEAR) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $requestcodecode);
				$st->BindParam(3, $reviewdate);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $reviewremark);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $patient);
				$st->BindParam(11, $sename);
				$st->BindParam(12, $secode);
				$st->BindParam(13, $currentday);
				$st->BindParam(14, $currentmonth);
				$st->BindParam(15, $currentyear);
				$exe = $st->execute();	
					if($exe){								
						return '2';								
					}else{								
						return '0';								
					}				
		
	}
	// 03 AUG 2023  09 JULY 2021   JOSEPH ADORBOE
	public function newreviewbooking($form_key,$requestcodecode,$patientcode,$patient,$patientnumber,$reviewdate,$reviewremark,$secode,$sename,$currentusercode,$currentuser,$currentday,$currentmonth,$currentyear,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT REV_ID FROM octopus_patients_review where REV_PATIENTCODE = ? and REV_SERVICECODE = ? and REV_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $secode);
		$st->BindParam(3, $one);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$sqlstmt = "INSERT INTO octopus_patients_review(REV_CODE,REV_REQUESTCODE,REV_DATE,REV_PATIENTCODE,REV_PATIENTNUM,REV_NOTES,REV_ACTOR,REV_ACTORCODE,REV_INSTCODE,REV_PATIENT,REV_SERVICE,REV_SERVICECODE,REV_DAY,REV_MONTH,REV_YEAR) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $requestcodecode);
				$st->BindParam(3, $reviewdate);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $patientnumber);
				$st->BindParam(6, $reviewremark);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$st->BindParam(10, $patient);
				$st->BindParam(11, $sename);
				$st->BindParam(12, $secode);
				$st->BindParam(13, $currentday);
				$st->BindParam(14, $currentmonth);
				$st->BindParam(15, $currentyear);
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
	// 6 AUG 2023 JOSEPH ADORBOE 
	public function getnewreviewfollowupscount($day,$instcode){
		$state = 4;
		$one = 1;
		$sqlstmt = ("SELECT REV_ID FROM octopus_patients_review WHERE REV_DATE = ? and  REV_INSTCODE = ? AND REV_STATUS = ? ");
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
	// 4 AUG 2023 , 10 MAR 2022 
	public function archivepastedreview($thereviewday,$instcode){
		$zero = '0';
		$one  = 1;
		$sql = "UPDATE octopus_patients_review SET REV_STATUS = ? WHERE REV_DATE < ? and REV_INSTCODE = ? and REV_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $thereviewday);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);			
		$exe = $st->execute();
		if($exe){								
			return '2';								
		}else{								
			return '0';								
		}	
	}	
	// 4 AUG 2023 09 JULY 2021 JOSEPH ADORBOE 
	public function updatepatientsreview($patientcode,$day,$currentusercode,$currentuser,$instcode,$patienttable){		
		$two = 2;
		$one = 1;
							
		$sql = "UPDATE octopus_patients_review SET REV_STATUS = ?, REV_ACTOR = ? ,  REV_ACTORCODE = ?  WHERE REV_PATIENTCODE = ? and REV_INSTCODE = ? and REV_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $patientcode);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $one);			
		$exe = $st->execute();	
		$patienttable->updatepatientreviewperformedservices($day,$patientcode,$instcode);			
		if($exe){			
			return '2';
		}else{			
			return '0';			
		}
	}
	// 8 AUG 2023, 15 JULY 2021 JOSEPH ADORBOE 
	public function checkreviewservice($servicescode, $patientcode,$thereviewday, $instcode){
		// checkreviewservice($servicescode, $patientcode, $day, $reveiwlist,$thereviewday, $instcode)
	// checkreviewservice($servicescode,$patientcode,$day,$consultationreview,$xraylabreview,$consultationothopedicreview,$consultationrheumatologytopup,$consultationrheumatologyfollowuptopup,$consultationinternalmedicinetopup,$consultationinternalmedicinefollowuptopup,$consultationorthopedicspecilisttopup,$consultationorthopedicspecilistfollouptopup,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,	$physiofullbodymassage,$physioreflexology,$physioultrasoundfollowup,$physioultrasoundonly,$dieticanconsultationsreview,$thereviewday,$instcode){
		$sate = 1;
		// if ($servicescode == $consultationreview || $servicescode == $xraylabreview || $servicescode == $consultationothopedicreview || $servicescode == $consultationrheumatologytopup || $servicescode == $consultationrheumatologyfollowuptopup || $servicescode == $consultationinternalmedicinetopup || $servicescode == $consultationinternalmedicinefollowuptopup || $servicescode == $consultationorthopedicspecilisttopup || $servicescode == $consultationorthopedicspecilistfollouptopup || $servicescode == $physiofollowup || $servicescode == $physioreflexology || $servicescode == $physioultrasoundfollowup || $servicescode == $physioultrasoundonly || $servicescode == $dieticanconsultationsreview) {
			$sqlstmt = "SELECT * FROM octopus_patients_review WHERE REV_PATIENTCODE = ? AND REV_INSTCODE = ?  AND  REV_STATUS = ?  AND REV_DATE > ? AND REV_SERVICECODE = ? ";
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $patientcode);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $sate);
			$st->BindParam(4, $thereviewday);
			$st->BindParam(5, $servicescode);
			$ert = $st->execute();
			if($ert){
				if($st->rowcount()>0){					
					return '2';
				}else{
					return '0';
				}				
			}else{
				return '0';
			}	

		// }else{
		// 	return '2';
		// }		
	}
}

$patientreviewtable = new OctopusPatientsReviewSql();
?>