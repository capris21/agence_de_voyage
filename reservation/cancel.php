<?php

include("../connexion.php");

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];

    // Mettre à jour le statut à "Annulée"
    $sql = "UPDATE reservation SET statut = 'Annulée' WHERE id_reservation = :id_reservation";
    $statement = $connect->prepare($sql);
    $statement->bindParam(':id_reservation', $id_reservation);

    try {
        $statement->execute();
        echo "Réservation annulée avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de l'annulation de la réservation : " . $e->getMessage();
    }
}
?>
