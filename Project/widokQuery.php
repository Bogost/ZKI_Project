<?php
	include 'config.php';
	session_start();
	
	if(!isset($_SESSION["authorized"]))
		header('location: index.php');
	
	$log = 0;
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$conn) {
		die("Connection to server failed: " . mysqli_connect_error());
	}
    $conn->query("SET CHARSET utf8");
	
	$_SESSION["sqlQuery"] = $_POST["sqlQuery"];
	$sql = $_POST["sqlQuery"];
	$result = $conn->query($sql);
	
	$error = mysqli_error($conn);
	if($error == '')
	{
		if($result->num_rows > 0)
		{
			$i = 0;
			while($row = $result->fetch_assoc())
			{
				foreach($row as $key => $value) {
					$data[$i][$key] = $value;
				}
				$i++;
			}
		}
		$columns = array_keys($data[0]);
		$nrOfColumns = count($columns);
		$nrOfRows = count($data);
	}
?>
<!-- https://www.tutorialrepublic.com/codelab.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>PKI project</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="wstyle.css">
		<script type="text/javascript">
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
});
		</script>
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
			<div class="row">
				<div class="col-sm-4">
					<a href="index.php" class="btn btn-success"><span>return to table selection</span></a>
				</div>
			</div>
			
<?php
//$result->num_rows
echo $error;
if( $error != '' || !$result )
{
	echo
	'		<div class="row">
				<div class="col-sm-12 alert alert-danger">';
	echo $error;
	echo
	'			</div>
			</div>
		</div>
	</body>
</html>';
}
else {
?>
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-12?>">
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
<?php
	foreach( $columns as $column) {
		echo "<th>" .$column. "</th>";
	}
?>
						</tr>
					</thead>
					<tbody>
<?php
	for($i = 0; $i < $nrOfRows; $i++){
		echo
	'						<tr>
	';
		for($j = 0; $j < $nrOfColumns; $j++)
		{
			echo '<td class="col-sm-'. floor(12/$nrOfColumns) .'">' . $data[$i][$columns[$j]]. "</td>";
		}
		echo
	'							
							</tr>
	';
	}
?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<?php
}
	$conn->close();
?>