<?php
include "connection.php";
require 'functions.php';
session_start();
$msg = '';
$email = $_SESSION['email'];
$type = $_SESSION['who'];
// echo $type;
if (isset($_POST['verify'])) {
    echo "verify";
    $otp1 = filter_input(INPUT_POST, 'otp1', FILTER_SANITIZE_SPECIAL_CHARS);
    $otp2 = filter_input(INPUT_POST, 'otp2', FILTER_SANITIZE_SPECIAL_CHARS);
    $otp3 = filter_input(INPUT_POST, 'otp3', FILTER_SANITIZE_SPECIAL_CHARS);
    $otp4 = filter_input(INPUT_POST, 'otp4', FILTER_SANITIZE_SPECIAL_CHARS);
    $otp5 = filter_input(INPUT_POST, 'otp5', FILTER_SANITIZE_SPECIAL_CHARS);
    $otp6 = filter_input(INPUT_POST, 'otp6', FILTER_SANITIZE_SPECIAL_CHARS);
   
    $enteredOTP = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;    
  
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiration'])) {
        
        if (time() > $_SESSION['otp_expiration']) {
            
            $msg = '<span class="text text-center  m-3"><a href ="register.php" style="text-decoration:none;" class = "text-danger">OTP Has Expired</a></span>';

        } elseif ($enteredOTP == $_SESSION['otp']) {
        
            
            if($type =='pass'){
                echo "hiiiixxx";
                
                $_SESSION['email'] = $email;

                header('location:reset_password.php');
            
            }elseif($type =='club'){
                
                $clubname = $_SESSION['clubname'];
                $type = $_SESSION['type'];
                $email = $_SESSION['email'];
                $manname = $_SESSION['manname'];
                $district = $_SESSION['district'];
                $mobile = $_SESSION['mobile'];
                $password = $_SESSION['password'];
                
                
                $image = "nothing";
            
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
               

                // $sql = "INSERT INTO user (name,email,mobile,district,age,password,image) VALUES ('{$name}', '{$email}','{$age}','{$district}','{$mobile}', '{$hashedPassword}', '{$image}')";
                $sql = "INSERT INTO `club`( `club_name`,`club_type`,`Man_name`, `email`, `mobile`, `district`, `logo`, `password`) VALUES ('$clubname','$type','$manname','$email','$mobile','$district','$image','$hashedPassword')";

                $result = mysqli_query($conn, $sql);
                // Proceed with the login or desired action
                if ($result) {
                    echo "hiiiii";
                    $msg = 'OTP verified successfully';
                    header('location:login.php');

                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_expiration']);
                    unset($_SESSION['email']);
                    unset($_SESSION['name']);
                    unset($_SESSION['who']);
                    unset($_SESSION['clubname']);
                    unset($_SESSION['type']);
                    unset($_SESSION['manname']);
                    unset($_SESSION['mobile']);
                    unset($_SESSION['district']);
        
                    unset($_SESSION['password']);
                }
                
               


            }else{

                $email = $_SESSION['email'];
                $name = $_SESSION['name'];
                $age = $_SESSION['age'];
                $district = $_SESSION['district'];
                $mobile = $_SESSION['mobile'];
                $password = $_SESSION['password'];
                $country = $_SESSION['country'];
                $image = "nothing";
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                
                // $sql = "INSERT INTO user (name,email,mobile,district,age,password,image) VALUES ('{$name}', '{$email}','{$age}','{$district}','{$mobile}', '{$hashedPassword}', '{$image}')";
                $sql = "INSERT INTO `user`( `name`, `email`, `mobile`, `district`, `age`, `password`, `image` ,`country`) VALUES ('$name','$email','$mobile','$district','$age','$hashedPassword','$image','$country')";
                $result = mysqli_query($conn, $sql);
                // Proceed with the login or desired action
                if ($result) {
                    echo "hii";
                    $msg = 'OTP verified successfully';
                    header('location:login.php');

                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_expiration']);
                    unset($_SESSION['email']);
                    unset($_SESSION['name']);
                    unset($_SESSION['age']);
                    unset($_SESSION['mobile']);
                    unset($_SESSION['district']);
    
                    unset($_SESSION['password']);
                }
                
               

            }
            
        } else {
            $msg = '<span class="text text-center text-danger m-3">Invalid OTP</span>';
        }
    } else {
        $msg = '<span class="text text-center text-danger m-3">OTP Was Not Send</span>';
    }
} else {
    $msg = '<span class="text text-center text-success m-3">Please enter OTP</span>';
}
if(isset($_POST['resend'])){
   
    $newOTP = generateOTP();
    // Send the new OTP via email
    if(sendOTP($newOTP,$email)) {
        $msg = "OTP has been resent to your email.";
    } else {
        // echo "Failed to send OTP. Please try again.";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link href="css/style.css?v=<?php echo time();  ?>" rel="stylesheet">
    <title>Document</title>
</head>

<body style="background: linear-gradient(#000, #0a104b);">
    <div class="container-fluid p-5 d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container w-100 w-md-50" style="box-shadow: 1px 1px 30px 4px gray;">
            <form method="post" class="d-flex justify-content-center align-items-center flex-column otp-form" style="height: 700px;">

                <h3 ><span class="underline text-light" style="font-weight: 900; margin-bottom:60px;" >OTP Verification</span></h3>
                
               <?php  echo $msg; ?>
                <div class=" mt-5 d-flex justify-content-center align-items-center mb-5 ">
                    <input type="text" name="otp1" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                    <input type="text" name="otp2" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                    <input type="text" name="otp3" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                    <input type="text" name="otp4" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                    <input type="text" name="otp5" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                    <input type="text" name="otp6" class="form-control otp-input " maxlength="1" oninput="move()" placeholder="0" >
                </div>
                <button type="submit" name="resend" class="resend">Resend OTP</button>
                <div class="d-flex justify-content-center align-items-center w-100 mt-4">
                    <button class="btn btn-primary button" type="submit" name="verify">Verify</button>
                </div>

            </form>
        </div>
    </div>
    <script src="js/nn.js"></script>
</body>

</html>