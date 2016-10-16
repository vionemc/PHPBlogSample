function searching(filter, key){
    if (key!=""){
        window.location="search.php?filter="+filter+"&key="+key;
    }else{
        alert("Masukkan keyword untuk pencarian!");
    }
}
//---------------fungsi achievement---------------------------
function achieve(username, type){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
//            alert('type :'+type);
//            alert('xmlhttp.responseText : '+xmlhttp.responseText);
            var res = xmlhttp.responseText; 			
            if (type==="comment"){				
                if(xmlhttp.responseText==="comment1"){
                    alert('Selamat! Anda mendapat Achievement \'Newbie Commentator\' !');
                }          
                else if(xmlhttp.responseText==="comment20"){
                    alert('Selamat! Anda mendapat Achievement \'Commentator\' !');
                }
            }
        }
    }
    xmlhttp.open("GET","php/achieve.php?username="+username+"&type="+type);
    xmlhttp.send();                
}
function achieve1(username, type, redirect){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var res = xmlhttp.responseText; 
            if (type==="post"){                
                if(res==="post1"){
                    alert('Selamat! Anda mendapat Achievement \'First Post\' !');
                }          
                else if(res==="post20"){
                    alert('Selamat! Anda mendapat Achievement \'Future Journalist\' !');
                }
                window.location = "content.php?idpost="+redirect;                
            }
        }
    }
    xmlhttp.open("GET","php/achieve.php?username="+username+"&type="+type);
    xmlhttp.send();                
}
//----------------------------------------------------------
function changeTheme1() {
    document.getElementById('css-tampilan').setAttribute('href', 'css/style.css');
    document.getElementById('header2').setAttribute('style', 'display:none;');
    document.getElementById('header1').removeAttribute('style');
    
}

function changeTheme2() {
    document.getElementById('css-tampilan').setAttribute('href', 'css/style2.css');
    document.getElementById('header1').setAttribute('style', 'display:none;');
    document.getElementById('header2').removeAttribute('style');
    
}

function refreshContentList(){
    var sort = document.getElementById('sort').value;
    var tags = document.getElementById('tagsFilter').value;
    tags = replaceAll(tags,' ','');
    var tempTags = tags;
    tempTags = replaceAll(tempTags,',','');
    if(tempTags===""){
        window.location="content_list.php?sort="+sort;
    }else{
        window.location="content_list.php?sort="+sort+"&tags="+tags;        
    }    
}

function refreshCLAjax(mode){
    var sort = document.getElementById('sort').value;
    var tags; 
    if(mode===1){
        tags = document.getElementById('currFilter').innerHTML;
        tags = replaceAll(tags,' ','');
        tags = replaceAll(tags,'\n','');        
        if(tags==="No-Filter"){
            tags="";
        }
    }
    else if(mode===2){
        tags = document.getElementById('tagsFilter').value;        
    }else{
        tags=mode;
    }
    tags = replaceAll(tags,' ','');
    var tempTags = tags;
    tempTags = replaceAll(tempTags,',','');    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("content_list").innerHTML = xmlhttp.responseText;
        }
    }
    if(tempTags===""){        
        xmlhttp.open("GET","php/refreshCL.php?sort="+sort);        
    }else{
        xmlhttp.open("GET","php/refreshCL.php?sort="+sort+"&tags="+tags);                
    }        
    xmlhttp.send();                
}

