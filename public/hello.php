<?php
include('connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// error_reporting(0);
require 'vendor/autoload.php';
session_start();
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['add_club'])) {
    $sports_name = $_POST['name'];
    $sports_image = $_FILES['image']['name'];
    $sports_image_temp_name = $_FILES['image']['tmp_name'];
    $sports_image_folder = "images/" . basename($sports_image);

    // Insert data into the database
    $sql = mysqli_query($conn, "INSERT INTO `sports`(`name`, `image`) VALUES ('$sports_name', '$sports_image')");
    
    if ($sql) {
        if (move_uploaded_file($sports_image_temp_name, $sports_image_folder)) {
            header('Location: admin_pannel.php'); // Corrected typo
            exit(); // Ensure the script stops executing after redirection
        } else {
            $message = "There was an error moving the uploaded file.";
        }
    } else {
        $message = "There was an error inserting the product into the database.";
    }
}

// If there is an error, display the message
if (isset($message)) {
    echo "<div class='alert alert-danger'>$message</div>";
}


// -------------------updating club details-------------------------//
if (isset($_POST['update_club'])) {
    // Fetching the values from the form
    $sp_id = $_POST['sp_id'];
    echo $sp_id;
    $sports_name = $_POST['name'];
    $sports_image = $_FILES['image']['name'];
    $sports_image_temp_name = $_FILES['image']['tmp_name'];
    $sports_image_folder = "images/" . basename($sports_image);

    // SQL query to update the sports details
    $sql = "UPDATE `sports` SET `name`='$sports_name', `image`='$sports_image' WHERE sp_id = '$sp_id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    
    if ($result) {
        // Attempt to move the uploaded file
        if (move_uploaded_file($sports_image_temp_name, $sports_image_folder)) {
            echo'hi';
            // Redirect to admin panel after successful update and file upload
            header('Location: admin_pannel.php');
            exit(); // Ensure the script stops executing after redirection
        } else {
            // Handle file move error
            $message = "There was an error moving the uploaded file.";
            echo "<script>alert('$message');</script>";
        }
    } 
}

