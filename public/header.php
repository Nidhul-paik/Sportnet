<?php
include('connection.php');
session_start();
$location = $_SESSION['location'];

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
  <title></title>
  <style>

  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg d-flex p-0" >
  <div class="container-fluid navcontainer-fluid" style="background: white;">
    <img class="nav-item img-fluid nav-img" src="images/logo.jpeg" style="width: 60px;height: 60px;border-radius: 50%; margin:5px; box-shadow: 0px 0px 12px 1px gray;" alt="Login">
    <button class="navbar-toggler" type="button" id="toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="border:1px solid black;"></span>
    </button>
    <div class="collapse navbar-collapse main" id="navbarSupportedContent">
      <ul class="navbar-nav m-auto mb-2 mb-lg-0 d-flex justify-content-around align-items-center w-50">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php if($location !='main.php#home'){echo 'main.php';} ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " href="<?php if($location !='main.php'){echo 'main.php#sportsclubs';}else{echo '#sportsclubs';} ?>">Clubs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?php if($location !='main.php'){echo 'main.php#about';}else{echo '#about';} ?>">About</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link active" href="<?php if($location !='main.php'){echo 'main.php#contact';}else{echo '#contact';} ?>">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="events.php">Events</a>
        </li>
        <li class="nav-item" id="profile" style="border-radius: 50%;border: 2px solid black;height: 40px;width: 40px;display: flex;justify-content: center;align-items: center;">
          <a class="nav-link active" href="<?php if($_SESSION['user_type']== 'club'){ $user = $_SESSION['email']; $_SESSION['email']=$user;  echo 'club_pannel.php';}else{ $user = $_SESSION['email']; $_SESSION['email']=$user; echo 'user_profile.php';} ?>" ><i class="fas fa-user"></i></a>
        </li>
         
        <li class="nav-item" id="profile" style="border-radius: 50%;border: 2px solid black;height: 40px;width: 40px;display: flex;justify-content: center;align-items: center;">
          <a href="workout.php"><i class="fa-solid fa-dumbbell text-dark"></i></a>
        </li>

        <li class="nav-item" id="profile" style="border-radius: 50%;  border: 2px solid black;height: 40px;width: 40px;display: flex;justify-content: center;align-items: center;">
          <a class="dashcon text-gray" href="logout.php"> <i class="fa-solid fa-arrow-right-from-bracket text-dark"></i></a>
        </li>

               
      </ul>
      <form class="d-flex form-control  w-25 header-form" style="background-color: #0097f2 !important;">
        <input class="form-control me-2 flex-grow-1 " type="search" placeholder="Search" aria-label="Search" style="background-color: #0097f2 !important;">
        <button class="btn btn-outline-success" type="submit"><i class="fas fa-search text-dark"></i></button>
      </form>
    </div>
  </div>


</nav>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>



  

</body>
</html>
