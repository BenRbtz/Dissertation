<?php

include_once('php/config.php');
include_once('php/session.php');

$_SESSION['moduleId'] = 1;
$_SESSION['lessonName'] = "Using The Editor";

// Get lessonId and rewards
$tempLesson = $userClass->getLessonId($_SESSION['moduleId'], 
													$_SESSION['lessonName']);
$_SESSION['lessonId'] = $tempLesson->lessonId;
$_SESSION['lessonReward'] = $tempLesson->lessonReward;

// Get task count
$tempTask = $userClass->getTaskCount($_SESSION['accountId'], $_SESSION['lessonId']);
$_SESSION['completedTotal'] =$tempTask->userCompletedTaskCount;
$_SESSION['totalTasks'] =$tempTask->totalTaskCount;
$_SESSION['taskNum'] = $tempTask->userCompletedTaskCount;

if($tempTask->userCompletedTaskCount < $tempTask->totalTaskCount ){
	// If user hasn't done all tasks for lesson
	$_SESSION['taskNum'] += 1;
} 


// Logout button was pressed
if (isset($_POST['logout'])) {
	$userClass->logout(); // Logout 
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CodeBits</title>
		
		<link rel="stylesheet" type="text/css" href="css/stylehome.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>

	<body class="vbox viewport">
		<header>
		<!-- Logout Button -->
			<form style="float: left;padding:0;" class="btn btn-default" method="post">
			    <input style="background:none; border:none;" type="submit" value="Log Out" name="logout">
			</form>

			<!-- Theme Switch -->
<!-- 			<section class="float_center">
				<input type="checkbox" name="toggle" id="toggle">
				<label for="toggle"></label>
			</section> -->

			<!-- Current Lesson -->
			<label  href="#home" style="padding: 5px; float: left;">
				<?php echo $_SESSION['moduleId'] . "." . $_SESSION['lessonName']; ?>
			</label>

			<!-- Coin Count -->
			<label style="float:right; padding-left: 5px;" id="coinCount">
				<?php $userClass->getCoinCount(); ?>
			</label>
			<img src="img/Gold_coin_icon.png"/>
		</header>

		<section class="main hbox space-between">

			<aside class="aside">
				<h2><?php echo $_SESSION['lessonName']; ?></h2>
				<!-- Description -->
				<div class="dialogue" id="instructions">
					<p style="margin-top:5px; ">Welcome To CodeBit!</p>
					<p>
						We are going to teach you how to program in Python 2.7. 
						You will be taught how to program from not knowing how to 
						program, to programming at an advance level.
					</p>
					<p>
						To write code use the text editor. The text editor is the
						section on the right hand-side starting with <code style="font-size:12px;">def memoize(fn, arg):</code>.
					</p>
					<p>
						If you have any problems with the tasks, use the hints 
						section for some guidance. However, some hints cost 
						coins. The only way to gain coins is to complete lessons, 
						so use your coins wisely!
					</p>
<!-- 					<p>
						If you would prefer to change the theme colour of 
						CodeBit, click the switch at the top of the page.
					</p> -->
					<p>
						Are you ready to learn to code? Click "Run Code" to see what 
						the code will do!
					</p>
				</div>

				<!-- Tasks Area -->
				<h3>Tasks</h3>
				<div class="dialogue" id="tasks">
					<ol style="padding:1em; padding-left: 2em; margin:0; list-style: none;" 
					id="task">
						<?php 

							$_SESSION['taskQuestions'] = $userClass->getTasks($_SESSION['lessonId']); 
							$array = $_SESSION['taskQuestions'];
							$completedTotal = $_SESSION['completedTotal'];
							$totalTasks = $_SESSION['totalTasks'];
							$count =0;

							foreach ($array as $value) {
								$count++;

								if($count == ($completedTotal + 1)) {
									echo '<li >'.($count).'/'.$totalTasks.' '.$value['taskQuestion'].'</li>';
								} elseif ($count <= $completedTotal) {
									echo '<li style="text-decoration:line-through;">'.($count).'/'.$totalTasks.' '.$value['taskQuestion'].'</li>';

								} else {
									echo '<li></li>';
								}
								
							}
						?>
					</ol>
				</div>
			</aside>

			<!-- Text Editor Area -->
			<div class="article vbox">
				<!-- Text Editor -->
				<article  id="editor" style="height:100%;">def memoize(fn, arg):
	memo = {}
 	if arg not in memo:
 		memo[arg] = fn(arg)
  	return memo[arg]


fibm = memoize(fib,5)
print fibm</article>

				<!-- Bar  -->
				<div style="height:50px;background: #333;">
					<!-- Preview field -->
					<pre id="output" style="float:left; width:20em; height:4em;"></pre> 
					<!-- Run Button -->
					<button class="runButton" type="button" onclick="showAnswer(editor.getValue());">
						Run Code
					</button>
				</div>
			</div>

			<!-- Lesson Completion Window -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <div class="modal-content">
			    	<!-- Window Header -->
			     	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Lesson Completed</h4>
			      	</div>
			      	<!-- Window Content -->
			      	<div class="modal-body">
			        	<p>Congratulations for completing this lesson, you've been rewarded:</p>
			      		<img style="float:left;margin-right:0.5em;" src="img/Gold_coin_icon.png"/><p><?php echo $_SESSION['lessonReward']; ?></p>

			        	<p style="margin-top:2em;">Press the 'Continue' button to proceed to the next lesson.</p>
			      	</div>
			      	<!-- Window Footer with button -->
			      	<div class="modal-footer">
				        <form class="btn btn-primary">
							<input  style="background:none; border:none;" type="button" value="Continue" onclick="window.location.href='http://localhost/website/module1_lesson2.php'" />
						</form>
			     	</div>
			    </div>

			  </div>
			</div>

		</section>

	
		<footer>
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button" id="currentLevel"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
			   		<button  class="progressbar" type="button" id="currentLevel"></button>  
			   		<button  class="progressbar" onclick="location.href='http://localhost/website/module1_lesson2.php';" type="button" ></button>	
			   		<button  class="progressbar" onclick="location.href='http://localhost/website/module1_lesson3.php';" type="button" ></button>
			   		</div>
			    </div>
    		</span>
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>		
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>		
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>		
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>		
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>			
			<span style="padding-top:1.5em;">
				<button  class="progressbar" type="button"></button>
		   		 <div id="tooltip">
		   		 	<label>Lessons</label><br>
		   		 	<div>
		   		 	<button  class="progressbar" type="button" ></button>
			   		<button  class="progressbar" type="button" ></button>  	
			   		<button  class="progressbar" type="button" ></button>
			   		</div>
			    </div>
    		</span>  
		</footer>
		<script src="resources/ace-builds/src-noconflict/ace.js" 
						type="text/javascript"></script>
		<script src="js/ace_editor_config.js" type="text/javascript"></script>
		<script src="js/ajax_script.js" type="text/javascript"></script>

	</body>
</html>
