<?php
include "app/databaseHandler.php";
include "app/loginHandler.php";

session_start();

$login = new loginHandler();
$login->login_action();

if(!isset($_SESSION["loggedin"]) || $_SESSION == 1) {
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <!-- metadata information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tsarbucks</title>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<!-- rest of the code goes here... -->

<!-- navigation bar -->
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
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<!-- side navigation bar -->
<!-- if the role is customer, see standard customer menu. -->
<?php if($_SESSION["role"] == "customer") : ?>
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav" style="margin-left:0;">
      <li class="sidebar-brand"></li>
        <li class="custom-active-state">
            <a href="home.php"><i class="fa fa-plus " aria-hidden="true"> </i> <span style="margin-left:10px;"> Home</span>
            </a>
        </li>
        <li>
            <a href="menu.php"><i class="fa fa-envelope " aria-hidden="true"> </i> <span style="margin-left:10px;"> Menu</span>
        </li>
        <li>
            <a href="spam.html"> <i class="fa fa-ban " aria-hidden="true"> </i> <span style="margin-left:10px;"> My Orders</span><span class="badge spambadge">  3</span></a>
        </li>
      </ul>
  </div>
<?php elseif($_SESSION["role"] == "barista") : ?>
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav" style="margin-left:0;">
      <li class="sidebar-brand"></li>
        <li class="custom-active-state">
            <a href="home.php"><i class="fa fa-plus " aria-hidden="true"> </i> <span style="margin-left:10px;"> Home</span>
            </a>
        </li>
        <li>
            <a href="menu.php"><i class="fa fa-envelope " aria-hidden="true"> </i> <span style="margin-left:10px;"> Pending</span>
            <span class="badge">5</span></a>
        </li>
      </ul>
  </div>
<?php endif; ?>



<!-- main view for inbox -->
<div id="inbox-section">
<h1>Welcome <?php echo $_SESSION["username"];?>!!!!!!</h1>
<!-- email table crap -->
<h3>Soooo are you gonna buy something or get out cus I don't have all day</h3>


</div>

</body>
	<!-- js declarations at the end -->
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</html>