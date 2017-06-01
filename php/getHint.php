<?php

include_once('config.php');
include_once('session.php');

// Session variables
$moduleNum = $_SESSION['moduleId'];
$lessonNum = $_SESSION['lessonId'];
$taskNum = $_SESSION['taskNum'];
$coins = $_SESSION["coins"];
$fuck = $session_accountId;
// Get method varaible
$hintType = $_GET['hintType'];

// Checks if hintType is valid
if ($hintType == "link" || $hintType == "advice" || $hintType == "solution") {

	//Get hint solution
	$hint = $userClass->getHint($session_accountId, $lessonNum, $taskNum, $hintType);

	//Check if hint is not used
	if($hint->hintUsed < 1) {
		// if user has enough coins
		if ( ($coins - $hint->hintCost) >= 0){
			// update coin count
		 	$userClass->updateCoins($session_accountId, $coins - $hint->hintCost);

		 	if($hintType != "link"){
			 	//Add to audit log
			 	
			 	$userClass->addAuditHintRecord($hint->hintCost, $session_accountId, 
			 		$hint->hintId);
		 	}	
		 	// Add user to hint Account_has_Hint table
		 	$userClass->addUserToHint($session_accountId, $hint->hintId);

		 	echo $hint->hintSolution;
		} 
	} else {
			echo $hint->hintSolution;
	}
} 

?>
