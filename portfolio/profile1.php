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
                                    <li> <a href="index.php">HOME</a> </li>
                                    <li> <a href="content_list.php">CONTENTS</a> </li>
                            <?php
                                if(isset($_SESSION['username']) && strlen($_SESSION['username'])>0){
                                    echo"<li> <a href='post.php'>CREATE CONTENT</a> </li>";                               
                                }         
                            ?>                                                                                                    
                                </ul>
                                <ul class="endmenu">
                                    <li>
                                        <select name="select">
                                            <option onclick="">All</option>
                                            <option onclick="">Username</option>
                                            <option onclick="">Content</option>
                                        </select>
                                        <input name="search" type="text" />
                                        <button id="searchB" class="searchButton" type="button" onclick="alert('search it');" />
<!--                                        <img src="image/search-button.png" alt="" width="22" height="22" align="absmiddle"/>    -->
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
                            <h1>vionemc</h1>

                            <div class="profile_avatar"><img src="image/like.png" alt="vionemc" />            
                                <form id="fChangeAvatar" method="post" action="">
                                    <p>
                                        <label>
                                            <input name="inputAvatar" type="file" id="inputAvatar" accept="image/jpg, image/jpeg"/>
                                            <input type="submit" name="changeAvatar" id="changeAvatar" value="Change Avatar" />
                                        </label>
                                    </p>
                                </form>
                            </div>
                            <div class="info">
                                <table width="392" border="0">
                                    <tr>
                                        <td width="90" valign="top">Email</td>
                                        <td width="10" valign="top">:</td>
                                        <td width="278">vionemc@yahoo.com
                                            <form id="fChangeEmail" method="post" action="">
                                                <p>
                                                    <input name="inputEmail" type="text" id="inputEmail" />
                                                    <input type="submit" name="changeEmail" id="changeEmail" value="Change Email" />
                                                </p>
                                            </form>            </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Gender</td>
                                        <td valign="top">:</td>
                                        <td>Perempuan</td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Jml Komentar</td>
                                        <td valign="top">:</td>
                                        <td>21</td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Jml Post</td>
                                        <td valign="top">:</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <td valign="top">About Me</td>
                                        <td valign="top">:</td>
                                        <td><p>apa ya?</p>
                                            <p>apa ya?</p>
                                            <form id="fChangeAbout" method="post" action="">
                                                <p>
                                                    <textarea name="inputAbout" id="inputAbout" rows="5" cols="40"/></textarea>                
                                                    <input type="submit" name="changeAbout" id="changeAbout" value="Change About" />
                                                </p>
                                            </form></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="userPost">
                                <div id="myPost" class="post">
                                    <h2>My Post</h2>
                                </div>
                                <div class="post">
                                    Konten ditaro di sini
                                </div>

                            </div>
                        </div>
                        <!-- /#block -->

                    </div>
                    <div id="sidebar">  
                        <div class="block">
                            <div id="c60">
                                <h4><a href="http://www.chess.com/members/trophy_room/vionemc">Achievement</a></h4>
                                <div id="c61"></div><table border="0" align="center" cellpadding="0" cellspacing="0" class="trophysidebox">
                                    <tbody><tr><td width="137" align="center" valign="bottom">
                                                <div class="trophybox">
                                                    <div class="trophyname">Good Sportsmanship  	</div>
                                                    <img src="./Home - Chess_files/291-544.png" width="64" height="64" /></div>
                                            </td>
                                            <td width="137" align="center" valign="bottom">Keterangan Achievement</td>
                                        </tr><tr><td align="center" valign="bottom">
                                                <div class="trophybox">
                                                    <div class="trophyname">
                                                        Thank You Note  	</div>
                                                    <img src="./Home - Chess_files/101-953.png" width="64" height="64" /></div></td>
                                            <td align="center" valign="bottom">Keterangan Achievement</td>
                                        </tr> </tbody></table>
                                <div class="clear" style="text-align:center; font-size: 0.85em"><a href="">See all Trophies</a></div></div>
                        </div>
                    </div>

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
