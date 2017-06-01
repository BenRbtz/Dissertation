<?php

include_once('php/config.php');
include_once('php/session.php');

// Logout button was pressed
if (isset($_POST['logout'])) {
  $userClass->logout(); // Logout 
}
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
  header('Cache-Control: no-store, no-cache, must-revalidate'); 
  header('Cache-Control: post-check=0, pre-check=0', FALSE); 
  header('Pragma: no-cache'); 
?>

<!DOCTYPE html>
<html>
  <head>
    <title>CodeBits</title>

    <link rel="shortcut icon" href="img/favicon.png">
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

  

      <!-- Coin Count -->
      <label style="float:right; padding-left: 5px; " id="coinCount">
        <?php $userClass->getCoinCount(); ?>
      </label>
      <img src="img/Gold_coin_icon.png"/>
    </header>


    <section class="main hbox space-between">
        <div style="padding:5em;text-align: center;top:50%;left:50%;position: 
                                            absolute;margin: -110px 0 0 -215px; color:white;" 
                                            class="dialogue" id="instructions">
          <h1>Course Complete</h1>
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
  </body>
</html>