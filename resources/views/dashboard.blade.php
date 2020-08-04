<!DOCTYPE html>

<html lang="en">

<head>

	<title>Dashboard</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	

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
	
  <!--/////////////////////////////////////////// IMP /////////////////////////////////////////////////////-->
<link rel="stylesheet" href="/template/com_app_min.css">
<link rel="stylesheet" href="/template/css/toppanel.css"> 
      
 <script src="/template/nn.js.download"></script>	 
 <!--//////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!-- upload form css -->
<style>

* {box-sizing: border-box;}

/* Style Form Container */
.form-container {
    position: relative;
    padding: 16px;
    overflow: auto;
    overflow-y: hidden;
    border: 1px solid rgba(0,0,0,.125);
}

/* Style Inline Form */
.form-inline {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
    overflow-y: hidden;
}

/* Style Label */
label {
    display: inline-block;
    margin-right: .5rem;
    margin-left: .5rem;
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
    overflow: auto;
    overflow-y: hidden;
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

button {
    font-family : verdana;
    font-size: 12px;
}

select, option {
    width: 150px;
}

option {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

input {
    width: 200px;
    border-radius: 5px;
}

label {
    font-size: small;
}

div {
    padding-left:20px;
    padding-right:20px;
}

.select-css {
	display: block;
	font-size: 14px;
	font-family: verdana;
	font-weight: 700;
	color: #444;
	line-height: 1.3;
	padding: .6em 1.4em .5em .8em;
	width: 100%;
	max-width: 100%;
	box-sizing: border-box;
	margin: 0;
	border: 1px solid #aaa;
	box-shadow: 0 1px 0 1px rgba(0,0,0,.04);
	border-radius: .5em;
	-moz-appearance: none;
	-webkit-appearance: none;
	appearance: none;
	background-color: #fff;
	background-repeat: no-repeat, repeat;
	background-position: right .7em top 50%, 0 0;
	background-size: .65em auto, 100%;
}
.select-css::-ms-expand {
	display: none;
}
.select-css:hover {
	border-color: #888;
}
.select-css:focus {
	border-color: #aaa;
	box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
	box-shadow: 0 0 0 3px -moz-mac-focusring;
	color: #222;
	outline: none;
}
.select-css option {
	font-weight:normal;
	font-size: 14px;
	font-family: verdana;
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
    margin: 2px;
    text-align: center;
}

.paginate a {
    text-decoration: none;
    color: blue;
    float: left;
    padding: 10px 15px;
 border-radius: 10px;
 transition: background-color .5s; 
    text-align: center;
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

<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<script src="/template/js/common.js.download" defer=""></script>
<script type='text/javascript'>

if (!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
  };
}

function uploadfile(){
var xmlhttp;
statusdiv = document.getElementById('uploadstatus');
if (window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
}
else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status==200){
        statusdiv.innerHTML = "<p style='color:#0000AA;font-family:verdana;font-size:12px;'>" + xmlhttp.responseText + ".</p>";
    }
}
//var file = this.files[0];
//var file = document.frmimageupload.imgupload.value; 
var file = document.getElementById('imgupload').files[0];
fname = file.name;
if(!fname.includes(".")){
    alert("The file extension is not supported. This file cannot be uploaded");
    return(false);
}
fext = fname.split(".")[1];
if(fext != "jpg" && fext != "jpeg"){
    alert("You may upload jpeg files only");
    return(false);
}
formdata = new FormData();
formdata.append("imgupload", file);
csrftoken = document.frmimageupload._token.value;
formdata.append("_token", csrftoken);
imgtags = document.getElementById('imagetags').value;
if(imgtags.trim() == ""){
    alert("Please enter at least one tag word.");
    return(false);
}
formdata.append('imagetags', imgtags);
price = document.frmimageupload.price.value;
formdata.append('price', price);
captcharesponse = grecaptcha.getResponse();
formdata.append('g-recaptcha-response', captcharesponse);
sel = document.frmimageupload.categories;
selectedcats = "";
for(i=0; i < sel.options.length; i++){
    if(sel.options[i].selected){
        selectedcats += sel.options[i].value + ",";
    }
}
if(selectedcats.trim() == ""){
    alert("Please select at least one category");
    return(false);
}
formdata.append('categories', selectedcats);
xmlhttp.open('POST', "/upload", true);
xmlhttp.send(formdata);
statusdiv.innerHTML = "<img src='/images/loading_small.gif'>Please wait while we upload your image...";    
}

