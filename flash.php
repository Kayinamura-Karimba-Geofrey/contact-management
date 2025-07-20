<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set a flash message
function set_flash($type, $message) {
    $_SESSION['flash'][$type][] = $message;
}

// Display and clear flash messages
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $messages) {
            foreach ($messages as $msg) {
                echo "<div class='alert alert-$type' role='alert'>" . htmlspecialchars($msg) . "</div>";
            }
        }
        unset($_SESSION['flash']);
    }
}
?>
