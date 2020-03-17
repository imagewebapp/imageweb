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
                $imagedata = array('imagepath' => $newfilepath, 'userid' => $userid, 'imagefilename' => $imagefilename, 'resolution' => $imres, 'verified' => 0, 'lowrespath' => $lowresimgpath, 'lowresfilename' => $lowresfilename, 'iconpath' => $iconpath, 'iconfilename' => $iconfilename, 'imagetags' => $imagetags, 'premium' => 0, 'categories' => $categories);
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

    /*
	Display gallery of images. Note: Session is not required for this page.
    */
    public function showgallery(Request $req){
        //$s = checksession();
        //if(!$s){
        //    return view('login');
        //}
        $startpoint = $req->input('startpoint') || 0;
        $chunksize = 20;
	$mode = $req->input('mode') || 'all';
	$tags = $req->input('tags') || '';
	if($mode == 'all' || $mode == ''){
            //$images = DB::table('images')->where('verified', '1')->orderBy('uploadts', 'DESC')->skip($startpoint)->take($chunksize)->get();
            $images = DB::table('images')->where('verified', '1')->orderBy('uploadts', 'DESC')->get();
            $totalcount = DB::table('images')->where('verified', '1')->count();
	}
	/*
	elseif($mode == 'popularity'){
	    $hits = DB::table('imagehits')->groupBy('imageid')->select('imageid', DB::raw('count(*) as hitcount))->get();
	    $images = [];
	    for($i=0; $i < count($hits); $i++){
		$hit = $hits[$i];
		$imgid = $hit->imageid;
		$img = DB::table('images')->where('id', $imgid)->first();
		array_push($images, $img);
	    }
	    $totalcount = count($hits);
	}
	elseif($mode == 'tags'){
	    $alltags = explode(",", $tags);
	    for($i=0; $i < count($alltags); $i++){ 
		$tag = $alltags[$i];
	        $imgs = DB::table('images')->where('imagetags', 'like', '%'.$tag.'%')->get();
		array_push($images, $imgs);
	    }
	    $totalcount = count($images);
	}
	*/
        $startpoint = $startpoint + $chunksize;
        $username = getuser();
        $profileimagepath = "";
        if($username != ""){
	    $profileimagepath = getprofileimage($username);
        }
	return view('gallery')->with(array('images' => $images, 'totalcount' => $totalcount, 'chunksize' => $chunksize, 'startpoint' => $startpoint, 'username' => $username, 'profileimage' => $profileimagepath));
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
        $hittime = date("Y-m-d H:i:s");
        $hitdata = array('imageid' => $imageid, 'owneruserid' => $ownerid, 'visitor' => $visitor, 'hittime' => $hittime);
        DB::table('imagehits')->insert($hitdata);
        $response = Response::make("Thanks for downloading", 200);
        $response->header("Content-Type", "Text/Plain");
        return $response;
    }


    /*
        Allow the legitimate owner to update the image.
    */
    public function update(Request $req){

    }


    /*
        Allow owner user to destroy the image
    */
    public function destroy(Request $req){

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
        return view('verifyimagesiface')->with(array('imagesdict' => $imagesdict, 'username' => $username, 'profileimage' => $profileimagepath));
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
        for($i=0; $i < count($imgverifylist); $i++){
            DB::table('images')->where('id', $imgverifylist[$i])->update(array('verified' => 1)); 
        }
        return "All checked images has been verified successfully. You should now be able to view them in the 'Gallery' page.";
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

}






