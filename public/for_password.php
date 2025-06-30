<?php 

include('connection.php');
require('functions.php');
session_start();





$msg = '';
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $_SESSION['email'] = $email;
    $sql = "SELECT * FROM user WHERE email = '{$email}'";
    $sql2 = "SELECT * FROM club WHERE email = '{$email}'";

    if (!mysqli_num_rows(mysqli_query($conn, $sql)) > 0 && !mysqli_num_rows(mysqli_query($conn, $sql2)) > 0) {

        $msg = "User not exists";
    } else {
        $otp = generateOTP();
       
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiration'] = time() + 300; // OTP expires in 5 minutes
        $_SESSION['who']= 'pass';
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

<div class="container-fluid d-flex justify-content-center align-items-center" style=" background: linear-gradient(#000, #0a104b); height:100vh; margin:0;">
    <form action="" method="post">
    
        <h4 class=" text-light text-center mx-auto mb-5" >Forgot Password?</h4>

           
            <p class="text-danger"><?php echo $msg; ?></p>
            <div class="form-group form-elements " id="email">
                <i  class="fas fa-envelope  "></i>
                <input type="text" name="email" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Email" required>
            </div>

            <div class="d-flex  justify-content-center align-items-center w-100 mt-3">

                <button  class="btn btn-primary button" id="emailsub" type="submit" name="submit">submit</button>

            </div>

    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="js/nn.js"></script>


</body>
</html>