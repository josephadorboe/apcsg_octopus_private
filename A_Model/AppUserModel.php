<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	$Usersmodel = htmlspecialchars(isset($_POST['Usersmodel']) ? $_POST['Usersmodel'] : '');
	
		// 6 AUG 2023
	switch ($Usersmodel)
	{
		// 06 AUG 2023 02 JAN 2021
		case 'setup_addsetupusers':
				$inputusername = htmlspecialchars(isset($_POST['inputusername']) ? $_POST['inputusername'] : '');
				$fullname = htmlspecialchars(isset($_POST['fullname']) ? $_POST['fullname'] : '');
				$theuserlevel = htmlspecialchars(isset($_POST['theuserlevel']) ? $_POST['theuserlevel'] : '');
				$facility = htmlspecialchars(isset($_POST['facility']) ? $_POST['facility'] : '');
				$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');					
				$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');			
				$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
				$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
				if($preventduplicate == '1'){				
					if(empty($inputusername)  || empty($fullname) || empty($theuserlevel) || empty($facility)){
						$status = "error";
						$msg = "Required Fields cannot be empty ";
					}else{					
						$fac = explode('@@@', $facility);
						$faccode = $fac['0'];
						$facname = $fac['1'];
						$facsname = $fac['2'];
						$ulev = explode('@@@', $theuserlevel);
						$ulevcode = $ulev['0'];
						$ulevname = $ulev['1'];
						$inputusername = $inputusername.'@'.$facsname ;				
						$pwd = $hash = md5($inputusername . $facsname);
						$newuserkey = md5($inputusername . $form_key);		
									
					$getresults = $userssql->setupinsert_users($form_key,$inputusername,$fullname,$pwd,$nowday,$newuserkey,$faccode,$facname,$facsname,$ulevcode,$ulevname,$currentusercode,$currentuser);	
					$action = 'Admin User Added';							
					$result = $engine->getresults($sqlresults,$item=$fullname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=3;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}
			}
		break;
		// 6 AUG 2023, 30 DEC 2020
		case 'changepassword':
				$newpassword = htmlspecialchars(isset($_POST['newpassword']) ? $_POST['newpassword'] : '');
				$confirmpassword = htmlspecialchars(isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '');
				$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
				$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
				$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
				if($preventduplicate == '1'){
				if(empty($newpassword) || empty($confirmpassword)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{
					if($newpassword != $confirmpassword){
						$status = "error";
						$msg = "Passwords dont march  ";
					}else{
						if(strlen($newpassword) < 12){
							$status = "error";
							$msg = "Passwords MUST be more than 12 characters ";
						}else{
							$sqlresults = $userssql->updatepassword($newpassword, $userkey, $currentusername);
							$action = 'Change Password';							
							$result = $engine->getresults($sqlresults,$item=$fullname,$action);
							$re = explode(',', $result);
							$status = $re[0];					
							$msg = $re[1];
							$event= "$action: $form_key $msg";
							$eventcode=3;
							$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);							
						}			
					}				
				}
			}
		break;
		// 06 AUG 2023, 02 JAN 2021
		case 'disableuser':
			$inputusername = htmlspecialchars(isset($_POST['inputusername']) ? $_POST['inputusername'] : '');
			$shortcode = htmlspecialchars(isset($_POST['shortcode']) ? $_POST['shortcode'] : '');
			$fullname = htmlspecialchars(isset($_POST['fullname']) ? $_POST['fullname'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($inputusername)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
					$sqlresults = $userssql->update_disable($currentusercode,$currentuser,$ekey);
					$action = 'Disable User';							
					$result = $engine->getresults($sqlresults,$item=$fullname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=88;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
					}				
			}
		break;	
		// 06 AUG 2023 , 02 JAN 2021
		case 'edituser': 
			$inputusername = htmlspecialchars(isset($_POST['inputusername']) ? $_POST['inputusername'] : '');
			$shortcode = htmlspecialchars(isset($_POST['shortcode']) ? $_POST['shortcode'] : '');
			$fullname = htmlspecialchars(isset($_POST['fullname']) ? $_POST['fullname'] : '');
			$theuserlevel = htmlspecialchars(isset($_POST['theuserlevel']) ? $_POST['theuserlevel'] : '');
			$speclevel = htmlspecialchars(isset($_POST['speclevel']) ? $_POST['speclevel'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($fullname) || empty($speclevel)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
						$ulev = explode('@@@', $theuserlevel);
						$ulevcode = $ulev['0'];
						$ulevname = $ulev['1'];
						$slevel = explode('@@@', $speclevel);
						$slevcode = $slevel['0'];
						$slevname = $slevel['1'];
						$sqlresults = $userssql->update_user($ekey,$fullname,$ulevcode,$ulevname,$slevcode,$slevname,$currentusercode,$currentuser,$instcode);
						$action = 'Edit User';							
						$result = $engine->getresults($sqlresults,$item=$fullname,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=87;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}			
			}
		break;
		// 6 AUG 2023 , 02 JAN 2021
		case 'resetpassword':
			$inputusername = htmlspecialchars(isset($_POST['inputusername']) ? $_POST['inputusername'] : '');
			$shortcode = htmlspecialchars(isset($_POST['shortcode']) ? $_POST['shortcode'] : '');
			$fullname = htmlspecialchars(isset($_POST['fullname']) ? $_POST['fullname'] : '');
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($inputusername)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
					$newpd = '#$'.$shortcode.'@'.date('mY'); 
					$pwd = $hash = md5($inputusername . $newpd);			
					$sqlresults = $userssql->update_resetpassword($pwd,$currentusercode,$currentuser,$ekey);
					$action = 'Reset Password';							
					$result = $engine->getresults($sqlresults,$item=$fullname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=86;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
				}			
			}
		break;
		// 6 AUG 2023 02 JAN 2021
		case 'addusers':
			$inputusername = htmlspecialchars(isset($_POST['inputusername']) ? $_POST['inputusername'] : '');
			$fullname = htmlspecialchars(isset($_POST['fullname']) ? $_POST['fullname'] : '');
			$theuserlevel = htmlspecialchars(isset($_POST['theuserlevel']) ? $_POST['theuserlevel'] : '');
			$specs = htmlspecialchars(isset($_POST['specs']) ? $_POST['specs'] : '');
			$currentshiftcode = htmlspecialchars(isset($_POST['currentshiftcode']) ? $_POST['currentshiftcode'] : '');			
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');			
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);
			if($preventduplicate == '1'){
				if($currentshiftcode == '0'){
					$status = "error";
					$msg = "Shift is closed";				
				}else{
				if(empty($inputusername)  || empty($fullname) || empty($theuserlevel) || empty($specs)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{			
				$inputusername = $inputusername.'@'.$currentusershortcode ;            
				$newpd = '#$'.$currentusershortcode.'@'.date('mY'); 		
				$pwd = $hash = md5($inputusername . $newpd);
				$newuserkey = md5($inputusername . $form_key);			
				$userl = explode('@@@', $theuserlevel);
				$userlecode = $userl['0'];
				$userlename = $userl['1'];			
				$sp = explode('@@@', $specs);
				$specscode = $sp['0'];
				$specsname = $sp['1'];			
				$sqlresults = $userssql->insert_newusers($form_key,$inputusername,$fullname,$pwd,$nowday,$newuserkey,$currentusershortcode,$currentusercode,$currentuser,$instcode,$userlecode,$userlename,$currentuserinst,$specscode,$specsname);	
				$action = 'New Users Added';							
				$result = $engine->getresults($sqlresults,$item=$fullname,$action);
				$re = explode(',', $result);
				$status = $re[0];					
				$msg = $re[1];
				$event= "$action: $form_key $msg";
				$eventcode=89;
				$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days); 			
			}			
		}
		}
		break;		
	}
?>
