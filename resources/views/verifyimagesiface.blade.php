<!DOCTYPE html>

<html lang="en">

<head>

	<title>Verify Images Screen</title>

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
<script type='text/javascript'>

function submitverification(){
    yn = confirm("Confirm verification of the selected images?");
    if(yn){
	document.frmimageverification.submit();
    }
}

</script>
<script src="/template/js/common.js.download" defer=""></script>
<script src="/template/js/profileimage.js" type="text/javascript"></script>
</head>

<body>

	<!-- Top panel -->
@include('toppanel')
	<!-- Top panel ends here -->
				<?php
				echo "<span style='color:#0000AA'>".$verifymessage."</span>";
				?>
					<div class="wrap-table100-nextcols js-pscroll"><h3 style='text-align:center;padding-left:20px;'>Verify Images</h3></div>
					<form name='frmimageverification' id='frmimageverification' action='/verifyimages' method='POST'>

					<div class="wrap-table100-nextcols js-pscroll">

						<div class="table100-nextcols">
						<?php
							$imageskeys = array_keys($imagesdict);
							if(count($imageskeys) == 0){
							    echo "<div style='text-align:center;font-weight:bold;color:red;padding-left:20px;'>There are no images to verify</div>";
							}
							else{
						?>

							<table width='100%'>

								<thead>

									<tr class="row100 head">

										<th class="cell100 column2" style="font-family:droid sans;">Image File</th>

										<th class="cell100 column3" style="font-family:droid sans;">Verify</th>

									</tr>

								</thead>

								<tbody>
                                                                @foreach ($imagesdict as $imgpath => $itemslist)
									<?php
									$imgid = $itemslist[0];
									$lowreswebpath = $itemslist[1];
									?>
									
                      							<tr class="row100 body">
										<td class="cell100 column2"><img src='{{$lowreswebpath}}' width='300' height='300'></td>

										<td class="cell100 column3" style="font-family:droid sans;">
										Accept:<input type='radio' name='imgverify{{$imgid}}' value="accept">&nbsp;&nbsp;Reject:<input type='radio' name='imgverify{{$imgid}}' value="reject">
										<input type='hidden' name='imgverify[]' value='{{$imgid}}'>
										<!-- <input type='checkbox' name='imgverify[]' value='{{$imgid}}'></td> -->
									<!-- Add pagination here -->
									</tr>
                                                                  @endforeach
								  <tr class="row100 body">
									<td colspan='2' align='center'><input type='button' name='btnverify' value='Verify' onClick='javascript:submitverification();'></td>
								  </tr>
								
								</tbody>

							</table>
						<?php
							}
						?>

						</div>

					</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</form>

	</div>

	</script>

<!--===============================================================================================-->

	<script src="js/main.js"></script>



</body>

</html>



