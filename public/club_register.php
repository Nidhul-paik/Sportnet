<?php
session_start();

require 'functions.php';

$otp = generateOTP();
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiration'] = time() + 300; // OTP expires in 5 minutes

include "connection.php";

try {
    if (isset($_POST['signup'])) {
       
        $msg = '';
        $mobm = '';
        $userm = '';
        $eamilm = '';
        $clubname = mysqli_real_escape_string($conn, $_POST['clubname']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $manname = mysqli_real_escape_string($conn, $_POST['manname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $district = mysqli_real_escape_string($conn, $_POST['district']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    // -----------mobile number validation--------------//

    $pattern = '/^(\+91)?[6-9]\d{9}$/';
    if (!preg_match($pattern, $mobile)) {
        $mobm =  "Invalid mobile number.";
    }   

    // -----------email validation----------------------//

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailm =  "Invalid Email address .";
    }
       
    if($mobm == '' && $emailm ==''){

        $sql = "SELECT * FROM `club` WHERE email = '{$email}'";
        $sql2 = "SELECT * FROM `user` WHERE email = '{$email}'";

        if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0  || mysqli_num_rows(mysqli_query($conn, $sql2)) > 0) {

            $userm = "email  already exists";
        } else {
           
            if ($password === $cpassword) {
                $_SESSION['who']="club";
                $_SESSION['clubname'] = $clubname;
                $_SESSION['type'] = $type;
                $_SESSION['email'] = $email;
                $_SESSION['manname'] = $manname;
                $_SESSION['district'] = $district;
                $_SESSION['mobile'] = $mobile;
                $_SESSION['password'] = $password;

                if (sendOTP($otp, $email)) {
                  

                    echo "<script>
                            setTimeout(function(){
                                window.location.href = 'emailverify.php';
                            }, 3000); // Redirect to success page after 3 seconds
                        </script>";

                } else {
                    $msg = "Failed to send OTP. Please try again.";
                }

            }
        }
    }else{
        echo "somthing wrong";
    }
   
    }
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; (commented out)
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Document</title>

</head>
<body>
    <div class="d-flex justify-content-center "  style=" background: linear-gradient(#000, #0a104b);">
       <!-- <div class="row rowcontainer mt-5"> -->
        <!-- <div class="container1 p-0 d-none col-lg-6 col-md-6 d-sm-block " id="container1" style="background-image: url('images/rg.webp');">
            
        </div> -->
<div class="container2 " style="background:transparent;">
    <h3 ><span class="underline" id="head">signup Here !</span></h3>
    <span class="text-cener text-danger"><?php echo $msg; ?></span>
    <span id="password_match" class="text text-danger"></span>
    <div class="form">

        <form method="post" >
        <h4 ><span class="underline" id="short-head">signup Here !</span></h4>

        <p class="text-danger"> <?php echo $userm; ?></p>
            <div class="form-group form-elements " >
               
                <i  class="fas fa-trophy  "></i>
                <input type="text" name="clubname" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Club Name" required>
            </div>

            <div class="form-group form-elements mb-3">
                <i class="fas fa-envelope"></i>
                <select name="type" class="form-control form-input" style="background: transparent; color: white; border:none;" required>
                <option value="" disabled selected>Club tType</option>
                <?php
                $sql = "SELECT name FROM `sports`";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
                       ?>
                        <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                        <?php
                    }
                }
                ?>
                    
                </select>
            </div>

            <div class="form-group form-elements " >
                <i  class="fas fa-user  "></i>
                <input type="text" name="manname" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Manager Name" required>
            </div>

            <p class="text-danger"><?php echo $emailm; ?></p>
            <div class="form-group form-elements ">
           
                <i  class="fas fa-envelope  "></i>
                <input type="text" name="email" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Email" required>
            </div>

            <p class="text-danger"><?php echo $mobm; ?></p>
            <div class="form-group form-elements ">
            
                <i  class="fas fa-phone  "></i>
                <input type="tel" name="mobile" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Mobile NO" required>
            </div>

            

           <div class="form-group form-elements mb-3">
                <i class="fas fa-map-marker-alt"></i>
                <select name="district" class="form-control form-input" style="background: transparent; color: white; border:none;" required>
                    <option value="" disabled selected>Select District</option>
                    <option value="Alappuzha">Alappuzha</option>
                    <option value="Ernakulam">Ernakulam</option>
                    <option value="Idukki">Idukki</option>
                    <option value="Kannur">Kannur</option>
                    <option value="Kasaragod">Kasaragod</option>
                    <option value="Kollam">Kollam</option>
                    <option value="Kottayam">Kottayam</option>
                    <option value="Kozhikode">Kozhikode</option>
                    <option value="Malappuram">Malappuram</option>
                    <option value="Palakkad">Palakkad</option>
                    <option value="Pathanamthitta">Pathanamthitta</option>
                    <option value="Thiruvananthapuram">Thiruvananthapuram</option>
                    <option value="Thrissur">Thrissur</option>
                    <option value="Wayanad">Wayanad</option>
                </select>
            </div>
<!-- 
            <div class="form-group form-elements">
              <i class="fas fa-lock "></i>
              <input type="password" name="password" style="background: transparent; color:white;" class="form-control form-input" id="password" aria-describedby="emailHelp" placeholder="Password" required>
            </div> -->

            <div class="form-group form-elements">
               
                <div class="input-group d-flex justify-content-center align-items-center">
                   <i class="fas fa-lock "></i>
                    <input type="password" id="password" name="password" style="background:transparent; color:white;" class="form-control form-input" placeholder="Enter your password" required>
                    <i class="fas fa-eye" id="eye-icon"></i>
                    </span>
                </div>
            </div>

            <!-- <div class="form-group form-elements " >
              <i class="fas fa-lock "></i>
              <input type="password" name="cpassword" style="background: transparent; color:white;" class="form-control form-input" id="cpassword" aria-describedby="emailHelp" placeholder="Confirm Password" required>
            </div> -->

            <div class="form-group form-elements">
               
                <div class="input-group d-flex justify-content-center align-items-center">
                   <i class="fas fa-lock "></i>
                    <input type="password" id="password2" name="cpassword" style="background:transparent; color:white;" class="form-control form-input" placeholder="Enter your password" required>
                    <i class="fas fa-eye" id="eye-icon2"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex  justify-content-center align-items-center w-100 ">

                <button  class="btn btn-primary button" type="submit" name="signup">Signup</button>

            </div>
            <p class="text-center text-light">Alredy a memmber? <a href="login.php">Login here</a></p>
                <p class="social-text text-light">Or</p>
                <div class="social-media mb-3">
                    <a href="" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                   <a href="" class="social-icon">
                     <i class="fab fa-google"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
        </form>
    </div>
</div>
       </div>
    <!-- </div> -->

    <script src="js/nn.js"></script>
</body>
</html>