$mmsg = '';
if (isset($_POST['add_member'])) {
    $mbremail = $_POST['mbremail'];
    $pos = $_POST['positions'];
    $club = $_POST['club'];
    $no = $_POST['no'];
    $type = $_POST['club_type'];
    $date = $_POST['date'];
    $club_email = $_SESSION['email'];

    // Fetch user details
    $sql = "SELECT * FROM `user` WHERE email = '$mbremail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $V = mysqli_fetch_assoc($result);
        $player_id = $V['user_id'];
        $player_name = $V['name'];
        $amount = 0;

        // Check if the user is already a member in the club
        $sql9 = "SELECT * FROM `clubuser` WHERE email = '$mbremail' AND club_id = '$club'";
        $result9 = mysqli_query($conn, $sql9);

        if (mysqli_num_rows($result9) > 0) {
            $mmsg = "User is already a member in this club";
        } else {
            // Insert player history
            $sss = "INSERT INTO `player_history` (`player_id`, `name`, `club`, `jersy_no`, `position`, `amount`, `date`) 
                    VALUES ('$player_id', '$player_name', '$club_email', '$no', '$pos', '$amount', '$date')";
            $rrr = mysqli_query($conn, $sss);

            // Debug insertion issue if needed
            if (!$rrr) {
                die("Error inserting player history: " . mysqli_error($conn));
            }

            // Insert into clubuser table
            $sql = "INSERT INTO `clubuser` (`club_id`, `sport_type`, `email`, `position`, `number`, `add_date`) 
                    VALUES ('$club', '$type', '$mbremail', '$pos', '$no', '$date')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Fetch club name
                $sq = "SELECT club_name FROM club WHERE club_id = '$club'";
                $rs = mysqli_query($conn, $sq);
                $da = mysqli_fetch_assoc($rs);
                $club_name = $da['club_name'];

                // Fetch player name
                $sq1 = "SELECT name FROM user WHERE email = '$mbremail'";
                $rs1 = mysqli_query($conn, $sq1);
                $daa = mysqli_fetch_assoc($rs1);
                $player_name = $daa['name'];

                // Send email using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('MAIL_USERNAME');
                    $mail->Password = getenv('MAIL_PASSWORD'); // App Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom(getenv('MAIL_USERNAME'), 'SportNet');
                    $mail->addAddress($mbremail);

                    // Email Content
                    $mail->isHTML(true);
                    $mail->Subject = 'A message from ' . $club_name;
                    $mail->Body = "<h2>Hey $player_name</h2><p>Welcome to our club!</p>";

                    $mail->send();
                    header('Location: club_pannel.php');
                    exit();
                } catch (Exception $e) {
                    // Handle email error
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else {
        $mmsg = "User is not registered in this SportNet";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script> -->
    <title>Add New Sports</title>
    <style>
        /* Remove the default Bootstrap focus styles */
        .sports_input:focus {
            outline: none;
            box-shadow: none;
        }

        .form-group .sports_input {
            background-color: inherit;
            /* border: none; */
            outline: none;
        }

        .form-group .sports_input:focus {
            background-color: inherit;
            outline: none;
            box-shadow: none;
        }
    </style>


</head>
<body style="background: linear-gradient(#000, #0a104b);">

    <div id="sports_add_area">
    <?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $page = $_SERVER['HTTP_REFERER'];
} else {
    $Page = 'main.php';  // A default page if no referrer is found
}
?>
<a  href="<?php echo $Page; ?>" style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:white; position: fixed;leftt: 17px;top: 15px;" ></i></a>

        <div><i class="fas fa-times" id="close_sports_add"></i></div>

        <?php


                if(isset($_GET['W'])){

                    $club = $_GET['W'];
                    $sql = "SELECT * FROM club WHERE club_id = '$club'";
                    $result  = mysqli_query($conn,$sql);
                    $data = mysqli_fetch_assoc($result);
                    $type =$data['club_type'];
                    ?>
                    <form action="" class="sports_insert" method="post" enctype="multipart/form-data">

                        <h2 class="text-center text-light" style="font-weight: 900;">Add New member</h2>
                        <p class="text-danger"><?php echo $mmsg; ?></p>
                        <div class="form-group">
                            <input type="text" name="mbremail" class="sports_input" value="" placeholder="Enter email">


                            <input type="hidden" name="club" value="<?php echo $club; ?>">
                        </div>
                        <input type="hidden" name="club_type" value="<?php echo $type; ?>">
                        <div class="form-group">
                        <input type="text" name="no" class="sports_input" value="" placeholder="Enter player number">
                        </div>

                        <div class="form-group">
                            <select id="positions" class= "sports_input" name="positions"  class="form-select" >
                           
                                <option >Select position</option>

                                <?php
                                $date = date('Y-m-d');
                               
                                if($type == 'football'){
                                    echo '
                                    <option value="goalkeeper">Goalkeeper</option>
                                    <option value="defender">Defender</option>
                                    <option value="midfielder">Midfielder</option>
                                    <option value="forward">Forward</option>
                                    ';
                                }elseif($type == 'cricket'){
                                    echo '
                                    <option value="batsman">Batsman</option>
                                    <option value="bowler">Bowler</option>
                                    <option value="all-rounder">All-rounder</option>
                                    <option value="wicketkeeper">Wicketkeeper</option>
                                    ';
                                }elseif($type == 'vollyball'){

                                    echo '
                                    <option value="setter">Setter</option>
                                    <option value="outside-hitter">Outside Hitter</option>
                                    <option value="middle-blocker">Middle Blocker</option>
                                    <option value="opposite-hitter">Opposite Hitter</option>
                                    <option value="libero">Libero</option>
                                    ';
                                }elseif($type == 'basketball'){
                                    echo '
                                    <option value="point-guard">Point Guard</option>
                                    <option value="shooting-guard">Shooting Guard</option>
                                    <option value="small-forward">Small Forward</option>
                                    <option value="power-forward">Power Forward</option>
                                    <option value="center">Center</option>
                                    ';
                                }else{
                                
                                    echo '
                                    <option value="raider">Raider</option>
                                    <option value="defender">Defender</option>
                                    <option value="all-rounder">All-rounder</option>
                                    ';
                                }
                                ?>

                            </select>
                            <input type="hidden" name="date" value="<?php echo $date; ?>">
                        </div>
                        
                        <button type="submit" name="add_member" class="mx-auto btn btn-light" style="width: 150px; border-radius: 30px; margin-top: 10px;">ADD</button>
                    </form>
                <?php
                }else if (isset($_GET['v'])) {
                    // ----------------updating form---------------------//
                    $sp_id = $_GET['v'];
                
                    
                    $sql = "SELECT * FROM `sports` WHERE sp_id = '$sp_id'";
                    
                
                    $result = mysqli_query($conn, $sql);
                
                
                    
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo $row['name'];
                            ?>
                            <form action="" class="sports_insert" method="post" enctype="multipart/form-data">
                                <h2 class="text-center text-light" style="font-weight: 900;">update</h2>
                                <div class="form-group">
                                    <input type="hidden" name="sp_id" value="<?php echo $row['sp_id']; ?>">
                                    <input type="text" name="name" class="sports_input" value="<?php echo $row['name']; ?>" placeholder="Sports name">
                                </div>

                                                            
                                <div class="form-group ">
                                    <input type="file" class="sports_input" name="image" required accept="image/png,image/jpg,image/jpeg,image/webp,image/avif">
                                    <input type="hidden" name="existing_image" value="<?php echo $row['image']; ?>">
                                </div>
                                <button type="submit" name="update_club" class="mx-auto btn btn-light" style="width: 150px; border-radius: 30px; margin-top: 10px;">edit</button>
                            </form>
                            <?php
                        } else {
                            echo "No records found.";
                        }
                        

                } else {
                    ?>

                    <!-- -------------------------adding form ------------------->

                    
                    <form action="" class="sports_insert" method="post" enctype="multipart/form-data">
            
                        <h2 class="text-center text-light" style="font-weight: 900;">Add New Sports</h2>
                        <div class="form-group">
                            <input type="text" name="name" class="sports_input" value="" placeholder="Sports name">
                        </div>
                        <div class="form-group">
                            <input type="file" class="sports_input" name="image" value=" " required accept="image/png,image/jpg,image/jpeg,image/webp,image/avif">
                        </div>
                        <button type="submit" name="add_club" class="mx-auto btn btn-light" style="width: 150px; border-radius: 30px; margin-top: 10px;">ADD</button>
                    </form>
                    <?php
                }


               
        ?>
        <?php if (isset($message)): ?>
            <div class="alert alert-danger mt-3"><?php echo $message; ?></div>
        <?php endif; ?>
        
    </div>
</body>
</html>
