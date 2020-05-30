<!DOCTYPE html>
<html>
<head>
	<title>Stripe Payment Gateway</title>
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
  
    <h1>Stripe Payment Gateway</h1>
  
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
  
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
  
                    <form role="form" action="/cardpayment" method="post" class="require-validation" data-cc-on-file="false" id="payment-form">
                        {{ csrf_field() }}
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text' name="customername">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' name="ccExpiryMonth">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Address Line 1</label> <input class='form-control' size='4' type='text' name="addressline1">
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Address Line 2</label> <input class='form-control' size='4' type='text' name="addressline2">
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>City</label> <input autocomplete='off'
                                    class='form-control card-cvc' size='4' type='text' name="city">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Country</label> <input class='form-control card-expiry-month' size='6' type='text' name="country">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay <?php echo number_format(round($imageprice,2), 2); ?></button>
                            </div>
                        </div>
                        <input type='hidden' name='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
			<input type='hidden' name='lowrespath' value="<?php echo $lowrespath; ?>">
                    </form>
                </div>
            </div>        
        </div>
    </div>
      
</div>
  
</body>
  

</html>


