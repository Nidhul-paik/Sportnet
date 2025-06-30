<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="position:absolute;width:100%;" >
    
<?php include('header.php'); 


if (isset($_SERVER['HTTP_REFERER'])) {
    $previousPage = $_SERVER['HTTP_REFERER'];
} else {
    $previousPage = 'main.php';  // A default page if no referrer is found
}?>
<a  href="<?php echo $previousPage; ?>" style="text-decoration: none;" ><i class="fa-solid fa-arrow-left" style="font-size: 29px; color:#0c0629; position: fixed;left: 17px;top: 100px;" ></i></a>

    <div class="container my-5" style="height: 100vh; display:flex; justify-content:center; align-items:center; flex-direction:column;">
    <h2 class="text-center mb-4">Find Your Workout and Diet Plan (18-60)</h2>
    <form action="search-results.php" method="POST" class="p-4 bg-light rounded"  style="width:100%;" >
        <div class="form-group mb-3">
            <label for="age">Enter Your Age:</label>
            <input type="number" name="age" id="age" class="form-control" placeholder="Enter your age" required>
        </div>
        <div class="form-group mb-3">
            <label for="sport_item">Select Sport Item:</label>
            <select name="sport_item" id="sport_item" class="form-control" required>
                <option value="" disabled selected>Select a sport</option>
                <option value="Football">Football</option>
                <option value="Cricket">Cricket</option>
                <option value="Volleyball">Volleyball</option>
                <option value="Basketball">Basketball</option>
                <option value="Kabaddi">Kabaddi</option>
                <option value="Kho-Kho">Kho-Kho</option>
                <option value="Tennis">Tennis</option>
                <option value="Badminton">Badminton</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Get Plan</button>
    </form>
</div>

</body>
<?php include('footer.php'); ?>
</html>