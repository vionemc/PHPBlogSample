<?php
session_start();
include("php/connectdb.php");
extract($_POST);
if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
    //ambil info username
    $sql = "SELECT * FROM profil WHERE username='" . $_SESSION['username'] . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die(mysql_error());
    }
    $user = mysql_fetch_array($result);
}
//ambil info current filter  
$filter = $_GET['filter'];
$key = $_GET['key'];
//mengesktrak key
if ($key !== "" && preg_replace('/\s\s+/', ' ', $key) !== "") {
    //membersihkan spasi sebelum dan setelah
	preg_replace('/\s+$/', '', $key);
	preg_replace('/$\s+/', '', $key);    
}
//ambil hasil pencarian
	//deklarasi
	$sUser=NULL;
	$sPost=NULL;
if ($filter==="All"||$filter==="Username") {
	$sql = "SELECT username,avatar FROM profil WHERE (username LIKE '%$key%') OR (about_me LIKE '%$key%') OR (email LIKE '%$key%') OR (nama_lengkap LIKE '%$key%')";
	$result = mysql_query($sql);
	if (!$result) {
		die(mysql_error());
	}
	$i=0;
	while($rowz=mysql_fetch_array($result)){
		$sUser[$i] = $rowz;
		$i++;
	}
}
if ($filter==="All"||$filter==="Post") {
	$sql = "SELECT DISTINCT konten.id_post,judul FROM konten,taglist WHERE ((konten.id_post=taglist.id_post AND (judul LIKE '%$key%' OR tag_name LIKE '%$key%')) OR (konten.id_post<>taglist.id_post AND (judul LIKE '%$key%')))";
	$result = mysql_query($sql);
	if (!$result) {
		die(mysql_error());
	}	
	$i=0;
	while($rowz=mysql_fetch_array($result)){
		$sPost[$i] = $rowz;
		$i++;
	}
}
/*
$sql = "SELECT DISTINCT tag_name FROM taglist";
$result = mysql_query($sql);
if (!$result) {
    die(mysql_error());
}
$i = 0;
while ($row = mysql_fetch_array($result)) {
    $tag[$i] = $row['tag_name'];
    $i++;
}
//paginasi
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$query = "SELECT count(*) FROM konten";
$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);
$query_data = mysql_fetch_row($result);
$numrows = $query_data[0];
$rows_per_page = 6;
$lastpage = ceil($numrows / $rows_per_page);
$pageno = (int) $pageno;
if ($pageno > $lastpage) {
    $pageno = $lastpage;
}
if ($pageno < 1) {
    $pageno = 1;
}
$limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;
//ambil sort
if (isset($_GET['sort'])) {
    if ($_GET['sort'] === "Most Popular") {
        $query = "SELECT * FROM konten ORDER BY jumlah_like DESC $limit";
    } else if ($_GET['sort'] === "Most Commented") {
        $query = "SELECT * FROM konten ORDER BY (SELECT COUNT(*) FROM komentar WHERE konten.id_post = komentar.id_post) DESC $limit";
    } else if ($_GET['sort'] === "Newest") {
        $query = "SELECT * FROM konten ORDER BY waktu_dipost DESC $limit";
    }
} else {
    $query = "SELECT * FROM konten ORDER BY waktu_dipost DESC $limit";
}
$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);
$i = 0;
while ($row1 = mysql_fetch_array($result)) {
    $konten[$i] = $row1;
    //proses format konten
    $konten[$i]['isi_konten'] = preg_replace("/\"/", "'", $konten[$i]['isi_konten']);
    $konten[$i]['isi_konten'] = str_replace("*", "&", $konten[$i]['isi_konten']);
    //sesuaikan width dan height untuk post video
//        if (strpos($konten[$i]['isi_konten'], "application/x-shockwave-flash") !== false) {
//            $konten[$i]['isi_konten'] = str_replace("600", "500", $konten[$i]['isi_konten']);
//            $konten[$i]['isi_konten'] = str_replace("400", "300", $konten[$i]['isi_konten']);
//        }
    //remove a href dan isinya mulai dari a href kedua
    $idxA = strpos($konten[$i]['isi_konten'], "<a href");
    $idxA = strpos($konten[$i]['isi_konten'], "<a href", $idxA + 1);
    if ($idxA !== false) {
        $sub1 = substr($konten[$i]['isi_konten'], 0, $idxA);
        $sub2 = substr($konten[$i]['isi_konten'], $idxA);
        $sub2 = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $sub2);
        $sub2 = str_replace("<a href=\"", "", $sub2);
        $sub2 = preg_replace("#\">()</a>#", "", $sub2);
        $konten[$i]['isi_konten'] = $sub1 . $sub2;
    }
    //pisahkan judul dan konten
    $idx1 = strpos($konten[$i]['isi_konten'], "<div class='clear'></div>");
    $idx1+=25;
    $konten[$i]['judul'] = substr($konten[$i]['isi_konten'], 0, $idx1);
    $konten[$i]['inti'] = substr($konten[$i]['isi_konten'], $idx1);
    //ambil jumlah komentar
    $sql1 = "SELECT COUNT(*) FROM komentar WHERE id_post='" . $konten[$i]['id_post'] . "'";
    $result1 = mysql_query($sql1);
    if (!$result1) {
        die("Error fetch bestL =" . mysql_error());
    }
    $row2 = mysql_fetch_array($result1);
    $konten[$i]['jumlah_komen'] = $row2['COUNT(*)'];
    $i++;
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
        <title>Tugas Besar PROGIN 1</title>

        <!-- CSS Links -->
        <link id="css-tampilan" rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
        <!--        <link rel="alternate stylesheet" type="text/css" href="css/cadangan1.css" title="alternative" />-->

        <!-- Scripts Here -->
        <script src="js/javascript.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="header">
            <div id="header1">    
                <div class="clear"></div>
                <div class="container_header_top">
                    <div class="container_header">
                        <div class="logop"> 
                            <?php
                            if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                                echo "<img src='" . $user['avatar'] . "' alt='' class='tinyImage' /></img>";
                                echo "<a href='profile.php?username=" . $_SESSION['username'] . "'>";
                                echo $_SESSION['username'] . " </a> |";
                                echo "<a href='php/logout.php'>";
                                echo "SIGN OUT</a> ";
                            } else {
                                echo "USERNAME<input id='Uname' name='username' type='text' />";
                                echo "PASSWORD<input id='Upass' name='password' type='password' />";
                                echo "<input type = 'button' value = 'SIGN IN' name = 'signin' onclick = 'signIn(document.getElementById(" . '"Uname"' . ").value,document.getElementById(" . '"Upass"' . ").value);' />";
                                echo "|";
                                echo "<input type = 'button' value = 'SIGN UP' name = 'signup' onclick = 'window.location=" . '"register_form.php"' . ";' />";
                            }
                            ?>                            
                        </div>
                    </div>
                </div>
                <div class="container_header_toppy"></div>
                <div class="container_header_border">
                    <div class="container_header_bottom">
                        <div class="container_header">
                            <div class="menuop">
                                <ul class="startmenu">
                                    <li> <a href="index.php" id="indexnav">HOME</a> </li>
                                    <li> <a href="content_list.php" id="contentlnav">CONTENTS</a> </li>
                                    <?php
                                    if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                                        echo"<li> <a href='post.php' id='postnav'>CREATE CONTENT</a> </li>";
                                    }
                                    ?>                                                                                                    
                                </ul>
                                <ul class="endmenu">
                                    <li>
                                      <select name="select" id="filter">
                                        <option onclick="">All</option>
                                        <option onclick="">Username</option>
                                        <option onclick="">Content</option>
                                      </select>
                                      <input name="search" type="text" id="key"/>
                                        <button id="searchB" class="searchButton" type="button" onClick="searching(document.getElementById('filter').value, document.getElementById('key').value);" />
                                    </li>
                                </ul>
                            </div>
                            <div class="mainlogo">
                                <a href="index.php"><img alt="LOGO" src="image/logo.png" height="150" width="150" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="contents">          
            <div class="container-content">
                <div id="container_main">
                    <div class="container_full">                    	    
                          <h3>Search Result For : "<?php echo $key ?>"</h3>
                          <h4>Filter : <?php echo $filter ?></h4>                          </div>
                    <?php
                                        if ($sPost || $sUser){
                                            if ($sPost){					
                                                    for ($i = 0; $i < count($sPost); $i++) {
                                                            echo "<div class='container_full'>";
                                                            echo "<div class='content'>";
                                                            echo "<h1><a href=\"content.php?idpost=".$sPost[$i]['id_post']."\">".$sPost[$i]['judul']."</a></h1>";
                                                            echo "<h4>";
                                                            echo "Tag : ";							
                                                            $sTag=NULL;	
                                                            $sql = "SELECT DISTINCT tag_name FROM konten,taglist WHERE (konten.id_post=taglist.id_post AND konten.id_post=".$sPost[$i]['id_post'].")";
                                                            $result = mysql_query($sql);
                                                            if (!$result) {								
                                                                    echo "none";
                                                            } else {
                                                                    $j=0;
                                                                while($rowz=mysql_fetch_array($result)){
                                                                            $sTag[$j] = $rowz;
                                                                            $j++;
                                                                    }
                                                                    if ($sTag==NULL) {
                                                                            echo "none";
                                                                    } else {	
                                                                            for ($k = 0; $k < count($sTag); $k++) {
                                                                                    echo $sTag[$k]['tag_name']." ";
                                                                            }
                                                                    }

                                                            }
                                                            echo "</h4>";
                                                            echo "</div>";                        
                                                            echo "</div>";
                                                    }
                                            }
                                            if ($sUser){
                                                    for ($i = 0; $i < count($sUser); $i++) {
                                                            echo "<div class='container_full'>";
                                                            echo "<div class='content'>";
                                                            echo "<h1><a href=\"profile.php?username=".$sUser[$i]['username']."\">".$sUser[$i]['username']."</a></h1>";						
                                                            echo "</div>";                        
                                                            echo "</div>";
                                                    }
                                            }
                                        }else {
						echo "<div class='container_full'>";
						echo "<div class='content'>";
						echo "<h1>No Result</h1>";						
						echo "</div>";                        
						echo "</div>";
					}
                    ?>
                </div>
            </div>

        </div>

        <div id="footer">
            <div class="container_footer">
                © 2011   ·   <a href="">About</a>   ·   <a href="">Rules</a>   ·   <a href="">FAQ</a>   ·   <a href="">People</a>   ·   <a href="">Top</a>   ·   <a href="">Terms</a>   ·   <a href="">Privacy</a>   ·   <a href="">Contact Us</a>
            </div>
        </div>

    </body>
</html>
