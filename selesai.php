<?php 

error_reporting(E_ALL);

include './koneksi.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
    
$id = $_GET['id'];

$sql = mysqli_query($conn, "UPDATE todos SET selesai = '1' WHERE id=$id");

header("location:index.php");



?>