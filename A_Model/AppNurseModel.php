<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$nursemodel = htmlspecialchars(isset($_POST['nursemodel']) ? $_POST['nursemodel'] : '');
	
	// 11 MAR 2021 
switch ($nursemodel)
{

	// 13 FEB 2022  JOSEPH ADORBOE
	case 'saveprocedurenotes':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
		$procedurecode = htmlspecialchars(isset($_POST['procedurecode']) ? $_POST['procedurecode'] : '');
		$procedurereport = htmlspecialchars(isset($_POST['procedurereport']) ? $_POST['procedurereport'] : '');
				
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{
                if(empty($ekey) || empty($procedurereport) ) {
                    $status = 'error';
                    $msg = 'Required Field Cannot be empty';
                }else{			
					$procedurereport = strtoupper($procedurereport);		                      
                    $answer = $nursesql->enterprocedurenotesreports($ekey, $procedurereport,$days, $currentusercode, $currentuser, $instcode,$currentday,$currentmonth,$currentyear);                   

                    if ($answer == '1') {
                        $status = "error";
                        $msg = "Already Selected";
                    } elseif ($answer == '2') {
                        $event= "Procedure Report has been saved successfully ";
                        $eventcode= 165;
                        $audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
							$status = "success";
                            $msg = "Notes Entered Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } elseif ($answer == '0') {
                        $status = "error";
                        $msg = "Unsuccessful";
                    } else {
                        $status = "error";
                        $msg = "Unknown Source";
                    }
                }
            }
			
			}
	break;
	
	// 22 JAN 2022 JOSEPH ADORBOE
	case 'cancelarchive':		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$visitcode = htmlspecialchars(isset($_POST['visitcode']) ? $_POST['visitcode'] : '');
		$patientcode = htmlspecialchars(isset($_POST['patientcode']) ? $_POST['patientcode'] : '');
		$patientnumber = htmlspecialchars(isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '');
		$patient = htmlspecialchars(isset($_POST['patient']) ? $_POST['patient'] : '');
		$billcode = htmlspecialchars(isset($_POST['billcode']) ? $_POST['billcode'] : '');	
		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		if($preventduplicate == '1'){		
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";				
			}else{

				if(empty($_POST["scheckbox"])){   
					$status = "error";
					$msg = "Required Fields cannot be empty";	 
				}else{
				
					foreach($_POST["scheckbox"] as $key){
							$kt = explode('@@@',$key);
							$bcode = $kt['0'];
							$servicescode = $kt['1'];
							$depts = $kt['2'];
							$cost = $kt['3'];
							$paymentmethodcode = $kt['4'];
							$paymentschemecode = $kt['5'];
							$labstate = $kt['6'];
							$med = $kt['7'];
							$scheme = $kt['9'];
							$qty = $kt['10'];
							$status = $kt['12'];

							if($status !== '1'){
								$status = "error";
								$msg = "Only Unpaid procedures can be cancelled"; 
							}else{
								$answer = $nursesql->cancelprocedures($bcode, $days,$patientcode, $visitcode, $currentusercode, $currentuser, $instcode);                        
								if ($answer == '1') {
									$status = "error";
									$msg = "Already Cancelled";
								} elseif ($answer == '2') {
									$event= "Cancel Procedure successfully ";
									$eventcode= 183;
									$audittrail = $userlogsql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
									if ($audittrail == '2') {
										$status = "success";
										$msg = "Cancel Procedure successfully ";
									} else {
										$status = "error";
										$msg = "Audit Trail Failed!";
									}
								} elseif ($answer == '0') {
									$status = "error";
									$msg = "Unsuccessful";
								} else {
									$status = "error";
									$msg = "Unknown Source";
								}
							}
						
							}							
						}			
					}			
				
		
			}
	break;
	
}

function servicebasketdetails($patient,$patientnumber,$paymentmethod,$scheme,$gender,$age,$idvalue,$consult){
	?>
	<div class="card">
		<div class="card-header">
		<div class="card-title">Details: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years </div>
		</div>
		<div class="card-body">
			<div class="btn-list">
				<!-- <a href="patientservicebasket" class="btn btn-dark">Back</a> -->
				<div class="btn-group mt-2 mb-2">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						Sub Menu <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						
						<li><a href="#" data-toggle="modal" data-target="#largeModalfollowupservicebasket">Request Followup </a></li>
						<li><a href="#" data-toggle="modal" data-target="#largeModaladdnotesservicebasket">Add Nurse Notes </a></li>										
					</ul>
				</div>																
			</div>									
		</div>
					
						
	</div>
<?php } 
 

?>
