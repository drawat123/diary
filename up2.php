<?php
    session_start();
    if(array_key_exists("content",$_POST))
    {
        include("connection.php");
        $q=$_POST['content'];
        $r=$_SESSION['id'];
        $query="select * from users where id=".mysqli_real_escape_string($link,$_SESSION['id'])."";
        $row=mysqli_fetch_array(mysqli_query($link,$query));
        $query="UPDATE `users` SET current = '$q' WHERE `users`.`id` = '$r'";
        mysqli_query($link,$query);
    }
?>