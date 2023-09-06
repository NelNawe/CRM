<?php

// On inclut la connexion à la base
require_once('Back/config.php');

// On écrit notre requête
$sql = 'SELECT * FROM `contact`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de contacts</title>
</head>
<body>

    <h1>Liste de contacts</h1>
    <table>
        <thead>
            <th>ID</th>
            <th>firstname</th>
            <th>lastname</th>
            <th>email</th>
            <th>Phone_number</th>
        </thead>
        <tbody>
        <?php
            foreach($result as $contact){
        ?>
                <tr>
                    <td><?= $contact['contact'] ?></td>
                    <td><?= $contact['firstname'] ?></td>
                    <td><?= $contact['lastname'] ?></td>
                    <td><?= $contact['ID'] ?></td>
                    <td><?= $contact['email'] ?></td>
                    <td><?= $contact['phonenumber'] ?></td>
                    
                    <td><a href="show.php?id=<?= $contact['id'] ?>">Voir</a>  <a href="create.php?id=<?= $contact['id'] ?>">Créer</a>  <a href="delete.php?id=<?= $contact['id'] ?>">Supprimer</a><a href="update.php?id=<?= $contact['id'] ?>">Modifier</a> </td>
                </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
    <a href="create.php">Ajouter</a>
</body>
</html>
