<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php 
if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clients WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    $clients = $statement->fetchAll(PDO::FETCH_ASSOC);
    $client = $clients[0];
} else {
    echo "Aucun élément sélectionné";
}
?>

<?php
if (isset($_POST["nom"])) {
    $id = $_POST["id_client"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    
    $sql = "UPDATE clients SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->bindValue(':nom', $nom, PDO::PARAM_STR);
    $statement->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':telephone', $telephone, PDO::PARAM_STR);
    
    $statement->execute();
    header('Location: index.php');
    exit();
}
?>

<h2 class="mt-3 text-center">GESTION DES CLIENTS</h2>   
<div class="container">
    <div class="card mt-5" style="margin-left: 15%;">
        <div class="card-header bg-primary">
            <h4 class="text-white">Modification d'un client</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <input required type="text" value="<?= $client["id"] ?>" hidden name="id_client">
                
                <label for="nom">Nom</label>
                <input class="form-control" name="nom" value="<?= $client["nom"] ?>" type="text" required>
                
                <label for="prenom">Prénom</label>
                <input class="form-control" name="prenom" value="<?= $client["prenom"] ?>" type="text" required>
                
                <label for="email">Email</label>
                <input class="form-control" name="email" value="<?= $client["email"] ?>" type="email" required>
                
                <label for="telephone">Téléphone</label>
                <input class="form-control" name="telephone" value="<?= $client["telephone"] ?>" type="text" required>
                
                <center class="mt-3">   
                    <button class="btn btn-danger" type="button" onclick="window.history.back();">Annuler</button>
                    <button class="btn btn-secondary" type="submit">Enregistrer</button>
                </center>
            </form>
        </div>     
    </div>
</div>

<?php include('../include/footer.php'); ?>
