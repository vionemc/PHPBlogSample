<?php
include("php/connectdb.php");
session_start();
if (!isset($_GET['idpost'])) {
    header("Location:index.php");
} 

$sql = "SELECT * FROM konten WHERE id_post=" . $_GET['idpost'];
$result = mysql_query($sql);
if (!$result) {
    die("Error content.php no id_post: " . mysql_error());
    //no such page exist
} else {
    $row = mysql_fetch_array($result);
    if (mysql_num_rows($result) == 0) {
        //no such page exist
        header("Location:error404.php");
    }
    //ambil avatarPath
    if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
        $avatarPath = "dummy";
        $sql = "SELECT avatar FROM profil WHERE username='" . $_SESSION['username'] . "'";
        $result = mysql_query($sql);
        $row1 = mysql_fetch_array($result);
        $avatarPath = $row1['avatar'];
        //ambil info username
        $sql = "SELECT * FROM profil WHERE username='" . $_SESSION['username'] . "'";
        $result = mysql_query($sql);
        if (!$result) {
            die(mysql_error());
        }
        $user = mysql_fetch_array($result);
    }
    //ambil list komentar
    $sql = "SELECT * FROM komentar WHERE id_post=" . $_GET['idpost'] . " ORDER BY waktu_comment DESC";
    $result = mysql_query($sql);
    $i = 0;
    while ($row1 = mysql_fetch_array($result)) {
        $komen[$i] = $row1;
        $i++;
    }
    $jumlah = $i;
}
?>
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
                                <li> <a href="index.php">HOME</a> </li>
                                <li> <a href="content_list.php">CONTENTS</a> </li>
                                <?php
                                if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                                    echo"<li> <a href='post.php'>CREATE CONTENT</a> </li>";
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
                <?php
                echo "<div class='container_full'>";
                if ($_GET['idpost'] === "'none'") {
                    echo "none = " . $_GET['isi'];
                } else {
                    //ambil isi dari database
                    $row['isi_konten'] = preg_replace("/\"/", "'", $row['isi_konten']);
                    $row['isi_konten'] = str_replace("*", "&", $row['isi_konten']);
                    echo $row['isi_konten'];
                }
                echo "<h4>by <a href='profile.php?username=";
                echo $row['username'] . "'>";
                echo $row['username'] . "</a>";

                $d1 = strtotime($row['waktu_dipost']);
                $d2 = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
                $d2 = strtotime($d2);
                $diff = $d2 - $d1;

                if ($diff >= 0 && $diff <= 60) {
                    echo " " . (floor($diff)) . " seconds";
                } else if ($diff > 60 && $diff <= 3600) {
                    echo " " . (floor($diff / 60)) . " minutes";
                } else if ($diff > 3600 && $diff <= 86400) {
                    echo " " . (floor($diff / 3600)) . " hours";
                } else if ($diff > 86400) {
                    echo " " . (floor($diff / 86400)) . " days";
                }
                echo " ago </h4>";
                echo "<div class = 'clear'></div>";
                echo "<h4><span id = 'stat_like_0'>";
                echo "</span></h4><h4>";
                echo "<span id='like_0' style='color:#458B00'>" . $row['jumlah_like'] . "</span>";
                echo " <span style='color:#458B00'>likes</span> | ";
                echo "<span id='hate_0' style='color:#8B1A1A'>" . $row['jumlah_dislike'] . "</span> <span style='color:#8B1A1A'>dislikes</span> | " . $jumlah . " comments </h4>";
                //cek status like user terhadap post
                if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                    $sql = "SELECT * FROM liker WHERE id_post='" . $_GET['idpost'] . "' AND username = '" . $_SESSION['username'] . "'";
                    $result = mysql_query($sql);
                    if (mysql_num_rows($result) == 0) {
                        echo "<button id='likeit_0' class='like' type='button' onclick='LikeThis(" . '"likeit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                        echo "<button id='hateit_0' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                    } else if (mysql_num_rows($result) == 1) {
                        $row = mysql_fetch_array($result);
                        $tipe = $row['like'];
                        if ($tipe === "like") {
                            echo "<script>changeStatLike('stat_like_" . 0 . "','You like this');</script>";
                            echo "<button id='likeit_" . 0 . "' class='unlike' type='button' onclick='LikeThis(" . '"likeit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                            echo "<button style='visibility:hidden' id='hateit_" . 0 . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                        } else if ($tipe === "dislike") {
                            echo "<script>changeStatLike('stat_like_" . 0 . "','You dislike this');</script>";
                            echo "<button style='visibility:hidden' id='likeit_" . 0 . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                            echo "<button id='hateit_" . 0 . "' class='unhate' type='button' onclick='LikeThis(" . '"hateit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                        } else if ($tipe === "netral") {
                            echo "<button id='likeit_" . 0 . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                            echo "<button id='hateit_" . 0 . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                        }
                    }
                } else {
                    echo "<button id='likeit_" . 0 . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                    echo "<button id='hateit_" . 0 . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . 0 . '"' . ", " . '"' . 0 . '"' . "," . '"' . $_GET['idpost'] . '"' . ");' />";
                }
                echo "</div>";

                if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                    //echo komentar
                    echo "<div class = 'container_full'>";
                    echo "<h2>Komentar</h2>";
                    echo "<textarea name = 'Komentar' id = 'Komentar' cols = '40' rows = '10' style = 'height: 100px; width: 450px;max-height: 100px; max-width: 450px;'></textarea><br />";
                    echo "<input type = 'button' value = 'Submit' name = 'SubmitComment' onclick = 'Comment(document.getElementById(" . '"Komentar"' . ").value, document.getElementById(" . '"commentList"' . ")," . '"' . $_SESSION['username'] . '"' . "," . '"' . $row['id_post'] . '"' . "," . '"' . $avatarPath . '"' . ");' />";
                    echo "</div>";
                }
                echo "<div id = 'commentList'>";
                for ($i = 0; $i < $jumlah; $i++) {
                    echo "<div class = 'container_full'>";
                    $komen[$i]['isi_komentar'] = preg_replace("/\"/", "'", $komen[$i]['isi_komentar']);
                    $komen[$i]['isi_komentar'] = str_replace("*", "&", $komen[$i]['isi_komentar']);
                    echo $komen[$i]['isi_komentar'];
                    echo "<h6 style='font-style:italic;'>";
                    $d1 = strtotime($komen[$i]['waktu_comment']);
                    $d2 = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
                    $d2 = strtotime($d2);
                    $diff = $d2 - $d1;
                    if ($diff >= 0 && $diff <= 60) {
                        echo (floor($diff)) . " seconds";
                    } else if ($diff > 60 && $diff <= 3600) {
                        echo (floor($diff / 60)) . " minutes";
                    } else if ($diff > 3600 && $diff <= 86400) {
                        echo (floor($diff / 3600)) . " hours";
                    } else if ($diff > 86400) {
                        echo (floor($diff / 86400)) . " days";
                    }
                    echo " ago </h6>";
                    //jika komentar user, sediakan hyperlink untuk hapus komen
                    if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                        if ($komen[$i]['username'] === $_SESSION['username']) {
                            echo "<input type = 'button' value = 'Delete' name = 'Delete' onclick = 'deleteComment(" . '"' . $komen[$i]['id_post'] . '"' . "," . '"' . $komen[$i]['username'] . '"' . "," . '"' . $komen[$i]['waktu_comment'] . '"' . ");' />";
                        }
                    }
                    echo "</div>";
                }
                echo "</div>";
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
