<?php
	REQUIRE_ONCE (INTFILE);
	REQUIRE_ONCE 'model.php';	
	$consumablesmodel = htmlspecialchars(isset($_POST['consumablesmodel']) ? $_POST['consumablesmodel'] : '');
	$dept = 'OPD';
	Global $instcode;
	
	// 6 AUG 2023 JOSEPH ADORBOE 
	switch ($consumablesmodel)
	{
		
		// 12 JAN 2022  JOSEPH ADORBOE  
		case 'editwards':
			$ekey = htmlspecialchars(isset($_POST['ekey']) ? $_POST['ekey'] : '');
			$wardname = htmlspecialchars(isset($_POST['wardname']) ? $_POST['wardname'] : '');
			$wardgender = htmlspecialchars(isset($_POST['wardgender']) ? $_POST['wardgender'] : '');
			$warerate = htmlspecialchars(isset($_POST['warerate']) ? $_POST['warerate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');		
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);		
			if($preventduplicate == '1'){
				if(empty($ekey) || empty($wardname) ){
					$status = "error";
					$msg = "Required Fields cannot be empty ";
				}else{											
					$sqlresults = $wardsql->editwards($ekey,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);					
					$action = 'Ward Edit';							
					$result = $engine->getresults($sqlresults,$item=$wardname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=100;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);					
				}
			}

		break;	
		// 8 AUG 2023 , 12 JAN 2022 JOSPH ADORBOE 
		case 'addwards':			
			$wardname = htmlspecialchars(isset($_POST['wardname']) ? $_POST['wardname'] : '');
			$wardgender = htmlspecialchars(isset($_POST['wardgender']) ? $_POST['wardgender'] : '');
			$warerate = htmlspecialchars(isset($_POST['warerate']) ? $_POST['warerate'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($wardname) || empty($wardgender) || empty($warerate)){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{
					$wardname = strtoupper($wardname);			
					$sqlresults = $wardsql->addwards($form_key,$wardname,$wardgender,$warerate,$currentuser,$currentusercode,$instcode);
					$title = 'Add Ward';
					$action = 'Ward Bed Added';							
					$result = $engine->getresults($sqlresults,$item=$wardname,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=100;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);
				}
			}

		break;

		// 5 NOV 2023,  JOSEPH ADORBOE 
		case 'addnewconsumablefully':			
			$consumable = htmlspecialchars(isset($_POST['consumable']) ? $_POST['consumable'] : '');
			$description = htmlspecialchars(isset($_POST['description']) ? $_POST['description'] : '');
			$storeqty = htmlspecialchars(isset($_POST['storeqty']) ? $_POST['storeqty'] : '');
			$transferqty = htmlspecialchars(isset($_POST['transferqty']) ? $_POST['transferqty'] : '');
			$costprice = htmlspecialchars(isset($_POST['costprice']) ? $_POST['costprice'] : '');
			$cashprice = htmlspecialchars(isset($_POST['cashprice']) ? $_POST['cashprice'] : '');
			$insuranceprice = htmlspecialchars(isset($_POST['insuranceprice']) ? $_POST['insuranceprice'] : '');
			$dollarprice = htmlspecialchars(isset($_POST['dollarprice']) ? $_POST['dollarprice'] : '');
			$partnerprice = htmlspecialchars(isset($_POST['partnerprice']) ? $_POST['partnerprice'] : '');
			$category = htmlspecialchars(isset($_POST['category']) ? $_POST['category'] : '');
			$restock = htmlspecialchars(isset($_POST['restock']) ? $_POST['restock'] : '');
			$alternateprice = htmlspecialchars(isset($_POST['alternateprice']) ? $_POST['alternateprice'] : '');
			$expire = htmlspecialchars(isset($_POST['expire']) ? $_POST['expire'] : '');
			$form_number = htmlspecialchars(isset($_POST['form_number']) ? $_POST['form_number'] : '');
			$form_key = htmlspecialchars(isset($_POST['form_key']) ? $_POST['form_key'] : '');
			$preventduplicate = $userformlogtable->checkformactionkey($form_number,$form_key,$currentusercode);			
			if($preventduplicate == '1'){
				if(empty($consumable) ){
					$status = 'error';
					$msg = 'Required Field Cannot be empty';				
				}else{	
					$consumablenumber = date('his');
					$consumable = strtoupper($consumable);	
					$alternateprice = $partnerprice	= '0.00';
					$transferqty = $qty = 0;	
					$totalqty = $storeqty+$transferqty+$qty;
					$stockvalue = $totalqty*$cashprice;
					$sqlresults = $consumablesetuptable->newconsumable($form_key,$consumable,$consumablenumber,$restock,$days,$description,$storeqty,$costprice,$cashprice,$dollarprice,$partnerprice,$alternateprice,$insuranceprice,$transferqty,$qty,$totalqty,$stockvalue,$currentuser,$currentusercode,$instcode);									
					$action = "Add consumable";
					if($sqlresults =='2'){

					}
					$result = $engine->getresults($sqlresults,$item=$consumable,$action);
					$re = explode(',', $result);
					$status = $re[0];					
					$msg = $re[1];
					$event= "$action: $form_key $msg";
					$eventcode=388;
					$usereventlogtable->auditlog($form_key,$form_number,$currentusercode,$currentuser,$instcode,$eventcode,$event,$days);				
				}
			}	
		break;
		
	}	

?>
