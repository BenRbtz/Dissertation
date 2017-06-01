<?php
  include("php/config.php");
  include('php/userClass.php');
  $userClass = new userClass();

  $errorMsgReg='';
  $errorMsgLogin='';
  
  // Login Form Button Pressed
  if (isset($_POST['loginSubmit'])) {
    // Store username and password from fields
    $username=$_POST['username'];
    $password=$_POST['password'];

    if(strlen(trim($username))>1 && strlen(trim($password)) >1) {
      //Attemp log on
      $accountId=$userClass->userLogin($username,$password);

      // Log in Successful
      if($accountId){
        $url='module1_lesson1.php';
        header("Location: $url"); // Page redirecting to home.php 
      } else {
        $errorMsgLogin="Please check login details.";
      }
    }
  }

  // Register Form Button Pressed
  if (isset($_POST['registerSubmit'])) {
    // Store username and password from fields
    $username=$_POST['usernameReg'];
    $password=$_POST['passwordReg'];

    // Regular expression check 
    $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
    $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

    if($username_check && $password_check) {
      // Attempt registeration of user
      $accountId=$userClass->userRegistration($username,$password);

      //  Register Successful
      if($accountId){
        $errorMsgLogin="Account Successfully Created.";
      } else {
        $errorMsgLogin="Username already exists.";
      }
    }
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="shortcut icon" href="img/favicon.png">
    <title>CodeBits</title>

    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
  </head>

  <body>
    <div class="login-page">
      <div class="form">

        <form class="login-form" method='post'>
          <h2 style="margin-top: 0; ">Login</h2>

          <div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
          <input type='text' name='username' placeholder="username" maxlength="20"/>
          <input type='password' name='password' placeholder="password" maxlength="20"/>
          <input type='submit' name='loginSubmit' value='Log In' id='submit'/>

          <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>



        <form class="register-form" id="register-form" method="post">
          <h2 style="margin-top: 0; ">Register</h2>

          <div class="errorMsg"><?php echo $errorMsgReg; ?></div>
          <input type="text" placeholder="username" name="usernameReg" maxlength="20"/>
          <input type="password" placeholder="password" name="passwordReg" maxlength="20"/>
          <input type="password" placeholder="confirm password" name="confirmPassword" maxlength="20"/>
          <span id='message'></span>
          <input type="submit" class="button" name="registerSubmit" value="Create Account" disabled>
          
          <p class="message">Already registered? <a href="#">Log In</a></p>
        </form>

      </div>
    </div>

    <script>
      // Called when form link has been pressed
      $('.message a').click(function(){
         $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
      });



      // Called When Register Form Fields are in uses
      $(':input[name="usernameReg"], :input[name="passwordReg"], :input[name="confirmPassword"]').on('keyup', function () {
          $('#message').html('').css('color', 'black');
          // Check username length is greater than 5
          if ($(':input[name="usernameReg"]').val().length > 5) {
            $('#message').html('').css('color', 'black');
            // Check password length is greater than 5
            if ($(':input[name="passwordReg"]').val().length > 5) {
              //Check if password and confirm password fields match
              if ($(':input[name="passwordReg"]').val() == $(':input[name="confirmPassword"]').val()) {
                  $('#message').html('Passwords Match').css('color', 'green');
                  $(':input[name="registerSubmit"]').prop('disabled', false);
              } else {
                  $('#message').html('Passwords Don\'t Match').css('color', 'red');
                  $(':input[name="registerSubmit"]').prop('disabled', true);
              }
            } else {
              $('#message').html('Password Must Be At Least 6 Characters').css('color', 'black');
              $(':input[name="registerSubmit"]').prop('disabled', true);
            }

          } else {
              $('#message').html('Username Must Be At Least 6 Characters').css('color', 'black');
              $(':input[name="registerSubmit"]').prop('disabled', true);
          }

      });
    </script>
  </body>
</html>