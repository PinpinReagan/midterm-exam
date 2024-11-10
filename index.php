<?php
// Start the session to store session variables if needed
session_start();

// Predefined static users
$users = [
    ['email' => 'user1@example.com', 'password' => 'password1'],
    ['email' => 'user2@example.com', 'password' => 'password2'],
    ['email' => 'user3@example.com', 'password' => 'password3'],
    ['email' => 'user4@example.com', 'password' => 'password4'],
    ['email' => 'user5@example.com', 'password' => 'password5']
];

// Initialize error messages
$emailError = '';
$passwordError = '';
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userFound = false;

    // Check if the email or password is empty
    if (empty($email)) {
        $emailError = "• Email is required.";
    }

    if (empty($password)) {
        $passwordError = "• Password is required.";
    }

    // If both email and password are filled, validate against static users
    if (!empty($email) && !empty($password)) {
        foreach ($users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $userFound = true;
                // Redirect to a success page or dashboard
                $_SESSION['email'] = $email; // You can store session data here
                header('Location: dashboard.php'); // Redirect to the dashboard page after login
                exit; // Make sure to exit to stop further code execution
            }
        }

        // If no matching user, set error message
        if (!$userFound) {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            flex-direction: column; /* Arrange items in a column */
        }

        /* Style for the system error box at the top of the page */
        .system-error-box {
            width: 350px; /* Adjust width to resize the box */
            max-width: 600px; /* Set maximum width */
            padding: 10px; /* Space inside the box */
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            font-size: 15px; /* Adjust font size */
            font-weight: bold;
            text-align: left; /* Align text to the left */
            margin-bottom: 20px; /* Space below the error box */
            box-sizing: border-box; /* Include padding in the width */
            line-height: 1.5; /* Adjust line height for better readability */
            position: relative; /* Position relative for the close button */
        }

        /* Position the close button at the top-right corner */
        .system-error-box button.close-btn {
            position: absolute;
            top: 15px;
            right: 10px;
            background: transparent;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #721c24;
            cursor: pointer;
        }

        /* Optionally, if you want to style the error messages more distinctly */
        .system-error-box br {
            margin-bottom: 5px; /* Add spacing between error lines */
        }

        .login-container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin: 0 0 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        /* Style for error messages inside the form */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Display system error message at the top of the page -->
    <?php if ($emailError || $passwordError || $error): ?>
        <div class="system-error-box">
            <button class="close-btn" onclick="this.parentElement.style.display='none';">X</button>
            SYSTEM ERROR:
            <?php 
            if ($emailError) echo "<br>" . $emailError;
            if ($passwordError) echo "<br>" . $passwordError;
            if ($error) echo "<br>" . $error;
            ?>
        </div>
    <?php endif; ?>

    <!-- Login container -->
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

</body>
</html>
