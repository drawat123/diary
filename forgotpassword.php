<?php
    if(isset($_GET['email'])&&isset($_GET['token']))
    {
        session_start();
        include("connection.php");
        $email=$_GET['email'];
        $token=$_GET['token'];
        $query="select * from users where email='$email' and token1='$token' and emailconfirm=1";
        $result=mysqli_query($link, $query);
        $row=mysqli_fetch_array($result);
        if (mysqli_num_rows($result) > 0)
        {
            if(isset($_POST['forgot']))
            {
                if(!$_POST['password'])
                {
                    $error.="Password is required<br>";
                    echo $error;
                }
                else
                {
                    $query="update users set password='".md5(md5($row['id']).$_POST['password'])."',token1=NULL where email='$email'";
                    if(mysqli_query($link, $query))
                    {
                        echo "<div class='alert alert-success' role='alert'>
                                <h4 class='alert-heading'>Your password is changed you can now <a href='http://localhost/secre/index.php'>Log In</a></h4>
                                </div>";
                                session_destroy();
                                setcookie("id","",time()-3600*24);
                                $_COOKIE="";
                    }
                }
            }
        }
        else
        {
            header("location:http://localhost/secre/index.php");
        }
    }
    else
    {
        header("location:http://localhost/secre/index.php");
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    </head>
    <body>
    <form method="POST" id="forget">
        <p class="lead"><strong>Enter your new password:<strong></p>
        <div class="form-group">
            <input type="password" name="password" placeholder="" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="forgot" value="Submit" class="btn btn-primary">
        </div>
    </form>
    </body>
</html>