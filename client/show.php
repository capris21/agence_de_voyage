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

<h2 class="mt-3 text-center">GESTION DES CLIENTS</h2>   
<div class="container">
    <div class="card mt-5" style="margin-left: 10%;">
        <div class="card-header bg-primary">
            <h4 class="text-white">Détails d'un client</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <h5 class ="col-md-4"><b>Nom : </b></h5>
                <h5 class ="col-md-8"><?= $client["nom"] ?></h5>
            </div>
            <div class="row">
                <h5 class ="col-md-4"><b>Prénom : </b></h5>
                <h5 class ="col-md-8"><?= $client["prenom"] ?></h5>
            </div>
            <div class="row">
                <h5 class ="col-md-4"><b>Email : </b></h5>
                <h5 class ="col-md-8"><?= $client["email"] ?></h5>
            </div>
            <div class="row">
                <h5 class ="col-md-4"><b>Téléphone : </b></h5>
                <h5 class ="col-md-8"><?= $client["telephone"] ?></h5>
            </div>
        </div>
    </div>     
</div>  

<?php include('../include/footer.php'); ?>
