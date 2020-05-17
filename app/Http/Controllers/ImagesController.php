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

use App\Validators\ReCaptcha;

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
    $im = imagecreatefromany($imagefile);
    switch($imtype){
        case 1:
            imagegif($im, $lowresimagefile, 75);
            break;
        case 2:
            imagejpeg($im, $lowresimagefile, 75);
            break;
        case 3:
            imagepng($im, $lowresimagefile, 75);
            break;
        case 6:
            imagewbmp($im, $lowresimagefile, 75);
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


class ImagesController extends BaseController
{

    /*
        List the resource
    */
    public function index(){

    }


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
		$r = isduplicateimage($username, $tempfilename);
		//$r = isduplicateimage2($userid, $tempfilename);
		if($r){
		    return "This is a duplicate image. This image cannot be uploaded.";
		}
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
	$delta = $currtime - $changepassrec->codegenerationts;
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
        $chunksize = 20;
        $totalcount = 0; //initialize totalcount here.
	$mode = $req->input('selmode');
        if($mode == ""){
	    $mode = "all";
	}
	$tags = $req->input('tagslist');
	$imagesrecs = [];
	if($mode == 'all' || $mode == ''){
            $imagesrecs = DB::table('images')->where('verified', 1)->orderBy('uploadts', 'DESC')->skip($startpoint)->take($chunksize)->get();
            //$imagesrecs = DB::table('images')->where('verified', 1)->orderBy('uploadts', 'DESC')->get();
            $totalcount = DB::table('images')->where('verified', 1)->count();
	}
	elseif($mode == 'popularity'){
	    //$hits = DB::table('imagehits')->groupBy('imageid')->select('imageid', DB::raw('count(*) as hitcount'))->get();
	    $hits = DB::table('imagehits')->select('imageid', DB::raw('count(*) as hitcount'))->groupBy('imageid')->orderBy('hitcount', 'desc')->skip($startpoint)->take($chunksize)->get();
	    for($i=0; $i < count($hits); $i++){
		$hit = $hits[$i];
		$imgid = $hit->imageid;
		$img = DB::table('images')->where('id', $imgid)->first();
		array_push($imagesrecs, $img);
	    }
	    $totalcount = count($hits);
	}
	elseif($mode == 'tags'){
	    $alltags = explode(",", $tags);
	    for($i=0; $i < count($alltags); $i++){ 
		$tag = $alltags[$i];
	        $imgs = DB::table('images')->where([ ['verified', '=', '1'], ['imagetags', 'like', '%'.$tag.'%'] ])->skip($startpoint)->take($chunksize)->get();
		for($c=0; $c < count($imgs); $c++){
		    $img = $imgs[$c];
		    array_push($imagesrecs, $img);
		}
	    }
	    $totalcount = count($imagesrecs);
	}
	
        $startpoint = $startpoint + $chunksize;
        $username = getuser();
        $profileimagepath = "";
        if($username != ""){
	    $profileimagepath = getprofileimage($username);
        }
	return view('gallery')->with(array('images' => $imagesrecs, 'totalcount' => $totalcount, 'chunksize' => $chunksize, 'startpoint' => $startpoint, 'username' => $username, 'profileimage' => $profileimagepath));
    }

    
    public function displayimage($username, $filename){
        $path = storage_path('users/'.$username."/".$filename);
        if (!File::exists($path)) {
            return "file doesn't exist";
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
        $image = DB::table('images')->where([ ['userid', '=', $ownerid], ['lowresfilename', '=', $lowresimagefilename] ])->first();
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
	$imagerecord = DB::table('images')->where('lowresfilename', $imgfilename)->first();
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
	    $imagerecs = DB::table('images')->where([ ['categories', 'like', '%'.$catslist[$c].'%'], ['verified', '=', '1'] ])->take(20)->get();
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
	DB::delete('delete from imagehits where imageid=?', [$imgid]);
	DB::delete('delete from images where id=?',[$imgid]);
	unlink($imagepath);
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
               return Redirect::to('dashboard');
           } 
        }        
        return Redirect::to('login');
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
          'confirmpassword' => 'required|alphaNum|min:8|same:password'
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
        $images = DB::table('images')->where('userid', $userid)->orderBy('uploadts', 'DESC')->skip($start)->take($chunksize)->get();
        $max = DB::table('images')->where('userid', $userid)->count();
        $start = $start + $chunksize;
        $categories = DB::table('categories')->get();
        $username = getuser();
        $profileimagepath = getprofileimage($username);
        return view('dashboard')->with(array('images' => $images, 'categories' => $categories, 'usertype' => $usertype, 'start' => $start, 'max' => $max, 'chunk' => $chunksize, 'username' => $username, 'profileimage' => $profileimagepath ));
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
        $images = DB::table('images')->where('verified', 0)->get();
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
            $imagesdict[$imgwebpath] = $imgid;
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
	    Images with the following IDs have been accepted.\n";
	$mailcontent .= implode("\n", $accepted);
	$mailcontent .= "\n\nThe following images (IDs) have been rejected.\n";
	$mailcontent .= implode("\n", $rejected);
	$mailcontent .= "\n\nThanks and Regards,
		Admin";
	$subject = "Image Verification";
	$firstname = $user->firstname;
	$lastname = $user->lastname;
	$maildata = array('name' => "imagewebapp admin", 'mailcontent' => $mailcontent);
	Mail::send('verify', $maildata, function ($mailcontent) use($emailid, $firstname, $lastname, $subject){
  	  $mailcontent->to($emailid, $firstname." ".$lastname)->subject($subject);
  	  $mailcontent->from('supmit2k3@yahoo.com', 'imageweb admin');
	});
	$images = DB::table('images')->where('verified', 0)->get();
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
            $imagesdict[$imgwebpath] = $imgid;
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

}






