
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    session_start();
    include('connection.php');
    // include('functions.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
  
    require_once __DIR__ . '/../vendor/autoload.php'; // Load PHPMailer and dotenv

    // Load .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        header('location:login.php');  // Redirect to login if session not set
        exit();  // Ensure no further code execution
    }

    $email = $_SESSION['email'];  // User is logged in, so you can safely use $_SESSION['email']

    try {
        if (isset($_POST['p_update'])) {
            // Update club details
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $district = mysqli_real_escape_string($conn, $_POST['district']);
            $mobile = mysqli_real_escape_string($conn, $_POST['mob']);
            $club = mysqli_real_escape_string($conn, $_POST['cname']);
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $image = $_FILES['image']['name'];
            $image_temp_name = $_FILES['image']['tmp_name'];
            $image_folder = "images/" . basename($image);

            $sql = "UPDATE `club` SET `club_name`='$club',`Man_name`='$name',
                    `mobile`='$mobile',`district`='$district',`logo`='$image' WHERE email = '$email'";

            $result = mysqli_query($conn, $sql);
            if ($result) {
                if (move_uploaded_file($image_temp_name, $image_folder)) {
                    header('Location: club_pannel.php');
                    exit();
                }
            }
        }

        // Other functionality...


        if($_SESSION['email']){


            $hour = date('H'); // Get the current hour in 24-hour format (00-23)
        
        
            if ($hour >= 5 && $hour < 12) {
                $timeOfDay = "Good Morning";
            } elseif ($hour >= 12 && $hour < 17) {
                $timeOfDay = "Good Afternoon";
            } elseif ($hour >= 17 && $hour < 21) {
                $timeOfDay = "Good Evening";
            } else {
                $timeOfDay = " Good Night";
            }
            
            $email = $_SESSION['email'];
        
            
        
            $sql="SELECT * FROM `club` WHERE email = '$email'";
        
            $result = mysqli_query($conn,$sql);
        
            if($result){
                
             if(mysqli_num_rows($result)>0){
              $data = mysqli_fetch_assoc($result);
              $id = $data['club_id'];
              $_SESSION['club_id'] = $id;
             }
            }
        }else{
            header('location:login.php');
        }
        
        
        if(isset($_POST['event_del'])){
         $id = $_POST['id'];
        
         $sql = "DELETE FROM `events` WHERE event_id = '$id'";
         if(mysqli_query($conn,$sql)){
            header('location:club_pannel.php');
            exit();
         }
        }
        
        if(isset($_POST['del_user'])){
          $email = $_POST['email'];
            $sql  = "DELETE FROM clubuser WHERE email = '$email'";
            $result = mysqli_query($conn,$sql);
            if($result){
                $sql = "SELECT * FROM user WHERE email = '$email'";
                $re = mysqli_query($conn,$sql);
                $da = mysqli_fetch_assoc($re);
                $id = $da['user_id'];

                $sq = "SELECT * FROM auction WHERE player = '$id'";
                $rl = mysqli_query($conn,$sq);
                
                if(mysqli_num_rows($rl)>0){
                    $sql  = "DELETE FROM auction WHERE player = '$id'";
                    $result = mysqli_query($conn,$sql);
                    header('location:club_pannel.php');
                    exit();
                }
                header('location:club_pannel.php');
                exit();
            }
        
        
        }
        
        if (isset($_POST['player_rqst'])) {
            
            $crnt_club = $_POST['current_club'];
            $crnt_amount = $_POST['current_amount'];
            $player = $_POST['player'];
            $offer_amount = $_POST['r_amount'];
            $offer_club = $_SESSION['email'];  // Assuming you're storing the club's email in session
        
            $sql = "SELECT  email FROM club WHERE email = '$offer_club'";
            $rs = mysqli_query($conn,$sql);
            if(mysqli_num_rows($rs)>0){
            
            // Insert query
            $sql = "INSERT INTO `auction` (`current_club`, `player`, `offer_club`, `current_amount`, `offer_amount`) 
                    VALUES ('$crnt_club','$player','$offer_club','$crnt_amount', '$offer_amount')";
        
            // Execute query
            $result = mysqli_query($conn, $sql);
        
            if ($result) {
                header('Location: club_pannel.php');
                exit();  // Best practice to exit after header redirect
            } else {
                echo "Error: " . mysqli_error($conn);  // Display the actual error for debugging
            }
        }else{
            header('location:login.php');
            exit();
        }
        }
        
        
        
        if(isset($_POST['like'])){
        
            
            $offer = $_POST['offer'];
          
            //checking user status is true
        
            $sql = "SELECT * FROM auction WHERE id = '$offer'";
            if(mysqli_num_rows($result=mysqli_query($conn,$sql))>0){
             echo "ssss";
                $data = mysqli_fetch_assoc($result);
                $offer_club = $data['offer_club'];
                $current = $data['current_club'];
        
                $sq = "SELECT  club_name,mobile FROM club WHERE club_id = '$current'";
                $rs = mysqli_query($conn,$sq);
                if(mysqli_num_rows($rs)>0){
                    echo "nnn";
                    $d = mysqli_fetch_assoc($rs);
                    $club_name = $d['club_name'];
                    $mobile = $d['mobile'];
                }
              
           
                if($data['user_status']=='true'){
                    
                
                    $sql = "UPDATE auction SET club_status = 'true' WHERE  id = '$offer'";
                    $result = mysqli_query($conn,$sql);
        
                
                    if($result){
                        
                        
                        $mail = new PHPMailer(true);
        
                        try {
                            //Server settings
                            $mail->SMTPDebug = 0;   
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = getenv('MAIL_USERNAME');
                            $mail->Password   = trim(getenv('MAIL_PASSWORD'));// Use App Password here
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = 587;
        
                            //Recipients
                            $mail->setFrom(getenv('MAIL_USERNAME'), 'SportNet');
                            $mail->addAddress($offer_club);  // Verify this email is correct
        
                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = 'Request Status';
                            $mail->Body    = '<h2>'.$club_name.' Accepted you Request </h2>
                                            <p>Contact them '.$mobile.'</p>
                                        ';
        
                            $mail->send();
                            header('location:club_pannel.php');
                        } catch (Exception $e) {
                            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
        
                    }
                }else{
                    $sql = "UPDATE auction SET club_status = 'true' WHERE  id = '$offer'";
                    $result = mysqli_query($conn,$sql);
                }
            }
        }
          
          
          if(isset($_POST['dislike'])){
            
            $offer = $_POST['offer'];
           
            $sql = "UPDATE auction SET club_status = 'false' WHERE id = '$offer'";
            $result = mysqli_query($conn,$sql);
            if($result){
              header('location:club_pannel.php');
              exit();
            }
          }
        
        
          // player tranfer 
        
          if(isset($_POST['transfer'])){
            $name = $_POST['name'];
            $player_id = $_POST['player_id'];
            $position = $_POST['position'];
            $jersy = $_POST['jersy'];
            $amount = $_POST['amount'];
            $club = $_POST['current_club'];
            $date = $_POST['date'];
            $offer_amount = $_POST['offer_amount'];
            $offer_club = $_POST['offer_club'];
            $auction_id = $_POST['auction'];
        
            echo $name.'<br>'.$player_id.'<br>'.$position.'<br>'.$jersy.'<br>'.$amount.'<br>'.$club.'<br>'.$date.'<br>'.$offer_amount;
        
            // Insert into player history
            $sql = "INSERT INTO `player_history` (`player_id`, `name`, `club`, `jersy_no`, `position`, `amount`, `date`) 
                    VALUES ('$player_id', '$name', '$club', '$jersy', '$position', '$amount', '$date')";
            $result = mysqli_query($conn, $sql);
        
            if ($result) {
                
                // Fetching player email
                $sq = "SELECT email FROM user WHERE user_id = '$player_id'";
                $rs = mysqli_query($conn, $sq);
                $ss = mysqli_fetch_assoc($rs);
                $player_email = $ss['email'];
                
               
                // Fetching club id
                $sq1 = "SELECT club_id FROM club WHERE email = '$offer_club'";
                $rs1 = mysqli_query($conn, $sq1);
                $sss = mysqli_fetch_assoc($rs1);
                $club_id = $sss['club_id'];
        
               
                // Update clubuser
                $sql = "UPDATE `clubuser` SET `club_id` = '$club_id', `amount` = '$offer_amount', `add_date` = '$date' 
                        WHERE email = '$player_email'";
                $rslt = mysqli_query($conn, $sql);
        
                if ($rslt) {
                    
        
                    $sql = "DELETE FROM auction WHERE player = '$player_id'";
            $result= mysqli_query($conn, $sql);
                    
                   if($result){
                    header('location:club_pannel.php');
                    exit();
                   }
                }
            }
        }
        
        
             
        
    } catch(Exception $e) {
        echo $e->getMessage();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles.css">

    <style>



.sports_input[type="date"] {
    background-color: inherit; /* Ensure background color is inherited */
    border: none; /* Remove border if any */
    outline: none; /* Remove outline */
    cursor: pointer; /* Set cursor to pointer */
}

.sports_input[type="date"]:focus {
    background-color: inherit; /* Maintain background color on focus */
    outline: none; /* Ensure no outline on focus */
    box-shadow: none; /* Remove any box shadow on focus */
}
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

.sidebar {
    width: 20%;
    background: white;
    color: white;
    height: 100vh;
    position: fixed;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px;
}

.sidebar ul li a {
    color: #b0f5d8;
    text-decoration: none;
    display: block;
}

.contents {
    margin-left: 250px;
    padding: 20px;
    width: calc(100% - 250px);
}

.contents-section {
    position: absolute;
    top: -900px;
    width: 80%;
    background-color: white;
    height: 100vh;
}

.view{
    top: 0px;
    right:0px
}
.contents-section h2 {
    margin-top: 0;
}
.dashcon{
    width: 100%;
    height: 70px;
    display: flex;
    justify-content: start;
    align-items:center;
    font-size: 25px;
    font-weight: 900;
    background-color: #0c0629;
}
.dumcon{
    width: 100%;
    height: 35px;
    background-color:#0c0629;
    
}
@media(max-width:485px){
    .sidebar{
        width: 485px;
    }
    
}



.usercontent {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    /* border: 1px solid #ddd; */
    padding: 8px;
    text-align: left;
    height: 90px;
}


th {
    /* background-color: #f4f4f4; */
    background-color: #0c0629;
    color: white;
}

img.user-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.delete-btn {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
}

.delete-btn:hover {
    background-color: #d32f2f;
}

.select{
    background-color: white;
    color: black;
    border-bottom: 2px solid blue;
}

@media screen and (max-width: 768px) {
    table {
        border: 0;
    }
    
    table thead {
        display: none;
    }
    
    table, tbody, tr, td {
        display: block;
        width: 100%;
    }
    
    tr {
        margin-bottom: 15px;
    }
    
    td {
        text-align: right;
        position: relative;
        padding-left: 50%;
    }
    
    td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 10px;
        font-weight: bold;
        text-align: left;
    }
    .contents-section{
        width: 100%;
        
    }
}




/* Basic styles for .view */
.contents-section {
    display: none;
}

.contents-section.view {
    display: block;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
    }
    
    .contents {
        margin-left: 0;
        width: 100%;
    }
}
.head{
    background: white;
    color: black;
    margin-top: -22px;
    height: 100px;
    justify-content: start;
    display: flex;
    align-items: center;
}

