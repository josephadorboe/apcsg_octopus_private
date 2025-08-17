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
	<?php // REQUIRE_ONCE (SUBMENUFILE); ?>		
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
							<!-- <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a> -->
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
				
				<br />	
				<hr />

						
		

					