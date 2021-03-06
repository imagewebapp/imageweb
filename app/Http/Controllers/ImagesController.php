<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

use Redirect;
use Input;
use Auth;
use DB;
use Mail;
use Imagick;
use File;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

use App\Validators\ReCaptcha;

use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

use imagescompare;


$imagedumppath = "/var/www/html/imageweb/users/";


function checksession(){
        $sessionid = Session::getId();
        $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
        if(!$sessobj){
            return(0);
        }
        $sessionstatus = $sessobj->sessionstatus;
        if(!$sessionstatus){
            return(0);
        }
        return(1);
}

function getuser(){
    $sessionid = Session::getId();
    $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
    if(!$sessobj){
        return("");
    }
    $sessionstatus = $sessobj->sessionstatus;
    if(!$sessionstatus){
        return("");
    }
    $userid = $sessobj->userid;
    $userobj = DB::table('users')->where('id', $userid)->first();
    $username = $userobj->username;
    return($username);
}

// This function should be called after a call to getuser so that the username is available during its call.
function getprofileimage($username){
    $user = DB::table('users')->where('username', $username)->first();
    $profileimage = $user->profileimage;
    if($profileimage == ""){
	$profileimagepath = "/images/user.png";
        return($profileimagepath);
    }
    $profileimagepath = "/image/".$username."/profileimage/".$profileimage;
    return($profileimagepath);
}


function imagecreatefromany($imagefilepath){
    $imtype = exif_imagetype($imagefilepath);
    $allowedtypes = array(1, 2, 3, 6);
    if(!in_array($imtype, $allowedtypes)){
        return false;
    }
    switch($imtype){
        case 1:
            $im = imagecreatefromgif($imagefilepath);
            break;
        case 2:
            $im = imagecreatefromjpeg($imagefilepath);
            break;
        case 3:
            $im = imagecreatefrompng($imagefilepath);
            break;
        case 6:
            $im = imagecreatefrombmp($imagefilepath);
            break;
    }
    return $im;
}


function getimageresolution($imgfile){
    //$img = imagecreatefromany($imgfile);
    //$imres = imageresolution($img); // for php7
    $img = new Imagick($imgfile);
    $imres = $img->getImageResolution();
    return $imres;
}


function createlowresimage($imagefile){
    $imtype = exif_imagetype($imagefile);
    $imgparts = explode(".", $imagefile);
    $imgparts[0] = $imgparts[0]."_lowres";
    $lowresimagefile = $imgparts[0].".".$imgparts[1];
    list($source_width, $source_height) = getimagesize($imagefile);
    $newwidth = 282;
    $newheight = 188;
    if($source_width < $source_height){
        $newwidth = 282;
        $newheight = 424;
    }
    try{
	$im = imagecreatefromany($imagefile);
	$thumb = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $source_width, $source_height);
    }
    catch(Exception $e){
	return $e->getMessage();
    }
    switch($imtype){
        case 1:
            //imagegif($im, $lowresimagefile, 75);
            imagegif($thumb, $lowresimagefile, 75);
            break;
        case 2:
            //imagejpeg($im, $lowresimagefile, 75);
            imagejpeg($thumb, $lowresimagefile, 75);
            break;
        case 3:
            //imagepng($im, $lowresimagefile, 75);
            imagepng($thumb, $lowresimagefile, 75);
            break;
        case 6:
            //imagewbmp($im, $lowresimagefile, 75);
            imagewbmp($thumb, $lowresimagefile, 75);
            break;
    }
    return $lowresimagefile;
}

function createimageicon($file, $w, $h) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($w/$h > $r) {
        $newwidth = $h*$r;
        $newheight = $h;
    } 
    else{
        $newheight = $w/$r;
        $newwidth = $w;
    }
    //Get file extension
    $exploding = explode(".",$file);
    $ext = end($exploding);
    $imagefilename = $exploding[0];
    $imagefilenameico = $imagefilename."_ico";
    $resizedfilename = $imagefilenameico.".".$ext;
    switch($ext){
        case "png":
            $src = imagecreatefrompng($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagepng($dst, $resizedfilename);
            break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagejpeg($dst, $resizedfilename);
            break;
        case "gif":
            $src = imagecreatefromgif($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagegif($dst, $resizedfilename);
            break;
        default:
            $src = imagecreatefromjpeg($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagejpeg($dst, $resizedfilename);
            break;
    }
    return $resizedfilename;
}


function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = '';
    return $ipaddress;
}


function iscopyrighted($imagefile){
    $exif = exif_read_data($imagefile, 0, true);
    foreach ($exif as $key => $section) {
    	foreach ($section as $name => $val) {
            if(preg_match("/copyright/i", $name) && $val != ""){
		return True;
	    }
    	}
    }
    return False;
}


function removeheaders($imagefile){
    try{
    $img = new Imagick($imagefile);
    $img->stripImage();
    $img->writeImage($imagefile);
    $img->clear();
    $img->destroy();
    }
    catch(Exception $e){
	echo 'Exception caught: ',  $e->getMessage(), "\n";
    }
}


function isduplicateimage($username, $imagefilepath){
    $dir = env("IMAGE_BASE_PATH", "");
    if($dir == ""){
	return True;
    }
    $dir = $dir."/".$username;
    $imghash = hash_file('md5', $imagefilepath);
    if ($h = opendir($dir)) {
    	while (($file = readdir($h)) !== false) {
            // skip directories
            if(is_dir($_="{$dir}/{$file}")) continue;
            $filehash = hash_file('md5', $_);
            if ($imghash == $filehash) {
            	return True;
            }
        }
        closedir($h);
    }
    return False;
}


function isduplicateimage2($userid, $imagefilepath){
    $imagefilepathparts = explode(".", $imagefilepath);
    $imagepartscount = count($imagefilepathparts);
    $ext = $imagefilepathparts[$imagepartscount - 1];
    $imgresource = "";
    if($ext == "jpg" || $ext == "jpeg"){
	$imgresource = imagecreatefromjpg($imagefilepath);
    }
    elseif($ext == "gif"){
	$imgresource = imagecreatefromgif($imagefilepath);
    }
    elseif($ext == "png"){
	$imgresource = imagecreatefrompng($imagefilepath);
    }
    else{
    }
    if($imgresource == ""){
	return True; // if we do not receive any image, then we take it as a duplicate.
    }
    $currfingerprint = fingerprint_image($imgresource);
    $imgrecs = DB::table('images')->where('userid', $userid)->get();
    for($ctr=0; $ctr < count($imgrecs); $ctr++){
	$img = $imgrecs[$ctr];
	if($img->fingerprint == $currfingerprint){
	    return True;
	}
    }
    return False;
}


function fingerprint_image($img, $resolution=8){
    $palette_array = array(
             '000000' => '0', '000b0a' => '1', '00240c' => '2', '005ab5' => '3', '006234' => '4',
             '00a8a4' => '5', '02000c' => '6', '021357' => '7', '02be28' => '8', '03112a' => '9',
             '03efa2' => 'A', '0411a4' => 'B', '04f62d' => 'C', '0becf3' => 'D', '0c12f1' => 'E',
             '10000c' => 'F', '101d01' => 'G', '1a7508' => 'H', '281603' => 'I', '2b0040' => 'J',
             '31a5fc' => 'K', '415aff' => 'L', '46d300' => 'M', '46fe37' => 'N', '48ffa1' => 'O',
             '4c00a0' => 'P', '4deff7' => 'Q', '540ff5' => 'R', '581404' => 'S', '5d6900' => 'T',
             '61023c' => 'U', '98f0fd' => 'V', '9aa3fe' => 'W', '9affc4' => 'X', 'a09400' => 'Y',
             'a11b13' => 'Z', 'a8f712' => 'a', 'afff69' => 'b', 'b138fe' => 'c', 'b500d8' => 'd',
             'c9eefd' => 'e', 'cf0f75' => 'f', 'd3ffc6' => 'g', 'dba8f3' => 'h', 'e49900' => 'i',
             'e6fffb' => 'j', 'e82810' => 'k', 'ebe7fe' => 'l', 'f49486' => 'm', 'f4f413' => 'n',
             'f8f1e2' => 'o', 'f90cde' => 'p', 'f9f468' => 'q', 'fa8f37' => 'r', 'fb49df' => 's',
             'fbf3b7' => 't', 'fbfffb' => 'u', 'fd90d8' => 'v', 'fdc5d6' => 'w', 'fdf8f7' => 'x',
             'ffe3f7' => 'y', 'ffffff' => 'z'
        );
    $max_w   = $resolution;
    $max_h   = $resolution;
    $palette = imagecreate($max_w, $max_h);
    foreach($palette_array as $hex_color=>$val) {
        $int_color = hexdec("0x".$hex_color);
        $color = array("red"   => 0xFF & ($int_color >> 0x10), "green" => 0xFF & ($int_color >> 0x8), "blue"  => 0xFF &  $int_color);
        imagecolorallocate($palette, $color['red'], $color['green'], $color['blue']);
    }
    $width  = imagesx($img);
    $height = imagesy($img);
    if ($height > $width)  {   
        $ratio   = $max_h / $height;  
        $thumb_h = $max_h;
        $thumb_w = $width * $ratio;
    } else {
        $ratio   = $max_w / $width;
        $thumb_w = $max_w;  
        $thumb_h = $height * $ratio;
    }
    $thumb = imagecreate($thumb_w, $thumb_h); 
    imagepalettecopy($thumb, $palette);
    imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_w, $thumb_h, $width, $height);
    imagepalettecopy($thumb, $palette);
    $fingerprint_array = array();
    $w = imagesx($thumb);
    $h = imagesy($thumb);
    for($j=0; $j<$h; $j++) {
        $string = "";
        for($i=0; $i<$w; $i++) {
            $color = ImageColorsForIndex($thumb, imagecolorat($thumb, $i, $j));
            $red   = dechex($color['red'  ]);
            while(strlen($red) < 2) $red = '0'.$red;
            $green = dechex($color['green']);
            while(strlen($green) < 2) $green = '0'.$green;
            $blue  = dechex($color['blue' ]);
            while(strlen($blue) < 2) $blue = '0'.$blue;
            $s = $red.$green.$blue;
            $c = $palette_array[$s];
            $string .= $c;
        }
        $fingerprint_array[] = $string;
    }
    $fingerprint = implode('-', $fingerprint_array);
    return($fingerprint);
}

