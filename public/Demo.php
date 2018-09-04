<?php
declare(strict_types=1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion BDD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>


<body>
    <?php include("../src/navigation_bar.html");
    require __DIR__.'/../src/App/DB_Connect.php';
    // require __DIR__.'/../src/GenericFunctions.php';
    // require __DIR__.'/../src/GetData.php';
    // require __DIR__.'/../src/EventInterface.php';

    // $dbco is the oject "connection to the database".
    $pdo = new App\DB_Connect();
    $conn = $pdo->DB_Link();


    
    $test = $conn->query("SELECT * FROM pizzeria.client");
    
    foreach  ($test as $row) {
        echo '<li>';
        echo $row["id"].'-'.$row["nom"]; 
        echo '</li>';
    }

    ?>

</body>
</html>
