<?php
include ("connectdb.php");
session_start();
//cek username
if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
    $idpost = $_GET['idpost'];
    $tipe = $_GET['tipe'];
    $username = $_SESSION['username'];
    //ambil post
    $sql = "SELECT * FROM konten WHERE id_post='" . $idpost . "'";
    $result = mysql_query($sql);
    if (!$result) {
        echo "Error updateLike.php1 : " . mysql_error();
    }
    $konten = mysql_fetch_array($result);
    //update tabel konten    
    if ($tipe === "like") {
        $sql = "UPDATE konten SET jumlah_like=jumlah_like+1 WHERE id_post='" . $idpost . "'";
    } else if ($tipe === "hate") {
        $sql = "UPDATE konten SET jumlah_dislike=jumlah_dislike+1 WHERE id_post='" . $idpost . "'";
    } else if ($tipe === "unlike") {
        $sql = "UPDATE konten SET jumlah_like=jumlah_like-1 WHERE id_post='" . $idpost . "'";
    } else if ($tipe === "unhate") {
        $sql = "UPDATE konten SET jumlah_dislike=jumlah_dislike-1 WHERE id_post='" . $idpost . "'";
    }
    $result = mysql_query($sql);
    if (!$result) {
        echo "Error updateLike.php2 : " . mysql_error();
    }
    //update tabel profil pembuat post
    if ($tipe === "like") {
        $count = $_GET['count'];
        //update jika jumlah like lebih banyak daripada yang ada di profil
        $sql = "SELECT achievement_like FROM profil WHERE username='" . $konten['username'] . "'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if ($count > $row['achievement_like']) {
            $sql = "UPDATE profil SET achievement_like='" . $count . "' WHERE username='" . $konten['username'] . "'";
            $result = mysql_query($sql);
            if (!$result) {
                echo "Error updateLike.php3 : " . mysql_error();
            }
        }
    } else if ($tipe === "hate") {
        $count = $_GET['count'];
        //update jika jumlah hate lebih banyak daripada yang ada di profil
        $sql = "SELECT achievement_dislike FROM profil WHERE username='" . $konten['username'] . "'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        if ($count > $row['achievement_dislike']) {
            $sql = "UPDATE profil SET achievement_dislike='" . $count . "' WHERE username='" . $konten['username'] . "'";
            $result = mysql_query($sql);
            if (!$result) {
                echo "Error updateLike.php4 : " . mysql_error();
            }
        }
    }
    //update tabel liker
    $sql = "SELECT * FROM liker WHERE username='" . $username . "' AND id_post='" . $idpost . "'";
    $result = mysql_query($sql);
    if (!$result) {
        echo "Error updateLike.php5 : " . mysql_error();
    }
    if (mysql_num_rows($result) == 0) {
        if ($tipe === "like") {
            $sql = "INSERT INTO liker(id_post,username,`like`) VALUES('$idpost','$username','like')";
        } else if ($tipe === "hate") {
            $sql = "INSERT INTO liker(id_post,username,`like`) VALUES('$idpost','$username','dislike')";
        } else if ($tipe === "unlike" || $tipe === "unhate") {
            $sql = "INSERT INTO liker(id_post,username,`like`) VALUES('$idpost','$username','netral')";
        }
        $result = mysql_query($sql);
        if (!$result) {
            echo "Error updateLike.php6 : " . mysql_error();
        }
    } else if (mysql_num_rows($result) == 1) {
        if ($tipe === "like") {
            $sql = "UPDATE liker SET `like`='like' WHERE id_post='" . $idpost . "' AND username='" . $username . "'";
        } else if ($tipe === "hate") {
            $sql = "UPDATE liker SET `like`='dislike' WHERE id_post='" . $idpost . "' AND username='" . $username . "'";
        } else if ($tipe === "unlike" || $tipe === "unhate") {
            $sql = "UPDATE liker SET `like`='netral' WHERE id_post='" . $idpost . "' AND username='" . $username . "'";
        }
        $result = mysql_query($sql);
        if (!$result) {
            echo "Error updateLike.php7 : " . mysql_error();
        }
    }
    echo "success";
} else {
    echo "failed";
}
mysql_close($con);
?>
