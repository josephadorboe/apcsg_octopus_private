<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$settingsmodel = isset($_POST['settingsmodel']) ? $_POST['settingsmodel'] : '';

	if($userdetails !== '-1'){
	//	$scheduleuserlist = ("SELECT * from octopus_users where USER_STATUS = '1' and USER_INSTCODE = '$instcode'  order by USER_FULLNAME ");
	//	$getscheduleuserslist = $dbconn->query($scheduleuserlist);

	}
	
	
	// 17 APR 2021 JOSEPH ADORBOE
	switch ($settingsmodel)
	{

		// 22 MAY 2021 JOSPH ADORBOE
		case 'savesreciptdetails':
			
			$companyname = isset($_POST['companyname']) ? $_POST['companyname'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$captions = isset($_POST['captions']) ? $_POST['captions'] : '';
			$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$taxpin = isset($_POST['taxpin']) ? $_POST['taxpin'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
			//	die($starttime);
				if(empty($ekey) || empty($companyname) || empty($captions) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	

					$ext = '.jpeg';
					$finame = $form_key.''.$ext;
					$pfed = 'images/';
					$file = $_FILES['fileone'];
					$file_name = $_FILES['fileone']['name'];
					$file_type = $_FILES['fileone']['type'];
					$file_size = $_FILES['fileone']['size'];
					$file_temp_loc = $_FILES['fileone']['tmp_name'];	
					$file_store = $pfed.$finame;
					move_uploaded_file($file_temp_loc, $file_store);


					$edit = $settingssql->update_receiptdetails($finame,$companyname,$captions,$phonenumber,$email,$taxpin,$currentuser,$currentusercode,$instcode);
					$title = 'Settings';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= "".$title." Edited successfully ";
						$eventcode= "50";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." edited Successfully";
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

		// 05 MAY 2021 JOSPH ADORBOE
		case 'saveshifttypes':
			
			$ekeyshift = isset($_POST['ekeyshift']) ? $_POST['ekeyshift'] : '';
			$starttime = isset($_POST['starttime']) ? $_POST['starttime'] : '';
			$endtime = isset($_POST['endtime']) ? $_POST['endtime'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
			//	die($starttime);
				if(empty($ekeyshift) || empty($starttime) || empty($endtime) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$edit = $settingssql->update_shiftsettings($starttime,$endtime,$ekeyshift,$currentuser,$currentusername,$instcode);
					$title = 'Settings';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= "".$title." Edited successfully ";
						$eventcode= "50";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = "".$title." edited Successfully";
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



		
		// 19 APR 2021 JOSPH ADORBOE
		case 'editsettings':

			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			$staffpershift = isset($_POST['staffpershift']) ? $_POST['staffpershift'] : '';
			$consultationduration = isset($_POST['consultationduration']) ? $_POST['consultationduration'] : '';
			$startconsultation = isset($_POST['startconsultation']) ? $_POST['startconsultation'] : '';
			$endconsultation = isset($_POST['endconsultation']) ? $_POST['endconsultation'] : '';
			$appointmentdays = isset($_POST['appointmentdays']) ? $_POST['appointmentdays'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($staffpershift) || empty($consultationduration) || empty($startconsultation) || empty($endconsultation) || empty($appointmentdays) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					$edit = $settingssql->update_settings($staffpershift,$consultationduration,$startconsultation,$endconsultation,$appointmentdays,$ekey,$instcode);
					$title = 'Settings';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." Edited successfully ";
						$eventcode= "105";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." edited Successfully";
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


		// 19 APR 2021 JOSPH ADORBOE
		case 'saveconsultationend':

			$consultationend = isset($_POST['consultationend']) ? $_POST['consultationend'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if(empty($consultationend) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					$edit = $settingssql->update_consultationend($consultationend,$currentusercode,$currentuser,$instcode);
					$title = 'Consultation Appointment End time';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." Edited successfully ";
						$eventcode= "106";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);	
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." edited Successfully";
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

		// 19 APR 2021 JOSPH ADORBOE
		case 'saveconsultationstart':

			$consultationstart = isset($_POST['consultationstart']) ? $_POST['consultationstart'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if(empty($consultationstart) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					$edit = $settingssql->update_consultationstart($consultationstart,$currentusercode,$currentuser,$instcode);
					$title = 'Consultation Appoitment start time ';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." Edited successfully ";
						$eventcode= "107";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." edited Successfully";
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

		// 19 APR 2021 JOSPH ADORBOE
		case 'saveconsultationduration':

			$consultationduration = isset($_POST['consultationduration']) ? $_POST['consultationduration'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if(empty($consultationduration) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					$edit = $settingssql->update_consultationduration($consultationduration,$currentusercode,$currentuser,$instcode);
					$title = 'Consultation Duration';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= " ".$title." Edited successfully ";
						$eventcode= "108";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." edited Successfully";
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


		// 18 APR 2021 JOSPH ADORBOE
		case 'savestaffpershift':

			$staffpershift = isset($_POST['staffpershift']) ? $_POST['staffpershift'] : '';
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			
			if($preventduplicate == '1'){
				if(empty($staffpershift) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{					
	
					$edit = $settingssql->update_staffpershift($staffpershift,$currentusercode,$currentuser,$instcode);
					$title = 'Total Staff Per Shift';
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit ".$title." Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit ".$title." Exist"; 					
					}else if($edit == '2'){
						$event= "".$title." Edited successfully ";
						$eventcode= "111";
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
					//	die($audittrail);
						if($audittrail == '2'){				
							$status = "success";
							$msg = " ".$title." edited Successfully";
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
	

?>