function checkcardvalidity($cardno){
        $lastchar = mb_substr($cardno, -1);
        $restofthestring = mb_substr($cardno, 0, -1);
        $splitrestofthestring = str_split($restofthestring);
        $reverserestofthestring = array_reverse($splitrestofthestring);
        $reversestring = join("", $reverserestofthestring);
        $strlength = strlen($reversestring);
        for($i=0; $i < $strlength; $i+=2){
            $reversestring[$i] = (int)$reversestring[$i] * 2;
            if((int)$reversestring[$i] > 9){
                $reversestring[$i] = (int)$reversestring[$i] - 9;
            }
        }
        $sumofdigits = 0;
        for($j=0; $j < strlen($reversestring); $j += 1){
            $sumofdigits = $sumofdigits + (int)$reversestring[$j];
        }
        $remainder = $sumofdigits % 10;
        if((int)$remainder != (int)$lastchar){
            return(0);
        }
        return(1);
}


function paypalwithdrawal($amount, $paypal_id){
    $ch = curl_init();
    $PAYPAL_CLIENT_ID = env("PAYPAL_CLIENT_ID");
    $PAYPAL_SECRET = env("PAYPAL_SECRET");
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $PAYPAL_CLIENT_ID.":".$PAYPAL_SECRET);

    $headers = array();
    $headers[] = "Accept: application/json";
    $headers[] = "Accept-Language: en_US";
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $results = curl_exec($ch);
    $getresult = json_decode($results);

    // PayPal Payout API for Send Payment from website to PayPal account
    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $array = array('sender_batch_header' => array(
           "sender_batch_id" => time(),
           "email_subject" => "Funds withdrawal - USD ".$amount,
           "email_message" => "You have withdrawn USD ". $amount." from your imageweb account to your paypal account."
    ),
    'items' => array(array(
           "recipient_type" => "EMAIL",
           "amount" => array(
           "value" => $amount,
           "currency" => "USD"
    ),
           "note" => "Thanks for the payout!",
           "sender_item_id" => time(),
           "receiver" => $paypal_id
    ))
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = array();
    $headers[] = "Content-Type: application/json";
    $headers[] = "Authorization: Bearer $getresult->access_token";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    try{
        $payoutResult = curl_exec($ch);
    }
    catch (Exception $e){
	echo $e->getMessage();
	return(0);
    }
    //print_r($result);
    $getPayoutResult = json_decode($payoutResult);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    //Send email to paypal email Id.
    $sessionid = Session::getId();
    $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
    $userid = $session->userid;
    $user = DB::table('users')->where('id', $userid)->first();
    $firstname = $user->firstname;
    $lastname = $user->lastname;
    $emailid = $user->email;
    $mailcontent = "You have withdrawn USD ".$amount." to the paypal account identified by ".$paypal_id.". If this is not what you wanted, please contact support at support@imageweb.com. <br/><br/>Thanks<br/>Admin\n";
    $hostname = request()->getHttpHost();
    $maildata = array('name' => $hostname." admin", 'mailcontent' => $mailcontent);
    $subject = "Funds withdrawal to ".$paypal_id;
    Mail::send('fundswithdrawalpaypal', $maildata, function ($mailcontent) use($emailid, $firstname, $lastname, $subject){
          $mailcontent->to($emailid, $firstname." ".$lastname)->subject($subject);
          $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
    });
    return(1); // Success code
}



class ImagesController extends BaseController{
    /*
        Create the resource by uploading the image
    */
    public function create(Request $req){
        $s = checksession();
        if(!$s){
            return "User is not logged in to upload images. Please login and try again.";
        }
	// Check captcha:
        $arr = [
            'g-recaptcha-response' => ['required'],
        ];
        $validator = Validator::make(Input::all() , $arr);

        if ($validator->fails()){
            $response = Response::make("Captcha validation failed", 200);
            $response->header("Content-Type", "Text/Plain");
            return $response;
        }
        $imagedumppath = "/var/www/html/imageweb/storage/users/";
        //$imagedumppath = Config::get('app.imagedumppath');
        $file = $_FILES['imgupload']['name'];
        $filetype = $_FILES['imgupload']['type'];
        if($filetype != 'image/png' && $filetype != 'image/jpg' && $filetype != 'image/gif' && $filetype != 'image/jpeg'){
            return "The file was not an image file";
        }
        $filecontents = file_get_contents($_FILES['imgupload']['tmp_name']);
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $user = DB::table('users')->where('id', $session->userid)->first();
        $username = $user->username;
        $userid = $session->userid;
        if($file != ""){
            $targetdir = $imagedumppath.$username."/";
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $tempfilename = $_FILES['imgupload']['tmp_name'];
            $newfilepath = $targetdir.$filename.".".$ext;
            if(file_exists($newfilepath)){// Return a message stating that the upload will clobber an existing file.
                return "A file with the same name already exists. Please delete the existing file and try to upload again";
            }
            else{
		// check if image is copyrighted
		/*
		if(iscopyrighted($tempfilename)){
		    return "The file is copyrighted. You may not upload files that are restricted using copyright";
		}
		*/
		$mimetype = mime_content_type($tempfilename);
                if($mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                    $msg = "File is not a jpeg image file. Please upload jpeg images only";
                    return($msg);
                }
		$r = isduplicateimage($username, $tempfilename);
		//$r = isduplicateimage2($userid, $tempfilename);
		
		if($r){
		    return "This is a duplicate image. This image cannot be uploaded.";
		}
		
		removeheaders($tempfilename);
                move_uploaded_file($tempfilename, $newfilepath);
                $imresraw = getimageresolution($newfilepath);
                $imres = implode("x", $imresraw);
                $iconpath = createimageicon($newfilepath, 300, 300);
                $lowresimgpath = createlowresimage($newfilepath);
                $imagefilename = basename($newfilepath);
                $lowresfilename = basename($lowresimgpath);
                $iconfilename = basename($iconpath);
                $imagetags = "";
                $categories = "";
                if(array_key_exists('imagetags', $_POST)){
                    $imagetags = $_POST['imagetags'];
                }
                $categories = "";
                if(array_key_exists('categories', $_POST)){
		    $categories = $_POST['categories'];
                    $categories = rtrim($categories, ",");
                }
		$price = 0.00;
		if(array_key_exists('price', $_POST)){
		    $price = floatval($_POST['price']);
		}
                $imagedata = array('imagepath' => $newfilepath, 'userid' => $userid, 'imagefilename' => $imagefilename, 'resolution' => $imres, 'verified' => 0, 'lowrespath' => $lowresimgpath, 'lowresfilename' => $lowresfilename, 'iconpath' => $iconpath, 'iconfilename' => $iconfilename, 'imagetags' => $imagetags, 'premium' => 0, 'categories' => $categories, 'price' => $price);
                DB::table('images')->insert($imagedata);
                return "File has been uploaded successfully";
            }
        }
    }

    /* Show Bulk Upload Screen */
    public function showbulkupload(Request $req){
	return view('bulkupload');
    }


    /* Handle Bulk Upload files */
    public function handlebulk(Request $req){
	$s = checksession();
        if(!$s){
            return "User is not logged in to upload images. Please login and try again.";
        }
        // Check captcha:
        $arr = [
            'g-recaptcha-response' => ['required'],
        ];
        $validator = Validator::make(Input::all() , $arr);

        if ($validator->fails()){
            $response = Response::make("Captcha validation failed", 200);
            $response->header("Content-Type", "Text/Plain");
            return $response;
        }
        $imagedumppath = "/var/www/html/imageweb/storage/users/";
	$sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $user = DB::table('users')->where('id', $session->userid)->first();
        $username = $user->username;
        $userid = $session->userid;
	$allowedfileExtension= ["jpg", "jpeg"];
	$files = $req->file('fileToUpload');
	foreach($files as $file){
	    $filename = $file->getClientOriginalName();
	    echo $filename;
	    $extension = $file->getClientOriginalExtension();
	    $check = in_array($extension,$allowedfileExtension);
	    if($check){
		//Store the file in appropriate location.
		$targetdir = $imagedumppath.$username."/";
	    }
	    else{
		return("You may upload JPEG files only.");
	    }
	}
    }


    /*
        Display clicked image (in gallery) on an overlay
    */
    public function display(Request $req){

    } 


    public function showforgotpassword(Request $req){
	return view('forgotpassword');
    }


    public function generatepasscode(Request $req){
	$username = $_POST['username'];
	$emailid = $_POST['emailid'];
	// First, check and verify that the username corresponds to the given email Id
	$userrec = DB::table('users')->where('username', $username)->first();
	$regemail = $userrec->email;
	$firstname = $userrec->firstname;
	$lastname = $userrec->lastname;
	if($regemail != $emailid){
	    return("The given email Id is not registered with the given username. Please enter your registered email Id and try again");
	}
	// Next, generate the random passcode
	$digits = 6;
	$passcode = rand(pow(10, $digits-1), pow(10, $digits)-1);
	// Add this passcode, username and email Id into the changepass table
	$changepassvals = array('passcode' => $passcode, 'username' => $username);
	DB::table('changepass')->insert($changepassvals);
	// Finally, send the passcode to the given email Id.
	$mailcontent = "Please enter the following passcode in the 'change password' screen: ".$passcode.". You will also need to enter a new password for your account. \n\nThanks\nAdmin\n";
	$hostname = $req->getHost();
	$maildata = array('name' => $hostname." admin", 'mailcontent' => $mailcontent);
	$subject = "Change password on ".$hostname;
	Mail::send('changepasswordmail', $maildata, function ($mailcontent) use($emailid, $firstname, $lastname, $subject){
          $mailcontent->to($emailid, $firstname." ".$lastname)->subject($subject);
          $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
        });
	return "";
    }


