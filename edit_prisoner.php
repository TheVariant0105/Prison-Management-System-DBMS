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
$result = mysqli_query($conn, "SELECT * FROM prisoners WHERE prisoner_id=$id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Prisoner not found.");
}

if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $crime = trim($_POST['crime']);
    $sentence_years = trim($_POST['sentence_years']);
    $cell_no = trim($_POST['cell_no']);
    $status = trim($_POST['status']);

    $photo = $row['photo']; 
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
    }

    $sql = "UPDATE prisoners SET 
                name='$name',
                age='$age',
                crime='$crime',
                sentence_years='$sentence_years',
                cell_no='$cell_no',
                photo='$photo',
                status='$status'
            WHERE prisoner_id='$id'";


    if (mysqli_query($conn, $sql)) {
        header("Location: prisoners.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Prisoner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-3 text-center">Edit Prisoner</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="<?php echo $row['age']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Crime</label>
                <input type="text" name="crime" class="form-control" value="<?php echo htmlspecialchars($row['crime']); ?>" required>
            </div>
            <div class="mb-3">
            <label class="form-label">Sentence Duration (in years)</label>
            <input type="number" name="sentence_years" value="<?php echo $row['sentence_years']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cell No</label>
                <input type="text" name="cell_no" class="form-control" value="<?php echo htmlspecialchars($row['cell_no']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option <?php if($row['status']=="Active") echo "selected"; ?>>Active</option>
                    <option <?php if($row['status']=="Released") echo "selected"; ?>>Released</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Photo</label><br>
                <?php if (!empty($row['photo'])) { ?>
                    <img src="uploads/<?php echo $row['photo']; ?>" width="80" height="80" style="border-radius:50%; object-fit:cover;"><br>
                <?php } ?>
                <input type="file" name="photo" accept="image/*" class="form-control mt-2">
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Update Prisoner</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
