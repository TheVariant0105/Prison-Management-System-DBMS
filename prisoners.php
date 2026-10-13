<?php
session_start();
include('includes/db_connect.php');
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM prisoners";

if (isset($_GET['search']) && !empty($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $query = "SELECT * FROM prisoners 
              WHERE name LIKE '%$keyword%' 
                 OR crime LIKE '%$keyword%' 
                 OR cell_no LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Prisoners List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif;">
<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-center flex-grow-1">Prisoners List</h2>

    <?php if ($_SESSION['role'] == 'admin') { ?>
        <form method="GET" class="d-flex me-2" role="search">
            <input type="text" name="keyword" class="form-control me-2"
                   placeholder="Search by name, crime, or cell..."
                   value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
            <button type="submit" name="search" class="btn btn-outline-primary me-2">Search</button>
            <a href="prisoners.php" class="btn btn-outline-secondary">Clear</a>
        </form>
        <a href="add_prisoner.php" class="btn btn-primary">+ Add New</a>
    <?php } ?>
    </div>



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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <img src="<?php echo !empty($row['photo']) ? 'uploads/'.$row['photo'] : 'https://via.placeholder.com/60'; ?>"
                         width="60" height="60" style="border-radius:50%; object-fit:cover;">
                </td>
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
                <td>
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['prisoner_id']; ?>">View</button>
                <?php if ($_SESSION['role'] == 'admin') { ?>
                <a href="edit_prisoner.php?id=<?php echo $row['prisoner_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_prisoner.php?id=<?php echo $row['prisoner_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this prisoner?');">Delete</a>
                <?php } ?>
</td>

            </tr>

            <!-- Prisoner Modal -->
            <div class="modal fade" id="viewModal<?php echo $row['prisoner_id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Prisoner Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img src="<?php echo !empty($row['photo']) ? 'uploads/'.$row['photo'] : 'https://via.placeholder.com/100'; ?>" 
                         width="120" height="120" style="border-radius:50%; object-fit:cover;">
                    <h5 class="mt-3"><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p><strong>Age:</strong> <?php echo $row['age']; ?></p>
                    <p><strong>Crime:</strong> <?php echo htmlspecialchars($row['crime']); ?></p>
                    <p><strong>Crime:</strong> <?php echo htmlspecialchars($row['crime']); ?></p>
                    <p><strong>Sentence Duration:</strong> <?php echo $row['sentence_years']; ?> years</p>
                    <p><strong>Cell No:</strong> <?php echo htmlspecialchars($row['cell_no']); ?></p>
                    <p><strong>Status:</strong> <span class="badge <?php echo ($row['status'] == 'Active') ? 'bg-success' : 'bg-secondary'; ?>"><?php echo $row['status']; ?></span></p>
                    <p><strong>Entry Date:</strong> <?php echo $row['entry_date']; ?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
