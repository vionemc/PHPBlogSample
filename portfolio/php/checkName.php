<?php
include("connectdb.php");
//validasi masukan
$Username = $_GET['name'];
//validasi username
//cek ada username tsb di DB
$sql = "SELECT username FROM profil where username='" . $Username . "'";
$result = mysql_query($sql);
if (!$result) {
    die('Error : ' . mysql_error());
} else {
    if (mysql_num_rows($result) > 0) {
        echo "failed";
    }
}
?>
