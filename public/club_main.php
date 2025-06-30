<?php
include('connection.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

  
</head>
<?php include('header.php'); ?>
<?php


if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = $_SESSION['pre'];  // A default page if no referrer is found
}
?>
<a href="<?php echo $previousPage; ?>"style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:#0c0629; position: fixed;left: 23px;top: 84px;" ></i></a>

   
  
<body>
    <div class="container-fluid " style="height: 100vh; display:flex; background:white; justify-content:center; align-items:center; flex-direction:column;" id="main">
        <?php
        if(isset($_GET['v'])){
            $id = $_GET['v'];
            $sql = "SELECT * FROM `club` WHERE club_id = '$id'";
            $result= mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $name = $row['club_name'];
            ?>
        <div class="container  p-5" style=" box-shadow: 0px 0px 18px 5px #e6e2e2;">
                <div class="row d-flex justify-content-center align-items-center">
                    <!-- Column for Image -->
                    <div class="col-12 col-md-6 mb-4 mb-md-0 text-center">
                        <img src="images/<?php echo $row['logo']; ?>" alt="" class="img-fluid">
                    </div>
                    <!-- Column for Club Name and About -->
                    <div class="col-12 col-md-6 d-flex flex-column justify-content-start">
                        <h1 style="color: black; font-size: 50px; font-weight: 900;"><?php echo $row['club_name']; ?></h1>
                        <p style="font-size: 20px; font-weight: 300;"><?php echo $row['about']; ?></p>

                        <div class="social-media mt-3">
                            <a href="" class="social-icon" style="border: 2px solid blue;">
                                <i class="fab fa-facebook-f text-primary"></i>
                            </a>
                            <a href="" class="social-icon" style="border: 2px solid blue;">
                                <i class="fab fa-twitter text-primary"></i>
                            </a>
                            <a href="" class="social-icon" style="border: 2px solid blue;">
                                <i class="fab fa-google text-primary"></i>
                            </a>
                            <a href="" class="social-icon text-primary" style="border: 2px solid blue;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
        </div>


      
       
    </div>

    <div class="row mx-auto d-flex justify-content-center align-items-center" style="height: auto; color:white; background: white; padding-bottom:40px;" id="sportsclubs">
    <h1 class="text-center text-primary" style="font-weight: 900; margin-top:60px; margin-bottom:80px;"><u>OUR PLAYERS</u></h1>
    <?php
        $sql = "SELECT * FROM `clubuser` WHERE club_id = '$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Get email from current club user
                $email = $row['email'];
                
                // Fetch user details from `user` table
                $user_sql = "SELECT * FROM `user` WHERE email = '$email'";
                $user_result = mysqli_query($conn, $user_sql);
                
                if ($data = mysqli_fetch_assoc($user_result)) {
                    ?>
                    <div class="col-lg-3 col-sm-12 player_card">
                        <a href="">
                            <div class="player_img" style="background-image: url('images/<?php echo $data['image']; ?>');"></div>

                            <div class="d-flex  justify-content-center align-items-center flex-column w-100">

                                    <div style="width: 100%;display: flex;justify-content: start;align-items: start;">
                                        <pre style="font-size: 25px;">Name    :</pre>
                                        <h3 class="text-start text-dark" style="text-transform: capitalize; font-size:22px;" ><?php echo $data['name']; ?></h3>
                                    </div>

                                    <div style="width: 100%;display: flex;justify-content: start;align-items: start;">
                                        <pre style="font-size: 25px;">Position:</pre>
                                        <h3 class="text-start text-dark" style="text-transform: capitalize; font-size:22px;" ><?php echo $row['position']; ?></h3>
                                    </div>

                                    <div style="width: 100%;display: flex;justify-content: start;align-items: start;">
                                        <pre style="font-size: 25px;">Age     :</pre>
                                        <h3 class="text-start text-dark" style="text-transform: capitalize; font-size:22px;" ><?php echo $data['age']; ?></h3>
                                    </div>

                            </div>
                            
                        </a>
                    </div>
                    <?php
                }
            }
        }
    ?>
</div>


    <div class="container-fluid " style="height: 100vh; display:flex;  align-items:center; flex-direction:column; padding-top:100px;" id="main">
            <h1 style="font-size: 50px;font-weight: 900;text-transform: capitalize;margin-bottom: 80px;"><u> Events</u></h1>
            <div class="container-fluid row">
            <?php
            $sql = "SELECT * FROM events WHERE club_name = '$name'   ORDER BY 
                    CASE 
                        WHEN type = 'recruitment' THEN 1
                        WHEN type = 'tournament' THEN 2
                        WHEN type = 'event' THEN 3
                        ELSE 4
                    END";
            $out = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_assoc($out)) {
            ?>
                <div class="event col-lg-4 col-sm-12 p-0" style="background-image:url('images/<?php echo $data['image']; ?>'); background-size:cover; background-repeat:no-repeat;">
                    <form method="post" id="event_form" class="event_form">
                        <h1 class="text-light mb-5" style="margin-left:10px; font-weight:900;"><u>Register here!</u></h1>
                        <input type="text" name="name" class="mt-5 " style="margin-left:10px;" placeholder="Name">
                        <br><br>
                    
                        <input type="text" name="id" id="" style="margin-left:10px;" placeholder="email">
                        <input type="submit" name="register" value="Register" style="width: 150px; margin-left:10px; margin-top:50px; height:50px; color:black; background:#1bea1b; border:none; border-radius:30px;">

                        <div id="back" style="width: 100%;margin-top:102px;border: none;background: #8c8cb1; margin-bottom:-200px; height:40px; display:flex; justify-content:center; align-items:center;">back</div>
                    </form>
                    
                </div>
            <?php
            }

        }
            ?>
        </div>
    </div>
       
</body>


</html>