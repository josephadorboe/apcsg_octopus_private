<div class="tab-menu-heading siderbar-tabs border-0  p-0">
	<div class="tabs-menu ">
		<!-- Tabs -->														
		<ul class="nav panel-tabs">								
			<li><a href="#index1a" <?php if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
			<li><a href="#index1b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
			<!-- <li><a href="#index1c" <?php  //if($sub == 3){ ?> class="active" <?php //} ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>							
			<li><a href="#index1d" <?php //if($sub == 4){ ?> class="active" <?php //} ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	 -->
		</ul>		
	</div> 
</div>
<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
	<div class="tab-content">					
			<div class="tab-pane border-top <?php if($sub == 1){ ?> active <?php } ?>" id="index1a">
				<ul class="side-menu toggle-menu">
					<li>
						<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>
					<li class = 'active' >
					<a class="side-menu__item" href="records__requestservicefilter"><i class="side-menu__icon typcn typcn-arrow-move-outline "></i><span class="side-menu__label">Request Service</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="records__patientregistration"><i class="side-menu__icon typcn typcn-location-outline"></i><span class="side-menu__label">Patient Registration</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="genstore__managedispensepoint"><i class="side-menu__icon typcn typcn-export"></i><span class="side-menu__label">Dispense point </span><?php   $generalitemsold = $saletable->getsalepaidcounts($instcode); if($generalitemsold > '0'){ ?> <span class="badge badge-danger"><?php echo $generalitemsold ; ?></span> <?php } ?></a>
					</li>
					<li>
						<a class="side-menu__item" href="genstore__managesalepointstransfer"><i class="side-menu__icon typcn typcn-export"></i><span class="side-menu__label">Item Transfered</span><?php $generalitemtransfer = $stockadjustmenttable->getgeneralitemtransfercounts($instcode); if($generalitemtransfer > '0'){ ?> <span class="badge badge-danger"><?php echo $generalitemtransfer ; ?></span> <?php } ?></a>
					</li>									
					<li>
						<a class="side-menu__item" href="records__sendbackservices"><i class="side-menu__icon typcn typcn-feather"></i><span class="side-menu__label">Send Back Services</span><?php if($sendbackservicecount > '0'){ ?> <span class="badge badge-primary"><?php echo $sendbackservicecount ; ?></span> <?php } ?></a>
					</li>										
					<li>
						<a class="side-menu__item" href="records__recordspatientfolderfilter"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Patient Folder</span></a>
					</li>	
					<!-- <li>
						<a class="side-menu__item" href="records__patientattacheresultsfilter"><i class="side-menu__icon typcn typcn-heart"></i><span class="side-menu__label">Attach Results </span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="records__manageappointment"><i class="side-menu__icon typcn typcn-cog"></i><span class="side-menu__label">Manage Appointment</span></a>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="records__manageappointmentslots"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Appointment Times </span></a>
					</li>									 -->
					<li>
						<a class="side-menu__item" href="review__patientreviewbookings"><i class="side-menu__icon typcn typcn-download"></i><span class="side-menu__label">Review / Referal / Followup</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="medicalreport__medicalreport"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Medical Reports</span></a>
					</li>									
					<li>
						<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
					</li>													
				</ul>
			</div>
			<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?> " id="index1b" >							
				<ul class="side-menu toggle-menu">
					<li>
						<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
					</li>																		
					<li>
						<a class="side-menu__item" href="records__patientrecordsfilter"><i class="side-menu__icon typcn typcn-document-text"></i><span class="side-menu__label">Patient Records</span></a>
					</li>									
					<li>
						<a class="side-menu__item" href="records__recordconsultations?1"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Shift Consultations</span></a>
					</li>
					<!-- <li>
						<a class="side-menu__item" href="records__patientschemefilter"><i class="side-menu__icon typcn typcn-dropbox"></i><span class="side-menu__label">Payment Scheme</span></a>
					</li> -->
					<li>
						<a class="side-menu__item" href="records__manageactiveservices"><i class="side-menu__icon typcn typcn-feather"></i><span class="side-menu__label">Manage Services</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="promotion__managepromotionsubscription"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label"> Promotion Subscription</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
					</li>
					<!-- 
					<li>
						<a class="side-menu__item" href="records__legacypatients"><i class="side-menu__icon typcn-contacts"></i><span class="side-menu__label">Legacy Patients</span></a>
					</li>	 
					<li>
						<a class="side-menu__item" href="records__patientsearchfilter"><i class="side-menu__icon typcn typcn-document-text"></i><span class="side-menu__label">Patient Search</span></a>
					</li>
					<li>
						<a class="side-menu__item" href="records__patientgroups"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Groups</span></a>
					</li>
					
					-->		
					
					<li>
						<a class="side-menu__item" href="patient__deceasedpatient"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Deceased Patients</span></a>
					</li>									
				</ul>							
		</div>
		<!--
		<div class="tab-pane border-top <?php  // if($sub == 3){ ?> active  <?php  // } ?> " id="index1c">
			<ul class="side-menu toggle-menu">
				<li>
					<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>									
				<li>
					<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
				</li>
													
			</ul>
		</div>
		<div class="tab-pane border-top <?php  // if($sub == 4){ ?> active  <?php  // } ?> " id="index1d">
			<ul class="side-menu toggle-menu">
				<li>
					<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
				</li>									
				
				<li>
					<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
				</li>									
			</ul>
		</div> -->	
		</div>					
	</div>
				