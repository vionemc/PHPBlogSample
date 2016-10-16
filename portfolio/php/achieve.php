<?php

include ("connectdb.php");
session_start();
$username = $_GET['username'];
$type = $_GET['type'];
$sql = "SELECT achievement_".$type." FROM profil WHERE username='" . $username . "'";
$result = mysql_query($sql);
if (!$result) {
    echo $sql . mysql_error();
} else {		
		$row = mysql_fetch_array($result);
		if ($type==="comment") {
				if ($row['achievement_comment']==1){
					echo 'comment1';	
				} else if ($row['achievement_comment']==20){
					echo 'comment20';	
				}
			} else if ($type==="post"){
				if ($row['achievement_post']==1){
					echo 'post1';	
				} else if ($row['achievement_post']==20){
					echo 'post20';
				}
			} else if ($type==="like"){
				if ($row['achievement_like']==100){
					echo 'like100';	
				} else if ($row['achievement_dislike']==100){
					echo 'dislike100';
				}
			} else {echo 'gagal';}						        
    		
			mysql_close($con);
}
?>
