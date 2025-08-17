<?php
	REQUIRE_ONCE (INTFILE); 	
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
 <?php // $versiontype = $engine->getcurrentversion(); ?>
<title>THE OCTOPUS - <?php echo $versiontype ; ?> - <?php echo $pagename; ?></title>
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
	<body class="">		
		<!--Global-Loader-->
		<div id="global-loader">
			<img src="assets/images/icons/loader.svg" alt="loader">
		</div>
		<?php REQUIRE_ONCE 'include/submenu.php'; ?>
			    <!-- page -->
		<div class="page">
			<!-- page-content -->
			<div class="page-content">
				<div class="container text-left text-dark">
					<div class="row">
						<div class="col-lg-12 d-block mx-auto">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-md-12">
									<!-- <div class="card">
										<div class="card-body"> -->
											<!-- <div class="text-center mb-6">
												<img src="assets/images/brand/logo1.png" class="" alt="">
											</div> -->
											
										
		<!-- page End-->