<!DOCTYPE html>
<html>
<head>
	<title>Stripe Payment Success</title>
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
<div class="row">
        <div class="col-md-6 col-md-offset-3" style="width:100%;display:block;margin-left:10px;margin-right:auto;text-align:center;">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
			<?php
			if($status == "fail"){
			    $color = "red";
			}
			else{
			    $color = "blue";
			}
			?>
                        <p class="panel-title display-td" style="color:<?php echo $color; ?>;"><?php echo $statusmessage; ?></p>
                    </div>                    
                </div>
	    </div>
	</div>
</div>

</body>
</html>



