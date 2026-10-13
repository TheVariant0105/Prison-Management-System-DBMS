<?php
session_start();
include('includes/db_connect.php');
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: officer_dashboard.php");
    exit();
}
$message = ""; 

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $crime = trim($_POST['crime']);
    $sentence_years = trim($_POST['sentence_years']);
    $cell_no = trim($_POST['cell_no']);
    $status = 'Active';

    $check_sql = "SELECT * FROM prisoners WHERE name='$name' AND age='$age' AND crime='$crime'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $message = '<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                        ⚠️ Prisoner already exists in the system!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    } else {
        $photo = "";
        if (!empty($_FILES['photo']['name'])) {
            $photo = basename($_FILES['photo']['name']);
            $target_dir = "uploads/";
            $target_file = $target_dir . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
        }

        $sql = "INSERT INTO prisoners (name, photo, age, crime, sentence_years, cell_no, entry_date, status)
        VALUES ('$name', '$photo', '$age', '$crime', '$sentence_years', '$cell_no', NOW(), '$status')";


        if (mysqli_query($conn, $sql)) {
            $message = '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            ✅ Prisoner added successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        } else {
            $message = '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            ❌ Error adding prisoner: ' . mysqli_error($conn) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Prisoner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include('includes/header.php'); ?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="text-center mb-3">Add Prisoner</h3>
        <?php echo $message; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Crime</label>
                <input type="text" name="crime" class="form-control" required>
            </div>
            <div class="mb-3">
            <label class="form-label">Sentence Duration (in years)</label>
            <input type="number" name="sentence_years" class="form-control" placeholder="e.g. 5" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cell No</label>
                <input type="text" name="cell_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Add Prisoner</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
