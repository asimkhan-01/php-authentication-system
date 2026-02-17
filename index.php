<?php
session_start();

$file = "users.txt";

/* ---------------- SIGNUP ---------------- */
if(isset($_POST['signup'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = $username . "|" . $email . "|" . $password . "\n";
    file_put_contents($file, $data, FILE_APPEND);

    $success = "Signup Successful! Now Login.";
}

/* ---------------- LOGIN ---------------- */
if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(file_exists($file)){
        $lines = file($file);

        foreach($lines as $line){
            $user = explode("|", trim($line));

            if($user[1] == $email && $user[2] == $password){
                $_SESSION['username'] = $user[0];
                header("Location: index.php");
                exit();
            }
        }
    }

    $error = "Invalid Email or Password!";
}

/* ---------------- LOGOUT ---------------- */
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Auth</title>
</head>
<body>

<?php if(isset($_SESSION['username'])): ?>

    <h2>Welcome <?php echo $_SESSION['username']; ?> 🎉</h2>
    <p>This is your Dashboard</p>
    <a href="?logout=true">Logout</a>

<?php else: ?>

    <h2>Signup</h2>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="signup">Signup</button>
    </form>

    <hr>

    <h2>Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>

<?php endif; ?>

</body>
</html>
