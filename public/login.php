
<?php
include "connection.php";
session_start();





if (isset($_POST['login'])) {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $msg = '';
    // Check in user table
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    $data = mysqli_fetch_array($result);

    if ($data && password_verify($password, $data['password'])) {
        // Update login count for user
        $login_count = $data['login_count'] + 1;
        $update_sql = "UPDATE user SET login_count = $login_count WHERE email = '$email'";
        mysqli_query($conn, $update_sql);

        // Set session and redirect based on user type
        if ($data['user_type'] == 'admin') {
            $_SESSION['user_type'] = $data['user_type'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $data['id'];

            header('location:admin_pannel.php');
        } else {
            $_SESSION['email'] = $data['email'];
            $_SESSION['user_type'] = 'user';
            header('location:main.php');
        }

    } else {
        // Check in club table
        $sql = "SELECT * FROM club WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die('Error: ' . mysqli_error($conn));
        }

        $data = mysqli_fetch_array($result);

        if ($data && password_verify($password, $data['password'])) {
            // Update login count for club
            $login_count = $data['login_count'] + 1;
            $update_sql = "UPDATE club SET login_count = $login_count WHERE email = '$email'";
            mysqli_query($conn, $update_sql);

            $_SESSION['email'] = $data['email'];
            $_SESSION['user_type'] = 'club';
            header('location:main.php');
        } else {
            // Check in admin table
            echo "hiii";
            $sql = "SELECT * FROM amdin WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die('Error: ' . mysqli_error($conn));
            }

            $data = mysqli_fetch_array($result);

            if ($password == $data['password']) {
                echo "hbbbbj";
                // Update login count for admin
                $login_count = $data['login_count'] + 1;
                echo $login_count;
                $update_sql = "UPDATE amdin SET login_count = $login_count WHERE email = '$email'";
                mysqli_query($conn, $update_sql);

                $_SESSION['email'] = $data['email'];
                header('location:admin_pannel.php');

            } else {
                $msg = '<span class="text text-danger">Invalid email or password</span>';
            }
        }
    }
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
    <div class="d-flex justify-content-center " style=" background: linear-gradient(#000, #0a104b);">
       <!-- <div class="row rowcontainer mt-5"> -->
        <!-- <div class="container1 p-0 d-none col-lg-6 col-md-6 d-sm-block " id="container1" style="background-image: url('images/rg.webp');">
            
        </div> -->
<div class="container2 " style="background-color: transparent;">
    <h3 ><span class="underline" id="head">login Here !</span></h3>
    <span id="password_match" class="text text-danger"></span>
    <div class="form">
        <form method="post" >
        <h4 ><span class="underline" id="short-head">login Here !</span></h4>

           
            <?php echo $msg; ?>
            <div class="form-group form-elements ">
                <i  class="fas fa-envelope  "></i>
                <input type="text" name="email" style="background: transparent; color:white;" class="form-control form-input"   placeholder="Email" required>
            </div>

           

            
            
            <div class="form-group form-elements ">
               
                <div class="input-group d-flex justify-content-center align-items-center">
                   <i class="fas fa-lock "></i>
                    <input type="password" id="password" style="background:transparent; color:white;" class="form-control form-input" name="password" placeholder="Enter your password" >
                    <i class="fas fa-eye" id="eye-icon"></i>
                    </span>
                </div>
            </div>
            <a href="for_password.php">forgot password?</a>
            <div class="d-flex  justify-content-center align-items-center w-100 mt-3">

                <button  class="btn btn-primary button" type="submit" name="login">login</button>

            </div>
            <p class="text-center text-light">don't have an account? <a href="register.php">register here</a></p>
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

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/nn.js"></script>
</body>
</html>