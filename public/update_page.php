<?php 
    include('connection.php');
    session_start();
    $club = $_SESSION['email'];
    $sql = mysqli_query($conn,"SELECT club_type FROM club WHERE email = '$club'");
    $data= mysqli_fetch_assoc($sql);
   $type = $data['club_type'];
//    echo $type;
    if(isset($_GET['V'])){
        

        $email = $_GET['V'];
        
        $sql = mysqli_query($conn,"SELECT * FROM clubuser WHERE email = '$email'");
        if($sql){
            $data = mysqli_fetch_assoc($sql);
        }
    
    }

    if (isset($_POST['upd_btn'])) {
      $amount = $_POST['amount'];
      $num = $_POST['number'];
      $pos = $_POST['position'];
  
      // Update the clubuser table
      $sql = "UPDATE `clubuser` SET `number`='$num', `position`='$pos', `amount`='$amount' WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);
  
      if ($result) {
          // Fetch the player's ID using their email
          $sq = "SELECT user_id FROM user WHERE email = '$email'";
          $rs = mysqli_query($conn, $sq);
          $bb = mysqli_fetch_assoc($rs);
          $player_id = $bb['user_id'];
  
          // Update the latest entry of the player in player_history
          $sql = "UPDATE `player_history` 
                  SET `amount` = '$amount' 
                  WHERE player_id = '$player_id' 
                  ORDER BY id DESC 
                  LIMIT 1";
          $result = mysqli_query($conn, $sql);
  
          if ($result) {
              header('Location: club_pannel.php');
              exit(); // Ensure further code is not executed after the redirect
          } else {
              echo "Error updating player history: " . mysqli_error($conn);
          }
      } else {
          echo "Error updating clubuser: " . mysqli_error($conn);
      }
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      background-color: #f7f9fc;
    }
    .main-div {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .custom-form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }
    .custom-form input {
      margin-bottom: 15px;
    }
    .update-btn {
      background-color: #4CAF50;
      border: none;
      padding: 10px 20px;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    .update-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="main-div">
    <form class="custom-form" method="post">
        
      <h3 class="text-center mb-4">Update Your Info</h3>
      <div class="mb-3">
        <label for="name" class="form-label">Number</label>
        <input type="text" class="form-control" name="number" value="<?php echo $data['number']; ?>" placeholder="<?php echo $data['number']; ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Position</label>
        <select name="position" class= "form-control" name="positions" value="<?php echo $data['position']; ?>" class="form-select" >
                           
                           <option ><?php echo $data['position']; ?></option>

                           <?php
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
      </div>
      <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="text" class="form-control" name="amount"  value="<?php echo $data['amount']; ?>" placeholder="<?php echo $data['amount']; ?>">
      </div>
      <button type="submit" class="btn update-btn w-100" name="upd_btn">Update</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>