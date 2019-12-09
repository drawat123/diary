<?php
    include('connection.php');
    $sess=$_SESSION['id']??' ';
    $query="select * from users where id='$sess'";
    $result=mysqli_query($link,$query);
    $row=mysqli_fetch_array($result);
?>