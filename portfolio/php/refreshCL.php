<?php

session_start();
include("connectdb.php");
extract($_POST);

if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
    //ambil info username
    $sql = "SELECT * FROM profil WHERE username='" . $_SESSION['username'] . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die(mysql_error());
    }
    $user = mysql_fetch_array($result);
}
//ambil info current filter    
//ambil list filter
$sql = "SELECT DISTINCT tag_name FROM taglist";
$result = mysql_query($sql);
if (!$result) {
    die(mysql_error());
}
$i = 0;
while ($row = mysql_fetch_array($result)) {
    $tag[$i] = $row['tag_name'];
    $i++;
}
//paginasi
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
//ambil tag
if (isset($_GET['tag'])) {//1 tag
    $query = "SELECT count(*) FROM konten,taglist WHERE konten.id_post=taglist.id_post AND tag_name='" . $_GET['tag'] . "'";
} else if (isset($_GET['tags'])) {//>1 tag
    $tags = $_GET['tags'];
//jika ada tag, proses tag tersebut
    if ($tags !== "" && preg_replace('/\s\s+/', '', $tags) !== "") {
        //pisahkan semua tag yang dipisah oleh koma
        $tags = explode(',', $tags);
        //proses tiap tag untuk currTag dan klausa where
        $currTag = "";
        $whereTag = "";
        for ($i = 0; $i < count($tags); $i++) {
            if ($tags[$i] !== "") {
                $currTag = $currTag . $tags[$i] . ",";
                $whereTag = $whereTag . "tag_name='$tags[$i]' OR ";
            }
        }
        //hapus or terakhir
        $whereTag = substr($whereTag, 0, strlen($whereTag) - 4);
        $currTag = substr($currTag, 0, strlen($currTag) - 1);
        $query = "SELECT count(*) FROM konten,taglist WHERE konten.id_post=taglist.id_post AND ($whereTag)";
    }
} else {
    $query = "SELECT count(*) FROM konten";
}
$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);
$query_data = mysql_fetch_row($result);
$numrows = $query_data[0];
$rows_per_page = 6;
$lastpage = ceil($numrows / $rows_per_page);
$pageno = (int) $pageno;
if ($pageno > $lastpage) {
    $pageno = $lastpage;
}
if ($pageno < 1) {
    $pageno = 1;
}
$limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;

//ambil sort
if (isset($_GET['tag'])) {
    if (isset($_GET['sort'])) {
        $currTag = $_GET['tag'];
        if ($_GET['sort'] === "Most Popular") {
            $query = "SELECT * FROM konten,taglist WHERE konten.id_post=taglist.id_post AND tag_name='$currTag' ORDER BY jumlah_like DESC $limit";
        } else if ($_GET['sort'] === "Most Commented") {
            $query = "SELECT * FROM konten,taglist WHERE konten.id_post=taglist.id_post AND tag_name='$currTag' ORDER BY (SELECT COUNT(*) FROM komentar WHERE konten.id_post = komentar.id_post) DESC $limit";
        } else if ($_GET['sort'] === "Newest") {
            $query = "SELECT * FROM konten,taglist WHERE konten.id_post=taglist.id_post AND tag_name='$currTag' ORDER BY waktu_dipost DESC $limit";
        }
    } else {
        $query = "SELECT * FROM konten WHERE konten.id_post=taglist.id_post AND tag_name='$currTag' ORDER BY waktu_dipost DESC $limit";
    }
} else if (isset($_GET['tags'])) {
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] === "Most Popular") {
            $query = "SELECT DISTINCT konten.id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike FROM konten LEFT OUTER JOIN taglist ON konten.id_post=taglist.id_post WHERE ($whereTag) ORDER BY jumlah_like DESC $limit";
        } else if ($_GET['sort'] === "Most Commented") {
            $query = "SELECT DISTINCT konten.id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike FROM konten LEFT OUTER JOIN taglist ON konten.id_post=taglist.id_post WHERE ($whereTag) ORDER BY (SELECT COUNT(*) FROM komentar WHERE konten.id_post = komentar.id_post) DESC $limit";
        } else if ($_GET['sort'] === "Newest") {
            $query = "SELECT DISTINCT konten.id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike FROM konten LEFT OUTER JOIN taglist ON konten.id_post=taglist.id_post WHERE ($whereTag) ORDER BY waktu_dipost DESC $limit";
        }
    } else {
        $query = "SELECT DISTINCT konten.id_post,judul,username,isi_konten,waktu_dipost,jumlah_like,jumlah_dislike FROM konten LEFT OUTER JOIN taglist ON konten.id_post=taglist.id_post ($whereTag) ORDER BY waktu_dipost DESC $limit";
    }
