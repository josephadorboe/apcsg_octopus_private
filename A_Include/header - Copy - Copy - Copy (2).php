<?php	
	//REQUIRE_ONCE (INTFILE);
	$pendingprocedurescount = $msql->getpendingprocedurereport($currentusercode,$instcode);
	if($currentuserlevel == 1 || $currentuserlevel == 4 || $currentuserlevel == 5 || $currentuserlevel== 38){ 
		$fp =  $patientnursefollowuptable->getnursefollowupscount($day,$instcode); 
		$newreview = $patientreviewtable->getnewreviewfollowupscount($day,$instcode);
		$newreferals = $patientreferaltable->getcounttodayreferals($day,$instcode);
		$pendingprocedurescount = $msql->getpendingprocedurereport($currentusercode,$instcode);
	} 
	if($currentuserlevel == 9 ){ 
		$pendingprocedurescount = $msql->getpendingprocedurereport($currentusercode,$instcode);
	} 
	if($currentuserlevel == 7 || $currentuserlevel == 38 || $currentuserlevel == 9){  
		$pharmacycount = $lov->getpharmacycounts($theexpiryday,$instcode); 
		$pc = explode('@' , $pharmacycount);
		$prescriptioncount = $pc[0];
		$devicecount = $pc[1];
		$procedurecount = $pc[2];
		$requisitioncount = $pc[3];
		$transfercount = $pc[4];
		$expirycount = $pc[5];
	}else{
		$transfercount=$expirycount='0';
	}
	if($currentuserlevel == 2 || $currentuserlevel == 3){  
		$billingcashiercount = $lov->getbillingcashiercount($instcode,$day,$privateinsurancecode,$nationalinsurancecode,$partnercompaniescode,$cashpaymentmethodcode,$mobilemoneypaymentmethodcode,$chequescode,$creditcode,$prepaidcode); 
		$pc = explode('@' , $billingcashiercount);
		$insurancecount = $pc[0];
		$noninsurancecount = $pc[1];
		$promotioncount = $pc[2];												
	}else{
		$insurancecount=$noninsurancecount=$promotioncount ='0';
	}
	if($currentuserlevel == 1 ){  
		$recordscount = $lov->getrecordscounts($instcode,$day,$currentshiftcode); 
		$pc = explode('@' , $recordscount);
		$sendbackservicecount = $pc[0];		
	}else{
		$sendbackservicecount='0';
	}		
?>
<!doctype html>
<html lang="en" dir="ltr">	
<!-- Mirrored from laravel.spruko.com/hogo/Leftmenu-toggle-LightSidebar/index by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Jul 2020 18:08:19 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Octopus Health management information system " name="description">		
		<meta content="Octopus EHRS" name="author">		
		<meta name="keywords" content="octopus, HMIS, HMS"/>
		<!-- Favicon -->
		<script src="assets/js/jquery.js"> </script>
		<link rel='stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' />
		<!--
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
-->
		<link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/brand/favicon.ico" />
<!-- Title -->
 <?php //$versiontype = $engine->getcurrentversion(); ?>
<title>THE OCTOPUS - <?php echo $versiontype; ?> - <?php echo $pagename; ?></title>
<!--Bootstrap.min css-->
<!-- Jquery js-->
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>	
<!--Bootstrap.min css-->
<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
<!-- Dashboard css -->
<link href="assets/css/style.css" rel="stylesheet" />
<!-- P-scroll bar css -->
<link href="assets/plugins/p-scroll/perfect-scrollbar.css" rel="stylesheet" />
<!-- Custom scroll bar css-->
<link href="assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
<!-- Sidemenu css -->
<link href="assets/plugins/toggle-sidebar/sidemenu.css" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<!-- Rightsidebar css -->
<link href="assets/plugins/sidebar/sidebar.css" rel="stylesheet">
<!-- Sidebar Accordions css -->
<link href="assets/plugins/accordion1/css/easy-responsive-tabs.css" rel="stylesheet">
<!---Font icons css-->
<link href="assets/plugins/iconfonts/plugin.css" rel="stylesheet" />
<link href="assets/plugins/iconfonts/icons.css" rel="stylesheet" />
<link  href="assets/fonts/fonts/font-awesome.min.css" rel="stylesheet">

<!---Switcher css-->
<link href="assets/switcher/css/switcher.css" rel="stylesheet" />
<link href="assets/switcher/demo.css" rel="stylesheet" />

