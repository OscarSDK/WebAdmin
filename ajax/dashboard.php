<?php
session_start();
// Set language for website
if(isset($_COOKIE['lang'])) {
	if ($_COOKIE['lang'] == "vi") {
		require_once '../include/lang_vi.php';
	} else {
		require_once '../include/lang_en.php';
	}
} else {
    setcookie('lang', 'en', time() + (86400 * 365), "/");
}
?>
<style type="text/css">
img.img-responsive { display: table-cell; width: 25%; }
</style>
<!--Start Breadcrumb-->
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="index.html"><?php echo $lang['HOME'] ?></a></li>
			<li><a href="#"><?php echo $lang['DASHBOARD'] ?></a></li>
		</ol>
		<div id="social" class="pull-right">
			<a href="#"><i class="fa fa-google-plus"></i></a>
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-linkedin"></i></a>
			<a href="#"><i class="fa fa-youtube"></i></a>
		</div>
	</div>
</div>
<!--End Breadcrumb-->
<!--Start Dashboard 1-->
<div id="dashboard-header" class="row">
	<div class="col-xs-2">
		<img class="img-responsive" src="img/statis.png">
	</div>
	<div class="col-xs-10 col-sm-4 col-md-5">
		<h1><?php echo $lang['RS'] ?></h1>
	</div>
</div>