//    die("query =^".$query."^");
} else {
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] === "Most Popular") {
            $query = "SELECT * FROM konten ORDER BY jumlah_like DESC $limit";
        } else if ($_GET['sort'] === "Most Commented") {
            $query = "SELECT * FROM konten ORDER BY (SELECT COUNT(*) FROM komentar WHERE konten.id_post = komentar.id_post) DESC $limit";
        } else if ($_GET['sort'] === "Newest") {
            $query = "SELECT * FROM konten ORDER BY waktu_dipost DESC $limit";
        }
    } else {
        $query = "SELECT * FROM konten ORDER BY waktu_dipost DESC $limit";
    }
}

$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);
$i = 0;
while ($row1 = mysql_fetch_array($result)) {
    $konten[$i] = $row1;
    //proses format konten
    $konten[$i]['isi_konten'] = preg_replace("/\"/", "'", $konten[$i]['isi_konten']);
    $konten[$i]['isi_konten'] = str_replace("*", "&", $konten[$i]['isi_konten']);
    //sesuaikan width dan height untuk post video
//        if (strpos($konten[$i]['isi_konten'], "application/x-shockwave-flash") !== false) {
//            $konten[$i]['isi_konten'] = str_replace("600", "500", $konten[$i]['isi_konten']);
//            $konten[$i]['isi_konten'] = str_replace("400", "300", $konten[$i]['isi_konten']);
//        }
    //remove a href dan isinya mulai dari a href kedua
    $idxA = strpos($konten[$i]['isi_konten'], "<a href");
    $idxA = strpos($konten[$i]['isi_konten'], "<a href", $idxA + 1);
    if ($idxA !== false) {
        $sub1 = substr($konten[$i]['isi_konten'], 0, $idxA);
        $sub2 = substr($konten[$i]['isi_konten'], $idxA);
        $sub2 = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $sub2);
        $sub2 = str_replace("<a href=\"", "", $sub2);
        $sub2 = preg_replace("#\">()</a>#", "", $sub2);
        $konten[$i]['isi_konten'] = $sub1 . $sub2;
    }
    //pisahkan judul dan konten
    $idx1 = strpos($konten[$i]['isi_konten'], "<div class='clear'></div>");
    $idx1+=25;
    $konten[$i]['judul'] = substr($konten[$i]['isi_konten'], 0, $idx1);
    $konten[$i]['inti'] = substr($konten[$i]['isi_konten'], $idx1);
    //ambil jumlah komentar
    $sql1 = "SELECT COUNT(*) FROM komentar WHERE id_post='" . $konten[$i]['id_post'] . "'";
    $result1 = mysql_query($sql1);
    if (!$result1) {
        die("Error fetch bestL =" . mysql_error());
    }
    $row2 = mysql_fetch_array($result1);
    $konten[$i]['jumlah_komen'] = $row2['COUNT(*)'];
    $i++;
}
//ambil jenis sort
$sort = "Newest";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}
?>
<?php

echo "<div class ='container_full' style='text-align: center'>";
if ($numrows > 0) {
    if (!isset($_GET['tag'])) {
        if ($pageno == 1) {
            echo " FIRST PREV ";
        } else {
            echo " <a href='content_list.php?sort=$sort'>FIRST</a> ";
            $prevpage = $pageno - 1;
            echo " <a href='content_list.php?sort=$sort&pageno=$prevpage'>PREV</a> ";
        }
        echo " ( Page $pageno of $lastpage ) ";
        if ($pageno == $lastpage) {
            echo " NEXT LAST ";
        } else {
            $nextpage = $pageno + 1;
            echo " <a href='content_list.php?sort=$sort&pageno=$nextpage'>NEXT</a> ";
            echo " <a href='content_list.php?sort=$sort&pageno=$lastpage'>LAST</a> ";
        }
    } else {
        if ($pageno == 1) {
            echo " FIRST PREV ";
        } else {
            echo " <a href='content_list.php?sort=$sort&tag=$currTag'>FIRST</a> ";
            $prevpage = $pageno - 1;
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$prevpage'>PREV</a> ";
        }
        echo " ( Page $pageno of $lastpage ) ";
        if ($pageno == $lastpage) {
            echo " NEXT LAST ";
        } else {
            $nextpage = $pageno + 1;
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$nextpage'>NEXT</a> ";
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$lastpage'>LAST</a> ";
        }
    }
}
echo "</div>";
echo "<div class='container_full'>";
?>
<?php
echo "<b><span style = 'font-size: 20px'>Current Filter :</span><span id = 'currFilter' style = 'font-size: 20px'>";
if (!isset($_GET['tag']) && !isset($_GET['tags'])) {
    echo "No-Filter";
} else {
    echo $currTag;
}
echo "</span></b>";
echo "</div>";
?>
<?php

