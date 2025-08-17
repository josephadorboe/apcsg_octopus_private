<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';

	$prescriptionplanmodel = isset($_POST['prescriptionplanmodel']) ? $_POST['prescriptionplanmodel'] : '';
	
	// 13 MAR 2022 JOSEPH ADORBOE  
switch ($prescriptionplanmodel)
{
	
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'editprescriptioplanmedication':

		$medication = isset($_POST['medication']) ? $_POST['medication'] : '';
		$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
		$pdays = isset($_POST['pdays']) ? $_POST['pdays'] : '';
		$route = isset($_POST['route']) ? $_POST['route'] : '';
		$qty = isset($_POST['qty']) ? $_POST['qty'] : '';
		$strenght = isset($_POST['strenght']) ? $_POST['strenght'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($medication) || empty($frequency) || empty($qty) || empty($pdays) || empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else {
                $med = explode('@@@', $medication);
                $medcode = $med[0];
                $medname = $med[1];
                $dosecode = $med[2];
                $dose = $med[3];
                
                $type = 'OPD';

                $freq = explode('@@@', $frequency);
                $freqcode = $freq[0];
                $freqname = $freq[1];
            //    $freqqty = $freq[2];

                $da = explode('@@@', $pdays);
                $dayscode = $da[0];
                $daysname = $da[1];
            //    $daysvalue = $da[2];

                if (!empty($route)) {
                    $rou = explode('@@@', $route);
                    $routecode = $rou[0];
                    $routename = $rou[1];
                } else {
                    $routecode = '';
                    $routename = '';
                }
                                
                $edit = $prescriptionplansql->editprescriptionplanmedication($ekey, $medcode, $medname, $dosecode, $dose, $freqcode, $freqname, $dayscode, $daysname, $routecode, $routename, $qty, $strenght, $currentusercode, $currentuser, $instcode);
                $title = 'Edit  Medication In  Prescription  Plan';
                if ($edit == '0') {
                    $status = "error";
                    $msg = "".$title." ".$medname."  Unsuccessful";
                } elseif ($edit == '1') {
                    $status = "error";
                    $msg = "".$title." ".$medname."  Exist";
                } elseif ($edit == '2') {
                    $event= "".$title." successfully ";
                    $eventcode= "186";
                    $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                    if ($audittrail == '2') {
                        $status = "success";
                        $msg = "".$title." ".$medname." added Successfully";
                    } else {
                        $status = "error";
                        $msg = "Audit Trail unsuccessful";
                    }
                } else {
                    $status = "error";
                    $msg = "Unknown source ";
                }
            }

		
		}

	break;
	
	// 23 JAN 2022  JOSEPH ADORBOE 
	case 'removemedicationfromprescriptionplan':

		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$medicate = isset($_POST['medicate']) ? $_POST['medicate'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{							
					
				$remove = $prescriptionplansql->update_removemedicationfromplans($ekey,$currentusercode,$currentuser,$instcode);
				
				if($remove == '0'){				
					$status = "error";					
					$msg = "Remove Medication".$medicate." Unsuccessful"; 
				}else if($remove == '1'){				
					$status = "error";					
					$msg = "Remove Medication".$medicate." Exist"; 					
				}else if($remove == '2'){
					$event= "Medication $medicate Remove successfully ";
					$eventcode= "187";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){				
						$status = "success";
						$msg = "Medication ".$medicate." Removed Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}			
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

			}
		}

	break;
	
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'addmedicationtoprescriptionplan': 
		$plancode = isset($_POST['plancode']) ? $_POST['plancode'] : '';
		$plan = isset($_POST['plan']) ? $_POST['plan'] : '';
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($plancode) || empty($plan)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
						
						foreach ($_POST["scheckbox"] as $plandetails) {
							$lpdet = explode('@@@', $plandetails);
							$medicationcode = $lpdet['0'];
							$medicationnum = $lpdet['1'];
							$medicationname = $lpdet['2'];
							$dosagecode = $lpdet['3'];
							$dosage = $lpdet['4'];
							$form_key = md5(microtime());
							
							$prescriptionplans = $prescriptionplansql->insert_prescriptionplanlist($form_key,$plancode,$plan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode);

							if ($prescriptionplans == '0') {
								$status = "error";
								$msg = "Add  Unsuccessful";
							} elseif ($prescriptionplans == '1') {
								$status = "error";
								$msg = "Prescription Plan Exist Already";
							} elseif ($prescriptionplans == '2') {
								$event= " Add Prescription Plans ".$plan." has been saved successfully ";
								$eventcode= 184;
								$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
								if ($audittrail == '2') {
									$status = "success";
									$msg = "Prescription Plan for $plan Added Successfully";
								} else {
									$status = "error";
									$msg = "Audit Trail Failed!";
								}
							} else {
								$status = "error";
								$msg = "Unknown Source";
							}
						}
					
			}
		}
	break;
	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'addprescriptionplan':
		
		$prescriptionplan = isset($_POST['prescriptionplan']) ? $_POST['prescriptionplan'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($prescriptionplan) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					$prescriptionplancode = md5(microtime());
					$prescriptionplannumber = $lov->getprescriptionplannumber($instcode);	
					$lp = $prescriptionplansql->newprescriptionplans($prescriptionplancode,$prescriptionplan,$prescriptionplannumber,$description,$days,$currentusercode,$currentuser,$instcode);
					if($lp == 2){
						foreach ($_POST["scheckbox"] as $plandetails) {
							// $rvalue = $_POST["frequency"];
							// print_r($rvalue);
							// die;
							$lpdet = explode('@@@', $plandetails);
							$medicationcode = $lpdet['0'];
							$medicationnum = $lpdet['1'];
							$medicationname = $lpdet['2'];
							$dosagecode = $lpdet['3'];
							$dosage = $lpdet['4'];
							$form_key = md5(microtime());
							$prescriptionplans = $prescriptionplansql->insert_prescriptionplanlist($form_key,$prescriptionplancode,$prescriptionplan,$medicationcode,$medicationnum,$medicationname,$days,$dosagecode,$dosage,$currentusercode,$currentuser,$instcode);

							if ($prescriptionplans == '0') {
								$status = "error";
								$msg = "Add  Unsuccessful";
							} elseif ($prescriptionplans == '1') {
								$status = "error";
								$msg = "Prescription Plan Exist Already";
							} elseif ($prescriptionplans == '2') {
								$event= " Add Prescription Plans ".$prescriptionplan." has been saved successfully ";
								$eventcode= 184;
								$audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
								if ($audittrail == '2') {
									$status = "success";
									$msg = "Prescription Plan for $prescriptionplan Added Successfully";
								} else {
									$status = "error";
									$msg = "Audit Trail Failed!";
								}
							} else {
								$status = "error";
								$msg = "Unknown Source";
							}
						}
					}else {
						$status = "error";
						$msg = "Unknown Source";
					}
			}
		}
	break;
	
}


?>
