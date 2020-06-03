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
</head>
<body>
  
<div class="container">
  
    <h1>PayPal Payment Gateway</h1>
  
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
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
		    <input type="hidden" name="cmd" value="_xclick">
		    <input type="hidden" name="business" value="imagewebapp@gmail.com">
		    <input type="hidden" name="item_name" value="<?php echo $lowrespath; ?>">
		    <input type="hidden" name="item_number" value="1">
		    <input type="hidden" name="currency_code" value="USD">
		    <input type="hidden" name="lc" value="IN">
		    <input type="hidden" name="bn" value="PP-BuyNowBF">
		    <input type='hidden' name='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
		    <input type='hidden' name='lowrespath' value="<?php echo $lowrespath; ?>">
		    Pay US$ <?php echo number_format(round($imageprice,2), 2); ?>
		    <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
		    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
		    </form>
                    
                </div>
            </div>        
        </div>
    </div>
      
</div>
  
</body>
  

</html>


