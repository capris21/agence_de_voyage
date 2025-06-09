<?php
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");

if (isset($_GET['id'])) {
    $id_reservation = $_GET['id'];

    // Récupérer la réservation à modifier
    $sql = "SELECT * FROM reservations WHERE id = :id"; // Assurez-vous que la table s'appelle 'reservations'
    $statement = $connect->prepare($sql);
    $statement->bindValue(':id', $id_reservation, PDO::PARAM_INT);
    $statement->execute();
    $reservation = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "Réservation non trouvée.";
        exit;
    }

    // Récupérer les clients et les destinations pour le formulaire
    $clients = $connect->query("SELECT * FROM client")->fetchAll(PDO::FETCH_ASSOC);
    $destinations = $connect->query("SELECT * FROM destinations")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mettre à jour la réservation
        $dateReservation = $_POST['dateReservation'];
        $client_id = $_POST['client_id'];
        $destination_id = $_POST['destination_id'];

        $sql = "UPDATE reservations SET date_reservation = :dateReservation, client_id = :client_id, destination_id = :destination_id WHERE id = :id";
        $statement = $connect->prepare($sql);
        $statement->bindValue(':dateReservation', $dateReservation);
        $statement->bindValue(':client_id', $client_id);
        $statement->bindValue(':destination_id', $destination_id);
        $statement->bindValue(':id', $id_reservation, PDO::PARAM_INT);

        if ($statement->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la réservation.";
        }
    }
}
?>

<h2 class="mt-3 text-center">Modifier la Réservation</h2>
<div class="container">
    <form method="POST">
        <div class="mb-3">
            <label for="dateReservation" class="form-label">Date de Réservation</label>
            <input type="date" class="form-control" name="dateReservation" value="<?= htmlspecialchars($reservation['date_reservation']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <select name="client_id" class="form-select" required>
                <?php foreach ($clients as $client) : ?>
                    <option value="<?= htmlspecialchars($client['id']) ?>" <?= $client['id'] == $reservation['client_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($client['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="destination_id" class="form-label">Destination</label>
            <select name="destination_id" class="form-select" required>
                <?php foreach ($destinations as $destination) : ?>
                    <option value="<?= htmlspecialchars($destination['id']) ?>" <?= $destination['id'] == $reservation['destination_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($destination['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<?php include('../include/footer.php'); ?>
