<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>ImageWeb Gallery</title>

<!--

Fluid Gallery Template

http://www.templatemo.com/tm-500-fluid-gallery

-->

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
	    //alert("Change Profile Image");
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

	</script>


</head>



    <body>
	 <!-- Navigation -->        

            

        <div class="navbar-brand text-uppercase" href="#"><i class="fa fa-picture-o tm-brand-icon"></i>ImageWeb Gallery</div>

	<div class="tm-navbar-bg">

            <ul class="nav navbar-nav">

                <li class="nav-item active selected">

                    <a href="/gallery">Gallery <span class="sr-only">(current)</span></a>

                </li>                                

                <li class="nav-item">

                    <a href="/dashboard">Dashboard</a>

                </li>

                <li class="nav-item">

                    <a href="#0" data-no="3">3rd fluid</a>

                </li>

                <li class="nav-item">

                    <a href="#0" data-no="4">Columns</a>

                </li>

                <li class="nav-item">
		    <?php
                        if($username != ""){
                            echo "<img src='".$profileimage."' height='50px' width='50px'>You are logged in as ".$username;
			    echo "<a href='/logout' data-no='5'>Logout</a>";
			    echo "<br/><a href='#/' onClick='javascript:showprofileimagescreen();'>Change Profile Image</a>";
			    echo "<br/><div id='profileimagediv' style='display:none;'><form id='frmprofimg' name='frmprofimg'><input type='file' name='uploadfile' id='uploadfile'><input type='button' name='btnupload' value='  Go  ' onClick='javascript:uploadprofileimage();'><div id='profstatus'></div><input type='button' name='btnclose' value='Close' onClick='javascript:closeuploadform();'>";
		    ?>
                     <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                    <?php
                            echo "</form></div>";
                        }
			else{
			    echo "<a href='/login'>Login</a> or <a href='/register'>Register</a>";
			}
                    ?> 

                </li>

            </ul>



    	</div>

        

        <!-- Content -->

        <div class="cd-hero">
        <!--
	<form name='frmsearch' method='GET'>

	<div align='center'>
	    Search Images <select name='selmode' onchange='javascript:showtagscontainer();'>
	    <option value='all'>Show All</option>
	    <option value='popularity'>By Popularity</option>
	    <option value='tags'>By Keywords</option>
	</select>
	<input type='button' name='btngo' id='btngo' value='  Go  ' onClick='javascript:searchgallery();'>
	<div id='tagscontainer'></div></div>
	</form>
	-->
            <ul class="cd-hero-slider">



                <li class="selected">                    

                    <div class="cd-full-width">

                        <div class="container-fluid js-tm-page-content" data-page-no="1" data-page-type="gallery">

                            <div class="tm-img-gallery-container">

                                <div class="tm-img-gallery gallery-one">

                                <!-- Gallery One pop up connected with JS code below -->
                                @foreach ($images as $img)
                                        <?php
                                        $imagepathparts = explode("users", $img->imagepath);
                                        $imagepath = "/image".$imagepathparts[1];
                                        $lowrespathparts = explode("users", $img->lowrespath);
                                        $lowrespath = "/image".$lowrespathparts[1];
                                        $iconpathparts = explode("users", $img->iconpath);
                                        $iconpath = "/image".$iconpathparts[1];
                                        ?>

                                    <div class="grid-item">

                                        <figure class="effect-sadie">

                                            <img src="<?php echo $lowrespath; ?>" alt="Image" class="img-fluid tm-img">

                                            <figcaption>

                                                <a href="<?php echo $imagepath; ?>">View Image</a>

                                            </figcaption>           

                                        </figure>

                                    </div>
				@endforeach
				<form name='frmdummy'>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
				
				</div>                                 

                            </div>

                        </div> 

                    </div>

                </li>

            </ul> <!-- .cd-hero-slider -->
	    <!--
	    <br /><br />
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
	    --> 

            <br /><br />

            <footer class="tm-footer">

            

                <div class="tm-social-icons-container text-xs-center">

                    <a href="#" class="tm-social-link"><i class="fa fa-facebook"></i></a>

                    <a href="#" class="tm-social-link"><i class="fa fa-google-plus"></i></a>

                    <a href="#" class="tm-social-link"><i class="fa fa-twitter"></i></a>

                    <a href="#" class="tm-social-link"><i class="fa fa-behance"></i></a>

                    <a href="#" class="tm-social-link"><i class="fa fa-linkedin"></i></a>

              </div>

                

                <p class="tm-copyright-text">Copyright &copy; <span class="tm-copyright-year">2020</span> Image Web 

                

                 | Design: <a href="www.templatemo.com" target="_parent">Template Mo</a></p>



            </footer>

                    

        </div> <!-- .cd-hero -->

        



        <!-- Preloader, https://ihatetomatoes.net/create-custom-preloading-screen/ -->

        <div id="loader-wrapper">

            

            <div id="loader"></div>

            <div class="loader-section section-left"></div>

            <div class="loader-section section-right"></div>



        </div>

        

        <!-- load JS files -->

        

        <script src="/template/js/tether.min.js"></script> <!-- Tether (http://tether.io/)  --> 

        <script src="/template/js/bootstrap.min.js"></script>             <!-- Bootstrap js (v4-alpha.getbootstrap.com/) -->

        <script src="/template/js/hero-slider-main.js"></script>          <!-- Hero slider (https://codyhouse.co/gem/hero-slider/) -->

        <script src="/template/js/jquery.magnific-popup.min.js"></script> <!-- Magnific popup (http://dimsemenov.com/plugins/magnific-popup/) -->

        

        <script>



            function adjustHeightOfPage(pageNo) {



                var pageContentHeight = 0;



                var pageType = $('div[data-page-no="' + pageNo + '"]').data("page-type");



                if( pageType != undefined && pageType == "gallery") {

                    pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .tm-img-gallery-container").height();

                }

                else {

                    pageContentHeight = $(".cd-hero-slider li:nth-of-type(" + pageNo + ") .js-tm-page-content").height() + 20;

                }

               

                // Get the page height

                var totalPageHeight = $('.cd-slider-nav').height()

                                        + pageContentHeight

                                        + $('.tm-footer').outerHeight();



                // Adjust layout based on page height and window height

                if(totalPageHeight > $(window).height()) 

                {

                    $('.cd-hero-slider').addClass('small-screen');

                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", totalPageHeight + "px");

                }

                else 

                {

                    $('.cd-hero-slider').removeClass('small-screen');

                    $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css("min-height", "100%");

                }

            }



            /*

                Everything is loaded including images.

            */

            $(window).load(function(){



                adjustHeightOfPage(1); // Adjust page height



                /* Gallery One pop up

                -----------------------------------------*/

                $('.gallery-one').magnificPopup({

                    delegate: 'a', // child items selector, by clicking on it popup will open

                    type: 'image',

                    gallery:{enabled:true}                

                });

				

                /* Collapse menu after click 

                -----------------------------------------*/

                $('#tmNavbar a').click(function(){

                    $('#tmNavbar').collapse('hide');



                    adjustHeightOfPage($(this).data("no")); // Adjust page height       

                });



                /* Browser resized 

                -----------------------------------------*/

                $( window ).resize(function() {

                    var currentPageNo = $(".cd-hero-slider li.selected .js-tm-page-content").data("page-no");

                    

                    // wait 3 seconds

                    setTimeout(function() {

                        adjustHeightOfPage( currentPageNo );

                    }, 1000);

                    

                });

        

                // Remove preloader (https://ihatetomatoes.net/create-custom-preloading-screen/)

                $('body').addClass('loaded');



                // Write current year in copyright text.

                $(".tm-copyright-year").text(new Date().getFullYear());

                           

            });



        </script>            



</body>

</html>


