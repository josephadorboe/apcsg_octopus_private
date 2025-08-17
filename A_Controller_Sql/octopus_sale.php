<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 21 FEB 2024
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_sale
	$saletable->update_dispensenewsale($salecode,$instcode)
*/

class OctopusSaleSql Extends Engine{

	// 22 FEB 2024, JOSEPH ADORBOE 
	public function getsalepaid($instcode){
		$list = ("SELECT * FROM octopus_sale WHERE NS_STATUS = '2' AND NS_INSTCODE = '$instcode' ORDER BY NS_ID ASC limit 50"); 
		return $list;              
	}

	// 22 FEB 2024
	public function getsalepaidcounts(String $instcode)
	{
		$sql = "SELECT NS_ID FROM octopus_sale WHERE NS_INSTCODE = '$instcode' AND NS_STATUS = '2' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$transfercount  = $st->rowCount();
		return $transfercount;      
	}

	// 22 FEB 2024,  JOSEPH ADORBOE 
	public function getsaledetails($salecode,$instcode){
		$two = 2;			
		$sqlstmt = ("SELECT * FROM octopus_sale WHERE NS_CODE = ? AND NS_INSTCODE = ? AND NS_STATUS = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $salecode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $two);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > '0'){
				$obj = $st->fetch(PDO::FETCH_ASSOC);			
				$value= $obj['NS_DTIME'].'@@'.$obj['NS_AMT'].'@@'.$obj['NS_AMTPAID'].'@@'.$obj['NS_CHANGE'].'@@'.$obj['NS_PAYMETHOD'].'@@'.$obj['NS_PAYDATE'].'@@'.$obj['NS_PAYACTOR'].'@@'.$obj['NS_NUMBER'];
				return $value;
			}else{
				return '0';				
			}
		}else{
			return '0';
		}
	
	}
	// 31 JAN 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function update_dispensenewsale($salecode,$instcode){
		$three = 3;
		$two = 2;
		$sql = "UPDATE octopus_sale SET NS_STATUS = ?  WHERE NS_CODE = ? AND NS_INSTCODE = ? AND  NS_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $three);
		$st->BindParam(2, $salecode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $two);
		$exe = $st->Execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}
	// 22 FEB 2024, JOSEPH ADORBOE 
	public function update_closesales($salecode,$method,$days,$amountpaid,$change,$currentusercode,$currentuser,$instcode){
		$two =2;			
		$sql = "UPDATE octopus_sale SET NS_AMTPAID = ?, NS_CHANGE = ?, NS_STATUS = ?, NS_PAYDATE = ?, NS_PAYACTOR = ? , NS_PAYACTORCODE = ? ,NS_PAYMETHOD = ? WHERE NS_CODE = ? AND NS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $amountpaid);
		$st->BindParam(2, $change);
		$st->BindParam(3, $two);
		$st->BindParam(4, $days);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $method);
		$st->BindParam(8, $salecode);
		$st->BindParam(9, $instcode);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}
	
	// 1 FEB 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function removesale($productprice,$salescode,$instcode){
		$sql = "UPDATE octopus_sale SET NS_AMT = NS_AMT - ?  WHERE NS_CODE = ? AND NS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $productprice);
		$st->BindParam(2, $salescode);
		$st->BindParam(3, $instcode);
		$exe = $st->Execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}
	
	// 31 JAN 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function update_newsale($salecode,$saleamt,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_sale SET NS_AMT = NS_AMT + ?  WHERE NS_CODE = ? AND NS_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $saleamt);
		$st->BindParam(2, $salecode);
		$st->BindParam(3, $instcode);
		$exe = $st->Execute();	
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}
		
	// 26 MAR 2023  JOSEPH ADORBOE 
	public function getsaleamount($salecode,$instcode){
		$one = 1;
		$zero = '0';	
		$sqlstmt = ("SELECT * FROM octopus_sale WHERE NS_CODE = ? AND NS_STATUS = ? AND NS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $salecode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > '0'){
				$obj = $st->fetch(PDO::FETCH_ASSOC);			
				$value= $obj['NS_AMT'] ;
				return $value;			
			}else{
				return '0';
			}
		}else{
			return '0';
		}
	}
	
	// 31 JAN 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function getsalecode($productshiftcode,$productshift,$days,$currentusercode,$currentuser,$instcode){
		$one = 1;
		// $two = 2;
		$zero = '0';	
		$sqlstmt = ("SELECT * FROM octopus_sale WHERE NS_SHIFTCODE = ? AND NS_STATUS = ? AND NS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $productshiftcode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > '0'){
				$obj = $st->fetch(PDO::FETCH_ASSOC);			
				$value= $obj['NS_CODE'] ;
				return $value;
			}else{
				$salescode = md5(microtime());	
				$salenumber = rand(100,10000);			
				$sqlstmt = "INSERT INTO octopus_sale (NS_CODE,NS_DTIME,NS_DT,NS_AMT,NS_ACTOR,NS_ACTORCODE,NS_AMTPAID,NS_SHIFT,NS_SHIFTCODE,NS_INSTCODE,NS_NUMBER) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
				$st = $this->db->Prepare($sqlstmt);
				$st->BindParam(1, $salescode);
				$st->BindParam(2, $days);
				$st->BindParam(3, $days);
				$st->BindParam(4, $zero);
				$st->BindParam(5, $currentuser);	
				$st->BindParam(6, $currentusercode);
				$st->BindParam(7, $zero);	
				$st->BindParam(8, $productshift);
				$st->BindParam(9, $productshiftcode);
				$st->BindParam(10, $instcode);
				$st->BindParam(11, $salenumber);				
				$exeuser = $st->Execute();				
				if($exeuser){
					return $salescode;
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}
	}
			
}
$saletable =  new OctopusSaleSql();
?>
