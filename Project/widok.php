<?php
	include 'config.php';
	session_start();
	
	if(!isset($_SESSION["authorized"]))
		header('location: index.php');
	
	$log = 0;
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->query("SET CHARSET utf8");
	
	if( $_POST["act"] == "delete")
	{
		$sql = "DELETE FROM ".$_POST["table"]." WHERE ".$_POST["keyColumn"]."=".$_POST["actId"];
		$conn->query($sql);
		$log = $sql;
	}
	
	$sql = "SHOW COLUMNS FROM ".$_POST["table"];
	$result_header = $conn->query($sql);
	$nrOfColumns = $result_header->num_rows;
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
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
	
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
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-<?php echo (10-$nrOfColumns)?>">
							<h2><b><?php echo $_POST["table"] ?></b></h2>
						</div>
						<div class="col-sm-<?php echo (2+$nrOfColumns)?>">
							<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Record</span></a>					
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>
								<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
<?php
$i = 0;
while($row = $result_header->fetch_assoc()) {
	echo "<th>" .$row["Field"]. "</th>";
	$column[$i++] = $row["Field"];
	if($row["Key"] == "PRI")
		$keyColumn = $row["Field"];
}
?>
							<th>Akcje</th>
						</tr>
					</thead>
					<tbody>
<?php
if( $_POST["act"] == "update")
{
	$sql = "UPDATE ".$_POST["table"]." SET ";
	for($j = 0; $j < $nrOfColumns - 1; $j++)
	{
		$sql = $sql . $column[$j] . " = '" . $_POST[$column[$j]] . "', ";
	}
	$sql = $sql . $column[$nrOfColumns - 1] . " = '" . $_POST[$column[$nrOfColumns - 1]] . "' WHERE ".$_POST["keyColumn"]."=".$_POST["actId"];
	$conn->query($sql);
	$log = $sql;
}
else if( $_POST["act"] == "add")
{
	$sql = "INSERT INTO ".$_POST["table"]." VALUES (";
	for($j = 0; $j < $nrOfColumns - 1; $j++)
	{
		$sql = $sql ."'". $_POST[$column[$j]] . "', ";
	}
	$sql = $sql ."'". $_POST[$column[$nrOfColumns - 1]] ."')";
	$conn->query($sql);
	$log = $sql;
}

$sql = "SELECT * FROM ".$_POST["table"];
$result = $conn->query($sql);
$i = 0;
while($row = $result->fetch_assoc()) {
	echo
'						<tr>
							<td>
								<span class="custom-checkbox">
									<input type="checkbox" id="checkbox'.$i.'" name="options'.$row[$keyColumn].'" value="1">
									<label for="checkbox'.$i.'"></label>
								</span>
							</td>
';
	for($j = 0; $j < $nrOfColumns; $j++)
	{
		echo "<td>" . $row[$column[$j]]. "</td>";
	}
	echo
'							<td class="tdclick" id="tdc'.$row[$keyColumn].'">
								<a id="upd'.$row[$keyColumn].'" href="#editEmployeeModal'.$row[$keyColumn].'" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
								<a id="del'.$row[$keyColumn].'" href="#deleteEmployeeModal'.$row[$keyColumn].'" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
							</td>
						</tr>
';
	$key[$i] = $row[$keyColumn];
	$i++;
}
?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-4">
			<?php echo $log ?>
			</div>
		</div>
		<!-- Edit Modal HTML (add)-->
		<div id="addEmployeeModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="widok.php" method="POST">
						<div class="modal-header">						
							<h4 class="modal-title">Add Record</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">
<?php
for($j = 0; $j < $nrOfColumns; $j++)
{
	echo
'							<div class="form-group">
								<label>'.$column[$j].'</label>
								<input type="text" name="'.$column[$j].'" class="form-control" required>
							</div>
';
}
?>				
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-success" value="Add">
						</div>
						<input type="hidden" name="act" value="add">
						<input type="hidden" name="table" value="<?php echo $_POST["table"]?>">
					</form>
				</div>
			</div>
		</div>
		<!-- Edit Modal HTML (edit)-->
<?php
for($i=0; $i < $result->num_rows; $i++)
{	
	echo
'
		<div id="editEmployeeModal'.$key[$i].'" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="widok.php" method="POST">
						<div class="modal-header">						
							<h4 class="modal-title">Edit Record</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">';					

	for($j = 0; $j < $nrOfColumns; $j++)
	{
		echo
'							<div class="form-group">
								<label>'.$column[$j].'</label>
								<input name="'.$column[$j].'" type="text" class="form-control" required>
							</div>
';
	}
	echo
'
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-info" value="Save">
						</div>
						<input type="hidden" name="act" value="update">
						<input type="hidden" name="table" value="'.$_POST["table"].'">
						<input type="hidden" name="keyColumn" value="'.$keyColumn.'">
						<input type="hidden" class="actId" name="actId" value="'.$key[$i].'">
					</form>
				</div>
			</div>
		</div>';
}
?>	
		<!-- Delete Modal HTML -->
<?php
for($i=0; $i < $result->num_rows; $i++)
{
	echo
'		<div id="deleteEmployeeModal'.$key[$i].'" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="widok.php" method="POST">
						<div class="modal-header">						
							<h4 class="modal-title">Delete Record</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">					
							<p>Are you sure you want to delete these Record?</p>
							<p class="text-warning"><small>This action cannot be undone.</small></p>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-danger" value="Delete">
						</div>
						<input type="hidden" name="act" value="delete">
						<input type="hidden" name="table" value="'.$_POST["table"].'">
						<input type="hidden" name="keyColumn" value="'.$keyColumn.'">
						<input type="hidden" class="actId" id="delActId" name="actId" value="'.$key[$i].'">
					</form>
				</div>
			</div>
		</div>';
}
?>
	</body>
</html>
<?php
	$conn->close();
?>