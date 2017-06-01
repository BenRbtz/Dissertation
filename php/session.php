<?php

// Logged in as user
if(!empty($_SESSION['accountId'])) {
	//Setting session varaibles
	$session_accountId=$_SESSION['accountId'];
	$session_coins=$_SESSION['coins'];

	include('userClass.php');
	$userClass = new userClass();
}

// Not Logged in as a user
if(empty($session_accountId)) {
	$url='login.php';
	header("Location: $url");
}

?>