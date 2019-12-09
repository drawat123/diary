<?php
    session_start();
    $diarycontent="";
    if(array_key_exists("id",$_COOKIE))
    {
        $_SESSION['id']=$_COOKIE['id'];
    }
    if(array_key_exists("id",$_SESSION))
    {
        include("connection.php");
        $r=$_SESSION['id'];
        date_default_timezone_set("Asia/Calcutta");
        $date= date('Y-m-d');
        $query="UPDATE `users` SET today = '$date' WHERE `users`.`id` = '$r'";
        mysqli_query($link,$query);
        $query="UPDATE `users` SET current = '$date' WHERE `users`.`id` = '$r'";
        mysqli_query($link,$query);
        $query="ALTER table users ADD `$date` text NULL";
        mysqli_query($link,$query);
        $query="select * from users where id=".mysqli_real_escape_string($link,$_SESSION['id'])."";
        $row=mysqli_fetch_array(mysqli_query($link,$query));
        $dia=$row['today'];
        $diarycontent=$row["$dia"];
        if(isset($_POST['forgot']))
        {
            $query = "SELECT email FROM users WHERE id = '$r'";
            $result = mysqli_query($link, $query);
            $row=mysqli_fetch_array($result);
            $token='qwertyuiopzxcvbnm1234567890$/()*';
	        $token=str_shuffle($token);
            $token= substr($token,0,10);
            $email=$row['email'];
            $query = "UPDATE users SET token1 = '$token' WHERE email = '$email'";
            mysqli_query($link,$query);
            header("location:http://localhost/secre/forgotpassword.php?email=$email&token=$token"); 
        }    
    }
    else
    {
        header("Location:index.php");
    }
    include("header.php");
?>
<nav class="navbar navbar-dark bg-dark justify-content-between" id="nav">
    <a class="navbar-brand" style="color:white">Diary</a>
    
        <p class="lead" style="color:white;">Date:<input id="datefield" name="datefield" type='date' min='1899-01-01' max='2000-13-13'></input></p>
    
    <div class="form-inline">
        <a href="index.php?logout=1"><button class="btn btn-danger my-2 my-sm-0" type="submit">Log Out</button></a>
    </div>
</nav>
<textarea class=" form-control" id="con1"><?php echo $diarycontent?></textarea>
<form method="POST" id="forget1">
    <div class="form-group">
        <input type="submit" name="forgot" value="Change Password" class="btn btn-light">
    </div>
</form>
<?php
    include("footer.php");
?>