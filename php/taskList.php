<?php 

include_once('config.php');
include_once('session.php');
// stores complete task count and total tasks in lesson
// divides both counts with '|' divider 
$temp =$_SESSION['completedTotal'].'|'.$_SESSION['totalTasks'].'|';

// inserts every task question into variable
// questions are divided with '|'
foreach ($_SESSION['taskQuestions'] as $value) {
	$temp .= $value['taskQuestion']."|";
}
			
echo $temp;

?>