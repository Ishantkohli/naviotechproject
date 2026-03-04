<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $message = "User found. You can reset password.";
        header("Location: reset-password.php?email=$email");
        exit();
    } else {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="S-L.css">
</head>
<body>

<div class="container">
    <form method="POST">
        <h1>Forgot Password</h1>
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit">Continue</button>
        <p style="color:red;"><?php echo $message; ?></p>
    </form>
</div>

</body>
</html>