<!--Select2 css -->
<link href="assets/plugins/select2/select2.min.css" rel="stylesheet" />
<!-- Time picker css-->
<link href="assets/plugins/time-picker/jquery.timepicker.css" rel="stylesheet" />
<!-- Date Picker css-->
<link href="assets/plugins/date-picker/spectrum.css" rel="stylesheet" />
<!-- File Uploads css-->
<link href="assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
<!--Mutipleselect css-->
<link rel="stylesheet" href="assets/plugins/multipleselect/multiple-select.css">
<!-- Owl Theme css-->
<link href="assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
<!-- Morris  Charts css-->
<link href="assets/plugins/morris/morris.css" rel="stylesheet" />
<!-- Data table css -->
<link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />	
<!---Sweetalert Css-->
<link href="assets/plugins/sweet-alert/jquery.sweet-modal.min.css" rel="stylesheet" />
<link href="assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />
<!-- File Uploads css-->
<link href="assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />
<!---Switcher css-->
<link href="assets/switcher/css/switcher.css" rel="stylesheet" />
<link href="assets/switcher/demo.css" rel="stylesheet" />
	</head>

	<body class="app sidebar-mini rtl">
	<?php REQUIRE_ONCE (SUBMENUFILE); ?>		
		<!-- Switcher -->
		<div class="switcher-wrapper">
			<div class="demo_changer">
				<div class="demo-icon bg_dark">
					<i class="fa fa-cog fa-spin text_primary"></i>
				</div>
				<div class="form_holder sidebar-right1">
					<div class="row">
					<!--
						<div class="predefined_styles">
							<h4>Versions</h4>
							<div class="swichermainleft p-4">
								<div class="pl-3 pr-3">
									<a class="btn btn-primary btn-block" href="index.html">LTR-Version</a> 
									<a class="btn btn-secondary btn-block" href="https://laravel.spruko.com/hogo/Leftmenu-toggle-LightSidebar-rtl/index">RTL-Version</a>
								</div>
							</div>
							<div class="swichermainleft border-top text-center p-4">
								<div class="p-3">
									<a class="btn btn-danger btn-block mt-0" href="http://laravel.spruko.com/hogo/">View Demo</a> 
									<a class="btn btn-warning btn-block" href="#">Buy Now</a> 
									<a class="btn btn-info btn-block" href="https://themeforest.net/user/sprukosoft/portfolio">Our Portfolio</a>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
		
		<!-- End Switcher -->
		
		<!--Global-Loader-->
		<div id="global-loader">		
			<img src="assets/images/icons/loader.svg" alt="loader">			
		</div>
		
		<div class="page">
			<div class="page-main">
				<!--app-header-->
				<div class="app-header header d-flex">
					<div class="container-fluid">
						<div class="d-flex">
						    <a class="header-brand" href="home">
							OCTOPUS EHRS 
								<!--
									<img src="assets/images/brand/logo.png" class="header-brand-img main-logo" alt="Hogo logo">
									<img src="assets/images/brand/icon.png" class="header-brand-img icon-logo" alt="Hogo logo">
								-->
							</a><!-- logo-->
							<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
							<a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a><!-- search icon -->
							<div class="header-form">						
								<form class="form-inline">
									<div class="search-element mr-3">
										<br />										
										<B><h3><?php echo $currentuserinst; ?></h3></B> 																	
									</div>									
								</form><!-- search-bar -->								
							</div>
							
							
							
									<!-- <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fe fe-grid mr-2"></i>UI Kit <i class="fa fa-angle-down ml-1"></i>
									</a> -->
									<!-- <ul class="dropdown-menu mega-dropdown-menu container row p-5">
										<li>
											<div class="row">
												<div class="col-md-4">
													<div class="">
														<div class="card-body p-0 relative">
															<div class="arrow-ribbon">Comming Events</div>
															<img class="" alt="img" src="assets/images/photos/32.jpg">
															<div class="btn-absolute">
																<a class="btn btn-primary btn-pill btn-sm" href="#">More info</a>
																<span id="timer-countercallback1" class="h5 text-white float-right mb-0 mt-1"></span>
															</div>
														</div>
													</div>
												</div>
												<div class="col-2">
													<h4  class="mb-3">Pages</h4>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Client Support</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> About Us</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Calendar</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Add New Pages</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Login Pages</a>
												</div>
												<div class="col-2">
													<h4  class="mb-3">Pages</h4>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Documentation</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Multi Pages</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Edit Profile</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Mail Settings</a>
													<a class="dropdown-item pl-0 pr-0" href="#"><i class="fa fa-angle-double-right text-muted mr-1"></i> Default Setting</a>
												</div>
												<div class="col-md-4">
													<h4  class="mb-3">Current projects</h4>
													<div class="overflow-hidden">
														<div class="card-body p-0">
															<div class="list-group list-lg-group list-group-flush">
																<a class="list-group-item list-group-item-action overflow-hidden pl-0 pr-0 pb-4" href="#">
																	<div class="d-flex">
																		<img class="avatar-xl br-7 mr-3" src="assets/images/photos/33.jpg" alt="Image description">
																		<div class="media-body">
																			<div class="align-items-center">
																				<h5 class="mb-0">
																					Wordpress project
																				</h5>
																			</div>
																			<div class="mb-2 mt-2">
																				<p class="mb-2">Project Status<span class="float-right text-default">85%</span></p>
																				<div class="progress progress-sm mb-0 h-1">
																					<div class="progress-bar progress-bar-striped progress-bar-animated bg-success w-85"></div>
																				</div>
																			</div>
																		</div>
																	</div>
																</a>
																<a class="list-group-item list-group-item-action overflow-hidden pl-0 pr-0 pt-4" href="#">
																	<div class="d-flex">
																		<img class="avatar-xl br-7 mr-3" src="assets/images/photos/34.jpg" alt="Image description">
																		<div class="media-body">
																			<div class="align-items-center">
																				<h5 class="mb-0">
																					Html project
																				</h5>
																			</div>
																			<div class="mb-2 mt-2">
																				<p class="mb-2">Project Status<span class="float-right text-default">75%</span></p>
																				<div class="progress progress-sm mb-0 h-1">
																					<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-75"></div>
																				</div>
																			</div>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul></li>
							</ul> -->
								
							<!-- <ul class="nav header-nav">
								<li class="nav-item dropdown header-option m-2">
									<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="fe fe-settings mr-2"></i>Settings
									</a>
									<div class="dropdown-menu dropdown-menu-left">
										<a class="dropdown-item" href="#">Option 1</a>
										<a class="dropdown-item" href="#">Option 2</a>
										<a class="dropdown-item" href="#">Option 3</a>
										<a class="dropdown-item" href="#">Option 4</a>
										<a class="dropdown-item" href="#">Option 5</a>

									</div>
								</li>
							</ul> -->
								
							
							<div class="d-flex order-lg-2 ml-auto header-rightmenu">
							<?php if($currentuserlevel == 1 || $currentuserlevel == 4 || $currentuserlevel == 5 || $currentuserlevel== 38){ ?>
							<ul class="nav navbar-nav horizontal-nav header-nav">
								<li class="mega-dropdown nav-item">
									<?php if($fp > '0'){?>
								<a href="nursefollowuplist" target="_blank">
									<div class="spinner-grow text-danger m-12" role="status">
										<span class="sr-only">Loading...</span>
										<span class="alert-danger"> followup Due </span>
									</div>
								</a>  	
								<?php } ?>	
								</li>
							</ul>				
							
								<?php  if($newreview > '0'){ ?>	
								<div class="col-md-3 mt-2 mb-2">									
									<a href="patientreviewbookings">
									<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Followup Today" data-content="Followup Today">
									<?php echo $newreview; ?> Followup Today
									</button>
									</a>
								</div>
								<?php } ?>
								<?php  if($newreferals > '0'){ ?>			
								<div class="col-md-3 mt-2 mb-2">
									<a href="patientreferal">
									<button type="button" class="btn btn-block btn-primary" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="New Referals" data-content="New Referals">
									<?php echo $newreferals; ?> New Referals 
									</button>
									</a>
								</div>
								<?php } }?>
								<?php  if($pendingprocedurescount > '0'){ ?>			
								<div class="col-md-3 mt-2 mb-2">
									<a href="manageprocedure">
									<button type="button" class="btn btn-block btn-warning" data-container="body" data-toggle="popover" data-popover-color="popdanger" data-placement="bottom" title="Attached Results" data-content=" Procedure Report ">
									<?php echo $pendingprocedurescount; ?> Procedure Reports 
									</button>
									</a>
								</div>
								<?php } ?>
								<?php  
									
									
								?>								
									<div class="dropdown">
										<?php if($transfercount > 0 ){ ?>
											<a href="managestocktransfers" title="New Stock Transfer">
											<button type="button" class="btn btn-warning mt-1 mb-1 mr-3">
												<span> <?php echo $transfercount; ?> New Transfer</span>										
											</button>
											</a>	
										<?php } ?>
										
										<?php if($expirycount > 0 ){ ?>
											<a href="manageexpiry" title="New Stock Transfer">
											<button type="button" class="btn btn-danger mt-1 mb-1 mr-3">
												<span> <?php echo $expirycount; ?> Expire Stocks </span>										
											</button>
											</a>	
										<?php } ?>
									</div>
								
								<!-- full-screen -->
								<div class="dropdown header-notify">
									<br />
								<h5> <?php  if($currentuserlevel !== '50'){ ?><?php  echo $currentshift; ?> - <font color =' red'><?php echo $versiontype ; ?>	</font> <br />-  Shift End:<?php echo $currentshiftend ; ?>00 Hours	<?php } ?></h5>

								<!--
									<a class="nav-link icon" data-toggle="dropdown" aria-expanded="false" role="button">
										<i class="fe fe-bell "></i>
										<span class="pulse bg-success"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<a href="#" class="dropdown-item text-center">4 New Notifications</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-green">
												<i class="fe fe-mail"></i>
											</div>
											<div>
												<strong>Message Sent.</strong>
												<div class="small text-muted">12 mins ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-pink">
												<i class="fe fe-shopping-cart"></i>
											</div>
											<div>
												<strong>Order Placed</strong>
												<div class="small text-muted">2  hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-blue">
												<i class="fe fe-calendar"></i>
											</div>
											<div>
												<strong> Event Started</strong>
												<div class="small text-muted">1  hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-orange">
												<i class="fe fe-monitor"></i>
											</div>
											<div>
												<strong>Your Admin Lanuch</strong>
												<div class="small text-muted">2  days ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all Notifications</a>
									</div>
-->
								</div><!-- notifications -->

								<!--
								<div class="dropdown header-user">
									<a class="nav-link leading-none siderbar-link"  data-toggle="sidebar-right" data-target=".sidebar-right">
										<span class="mr-3 d-none d-lg-block ">
											<span class="text-gray-white"><span class="ml-2"><?php // echo $currentuserlevelname; ?></span></span>
										</span>										
										<span class="avatar avatar-md brround"><img src="assets/images/users/female/33.png" alt="Profile-img" class="avatar avatar-md brround"></span>								
									</a>								
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">								
										<div class="header-user text-center mt-4 pb-4">
											<span class="avatar avatar-xxl brround"><img src="assets/images/users/female/33.png" alt="Profile-img" class="avatar avatar-xxl brround"></span>
											<a href="#" class="dropdown-item text-center font-weight-semibold user h3 mb-0"><?php // echo $currentuserlevelname; ?></a>
											<small><?php //echo $currentuserlevel; ?></small>
										</div>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon mdi mdi-account-outline "></i> Spruko technologies
										</a>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon  mdi mdi-account-plus"></i> Add another Account
										</a>										
										<div class="card-body border-top">
											<div class="row">
												<div class="col-6 text-center">
													<a class="" href="#"><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
													<div>Inbox</div>
												</div>
												<div class="col-6 text-center">
													<a class="" href="#"><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
													<div>Sign out</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- profile -=->
								<div class="dropdown">
									<a  class="nav-link icon siderbar-link" data-toggle="sidebar-right" data-target=".sidebar-right">
										<i class="fe fe-more-horizontal"></i>
									</a>
								</div><!-- Right-siebar-->
							</div>
						</div>
					</div>
				</div>
