<?php
require_once "pdo.php";

// Demand a GET parameter
if ( !isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$failure = false;  // If we have no POST data

// POST data into autos table and process that input
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if ( strlen($_POST['make']) < 1) {
        $failure = "Make is required";
      // Verify that the email address is formatted. if input is not formatted correctly then print string, else do the next function.
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = "Mileage and year must be numeric";
    } else {
        $sql = "INSERT INTO autos (make, year, mileage) 
                  VALUES (:make, :year, :mileage)";
        echo("<pre>\n".$sql."\n</pre>\n");
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']));
    }
}
// DELETE data from autos table
if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    echo "<pre>\n$sql\n</pre>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
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
if ( isset($_REQUEST['name']) ) {
    echo htmlentities($_REQUEST['name']);
}
?></h1>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

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
    echo("</td><td>");
    echo('<form method="post"><input type="hidden" ');
    echo('name="auto_id" value="'.$row['auto_id'].'">'."\n");
    echo('<input type="submit" value="Del" name="delete">');
    echo("\n</form>\n");
    echo("</td></tr>\n");
}
?>
</table>
</div>
</body>
</html>