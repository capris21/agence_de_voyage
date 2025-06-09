<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php
if (isset($_POST["pays"], $_POST["ville"], $_POST["prix"], $_POST["date_depart"], $_POST["date_retour"], $_POST["statut"])) {
    $pays = $_POST["pays"];
    $ville = $_POST["ville"];
    $prix = $_POST["prix"];
    $date_depart = $_POST["date_depart"];
    $date_retour = $_POST["date_retour"];
    $statut = $_POST["statut"];

    $sql = "INSERT INTO destinations(pays, ville, prix, date_depart, date_retour, statut) VALUES (:pays, :ville, :prix, :date_depart, :date_retour, :statut)";
    $statement = $connect->prepare($sql);
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
    <div class="card mt-5" style="margin-left: 10%; margin-right: 15px;">
        <div class="card-header bg-primary">
            <h4 class="text-white">FORMULAIRE D'AJOUT</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <table class="table table-striped">
                    <tr>
                        <td>
                            <label for="pays">Pays</label>
                            <input class="form-control" name="pays" type="text" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ville">Ville</label>
                            <input class="form-control" name="ville" type="text" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="prix">Prix</label>
                            <input class="form-control" name="prix" type="number" step="0.01" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="date_depart">Date de Départ</label>
                            <input class="form-control" name="date_depart" type="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="date_retour">Date de Retour</label>
                            <input class="form-control" name="date_retour" type="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="statut">Statut</label>
                            <select name="statut" class="form-select" required>
                                <option value="">Choisir le statut</option>
                                <option value="en attente">En attente</option>
                                <option value="validée">Validée</option>
                                <option value="annulée">Annulée</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <center class="mt-3">   
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <button type="submit" class="btn btn-secondary">Enregistrer</button>
                </center>
            </form>
        </div>     
    </div>
</div>

<?php include('../include/footer.php'); ?>