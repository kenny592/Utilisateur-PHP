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
// Suppression après soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "<p style='color: green; text-align: center;'>Utilisateur supprimé avec succès !</p>";
    } else {
        $message = "<p style='color: red; text-align: center;'>Erreur lors de la suppression.</p>";
    }
    $stmt->close();
}
// Récupérer les données de l'utilisateur (uniquement si pas encore supprimé)
$sql = "SELECT * FROM user WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    die("Utilisateur non trouvé ou déjà supprimé.");
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer l'utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color:rgb(0, 0, 0);
            color: #333;
        }
        h1 {
            text-align: center;
            color: #dc3545;
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
        input[readonly] {
            background-color: #e9ecef;
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
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
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
<h1>Supprimer un utilisateur</h1>
<?php echo $message; ?>
<form method="post" onsubmit="return confirm('Es-tu sûr de vouloir supprimer cet utilisateur ?');">
    <label>Nom : <input type="text" value="<?= htmlspecialchars($row['nom']) ?>" readonly></label>
    <label>Prénom : <input type="text" value="<?= htmlspecialchars($row['prenom']) ?>" readonly></label>
    <label>Âge : <input type="text" value="<?= htmlspecialchars($row['age']) ?>" readonly></label>
    <label>Sexe :
        <input type="text" value="<?= htmlspecialchars($row['sexe']) ?>" readonly>
    </label><br>
    <button type="submit">Supprimer</button>
</form>
<div class="back-link">
    <a href="index.php">← Retour à la liste</a>
</div>
</body>
</html>

