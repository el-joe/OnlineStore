<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>


  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    body {
        margin: 0;
    }
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 9999;
    }

    .sticky + .container {
      padding-bottom: 100px;
    }
    .margin {
      padding-top:50px;
    }
    *{
      margin: 0
    }

    .form{
      position: relative;
      margin-right: 10px;
    }
    .search-icon{
      position: absolute;
      /*margin-left: 370px;*/
      margin-left: -20px;
      margin-top:10px;
    }

    .modal-dialog {
      margin-top: 200px;
      vertical-align: center;
      text-align: center;
    }
  </style>
  @yield('style')
</head>
<body>
@yield('jumbotron')

<nav id="navbar" class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('index') }}"><span style="font-size: 30px;">s</span>hop</a>
    </div>
    <div class="nav navbar-nav navbar-right" id="myNavbar">
      <ul class="nav navbar-nav">
        <li>
          <form class="form form-inline" action="{{ route('product.search') }}" method="GET" style="margin-top: 10px;margin-right: 50px">
            
            <input type="text" name="query" class="form-control" size="50" placeholder="Search" value="{{ request('query') }}"><i class="fa fa-search search-icon"></i>
          </form>
        </li>
          


        </a>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <span class="glyphicon glyphicon-user"></span>&nbsp&nbsp

              @auth
              {{ Auth::user()->name }}
              @else
              Your Account
              @endauth

              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                @auth
                <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">logout</a></li>
                @else
                <li><a href="{{ route('register') }}">register</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </li>
        <li>
          <a href="{{ route('product.shoppingCart') }}">
             Shopping-Cart
            <span class="glyphicon glyphicon-shopping-cart"></span>
            <span class="badge"> {{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>
          </a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid" style="margin-top: 100px">
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
@yield('content')
@yield('footer')
@yield('scripts')
</div>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var margin = document.getElementsByTagName("body")[0];
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
    margin.classList.add("margin");
  } else {
    navbar.classList.remove("sticky");
    margin.classList.remove("margin");

  }
}
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>