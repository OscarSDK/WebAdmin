<?php
session_start();
require_once '../include/Config.php';
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
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#"><?php echo $lang['DASHBOARD'] ?></a></li>
			<li><a href="#"><?php echo $lang['MANAGE_COMMENT'] ?></a></li>
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
	<div class="col-xs-12">
		<div class="box">
			<div class="box-content no-padding">
				<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
					<thead>
						<tr>
							<th><?php echo $lang['ORDINAL'] ?></th>
							<th><?php echo $lang['LICENSE_PLATE'] ?></th>
							<th><?php echo $lang['TYPE'] ?></th>
							<th><?php echo $lang['STATE'] ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!-- Start: list_row -->
						<?php
						require_once '/Config.php';
						$api_key = $_SESSION["staff_api_key"];
						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/vehicle");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$api_key));

						// execute the request
						$result = curl_exec($ch);

						// close curl resource to free up system resources
						curl_close($ch);

						$json = json_decode($result);
						$res = $json->{'vehicles'};
						$i = 1;
						foreach ($res as $value) {
						?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><?php echo $value->{'license_plate'}==NULL?' ':$value->{'license_plate'} ?></td>
							<td><?php echo $value->{'type'}==NULL?' ':$value->{'type'} ?></td>
							<td><?php 
									$percent = round($value->{'status'}/2*100);
									if ($percent <= 50) {
										$color = 'progress-bar-danger';
									} else {
										$color = 'progress-bar-success';
									}
								?>		
								<div class="progress">
									<div class="progress-bar <?php echo $color ?>" role="progressbar" aria-valuenow="<?php echo $percent ?>" 
											aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
										<span><?php echo $percent ?>%</span>
									</div>
								</div>
							</td>
							<td><a href="controller/vehicle.php?vehicle_id=<?php echo $value->{'vehicle_id'} ?>&act=view" 
									class="btn btn-warning btn-app-sm btn-circle"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
						<?php
						}
						?>
					<!-- End: list_row -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings
function AllTables(){
	TestTable1();
	TestTable2();
	TestTable3();
	LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
	$('select').select2();
	$('.dataTables_filter').each(function(){
		$(this).find('label input[type=text]').attr('placeholder', 'Search');
	});
}
$(document).ready(function() {
	// Load Datatables and run plugin on tables 
	LoadDataTablesScripts(AllTables);
	// Add Drag-n-Drop feature
	WinMove();
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    <?php 
		if (isset($_SESSION["message"])) {
	?>
    $().toastmessage('showSuccessToast', '<?php echo $_SESSION["message"] ?>')
    <?php
    		$_SESSION["message"] = null;
		}
	?>
})
</script>