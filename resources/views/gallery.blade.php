<!DOCTYPE HTML>

<!--

	Radius by TEMPLATED

	templated.co @templatedco

	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)

-->

<html>

	<head>

		<title>Gallery</title>

		<meta charset="utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="template/css/navbar.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="template/js/navbar.js"></script>

		<link rel="stylesheet" href="template/css/main.css" />

		<!-- Bootstrap minified JS CDN link -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap minified theme CDN link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <!-- Bootstrap minified CSS CDN link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- top panel CSS -->

    <!--/////////////////////////////////////////// IMP /////////////////////////////////////////////////////-->
    <link rel="stylesheet" href="/template/com_app_min.css">	 
      
    <script src="/template/nn.js.download"></script>	 
    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->

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

	.row input{
	  float:left;
	}
    </style>

    <!-- top panel CSS ends -->

	<style>

.semitrans {
	  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	  filter: alpha(opacity=100);
	  opacity: 1.0;
	  -moz-opacity: 1.0; 
	  -khtml-opacity: 1.0;
	  background-color:#FFFFFF;
	  color:#0000AA;
	  position:fixed; top:10px; left:10px; width:auto; height:auto; max-width:50%; max-height:50%; text-align:center; cursor: default;outline: none;align-items: center; overflow-y:scroll;
	}

	</style>
<!-- search form css -->
<style>

* {box-sizing: border-box;}

/* Style Form Container */
.form-container {
    position: relative;
    padding: 16px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,.125);
}

/* Style Inline Form */
.form-inline {
    display: flex;
    align-items: center;
    justify-content: center;
    padding:5px;
}

/* Style Label */
label {
    display: inline-block;
    margin-right: .5rem;
    margin-bottom: 0;
    nowrap;
}

/* Style Input */
.form-control {
    display: block;
    width: 50%;
    padding: .375rem .75rem;
    margin-right: .5rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}

/* Style Checkbox Container */
.form-check {
    display: flex;
    flex: 0 0 130px;
}

/* Style Button */
.btn {
    display: inline-block;
    font-weight: 400;
    color: #ffffff;
    cursor: pointer;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    background-color: #007bff;
}

select, option {
    width: 250px;
}

