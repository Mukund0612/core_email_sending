<?php
$con = mysqli_connect('localhost','root','','core_email');
$verification_code = $_GET['verification_code'];
$u_id = $_GET['u_id'];
$type = $_GET['type'];

$sql = "SELECT * FROM `register` WHERE `referral_code` = '$verification_code' and `u_id` = '$u_id'";
$result = mysqli_query($con,$sql) or die(mysqli_error($con));
$user_record = mysqli_fetch_assoc($result);

if( $type == 'user' && $user_record['u_id'] == $u_id ){
    
    $sql = "UPDATE `register` SET `verification_status` = 'Y' WHERE `u_id` = '$u_id' ";
    $update = mysqli_query($con,$sql);
    if( $update == 1 ){
            
        header('location:http://localhost/core_email/index.php?msg=s');
    }
} else {

    header('location:http://localhost/core_email/index.php?msg=w');
}

?>