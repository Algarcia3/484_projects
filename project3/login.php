<?php

// redirect to home page if they're already logged in...
session_start();

if(isset($_SESSION["loggedin"]) || $_SESSION == 1) {
  header("Location: home.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <!-- metadata information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tsarbucks Login</title>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<!-- rest of the code goes here... -->

<!-- top navigation bar -->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">
    <img src="images/coffee.svg" width="30" height="30" class="d-inline-block align-top tsar-title" alt="">
    Tsarbucks
  </a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#helppage">Help</a>
      </li>
    </ul>
  </div>
</nav>

<!-- container for login section -->

<div class="container">
    <div class="card card-container">
        <img class=logo-img src="images/coffee.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <p class=sign-in-text>Sign in to Tsarbucks</p>
        <form class="form-signin" action="home.php" method="post">
            <input name="username" type="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <div class="checkbox">
                <label class="remember-me"><input type="checkbox" value=""> Remember Me</label>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
        </form>
        <div class="signin-help">
      <p class="fpw">Forgot your password? <a href="http://www.csun.edu/~boa63454/">Click here.</a></p>
    </div>
    </div>
</div>

</body>
  <!-- js declarations at the end -->
  <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="bower_components/tether/dist/js/tether.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</html>