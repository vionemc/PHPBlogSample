<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("connectdb.php");
session_start();
//$gantiAvatar = $_POST['inputAvatar'];
extract($_POST);
$username = $_GET['username'];
$gantiAvatar = $_FILES["inputAvatar"]["name"];

$ext = end(explode('.', $gantiAvatar));
$ext = strtolower($ext);
if ($ext !== "jpg" && $ext !== "jpeg") {
    $noticeImage = "Masukkan file jpg atau jpeg";
    header("Location:../profile.php?username=" . $username .
            "&inputAvatar=" . $gantiAvatar .
            "&NinputAvatar=" . $noticeImage
    );
} else {//masukan valid
    //copy file image
    move_uploaded_file($_FILES["inputAvatar"]["tmp_name"], "../avatars/" . $_FILES["inputAvatar"]["name"]);
    if ($_FILES["inputAvatar"]["name"] === "") {
        if ($Gender === "Laki-laki") {
            $Image = "avatars/avatar-male.gif";
        } else if ($Gender === "Perempuan") {
            $Image = "avatars/avatar-female.gif";
        }
    } else {
        $gantiAvatar = "avatars/" . $_FILES["inputAvatar"]["name"];
    }

    require 'connectdb.php';
    $sql = "UPDATE profil SET avatar = '$gantiAvatar' where username = '$username'";

    $result = mysql_query($sql);
    //$num = mysql_affected_rows($result);
    if ($result) {
        header("Location:../profile.php?username=" . $username);
    }
}
?>
