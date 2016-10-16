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
                                            <option onClick="">All</option>
                                            <option onClick="">Username</option>
                                            <option onClick="">Content</option>
                                        </select>
                                        <input name="search" type="text" />
                                        <button id="searchB" class="searchButton" type="button" onClick="alert('search it');" />
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

        <div id="contents">          
            <div class="container-content">
              <div id="container_main">
                <div class="content_tag">
                        	<select name="tags" id="tags">
                    	      <option>Newest</option>
                              <option>Most Popular</option>
                              <option>Most Commented</option>
                  	      </select> 
                          <input name="Go" type="button" value="Sort"/>
                        <h3>Tag :</h3>
                        <input name="Filter" type="text" /><input name="Go" type="button" value="Go"/><br />
                        <ul>
                        	<li><a href="">Tag 1</a></li>
                            <li><a href="">Tag 2</a></li>
                            <li><a href="">Tag 3</a></li>
                        </ul>
                </div>
                <div id="content_list">
                <div class="container_full">
                        <div class="content">
                            <p>
                                CLICK>> <a href="">
                                    Sebuah situs yang secara ajaib mengembalikan pengunjungnya ke dunia nyata dan membangkitkan banyak introspeksi.
                                </a>
                            </p>
                        </div>
                        <div class="content_id">
                            <h1><a href="content.html">ol.akademik.itb.ac.id</a></h1>
                            <h4>by <a href="content.html">nandaep</a> 3 years ago </h4>
                            <h4><span id="like_0"></span> likes | 49999 comments </h4>
                            <script type="text/javascript">Randomize(document.getElementById('like_0'),-50000,50000);</script>
                            <button class="like" type="button" value="Like" onClick="Like(this, document.getElementById('like_0'));" />
                            <button class="dislike" type="button" value="Dislike" onClick="Like(this, document.getElementById('like_0'));" />
                        </div>
                        
                </div>
                    <div class="container_full">
                        <div class="content">    
                            <img alt="LOGO" src="image/frenzon.jpg" width="100%"/><br/>
                        </div>
                        <div class="content_id">
                            <h1><a href="content.html">Tugu Friendzone ITB</a></h1>
                            <h4>by <a href="content.html">ami</a> 3 years ago </h4>
                            <h4><span id="like_1"></span> likes | 49999 comments </h4>
                            <script type="text/javascript">Randomize(document.getElementById('like_1'),-50000,50000);</script>
                            <button class="like" type="button" value="Like" onClick="Like(this, document.getElementById('like_1'));" />
                            <button class="dislike" type="button" value="Dislike" onClick="Like(this, document.getElementById('like_1'));" />
                        </div>
                </div>
                    <div class="container_full">
                        <div class="content">  
                            <object type="application/x-shockwave-flash" width="600" height="400" data="http://www.youtube.com/v/imuT2vj1TaY?version=3&amp;hl=en_US">
                                <param name="movie" value="http://www.youtube.com/v/imuT2vj1TaY?version=3&amp;hl=en_US" />
                                <param name="allowFullScreen" value="true" />
                            </object>
                        </div>
                        <div class="content_id">
                            <h1><a href="content.html">SNSG - Pinter Ngaji</a></h1>
                            <h4>by <a href="content.html">ucup</a> 3 years ago </h4>
                            <h4><span id="like_2"></span> likes | 49999 comments </h4>
                            <script type="text/javascript">Randomize(document.getElementById('like_2'),-50000,50000);</script>
                            <button class="like" type="button" value="Like" onClick="Like(this, document.getElementById('like_2'));" />
                            <button class="dislike" type="button" value="Dislike" onClick="Like(this, document.getElementById('like_2'));" /> 
                        </div>
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
