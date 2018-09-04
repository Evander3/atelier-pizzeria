<?php
    declare(strict_types=1);
    include("../src/navigation_bar.html");
    require __DIR__.'/../src/App/DB_Connect.php';

    $control = 0;
    // First : connection with the DB
    $pdo = new App\DB_Connect();
    $db_link = $pdo->DB_Link();

    // Second we do the eventual change in the DB
    if (isset($_POST['delete_client']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                DELETE FROM pizzeria.client
                WHERE id = :id2del
            ");
            $stmt->bindValue(':id2del', $_POST['client_id']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    } elseif (isset($_POST['add_client']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                INSERT INTO pizzeria.client (nom, prenom, ville, age)
                VALUES (:nom, :prenom, :ville, :age)
            ");
            $stmt->bindValue(':nom', strtoupper(trim($_POST['client_nom'])));
            $stmt->bindValue(':prenom', ucfirst(strtolower(trim($_POST['client_prenom']))));
            $stmt->bindValue(':ville', ucfirst(strtolower(trim($_POST['client_ville']))));
            $stmt->bindValue(':age', $_POST['client_age']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['mod_client']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                UPDATE pizzeria.client
                SET nom = :nom, prenom = :prenom, ville = :ville, age = :age
                WHERE id = :id2up
            ");
            $stmt->bindValue(':nom', strtoupper(trim($_POST['client_nom'])));
            $stmt->bindValue(':prenom', ucfirst(strtolower(trim($_POST['client_prenom']))));
            $stmt->bindValue(':ville', ucfirst(strtolower(trim($_POST['client_ville']))));
            $stmt->bindValue(':age', $_POST['client_age']);
            $stmt->bindValue(':id2up', $_POST['client_id']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    if ($control === 1)
    {
        $stmt->execute();
        header('Location: GstClnt.php');
    }

    
    // Then we load data from DB.
    $data = $db_link->query("SELECT * FROM pizzeria.client");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La Florentina</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    
    <header class="page-header">
        <h1>Gestion Clients</h1>
    </header>

    <section>
        <table align=center style="width:70%">
        <tr>
            <th>Id.</th>
            <th>NOM</th>
            <th>Prénom</th>
            <th>Ville</th>
            <th colspan=3>Age</th>
        </tr>

        <br/>
        <br/>

        <?php
        foreach  ($data as $row) {
            if (isset($_POST['modify_client']) && $row["id"]===$_POST['client_id'])
            {
                echo '<tr>
                    <form method="post">
                        <td>'.$row["id"].'<input type="number" name="client_id" value='.$row["id"].' hidden></td>
                        <td><input type="text" maxlength="64" name="client_nom" value="'.$row["nom"].'" required ></td>
                        <td><input type="text" maxlength="64" name="client_prenom" value="'.$row["prenom"].'" required ></td>
                        <td><input type="text" maxlength="64" name="client_ville" value="'.$row["ville"].'" required ></td>
                        <td><input type="number" maxlength="64" name="client_age" value='.$row["age"].' min=0 max=99 required ></td>
                        <td colspan=2> <input type="submit" name="mod_client" value="Valider"></td>
                    </form>
                </tr>';
            } else {
                echo '<tr>
                <td> '.$row["id"].'</td>
                <td> '.$row["nom"].'</td>
                <td> '.$row["prenom"].'</td>
                <td> '.$row["ville"].'</td>
                <td> '.$row["age"].'</td>
                <td> <form method="post"><input type="text" name="client_id" value="'.$row["id"].'" hidden><input type="submit" name="delete_client" value="Supprimer"></form></td>
                <td> <form method="post"><input type="text" name="client_id" value="'.$row["id"].'" hidden><input type="submit" name="modify_client" value="Modifier"></form></td>
                </tr>';
            }
        }
        $new_row = $row["id"]+1;
        unset($data, $row);

        if ( !isset($_POST['modify_client']))
        { ?>

        <tr>
            <td colspan=6><h3>Ajouter un client</h3></td>
        </tr>

        <form method="post">
            <tr>
                <td><?php echo $new_row ?></td>
                <td><input type="text" maxlength="64" name="client_nom" placeholder="Nom" required ></td>
                <td><input type="text" maxlength="64" name="client_prenom" placeholder="Prénom" required ></td>
                <td><input type="text" maxlength="64" name="client_ville" placeholder="Ville" required ></td>
                <td><input type="number" name="client_age" placeholder="Age" min=0 max=99 required ></td>  <!-- oui j'interdis les personnes de plus de 99 ans à commander des pizzas ... et alors ? -->
                <td colspan=2><input type="submit" name="add_client" value='Ajouter'></td>
            </tr>
        </form>
        <?php } ?>

        </table>
    </section>

</body>
</html>

