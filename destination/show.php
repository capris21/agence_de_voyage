<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php
if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM destination WHERE id_destination = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    $destinations = $statement->fetchAll(PDO::FETCH_ASSOC);
    $destination = $destinations[0];
} else {
    echo "Aucun élément sélectionné";
}
?>

<h2 class="mt-3 text-center">GESTION DES DESTINATIONS</h2>   
<div class="container">
    <div class="card mt-5" style="margin-left: 10%;">
        <div class="card-header bg-primary">
            <h4 class="text-white">Détails d'une destination</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <h5 class="col-md-4"><b>Pays : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["pays"]) ?></h5>
            </div>
            <hr>
            <div class="row">
                <h5 class="col-md-4"><b>Ville : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["ville"]) ?></h5>
            </div>
            <hr>
            <div class="row">
                <h5 class="col-md-4"><b>Prix : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["prix"]) ?> €</h5>
            </div>
            <hr>
            <div class="row">
                <h5 class="col-md-4"><b>Date de Départ : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["date_depart"]) ?></h5>
            </div>
            <hr>
            <div class="row">
                <h5 class="col-md-4"><b>Date de Retour : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["date_retour"]) ?></h5>
            </div>
            <hr>
            <div class="row">
                <h5 class="col-md-4"><b>Statut : </b></h5>
                <h5 class="col-md-8"><?= htmlspecialchars($destination["statut"]) ?></h5>
            </div>
        </div>
    </div>   
    <center class="mt-3">   
        <button class="btn btn-danger" onclick="window.history.back();">Annuler</button>
        <a href="modifier_destination.php?id=<?= htmlspecialchars($destination['id_destination']) ?>" class="btn btn-secondary">Modifier</a>
    </center>  
</div>  

<?php include('../include/footer.php'); ?>
