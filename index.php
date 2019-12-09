<?php
    session_start();
    $error="";
    $m="";
    $m1="";
    if(array_key_exists("logout",$_GET))
    {
        session_destroy();
        setcookie("id","",time()-3600*24);
        $_COOKIE="";
    }
    include("connection.php");
    if(array_key_exists("id",$_SESSION) or array_key_exists("id",$_COOKIE))
    {
        header("location:loginpage.php");
    }
    if(array_key_exists("forgot",$_POST))
    {
        header("location:forgot.php");
    }
    if(array_key_exists("submit",$_POST))
    {
        if(!$_POST['email'])
        {
            $error.="An email is required<br>";
        }
        if(!$_POST['password'])
        {
            $error.="Password is required<br>";
        }
        if($error!="")
        {
            $error="<p>There were error(s) in your form:</p>".$error;
        }
        else
        {
            if($_POST['signup']==1)
            {
                $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0 && $result!=false)
                {
                    $error = "That email address is taken.";
                }
                else
                {
                    $token='qwertyuiopzxcvbnm1234567890$/()*';
	                $token=str_shuffle($token);
                    $token= substr($token,0,10);
                    $query="insert into users(email,password,token,emailconfirm) values ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['email'])."','$token',0)";
                    if(!mysqli_query($link,$query))
                    {
                        $error="<p>could not sign in</p>";
                    }
                    else
                    {
                        $email=$_POST['email'];
                        $subject="Please verify email";
                        $body="Click on the link to verify email http://localhost/secre/confirmemail.php?email=$email&token=$token";
                        $headers="From: anil122rana@gmail.com";
                        $query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        mysqli_query($link,$query);
                        mail($email,$subject,$body,$headers);
                        $m1="Verification email has been sent to your account<br>Verify your email to login"; 
                    }
                }
            }
            else
            {
                $query="select * from users where email='".mysqli_real_escape_string($link,$_POST['email'])."'";
                $result=mysqli_query($link,$query);
                $row=mysqli_fetch_array($result);
                if(isset($row))
                {
                    $email=$_POST['email'];
                    $pass=md5(md5($row['id']).$_POST['password']);
                    if($pass==$row['password'])
                    {
                        $query="select emailconfirm from users where email='$email'";
                        $result=mysqli_query($link,$query);
                        $row1=mysqli_fetch_array($result);
                        if($row1[0]==0)
                        {
                            $m="Verify your email before signing in";
                        }
                        else
                        {
                            $_SESSION['id']=$row['id'];
                            
                            if($_POST['stayloggedin']=='1')
                            {
                                setcookie("id",$row['id'],time()+3600*24*365);
                            }
                            header("location:loginpage.php");
                        }
                    }
                    else
                    {
                        $error="That email/password combination cannot be found";
                    }
                }
                else
                {
                    $error="That email/password combination cannot be found";
                }
            }
        }
    }
?>
<?php include("header.php"); ?>
    <div class="container" id="homepagecontainer">
        <h1>Diary</h1>
            <p class="lead"><strong>Store your thoughts permanently and securely!</strong></p>  
        <div id="error"><?php
                if($error!=""){echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';}
                if($m!=""){echo '<div class="alert alert-danger" role="alert">'.$m.'</div>';}
                if($m1!=""){echo '<div class="alert alert-success" role="alert">'.$m1.'</div>';}
            ?>
        </div>
        <form method="POST" id="signupform">
            <div class="form-group">
                <input type="email" name="email" placeholder="Your Email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="checkbox" name="stayloggedin" value="1" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Stay logged in</label>
            </div>
                <input type="hidden" name="signup" value="1">
            <div class="form-group">
                <input type="submit" name="submit" value="Sign Up" class="btn btn-primary">
            </div>
            <p><a class="toggleform badge badge-primary">Log In</a></p>
        </form>
        <form method="POST" id="loginform">
            <p class="lead">Log in using your username and password</p>
            <div class="form-group">
                <input type="email" name="email" placeholder="Your Email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="checkbox" name="stayloggedin" value="1" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Stay logged in</label>
            </div>
                <input type="hidden" name="signup" value="0">
            <div class="form-group">
                <input type="submit" name="submit" value="Log In" class="btn btn-primary">
            </div>
            <p><a class="toggleform badge badge-primary">Sign Up</a></p>
        </form>
        <form method="POST" id="forg">
            <div class="form-group" style="margin:80px;">
                <input type="submit" name="forgot" value="Forgot Password" class="btn btn-link">
            </div>
        </form>
    </div>
    <?php include("footer.php") ?>