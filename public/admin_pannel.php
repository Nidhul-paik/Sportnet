<?php
 include"connection.php";

// --------------------delete club--------------//

if(isset($_POST['del_sport'])){
  
    $id  = $_POST['sp_id'];
    
    $sql = "DELETE   FROM `sports` WHERE sp_id = '$id'";
    $result = mysqli_query($conn,$sql);
    

   
}

//----------------- delete users-----------------//

if(isset($_POST['del_user'])){
    $id  = $_POST['user_id'];
    
    $sql = "DELETE   FROM `user` WHERE user_id = '$id'";
    $result = mysqli_query($conn,$sql);
    

   
}

if(isset($_POST['event_del'])){
    $id = $_POST['id'];
   
    $sql = "DELETE FROM `events` WHERE event_id = '$id'";
    if(mysqli_query($conn,$sql)){
       header('location:admin_pannel.php');
    }
   }

   if(isset($_POST['del_clubs'])){
    $id = $_POST['club_id'];

    $sql = "DELETE FROM `club` WHERE club_id = '$id'";
    if(mysqli_query($conn,$sql)){
       header('location:admin_pannel.php');
    }
   }

   
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin pannel</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <style>
    /* table {
    width: 90%;
    border-collapse: collapse;
    min-height: 600px;
    border: 3px solid black;
    margin: auto;
    font-size: 20px;
} */

table {
    box-shadow: 0px 0px 15px 1px gray;
    border: none;
    width: 99%;
    border-collapse: collapse;
    margin-bottom: 20px;
    margin: auto;
    font-size: 25px;
    font-weight: 500;
}

th, td {
    /* border: 1px solid #ddd; */
    padding: 8px;
    text-align: left;
}

th {
    background-color:#1a2d53;
    height: 40px;
    color:white;
}

 </style>
</head>
<body>
    <div class="container-fluid dash-container " style="padding-left:0px;">
        <div class="dash  h-100 " style="width: 20%;">
            <div class="w-100 dash-head ">SportNet</div>
            <div class="d-flex  flex-column mt-5 " style="background-image: linear-gradient(to right, white, white);">

                <div class="dummy " id="dummy1"><i></i></div>

                <div class="content " id="sports"><i class="  fas fa-users"></i>sports</div>

                <div class="dummy " id="dummy2"><i></i></div>

                <div class="content " id="users"><i class="  fas fa-shopping-cart"></i>users</div>

                <div class="dummy " id="dummy3"><i></i></div>


                <div class="content "id="clubs"><i class="  fas fa-coins"></i>clubs</div>

                <div class="dummy " id="dummy4"><i></i></div>

                <div class="content "  id="evnt" ><i class="  fas fa-bars"></i>events</div>

                <div class="dummy " id="dummy5"><i></i></div>

                <div class="content " style="padding-left: 24px;"  id="evnt" ><i class="fa-solid fa-border-all "></i><a style="text-decoration: none; margin-left:20px; color:white;"  href="playerhistory.php">Players</a></div>

                <div class="dummy " ><i></i></div>

                <div class="content "  style="padding-left: 24px;" id="evnt" ><i class="fa-solid fa-right-from-bracket"></i><form action="" method="post"><a style="background:transparent; margin-left:20px;text-decoration:none; color:white;" href="logout.php" >Logout</a></div>

                <div class="dummy " ><i></i></div>
            </div>
        </div>
        <h1 class="text-center" style="position: absolute;font-size: 225px;top: 300px; margin-left: 450px; width:80%; color:gray;">Admin Panel</h1>

        <!-- -------------------sports-space --------------->


