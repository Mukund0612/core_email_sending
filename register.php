
<?php


include('include/function.php');

// Verify user MSG
if(isset($_GET['msg']) && $_GET['msg'] == 's' ){
    $registration_msg = "Email Verification SuccessFully Complate Please Login.";
}

//
if(isset($_GET['msg']) && $_GET['msg'] == 'w' ){
    $registration_msg = "Email Verification Failed Please Try Again.";
}

// Click event for sign up
if(isset($_POST['submit'])):
    
    // Blank Validation for Name
    if( $_POST['name'] == "" ):
        $name_err = "Please Enter Name";
    endif;
    
    // Blank Validation for Email
    if( $_POST['email'] == "" ):
        $email_err = "Please Enter email";
    else:
        if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)): // If Email is Currect
            $email_err = "Please Enter email";
        endif;
    endif;
    
    // Blank Validation for Password
    if($_POST['password'] == "" ):
        $password_err = "Please Enter Password.";
    endif;

    // Blank Validation for Password
    if($_POST['confirm-password'] == "" ):
        $confirm_password_err = "Please Enter Password.";
    else:
        if($_POST['password'] != $_POST['confirm-password']): // If password and confirm password match
            $confirm_password_err = "Password Dose Not Match.";
        endif;
    endif;

    // Specific Critarea
    if(!isset($name_err) && !isset($email_err) && !isset($password_err) && !isset($confirm_password_err) ){
        $referral_code = referral_code_generate($con,TRUE);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO `register` (`name`,`email`,`password`,`referral_code`,`verification_status`) VALUES ( '".$name."' , '".$email."' , '".$password."' , '".$referral_code."' ,'N' )";

        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
        $fetch = mysqli_query($con,"SELECT MAX(`u_id`) as u_id FROM `register`;");
        $u_id = mysqli_fetch_assoc($fetch)['u_id'];

        if( $result == 1 ):
            $verification_link = "http://localhost/core_email/email_verify.php?type=user&verification_code=".$referral_code."&u_id=".$u_id;
            
            sendAccVerificationEmail($_POST['email'],$verification_link,$_POST['name']);
            $check_email = "Please chack Your Mail Inbox to verify your email.";
        endif;

    }

endif;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="background_image" device-width>
        <div class="header">
            <h1 class="text-white text-center">Registration With Email</h1>
            
        </div>
        <div class="container">
            <div class="registration">
                <div class="sign-up-content">
                    <form method="POST" class="signup-form">
                        <h2 class="form-title" align="center">Sing Up</h2>
                            <?php if(isset($registration_msg)){ echo $registration_msg; }?>
                            <?php if(isset($check_email)){ echo $check_email; }?>
                            <hr>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="name" class="label label-default">Full name</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="error">
                                <?php if(isset($name_err)){ echo $name_err; } ?>
                            </div>
                        </div>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="email" class="label label-default">Email</label>
                            </div>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" id="eamil">
                            </div>
                            <div class="error">
                                <?php if(isset($email_err)){ echo $email_err; } ?>
                            </div>
                        </div>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="password" class="label label-default">Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="error">
                                <?php if(isset($password_err)){ echo $password_err; } ?>
                            </div>
                        </div>
                        <div class="row control">
                            <div class="col-md-5">
                                <label for="confirm-password" class="label label-default">Confirm-Password</label>
                            </div>
                            <div class="col-md-7">
                                <input type="password" class="form-control" name="confirm-password" id="confirm-password">
                            </div>
                            <div class="error">
                                <?php if(isset($confirm_password_err)){ echo $confirm_password_err; } ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-textbox">
                            <input type="submit" name="submit" id="submit" class="submit" value="Create account">
                        </div>
                    </form>

                    <p class="loginhere">
                        Already have an account ?<a href="index.php" class="loginhere-link"> Log in</a>
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