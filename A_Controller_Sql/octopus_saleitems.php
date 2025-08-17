<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 21 FEB 2024
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_saleitems
	$saleitemstable->getsoldtoday($instcode)
*/

class OctopusSaleItemsSql Extends Engine{

	// 21 FEB 2024, JOSEPH ADORBOE 
	public function getsoldtoday($instcode){
		$list = ("SELECT SUM(SI_QTY) as SOLD, SUM(SI_TOTAMT) AS TOT , SI_STOCK , SI_UNITPRICE FROM octopus_saleitems WHERE SI_STATUS = '2' AND SI_INSTCODE = '$instcode' group by SI_STOCKCODE "); 
		return $list;              
	}
	// 1 FEB 2024, JOSEPH ADORBOE 
	public function getsolditemslist($searchitem,$currentshiftcode,$instcode){
		if(empty($searchitem)){
			$list = ("SELECT SI_STOCKCODE,SI_STOCK,SUM(SI_QTY) AS QTY , sum(SI_TOTAMT) AS TOT ,SI_UNITPRICE,SI_ACTOR FROM octopus_saleitems WHERE SI_STATUS = '2' AND SI_INSTCODE = '$instcode' AND SI_SHIFTCODE = '$currentshiftcode' GROUP BY SI_STOCKCODE order by SI_STOCK desc limit 500");                                                                            
		} else{
			$list = ("SELECT SI_STOCKCODE,SI_STOCK,SUM(SI_QTY) AS QTY , sum(SI_TOTAMT) AS TOT ,SI_UNITPRICE,SI_ACTOR FROM octopus_saleitems WHERE SI_STATUS = '2' AND SI_INSTCODE = '$instcode' AND SI_SHIFTCODE = '$searchitem' GROUP BY SI_STOCKCODE order by SI_STOCK desc limit 500"); 
		}
		
		return $list;     
	}

	// 22 FEB 2024, JOSEPH ADORBOE 
	public function getsalesitemsrecepit($salecode,$instcode){
		$list = ("SELECT * FROM octopus_saleitems WHERE SI_STATUS = '1' AND SI_INSTCODE = '$instcode' AND SI_SALECODE = '$salecode' order by SI_ID desc limit 50"); 
		return $list;              
	}
	
	// 31 JAN 2024, JOSEPH ADORBOE 
	public function getsalesitems($salecode,$instcode){
		$list = ("SELECT * FROM octopus_saleitems WHERE SI_STATUS = '1' AND SI_INSTCODE = '$instcode' AND SI_SALECODE = '$salecode' order by SI_ID desc limit 50"); 
		return $list;              
	}
	
	// 26 MAR 2023  JOSEPH ADORBOE 
	public function update_closesalesitems($salecode,$instcode){
		$one = 1;
		$two =2;			
		$sql = "UPDATE octopus_saleitems SET SI_STATUS = ?  WHERE SI_SALECODE = ? AND SI_INSTCODE = ? AND SI_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $two);
		$st->BindParam(2, $salecode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}		
	}

	// 26 MAR 2023  JOSEPH ADORBOE 
	public function removesaleitem($ekey,$salescode,$instcode){
		$one = 1;
		$zero = '0';		
		$sql = "UPDATE octopus_saleitems SET SI_STATUS = ?  WHERE SI_CODE = ? AND SI_INSTCODE = ?  AND SI_SALECODE = ? AND SI_STATUS = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $ekey);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $salescode);
		$st->BindParam(5, $one);
		$exe = $st->Execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
		
	}
	
	// 31 JAN 2024, 26 MAR 2023  JOSEPH ADORBOE 
	public function insert_newsale($form_key,$productcode,$salecode,$product,$productqty,$productprice,$productshiftcode,$productshift,$saleqty,$saleamt,$days,$productunit,$currentusercode,$currentuser,$instcode){
		$one = 1;
		// $two = 2;
		$zero = '0';	
		$sqlstmt = ("SELECT * FROM octopus_saleitems WHERE SI_STOCKCODE = ? AND SI_STATUS = ? AND SI_INSTCODE = ? AND SI_SALECODE = ?");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $productcode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $salecode);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > '0'){
				return 1;
			}else{
			//	$salecode = md5(microtime());				
				$sqlstmt = "INSERT INTO octopus_saleitems (SI_CODE,SI_SALECODE,SI_DATE,SI_DATETIME,SI_STOCKCODE,SI_STOCK,SI_QTY,SI_UNITPRICE,SI_TOTAMT,SI_BQTY,SI_SHIFT,SI_SHIFTCODE,SI_ACTOR,SI_ACTORCODE,SI_INSTCODE,SI_UNIT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$st = $this->db->Prepare($sqlstmt);
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $salecode);
				$st->BindParam(3, $days);
				$st->BindParam(4, $days);
				$st->BindParam(5, $productcode);	
				$st->BindParam(6, $product);
				$st->BindParam(7, $saleqty);	
				$st->BindParam(8, $productprice);
				$st->BindParam(9, $saleamt);
				$st->BindParam(10, $productqty);
				$st->BindParam(11, $productshift);
				$st->BindParam(12, $productshiftcode);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $productunit);				
				$exeuser = $st->Execute();
				if($exeuser){
					return '2';
				}else{
					return '0';
				}
			}
		}else{
			return '0';
		}
	}

	// 25 Jan 2024,  JOSEPH ADORBOE 
	public function getsaletotal($shiftcode,$instcode){
		$one = 1;
		$two = 2;
		$zero = '0';	
		if($shiftcode !== 'NA'){
			$sqlstmt = ("SELECT sum(SI_TOTAMT) AS TOT FROM octopus_saleitems WHERE SI_STATUS = ? AND SI_INSTCODE = ? AND SI_SHIFTCODE = ?");
			$st = $this->db->prepare($sqlstmt);
			$st->BindParam(1, $two);
			$st->BindParam(2, $instcode);
			$st->BindParam(3, $shiftcode);
			$expt = $st->execute();
			if($expt){
				if($st->rowcount() > '0'){
					$obj = $st->fetch(PDO::FETCH_ASSOC);			
					$value= intval($obj['TOT']) ;
					return $value;
				}else{
					return '0';				
				}
			}else{
				return '0';
			}
		}else{
			return '0';
		} 
	}
			
}
$saleitemstable =  new OctopusSaleItemsSql();
?>
