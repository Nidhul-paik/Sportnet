<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="position:absolute; width:100%;" >
<?php
include('connection.php');
include('header.php');

// Get user inputs
$age = $_POST['age'];
$sport_item = $_POST['sport_item'];

// Determine age group based on age input
if ($age >= 18 && $age <= 25) {
    $age_group = '18-25';
} elseif ($age >= 26 && $age <= 35) {
    $age_group = '26-35';
} elseif ($age >= 36 && $age <= 45) {
    $age_group = '36-45';
} elseif ($age >= 46 && $age <= 60) {
    $age_group = '46-60';
} else {
    echo "<p>Sorry, we don't have plans for your age group.</p>";
    exit();
}

// Fetch workout plan from the database
$sql_workout = "SELECT workout_plan FROM workouts WHERE sport_item = '$sport_item' AND age_group = '$age_group'";
$result_workout = mysqli_query($conn, $sql_workout);
$workout_plan = mysqli_fetch_assoc($result_workout)['workout_plan'];

// Fetch diet plan from the database
$sql_diet = "SELECT diet_plan FROM diets WHERE sport_item = '$sport_item' AND age_group = '$age_group'";
$result_diet = mysqli_query($conn, $sql_diet);
$diet_plan = mysqli_fetch_assoc($result_diet)['diet_plan'];

// Convert workout and diet plans into array for list items
$workout_items = explode(',', $workout_plan); // Assuming plans are stored as comma-separated values
$diet_items = explode(',', $diet_plan);
?>

<div class="container my-5" style="width:100%; height:100vh; display:flex; justify-content:center; align-items:center; flex-direction:column;">
    <h2 class="text-center" style="font-weight: 900;" >Your Workout and Diet Plan</h2>
    
    <!-- Workout Plan Section -->
    <div class="mt-4" style="width: 100%;" >
        <h4>Workout Plan for <?php echo $sport_item; ?> (Age Group: <?php echo $age_group; ?>)</h4>
        <ul>
            <?php
            foreach ($workout_items as $workout) {
                echo "<li class='text-primary'; >" . trim($workout) . "</li>"; // Trim to remove extra spaces
            }
            ?>
        </ul>
    </div>
    
    <!-- Diet Plan Section -->
    <div class="mt-4" style="width: 100%;">
        <h4>Diet Plan for <?php echo $sport_item; ?> (Age Group: <?php echo $age_group; ?>)</h4>
        <ul>
            <?php
            foreach ($diet_items as $diet) {
                echo "<li class='text-primary'; style = 'font-size:18px';>" . trim($diet) . "</li>"; // Trim to remove extra spaces
            }
            ?>
        </ul>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>