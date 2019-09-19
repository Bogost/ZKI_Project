<?php
include 'config.php';

	session_start();
	
	$queryValue = '';
	if(isset($_SESSION["sqlQuery"]))
	{
		$queryValue = $_SESSION["sqlQuery"];
	}
	//authorization
	$setget = array( 'transfer' => $_SERVER["PHP_SELF"] );
	if(isset($_POST['authorized'])&&$_POST['authorized']=="true")
	{
		$_SESSION["authorized"] = $_POST['authorized'];
		$_SESSION["user"] = $_POST['user'];
	}
	if(!isset($_SESSION["authorized"]))
		header('location: ../Authentification/index.php?' . http_build_query($setget));
	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
?>
<!doctype html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PKI project</title>
  </head>
  <body>
	<div class="container">
		<div class="row">
			<div class="col-sm-5 alert alert-info">
				<strong style="font-size: 150%"><?php echo $_SESSION["user"]?></strong>
				<form action="signout.php" method="POST">
					<button type="button" onclick="submit()" class="btn btn-primary" style="float: right">Sign Out</button>
				</form>
			</div>
		</div>
		<form action="widok.php" method="POST">
			<div class="form-group">
				<label for="sel1">Choose table:</label>
				<select name="table" class="form-control" id="sel1">
<?php
	$sql = "SHOW TABLES FROM project_pki";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<option>" . $row["Tables_in_project_pki"]. "</option>";
		}
	}
?>
				</select>
				<br>
				<input type="submit" class="btn btn-info" value="Show Table Content">
				<input type="hidden" name="act" value="noact">
			</div>
		</form>
		<form action="widokQuery.php" method="POST">
			<label for="query1">Write SQL</label>
			<input type="text" id="query1" name="sqlQuery" class="form-control" value="<?php echo $queryValue?>">
			<br>
			<input type="submit" class="btn btn-info" value="Send Query">
		</form>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?php
	$conn->close();
?>