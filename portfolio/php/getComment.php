<?php
include("connectdb.php");
//paginasi
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$id = $_GET['idpost'];
//ambil list komentar
$sql = "SELECT * FROM komentar WHERE id_post=" . $_GET['idpost'] . " ORDER BY waktu_comment DESC";
$result = mysql_query($sql);
if (!$result) {
    die(mysql_error());
}
$numrows = mysql_num_rows($result);
$rows_per_page = 2;
$lastpage = ceil($numrows / $rows_per_page);
$pageno = (int) $pageno;
if ($pageno > $lastpage) {
    $pageno = $lastpage;
}
if ($pageno < 1) {
    $pageno = 1;
}
$limit = 'LIMIT ' . ($pageno - 1) * $rows_per_page . ',' . $rows_per_page;
//ambil list komentar
$sql = "SELECT * FROM komentar WHERE id_post=" . $_GET['idpost'] . " ORDER BY waktu_comment DESC $limit";
$result = mysql_query($sql);
$i = 0;
while ($row1 = mysql_fetch_array($result)) {
    $komen[$i] = $row1;
    $i++;
}
//echo navigasi
echo "<div class ='container_full' style='text-align: center'>";
if ($numrows > 0) {
    if ($pageno == 1) {
        echo " FIRST PREV ";
    } else {
        echo " <a href=''>FIRST</a> ";
        $prevpage = $pageno - 1;
        echo " <a href='getComment.php?pageno=$prevpage&idpost=$id'>PREV</a> ";
    }
    echo " ( Page $pageno of $lastpage ) ";
    if ($pageno == $lastpage) {
        echo " NEXT LAST ";
    } else {
        $nextpage = $pageno + 1;
        echo " <a href='getComment.php?pageno=$nextpage&idpost=$id'>NEXT</a> ";
        echo " <a href='getComment.php?pageno=$lastpage&idpost=$id'>LAST</a> ";
    }
}
echo "</div>";
//echo komentar
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
    if (isset($_SESSION['username']) && strlen($_SESSION['username']) > 0) {
        if ($komen[$i]['username'] === $_SESSION['username']) {
            echo "<input type = 'button' value = 'Delete' name = 'Delete' onclick = 'deleteComment(" . '"' . $komen[$i]['id_post'] . '"' . "," . '"' . $komen[$i]['username'] . '"' . "," . '"' . $komen[$i]['waktu_comment'] . '"' . ");' />";
        }
    }
    echo "</div>";
}
echo "</div>";
?>
