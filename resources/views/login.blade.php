<!doctype html>
<html>
   <head>
      <title>My Login Page</title>

      <meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="template/css/navbar.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="template/js/navbar.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap minified JS CDN link -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap minified theme CDN link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <!-- Bootstrap minified CSS CDN link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- top panel CSS -->

    <style>
    .container {
	  max-width: 960px;
	}
	.navbar-survival101 {
	  background-color:#2B6DAD;
	}
	/* .navbar-survival101 .navbar-brand {
	  margin-right: 2.15rem;
	  padding: 3px 0 0 0;
	  line-height: 36px;
	} */

	.navbar-survival101 .navbar-brand img {
	  vertical-align: baseline;
	}

	.navbar-expand-lg .navbar-nav .nav-link {
	  color: #fff;
	}

	.search-box {
	  position: relative;
	  height: 34px;
	}
	.search-box input {
	  border: 0;
	  border-radius: 3px !important;
	  padding-right: 28px;
	  font-size: 15px;
	}

	.search-box .input-group-btn {
	  position: absolute;
	  right: 0;
	  top: 0;
	  z-index: 999;
	}

	.search-box .input-group-btn button {
	  background-color: transparent;
	  border: 0;
	  padding: 4px 8px;
	  color: rgba(0,0,0,.4);
	  font-size: 20px;
	}

	.search-box .input-group-btn button:hover,
	.search-box .input-group-btn button:active,
	.search-box .input-group-btn button:focus {
	  color: rgba(0,0,0,.4);
	}

	@media (min-width: 992px) {
	  .navbar-expand-lg .navbar-nav .nav-link {
	    padding-right: .7rem;
	    padding-left: .7rem;
	  }
	  
	  .search-box {
	    width: 300px !important;
	  }
	}

	.caroulsel {
	  width: 100%;
	  overflow: hidden;
	  padding: 5px 0 5px 5px;
	}

	.caroulsel-wrap {
	  white-space: nowrap;
	  font-size: 0;
	}

	.caroulsel-wrap a {
	  display: inline-block;
	  width: 134px;
	  height: 92px;
	  background-color: silver;
	  border: #ccc 1px solid;
	  margin-right: 5px;
	}

	input[type="radio"]{
  	  margin: 0 30px 0 10px;
	}
    </style>

    <!-- Login Controls style -->
    <style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:400,300,600);

*{box-sizing:border-box;}

