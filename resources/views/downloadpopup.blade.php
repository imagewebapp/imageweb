<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Image Download</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <style>
	/*****************globals*************/
	body {
	  font-family: 'open sans';
	  overflow-x: hidden; }

	img {
	  max-width: 100%; }

	.preview {
	  display: -webkit-box;
	  display: -webkit-flex;
	  display: -ms-flexbox;
	  display: flex;
	  -webkit-box-orient: vertical;
	  -webkit-box-direction: normal;
	  -webkit-flex-direction: column;
	      -ms-flex-direction: column;
		  flex-direction: column; }
	  @media screen and (max-width: 996px) {
	    .preview {
	      margin-bottom: 20px; } }

	.preview-pic {
	  -webkit-box-flex: 1;
	  -webkit-flex-grow: 1;
	      -ms-flex-positive: 1;
		  flex-grow: 1; }

	.preview-thumbnail.nav-tabs {
	  border: none;
	  margin-top: 15px; }
	  .preview-thumbnail.nav-tabs li {
	    width: 18%;
	    margin-right: 2.5%; }
	    .preview-thumbnail.nav-tabs li img {
	      max-width: 100%;
	      display: block; }
	    .preview-thumbnail.nav-tabs li a {
	      padding: 0;
	      margin: 0; }
	    .preview-thumbnail.nav-tabs li:last-of-type {
	      margin-right: 0; }

	.tab-content {
	  overflow: hidden; }
	  .tab-content img {
	    width: 100%;
	    -webkit-animation-name: opacity;
		    animation-name: opacity;
	    -webkit-animation-duration: .3s;
		    animation-duration: .3s; }

	.card {
	  margin-top: 50px;
	  background: #eee;
	  padding: 3em;
	  line-height: 1.5em; }

	@media screen and (min-width: 997px) {
	  .wrapper {
	    display: -webkit-box;
	    display: -webkit-flex;
	    display: -ms-flexbox;
	    display: flex; } }

	.details {
	  display: -webkit-box;
	  display: -webkit-flex;
	  display: -ms-flexbox;
	  display: flex;
	  -webkit-box-orient: vertical;
	  -webkit-box-direction: normal;
	  -webkit-flex-direction: column;
	      -ms-flex-direction: column;
		  flex-direction: column; }

	.colors {
	  -webkit-box-flex: 1;
	  -webkit-flex-grow: 1;
	      -ms-flex-positive: 1;
		  flex-grow: 1; }

	.product-title, .price, .sizes, .colors {
	  text-transform: UPPERCASE;
	  font-weight: bold; }

	.checked, .price span {
	  color: #ff9f1a; }

	.product-title, .rating, .product-description, .price, .vote, .sizes {
	  margin-bottom: 15px; }

	.product-title {
	  margin-top: 0; }

	.size {
	  margin-right: 10px; }
	  .size:first-of-type {
	    margin-left: 40px; }

	.color {
	  display: inline-block;
	  vertical-align: middle;
	  margin-right: 10px;
	  height: 2em;
	  width: 2em;
	  border-radius: 2px; }
	  .color:first-of-type {
	    margin-left: 20px; }

	.add-to-cart, .like {
	  background: #ff9f1a;
	  padding: 1.2em 1.5em;
	  border: none;
	  text-transform: UPPERCASE;
	  font-weight: bold;
	  color: #fff;
	  -webkit-transition: background .3s ease;
		  transition: background .3s ease; }
	  .add-to-cart:hover, .like:hover {
	    background: #b36800;
	    color: #fff; }

	.not-available {
	  text-align: center;
	  line-height: 2em; }
	  .not-available:before {
	    font-family: fontawesome;
	    content: "\f00d";
	    color: #fff; }

	.orange {
	  background: #ff9f1a; }

	.green {
	  background: #85ad00; }

	.blue {
	  background: #0076ad; }

	.tooltip-inner {
	  padding: 1.3em; }

	@-webkit-keyframes opacity {
	  0% {
	    opacity: 0;
	    -webkit-transform: scale(3);
		    transform: scale(3); }
	  100% {
	    opacity: 1;
	    -webkit-transform: scale(1);
		    transform: scale(1); } }

	@keyframes opacity {
	  0% {
	    opacity: 0;
	    -webkit-transform: scale(3);
		    transform: scale(3); }
	  100% {
	    opacity: 1;
	    -webkit-transform: scale(1);
		    transform: scale(1); } }

	/*# sourceMappingURL=style.css.map */

    </style>
    <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
    <script>
	imgpath = '<?php echo $imagepath; ?>';
	function showimage(lowrespath){
	    imagedetails = <?php echo json_encode($imagesinfo); ?>;
	    imagetag = document.getElementById('mainimage');
	    imagetag.src = lowrespath;
	    window.scrollTo(0, 0);
	    if(imagedetails.hasOwnProperty(lowrespath)){
		imghits = document.getElementById('imagehits');
		imghits.innerHTML = imagedetails[lowrespath]['imagehits'] + " downloads";
		imgtags = document.getElementById('imagetags');
		imgtags.innerHTML = imagedetails[lowrespath]['imagetags'];
		imgprice = document.getElementById('price');
		price = imagedetails[lowrespath]['price'];
		if(imagedetails[lowrespath]['price'] == 0 || imagedetails[lowrespath]['price'] == ""){
		    imagedetails[lowrespath]['price'] = "CURRENT PRICE: FREE";
		}
		else{
		    imagedetails[lowrespath]['price'] = "CURRENT PRICE (US$): " + imagedetails[lowrespath]['price'];
		}
		imgprice.innerHTML = imagedetails[lowrespath]['price'];
		imgcats = document.getElementById('imagecategory');
		imgcats.innerHTML = imagedetails[lowrespath]['categories'];
		imgowner = document.getElementById('owner');
		imgowner.innerHTML = imagedetails[lowrespath]['owner'];
		premiumspan = document.getElementById('premium');
		if(price > 0){
		    premiumspan.innerHTML = "&nbsp;&nbsp;<button class='add-to-cart btn btn-default' id='btnbuy' type='button' onclick='javascript:buyimage(\"" + lowrespath + "\");'>Buy Original</button><span id='waitpdiv'></span>";
		}
		else{
		    premiumspan.innerHTML = "";
		}
		//captchadiv = document.getElementById('captchacontent');
		//captchadiv.innerHTML = "<div class='g-recaptcha' data-sitekey='6LdR4fUUAAAAALCtrHM_1X9W1S-Q0s5JvL-Zln2s'></div>";
		downloadbutton = document.getElementById('btndownload');
		imgpath = lowrespath;
		downloadbutton.onclick = downloadimage;
	    }
	    imagetag.focus();
	}


	function downloadimage(){
            //imgpathparts = imgpath.split("_lowres");
            //origimgpath = imgpathparts[0] + imgpathparts[1];
            //origimgpathparts = origimgpath.split("/");
            //filename = origimgpathparts[origimgpathparts.length - 1];
	    // ===================================
	    imgpathparts = imgpath.split("/");
	    filename = imgpathparts[imgpathparts.length - 1];
	    // ===================================
            var anchor = document.querySelector('a');
            var a = document.createElement('a');
	    //a.href = origimgpath;
	    a.href = imgpath;
            a.download = filename;
            a.style = 'display: none';
            anchor.parentNode.appendChild(a);
	    waiter = document.getElementById('waitdiv');
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
		    waiter.innerHTML = "";
		    a.click();
            	    a.remove();
                    alert("Thanks for downloading.");
                }
		else if(xmlhttp.readyState == 4 && xmlhttp.status==400){
		    waiter.innerHTML = "";
		    alert(xmlhttp.responseText);
		}
            }
            targeturl = "/download";
            getdata = "imagepath=" + imgpath;
            getdata += "&_token=" + document.frmdummy._token.value;
	    getdata += "&g-recaptcha-response=" + grecaptcha.getResponse();
            //alert(getdata);
            xmlhttp.open("GET",targeturl + "?" + getdata,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmdummy._token.value);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send();
	    waiter.innerHTML = "<img src='/images/loading_small.gif'>";
        }

	function buyimage(){
	}
    </script>
    <link rel="stylesheet" href="template/css/main.css" />
  </head>

  <body>
	
	<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="<?php echo $imagepath; ?>" id="mainimage" /></div>
						  <!--
						  <div class="tab-pane" id="pic-2"><img src="http://placekitten.com/400/252" /></div>
						  <div class="tab-pane" id="pic-3"><img src="http://placekitten.com/400/252" /></div>
						  <div class="tab-pane" id="pic-4"><img src="http://placekitten.com/400/252" /></div>
						  <div class="tab-pane" id="pic-5"><img src="http://placekitten.com/400/252" /></div>
						  -->
						</div>
						<!--
						<ul class="preview-thumbnail nav nav-tabs">
						  <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
						  <li><a data-target="#pic-2" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
						  <li><a data-target="#pic-3" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
						  <li><a data-target="#pic-4" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
						  <li><a data-target="#pic-5" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>
						</ul>
						-->
					</div>
					<div class="details col-md-6">
						<h3 class="product-title" id="imagetags"><?php echo $imagetags; ?></h3>
						<div class="rating">
							<div class="stars" id="stars">
								<?php
								if($imagehits == 0 || !$imagehits){
								?>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<?php
								}
								elseif($imagehits > 0 && $imagehits <= 10){
								?>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<?php
								}
								elseif($imagehits > 10 && $imagehits <= 25){
								?>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<?php
								}
								elseif($imagehits > 25 && $imagehits <= 50){
								?>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
								<?php
								}
								elseif($imagehits > 50 && $imagehits <= 75){
								?>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<?php
								}
								elseif($imagehits > 75){
								?>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<?php
								}
								?>
							</div>
							<span class="review-no" id="imagehits"><?php echo $imagehits; ?> downloads</span>
						</div>
						<p class="product-description" id="imagecategory"><?php echo $imagecategory; ?>.</p>
						<?php
						if($imageprice == "FREE"){
						?>
						<h4 class="price" id="price">current price (US$): <span>FREE</span></h4>
						<?php
						}
						else{
						?>
						<h4 class="price" id="price">current price (US$): <span><?php echo number_format(round($imageprice,2), 2); ?></span></h4>
						<?php
						}
						?>
						<p class="vote" id="owner">This image is owned by <strong><?php echo $imageowner; ?></strong></p>
						<!--
						<h5 class="sizes">sizes:
							<span class="size" data-toggle="tooltip" title="small">s</span>
							<span class="size" data-toggle="tooltip" title="medium">m</span>
							<span class="size" data-toggle="tooltip" title="large">l</span>
							<span class="size" data-toggle="tooltip" title="xtra large">xl</span>
						</h5>
						<h5 class="colors">colors:
							<span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
							<span class="color green"></span>
							<span class="color blue"></span>
						</h5>
						-->
						<div id="captchacontent">
						<div class="g-recaptcha" data-sitekey="6LdR4fUUAAAAALCtrHM_1X9W1S-Q0s5JvL-Zln2s"></div>
						</div>
						<div class="action">

							<button class="add-to-cart btn btn-default" id="btndownload" type="button" onclick="javascript:downloadimage();">Free Download</button><span id='waitdiv'></span><span id="premium">
							<?php
							if(round($imageprice, 2) > 0.00){
							?> 
							&nbsp;&nbsp;<button class="add-to-cart btn btn-default" id="btnbuy" type="button" onclick="javascript:buyimage('<?php echo $imagepath; ?>');">Buy Original</button><span id='waitpdiv'></span>
							<?php
							}
							?>
							</span>
							<!-- <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button> -->
							<button class="add-to-cart btn btn-default" type="button" onclick="javascript:window.close();">Close</button>
						</div>
					</div>
				</div>
			</div>
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
								<a href="#_" onclick="javascript:showimage('<?php echo $lowrespath; ?>');">
								<img src="<?php echo $lowrespath; ?>">
								</a>
							</div>
							<?php
							    $ctr++;
							?>

						@endforeach

						<form name='frmdummy'>
                                        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                		</form>
					</div>

				</div>

			</div>
  </body>
</html>


