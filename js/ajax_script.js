/**
 * Calls php method to update displayed coin number
 */
function refreshCoinCount() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("coinCount").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","php/updateCoinCounter.php?",true);
	xmlhttp.send();
}

/**
 * Calls php method to display hints
 * @param {string} hintType
 */
function showHint(hintType) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			switch(hintType){
				case "link":
						window.open("https://" + this.responseText, false);
						break;
				case "advice":
						
						if (this.responseText != "") {
							// adds hint inside advice button
							document.getElementById("adviceButton").innerHTML = this.responseText;
							refreshCoinCount();
						}
						break;	
				case "solution":
						if (this.responseText != "") {
							// adds solution in text editor
							editor.setValue(this.responseText);
							refreshCoinCount();
							// reload hint button to show 0
							reloadButton('solution');
						}
						break;	
				default:
						console.log("Button has passed wrong parameter: "+  hintType);
						break;		
			}
		}
	};
	//returns hint strin
	xmlhttp.open("GET","php/getHint.php?hintType="+hintType,true);
	xmlhttp.send();
}

/**
 * Dynamically evaluate user code and prints whether its correct 
 * in console
 * @param {string} userCode - from textEditor
 */
function showAnswer(userCode) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//updates small view

			// Checks answer state
			// Code 2 = lesson finished
			// Code 1 = correct answer
			// Code 0 = incorrect answer
			switch(parseInt(this.responseText)){
				case 2:
					// Show Complete lesson view
					$('#myModal').modal('show');
				case 1:
					updateTaskList();  //Update task list
					reloadButton('advice'); //reload advice button
					reloadButton('solution'); // reload solution button

					// Update Console with text
					document.getElementById("output").innerHTML = document.getElementById("output").innerHTML +
													"<p style= \"margin:0;color:green;font-weight: bold;\">> Correct</p>";
					//Sets console scroll to bottom
					var pre = jQuery("#output");
   					pre.scrollTop( pre.prop("scrollHeight") );
					break;
				case 0:
					// Update console with text
					document.getElementById("output").innerHTML = document.getElementById("output").innerHTML +
													"<p style= \"margin:0;color:red;font-weight: bold;\">> Incorrect, try again.</p>";
					// Sets console scroll to bottom
					var pre = jQuery("#output");
   					pre.scrollTop( pre.prop("scrollHeight") );
					break;
				default:
					var e = new Error('Error: Wrong value returned from validatecode.php '+this.responseText ); 
					throw e;
			}
		}
	};
	//return whether the user is correct or incorrect with their code
	xmlhttp.open("GET","php/validateCode.php?userCode="+userCode,true);
	xmlhttp.send();
}




/**
* Dynamically updates task list to strikeout completed tasks
*/
function updateTaskList() {
	    $.ajax({
	      url: 'php/taskList.php',
	      type: 'post',
	      success: function(data, status) {
	      	// Gets string answer from data variable
	      	// Puts into array based on '|' divider 
	      	var array=data.split('|');
			var completedTaskNum= array[0]; // Task completed count for the user
			var totalTaskNum = array[1]; // Total of tasks for the lessons

			// Update task list by using the id task
		    	$("#task li").each(function (index) {
			       	var count = $(this).index();// Task number
			       	// If current task
			       	if( (count) == (completedTaskNum)) {
			       		// insert task into li
			    		$(this).html('<li>'+(count+1)+'/'+ totalTaskNum+ ' ' 
			    			+array[count +2]+'</li>');
			    	// If already completed
			    	} else if(count <= completedTaskNum) {
			    		//insert task into li with line through text
			       		$(this).html('<li><strike>'+(count+1)+'/'+ totalTaskNum+ ' ' 
			       								+array[count+2]+'</strike></li>');
			       	// If next task, do nothing
			   		} else {

			   		}
			   		console.log( count + ": " + $( this ).text() );
		    	});
	      },
	      error: function(xhr, desc, err) {
	        console.log(xhr);
	        console.log("Details: " + desc + "\nError:" + err);
	      }
	    });
}


/**
 * Dynamically inserts hint button default text
 * @param {string} userCode - from textEditor
 */
function reloadButton(hintType) {

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var hintButton = document.getElementById(hintType+"Button");
			// If button type is advice
			if(hintType == "advice") {
				//check if hint is displayed			
					document.getElementById(hintType+"Button").innerHTML = 
						'<table style="width:100%;">' +
							'<tr>' +
								'<th style="width:80%;text-align:center">' +
								    '<label>Advice</label>' +
								'</th>' +
								'<th>' +		
								    '<img style="float:left;" src="img/Gold_coin_icon.png"/>'+
								    '<label style="padding-left:1em; float:left;">' +
										this.responseText +
									'</label>' + 	
								'</th>' +
							'</tr>' +
						'</table>'
			// If button type is solution
			} else {
				document.getElementById(hintType+"Button").innerHTML = 
						'<table style="width:100%;">' +
							'<tr>' +
								'<th style="width:80%;text-align:center">' +
								    '<label>Solution</label>' +
								'</th>' +
								'<th>' +		
								    '<img style="float:left;" src="img/Gold_coin_icon.png"/>'+
								    '<label style="padding-left:1em; float:left;">' +
										this.responseText +
									'</label>' + 	
								'</th>' +
							'</tr>' +
						'</table>'
			}
		}
	};
	
	//return whether the user is correct or incorrect with their code
	xmlhttp.open('GET',"isHintPurchased.php?hintType="+hintType,true);
	xmlhttp.send();
}
