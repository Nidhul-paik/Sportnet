<?php 
    include("connection.php");
    require 'functions.php';
    session_start();

    // Check if session contains email
    if (!isset($_SESSION['email'])) {
        die("No email found in session.");
    }

    if (isset($_POST['send'])) {
       
        
        // Sanitize and retrieve the inputs
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
       
        // Retrieve email from session
        $email = $_SESSION['email'];
        


       
        $result = updatePassword($email, $password);
        if ($result) {
            $msg = "<span class='text text-success'>Password successfully changed. You can log in now.</span>";
            echo "<script>
            setTimeout(function(){
                window.location.href = 'login.php';
            }, 3000); // Redirect to success page after 3 seconds
        </script>";
        } else {
            $msg = "<span class='text text-danger'>Something went wrong.</span>";
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

<div class="container " style="display: flex;justify-content: space-evenly;align-items: center;height: 100vh; flex-direction:column;">
    <h3 ><span style="font-weight: 900; font-size:35px; margin-bottom:20px;" id="head">Reset your password</span></h3>
    <?php echo $msg; ?>
    <span id="password_match"></span>
    <div class="form" style="background: linear-gradient(#000, #0a104b);height:350px; width:500px;box-shadow: 1px 1px 30px 4px gray;" >
        <form method="post" style="background: transparent;height: 300px;display: flex;justify-content: center;align-items: center;flex-direction: column;" >
            
            

            

           

            <div class="form-group form-elements">
               
                <div class="input-group d-flex justify-content-center align-items-center">
                   <i class="fas fa-lock "></i>
                    <input type="password" id="password" name="password" style="background:transparent; color:white;" class="form-control form-input" placeholder="Enter your password" required>
                    <i class="fas fa-eye" id="eye-icon"></i>
                    </span>
                </div>
            </div>

          

            <div class="form-group form-elements">
               
                <div class="input-group d-flex justify-content-center align-items-center">
                   <i class="fas fa-lock "></i>
                    <input type="password" id="password2" name="cpassword" style="background:transparent; color:white;" class="form-control form-input" placeholder="Enter your password" required>
                    <i class="fas fa-eye" id="eye-icon2"></i>
                    </span>
                </div>
            </div>
            
            
            <div class="d-flex justify-content-center align-items-center w-100 ">
                <button  class="btn btn-primary button"  type="submit" name="send">send</button>
            </div>
                
        </form>
    </div>
</div>
      <script src="js/nn.js"></script>
</body>
</html>