<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['email']) ) {
    die('Not logged in');
}

$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
</p>
<h2>Automobiles</h2>
<table border="1">
<?php
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo($row['make']);
    echo("</td><td>");
    echo($row['year']);
    echo("</td><td>");
    echo($row['mileage']);
    echo("</td></tr>\n");
}
?>
</table>
<p>
<a href="add.php">Add New</a>
<a href="logout.php">Logout</a>
</p>
</div>
</body>
</html>
