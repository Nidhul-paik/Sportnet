<?php
$config = parse_ini_file(__DIR__ . '/../.env');

$conn = mysqli_connect(
    $config['DB_HOST'],
    $config['DB_USER'],
    $config['DB_PASS'],
    $config['DB_NAME']
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";  // Optional for debug
?>
