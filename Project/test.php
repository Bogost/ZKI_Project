<?php
include 'config.php';
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->query("SET CHARSET utf8");
$sql = "SELECT * FROM produkt";
$result = $conn->query($sql);

$data = array();
$i = 0;
while($row = $result->fetch_assoc())
{
    foreach($row as $key => $value) {
        $data[$i][$key] = $value;
    }
	$i++;
}
print_r($data);
echo '<br>';
print_r(count($data));
?>