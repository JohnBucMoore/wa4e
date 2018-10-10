<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

// If the user requested cancel go back to view.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['add']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])) {
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = "All values are required";
        error_log("Data entry failure ".$_SESSION['error']);
        header("Location: add.php");
        return;
      // Verify that the email address is formatted. if input is not formatted correctly then print string, else do the next function.
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Year and mileage must be integers";
        error_log("Data entry failure ".$_SESSION['error']);
        header("Location: add.php");
        return;
    } else {
        $sql = "INSERT INTO autos (make, year, mileage, model) VALUES ( :mk, :yr, :mi, :md)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':md' => $_POST['model']));
    $_SESSION['success'] = "added";
    header("Location: index.php");
    return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>John Buchanan Moore's Automobile Tracker</title>
</head>

<body>
<div class="container">
<h1>Tracking Autos for <?php
if ( isset($_SESSION['name']) ) {
    echo $_SESSION['name'];
}
?></h1>
<p>
<?php
    if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}
?>
</p>
<form method="post">
<p>Make:<input type="text" name="make"></p><br/>
<p>Model:<input type="text" name="model"></p><br/>
<p>Year:<input type="text" name="year"></p><br/>
<p>Mileage:<input type="text" name="mileage"></p><br/>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>