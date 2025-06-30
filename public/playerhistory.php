<?php include('connection.php'); 

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player History Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .search-container {
            margin-top: 50px;
            text-align: center;
        }
        .search-input {
            width: 400px;
            margin: 0 auto;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
$em = $_SESSION['email'];

$sq = "SELECT * FROM user WHERE email = '$em'";
$result = mysqli_query($conn, $sq);

if (mysqli_num_rows($result) > 0) {
    
    $page = 'user_profile.php';
} else {

    $page = 'club_pannel.php';
}
?>

<a href="<?php echo $page; ?>" style="text-decoration: none;">
    <i class="fa-solid fa-arrow-left" 
       style="font-size: 29px; color: #0c0629; position: fixed; left: 17px; top: 15px;"></i>
</a>


<div class="container">
    <div class="search-container">
        <h2 class="mb-4" style="font-weight: 900;">Player History Search</h2>
        <form method="GET" class="d-flex justify-content-center">
            <input type="text" name="query" class="form-control me-2 search-input" placeholder="Search by player name or club">
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mt-5">
            <thead class="table-dark">
                <tr>
                    <th>SI</th>
                    <th>Player ID</th>
                    <th>Name</th>
                    <th>Club</th>
                    <th>Jersey No</th>
                    <th>Position</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['query'])) {
                    $search = $conn->real_escape_string($_GET['query']);
                    $sql = "SELECT * FROM player_history 
                            WHERE name LIKE '%$search%' OR club LIKE '%$search%'";
                } else {
                    $sql = "SELECT * FROM player_history";
                }
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?><tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['player_id']?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td>
                                    <?php 
                                    $em =  $row['club']; 
                                    $sq = "SELECT club_name FROM club WHERE email = '$em'";
                                    $rs = mysqli_query($conn,$sq);
                                    $dd = mysqli_fetch_assoc($rs);
                                    echo $dd['club_name'];
                                    
                                
                                    ?>
                                </td>
                               
                                <td><?php echo $row['jersy_no']; ?></td>
                                <td><?php echo $row['position']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                              </tr>
                              <?php
                              $count++;
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