function changeStatLike(idLike,statLike1){
    var statLike = document.getElementById(idLike);
    statLike.innerHTML = statLike1;
}
function validate() {//untuk validasi form
    //id elemen di formnya tolong sesuaikan
    var Username = document.getElementById('username').value;                
    var Password = document.getElementById('password').value;
    var CPassword = document.getElementById('cPassword').value;
    var NamaL = document.getElementById('namaL').value;
    var Tgl = document.getElementById('tgl').value;
    var Image = document.getElementById('inputAvatar').value;
    var Email = document.getElementById('email').value;
    var Gender = document.getElementById('gender').value;

    //validasi username
    if (Username == "") {
        document.getElementById('notifUsername').innerHTML = 'Username tidak boleh kosong';
        return false;
    } else if (Username.length < 5) {
        document.getElementById('notifUsername').innerHTML = 'Masukkan username dengan panjang min 5 karakter!';
        return false;
    }
                    
    document.getElementById('notifUsername').innerHTML = '';
                    
    if (!validateFormat(Email, "^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$")) {
        document.getElementById('notifEmail').innerHTML = 'Masukkan email yang valid';
        return false;
    }
                    
    document.getElementById('notifEmail').innerHTML = '';
                    
    if (Username === Password) {
        document.getElementById('notifPassword').innerHTML = 'Username dan password tidak boleh sama!';                        
        return false;
    }

    //validasi password
    if (Password.length < 8) {
        document.getElementById('notifPassword').innerHTML = 'Masukkan password dengan panjang min 8 karakter!';
        return false;
    }

    if (Password === Email) {
        document.getElementById('notifPassword').innerHTML = 'Email dan password tidak boleh sama!';
        return false;
    }

    document.getElementById('notifPassword').innerHTML = '';

    //validasi confirm password
    if (Password != CPassword) {
        document.getElementById('notifCPassword').innerHTML = 'Password dan confirm password harus sama!';
        return false;
    }
                    
    document.getElementById('notifCPassword').innerHTML = '';

    //validasi nama lengkap
    if (!validateFormat(NamaL, "[a-zA-Z']\\s[a-zA-Z']")) {
        document.getElementById('notifNama').innerHTML = 'Masukkan Nama Lengkap Anda';
        return false;
    }

    document.getElementById('notifNama').innerHTML = '';

    //validasi tanggal lahir				
    if (!validateFormat(Tgl, "^[0-9][0-9][0-9][0-9][-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$")) {
        document.getElementById('notifTanggal').innerHTML = 'Tanggal lahir harus valid dan berformat yyyy-mm-dd!';
        return false;
    }
                    
    document.getElementById('notifTanggal').innerHTML =  '';

    if (!validateFormat(Image, "(.*?)\.(jpg|jpeg)$")) {
        document.getElementById('notifAvatar').innerHTML = 'Masukkan file jpg atau jpeg';
        return false;
    }
                    
    document.getElementById('notifAvatar').innerHTML = '';
                    
    //validasi gender
    if (Gender === "Pilih Gender") {
        document.getElementById('notifGender').innerHTML = 'Pilih Salah Satu Gender';
        return false;
    }				

    document.getElementById('notifGender').innerHTML = '';

    document.getElementById('submitRegister').removeAttribute('disabled');
    return true;
}
	
function redirectSave() {
    window.location = "content_list.php"
}


// fungsi dasar
//fungsi regex
function validateFormat(word, regex){//untuk validasi format
    //cuman fungsi pendukung validasi registrasi, jadi santai lah
    var re = new RegExp(regex);
    if (word.match(re)) {
        return true;
    } 
    return false;			  
}
			
//fungsi untuk halaman konten

function signIn(username,pass){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var res = xmlhttp.responseText; 
            if(xmlhttp.responseText==="failed"){
                alert('Username/Password salah! '); 
            }          
            else if(xmlhttp.responseText==="success"){
                window.location="profile.php?username="+username;                                
            }
        }
    }
    xmlhttp.open("GET","php/login.php?username="+username+"&password="+pass);
    xmlhttp.send();                
}

function deleteComment(idpost,username,waktu){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var isiHal = document.getElementById('container_main');
            isiHal.innerHTML = xmlhttp.responseText;            
        //            alert('*'+xmlhttp.responseText+'*');                                
        //            window.location = "content.php?idpost="+idpost;
        }
    }
    xmlhttp.open("GET","php/deleteKomen.php?idpost="+idpost+"&username="+username+"&waktu="+waktu);
    xmlhttp.send();                
}

