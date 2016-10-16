<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$con = mysql_connect("localhost", "progin", "progin");
if (!$con) {
    die('Koneksi gagal dilakukan: ' . mysql_error());
}

mysql_select_db("progin_171_13509042", $con);
?>
