<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class pricing Extends Engine{

	// 15 NOV 2022 JOSEPH ADORBOE 
	public function getschemepercentage($paymentschemecode,$instcode){
		$one = 1;
		$sql = 'SELECT PSC_SCHEMEPERCENTAGE FROM octopus_paymentscheme WHERE PSC_CODE = ? AND PSC_INSTCODE = ? AND PSC_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $one);
	//	$st->BindParam(4, $one);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PSC_SCHEMEPERCENTAGE'];			
				return $price ; 			
			}else{
				return '0';
            }

        }else{
			return '0';
		}

	}


	// 15 JULY 2021 JOSEPH ADORBOE 
	public function getcashdollarprice($servicescode,$instcode,$cashschemecode,$exchangerate){		
		$one = 1;
		$sql = 'SELECT PS_DOLLARPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $cashschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
		if ($exrt) {
			if ($st->rowcount() > 0) {
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_DOLLARPRICE']*$exchangerate;
			//	$price = $obj['PS_DOLLARPRICE'];
				return $price ;
			} else {
				return '-1';
			}
		} else {
			return '0';
		}
			
		}

	// 06 NOV 2022 JOSEPH ADORBOE 
	public function privateinsuranceforeignprices($servicescode,$paymentmethodcode,$paymentschemecode,$exchangerate,$instcode){
		$one = 1;
		$sql = 'SELECT PS_DOLLARPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_DOLLARPRICE']*$exchangerate;			
				return $price ; 			
			}else{
				return '-1';
            }

        }else{
			return '0';
		}

	}

	// 06 NOV 2022 JOSEPH ADORBOE 
	public function getexchangerate(String $currency, String $day, String $instcode) : float {
		$one = 1; 		
		$sql = 'SELECT FOX_RATE FROM octopus_cashier_forex where FOX_CURRENCY = ? and date(FOX_DATE) = ? and FOX_INSTCODE = ? and FOX_STATUS = ? order by FOX_ID DESC';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $currency);
		$st->BindParam(2, $day);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
		if ($exrt) {
			if ($st->rowcount() > 0) {
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['FOX_RATE'];
				return $price ;
			} else {
				return '-1';
			}
		} else {
			return '-1';
		}	
	}
	

	// 15 JULY 2021 JOSEPH ADORBOE 
	public function getcashprice($paymentmethodcode,$paymentschemecode,$servicescode,$ptype,$instcodenuc,$instcode,$cashschemecode,$cashpaymentmethodcode){
	//	die($instcodenuc);
		$rat =  1;
		if($instcode == $instcodenuc){
			if($ptype == 'XP'){
				$sql = 'SELECT PS_ALTPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
                $st = $this->db->Prepare($sql);
                $st->BindParam(1, $cashschemecode);
                $st->BindParam(2, $servicescode);
                $st->BindParam(3, $instcode);
                $st->BindParam(4, $rat);
                $exrt = $st->execute();
                if ($exrt) {
                    if ($st->rowcount() > 0) {
                        $obj = $st->Fetch(PDO::FETCH_ASSOC);
                        $price = $obj['PS_ALTPRICE'];
                        return $price ;
                    } else {
                        return '-1';
                    }
                } else {
                    return '0';
                }

			}else{
                $sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
                $st = $this->db->Prepare($sql);
                $st->BindParam(1, $cashschemecode);
                $st->BindParam(2, $servicescode);
                $st->BindParam(3, $instcode);
                $st->BindParam(4, $rat);
                $exrt = $st->execute();
                if ($exrt) {
                    if ($st->rowcount() > 0) {
                        $obj = $st->Fetch(PDO::FETCH_ASSOC);
                        $price = $obj['PS_PRICE'];
                        return $price ;
                    } else {
                        return '-1';
                    }
                } else {
                    return '0';
                }
            }

		}else{

            $sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
            $st = $this->db->Prepare($sql);
            $st->BindParam(1, $cashschemecode);
            $st->BindParam(2, $servicescode);
            $st->BindParam(3, $instcode);
            $st->BindParam(4, $rat);
            $exrt = $st->execute();
            if ($exrt) {
                if ($st->rowcount() > 0) {
                    $obj = $st->Fetch(PDO::FETCH_ASSOC);
                    $price = $obj['PS_PRICE'];
                    return $price ;
                } else {
                    return '-1';
                }
            } else {
                return '0';
            }
        }
	}

	
	// 23 JUNE 2021 JOSEPH ADORBOE 
	public function partnercompaniesprices($servicescode, $paymentmethodcode, $paymentschemecode, $partnercompaniescode,$cashpaymentmethodcode,$instcode){
		$one = 1;
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYMENTMETHODCODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $paymentmethodcode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrted = $st->execute();
                if ($exrted) {
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];			
						return $price ; 			
					}else{
                        $sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYMENTMETHODCODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
                        $st = $this->db->Prepare($sql);
                        $st->BindParam(1, $cashpaymentmethodcode);
                        $st->BindParam(2, $servicescode);
                        $st->BindParam(3, $instcode);
						$st->BindParam(4, $one);
                        $exrted = $st->execute();
                        if ($exrted) {
                            if ($st->rowcount() > 0) {
                                $obj = $st->Fetch(PDO::FETCH_ASSOC);
                                $price = $obj['PS_PRICE'];
                                return $price ;
                            } else {
                                return '-1';
                            }
                        }
                    }

                }else{
					return '0';
				}
            }

        }else{
			return '0';
		}

	}
	

	// 22 JUNE 2021 JOSEPH ADORBOE 
	public function privateinsuranceprices($servicescode,$paymentmethodcode,$paymentschemecode,$instcode){
		$one = 1;
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
        if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				return '-1';
            }

        }else{
			return '0';
		}

	}

	// 12 JULY 2021 JOSEPH ADORBOE 
	public function gettheprice($paymentmethodcode, $paymentschemecode, $servicescode, $instcode, $cashschemecode,$cashpaymentmethodcode){
		$rat =  1;
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $rat);
		$exrt = $st->execute();
		if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? and PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $rat);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];						
						return $price ; 						
					}else{
						return '-1';

						// $sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYMENTMETHODCODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ?';
						// $st = $this->db->Prepare($sql);
						// $st->BindParam(1, $cashpaymentmethodcode);
						// $st->BindParam(2, $servicescode);
						// $st->BindParam(3, $instcode);
						// $exrted = $st->execute();
						// if($exrted){
						// 	if($st->rowcount() > 0){					
						// 		$obj = $st->Fetch(PDO::FETCH_ASSOC);
						// 		$price = $obj['PS_PRICE'];								
						// 		return $price ; 								
						// 	}else{
						// 		return '-1';
						// 	}
						// }else{
						// 	return '0';
						// }
					}
				}else{
					return '-5';
				}
			}
		}else{
			return '-4';
		}
	}

	
	public function getprice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc){
		$one = 1;
		if($instcode == $instcodenuc){
			if($ptype == 'XP'){
			//	if($ptype == 'XP' && $paymentschemecode == $cashschemecode){
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];						
						return $price ; 						
					}else{
						return '-1';						
					}
				}else{
					return '-2';
				}
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $paymentschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrt = $st->execute();
				if($exrt){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];			
						return $price ; 			
					}else{
						$sql = 'SELECT PS_PRICE FROM octopus_st_pricing WHERE PS_PAYSCHEMECODE = ? AND PS_ITEMCODE = ? AND PS_INSTCODE = ? AND PS_STATUS = ? ';
						$st = $this->db->Prepare($sql);
						$st->BindParam(1, $cashschemecode);
						$st->BindParam(2, $servicescode);
						$st->BindParam(3, $instcode);
						$st->BindParam(4, $one);
						$exrted = $st->execute();
						if($exrted){
							if($st->rowcount() > 0){			
								$obj = $st->Fetch(PDO::FETCH_ASSOC);
								$price = $obj['PS_PRICE'];						
								return $price ; 						
							}else{
								return '-1';
								
							}
						}else{
							return '-2';
						}
					}
				}else{
					return '-1';
				}
			}

		}else{
		
		$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ? ';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
		if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_PRICE'];			
				return $price ; 			
			}else{
				$sql = 'SELECT PS_PRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ? ';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_PRICE'];						
						return $price ; 						
					}else{
						return '-1';
						
					}
				}else{
					return '-2';
				}
			}
		}else{
			return '-1';
		}
	}
}

	public function getpartnerrice($paymentmethodcode,$paymentschemecode,$servicescode,$instcode,$cashschemecode,$ptype,$instcodenuc){
		$one = 1;
		if($instcode == $instcodenuc){
			if($ptype == 'XP'){
			//	if($ptype == 'XP' && $paymentschemecode == $cashschemecode){
				$sql = 'SELECT PS_OTHERPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_OTHERPRICE'];						
						return $price ; 						
					}else{
						return '-1';						
					}
				}else{
					return '-2';
				}
			}else{
				$sql = 'SELECT PS_OTHERPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $paymentschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrt = $st->execute();
				if($exrt){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_OTHERPRICE'];			
						return $price ; 			
					}else{
						$sql = 'SELECT PS_OTHERPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
						$st = $this->db->Prepare($sql);
						$st->BindParam(1, $cashschemecode);
						$st->BindParam(2, $servicescode);
						$st->BindParam(3, $instcode);
						$st->BindParam(4, $one);
						$exrted = $st->execute();
						if($exrted){
							if($st->rowcount() > 0){			
								$obj = $st->Fetch(PDO::FETCH_ASSOC);
								$price = $obj['PS_OTHERPRICE'];						
								return $price ; 						
							}else{
								return '-1';
								
							}
						}else{
							return '-2';
						}
					}
				}else{
					return '-1';
				}
			}
		}else{
		
		$sql = 'SELECT PS_OTHERPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
		$st = $this->db->Prepare($sql);
		$st->BindParam(1, $paymentschemecode);
		$st->BindParam(2, $servicescode);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$exrt = $st->execute();
		if($exrt){
			if($st->rowcount() > 0){			
				$obj = $st->Fetch(PDO::FETCH_ASSOC);
				$price = $obj['PS_OTHERPRICE'];			
				return $price ; 			
			}else{
				$sql = 'SELECT PS_OTHERPRICE FROM octopus_st_pricing where PS_PAYSCHEMECODE = ? and PS_ITEMCODE = ? and PS_INSTCODE = ? AND PS_STATUS = ?';
				$st = $this->db->Prepare($sql);
				$st->BindParam(1, $cashschemecode);
				$st->BindParam(2, $servicescode);
				$st->BindParam(3, $instcode);
				$st->BindParam(4, $one);
				$exrted = $st->execute();
				if($exrted){
					if($st->rowcount() > 0){			
						$obj = $st->Fetch(PDO::FETCH_ASSOC);
						$price = $obj['PS_OTHERPRICE'];						
						return $price ; 						
					}else{
						return '-1';
						
					}
				}else{
					return '-2';
				}
			}
		}else{
			return '-1';
		}
	}
	
	}



	
	 
}