    public function showchangepassword(Request $req){
	return view('changepassword');
    }


    public function changepassword(Request $req){
	if(!array_key_exists('passcode', $_POST) || !array_key_exists('password', $_POST) || !array_key_exists('confirmpassword', $_POST)){
	    return("One or more parameters is missing. Please enter appropriate values in all fields and try again");
	}
	$passcode = $_POST['passcode'];
	$password = $_POST['password'];
	$confirmpassword = $_POST['confirmpassword'];
	if($password != $confirmpassword){
	    return("Password and Confirm Password values should be the same. Please fill up the fields with same value and try again.");
	}
	$changepassrec = DB::table('changepass')->where('passcode', $passcode)->orderBy('codegenerationts', 'desc')->first();
	if(!$changepassrec){
	    return("You entered a wrong passcode. Please enter your correct passcode and try again");
	}
	$currtimestr = date("Y-m-d H:i:s");
	$currtime = strtotime($currtimestr);
	$delta = $currtime - strtotime($changepassrec->codegenerationts);
	if($delta > 900){ // code was generated more than 30 mins back.
	    return("Your passcode has become stale. Please generate a new passcode by clicking on 'forgot password' link and try again".$delta);
	}
	$username = $changepassrec->username;
	$passwordhash = Hash::make($password);
	DB::table('users')->where('username', $username)->update(array('password' => $passwordhash));
	return("");
    }

    /*
	Display gallery of images. Note: Session is not required for this page.
    */
    public function showgallery(Request $req){
        $startpoint = 0;
        if(array_key_exists('startpoint', $_GET)){
            $startpoint = $_GET['startpoint'];
        }
	$lastpoint = 0;
	if(array_key_exists('lastpoint', $_GET)){
            $lastpoint = $_GET['lastpoint'];
	    $startpoint = $lastpoint;
        }
        //$chunksize = 40;
        $chunksize = env('CHUNKSIZE');
        $totalcount = 0; //initialize totalcount here.
	$mode = $req->input('selmode');
        if($mode == ""){
	    $mode = "all";
	}
	$tags = $req->input('tagslist');
	if(!$tags){
	    $tags = $req->input('tagslist2');
	    if($tags){
		$mode = "tags";
	    }
	}
	$imagesrecs = [];
	if($mode == 'all' || $mode == ''){
            $imagesrecs = DB::table('images')->where([ ['verified', '=',1], ['removed', '=', 0]])->orderBy('uploadts', 'DESC')->skip($startpoint)->take($chunksize)->get();
            //$imagesrecs = DB::table('images')->where('verified', 1)->orderBy('uploadts', 'DESC')->get();
            $totalcount = DB::table('images')->where([['verified', '=', 1], ['removed', '=', 0]])->count();
	    $lastpoint = $totalcount - $chunksize;
	}
	elseif($mode == 'popularity'){
	    //$hits = DB::table('imagehits')->groupBy('imageid')->select('imageid', DB::raw('count(*) as hitcount'))->get();
	    $hits = DB::table('imagehits')->select('imageid', DB::raw('count(*) as hitcount'))->groupBy('imageid')->orderBy('hitcount', 'desc')->skip($startpoint)->take($chunksize)->get();
	    for($i=0; $i < count($hits); $i++){
		$hit = $hits[$i];
		$imgid = $hit->imageid;
		$img = DB::table('images')->where([['id','=', $imgid], ['removed', '=', 0]])->first();
		array_push($imagesrecs, $img);
	    }
	    $totalcount = count($hits);
	    $lastpoint = $totalcount - $chunksize;
	}
	elseif($mode == 'tags'){
	    $alltags = explode(",", $tags);
	    for($i=0; $i < count($alltags); $i++){ 
		$tag = $alltags[$i];
		$tag = preg_replace('/^\s+/', '', $tag);
		$tag = preg_replace('/\s+$/', '', $tag);
	        $imgs = DB::table('images')->where([ ['verified', '=', '1'], ['imagetags', 'like', '%'.$tag.'%'], ['removed', '=',0] ])->skip($startpoint)->take($chunksize)->get();
		for($c=0; $c < count($imgs); $c++){
		    $img = $imgs[$c];
		    array_push($imagesrecs, $img);
		}
		// User may enter file name (or partial filenames) in tags text input. So do a search using filenames.
		$tagparts = explode(".", $tag);
		if(count($tagparts) > 1 && ($tagparts[count($tagparts)-1] == "jpg" || $tagparts[count($tagparts)-1] == "jpeg")){
		    array_pop($tagparts);
		}
		if(count($tagparts) > 0){
		    $tagname = implode(".", $tagparts);
		    $imgs = DB::table('images')->where([ ['verified', '=', '1'], ['imagefilename', 'like', '%'.$tagname.'%'], ['removed', '=',0] ])->skip($startpoint)->take($chunksize)->get();
		    for($c=0; $c < count($imgs); $c++){
                        $img = $imgs[$c];
                    	array_push($imagesrecs, $img);
                    }
		}
	    }
	    $totalcount = count($imagesrecs);
	    $lastpoint = $totalcount - $chunksize;
	}
        $startpoint = $startpoint + $chunksize;
        $username = getuser();
        $profileimagepath = "";
        if($username != ""){
	    $profileimagepath = getprofileimage($username);
        }
	return view('gallery')->with(array('images' => $imagesrecs, 'totalcount' => $totalcount, 'chunksize' => $chunksize, 'startpoint' => $startpoint, 'username' => $username, 'profileimage' => $profileimagepath, 'lastpoint' => $lastpoint));
    }

    
    public function displayimage(Request $req, $username, $filename, $paymentid=-1){
        $path = storage_path('users/'.$username."/".$filename);
        if (!File::exists($path)) {
            return "file doesn't exist";
        }
	/*
	$referer = $req->header('HTTP_REFERER');
	if(!$referer){
	    $referer = URL::previous();
	}
	$callerdomain = env("DOMAIN_URL");
	if(!preg_match("/".$callerdomain."/", $referer)){
	    return "The request for the image didn't come from the correct domain";
	}
	$sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $userid = $session->userid;
	*/
	/*
	To Do: Check if the $filename is a high res image. If so, check if it is a premium image.
	If so, check to see if we have a valid paymentid. If not, return message saying user can't
	see the image. If we have a valid paymentid (verified from the DB), we allow the user to
	take the image.
	*/
	// Get the current (image) request URL
	$imgurl = URL::current();
	if(!preg_match("/lowres/", $imgurl) && !preg_match("/_ico/", $imgurl)){
	    // Get the price of the image
	    $user = DB::table('users')->where('username', $username)->first();
	    $userid = $user->id;
	    $imgrec = DB::table('images')->where([ ['userid', '=', $userid], ['imagefilename', '=', $filename]])->first();
	    $imgprice = number_format(round($imgrec->price, 2), 2);
	    //if($imgprice > 0.00 && $imgrec->userid != $userid){ // This will allow the image to be viewed by its owner.
	    if($imgprice > 0.00){ // This will allow the image to be viewed by its owner.
	 	// check payment Id
		return "You can't download this image without paying for it.";
	    }
	}
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }


