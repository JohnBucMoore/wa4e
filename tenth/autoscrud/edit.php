<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ( isset($_POST['make']) && isset($_POST['year'])
     && isset($_POST['mileage']) && isset($_POST['auto_id']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All values are required';
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }
    $sql = "UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record edited';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that auto_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>John Buchanan Moores Automobile Editor Page</title>
<?php require_once 'bootstrap.php'; ?>
</head>
<p>Edit Automobile</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $md ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mi ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>