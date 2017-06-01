<?php

include_once('php/config.php');
include_once('php/session.php');
// Session variables
$moduleNum = $_SESSION['moduleId'];
$lessonNum = $_SESSION['lessonId'];
$taskNum = $_SESSION['taskNum'];
// Get method varaible
$hintType = $_GET['hintType'];

// Checks if hintType is valid
if ($hintType == "link" || $hintType == "advice" || $hintType == "solution") {

	//Get hint solution
	$hint = $userClass->getHint($session_accountId, $lessonNum, $taskNum, $hintType);

	//Check if hint is not used
	if($hint->hintUsed < 1) {
		echo '-'.$hint->hintCost;
	} else {
		echo '0';
	}
} 

?>