<?php

include_once('php/config.php');
include_once('php/session.php');

$_SESSION['moduleId'] = 1;
$_SESSION['lessonName'] = "Text Output";

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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
		</script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
		</script>
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
				<?php echo $_SESSION['moduleId'] . "." . $_SESSION['lessonName'] ; 
				?>
			</label>

			<!-- Coin Count -->
			<label style="float:right; padding-left: 5px; " id="coinCount">
				<?php $userClass->getCoinCount(); ?>
			</label>
			<img src="img/Gold_coin_icon.png"/>
		</header>

		<section class="main hbox space-between">

			<aside class="aside">
				<h2><?php echo $_SESSION['lessonName']; ?></h2>
				<!-- Description -->
				<div class="dialogue" id="instructions">
					<!-- <p style="margin-top:5px; ">Welcome To CodeBit!</p> -->
					<p style="margin-top:5px;"">
						For the first lesson we are going to learn how to output
						text in a console. This is a powerful tool in testing 
						your code, as you can check whether the output is
						correct or not.
					</p>
					<p>
						In programming, there are reserved words with special 
						meaning called keywords. Keywords must be spelt correct 
						to perform their special function. Additionally, 
						keywords are case sensitive.
					</p>
					<p>
						The keyword we are going to use in this lesson is 
						<code style="font-size:12px;">print</code>, which outputs text to a console.
						To begin outputting text, type the keyword followed by a 
						single space. To specify output text use <code style="font-size:12px;">"</code> on each side 
						of the text you want to output. 
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
									// echo '<li>'.($count).'/'.$totalTasks.'</li>';
									echo '<li></li>';
								}
								
							}
						?>
					</ol>
				</div>

				<!-- Hints Area -->
				<div class="dialogue" style="margin:1em;border:none;  ">
				 	<button id="hintTitle" type="button" class="btn hintHeader collapsed" 
				 			data-toggle="collapse" data-target="#hints">
				 			Hints
				 	</button>
				  	<div id="hints" class="collapse" >
				  		<!-- Link Button -->
				  		<button type="button" onclick="showHint('link'); ">
				  			<table style="width:100%;">
							 	<tr>
							     	<th style="width:80%;text-align:center">
							     		<label>Link</label>
							     	</th>
							      	<th>		
							      		<img style="float:left;" src="img/Gold_coin_icon.png"/>
							      		<label style="padding-left:1em; float:left;">
											0
										</label> 	
									</th>
							   </tr>
							</table>
				  		</button>
				  		<!-- Advice Button -->
				  		<button type="button" onclick="showHint('advice');" id="adviceButton">
				
				  			<table style="width:100%;">
							 	<tr>
							     	<th style="width:80%;text-align:center">
							     		<label>Advice</label>
							     	</th>
							      	<th>		
							      		<img style="float:left;" src="img/Gold_coin_icon.png"/>
							      		<label style="padding-left:1em; float:left;">
											<?php 
											$_GET['hintType'] = 'advice';
											include('isHintPurchased.php');
											?>
										</label> 	
									</th>
							   </tr>
							</table>
				  		</button>
				  		<!-- Solution Button -->
				  		<button type="button" onclick="showHint('solution');" id="solutionButton">
				  			<table style="width:100%;">
							 	<tr>
							     	<th style="width:80%;text-align:center">
							     		<label>Solution</label>
							     	</th>
							      	<th>		
							      		<img style="float:left;" src="img/Gold_coin_icon.png"/>
							      		<label style="padding-left:1em; float:left;">
											<?php 
											$_GET['hintType'] = 'solution';
											include('isHintPurchased.php');
											?>
										</label> 	
									</th>
							   </tr>
							</table>
				  		</button>
				  	</div>
				</div>
			</aside>

			<!-- Text Editor Area -->
			<div class="article vbox">
				<!-- Text Editor -->
				<article  id="editor" style="height:100%;"></article>

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
			  	<!-- Window Header -->
			    <div class="modal-content">
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
			      	<!-- Window Footer -->
			      	<div class="modal-footer">
				        <form class="btn btn-primary">
							<input  style="background:none; border:none;" type="button" value="Continue" onclick="window.location.href='http://localhost/website/module1_lesson3.php'" />
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
		   		 	<button  class="progressbar" onclick="location.href='http://localhost/website/module1_lesson1.php';" type="button" ></button>
			   		<button  class="progressbar" type="button" id="currentLevel"></button>  	
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