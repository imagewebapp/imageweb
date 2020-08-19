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
	  overflow-x: hidden;
	}

	img {
	  max-width: 100%;
	  pointer-events: none;
	}

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
    <style>

	.semitrans {
		  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		  filter: alpha(opacity=100);
		  opacity: 1.0;
		  -moz-opacity: 1.0; 
		  -khtml-opacity: 1.0;
		  background-color:#a8e7f0;
		  color:#0000AA;
		  position:absolute; top:10px; left:10px; width:auto; height:auto; max-width:100%; max-height:100%; text-align:center; cursor: default;outline: none;align-items: center;border: 10px solid rgba(0, 0, 0, 0.3);overflow-x:scroll;overflow-y:scroll;
		}

    </style>

    <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
    <script>
	$('img').mousedown(function (e) {
	  if(e.button == 2) { // right click
	    return false; // do nothing!
	  }
	});
    </script>
    <script>
	imgpath = '<?php echo $imagepath; ?>';
	imprice = 0.00;
	<?php
	if($imageprice == "FREE" || round($imageprice,2) == 0.00){
	?>
	    imprice = 0.00;
	<?php
	}
	else{
	?>
	    imprice = <?php echo number_format(round($imageprice,2), 2); ?>;
	<?php
	}
	?>
	
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
		    imagedetails[lowrespath]['price'] = "CURRENT PRICE (US$): " + parseFloat(imagedetails[lowrespath]['price']).toFixed(2);
		}
		imgprice.innerHTML = imagedetails[lowrespath]['price'];
		imgcats = document.getElementById('imagecategory');
		imgcats.innerHTML = imagedetails[lowrespath]['categories'];
		imgowner = document.getElementById('owner');
		imgowner.innerHTML = imagedetails[lowrespath]['owner'];
		premiumspan = document.getElementById('premium');
		if(price > 0){
		    premiumspan.innerHTML = "&nbsp;&nbsp;<button class='add-to-cart btn btn-default' id='btnbuy' type='button' onclick='javascript:buyimage(\"" + lowrespath + "\");'>Buy Original</button><span id='waitpdiv'></span>";
		    buyorigdiv = document.getElementById("buyorig");
		    buyorigdiv.innerHTML = '"Buy Original" allows you to purchase and download the original high resolution version of the selected image.';
		}
		else{
		    premiumspan.innerHTML = "";
		    buyorigdiv = document.getElementById("buyorig");
		    buyorigdiv.innerHTML = "";
		}
		starsdiv = document.getElementById("stars");
		if(!imagedetails[lowrespath]['imagehits'] || imagedetails[lowrespath]['imagehits'] == 0){
		    starsdiv.innerHTML = "<span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span>";
		}
		else if(imagedetails[lowrespath]['imagehits'] > 0 && imagedetails[lowrespath]['imagehits'] <= 10){
		    starsdiv.innerHTML = "<span class='fa fa-star checked'></span><span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span>";
		}
		else if(imagedetails[lowrespath]['imagehits'] > 10 && imagedetails[lowrespath]['imagehits'] <= 25){
		    starsdiv.innerHTML = "<span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star'></span><span class='fa fa-star'></span><span class='fa fa-star'></span>";
		}
		else if(imagedetails[lowrespath]['imagehits'] > 25 && imagedetails[lowrespath]['imagehits'] <= 50){
		    starsdiv.innerHTML = "<span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star'></span><span class='fa fa-star'></span>";
		}
		else if(imagedetails[lowrespath]['imagehits'] > 50 && imagedetails[lowrespath]['imagehits'] <= 75){
		    starsdiv.innerHTML = "<span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star'></span>";
		}
		else if(imagedetails[lowrespath]['imagehits'] > 75){
		    starsdiv.innerHTML = "<span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span><span class='fa fa-star checked'></span>";
		}
		//captchadiv = document.getElementById('captchacontent');
		//captchadiv.innerHTML = "<div class='g-recaptcha' data-sitekey='6LdR4fUUAAAAALCtrHM_1X9W1S-Q0s5JvL-Zln2s'></div>";
		downloadbutton = document.getElementById('btndownload');
		imgpath = lowrespath;
		imprice = imagedetails[lowrespath]['price'];
		//alert(imagedetails[lowrespath]['price']);
		if(imagedetails[lowrespath]['price'] == "CURRENT PRICE: FREE"){
		    imprice = 0.00;
		}
		//alert(imprice);
		downloadbutton.onclick = downloadimage;
	    }
	    imagetag.focus();
	    closescreen();
	}


	function downloadimage(){
	    filename = "";
	    imprice = imprice.toString(10);
	    imprice = imprice.replace("CURRENT PRICE (US$): ", "");
	    if(parseFloat(imprice) == 0.00 || imprice == "CURRENT PRICE: FREE" || !imprice || isNaN(parseFloat(imprice))){
                imgpathparts = imgpath.split("_lowres");
            	origimgpath = imgpathparts[0] + imgpathparts[1];
            	origimgpathparts = origimgpath.split("/");
            	filename = origimgpathparts[origimgpathparts.length - 1];
	    }
	    else{
	    
	    // ===================================
	    	imgpathparts = imgpath.split("/");
	    	filename = imgpathparts[imgpathparts.length - 1];
	    // ===================================
	    
	    }
	    
            var anchor = document.querySelector('a');
            var a = document.createElement('a');
	    //alert(imprice);
	    imprice = imprice.replace("CURRENT PRICE (US$): ", "");
	    //alert(typeof(imprice));
	    //alert(isNaN(parseFloat(imprice)));
	    if(parseFloat(imprice) == 0.00 || imprice == "CURRENT PRICE: FREE" || !imprice || isNaN(parseFloat(imprice))){
	     	a.href = origimgpath;
		//alert("original " + origimgpath);
	    }
	    else{
	    	a.href = imgpath;
		//alert("lowres " + imgpath);
	    }
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

	function closescreen(){
	    screendiv = document.getElementById('transscreens');
  	    screendiv.innerHTML = "";
  	    screendiv.style.display = "none";
	}

	function paypal(lowresimgpath){
	    pgdivelem = document.getElementById('pgdiv');
	    pgdivelem.style.display = "";
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    //alert(xmlhttp.responseText);
		    pgdivelem.innerHTML = xmlhttp.responseText;
                }
            }
            targeturl = "/paypalpayment?img=" + lowresimgpath;
            xmlhttp.open("GET",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmdummy._token.value);
            xmlhttp.send();
	}

	function stripe(lowresimgpath){
	    pgdivelem = document.getElementById('pgdiv');
	    pgdivelem.style.display = "";
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    //alert(xmlhttp.responseText);
		    pgdivelem.innerHTML = xmlhttp.responseText;
                }
            }
            targeturl = "/cardpayment?img=" + lowresimgpath;
            xmlhttp.open("GET",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmdummy._token.value);
            xmlhttp.send();
	}

	function buyimage(lowresimgpath){
	    captchaval = grecaptcha.getResponse();
	    if(!captchaval || captchaval == ""){
		alert("Please fulfil the captcha challenge to continue.");
		return(false);
	    }
	    // Check login status
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
	    xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    //alert(xmlhttp.responseText);
		    if(xmlhttp.responseText == '1'){
			screendiv = document.getElementById('transscreens');
	  	        screendiv.innerHTML += "<br>Select your payment option below:";
		        screendiv.innerHTML += "<div><br><a href='#_' onclick='javascript:paypal(\"" + lowresimgpath + "\");' style='color:#0000AA;font-weight:bold;'>Pay&nbsp;With&nbsp;PayPal</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:stripe(\"" + lowresimgpath + "\");' style='color:#0000AA;font-weight:bold;'>Pay&nbsp;With&nbsp;Card</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:closescreen();' style='color:#0000AA;font-weight:bold;'>Close&nbsp;Screen</a><br/></div><div id='pgdiv' style='display:none;'></div>";
	  	        screendiv.style.display = "";
		    }
		    else{ // Show login screen
			screendiv = document.getElementById('transscreens');
		   	//alert(xmlhttp.responseText);
			content = xmlhttp.responseText;
			content = content.replace(/LOWRESIMGPATH/, lowresimgpath);
			screendiv.innerHTML = content;
			screendiv.style.display = "";
		    }
                }
            }
	    targeturl = "/checkbuylogin";
            xmlhttp.open("GET",targeturl,true); // Make it an ajax call.
            xmlhttp.send();
	}


	function dologin(){
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
	    xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    //alert(xmlhttp.responseText);
		    screendiv = document.getElementById('transscreens');
		    screendiv.innerHTML = xmlhttp.responseText;
		    screendiv.style.display = "";
                }
            }
            targeturl = "/floatlogin";
	    postdata = "username=" + document.frmlogin.username.value + "&_token=" + document.frmlogin._token.value + "&password=" + document.frmlogin.password.value + "&lowresimgpath=" + document.frmlogin.lowresimgpath.value;
	    //alert(postdata);
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.frmlogin._token.value);
	    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);
	}


	if(typeof(String.prototype.trim) === "undefined"){
	    String.prototype.trim = function(){
		return String(this).replace(/^\s+|\s+$/g, '');
	    };
	}

	function luhntest(cardno){
	    lastchar = cardno[cardno.length-1];
	    restofthestring = cardno.slice(0, -1);
	    splitrestofthestring = restofthestring.split("");
	    reverserestofthestring = splitrestofthestring.reverse();
	    reversestring = reverserestofthestring.join("");
	    for(i=1; i < reversestring.length;i=i+2){
		reversestring[i] = parseInt(reversestring[i]) * 2;
		if(reversestring[i] > 9){
		    reversestring[i] = reversestring[i] - 9;
		}
	    }
	    sumofdigits = 0;
	    for(j=0; j < reversestring.length; j++){
		sumofdigits = sumofdigits + reversestring[j];
	    }
	    remainder = sumofdigits % 10;
	    if(parseInt(remainder) != parseInt(lastchar)){
		return (false);
	    }
	    return (true);
	}

	function validate_and_submit(){
	    //alert("HELLO");
	    cust_name = document.payment_form.customername.value;
	    emailid = document.payment_form.emailid.value;
	    card_num = document.payment_form.card_no.value;
	    cvv_num = document.payment_form.cvvNumber.value;
	    exp_mon = document.payment_form.ccExpiryMonth.value;
	    exp_year = document.payment_form.ccExpiryYear.value;
	    addr_line1 = document.payment_form.addressline1.value;
	    addr_line2 = document.payment_form.addressline2.value;
	    city = document.payment_form.city.value;
	    country = document.payment_form.country.value;
	    zipcode = document.payment_form.zipcode.value;
	    payamount = document.payment_form.payamt.value;
	    lowresimgpath = document.payment_form.lowrespath.value;
	    if(cust_name.trim() == ""){
		alert("Customer name field should not be empty");
		return(false);
	    }
	    if(emailid.trim() == ""){
		alert("Email Id field should not be empty");
		return(false);
	    }
	    if(card_num.trim() == ""){
		alert("Card number field should not be empty");
		return(false);
	    }
	    //luhnres = luhntest(card_num.trim());
	    //if(!luhnres){
	    //	alert("Your card number is invalid");
	    //	return (false);
	    //}
	    if(cvv_num.trim() == ""){
		alert("CVV number field should not be empty");
		return(false);
	    }
	    if(exp_mon.trim() == "" || exp_year.trim() == ""){
		alert("Expiry month and year fields should not be empty");
		return(false);
	    }
	    if(addr_line1.trim() == ""){
		alert("Address line1 should not be empty");
		return(false);
	    }
	    if(zipcode.trim() == ""){
		alert("Zip code should not be empty");
		return(false);
	    }
	    document.getElementById('btnpay').disabled = true;
	    waitdivelem = document.getElementById('waitdiv');
	    waitdivelem.innerHTML = "Please wait while we process your payment.";
	    document.payment_form.submit();
	}

	
    </script>

    <script type='text/javascript'>
	function adjustpayamt(){
	    currname = document.payment_form.currency.options[document.payment_form.currency.options.selectedIndex].value;
	    //alert(currname);
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
		    //alert(xmlhttp.responseText);
		    rate = xmlhttp.responseText;
		    currvalue = document.getElementById('payamt').value * rate;
		    document.getElementById('btnpay').innerHTML = "Pay " + currname + " " + currvalue.toFixed(2);
		    //document.getElementById('payamt').value = currvalue.toFixed(2);
                }
            }
            targeturl = "/getcurrencyrate";
	    postdata = "currname=" + currname + "&_token=" + document.payment_form._token.value;
	    //alert(postdata);
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', document.payment_form._token.value);
	    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);
	}
    </script>
    <script type='text/javascript'>
	function makepayment(){
	    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }
            else{
	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
		//alert(xmlhttp.status);
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
                    //alert(xmlhttp.responseText);
		    screendiv = document.getElementById('transscreens');
	  	    screendiv.innerHTML = xmlhttp.responseText;
                }
            }
            targeturl = document.payment_form.action;
	    cmd = document.payment_form.cmd.value;
	    business = document.payment_form.business.value;
	    item_name = document.payment_form.item_name.value;
 	    item_number = document.payment_form.item_number.value;
	    currency_code = document.payment_form.currency_code.value;
	    lc = document.payment_form.lc.value;
	    bn = document.payment_form.bn.value;
  	    payamt = document.payment_form.payamt.value;
	    lowrespath = document.payment_form.lowrespath.value;
	    csrftoken = document.payment_form._token.value;
            postdata = "cmd=" + cmd + "&business=" + business + "&item_name=" + item_name + "&item_number=" + item_number + "&currency_code=" + currency_code + "&lc=" + lc + "&bn=" + bn + "&payamt=" + payamt + "&lowrespath=" + lowrespath + "&_token=" + csrftoken;
	    //alert(postdata);
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', csrftoken);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);

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
						</div>
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
						<div id="captchacontent">
						<div class="g-recaptcha" data-sitekey="6LdR4fUUAAAAALCtrHM_1X9W1S-Q0s5JvL-Zln2s"></div>
						</div>
						<div id="transscreens" class="semitrans" style="max-height:100%;max-width:100%;display:none;"></div>
						<div class="action" style="display:flex;align-content: space-between;">

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
							&nbsp;&nbsp;<button class="add-to-cart btn btn-default" type="button" onclick="javascript:window.close();">Close</button>
						</div>
						<div style="font-style:italic;color:blue;"> "Free Download" allows you to download a low resolution version of the selected image, if the image is a premium one. If the image is not a premium image, then the original high resoluton version will be downloaded.</div><br />
						<div style="font-style:italic;color:blue;" id="buyorig">
						<?php
						if(round($imageprice, 2) > 0.00){
						?>
						 "Buy Original" allows you to purchase and download the original high resolution version of the selected image.
						<?php
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="main">

				<div class="inner">
					<div style='color:blue;font-weight:bold;'>Related Images</div>
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


