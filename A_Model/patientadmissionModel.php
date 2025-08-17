<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$admissionmodel = isset($_POST['admissionmodel']) ? $_POST['admissionmodel'] : '';
	$dept = 'IPD';

	Global $instcode; 
	
	// 11 JAN 2022 JOSEPH ADORBOE assignbeds
	switch ($admissionmodel)
	{

	// 13 JUNE 2023 JOSEPH ADORBOE
	case 'savepatienthandovernotes':
		$consultationcode = isset($_POST['consultationcode']) ? $_POST['consultationcode'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$currentshift = isset($_POST['currentshift']) ? $_POST['currentshift'] : '';
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$handovernotes = isset($_POST['handovernotes']) ? $_POST['handovernotes'] : '';
		$servicerequestedcode = isset($_POST['servicerequestedcode']) ? $_POST['servicerequestedcode'] : '';
		$servicerequested = isset($_POST['servicerequested']) ? $_POST['servicerequested'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
		
		if($preventduplicate == '1'){
			if( empty($handovernotes) || empty($patientcode) || empty($patientnumber) ){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{				
			//	$doctorsnotes = strtoupper($doctorsnotes);
				
            	$notesrequestcode = $patientsnotestable->getnotesnumber($instcode);
				$types = 'HANDOVER';
				$service = "Amission";
				$add = $treatmentsql->insert_patientdoctorsnotes($form_key,$days,$notesrequestcode,$types,$service,$service,$consultationcode,$visitcode,$age,$gender,$patientcode,$patientnumber,$patient,$handovernotes,$currentusercode,$currentuser,$instcode);
				$title = "Handover Notes";
				if($add == '0'){				
					$status = "error";					
					$msg = "$title added Unsuccessful"; 
				}else if($add == '1'){						
					$status = "error";					
					$msg = "$title  Exist";					
				}else if($add == '2'){
					$event= "$title added successfully ";
					$eventcode= "139";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					if($audittrail == '2'){
						$status = "success";
						$msg = "$title for $patient  Successfully";	
					}else{
						$status = "error";					
						$msg = "Audit Trail Failed!"; 
					}					
			}else{				
					$status = "error";					
					$msg = "Unknown source "; 					
			}

			}
		}

	break;


	// 23 APR 2022  JOSEPH ADORBOE 
	case 'savepatientvitals':			
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$visitcode = isset($_POST['visitcode']) ? $_POST['visitcode'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$patientvitalstatus = isset($_POST['patientvitalstatus']) ? $_POST['patientvitalstatus'] : '';
		$age = isset($_POST['age']) ? $_POST['age'] : '';
		$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
		$bp = isset($_POST['bp']) ? $_POST['bp'] : '';
		$temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';
		$height = isset($_POST['height']) ? $_POST['height'] : '';
		$spo = isset($_POST['spo']) ? $_POST['spo'] : '';
		$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
		$pulse = isset($_POST['pulse']) ? $_POST['pulse']: '' ;
		$currentshiftcode = isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);					
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){				
				$status = "error";
				$msg = "Shift is closed";	 				
			}else{
				
				$fbs=$rbs=$glucosetest='NA';
				$insertcheck = $admissionsql->insert_admissionpatientvitals($form_key,$patientcode,$patientnumber,$patient,$visitcode,$age,$gender,$bp,$temperature,$height,$weight,$remarks,$dept,$days,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode,$fbs,$rbs,$glucosetest,$pulse,$spo,$currentday,$currentmonth,$currentyear);	

				if($insertcheck == '0'){				
					$status = "error";					
					$msg = "Adding Patient $patient Vitals Unsuccessful"; 
				}else if($insertcheck == '1'){			
					$status = "error";					
					$msg = "Patient Vitals for $patient already Exist"; 			
				}else if($insertcheck == '2'){				
					$status = "success";
					$msg = "Patient $patient Vitals added Successfully";
					$event= "ADD PATIENT VITALS CODE: $form_key $patientcode $patient has been saved successfully ";
					$eventcode= 52;
					$msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);												
				}else{				
					$status = "error";					
					$msg = "Add New Users Unsuccessful "; 				
				}
			}
				
		}			
	break;


	// 22 APR 2022  JOSEPH ADORBOE  
	case 'assignbeds':
		$admissioncode = isset($_POST['admissioncode']) ? $_POST['admissioncode'] : '';
		$wardbeds = isset($_POST['wardbeds']) ? $_POST['wardbeds'] : '';
		$patientcode = isset($_POST['patientcode']) ? $_POST['patientcode'] : '';
		$patientnumber = isset($_POST['patientnumber']) ? $_POST['patientnumber'] : '';
		$patient = isset($_POST['patient']) ? $_POST['patient'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($admissioncode) || empty($wardbeds) || empty($patientcode) || empty($patientnumber) || empty($patient) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
				$pers = explode('@@@', $wardbeds);
				$bedcode = $pers[0];
				$bedname = $pers[1];
				$wardcode = $pers[2];
				$wardname = $pers[3];
				$bedgender = $pers[4];
				$bedrate = $pers[5];
								
				$assignbed = $admissionsql->assignbed($admissioncode,$bedcode,$bedname,$wardcode,$wardname,$bedgender,$bedrate,$currentuser,$currentusercode,$instcode);
				$title = 'Assign Bed';
				if($assignbed == '0'){					
					$status = "error";					
					$msg = " $title for $wardname  Unsuccessful"; 
				}else if($assignbed == '1'){				
					$status = "error";					
					$msg = " $title for $wardname  Exist"; 					
				}else if($assignbed == '2'){
					$event= " $title $wardname successfully ";
					$eventcode= "101";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " $title $wardname Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;

		// 13 JAN 2022  JOSEPH ADORBOE  
	case 'editwardsbed':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$bedname = isset($_POST['bedname']) ? $_POST['bedname'] : '';
		$wards = isset($_POST['wards']) ? $_POST['wards'] : '';
		$bedrate = isset($_POST['bedrate']) ? $_POST['bedrate'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($bedname) || empty($bedrate) || empty($wards) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
				$pers = explode('@@@', $wards);
				$wardcode = $pers[0];
				$wardname = $pers[1];
			//	$wardrate = $pers[2];
			//	$wardgender = $pers[3];							
				$editpricing = $admissionsql->editwardsbed($ekey,$bedname,$wardcode,$wardname,$bedrate,$currentuser,$currentusercode,$instcode);
				$title = 'Edit Bed';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$wardname." Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "".$title." for ".$wardname." Exist"; 					
				}else if($editpricing == '2'){
					$event= " ".$title." ".$wardname."  successfully ";
					$eventcode= "101";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$wardname." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;
	
	// 12 JAN 2022 JOSPH ADORBOE 
	case 'addwardsbeds':			
		$bedname = isset($_POST['bedname']) ? $_POST['bedname'] : '';
		$wards = isset($_POST['wards']) ? $_POST['wards'] : '';
	//	$warerate = isset($_POST['warerate']) ? $_POST['warerate'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($bedname) || empty($wards)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$bedname = strtoupper($bedname);
				$pers = explode('@@@', $wards);
				$wardcode = $pers[0];
				$wardname = $pers[1];
				$wardrate = $pers[2];
				$wardgender = $pers[3];			
				$add = $admissionsql->addwardsbeds($form_key,$bedname,$wardcode,$wardname,$wardrate,$wardgender,$currentuser,$currentusercode,$instcode);
				$title = 'Add Ward';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." ".$bedname."  Unsuccessful"; 
				}else if($add == '1'){				
					$status = "error";					
					$msg = "".$title." ".$bedname."  Exist"; 					
				}else if($add == '2'){
					$event= "".$title."  ".$bedname."  successfully ";
					$eventcode= "100";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$bedname."  Successfully";
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
	

	// 12 JAN 2022  JOSEPH ADORBOE  
	case 'editwards':
		$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
		$wardname = isset($_POST['wardname']) ? $_POST['wardname'] : '';
		$wardgender = isset($_POST['wardgender']) ? $_POST['wardgender'] : '';
		$warerate = isset($_POST['warerate']) ? $_POST['warerate'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if(empty($ekey) || empty($wardname) ){
				$status = "error";
				$msg = "Required Fields cannot be empty ";
			}else{		
										
				$editpricing = $admissionsql->editwards($ekey,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);
				$title = 'Edit Wards';
				if($editpricing == '0'){					
					$status = "error";					
					$msg = "".$title." for ".$wardname." Unsuccessful"; 
				}else if($editpricing == '1'){				
					$status = "error";					
					$msg = "".$title." for ".$wardname." Exist"; 					
				}else if($editpricing == '2'){
					$event= " ".$title." ".$wardname."  successfully ";
					$eventcode= "101";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = " ".$title." ".$wardname." Successfully";
					}else{
						$status = "error";
						$msg = "Audit Trail unsuccessful";	
					}						
				}else{					
					$status = "error";					
					$msg = "Unsuccessful source "; 					
				}
			}
		}

	break;
	
	// 12 JAN 2022 JOSPH ADORBOE 
	case 'addwards':			
		$wardname = isset($_POST['wardname']) ? $_POST['wardname'] : '';
		$wardgender = isset($_POST['wardgender']) ? $_POST['wardgender'] : '';
		$warerate = isset($_POST['warerate']) ? $_POST['warerate'] : '';
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
		if($preventduplicate == '1'){
			if(empty($wardname) || empty($wardgender) || empty($warerate)){
				$status = 'error';
				$msg = 'Required Field Cannot be empty';				
			}else{
				$wardname = strtoupper($wardname);			
				$add = $admissionsql->addwards($form_key,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);
				$title = 'Add Ward';
				if($add == '0'){				
					$status = "error";					
					$msg = "".$title." ".$wardname."  Unsuccessful"; 
				}else if($add == '1'){				
					$status = "error";					
					$msg = "".$title." ".$wardname."  Exist"; 					
				}else if($add == '2'){
					$event= "".$title."  ".$wardname."  successfully ";
					$eventcode= "100";
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
					if($audittrail == '2'){				
						$status = "success";
						$msg = "".$title." ".$wardname."  Successfully";
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
	
	
	}

    function admissionmenu($patient, $patientnumber, $paymentmethod, $scheme, $gender, $age, $idvalue, $consult, $allegryalert, $chronicalert, $pendivestalert, $attachedalert, $vitals,$admissiontype,$admissiondoctor,$admissionnotes,$admissiontriage ,$admissionpaymenttype,$admissionward,	$admissionbed,$admissionsduration,$admissiondate,$admissionnumber,$admissionsservice,$admissionsservicecode)
    {
        ?>
		<div class="card">
			<div class="card-header">
			<div class="card-title">Detail: <?php echo $patient; ?> - <?php echo $patientnumber; ?> - <?php echo $paymentmethod; ?> - <?php echo $scheme; ?> - <?php echo $gender; ?> - <?php echo $age; ?> Years - <?php echo (($admissionpaymenttype == '1')?'PAY BEFORE':'PAY AFTER'); ?>  - <?php echo(($admissiontype == '1')?'DETAIN':(($admissiontype == '2')?'ADMISSION':'EMERGENCY')); ?> 
			 </div>		
			</div>
			
			<div class="card-body">
			<div class="btn-list">
			<a href="manageadmission" class="btn btn-dark <?php if ($consult == 11) { ?>active <?php } ?>">Back</a>
			<br />
			<a href="admission__admissiondetails?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 1) { ?>active <?php } ?>">Patient Details</a>
			<a href="admission__patientvitals?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 2) { ?>active <?php } ?>">Vitals</a>
			<a href="admissionpatientnotes?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 12) { ?>active <?php } ?>">Notes</a>
			<a href="admission__patientvisit?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 3) { ?>active <?php } ?>">Visit Summary</a>
			<a href="admission__patientlegacy?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 4) { ?>active <?php } ?>">History</a>
			<a href="admission__patientcomplains?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if ($consult == 5) { ?>active <?php } ?>">Complaints</a>
			<a href="admission__patientphysicalexams?<?php echo $idvalue ?>" class="btn btn-outline-warning <?php if ($consult == 6) { ?>active <?php } ?>">Physical Exam</a>
			<a href="admission__patientinvestigation?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 7) { ?>active <?php } ?>">Investigations</a>
			<a href="admission__patientdiagnosis?<?php echo $idvalue ?>" class="btn btn-outline-primary <?php if ($consult == 8) { ?>active <?php } ?>">Diagnosis</a>
			<a href="admission__patientprescription?<?php echo $idvalue ?>" class="btn btn-outline-secondary <?php if ($consult == 9) { ?>active <?php } ?>">Prescription</a>
			<a href="admission__patienttreatment?<?php echo $idvalue ?>" class="btn btn-outline-info <?php if ($consult == 10) { ?>active <?php } ?>">Treatment</a>
			
			<a href="admission__patientaction?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 11) { ?>active <?php } ?>">Action</a>	
				<!--					
					
					<!--
					<a href="#" class="btn btn-outline-secondary">Vitals</a>
					<a href="#" class="btn btn-outline-secondary">History</a>											
					
					--
					<a href="consultationpatientlastvisit?<?php echo $idvalue ?>" class="btn btn-outline-success <?php if ($consult == 8) { ?>active <?php } ?>">Previous Visit</a>
																
					<!--
					<a href="#" class="btn btn-outline-success">Management</a>
					--
					
					<!--
						<a href="#" class="btn btn-outline-warning">Doctors Notes</a>
						
						--
						<a href="consultationpatientsummary?<?php echo $idvalue ?>" class="btn btn-outline-danger <?php if ($consult == 6) { ?>active <?php } ?>">Summary</a>
					
	-->												
				</div>	
				<br />
				<div class="row">										
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission No*</label>
								<?php echo $admissionnumber; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admission Date*</label>
								<?php echo date('D d M Y H:i:s a',strtotime($admissiondate)); ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Ward*</label>
								<?php echo $admissionward; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Bed*</label>
							<?php echo $admissionbed; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Triage*</label>
							<?php echo $admissiontriage; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Doctor*</label>
							<?php echo $admissiondoctor; ?>
							</div>											
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Duration*</label>
							<?php echo $admissionsduration; ?> Days
							</div>											
						</div>
						
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Service*</label>
							<?php echo $admissionsservice; ?>
							</div>											
						</div>
	
						<div class="col-md-3">
							<div class="form-group">
							<label class="form-label">Admiting Notes*</label>
							<?php echo $admissionnotes; ?>
							</div>											
						</div>
				</div>		

				
				<br />
				<?php
                    if($vitals !== '1'){
						$vt = explode('@', $vitals);
						$bp = $vt[0];
						$temp = $vt[1];
						$height = $vt[2];
						$weight = $vt[3];
						$fbs = $vt[4];
						$pulse = $vt[7];
						$spo2 = $vt[8];

					}else{
						$bp = $temp = $height = $weight = $fbs = $pulse = 'NA';
					}
				?>
				<div class="card-title">Vitals : BP - <?php echo $bp; ?> , Temperature - <?php echo $temp; ?> , Pulse - <?php echo $pulse; ?> , Height - <?php echo $height; ?> , Weight - <?php echo $weight; ?> , FBS - <?php echo $fbs; ?>  </div>	
										
			</div>	
							
		</div>
			
		<div class="row">
		<?php if (empty($admissionbed)) { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient NOT Assigned to a Bed">
			Patient NOT Assigned to a Bed 
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if ($allegryalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-danger" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Allergy" data-content="Patient has allergy">
			Patient has ALLERGY
			</button>
			</a>
		</div>
		<?php } ?>

		<?php if ($chronicalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Chronic Condition" data-content="Patient has Chronic Condition">
			Patient has CHRONIC Condition
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($pendivestalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-secondary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Investigations" data-content="Patient has Pending Investigations ">
			Patient has Pending Investigations
			</button>
			</a>
		</div>
		<?php } ?>
		<?php if ($attachedalert == '2') { ?>			
		<div class="col-md-3 mt-2 mb-2">
			<a href="admission__admissiondetails?<?php echo $idvalue ?>">
			<button type="button" class="btn btn-block btn-success" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content="Patient has Attached Results ">
			Patient has Attached Results 
			</button>
			</a>
		</div>
		<?php } ?>
		</div>
		
<?php
    }
	
?>
