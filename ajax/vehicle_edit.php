<?php
	session_start();
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

	if (!isset($_SESSION["staff_api_key"])) {
		header('Location: ../ajax/login.php');
		die();
	}

	if (!isset($_SESSION["vehicle"])) {
		header('Location: ../index.php#ajax/vehicle_list.php');
		die();
	} else {
		$user = $_SESSION["vehicle"];
	}
?>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#"><?php echo $lang['DASHBOARD'] ?></a></li>
			<li><a href="#"><?php echo $lang['MANAGE_VEHICLE'] ?></a></li>
			<li><a href="#"><?php $lang['VEHICLE_DETAILS'] ?></a></li>
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
				<form method='POST' action='controller/vehicle.php' class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['LICENSE_PLATE'] ?></label>
								<div class="col-sm-6">
								<input disabled type="text" class="form-control" placeholder="License plate" value="<?php echo $user['license_plate'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="Biến số" name="license_plate">
								</div>
								<div class="col-sm-1">
									<a target="_blank" href="ajax/personal_id.php#<?php echo $user['license_plate_img'] ?>" onclick="return popup('ajax/personal_id.php#<?php echo $user['license_plate_img'] ?>')" type="button" 
										class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i>
									</a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['TYPE'] ?></label>
								<div class="col-sm-6">
								<input disabled type="text" class="form-control" placeholder="Type" value="<?php echo $user['type'] ?>"
									data-toggle="tooltip" data-placement="bottom" title="Loại xe" name="type">
								</div>
								<div class="col-sm-1">
									<a target="_blank" href="ajax/personal_id.php#<?php echo $user['vehicle_img'] ?>" onclick="return popup('ajax/personal_id.php#<?php echo $user['vehicle_img'] ?>')" type="button" 
										class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i>
									</a>
								</div>
								<div class="col-sm-1">
									<a target="_blank" href="ajax/personal_id.php#<?php echo $user['motor_insurance_img'] ?>" onclick="return popup('ajax/personal_id.php#<?php echo $user['motor_insurance_img'] ?>')" type="button" 
										class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i>
									</a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['VALIDATED'] ?></label>
								<div class="col-sm-6">
									<div class="toggle-switch toggle-switch-success">
										<label>
											<input name="status" type="hidden" value="<?php echo $user['status']?>">
											<input <?php echo $user['status']==2?'checked':'' ?> type="checkbox" name="identify">
											<div class="toggle-switch-inner"></div>
											<div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['STATE'] ?></label>
								<div class="col-sm-6">
									<input type='hidden' name='status' value='<?php echo $user['status'] ?>'/>
									<?php
										$percent = round($user['status']/2*100);
									?>
									<div class="progress">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent ?>" 
											aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
											<span><?php echo $percent ?>%</span>
										</div>
									</div>
								</div>
							</div>
							<input type='hidden' name='vehicle_id' value='<?php echo $user['vehicle_id'] ?>'/>
							<input type='hidden' name='act' value='edit'/>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-2">
							<a href="index.php" type="cancel" class="btn btn-default btn-label-left">
							<span><i class="fa fa-clock-o txt-danger"></i></span>
								<?php echo $lang['BACK'] ?>
							</a>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-primary btn-label-left">
							<span><i class="fa fa-clock-o"></i></span>
								<?php echo $lang['UPDATE'] ?>
							</button>
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
