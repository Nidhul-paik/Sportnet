<?php 
include('connection.php');
session_start();


// Get the protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Get the host (domain name)
$host = $_SERVER['HTTP_HOST'];

// Get the URI (page path and query string)
$uri = $_SERVER['REQUEST_URI'];

// Combine to form the full URL
$current_url = $protocol . $host . $uri;

$_SESSION['pre'] = $current_url;

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

    <style>


        input{
            height: 45px;
            border: none;
            border-radius: 30px;
            margin-bottom: 20px;
            width:95% ;
            
        }
        input::placeholder{
            color: black;
        }
        .main-card {
            text-decoration: none;
            width: 350px;
            height: 400px;
            
            margin: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            perspective: 1000px; /* Added perspective for 3D effect */
        }

        .thecard {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.8s ease; /* Updated transition */
        }

        .main-card:hover .thecard {
            transform: rotateY(180deg); /* Rotate the card on hover */
        }

        .frontcard, .backcard {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow: 0px 0px 9px 1px #e8d5d5;
            border-radius: 10%;
        }

        .frontcard {
            background: white;
        }

        .backcard {
            background: #535e6d;
            color: white;
            font-size: 18px;
            transform: rotateY(180deg); /* Rotate the back card */
        }
    </style>
</head>

<body class="cb_main" >
<?php include('header.php'); ?>
    <?php


if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}
?>
<a href="<?php echo $previousPage; ?>"style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:#0c0629; position: fixed;left: 23px;top: 84px;" ></i></a>

   
  

    <?php 


if(isset($_GET['sport_id'])){
    $id = $_GET['sport_id'];
  

     $sql = "SELECT * FROM sports WHERE sp_id = '$id'";
     $result = mysqli_query($conn,$sql);
     if($result){
        $data = mysqli_fetch_assoc($result);
        $type = $data['name'];
     ?>


<div class="container">
        
<div class="row  mx-auto d-flex justify-content-center align-items-center p-0" style="height: auto; color:white; background: white;  padding-bottom:40px;" id="sportsclubs">
        <h1 class="text-center text-primary" style="font-weight: 900; margin-top:60px; margin-bottom:80px;"><u>CLUBS</u></h1>
        <?php
            $sql = "SELECT * FROM club WHERE club_type = '$type' ";
            $result = mysqli_query($conn,$sql);

            while($row = mysqli_fetch_assoc($result)){
                ?>
                <a href="club_main.php?v=<?php echo $row['club_id']; ?>"   class="col-lg-3 col-sm-12  main-card"  >
                <div class="thecard">

                    <div class="  frontcard " >
                        <div class="club_img w-100" style="background-image: url('images/<?php echo $row['logo']; ?>');" >
        
                        </div>
                        <h3 class="text-center text-dark"><?php echo $row['club_name']; ?></h3>
                    </div>

                    <div class="backcard ">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-start p-2" style="flex-direction: column;">
                    <p style="font-size: 35px;"><strong><?php echo $row['club_name']; ?></strong></p>
                    <p style="font-size:23px;"><strong>Location:</strong><?php echo $row['district']; ?></p>
                    <p style="font-size:23px;"><strong>Manager:</strong><?php echo $row['Man_name']; ?></p>
                    <p style="font-size:23px;"><strong>Contact:</strong><?php echo $row['mobile']; ?></p>
                    <p style="font-size:23px;"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                    </div>
                    </div>
                </div>
                </a>
            <?php
            }


            ?>
</div>
</div>

<div class="container-fluid " style="height: 100vh; display:flex;  align-items:center; flex-direction:column; padding-top:100px;" id="main">
    <h1 style="font-size: 50px;font-weight: 900;text-transform: capitalize;margin-bottom: 80px;"><u><?php echo $type; ?> Events</u></h1>
    <div class="container-fluid row">
    <?php
    $sql = "SELECT * FROM events WHERE sports = '$type' ORDER BY 
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
    ?>
</div>

</div>
        <?php 
        }
    }
        
    
    ?>
         

            
            
    
         <script>
    // let rg = document.getElementById('register');
    // let form =document.getElementById('event_form');
    // let back =document.getElementById('back');

    // rg.addEventListener('click',()=>{
    //     form.classList.add('event_form_view');
        
        

    // })
    // back.addEventListener('click',()=>{
    //     form.classList.remove('event_form_view');


    // })

    document.querySelectorAll('.event').forEach((eventCard, index) => {
    let rg = eventCard.querySelector('#register button');
    let form = eventCard.querySelector('.event_form');
    let back = eventCard.querySelector('#back');

    rg.addEventListener('click', () => {
        form.classList.add('event_form_view');
        rg.style.display = 'none';
    });

    back.addEventListener('click', () => {
        form.classList.remove('event_form_view');
        rg.style.display='block';
    });
});

</script>


</body>
</html>