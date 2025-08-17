<?php
	REQUIRE_ONCE (INTFILE);	
	$setuppromotionmodel = isset($_POST['setuppromotionmodel']) ? $_POST['setuppromotionmodel'] : '';

	switch ($setuppromotionmodel)
	{

		// 24 DEC 2024, JOSEPH ADROBOE
		case 'addnewpromotion':
			$promotiontitle = htmlspecialchars(isset($_POST['promotiontitle']) ? $_POST['promotiontitle'] : '');
			$startdate = htmlspecialchars(isset($_POST['startdate']) ? $_POST['startdate'] : '');
			$enddate = htmlspecialchars(isset($_POST['enddate']) ? $_POST['enddate'] : '');
			$promotiontype = htmlspecialchars(isset($_POST['promotiontype']) ? $_POST['promotiontype'] : '');
			$promotionservice = htmlspecialchars(isset($_POST['promotionservice']) ? $_POST['promotionservice'] : '');
			$unitprice = htmlspecialchars(isset($_POST['unitprice']) ? $_POST['unitprice'] : '');
			$totalprice = htmlspecialchars(isset($_POST['totalprice']) ? $_POST['totalprice'] : '');		
			$promotionqty = htmlspecialchars(isset($_POST['promotionqty']) ? $_POST['promotionqty'] : '');
			$promotionterms = htmlspecialchars(isset($_POST['promotionterms']) ? $_POST['promotionterms'] : '');
			$promotionvalidity = htmlspecialchars(isset($_POST['promotionvalidity']) ? $_POST['promotionvalidity'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);	
			// $engine->getactionkey($form_number,$form_key);			
			if($preventduplicate == '1'){
				if (empty($promotiontitle) || empty($startdate) || empty($enddate) || empty($promotiontype)|| empty($promotionservice)|| empty($unitprice)|| empty($totalprice)|| empty($promotionqty) || empty($promotionterms) || empty($promotionvalidity)) {
						$status = 'error';
						$msg = 'Required Field Cannot be empty';                      
					} else {  										
						if (!empty($promotionservice)) {							
							$pset = explode('@@@', $promotionservice);
							$servicecode = $pset[0];
							$servicename = $pset[1];                       
						} else {
							$servicecode = $servicename = '';
						}
						$promotioncode = md5(microtime());
						$sqlresults = $promotionsetuptable->addnewpromotion($promotioncode,$promotiontitle,$startdate,$enddate,$day,$promotiontype,$servicecode,$servicename,$unitprice,$totalprice,$promotionqty,$promotionterms,$promotionvalidity,$currentusercode,$currentuser,$instcode);                      
						if($sqlresults == '2'){
							$cash = 'CASH';
							$pricingtable->setcashprices($itemcode=$servicecode,$item=$servicename,$newprice=$unitprice,$alternateprice=$unitprice,$dollarprice='0.00',$partnerprice=$unitprice,$cashpricecode=md5(microtime()),$category='1',$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);                       
						}                       
						$result = $engine->getresults($sqlresults,$item=$promotiontitle,$action);
						$re = explode(',', $result);
						$status = $re[0];					
						$msg = $re[1];
						$event= "$action: $form_key $msg";
						$eventcode=9749;
						$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					                     
					}
			}
		break;	
		// 24 DEC 2024 ,  JOSEPH ADORBOE  
		case 'editsetuppromotion': 
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$promotiontitle = htmlspecialchars(isset($_POST['promotiontitle']) ? $_POST['promotiontitle'] : '');
			$startdate = htmlspecialchars(isset($_POST['startdate']) ? $_POST['startdate'] : '');
			$enddate = htmlspecialchars(isset($_POST['enddate']) ? $_POST['enddate'] : '');
			$promotiontype = htmlspecialchars(isset($_POST['promotiontype']) ? $_POST['promotiontype'] : '');
			$promotionservice = htmlspecialchars(isset($_POST['promotionservice']) ? $_POST['promotionservice'] : '');
			$unitprice = htmlspecialchars(isset($_POST['unitprice']) ? $_POST['unitprice'] : '');
			$totalprice = htmlspecialchars(isset($_POST['totalprice']) ? $_POST['totalprice'] : '');		
			$promotionqty = htmlspecialchars(isset($_POST['promotionqty']) ? $_POST['promotionqty'] : '');
			$promotionterms = htmlspecialchars(isset($_POST['promotionterms']) ? $_POST['promotionterms'] : '');
			$promotionstatus = htmlspecialchars(isset($_POST['promotionstatus']) ? $_POST['promotionstatus'] : '');
			$promotionvalidity = htmlspecialchars(isset($_POST['promotionvalidity']) ? $_POST['promotionvalidity'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);	
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($promotiontitle) || empty($startdate) || empty($enddate) || empty($promotiontype)|| empty($promotionservice)|| empty($unitprice)|| empty($totalprice)|| empty($promotionqty) || empty($promotionterms)  || empty($promotionvalidity)){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{								
					if (!empty($promotionservice)) {							
						$pset = explode('@@@', $promotionservice);
						$servicecode = $pset[0];
						$servicename = $pset[1];                       
					} else {
						$servicecode = $servicename = '';
					}
					$sqlresults = $promotionsetuptable->editpromotion($ekey,$promotiontitle,$startdate,$enddate,$promotiontype,$servicecode,$servicename,$unitprice,$totalprice,$promotionqty,$promotionterms,$promotionstatus,$promotionvalidity,$currentusercode,$currentuser,$instcode);
					if($sqlresults == '2'){
						$cash = 'CASH';
						$pricingtable->setcashprices($itemcode=$servicecode,$item=$servicename,$newprice=$unitprice,$alternateprice=$unitprice,$dollarprice='0.00',$partnerprice=$unitprice,$cashpricecode=md5(microtime()),$category='1',$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);                       
					}  
					$action = 'Edit Promotion';							
					$result = $engine->getresults($sqlresults,$item=$promotiontitle,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=9748;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);   
				}
			}
		break;
	

	} 
?>
