<?php
session_start();
if (!isset($_SESSION["api_key"])) {
	header('Location: ../ajax/login.php');
	die();
}

if (isset($_GET['act']) && isset($_GET['user_id'])) {
	$act = $_GET['act'];
	$user_id = $_GET['user_id'];

	if ($act == 'view') {
		$api_key = $_SESSION["api_key"];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://localhost/RESTFul/v1/staff/user/".$user_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$api_key));

		// execute the request
		$result = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);
		$user = json_decode($result);

		if(isset($user)) {
			$_SESSION['user'] = $user;
		}
		
		header('Location: ../index.php#ajax/user_edit.php');
		die();
	} else if ($act == 'edit') {

	} else if ($act == 'delete') {
		//Initial curl
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "http://localhost/RESTFul/v1/staff/user/".$user_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: '.$_SESSION['api_key']));

		// execute the request
		$result = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		$json = json_decode($result);

		if (!$json->{'error'}) {
			$_SESSION['message'] = $json->{'message'};
			
			header('Location: ../index.php#ajax/user_list.php');
			die();
		} else {
			$_SESSION['message'] = $json->{'message'};
			
			header('Location: ../ajax/login.php');
			die();
		}
	} else {
		header('Location: ../index.php');
		die();
	}
} else {
	header('Location: ../index.php');
	die();
}
?>