option {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

/* Change Style when screen width is 768px or less*/
@media (max-width: 768px) {
    .form-inline {
        flex-direction: column;
        align-items: stretch;
    }
    label {
        margin-bottom: .5rem;
        margin-right: 0;
    }
    .form-control {
        margin-bottom: 1rem;
    }
    .form-check {
        display: flex;
        flex: 0 0 auto;
        margin-bottom: 1rem;
    }
    .btn {
        display: block;
        width: 100%;
    }
}
</style>

<!-- pagination styles -->
<style>
.paginate {
    display: inline-block;
    padding: 2px;
    text-align: center;
}

.paginate a {
    text-decoration: none;
    color: blue;
    float: left;
    padding: 10px 15px;
    text-align: center;
    border-radius: 10px;
    transition: background-color .5s; 
}

.paginate a.active {
    background-color: lightblue;
    color: lightblue;
    border-radius: 10px;
}

.paginate a:hover:not(.active) {
    background-color: lightgray;
}
</style>
<!-- Search button style -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

          <![endif]-->



        <!-- These two JS are loaded at the top for gray scale including the loader. -->



        <script src="/template/js/jquery-1.11.3.min.js"></script>

        <!-- jQuery (https://jquery.com/download/) -->

  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script>

        

            var tm_gray_site = false;
	       

            if(tm_gray_site) {

                $('html').addClass('gray');

            }

            else {

                $('html').removeClass('gray');   

            }

        </script>
        <script>

          $("img").on('contextmenu', function(e) {
              e.preventDefault();
          })

        </script>
        <script>
        function savefile(file, filename) {
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(file);
            a.download = filename;
            a.dispatchEvent(new MouseEvent('click'));
        }


        function downloadimage(imgpath){
            imgpathparts = imgpath.split("_lowres");
            origimgpath = imgpathparts[0] + imgpathparts[1];
            origimgpathparts = origimgpath.split("/");
            filename = origimgpathparts[origimgpathparts.length - 1];
            var anchor = document.querySelector('a');
            var a = document.createElement('a');
	    a.href = origimgpath;
            a.download = filename;
            a.style = 'display: none';
            anchor.parentNode.appendChild(a);
            a.click();
            a.remove();
            // Now send a request to server so that imagehits table is updated.
            var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
                    alert("Thanks for downloading.");
                }
            }
            targeturl = "/download";
            getdata = "imagepath=" + imgpath;
            getdata += "&_token=" + document.frmdummy._token.value;
            //alert(getdata);
            xmlhttp.open("GET",targeturl + "?" + getdata,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmdummy._token.value);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send();
        }


        function downloadimage_post(imgpath){
            //alert(imgpath);
            var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
                    var contentdisposition = xmlhttp.getResponseHeader('Content-Disposition');
                    var filename = contentdisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/)[1];
                    var type = xmlhttp.getResponseHeader('Content-Type');
                    var blob = new Blob([xmlhttp.response], {type : type});
                    savefile(blob, filename);
                }
            }
            targeturl = "/download";
            postdata = "imagepath=" + imgpath;
            postdata += "&_token=" + document.frmdummy._token.value;
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmdummy._token.value);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);
        }


        function showtagscontainer(){
            selectedmode = document.frmsearch.selmode.options[document.frmsearch.selmode.options.selectedIndex].value;
            containerdiv = document.getElementById('tagscontainer');
            if(selectedmode == 'tags'){
                containerdiv.innerHTML = "&nbsp;&nbsp; <input type='text' name='tagslist' size='30' placeholder='comma separated keywords'> &nbsp;&nbsp;";
            }
            else{
                containerdiv.innerHTML = "";
            }
        }


        function searchgallery(){
            mode = document.frmsearch.selmode.options[document.frmsearch.selmode.options.selectedIndex].value;
            tags = "";
            if(mode == "tags"){
                tags = document.frmsearch.tagslist.value;
            }
            document.frmsearch.action = "/gallery?mode=" + mode;
            if(tags != ""){
                document.frmsearch.action += "&tags=" + tags;
            }
            document.frmsearch.method='GET';
            document.frmsearch.submit();
        }


        function showprofileimagescreen(){
            profileimguploaddiv = document.getElementById('profileimagediv');
            profileimguploaddiv.style.display = "";
        }

        function closeuploadform(){
            profileimguploaddiv = document.getElementById('profileimagediv');
            profileimguploaddiv.style.display = "none";
        }

        function uploadprofileimage(){
            var xmlhttp;
            statusdiv = document.getElementById('profstatus');
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
                    window.location.reload(true);
                }
            }
            var file = document.getElementById('uploadfile').files[0];
            formdata = new FormData();
            formdata.append("uploadfile", file);
            csrftoken = document.frmprofimg._token.value;
            formdata.append("_token", csrftoken);
            xmlhttp.open('POST', "/changeprofileimage", true);
            xmlhttp.send(formdata);
            statusdiv.innerHTML = "<img src='/images/loading_small.gif'>";
        }

	function closeimg(){
  	  screendiv = document.getElementById('transscreens');
  	  screendiv.innerHTML = "";
  	  screendiv.style.display = "none";
	}

	function showdownloadimage(imgpath){
	  //alert("Download Image");
	  winnew = window.open("/downloadpopup?imagepath=" + imgpath, "downloadwindow", "width=1080,height=640,toolbar=no,location=no");
	  closeimg();
	}

	function showoverlay(imgpath){
	  //alert(imgpath);
  	  screendiv = document.getElementById('transscreens');
	  screendiv.innerHTML = "<a href='#_' onclick='javascript:closeimg();' style='color:blue;font-weight:bold;'>Close</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:showdownloadimage(\"" + imgpath + "\");' style='color:blue;font-weight:bold;'>Download</a>";
  	  screendiv.innerHTML += "<br><img src='" + imgpath + "' style='width:100%;height:100%;'>";
	  screendiv.innerHTML += "<br><a href='#_' onclick='javascript:closeimg();' style='color:blue;font-weight:bold;'>Close</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:showdownloadimage(\"" + imgpath + "\");' style='color:blue;font-weight:bold;'>Download</a>";
  	  screendiv.style.display = "";
	}
        </script>
	<script src="/template/js/common.js.download" defer=""></script>
	<style>
	img {
	    pointer-events: none;
	}
	</style>
	</head>

	<body>



		<!-- Header -->

		<!--	<header id="header">

				<div class="inner">

					<div class="content">

						<h1>Radius</h1>

						<h2>A fully responsive masonry-style<br />

						portfolio template.</h2>

						<a href="#" class="button big alt"><span>Let's Go</span></a>

					</div>

					<a href="#" class="button hidden"><span>Let's Go</span></a>

				</div>

			</header>
		-->
	<!-- HTML from the template download page -->

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

	<!-- HTML from template download page ends here... -->
