<?php
include 'db.php';
include 'flash.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $full_name= trim($_POST['full_name']);
    $email= trim($_POST['email']);
    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
    $phone_number=trim($_POST['phone_number']);
    $role=$_POST['role'];

    $stmt=$conn->prepare('select id from contacts where email=?');
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        set_flash('danger','email already in use');

    }else{
        $stmt=$conn->prepare("insert into contacts(full_name,email,password,phone_number,role) values(?,?,?,?,?)");
        $stmt->bind_param("sssis" ,$full_name,$email,$password,$phone_number,$role);
        if($stmt->execute()){
            set_flash('success','Registration successfull please login');
            header("location:login.php");
            exit();

        }else{
            set_flash('danger','Registration failed');

        }

    }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 500px;">
        <nav class="navbar navbar-light bg-light mb-4 rounded">
            <span class="navbar-brand mb-0 h1 mx-auto">Contact Management</span>
        </nav>
        <?php show_flash(); ?>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Register</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="number" id="phone_number" name="phone_number" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="login.php" class="btn btn-link">Already registered? Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>