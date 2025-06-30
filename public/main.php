<?php

include('connection.php');
session_start();
$location = basename(__FILE__);
$_SESSION['location'];
$conmsg='';

// Check if form is submitted
if($_SESSION['email']){
   
    if (isset($_POST['contact_sub'])) {
        // Get form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
    
        // Validate input
        if (empty($name) || empty($email) || empty($message)) {
           $conmsg = "Please fill in all fields.";
        }
    
        // Prepare SQL statement
        $sql = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";
    
        // Execute SQL statement
        if (mysqli_query($conn, $sql)) {
           
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    
        // Close connection
        mysqli_close($conn);
    }
    
}else{
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link  rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

  <style>
    /* styles.css */

/* styles.css */

/* About Section Styles */
.about {
    background-color: #f8f9fa;
    padding: 40px 0;
}

.about h2 {
    color: #007bff;
    margin-bottom: 20px;
    font-weight: bold;
}

.about h3 {
    color: #343a40;
    margin-bottom: 15px;
    font-weight: bold;
}

.about p {
    line-height: 1.6;
    margin-bottom: 20px;
}

.about ul {
    list-style-type: none;
    padding: 0;
}

.about ul li {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.about ul li i {
    color: #007bff;
    margin-right: 10px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}


/* Contact Section Styles */
/* #contact {
    background-color: #f8f9fa;
    color: #212529;
}

#contact h2 {
    color: #007bff;
    font-weight: bold;
} */

#contact .form-label {
    font-weight: bold;
}

#contact .form-control {
    border-radius: 0;
    box-shadow: none;
}

#contact .btn-primary {
    background-color: #007bff;
    border: none;
    border-radius: 0;
}

#contact .btn-primary:hover {
    background-color: #0056b3;
    border: none;
}


  </style>
</head>
<body style="background-color: black;">
<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = 'main.php';
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}
?>
<a  href="<?php echo $previousPage; ?>" style="text-decoration: none;" ><i class="fa-solid fa-arrow-up" style="font-size: 29px; color:#0c0629; position: fixed;right: 17px;bottom: 15px;" ></i></a>

    <?php include 'header.php';?>
    <div class="container-fluid bg-secondary d-flex justify-content-center align-items-center flex-column main" id="main" style="height: 100vh; width:100%; background-repeat:no-repeat; background-size:cover; background-image: url('images/ss.webp');">
        <!-- <div class="container" >
            <h1 class="text text-dark" style="font-size: 45px; font-weight:900; ">WHO WINS ?</h1>
            <p class="text " style="font-size:20px; font-weight:900; word-spacing: 1px;">Success  is  no  accident. it is hard work,  perseverance, learning, studying, sacrifice, and most of all, love of what you are doing or learning to do </p>
        </div> -->
        <div class="container-fluid"style="position:absolute; top:850px; background:white; height:100px"></div>
    </div>
   
        

        <!-- About Section -->
<!-- About Section                   linear-gradient(rgb(0, 0, 0), rgb(10, 16, 75));-->
<!-- About Section for Admin Dashboard -->
<section id="about" class="about py-5 " style="height:100%; color:white; background: white">
    <div class="container pt-5" >
        <div class="row text-center mb-4">
            <div class="col">
                <h2 class="display-4">About Us</h2>
                <p class="lead text-dark">An overview of the platform designed to manage sports clubs and their members efficiently.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-primary">Platform Overview</h3>
                <p class="text-dark">This platform is designed to streamline the management of sports clubs and their members. It provides tools for registration, event management, and member interaction, ensuring a smooth and efficient operation for clubs and a seamless experience for members.</p>
                <p class="text-dark">Admins can oversee multiple clubs, manage events, and view analytics to ensure everything is running smoothly. The platform’s goal is to enhance communication, organization, and engagement within the sports community.</p>
            </div>
            <div class="col-md-6">
                <h3 class="text-primary">Key Features</h3>
                <ul class="list-unstyled text-dark">
                    <li><i class="fas fa-users text-dark"></i> Manage multiple clubs and users</li>
                    <li><i class="fas fa-calendar-alt text-dark"></i> Schedule and manage events</li>
                    <li><i class="fas fa-bell text-dark"></i> Automated notifications for updates</li>
                    <li><i class="fas fa-chart-line text-dark"></i> Access to performance analytics</li>
                    <li><i class="fas fa-cogs text-dark"></i> Customizable settings and preferences</li>
                </ul>
            </div>
        </div>
       
    </div>
</section>


    
<div class="row  mx-auto d-flex justify-content-center align-items-center" style="height: auto; color:white; background: white;  padding-bottom:40px;" id="sportsclubs">
        <h1 class="text-center text-primary" style="font-weight: 900; margin-top:60px; margin-bottom:80px;"><u>SPORTS</u></h1>
        <?php
            $sql = "SELECT * FROM `sports`";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
               
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-lg-3 col-sm-12 sports ">
                        <a href="clubs.php?sport_id=<?php echo $row['sp_id']; ?>">
                             <div class="img" style="background-image: url('images/<?php echo $row['image']; ?>');">

                             </div>
                            <h3 class="text-center text-dark"><?php echo $row['name']; ?></h3>
                        </a>
                    </div>
                    <?php
                }
            }
        ?>

            
            
        </div>


        <!-- Contact Section -->
<div class="container-fluid  text-dark py-6 d-flex justify-content-center align-items-center" id="contact" style="height: 100vh; color:white; background: white;">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Details -->
            <div class="col-lg-6 col-md-12">
                <h2 class="text-primary mb-4">Contact Us</h2>
                <p class="mb-4 text-dark">Have any questions or need support? Feel free to reach out to us using the contact form or the details below. We are here to help you!</p>
                <div class="d-flex mb-3">
                    <i class="fa fa-map-marker-alt me-3 text-primary" style="font-size: 1.5rem;"></i>
                    <div>
                        <h5 class="text-dark mb-1">Our Address</h5>
                        <p class="text-dark">123 Sports Avenue, City, Country</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fa fa-phone-alt me-3 text-primary" style="font-size: 1.5rem;"></i>
                    <div>
                        <h5 class="text-dark mb-1">Phone</h5>
                        <p class="text-dark">+1 (234) 567-8901</p>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <i class="fa fa-envelope me-3 text-primary" style="font-size: 1.5rem;"></i>
                    <div>
                        <h5 class="text-dark mb-1">Email</h5>
                        <p class="text-dark">support@sportsclub.com</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-6 col-md-12">
                <h2 class="text-primary mb-4">Get In Touch</h2>
                <form action="" method="post">

                <p class="text-danger"><b><?php echo $conmsg; ?></b></p>
                    <div class="form-group mb-3">
                        <label for="name" class="form-label text-dark">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label text-dark">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message" class="form-label text-dark">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary text-dark" name="contact_sub">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>


        <?php include('footer.php'); ?>
</body>
</html>