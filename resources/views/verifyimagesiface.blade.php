<!DOCTYPE html>

<html lang="en">

<head>

	<title>Verify Images Screen</title>

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

function submitverification(){
    yn = confirm("Confirm verification of the selected images?");
    if(yn){
	document.frmimageverification.submit();
    }
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

                <li class="nav-item">

                    <a href="/logout" data-no="5">Logout</a>

                </li>

            </ul>



    	</div>


					</div>

					<div class="wrap-table100-nextcols js-pscroll"><h3>Verify Images</h3></div>
					<form name='frmimageverification' id='frmimageverification' action='/verifyimages' method='POST'>

					<div class="wrap-table100-nextcols js-pscroll">

						<div class="table100-nextcols">

							<table width='100%'>

								<thead>

									<tr class="row100 head">

										<th class="cell100 column2">Image File</th>

										<th class="cell100 column3">Verify</th>

									</tr>

								</thead>

								<tbody>
                                                                @foreach ($imagesdict as $imgpath => $imgid)
									
                      							<tr class="row100 body">

										<td class="cell100 column2"><img src='{{$imgpath}}' width='300' height='300'></td>

										<td class="cell100 column3"><input type='checkbox' name='imgverify[]' value='{{$imgid}}'></td>
									<!-- Add pagination here -->
									</tr>
                                                                  @endforeach
								  <tr class="row100 body">
									<td colspan='2'><input type='button' name='btnverify' value='Verify' onClick='javascript:submitverification();'></td>
								  </tr>
								
								</tbody>

							</table>

						</div>

					</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</form>

				</div>

			</div>

		</div>

	</div>





<!--===============================================================================================-->	

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/bootstrap/js/popper.js"></script>

	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/select2/select2.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>

	<script>

		$('.js-pscroll').each(function(){

			var ps = new PerfectScrollbar(this);



			$(window).on('resize', function(){

				ps.update();

			})



			$(this).on('ps-x-reach-start', function(){

				$(this).parent().find('.table100-firstcol').removeClass('shadow-table100-firstcol');

			});



			$(this).on('ps-scroll-x', function(){

				$(this).parent().find('.table100-firstcol').addClass('shadow-table100-firstcol');

			});



		});



		

		

		

	</script>

<!--===============================================================================================-->

	<script src="js/main.js"></script>



</body>

</html>



