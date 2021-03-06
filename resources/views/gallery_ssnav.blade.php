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

		<link rel="stylesheet" href="template/css/main.css" />

		<!-- Top Panel CSS -->
		<link href="/template/css/p7DMM01.css" rel="stylesheet" media="all">
		<link href="/template/css/p7affinity-1_02.css" rel="stylesheet">
		<link href="/template/css/p7affinity_print.css" rel="stylesheet" media="print">
		<link href="/template/css/_jyotish.css" rel="stylesheet" type="text/css">

		<!-- Top Panel CSS ends -->

<link rel="stylesheet" 
  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<style>

.semitrans {
	  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	  filter: alpha(opacity=100);
	  opacity: 1.0;
	  -moz-opacity: 1.0; 
	  -khtml-opacity: 1.0;
	  background-color:#FFFFFF;
	  color:#0000AA;
	  position:fixed; top:0; left:0; width:auto; height:auto; max-width:80%; max-height:80%; text-align:center; cursor: default;outline: none;align-items: center; overflow-y:scroll;
	}

	</style>

<style>
select {
  width: 250px;
}

option {
  width: 250px;
}
</style>

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

          $("body").on('contextmenu', function(e) {
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
                containerdiv.innerHTML = "<input type='text' name='tagslist' size='30'> Multiple tags should be separated by commas";
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

	function showoverlay(imgpath){
	  //alert(imgpath);
  	  screendiv = document.getElementById('transscreens');
  	  screendiv.innerHTML = "<img src='" + imgpath + "' style='width:100%;height:100%;'>";
	  screendiv.innerHTML += "<br><a href='#_' onclick='javascript:closeimg();'>Close</a>";
  	  screendiv.style.display = "";
	}
        </script>
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
<div class="masthead"> <span class="name">Site Title Here</span><br>
  Put some text here... </div>

<div class="top-navigation">
  <div class="menu-top-wrapper">
    <div id="p7DMM_1" class="p7DMM01 p7DMM p7dmm-left responsive">
      <div id="p7DMMtb_1" class="p7DMM-toolbar closed"></div>
      <ul id="p7DMMu_1" class="p7DMM01-menu closed">
        <li><a href="/gallery">Gallery <span class="sr-only">(current)</span></a></li>
        <li><a href="/dashboard">Dashboard</a></li>
	<?php
          if(isset($usertype) && $usertype == "admin"){
        ?>
        <li><a href="/verifyimagesiface">Verify Images</a></li>
        <?php
          }
        ?>
        <li><a href="#0" data-no="3">About us</a></li>
        <li><a href="#0" data-no="4">Terms and Conditions</a></li>
          <?php
                        if($username != ""){
                            echo "<li>You are logged in as ".$username."<img src='".$profileimage."' height='50px' width='50px'></li>";
                            echo "<li><a href='/logout' data-no='5'>Logout</a></li>";
                            echo "<li><a href='#/' onClick='javascript:showprofileimagescreen();'>Change Profile Image</a></li>";
                            echo "<div id='profileimagediv' style='display:none;'><form id='frmprofimg' name='frmprofimg'><input type='file' name='uploadfile' id='uploadfile'><input type='button' name='btnupload' value='  Go  ' onClick='javascript:uploadprofileimage();'><div id='profstatus'></div><input type='button' name='btnclose' value='Close' onClick='javascript:closeuploadform();'>";
                    ?>
                     <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                    <?php
		     echo "</form></div>";
                        }
                        else{
                            echo "<li><a href='/login'>Login</a> or <a href='/register'>Register</a></li>";
                        }
                    ?>
        </li>
    </div>
  </div>
</div>
</div>
<!-- Top panel ends here -->

	<!-- HTML from template download page ends here... -->

			
	    <!-- old css start -->
<form name='frmsearch' method='GET' class="form-horizontal">
<div align='center' class="row">
<ul  class="p7DMM01-menu closed">
<li>Search Images </li><li><select name='selmode' id='selmode' onchange='javascript:showtagscontainer();'></li>
  <option value='all'>Show All</option>
  <option value='popularity'>By Popularity</option>
  <option value='tags'>By Keywords</option>
</select>
<li><input type='button' name='btngo' id='btngo' value='  Go  ' onClick='javascript:searchgallery();'></li>
</ul>
<div id='tagscontainer'></div></div>
</form>
		<!-- old css ends -->

		<!-- Main -->

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

			<div id="footer">

				<br /><br />
				<div>
				    <?php

					 if($startpoint < $totalcount){
					      echo "<div align='center'><a href='/gallery?startpoint=".$startpoint."'>Next</a></div>";
					 }
					 if($startpoint > $chunksize){
					      $prev = $startpoint - 2*$chunksize;
					      if($prev < 0){
						  $prev = 0;
					      }
					     echo "<div align='center'><a href='/gallery?startpoint=".$prev."'>Prev</a></div>";
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


