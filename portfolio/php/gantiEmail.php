<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$gantiEmail = $_POST['inputEmail'];
$username = $_GET['username'];
if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $gantiEmail)) {
    $IsValid = false;
    $noticeEmail = "Masukkan email yang valid";
  header("Location:../profile.php?username=" . $username . "&email=" . $gantiEmail . "&noticeEmail=" . $noticeEmail);
} else {
    //cek ada username tsb di DB
    require 'connectdb.php';
    $sql = "SELECT username FROM profil where email='" . $Email . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die('Error : ' . mysql_error());
    } else {
        if (mysql_num_rows($result) > 0) {
            $IsValid = false;
            $noticeEmail = "Email sudah ada di database!";
            header("Location:../profile.php?username=$username&email=$gantiEmail" . "&noticeEmail=" . $noticeEmail);
        } else {
            require 'connectdb.php';
            $sql = "UPDATE profil SET email = '$gantiEmail' where username = '$username'";
            $result = mysql_query($sql);
            if ($result) {
                header("Location:../profile.php?username=" . $username);
            }
        }
    }
}
?>
