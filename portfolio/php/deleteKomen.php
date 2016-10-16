<?php
include ("connectdb.php");
session_start();
$idpost = $_GET['idpost'];
$username = $_GET['username'];
$waktu = $_GET['waktu'];
$sql = "DELETE FROM komentar WHERE id_post=" . $idpost . " AND username='" . $username . "' AND waktu_comment='" . $waktu . "'";
$result = mysql_query($sql);
if (!$result) {
    echo $sql . mysql_error();
} else {
    $sql = "SELECT * FROM konten WHERE id_post=" . $_GET['idpost'];
    $result = mysql_query($sql);
    if (!$result) {
        header("Location:../error404.php");
        die("Error : " . mysql_error());
        //no such page exist
    } else {
        $row = mysql_fetch_array($result);
        if (mysql_num_rows($result) == 0) {
            //no such page exist
            header("Location:../error404.php");
        }
        //ambil avatarPath
        if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
            $avatarPath = "dummy";
            $sql = "SELECT avatar FROM profil WHERE username='" . $_SESSION['username'] . "'";
            $result = mysql_query($sql);
            $row1 = mysql_fetch_array($result);
            $avatarPath = $row1['avatar'];
        }
        //ambil list komentar
        $sql = "SELECT * FROM komentar WHERE id_post=" . $_GET['idpost'] . " ORDER BY waktu_comment DESC";
        $result = mysql_query($sql);
        $i = 0;
        $komen = NULL;
        while ($row1 = mysql_fetch_array($result)) {
            $komen[$i] = $row1;
            $i++;
        }
    }
    echo "<div class='container_full'>";
    if ($_GET['idpost'] === "'none'") {
        echo "none = " . $_GET['isi'];
    } else {
        //ambil isi dari database
        $row['isi_konten'] = preg_replace("/\"/", "'", $row['isi_konten']);
        $row['isi_konten'] = str_replace("*", "&", $row['isi_konten']);
        echo $row['isi_konten'];
    }
    echo "<h4>by <a href='profile.php?username=";
    echo $row['username'] . "'>";
    echo $row['username'] . "</a>";

    $d1 = strtotime($row['waktu_dipost']);
    $d2 = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
    $d2 = strtotime($d2);
    $diff = $d2 - $d1;

    if ($diff >= 0 && $diff <= 60) {
        echo " ".(floor($diff)) . " seconds";
    } else if ($diff > 60 && $diff <= 3600) {
        echo " ".(floor($diff / 60)) . " minutes";
    } else if ($diff > 3600 && $diff <= 86400) {
        echo " ".(floor($diff / 3600)) . " hours";
    } else if ($diff > 86400) {
        echo " ".(floor($diff / 86400)) . " days";
    }
    echo " ago </h4>";
    echo "</div>";

    if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
        //echo komentar
        echo "<div class = 'container_full'>";
        echo "<h2>Komentar</h2>";
        echo "<textarea name = 'Komentar' id = 'Komentar' cols = '40' rows = '10' style = 'height: 100px; width: 450px;max-height: 100px; max-width: 450px;'></textarea><br />";
        echo "<input type = 'button' value = 'Submit' name = 'SubmitComment' onclick = 'Comment(document.getElementById(" . '"Komentar"' . ").value, document.getElementById(" . '"commentList"' . ")," . '"' . $_SESSION['username'] . '"' . "," . '"' . $row['id_post'] . '"' . "," . '"' . $avatarPath . '"' . ");' />";
        echo "</div>";
        echo "<div id = 'commentList'>";
        for ($i = 0; $i < count($komen); $i++) {
            echo "<div class = 'container_full'>";
            $komen[$i]['isi_komentar'] = preg_replace("/\"/", "'", $komen[$i]['isi_komentar']);
            $komen[$i]['isi_komentar'] = str_replace("*", "&", $komen[$i]['isi_komentar']);
            echo $komen[$i]['isi_komentar'];
            echo "<h6 style='font-style:italic;'>";
            $d1 = strtotime($komen[$i]['waktu_comment']);
            $d2 = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
            $d2 = strtotime($d2);
            $diff = $d2 - $d1;
            if ($diff >= 0 && $diff <= 60) {
                echo (floor($diff)) . " seconds";
            } else if ($diff > 60 && $diff <= 3600) {
                echo (floor($diff / 60)) . " minutes";
            } else if ($diff > 3600 && $diff <= 86400) {
                echo (floor($diff / 3600)) . " hours";
            } else if ($diff > 86400) {
                echo (floor($diff / 86400)) . " days";
            }
            echo " ago </h6>";
            //jika komentar user, sediakan hyperlink untuk hapus komen
            if ($komen[$i]['username'] === $_SESSION['username']) {
                echo "<input type = 'button' value = 'Delete' name = 'Delete' onclick = 'deleteComment(" . '"' . $komen[$i]['id_post'] . '"' . "," . '"' . $komen[$i]['username'] . '"' . "," . '"' . $komen[$i]['waktu_comment'] . '"' . ");' />";
            }
            echo "</div>";
        }
        echo "</div>";
    }
    mysql_close($con);
}
?>
