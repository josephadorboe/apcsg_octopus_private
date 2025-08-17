<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$recordsmodel = isset($_POST['recordsmodel']) ? $_POST['recordsmodel'] : '';
	
	// 08 MAY 2021 JOSEPH ADORBOE 
switch ($recordsmodel)
{
	// 29 JULY 2021 JOSEPH ADORBOE  
	case 'endvisit': 
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		// $requestcode = isset($_POST['requestcode']) ? $_POST['requestcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$servicecode = isset($_POST['servicecode']) ? $_POST['servicecode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($patient) || empty($patientcode) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{
                $edit = $recordssql->endvisit($ekey,$visitcode,$servicecode,$patientcode,$currentusercode,$currentuser,$instcode);
                $title = 'End visit ';
                if ($edit == '0') {
                    $status = "error";
                    $msg = "".$title." for ".$patient." Unsuccessful";
                } elseif ($edit == '1') {
                    $status = "error";
                    $msg = "".$title." for ".$patient." has a been activated already ";
                } elseif ($edit == '2') {
                    $event= " ".$title." ".$patient."  successfully ";
                    $eventcode= "176";
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = " ".$title." ".$patient." Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail unsuccessful";
                    }
                } else {
                    $status = "error";
                    $msg = "Unsuccessful source ";
                }
            }
		}

	break;

	// 06 JULY 2021 JOSEPH ADORBOE patient folder search 
	case 'records_patientfoldersearch': 
		$patientrecords = isset($_POST['patientrecords']) ? $_POST['patientrecords'] : '';			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";  
				$msg = "Shift is closed";					
			}else{
				if(empty($patientrecords) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{						
					$value = $patientrecords;
					$msql->passingvalues($pkey=$form_key,$value);						
					$url = "recordspatientfolder?$form_key";
					$engine->redirect($url);
				}
			}
		}
	break;
	

	// 5 MAY 2021
	case 'records_updatepatientnumberrecords':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$newpatientnumber = isset($_POST['newpatientnumber']) ? $_POST['newpatientnumber'] : '';	
		$replacepatientnumber = isset($_POST['replacepatientnumber']) ? $_POST['replacepatientnumber'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){				
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";					
				}else{
					if(empty($newpatientnumber) || empty($replacepatientnumber) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';														
				}else{						
					$editpatientrecords = $recordssql->update_patientnumberrecords($ekey,$replacepatientnumber,$currentusercode,$currentuser,$instcode);					
					$title = 'Edit Patient Number ';
					if($editpatientrecords == '0'){					
						$status = "error";					
						$msg = "".$title." ".$fullname." Records Unsuccessful"; 	
					}else if($editpatientrecords == '1'){						
						$status = "error";					
						$msg = "".$title." ".$fullname." Exist"; 						
					}else if($editpatientrecords == '2'){
						$event= "".$title." for ".$replacepatientnumber." successfully ";
						$eventcode= 61;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." from $newpatientnumbe to $replacepatientnumber saved Successfully";		
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}				
					}else{					
						$status = "error";					
						$msg = "Edit Patient Records Unknown source ";						
					}
				}
			}
		}

	break;


	// 17 JAN 2021
	case 'records_updatepatientrecords':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$newpatientnumber = isset($_POST['newpatientnumber']) ? $_POST['newpatientnumber'] : '';	
		$replacepatientnumber = isset($_POST['replacepatientnumber']) ? $_POST['replacepatientnumber'] : '';		
		$patienttitle = isset($_POST['patienttitle']) ? $_POST['patienttitle'] : '';
		$patientfirstname = isset($_POST['patientfirstname']) ? $_POST['patientfirstname'] : '';
		$patientlastname = isset($_POST['patientlastname']) ? $_POST['patientlastname'] : '';
		$patientbirthdate = isset($_POST['patientbirthdate']) ? $_POST['patientbirthdate'] : '';
		$patientgender = isset($_POST['patientgender']) ? $_POST['patientgender'] : '';
		$patientmaritalstatus = isset($_POST['patientmaritalstatus']) ? $_POST['patientmaritalstatus'] : '';
		$patientreligion = isset($_POST['patientreligion']) ? $_POST['patientreligion'] : '';
		$patientnationality = isset($_POST['patientnationality']) ? $_POST['patientnationality'] : '';
		$patientphone = isset($_POST['patientphone']) ? $_POST['patientphone'] : '';
		$patientaltphone = isset($_POST['patientaltphone']) ? $_POST['patientaltphone'] : '';
		$patienthomeaddress = isset($_POST['patienthomeaddress']) ? $_POST['patienthomeaddress'] : '';
		$patientemail = isset($_POST['patientemail']) ? $_POST['patientemail'] : '';
		$patientpostal = isset($_POST['patientpostal']) ? $_POST['patientpostal'] : '';
		$patientoccupation = isset($_POST['patientoccupation']) ? $_POST['patientoccupation'] : '';
		$patientemergencyone = isset($_POST['patientemergencyone']) ? $_POST['patientemergencyone'] : '';		
		$patientemergencytwo = isset($_POST['patientemergencytwo']) ? $_POST['patientemergencytwo'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){				
				if($currentshiftcode == '0'){				
					$status = "error";
					$msg = "Shift is closed";					
				}else{
					if(empty($newpatientnumber) || empty($patientfirstname) || empty($patientlastname)  || empty($patientbirthdate) || empty($patientgender) || empty($patientphone) || empty($patientemergencyone) || empty($patientemergencytwo)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';														
				}else{					
					$bdate = explode('-', $patientbirthdate);
					$mmd = $bdate[1];
					$ddd = $bdate[2];
					$yyy = $bdate[0];
					$patientbirthdate = $yyy.'-'.$mmd.'-'.$ddd;				
					$fullname = $patientfirstname.' '.$patientlastname;					
					$editpatientrecords = $recordssql->update_patientrecords($ekey,$patientfirstname,$patientlastname,$fullname,$patientaltphone,$patientnationality,$patientreligion,$patientpostal,$patientmaritalstatus,$patienthomeaddress,$patientemail,$patientbirthdate,$patientoccupation,$patientgender,$patientphone,$patientemergencyone,$patientemergencytwo,$currentusercode,$currentuser,$instcode);
					$title = 'Edit Patient records ';
					if($editpatientrecords == '0'){					
						$status = "error";					
						$msg = "".$title." ".$fullname." Records Unsuccessful"; 	
					}else if($editpatientrecords == '1'){						
						$status = "error";					
						$msg = "".$title." ".$fullname." Exist"; 						
					}else if($editpatientrecords == '2'){
						$event= "".$title." for ".$newpatientnumber." successfully ";
						$eventcode= 61;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "".$title." for $patientlastname $patientfirstname saved Successfully";		
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}				
					}else{					
						$status = "error";					
						$msg = "Edit Patient Records Unknown source ";						
					}
				}
			}
		}

	break;
	
	
		
}
 

?>
