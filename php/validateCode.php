<?php

include_once('config.php');
include_once('session.php');

// Session variables
$lessonId = $_SESSION['lessonId'];
$taskNum = $_SESSION['taskNum'];
$task = $userClass->getTask($lessonId, $taskNum);
$coins = $_SESSION["coins"];

// Check if userCode is correct using RegEx
if (preg_match($task->taskAnswer , $_GET['userCode']) ) {
	//If user hasn't done all tasks for lesson
	$tempTask = $userClass->getTaskCount($_SESSION['accountId'], $_SESSION['lessonId']);
	if($tempTask->userCompletedTaskCount < $tempTask->totalTaskCount ){
		//Add user to Account_has_Task as task is completed
		$userClass->addUserToTask($session_accountId, $task->taskId);
	}
	
	// Get task count
	$tempTask = $userClass->getTaskCount($_SESSION['accountId'], $_SESSION['lessonId']);
	$_SESSION['taskNum'] = $tempTask->userCompletedTaskCount; //completed task count
	$_SESSION['completedTotal'] =$tempTask->userCompletedTaskCount; // total task count

	// If user hasn't done all tasks for lesson
	if($tempTask->userCompletedTaskCount < $tempTask->totalTaskCount ){
		$_SESSION['taskNum'] += 1;
		echo 1;
	// If user has done all tasks for lesson
	} else {
		$lessonComplete = $userClass->isLessonCompleted($_SESSION['accountId'], 
														$_SESSION['lessonId']);
		if($lessonComplete->lessonComplete < 1) {
			// update coin count
			$userClass->addUserToLesson($_SESSION['accountId'], $_SESSION['lessonId']);// Add user to lesson completion table
			$userClass->updateCoins($session_accountId, $coins + $lessonComplete->lessonReward); //update refreshes coin count
			$userClass->addAuditLessonRecord($lessonComplete->lessonReward, $session_accountId, $_SESSION['lessonId']); // add coin change in audit table
		} 
		echo 2;
	}
// incorrect code solution
} else {
	echo 0;
}

?>