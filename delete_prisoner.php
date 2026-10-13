<?php
session_start();
include('includes/db_connect.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: officer_dashboard.php");
    exit();
}
if (!isset($_GET['id'])) {
    die("Invalid request: missing prisoner ID");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT photo FROM prisoners WHERE prisoner_id=$id");
$row = mysqli_fetch_assoc($result);
if ($row && !empty($row['photo'])) {
    $photo_path = "uploads/" . $row['photo'];
    if (file_exists($photo_path)) {
        unlink($photo_path);
    }
}

$sql = "DELETE FROM prisoners WHERE prisoner_id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: prisoners.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
