<?php

class userClass
{
	/*
	* Gets the accountId for the user
	* @param string $username to get the accountId
	*
	* @return int accoundId user account id
	*/
	public function getAccountId($username) {
		try {
			$db = getDB(); // Connection to database

			// Prepared Statment
			$st = $db->prepare("
				SELECT accountId 
				FROM Account 
				WHERE username=:username
			"); 

			// Set prepared statement parameters
			$st->bindParam("username", $username,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$data=$st->fetch(PDO::FETCH_OBJ); // fetch statement data
			$db = null; // close connection to db
			
			return $data->accountId; 

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Add user and module to Account_has_Module table 
	* @param int $accountId accountId for the user
	* @param int $moduleId moduleId for a module
	*/
	public function addUserToModule($accountId, $moduleId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Account_has_Module(Account_accountId, Module_moduleId) 
				VALUES (:accountId,:moduleId)
			");

			// Set prepared statement parameters
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR) ;
			$st->bindParam("moduleId", $moduleId,PDO::PARAM_STR) ;

			$st->execute(); // execute statement
			$db = null; // close connection to db
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Add user and hint used to Account_has_Hint table 
	* @param int $accountId accountId for the user
	* @param int $hintId hintId for a hint
	*/
	public function addUserToHint($accountId, $hintId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Account_has_Hint(Account_accountId, Hint_HintId) 
				VALUES (:accountId, :hintId)
			");

			// Set prepared statement parameters
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("hintId", $hintId,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$db = null; // close connection to db

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}


	/*
	* Add user and task to Account_has_Task table 
	* @param int $accountId accountId for the user
	* @param int $taskId taskId for the task
	*/
	public function addUserToTask($accountId, $taskId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Account_has_Task(Account_accountId, Task_taskId) 
				VALUES (:accountId, :taskId)
			");

			// Set prepared statement parameters
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("taskId", $taskId,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$db = null; // close connection to db

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Add user and lesson to Account_has_Lesson table 
	* @param int $accountId accountId for the user
	* @param int $lessonId lessonId for the lesson
	*/
	public function addUserToLesson($accountId, $lessonId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Account_has_Lesson(Account_accountId, Lesson_lessonId) 
				VALUES (:accountId, :lessonId)
			");

			// Set prepared statement parameters
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("lessonId", $lessonId,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$db = null; // close connection to db

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Add a hint audit record
	* @param int $coinAmountChange amount to be subtracted
	* @param int $accountId account the audit is related to
	* @param int $hintId hint used
	*/
	public function addAuditHintRecord($coinAmountChange, $accountId, $hintId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Audit(coinAmountChange, comment, Account_accountId, Hint_hintId) 
				VALUES (:coinAmountChange, :comment, :accountId, :hintId)
			");
			$comment = "Used Hint";
			$coinAmountChange = "-".$coinAmountChange;
			// Set prepared statement parameters
			$st->bindParam("coinAmountChange", $coinAmountChange,PDO::PARAM_STR);
			$st->bindParam("comment", $comment,PDO::PARAM_STR);
			$st->bindValue("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("hintId", $hintId,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$db = null; // close connection to db

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}		
	}

	/*
	* Add a task audit record
	* @param int $coinAmountChange amount to be added
	* @param int $accountId account the audit is related to
	* @param int $lessonId completed
	*/
	public function addAuditLessonRecord($coinAmountChange, $accountId, $lessonId) {
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				INSERT INTO Audit(coinAmountChange, comment, Account_accountId, Lesson_lessonId) 
				VALUES (:coinAmountChange, :comment, :accountId, :lessonId)
			");
			$comment = "Completed Lesson";
			$coinAmountChange = "+".$coinAmountChange;
			// Set prepared statement parameters
			$st->bindParam("coinAmountChange", $coinAmountChange,PDO::PARAM_STR);
			$st->bindParam("comment", $comment,PDO::PARAM_STR);
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("lessonId", $lessonId,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$db = null; // close connection to db

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}		
	}

	/* 
	* Login to website using user credentials
	* @param string $username to compare to username on db
	* @param string $password to compare to password on db
	*
	* @return boolean $gainAccess whether the user can access website
	*/
	public function userLogin($username,$password) {
		try {
			$db = getDB(); // Connection to database
			$hash_password= hash('sha256', $password); //Password encryption 

			// prepared statement
			$st = $db->prepare("
				SELECT accountId, coins 
				FROM Account 
				WHERE username=:username 
				AND password=:hash_password
			"); 

			// Set prepared statement parameters
			$st->bindParam("username", $username,PDO::PARAM_STR);
			$st->bindParam("hash_password", $hash_password,PDO::PARAM_STR);

			$st->execute(); // execute sql statement
			$count=$st->rowCount(); // get number of records
			$data=$st->fetch(PDO::FETCH_OBJ); // fetch statement data
			$db = null; // close connection to db
			$gainAccess = false; // default access to website is false

			if($count) {
				// Storing user session value
				$_SESSION['accountId']=$data->accountId; 
				$_SESSION['coins']=$data->coins; 

				$gainAccess = true; // allow access to database
			} 
			return $gainAccess;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/* 
	* Register a user to website using user credentials
	* @param string $username to set the username
	* @param string $password to set the password
	*
	* @return boolean $gainAccess whether the user can access website
	*/
	public function userRegistration($username, $password) {
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT accountId
				FROM Account 
				WHERE username=:username
			"); 
			
			// Set prepared statement parameters
			$st->bindParam("username", $username,PDO::PARAM_STR);

			$st->execute(); // execute statement
			$count=$st->rowCount(); // get number of records
			$gainAccess = false; // default access to website is false

			// If record doesn't exist
			if($count<1) {
				$st = $db->prepare("
					INSERT INTO Account(username, password) 
					VALUES (:username,:hash_password)
				");

				$hash_password= hash('sha256', $password); //Password encryption		

				// Set prepared statement parameters
				$st->bindParam("username", $username,PDO::PARAM_STR);
				$st->bindParam("hash_password", $hash_password,PDO::PARAM_STR);

				$st->execute(); // execute statement

				//Add user to module database
				$this->addUserToModule($this->getAccountId($username), 1);
				
				$gainAccess = true; // allow access to database
			} 

			$db = null; // close connection to database
			return $gainAccess;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}

	/*
	* Gets task completed count for the user and the task count for the lesson
	* @param int $accountId to see how many tasks the user has done
	* @param int $lessonId to see how many tasks are in the lesson
	*
	* @return object $data(int userCompletedTaskCount, int totalTaskCount) 
	*/
	public function getTaskCount($accountId, $lessonId){
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT COUNT(
							CASE :accountId
							WHEN Account_accountId 
							THEN 1 ELSE NULL END
							) AS userCompletedTaskCount, 
        			 	(SELECT COUNT(*)
                        FROM Task
                        WHERE Lesson_lessonId=:lessonId) AS totalTaskCount
				FROM Task 
			    JOIN Account_has_Task
				ON Task.taskId = Account_has_Task.Task_taskId
				WHERE Lesson_lessonId=:lessonId
				"); 

			// Set prepared statement parameters
			$st->bindParam("accountId", $accountId,PDO::PARAM_STR);
			$st->bindParam("lessonId", $lessonId,PDO::PARAM_STR);
			$st->execute(); // execute statement

			$data = $st->fetch(PDO::FETCH_OBJ);// fetch statement records
			$db = null; // close connection to database

			return $data;
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Gets hint and if the user has used it already
	* @param int $accountId to see if user has used hint already
	* @param int $lessonId to specify which lesson hints is wanted
	* @param int $taskNum to specify which task hints is wanted
	* @param string $hintType to specify which hint type is wanted
	*
	* @return object $data(int hintUsed, string hintSolution, 
	*									int hintCost, int hintId) 
	*/
	public function getHint($accountId, $lessonId, $taskNum, $hintType)
	{
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT hintSolution, hintCost, hintId, 
					COUNT(
							CASE :accountId 
							WHEN Account_accountId 
							THEN 1 ELSE NULL END
							) AS hintUsed
				FROM Hint 
				JOIN Task 
				ON Hint.Task_taskId = Task.taskId
				LEFT JOIN Account_has_Hint 
				ON Hint.hintId = Account_has_Hint.Hint_hintId
				WHERE `hintType` = :hintType
				AND `Lesson_lessonId` = :lessonId
				AND `taskNumber` = :taskNum
			");

			// Set prepared statement parameters
			$st->bindParam("hintType", $hintType, PDO::PARAM_INT);
			$st->bindParam("accountId", $accountId, PDO::PARAM_INT);
			$st->bindParam("taskNum", $taskNum, PDO::PARAM_INT);
			$st->bindParam("lessonId", $lessonId, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$data = $st->fetch(PDO::FETCH_OBJ); // fetch statement records
			$db = null; // close connection to database

			return $data;
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Get the lesson id and lesson coin reward
	* @param int $moduleId to get the lesson module
	* @param int $lessonName to get the lesson name
	* @return int $data(lessonId, lessonReward)
	*/
	public function getLessonId($moduleId, $lessonName){
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT lessonId, lessonReward
				FROM Lesson 
				WHERE lessonName=:lessonName
				AND Module_moduleId = :moduleId
			");

			// Set prepared statement parameters
			$st->bindParam("lessonName", $lessonName, PDO::PARAM_INT);
			$st->bindParam("moduleId", $moduleId, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$data = $st->fetch(PDO::FETCH_OBJ); // fetch statement data
			$db = null; // close connection to database

			return $data;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Check if lesson is completed
	* @param int $moduleId to get the lesson module
	* @param int $lessonName to get the lesson name
	* @return int $data(lessonReward, lessonComplete)
	*/
	public function isLessonCompleted($accountId, $lessonId){
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT lessonReward,
					COUNT(
							CASE :accountId 
							WHEN Account_accountId 
							THEN 1 ELSE NULL END
							) AS lessonComplete
				FROM Lesson 
				LEFT JOIN Account_has_Lesson 
				ON Lesson.lessonId = Account_has_Lesson.Lesson_lessonId
				WHERE `lessonId` = :lessonId
			");

			// Set prepared statement parameters
			$st->bindParam("lessonId", $lessonId, PDO::PARAM_INT);
			$st->bindParam("accountId", $accountId, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$data = $st->fetch(PDO::FETCH_OBJ); // fetch statement data
			$db = null; // close connection to database

			return $data;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Gets the task answer and id
	* @param int $lessonId to get the lesson
	* @param int $taskNum to get the task
	* @param object $data (taskId, taskAnswer)
	*/
	public function getTask($lessonId, $taskNum) {
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT taskAnswer, taskId
				FROM Task 
				JOIN Lesson ON Task.Lesson_lessonId = Lesson.lessonId
				WHERE lessonId=:lessonId
				AND taskNumber=:taskNum
			");

			// Set prepared statement parameters
			$st->bindParam("lessonId", $lessonId, PDO::PARAM_INT);
			$st->bindParam("taskNum", $taskNum, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$data = $st->fetch(PDO::FETCH_OBJ); // fetch statement data
			$db = null; // close connection to database

			return $data;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Get lesson task questions
	* @param int $lessonId to get the lesson
	* @param object $data questions
	*/
	public function getTasks($lessonId) {
		try {
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				SELECT taskQuestion
				FROM Task 
				WHERE Lesson_lessonId=:lessonId
			");

			// Set prepared statement parameters
			$st->bindParam("lessonId", $lessonId, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$data = $st->fetchAll(); // fetch all the questions 
			$db = null; // close connection to database

			return $data;

		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	/*
	* Update User's coin count
	* @param int $accountId to select account
	* @param int $coins the amount of coins to add/subtract
	*/
	public function updateCoins($accountId, $coins)
	{
		try{
			$db = getDB(); // Connection to database

			// Prepared Statement
			$st = $db->prepare("
				UPDATE Account
				SET coins = :coins 
				WHERE accountId= :accountId
			");

			// Set prepared statement parameters
			$st->bindParam("coins", $coins, PDO::PARAM_INT);
			$st->bindParam("accountId", $accountId, PDO::PARAM_INT);
			$st->execute(); // execute statement

			$_SESSION["coins"] = $coins; //update session coin variable
			
			$db = null; // close connection to database
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}

	/*
	* Print the user coin count
	*/
	public function getCoinCount() {
		echo $_SESSION["coins"];
	}

	/*
	* Destroy the session and redirect to login
	*/
	public function logout(){
		$_SESSION = array(); // clear session varaible
		session_destroy();
		header("Location: /website/login.php"); // redirect to login
	}
}
?>