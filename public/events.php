<?php 
session_start();
 $file = basename(__FILE__);
 $_SESSION['location']= $file;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}


if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $Page = 'events.php';  // A default page if no referrer is found
}
?>
<a  href="<?php echo $Page; ?>" style="text-decoration: none;" ><i class="fa-solid fa-arrow-up" style="font-size: 29px; color:#0c0629; position: fixed;right: 17px;bottom: 15px;" ></i></a>

  <?php include('header.php'); ?>
  <a  href="<?php echo $previousPage; ?>" style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:#0c0629; position: fixed;left: 17px;top: 100px;" ></i></a>
    <div class="container-fluid " style="height: 100vh; display:flex;  align-items:center; flex-direction:column; padding-top:100px;" id="main">
    <h1 style="font-size: 50px;font-weight: 900;text-transform: capitalize;margin-bottom: 80px;"><u> Events</u></h1>
    <div class="container-fluid row">
    <?php
    $sql = "SELECT * FROM events  ORDER BY 
            CASE 
                WHEN type = 'recruitment' THEN 1
                WHEN type = 'tournament' THEN 2
                WHEN type = 'event' THEN 3
                ELSE 4
            END";
    $out = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_assoc($out)) {
    ?>
        <div id="<?php $data['event_id']; ?>" class="event col-lg-4 col-sm-12 p-0" style="background-image:url('images/<?php echo $data['image']; ?>'); background-size:cover; background-repeat:no-repeat;">
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
    ?>
</div>
</div>
</body>
</html>