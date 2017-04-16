<!DOCTYPE html>
<html>
<head>
  <!-- metadata information -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurants</title>
  {{-- <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100">
 {{--  <link rel="stylesheet" type="text/css" href="css/styles.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<!-- rest of the code goes here... -->

<!-- navigation bar -->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php">
    <img src="{{asset('images/coffee.svg')}}" width="30" height="30" class="d-inline-block align-top tsar-title" alt="">
    Where To Eat
  </a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{URL::to('main')}}">Home<span class="sr-only">(current)</span></a>
      </li>
      @if(Auth::user())
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('logout') }}">Logout</a>
      </li>
      @else
        <li class="nav-item">
          <a class="nav-link" href="{{URL::to('login')}}">Login</a>
        </li>
      @endif
    </ul>
  </div>
</nav>

<!-- side navigation bar -->
<!-- if the role is customer, see standard customer menu. -->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav" style="margin-left:0;">
      <li class="sidebar-brand"></li>
        <li>
            <a href="{{URL::to('main')}}"><i class="fa fa-home" aria-hidden="true"> </i> <span style="margin-left:10px;"> Home</span>
            </a>
        </li>
        <li class="custom-active-state">
            <a href="{{URL::to('restaurants')}}"><i class="fa fa-cutlery " aria-hidden="true"> </i> <span style="margin-left:10px;"> Restaurants</span>
            </a>
        </li>

        @if(Auth::user())
          @if(Auth::user()->isAdmin())
          <li>
              <a href="myorders.php"> 
              <i class="fa fa-comments-o " aria-hidden="true"> 
              </i> 
                <span style="margin-left:10px;">Admin Panel</span>
                <span id="spambadge_orders" class="badge spambadge">  
                </span>
              </a>
          </li>
          @endif
        @endif

        @if(Auth::user() && !Auth::user()->isAdmin())
        <li>
            <a href="myorders.php"> 
            <i class="fa fa-comments-o " aria-hidden="true"> 
            </i> 
              <span style="margin-left:10px;">My Reviews</span>
              <span id="spambadge_orders" class="badge spambadge">  
              </span>
            </a>
        </li>
        <li>
            <a href="mycart.php"> 
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
    <div class="alert alert-success" style="width: 50%;">{{ Session::get('message') }}</div>
@endif

@if(Session::has('review_created'))
    <div class="alert alert-success" style="width: 50%;">{{ Session::get('review_created') }}</div>
@endif
    
    <h1>Restaurant Details</h1>
    {{-- button goes here for displaying add review --}}

  @if(Auth::user())
    <a href="{{ URL::to('restaurants/' . $restaurants->restaurant_id . '/addreview')}}">
      <button name="review_button" class="btn btn-primary" style="float: right;">
        <i class="fa fa-plus" aria-hidden="true">
        </i> Write A Review
        </button>
    </a>
  @endif

    &nbsp;
    <h2>{{ $restaurants->restaurant_name }}</h2>
    <h3>Average Rating</h3>
    <h3>{{ $avg_rating }}/5</h3>
    &nbsp;
    <h3>Address</h3>
    <h4>{{ $restaurants->street_address }}</h4>
    <h4>{{ $restaurants->city }},</h4>
    <h4>{{ $restaurants->state }}</h4>
    &nbsp;
    <h3>Website</h3>
    <h4>{{ $restaurants->website }}</h4>
    &nbsp;
    <h3>Reviews</h3>

    {{-- output all of the reviews --}}
    @foreach($reviews as $review)
      <h4>{{$review->review_tagline}}</h4>
      <h5>Review By: {{$review->user->username}}</h5>
      <h6>Posted: {{ date('F d, Y H:i:s', strtotime($review->created_at)) }}</h6>
      <h6>Rating: {{ $review->rating }}/5</h6>
      <h5>{{ $review->review }}</h5>
      &nbsp;
    @endforeach

    {{-- link restaurants route using the id --}}

    </br>
    &nbsp;
</div>
</body>
	<!-- js declarations at the end -->
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</html>