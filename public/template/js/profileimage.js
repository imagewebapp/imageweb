function showprofileimagescreen(){
    profileimguploaddiv = document.getElementById('profileimagediv');
    profileimguploaddiv.style.display = "";
}

function closeuploadform(){
    profileimguploaddiv = document.getElementById('profileimagediv');
    profileimguploaddiv.style.display = "none";
}

function uploadprofileimage(){
    var xmlhttp;
    statusdiv = document.getElementById('profstatus');
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }
    else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status==200){
	    window.location.reload(true);
        }
    }
    var file = document.getElementById('uploadfile').files[0];
    formdata = new FormData();
    formdata.append("uploadfile", file);
    csrftoken = document.frmprofimg._token.value;
    formdata.append("_token", csrftoken);
    xmlhttp.open('POST', "/changeprofileimage", true);
    xmlhttp.send(formdata);
    statusdiv.innerHTML = "<img src='/images/loading_small.gif'>";
}

