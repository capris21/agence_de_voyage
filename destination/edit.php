<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php 
if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM destinations WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->execute();
    $destinations = $statement->fetchAll(PDO::FETCH_ASSOC);
    $destination = $destinations[0];
} else {
    echo "Aucun élément sélectionné";
}
?>

<?php
if (isset($_POST["pays"], $_POST["ville"], $_POST["prix"], $_POST["date_depart"], $_POST["date_retour"], $_POST["statut"])) {
    $id = $_POST["id"];
    $pays = $_POST["pays"];
    $ville = $_POST["ville"];
    $prix = $_POST["prix"];
    $date_depart = $_POST["date_depart"];
    $date_retour = $_POST["date_retour"];
    $statut = $_POST["statut"];

    $sql = "UPDATE destinations SET pays = :pays, ville = :ville, prix = :prix, date_depart = :date_depart, date_retour = :date_retour, statut = :statut WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_STR);
    $statement->bindValue(':pays', $pays, PDO::PARAM_STR);
    $statement->bindValue(':ville', $ville, PDO::PARAM_STR);
    $statement->bindValue(':prix', $prix, PDO::PARAM_STR);
    $statement->bindValue(':date_depart', $date_depart, PDO::PARAM_STR);
    $statement->bindValue(':date_retour', $date_retour, PDO::PARAM_STR);
    $statement->bindValue(':statut', $statut, PDO::PARAM_STR);
    $statement->execute();

    header('Location: index.php');
    exit();
}
?>

<h2 class="mt-3 text-center">GESTION DES DESTINATIONS</h2>   
<div class="container">
    <div class="card mt-5" style="margin-left: 15%;">
        <div class="card-header bg-primary">
            <h4 class="text-white">Modification d'une destination</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <input required type="text" value="<?= htmlspecialchars($destination["id_"]) ?>" hidden name="id
                ">
                
                <label for="pays">Pays</label>
                <input class="form-control" name="pays" value="<?= htmlspecialchars($destination["pays"]) ?>" type="text" required>
                
                <label for="ville">Ville</label>
                <input class="form-control" name="ville" value="<?= htmlspecialchars($destination["ville"]) ?>" type="text" required>
                
                <label for="prix">Prix</label>
                <input class="form-control" name="prix" value="<?= htmlspecialchars($destination["prix"]) ?>" type="number" step="0.01" required>
                
                <label for="date_depart">Date de Départ</label>
                <input class="form-control" name="date_depart" value="<?= htmlspecialchars($destination["date_depart"]) ?>" type="date" required>
                
                <label for="date_retour">Date de Retour</label>
                <input class="form-control" name="date_retour" value="<?= htmlspecialchars($destination["date_retour"]) ?>" type="date" required>
                
                <label for="statut">Statut</label>
                <select name="statut" class="form-select" required>
                    <option value="en attente" <?= $destination["statut"] == "en attente" ? 'selected' : '' ?>>En attente</option>
                    <option value="validée" <?= $destination["statut"] == "validée" ? 'selected' : '' ?>>Validée</option>
                    <option value="annulée" <?= $destination["statut"] == "annulée" ? 'selected' : '' ?>>Annulée</option>
                </select>

                <center class="mt-3">   
                    <button type="button" class="btn btn-danger" onclick="window.history.back();">Annuler</button>
                    <button type="submit" class="btn btn-secondary">Enregistrer</button>
                </center>
            </form>
        </div>     
    </div>
</div>

<?php include('../include/footer.php'); ?>
