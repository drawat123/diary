<?php
    if(isset($_GET['email'])&&isset($_GET['token']))
    {
        include("connection.php");
        $email=$_GET['email'];
        $token=$_GET['token'];
        $query="select id from users where email='$email' and token='$token' and emailconfirm=0";
        $result=mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0)
        {
            $query="update users set emailconfirm=1 where email='$email'";
            if(mysqli_query($link, $query))
            {
                echo "<div class='alert alert-success' role='alert'>
                        <h4 class='alert-heading'>Well done!</h4>
                        <p>Your email is confirmed you can now <a href='http://localhost/secre/index.php'>Log In</a></p>
                        </div>";
            }
        }
        else
        {
            echo "<h1 class='alert alert-danger' role='alert'>
            Invalid link
          </h1>";
        }
    }
    else
    {
        echo "<h1 class='alert alert-danger' role='alert'>
            Invalid link
          </h1>";
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    </head>
</html>