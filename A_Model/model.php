<?php
	
	REQUIRE_ONCE "core/init.php";
	REQUIRE_ONCE "app_octopus_config.php";
	REQUIRE_ONCE "core/requireonce.php"	;
	$engine = new engine(); 
	$coder = new code();
	$msql = new mainsql();
	$db = $connections->dbconnect();
	$dbconn = $connections->dbconnect();
	
	$lov = new lov();
	$ulogs = new userlogs();
	$pat = new patients();
	$dash = new dashboard();
	$sett = new settings();
	$pricing = new pricing();
	// $cry = new crypt();
	
	$prepaidscheme = 'PREPAID WALLET';
	$pathed = 'folders/';
	$resultspathed = 'results/'; 
	$invoices = 'invoices/'; 
	$day = Date('Y-m-d');
	$days = Date('Y-m-d H:i:s');
	$dayformated = Date('d-m-Y');
	$dayformatedtime = Date('d-m-Y H:i:s');

	$year =  date('Y');
	$thereviewday = date('Y-m-d', strtotime($day. ' - 10 days'));
	$theexpiryday = date('Y-m-d', strtotime($day. ' + 30 days'));
	$formatedexpiryday = date('d-m-Y', strtotime($day. ' + 90 days'));
	
	$pricingtable = new OctopusStPricingSql();
	$userlogsql = new UsersLogsControllerSql();
	$shifttable = new OctopusShiftsSql();
	
	$patientsbillstable = new OctopusPatientsBillsClass();
	$patientrefundtable = new OctopusPatientRefundSql();
	$pricingtable = new OctopusStPricingSql();
	// $patientschemetable = new OctopusPatientsPaymentSchemeSql();
	$patienttable = new OctopusPatientsSql();
	$patientreviewtable = new OctopusPatientsReviewSql();
	$patientvisittable = new OctopusPatientsVisitSql();
	$patientdeathtable = new OctopusPatientsDeathSql();
	$patientbillitemtable = new OctopusPatientBillitemClass();
	$incidencetable = new OctopusIncidencesSql();	
	$patientsattachedresultstable = new OctopusPatientsAttachedResultsSql();
	$patientclaimstable = new OctopusPatientsClaimsSql();
	$patientprocedureconsumabletable =  new OctopusPatientsProcedureConsumableusedSql();
	$adminservicetable = new OctopusAdminServiceSql();
	$claimsmonthlytable = new OctopusClaimsMonthlySql();
	$claimsschemetable = new OctopusClaimsSchemeSql();
	$paymentschemetable = new OctopusPaymentSchemeClass();
	$patientcredittable = new OctopusPatientCreditClass();
	
	

	if($currentuserlevel == 38 || $currentuserlevel == 40 || $currentuserlevel == 10 ){
		$medsql = new MedicationController();
	}
	if($currentuserlevel == 1){		
		$reviewcontroller = new PatientReviewController();		
	//	$referalcontroller = new PatientsReferalController();		
	//	$stockadjustmenttable =  new OctopusStockadjustmentSql();
	//	$patientdeathsql = new PatientDeathController();					
	//	$requestservicesql = new RequestServiceController();	
	//	$requestappointsql = new RequestAppointmentController();
	//	$servicerequestsql = new ServiceRequestControllerSql();		
	//	$patientsgroupssql = new PatientsGroupsController();
	//	$recordscontroller = new RecordsController();		
	//	$medicalreportcontroller = new MedicalReportController();
	//	$appointmentcontroller = new AppointmentController();			
	}
	if($currentuserlevel == 2){
		$cashierforextable = new OctopusCashierForexSql();
		$diagnosistable = new OctopusPatientsDiagnosisSql();
		$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		$endofdaytable = new OctopusCashierEndofdaySql();
	}
	
	if($currentuserlevel == 3){
		$cashierforextable = new OctopusCashierForexSql();
		$endofdaytable = new OctopusCashierEndofdaySql();
	}
	if($currentuserlevel == 4){
		// $patientsServiceRequesttable = new OctopusPatientsServiceRequestSql();
		// $patientappointmenttable = new OctopusPatientsAppointmentSql;
		// $referaltable = new OctopusPatientsReferalSql();
		$patientsqueuecontroller = new PatientQueueController();		
		// $patientconsultationstable = new OctopusPatientsConsultationsSql();
		// $patientconsultationsarchivetable = new OctopusPatientsConsultationsArchiveSql();	
	//	$patientclaimscontroller = new PatientsClaimsController();		
	//	$patientclaimstable = new OctopusPatientsClaimsSql();
		// $patientsDevicestable = new OctopusPatientsDevicesSql();		
		// $patientproceduretable = new OctopusPatientsProceduresSql();		
		// $Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		// $diagnosistable = new OctopusPatientsDiagnosisSql();
		// $patientsInvestigationRequesttable = new OctopusPatientsInvestigationsRequestSql();		
		// $patientcomplainstable = new OctopusPatientsComplainsSql();
	// //	$medicalreportcontroller = new MedicalReportController();
		// $patientsMedicalreportstable = new OctopusPatientsMedicalreportsSql();		
		// $patientdeathtable = new OctopusPatientsDeathSql();		
		//$patientconsultationsarchivetable = new OctopusPatientsConsultationsArchiveSql();
	//	$reviewcontroller = new PatientReviewController();
		// $admissionactioncontroller = new AdmissionActionController();
		// $admissionsql = new PatientAdmissionController();
	//	$notessql = new PatientNotesController();
	//	$referalcontroller = new PatientsReferalController();
		
	//	$actionreferalcontroller = new ActionReferalController();
	//	$patientdeathsql = new PatientDeathController();
	//	$vitalssql = new OctopusPatientsPhysicalexamsSql();
		
	}
	
	if($currentuserlevel == 5 ){
		$patientproceduretable = new OctopusPatientsProceduresSql();
		$patientsDevicestable = new OctopusPatientsDevicesSql();
		$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		$diagnosistable = new OctopusPatientsDiagnosisSql();
		$procedureconsumabletable =  new OctopusProcedureConsumableSql();
		$consumablesetuptable = new OctopusSetupConsumablesSql();
		
		$admissionactionsql = new AdmissionActionController();
		$admissionsql = new PatientAdmissionController();
		$notessql = new PatientNotesController();
	}
	
	if($currentuserlevel == 4 ){
		$patientproceduretable = new OctopusPatientsProceduresSql();
		$patientsDevicestable = new OctopusPatientsDevicesSql();
		$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		$diagnosistable = new OctopusPatientsDiagnosisSql();
		$procedureconsumabletable =  new OctopusProcedureConsumableSql();
		$consumablesetuptable = new OctopusSetupConsumablesSql();
		
		$admissionactionsql = new AdmissionActionController();
		$admissionsql = new PatientAdmissionController();
		$notessql = new PatientNotesController();
	}
	
	if($currentuserlevel == 7){
		$patientproceduretable = new OctopusPatientsProceduresSql();
		$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		$patientsDevicestable = new OctopusPatientsDevicesSql();
		$diagnosistable = new OctopusPatientsDiagnosisSql();
		$stockadjustmenttable =  new OctopusStockadjustmentSql();
		$consumablesetuptable = new OctopusSetupConsumablesSql();
		$batchestable =  new OctopusBatchesSql();
		$medicationtable = new OctopusMedicationSql();
		$devicesetuptable = new OctopusDevicesSql();
	}
	if($currentuserlevel == 9){
		$cashierforextable = new OctopusCashierForexSql();
		$endofdaytable = new OctopusCashierEndofdaySql();
	}

	
	if($currentuserlevel ==38){
		$consumablesetuptable = new OctopusSetupConsumablesSql();
		$paymentschemetable = new OctopusPaymentSchemeClass();
		$procedureconsumabletable =  new OctopusProcedureConsumableSql();
		$patientprocedureconsumabletable =  new OctopusPatientsProcedureConsumableusedSql();
		$stockadjustmenttable =  new OctopusStockadjustmentSql();
		$expirytable =  new OctopusPharmacyExpirySql();
		$batchestable =  new OctopusBatchesSql();
		$proceduresetuptable = new OctopusProceduresSql();
		$labtesttable = new OctopusLabtestsSql();
	//	$imagingsetuptable = new OctopusImagingSql();
		$medicationtable = new OctopusMedicationSql();
		$planmedicationtable = new OctopusPrescriptionMedicationSql();
		$Prescriptionstable = new OctopusPatientsPrescriptionsSql();
		$devicesetuptable = new OctopusDevicesSql();
		$patientsDevicestable = new OctopusPatientsDevicesSql();
		$cashiertillstable = new OctopusCashierTillsSql();
		$cashierforextable = new OctopusCashierForexSql();
		$endofdaytable = new OctopusCashierEndofdaySql();
		$partnerbilltable = new OctopusCashierPartnerbillsSql();	

		$consumablecontroller =  new SetupConsumablesController();
	}	

	
	$patientsqueue = new PatientQueueController();
	$registrationsql = new RegistrationController();
	// $requestservicesql = new RequestServiceController();
	$cashiersql = new CashierController();
	// $paymentschemesql = new PaymentSchemeController();
	$facilitysql = new FacilityController();
	$nursesql = new NurseController();
	$consultationsql = new ConsultationController();
	$patientsql = new PatientController();
	$complainssql = new PatientComplainsController();
	$physicalexamssql = new PatientPhysicalExamController();
	$diagnosissql = new PatientDiagnosisController();
	$treatmentsql = new PatientTreatmentController();
	$prescriptionsql = new PatientPrescriptionController();
	$investigationsql = new PatientInvestigationController();
	$labssql = new LabsController();
	$schedulesql = new ScheduleController();
	$settingssql = new SettingsController();
	$appointmentsql = new AppointmentController();
	$pharmacysql = new PharmacyController();
	$recordssql = new RecordsController();
	$setupsql = new SetupController();
	$billingsql = new BillingController();
	
	$consultactionsql = new ConsultationActionController();
	$referalsql = new ConsultationActionReferalController();
	$partnerpaymentsql = new CashierPartnerPaymentController();
	$reviewsql = new PatientReviewController();
	$walkinsql = new WalkinController();
	$prescriptionplansql = new PrescriptionPlanController();
	$sentoutsql = new SentoutController();
	$requestionsql = new RequestionController();
	$storessql = new StoresController();	
	$physiosql = new PatientPhysioController();
	// $cashierwalletsql = new cashierWalletController();
	$cashierrefunds = new cashierRefundsController();
	$cashierreceiptssql = new CashierRecieptController();
	$pprescripesql = new PharmacyPrescripeController();
	$pdevicesql = new PharmacyDeviceController();
	$proceduresql = new ProcedureController();
	$nav = new navigation();
	
	$prepaidchemecode = $paymentschemetable->getprepaidchemecode($prepaidcode,$instcode);
	$prepaidscheme = 'PREPAID WALLET';
	
	//REQUIRE_ONCE 'controller/MedicationController.php';
	
	//$medsql = new MedicationController();
	

	$userdetails = $usertable->getcurrentuserdetails();		
	if($userdetails !== '-1'){		
		$usd = explode('@@@', $userdetails);
		$currentusercode = $usd[0];
		$currentuser = $usd[2];
		$currentusername = $usd[1];
		$currentuserlevel = $usd[3];
		$currentusershortcode = $usd[4];
		$currentuserinst = $usd[10];
		$instcode = $usd[8];
		$userkey = $usd[6];
		$loginkey= $usd[7];
		$currentuserlevelname = $usd[11];
		$useraccesslevel= $usd[12];
		$currentuserspec= $usd[13];
		
		$prepaidchemecode = $paymentschemetable->getprepaidchemecode($prepaidcode,$instcode);		
		$cashschemecode = $paymentschemetable->getcashschemecode($cashpaymentmethodcode,$instcode);
		$currentshiftdetails = $engine->getcurrentdetails($instcode);

		if($currentshiftdetails !== 0){
			
			$usde = explode('@@@', $currentshiftdetails);
			$currentshiftcode = $usde[0];
			$currentshift = $usde[1];
			$currentshifttype = $usde[2];
			$currentdate = $usde[3];
			$currentstaffpershift = $usde[4];
			$currentconsultationduration = $usde[6];
			$currentconsultationstart = $usde[7];	
			$currentconsultationend = $usde[8];	
			$currentconsultationdaysahead = $usde[9];	
			$currentappointmentnumber = $usde[10];		
			$currentshiftstart = $usde[11];
			$currentshiftend = $usde[12];
			$currentlastcheck = $usde[13];
			$currentday = $usde[14];
			$currentweek = $usde[15];
			$currentmonth = $usde[16];
			$currentyear = $usde[17];
			$currenttime = date('H');		
		
		}else{
			$currentshiftcode=$currentshift=$currentshifttype=$currentdate=$currentstaffpershift= -1;
		}
				if($currentuserlevel == "38"){
					//die;
					REQUIRE_ONCE "model/medicationModel.php";
					REQUIRE_ONCE "controller/MedicationController.php";
					$medsql = new MedicationController();
				}
	}else{
		$currentusercode='';
	}	

	$model = isset($_POST['model']) ? $_POST['model'] : '';	
	// 18 FEB 2021
	switch ($model)
	{		
			
	} 

?>
