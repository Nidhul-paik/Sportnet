<?php
include('connection.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require 'vendor/autoload.php';



if(isset($_POST['add_event'])){
    $date = $_POST['date'];

    $image = $_FILES['image']['name'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_folder = "images/" . basename($image);

    $type = $_POST['type'];
    $email = $_SESSION['email'];

    // Get club details
    $sql = "SELECT * FROM `club` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $id = $data['club_name'];
    $club_type = $data['club_type'];

    // Insert event into the events table
    $sql1 = "INSERT INTO `events`(`club_name`, `type`, `image`, `event_date`, `sports`) VALUES ('$id','$type','$image','$date','$club_type')";
    $result2 = mysqli_query($conn, $sql1);
    
    if($result2){
        $event_id = mysqli_insert_id($conn); // Get the last inserted event ID

        if (move_uploaded_file($image_temp_name, $image_folder)) {
            
            // Get all users to send email notifications
            $sql_users = "SELECT email FROM `user`"; // Fetch all users' emails from `users` table
            $result_users = mysqli_query($conn, $sql_users);

            while($user = mysqli_fetch_assoc($result_users)) {
                $user_email = $user['email'];
                
                
                // Prepare email notification
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output (0 = off)
                $mail->isSMTP();     
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output (commented out)                                 // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';               // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                             // Enable SMTP authentication
                $mail->Username = getenv('MAIL_USERNAME'); // SMTP username
                    $mail->Password = getenv('MAIL_PASSWORD'); // SMTP password         
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                              // TCP port to connect to
        
                //Recipients
                $mail->setFrom(getenv('MAIL_USERNAME'), 'SportNet');
                $mail->addAddress($user_email);                            // Add a recipient
        
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'New Event: ' . $type . ' on ' . $date;
                // $mail->Body    = '<h2>New Event from ' . $id . ' Club</h2>
                //   <p>We are excited to inform you about a new event happening on <b>' . $date . '</b>.</p>
                //   <p>Event Type: ' . $type . '</p>
                //   <p>Please find the event poster attached below.</p>';
                // $mail->AltBody = 'New Event from ' . $id . ' on ' . $date . '. Event Type: ' . $type;

                                // Construct the image path using the image folder and the image filename from the database
                $image_folder = 'images/' . $image;  // $image contains the filename from the form or database

                // Embed the image
                $mail->addEmbeddedImage($image_folder, 'event_poster');  // Embed the image with a unique identifier

                // Now, modify the HTML body to display the embedded image
                $mail->Body = '<h2>New Event from ' . $id . ' Club</h2>
                                <p>We are excited to inform you about a new event happening on <b>' . $date . '</b>.</p>
                                <p>Event Type: ' . $type . '</p>
                                <p>Please find the event poster below:</p>
                                <img src="cid:event_poster" alt="Event Poster">';

        
                $mail->send();
                
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }

            // Redirect after successful event creation and notification
            header('Location: club_pannel.php');
            exit();
        } else {
            $message = "There was an error moving the uploaded file.";
        }
    }
}

?> 