<div class="form-container">
<form name='frmsearch' method='GET' class="form-inline" style="color:blue;">
<label style="color:blue;">Search Images </label>&nbsp;&nbsp;<select name='selmode' id='selmode' onchange='javascript:showtagscontainer();'>
<?php
	if(!array_key_exists('selmode', $_GET) || $_GET['selmode'] == "all"){
?>
  <option value='all'>Show All</option>
  <option value='popularity'>By Popularity</option>
  <option value='tags'>By Keywords</option>
<?php
	}
	elseif(array_key_exists('selmode', $_GET) && $_GET['selmode'] == "popularity"){
?>
  <option value='all'>Show All</option>
  <option value='popularity' selected>By Popularity</option>
  <option value='tags'>By Keywords</option>
<?php
	}
	elseif(array_key_exists('selmode', $_GET) && $_GET['selmode'] == "tags"){
?>
  <option value='all'>Show All</option>
  <option value='popularity'>By Popularity</option>
  <option value='tags' selected>By Keywords</option>
<?php
	}
?>
</select>&nbsp;&nbsp;
<?php
	if(array_key_exists('selmode', $_GET) && $_GET['selmode'] == "tags"){
?>
<span id='tagscontainer'>&nbsp;&nbsp;<input type='text' name='tagslist' size='30' value="<?php echo $_GET['tagslist']; ?>" placeholder='Comma separated keywords'> &nbsp;&nbsp;</span>
<?php
}
else{
?>
<span id='tagscontainer'></span>
<?php
}
?>
&nbsp;&nbsp;<input type='button' name='btngo' id='btngo' value='Search' onClick='javascript:searchgallery();' style="background-image: url(/images/search.png);background-repeat: no-repeat;cursor: pointer;border:none;vertical-align:middle;padding:5px;">
</form>
</div>
		<!-- old css ends -->

		<!-- Main -->
			<div style='text-align:center;'>
			<div class='paginate'>
				    <?php
					 if($startpoint < $totalcount){
					      echo "<a href='/gallery?startpoint=".$startpoint."'>Next<img src='/images/next.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					      echo "<a href='/gallery?lastpoint=".$lastpoint."'>Last<img src='/images/last.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					 }
					 if($startpoint > $chunksize){
					      $prev = $startpoint - 2*$chunksize;
					      if($prev < 0){
						  $prev = 0;
					      }
					     echo "<a href='/gallery?startpoint=0'>First<img src='/images/first.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					     echo "<a href='/gallery?startpoint=".$prev."'>Prev<img src='/images/prev.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					 }
				    ?>

				    <br />
			</div>
			</div>
			<div id="main">

				<div class="inner">

					<div class="columns">
						<?php 
						    $ctr = 1;
						?>
						@foreach ($images as $img)
				                        <?php
				                        $imagepathparts = explode("users", $img->imagepath);
				                        $imagepath = "/image".$imagepathparts[1];
				                        $lowrespathparts = explode("users", $img->lowrespath);
				                        $lowrespath = "/image".$lowrespathparts[1];
				                        $iconpathparts = explode("users", $img->iconpath);
				                        $iconpath = "/image".$iconpathparts[1];
				                        ?>


							<div class="image fit">
								<a href="#_" onclick="javascript:showoverlay('<?php echo $lowrespath; ?>');">
								<img src="<?php echo $lowrespath; ?>">
								</a>
							</div>
							<?php
							    $ctr++;
							?>

						@endforeach
						<div id="transscreens" class="semitrans" style="max-height:80%;max-width:80%;display:none;"></div>

						<form name='frmdummy'>
                                        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                		</form>

					</div>

				</div>

			</div>

		<br /><br />

		<!-- Footer -->


				<br /><br />
				<div style='text-align:center;'>
				<div class='paginate'>
				    <?php
					 if($startpoint < $totalcount){
					      echo "<a href='/gallery?startpoint=".$startpoint."'>Next<img src='/images/next.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					      echo "<a href='/gallery?lastpoint=".$lastpoint."'>Last<img src='/images/last.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					 }
					 if($startpoint > $chunksize){
					      $prev = $startpoint - 2*$chunksize;
					      if($prev < 0){
						  $prev = 0;
					      }
					     echo "<a href='/gallery?startpoint=0'>First<img src='/images/first.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					     echo "<a href='/gallery?startpoint=".$prev."'>Prev<img src='/images/prev.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					 }
				    ?>

				    <br /><br />
					<!-- 

					<div class="copyright">

						<h3>Follow me</h3>

						<ul class="icons">

							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>

							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>

							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>

							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>

						</ul>

						&copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com/">Unsplash</a>.

					</div>
					-->

				</div>
				</div>

		<!-- Scripts -->

			<script src="template/js/jquery.min.js"></script>

			<script src="template/js/skel.min.js"></script>

			<script src="template/js/util.js"></script>

			<script src="template/js/main.js"></script>



	</body>

</html>


