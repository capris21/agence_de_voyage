<?php
include("../connexion.php");

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];

    // Supprimer la réservation
    $sql = "DELETE FROM reservations WHERE id = :id";
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id_reservation, PDO::PARAM_INT);

    if ($statement->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de la réservation.";
    }
} else {
    echo "ID de réservation non spécifié.";
}
?>
