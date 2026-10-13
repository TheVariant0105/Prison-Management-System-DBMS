<?php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'officer') {
    header("Location: index.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM prisoners");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Prisoners (Officer View)</title>
</head>
<body style="background-color: #f8f9fa;">
<?php include('includes/header.php'); ?>

<div class="container mt-4">
  <h2 class="text-center mb-4">Prisoners List (Read-Only)</h2>
  <table class="table table-bordered table-striped table-hover shadow-sm">
    <thead class="table-primary">
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Age</th>
        <th>Crime</th>
        <th>Sentence (Years)</th>
        <th>Cell No</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><img src="<?php echo !empty($row['photo']) ? 'uploads/'.$row['photo'] : 'https://via.placeholder.com/60'; ?>" width="60" height="60" style="border-radius:50%;object-fit:cover;"></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo $row['age']; ?></td>
        <td><?php echo htmlspecialchars($row['crime']); ?></td>
        <td><?php echo $row['sentence_years']; ?></td>
        <td><?php echo htmlspecialchars($row['cell_no']); ?></td>
        <td>
          <span class="badge <?php echo ($row['status'] == 'Active') ? 'bg-success' : 'bg-secondary'; ?>">
            <?php echo $row['status']; ?>
          </span>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