//fungsi utama
function Comment(komen, target, username, idpost, avatarPath){//fungsi buat komen di konten
    //komen : value dari textarea Komentar
    //target : tempat menyimpan komen
    var TempHTML = target;
    var K = komen.replace(/\n\r?/g, '<br />');
    K = replaceAll(K,'&','*');        
    K = replaceAll(K,'\'','\"');
    var isiKomen=
    "	<h3 style='font-style:italic;'>"
    +   "<a href='profile.php?username="+username+"'>"+username+"</a>"
    +"  </h3>"
    +"  <image src='"+avatarPath+"' height='50px' width='50px'>"
    +"	<div>"+K+"</div>";

    //    var isiKomen1="<div class='container_full'>"
    //    +"	<h3 style='font-style:italic;'>"
    //    +   "<a href='profile.php?username="+username+"'>"+username+" "+idpost+"</a>"
    //    +"  </h3>"
    //    +"  <image src='"+avatarPath+"' height='50px' width='50px'>"
    //    +"	<h6 style='font-style:italic;'>"+ThisTime()+"</h6>"
    //    +"	<div>"+komen.replace(/\n\r?/g, '<br />')+"</div>"
    //    +"  </div>"+TempHTML.innerHTML;		
    //    target.innerHTML = isiKomen1;
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var isiHal = document.getElementById('container_main');
            isiHal.innerHTML = xmlhttp.responseText;
            achieve(username, "comment");
        //            alert('*'+xmlhttp.responseText+'*');                                
        //            window.location = "content.php?idpost="+idpost;
        }
    }
    xmlhttp.open("GET","php/updateKomen.php?idpost="+idpost+"&username="+username+"&isi="+isiKomen+"&waktu="+ThisTime());
    xmlhttp.send();            
}

function diffTime(early, later){
    //format YYYY-MM-DD HH:II:SS
    //       0123456789012345678
    var YYYY = early.substring(0,4);
    var ZZZZ = later.substring(0,4);   
    var MM = early.substring(5,7);
    var NN = later.substring(5,7);       
    var DD = early.substring(8,10);
    var EE = later.substring(8,10);
    var h1 = early.substring(11,13);
    var h2 = later.substring(11,13);           
    var m1 = early.substring(14,16);
    var m2 = later.substring(14,16);
    var s1 = early.substring(17);
    var s2 = later.substring(17);               
    var t1 = new Date(YYYY, MM, DD, h1, m1, s1, "0")
    var t2 = new Date(ZZZZ, NN, EE, h2, m2, s2, "0")
    var diff = t2.getTime() - t1.getTime()

    if (diff >= 0 && diff <= 60) {
        return ((Math.floor(diff))+" seconds");
    }
    else if (diff > 60 && diff <= 3600) {
        return ((Math.floor(diff/60))+" minutes");
    }
    else if (diff > 3600 && diff <= 86400) {
        return ((Math.floor(diff/3600))+" hours");
    }
    else if (diff > 86400) {
        return ((Math.floor(diff/86400))+" days");
    }                        
}

//fungsi dasar
function WriteTime(){//fungsi untuk menulis waktu saat ini
    document.write(ThisTime());
}
function ThisTime(){//fungsi untuk mereturn waktu saat ini
    var now=new Date();
    var H = now.getHours();
    var M = now.getMinutes();
    var S = now.getSeconds();
    var HH;
    var MM;
    var SS;
    var NMonth = now.getMonth()+1;
    var NDate = now.getDate();
    if (NMonth<10){
        NMonth = "0"+NMonth;
    }
    if (NDate<10){
        NDate = "0"+NDate;
    }
    if (H<10){
        HH = "0"+H;
    }
    else {
        HH = H;
    }
    if (M<10){
        MM = "0"+M;
    }
    else {
        MM = M;
    }
    if (S<10){
        SS = "0"+S;
    }
    else {
        SS = S;
    }    
    return now.getFullYear()+"-"+NMonth+"-"+NDate+" "+HH+":"+MM+":"+SS;
}

//fungsi umum	
function Randomize(target, minV, maxV){//untuk randomize jumlah like saat pertama membuka website
    //target : label yang innerHTMLnya akan diubah dengan fungsi ini. misal document.getElementById('like')
    //minV : nilai integer minimum yang boleh dihasilkan
    //maxV : nilai integer maksimum yang boleh dihasilkan
    target.innerHTML = Math.floor(Math.random() * (maxV - minV + 1)) + minV;		
}
	
