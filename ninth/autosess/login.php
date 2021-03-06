<?php
session_start();
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //Pw is php123
$email = '';
$password = '';
if ( isset($_POST['email']) && isset($_POST['password']) ) {
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $password = $_POST['password'];
    $_SESSION['password'] = $password;
    if ( strlen($_SESSION['email']) < 1 || strlen($_SESSION['password']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
        error_log("Login fail both email:".$_SESSION['email']." and password:".$_SESSION['password']." are required");
        header("Location: login.php");
        return;
    } elseif (!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        error_log("Login fail ".$_SESSION['email']." does not contain an at-sign (@)");
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_SESSION['password']);
        if ( $check == $stored_hash ) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['success'] = "Login successful";
            error_log("Login success ".$_SESSION['email']);
            header("Location: view.php");
            return;
        } else {
            error_log("Login fail ".$_SESSION['email']." $check");
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>John Buchanan Moore's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="post" action="login.php">
    <p><label for="email">Email:</label>
    <input type="text" name="email" id="email" size="40"
  <?php echo 'value="' . htmlentities($email) . '"';
?>
    /></p>
    <p><label for="password">Password:</label>
    <input type="text" name="password" id="password" size="40"
  <?php echo 'value="' . htmlentities($password) . '"';
?>
    /></p>
<p><input type="submit" name="login" value="Log In"/>
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the programming language this
 is written in (all lower case) followed by 123. -->
</p>
</div>
</body>
</html>
