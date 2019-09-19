<?php
include 'config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!$conn) {
	die("Connection to server failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE " . DB_NAME;
$conn->query($sql);
$conn->select_db(DB_NAME);
if (!$conn) {
	die("Connection to server failed: " . mysqli_connect_error());
}
$conn->query("SET CHARSET utf8");
$sql = 
"CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$conn->query($sql);

$sql = 
"INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(5, 'w', 'f1290186a5d0b1ceab27f4e77c0c5d68', 'qweasdzcx@qwe.com');";
$conn->query($sql);

$sql = 
"ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);";
$conn->query($sql);
  
$sql =
"ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;";
$conn->query($sql);

echo "done";
?>