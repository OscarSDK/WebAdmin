<?php
session_start();
//Set language for website
if (isset($_GET["lang"])) {
	setcookie('lang', $_GET["lang"], time() + (86400 * 365), "/");
	header("location: http://localhost/webadmin/index.php");
}

if(isset($_COOKIE['lang'])) {
	if ($_COOKIE['lang'] == "vi") {
		require_once 'include/lang_vi.php';
	} else {
		require_once 'include/lang_en.php';
	}
} else {
    setcookie('lang', 'en', time() + (86400 * 365), "/");
}

//Check if user not login
if (!isset($_SESSION["staff_api_key"])) {
	header('Location: ajax/login.php');
	die();
}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $lang['RS'] ?><?php echo $lang['MAINPAGE_TITLE'] ?></title>
		<meta name="description" content="description">
		<meta name="author" content="DevOOPS">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
		<link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
		<link href="plugins/select2/select2.css" rel="stylesheet">
		<link href="plugins/justified-gallery/justifiedGallery.css" rel="stylesheet">
		<link href="css/style_v2.css" rel="stylesheet">
		<link href="plugins/chartist/chartist.min.css" rel="stylesheet">
		<link href="plugins/toast/resources/css/jquery.toastmessage.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
<!--Start Header-->
<div id="screensaver">
	<canvas id="canvas"></canvas>
	<i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
	<div class="devoops-modal">
		<div class="devoops-modal-header">
			<div class="modal-header-name">
				<span></span>
			</div>
			<div class="box-icons">
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<form method="post" action="controller/checkLogin.php">
		<div class="devoops-modal-inner">
		</div>
		<div class="devoops-modal-bottom">
		</div>
		</form>
	</div>
</div>
<header class="navbar">
	<div class="container-fluid expanded-panel">
		<div class="row">
			<div id="logo" class="col-xs-12 col-sm-2">
				<a href=""><?php echo $lang['RIDESHARING'] ?></a>
			</div>
			<div id="top-panel" class="col-xs-12 col-sm-10">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						<div id="search">
							<input type="text" placeholder="search"/>
							<i class="fa fa-search"></i>
						</div>
					</div>
					<div class="col-xs-4 col-sm-8 top-panel-right">
						<a href="#" class="about"><?php echo $lang['ABOUT'] ?></a>
						<ul class="nav navbar-nav pull-right panel-menu">
							<li class="hidden-xs">
								<a href="index.php?lang=en"><img src="img/en.png" /></a>
							</li>
							<li class="hidden-xs">
								<a href="index.php?lang=vi"><img src="img/vi.png" /></a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
									<div class="avatar">
										<img src="<?php echo isset($_SESSION['StaffProfile']['link_avatar'])?'data:image/jpeg;base64,'.$_SESSION['StaffProfile']['link_avatar']:'img/avatar.jpg' ?>" class="img-circle" alt="avatar" />
									</div>
									<i class="fa fa-angle-down pull-right"></i>
									<div class="user-mini pull-right">
										<span class="welcome"><?php echo $lang['HELLO'] ?>,</span>
										<span>
										<?php 
											if (isset($_SESSION["StaffProfile"]) && isset($_SESSION["StaffProfile"]["fullname"])) {
												echo $_SESSION["StaffProfile"]["fullname"];
											} else {
												echo "Khách";
											}
										?>
										</span>
									</div>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="controller/staff.php?act=viewprofile">
											<i class="fa fa-user"></i>
											<span><?php echo $lang['PERSONAL_INFO'] ?></span>
										</a>
									</li>
									<li>
										<a href="controller/logout.php">
											<i class="fa fa-power-off"></i>
											<span><?php echo $lang['LOGOUT'] ?></span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				<li>
					<a href="ajax/dashboard.php" class="ajax-link">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs"><?php echo $lang['HOME'] ?></span>
					</a>
				</li>
				<?php
				if ($_SESSION["StaffProfile"]["role"] == 2) {
				?>
				<li class="dropdown">
					<a href="ajax/staff_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['STAFF_MANAGE'] ?></span>
					</a>
				</li>
				<?php
				}
				?>
				<li class="dropdown">
					<a href="ajax/user_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['USER_MANAGE'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/driver_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_DRIVER'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/vehicle_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_VEHICLE'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/itinerary_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_ITINERARY'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/map.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['ITINERARY_TRACKING'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/comment_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_COMMENT'] ?></span>
					</a>
				</li>
				<li class="dropdown">
					<a href="ajax/feedback_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_FEEDBACK'] ?></span>
					</a>
				</li>
				<!-- <li class="dropdown">
					<a href="ajax/message_list.php" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['MANAGE_MESSAGE'] ?></span>
					</a>
				</li> -->
				<?php
				if ($_SESSION["StaffProfile"]["role"] == 2) {
				?>
				<li class="dropdown">
					<a href="controller/statistic.php?view=user" class="ajax-link">
						<i class="fa fa-bar-chart-o"></i>
						<span class="hidden-xs"><?php echo $lang['STATISTC_SYS'] ?></span>
					</a>
				</li>
				<?php
				}
				?>
				<li>
					<a id="locked-screen" class="submenu" href="#">
						<i class="fa fa-power-off"></i>
						<span class="hidden-xs"><?php echo $lang['LOCK_SCREEN'] ?></span>
					</a>
				</li>
				<li>
					<a href="controller/logout.php">
						<i class="fa fa-power-off"></i>
						<span class="hidden-xs"><?php echo $lang['LOGOUT'] ?></span>
					</a>
				</li>
			</ul>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			<div id="about">
				<div class="about-inner">
					<h4 class="page-header"><?php echo $lang['RS'] ?></h4>
					<p><?php echo $lang['RS_TEAM'] ?></p>
				</div>
			</div>
			<div class="preloader">
				<img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
			</div>
			<div id="ajax-content"></div>
		</div>
		<!--End Content-->
	</div>
</div>
<!--End Container-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/toast/javascript/jquery.toastmessage.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/justified-gallery/jquery.justifiedGallery.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="plugins/tinymce/jquery.tinymce.min.js"></script>
<!-- All functions for this theme + document.ready processing -->
<script src="js/devoops.js"></script>
<!--Reference the SignalR library. -->
<script src="js/jquery.signalR-2.0.3.min.js"></script>
<!--Reference the autogenerated SignalR hub script. -->
<script src="http://localhost:8080/signalr/hubs"></script>
<script>
$(document).ready(function () {
	//Set the hubs URL for the connection
	$.connection.hub.url = "http://localhost:8080/signalr";

	// Declare a proxy to reference the hub.
	chat = $.connection.myHub;

	$.connection.hub.logging = true;

	$('#locked-screen').on('click', function (e) {
		e.preventDefault();
		$('body').addClass('body-screensaver');
		$('#screensaver').addClass("show");
		ScreenSaver();
	});
});
</script>
</body>
</html>