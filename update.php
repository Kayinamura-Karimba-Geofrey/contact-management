<?php
include 'db.php';
include 'flash.php';
session_start();

$id = $_POST['id'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];

$stmt = $conn->prepare("UPDATE contacts SET full_name=?, email=?, phone_number=? WHERE id=?");
$stmt->bind_param("sssi", $full_name, $email, $phone_number, $id);

if ($stmt->execute()) {
    set_flash('success', 'Profile updated successfully.');
} else {
    set_flash('danger', 'Error updating profile.');
}

header("Location: dashboard.php");
exit();
