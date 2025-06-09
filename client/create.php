<?php
session_start();
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php
if (isset($_POST["nom"])) {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    
    // Préparer la requête d'insertion
    $sql = "INSERT INTO clients(nom, prenom, email, telephone) VALUES(:nom, :prenom, :email, :telephone)";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':nom', $nom, PDO::PARAM_STR);
    $statement->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':telephone', $telephone, PDO::PARAM_STR);
    
    // Exécuter la requête
    $statement->execute();
    
    // Rediriger vers la page d'index
    header('Location: index.php');
    exit();
}
?>

<h2 class="mt-3 text-center">GESTION DES CLIENTS</h2>   
<div class="container">
    <div class="card mt-5" style="margin-left: 15%;">
        <div class="card-header bg-primary">
            <h4 class="text-white">FORMULAIRE D'AJOUT DE CLIENT</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <table class="table table-striped">
                    <tr>
                        <td><label for="nom">Nom</label></td>
                        <td><input class="form-control" name="nom" type="text" required></td>
                    </tr>
                    <tr>
                        <td><label for="prenom">Prénom</label></td>
                        <td><input class="form-control" name="prenom" type="text" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input class="form-control" name="email" type="email" required></td>
                    </tr>
                    <tr>
                        <td><label for="telephone">Téléphone</label></td>
                        <td><input class="form-control" name="telephone" type="text" required></td>
                    </tr>
                </table>
                <center class="mt-3">   
                    <button class="btn btn-danger" type="button" onclick="window.history.back();">Annuler</button>
                    <button class="btn btn-secondary" type="submit">Enregistrer</button>
                </center>
            </form>
        </div>     
    </div>
</div>

<?php include('../include/footer.php'); ?>
