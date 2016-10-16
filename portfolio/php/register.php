<?php

include("connectdb.php");
session_start();
extract($_POST);
//validasi masukan
//id elemen di formnya tolong sesuaikan
$Username = $_POST['username'];
$Password = $_POST['password'];
$CPassword = $_POST['cPassword'];
$NamaL = $_POST['namaL'];
$Tgl = $_POST['tgl'];
$Image = $_FILES["inputAvatar"]["name"];
$Email = $_POST['email'];
$Gender = $_POST['gender'];
$About = $_POST['about'];
$IsValid = true;
$noticeUsername = "";
$noticePassword = "";
$noticeCPassword = "";
$noticeNamaL = "";
$noticeTgl = "";
$noticeImage = "";
$noticeEmail = "";
$noticeGender = "";
//validasi username
if ($Username === "") {
    $IsValid = false;
    $noticeUsername = "Username tidak boleh kosong";
} else if (strlen($Username) < 5) {
    $IsValid = false;
    $noticeUsername = "Masukkan username dengan panjang min 5 karakter!";
} else {
    //cek ada username tsb di DB
    $sql = "SELECT username FROM profil where username='" . $Username . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die('Error : ' . mysql_error());
    } else {
        if (mysql_num_rows($result) > 0) {
            $IsValid = false;
            $noticeUsername = "Username sudah ada di database!";
        }
    }
}

if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $Email)) {
    $IsValid = false;
    $noticeEmail = "Masukkan email yang valid";
} else {
    //cek ada username tsb di DB
    $sql = "SELECT username FROM profil where email='" . $Email . "'";
    $result = mysql_query($sql);
    if (!$result) {
        die('Error : ' . mysql_error());
    } else {
        if (mysql_num_rows($result) > 0) {
            $IsValid = false;
            $noticeEmail = "Email sudah ada di database!";
        }
    }
}

if ($Username === $Password && strlen($Username) != 0 && strlen($Password) != 0) {
    $IsValid = false;
    $noticePassword = "Username dan password tidak boleh sama!";
}

//validasi password
if (strlen($Password) < 8) {
    $IsValid = false;
    $noticePassword = "Masukkan password dengan panjang min 8 karakter!";
}

if ($Password === $Email && strlen($Username) != 0 && strlen($Password) != 0) {
    $IsValid = false;
    $noticePassword = "Email dan password tidak boleh sama!";
}

//validasi confirm password
if ($Password !== $CPassword && strlen($Password) != 0) {
    $IsValid = false;
    $noticeCPassword = "Password dan confirm password harus sama!";
}

function wordCount($string) {
    $words = "";
    $string = eregi_replace(" +", " ", $string);
    $array = explode(" ", $string);
    for ($i = 0; $i < count($array); $i++) {
        if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i]))
            $words[$i] = $array[$i];
    }
    return $words;
}

//validasi nama lengkap
if (count(wordCount($NamaL)) < 2) {
    $IsValid = false;
    $noticeNamaL = "Masukkan Nama Lengkap Anda ";
}

//validasi tanggal lahir			
if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $Tgl)) {
    $IsValid = false;
    $noticeTgl = "Tanggal lahir harus valid dan berformat yyyy-mm-dd!";
} else {
    //parse bulan, tanggal, dan tahun
    $year = substr($Tgl, 0, 4);
    $month = substr($Tgl, 5, 2);
    $date = substr($Tgl, 8, 2);
    //checkdate
    if (!checkdate($month, $date, $year)) {
        $IsValid = false;
        $noticeTgl = "Tanggal lahir yang dimasukkan tidak valid!";
    }
}

//validasi image
$ext = end(explode('.', $Image));
$ext = strtolower($ext);
if ($ext !== "jpg" && $ext !== "jpeg") {
    $IsValid = false;
    $noticeImage = "Masukkan file jpg atau jpeg";
}

//validasi gender
if ($Gender === "Pilih Gender") {
    $IsValid = false;
    $noticeGender = "Pilih Salah Satu Gender";
}
$_SESSION['about'] = $About;

if (!$IsValid) {
    header("Location:../register_form.php?username=" . $Username .
            "&password=" . $Password .
            "&cPassword=" . $CPassword .
            "&namaL=" . $NamaL .
            "&tgl=" . $Tgl .
            "&inputAvatar=" . $Image .
            "&email=" . $Email .
            "&gender=" . $Gender .
            "&Nusername=" . $noticeUsername .
            "&Npassword=" . $noticePassword .
            "&NcPassword=" . $noticeCPassword .
            "&NnamaL=" . $noticeNamaL .
            "&Ntgl=" . $noticeTgl .
            "&NinputAvatar=" . $noticeImage .
            "&Nemail=" . $noticeEmail .
            "&Ngender=" . $noticeGender
    );
} else {//masukan valid
    //copy file image
    move_uploaded_file($_FILES["inputAvatar"]["tmp_name"], "../avatars/" . $_FILES["inputAvatar"]["name"]);
    if ($_FILES["inputAvatar"]["name"] === "") {
        if ($Gender === "Laki-laki") {
            $Image = "avatars/avatar-male.gif";
        } else if ($Gender === "Perempuan") {
            $Image = "avatars/avatar-female.gif";
        }
    } else {
        $Image = "avatars/" . $_FILES["inputAvatar"]["name"];
    }
    $about1 = str_replace("'", "''", $about);
    $sql = "INSERT INTO profil(username, email, password, nama_lengkap, tanggal_lahir, avatar, gender,about_me ) VALUES('$Username','$Email','$Password','$NamaL','$Tgl','$Image','$Gender', '$about1')";
    $result = mysql_query($sql);
    if (!$result) {
        echo "sql = " . $about1;
//        die('Error : ' . mysql_error());
    } else {
        mysql_close($con);
        $_SESSION['username'] = $Username;
        header("Location:../profile.php?username=".$username);
    }
}
?>