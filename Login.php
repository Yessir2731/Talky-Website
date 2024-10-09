<?php

require('conek.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to get user details by username
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);

    // Bind the username parameter to the SQL statement
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_array();

        // Verify the password
        if (password_verify($password, $user['passwords'])) {
            // Start the session
            session_start();

            $role = $user['role'];

            if ($role == 1) {
                // If the user is an admin
                $_SESSION['log'] = 'logged';
                $_SESSION['role'] = 'admin';
                header('Location: ./admin/admin.php');
            } else {
                // If the user is a regular user
                $_SESSION['log'] = 'logged';
                $_SESSION['role'] = 'user';
                header('Location: ./user/user.php');
            }
        } else {
            // If the password does not match
            echo "Invalid username or password";
        }
    } else {
        // If no user is found with that username
        echo "Invalid username or password";
    }
}
?>
