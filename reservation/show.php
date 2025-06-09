<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];

    // Récupérer les détails de la réservation
    $sql = "SELECT * FROM reservations WHERE id = :id"; // Assurez-vous que la table s'appelle 'reservations'
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id_reservation, PDO::PARAM_INT);
    $statement->execute();
    $reservation = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "Réservation non trouvée.";
        exit;
    }

    // Récupérer le client et la destination associés
    $sql = "SELECT * FROM clients WHERE id = :id_client"; // Assurez-vous que la table s'appelle 'clients'
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id_client', $reservation['client_id'], PDO::PARAM_INT);
    $statement->execute();
    $client = $statement->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM destinations WHERE id = :id_destination"; // Assurez-vous que la table s'appelle 'destinations'
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id_destination', $reservation['destination_id'], PDO::PARAM_INT);
    $statement->execute();
    $destination = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<h2 class="mt-3 text-center">Détails de la Réservation</h2>
<div class="container">
    <table class="table">
        <tr>
            <th>ID Réservation</th>
            <td><?= htmlspecialchars($reservation['id']) ?></td>
        </tr>
        <tr>
            <th>Date de Réservation</th>
            <td><?= htmlspecialchars($reservation['date_reservation']) ?></td>
        </tr>
        <tr>
            <th>Statut</th>
            <td><?= htmlspecialchars($reservation['statut']) ?></td>
        </tr>
        <tr>
            <th>Client</th>
            <td><?= htmlspecialchars($client['nom']) ?></td>
        </tr>
        <tr>
            <th>Destination</th>
            <td><?= htmlspecialchars($destination['nom']) ?></td>
        </tr>
    </table>
    <a href="index.php" class="btn btn-secondary">Retour</a>
</div>

<?php include('../include/footer.php'); ?>
