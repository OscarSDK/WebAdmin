<?php
session_start();
require_once '../include/Config.php';
if (!isset($_SESSION["staff_api_key"])) {
	header('Location: ../ajax/login.php');
	die();
}

if ((isset($_GET['act']) && isset($_GET['feedback_id'])) || (isset($_POST['act']) && isset($_POST['feedback_id']))) {
	$act = !isset($_GET['act'])?$_POST['act']:$_GET['act'];
	$feedback_id = !isset($_GET['act'])?$_POST['feedback_id']:$_GET['feedback_id'];

	if ($act == 'view') {
		$api_key = $_SESSION["staff_api_key"];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/feedback/".$feedback_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: '.$api_key));

		// execute the request
		$result = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);
		$feedback = json_decode($result, true);

		$feedback = $feedback['feedback'];

		$feedback['feedback_id'] = $feedback_id;

		if(isset($feedback)) {
			$_SESSION['feedback'] = $feedback;
		}
		
		header('Location: ../index.php#ajax/vehicle_edit.php');
		die();
	} else if ($act == 'delete') {
		//Initial curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/feedback/".$feedback_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$_SESSION['staff_api_key']));

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

		header('Location: ../index.php#ajax/feedback_list.php');
		die();
	} else {
		header('Location: ../index.php#ajax/feedback_list.php');
		die();
	}
} else {
	header('Location: ../index.php#ajax/feedback_list.php');
	die();
}
?>