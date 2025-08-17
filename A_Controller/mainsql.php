<?php
/*
	AUTHOR: JOSEPH ADORBOE
	DATE: 18 FEB 2021
	PURPOSE: TO OPERATE MYSQL QUERY 	
*/

class mainsql Extends Engine{
	// 29 JULY 2023 ,  JOSEPH ADORBOE
    public function getservicecover($itemcode,$schemecode,$scheme,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and  PS_PAYSCHEMECODE = ? and  PS_STATUS = ? AND PS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemcode);
		$st->BindParam(2, $schemecode);
		$st->BindParam(3, $one);
		$st->BindParam(4, $instcode);
		$check = $st->execute();
		if($check){
			if($st->rowcount() > 0){			
				return '1';			
			}else{
				return '0';
			}
		}else{
			return '0';
		}	
	}

	// 29 MAR 2023 JOSEPH ADORBOE 
	public function getpdfdetail($instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_admin_receiptdetails where RP_INSTCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);				
				$results = $object['RP_INSTNAME'].'@'.$object['RP_PHONENUM'].'@'.$object['RP_EMAIL'].'@'.$object['RP_LOGO'].'@'.$object['RP_PIN'].'@'.$object['RP_CAPTION'];				
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	

	
	// 29 MAR 2023 JOSEPH ADORBOE 
	public function getpatientbillingdetails($idvalue,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where  B_INSTCODE = ? AND B_VISITCODE = ?  limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $idvalue);	
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_VISITCODE'].'@'.$object['B_PATIENTNUMBER'].'@'.$object['B_PATIENT'].'@'.$object['B_DT'].'@'.$object['B_PAYSCHEME'].'@'.$object['B_PATIENTCODE'].'@'.$object['B_PAYSCHEMECODE'];
				
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	

	
	// 19 MAR 2023 , JOSEPH ADORBOE 
	public function getreferaldetails($idvalue){		
		$st = $this->db->prepare("SELECT * FROM octopus_patients_referal WHERE RF_CODE = ?");   
		$st->BindParam(1, $idvalue);
		$st->execute();
		if($st->rowcount()>0){
		$obj = $st->fetch(PDO::FETCH_ASSOC);	
	
		$value = $obj['RF_CODE'].'@@@'.$obj['RF_NUMBER'].'@@@'.$obj['RF_PATIENTCODE'].'@@@'.$obj['RF_PATIENTNUM'].'@@@'.$obj['RF_PATIENT'].'@@@'.$obj['RF_GENDER'].'@@@'.$obj['RF_AGE'].'@@@'.$obj['RF_DATE'].'@@@'.$obj['RF_HISTORY'].'@@@'.$obj['RF_FINDINGS'].'@@@'.$obj['RF_DIAGNOSIS'].'@@@'.$obj['RF_TREATMENT'].'@@@'.$obj['RF_REMARKS'].'@@@'.$obj['RF_VITALSNUM'].'@@@'.$obj['RF_INTRO'].'@@@'.$obj['RF_ACTOR'].'@@@'.$obj['RF_SPECIALITY'];
		
		return $value ;			
		}else{				
			return '-1';				
		}			
			
	}

	// 11 DEC 2022 JOSEPH ADORBOE 
	public function doctorstatsdetails($idvalue,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_stats_doctors_monthly where MS_CODE = ? and MS_INSTCODE = ? AND MS_STATUS = ?  limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
	//	$st->BindParam(4, $currentusercode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MS_DOCTOR'].'@'.$object['MS_STARTDATE'].'@'.$object['MS_ENDDATE'].'@'.$object['MS_TOTALCONSULTATION'].'@'.$object['MS_CONSULTATIONAMOUNT'].'@'.$object['MS_MONTH'].'@'.$object['MS_DOCTORCODE'];
				//.'@'.$object['SALS_PROCEDURESNUMS'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	

	// 2 DEC 2022 JOSEPH ADORBOE 
	public function processdoctorstatsmonthlyfinance($formkey,$mcode,$mtitle,$myear,$mstart,$estart,$doctorcode,$doctorname,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$currentusercode,$currentuser,$instcode) {	
		$zero = '0';
		$totalnoncashservice = $totalnoncashpharmacy = $totalnoncashlab = $totallab = $totalcashlab=$totalnoncashimaging = $totalimaging = $totalcashimaging=$totalnoncashdevice = $totaldevice = $totalcashdevice=$totalnoncashprocedure = $totalprocedure =$totalcashprocedure=$totalnoncashpharmacy = $totalpharmacy = $totalcashpharmacy= '0.00';
		$services = 'SERVICES';
		$pharmacy = 'PHARMACY';
		$device = 'DEVICES';
		$procedure = 'PROCEDURE';
		$lab = 'LABS';
		$imaging = 'IMAGING';
		$medicalreport = 'MEDREPORTS';

		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations_archive WHERE  CON_INSTCODE = ? AND CON_COMPLETE != ?  AND CON_DOCTORCODE = ? AND DATE(CON_DATE) between ? and ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $doctorcode);
		$st->BindParam(4, $mstart);
		$st->BindParam(5, $estart);
		$details =	$st->execute();
		if($details){
		//	echo $mtitle;
			$consultationcount = $st->rowcount();	
		//	die;
			if($consultationcount > '0'){

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $services);
				$totalcashservice = $st->execute();
				if($totalcashservice){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashservice = $obj['CASHAMOUNT'];												
					if($totalcashservice < 1 || empty($totalcashservice)){
						$totalcashservice = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $services);
				$totalservice = $st->execute();
				if($totalservice){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalservice = $obj['CASHAMOUNT'];												
					if($totalservice < 1 || empty($totalservice)){
						$totalservice = 0.00;
					}				
				}
				$totalnoncashservice = $totalservice - $totalcashservice;

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS PHARAMCYCASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT != ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $pharmacy);
				$totalcashpharmacy = $st->execute();
				if($totalcashpharmacy){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashpharmacy = $obj['PHARAMCYCASHAMOUNT'];												
					if($totalcashpharmacy < 1 || empty($totalcashpharmacy)){
						$totalcashpharmacy = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $pharmacy);
				$totalpharmacy = $st->execute();
				if($totalpharmacy){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
				echo	$totalpharmacy = $obj['CASHAMOUNT'];												
					if($totalpharmacy < 1 || empty($totalpharmacy)){
						$totalpharmacy = 0.00;
					}				
				}
				$totalnoncashpharmacy = $totalpharmacy - $totalcashpharmacy;				

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $procedure);
				$totalcashprocedure = $st->execute();
				if($totalcashprocedure){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashprocedure = $obj['CASHAMOUNT'];												
					if($totalcashprocedure < 1 || empty($totalcashprocedure)){
						$totalcashprocedure = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $procedure);
				$totalprocedure = $st->execute();
				if($totalprocedure){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalprocedure = $obj['CASHAMOUNT'];												
					if($totalprocedure < 1 || empty($totalprocedure)){
						$totalprocedure = 0.00;
					}				
				}
				$totalnoncashprocedure = $totalprocedure - $totalcashprocedure;				

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $device);
				$totalcashdevice = $st->execute();
				if($totalcashdevice){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashdevice = $obj['CASHAMOUNT'];												
					if($totalcashdevice < 1 || empty($totalcashdevice)){
						$totalcashdevice = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $device);
				$totaldevice = $st->execute();
				if($totaldevice){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totaldevice = $obj['CASHAMOUNT'];												
					if($totaldevice < 1 || empty($totaldevice)){
						$totaldevice = 0.00;
					}				
				}
				$totalnoncashdevice = $totaldevice - $totalcashdevice;				

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $imaging);
				$totalcashimaging = $st->execute();
				if($totalcashimaging){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashimaging = $obj['CASHAMOUNT'];												
					if($totalcashimaging < 1 || empty($totalcashimaging)){
						$totalcashimaging = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $imaging);
				$totalimaging = $st->execute();
				if($totalimaging){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalimaging = $obj['CASHAMOUNT'];												
					if($totalimaging < 1 || empty($totalimaging)){
						$totalimaging = 0.00;
					}				
				}
				$totalnoncashimaging = $totalimaging - $totalcashimaging;				

				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $lab);
				$totalcashlab = $st->execute();
				if($totalcashlab){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashlab = $obj['CASHAMOUNT'];												
					if($totalcashlab < 1 || empty($totalcashlab)){
						$totalcashlab = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $lab);
				$totallab = $st->execute();
				if($totallab){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totallab = $obj['CASHAMOUNT'];												
					if($totallab < 1 || empty($totallab)){
						$totallab = 0.00;
					}				
				}
				$totalnoncashlab = $totallab - $totalcashlab;
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $cashpaymentmethodcode);
				$st->BindParam(7, $medicalreport);
				$totalcashmedicalreport = $st->execute();
				if($totalcashmedicalreport){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalcashmedicalreport = $obj['CASHAMOUNT'];												
					if($totalcashmedicalreport < 1 || empty($totalcashmedicalreport)){
						$totalcashmedicalreport = 0.00;
					}				
				}
				
				$sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_DPT = ? ");
				$st = $this->db->prepare($sqlstmt);
				$st->BindParam(1, $instcode);
				$st->BindParam(2, $zero);
				$st->BindParam(3, $doctorcode);
				$st->BindParam(4, $mstart);
				$st->BindParam(5, $estart);
				$st->BindParam(6, $medicalreport);
				$totalmedicalreport = $st->execute();
				if($totalmedicalreport){
					$obj = $st->fetch(PDO::FETCH_ASSOC);				
					$totalmedicalreport = $obj['CASHAMOUNT'];												
					if($totalmedicalreport < 1 || empty($totalmedicalreport)){
						$totalmedicalreport = 0.00;
					}				
				}
				$totalnoncashmedicalreport = $totalmedicalreport - $totalcashmedicalreport;
				
				$sqlstmt = "UPDATE octopus_stats_doctors_monthly SET 
					MS_CONSULTATIONCASH = ?,
					MS_CONSULTATIONOTHERS = ?, 
					MS_CONSULTATIONAMOUNT = ?,
					MS_MEDICATIONCASH = ?,
					MS_MEDICATIONOTHERS = ?,
					MS_MEDICATIONAMOUNT = ?,
					MS_PROCEDURECASH = ?,
					MS_PROCEDUREOTHERS = ?,
					MS_PROCEDUREAMOUNT = ?,					
					MS_DEVICECASH = ?,
					MS_DEVICEOTHERS = ?,
					MS_DEVICEAMOUNT = ?,
					MS_LABSCASH = ?,
					MS_LABSOTHERS = ?,
					MS_LABSAMOUNT = ?,
					MS_IMAGINGCASH = ?,
					MS_IMAGING_OTHERS = ?,
					MS_IMAGINGAMOUNT = ?,
					MS_MEDICALREPORTCASH = ?,
					MS_MEDICALREPORTOTHER = ?,
					MS_MEDICALREPORTAMOUNT = ?
				 WHERE MS_MONTH = ? AND MS_INSTCODE = ? AND MS_DOCTORCODE = ? ";
					$st = $this->db->prepare($sqlstmt);   
					$st->BindParam(1, $totalcashservice);
					$st->BindParam(2, $totalnoncashservice);
					$st->BindParam(3, $totalservice);
					$st->BindParam(4, $totalcashpharmacy);
					$st->BindParam(5, $totalnoncashpharmacy);
					$st->BindParam(6, $totalpharmacy);
					$st->BindParam(7, $totalcashprocedure);
					$st->BindParam(8, $totalnoncashprocedure);
					$st->BindParam(9, $totalprocedure);
					$st->BindParam(10, $totalcashdevice);
					$st->BindParam(11, $totalnoncashdevice);
					$st->BindParam(12, $totaldevice);
					$st->BindParam(13, $totalcashlab);
					$st->BindParam(14, $totalnoncashlab);
					$st->BindParam(15, $totallab);
					$st->BindParam(16, $totalcashimaging);
					$st->BindParam(17, $totalnoncashimaging);
					$st->BindParam(18, $totalimaging);
					$st->BindParam(19, $totalcashmedicalreport);
					$st->BindParam(20, $totalnoncashmedicalreport);
					$st->BindParam(21, $totalmedicalreport);
					$st->BindParam(22, $mtitle);
					$st->BindParam(23, $instcode);
					$st->BindParam(24, $doctorcode);				
					$exev = $st->execute();	
					if($exev){
						return '2';			
					}else{			
						return '0';			
					}
			}else{
				return '1';
			}
			
		}else{
			return '0';
		}	
	}

	// 2 DEC 2022 JOSEPH ADORBOE 
	public function processdoctorstatsmonthlyend($mcode,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one = 1;
		$sql = "UPDATE octopus_st_month SET MON_PROCESSED = ?  WHERE MON_CODE = ? AND MON_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $mcode);
		$st->BindParam(3, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}


	// 2 DEC 2022 JOSEPH ADORBOE 
	public function processdoctorstatsmonthly($formkey,$mcode,$mtitle,$myear,$mstart,$estart,$doctorcode,$doctorname,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$currentusercode,$currentuser,$instcode) {	
		$zero = '0';
		$one = 1;
		$totalcash = $totalnoncash = $totalamount = '0.00';
		$sqlstmt = ("SELECT MS_ID FROM octopus_stats_doctors_monthly WHERE  MS_INSTCODE = ? AND MS_STATUS = ?  AND MS_DOCTORCODE = ? AND MS_STARTDATE = ? AND MS_ENDDATE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $doctorcode);
		$st->BindParam(4, $mstart);
		$st->BindParam(5, $estart);
		$details =	$st->execute();
if ($details) {
    $doctstat = $st->rowcount();
    if ($doctstat == '0') {
        $sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations_archive WHERE  CON_INSTCODE = ? AND CON_COMPLETE != ?  AND CON_DOCTORCODE = ? AND DATE(CON_DATE) between ? and ? ");
        $st = $this->db->prepare($sqlstmt);
        $st->BindParam(1, $instcode);
        $st->BindParam(2, $zero);
        $st->BindParam(3, $doctorcode);
        $st->BindParam(4, $mstart);
        $st->BindParam(5, $estart);
        $details =	$st->execute();
        if ($details) {
            //	echo $mtitle;
            $consultationcount = $st->rowcount();
            //	die;
            if ($consultationcount > '0') {
                $sqlstmt = ("SELECT PPD_ID FROM octopus_patients_procedures WHERE  PPD_INSTCODE = ? AND PPD_COMPLETE != ?  AND PPD_ACTORCODE = ? AND DATE(PPD_DATE) between ? and ?  ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $procedure = $st->execute();
                if ($procedure) {
                    $procedurecount = $st->rowcount();
                }

                $sqlstmt = ("SELECT PD_ID FROM octopus_patients_devices WHERE PD_INSTCODE = ? AND PD_COMPLETE != ?  AND PD_ACTORCODE = ? AND DATE(PD_DATE) between ? and ? ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $devices =	$st->execute();
                if ($devices) {
                    $devicecount = $st->rowcount();
                }

                $sqlstmt = ("SELECT MDR_ID FROM octopus_patients_medicalreports WHERE  MDR_INSTCODE = ? AND MDR_STATUS != ?  AND MDR_ACTORCODE = ? AND DATE(MDR_DATE) between ? and ? ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $medicalreport =	$st->execute();
                if ($medicalreport) {
                    $medicalreportcount = $st->rowcount();
                }

                $sqlstmt = ("SELECT PRESC_ID FROM octopus_patients_prescriptions WHERE  PRESC_INSTCODE = ? AND PRESC_COMPLETE != ?  AND PRESC_ACTORCODE = ? AND DATE(PRESC_DATE) between ? and ? ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $prescription =	$st->execute();
                if ($prescription) {
                    $prescriptioncount = $st->rowcount();
                }

                $sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE  MIV_INSTCODE = ? AND MIV_COMPLETE != ?  AND MIV_ACTORCODE = ? AND DATE(MIV_DATE) between ? and ?  AND MIV_CATEGORY = 'LABS'");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $labs =	$st->execute();
                if ($labs) {
                    $labscount = $st->rowcount();
                }

                $sqlstmt = ("SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE  MIV_INSTCODE = ? AND MIV_COMPLETE != ?  AND MIV_ACTORCODE = ? AND DATE(MIV_DATE) between ? and ?  AND MIV_CATEGORY = 'IMAGING'");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $labs =	$st->execute();
                if ($labs) {
                    $imagingcount = $st->rowcount();
                }

                // $sqlstmt = ("SELECT MDR_ID FROM octopus_patients_medicalreports WHERE  MDR_INSTCODE = ? AND MDR_STATUS != ?  AND MDR_ACTORCODE = ? AND DATE(MDR_DATE) between ? and ? ");
                // $st = $this->db->prepare($sqlstmt);
                // $st->BindParam(1, $instcode);
                // $st->BindParam(2, $zero);
                // $st->BindParam(3, $doctorcode);
                // $st->BindParam(4, $mstart);
                // $st->BindParam(5, $estart);
                // $medicalreport =	$st->execute();
                // if($medicalreport){
                // 	$medicalreportcount = $st->rowcount();
                // }

                $sqlstmt = ("SELECT SUM(B_TOTAMT) AS CASHAMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? AND ? AND B_METHODCODE = ? ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                $st->BindParam(6, $cashpaymentmethodcode);
                $cashbilling = $st->execute();
                if ($cashbilling) {
                    $obj = $st->fetch(PDO::FETCH_ASSOC);
                    $totalcash = $obj['CASHAMOUNT'];
                    if ($totalcash < 1 || empty($totalcash)) {
                        $totalcash = 0.00;
                    }
                }

                $sqlstmt = ("SELECT SUM(B_TOTAMT) AS AMOUNT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ?  AND B_BILLERCODE = ? AND DATE(B_DTIME) between ? and ? ");
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $instcode);
                $st->BindParam(2, $zero);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mstart);
                $st->BindParam(5, $estart);
                // $st->BindParam(7, $mobilemoneypaymentmethodcode); or B_PAYMETHODCODE = ?)
                $totalbilling = $st->execute();
                if ($totalbilling) {
                    $obj = $st->fetch(PDO::FETCH_ASSOC);
                    $totalamount = $obj['AMOUNT'];
                    if ($totalamount < 1 || empty($totalamount)) {
                        $totalamount = 0.00;
                    }
                }

                $totalnoncash = $totalamount - $totalcash ;
                echo $totalcash,$cashpaymentmethodcode;

                $sqlstmt = "INSERT INTO octopus_stats_doctors_monthly(MS_CODE,MS_DOCTOR,MS_DOCTORCODE,MS_MONTH,MS_YEAR,MS_STARTDATE,MS_ENDDATE,MS_INSTCODE,MS_TOTALCONSULTATION,MS_PROCEDURES,MS_MEDICATIONS,MS_DEVICES,MS_LABS,MS_IMAGING,MS_TOTALCASH,MS_TOTALAMOUNT,MS_TOTALNONCASH,MS_MEDICALREPORT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                $st = $this->db->prepare($sqlstmt);
                $st->BindParam(1, $formkey);
                $st->BindParam(2, $doctorname);
                $st->BindParam(3, $doctorcode);
                $st->BindParam(4, $mtitle);
                $st->BindParam(5, $myear);
                $st->BindParam(6, $mstart);
                $st->BindParam(7, $estart);
                $st->BindParam(8, $instcode);
                $st->BindParam(9, $consultationcount);
                $st->BindParam(10, $procedurecount);
                $st->BindParam(11, $prescriptioncount);
                $st->BindParam(12, $devicecount);
                $st->BindParam(13, $labscount);
                $st->BindParam(14, $imagingcount);
                $st->BindParam(15, $totalcash);
                $st->BindParam(16, $totalamount);
                $st->BindParam(17, $totalnoncash);
                $st->BindParam(18, $medicalreportcount);
                $exev = $st->execute();

                if ($exev) {
                    return '2';
                } else {
                    return '0';
                }
            } else {
                return '1';
            }
        } else {
            return '0';
        }
    } else {
        return '0';
    }
	}	

	}

	// 1 DEC 2022 JOSEPH ADORBOE
	public function processbiller($currentuser,$currentusercode,$instcode){
		$nu = "";
		$zero = '0';	
		$x = 1;
		$y = 1000;
	for ($x=1;$x<$y;$x++) {
		$sqlstmt = "SELECT B_SERVCODE , B_DPT FROM octopus_patients_billitems WHERE B_STATUS != ?  AND B_INSTCODE = ? AND (B_BILLERCODE IS NULL OR B_BILLERCODE = ?) AND B_ID = ?";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nu);
		$st->BindParam(4, $x);
		$exe = $st->execute();
		if ($exe) {
			if ($st->rowCount()>0) {
				$obj = $st->fetch(PDO::FETCH_ASSOC);
				$servicecode = $obj['B_SERVCODE'];
				$servicedept = $obj['B_DPT'];
				if ($servicedept == 'DEVICES') {
					$sqlstmt = "SELECT PD_ACTORCODE, PD_ACTOR FROM octopus_patients_devices WHERE PD_CODE = ? ";
					$st = $this->db->prepare($sqlstmt);
					$st->BindParam(1, $servicecode);
					// $st->BindParam(2, $instcode);
					// $st->BindParam(3, $nu);
					// $st->BindParam(4, $x);
					$exe = $st->execute();
					if ($exe) {
						if ($st->rowCount()>0) {
							$obj = $st->fetch(PDO::FETCH_ASSOC);
							$billercode = $obj['PD_ACTORCODE'];
							$biller = $obj['PD_ACTOR'];
							$sql = "UPDATE octopus_patients_billitems SET B_BILLERCODE = ?, B_BILLER = ?  WHERE B_SERVCODE = ? AND B_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $billercode);
							$st->BindParam(2, $biller);
							$st->BindParam(3, $servicecode);
							$st->BindParam(4, $instcode);
							$selectitem = $st->Execute();		

						} else {
							return '0';
						}
					}
				} else {
					return '0';
				}
			} else {
				return '0';
			}
    }
	}
	}
	

	// 1 DEC 2022 JOSEPH ADORBOE 
	public function getdoctorstatsreport($day,$currentusercode,$instcode){
		$state = 1;
		$two = 2;
		$zero = 0;
		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE  CON_INSTCODE = ? AND CON_COMPLETE = ?  AND CON_DOCTORCODE = ? AND DATE(CON_DATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$pendingconsultation = $st->rowcount();		
		}else{
			return '0';
		}	

		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE  CON_INSTCODE = ? AND CON_COMPLETE = ?  AND CON_DOCTORCODE = ? AND DATE(CON_DATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $two);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$completedconsultation = $st->rowcount();		
		}else{
			return '0';
		}	

		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE  CON_INSTCODE = ? AND CON_COMPLETE = ?  AND CON_DOCTORCODE = ? AND DATE(CON_DATE) < ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $day);
		$details =	$st->execute();
		if($details){
			$pastconsultation = $st->rowcount();		
		}else{
			return '0';
		}

		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE  CON_INSTCODE = ? AND CON_COMPLETE != ? AND DATE(CON_DATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $day);
		$details =	$st->execute();
		if($details){
			$totalconsultation = $st->rowcount();		
		}else{
			return '0';
		}	

		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE  CON_INSTCODE = ? AND CON_COMPLETE != ? AND DATE(CON_DATE) = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $day);
		$details =	$st->execute();
		if($details){
			$totalconsultation = $st->rowcount();		
		}else{
			return '0';
		}	
		
		return $pendingconsultation.'@'.$completedconsultation.'@'.$pastconsultation.'@'.$totalconsultation;
		//.'@'.$totaladultpatients.'@'.$totalelderlypatients.'@'.$totalmalechildrenpatients.'@'.$totalfemalechildrenpatients.'@'.$totaladultmalepatients.'@'.$totaladultfemalepatients.'@'.$totaleldermalepatients.'@'.$totalelderfemalepatients;
	// 
	// 	$malegender = 'Male';
	// 	$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_GENDER = ? ");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);
	// 	$st->BindParam(3, $malegender);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		$totalmalepatients = $st->rowcount();		
	// 	}else{
	// 		return '0';
	// 	}	
	// 	$femalegender = 'Female';
	// 	$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmt);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);
	// 	$st->BindParam(3, $femalegender);
	// 	$details =	$st->execute();
	// 	if($details){
	// 		$totalfemalepatients = $st->rowcount();		
	// 	}else{
	// 		return '0';
	// 	}

	// 	$day = Date('Y-m-d');		
	// 	// $yearOnly1 = date('Y', strtotime($patientbirthdate));
	// 	// $yearOnly2 = 

	// 	$thisyear = date('Y', strtotime($day));
	// 	$endyearchildern = $thisyear - 16;
	// 	$startyeardatechildern = $thisyear.'-12-31';
	// 	$endyeardatechildren = $endyearchildern.'-01-01';
		
	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardatechildren);
	// 	$st->BindParam(4, $startyeardatechildern);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totalchildrenpatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}	

	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardatechildren);
	// 	$st->BindParam(4, $startyeardatechildern);
	// 	$st->BindParam(5, $malegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totalmalechildrenpatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}	

	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardatechildren);
	// 	$st->BindParam(4, $startyeardatechildern);
	// 	$st->BindParam(5, $femalegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totalfemalechildrenpatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}	

	
	// 	$startyear = $thisyear - 17;
	// 	$startyeardate = $startyear.'-01-01';
	// 	$endyear = $thisyear - 50;
	// 	$endyeardate = $endyear.'-12-31';
		
	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totaladultpatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}

	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$st->BindParam(5, $malegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totaladultmalepatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}

	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$st->BindParam(5, $femalegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totaladultfemalepatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}

	// 	$startyear = $thisyear - 51;
	// 	$startyeardate = $startyear.'-01-01';
	// 	$endyear = $thisyear - 100;
	// 	$endyeardate = $endyear.'-12-31';
		
	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? ");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totalelderlypatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}

	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$st->BindParam(5, $malegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totaleldermalepatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}

	// 	$aged = 30;
	// 	$sqlstmts = ("SELECT PATIENT_ID FROM octopus_patients WHERE  PATIENT_INSTCODE = ? AND PATIENT_STATUS = ? AND PATIENT_DOB BETWEEN  ? AND ? AND PATIENT_GENDER = ?");
	// 	$st = $this->db->prepare($sqlstmts);
	// 	$st->BindParam(1, $instcode);
	// 	$st->BindParam(2, $state);		
	// 	$st->BindParam(3, $endyeardate);
	// 	$st->BindParam(4, $startyeardate);
	// 	$st->BindParam(5, $femalegender);
	// 	$detailss =	$st->execute();
	// 	if($detailss){
	// 		$totalelderfemalepatients = $st->rowcount();
			
	// 	}else{
	// 		return '0';
	// 	}
			
	// 	return $pendingconsultation.'@'.$completedconsultation.'@'.$pastconsultation.'@'.$totalchildrenpatients.'@'.$totaladultpatients.'@'.$totalelderlypatients.'@'.$totalmalechildrenpatients.'@'.$totalfemalechildrenpatients.'@'.$totaladultmalepatients.'@'.$totaladultfemalepatients.'@'.$totaleldermalepatients.'@'.$totalelderfemalepatients;
	// //	return $totalchildrenpatients;

	}

	// 20 NOV 2022 JOSEPH ADORBOE
	public function returnservicerequest($ekey,$returnreason,$currentusercode,$currentuser,$instcode){
		$zero = '0';
		$one =1;
		$sql = "UPDATE octopus_patients_servicesrequest SET REQU_RETURN = ?, REQU_RETURNTIME = ? , REQU_RETURNACTOR = ?, REQU_RETURNACTORCODE = ? , REQU_RETURNREASON = ?  WHERE REQU_CODE = ? and  REQU_RETURN = ? AND REQU_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $days);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $returnreason);
		$st->BindParam(6, $ekey);
		$st->BindParam(7, $zero);
		$st->BindParam(8, $instcode);
		$selectitem = $st->Execute();				
			if($selectitem){
				return '2' ;	
			}else{
				return '0' ;	
			}	
	}

	// 05 NOV 2022 JOSEPH ADORBOE 
	public function addforex($form_key,$currency,$rates,$days,$currentusercode,$currentuser,$instcode) {		
		$zero = '0';
		$one = 1;
		$two = 2;
		
			$sqlstmt = "INSERT INTO octopus_cashier_forex(FOX_CODE,FOX_DATE,FOX_CURRENCY,FOX_RATE,FOX_ACTOR,FOX_ACTORCODE,FOX_INSTCODE) VALUES (?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $days);
			$st->BindParam(3, $currency);
			$st->BindParam(4, $rates);
			$st->BindParam(5, $currentuser);
			$st->BindParam(6, $currentusercode);
			$st->BindParam(7, $instcode);
			$exev = $st->execute();	
			if($exev){
				$sql = "UPDATE octopus_cashier_forex SET FOX_STATUS = ? WHERE FOX_CODE != ? AND FOX_CURRENCY = ?  AND FOX_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $two);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $currency);
				$st->BindParam(4, $instcode);
				$exet = $st->execute();		

				return '2';			
			}else{			
				return '0';			
			}
		

	}

	// 24 SEPT 2022 JOSEPH ADORBOE 
	public function getmessage(){
		$status = "error";
        $msg = "Unknown source ";
		return $status;
	}

	// 27 AUG 2022,  JOSEPH ADORBOE
    public function getpendingcount($currentusercode,$thereviewday,$instcode){
	
		$one = 1;
		$na = 'NA';
		$year = date('Y');
		$sqlstmt = ("SELECT CON_ID FROM octopus_patients_consultations WHERE CON_DOCTORCODE = ? AND CON_DATE < ? AND CON_INSTCODE = ? AND CON_COMPLETE = ?");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $thereviewday);
		$st->BindParam(3, $instcode);
		$st->BindParam(4, $one);
		$st->execute();	
		return $st->rowcount();
		
	}

	// 15 AUG 2022 JOSEPH ADORBOE
	public function removeattachments($ekey,$form_key,$currentusercode,$currentuser,$instcode){			
		$zero = '0';
		$one = 1;
		$sqlstmt = "UPDATE octopus_patients_attachedresults SET RES_STATUS = ?, RES_ACTOR = ? , RES_ACTORCODE = ? WHERE RES_CODE = ? AND RES_INSTCODE = ? AND RES_STATUS = ? ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$st->BindParam(6, $one);
		$exe = $st->execute();		
		if($exe){
			return '2';
		}else{
			return '0';
		}
	}


	
       

	// 28 JULY 2022 , JOSEPH ADORBOE 
	public function medicalreportdetails($idvalue){		
		$st = $this->db->prepare("SELECT * FROM octopus_patients_medicalreports WHERE MDR_CODE = ?");   
		$st->BindParam(1, $idvalue);
		$st->execute();
		if($st->rowcount()>0){
		$obj = $st->fetch(PDO::FETCH_ASSOC);
	
		$value = $obj['MDR_CODE'].'@@@'.$obj['MDR_REQUESTNUMBER'].'@@@'.$obj['MDR_PATIENTCODE'].'@@@'.$obj['MDR_PATIENTNUMBER'].'@@@'.$obj['MDR_PATIENT'].'@@@'.$obj['MDR_GENDER'].'@@@'.$obj['MDR_AGE'].'@@@'.$obj['MDR_DATE'].'@@@'.$obj['MDR_SERVICE'].'@@@'.$obj['MDR_ADDRESS'].'@@@'.$obj['MDR_REPORT'].'@@@'.$obj['MDR_ACTOR'].'@@@'.$obj['MDR_DIAGNOSIS'].'@@@'.$obj['MDR_ACTORTITLE'];
		
			return $value ;			
		}else{				
			return '-1';				
		}			
			
	}

	// 24 JULY 2022 JOSEPH ADORBOE 
	public function processbillinglegacy($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$date,$visitcode,$paymethodcode,$paymethod,$patientschemecode,$patientscheme,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){		
		$zero = '0';
		$one = 1;
		$one = 1;
		if( $paymethodcode == $privateinsurancecode || $paymethodcode == $nationalinsurancecode || $paymethodcode == $partnercompaniescode ){

			$sqlstmt = "INSERT INTO octopus_patients_claims(CLAIM_CODE,CLAIM_NUMBER,CLAIM_PATIENTCODE,CLAIM_PATIENTNUMBER,CLAIM_PATIENT,CLAIM_DATE,CLAIM_VISITCODE,CLAIM_PAYSCHEMECODE,CLAIM_PAYSCHEME,CLAIM_METHOD,CLAIM_METHODCODE,CLAIM_INSTCODE,CLAIM_DAY,CLAIM_MONTH,CLAIM_YEAR,CLAIMS_ACTOR,CLAIMS_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $claimsnumber);
			$st->BindParam(3, $patientcode);
			$st->BindParam(4, $patientnumber);
			$st->BindParam(5, $patient);
			$st->BindParam(6, $date);
			$st->BindParam(7, $visitcode);
			$st->BindParam(8, $patientschemecode);
			$st->BindParam(9, $patientscheme);
			$st->BindParam(10, $paymethod);
			$st->BindParam(11, $paymethodcode);
			$st->BindParam(12, $instcode);
			$st->BindParam(13, $currentday);
			$st->BindParam(14, $currentmonth);
			$st->BindParam(15, $currentyear);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$exev = $st->execute();	
			if($exev){
				$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ?, B_CLAIMSCODE = ? ,B_CLAIMSNUMBER = ?  WHERE B_PATIENTCODE  = ? AND B_VISITCODE = ?  AND B_PAYSCHEMECODE = ? AND B_PREFORMED = ? AND B_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $one);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $claimsnumber);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $patientschemecode);
				$st->BindParam(7, $zero);
				$st->BindParam(8, $instcode);
			//	$st->BindParam(9, $instcode);
				$exet = $st->execute();		

				return '2';			
			}else{			
				return '0';			
			}
		}else{
			return '0';
		}

	}

	// 14 JULY  2022 JOSEPH ADORBOE 
	public function performinsurancebilling($form_key,$claimsnumber,$patientcode,$patientnumber,$patient,$days,$visitcode,$paymentmethodcode,$paymentmethod,$patientschemecode,$patientscheme,$patientservicecode,$currentusercode,$currentuser,$instcode,$currentday,$currentmonth,$currentyear,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode){		
		$zero = '0';
		$one = 1;
		$one = 1;
		if( $paymentmethodcode == $privateinsurancecode || $paymentmethodcode == $nationalinsurancecode || $paymentmethodcode == $partnercompaniescode ){

		
		$sqlstmt = ("SELECT CLAIM_CODE,CLAIM_NUMBER FROM octopus_patients_claims WHERE CLAIM_PATIENTCODE = ? AND CLAIM_VISITCODE = ? AND  CLAIM_PAYSCHEMECODE = ? AND CLAIM_STATUS = ?  AND CLAIM_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcode);
		$st->BindParam(2, $visitcode);
		$st->BindParam(3, $patientschemecode);
		$st->BindParam(4, $one);
		$st->BindParam(5, $instcode);
		$st->execute();		
		if($st->rowcount() > 0){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$claincode  = $obj['CLAIM_CODE'];	
			$clainnumber  = $obj['CLAIM_NUMBER'];
			$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ?, B_CLAIMSCODE = ? ,B_CLAIMSNUMBER = ?  WHERE B_PATIENTCODE  = ? AND B_VISITCODE = ?  AND  B_ITEMCODE = ? AND B_PAYSCHEMECODE = ? AND B_PREFORMED = ? AND B_INSTCODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $one);
			$st->BindParam(2, $claincode);
			$st->BindParam(3, $clainnumber);
			$st->BindParam(4, $patientcode);
			$st->BindParam(5, $visitcode);
			$st->BindParam(6, $patientservicecode);
			$st->BindParam(7, $patientschemecode);
			$st->BindParam(8, $zero);
			$st->BindParam(9, $instcode);
			$exet = $st->execute();	
			if($exet){
				return '2';			
			}else{			
				return '0';			
			}
				
		}else{	
			$sqlstmt = "INSERT INTO octopus_patients_claims(CLAIM_CODE,CLAIM_NUMBER,CLAIM_PATIENTCODE,CLAIM_PATIENTNUMBER,CLAIM_PATIENT,CLAIM_DATE,CLAIM_VISITCODE,CLAIM_PAYSCHEMECODE,CLAIM_PAYSCHEME,CLAIM_METHOD,CLAIM_METHODCODE,CLAIM_INSTCODE,CLAIM_DAY,CLAIM_MONTH,CLAIM_YEAR,CLAIMS_ACTOR,CLAIMS_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $claimsnumber);
			$st->BindParam(3, $patientcode);
			$st->BindParam(4, $patientnumber);
			$st->BindParam(5, $patient);
			$st->BindParam(6, $days);
			$st->BindParam(7, $visitcode);
			$st->BindParam(8, $patientschemecode);
			$st->BindParam(9, $patientscheme);
			$st->BindParam(10, $paymentmethod);
			$st->BindParam(11, $paymentmethodcode);
			$st->BindParam(12, $instcode);
			$st->BindParam(13, $currentday);
			$st->BindParam(14, $currentmonth);
			$st->BindParam(15, $currentyear);
			$st->BindParam(16, $currentuser);
			$st->BindParam(17, $currentusercode);
			$exev = $st->execute();	
			if($exev){
				$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ?, B_CLAIMSCODE = ? ,B_CLAIMSNUMBER = ?  WHERE B_PATIENTCODE  = ? AND B_VISITCODE = ?  AND  B_ITEMCODE = ? AND B_PAYSCHEMECODE = ? AND B_PREFORMED = ? AND B_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $one);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $claimsnumber);
				$st->BindParam(4, $patientcode);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $patientservicecode);
				$st->BindParam(7, $patientschemecode);
				$st->BindParam(8, $zero);
				$st->BindParam(9, $instcode);
				$exet = $st->execute();		

				return '2';			
			}else{			
				return '0';			
			}
	}

	}else{
		$sql = "UPDATE octopus_patients_billitems SET B_PREFORMED = ? WHERE B_PATIENTCODE  = ? AND B_VISITCODE = ?  AND  B_ITEMCODE = ? AND B_PAYSCHEMECODE = ? AND B_PREFORMED = ? AND B_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $one);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $visitcode);
		$st->BindParam(4, $patientservicecode);
		$st->BindParam(5, $patientschemecode);
		$st->BindParam(6, $zero);
		$st->BindParam(7, $instcode);
		$exe = $st->execute();		
		if($exe){
			return '2';			
		}else{			
			return '0';			
		}

	}
	}
	

	// 28 MAY 2022 JOSEPH ADORBOE 
	public function update_disableservicepartner($ekey,$currentusercode,$currentuser,$instcode){		
		$zero = '0';
		$sql = "UPDATE octopus_servicepartners SET COMP_STATUS = ?, COMP_ACTOR = ? , COMP_ACTORCODE = ?  WHERE COMP_CODE = ? AND COMP_INSTCODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $zero);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		$st->BindParam(5, $instcode);
		$exe = $st->execute();		
		if($exe){
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 28 MAY 2022 JOSEPH ADORBOE 
	public function update_servicepartner($ekey,$partnername,$partnerservicecode,$partnerservicename,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode){		
		$rt = 0;
		$sql = "UPDATE octopus_servicepartners SET COMP_NAME = ?, COMP_ADDRESS = ? , COMP_PHONENUMBER = ? , COMP_CONTACTPERSON = ? , COMP_CONTACTPERSONINFO = ?, COMP_REMARKS = ? , COMP_SERVICECODE = ? , COMP_SERVICE = ? WHERE COMP_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $partnername);
		$st->BindParam(2, $partneraddress);
		$st->BindParam(3, $phone);
		$st->BindParam(4, $contactperson);
		$st->BindParam(5, $contacts);
		$st->BindParam(6, $partnerremarks);
		$st->BindParam(7, $partnerservicecode);
		$st->BindParam(8, $partnerservicename);
		$st->BindParam(9, $ekey);
		$exe = $st->execute();		
		if($exe){
			return '2';			
		}else{			
			return '0';			
		}
	}
	
	// 28 MAY 2022  JOSEPH ADORBOE
    public function insert_servicepartner($form_key,$partnerservicecode,$partnerservicename,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode){	
		$one = 1;
		$sqlstmt = ("SELECT COMP_ID FROM octopus_servicepartners WHERE COMP_INSTCODE = ? AND COMP_STATUS = ? AND  COMP_SERVICECODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
	//	$st->BindParam(1, $partnername);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $one);
		$st->BindParam(3, $partnerservicecode);
		$st->execute();		
		if($st->rowcount() > 0){
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_servicepartners(COMP_CODE,COMP_NAME,COMP_ADDRESS,COMP_PHONENUMBER,COMP_CONTACTPERSON,COMP_CONTACTPERSONINFO,COMP_SERVICECODE,COMP_SERVICE,COMP_REMARKS,COMP_ACTOR,COMP_ACTORCODE,COMP_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $partnername);
			$st->BindParam(3, $partneraddress);
			$st->BindParam(4, $phone);
			$st->BindParam(5, $contactperson);
			$st->BindParam(6, $contacts);
			$st->BindParam(7, $partnerservicecode);
			$st->BindParam(8, $partnerservicename);
			$st->BindParam(9, $partnerremarks);
			$st->BindParam(10, $currentuser);
			$st->BindParam(11, $currentusercode);	
			$st->BindParam(12, $instcode);
		//	$st->BindParam(13, $userlename);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}	

	// 24 MAY 2021  JOSEPH ADORBOE 
	public function gettotalmedicationdispensed($termone,$termtwo,$instcode){
		$zero = '0';
		$sqlstmt = ("SELECT SUM(PRESC_TOT) AS TOTALREVENUE FROM octopus_patients_prescriptions WHERE  PRESC_INSTCODE = ? AND PRESC_STATUS != ? AND DATE(PRESC_DISPENSEDATE) BETWEEN ? AND  ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalrevenuetotal = $obj['TOTALREVENUE'];		
		}else{
			$totalrevenuetotal = '0';
		}			
		return $totalrevenuetotal ;
	}

	// 21 MAY 2021  JOSEPH ADORBOE 
	public function getrevenuetotals($termone,$termtwo,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$privateinsurancecode,$partnercompaniescode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT SUM(TILL_AMOUNT) AS TOTALREVENUE FROM octopus_cashier_tills WHERE  TILL_INSTCODE = ? AND TILL_STATUS = ? AND TILL_DATE BETWEEN ? AND  ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalrevenuetotal = $obj['TOTALREVENUE'];		
		}else{
			$totalrevenuetotal = '0';
		}
		
		$sqlstmt = ("SELECT SUM(TILL_AMOUNT) AS TOTALCASH FROM octopus_cashier_tills WHERE  TILL_INSTCODE = ? AND TILL_STATUS = ? AND TILL_DATE BETWEEN ? AND  ? AND TILL_PAYMENTMETHODCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$st->BindParam(5, $cashpaymentmethodcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalcashrevenuetotal = $obj['TOTALCASH'];		
		}else{
			$totalcashrevenuetotal =  '0';
		}	
		
		$sqlstmt = ("SELECT SUM(TILL_AMOUNT) AS TOTALMOMO FROM octopus_cashier_tills WHERE  TILL_INSTCODE = ? AND TILL_STATUS = ? AND TILL_DATE BETWEEN ? AND  ? AND TILL_PAYMENTMETHODCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$st->BindParam(5, $mobilemoneypaymentmethodcode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			 $totalmomorevenuetotal = $obj['TOTALMOMO'];		
		}else{
			$totalmomorevenuetotal =  '0';
		}

		$sqlstmt = ("SELECT SUM(TILL_AMOUNT) AS TOTALINS FROM octopus_cashier_tills WHERE  TILL_INSTCODE = ? AND TILL_STATUS = ? AND TILL_DATE BETWEEN ? AND  ? AND TILL_PAYMENTMETHODCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$st->BindParam(5, $privateinsurancecode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalinsurancerevenuetotal = $obj['TOTALINS'];		
		}else{
			$totalinsurancerevenuetotal = '0';
		}

		$sqlstmt = ("SELECT SUM(TILL_AMOUNT) AS TOTALCOMP FROM octopus_cashier_tills WHERE  TILL_INSTCODE = ? AND TILL_STATUS = ? AND TILL_DATE BETWEEN ? AND  ? AND TILL_PAYMENTMETHODCODE = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $state);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$st->BindParam(5, $partnercompaniescode);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalpartnercompanyrevenuetotal = $obj['TOTALCOMP'];		
		}else{
			$totalpartnercompanyrevenuetotal = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalitems = $obj['TOT'];		
		}else{
			$totalitems = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'SERVICES' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalservice = $obj['TOT'];		
		}else{
			$totalservice = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'PHARMACY' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalpharmacy = $obj['TOT'];		
		}else{
			$totalpharmacy = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'LABS' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totallabs = $obj['TOT'];		
		}else{
			$totallabs = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'PROCEDURE' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalprocedure = $obj['TOT'];		
		}else{
			$totalprocedure = '0';
		}	

		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'DEVICES' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totaldevices = $obj['TOT'];		
		}else{
			$totaldevices = '0';
		}
		$zero = '0';
		$sqlstmt = ("SELECT SUM(B_TOTAMT) TOT FROM octopus_patients_billitems WHERE  B_INSTCODE = ? AND B_STATUS != ? AND B_DT BETWEEN ? AND  ? AND B_DPT = 'MEDREPORTS' AND B_COST != '-1' ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $zero);
		$st->BindParam(3, $termone);
		$st->BindParam(4, $termtwo);
		$details =	$st->execute();
		if($details){
			$obj = $st->fetch(PDO::FETCH_ASSOC);
			$totalmedicalreports = $obj['TOT'];		
		}else{
			$totalmedicalreports = '-1';
		}	
				
		return $totalrevenuetotal.'@'.$totalcashrevenuetotal.'@'.$totalmomorevenuetotal.'@'.$totalinsurancerevenuetotal.'@'.$totalpartnercompanyrevenuetotal.'@'.$totalitems.'@'.$totalservice.'@'.$totalpharmacy.'@'.$totallabs.'@'.$totalprocedure.'@'.$totaldevices.'@'.$totalmedicalreports;	
		
	}

	

	// 1 JUL 2023 JOSEPH ADORBOE 
	public function edithandover($ekey,$handovertitle,$handovernotes,$currentusercode,$currentuser,$instcode){	
		$zero = '0';
		$one = 1;
		$two = 2;
		$sql = "UPDATE octopus_handover SET HO_TITLE = ? , HO_NOTES = ? WHERE HO_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $handovertitle);
		$st->BindParam(2, $handovernotes);
		$st->BindParam(3, $ekey);
		// $st->BindParam(4, $two);
		// $st->BindParam(5, $day);
		// $st->BindParam(6, $one);
		// $st->BindParam(7, $one);
		// $st->BindParam(8, $instcode);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}


	// 13 FEB 2022   JOSEPH ADORBOE
	public function insert_newhandovernotes($form_key,$handovercode,$day,$handovertitle,$handovernotes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){	
		$type = 'NA';
		$sqlstmt = "INSERT INTO octopus_handover(HO_CODE,HO_NUMBER,HO_DATE,HO_TYPE,HO_TITLE,HO_NOTES,HO_SHIFT,HO_SHIFTCODE,HO_INSTCODE,HO_ACTOR,HO_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $handovercode);
		$st->BindParam(3, $day);
		$st->BindParam(4, $type);
		$st->BindParam(5, $handovertitle);
		$st->BindParam(6, $handovernotes);
		$st->BindParam(7, $currentshift);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$exe = $st->execute();	
		if($exe){									
			$sql = "UPDATE octopus_current SET CU_INCIDENCENUMBER = ?  WHERE CU_INSTCODE = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $incidencecode);
			$st->BindParam(2, $instcode);						
			$exe = $st->execute();
			if ($exe) {
				return '2';
			}else{
				return '0';
			}									
		}else{								
			return '0';								
		}				
		
	}


	// 31 JAN 2022,  JOSEPH ADORBOE
    public function doctordaystats($currentusercode,$currentuser,$instcode){
	
		$mt = 4;
		$year = date('Y');
		$month = date('M Y');
		$dayd = date('d M Y');
		$sqlstmt = ("SELECT DS_ID FROM octopus_stats_doctors where DS_DOCTORCODE = ? AND DS_TYPE = ? AND DS_DAY = ? AND DS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $dayd);
		$st->BindParam(4, $instcode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{	
			$mkey = md5(microtime());			
			$sqlstmt = "INSERT INTO octopus_stats_doctors(DS_CODE,DS_DOCTOR,DS_DOCTORCODE,DS_TYPE,DS_YEAR,DS_INSTCODE,DS_MONTH,DS_DAY) VALUES (?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $mkey);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $mt);
			$st->BindParam(5, $year);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $month);
			$st->BindParam(8, $dayd);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}

	// 31 JAN 2022,  JOSEPH ADORBOE
    public function doctormonthlystats($currentusercode,$currentuser,$instcode){
	
		$mt = 3;
		$year = date('Y');
		$month = date('M Y');
		$na = 'NA';
		$sqlstmt = ("SELECT DS_ID FROM octopus_stats_doctors where DS_DOCTORCODE = ? AND DS_TYPE = ? AND DS_MONTH = ? AND DS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $month);
		$st->BindParam(4, $instcode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{	
			$mkey = md5(microtime());			
			$sqlstmt = "INSERT INTO octopus_stats_doctors(DS_CODE,DS_DOCTOR,DS_DOCTORCODE,DS_TYPE,DS_YEAR,DS_INSTCODE,DS_MONTH,DS_DAY) VALUES (?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $mkey);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $mt);
			$st->BindParam(5, $year);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $month);
			$st->BindParam(8, $na);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
	
	// 31 JAN 2022,  JOSEPH ADORBOE
    public function doctortotalstats($currentusercode,$currentuser,$instcode){
	
		$mt = 1;
		$na = 'NA';
		$year = date('Y');
		$sqlstmt = ("SELECT DS_ID FROM octopus_stats_doctors where DS_DOCTORCODE = ? AND DS_TYPE = ? AND DS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $instcode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{	
			$mkey = md5(microtime());			
			$sqlstmt = "INSERT INTO octopus_stats_doctors(DS_CODE,DS_DOCTOR,DS_DOCTORCODE,DS_TYPE,DS_YEAR,DS_INSTCODE,DS_MONTH,DS_DAY) VALUES (?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $mkey);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $mt);
			$st->BindParam(5, $year);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $na);
			$st->BindParam(8, $na);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
	// 31 JAN 2022,  JOSEPH ADORBOE
    public function doctoryearlystats($currentusercode,$currentuser,$instcode){
	
		$mt = 2;
		$na = 'NA';
		$year = date('Y');
		$sqlstmt = ("SELECT DS_ID FROM octopus_stats_doctors where DS_DOCTORCODE = ? AND DS_TYPE = ? AND DS_YEAR = ? AND DS_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $mt);
		$st->BindParam(3, $year);
		$st->BindParam(4, $instcode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{	
			$mkey = md5(microtime());			
			$sqlstmt = "INSERT INTO octopus_stats_doctors(DS_CODE,DS_DOCTOR,DS_DOCTORCODE,DS_TYPE,DS_YEAR,DS_INSTCODE,DS_MONTH,DS_DAY) VALUES (?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $mkey);
			$st->BindParam(2, $currentuser);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $mt);
			$st->BindParam(5, $year);
			$st->BindParam(6, $instcode);
			$st->BindParam(7, $na);
			$st->BindParam(8, $na);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	

	// 26 JAN 2022 JOSEPH ADORBOE 
	public function doctorStats($instcode){
		$nut = 1;
		$bot = 5;
		$sqlstmt = ("SELECT USER_FULLNAME,USER_CODE FROM octopus_users WHERE  USER_INSTCODE = ? AND USER_STATUS = ? AND USER_LEVEL = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $instcode);
		$st->BindParam(2, $nut);
		$st->BindParam(3, $bot);

		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				// $stmtcards =$st->GetAll();
				// print_r($stmtcards);
				// die;
				// $object = $st->fetch(PDO::FETCH_ASSOC);
				// print_r($object);
				// die;
				// $userdoctorcode = $object['USER_CODE'];
				// $userdoctor = $object['USER_FULLNAME'];				
				// return $results;

				// foreach ($rows as $row){
				// 	array_push($arr, $row['keyword']);
				// }
		
			}else{
				return'1';
			}	
		}else{
			return '0';
		}	
	}

	// 10 NOV 2021 JOSEPH ADORBOE 
	public function getuserpaymentdetails($idvalue,$currentusercode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_salary where SALS_CODE = ? and SALS_INSTCODE = ? AND SALS_STATUS = ? AND SALS_USERCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$st->BindParam(4, $currentusercode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['SALS_MONTH'].'@'.$object['SALS_AMOUNTDUE'].'@'.$object['SALS_TOTALTAX'].'@'.$object['SALS_SALARYNUM'].'@'.$object['SALS_SHIFTNUMS'].'@'.$object['SALS_PROCEDURESNUMS'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	


	// 09 NOV 2021 JOSEPH ADORBOE
	public function processprocedurefees($locumshare,$paysource,$facilityshare,$consumablepercentage,$consumableamount,$procedurefee,$usershareamount,$usersharetaxamount,$useramountdue,$facilityshareamount,$salarydetailsnum,$salarynum,$currentdate,$currentday,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode){			
		$cdate = date('Y-m-d' , strtotime($currentdate));
		$nt = 1;
		$faclitytotal = $consumableamount + $facilityshareamount;
		$sqlstmt = ("SELECT * FROM octopus_salary WHERE SALS_USERCODE = ? AND SALS_INSTCODE = ? AND SALS_STATUS = ? AND SALS_MONTH = ? ");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $nt);
		$st->BindParam(4, $currentmonth);
		$extp = $st->execute();
		if ($extp) {
            if ($st->rowcount() > 0) {
				$row = $st->fetch(PDO::FETCH_ASSOC);
				$monthsalarycode = $row['SALS_CODE'];
				$salarycode = md5(microtime());
				
				$sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_AMOUNTDUE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $salarycode);
                                $st->BindParam(2, $monthsalarycode);
                                $st->BindParam(3, $salarydetailsnum);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $currentuser);
                                $st->BindParam(6, $cdate);
                                $st->BindParam(7, $usershareamount);
                                $st->BindParam(8, $useramountdue);
                                $st->BindParam(9, $usersharetaxamount);
                                $st->BindParam(10, $locumshare);
                                $st->BindParam(11, $currentday);
                                $st->BindParam(12, $currentmonth);
                                $st->BindParam(13, $currentyear);
                                $st->BindParam(14, $currentusercode);
                                $st->BindParam(15, $currentuser);
                                $st->BindParam(16, $instcode);
								$st->BindParam(17, $faclitytotal);
								$st->BindParam(18, $paysource);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ?  WHERE CU_INSTCODE = ?  ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $salarydetailsnum);
                                    $st->BindParam(2, $instcode);
                                    $exe = $st->execute();
									$nut = 1;

                                    $sql = "UPDATE octopus_salary SET SALS_AMOUNTDUE =  SALS_AMOUNTDUE + ?, SALS_TOTALTAX = SALS_TOTALTAX + ?, SALS_PROCEDURESNUMS = SALS_PROCEDURESNUMS + ?  WHERE SALS_CODE = ? AND SALS_USERCODE = ? AND SALS_INSTCODE = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $useramountdue);
                                    $st->BindParam(2, $usersharetaxamount);
                                    $st->BindParam(3, $nut);
                                    $st->BindParam(4, $monthsalarycode);
                                    $st->BindParam(5, $currentusercode);
									$st->BindParam(6, $instcode);
                                    $exe = $st->execute();                                   
                                } else {
                                    return '0';
                                }
                            } else {
                                $monthsalarycode = md5(microtime());
                                $salarycode = md5(microtime());       
                               $nut = 1;
							   $zero = '0';
                                $sqlstmt = "INSERT INTO octopus_salary(SALS_CODE,SALS_SALARYNUM,SALS_USER,SALS_USERCODE,SALS_DATE,SALS_AMOUNTDUE,SALS_TOTALTAX,SALS_ACTOR,SALS_ACTORCODE,SALS_DAY,SALS_MONTH,SALS_YEAR,SALS_INSTCODE,SALS_PROCEDURESNUMS,SALS_SHIFTNUMS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $monthsalarycode);
                                $st->BindParam(2, $salarynum);
                                $st->BindParam(3, $currentuser);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $cdate);
                                $st->BindParam(6, $useramountdue);
                                $st->BindParam(7, $usersharetaxamount);
                                $st->BindParam(8, $currentuser);
                                $st->BindParam(9, $currentusercode);
                                $st->BindParam(10, $currentday);
                                $st->BindParam(11, $currentmonth);
                                $st->BindParam(12, $currentyear);
                                $st->BindParam(13, $instcode);
								$st->BindParam(14, $nut);
								$st->BindParam(15, $zero);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_AMOUNTDUE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                    $st = $this->db->prepare($sqlstmt);
                                    $st->BindParam(1, $salarycode);
                                    $st->BindParam(2, $monthsalarycode);
                                    $st->BindParam(3, $salarydetailsnum);
                                    $st->BindParam(4, $currentusercode);
                                    $st->BindParam(5, $currentuser);
                                    $st->BindParam(6, $cdate);
                                    $st->BindParam(7, $usershareamount);
                                    $st->BindParam(8, $useramountdue);
                                    $st->BindParam(9, $usersharetaxamount);
                                    $st->BindParam(10, $locumshare);
                                    $st->BindParam(11, $currentday);
                                    $st->BindParam(12, $currentmonth);
                                    $st->BindParam(13, $currentyear);
                                    $st->BindParam(14, $currentusercode);
                                    $st->BindParam(15, $currentuser);
                                    $st->BindParam(16, $instcode);
									$st->BindParam(17, $faclitytotal);
									$st->BindParam(18, $paysource);
                                    $exet = $st->execute();
                                    if ($exet) {
                                        $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ? ,CU_SALARYNUM = ?  WHERE CU_INSTCODE = ?  ";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $salarydetailsnum);
                                        $st->BindParam(2, $salarynum);
                                        $st->BindParam(3, $instcode);
                                        $exe = $st->execute();                                        
                                    } else {
                                        return '0';
                                    }
                                } else {
                                    return '0';
                                }
                            }
                        }else{
							return '0';
						}
                   

	}

	// 09 NOV 2021 JOSEPH ADORBOE 
	public function getbillingitemdetails($ekey,$procedurecode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_billitems where B_SERVCODE = ? and B_INSTCODE = ? AND B_ITEMCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $procedurecode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['B_COST'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	

	// 09 NOV 2021 JOSEPH ADORBOE 
	public function getlocumdetails($currentusercode,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_setup_locum where LOCUM_USERCODE = ? and LOCUM_INSTCODE = ? AND LOCUM_STATUS = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['LOCUM_AMOUNT'].'@'.$object['LOCUM_TAX'].'@'.$object['LOCUM_SHARE'].'@'.$object['LOCUM_FACILITYSHARE'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	



	// 07 NOV 2021 JOSEPH ADORBOE
	public function proceslocumschedule($currentshiftcode,$currentshift,$currentshifttype,$currentdate,$days,$currentday,$currentweek,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode){		
		
		$nt = 1; 
		$cdate = date('Y-m-d' , strtotime($currentdate));
		$sqlstmt = ("SELECT * FROM octopus_setup_locum where LOCUM_USERCODE = ? and LOCUM_STATUS = ? and LOCUM_INSTCODE =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
		$extp = $st->execute();
		
		if($extp){
			
			if($st->rowcount() > 0){				
				$row = $st->fetch(PDO::FETCH_ASSOC);
				$locumamount = $row['LOCUM_AMOUNT'];
				$locumtax = $row['LOCUM_TAX'];
				$taxamount = ($locumamount*$locumtax)/100;
				$amountdue = $locumamount-$taxamount;
				$zero = '0';
				$sqlstmt = ("SELECT * FROM octopus_schedule_staff WHERE SC_STAFFCODE = ? AND SC_INSTCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $currentusercode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cdate);
				$st->BindParam(4, $currentshifttype);
				$extp = $st->execute();
				
                if ($extp) {
					
                     if($st->rowcount() > 0){                   
                    $row = $st->fetch(PDO::FETCH_ASSOC);
                    $state = $row['SC_STATUS'];
                    // not paid for the shift
					
                    if ($state == '1') {						
                        // insert into thhe locum bill for the user
						//die($state);
                        $sqlstmt = ("SELECT * FROM octopus_salary WHERE SALS_USERCODE = ? AND SALS_INSTCODE = ? AND SALS_STATUS = ? AND SALS_MONTH = ? ");
                        $st = $this->db->prepare($sqlstmt);
                        $st->BindParam(1, $currentusercode);
                        $st->BindParam(2, $instcode);
                        $st->BindParam(3, $nt);
                        $st->BindParam(4, $currentmonth);
                        $extp = $st->execute();
                        if ($extp) {
                            if ($st->rowcount() > 0) {
							//	die;
                                $row = $st->fetch(PDO::FETCH_ASSOC);
                                $monthsalarycode = $row['SALS_CODE'];
                                $salarycode = md5(microtime());
                               
                                $sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $instcode);
                                $st->execute();
                                $obj = $st->fetch(PDO::FETCH_ASSOC);
                                $data = $obj['CU_SALARYTRANSACTIONNUM'];
                                $salarytransactionnum = $data + 1;
								$paysource = 'SHIFT';

                                $sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $salarycode);
                                $st->BindParam(2, $monthsalarycode);
                                $st->BindParam(3, $salarytransactionnum);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $currentuser);
                                $st->BindParam(6, $cdate);
                                $st->BindParam(7, $locumamount);
                                $st->BindParam(8, $amountdue);
                                $st->BindParam(9, $taxamount);
                                $st->BindParam(10, $locumtax);
                                $st->BindParam(11, $currentday);
                                $st->BindParam(12, $currentmonth);
                                $st->BindParam(13, $currentyear);
                                $st->BindParam(14, $currentusercode);
                                $st->BindParam(15, $currentuser);
                                $st->BindParam(16, $instcode);
								$st->BindParam(17, $paysource);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ?  WHERE CU_INSTCODE = ?  ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $salarytransactionnum);
                                    $st->BindParam(2, $instcode);
                                    $exe = $st->execute();
									$nut = 1;

                                    $sql = "UPDATE octopus_salary SET SALS_AMOUNTDUE =  SALS_AMOUNTDUE + ?, SALS_TOTALTAX = SALS_TOTALTAX + ? , SALS_SHIFTNUMS = SALS_SHIFTNUMS + ?  WHERE SALS_CODE = ? AND SALS_USERCODE = ? AND SALS_INSTCODE = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $amountdue);
                                    $st->BindParam(2, $taxamount);
                                    $st->BindParam(3, $nut);
                                    $st->BindParam(4, $monthsalarycode);
                                    $st->BindParam(5, $currentusercode);
									$st->BindParam(6, $instcode);
                                    $exe = $st->execute();

                                    $two = 2;
                                    $sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
                                    $st = $this->db->prepare($sql);
                                    $st->BindParam(1, $currentshiftcode);
                                    $st->BindParam(2, $currentshift);
                                    $st->BindParam(3, $days);
                                    $st->BindParam(4, $currentuser);
                                    $st->BindParam(5, $currentusercode);
                                    $st->BindParam(6, $two);
                                    $st->BindParam(7, $currentusercode);
                                    $st->BindParam(8, $cdate);
                                    $st->BindParam(9, $currentshifttype);
                                    $st->BindParam(10, $instcode);
                                    $exe = $st->execute();
                                } else {
                                    return '0';
                                }
                            } else {
                                $monthsalarycode = md5(microtime());
                                $salarycode = md5(microtime());
								$paysource = 'SHIFT';
                               
                                $sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $instcode);
                                $st->execute();
                                $obj = $st->fetch(PDO::FETCH_ASSOC);
                                $data = $obj['CU_SALARYNUM'].'@@'.$obj['CU_SALARYTRANSACTIONNUM'];
                                $et = explode('@@', $data);
                                $snum = $et[0];
                                $tnum = $et[1];
                                $salarynum = $snum + 1;
                                $salarytransactionnum = $tnum + 1;
								$nut = 1;
								$zero = '0';

                                $sqlstmt = "INSERT INTO octopus_salary(SALS_CODE,SALS_SALARYNUM,SALS_USER,SALS_USERCODE,SALS_DATE,SALS_AMOUNTDUE,SALS_TOTALTAX,SALS_ACTOR,SALS_ACTORCODE,SALS_DAY,SALS_MONTH,SALS_YEAR,SALS_INSTCODE,SALS_SHIFTNUMS,SALS_PROCEDURESNUMS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                $st = $this->db->prepare($sqlstmt);
                                $st->BindParam(1, $monthsalarycode);
                                $st->BindParam(2, $salarynum);
                                $st->BindParam(3, $currentuser);
                                $st->BindParam(4, $currentusercode);
                                $st->BindParam(5, $cdate);
                                $st->BindParam(6, $amountdue);
                                $st->BindParam(7, $taxamount);
                                $st->BindParam(8, $currentuser);
                                $st->BindParam(9, $currentusercode);
                                $st->BindParam(10, $currentday);
                                $st->BindParam(11, $currentmonth);
                                $st->BindParam(12, $currentyear);
                                $st->BindParam(13, $instcode);
								$st->BindParam(14, $nut);
								$st->BindParam(15, $zero);
                                $exet = $st->execute();
                                if ($exet) {
                                    $sqlstmt = "INSERT INTO octopus_salary_details(SAL_CODE,SAL_MONTHCODE,SAL_TRANSACTIONNUM,SAL_USERCODE,SAL_USER,SAL_DATE,SAL_AMOUNT,SAL_AMTDUEUSER,SAL_TAXAMOUNTUSER,SAL_TAXPERCENTUSER,SAL_DAY,SAL_MONTH,SAL_YEAR,SAL_ACTORCODE,SAL_ACTOR,SAL_INSTCODE,SAL_SOURCE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
                                    $st = $this->db->prepare($sqlstmt);
                                    $st->BindParam(1, $salarycode);
                                    $st->BindParam(2, $monthsalarycode);
                                    $st->BindParam(3, $salarytransactionnum);
                                    $st->BindParam(4, $currentusercode);
                                    $st->BindParam(5, $currentuser);
                                    $st->BindParam(6, $cdate);
                                    $st->BindParam(7, $locumamount);
                                    $st->BindParam(8, $amountdue);
                                    $st->BindParam(9, $taxamount);
                                    $st->BindParam(10, $locumtax);
                                    $st->BindParam(11, $currentday);
                                    $st->BindParam(12, $currentmonth);
                                    $st->BindParam(13, $currentyear);
                                    $st->BindParam(14, $currentusercode);
                                    $st->BindParam(15, $currentuser);
                                    $st->BindParam(16, $instcode);
									$st->BindParam(17, $paysource);
									
                                    $exet = $st->execute();
                                    if ($exet) {
                                        $sql = "UPDATE octopus_current SET CU_SALARYTRANSACTIONNUM = ? ,CU_SALARYNUM = ?  WHERE CU_INSTCODE = ?  ";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $salarytransactionnum);
                                        $st->BindParam(2, $salarynum);
                                        $st->BindParam(3, $instcode);
                                        $exe = $st->execute();

                                        // $sql = "UPDATE octopus_salary SET SALS_AMOUNTDUE =  SALS_AMOUNTDUE + ?, SALS_TOTALTAX = SALS_TOTALTAX + ?  WHERE SALS_CODE = ? AND SALS_USERCODE = ? AND SALS_INSTCODE = ? ";
                                        // $st = $this->db->prepare($sql);
                                        // $st->BindParam(1, $amountdue);
                                        // $st->BindParam(2, $taxamount);
                                        // $st->BindParam(3, $monthsalarycode);
                                        // $st->BindParam(4, $currentusercode);
                                        // $st->BindParam(5, $instcode);
                                        // $exe = $st->execute();

                                        $two = 2;
                                        $sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
                                        $st = $this->db->prepare($sql);
                                        $st->BindParam(1, $currentshiftcode);
                                        $st->BindParam(2, $currentshift);
                                        $st->BindParam(3, $days);
                                        $st->BindParam(4, $currentuser);
                                        $st->BindParam(5, $currentusercode);
                                        $st->BindParam(6, $two);
                                        $st->BindParam(7, $currentusercode);
                                        $st->BindParam(8, $cdate);
                                        $st->BindParam(9, $currentshifttype);
                                        $st->BindParam(10, $instcode);
                                        $exe = $st->execute();
                                    } else {
                                        return '0';
                                    }
                                } else {
                                    return '0';
                                }
                            }
                        }
                    } elseif ($state == 2) {
                        return '20';
                    } else {
                        return '30';
                    }
                }else{
					return '40';
				}

				}else{
					return '0';
				}

				
			}else{

				$sqlstmt = ("SELECT * FROM octopus_schedule_staff WHERE SC_STAFFCODE = ? AND SC_INSTCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $currentusercode);
				$st->BindParam(2, $instcode);
				$st->BindParam(3, $cdate);
				$st->BindParam(4, $currentshifttype);
				$extp = $st->execute();
                if ($extp) {
					if ($st->rowcount() > 0) {
					$row = $st->fetch(PDO::FETCH_ASSOC);
					$state = $row['SC_STATUS'];
					// not paid for the shift
                    if ($state == 1) {

						$two = 2;
						$sql = "UPDATE octopus_schedule_staff SET SC_SHIFTCODE = ?, SC_SHIFT = ? , SC_ACTORLOGIN = ? , SC_ACTIONACTOR = ? , SC_ACTIONACTORCODE = ? , SC_STATUS = ? WHERE SC_STAFFCODE = ? AND SC_DATE = ? AND SC_SHIFTTYPE = ? AND SC_INSTCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $currentshiftcode);
						$st->BindParam(2, $currentshift);
						$st->BindParam(3, $days);
						$st->BindParam(4, $currentuser);	
						$st->BindParam(5, $currentusercode);	
						$st->BindParam(6, $two);
						$st->BindParam(7, $currentusercode);
						$st->BindParam(8, $cdate);
						$st->BindParam(9, $currentshifttype);
						$st->BindParam(10, $instcode);
						$exe = $st->execute();

                    }else if($state == 2){
						return '20';
					}else{
						return '30';
					}

                }else{
					return '0';
				}

			}else{
				return '0';
			}
			//	return '10';				
			}
		}else{
			return '0';
		}

	}

	// 05 NOV 2021 JOSEPH ADORBOE 
	public function editlocum($ekey,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentusercode,$currentuser,$instcode){		
		$rt = 1;		
		$sql = "UPDATE octopus_setup_locum SET LOCUM_START = ? , LOCUM_END = ? , LOCUM_AMOUNT = ? , LOCUM_ACTOR = ? , LOCUM_ACTORCODE = ? , LOCUM_TAX = ? , LOCUM_SHARE = ? , LOCUM_FACILITYSHARE = ? WHERE LOCUM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $startdate);
		$st->BindParam(2, $enddate);
		$st->BindParam(3, $amount);
		$st->BindParam(4, $currentuser);	
		$st->BindParam(5, $currentusercode);
		$st->BindParam(6, $taxprecentage);
		$st->BindParam(7, $procedureshareamount);
		$st->BindParam(8, $facilityshare);
		$st->BindParam(9, $ekey);	
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 05 NOV 2021 JOSEPH ADORBOE
	public function addnewlocum($form_key,$personelcode,$personelname,$locumnumber,$startdate,$enddate,$amount,$taxprecentage,$procedureshareamount,$facilityshare,$currentuser,$currentusercode,$instcode){	
		$bt = 1;
		$sqlstmt = ("SELECT LOCUM_ID FROM octopus_setup_locum WHERE LOCUM_USERCODE = ? AND LOCUM_INSTCODE =? AND LOCUM_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $personelcode);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$sqlstmt = "INSERT INTO octopus_setup_locum(LOCUM_CODE,LOCUM_NUMBER,LOCUM_USER,LOCUM_USERCODE,LOCUM_START,LOCUM_END,LOCUM_AMOUNT,LOCUM_INSTCODE,LOCUM_ACTOR,LOCUM_ACTORCODE,LOCUM_TAX,LOCUM_SHARE,LOCUM_FACILITYSHARE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $locumnumber);
				$st->BindParam(3, $personelname);
				$st->BindParam(4, $personelcode);
				$st->BindParam(5, $startdate);
				$st->BindParam(6, $enddate);
				$st->BindParam(7, $amount);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $currentuser);
				$st->BindParam(10, $currentusercode);
				$st->BindParam(11, $taxprecentage);
				$st->BindParam(12, $procedureshareamount);
				$st->BindParam(13, $facilityshare);
				$exe = $st->execute();	
				if($exe){									
					$sql = "UPDATE octopus_current SET CU_LOCUM = ?  WHERE CU_INSTCODE = ?  ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $locumnumber);
					$st->BindParam(2, $instcode);						
					$exe = $st->execute();
					if ($exe) {
						return '2';
					}else{
						return '0';
					}										
				}else{								
					return '0';								
				}				
			}
		}else{
			return '0';
		}
	}


	// 20 OCT 2021    JOSEPH ADORBOE
	public function insert_newincidence($form_key,$incidencecode,$days,$incidencetitle,$notes,$type,$currentshiftcode,$currentshift,$currentusercode,$currentuser,$instcode){	
		
		$sqlstmt = "INSERT INTO octopus_incidences(IND_CODE,IND_NUMBER,IND_DATE,IND_TYPE,IND_TITLE,IND_DESCRIPTION,IND_SHIFT,IND_SHIFTCODE,IND_INSTCODE,IND_ACTOR,IND_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $incidencecode);
		$st->BindParam(3, $days);
		$st->BindParam(4, $type);
		$st->BindParam(5, $incidencetitle);
		$st->BindParam(6, $notes);
		$st->BindParam(7, $currentshift);
		$st->BindParam(8, $currentshiftcode);
		$st->BindParam(9, $instcode);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$exe = $st->execute();	
		if($exe){									
			$sql = "UPDATE octopus_current SET CU_INCIDENCENUMBER = ?  WHERE CU_INSTCODE = ?  ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $incidencecode);
			$st->BindParam(2, $instcode);						
			$exe = $st->execute();
			if ($exe) {
				return '2';
			}else{
				return '0';
			}									
		}else{								
			return '0';								
		}				
		
	}


	// 14 OCT 2021 JOSEPH ADORBOE 
	public function issuemedicalreport($days,$currentuser,$currentusercode,$idvalue){		
		$rt = 1;		
		$sql = "UPDATE octopus_patients_medicalreports SET MDR_ISSUED = ?, MDR_ISSUEDACTOR = ? ,  MDR_ISSUEDACTORCODE = ? , MDR_ISSUEDDATE = ?  WHERE MDR_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $rt);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $days);	
		$st->BindParam(5, $idvalue);	
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}

	// 14 OCT 2021 JOSEPH ADORBOE 
	public function getmedicalreportdetails($idvalue,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients_medicalreports where MDR_CODE = ? and MDR_INSTCODE = ? limit 1");
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $idvalue);
		$st->BindParam(2, $instcode);
		$details =	$st->execute();
		if($details){
			if($st->rowcount() > 0){
				$object = $st->fetch(PDO::FETCH_ASSOC);
				$results = $object['MDR_CODE'].'@'.$object['MDR_PATIENTCODE'].'@'.$object['MDR_PATIENTNUMBER'].'@'.$object['MDR_PATIENT'].'@'.$object['MDR_DATE'].'@'.$object['MDR_SERVICE'].'@'.$object['MDR_SERVICECODE'].'@'.$object['MDR_ADDRESS'].'@'.$object['MDR_REPORT'].'@'.$object['MDR_ACTOR'].'@'.$object['MDR_ACTORCODE'].'@'.$object['MDR_REQUESTNUMBER'];
				return $results;
			}else{
				return'1';
			}
		}else{
			return '0';
		}			
	}	


	// 12 OCT 2021   JOSEPH ADORBOE
	public function attachenonrequestedpatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$itmcode,$itmname,$remarks,$finame,$currentusercode,$currentuser,$instcode){		
		
		$sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE,RES_REMARKS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $requestcode);
		$st->BindParam(8, $itmcode);
		$st->BindParam(9, $itmname);
		$st->BindParam(10, $finame);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $currentusercode);
		$st->BindParam(13, $instcode);
		$st->BindParam(14, $remarks);
		$exe = $st->execute();		
		if($exe){
				return '2';
			}else{
				return '0';
			}			

	}


	// 20 SEPT 2021 JOSEPH ADORBOE 
	public function edititems($ekey,$itemnames,$desc,$currentusercode,$currentuser,$instcode){		
		$rt = '0';		
		$sql = "UPDATE octopus_st_items SET ITM_NAME = ?, ITM_DESC = ? ,  ITM_ACTORCODE = ? , ITM_ACTOR = ?  WHERE ITM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $itemnames);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $currentuser);	
		$st->BindParam(5, $ekey);	
		$exe = $st->execute();				
		if($exe){					
			return '2';
		}else{			
			return '0';			
		}
	}


	// 20 SEPT 2021    JOSEPH ADORBOE
	public function insert_addnewitems($form_key,$itemnames,$desc,$currentusercode,$currentuser,$instcode){	
		$bt = 1;
		$sqlstmt = ("SELECT ITM_ID FROM octopus_st_items WHERE ITM_NAME = ? AND ITM_INSTCODE =? AND ITM_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $itemnames);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $bt);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	
				$sqlstmt = "INSERT INTO octopus_st_items(ITM_CODE,ITM_NAME,ITM_DESC,ITM_ACTOR,ITM_ACTORCODE,ITM_INSTCODE) VALUES (?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $itemnames);
				$st->BindParam(3, $desc);
				$st->BindParam(4, $currentuser);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $instcode);
				$exe = $st->execute();	
				if($exe){									
					return '2';								
				}else{								
					return '0';								
				}				
			}
		}else{
			return '0';
		}
	}	

	// 9 AUG 2021 JOSEPH ADORBOE 
	public function patientnumbertype($patientnumber,$instcode,$instcodenuc){
		if($instcode == $instcodenuc){
			$pnd = explode('/', $patientnumber);
			$theserial = $pnd[0];
			$ptype = $pnd[1];
			$ptype = strtoupper($ptype);
		}else{
			$ptype =1;
		}

		return $ptype;
	}

	// 29 JULY 2021   JOSEPH ADORBOE
	public function getpatientcurrentvisitcode($patientcodecode,$patientnumber,$patient,$vcode,$days,$gender,$age,$walkinservice,$cashpaymentmethodcode,$cashpaymentmethod,$cashschemecode,$currentuser,$currentusercode,$instcode){		
		$nt = 1; 
		$sqlstmt = ("SELECT * FROM octopus_patients_visit where VISIT_PATIENTCODE = ? and VISIT_COMPLETE =? and VISIT_INSTCODE =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientcodecode);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){
				$row = $st->fetch(PDO::FETCH_ASSOC);
				$visitcode = $row['VISIT_CODE'];
				return $visitcode;			
			}else{	

				$walkin = 'WALK IN';
				$cash = 'CASH';
				$paymenttype  = 1;
				$sqlstmt = "INSERT INTO octopus_patients_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUMBER,VISIT_PATIENT,VISIT_DATE,VISIT_SERVICECODE,VISIT_SERVICE,VISIT_PAYMENTMETHOD,VISIT_PAYMENTMETHODCODE,VISIT_PAYMENTSCHEMECODE,VISIT_PAYMENTSCHEME,VISIT_PAYMENTTYPE,VISIT_ACTOR,VISIT_ACTORCODE,VISIT_INSTCODE,VISIT_GENDER,VISIT_AGE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $vcode);
				$st->BindParam(2, $patientcodecode);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $days);
				$st->BindParam(6, $walkinservice);
				$st->BindParam(7, $walkin);
				$st->BindParam(8, $cashpaymentmethod);
				$st->BindParam(9, $cashpaymentmethodcode);
				$st->BindParam(10, $cashschemecode);
				$st->BindParam(11, $cash);
				$st->BindParam(12, $paymenttype);
				$st->BindParam(13, $currentuser);
				$st->BindParam(14, $currentusercode);
				$st->BindParam(15, $instcode);
				$st->BindParam(16, $gender);
				$st->BindParam(17, $age);
				$exe = $st->execute();						
				if($exe){							
					return $vcode;								
				}else{
					return '0';							
				}

			}
		}else{
			return '0';
		}

	}


	// 10 JULY 2021   JOSEPH ADORBOE
	public function attachepatientexternalresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$attachtype,$remarks,$finame,$currentusercode,$currentuser,$instcode){		
		$category = 2;
		$name  = ' External';
		$sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_TYPE,RES_CATGORY,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE,RES_REMARKS,RES_TEST) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $patientcode);
		$st->BindParam(3, $patientnumbers);
		$st->BindParam(4, $patient);
		$st->BindParam(5, $day);
		$st->BindParam(6, $days);
		$st->BindParam(7, $attachtype);
		$st->BindParam(8, $category);
		$st->BindParam(9, $finame);
		$st->BindParam(10, $currentuser);
		$st->BindParam(11, $currentusercode);
		$st->BindParam(12, $instcode);
		$st->BindParam(13, $remarks);
		$st->BindParam(14, $name);
		$exe = $st->execute();		
		if($exe){
			return '2';
		}else{
			return '0';
		}	
	}

	

	

	// 09 JULY  2021 JOSEPH ADORBOE 
	public function getpatientdetails($patientnumber,$instcode){
		$state = 1;
		$sqlstmt = ("SELECT * FROM octopus_patients where PATIENT_PATIENTNUMBER = ? and PATIENT_INSTCODE = ? and PATIENT_STATUS = ? ");
		$st = $this->db->Prepare($sqlstmt);
		$st->BindParam(1, $patientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $state);
		$expt = $st->execute();
		if($expt){
			if($st->rowcount() > 0){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$patientcode = $obj['PATIENT_CODE'];
				$patient = $obj['PATIENT_NAMES'];
				$bithdate = $obj['PATIENT_DOB'];
				$gender = $obj['PATIENT_GENDER'];
				return $patientcode.'@@@'.$patient.'@@@'.$bithdate.'@@@'.$gender;
			}else{
				return '-1';
			}
		}else{
			return '-1';
		}
	}	


	// //  27 JUNE 2021, 6 APR 2019 , JOSEPH ADORBOE  
    // public function setnotification($form_key,$form_number,$currentusercode,$currentuser,$instcode,$notifytitle,$notifymssage,$notifysource,$currentshift,$currentshiftcode,$patientcode,$patientnumber,$patient,$day){
		
	// 	$sqlstmt = ("INSERT INTO octopus_userlog (USLOG_USERCODE,USLOG_USERNAME,USLOG_FULLNAME,USLOG_LOGTYPECODE,USLOG_DESC,USLOG_DATE,USLOG_INSTCODE,USLOG_CODE) VALUES (?,?,?,?,?,?,?,?) ");
	// 	$st = $this->db->prepare($sqlstmt);   
	// 	$st->BindParam(1, $currentusercode);
	// 	$st->BindParam(2, $currentusername);
	// 	$st->BindParam(3, $currentuser);
	// 	$st->BindParam(4, $eventcode);
	// 	$st->BindParam(5, $event);
	// 	$st->BindParam(6, $day);
	// 	$st->BindParam(7, $instcode);
	// 	$st->BindParam(8, $form_key);
	// 	$exeuserlogs = $st->execute();
	// 	if($exeuserlogs ){
	// 		$sql = ("INSERT INTO octopus_userformlogs (FORM_NUMBER,FORM_KEY,FORM_ACTORCODE,FORM_ACTOR,FORM_INSTCODE) VALUES (?,?,?,?,?) ");
	// 		$st = $this->db->prepare($sql);   
	// 		$st->BindParam(1, $form_number);
	// 		$st->BindParam(2, $form_key);
	// 		$st->BindParam(3, $currentusercode);
	// 		$st->BindParam(4, $currentuser);		
	// 		$st->BindParam(5, $instcode);
	// 		$exeformlogs = $st->execute();
	// 		if($exeformlogs){
	// 			return '2';
	// 		}else{
	// 			return '0';
	// 		}

	// 	}else{
	// 		return '0';
	// 	}					
	// }
	

	// 03 JUN 2021 JOSEPH ADORBOE 
	public function editpricing($ekey,$paycode,$payname,$schcode,$schname,$price,$day,$category,$currentusercode,$currentuser,$instcode){		
		$rt = 1;
		$sql = "UPDATE octopus_st_pricing SET PS_PRICE = ?, PS_PAYMENTMETHOD = ?, PS_PAYMENTMETHODCODE = ?, PS_PAYSCHEMECODE = ? , PS_PAYSCHEME = ? , PS_ACTORCODE = ? ,  PS_ACTOR = ? ,PS_CATEGORY = ? WHERE PS_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $price);
		$st->BindParam(2, $payname);
		$st->BindParam(3, $paycode);
		$st->BindParam(4, $schcode);	
		$st->BindParam(5, $schname);
		$st->BindParam(6, $currentusercode);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $category);
		$st->BindParam(9, $ekey);
		$exe = $st->execute();		
		if($exe){			
			return '2';
		}else{			
			return '0';			
		}	

	}

	// 23 MAY 2021   JOSEPH ADORBOE
	public function attachepatientresults($ekey,$form_key,$patientnumbers,$patient,$patientcode,$day,$days,$requestcode,$testscode,$tests,$finame,$currentusercode,$currentuser,$instcode){		
		$nutt = 7;		
		$sqlstmt = " Select * from octopus_patients_investigationrequest where MIV_CODE = ? and MIV_STATE != ? ";
		$st = $this->db->prepare($sqlstmt);
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $nutt);
		if($sqlstmt){
			if($st->rowcount() > 0 ){
				return '1';
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_attachedresults(RES_CODE,RES_PATIENTCODE,RES_PATIENTNUMBER,RES_PATIENT,RES_DATE,RES_DATETIME,RES_REQUESTCODE,RES_TESTCODE,RES_TEST,RES_FILE,RES_ACTOR,RES_ACTORCODE,RES_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $patientcode);
				$st->BindParam(3, $patientnumbers);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $day);
				$st->BindParam(6, $days);
				$st->BindParam(7, $requestcode);
				$st->BindParam(8, $testscode);
				$st->BindParam(9, $tests);
				$st->BindParam(10, $finame);
				$st->BindParam(11, $currentuser);
				$st->BindParam(12, $currentusercode);
				$st->BindParam(13, $instcode);
				$exe = $st->execute();		
				if($exe){
					$nut = 2;
					$nutt = 7;								
					$sql = "UPDATE octopus_patients_investigationrequest SET MIV_ATTACHED = ? , MIV_RESULTDATE = ?, MIV_RESULTACTOR = ?, MIV_RESULTACTORCODE = ?, MIV_STATE = ?, MIV_ATTACHEDFILE = ?, MIV_COMPLETE = ? WHERE MIV_REQUESTCODE = ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $nut);
					$st->BindParam(2, $days);
					$st->BindParam(3, $currentuser);
					$st->BindParam(4, $currentusercode);
					$st->BindParam(5, $nutt);
					$st->BindParam(6, $finame);
					$st->BindParam(7, $nut);
					$st->BindParam(8, $requestcode);
					$ups = $st->Execute();	
					if($ups){
						return '2';
					}else{
						return '0';
					}			
				}else{			
					return '0';			
				}				
			}
		}else{
			return '0';
		}			

	}


	// 05 MAY 2021 JOSEPH ADORBOE
    public function automaticshift($day,$days,$currenttime,$currentlastcheck,$currentshiftcode,$currentshiftstart,$currentshiftend,$currentday,$currentweek,$currentmonth,$currentyear,$currentusercode,$currentuser,$instcode)
	{
        // when shift is open
        if ($currentshiftcode !== '0') {
            if ($currenttime == $currentlastcheck) {				
                return '0';
            } elseif ($currenttime !== $currentlastcheck) {				
                if ($currentshiftend>$currenttime) {
					$sql = "UPDATE octopus_current SET CU_LASTCHECK = ? WHERE CU_INSTCODE = ? and  CU_LASTCHECK != ? ";
					$st = $this->db->prepare($sql);
					$st->BindParam(1, $currenttime);
					$st->BindParam(2, $instcode);
					$st->BindParam(3, $currenttime);
					$ups = $st->Execute();
					return '0';
				} elseif ($currenttime == $currentshiftend) {
					
                    $nut = '0';
                    $sql = "UPDATE octopus_shifts SET SHIFT_STATUS = ? WHERE SHIFT_CODE = ? ";
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $nut);
                    $st->BindParam(2, $currentshiftcode);
                    $ups = $st->Execute();
                    if ($ups) {
                        $sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $nut);
                        $st->BindParam(2, $nut);
                        $st->BindParam(3, $currenttime);
                        $st->BindParam(4, $instcode);
                        $upsd = $st->Execute();
                        if ($upsd) {
                            return '2';
                        } else {
                            return '0';
                        }
                    } else {
                        return '0';
                    }
                } elseif ($currentshiftend<$currenttime) {
				//	die('test');
                    $nut = '0';
                    $sql = "UPDATE octopus_shifts SET SHIFT_STATUS = ? WHERE SHIFT_CODE = ? ";
                    $st = $this->db->prepare($sql);
                    $st->BindParam(1, $nut);
                    $st->BindParam(2, $currentshiftcode);
                    $ups = $st->Execute();
                    if ($ups) {
                        $sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
                        $st = $this->db->prepare($sql);
                        $st->BindParam(1, $nut);
                        $st->BindParam(2, $nut);
                        $st->BindParam(3, $currenttime);
                        $st->BindParam(4, $instcode);
                        $upsd = $st->Execute();
                        if ($upsd) {
                            return '2';
                        } else {
                            return '0';
                        }
                    } else {
                        return '0';
                    }
                } else {
                    return '0';
                }
            } else {
                return '0';
            }
        } elseif ($currentshiftcode == '0') {
            if ($currenttime == $currentlastcheck) {
						
				$sql = ("SELECT * FROM octopus_admin_shifttypes where SHT_STARTTIME = ? and SHT_INSTCODE = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $currenttime);
				$st->BindParam(2, $instcode);
				$exe = $st->execute();
                    if ($exe) {
                        if ($st->rowcount()>0) {
							$object =  $st->fetch(PDO::FETCH_ASSOC);
							$shifttype = $object['SHT_SHIFTTYPE'];
							$shiftstart = $object['SHT_STARTTIME'];
							$shiftend = $object['SHT_ENDTIME'];
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());
							$shiftday = date('d M Y', strtotime($day));
							$shiftmonth = date('M Y', strtotime($day));
							$shiftyear = date('Y', strtotime($day));
														
							$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $day);
                            $st->BindParam(3, $shiftname);
                            $st->BindParam(4, $shifttype);
                            $st->BindParam(5, $currentusercode);
                            $st->BindParam(6, $currentuser);
                            $st->BindParam(7, $days);
                            $st->BindParam(8, $instcode);
                            $st->BindParam(9, $shiftstart);
                            $st->BindParam(10, $shiftend);
                            $exe = $st->execute();
                            if ($exe) {
								$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ? , CU_DAY = ? , CU_MONTH = ? , CU_YEAR = ?  WHERE CU_INSTCODE = ? ";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $form_key);
                                $st->BindParam(2, $shiftname);
                                $st->BindParam(3, $shifttype);
                                $st->BindParam(4, $days);
                                $st->BindParam(5, $shiftstart);
                                $st->BindParam(6, $shiftend);
                                $st->BindParam(7, $currenttime);
                                $st->BindParam(8, $shiftday);
								$st->BindParam(9, $shiftmonth);
								$st->BindParam(10, $shiftyear);
								$st->BindParam(11, $instcode);
                                $ups = $st->Execute();
                                if ($ups) {
                                    return '2';
                                } else {
                                    return '0';
                                }

                            }else{
								return '0';
							}

                        }else{
							$sql = "UPDATE octopus_current SET CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $currenttime);
							$st->BindParam(2, $instcode);
							$ups = $st->Execute();
							return '0';
						}
                    }else{
						return '0';
					}   
			
			} elseif ($currenttime !== $currentlastcheck) {				
            	if($currenttime > $currentlastcheck){
					
				$sql = ("SELECT * FROM octopus_admin_shifttypes where SHT_STARTTIME < ?  and SHT_ENDTIME > ? and SHT_INSTCODE = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $currenttime);
				$st->BindParam(2, $currenttime);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();
                    if ($exe) {
                        if ($st->rowcount()>0) {
							$object =  $st->fetch(PDO::FETCH_ASSOC);
							$shifttype = $object['SHT_SHIFTTYPE'];
							$shiftstart = $object['SHT_STARTTIME'];
							$shiftend = $object['SHT_ENDTIME'];
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());
							$shiftday = date('d M Y', strtotime($day));
							$shiftmonth = date('M Y', strtotime($day));
							$shiftyear = date('Y', strtotime($day));

							$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $day);
                            $st->BindParam(3, $shiftname);
                            $st->BindParam(4, $shifttype);
                            $st->BindParam(5, $currentusercode);
                            $st->BindParam(6, $currentuser);
                            $st->BindParam(7, $days);
                            $st->BindParam(8, $instcode);
                            $st->BindParam(9, $shiftstart);
                            $st->BindParam(10, $shiftend);
                            $exe = $st->execute();
                            if ($exe) {
								$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ?  , CU_DAY = ? , CU_MONTH = ? , CU_YEAR = ? WHERE CU_INSTCODE = ? ";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $form_key);
                                $st->BindParam(2, $shiftname);
                                $st->BindParam(3, $shifttype);
                                $st->BindParam(4, $days);
                                $st->BindParam(5, $shiftstart);
                                $st->BindParam(6, $shiftend);
                                $st->BindParam(7, $currenttime);
                                $st->BindParam(8, $shiftday);
								$st->BindParam(9, $shiftmonth);
								$st->BindParam(10, $shiftyear);
								$st->BindParam(11, $instcode);
                                $ups = $st->Execute();
                                if ($ups) {
                                    return '2';
                                } else {
                                    return '0';
                                }

                            }else{
								return '0';
							}

                        }else{
							$sql = "UPDATE octopus_current SET CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $currenttime);
							$st->BindParam(2, $instcode);
							$ups = $st->Execute();
							return '0';
						}
                    }else{
						return '0';
					}   

			}else if($currenttime < $currentlastcheck){
			//	die('testing');

				$sql = ("SELECT * FROM octopus_admin_shifttypes where SHT_STARTTIME < ? and SHT_ENDTIME > ? and SHT_INSTCODE = ? ");
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $currenttime);
				$st->BindParam(2, $currenttime);
				$st->BindParam(3, $instcode);
				$exe = $st->execute();
                    if ($exe) {
                        if ($st->rowcount()>0) {
							$object =  $st->fetch(PDO::FETCH_ASSOC);
							$shifttype = $object['SHT_SHIFTTYPE'];
							$shiftstart = $object['SHT_STARTTIME'];
							$shiftend = $object['SHT_ENDTIME'];
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());
							$shiftday = date('d M Y', strtotime($day));
							$shiftmonth = date('M Y', strtotime($day));
							$shiftyear = date('Y', strtotime($day));

							$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
                            $st = $this->db->prepare($sql);
                            $st->BindParam(1, $form_key);
                            $st->BindParam(2, $days);
                            $st->BindParam(3, $shiftname);
                            $st->BindParam(4, $shifttype);
                            $st->BindParam(5, $currentusercode);
                            $st->BindParam(6, $currentuser);
                            $st->BindParam(7, $days);
                            $st->BindParam(8, $instcode);
                            $st->BindParam(9, $shiftstart);
                            $st->BindParam(10, $shiftend);
                            $exe = $st->execute();
                            if ($exe) {
								$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ? , CU_DAY = ? , CU_MONTH = ? , CU_YEAR = ? WHERE CU_INSTCODE = ? ";
                                $st = $this->db->prepare($sql);
                                $st->BindParam(1, $form_key);
                                $st->BindParam(2, $shiftname);
                                $st->BindParam(3, $shifttype);
                                $st->BindParam(4, $days);
                                $st->BindParam(5, $shiftstart);
                                $st->BindParam(6, $shiftend);
                                $st->BindParam(7, $currenttime);
                                $st->BindParam(8, $shiftday);
								$st->BindParam(9, $shiftmonth);
								$st->BindParam(10, $shiftyear);
								$st->BindParam(11, $instcode);
                                $ups = $st->Execute();
                                if ($ups) {
                                    return '2';
                                } else {
                                    return '0';
                                }

                            }else{
								return '0';
							}

                        }else{
							$sql = "UPDATE octopus_current SET CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
							$st = $this->db->prepare($sql);
							$st->BindParam(1, $currenttime);
							$st->BindParam(2, $instcode);
							$ups = $st->Execute();
							return '0';
						}
                    }else{
						return '0';
					}
   
			}else{
				return '0';
			}
		}

        } else {
            return '0';
        }
    }	
           

	// 27 JAN 2021
	public function update_editunits($ekey,$units,$currentusercode,$currentuser){
		
		$rt = 1;
		$sql = "UPDATE octopus_st_units SET UN_NAME = ?, UN_ACTOR = ?, UN_ACTORCODE = ?  WHERE UN_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $units);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);		
		$exe = $st->execute();		
		if($exe){			
			return '2';
		}else{			
			return '0';			
		}	

	}
	
	// 27 JAN 2021   JOSEPH ADORBOE
	public function insert_addunits($form_key,$units,$currentusercode,$currentuser,$instcode){
		
		$but = 1;
		$sqlstmt = ("SELECT UN_ID FROM octopus_st_units where UN_NAME = ? and UN_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $units);
		$st->BindParam(2, $but);
		$extp = $st->execute();

		if($extp){

			if($st->rowcount() > 0){
			
				return '1';
				
			}else{	

				$sqlstmt = "INSERT INTO octopus_st_units(UN_CODE,UN_NAME,UN_ACTOR,UN_ACTORCODE) VALUES (?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $units);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$exe = $st->execute();	
				
				if($exe){
										
					return '2';
					
				}else{
					
					return '0';
					
				}
			}

		}else{

			return '0';


		}
		

	}

	
	// 25 JAN 2021
	public function update_editdosageform($ekey,$dosageform,$currentusercode,$currentuser){
		
		$rt = 1;
		$sql = "UPDATE octopus_st_dosageform SET DF_NAME = ?, DF_ACTOR = ?, DF_ACTORCODE = ?  WHERE DF_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $dosageform);
		$st->BindParam(2, $currentuser);
		$st->BindParam(3, $currentusercode);
		$st->BindParam(4, $ekey);
		
		$exe = $st->execute();
		
		if($exe){
			
			return '2';
			
		}else{
			
			return '0';
			
		}

		

	}


	// 27 JAN 2021   JOSEPH ADORBOE
	public function insert_dosageform($form_key,$dosageform,$currentusercode,$currentuser,$instcode){
		
		$but = 1;
		$sqlstmt = ("SELECT DF_ID FROM octopus_st_dosageform where DF_NAME = ? and DF_STATUS =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $dosageform);
		$st->BindParam(2, $but);
		$extp = $st->execute();

		if($extp){

			if($st->rowcount() > 0){
			
				return '1';
				
			}else{	

				$sqlstmt = "INSERT INTO octopus_st_dosageform(DF_CODE,DF_NAME,DF_ACTOR,DF_ACTORCODE) VALUES (?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $dosageform);
				$st->BindParam(3, $currentuser);
				$st->BindParam(4, $currentusercode);
				$exe = $st->execute();	
				
				if($exe){
										
					return '2';
					
				}else{
					
					return '0';
					
				}
			}

		}else{

			return '0';


		}
		

	}



	// 25 JAN 2021
	public function update_patientfileed($ekey,$finame){
		
		$rt = 1;
		$sql = "UPDATE octopus_patients SET PATIENT_FOLDERNAME = ?, PATIENT_FOLDERATTACHED = ? WHERE PATIENT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $finame);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $ekey);
		
		$exe = $st->execute();
		
		if($exe){
			
			return '2';
			
		}else{
			
			return '0';
			
		}

		

	}

	


	// 17 JAN 2021   JOSEPH ADORBOE
	public function insert_patientpaymentscheme($form_key,$ekey,$patientnumber,$patient,$paymentschemecode,$paymentscheme,$paymentmethodcode,$paymethname,$patientcardno,$expirydate,$currentusercode,$currentuser,$instcode,$day,$paymentplan){
		
		$nt = 1; 
		$sqlstmt = ("SELECT * FROM octopus_patients_paymentschemes where PAY_PATIENTCODE = ? and PAY_STATUS =? and PAY_INSTCODE =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $ekey);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				$sql = "UPDATE octopus_patients_paymentschemes SET PAY_PAYMENTMETHODCODE = ?, PAY_PAYMENTMETHOD =  ? , PAY_SCHEMECODE =?, PAY_SCHEMENAME =? , PAY_CARDNUM = ? , PAY_ENDDT = ?, PAY_ACTOR =?, PAY_ACTORCODE =? , PAY_PLAN =?  WHERE PAY_PATIENTCODE = ?  ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $paymethname);
				$st->BindParam(2, $paymentmethodcode);
				$st->BindParam(3, $paymentschemecode);	
				$st->BindParam(4, $paymentscheme);
				$st->BindParam(5, $patientcardno);
				$st->BindParam(6, $expirydate);	
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);	
				$st->BindParam(9, $paymentplan);
				$st->BindParam(10, $ekey);
				$exe = $st->execute();				
				if($exe){					
					return '2';					
				}else{					
					return '0';					
				}
			}else{
				$sqlstmt = "INSERT INTO octopus_patients_paymentschemes(PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_CARDNUM,PAY_ENDDT,PAY_ACTOR,PAY_ACTORCODE,PAY_INSTCODE,PAY_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $ekey);
				$st->BindParam(3, $patientnumber);
				$st->BindParam(4, $patient);
				$st->BindParam(5, $day);
				$st->BindParam(6, $paymethname);
				$st->BindParam(7, $paymentmethodcode);
				$st->BindParam(8, $paymentschemecode);
				$st->BindParam(9, $paymentscheme);
				$st->BindParam(10, $patientcardno);
				$st->BindParam(11, $expirydate);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $paymentplan);
				$exe = $st->execute();				
				if($exe){					
					return '2';						
				}else{					
					return '0';					
				}
			}
		}else{
			return '0';
		}
	}
	
	// 14 JAN 2021
	public function update_patientgroup($ekey,$groupname,$desc,$currentusercode,$currentuser,$instcode){
		
		$rt = 0;
		$sql = "UPDATE octopus_patients_groups SET GRP_NAME = ?, GRP_DESC = ?, GRP_ACTOR = ?, GRP_ACTORCODE = ?  WHERE GRP_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $groupname);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$exe = $st->execute();
		
		if($exe){
			
			return '2';
			
		}else{
			
			return '0';
			
		}	

	}


	// 14 JAN 2021
	public function update_patientgroupsmembersremove($form_key,$ekey,$vkey,$currentusercode,$currentuser,$instcode){
		
		$rt = '';
		$sql = "UPDATE octopus_patients SET PATIENT_GROUPCODE = ?, PATIENT_GROUP = ? WHERE PATIENT_CODE = ?  and PATIENT_INSTCODE = ?";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $rt);
		$st->BindParam(2, $rt);
		$st->BindParam(3, $ekey);
		$st->BindParam(4, $instcode);
	
		$exe = $st->execute();
		
		if($exe){
			
			$rt = 1 ;
			$sql = "UPDATE octopus_patients_groups SET GRP_MEMBERS = GRP_MEMBERS - ?  WHERE GRP_CODE = ? ";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $rt);
			$st->BindParam(2, $vkey);
			
			$exe = $st->execute();
			
			if($exe){
				
				return '2';
				
			}else{
				
				return '0';
				
			}	
			
		}else{
			
			return '0';
			
		}	
	

}

	
	// 14 jan 2021
	public function update_patientgroupsmembers($form_key,$groupcode,$groupname,$grouppatientnumber,$currentusercode,$currentuser,$instcode){
						
		
		$nt = 1; 
		$sqlstmt = ("SELECT PATIENT_CODE FROM octopus_patients where PATIENT_PATIENTNUMBER = ? and PATIENT_STATUS =? and PATIENT_INSTCODE = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $grouppatientnumber);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
	//	$st->BindParam(4, $groupcode); and PATIENT_GROUPCODE = ?
		$rtd = $st->execute();

		if($rtd){

			if($st->rowcount() > 0){

				
			$rt = 0;
			$sql = "UPDATE octopus_patients SET PATIENT_GROUPCODE = ?, PATIENT_GROUP = ? WHERE PATIENT_PATIENTNUMBER = ?  and PATIENT_INSTCODE = ?";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $groupcode);
			$st->BindParam(2, $groupname);
			$st->BindParam(3, $grouppatientnumber);
			$st->BindParam(4, $instcode);
		
			$exe = $st->execute();
			
			if($exe){
				
				$rt = 1 ;
				$sql = "UPDATE octopus_patients_groups SET GRP_MEMBERS = GRP_MEMBERS + ?  WHERE GRP_CODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $rt);
				$st->BindParam(2, $groupcode);
				
				$exe = $st->execute();
				
				if($exe){
					
					return '2';
					
				}else{
					
					return '0';
					
				}	
				
			}else{
				
				return '0';
				
			}	


			}else{

				return '3';
			}

		}else{

			return '0';

		}
		
		

			
		

	}


	// 14 JAN 2021   JOSEPH ADORBOE
	public function insert_patientgroups($form_key,$patientgroup,$groupdesc,$patientnumber,$day,$currentusercode,$currentuser,$instcode){		
		$nt = 1; 
		$sqlstmt = ("SELECT GRP_ID FROM octopus_patients_groups where GRP_NAME = ? and GRP_STATUS =? and GRP_INSTCODE =? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientgroup);
		$st->BindParam(2, $nt);
		$st->BindParam(3, $instcode);
		$extp = $st->execute();
		if($extp){
			if($st->rowcount() > 0){			
				return '1';				
			}else{	

				$nt = 1; 
				$sqlstmt = ("SELECT * FROM octopus_patients where PATIENT_PATIENTNUMBER = ? AND PATIENT_INSTCODE = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientnumber);
				$st->BindParam(2, $instcode);
				$frt = $st->execute();
				if($frt){
					if($st->rowcount() > 0){				
						$row = $st->fetch(PDO::FETCH_ASSOC);    
						$pcode = $row['PATIENT_CODE'];
						$pname = $row['PATIENT_NAMES'];

						$sqlstmt = "INSERT INTO octopus_patients_groups(GRP_CODE,GRP_NAME,GRP_DESC,GRP_MEMBERS,GRP_PATIENTCODE,GRP_PATIENTNUMBER,GRP_PATIENT,GRP_ACTOR,GRP_ACTORCODE,GRP_INSTCODE,GRP_DATE) VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
						$st = $this->db->prepare($sqlstmt);   
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $patientgroup);
						$st->BindParam(3, $groupdesc);
						$st->BindParam(4, $nt);
						$st->BindParam(5, $pcode);
						$st->BindParam(6, $patientnumber);
						$st->BindParam(7, $pname);
						$st->BindParam(8, $currentuser);
						$st->BindParam(9, $currentusercode);
						$st->BindParam(10, $instcode);
						$st->BindParam(11, $day);
						$exe = $st->execute();		
						
						if($exe){
									$sql = "UPDATE octopus_patients SET PATIENT_GROUP = ?, PATIENT_GROUPCODE =  ?  WHERE PATIENT_CODE = ?  ";
									$st = $this->db->prepare($sql);
									$st->BindParam(1, $patientgroup);
									$st->BindParam(2, $form_key);
									$st->BindParam(3, $pcode);			
									$exe = $st->execute();									
									if($exe){										
										return '2';										
									}else{										
										return '0';										
									}							
						}else{							
							return '0';							
						}
					}else{
						return '3';						
					}
				}else{
					return '3';
				}
			}
		}else{
			return '0';
		}
	}


	// 14 JAN 2021 , JOSEPH ADORBOE  
	public function getpassedvalues($idvalue){
		$sql = ("SELECT * from octopus_passvalues where PASS_KEY = ?");
    	$st = $this->db->prepare($sql);
   		$st->BindParam(1, $idvalue);
		$st->execute();
			if($st->rowcount()>0){
				$row = $st->fetch(PDO::FETCH_ASSOC);    
				$evalue = $row['PASS_VALUE'];
				return $evalue ;
			}else{
				return '0';
			}	
	}

	// 14 JAN 2021 , JOSEPH ADORBOE  
    public function passingvalues($pkey,$value){		
		$sql = ("INSERT INTO octopus_passvalues (PASS_KEY,PASS_VALUE) VALUES (?,?) ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $pkey);
		$st->BindParam(2, $value);	
		$st->execute();						
	}

	

	// 8 JAN 2021   JOSEPH ADORBOE
    public function admin_singlepricing($form_key,$sercode,$sername,$paycode,$payname,$schcode,$schname,$price,$day,$type,$currentusercode,$currentuser,$instcode){	
		$rt = 1;
		$sqlstmt = ("SELECT PS_ID FROM octopus_st_pricing where PS_ITEMCODE = ? and  PS_PAYMENTMETHODCODE = ? and PS_PAYSCHEMECODE = ? and PS_INSTCODE = ? and PS_STATUS = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $sercode);
		$st->BindParam(2, $paycode);
		$st->BindParam(3, $schcode);
		$st->BindParam(4, $instcode);
		$st->BindParam(5, $type);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';
		}else{				
		$sqlstmt = "INSERT INTO octopus_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYMENTMETHOD,PS_PAYMENTMETHODCODE,PS_PAYSCHEMECODE,PS_PAYSCHEME,PS_ACTORCODE,PS_ACTOR,PS_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $type);
		$st->BindParam(3, $sercode);
		$st->BindParam(4, $sername);
		$st->BindParam(5, $price);
		$st->BindParam(6, $payname);
		$st->BindParam(7, $paycode);
		$st->BindParam(8, $schcode);
		$st->BindParam(9, $schname);
		$st->BindParam(10, $currentusercode);
		$st->BindParam(11, $currentuser);
		$st->BindParam(12, $instcode);
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	
	}
	}

	// 6 JAN 2021   JOSEPH ADORBOE
    public function insert_phonebook($fk,$form_key,$newpatientnumber,$fullname,$patientphone,$smsphone,$instcode,$currentuser,$currentusercode){	
		$sqlstmt = ("SELECT PH_ID FROM octopus_phonebook where PH_PHONENUMBER = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $patientphone);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{			
		$sqlstmt = "INSERT INTO octopus_phonebook(PH_CODE,PH_PATIENTCODE,PH_PATIENTNUMBER,PH_PATIENT,PH_PHONENUMBER,PH_SMSPHONE,PH_ACTOR,PH_ACTORCODE,PH_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $fk);
		$st->BindParam(2, $form_key);
		$st->BindParam(3, $newpatientnumber);
		$st->BindParam(4, $fullname);
		$st->BindParam(5, $patientphone);
		$st->BindParam(6, $smsphone);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);
		$st->BindParam(9, $instcode);
		$exe = $st->execute();			
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}	
	}
	}	

	// 6 JAN 2021,  JOSEPH ADORBOE
    public function insert_patientregistration($form_key,$newpatientnumber,$patienttitle,$patientfirstname,$patientlastname,$fullname,$days,$patientbirthdate,$patientgender,$patientreligion,$patientmaritalstatus,$currentusercode,$currentuser,$instcode,$patientoccupation,$theyear,$theserial,$patientnationality,$patienthomeaddress,$patientphone,$patientaltphone,$paymentmenthodname,$paymentmethodcode,$patientemergencyone,$patientemergencytwo,$smsphone,$smsphoned,$fk,$patientemail,$patientpostal,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$paymentschemecode,$paymentschemename,$patientcardnumber,$patientcardexpirydate,$requestservices,$servicescode,$servicesname,$visitcode,$currentshiftcode,$currentshift,$servicerequestcode,$billingcode,$billingitemcode,$patientage,$amount,$newfolderamount,$billamount,$billingnewfolderitemcode,$filenamed){
		$mt = 1;
		$sqlstmt = ("SELECT PATIENT_ID FROM octopus_patients where PATIENT_PATIENTNUMBER = ? AND PATIENT_INSTCODE = ? AND PATIENT_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newpatientnumber);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{		
		$sqlstmt = "INSERT INTO octopus_patients(PATIENT_CODE,PATIENT_PATIENTNUMBER,PATIENT_DATE,PATIENT_FIRSTNAME,PATIENT_LASTNAME,PATIENT_NAMES,PATIENT_TITLE,PATIENT_INSTCODE,PATIENT_DOB,PATIENT_GENDER,PATIENT_RELIGION,PATIENT_MARITAL,PATIENT_OCCUPATION,PATIENT_YEAR,PATIENT_SERIAL,PATIENT_NATIONALITY,PATIENT_HOMEADDRESS,PATIENT_PHONENUMBER,PATIENT_ALTPHONENUMBER,PATIENT_PAYMENTMETHOD,PATIENT_PAYMENTMETHODCODE,PATIENT_ACTOR,PATIENT_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $newpatientnumber);
		$st->BindParam(3, $days);
		$st->BindParam(4, $patientfirstname);
		$st->BindParam(5, $patientlastname);
		$st->BindParam(6, $fullname);
		$st->BindParam(7, $patienttitle);
		$st->BindParam(8, $instcode);
		$st->BindParam(9, $patientbirthdate);
		$st->BindParam(10, $patientgender);
		$st->BindParam(11, $patientreligion);
		$st->BindParam(12, $patientmaritalstatus);
		$st->BindParam(13, $patientoccupation);
		$st->BindParam(14, $theyear);
		$st->BindParam(15, $theserial);
		$st->BindParam(16, $patientnationality);
		$st->BindParam(17, $patienthomeaddress);
		$st->BindParam(18, $patientphone);
		$st->BindParam(19, $patientaltphone);
		$st->BindParam(20, $paymentmenthodname);
		$st->BindParam(21, $paymentmethodcode);
		$st->BindParam(22, $currentuser);
		$st->BindParam(23, $currentusercode);		
		$exe = $st->execute();
		if($exe){
			if(!empty($patientphone)){
				$sqlstmt = ("SELECT PH_ID FROM octopus_phonebook where PH_PHONENUMBER = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientphone);
				$st->execute();				
				if($st->rowcount() < 1){								
				$sqlstmt = "INSERT INTO octopus_phonebook(PH_CODE,PH_PATIENTCODE,PH_PATIENTNUMBER,PH_PATIENT,PH_PHONENUMBER,PH_SMSPHONE,PH_ACTOR,PH_ACTORCODE,PH_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $fk);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $patientphone);
				$st->BindParam(6, $smsphone);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$exe = $st->execute();

				}	
			}

			if(!empty($patientaltphone)){
				$sqlstmt = ("SELECT PH_ID FROM octopus_phonebook where PH_PHONENUMBER = ? ");
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $patientaltphone);
				$st->execute();				
				if($st->rowcount() < 1){					
					$fk = $form_key.'@@';								
				$sqlstmt = "INSERT INTO octopus_phonebook(PH_CODE,PH_PATIENTCODE,PH_PATIENTNUMBER,PH_PATIENT,PH_PHONENUMBER,PH_SMSPHONE,PH_ACTOR,PH_ACTORCODE,PH_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $fk);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $patientaltphone);
				$st->BindParam(6, $smsphoned);
				$st->BindParam(7, $currentuser);
				$st->BindParam(8, $currentusercode);
				$st->BindParam(9, $instcode);
				$exe = $st->execute();

				}
			}
			$sqlstmt = "INSERT INTO octopus_patients_contacts(PC_CODE,PC_PATIENTCODE,PC_PATIENTNUMBER,PC_PATIENT,PC_DATE,PC_PHONE,PC_PHONEALT,PC_HOMEADDRESS,PC_EMAIL,PC_POSTAL,PC_EMERGENCYONE,PC_EMERGENCYTWO,PC_ACTOR,PC_ACTORCODE,PC_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $form_key);
			$st->BindParam(3, $newpatientnumber);
			$st->BindParam(4, $fullname);
			$st->BindParam(5, $days);
			$st->BindParam(6, $patientphone);
			$st->BindParam(7, $patientaltphone);
			$st->BindParam(8, $patienthomeaddress);
			$st->BindParam(9, $patientemail);
			$st->BindParam(10, $patientpostal);
			$st->BindParam(11, $patientemergencyone);
			$st->BindParam(12, $patientemergencytwo);
			$st->BindParam(13, $currentuser);
			$st->BindParam(14, $currentusercode);
			$st->BindParam(15, $instcode);			
			$exe = $st->execute();
			
			if($paymentmethodcode == $privateinsurancecode  || $paymentmethodcode == $nationalinsurancecode || $paymentmethodcode == $partnercompaniescode){

				$sqlstmt = "INSERT INTO octopus_patients_paymentschemes(PAY_CODE,PAY_PATIENTCODE,PAY_PATIENTNUMBER,PAY_PATIENT,PAY_DATE,PAY_PAYMENTMETHODCODE,PAY_PAYMENTMETHOD,PAY_SCHEMECODE,PAY_SCHEMENAME,PAY_ENDDT,PAY_CARDNUM,PAY_ACTOR,PAY_ACTORCODE,PAY_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $days);
				$st->BindParam(6, $paymentmethodcode);
				$st->BindParam(7, $paymentmenthodname);
				$st->BindParam(8, $paymentschemecode);
				$st->BindParam(9, $paymentschemename);
				$st->BindParam(10, $patientcardexpirydate);
				$st->BindParam(11, $patientcardnumber);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$exe = $st->execute();			
			}

			If($requestservices == 'YES'){
				$sqlstmt = "INSERT INTO octopus_patients_visit(VISIT_CODE,VISIT_PATIENTCODE,VISIT_PATIENTNUMBER,VISIT_PATIENT,VISIT_DATE,VISIT_SERVICECODE,VISIT_SERVICE,VISIT_PAYMENTMETHOD,VISIT_PAYMENTMETHODCODE,VISIT_PAYMENTSCHEME,VISIT_PAYMENTSCHEMECODE,VISIT_ACTOR,VISIT_ACTORCODE,VISIT_INSTCODE,VISIT_SHIFTCODE,VISIT_SHIFT,VISIT_GENDER,VISIT_AGE) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmt);   
				$st->BindParam(1, $visitcode);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $days);
				$st->BindParam(6, $servicescode);
				$st->BindParam(7, $servicesname);
				$st->BindParam(8, $paymentmenthodname);
				$st->BindParam(9, $paymentmethodcode);
				$st->BindParam(10, $paymentschemename);
				$st->BindParam(11, $paymentschemecode);
				$st->BindParam(12, $currentuser);
				$st->BindParam(13, $currentusercode);
				$st->BindParam(14, $instcode);
				$st->BindParam(15, $currentshiftcode);
				$st->BindParam(16, $currentshift);
				$st->BindParam(17, $patientgender);
				$st->BindParam(18, $patientage);
				$exe = $st->execute();
			
				$sqlstmtserv = "INSERT INTO octopus_patients_servicesrequest(REQU_CODE,REQU_VISITCODE,REQU_BILLCODE,REQU_DATE,REQU_PATIENTCODE,REQU_PATIENTNUMBER,REQU_PATIENT,REQU_AGE,REQU_GENDER,REQU_PAYMENTMETHOD,REQU_PAYMENTMETHODCODE,REQU_PAYSCHEMECODE,REQU_PAYSCHEME,REQU_SERVICECODE,REQU_SERVICE,REQU_ACTOR,REQU_ACTORCODE,REQU_INSTCODE,REQU_SHIFTCODE,REQU_SHIFT) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtserv);   
				$st->BindParam(1, $servicerequestcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $form_key);
				$st->BindParam(6, $newpatientnumber);
				$st->BindParam(7, $fullname);
				$st->BindParam(8, $patientage);
				$st->BindParam(9, $patientgender);
				$st->BindParam(10, $paymentmenthodname);
				$st->BindParam(11, $paymentmethodcode);
				$st->BindParam(12, $paymentschemecode);
				$st->BindParam(13, $paymentschemename);
				$st->BindParam(14, $servicescode);
				$st->BindParam(15, $servicesname);
				$st->BindParam(16, $currentuser);
				$st->BindParam(17, $currentusercode);
				$st->BindParam(18, $instcode);
				$st->BindParam(19, $currentshiftcode);
				$st->BindParam(20, $currentshift);
				$exed = $st->execute();				
				$sqlstmtbills = "INSERT INTO octopus_patients_bills(BILL_CODE,BILL_PATIENTCODE,BILL_PATIENTNUMBER,BILL_PATIENT,BILL_VISITCODE,BILL_DATE,BILL_AMOUNT,BILL_ACTOR,BILL_ACTORCODE,BILL_INSTCODE) 
				VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtbills);   
				$st->BindParam(1, $billingcode);
				$st->BindParam(2, $form_key);
				$st->BindParam(3, $newpatientnumber);
				$st->BindParam(4, $fullname);
				$st->BindParam(5, $visitcode);
				$st->BindParam(6, $days);
				$st->BindParam(7, $billamount);
				$st->BindParam(8, $currentuser);
				$st->BindParam(9, $currentusercode);
				$st->BindParam(10, $instcode);
				$exedd = $st->execute();
				$rtn = 1;
				$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
				B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
				,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtbillsitems);   
				$st->BindParam(1, $billingitemcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $days);
				$st->BindParam(6, $form_key);
				$st->BindParam(7, $newpatientnumber);
				$st->BindParam(8, $fullname);
				$st->BindParam(9, $servicesname);
				$st->BindParam(10, $servicescode);
				$st->BindParam(11, $paymentschemecode);
				$st->BindParam(12, $paymentschemename);
				$st->BindParam(13, $paymentmenthodname);
				$st->BindParam(14, $paymentmethodcode);
				$st->BindParam(15, $rtn);
				$st->BindParam(16, $amount);
				$st->BindParam(17, $amount);
				$st->BindParam(18, $amount);
				$st->BindParam(19, $currentuser);
				$st->BindParam(20, $currentusercode);
				$st->BindParam(21, $instcode);
				$st->BindParam(22, $currentshiftcode);
				$st->BindParam(23, $currentshift);
				$exedd = $st->execute();
				$rtn = 1;
				$newfoldercode = 'SER0001';
				$newfolder  = 'NEW FOLDER';
				$sqlstmtbillsitems = "INSERT INTO octopus_patients_billitems(B_CODE,B_VISITCODE,B_BILLCODE,B_DT,B_DTIME,
				B_PATIENTCODE,B_PATIENTNUMBER,B_PATIENT,B_ITEM,B_ITEMCODE,B_PAYSCHEMECODE,B_PAYSCHEME,B_METHOD,B_METHODCODE
				,B_QTY,B_COST,B_TOTAMT,B_CASHAMT,B_ACTOR,B_ACTORCODE,B_INSTCODE,B_SHIFTCODE,B_SHIFT) 
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sqlstmtbillsitems);   
				$st->BindParam(1, $billingnewfolderitemcode);
				$st->BindParam(2, $visitcode);
				$st->BindParam(3, $billingcode);
				$st->BindParam(4, $days);
				$st->BindParam(5, $days);
				$st->BindParam(6, $form_key);
				$st->BindParam(7, $newpatientnumber);
				$st->BindParam(8, $fullname);
				$st->BindParam(9, $newfolder);
				$st->BindParam(10, $newfoldercode);
				$st->BindParam(11, $paymentschemecode);
				$st->BindParam(12, $paymentschemename);
				$st->BindParam(13, $paymentmenthodname);
				$st->BindParam(14, $paymentmethodcode);
				$st->BindParam(15, $rtn);
				$st->BindParam(16, $newfolderamount);
				$st->BindParam(17, $newfolderamount);
				$st->BindParam(18, $newfolderamount);
				$st->BindParam(19, $currentuser);
				$st->BindParam(20, $currentusercode);
				$st->BindParam(21, $instcode);
				$st->BindParam(22, $currentshiftcode);
				$st->BindParam(23, $currentshift);
				$exedd = $st->execute();
			}
			return '2';			
		}else{			
			return '0';			
		}
	}	
	
	}	
	
	// 6 jan 2021,  JOSEPH ADORBOE
    public function setup_assignservices($form_key,$sercode,$sername,$faccode,$facname,$billable,$servicestate,$day,$currentusercode,$currentuser){	
		$mt = 1;
		$sqlstmt = ("SELECT SEV_ID FROM octopus_admin_services where SEV_SERVICECODE = ? AND SEV_INSTCODE = ? AND SEV_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $sercode);
		$st->BindParam(2, $faccode);
		$st->BindParam(3, $mt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_admin_services(SEV_CODE,SEV_SERVICECODE,SEV_SERVICES,SEV_INSTCODE,SEV_FACILITY,SEV_BILLABLE,SEV_STATE,SEV_DATE,SEV_ACTOR,SEV_ACTORCODE) VALUES (?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $sercode);
			$st->BindParam(3, $sername);
			$st->BindParam(4, $faccode);
			$st->BindParam(5, $facname);
			$st->BindParam(6, $billable);
			$st->BindParam(7, $servicestate);
			$st->BindParam(8, $day);
			$st->BindParam(9, $currentuser);
			$st->BindParam(10, $currentusercode);		
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
	// 6 JAN 2021
	public function setup_editservice($ekey,$servicename,$desc,$currentusercode,$currentuser){		
		$rt = 0;
		$sql = "UPDATE octopus_setup_services SET SE_NAME = ?, SE_DESC = ? WHERE SE_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $servicename);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $ekey);		
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}	
	
	// 6 JAN 2021,  JOSEPH ADORBOE
    public function setup_services($form_key,$servicecode,$services,$desc,$currentusercode,$currentuser){	
			$mt = 1;
			$sqlstmt = ("SELECT SE_CODE FROM octopus_setup_services where SE_NAME = ? ");
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $services);		
			$st->execute();			
		if($st->rowcount() > 0){			
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_setup_services(SE_CODE,SE_NAME,SE_DESC,SE_ACTOR,SE_ACTORCODE) VALUES (?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $servicecode);
			$st->BindParam(2, $services);
			$st->BindParam(3, $desc);
			$st->BindParam(4, $currentuser);
			$st->BindParam(5, $currentusercode);		
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}

	// 3 JAN 2021,  15 NOV 2022  JOSEPH ADORBOE
    public function insert_paymentscheme(String $form_key,String $newscheme,String $desc,String $paymentmethodcode,String $paymentmethodname,String $partnercode,String $partnername,String $schemepercentage,String $patientpercentage,String $plan,String $currentusercode,String $currentuser,String $instcode):int {	
		$mt = 1;
		$sqlstmt = ("SELECT PSC_ID FROM octopus_paymentscheme where PSC_SCHEMENAME = ? AND PSC_INSTCODE = ? AND PSC_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $newscheme);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$st->execute();		
	if($st->rowcount() > 0){		
		return '1';		
	}else{			
		$sqlstmt = "INSERT INTO octopus_paymentscheme(PSC_CODE,PSC_SCHEMENAME,PSC_DESC,PSC_COMPANY,PSC_COMPANYCODE,PSC_PAYMENTMETHOD,PSC_PAYMENTMETHODCODE,PSC_ACTOR,PSC_ACTORCODE,PSC_INSTCODE,PSC_SCHEMEPERCENTAGE,PSC_PATIENTPERCENTAGE,PSC_PLAN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $newscheme);
		$st->BindParam(3, $desc);
		$st->BindParam(4, $partnername);
		$st->BindParam(5, $partnercode);
		$st->BindParam(6, $paymentmethodname);
		$st->BindParam(7, $paymentmethodcode);
		$st->BindParam(8, $currentuser);
		$st->BindParam(9, $currentusercode);
		$st->BindParam(10, $instcode);
		$st->BindParam(11, $schemepercentage);
		$st->BindParam(12, $patientpercentage);
		$st->BindParam(13, $plan);
		$exe = $st->execute();
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}	
	}
	}

	// 15 NOV 2022 JOSEPH ADORBOE
	public function update_paymentscheme($ekey, $newscheme, $desc, $paymentmethodcode, $paymentmethodname, $partnercode, $partnername, $schemepercentage, $patientpercentage,$plan, $currentusercode, $currentuser, $instcode){		
		$rt = 0;
		$sql = "UPDATE octopus_paymentscheme SET PSC_SCHEMENAME = ? ,PSC_DESC =?  ,PSC_ACTOR = ? ,PSC_ACTORCODE = ? ,PSC_SCHEMEPERCENTAGE = ? ,PSC_PATIENTPERCENTAGE = ?, PSC_PLAN = ? WHERE PSC_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $newscheme);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $schemepercentage);
		$st->BindParam(6, $patientpercentage);
		$st->BindParam(7, $plan);
		$st->BindParam(8, $ekey);
		$exe = $st->execute();		
		if($exe){		
			$sql = "UPDATE octopus_patients_paymentschemes SET PAY_PLAN = ? WHERE PAY_SCHEMECODE = ?";
			$st = $this->db->prepare($sql);
			$st->BindParam(1, $plan);
			$st->BindParam(2, $ekey);
			// $st->BindParam(3, $currentuser);
			// $st->BindParam(4, $currentusercode);
			// $st->BindParam(5, $schemepercentage);
			// $st->BindParam(6, $patientpercentage);
			// $st->BindParam(7, $plan);
			// $st->BindParam(8, $ekey);
			$exe = $st->execute();	
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 3 JAN 2021
	public function update_paymentpartner($ekey,$partnername,$paymentmethodcode,$paymentmethodname,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode){		
		$rt = 0;
		$sql = "UPDATE octopus_paymentpartners SET COMP_NAME = ?, COMP_ADDRESS = ? , COMP_PHONENUMBER = ? , COMP_CONTACTPERSON = ? , COMP_CONTACTPERSONINFO = ?, COMP_REMARKS = ? , COMP_METHODCODE = ? , COMP_METHOD = ? WHERE COMP_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $partnername);
		$st->BindParam(2, $partneraddress);
		$st->BindParam(3, $phone);
		$st->BindParam(4, $contactperson);
		$st->BindParam(5, $contacts);
		$st->BindParam(6, $partnerremarks);
		$st->BindParam(7, $paymentmethodcode);
		$st->BindParam(8, $paymentmethodname);
		$st->BindParam(9, $ekey);
		$exe = $st->execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 3 jan 2021,  JOSEPH ADORBOE
    public function insert_paymentpartner($form_key,$paymentmethodcode,$paymentmethodname,$partnername,$partneraddress,$phone,$contactperson,$contacts,$partnerremarks,$currentusercode,$currentuser,$instcode){	
		$mt = 1;
		$sqlstmt = ("SELECT COMP_CODE FROM octopus_paymentpartners where COMP_NAME = ? AND COMP_INSTCODE = ? AND COMP_STATUS = ?  ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $partnername);
		$st->BindParam(2, $instcode);
		$st->BindParam(3, $mt);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_paymentpartners(COMP_CODE,COMP_NAME,COMP_ADDRESS,COMP_PHONENUMBER,COMP_CONTACTPERSON,COMP_CONTACTPERSONINFO,COMP_METHODCODE,COMP_METHOD,COMP_REMARKS,COMP_ACTOR,COMP_ACTORCODE,COMP_INSTCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $partnername);
			$st->BindParam(3, $partneraddress);
			$st->BindParam(4, $phone);
			$st->BindParam(5, $contactperson);
			$st->BindParam(6, $contacts);
			$st->BindParam(7, $paymentmethodcode);
			$st->BindParam(8, $paymentmethodname);
			$st->BindParam(9, $partnerremarks);
			$st->BindParam(10, $currentuser);
			$st->BindParam(11, $currentusercode);	
			$st->BindParam(12, $instcode);
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}	
	
	// 3 JAN 2021
	public function setup_editassignpaymentmethod($ekey,$paycode,$payname,$faccode,$facname,$day,$currentusercode,$currentuser){	
		$ngh = '2';
		$sql = "UPDATE octopus_admin_paymentmethod SET PAY_METHODCODE = ? ,PAY_METHOD = ? ,PAY_INSTCODE =? ,PAY_FACILITY = ? WHERE PAY_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paycode);
		$st->BindParam(2, $payname);
		$st->BindParam(3, $faccode);
		$st->BindParam(4, $facname);
		$st->BindParam(5, $ekey);	
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 3 JAN 2021 JOSEPH ADORBOE
	public function setup_assignpaymentmethod($form_key,$paycode,$payname,$faccode,$facname,$day,$currentusercode,$currentuser){			
		$nt = 1; 
		$sqlstmt = ("SELECT PAY_ID FROM octopus_admin_paymentmethod where PAY_METHODCODE =? AND PAY_INSTCODE = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $paycode);
		$st->BindParam(2, $faccode);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{					
		$sqlstmt = "INSERT INTO octopus_admin_paymentmethod(PAY_CODE,PAY_METHODCODE,PAY_METHOD,PAY_INSTCODE,PAY_FACILITY,PAY_DATE,PAY_ACTOR,PAY_ACTORCODE) VALUES (?,?,?,?,?,?,?,?) ";
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $form_key);
		$st->BindParam(2, $paycode);
		$st->BindParam(3, $payname);
		$st->BindParam(4, $faccode);
		$st->BindParam(5, $facname);
		$st->BindParam(6, $day);
		$st->BindParam(7, $currentuser);
		$st->BindParam(8, $currentusercode);		
		$exe = $st->execute();			
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}	
	}
	}
	
	// 02 JAN 2021
	public function setup_editpaymentmethod($ekey,$paymentmethod,$desc,$currentusercode,$currentuser){	
		$ngh = '2';
		$sql = "UPDATE octopus_setup_paymentmethod SET PM_METHOD = ?, PM_DESC = ?,PM_ACTOR = ? ,PM_ACTORCODE = ? WHERE PM_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $paymentmethod);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $currentusercode);
		$st->BindParam(5, $ekey);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}
		
	// 02 JAN 2021 JOSEPH ADORBOE
    public function setup_paymentmethod($form_key,$paymentmethod,$desc,$currentusercode,$currentuser){		
			$nt = 1; 
			$sqlstmt = ("SELECT PM_ID FROM octopus_setup_paymentmethod where PM_METHOD = ? and PM_STATUS =? ");
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $paymentmethod);
			$st->BindParam(2, $nt);
			$st->execute();			
			if($st->rowcount() > 0){				
				return '1';				
			}else{			
			$sqlstmt = "INSERT INTO octopus_setup_paymentmethod(PM_CODE,PM_METHOD,PM_DESC,PM_ACTOR,PM_ACTORCODE) VALUES (?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $paymentmethod);
			$st->BindParam(3, $desc);
			$st->BindParam(4, $currentuser);
			$st->BindParam(5, $currentusercode);
			$exe = $st->execute();				
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}		
		}
	}
			
	// 02 JAN 2020,  JOSEPH ADORBOE
    public function setupinsert_users($form_key,$inputusername,$fullname,$pwd,$nowday,$newuserkey,$faccode,$facname,$facsname,$ulevcode,$ulevname,$currentusercode,$currentuser){	
		$sqlstmt = ("SELECT USER_ID FROM octopus_users where USER_USERNAME = ? ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $inputusername);
		$st->execute();		
		if($st->rowcount() > 0){			
			return '1';			
		}else{				
			$sqlstmt = "INSERT INTO octopus_users(USER_CODE,USER_USERNAME,USER_PWD,USER_FULLNAME,USER_INSTCODE,USER_SHORTCODE,USER_USERKEY,USER_ACTOR,USER_ACTORCODE,USER_LEVEL,USER_LEVELNAME,USER_INSTNAME) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $inputusername);
			$st->BindParam(3, $pwd);
			$st->BindParam(4, $fullname);
			$st->BindParam(5, $faccode);
			$st->BindParam(6, $facsname);
			$st->BindParam(7, $newuserkey);
			$st->BindParam(8, $currentuser);
			$st->BindParam(9, $currentusercode);
			$st->BindParam(10, $ulevcode);
			$st->BindParam(11, $ulevname);	
			$st->BindParam(12, $facname);	
			$exe = $st->execute();
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}	
		}
	}
	
	
	// 01 JAN 2021 ,  JOSEPH ADORBOE
    public function closingshift($currentshiftcode,$days,$currentuser,$currentusercode,$instcode)
	{
		$nut = '0';
		$sql = "UPDATE octopus_shifts SET SHIFT_STATUS = ? WHERE SHIFT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $currentshiftcode);
		$ups = $st->Execute();				
			if($ups){
				$lastcheck = 26;										
				$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ? , CU_SHIFT = ? , CU_LASTCHECK = ?, CU_STARTSHIFT = ? , CU_ENDSHIFT = ?  WHERE CU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nut);
				$st->BindParam(2, $nut);
				$st->BindParam(3, $lastcheck);
				$st->BindParam(4, $nut);
				$st->BindParam(5, $nut);
				$st->BindParam(6, $instcode);
				$ups = $st->Execute();
				if($ups){
					return '2';
				}else{
					return '0';
				}					
			}else{					
				return '0';					
			}
	}		
		

	// 06 MAY 2021 JOSEPH ADORBOE
    public function automaticopenshift($day,$days,$currenttime,$currentusercode,$currentuser,$instcode)
	{
		$sql = ("SELECT * FROM octopus_admin_shifttypes where SHT_STARTTIME = ? and SHT_INSTCODE = ? ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $currenttime);
		$st->BindParam(2, $instcode);
		$exe = $st->execute();		
		if($exe){
			if($st->rowcount()>0){	
				$object =  $st->fetch(PDO::FETCH_ASSOC);
				$shifttype = $object['SHT_SHIFTTYPE'];
				$shiftstart = $object['SHT_STARTTIME'];
				$shiftend = $object['SHT_ENDTIME'];
				$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
				$form_key = md5(microtime());

						$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
						$st = $this->db->prepare($sql);   
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $day);
						$st->BindParam(3, $shiftname);
						$st->BindParam(4, $shifttype);
						$st->BindParam(5, $currentusercode);
						$st->BindParam(6, $currentuser);
						$st->BindParam(7, $days);
						$st->BindParam(8, $instcode);
						$st->BindParam(9, $shiftstart);
						$st->BindParam(10, $shiftend);				
						$exe = $st->execute();			
							if($exe){	
								$lastcheck = 25;						
								$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ?  WHERE CU_INSTCODE = ? ";
								$st = $this->db->prepare($sql);
								$st->BindParam(1, $form_key);
								$st->BindParam(2, $shiftname);
								$st->BindParam(3, $shifttype);
								$st->BindParam(4, $day);
								$st->BindParam(5, $shiftstart);
								$st->BindParam(6, $shiftend);
								$st->BindParam(7, $lastcheck);
								$st->BindParam(8, $instcode);
								$ups = $st->Execute();
								if($ups){
									return '2';
								}else{
									return '0';
								}						
						}else{						
							return '0';						
						}								
			}else{
				$lastcheck = 27;
				$sql = "UPDATE octopus_current SET CU_LASTCHECK = ?  WHERE CU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $currenttime);
				$st->BindParam(2, $instcode);				
				$ups = $st->Execute();
				if($ups){
					return '2';
				}else{
					return '0';
				}	
			}
		}else{
			return '0';
		}					
		
	}
	

	// 05 MAY 2021 JOSEPH ADORBOE
    public function automaticcloseopenshift($day,$days,$currentshiftcode,$currentshiftstart,$currentshiftend,$currentusercode,$currentuser,$instcode)
	{
		$nut = '0';
		$sql = "UPDATE octopus_shifts SET SHIFT_STATUS = ?   WHERE SHIFT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $nut);
		$st->BindParam(2, $currentshiftcode);
		$ups = $st->Execute();				
			if($ups){
				$lastcheck = 26;									
				$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ? , CU_SHIFT = ? , CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
				$st = $this->db->prepare($sql);
				$st->BindParam(1, $nut);
				$st->BindParam(2, $nut);
				$st->BindParam(3, $lastcheck);
				$st->BindParam(4, $instcode);
				$ups = $st->Execute();
				if($ups){

					$sql = ("SELECT * FROM octopus_admin_shifttypes where SHT_STARTTIME = ? and SHT_INSTCODE = ? ");
					$st = $this->db->prepare($sql);   
					$st->BindParam(1, $currentshiftstart);
					$st->BindParam(2, $instcode);
					$exe = $st->execute();		
					if($exe){
						if($st->rowcount()>0){	
							$object =  $st->fetch(PDO::FETCH_ASSOC);
							$shifttype = $object['SHT_SHIFTTYPE'];
							$shiftstart = $object['SHT_STARTTIME'];
							$shiftend = $object['SHT_ENDTIME'];
							$shiftname = date('d M Y', strtotime($day)) .'@'.$shifttype;
							$form_key = md5(microtime());

									$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
									$st = $this->db->prepare($sql);   
									$st->BindParam(1, $form_key);
									$st->BindParam(2, $day);
									$st->BindParam(3, $shiftname);
									$st->BindParam(4, $shifttype);
									$st->BindParam(5, $currentusercode);
									$st->BindParam(6, $currentuser);
									$st->BindParam(7, $days);
									$st->BindParam(8, $instcode);
									$st->BindParam(9, $shiftstart);
									$st->BindParam(10, $shiftend);				
									$exe = $st->execute();			
										if($exe){	
											$lastcheck = 25;					
											$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ? WHERE CU_INSTCODE = ? ";
											$st = $this->db->prepare($sql);
											$st->BindParam(1, $form_key);
											$st->BindParam(2, $shiftname);
											$st->BindParam(3, $shifttype);
											$st->BindParam(4, $day);
											$st->BindParam(5, $shiftstart);
											$st->BindParam(6, $shiftend);
											$st->BindParam(7, $lastcheck);
											$st->BindParam(8, $instcode);
											$ups = $st->Execute();
											if($ups){
												return '2';
											}else{
												return '0';
											}						
									}else{						
										return '0';						
									}								
						}else{
							return '2';
						}
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
				
				

	// 01 JAN 2021 ,  JOSEPH ADORBOE
    public function opennewshift($form_key,$day,$shiftname,$shftty,$days,$shftstart,$shftend,$currentuser,$currentusercode,$instcode)
	{
		$nty = '0';
		$sql = ("SELECT SHIFT_ID FROM octopus_shifts where SHIFT_DATE = ? and SHIFT_TYPE = ? and SHIFT_STATUS = ? and SHIFT_INSTCODE = ? ");
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $day);
		$st->BindParam(2, $shftty);
		$st->BindParam(3, $nty);
		$st->BindParam(4, $instcode);
 		$exe = $st->execute();		
		if($exe){			
			if($st->rowcount()>0){				
				return '1';				
			}else{				
				$sql = "INSERT INTO octopus_shifts(SHIFT_CODE,SHIFT_DATE,SHIFT_NAME,SHIFT_TYPE,SHIFT_OPENACTORCODE,SHIFT_OPENACTOR,SHIFT_OPENTIME,SHIFT_INSTCODE,SHIFT_START,SHIFT_END) VALUES (?,?,?,?,?,?,?,?,?,?) ";
				$st = $this->db->prepare($sql);   
				$st->BindParam(1, $form_key);
				$st->BindParam(2, $day);
				$st->BindParam(3, $shiftname);
				$st->BindParam(4, $shftty);
				$st->BindParam(5, $currentusercode);
				$st->BindParam(6, $currentuser);
				$st->BindParam(7, $days);
				$st->BindParam(8, $instcode);
				$st->BindParam(9, $shftstart);
				$st->BindParam(10, $shftend);				
				$exe = $st->execute();			
					if($exe){	
						$lastcheck = 25;								
						$sql = "UPDATE octopus_current SET CU_SHIFTCODE = ?, CU_SHIFT = ?, CU_SHFTTYPE = ? , CU_DATE = ?, CU_STARTSHIFT = ?, CU_ENDSHIFT = ? , CU_LASTCHECK = ?  WHERE CU_INSTCODE = ? ";
						$st = $this->db->prepare($sql);
						$st->BindParam(1, $form_key);
						$st->BindParam(2, $shiftname);
						$st->BindParam(3, $shftty);
						$st->BindParam(4, $day);
						$st->BindParam(5, $shftstart);
						$st->BindParam(6, $shftend);
						$st->BindParam(7, $lastcheck);
						$st->BindParam(8, $instcode);
						$ups = $st->Execute();
						if($ups){
							return '2';
						}else{
							return '0';
						}						
					}else{						
						return '0';						
					}			
				}	
		}else{				
			return '0';				
		}
	}

	// 1 JAN 2021
	public function setup_editassignfacility($ekey,$shtcode,$shtname,$faccode,$facname,$day,$currentusercode,$currentuser){		
		$ngh = '2';
		$sql = "UPDATE octopus_admin_shifttypes SET SHT_SHIFTTYPE = ? ,SHT_SHIFTTYPECODE = ? ,SHT_INSTCODE = ? ,SHT_FACILITY = ? WHERE SHT_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $shtname);
		$st->BindParam(2, $shtcode);
		$st->BindParam(3, $faccode);
		$st->BindParam(4, $facname);
		$st->BindParam(5, $ekey);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 1 JAN 2021
	public function setup_editfacility($ekey,$facilityname,$facilityaddress,$phonenumber,$currentusercode,$currentuser){	
		$ngh = '2';
		$sql = "UPDATE octopus_setup_facilities SET FAC_NAME = ?, FAC_ADDRESS = ? , FAC_PHONENUMBER = ? WHERE FAC_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $facilityname);
		$st->BindParam(2, $facilityaddress);
		$st->BindParam(3, $phonenumber);
		$st->BindParam(4, $ekey);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}

	// 31 DEC 2020
	public function setup_editshifttypes($ekey,$shifttypes,$desc,$currentusercode,$currentuser){		
		$ngh = '2';
		$sql = "UPDATE octopus_setup_shifttype SET SHTY_TYPE = ?, SHTY_DESC = ? WHERE SHTY_CODE = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $shifttypes);
		$st->BindParam(2, $desc);
		$st->BindParam(3, $ekey);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}	
	
	// 31 DEC 2020 JOSEPH ADORBOE
    public function setup_shifttypes($form_key,$shifttypes,$desc,$currentusercode,$currentuser){		
			$nt = 1; 
			$sqlstmt = ("SELECT SHTY_ID FROM octopus_setup_shifttype where SHTY_TYPE = ? and SHTY_STATUS =? ");
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $shifttypes);
			$st->BindParam(2, $nt);
			$st->execute();			
			if($st->rowcount() > 0){				
				return '1';				
			}else{				
			$sqlstmt = "INSERT INTO octopus_setup_shifttype(SHTY_CODE,SHTY_TYPE,SHTY_DESC,SHTY_ACTOR,SHTY_ACTORCODE) VALUES (?,?,?,?,?) ";
			$st = $this->db->prepare($sqlstmt);   
			$st->BindParam(1, $form_key);
			$st->BindParam(2, $shifttypes);
			$st->BindParam(3, $desc);
			$st->BindParam(4, $currentuser);
			$st->BindParam(5, $currentusercode);
			$exe = $st->execute();			
			if($exe){				
				return '2';				
			}else{				
				return '0';				
			}				
		}
	}

	// 30 DEC 2020
	public function updatepassword($newpassword,$userkey,$currentusername){		
		$pwd = $hash = md5($currentusername . $newpassword);
		$ngh = '2';
		$sql = "UPDATE octopus_users SET USER_PWD = ?, USER_CHG = ? WHERE USER_USERKEY = ? ";
		$st = $this->db->prepare($sql);
		$st->BindParam(1, $pwd);
		$st->BindParam(2, $ngh);
		$st->BindParam(3, $userkey);
		$exe = $st->Execute();		
		if($exe){			
			return '2';			
		}else{			
			return '0';			
		}
	}
	
	//  26 FEB 2021, 6 APR 2019 , JOSEPH ADORBOE  
    public function auditlog($form_key,$form_number,$currentusercode,$currentuser,$currentusername,$instcode,$eventcode,$event,$day){				
		$sqlstmt = ("INSERT INTO octopus_userlog (USLOG_USERCODE,USLOG_USERNAME,USLOG_FULLNAME,USLOG_LOGTYPECODE,USLOG_DESC,USLOG_DATE,USLOG_INSTCODE,USLOG_CODE) VALUES (?,?,?,?,?,?,?,?) ");
		$st = $this->db->prepare($sqlstmt);   
		$st->BindParam(1, $currentusercode);
		$st->BindParam(2, $currentusername);
		$st->BindParam(3, $currentuser);
		$st->BindParam(4, $eventcode);
		$st->BindParam(5, $event);
		$st->BindParam(6, $day);
		$st->BindParam(7, $instcode);
		$st->BindParam(8, $form_key);
		$exeuserlogs = $st->execute();
		if($exeuserlogs ){
			$sql = ("INSERT INTO octopus_userformlogs (FORM_NUMBER,FORM_KEY,FORM_ACTORCODE,FORM_ACTOR,FORM_INSTCODE) VALUES (?,?,?,?,?) ");
			$st = $this->db->prepare($sql);   
			$st->BindParam(1, $form_number);
			$st->BindParam(2, $form_key);
			$st->BindParam(3, $currentusercode);
			$st->BindParam(4, $currentuser);		
			$st->BindParam(5, $instcode);
			$exeformlogs = $st->execute();
			if($exeformlogs){
				return '2';
			}else{
				return '0';
			}

		}else{
			return '0';
		}					
	}
	
} 
?>