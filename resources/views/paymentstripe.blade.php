<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title>Bootstrap 101 Template</title>
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
 </style>
 </head>
 <body>
<div class="container">
<div class='row'>
<div class='col-md-4'></div>
<div class='col-md-4'>
<form class="form-horizontal" method="POST" id="payment-form" role="form" action="/cardpayment" >
{{ csrf_field() }}
<div class='form-row'>
<div class='col-xs-12 form-group card required'>
<label class='control-label'>Card Number</label>
<input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
</div>
</div>
<div class='form-row'>
<div class='col-xs-4 form-group cvc required'>
<label class='control-label'>CVV</label>
<input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
</div>
<div class='col-xs-4 form-group expiration required'>
<label class='control-label'>Expiration</label>
<input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
</div>
<div class='col-xs-4 form-group expiration required'>
<label class='control-label'> </label>
<input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
</div>
</div>
<br>
<div class='form-row'>
<label class='control-label'>Name</label>
<input class='form-control' size='16' type='text' name="customername">
</div>
<div class='form-row'>
<label class='control-label'>Address Line 1</label>
<input class='form-control' size='16' type='text' name="addressline1">
</div>
<div class='form-row'>
<label class='control-label'>Address Line 2</label>
<input class='form-control' size='16' type='text' name="addressline2">
</div>
<div class='form-row'>
<label class='control-label'>City</label>
<input class='form-control' size='16' type='text' name="city">
</div>
<div class='form-row'>
<label class='control-label'>Country</label>
<input class='form-control' size='16' type='text' name="country">
</div>
<div class='form-row'>
<div class='col-md-12' style="margin-left:-10px;">
<div class='form-control total btn btn-primary' >
Total:
<span class='amount'><?php echo number_format(round($imageprice,2), 2); ?></span>
<input type='hidden' name='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
<input type='hidden' name='lowrespath' value="<?php echo $lowrespath; ?>">
</div>
</div>
</div>
<div class='form-row'>
<div class='col-md-12 form-group'>
<button class='form-control btn btn-success submit-button' type='submit'>Pay »</button>
</div>
</div>
<div class='form-row'>
<div class='col-md-12 error form-group hide'>
<div class='alert-danger alert'>
Please correct the errors and try again.
</div>
</div>
</div>
</form>
</div>
<div class='col-md-4'></div>
</div>
</div>
</body>


