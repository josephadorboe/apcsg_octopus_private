<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class SetupConsumablesController Extends Engine{

	// 23 JULY 2023 JOSEPH ADORBOE 
	public function approvebulkconsumablerestock($ajustcode,$itemcode,$addqty,$costprice,$newprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode,$consumablesetuptable,$stockadjustmenttable){	
		$consu = $consumablesetuptable->updateconsumable($itemcode,$addqty,$costprice,$newprice,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
		$vt = $consumablesetuptable->calculatestockvalue($itemcode,$instcode);
		$exe = $stockadjustmenttable->approvebulkconsumablerestock($ajustcode,$instcode);				
		if($exe == '2' && $vt == '2' && $consu == '2'){	
			return '2';			
		}else{			
			return '0';			
		}				
	}

	// 12 NOV 2023, JOSEPH ADORBOE
	public function editbulkrestockconsumable($ekey,$batchnumber,$suppliedqty,$costprice,$cashprice,$dollarprice,$insuranceprice,$instcode,$stockadjustmenttable,$batchestable){
		
		$restock  = $stockadjustmenttable->editstockadjustmentpending($ekey,$suppliedqty,$costprice,$cashprice,$insuranceprice,$dollarprice,$instcode);
		if($restock == '2'){			
			$batch = $batchestable->editbatch($batchnumber,$suppliedqty,$instcode);						
			return '2';
		}else{
			return '0';
		}	
	}	

	// 12 NOV 2023, JOSEPH ADORBOE
	public function bulkrestockconsumable($batchnumber,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$dollarprice,$category,$insuranceprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$stockadjustmenttable,$expirytable,$batchestable){
		
		$restock  = $stockadjustmenttable->newstockadjustmentpending($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode);
		if($restock == '2'){
			$batchcode = md5(microtime());
			$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$category,$costprice,$cashprice,$suppliedqty,$currentuser,$currentusercode,$instcode);
			$expy = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$currentuser,$currentusercode,$instcode);			
			return '2';
		}else{
			return '0';
		}	
	}	

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function returnconsumablestosupplier($batchnumber,$batchcode,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newtotalqty,$totalqty,$newstoreqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$description,$stockvalue,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$consumablesetuptable,$stockadjustmenttable,$batchestable){	
		$trans  = $stockadjustmenttable->newstockadjustmenttosupplier($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtotalqty,$totalqty,$unit,$type,$batchnumber,$description,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode);

		$com = $consumablesetuptable->returnconsumabletosupplier($newstoreqty,$newtotalqty,$stockvalue,$itemcode,$instcode);		
		
		$batch = $batchestable->reducebatchqtysupplier($batchcode,$suppliedqty,$instcode);	
		if($com == '2' && $trans  =='2' && $batch == '2'){
			return '2';
		}else{
			return '0';
		}		
	}

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function returnconsumablestostore($batchnumber,$batchcode,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newqty,$storeqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$consumablesetuptable,$stockadjustmenttable,$batchestable){	
		$com = $consumablesetuptable->returnconsumabletostore($suppliedqty,$itemcode,$instcode);
		
		$trans  = $stockadjustmenttable->newstockadjustmentreturn($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$type,$batchnumber,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode);
		$batch = $batchestable->increasebatchqty($batchcode,$suppliedqty,$instcode);	
		if($com == '2' && $trans  =='2' && $batch == '2'){
			return '2';
		}else{
			return '0';
		}		
	}
	

	// 10 NOV 2023 JOSEPH ADORBOE 
	public function transferconsumablestopharmacy($batchnumber,$batchcode,$type,$suppliedqty,$item,$itemcode,$itemnumber,$newstoreqty,$newtransferqty,$ajustcode,$adjustmentnumber,$days,$unit,$expire,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$consumablesetuptable,$stockadjustmenttable,$batchestable){	
		$com = $consumablesetuptable->transferconsumabletopharmacy($suppliedqty,$itemcode,$instcode);
		$trans  = $stockadjustmenttable->newstockadjustmenttransfer($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newtransferqty,$newstoreqty,$unit,$type,$batchnumber,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode);
		$batch = $batchestable->reducebatchqty($batchcode,$suppliedqty,$instcode);	
		if($com == '2' && $trans  =='2' && $batch == '2'){
			return '2';
		}else{
			return '0';
		}		
	}
	
	// 9 NOV 2023, JOSEPH ADORBOE
	public function restockconsumable($ekey,$type,$batchnumber,$cash,$suppliedqty,$item,$itemcode,$itemnumber,$storeqty,$itemqty,$newqty,$expire,$expirycode,$ajustcode,$adjustmentnumber,$days,$unit,$costprice,$newprice,$cashprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$category,$cashschemecode,$cashpaymentmethodcode,$cashpaymentmethod,$cashpricecode,$insuranceprice,$currentusercode,$currentuser,$currentshiftcode,$currentshift,$instcode,$stockadjustmenttable,$consumablesetuptable,$expirytable,$pricingtable,$batchestable){
		$restock  = $stockadjustmenttable->newstockadjustment($ajustcode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$newqty,$storeqty,$unit,$costprice,$newprice,$batchnumber,$insuranceprice,$dollarprice,$currentshift,$currentshiftcode,$expire,$currentuser,$currentusercode,$instcode);
		if($restock == '2'){
			$batchcode = md5(microtime());
			$batch = $batchestable->newbatches($batchcode,$batchnumber,$days,$itemcode,$item,$category,$costprice,$cashprice,$suppliedqty,$currentuser,$currentusercode,$instcode);
			$consu = $consumablesetuptable->restockconsumable($itemcode,$newqty,$costprice,$newprice,$totalqty,$stockvalue,$alternateprice,$partnerprice,$dollarprice,$insuranceprice,$instcode);
			$expy = $expirytable->newexpiry($expirycode,$adjustmentnumber,$days,$itemcode,$itemnumber,$item,$suppliedqty,$expire,$currentuser,$currentusercode,$instcode);
			$cprice = $pricingtable->setcashprices($itemcode,$item,$newprice,$alternateprice,$dollarprice,$partnerprice,$cashpricecode,$category,$cash,$cashschemecode,$cashpaymentmethod,$cashpaymentmethodcode,$currentusercode,$currentuser,$instcode);
			$inprice = $pricingtable->updateinsuranceprices($cashpaymentmethodcode,$itemcode,$insuranceprice,$dollarprice,$instcode, $currentusercode, $currentuser);
			
			return '2';
		}else{
			return '0';
		}	
	}	
} 
?>