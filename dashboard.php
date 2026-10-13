<?php
session_start();
include('includes/db_connect.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: officer_dashboard.php");
    exit();
}

$total_prisoners = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM prisoners"))[0];
$active_prisoners = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM prisoners WHERE status='Active'"))[0];
$released_prisoners = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM prisoners WHERE status='Released'"))[0];
$total_cells = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM cells"))[0];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f5f6fa;">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">🏛 Prison Management</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="prisoners.php">Prisoners</a></li>
        <li class="nav-item"><a class="nav-link" href="add_prisoner.php">Add Prisoner</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Admin Dashboard</h2>
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-primary">
        <div class="card-body">
          <h4><?php echo $total_prisoners; ?></h4>
          <p class="card-text text-muted">Total Prisoners</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-success">
        <div class="card-body">
          <h4><?php echo $active_prisoners; ?></h4>
          <p class="card-text text-muted">Active Prisoners</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-secondary">
        <div class="card-body">
          <h4><?php echo $released_prisoners; ?></h4>
          <p class="card-text text-muted">Released Prisoners</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-warning">
        <div class="card-body">
          <h4><?php echo $total_cells; ?></h4>
          <p class="card-text text-muted">Total Cells</p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
