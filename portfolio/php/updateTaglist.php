<?php

/////////////Bagian yand diubah////////////////////////////
$IsValid = true;
$tipePost = "";
$judul = $_GET['judul'];
$Username = $_GET['username'];
$isi = $_GET['isi'];
$tag = $_GET['tag'];
//validasi url
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $noticeUrl = "";
    $tipePost = "url";
    if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)) {
        $IsValid = false;
        $noticeUrl = "Masukkan URL yang valid";
    } else {
        $IsValid = true;
    }
}

//validasi video
//if (isset($_GET['video'])) {
//    $video = $_GET['video'];
//    $noticeVideo = "";
//    $tipePost = "video";
//    if (!preg_match('|https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube.com\/watch\?)((?:[\w\d-_\=]+&(?:amp;)?)*v(?:<[A-Z]+>)?=([0-9a-zA-Z-_]+))/|i', $video)) {
//        $IsValid = false;
//        $noticeVideo = "Masukkan video youtube yang valid";
//    } else {
//        $IsValid = true;
//    }
//}

if ($IsValid == false) {
    if ($tipePost === "url") {
        echo "post.php?username=$Username&Nurl=$noticeUrl&url=$url&judul=$judul&isi=$isi&tag=$tag";
    } 
    else if ($tipePost === "video") {
        echo "post.php?username=$Username&Nvideo=$noticeVideo&video=$video&judul=$judul&isi=$isi&tag=$tag";
    }
} else {
    include ("connectdb.php");
    $waktu = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
//ambil id max
    $sql = "SELECT MAX(id_post) AS id_posts FROM konten";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if (mysql_num_rows($result) == 0) {
        $idTemp = 1;
    } else {
        $idTemp = $row['id_posts'] + 1;
    }
    $isi = str_replace("none", $idTemp, $isi);
    $isi = str_replace("'", "''", $isi);
    $judul = str_replace("'", "''", $judul);
    $sql = "INSERT INTO konten (id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike) VALUES('$idTemp','$judul','$Username','$isi','$waktu',0,0)";
    $result = mysql_query($sql);
    if (!$result) {
        echo "Error insert konten" . $sql . mysql_error() . "\n";
    } else {
        //update achievement post
        $sql = "SELECT achievement_post FROM profil WHERE username='" . $Username . "'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $achieve = $row['achievement_post'] + 1;
        $sql = "UPDATE profil SET achievement_post='" . $achieve . "' WHERE username='" . $Username . "'";
        $result = mysql_query($sql);
        if (!$result) {
            echo "Error : " . mysql_error();
        } else {
            echo $idTemp;
        }
    }
//jika ada tag, proses tag tersebut
    if ($tag !== "" && preg_replace('/\s\s+/', '', $tag) !== "") {
        //pisahkan semua tag yang dipisah oleh koma
        $tag = explode(',', $tag);
        //proses tiap tag untuk masuk ke tabel taglist
        for ($i = 0; $i < count($tag); $i++) {
            if ($tag[$i] !== "") {
                //cari tag dengan nama sama di database
                $sql = "SELECT * FROM taglist WHERE id_post='" . $idTemp . "' AND tag_name='" . $tag[$i] . "'";
                $result = mysql_query($sql);
                if (!$result) {
                    echo "Error search taglist " . $sql . mysql_error() . "\n";
                } else {
                    if (mysql_num_rows($result) == 0) {
                        $sql = "INSERT INTO taglist (id_post,tag_name) VALUES('$idTemp','$tag[$i]')";
                        $result = mysql_query($sql);
                        if (!$result) {
                            echo "Error insert taglist " . $sql . mysql_error() . "\n";
                        }
                    }
                }
            }
        }
    }
    mysql_close($con);
}
?>
