<?php
    session_start();
        include("connection.php");
        $query="select * from users where id=".mysqli_real_escape_string($link,$_SESSION['id'])."";
        $row=mysqli_fetch_array(mysqli_query($link,$query));
        $dia=$row['current'];
        $diarycontent=$row["$dia"];
        echo $diarycontent;  
?>