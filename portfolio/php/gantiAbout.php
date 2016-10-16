<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $gantiAbout = $_POST['inputAbout'];
    $username = $_GET['username'];

    require 'connectdb.php';
    $sql = "UPDATE profil SET about_me = '$gantiAbout' where username = '$username'";
    
    $result = mysql_query($sql);
    //$num = mysql_affected_rows($result);
    if ($result){
        header("Location:../profile.php?username=".$username);
    }
?>
