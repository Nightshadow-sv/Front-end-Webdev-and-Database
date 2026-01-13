<?php
$conn = mysqli_connect("localhost", "root", "", "news_portal_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>