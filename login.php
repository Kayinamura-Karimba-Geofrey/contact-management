<?php
include 'db.php';
include 'flash.php';
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=trim($_POST['email']);
    $password=($_POST['password']);

    $stmt=$conn->prepare('select id ,password,phone_number,role from contacts where email=?');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->bind_result($id,$hashed_password,$phone_number,$role);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['phone_number']=$phone_number;
            $_SESSION['role']    = $role;
            header("Location: dashboard.php");
            exit();
        } else {
            set_flash('danger', 'Incorrect password.');
        }
    } else {
        set_flash('danger', 'Email not found.');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
                <h2 class="card-title text-center mb-4">Login</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="register.php" class="btn btn-link">Need an account? Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>