function Like(button, target){//untuk like/dislike
    //button : button yang diklik untuk like/dislike
    //target : label yang innerHTMLnya akan diubah dengan fungsi ini. misal document.getElementById('like')
    var Likes = parseInt(target.innerHTML);
    if (button.value === "Like" && Likes<50000) {
        target.innerHTML++;
        button.disabled = true;
    } else if (button.value === "Dislike" && Likes>-50000){
        target.innerHTML--;
        button.disabled = true;
    }
}

function LikeThis(buttonID, targetID, idpost){//untuk like/dislike
    //button : button yang diklik untuk like/dislike
    //target : label yang innerHTMLnya akan diubah dengan fungsi ini. misal document.getElementById('like')
    var button = document.getElementById(buttonID);
    var stat = document.getElementById("stat_like_"+targetID);
    if (button.className === "like") {
        var target = document.getElementById("like_"+targetID);		        
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText==="failed"){
                    alert("Silakan login dulu untuk like/dislike post");
                }
                else if(xmlhttp.responseText==="success"){
                    target.innerHTML++;
                    button.setAttribute("class","unlike");	
                    var hateButton = document.getElementById(buttonID.replace("like","hate"));	
                    hateButton.style.visibility='hidden';		
                    stat.innerHTML = "You like this";	                    
                }               
                else {
//                    alert(xmlhttp.responseText);
                }                
            }
        }
        xmlhttp.open("GET","php/updateLike.php?idpost="+idpost+"&tipe=like&count="+(parseInt(target.innerHTML)+1));
        xmlhttp.send();                                                       
    } else if (button.className === "hate"){
        var target = document.getElementById("hate_"+targetID);			        
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText==="failed"){
                    alert("Silakan login dulu untuk like/dislike post");
                }
                else if(xmlhttp.responseText==="success"){
                    target.innerHTML++;
                    button.setAttribute("class","unhate");		
                    var likeButton = document.getElementById(buttonID.replace("hate","like"));	
                    likeButton.style.visibility='hidden';					
                    stat.innerHTML = "You dislike this";			
                }               
            }
        }
        xmlhttp.open("GET","php/updateLike.php?idpost="+idpost+"&tipe=hate&count="+(parseInt(target.innerHTML)+1));
        xmlhttp.send();                
    } else if (button.className === "unlike"){
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText==="failed"){
                    alert("Silakan login dulu untuk like/dislike post");
                }
                else if(xmlhttp.responseText==="success"){
                    var target = document.getElementById("like_"+targetID);			
                    target.innerHTML--;
                    button.setAttribute("class","like");	
                    var hateButton = document.getElementById(buttonID.replace("like","hate"));	
                    hateButton.style.visibility='visible';					
                    stat.innerHTML = " ";		
                }               
            }
        }
        xmlhttp.open("GET","php/updateLike.php?idpost="+idpost+"&tipe=unlike");
        xmlhttp.send();                        	
    } else if (button.className === "unhate"){
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText==="failed"){
                    alert("Silakan login dulu untuk like/dislike post");
                }
                else if(xmlhttp.responseText==="success"){
                    var target = document.getElementById("hate_"+targetID);			
                    target.innerHTML--;
                    button.setAttribute("class","hate");		
                    var likeButton = document.getElementById(buttonID.replace("hate","like"));	
                    likeButton.style.visibility='visible';							
                    stat.innerHTML = " ";			
                }               
            }
        }
        xmlhttp.open("GET","php/updateLike.php?idpost="+idpost+"&tipe=unhate");
        xmlhttp.send();                        	        
    }           
}
	
