<?php
session_start();
extract($_POST);
if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
    ?><script>alert("Anda sudah login sebagai member!");</script><?php
    //redirect anonymous
    $_SESSION['about'] = "";
    header("Location:index.php");
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
            <div class="clear"></div>
            <div class="container_header_top">
                <div class="container_header">
                    <div class="logop"> 
                        <?php
                        echo "USERNAME<input id='Uname' name='username' type='text' />";
                        echo "PASSWORD<input id='Upass' name='password' type='password' />";
                        echo "<input type = 'button' value = 'SIGN IN' name = 'signin' onclick = 'signIn(document.getElementById(" . '"Uname"' . ").value,document.getElementById(" . '"Upass"' . ").value);' />";
                        echo "|";
                        echo "<input type = 'button' value = 'SIGN UP' name = 'signup' onclick = 'window.location=" . '"register_form.php"' . ";' />";
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
            <form id="formRegister" enctype="multipart/form-data" method="post" action="php/register.php">
                <div id="container_main">
                    <label>Username</label>
                    <input type="text" name="username" id="username" value="<?php if (isset($_GET['username'])) echo$_GET['username'] ?>"/>
                    <div class="alert" id="notifUsername"><?php if (isset($_GET['Nusername'])) echo$_GET['Nusername'] ?></div>

                    <div class="clear"></div>

                    <label>Email</label>
                    <input type="text" name="email" id="email" value="<?php if (isset($_GET['email'])) echo$_GET['email'] ?>"/>
                    <label class="alert" id="notifEmail"><?php if (isset($_GET['Nemail'])) echo$_GET['Nemail'] ?></label>

                    <div class="clear"></div>

                    <label>Password</label>
                    <input type="password" name="password" id="password" value="<?php if (isset($_GET['password'])) echo$_GET['password'] ?>"/>
                    <label class="alert" id="notifPassword"><?php if (isset($_GET['Npassword'])) echo$_GET['Npassword'] ?></label>

                    <div class="clear"></div>

                    <label>Confirm Password</label>
                    <input type="password" name="cPassword" id="cPassword" value="<?php if (isset($_GET['cPassword'])) echo$_GET['cPassword'] ?>"/>
                    <label class="alert" id="notifCPassword"><?php if (isset($_GET['NcPassword'])) echo$_GET['NcPassword'] ?></label>

                    <div class="clear"></div>

                    <label>Nama Lengkap</label>
                    <input type="text" name="namaL" id="namaL" value="<?php if (isset($_GET['namaL'])) echo$_GET['namaL'] ?>"/>
                    <label class="alert" id="notifNama"><?php if (isset($_GET['NnamaL'])) echo$_GET['NnamaL'] ?></label>

                    <div class="clear"></div>

                    <label>Tanggal Lahir</label>
                    <input type="text" name="tgl" id="tgl" value="<?php if (isset($_GET['tgl'])) echo$_GET['tgl'] ?>"/>
                    <label class="alert" id="notifTanggal"><?php if (isset($_GET['Ntgl'])) echo$_GET['Ntgl'] ?></label>

                    <div class="clear"></div>

                    <label>Avatar</label>
                    <label id="avatar"></label>
                    <input name="inputAvatar" type="file" id="inputAvatar" accept="image" />
                    <label class="alert" id="notifAvatar"><?php if (isset($_GET['NinputAvatar'])) echo$_GET['NinputAvatar'] ?></label>

                    <div class="clear"></div>

                    <label>Gender</label>
                    <select name="gender" id="gender">
                        <option <?php if (isset($_GET['gender']) && $_GET['gender'] === "Pilih Gender") echo"selected='true'"; ?>>Pilih Gender</option>
                        <option <?php if (isset($_GET['gender']) && $_GET['gender'] === "Laki-laki") echo"selected='true'"; ?>>Laki-laki</option>
                        <option <?php if (isset($_GET['gender']) && $_GET['gender'] === "Perempuan") echo"selected='true'"; ?>>Perempuan</option>
                    </select>
                    <label class="alert" id="notifGender"><?php if (isset($_GET['Ngender'])) echo$_GET['Ngender'] ?></label>

                    <div class="clear"></div>

                    <label>About Me</label>
                    <textarea name="about" COLS=40 ROWS=10 id="about" style="height:100px; width:450px; max-height:100px; max-width:450px;"><?php if (isset($_SESSION['about'])) echo$_SESSION['about'] ?></textarea>

                    <div class="clear"></div>

                    <input type="submit" id="verify" value="Verify" onclick="window.location('php/register.php')" />
<!--                    <input type="button" id="submitRegister" value="Register" onclick="redirectSave()"  />-->
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
<?php $_SESSION['about'] = "" ?>