    public function displayprofileimage($username, $filename){
        $path = storage_path('users/'.$username."/profileimage/".$filename);
        if (!File::exists($path)) {
            return "file doesn't exist";
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    } 


    /*
        Allow legitimate users to download the image.
    */
    public function download(Request $req){
        //$s = checksession();
        //if(!$s){
        //    return "User is not logged in to download images. Please login and try again.";
        //} //Login is not required to download images.
	// Check captcha:
	$arr = [
    	    'g-recaptcha-response' => 'required'
	];
	$validator = Validator::make(Input::all() , $arr);
	
        if ($validator->fails()){
	    $response = Response::make("Captcha validation failed", 400);
            $response->header("Content-Type", "Text/Plain");
            return $response;
        }
	
        $client_ip = "";
        $client_ip = get_client_ip();
	$details = json_decode(file_get_contents("http://ipinfo.io/{$client_ip}/json"), true);
	$geoloc = "";
	try{
	    if(array_key_exists("city", $details)){
	    	$geoloc = $details['city'];
	    }
	}
	catch(Exception $e){
	}
	$imagepath = $_GET['imagepath'];
        $imagepathparts = explode("/", $imagepath);
        $imageownername = $imagepathparts[2];
	$lowresimagefilename = $imagepathparts[3];
        $user = DB::table('users')->where('username', $imageownername)->first();
        $ownerid = $user->id;
        $image = DB::table('images')->where([ ['userid', '=', $ownerid], ['lowresfilename', '=', $lowresimagefilename], ['removed', '=', 0] ])->first();
        if(!$image){
	    return "Image Couldn't be found!";
	}
	$imagepath = $image->imagepath;
        $imagefilename = $image->imagefilename;
        $sessionid = Session::getId();
        $visitor = 0;
        if($sessionid){
            $sessobj = DB::table('sessions')->where([ ['sessionid', '=', $sessionid], ['sessionstatus', '=', '1'] ])->first();
            if($sessobj){
                $visitor = $sessobj->userid;
            }
        }
        $imageid = $image->id;
	// Check to see if the same image has been downloaded from the same IP previously. If so, imagehit is not incremented.
        $prevhit = DB::table('imagehits')->where([ ['ipaddress', '=', $client_ip], ['imageid', '=', $imageid] ])->first();
	if(!$prevhit){
            $hittime = date("Y-m-d H:i:s");
	    $useragent = $_SERVER['HTTP_USER_AGENT'];
            $hitdata = array('imageid' => $imageid, 'owneruserid' => $ownerid, 'visitor' => $visitor, 'hittime' => $hittime, 'ipaddress' => $client_ip, 'geolocation' => $geoloc, 'user_agent' => $useragent);
            DB::table('imagehits')->insert($hitdata);
	}
        $response = Response::make("Thanks for downloading", 200);
        $response->header("Content-Type", "Text/Plain");
        return $response;
    }

    /*
       Show download popup window to user
    */
    public function showdownloadwin(Request $req){
        $imagepath = "";
        if(array_key_exists('imagepath', $_GET)){
            $imagepath = $_GET['imagepath'];
        }
	$imagecategory = "";
	$imagehits = 0;
	$imagetags = "";
	$imageprice = "Free";
	$imageowner = "";
	$images = array();
        $imagepathparts = explode("/", $imagepath);
	$pathpartslength = count($imagepathparts);
	$imgfilename = $imagepathparts[$pathpartslength-1];
	$ownername = $imagepathparts[$pathpartslength-2];
	$user= DB::table('users')->where([ ['username', '=', $ownername] ])->first();
	$ownerid = $user->id;
	$imagerecord = DB::table('images')->where([ ['lowresfilename', '=', $imgfilename ], ['removed', '=', 0], ['userid','=', $ownerid ] ])->first();
	$imagecategory = $imagerecord->categories;
	$imagetags = $imagerecord->imagetags;
	$imageprice = $imagerecord->price;
	if(!$imageprice){
	    $imageprice = "Free";
	}
	$imageownerid = $imagerecord->userid;
	$imageid = $imagerecord->id;
	$userrecord = DB::table('users')->where('id', $imageownerid)->first();
	$imageowner = $userrecord->username;
	$imghitsrecs = DB::table('imagehits')->where('imageid', $imageid)->get();
	$imagehits = count($imghitsrecs);
	$catslist = explode(",", $imagecategory);
	$unique_images = array();
	$imagesinfo = array();
	for($c=0;$c < count($catslist);$c++){
	    $imagerecs = DB::table('images')->where([ ['categories', 'like', '%'.$catslist[$c].'%'], ['verified', '=', '1'], ['removed', '=', 0] ])->take(20)->get();
	    for($i=0; $i < count($imagerecs); $i++){
		$imgrec = $imagerecs[$i];
		$imgfilename = $imgrec->imagefilename;
		$imgorigpath = $imgrec->imagepath;
		$origpathparts = explode("users", $imgorigpath);
		$imgorigwebpath = "/image".$origpathparts[1];
		$imglowrespath = $imgrec->lowrespath;
		$lowrespathparts = explode("users", $imglowrespath);
		$imglowrespathweb = "/image".$lowrespathparts[1];
		$imgcategories = $imgrec->categories;
		$imgprice = $imgrec->price;
		$imgtags = $imgrec->imagetags;
		$imguserid = $imgrec->userid;
		$imgid = $imgrec->id;
		$imguserrec = DB::table('users')->where('id', $imguserid)->first();
		$imgownername = $imguserrec->username;
		$imghitsrecs = DB::table('imagehits')->where('imageid', $imgid)->get();
		$imghitscount = count($imghitsrecs);
		$imagesinfo[$imglowrespathweb] = array('categories' => $imgcategories, 'imagehits' => $imghitscount, 'owner' => $imgownername, 'imagetags' => $imgtags, 'price' => $imgprice, 'origpath' => $imgorigwebpath);
		if(!array_key_exists($imgfilename, $unique_images)){
		    array_push($images, $imgrec);
		    $unique_images[$imgfilename] = 1;
		}
	    }
	}
        return view('downloadpopup')->with(array('imagepath' => $imagepath, 'imagecategory' => $imagecategory, 'imagehits' => $imagehits, 'imagetags' => $imagetags, 'imageprice' => $imageprice, 'imageowner' => $imageowner, 'images' => $images, 'imagesinfo' => $imagesinfo));
    }


    /*
        Allow the legitimate owner to update the image.
    */
    public function update(Request $req){

    }


    /*
        Allow owner user to delete the image
    */
    public function removeimage(Request $req){
	$s = checksession();
        if(!$s){
            return view('login');
        }
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $userid = $session->userid;
	$inputuserid = $req->input("userid");
	if($userid != $inputuserid){
	  $response = Response::make("The session seems to be corrupt. The image could not be removed due to this issue.", 200);
          $response->header("Content-Type", "Text/Plain");
          return $response;
	}
	$imagefilename = $req->input("imagefilename");
	$user = DB::table('users')->where('id', $userid)->first();
	$username = $user->username;
        $imagepath = "/var/www/html/imageweb/storage/users/".$username."/".$imagefilename;
	# Delete records from DB tables first.
	$imgobj =  DB::table('images')->where([ ['imagepath', '=', $imagepath] ])->first();
	$imgid = $imgobj->id;
	DB::table('images')->where('id', $imgid)->update(array('removed' => 1));
	$removedpath = "/var/www/html/imageweb/storage/removed/".$username;
	if(!file_exists($removedpath)){
            mkdir($removedpath, 0777, true);
        }
	// Find all files related to the selected image
	$imagepathparts = explode(".", $imagepath);
	$userpath = "/var/www/html/imageweb/storage/users/".$username;
	$lowresimage = $imagepathparts[0]."_lowres.".$imagepathparts[1];
	$iconimage = $imagepathparts[0]."_ico.".$imagepathparts[1];
	$imagefilenameparts = explode(".", $imagefilename);
	$newlowresfilename = $imagefilenameparts[0]."_lowres.".$imagefilenameparts[1];
	$newiconfilename = $imagefilenameparts[0]."_ico.".$imagefilenameparts[1];
	$newimagefilepath = $removedpath."/".$imagefilename;
	$newlowresfilepath = $removedpath."/".$newlowresfilename;
	$newiconfilepath = $removedpath."/".$newiconfilename;
	rename($imagepath, $newimagefilepath);
	rename($lowresimage, $newlowresfilepath);
	rename($iconimage, $newiconfilepath);
	$response = Response::make("Deleted the selected image successfully", 200);
	$response->header("Content-Type", "Text/Plain");
        return $response;
    }

    /*
        SHow login form page
    */
    public function showloginpage(){
        return view('login');
    }


    /*
        Login user
    */
    public function dologin(Request $req){
      $rules = array(
      'username' => 'required|alphaNum|min:4', // make sure the email is an actual email
      'password' => 'required|alphaNum|min:8'
      );
      // checking all field
      $validator = Validator::make(Input::all() , $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails())
        {
        return Redirect::to('login')->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        }
        else
        {
        // create our user data for the authentication
        $username = $req->input('username');
        $password = $req->input('password');
        $hashedpassword = Hash::make($password);
        //$user = User::where('username', '=', $username);
        $user = DB::table('users')->where('username', $username)->first();
        if(Hash::check($password, $user->password)){
           if($user->verified){
               // Add session to sessions table
               if(!checksession()){
                   $req->session()->regenerate();
                   $sessionid = Session::getId();
                   $userid = $user->id;
                   $starttime = date("Y-m-d H:i:s");
                   $sessdata = array('sessionid' => $sessionid, 'userid' => $userid, 'starttime' => $starttime);
                   DB::table('sessions')->insert($sessdata);
               }
	       $rurl = $req->input('rurl');
	       preg_match('/getimage/', $rurl, $matches);
	       if(count($matches) > 0){
		  return Redirect::to($rurl);
	       }
               return Redirect::to('dashboard');
           } 
        }        
        return Redirect::to('login')->withErrors(['The username or password was incorrect']);
      }
    }


    /* 
        Logout user
    */
    public function dologout(Request $req){
        $sessionid = Session::getId();
        //print_r($sessionid);
        DB::table('sessions')->where('sessionid', $sessionid)->update(array('sessionstatus' => 0));
        return view('login');
    }


    /*
        User registration form
    */
    public function showregistrationform(){
        return view('register');
    }


    /*
        Process registration form data
    */
    public function doregister(Request $req){
        $rules = array(
          'username' => 'required|alphaNum|min:4', // make sure the email is an actual email
          'password' => 'required|alphaNum|min:8',
          'confirmpassword' => 'required|alphaNum|min:8|same:password',
	  'email' => 'required'
        );
        $validator = Validator::make(Input::all() , $rules);
        // if the validator fails, redirect back to the form
        if ($validator->fails()){
            return Redirect::to('register')->withErrors($validator) // send back all errors to the login form
            ->withInput(Input::except('confirmpassword')); // send back the input (not the confirmpassword) so that we can repopulate the form
        }
        $username = $req->input('username');
        $firstname = $req->input('firstname');
        $lastname = $req->input('lastname');
        $emailid = $req->input('email');
        $password = Hash::make($req->input('password'));
        $confirmpassword = Hash::make($req->input('confirmpassword'));
	if($req->input('password') != $req->input('confirmpassword')){
	    return("Password and Confirm Password fields do not match");
	}
	$users = DB::table('users')->where('email', $emailid)->get();
	if($users && count($users) >= 1){
	    return Redirect::back()->withErrors(["This email Id has already been used by another user. Please insert another email Id"]);
	}
        $data = array('firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'email' => $emailid, 'password' => $password);
        // send an email with verification link. Generate a verification code first.
        $randomtoken = str_random(32);
        $data['verificationtoken'] = $randomtoken;
        $hostname = $req->getHost();
        $verificationurl = "http://".$hostname.":".$_SERVER['SERVER_PORT']."/verify?token=".$randomtoken;
        $mailcontent = "Thanks for signing up with imageweb.\n\nPlease click on the link below to verify your email Id. You may start using your account once it is verified. Click here: <a href='".$verificationurl."' target='_blank'>".$verificationurl."</a>";
        $subject = "Verify account on ".$hostname;
        DB::table('users')->insert($data);
        // Create directory for user now...
        $userpath = "/var/www/html/imageweb/storage/users/".$username;
        mkdir($userpath);
        mkdir($userpath."/profileimage");
        // Send email now.
        $maildata = array('name' => $hostname." admin", 'mailcontent' => $mailcontent);
        Mail::send('verify', $maildata, function ($mailcontent) use($emailid, $firstname, $lastname, $subject){
          $mailcontent->to($emailid, $firstname." ".$lastname)->subject($subject);
          $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
        });
        Session::flash('activation', 'Please activate your account by clicking on the verification link sent to your email. You would be able to login after that.');
        return view('login');
    }


    /*
        Activate registered users when they click on a link in the registration email.
    */
    public function activateregistration(Request $req){
        $regtoken = $req->input('token');
        //$user = DB::table('users')->where('verificationtoken', $regtoken)->first(); 
        DB::update('update users set verified=1 where verificationtoken=?',[$regtoken]);
        Session::flash('activation', 'Your acccount has been activated. Please login below.');
        return view('login');
    }

    
    public function dashboard(){
        $s = checksession();
        if(!$s){
            return view('login');
        }
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $userid = $session->userid;
        $user = DB::table('users')->where('id', $userid)->first();
        $usertype = $user->usertype;
        $start = 0;
        $chunksize = 20;
        if(array_key_exists('start', $_GET)){
            $start = $_GET['start'];
        }
	$lastpoint = 0;
	if(array_key_exists('lastpoint', $_GET)){
            $lastpoint = $_GET['lastpoint'];
	    $start = $lastpoint;
        }
        $images = DB::table('images')->where([['userid', '=', $userid], ['removed', '=', 0]])->orderBy('uploadts', 'DESC')->skip($start)->take($chunksize)->get();
        $max = DB::table('images')->where('userid', $userid)->count();
        $start = $start + $chunksize;
	$lastpoint = $max - $chunksize;
        $categories = DB::table('categories')->get();
        $username = getuser();
        $profileimagepath = getprofileimage($username);
        return view('dashboard')->with(array('images' => $images, 'categories' => $categories, 'usertype' => $usertype, 'start' => $start, 'max' => $max, 'chunk' => $chunksize, 'username' => $username, 'userid' => $userid, 'profileimage' => $profileimagepath, 'lastpoint' => $lastpoint ));
    }


    public function verifyimagesiface(Request $req){
        $s = checksession();
        if(!$s){
            return view('login');
        }
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $userid = $session->userid;
        $user = DB::table('users')->where('id', $userid)->first();
        $usertype = $user->usertype;
        if($usertype != 'admin'){
            return view('login');
        }
        // Now allow user to verify images.
        $images = DB::table('images')->where([ ['verified', '=', 0], ['removed', '=', '0'] ])->get();
        $imagesdict = array();
        $numimages = count($images);
        for($i=0; $i < $numimages; $i++){
            $imgid = $images[$i]->id;
            $imgpath = $images[$i]->imagepath;
            $ownerid = $images[$i]->userid;
            $ownerobj = DB::table('users')->where('id', $ownerid)->first();
            $ownername = $ownerobj->username;
            $imagepathparts = explode($ownername, $imgpath);
            $imgwebpath = "/image/".$ownername.$imagepathparts[1];
	    $lowrespath = $images[$i]->lowrespath;
	    $lowrespathparts = explode("users", $lowrespath);
	    $lowreswebpath = "/image".$lowrespathparts[1];
            $imagesdict[$imgwebpath] = [$imgid, $lowreswebpath];
        } 
        $username = getuser();
        $profileimagepath = getprofileimage($username);
        return view('verifyimagesiface')->with(array('imagesdict' => $imagesdict, 'username' => $username, 'profileimage' => $profileimagepath, 'verifymessage' => ""));
    }


    public function verifyimages(Request $req){
        $s = checksession();
        if(!$s){
            return view('login');
        }
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $userid = $session->userid;
        $user = DB::table('users')->where('id', $userid)->first();
        $usertype = $user->usertype;
        if($usertype != 'admin'){
            return view('login');
        }
        $imgverifylist = $_POST['imgverify'];
	$accepted = array();
	$rejected = array();
        for($i=0; $i < count($imgverifylist); $i++){
	    $verifyfieldname = 'imgverify'.$imgverifylist[$i];
	    $verifystatus = "";
	    if(array_key_exists($verifyfieldname, $_POST)){
	    	$verifystatus = $_POST[$verifyfieldname];
	    }
	    if($verifystatus == "accept"){
            	DB::table('images')->where('id', $imgverifylist[$i])->update(array('verified' => 1)); 
		array_push($accepted, $imgverifylist[$i]);
	    }
	    elseif($verifystatus == "reject"){
            	DB::table('images')->where('id', $imgverifylist[$i])->update(array('verified' => -1)); 
		array_push($rejected, $imgverifylist[$i]);
	    }
	    else{
	    }
        }
	// Send email with status
	$emailid = "imagewebapp@gmail.com";
	$mailcontent = "Hi,
	    Images with the following IDs have been accepted.<br>";
	$mailcontent .= implode("<br>", $accepted);
	$mailcontent .= "<br><br>The following images (IDs) have been rejected.<br>";
	$mailcontent .= implode("<br>", $rejected);
	$mailcontent .= "<br><br>Thanks and Regards,
		<br>Admin";
	$subject = "Image Verification";
	$firstname = $user->firstname;
	$lastname = $user->lastname;
	$maildata = array('name' => "imagewebapp admin", 'mailcontent' => $mailcontent);
	Mail::send('verify', $maildata, function ($mailcontent) use($emailid, $firstname, $lastname, $subject){
  	  $mailcontent->to($emailid, $firstname." ".$lastname)->subject($subject);
  	  $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
	});
	$images = DB::table('images')->where([ ['verified', '=',  0], ['removed', '=', '0'] ])->get();
        $imagesdict = array();
        $numimages = count($images);
        for($i=0; $i < $numimages; $i++){
            $imgid = $images[$i]->id;
            $imgpath = $images[$i]->imagepath;
            $ownerid = $images[$i]->userid;
            $ownerobj = DB::table('users')->where('id', $ownerid)->first();
            $ownername = $ownerobj->username;
            $imagepathparts = explode($ownername, $imgpath);
            $imgwebpath = "/image/".$ownername.$imagepathparts[1];
	    $lowrespath = $images[$i]->lowrespath;
            $lowrespathparts = explode("users", $lowrespath);
            $lowreswebpath = "/image".$lowrespathparts[1];
            $imagesdict[$imgwebpath] = [$imgid, $lowreswebpath];
        }
        $username = getuser();
        $profileimagepath = getprofileimage($username);
	return view('verifyimagesiface')->with(array('imagesdict' => $imagesdict, 'username' => $username, 'profileimage' => $profileimagepath, 'verifymessage' => "All checked images has been verified successfully. You should now be able to view them in the 'Gallery' page." ));
    }


    public function changeprofileimage(Request $req){
        $s = checksession();
        if(!$s){
            return "User is not logged in to upload images. Please login and try again.";
        }
        $imagedumppath = "/var/www/html/imageweb/storage/users/";
        //$imagedumppath = Config::get('app.imagedumppath');
        $file = $_FILES['uploadfile']['name'];
        $filetype = $_FILES['uploadfile']['type'];
        if($filetype != 'image/png' && $filetype != 'image/jpg' && $filetype != 'image/gif' && $filetype != 'image/jpeg'){
            return "The file was not an image file";
        }
        $filecontents = file_get_contents($_FILES['uploadfile']['tmp_name']);
        $sessionid = Session::getId();
        $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
        $user = DB::table('users')->where('id', $session->userid)->first();
        $username = $user->username;
        $userid = $session->userid;
        if($file != ""){
            $targetdir = $imagedumppath.$username."/profileimage/";
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $tempfilename = $_FILES['uploadfile']['tmp_name'];
            $newfilepath = $targetdir.$filename.".".$ext;
            move_uploaded_file($tempfilename, $newfilepath);
	    $profilefilename = $filename.".".$ext;
	    DB::table('users')->where('id', $userid)->update(array('profileimage' => $profilefilename));
	    return "Please refresh the screen to see your uploaded profile image";
        }
	return "Your image could not be uploaded. Please try again or contact the administrator";
    }


    public function showaboutus(Request $req){
	$username = "";
	$username = getuser();
	$profileimagepath = "";
        if($username != ""){
            $profileimagepath = getprofileimage($username);
        }
	return view('aboutus')->with(array('username' => $username, 'profileimage' => $profileimagepath));
    }


    public function showtermsandconditions(Request $req){
	$username = "";
	$username = getuser();
	$profileimagepath = "";
        if($username != ""){
            $profileimagepath = getprofileimage($username);
        }
	return view('termsandconditions')->with(array('username' => $username, 'profileimage' => $profileimagepath));
    }


    public function paymentbypaypal(Request $req){
	$imageprice = 0;
        $lowrespath = "";
        if(array_key_exists('img', $_GET)){
	    $lowresimg = $_GET['img'];
            $lowresimgparts = explode("image", $lowresimg);
            $basepath = "/var/www/html/imageweb/storage/users";
            $lowrespath = $basepath.$lowresimgparts[1];
            $recs = DB::table('images')->where('lowrespath', $lowrespath)->get();
            if(count($recs) == 0){
                $msg = "Couldn't find image with the specification submitted";
                return($msg);
            }
            $imageprice  = $recs[0]->price;
	}
	else{
	    $msg = "Required parameter img missing";
            return($msg);
	}
	return view('paymentpaypal')->with(array('imageprice' => $imageprice, 'lowrespath' => $lowrespath));
    }


    public function __construct(){
	/** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function makepaymentbypaypal(Request $req){
	//require 'vendor/autoload.php';
	$apiContext = new \PayPal\Rest\ApiContext(
  	    new \PayPal\Auth\OAuthTokenCredential(
    	    	env('PAYPAL_CLIENT_ID'),
    	    	env('PAYPAL_SECRET')
  	    )
	);
	$paypalacctid = $req->get('paypalacctid');
	$cmd = $req->get('cmd');
	$business = "imagewebapp@gmail.com";
	$item_name = $req->get('item_name');
	$item_number = $req->get('item_number');
	$currency_code = $req->get('currency_code');
	$lc = $req->get('lc');
	$bn = $req->get('bn');
	$payamt = $req->get('payamt');
	$lowrespath = $req->get('lowrespath');

	$payer = new \PayPal\Api\Payer();
	$payer->setPaymentMethod('paypal');
	$item_1 = new \PayPal\Api\Item();
	$item_1->setName($item_name)
	    ->setCurrency('USD')
	    ->setQuantity(1)
	    ->setPrice($payamt);
	$item_list = new \PayPal\Api\ItemList();
	$item_list->setItems(array($item_1));

	$amount = new \PayPal\Api\Amount();
	$amount->setCurrency('USD')
	    ->setTotal($payamt);

	$transaction = new \PayPal\Api\Transaction();
	$transaction->setAmount($amount)
	    ->setItemList($item_list)
	    ->setDescription("Buying premium content");
	
	$schemeandhost = $req->getSchemeAndHttpHost();
	$redirect_urls = new \PayPal\Api\RedirectUrls();
	//$redirect_urls->setReturnUrl(URL::route('paypalsuccess'))
	//    ->setCancelUrl(URL::route('paypalcancel'));
	$redirect_urls->setReturnUrl($schemeandhost."/paypalsuccess?payamt=".$payamt."&lowresfilename=".$lowrespath)
	    ->setCancelUrl($schemeandhost."/paypalcancel?payamt=".$payamt."&lowresfilename=".$lowrespath);

	$payment = new \PayPal\Api\Payment();
	$payment->setIntent('Sale')
	    ->setPayer($payer)
	    ->setRedirectUrls($redirect_urls)
	    ->setTransactions(array($transaction));

	try{
	    $payment->create($this->_api_context);
	}
	catch(\PayPal\Exception\PPConnectionException $ex){
	    if (\Config::get('app.debug')) {
		\Session::put('error', 'Connection timeout');
		return Redirect::route('paypalpayment');
	    }
	    else{
		\Session::put('error', 'Some error occur, sorry for inconvenient');
		return Redirect::route('paypalpayment');
	    }
	}

	foreach ($payment->getLinks() as $link) {
	    if ($link->getRel() == 'approval_url') {
		$redirect_url = $link->getHref();
		break;
	    }
	}
	Session::put('paypal_payment_id', $payment->getId());
	if (isset($redirect_url)) {
	    return Redirect::away($redirect_url);
	}

	\Session::put('error', 'Unknown error occurred');
	return Redirect::route('paypalpayment');
    }


    public function paymentsuccess(Request $req){
	$payamt = $req->get('payamt');
	$lowrespath = $req->get('lowresfilename');
	// Validate the image file
        $recs = DB::table('images')->where([ ['price', '=', (float)$payamt], ['lowresfilename', '=', $lowrespath] ])->get();
        if(count($recs) == 0){
            $msg = "Invalid price and/or image specification";
            return($msg);
        }
        $imageid = $recs[0]->id;
        $ownerid = $recs[0]->userid;
        $origimgpath = $recs[0]->imagepath;
        $s = checksession();
        $userid = -1;
        // Get payment_id and assign it to tokenid.
        if($s){
            $sessionid = Session::getId();
            $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
            $userid = $session->userid;
        }
	else{
	    return("You need to login first before you can use the paypal session");
	}
	$userobj = DB::table('users')->where('id', '=', $userid)->first();
	if(!$userobj){
	    return("The user identified by the Id ".$userid." doesn't exist");
	}
	$customername = $userobj->firstname." ".$userobj->lastname;
	$addressline1 = "";
	$addressline2 = "";
	$city = "";
	$state = "";
	$country = "";
	$zipcode = "";
	$tokenid = "";
        $client_ip = get_client_ip();
        $details = json_decode(file_get_contents("http://ipinfo.io/{$client_ip}/json"), true);
        $geoloc = "";
        try{
            if(array_key_exists("city", $details)){
                $geoloc = $details['city'];
            }
        }
        catch(Exception $e){
        }
	$paymentsdata = array('imageid' => $imageid, 'amount' => $payamt, 'downloaded' => false, 'customername' => $customername, 'address' => $addressline1." ".$addressline2.", ".$city.", ".$state.", ".$country.", PIN Code: ".$zipcode, 'tokenid' => $tokenid, 'userid' => $userid);
        $paymentid = DB::table('payments')->insertGetId($paymentsdata);
        $hostname = $req->getHost();
        $hostportname = $req->getHttpHost();
        $rooturl = "http://".$hostportname;
        //$rooturl = "https://".$hostportname;
        $origimgpathparts = explode("users", $origimgpath);
        $origimgurl = "/image".$origimgpathparts[1];
        $downloadimageurl = $rooturl."/getimage?imgurl=".$origimgurl."&imgpath=".$origimgpath."&tokenid=".$tokenid;
        $mailcontent = "<a href='".$downloadimageurl."'>Download Image Here</a>";
        $maildata = array('name' => $hostname." admin", 'mailcontent' => $mailcontent);
        $subject = "Download Image Link";
        Mail::send('downloadlinkmail', $maildata, function ($mailcontent) use($emailid, $customername, $subject){
                   $mailcontent->to($emailid, $customername)->subject($subject);
                    $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
        });
        $hittime = date("Y-m-d H:i:s");
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $imghitsdata = array('imageid' => $imageid, 'owneruserid' => $ownerid, 'visitor' => $userid, 'ipaddress' => $client_ip, 'geolocation' => $geoloc, 'user_agent' => $useragent, 'hittime' => $hittime);
        DB::table('imagehits')->insert($imghitsdata);
        // 1. Add a record in transactions table with all appropriate values.
        $currency = "USD";
        $transactionrec = array('imgownerid' => $ownerid, 'buyerid' => $userid, 'paymentid' => $paymentid, 'amount' => $payamt, 'currency' => $currency);
        DB::table('transactions')->insert($transactionrec);
        // 2. Adjust 'fundstatus' table record for this user so that the user's finances on this website are correctly reflected.
        $fundstatusrecs = DB::table('fundstatus')->where('userid', $ownerid)->get();
        if(count($fundstatusrecs) > 0){
            $existing_amt = $fundstatusrecs[0]->accountbalance;
            $new_amt = $existing_amt + $payamt;
            DB::table('fundstatus')->where('userid', $ownerid)->update(array('accountbalance' => $new_amt));
        }
        else{
            $fundstatusrec = array('userid' => $ownerid, 'accountbalance' => $new_amt);
            DB::table('fundstatus')->insert($fundstatusrec);
        }
	return("Payment was successful");
    }


    public function paymentcancel(Request $req){
	// Handle the cancellation of the transaction - return appropriate message to confirm with the user.
	return("Payment was cancelled");
    }


    public function cardpaymentbystripe(Request $req){
	$imageprice = 0;
	$lowrespath = "";
	if(array_key_exists('img', $_GET)){
	    $lowresimg = $_GET['img'];
	    $lowresimgparts = explode("image", $lowresimg);
	    $basepath = "/var/www/html/imageweb/storage/users";
	    $lowrespath = $basepath.$lowresimgparts[1];
	    $recs = DB::table('images')->where('lowrespath', $lowrespath)->get();
	    if(count($recs) == 0){
		$msg = "Couldn't find image with the specification submitted";
	 	return($msg);
	    }
	    $imageprice  = $recs[0]->price;
	}
	else{
	    $msg = "Required parameter img missing";
	    return($msg);
	}
	return view('paymentstripe')->with(array('imageprice' => $imageprice, 'lowrespath' => $lowrespath));
    }


    public function makepaymentbystripe(Request $req){
	$validator = Validator::make($req->all(), ['card_no' => 'required', 
					'ccExpiryMonth' => 'required',
					'ccExpiryYear' => 'required',
					'cvvNumber' => 'required',
					 ]);
	$input = $req->all();
	if ($validator->passes()) {
	    $input = array_except($input,array('_token'));
	    $stripe = \Stripe::setApiKey(env('STRIPE_API_SECRET'));
	    $customername = $req->get('customername');
	    $emailid = $req->get('emailid');
	    $addressline1 = $req->get('addressline1');
	    $addressline2 = $req->get('addressline2');
	    $city = $req->get('city');
	    $country = $req->get('country');
	    $state = $req->get('state');
	    $zipcode = $req->get('zipcode');
	    $currency = $req->get('currency');
	    $cardnum = $req->get('card_no');
	    $cardvalidity = checkcardvalidity($cardnum);
	    //if(!$cardvalidity){
	    //	return("The card number entered by you is invalid");
	    //}
	    try {
		$token = $stripe->tokens()->create(['card' => ['number' => $req->get('card_no'), 'exp_month' => $req->get('ccExpiryMonth'), 'exp_year' => $req->get('ccExpiryYear'), 'cvc' => $req->get('cvvNumber'), ]]);
		if (!isset($token['id'])) {
		    return ("Token Id is not set");
		}
		$tokenid = $token['id'];
		$payamt = $req->get('payamt');
		$lowrespath = $req->get('lowrespath');
		// Validate the amount with the image
		$recs = DB::table('images')->where([ ['price', '=', $payamt], ['lowrespath', '=', $lowrespath] ])->get();
		if(count($recs) == 0){
		    $msg = "Invalid price and/or image specification";
		    return($msg);
		}
		$imageid = $recs[0]->id;
		$ownerid = $recs[0]->userid;
	 	$origimgpath = $recs[0]->imagepath;
		$s = checksession();
		$userid = -1;
		if($s){
		    $sessionid = Session::getId();
        	    $session = DB::table('sessions')->where('sessionid', $sessionid)->first();
		    $userid = $session->userid;
		}
		$client_ip = "";
        	$client_ip = get_client_ip();
        	$details = json_decode(file_get_contents("http://ipinfo.io/{$client_ip}/json"), true);
        	$geoloc = "";
        	try{
            	    if(array_key_exists("city", $details)){
                   	$geoloc = $details['city'];
            	    }
        	}
        	catch(Exception $e){
        	}
		$paymentsdata = array('imageid' => $imageid, 'amount' => $payamt, 'downloaded' => false, 'customername' => $customername, 'address' => $addressline1." ".$addressline2.", ".$city.", ".$state.", ".$country.", PIN Code: ".$zipcode, 'tokenid' => $tokenid, 'userid' => $userid);
		//$customer = $stripe->customers()->create(['name' => $customername, 'address' => ['line1' => $addressline1, 'line2' => $addressline2, 'city' => $city, 'country' => $country, 'state' => $state, 'postal_code' => $zipcode] ]);
		$customer = $stripe->customers()->create(['source' => $tokenid, 'name' => $customername, 'address' => ['line1' => $addressline1, 'line2' => $addressline2, 'city' => $city, 'country' => $country, 'state' => $state, 'postal_code' => $zipcode] ]);
		if(!$customer){
		    return("Could not create a customer object. Could not complete this transaction");
		}
		// Associate a source with the customer
		//\Stripe\Customer::createSource($customer['id'], ['source' => $tokenid]);
		$raterecs = DB::table('currencyrates')->where('currcode', $currency)->get();
		if(count($raterecs) == 0){
		    $currency = "USD";
		}
		else{
		    $rate = $raterecs[0]->numunitsperusd;
		    $payamt = $payamt * $rate;
		}
		$charge = $stripe->charges()->create(['currency' => $currency, 'amount' => $payamt, 'description' => 'image payment', 'customer' => $customer['id']]);
		//$charge = $stripe->charges()->create(['card' => $token['id'], 'currency' => 'USD', 'amount' => $payamt, 'description' => 'image payment', 'customer' => $customer['id']]);
		if($charge['status'] == 'succeeded') {
		    Session::flash('success', 'Payment successful!');
		    // Insert in payments table and add record in imagehits table.
		    $paymentid = DB::table('payments')->insertGetId($paymentsdata);
		    //echo "<pre>";
		    //print_r($charge);
		    // Download the image on buyers device 
		    $origimgpathparts = explode("users", $origimgpath);
		    $origimgurl = "/image".$origimgpathparts[1];
		    /*
		    header("Content-Description: File Transfer");
		    header("Content-Type: image/jpeg");
		    header("Content-Disposition: attachment; filename=\"".basename($origimgurl)."\"");
		    readfile($origimgpath);
		    DB::table('payments')->where('tokenid', $tokenid)->update(array('downloaded' => true));
		    */
		    $hostname = $req->getHost();
		    $hostportname = $req->getHttpHost();
		    $rooturl = "http://".$hostportname;
		    //$rooturl = "https://".$hostportname;
		    $downloadimageurl = $rooturl."/getimage?imgurl=".$origimgurl."&imgpath=".$origimgpath."&tokenid=".$tokenid;
		    $mailcontent = "<a href='".$downloadimageurl."'>Download Image Here</a>";
		    $maildata = array('name' => $hostname." admin", 'mailcontent' => $mailcontent);
		    $subject = "Download Image Link";
		    Mail::send('downloadlinkmail', $maildata, function ($mailcontent) use($emailid, $customername, $subject){
			$mailcontent->to($emailid, $customername)->subject($subject);
			$mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
		    });
		    $hittime = date("Y-m-d H:i:s");
            	    $useragent = $_SERVER['HTTP_USER_AGENT'];
		    $imghitsdata = array('imageid' => $imageid, 'owneruserid' => $ownerid, 'visitor' => $userid, 'ipaddress' => $client_ip, 'geolocation' => $geoloc, 'user_agent' => $useragent, 'hittime' => $hittime);
		    DB::table('imagehits')->insert($imghitsdata);
		    // 1. Add a record in transactions table with all appropriate values.
		    $transactionrec = array('imgownerid' => $ownerid, 'buyerid' => $userid, 'paymentid' => $paymentid, 'amount' => $payamt, 'currency' => $currency);
		    DB::table('transactions')->insert($transactionrec);
		    // 2. Adjust 'fundstatus' table record for this user so that the user's finances on this website are correctly reflected.
		    // Convert $payamt to USD
		    if($currency == 'USD'){
			$payamt = $payamt;
		    }
		    $raterec = DB::table('currencyrates')->where('currcode', $currency)->first();
		    $payamt_USD = $payamt/$raterec->numunitsperusd;
		    $fundstatusrecs = DB::table('fundstatus')->where('userid', $ownerid)->get();
		    if(count($fundstatusrecs) > 0){
			$existing_amt = $fundstatusrecs[0]->accountbalance;
			$new_amt = $existing_amt + (1 - env('COMMISSION_PERCENT')/100)*$payamt_USD;
			DB::table('fundstatus')->where('userid', $ownerid)->update(array('accountbalance' => $new_amt));
		    }
		    else{
			$new_amt = (1 - env('COMMISSION_PERCENT')/100)*$payamt_USD;
			$fundstatusrec = array('userid' => $ownerid, 'accountbalance' => $new_amt);
			DB::table('fundstatus')->insert($fundstatusrec);
		    }
		    $successmessage = 'payment successful. A link has been sent to the email you have specified. You may download the image by clicking on that link in the email.';
		    return view('stripestatus')->with(array('statusmessage' => $successmessage, 'status' => 'success'));
		}
		else{
		    \Session::put('error','Payment was not successful!!');
		    $failmessage = "payment was NOT successful";
		    return view('stripestatus')->with(array('statusmessage' => $failmessage, 'status' => 'fail'));
		}
	    }
	    catch(Exception $e){
		\Session::put('error',$e->getMessage());
		return view('stripestatus')->with(array('statusmessage' => $e->getMessage(), 'status' => 'fail'));
	    }
	    catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
		\Session::put('error',$e->getMessage());
		return view('stripestatus')->with(array('statusmessage' => $e->getMessage(), 'status' => 'fail'));
	    }
	    catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
		\Session::put('error',$e->getMessage());
		return view('stripestatus')->with(array('statusmessage' => $e->getMessage(), 'status' => 'fail'));
	    }
	}
    }

    function currencyrate(Request $req){
	$currname = $req->get('currname');
	$recs = DB::table('currencyrates')->where('currcode', $currname)->get();
	if(count($recs) == 0){
	    return (1);
	}
	$rate = $recs[0]->numunitsperusd;
	return($rate);
    }


    function getimage(Request $req){
	$s = checksession();
        if(!$s){
	    $message = "You are not logged in. Please login to download the image. The image will get downloaded once you login into your account";
	    $queryurl = $req->fullUrl();
	    return Redirect::to('login?url='.urlencode($queryurl))->withErrors([$message]);
        }
	$sessionid = Session::getId();
    	$sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
    	if(!$sessobj){
            return("Invalid session. Please login into the website and then try to download the image.");
    	}
    	$sessionstatus = $sessobj->sessionstatus;
    	if(!$sessionstatus){
            return("Invalid session status. Please login into the website and then try to download the image.");
    	}
    	$userid = $sessobj->userid;
	$origimgurl = $req->get('imgurl');
	$origimgpath = $req->get('imgpath');
	$tokenid = $req->get('tokenid');
	$recs2 = DB::table('payments')->where('tokenid', $tokenid)->get();
	if(count($recs2) == 0){
	    $message = "Could not find the given token. Please contact the support with the given token for further assistance. Token: ".$tokenid;
	    return($message);
	}
	$payuserid = $recs2[0]->userid;
	if($payuserid != $userid){
	    $message = "You are not logged in as the user who paid for the image";
	    return Redirect::to('login')->withErrors([$message]);
	}
	$currtime = date('Y-m-d H:i:s');
	$createdtime = $recs2[0]->created_at;
	// Add 72 hours to $createdtime
	$maxtime = date('Y-m-d H:i:s', strtotime($createdtime.' + 3 days'));
	if($currtime > $maxtime){
	    $message = "Your link to the image has been deactivated as 72 hours have passed since you paid for it. If you haven't been able to download the image as yet, please contact support at support@imageweb.com with the token Id ".$tokenid;
	    return($message);
	}
	header("Content-Description: File Transfer");
	header("Content-Type: image/jpeg");
	header("Content-Disposition: attachment; filename=\"".basename($origimgurl)."\"");
	readfile($origimgpath);
	DB::table('payments')->where('tokenid', $tokenid)->update(array('downloaded' => true));
	$referer = $req->header('HTTP_REFERER');
	preg_match('/login/', $referer, $matches);
	if(count($matches) > 0){
	    return Redirect::to('dashboard');
	}
    }


    function buylogin(Request $req){
        $s = checksession();
        if(!$s){
            $message = "You are not logged in. Please login to buy the image.";
            return Redirect::to('floatlogin')->withErrors([$message]);
        }
        $sessionid = Session::getId();
        $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
        if(!$sessobj){
            $message = "Invalid session. Please login again to buy the selected image";
	    return Redirect::to('floatlogin')->withErrors([$message]);
        }
        $sessionstatus = $sessobj->sessionstatus;
        if(!$sessionstatus){
            $message = "Invalid session status. Please login again to buy the selected image";
	    return Redirect::to('floatlogin')->withErrors([$message]);
        }
	return("1");
    }


    function floatlogin(Request $req){
	return view('floatlogin');
    }

    function dofloatlogin(Request $req){
	$rules = array(
      'username' => 'required|alphaNum|min:4', // make sure the email is an actual email
      'password' => 'required|alphaNum|min:8'
      );
      // checking all field
      $validator = Validator::make(Input::all() , $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails())
        {
        return Redirect::to('floatlogin')->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        }
        else
        {
        // create our user data for the authentication
        $username = $req->input('username');
        $password = $req->input('password');
	$lowresimgpath = $req->input('lowresimgpath');
        $hashedpassword = Hash::make($password);
        //$user = User::where('username', '=', $username);
        $user = DB::table('users')->where('username', $username)->first();
        if(Hash::check($password, $user->password)){
           if($user->verified){
               // Add session to sessions table
               if(!checksession()){
                   $req->session()->regenerate();
                   $sessionid = Session::getId();
                   $userid = $user->id;
                   $starttime = date("Y-m-d H:i:s");
                   $sessdata = array('sessionid' => $sessionid, 'userid' => $userid, 'starttime' => $starttime);
                   DB::table('sessions')->insert($sessdata);
               }
	       $message = "<br>Select your payment option below:<div><br><a href='#_' onclick='javascript:paypal(\"".$lowresimgpath."\");' style='color:#0000AA;font-weight:bold;'>Pay&nbsp;With&nbsp;PayPal</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:stripe(\"".$lowresimgpath."\");' style='color:#0000AA;font-weight:bold;'>Pay&nbsp;With&nbsp;Card</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='#_' onclick='javascript:closescreen();' style='color:#0000AA;font-weight:bold;'>Close&nbsp;Screen</a><br/></div><div id='pgdiv' style='display:none;'></div>";
               return ($message);
           }
        }
        return Redirect::to('floatlogin')->withErrors(['The username or password was incorrect']);
      }

    }

    function showwithdrawscreen(Request $req){
	$s = checksession();
        if(!$s){
            $message = "You are not logged in. Please login to withdraw your funds.";
            $queryurl = $req->fullUrl();
            return Redirect::to('login?url='.urlencode($queryurl))->withErrors([$message]);
        }
        $sessionid = Session::getId();
        $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
        if(!$sessobj){
            return("Invalid session. Please login into the website and then try to download the image.");
        }
        $sessionstatus = $sessobj->sessionstatus;
        if(!$sessionstatus){
            return("Invalid session status. Please login into the website and then try to download the image.");
        }
	$userid = $sessobj->userid;
	$userobj = DB::table('users')->where('id', $userid)->first();
	$firstname = $userobj->firstname;
	$lastname = $userobj->lastname;
	$username = $userobj->username;
	$emailid = $userobj->email;
        $user = DB::table('users')->where('id', $userid)->first();
        $usertype = $user->usertype;
        $profileimagepath = getprofileimage($username);
	$bankaccts = array();
	$bankaccountqset = DB::table('bankaccount')->where('userid', $userid)->get();
	for($i=0; $i < count($bankaccountqset); $i++){
	    $bankaccountobj = $bankaccountqset[$i];
	    $acctname = $bankaccountobj->accountname;
	    $holdername = $bankaccountobj->holdername;
	    $bankname = $bankaccountobj->bankname;
	    $branchname = $bankaccountobj->branchname;
	    $bankcode = $bankaccountobj->bankcode;
	    $acctnumber = $bankaccountobj->accountnumber;
	    $bankaccts[$acctname] = array('holdername' => $holdername, 'bankname' => $bankname, 'branchname' => $branchname, 'bankcode' => $bankcode, 'accountnumber' => $acctnumber);
	}
	$balancerec = DB::table('fundstatus')->where('userid', $userid)->first();
	$balanceamt = 0.00;
	if($balancerec){
	    $balanceamt = $balancerec->accountbalance;
	}
	return view('withdrawscreen')->with(array('bankaccts' => $bankaccts, 'firstname' => $firstname, 'lastname' => $lastname, 'username'=> $username, 'emailid' => $emailid, 'balanceamount' => $balanceamt, 'userid' => $userid, 'usertype' => $usertype, 'profileimage' => $profileimagepath ));
    }


    function maketransfer(Request $req){
        $s = checksession();
        if(!$s){
            $message = "You are not logged in. Please login to do financial transactions.";
            $queryurl = $req->fullUrl();
            return Redirect::to('login?url='.urlencode($queryurl))->withErrors([$message]);
        }
        $sessionid = Session::getId();
        $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
        if(!$sessobj){
            return("Invalid session. Please login into the website and then try to do financial transactions.");
        }
        $sessionstatus = $sessobj->sessionstatus;
        if(!$sessionstatus){
            return("Invalid session status. Please login into the website and then try to do financial transactions.");
        }
        $userid = $sessobj->userid;
	$userobj = DB::table('users')->where('id', $userid)->first();
	// Get POST input data
	$firstname = $req->input('first_name');
	$lastname = $req->input('last_name');
	$emailid = $req->input('emailid');
	$amount = $req->input('amount_transfer');
	$bankaccount = $req->input('bank_account');
	$newbankaccount = $req->input('new_bank_account');
	$acctnumber = $req->input('acct_number');
	$bankname = $req->input('bank_name');
	$bankbranch = $req->input('bank_branch');
	$branchcode = $req->input('branch_id_code');
	$countryname = $req->input('country');
	// Now we have got all values. So we start the transfer if the amount is less than or equal to the amount in the fundstatus table
	$fundrec = DB::table('fundstatus')->where('userid', $userid)->first();
	if(!$fundrec || $fundrec->accountbalance == 0){ // The user doesn't seem to have any funds. So we create the bank account if it doesn't exist and return.
	    if(!$newbankaccount){
		return("No funds to withdraw");
	    }
	    else{
	    	$acctrec = array('userid' => $userid, 'bankname' => $bankname, 'branchname'	=> $bankbranch, 'bankcode' => $branchcode, 'holdername' => $firstname." ".$lastname, 'accountname' => $newbankaccount, 'accountnumber' => $acctnumber);
	    	// Check if an account with the same account number exists
	    	$acctrecs = DB::table('bankaccount')->where('accountnumber', $acctnumber)->get();
	    	if(count($acctrecs) > 0){
		    return("An account with the same account number exists. Please provide an alternate account number and try again!");
		}
		DB::table('bankaccount')->insert($acctrec);
	    } 
	}
	else if($amount > $fundrec->accountbalance){
	    if($newbankaccount != ""){
	        $acctrec = array('userid' => $userid, 'bankname' => $bankname, 'branchname'     => $bankbranch, 'bankcode' => $branchcode, 'holdername' => $firstname." ".$lastname, 'accountname' => $newbankaccount, 'accountnumber' => $acctnumber);
                // Check if an account with the same account number exists
                $acctrecs = DB::table('bankaccount')->where('accountnumber', $acctnumber)->get();
                if(count($acctrecs) > 0){
                    return("An account with the same account number exists. Please provide an alternate account number and try again!");
                }
                DB::table('bankaccount')->insert($acctrec);
	    }
	    return("Amount requested is greater than the balance amount you have. Please enter an appropriate value for your amount and try again");
	}
	else{
	    if($newbankaccount != ""){
            	$acctrec = array('userid' => $userid, 'bankname' => $bankname, 'branchname'     => $bankbranch, 'bankcode' => $branchcode, 'holdername' => $firstname." ".$lastname, 'accountname' => $newbankaccount, 'accountnumber' => $acctnumber);
            	// Check if an account with the same account number exists
            	$acctrecs = DB::table('bankaccount')->where('accountnumber', $acctnumber)->get();
            	if(count($acctrecs) > 0){
                    return("An account with the same account number exists. Please provide an alternate account number and try again!");
            	}
            	$acctid = DB::table('bankaccount')->insertGetId($acctrec);
            }
	    else{
		$acctrec = DB::table('bankaccount')->where([['accountnumber', '=', $acctnumber], ['userid', '=', $userid]])->first();
		$acctid = $acctrec->id;
	    }

	    // 1. Make transfer through razorpay
	    // 2. Add a record in 'transactions' table with all the required fields.
	    $transactionrec = array('imgownerid' => $userid, 'buyerid' => $userid, paymentid => NULL, 'amount' => $amount, 'currency' => 'USD', 'accountid' => $acctid, 'trx_type' => 'c'); // imgownerid is incorrectly set to $userid so that the foreign key constraint is satisfied.
	    DB::table('transactions')->insert($transactionrec);
	    // 3. Update 'fundstatus' table to reflect the status of the user's finances on this website. 
	    $fundstatusrec = DB::table('fundstatus')->where('userid', $userid)->first();
	    if($fundstatusrec){
		$acctbalance = $fundstatusrec->accountbalance - $amount;
		DB::table('fundstatus')->where('userid', $userid)->update(array('accountbalance' => $acctbalance));
	    }
	    else{
	   	return("Cannot withdraw funds - No funds available for withdrawal"); 
	    }
	}
	return("Transfer completed successfully");
    }


    function withdrawpaypal(Request $req){
	$s = checksession();
        if(!$s){
            $message = "You are not logged in. Please login to do financial transactions.";
            $queryurl = $req->fullUrl();
            return Redirect::to('login?url='.urlencode($queryurl))->withErrors([$message]);
        }
        $sessionid = Session::getId();
        $sessobj = DB::table('sessions')->where('sessionid', $sessionid)->first();
        if(!$sessobj){
            return("Invalid session. Please login into the website and then try to do financial transactions.");
        }
        $sessionstatus = $sessobj->sessionstatus;
        if(!$sessionstatus){
            return("Invalid session status. Please login into the website and then try to do financial transactions.");
        }
        $userid = $sessobj->userid;
        $userobj = DB::table('users')->where('id', $userid)->first();
	$paypaluserid = $req->input('paypalacctid');
	$withdrawamount = $req->input('withdraw_amount');
	$retval = paypalwithdrawal($withdrawamount, $paypaluserid);
	if((int)$retval == 1){
	    // Update pgsql tables.
	    // 1. Add a record in transactions table with all appropriate values.
	    $transactionrec = array('imgownerid' => $userid, 'buyerid' => $userid, 'paymentid' => NULL, 'amount' => $withdrawamount, 'currency' => 'USD', 'trx_type' => 'c'); // imgownerid is incorrectly set to $userid so that the foreign key constraint is satisfied.
	    DB::table('transactions')->insert($transactionrec);
	    $fundstatusrecs = DB::table('fundstatus')->where('userid', $userid)->get();
	    if(count($fundstatusrecs) > 0){
	        $existing_amt = $fundstatusrecs[0]->accountbalance;
	 	if($existing_amt < $withdrawamount){
		    return("Cannot withdraw funds - This account does not contain sufficient funds.");
		}
		$new_amt = $existing_amt - $withdrawamount;
		DB::table('fundstatus')->where('userid', $userid)->update(array('accountbalance' => $new_amt));
	    }
	    else{
                return("Cannot withdraw funds - No funds available for withdrawal");
            }
	    return("Transfer completed successfully");
	}
	return("Error occurred during transaction");
    }

}