//fungsi untuk halaman post
//fungsi utama
function ChangeForm(){//untuk mengubah form yang disediakan sesuai keinginan saat akan mengepost
    //variabelnya harus disesuaikan satu-satu. aku ga bikin parameter fungsi karena parameternya terlalu banyak.
    var f1 = document.getElementById('postType_0');
    var f2 = document.getElementById('postType_1');
    var f3 = document.getElementById('postType_2');
    var URL = document.getElementById('url');
    var Desc = document.getElementById('desc');
    var Picture = document.getElementById('picture');
    var Video = document.getElementById('video');
    var tag = document.getElementById('tagContent');	
    if (f1.checked){
        tag.disabled = false;
        tag.setAttribute('style', 'background: #CCC;');		
        URL.disabled = false;        
        URL.setAttribute('style', 'background: #CCC;');			
        Desc.disabled = false;
        Picture.disabled = true;
        Video.disabled = true;
        Desc.setAttribute('style', 'background: #CCC; max-width: 450px; max-height: 180px; margin-left: 0px; margin-right: 0px; width: 457px; margin-top: 0px; margin-bottom: 0px; height: 200px;');
        Picture.setAttribute('style', 'background: #CC0000;');
        Video.setAttribute('style', 'background: #CC0000;');
    } else if (f2.checked){
        tag.disabled = false;
        tag.setAttribute('style', 'background: #CCC;');				
        URL.disabled = true;
        Desc.disabled = true;
        Picture.disabled = false;
        Video.disabled = true;
        URL.setAttribute('style', 'background: #CC0000;');
        Desc.setAttribute('style', 'background: #CC0000; max-width: 450px; max-height: 180px; margin-left: 0px; margin-right: 0px; width: 457px; margin-top: 0px; margin-bottom: 0px; height: 200px;');
        Picture.setAttribute('style', 'background: #CCC;');
        Video.setAttribute('style', 'background: #CC0000;');
    } else if (f3.checked){
        tag.disabled = false;
        tag.setAttribute('style', 'background: #CCC;');				
        URL.disabled = true;
        Desc.disabled = true;
        Picture.disabled = true;
        Video.disabled = false;
        URL.setAttribute('style', 'background: #CC0000;');
        Desc.setAttribute('style', 'background: #CC0000; max-width: 450px; max-height: 180px; margin-left: 0px; margin-right: 0px; width: 457px; margin-top: 0px; margin-bottom: 0px; height: 200px;');
        Picture.setAttribute('style', 'background: #CC0000;');
        Video.setAttribute('style', 'background: #CCC;');
    }
}
		
function konversiYoutubeURL(url) {
    var str = "http://www.youtube.com/v/";
    str += getURLQueryValueById(url,"v");
    str += "?version=3&feature=player_detailpage";
    return str;
}

function getURLQueryValueById(url,id) {
    // mengembalikan nilai dari parameter query string yang dimasukkan
    var str = url;
    var idx = str.indexOf(id);
    if (idx != -1) {
        idx	+= id.length +1;
        var idx2 = str.indexOf("&", idx);
        if (idx2 == -1) {
            str = str.substring(idx);
        } else {
            str = str.substring(idx, idx2);
        }
        str = getQueryOK(str);
        return str;
    } else {
        return "";
    }
}		
		
function getQueryOK(str) {
    str = str.replace(/%3B/gi,";");
    str = str.replace(/%3F/gi,"?");
    str = str.replace(/%2F/gi,"/");
    str = str.replace(/%3A/gi,":");
    str = str.replace(/%23/gi,"#");
    str = str.replace(/%26/gi,"&");
    str = str.replace(/%3D/gi,"=");
    str = str.replace(/%2B/gi,"+");
    str = str.replace(/%24/gi,"$");
    str = str.replace(/%2C/gi,",");
    str = str.replace(/%20/gi," ");
    str = str.replace(/%25/gi,"%");
    str = str.replace(/%3C/gi,"<");
    str = str.replace(/%3E/gi,">");
    str = str.replace(/%7E/gi,"~");
    str = str.replace(/%27/gi,"'");
    str = str.replace(/~/gi,"<br/>");
    return str;
}
	
function checkUrl(url) {
    //    var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    //    if(urlregex.test(url))
    //    {
    //        return(true);
    //    }
    //    return(false);
    return true;
}

