<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'exophp';
$conn = new mysqli($host, $user, $password, $dbname);
// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
// Vérifier si un ID est passé dans l'URL
if (!isset($_GET['id'])) {
    die("ID de l'utilisateur non spécifié.");
}
$id = intval($_GET['id']);
$message = "";
// Mise à jour après soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $age = $_POST["age"];
    $sexe = $_POST["sexe"];
    $stmt = $conn->prepare("UPDATE user SET nom=?, prenom=?, age=?, sexe=? WHERE id=?");
    $stmt->bind_param("ssisi", $nom, $prenom, $age, $sexe, $id);
    if ($stmt->execute()) {
        $message = "<p style='color: green; text-align: center;'>Utilisateur mis à jour avec succès !</p>";
    } else {
        $message = "<p style='color: red; text-align: center;'>Erreur lors de la mise à jour.</p>";
    }
    $stmt->close();
}
// Récupérer les données de l'utilisateur
$sql = "SELECT * FROM user WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    die("Utilisateur non trouvé.");
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color:rgb(0, 0, 0);
            color: #333;
        }
        h1 {
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
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #007BFF;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Modifier un utilisateur</h1>
<?php echo $message; ?>
<form method="post">
    <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($row['nom']) ?>" required></label>
    <label>Prénom : <input type="text" name="prenom" value="<?= htmlspecialchars($row['prenom']) ?>" required></label>
    <label>Âge : <input type="text" name="age" value="<?= htmlspecialchars($row['age']) ?>" required></label>
    <label>Sexe :
        <select name="sexe" required>
            <option value="Homme" <?= $row['sexe'] == "Homme" ? "selected" : "" ?>>Homme</option>
            <option value="Femme" <?= $row['sexe'] == "Femme" ? "selected" : "" ?>>Femme</option>
            <option value="Autre" <?= $row['sexe'] == "Autre" ? "selected" : "" ?>>Autre</option>
        </select>
    </label><br>
    <button type="submit">Mettre à jour</button>
</form>

