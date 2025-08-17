<?php 
	REQUIRE_ONCE ('app_octopus_config.php');	
	REQUIRE_ONCE (INTFILE);
				
	if(!isset($_GET['SEG_ONE'])){
		$page = htmlentities('login');
	}else{
		// $page = htmlentities($_GET['SEG_ONE']);	
		$startpage = htmlentities($_GET['SEG_ONE']); 
		if(!empty($startpage)){
			$page = $startpage;			
		}else{
			$page = $_SERVER['REQUEST_URI'];
			$pag = explode('/', $page);
			$pagone = $pag[1];
			$ppg = explode('?', $pagone);
			$page = $ppg[0];			
		}		
	}
/*

109
110
111
112
113
114
115
116
117
118
119
120

*/
	$exp = explode('__', $page);
	$modelroute = $exp[0];	
	if($modelroute == 'physio'){
		$modelpage = $exp[1];
		require_once 'index_physio.php';
	}else if($modelroute == 'labs'){
		$modelpage = $exp[1];
		require_once 'index_labs.php';
	}else if($modelroute == 'investigationplansetup'){
		$modelpage = $exp[1];
		require_once 'index_investigationplansetup.php';
	}else if($modelroute == 'radiologysetup'){
		$modelpage = $exp[1];
		require_once 'index_radiologysetup.php';
	}else if($modelroute == 'patientfolder'){
		$modelpage = $exp[1];
		require_once 'index_patientfolder.php';
	}else if($modelroute == 'admin'){
		$modelpage = $exp[1];
		require_once 'index_admin.php';
	}else if($modelroute == 'radiology'){
		$modelpage = $exp[1];
		require_once 'index_radiology.php';
	}else if($modelroute == 'walkin'){
		$modelpage = $exp[1];
		require_once 'index_walkin.php';
	}else if($modelroute == 'cashier'){
		$modelpage = $exp[1];
		require_once 'index_cashier.php';
	}else if($modelroute == 'stats'){
		$modelpage = $exp[1];
		require_once 'index_stats.php';
	}else if($modelroute == 'setup'){
		$modelpage = $exp[1];
		require_once 'index_setup.php';
	}else if($modelroute == 'report'){
		$modelpage = $exp[1];
		require_once 'index_report.php';
	}else if($modelroute == 'admission'){
		$modelpage = $exp[1];
		require_once 'index_admission.php';
	}else if($modelroute == 'claimbilling'){
		$modelpage = $exp[1];
		require_once 'index_claimbilling.php';
	}else if($modelroute == 'records'){
		$modelpage = $exp[1];
		require_once 'index_records.php';
	}else if($modelroute == 'promotion'){
		$modelpage = $exp[1];
		require_once 'index_promotion.php';
	}else if($modelroute == 'genstore'){
		$modelpage = $exp[1];
		require_once 'index_generalstore.php';
	}else if($modelroute == 'attachment'){
		$modelpage = $exp[1];
		require_once 'index_attachment.php';
	}else if($modelroute == 'review'){
		$modelpage = $exp[1];
		require_once 'index_review.php';
	}else if($modelroute == 'medicalreport'){
		$modelpage = $exp[1];
		require_once 'index_medicalreport.php';
	}else if($modelroute == 'incidence'){
		$modelpage = $exp[1];
		require_once 'index_incidence.php';
	}else if($modelroute == 'patient'){
		$modelpage = $exp[1];
		require_once 'index_patient.php';
	}else if($modelroute == 'cash'){
		$modelpage = $exp[1];
		require_once 'index_cash.php';
	}else if($modelroute == 'wallet'){
		$modelpage = $exp[1];
		require_once 'index_wallet.php';
	}else{
		

// sleep(15); 
#Switch statement to display respective pages      
#Switch statement to display respective pages      
 
switch (strtolower($page))
{
	
	

	// 15 JUNE 2024  
	case 'patientreferalbookings':
		include(ROOTDOC.DS.'app_octopus_patient_referal.php');
	break;
	
	// // 09 JULY 2021
	// case 'patientfolderlist':
	// 	include(ROOTDOC.DS.'app_octopus_consultations_patientfolder.php');
	// break;

	// 1 OCT 2024  JOSEPH ADORBOE  
	case "pastprocedurenursereport":
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_past_reports.php');
	break;
	// 28 AUG 2024   
	case "pasteditpatientfollowup":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientfollowup_edit.php');
	break;
	// 28 AUG 2024   
	case "pasthistroypatientfollowup":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientfollowup_histroy.php');
	break;
	// 27 AUG 2024   
	case "pastaddpatientfollowup":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientfollowup_add.php');
	break;
	// 22 AUG 2024   
	case "pasteditpatientwounddressing":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientwounddressing_edit.php');
	break;
	// 22 AUG 2024   
	case "pasthistroypatientwounddressing":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientwounddressing_history.php');
	break;
	//21 AUG 2024, JOSEPH ADORBOE 
	case "pastaddpatientwounddressing":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientwounddressing_add.php');
	break;
	// 18 AUG 2024   
	case "pastviewpatientlabsview":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientlabs_view.php');
	break;	
	// 17 AUG 2024   
	case "pasteditpatientmanagement":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientmanagement_edit.php');
	break;
	// 17 AUG 2024   
	case "pasthistroypatientmanagement":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientmanagement_history.php');
	break;
	// 16 AUG 2024   
	case "pasteditpatientprescription":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprescription_edit.php');
	break;
	
	// 16 AUG 2024   
	case "pasteditpatientdiagnosis":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdiagnosis_edit.php');
	break;
	// 16 AUG 2024   
	case "pastremovepatientlabs":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientlabs_remove.php');
	break;
	// 16 AUG 2024   
	case "pasteditpatientimaging":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientimaging_edit.php');
	break;
	// 16 AUG 2024   
	case "pasteditpatientlabs":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientlabs_edit.php');
	break;

	


	// 15 AUG 2024   
	case "pasteditpatientphysicalexams":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientexam_edit.php');
	break;
	// 15 AUG 2024   
	case "pasteditpatientcomplain":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientcomplains_edit.php');
	break;
	// 15 AUG 2024   
	case "pasteditpatientvitals":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientvitals_edit.php');
	break;
	// 15 AUG 2024   
	case "pastaddpatientmanagement":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientmanagement_add.php');
	break;
	
	// 15 AUG 2024   
	case "pasthistroypatientdoctornotes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdoctornotes_history.php');
	break;
	// 15 AUG 2024   
	case "pastupdatespatientdoctornotes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdoctornotes_updates.php');
	break;
	// 15 AUG 2024   
	case "pasteditpatientdoctornotes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdoctornotes_edit.php');
	break;
	// 11 AUG 2024   
	case "pastaddpatientdoctornotes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdoctornotes_add.php');
	break;


	// 11 AUG 2024   
	case "pasthistroypatientprocedure":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprocedure_history.php');
	break;
	// 11 AUG 2024   
	case "pasteditpatientprocedure":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprocedure_edit.php');
	break;
	// 11 AUG 2024   
	case "pastaddpatientprocedure":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprocedure_add.php');
	break;

	// 11 AUG 2024   
	case "pasthistroypatientdevice":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdevice_history.php');
	break;
	// 11 AUG 2024   
	case "pasteditpatientdevices":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdevice_edit.php');
	break;
	// 11 AUG 2024   
	case "pastaddpatientdevices":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdevice_add.php');
	break;

	// 10 AUG 2024   
	case "pasthistroypatientprescription":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprescription_history.php');
	break;
	// 10 AUG 2024   
	case "pastaddpatientprescription":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientprescription_add.php');
	break;

	// 10 AUG 2024   
	case "pasthistroypatientdiagnosis":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdiagnosis_history.php');
	break;
	// 10 AUG 2024   
	case "pastaddpatientdiagnosis":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientdiagnosis_add.php');
	break;
	// 9 AUG 2024   
	case "pasthistroypatientimaging":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientimaging_history.php');
	break;
	// 9 AUG 2024   
	case "pastaddpatientimaging":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientimaging_add.php');
	break;
	// 9 AUG 2024   
	case "pasthistroypatientlabs":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientlabs_history.php');
	break;
	// 9 AUG 2024   
	case "pastaddpatientlabs":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientlabs_add.php');
	break;
	// 9 AUG 2024   
	case "pasthistroypatientexam":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientexam_history.php');
	break;
	// 9 AUG 2024   
	case "pastaddpatientexams":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientexam_add.php');
	break;
	// 9 AUG 2024   
	case "pasthistroypatientoutcomes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientoutcomes_history.php');
	break;
	// 9 AUG 2024   
	case "pastaddpatientoutcomes":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientoutcomes_add.php');
	break;
	// 9 AUG 2024   
	case "pasthistroypatientvitals":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientvitals_history.php');
	break;
	// 9 AUG 2024   
	case "pastaddpatientvitals":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientvitals_add.php');
	break;
	// 8 AUG 2024   
	case "pasthistroypatientcomplains":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientcomplains_history.php');
	break;
	// 8 AUG 2024   
	case "pastaddpatientcomplains":
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_patientcomplains_add.php');
	break;	
	// 31 JULY 2024   
	case "patientwalkininvestigationsimaging":
		include(ROOTDOC.DS.'app_octopus_patients_walkin_imageing.php');
	break;
	// 31 JULY 2024   
	case "patientwalkininvestigationslabs":
		include(ROOTDOC.DS.'app_octopus_patients_walkin_labs.php');
	break;
	// 31 JULY 2024   
	case "patientwalkininvestigations":
		include(ROOTDOC.DS.'app_octopus_patients_walkin.php');
	break;
	// 31 JULY 2024   
	case "patientwalkininvestigationfilter":
		include(ROOTDOC.DS.'app_octopus_patients_walkin_filter.php');
	break;	
	// 31 JULY 2024   
	case "attacheddocumentview":
		include(ROOTDOC.DS.'app_octopus_patients_attachments_documents_single.php');
	break;
	// 31 JULY 2024   
	case "patientnonrequestedview":
		include(ROOTDOC.DS.'app_octopus_patients_nonrequested_view.php');
	break;
	// 31 JULY 2024   
	case "patientnonrequested":
		include(ROOTDOC.DS.'app_octopus_patients_nonrequested.php');
	break;
	// 31 JULY 2024   
	case "patientnonrequestedfilter":
		include(ROOTDOC.DS.'app_octopus_patients_nonrequested_filter.php');
	break;
	
	
	// 18 JUNE 2024  
	case 'patientattachmentlist':
		include(ROOTDOC.DS.'app_octopus_patients_attachments_attached.php');
	break;
	// 18 JUNE 2024  
	case 'patientattachmentview':
		include(ROOTDOC.DS.'app_octopus_patients_attachments_documents_view.php');
	break;
	// 18 JUNE 2024  
	case 'patientattachmentsdocumentslist':
		include(ROOTDOC.DS.'app_octopus_patients_attachments_documents_list.php');
	break;
	// 17 JUNE 2024  
	case 'patientglucosemonitor':
		include(ROOTDOC.DS.'app_octopus_patients_glucose_monitor.php');
	break;
	// 17 JUNE 2024  
	case 'patientallergies':
		include(ROOTDOC.DS.'app_octopus_patients_alleries.php');
	break;
	
	// 15 JUNE 2024, JOSEPH ADORBOE 
	case 'patientattachmentsdocuments':
		include(ROOTDOC.DS.'app_octopus_patients_attachments_documents.php');
	break;
	// 15 JUNE 2024, JOSEPH ADORBOE 
	case 'patientattachmentstoday':
		include(ROOTDOC.DS.'app_octopus_patients_attachments_today.php');
	break;
	// 15 JUNE 2024, JOSEPH ADORBOE 
	case 'patientattachments':
		include(ROOTDOC.DS.'app_octopus_patients_attachments.php');
	break;
	// 1 JUNE 2024, JOSEPH ADORBOE 
	case 'nursepatientvitals':
		include(ROOTDOC.DS.'app_octopus_nurse_vitals.php');
	break;
	// 27 MAY 2024, JOSEPH ADORBOE 
	case 'managenursingservices':
		include(ROOTDOC.DS.'app_octopus_nurse_servicing.php');
	break;
	// 25 MAY 2024, JOSEPH ADORBOE 
	case 'managecancelledconsultation':
		include(ROOTDOC.DS.'app_octopus_nurse_cancelled_consultation.php');
	break;
	// 25 MAY 2024, JOSEPH ADORBOE 
	case 'managecancelledservices':
		include(ROOTDOC.DS.'app_octopus_nurse_cancelled_services.php');
	break;
	// 22 MAY 2024, JOSEPH ADORBOE 
	case 'nursefollowupupcominglist':
		include(ROOTDOC.DS.'app_octopus_nurse_followup_upcoming.php');
	break;
	// 21 MAY 2024, JOSEPH ADORBOE 
	case 'patientqueuenursesnotesdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_notes_details.php');
	break;
	// 17 MAY 2024, JOSEPH ADORBOE 
	case 'nursefollowuplist':
		include(ROOTDOC.DS.'app_octopus_nurse_followup.php');
	break;
	// 17 MAY 2024, JOSEPH ADORBOE 
	case 'patientqueuenursesnoteslist':
		include(ROOTDOC.DS.'app_octopus_nurse_notes_list.php');
	break;
	// 16 MAY 2024, JOSEPH ADORBOE 
	case 'patientfollowupsdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfollowup.php');
	break;
	// 15 MAY 2024, JOSEPH ADORBOE 
	case 'nursepatientqueueconsultation':
		include(ROOTDOC.DS.'app_octopus_nurse_patientqueue_consultation.php');
	break;
	// 15 MAY 2024, JOSEPH ADORBOE 
	case 'nursepatientqueuepasted':
		include(ROOTDOC.DS.'app_octopus_nurse_patientqueue_past.php');
	break;
	// 15 MAY 2024, JOSEPH ADORBOE 
	case 'patientqueuenursesnotes':
		include(ROOTDOC.DS.'app_octopus_nurse_notes.php');
	break;
	

	// 13 JAN 2024, JOSEPH ADORBOE 
	case 'patientconsultationsearch':
		include(ROOTDOC.DS.'app_octopus_consultations_patientsearchfilter.php');
	break;
	
	
	 // 14 NOV 2023
	case 'patientfolderprescriptionplan':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_prescriptions_plan.php');
	break;
	// 14 NOV 2023
	case 'patientfolderprescriptions':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_prescriptions.php');
	break;
	
	 // 31 OCT 2023
	 case 'manageprocedureconsumables':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_consumables.php');
	break;
	// 7 NOV 2023, 30 AUG 2021
	case 'patientfolderdevices':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_devices.php');
	break;
	 // 7 NOV 2023
	 case 'patientfolderreferal':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_referal.php');
	break;
	 // 7 NOV 2023
	 case 'patientfolderreview':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_review.php');
	break;
	
	 // 31 OCT 2023
	 case 'manageprocedureconsumables':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_consumables.php');
	break;
	// 5 NOV 2023
	case 'patientfolderprocedures':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_procedures.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_updates.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesmanagement':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_management.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesnurse':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_nurse.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesadmission':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_admission.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesdietican':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_diet.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesphysio':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_physio.php');     
	break;
	// 4 NOV 2023
	case 'patientfoldernotesopd':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes_opd.php');     
	break;
	// 3 NOV 2023
	case 'patientfolderdiagnosisupdated':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_diagnosis_updates.php');     
	break;
	// 30 Oct 2023
	case 'consultationpatientprocedures':
		include(ROOTDOC.DS.'app_octopus_consultations_patientprocedures.php');     
	break;
	// 28 Oct 2023
	case 'patientfolderphysicalexamshistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_physicalexams_history.php');     
	break;
	// 28 Oct 2023
	case 'patientfolderphysicalexamsupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_physicalexams_updates.php');     
	break;
	// 28 Oct 2023
	case 'patietnfoldercomplainthistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_complains_history.php');     
	break;
	// 28 Oct 2023
	case 'patientfoldercomplaintupdate':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_complains_updates.php');     
	break;
	// 28 Oct 2023
	case 'patientfolderaddcomplaint':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_complains_bulk.php');     
	break;
	// 13 Oct 2023
	case 'consultationpatientphysiotheraphyhistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientphysiotheraphy_history.php');     
	break;
	// 13 Oct 2023
	case 'consultationpatientdieteticshistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdietitican_history.php');     
	break;
	// 12 Oct 2023
	case 'patientsnotesupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdoctornotes_updates.php');     
	break;
	 // 8 Oct 2023
	case 'patientscomplainsupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientcomplains_updates.php');     
	break;
	// 7 Oct 2023
	case 'patientsdiagnosisupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdiagnosis_updates.php');     
	break;
	// 5 Oct 2023
	case 'physicalexamsupdates':
		include(ROOTDOC.DS.'app_octopus_consultations_patientphysicalexams_updates.php');     
	break; 
	
	
	
	
	// 26 MAY 2023
	case 'consultationpatientdieteticsvitals':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdietitican_vitals.php');
	break;
	// 26 MAY 2023
	case 'patientfolderlistnotes':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_notes.php');
	break;
	// 1 MAY 2023
	case 'generatelabrequestpdf':
		include(ROOTDOC.DS.'app_octopus_labs_request_pdf.php');
	break;
	// 1 MAY 2023
	case 'nursepricingmedications':
		include(ROOTDOC.DS.'app_octopus_pricing_medications.php');
	break;
	// 1 MAY 2023
	case 'nursepricingdevices':
		include(ROOTDOC.DS.'app_octopus_pricing_devices.php');
	break;
	// 1 MAY 2023
	case 'nursepricingimaging':
		include(ROOTDOC.DS.'app_octopus_pricing_imaging.php');
	break;
	// 1 MAY 2023
	case 'nursepricinglabs':
		include(ROOTDOC.DS.'app_octopus_pricing_labs.php');
	break;
	// 1 MAY 2023
	case 'nursepricingprocedure':
		include(ROOTDOC.DS.'app_octopus_pricing_procedure.php');
	break;
	// 1 MAY 2023
	case 'nursepricing':
		include(ROOTDOC.DS.'app_octopus_pricing_services.php');
	break;
	// 21 APR 2021
	case 'labimagingpricing':
		include(ROOTDOC.DS.'app_octopus_labs_imaging_pricing.php');
	break;
		
	// 19 MAR 2023
	case 'patientreferal':
		include(ROOTDOC.DS.'app_octopus_patients_referal.php');
	break;
	// 19 MAR 2023
	case 'generatereferalpdf':
		include(ROOTDOC.DS.'app_octopus_consultations_patientreferals_pdf.php');
	break;
	// 19 MAR 2023
	case 'consultationpatientexternalreferalsnew':
		include(ROOTDOC.DS.'app_octopus_consultations_patientreferals_new.php');
	break;
	// 19 MAR 2023
	case 'consultationpatientexternalreferals':
		include(ROOTDOC.DS.'app_octopus_consultations_patientreferals.php');
	break;
	
	
	
	// 19 JAN 2023
	case 'consultationcompletedtoday':
		include(ROOTDOC.DS.'app_octopus_consultations_completedtoday.php');
	break;
	// 18 JAN 2023
	case 'consultationpatientdoctornotes':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdoctornotes.php');
	break;
	// 13 JAN 2023
	case 'consultationpatientdietetics':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdietitican.php');
	break;
	 // 13 JAN 2023
	 case 'consultationpatientphysiotheraphy':
		include(ROOTDOC.DS.'app_octopus_consultations_patientphysiotheraphy.php');
	break;
	
	// 28 DEC 2022
	case 'manageimagingpriceingdetails':
		include(ROOTDOC.DS.'app_octopus_price_imaging_details.php');
	break;
	// 28 DEC 2022
	case 'manageimagingpriceing':
		include(ROOTDOC.DS.'app_octopus_price_imaging.php');
	break;
	// 28 DEC 2022
	case 'managelabspriceingdetails':
		include(ROOTDOC.DS.'app_octopus_price_labs_details.php');
	break;
	// 27 DEC 2022
	case 'managelabspriceing':
		include(ROOTDOC.DS.'app_octopus_price_labs.php');
	break;
	// 25 DEC 2022
	case 'manageedservicesdetails':
		include(ROOTDOC.DS.'app_octopus_price_services_details.php');
	break;
	// 25 DEC 2022
	case 'manageedservices':
		include(ROOTDOC.DS.'app_octopus_price_services.php');
	break;
	// 24 DEC 2022
	case 'manageprocedurepriceingdetails':
		include(ROOTDOC.DS.'app_octopus_price_procedure_details.php');
	break;
	// 24 DEC 2022
	case 'manageprocedurepriceing':
		include(ROOTDOC.DS.'app_octopus_price_procedure.php');
	break;
	 // 13 DEC 2022
	 case 'labsrequestreportdoctordetailspdf':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_doctor_pdf.php');
	break;
	 // 13 DEC 2022
	 case 'labsrequestreportdoctordetails':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_doctor.php');
	break;
	// 13 DEC 2022
	case 'labsrequestreportlabsdetailspdf':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_labs_pdf.php');
	break;
	// 13 DEC 2022
	case 'labsrequestreportlabsdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_labs.php');
	break;
	// 13 DEC 2022
	case 'labsrequestreportpatientdetailspdf':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_patient_pdf.php');
	break;
	// 13 DEC 2022
	case 'labsrequestreportpatientdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details_patient.php');
	break;
	// 13 DEC 2022
	case 'labreportsnornimalpdf':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_normial_pdf.php');
	break;
	 // 13 DEC 2022
	 case 'labsrequestreportdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports_details.php');
	break;
	 // 11 DEC 2022
	 case 'labreports':
		include(ROOTDOC.DS.'app_octopus_labs_labrequest_reports.php');
	break;
	
	
	// 28 NOV 2022
	case 'monitordevices':
		include(ROOTDOC.DS.'app_octopus_monitor_devices.php');
	break;
	// 27 NOV 2022
	case 'monitorpharmacy':
		include(ROOTDOC.DS.'app_octopus_monitor_pharmacy.php');
	break;
	
	
	// 02 OCT 2022
	case 'pharmacypatientfolderproceduredetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder_procedure_details.php');
	break;
	// 02 OCT 2022
	case 'pharmacypatientfolderprocedure':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder_procedure.php');
	break;
	// 24 SEPT 2022
	case 'pharmacypatientfolderdevicedetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder_devices_details.php');
	break;
	// 02 OCT 2022
	case 'pharmacypatientfolderdevice':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder_devices.php');
	break;
	
	
	// 24 SEPT 2022
	case 'pharmacypatientfolderdetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder_prescriptions_details.php');
	break;
	// 24 SEPT 2022
	case 'pharmacypatientfolder':
		include(ROOTDOC.DS.'app_octopus_pharmacy_patientfolder.php');
	break;
	
	
	// 29 JULY 2022
	case 'patientfoldervisitoutcome':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_visitoutcome.php');
	break;
	
	
	
	// 2 JUNE 2022
	case 'processpartnerimaging':
		include(ROOTDOC.DS.'app_octopus_labs_imaging_partners.php');
	break;
	// 29 MAY 2022
	case 'consultationpatientcomplaintbulk':
		include(ROOTDOC.DS.'app_octopus_consultations_patientcomplains_bulk.php');
	break;
	// 29 MAY 2022
	case 'setupimaging':
		include(ROOTDOC.DS.'app_octopus_st_imaging.php');
	break;
	
	
	// 15 MAY 2022 
	case 'partnerlist':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest_partners_list.php');
	break;
	
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 4 MAY 2022 
	case 'physioreports':
		include(ROOTDOC.DS.'app_octopus_reports_physio.php');
	break;
	// 3 MAY 2022 
	case 'physiotherapyreportsfilter':
		include(ROOTDOC.DS.'app_octopus_reports_physio_filter.php');
	break;
	// 3 MAY 2022 
	case 'archivetreatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports_archive.php');
	break;
	// 3 MAY 2022
	case 'physiopatienttreatmentarchive':
		include(ROOTDOC.DS.'app_octopus_physio_patienttreatments_archives.php');
	break;
	// 3 MAY 2022
	case 'physioservicebasketarchivesdetails':
		include(ROOTDOC.DS.'app_octopus_physio_servicebasket_archives_details.php');
	break;
	// 2 MAY 2022
	case 'managephysioservicebasketarchives':
		include(ROOTDOC.DS.'app_octopus_physio_servicebasket_archives.php');
	break;
	// 2 MAY 2022 2
	case 'physiopatientaction':
		include(ROOTDOC.DS.'app_octopus_physio_patientaction.php');
	break;
	// 2 MAY 2022 2
	case 'treatmentreport':
		include(ROOTDOC.DS.'app_octopus_physio_treatment_reports.php');
	break;
	// 1 MAY 2022
	case 'physiopatienttreatment':
		include(ROOTDOC.DS.'app_octopus_physio_patienttreatments.php');
	break;
	// 1 MAY 2022
	case 'physioservicebasketdetails':
		include(ROOTDOC.DS.'app_octopus_physio_servicebasket_details.php');
	break;
	// 1 MAY 2022
	case 'managephysioservicebasket':
		include(ROOTDOC.DS.'app_octopus_physio_servicebasket.php');
	break;	
	
	// 18 APR 2022
	case 'managestoresdetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_requisition_restock_details.php');
	break;
	// 17 APR 2022
	case 'managestores':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_stores.php');
	break;
	// 15 APR 2022
	case 'requestionrestock':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_requisition_restock.php');
	break;
	// 15 APR 2022
	case 'requestiondetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_requisition_details.php');
	break;
	
	// 13 APR  2022
	case 'consultationpatientdiagnosisadd':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdiagnosis_add.php');
	break;
	 // 12 MAR 2022
	 case 'archievefilter':
		include(ROOTDOC.DS.'app_octopus_archive_filter.php');
	break;
	// 12 MAR 2022 JOSEPH ADORBOE 
	case 'walkinnonpatientimagingequest':
		include(ROOTDOC.DS.'app_octopus_walk_in_imageing_nonpatient.php');
	break;
	
	// 12 MAR 2022 JOSEPH ADORBOE 
	case 'walkinnonpatientlabrequest':
		include(ROOTDOC.DS.'app_octopus_walk_in_labs_nonpatient.php');
	break;
	// 12 MAR 2022 JOSEPH ADORBOE 
	case 'walkinlabrequest':
		include(ROOTDOC.DS.'app_octopus_walk_in_labs.php');
	break;
	
	// 05 MAR 2022 JOSEPH ADORBOE 
	case 'processpartnerlabs':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest_partners.php');
	break;
	// 13 FEB 2022 JOSEPH ADORBOE 
	case 'nursehandovernotes':
		include(ROOTDOC.DS.'app_octopus_nurse_handover.php');
	break;
	// 13 FEB 2022 JOSEPH ADORBOE 
	case 'servicebasketarchives':
		include(ROOTDOC.DS.'app_octopus_nurse_servicebasket_archives.php');
	break;
	// 12 FEB 2022 JOSEPH ADORBOE 
	case 'vitalhistorydetails':
		include(ROOTDOC.DS.'app_octopus_nurse_vitals_details.php');
	break;
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'prescriptionplandetails':
		include(ROOTDOC.DS.'app_octopus_prescriptionplan_details.php');
	break;
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'setupprescriptionplan':
		include(ROOTDOC.DS.'app_octopus_prescriptionplan.php');
	break;
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'labplandetails':
		include(ROOTDOC.DS.'app_octopus_consultations_labplans_details.php');
	break;
	// 23 JAN 2022 JOSEPH ADORBOE 
	case 'setuplabplan':
		include(ROOTDOC.DS.'app_octopus_consultations_labplans.php');
	break;
	
	// 22 JAN 2022 JOSEPH ADORBOE 
	case 'consultationpatientdocument':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdocuments.php');
	break;
	
	// 22 JAN 2022 JOSEPH ADORBOE 
	case 'pastproceduresdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_details_past.php');
	break;
	// 22 JAN 2022 JOSEPH ADORBOE 
	case 'pastprocedures':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_past.php');
	break;
	// 13 JAN 2022 JOSEPH ADORBOE 
	case 'pastconsultationdetails':
		include(ROOTDOC.DS.'app_octopus_consultations_pasted_summary.php');
	break;
	// 13 JAN 2022 JOSEPH ADORBOE 
	case 'pastconsultation':
		include(ROOTDOC.DS.'app_octopus_consultations_pasted.php');
	break;
	// 12 JAN 2022 JOSEPH ADORBOE 
	case 'setupbeds':
		include(ROOTDOC.DS.'app_octopus_st_beds.php');
	break;
	// 11 JAN 2022 JOSEPH ADORBOE 
	case 'setupwardsandbeds':
		include(ROOTDOC.DS.'app_octopus_st_wardsandbeds.php');
	break;
	
	// 11 JAN 2022 JOSEPH ADORBOE 
	case 'manageadmission':
		include(ROOTDOC.DS.'app_octopus_admissions.php');
	break;
	// 21 DEC 2021 JOSEPH ADORBOE 
	case 'consultationpatientresultsattached':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_resultsattached.php');
	break;
	// 21 DEC 2021 JOSEPH ADORBOE 
	case 'consultationpatientresultsattached':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_resultsattached.php');
	break;
	// 21 DEC 2021 JOSEPH ADORBOE 
	case 'consultationpatientresultsattached':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_resultsattached.php');
	break;
	// 21 DEC 2021 JOSEPH ADORBOE 
	case 'consultationpatientresultsattached':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_resultsattached.php');
	break;
	// 02 JAN 2022 JOSEPH ADORBOE 
	case 'patientstatspdf':
		include(ROOTDOC.DS.'app_octopus_stats_patient_pdf.php');
	break;
	// 02 JAN 2022 JOSEPH ADORBOE 
	case 'generalstats':
		include(ROOTDOC.DS.'app_octopus_stats_filter.php');
	break;
	// 21 DEC 2021 JOSEPH ADORBOE 
	case 'consultationpatientresultsattached':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_resultsattached.php');
	break;
	
	
	// 21 FEB 2025, JOSEPH ADORBOE 
	case 'consultationreportcomplain':
		include(ROOTDOC.DS.'app_octopus_consultation_report_complain.php');
	break;
	// 21 FEB 2025, JOSEPH ADORBOE 
	case 'consultationreportdoctor':
		include(ROOTDOC.DS.'app_octopus_consultation_report_doctor.php');
	break;
	// 21 FEB 2025, JOSEPH ADORBOE 
	case 'consultationreportdiagnosis':
		include(ROOTDOC.DS.'app_octopus_consultation_report_diagnosis.php');
	break;
	// 1 DEC 2021 JOSEPH ADORBOE 
	case 'consultationreport':
		include(ROOTDOC.DS.'app_octopus_consultation_report.php');
	break;
	// 01 DEC 2021 JOSEPH ADORBOE 
	case 'consultationreportsfilter':
		include(ROOTDOC.DS.'app_octopus_consultation_report_filter.php');
	break;
	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientrequestlabs':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_labplans_request.php');
	break;
	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientlabsplansdetails':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_labplans_testlist.php');
	break;
	// 22 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientlabsplans':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_labplans.php');
	break;
	// 21 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientdiagnosishistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdiagnosis_history.php');
	break;
	// 21 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientphysicalexamhistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientphysicalexams_history.php');
	break;
	// 19 NOV 2021 JOSEPH ADORBOE 
	case 'consultationpatientcomplainthistory':
		include(ROOTDOC.DS.'app_octopus_consultations_patientcomplains_history.php');
	break;
	// 13 NOV 2021 JOSEPH ADORBOE 
	case 'myconsultationreport':
		include(ROOTDOC.DS.'app_octopus_consultations_myconsultation.php');
	break;
	// 13 NOV 2021 JOSEPH ADORBOE 
	case 'myconsultationsfilter':
		include(ROOTDOC.DS.'app_octopus_consultations_myconsultationfilter.php');
	break;
	
	// 11 NOV 2021 JOSEPH ADORBOE 
	case 'patientstatsreport':
		include(ROOTDOC.DS.'app_octopus_stats_patient_reports.php');
	break;
	// 11 NOV 2021 JOSEPH ADORBOE 
	case 'managepatientstats':
		include(ROOTDOC.DS.'app_octopus_stats_patient_filter.php');
	break;
	
	// 2 NOV 2021 JOSEPH ADORBOE 
	case 'managescheduled':
		include(ROOTDOC.DS.'app_octopus_schedule.php');
	break;
	
	// 1 NOV 2021 JOSEPH ADORBOE 
	case 'monitorprocedures':
		include(ROOTDOC.DS.'app_octopus_consultations_monitorprocedures.php');
	break;	
	// 1 NOV 2021 JOSEPH ADORBOE 
	case 'patientqueuelist':
		include(ROOTDOC.DS.'app_octopus_consultations_patientqueue.php');
	break;	
	
		
	
	
	// 12 OCT 2021
	case 'consultationpatientattachedresultspatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_results_attached.php');
	break;
	// 10 OCT 2021
	case 'managevisitfilter':
		include(ROOTDOC.DS.'app_octopus_backend_managevisit_filter.php');
	break;
	// 25 SEPT 2021
	case 'Imagingresultsdetails':
		include(ROOTDOC.DS.'app_octopus_labs_Imagingresults_details.php');
	break;
	// 25 SEPT 2021
	case 'Imagingpendingresults':
		include(ROOTDOC.DS.'app_octopus_labs_Imagingresults.php');
	break;
	// 25 SEPT 2021
	case 'setimagingpricing':
		include(ROOTDOC.DS.'app_octopus_labs_Imagingrequest_setprice.php');
	break;
	// 25 SEPT 2021
	case 'imagingtestrequestdetails':
		include(ROOTDOC.DS.'app_octopus_labs_imagingrequest_testdetails.php');
	break;
	// 25 SEPT 2021
	case 'imagingrequestdetails':
		include(ROOTDOC.DS.'app_octopus_labs_imagingrequest_details.php');
	break;
	// 25 SEPT 2021
	case 'imagingrequests':
		include(ROOTDOC.DS.'app_octopus_labs_imagingrequest.php');
	break;
	// 20 SEPT 2021 JOSEPH ADORBOE
	case 'managerequisition':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_requisition.php');
	break;
	// 20 SEPT 2021 JOSEPH ADORBOE 
	case 'manageitems':
		include(ROOTDOC.DS.'app_octopus_pharmacy_inventory_manageitem.php');
	break;
	// 16 SEPT 2021
	case 'consultationimagingpatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_investigation_imaging.php');
	break;
	// 15 SEPT 2021
	case 'consultationimaging':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation_imaging.php');
	break;
	// 09 SEPT 2021
	case 'patientconsultationrheumatology':
		include(ROOTDOC.DS.'app_octopus_consultations_rheumatology.php');
	break;
	
	// 23 AUG 2021
	case 'pharmacyreportpage':
		include(ROOTDOC.DS.'app_octopus_pharmacy_report.php');
	break;
	// 23 AUG 2021
	case 'pharmacyreports':
		include(ROOTDOC.DS.'app_octopus_pharmacy_reportfilter.php');
	break;
	// 20 AUG 2021
	case 'devicepharmacypricing':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_pricing.php');
	break;
	// 20 AUG 2021
	case 'devicespharmacystocklist':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_stocklist.php');
	break;
	// 20 AUG 2021
	case 'devicestockadjustments':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_stockadjustment.php');
	break;
	// 20 AUG 2021
	case 'newdevices':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_newdevices.php');
	break;
	// 20 AUG 2021
	case 'devicelowstocks':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_lowstocks.php');
	break;
	// 14 AUG 2021
	case 'deviceprescriptionarchive':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_archive.php');
	break;
	// 14 AUG 2021
	case 'devicesarchivefilter':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_archivefilter.php');
	break;
	// 04 AUG 2021
	case 'consultationpatientobgyopd':
		include(ROOTDOC.DS.'app_octopus_consultations_obsgyne_opd.php');
	break;
	// 04 AUG 2021
	case 'consultationpatientobgyhistory':
		include(ROOTDOC.DS.'app_octopus_consultations_obsgyne_history.php');
	break;
	// 04 AUGUST 2021
	case 'consultationobgydetails':
		include(ROOTDOC.DS.'app_octopus_consultations_obsgyne_details.php');
	break;
	// 04 AUG 2021
	case 'patientobsgyne':
		include(ROOTDOC.DS.'app_octopus_consultations_obsgyne.php');
	break;
	// 31 JULY 2021
	case 'walkindevicesnonpatients':
		include(ROOTDOC.DS.'app_octopus_walk_in_devices_nonpatient.php');
	break;
	// 31 JULY 2021
	case 'walkinpharmacynonpatients':
		include(ROOTDOC.DS.'app_octopus_walk_in_pharmacy_nonpatient.php');
	break;
	
	// 30 JULY 2021
	case 'walkinnonpatientfilter':
		include(ROOTDOC.DS.'app_octopus_walk_in_nonpatient_filter.php');
	break;
	// 30 JULY 2021
	case 'walkindevices':
		include(ROOTDOC.DS.'app_octopus_walk_in_devices.php');
	break;
		
	// 26 JULY 2021
	case 'deviceprescriptionsendout':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_sendout.php');
	break;
	// 26 JULY 2021
	case 'medicaldevicesendoutfilter':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_sendout_filter.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientactionpatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_action.php');
	break;
	// 20 JULY 2021
	case 'patientfoldertreatment':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_treatment.php');
	break;
	// 20 JULY 2021
	case 'consultationtreatmentplanpatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_treatmentplan.php');
	break;
	// // 20 JULY 2021
	// case 'consultationpatientprescriptionpatientfolder':
	// 	include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_prescriptions.php');
	// break;
	// 20 JULY 2021
	case 'consultationpatientdiagnosispatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_diagnosis.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientinvestigationpatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_investigation.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientphysicalexamspatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_physicalexams.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientcomplainspatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_complains.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientlastvisitpatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_lastvisit.php');
	break;
	// 20 JULY 2021
	case 'consultationpatientlegacypatientfolder':
		include(ROOTDOC.DS.'app_octopus_consultations_patientfolder_legacy.php');
	break;
	
	// 16 JULY 2021
	case 'procedurereports':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_reports.php');
	break;
	// 16 JULY 2021
	case 'procedurerequestdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures_details.php');
	break;
	// 16 JULY 2021
	case 'manageprocedure':
		include(ROOTDOC.DS.'app_octopus_nurse_procedures.php');
	break;
	// 10 JULY 2021
	case 'nursepatientfolderdetailsallvisit':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfolder_visitdetails_all.php');
	break;
	// 10 JULY 2021
	case 'nursepatientfolderdetailsvisit':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfolder_visitdetails.php');
	break;
	// 10 JULY 2021
	case 'nursepatientfolderdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfolder_details.php');
	break;
	// 10 JULY 2021
	case 'nursepatientfolder':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfolder.php');
	break;
	// 10 JULY 2021
	case 'nursepatientfolderfilter':
		include(ROOTDOC.DS.'app_octopus_nurse_patientfolder_filter.php');
	break;
	
	
	
	
	
	
	
	// 29 JUNE 2021
	case 'setdevicepricing':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_setpricing.php');
	break;
	// 28 JUNE 2021
	case 'devicepresrequestdetails':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_details_page.php');
	break;
	// 28 JUNE 2021
	case 'prescriptiondevicerequestdetails':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices_details.php');
	break;
	// 27 JUNE 2021
	case 'manageprescribedevices':
		include(ROOTDOC.DS.'app_octopus_pharamcy_devices.php');
	break;
	
	// 20 JUNE 2021
	case 'labssendout':
		include(ROOTDOC.DS.'app_octopus_labs_sendout.php');
	break;
	// 20 JUNE 2021
	case 'labrequestsendoutfilter':
		include(ROOTDOC.DS.'app_octopus_labs_sendout_filter.php');
	break;
	// 13 JUNE 2021
	case 'prescriptionsendout':
		include(ROOTDOC.DS.'app_octopus_pharmacy_sendout.php');
	break;
	// 15 JUNE 2021
	case 'prescriptionsendoutfilter':
		include(ROOTDOC.DS.'app_octopus_pharmacy_sendout_filter.php');
	break;
	// 15 JUNE 2021
	case 'sendoutpharmacy':
		include(ROOTDOC.DS.'app_octopus_pharamcy_prescriptions_sendout.php');
	break;
	// 13 JUNE 2021
	case 'managepharmacytreatmentplan':
		include(ROOTDOC.DS.'app_octopus_pharmacy_treatmentplan.php');
	break;
	// 13 JUNE 2021
	case 'prescriptionarchive':
		include(ROOTDOC.DS.'app_octopus_pharmacy_archive.php');
	break;
	// 13 JUNE 2021
	case 'prescriptionarchievefilter':
		include(ROOTDOC.DS.'app_octopus_pharmacy_archivefilter.php');
	break;
	// 13 JUNE 2021
	case 'manageexpiry':
		include(ROOTDOC.DS.'app_octopus_pharmacy_expiry.php');
	break;
	// 04 JUNE 2021
	case 'stockadjustments':
		include(ROOTDOC.DS.'app_octopus_pharmacy_stockadjustment.php');
	break;
	// 03 JUNE 2021
	case 'restocksdetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_restocks_details.php');
	break;
	// 03 JUNE 2021
	case 'restocks':
		include(ROOTDOC.DS.'app_octopus_pharmacy_restocks.php');
	break;
	// 03 JUNE 2021
	case 'setupsuppliers':
		include(ROOTDOC.DS.'app_octopus_st_suppliers.php');
	break;
	// 03 JUNE 2021
	case 'pharmacypricing':
		include(ROOTDOC.DS.'app_octopus_pharmacy_pricing.php');
	break;
	// 03 JUNE 2021
	case 'pharmacystocklist':
		include(ROOTDOC.DS.'app_octopus_pharmacy_stocklist.php');
	break;
	// 01 JUNE 2021
	case 'newmedications':
		include(ROOTDOC.DS.'app_octopus_pharmacy_newmedications.php');
	break;
	// 02 JUNE 2021
	case 'lowstocks':
		include(ROOTDOC.DS.'app_octopus_pharmacy_lowstocks.php');
	break;
	// 01 JUNE 2021
	case 'labsresultsdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labsresults_details.php');
	break;
	// 01 JUNE 2021
	case 'pendingresults':
		include(ROOTDOC.DS.'app_octopus_labs_labsresults.php');
	break;
	// 29 MAY 2021
	case 'consultationdevices':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdevices.php');
	break;
	// 28 MAY 2021
	case 'managetreatmentplan':
		include(ROOTDOC.DS.'app_octopus_consultations_patienttreatmentplan_manage.php');
	break;
	// 27 MAY 2021
	case 'consultationtreatmentplan':
		include(ROOTDOC.DS.'app_octopus_consultations_patienttreatmentplan.php');
	break;
	// 25 MAY 2021
	case 'consultationpatientlegacy':
		include(ROOTDOC.DS.'app_octopus_consultations_legacy.php');
	break;
	// 23 MAY 2021
	case 'attached':
		include(ROOTDOC.DS.'app_octopus_nurse_attached.php');
	break;
	
	
	// 15 MAY 2021
	case 'setupprocedure':
		include(ROOTDOC.DS.'app_octopus_st_procedure.php');
	break;
	// 14 MAY 2021
	case 'setuplabs':
		include(ROOTDOC.DS.'app_octopus_st_labs.php');
	break;
	// 13 MAY 2021
	case 'setupdevices':
		include(ROOTDOC.DS.'app_octopus_st_devices.php');
	break;
	// 13 MAY 2021
	case 'setupmedications':
		include(ROOTDOC.DS.'app_octopus_st_medication.php');
	break;
	// 13 MAY 2021
	case 'servicebasketdetails':
		include(ROOTDOC.DS.'app_octopus_nurse_servicebasket_details.php');
	break;
	// 13 MAY 2021
	case 'patientservicebasket':
		include(ROOTDOC.DS.'app_octopus_nurse_servicebasket.php');
	break;
	// 13 MAY 2021
	case 'patientconsultationorthopedic':
		include(ROOTDOC.DS.'app_octopus_consultations_orthopedic.php');
	break;
	// 13 MAY 2021
	case 'patientconsultationgp':
		include(ROOTDOC.DS.'app_octopus_consultations_gp.php');
	break;
	
	// 25 APR 2021
	case 'presrequestdetails':
		include(ROOTDOC.DS.'app_octopus_pharmacy_prescriptions_details_prescription.php');
	break;
	// 23 APR 2021
	case 'setprescriptionpricing':
		include(ROOTDOC.DS.'app_octopus_pharamcy_prescriptions_setpricing.php');
	break;
	// 23 APR 2021
	case 'prescriptionrequestdetails':
		include(ROOTDOC.DS.'app_octopus_pharamcy_prescriptions_details.php');
	break;
	// 23 APR 2021
	case 'manageprescriptions':
		include(ROOTDOC.DS.'app_octopus_pharamcy_prescriptions.php');
	break;
	
	
	// 12 APR 2021
	case 'patientlabsresults':		
		include(ROOTDOC.DS.'app_octopus_consultations_patientresults.php');
	break;
	// 8 APR 2021
	case 'labpricing':
		include(ROOTDOC.DS.'app_octopus_labs_pricing.php');
	break;
	// 8 APR 2021
	case 'testdetails':
		include(ROOTDOC.DS.'app_octopus_labs_archive_testdetails.php');
	break;	
	// 8 APR 2021
	case 'archieve':
		include(ROOTDOC.DS.'app_octopus_labs_archive.php');
	break;	
	// 8 APR 2021
	case 'archievefilter':
		include(ROOTDOC.DS.'app_octopus_labs_archive_searchfilter.php');
	break;	
	// 8 APR 2021
	case 'labsarchivefilter':
		include(ROOTDOC.DS.'app_octopus_labs_archive_searchfilter.php');
	break;	
	// 8 APR 2021
	case 'sampleregistry':
		include(ROOTDOC.DS.'app_octopus_labs_sample.php');
	break;	
	// 8 APR 2021
	case 'samplesearchfilter':
		include(ROOTDOC.DS.'app_octopus_labs_sample_searchfilter.php');
	break;		
	//05 APR 2021
	case 'labstestrequestdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest_testdetails.php');
	break;	
	// 04 APR 2021 
	case 'setlabspricing':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest_setprice.php');
	break;	
	// 03 APR 2021
	case 'labsrequestdetails':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest_details.php');
	break;	
	// 31 MAR 2021
	case 'patientoverthecounter':
		include(ROOTDOC.DS.'app_octopus_patients_overthecounter.php');
	break;	
	// 31 MAR 2021
	case 'labsrequests':
		include(ROOTDOC.DS.'app_octopus_labs_labsrequest.php');
	break;	
	// 30 MAR 2021
	case 'labresulttemplate':
		include(ROOTDOC.DS.'app_octopus_labs_resulttemplate.php');
	break;	
	// 30 MAR 2021
	case 'labtests':
		include(ROOTDOC.DS.'app_octopus_labs_labtests.php');
	break;		
	// 29 MAR 2021
	case 'labdispline':
		include(ROOTDOC.DS.'app_octopus_labs_discpline.php');
	break;
	// 29 MAR 2021
	case 'labsspecimen':
		include(ROOTDOC.DS.'app_octopus_labs_specimen.php');
	break;
	// 27 MAR 2021
	case 'consultationpatientaction':
		include(ROOTDOC.DS.'app_octopus_consultations_patientaction.php');
	break;
	// 27 MAR 2021
	case 'consultationpatientinvestigation':
		include(ROOTDOC.DS.'app_octopus_consultations_patientinvestigation.php');
	break;
	// 27 MAR 2021
	case 'consultationpatientprescription':
		include(ROOTDOC.DS.'app_octopus_consultations_patientprescriptions.php');
	break;
	// 26 MAR 2021
	case 'consultationpatientlastvisit':
		include(ROOTDOC.DS.'app_octopus_consultations_patientlastvisit.php');
	break;
	// 26 MAR 2021
	case 'consultationpatientsummary':
		include(ROOTDOC.DS.'app_octopus_consultations_patientsummary.php');
	break;
	// 25 MAR 2021
	case 'consultationpatienttreatment':
		include(ROOTDOC.DS.'app_octopus_consultations_patienttreatment.php');
	break;
	// 25 MAR 2021
	case 'consultationpatientdiagnosis':
		include(ROOTDOC.DS.'app_octopus_consultations_patientdiagnosis.php');
	break;
	// 25 MAR 2021
	case 'consultationpatientphysicalexams':
		include(ROOTDOC.DS.'app_octopus_consultations_patientphysicalexams.php');
	break;
	// 24 MAR 2021
	case 'consultationpatientcomplains':
		include(ROOTDOC.DS.'app_octopus_consultations_patientcomplains.php');
	break;
	
	// 17 MAR 2021
	case 'consultationdetails':
		include(ROOTDOC.DS.'app_octopus_consultations_details.php');
	break;
	
	// 20 FEB 2021
	case 'patientconsultation':
		include(ROOTDOC.DS.'app_octopus_consultations.php');
	break;
	// 17 FEB 2021
	case 'nursepatientqueue':
		include(ROOTDOC.DS.'app_octopus_nurse_patientqueue.php');
	break;
	
	
	// 27 JAN 2021
	case 'medicationanddevices':
		include(ROOTDOC.DS.'app_octopus_st_medicationanddevices.php');
	break;
	// 27 JAN 2021
	case 'manageunits':
		include(ROOTDOC.DS.'app_octopus_st_units.php');
	break;
	// 27 JAN 2021
	case 'dosageform':
		include(ROOTDOC.DS.'app_octopus_st_dosageform.php');
	break;		
	
	// 4 SEPT 2020
	case 'changepassword':
		include(ROOTDOC.DS.'app_octopus_changepassword.php');
	break;
	
	

		
	// 4 SEPT 2020
	case 'home':
		include(HOMEFILE);
	break;	
	// 4 SEPT 2020
	case 'login':
		include(LOGINFOLDER.DS.'app_octopus_login.php');
	break;
	// 4 SEPT 2020
	case 'logout':
		include(LOGINFOLDER.DS.'app_octopus_logout.php');
	break;
	// 4 SEPT 2020
	default:
		include(HOMEFILE);
	break;	
}
}#endSwitch 2741