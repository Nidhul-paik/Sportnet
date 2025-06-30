<?php

ini_set('display_errors', 0);
  error_reporting(0);
   include('connection.php');
    // Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
   

        require_once __DIR__ . '/../vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        error_reporting(0);
    // Load Composer's autoloader
       

        function generateOTP($length = 6) {
            $otp = '';
            for ($i = 0; $i < $length; $i++) {
                $otp .= mt_rand(0, 9);
            }
            return $otp;
        }


        
        function sendOTP($otp, $email) {
            $mail = new PHPMailer(true);
        
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = getenv('MAIL_USERNAME');
                $mail->Password   = trim(getenv('MAIL_PASSWORD')); // trim is good
        
                // ✅ The port & encryption must match
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // if using port 587
                $mail->Port       = 587;
        
                // Recipients
                $mail->setFrom(getenv('MAIL_USERNAME'), 'SportNet');
                $mail->addAddress($email);
        
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = 'Your OTP code is: <b>' . $otp . '</b>';
                $mail->AltBody = 'Your OTP code is: ' . $otp;
        
                $mail->send();
                return true;
            } catch (Exception $e) {
                error_log("Mail error: " . $mail->ErrorInfo); // Optional: log error
                return false;
            }
        }
        

        
        // update password
        include("connection.php");
        function updatePassword($email, $password) {
            global $conn;
        
            // Hash the new password before storing it in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE email = '$email'"))>0){
                    
            
                // Prepare the SQL statement
                $stmt = $conn->prepare("UPDATE `user` SET `password` = ? WHERE `email` = ?");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
            
                // Bind the parameters
                $stmt->bind_param('ss', $hashedPassword, $email);
            
                // Execute the statement
                if ($stmt->execute() === false) {
                    die('Execute failed: ' . htmlspecialchars($stmt->error));
                }
            
                // Close the statement
                $stmt->close();
        }else{
            

            $stmt = $conn->prepare("UPDATE `club` SET `password` = ? WHERE `email` = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
        
            // Bind the parameters
            $stmt->bind_param('ss', $hashedPassword, $email);
        
            // Execute the statement
            if ($stmt->execute() === false) {
                die('Execute failed: ' . htmlspecialchars($stmt->error));
            }
        
            // Close the statement
            $stmt->close();
        }
        
            // Return true to indicate success
            return true;
        }


       

        
        


    
    ?>