.usercontent{
    width:100%;
    
}

    </style>
</head>
<body>
    <?php

if($_SESSION['email']){


    $hour = date('H'); // Get the current hour in 24-hour format (00-23)


    if ($hour >= 5 && $hour < 12) {
        $timeOfDay = "Good Morning";
    } elseif ($hour >= 12 && $hour < 17) {
        $timeOfDay = "Good Afternoon";
    } elseif ($hour >= 17 && $hour < 21) {
        $timeOfDay = "Good Evening";
    } else {
        $timeOfDay = " Good Night";
    }
    
    $email = $_SESSION['email'];

    

    $sql="SELECT * FROM `club` WHERE email = '$email'";

    $result = mysqli_query($conn,$sql);

    if($result){
        
     if(mysqli_num_rows($result)>0){
      $data = mysqli_fetch_assoc($result);
      $id = $data['club_id'];
      $_SESSION['club_id'] = $id;
     }else{
        header('location:login.php');
     }
    }

?>
    
<div>
    <div class="sidebar" id="sidebar">
    <?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = 'main.php';
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}
?>


    <div class="w-100 dash-head " style="overflow: scroll;"> <a href="<?php echo $previousPage; ?>"style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:#0c0629; margin-left: 15px;margin-right: 40px; margin-top: 19px;" ></i></a>
    SportNet</div>
        <ul>
            <div class="dumcon" id="dum1"></div>

            <div style="background: #0c0629;" >
                <div class="dashcon" id="detail">
                    <li><a style="color: gray;" href="#" id="">Account</a></li>
                </div>
            </div>

            <div class="dumcon" id="dum2"></div>

            <div style="background: #0c0629; ">
                <div class="dashcon" id="user">
                    <li><a style="color: gray;" href="#" id="li">Members</a></li>
                </div>

            </div>

            <div class="dumcon" id ="dum3"></div>

            <div style="background: #0c0629; ">
                <div class="dashcon"  id="school">
                    <li><a style="color: gray;" href="#" id="li">Your Events</a></li>
                </div>
            </div>

            <div class="dumcon" id="dum4"></div>

           <div style="background: #0c0629;" >
                <div class="dashcon" id="course">
                    <li><a style="color: gray;"  >All Players</a></li>
                </div>
           </div>

            <div class="dumcon" id="dum5"></div>

            <div style="background: #0c0629;" >
                <div class="dashcon" id="other">
                    <li><a style="color: gray;"  id="">Auction Status</a></li>
                </div>
            </div>

            <div class="dumcon" id="dum6"></div>

            <div style="background: #0c0629;" >
                <div class="dashcon" >
                    <li><a href="playerhistory.php" style="color: gray; text-decoration:none;"  id="">PlayerHistory</a></li>
                </div>
            </div>

            <div class="dumcon" id="dum"></div>
            <div class="dumcon" id="dum"></div>

            <div style="background: #0c0629;" >
                <div class="dashcon" id="other">
                <li style="background: #0c0629;"><a class="dashcon text-gray" href="logout.php">Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>

                </div>
            </div>

           

            

            <div class="dumcon" id="dum"></div>
            <div class="dumcon" id="dum"></div>
        </ul>
    </div>
   
    <div class="contents">

        <div class="container-fluid" style="background: white;height: 101px;width: 80%;margin: -20px;position: fixed;right: 18px; z-index:1;">
        <div class="d-flex justify-content-center align-items-center" style="width: 300xp; float:right; height:100%;">
        <img class="nav-item img-fluid nav-img" src="images/<?php echo $data['logo']; ?>" style="width: 60px;height: 60px;border-radius: 50%; margin:5px; box-shadow: 0px 0px 12px 1px gray;" alt="Login">
        <h3><?php echo $data['club_name']; ?></h3>
        </div>

    </div>
    <!-- <h1 class="text-center text-dark" style="position: absolute;bottom: 400px;right: 500px;font-size: 56px;font-weight: 900;"><?php echo $timeOfDay; ?> <?php echo $data['club_name']; ?></h1> -->

    <div id="users" class="contents-section"  style="margin-top: 100px;">
                <!-- Users table content here -->
            
        <div class="usercontent" >
            <h2 style="text-align: center; font-size:28px; font-weight:900; margin-bottom:50px">Users</h2>
            <a href="hello.php?W=<?php echo $_SESSION['club_id']; ?>"><button class="btn-success" id="add_mbr" style="margin-bottom: 20px;border: none;width: 200px;height: 50px;border-radius: 30px;">Add Members</button></a>
            <?php 
                        $count = 1;
            // First query to get all members of the club

                $date = date("Y-m-d");
                    $sql1 = "SELECT * FROM clubuser WHERE club_id ='$id' ";
                    $result1 = mysqli_query($conn, $sql1);

                    if(mysqli_num_rows($result1) > 0){
                        ?>
            <table >
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Position</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>age</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                       
                        // Loop through each member in the clubuser table
                        while($data = mysqli_fetch_assoc($result1)){
                            $email = $data['email'];
                            

                            // Second query to get user details from the user table
                            $sql2 = "SELECT * FROM user WHERE email ='$email'";
                            $result2 = mysqli_query($conn, $sql2);

                            if(mysqli_num_rows($result2) > 0){
                                // Loop through each user found
                                while($row = mysqli_fetch_assoc($result2)){
                                    ?>
                                    <tr style="border-bottom:2px solid gray;">
                                    <!-- style="box-shadow: 0px 0px 0px 2px #eee;" -->
                                    <form  method="post">
                                        <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><img src="images/<?php echo $row['image']; ?>" class="user-image"></td>
                                        <td>
                                            <?php $email = $row['email']; 
                                            $sql = "SELECT * FROM `clubuser` WHERE email ='$email'";
                                            $result = mysqli_query($conn,$sql);
                                           
                                            $data = mysqli_fetch_assoc($result);
                                            echo $data['position'];
                                            
                                            ?>
                                        </td>
                                        <td><?php echo $data['number']; ?></td>
                                        <td><?php echo $data['amount'];  ?></td>
                                        
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['mobile']; ?></td>
                        
                                        <input type="hidden" value="<?php echo $row['user_id']; ?>" name="id">
                                        <td>
                                            <button class="delete-btn" name="del_user" type="submit" style="margin:auto;">Delete</button>
                                            <button class="delete-btn"><a href="update_page.php?V=<?php echo $data['email']; ?>" style="text-decoration: none; color:white;"  >Update</a></button>
                                        </td>
                                    </form>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                            }
                        }
                        
                    } else {
                        // $msg = "Club member must be registered in this SpotNet";
                       echo ' <h1>Currently no users </h1>';
                    }
                
            ?>

                            
                
                    
                    
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

        
        </div>

    
    </div>

    <div id="schools" class="contents-section" style="margin-top: 100px;" >
                <!-- School content here -->
                <!-- school table content here-->

        <div class="usercontent">
        <h2 style="text-align: center; font-size:28px; font-weight:900; margin-bottom:50px">Your Events</h2>

        <button id="event" class="bg-success" style="width: 200px; height:50px; border:none; margin-bottom:20px; border-radius:30px;">Add Event</button>
        <table id="main">
            
                <?php 

                $email=$_SESSION['email'];
             
                $sql = "SELECT club_name FROM club WHERE email='$email'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                  
                    $data = mysqli_fetch_assoc($result); // Fetch the result as an associative array
                    $club_name = $data['club_name']; // Access the 'name' column
                  
                }

                // Get today's date
                $today = date("Y-m-d");
                
                // SQL query to get all upcoming events from the database ordered by event_date
                $sql = "SELECT * FROM events WHERE club_name ='$club_name' AND event_date >= '$today' ORDER BY event_date ASC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    ?>
                    <thead>
                <tr>
                    <th>Serial No.</th>
                    <th>event</th>
                    <th>event type</th>
                    <th>club</th>
                    <th>Date</th>
                    
                    <th>View</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $serial_no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr style="border-bottom:2px solid gray;">
                            <td><?php echo $serial_no++; ?></td>
                            <td><img style="width:100px;" src="images/<?php echo $row['image']; ?>" alt=""></td>

                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['club_name']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['event_date'])); ?></td>
                            <td><a href="events.php?id=<?php echo $row['event_id']; ?>" class="btn btn-info">View Details</a></td>

                            <td><button class="delete-btn" name="delete" type="submit" style="margin:auto;">Delete</button></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No upcoming events found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        </div>

        
    </div>


