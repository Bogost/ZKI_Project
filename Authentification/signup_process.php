<?php
	session_start();
	include 'config.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$conn->query("SET CHARSET utf8");
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$password_con = mysqli_real_escape_string($conn, $_POST['password_con']);
	$errors = array();
	
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password)) { array_push($errors, "Password is required"); }
	if ($password != $password_con) {
		array_push($errors, "The two passwords do not match");
	}
	
	// first check the database to make sure 
    // a user does not already exist with the same username and/or email
	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	// if user exists
	if ($user) { 
		if ($user['username'] === $username) {
		  array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "email already exists");
		}
	}
	
	// Finally, register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password);//encrypt the password before saving in the database

		$query = "INSERT INTO users (username, email, password) 
				  VALUES('$username', '$email', '$password')";
		mysqli_query($conn, $query);
		$_SESSION['username'] = $username;
		$conn->close();
		header('location: logged.php');
	}
	else
	{
		$get_error = array( 'error' => $errors[0] );
		header('location: signup.php?' . http_build_query($get_error),true,303);
	}
?>