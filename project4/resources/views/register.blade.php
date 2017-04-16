<!DOCTYPE html>
<html>
<head>
  <!-- metadata information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Where to Eat Registration</title>
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
    Where To Eat
  </a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item" >
        <a class="nav-link" href="login">Login</a>
      </li>
      @if(!Auth::check()) 
        <li class="nav-item">
          <a class="nav-link" href="register">Register</a>
        </li>
      @endif
    </ul>
  </div>
</nav>

<!-- container for register section -->

<div class="container">
    <div class="card card-container" style="max-width:700px;">
        <img class=logo-img src="images/coffee.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        <p class=register-text>Register Your Account</p>

        {{-- form for the registration --}}
        {{ Form::open(array('url' => 'register', 'class' => 'form-signin')) }}
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            {{ Form::text('username', null, array('placeholder'=>'Username', 'class'=>'form-control' ) ) }}
            {{ Form::text('name', null, array('placeholder'=>'Name', 'class'=>'form-control' ) ) }}
            {{ Form::email('email', null, array('placeholder'=>'E-Mail', 'class'=>'form-control' ) ) }}
            {{ Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control' ) ) }}
            {{ Form::password('password_confirmation', array('placeholder'=>'Confirm Password', 'class'=>'form-control' ) ) }}
            {{ Form::submit('Register', array('class' => 'btn btn-lg btn-primary btn-block btn-signin')) }}</p>
        {{ Form::close() }}

        </p>

        <div class="signin-help">
    </div>
    </div>
</div>

</body>
  <!-- js declarations at the end -->
  <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="bower_components/tether/dist/js/tether.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</html>