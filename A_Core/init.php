<?php	
	// require_once (LOGININTFILE) ;
	// REQUIRE_ONCE 'app_octopus_config.php';
	
	REQUIRE_ONCE (REQUIREONCEFILE)	;	
	$dbconn = $connection->dbconnect();
	$userdetails = $usertable->getcurrentuserdetails();		
	if($userdetails !== '-1'){		
		$usd = explode('@@@', $userdetails);
		$currentusercode = $usd[0];
		$currentuser = $usd[2];
		$currentusername = $usd[1];
		$currentuserlevel = intval($usd[3]);
		$currentuserlevelname = $usd[11];
		$currentusershortcode = $usd[4];
		$currentuserinst = $usd[10];
		$instcode = $usd[8];
		$userkey = $usd[6];
		$loginkey= $usd[7];
		$useraccesslevel= $usd[12];
		$currentuserspec= $usd[13];
		
		// echo 
		if($pg !== 10000){
			$checklogin = $usertable->checkloginstatus($loginkey,$userkey);
			if($checklogin <> intval(1)) {				
				$url = 'logout';
				$engine->redirect($url);
			}	
		}else{
			$url = 'logout';
			$engine->redirect($url);
		}
		if ($_SESSION['login'] <> '1'){
			$url = 'logout';
			$engine->redirect($url);
		}
		
		
		// if($currentuserlevel == '5' || $currentuserlevel == '8'){
		// 	//$msql->autoarchive($currentusercode,$currentuser,$instcode);
		// 	// check if doctor has totals 
		// 	$codtoryearstats = $msql->doctortotalstats($currentusercode,$currentuser,$instcode);
		// 	// check if the user has stats for the year 
		// 	$codtoryearstats = $msql->doctoryearlystats($currentusercode,$currentuser,$instcode);
		// 	// check if the user has stats for the month
		// 	$codtoryearstats = $msql->doctormonthlystats($currentusercode,$currentuser,$instcode);
		// 	// check if the user has stats for the day 
		// 	$codtordaystats = $msql->doctordaystats($currentusercode,$currentuser,$instcode);
		// 	// check doctor pending 
		// 	$pendingcount = $msql->getpendingcount($currentusercode,$thereviewday,$instcode);			

		// 	// diagnosis array
		// 	//$diagnosisicdlist[] = $lov->getdiagnosisicdcodes();
		// 	//die;
		// }		

		$currentdetails = $currenttable->getcurrentdetails($instcode);	

		if($currentdetails !== 0){			
			$usde = explode('@@@', $currentdetails);
			$currentshiftcode = $usde[0];
			$currentshift = $usde[1];
			$currentshifttype = $usde[2];
			$currentdate = $usde[3];
			$currentstaffpershift = $usde[4];	
			$currentconsultationduration = $usde[6];	
			$currentconsultationstart = $usde[7];	
			$currentconsultationend = $usde[8];	
			$currentconsultationdaysahead = $usde[9];	
			$currentappointmentnumber = $usde[10];
			$currentshiftstart = $usde[11];
			$currentshiftend = $usde[12];
			$currentlastcheck = $usde[13];
			$currentday = $usde[14];
			$currentweek = $usde[15];
			$currentmonth = $usde[16];
			$currentyear = $usde[17];
			$currenttime = date('H');		
		
			$autoshift = $shiftcontroller->automaticshiftday($day,$days,$currentdate,$currenttime,$currentshiftcode,$currentusercode,$currentuser,$instcode);
		
			if($autoshift == '2'){
				$currentdetails = $currenttable->getcurrentdetails($instcode);
				$usde = explode('@@@', $currentdetails);
				$currentshiftcode = $usde[0];
				$currentshift = $usde[1];
				$currentshifttype = $usde[2];
				$currentdate = $usde[3];
				$currentstaffpershift = $usde[4];	
				$currentconsultationduration = $usde[6];	
				$currentconsultationstart = $usde[7];	
				$currentconsultationend = $usde[8];	
				$currentconsultationdaysahead = $usde[9];	
				$currentappointmentnumber = $usde[10];
				$currentshiftstart = $usde[11];
				$currentshiftend = $usde[12];
				$currentlastcheck = $usde[13];
				$currentday = $usde[14];
				$currentweek = $usde[15];
				$currentmonth = $usde[16];
				$currentyear = $usde[17];
				$currenttime = date('H');
			}
			
			$currentcontroller->currentday($currentday,$currentmonth,$currentyear,$currentuser,$currentusercode,$instcode);
			$currentcontroller->currentmonth($currentmonth,$currentyear,$currentuser,$currentusercode,$instcode);
			$currentcontroller->currentyear($currentmonth,$currentyear,$currentuser,$currentusercode,$instcode);

			$locumstate = $locumcontroller->proceslocumschedule($currentshiftcode,$currentshift,$currentshifttype,$currentdate,$days,$currentday,$currentweek,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode);
			$patientvisittable->endpastvisits($day,$instcode);
			//	$msql->currentstats($currentday,$currentmonth,$currentyear,$currentuser,$currentusercode,$instcode);
			// //if shift is open
			// if($currentshiftcode !== '0'){
			// 	// check for the current time and compare if there is a startime in range 
			// 	$currenttime = date('H');
			// 	if($currentshiftend == $currenttime){
			// 		$msql->automaticcloseopenshift($day,$days,$currenttime,$currentshiftcode,$currentshiftstart,$currentshiftend,$currentusercode,$currentuser,$instcode);
			// 	}else{
			// 		return '2';
			// 	}			
			// }else{
			// 	$currenttime = date('H');
			// 	if($currenttime !== $currentlastcheck ){
			// 		$msql->automaticopenshift($day,$days,$currenttime,$currentusercode,$currentuser,$instcode);
			// 	}
			// }	
			
			$prepaidchemecode = $paymentschemetable->getprepaidchemecode($prepaidcode,$instcode);		
		//	$foreignserviceschemecode = $lov->getforeignserviceschemecode($foreignservicecode);	
			$cashschemecode = $paymentschemetable->getcashschemecode($cashpaymentmethodcode,$instcode);		
		//	$registrationsql->updatepatienttypes($instcode);
			if($currentuserlevel == 1){
				REQUIRE_ONCE (COREFOLDER.'autoloader_record.php');
			}

			

		}else{
			$currentshiftcode=$currentshifttype=$currentdate=$currentstaffpershift=$currentconsultationduration=$currentconsultationstart=$currentconsultationend= $currentshiftstart =$currentshiftend = -1;
			$currentshift = 'Shift Closed';
		}
	// }else if($userdetails == -1){
	// 	$url = 'login';		  
		//$engine->redirect($url);
	// }else{
	// 	die('Logout');
		// unset($_SESSION['username']);
		// unset($_SESSION['login']);
		// session_destroy();
		// // $db =null;
		// // $dbconn = null;
		// // $conn = null;
		// // $loginstate = '0';			
		// $url = 'login';		  
		// $engine->redirect($url);
		// exit;
	} 

	$vtype = $engine->getcurrentversion();
	$vt = explode('@@', $vtype);
	$versiontype = $vt[0];
	$versionname = $vt[1];
	$versiondate = $vt[2];
	
?>