body {
  font-family: 'open sans', helvetica, arial, sans;
background:url(http://farm8.staticflickr.com/7064/6858179818_5d652f531c_h.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

@grey:#2a2a2a;
@blue:#1fb5bf;
.log-form {
  width: 40%;
  min-width: 320px;
  max-width: 475px;
  background: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%,-50%);
-moz-transform: translate(-50%,-50%);
-o-transform: translate(-50%,-50%);
-ms-transform: translate(-50%,-50%);
transform: translate(-50%,-50%);
  
  box-shadow: 0px 2px 5px rgba(0,0,0,.25);
  
  @media(max-width: 40em){
    width: 95%;
    position: relative;
    margin: 2.5% auto 0 auto;
    left: 0%;
  -webkit-transform: translate(0%,0%);
-moz-transform: translate(0%,0%);
-o-transform: translate(0%,0%);
-ms-transform: translate(0%,0%);
transform: translate(0%,0%);
  }
  
  form {
    display: block;
    width: 100%;
    padding: 2em;
  }
  
  h2 {
    width: 100%;
    color: lighten(@grey, 20%);
    font-family: 'open sans condensed';
    font-size: 1.35em;
    display: block;
    background:@grey;
    width: 100%;
    text-transform: uppercase;
    padding: .75em 1em .75em 1.5em;
    box-shadow:inset 0px 1px 1px fadeout(white, 95%);
    border: 1px solid darken(@grey, 5%);
    //text-shadow: 0px 1px 1px darken(@grey, 5%);
    margin: 0;
    font-weight: 200;
  }
  
  input {
    display: block;
    margin: auto auto;
    width: 100%;
    margin-bottom: 2em;
    padding: .5em 0;
    border: none;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 1.25em;
    color: #757575;
    &:focus {
      outline: none;
    }
  }
  
  .btn {
    display: inline-block;
    background: @blue;
    border: 1px solid darken(@blue, 5%);
    padding: .5em 2em;
    color: white;
    margin-right: .5em;
    box-shadow: inset 0px 1px 0px fadeout(white, 80%); 
    &:hover {
      background: lighten(@blue, 5%);
    }
    &:active {
      background: @blue; 
      box-shadow: inset 0px 1px 1px fadeout(black, 90%); 
    }
    &:focus {
      outline: none;
    }
  }
  
  .forgot {
    color: lighten(@blue, 10%);
    line-height: .5em;
    position: relative;
    top: 2.5em;
    text-decoration: none;
    font-size: .75em;
    margin:0;
    padding: 0;
    float: right;
    
    &:hover {
      color:darken(@blue, 5%);
    }
    &:active{ 
    }
  }
  
}
    </style>
    <!--/////////////////////////////////////////// IMP /////////////////////////////////////////////////////-->
    <link rel="stylesheet" href="/template/com_app_min.css">	 
      
    <script src="/template/nn.js.download"></script>	 
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <!-- top panel CSS ends -->

    <!-- load stylesheets -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">  

    <!-- Google web font "Open Sans" -->

    <link rel="stylesheet" href="/template/Font-Awesome-4.7/css/font-awesome.min.css">                

    <!-- Font Awesome -->

    <link rel="stylesheet" href="/template/css/bootstrap.min.css">                                      

    <!-- Bootstrap style -->

    <link rel="stylesheet" href="/template/css/hero-slider-style.css">                              

    <!-- Hero slider style (https://codyhouse.co/gem/hero-slider/) -->

    <link rel="stylesheet" href="/template/css/magnific-popup.css">                                 

    <!-- Magnific popup style (http://dimsemenov.com/plugins/magnific-popup/) -->

    <link rel="stylesheet" href="/template/css/templatemo-style.css">                                   



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

          <![endif]-->



        <!-- These two JS are loaded at the top for gray scale including the loader. -->



        <script src="/template/js/jquery-1.11.3.min.js"></script>

        <!-- jQuery (https://jquery.com/download/) -->



        <script>

		

            var tm_gray_site = false;

            

            if(tm_gray_site) {

                $('html').addClass('gray');

            }

            else {

                $('html').removeClass('gray');   

            }

        </script> 

	<script src="/template/js/common.js.download" defer=""></script>
	<script src="/template/js/searchgallery.js"></script>
   </head>
   <body>

	<!-- Top panel -->

	@include('toppanel')
	<!-- Top panel ends here -->

      {{ Form::open(array('url' => 'login')) }}
      <div class="log-form">
      <h2 style="color:blue;padding-left:15px;">Login to your account</h2>
      <!-- if there are login errors, show them here -->
     <?php
       if(Session::has('activation')){
	 echo "<div style='color:0000AA;padding-left:20px;'>".Session::get("activation")."</div>";
       }       
      ?>
      <p style="color:blue;padding-left:20px;">
         {{ $errors->first('username') }}
         {{ $errors->first('password') }}
      </p>
      <p style="color:blue;padding-left:20px;">
	@if($errors->any())
	<p style="color:red;">{{$errors->first()}}</p>
	@endif
         
         {{ Form::text('username', Input::old('text'), array('placeholder' => 'username', 'title' => 'username')) }}
      </p>
      <p style="color:blue;padding-left:20px;">
         
         {{ Form::password('password', array('placeholder' => 'password', 'title' => 'password')) }}
      </p>
      <input type="hidden" name="_token" value="{{ csrf_token() }}"><input type='hidden' name='rurl' value="{{request()->query('url')}}">
      <p style="color:blue;padding-left:20px;">{{ Form::submit('Submit!') }}</p>
      <p style="padding-left:20px;color:blue;font-weight:bold;"><a class='forgot' href="/forgotpassword">Forgot Password</a>|New user?<a href='/register' class='forgot'>Register here</a></p>
      </div>
      {{ Form::close() }}
</body>
</html>


