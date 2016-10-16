<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Tugas Besar PROGIN 1</title>
        <link id="css-tampilan" rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
        <script src="js/javascript.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        require 'php/connectdb.php';
        session_start();
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
        $sql = "Select * from profil where username='$_GET[username]'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        ?>
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
        <div class="container-content">
            <div id="container_main">
                <div class="container_full">
                    <div id="content">
                        <div class="block">
                            <h1><?php echo $row['username']; ?></h1>
                            <div class="profile_avatar"><img src= "<?php echo $row['avatar']; ?>"  width="250px" alt="gambar" />
                                <form id="fChangeAvatar" method="post" enctype="multipart/form-data" action="php/gantiImage.php?username=<?php echo $_GET['username']; ?>">
                                    <p>
                                        <label>
                                            <input name="inputAvatar" type="file" id="inputAvatar" accept="image"/>
                                            <input type="submit" name="changeAvatar" id="changeAvatar" value="Change Avatar"/>
                                        </label>
                                    </p>
                                </form>
                                <label style="color: red">
                                    <?php
                                    if (isset($_GET['NinputAvatar']))
                                        echo $_GET['NinputAvatar']
                                        ?>
                                </label>
                            </div>
                            <div class="info">
                                <table width="392" border="0">
                                    <form id="fChangeEmail" method="post" action="php/gantiEmail.php?username=<?php echo $_GET['username']; ?>">
                                        <tr>
                                            <td width="90" valign="top">Email</td>
                                            <td width="10" valign="top">:</td>
                                            <td width="278"><?php echo $row['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><p>
                                                    <input name="inputEmail" type="text" id="inputEmail" value="<?php
                                if (isset($_GET['email'])) {
                                    echo $_GET['email'];
                                }
                                    ?>"/>
                                                    <input type="submit" name="changeEmail" id="changeEmail" value="Change Email" />
                                                </p></td>
                                        </tr>
                                    </form>
                                    <tr>
                                        <td width="90" valign="top"></td>
                                        <td width="10" valign="top"></td>
                                        <td width="278"></td>
                                        <td style="color: red"><?php
                                                           if (isset($_GET['noticeEmail'])) {
                                                               echo $_GET['noticeEmail'];
                                                           }
                                    ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Gender</td>
                                        <td valign="top">:</td>
                                        <td>
                                            <?php
                                            echo $row['gender'];
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td valign="top">Jml Komentar</td>
                                        <td valign="top">:</td>
                                        <td><?php echo $row['achievement_comment']; ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Jml Konten</td>
                                        <td valign="top">:</td>
                                        <td>
                                            <?php
                                            echo $row['achievement_post'];
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td valign="top">About Me</td>
                                        <td valign="top">:</td>
                                        <td>
                                            <form id="fChangeAbout" method="post" action="php/gantiAbout.php?username=<?php echo $_GET['username']; ?>">
                                                <p>
                                                    <textarea name="inputAbout" id="inputAbout" rows="5" cols="40" style="width:350px; height: 100px;max-width:350px; max-height: 100px;"><?php echo $row['about_me']; ?></textarea>
                                                    <input type="submit" name="changeAbout" id="changeAbout" value="Change About" />
                                                </p>
                                            </form></td>
                                    </tr>
                                </table>
                            </div>                              
                        </div>
                    </div>
                    <div id="sidebar">
                        <div class="block">
                            <div id="c60">
                                <h4>Achievement</h4>
                                <div id="c61"></div>
                                <table border="0" align="center" cellpadding="0" cellspacing="0" class="trophysidebox">
                                    <tbody>
                                        <?php
                                        if($row['achievement_post']>0) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Newbie Commentator</div>";
                                            echo "<img src='image/comment1.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Mengomentari post untuk pertama kalinya</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        }
                                        if($row['achievement_post']>19) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Commentator</div>";
                                            echo "<img src='image/comment20.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Mengomentari post minimal 20 kalinya</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        }                                        
                                        if($row['achievement_comment']>0) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Newbie Journalist</div>";
                                            echo "<img src='image/post1.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Melakukan post untuk pertama kalinya</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        }                                                                                
                                        if($row['achievement_post']>19) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Future Journalist</div>";
                                            echo "<img src='image/post20.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Melakukan post minimal 20 kali</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        } 
                                        if($row['achievement_like']>99) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Public Figure</div>";
                                            echo "<img src='image/like100.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Mempunyai minimal 1 post dengan 100 like</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        }                                                                                                                                                                
                                        if($row['achievement_dislike']>99) {
                                            echo "<tr>";
                                            echo"<td width='137' align='center' valign='bottom'>";
                                            echo "<div class='trophybox'>";
                                            echo "<div class='trophyname'>Arch Enemy</div>";
                                            echo "<img src='image/dislike100.png' width='64' height='64' /></div>";
                                            echo"</td>";
                                            echo"<td width='137' align='center' valign='bottom'>Mempunyai minimal 1 post dengan 100 dislike</td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><h4></h4></td>";
                                            echo "<td><h4></h4></td>";                                    
                                            echo "</tr>";
                                        }                                                                                                                                                                                                        
                                        ?>
                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>

                </div>
                <div id="myPost" class="post">
                    <h2>My Post</h2>
                </div>
                <?php
                //$username = $_GET['username'];
                if ($row['achievement_post'] > 0) {
                    require 'php/connectdb.php';
                    $sql2 = "Select * from konten WHERE username ='" . $_SESSION['username'] . "' order by waktu_dipost DESC";
                    $result2 = mysql_query($sql2);
                    $i = 0;
                    while ($row1 = mysql_fetch_array($result2)) {
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

                        echo "<div class='container_full'>";
                        echo "<div class='content'>";
                        echo $konten[$i]['inti'];
                        echo "</div>";
                        echo "<div class = 'content_id'>";
                        echo $konten[$i]['judul'];
                        echo "<div class='clear'></div>";
                        echo "<h4>by <a href='profile.php?username=";
                        echo $konten[$i]['username'] . "'>";
                        echo $konten[$i]['username'] . "</a>";

                        $d1 = strtotime($konten[$i]['waktu_dipost']);
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
                        echo "<span id='like_" . $i . "' style='color:#458B00'>" . $konten[$i]['jumlah_like'] . "</span>";
                        echo " <span style='color:#458B00'>likes</span> | ";
                        echo "<span id='hate_" . $i . "' style='color:#8B1A1A'>" . $konten[$i]['jumlah_dislike'] . "</span> <span style='color:#8B1A1A'>dislikes</span> | " . $konten[$i]['jumlah_komen'] . " comments </h4>";
                        //cek status like user terhadap post
                        if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
                            $sql = "SELECT * FROM liker WHERE id_post='" . $konten[$i]['id_post'] . "' AND username = '" . $_SESSION['username'] . "'";
                            $result = mysql_query($sql);
                            if (mysql_num_rows($result) == 0) {
                                echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                            } else if (mysql_num_rows($result) == 1) {
                                $row = mysql_fetch_array($result);
                                $tipe = $row['like'];
                                if ($tipe === "like") {
                                    echo "<script>changeStatLike('stat_like_" . $i . "','You like this');</script>";
                                    echo "<button id='likeit_" . $i . "' class='unlike' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                    echo "<button style='visibility:hidden' id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                } else if ($tipe === "dislike") {
                                    echo "<script>changeStatLike('stat_like_" . $i . "','You dislike this');</script>";
                                    echo "<button style='visibility:hidden' id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                    echo "<button id='hateit_" . $i . "' class='unhate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                } else if ($tipe === "netral") {
                                    echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                    echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                                }
                            }
                        } else {
                            echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                            echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                        }
                        echo "</div>";
                        echo "</div>";
                        $i++;
                    }
                } else {
                    echo "<div class='container_full'>";
                    echo "<b><span style='font-size: 30px; color:red;'>Oops, you haven't posted anything yet! :)</span></b><br/>";
//                        echo "<h1 style='color:red'></h1>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>                  
        <div id="footer">
            <div class="container_footer">
                © 2011   ·   <a href="">About</a>   ·   <a href="">Rules</a>   ·   <a href="">FAQ</a>   ·   <a href="">People</a>   ·   <a href="">Top</a>   ·   <a href="">Terms</a>   ·   <a href="">Privacy</a>   ·   <a href="">Contact Us</a>
            </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
