<?php
include 'session.php';
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM contacts WHERE id = $id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 500px;">
        <nav class="navbar navbar-light bg-light mb-4 rounded">
            <span class="navbar-brand mb-0 h1 mx-auto">Contact Management</span>
        </nav>
        <?php if (function_exists('show_flash')) show_flash(); ?>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Edit Profile</h2>
                <form method="post" action="update.php">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" value="<?= htmlspecialchars($user['phone_number']) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                    <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
