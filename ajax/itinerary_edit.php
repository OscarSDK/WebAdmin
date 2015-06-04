<?php
	session_start();
	require_once '../include/Config.php';
	if (!isset($_SESSION["staff_api_key"])) {
		header('Location: ../ajax/login.php');
		die();
	}

	require_once '../include/Config.php';
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

	if (!isset($_SESSION["itinerary"])) {
		header('Location: ../index.php#ajax/itinerary_list.php');
		die();
	} else {
		$itinerary = $_SESSION["itinerary"];
	}
?>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#"><?php echo $lang['DASHBOARD'] ?></a></li>
			<li><a href="#"><?php echo $lang['MANAGE_ITINERARY'] ?></a></li>
			<li><a href="#"><?php echo $lang['ITINERARY_DETAILS'] ?></a></li>
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
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-content">
				<form method="POST" action="controller/itinerary.php" class="form-horizontal" role="form">
					<div class="form-group">

						<div class="col-sm-8">
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DRIVER'] ?>:</label>
								<div class="col-sm-6">
								<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DRIVER'] ?>" value="<?php echo $itinerary['fullname'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DRIVER'] ?>" name="driver_id">
								</div>
								<div class="col-sm-1">
									<a target="_blank" href="ajax/personal_id.php#<?php echo $itinerary['link_avatar'] ?>" onclick="return popup('ajax/personal_id.php#<?php echo $itinerary['link_avatar'] ?>')" type="button" 
										class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i>
									</a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['CUSTOMER'] ?>:</label>
								<div class="col-sm-6">
								<input disabled type="text" class="form-control" placeholder="<?php echo $lang['CUSTOMER'] ?>" value="<?php echo $itinerary['c_fullname'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['CUSTOMER'] ?>" name="customer_id">
								</div>
								<div class="col-sm-1">
									<a target="_blank" href="ajax/personal_id.php#<?php echo $itinerary['c_linkavatar'] ?>" onclick="return popup('ajax/personal_id.php#<?php echo $itinerary['c_linkavatar'] ?>')" type="button" 
										class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i>
									</a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DEPARTURE'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DEPARTURE'] ?>" value="<?php echo $itinerary['start_address'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DEPARTURE'] ?>" name="phone">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DESTINATION'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DESTINATION'] ?>" value="<?php echo $itinerary['end_address'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DESTINATION'] ?>" name="email">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['PICK_UP'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['PICK_UP'] ?>" value="<?php echo $itinerary['pick_up_address'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['PICK_UP'] ?>" name="phone">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DROP'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DROP'] ?>" value="<?php echo $itinerary['drop_address'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DROP'] ?>" name="email">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left">Ngày tạo:</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" value="<?php echo $itinerary['leave_date'] ?>"
									disabled data-toggle="tooltip" data-placement="bottom" title="Ngày tạo tài khoản">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DURATION'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DURATION'] ?>" value="<?php echo $itinerary['duration'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DURATION'] ?>:" name="personalID">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DISTANCE'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DISTANCE'] ?>" value="<?php echo $itinerary['distance'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DISTANCE'] ?>:" name="personalID">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['COST'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['COST'] ?>" value="<?php echo $itinerary['cost'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['COST'] ?>:" name="personalID">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['DESCRIPTION'] ?>:</label>
								<div class="col-sm-6">
									<input disabled type="text" class="form-control" placeholder="<?php echo $lang['DESCRIPTION'] ?>" value="<?php echo $itinerary['description'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['DESCRIPTION'] ?>:" name="personalID">
								</div>
							</div>
							
							<input type='hidden' name='user_id' value='<?php echo $itinerary['user_id'] ?>'/>
							<input type='hidden' name='act' value='edit'/>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-2">
							<a href="" type="cancel" class="btn btn-default btn-label-left">
							<span><i class="fa fa-clock-o txt-danger"></i></span>
								<?php echo $lang['BACK'] ?>
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// Run Select2 plugin on elements
function DemoSelect2(){
	$('#s2_with_tag').select2({placeholder: "Select OS"});
	$('#s2_country').select2();
}
// Run timepicker
function DemoTimePicker(){
	$('#input_time').timepicker({setDate: new Date()});
}
function popup(url) {
	newwindow=window.open(url,'name','height=300,width=500');
	if (window.focus) {newwindow.focus()}
	return false;
}
$(document).ready(function() {
	// Create Wysiwig editor for textare
	TinyMCEStart('#wysiwig_simple', null);
	TinyMCEStart('#wysiwig_full', 'extreme');
	// Add slider for change test input length
	FormLayoutExampleInputLength($( ".slider-style" ));
	// Initialize datepicker
	$('#input_date').datepicker({setDate: new Date()});
	// Load Timepicker plugin
	LoadTimePickerScript(DemoTimePicker);
	// Add tooltip to form-controls
	$('.form-control').tooltip();
	LoadSelect2Script(DemoSelect2);
	// Load example of form validation
	LoadBootstrapValidatorScript(DemoFormValidator);
	// Add drag-n-drop feature to boxes
	WinMove();
});
</script>
