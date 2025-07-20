<?php
include 'session.php';
include 'db.php';
include 'flash.php';

$id = $_SESSION['user_id'];

// Use prepared statement for security
$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Contact Management</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php show_flash(); ?>
    <?php if ($user): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h2>
                <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p class="card-text"><strong>Phone:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
                <p class="card-text"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning">Edit Profile</a>
                    <a href="password.php" class="btn btn-secondary">Change Password</a>
                    <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Account</a>
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="read.php" class="btn btn-info">Manage Users</a>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-dark">Logout</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">User not found.</div>
    <?php endif; ?>
</body>
</html>
