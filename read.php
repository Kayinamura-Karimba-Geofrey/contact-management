<?php
include 'session.php';
include 'db.php';
include 'flash.php';

if (!is_admin()) {
    set_flash('danger', 'Access denied.');
    header("Location: dashboard.php");
    exit();
}

$results = $conn->query("SELECT id, full_name, email,phone_number, role FROM contacts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Contact Management</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h2>All Registered Contacts</h2>
    <?php show_flash(); ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th><th>Full Name</th><th>Email</th><th>Phone Number</th><th>Role</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone_number']) ?></td>
                            <td><?= $row['role'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete user?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
</body>
</html>
