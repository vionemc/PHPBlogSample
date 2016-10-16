<?php
session_start();
if (!isset($_SESSION['username']) || (isset($_SESSION['username']) && strlen($_SESSION['username']) == 0)) {
    //redirect anonymous
    header("Location:index.php");
} else {
    include("php/connectdb.php");
    //ambil info username
    $sql = "SELECT * FROM profil WHERE username='" . $_SESSION['username'] . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die(mysql_error());
    }
    $user = mysql_fetch_array($result);
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
<body id="post">
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
            <form id="postForm" enctype="multipart/form-data" method="post" action="upload_img.php">
                <div id="container_main">
                    <label>Judul</label>
                    <input type="text" name="title" id="title" />

                    <div class="clear"></div>

                    <label>Jenis Post</label>
                    <input type="radio" name="postType" value="URL" id="postType_0" onchange="ChangeForm();" /><label>URL</label>
                    <input type="radio" name="postType" value="Image" id="postType_1" onchange="ChangeForm();" /><label>Image</label>
                    <input type="radio" name="postType" value="Video" id="postType_2" onchange="ChangeForm();" /><label>Video</label>

                    <div class="clear"></div>

                    <label>URL</label>
                    <input name="url" type="text" disabled="disabled" id="url" style="background: #CC0000;"/>

                    <div class="clear"></div>

                    <label>Deskripsi URL</label>
                    <textarea rows="5" name="desc" cols="45" id="desc" style="background: #CC0000; max-width: 450px; max-height: 180px; margin-left: 0px; margin-right: 0px; width: 457px; margin-top: 0px; margin-bottom: 0px; height: 200px; "></textarea>
                    <div class="clear"></div>

                    <label>Image</label>
                    <label id="avatar"></label>
                    <input id="picture" type="file" accept="image" name="picture" disabled="disabled" style="background: #CC0000;"/>

                    <div class="clear"></div>

                    <label>Link Video</label>
                    <input name="video" type="text" disabled="disabled" id="video" style="background: #CC0000;"/>

                    <div class="clear"></div>

                    <label>Tag</label>
                    <input name="tag" type="text" disabled="disabled" id="tagContent" style="background: #CC0000;"/>					

                    <div class="clear"></div>

                    <input type="button" value="Preview"  onclick="PreviewPost();"/>
                    <input type="button" value="Post"  onclick="PostContent(<?php echo "'" . $_SESSION['username'] . "'" ?>);"/>                    
                    <h2 id="preview"></h2>

                    <div class="clear"></div>					

                    <p id="contentview"></p>
                </div>
            </form>
        </div>

    </div>

    <div id="footer">
        <div class="container_footer">
            © 2011   ·   <a href="">About</a>   ·   <a href="">Rules</a>   ·   <a href="">FAQ</a>   ·   <a href="">People</a>   ·   <a href="">Top</a>   ·   <a href="">Terms</a>   ·   <a href="">Privacy</a>   ·   <a href="">Contact Us</a>
        </div>
    </div>

</body>
</html>
