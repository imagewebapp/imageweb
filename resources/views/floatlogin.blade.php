<form name='frmlogin' method='POST' action='/floatlogin'>
<div class="log-form">
<h2 style="color:blue;padding-left:15px;">Login to your account</h2>
<!-- if there are login errors, show them here -->
<?php
if(Session::has('activation')){
 echo "<div style='color:0000AA;padding-left:20px;'>".Session::get("activation")."</div>";
}       
?>
<p style="color:blue;padding-left:20px;">
 {{ $errors->first('username') }}
 {{ $errors->first('password') }}
</p>
<p style="color:blue;padding-left:20px;">
@if($errors->any())
<p style="color:red;">{{$errors->first()}}</p>
@endif
 <input type='text' name='username' value='' placeholder='username' title='username'>
 
</p>
<p style="color:blue;padding-left:20px;">
 
 <input type='password' name='password' value='' placeholder='password' title='password'>
</p>
<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type='hidden' name='lowresimgpath' value="LOWRESIMGPATH">
<p style="color:blue;padding-left:20px;"><input type='button' name='btngo' value='Login' onClick='javascript:dologin();'></p>
</div>
</form>


