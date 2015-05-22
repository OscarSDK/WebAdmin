<?php
session_start();
require_once '../include/Config.php';
if (!isset($_SESSION["staff_api_key"])) {
	header('Location: ../ajax/login.php');
	die();
}

if ((isset($_GET['act']) && isset($_GET['vehicle_id'])) || (isset($_POST['act']) && isset($_POST['vehicle_id']))) {
	$act = !isset($_GET['act'])?$_POST['act']:$_GET['act'];
	$vehicle_id = !isset($_GET['act'])?$_POST['vehicle_id']:$_GET['vehicle_id'];

	if ($act == 'view') {
		$api_key = $_SESSION["staff_api_key"];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/vehicle/".$vehicle_id."?lang=".$_COOKIE['lang']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: '.$api_key));

		// execute the request
		$result = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);
		$vehicle = json_decode($result, true);

		$vehicle = $vehicle['vehicle'];

		$vehicle['vehicle_id'] = $vehicle_id;

		if(isset($vehicle)) {
			$_SESSION['vehicle'] = $vehicle;
		}
		
		header('Location: ../index.php#ajax/vehicle_edit.php');
		die();
	} else if ($act == 'edit') {
		$status = $_POST['status'];
		
		if (isset($_POST['identify'])) {
			$status = 2;
		} else {
			$status = 1;
		}

		$data = array(
			'status' => $status
			);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/vehicle/".$vehicle_id."?lang=".$_COOKIE['lang']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$_SESSION['staff_api_key']));
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

		// execute the request
		$result = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		$json = json_decode($result);

		if (!$json->{'error'}) {
			$_SESSION['message'] = $json->{'message'};
		} else {
			$_SESSION['message'] = $json->{'message'};
		}

		header('Location: ../index.php#ajax/vehicle_list.php');
		die();
	} else {
		header('Location: ../index.php#ajax/vehicle_list.php');
		die();
	}
} else {
	header('Location: ../index.php#ajax/vehicle_list.php');
	die();
}
?>