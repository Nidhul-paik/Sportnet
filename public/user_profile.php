<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];

try {
    // Handle Profile Update
    if (isset($_POST['update'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $district = mysqli_real_escape_string($conn, $_POST['district']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mob']);
        $image = $_FILES['image']['name'];
        $image_temp_name = $_FILES['image']['tmp_name'];
        $image_folder = "images/" . basename($image);

        // Prepared statement for updating the user
        $stmt = $conn->prepare("UPDATE user SET `name`=?, `age`=?, `district`=?, `mobile`=?, `image`=? WHERE email=?");
        $stmt->bind_param("ssssss", $name, $age, $district, $mobile, $image, $email);
        $result = $stmt->execute();

        if ($result) {
            if (move_uploaded_file($image_temp_name, $image_folder)) {
                header('Location: user_profile.php');
                exit();
            } else {
                
            }
        } else {
            
        }
    }

    // Handle Like
    if (isset($_POST['like'])) {
        $id = $_POST['player'];
        $offer = $_POST['offer'];
        $stmt = $conn->prepare("UPDATE auction SET user_status = 'true' WHERE Player = ? AND id = ?");
        $stmt->bind_param("ii", $id, $offer);
        $result = $stmt->execute();

        if ($result) {
            header('Location: user_profile.php');
            exit();
        }
    }

    // Handle Dislike
    if (isset($_POST['dislike'])) {
        $id = $_POST['player'];
        $offer = $_POST['offer'];
        $stmt = $conn->prepare("UPDATE auction SET user_status = 'false' WHERE Player = ? AND id = ?");
        $stmt->bind_param("ii", $id, $offer);
        $result = $stmt->execute();

        if ($result) {
            header('Location: user_profile.php');
            exit();
        }
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
      .about_user{
        display:flex; justify-content:start; align-items:start; flex-direction:column;
        padding:23px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 300px;
        height:315px;
        margin-top: 10px;
        overflow: scroll;
      }
      @media (min-width: 992px){
      .col-lg-4 {
        flex: 0 0 auto;
        width: 30%;
      }
    }
      @media(width:450px){
        .about_user{
          margin-top:20px;
        }
      }
    </style>
</head>
<body style="margin: 0px;">
<?php include 'header.php';

if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}
?>
<a href="<?php echo $previousPage; ?>"style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:white; z-index:2; position: fixed;left: 23px;top: 84px;" ></i></a>

   
<?php

if ($_SESSION['email']) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            ?>
            <div style="width: 100%; height:190px; background:black; position:absolute; top:66px;">
              <div style="position: absolute;top: 102px;left: 280px;">
                <h3 class="text-light"><?php echo $data['name']; ?></h3>
                <h5 class="text-light"><?php echo $data['district']; ?></h5>
              </div>
            </div>
            <div style="background-image: url('images/<?php echo $data['image']; ?>'); width: 190px;height: 190px;background-size: cover;position: absolute;top: 153px;left: 72px;box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);"></div>

            <button id="acc" style="width: 190px;height: 40px;background-size: cover;position: absolute;top: 350px;left: 72px; background:white; border:2px solid black;">Change Profile</button>

            <div class="container-fluid  " style="position: absolute; top:450px; display:flex; justify-content:center; align-items:center;">
            <div  class=" row p-3" style="width: 100%; height:90%; display:flex; justify-content:center; align-items:start;  ">
              <div class="about_user col-lg-3 col-sm-6 mx-3 mt-3 ">
                          <h1 class="mb-5"><u>About</u></h1>
                          <h3 class="mb-3"><i class="fas fa-user mx-2"></i><?php echo $data['name']; ?></h3>
                          <h3 class="mb-3"><i class="fas fa-envelope mx-2"></i><?php echo $data['email']; ?></h3>
                          <h3 class="mb-3"><i class="fas fa-phone mx-2"></i><?php echo $data['mobile']; ?></h3>
                          <h3 class="mb-3"><i class="fas fa-calendar-alt mx-2"></i><?php echo $data['age']; ?></h3>
              </div>
            <?php

            $sql1 = "SELECT * FROM `clubuser` WHERE email = '$email'";
            $rslt = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($rslt) > 0) {
                $row = mysqli_fetch_assoc($rslt)
                ?>
                  <div class="about_user col-lg-3 col-sm-6 mx-3 mt-3">
                    <h1 class="mb-5"><u>Current Status</u></h1>
                    <?php
                    $clb = $row['club_id'];

                    $club = "SELECT * FROM `club` WHERE club_id = '$clb'";
                    $clb_rslt = mysqli_query($conn, $club);
                    if ($clb_rslt) {
                        $rrr = mysqli_fetch_assoc($clb_rslt);

                        ?>
                              <h1 style="font-size: 32px;">club     :<?php echo $rrr['club_name'];
                    } ?></h1>
                              <h1 style="font-size: 32px;">Number   :<?php echo $row['number']; ?></h1>
                              <h1 style="font-size: 32px;">Position :<?php echo $row['position']; ?></h1>
                      </div>
                  <?php
            }
            ?>
            <div class="about_user col-lg-3 col-sm-6 mx-3 mt-3 " >
              <h1 class="mb-5"><u>New offers</u></h1>

              <?php
              $email = $_SESSION['email'];
              if ($email) {
                  $sql = "SELECT * FROM user WHERE email = '$email'";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $id = $row['user_id'];
              }

              $sql = "SELECT * FROM auction WHERE player = '$id'";
              $result2 = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result2) > 0) {
                  ?>
                  <table style="width: 100%; font-size:25px;">
                      <thead>
                        <th>SI</th>
                        <th>Club</th>
                        <th>Amount</th>
                        <th>Choice</th>
                      </thead>
                      <tbody>

                    <?php
                    $count = 1;
                    while ($data = mysqli_fetch_assoc($result2)) {
                    ?>
                      <tr>
                        <form action="" method ="post">
                          <input type="hidden" name="player" value="<?php echo $id; ?>">
                          <input type="hidden" name="offer" value="<?php echo $data['id']; ?>">

                          <td><?php echo $count; ?></td>
                          <td>
                    <?php
                    $club = $data['offer_club'];
                    $result = mysqli_query($conn, "SELECT * FROM club WHERE email = '$club'");
                    $row = mysqli_fetch_assoc($result);
                    echo $row['club_name'];
                    ?>

                        </td>
                        <td>
                        <?php echo $data['offer_amount']; ?>
                        </td>
                        <td>
                          <button class="btn" type="submit" name="like"> <i class="fas fa-thumbs-up" style="font-size: 24px; <?php if ($data['user_status'] == 'true') {echo "color:green;";} else {echo "color:#00f500;";}?> "></i></button>
                          <button class="btn" type="submit" name="dislike">  <i class="fas fa-thumbs-down" style="font-size: 24px; <?php if ($data['user_status'] == 'false') {echo "color:red;";} else {echo "color:#ff8080;";}?> "></i></button>
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
            </div>

<div id="account" style="transition: ease-in .5s;">
  <div style=" width: 550px; height:650px; background:white; flex-direction:column; display:flex; justify-content:center; align-items:center;  margin-bottom:100px; " >
  <div  class="w-100" ><i class="fas fa-times " id="close_acc" style="float: right; font-size:18px; margin-right:15px;"></i></div>
  <!-- <div id="fullac" style="width: 100%; height:100%;display:flex; justify-content:center; align-items:center;"> -->
        <div class="profile" style="width: 90%; height:90%; display:flex; justify-content:center; align-items:center; ">

          <form action="" method="post" enctype="multipart/form-data" style="width: 90%; height:90%; display:flex; justify-content:center; align-items:center; flex-direction:column;">

              <div class="form-group pform " style="width: 150px; height:150px; margin-top:-30px; margin-bottom:40px; background-repeat:no-repeat; background-image: url('<?php echo ($data['image'] != 'nothing') ? "images/{$data['image']}" : "images/logo.jpeg"; ?>'); background-size: cover;border-radius: 50%;box-shadow: 0px 0px 8px 0px gray;display: flex;justify-content: center;align-items: center;">
                <input type="file" class="account_input" name="image" value=" <?php echo $data['image']; ?>" style="opacity: 0;" required accept="image/png,image/jpg,image/jpeg,image/webp,image/avif">
              </div>

              <div class="form-group pform " style="width: 90%;">
                <input type="text" name="name" class="account_input"  placeholder="Name"value="<?php echo $data['name']; ?>">
              </div>


              <div class="form-group pform " style="width: 90%;">
                <input type="text" name="email" class="account_input" value="<?php echo $data['email']; ?>" placeholder="Email">
              </div>

              <div class="form-group pform " style="width: 90%;">
                <input type="text" name="mob" class="account_input" value="<?php echo $data['mobile']; ?>" placeholder="Mob">
              </div>
              <div class="form-group pform " style="width: 90%;">
                <input type="text" name="age" class="account_input" value="<?php echo $data['age']; ?>" placeholder="Mob">
              </div>

              <select name="district"  class="form-control account_input"  style="background: transparent; color: black; width:90%;" required>
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
              <button type="submit" name="update" class="mx-auto btn btn-light" style="width: 150px; border-radius: 30px; margin-top: 10px;background: #1fff42;">UPDATE</button>
              <?php
} else {
            header('location:login.php');
        }
    } else {
        echo "something wrong";
    }
} else {
    header('location:login.php');
}

?>

         </form>
      </div>
  </div>
  <!-- </div> -->
</div>
<script>
  let acc = document.getElementById('acc');
  let account = document.getElementById('account');
  let cls_acc = document.getElementById('close_acc');


  acc.addEventListener('click',()=>{
    account.style.top ='80px';
  })
  cls_acc.addEventListener('click',()=>{
    account.style.top = '-1800px';
  })
</script>
</body>
</html>
