<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'connectdb.php';
session_start();
$username=$_GET['username'];
$password=$_GET['password'];

// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

$sql="SELECT * FROM profil WHERE username='$username' and password='$password'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $username and $password, table row must be 1 row

if($count==1){
// Register $username, $password and redirect to file "login_success.php"
$_SESSION['username'] = $username;
echo "success";
}
else {
echo "failed";
}

ob_end_flush();
?>
