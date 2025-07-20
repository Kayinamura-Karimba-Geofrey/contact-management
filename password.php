<?php
include 'session.php';
include 'db.php';
include 'flash.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST['current'];
    $new     = $_POST['new'];
    $confirm = $_POST['confirm'];
    $id      = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT password FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($hashed);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current, $hashed)) {
        set_flash('danger', 'Current password incorrect.');
    } elseif ($new !== $confirm) {
        set_flash('danger', 'New passwords do not match.');
    } else {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE contacts SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_hash, $id);
        $stmt->execute();
        set_flash('success', 'Password updated.');
    }

    header("Location: password.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 400px;">
        <nav class="navbar navbar-light bg-light mb-4 rounded">
            <span class="navbar-brand mb-0 h1 mx-auto">Contact Management</span>
        </nav>
        <?php show_flash(); ?>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Change Password</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="current" class="form-label">Current Password</label>
                        <input type="password" id="current" name="current" class="form-control" placeholder="Current Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new" class="form-label">New Password</label>
                        <input type="password" id="new" name="new" class="form-control" placeholder="New Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirm" name="confirm" class="form-control" placeholder="Confirm New Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                    <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
