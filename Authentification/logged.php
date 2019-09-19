<?php
	session_start();
	
	if(!isset($_SESSION['username']))
		header('location: index.php');
?>
<!--Made with love by Mutiullah Samim -->
<!--https://bootsnipp.com/snippets/vl4R7-->
<!DOCTYPE html>
<html>
<head>
	<title>Authorization Page</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card" style="height: 250px">
			<div class="card-header">
				<h3>Currently Logged</h3>
			</div>
			<div class="card-body">
				<form action="signout_process.php" method="POST">
					<div class="form-group">
						<input type="submit" value="Sign Out" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
<?php
	if(isset($_SESSION['transfer']) && $_SESSION['transfer'] != '')
	{
		echo '
				<form action="'.$_SESSION['transfer'].'" method="POST">
					<div class="form-group">
						<input type="submit" value="GO" class="btn float-left btn-success">
						<input name="authorized" type="hidden" value="true">
						<input name="user" type="hidden" value="'.$_SESSION['username'].'">
					</div>
				</form>';
	}
?>
			</div>
		</div>
	</div>
</div>
</body>
</html>