function isValidYoutube(url){
    //    var urlregex = new RegExp("^http:\/\/(?:www\.)?youtube.com\/watch\?(?=.*v=\w+)(?:\S+)?$");
    //    if(urlregex.test(url))
    //    {
    //        return(true);
    //    }
    //    return(false);    
    return true;
}

function isValidImage(path){
    if(path.split('.').pop().toLowerCase() == 'jpg' || path.split('.').pop().toLowerCase() == 'jpeg')
    {
        return true;
    }	
    return false;	     
}

function getContent(){
    var f1 = document.getElementById('postType_0');
    var f2 = document.getElementById('postType_1');
    var f3 = document.getElementById('postType_2');
    var URL = document.getElementById('url').value;
    var Desc = replaceAll(document.getElementById('desc').value,"\n","<br/>");
    var Picture = document.getElementById('picture').value;
    var Video = document.getElementById('video').value;
    var Preview = document.getElementById('preview');
    var Content = document.getElementById('contentview');
    var Title = document.getElementById('title').value;
		
    if (f1.checked){
        return "<h1><a href = content.php?idpost=none>"+Title+"</h1>"+  
        "<div class='clear'></div>"+					        
        "<a href='"+URL+"'>"+URL+"</a><br>"+				
        "<div class='clear'></div>"+					                
        "<h4>"+Desc+"</h4>";
    } else if (f3.checked){
        return "<h1><a href = content.php?idpost=none>"+Title+"</h1>"+  
        "<div class='clear'></div>"+					                
        "<object type='application/x-shockwave-flash' width='600' height='400' data='"+
        konversiYoutubeURL(Video)+
        "'><param name='movie' value='"+
        konversiYoutubeURL(Video)+
        "' /><param name='allowFullScreen' value='true' /></object>";
    } else if (f2.checked){ //kata spek ga ada yang terjadi
        return 
        "<h1><a href = content.php?idpost=none>"+Title+"</h1>"+  
        "<div class='clear'></div>"+					        
        "<img src='pictures/frenzon.jpg' width='100%' /><br />";
    }        
}

function checkUniqueUsername(uname){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var respon = xmlhttp.responseText;
            if(respon=="failed"){
                document.getElementById("notifUsername").innerHTML="Username sudah ada di database!";
            }else{
                document.getElementById("notifUsername").innerHTML="";                    
            }
        }
    }
    xmlhttp.open("GET","php/checkName.php?name="+uname);
    xmlhttp.send();                
}
    
function checkUniqueEmail(uname){
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var respon = xmlhttp.responseText;
            if(respon=="failed"){
                document.getElementById("notifEmail").innerHTML="Email sudah ada di database!";
            }else{
                document.getElementById("notifEmail").innerHTML="";                    
            }
        }
    }
    xmlhttp.open("GET","php/checkEmail.php?email="+uname);
    xmlhttp.send();                
}    

