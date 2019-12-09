<?php
    $error="";
    $m1="";
    include("connection.php");
    include("header.php");
    if(isset($_POST['forgot']))
    {
        if(!$_POST['email'])
        {
            $error.="An email is required";
        }
        else
        {
            $query = "SELECT email FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
            $result = mysqli_query($link, $query);
            $row=mysqli_fetch_array($result);
            if($_POST['email']=$row['email'])
            {
                $token='qwertyuiopzxcvbnm1234567890$/()*';
	            $token=str_shuffle($token);
                $token= substr($token,0,10);
                $email=$_POST['email'];
                $subject="Change Password";
                $body="Click on the link to change your password http://localhost/secre/forgotpassword.php?email=$email&token=$token";
                $headers="From: anil122rana@gmail.com";
                $query = "UPDATE users SET token1 = '$token' WHERE email = '$email'";
                mysqli_query($link,$query);
                mail($email,$subject,$body,$headers);
                $m1="Link to change password is sent to your account"; 
            }
            else
            {
                $error= "Email cannot be found";
            }
        }
    }
?>
<div id="errorcontainer">
    <h4 ><?php if($m1!=""){echo '<div class="alert alert-success" role="alert">'.$m1.'</div>';}
               if($error!=""){echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';}
    ?></h4>
</div>
<form method="POST" id="forget">
    <p class="lead"><strong>Enter your email:<strong></p>
    <div class="form-group">
        <input type="email" name="email" placeholder="Your Email" class="form-control">
    </div>
    <div class="form-group">
        <input type="submit" name="forgot" value="Submit" class="btn btn-primary">
    </div>
</form>
</div>
<?php include("footer.php") ?>