<?php
/*
AUTHOR: JOSEPH ADORBOE
DATE: 10 JAN 2021 getrecordsseerviceslov
PURPOSE: TO GENERATE LIST OF VALUES  
*/

class lov Extends Engine{

	public function getwounddressingLov(){
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "SER0047@@@WOUND DRESSING - LARGE  "> WOUND DRESSING - LARGE  </option>';	
		echo '<option value = "SER0048@@@WOUND DRESSING - MEDIUM  "> WOUND DRESSING - MEDIUM  </option>';	
		echo '<option value = "SER0049@@@WOUND DRESSING - SMALL  "> WOUND DRESSING - SMALL  </option>';		
	}

	// 31 DEC 2024  JOSEPH ADORBOE 
	public function getpatientpromotionstatusLov()
	{		
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "0"> Suspend </option>';
		echo '<option value = "1"> Pending </option>';	
		echo '<option value = "2"> Active </option>';		
	}
	// 28 DEC 2024  JOSEPH ADORBOE 
	public function getpromotionvalidityLov()
	{		
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "30"> 30 Days </option>';	
		echo '<option value = "60"> 60 Days </option>';	
		echo '<option value = "90"> 90 Days </option>';	
		echo '<option value = "120"> 120 Days </option>';	
		echo '<option value = "150"> 150 Days </option>';		
	}
	// 23 DEC 2024  JOSEPH ADORBOE 
	public function getpromotionstatusLov()
	{		
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "1"> Active </option>';	
		echo '<option value = "2"> Suspended </option>';		
	}

