<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';
	
	$finacialreportsmodel = htmlspecialchars(isset($_POST['finacialreportsmodel']) ? $_POST['finacialreportsmodel'] : '');
	$dept = 'IPD';

	Global $instcode; 
	
	// 4 SEPT 2024 , JOSEPH ADORBOE  
	switch ($finacialreportsmodel)
	{

		// 4 SEPT 2024 JOSPH ADORBOE
		case 'revenuereportstats': 			
		$statstype = htmlspecialchars(isset($_POST['statstype']) ? $_POST['statstype'] : '');	
		$fromdate = htmlspecialchars(isset($_POST['fromdate']) ? $_POST['fromdate'] : '');	
		$todate = htmlspecialchars(isset($_POST['todate']) ? $_POST['todate'] : '');		
		$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
		$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
		$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
		if($preventduplicate == '1'){
			if($currentshiftcode == '0'){			
				$status = "error";
				$msg = "Shift is closed";				
			}else{
				if(empty($statstype)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{					
						if($statstype == 1){
							if(empty($fromdate) || empty($todate)){
								$status = "error";
								$msg = "Required Fields Month cannot be empty ";
							}else{
							
								$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;

								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);	
							}								
						}else if($statstype == 2){
							if(empty($fromdate) || empty($todate)){
								$status = "error";
								$msg = "Required Fields Month cannot be empty ";
							}else{
							
								$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;
								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);	
							}		
							
						}else if($statstype == 3){
							$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

								$to = explode('/', $todate);
								$tomonth = $to[0];
								$today = $to[1];
								$toyear = $to[2];
								$todate = $toyear.'-'.$tomonth.'-'.$today;
							
								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);

						}else if($statstype == 4){
								$from = explode('/', $fromdate);
									$frommonth = $from[0];
									$fromday = $from[1];
									$fromyear = $from[2];
									$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;

									$to = explode('/', $todate);
									$tomonth = $to[0];
									$today = $to[1];
									$toyear = $to[2];
									$todate = $toyear.'-'.$tomonth.'-'.$today;
								
									$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
									$msql->passingvalues($pkey=$form_key,$value);					
									$url = "report__allrevenuepdf?$form_key";
									$engine->redirect($url);	
									
						}else if($statstype == 5 || $statstype == 6 || $statstype == 7 || $statstype == 8 || $statstype == 9 || $statstype == 10 || $statstype == 11 ){
									$from = explode('/', $fromdate);
										$frommonth = $from[0];
										$fromday = $from[1];
										$fromyear = $from[2];
										$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;
	
										$to = explode('/', $todate);
										$tomonth = $to[0];
										$today = $to[1];
										$toyear = $to[2];
										$todate = $toyear.'-'.$tomonth.'-'.$today;
									
										$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
										$msql->passingvalues($pkey=$form_key,$value);					
										$url = "report__allrevenuepdf?$form_key";
										$engine->redirect($url);	
						
						}else if($statstype == 12){
							if(empty($fromdate) || empty($todate)){
								$status = "error";
								$msg = "Required Fields Month cannot be empty ";
							}else{
								$from = explode('/', $fromdate);
								$frommonth = $from[0];
								$fromday = $from[1];
								$fromyear = $from[2];
								$fromdate = $fromyear.'-'.$frommonth.'-'.$fromday;	
								$to = explode('/', $todate);
										$tomonth = $to[0];
										$today = $to[1];
										$toyear = $to[2];
										$todate = $toyear.'-'.$tomonth.'-'.$today;
								$value = $statstype.'@@@'.$fromdate.'@@@'.$todate;
								$msql->passingvalues($pkey=$form_key,$value);					
								$url = "report__allrevenuepdf?$form_key";
								$engine->redirect($url);
							}	
								}						
							}
						}
					}
		break;

	}

?>
