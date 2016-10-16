<?php

include ("php/connectdb.php");
session_start();
extract($_POST);
//copy file image
move_uploaded_file($_FILES["picture"]["tmp_name"], "pictures/" . $_FILES["picture"]["name"]);
//masukkan ke database
$sql = "SELECT MAX(id_post) AS id_posts FROM konten";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if (mysql_num_rows($result) == 0) {
    $idTemp = 1;
} else {
    $idTemp = $row['id_posts'] + 1;
}
//konstruksi isi post
$isi = '<h1><a href = "content.php?idpost=' . $idTemp . '">' . $_POST['title'] . '</a></h1>' .
        '<div class="clear"></div>' .
        '<img src="pictures/' . $_FILES["picture"]["name"] . '" width="100%" /><br />';
$judul = $_POST['title'];
$username = $_SESSION['username'];
$waktu = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
$judul = str_replace("'", "''", $judul);
$isi = str_replace("none", $idTemp, $isi);
$isi = str_replace("'", "''", $isi);
//update database
$sql = "INSERT INTO konten (id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike) VALUES('$idTemp','$judul','$username','$isi','$waktu',0,0)";
$result = mysql_query($sql);
if (!$result) {
    die($sql . mysql_error());
} else {
    //update achievement post
    $sql = "SELECT achievement_post FROM profil WHERE username='" . $username . "'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $achieve = $row['achievement_post'] + 1;
    $sql = "UPDATE profil SET achievement_post='" . $achieve . "' WHERE username='" . $username . "'";
    $result = mysql_query($sql);
    if (!$result) {
        echo "Error : " . mysql_error();
    } else {
        $sql = "SELECT achievement_post FROM profil WHERE username='" . $username . "'";
        $result = mysql_query($sql);
        if (!$result) {
            echo $sql . mysql_error();
        } else {
            $row = mysql_fetch_array($result);
            if ($row['achievement_post'] == 1) {
                ?><script>alert("Selamat! Anda mendapat Achievement \'First Post\' !"); window.location="content.php?idpost=<?php echo$idTemp?>";</script><?php
            } else if ($row['achievement_post'] == 20) {
                ?><script>alert("Selamat! Anda mendapat Achievement \'Future Journalistt\' !"); window.location="content.php?idpost=<?php echo$idTemp?>";</script><?php
            }else{
                ?><script>alert("Jumlah");</script><?php                
            }
            mysql_close($con);
        }
    }
}
?>