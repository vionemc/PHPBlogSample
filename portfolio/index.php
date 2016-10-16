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
//ambil 3 konten like terbanyak
$sql = "SELECT * FROM konten ORDER BY jumlah_like DESC";
$result = mysql_query($sql);
if (!$result) {
    die("Error fetch bestL =" . mysql_error());
}
$i = 0;
while (($row1 = mysql_fetch_array($result)) && ($i < 3)) {
    $bestLike[$i] = $row1;
    $sql1 = "SELECT COUNT(*) FROM komentar WHERE id_post='" . $bestLike[$i]['id_post'] . "'";
    $result1 = mysql_query($sql1);
    if (!$result1) {
        die("Error fetch bestL =" . mysql_error());
    }
    $row2 = mysql_fetch_array($result1);
    $bestLike[$i]['jumlah_komen'] = $row2['COUNT(*)'];
    $i++;
}
$jumBestLike = $i;

//ambil 3 konten komen terbanyak
$sql = "SELECT id_post,count(*) FROM `komentar` GROUP BY id_post ORDER BY count(*) DESC";
$result = mysql_query($sql);
if (!$result) {
    die("Error fetch bestC1 =" . mysql_error());
}
$i = 0;
while (($row1 = mysql_fetch_array($result)) && ($i < 3)) {
    $sql1 = "SELECT * FROM `konten` WHERE id_post='" . $row1['id_post'] . "'";
    $result1 = mysql_query($sql1);
    if (!$result1) {
        die("Error fetch bestC2 =" . mysql_error());
    } else {
        $row2 = mysql_fetch_array($result1);
        $bestComm[$i] = $row2;
        $bestComm[$i]['jumlah_komen'] = $row1['count(*)'];
    }
    $i++;
}
$jumBestComm = $i;
?>
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
    <body id="index">
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
                    for ($i = 0; $i < 3; $i++) {
                        echo "<div class='container_onethird'>";
                        echo "<img class='logo-utama' alt='LOGO' src='image/best" . ($i + 1) . ".png' width='150' />";
                        if (($i + 1) > $jumBestLike) {
                            echo "<h1>Post is not available yet!</h1>";
                        } else {
                            //ambil isi dari database
                            $bestLike[$i]['isi_konten'] = preg_replace("/\"/", "'", $bestLike[$i]['isi_konten']);
                            $bestLike[$i]['isi_konten'] = str_replace("*", "&", $bestLike[$i]['isi_konten']);
                            //sesuaikan width dan height untuk post video
                            if (strpos($bestLike[$i]['isi_konten'], "application/x-shockwave-flash") !== false) {
                                $bestLike[$i]['isi_konten'] = str_replace("600", "280", $bestLike[$i]['isi_konten']);
                                $bestLike[$i]['isi_konten'] = str_replace("400", "200", $bestLike[$i]['isi_konten']);
                            }
                            //remove a href dan isinya mulai dari a href kedua
                            $idxA = strpos($bestLike[$i]['isi_konten'], "<a href");
                            $idxA = strpos($bestLike[$i]['isi_konten'], "<a href", $idxA + 1);
                            if ($idxA !== false) {
                                $sub1 = substr($bestLike[$i]['isi_konten'], 0, $idxA);
                                $sub2 = substr($bestLike[$i]['isi_konten'], $idxA);
                                $sub2 = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $sub2);
                                $sub2 = str_replace("<a href=\"", "", $sub2);
                                $sub2 = preg_replace("#\">()</a>#", "", $sub2);
                                $bestLike[$i]['isi_konten'] = $sub1 . $sub2;
                            }

                            echo $bestLike[$i]['isi_konten'];
                            echo "<div class='clear'></div>";
                            echo "<h4>by <a href='profile.php?username=";
                            echo $bestLike[$i]['username'] . "'>";
                            echo $bestLike[$i]['username'] . "</a>";

                            $d1 = strtotime($bestLike[$i]['waktu_dipost']);
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
                            echo "<h4><span id = 'stat_like_" . $i . "'>";
                            echo "</span></h4><h4>";
                            echo "<span id='like_" . $i . "' style='color:#458B00'>" . $bestLike[$i]['jumlah_like'] . "</span>";
                            echo " <span style='color:#458B00'>likes</span> | ";
                            echo "<span id='hate_" . $i . "' style='color:#8B1A1A'>" . $bestLike[$i]['jumlah_dislike'] . "</span> <span style='color:#8B1A1A'>dislikes</span> | " . $bestLike[$i]['jumlah_komen'] . " comments </h4>";
                            //cek status like user terhadap post
                            if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                                $sql = "SELECT * FROM liker WHERE id_post='" . $bestLike[$i]['id_post'] . "' AND username = '" . $_SESSION['username'] . "'";
                                $result = mysql_query($sql);
                                if (mysql_num_rows($result) == 0) {
                                    echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                    echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                } else if (mysql_num_rows($result) == 1) {
                                    $row = mysql_fetch_array($result);
                                    $tipe = $row['like'];
                                    if ($tipe === "like") {
                                        echo "<script>changeStatLike('stat_like_" . $i . "','You like this');</script>";
                                        echo "<button id='likeit_" . $i . "' class='unlike' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                        echo "<button style='visibility:hidden' id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                    } else if ($tipe === "dislike") {
                                        echo "<script>changeStatLike('stat_like_" . $i . "','You dislike this');</script>";
                                        echo "<button style='visibility:hidden' id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                        echo "<button id='hateit_" . $i . "' class='unhate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                    } else if ($tipe === "netral") {
                                        echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                        echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                    }
                                }
                            } else {
                                echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                                echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $bestLike[$i]['id_post'] . '"' . ");' />";
                            }
                        }
                        echo "</div>";
                    }
                    ?>                    
                </div>
                <div id="container_main">
                    <?php
                    for ($i = 0; $i < 3; $i++) {
                        echo "<div class='container_onethird'>";
                        echo "<img class='logo-utama' alt='LOGO' src='image/bestc" . ($i + 1) . ".png' width='150' />";
                        if (($i + 1) > $jumBestComm) {
                            echo "<h1>Post is not available yet!</h1>";
                        } else {
                            //ambil isi dari database
                            $bestComm[$i]['isi_konten'] = preg_replace("/\"/", "'", $bestComm[$i]['isi_konten']);
                            $bestComm[$i]['isi_konten'] = str_replace("*", "&", $bestComm[$i]['isi_konten']);
                            //sesuaikan width dan height untuk post video
                            if (strpos($bestComm[$i]['isi_konten'], "application/x-shockwave-flash") !== false) {
                                $bestComm[$i]['isi_konten'] = str_replace("600", "280", $bestComm[$i]['isi_konten']);
                                $bestComm[$i]['isi_konten'] = str_replace("400", "200", $bestComm[$i]['isi_konten']);
                            }
                            //remove a href dan isinya mulai dari a href kedua
                            $idxA = strpos($bestComm[$i]['isi_konten'], "<a href");
                            $idxA = strpos($bestComm[$i]['isi_konten'], "<a href", $idxA + 1);
                            if ($idxA !== false) {
                                $sub1 = substr($bestComm[$i]['isi_konten'], 0, $idxA);
                                $sub2 = substr($bestComm[$i]['isi_konten'], $idxA);
                                $sub2 = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $sub2);
                                $sub2 = str_replace("<a href=\"", "", $sub2);
                                $sub2 = preg_replace("#\">()</a>#", "", $sub2);
                                $bestComm[$i]['isi_konten'] = $sub1 . $sub2;
                            }
                            echo $bestComm[$i]['isi_konten'];
                            echo "<div class='clear'></div>";
                            echo "<h4>by <a href='profile.php?username=";
                            echo $bestComm[$i]['username'] . "'>";
                            echo $bestComm[$i]['username'] . "</a>";

                            $d1 = strtotime($bestComm[$i]['waktu_dipost']);
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
                            echo "<h4><span id = 'stat_like_" . ($i + 3) . "'>";
                            echo "</span></h4><h4>";
                            echo "<span id='like_" . ($i + 3) . "' style='color:#458B00'>" . $bestComm[$i]['jumlah_like'] . "</span>";
                            echo " <span style='color:#458B00'>likes</span> | ";
                            echo "<span id='hate_" . ($i + 3) . "' style='color:#8B1A1A'>" . $bestComm[$i]['jumlah_dislike'] . "</span> <span style='color:#8B1A1A'>dislikes</span> | " . $bestComm[$i]['jumlah_komen'] . " comments </h4>";
                            //cek status like user terhadap post
                            if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                                $sql = "SELECT * FROM liker WHERE id_post='" . $bestComm[$i]['id_post'] . "' AND username = '" . $_SESSION['username'] . "'";
                                $result = mysql_query($sql);
                                if (mysql_num_rows($result) == 0) {
                                    echo "<button id='likeit_" . ($i + 3) . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                    echo "<button id='hateit_" . ($i + 3) . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                } else if (mysql_num_rows($result) == 1) {
                                    $row = mysql_fetch_array($result);
                                    $tipe = $row['like'];
                                    if ($tipe === "like") {
                                        echo "<script>changeStatLike('stat_like_" . ($i+3) . "','You like this');</script>";                                        
                                        echo "<button id='likeit_" . ($i + 3) . "' class='unlike' type='button' onclick='LikeThis(" . '"likeit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                        echo "<button style='visibility:hidden' id='hateit_" . ($i + 3) . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                    } else if ($tipe === "dislike") {
                                        echo "<script>changeStatLike('stat_like_" . ($i+3) . "','You dislike this');</script>";                                                                                
                                        echo "<button style='visibility:hidden' id='likeit_" . ($i + 3) . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                        echo "<button id='hateit_" . ($i + 3) . "' class='unhate' type='button' onclick='LikeThis(" . '"hateit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                    } else if ($tipe === "netral") {
                                        echo "<button id='likeit_" . ($i + 3) . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                        echo "<button id='hateit_" . ($i + 3) . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                    }
                                }
                            } else {
                                echo "<button id='likeit_" . ($i + 3) . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                                echo "<button id='hateit_" . ($i + 3) . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . ($i + 3) . '"' . ", " . '"' . ($i + 3) . '"' . "," . '"' . $bestComm[$i]['id_post'] . '"' . ");' />";
                            }
                        }
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
