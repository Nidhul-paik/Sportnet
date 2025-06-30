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
        .waviy {
        position: relative;
        -webkit-box-reflect: below -20px linear-gradient(transparent, rgba(0,0,0,.2));
        font-size: 60px;
        position: absolute;
        top: 10px;
        left: 20px;

}

.waviy span {
  font-family: 'Alfa Slab One', cursive;
  position: relative;
  display: inline-block;
  color: #fff;
  animation: waviy 1s infinite;
  animation-delay: calc(.1s * var(--i));
  font-weight: 900;
  width: 190px;
}
@keyframes waviy {
  0%,40%,100% {
    transform: translateY(0)
  }
  20% {
    transform: translateY(-20px)
  }
}


.animate-charcter
{
   text-transform: uppercase;
  background-image: linear-gradient(
    -225deg,
    #231557 0%,
    #44107a 29%,
    #ff1361 67%,
    #fff800 100%
  );
  background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  /* text-fill-color: transparent; */
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 2s linear infinite;
  display: inline-block;
      font-size: 190px;
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
    </style>
</head>
<body>
   
    <div class="container-fluid bg-secondary d-flex justify-content-center align-items-center flex-column index" style="height: 100vh; width:100%; background-repeat:no-repeat; background-size:cover; background-image: url('images/set.jpg'); ">
    
    <div class="container">
    <h1 class="text text-light" style="font-size: 45px; font-weight:900; ">SportNet</h1>
    <p class="text text-light" style="font-size:20px; font-weight:900; word-spacing: 1px;">SportNet simplifies sports club management by connecting clubs, members, and events on one platform, promoting seamless interaction and growth within the sports community </p>
    </div>
    <div class="container d-flex justify-content-center sport-btn">
        <a class="mx-2" href="login.php" style="text-decoration: none; color:white;"><button class="btn-primary " >LOGIN</button></a>
        <a class="mx-2" href="register.php" style="text-decoration: none;"><button>SIGN UP</button></a>
    </div>
    <div class="container d-flex justify-content-start mt-5">
        <a href="club_register.php"><p class="text-light" style="font-size: 20px; font-weight:900;">Register your club here!</p></a>
    </div>
    </div>
</body>
</html>