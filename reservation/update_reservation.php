<?php
include("../connexion.php");

// Identifier les réservations expirées
$sql = "SELECT * FROM reservation WHERE date_expiration < NOW() AND statut = 'Active'";
$statement = $connect->prepare($sql);
$statement->execute();
$reservationsExpirées = $statement->fetchAll(PDO::FETCH_OBJ);

// Mettre à jour le statut des réservations expirées
if (!empty($reservationsExpirées)) {
    $updateSql = "UPDATE reservation SET statut = 'Expired' WHERE date_expiration < NOW() AND statut = 'Active'";
    $updateStatement = $connect->prepare($updateSql);
    
    if ($updateStatement->execute()) {
        echo "Le statut des réservations expirées a été mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du statut des réservations.";
    }
} else {
    echo '<div class="alert alert-warning text-center" role="alert">
                         Aucune réservation expirée à mettre à jour.
                       </div>';
}
?>
