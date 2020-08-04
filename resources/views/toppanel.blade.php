<!-- Top Panel -->
	<nav class="navbar navbar-expand-lg navbar-dark navbar-survival101">
  	<div class="container">
	    <a class="navbar-brand" href="#">
	      <img src="https://lh3.googleusercontent.com/-ZAS0BBE8Sm0/WaFOdATxW9I/AAAAAAAAAf4/8FfuKoWw6n0cvynAv7Fv2sdYESliQEm4wCL0BGAYYCw/h18/2017-08-26.png" alt="L A N T E R N">
	    </a>

	    <div class="collapse navbar-collapse" id="navbarColor02" style="display:flex;flex-direction:row;color:white;">
	      <ul>
		<?php
		if(isset($username) && isset($profileimage) && $username != ""){
		    echo "<li>You are logged in as ".$username."<img src='".$profileimage."' height='50px' width='50px'>";
		    echo "<a class='nav-link' href='/logout' style='color:white;'>Logout</a></li>";
		    echo "<a class='nav-link' href='#/' onClick='javascript:showprofileimagescreen();' style='color:white;'>Change Profile Image</a>";
		    echo "<span id='profileimagediv' style='display:none;'><form id='frmprofimg' name='frmprofimg'><input type='file' name='uploadfile' id='uploadfile'><input type='button' name='btnupload' value='  Go  ' onClick='javascript:uploadprofileimage();'><div id='profstatus'></span><input type='button' name='btnclose' value='Close' onClick='javascript:closeuploadform();'>";
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

        <!-- adobe top panel -->
	<div class="react-spectrum-provider spectrum spectrum--light spectrum--medium"><main><div><div class="sc-iGPElx sc-hgHYgh hhOipk"></div><nav data-t="navbar" class="sc-kgoBCf cNdcvw"><div class="sc-kGXeez sc-kpOJdX bHSdES"></div></div><div class="sc-kGXeez sc-dxgOiQ jsiCyh"><section><section data-t="photos-lp-hero" class="sc-iuJeZd enkIOd"><div class="heroWithSearchstyle__StyledSearchBarWrapper-sc-1komyey-0 dMOYUP"><div class="is-floating sc-bYwvMP iDJxkn"><div data-t="filter-asset-type" class="sc-hUMlYv sc-ESoVU YBXb"></div><div class="sc-hUMlYv sc-kkbgRg tORwQ"><div class="sc-jMMfwr fgEjFF"></div></div></div></div></div></section></main></div>
	<!-- adobe top panel ends -->


	<div class="wrapper" style="transform: none;border:4px solid blue;">
	  <header>
        <div class="clearfix head-bottom">
          <div class="red-navigation">
            <div class="nav-f-block">
              <div id="nav-icon"><span></span><span></span><span></span></div>
              <a href=""><img src="/template/img/imageweb_logo.png" alt="Image Web" title="Image Web" width="50px" height="50px"></a>
            </div>
            <div class="nav-s-block">
              <div class="search" id="searchb" style="border:4px solid green;"><form name='frmsearch2' method='GET' action='/gallery?mode=tags'>
						<input autocomplete="on" type="text" placeholder="Search on Imageweb..." class="input-search" name='tagslist2' id='tagslist2'>
						<button type="submit" class="searchButton" onClick='javascript:searchgallery2();'>Search</button>
                </form></div>
              <div class="d-none">
                <ul>
				<li><a href="/dashboard" title="Dashboard">Dashboard</a></li>
				  <li><a href="/gallery" title="Gallery" style="color: yellow;border: 1px solid yellow;border-radius: 10px;margin: 14px 0px;line-height: 54px;display: inline;padding: 6px;">Gallery</a></li>
				<?php
					if(isset($usertype) && $usertype == "admin"){
				?>
					<li><a href="/verifyimagesiface">Verify Images</a></li>
				<?php
					}
				?>
				 <li><a href="/withdrawscreen" title="Withdraw funds">Withdraw Funds</a></li>
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


