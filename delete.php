<?php
include 'session.php';
include 'db.php';
include 'flash.php';

$id = $_GET['id'];

if (is_admin() || $_SESSION['user_id'] == $id) {
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($_SESSION['user_id'] == $id) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        set_flash('success', 'contact deleted.');
        header("Location: users.php");
        exit();
    }
} else {
    set_flash('danger', 'Unauthorized.');
    header("Location: dashboard.php");
    exit();
}
