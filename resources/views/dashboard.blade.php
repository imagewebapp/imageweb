<!DOCTYPE html>

<html lang="en">

<head>

	<title>Dashboard</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

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
<script type='text/javascript'>

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
        statusdiv.innerHTML = "<p style='color:#0000AA;'>" + xmlhttp.responseText + ".</p>";
    }
}
//var file = this.files[0];
//var file = document.frmimageupload.imgupload.value; 
var file = document.getElementById('imgupload').files[0]; 
formdata = new FormData();
formdata.append("imgupload", file);
csrftoken = document.frmimageupload._token.value;
formdata.append("_token", csrftoken);
imgtags = document.getElementById('imagetags').value;
formdata.append('imagetags', imgtags);
sel = document.frmimageupload.categories;
selectedcats = "";
for(i=0; i < sel.options.length; i++){
    if(sel.options[i].selected){
        selectedcats += sel.options[i].value + ",";
    }
}
formdata.append('categories', selectedcats);
xmlhttp.open('POST', "/upload", true);
xmlhttp.send(formdata);
statusdiv.innerHTML = "<img src='/images/loading_small.gif'>";    
}


function removeimage(imagefilename, userid){

}

</script>

</head>

<body>

	

	<div class="limiter">

		<div class="container-table100">

			<div class="wrap-table100">

				<div class="table100 ver1">

					<div class="table100-firstcol">
					 <!-- Navigation -->        

            

        <div class="navbar-brand text-uppercase" href="#"><i class="fa fa-picture-o tm-brand-icon"></i>ImageWeb Dashboard</div>

	<div class="tm-navbar-bg">

            <ul class="nav navbar-nav">

                <li class="nav-item active selected">

                    <a href="/gallery">Gallery</a>

                </li>                                

                <li class="nav-item">

                    <a href="/dashboard">Dashboard<span class="sr-only">(current)</span></a>

                </li>

                <li class="nav-item">

                    <a href="#0" data-no="3">3rd fluid</a>

                </li>

                <li class="nav-item">

                    <a href="#0" data-no="4">Columns</a>

                </li>

		@if($usertype == 'admin')
		
                <li class="nav-item">

                    <a href="/verifyimagesiface" data-no="4">Verify Images</a>

                </li>
 
		@endif

                <li class="nav-item">

                    <a href="/logout" data-no="5">Logout</a>

                </li>

            </ul>



    	</div>

						<table>

							<tr width='100%'>

								<td colspan='8'>
									<form name='frmimageupload' method='POST' action='/upload' enctype='multipart/formdata'>Upload Image: <input type='file' name='imgupload' id='imgupload' accept='image/*'> Enter Tags:<input type='text' name='imagetags' id='imagetags' value=''> Select Categories: <select name='categories' size='3' multiple>
									@foreach ($categories as $category)
									<option value='<?php echo $category->categoryname; ?>'><?php echo $category->categoryname; ?></option>
									@endforeach
									</select><input type='button' name='submitform' value='Upload' onClick='javascript:uploadfile();'><input type="hidden" name="_token" value="{{ csrf_token() }}"><div id='uploadstatus'></div></form>

								</td>

							</tr>


						</table>

					</div>

					

					<div class="wrap-table100-nextcols js-pscroll">

						<div class="table100-nextcols">

							<table width='100%'>

								<thead>

									<tr class="row100 head">

										<th class="cell100 column2">Image File</th>

										<th class="cell100 column3">Low Res File</th>

										<th class="cell100 column4">Icon File</th>

										<th class="cell100 column5">Upload Date</th>
										
										<th class="cell100 column5">Resolution</th>
										
										<th class="cell100 column5">Image Tags</th>

										<th class="cell100 column6">Premium</th>
										
										<th class="cell100 column6">Verified</th>

										<th class="cell100 column7">Remove</th>

										<th class="cell100 column8">Hit Count</th>

									</tr>

								</thead>

								<tbody>
                                                                @foreach ($images as $img)
									<?php

									$imagepathparts = explode("users", $img->imagepath);
									$imagepath = "/image".$imagepathparts[1];
									$lowrespathparts = explode("users", $img->lowrespath);
									$lowrespath = "/image".$lowrespathparts[1];
									$iconpathparts = explode("users", $img->iconpath);
       									$iconpath = "/image".$iconpathparts[1];
									?>

                      							<tr class="row100 body">

										<td class="cell100 column2"><img src='{{$imagepath}}' width='200' height='200'></td>

										<td class="cell100 column3"><img src='{{$lowrespath}}' width='150' height='150'></td>

										<td class="cell100 column4"><img src='{{$iconpath}}' width='50' height='50'></td>

										<td class="cell100 column5">{{$img->uploadts}}</td>
										
										<td class="cell100 column5">{{$img->resolution}}</td>
										
										<td class="cell100 column5">{{$img->imagetags}}</td>
										@if($img->premium == 0)
										<td class="cell100 column6">No</td>
										@else
										<td class="cell100 column6">Yes</td>
										@endif
										@if($img->verified == 0)										
										<td class="cell100 column6">No</td>
										@else
										<td class="cell100 column6">Yes</td>
										@endif

										<td class="cell100 column7"><a href='#/' onclick='javascript:removeimage({{$img->imagefilename}}, {{$img->userid}});'>Remove Image</a></td>

										<td class="cell100 column8"></td>
									<!-- Add pagination here -->
									</tr>
                                                                  @endforeach


								</tbody>

							</table>
							<?php

							if($start < $max){
							    echo "<div align='center'><a href='/dashboard?start=".$start."'>Next</a></div>";
							}
							if($start > $chunk){
							    $prev = $start - 2*$chunk;
							    if($prev < 0){
								$prev = 0;
							    }
							    echo "<div align='center'><a href='/dashboard?start=".$prev."'>Prev</a></div>";
							}
							?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>


</body>

</html>



