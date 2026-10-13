<?php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Simple officer dashboard
?>
<!DOCTYPE html>
<html>
<head>
  <title>Officer Dashboard</title>
</head>
<body class="bg-light">
<?php include('includes/header.php'); ?>

<div class="container mt-5">
  <div class="card shadow-sm p-4">
    <h2 class="text-center mb-3">Welcome, Officer <?php echo $_SESSION['username']; ?> 👮‍♂️</h2>
    <p class="text-center text-muted">You can view prisoner details but not edit or delete them.</p>

    <div class="text-center mt-3">
      <a href="officer_prisoners.php" class="btn btn-primary">View Prisoners</a>
    </div>
  </div>
</div>
</body>
</html>
