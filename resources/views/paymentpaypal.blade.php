<!DOCTYPE html>
<html>
<head>
	<title>Paypal Payment Gateway</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>

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
                if(xmlhttp.readyState == 4 && xmlhttp.status==200){
                    alert(xmlhttp.responseText);
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
	    alert(postdata);
            xmlhttp.open("POST",targeturl,true); // Make it an ajax call.
            xmlhttp.setRequestHeader('X-CSRFToken', csrftoken);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(postdata);

	}
    </script>
</head>
<body>
  
<span class="container" style="width:100%;">
  
    <h2>PayPal Payment Gateway</h2>
  
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="width:100%;display:block;margin-left:10px;margin-right:auto;text-align:center;">
            <div class="panel panel-default credit-card-box">
                <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                    </div>
                <div class="panel-body">
  
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
  		    <form action="/paypalpayment" method="POST" class="require-validation" data-cc-on-file="false" id="payment-form" name="payment_form">
		    {{ csrf_field() }}
		    <div class='form-row row'>
		            <div class='col-xs-12 form-group required'>
		                <label class='control-label'>PayPal Account Name</label> <input class='form-control' size='4' type='text' name="customername">
		            </div>
                    </div>
		    <?php
			$lowrespathparts = explode("/", $lowrespath);
			$numparts = count($lowrespathparts);
			$lowresfilename = $lowrespathparts[$numparts-1];
		    ?>
		    <input type="hidden" name="cmd" value="_xclick">
		    <input type="hidden" name="business" value="imagewebapp@gmail.com">
		    <input type="hidden" name="item_name" value="<?php echo $lowresfilename; ?>">
		    <input type="hidden" name="item_number" value="1">
		    <input type="hidden" name="currency_code" value="USD">
		    <input type="hidden" name="lc" value="IN">
		    <input type="hidden" name="bn" value="PP-BuyNowBF">
		    <input type='hidden' name='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
		    <input type='hidden' name='lowrespath' value="<?php echo $lowresfilename; ?>">
		    Pay US$ <?php echo number_format(round($imageprice,2), 2); ?>
		    <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online." onclick='javascript:makepayment();'>
		    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
		    </form>
                    
                </div>
            </div>        
        </div>
    </div>
      
</div>
  
</body>
  

</html>