if ($numrows == 0) {
    echo "<div class='container_full'>";
    echo "<b><span style='font-size: 40px; color:red'>No such content found! :(</span></b><br/>";
//                        echo "<h1 style='color:red'></h1>";
    echo "</div>";
} else {
    for ($i = 0; $i < count($konten); $i++) {
        echo "<div class='container_full'>";
        echo "<div class='content'>";
        echo $konten[$i]['inti'];
        echo "</div>";
        echo "<div class = 'content_id'>";
        echo $konten[$i]['judul'];
        echo "<div class='clear'></div>";
        echo "<h4>by <a href='profile.php?username=";
        echo $konten[$i]['username'] . "'>";
        echo $konten[$i]['username'] . "</a>";

        $d1 = strtotime($konten[$i]['waktu_dipost']);
        $d2 = gmdate('Y-m-d H:i:s', time() + (7 * 60 * 60));
        $d2 = strtotime($d2);
        $diff = $d2 - $d1;
        if ($diff >= 0 && $diff <= 60) {
            echo " " . (floor($diff)) . " seconds";
        } else if ($diff > 60 && $diff <= 3600) {
            echo " " . (floor($diff / 60)) . " minutes";
        } else if ($diff > 3600 && $diff <= 86400) {
            echo " " . (floor($diff / 3600)) . " hours";
        } else if ($diff > 86400) {
            echo " " . (floor($diff / 86400)) . " days";
        }
        echo " ago </h4>";
        echo "<div class = 'clear'></div>";
        echo "<h4><span id = 'stat_like_" . $i . "'>";
        echo "</span></h4><h4>";
        echo "<span id='like_" . $i . "' style='color:#458B00'>" . $konten[$i]['jumlah_like'] . "</span>";
        echo " <span style='color:#458B00'>likes</span> | ";
        echo "<span id='hate_" . $i . "' style='color:#8B1A1A'>" . $konten[$i]['jumlah_dislike'] . "</span> <span style='color:#8B1A1A'>dislikes</span> | " . $konten[$i]['jumlah_komen'] . " comments </h4>";
        //cek status like user terhadap post
        if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
            $sql = "SELECT * FROM liker WHERE id_post='" . $konten[$i]['id_post'] . "' AND username = '" . $_SESSION['username'] . "'";
            $result = mysql_query($sql);
            if (mysql_num_rows($result) == 0) {
                echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
            } else if (mysql_num_rows($result) == 1) {
                $row = mysql_fetch_array($result);
                $tipe = $row['like'];
                if ($tipe === "like") {
                    echo "<script>changeStatLike('stat_like_" . $i . "','You like this');</script>";
                    echo "<button id='likeit_" . $i . "' class='unlike' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                    echo "<button style='visibility:hidden' id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                } else if ($tipe === "dislike") {
                    echo "<script>changeStatLike('stat_like_" . $i . "','You dislike this');</script>";
                    echo "<button style='visibility:hidden' id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                    echo "<button id='hateit_" . $i . "' class='unhate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                } else if ($tipe === "netral") {
                    echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                    echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
                }
            }
        } else {
            echo "<button id='likeit_" . $i . "' class='like' type='button' onclick='LikeThis(" . '"likeit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
            echo "<button id='hateit_" . $i . "' class='hate' type='button' onclick='LikeThis(" . '"hateit_' . $i . '"' . ", " . '"' . $i . '"' . "," . '"' . $konten[$i]['id_post'] . '"' . ");' />";
        }
        echo "</div>";
        echo "</div>";
    }
}
?>
<?php

if ($numrows > 0) {
    echo "<div class ='container_full' style='text-align: center'>";
    if (!isset($_GET['tag'])) {
        if ($pageno == 1) {
            echo " FIRST PREV ";
        } else {
            echo " <a href='content_list.php?sort=$sort'>FIRST</a> ";
            $prevpage = $pageno - 1;
            echo " <a href='content_list.php?sort=$sort&pageno=$prevpage'>PREV</a> ";
        }
        echo " ( Page $pageno of $lastpage ) ";
        if ($pageno == $lastpage) {
            echo " NEXT LAST ";
        } else {
            $nextpage = $pageno + 1;
            echo " <a href='content_list.php?sort=$sort&pageno=$nextpage'>NEXT</a> ";
            echo " <a href='content_list.php?sort=$sort&pageno=$lastpage'>LAST</a> ";
        }
    } else {
        if ($pageno == 1) {
            echo " FIRST PREV ";
        } else {
            echo " <a href='content_list.php?sort=$sort&tag=$currTag'>FIRST</a> ";
            $prevpage = $pageno - 1;
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$prevpage'>PREV</a> ";
        }
        echo " ( Page $pageno of $lastpage ) ";
        if ($pageno == $lastpage) {
            echo " NEXT LAST ";
        } else {
            $nextpage = $pageno + 1;
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$nextpage'>NEXT</a> ";
            echo " <a href='content_list.php?sort=$sort&tag=$currTag&pageno=$lastpage'>LAST</a> ";
        }
    }
    echo "</div>";
}
?>
