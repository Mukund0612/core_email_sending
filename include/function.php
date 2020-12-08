<?php
/**
 * Database Connection
 */
$con = mysqli_connect('localhost','root','','core_email');


/**
 * Generate 8 Digit Rendom number
 */
function referral_code_generate($con,$unique){
    $referral_code_len = 8;
    $referral_code_str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $unique_code = FALSE;
    while(!$unique_code):

        $referral_code = '';
        $i = 0;
        while($i < $referral_code_len):
            
            $referral_code .= substr($referral_code_str, mt_rand( 0, strlen($referral_code_str)-1), 1 );
            $i++;
        endwhile;
        // nativekamal1
        if( $unique == TRUE ):

            $sql = "SELECT `referral_code` FROM `register` WHERE `referral_code` = '$referral_code'";
            $result = mysqli_query($con,$sql) or die(mysqli_error($con));
            if( mysqli_num_rows($result) == 0 ):

                $unique_code = TRUE;
            endif;
        else:

            $unique_code = TRUE;
        endif;
    endwhile;
    return $referral_code;
}

/**
 * Send Verification email to user is sign Up
 */

function sendAccVerificationEmail($to,$verification_link,$fname){
    
    ob_start(); 
        require_once ('email_verification.php');
    $body =  ob_get_clean();
    
    $subject= "Activate Your Account";
    
    require_once 'include/phpmailer/class.phpmailer.php'; 
   
          $mail = new PHPMailer(true); 
          try{
            $mail->IsSMTP();                           // tell the class to use SMTP
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Port       = 587;     
            $mail->Host       = "smtp.gmail.com"; // SMTP server
            $mail->Username   = "testing.email7804@gmail.com";     // SMTP server username
            $mail->Password   = "testing.email"; 
            $mail->SMTPSecure = "tls"; 
           // $mail->IsSendmail();  // tell the class to use Sendmail
        
            $mail->AddReplyTo('testing.email7804@gmail.com','Mukund');
        
            $mail->From       = 'testing.email7804@gmail.com';
            $mail->FromName   = 'Mukund';
            
            $mail->AddAddress($to);
     
            $mail->Subject  =   $subject;
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap   = 80; // set word wrap
        
            $mail->MsgHTML($body);
            
            $mail->IsHTML(true); // send as HTML
        
            $sendEmail = $mail->Send();

            return true;
      } catch (phpmailerException $e) {
          echo $e->errorMessage();
          
      }
}