function PostContent(username){//untuk publish post
    var f1 = document.getElementById('postType_0');
    var f2 = document.getElementById('postType_1');
    var f3 = document.getElementById('postType_2'); 
    var Title = document.getElementById('title').value;    
    var Tag = document.getElementById('tagContent').value;    
    var Content = getContent();
    if (f1.checked){
        //tampilin URL + Deskripsi
        var URL = document.getElementById('url').value;
        var Desc = document.getElementById('desc').value;        
        if(Title.length == 0 || URL.length == 0 || Desc.length == 0){
            alert("Please make sure the title, URL, and description field is not empty!");
        }
        else if(!checkUrl(URL)){
            alert("Sorry, your link URL is not valid :(");            
        }
        else{
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var respon = xmlhttp.responseText;
//                    alert("respon = *"+respon+"* , parseInt = *"+parseInt(respon,10)+"*");
                    if(parseInt(respon,10)==respon){
//                        alert("Anjir masih masuk sini lah");                    
                        achieve1(username, "post",respon);                    
                    }else{
                        window.location = respon;
                    }                    
                }
            }
            Content = replaceAll(Content,'&','*');                        
            xmlhttp.open("GET","php/updateTaglist.php?judul="+Title+"&username="+username+"&isi="+replaceAll(Content,'\'','\"')+"&tag="+Tag+"&url="+URL);
            xmlhttp.send();            
        }
    } else if (f2.checked){
        //tampilin image
        var Picture = document.getElementById('picture').value;    
        if(Title.length == 0 || Picture.length == 0){
            alert("Please make sure the title and image path field is not empty!");
        }
        else if(!isValidImage(Picture)){
            alert("Sorry, your image extension must be JPEG :(");            
        }            
        else{
            //copy image ke pictures
            var postForm = document.getElementById('postForm');  
            postForm.submit();
        //            alert("Image OK!");
        }        
    } else if (f3.checked){ 
        //tampilin video        
        var Video = document.getElementById('video').value;    
        if(Title.length == 0 || Video.length == 0){
            alert("Please make sure the title and Video URL field is not empty!");
        }
        else if(!isValidYoutube(URL)){
            alert("Sorry, your Youtube link is not valid :(");            
        }    
        else{
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var respon = xmlhttp.responseText;
//                    alert("respon videooh= *"+respon+"* , parseInt = *"+parseInt(respon,10)+"*");
                    if(parseInt(respon,10)==respon){
//                        alert("Anjir masih masuk sini lah");                    
                        achieve1(username, "post",respon);                    
                    }else{
                        window.location = respon;
                    }                    
                }                
            }
            Content = replaceAll(Content,'\'','\"');
            Content = replaceAll(Content,'&','*');            
//            alert("php/updateTaglist.php?judul="+Title+"&username="+username+"&isi="+Content+"&tag="+Tag+"&video="+Video);
            xmlhttp.open("GET","php/updateTaglist.php?judul="+Title+"&username="+username+"&isi="+Content+"&tag="+Tag+"&video="+Video);
            xmlhttp.send();                        
        }        
    }        
}                
                
function replaceAll(txt, replace, with_this) {
    return txt.replace(new RegExp(replace, 'g'),with_this);
}                
                
function PreviewPost(){//untuk preview hasil post
    //variabelnya harus disesuaikan satu-satu. aku ga bikin parameter fungsi karena parameternya terlalu banyak. terus kayaknya ga bisa pake metode submit deh, soalnya aku asumsi si previewnya di halaman yg sama. klo ternyata harus ke halaman content, bilang ya, ntar kodenya diganti
    var f1 = document.getElementById('postType_0');
    var f2 = document.getElementById('postType_1');
    var f3 = document.getElementById('postType_2');
    var URL = document.getElementById('url').value;
    var Desc = replaceAll(document.getElementById('desc').value,"\n","<br/>");
    var Picture = document.getElementById('picture').value;
    var Video = document.getElementById('video').value;
    var Preview = document.getElementById('preview');
    var Content = document.getElementById('contentview');
    var Title = document.getElementById('title').value;
		
    if (f1.checked){
        //tampilin URL + Deskripsi
        Content.innerHTML  = "<div class='container_full'>"+
        "<h1>"+Title+"</h1>"+  
        "<div class='clear'></div>"+					        
        "<a href='"+URL+"'>"+URL+"</a><br>"+				
        "<div class='clear'></div>"+					        
        "<h4>"+Desc+"</h4>"+				        
        "</div>";          
    } else if (f3.checked){
        //tampilin video
        Content.innerHTML  = "<div class='container_full'>"+
        "<h1>"+Title+"</h1>"+                                        
        "<div class='clear'></div>"+					                
        "<object type='application/x-shockwave-flash' width='600' height='400' data='"+
        konversiYoutubeURL(Video)+
        "'><param name='movie' value='"+
        konversiYoutubeURL(Video)+
        "' /><param name='allowFullScreen' value='true' /></object>"+
        "</div>";                
    } else if (f2.checked){ //kata spek ga ada yang terjadi
    //tampilin image
    //Content.innerHTML = "<img src='image/"+Picture+"'></img>";
    }    
}
		
    //fungsi dasar
	

    //fungsi untuk halaman home
    //fungsi utama
    //fungsi dasar
	
    //fungsi untuk perubahan tema
    //fungsi utama
    //fungsi dasar