<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container my-5">
    <h2 class="text-center mb-4">Find Your Workout and Diet Plan</h2>
    <form action="search-results.php" method="POST" class="p-4 bg-light rounded">
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
</html>