<!-- -------------- All playeres section  ------------->

    <div id="courses" class="contents-section" style="margin-top: 100px;" >

         
    <div class="usercontent" >
            <h2 style="text-align: center; font-size:28px; font-weight:900; margin-bottom:50px">Users</h2>
            <table >
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Current club</th>
                        <th>Position</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>Highest Offer</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                        <?php 
                        $count = 1;
                        $email = $_SESSION['email'];
                       
                        $sql = "SELECT * FROM club WHERE email = '$email'";
                        $result  = mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0){
                           
                        $data = mysqli_fetch_assoc($result);
                        $type = $data['club_type'];
                       
            // First query to get all members of the club

                $date = date("Y-m-d");
                    $sql1 = "SELECT * FROM clubuser WHERE sport_type = '$type' ";
                    $result1 = mysqli_query($conn, $sql1);

                    if(mysqli_num_rows($result1) > 0){
                        // Loop through each member in the clubuser table
                        while($data = mysqli_fetch_assoc($result1)){
                            $email = $data['email'];
                            

                            // Second query to get user details from the user table
                            $sql2 = "SELECT * FROM user WHERE email ='$email'";
                            $result2 = mysqli_query($conn, $sql2);

                            if(mysqli_num_rows($result2) > 0){
                                // Loop through each user found
                                while($row = mysqli_fetch_assoc($result2)){
                                    ?>
                                    <tr style="border-bottom:2px solid gray;">
                                    <!-- style="box-shadow: 0px 0px 0px 2px #eee;" -->
                                    <form  method="post">
                                        <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                                        <input type="hidden" name="current_club" value="<?php echo $data['club_id']; ?>">
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <input type="hidden" name="player" value="<?php echo $row['user_id']; ?>">
                                        <td><img src="images/<?php echo $row['image']; ?>" class="user-image"></td>
                                        <td><?php $cl=  $data['club_id']; $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM club WHERE club_id = '$cl'")); echo $result['club_name'];  ?></td>
                                        <td>
                                            <?php 
                                            echo $data['position'];
                                            
                                            ?>
                                        </td>
                                        <td><?php echo $data['number']; ?></td>
                                        <input type="hidden" name="current_amount" value="<?php echo $data['amount']; ?>">
                                        <td><?php echo $data['amount'];  ?></td>
                                        <td>
                                          
                                            <?php
                                              
                                            // Get the player from the data array
                                            $player = $data['email'];

                                            $sql = "SELECT * FROM user WHERE email = '$player'";
                                            $rs = mysqli_query($conn,$sql);
                                            $d = mysqli_fetch_assoc($rs);
                                            $p_id =  $d['user_id'];

                                        
                                            // SQL query to select all offers for the specified player
                                            $sql = "SELECT offer_amount FROM auction WHERE player = '$p_id'";
                                            $result = $conn->query($sql);

                                            // Initialize an array to hold offer amounts
                                            $offerAmounts = array();

                                            // Fetch all offer amounts into the array
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $offerAmounts[] = $row['offer_amount'];  // Append offer_amount to the array
                                            }

                                            // Check if the array is not empty and find the highest offer amount
                                            if (!empty($offerAmounts)) {
                                                $highestOffer = max($offerAmounts);  // Find the maximum offer amount
                                                echo $highestOffer;  // Display the highest offer amount
                                            } else {
                                                echo "No offers";  // Message if there are no offers
                                            }
                                            ?>
                                        </td>

                                        
                        
                                        <input type="hidden" value="<?php echo $row['user_id']; ?>" name="id">
                                        <td>
                                          <?php 

                                            $user = $_SESSION['email'];
                                            $rqstclub_id = $data['club_id'];
                                            $result = mysqli_query($conn,"SELECT  * FROM club WHERE email = '$user'");
                                            if(mysqli_num_rows($result)>0){
                                               
                                                $data = mysqli_fetch_assoc($result);
                                                $club_id = $data['club_id'];
                                               
                                            }

                                           
                                           
                                           
                                        if($rqstclub_id == $club_id){
                                            echo "<button class = 'btn-success'>It's your player</button></button>";
                                        
                                            
                                        
                                          }else{
                                            ?>
                                            <input type="text" class="bg-light" name="r_amount" placeholder="enter offer amount">
                                            <button class="delete-btn" name="player_rqst" type="submit" style="margin:auto;">Send Request</button>
                                           <?php
                                          }
                                        ?>

                                     
                                         </td>
                                    </form>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                            }
                        }
                        
                    } else {
                        $msg = "Club member must be registered in this SpotNet";
                    }
                        }
            ?>

                            
                
                    
                    
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

        
        </div>

    </div>
  
    <div id="others" class="contents-section" style="margin-top: 100px;" >
        <div class="usercontent">

       
        <?php
              $email = $_SESSION['email'];
              if($email){
                $sql ="SELECT * FROM club WHERE email = '$email'";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['club_id'];
               
              }

              $sql ="SELECT * FROM auction WHERE current_club = '$id'";
              $result2 = mysqli_query($conn,$sql);
              if(mysqli_num_rows($result2)>0){
                ?>  <h2 class="text-center mb-5" >Offers</h2><?php
                ?>
                 <table class="mb-5" >
                  <thead>
                    <th>SI</th>
                    <th>player</th>
                    <th>Jersy NO</th>
                    <th>Amount Offered</th>
                    <th>offered By</th>
                    <th>Player Status</th>
                    <th>Club Status</th>
                    <th>Transfer</th>
                  </thead>
                  <tbody>

                 <?php
                 $count=1;
                while($data = mysqli_fetch_assoc($result2)){
                  ?>
                  <tr style="border-bottom:2px solid gray;">
                    <form action="" method ="post">
                      <input type="hidden" name="offer" value="<?php echo $data['id']; ?>">
                       
                      <td><?php echo $count;  ?></td>
                      
                      <td>
                        <input type="hidden" value="<?php echo $data['player']; ?>" name="player_id">
                        <input type="hidden" name="auction" value="<?php echo $data['id']; ?>">
                      <?php 
                         $current_club = $_SESSION['email'];

                          $user_id =  $data['player']; 
                          
                          $result = mysqli_query($conn,"SELECT * FROM user WHERE user_id = '$user_id'");
                          $row = mysqli_fetch_assoc($result);
                          echo $row['name'];
                          
                          ?>
                          <input type="hidden" name="current_club" value="<?php echo $current_club; ?>">
                        <input type="hidden" name = "name" value="<?php echo $row['name']; ?>">
                      </td>

                      <td>
                      <?php 
                          $user_email = $row['email'];
                          $user_id =  $data['player']; 
                          
                          $result = mysqli_query($conn,"SELECT * FROM clubuser WHERE email = '$user_email'");
                          $row = mysqli_fetch_assoc($result);
                          echo $row['number'];
                          ?>
                        <input type="hidden" name="jersy" value="<?php echo $row['number']; ?>">
                        <input type="hidden" name="position" value="<?php echo $row['position']; ?>">
                        <input type="hidden" name="amount" value="<?php echo $row['amount']; ?>">
                        <input type="hidden" name="date" value="<?php echo $row['add_date']; ?>">
                      </td>

                      <td><?php echo $data['offer_amount'];  ?>
                        <input type="hidden" name="offer_amount"value="<?php echo $data['offer_amount']; ?>" >
                        </td>
                      <td>
                      <?php 
                          $club =  $data['offer_club']; 
                          $result = mysqli_query($conn,"SELECT * FROM club WHERE email = '$club'");
                          $row = mysqli_fetch_assoc($result);
                          echo $row['club_name'];
                          ?>
                         <input type="hidden" name="offer_club" value="<?php echo $data['offer_club']; ?>">
                      </td>

                      <td>
                      <?php  
                        if($data['user_status']=='true'){echo '<i class="fas fa-thumbs-up" style="font-size:25px; color:green;"></i>';}elseif($data['user_status']=='false'){echo '<i class="fas fa-thumbs-down" style="font-size:25px; color:red;"></i>';}else{echo'--';}
                      ?>
                      </td>
                      <td>
                        <button class="btn"  type="submit" name="like"> <i class="fas fa-thumbs-up" style="font-size: 24px; <?php if($data['club_status']=='true'){echo "color:green;";}else{echo "color:#00f500;";} ?> "></i></button>
                        <button class="btn" type="submit" name="dislike">  <i class="fas fa-thumbs-down" style="font-size: 24px; <?php if($data['club_status']=='false'){echo "color:red;";}else{echo "color:#ff8080;";} ?> "></i></button>
                      </td>
                      <td>
                        <?php 
                        if($data['user_status']=='true' && $data['club_status']=='true'){
                            ?>
                        <button class="btn btn-danger" name="transfer" style="width: 200px; height:50px; border:none;" title="before click everify all the transfer procedures are done other wise you may  lose your player" >Transfer</button>
                        <?php
                        }
                        ?>
                      </td>
                    </form>
                  </tr>
                <?php
                $count++;
                }
              }
                ?>

                </tbody>
                </table>

                <h2 class="mt-5 text-center">Request  Status</h2>

                <?php
              $email = $_SESSION['email'];
            //   if($email){
            //     $sql ="SELECT * FROM club WHERE email = '$email'";
            //     $result = mysqli_query($conn,$sql);
            //     $row = mysqli_fetch_assoc($result);
            //     $id = $row['club_id'];
            //   }

              $sql ="SELECT * FROM auction WHERE offer_club = '$email'";
              $result2 = mysqli_query($conn,$sql);
              if(mysqli_num_rows($result2)>0){
                ?>
                 <table >
                  <thead>
                    <th>SI</th>
                    <th>player</th>
                    <th>Jersy NO</th>
                    <th>Amount Offered</th>
                    <!-- <th>offered By</th> -->
                    <th>Player Status</th>
                    <th>Club Status</th>
                  </thead>
                  <tbody>

                 <?php
                 $count=1;
                while($data = mysqli_fetch_assoc($result2)){
                  ?>
                  <tr style="border-bottom:2px solid gray;">
                    <form action="" method ="post">
                      <input type="hidden" name="offer" value="<?php echo $data['id']; ?>">

                      <td><?php echo $count;  ?></td>
                      
                      <td>
                      <?php 
                          $user_id =  $data['player']; 
                          
                          $result = mysqli_query($conn,"SELECT * FROM user WHERE user_id = '$user_id'");
                          $row = mysqli_fetch_assoc($result);
                          echo $row['name'];
                          ?>
                        
                      </td>

                      <td>
                      <?php 
                          $user_email = $row['email'];
                          $user_id =  $data['player']; 
                          
                          $result = mysqli_query($conn,"SELECT * FROM clubuser WHERE email = '$user_email'");
                          $row = mysqli_fetch_assoc($result);
                          echo $row['number'];
                          ?>
                        
                      </td>

                      <td><?php echo $data['offer_amount'];  ?></td>
                      <!-- <td> -->
                      <?php 
                        //   $club =  $data['offer_club']; 
                        //   $result = mysqli_query($conn,"SELECT * FROM club WHERE email = '$club'");
                        //   $row = mysqli_fetch_assoc($result);
                        //   echo $row['club_name'];
                          ?>
                        
                      <!-- </td> -->

                      <td>
                      <?php  
                        if($data['user_status']=='true'){echo '<i class="fas fa-thumbs-up" style="font-size:25px; color:green;"></i>';}elseif($data['user_status']=='false'){echo '<i class="fas fa-thumbs-down" style="font-size:25px; color:red;"></i>';}else{echo'--';}
                      ?>
                      </td>
                      <td>
                      <?php  
                        if($data['club_status']=='true'){echo '<i class="fas fa-thumbs-up" style="font-size:25px; color:green;"></i>';}elseif($data['club_status']=='false'){echo '<i class="fas fa-thumbs-down" style="font-size:25px; color:red;"></i>';}else{echo'--';}
                      ?>
                     </td>
                    </form>
                  </tr>
                <?php
                $count++;
                }
              }
                ?>

                </tbody>
                </table>

        </div>
    </div>


    <div id="details"   class="contents-section" style="margin-top: 100px; height:90%">


        <div class="fullac" style="width: 100%; height:100%;display:flex; justify-content:center; align-items:center;">
            <div class="profile" style="  width: 50%;height: 95%;display: flex;justify-content: center;align-items: center;box-shadow: 0px 0px 27px 1px #deebf7;flex-direction:column;">
            <form action="" method="post" enctype="multipart/form-data" style="width: 90%; height:90%; display:flex; justify-content:center; align-items:center; flex-direction:column;">
            <?php
        
            if($_SESSION['email']){
                $email = $_SESSION['email'];

                

                $sql="SELECT * FROM `club` WHERE email = '$email'";

                $result = mysqli_query($conn,$sql);

                if($result){
                    
                if(mysqli_num_rows($result)>0){
                $data = mysqli_fetch_assoc($result);
                ?>
                <div class="form-group pform " style="width: 200px; height:200px;  margin-bottom:40px; background-repeat:no-repeat; background-image: url('<?php echo ($data['logo'] != 'nothing') ? "images/{$data['logo']}" : "images/logo.jpeg"; ?>'); background-size: cover;border-radius: 50%;box-shadow: 0px 0px 8px 0px gray;display: flex;justify-content: center;align-items: center;">
                    <input type="file" class="account_input" name="image" value=" <?php echo $data['logo']; ?>" style="opacity: 0;" required accept="image/png,image/jpg,image/jpeg,image/webp,image/avif">
                </div>

                <div class="form-group pform " style="width: 90%;">
                    <input type="text" name="cname" class="account_input"  placeholder="Name"value="<?php echo $data['club_name']; ?>">
                </div>

                <div class="form-group  mb-3 pform" style="width: 90%;">
                
                    <select name="type" class="form-control account_input" value=" <?php echo $data['club_type']; ?>" required>
                    <option value=" <?php echo $data['club_type']; ?>" disabled selected> <?php echo $data['club_type']; ?></option>
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

                <div class="form-group pform " style="width: 90%;">
                    <input type="text" name="name" class="account_input" value="<?php echo $data['Man_name']; ?>" placeholder="Mob">
                </div>
                <div class="form-group pform " style="width: 90%;">
                    <input type="text" name="email" class="account_input" value="<?php echo $data['email']; ?>" placeholder="Email">
                </div>

                <div class="form-group pform " style="width: 90%;">
                    <input type="text" name="mob" class="account_input" value="<?php echo $data['mobile']; ?>" placeholder="Mob">
                </div>
                

                <select name="district"  class="form-control account_input"  style="background: transparent; color: black; width:90%;" value="<?php echo $data['district']; ?>" required>
                        <option value="<?php echo $data['district']; ?>" disabled selected><?php echo $data['district']; ?></option>
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
                <button type="submit" name="p_update" class="mx-auto btn btn-light" style="width: 150px; border-radius: 30px; margin-top: 10px;background: #1fff42;">UPDATE</button>
                <?php
                }
                }else{
                echo "something wrong";
                }
            }else{
                header('location:login.php');
            }

            ?>
            
            </form>
            </div>
        </div>
    </div>


