<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $row = mysqli_fetch_assoc($sql);

    if ($row && password_verify($password, $row['password_hash'])) {
        $_SESSION['admin'] = $row['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login">
    <form method="post">
        <h2>Login Admin</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>