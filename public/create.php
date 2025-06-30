<?php
include('connection.php');

// Extended diet plans data
$insert_diets = "INSERT INTO diets (sport_item, age_group, diet_plan) VALUES 
    ('Football', '18-25', 'High protein, moderate carbs, hydration with electrolytes, Whole grains, lean meats, vegetables.'),
    ('Football', '26-35', 'Balanced protein and carbs, Low-fat dairy, whole grains, lean protein, hydration with water and electrolytes.'),
    ('Football', '36-45', 'Moderate protein, lower carbs, Focus on fiber-rich vegetables, Hydration with water, Moderate portion control.'),
    ('Football', '46-60', 'Low-calorie, high-fiber diet, Focus on lean proteins, Healthy fats like olive oil, Hydration with water.'),
    
    ('Cricket', '18-25', 'High carbs for energy, moderate protein, lean meats, whole grains, vegetables, plenty of water.'),
    ('Cricket', '26-35', 'Balanced diet with more focus on carbs, Whole grains, fruits, vegetables, moderate protein, hydration.'),
    ('Cricket', '36-45', 'Moderate carbs, focus on fiber, Whole grains, lean protein, hydration with water.'),
    ('Cricket', '46-60', 'Low carbs, high fiber, Lean meats, vegetables, hydration with water.'),
    
    ('Volleyball', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
    ('Volleyball', '26-35', 'Balanced protein and carbs, more focus on vegetables and lean protein, hydration with water.'),
    ('Volleyball', '36-45', 'Moderate protein, low carbs, more vegetables and fiber, hydration with water.'),
    ('Volleyball', '46-60', 'Low-fat, high-fiber diet, Focus on lean protein, more vegetables, hydration with water.'),
    
    ('Basketball', '18-25', 'High protein, high carbs, lean meats, whole grains, fruits and vegetables, hydration with electrolytes.'),
    ('Basketball', '26-35', 'Balanced protein and carbs, more focus on fruits, vegetables, hydration with water.'),
    ('Basketball', '36-45', 'Moderate protein, low carbs, focus on vegetables, hydration with water.'),
    ('Basketball', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
    
    ('Kabaddi', '18-25', 'High protein, moderate carbs, fiber-rich vegetables, lean meats, hydration with electrolytes.'),
    ('Kabaddi', '26-35', 'Balanced protein and carbs, vegetables, whole grains, hydration with water.'),
    ('Kabaddi', '36-45', 'Moderate protein, low carbs, more vegetables, hydration with water.'),
    ('Kabaddi', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
    
    ('Kho-Kho', '18-25', 'High protein, moderate carbs, vegetables, lean meats, whole grains, hydration with water.'),
    ('Kho-Kho', '26-35', 'Balanced protein and carbs, more vegetables and fiber, hydration with water.'),
    ('Kho-Kho', '36-45', 'Moderate protein, lower carbs, fiber-rich vegetables, hydration with water.'),
    ('Kho-Kho', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.'),
    
    ('Tennis', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
    ('Tennis', '26-35', 'Balanced protein and carbs, more focus on vegetables, hydration with water.'),
    ('Tennis', '36-45', 'Moderate protein, low carbs, focus on vegetables, hydration with water.'),
    ('Tennis', '46-60', 'Low-fat, high-fiber diet, lean proteins, hydration with water.'),
    
    ('Badminton', '18-25', 'High protein, moderate carbs, lean meats, vegetables, whole grains, hydration with water and electrolytes.'),
    ('Badminton', '26-35', 'Balanced protein and carbs, vegetables, whole grains, hydration with water.'),
    ('Badminton', '36-45', 'Moderate protein, low carbs, more vegetables, hydration with water.'),
    ('Badminton', '46-60', 'Low-calorie, high-fiber diet, lean proteins, hydration with water.')
";

// Execute the query
if (mysqli_query($conn, $insert_diets)) {
    echo "Diet data inserted successfully.";
} else {
    echo "Error inserting diet data: " . mysqli_error($conn);
}
?>
