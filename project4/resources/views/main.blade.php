<!DOCTYPE html>
<html>
<head>
  <!-- metadata information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- rest of the code goes here... -->

<!-- navigation bar -->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{ URL::to('main') }}">
    <img src="images/coffee.svg" width="30" height="30" class="d-inline-block align-top tsar-title" alt="">
    Where To Eat
  </a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="main">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('logout') }}">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<!-- side navigation bar -->
<!-- if the role is customer, see standard customer menu. -->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav" style="margin-left:0;">
      <li class="sidebar-brand"></li>
        <li class="custom-active-state">
            <a href="main"><i class="fa fa-home" aria-hidden="true"> </i> <span style="margin-left:10px;"> Home</span>
            </a>
        </li>
        <li>
            <a href="restaurants"><i class="fa fa-cutlery " aria-hidden="true"> </i> <span style="margin-left:10px;"> Restaurants</span>
        </li>

        @if(Auth::user()->isAdmin())
        <li>
            <a href="myorders.php"> 
            <i class="fa fa-comments-o " aria-hidden="true"> 
            </i> 
              <span style="margin-left:10px;">Admin Panel</span>
            </a>
        </li>
        @elseif(Auth::check())
        <li>
            <a href="{{URL::to('myreviews')}}"> 
            <i class="fa fa-comments-o " aria-hidden="true"> 
            </i> 
              <span style="margin-left:10px;">My Reviews</span>
              <span id="spambadge_orders" class="badge spambadge">  
              </span>
            </a>
        </li>
        <li>
            <a href="{{ URL::to('myprofile') }}"> 
              <i class="fa fa-user " aria-hidden="true"> </i> 
              <span style="margin-left:10px;"> My Profile</span>
            </a>
        </li>
        @endif
      </ul>
  </div>


<!-- main view for inbox -->
<div id="inbox-section">
@if(Session::has('message'))
    <div class="alert alert-success" style="width: 45%">{{ Session::get('message') }}</div>
@endif

<h1>Welcome, {{ Auth::user()->name }}!!!!</h1>
<h2>Quit fuckin around and start doin stuff yea?!?!?</h2>

</div>

</body>
	<!-- js declarations at the end -->
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</html>