<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color:rgb(0, 0, 0);
            color: #333;
        }
        h1, h2 {
            text-align: center;
            color: #007BFF;
        }
        form {
            width: 300px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2e6ea;
        }
        .action-btn {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .edit-btn {
            background-color: #28a745;
        }

        .delete-btn {
            background-color:rgb(255, 0, 25);
        }
    </style>
</head>
<body>
    <h1>Ajouter un utilisateur</h1>
    <form method="post" action="insert.php">
        <label>Nom : <input type="text" name="nom" required></label>
        <label>Prénom : <input type="text" name="prenom" required></label>
        <label>Âge : <input type="text" name="age" required></label>
        <label>Sexe :
            <select name="sexe" required>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>
        </label><br>
        <button type="submit">Envoyer</button>
    </form>
<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'exophp';
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("<p style='color:red; text-align:center;'>Erreur de connexion : " . $conn->connect_error . "</p>");
}
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
echo "<h2>Liste des utilisateurs</h2>";
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>prenom</th>
                <th>age</th>
                <th>sexe</th>
                <th>action</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["nom"]."</td>
                <td>".$row["prenom"]."</td>
                <td>".$row["age"]."</td>
                <td>".$row["sexe"]."</td>
                <td>
                    <a class='action-btn edit-btn' href='edit.php?id=".$row["id"]."'>Modifier</a>
                    <a class='action-btn delete-btn' href='delete.php?id=".$row["id"]."'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>Aucun utilisateur trouvé.</p>";
}
$conn->close();
?>
</body>
</html>

