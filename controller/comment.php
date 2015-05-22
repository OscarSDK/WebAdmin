<?php
session_start();
require_once '../include/Config.php';
if (!isset($_SESSION["staff_api_key"])) {
	header('Location: ../ajax/login.php');
	die();
}

if ((isset($_GET['act']) && isset($_GET['comment_id'])) || (isset($_POST['act']) && isset($_POST['comment_id']))) {
	$act = !isset($_GET['act'])?$_POST['act']:$_GET['act'];
	$comment_id = !isset($_GET['act'])?$_POST['comment_id']:$_GET['comment_id'];

	if ($act == 'delete') {
		//Initial curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, REST_HOST."/RESTFul/v1/staff/comment/".$comment_id."?lang=".$_COOKIE['lang']);
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

		header('Location: ../index.php#ajax/comment_list.php');
		die();
	} else {
		header('Location: ../index.php#ajax/comment_list.php');
		die();
	}
} else {
	header('Location: ../index.php#ajax/comment_list.php');
	die();
}
?>