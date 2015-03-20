<?php
session_start();
?>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<a href="#" class="show-sidebar">
			<i class="fa fa-bars"></i>
		</a>
		<ol class="breadcrumb pull-left">
			<li><a href="#">Dashboard</a></li>
			<li><a href="#">Tables</a></li>
			<li><a href="#">Data Tables</a></li>
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
							<th>No</th>
							<th>Full Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Personal ID</th>
							<th>Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!-- Start: list_row -->
						<?php
						require_once '/Config.php';
						$api_key = $_SESSION["api_key"];
						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL, "http://localhost/RESTFul/v1/staff/user");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$api_key));

						// execute the request
						$result = curl_exec($ch);

						// close curl resource to free up system resources
						curl_close($ch);

						$json = json_decode($result);
						$res = $json->{'users'};
						$i = 1;
						foreach ($res as $value) {
						?>
						<tr>
							<td><?php echo $i++ ?></td>
							<td><img class="img-rounded" src="data:image/jpeg;base64,<?php echo $value->{'link_avatar'}==NULL?' ':$value->{'link_avatar'} ?>" alt="">
								<?php echo $value->{'fullname'}==NULL?' ':$value->{'fullname'} ?>
							</td>
							<td><?php echo $value->{'email'}==NULL?' ':$value->{'email'} ?></td>
							<td><?php echo $value->{'phone'}==NULL?' ':$value->{'phone'} ?></td>
							<td><?php echo $value->{'personalID'}==NULL?' ':$value->{'personalID'} ?></td>
							<td><?php 
									if ($value->{'status'}==2) {
								?>		
								<div class="progress">
									<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
										<span>66%</span>
									</div>
								</div>
								<?php
									} else if ($value->{'status'}==3) {
								?>
								<div class="progress">
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
										<span>100%</span>
									</div>
								</div>
								<?php
									} else {
								?>
								<div class="progress">
									<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
										<span>33%</span>
									</div>
								</div>
								<?php
									}
								?>
							</td>
							<td><a href="controller/user.php?user_id=<?php echo $value->{'user_id'} ?>&act=view" 
									class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-eye"></i></a>
								<a href="controller/user.php?user_id=<?php echo $value->{'user_id'} ?>&act=edit" 
									class="btn btn-warning btn-app-sm btn-circle"><i class="fa fa-edit"></i></a>
								<a href="controller/user.php?user_id=<?php echo $value->{'user_id'} ?>&act=delete" 
									class="btn btn-danger btn-app-sm btn-circle"><i class="fa fa-trash-o"></i></a> 
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