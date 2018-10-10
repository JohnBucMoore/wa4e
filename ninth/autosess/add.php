<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['email']) ) {
    die('Not logged in');
}

// If the user requested cancel go back to view.php
if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

$make = '';
$year = '';
$mileage = '';
if ( isset($_POST['add']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if ( strlen($_POST['make']) < 1) {
        $_SESSION['error'] = "Make is required";
        error_log("Data entry failure ".$_SESSION['error']);
        header("Location: add.php");
        return;
      // Verify that the email address is formatted. if input is not formatted correctly then print string, else do the next function.
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage and year must be numeric";
        error_log("Data entry failure ".$_SESSION['error']);
        header("Location: add.php");
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
        ':mk' => htmlentities($_POST['make']),
        ':yr' => htmlentities($_POST['year']),
        ':mi' => htmlentities($_POST['mileage']))
    );
    $_SESSION['success'] = "Record inserted";
    header("Location: view.php");
    return;
    }
}
?>

<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>John Buchanan Moore's Automobile Tracker</title>
</head>

<body>
<div class="container">
<h1>Tracking Autos for <?php
if ( isset($_SESSION['email']) ) {
    echo htmlentities($_SESSION['email']);
}
?></h1>
<p>
<?php
    if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
</p>
<form method="post">
<p><label for="make">Make:</label>
    <input type="text" name="make" id="make" size="60"
  <?php echo 'value="' . htmlentities($make) . '"';
?>
    /></p>
<p><label for="year">Year:</label>
    <input type="text" name="year" id="year"
  <?php echo 'value="' . htmlentities($year) . '"';
?>
    /></p>
<p><label for="mileage">Mileage:</label>
    <input type="text" name="mileage" id="mileage"
  <?php echo 'value="' . htmlentities($mileage) . '"';
?>
    /></p>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>
