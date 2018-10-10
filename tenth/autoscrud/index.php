<?php
require_once "pdo.php";
session_start();
$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");

if ($stmt === false) {
    $_SESSION['success'] = "No rows found";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>John Buchanan Moores Index Page</title>
<?php require_once 'bootstrap.php'; ?>
</head>
<body>
    <div class='container'>
    <h1>Welcome to the Automobiles Database</h1>
    <p>
    <?php
    if ( ! isset($_SESSION['name']) ) {
        echo '<a href="login.php">Please log in</a></p>';
        echo '<p>Attempt to <a href="add.php">add data</a> without logging in.</p>';
        echo '<p><a href="https://github.com/JohnBucMoore/wa4e/tree/master/tenth/autoscrud" target="_blank">Source Code for this Application</a></p>';
    } else {
        if ( isset($_SESSION['success']) ) {
            echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);
        }
        echo('<table border="1">'."\n");
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
            echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
            echo("</td></tr>\n");
        } 
        echo ("</table><p><a href=".'add.php'.">Add New Entry</a></p><p><a href=".'logout.php'.">Log Out</a></p>");
    }
    ?>
    
</div>
</body>
</html>