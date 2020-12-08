<?php
include('include/function.php');

if(isset($_POST['submit'])){
    $password = $_POST['password'];
    $email = $_POST['email'];

    if( isset($email) ){

        $sql = "SELECT * FROM `register` where `email`='$email'";
        $result = mysqli_query($con,$sql);
        if( mysqli_num_rows($result) == 1 ){
            $record =   mysqli_fetch_assoc($result);
            $db_password = $record['password'];
            $name = $record['name'];
            if( isset($password) && password_verify( $password, $db_password )){
                $verification_status =  $record['verification_status'];
                
                if( $verification_status == 'Y' ){

                    header("location:dashboard.php?name=$name");
                } else {

                    $error = "Please Verify Your Email And Try again.";
                }

            } else {

                $error = "Please Enter Valid Email or Password.";
            }
        } else {

            $error = "Please Enter Valid Email or Password.";
        }
    } else {
        $error = "Please Enter Valid Email or Password.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="background_image" device-width>
        <div class="header">
            <h1 class="text-white text-center">Login Form</h1>
            
        </div>
        <div class="container">
            <div class="registration">
                <div class="sign-up-content">
                    <form method="POST" class="signup-form">
                        <h2 class="form-title" align="center">Login</h2>
                        <?php if(isset($error)){ echo $error; }?>
                            <hr>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="email" class="label label-default">Email</label>
                            </div>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" id="eamil">
                            </div>
                        </div>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="password" class="label label-default">Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <hr>
                        <div class="form-textbox">
                            <input type="submit" name="submit" id="submit" class="submit" value="Login" style="padding:4px 15px;">
                        </div>
                    </form>

                    <p class="loginhere" >
                        Create an account ?<a href="register.php" class="loginhere-link"> Sign Up </a>
                    </p>
                </div>
            </div>
        </div>
        <h1 class="footer">Mukund Hirpara<h1>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
   
</body>

</html>