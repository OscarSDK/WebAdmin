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

	if (isset($_SESSION["staff"])) {
		$staff = $_SESSION["staff"];
	} 
?>

<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#"><?php echo $lang['DASHBOARD'] ?></a></li>
			<li><a href="#"><?php echo $lang['STAFF_MANAGE'] ?></a></li>
			<li><a href="#"><?php echo $lang['STAFF_DETAILS'] ?></a></li>
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
				<form method='POST' action='controller/staff.php' class="form-horizontal" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<input type="file" name="imageID" id="upImage">
							<img id="avatar" onclick="$('#fileToUpload').trigger('click')" class="img-rounded col-sm-4" 
							src="data:image/jpeg;base64,<?php echo isset($staff['link_avatar'])?$staff['link_avatar']:'' ?>" alt="">
							<input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" />
							<input id="link_avatar" name="link_avatar" type="hidden" value="<?php echo isset($staff['link_avatar'])?$staff['link_avatar']:'' ?>">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['NAME'] ?></label>
								<div class="col-sm-6">
								<input type="text" class="form-control" placeholder="Full name" value="<?php echo isset($staff['fullname'])?$staff['fullname']:'' ?>"
									data-toggle="tooltip" data-placement="bottom" title="Họ và tên" name="fullname">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['EMAIL'] ?></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="Email" value="<?php echo isset($staff['email'])?$staff['email']:'' ?>"
									data-toggle="tooltip" data-placement="bottom" title="Địa chỉ email" name="email">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['PERSONAL_ID'] ?></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="Chứng minh nhân dân" value="<?php echo isset($staff['personalID'])?$staff['personalID']:'' ?>"
									data-toggle="tooltip" data-placement="bottom" title="Chứng minh nhân dân" name="personalID">
								</div>
							</div>
							<?php
							if (isset($staff['created_at'])) {
							?>
							<div class="form-group">
								<label class="col-sm-4 control-label" style="text-align:left"><?php echo $lang['CREATE_DAY'] ?></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" value="<?php echo $staff['created_at'] ?>"
									disabled data-toggle="tooltip" data-placement="bottom" title="Ngày tạo tài khoản">
								</div>
							</div>
							<?php } ?>
							<?php
							if (isset($staff['staff_id'])) {
							?>
							<input type='hidden' name='staff_id' value='<?php echo $staff['staff_id'] ?>'/>
							<input type='hidden' name='act' value='edit'/>
							<?php 
							} else { 
							?>
							<input type='hidden' name='act' value='create'/>
							<?php } ?>
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
							<?php
							if (isset($staff['staff_id'])) {
							?>
							<span><i class="fa fa-clock-o"></i></span>
								<?php echo $lang['UPDATE'] ?>
							</button>
							<?php 
							} else { 
							?>
							<span><i class="fa fa-clock-o"></i></span>
								<?php echo $lang['NEW'] ?>
							</button>
							<?php } ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//Set image for field
function readURL(input,id) {
	
	var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    var file = input.files[0];

    if(file.size > 358400){	

    	showError("File size is not big than 350KB!");

    }else {

    	if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else {
        	showError("Please add the image!");
            }	
    } 
}
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
function readURL(input,id) {

    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    var file = input.files[0];

    if(file.size > 358400){ 

     showError("File size is not big than 350KB!");

    } else {

     if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(id).attr('src', e.target.result);
                $("#link_avatar").val(e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else {
         alert("Please add the image!");
        } 
    }
}
$(document).ready(function() {
	$('#fileToUpload').change(function(){
		readURL(this,"#avatar");              	             				            
	});

	$('#upImage').change(function(){
	    readURL(this,'#avatar');
	});
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