<!--app-header end-->

		<!-- Sidebar menu-->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar toggle-sidebar">
					<div class="app-sidebar__user pb-0">						
						<!-- <div class="user-body">
							<span class="avatar avatar-xxl brround text-center cover-image" data-image-src="assets/images/users/female/33.png"></span>
						</div>						 -->
						<div class="user-info">
							<a href="home" class="ml-2"><span class="text-dark app-sidebar__user-name font-weight-semibold"><?php echo substr($currentuser, 0 ,20); ?></span></a>							
							<?php // echo $currentuserlevelname  ; ?>
							<!--
							<a href="admin__myschedule" title="My schedule"><i class="fa fa-envelope-open fs-17"></i> My Schedule</a>
							<br />
							<a href="admin__mypayslip" title="payslip"><i class="fa fa-address-book fs-17"></i> My Pay Slip</a>
							<br />
										-->
										<br />
										
							[ <?php echo $currentuserspec; ?> ]
										<br />
							<a href="changepassword" title="changepassword"><i class="fa fa-users fs-17"></i> Change Password</a>
							
							<br />
								<span class="text-muted app-sidebar__user-name text-sm"> <a href="logout" title="logout"><i class="fa fa-power-off fs-17"></i> Logout</a></span>
							</a>
						</div>
					</div>
					
					<div class="tab-menu-heading siderbar-tabs border-0  p-0">
						<div class="tabs-menu ">
							<!-- Tabs -->
							<?php if($currentuserlevel == 1){ ?>							
							<ul class="nav panel-tabs">								
								<li><a href="#index1a" <?php if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
								<li><a href="#index1b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
								<li><a href="#index1c" <?php  if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>							
								<li><a href="#index1d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
							</ul>
							<?php }else if($currentuserlevel == 2){ ?>
								<ul class="nav panel-tabs">
								<li><a href="#index2a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
								<li><a href="#index2c" <?php   if($sub == 3){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
									</ul>
							<?php }else if($currentuserlevel == 3){ ?>
								<ul class="nav panel-tabs">
									<li><a href="#index3a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<!--
									<li class=""><a href="#index3b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
									-->
									<li><a href="#index3c"  <?php  if($sub == 3 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
								</ul>
							<?php }else if($currentuserlevel == 4){ ?>
								
								<ul class="nav panel-tabs">
									<li><a href="#index4a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index4b" <?php  if($sub == 2){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
									<li><a href="#index4c" <?php   if($sub == 3){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
									<li><a href="#index4d" <?php   if($sub == 4){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>								
								</ul>
								
							<?php }else if($currentuserlevel == 5){ ?>
								<ul class="nav panel-tabs">
										<li><a href="#index5a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
										<?php if($useraccesslevel == '1' ){  ?>
										<li><a href="#index5b" <?php  if ($sub == 2) { ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
										<?php } ?>
										<li><a href="#index5c" <?php  if($sub == 3 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-adjust fs-17"></i></a></li>										
									<!--	<li><a href="#index5d" <?php   if($sub == 4){ ?> class="active" <?php  } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>	-->								
								</ul>
							<?php }else if($currentuserlevel == 6){ ?>
								<ul class="nav panel-tabs">
									<li><a href="#index6a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index6b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
									<li><a href="#index6c" <?php  if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
									<li><a href="#index6d" <?php  if($sub == 4){ ?> class="active"  <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
								</ul>									
							<?php }else if($currentuserlevel == 7){ ?>
								<ul class="nav panel-tabs">
									<li><a href="#index7a" <?php  if($sub == 1 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index7b" <?php  if($sub == 2 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
									<li><a href="#index7c" <?php  if($sub == 3 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>																		
									<li><a href="#index7d" <?php  if($sub == 4){ ?> class="active"  <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
								</ul>
							<?php }else if($currentuserlevel == 8 ){ ?>
								<ul class="nav panel-tabs">
									<li class=""><a href="#index8a" <?php if($sub == 1 ){ ?> class="active"  <?php  } ?>  data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index8b" <?php  if($sub == 2 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-envelope fs-17"></i></a></li>
									<li><a href="#index8c" <?php  if($sub == 3 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
									<li><a href="#index8d" <?php  if($sub == 4 ){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-power-off fs-17"></i></a></li>
								</ul>																	
							<?php }else if($currentuserlevel == 9 ){ ?>
								<ul class="nav panel-tabs">
									<li><a href="#index9a" <?php if($sub == 1){ ?> class="active"  <?php } ?>  data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index9b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-times fs-17"></i></a></li>
									<li><a href="#index9c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-envelope fs-17"></i></a></li>
								</ul>
							<?php }else if($currentuserlevel == 10){ ?>
								<ul class="nav panel-tabs">
										<li class=""><a href="#index10a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
										<li><a href="#index10d"  <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
										<!--
										<li><a href="#index2" data-toggle="tab"><i class="fa fa-envelope fs-17"></i></a></li>
										<li><a href="#index3" data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
										<li><a href="login.html" title="logout"><i class="fa fa-power-off fs-17"></i></a></li>
										-->
								</ul>	
							<?php }else if($currentuserlevel == 11){ ?>
								<ul class="nav panel-tabs">
									<li class=""><a href="#index11a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index11b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
									<li><a href="#index11c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
									<li><a href="#index11d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
								</ul>	
							<?php }else if($currentuserlevel == 12){ ?>
								<ul class="nav panel-tabs">
									<li class=""><a href="#index12a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
									<li><a href="#index12b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
									<li><a href="#index12c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
									<li><a href="#index12d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
								</ul>
							<?php }else if($currentuserlevel == 13){ ?>
							<ul class="nav panel-tabs">
								<li class=""><a href="#index13a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
								<li><a href="#index13b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
								<li><a href="#index13c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
								<li><a href="#index13d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
							</ul>
							<?php }else if($currentuserlevel == 14){ ?>
							<ul class="nav panel-tabs">
								<li class=""><a href="#index14a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
								<li><a href="#index14b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
								<li><a href="#index14c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
								<li><a href="#index14d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
							</ul>
							<?php }else if($currentuserlevel == 15){ ?>
							<ul class="nav panel-tabs">
								<li class=""><a href="#index15a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
								<li><a href="#index15b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
								<li><a href="#index15c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
								<li><a href="#index15d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
							</ul>								
							<?php }else if($currentuserlevel == 38 || $currentuserlevel == 37){ ?>
								<ul class="nav panel-tabs">
									<li class=""><a href="#index38a" <?php   if($sub == 1) { ?> class="active"  <?php  } ?>  data-toggle="tab"><i class="fa fa-briefcase"></i></a></li>
									<li><a href="#index38b" <?php if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-cubes"></i></a></li>
									<li><a href="#index38c" <?php if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bank"></i></a></li>
									<li><a href="#index38d" <?php if($sub == 4){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-bars"></i></a></li>	
									</ul>								
							<?php }else if($currentuserlevel == 39){ ?>
								<ul class="nav panel-tabs">
										<li class=""><a href="#index39a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-address-book fs-17"></i></a></li>
										<li><a href="#index39d"  <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
										<!--
										<li><a href="#index2" data-toggle="tab"><i class="fa fa-envelope fs-17"></i></a></li>
										<li><a href="#index3" data-toggle="tab"><i class="fa fa-user fs-17"></i></a></li>
										<li><a href="login.html" title="logout"><i class="fa fa-power-off fs-17"></i></a></li>
										-->
								</ul>
								<?php }else if($currentuserlevel == 40){ ?>
									<ul class="nav panel-tabs">
										<li class=""><a href="#index40a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-building fs-17"></i></a></li>
										<li><a href="#index40b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-money fs-17"></i></a></li>
										<li><a href="#index40c" <?php  if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-barcode fs-17"></i></a></li>
										<!--
										<li><a href="#index40d"  <?php // if($pg == 2153 || $pg == 2158 || $pg == 2159 || $pg == 2153 ){ ?> class="active" <?php // } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
										-->
										<!--
										<li><a href="#index40d" title="logout"><i class="fa fa-bars fs-17"></i></a></li>
										-->
									</ul>
									<?php }else if($currentuserlevel == 50){ ?>
									<ul class="nav panel-tabs">
										<li class=""><a href="#index50a" <?php  if($sub == 1){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-building fs-17"></i></a></li>
										<!-- <li><a href="#index50b" <?php  if($sub == 2){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-money fs-17"></i></a></li>
										<li><a href="#index50c" <?php  if($sub == 3){ ?> class="active" <?php } ?> data-toggle="tab"><i class="fa fa-barcode fs-17"></i></a></li> -->
										<!--
										<li><a href="#index40d"  <?php // if($pg == 2153 || $pg == 2158 || $pg == 2159 || $pg == 2153 ){ ?> class="active" <?php // } ?> data-toggle="tab"><i class="fa fa-user-md fs-17"></i></a></li>
										-->
										<!--
										<li><a href="#index40d" title="logout"><i class="fa fa-bars fs-17"></i></a></li>
										-->
									</ul>

							<?php } ?>
						</div> 
					</div>
					<div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
						<div class="tab-content">
						
						<?php if($currentuserlevel == 1){ ?>
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
										<a class="side-menu__item" href="records__recordconsultations?1"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Consultations</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="records__patientschemefilter"><i class="side-menu__icon typcn typcn-dropbox"></i><span class="side-menu__label">Payment Scheme</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="records__manageactiveservices"><i class="side-menu__icon typcn typcn-feather"></i><span class="side-menu__label">Manage Services</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="records__legacypatients"><i class="side-menu__icon typcn-contacts"></i><span class="side-menu__label">Legacy Patients</span></a>
									</li>	
									<li>
										<a class="side-menu__item" href="records__patientsearchfilter"><i class="side-menu__icon typcn typcn-document-text"></i><span class="side-menu__label">Patient Search</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="records__patientgroups"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Groups</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="records__patientsdeceased"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Deceased Patients</span></a>
									</li>									
								</ul>							
						</div>

						<div class="tab-pane border-top <?php   if($sub == 3){ ?> active  <?php  } ?> " id="index1c">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>									
								<li>
									<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
								</li>									
							</ul>
						</div>
						<div class="tab-pane border-top <?php   if($sub == 4){ ?> active  <?php  } ?> " id="index1d">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>									
								<li>
									<a class="side-menu__item" href="records__promotion__managepromotionsubscription"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label"> Promotion Subscription</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
								</li>									
							</ul>
						</div>

						<?php } else if($currentuserlevel == 2){ ?>
							
							<div class="tab-pane <?php  if($sub == 1){ ?> active <?php } ?> " id="index2a">
								<ul class="side-menu toggle-menu">
									<li>
										<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
									</li>	
									<li>
										<a class="side-menu__item" href="claimbilling__noncashtransactions"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Transactions</span><?php if($insurancecount > '0'){ ?> <span class="badge badge-primary"><?php echo $insurancecount ; ?></span> <?php } ?></a>
									</li>
									<li>
										<a class="side-menu__item" href="claimbilling__transactionsbasket"><i class="side-menu__icon typcn typcn-dropbox"></i><span class="side-menu__label">Transactions Basket </span></a>
									</li>
									<li>
										<a class="side-menu__item" href="manageclaims"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Claims</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
									<!--
									<li>
										<a class="side-menu__item" href="claimbilling__managelegacydetails"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Legacy </span></a>
									</li>
									<li>
										<a class="side-menu__item" href="claimbilling__billingtransactionsprocessed"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Processed </span></a>
									</li>	
									-->															
								</ul>
							</div>

							<div class="tab-pane border-top <?php  if($sub == 2 ){ ?> active <?php } ?>" id="index2b">
								<ul class="side-menu toggle-menu">
									<li>
										<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__manageprice"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Pricing</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Payment Method</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Payment Partners</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__managepaymentscheme"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Payment Schemes</span></a>
									</li>																
								</ul>
							</div>

							<div class="tab-pane border-top <?php   if($sub == 3){ ?> active  <?php  } ?> " id="index2c">
									<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="receiptsearchfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Receipts Issued </span></a>
											</li>								
											
											<li>
												<a class="side-menu__item" href="cashier__shifttransactions"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Shift Transaction </span></a>
											</li>
											<li>
												<a class="side-menu__item" href="cashier__cashierpatientfolderfilter"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Patient Folder</span></a>
											</li>								
										
										<li>
											<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
										</li>			
										
									</ul>
								</div>
								<!--
							<div class="tab-pane border-top <?php   //if($sub == 3 ){ ?> active  <?php  //} ?> " id="index2c">
									<ul class="side-menu toggle-menu">
									<li>
										<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
									</li>							
									
									<li>
										<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
									</li>			
									
								</ul>
							</div>	-->
							
							<?php } else if($currentuserlevel == 3){ ?>
									<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index3a">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="cashier__cashtransactions"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Transactions</span> <?php if($noninsurancecount > '0'){ ?> <span class="badge badge-primary"><?php echo $noninsurancecount ; ?></span> <?php } ?></a>
											</li>
											<?php if($prepaidchemecode !== '0'){ ?>
											<li>
												<a class="side-menu__item" href="cashier__managepatientwalletfilter"><i class="side-menu__icon typcn typcn-support"></i><span class="side-menu__label">Manage Wallet</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="promotion__managepromotionsubscriptionpayment"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label"> Promotion Subscription</span> <?php if($promotioncount > '0'){ ?> <span class="badge badge-success"><?php echo $promotioncount ; ?></span> <?php } ?></a>
											</li>
											<?php } ?>
											<li>
										<a class="side-menu__item" href="managesalepoints?1"><i class="side-menu__icon typcn typcn-export"></i><span class="side-menu__label">Sale point</span></a>
									</li>
											<!--
											<li>
												<a class="side-menu__item" href="admin__managecreditorslist"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Manage Credit</span></a>
											</li>
											-->
											<li>
											<a class="side-menu__item" href="cashier__partnerpayments"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Partner Payments</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="cashier__managerefunds"><i class="side-menu__icon typcn typcn-spanner-outline"></i><span class="side-menu__label">Refunds</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="cashier__manageendofday"><i class="side-menu__icon typcn typcn-chart-pie-outline"></i><span class="side-menu__label">End OF Day</span></a>
											</li>										
											<li>
												<a class="side-menu__item" href="admin__manageforex"><i class="side-menu__icon typcn typcn-chart-pie"></i><span class="side-menu__label">Manage Forex</span></a>
											</li>												
											<li>
												<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
											</li>					
										</ul>
									</div>
									<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index3b">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>																	

											<li>
												<a class="side-menu__item" href="admin__manageprice"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Pricing</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Payment Method</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Payment Partners</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="admin__managepaymentscheme"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Payment Schemes</span></a>
											</li>

										</ul>
									</div>

									<div class="tab-pane border-top <?php   if($sub == 3){ ?> active  <?php  } ?> " id="index3c">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="receiptsearchfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Receipts Issued </span></a>
											</li>								
											
											<li>
												<a class="side-menu__item" href="cashier__shifttransactions"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Shift Transaction </span></a>
											</li>
											<li>
												<a class="side-menu__item" href="cashier__cashierpatientfolderfilter"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Patient Folder</span></a>
											</li>								
										
										<li>
											<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
										</li>			
										
									</ul>
								</div>
								
								<?php } else if($currentuserlevel == 4){ 
																	 	
									$nursecount = $lov->getnursecounts($currentusercode,$patientqueueexcept,$nursingservices,$thereviewday,$day,$instcode); 
									$nc = explode('@' , $nursecount);
									$myconsultationcount = $nc[0];
									$admissioncount = $nc[1];
									$procedurecount = $nc[2];
									$followupcount = $nc[3];
									$patientqueuecount = $nc[4];
									$servicebasketcount = $nc[5];
									$handovercount = $nc[6];
									$patientpastedqueuecount = $nc[7];
									$patientfollowupcount = $nc[8];	
									$patientcancelledcount = $nc[9];
									$nursingcount 	= $nc[10];	
									$investigationscount 	= $nc[11];							
								?>
								<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index4a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
										<li>
											<a class="side-menu__item" href="nursepatientqueue"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Patient Queue </span> <?php if($patientqueuecount > '0'){ ?> <span class="badge badge-primary"><?php echo $patientqueuecount ; ?></span> <?php } ?></a>
										</li>	
										<li>
											<a class="side-menu__item" href="patientservicebasket"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Service Baskets </span> <?php if($servicebasketcount > '0'){ ?> <span class="badge badge-primary"><?php echo $servicebasketcount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="admission__nursemanageadmission"><i class="side-menu__icon typcn typcn-film"></i><span class="side-menu__label">Admissions / Detain</span> <?php if($admissioncount > '0'){ ?> <span class="badge badge-primary"><?php echo $admissioncount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="nursefollowuplist"><i class="side-menu__icon typcn typcn-contacts"></i><span class="side-menu__label">Patient Followup </span> <?php if($patientfollowupcount > '0'){ ?> <span class="badge badge-primary"><?php echo $patientfollowupcount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientattachmentstoday"><i class="side-menu__icon typcn typcn-feather"></i><span class="side-menu__label">Investigations </span> <?php if($investigationscount > '0'){ ?> <span class="badge badge-primary"><?php echo $investigationscount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="nursepatientfolderfilter"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Patient Folder </span></a>
										</li>																				
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>			
																		
									</ul>
								</div>

								<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index4b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientqueuenursesnoteslist"><i class="side-menu__icon typcn typcn-book"></i><span class="side-menu__label">Patient Notes </span> <?php // if($patientqueuecount > '0'){ ?> <span class="badge badge-primary"><?php //echo $patientqueuecount ; ?></span> <?php //} ?></a>
										</li>
										
										<li>
											<a class="side-menu__item" href="managenursingservices"><i class="side-menu__icon typcn typcn-arrow-sync-outline"></i><span class="side-menu__label">Nurseing Services  </span> <?php if($nursingcount > '0'){ ?> <span class="badge badge-primary"><?php echo $nursingcount ; ?></span> <?php  } ?></a>
										</li>															
										
										<li>
											<a class="side-menu__item" href="patientreviewbookings"><i class="side-menu__icon typcn typcn-rss"></i><span class="side-menu__label">Review / Follow Up</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientreferalbookings"><i class="side-menu__icon typcn typcn-pin-outline"></i><span class="side-menu__label"> Referal </span></a>
										</li>
										<li>
											<a class="side-menu__item" href="managecancelledservices"><i class="side-menu__icon typcn typcn-refresh"></i><span class="side-menu__label">Manage Cancellations</span> <?php if($patientcancelledcount > '0'){ ?> <span class="badge badge-primary"><?php echo $patientcancelledcount ; ?></span> <?php } ?></a>
										</li>
										
										<li>
											<a class="side-menu__item" href="manageprocedure"><i class="side-menu__icon typcn typcn-refresh-outline"></i><span class="side-menu__label">Manage Procedure</span> <?php if($procedurecount > '0'){ ?> <span class="badge badge-primary"><?php echo $procedurecount ; ?></span> <?php } ?></a>
										</li>
																								
									</ul>
								</div>
								<div class="tab-pane border-top <?php  if($sub == 3){ ?> active <?php } ?>" id="index4c">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										
										<li>
										<a class="side-menu__item" href="patientallergies"><i class="side-menu__icon typcn typcn-feather"></i><span class="side-menu__label">Allergies </span></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientglucosemonitor"><i class="side-menu__icon typcn typcn-download"></i><span class="side-menu__label">Glucose Monitor</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="medicalreport"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Medical Reports</span></a>
										</li>
																				
										
										<li>
										<a class="side-menu__item" href="patientsdeceased"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Deceased Patients</span></a>
									</li>	
											
																							
									</ul>
								</div>
								<div class="tab-pane border-top <?php  if($sub == 4){ ?> active <?php } ?>" id="index4d">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="nursehandovernotes"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Handover Notes </span> <?php if($handovercount > '0'){ ?> <span class="badge badge-primary"><?php echo $handovercount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="nursepricing"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Pricing</span></a>
										</li>													
									</ul>
								</div>
								<?php } else if($currentuserlevel == 5){ 									
									$doctorcount = $lov->getdoctorscounts($currentusercode,$thereviewday,$instcode); 
									$dc = explode('@' , $doctorcount);
									$myconsultationcount = $dc[0];
									$admissioncount = $dc[1];
									$procedurecount = $dc[2];
									$followupcount = $dc[3];
								?>
								<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index5a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
										<li>
											<a class="side-menu__item" href="patientconsultationgp"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label"> Consultation</span> <?php if($myconsultationcount > '0'){ ?> <span class="badge badge-primary"><?php echo $myconsultationcount ; ?></span> <?php } ?></a>
										</li>
										<?php //if($pendingcount<'1'){ ?>
										<li>
											<a class="side-menu__item" href="manageadmission"><i class="side-menu__icon typcn typcn-film"></i><span class="side-menu__label">Admissions / Detention</span> <?php if($admissioncount > '0'){ ?> <span class="badge badge-primary"><?php echo $admissioncount ; ?></span> <?php } ?></a>
										</li>
										<?php //} ?>
										<!--
										<li>
											<a class="side-menu__item" href="patientconsultationorthopedic"><i class="side-menu__icon typcn typcn-puzzle"></i><span class="side-menu__label"> Orthopedic Consultation</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientobsgyne"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Obstetrics & Gynecology</span></a>
										</li>
										
										-->
										
										<li>
											<a class="side-menu__item" href="patientreviewbookings"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Review / Referal / Follow Up</span> <?php if($followupcount > '0'){ ?><span class="badge badge-primary"><?php echo $followupcount ; ?></span> <?php } ?></a>
										</li>
										<!-- <li>
											<a class="side-menu__item" href="patientconsultationsearch"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Patient Search </span></a>
										</li> -->
										<li>
											<a class="side-menu__item" href="patientfolder__filter"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Patient Folder </span></a>
										</li>
										<li>
											<a class="side-menu__item" href="attachment__filterattachment"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Attachments</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="manageprocedure"><i class="side-menu__icon typcn-refresh-outline"></i><span class="side-menu__label">Manage Procedure</span> <?php if($procedurecount > '0'){ ?><span class="badge badge-primary"><?php echo $procedurecount ; ?></span> <?php } ?></a>
										</li>
										<li>
											<a class="side-menu__item" href="managemedicalreport"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label"> Medical Reports</span></a>
										</li>
											
										<li>
											<a class="side-menu__item" href="nursehandovernotes"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Handover Notes </span></a>
										</li>
										<!--
										<li>
											<a class="side-menu__item" href="mystats"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">My Stats</span></a>
										</li> -->
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>										
										
									</ul>
								</div>
								<?php if($useraccesslevel == '1' ){  ?>
								<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index5b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>									
										<li>
											<a class="side-menu__item" href="patientqueuelist"><i class="side-menu__icon typcn typcn-puzzle"></i><span class="side-menu__label"> Patient Queue</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="monitorprocedures"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label"> Monitor Procedure</span></a>
										</li>										
										<li>
											<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="consultationreportsfilter"><i class="side-menu__icon typcn typcn-eject"></i><span class="side-menu__label">Reports</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="physiotherapyreportsfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Physiotherapy Reports</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="doctorstats"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label"> Stats</span></a>
										</li>
										<li>
									<a class="side-menu__item" href="labreports"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Lab Reports</span></a>
								</li>
										
									</ul>
								</div>
								<?php } ?>

								<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?>" id="index5c">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
										<li>
											<a class="side-menu__item" href="setupmedications "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Medication </span></a>
										</li>
										<li>
											<a class="side-menu__item" href="setupdevices "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label"> Devices </span></a>
										</li>
										<li>
											<a class="side-menu__item" href="setuplabs"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Labs</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="setupimaging"><i class="side-menu__icon typcn typcn-starburst"></i><span class="side-menu__label">Imaging / Scan</span></a>
										</li>
										
										<li>
											<a class="side-menu__item" href="setupprocedure"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Procedures</span></a>
										</li>								
										
										<li>
											<a class="side-menu__item" href="setuplabplan"><i class="side-menu__icon typcn typcn-puzzle"></i><span class="side-menu__label"> Lab Plan</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="setupprescriptionplan"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Prescription Plan</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="pastconsultation"><i class="side-menu__icon typcn typcn-cloud-storage"></i><span class="side-menu__label">Past Consultations </span></a>
										</li>
										<li>
										<a class="side-menu__item" href="patientsdeceased"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Deceased Patients</span></a>
									</li>	
										<!--
										<li>
											<a class="side-menu__item" href="myconsultationsfilter"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">My Consultations</span></a>
										</li>
								--></ul>
								</div>											
								
								<?php } else if($currentuserlevel == 6){ ?>
									<div class="tab-pane <?php  if($sub == 1){ ?> active <?php } ?> " id="index6a">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="labsrequests"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Lab Request</span></a>
											</li>											
											<!--
												<li>
												<a class="side-menu__item" href="pendingresults"><i class="side-menu__icon typcn typcn-starburst"></i><span class="side-menu__label">Labs Pending Results</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="processpartnerlabs"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Partner Labs</span></a>
											</li>
											-->
											<li>
												<a class="side-menu__item" href="walkinfilter"><i class="side-menu__icon typcn typcn-star"></i><span class="side-menu__label">Walk In</span></a>
											</li>	

											<li>
												<a class="side-menu__item" href="imagingrequests"><i class="side-menu__icon typcn typcn-media-eject-outline"></i><span class="side-menu__label">Imaging Request</span></a>
											</li>
											<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
											
											<!--
												<li>
												<a class="side-menu__item" href="Imagingpendingresults"><i class="side-menu__icon typcn-media-fast-forward-outline"></i><span class="side-menu__label">Imaging Pending Results</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
											</li>
										
											<!--
												<li>
												<a class="side-menu__item" href="admin__myschedule"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">My Schedule</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="labrequestsendoutfilter"><i class="side-menu__icon typcn typcn-media-stop-outline"></i><span class="side-menu__label">Imaging Send Out </span></a>
											</li>									
											<li>
												<a class="side-menu__item" href="archievefilter"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Labs Archive</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="samplesearchfilter"><i class="side-menu__icon typcn typcn-media-record"></i><span class="side-menu__label">Sample Registry</span></a>
											</li>			
											
												<li>
												<a class="side-menu__item" href="patientoverthecounter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Over The Counter</span></a>
											</li>
											
											<li>
												<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Archives</span></a>
											</li>
												-->							
											
										</ul>
									</div>
									<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index6b">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="labtests"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Lab Test</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="labdispline"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Lab Displine</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="labsspecimen"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Lab Specimen </span></a>
											</li>
											<li>
												<a class="side-menu__item" href="setuplabplan"><i class="side-menu__icon typcn typcn-puzzle"></i><span class="side-menu__label"> Lab Plan</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="labpricing"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Pricing</span></a>
											</li>											
										</ul>
									</div>

									<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?> " id="index6c">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>									

											<li>
												<a class="side-menu__item" href="labrequestsendoutfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Send Out </span></a>
											</li>									
											<li>
												<a class="side-menu__item" href="archievefilter"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label"> Archive</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="samplesearchfilter"><i class="side-menu__icon typcn typcn-media-record"></i><span class="side-menu__label">Sample Registry</span></a>
											</li>
											
										</ul>
									</div>

								<?php } else if($currentuserlevel == 7){  
									$pharmacycount = $lov->getpharmacycounts($theexpiryday,$instcode); 
									$pc = explode('@' , $pharmacycount);
									$prescriptioncount = $pc[0];
									$devicecount = $pc[1];
									$procedurecount = $pc[2];
									$requisitioncount = $pc[3];
									$transfercount = $pc[4];
									$expirycount = $pc[5];									
								?>

									<div class="tab-pane <?php  if($sub == 1){ ?> active <?php } ?> " id="index7a">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="manageprescriptions"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Prescriptions</span> <?php if($prescriptioncount > '0'){ ?><span class="badge badge-primary"><?php echo $prescriptioncount ; ?></span> <?php } ?></a>
											</li>											
											<li>
												<a class="side-menu__item" href="manageprescribedevices"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Medical Devices</span> <?php if($devicecount > '0'){ ?><span class="badge badge-primary"><?php echo $devicecount ; ?></span> <?php } ?></a>
											</li>
											<li>
												<a class="side-menu__item" href="pharmacyconsumable"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Consumables</span> <?php //if($devicecount > '0'){ ?><span class="badge badge-primary"><?php //echo $devicecount ; ?></span> <?php //} ?></a>
											</li>
											<li>
												<a class="side-menu__item" href="walkinfilter"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Walk In</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="manageprocedure"><i class="side-menu__icon typcn-refresh-outline"></i><span class="side-menu__label">Manage Procedure</span><?php if($procedurecount > '0'){ ?><span class="badge badge-primary"><?php echo $procedurecount ; ?></span> <?php } ?></a>
											</li>
											<li>
												<a class="side-menu__item" href="managestocktransfers"><i class="side-menu__icon typcn typcn-spiral"></i><span class="side-menu__label">Stock Transfers</span><?php if($transfercount > '0'){ ?><span class="badge badge-primary"><?php echo $transfercount ; ?></span> <?php } ?></a>
											</li>
											<li>
												<a class="side-menu__item" href="manageexpiry"><i class="side-menu__icon typcn typcn-star"></i><span class="side-menu__label">Expiry </span> <?php if($expirycount > '0'){ ?><span class="badge badge-primary"><?php echo $expirycount ; ?></span> <?php } ?></a>
											</li>
											<li>
												<a class="side-menu__item" href="pharmacypatientfolder?1"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Patient Folder</span></a>
											</li>	
											<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
											
										</ul>
									</div>

									<div class="tab-pane border-top <?php  if($sub == 2 ){ ?> active <?php } ?>" id="index7b">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="lowstocks"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Medication Low Stocks</span></a>
											</li>								

											<!--<li>
												<a class="side-menu__item" href="newmedications"><i class="side-menu__icon typcn typcn-spiral"></i><span class="side-menu__label">New Medications</span></a>
											</li>
											
											<li>
												<a class="side-menu__item" href="stockadjustments"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Medication Adjustment</span></a>
											</li> -->
										
											<li>
												<a class="side-menu__item" href="setupprescriptionplan"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Prescription Plan</span></a>
											</li>	
											
										
											<li>
												<a class="side-menu__item" href="pharmacystocklist"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Medication List</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="pharmacypricing"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Medication Priceing</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="devicelowstocks"><i class="side-menu__icon typcn typcn-group"></i><span class="side-menu__label">Device Low Stocks</span></a>
											</li>
											<!--<li>
												<a class="side-menu__item" href="newdevices"><i class="side-menu__icon typcn typcn-key"></i><span class="side-menu__label">New Devices</span></a>
											</li>
																						
											<li>
												<a class="side-menu__item" href="devicestockadjustments"><i class="side-menu__icon typcn typcn-keyboard"></i><span class="side-menu__label">Devices Adjustment</span></a>
											</li>	-->									
											<li>
												<a class="side-menu__item" href="devicespharmacystocklist"><i class="side-menu__icon typcn typcn-lightbulb"></i><span class="side-menu__label">Devices Stock List</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="devicepharmacypricing"><i class="side-menu__icon typcn typcn-map"></i><span class="side-menu__label">Device Pricing</span></a>
											</li>							
										</ul>
									</div>
									
									<div class="tab-pane border-top <?php  if($sub == 3){ ?> active <?php  } ?>" id="index7c">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
														
											
										</ul>
									</div>

									<div class="tab-pane border-top <?php  if($sub == 4 ){ ?> active <?php } ?>" id="index7d">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>	
											<li>
												<a class="side-menu__item" href="report__pharmacyreportfilter"><i class="side-menu__icon typcn typcn-clipboard"></i><span class="side-menu__label">Reports</span></a>
											</li>
																			
										</ul>
									</div>

<?php } else if($currentuserlevel == 8 ){ 
	$physiocount = $patientsServiceRequesttable->getphysiocounts($physioservices,$currentusercode,$instcode); 								
	$ph = explode('@@' , $physiocount);
	$physiopatientqueuecount = $ph[0];
	$myphysiopatientqueuecount = $ph[1];
	$archivephysiocount = $ph[2];
	$mycompletedphysiocount = $ph[3];									
?>

<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index8a">
	<ul class="side-menu toggle-menu">
		<li>
			<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
		</li>
		<li>
			<a class="side-menu__item" href="physio__patientqueue?1"><i class="side-menu__icon typcn typcn-th-list"></i><span class="side-menu__label">Patient Queue</span><?php if($physiopatientqueuecount > '0'){ ?><span class="badge badge-primary"><?php echo $physiopatientqueuecount ; ?></span> <?php } ?></a>
		</li>
		<li>
			<a class="side-menu__item" href="physio__myservicebasket?1"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label"> My Service Basket</span><?php if($myphysiopatientqueuecount > '0'){ ?><span class="badge badge-primary"><?php echo $myphysiopatientqueuecount ; ?></span> <?php } ?></a>
		</li>		
		<li>
			<a class="side-menu__item" href="physio__myservicebasketcompleted?1"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label"> My completed Service </span> <?php if($mycompletedphysiocount > '0'){ ?><span class="badge badge-warning"><?php echo $mycompletedphysiocount ; ?></span> <?php } ?></a>
		</li>
		<li>
			<a class="side-menu__item" href="physio__patientqueuearchive?1"><i class="side-menu__icon typcn typcn-download-outline"></i><span class="side-menu__label">Patient Queue Archive</span><?php if($archivephysiocount > '0'){ ?><span class="badge badge-primary"><?php echo $archivephysiocount ; ?></span> <?php } ?></a>
		</li>
		<li>
			<a class="side-menu__item" href="patientfolder__filter"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Patient Folder </span></a>
		</li>	
		<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>								
	</ul>
</div>

						<div class="tab-pane border-top <?php   if($pg == 2157 || $pg == 2158 || $pg == 2159 || $pg == 2051 || $pg ==2052 || $pg ==2153 ){ ?> active  <?php  } ?> " id="index38d">
								<ul class="side-menu toggle-menu">
									<li>
										<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
									</li>							
									
									<li>
										<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
									</li>			
									
								</ul>
							</div>

							<?php } else if($currentuserlevel == 9 ){ 
							//	$physiocount = $lov->getphysiocounts($currentusercode,$thereviewday,$day,$physiofirstvisit,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,$physiofullbodymassage,$physioreflexology,$instcode); 								
							// $ph = explode('@' , $physiocount);
							// $servicerequestcount = $ph[0];
							// $devicecount = $pc[1];
							// $procedurecount = $pc[2];
							// $requisitioncount = $pc[3];									
						?>

						<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index9a">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__managerefunds"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Refunds</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__managerreturns"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Manage Return</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__managereceipts"><i class="side-menu__icon typcn typcn-document-add"></i><span class="side-menu__label">Manage Receipts</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="manageclaims"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Claims</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__cancelledtransaction"><i class="side-menu__icon typcn typcn-chevron-left-outline"></i><span class="side-menu__label">Manage Cancelled</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__manageforex"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Forex</span></a>
								</li>	
								<li>
									<a class="side-menu__item" href="cashier__manageendofday"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">End OF Day</span></a>
								</li>
								<?php if($prepaidchemecode !== '0'){ ?>
								<li>
									<a class="side-menu__item" href="cashier__managepatientwalletfilter"><i class="side-menu__icon typcn typcn-support"></i><span class="side-menu__label">Manage Wallet</span></a>
								</li>
								<?php } ?>
								<li>
									<a class="side-menu__item" href="admin__managecreditorslist"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Manage Credit</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__partnerpayments"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Partner Payments</span></a>
								</li>
								<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
							</ul>
						</div>	
						
						<div class="tab-pane border-top <?php  if($sub == 2 ){ ?> active <?php } ?>" id="index9b">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="physiotherapyreportsfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Physiotherapy Reports</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="report__pharmacyreportfilter"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Pharmacy Reports</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="report__revenuereportfilter"><i class="side-menu__icon typcn typcn-location-outline"></i><span class="side-menu__label">Revenue Report</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="doctorstats"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label"> Stats</span></a>
								</li>
										<li>
									<a class="side-menu__item" href="labreports"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Lab Reports</span></a>
								</li>
																	
							</ul>
						</div>
						
						<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?>" id="index9c">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="receiptsearchfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Receipts Issued </span></a>
								</li>								
								
								<li>
									<a class="side-menu__item" href="cashier__shifttransactions"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Shift Transaction </span></a>
								</li>											
							</ul>
						</div>
						<?php } else if($currentuserlevel == 10 ){ 
							//$physiocount = $lov->getphysiocounts($currentusercode,$thereviewday,$day,$physiofirstvisit,$physiofollowup,$physioacupuncturesinglesite,$physioacupuncturemultisite,$physiofullbodymassage,$physioreflexology,$instcode); 								
							// $ph = explode('@' , $physiocount);
							// $servicerequestcount = $ph[0];
							// $devicecount = $pc[1];
							// $procedurecount = $pc[2];
							// $requisitioncount = $pc[3];									
						?>

						<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index10a">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="managegeneralstores"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Stores</span></a>
								</li>
								<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
								
								<!--
									<li>
									<a class="side-menu__item" href="managephysioservicebasketarchives"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Archives</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="patientfolder__filter"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Patient Folder </span></a>
								</li>
								
								<li>
									<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-location-outline"></i><span class="side-menu__label">Manage Payment Partners</span></a>
								</li>									

								<li>
									<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Payment Methods</span></a>
								</li>	
								<li>
									<a class="side-menu__item" href="admin__myschedule"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">My Schedule</span></a>
								</li>	-->						
								
							</ul>
						</div>

						<div class="tab-pane border-top <?php   if($pg == 2157 || $pg == 2158 || $pg == 2159 || $pg == 2051 || $pg ==2052 || $pg ==2153 ){ ?> active  <?php  } ?> " id="index10d">
								<ul class="side-menu toggle-menu">
									<li>
										<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
									</li>							
									<!--
									<li>
										<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
									</li>
									<li>
										<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
									</li>	-->		
									
								</ul>
							</div>
							<?php } else if($currentuserlevel == 11 ){ ?>
								<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index11a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="patientselfregistration"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Registration</span></a>
										</li>							
									</ul>
								</div>

								<div class="tab-pane border-top <?php if($pg == 2157){ ?> active  <?php } ?> " id="index11b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
									</ul>
								</div>

								<?php } else if($currentuserlevel == 12){ ?>
								<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index12a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="managegeneralstores"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Stores</span></a>
										</li>
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>								
									</ul>
								</div>

								<div class="tab-pane border-top <?php if($pg == 2157){ ?> active  <?php } ?> " id="index12b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
									</ul>
								</div>
								<?php } else if($currentuserlevel == 13){ ?>
								<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index13a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="radiology__managerequest"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Request</span></a>
										</li>	
										<li>
											<a class="side-menu__item" href="walkin__filter"><i class="side-menu__icon typcn typcn-lightbulb"></i><span class="side-menu__label">Walk In</span></a>
										</li>
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>								
									</ul>
								</div>
								<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index13b">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="radiology__setupradiologytest"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Radiology List</span></a>
											</li>
											
											<li>
												<a class="side-menu__item" href="radiology__setupradiologyprice"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Pricing</span></a>
											</li>											
										</ul>
									</div>

									<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?> " id="index13c">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>									

											<!-- <li>
												<a class="side-menu__item" href="labrequestsendoutfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Send Out </span></a>
											</li>									
											<li>
												<a class="side-menu__item" href="archievefilter"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label"> Archive</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="samplesearchfilter"><i class="side-menu__icon typcn typcn-media-record"></i><span class="side-menu__label">Sample Registry</span></a>
											</li> -->
											
										</ul>
									</div>

								<!-- <div class="tab-pane border-top <?php // if($pg == 2157){ ?> active  <?php // } ?> " id="index13b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
									</ul>
								</div> -->
								<?php } else if($currentuserlevel == 14){ ?>
								<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index12a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="managegeneralstores"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Stores</span></a>
										</li>
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>								
									</ul>
								</div>

								<div class="tab-pane border-top <?php if($pg == 2157){ ?> active  <?php } ?> " id="index12b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
									</ul>
								</div>
								<?php } else if($currentuserlevel == 15){ ?>
								<div class="tab-pane <?php   if($sub == 1){ ?> active  <?php  } ?> " id="index12a">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>
										<li>
											<a class="side-menu__item" href="managegeneralstores"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Stores</span></a>
										</li>	
										<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>							
									</ul>
								</div>

								<div class="tab-pane border-top <?php if($pg == 2157){ ?> active  <?php } ?> " id="index12b">
									<ul class="side-menu toggle-menu">
										<li>
											<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
										</li>	
									</ul>
								</div>
						<?php } else if($currentuserlevel == 38){ ?>
							<div class="tab-pane <?php   if($sub == '1' ){ ?> active  <?php  } ?> " id="index38a">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>								
								<li>
									<a class="side-menu__item" href="managegeneralstores"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Manage Stores</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="managebatch"><i class="side-menu__icon typcn typcn-spanner-outline"></i><span class="side-menu__label">Manage Batch</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="returntosupplierlist"><i class="side-menu__icon typcn typcn-spiral"></i><span class="side-menu__label">Return to Supplier</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="promotion__managepromotion"><i class="side-menu__icon typcn typcn-cog"></i><span class="side-menu__label">Manage Promotion</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__manageforex"><i class="side-menu__icon typcn typcn-news"></i><span class="side-menu__label">Manage Forex</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="cashier__manageendofday"><i class="side-menu__icon typcn-star-half-outline"></i><span class="side-menu__label">End OF Day</span></a>
								</li>
								<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>									
								<li>
									<a class="side-menu__item" href="incidencereports"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Incidence Reports </span></a>
								</li>			
							</ul>
						</div>
						<div class="tab-pane border-top <?php  if($sub == '2' ){ ?> active <?php } ?>" id="index38b">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="manageedservices"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Setup / Pricing</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__manageuser"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Manage Users</span></a>
								</li>	
								<li>
									<a class="side-menu__item" href="cashier__manageservicepartner"><i class="side-menu__icon typcn typcn-star-half-outline"></i><span class="side-menu__label">Service Partners</span></a>
								</li>
								<li>
										<a class="side-menu__item" href="manageclaims"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Claims</span></a>
									</li>
								<li>
								<li>								
									<a class="side-menu__item" href="cashier__managerefunds"><i class="side-menu__icon typcn typcn-shopping-bag"></i><span class="side-menu__label">Refunds</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="monitorpharmacy"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Monitor Pharmacy</span></a>
								</li>
																
							</ul>
						</div>
						<div class="tab-pane border-top <?php if($sub == '3' ){ ?> active  <?php  } ?> " id="index38c">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>				
								<li>
									<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
								</li>									
							</ul>
						</div>
						<div class="tab-pane border-top <?php if($sub == '4' ){ ?> active  <?php  } ?> " id="index38d">
							<ul class="side-menu toggle-menu">
								<li>
									<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
								</li>				
								<li>
									<a class="side-menu__item" href="physiotherapyreportsfilter"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Physiotherapy Reports</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="report__pharmacyreportfilter"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Pharmacy Reports</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="report__revenuereportfilter"><i class="side-menu__icon typcn typcn-location-outline"></i><span class="side-menu__label">Revenue Report</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="labreports"><i class="side-menu__icon typcn typcn-headphones"></i><span class="side-menu__label">Lab Reports</span></a>
								</li>
								<li>
									<a class="side-menu__item" href="doctorstats"><i class="side-menu__icon typcn typcn-tabs-outline"></i><span class="side-menu__label"> Stats</span></a>
								</li>																	
							</ul>
						</div>
							<?php } else if($currentuserlevel == 39){ ?>

									<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index39a">
										<ul class="side-menu toggle-menu">
											<li>
												<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
											</li>
											<li>
												<a class="side-menu__item" href="generalstats"><i class="side-menu__icon typcn typcn-spanner-outline"></i><span class="side-menu__label">General Stats </span></a>
											</li>	
											<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>							
										</ul>
									</div>
									<div class="tab-pane border-top <?php   if($sub == 4 ){ ?> active  <?php  } ?> " id="index39d">
												<ul class="side-menu toggle-menu">
													<li>
														<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
													</li>										
													<li>
														<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
													</li>											
												</ul>
											</div>
									
							<?php } else if($currentuserlevel == 40){ ?>


										<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index40a">
											<ul class="side-menu toggle-menu">
												<li>
													<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
												</li>									
												
												<li>
													<a class="side-menu__item" href="admin__manageshift"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Manage Shifts</span></a>
												</li>
											
												<li>
													<a class="side-menu__item" href="admin__managecredit"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Credit</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__manageuser"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Manage Users</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__managesettings"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Manage Settings</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__manageservices"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Services</span></a>
												</li>	
												<li>
													<a class="side-menu__item" href="doctorstats"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label"> Stats</span></a>
												</li>
												<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>											
											</ul>
										</div>
										
										<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index40b">
											<ul class="side-menu toggle-menu">
												<li>
													<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
												</li>									

												<li>
													<a class="side-menu__item" href="admin__manageprice"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Pricing</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Payment Method</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Payment Partners</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__managepaymentscheme"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Payment Schemes</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="admin__manageservicepartners"><i class="side-menu__icon typcn typcn-support"></i><span class="side-menu__label">Service Partners</span></a>
												</li>				
												
											</ul>
										</div>


										<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?>" id="index40c"> 
											<ul class="side-menu toggle-menu">
												<li>
													<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
												</li>	
												<li>
													<a class="side-menu__item" href="setupmedications "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Medication </span></a>
												</li>
												<li>
													<a class="side-menu__item" href="setupdevices "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label"> Devices </span></a>
												</li>
												<li>
													<a class="side-menu__item" href="setuplabs"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Labs</span></a>
												</li>
												<li>
													<a class="side-menu__item" href="setupimaging"><i class="side-menu__icon typcn typcn-starburst"></i><span class="side-menu__label">Imaging / Scan</span></a>
												</li>
												
												<li>
													<a class="side-menu__item" href="setupprocedure"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Procedures</span></a>
												</li>	
												
												<li>
													<a class="side-menu__item" href="setupsuppliers"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Suppliers</span></a>
												</li>
												
												<li>
													<a class="side-menu__item" href="setupwardsandbeds"><i class="side-menu__icon typcn typcn-flow-children"></i><span class="side-menu__label">Wards & Beds</span></a>
												</li>	
												<li>
													<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
												</li>	
												<li>
													<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
												</li>		
												
											</ul>
										</div>	
										
										<?php } else if($currentuserlevel == 50){ ?>


											<div class="tab-pane <?php  if($sub == 1 ){ ?> active <?php } ?> " id="index50a">
												<ul class="side-menu toggle-menu">
													<li>
														<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
													</li>									
													
													<li>
														<a class="side-menu__item" href="setup__setupfacilities"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Setup Facilites</span></a>
													</li>
													<li>
										<a class="side-menu__item" href="incidence__manageincidence"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Incidence</span></a>
									</li>	
												
													<!-- <li>
														<a class="side-menu__item" href="admin__managecredit"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Credit</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="manageusers"><i class="side-menu__icon typcn typcn-database"></i><span class="side-menu__label">Manage Users</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__managesettings"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Manage Settings</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__manageservices"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label">Manage Services</span></a>
													</li>	
													<li>
														<a class="side-menu__item" href="doctorstats"><i class="side-menu__icon typcn typcn-leaf"></i><span class="side-menu__label"> Stats</span></a>
													</li>										 -->
												</ul>
											</div>

											<div class="tab-pane border-top <?php  if($sub == 2){ ?> active <?php } ?>" id="index40b">
												<ul class="side-menu toggle-menu">
													<li>
														<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
													</li>									

													<li>
														<a class="side-menu__item" href="admin__manageprice"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Manage Pricing</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__managepaymentmethod"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Payment Method</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__managepaymentpartners"><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Payment Partners</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__managepaymentscheme"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Payment Schemes</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="admin__manageservicepartners"><i class="side-menu__icon typcn typcn-support"></i><span class="side-menu__label">Service Partners</span></a>
													</li>				
													
												</ul>
											</div>


											<div class="tab-pane border-top <?php  if($sub == 3 ){ ?> active <?php } ?>" id="index40c"> 
												<ul class="side-menu toggle-menu">
													<li>
														<a class="side-menu__item" href="home"><i class="side-menu__icon typcn typcn-device-desktop"></i><span class="side-menu__label">Dashboard</span></a>
													</li>	
													<li>
														<a class="side-menu__item" href="setupmedications "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label">Medication </span></a>
													</li>
													<li>
														<a class="side-menu__item" href="setupdevices "><i class="side-menu__icon typcn typcn-folder-open"></i><span class="side-menu__label"> Devices </span></a>
													</li>
													<li>
														<a class="side-menu__item" href="setuplabs"><i class="side-menu__icon typcn typcn-flow-switch"></i><span class="side-menu__label">Labs</span></a>
													</li>
													<li>
														<a class="side-menu__item" href="setupimaging"><i class="side-menu__icon typcn typcn-starburst"></i><span class="side-menu__label">Imaging / Scan</span></a>
													</li>
													
													<li>
														<a class="side-menu__item" href="setupprocedure"><i class="side-menu__icon typcn typcn-th-large-outline"></i><span class="side-menu__label">Procedures</span></a>
													</li>	
													
													<li>
														<a class="side-menu__item" href="setupsuppliers"><i class="side-menu__icon typcn typcn-flow-parallel"></i><span class="side-menu__label">Suppliers</span></a>
													</li>
													
													<li>
														<a class="side-menu__item" href="setupwardsandbeds"><i class="side-menu__icon typcn typcn-flow-children"></i><span class="side-menu__label">Wards & Beds</span></a>
													</li>	
													<li>
														<a class="side-menu__item" href="admin__setlocum"><i class="side-menu__icon typcn typcn-compass"></i><span class="side-menu__label">Set Locum</span></a>
													</li>	
													<li>
														<a class="side-menu__item" href="admin__manageschedule"><i class="side-menu__icon typcn typcn-arrow-move-outline"></i><span class="side-menu__label">Manage Schedule</span></a>
													</li>		
													
												</ul>
											</div>	
						<?php } ?>
						
						</div>					
					</div>
				</aside>
				
				<!--sidemenu end-->
				<div class="app-content  my-3 my-md-5 toggle-content">
					<div class="side-app">					