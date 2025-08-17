<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$schedulemodel = isset($_POST['schedulemodel']) ? $_POST['schedulemodel'] : '';

	// if($userdetails !== '-1'){

		

	// 	// $scheduleuserlist = ("SELECT * from octopus_users where USER_STATUS = '1' and USER_INSTCODE = '$instcode'  order by USER_FULLNAME ");
	// 	// $getscheduleuserslist = $dbconn->query($scheduleuserlist);

	// }
	
	
	// 17 APR 2021 JOSEPH ADORBOE
	switch ($schedulemodel)
	{
		// 07 NOV 2021 JOSEPH ADORBOE 
		case 'cancelschedule':

			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				if($preventduplicate == '1'){						
						if(empty($ekey)){	   
							$status = "error";
							$msg = "Required Fields cannot be empty";		 
						}else{			
								$answer = $schedulesql->cancelschedule($ekey,$days,$currentusercode,$currentuser);
					
								if($answer == '1'){
									$status = "error";
									$msg = "Already Unselected ";	
								}else if($answer == '2'){
									$event= "Remove staff schedule ".$ekey."  has been saved successfully ";
									$eventcode= 109;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Remove Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}
																		
								}else if($answer == '0'){	
									$status = "error";
									$msg = "Unsuccessful"; 	
								}else{	
									$status = "error";
									$msg = "Unknown Source"; 	
								}
					}		
			}

		break;
	

		// 07 NOV 2021 JOSEPH ADORBOE 
		case 'savemyschedule': 
			$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$shifttype = isset($_POST['shifttype']) ? $_POST['shifttype'] : '';			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($scheduledate) || empty($shifttype) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
					$schedulecode = md5(microtime());
					$sty = explode('@@@',$shifttype);
					$shifttype = $sty['0'];
					$dt = explode('/', $scheduledate);
					$schedulemonth = $dt[0];
					$scheduleday = $dt[1];
					$scheduleyear = $dt[2];
					$scheduledate = $scheduleyear.'-'.$schedulemonth.'-'.$scheduleday;
				//	die($scheduledate);
					$mainschedule = $schedulesql->insert_schedule($schedulecode,$scheduledate,$shifttype,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);

				//	foreach($_POST["scheckboxmanualschedule"] as $staffdetails){
						$schedulenumber = $lov->getschedulenumber($instcode);	
						// $staffdet = explode('@@@',$staffdetails);
						// $staffdetcode = $staffdet['0'];
						// $staffdetname = $staffdet['1'];
						$staffschedulecode = md5(microtime());
						$staffschedule = $schedulesql->insert_myschedule($staffschedulecode,$scheduledate,$shifttype,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
									
					if($staffschedule == '0'){					
						$status = "error";					
						$msg = "Add  Unsuccessful"; 
					}else if($staffschedule == '1'){						
						$status = "error";					
						$msg = "Schedule Exist Already"; 					
					}else if($staffschedule == '2'){	
						$event= " Add schedule ".$staffdetname." has been saved successfully ";
						$eventcode= 110;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "Manual schedule for ".$scheduledate." ".$shifttype." Added Successfully";
							}else{
								$status = "error";					
								$msg = "Audit Trail Failed!"; 
							}									
					}else{					
						$status = "error";					
						$msg = "Unknown Source";					
					}
			//	}
				}
			}
		break;

		// 18 APR 2021 JOSEPH ADORBOE 
		case 'removemanualschedule':

			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$ekey = isset($_POST['ekey']) ? $_POST['ekey'] : '';
			
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				if($preventduplicate == '1'){						
						if(empty($ekey)){	   
							$status = "error";
							$msg = "Required Fields cannot be empty";		 
						}else{			
								$answer = $schedulesql->removestaffschedule($ekey,$currentusercode,$currentuser);
					
								if($answer == '1'){
									$status = "error";
									$msg = "Already Unselected ";	
								}else if($answer == '2'){
									$event= "Remove staff schedule ".$ekey."  has been saved successfully ";
									$eventcode= 109;
									$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
									if($audittrail == '2'){
										$status = "success";
										$msg = "Remove Successfully";	
									}else{
										$status = "error";					
										$msg = "Audit Trail Failed!"; 
									}
																		
								}else if($answer == '0'){	
									$status = "error";
									$msg = "Unsuccessful"; 	
								}else{	
									$status = "error";
									$msg = "Unknown Source"; 	
								}
					}		
			}

		break;

		
		
		// 18 APR 2021
		case 'savemanualschedule': 
			$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$shifttype = isset($_POST['shifttype']) ? $_POST['shifttype'] : '';			
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
					if(empty($scheduledate) || empty($shifttype) ){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{
					$schedulecode = md5(microtime());
					$mainschedule = $schedulesql->insert_schedule($schedulecode,$scheduledate,$shifttype,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);

					foreach($_POST["scheckboxmanualschedule"] as $staffdetails){
						$schedulenumber = $lov->getschedulenumber($instcode);	
						$staffdet = explode('@@@',$staffdetails);
						$staffdetcode = $staffdet['0'];
						$staffdetname = $staffdet['1'];
						$staffschedulecode = md5(microtime());
						$staffschedule = $schedulesql->insert_staffschedule($staffschedulecode,$scheduledate,$shifttype,$staffdetcode,$staffdetname,$schedulenumber,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear);
									
					if($staffschedule == '0'){					
						$status = "error";					
						$msg = "Add  Unsuccessful"; 
					}else if($staffschedule == '1'){						
						$status = "error";					
						$msg = "Schedule Exist Already"; 					
					}else if($staffschedule == '2'){	
						$event= " Add schedule ".$staffdetname." has been saved successfully ";
						$eventcode= 110;
						$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
							if($audittrail == '2'){
								$status = "success";
								$msg = "Manual schedule for ".$scheduledate." ".$shifttype." Added Successfully";
							}else{
								$status = "error";					
								$msg = "Audit Trail Failed!"; 
							}									
					}else{					
						$status = "error";					
						$msg = "Unknown Source";					
					}
				}
				}
			}
		break;


		// 18 APR 2021 JOSPH ADORBOE
		case 'manualschedulefilter': 
			
			$scheduledate = isset($_POST['scheduledate']) ? $_POST['scheduledate'] : '';
			$shifttype = isset($_POST['shifttype']) ? $_POST['shifttype'] : '';		
			$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
			$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){			
					$status = "error";
					$msg = "Shift is closed";				
				}else{
				if(empty($scheduledate) || empty($shifttype)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
						$dt = explode('/', $scheduledate);
						$schedulemonth = $dt[0];
						$scheduleday = $dt[1];
						$scheduleyear = $dt[2];
						$scheduledate = $scheduleyear.'-'.$schedulemonth.'-'.$scheduleday;

						if($scheduledate < $day){
							$status = "error";
							$msg = "Schedule date can only be a future date";
						}else{
							$value = $scheduledate.'@@@'.$shifttype;
							$msql->passingvalues($pkey=$form_key,$value);					
							$url = "admin__manualschedule?$form_key";
							$engine->redirect($url);
						}						
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
	
					$edit = $schedulesql->update_staffpershift($staffpershift,$currentusercode,$currentuser,$instcode);
					
					if($edit == '0'){				
						$status = "error";					
						$msg = "Edit Staff Per shift Unsuccessful"; 
					}else if($edit == '1'){				
						$status = "error";					
						$msg = "Edit Staff Per shift Exist"; 					
					}else if($edit == '2'){
						$event= "Staff Per shift Edited successfully ";
						$eventcode= "111";
						$audit= $msql->auditlog($currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$form_number,$form_key,$day);	
						if($audit == '2'){				
							$status = "success";
							$msg = "Staff Per shift edited Successfully";
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
