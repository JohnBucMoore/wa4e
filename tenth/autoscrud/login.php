<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //Pw is php123
if ( isset($_POST['email']) && isset($_POST['pass'])  ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        error_log("Login fail both email:".$_SESSION['email']." and password:".$_SESSION['pass']." are required");
        header("Location: login.php");
        return;
    } 
    // use this to debug code: echo("<p>Handling POST data...</p>\n"); 
    $sql = "SELECT name FROM users 
        WHERE email = :em AND password = :pw";
    // use this to debug code: echo "<p>$sql</p>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['email'], 
        ':pw' => $_POST['pass']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // use this to debug code: var_dump($row);
    if ( $row === FALSE ) {
        $_SESSION['error'] = "Login incorrect";
        error_log("Login failed ".$_SESSION['email']." not found in database");
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION['name'] = $_POST['email'];
            $_SESSION['success'] = "Login successful";
            error_log("Login success ".$_SESSION['email']);
            header("Location: index.php");
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
<title>John Buchanan Moore's Login Page</title>
<?php require_once "bootstrap.php"; ?>
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
<label for="email">User Name</label><input type="text" name="email"><br/>
<label for="pass">Password</label><input type="text" name="pass"><br/>
<input type="submit" value="Log In">
<a href="index.php">Cancel</a></p>
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