function removeimage(imagefilename, userid, ctr){
  removeimgurl = "/removeimage";
  yn = confirm("This action will delete the image permanently. Do you want to continue?");
  if(!yn){
    return(0);
  }
  var xmlhttp;
  rmdivelem = 'rmdiv' + ctr;
  statusdiv = document.getElementById(rmdivelem);
  if (window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();
  }
  else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status==200){
        statusdiv.style.display = "";
        //statusdiv.innerHTML = "<p style='color:#0000AA;'>" + xmlhttp.responseText + ".</p>";
	alert( xmlhttp.responseText);
	location.reload();
    }
  }
  formdata = new FormData();
  csrftoken = document.frmprofimg._token.value;
  formdata.append("_token", csrftoken);
  formdata.append("imagefilename", imagefilename);
  formdata.append("userid", userid);
  xmlhttp.open('POST', removeimgurl, true);
  xmlhttp.send(formdata);
  statusdiv.style.display = "";
  statusdiv.innerHTML = "<img src='/images/loading_small.gif'>";
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
</script>
<script src="/template/js/searchgallery.js"></script>
</head>

<body>
@include('toppanel')
			<table>

				<tr width='100%'>

					<td colspan='8' width='80%' align='center'>
					<div class="form-container">
					<div style="background-color:lightblue;white-space:nowrap">
					<form name='frmimageupload' method='POST' action='/upload' enctype='multipart/formdata' class="form-inline" style="color:blue;"><label>Upload Image:</label> <input type='file' name='imgupload' id='imgupload' accept='image/jpeg' title="select file" style="color:transparent;font-family : verdana;font-size:12px;font-weight:bold;color:blue;" onchange="this.style.color='blue';">&nbsp;&nbsp;<label>Enter Tags</label><input type='text' name='imagetags' id='imagetags' value='' placeholder='Enter tags here'> <label>Select Categories:</label> <select name='categories' size='3' class="select-css" multiple>
					@foreach ($categories as $category)
					<option value='<?php echo $category->categoryname; ?>'><?php echo $category->categoryname; ?></option>
					@endforeach
					</select>&nbsp;&nbsp; <label>Price: USD($)</label><input type='text' name='price' value='0.00' id='price'></div><div style="background-color:lightblue;white-space:nowrap">&nbsp;&nbsp;<span class="g-recaptcha" data-sitekey="6LdR4fUUAAAAALCtrHM_1X9W1S-Q0s5JvL-Zln2s"></span>&nbsp;&nbsp;<input type='button' name='submitform' value='Upload' onClick='javascript:uploadfile();' style='font-family : verdana;font-size:12px;font-weight:bold;color:blue;'><input type="hidden" name="_token" value="{{ csrf_token() }}"><div id='uploadstatus' style="font-family:verdana;font-size:12px;color:#0000AA;"></div></div></form>
					</div>
					</td>

				</tr>


						</table>

					</div>

					<?php
					echo "<div style='text-align:center'>";
					echo "<div class='paginate'>";
					if($start < $max){
					    echo "<a href='/dashboard?start=".$start."'>Next<img src='/images/next.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					    echo "<a href='/dashboard?lastpoint=".$lastpoint."'>Last<img src='/images/last.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					}
					if($start > $chunk){
					    $prev = $start - 2*$chunk;
					    if($prev < 0){
						$prev = 0;
					    }
					    echo "<a href='/dashboard?start=0'>First<img src='/images/first.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					    echo "<a href='/dashboard?start=".$prev."'>Prev<img src='/images/prev.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
					}
					echo "</div>";
					echo "</div>";
					?>

					<div class="wrap-table100-nextcols js-pscroll">

						<div class="table100-nextcols">

							<table width='100%' cellpadding='4' cellspacing='2'>

								<thead>

									<tr class="row100 head">

										<th class="cell100 column2">Image File</th>

										<!-- <th class="cell100 column3">Low Res File</th> -->

										<th class="cell100 column4">Icon File</th>

										<th class="cell100 column5">Upload Date</th>
										
										<th class="cell100 column5">Resolution</th>
										
										<th class="cell100 column5">Image Tags</th>

										<th class="cell100 column6">Price(USD)</th>
										
										<th class="cell100 column6">Verified</th>

										<th class="cell100 column7">Remove</th>

										<th class="cell100 column8">Hit Count</th>

									</tr>

								</thead>

								<tbody>
								<?php $ctr = 1; ?>
                                                                @foreach ($images as $img)
									<?php

									$imagepathparts = explode("users", $img->imagepath);
									$imagepath = "/image".$imagepathparts[1];
									$lowrespathparts = explode("users", $img->lowrespath);
									$lowrespath = "/image".$lowrespathparts[1];
									$iconpathparts = explode("users", $img->iconpath);
       									$iconpath = "/image".$iconpathparts[1];
									$verified = $img->verified;
									$rowcolor = "#0000AA";
									if((int)$verified == -1){
									    $rowcolor = "#AA0000";
									}
									else if((int)$verified == 0){
									    $rowcolor = "#00AA00";
									}
									?>

                      							<tr class="row100 body" style="color:<?php echo $rowcolor; ?>;">
										<!--
										<?php
										//if($img->price > 0.00 && (int)$img->userid != (int)$userid){
										if($img->price > 0.00){
										?>
										<td class="cell100 column2">Premium Image, Can't be displayed</td>
										<?php
										}
										else{
										?>
										<td class="cell100 column2"><img src='{{$imagepath}}' width='200' height='200'></td>
										<?php
										}
										?>
										-->
										<td class="cell100 column3"><img src='{{$lowrespath}}' width='200' height='200'></td>

										<td class="cell100 column4"><img src='{{$iconpath}}' width='50' height='50'></td>

										<td class="cell100 column5" style="font-family:droid sans;">{{$img->uploadts}}</td>
										
										<td class="cell100 column5" style="font-family:droid sans;">{{$img->resolution}}</td>
										
										<td class="cell100 column5" style="font-family:droid sans;">{{$img->imagetags}}</td>
										@if($img->price == 0.00)
										<td class="cell100 column6" style="font-family:droid sans;">Free</td>
										@else
										<td class="cell100 column6" style="font-family:droid sans;">USD <?php echo number_format(round($img->price,2), 2); ?></td>
										@endif
										@if($img->verified == 0)
										<td class="cell100 column6" style="font-family:droid sans;">Pending</td>
										@elseif($img->verified == 1)
										<td class="cell100 column6" style="font-family:droid sans;">Verified</td>
										@elseif($img->verified == -1)
										<td class="cell100 column6" style="font-family:droid sans;">Rejected</td>
										@endif

										<td class="cell100 column7" style="font-family:droid sans;"><a href='#/' onclick="javascript:removeimage('{{$img->imagefilename}}', '{{$img->userid}}', '<?php echo $ctr; ?>');">Remove Image</a><div id='rmdiv<?php echo $ctr; ?>' style="display:none;"></div></td>
										<?php
										$imgid = $img->id;
										$imghits = DB::table('imagehits')->where('imageid', $imgid)->get();
										$counthits = count($imghits);
										?>
										<td class="cell100 column8" style="text-align:center;font-family:droid sans;">{{$counthits}}</td>
									<!-- Add pagination here -->
									</tr>
									<?php $ctr++; ?>
                                                                  @endforeach


								</tbody>

							</table>
							<div style='text-align:center'>
							<div class='paginate'>
							<?php

							if($start < $max){
							    echo "<a href='/dashboard?start=".$start."'>Next<img src='/images/next.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
							    echo "<a href='/dashboard?lastpoint=".$lastpoint."'>Last<img src='/images/last.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
							}
							if($start > $chunk){
							    $prev = $start - 2*$chunk;
							    if($prev < 0){
								$prev = 0;
							    }
							    echo "<a href='/dashboard?start=0'>First<img src='/images/first.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
							    echo "<a href='/dashboard?start=".$prev."'>Prev<img src='/images/prev.png' style='width:24px;height:24px;'></a>&nbsp;&nbsp;";
							}
							?>
							</div>
							</div>
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>


</body>

</html>



