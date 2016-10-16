<?php
include("connectdb.php");
//validasi masukan
$Email = $_GET['email'];
//validasi username
//cek ada username tsb di DB
$sql = "SELECT username FROM profil where email='" . $Email . "'";
$result = mysql_query($sql);
if (!$result) {
    die('Error : ' . mysql_error());
} else {
    if (mysql_num_rows($result) > 0) {
        echo "failed";
    }
}
?>
