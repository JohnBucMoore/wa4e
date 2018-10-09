<?php // Do not put any HTML above this line
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; //Pw is php123

$failure = false;  // If we have no POST data

if ( isset($_POST['email']) && isset($_POST['password']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1 ) {
        $failure = "Email and password are required";
      // Verify that the email address is formatted. if input is not formatted correctly then print string, else do the next function.
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $failure = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt.$_POST['password']);
        if ( $check == $stored_hash ) {
            error_log("Login success ".$_POST['email']);
            // Redirect the browser to autos.php
            header("Location: autos.php?name=".urlencode($_POST['email']));
            return;
        } else {
            error_log("Login fail ".$_POST['email']." $check");
            $failure = "Incorrect password";
        }
    }
}
// Fall through into the View
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
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="nam">Email</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="password" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the programming language this
 is written in (all lower case) followed by 123. -->
</p>
</div>
</body>
