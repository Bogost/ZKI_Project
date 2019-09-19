<?php
include 'config.php';
session_start();
	
$destination = 'logged.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
	die("Connection to server failed: " . mysqli_connect_error());
}
$conn->query("SET CHARSET utf8");
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$errors = array();

$password = md5($password);
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$results = mysqli_query($conn, $query);
if (mysqli_num_rows($results) == 1) {
	$_SESSION['username'] = $username;
	header("location: $destination");
}
else {
	array_push($errors, "Wrong username/password combination");
	$get_error = array( 'error' => $errors[0] );
	header('location: index.php?' . http_build_query($get_error),true,303);
}
?>