	// 23 DEC 2024  JOSEPH ADORBOE 
	public function getpromotionserviceLov()
	{		
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "SER0078@@@Physiotherapy Consultation [ Promotion ] "> Physiotherapy Consultation [ Promotion ]  </option>';		
	}
	// 23 DEC 2024  JOSEPH ADORBOE 
	public function getpromotiontypeLov()
	{		
		echo '<option value = "">-- Select --</option>';
		echo '<option value = "Service"> Service </option>';
		echo '<option value = "Device"> Device</option>';
		echo '<option value = "Medication"> Medication</option>';
		echo '<option value = "Procedure"> Procedure </option>';
		echo '<option value = "General Item"> General Item </option>';		
	}
	//27 MAY 2024 JOSEPH ADORBOE 
	public function getnurseserviceslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_admin_services where SEV_STATUS = '$mnm' and SEV_INSTCODE = '$instcode' and SEV_STATE = '3' ORDER BY SEV_SERVICES ASC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SEV_SERVICECODE'].'@@@'.$obj['SEV_SERVICES'].'">'.$obj['SEV_SERVICES'].' </option>';
		}			
	}


	// 22 NOV 2023  JOSEPH ADORBOE 
	public function getconsumableslov($instcode)
	{
		$mnm = 1;
		$sql = " SELECT * FROM octopus_st_consumables WHERE COM_STATUS = '1' AND COM_INSTCODE = '$instcode' ORDER BY COM_CONSUMABLE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['COM_CODE'].'@@@'.$obj['COM_CONSUMABLE'].'@@@'.$obj['COM_QTY'].'">'.$obj['COM_CONSUMABLE'].' </option>';
		}
	}

	// 10 NOV 2023
	public function getbatchlistlov($itemcode,$instcode)
	{
		$sql = " SELECT * FROM octopus_batches WHERE BATCH_INSTCODE = '$instcode' AND BATCH_ITEMCODE  = '$itemcode' AND BATCH_QTY > 0 AND BATCH_STATUS = '1' ORDER BY BATCH_ID ASC  LIMIT 100"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['BATCH_CODE'].'@@'.$obj['BATCH_QTY'].'@@'.$obj['BATCH_NUMBER'].'">'.$obj['BATCH_EXPIRY'].' - Batch: '.$obj['BATCH_NUMBER'].' - Qty: '.$obj['BATCH_QTY'].' </option>';
		}			
	}
	
	// 5 NOV 2023, 
	public function getconsumablevalue(String $instcode)
		{
		$one = 1;
		$zero = '0';
		$sql = " SELECT SUM(COM_STOCKVALUE) AS STOCKVALUE FROM octopus_st_consumables WHERE COM_INSTCODE = ? AND COM_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['STOCKVALUE'];				
				return $value;
			}else{
				return $zero ;
			}
		}else{
			return $zero ;
		}			
	}
	
	// 17 JULY 2023 JOSEPH ADORBOE 
	public function getschemeplanslov()
	{		
		echo '<option value= "">-- Select --</option>';
		echo "<option value='Executive'> Executive </option>";
		echo "<option value='Premium Plus'> Premium Plus </option>";
		echo "<option value='Premium'> Premium </option>";
		echo "<option value='Basic Plus'> Basic Plus</option>";
		echo "<option value='Basic'> Basic </option>";
		echo "<option value='Others'> Others </option>";		
	}


	// 26 JULY 2023 JOSEPH ADORBOE 
	public function getreviewservicesLov($instcode)
	{		
		echo '<option value= "">-- Select Service--</option>';
		echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
		echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP </option>";
		echo "<option value='SER0031@@@X RAY AND LAB REVIEW'>X RAY AND LAB REVIEW </option>";
		echo "<option value='SER0034@@@RHEUMATOLOGY  FOLLOW UP'>RHEUMATOLOGY FOLLOWUP</option>";
		echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOWUP'>PHYSICIAN SPECIALIST FOLLOWUP</option>";
		echo "<option value='SER0041@@@RHEUMATOLOGY TOPUP'>RHEUMATOLOGY TOPUP </option>";
		echo "<option value='SER0043@@@PHYSICIAN SPECIALIST TOPUP'>PHYSICIAN SPECIALIST TOPUP </option>";
		echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
		echo "<option value='SER0047@@@LARGE WOUND DRESSING'>LARGE WOUND DRESSING</option>";
		echo "<option value='SER0048@@@MEDIUM WOUND DRESSING'>MEDIUM WOUND DRESSING</option>";
		echo "<option value='SER0049@@@SMALL WOUND DRESSING'>SMALL WOUND DRESSING</option>";
		echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
		echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT</option>";
		echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE '>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
		echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE '>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
		echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
		echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
		echo "<option value='SER0071@@@PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)'>PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)</option>";
		echo "<option value='SER0072@@@PHYSIOTHERAPY - ULTRASOUND ONLY'>PHYSIOTHERAPY - ULTRASOUND ONLY</option>";
		echo "<option value='SER0074@@@DIETICAN CONSULTATIONS REVIEW'>DIETICAN CONSULTATIONS REVIEW</option>";
	}


	// 25 JULY 2023 JOSEPH ADORBOE 
	public function getreferalservicesLovs($instcode)
	{	
		$one = 1;
		// ,$patientphysiocheck
		echo '<option value= "">-- Select Service--</option>';
		echo "<option value='SER0019@@@GENERAL OPD FOLLOWUP'>GENERAL OPD</option>";
		echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
		echo "<option value='SER0023@@@ORTHOPEDIC SPECIALIST'>ORTHOPEDIC SPECIALIST</option>";
		echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP</option>";
		echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
		echo "<option value='SER0035@@@PHYSICIAN SPECIALIST'>PHYSICIAN SPECIALIST </option>";
		echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOWUP'>PHYSICIAN SPECIALIST FOLLOWUP</option>";
		echo "<option value='SER0043@@@PHYSICIAN SPECIALIST TOPUP'>PHYSICIAN SPECIALIST TOPUP</option>";
		echo "<option value='SER0031@@@REVIEW (LAB, IMAGING ,COMPLAINTS )'>REVIEW (LAB, IMAGING ,COMPLAINTS ) </option>";
		echo "<option value='SER0033@@@RHEUMATOLOGY '>RHEUMATOLOGY</option>";
		echo "<option value='SER0034@@@RHEUMATOLOGY FOLLOWUP'>RHEUMATOLOGY FOLLOWUP </option>";
		echo "<option value='SER0041@@@RHEUMATOLOGY TOP UP'>RHEUMATOLOGY TOP UP </option>";
		echo "<option value='SER0052@@@FAMILY MEDICINE'>FAMILY MEDICINE</option>";
		echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
		echo "<option value='SER0073@@@DIETICAN CONSULTATIONS '>DIETICAN CONSULTATIONS </option>";
		echo "<option value='SER0074@@@DIETICAN CONSULTATIONS FOLLOWUP'>DIETICAN CONSULTATIONS FOLLOWUP</option>";
	//	if($patientphysiocheck == '0' || $patientphysiocheck == '1'){ 
		echo "<option value='SER0063@@@PHYSIOTHERAPY - FIRST VISIT'>PHYSIOTHERAPY</option>";
		echo "<option value='SER0070@@@PHYSIOTHERAPY  + ULTRASOUND (FIRST TIME)'>PHYSIOTHERAPY + ULTRASOUND (FIRST TIME)</option>";
	//	}else{
		echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT</option>";
		echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE '>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
		echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE '>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
		echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
		echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
		echo "<option value='SER0071@@@PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)'>PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)</option>";
		echo "<option value='SER0072@@@PHYSIOTHERAPY - ULTRASOUND ONLY'>PHYSIOTHERAPY - ULTRASOUND ONLY</option>";	
	}	

	// 25 JULY 2023 JOSEPH ADORBOE 
	public function getfollowupservicesLov($instcode)
	{		
		echo '<option value= "">-- Select Service--</option>';
		echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
		echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP</option>";
		echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
		echo "<option value='SER0031@@@X RAY AND LAB REVIEW'> REVIEW ( X RAY AND LAB ) </option>";
		echo "<option value='SER0034@@@RHEUMATOLOGY FOLLOW UP'>RHEUMATOLOGY FOLLOW UP </option>";
		echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOW UP'>PHYSICIAN SPECIALIST FOLLOW UP</option>";
		echo "<option value='SER0052@@@FAMILY MEDICINE'>FAMILY MEDICINE</option>";
		echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
		echo "<option value='SER0073@@@DIETICAN CONSULTATIONS '>DIETICAN CONSULTATIONS </option>";
		echo "<option value='SER0074@@@DIETICAN CONSULTATIONS FOLLOWUP'>DIETICAN CONSULTATIONS FOLLOWUP</option>";
		echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT </option>";
		echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE'>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
		echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE'>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
		echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
		echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
		
	}	

	// // 17 JULY 2023 JOSEPH ADORBOE 
	// public function getschemeplanslov()
	// {		
	// 	echo '<option value= "">-- Select --</option>';
	// 	echo "<option value='Executive'> Executive </option>";
	// 	echo "<option value='Premium Plus'> Premium Plus </option>";
	// 	echo "<option value='Premium'> Premium </option>";
	// 	echo "<option value='Basic Plus'> Basic Plus</option>";
	// 	echo "<option value='Basic'> Basic </option>";
	// 	echo "<option value='Others'> Others </option>";		
	// }
	// // 26 JULY 2023 JOSEPH ADORBOE 
	// public function getreviewservicesLov($instcode)
	// {		
	// 	echo '<option value= "">-- Select Service--</option>';
	// 	echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
	// 	echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP </option>";
	// 	echo "<option value='SER0031@@@X RAY AND LAB REVIEW'>X RAY AND LAB REVIEW </option>";
	// 	echo "<option value='SER0034@@@RHEUMATOLOGY  FOLLOW UP'>RHEUMATOLOGY FOLLOWUP</option>";
	// 	echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOWUP'>PHYSICIAN SPECIALIST FOLLOWUP</option>";
	// 	echo "<option value='SER0041@@@RHEUMATOLOGY TOPUP'>RHEUMATOLOGY TOPUP </option>";
	// 	echo "<option value='SER0043@@@PHYSICIAN SPECIALIST TOPUP'>PHYSICIAN SPECIALIST TOPUP </option>";
	// 	echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
	// 	echo "<option value='SER0047@@@LARGE WOUND DRESSING'>LARGE WOUND DRESSING</option>";
	// 	echo "<option value='SER0048@@@MEDIUM WOUND DRESSING'>MEDIUM WOUND DRESSING</option>";
	// 	echo "<option value='SER0049@@@SMALL WOUND DRESSING'>SMALL WOUND DRESSING</option>";
	// 	echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
	// 	echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT</option>";
	// 	echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE '>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
	// 	echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE '>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
	// 	echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
	// 	echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
	// 	echo "<option value='SER0071@@@PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)'>PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)</option>";
	// 	echo "<option value='SER0072@@@PHYSIOTHERAPY - ULTRASOUND ONLY'>PHYSIOTHERAPY - ULTRASOUND ONLY</option>";
	// 	echo "<option value='SER0074@@@DIETICAN CONSULTATIONS REVIEW'>DIETICAN CONSULTATIONS REVIEW</option>";
	// }
	

	// // 25 JULY 2023 JOSEPH ADORBOE 
	// public function getreferalservicesLovs($instcode)
	// {	
	// 	$one = 1;
	// 	// ,$patientphysiocheck
	// 	echo '<option value= "">-- Select Service--</option>';
	// 	echo "<option value='SER0019@@@GENERAL OPD FOLLOWUP'>GENERAL OPD</option>";
	// 	echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
	// 	echo "<option value='SER0023@@@ORTHOPEDIC SPECIALIST'>ORTHOPEDIC SPECIALIST</option>";
	// 	echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP</option>";
	// 	echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
	// 	echo "<option value='SER0035@@@PHYSICIAN SPECIALIST'>PHYSICIAN SPECIALIST </option>";
	// 	echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOWUP'>PHYSICIAN SPECIALIST FOLLOWUP</option>";
	// 	echo "<option value='SER0043@@@PHYSICIAN SPECIALIST TOPUP'>PHYSICIAN SPECIALIST TOPUP</option>";
	// 	echo "<option value='SER0031@@@REVIEW (LAB, IMAGING ,COMPLAINTS )'>REVIEW (LAB, IMAGING ,COMPLAINTS ) </option>";
	// 	echo "<option value='SER0033@@@RHEUMATOLOGY '>RHEUMATOLOGY</option>";
	// 	echo "<option value='SER0034@@@RHEUMATOLOGY FOLLOWUP'>RHEUMATOLOGY FOLLOWUP </option>";
	// 	echo "<option value='SER0041@@@RHEUMATOLOGY TOP UP'>RHEUMATOLOGY TOP UP </option>";
	// 	echo "<option value='SER0052@@@FAMILY MEDICINE'>FAMILY MEDICINE</option>";
	// 	echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
	// 	echo "<option value='SER0073@@@DIETICAN CONSULTATIONS '>DIETICAN CONSULTATIONS </option>";
	// 	echo "<option value='SER0074@@@DIETICAN CONSULTATIONS FOLLOWUP'>DIETICAN CONSULTATIONS FOLLOWUP</option>";
	// //	if($patientphysiocheck == '0' || $patientphysiocheck == '1'){ 
	// 	echo "<option value='SER0063@@@PHYSIOTHERAPY - FIRST VISIT'>PHYSIOTHERAPY</option>";
	// 	echo "<option value='SER0070@@@PHYSIOTHERAPY  + ULTRASOUND (FIRST TIME)'>PHYSIOTHERAPY + ULTRASOUND (FIRST TIME)</option>";
	// //	}else{
	// 	echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT</option>";
	// 	echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE '>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
	// 	echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE '>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
	// 	echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
	// 	echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
	// 	echo "<option value='SER0071@@@PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)'>PHYSIOTHERAPY + ULTRASOUND (FOLLOW UP)</option>";
	// 	echo "<option value='SER0072@@@PHYSIOTHERAPY - ULTRASOUND ONLY'>PHYSIOTHERAPY - ULTRASOUND ONLY</option>";	
	// }	

	// // 25 JULY 2023 JOSEPH ADORBOE 
	// public function getfollowupservicesLov($instcode)
	// {		
	// 	echo '<option value= "">-- Select Service--</option>';
	// 	echo "<option value='SER0020@@@GENERAL OPD FOLLOWUP'>GENERAL OPD FOLLOWUP</option>";
	// 	echo "<option value='SER0024@@@ORTHOPEDIC SPECIALIST FOLLOWUP'>ORTHOPEDIC SPECIALIST FOLLOWUP</option>";
	// 	echo "<option value='SER0045@@@ORTHOPEDIC SPECIALIST TOPUP'>ORTHOPEDIC SPECIALIST TOPUP</option>";
	// 	echo "<option value='SER0031@@@X RAY AND LAB REVIEW'> REVIEW ( X RAY AND LAB ) </option>";
	// 	echo "<option value='SER0034@@@RHEUMATOLOGY FOLLOW UP'>RHEUMATOLOGY FOLLOW UP </option>";
	// 	echo "<option value='SER0036@@@PHYSICIAN SPECIALIST FOLLOW UP'>PHYSICIAN SPECIALIST FOLLOW UP</option>";
	// 	echo "<option value='SER0052@@@FAMILY MEDICINE'>FAMILY MEDICINE</option>";
	// 	echo "<option value='SER0053@@@FAMILY MEDICINE FOLLOWUP'>FAMILY MEDICINE FOLLOWUP</option>";
	// 	echo "<option value='SER0073@@@DIETICAN CONSULTATIONS '>DIETICAN CONSULTATIONS </option>";
	// 	echo "<option value='SER0074@@@DIETICAN CONSULTATIONS FOLLOWUP'>DIETICAN CONSULTATIONS FOLLOWUP</option>";
	// 	echo "<option value='SER0064@@@PHYSIOTHERAPY  - FOLLOWUP  VISIT'>PHYSIOTHERAPY  - FOLLOWUP  VISIT </option>";
	// 	echo "<option value='SER0065@@@PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE'>PHYSIOTHERAPY - ACUPUNTURE - SINGLE SITE </option>";
	// 	echo "<option value='SER0066@@@PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE'>PHYSIOTHERAPY  - ACUPUNTURE - MULTI SITE </option>";
	// 	echo "<option value='SER0067@@@PHYSIOTHERAPY - FULL BODY MASSAGE'>PHYSIOTHERAPY - FULL BODY MASSAGE</option>";
	// 	echo "<option value='SER0068@@@PHYSIOTHERAPY  - REFLEXOLOGY'>PHYSIOTHERAPY  - REFLEXOLOGY</option>";
		
	// }
	// 7 SEPT 2023
	public function getpastedshifts($instcode)
	{
		$sql = " SELECT * FROM octopus_shifts WHERE SHIFT_INSTCODE = '$instcode' AND SHIFT_STATUS = '0' ORDER BY SHIFT_ID DESC  LIMIT 100"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SHIFT_CODE'].'">'.$obj['SHIFT_NAME'].' </option>';
		}			
	}	

	// 16 MAY 2023
	public function gettotalmedicationqty(String $medcode): Int 
		{
		$one = 1;
		$sql = " SELECT MED_TOTALQTY AS TOTALQTY FROM octopus_st_medications WHERE MED_CODE = ? AND MED_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $medcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['TOTALQTY'];				
				return $value;
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}

	// 1 MAY 2023 JOSEPH ADORBOE
	public function getsearchmedicationslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_medications where MED_STATUS = '$mnm' and MED_STATE = '2' and MED_INSTCODE = '$instcode' order by MED_MEDICATION "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MED_CODE'].'">'.$obj['MED_MEDICATION'].' - '.$obj['MED_DOSAGE'].' </option>';
		}
	}

	// 1 MAY 2023 JOSEPH ADORBOE
	public function getsearchdeviceslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm'  and DEV_INSTCODE = '$instcode' order by DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'">'.$obj['DEV_DEVICE'].' </option>';
		}
	}


	// 1 MAY 2021
	public function getsearchprocedurelov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm'  and MP_INSTCODE = '$instcode' order by MP_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['MP_CODE'].'">'.$obj['MP_NAME'].' </option>';

            }
	}


	// 1 MAY 2023
	public function getsearchbillableservices($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_admin_services where SEV_STATUS = '$mnm' and SEV_INSTCODE = '$instcode' and SEV_BILLABLE = '1' ORDER BY SEV_SERVICES ASC  "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SEV_SERVICECODE'].'">'.$obj['SEV_SERVICES'].' </option>';
			}
			
	}


	

	// 11 APR 2022 JOSEPH ADORBOE
	public function getshiftlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_shifts where SHIFT_INSTCODE = '$instcode' AND SHIFT_ENDOFDAY = '0'  order by SHIFT_ID DESC Limit 50"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SHIFT_CODE'].'@@@'.$obj['SHIFT_NAME'].'@@@'.$obj['SHIFT_DATE'].'">'.$obj['SHIFT_NAME'].' </option>';
		}
	}

	// 06 FEB 2022 JOSEPH ADORBOE 
	public function getclaimsreportsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value=3> Claims List By Date</option>';
		echo '<option value=4> Claims List By Scheme</option>';
		echo '<option value=5> Patient Number </option>';
		
		//echo '<option value=1> Patient No.  Name  Claims No.</option>';
		//echo '<option value=2> Claims Date</option>';	
	}	

	// 24 JAN 2023 
	public function getbillingcashiercount($instcode,$day,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode,$creditcode,$prepaidcode)
	{
		$sql = "SELECT DISTINCT B_VISITCODE,B_DT FROM octopus_patients_billitems WHERE B_INSTCODE = '$instcode' AND B_DT = '$day' AND B_STATUS = 1 and B_METHODCODE IN('$privateinsurancecode','$nationalinsurancecode','$partnercompaniescode')"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$insurancecount  = $st->rowCount();
		
		$sql = "SELECT DISTINCT B_VISITCODE,B_DT FROM octopus_patients_billitems WHERE B_INSTCODE = '$instcode' AND B_DT = '$day' AND B_STATUS = 1 and B_METHODCODE IN('$cashpaymentmethodcode','$mobilemoneypaymentmethodcode','$chequescode','$creditcode','$prepaidcode')"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$noninsurancecount  = $st->rowCount();	
			
		$sql = "SELECT PPR_ID FROM octopus_patients_promotion WHERE PPR_INSTCODE = '$instcode'  AND PPR_PAID = '0' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();
		$promotioncount  = $st->rowCount();

		return $insurancecount.'@'.$noninsurancecount.'@'.$promotioncount;        
	}


	// 22 JAN 2023
	public function getpatientpaymentnonschemeLov($instcode,$patientcode)
	{	
		$one = 1;
		$sql = " SELECT * FROM octopus_patients_paymentschemes where  PAY_INSTCODE = '$instcode' and PAY_STATUS = '$one' and PAY_PATIENTCODE = '$patientcode' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();			
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PAY_SCHEMECODE'].'@@@'.$obj['PAY_SCHEMENAME'].'@@@'.$obj['PAY_PAYMENTMETHODCODE'].'@@@'.$obj['PAY_PAYMENTMETHOD'].'@@@'.$obj['PAY_PLAN'].'">'.$obj['PAY_SCHEMENAME'].' </option>';			   
		}
	}


	// 27 NOV 2022
	public function getstockdevicevalue(String $instcode): Int 
		{
		$one = 1;
		$sql = " SELECT SUM(DEV_STOCKVALUE) AS STOCKVALUE FROM octopus_st_devices WHERE DEV_INSTCODE = ? AND DEV_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['STOCKVALUE'];				
				return intval($value);
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}

	// 27 NOV 2022
	public function getstockvalue(String $instcode): Int 
		{
		$one = 1;
		$sql = " SELECT SUM(MED_STOCKVALUE) AS STOCKVALUE FROM octopus_st_medications WHERE MED_INSTCODE = ? AND MED_STATUS = ? "; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);	
		$st->BindParam(2, $one);	
		$ext = $st->execute();	
		if($ext){
			if($st->rowcount()){
				$obj = $st->fetch(PDO::FETCH_ASSOC);				
				$value = $obj['STOCKVALUE'];				
				return intval($value);
			}else{
				return '0';
			}
		}else{
			return '0';
		}			
	}

	// 20 NOV 2022 
	public function getreturncounts($instcode)
	{
		$sql = "SELECT PRESC_ID FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_RETURN = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$returnmedicationcount  = $st->rowCount();
		$sql = "SELECT PD_ID FROM octopus_patients_devices WHERE PD_INSTCODE = '$instcode' AND PD_RETURN = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$returndevicecount  = $st->rowCount();
		$sql = "SELECT PPD_ID FROM octopus_patients_procedures WHERE PPD_INSTCODE = '$instcode' AND PPD_RETURN = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$returnprocedurecount  = $st->rowCount();
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_RETURN = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$returnservicecount  = $st->rowCount();	
		
		$sql = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_RETURN = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$returninvestigationscount  = $st->rowCount();	

		return $returnmedicationcount.'@'.$returndevicecount.'@'.$returnprocedurecount.'@'.$returnservicecount.'@'.$returninvestigationscount;      
	}


	// 24 SEPT 2022 JOSEPH ADORBOE 
	public function getcurrencyLov()
	{		
		echo '<option value= "">-- Select --</option>';
		echo "<option value='USDOLLARS'> US Dollars </option>";
		echo "<option value='EUROS'> Euros </option>";
		echo "<option value='POUND'> Pound </option>";
		echo "<option value='GHCEDIS'> CEDIS </option>";
		
	}


	// 04 NOV 2022 
	public function getforeignprivateinsurancepaymentschemeLov($instcode,$foreigninsurancecode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$foreigninsurancecode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	// 24 SEPT 2022 JOSEPH ADORBOE 
	public function getpharamcyLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value=1> Patient No.  Name </option>';
		echo '<option value=2> Date</option>';	
	}

	// 15 JUNE 2022 JOSEPH ADORBOE 
	public function getpatientpaymentcashschemeLov($instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode)
	{	
		$mnm = 1;
		$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' and PSC_PAYMENTMETHODCODE = '$cashpaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$mobilemoneypaymentmethodcode' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value=0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		
		}
	}

	

	//28 MAY 2022 
	public function getscanpricelov($schemecode,$paycode,$instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_radiology WHERE SC_STATUS = '$mnm'  AND SC_INSTCODE = '$instcode' AND  SC_CODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1' ) ORDER BY SC_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SC_CODE'].'@@@'.$obj['SC_NAME'].'">'.$obj['SC_NAME'].' </option>';
		}
	}

	//28 MAY 2022 
	public function getpatientallprocedurepricelov($schemecode,$paycode,$instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm'  and MP_INSTCODE = '$instcode' AND  MP_CODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1' ) ORDER BY MP_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MP_CODE'].'@@@'.$obj['MP_NAME'].'">'.$obj['MP_NAME'].' </option>';
		}
	}


	//28 MAY 2022 JOSEPH ADORBOE 
	public function getdevicespricelov($schemecode,$paycode,$instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm' and DEV_INSTCODE = '$instcode' AND DEV_CODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1' ) ORDER BY DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'@@@'.$obj['DEV_DEVICE'].'">'.$obj['DEV_DEVICE'].' - '.$obj['DEV_QTY'].' </option>';
		}
	}

	//28 MAY 2022 JOSEPH ADORBOE 
	public function getlabspricelov($schemecode,$paycode,$instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_labtest WHERE LTT_STATUS = '$mnm' and LTT_INSTCODE = '$instcode' AND LTT_CODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1' ) ORDER BY LTT_NAME "; 
		// $sql = " SELECT * FROM octopus_st_labtest LEFT JOIN octopus_st_pricing ON LTT_CODE = PS_ITEMCODE WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1' AND PS_CODE IS NULL AND LTT_STATUS = '$mnm' and LTT_INSTCODE = '$instcode' order by LTT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LTT_CODE'].'@@@'.$obj['LTT_NAME'].'@@@'.$obj['LTT_PARTNERCODE'].'">'.$obj['LTT_NAME'].' </option>';
		}
	}

	//28 MAY 2022 
	public function getbillableservicesprice($schemecode,$paycode,$instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_admin_services WHERE SEV_STATUS = '$mnm' AND SEV_INSTCODE = '$instcode' AND SEV_BILLABLE = '1' AND SEV_SERVICECODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1')  ORDER BY SEV_SERVICES "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SEV_SERVICECODE'].'@@@'.$obj['SEV_SERVICES'].'">'.$obj['SEV_SERVICES'].' </option>';
		}			
	}

	//28 MAY 2022 
	public function getmedicationspricinglov($schemecode,$paycode,$instcode)
	{
		$mnm = 1;
		$sql = " SELECT * FROM octopus_st_medications WHERE MED_STATUS = '1' AND MED_INSTCODE = '$instcode' AND MED_CODE NOT IN ( SELECT PS_ITEMCODE FROM octopus_st_pricing WHERE PS_PAYMENTMETHODCODE = '$paycode' AND PS_PAYSCHEMECODE = '$schemecode' AND  PS_STATUS = '1')  ORDER BY MED_MEDICATION "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MED_CODE'].'@@@'.$obj['MED_MEDICATION'].'- '.$obj['MED_BRANDNAME'].' - '.$obj['MED_DOSAGE'].'@@@'.$obj['MED_DOSAGECODE'].'@@@'.$obj['MED_DOSAGE'].'">'.$obj['MED_MEDICATION'].' - '.$obj['MED_DOSAGE'].'  - '.$obj['MED_QTY'].' </option>';
		}
	}


	// 26 MAY 2022 JOSEPH ADORBOE 
	public function getservicepartnerservicesLov()
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= "2@Pharmacy"> Pharmacy </option>';
		echo '<option value= "3@Labs"> Labs </option>';
		echo '<option value= "4@Scans"> Scans </option>';
		echo '<option value= "7@Procedure"> Procedures </option>';
	}	

	// 21 MAY 2022 JOSEPH ADORBOE 
	public function getrevenuereportsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 12> Income Reports </option>';
		echo '<option value= 1> All Revenue Reports </option>';
		echo '<option value= 2> Cash Revenue Reports </option>';
		echo '<option value= 3> MOMO Revenue Report </option>';
		echo '<option value= 4> Partner Revenue Report </option>';
		echo '<option value= 5> Insurance Revenue Report </option>';
		echo '<option value= 6> Item Revenue Report </option>';
		echo '<option value= 7> Services Revenue Report </option>';
		echo '<option value= 8> Pharmacy Revenue Report </option>';
		echo '<option value= 9> Labs Revenue Report </option>';
		echo '<option value= 10> Procedure Revenue Report </option>';
		echo '<option value= 11> Devices Revenue Report </option>';
	}	


	// 18 MAY 2022 
	public function getexecutiveuserdashboard($instcode,$day)
	{
		$sql = "SELECT PATIENT_ID FROM octopus_patients WHERE PATIENT_INSTCODE = '$instcode' AND PATIENT_STATUS = '1' AND DATE(PATIENT_DATE) = '$day' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$todaynewpatientscount  = $st->rowCount();
		$sql = "SELECT CON_ID FROM octopus_patients_consultations_archive WHERE CON_INSTCODE = '$instcode' AND CON_STATUS != '0' AND DATE(CON_DATE) = '$day'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$consultationcount  = $st->rowCount();
		$sql = "SELECT PRESC_ID FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_DISPENSE = '2' AND DATE(PRESC_DISPENSEDATE) ='$day' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$dispensecount  = $st->rowCount();
		$sql = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND MIV_STATUS != '0' AND DATE(MIV_DATE) ='$day' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$labcount  = $st->rowCount();
		
		return $todaynewpatientscount.'@'.$consultationcount.'@'.$dispensecount.'@'.$labcount;      
	}

	// 14 MAY 2022 JOSEPH ADORBOE 
	public function getpharmacyreportsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Medication Dispensed </option>';
		echo '<option value= 2> Stock Levels </option>';
		echo '<option value= 3> Low Stocks </option>';
		echo '<option value= 4> Expiry Stocks </option>';
	}	

	// 22 APR 2022 
	public function getphysiovisitsummary($physiofirstvisit,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,$physiofullbodymassage,$physioreflexology,$termone,$termtwo,$instcode)
	{
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SERVICECODE IN('$physiofirstvisit','$physiofollowup','$physioacupuncturesinglesite','$physioacupuncturemultisite','$physiofullbodymassage','$physioreflexology') AND DATE(REQU_DATE) BETWEEN '$termone' AND '$termtwo'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$totalcount  = $st->rowCount();
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_STAGE = '2' AND REQU_SERVICECODE IN('$physiofirstvisit','$physiofollowup','$physioacupuncturesinglesite','$physioacupuncturemultisite','$physiofullbodymassage','$physioreflexology') AND DATE(REQU_DATE) BETWEEN '$termone' AND '$termtwo'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$newpatientcount  = $st->rowCount();
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_STAGE != '2' AND REQU_SERVICECODE IN('$physiofirstvisit','$physiofollowup','$physioacupuncturesinglesite','$physioacupuncturemultisite','$physiofullbodymassage','$physioreflexology') AND DATE(REQU_DATE) BETWEEN '$termone' AND '$termtwo'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$referralcount  = $st->rowCount();
		
		return $totalcount.'@'.$newpatientcount.'@'.$referralcount;      
	}

	// 04 MAY 2022 JOSEPH ADORBOE 
	public function getphysiostatsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Visit Stats </option>';
		echo '<option value= 2> Revenue </option>';
		echo '<option value= 3> Patient List </option>';		
	}	

	// 24 APR 2022  JOSEPH ADORBOE 
	public function getadmissionactionLov()
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value=10> Discharge Only </option>';
		echo '<option value= 40>Internal Referal </option>';
		echo '<option value= 60> Death </option>';
		echo '<option value= 70> Follow up Appointments</option>';
		echo '<option value= 80> Review </option>';		
	}	

	// 24 APR 2022  AND DN_INSTCODE = '$instcode'
	public function getpatientsdiagnosissearchlov($code,$instcode)
	{
		$one = 1;
		$sql = " SELECT * FROM octopus_st_diagnosis WHERE DN_STATUS = '$one' AND DN_CODE LIKE '%".$code."%' order by DN_NAME  LIMIT 100"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DN_CODE'].'@@@'.$obj['DN_NAME'].'">'.$obj['DN_CODE'].' - '.$obj['DN_NAME'].' </option>';
		}
	}

	// 04 MAY 2022 
	public function gettotalamount($termone,$termtwo,$physiofirstvisit,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,$physiofullbodymassage,$physioreflexology,$instcode)
	{
		$sql = "SELECT SUM(B_TOTAMT) AS TOT FROM octopus_patients_billitems WHERE B_INSTCODE = '$instcode' AND B_ITEMCODE IN('$physiofirstvisit','$physiofollowup','$physioacupuncturesinglesite','$physioacupuncturemultisite','$physiofullbodymassage','$physioreflexology') AND B_COMPLETE = '2' AND DATE(B_PAYDATE) BETWEEN '$termone' AND '$termtwo' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();  
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$value = $obj['TOT'];				
		return $value;		
	}

	// 22 APR 2022 
	public function getnursecounts($currentusercode,$patientqueueexcept,$nursingservices,$thereviewday,$day,$instcode)
	{
		
		$sql = "SELECT CON_ID FROM octopus_patients_consultations WHERE CON_INSTCODE = '$instcode' AND CON_STATE = '1' AND CON_DOCTORCODE = '$currentusercode'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$myconsultationcount  = $st->rowCount();		
		$sql = "SELECT ADM_ID FROM octopus_patients_admissions WHERE ADM_INSTCODE = '$instcode' AND ADM_COMPLETE = '1' AND ADM_DATE = '$day'"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$admissioncount  = $st->rowCount();		
		$sql = "SELECT DISTINCT PPD_PATIENTCODE FROM octopus_patients_procedures WHERE PPD_INSTCODE = '$instcode' AND PPD_COMPLETE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$procedurecount  = $st->rowCount();		
		$sql = "SELECT REV_ID FROM octopus_patients_review WHERE REV_INSTCODE = '$instcode' AND REV_STATUS = '1' AND REV_ACTORCODE = '$currentusercode' AND  DATE(REV_DATE) > '$thereviewday' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$reviewcount  = $st->rowCount();		
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_STAGE = '1' AND REQU_SHOW = '7' AND REQU_VITALSTATUS = '0'  AND  DATE(REQU_DATE) = '$day' AND  REQU_COMPLETE = '1'  AND REQU_STATUS = '2' AND REQU_RETURN = '0' AND REQU_SERVICECODE NOT IN ('$patientqueueexcept') "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$patientqueuecount  = $st->rowCount();			
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_STAGE = '3' AND REQU_SHOW = '7' AND  DATE(REQU_DATE) = '$day' AND  REQU_COMPLETE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$servicecount  = $st->rowCount();	
		$sql = "SELECT HO_ID FROM octopus_handover WHERE HO_INSTCODE = '$instcode' AND HO_STATUS = '1' AND HO_DATE = '$day' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$handovercount  = $st->rowCount();
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_STAGE = '1' AND REQU_SHOW = '7' AND  DATE(REQU_DATE) < '$day' AND  REQU_COMPLETE = '1'  and REQU_STATUS = '2'"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$patientqueuepastedcount  = $st->rowCount();
		$sql = "SELECT FU_ID FROM octopus_patients_nurse_followup WHERE FU_INSTCODE = '$instcode' AND FU_STATUS = '1' AND !(FU_REQUESTDATE > '$day') "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$followupcount  = $st->rowCount();
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND REQU_SHOW = '7' AND  DATE(REQU_DATE) = '$day' AND  REQU_COMPLETE = '1'  and REQU_STATUS = '2' AND REQU_RETURN = '1'"; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$patientqueuecancelledcount  = $st->rowCount();	
		$sql = "SELECT REQU_ID FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = '$instcode' AND  DATE(REQU_DATE) = '$day' AND  REQU_COMPLETE = '1' AND REQU_SERVICECODE IN ('$nursingservices') "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$nursingcount  = $st->rowCount();
		$sql = "SELECT MIV_ID FROM octopus_patients_investigationrequest WHERE MIV_INSTCODE = '$instcode' AND  DATE(MIV_DATE) = '$day' AND  MIV_COMPLETE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$investigationcount  = $st->rowCount();
		return $myconsultationcount.'@'.$admissioncount.'@'.$procedurecount.'@'.$reviewcount.'@'.$patientqueuecount.'@'.$servicecount.'@'.$handovercount.'@'.$patientqueuepastedcount.'@'.$followupcount.'@'.$patientqueuecancelledcount.'@'.$nursingcount.'@'.$investigationcount;      
	}

	
	// 22 APR 2022 
	public function getdoctorscounts($currentusercode,$thereviewday,$instcode)
	{
		$sql = "SELECT CON_ID FROM octopus_patients_consultations WHERE CON_INSTCODE = '$instcode' AND CON_STATE = '1' AND CON_DOCTORCODE = '$currentusercode'  "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$myconsultationcount  = $st->rowCount();
		$sql = "SELECT ADM_ID FROM octopus_patients_admissions WHERE ADM_INSTCODE = '$instcode' AND ADM_COMPLETE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$admissioncount  = $st->rowCount();
		$sql = "SELECT DISTINCT PPD_PATIENTCODE FROM octopus_patients_procedures WHERE PPD_INSTCODE = '$instcode' AND PPD_COMPLETE = '1' AND PPD_ACTORCODE = '$currentusercode' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$procedurecount  = $st->rowCount();
		$sql = "SELECT REV_ID FROM octopus_patients_review WHERE REV_INSTCODE = '$instcode' AND REV_STATUS = '1' AND REV_ACTORCODE = '$currentusercode' AND  DATE(REV_DATE) > '$thereviewday' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$reviewcount  = $st->rowCount();		

		return $myconsultationcount.'@'.$admissioncount.'@'.$procedurecount.'@'.$reviewcount;      
	}


	// 30 MAR 2022 JOSEPH ADORBOE 
	public function getcountdetails($instcode,$day)
	{
		$one = 1;	
		$seven = 7;
		$sql = "SELECT * FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = ? AND REQU_COMPLETE = ? AND date(REQU_DATE) = ? AND REQU_SHOW = ?"; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $one);
		$st->BindParam(3, $day);
		$st->BindParam(4, $seven);
		$st->execute();
		$patientqueue = $st->rowcount();

		$one = 1;	
		$seven = 7;
		$sql = "SELECT * FROM octopus_patients_servicesrequest WHERE REQU_INSTCODE = ? AND REQU_COMPLETE = ? AND date(REQU_DATE) = ? AND REQU_SHOW = ? AND REQU_VITALSTATUS = ?"; 
		$st = $this->db->prepare($sql);   
		$st->BindParam(1, $instcode); 
		$st->BindParam(2, $one);
		$st->BindParam(3, $day);
		$st->BindParam(4, $seven);
		$st->BindParam(5, $one);
		$st->execute();
		$consultationqueue = $st->rowcount();

		return $patientqueue.'@@@'.$consultationqueue;
		//.'@@@'.$patienttotalnumber.'@@@'.$activeservices.'@@@'.$todayactiveservices.'@@@'.$todayvisits.'@@@'.$todayappointmentpending.'@@@'.$todayappointment.'@@@'.$todaytotalslots.'@@@'.$todayavaliableslots ;
	}


	// 17 APR 2022 
	public function getpharmacycounts(String $theexpiryday, String $instcode): String 
	{
		$sql = "SELECT DISTINCT PRESC_PATIENTCODE FROM octopus_patients_prescriptions WHERE PRESC_INSTCODE = '$instcode' AND PRESC_STATE = '1' AND PRESC_RETURN = '0' AND PRESC_ARCHIVE = '0' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$prescriptioncount  = $st->rowCount();

		$sql = "SELECT DISTINCT PD_PATIENTCODE FROM octopus_patients_devices WHERE PD_INSTCODE = '$instcode' AND PD_STATE = '1' AND PD_RETURN = '0' AND  PD_ARCHIVE = '0' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$devicecount  = $st->rowCount();

		$sql = "SELECT DISTINCT PPD_PATIENTCODE FROM octopus_patients_procedures WHERE PPD_INSTCODE = '$instcode' AND PPD_STATE = '1' AND PPD_RETURN = '0' AND PPD_ARCHIVE = '0' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$procedurecount  = $st->rowCount();

		$sql = "SELECT REQ_ID FROM octopus_requistions WHERE REQ_INSTCODE = '$instcode' AND REQ_STATUS = '2' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$requisitioncount  = $st->rowCount();	
		
		$sql = "SELECT SA_ID FROM octopus_pharmacy_stockadjustment WHERE SA_INSTCODE = '$instcode' AND SA_TYPE IN('2','5','11') and SA_STATUS = '1' AND SA_STATE = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$transfercount  = $st->rowCount();
		
		$sql = "SELECT EXP_ID FROM octopus_pharmacy_expiry WHERE EXP_INSTCODE = '$instcode'  AND EXP_EXPIRYDATE < '$theexpiryday' AND EXP_STATUS = '1' "; 
        $st = $this->db->prepare($sql);   
        $st->execute();   
		$expirycount  = $st->rowCount();

		return $prescriptioncount.'@'.$devicecount.'@'.$procedurecount.'@'.$requisitioncount.'@'.$transfercount.'@'.$expirycount;      
	}

	

	// 13 APR 2022 JOSEPH ADORBOE 
	public function getdiagnosisicdcodes()
	{
		$one = 1;
		$sql = " SELECT * FROM octopus_st_diagnosis where DN_STATUS = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $one);				
		$st->execute();		
        while ($obj = $st->fetch(PDO::FETCH_ASSOC)) {
            echo  $data[] = $obj['DN_CODE'].'@@@'.$obj['DN_NAME'];
            //return $data;
        }
		
	}

	// 23 JAN 2022  JOSEPH ADORBOE 
	public function getprescriptionplannumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_PRESCRIPTIONPLAN'];
		$value = $data + 1;			
		return $value;		
	}

	// 13 JAN 2022 JOSEPH ADORBOE 
	public function getwardsbedLov($instcode)
	{
		$mnm = '0';
		$sql = " SELECT * FROM octopus_st_ward_bed where  BED_INSTCODE = '$instcode' and BED_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['BED_CODE'].'@@@'.$obj['BED_NAME'].'@@@'.$obj['BED_WARDCODE'].'@@@'.$obj['BED_WARD'].'@@@'.$obj['BED_GENDER'].'@@@'.$obj['BED_RATE'].'">'.$obj['BED_NAME'].' - '.$obj['BED_WARD'].' </option>';
		}
	}

	// 12 JAN 2022 JOSEPH ADORBOE 
	public function getwardsLov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_ward where  WARD_INSTCODE = '$instcode' and WARD_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['WARD_CODE'].'@@@'.$obj['WARD_NAME'].'@@@'.$obj['WARD_RATE'].'@@@'.$obj['WARD_GENDER'].'">'.$obj['WARD_NAME'].' </option>';
		}
	}


	// 05 jan 2022 
	public function admissionrequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_ADMSSIONNUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	// 05 jan 2022 
	public function getdeathrequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_DEATHNUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	// 09 SEPT 2022 JOSEPH ADORBOE 
	public function getrefundLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value=1> Patient No.  Name  Refund No.</option>';
		echo '<option value=2> Refund Date</option>';	
	}	


	// 02 JAN 2022 JOSEPH ADORBOE 
	public function getgenearlstatsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Patient Stats </option>';
		echo '<option value= 2> Visit Stats </option>';
		
	}	


	// 1 DEC 2021 JOSEPH ADORBOE 
	public function getconsultationreportsLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Consultations Report </option>';
		echo '<option value= 2> Doctors Consultation Report</option>';
		// echo '<option value= 3> Monthly  Consultation Report</option>';
		// echo '<option value= 4> Monthly  Doctor Consultation Report</option>';
		echo '<option value= 5> Diagnosis Report</option>';
		echo '<option value= 6> Presenting Complain Report</option>';
	}	

	// 22 NOV 2021 JOSEPH ADORBOE 
	public function getlabstreatmentplansLov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_labplans where  LP_INSTCODE = '$instcode' and LP_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LP_CODE'].'@@@'.$obj['LP_NAME'].'@@@'.$obj['LP_CODENUM'].'">'.$obj['LP_NAME'].' </option>';
		}
	}

	// 22 NOV 2021 JOSEPH ADORBOE 
	public function getlabplannumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_LABPLAN'];
		$value = $data + 1;			
		return $value;		
	}

	//13 NOV 2021 JOSEPH ADORBOE 
	public function getallmonths($instcode)
	{
		$mnm = 1;
		$doc = 4;
		$sql = " SELECT * FROM octopus_st_summary where  ST_INSTCODE = '$instcode' and ST_STATUS = '$mnm' AND ST_TYPE = '2' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['ST_NAME'].'">'.$obj['ST_NAME'].' </option>';		
		}
	}

	// 13 NOV 2021 JOSEPH ADORBOE 
	public function getmyconsultationtypeLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Daily Report </option>';
		echo '<option value= 2> Monthly Report</option>';
		
	}	

	// 11 NOV 2021 JOSEPH ADORBOE 
	public function getpatientstatstypeLov($instcode)
	{		
		echo '<option value= "">-- Select --</option>';
		echo '<option value= 1> Patient Gender & Age Stats </option>';
		echo '<option value= 2> Patient Registration Stats </option>';
		
	}	

	// 09 NOV 2021 JOSEPH ADORBOE 
	public function getsalarynumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_SALARYNUM'];
		$value = $data + 1;			
		return $value;		
	}

	// 09 NOV 2021 JOSEPH ADORBOE 
	public function getsalarydetailsnumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_SALARYTRANSACTIONNUM'];
		$value = $data + 1;			
		return $value;		
	}

	// 05 NOV 2021 JOSEPH ADORBOE 
	public function getschedulenumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_SCHEDULENUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	// 05 NOV 2021 JOSEPH ADORBOE 
	public function getlocumnumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_LOCUM'];
		$value = $data + 1;			
		return $value;		
	}

	//05 NOV 2021
	public function getallpersonelLov($instcode)
	{
		$mnm = 1;
		$doc = 4;
		$sql = " SELECT * FROM octopus_users where  USER_INSTCODE = '$instcode' and USER_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['USER_CODE'].'@@@'.$obj['USER_FULLNAME'].'">'.$obj['USER_FULLNAME'].' </option>';
		
		}
	}
	

	// 20 OCT 2021 JOSEPH ADORBOE 
	public function getincidencecode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_INCIDENCENUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	// 20 OCT 2021 JOSEPH ADORBOE 
	public function getincidencetypelov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_type where TYPE_STATUS = '$mnm' order by TYPE_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['TYPE_NAME'].'">'.$obj['TYPE_NAME'].' </option>';
		}
	}


	// 14 OCT 2021 JOSEPH ADORBOE 
	public function getmedicalreportnumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_MEDICALREPORTNUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	


	// 16 JULY 2021
	public function getprocedurecode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_PROCEDURE'];
		$value = $data + 1;			
		return $value;		
	}


	// 12 SEPT 2021
	public function getlabcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_LABCODE'];
		$value = $data + 1;
		
		return $value;
		
	}
	// 23 AUG 2021 JOSEPH ADORBOE
	public function getreportshiftlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_shifts where SHIFT_INSTCODE = '$instcode' order by SHIFT_ID DESC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SHIFT_CODE'].'@@@'.$obj['SHIFT_NAME'].'">'.$obj['SHIFT_NAME'].' </option>';
		}
	}



	// 20 AUG 2021 JOSEPH ADORBOE
	public function getdeviceinstoresearchlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm'  and DEV_INSTCODE = '$instcode' order by DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'">'.$obj['DEV_DEVICE'].' </option>';
		}
	}


	//20 AUG 2021
	public function getdevicesinstorelov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm' and DEV_INSTCODE = '$instcode' order by DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'@@@'.$obj['DEV_CODENUM'].'@@@'.$obj['DEV_DEVICE'].'@@@'.$obj['DEV_QTY'].'">'.$obj['DEV_DEVICE'].' - '.$obj['DEV_QTY'].' </option>';
		}
	}


	// 13 AUG 2021 JOSEPH ADORBOE 
	public function getchronicLov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_chronic where CH_STATUS = '$mnm' order by CH_CHRONIC "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['CH_CODE'].'@@@'.$obj['CH_CHRONIC'].'">'.$obj['CH_CHRONIC'].' </option>';
		}
	}

	// 13 AUG 2021 JOSEPH ADORBOE 
	public function getallergyLov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_allergy where ALG_STATUS = '$mnm' order by ALG_ALLEGY "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value=0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['ALG_CODE'].'@@@'.$obj['ALG_ALLEGY'].'">'.$obj['ALG_ALLEGY'].' </option>';
		}
	}

	// 13 AUG 2021 JOSEPH ADORBOE 
	public function getnewallergyLov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_allergy where ALG_STATUS = '$mnm' order by ALG_ALLEGY "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['ALG_CODE'].'@@@'.$obj['ALG_ALLEGY'].'">'.$obj['ALG_ALLEGY'].' </option>';
		}
	}



	// 31 JULY 2021
	public function getwalkinpatientnumber($instcode)
	{
		$mnm = '1';
		$sql = " SELECT CU_WALKINPATIENTNUMBER FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_WALKINPATIENTNUMBER'];
		$value = $data + 1;			
		return $value;		
	}

	// 17 JULY 2021
	public function getconsultationrequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_CONSULTATIONCODE'];
		$value = $data + 1;			
		return $value;		
	}

	// 16 JULY 2021
	public function getprocedurerequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_PROCEDURECODE'];
		$value = $data + 1;			
		return $value;		
	}


	

	
	//30 JUNE JOSEPH ADORBOE 
	public function getcashpaymenttypesLov($instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$creditcode,$prepaidcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' and PSC_PAYMENTMETHODCODE = '$cashpaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$mobilemoneypaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$creditcode' or PSC_PAYMENTMETHODCODE = '$prepaidcode' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value=0>-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		
		}
			
	}


	//23 JUNE JOSEPH ADORBOE 
	public function getnoncashpaymenttypesLov($instcode,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' and PSC_PAYMENTMETHODCODE = '$privateinsurancecode' or PSC_PAYMENTMETHODCODE = '$nationalinsurancecode' or PSC_PAYMENTMETHODCODE = '$partnercompaniescode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value=0>-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'@@@'.$obj['PSC_PLAN'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		   
			}
			
	}

	//03 JUNE  2021 JOSEPH ADORBOE 
	public function getsupplierlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_suppliers where SUPPLIER_INSTCODE = '$instcode' and  SUPPLIER_STATUS = '1' order by SUPPLIER_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SUPPLIER_CODE'].'@@@'.$obj['SUPPLIER_CODENUM'].'@@@'.$obj['SUPPLIER_NAME'].'">'.$obj['SUPPLIER_NAME'].' </option>';
		}
	}


	// 29 MAY 2021
	public function getpatientdevicerequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_DEVICEREQUESTCODE'];
		$value = $data + 1;			
		return $value;		
	}

	//27 MAY 2021
	public function gettreatmentplansLov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_prescriptionplan where  TRP_INSTCODE = '$instcode' and TRP_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['TRP_CODE'].'@@@'.$obj['TRP_NAME'].'">'.$obj['TRP_NAME'].' </option>';
		}
	}
		
	// 29 MAY 2021
	public function getdevicecode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_DEVICECODE'];
		$value = $data + 1;			
		return $value;		
	}

	// 04 APR 2021
	public function getprescriptionrequestcode($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
		$st = $this->db->prepare($sql); 
		$st->BindParam(1, $instcode);				
		$st->execute();		
		$obj = $st->fetch(PDO::FETCH_ASSOC);				
		$data = $obj['CU_PRECRIPECODE'];
		$value = $data + 1;			
		return $value;		
	}


	//16 APR 2021
	public function getappointmenttime($instcode,$days)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_appointmentslots where  AP_INSTCODE = '$instcode' and AP_STATUS = '$mnm' and AP_TIMESTART >= '$days' order by AP_TIMESTART "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['AP_CODE'].'@@@'.$obj['AP_TIMESTART'].'@@@'.$obj['AP_TIMEEND'].'@@@'.$obj['AP_DOCTORCODE'].'@@@'.$obj['AP_DOCTOR'].'">'.$obj['AP_DOCTOR'].' From '.date('d M Y h:i:s a', strtotime($obj['AP_TIMESTART'])).' to '.date('d M Y h:i:s a', strtotime($obj['AP_TIMEEND'])).'</option>';
		}
	}

	//16 APR 2021
	public function getallpaymentschemeLov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		}
	}
	
	// 04 APR 2021
	public function getlabrequestcode($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_current where CU_INSTCODE = ?"; 
			$st = $this->db->prepare($sql); 
			$st->BindParam(1, $instcode);				
			$st->execute();		
			$obj = $st->fetch(PDO::FETCH_ASSOC);				
			$data = $obj['CU_LABSCODE'];
			$value = $data + 1;
			
			return $value;
		
	}
	
	//27 MAR 2021
	public function getdeviceslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_devices where DEV_STATUS = '$mnm' and DEV_INSTCODE = '$instcode' order by DEV_DEVICE "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DEV_CODE'].'@@@'.$obj['DEV_DEVICE'].'">'.$obj['DEV_DEVICE'].' - '.$obj['DEV_QTY'].' </option>';
		}
	}


	// 05 APR 2021
	public function getsamplesLov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_labspecimen where SP_STATUS = '$mnm' order by SP_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['SP_CODE'].'@@@'.$obj['SP_NAME'].'">'.$obj['SP_NAME'].' </option>';
		}
	}

	//30 MAR 2021
	public function getlabsdisciplinelov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_labdiscipline where LD_STATUS = '$mnm' order by LD_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LD_CODE'].'@@@'.$obj['LD_NAME'].'">'.$obj['LD_NAME'].' </option>';
		}
	}

	//27 MAR 2021
	public function getactionslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_patients_action where ACT_STATUS = '$mnm' and ACT_INSTCODE = '$instcode' order by ACT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['ACT_CODENUM'].'">'.$obj['ACT_NAME'].' </option>';
		}
	}

	//27 MAR 2021
	public function getlabslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_labtest where LTT_STATUS = '$mnm' and LTT_INSTCODE = '$instcode' order by LTT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
	//	echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LTT_CODE'].'@@@'.$obj['LTT_NAME'].'@@@'.$obj['LTT_PARTNERCODE'].'">'.$obj['LTT_NAME'].' </option>';
		}
	}

	//08 JUNE 2021
	public function getlabssearchlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_labtest where LTT_STATUS = '$mnm' and LTT_INSTCODE = '$instcode' order by LTT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LTT_CODE'].'">'.$obj['LTT_NAME'].' </option>';
		}
	}

	// 11 JUNE 2021
	public function getmedicationsinstoresearchlov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_medications where MED_STATUS = '$mnm' and MED_STATE = '2' and MED_INSTCODE = '$instcode' order by MED_MEDICATION "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MED_CODE'].'">'.$obj['MED_MEDICATION'].' - '.$obj['MED_DOSAGE'].' </option>';
		}
	}



	// 04 JUNE 2021
	public function getmedicationsinstorelov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_medications where MED_STATUS = '$mnm' and MED_STATE = '2' and MED_INSTCODE = '$instcode' order by MED_MEDICATION "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MED_CODE'].'@@@'.$obj['MED_MEDICATION'].'@@@'.$obj['MED_DOSAGECODE'].'@@@'.$obj['MED_DOSAGE'].'@@@'.$obj['MED_CODENUM'].'@@@'.$obj['MED_QTY'].'">'.$obj['MED_MEDICATION'].'  - '.$obj['MED_UNIT'].' - '.$obj['MED_QTY'].'</option>';
		}
	}

	// 27 MAR 2021
	public function getmedicationslov($instcode)
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_medications where MED_STATUS = '$mnm' and MED_INSTCODE = '$instcode' order by MED_MEDICATION "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['MED_CODE'].'@@@'.$obj['MED_MEDICATION'].'@@@'.$obj['MED_DOSAGECODE'].'@@@'.$obj['MED_DOSAGE'].'@@@'.$obj['MED_DOSE'].'@@@'.$obj['MED_BRANDNAME'].'@@@'.$obj['MED_UNIT'].' ">'.$obj['MED_MEDICATION'].' - '.$obj['MED_UNIT'].' - '.$obj['MED_QTY'].' </option>';
		}
	}


	//27 MAR 2021
	public function getdayslov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_days where DA_STATUS = '$mnm' order by DA_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DA_CODE'].'@@@'.$obj['DA_NAME'].'@@@'.$obj['DA_VALUE'].'">'.$obj['DA_NAME'].' </option>';
		}
	}


	//27 MAR 2021
	public function getunitslov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_units where UN_STATUS = '$mnm' order by UN_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['UN_CODE'].'@@@'.$obj['UN_NAME'].'">'.$obj['UN_NAME'].' </option>';
		}
	}


	//27 MAR 2021
	public function getroutelov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_route where RT_STATUS = '$mnm' order by RT_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['RT_CODE'].'@@@'.$obj['RT_NAME'].'">'.$obj['RT_NAME'].' </option>';
		}
	}


	//27 MAR 2021
	public function getfrequencylov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_frequency where FRE_STATUS = '$mnm' order by FRE_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['FRE_CODE'].'@@@'.$obj['FRE_NAME'].'@@@'.$obj['FRE_QTY'].'">'.$obj['FRE_NAME'].' </option>';
		}
	}


	//27 MAR 2021
	public function getdosageformlov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_dosageform where DF_STATUS = '$mnm' order by DF_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select Dosage Form--</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['DF_CODE'].'@@@'.$obj['DF_NAME'].'">'.$obj['DF_NAME'].' </option>';
		}
	}

	//26 MAR 2021
	public function getpatientsoxygenlov()
	{
		$mnm = '1';
		$sql = " SELECT * FROM octopus_st_oxygen where OX_STATUS = '$mnm' order by OX_NAME "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['OX_CODE'].'@@@'.$obj['OX_NAME'].'">'.$obj['OX_NAME'].' </option>';
		}
	}

	//26 MAR 2021
	public function getpatientallprocedurelov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm'  and MP_INSTCODE = '$instcode' order by MP_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['MP_CODE'].'@@@'.$obj['MP_NAME'].'">'.$obj['MP_NAME'].' </option>';

            }
	}

	//26 MAR 2021
	public function getpatientsprocedurelov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm' and MP_SPEC IS NULL and MP_INSTCODE = '$instcode' order by MP_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['MP_CODE'].'@@@'.$obj['MP_NAME'].'">'.$obj['MP_NAME'].' </option>';

            }
	}


	// 01 MAY 2022 
	public function getpatientsprocedurephysiolov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_procedures where MP_STATUS = '$mnm' and MP_SPEC= '$mnm'  and MP_INSTCODE = '$instcode' order by MP_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['MP_CODE'].'@@@'.$obj['MP_NAME'].'">'.$obj['MP_NAME'].' </option>';

            }
	}


	//25 MAR 2021 AND DN_INSTCODE = '$instcode'
	public function getpatientsdiagnosislov($instcode)
	{
			$one = 1;
			$sql = " SELECT * FROM octopus_st_diagnosis WHERE DN_STATUS = '$one'  order by DN_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['DN_CODE'].'@@@'.$obj['DN_NAME'].'">'.$obj['DN_CODE'].' - '.$obj['DN_NAME'].' </option>';

            }
	}

	//25 MAR 2021
	public function getpatientsphysicalexamslov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_physicalexam WHERE PE_STATUS = '$mnm' AND PE_INSTCODE = '$instcode' order by PE_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PE_CODE'].'@@@'.$obj['PE_NAME'].'">'.$obj['PE_NAME'].' </option>';

            }
	}

	//24 MAR 2021
	public function getpatientscomplainslov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_complains where COMPL_STATUS = '$mnm' AND COMPL_INSTCODE = '$instcode' order by COMPL_COMPLAINS "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo "<option value= '0'>-- Select --</option>";
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['COMPL_CODE'].'@@@'.$obj['COMPL_COMPLAINS'].'">'.$obj['COMPL_COMPLAINS'].' </option>';

            }
	}


	//6 MAR 2021
	public function getbankslov()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_st_banks where BANK_STATUS = '$mnm' order by BANK_NAME "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['BANK_CODE'].'@@@'.$obj['BANK_NAME'].'">'.$obj['BANK_NAME'].' </option>';

            }
	}


	//18 FEB 2021
	public function getuserspeciallov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_setup_specializations where SPEC_INSTCODE IN('$instcode','ALL') and SPEC_STATUS = '$mnm' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SPEC_CODE'].'@@@'.$obj['SPEC_NAME'].'">'.$obj['SPEC_NAME'].' </option>';
            }
	}
	//03 MAY 2022 
	public function getphysiophysiciansLov($instcode)
	{
		$mnm = '1';
		$doc = 5;
		$sql = " SELECT * FROM octopus_users WHERE  USER_INSTCODE = '$instcode' AND USER_STATUS = '$mnm' AND USER_LEVEL IN('5','8') "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['USER_CODE'].'@@@'.$obj['USER_FULLNAME'].'">'.$obj['USER_FULLNAME'].' </option>';

		}
	}

	//18 FEB 2021
	public function getphysiciansLov($instcode)
	{
		$mnm = '1';
		$doc = 5;
		$sql = " SELECT * FROM octopus_users WHERE  USER_INSTCODE = '$instcode' AND USER_STATUS = '$mnm' AND USER_LEVEL = '$doc' "; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['USER_CODE'].'@@@'.$obj['USER_FULLNAME'].'">'.$obj['USER_FULLNAME'].' </option>';

		}
	}

	//18 FEB 2021
	public function getnursesLov($instcode)
	{
			$mnm = '1';
			$doc = 4;
			$sql = " SELECT * FROM octopus_users where  USER_INSTCODE = '$instcode' and USER_STATUS = '$mnm' and USER_LEVEL = '$doc' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['USER_CODE'].'@@@'.$obj['USER_FULLNAME'].'">'.$obj['USER_FULLNAME'].' </option>';
			
            }
	}


	//31 JAN 2021
	public function getpaymenttypesLov($instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' and PSC_PAYMENTMETHODCODE = '$cashpaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$mobilemoneypaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$chequescode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value=0>-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		   
			}
			
	}


	//17 JAN 2021
	public function getschemeLov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PLAN'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	// 14 JAN 2021
	public function getgroupname($groupcode,$instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_patients_groups where GRP_CODE = ? AND GRP_INSTCODE = ? "; 
			$st = $this->db->prepare($sql); 
			$st->BindParam(1, $groupcode);
			$st->BindParam(2, $instcode);			
			$st->execute();
		
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
				
			$data = $obj['GRP_NAME'].'@@@'.$obj['GRP_MEMBERS'];
			
			return $data;
			
            }
	}	
	
	//10 JAN 2021 or PSC_PAYMENTMETHODCODE = '$chequescode' or PSC_PAYMENTMETHODCODE = '$creditcode'
	public function getpatientpaymentschemeLov($instcode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode,$patientcode,$creditcode,$credit,$cashpaymentmethod)
	{	
			$mnm = 1;
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' and PSC_PAYMENTMETHODCODE = '$cashpaymentmethodcode' or PSC_PAYMENTMETHODCODE = '$mobilemoneypaymentmethodcode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value=0>-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'@@@'.$obj['PSC_PLAN'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
		   
			}
			$sql = " SELECT * FROM octopus_patients_paymentschemes where  PAY_INSTCODE = '$instcode' and PAY_STATUS = '$mnm' and PAY_PATIENTCODE = '$patientcode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();			
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
				echo '<option value="'.$obj['PAY_SCHEMECODE'].'@@@'.$obj['PAY_SCHEMENAME'].'@@@'.$obj['PAY_PAYMENTMETHODCODE'].'@@@'.$obj['PAY_PAYMENTMETHOD'].'@@@'.$obj['PAY_PLAN'].'">'.$obj['PAY_SCHEMENAME'].' </option>';
			   
			}
			

	}


	//8 JAN 2021
	public function getpaymentschemeLov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PAYMENTMETHODCODE'].'@@@'.$obj['PSC_PAYMENTMETHOD'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	
	// 8 JAN 2021
	public function getpatientage($patientbirthdate)
	{		
		$day = Date('Y-m-d');		
		$yearOnly1 = date('Y', strtotime($patientbirthdate));
		$yearOnly2 = date('Y', strtotime($day));
		$monthOnly1 = date('m', strtotime($patientbirthdate));
		$monthOnly2 = date('m', strtotime($day));
		$dayOnly1 = date('d', strtotime($patientbirthdate));
		$dayOnly2 = date('d', strtotime($day));
		$yearOnly = $yearOnly2 - $yearOnly1;
		$monthOnly = $monthOnly2 - $monthOnly1;		
		return $yearOnly;					
    }
		
	
	
	//08 JAN 2021
	public function getbillableservices($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_admin_services where SEV_STATUS = '$mnm' and SEV_INSTCODE = '$instcode' and SEV_BILLABLE = '1' ORDER BY SEV_SERVICES ASC  "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SEV_SERVICECODE'].'@@@'.$obj['SEV_SERVICES'].'">'.$obj['SEV_SERVICES'].' </option>';
			}
			
	}


	//06 JAN 2021
	public function getrecordsseerviceslov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_admin_services where SEV_STATUS = '$mnm' and SEV_INSTCODE = '$instcode' and SEV_STATE = '1' ORDER BY SEV_SERVICES ASC "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SEV_SERVICECODE'].'@@@'.$obj['SEV_SERVICES'].'@@@'.$obj['SEV_TYPE'].'">'.$obj['SEV_SERVICES'].' </option>';
			}
			
	}

	//06 JAN 2021 getrecordsseerviceslov
	public function getallserviceslov()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_setup_services where SE_STATUS = '$mnm' ORDER BY SEV_SERVICES ASC "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SE_CODE'].'@@@'.$obj['SE_NAME'].'">'.$obj['SE_NAME'].' </option>';
			}
			
	}

	//4 JAN 2021
	public function getpartnerpaymentschemeLov($instcode,$partnercompaniescode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$partnercompaniescode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	//3 MAR 2021
	public function getcashpaymentschemeLov($instcode,$cashpaymentmethodcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$cashpaymentmethodcode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	//3 MAR 2021
	public function getmomopaymentschemeLov($instcode,$mobilemoneypaymentmethodcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$mobilemoneypaymentmethodcode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	//4 JAN 2021
	public function getnationalinsurancepaymentschemeLov($instcode,$nationalinsurancecode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$nationalinsurancecode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}


	//4 JAN 2021
	public function getprivateinsurancepaymentschemeLov($instcode,$privateinsurancecode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_paymentscheme where  PSC_INSTCODE = '$instcode' and PSC_STATUS = '$mnm' AND PSC_PAYMENTMETHODCODE = '$privateinsurancecode' "; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PSC_CODE'].'@@@'.$obj['PSC_SCHEMENAME'].'@@@'.$obj['PSC_PLAN'].'">'.$obj['PSC_SCHEMENAME'].' </option>';
            }
	}

	// 12 OCT 2020
	public function getinstpaymentpartnerLov($instcode)
	{
			$nn = '1';
			$pays = 'PS-1';
			$sql = " SELECT * FROM octopus_paymentpartners where COMP_INSTCODE = ? and COMP_STATUS = ?  order by COMP_NAME "; 
			$st = $this->db->prepare($sql);  
			$st->Bindparam(1, $instcode);
			$st->Bindparam(2, $nn);
		//	$st->Bindparam(3, $pays);
			$st->execute();

			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){

			echo '<option value="'.$obj['COMP_CODE'].'@@@'.$obj['COMP_NAME'].'@@@'.$obj['COMP_METHODCODE'].'@@@'.$obj['COMP_METHOD'].' ">'.$obj['COMP_NAME'].' </option>';

			}
			
	}
	
	
	// 03 JAN 2021
	public function getinstpaymentmethodLov($instcode)
	{
			$mnm = '1';
			$sql = "SELECT * FROM octopus_admin_paymentmethod where PAY_STATUS = '$mnm' and PAY_INSTCODE = '$instcode'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo "<option value=''>-- Select --</option>";
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PAY_METHODCODE'].'@@@'.$obj['PAY_METHOD'].'">'.$obj['PAY_METHOD'].' </option>';
            }
	}

	// 08 JUNE 2021
	public function getinstpaymentmethodsearchLov($instcode)
	{
			$mnm = '1';
			$sql = "SELECT * FROM octopus_admin_paymentmethod where PAY_STATUS = '$mnm' and PAY_INSTCODE = '$instcode'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo "<option value=''>-- Select --</option>";
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PAY_METHODCODE'].'">'.$obj['PAY_METHOD'].' </option>';
            }
	}


	// 03 JAN 2021
	public function getpaymentmethods()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_setup_paymentmethod where PM_STATUS = '$mnm'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['PM_CODE'].'@@@'.$obj['PM_METHOD'].'">'.$obj['PM_METHOD'].' </option>';
            }
	}
	
	
	//02 JAN 2021
	public function getuserlevelsetuplov()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_userlevels where LEVEL_STATE = '$mnm'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['LEVEL_CODE'].'@@@'.$obj['LEVEL_NAME'].'">'.$obj['LEVEL_NAME'].' </option>';
			}
			
	}

	//02 JAN 2021
	public function getuserlevellov()
	{
		$mnm = '2';
		$sql = " SELECT LEVEL_CODE,LEVEL_NAME FROM octopus_userlevels WHERE LEVEL_STATE = '$mnm'"; 
		$st = $this->db->prepare($sql); 
		$st->execute();
		echo '<option value= "">-- Select --</option>';
		while($obj = $st->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="'.$obj['LEVEL_CODE'].'@@@'.$obj['LEVEL_NAME'].'">'.$obj['LEVEL_NAME'].' </option>';
		}
			
	}

	//13 SEPT 2020
	public function getuserlevels()
	{
			$mnm = '2';
			$sql = " SELECT * FROM octopus_userlevels where LEVEL_LEVEL = '$mnm'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['LEVEL_CODE'].'@@@'.$obj['LEVEL_NAME'].'">'.$obj['LEVEL_NAME'].' </option>';
            }
	}
	
	
	//10 SEPT 2020
	public function getshifttypeLov($instcode)
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_admin_shifttypes where SHT_INSTCODE = '$instcode'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SHT_SHIFTTYPE'].'@@@'.$obj['SHT_STARTTIME'].'@@@'.$obj['SHT_ENDTIME'].'">'.$obj['SHT_SHIFTTYPE'].' </option>';
			}			
	}

	//01 JAN 2021
	public function getshifttypes()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_setup_shifttype where SHTY_STATUS = '$mnm'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['SHTY_CODE'].'@@@'.$obj['SHTY_TYPE'].'">'.$obj['SHTY_TYPE'].' </option>';
			}
			
	}	

	//01 JAN 2021
	public function getfacilitiesLov()
	{
			$mnm = '1';
			$sql = " SELECT * FROM octopus_setup_facilities where FAC_STATUS = '$mnm'"; 
			$st = $this->db->prepare($sql); 
			$st->execute();
			echo '<option value= "">-- Select --</option>';
			while($obj = $st->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="'.$obj['FAC_CODENUMBER'].'@@@'.$obj['FAC_NAME'].'@@@'.$obj['FAC_SHORTCODE'].'">'.$obj['FAC_NAME'].' </option>';
			}
			
	}
    
}