</div>


<!-- event add form -->

<div id="event_add" style="position:absolute; height:70vh; width:500px; background-color: #0c0629; left:-600px; top:100px; transition:ease-in .5s; border-radius:70px;">
                <form action="eventnotification.php" class="sports_insert" style="justify-content: start; margin-top:50px;" method="post" enctype="multipart/form-data">
                    <h2 class="text-center text-light" style="font-weight: 900;">Add Events</h2>

                    <div class="form-group w-100">
                    <select name="type" class="form-control form-input my-3" style="background: transparent; color: white; border:none; width: 100%;border-bottom: 2px solid white;" required>
                        <option value="" disabled selected>Select event type</option>
                        <option value="event">event</option>
                        <option value="tournament">tournament</option>
                        <option value="recruitment">recruitment</option>

                        
                    </select>
                    </div>

                                                
                    <div class="form-group w-100 ">
                        <input type="file" class="sports_input my-3" name="image" style="width: 100%;border-bottom: 2px solid white;" required accept="image/png,image/jpg,image/jpeg,image/webp,image/avif">
                    </div>

                    <div class="form-group w-100 ">
                        <input type="date" class="sports_input my-3" name="date" style="width: 100%;border-bottom: 2px solid white;" required >
                    </div>

                    <button type="submit" name="add_event" class="mx-auto btn btn-light mt-5" style="width: 150px; border-radius: 30px; margin-top: 10px;">Add</button>
                </form>
