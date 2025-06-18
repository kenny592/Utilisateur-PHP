<?php
 //var_dump($_POST);
 if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['sexe'])){
    try{
    // connexion a la BDD
        $pdo = new PDO('mysql:host=localhost; dbname=exophp; charset=utf8mb4','root','',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    //requette preparé
    $request = $pdo->prepare("INSERT INTO user (nom, prenom, age, sexe) VALUES (?, ?, ?, ?)");
    $request->execute([$_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['sexe']]);
    //redirection vers index.php
        header("location: index.php");
        exit();
    }
    catch(PDOExecption $e){
        echo "erreur:" .$e->getMessage();
    }
};




 