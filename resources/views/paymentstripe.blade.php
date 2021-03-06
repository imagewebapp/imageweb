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
  
<span class="container" style="width:100%;">
  
    <h2>Process Payment</h2>
  
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="width:100%;display:block;margin-left:10px;margin-right:auto;text-align:center;">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
		<div style="color:red;font-style:italic;">Fields marked with asterisk ('*') are mandatory</div>
                <div class="panel-body">
  
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
  
                    <form role="form" action="/cardpayment" method="POST" class="require-validation" data-cc-on-file="false" id="payment-form" name="payment_form">
                        {{ csrf_field() }}
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card *</label> <input class='form-control' size='4' type='text' name="customername">
                            </div>
                        </div>
			<div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Email Id *</label> <input class='form-control' size='4' type='text' name="emailid">
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Card Number *</label> <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                            </div>
                        </div>
			
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC *</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration&nbsp;Month *</label> <select id="ccExpiryMonth" name="ccExpiryMonth" class='form-control card-expiry-month'>
				    <option value="01">01</option>
				    <option value="02">02</option>
				    <option value="03">03</option>
				    <option value="04">04</option>
				    <option value="05">05</option>
				    <option value="06">06</option>
				    <option value="07">07</option>
				    <option value="08">08</option>
				    <option value="09">09</option>
				    <option value="10">10</option>
				    <option value="11">11</option>
				    <option value="12">12</option>
			    	</select>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration&nbsp;Year *</label> <select id="ccExpiryYear" name="ccExpiryYear" class='form-control card-expiry-year'>
				    <option value="2020">2020</option>
				    <option value="2021">2021</option>
				    <option value="2022">2022</option>
				    <option value="2023">2023</option>
				    <option value="2024">2024</option>
				    <option value="2025">2025</option>
				    <option value="2026">2026</option>
				    <option value="2027">2027</option>
				    <option value="2028">2028</option>
				    <option value="2029">2029</option>
				    <option value="2030">2030</option>
				</select>
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Address Line 1 *</label> <input class='form-control' size='4' type='text' name="addressline1">
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 form-group'>
                                <label class='control-label'>Address Line 2</label> <input class='form-control' size='4' type='text' name="addressline2">
                            </div>
                        </div>

			<div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group city'>
                                <label class='control-label'>City</label> <input autocomplete='off'
                                    class='form-control city' size='4' type='text' name="city">
                            </div>
			    <div class='col-xs-12 col-md-4 form-group state'>
                                <label class='control-label'>State</label> <input autocomplete='off'
                                    class='form-control state' size='4' type='text' name="state">
                            </div>
                            <div class='col-xs-12 col-md-4 form-group country required'>
                                <label class='control-label'>Country *</label> 
				<select id="country" name="country" class='form-control'>
				   <option value="Afganistan">Afghanistan</option>
				   <option value="Albania">Albania</option>
				   <option value="Algeria">Algeria</option>
				   <option value="American Samoa">American Samoa</option>
				   <option value="Andorra">Andorra</option>
				   <option value="Angola">Angola</option>
				   <option value="Anguilla">Anguilla</option>
				   <option value="Antigua & Barbuda">Antigua & Barbuda</option>
				   <option value="Argentina">Argentina</option>
				   <option value="Armenia">Armenia</option>
				   <option value="Aruba">Aruba</option>
				   <option value="Australia">Australia</option>
				   <option value="Austria">Austria</option>
				   <option value="Azerbaijan">Azerbaijan</option>
				   <option value="Bahamas">Bahamas</option>
				   <option value="Bahrain">Bahrain</option>
				   <option value="Bangladesh">Bangladesh</option>
				   <option value="Barbados">Barbados</option>
				   <option value="Belarus">Belarus</option>
				   <option value="Belgium">Belgium</option>
				   <option value="Belize">Belize</option>
				   <option value="Benin">Benin</option>
				   <option value="Bermuda">Bermuda</option>
				   <option value="Bhutan">Bhutan</option>
				   <option value="Bolivia">Bolivia</option>
				   <option value="Bonaire">Bonaire</option>
				   <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
				   <option value="Botswana">Botswana</option>
				   <option value="Brazil">Brazil</option>
				   <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
				   <option value="Brunei">Brunei</option>
				   <option value="Bulgaria">Bulgaria</option>
				   <option value="Burkina Faso">Burkina Faso</option>
				   <option value="Burundi">Burundi</option>
				   <option value="Cambodia">Cambodia</option>
				   <option value="Cameroon">Cameroon</option>
				   <option value="Canada">Canada</option>
				   <option value="Canary Islands">Canary Islands</option>
				   <option value="Cape Verde">Cape Verde</option>
				   <option value="Cayman Islands">Cayman Islands</option>
				   <option value="Central African Republic">Central African Republic</option>
				   <option value="Chad">Chad</option>
				   <option value="Channel Islands">Channel Islands</option>
				   <option value="Chile">Chile</option>
				   <option value="China">China</option>
				   <option value="Christmas Island">Christmas Island</option>
				   <option value="Cocos Island">Cocos Island</option>
				   <option value="Colombia">Colombia</option>
				   <option value="Comoros">Comoros</option>
				   <option value="Congo">Congo</option>
				   <option value="Cook Islands">Cook Islands</option>
				   <option value="Costa Rica">Costa Rica</option>
				   <option value="Cote DIvoire">Cote DIvoire</option>
				   <option value="Croatia">Croatia</option>
				   <option value="Cuba">Cuba</option>
				   <option value="Curaco">Curacao</option>
				   <option value="Cyprus">Cyprus</option>
				   <option value="Czech Republic">Czech Republic</option>
				   <option value="Denmark">Denmark</option>
				   <option value="Djibouti">Djibouti</option>
				   <option value="Dominica">Dominica</option>
				   <option value="Dominican Republic">Dominican Republic</option>
				   <option value="East Timor">East Timor</option>
				   <option value="Ecuador">Ecuador</option>
				   <option value="Egypt">Egypt</option>
				   <option value="El Salvador">El Salvador</option>
				   <option value="Equatorial Guinea">Equatorial Guinea</option>
				   <option value="Eritrea">Eritrea</option>
				   <option value="Estonia">Estonia</option>
				   <option value="Ethiopia">Ethiopia</option>
				   <option value="Falkland Islands">Falkland Islands</option>
				   <option value="Faroe Islands">Faroe Islands</option>
				   <option value="Fiji">Fiji</option>
				   <option value="Finland">Finland</option>
				   <option value="France">France</option>
				   <option value="French Guiana">French Guiana</option>
				   <option value="French Polynesia">French Polynesia</option>
				   <option value="French Southern Ter">French Southern Ter</option>
				   <option value="Gabon">Gabon</option>
				   <option value="Gambia">Gambia</option>
				   <option value="Georgia">Georgia</option>
				   <option value="Germany">Germany</option>
				   <option value="Ghana">Ghana</option>
				   <option value="Gibraltar">Gibraltar</option>
				   <option value="Great Britain">Great Britain</option>
				   <option value="Greece">Greece</option>
				   <option value="Greenland">Greenland</option>
				   <option value="Grenada">Grenada</option>
				   <option value="Guadeloupe">Guadeloupe</option>
				   <option value="Guam">Guam</option>
				   <option value="Guatemala">Guatemala</option>
				   <option value="Guinea">Guinea</option>
				   <option value="Guyana">Guyana</option>
				   <option value="Haiti">Haiti</option>
				   <option value="Hawaii">Hawaii</option>
				   <option value="Honduras">Honduras</option>
				   <option value="Hong Kong">Hong Kong</option>
				   <option value="Hungary">Hungary</option>
				   <option value="Iceland">Iceland</option>
				   <option value="Indonesia">Indonesia</option>
				   <option value="India">India</option>
				   <option value="Iran">Iran</option>
				   <option value="Iraq">Iraq</option>
				   <option value="Ireland">Ireland</option>
				   <option value="Isle of Man">Isle of Man</option>
				   <option value="Israel">Israel</option>
				   <option value="Italy">Italy</option>
				   <option value="Jamaica">Jamaica</option>
				   <option value="Japan">Japan</option>
				   <option value="Jordan">Jordan</option>
				   <option value="Kazakhstan">Kazakhstan</option>
				   <option value="Kenya">Kenya</option>
				   <option value="Kiribati">Kiribati</option>
				   <option value="Korea North">Korea North</option>
				   <option value="Korea Sout">Korea South</option>
				   <option value="Kuwait">Kuwait</option>
				   <option value="Kyrgyzstan">Kyrgyzstan</option>
				   <option value="Laos">Laos</option>
				   <option value="Latvia">Latvia</option>
				   <option value="Lebanon">Lebanon</option>
				   <option value="Lesotho">Lesotho</option>
				   <option value="Liberia">Liberia</option>
				   <option value="Libya">Libya</option>
				   <option value="Liechtenstein">Liechtenstein</option>
				   <option value="Lithuania">Lithuania</option>
				   <option value="Luxembourg">Luxembourg</option>
				   <option value="Macau">Macau</option>
				   <option value="Macedonia">Macedonia</option>
				   <option value="Madagascar">Madagascar</option>
				   <option value="Malaysia">Malaysia</option>
				   <option value="Malawi">Malawi</option>
				   <option value="Maldives">Maldives</option>
				   <option value="Mali">Mali</option>
				   <option value="Malta">Malta</option>
				   <option value="Marshall Islands">Marshall Islands</option>
				   <option value="Martinique">Martinique</option>
				   <option value="Mauritania">Mauritania</option>
				   <option value="Mauritius">Mauritius</option>
				   <option value="Mayotte">Mayotte</option>
				   <option value="Mexico">Mexico</option>
				   <option value="Midway Islands">Midway Islands</option>
				   <option value="Moldova">Moldova</option>
				   <option value="Monaco">Monaco</option>
				   <option value="Mongolia">Mongolia</option>
				   <option value="Montserrat">Montserrat</option>
				   <option value="Morocco">Morocco</option>
				   <option value="Mozambique">Mozambique</option>
				   <option value="Myanmar">Myanmar</option>
				   <option value="Nambia">Nambia</option>
				   <option value="Nauru">Nauru</option>
				   <option value="Nepal">Nepal</option>
				   <option value="Netherland Antilles">Netherland Antilles</option>
				   <option value="Netherlands">Netherlands (Holland, Europe)</option>
				   <option value="Nevis">Nevis</option>
				   <option value="New Caledonia">New Caledonia</option>
				   <option value="New Zealand">New Zealand</option>
				   <option value="Nicaragua">Nicaragua</option>
				   <option value="Niger">Niger</option>
				   <option value="Nigeria">Nigeria</option>
				   <option value="Niue">Niue</option>
				   <option value="Norfolk Island">Norfolk Island</option>
				   <option value="Norway">Norway</option>
				   <option value="Oman">Oman</option>
				   <option value="Pakistan">Pakistan</option>
				   <option value="Palau Island">Palau Island</option>
				   <option value="Palestine">Palestine</option>
				   <option value="Panama">Panama</option>
				   <option value="Papua New Guinea">Papua New Guinea</option>
				   <option value="Paraguay">Paraguay</option>
				   <option value="Peru">Peru</option>
				   <option value="Phillipines">Philippines</option>
				   <option value="Pitcairn Island">Pitcairn Island</option>
				   <option value="Poland">Poland</option>
				   <option value="Portugal">Portugal</option>
				   <option value="Puerto Rico">Puerto Rico</option>
				   <option value="Qatar">Qatar</option>
				   <option value="Republic of Montenegro">Republic of Montenegro</option>
				   <option value="Republic of Serbia">Republic of Serbia</option>
				   <option value="Reunion">Reunion</option>
				   <option value="Romania">Romania</option>
				   <option value="Russia">Russia</option>
				   <option value="Rwanda">Rwanda</option>
				   <option value="St Barthelemy">St Barthelemy</option>
				   <option value="St Eustatius">St Eustatius</option>
				   <option value="St Helena">St Helena</option>
				   <option value="St Kitts-Nevis">St Kitts-Nevis</option>
				   <option value="St Lucia">St Lucia</option>
				   <option value="St Maarten">St Maarten</option>
				   <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
				   <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
				   <option value="Saipan">Saipan</option>
				   <option value="Samoa">Samoa</option>
				   <option value="Samoa American">Samoa American</option>
				   <option value="San Marino">San Marino</option>
				   <option value="Sao Tome & Principe">Sao Tome & Principe</option>
				   <option value="Saudi Arabia">Saudi Arabia</option>
				   <option value="Senegal">Senegal</option>
				   <option value="Seychelles">Seychelles</option>
				   <option value="Sierra Leone">Sierra Leone</option>
				   <option value="Singapore">Singapore</option>
				   <option value="Slovakia">Slovakia</option>
				   <option value="Slovenia">Slovenia</option>
				   <option value="Solomon Islands">Solomon Islands</option>
				   <option value="Somalia">Somalia</option>
				   <option value="South Africa">South Africa</option>
				   <option value="Spain">Spain</option>
				   <option value="Sri Lanka">Sri Lanka</option>
				   <option value="Sudan">Sudan</option>
				   <option value="Suriname">Suriname</option>
				   <option value="Swaziland">Swaziland</option>
				   <option value="Sweden">Sweden</option>
				   <option value="Switzerland">Switzerland</option>
				   <option value="Syria">Syria</option>
				   <option value="Tahiti">Tahiti</option>
				   <option value="Taiwan">Taiwan</option>
				   <option value="Tajikistan">Tajikistan</option>
				   <option value="Tanzania">Tanzania</option>
				   <option value="Thailand">Thailand</option>
				   <option value="Togo">Togo</option>
				   <option value="Tokelau">Tokelau</option>
				   <option value="Tonga">Tonga</option>
				   <option value="Trinidad & Tobago">Trinidad & Tobago</option>
				   <option value="Tunisia">Tunisia</option>
				   <option value="Turkey">Turkey</option>
				   <option value="Turkmenistan">Turkmenistan</option>
				   <option value="Turks & Caicos Is">Turks & Caicos Is</option>
				   <option value="Tuvalu">Tuvalu</option>
				   <option value="Uganda">Uganda</option>
				   <option value="United Kingdom">United Kingdom</option>
				   <option value="Ukraine">Ukraine</option>
				   <option value="United Arab Erimates">United Arab Emirates</option>
				   <option value="United States of America">United States of America</option>
				   <option value="Uraguay">Uruguay</option>
				   <option value="Uzbekistan">Uzbekistan</option>
				   <option value="Vanuatu">Vanuatu</option>
				   <option value="Vatican City State">Vatican City State</option>
				   <option value="Venezuela">Venezuela</option>
				   <option value="Vietnam">Vietnam</option>
				   <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
				   <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
				   <option value="Wake Island">Wake Island</option>
				   <option value="Wallis & Futana Is">Wallis & Futana Is</option>
				   <option value="Yemen">Yemen</option>
				   <option value="Zaire">Zaire</option>
				   <option value="Zambia">Zambia</option>
				   <option value="Zimbabwe">Zimbabwe</option>
				</select>
                            </div>
                        </div>
  			<div class='form-row row'>
			    <div class='col-xs-12 col-md-4 form-group zipcode required'>
                                <label class='control-label'>Zip Code *</label> <input autocomplete='off'
                                    class='form-control zip' size='4' type='text' name="zipcode">
                            </div>
			    <div class='col-xs-12 col-md-4 form-group required'>
                                <label class='control-label'>Card Type *</label> 
				<select id="cardtype" name="cardtype" class='form-control'>
				    <option value="credit">Credit Card</option>
				    <option value="debit">Debit Card</option>
				</select>
			    </div>
			    <div class='col-xs-12 col-md-4 form-group required'>
                                <label class='control-label'>Currency *</label> 
				<select id="currency" name="currency" class='form-control' onchange="javascript:adjustpayamt();">
				    <option value="USD">US Dollar (US$)</option>
				    <option value="INR">Indian Rupee (Rs)</option>
				    <option value="GBP">British Pounds (GBP)</option>
				    <option value="EUR">Euro (EUR)</option>
				</select>
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
                                <button class="btn btn-primary btn-lg btn-block" id="btnpay" type="button" onclick='javascript:validate_and_submit();'>Pay US$ <?php echo number_format(round($imageprice,2), 2); ?></button>
                            </div>
			    <div id='waitdiv'></div>
                        </div>
                        <input type='hidden' name='payamt' id='payamt' value="<?php echo number_format(round($imageprice,2), 2); ?>">
			<input type='hidden' name='lowrespath' value="<?php echo $lowrespath; ?>">
                    </form>
                </div>
            </div>        
        </div>
    </div>
      
</span>
  
</body>
  

</html>