</div>

    <script src="script.js"></script><script>
       


 document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.contents-section');
    const links = document.querySelectorAll('.sidebar ul li a');


    let user = document.getElementById('user');
    let school = document.getElementById('school');
    let course = document.getElementById('course');
    let other = document.getElementById('other');
    let detail = document.getElementById('detail');


    user.addEventListener('click', () => showSection('users','user'));
    school.addEventListener('click', () => showSection('schools','school'));
    course.addEventListener('click', () => showSection('courses','course'));
    other.addEventListener('click', () => showSection('others','other'));
    detail.addEventListener('click', () => showSection('details','detail'));


    let dum1 = document.getElementById('dum1');
    let dum2 = document.getElementById('dum2');
    let dum3 = document.getElementById('dum3');
    let dum4 = document.getElementById('dum4');
    let dum5 = document.getElementById('dum5');
    let dum6 = document.getElementById('dum6');

    function showSection(sectionId,Id) {
  

        sections.forEach(section => {
            if (section.id === sectionId) {
               
                switch(Id){
                    case 'user' : user.style.background='white';
                                  user.style.borderRadius='100px 0px 0px 100px';
                                  
                                detail.style.background='#0c0629';
                                school.style.background='#0c0629';
                                course.style.background='#0c0629';
                                other.style.background='#0c0629';

                                dum2.style.borderRadius = "0px 0px 100px 0px";
                                dum3.style.borderRadius = "0px 100px 0px 0px";
                                dum1.style.borderRadius = "0px 0px 0px 0px";
                                dum4.style.borderRadius = "0px 0px 0px 0px";
                                dum5.style.borderRadius = "0px 0px 0px 0px";
                                dum6.style.borderRadius = "0px 0px 0px 0px";
                                            
                                    
                                break;

                    case 'detail' : detail.style.background='white';
                                    detail.style.borderRadius='100px 0px 0px 100px';
                                    user.style.background='#0c0629';
                                    school.style.background='#0c0629';
                                    course.style.background='#0c0629';
                                    other.style.background='#0c0629';


                                dum1.style.borderRadius = "0px 0px 100px 0px";
                                dum2.style.borderRadius = "0px 100px 0px 0px";
                                dum3.style.borderRadius = "0px 0px 0px 0px";
                                dum4.style.borderRadius = "0px 0px 0px 0px";
                                dum5.style.borderRadius = "0px 0px 0px 0px";
                                dum6.style.borderRadius = "0px 0px 0px 0px";
                                    
                                    break;

                    case 'school' : school.style.background='white';
                                    school.style.borderRadius='100px 0px 0px 100px';

                                    detail.style.background='#0c0629';
                                    user.style.background='#0c0629';
                                    course.style.background='#0c0629';
                                    other.style.background='#0c0629';


                                    dum2.style.borderRadius = "0px 0px 0px 0px";
                                    dum3.style.borderRadius = "0px 0px 100px 0px";
                                    dum1.style.borderRadius = "0px 0px 0px 0px";
                                    dum4.style.borderRadius = "0px 100px 0px 0px";
                                    dum5.style.borderRadius = "0px 0px 0px 0px";
                                    dum6.style.borderRadius = "0px 0px 0px 0px";
                                    
                                    break;

                    case 'course' : course.style.background='white';
                                    course.style.borderRadius='100px 0px 0px 100px';

                                    detail.style.background='#0c0629';
                                    school.style.background='#0c0629';
                                    user.style.background='#0c0629';
                                    other.style.background='#0c0629';


                                    dum2.style.borderRadius = "0px 0px 0px 0px";
                                    dum3.style.borderRadius = "0px 0px 0px 0px";
                                    dum1.style.borderRadius = "0px 0px 0px 0px";
                                    dum4.style.borderRadius = "0px 0px 100px 0px";
                                    dum5.style.borderRadius = "0px 100px 0px 0px";
                                    dum6.style.borderRadius = "0px 0px 0px 0px";
                                    
                                    break;

                    case 'other' : other.style.background='white';
                                    other.style.borderRadius='100px 0px 0px 100px';

                                    detail.style.background='#0c0629';
                                    school.style.background='#0c0629';
                                    course.style.background='#0c0629';
                                    user.style.background='#0c0629';



                                    dum2.style.borderRadius = "0px 0px 0px 0px";
                                    dum3.style.borderRadius = "0px 0px 0px 0px";
                                    dum1.style.borderRadius = "0px 0px 0px 0px";
                                    dum4.style.borderRadius = "0px 0px 0px 0px";
                                    dum5.style.borderRadius = "0px 0px 100px 0px";
                                    dum6.style.borderRadius = "0px 100px 0px 0px";
                                    
                                    break;
                }
            
                section.classList.add('view');
                
            } else {
                section.classList.remove('view');
            }
        });

        links.forEach(link => {
            if (link.id === sectionId) {
                link.style.color = 'rgb(198, 77, 77)';
            } else {
                link.style.color = 'rgb(198, 77, 77)';
            }
        });
    }

 let event = document.getElementById('event');
 let event_add = document.getElementById('event_add');
 let main = document.getElementById('main');

 let flag = 'true';
 event.addEventListener('click',()=>{
    if(flag=='true'){
     flag = 'false';
    //  event_add.style.right='600px';
     event_add.style.left='40%';
    }else{
        flag ='true';
        event_add.style.left='-600px';
    }
   
   
 });

 main.addEventListener('click',()=>{
    event_add.style.left='-600px';
   
 });
   
});

    </script>
</body>
<?php
}else{
    header('location:login.php');
}
?>
</html>
