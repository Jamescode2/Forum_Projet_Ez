<?php
$mysqli=mysqli_connect("localhost","root","","forum_users");
$sql="select * from topic ORDER BY pseudo DESC";
$result=mysqli_query($mysqli,$sql);
$all=mysqli_fetch_all($result,MYSQLI_ASSOC);
$jsonall=json_encode($all,JSON_PRETTY_PRINT);
echo $jsonall;
?>