<div class=" d-flex justify-content-center align-items-center flex-column" id="sports-space" style="height: 100vh;">
    <div><i class="fas fa-times" id="close-sports"></i></div>
    <div class="container" style="height:100vh;">
        <div class="text-center" style="font-weight: 600; font-size:50px; margin-bottom:100px; margin-top:100px;">sports</div>
        <a href="hello.php"><input class="btn btn-light text-dark" type="submit" name="add_club" style="width: 150px;height: 50px;background: green;border: none;margin-bottom: 20px;" value="ADD"></a>
        <?php
        $sql = "SELECT * FROM `sports`";
        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result) > 0){
        ?>
       <div class="">
       <table class=" " style="font-size:25px; margin:auto; margin-bottom:20px;">
            <thead>
                <tr class="">
                    <th class="">SI</th>
                    <th class="">Image</th>
                    <th class="">Name</th>
                    <th class="">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($fetch_product = mysqli_fetch_assoc($result)){
                ?>
                <tr class="">
                    <form action="" method="post">
                        <td class=""><?php echo $fetch_product['sp_id']; ?></td>
                        <input type="hidden" name="sp_id" value="<?php echo $fetch_product['sp_id']; ?>">
                        <td class=""><img src="images/<?php echo $fetch_product['image']; ?>" style="width: 50px; height:50px; border-radius:50%;"></td>
                        <td class=""><?php echo $fetch_product['name']; ?></td>
                        <td class=" d-flex  align-items-center">
                            <a class="btn btn-warning w-50" href="hello.php?v=<?php echo $fetch_product['sp_id']; ?>" name="edit_clubs">Edit</a>
                            <input type="submit" class="btn btn-warning w-50 mr-2" value="Delete" name="del_sport">
                        </td>
                    </form>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
       </div>
        <?php
        }
        ?> 
    </div>
</div>


        <!--------------------- users-space ---------------------->

        <div class="  d-flex justify-content-center align-items-center flex-column " id="users-space" style="height: 100vh;">
            <div class="w-100"><i class="fas fa-times" id="close-users"></i></div>
           
            <div class="container  " style=" height:100vh;">
            <div class="text-center  " style="font-weight: 600; font-size:50px; margin-bottom:100px; margin-top:100px;">users</div>
                 <?php
                    $sql = "SELECT * FROM `user`";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result) > 0){
                    ?>
                    
                     <table   >
                        <tr class="" >
                            <th class="" >SI</th>
                            <th class="" >image</th>
                            <th class="" >name</th>
                            <th class="" >email</th>
                            <th class="" >mobile</th>
                            <th class="" >district</th>
                            <th class="" >age</th>
                            <th class="">operation</th>
                        </tr>
                        <?php
                        $count = 1;
                        while($fetch_product = mysqli_fetch_assoc($result)){
                            ?>
                            <tr style="border-bottom:2px solid gray;">
                            <form action="" method="post">
                                <td class=""><?php echo $count; ?></td>
                                <input type="hidden" name="user_id" value="<?php echo $fetch_product['user_id']; ?>">
                                <td class=""><img src="images/<?php echo $fetch_product['image']; ?>" style="width: 50px; height:50px; border-radius:50%;"></td>
                                <td class=""><?php echo $fetch_product['name']; ?></td>
                                <td class=""><?php echo $fetch_product['email']; ?></td>
                                <td class=""><?php echo $fetch_product['mobile']; ?></td>
                                <td class=""><?php echo $fetch_product['district']; ?></td>
                                <td class=""><?php echo $fetch_product['age']; ?></td>
                                <td class="">
                                    <input type="submit" class="btn btn-warning w-100 h-100" value="delete" name="del_user">
                                </td>
                            </form>

                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                     </table>
                     
                     <?php
                    }
                ?> 
                
            </div>
        </div>
      

        <!-- ----------------------clubs-area --------------------->

 <div id="clubs-space" class="contents-section"  style="margin-top: 100px;">
            <!-- Users table content here -->
           
    <div class="usercontent" style="overflow: scroll; padding-bottom:120px;">
        <h2 style="text-align: center; font-size:28px; font-weight:900; margin-bottom:50px">Users</h2>
     
        <?php
                    $sql = "SELECT * FROM `club`";
                    $result = mysqli_query($conn,$sql);
                    if (mysqli_num_rows($result) > 0){
                    ?>
        <table>
            <thead>
                <tr>
                    <th>Serial No.</th>
                    <th>logo</th>
                    <th>club</th>
                    <th>type</th>
                    <th>manager</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>district</th>
                    <th>operation</th>
                </tr>
            </thead>
            <tbody>
            <?php
             $count = 1;
                        while($fetch_product = mysqli_fetch_assoc($result)){
                            ?>

            <tr  style="border-bottom:2px solid gray;">
                            <form action="" method="post">
                                <td ><?php echo $count; ?></td>
                                <input type="hidden" name="club_id" value="<?php echo $fetch_product['club_id']; ?>">
                                <td ><img src="images/<?php echo $fetch_product['logo']; ?>" style="width: 50px; height:50px; border-radius:50%;"></td>
                                <td ><?php echo $fetch_product['club_name']; ?></td>
                                <td ><?php echo $fetch_product['club_type']; ?></td>
                                <td ><?php echo $fetch_product['Man_name']; ?></td>
                                <td ><?php echo $fetch_product['email']; ?></td>
                                <td ><?php echo $fetch_product['mobile']; ?></td>
                                <td ><?php echo $fetch_product['district']; ?></td>
                                <td >
                                    <input type="submit" class="btn btn-warning w-100 h-100" value="delete" name="del_clubs">
                                </td>
                            </form>

                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
            
                
                
                <!-- Add more rows as needed -->
            </tbody>
        </table>
         
        <?php
                    }
                ?> 

    </div>
</div>

<!-- ---------------------events-area ----------------->

<div id="evnt-area" class="contents-section" style="margin-top: 100px; padding-bottom:100px;" >
            <!-- School content here -->
              <!-- school table content here-->

    <div class="usercontent" >
        <h2 style="text-align: center; font-size:28px; font-weight:900; margin-bottom:150px">Events</h2>

        <table id="main">
            <thead>
                <tr>
                    <th>Serial No.</th>
                    <th>type</th>
                    <th>poster</th>
                    <th>club</th>
                    <th>Date</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM `events` ";
                $result = mysqli_query($conn,$sql);
                $i=1;
                while($data = mysqli_fetch_assoc($result)){
                    ?>
                    <tr  style="border-bottom:2px solid gray;">
                    <form action="" method="post">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['type']; ?></td>
                    <td><img src="images/<?php echo $data['image']; ?>"  style="width: 150px; height:180px;" ></td>
                    <td><?php echo $data['club_name']; ?></td>
                   

                    <input type="hidden" value="<?php echo $data['event_id']; ?>" name="id">
                    <td><?php echo $data['event_date']; ?></td>
                    <td >
                        <!-- <button class="delete-btn" name="slupdate" type="submit"></button> -->
                        <button class="delete-btn" name="event_del" type="submit" style="margin:auto; width: 120px;border: none;background: yellow;height: 50px;">Delete</button>
                    </td>
                    </form>
                </tr>
                <?php
                    $i++;
                }
                ?>

            </tbody>
        </table>
    </div>
   
</div>


          <script>
        document.addEventListener('DOMContentLoaded',function(){

            let dummy1 = document.getElementById('dummy1');
            let dummy2 = document.getElementById('dummy2');
            let dummy3 = document.getElementById('dummy3');
            let dummy4 = document.getElementById('dummy4');
            let dummy5 = document.getElementById('dummy5');
            




            let evnt = document.getElementById('evnt');
            let evnt_area = document.getElementById('evnt-area');
            evnt.addEventListener('click',()=>{
                console.log('hiii');
                    evnt_area.classList.add('sport');
                    evnt.classList.add('content_add');

                    users_space.classList.remove('sport');
                    sports_space.classList.remove('sport');
                    clubs_space.classList.remove('sport');

                    clubs.classList.remove('content_add');
                    users.classList.remove('content_add');
                    sports.classList.remove('content_add');

                    dummy2.style.borderRadius = "0px 0px 0px 0px";
                    dummy3.style.borderRadius = "0px 0px 0px 0px";
                    dummy1.style.borderRadius = "0px 0px 0px 0px";
                    dummy4.style.borderRadius = "0px 0px 100px 0px";
                    dummy5.style.borderRadius = "0px 100px 0px 0px";
          

            })


            // ----------------sports area-----------------//

            let sports = document.getElementById('sports');
            let sports_space = document.getElementById('sports-space');
            let close_sports = document.getElementById('close-sports');

            
            

            sports.addEventListener('click',() => {
                
                    sports_space.classList.add('sport');
                    sports.classList.add('content_add');
                    
                    users_space.classList.remove('sport');
                    clubs_space.classList.remove('sport');
                    evnt_area.classList.remove('sport');

                    evnt.classList.remove('content_add');
                    users.classList.remove('content_add');
                    clubs.classList.remove('content_add');

                    dummy1.style.borderRadius = "0px 0px 100px 0px";
                    dummy2.style.borderRadius = "0px 100px 0px 0px";
                    dummy3.style.borderRadius = "0px 0px 0px 0px";
                    dummy4.style.borderRadius = "0px 0px 0px 0px";
                    dummy5.style.borderRadius = "0px 0px 0px 0px";
                    
                    
                   
               
            });
            close_sports.addEventListener('click',()=>{
                   
                    sports_space.classList.remove('sport');
                    sports.classList.remove('content_add');
                    dummy1.style.borderRadius = "0px 0px 0px 0px";
                    dummy2.style.borderRadius = "0px 0px 0px 0px";
                
            });

           
            //------------------- users area------------------------//

            let users = document.getElementById('users');
            let users_space = document.getElementById('users-space');
            let close_users = document.getElementById('close-users');

            users.addEventListener('click',() => {
                
               
                    users_space.classList.add('sport');
                    users.classList.add('content_add');

                    sports_space.classList.remove('sport');
                    clubs_space.classList.remove('sport');
                    evnt_area.classList.remove('sport');

                    evnt.classList.remove('content_add');
                    sports.classList.remove('content_add');
                    clubs.classList.remove('content_add');

                    dummy2.style.borderRadius = "0px 0px 100px 0px";
                    dummy3.style.borderRadius = "0px 100px 0px 0px";
                    dummy1.style.borderRadius = "0px 0px 0px 0px";
                    dummy4.style.borderRadius = "0px 0px 0px 0px";
                    dummy5.style.borderRadius = "0px 0px 0px 0px";
                
            });
            close_users.addEventListener('click',()=>{
                  
                    users_space.classList.remove('sport');
                    users.classList.remove('content_add');

                    dummy2.style.borderRadius = "0px 0px 0px 0px";
                    dummy3.style.borderRadius = "0px 0px 0px 0px";
                
            });




            let clubs = document.getElementById('clubs');
            let clubs_space = document.getElementById('clubs-space');
            let close_clubs = document.getElementById('close-clubs');

            clubs.addEventListener('click',() => {
                console.log('hhhi clubs');
                
                    clubs_space.classList.add('sport');
                    clubs.classList.add('content_add');

                    users_space.classList.remove('sport');
                    sports_space.classList.remove('sport');
                    evnt_area.classList.remove('sport');

                    evnt.classList.remove('content_add');
                    users.classList.remove('content_add');
                    sports.classList.remove('content_add');

                    dummy2.style.borderRadius = "0px 0px 0px 0px";
                    dummy3.style.borderRadius = "0px 0px 100px 0px";
                    dummy1.style.borderRadius = "0px 0px 0px 0px";
                    dummy4.style.borderRadius = "0px 100px 0px 0px";
                    dummy5.style.borderRadius = "0px 0px 0px 0px";
               
            });
            close_sales.addEventListener('click',()=>{
               
                sales_space.classList.remove('sales');
                sales.style.background = "none";
            });

        });
    </script>
</body>
</html>