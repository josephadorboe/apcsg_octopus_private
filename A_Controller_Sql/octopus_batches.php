<?php
/*	AUTHOR: JOSEPH ADORBOE
	DATE: 9 NOV 2023
	PURPOSE: TO OPERATE MYSQL QUERY
	Base : 	octopus_batches
	$batchestable->reverse_newbatches($batchcode,$instcode)
*/

class OctopusBatchesSql Extends Engine{

	// 26 NOV 2024 , JOSEPH ADORBOE 
	public function reverse_newbatches($batchcode,$instcode){
		$one = '1';
		$sqlstmt = ("DELETE * FROM octopus_batches WHERE BATCH_CODE = ? AND  BATCH_INSTCODE = ?  AND BATCH_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $batchcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 14 NOV 2022, JOSEPH ADORBOE
	public function editbatchpending($batchcode,$qtyleft,$expiry,$qtysupplied,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_QTYSUPPLIED = ?, BATCH_QTY = ?, BATCH_EXPIRY = ?, BATCH_ACTOR = ?, BATCH_ACTORCODE = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qtysupplied);
		$st->BindParam(2, $qtyleft);
		$st->BindParam(3, $expiry);
		$st->BindParam(4, $currentuser);
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $batchcode);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}

	// 14 FEB 2024, JOSEPH ADORBOE
	public function getallbatchitemlist($idvalue,$instcode){
		$zero = '0';
		$list = ("SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' and BATCH_STATUS = '1' AND BATCH_ITEMCODE = '$idvalue'  AND BATCH_QTY > '$zero' order by BATCH_EXPIRY ASC  ");
		return $list;
	}
	// 14 FEB 2024, JOSEPH ADORBOE
	public function getbatchlist($idvalue,$instcode){
		$list = ("SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' and BATCH_STATUS = '1' AND BATCH_ITEMCODE = '$idvalue'  order by BATCH_ID ASC ");
		return $list;
	}
	// 13 NOV 2023 JOSEPH ADORBOE
	public function getquerybatch($instcode){
		$list = ("SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' and BATCH_QTY > '0' AND BATCH_STATUS IN('0','1','2','3')  order by BATCH_ID DESC ");
		return $list;
	}
	// 9 NOV 2023 JOSEPH ADORBOE
	public function getquerybatchreport($idvalue,$instcode){
		$list = ("SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' and BATCH_STATUS = '1' AND BATCH_ITEMCODE = '$idvalue'  order by BATCH_ID DESC ");
		return $list;
	}

	
	// 25 MAR 2024, JOSEPH ADORBOE 
	public function gettotalbatchqtyonly($itemcode,$instcode){
		$one = 1;
		$zero = '0';		
		$sql = " SELECT SUM(BATCH_QTY) AS TOTALQTY FROM octopus_batches WHERE BATCH_ITEMCODE = ? AND BATCH_STATUS = ? AND BATCH_INSTCODE = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $itemcode);	
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);	
		$ext = $st->execute();
		if($ext){	
			if($st->rowcount()>'0'){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['TOTALQTY'];				
				return $value;
			}else{
				return '-1';
			}
		}else{
			return '0';
		}							
	}
	// 27 MAR 2024 JOSEPH ADORBOE 
	public function returntosupplierbatchprocess($batchcode,$qty,$state,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $state);
		$st->BindParam(3, $batchcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';			
		}else{
			return '0';
		}	
	}
	// 28 MAR 2024 JOSEPH ADORBOE 
	public function transferbulkbatchprocess($itemcode,$addqty,$instcode){
		//	echo "<br />itemcode : {$itemcode}, qty :{$addqty}  <br />";		
		$batches = [];
		$zero = '0';
		$one = 1;
		$sql = " SELECT * FROM octopus_batches WHERE BATCH_ITEMCODE = ? AND BATCH_STATUS = ? AND BATCH_INSTCODE = ?  AND BATCH_QTY > ? order by BATCH_EXPIRY ASC "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $itemcode);	
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);	
		$st->BindParam(4, $zero);	
		$ext = $st->execute();
		if($ext){
			if($st->rowcount()>0){
				while($obj = $st->fetch(PDO::FETCH_ASSOC))
				$batches[] = $obj;	
			//	var_dump($batches);	
				
				$bal =  $addqty;
				$rem = 0;
				foreach($batches as $batch){
					$batchqty = $batch['BATCH_QTY'];
					$batchcode = $batch['BATCH_CODE'];	
					if($batchqty > $bal){
						$qty = $bal;
						$rem = 0;
						$state = 1;
					}else if($batchqty == $bal){
						$qty = $bal;
						$rem = 0;
						$state = 2;
					}
					else{
						$qty = $batchqty;
						$rem = $bal - $batchqty;
						$state = 2;
					}								
					//	echo "<br />batch qty : {$batchqty}, batch balance:{$bal} , batch code:{$batchcode} , state:{$state} , rem:{$rem}  <br />";
											
					//	echo "<br />qty : {$qty}, rem : {$rem} <br />";	
						$one = 1;
						$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ?, BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $qty);
						$st->BindParam(2, $qty);
						$st->BindParam(3, $state);
						$st->BindParam(4, $batchcode);
						$st->BindParam(5, $instcode);
						$st->BindParam(6, $one);
						$exe = $st->execute();
						if($exe){
							$bal= $rem;	
							if($bal == 0){
								return '2';		
								break;	
							}
							return '2';			
						}else{
							$bal= $rem;	
							if($bal == 0){
								return '0';
								break;	
							}
							return '0';
						}			
					//	echo "<br />batch qty : {$batchqty}, batch balance:{$bal} , batch code:{$batchcode}  <br />";	
					//	die;							
					}	
			//	echo $one;
			}else{
				return '0';
			}
			
		}else{
			return '0';
		}
	}
		// 		$bal = $transferqty;
		// 		echo "<br />start balance : {$bal} <br />";
		// 		foreach($batches as $batch){
		// 			$batchqty = $batch['BATCH_QTY'];
		// 			$batchcode = $batch['BATCH_CODE'];					
		// 			if($bal >= $batchqty){						
		// 				echo "<br />batchcode : {$batchcode}, batch balance:{$batchqty}  <br />";
		// 			//	echo "batch qty: {$batchqty} <br />";	
		// 			//	die;					
		// 				$state = 1;
		// 				$rem = $bal-$batch['BATCH_QTY'];
		// 				echo $rem;
		// 				echo $bal;						
		// 				die;
		// 				if($rem >=$zero){
		// 					$qty = $batch['BATCH_QTY'];
		// 					$bal = $rem;
		// 					$state = 2;
		// 				}else{
		// 					$bal = $bal-$batch['BATCH_QTY'];
		// 					$state = 1;
		// 				}
		// 				echo "remaining balance : {$rem} <br />";
		// 				if($rem >'0'){
		// 					$state = 1;
		// 				}
		// 				$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ?, BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		// 				$st = $this->db->prepare($sql);
		// 				$st->BindParam(1, $qty);
		// 				$st->BindParam(2, $qty);
		// 				$st->BindParam(3, $state);
		// 				$st->BindParam(4, $batchcode);
		// 				$st->BindParam(5, $instcode);
		// 				$st->BindParam(6, $one);
		// 				$exe = $st->execute();
		// 				if($exe){
		// 					if($rem >'0'){
		// 						$bal = $bal-$batch['BATCH_QTY'];
		// 					}else{
		// 						$bal = $bal-$batch['BATCH_QTY'];
		// 					}
							
		// 				}else{
		// 					$bal = '0';
		// 				}						
		// 			// 	}else if($bal == $batchqty){
		// 			// 	echo "equal no balance   <br />";	
		// 			}else{
		// 				// transfer qty less than batch qty 
		// 				echo "<br />batchcode : {$batchcode}, batch balance:{$batchqty}  <br />";
		// 				$rem = $bal-$batchqty;
		// 				$qty = $batchqty;
		// 				$state = 2;
		// 				$bal = $rem ;
		// 				echo $rem;
		// 				echo $bal;	
		// 			//	echo $bal;

		// 				// $sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ?, BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		// 				// $st = $this->db->prepare($sql);
		// 				// $st->BindParam(1, $qty);
		// 				// $st->BindParam(2, $qty);
		// 				// $st->BindParam(3, $state);
		// 				// $st->BindParam(4, $batchcode);
		// 				// $st->BindParam(5, $instcode);
		// 				// $st->BindParam(6, $one);
		// 				// $exe = $st->execute();
		// 				// if($exe){
		// 				// 	if($rem >'0'){
		// 				// 		$bal = $bal-$batch['BATCH_QTY'];
		// 				// 	}else{
		// 				// 		$bal = $bal-$batch['BATCH_QTY'];
		// 				// 	}
							
		// 				// }else{
		// 				// 	$bal = '0';
		// 				// }			
		// 			}			
		// 		}
		// 		//	$i = 1;					
		// 		//	echo "balance : {$batch['BATCH_QTY']} <br />";
		// 		// 	while ($bal>'0') {
		// 		// 		echo "balance : {$batch['BATCH_QTY']} <br />";
		// 		// 	//	$bal = $bal-$obj['BATCH_QTY'];
		// 		// //	$i++;
		// 		// 	}			
		// 		die;
		// 	}else{
		// 		return '0';
		// 	}
		// }else{
		// 	return '0';
		// }		

		// // if($st->rowcount() > '0'){
		// // 	$obj = $st->fetch(PDO::FETCH_ASSOC);				
		// // 	$value = $obj['BATCH_QTY'];				
		// // 	return $value;
		// // }else{
		// // 	return '00';
		// // }
		// // while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		// // 	$batches = $obj;
		// // }
		// // return $batches;
		// // var_dump($ext);
		// // die;
		// return $batches;

	// }

	// 30 MAR 2024 JOSEPH ADORBOE 
	public function setbatchprocessornull($batchprocessorcode,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_PROCESSORCODE = ? WHERE BATCH_PROCESSORCODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ?  ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $batchprocessorcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';			
		}else{
			return '0';
		}		
	}

	// 30 MAR 2024 JOSEPH ADORBOE 
	public function setbatchprocessor($batchcode,$batchprocessorcode,$instcode){
		$one  = 1;
		$sql = "UPDATE octopus_batches SET BATCH_PROCESSORCODE = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $batchprocessorcode);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';			
		}else{
			return '0';
		}		
	}
	// 23 MAR 2024 JOSEPH ADORBOE 
	public function transferbatchprocess($batchcode,$qty,$state,$instcode){
		$one = 1;
		//	echo "<br />batchcode : {$batchcode}, qty :{$qty}  <br />";
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ?, BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $qty);
		$st->BindParam(3, $state);
		$st->BindParam(4, $batchcode);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $one);
		$exe = $st->execute();
		if($exe){
			return '2';			
		}else{
			return '0';
		}		
		
	}
	// 27 MAR 2024 JOSEPH ADORBOE
	public function getbatchlistlov($itemcode,$instcode)
	{
		$sql = " SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' AND BATCH_ITEMCODE  = '$itemcode' AND BATCH_QTY > 0 AND BATCH_STATUS = '1' order by BATCH_EXPIRY ASC LIMIT 20"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
	//	echo '<option value= 0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['BATCH_CODE'].'@@@'.$obj['BATCH_NUMBER'].'@@@'.$obj['BATCH_QTY'].'@@@'.$obj['BATCH_EXPIRY'].'">'.$obj['BATCH_EXPIRY'].' - Batch: '.$obj['BATCH_NUMBER'].' - Qty: '.$obj['BATCH_QTY'].' </option>';
		}			
	}
	// 25 MAR 2024, JOSEPH ADORBOE 
	public function gettotalbatchqty($days,$itemcode,$itemname,$category,$qty,$expire,$stockvalue,$cashprice,$costprice,$currentuser,$currentusercode,$instcode){
		$one = 1;
		$zero = '0';
		$sql = " SELECT * FROM octopus_batches WHERE BATCH_ITEMCODE = ? AND BATCH_STATUS = ? AND BATCH_INSTCODE = ?  AND BATCH_QTY > ? order by BATCH_EXPIRY ASC "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $itemcode);	
		$st->BindParam(2, $one);
		$st->BindParam(3, $instcode);	
		$st->BindParam(4, $zero);	
		$ext = $st->execute();
		if($ext){
			if($st->rowcount()>'0'){
				$sql = " SELECT SUM(BATCH_QTY) AS TOTALQTY FROM octopus_batches WHERE BATCH_ITEMCODE = ? AND BATCH_STATUS = ? AND BATCH_INSTCODE = ? "; 
				$st = $this->db->prepare($sql); 
				$st->BindParam(1, $itemcode);	
				$st->BindParam(2, $one);
				$st->BindParam(3, $instcode);	
				$ext = $st->execute();
				if($ext){	
					if($st->rowcount()>'0'){
						$obj = $st->fetch(PDO::FETCH_ASSOC);				
						$value = $obj['TOTALQTY'];				
						return $value;
					}else{
						return '-1';
					}
				}else{
					return '0';
				}

			}else{
				if($qty > $zero){				
				$batchcode = md5(microtime());
				$batchnumber = rand(100,10000);
				$batchdescription = 'Automatic Batch';
				$sqlstmt = "INSERT INTO octopus_batches(BATCH_CODE,BATCH_NUMBER,BATCH_DATE,BATCH_ITEMCODE,BATCH_ITEM,BATCH_CATEGORY,BATCH_QTYSUPPLIED,BATCH_QTYTRANSFERED,BATCH_QTY,BATCH_COSTPRICE,BATCH_CASHPRICE,BATCH_STOCKVALUE,BATCH_ACTOR,BATCH_ACTORCODE,BATCH_INSTCODE,BATCH_EXPIRY,BATCH_DESC)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $batchcode);
				$st->BindParam(2, $batchnumber);
				$st->BindParam(3, $days);
				$st->BindParam(4, $itemcode);
				$st->BindParam(5, $itemname);
				$st->BindParam(6, $category);
				$st->BindParam(7, $qty);
				$st->BindParam(8, $zero);
				$st->BindParam(9, $qty);
				$st->BindParam(10, $costprice);
				$st->BindParam(11, $cashprice);
				$st->BindParam(12, $stockvalue);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $expire);
				$st->BindParam(17, $batchdescription);
				$exe = $st->execute();
				if($exe){
					return $qty;
				}else{
					return '-1';
				}	
			}else{
				return $zero;
			}		
			}
		}else{
			return '0';
		}					
	}
	//2 JAN 2024,  JOSEPH ADORBOE
    public function addnewbatches($batchcode,$batchnumber,$days,$itemcode,$itemname,$category,$qtysupplied,$qtyleft,$batchdescription,$expire,$currentuser,$currentusercode,$instcode){
		$zero = '0';		
		$sqlstmt = "INSERT INTO octopus_batches(BATCH_CODE,BATCH_NUMBER,BATCH_DATE,BATCH_ITEMCODE,BATCH_ITEM,BATCH_CATEGORY,BATCH_QTYSUPPLIED,BATCH_QTYTRANSFERED,BATCH_QTY,BATCH_COSTPRICE,BATCH_CASHPRICE,BATCH_STOCKVALUE,BATCH_ACTOR,BATCH_ACTORCODE,BATCH_INSTCODE,BATCH_EXPIRY,BATCH_DESC)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $batchcode);
		$st->BindParam(2, $batchnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemname);
		$st->BindParam(6, $category);
		$st->BindParam(7, $qtysupplied);
		$st->BindParam(8, $zero);
		$st->BindParam(9, $qtyleft);
		$st->BindParam(10, $zero);
		$st->BindParam(11, $zero);
		$st->BindParam(12, $zero);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $expire);
		$st->BindParam(17, $batchdescription);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 2 JAN 2024 JOSEPH ADORBOE
	public function enablebatch($batchcode,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $zero);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 2 JAN 2024,  JOSEPH ADORBOE
	public function editbatchqty($batchcode,$qtyleft,$qtysupplied,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_QTYSUPPLIED = ?, BATCH_QTY = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qtysupplied);
		$st->BindParam(2, $qtyleft);
		$st->BindParam(3, $batchcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 4 APR 2024, JOSEPH ADORBOE
	public function approvebatch($batchcode,$instcode){
		$one = 1;
		$three = 3;
		$sql = "UPDATE octopus_batches SET BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $three);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 4 APR 2024, JOSEPH ADORBOE
	public function deletebatch($batchcode,$instcode){
		$one = 1;
		$zero = '0';
		$delete = 4;
		$sql = "UPDATE octopus_batches SET BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $delete);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 8 DEC 2023, JOSEPH ADORBOE
	public function disablebatch($batchcode,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_STATUS = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $batchcode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 12 NOV 2023, JOSEPH ADORBOE
	public function editbatch($batchcode,$qtyleft,$batchdescription,$expiry,$qtysupplied,$currentusercode,$currentuser,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_QTYSUPPLIED = ?, BATCH_QTY = ?, BATCH_EXPIRY = ?,  BATCH_DESC = ?, BATCH_ACTOR = ?, BATCH_ACTORCODE = ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qtysupplied);
		$st->BindParam(2, $qtyleft);
		$st->BindParam(3, $expiry);
		$st->BindParam(4, $batchdescription);
		$st->BindParam(5, $currentuser);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $batchcode);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 9 NOV 2023, JOSEPH ADORBOE
	public function reducebatchqtysupplier($batchcode,$qty,$instcode){
		$one = 1;
		$zero = '0';
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $batchcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 9 NOV 2023,   JOSEPH ADORBOE
	public function increasebatchqty($batchcode,$qty,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY + ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED - ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $qty);
		$st->BindParam(3, $batchcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 5 DEC 2023, JOSEPH ADORBOE
	public function returntosupplierbatchnumberqty($batchnumber,$qty,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ? WHERE BATCH_NUMBER = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $batchnumber);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 9 NOV 2023, JOSEPH ADORBOE
	public function reducebatchnumberqty($batchnumber,$qty,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ? WHERE BATCH_NUMBER = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $qty);
		$st->BindParam(3, $batchnumber);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 19 NOV 2023, JOSEPH ADORBOE
	public function returntostoresreducebatchnumberqty($batchnumber,$qty,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY + ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED - ? WHERE BATCH_NUMBER = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $qty);
		$st->BindParam(3, $batchnumber);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	// 9 NOV 2023, JOSEPH ADORBOE
	public function reducebatchqty($batchcode,$qty,$instcode){
		$one = 1;
		$sql = "UPDATE octopus_batches SET BATCH_QTY = BATCH_QTY - ?, BATCH_QTYTRANSFERED = BATCH_QTYTRANSFERED + ? WHERE BATCH_CODE = ? AND BATCH_INSTCODE = ? AND BATCH_STATUS = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $qty);
		$st->BindParam(2, $qty);
		$st->BindParam(3, $batchcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $one);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	//4 APR 2024, ,  JOSEPH ADORBOE
    public function newbatchespending($form_key,$batchnumber,$days,$itemcode,$itemname,$category,$costprice,$cashprice,$qty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$stockvalue = $cashprice*$qty;
		$three = 3;
		$sqlstmt = "INSERT INTO octopus_batches(BATCH_CODE,BATCH_NUMBER,BATCH_DATE,BATCH_ITEMCODE,BATCH_ITEM,BATCH_CATEGORY,BATCH_QTYSUPPLIED,BATCH_QTYTRANSFERED,BATCH_QTY,BATCH_COSTPRICE,BATCH_CASHPRICE,BATCH_STOCKVALUE,BATCH_ACTOR,BATCH_ACTORCODE,BATCH_INSTCODE,BATCH_DESC,BATCH_EXPIRY,BATCH_STATUS)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $batchnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemname);
		$st->BindParam(6, $category);
		$st->BindParam(7, $qty);
		$st->BindParam(8, $zero);
		$st->BindParam(9, $qty);
		$st->BindParam(10, $costprice);
		$st->BindParam(11, $cashprice);
		$st->BindParam(12, $stockvalue);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $batchdescription);
		$st->BindParam(17, $expire);
		$st->BindParam(18, $three);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
	//9 NOV 2023,  JOSEPH ADORBOE
    public function newbatches($form_key,$batchnumber,$days,$itemcode,$itemname,$category,$costprice,$cashprice,$qty,$batchdescription,$expire,$currentuser,$currentusercode,$instcode){
		$zero = '0';
		$stockvalue = $cashprice*$qty;
		$sqlstmt = "INSERT INTO octopus_batches(BATCH_CODE,BATCH_NUMBER,BATCH_DATE,BATCH_ITEMCODE,BATCH_ITEM,BATCH_CATEGORY,BATCH_QTYSUPPLIED,BATCH_QTYTRANSFERED,BATCH_QTY,BATCH_COSTPRICE,BATCH_CASHPRICE,BATCH_STOCKVALUE,BATCH_ACTOR,BATCH_ACTORCODE,BATCH_INSTCODE,BATCH_DESC,BATCH_EXPIRY)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $batchnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $itemcode);
		$st->BindParam(5, $itemname);
		$st->BindParam(6, $category);
		$st->BindParam(7, $qty);
		$st->BindParam(8, $zero);
		$st->BindParam(9, $qty);
		$st->BindParam(10, $costprice);
		$st->BindParam(11, $cashprice);
		$st->BindParam(12, $stockvalue);
		$st->BindParam(13, $currentuser);
		$st->BindParam(14, $currentusercode);
		$st->BindParam(15, $instcode);
		$st->BindParam(16, $batchdescription);
		$st->BindParam(17, $expire);
		$exe = $st->execute();
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}
}
$batchestable =  new OctopusBatchesSql();
?>
