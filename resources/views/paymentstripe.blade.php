<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title>Stripe Card Payment Form</title>
   <!-- Bootstrap -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 <style>
 .submit-button {
 margin-top: 10px;
}

body { margin:50px auto; width:600px;}

/* CSS for Credit Card Payment form */
.credit-card-box .panel-title {
    display: inline;
    font-weight: bold;
}
.credit-card-box .form-control.error {
    border-color: red;
    outline: 0;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
}
.credit-card-box label.error {
  font-weight: bold;
  color: red;
  padding: 2px 8px;
  margin-top: 2px;
}
.credit-card-box .payment-errors {
  font-weight: bold;
  color: red;
  padding: 2px 8px;
  margin-top: 2px;
}
.credit-card-box label {
    display: block;
}
/* The old "center div vertically" hack */
.credit-card-box .display-table {
    display: table;
}
.credit-card-box .display-tr {
    display: table-row;
}
.credit-card-box .display-td {
    display: table-cell;
    vertical-align: middle;
    width: 50%;
}
/* Just looks nicer */
.credit-card-box .panel-heading img {
    min-width: 180px;
}
 </style>
 </head>
 <body>
<div class="container">
<div class="row">
<!-- You can make it whatever width you want. I'm making it full width
on <= small devices and 4/12 page width on >= medium devices -->
<div class="col-xs-12 col-md-4">


<!-- CREDIT CARD FORM STARTS HERE -->
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
<form role="form" id="payment-form" method="POST" action="/cardpayment">
{{ csrf_field() }}
<div class="row">
<div class="col-xs-12">
<div class="form-group">
<label for="cardNumber">Name on Card</label>
<div class="input-group">
<input type="tel" class="form-control" name="customername"  placeholder="Name on card" autocomplete="cc-number" />
<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
</div>
</div>                            
</div>

<div class="row">
<div class="col-xs-12">
<div class="form-group">
<label for="cardNumber">Card Number</label>
<div class="input-group">
<input type="tel" class="form-control" name="card_no"  placeholder="Valid Card Number" autocomplete="cc-number" required autofocus />
<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
</div>
</div>                            
</div>

<div class="row">
<div class="col-xs-7 col-md-7">
<div class="form-group">
<label for="cardExpiry"><span class="hidden-xs">Expiration Month</span><span class="visible-xs-inline"></span></label>
<input type="tel" class="form-control" name="ccExpiryMonth" placeholder="MM" autocomplete="cc-exp" required />
</div>
</div>
<div class="col-xs-7 col-md-7">
<div class="form-group">
<label for="cardExpiry"><span class="hidden-xs">Expiration Year</span><span class="visible-xs-inline"></span></label>
<input type="tel" class="form-control" name="ccExpiryYear" placeholder="YYYY" autocomplete="cc-exp" required />
</div>
</div>
</div>
<div class="col-xs-5 col-md-5 pull-right">
<div class="form-group">
<label for="cardCVC">CVV Code</label>
<input type="tel" class="form-control" name="cvvNumber" placeholder="CVC" autocomplete="cc-csc" required />
</div>
</div>

<div class="row">
<div class="col-xs-12">
<div class="form-group">
<label for="cardNumber">Address Line 1</label>
<div class="input-group">
<input type="tel" class="form-control" name="addressline1"  placeholder="Address line 1" />
<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
</div>
</div>                            
</div>

<div class="row">
<div class="col-xs-12">
<div class="form-group">
<label for="cardNumber">Address Line 2</label>
<div class="input-group">
<input type="tel" class="form-control" name="addressline2"  placeholder="Address line 2" />
<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
</div>
</div>                            
</div>

<div class="row">
<div class="col-xs-7 col-md-7">
<div class="form-group">
<label for="cardExpiry"><span class="hidden-xs">City</span><span class="visible-xs-inline"></span></label>
<input type="tel" class="form-control" name="city" autocomplete="cc-exp" required />
</div>
</div>
<div class="col-xs-7 col-md-7">
<div class="form-group">
<label for="cardExpiry"><span class="hidden-xs">Country</span><span class="visible-xs-inline"></span></label>
<input type="tel" class="form-control" name="country" autocomplete="cc-exp" required />
</div>
</div>
</div>

<div class="row">
<div class="col-xs-12">
<button class="btn btn-success btn-lg btn-block" type="submit">Pay <?php echo number_format(round($imageprice,2), 2); ?></button>
</div>
</div>
<div class="row" style="display:none;">
<div class="col-xs-12">
<p class="payment-errors"></p>
</div>
</div>
<input type='hidden' name='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
<input type='hidden' name='lowrespath' value="<?php echo $lowrespath; ?>">
</form>
</div>
</div>            
<!-- CREDIT CARD FORM ENDS HERE -->

</div>            

</div>
</div>

</body>


