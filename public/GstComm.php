<?php
    declare(strict_types=1);
    include("../src/navigation_bar.html");
    require __DIR__.'/../src/App/DB_Connect.php';

    $control = 0;
    // First : connection with the DB
    $pdo = new App\DB_Connect();
    $db_link = $pdo->DB_Link();

    // Second we do the eventual change in the DB
    if (isset($_POST['delete_commande']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                DELETE FROM pizzeria.commande
                WHERE id = :id2del
            ");
            $stmt->bindValue(':id2del', $_POST['commande_id']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['add_commande']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                INSERT INTO pizzeria.commande (libelle, reference, prix, url_image)
                VALUES (:libelle, :reference, :prix, :url_image)
            ");
            $pizza_nom = strtolower(trim($_POST['pizza_nom']));
            $pizza_ref = "P".substr(strtoupper(str_replace(' ', '', $pizza_nom)),0,3);
            $stmt->bindValue(':libelle', ucfirst($pizza_nom));
            $stmt->bindValue(':reference', $pizza_ref);
            $stmt->bindValue(':prix', $_POST['pizza_prix']);
            $stmt->bindValue(':url_image', htmlspecialchars($_POST['pizza_url']));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['mod_commande']))
    {
        $control = 1;
        try {
            $stmt = $db_link->prepare("
                UPDATE pizzeria.commande
                SET libelle = :libelle, reference = :reference, prix = :prix, url_image = :url_image
                WHERE id = :id2up
            ");
            $pizza_nom = strtolower(trim($_POST['pizza_nom']));
            $pizza_ref = "P".substr(strtoupper(str_replace(' ', '', $pizza_nom)),0,3);
            $stmt->bindValue(':libelle', ucfirst($pizza_nom));
            $stmt->bindValue(':reference', $pizza_ref);
            $stmt->bindValue(':prix', $_POST['pizza_prix']);
            $stmt->bindValue(':url_image', htmlspecialchars($_POST['pizza_url']));
            $stmt->bindValue(':id2up', $_POST['commande_id']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    if ($control === 1)
    {
        $stmt->execute();
        // header('Location: GstComm.php');
    }

    
    // Then we load data from DB.
    $data = $db_link->query("SELECT * FROM pizzeria.commande");
// ok so it seems a WIP query would be :

// SELECT
// 	commande.numero_commande as NUMERO_COMMANDE,
// 	commande.date_commande as DATE_COMMANDE,
//     client.nom,
//     client.prenom,
//     pizza.id,
//     livreur.nom,
//     livreur.prenom
// FROM `commande`
// RIGHT JOIN commande_pizza ON commande.id = commande_pizza.commande_id
// INNER JOIN pizza ON commande_pizza.pizza_id = pizza.id
// INNER JOIN livreur ON commande.livreur_id = livreur.id
// INNER JOIN client ON commande.client_id = client.id

// however it seems it's not WAD (not the same results)

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
        <h1>Gestion des Commandes</h1>
        
        
        
        
        <h1>WIP WIP WIP WIP WIP</h1>
    </header>

    <section>
        <table align=center style="width:70%">
        <tr>
            <th>Id.</th>
            <th>Libellé</th>
            <th>Référence</th>
            <th>Prix (€)</th>
            <th colspan=3>Image</th>
        </tr>

        <br/>
        <br/>

        <?php
        foreach  ($data as $row) {
            if (isset($_POST['modify_commande']) && $row["id"]===$_POST['commande_id'])
            {
                echo '<tr>
                    <form method="post">
                        <td>'.$row["id"].'<input type="number" name="commande_id" value='.$row["id"].' hidden></td>
                        <td><input type="text" maxlength="64" name="pizza_nom" value="'.$row["libelle"].'" required ></td>
                        <td><input type="text" maxlength="4" name="pizza_reference" value="'.$row["reference"].'" disabled required ></td>
                        <td><input type="number" name="pizza_prix" value="'.$row["prix"].'" min=0 max=15 required ></td>
                        <td><input type="url" name="pizza_url" value='.$row["url_image"].' required ></td>
                        <td colspan=2> <input type="submit" name="mod_commande" value="Valider"></td>
                    </form>
                </tr>';
            } else {
                echo '<tr>
                <td> '.$row["id"].'</td>
                <td> '.$row["libelle"].'</td>
                <td> '.$row["reference"].'</td>
                <td> '.$row["prix"].'</td>
                <td> <img src="'.$row["url_image"].'" alt="'.$row["libelle"].'" width=200></td>
                <td> <form method="post"><input type="text" name="commande_id" value="'.$row["id"].'" hidden><input type="submit" name="delete_commande" value="Supprimer"></form></td>
                <td> <form method="post"><input type="text" name="commande_id" value="'.$row["id"].'" hidden><input type="submit" name="modify_commande" value="Modifier"></form></td>
                </tr>';
            }
        }
        $new_row = $row["id"]+1;
        unset($data, $row);

        if ( !isset($_POST['modify_commande']))
        { ?>

        <tr>
            <td colspan=6><h3>Nouvelle Commande</h3></td>
        </tr>

        <form method="post">
            <tr>
                <td><?php echo $new_row ?></td>
                <td><input type="text" maxlength="64" name="pizza_nom" placeholder="Nom pizza" required ></td>
                <td><input type="text" maxlength="4" name="pizza_reference" value="XXXX" disabled required ></td>
                <td><input type="number" name="pizza_prix" placeholder=9,99 min=0 max=15 required ></td>  <!-- oui, pas plus de 15€ pour une pizza faut pas déconner -->
                <td><input type="url" name="pizza_url" placeholder="http://www.example.com/pizza.jpg" required ></td>
                <td colspan=2><input type="submit" name="add_commande" value='Ajouter'></td>
            </tr>
        </form>
        <?php } ?>

        </table>
    </section>

</body>
</html>

