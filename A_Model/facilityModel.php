<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	
	$facilitymodel = isset($_POST['facilitymodel']) ? $_POST['facilitymodel'] : '';
	
	// 10 MAR 2021
switch ($facilitymodel)
{
	
	
	// 24 FEB 2022 JOSEPH ADORBOE 
	case 'setup_addfacilityservices': 

		// $facilityname = isset($_POST['facilityname']) ? $_POST['facilityname'] : '';
		// $facilityaddress = isset($_POST['facilityaddress']) ? $_POST['facilityaddress'] : '';
		// $phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
		// $facilityshortcode = isset($_POST['facilityshortcode']) ? $_POST['facilityshortcode'] : '';
		// $facilitystart = isset($_POST['facilitystart']) ? $_POST['facilitystart'] : '';
		// $facilityend = isset($_POST['facilityend']) ? $_POST['facilityend'] : '';
		// $expirydate = isset($_POST['expirydate']) ? $_POST['expirydate'] : '';
		// $facilityrate = isset($_POST['facilityrate']) ? $_POST['facilityrate'] : '';
		// $facilitycode = isset($_POST['facilitycode']) ? $_POST['facilitycode'] : '';	
		// $adminfullname = isset($_POST['adminfullname']) ? $_POST['adminfullname'] : '';	
		// $adminusername = isset($_POST['adminusername']) ? $_POST['adminusername'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($form_number)  ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{		

				// assign services
                if (!empty($_POST["scheckboxserv"])) {
                    foreach ($_POST["scheckboxserv"] as $servikey) {
                        $facilityservice = explode('@@@', $servikey);
                        $facilityservicecode = $facilityservice['0'];
                        $facilityservicename = $facilityservice['1'];
                        $facilitybillable = $facilityservice['2'];
                        $facilityservicelevel = $facilityservice['3'];
                        //	die($servikey);
                        $assigncode = md5(microtime());
                        $assignservice = $facilitysql->setup_assignfacilityservices($assigncode, $facilityservicecode, $facilityservicename, $facilitybillable, $facilityservicelevel, $instcode, $currentuserinst, $day, $currentusercode, $currentuser);
                    }

                

                    if ($assignservice == '0') {
                        $status = "error";
                        $msg = "Add Facility Unsuccessful";
                    } elseif ($assignservice == '1') {
                        $status = "error";
                        $msg = "Facility Exist";
                    } elseif ($assignservice == '2') {
                        $event= " Add Facility Code :".$form_key."  ".$currentuserinst. "   has been saved successfully ";
                        $eventcode= 70;
                        $audittrail = $msql->auditlog($form_key, $form_number, $currentusercode, $currentuser, $currentusername, $instcode, $eventcode, $event, $day);
                        if ($audittrail == '2') {
                            $status = "success";
                            $msg = "Facilities Added Successfully";
                        } else {
                            $status = "error";
                            $msg = "Audit Trail Failed!";
                        }
                    } else {
                        $status = "error";
                        $msg = "Add Facility Unsuccessful ";
                    }
                }else{
					$status = "error";
					$msg = "Add Facility Services Unsuccessful. No service selected  ";
				}
			}
		}
	break;



	// 1 JAN 2020 
	case 'setup_addfacility': 

		$facilityname = isset($_POST['facilityname']) ? $_POST['facilityname'] : '';
		$facilityaddress = isset($_POST['facilityaddress']) ? $_POST['facilityaddress'] : '';
		$phonenumber = isset($_POST['phonenumber']) ? $_POST['phonenumber'] : '';
		$facilityshortcode = isset($_POST['facilityshortcode']) ? $_POST['facilityshortcode'] : '';
		$facilitystart = isset($_POST['facilitystart']) ? $_POST['facilitystart'] : '';
		$facilityend = isset($_POST['facilityend']) ? $_POST['facilityend'] : '';
		$expirydate = isset($_POST['expirydate']) ? $_POST['expirydate'] : '';
		$facilityrate = isset($_POST['facilityrate']) ? $_POST['facilityrate'] : '';
		$facilitycode = isset($_POST['facilitycode']) ? $_POST['facilitycode'] : '';	
		$adminfullname = isset($_POST['adminfullname']) ? $_POST['adminfullname'] : '';	
		$adminusername = isset($_POST['adminusername']) ? $_POST['adminusername'] : '';		
		$form_number = isset($_POST['form_number']) ? $_POST['form_number'] : '';
		$form_key = isset($_POST['form_key']) ? $_POST['form_key'] : '';		
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){

				if(empty($facilityname) || empty($facilityaddress) || empty($phonenumber) || empty($facilityshortcode) || empty($expirydate)  || empty($adminfullname) || empty($adminusername) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{

				$facilityname = strtoupper($facilityname);
				$facilityshortcode = strtoupper($facilityshortcode);
				$adminusername = $adminusername.'@'.$facilityshortcode ;            
				$pwdd = $hash = md5($adminusername . $facilityshortcode);
				$newuserkeyd = md5($adminusername . $form_key);	
				$adminfullname = strtoupper($adminfullname)	;	
				$ulevname = 'HOSPITAL ADMIN';
				$ulevcode = 40;		
				$setup_facilities = $facilitysql->setup_facilities($form_key,$facilityname,$facilityaddress,$phonenumber,$facilityshortcode,$facilitystart,$facilityend,$expirydate,$day,$facilityrate,$facilitycode,$adminusername,$adminfullname,$pwdd,$newuserkeyd,$ulevcode,$ulevname,$currentusercode,$currentuser);
				
				// assign shift types 
				foreach($_POST["scheckbox"] as $shiftkey){
					$shifttypes = explode('@@@',$shiftkey);
					$shifttypecode = $shifttypes['0'];
					$shifttypes = $shifttypes['1'];
					$assigncode = md5(microtime());
					$assignshifttypes = $facilitysql->setup_assignfacilities($assigncode,$shifttypecode,$shifttypes,$facilitycode,$facilityname,$day,$currentusercode,$currentuser);
				}

				
				// assign payment method
				foreach($_POST["scheckboxpaymethod"] as $paymethodkey){
					$facilitypaymethod = explode('@@@',$paymethodkey);
					$facilitypaymethodcode = $facilitypaymethod['0'];
					$facilitypaymethodname = $facilitypaymethod['1'];
					$assigncode = md5(microtime());
					$assignpaymentmethod = $facilitysql->setup_assignfaclilitypaymentmethod($assigncode,$facilitypaymethodcode,$facilitypaymethodname,$facilitycode,$facilityname,$day,$currentusercode,$currentuser);
				}


				// assign services
				foreach($_POST["scheckboxserv"] as $servikey){
					$facilityservice = explode('@@@',$servikey);
					$facilityservicecode = $facilityservice['0'];
					$facilityservicename = $facilityservice['1'];
					$facilitybillable = $facilityservice['2'];
					$facilityservicelevel = $facilityservice['3'];
				//	die($servikey);
					$assigncode = md5(microtime());
					$assignservice = $facilitysql->setup_assignfacilityservices($assigncode,$facilityservicecode,$facilityservicename,$facilitybillable,$facilityservicelevel,$facilitycode,$facilityname,$day,$currentusercode,$currentuser);
				}

				$receiptdetails = $facilitysql->setupreceiptdetails($facilitycode,$facilityname,$currentusercode,$currentuser);
				$inputusername = 'admin';
				$fullname = 'admin';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'SYSTEM ADMIN';
				$ulevcode = 40;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);

				$inputusername = 'records';
				$fullname = 'records';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'RECORDS OFFICER';
				$ulevcode = 1;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);
 
				$inputusername = 'cashier';
				$fullname = 'cashier';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'CASHIER';
				$ulevcode = 3;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);
				
				$inputusername = 'bills';
				$fullname = 'bills';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'BILLING OFFICER';
				$ulevcode = 2;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				$inputusername = 'nurse';
				$fullname = 'nurse';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'NURSE';
				$ulevcode = 4;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				$inputusername = 'doctor';
				$fullname = 'doctor';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'DOCTOR';
				$ulevcode = 5;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				$inputusername = 'labs';
				$fullname = 'labs';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'LABS';
				$ulevcode = 6;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				$inputusername = 'pharmacy';
				$fullname = 'pharmacy';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'PHARMACY';
				$ulevcode = 7;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				$inputusername = 'hospadmin';
				$fullname = 'hospital Admin';
				$inputusername = $inputusername.'@'.$facilityshortcode ;
				$ulevname = 'HOSPTIAL ADMIN';
				$ulevcode = 39;
				
				$pwd = $hash = md5($inputusername . $facilityshortcode);
				$newuserkey = md5($inputusername . $form_key);
				$form_key = md5(microtime());
				$setup_adduser = $facilitysql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$newuserkey,$facilitycode,$facilityname,$facilityshortcode,$ulevcode,$ulevname,$currentusercode,$currentuser);


				if($setup_facilities == '0'){					
					$status = "error";					
					$msg = "Add Facility Unsuccessful"; 
				}else if($setup_facilities == '1'){						
					$status = "error";					
					$msg = "Facility Exist"; 					
				}else if($setup_facilities == '2'){	
					$event= " Add Facility Code :".$form_key."  ".$facilityname. "   has been saved successfully ";
					$eventcode= 70;
					$audittrail = $msql->auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day);
						if($audittrail == '2'){
							$status = "success";
							$msg = "Facilities Added Successfully";
						}else{
							$status = "error";					
							$msg = "Audit Trail Failed!"; 
						}									
				}else{					
					$status = "error";					
					$msg = "Add Facility Unsuccessful ";					
				}
			}
		}
	break;


		
}

	// $facilitylist = ("SELECT * from octopus_setup_facilities where FAC_STATUS = '1' ");
	// $getfacilitylist = $dbconn->query($facilitylist);

	// $shifttypeslist = ("SELECT * from octopus_setup_shifttype where SHTY_STATUS = '1' ");
	// $getshifttypeslist = $dbconn->query($shifttypeslist);

	// $facilitypaymentmethodlist = ("SELECT * from octopus_setup_paymentmethod where PM_STATUS = '1' ");
	// $getpaymentmethodlist = $dbconn->query($facilitypaymentmethodlist);

	// $faclitiyserviceslist = ("SELECT * from octopus_setup_services where SE_STATUS = '1' ");
	// $getfaclitiyserviceslist = $dbconn->query($faclitiyserviceslist);
 

?>
