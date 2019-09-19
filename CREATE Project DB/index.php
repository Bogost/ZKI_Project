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
$sql = "CREATE TABLE `marka` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";$conn->query($sql);
$sql = "
INSERT INTO `marka` (`id`, `nazwa`) VALUES
(1, 'Lays'),
(2, 'Mlekovita'),
(3, 'Cisowianka'),
(4, 'Mlekpol'),
(5, 'Stabilo');";$conn->query($sql);
$sql = "
CREATE TABLE `produkt` (
  `id` int(11) NOT NULL,
  `id_marki` int(11) NOT NULL,
  `nazwa` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";$conn->query($sql);
$sql = "
INSERT INTO `produkt` (`id`, `id_marki`, `nazwa`) VALUES
(1, 1, 'czipsy paprykowe'),
(2, 3, 'woda mineralna gazowana'),
(3, 2, 'żółty ser'),
(4, 4, 'maślanka'),
(5, 5, 'długopis');";$conn->query($sql);
$sql = "ALTER TABLE `marka`
  ADD PRIMARY KEY (`id`);";$conn->query($sql);
$sql = "
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marki` (`id_marki`);
  ";$conn->query($sql);
  $sql = "
ALTER TABLE `marka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;";$conn->query($sql);
$sql = 
"  
ALTER TABLE `produkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;";$conn->query($sql);
$sql = 
"
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`id_marki`) REFERENCES `marka` (`id`);
";$conn->query($sql);
$sql = "CREATE TABLE `marka` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$conn->query($sql);
$conn->close();
echo "done";
?>