<?php
require("db.php");
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("tracker");
$parnode = $dom->appendChild($node);
// Opens a connection to a MySQL server
$connection = mysqli_connect ('52.68.108.127:3306', $username, $password);
if (!$connection) { die('Not connected : ' . mysqli_connect_error($connection));}79
// Set the active MySQL database
$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
die ('Can\'t use db : ' . mysqli_connect_error($connection));
}
// Select all the rows in the tracker table
$query = "SELECT * FROM tracker ORDER BY id DESC LIMIT 1";
$result = mysqli_query($connection, $query);
if (!$result) {
die('Invalid query: ' . mysqli_connect_error($connection));
}
header("Content-type: text/xml");
// Iterate through the rows, adding XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
// ADD TO XML DOCUMENT NODE
$node = $dom->createElement("marker");
$newnode = $parnode->appendChild($node);
$newnode->setAttribute("id", $row['id']);
$newnode->setAttribute("date", $row['date']);
$newnode->setAttribute("speed", $row['speed']);
$newnode->setAttribute("lat", $row['lat']);
$newnode->setAttribute("lng", $row['lng']);
$newnode->setAttribute("course", $row['course']);
}80
echo $dom->saveXML();
?>