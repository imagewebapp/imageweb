<!DOCTYPE html>

<html lang="en">

<head>

	<title>Forgot Password</title>

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

	
    </style>

    <!-- top panel CSS ends -->

    <!-- Forgot Password Controls style -->
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
.forgot-form {
  width: 50%;
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
    color: blue;
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
  
}
    </style>
    
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
    <!--/////////////////////////////////////////// IMP /////////////////////////////////////////////////////-->
    <link rel="stylesheet" href="/template/com_app_min.css">	 
      
    <script src="/template/nn.js.download"></script>	 
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->

<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<script type='text/javascript'>
	function generatepasscode(){
	    var xmlhttp;
	    waiter = document.getElementById('waitdiv');
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    waiter.innerHTML = "";
		    if(xmlhttp.responseText != ""){
			alert(xmlhttp.responseText);
			return(false);
		    }
		    else{
			document.frmpasscode.method = "GET";
			document.frmpasscode.submit();
		    }
                }
            }
            postdata = "_token=" + document.frmpasscode._token.value;
	    postdata += "&username=" + document.frmpasscode.username.value;
	    postdata += "&emailid=" + document.frmpasscode.emailid.value;
            //alert(getdata);
	    targeturl = "/generatepasscode"
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmpasscode._token.value);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);
	    waiter.innerHTML = "<img src='/images/loading_small.gif'>";
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
	      
	      
	    </div>
	  </div>
	    
    </nav>

    <div class="wrapper" style="transform: none;border:4px solid blue;">
	  <header>
        <div class="clearfix head-bottom">
          <div class="red-navigation">
            <div class="nav-f-block">
              <div id="nav-icon"><span></span><span></span><span></span></div>
              <a href=""><img src="/template/img/imageweb_logo.png" alt="Image Web" title="Image Web" width="50px" height="50px"></a>
            </div>
            <div class="nav-s-block">
              
              <div class="d-none">
                <ul>
				<li><a href="/dashboard" title="Dashboard">Dashboard</a></li>
				  <li><a href="/gallery" title="Gallery" style="color: yellow;border: 1px solid yellow;border-radius: 10px;margin: 14px 0px;line-height: 54px;display: inline;padding: 6px;">Gallery</a></li>
				 <li><a href="/aboutus" title="About Us">About Us</a></li>
				  <li><a href="/termsandconditions" title="Terms and Conditions">Terms and Conditions</a></li>
                </ul>
              </div>
            </div>
            
          </div>
        </div>	
      </header>
 
      </div>
	<br /><br /><hr>
    <div class="wrap-table100-nextcols js-pscroll">
	<div class="forgot-form">
	<form name='frmpasscode' method='GET' action='/changepassword'>
	<table border='0' cellpadding='4'>
	    <tr>
		<td>&nbsp;</td><td style="padding-left:20px;color:blue;font-weight:bold;">Enter username: </td><td><input type='text' name='username' id='username' value=''></td>
	    </tr>
	    <tr>
		<td colspan='3'>&nbsp;</td>
	    </tr>
	    <tr>
		<td>&nbsp;</td><td style="padding-left:20px;color:blue;font-weight:bold;">Enter email address: </td><td><input type='text' name='emailid' id='emailid' value=''></td>
	    </tr>
	    <tr>
		<td colspan='3'>&nbsp;</td>
	    </tr>
	    <tr>
		<td>&nbsp;</td><td colspan='2' align='center'><span><input type='button' name='btnpasscode' id='btnpasscode' value='Generate Passcode' onclick='javascript:generatepasscode();'>&nbsp;&nbsp;<input type='button' name='btnback' id='btnback' value='Back' onclick='javascript:window.location="/login";'></span><div id='waitdiv'></div></td>
	    </tr>
	    <tr>
		<td colspan='3'><input type='hidden' name='_token' value='{{ csrf_token() }}'></td>
	    </tr>
	</table>
	</form>
	</div>
    </div>

</body>

</html>


