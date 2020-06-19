function searchgallery2(){
    tags = document.getElementById('tagslist2').value;
    document.frmsearch2.action = "/gallery?mode=tags";
    if(tags != ""){
        document.frmsearch2.action += "&tags=" + tags;
    }
    //alert(document.frmsearch2.action);
    document.frmsearch2.method='GET';
    document.frmsearch2.submit();
}

