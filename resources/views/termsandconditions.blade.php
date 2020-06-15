<!DOCTYPE html>

<html lang="en">

<head>

	<title>Terms and Conditions</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="template/css/navbar.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="template/js/navbar.js"></script>
	<!--/////////////////////////////////////////// IMP /////////////////////////////////////////////////////-->
        <link rel="stylesheet" href="/template/com_app_min.css">	 
      
        <script src="/template/nn.js.download"></script>	 
        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->


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
    </style>

    <!-- top panel CSS ends -->
    
    <!-- load stylesheets -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600">  

    <!-- Google web font "Open Sans" -->

    <link rel="stylesheet" href="/template/Font-Awesome-4.7/css/font-awesome.min.css">                

    <!-- Font Awesome -->

    <link rel="stylesheet" href="/template/css/hero-slider-style.css">                              

    <!-- Hero slider style (https://codyhouse.co/gem/hero-slider/) -->

    <link rel="stylesheet" href="/template/css/magnific-popup.css">                                 

    <!-- Magnific popup style (http://dimsemenov.com/plugins/magnific-popup/) -->

    <link rel="stylesheet" href="/template/css/templatemo-style.css">                                   

    <link rel="stylesheet" href="/template/css/bootstrap.min.css">                                      

    <!-- Bootstrap style -->

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
</head>

<body>

	<!-- Top Panel -->
	<nav class="navbar navbar-expand-lg navbar-dark navbar-survival101">
  	<div class="container">
	    <a class="navbar-brand" href="#">
	      <img src="https://lh3.googleusercontent.com/-ZAS0BBE8Sm0/WaFOdATxW9I/AAAAAAAAAf4/8FfuKoWw6n0cvynAv7Fv2sdYESliQEm4wCL0BGAYYCw/h18/2017-08-26.png" alt="L A N T E R N">
	    </a>

	    <div class="collapse navbar-collapse" id="navbarColor02">
	      <ul class="navbar-nav mr-auto">
		<?php
		if($username != ""){
		    echo "<li class='nav-item'>You are logged in as ".$username."<img src='".$profileimage."' height='50px' width='50px'>";
		    echo "<a class='nav-link' href='/logout'>Logout</a></li>";
		    echo "<li class='nav-item'><a class='nav-link' href='#/' onClick='javascript:showprofileimagescreen();'>Change Profile Image</a></li>";
		    echo "<div id='profileimagediv' style='display:none;'><form id='frmprofimg' name='frmprofimg'><input type='file' name='uploadfile' id='uploadfile'><input type='button' name='btnupload' value='  Go  ' onClick='javascript:uploadprofileimage();'><div id='profstatus'></div><input type='button' name='btnclose' value='Close' onClick='javascript:closeuploadform();'>";
	        ?>
	         <input type='hidden' name='_token' value='{{ csrf_token() }}'>
	        <?php
	            echo "</form></div>";
		}
		else{
		    echo "<li class='nav-item'><a class='nav-link' href='/login'>Login</a> or <a href='/register'>Register</a></li>";
		}
	        ?>
	      </ul>
	      
	    </div>
	  </div>
	    
    </nav>
    <div class="wrapper" style="transform: none;border:4px solid blue;">
	  <header>
        <div class="clearfix head-bottom">
          <div class="red-navigation">
            <div class="nav-f-block">
              <div id="nav-icon"><span></span><span></span><span></span></div>
              <a href="https://zeenews.india.com/"><img src="./Death of pregnant elephant in Kerala, Maneka Gandhi flays Kerala government_files/zeenewslogo_nav.png" alt="Image Web" title="Image Web"></a>
            </div>
            <div class="nav-s-block">
              <div class="search" id="searchb" style="border:4px solid green;">
						<input autocomplete="on" type="text" placeholder="Search on Imageweb..." class="input-search">
						<button type="submit" class="searchButton">Search</button>
                </div>
              <div class="d-none">
                <ul>
				<li><a href="/dashboard" title="Dashboard">Dashboard</a></li>
				  <li><a href="/gallery" title="Gallery" style="color: yellow;border: 1px solid yellow;border-radius: 10px;margin: 14px 0px;line-height: 54px;display: inline;padding: 6px;">Gallery</a></li>
				 <li><a href="/aboutus" title="About Us">About Us</a></li>
				  <li><a href="/termsandconditions" title="Terms and Conditions">Terms and Conditions</a></li>
                </ul>
              </div>
            </div>
            <div class="nav-t-block">
              <ul class="social-block">
                <li><button class="search-click"><i class="fa fa-search" aria-hidden="true"></i></button></li>

              </ul>
            </div>
          </div>
        </div>	
      </header>
 
      </div>
<!-- Top panel ends here -->

<!-- Enter Content Here -->

</body>

</html>

